@php
    $steps = [
        1 => 'Email',
        2 => 'Documents',
        3 => 'Aadhaar',
        4 => 'Business',
        5 => 'Bank',
        6 => 'Review',
    ];

    $currentStep = (int) ($currentStep ?? request()->integer('step', 1));
    $currentStep = max(1, min(6, $currentStep));

    /*
    |--------------------------------------------------------------------------
    | STEP COMPLETION
    |--------------------------------------------------------------------------
    */

    $emailCompleted = !empty($seller->email_verified_at);

    $documentsCompleted =
        !empty($seller->business_certificate_path) &&
        !empty($seller->aadhaar_document_path);

    $aadhaarCompleted = !empty($seller->aadhaar_verified_at);

    $businessCompleted =
        !empty($seller->business_type) &&
        !empty($seller->pan_number) &&
        !empty($seller->udyam_number);

    $bankCompleted =
        !empty($seller->bank_account_holder) &&
        !empty($seller->bank_account_number) &&
        !empty($seller->bank_ifsc) &&
        !empty($seller->bank_name);

    $completedSteps = [
        1 => $emailCompleted,
        2 => $documentsCompleted,
        3 => $aadhaarCompleted,
        4 => $businessCompleted,
        5 => $bankCompleted,
    ];

    /*
    |--------------------------------------------------------------------------
    | SAFE MASKING
    |--------------------------------------------------------------------------
    */

    $maskedPan = !empty($seller->pan_number)
        ? substr($seller->pan_number, 0, 5) . '****' . substr($seller->pan_number, -1)
        : 'Not provided';

    $maskedBank = !empty($seller->bank_account_number)
        ? 'XXXX XXXX ' . substr($seller->bank_account_number, -4)
        : 'Not provided';
@endphp

@extends('seller.partials.premium-layout')

@section('title', 'Seller Verification & KYC')

@section('content')

