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

    /*
    |--------------------------------------------------------------------------
    | PROGRESS
    |--------------------------------------------------------------------------
    */

    $completedCount = collect($completedSteps)
        ->filter()
        ->count();

    $progressPercent = min(100, ($completedCount / 5) * 100);
@endphp

@extends('seller.partials.premium-layout')

@section('title', 'Seller Verification & KYC')

@section('content')

<div class="seller-verification-shell">

    <div class="seller-verification-card">

        {{-- =========================================================
             PREMIUM HEADER
        ========================================================== --}}

        <header class="verification-header">

            <div class="header-main">

                <div class="eyebrow">
                    <span class="eyebrow-dot"></span>
                    SMART BASKET · SELLER PARTNER PROGRAM
                </div>

                <div class="header-title-row">

                    <div class="header-title-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <div class="header-copy">

                        <h1>
                            Verification <span>&amp; KYC</span>
                        </h1>

                        <p>
                            Complete all 6 verification steps to activate your
                            SmartBasket seller account.
                        </p>

                    </div>

                </div>

            </div>

            <div class="header-right">

                <div class="progress-summary">

                    <div class="progress-summary-top">

                        <span>
                            Verification Progress
                        </span>

                        <strong>
                            {{ $completedCount }}/5
                        </strong>

                    </div>

                    <div class="progress-track">

                        <span
                            class="progress-value"
                            style="width: {{ $progressPercent }}%;"
                        ></span>

                    </div>

                </div>

                <div class="step-pill">

                    <span class="step-pill-icon">
                        <i class="fa-solid fa-layer-group"></i>
                    </span>

                    <span>
                        Step {{ $currentStep }} / 6
                    </span>

                </div>

            </div>

        </header>


        {{-- =========================================================
             STEP PROGRESS
        ========================================================== --}}

        <div class="stepper-wrapper">

            <div class="stepper">

                @foreach($steps as $stepNumber => $label)

                    @php
                        $isCurrent = $stepNumber === $currentStep;
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

                                <i class="fa-solid fa-check"></i>

                            @else

                                {{ $stepNumber }}

                            @endif

                        </span>

                        <span class="step-content">

                            <span class="step-label">
                                {{ $label }}
                            </span>

                            <span class="step-state">

                                @if($isCurrent)
                                    Current
                                @elseif($isComplete)
                                    Completed
                                @elseif($isLocked)
                                    Locked
                                @else
                                    Pending
                                @endif

                            </span>

                        </span>

                    </button>

                @endforeach

            </div>

        </div>


        {{-- =========================================================
             ALERTS
        ========================================================== --}}

        @if(session('success'))

            <div class="global-alert success-alert">

                <span class="alert-icon">
                    <i class="fa-solid fa-check"></i>
                </span>

                <div class="alert-content">
                    <strong>Success</strong>
                    <span>{{ session('success') }}</span>
                </div>

                <button
                    type="button"
                    class="alert-close"
                    onclick="this.closest('.global-alert').remove()"
                    aria-label="Close"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>

        @endif


        @if(session('error'))

            <div class="global-alert error-alert">

                <span class="alert-icon">
                    <i class="fa-solid fa-exclamation"></i>
                </span>

                <div class="alert-content">
                    <strong>Action required</strong>
                    <span>{{ session('error') }}</span>
                </div>

                <button
                    type="button"
                    class="alert-close"
                    onclick="this.closest('.global-alert').remove()"
                    aria-label="Close"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>

        @endif


        @if($errors->any())

            <div class="global-alert error-alert">

                <span class="alert-icon">
                    <i class="fa-solid fa-exclamation"></i>
                </span>

                <div class="alert-content">

                    <strong>
                        Please fix the following:
                    </strong>

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif


        {{-- =========================================================
             VERIFICATION CONTENT
        ========================================================== --}}

        <main class="verification-panels">


            {{-- =====================================================
                 STEP 1 · EMAIL
            ====================================================== --}}

            <section
                class="verification-panel {{ $currentStep === 1 ? 'active' : '' }}"
                data-panel="1"
            >

                <div class="panel-heading">

                    <div class="panel-heading-left">

                        <div class="panel-icon blue">
                            <i class="fa-solid fa-envelope-circle-check"></i>
                        </div>

                        <div>

                            <div class="panel-kicker">
                                STEP 01 · SECURE ACCESS
                            </div>

                            <h2 class="panel-title">
                                Verify your seller email
                            </h2>

                            <p class="panel-description">
                                Confirm your registered email address before
                                continuing with KYC verification.
                            </p>

                        </div>

                    </div>

                    <span class="status-tag {{ $emailCompleted ? 'green' : 'amber' }}">

                        <span class="status-dot"></span>

                        {{ $emailCompleted ? 'Verified' : 'Required' }}

                    </span>

                </div>


                <div class="security-note">

                    <div class="security-note-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <div>

                        <strong>
                            Secure email verification
                        </strong>

                        <p>
                            A secure 16-digit verification code will be sent
                            to your registered seller email address.
                        </p>

                    </div>

                </div>


                <div class="form-card">

                    <div class="form-card-header">

                        <div>

                            <h3>
                                Send verification code
                            </h3>

                            <p>
                                Request a new verification code for your email.
                            </p>

                        </div>

                        <span class="mini-icon">
                            <i class="fa-solid fa-paper-plane"></i>
                        </span>

                    </div>


                    <form
                        method="POST"
                        action="{{ route('seller.verification.email.send') }}"
                        class="stacked-form"
                    >

                        @csrf

                        <div class="field-block">

                            <label class="form-label">
                                Seller Email Address
                                <span>*</span>
                            </label>

                            <div class="input-with-icon">

                                <i class="fa-solid fa-envelope"></i>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $seller->email ?? '') }}"
                                    class="form-input"
                                    autocomplete="email"
                                    required
                                >

                            </div>

                        </div>

                        <button
                            type="submit"
                            class="primary-button"
                        >

                            <i class="fa-solid fa-paper-plane"></i>

                            Send Verification Code

                        </button>

                    </form>

                </div>


                <div class="form-card secondary-form-card">

                    <div class="form-card-header">

                        <div>

                            <h3>
                                Enter verification code
                            </h3>

                            <p>
                                Enter the 16-digit code received in your email.
                            </p>

                        </div>

                        <span class="mini-icon success">
                            <i class="fa-solid fa-key"></i>
                        </span>

                    </div>


                    <form
                        method="POST"
                        action="{{ route('seller.verification.email.verify') }}"
                        class="stacked-form"
                    >

                        @csrf

                        <div class="field-block">

                            <label class="form-label">
                                16-Digit Verification Code
                                <span>*</span>
                            </label>

                            <div class="input-with-icon">

                                <i class="fa-solid fa-hashtag"></i>

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

                            <small class="field-help">
                                Enter all 16 digits without spaces.
                            </small>

                        </div>

                        <button
                            type="submit"
                            class="success-button"
                        >

                            <i class="fa-solid fa-circle-check"></i>

                            Verify Email

                        </button>

                    </form>

                </div>

            </section>


            {{-- =====================================================
                 STEP 2 · DOCUMENTS
            ====================================================== --}}

            <section
                class="verification-panel {{ $currentStep === 2 ? 'active' : '' }}"
                data-panel="2"
            >

                <div class="panel-heading">

                    <div class="panel-heading-left">

                        <div class="panel-icon blue">
                            <i class="fa-solid fa-file-shield"></i>
                        </div>

                        <div>

                            <div class="panel-kicker">
                                STEP 02 · DOCUMENT CHECK
                            </div>

                            <h2 class="panel-title">
                                Upload your KYC documents
                            </h2>

                            <p class="panel-description">
                                Provide clear and valid documents for seller verification.
                            </p>

                        </div>

                    </div>

                    <span class="status-tag {{ $documentsCompleted ? 'green' : 'amber' }}">

                        <span class="status-dot"></span>

                        {{ $documentsCompleted ? 'Complete' : 'Required' }}

                    </span>

                </div>


                <div class="security-note">

                    <div class="security-note-icon">
                        <i class="fa-solid fa-lock"></i>
                    </div>

                    <div>

                        <strong>
                            Your documents are protected
                        </strong>

                        <p>
                            Files are stored privately and are available only
                            to authorized SmartBasket verification personnel.
                        </p>

                    </div>

                </div>


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

                                    <strong>
                                        Business Certificate
                                    </strong>

                                    <small>
                                        Required document
                                    </small>

                                </div>

                            </div>


                            <label
                                for="business_certificate"
                                class="file-drop-zone"
                            >

                                <span class="file-drop-icon">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                </span>

                                <span class="file-drop-title">
                                    Choose certificate
                                </span>

                                <span class="file-drop-subtitle">
                                    PDF, JPG, JPEG, PNG or WEBP
                                </span>

                            </label>

                            <input
                                id="business_certificate"
                                type="file"
                                name="business_certificate"
                                accept=".pdf,.jpg,.jpeg,.png,.webp"
                                class="native-file-input"
                                {{ empty($seller->business_certificate_path) ? 'required' : '' }}
                            >

                            <div class="file-help">
                                Maximum file size: 5 MB
                            </div>

                            @if(!empty($seller->business_certificate_path))

                                <div class="uploaded-status">

                                    <i class="fa-solid fa-circle-check"></i>

                                    Business certificate already uploaded

                                </div>

                            @endif

                            <div
                                class="selected-file"
                                data-file-name="business_certificate"
                            ></div>

                        </div>


                        {{-- AADHAAR DOCUMENT --}}

                        <div class="upload-box">

                            <div class="upload-header">

                                <span class="upload-icon">

                                    <i class="fa-solid fa-id-card"></i>

                                </span>

                                <div>

                                    <strong>
                                        Aadhaar Document
                                    </strong>

                                    <small>
                                        Required document
                                    </small>

                                </div>

                            </div>


                            <label
                                for="aadhaar_document"
                                class="file-drop-zone"
                            >

                                <span class="file-drop-icon">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                </span>

                                <span class="file-drop-title">
                                    Choose Aadhaar document
                                </span>

                                <span class="file-drop-subtitle">
                                    PDF, JPG, JPEG, PNG or WEBP
                                </span>

                            </label>

                            <input
                                id="aadhaar_document"
                                type="file"
                                name="aadhaar_document"
                                accept=".pdf,.jpg,.jpeg,.png,.webp"
                                class="native-file-input"
                                {{ empty($seller->aadhaar_document_path) ? 'required' : '' }}
                            >

                            <div class="file-help">
                                Maximum file size: 5 MB
                            </div>

                            @if(!empty($seller->aadhaar_document_path))

                                <div class="uploaded-status">

                                    <i class="fa-solid fa-circle-check"></i>

                                    Aadhaar document already uploaded

                                </div>

                            @endif

                            <div
                                class="selected-file"
                                data-file-name="aadhaar_document"
                            ></div>

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="primary-button wide-button"
                    >

                        <i class="fa-solid fa-cloud-arrow-up"></i>

                        Upload Securely &amp; Continue

                        <i class="fa-solid fa-arrow-right"></i>

                    </button>

                </form>

            </section>


            {{-- =====================================================
                 STEP 3 · AADHAAR
            ====================================================== --}}

            <section
                class="verification-panel {{ $currentStep === 3 ? 'active' : '' }}"
                data-panel="3"
            >

                <div class="panel-heading">

                    <div class="panel-heading-left">

                        <div class="panel-icon blue">
                            <i class="fa-solid fa-id-card"></i>
                        </div>

                        <div>

                            <div class="panel-kicker">
                                STEP 03 · IDENTITY VERIFICATION
                            </div>

                            <h2 class="panel-title">
                                Verify your Aadhaar
                            </h2>

                            <p class="panel-description">
                                Complete Aadhaar verification through the configured
                                authorized verification workflow.
                            </p>

                        </div>

                    </div>

                    <span class="status-tag {{ $aadhaarCompleted ? 'green' : 'blue' }}">

                        <span class="status-dot"></span>

                        {{ $aadhaarCompleted ? 'Verified' : 'Secure' }}

                    </span>

                </div>


                @if(isset($configured) && !$configured)

                    <div class="info-box">

                        <div class="info-box-icon">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>

                        <div>

                            <strong>
                                Aadhaar verification service is not configured.
                            </strong>

                            <p>
                                Please configure the authorized verification
                                provider before attempting Aadhaar verification.
                            </p>

                        </div>

                    </div>

                @else

                    <div class="security-note">

                        <div class="security-note-icon">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>

                        <div>

                            <strong>
                                Secure identity verification
                            </strong>

                            <p>
                                Your Aadhaar information is handled only through
                                the authorized verification workflow.
                            </p>

                        </div>

                    </div>


                    <div class="form-card">

                        <div class="form-card-header">

                            <div>

                                <h3>
                                    Start Aadhaar verification
                                </h3>

                                <p>
                                    Enter your Aadhaar number or provider reference.
                                </p>

                            </div>

                            <span class="mini-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </span>

                        </div>


                        <form
                            method="POST"
                            action="{{ route('seller.verification.aadhaar.start') }}"
                            class="stacked-form"
                        >

                            @csrf

                            <div class="field-block">

                                <label class="form-label">
                                    Aadhaar / Provider Reference
                                    <span>*</span>
                                </label>

                                <div class="input-with-icon">

                                    <i class="fa-solid fa-id-card"></i>

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

                                </div>

                                <small class="field-help">
                                    Your Aadhaar number is handled only through
                                    the authorized verification workflow.
                                </small>

                            </div>


                            <button
                                type="submit"
                                class="primary-button"
                            >

                                <i class="fa-solid fa-shield-halved"></i>

                                Start Aadhaar Verification

                            </button>

                        </form>

                    </div>


                    <div class="form-card secondary-form-card">

                        <div class="form-card-header">

                            <div>

                                <h3>
                                    Enter verification OTP
                                </h3>

                                <p>
                                    Enter the OTP received from the verification provider.
                                </p>

                            </div>

                            <span class="mini-icon success">
                                <i class="fa-solid fa-lock"></i>
                            </span>

                        </div>


                        <form
                            method="POST"
                            action="{{ route('seller.verification.aadhaar.verify') }}"
                            class="stacked-form"
                        >

                            @csrf

                            <div class="field-block">

                                <label class="form-label">
                                    Verification OTP
                                    <span>*</span>
                                </label>

                                <div class="input-with-icon">

                                    <i class="fa-solid fa-key"></i>

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

                            </div>


                            <button
                                type="submit"
                                class="success-button"
                            >

                                <i class="fa-solid fa-circle-check"></i>

                                Verify Aadhaar OTP

                            </button>

                        </form>

                    </div>

                @endif

            </section>


            {{-- =====================================================
                 STEP 4 · BUSINESS
            ====================================================== --}}

            <section
                class="verification-panel {{ $currentStep === 4 ? 'active' : '' }}"
                data-panel="4"
            >

                <div class="panel-heading">

                    <div class="panel-heading-left">

                        <div class="panel-icon blue">
                            <i class="fa-solid fa-building"></i>
                        </div>

                        <div>

                            <div class="panel-kicker">
                                STEP 04 · BUSINESS PROFILE
                            </div>

                            <h2 class="panel-title">
                                Tell us about your business
                            </h2>

                            <p class="panel-description">
                                Enter your legal business information exactly
                                as it appears on your official documents.
                            </p>

                        </div>

                    </div>

                    <span class="status-tag {{ $businessCompleted ? 'green' : 'blue' }}">

                        <span class="status-dot"></span>

                        {{ $businessCompleted ? 'Complete' : 'Legal Details' }}

                    </span>

                </div>


                <form
                    method="POST"
                    action="{{ route('seller.verification.business-details.update') }}"
                    class="stacked-form"
                >

                    @csrf
                    @method('PUT')


                    <div class="form-card">

                        <div class="section-heading">

                            <div class="section-heading-icon">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>

                            <div>

                                <h3>
                                    Business identity
                                </h3>

                                <p>
                                    Provide your official business information.
                                </p>

                            </div>

                        </div>


                        <div class="grid-two">

                            <div class="field-block">

                                <label class="form-label">
                                    Business Type
                                    <span>*</span>
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


                            <div class="field-block">

                                <label class="form-label">
                                    PAN Number
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="pan_number"
                                    value="{{ old('pan_number', $seller->pan_number ?? '') }}"
                                    class="form-input uppercase-input"
                                    placeholder="ABCDE1234F"
                                    maxlength="10"
                                    autocomplete="off"
                                    required
                                >

                            </div>


                            <div class="field-block">

                                <label class="form-label">
                                    Udyam Number
                                    <span>*</span>
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

                        </div>

                    </div>


                    <div class="form-card">

                        <div class="section-heading">

                            <div class="section-heading-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>

                            <div>

                                <h3>
                                    Business address
                                </h3>

                                <p>
                                    Add the primary address associated with your business.
                                </p>

                            </div>

                        </div>


                        <div class="grid-two">

                            <div class="field-block full-span">

                                <label class="form-label">
                                    Business Address
                                </label>

                                <textarea
                                    name="shop_address"
                                    class="form-input textarea-input"
                                    rows="3"
                                    placeholder="Street, area, business address"
                                >{{ old('shop_address', $seller->shop_address ?? '') }}</textarea>

                            </div>


                            <div class="field-block">

                                <label class="form-label">
                                    City
                                </label>

                                <input
                                    type="text"
                                    name="city"
                                    value="{{ old('city', $seller->city ?? '') }}"
                                    class="form-input"
                                    placeholder="City"
                                >

                            </div>


                            <div class="field-block">

                                <label class="form-label">
                                    State
                                </label>

                                <input
                                    type="text"
                                    name="state"
                                    value="{{ old('state', $seller->state ?? '') }}"
                                    class="form-input"
                                    placeholder="State"
                                >

                            </div>


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
                                    placeholder="6-digit pincode"
                                >

                            </div>

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="primary-button wide-button"
                    >

                        <i class="fa-solid fa-floppy-disk"></i>

                        Save Business Details &amp; Continue

                        <i class="fa-solid fa-arrow-right"></i>

                    </button>

                </form>

            </section>


            {{-- =====================================================
                 STEP 5 · BANK
            ====================================================== --}}

            <section
                class="verification-panel {{ $currentStep === 5 ? 'active' : '' }}"
                data-panel="5"
            >

                <div class="panel-heading">

                    <div class="panel-heading-left">

                        <div class="panel-icon blue">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>

                        <div>

                            <div class="panel-kicker">
                                STEP 05 · PAYOUT SETUP
                            </div>

                            <h2 class="panel-title">
                                Add your bank details
                            </h2>

                            <p class="panel-description">
                                These details are used for secure seller payouts.
                            </p>

                        </div>

                    </div>

                    <span class="status-tag {{ $bankCompleted ? 'green' : 'blue' }}">

                        <span class="status-dot"></span>

                        {{ $bankCompleted ? 'Complete' : 'Payout Setup' }}

                    </span>

                </div>


                <div class="security-note">

                    <div class="security-note-icon">
                        <i class="fa-solid fa-lock"></i>
                    </div>

                    <div>

                        <strong>
                            Bank information is protected
                        </strong>

                        <p>
                            Your account number is never displayed in full
                            after saving.
                        </p>

                    </div>

                </div>


                <form
                    method="POST"
                    action="{{ route('seller.verification.bank-details.update') }}"
                    enctype="multipart/form-data"
                    class="stacked-form"
                    id="bankDetailsForm"
                >

                    @csrf
                    @method('PUT')


                    <div class="form-card">

                        <div class="section-heading">

                            <div class="section-heading-icon">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>

                            <div>

                                <h3>
                                    Payout account
                                </h3>

                                <p>
                                    Enter the bank account where your seller
                                    payouts should be received.
                                </p>

                            </div>

                        </div>


                        <div class="grid-two">

                            <div class="field-block">

                                <label class="form-label">
                                    Account Holder Name
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="bank_account_holder"
                                    value="{{ old('bank_account_holder', $seller->bank_account_holder ?? '') }}"
                                    class="form-input"
                                    autocomplete="name"
                                    placeholder="Account holder name"
                                    required
                                >

                            </div>


                            <div class="field-block">

                                <label class="form-label">
                                    Bank Name
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="bank_name"
                                    value="{{ old('bank_name', $seller->bank_name ?? '') }}"
                                    class="form-input"
                                    autocomplete="organization"
                                    placeholder="Bank name"
                                    required
                                >

                            </div>


                            <div class="field-block">

                                <label class="form-label">
                                    Account Number
                                    <span>*</span>
                                </label>

                                <div class="input-with-icon">

                                    <i class="fa-solid fa-credit-card"></i>

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

                                </div>

                                @if(!empty($seller->bank_account_number))

                                    <small class="field-help">

                                        Existing account:
                                        XXXX XXXX {{ substr($seller->bank_account_number, -4) }}

                                    </small>

                                @endif

                            </div>


                            <div class="field-block">

                                <label class="form-label">
                                    Confirm Account Number
                                    <span>*</span>
                                </label>

                                <div class="input-with-icon">

                                    <i class="fa-solid fa-circle-check"></i>

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

                            </div>


                            <div class="field-block">

                                <label class="form-label">
                                    IFSC Code
                                    <span>*</span>
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

                        </div>

                    </div>


                    <div class="form-card">

                        <div class="section-heading">

                            <div class="section-heading-icon">
                                <i class="fa-solid fa-file-circle-check"></i>
                            </div>

                            <div>

                                <h3>
                                    Bank proof
                                </h3>

                                <p>
                                    Upload supporting bank documentation if required.
                                </p>

                            </div>

                        </div>


                        <div class="bank-proof-upload">

                            <input
                                type="file"
                                name="bank_proof"
                                id="bank_proof"
                                class="native-file-input"
                                accept=".pdf,.jpg,.jpeg,.png,.webp"
                            >

                            <label
                                for="bank_proof"
                                class="bank-proof-label"
                            >

                                <span class="bank-proof-icon">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                </span>

                                <span>

                                    <strong>
                                        Choose bank proof
                                    </strong>

                                    <small>
                                        PDF, JPG, JPEG, PNG or WEBP · Maximum 5 MB
                                    </small>

                                </span>

                            </label>

                            @if(!empty($seller->bank_proof_path))

                                <div class="uploaded-status">

                                    <i class="fa-solid fa-circle-check"></i>

                                    Bank proof already uploaded

                                </div>

                            @endif

                            <div
                                class="selected-file"
                                data-file-name="bank_proof"
                            ></div>

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="primary-button wide-button"
                    >

                        <i class="fa-solid fa-building-columns"></i>

                        Save Bank Details &amp; Continue

                        <i class="fa-solid fa-arrow-right"></i>

                    </button>

                </form>

            </section>


            {{-- =====================================================
                 STEP 6 · REVIEW
            ====================================================== --}}

            <section
                class="verification-panel {{ $currentStep === 6 ? 'active' : '' }}"
                data-panel="6"
            >

                <div class="panel-heading">

                    <div class="panel-heading-left">

                        <div class="panel-icon blue">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>

                        <div>

                            <div class="panel-kicker">
                                STEP 06 · FINAL REVIEW
                            </div>

                            <h2 class="panel-title">
                                Review &amp; submit your application
                            </h2>

                            <p class="panel-description">
                                Verify your information before submitting your
                                seller verification application.
                            </p>

                        </div>

                    </div>

                    <span class="status-tag blue">

                        <span class="status-dot"></span>

                        Final Step

                    </span>

                </div>


                <div class="review-banner">

                    <div class="review-banner-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <div>

                        <strong>
                            Almost there!
                        </strong>

                        <p>
                            Review each section carefully. Once submitted,
                            your application will be sent for SmartBasket verification.
                        </p>

                    </div>

                </div>


                <div class="review-grid">


                    {{-- SELLER INFORMATION --}}

                    <div class="review-card">

                        <div class="review-card-top">

                            <div class="review-icon blue">
                                <i class="fa-solid fa-user"></i>
                            </div>

                            <span class="review-status neutral">
                                Profile
                            </span>

                        </div>

                        <h3>
                            Seller Information
                        </h3>

                        <div class="review-details">

                            <div class="review-row">

                                <span>Name</span>

                                <strong>
                                    {{ $seller->seller_name ?? 'Not provided' }}
                                </strong>

                            </div>

                            <div class="review-row">

                                <span>Email</span>

                                <strong>
                                    {{ $seller->email ?? 'Not provided' }}
                                </strong>

                            </div>

                            <div class="review-row">

                                <span>Mobile</span>

                                <strong>
                                    {{ $seller->mobile_number ?? 'Not provided' }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- EMAIL --}}

                    <div class="review-card">

                        <div class="review-card-top">

                            <div class="review-icon green">
                                <i class="fa-solid fa-envelope-circle-check"></i>
                            </div>

                            <span class="review-status {{ $emailCompleted ? 'success' : 'pending' }}">

                                {{ $emailCompleted ? 'Verified' : 'Pending' }}

                            </span>

                        </div>

                        <h3>
                            Email Verification
                        </h3>

                        @if($emailCompleted)

                            <div class="review-success">

                                <i class="fa-solid fa-circle-check"></i>

                                Email verified successfully

                            </div>

                        @else

                            <div class="review-pending">

                                <i class="fa-solid fa-clock"></i>

                                Verification pending

                            </div>

                        @endif

                    </div>


                    {{-- DOCUMENTS --}}

                    <div class="review-card">

                        <div class="review-card-top">

                            <div class="review-icon blue">
                                <i class="fa-solid fa-file-shield"></i>
                            </div>

                            <span class="review-status {{ $documentsCompleted ? 'success' : 'pending' }}">

                                {{ $documentsCompleted ? 'Complete' : 'Missing' }}

                            </span>

                        </div>

                        <h3>
                            KYC Documents
                        </h3>

                        <div class="review-check-list">

                            <div class="review-check-row">

                                <span>
                                    <i class="fa-solid fa-file-lines"></i>
                                    Business Certificate
                                </span>

                                @if(!empty($seller->business_certificate_path))

                                    <strong class="check">
                                        <i class="fa-solid fa-check"></i>
                                        Uploaded
                                    </strong>

                                @else

                                    <strong class="missing">
                                        Missing
                                    </strong>

                                @endif

                            </div>

                            <div class="review-check-row">

                                <span>
                                    <i class="fa-solid fa-id-card"></i>
                                    Aadhaar Document
                                </span>

                                @if(!empty($seller->aadhaar_document_path))

                                    <strong class="check">
                                        <i class="fa-solid fa-check"></i>
                                        Uploaded
                                    </strong>

                                @else

                                    <strong class="missing">
                                        Missing
                                    </strong>

                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- AADHAAR --}}

                    <div class="review-card">

                        <div class="review-card-top">

                            <div class="review-icon blue">
                                <i class="fa-solid fa-id-card"></i>
                            </div>

                            <span class="review-status {{ $aadhaarCompleted ? 'success' : 'pending' }}">

                                {{ $aadhaarCompleted ? 'Verified' : 'Pending' }}

                            </span>

                        </div>

                        <h3>
                            Aadhaar Verification
                        </h3>

                        @if($aadhaarCompleted)

                            <div class="review-success">

                                <i class="fa-solid fa-circle-check"></i>

                                Aadhaar verified successfully

                            </div>

                        @else

                            <div class="review-pending">

                                <i class="fa-solid fa-clock"></i>

                                Verification pending

                            </div>

                        @endif

                    </div>


                    {{-- BUSINESS --}}

                    <div class="review-card">

                        <div class="review-card-top">

                            <div class="review-icon blue">
                                <i class="fa-solid fa-building"></i>
                            </div>

                            <span class="review-status {{ $businessCompleted ? 'success' : 'pending' }}">

                                {{ $businessCompleted ? 'Complete' : 'Pending' }}

                            </span>

                        </div>

                        <h3>
                            Business Details
                        </h3>

                        <div class="review-details">

                            <div class="review-row">

                                <span>Type</span>

                                <strong>
                                    {{ $seller->business_type ?: 'Not provided' }}
                                </strong>

                            </div>

                            <div class="review-row">

                                <span>PAN</span>

                                <strong>
                                    {{ $maskedPan }}
                                </strong>

                            </div>

                            <div class="review-row">

                                <span>Udyam</span>

                                <strong>
                                    {{ $seller->udyam_number ?: 'Not provided' }}
                                </strong>

                            </div>

                            <div class="review-row">

                                <span>GST</span>

                                <strong>
                                    {{ $seller->gst_number ?: 'Not provided' }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- BANK --}}

                    <div class="review-card">

                        <div class="review-card-top">

                            <div class="review-icon blue">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>

                            <span class="review-status {{ $bankCompleted ? 'success' : 'pending' }}">

                                {{ $bankCompleted ? 'Complete' : 'Pending' }}

                            </span>

                        </div>

                        <h3>
                            Bank Details
                        </h3>

                        <div class="review-details">

                            <div class="review-row">

                                <span>Holder</span>

                                <strong>
                                    {{ $seller->bank_account_holder ?: 'Not provided' }}
                                </strong>

                            </div>

                            <div class="review-row">

                                <span>Bank</span>

                                <strong>
                                    {{ $seller->bank_name ?: 'Not provided' }}
                                </strong>

                            </div>

                            <div class="review-row">

                                <span>Account</span>

                                <strong>
                                    {{ $maskedBank }}
                                </strong>

                            </div>

                            <div class="review-row">

                                <span>IFSC</span>

                                <strong>
                                    {{ $seller->bank_ifsc ?: 'Not provided' }}
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- FINAL SUBMISSION --}}

                <div class="final-submit-box">

                    <div class="final-submit-icon">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>

                    <div class="final-submit-content">

                        <span class="final-submit-kicker">
                            FINAL APPLICATION
                        </span>

                        <h3>
                            Ready to submit your verification?
                        </h3>

                        <p>
                            By submitting this application, you confirm that
                            the information and documents provided are accurate
                            and belong to you or your business.
                        </p>

                    </div>

                </div>


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

                        <span class="custom-check"></span>

                        <span class="confirmation-text">
                            I confirm that all information provided above is
                            correct and I agree to SmartBasket seller
                            verification terms.
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

        </main>


        {{-- =========================================================
             STEP ACTION BAR
        ========================================================== --}}

        <footer class="verification-actions">

            <button
                type="button"
                id="backButton"
                class="secondary-button"
                {{ $currentStep <= 1 ? 'disabled' : '' }}
            >

                <i class="fa-solid fa-arrow-left"></i>

                Back

            </button>


            <div class="navigation-info">

                <span class="navigation-step-label">
                    Step {{ $currentStep }} of 6
                </span>

                <span class="navigation-dot">
                    •
                </span>

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

                    Continue

                    <i class="fa-solid fa-arrow-right"></i>

                </button>

            @else

                <span class="final-ready-label">

                    <span class="final-ready-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </span>

                    Final review

                </span>

            @endif

        </footer>

    </div>

