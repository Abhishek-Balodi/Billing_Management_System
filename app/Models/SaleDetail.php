<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $table = 'sales_details';

    protected $fillable = [
        'invoice_no', 'invoice_date', 'customer_id', 'user_id', 'employee_id', 'status',
        'sales_type', 'challan_no', 'challan_date', 'lr_no', 'entry_date', 'delivery_mode',
        'total_amount', 'discount_amount', 'tax_amount', 'grand_total', 'actual_total',
        'round_off_amount', 'remarks', 'reverse_charge', 'shipping_address', 'place_of_supply',
        'created_by'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class, 'sale_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}