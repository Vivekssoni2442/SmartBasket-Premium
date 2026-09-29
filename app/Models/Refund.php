<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Refund extends Model
{
    protected $fillable = ['payment_id', 'order_id', 'user_id', 'seller_id', 'payment_transaction_id', 'gateway_refund_id', 'amount', 'currency', 'status', 'reason', 'metadata', 'requested_at', 'processed_at', 'failed_at'];

    protected function casts(): array { return ['amount' => 'decimal:2', 'metadata' => 'array', 'requested_at' => 'datetime', 'processed_at' => 'datetime', 'failed_at' => 'datetime']; }

    public function payment(): BelongsTo { return $this->belongsTo(Payment::class); }
    public function order(): BelongsTo { return $this->belongsTo(Order::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function seller(): BelongsTo { return $this->belongsTo(SellerProfile::class, 'seller_id'); }
    public function transaction(): BelongsTo { return $this->belongsTo(PaymentTransaction::class, 'payment_transaction_id'); }
}
