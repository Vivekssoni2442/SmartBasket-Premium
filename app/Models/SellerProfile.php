<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SellerProfile extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'seller_profiles';

    /*
    |--------------------------------------------------------------------------
    | VERIFICATION STATUS CONSTANTS
    |--------------------------------------------------------------------------
    */

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PENDING_EMAIL = 'pending_email';
    public const STATUS_EMAIL_VERIFICATION = 'email_verification';
    public const STATUS_DOCUMENTS_PENDING = 'documents_pending';
    public const STATUS_AADHAAR_VERIFICATION = 'aadhaar_verification';
    public const STATUS_BUSINESS_DETAILS = 'business_details';
    public const STATUS_BANK_DETAILS = 'bank_details';

    public const STATUS_SUBMITTED = 'pending_admin_review';
    public const STATUS_PENDING_ADMIN_REVIEW = 'pending_admin_review';

    public const STATUS_PENDING_REVIEW = 'pending_review';
    public const STATUS_UNDER_REVIEW = 'under_review';

    public const STATUS_APPROVED = 'approved';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_SUSPENDED = 'suspended';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'seller_id',
        'user_id',

        'seller_name',
        'email',
        'phone',
        'mobile',

        'address',
        'city',
        'state',
        'country',
        'pincode',

        'verification_status',
        'verification_step',

        'email_verified_at',
        'email_verification_code',
        'email_verification_code_hash',
        'email_verification_expires_at',

        'business_certificate_path',
        'aadhaar_document_path',

        'aadhaar_number',
        'aadhaar_verified_at',
        'aadhaar_verification_status',

        'business_type',
        'business_name',
        'pan_number',
        'udyam_number',

        'bank_account_holder',
        'bank_account_number',
        'bank_ifsc',
        'bank_name',
        'bank_branch',

        'application_submitted_at',

        'approved_at',
        'rejected_at',
        'rejection_reason',

        'admin_notes',
        'reviewed_by',
        'reviewed_at',

        'is_active',
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'email_verification_expires_at' => 'datetime',

            'aadhaar_verified_at' => 'datetime',

            /*
             * Actual database column.
             */
            'application_submitted_at' => 'datetime',

            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
            'reviewed_at' => 'datetime',

            'is_active' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | BACKWARD COMPATIBILITY
    |--------------------------------------------------------------------------
    |
    | Older admin pages may use:
    |
    | $seller->verification_submitted_at
    |
    | Actual database column:
    |
    | application_submitted_at
    |
    */

    public function getVerificationSubmittedAtAttribute()
    {
        return $this->application_submitted_at;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function verificationLogs(): HasMany
    {
        return $this->hasMany(
            SellerVerificationLog::class,
            'seller_profile_id'
        );
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(
            Admin::class,
            'reviewed_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EMAIL VERIFICATION
    |--------------------------------------------------------------------------
    */

    public function isEmailVerified(): bool
    {
        return !empty($this->email_verified_at);
    }

    /*
    |--------------------------------------------------------------------------
    | DOCUMENT VERIFICATION
    |--------------------------------------------------------------------------
    */

    public function hasBusinessCertificate(): bool
    {
        return !empty($this->business_certificate_path);
    }

    public function hasAadhaarDocument(): bool
    {
        return !empty($this->aadhaar_document_path);
    }

    /**
     * Check whether all required documents are uploaded.
     *
     * This method is required by the Admin Seller Verification page.
     */
    public function hasRequiredDocuments(): bool
    {
        return $this->hasBusinessCertificate()
            && $this->hasAadhaarDocument();
    }

    /**
     * Existing compatibility method.
     */
    public function areDocumentsUploaded(): bool
    {
        return $this->hasRequiredDocuments();
    }

    /*
    |--------------------------------------------------------------------------
    | AADHAAR VERIFICATION
    |--------------------------------------------------------------------------
    */

    public function isAadhaarVerified(): bool
    {
        return !empty($this->aadhaar_verified_at);
    }

    /*
    |--------------------------------------------------------------------------
    | BUSINESS DETAILS
    |--------------------------------------------------------------------------
    */

    public function areBusinessDetailsComplete(): bool
    {
        return !empty($this->business_type)
            && !empty($this->pan_number)
            && !empty($this->udyam_number);
    }

    public function hasBusinessDetails(): bool
    {
        return $this->areBusinessDetailsComplete();
    }

    /*
    |--------------------------------------------------------------------------
    | BANK DETAILS
    |--------------------------------------------------------------------------
    */

    public function areBankDetailsComplete(): bool
    {
        return !empty($this->bank_account_holder)
            && !empty($this->bank_account_number)
            && !empty($this->bank_ifsc)
            && !empty($this->bank_name);
    }

    public function hasBankDetails(): bool
    {
        return $this->areBankDetailsComplete();
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS CHECKS
    |--------------------------------------------------------------------------
    */

    public function isPendingEmail(): bool
    {
        return in_array(
            $this->verification_status,
            [
                self::STATUS_PENDING_EMAIL,
                self::STATUS_EMAIL_VERIFICATION,
            ],
            true
        );
    }

    public function isEmailVerificationPending(): bool
    {
        return $this->isPendingEmail();
    }

    public function isDocumentsPending(): bool
    {
        return $this->verification_status === self::STATUS_DOCUMENTS_PENDING;
    }

    public function isAadhaarVerificationPending(): bool
    {
        return $this->verification_status === self::STATUS_AADHAAR_VERIFICATION;
    }

    public function isBusinessDetailsPending(): bool
    {
        return $this->verification_status === self::STATUS_BUSINESS_DETAILS;
    }

    public function isBankDetailsPending(): bool
    {
        return $this->verification_status === self::STATUS_BANK_DETAILS;
    }

    public function isPendingAdminReview(): bool
    {
        return in_array(
            $this->verification_status,
            [
                self::STATUS_SUBMITTED,
                self::STATUS_PENDING_ADMIN_REVIEW,
            ],
            true
        );
    }

    public function isPendingReview(): bool
    {
        return in_array(
            $this->verification_status,
            [
                self::STATUS_PENDING_REVIEW,
                self::STATUS_UNDER_REVIEW,
            ],
            true
        );
    }

    public function isApproved(): bool
    {
        return in_array(
            $this->verification_status,
            [
                self::STATUS_APPROVED,
                self::STATUS_ACTIVE,
            ],
            true
        );
    }

    public function isActive(): bool
    {
        return $this->verification_status === self::STATUS_ACTIVE;
    }

    public function isRejected(): bool
    {
        return $this->verification_status === self::STATUS_REJECTED;
    }

    public function isSuspended(): bool
    {
        return $this->verification_status === self::STATUS_SUSPENDED;
    }

    /*
    |--------------------------------------------------------------------------
    | APPLICATION STATUS
    |--------------------------------------------------------------------------
    */

    public function isApplicationSubmitted(): bool
    {
        return in_array(
            $this->verification_status,
            [
                self::STATUS_SUBMITTED,
                self::STATUS_PENDING_ADMIN_REVIEW,
                self::STATUS_PENDING_REVIEW,
                self::STATUS_UNDER_REVIEW,
                self::STATUS_APPROVED,
                self::STATUS_ACTIVE,
            ],
            true
        );
    }

    public function isApplicationApproved(): bool
    {
        return in_array(
            $this->verification_status,
            [
                self::STATUS_APPROVED,
                self::STATUS_ACTIVE,
            ],
            true
        );
    }

    public function isCompleted(): bool
    {
        return $this->isApplicationApproved();
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFICATION STEP
    |--------------------------------------------------------------------------
    */

    public function getVerificationStep(): int
    {
        if (!$this->isEmailVerified()) {
            return 1;
        }

        if (!$this->hasRequiredDocuments()) {
            return 2;
        }

        if (!$this->isAadhaarVerified()) {
            return 3;
        }

        if (!$this->areBusinessDetailsComplete()) {
            return 4;
        }

        if (!$this->areBankDetailsComplete()) {
            return 5;
        }

        return 6;
    }

    /*
    |--------------------------------------------------------------------------
    | COMPLETED STEPS
    |--------------------------------------------------------------------------
    */

    public function getCompletedSteps(): int
    {
        $completed = 0;

        if ($this->isEmailVerified()) {
            $completed++;
        }

        if ($this->hasRequiredDocuments()) {
            $completed++;
        }

        if ($this->isAadhaarVerified()) {
            $completed++;
        }

        if ($this->areBusinessDetailsComplete()) {
            $completed++;
        }

        if ($this->areBankDetailsComplete()) {
            $completed++;
        }

        if ($this->isApplicationSubmitted()) {
            $completed++;
        }

        return $completed;
    }

    /*
    |--------------------------------------------------------------------------
    | PROGRESS PERCENTAGE
    |--------------------------------------------------------------------------
    */

    public function getProgressPercentage(): int
    {
        return (int) round(
            ($this->getCompletedSteps() / 6) * 100
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS LABEL
    |--------------------------------------------------------------------------
    */

    public function getStatusLabel(): string
    {
        return match ($this->verification_status) {

            self::STATUS_DRAFT =>
                'Draft',

            self::STATUS_PENDING_EMAIL,
            self::STATUS_EMAIL_VERIFICATION =>
                'Email Verification Pending',

            self::STATUS_DOCUMENTS_PENDING =>
                'Documents Required',

            self::STATUS_AADHAAR_VERIFICATION =>
                'Aadhaar Verification Pending',

            self::STATUS_BUSINESS_DETAILS =>
                'Business Details Pending',

            self::STATUS_BANK_DETAILS =>
                'Bank Details Pending',

            self::STATUS_SUBMITTED,
            self::STATUS_PENDING_ADMIN_REVIEW =>
                'Pending Admin Review',

            self::STATUS_PENDING_REVIEW,
            self::STATUS_UNDER_REVIEW =>
                'Under Review',

            self::STATUS_APPROVED =>
                'Approved',

            self::STATUS_ACTIVE =>
                'Seller Account Active',

            self::STATUS_INACTIVE =>
                'Inactive',

            self::STATUS_REJECTED =>
                'Application Rejected',

            self::STATUS_SUSPENDED =>
                'Suspended',

            default =>
                ucwords(
                    str_replace(
                        ['_', '-'],
                        ' ',
                        (string) ($this->verification_status ?: 'Unknown')
                    )
                ),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | APPLICATION STATUS LABEL
    |--------------------------------------------------------------------------
    */

    public function getApplicationStatusLabel(): string
    {
        return $this->getStatusLabel();
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS BADGE CLASS
    |--------------------------------------------------------------------------
    */

    public function getApplicationStatusBadgeClass(): string
    {
        return match ($this->verification_status) {

            self::STATUS_APPROVED,
            self::STATUS_ACTIVE =>
                'badge-success',

            self::STATUS_REJECTED =>
                'badge-danger',

            self::STATUS_SUSPENDED =>
                'badge-warning',

            self::STATUS_UNDER_REVIEW,
            self::STATUS_PENDING_REVIEW,
            self::STATUS_PENDING_ADMIN_REVIEW,
            self::STATUS_SUBMITTED =>
                'badge-info',

            self::STATUS_DRAFT =>
                'badge-secondary',

            self::STATUS_PENDING_EMAIL,
            self::STATUS_EMAIL_VERIFICATION,
            self::STATUS_DOCUMENTS_PENDING,
            self::STATUS_AADHAAR_VERIFICATION,
            self::STATUS_BUSINESS_DETAILS,
            self::STATUS_BANK_DETAILS =>
                'badge-secondary',

            default =>
                'badge-secondary',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | BACKWARD COMPATIBILITY
    |--------------------------------------------------------------------------
    */

    public function getApplicationStatusClass(): string
    {
        return $this->getApplicationStatusBadgeClass();
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS COLOR
    |--------------------------------------------------------------------------
    */

    public function getStatusColor(): string
    {
        return match ($this->verification_status) {

            self::STATUS_APPROVED,
            self::STATUS_ACTIVE =>
                '#22c55e',

            self::STATUS_REJECTED =>
                '#ef4444',

            self::STATUS_SUSPENDED =>
                '#f59e0b',

            self::STATUS_UNDER_REVIEW,
            self::STATUS_PENDING_REVIEW,
            self::STATUS_PENDING_ADMIN_REVIEW,
            self::STATUS_SUBMITTED =>
                '#3b82f6',

            self::STATUS_PENDING_EMAIL,
            self::STATUS_EMAIL_VERIFICATION =>
                '#a855f7',

            self::STATUS_DOCUMENTS_PENDING,
            self::STATUS_AADHAAR_VERIFICATION,
            self::STATUS_BUSINESS_DETAILS,
            self::STATUS_BANK_DETAILS =>
                '#f59e0b',

            default =>
                '#64748b',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS ICON
    |--------------------------------------------------------------------------
    */

    public function getStatusIcon(): string
    {
        return match ($this->verification_status) {

            self::STATUS_APPROVED,
            self::STATUS_ACTIVE =>
                '✓',

            self::STATUS_REJECTED =>
                '✕',

            self::STATUS_SUSPENDED =>
                '!',

            self::STATUS_UNDER_REVIEW,
            self::STATUS_PENDING_REVIEW,
            self::STATUS_PENDING_ADMIN_REVIEW,
            self::STATUS_SUBMITTED =>
                '⏳',

            self::STATUS_PENDING_EMAIL,
            self::STATUS_EMAIL_VERIFICATION =>
                '✉',

            self::STATUS_DOCUMENTS_PENDING =>
                '📄',

            self::STATUS_AADHAAR_VERIFICATION =>
                '🪪',

            self::STATUS_BUSINESS_DETAILS =>
                '🏢',

            self::STATUS_BANK_DETAILS =>
                '🏦',

            self::STATUS_DRAFT =>
                '📝',

            default =>
                '•',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS MESSAGE
    |--------------------------------------------------------------------------
    */

    public function getStatusMessage(): string
    {
        return match ($this->verification_status) {

            self::STATUS_DRAFT =>
                'Your seller application is currently saved as a draft.',

            self::STATUS_PENDING_EMAIL,
            self::STATUS_EMAIL_VERIFICATION =>
                'Please verify your registered seller email to continue.',

            self::STATUS_DOCUMENTS_PENDING =>
                'Your email has been verified. Please upload all required seller documents.',

            self::STATUS_AADHAAR_VERIFICATION =>
                'Your documents are available. Please complete Aadhaar verification.',

            self::STATUS_BUSINESS_DETAILS =>
                'Please complete your business information to continue.',

            self::STATUS_BANK_DETAILS =>
                'Please complete your bank information before submitting the application.',

            self::STATUS_SUBMITTED,
            self::STATUS_PENDING_ADMIN_REVIEW =>
                'Your complete seller application has been submitted and is waiting for admin approval.',

            self::STATUS_PENDING_REVIEW,
            self::STATUS_UNDER_REVIEW =>
                'Your seller application is currently being reviewed by the SmartBasket admin team.',

            self::STATUS_APPROVED =>
                'Congratulations! Your seller application has been approved.',

            self::STATUS_ACTIVE =>
                'Your seller account is fully verified and active.',

            self::STATUS_REJECTED =>
                !empty($this->rejection_reason)
                    ? 'Reason: ' . $this->rejection_reason
                    : 'Your seller application was rejected.',

            self::STATUS_SUSPENDED =>
                'Your seller account is currently suspended.',

            self::STATUS_INACTIVE =>
                'Your seller account is currently inactive.',

            default =>
                'Your seller verification is currently being processed.',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | SET STATUS
    |--------------------------------------------------------------------------
    */

    public function setVerificationStatus(string $status): bool
    {
        $allowedStatuses = [
            self::STATUS_DRAFT,
            self::STATUS_PENDING_EMAIL,
            self::STATUS_EMAIL_VERIFICATION,
            self::STATUS_DOCUMENTS_PENDING,
            self::STATUS_AADHAAR_VERIFICATION,
            self::STATUS_BUSINESS_DETAILS,
            self::STATUS_BANK_DETAILS,
            self::STATUS_SUBMITTED,
            self::STATUS_PENDING_ADMIN_REVIEW,
            self::STATUS_PENDING_REVIEW,
            self::STATUS_UNDER_REVIEW,
            self::STATUS_APPROVED,
            self::STATUS_ACTIVE,
            self::STATUS_INACTIVE,
            self::STATUS_REJECTED,
            self::STATUS_SUSPENDED,
        ];

        if (!in_array($status, $allowedStatuses, true)) {
            return false;
        }

        $this->verification_status = $status;

        return $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE VERIFICATION STEP
    |--------------------------------------------------------------------------
    */

    public function updateVerificationStep(): bool
    {
        $this->verification_step = $this->getVerificationStep();

        return $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | APPLICATION SUBMISSION
    |--------------------------------------------------------------------------
    */

    public function markApplicationSubmitted(): bool
    {
        $this->verification_status = self::STATUS_PENDING_ADMIN_REVIEW;

        $this->application_submitted_at = now();

        $this->verification_step = 6;

        return $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVAL
    |--------------------------------------------------------------------------
    */

    public function markApproved(): bool
    {
        $this->verification_status = self::STATUS_APPROVED;

        $this->approved_at = now();

        $this->rejected_at = null;

        $this->rejection_reason = null;

        $this->is_active = false;

        return $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | ACTIVATE SELLER
    |--------------------------------------------------------------------------
    */

    public function markActive(): bool
    {
        $this->verification_status = self::STATUS_ACTIVE;

        $this->is_active = true;

        if (empty($this->approved_at)) {
            $this->approved_at = now();
        }

        return $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT APPLICATION
    |--------------------------------------------------------------------------
    */

    public function markRejected(?string $reason = null): bool
    {
        $this->verification_status = self::STATUS_REJECTED;

        $this->rejected_at = now();

        $this->rejection_reason = $reason;

        $this->is_active = false;

        return $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | SUSPEND SELLER
    |--------------------------------------------------------------------------
    */

    public function markSuspended(?string $reason = null): bool
    {
        $this->verification_status = self::STATUS_SUSPENDED;

        $this->is_active = false;

        if (!empty($reason)) {
            $this->admin_notes = $reason;
        }

        return $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | PENDING REVIEW
    |--------------------------------------------------------------------------
    */

    public function markPendingReview(): bool
    {
        $this->verification_status = self::STATUS_PENDING_REVIEW;

        return $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | DISPLAY HELPERS
    |--------------------------------------------------------------------------
    */

    public function getSellerDisplayName(): string
    {
        return $this->seller_name
            ?: $this->business_name
            ?: ($this->name ?? null)
            ?: 'Seller';
    }

    public function getSellerName(): string
    {
        return $this->getSellerDisplayName();
    }

    public function getSellerEmail(): string
    {
        return $this->email
            ?: ($this->user?->email ?? '-');
    }

    public function getSellerPhone(): string
    {
        return $this->phone
            ?: $this->mobile
            ?: ($this->user?->phone ?? '-');
    }

    public function getMaskedAadhaar(): string
    {
        if (empty($this->aadhaar_number)) {
            return '-';
        }

        $aadhaar = preg_replace(
            '/\D/',
            '',
            $this->aadhaar_number
        );

        if (strlen($aadhaar) < 4) {
            return '****';
        }

        return 'XXXX-XXXX-' . substr(
            $aadhaar,
            -4
        );
    }

    public function getMaskedBankAccount(): string
    {
        if (empty($this->bank_account_number)) {
            return '-';
        }

        $account = preg_replace(
            '/\s+/',
            '',
            $this->bank_account_number
        );

        if (strlen($account) < 4) {
            return '****';
        }

        return '****' . substr(
            $account,
            -4
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT QR
    |--------------------------------------------------------------------------
    */

    public function hasPaymentQr(): bool
{
    return !empty($this->payment_qr);
}
}