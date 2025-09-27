<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    //
    use HasFactory;

    protected $fillable = [
    'user_id',
    'employee_id',
    'first_name',
    'last_name',
    'email',
    'phone',
    'address',
    'city',
    'state',
    'country',
    'postal_code',
    'status',
    'image'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