</div>

@endsection


@push('styles')

<style>

:root {

    --kyc-primary: #2563eb;
    --kyc-primary-dark: #1d4ed8;
    --kyc-primary-deep: #1e40af;

    --kyc-primary-soft: #eff6ff;
    --kyc-primary-soft-2: #dbeafe;

    --kyc-blue-border: #bfdbfe;

    --kyc-success: #16a34a;
    --kyc-success-soft: #f0fdf4;
    --kyc-success-border: #bbf7d0;

    --kyc-warning: #d97706;
    --kyc-warning-soft: #fffbeb;
    --kyc-warning-border: #fde68a;

    --kyc-danger: #dc2626;
    --kyc-danger-soft: #fef2f2;
    --kyc-danger-border: #fecaca;

    --kyc-bg: #f4f8ff;
    --kyc-surface: #ffffff;
    --kyc-surface-soft: #f8fbff;

    --kyc-border: #e2e8f0;
    --kyc-border-dark: #cbd5e1;

    --kyc-text: #0f172a;
    --kyc-text-secondary: #334155;
    --kyc-muted: #64748b;
    --kyc-placeholder: #94a3b8;

    --kyc-radius-xl: 26px;
    --kyc-radius-lg: 20px;
    --kyc-radius-md: 15px;
    --kyc-radius-sm: 11px;

    --kyc-shadow:
        0 24px 70px rgba(15, 23, 42, .10);

    --kyc-shadow-soft:
        0 8px 28px rgba(15, 23, 42, .06);

}


