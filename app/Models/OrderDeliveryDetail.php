<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDeliveryDetail extends Model
{
    protected $fillable = ['order_id', 'delivery_partner_id', 'status', 'current_location', 'assigned_at', 'tracking_token', 'latitude', 'longitude', 'location_updated_at', 'delivery_scan_code', 'delivered_at'];

    protected $casts = ['assigned_at' => 'datetime', 'location_updated_at' => 'datetime', 'delivered_at' => 'datetime', 'latitude' => 'float', 'longitude' => 'float'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function deliveryPartner()
    {
        return $this->belongsTo(DeliveryPartner::class);
    }
}
