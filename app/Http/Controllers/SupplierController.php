<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    //

 public function index(){
    if (Auth::guard('web')->check()) {
    // Admin
    $userId = Auth::guard('web')->id();
          $suppliers = Supplier::with('employee')
            ->where('user_id', $userId)
            ->get();

            
    } elseif(Auth::guard('employee')->check()){
        // Employee
        $employee = Auth::guard('employee')->user();
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

   if (Auth::guard('web')->check()) {
    // Admin
    $data['user_id'] = Auth::guard('web')->id();
    $data['employee_id'] = null;
} elseif(Auth::guard('employee')->check()){
    // Employee
    $employee = Auth::guard('employee')->user();
      $data['employee_id'] = $employee->id;
        $data['user_id'] = $employee->user_id; // assuming employee model me ye column hai

      \Log::info('Employee adding supplier', [
        'employee_id' => $data['employee_id'],
        'user_id' => $data['user_id'],
        'employee_name' => $employee->name,
    ]);
}


       Supplier::create($data);

      return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully');

    }




   
}
