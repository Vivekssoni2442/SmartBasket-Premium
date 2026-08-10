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
        'mobile_number',
        'shop_address',
        'city',
        'state',
        'pincode',
        'gst_number',
        'shop_logo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id', 'user_id');
    }
}