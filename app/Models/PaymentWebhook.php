<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentWebhook extends Model
{
    protected $fillable = ['payment_id', 'gateway', 'gateway_event_id', 'event_type', 'status', 'payload', 'headers', 'processed_at', 'failure_reason'];

    protected function casts(): array { return ['payload' => 'array', 'headers' => 'array', 'processed_at' => 'datetime']; }

    public function payment(): BelongsTo { return $this->belongsTo(Payment::class); }
}