<div class="seller-verification-shell">

    <div class="seller-verification-card">

        {{-- =========================================================
             HEADER
        ========================================================== --}}

        <div class="verification-header">

            <div>
                <div class="eyebrow">
                    SELLER PARTNER PROGRAM
                </div>

                <h1>
                    Verification &amp; KYC
                </h1>

                <p class="header-description">
                    Complete all 6 steps to activate your SmartBasket seller account.
                </p>
            </div>

            <div class="step-pill">
                Step {{ $currentStep }} / 6
            </div>

        </div>


        {{-- =========================================================
             PROGRESS STEPPER
        ========================================================== --}}

        <div class="stepper">

            @foreach($steps as $stepNumber => $label)

                @php
                    $isCurrent = $stepNumber === $currentStep;

                    /*
                     * Previous steps are accessible.
                     * Future steps remain locked.
                     */
                    $isLocked = $stepNumber > $currentStep;

                    $isComplete =
                        $stepNumber < $currentStep ||
                        ($stepNumber <= 5 && ($completedSteps[$stepNumber] ?? false));

                    $statusClass = '';

                    if ($isCurrent) {
                        $statusClass = 'active';
                    } elseif ($isComplete) {
                        $statusClass = 'complete';
                    } elseif ($isLocked) {
                        $statusClass = 'locked';
                    }
                @endphp

                <button
                    type="button"
                    class="step-item {{ $statusClass }}"
                    data-step-button="{{ $stepNumber }}"
                    data-target-step="{{ $stepNumber }}"
                    {{ $isLocked ? 'disabled' : '' }}
                >

                    <span class="step-number">

                        @if($isComplete && !$isCurrent)
                            ✓
                        @else
                            {{ $stepNumber }}
                        @endif

                    </span>

                    <span class="step-label">
                        {{ $label }}
                    </span>

                </button>

            @endforeach

        </div>


        {{-- =========================================================
             FLASH MESSAGES
        ========================================================== --}}

        @if(session('success'))

            <div class="global-alert success-alert">
                <span class="alert-icon">✓</span>
                <span>{{ session('success') }}</span>
            </div>

        @endif


        @if(session('error'))

            <div class="global-alert error-alert">
                <span class="alert-icon">!</span>
                <span>{{ session('error') }}</span>
            </div>

        @endif


        @if($errors->any())

            <div class="global-alert error-alert">

                <span class="alert-icon">!</span>

                <div>
                    <strong>Please fix the following:</strong>

                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>

        @endif


        {{-- =========================================================
             PANELS
        ========================================================== --}}

        <div class="verification-panels">


            {{-- =====================================================
                 STEP 1 — EMAIL
            ====================================================== --}}

            <section
                class="verification-panel {{ $currentStep === 1 ? 'active' : '' }}"
                data-panel="1"
            >

                <div class="panel-header">

                    <div>
                        <div class="panel-kicker">
                            STEP 01 · SECURE ACCESS
                        </div>

                        <h2 class="panel-title">
                            Verify your seller email
                        </h2>
                    </div>

                    <span class="status-tag {{ $emailCompleted ? 'green' : 'amber' }}">
                        {{ $emailCompleted ? 'Verified' : 'Required' }}
                    </span>

                </div>

                <p class="muted">
                    A secure 16-digit verification code will be sent to your registered
                    seller email address.
                </p>


                <div class="surface-box">

                    <form
                        method="POST"
                        action="{{ route('seller.verification.email.send') }}"
                        class="stacked-form"
                    >

                        @csrf

                        <div class="field-block">

                            <label class="form-label">
                                Seller Email Address
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $seller->email ?? '') }}"
                                class="form-input"
                                autocomplete="email"
                                required
                            >

                        </div>

                        <button
                            type="submit"
                            class="primary-button"
                        >
                            Send Verification Code
                        </button>

                    </form>

                </div>


                <div class="surface-box alt-box">

                    <form
                        method="POST"
                        action="{{ route('seller.verification.email.verify') }}"
                        class="stacked-form"
                    >

                        @csrf

                        <div class="field-block">

                            <label class="form-label">
                                16-Digit Verification Code
                            </label>

                            <input
                                type="text"
                                name="code"
                                class="form-input code-input"
                                inputmode="numeric"
                                pattern="[0-9]{16}"
                                maxlength="16"
                                placeholder="0000000000000000"
                                required
                            >

                        </div>

                        <button
                            type="submit"
                            class="success-button"
                        >
                            Verify Email
                        </button>

                    </form>

                </div>

            </section>


            {{-- =====================================================
                 STEP 2 — DOCUMENTS
            ====================================================== --}}

            <section
                class="verification-panel {{ $currentStep === 2 ? 'active' : '' }}"
                data-panel="2"
            >

                <div class="panel-header">

                    <div>
                        <div class="panel-kicker">
                            STEP 02 · DOCUMENT CHECK
                        </div>

                        <h2 class="panel-title">
                            Upload your KYC documents
                        </h2>
                    </div>

                    <span class="status-tag {{ $documentsCompleted ? 'green' : 'amber' }}">
                        {{ $documentsCompleted ? 'Complete' : 'Required' }}
                    </span>

                </div>

                <p class="muted">
                    Upload your business certificate and Aadhaar document.
                    Files are stored privately for authorized SmartBasket verification.
                </p>


                <form
                    method="POST"
                    action="{{ route('seller.verification.documents.upload') }}"
                    enctype="multipart/form-data"
                    class="stacked-form"
                >

                    @csrf


                    <div class="upload-grid">


                        {{-- BUSINESS CERTIFICATE --}}

                        <div class="upload-box">

                            <div class="upload-header">

                                <span class="upload-icon">
                                    <i class="fa-solid fa-file-lines"></i>
                                </span>

                                <div>
                                    <strong>Business Certificate</strong>

                                    <small>
                                        Required document
                                    </small>
                                </div>

                            </div>

                            <input
                                id="business_certificate"
                                type="file"
                                name="business_certificate"
                                accept=".pdf,.jpg,.jpeg,.png,.webp"
                                class="form-input file-input"
                                {{ empty($seller->business_certificate_path) ? 'required' : '' }}
                            >

                            <div class="file-help">
                                PDF, JPG, JPEG, PNG or WEBP · Max 5 MB
                            </div>

                            @if(!empty($seller->business_certificate_path))

                                <div class="uploaded-status">
                                    ✓ Business certificate already uploaded
                                </div>

                            @endif

                        </div>


                        {{-- AADHAAR DOCUMENT --}}

                        <div class="upload-box">

                            <div class="upload-header">

                                <span class="upload-icon blue-icon">
                                    <i class="fa-solid fa-id-card"></i>
                                </span>

                                <div>
                                    <strong>Aadhaar Document</strong>

                                    <small>
                                        Required document
                                    </small>
                                </div>

                            </div>

                            <input
                                id="aadhaar_document"
                                type="file"
                                name="aadhaar_document"
                                accept=".pdf,.jpg,.jpeg,.png,.webp"
                                class="form-input file-input"
                                {{ empty($seller->aadhaar_document_path) ? 'required' : '' }}
                            >

                            <div class="file-help">
                                PDF, JPG, JPEG, PNG or WEBP · Max 5 MB
                            </div>

                            @if(!empty($seller->aadhaar_document_path))

                                <div class="uploaded-status">
                                    ✓ Aadhaar document already uploaded
                                </div>

                            @endif

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="primary-button"
                    >
                        Upload Securely &amp; Continue →
                    </button>

                </form>

            </section>


            {{-- =====================================================
                 STEP 3 — AADHAAR
            ====================================================== --}}

            <section
                class="verification-panel {{ $currentStep === 3 ? 'active' : '' }}"
                data-panel="3"
            >

                <div class="panel-header">

                    <div>
                        <div class="panel-kicker">
                            STEP 03 · IDENTITY VERIFICATION
                        </div>

                        <h2 class="panel-title">
                            Verify your Aadhaar
                        </h2>
                    </div>

                    <span class="status-tag {{ $aadhaarCompleted ? 'green' : 'blue' }}">
                        {{ $aadhaarCompleted ? 'Verified' : 'Secure' }}
                    </span>

                </div>

                <p class="muted">
                    Complete Aadhaar verification through the configured authorized
                    verification workflow.
                </p>


                @if(isset($configured) && !$configured)

                    <div class="info-box">

                        <strong>Aadhaar verification service is not configured.</strong>

                        <p>
                            Please configure the authorized verification provider
                            before attempting Aadhaar verification.
                        </p>

                    </div>

                @else

                    <div class="surface-box">

                        <form
                            method="POST"
                            action="{{ route('seller.verification.aadhaar.start') }}"
                            class="stacked-form"
                        >

                            @csrf

                            <div class="field-block">

                                <label class="form-label">
                                    Aadhaar / Provider Reference
                                </label>

                                <input
                                    type="text"
                                    name="aadhaar_identifier"
                                    value="{{ old('aadhaar_identifier', $seller->verification_reference_id ?? '') }}"
                                    class="form-input"
                                    inputmode="numeric"
                                    maxlength="12"
                                    placeholder="Enter Aadhaar number or provider reference"
                                    required
                                >

                                <small class="field-help">
                                    Your Aadhaar number is handled only through the
                                    authorized verification workflow.
                                </small>

                            </div>

                            <button
                                type="submit"
                                class="primary-button"
                            >
                                Start Aadhaar Verification
                            </button>

                        </form>

                    </div>


                    <div class="surface-box alt-box">

                        <form
                            method="POST"
                            action="{{ route('seller.verification.aadhaar.verify') }}"
                            class="stacked-form"
                        >

                            @csrf

                            <div class="field-block">

                                <label class="form-label">
                                    Verification OTP
                                </label>

                                <input
                                    type="text"
                                    name="otp"
                                    class="form-input code-input"
                                    inputmode="numeric"
                                    autocomplete="one-time-code"
                                    maxlength="6"
                                    pattern="[0-9]{4,6}"
                                    placeholder="Enter OTP"
                                    required
                                >

                            </div>

                            <button
                                type="submit"
                                class="success-button"
                            >
                                Verify Aadhaar OTP
                            </button>

                        </form>

                    </div>

                @endif

            </section>


            {{-- =====================================================
                 STEP 4 — BUSINESS
            ====================================================== --}}

            <section
                class="verification-panel {{ $currentStep === 4 ? 'active' : '' }}"
                data-panel="4"
            >

                <div class="panel-header">

                    <div>
                        <div class="panel-kicker">
                            STEP 04 · BUSINESS PROFILE
                        </div>

                        <h2 class="panel-title">
                            Tell us about your business
                        </h2>
                    </div>

                    <span class="status-tag {{ $businessCompleted ? 'green' : 'violet' }}">
                        {{ $businessCompleted ? 'Complete' : 'Legal Details' }}
                    </span>

                </div>

                <p class="muted">
                    Enter your legal business information exactly as it appears
                    on your official documents.
                </p>


                <form
                    method="POST"
                    action="{{ route('seller.verification.business-details.update') }}"
                    class="stacked-form"
                >

                    @csrf
                    @method('PUT')


                    <div class="grid-two">


                        {{-- BUSINESS TYPE --}}

                        <div class="field-block">

                            <label class="form-label">
                                Business Type *
                            </label>

                            <select
                                name="business_type"
                                class="form-input"
                                required
                            >

                                <option value="">
                                    Select business type
                                </option>

                                @foreach([
                                    'Individual Seller',
                                    'Proprietorship',
                                    'Partnership',
                                    'Private Limited',
                                    'LLP',
                                    'Other'
                                ] as $type)

                                    <option
                                        value="{{ $type }}"
                                        @selected(old('business_type', $seller->business_type ?? '') === $type)
                                    >
                                        {{ $type }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- BUSINESS NAME --}}

                        <div class="field-block">

                            <label class="form-label">
                                Business Name
                            </label>

                            <input
                                type="text"
                                name="business_name"
                                value="{{ old('business_name', $seller->business_name ?? $seller->shop_name ?? '') }}"
                                class="form-input"
                                placeholder="Enter business name"
                            >

                        </div>


                        {{-- PAN --}}

                        <div class="field-block">

                            <label class="form-label">
                                PAN Number *
                            </label>

                            <input
                                type="text"
                                name="pan_number"
                                value="{{ old('pan_number', $seller->pan_number ?? '') }}"
                                class="form-input uppercase-input"
                                placeholder="ABCDE1234F"
                                maxlength="10"
                                required
                            >

                        </div>


                        {{-- UDYAM --}}

                        <div class="field-block">

                            <label class="form-label">
                                Udyam Number *
                            </label>

                            <input
                                type="text"
                                name="udyam_number"
                                value="{{ old('udyam_number', $seller->udyam_number ?? '') }}"
                                class="form-input uppercase-input"
                                placeholder="UDYAM-XX-00-0000000"
                                required
                            >

                        </div>


                        {{-- GST --}}

                        <div class="field-block">

                            <label class="form-label">
                                GST Number
                            </label>

                            <input
                                type="text"
                                name="gst_number"
                                value="{{ old('gst_number', $seller->gst_number ?? '') }}"
                                class="form-input uppercase-input"
                                placeholder="Optional GST number"
                            >

                        </div>


                        {{-- ADDRESS --}}

                        <div class="field-block">

                            <label class="form-label">
                                Business Address
                            </label>

                            <textarea
                                name="shop_address"
                                class="form-input"
                                rows="3"
                                placeholder="Street, area, business address"
                            >{{ old('shop_address', $seller->shop_address ?? '') }}</textarea>

                        </div>


                        {{-- CITY --}}

                        <div class="field-block">

                            <label class="form-label">
                                City
                            </label>

                            <input
                                type="text"
                                name="city"
                                value="{{ old('city', $seller->city ?? '') }}"
                                class="form-input"
                            >

                        </div>


                        {{-- STATE --}}

                        <div class="field-block">

                            <label class="form-label">
                                State
                            </label>

                            <input
                                type="text"
                                name="state"
                                value="{{ old('state', $seller->state ?? '') }}"
                                class="form-input"
                            >

                        </div>


                        {{-- PINCODE --}}

                        <div class="field-block">

                            <label class="form-label">
                                Pincode
                            </label>

                            <input
                                type="text"
                                name="pincode"
                                value="{{ old('pincode', $seller->pincode ?? '') }}"
                                class="form-input"
                                inputmode="numeric"
                                maxlength="6"
                            >

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="primary-button"
                    >
                        Save Business Details &amp; Continue →
                    </button>

                </form>

            </section>


            {{-- =====================================================
                 STEP 5 — BANK
            ====================================================== --}}

            <section
                class="verification-panel {{ $currentStep === 5 ? 'active' : '' }}"
                data-panel="5"
            >

                <div class="panel-header">

                    <div>
                        <div class="panel-kicker">
                            STEP 05 · PAYOUT SETUP
                        </div>

                        <h2 class="panel-title">
                            Add your bank details
                        </h2>
                    </div>

                    <span class="status-tag {{ $bankCompleted ? 'green' : 'green' }}">
                        {{ $bankCompleted ? 'Complete' : 'Payout Setup' }}
                    </span>

                </div>

                <p class="muted">
                    These details are used for seller payouts. Your account number
                    is never displayed in full after saving.
                </p>


                <form
                    method="POST"
                    action="{{ route('seller.verification.bank-details.update') }}"
                    enctype="multipart/form-data"
                    class="stacked-form"
                    id="bankDetailsForm"
                >

                    @csrf
                    @method('PUT')


                    <div class="grid-two">


                        {{-- ACCOUNT HOLDER --}}

                        <div class="field-block">

                            <label class="form-label">
                                Account Holder Name *
                            </label>

                            <input
                                type="text"
                                name="bank_account_holder"
                                value="{{ old('bank_account_holder', $seller->bank_account_holder ?? '') }}"
                                class="form-input"
                                autocomplete="name"
                                required
                            >

                        </div>


                        {{-- BANK NAME --}}

                        <div class="field-block">

                            <label class="form-label">
                                Bank Name *
                            </label>

                            <input
                                type="text"
                                name="bank_name"
                                value="{{ old('bank_name', $seller->bank_name ?? '') }}"
                                class="form-input"
                                autocomplete="organization"
                                required
                            >

                        </div>


                        {{-- ACCOUNT NUMBER --}}

                        <div class="field-block">

                            <label class="form-label">
                                Account Number *
                            </label>

                            <input
                                type="password"
                                name="bank_account_number"
                                value=""
                                class="form-input"
                                inputmode="numeric"
                                autocomplete="new-password"
                                placeholder="{{ !empty($seller->bank_account_number) ? 'Enter again to replace' : 'Enter account number' }}"
                                required
                            >

                            @if(!empty($seller->bank_account_number))

                                <small class="field-help">
                                    Existing account:
                                    XXXX XXXX {{ substr($seller->bank_account_number, -4) }}
                                </small>

                            @endif

                        </div>


                        {{-- CONFIRM ACCOUNT --}}

                        <div class="field-block">

                            <label class="form-label">
                                Confirm Account Number *
                            </label>

                            <input
                                type="password"
                                name="bank_account_number_confirmation"
                                value=""
                                class="form-input"
                                inputmode="numeric"
                                autocomplete="new-password"
                                placeholder="Re-enter account number"
                                required
                            >

                        </div>


                        {{-- IFSC --}}

                        <div class="field-block">

                            <label class="form-label">
                                IFSC Code *
                            </label>

                            <input
                                type="text"
                                name="bank_ifsc"
                                value="{{ old('bank_ifsc', $seller->bank_ifsc ?? '') }}"
                                class="form-input uppercase-input"
                                maxlength="11"
                                placeholder="SBIN0001234"
                                required
                            >

                        </div>


                        {{-- ACCOUNT TYPE --}}

                        <div class="field-block">

                            <label class="form-label">
                                Account Type
                            </label>

                            <select
                                name="account_type"
                                class="form-input"
                            >

                                <option value="">
                                    Select account type
                                </option>

                                <option
                                    value="Savings"
                                    @selected(old('account_type', $seller->account_type ?? '') === 'Savings')
                                >
                                    Savings
                                </option>

                                <option
                                    value="Current"
                                    @selected(old('account_type', $seller->account_type ?? '') === 'Current')
                                >
                                    Current
                                </option>

                                <option
                                    value="Business"
                                    @selected(old('account_type', $seller->account_type ?? '') === 'Business')
                                >
                                    Business
                                </option>

                            </select>

                        </div>


                        {{-- BANK PROOF --}}

                        <div class="field-block full-span">

                            <label class="form-label">
                                Bank Proof
                            </label>

                            <input
                                type="file"
                                name="bank_proof"
                                class="form-input file-input"
                                accept=".pdf,.jpg,.jpeg,.png,.webp"
                            >

                            <small class="field-help">
                                Optional · PDF, JPG, JPEG, PNG or WEBP · Maximum 5 MB
                            </small>

                            @if(!empty($seller->bank_proof_path))

                                <div class="uploaded-status">
                                    ✓ Bank proof already uploaded
                                </div>

                            @endif

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="primary-button"
                    >
                        Save Bank Details &amp; Continue →
                    </button>

                </form>

            </section>


            {{-- =====================================================
                 STEP 6 — REVIEW
            ====================================================== --}}

            <section
                class="verification-panel {{ $currentStep === 6 ? 'active' : '' }}"
                data-panel="6"
            >

                <div class="panel-header">

                    <div>
                        <div class="panel-kicker">
                            STEP 06 · FINAL REVIEW
                        </div>

                        <h2 class="panel-title">
                            Review &amp; submit your application
                        </h2>
                    </div>

                    <span class="status-tag success">
                        Final Step
                    </span>

                </div>

                <p class="muted">
                    Please verify all information before submitting your seller
                    verification application.
                </p>


                <div class="review-grid">


                    {{-- SELLER --}}

                    <div class="review-card">

                        <div class="review-icon">
                            <i class="fa-solid fa-user"></i>
                        </div>

                        <h3>
                            Seller Information
                        </h3>

                        <p>
                            <strong>Name:</strong>
                            {{ $seller->seller_name ?? 'Not provided' }}
                        </p>

                        <p>
                            <strong>Email:</strong>
                            {{ $seller->email ?? 'Not provided' }}
                        </p>

                        <p>
                            <strong>Mobile:</strong>
                            {{ $seller->mobile_number ?? 'Not provided' }}
                        </p>

                    </div>


                    {{-- EMAIL --}}

                    <div class="review-card">

                        <div class="review-icon green-review">
                            <i class="fa-solid fa-envelope-circle-check"></i>
                        </div>

                        <h3>
                            Email Verification
                        </h3>

                        @if($emailCompleted)

                            <div class="review-success">
                                ✓ Email verified
                            </div>

                        @else

                            <div class="review-pending">
                                Verification pending
                            </div>

                        @endif

                    </div>


                    {{-- DOCUMENTS --}}

                    <div class="review-card">

                        <div class="review-icon">
                            <i class="fa-solid fa-file-shield"></i>
                        </div>

                        <h3>
                            KYC Documents
                        </h3>

                        <p>
                            Business Certificate:
                            <strong>
                                {{ !empty($seller->business_certificate_path) ? 'Uploaded ✓' : 'Missing' }}
                            </strong>
                        </p>

                        <p>
                            Aadhaar Document:
                            <strong>
                                {{ !empty($seller->aadhaar_document_path) ? 'Uploaded ✓' : 'Missing' }}
                            </strong>
                        </p>

                    </div>


                    {{-- AADHAAR --}}

                    <div class="review-card">

                        <div class="review-icon blue-review">
                            <i class="fa-solid fa-id-card"></i>
                        </div>

                        <h3>
                            Aadhaar Verification
                        </h3>

                        @if($aadhaarCompleted)

                            <div class="review-success">
                                ✓ Aadhaar verified
                            </div>

                        @else

                            <div class="review-pending">
                                Verification pending
                            </div>

                        @endif

                    </div>


                    {{-- BUSINESS --}}

                    <div class="review-card">

                        <div class="review-icon violet-review">
                            <i class="fa-solid fa-building"></i>
                        </div>

                        <h3>
                            Business Details
                        </h3>

                        <p>
                            <strong>Type:</strong>
                            {{ $seller->business_type ?: 'Not provided' }}
                        </p>

                        <p>
                            <strong>PAN:</strong>
                            {{ $maskedPan }}
                        </p>

                        <p>
                            <strong>Udyam:</strong>
                            {{ $seller->udyam_number ?: 'Not provided' }}
                        </p>

                        <p>
                            <strong>GST:</strong>
                            {{ $seller->gst_number ?: 'Not provided' }}
                        </p>

                    </div>


                    {{-- BANK --}}

                    <div class="review-card">

                        <div class="review-icon green-review">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>

                        <h3>
                            Bank Details
                        </h3>

                        <p>
                            <strong>Holder:</strong>
                            {{ $seller->bank_account_holder ?: 'Not provided' }}
                        </p>

                        <p>
                            <strong>Bank:</strong>
                            {{ $seller->bank_name ?: 'Not provided' }}
                        </p>

                        <p>
                            <strong>Account:</strong>
                            {{ $maskedBank }}
                        </p>

                        <p>
                            <strong>IFSC:</strong>
                            {{ $seller->bank_ifsc ?: 'Not provided' }}
                        </p>

                    </div>

                </div>


                {{-- FINAL WARNING --}}

                <div class="final-submit-box">

                    <div class="final-submit-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <div>

                        <h3>
                            Ready to submit?
                        </h3>

                        <p>
                            By submitting this application, you confirm that the
                            information and documents provided are accurate and
                            belong to you / your business.
                        </p>

                    </div>

                </div>


                {{-- FINAL SUBMIT --}}

                <form
                    method="POST"
                    action="{{ route('seller.verification.submit') }}"
                    id="finalSubmitForm"
                >

                    @csrf

                    <label class="confirmation-check">

                        <input
                            type="checkbox"
                            id="confirmApplication"
                            required
                        >

                        <span>
                            I confirm that all information provided above is correct
                            and I agree to SmartBasket seller verification terms.
                        </span>

                    </label>

                    <button
                        type="submit"
                        class="submit-application-button"
                        id="submitApplicationButton"
                    >
                        <i class="fa-solid fa-paper-plane"></i>
                        SUBMIT APPLICATION
                    </button>

                </form>

            </section>

        </div>


        {{-- =========================================================
             BOTTOM NAVIGATION
        ========================================================== --}}

        <div class="verification-actions">

            <button
                type="button"
                id="backButton"
                class="secondary-button"
                {{ $currentStep <= 1 ? 'disabled' : '' }}
            >
                ← Back
            </button>


            <div class="navigation-info">

                <span>
                    Step {{ $currentStep }} of 6
                </span>

                <span class="navigation-dot">•</span>

                <span>
                    {{ $steps[$currentStep] }}
                </span>

            </div>


            @if($currentStep < 6)

                <button
                    type="button"
                    id="nextButton"
                    class="primary-button"
                >
                    Next →
                </button>

            @else

                <span class="final-ready-label">
                    Final review complete
                </span>

            @endif

        </div>

    </div>