/* ================================================================
   MAIN SHELL
================================================================ */

.seller-verification-shell {

    width: 100%;
    min-height: calc(100vh - 50px);

    box-sizing: border-box;

    padding: 24px 24px 42px;

    background:
        radial-gradient(
            circle at 0% 0%,
            rgba(37, 99, 235, .09),
            transparent 28%
        ),
        radial-gradient(
            circle at 100% 100%,
            rgba(59, 130, 246, .07),
            transparent 26%
        ),
        linear-gradient(
            180deg,
            #f8fbff 0%,
            #f2f7ff 100%
        );

}


/* ================================================================
   MAIN CARD
================================================================ */

.seller-verification-card {

    width: min(1580px, 100%);

    margin: 0 auto;

    overflow: hidden;

    background: var(--kyc-surface);

    border: 1px solid var(--kyc-border);

    border-radius: var(--kyc-radius-xl);

    box-shadow: var(--kyc-shadow);

}


/* ================================================================
   HEADER
================================================================ */

.verification-header {

    position: relative;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 30px;

    padding: 34px 38px;

    color: #fff;

    background:
        radial-gradient(
            circle at 85% 15%,
            rgba(96, 165, 250, .28),
            transparent 30%
        ),
        linear-gradient(
            135deg,
            #1e40af 0%,
            #2563eb 52%,
            #1d4ed8 100%
        );

}


