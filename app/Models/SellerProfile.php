<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'seller_name',
        'shop_name',
        'email',
        'password',
        'mobile_number',
        'shop_address',
        'city',
        'state',
        'pincode',
        'gst_number',
        'shop_logo',
        'payment_qr',
        'theme',
        'notifications_enabled',
        'online_payments_enabled',
    ];

    /**
     * Seller passwords are only used for authentication and must never be
     * exposed when this model is serialized.
     */
    protected $hidden = [
        'password',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }
}
