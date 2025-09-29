<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Store;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        $currentUserId = $this->getCurrentUserId();
        $products = Product::with(['category', 'subcategory', 'brand', 'user', 'employee', 'store', 'warehouse'])
                          ->where('user_id', $currentUserId)
                          ->get();
        $categories = Category::where('user_id', $currentUserId)->get();
        $brands = Brand::where('user_id', $currentUserId)->get();
        return view('product-list', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $currentUserId = $this->getCurrentUserId();
        $categories = Category::where('user_id', $currentUserId)->get();
        $subcategories = Subcategory::where('user_id', $currentUserId)->get();
        $brands = Brand::where('user_id', $currentUserId)->get();
        $stores = Store::where('user_id', $currentUserId)->get();
        $warehouses = Warehouse::where('user_id', $currentUserId)->get();
        return view('add-product', compact('categories', 'subcategories', 'brands', 'stores', 'warehouses'));
    }

    public function store(Request $request)
    {
        \Log::info('Submitted form data', $request->all());
        \Log::info('Submitted barcode_symbology', ['value' => $request->barcode_symbology]);
        \Log::info('Image uploaded', ['hasFile' => $request->hasFile('image')]);

        // Preprocess barcode_symbology to handle case and spaces
        $request->merge([
            'barcode_symbology' => $request->barcode_symbology ? strtolower(str_replace(' ', '', $request->barcode_symbology)) : null,
        ]);

        \Log::info('Processed barcode_symbology', ['value' => $request->barcode_symbology]);

        $data = [];
        if (Auth::guard('web')->check()) {
            $data['user_id'] = Auth::guard('web')->id();
            $data['employee_id'] = null;
        } elseif (Auth::guard('employee')->check()) {
            $employee = Auth::guard('employee')->user();
            $data['employee_id'] = $employee->id;
            $data['user_id'] = $employee->user_id;
        } else {
            return redirect()->route('products.index')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,NULL,id,user_id,' . $data['user_id'],
            'category_id' => 'required|exists:categories,id,user_id,' . $data['user_id'],
            'subcategory_id' => 'required|exists:subcategories,id,user_id,' . $data['user_id'],
            'brand_id' => 'required|exists:brands,id,user_id,' . $data['user_id'],
            'description' => 'nullable|string',
            'hsn_sac_code' => 'nullable|string|max:255',
            'unit_of_measure' => 'required|in:kg,liter,piece,meter,dozen,gram,ml',
            'unit_price' => 'required|numeric|min:0',
            'tax_type' => 'required|in:inclusive,exclusive',
            'tax_category' => 'required|in:gst,sgst,cgst,igst',
            'tax_percentage' => 'required|in:0,5,18,40',
            'quantity' => 'required|numeric|min:0',
            'quantity_alert' => 'nullable|numeric|min:0',
            'barcode' => 'nullable|string|max:255',
            'barcode_symbology' => 'nullable|in:code128,code39,upc,ean13',
            'selling_type' => 'required|in:online,cash',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'store_id' => 'nullable|exists:stores,id,user_id,' . $data['user_id'],
            'warehouse_id' => 'nullable|exists:warehouses,id,user_id,' . $data['user_id'],
            'discount_type' => 'nullable|in:percentage,fixed',
            'discount_value' => 'nullable|numeric|min:0',
            'warranties' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'manufactured_date' => 'nullable|date|date_format:d-m-Y',
            'expiry_date' => 'nullable|date|date_format:d-m-Y|after_or_equal:manufactured_date',
        ], [
            'name.unique' => 'This product name already exists for this user.',
            'category_id.exists' => 'The selected category is invalid or does not belong to this user.',
            'subcategory_id.exists' => 'The selected subcategory is invalid or does not belong to this user.',
            'brand_id.exists' => 'The selected brand is invalid or does not belong to this user.',
            'store_id.exists' => 'The selected store is invalid or does not belong to this user.',
            'warehouse_id.exists' => 'The selected warehouse is invalid or does not belong to this user.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a JPEG, PNG, JPG, or GIF.',
            'image.max' => 'The image size must not exceed 2MB.',
            'barcode_symbology.in' => 'The selected barcode symbology is invalid.',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            \Log::info('Image stored', ['path' => $imagePath]);
        }

        // Convert dates to Y-m-d format for storage
        if ($request->filled('manufactured_date')) {
            $validated['manufactured_date'] = Carbon::createFromFormat('d-m-Y', $request->manufactured_date)->format('Y-m-d');
        }

        if ($request->filled('expiry_date')) {
            $validated['expiry_date'] = Carbon::createFromFormat('d-m-Y', $request->expiry_date)->format('Y-m-d');
        }

        Product::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'],
            'brand_id' => $validated['brand_id'],
            'description' => $validated['description'],
            'hsn_sac_code' => $validated['hsn_sac_code'],
            'unit_of_measure' => $validated['unit_of_measure'],
            'unit_price' => $validated['unit_price'],
            'tax_type' => $validated['tax_type'],
            'tax_category' => $validated['tax_category'],
            'tax_percentage' => $validated['tax_percentage'],
            'quantity' => $validated['quantity'],
            'quantity_alert' => $validated['quantity_alert'],
            'barcode' => $validated['barcode'],
            'barcode_symbology' => $validated['barcode_symbology'],
            'selling_type' => $validated['selling_type'],
            'image' => $imagePath,
            'store_id' => $validated['store_id'],
            'warehouse_id' => $validated['warehouse_id'],
            'discount_type' => $validated['discount_type'],
            'discount_value' => $validated['discount_value'],
            'warranties' => $validated['warranties'],
            'manufacturer' => $validated['manufacturer'],
            'manufactured_date' => $validated['manufactured_date'],
            'expiry_date' => $validated['expiry_date'],
            'user_id' => $data['user_id'],
            'employee_id' => $data['employee_id'],
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $currentUserId = $this->getCurrentUserId();
        $product = Product::with(['category', 'subcategory', 'brand', 'user', 'employee', 'store', 'warehouse'])
                         ->where('user_id', $currentUserId)
                         ->findOrFail($id);
        return view('product-details', compact('product'));
    }

    public function edit($id)
    {
        $currentUserId = $this->getCurrentUserId();
        $product = Product::where('user_id', $currentUserId)->findOrFail($id);
        $categories = Category::where('user_id', $currentUserId)->get();
        $subcategories = Subcategory::where('user_id', $currentUserId)->get();
        $brands = Brand::where('user_id', $currentUserId)->get();
        $stores = Store::where('user_id', $currentUserId)->get();
        $warehouses = Warehouse::where('user_id', $currentUserId)->get();
        return view('edit-product', compact('product', 'categories', 'subcategories', 'brands', 'stores', 'warehouses'));
    }

    public function update(Request $request, $id)
    {
        $currentUserId = $this->getCurrentUserId();
        $product = Product::where('user_id', $currentUserId)->findOrFail($id);

        \Log::info('Submitted form data for update', $request->all());
        \Log::info('Submitted barcode_symbology for update', ['value' => $request->barcode_symbology]);
        \Log::info('Image uploaded for update', ['hasFile' => $request->hasFile('image')]);

        // Preprocess barcode_symbology to handle case and spaces
        $request->merge([
            'barcode_symbology' => $request->barcode_symbology ? strtolower(str_replace(' ', '', $request->barcode_symbology)) : null,
        ]);

        \Log::info('Processed barcode_symbology for update', ['value' => $request->barcode_symbology]);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $id . ',id,user_id,' . $currentUserId,
            'category_id' => 'required|exists:categories,id,user_id,' . $currentUserId,
            'subcategory_id' => 'required|exists:subcategories,id,user_id,' . $currentUserId,
            'brand_id' => 'required|exists:brands,id,user_id,' . $currentUserId,
            'description' => 'nullable|string',
            'hsn_sac_code' => 'nullable|string|max:255',
            'unit_of_measure' => 'required|in:kg,liter,piece,meter,dozen,gram,ml',
            'unit_price' => 'required|numeric|min:0',
            'tax_type' => 'required|in:inclusive,exclusive',
            'tax_category' => 'required|in:gst,sgst,cgst,igst',
            'tax_percentage' => 'required|in:0,5,18,40',
            'quantity' => 'required|numeric|min:0',
            'quantity_alert' => 'nullable|numeric|min:0',
            'barcode' => 'nullable|string|max:255',
            'barcode_symbology' => 'nullable|in:code128,code39,upc,ean13',
            'selling_type' => 'required|in:online,cash',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'store_id' => 'nullable|exists:stores,id,user_id,' . $currentUserId,
            'warehouse_id' => 'nullable|exists:warehouses,id,user_id,' . $currentUserId,
            'discount_type' => 'nullable|in:percentage,fixed',
            'discount_value' => 'nullable|numeric|min:0',
            'warranties' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'manufactured_date' => 'nullable|date|date_format:d-m-Y',
            'expiry_date' => 'nullable|date|date_format:d-m-Y|after_or_equal:manufactured_date',
        ], [
            'name.unique' => 'This product name already exists for this user.',
            'category_id.exists' => 'The selected category is invalid or does not belong to this user.',
            'subcategory_id.exists' => 'The selected subcategory is invalid or does not belong to this user.',
            'brand_id.exists' => 'The selected brand is invalid or does not belong to this user.',
            'store_id.exists' => 'The selected store is invalid or does not belong to this user.',
            'warehouse_id.exists' => 'The selected warehouse is invalid or does not belong to this user.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a JPEG, PNG, JPG, or GIF.',
            'image.max' => 'The image size must not exceed 2MB.',
            'barcode_symbology.in' => 'The selected barcode symbology is invalid.',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
            \Log::info('Image stored for update', ['path' => $validated['image']]);
        } else {
            $validated['image'] = $product->image; // Retain existing image
        }

        // Convert dates to Y-m-d format for storage
        if ($request->filled('manufactured_date')) {
            $validated['manufactured_date'] = Carbon::createFromFormat('d-m-Y', $request->manufactured_date)->format('Y-m-d');
        }

        if ($request->filled('expiry_date')) {
            $validated['expiry_date'] = Carbon::createFromFormat('d-m-Y', $request->expiry_date)->format('Y-m-d');
        }

        $product->update([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'],
            'brand_id' => $validated['brand_id'],
            'description' => $validated['description'],
            'hsn_sac_code' => $validated['hsn_sac_code'],
            'unit_of_measure' => $validated['unit_of_measure'],
            'unit_price' => $validated['unit_price'],
            'tax_type' => $validated['tax_type'],
            'tax_category' => $validated['tax_category'],
            'tax_percentage' => $validated['tax_percentage'],
            'quantity' => $validated['quantity'],
            'quantity_alert' => $validated['quantity_alert'],
            'barcode' => $validated['barcode'],
            'barcode_symbology' => $validated['barcode_symbology'],
            'selling_type' => $validated['selling_type'],
            'image' => $validated['image'],
            'store_id' => $validated['store_id'],
            'warehouse_id' => $validated['warehouse_id'],
            'discount_type' => $validated['discount_type'],
            'discount_value' => $validated['discount_value'],
            'warranties' => $validated['warranties'],
            'manufacturer' => $validated['manufacturer'],
            'manufactured_date' => $validated['manufactured_date'],
            'expiry_date' => $validated['expiry_date'],
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $currentUserId = $this->getCurrentUserId();
        $product = Product::where('user_id', $currentUserId)->findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('products.index')->with('danger', 'Product deleted successfully.');
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