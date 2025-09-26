<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with(['user', 'employee'])->get();
        return view('brands-list', compact('brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'status' => 'nullable|boolean',
        ], [
            'name.unique' => 'This brand already exists.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a JPEG or PNG.',
            'image.max' => 'The image size must not exceed 2MB.',
        ]);

        $userId = null;
        $employeeId = null;

        if (auth()->guard('employee')->check()) {
            $employeeId = auth()->guard('employee')->id();
            $employee = Employee::find($employeeId);
            $userId = $employee ? $employee->user_id : null;
        } elseif (auth()->check()) {
            $userId = auth()->id();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brand_images', 'public');
        }

        Brand::create([
            'name' => $validated['name'],
            'image' => $imagePath,
            'status' => $request->has('status') ? 1 : 0,
            'user_id' => $userId,
            'employee_id' => $employeeId,
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'status' => 'nullable|boolean',
        ], [
            'name.unique' => 'This brand already exists.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a JPEG or PNG.',
            'image.max' => 'The image size must not exceed 2MB.',
        ]);

        $brand = Brand::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }
            $validated['image'] = $request->file('image')->store('brand_images', 'public');
        } else {
            $validated['image'] = $brand->image; // Retain existing image
        }

        $brand->update([
            'name' => $validated['name'],
            'image' => $validated['image'],
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }
        $brand->delete();

        return redirect()->route('brands.index')->with('danger', 'Brand deleted successfully.');
    }
}