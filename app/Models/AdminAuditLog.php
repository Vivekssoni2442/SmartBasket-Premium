<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * AdminAuditLog Model
 *
 * Comprehensive audit trail of all admin actions.
 *
 * Tracks:
 * - Admin login/logout
 * - Failed login attempts
 * - Account lockouts
 * - Seller approvals/rejections
 * - Product actions
 * - Refund actions
 * - Coupon management
 * - Settings changes
 * - Suspension/activation actions
 *
 * Never stores:
 * - Passwords or hashes
 * - Sensitive authentication secrets
 * - Unnecessary PII beyond ID
 */
class AdminAuditLog extends Model
{
    protected $table = 'admin_audit_logs';

    protected $fillable = [
        'admin_id',
        'action',
        'entity_type',
        'entity_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'status',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Relationship: Audit log belongs to an Admin
     */
    public function admin()
{
    return $this->belongsTo(Admin::class, 'admin_id', 'id');
}

    /**
     * Create a comprehensive audit log entry
     */
    public static function log(
        Admin $admin,
        string $action,
        ?string $entityType = null,
        ?string $entityId = null,
        ?string $description = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        string $status = 'success'
    ): self {
        return self::create([
            'admin_id' => (string) $admin->getKey(),
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => $status,
        ]);
    }
}
