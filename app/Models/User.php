<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\SecuritySetting;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'house_no',
        'street',
        'area',
        'landmark',
        'city',
        'state',
        'country',
        'pin_code',
        'profile_image',
        'language',
        'dark_mode',
        'notifications',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    // Security PIN Relation
    public function securitySetting()
    {
        return $this->hasOne(SecuritySetting::class);
    }

}