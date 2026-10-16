<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderReturnRequest extends Model
{
    public const STATUS_REQUESTED = 'requested';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_REFUND_PENDING = 'refund_pending';
    public const STATUS_REFUNDED = 'refunded';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'order_id', 'user_id', 'items', 'reason', 'description', 'status',
        'seller_note', 'decision_note', 'reviewed_by_admin', 'refund_amount',
        'history', 'reviewed_at', 'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
            'history' => 'array',
            'refund_amount' => 'decimal:2',
            'reviewed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo { return $this->belongsTo(Order::class); }
    public function customer(): BelongsTo { return $this->belongsTo(User::class, 'user_id'); }

    public function appendHistory(string $status, ?string $note = null, ?string $actor = null): void
    {
        $history = $this->history ?? [];
        $history[] = [
            'status' => $status,
            'note' => $note,
            'actor' => $actor,
            'at' => now()->toIso8601String(),
        ];
        $this->history = $history;
    }
}
