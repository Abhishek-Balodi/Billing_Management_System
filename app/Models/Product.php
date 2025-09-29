<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'name', 'category_id', 'subcategory_id', 'brand_id', 
        // 'description', 'hsn_sac_code', 'unit_of_measure', 'unit_price', 'tax_type', 'tax_category', 
        // 'tax_percentage', 'quantity', 'quantity_alert', 'barcode', 'manufactured_date', 'expiry_date',
        // 'user_id', 'employee_id'

        'name', 'category_id', 'subcategory_id', 'brand_id', 'selling_type', 'image', 
        'user_id', 'employee_id', 'store_id', 'warehouse_id', 'description', 'hsn_sac_code', 
        'unit_of_measure', 'unit_price', 'tax_type', 'tax_category', 'tax_percentage', 
        'quantity', 'quantity_alert', 'barcode', 'barcode_symbology', 'manufactured_date', 
        'expiry_date', 'discount_type', 'discount_value', 'warranties', 'manufacturer'
    ];

    // public function vendor()
    // {
    //     return $this->belongsTo(Vendor::class);
    // }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
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
