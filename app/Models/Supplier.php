<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'gstin',
        'pan',
        'company_name',
        'website',
        'image',
        'status',
        'user_id',
        'employee_id',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getStatusDisplayAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
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