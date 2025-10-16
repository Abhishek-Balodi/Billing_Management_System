<?php

namespace App\Http\Controllers;

use App\Models\PurchaseDetail;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    public function create()
    {
        $currentUserId = $this->getCurrentUserId();
        $suppliers = Supplier::where('user_id', $currentUserId)->get();
        $products = Product::where('user_id', $currentUserId)->get();
        return view('purchase', compact('suppliers', 'products'));
    }

    public function getSupplierData($id)
    {
        $currentUserId = $this->getCurrentUserId();
        $supplier = Supplier::where('id', $id)
                        ->where('user_id', $currentUserId)
                        ->first();

        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found or unauthorized'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $supplier->id,
                'first_name' => $supplier->first_name,
                'last_name' => $supplier->last_name,
                'address' => $supplier->address,
                'city' => $supplier->city,
                'state' => $supplier->state,
                'country' => $supplier->country,
                'postal_code' => $supplier->postal_code,
                'phone' => $supplier->phone,
                'gstin' => $supplier->gstin,
                'pan' => $supplier->pan,
                'company_name' => $supplier->company_name,
                'email' => $supplier->email,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $data = [];
        if (Auth::guard('web')->check()) {
            $data['user_id'] = Auth::guard('web')->id();
            $data['employee_id'] = null;
        } elseif (Auth::guard('employee')->check()) {
            $employee = Auth::guard('employee')->user();
            $data['employee_id'] = $employee->id;
            $data['user_id'] = $employee->user_id;

            Log::info('Employee creating purchase', [
                'employee_id' => $data['employee_id'],
                'user_id' => $data['user_id'],
                'employee_name' => $employee->name,
            ]);
        } else {
            return redirect()->route('purchase')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_type' => 'required|in:Regular,Bill of Supply,Export',
            'invoice_no' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'challan_no' => 'nullable|string|max:255',
            'challan_date' => 'nullable|date',
            'lr_no' => 'nullable|string|max:255',
            'entry_date' => 'nullable|date',
            'delivery_mode' => 'nullable|in:Transport,Direct Delivery,Courier,Self',
            'total_amount' => 'required|numeric',
            'discount_amount' => 'nullable|numeric',
            'tax_amount' => 'nullable|numeric',
            'grand_total' => 'required|numeric',
            'remarks' => 'nullable|string',
            'reverse_charge' => 'boolean',
            'shipping_address' => 'required|string|max:255',
            'place_of_supply' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.hsn_code' => 'required|string|max:50',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unit' => 'required|string|max:50',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0|max:100',
            'items.*.discount_rs' => 'nullable|numeric|min:0',
            'items.*.tax_percent' => 'nullable|numeric|min:0|max:100',
            'items.*.igst_percent' => 'nullable|numeric|min:0|max:100',
            'items.*.cess_percent' => 'nullable|numeric|min:0|max:100',
            'items.*.cess_rs' => 'nullable|numeric|min:0',
            'items.*.total_amount' => 'required|numeric|min:0',
            'items.*.expiry_date' => 'nullable|date',
        ]);

        // Calculate totals from items
        $total_taxable = 0;
        $total_discount = 0;
        $total_tax = 0;
        $grand_total = 0;

        foreach ($validated['items'] as $item) {
            $subtotal = $item['qty'] * $item['price'];
            $discount = ($item['discount'] ?? 0) + ($item['discount_rs'] ?? 0);
            $taxable = $subtotal - $discount;
            $tax_amount = $taxable * (($item['tax_percent'] ?? 0) / 100) + 
                         $taxable * (($item['igst_percent'] ?? 0) / 100) + 
                         $taxable * (($item['cess_percent'] ?? 0) / 100) + 
                        ($item['cess_rs'] ?? 0);
            
            $total_taxable += $taxable;
            $total_discount += $discount;
            $total_tax += $tax_amount;
            $grand_total += $taxable + $tax_amount;
        }

        $purchase = PurchaseDetail::create([
            'invoice_no' => $validated['invoice_no'],
            'invoice_date' => $validated['invoice_date'],
            'supplier_id' => $validated['supplier_id'],
            'user_id' => $data['user_id'],
            'employee_id' => $data['employee_id'],
            'status' => 'pending',
            'purchase_type' => $validated['purchase_type'],
            'challan_no' => $validated['challan_no'] ?? null,
            'challan_date' => $validated['challan_date'] ?? null,
            'lr_no' => $validated['lr_no'] ?? null,
            'entry_date' => $validated['entry_date'] ?? null,
            'delivery_mode' => $validated['delivery_mode'] ?? null,
            'total_amount' => $total_taxable, // Total without tax
            'discount_amount' => $total_discount,
            'tax_amount' => $total_tax,
            'grand_total' => $grand_total,
            'remarks' => $validated['remarks'] ?? null,
            'created_by' => $data['user_id'],
            'reverse_charge' => $validated['reverse_charge'] ?? false,
            'shipping_address' => $validated['shipping_address'],
            'place_of_supply' => $validated['place_of_supply'],
        ]);

        foreach ($validated['items'] as $item) {
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item['product_id'] ?? null,
                'product_name' => $item['product_name'],
                'hsn_code' => $item['hsn_code'],
                'qty' => $item['qty'],
                'unit' => $item['unit'],
                'price' => $item['price'],
                'user_id' => $data['user_id'],
                'employee_id' => $data['employee_id'],
                'discount' => $item['discount'] ?? 0,
                'tax_percent' => $item['tax_percent'] ?? 0,
                'igst_percent' => $item['igst_percent'] ?? 0,
                'tax_amount' => $item['tax_amount'] ?? 0,
                'total_amount' => $item['total_amount'],
                'expiry_date' => $item['expiry_date'] ?? null,
                'cess_percent' => $item['cess_percent'] ?? 0,
                'cess_rs' => $item['cess_rs'] ?? 0,
            ]);
        }

        return redirect()->route('purchase')->with('success', 'Purchase created successfully.');
    }

    protected function getCurrentUserId()
    {
        if (Auth::guard('web')->check()) {
            return Auth::guard('web')->id();
        } elseif (Auth::guard('employee')->check()) {
            return Auth::guard('employee')->user()->user_id;
        }

        return null;
    }
}