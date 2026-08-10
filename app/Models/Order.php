<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'address',
        'city',
        'total',
        'amount',
        'status',
        'payment_method',
        'payment_status',
        'order_status',
        'delivery_status',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryDetail()
    {
        return $this->hasOne(OrderDeliveryDetail::class);
    }
}
