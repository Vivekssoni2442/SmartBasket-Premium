<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'access_token',
        'gateway',
        'gateway_order_id',
        'gateway_payment_id',
        'gateway_signature',
        'payment_method',
        'status',
        'amount',
        'amount_paise',
        'currency',
        'items_snapshot',
        'customer_details',
        'order_ids',
        'failure_reason',
        'verified_at',
        'expires_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'items_snapshot' => 'array',
        'customer_details' => 'array',
        'order_ids' => 'array',
        'verified_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isAccessibleByCurrentSession(): bool
    {
        return (auth()->check() && (int) $this->user_id === (int) auth()->id())
            || session('payment_transaction_token.' . $this->id) === $this->access_token;
    }
}