.verification-header::after {

    content: "";

    position: absolute;

    right: 0;
    bottom: 0;
    left: 0;

    height: 1px;

    background: rgba(255,255,255,.18);

}


.header-main {

    min-width: 0;

}


.eyebrow {

    display: flex;

    align-items: center;

    gap: 8px;

    margin-bottom: 13px;

    color: #dbeafe;

    font-size: .68rem;

    font-weight: 900;

    letter-spacing: .18em;

}


.eyebrow-dot {

    width: 7px;
    height: 7px;

    border-radius: 50%;

    background: #fff;

    box-shadow: 0 0 0 5px rgba(255,255,255,.12);

}


.header-title-row {

    display: flex;

    align-items: center;

    gap: 16px;

}


.header-title-icon {

    width: 56px;
    height: 56px;

    flex: 0 0 56px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 17px;

    color: #fff;

    background: rgba(255,255,255,.13);

    border: 1px solid rgba(255,255,255,.20);

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.10),
        0 10px 25px rgba(15,23,42,.10);

    font-size: 1.35rem;

}


.verification-header h1 {

    margin: 0;

    color: #fff;

    font-size: clamp(2rem, 3vw, 3rem);

    line-height: 1.05;

    font-weight: 900;

    letter-spacing: -.045em;

}


