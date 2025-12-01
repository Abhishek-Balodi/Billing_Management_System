<?php

namespace App\Http\Controllers;

use App\Models\PurchaseDetail;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $currentUserId = $this->getCurrentUserId();
        
        $purchases = PurchaseDetail::with(['supplier', 'items', 'employee'])
            ->where('user_id', $currentUserId)
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Yahan paginate use karein

        return view('purchase-list', compact('purchases'));
    }

    public function showDetails($id)
    {
        $currentUserId = $this->getCurrentUserId();
        
        $purchase = PurchaseDetail::with(['supplier', 'items', 'employee'])
            ->where('id', $id)
            ->where('user_id', $currentUserId)
            ->firstOrFail();

        return view('purchase-details', compact('purchase'));
    }

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
        \Log::info('Form Data Received:', $request->all());

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

        try {
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
                'actual_total' => 'required|numeric',
                'round_off_amount' => 'required|numeric',
                'remarks' => 'nullable|string',
                'reverse_charge' => 'boolean',
                'shipping_address' => 'required|string|max:255',
                'place_of_supply' => 'required|string|max:255',
                'round_off' => 'boolean',
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'nullable|exists:products,id',
                'items.*.barcode' => 'nullable|string|max:255',
                'items.*.hsn_code' => 'required|string|max:50',
                'items.*.qty' => 'required|integer|min:1',
                'items.*.unit' => 'required|string|max:50',
                'items.*.price' => 'required|numeric|min:0',
                'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
                'items.*.discount_rs' => 'nullable|numeric|min:0',
                'items.*.gst_percent' => 'nullable|numeric|min:0|max:100',
                'items.*.gst_amount' => 'nullable|numeric|min:0',
                'items.*.igst_percent' => 'nullable|numeric|min:0|max:100',
                'items.*.igst_amount' => 'nullable|numeric|min:0',
                'items.*.cess_percent' => 'nullable|numeric|min:0|max:100',
                'items.*.cess_rs' => 'nullable|numeric|min:0',
                'items.*.total_amount' => 'required|numeric|min:0',
                'items.*.expiry_date' => 'nullable|date',
            ]);

            // Calculate totals from items for verification
            $total_taxable = 0;
            $total_discount = 0;
            $total_tax = 0;
            $grand_total = 0;
            $actual_total = 0;

            $itemsData = [];
            foreach ($validated['items'] as $index => $item) {
                $product = Product::find($item['product_id']);
                $subtotal = $item['qty'] * $item['price'];
                $discount_percent = $item['discount_percent'] ?? 0;
                $discount_rs = $item['discount_rs'] ?? 0;
                $discount_total = ($subtotal * $discount_percent / 100) + $discount_rs;
                $taxable = $subtotal - $discount_total;
                $gst_amount = $item['gst_amount'] ?? 0;
                $igst_amount = $item['igst_amount'] ?? 0;
                $cess_percent = $item['cess_percent'] ?? 0;
                $cess_rs = $item['cess_rs'] ?? 0;
                $cess_amount = ($taxable * $cess_percent / 100) + $cess_rs;
                $tax_amount = $gst_amount + $igst_amount + $cess_amount;

                $item_total = $taxable + $tax_amount;

                $itemsData[] = [
                    'purchase_id' => null,
                    'product_id' => $item['product_id'] ?? null,
                    'barcode' => $item['barcode'] ?? null,
                    'product_name' => $product ? $product->name : $item['hsn_code'],
                    'hsn_code' => $item['hsn_code'],
                    'qty' => $item['qty'],
                    'unit' => $item['unit'],
                    'price' => $item['price'],
                    'user_id' => $data['user_id'],
                    'employee_id' => $data['employee_id'],
                    'discount_percent' => $discount_percent,
                    'discount_rs' => $discount_rs,
                    'gst_percent' => $item['gst_percent'] ?? 0,
                    'igst_percent' => $item['igst_percent'] ?? 0,
                    'cess_percent' => $cess_percent,
                    'cess_rs' => $cess_rs,
                    'tax_amount' => $tax_amount,
                    'total_amount' => $item_total,
                    'expiry_date' => $item['expiry_date'] ?? null,
                ];

                $total_taxable += $taxable;
                $total_discount += $discount_total;
                $total_tax += $tax_amount;
                $grand_total += $item_total;
                $actual_total += $item_total;
            }

            // Apply round-off if intended
            $round_off = $validated['round_off'] ?? false;
            $round_off_amount = $validated['round_off_amount'] ?? 0;
            
            if ($round_off) {
                $grand_total = $actual_total + $round_off_amount;
            } else {
                $grand_total = $actual_total;
                $round_off_amount = 0;
            }

            // Use transaction to ensure data integrity
            DB::beginTransaction();
            try {
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
                    'total_amount' => $total_taxable,
                    'discount_amount' => $total_discount,
                    'tax_amount' => $total_tax,
                    'grand_total' => $grand_total,
                    'actual_total' => $actual_total,
                    'round_off_amount' => $round_off_amount,
                    'remarks' => $validated['remarks'] ?? null,
                    'created_by' => $data['user_id'],
                    'reverse_charge' => $validated['reverse_charge'] ?? false,
                    'shipping_address' => $validated['shipping_address'],
                    'place_of_supply' => $validated['place_of_supply'],
                ]);

                foreach ($itemsData as &$item) {
                    $item['purchase_id'] = $purchase->id;
                    PurchaseItem::create($item);
                }

                DB::commit();
                \Log::info('Purchase Saved Successfully:', [
                    'purchase_id' => $purchase->id,
                    'actual_total' => $actual_total,
                    'round_off_amount' => $round_off_amount,
                    'grand_total' => $grand_total
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Purchase Save Failed:', ['error' => $e->getMessage()]);
                return redirect()->route('purchases.create')->with('error', 'Failed to save purchase: ' . $e->getMessage());
            }

            return redirect()->route('purchases.create')->with('success', 'Purchase created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Failed:', ['errors' => $e->errors()]);
            return redirect()->route('purchases.create')->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Unexpected Error:', ['error' => $e->getMessage()]);
            return redirect()->route('purchases.create')->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

        public function edit($id)
    {
        $currentUserId = $this->getCurrentUserId();
        
        $purchase = PurchaseDetail::with(['supplier', 'items.product'])
            ->where('id', $id)
            ->where('user_id', $currentUserId)
            ->firstOrFail();

        $suppliers = Supplier::where('user_id', $currentUserId)->get();
        $products = Product::where('user_id', $currentUserId)->get();

        return view('purchase-edit', compact('purchase', 'suppliers', 'products'));
    }

    public function update(Request $request, $id)
    {
        \Log::info('Purchase Update Data:', $request->all());

        $currentUserId = $this->getCurrentUserId();
        
        // Check if purchase exists and belongs to user
        $purchase = PurchaseDetail::where('id', $id)
            ->where('user_id', $currentUserId)
            ->firstOrFail();

        try {
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
                'status' => 'required|in:pending,completed,cancelled',
                'total_amount' => 'required|numeric',
                'discount_amount' => 'nullable|numeric',
                'tax_amount' => 'nullable|numeric',
                'grand_total' => 'required|numeric',
                'actual_total' => 'required|numeric',
                'round_off_amount' => 'required|numeric',
                'remarks' => 'nullable|string',
                'reverse_charge' => 'boolean',
                'shipping_address' => 'required|string|max:255',
                'place_of_supply' => 'required|string|max:255',
                'round_off' => 'boolean',
                'items' => 'required|array|min:1',
                'items.*.id' => 'nullable|exists:purchase_items,id',
                'items.*.product_id' => 'nullable|exists:products,id',
                'items.*.barcode' => 'nullable|string|max:255',
                'items.*.hsn_code' => 'required|string|max:50',
                'items.*.qty' => 'required|integer|min:1',
                'items.*.unit' => 'required|string|max:50',
                'items.*.price' => 'required|numeric|min:0',
                'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
                'items.*.discount_rs' => 'nullable|numeric|min:0',
                'items.*.gst_percent' => 'nullable|numeric|min:0|max:100',
                'items.*.gst_amount' => 'nullable|numeric|min:0',
                'items.*.igst_percent' => 'nullable|numeric|min:0|max:100',
                'items.*.igst_amount' => 'nullable|numeric|min:0',
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
            $actual_total = 0;

            $itemsData = [];
            foreach ($validated['items'] as $index => $item) {
                $product = Product::find($item['product_id']);
                $subtotal = $item['qty'] * $item['price'];
                $discount_percent = $item['discount_percent'] ?? 0;
                $discount_rs = $item['discount_rs'] ?? 0;
                $discount_total = ($subtotal * $discount_percent / 100) + $discount_rs;
                $taxable = $subtotal - $discount_total;
                $gst_amount = $item['gst_amount'] ?? 0;
                $igst_amount = $item['igst_amount'] ?? 0;
                $cess_percent = $item['cess_percent'] ?? 0;
                $cess_rs = $item['cess_rs'] ?? 0;
                $cess_amount = ($taxable * $cess_percent / 100) + $cess_rs;
                $tax_amount = $gst_amount + $igst_amount + $cess_amount;

                $item_total = $taxable + $tax_amount;

                $itemsData[] = [
                    'id' => $item['id'] ?? null,
                    'product_id' => $item['product_id'] ?? null,
                    'barcode' => $item['barcode'] ?? null,
                    'product_name' => $product ? $product->name : $item['hsn_code'],
                    'hsn_code' => $item['hsn_code'],
                    'qty' => $item['qty'],
                    'unit' => $item['unit'],
                    'price' => $item['price'],
                    'user_id' => $currentUserId,
                    'employee_id' => $purchase->employee_id,
                    'discount_percent' => $discount_percent,
                    'discount_rs' => $discount_rs,
                    'gst_percent' => $item['gst_percent'] ?? 0,
                    'igst_percent' => $item['igst_percent'] ?? 0,
                    'cess_percent' => $cess_percent,
                    'cess_rs' => $cess_rs,
                    'tax_amount' => $tax_amount,
                    'total_amount' => $item_total,
                    'expiry_date' => $item['expiry_date'] ?? null,
                ];

                $total_taxable += $taxable;
                $total_discount += $discount_total;
                $total_tax += $tax_amount;
                $grand_total += $item_total;
                $actual_total += $item_total;
            }

            // Apply round-off if intended
            $round_off = $validated['round_off'] ?? false;
            $round_off_amount = $validated['round_off_amount'] ?? 0;
            
            if ($round_off) {
                $grand_total = $actual_total + $round_off_amount;
            } else {
                $grand_total = $actual_total;
                $round_off_amount = 0;
            }

            // Use transaction to ensure data integrity
            DB::beginTransaction();
            try {
                // Update purchase details
                $purchase->update([
                    'invoice_no' => $validated['invoice_no'],
                    'invoice_date' => $validated['invoice_date'],
                    'supplier_id' => $validated['supplier_id'],
                    'status' => $validated['status'],
                    'purchase_type' => $validated['purchase_type'],
                    'challan_no' => $validated['challan_no'] ?? null,
                    'challan_date' => $validated['challan_date'] ?? null,
                    'lr_no' => $validated['lr_no'] ?? null,
                    'entry_date' => $validated['entry_date'] ?? null,
                    'delivery_mode' => $validated['delivery_mode'] ?? null,
                    'total_amount' => $total_taxable,
                    'discount_amount' => $total_discount,
                    'tax_amount' => $total_tax,
                    'grand_total' => $grand_total,
                    'actual_total' => $actual_total,
                    'round_off_amount' => $round_off_amount,
                    'remarks' => $validated['remarks'] ?? null,
                    'reverse_charge' => $validated['reverse_charge'] ?? false,
                    'shipping_address' => $validated['shipping_address'],
                    'place_of_supply' => $validated['place_of_supply'],
                ]);

                // Update or create items
                foreach ($itemsData as $itemData) {
                    if ($itemData['id']) {
                        // Update existing item
                        $purchaseItem = PurchaseItem::find($itemData['id']);
                        if ($purchaseItem && $purchaseItem->purchase_id == $purchase->id) {
                            $purchaseItem->update($itemData);
                        }
                    } else {
                        // Create new item
                        $itemData['purchase_id'] = $purchase->id;
                        PurchaseItem::create($itemData);
                    }
                }

                // Delete items that were removed
                $currentItemIds = collect($itemsData)->pluck('id')->filter()->toArray();
                PurchaseItem::where('purchase_id', $purchase->id)
                    ->whereNotIn('id', $currentItemIds)
                    ->delete();

                DB::commit();
                \Log::info('Purchase Updated Successfully:', [
                    'purchase_id' => $purchase->id,
                    'actual_total' => $actual_total,
                    'round_off_amount' => $round_off_amount,
                    'grand_total' => $grand_total
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Purchase Update Failed:', ['error' => $e->getMessage()]);
                return redirect()->route('purchases.edit', $id)->with('error', 'Failed to update purchase: ' . $e->getMessage());
            }

            return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Failed:', ['errors' => $e->errors()]);
            return redirect()->route('purchases.edit', $id)->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Unexpected Error:', ['error' => $e->getMessage()]);
            return redirect()->route('purchases.edit', $id)->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $currentUserId = $this->getCurrentUserId();
        
        try {
            $purchase = PurchaseDetail::where('id', $id)
                ->where('user_id', $currentUserId)
                ->firstOrFail();

            // Delete related items first
            PurchaseItem::where('purchase_id', $id)->delete();
            
            // Delete the purchase
            $purchase->delete();

            return redirect()->route('purchases.index')
                ->with('success', 'Purchase deleted successfully.');

        } catch (\Exception $e) {
            \Log::error('Purchase Delete Failed:', ['error' => $e->getMessage()]);
            
            return redirect()->route('purchases.index')
                ->with('error', 'Failed to delete purchase.');
        }
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