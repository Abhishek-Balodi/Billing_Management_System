<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'product_name',
        'hsn_code',
        'qty',
        'unit',
        'price',
        'user_id',
        'employee_id',
        'discount',
        'tax_percent',
        'igst_percent',
        'tax_amount',
        'total_amount',
        'expiry_date',
    ];

    public function purchase()
    {
        return $this->belongsTo(PurchaseDetail::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
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
