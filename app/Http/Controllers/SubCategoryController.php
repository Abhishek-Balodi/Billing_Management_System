<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SubcategoryController extends Controller
{
    public function index()
    {
        $currentUserId = $this->getCurrentUserId();
        $subcategories = Subcategory::with(['category', 'user', 'employee'])->where('user_id', $currentUserId)->get();
        $categories = Category::where('user_id', $currentUserId)->get();
        return view('sub-categories', compact('subcategories', 'categories'));
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

            \Log::info('Employee adding subcategory', [
                'employee_id' => $data['employee_id'],
                'user_id' => $data['user_id'],
                'employee_name' => $employee->name,
            ]);
        } else {
            return redirect()->route('subcategories.index')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subcategories,name,NULL,id,user_id,' . $data['user_id'],
            'category_id' => 'required|exists:categories,id,user_id,' . $data['user_id'],
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'status' => 'nullable|boolean',
        ], [
            'name.unique' => 'This sub-category already exists for this user.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category is not valid or does not belong to this user.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a JPEG or PNG.',
            'image.max' => 'The image size must not exceed 2MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('subcategory_images', 'public');
        }

        Subcategory::create([
            'name' => $validated['name'],
            'image' => $imagePath,
            'status' => $request->has('status') ? 1 : 0,
            'category_id' => $validated['category_id'],
            'user_id' => $data['user_id'],
            'employee_id' => $data['employee_id'],
        ]);

        return redirect()->route('subcategories.index')->with('success', 'Sub category created successfully.');
    }

    public function update(Request $request, $id)
    {
        $subcategory = Subcategory::findOrFail($id);

        $currentUserId = $this->getCurrentUserId();
        if ($subcategory->user_id !== $currentUserId) {
            return redirect()->route('subcategories.index')->with('error', 'Unauthorized access to update sub-category.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subcategories,name,' . $id . ',id,user_id,' . $subcategory->user_id,
            'category_id' => 'required|exists:categories,id,user_id,' . $subcategory->user_id,
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'status' => 'nullable|boolean',
        ], [
            'name.unique' => 'This sub-category already exists for this user.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category is not valid or does not belong to this user.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a JPEG or PNG.',
            'image.max' => 'The image size must not exceed 2MB.',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($subcategory->image) {
                Storage::disk('public')->delete($subcategory->image);
            }
            $validated['image'] = $request->file('image')->store('subcategory_images', 'public');
        } else {
            $validated['image'] = $subcategory->image; // Retain existing image
        }

        $subcategory->update([
            'name' => $validated['name'],
            'image' => $validated['image'],
            'status' => $request->has('status') ? 1 : 0,
            'category_id' => $validated['category_id'],
        ]);

        return redirect()->route('subcategories.index')->with('success', 'Sub category updated successfully.');
    }

    public function destroy($id)
    {
        $subcategory = Subcategory::findOrFail($id);

        $currentUserId = $this->getCurrentUserId();
        if ($subcategory->user_id !== $currentUserId) {
            return redirect()->route('subcategories.index')->with('error', 'Unauthorized access to delete sub-category.');
        }

        if ($subcategory->image) {
            Storage::disk('public')->delete($subcategory->image);
        }
        $subcategory->delete();

        return redirect()->route('subcategories.index')->with('success', 'Sub category deleted successfully.');
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