</div>

@endsection


{{-- ================================================================
     STYLES
================================================================ --}}

@push('styles')

<style>

:root {
    --kyc-green: #22c55e;
    --kyc-green-dark: #16a34a;
    --kyc-blue: #3b82f6;
    --kyc-bg: #07111f;
    --kyc-card: rgba(15, 23, 42, .97);
    --kyc-border: rgba(148, 163, 184, .18);
    --kyc-text: #e2e8f0;
    --kyc-muted: #94a3b8;
}


/* =========================================================
   MAIN
========================================================= */

.seller-verification-shell {

    min-height: calc(100vh - 40px);

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 30px 16px 50px;

    background:
        radial-gradient(
            circle at 5% 5%,
            rgba(34,197,94,.13),
            transparent 24%
        ),
        radial-gradient(
            circle at 95% 90%,
            rgba(59,130,246,.10),
            transparent 25%
        ),
        var(--sb-bg, #07111f);
}


.seller-verification-card {

    width: min(1150px, 100%);

    overflow: hidden;

    background:
        linear-gradient(
            145deg,
            rgba(15,23,42,.98),
            rgba(10,22,35,.97)
        );

    border: 1px solid var(--kyc-border);

    border-radius: 30px;

    box-shadow:
        0 35px 90px rgba(0,0,0,.30),
        0 10px 30px rgba(0,0,0,.15);

    backdrop-filter: blur(20px);

}


/* =========================================================
   HEADER
========================================================= */

.verification-header {

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 25px;

    padding: 34px 34px 28px;

    color: #fff;

    background:
        linear-gradient(
            135deg,
            #0f172a,
            #064e3b
        );

    border-bottom: 1px solid rgba(255,255,255,.08);

}


.eyebrow {

    font-size: .68rem;

    font-weight: 800;

    letter-spacing: .20em;

    color: #86efac;

}


.verification-header h1 {

    margin: 8px 0 7px;

    font-size: clamp(2rem, 4vw, 3rem);

    line-height: 1.05;

    letter-spacing: -.045em;

    font-weight: 900;

}


.header-description {

    margin: 0;

    color: #cbd5e1;

    font-size: .92rem;

}


.step-pill {

    flex-shrink: 0;

    padding: 11px 17px;

    border-radius: 999px;

    color: #dcfce7;

    background: rgba(255,255,255,.08);

    border: 1px solid rgba(255,255,255,.14);

    font-size: .78rem;

    font-weight: 800;

}


/* =========================================================
   STEPPER
========================================================= */

.stepper {

    display: grid;

    grid-template-columns: repeat(6, 1fr);

    gap: 10px;

    padding: 18px 22px 20px;

    background: rgba(2,6,23,.32);

    border-bottom: 1px solid var(--kyc-border);

}


.step-item {

    min-height: 58px;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    border-radius: 14px;

    border: 1px solid var(--kyc-border);

    background: rgba(148,163,184,.035);

    color: var(--kyc-text);

    cursor: pointer;

    font-weight: 800;

    transition:
        transform .18s ease,
        border-color .18s ease,
        background .18s ease,
        box-shadow .18s ease;

}


.step-item:hover:not(:disabled) {

    transform: translateY(-2px);

    border-color: rgba(34,197,94,.42);

}


.step-item.active {

    background: rgba(34,197,94,.13);

    border-color: rgba(34,197,94,.55);

    box-shadow:
        0 0 0 1px rgba(34,197,94,.12),
        0 8px 20px rgba(34,197,94,.06);

}


.step-item.complete {

    background: rgba(34,197,94,.075);

    border-color: rgba(34,197,94,.32);

}


.step-item.locked {

    opacity: .45;

    cursor: not-allowed;

}


.step-number {

    width: 26px;

    height: 26px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 50%;

    background: rgba(255,255,255,.07);

    color: #cbd5e1;

    font-size: .76rem;

    font-weight: 900;

}


.step-item.active .step-number,
.step-item.complete .step-number {

    background: linear-gradient(
        135deg,
        var(--kyc-green),
        var(--kyc-green-dark)
    );

    color: #03200f;

}


.step-label {

    font-size: .78rem;

}


/* =========================================================
   ALERTS
========================================================= */

.global-alert {

    margin: 22px 24px 0;

    padding: 14px 16px;

    display: flex;

    gap: 12px;

    align-items: flex-start;

    border-radius: 14px;

    border: 1px solid;

    font-size: .9rem;

}


.success-alert {

    color: #bbf7d0;

    background: rgba(34,197,94,.08);

    border-color: rgba(34,197,94,.25);

}


.error-alert {

    color: #fecaca;

    background: rgba(239,68,68,.08);

    border-color: rgba(239,68,68,.25);

}


.alert-icon {

    width: 24px;

    height: 24px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 50%;

    font-weight: 900;

}


/* =========================================================
   PANELS
========================================================= */

.verification-panels {

    padding: 30px 26px 12px;

}


.verification-panel {

    display: none;

    animation: kycFade .25s ease;

}


.verification-panel.active {

    display: block;

}


@keyframes kycFade {

    from {
        opacity: 0;
        transform: translateY(7px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }

}


.panel-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 18px;

    margin-bottom: 8px;

}


.panel-kicker {

    color: #7dd3fc;

    font-size: .68rem;

    font-weight: 800;

    letter-spacing: .13em;

    text-transform: uppercase;

}


.panel-title {

    margin: 5px 0 0;

    color: var(--kyc-text);

    font-size: clamp(1.45rem, 2.5vw, 2rem);

    font-weight: 900;

    letter-spacing: -.035em;

}


.muted {

    margin: 0 0 22px;

    color: var(--kyc-muted);

    line-height: 1.65;

}


/* =========================================================
   STATUS
========================================================= */

.status-tag {

    padding: 7px 11px;

    border-radius: 999px;

    border: 1px solid;

    font-size: .65rem;

    font-weight: 900;

    letter-spacing: .08em;

    text-transform: uppercase;

}


.status-tag.green {

    color: #86efac;

    background: rgba(34,197,94,.08);

    border-color: rgba(34,197,94,.22);

}


.status-tag.amber {

    color: #fbbf24;

    background: rgba(245,158,11,.08);

    border-color: rgba(245,158,11,.22);

}


.status-tag.blue {

    color: #93c5fd;

    background: rgba(59,130,246,.08);

    border-color: rgba(59,130,246,.22);

}


.status-tag.violet {

    color: #c4b5fd;

    background: rgba(168,85,247,.08);

    border-color: rgba(168,85,247,.22);

}


.status-tag.success {

    color: #a7f3d0;

    background: rgba(16,185,129,.08);

    border-color: rgba(16,185,129,.22);

}


/* =========================================================
   FORMS
========================================================= */

.surface-box {

    padding: 20px;

    margin-bottom: 16px;

    border-radius: 18px;

    background: rgba(148,163,184,.035);

    border: 1px solid var(--kyc-border);

}


.alt-box {

    background: rgba(2,6,23,.16);

}


.stacked-form {

    display: flex;

    flex-direction: column;

    gap: 16px;

}


.field-block {

    display: flex;

    flex-direction: column;

    gap: 8px;

}


.grid-two {

    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 18px;

}


.full-span {

    grid-column: 1 / -1;

}


.form-label {

    color: var(--kyc-text);

    font-size: .88rem;

    font-weight: 800;

}


.form-input {

    width: 100%;

    min-height: 47px;

    box-sizing: border-box;

    border-radius: 12px;

    border: 1px solid var(--kyc-border);

    padding: 11px 14px;

    background: rgba(2,6,23,.22);

    color: var(--kyc-text);

    transition:
        border-color .18s ease,
        box-shadow .18s ease,
        background .18s ease;

}


.form-input:focus {

    outline: none;

    border-color: rgba(34,197,94,.60);

    box-shadow:
        0 0 0 3px rgba(34,197,94,.11);

}


.form-input::placeholder {

    color: #64748b;

}


select.form-input option {

    background: #0f172a;

    color: #f8fafc;

}


.uppercase-input {

    text-transform: uppercase;

}


.code-input {

    letter-spacing: .20em;

    font-weight: 800;

}


.field-help,
.file-help {

    color: #64748b;

    font-size: .76rem;

    line-height: 1.5;

}


/* =========================================================
   UPLOAD
========================================================= */

.upload-grid {

    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 18px;

}


.upload-box {

    padding: 20px;

    display: flex;

    flex-direction: column;

    gap: 13px;

    border-radius: 18px;

    background: rgba(2,6,23,.18);

    border: 1px solid var(--kyc-border);

}


.upload-header {

    display: flex;

    align-items: center;

    gap: 12px;

    color: var(--kyc-text);

}


.upload-header strong {

    display: block;

}


.upload-header small {

    display: block;

    margin-top: 3px;

    color: #64748b;

}


.upload-icon {

    width: 42px;

    height: 42px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    color: #86efac;

    background: rgba(34,197,94,.10);

    border: 1px solid rgba(34,197,94,.20);

}


.blue-icon {

    color: #93c5fd;

    background: rgba(59,130,246,.10);

    border-color: rgba(59,130,246,.20);

}


.file-input {

    padding: 9px 10px;

}


.uploaded-status {

    color: #86efac;

    font-size: .78rem;

    font-weight: 800;

}


/* =========================================================
   INFO
========================================================= */

.info-box {

    padding: 18px;

    margin-bottom: 18px;

    border-radius: 16px;

    color: #fde68a;

    background: rgba(245,158,11,.08);

    border: 1px solid rgba(245,158,11,.22);

}


.info-box p {

    margin: 7px 0 0;

    color: #fcd34d;

}


/* =========================================================
   REVIEW
========================================================= */

.review-grid {

    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 18px;

}


.review-card {

    position: relative;

    padding: 20px;

    border-radius: 18px;

    background: rgba(148,163,184,.035);

    border: 1px solid var(--kyc-border);

}


.review-icon {

    width: 38px;

    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    margin-bottom: 13px;

    border-radius: 11px;

    color: #93c5fd;

    background: rgba(59,130,246,.09);

}


.green-review {

    color: #86efac;

    background: rgba(34,197,94,.09);

}


.blue-review {

    color: #93c5fd;

    background: rgba(59,130,246,.09);

}


.violet-review {

    color: #c4b5fd;

    background: rgba(168,85,247,.09);

}


.review-card h3 {

    margin: 0 0 13px;

    color: #f8fafc;

    font-size: 1rem;

    font-weight: 850;

}


.review-card p {

    margin: 0 0 7px;

    color: var(--kyc-text);

    font-size: .87rem;

    line-height: 1.55;

}


.review-success {

    color: #86efac;

    font-weight: 800;

}


.review-pending {

    color: #fbbf24;

    font-weight: 800;

}


/* =========================================================
   FINAL SUBMIT
========================================================= */

.final-submit-box {

    display: flex;

    align-items: flex-start;

    gap: 15px;

    margin-top: 22px;

    padding: 20px;

    border-radius: 18px;

    color: #d1fae5;

    background:
        linear-gradient(
            135deg,
            rgba(34,197,94,.09),
            rgba(16,185,129,.04)
        );

    border: 1px solid rgba(34,197,94,.22);

}


.final-submit-icon {

    width: 44px;

    height: 44px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 13px;

    color: #86efac;

    background: rgba(34,197,94,.12);

}


.final-submit-box h3 {

    margin: 0 0 5px;

    color: #ecfdf5;

    font-size: 1rem;

}


.final-submit-box p {

    margin: 0;

    color: #a7f3d0;

    font-size: .83rem;

    line-height: 1.6;

}


#finalSubmitForm {

    margin-top: 18px;

}


