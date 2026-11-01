<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'seller_id',
        'name',
        'mobile',
        'address',
        'city',
        'total',
        'amount',
        'shipping_amount',
        'estimated_delivery_days',
        'status',
        'payment_method',
        'payment_status',
        'order_status',
        'delivery_status',
        'cancellation_reason',
        'cancelled_at',
        'whatsapp_invoice_opt_in',
        'whatsapp_invoice_status',
        'whatsapp_invoice_message_id',
        'whatsapp_invoice_sent_at',
        'whatsapp_invoice_error',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
        'shipping_amount' => 'decimal:2',
        'estimated_delivery_days' => 'integer',
        'cancelled_at' => 'datetime',
        'whatsapp_invoice_opt_in' => 'boolean',
        'whatsapp_invoice_sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seller()
    {
        return $this->belongsTo(SellerProfile::class, 'seller_id');
    }

    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'payment_order')->withTimestamps();
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function returnRequests()
    {
        return $this->hasMany(OrderReturnRequest::class);
    }

    public function cancellationRequest()
    {
        return $this->hasOne(OrderCancellationRequest::class);
    }

    public function scopeForSeller($query, int $sellerId)
    {
        return $query->where(function ($orders) use ($sellerId) {
            $orders->where('seller_id', $sellerId)
                ->orWhereJsonContains('items', ['seller_id' => $sellerId]);
        });
    }

    public function belongsToSeller(int $sellerId): bool
    {
        if ((int) $this->seller_id === $sellerId) {
            return true;
        }

        return collect($this->items ?? [])->contains(
            fn (array $item) => (int) ($item['seller_id'] ?? 0) === $sellerId
        );
    }

    public function deliveryDetail()
    {
        return $this->hasOne(OrderDeliveryDetail::class);
    }

    public function isCancellable(): bool
    {
        $statuses = collect([
            $this->deliveryDetail?->status,
            $this->delivery_status,
            $this->order_status,
            $this->status,
        ])->filter()->map(fn ($status) => strtolower(trim((string) $status)));

        if ($statuses->isEmpty() || $statuses->contains(fn ($status) => in_array($status, ['delivered', 'complete', 'completed', 'cancelled', 'canceled'], true))) {
            return false;
        }

        return ! $this->seller || $this->seller->allowsCustomerCancellation();
    }

    /** COD is collected at delivery, so its customer-facing payment label is Cash. */
    public function isCashOnDelivery(): bool
    {
        $method = strtolower(trim((string) $this->payment_method));

        return in_array($method, ['cod', 'cash', 'cash_on_delivery', 'cash on delivery'], true);
    }

    public function isSellerDirectUpi(): bool
    {
        return strtolower(trim((string) $this->payment_method)) === 'seller upi';
    }

    public function isPaymentEligibleForReturn(): bool
    {
        return (! $this->seller || $this->seller->allowsCustomerReturns())
            && ($this->isCashOnDelivery()
                || in_array(strtolower(trim((string) $this->payment_status)), ['paid', 'successful'], true));
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        $status = trim((string) ($this->payment_status ?? 'Pending'));
        if ($this->isCashOnDelivery() && in_array(strtolower($status), ['pending', 'cash'], true)) {
            return 'Cash';
        }

        return ucfirst($status);
    }
}
