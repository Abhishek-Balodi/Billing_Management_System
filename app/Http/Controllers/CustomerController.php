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
    if (Auth::guard('web')->check()) {
        // Admin
        $userId = Auth::guard('web')->id();
        $customers = Customer::with('employee') // agar relation banaya hai
            ->where('user_id', $userId)
            ->get();

    } elseif (Auth::guard('employee')->check()) {
        // Employee
        $employee = Auth::guard('employee')->user();
        $customers = Customer::with('employee')
            ->where('employee_id', $employee->id)
            ->get();
    } else {
        $customers = collect();
    }

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
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('customer_images', 'public');
        }

        $customer = Customer::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'country' => $validated['country'],
            'postal_code' => $validated['postal_code'],
            'image' => $imagePath,
            'status' => $request->has('status') ? 1 : 0,
            'user_id' => $data['user_id'],
            'employee_id' => $data['employee_id'],
        ]);

        // Attach multiple admins if sent
        if ($request->has('admin_ids')) {
            $customer->admins()->sync($request->admin_ids);
        }

        return redirect()->back()->with('success', 'Customer created successfully.');
    }

  public function update(Request $request, Customer $customer)
{
    // ✅ Validation
    $validated = $request->validate([
        'first_name'   => 'required|string|max:255',
        'last_name'    => 'required|string|max:255',
        'email'        => 'required|email|max:255|unique:customers,email,' . $customer->id,
        'phone'        => 'required|string|max:20',
        'address'      => 'required|string|max:255',
        'city'         => 'required|string|max:100',
        'state'        => 'required|string|max:100',
        'country'      => 'required|string|max:100',
        'postal_code'  => 'required|string|max:20',
        'image'        => 'nullable|image|mimes:jpeg,png|max:2048',
        'status'       => 'nullable|boolean',
    ]);

    // ✅ Authorization
    if (Auth::guard('web')->check()) {
        if ($customer->user_id !== Auth::guard('web')->id()) {
            abort(403, 'Unauthorized action');
        }
    } elseif (Auth::guard('employee')->check()) {
        if ($customer->employee_id !== Auth::guard('employee')->id()) {
            abort(403, 'Unauthorized action');
        }
    } else {
        abort(403, 'Unauthorized action');
    }

    // ✅ Fields to update
    $data = $request->only([
        'first_name','last_name','email','phone','address',
        'city','state','country','postal_code'
    ]);

    // $data['status'] = $request->has('status') ? 1 : 0;
    $data['status'] = $request->status; // directly use value 0/1


    // ✅ Handle Image
    if ($request->hasFile('image')) {
        // Purani image delete karo agar exist karti hai
        if ($customer->image && Storage::disk('public')->exists($customer->image)) {
            Storage::disk('public')->delete($customer->image);
        }
        // Nayi image store karo
        $data['image'] = $request->file('image')->store('customer_images', 'public');
    }

    // ✅ Update
    $customer->update($data);

    return redirect()->route('customers.index')
                     ->with('success', 'Customer updated successfully');
}



public function destroy($id)
{
    if(Auth::guard('web')->check()){
        $userId = Auth::guard('web')->id();
        $customer = Customer::where('user_id', $userId)
                            ->where('id', $id)
                            ->firstOrFail();
    } elseif(Auth::guard('employee')->check()) {
        $employee = Auth::guard('employee')->user();
        $customer = Customer::where('employee_id', $employee->id)
                            ->where('id', $id)
                            ->firstOrFail();
    } else {
        abort(403, 'Unauthorized action');
    }

    // Delete customer
    $customer->delete();

    return response()->json(['success' => 'Customer deleted successfully']);
}

}
