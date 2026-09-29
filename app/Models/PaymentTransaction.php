<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'payment_id',
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
        'attempt_number',
        'transaction_type',
        'gateway_transaction_id',
        'request_metadata',
        'response_metadata',
        'initiated_at',
        'completed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'items_snapshot' => 'array',
        'customer_details' => 'array',
        'order_ids' => 'array',
        'request_metadata' => 'array',
        'response_metadata' => 'array',
        'verified_at' => 'datetime',
        'expires_at' => 'datetime',
        'initiated_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function auditRecords()
    {
        return $this->hasMany(PaymentAuditRecord::class);
    }

    public function isAccessibleByCurrentSession(): bool
    {
        return (auth()->check() && (int) $this->user_id === (int) auth()->id())
            || session('payment_transaction_token.' . $this->id) === $this->access_token;
    }
}
