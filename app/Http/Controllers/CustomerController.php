<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index()
    {
        $currentUserId = $this->getCurrentUserId();
        $customers = Customer::with(['user', 'employee'])->where('user_id', $currentUserId)->get();
        return view('customers', compact('customers'));
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

            Log::info('Employee adding customer', [
                'employee_id' => $data['employee_id'],
                'user_id' => $data['user_id'],
                'employee_name' => $employee->name,
            ]);
        } else {
            return redirect()->route('customers.index')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,NULL,id,user_id,' . $data['user_id'],
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'gstin' => 'nullable|string|max:15',
            'pan' => 'nullable|string|max:10',
            'company_name' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'status' => 'nullable|boolean',
        ], [
            'email.unique' => 'This email is already used by another customer for this user.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a JPEG or PNG.',
            'image.max' => 'The image size must not exceed 2MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('customer_images', 'public');
        }

        Customer::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'shipping_address' => $validated['shipping_address'],
            'billing_address' => $validated['billing_address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'country' => $validated['country'],
            'postal_code' => $validated['postal_code'],
            'gstin' => $validated['gstin'],
            'pan' => $validated['pan'],
            'company_name' => $validated['company_name'],
            'website' => $validated['website'],
            'image' => $imagePath,
            'status' => $request->has('status') ? 1 : 0,
            'user_id' => $data['user_id'],
            'employee_id' => $data['employee_id'],
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $currentUserId = $this->getCurrentUserId();
        if ($customer->user_id !== $currentUserId) {
            return redirect()->route('customers.index')->with('error', 'Unauthorized access to update customer.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $id . ',id,user_id,' . $customer->user_id,
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'gstin' => 'nullable|string|max:15',
            'pan' => 'nullable|string|max:10',
            'company_name' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'status' => 'nullable|boolean',
        ], [
            'email.unique' => 'This email is already used by another customer for this user.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a JPEG or PNG.',
            'image.max' => 'The image size must not exceed 2MB.',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($customer->image) {
                Storage::disk('public')->delete($customer->image);
            }
            $validated['image'] = $request->file('image')->store('customer_images', 'public');
        } else {
            $validated['image'] = $customer->image; // Retain existing image
        }

        $customer->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'shipping_address' => $validated['shipping_address'],
            'billing_address' => $validated['billing_address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'country' => $validated['country'],
            'postal_code' => $validated['postal_code'],
            'gstin' => $validated['gstin'],
            'pan' => $validated['pan'],
            'company_name' => $validated['company_name'],
            'website' => $validated['website'],
            'image' => $validated['image'],
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        $currentUserId = $this->getCurrentUserId();
        if ($customer->user_id !== $currentUserId) {
            return redirect()->route('customers.index')->with('error', 'Unauthorized access to delete customer.');
        }

        if ($customer->image) {
            Storage::disk('public')->delete($customer->image);
        }
        $customer->delete();

        return redirect()->route('customers.index')->with('danger', 'Customer deleted successfully.');
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