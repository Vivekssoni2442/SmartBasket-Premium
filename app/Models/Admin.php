<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Admin Model
 *
 * Represents a SmartBasket platform administrator.
 *
 * Admin accounts are separate from Customer (User)
 * and SellerProfile accounts.
 *
 * Admin accounts must NOT be publicly created.
 */
class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';

    /**
     * Admin uses a string primary key.
     */
    protected $keyType = 'string';

    /**
     * Admin IDs are generated manually.
     */
    public $incrementing = false;

    /**
     * Admin role constants.
     */
    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MODERATOR = 'moderator';

    /**
     * Admin status constants.
     */
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_SUSPENDED = 'suspended';

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'status',
        'avatar',
        'bio',
        'timezone',
        'language',
        'dark_mode',
        'mfa_enabled',
        'mfa_secret',
        'mfa_recovery_codes',
        'last_login_at',
        'last_login_ip',
        'last_activity_at',
        'login_attempts',
        'locked_until',
    ];

    /**
     * Hidden attributes.
     */
    protected $hidden = [
        'password',
        'mfa_secret',
        'mfa_recovery_codes',
    ];

    /**
     * Attribute casts.
     */
    protected $casts = [
        'mfa_enabled' => 'boolean',
        'mfa_recovery_codes' => 'array',
        'last_login_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'locked_until' => 'datetime',
    ];

    /**
     * Generate Admin ID automatically.
     */
    protected static function booted(): void
    {
        static::creating(function (self $admin) {
            if (!$admin->id) {
                $admin->id = 'ADMIN-' . Str::upper(Str::random(12));
            }
        });
    }

    /**
     * Relationship: Admin has many audit logs.
     */
    public function auditLogs()
    {
        return $this->hasMany(
            AdminAuditLog::class,
            'admin_id',
            'id'
        );
    }

    /**
     * Check if admin is a super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    /**
     * Check if admin account is active.
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if admin account is currently locked.
     */
    public function isLocked(): bool
    {
        if (!$this->locked_until) {
            return false;
        }

        if (now()->isAfter($this->locked_until)) {
            $this->update([
                'locked_until' => null,
                'login_attempts' => 0,
            ]);

            return false;
        }

        return true;
    }

    /**
     * Lock admin account for 15 minutes.
     */
    public function lock(): void
    {
        $this->update([
            'locked_until' => now()->addMinutes(15),
        ]);
    }

    /**
     * Record a failed login attempt.
     */
    public function recordFailedAttempt(): void
    {
        $attempts = (int) ($this->login_attempts ?? 0) + 1;

        if ($attempts >= 5) {
            $this->lock();
        }

        $this->update([
            'login_attempts' => $attempts,
        ]);
    }

    /**
     * Clear failed login attempts after successful login.
     */
    public function clearLoginAttempts(): void
    {
        $this->update([
            'login_attempts' => 0,
            'locked_until' => null,
            'last_login_at' => now(),
        ]);
    }

    /**
     * Update last activity timestamp.
     */
    public function updateLastActivity(): void
    {
        $this->update([
            'last_activity_at' => now(),
        ]);
    }

    /**
     * Generate TOTP secret.
     */
    public static function generateTotpSecret(): string
    {
        return base64_encode(random_bytes(32));
    }

    /**
     * Enable MFA for this admin.
     */
    public function enableMfa(string $secret): void
    {
        $recoveryCodes = [];

        for ($i = 0; $i < 10; $i++) {
            $recoveryCodes[] = Str::upper(Str::random(8));
        }

        $this->update([
            'mfa_enabled' => true,
            'mfa_secret' => $secret,
            'mfa_recovery_codes' => $recoveryCodes,
        ]);
    }

    /**
     * Disable MFA for this admin.
     */
    public function disableMfa(): void
    {
        $this->update([
            'mfa_enabled' => false,
            'mfa_secret' => null,
            'mfa_recovery_codes' => [],
        ]);
    }

    /**
     * Use a recovery code.
     */
    public function useRecoveryCode(string $code): bool
    {
        $codes = $this->mfa_recovery_codes ?? [];

        if (!in_array($code, $codes, true)) {
            return false;
        }

        // Remove the used recovery code.
        $codes = array_values(
            array_diff($codes, [$code])
        );

        $this->update([
            'mfa_recovery_codes' => $codes,
        ]);

        return true;
    }
}