<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\SecuritySetting;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected static function booted(): void
    {
        static::creating(function (self $user) {
            if ($user->customer_uid) return;
            do { $user->customer_uid = 'CUS-'.Str::upper(Str::random(8)); }
            while (static::where('customer_uid', $user->customer_uid)->exists());
        });
    }


    protected $fillable = [
        'name',
        'customer_uid',
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
