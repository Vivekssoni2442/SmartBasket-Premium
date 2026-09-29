<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerEarning extends Model
{
    protected $fillable = ['seller_id', 'order_id', 'payment_id', 'order_item_key', 'gross_amount', 'platform_fee', 'net_amount', 'status', 'available_at', 'paid_at'];
    protected $casts = ['gross_amount' => 'decimal:2', 'platform_fee' => 'decimal:2', 'net_amount' => 'decimal:2', 'available_at' => 'datetime', 'paid_at' => 'datetime'];
    public function seller() { return $this->belongsTo(SellerProfile::class, 'seller_id'); }
    public function order() { return $this->belongsTo(Order::class); }
    public function payment() { return $this->belongsTo(Payment::class); }
    public function payouts() { return $this->belongsToMany(SellerPayout::class, 'seller_payout_earnings', 'seller_earning_id', 'seller_payout_id')->withPivot('amount')->withTimestamps(); }
}
