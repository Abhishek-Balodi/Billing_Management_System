<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class EmployeeController extends Controller
{
    // EmployeeController.php
public function index()
{
    $employees = Employee::with('role')->get();
    return view('employees.index', compact('employees'));
}
    // Show the employee creation form
    public function create()
    {

       if (!Auth::check()) {
    return redirect()->route('login')->with('error', 'Please log in first.');
}

if (Auth::user()->role_uuid !== '00000001') {
    return redirect()->route('home')->with('error', 'You do not have permission to create users.');
}

        // Get all roles
        $roles = Role::all();
        return view('employees.create', compact('roles'));
    }

    // Store the new employee data
    public function store(Request $request)
    {

       if (Auth::user()->role_uuid !== '00000001') {
    return redirect()->route('home')->with('error', 'You do not have permission to create user');
}


        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_uuid' => 'required|exists:roles,role_uuid',
        ]);

        // dd($request);

        // $role = Role::where('role_uuid', $request->role_uuid)->first();
        // $role_uuid = $role->role_uuid;

        // dd($role_uuid);
        // Create the new employee
        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_uuid' => $request->role_uuid, // Set the role_id from the form
            'user_id' => Auth::id(),
        ]);

        // Redirect to a success page or back to the employee list
        return redirect()->route('employees.create')->with('success', 'Employee added successfully');
    }



    public function showLoginForm(){
        return view('employees.employee-login');
    }

    public function login(Request $request){
       $credentials =  $request->only('email','password');

       if(Auth::guard('employee')->attempt($credentials)){
        $employee = Auth::guard('employee')->user();

        session()->put('employee_id', $employee->id);
        session()->put('created_by_user_id', $employee->user_id);

        Log::info('Employee logged in ',[
        'employee_id' => $employee->id,
        'employee_name' => $employee->name,
        'created_by_id' => $employee->user_id,
        'email' => $employee->email, 
        ]);
        return redirect()->route('home');
       }
       return back()->withErrors([
        'email' => 'Invalid credentials.',
       ]);
    }

    public function logout(){
        Auth::guard('employee')->logout();

        session()->flush();
        return redirect()->route('employee.login');
    }
    public function editProfile(){
        $employee = Auth::guard('employee')->user();
        return view('employees.profile-edit', compact('employee'));
    }

     public function updateProfile(Request $request){
        //fetch curr user
        $employee = Auth::guard('employee')->user();

        $request->validate([
             'name' => 'required|string|max:255',
        'email' => 'required|email|unique:employees,email,' . $employee->id,
        'profile_photo' => 'nullable|image|mimes:jpg,png,jpeg',
        'password' => 'nullable|string|min:8|confirmed',
        ]);

        if($request->hasFile('profile_photo')){
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $employee->profile_photo_path = $path;
        }

        $employee->name  = $request->name;
        $employee->email = $request->email;

        if($request->filled('password')){
            $employee->password = Hash::make($request->password);
        }

        $employee->save();
        return redirect()->route('employee.profile.edit')->with('success','profile updated successfully');
     }
}