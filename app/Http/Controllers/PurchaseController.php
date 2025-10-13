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
        return view('purchases.create', compact('suppliers', 'products'));
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
            return redirect()->route('purchases.create')->with('error', 'Unauthorized access.');
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
            'discount_amount' => 'nullable|numeric|default:0',
            'tax_amount' => 'nullable|numeric|default:0',
            'grand_total' => 'required|numeric',
            'remarks' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.hsn_code' => 'required|string|max:50',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unit' => 'required|string|max:50',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_percent' => 'nullable|numeric|min:0|max:100',
            'items.*.igst_percent' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_amount' => 'nullable|numeric|min:0',
            'items.*.total_amount' => 'required|numeric|min:0',
            'items.*.expiry_date' => 'nullable|date',
        ]);

        $purchase = PurchaseDetail::create([
            'invoice_no' => $validated['invoice_no'],
            'invoice_date' => $validated['invoice_date'],
            'supplier_id' => $validated['supplier_id'],
            'user_id' => $data['user_id'],
            'employee_id' => $data['employee_id'],
            'status' => 'pending',
            'purchase_type' => $validated['purchase_type'],
            'challan_no' => $validated['challan_no'],
            'challan_date' => $validated['challan_date'],
            'lr_no' => $validated['lr_no'],
            'entry_date' => $validated['entry_date'],
            'delivery_mode' => $validated['delivery_mode'],
            'total_amount' => $validated['total_amount'],
            'discount_amount' => $validated['discount_amount'] ?? 0,
            'tax_amount' => $validated['tax_amount'] ?? 0,
            'grand_total' => $validated['grand_total'],
            'remarks' => $validated['remarks'],
            'created_by' => $data['user_id'],
        ]);

        foreach ($validated['items'] as $item) {
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item['product_id'],
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
                'expiry_date' => $item['expiry_date'],
            ]);
        }

        return redirect()->route('purchases.create')->with('success', 'Purchase created successfully.');
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
