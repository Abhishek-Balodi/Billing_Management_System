<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        $currentUserId = $this->getCurrentUserId();
        $categories = Category::with(['user', 'employee'])->where('user_id', $currentUserId)->get();
        return view('category-list', compact('categories'));
    }

    public function productpage_store(Request $request)
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
            $data['user_id'] = $employee->user_id;

            \Log::info('Employee adding category', [
                'employee_id' => $data['employee_id'],
                'user_id' => $data['user_id'],
                'employee_name' => $employee->name,
            ]);
        } else {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,NULL,id,user_id,' . $data['user_id'],
            'status' => 'nullable|boolean',
        ], [
            'name.unique' => 'This category already exists for this user.',
        ]);

        Category::create([
            'name' => $validated['name'],
            'status' => $request->has('status') ? 1 : 0,
            'user_id' => $data['user_id'],
            'employee_id' => $data['employee_id'],
        ]);

        return redirect()->back()->with('success', 'Category created successfully.');
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
            $data['user_id'] = $employee->user_id;

            \Log::info('Employee adding category', [
                'employee_id' => $data['employee_id'],
                'user_id' => $data['user_id'],
                'employee_name' => $employee->name,
            ]);
        } else {
            return redirect()->route('categories.index')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,NULL,id,user_id,' . $data['user_id'],
            'status' => 'nullable|boolean',
        ], [
            'name.unique' => 'This category already exists for this user.',
        ]);

        Category::create([
            'name' => $validated['name'],
            'status' => $request->has('status') ? 1 : 0,
            'user_id' => $data['user_id'],
            'employee_id' => $data['employee_id'],
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $currentUserId = $this->getCurrentUserId();
        if ($category->user_id !== $currentUserId) {
            return redirect()->route('categories.index')->with('error', 'Unauthorized access to update category.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id . ',id,user_id,' . $category->user_id,
            'status' => 'nullable|boolean',
        ], [
            'name.unique' => 'This category already exists for this user.',
        ]);

        $category->update([
            'name' => $validated['name'],
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $currentUserId = $this->getCurrentUserId();
        if ($category->user_id !== $currentUserId) {
            return redirect()->route('categories.index')->with('error', 'Unauthorized access to delete category.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
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