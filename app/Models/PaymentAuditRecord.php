<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentAuditRecord extends Model
{
    protected $fillable = ['payment_id', 'payment_transaction_id', 'user_id', 'event', 'from_status', 'to_status', 'metadata', 'ip_address', 'user_agent'];

    protected function casts(): array { return ['metadata' => 'array']; }

    public function payment(): BelongsTo { return $this->belongsTo(Payment::class); }
    public function transaction(): BelongsTo { return $this->belongsTo(PaymentTransaction::class, 'payment_transaction_id'); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
