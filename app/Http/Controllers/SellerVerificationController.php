<?php

namespace App\Http\Controllers;

use App\Mail\SellerApplicationSubmittedMail;
use App\Mail\SellerVerificationCodeMail;
use App\Models\SellerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerVerificationController extends Controller
{
    private const ADMIN_EMAIL = 'smartbasket2442@gmail.com';
    private const MAX_ATTEMPTS = 5;
    private const CODE_EXPIRY_MINUTES = 10;
    private const RESEND_COOLDOWN_SECONDS = 60;

    private const DOCUMENTS = [
        'business_certificate' => 'business_certificate_path',
        'aadhaar_document' => 'aadhaar_document_path',
        'pan_document' => 'pan_document_path',
        'shop_proof' => 'shop_proof_path',
        'bank_proof' => 'bank_proof_path',
    ];

    private function currentSeller(): SellerProfile
    {
        abort_unless(session('seller_login') && session('seller_id'), 403, 'Please login as seller first.');

        return SellerProfile::findOrFail((int) session('seller_id'));
    }

    private function stepData(SellerProfile $seller, int $step): array
    {
        return ['seller' => $seller, 'currentStep' => $step, 'totalSteps' => 6];
    }

    private function stepForSeller(SellerProfile $seller): int
    {
        if (!$seller->isEmailVerified()) {
            return 1;
        }

        if (!$seller->hasRequiredDocuments()) {
            return 2;
        }

        if (!$seller->isAadhaarVerified()) {
            return 3;
        }

        if (!$seller->hasBusinessDetails()) {
            return 4;
        }

        if (!$seller->hasBankDetails()) {
            return 5;
        }

        return 6;
    }

    private function isEditing(): bool
    {
        return session('seller_verification_edit_mode') === true;
    }

    private function enableEditMode(Request $request): void
    {
        if ($request->boolean('edit')) {
            session(['seller_verification_edit_mode' => true]);
        }
    }

    private function clearEditMode(): void
    {
        session()->forget('seller_verification_edit_mode');
    }

    private function redirectToStep(SellerProfile $seller)
    {
        return match ($this->stepForSeller($seller)) {
            1 => redirect()->route('seller.verification.email'),
            2 => redirect()->route('seller.verification.documents'),
            3 => redirect()->route('seller.verification.aadhaar'),
            4 => redirect()->route('seller.verification.business-details'),
            5 => redirect()->route('seller.verification.bank-details'),
            default => redirect()->route('seller.verification.review'),
        };
    }

    public function index()
    {
        $seller = $this->currentSeller();

        if ($seller->isApplicationSubmitted()) {
            return redirect()->route('seller.verification.status');
        }

        return $this->redirectToStep($seller);
    }

    public function saveStep(Request $request)
    {
        $seller = $this->currentSeller();
        $step = $request->validate(['step' => ['required', 'integer', 'between:1,6']])['step'];

        if ((int) $step > $this->stepForSeller($seller)) {
            return back()->with('error', 'Please complete the previous steps before continuing.');
        }

        $seller->update(['onboarding_step' => min((int) $step + 1, 6)]);

        return $this->redirectToStep($seller)->with('success', 'Progress saved successfully.');
    }

    public function onboarding()
    {
        return $this->index();
    }

    public function emailForm(Request $request)
    {
        $seller = $this->currentSeller();
        $this->enableEditMode($request);

        if ($seller->isApplicationSubmitted()) {
            return redirect()->route('seller.verification.status');
        }

        return view('seller.verification.email', $this->stepData($seller, 1));
    }

    public function sendEmailCode()
    {
        $seller = $this->currentSeller();

        if ($seller->isEmailVerified()) {
            return back()->with('info', 'Your email is already verified.');
        }

        if (!$seller->email) {
            return back()->with('error', 'Seller email address is missing.');
        }

        if ($seller->email_code_sent_at && $seller->email_code_sent_at->gt(now()->subSeconds(self::RESEND_COOLDOWN_SECONDS))) {
            return back()->with('error', 'Please wait before requesting another verification code.');
        }

        $code = (string) random_int(1000000000000000, 9999999999999999);
        $expiresAt = now()->addMinutes(self::CODE_EXPIRY_MINUTES);
        $hash = Hash::make($code);

        try {
            Mail::to($seller->email)->send(new SellerVerificationCodeMail($code, 'email'));

            $seller->forceFill([
                'email_code_hash' => $hash,
                'email_verification_code_hash' => $hash,
                'email_code_expires_at' => $expiresAt,
                'email_verification_expires_at' => $expiresAt,
                'email_code_attempts' => 0,
                'email_verification_attempts' => 0,
                'email_code_sent_at' => now(),
                'verification_status' => SellerProfile::STATUS_EMAIL_VERIFICATION,
                'onboarding_step' => 1,
            ])->save();
        } catch (\Throwable $exception) {
            Log::error('Seller email verification failed.', ['seller_id' => $seller->id]);

            return back()->with('error', 'Unable to send verification email.');
        }

        return back()->with('success', 'A 16-digit verification code has been sent to ' . $seller->email . '.');
    }

    public function verifyEmailCode(Request $request)
    {
        $seller = $this->currentSeller();
        $code = $request->validate(['code' => ['required', 'digits:16']])['code'];

        if ($seller->isEmailVerified()) {
            return redirect()->route('seller.verification.documents')->with('info', 'Email is already verified.');
        }

        $hash = $seller->email_code_hash ?: $seller->email_verification_code_hash;
        $expiresAt = $seller->email_code_expires_at ?: $seller->email_verification_expires_at;
        $attempts = max((int) $seller->email_code_attempts, (int) $seller->email_verification_attempts);

        if (!$hash || !$expiresAt || now()->greaterThan($expiresAt)) {
            $seller->forceFill([
                'email_code_hash' => null,
                'email_verification_code_hash' => null,
                'email_code_expires_at' => null,
                'email_verification_expires_at' => null,
                'email_code_attempts' => 0,
                'email_verification_attempts' => 0,
            ])->save();

            return back()->with('error', 'Verification code expired. Please request a new code.');
        }

        if ($attempts >= self::MAX_ATTEMPTS) {
            return back()->with('error', 'Too many invalid attempts. Please request a new code.');
        }

        if (!Hash::check((string) $code, (string) $hash)) {
            $seller->forceFill([
                'email_code_attempts' => $attempts + 1,
                'email_verification_attempts' => $attempts + 1,
            ])->save();

            return back()->with('error', 'Invalid verification code.');
        }

        $seller->forceFill([
            'email_verified_at' => now(),
            'email_code_hash' => null,
            'email_verification_code_hash' => null,
            'email_code_expires_at' => null,
            'email_verification_expires_at' => null,
            'email_code_attempts' => 0,
            'email_verification_attempts' => 0,
            'onboarding_step' => 2,
            'verification_status' => SellerProfile::STATUS_DOCUMENTS_PENDING,
        ])->save();

        session(['seller_email_verified' => true]);

        if ($this->isEditing()) {
            $this->clearEditMode();

            return redirect()->route('seller.verification.review')->with('success', 'Email updated successfully.');
        }

        return redirect()->route('seller.verification.documents')->with('success', 'Email verified successfully. Continue to Step 2.');
    }

    public function documentsForm(Request $request)
    {
        $seller = $this->currentSeller();
        $this->enableEditMode($request);

        if (!$seller->isEmailVerified()) {
            return redirect()->route('seller.verification.email')->with('error', 'Please complete Step 1 first.');
        }

        return view('seller.documents', $this->stepData($seller, 2));
    }

    public function uploadDocument(Request $request)
    {
        $seller = $this->currentSeller();

        if (!$seller->isEmailVerified()) {
            return redirect()->route('seller.verification.email');
        }

        $rules = [];
        foreach (array_keys(self::DOCUMENTS) as $input) {
            $rules[$input] = ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'];
        }

        $request->validate($rules);
        $data = [];
        $missing = [];

        foreach (self::DOCUMENTS as $input => $column) {
            if ($request->hasFile($input)) {
                $oldPath = $seller->{$column};
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }

                $data[$column] = $request->file($input)->store("seller-documents/{$seller->id}", 'public');
                $timestampColumn = $this->documentTimestampColumn($column);
                if ($timestampColumn) {
                    $data[$timestampColumn] = now();
                }
            } elseif (!$seller->{$column}) {
                $missing[] = str_replace('_', ' ', $input);
            }
        }

        if ($missing) {
            return back()->withInput()->with('error', 'Required documents missing: ' . implode(', ', $missing) . '.');
        }

        $seller->forceFill($data + [
            'onboarding_step' => 3,
            'verification_status' => SellerProfile::STATUS_AADHAAR_VERIFICATION,
        ])->save();

        if ($this->isEditing()) {
            $this->clearEditMode();

            return redirect()->route('seller.verification.review')->with('success', 'Documents updated successfully.');
        }

        return redirect()->route('seller.verification.aadhaar')->with('success', 'Documents saved successfully. Continue to Step 3.');
    }

    private function documentTimestampColumn(string $column): ?string
    {
        return match ($column) {
            'business_certificate_path' => 'business_certificate_uploaded_at',
            'aadhaar_document_path' => 'aadhaar_document_uploaded_at',
            'pan_document_path' => 'pan_document_uploaded_at',
            'shop_proof_path' => 'shop_proof_uploaded_at',
            'bank_proof_path' => 'bank_proof_uploaded_at',
            default => null,
        };
    }

    public function aadhaarForm(Request $request)
    {
        $seller = $this->currentSeller();
        $this->enableEditMode($request);

        if (!$seller->isEmailVerified()) {
            return redirect()->route('seller.verification.email');
        }

        if (!$seller->hasRequiredDocuments()) {
            return redirect()->route('seller.verification.documents');
        }

        return view('seller.verification.aadhaar', $this->stepData($seller, 3));
    }

    public function startAadhaar()
    {
        $seller = $this->currentSeller();

        if (!$seller->hasRequiredDocuments()) {
            return redirect()->route('seller.verification.documents');
        }

        $seller->forceFill([
            'verification_reference_id' => $seller->verification_reference_id ?: 'SB-AADHAAR-' . strtoupper(Str::random(12)),
            'verification_status' => SellerProfile::STATUS_AADHAAR_VERIFICATION,
            'onboarding_step' => 3,
        ])->save();

        return back()->with('success', 'Demo Aadhaar verification started.');
    }

    public function verifyAadhaar(Request $request)
    {
        $seller = $this->currentSeller();
        $data = $request->validate(['aadhaar_number' => ['required', 'digits:12']]);

        if (!$seller->hasRequiredDocuments()) {
            return redirect()->route('seller.verification.documents');
        }

        $seller->forceFill([
            'aadhaar_number' => $data['aadhaar_number'],
            'aadhaar_verified' => true,
            'aadhaar_verified_at' => now(),
            'verification_status' => SellerProfile::STATUS_BUSINESS_DETAILS,
            'onboarding_step' => 4,
        ])->save();

        if ($this->isEditing()) {
            $this->clearEditMode();

            return redirect()->route('seller.verification.review')->with('success', 'Aadhaar details updated successfully.');
        }

        return redirect()->route('seller.verification.business-details')->with('success', 'Demo Aadhaar verification completed. Continue to Step 4.');
    }

    public function businessDetails(Request $request)
    {
        $seller = $this->currentSeller();
        $this->enableEditMode($request);

        if (!$seller->isEmailVerified() || !$seller->hasRequiredDocuments() || !$seller->isAadhaarVerified()) {
            return $this->redirectToStep($seller);
        }

        return view('seller.business-details', $this->stepData($seller, 4));
    }

    public function updateBusinessDetails(Request $request)
    {
        $seller = $this->currentSeller();
        $data = $request->validate([
            'business_type' => ['required', 'string', 'max:100'],
            'business_name' => ['required', 'string', 'max:255'],
            'business_address' => ['required', 'string', 'max:2000'],
            'business_city' => ['required', 'string', 'max:100'],
            'business_state' => ['required', 'string', 'max:100'],
            'business_pincode' => ['required', 'digits:6'],
            'gst_number' => ['nullable', 'string', 'max:50'],
            'pan_number' => ['required', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/i'],
            'udyam_number' => ['required', 'string', 'max:100'],
        ]);

        $seller->forceFill([
            'business_type' => trim($data['business_type']),
            'business_name' => trim($data['business_name']),
            'business_address' => trim($data['business_address']),
            'business_city' => trim($data['business_city']),
            'business_state' => trim($data['business_state']),
            'business_pincode' => trim($data['business_pincode']),
            'city' => trim($data['business_city']),
            'state' => trim($data['business_state']),
            'pincode' => trim($data['business_pincode']),
            'gst_number' => filled($data['gst_number'] ?? null) ? strtoupper(trim($data['gst_number'])) : null,
            'pan_number' => strtoupper(trim($data['pan_number'])),
            'udyam_number' => strtoupper(trim($data['udyam_number'])),
            'onboarding_step' => 5,
            'verification_status' => SellerProfile::STATUS_BANK_DETAILS,
        ])->save();

        if ($this->isEditing()) {
            $this->clearEditMode();

            return redirect()->route('seller.verification.review')->with('success', 'Business details updated successfully.');
        }

        return redirect()->route('seller.verification.bank-details')->with('success', 'Business details saved successfully. Continue to Step 5.');
    }

    public function bankDetails(Request $request)
    {
        $seller = $this->currentSeller();
        $this->enableEditMode($request);

        if (!$seller->isEmailVerified() || !$seller->hasRequiredDocuments() || !$seller->isAadhaarVerified() || !$seller->hasBusinessDetails()) {
            return $this->redirectToStep($seller);
        }

        return view('seller.bank-details', $this->stepData($seller, 5));
    }

    public function updateBankDetails(Request $request)
    {
        $seller = $this->currentSeller();
        $data = $request->validate([
            'bank_account_holder' => ['required', 'string', 'max:255'],
            'bank_account_number' => ['required', 'string', 'max:50', 'confirmed'],
            'bank_ifsc' => ['required', 'regex:/^[A-Z]{4}0[A-Z0-9]{6}$/i'],
            'bank_name' => ['required', 'string', 'max:255'],
            'bank_branch' => ['required', 'string', 'max:255'],
            'bank_proof' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $values = [
            'bank_account_holder' => trim($data['bank_account_holder']),
            'bank_account_holder_name' => trim($data['bank_account_holder']),
            'bank_account_number' => trim($data['bank_account_number']),
            'bank_ifsc' => strtoupper(trim($data['bank_ifsc'])),
            'bank_name' => trim($data['bank_name']),
            'bank_branch' => trim($data['bank_branch']),
            'onboarding_step' => 6,
            'verification_status' => SellerProfile::STATUS_BANK_DETAILS,
        ];

        if ($request->hasFile('bank_proof')) {
            if ($seller->bank_proof_path && Storage::disk('public')->exists($seller->bank_proof_path)) {
                Storage::disk('public')->delete($seller->bank_proof_path);
            }
            $values['bank_proof_path'] = $request->file('bank_proof')->store("seller-documents/{$seller->id}", 'public');
            $values['bank_proof_uploaded_at'] = now();
        }

        $seller->forceFill($values)->save();
        $this->clearEditMode();

        return redirect()->route('seller.verification.review')->with('success', 'Bank details saved successfully. Continue to Step 6.');
    }

    public function review()
    {
        $seller = $this->currentSeller();
        $errors = $this->applicationErrors($seller);

        if ($errors) {
            return $this->redirectToStep($seller)->with('error', $errors[0]);
        }

        return view('seller.application-review', $this->stepData($seller, 6));
    }

    private function applicationErrors(SellerProfile $seller): array
    {
        $errors = [];
        if (!$seller->isEmailVerified()) $errors[] = 'Email verification is incomplete.';
        if (!$seller->hasRequiredDocuments()) $errors[] = 'All five required documents must be uploaded.';
        if (!$seller->isAadhaarVerified()) $errors[] = 'Aadhaar demo verification is incomplete.';
        if (!$seller->hasBusinessDetails()) $errors[] = 'Business details are incomplete.';
        if (!$seller->hasBankDetails()) $errors[] = 'Bank details are incomplete.';
        return $errors;
    }

    public function submitApplication()
    {
        $seller = $this->currentSeller();

        if ($seller->isPendingAdminReview() || $seller->isApproved()) {
            return redirect()->route('seller.verification.status')->with('info', 'Your application has already been submitted.');
        }

        $errors = $this->applicationErrors($seller);
        if ($errors) {
            return back()->with('error', implode(' ', $errors));
        }

        $seller->forceFill([
            'verification_status' => SellerProfile::STATUS_PENDING_ADMIN_REVIEW,
            'application_submitted_at' => now(),
            'verification_submitted_at' => now(),
            'admin_reviewed_at' => null,
            'admin_reviewed_by' => null,
            'rejection_reason' => null,
            'approved_at' => null,
            'admin_notification_status' => 'pending',
            'onboarding_step' => 6,
        ])->save();

        try {
            Mail::to(self::ADMIN_EMAIL)->send(new SellerApplicationSubmittedMail($seller->fresh()));
            $seller->forceFill([
                'admin_notification_status' => 'sent',
                'admin_notification_sent_at' => now(),
                'admin_notification_failed_at' => null,
            ])->save();
        } catch (\Throwable $exception) {
            Log::error('Seller application email failed.', ['seller_id' => $seller->id]);
            $seller->forceFill([
                'admin_notification_status' => 'failed',
                'admin_notification_failed_at' => now(),
            ])->save();
        }

        $this->clearEditMode();

        return redirect()->route('seller.verification.status')->with('success', 'Your Seller Partner application has been submitted successfully.');
    }

    public function status()
    {
        return view('seller.verification.status', ['seller' => $this->currentSeller()]);
    }

    public function restartApplication()
    {
        $seller = $this->currentSeller();

        foreach (array_values(self::DOCUMENTS) as $column) {
            if ($seller->{$column} && Storage::disk('public')->exists($seller->{$column})) {
                Storage::disk('public')->delete($seller->{$column});
            }
        }

        $seller->forceFill([
            'email_verified_at' => null,
            'email_code_hash' => null,
            'email_verification_code_hash' => null,
            'email_code_expires_at' => null,
            'email_verification_expires_at' => null,
            'email_code_attempts' => 0,
            'email_verification_attempts' => 0,
            'email_code_sent_at' => null,
            'business_certificate_path' => null,
            'aadhaar_document_path' => null,
            'pan_document_path' => null,
            'shop_proof_path' => null,
            'bank_proof_path' => null,
            'aadhaar_number' => null,
            'aadhaar_verified' => false,
            'aadhaar_verified_at' => null,
            'business_type' => null,
            'business_name' => null,
            'business_address' => null,
            'business_city' => null,
            'business_state' => null,
            'business_pincode' => null,
            'pan_number' => null,
            'udyam_number' => null,
            'bank_account_holder' => null,
            'bank_account_holder_name' => null,
            'bank_account_number' => null,
            'bank_ifsc' => null,
            'bank_name' => null,
            'bank_branch' => null,
            'application_submitted_at' => null,
            'verification_submitted_at' => null,
            'verification_status' => SellerProfile::STATUS_DRAFT,
            'onboarding_step' => 1,
            'admin_notification_status' => null,
        ])->save();

        return redirect()->route('seller.verification.email')->with('success', 'Your previous application data has been cleared.');
    }

    public function applicationSummary()
    {
        $seller = $this->currentSeller();
        return view('seller.application-summary', [
            'seller' => $seller,
            'applicationId' => $seller->verification_reference_id ?: sprintf('SB-%08d', $seller->id),
        ]);
    }

    public function application()
    {
        return redirect()->route('seller.verification.review');
    }

    public function documentChecklist()
    {
        return redirect()->route('seller.verification.documents');
    }

    public function viewApplicationDocument(string $document)
    {
        $seller = $this->currentSeller();
        $field = [
            'business-certificate' => 'business_certificate_path',
            'aadhaar' => 'aadhaar_document_path',
            'pan' => 'pan_document_path',
            'shop-proof' => 'shop_proof_path',
            'bank-proof' => 'bank_proof_path',
        ][$document] ?? null;

        abort_unless($field && $seller->{$field} && Storage::disk('public')->exists($seller->{$field}), 404);
        return response()->file(Storage::disk('public')->path($seller->{$field}));
    }

    public function activationForm()
    {
        $seller = $this->currentSeller();

        abort_unless($seller->isApproved(), 403, 'Seller application is not approved.');

        return view('seller.verification.activation', compact('seller'));
    }

    public function verifyActivation(Request $request)
    {
        $seller = $this->currentSeller();
        abort_unless($seller->isApproved(), 403, 'Seller application is not approved.');

        $code = $request->validate(['code' => ['required', 'digits:16']])['code'];
        $attempts = (int) $seller->activation_attempts;

        if (!$seller->activation_code_hash || !$seller->activation_code_expires_at || now()->greaterThan($seller->activation_code_expires_at)) {
            return back()->with('error', 'Activation code expired. Please request a new code.');
        }

        if ($attempts >= self::MAX_ATTEMPTS) {
            return back()->with('error', 'Too many invalid attempts.');
        }

        if (!Hash::check((string) $code, (string) $seller->activation_code_hash)) {
            $seller->increment('activation_attempts');
            return back()->with('error', 'Invalid activation code.');
        }

        $seller->forceFill([
            'activation_code_hash' => null,
            'activation_code_expires_at' => null,
            'activation_attempts' => 0,
            'activation_verified_at' => now(),
        ])->save();

        return redirect()->route('seller.dashboard')->with('success', 'Seller account activated successfully.');
    }

    public function resendActivationCode()
    {
        $seller = $this->currentSeller();
        abort_unless($seller->isApproved(), 403, 'Seller application is not approved.');

        $code = (string) random_int(1000000000000000, 9999999999999999);

        try {
            Mail::raw("Your SMART BASKET seller activation code is: {$code}", function ($message) use ($seller) {
                $message->to($seller->email)->subject('SMART BASKET - Seller Activation Code');
            });
        } catch (\Throwable $exception) {
            Log::error('Seller activation email failed.', ['seller_id' => $seller->id]);
            return back()->with('error', 'Unable to send activation code.');
        }

        $seller->forceFill([
            'activation_code_hash' => Hash::make($code),
            'activation_code_expires_at' => now()->addMinutes(self::CODE_EXPIRY_MINUTES),
            'activation_attempts' => 0,
            'activation_code_sent_at' => now(),
        ])->save();

        return back()->with('success', 'Activation code sent successfully.');
    }
}
