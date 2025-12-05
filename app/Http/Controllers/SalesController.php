<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\SaleDetail;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function create()
    {
        $currentUserId = $this->getCurrentUserId();
        $customers = Customer::where('user_id', $currentUserId)->get();
        $products = Product::where('user_id', $currentUserId)->get();
        return view('sales', compact('customers', 'products'));
    }

    public function getCustomerData($id)
    {
        $currentUserId = $this->getCurrentUserId();
        $customer = Customer::where('id', $id)->where('user_id', $currentUserId)->firstOrFail();

        $full_address = trim($customer->billing_address . ', ' . $customer->city . ', ' . $customer->state . ' - ' . $customer->postal_code);

        return response()->json([
            'success' => true,
            'data' => [
                'full_address' => $full_address,
                'contact_person' => $customer->first_name . ' ' . $customer->last_name,
                'phone' => $customer->phone,
                'gstin' => $customer->gstin ?? '',
                'pan' => $customer->pan ?? '',
            ]
        ]);
    }

    public function store(Request $request)
    {
        // data store logic
    }

    public function index()
    {
        // List view 
    }

    protected function getCurrentUserId()
    {
        return Auth::guard('web')->check() ? Auth::guard('web')->id() : Auth::guard('employee')->user()->user_id;
    }
}