.verification-header h1 span {

    color: #dbeafe;

}


.header-copy p {

    max-width: 700px;

    margin: 9px 0 0;

    color: #dbeafe;

    font-size: .92rem;

    line-height: 1.6;

}


.header-right {

    display: flex;

    align-items: flex-end;

    flex-direction: column;

    gap: 13px;

    flex-shrink: 0;

}


.progress-summary {

    width: 210px;

}


.progress-summary-top {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 7px;

    color: #dbeafe;

    font-size: .68rem;

    font-weight: 800;

}


.progress-summary-top strong {

    color: #fff;

    font-size: .72rem;

}


.progress-track {

    width: 100%;

    height: 6px;

    overflow: hidden;

    border-radius: 99px;

    background: rgba(255,255,255,.16);

}


.progress-value {

    display: block;

    height: 100%;

    border-radius: inherit;

    background: #fff;

    transition: width .35s ease;

}


.step-pill {

    display: inline-flex;

    align-items: center;

    gap: 9px;

    padding: 10px 15px;

    border-radius: 999px;

    color: #fff;

    background: rgba(255,255,255,.11);

    border: 1px solid rgba(255,255,255,.20);

    font-size: .75rem;

    font-weight: 900;

}


.step-pill-icon {

    width: 25px;
    height: 25px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: rgba(255,255,255,.15);

}


/* ================================================================
   STEPPER
================================================================ */

.stepper-wrapper {

    padding: 18px 24px;

    background: #fff;

    border-bottom: 1px solid var(--kyc-border);

}


.stepper {

    display: grid;

    grid-template-columns: repeat(6, minmax(0, 1fr));

    gap: 10px;

}


.step-item {

    min-width: 0;

    min-height: 70px;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 10px;

    padding: 10px 12px;

    border: 1px solid var(--kyc-border);

    border-radius: 15px;

    background: #fff;

    color: var(--kyc-text-secondary);

    cursor: pointer;

    text-align: left;

    transition:
        transform .18s ease,
        border-color .18s ease,
        background .18s ease,
        box-shadow .18s ease;

}


.step-item:hover:not(:disabled) {

    transform: translateY(-2px);

    border-color: var(--kyc-blue-border);

    box-shadow: var(--kyc-shadow-soft);

}


.step-item.active {

    color: var(--kyc-primary-deep);

    background: var(--kyc-primary-soft);

    border-color: #93c5fd;

    box-shadow:
        0 0 0 3px rgba(37,99,235,.06);

}


.step-item.complete {

    color: #166534;

    background: #f7fef9;

    border-color: var(--kyc-success-border);

}


.step-item.locked {

    color: #94a3b8;

    background: #f8fafc;

    opacity: .68;

    cursor: not-allowed;

}


.step-number {

    width: 34px;
    height: 34px;

    flex: 0 0 34px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    color: #64748b;

    background: #f1f5f9;

    border: 1px solid #e2e8f0;

    font-size: .75rem;

    font-weight: 900;

}


.step-item.active .step-number {

    color: #fff;

    background: var(--kyc-primary);

    border-color: var(--kyc-primary);

}


.step-item.complete .step-number {

    color: #fff;

    background: var(--kyc-success);

    border-color: var(--kyc-success);

}


.step-content {

    min-width: 0;

    display: flex;

    flex-direction: column;

    gap: 2px;

}


.step-label {

    font-size: .77rem;

    font-weight: 900;

    white-space: nowrap;

}


.step-state {

    color: #94a3b8;

    font-size: .62rem;

    font-weight: 700;

}


.step-item.active .step-state {

    color: #3b82f6;

}


.step-item.complete .step-state {

    color: #16a34a;

}


/* ================================================================
   ALERTS
================================================================ */

.global-alert {

    position: relative;

    margin: 20px 30px 0;

    padding: 14px 16px;

    display: flex;

    align-items: flex-start;

    gap: 12px;

    border: 1px solid;

    border-radius: 14px;

}


.success-alert {

    color: #166534;

    background: var(--kyc-success-soft);

    border-color: var(--kyc-success-border);

}


.error-alert {

    color: #991b1b;

    background: var(--kyc-danger-soft);

    border-color: var(--kyc-danger-border);

}


.alert-icon {

    width: 30px;
    height: 30px;

    flex: 0 0 30px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: rgba(255,255,255,.75);

}


.alert-content {

    min-width: 0;

    display: flex;

    flex-direction: column;

    gap: 2px;

    padding-top: 2px;

    font-size: .84rem;

    line-height: 1.55;

}


.alert-content strong {

    font-weight: 900;

}


.alert-content ul {

    margin: 7px 0 0;

    padding-left: 18px;

}


.alert-close {

    margin-left: auto;

    border: 0;

    background: transparent;

    color: inherit;

    cursor: pointer;

    opacity: .65;

}


.alert-close:hover {

    opacity: 1;

}


/* ================================================================
   PANELS
================================================================ */

.verification-panels {

    padding: 34px 34px 26px;

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


/* ================================================================
   PANEL HEADING
================================================================ */

.panel-heading {

    display: flex;

    align-items: flex-start;

    justify-content: space-between;

    gap: 20px;

    margin-bottom: 25px;

}


.panel-heading-left {

    display: flex;

    align-items: flex-start;

    gap: 14px;

    min-width: 0;

}


.panel-icon {

    width: 48px;
    height: 48px;

    flex: 0 0 48px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 14px;

}


.panel-icon.blue {

    color: var(--kyc-primary);

    background: var(--kyc-primary-soft);

    border: 1px solid var(--kyc-blue-border);

}


.panel-kicker {

    margin-top: 2px;

    color: var(--kyc-primary);

    font-size: .65rem;

    font-weight: 900;

    letter-spacing: .13em;

    text-transform: uppercase;

}


.panel-title {

    margin: 5px 0 5px;

    color: var(--kyc-text);

    font-size: clamp(1.45rem, 2.5vw, 2rem);

    line-height: 1.15;

    font-weight: 900;

    letter-spacing: -.035em;

}


.panel-description {

    max-width: 800px;

    margin: 0;

    color: var(--kyc-muted);

    font-size: .88rem;

    line-height: 1.6;

}


/* ================================================================
   STATUS
================================================================ */

.status-tag {

    flex-shrink: 0;

    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 7px 11px;

    border-radius: 999px;

    border: 1px solid;

    font-size: .62rem;

    font-weight: 900;

    letter-spacing: .07em;

    text-transform: uppercase;

}


.status-dot {

    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: currentColor;

}


.status-tag.green {

    color: #15803d;

    background: var(--kyc-success-soft);

    border-color: var(--kyc-success-border);

}


.status-tag.amber {

    color: #b45309;

    background: var(--kyc-warning-soft);

    border-color: var(--kyc-warning-border);

}


.status-tag.blue {

    color: var(--kyc-primary);

    background: var(--kyc-primary-soft);

    border-color: var(--kyc-blue-border);

}


/* ================================================================
   SECURITY NOTE
================================================================ */

.security-note {

    display: flex;

    align-items: flex-start;

    gap: 12px;

    margin-bottom: 20px;

    padding: 15px 17px;

    border: 1px solid var(--kyc-blue-border);

    border-radius: 15px;

    background: linear-gradient(
        135deg,
        #f8fbff,
        #eff6ff
    );

}


.security-note-icon {

    width: 36px;
    height: 36px;

    flex: 0 0 36px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    color: var(--kyc-primary);

    background: #fff;

    border: 1px solid var(--kyc-blue-border);

}


.security-note strong {

    display: block;

    margin: 1px 0 3px;

    color: var(--kyc-text);

    font-size: .81rem;

    font-weight: 900;

}


.security-note p {

    margin: 0;

    color: var(--kyc-muted);

    font-size: .76rem;

    line-height: 1.55;

}


/* ================================================================
   FORM CARDS
================================================================ */

.form-card {

    margin-bottom: 18px;

    padding: 22px;

    background: #fff;

    border: 1px solid var(--kyc-border);

    border-radius: var(--kyc-radius-lg);

    box-shadow: 0 5px 18px rgba(15,23,42,.025);

}


.secondary-form-card {

    background: var(--kyc-surface-soft);

}


.form-card-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    margin-bottom: 20px;

}


