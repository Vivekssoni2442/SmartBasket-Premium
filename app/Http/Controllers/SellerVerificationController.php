<?php

namespace App\Http\Controllers;

use App\Models\SellerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerVerificationController extends Controller
{
    private const MAX_ATTEMPTS = 5;
    private const CODE_EXPIRY_MINUTES = 10;

    /*
    |--------------------------------------------------------------------------
    | CURRENT SELLER
    |--------------------------------------------------------------------------
    */

    private function currentSeller(): SellerProfile
    {
        abort_unless(
            session('seller_login') && session('seller_id'),
            403,
            'Please login as seller first.'
        );

        return SellerProfile::findOrFail(
            (int) session('seller_id')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT MODE
    |--------------------------------------------------------------------------
    */

    private function isEditMode(): bool
    {
        return session('seller_verification_edit_mode') === true;
    }

    private function enableEditMode(Request $request): void
    {
        if ($request->boolean('edit')) {
            session([
                'seller_verification_edit_mode' => true,
            ]);
        }
    }

    private function clearEditMode(): void
    {
        session()->forget('seller_verification_edit_mode');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP DEFINITIONS
    |--------------------------------------------------------------------------
    */

    private function stepForSeller(SellerProfile $seller): int
    {
        if (!$seller->email_verified_at) {
            return 1;
        }

        if (
            empty($seller->business_certificate_path) ||
            empty($seller->aadhaar_document_path)
        ) {
            return 2;
        }

        if (!$seller->aadhaar_verified_at) {
            return 3;
        }

        if (
            empty($seller->business_type) ||
            empty($seller->pan_number) ||
            empty($seller->udyam_number)
        ) {
            return 4;
        }

        if (
            empty($seller->bank_account_holder) ||
            empty($seller->bank_account_number) ||
            empty($seller->bank_ifsc) ||
            empty($seller->bank_name)
        ) {
            return 5;
        }

        return 6;
    }

    /*
    |--------------------------------------------------------------------------
    | CURRENT STEP REDIRECT
    |--------------------------------------------------------------------------
    */

    private function redirectToCurrentStep(SellerProfile $seller)
    {
        if ($seller->isActive()) {
            return redirect()->route('seller.dashboard');
        }

        if (
            in_array(
                $seller->verification_status,
                [
                    SellerProfile::STATUS_REJECTED,
                    SellerProfile::STATUS_SUSPENDED,
                ],
                true
            )
        ) {
            return redirect()->route(
                'seller.verification.status'
            );
        }

        return match ($this->stepForSeller($seller)) {
            1 => redirect()->route(
                'seller.verification.email'
            ),

            2 => redirect()->route(
                'seller.verification.documents'
            ),

            3 => redirect()->route(
                'seller.verification.aadhaar'
            ),

            4 => redirect()->route(
                'seller.business-details'
            ),

            5 => redirect()->route(
                'seller.bank-details'
            ),

            default => redirect()->route(
                'seller.application.review'
            ),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | STEP DATA
    |--------------------------------------------------------------------------
    */

    private function stepData(
        SellerProfile $seller,
        int $step
    ): array {
        return [
            'seller' => $seller,
            'currentStep' => $step,
            'totalSteps' => 6,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 1 - EMAIL
    |--------------------------------------------------------------------------
    */

    public function emailForm(Request $request)
    {
        $seller = $this->currentSeller();

        $this->enableEditMode($request);

        if ($seller->isActive()) {
            return redirect()->route('seller.dashboard');
        }

        return view(
            'seller.verification.email',
            $this->stepData($seller, 1)
        );
    }

    public function sendEmailCode(Request $request)
    {
        $seller = $this->currentSeller();

        if ($seller->email_verified_at) {
            return back()->with(
                'info',
                'Your email is already verified.'
            );
        }

        if (empty($seller->email)) {
            Log::error(
                'SELLER EMAIL VERIFICATION FAILED: EMAIL EMPTY',
                ['seller_id' => $seller->id]
            );

            return back()->with(
                'error',
                'Seller email address is missing.'
            );
        }

        $code = '';

        for ($i = 0; $i < 16; $i++) {
            $code .= (string) random_int(0, 9);
        }

        try {
            Mail::raw(
                "SMART BASKET PREMIUM\n\n"
                . "SELLER PARTNER PROGRAM\n"
                . "EMAIL VERIFICATION\n\n"
                . "Hello {$seller->seller_name},\n\n"
                . "Your 16-digit seller verification code is:\n\n"
                . "{$code}\n\n"
                . "This code is valid for "
                . self::CODE_EXPIRY_MINUTES
                . " minutes.\n\n"
                . "Please do not share this code with anyone.\n\n"
                . "SMART BASKET PREMIUM",
                function ($message) use ($seller) {
                    $message
                        ->from(
                            config(
                                'mail.from.address',
                                'smartbasket2442@gmail.com'
                            ),
                            config(
                                'mail.from.name',
                                'SMART BASKET PREMIUM'
                            )
                        )
                        ->to($seller->email)
                        ->subject(
                            'SMART BASKET - Seller Email Verification Code'
                        );
                }
            );

            $seller->forceFill([
                'email_code_hash' => Hash::make($code),
                'email_code_expires_at' =>
                    now()->addMinutes(
                        self::CODE_EXPIRY_MINUTES
                    ),
                'email_code_attempts' => 0,
                'email_code_sent_at' => now(),
                'verification_status' =>
                    SellerProfile::STATUS_PENDING_EMAIL,
                'onboarding_step' => 1,
            ])->save();

            return back()->with(
                'success',
                'A 16-digit verification code has been sent to '
                . $seller->email
                . '. Please check your inbox and spam folder.'
            );
        } catch (\Throwable $e) {
            Log::error(
                'SELLER VERIFICATION MAIL FAILED',
                [
                    'seller_id' => $seller->id,
                    'seller_email' => $seller->email,
                    'error' => $e->getMessage(),
                ]
            );

            return back()->with(
                'error',
                'Unable to send verification email. Please check your email configuration.'
            );
        }
    }

    public function verifyEmailCode(Request $request)
    {
        $seller = $this->currentSeller();

        $validated = $request->validate([
            'code' => [
                'required',
                'digits:16',
            ],
        ]);

        if ($seller->email_verified_at) {
            if ($this->isEditMode()) {
                $this->clearEditMode();

                return redirect()
                    ->route('seller.application.review')
                    ->with(
                        'info',
                        'Email is already verified.'
                    );
            }

            return redirect()
                ->route('seller.verification.documents')
                ->with(
                    'info',
                    'Email is already verified.'
                );
        }

        if (
            !$seller->email_code_hash ||
            !$seller->email_code_expires_at ||
            now()->greaterThan($seller->email_code_expires_at)
        ) {
            $seller->forceFill([
                'email_code_hash' => null,
                'email_code_expires_at' => null,
                'email_code_attempts' => 0,
            ])->save();

            return back()->with(
                'error',
                'Verification code expired. Please request a new code.'
            );
        }

        if (
            (int) $seller->email_code_attempts >=
            self::MAX_ATTEMPTS
        ) {
            $seller->forceFill([
                'email_code_hash' => null,
                'email_code_expires_at' => null,
                'email_code_attempts' => 0,
            ])->save();

            return back()->with(
                'error',
                'Too many invalid attempts. Please request a new code.'
            );
        }

        if (
            !Hash::check(
                (string) $validated['code'],
                (string) $seller->email_code_hash
            )
        ) {
            $seller->increment('email_code_attempts');

            return back()->with(
                'error',
                'Invalid verification code.'
            );
        }

        $seller->forceFill([
            'email_verified_at' => now(),
            'email_code_hash' => null,
            'email_code_expires_at' => null,
            'email_code_attempts' => 0,
            'onboarding_step' => 2,
            'verification_status' =>
                SellerProfile::STATUS_EMAIL_VERIFIED,
        ])->save();

        session([
            'seller_email_verified' => true,
        ]);

        if ($this->isEditMode()) {
            $this->clearEditMode();

            return redirect()
                ->route('seller.application.review')
                ->with(
                    'success',
                    'Email updated and verified successfully.'
                );
        }

        return redirect()
            ->route('seller.verification.documents')
            ->with(
                'success',
                'Email verified successfully. Please complete Step 2.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 2 - DOCUMENTS
    |--------------------------------------------------------------------------
    */

    public function documentsForm(Request $request)
    {
        $seller = $this->currentSeller();

        $this->enableEditMode($request);

        if (!$seller->email_verified_at) {
            return redirect()
                ->route('seller.verification.email')
                ->with(
                    'error',
                    'Please verify your email first.'
                );
        }

        return view(
            'seller.documents',
            $this->stepData($seller, 2)
        );
    }

    public function uploadDocument(Request $request)
    {
        $seller = $this->currentSeller();

        if (!$seller->email_verified_at) {
            return redirect()
                ->route('seller.verification.email')
                ->with(
                    'error',
                    'Please verify your email first.'
                );
        }

        $validated = $request->validate([
            'business_certificate' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,webp',
                'max:5120',
            ],

            'aadhaar_document' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $hasBusinessCertificate =
            $request->hasFile('business_certificate') ||
            !empty($seller->business_certificate_path);

        $hasAadhaar =
            $request->hasFile('aadhaar_document') ||
            !empty($seller->aadhaar_document_path);

        if (
            !$hasBusinessCertificate ||
            !$hasAadhaar
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Both Business Certificate and Aadhaar Card are required.'
                );
        }

        $data = [];

        if ($request->hasFile('business_certificate')) {
            if (
                $seller->business_certificate_path &&
                Storage::disk('public')->exists(
                    $seller->business_certificate_path
                )
            ) {
                Storage::disk('public')->delete(
                    $seller->business_certificate_path
                );
            }

            $data['business_certificate_path'] =
                $request
                    ->file('business_certificate')
                    ->store(
                        "seller-certificates/{$seller->id}",
                        'public'
                    );

            $data['business_certificate_uploaded_at'] = now();
        }

        if ($request->hasFile('aadhaar_document')) {
            if (
                $seller->aadhaar_document_path &&
                Storage::disk('public')->exists(
                    $seller->aadhaar_document_path
                )
            ) {
                Storage::disk('public')->delete(
                    $seller->aadhaar_document_path
                );
            }

            $data['aadhaar_document_path'] =
                $request
                    ->file('aadhaar_document')
                    ->store(
                        "seller-aadhaar-documents/{$seller->id}",
                        'public'
                    );

            $data['aadhaar_document_uploaded_at'] = now();
        }

        if (empty($seller->aadhaar_verified_at)) {
            $data['onboarding_step'] = 3;
            $data['verification_status'] =
                SellerProfile::STATUS_DOCUMENTS_PENDING;
        }

        $seller->forceFill($data)->save();

        $seller->refresh();

        if (
            empty($seller->business_certificate_path) ||
            empty($seller->aadhaar_document_path)
        ) {
            return back()->with(
                'error',
                'Both documents are required.'
            );
        }

        if ($this->isEditMode()) {
            $this->clearEditMode();

            return redirect()
                ->route('seller.application.review')
                ->with(
                    'success',
                    'Documents updated successfully.'
                );
        }

        return redirect()
            ->route('seller.verification.aadhaar')
            ->with(
                'success',
                'Documents saved successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 3 - AADHAAR
    |--------------------------------------------------------------------------
    */

    public function aadhaarForm(Request $request)
    {
        $seller = $this->currentSeller();

        $this->enableEditMode($request);

        if (!$seller->email_verified_at) {
            return redirect()
                ->route('seller.verification.email')
                ->with(
                    'error',
                    'Please complete Step 1 Email Verification first.'
                );
        }

        if (
            empty($seller->business_certificate_path) ||
            empty($seller->aadhaar_document_path)
        ) {
            return redirect()
                ->route('seller.verification.documents')
                ->with(
                    'error',
                    'Please complete Step 2 Documents first.'
                );
        }

        return view(
            'seller.verification.aadhaar',
            $this->stepData($seller, 3)
        );
    }

    public function startAadhaar(Request $request)
    {
        $seller = $this->currentSeller();

        if (!$seller->email_verified_at) {
            return redirect()
                ->route('seller.verification.email')
                ->with(
                    'error',
                    'Please complete Step 1 first.'
                );
        }

        if (
            empty($seller->business_certificate_path) ||
            empty($seller->aadhaar_document_path)
        ) {
            return redirect()
                ->route('seller.verification.documents')
                ->with(
                    'error',
                    'Please complete Step 2 Documents first.'
                );
        }

        $referenceId =
            $seller->verification_reference_id
            ?: 'SB-AADHAAR-' .
            strtoupper(Str::random(12));

        $seller->forceFill([
            'verification_reference_id' => $referenceId,
            'verification_status' =>
                SellerProfile::STATUS_AADHAAR_PENDING,
            'onboarding_step' => 3,
        ])->save();

        return back()->with(
            'success',
            'Aadhaar verification started.'
        );
    }

    public function verifyAadhaar(Request $request)
    {
        $seller = $this->currentSeller();

        $validated = $request->validate([
            'aadhaar_number' => [
                'required',
                'digits:12',
            ],
        ]);

        if (!$seller->email_verified_at) {
            return redirect()
                ->route('seller.verification.email')
                ->with(
                    'error',
                    'Please complete Step 1 first.'
                );
        }

        if (
            empty($seller->business_certificate_path) ||
            empty($seller->aadhaar_document_path)
        ) {
            return redirect()
                ->route('seller.verification.documents')
                ->with(
                    'error',
                    'Please complete Step 2 Documents first.'
                );
        }

        $data = [
            'aadhaar_verified_at' => now(),
            'verification_status' =>
                SellerProfile::STATUS_DOCUMENTS_PENDING,
            'onboarding_step' => 4,
        ];

        if (
            Schema::hasColumn(
                'seller_profiles',
                'aadhaar_number'
            )
        ) {
            $data['aadhaar_number'] =
                $validated['aadhaar_number'];
        }

        $seller->forceFill($data)->save();

        if ($this->isEditMode()) {
            $this->clearEditMode();

            return redirect()
                ->route('seller.application.review')
                ->with(
                    'success',
                    'Aadhaar verification updated successfully.'
                );
        }

        return redirect()
            ->route('seller.business-details')
            ->with(
                'success',
                'Aadhaar verification completed successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 4 - BUSINESS DETAILS
    |--------------------------------------------------------------------------
    */

    public function businessDetails(Request $request)
    {
        $seller = $this->currentSeller();

        $this->enableEditMode($request);

        if (!$seller->email_verified_at) {
            return redirect()
                ->route('seller.verification.email')
                ->with(
                    'error',
                    'Please complete Step 1 first.'
                );
        }

        if (
            empty($seller->business_certificate_path) ||
            empty($seller->aadhaar_document_path)
        ) {
            return redirect()
                ->route('seller.verification.documents')
                ->with(
                    'error',
                    'Please complete Step 2 first.'
                );
        }

        if (!$seller->aadhaar_verified_at) {
            return redirect()
                ->route('seller.verification.aadhaar')
                ->with(
                    'error',
                    'Please complete Step 3 first.'
                );
        }

        return view(
            'seller.business-details',
            $this->stepData($seller, 4)
        );
    }

    public function updateBusinessDetails(Request $request)
    {
        $seller = $this->currentSeller();

        if (!$seller->email_verified_at) {
            return redirect()
                ->route('seller.verification.email');
        }

        if (
            empty($seller->business_certificate_path) ||
            empty($seller->aadhaar_document_path)
        ) {
            return redirect()
                ->route('seller.verification.documents');
        }

        if (!$seller->aadhaar_verified_at) {
            return redirect()
                ->route('seller.verification.aadhaar');
        }

        $data = $request->validate([
            'business_type' => [
                'required',
                'string',
                'max:100',
            ],

            'gst_number' => [
                'nullable',
                'string',
                'max:50',
            ],

            'pan_number' => [
                'required',
                'string',
                'max:30',
            ],

            'udyam_number' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        $seller->forceFill([
            'business_type' =>
                $data['business_type'],

            'gst_number' =>
                $data['gst_number'] ?? null,

            'pan_number' =>
                strtoupper(
                    trim($data['pan_number'])
                ),

            'udyam_number' =>
                strtoupper(
                    trim($data['udyam_number'])
                ),

            'onboarding_step' => 5,
        ])->save();

        if ($this->isEditMode()) {
            $this->clearEditMode();

            return redirect()
                ->route('seller.application.review')
                ->with(
                    'success',
                    'Business details updated successfully.'
                );
        }

        return redirect()
            ->route('seller.bank-details')
            ->with(
                'success',
                'Business details saved successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 5 - BANK DETAILS
    |--------------------------------------------------------------------------
    */

    public function bankDetails(Request $request)
    {
        $seller = $this->currentSeller();

        $this->enableEditMode($request);

        if (!$seller->email_verified_at) {
            return redirect()
                ->route('seller.verification.email');
        }

        if (
            empty($seller->business_certificate_path) ||
            empty($seller->aadhaar_document_path)
        ) {
            return redirect()
                ->route('seller.verification.documents');
        }

        if (!$seller->aadhaar_verified_at) {
            return redirect()
                ->route('seller.verification.aadhaar');
        }

        if (
            empty($seller->business_type) ||
            empty($seller->pan_number) ||
            empty($seller->udyam_number)
        ) {
            return redirect()
                ->route('seller.business-details');
        }

        return view(
            'seller.bank-details',
            $this->stepData($seller, 5)
        );
    }

    public function updateBankDetails(Request $request)
    {
        $seller = $this->currentSeller();

        if (!$seller->email_verified_at) {
            return redirect()
                ->route('seller.verification.email');
        }

        if (
            empty($seller->business_certificate_path) ||
            empty($seller->aadhaar_document_path)
        ) {
            return redirect()
                ->route('seller.verification.documents');
        }

        if (!$seller->aadhaar_verified_at) {
            return redirect()
                ->route('seller.verification.aadhaar');
        }

        if (
            empty($seller->business_type) ||
            empty($seller->pan_number) ||
            empty($seller->udyam_number)
        ) {
            return redirect()
                ->route('seller.business-details');
        }

        $data = $request->validate([
            'bank_account_holder' => [
                'required',
                'string',
                'max:255',
            ],

            'bank_account_number' => [
                'required',
                'string',
                'max:50',
            ],

            'bank_ifsc' => [
                'required',
                'string',
                'max:20',
            ],

            'bank_name' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $seller->forceFill([
            'bank_account_holder' =>
                trim($data['bank_account_holder']),

            'bank_account_number' =>
                trim($data['bank_account_number']),

            'bank_ifsc' =>
                strtoupper(
                    trim($data['bank_ifsc'])
                ),

            'bank_name' =>
                trim($data['bank_name']),

            'onboarding_step' => 6,
        ])->save();

        $this->clearEditMode();

        return redirect()
            ->route('seller.application.review')
            ->with(
                'success',
                'Bank details saved successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 6 - REVIEW
    |--------------------------------------------------------------------------
    */

    public function review()
    {
        $seller = $this->currentSeller();

        if (!$seller->email_verified_at) {
            return redirect()
                ->route('seller.verification.email')
                ->with(
                    'error',
                    'Please complete Step 1 first.'
                );
        }

        if (
            empty($seller->business_certificate_path) ||
            empty($seller->aadhaar_document_path)
        ) {
            return redirect()
                ->route('seller.verification.documents')
                ->with(
                    'error',
                    'Please complete Step 2 first.'
                );
        }

        if (!$seller->aadhaar_verified_at) {
            return redirect()
                ->route('seller.verification.aadhaar')
                ->with(
                    'error',
                    'Please complete Step 3 first.'
                );
        }

        if (
            empty($seller->business_type) ||
            empty($seller->pan_number) ||
            empty($seller->udyam_number)
        ) {
            return redirect()
                ->route('seller.business-details')
                ->with(
                    'error',
                    'Please complete Step 4 first.'
                );
        }

        if (
            empty($seller->bank_account_holder) ||
            empty($seller->bank_account_number) ||
            empty($seller->bank_ifsc) ||
            empty($seller->bank_name)
        ) {
            return redirect()
                ->route('seller.bank-details')
                ->with(
                    'error',
                    'Please complete Step 5 first.'
                );
        }

        $this->clearEditMode();

        return view(
            'seller.application-review',
            $this->stepData($seller, 6)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SUBMIT APPLICATION
    |--------------------------------------------------------------------------
    */

    public function submitApplication(Request $request)
    {
        $seller = $this->currentSeller();

        $errors = [];

        if (!$seller->email_verified_at) {
            $errors[] = 'Email verification is incomplete.';
        }

        if (!$seller->business_certificate_path) {
            $errors[] = 'Business certificate is missing.';
        }

        if (!$seller->aadhaar_document_path) {
            $errors[] = 'Aadhaar document is missing.';
        }

        if (!$seller->aadhaar_verified_at) {
            $errors[] = 'Aadhaar verification is incomplete.';
        }

        if (empty($seller->business_type)) {
            $errors[] = 'Business type is required.';
        }

        if (empty($seller->pan_number)) {
            $errors[] = 'PAN number is required.';
        }

        if (empty($seller->udyam_number)) {
            $errors[] = 'Udyam number is required.';
        }

        if (empty($seller->bank_account_holder)) {
            $errors[] = 'Bank account holder is required.';
        }

        if (empty($seller->bank_account_number)) {
            $errors[] = 'Bank account number is required.';
        }

        if (empty($seller->bank_ifsc)) {
            $errors[] = 'Bank IFSC is required.';
        }

        if (empty($seller->bank_name)) {
            $errors[] = 'Bank name is required.';
        }

        if (count($errors) > 0) {
            return back()->with(
                'error',
                implode(' ', $errors)
            );
        }

        $seller->forceFill([
            'verification_status' =>
                SellerProfile::STATUS_PENDING_ADMIN_REVIEW,

            'verification_submitted_at' => now(),

            'admin_reviewed_at' => null,
            'admin_reviewed_by' => null,
            'rejection_reason' => null,
            'approved_at' => null,

            'onboarding_step' => 6,
        ])->save();

        $this->notifyAdmin($seller);

        return redirect()
            ->route('seller.verification.status')
            ->with(
                'success',
                'Your Seller Partner application has been submitted successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    public function status()
    {
        $seller = $this->currentSeller();

        return view(
            'seller.verification.status',
            compact('seller')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTIVATION
    |--------------------------------------------------------------------------
    */

    public function activationForm()
    {
        $seller = $this->currentSeller();

        if (
            $seller->verification_status !==
            SellerProfile::STATUS_APPROVED
        ) {
            return redirect()
                ->route('seller.verification.status')
                ->with(
                    'error',
                    'Your seller application has not been approved yet.'
                );
        }

        return view(
            'seller.verification.activation',
            compact('seller')
        );
    }

    public function verifyActivation(Request $request)
    {
        $seller = $this->currentSeller();

        if (
            $seller->verification_status !==
            SellerProfile::STATUS_APPROVED
        ) {
            return redirect()
                ->route('seller.verification.status')
                ->with(
                    'error',
                    'Your seller application has not been approved.'
                );
        }

        $validated = $request->validate([
            'code' => [
                'required',
                'digits:16',
            ],
        ]);

        if (
            !$seller->activation_code_hash ||
            !$seller->activation_code_expires_at ||
            now()->greaterThan(
                $seller->activation_code_expires_at
            )
        ) {
            $seller->forceFill([
                'activation_code_hash' => null,
                'activation_code_expires_at' => null,
                'activation_attempts' => 0,
            ])->save();

            return back()->with(
                'error',
                'Activation code expired. Please request a new code.'
            );
        }

        if (
            (int) $seller->activation_attempts >=
            self::MAX_ATTEMPTS
        ) {
            return back()->with(
                'error',
                'Too many invalid attempts. Please request a new code.'
            );
        }

        if (
            !Hash::check(
                (string) $validated['code'],
                (string) $seller->activation_code_hash
            )
        ) {
            $seller->increment('activation_attempts');

            return back()->with(
                'error',
                'Invalid activation code.'
            );
        }

        $seller->forceFill([
            'activation_code_hash' => null,
            'activation_code_expires_at' => null,
            'activation_attempts' => 0,
            'activation_verified_at' => now(),
            'onboarding_step' => 8,
        ])->save();

        session([
            'seller_login' => true,
            'seller_email' => $seller->email,
            'seller_id' => (int) $seller->id,
        ]);

        return redirect()
            ->route('seller.dashboard')
            ->with(
                'success',
                'Seller account activated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | RESEND ACTIVATION CODE
    |--------------------------------------------------------------------------
    */

    public function resendActivationCode(Request $request)
    {
        $seller = $this->currentSeller();

        if (
            $seller->verification_status !==
            SellerProfile::STATUS_APPROVED
        ) {
            return back()->with(
                'error',
                'Activation is not available.'
            );
        }

        $code = '';

        for ($i = 0; $i < 16; $i++) {
            $code .= (string) random_int(0, 9);
        }

        try {
            Mail::raw(
                "SMART BASKET PREMIUM\n\n"
                . "SELLER ACCOUNT ACTIVATION\n\n"
                . "Hello {$seller->seller_name},\n\n"
                . "Your 16-digit activation code is:\n\n"
                . "{$code}\n\n"
                . "This code is valid for "
                . self::CODE_EXPIRY_MINUTES
                . " minutes.\n\n"
                . "SMART BASKET PREMIUM",
                function ($message) use ($seller) {
                    $message
                        ->from(
                            config(
                                'mail.from.address',
                                'smartbasket2442@gmail.com'
                            ),
                            config(
                                'mail.from.name',
                                'SMART BASKET PREMIUM'
                            )
                        )
                        ->to($seller->email)
                        ->subject(
                            'SMART BASKET - Seller Activation Code'
                        );
                }
            );

            $seller->forceFill([
                'activation_code_hash' =>
                    Hash::make($code),

                'activation_code_expires_at' =>
                    now()->addMinutes(
                        self::CODE_EXPIRY_MINUTES
                    ),

                'activation_attempts' => 0,

                'activation_code_sent_at' => now(),
            ])->save();
        } catch (\Throwable $e) {
            Log::error(
                'SELLER ACTIVATION EMAIL FAILED',
                [
                    'seller_id' => $seller->id,
                    'seller_email' => $seller->email,
                    'error' => $e->getMessage(),
                ]
            );

            return back()->with(
                'error',
                'Unable to send activation code.'
            );
        }

        return back()->with(
            'success',
            'Activation code sent successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ONBOARDING
    |--------------------------------------------------------------------------
    */

    public function onboarding()
    {
        $seller = $this->currentSeller();

        return $this->redirectToCurrentStep($seller);
    }

    /*
    |--------------------------------------------------------------------------
    | APPLICATION SUMMARY
    |--------------------------------------------------------------------------
    */

    public function applicationSummary()
    {
        $seller = $this->currentSeller();

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        | application-summary.blade.php missing હોય તો application-review
        | પર fallback કરવામાં આવશે.
        */

        $summaryView = resource_path(
            'views/seller/application-summary.blade.php'
        );

        if (is_file($summaryView)) {
            return view(
                'seller.application-summary',
                compact('seller')
            );
        }

        return view(
            'seller.application-review',
            $this->stepData($seller, 6)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | APPLICATION
    |--------------------------------------------------------------------------
    */

    public function application()
    {
        $seller = $this->currentSeller();

        return view(
            'seller.application',
            compact('seller')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DOCUMENT CHECKLIST
    |--------------------------------------------------------------------------
    */

    public function documentChecklist()
    {
        $seller = $this->currentSeller();

        if (!$seller->email_verified_at) {
            return redirect()
                ->route('seller.verification.email')
                ->with(
                    'error',
                    'Please verify your email first.'
                );
        }

        return view(
            'seller.documents',
            $this->stepData($seller, 2)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN NOTIFICATION
    |--------------------------------------------------------------------------
    */

    private function notifyAdmin(
        SellerProfile $seller
    ): bool {
        $adminEmail = 'smartbasket2442@gmail.com';

        try {
            $seller->refresh();

            $view = resource_path(
                'views/emails/seller-application.blade.php'
            );

            if (!is_file($view)) {
                Log::error(
                    'SELLER ADMIN MAIL FAILED: EMAIL VIEW NOT FOUND',
                    [
                        'seller_id' => $seller->id,
                        'view' => $view,
                    ]
                );

                $seller->forceFill([
                    'admin_notification_status' => 'failed',
                    'admin_notification_failed_at' => now(),
                ])->save();

                return false;
            }

            Mail::send(
                'emails.seller-application',
                [
                    'seller' => $seller,
                ],
                function ($message) use (
                    $seller,
                    $adminEmail
                ) {
                    $message
                        ->from(
                            config(
                                'mail.from.address',
                                'smartbasket2442@gmail.com'
                            ),
                            config(
                                'mail.from.name',
                                'SMART BASKET PREMIUM'
                            )
                        )
                        ->to($adminEmail)
                        ->subject(
                            'SMART BASKET - New Seller Application #'
                            . $seller->id
                        );

                    $attachments = [
                        'business_certificate_path' =>
                            'business-certificate',

                        'aadhaar_document_path' =>
                            'aadhaar',

                        'pan_document_path' =>
                            'pan',

                        'shop_proof_path' =>
                            'shop-proof',

                        'bank_proof_path' =>
                            'bank-proof',
                    ];

                    foreach (
                        $attachments as $field => $label
                    ) {
                        if (
                            !empty($seller->{$field}) &&
                            Storage::disk('public')->exists(
                                $seller->{$field}
                            )
                        ) {
                            $file = Storage::disk('public')->path(
                                $seller->{$field}
                            );

                            $extension = pathinfo(
                                $file,
                                PATHINFO_EXTENSION
                            );

                            $message->attach(
                                $file,
                                [
                                    'as' =>
                                        'seller-' .
                                        $seller->id .
                                        '-' .
                                        $label .
                                        '.' .
                                        $extension,
                                ]
                            );
                        }
                    }
                }
            );

            $seller->forceFill([
                'admin_notification_status' => 'sent',
                'admin_notification_sent_at' => now(),
                'admin_notification_failed_at' => null,
            ])->save();

            Log::info(
                'SELLER ADMIN MAIL SENT SUCCESSFULLY',
                [
                    'seller_id' => $seller->id,
                    'admin_email' => $adminEmail,
                ]
            );

            return true;
        } catch (\Throwable $e) {
            Log::error(
                'SELLER ADMIN MAIL FAILED',
                [
                    'seller_id' => $seller->id,
                    'admin_email' => $adminEmail,
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

            try {
                $seller->forceFill([
                    'admin_notification_status' => 'failed',
                    'admin_notification_failed_at' => now(),
                ])->save();
            } catch (\Throwable $ignored) {
                // Prevent secondary database error from masking
                // the original mail error.
            }

            return false;
        }
    }
}