.confirmation-check {

    display: flex;

    align-items: flex-start;

    gap: 10px;

    padding: 13px 0;

    color: #cbd5e1;

    font-size: .82rem;

    line-height: 1.5;

    cursor: pointer;

}


.confirmation-check input {

    width: 18px;

    height: 18px;

    margin-top: 1px;

    accent-color: var(--kyc-green);

}


.submit-application-button {

    width: 100%;

    min-height: 52px;

    border: 0;

    border-radius: 14px;

    color: #022c16;

    background:
        linear-gradient(
            135deg,
            #4ade80,
            #16a34a
        );

    font-weight: 900;

    letter-spacing: .02em;

    cursor: pointer;

    transition:
        transform .18s ease,
        filter .18s ease;

}


.submit-application-button:hover {

    transform: translateY(-1px);

    filter: brightness(1.06);

}


/* =========================================================
   BOTTOM ACTIONS
========================================================= */

.verification-actions {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    padding: 20px 26px 28px;

    border-top: 1px solid var(--kyc-border);

    background: rgba(2,6,23,.18);

}


.navigation-info {

    color: #64748b;

    font-size: .78rem;

    font-weight: 700;

}


.navigation-dot {

    margin: 0 6px;

}


.final-ready-label {

    color: #86efac;

    font-size: .78rem;

    font-weight: 800;

}