.form-card-header h3 {

    margin: 0 0 4px;

    color: var(--kyc-text);

    font-size: .98rem;

    font-weight: 900;

}


.form-card-header p {

    margin: 0;

    color: var(--kyc-muted);

    font-size: .75rem;

}


.mini-icon {

    width: 40px;
    height: 40px;

    flex: 0 0 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    color: var(--kyc-primary);

    background: var(--kyc-primary-soft);

    border: 1px solid var(--kyc-blue-border);

}


.mini-icon.success {

    color: var(--kyc-success);

    background: var(--kyc-success-soft);

    border-color: var(--kyc-success-border);

}


/* ================================================================
   SECTION HEADING
================================================================ */

.section-heading {

    display: flex;

    align-items: center;

    gap: 12px;

    margin-bottom: 22px;

    padding-bottom: 16px;

    border-bottom: 1px solid #edf2f7;

}


.section-heading-icon {

    width: 38px;
    height: 38px;

    flex: 0 0 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    color: var(--kyc-primary);

    background: var(--kyc-primary-soft);

}


.section-heading h3 {

    margin: 0 0 3px;

    color: var(--kyc-text);

    font-size: .92rem;

    font-weight: 900;

}


.section-heading p {

    margin: 0;

    color: var(--kyc-muted);

    font-size: .73rem;

}


/* ================================================================
   FORMS
================================================================ */

.stacked-form {

    display: flex;

    flex-direction: column;

    gap: 18px;

}


.grid-two {

    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 18px;

}


.full-span {

    grid-column: 1 / -1;

}


.field-block {

    display: flex;

    flex-direction: column;

    gap: 7px;

}


.form-label {

    color: var(--kyc-text-secondary);

    font-size: .78rem;

    font-weight: 850;

}


.form-label span {

    color: var(--kyc-danger);

}


.form-input {

    width: 100%;

    min-height: 47px;

    box-sizing: border-box;

    padding: 11px 13px;

    border: 1px solid #dbe3ed;

    border-radius: 11px;

    outline: none;

    color: var(--kyc-text);

    background: #fff;

    font-size: .84rem;

    transition:
        border-color .18s ease,
        box-shadow .18s ease,
        background .18s ease;

}


.form-input:hover {

    border-color: #cbd5e1;

}


.form-input:focus {

    border-color: #60a5fa;

    box-shadow:
        0 0 0 3px rgba(37,99,235,.10);

}


.form-input::placeholder {

    color: var(--kyc-placeholder);

}


select.form-input {

    cursor: pointer;

}


select.form-input option {

    color: #0f172a;

    background: #fff;

}


.textarea-input {

    min-height: 95px;

    resize: vertical;

}


.input-with-icon {

    position: relative;

}


.input-with-icon > i {

    position: absolute;

    left: 14px;

    top: 50%;

    z-index: 2;

    color: #94a3b8;

    transform: translateY(-50%);

    pointer-events: none;

    font-size: .78rem;

}


.input-with-icon .form-input {

    padding-left: 39px;

}


.uppercase-input {

    text-transform: uppercase;

}


.code-input {

    letter-spacing: .18em;

    font-weight: 850;

}


.field-help {

    color: var(--kyc-muted);

    font-size: .70rem;

    line-height: 1.5;

}


/* ================================================================
   BUTTONS
================================================================ */

.primary-button,
.secondary-button,
.success-button {

    min-height: 46px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    padding: 11px 18px;

    border-radius: 11px;

    border: 1px solid transparent;

    font-size: .78rem;

    font-weight: 900;

    cursor: pointer;

    transition:
        transform .18s ease,
        box-shadow .18s ease,
        background .18s ease,
        opacity .18s ease;

}


.primary-button {

    color: #fff;

    background:
        linear-gradient(
            135deg,
            var(--kyc-primary),
            var(--kyc-primary-dark)
        );

    box-shadow:
        0 7px 17px rgba(37,99,235,.17);

}


.primary-button:hover {

    transform: translateY(-1px);

    box-shadow:
        0 10px 22px rgba(37,99,235,.23);

}


.secondary-button {

    color: var(--kyc-text-secondary);

    background: #fff;

    border-color: var(--kyc-border);

}


.secondary-button:hover {

    transform: translateY(-1px);

    border-color: var(--kyc-blue-border);

    color: var(--kyc-primary);

    background: var(--kyc-primary-soft);

}


.secondary-button:disabled {

    opacity: .40;

    cursor: not-allowed;

    transform: none;

    box-shadow: none;

}


.success-button {

    color: #fff;

    background:
        linear-gradient(
            135deg,
            #16a34a,
            #15803d
        );

    box-shadow:
        0 7px 17px rgba(22,163,74,.15);

}


.success-button:hover {

    transform: translateY(-1px);

}


.wide-button {

    width: 100%;

}


/* ================================================================
   UPLOAD
================================================================ */

.upload-grid {

    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 18px;

}


.upload-box {

    position: relative;

    display: flex;

    flex-direction: column;

    gap: 13px;

    padding: 20px;

    border: 1px solid var(--kyc-border);

    border-radius: 18px;

    background: var(--kyc-surface-soft);

    transition:
        border-color .18s ease,
        box-shadow .18s ease,
        transform .18s ease;

}


.upload-box:hover {

    border-color: var(--kyc-blue-border);

    box-shadow: var(--kyc-shadow-soft);

    transform: translateY(-1px);

}


.upload-header {

    display: flex;

    align-items: center;

    gap: 11px;

}


.upload-icon {

    width: 43px;
    height: 43px;

    flex: 0 0 43px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    color: var(--kyc-primary);

    background: var(--kyc-primary-soft);

    border: 1px solid var(--kyc-blue-border);

}


.upload-header strong {

    display: block;

    color: var(--kyc-text);

    font-size: .84rem;

    font-weight: 900;

}


.upload-header small {

    display: block;

    margin-top: 3px;

    color: var(--kyc-muted);

    font-size: .68rem;

}


.file-drop-zone {

    min-height: 105px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-direction: column;

    gap: 5px;

    padding: 18px;

    border: 1.5px dashed #bfdbfe;

    border-radius: 14px;

    color: var(--kyc-primary);

    background: #fff;

    cursor: pointer;

    text-align: center;

    transition:
        border-color .18s ease,
        background .18s ease;

}


.file-drop-zone:hover {

    border-color: var(--kyc-primary);

    background: var(--kyc-primary-soft);

}


.file-drop-icon {

    font-size: 1.2rem;

}


.file-drop-title {

    color: var(--kyc-text);

    font-size: .78rem;

    font-weight: 850;

}


.file-drop-subtitle {

    color: var(--kyc-muted);

    font-size: .65rem;

}


.native-file-input {

    position: absolute;

    width: 1px;
    height: 1px;

    opacity: 0;

    pointer-events: none;

}


.selected-file {

    display: none;

    padding: 8px 10px;

    border-radius: 9px;

    color: var(--kyc-primary-deep);

    background: var(--kyc-primary-soft);

    border: 1px solid var(--kyc-blue-border);

    font-size: .70rem;

    font-weight: 800;

}


.selected-file.show {

    display: block;

}


.uploaded-status {

    display: flex;

    align-items: center;

    gap: 7px;

    color: #15803d;

    font-size: .72rem;

    font-weight: 850;

}


.bank-proof-upload {

    position: relative;

}


.bank-proof-label {

    display: flex;

    align-items: center;

    gap: 13px;

    padding: 16px;

    border: 1px dashed #bfdbfe;

    border-radius: 13px;

    background: var(--kyc-primary-soft);

    cursor: pointer;

}


.bank-proof-label strong {

    display: block;

    margin-bottom: 3px;

    color: var(--kyc-text);

    font-size: .78rem;

}


.bank-proof-label small {

    color: var(--kyc-muted);

    font-size: .67rem;

}


.bank-proof-icon {

    width: 40px;
    height: 40px;

    flex: 0 0 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 11px;

    color: var(--kyc-primary);

    background: #fff;

    border: 1px solid var(--kyc-blue-border);

}


/* ================================================================
   INFO BOX
================================================================ */

.info-box {

    display: flex;

    align-items: flex-start;

    gap: 13px;

    margin-bottom: 20px;

    padding: 17px;

    border: 1px solid var(--kyc-warning-border);

    border-radius: 15px;

    background: var(--kyc-warning-soft);

}


.info-box-icon {

    width: 38px;
    height: 38px;

    flex: 0 0 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    color: var(--kyc-warning);

    background: #fff;

}


.info-box strong {

    display: block;

    color: #92400e;

    font-size: .82rem;

    font-weight: 900;

}


.info-box p {

    margin: 4px 0 0;

    color: #a16207;

    font-size: .75rem;

    line-height: 1.55;

}


