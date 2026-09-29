<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerPayout extends Model
{
    protected $fillable = ['seller_id', 'amount', 'status', 'reference', 'seller_note', 'admin_note', 'reviewed_by', 'reviewed_at', 'paid_at'];
    protected $casts = ['amount' => 'decimal:2', 'reviewed_at' => 'datetime', 'paid_at' => 'datetime'];
    public function seller() { return $this->belongsTo(SellerProfile::class, 'seller_id'); }
    public function reviewer() { return $this->belongsTo(Admin::class, 'reviewed_by'); }
    public function earnings() { return $this->belongsToMany(SellerEarning::class, 'seller_payout_earnings', 'seller_payout_id', 'seller_earning_id')->withPivot('amount')->withTimestamps(); }
}
