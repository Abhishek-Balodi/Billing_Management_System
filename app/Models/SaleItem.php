<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $table = 'sales_items';

    protected $fillable = [
        'sale_id', 'product_id', 'product_name', 'hsn_code', 'qty', 'unit', 'price',
        'user_id', 'employee_id', 'discount_percent', 'discount_rs',
        'gst_percent', 'igst_percent', 'cess_percent', 'cess_rs',
        'tax_amount', 'total_amount', 'expiry_date'
    ];

    public function sale()
    {
        return $this->belongsTo(SaleDetail::class, 'sale_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}