.primary-button,
.secondary-button,
.success-button {

    min-height: 46px;

    padding: 11px 19px;

    border-radius: 12px;

    font-weight: 850;

    cursor: pointer;

    border: 1px solid transparent;

    transition:
        transform .18s ease,
        filter .18s ease,
        opacity .18s ease;

}


.primary-button {

    color: #03200f;

    background:
        linear-gradient(
            135deg,
            #22c55e,
            #16a34a
        );

}


.success-button {

    color: #fff;

    background:
        linear-gradient(
            135deg,
            #60a5fa,
            #2563eb
        );

}


.secondary-button {

    color: var(--kyc-text);

    background: rgba(148,163,184,.07);

    border-color: var(--kyc-border);

}


.primary-button:hover,
.secondary-button:hover,
.success-button:hover {

    transform: translateY(-1px);

    filter: brightness(1.05);

}


.secondary-button:disabled {

    opacity: .35;

    cursor: not-allowed;

    transform: none;

}


/* =========================================================
   LIGHT THEME
========================================================= */

html.light .seller-verification-shell,
body.light .seller-verification-shell {

    background:
        radial-gradient(
            circle at 5% 5%,
            rgba(34,197,94,.10),
            transparent 24%
        ),
        #f4f7fb;

}


html.light .seller-verification-card,
body.light .seller-verification-card {

    background: #fff;

    border-color: #e2e8f0;

    box-shadow: 0 25px 70px rgba(15,23,42,.10);

}


