<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Passkeys\Contracts\PasskeyUser;
use Laravel\Passkeys\Passkey;
use Laravel\Passkeys\PasskeyAuthenticatable;

class SellerProfile extends Authenticatable implements PasskeyUser
{
    use HasFactory, SoftDeletes, PasskeyAuthenticatable;

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

    /*
     * Backward compatibility.
     */
    public const STATUS_EMAIL_VERIFIED = self::STATUS_DOCUMENTS_PENDING;

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

        /*
        | Identity
        */

        'seller_id',
        'user_id',

        'seller_name',
        'shop_name',

        'email',
        'face_unlock_enabled',
        'phone',
        'mobile',
        'mobile_number',

        /*
        | Address
        */

        'address',
        'business_address',

        'city',
        'state',
        'country',
        'pincode',

        'business_city',
        'business_state',
        'business_pincode',

        /*
        | Verification
        */

        'verification_status',
        'verification_step',
        'onboarding_step',

        /*
        | Password
        */

        'password',

        /*
        | Email verification
        */

        'email_verified_at',

        'email_verification_code',
        'email_verification_code_hash',
        'email_verification_expires_at',
        'email_verification_attempts',

        'email_code_hash',
        'email_code_expires_at',
        'email_code_attempts',
        'email_code_sent_at',

        /*
        | Documents
        */

        'business_certificate_path',
        'aadhaar_document_path',
        'pan_document_path',
        'shop_proof_path',
        'bank_proof_path',

        'business_certificate_uploaded_at',
        'aadhaar_document_uploaded_at',
        'pan_document_uploaded_at',
        'shop_proof_uploaded_at',
        'bank_proof_uploaded_at',

        /*
        | Aadhaar
        */

        'aadhaar_number',
        'aadhaar_verified',
        'aadhaar_verified_at',
        'aadhaar_verification_status',

        'verification_reference_id',

        /*
        | Business
        */

        'business_type',
        'business_name',

        'gst_number',
        'pan_number',
        'udyam_number',

        /*
        | Bank
        */

        'bank_account_holder',
        'bank_account_holder_name',
        'bank_account_number',
        'bank_ifsc',
        'bank_name',
        'bank_branch',

        /*
        | Application
        */

        'application_submitted_at',
        'verification_submitted_at',

        'approved_at',
        'rejected_at',
        'rejection_reason',

        /*
        | Admin review
        */

        'admin_notes',
        'reviewed_by',
        'reviewed_at',

        'admin_reviewed_at',
        'admin_reviewed_by',

        /*
        | Admin notification
        */

        'admin_notification_status',
        'admin_notification_sent_at',
        'admin_notification_failed_at',

        /*
        | Seller account
        */

        'is_active',
        'blocked_at',
        'block_reason',

        /*
        | Seller settings
        */

        'preferences',

        /*
        | Seller payment settings
        */

        'payment_upi_id',
        'payment_mobile_number',
        'payment_business_name',
        'payment_status',
        'payment_provider',
        'payment_verification_status',
        'payment_verified_at',
        'payment_enabled',

        'whatsapp_business_phone',
        'whatsapp_phone_number_id',
        'whatsapp_access_token',
        'whatsapp_invoice_template',
        'whatsapp_template_language',
        'whatsapp_invoice_enabled',

        'online_payments_enabled',

        /*
        | Seller payment QR
        */

        'payment_qr',

        /*
        | Activation
        */

        'activation_code_hash',
        'activation_code_expires_at',
        'activation_code_sent_at',
        'activation_attempts',
        'activation_verified_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [

            'face_unlock_enabled' => 'boolean',

            /*
            |--------------------------------------------------------------------------
            | Email verification dates
            |--------------------------------------------------------------------------
            */

            'email_verified_at' => 'datetime',

            'email_code_sent_at' => 'datetime',
            'email_code_expires_at' => 'datetime',

            'email_verification_expires_at' => 'datetime',

            /*
            |--------------------------------------------------------------------------
            | Document upload dates
            |--------------------------------------------------------------------------
            */

            'business_certificate_uploaded_at' => 'datetime',
            'aadhaar_document_uploaded_at' => 'datetime',
            'pan_document_uploaded_at' => 'datetime',
            'shop_proof_uploaded_at' => 'datetime',
            'bank_proof_uploaded_at' => 'datetime',

            /*
            |--------------------------------------------------------------------------
            | Aadhaar
            |--------------------------------------------------------------------------
            */

