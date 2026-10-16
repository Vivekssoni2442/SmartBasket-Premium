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
        'status',
        'payment_method',
        'payment_status',
        'order_status',
        'delivery_status',
        'cancellation_reason',
        'cancelled_at',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
        'cancelled_at' => 'datetime',
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
        $status = $this->deliveryDetail?->status ?? $this->order_status ?? $this->status;
        return in_array($status, ['Placed', 'Confirmed', 'Pending', 'Order Placed', 'Seller Confirmed'], true);
    }

    /** COD is collected at delivery, so its customer-facing payment label is Cash. */
    public function isCashOnDelivery(): bool
    {
        $method = strtolower(trim((string) $this->payment_method));

        return in_array($method, ['cod', 'cash', 'cash_on_delivery', 'cash on delivery'], true);
    }

    public function isPaymentEligibleForReturn(): bool
    {
        return $this->isCashOnDelivery()
            || in_array(strtolower(trim((string) $this->payment_status)), ['paid', 'successful'], true);
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