html.light .stepper,
body.light .stepper {

    background: #f8fafc;

}


html.light .form-input,
body.light .form-input {

    color: #111827;

    background: #fff;

    border-color: #dbe3ed;

}


html.light .form-label,
body.light .form-label {

    color: #111827;

}


html.light .panel-title,
body.light .panel-title {

    color: #111827;

}


html.light .muted,
body.light .muted {

    color: #64748b;

}


html.light .surface-box,
html.light .upload-box,
html.light .review-card,
body.light .surface-box,
body.light .upload-box,
body.light .review-card {

    background: #f8fafc;

    border-color: #e2e8f0;

}


html.light .review-card h3,
body.light .review-card h3 {

    color: #111827;

}


html.light .review-card p,
body.light .review-card p {

    color: #374151;

}


html.light .verification-actions,
body.light .verification-actions {

    background: #f8fafc;

}


html.light .step-item,
body.light .step-item {

    color: #374151;

    background: #fff;

    border-color: #e2e8f0;

}


html.light select.form-input option,
body.light select.form-input option {

    background: #fff;

    color: #111827;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .stepper {

        grid-template-columns: repeat(3, 1fr);

    }

    .step-label {

        font-size: .72rem;

    }

}


@media (max-width: 700px) {

    .seller-verification-shell {

        padding: 10px;

        align-items: flex-start;

    }


    .seller-verification-card {

        border-radius: 20px;

    }


    .verification-header {

        padding: 25px 20px;

        flex-direction: column;

        align-items: flex-start;

    }


    .verification-header h1 {

        font-size: 2rem;

    }


    .stepper {

        padding: 12px;

        gap: 7px;

    }


    .step-item {

        min-height: 50px;

        padding: 8px 5px;

        flex-direction: column;

        gap: 4px;

    }


    .step-label {

        font-size: .64rem;

    }


    .verification-panels {

        padding: 22px 16px 8px;

    }


    .grid-two,
    .upload-grid,
    .review-grid {

        grid-template-columns: 1fr;

    }


    .full-span {

        grid-column: auto;

    }


    .panel-header {

        align-items: flex-start;

        flex-direction: column;

    }


    .verification-actions {

        padding: 17px 16px 22px;

        flex-wrap: wrap;

    }


    .navigation-info {

        order: 3;

        width: 100%;

        text-align: center;

    }


    .primary-button,
    .secondary-button,
    .success-button {

        min-width: 0;

    }

}


