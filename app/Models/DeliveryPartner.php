<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryPartner extends Model
{
protected $fillable = [
        'name',
        'image',
        'phone',
        'email',
        'vehicle_number',
        'vehicle_type',
        'delivery_date',
        'expected_time',
        'notes',
        'current_location',
    ];

    protected $casts = [
        'delivery_date' => 'date',
    ];

    public function deliveryDetails()
    {
        return $this->hasMany(OrderDeliveryDetail::class);
    }
}
