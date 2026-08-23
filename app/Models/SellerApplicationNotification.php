<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerApplicationNotification extends Model
{
    protected $fillable = ['seller_profile_id', 'type', 'recipient', 'status', 'error_message', 'sent_at'];
    protected function casts(): array { return ['sent_at' => 'datetime']; }
    public function seller() { return $this->belongsTo(SellerProfile::class, 'seller_profile_id'); }
}