/* ================================================================
   REVIEW BANNER
================================================================ */

.review-banner {

    display: flex;

    align-items: flex-start;

    gap: 13px;

    margin-bottom: 22px;

    padding: 17px;

    border: 1px solid var(--kyc-blue-border);

    border-radius: 16px;

    background:
        linear-gradient(
            135deg,
            #f8fbff,
            #eff6ff
        );

}


.review-banner-icon {

    width: 42px;
    height: 42px;

    flex: 0 0 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    color: var(--kyc-primary);

    background: #fff;

    border: 1px solid var(--kyc-blue-border);

}


.review-banner strong {

    display: block;

    color: var(--kyc-text);

    font-size: .83rem;

    font-weight: 900;

}


.review-banner p {

    margin: 4px 0 0;

    color: var(--kyc-muted);

    font-size: .74rem;

    line-height: 1.55;

}


/* ================================================================
   REVIEW GRID
================================================================ */

.review-grid {

    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 18px;

}


.review-card {

    padding: 20px;

    border: 1px solid var(--kyc-border);

    border-radius: 18px;

    background: #fff;

    box-shadow: 0 5px 18px rgba(15,23,42,.025);

}


.review-card-top {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 10px;

    margin-bottom: 13px;

}


.review-icon {

    width: 40px;
    height: 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 11px;

}


.review-icon.blue {

    color: var(--kyc-primary);

    background: var(--kyc-primary-soft);

}


.review-icon.green {

    color: var(--kyc-success);

    background: var(--kyc-success-soft);

}


.review-card h3 {

    margin: 0 0 15px;

    color: var(--kyc-text);

    font-size: .92rem;

    font-weight: 900;

}


.review-status {

    display: inline-flex;

    align-items: center;

    padding: 5px 8px;

    border-radius: 999px;

    font-size: .59rem;

    font-weight: 900;

    text-transform: uppercase;

    letter-spacing: .06em;

}


.review-status.success {

    color: #15803d;

    background: var(--kyc-success-soft);

}


.review-status.pending {

    color: #b45309;

    background: var(--kyc-warning-soft);

}


.review-status.neutral {

    color: #475569;

    background: #f1f5f9;

}


.review-details {

    display: flex;

    flex-direction: column;

    gap: 9px;

}


.review-row {

    display: flex;

    align-items: flex-start;

    justify-content: space-between;

    gap: 14px;

    padding-bottom: 9px;

    border-bottom: 1px solid #f1f5f9;

}


.review-row:last-child {

    padding-bottom: 0;

    border-bottom: 0;

}


.review-row span {

    color: var(--kyc-muted);

    font-size: .70rem;

}


.review-row strong {

    max-width: 65%;

    color: var(--kyc-text-secondary);

    font-size: .72rem;

    font-weight: 800;

    text-align: right;

    word-break: break-word;

}


.review-check-list {

    display: flex;

    flex-direction: column;

    gap: 11px;

}


.review-check-row {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 12px;

    padding: 10px 11px;

    border-radius: 10px;

    background: #f8fafc;

}


.review-check-row > span {

    display: flex;

    align-items: center;

    gap: 8px;

    color: var(--kyc-text-secondary);

    font-size: .71rem;

    font-weight: 700;

}


.review-check-row > span i {

    color: var(--kyc-primary);

}


.review-check-row strong {

    font-size: .66rem;

    font-weight: 900;

}


.review-check-row strong.check {

    color: #15803d;

}


.review-check-row strong.missing {

    color: #dc2626;

}


.review-success {

    display: flex;

    align-items: center;

    gap: 8px;

    padding: 11px 12px;

    border-radius: 10px;

    color: #15803d;

    background: var(--kyc-success-soft);

    font-size: .73rem;

    font-weight: 850;

}


.review-pending {

    display: flex;

    align-items: center;

    gap: 8px;

    padding: 11px 12px;

    border-radius: 10px;

    color: #b45309;

    background: var(--kyc-warning-soft);

    font-size: .73rem;

    font-weight: 850;

}


/* ================================================================
   FINAL SUBMIT
================================================================ */

.final-submit-box {

    display: flex;

    align-items: flex-start;

    gap: 14px;

    margin-top: 22px;

    padding: 20px;

    border: 1px solid var(--kyc-blue-border);

    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            #f8fbff,
            #eff6ff
        );

}


.final-submit-icon {

    width: 46px;
    height: 46px;

    flex: 0 0 46px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 13px;

    color: #fff;

    background:
        linear-gradient(
            135deg,
            var(--kyc-primary),
            var(--kyc-primary-dark)
        );

    box-shadow:
        0 8px 20px rgba(37,99,235,.18);

}


.final-submit-kicker {

    display: block;

    margin-bottom: 3px;

    color: var(--kyc-primary);

    font-size: .62rem;

    font-weight: 900;

    letter-spacing: .12em;

}


.final-submit-box h3 {

    margin: 0 0 5px;

    color: var(--kyc-text);

    font-size: .98rem;

    font-weight: 900;

}


.final-submit-box p {

    margin: 0;

    color: var(--kyc-muted);

    font-size: .76rem;

    line-height: 1.6;

}


/* ================================================================
   CONFIRMATION
================================================================ */

#finalSubmitForm {

    margin-top: 17px;

}


.confirmation-check {

    position: relative;

    display: flex;

    align-items: flex-start;

    gap: 10px;

    padding: 12px 0;

    color: var(--kyc-text-secondary);

    font-size: .76rem;

    line-height: 1.55;

    cursor: pointer;

}


.confirmation-check input {

    position: absolute;

    opacity: 0;

    pointer-events: none;

}


.custom-check {

    width: 19px;
    height: 19px;

    flex: 0 0 19px;

    margin-top: 1px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    border: 1.5px solid #cbd5e1;

    border-radius: 5px;

    background: #fff;

    transition:
        background .18s ease,
        border-color .18s ease;

}


.confirmation-check input:checked + .custom-check {

    background: var(--kyc-primary);

    border-color: var(--kyc-primary);

}


.confirmation-check input:checked + .custom-check::after {

    content: "\f00c";

    color: #fff;

    font-family: "Font Awesome 6 Free";

    font-size: .62rem;

    font-weight: 900;

}


.confirmation-check input:focus-visible + .custom-check {

    box-shadow:
        0 0 0 3px rgba(37,99,235,.12);

}


.confirmation-text {

    padding-top: 1px;

}


.submit-application-button {

    width: 100%;

    min-height: 54px;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 9px;

    border: 0;

    border-radius: 13px;

    color: #fff;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );

    box-shadow:
        0 9px 24px rgba(37,99,235,.18);

    font-size: .78rem;

    font-weight: 950;

    letter-spacing: .035em;

    cursor: pointer;

    transition:
        transform .18s ease,
        box-shadow .18s ease,
        opacity .18s ease;

}


.submit-application-button:hover {

    transform: translateY(-1px);

    box-shadow:
        0 13px 30px rgba(37,99,235,.24);

}


.submit-application-button:disabled {

    opacity: .65;

    cursor: wait;

    transform: none;

}


/* ================================================================
   ACTION BAR
================================================================ */

.verification-actions {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    padding: 18px 34px 25px;

    border-top: 1px solid var(--kyc-border);

    background: #fbfdff;

}


.navigation-info {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    color: var(--kyc-muted);

    font-size: .73rem;

    font-weight: 700;

}


.navigation-step-label {

    color: var(--kyc-text-secondary);

    font-weight: 900;

}


.navigation-dot {

    color: #cbd5e1;

}


.final-ready-label {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 9px 12px;

    border-radius: 999px;

    color: #15803d;

    background: var(--kyc-success-soft);

    border: 1px solid var(--kyc-success-border);

    font-size: .69rem;

    font-weight: 900;

}


.final-ready-icon {

    display: inline-flex;

}


/* ================================================================
   FOCUS ACCESSIBILITY
================================================================ */

button:focus-visible,
label:focus-visible,
input:focus-visible,
select:focus-visible,
textarea:focus-visible {

    outline: 3px solid rgba(37,99,235,.16);

    outline-offset: 2px;

}


/* ================================================================
   RESPONSIVE
================================================================ */

@media (max-width: 1200px) {

    .seller-verification-shell {

        padding-left: 16px;
        padding-right: 16px;

    }


    .verification-header {

        padding: 30px;

    }


    .verification-panels {

        padding-left: 26px;
        padding-right: 26px;

    }


    .verification-actions {

        padding-left: 26px;
        padding-right: 26px;

    }

}


