<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Agar login karna ho
use Illuminate\Notifications\Notifiable;

// class Employee extends Model
class Employee extends Authenticatable
{
    //
    use HasFactory,Notifiable;
    protected $fillable = [
        'name',
        'email',
         'profile_photo_path',
        'email_verified_at',
        'password',
        'role_uuid',
        'user_id',
    ];

    protected $cast = [
        'password',
        'remember_token',
    ];
      // Casts
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo(Role::class, 'role_uuid','role_uuid');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function getProfilePhotoUrlAttribute(){
         if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }

        return asset('assets/img/avatar/avatar-25.png');
    }
}
