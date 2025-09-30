<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'status',
        'category_id',
        'user_id',
        'employee_id'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getStatusDisplayAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
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