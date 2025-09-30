<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'address', 
        'city', 'state', 'country', 'postal_code', 'image', 
        'status', 'user_id', 'employee_id'
    ];

    // Multiple admins
    public function admins()
    {
        return $this->belongsToMany(User::class, 'customer_admin', 'customer_id', 'user_id');
    }

    // Employee who added the customer
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Main admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
