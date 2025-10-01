<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(){
        if (Auth::guard('web')->check()) {
    
        // Admin
        $userId = Auth::guard('web')->id();
            $suppliers = Supplier::with('employee')
                ->where('user_id', $userId)
                ->get();

                
        } elseif(Auth::guard('employee')->check()){
            // dd(Auth::guard('employee')->user());
            // Employee
            $employee = Auth::guard('employee')->user();
            // dd(Supplier::with('employee')->where('employee_id', $employee->id) ->get());
            $suppliers = Supplier::with('employee')
            ->where('employee_id', $employee->id)
            ->get();
        } else {
            $suppliers = collect();
        }
    
        return view('suppliers', compact('suppliers'));
    }

    public function store(Request $request){
        $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'country' => 'required',
        'postal_code' => 'required',
        ]);

        $data = $request->all();
            // Image save karein
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('suppliers', 'public'); 
            $data['image'] = $path; // DB me sirf relative path save hoga (e.g. suppliers/abcd.jpg)
        }

        if (Auth::guard('web')->check()) {
            // Admin
            $data['user_id'] = Auth::guard('web')->id();
            $data['employee_id'] = null;
        } elseif(Auth::guard('employee')->check()){
            // Employee
            $employee = Auth::guard('employee')->user();
            $data['employee_id'] = $employee->id;
                $data['user_id'] = $employee->user_id;

            \Log::info('Employee adding supplier', [
                'employee_id' => $data['employee_id'],
                'user_id' => $data['user_id'],
                'employee_name' => $employee->name,
            ]);
        }

        Supplier::create($data);
        return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully');

    }

    public function edit($id){
        if(Auth::guard('web')->check()){
            //admin
            $userId = Auth::guard('web')->id();
            //admin have right  to edit own and employee data
            $supplier = Supplier::where('user_id', $userId)
            ->where('id',$id)
            ->firstOrFail();
        }elseif(Auth::guard('employee')->check()){
    // dd(Auth::guard('employee')->check());
        $employee = Auth::guard('employee')->user();
        //employee can only their own data
        $supplier = Supplier::where('employee_id', $employee->id)
        ->where('id', $id)
        ->firstOrFail();
        } else{
            abort(403,'unauthorized action.');
        }
        return response()->json($supplier);
    }


    public function update(Request $request, $id){
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
        ]);

        if(Auth::guard('web')->check()){
            $userId = Auth::guard('web')->id();
            $supplier = Supplier::where('user_id' , $userId)
                ->where('id', $id)
                ->firstOrFail();
        } elseif(Auth::guard('employee')->check()){
            $employee = Auth::guard('employee')->user(); // define $employee
            $supplier = Supplier::where('employee_id', $employee->id)
                ->where('id', $id)
                ->firstOrFail();
        } else{
            abort(403, 'Unauthorized action');
        }
        $data = $request->all();
        // Status handling: checked → 1, unchecked → 0
        $data['status'] = $request->has('status') ? 1 : 0;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('suppliers', 'public');
            $data['image'] = $path; // sirf relative path save hoga
        } else {
            unset($data['image']); // agar image upload nahi hui to existing image ko overwrite mat karo
        }

        $supplier->update($data);
        return redirect()->route('suppliers.index')->with('success','Supplier updated successfully');
    }


    public function destroy($id){
        if(Auth::guard('web')->check()){
        $userId =  Auth::guard('web')->id();
        $supplier = Supplier::where('user_id', $userId)
        ->where('id', $id)
        ->firstOrFail();
        }elseif(Auth::guard('employee')->check()){
        $employee = Auth::guard('employee')->user();
        $supplier = Supplier::where('employee_id', $employee->id)
            ->where('id', $id)
            ->firstOrFail();
        } else {
            abort(403, 'Unauthorized action');
        }

        // Delete supplier
        $supplier->delete();
        return response()->json(['success' => 'Supplier deleted successfully']);
    }
}