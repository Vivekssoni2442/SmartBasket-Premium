<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'gateway', 'gateway_reference', 'payment_method', 'status',
        'amount', 'currency', 'idempotency_key', 'metadata', 'authorized_at',
        'captured_at', 'failed_at', 'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'metadata' => 'array',
            'authorized_at' => 'datetime',
            'captured_at' => 'datetime',
            'failed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function orders(): BelongsToMany { return $this->belongsToMany(Order::class)->withTimestamps(); }
    public function transactions(): HasMany { return $this->hasMany(PaymentTransaction::class); }
    public function webhooks(): HasMany { return $this->hasMany(PaymentWebhook::class); }
    public function refunds(): HasMany { return $this->hasMany(Refund::class); }
    public function auditRecords(): HasMany { return $this->hasMany(PaymentAuditRecord::class); }
    public function sellerEarnings(): HasMany { return $this->hasMany(SellerEarning::class); }
}
