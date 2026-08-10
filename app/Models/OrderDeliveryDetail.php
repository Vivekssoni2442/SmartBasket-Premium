<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDeliveryDetail extends Model
{
    protected $fillable = ['order_id', 'delivery_partner_id', 'status', 'current_location', 'assigned_at'];

    protected $casts = ['assigned_at' => 'datetime'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function deliveryPartner()
    {
        return $this->belongsTo(DeliveryPartner::class);
    }
}
