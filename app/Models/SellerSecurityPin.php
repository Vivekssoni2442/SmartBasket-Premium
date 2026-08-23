<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerSecurityPin extends Model
{
    protected $fillable = ['seller_profile_id', 'pin_hash', 'security_enabled', 'last_attempt_at', 'failed_attempt_count'];

    protected $hidden = ['pin_hash'];

    protected function casts(): array
    {
        return ['security_enabled' => 'boolean', 'last_attempt_at' => 'datetime'];
    }

    public function seller()
    {
        return $this->belongsTo(SellerProfile::class, 'seller_profile_id');
    }
}