@media (max-width: 450px) {

    .stepper {

        grid-template-columns: repeat(2, 1fr);

    }


    .step-item {

        flex-direction: row;

        min-height: 46px;

    }


    .step-label {

        font-size: .70rem;

    }


    .verification-header h1 {

        font-size: 1.75rem;

    }

}

</style>

@endpush


{{-- ================================================================
     JAVASCRIPT
================================================================ --}}

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const panels = Array.from(
        document.querySelectorAll('.verification-panel')
    );

    const stepButtons = Array.from(
        document.querySelectorAll('[data-step-button]')
    );

    const backButton =
        document.getElementById('backButton');

    const nextButton =
        document.getElementById('nextButton');

    const currentStep =
        Number(@json($currentStep));


    /*
    |--------------------------------------------------------------------------
    | ACTIVATE PANEL
    |--------------------------------------------------------------------------
    */

    function activateStep(step) {

        step = Number(step);

        if (step < 1 || step > 6) {
            return;
        }

        panels.forEach(function (panel) {

            panel.classList.toggle(
                'active',
                Number(panel.dataset.panel) === step
            );

        });


        stepButtons.forEach(function (button) {

            button.classList.toggle(
                'active',
                Number(button.dataset.stepButton) === step
            );

        });


        if (backButton) {

            backButton.disabled = step <= 1;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | COMPLETED / PREVIOUS STEP CLICK
    |--------------------------------------------------------------------------
    */

    stepButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            if (button.disabled) {
                return;
            }

            const target =
                Number(button.dataset.targetStep);

            /*
             * Only current and already completed
             * steps can be opened.
             */

            if (target <= currentStep) {

                window.location.href =
                    "{{ route('seller.verification.index') }}"
                    + "?step="
                    + target;

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | BACK
    |--------------------------------------------------------------------------
    */

    if (backButton) {

        backButton.addEventListener('click', function () {

            if (currentStep <= 1) {
                return;
            }

            window.location.href =
                "{{ route('seller.verification.index') }}"
                + "?step="
                + (currentStep - 1);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | NEXT
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    |
    | Step 2, 3, 4 and 5 have their own forms.
    | Therefore Next will submit the active form.
    |
    */

    if (nextButton) {

        nextButton.addEventListener('click', function () {

            const activePanel =
                document.querySelector(
                    '.verification-panel.active'
                );

            if (!activePanel) {
                return;
            }


            const form =
                activePanel.querySelector('form');


            /*
             * STEP 1:
             * Email has two forms.
             * User must verify email through
             * the Verify Email button.
             */

            if (currentStep === 1) {

                @if($emailCompleted)

                    window.location.href =
                        "{{ route('seller.verification.index') }}"
                        + "?step=2";

                @else

                    alert(
                        'Please verify your email before continuing.'
                    );

                @endif

                return;

            }


            /*
             * STEP 2:
             */

            if (currentStep === 2) {

                const uploadForm =
                    activePanel.querySelector(
                        'form[action*="documents.upload"]'
                    );

                if (uploadForm) {

                    const businessFile =
                        uploadForm.querySelector(
                            '[name="business_certificate"]'
                        );

                    const aadhaarFile =
                        uploadForm.querySelector(
                            '[name="aadhaar_document"]'
                        );

                    @if(!$documentsCompleted)

                        if (
                            !businessFile ||
                            !businessFile.files.length
                        ) {

                            alert(
                                'Please upload your Business Certificate.'
                            );

                            return;

                        }


                        if (
                            !aadhaarFile ||
                            !aadhaarFile.files.length
                        ) {

                            alert(
                                'Please upload your Aadhaar document.'
                            );

                            return;

                        }

                    @endif

                    uploadForm.submit();

                }

                return;

            }


            /*
             * STEP 3:
             */

            if (currentStep === 3) {

                @if($aadhaarCompleted)

                    window.location.href =
                        "{{ route('seller.verification.index') }}"
                        + "?step=4";

                @else

                    alert(
                        'Please complete Aadhaar verification before continuing.'
                    );

                @endif

                return;

            }


            /*
             * STEP 4:
             */

            if (currentStep === 4) {

                if (form) {

                    const businessType =
                        form.querySelector(
                            '[name="business_type"]'
                        );

                    const pan =
                        form.querySelector(
                            '[name="pan_number"]'
                        );

                    const udyam =
                        form.querySelector(
                            '[name="udyam_number"]'
                        );


                    if (
                        !businessType ||
                        !businessType.value.trim()
                    ) {

                        alert(
                            'Please select your business type.'
                        );

                        return;

                    }


                    if (
                        !pan ||
                        !pan.value.trim()
                    ) {

                        alert(
                            'Please enter your PAN number.'
                        );

                        return;

                    }


                    if (
                        !udyam ||
                        !udyam.value.trim()
                    ) {

                        alert(
                            'Please enter your Udyam number.'
                        );

                        return;

                    }


                    form.submit();

                }

                return;

            }


            /*
             * STEP 5:
             */

            if (currentStep === 5) {

                if (form) {

                    const account =
                        form.querySelector(
                            '[name="bank_account_number"]'
                        );

                    const confirmation =
                        form.querySelector(
                            '[name="bank_account_number_confirmation"]'
                        );

                    if (
                        account &&
                        confirmation &&
                        account.value !== confirmation.value
                    ) {

                        alert(
                            'Bank account number and confirmation do not match.'
                        );

                        confirmation.focus();

                        return;

                    }


                    if (
                        account &&
                        !/^[0-9]+$/.test(account.value)
                    ) {

                        alert(
                            'Please enter a valid bank account number.'
                        );

                        account.focus();

                        return;

                    }


                    form.submit();

                }

                return;

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | BANK ACCOUNT CONFIRMATION
    |--------------------------------------------------------------------------
    */

    const bankForm =
        document.getElementById('bankDetailsForm');

    if (bankForm) {

        bankForm.addEventListener('submit', function (event) {

            const account =
                bankForm.querySelector(
                    '[name="bank_account_number"]'
                );

            const confirmation =
                bankForm.querySelector(
                    '[name="bank_account_number_confirmation"]'
                );

            if (
                account &&
                confirmation &&
                account.value !== confirmation.value
            ) {

                event.preventDefault();

                alert(
                    'Bank account number and confirmation do not match.'
                );

                confirmation.focus();

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | FINAL SUBMIT CONFIRMATION
    |--------------------------------------------------------------------------
    */

    const finalForm =
        document.getElementById('finalSubmitForm');

    if (finalForm) {

        finalForm.addEventListener('submit', function (event) {

            const checkbox =
                document.getElementById(
                    'confirmApplication'
                );

            if (
                !checkbox ||
                !checkbox.checked
            ) {

                event.preventDefault();

                alert(
                    'Please confirm that all information provided is correct.'
                );

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | PAN AUTO UPPERCASE
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.uppercase-input')
        .forEach(function (input) {

            input.addEventListener(
                'input',
                function () {

                    this.value =
                        this.value.toUpperCase();

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | INITIAL STATE
    |--------------------------------------------------------------------------
    */

    activateStep(currentStep);

});

</script>

@endpush