            'aadhaar_verified' => 'boolean',
            'aadhaar_verified_at' => 'datetime',

            /*
            |--------------------------------------------------------------------------
            | Application
            |--------------------------------------------------------------------------
            */

            'application_submitted_at' => 'datetime',
            'verification_submitted_at' => 'datetime',

            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',

            /*
            |--------------------------------------------------------------------------
            | Admin review
            |--------------------------------------------------------------------------
            */

            'admin_reviewed_at' => 'datetime',
            'reviewed_at' => 'datetime',

            /*
            |--------------------------------------------------------------------------
            | Admin notifications
            |--------------------------------------------------------------------------
            */

            'admin_notification_sent_at' => 'datetime',
            'admin_notification_failed_at' => 'datetime',

            /*
            |--------------------------------------------------------------------------
            | Seller account
            |--------------------------------------------------------------------------
            */

            'is_active' => 'boolean',
            'blocked_at' => 'datetime',

            /*
            |--------------------------------------------------------------------------
            | Seller settings
            |--------------------------------------------------------------------------
            */

            'preferences' => 'array',

            'whatsapp_access_token' => 'encrypted',
            'whatsapp_invoice_enabled' => 'boolean',

            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */

            'payment_enabled' => 'boolean',
            'payment_verified_at' => 'datetime',

            'online_payments_enabled' => 'boolean',

            /*
            |--------------------------------------------------------------------------
            | Activation
            |--------------------------------------------------------------------------
            */

            'activation_code_expires_at' => 'datetime',
            'activation_code_sent_at' => 'datetime',
            'activation_verified_at' => 'datetime',

            'activation_attempts' => 'integer',

            /*
            |--------------------------------------------------------------------------
            | Attempts
            |--------------------------------------------------------------------------
            */

