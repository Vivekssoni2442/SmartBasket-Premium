<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderCancellationRequest extends Model
{
    public const STATUS_REFUND_PENDING = 'refund_pending';
    public const STATUS_REFUNDED = 'refunded';
    public const STATUS_NO_REFUND = 'no_refund';

    protected $hidden = [
        'upi_id', 'bank_account_holder', 'bank_name', 'bank_account_number', 'bank_ifsc',
    ];

    protected $fillable = [
        'order_id', 'user_id', 'seller_id', 'status', 'reason', 'refund_amount',
        'refund_method', 'upi_id', 'bank_account_holder', 'bank_name',
        'bank_account_number', 'bank_ifsc', 'seller_transfer_reference',
        'seller_note', 'refund_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'upi_id' => 'encrypted',
            'bank_account_holder' => 'encrypted',
            'bank_name' => 'encrypted',
            'bank_account_number' => 'encrypted',
            'bank_ifsc' => 'encrypted',
            'refund_amount' => 'decimal:2',
            'refund_sent_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(SellerProfile::class, 'seller_id');
    }
}