@media (max-width: 980px) {

    .verification-header {

        align-items: flex-start;

        flex-direction: column;

    }


    .header-right {

        width: 100%;

        align-items: flex-start;

        flex-direction: row;

        justify-content: space-between;

    }


    .progress-summary {

        width: min(300px, 100%);

    }


    .stepper {

        grid-template-columns: repeat(3, minmax(0, 1fr));

    }


    .step-item {

        justify-content: flex-start;

    }

}


@media (max-width: 760px) {

    .seller-verification-shell {

        min-height: auto;

        padding: 10px;

    }


    .seller-verification-card {

        border-radius: 20px;

    }


    .verification-header {

        padding: 25px 20px;

    }


    .header-title-row {

        align-items: flex-start;

    }


    .header-title-icon {

        width: 45px;
        height: 45px;

        flex-basis: 45px;

        border-radius: 13px;

    }


    .verification-header h1 {

        font-size: 2rem;

    }


    .header-right {

        align-items: stretch;

        flex-direction: column;

    }


    .progress-summary {

        width: 100%;

    }


    .step-pill {

        align-self: flex-start;

    }


    .stepper-wrapper {

        padding: 12px;

    }


    .stepper {

        grid-template-columns: repeat(2, minmax(0, 1fr));

        gap: 7px;

    }


    .step-item {

        min-height: 58px;

        padding: 8px;

    }


    .step-state {

        display: none;

    }


    .verification-panels {

        padding: 23px 16px 18px;

    }


    .panel-heading {

        flex-direction: column;

        margin-bottom: 20px;

    }


    .status-tag {

        align-self: flex-start;

    }


    .grid-two,
    .upload-grid,
    .review-grid {

        grid-template-columns: 1fr;

    }


    .full-span {

        grid-column: auto;

    }


    .form-card {

        padding: 17px;

        border-radius: 16px;

    }


    .verification-actions {

        padding: 16px;

        flex-wrap: wrap;

    }


    .verification-actions .secondary-button,
    .verification-actions .primary-button {

        flex: 1;

    }


    .navigation-info {

        order: 3;

        width: 100%;

    }

}


@media (max-width: 480px) {

    .seller-verification-shell {

        padding: 5px;

    }


    .verification-header {

        padding: 22px 16px;

    }


    .eyebrow {

        font-size: .58rem;

        letter-spacing: .12em;

    }


    .header-title-row {

        gap: 10px;

    }


    .header-title-icon {

        width: 40px;
        height: 40px;

        flex-basis: 40px;

        border-radius: 11px;

        font-size: 1rem;

    }


    .verification-header h1 {

        font-size: 1.65rem;

    }


    .header-copy p {

        font-size: .78rem;

    }


    .stepper {

        grid-template-columns: 1fr 1fr;

    }


    .step-item {

        min-height: 48px;

        justify-content: center;

    }


    .step-number {

        width: 28px;
        height: 28px;

        flex-basis: 28px;

    }


    .step-label {

        font-size: .66rem;

    }


    .panel-heading-left {

        gap: 10px;

    }


    .panel-icon {

        width: 40px;
        height: 40px;

        flex-basis: 40px;

        border-radius: 11px;

    }


    .panel-title {

        font-size: 1.3rem;

    }


    .panel-description {

        font-size: .77rem;

    }


    .security-note {

        padding: 13px;

    }


    .security-note-icon {

        width: 32px;
        height: 32px;

        flex-basis: 32px;

    }


    .upload-box {

        padding: 15px;

    }


    .review-card {

        padding: 16px;

    }


    .review-row {

        flex-direction: column;

        gap: 3px;

    }


    .review-row strong {

        max-width: 100%;

        text-align: left;

    }


    .final-submit-box {

        flex-direction: column;

    }


    .verification-actions {

        gap: 8px;

    }


    .verification-actions .secondary-button,
    .verification-actions .primary-button {

        width: 100%;

        flex: 1 1 100%;

    }

}


/* ================================================================
   REDUCED MOTION
================================================================ */

@media (prefers-reduced-motion: reduce) {

    *,
    *::before,
    *::after {

        scroll-behavior: auto !important;

        animation-duration: .01ms !important;

        animation-iteration-count: 1 !important;

        transition-duration: .01ms !important;

    }

}

</style>

@endpush


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    'use strict';


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


    const verificationIndexUrl =
        @json(route('seller.verification.index'));


    function goToStep(step) {

        step = Number(step);

        if (step < 1 || step > 6) {
            return;
        }

        window.location.href =
            verificationIndexUrl + '?step=' + step;

    }


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

            backButton.disabled =
                step <= 1;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | STEP BUTTONS
    |--------------------------------------------------------------------------
    */

    stepButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            if (button.disabled) {
                return;
            }


            const target =
                Number(button.dataset.targetStep);


            if (target <= currentStep) {

                goToStep(target);

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

            goToStep(currentStep - 1);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | NEXT / CONTINUE
    |--------------------------------------------------------------------------
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
            |--------------------------------------------------------------------------
            | STEP 1
            |--------------------------------------------------------------------------
            */

            if (currentStep === 1) {

                @if($emailCompleted)

                    goToStep(2);

                @else

                    alert(
                        'Please verify your email before continuing.'
                    );

                @endif

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | STEP 2
            |--------------------------------------------------------------------------
            */

            if (currentStep === 2) {

                const uploadForm =
                    activePanel.querySelector(
                        'form[action*="documents.upload"]'
                    );


                if (!uploadForm) {
                    return;
                }


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
                        !businessFile.files ||
                        !businessFile.files.length
                    ) {

                        alert(
                            'Please upload your Business Certificate.'
                        );

                        return;

                    }


                    if (
                        !aadhaarFile ||
                        !aadhaarFile.files ||
                        !aadhaarFile.files.length
                    ) {

                        alert(
                            'Please upload your Aadhaar document.'
                        );

                        return;

                    }

                @endif


                uploadForm.requestSubmit();

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | STEP 3
            |--------------------------------------------------------------------------
            */

            if (currentStep === 3) {

                @if($aadhaarCompleted)

                    goToStep(4);

                @else

                    alert(
                        'Please complete Aadhaar verification before continuing.'
                    );

                @endif

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | STEP 4
            |--------------------------------------------------------------------------
            */

            if (currentStep === 4) {

                if (!form) {
                    return;
                }


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

                    businessType?.focus();

                    return;

                }


                if (
                    !pan ||
                    !pan.value.trim()
                ) {

                    alert(
                        'Please enter your PAN number.'
                    );

                    pan?.focus();

                    return;

                }


                if (
                    !udyam ||
                    !udyam.value.trim()
                ) {

                    alert(
                        'Please enter your Udyam number.'
                    );

                    udyam?.focus();

                    return;

                }


                form.requestSubmit();

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | STEP 5
            |--------------------------------------------------------------------------
            */

            if (currentStep === 5) {

                if (!form) {
                    return;
                }


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
                    account.value &&
                    !/^[0-9]+$/.test(account.value)
                ) {

                    alert(
                        'Please enter a valid bank account number.'
                    );

                    account.focus();

                    return;

                }


                form.requestSubmit();

                return;

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | BANK FORM VALIDATION
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
    | FINAL SUBMIT
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


                return;

            }


            const submitButton =
                document.getElementById(
                    'submitApplicationButton'
                );


            if (submitButton) {

                submitButton.disabled = true;


                submitButton.innerHTML =
                    '<i class="fa-solid fa-spinner fa-spin"></i> SUBMITTING APPLICATION...';

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | UPPERCASE INPUTS
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
    | NUMERIC INPUTS
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            'input[name="code"], input[name="otp"], input[name="pincode"]'
        )
        .forEach(function (input) {

            input.addEventListener(
                'input',
                function () {

                    this.value =
                        this.value.replace(/\D/g, '');

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | BANK ACCOUNT NUMBERS
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            'input[name="bank_account_number"], input[name="bank_account_number_confirmation"]'
        )
        .forEach(function (input) {

            input.addEventListener(
                'input',
                function () {

                    this.value =
                        this.value.replace(/\D/g, '');

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | FILE NAME PREVIEW
    |--------------------------------------------------------------------------
    */

    const fileInputs =
        document.querySelectorAll(
            '.native-file-input'
        );


    fileInputs.forEach(function (input) {

        input.addEventListener(
            'change',
            function () {

                const file =
                    this.files && this.files.length
                        ? this.files[0]
                        : null;


                const name =
                    this.getAttribute('name');


                const preview =
                    document.querySelector(
                        '[data-file-name="' + name + '"]'
                    );


                if (!preview) {
                    return;
                }


                if (file) {

                    preview.textContent =
                        'Selected: ' + file.name;

                    preview.classList.add('show');

                } else {

                    preview.textContent = '';

                    preview.classList.remove('show');

                }

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | ACTIVATE CURRENT STEP
    |--------------------------------------------------------------------------
    */

    activateStep(currentStep);

});

</script>

@endpush