            'email_code_attempts' => 'integer',
            'email_verification_attempts' => 'integer',
        ];
    }

    public function isBlocked(): bool
    {
        return $this->blocked_at !== null;
    }

    public function preference(string $key, mixed $default = null): mixed
    {
        $preferences = is_array($this->preferences) ? $this->preferences : [];

        return array_key_exists($key, $preferences)
            ? $preferences[$key]
            : $default;
    }

    public function isStoreVisibleToCustomers(): bool
    {
        return ! $this->isBlocked();
    }

    public function allowsCustomerCancellation(): bool
    {
        return (bool) $this->preference('allow_order_cancellation', true);
    }

    public function allowsCustomerReturns(): bool
    {
        return (bool) $this->preference('allow_return_requests', true);
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT HELPERS
    |--------------------------------------------------------------------------
    */

    public function getPaymentUpiId(): string
    {
        return trim(
            (string) (
                $this->payment_upi_id
                ?: ($this->preferences['upi_id'] ?? '')
            )
        );
    }

    public function getPaymentMobileNumber(): string
    {
        return trim(
            (string) (
                $this->payment_mobile_number
                ?: $this->mobile_number
                ?: $this->phone
                ?: $this->mobile
                ?: ''
            )
        );
    }

    public function getPaymentBusinessName(): string
    {
        return trim(
            (string) (
                $this->payment_business_name
                ?: $this->shop_name
                ?: $this->seller_name
                ?: 'SMART BASKET'
            )
        );
    }

    public function isOnlinePaymentEnabled(): bool
    {
        return (bool) $this->online_payments_enabled
            && (bool) $this->payment_enabled
            && $this->payment_status === 'enabled'
            && ! in_array($this->verification_status, [self::STATUS_INACTIVE, self::STATUS_SUSPENDED, self::STATUS_REJECTED], true);
    }

    public function hasValidPaymentConfiguration(): bool
    {
        $upiId = $this->getPaymentUpiId();
        $businessName = $this->getPaymentBusinessName();

        return $upiId !== ''
            && preg_match(
                '/^[a-zA-Z0-9][a-zA-Z0-9._-]{1,252}@[a-zA-Z][a-zA-Z0-9.-]{1,63}$/',
                $upiId
            ) === 1
            && $businessName !== '';
    }

    public function paymentUriForAmount(
        float|string $amount,
        string $orderReference
    ): string {
        $upiId = $this->getPaymentUpiId();

        if (! $this->isOnlinePaymentEnabled() || ! $this->hasValidPaymentConfiguration()) {
            throw new \InvalidArgumentException(
                'Seller UPI payment is currently unavailable.'
            );
        }

        if (! is_numeric($amount) || (float) $amount <= 0) {
            throw new \InvalidArgumentException('Payment amount must be greater than zero.');
        }

        $amountValue = number_format(
            (float) $amount,
            2,
            '.',
            ''
        );

        $name = $this->getPaymentBusinessName();

        $query = http_build_query(
            [
                'pa' => $upiId,
                'pn' => $name,
                'am' => $amountValue,
                'cu' => 'INR',
                'tn' => $orderReference,
            ],
            '',
            '&',
            PHP_QUERY_RFC3986
        );

        return 'upi://pay?' . $query;
    }

    /*
    |--------------------------------------------------------------------------
    | BACKWARD COMPATIBILITY
    |--------------------------------------------------------------------------
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

    /**
     * Seller passkeys use the package's `user_id` foreign key, even though
     * this authenticatable model is named SellerProfile.
     */
    public function passkeys(): HasMany
    {
        return $this->hasMany(Passkey::class, 'user_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(
            Product::class,
            'seller_id'
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

    public function earnings(): HasMany
    {
        return $this->hasMany(
            SellerEarning::class,
            'seller_id'
        );
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(
            SellerPayout::class,
            'seller_id'
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

    public function hasRequiredDocuments(): bool
    {
        return $this->hasBusinessCertificate()
            && $this->hasAadhaarDocument();
    }

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
            && !empty($this->business_name)
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
        return $this->verification_status
            === self::STATUS_DOCUMENTS_PENDING;
    }

    public function isAadhaarVerificationPending(): bool
    {
        return $this->verification_status
            === self::STATUS_AADHAAR_VERIFICATION;
    }

    public function isBusinessDetailsPending(): bool
    {
        return $this->verification_status
            === self::STATUS_BUSINESS_DETAILS;
    }

    public function isBankDetailsPending(): bool
    {
        return $this->verification_status
            === self::STATUS_BANK_DETAILS;
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
        return $this->verification_status
            === self::STATUS_ACTIVE;
    }

    public function isRejected(): bool
    {
        return $this->verification_status
            === self::STATUS_REJECTED;
    }

    public function isSuspended(): bool
    {
        return $this->verification_status
            === self::STATUS_SUSPENDED;
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
                        (string) (
                            $this->verification_status
                            ?: 'Unknown'
                        )
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
    | SET VERIFICATION STATUS
    |--------------------------------------------------------------------------
    */

    public function setVerificationStatus(
        string $status
    ): bool {
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

        if (!in_array(
            $status,
            $allowedStatuses,
            true
        )) {
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
        $this->verification_step =
            $this->getVerificationStep();

        return $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | APPLICATION SUBMISSION
    |--------------------------------------------------------------------------
    */

    public function markApplicationSubmitted(): bool
    {
        $this->verification_status =
            self::STATUS_PENDING_ADMIN_REVIEW;

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
        $this->verification_status =
            self::STATUS_APPROVED;

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
        $this->verification_status =
            self::STATUS_ACTIVE;

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

    public function markRejected(
        ?string $reason = null
    ): bool {
        $this->verification_status =
            self::STATUS_REJECTED;

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

    public function markSuspended(
        ?string $reason = null
    ): bool {
        $this->verification_status =
            self::STATUS_SUSPENDED;

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
        $this->verification_status =
            self::STATUS_PENDING_REVIEW;

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
            ?: $this->shop_name
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
            ?: $this->mobile_number
            ?: ($this->user?->phone ?? '-');
    }

    /*
    |--------------------------------------------------------------------------
    | MASKED AADHAAR
    |--------------------------------------------------------------------------
    */

    public function getMaskedAadhaar(): string
    {
        if (empty($this->aadhaar_number)) {
            return '-';
        }

        $aadhaar = preg_replace(
            '/\D/',
            '',
            (string) $this->aadhaar_number
        );

        if (strlen($aadhaar) < 4) {
            return '****';
        }

        return 'XXXX-XXXX-' .
            substr($aadhaar, -4);
    }

    /*
    |--------------------------------------------------------------------------
    | MASKED BANK ACCOUNT
    |--------------------------------------------------------------------------
    */

    public function getMaskedBankAccount(): string
    {
        if (empty($this->bank_account_number)) {
            return '-';
        }

        $account = preg_replace(
            '/\s+/',
            '',
            (string) $this->bank_account_number
        );

        if (strlen($account) < 4) {
            return '****';
        }

        return '****' .
            substr($account, -4);
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
