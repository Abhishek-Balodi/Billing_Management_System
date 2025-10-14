<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'invoice_date',
        'supplier_id',
        'user_id',
        'employee_id',
        'status',
        'purchase_type',
        'challan_no',
        'challan_date',
        'lr_no',
        'entry_date',
        'delivery_mode',
        'total_amount',
        'discount_amount',
        'tax_amount',
        'grand_total',
        'remarks',
        'created_by',
        'reverse_charge',
        'shipping_address',
        'place_of_supply',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id');
    }
}
