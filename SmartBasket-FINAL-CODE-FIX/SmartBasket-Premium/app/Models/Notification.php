<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'title',
        'message',
        'user_id',
        'seller_id',
        'role',
        'is_read',
        'data',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope: notifications for sellers
     */
    public function scopeForSeller($query, $sellerId = null)
    {
        return $query->where('role', 'seller')
            ->when($sellerId, fn($q) => $q->where('seller_id', $sellerId));
    }

    /**
     * Scope: notifications for users
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('role', 'user')->where('user_id', $userId);
    }
}