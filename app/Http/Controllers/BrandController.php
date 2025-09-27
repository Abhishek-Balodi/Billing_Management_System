<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    public function index()
    {
        $currentUserId = $this->getCurrentUserId();
        $brands = Brand::with(['user', 'employee'])->where('user_id', $currentUserId)->get();
        return view('brands-list', compact('brands'));
    }

    public function store(Request $request)
    {
        $data = [];
        if (Auth::guard('web')->check()) {
            // Admin
            $data['user_id'] = Auth::guard('web')->id();
            $data['employee_id'] = null;
        } elseif (Auth::guard('employee')->check()) {
            // Employee
            $employee = Auth::guard('employee')->user();
            $data['employee_id'] = $employee->id;
            $data['user_id'] = $employee->user_id; // assuming employee model me ye column hai

            \Log::info('Employee adding brand', [
                'employee_id' => $data['employee_id'],
                'user_id' => $data['user_id'],
                'employee_name' => $employee->name,
            ]);
        } else {
            return redirect()->route('brands.index')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,NULL,id,user_id,' . $data['user_id'],
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'status' => 'nullable|boolean',
        ], [
            'name.unique' => 'This brand already exists for this user.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a JPEG or PNG.',
            'image.max' => 'The image size must not exceed 2MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brand_images', 'public');
        }

        Brand::create([
            'name' => $validated['name'],
            'image' => $imagePath,
            'status' => $request->has('status') ? 1 : 0,
            'user_id' => $data['user_id'],
            'employee_id' => $data['employee_id'],
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $currentUserId = $this->getCurrentUserId();
        if ($brand->user_id !== $currentUserId) {
            return redirect()->route('brands.index')->with('error', 'Unauthorized access to update brand.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $id . ',id,user_id,' . $brand->user_id,
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'status' => 'nullable|boolean',
        ], [
            'name.unique' => 'This brand already exists for this user.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a JPEG or PNG.',
            'image.max' => 'The image size must not exceed 2MB.',
        ]);

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

        $currentUserId = $this->getCurrentUserId();
        if ($brand->user_id !== $currentUserId) {
            return redirect()->route('brands.index')->with('error', 'Unauthorized access to delete brand.');
        }

        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }
        $brand->delete();

        return redirect()->route('brands.index')->with('danger', 'Brand deleted successfully.');
    }

    protected function getCurrentUserId()
    {
        if (Auth::guard('web')->check()) {
            return Auth::guard('web')->id();
        } elseif (Auth::guard('employee')->check()) {
            return Auth::guard('employee')->user()->user_id; // assuming employee model me user_id column hai
        }

        return null;
    }
}