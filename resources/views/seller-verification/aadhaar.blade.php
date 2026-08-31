@extends('seller.partials.premium-layout')

@section('title', 'Aadhaar Verification')

@php
    $step = 3;
@endphp

@section('content')

<style>
/* =========================================================
   SMART BASKET
   SELLER KYC — STEP 3
   PREMIUM LIGHT THEME
========================================================= */

.aadhaar-page {
    --a-green: #00a86b;
    --a-green-dark: #008f5b;
    --a-green-soft: #ecfdf5;
    --a-green-border: #bbf7d0;

    --a-bg: #f6f8fb;
    --a-card: #ffffff;
    --a-card-soft: #f9fafb;

    --a-text: #111827;
    --a-heading: #0f172a;
    --a-muted: #64748b;

    --a-border: #e5e7eb;
    --a-border-soft: #eef2f7;

    --a-blue: #2563eb;
    --a-blue-soft: #eff6ff;

    width: 100%;
    max-width: 1080px;
    margin: 0 auto;
    padding: 8px 0 45px;

    color: var(--a-text);
}

/* =========================================================
   MAIN CARD
========================================================= */

.aadhaar-card {
    position: relative;
    overflow: hidden;

    background: var(--a-card);

    border: 1px solid var(--a-border);

    border-radius: 28px;

    box-shadow:
        0 25px 70px rgba(15, 23, 42, .08),
        0 8px 25px rgba(15, 23, 42, .04);
}

/* Decorative glow */

.aadhaar-card::before {
    content: "";

    position: absolute;

    width: 360px;
    height: 360px;

    right: -180px;
    top: -190px;

    border-radius: 50%;

    background: rgba(16, 185, 129, .10);

    filter: blur(55px);

    pointer-events: none;
}

/* =========================================================
   TOP PROGRESS
========================================================= */

.aadhaar-top {
    position: relative;
    z-index: 2;

    padding: 26px 32px 22px;

    border-bottom: 1px solid var(--a-border-soft);

    background:
        linear-gradient(
            180deg,
            #ffffff 0%,
            #fbfdfc 100%
        );
}

.aadhaar-top-row {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;
}

.step-info {
    display: flex;
    align-items: center;
    gap: 13px;
}

.step-number {
    width: 44px;
    height: 44px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 14px;

    background: linear-gradient(
        135deg,
        #00b878,
        #009b63
    );

    color: #ffffff;

    font-size: 15px;
    font-weight: 900;

    box-shadow:
        0 8px 20px rgba(0, 168, 107, .18);
}

.step-text strong {
    display: block;

    color: var(--a-heading);

    font-size: 13px;
    font-weight: 800;
}

.step-text span {
    display: block;

    margin-top: 3px;

    color: var(--a-muted);

    font-size: 10px;
}

/* Step pill */

.step-count {
    display: inline-flex;
    align-items: center;

    padding: 8px 13px;

    border-radius: 999px;

    background: var(--a-green-soft);

    border: 1px solid var(--a-green-border);

    color: var(--a-green-dark);

    font-size: 10px;
    font-weight: 800;
}

/* Progress */

.progress-line {
    display: grid;

    grid-template-columns: repeat(6, 1fr);

    gap: 7px;

    margin-top: 21px;
}

.progress-segment {
    height: 5px;

    border-radius: 999px;

    background: #e5e7eb;
}

.progress-segment.done,
.progress-segment.active {
    background: linear-gradient(
        90deg,
        #00b878,
        #16a66d
    );
}

/* =========================================================
   CONTENT
========================================================= */

.aadhaar-content {
    position: relative;
    z-index: 2;

    padding: 34px 32px 30px;
}

/* Header */

.aadhaar-header {
    display: flex;
    align-items: flex-start;

    gap: 16px;

    margin-bottom: 24px;
}

.aadhaar-main-icon {
    width: 58px;
    height: 58px;

    flex: 0 0 58px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 17px;

    background: var(--a-green-soft);

    border: 1px solid var(--a-green-border);

    color: var(--a-green);

    font-size: 22px;
}

.aadhaar-header h1 {
    margin: 0;

    color: var(--a-heading);

    font-size: clamp(24px, 3vw, 32px);

    font-weight: 850;

    letter-spacing: -.7px;
}

.aadhaar-header h1 span {
    color: var(--a-green);
}

.aadhaar-header p {
    max-width: 690px;

    margin: 7px 0 0;

    color: var(--a-muted);

    font-size: 11px;

    line-height: 1.65;
}

/* =========================================================
   SECURITY NOTICE
========================================================= */

.security-box {
    display: flex;
    align-items: flex-start;

    gap: 13px;

    padding: 16px 17px;

    margin-bottom: 24px;

    border-radius: 16px;

    background: linear-gradient(
        135deg,
        #f0fdf4,
        #ecfdf5
    );

    border: 1px solid #bbf7d0;
}

.security-icon {
    width: 39px;
    height: 39px;

    flex: 0 0 39px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: #ffffff;

    color: var(--a-green);

    border: 1px solid #d1fae5;

    box-shadow: 0 4px 12px rgba(16,185,129,.08);
}

.security-box h3 {
    margin: 0;

    color: #166534;

    font-size: 12px;
    font-weight: 850;
}

.security-box p {
    margin: 4px 0 0;

    color: #4b6358;

    font-size: 10px;

    line-height: 1.6;
}

/* =========================================================
   WARNING
========================================================= */

.aadhaar-alert {
    display: flex;
    align-items: flex-start;

    gap: 12px;

    padding: 16px;

    margin-bottom: 24px;

    border-radius: 16px;

    background: #fffbeb;

    border: 1px solid #fde68a;

    color: #92400e;

    font-size: 11px;

    line-height: 1.6;
}

.aadhaar-alert i {
    margin-top: 2px;

    color: #d97706;
}

/* =========================================================
   FORM GRID
========================================================= */

.verification-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 20px;
}

/* =========================================================
   VERIFICATION BOX
========================================================= */

.verification-box {
    position: relative;

    padding: 24px;

    border-radius: 20px;

    background: #ffffff;

    border: 1px solid var(--a-border);

    box-shadow:
        0 8px 25px rgba(15,23,42,.035);

    transition:
        transform .22s ease,
        box-shadow .22s ease,
        border-color .22s ease;
}

.verification-box:hover {
    transform: translateY(-2px);

    border-color: #b7e8d4;

    box-shadow:
        0 15px 35px rgba(15,23,42,.07);
}

/* top accent */

.verification-box::before {
    content: "";

    position: absolute;

    left: 24px;
    right: 24px;
    top: 0;

    height: 3px;

    border-radius:
        0 0 999px 999px;

    background:
        linear-gradient(
            90deg,
            #00b878,
            #4ade80
        );
}

/* Box Header */

.verification-box-header {
    display: flex;
    align-items: center;

    gap: 12px;

    margin-bottom: 20px;
}

.box-icon {
    width: 43px;
    height: 43px;

    flex: 0 0 43px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 13px;

    background: var(--a-green-soft);

    color: var(--a-green);

    border: 1px solid #d1fae5;

    font-size: 15px;
}

.verification-box h2 {
    margin: 0;

    color: var(--a-heading);

    font-size: 14px;
    font-weight: 850;
}

.box-description {
    margin-top: 4px;

    color: var(--a-muted);

    font-size: 9px;
}

/* =========================================================
   FORM
========================================================= */

.aadhaar-label {
    display: block;

    margin-bottom: 8px;

    color: var(--a-heading);

    font-size: 10px;

    font-weight: 800;
}

.required-mark {
    color: #dc2626;
}

/* Input */

.aadhaar-input {
    width: 100%;

    min-height: 49px;

    padding: 12px 14px;

    border-radius: 12px;

    border: 1px solid #dbe2ea;

    background: #ffffff;

    color: var(--a-heading);

    outline: none;

    font-family: inherit;

    font-size: 12px;

    transition:
        border-color .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}

.aadhaar-input:hover {
    border-color: #9edfc5;
}

.aadhaar-input:focus {
    border-color: #00b878;

    background: #fcfffd;

    box-shadow:
        0 0 0 4px rgba(0,184,120,.10);
}

.aadhaar-input::placeholder {
    color: #94a3b8;
}

.input-help {
    display: block;

    margin-top: 8px;

    color: #94a3b8;

    font-size: 9px;

    line-height: 1.55;
}

/* OTP */

.otp-input {
    letter-spacing: .32em;

    font-weight: 800;
}

/* =========================================================
   VERIFY BUTTON
========================================================= */

.verify-button {
    width: 100%;

    min-height: 49px;

    margin-top: 15px;

    border: 0;

    border-radius: 12px;

    background:
        linear-gradient(
            135deg,
            #00b878,
            #009b63
        );

    color: #ffffff;

    font-family: inherit;

    font-size: 11px;

    font-weight: 850;

    cursor: pointer;

    box-shadow:
        0 9px 22px rgba(0,168,107,.16);

    transition:
        transform .2s ease,
        box-shadow .2s ease,
        filter .2s ease;
}

.verify-button:hover {
    transform: translateY(-2px);

    filter: brightness(1.03);

    box-shadow:
        0 14px 30px rgba(0,168,107,.22);
}

.verify-button:active {
    transform: translateY(0);
}

.verify-button i {
    margin-right: 7px;
}

/* =========================================================
   DIVIDER
========================================================= */

.verification-divider {
    display: flex;

    align-items: center;

    gap: 12px;

    margin: 25px 0;
}

.verification-divider::before,
.verification-divider::after {
    content: "";

    flex: 1;

    height: 1px;

    background: var(--a-border);
}

.verification-divider span {
    color: #94a3b8;

    font-size: 9px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .08em;
}

/* =========================================================
   ACTIONS
========================================================= */

.aadhaar-actions {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    margin-top: 28px;

    padding-top: 24px;

    border-top: 1px solid var(--a-border);
}

.aadhaar-btn {
    min-height: 48px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    padding: 0 20px;

    border-radius: 12px;

    text-decoration: none;

    font-family: inherit;

    font-size: 11px;

    font-weight: 850;

    transition: .2s ease;
}

.aadhaar-back {
    background: #ffffff;

    color: #64748b;

    border: 1px solid #dbe2ea;
}

.aadhaar-back:hover {
    color: #334155;

    background: #f8fafc;

    border-color: #cbd5e1;

    transform: translateY(-1px);
}

.aadhaar-continue {
    color: #ffffff;

    background:
        linear-gradient(
            135deg,
            #00b878,
            #009b63
        );

    box-shadow:
        0 8px 20px rgba(0,168,107,.14);
}

.aadhaar-continue:hover {
    color: #ffffff;

    transform: translateY(-2px);

    box-shadow:
        0 13px 28px rgba(0,168,107,.21);
}

/* =========================================================
   FOOTER
========================================================= */

.aadhaar-footer {
    display: flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    margin-top: 17px;

    color: #94a3b8;

    font-size: 9px;
}

.aadhaar-footer i {
    color: var(--a-green);
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width: 800px) {

    .aadhaar-top {
        padding: 22px 20px;
    }

    .aadhaar-content {
        padding: 28px 20px;
    }

    .verification-grid {
        grid-template-columns: 1fr;
    }
}

@media(max-width: 560px) {

    .aadhaar-card {
        border-radius: 21px;
    }

    .aadhaar-top-row {
        align-items: flex-start;
    }

    .step-count {
        display: none;
    }

    .aadhaar-header {
        gap: 12px;
    }

    .aadhaar-main-icon {
        width: 48px;
        height: 48px;

        flex-basis: 48px;

        border-radius: 14px;

        font-size: 18px;
    }

    .aadhaar-header h1 {
        font-size: 22px;
    }

    .verification-box {
        padding: 20px;
    }

    .aadhaar-actions {
        flex-direction: column-reverse;
    }

    .aadhaar-btn {
        width: 100%;
    }

    .progress-line {
        gap: 4px;
    }
}
</style>


<div class="aadhaar-page">

    <div class="aadhaar-card">

        {{-- =====================================================
             TOP PROGRESS
        ====================================================== --}}

        <div class="aadhaar-top">

            <div class="aadhaar-top-row">

                <div class="step-info">

                    <div class="step-number">
                        3
                    </div>

                    <div class="step-text">

                        <strong>
                            Identity Verification
                        </strong>

                        <span>
                            Seller Partner Program
                        </span>

                    </div>

                </div>

                <div class="step-count">
                    STEP 3 OF 6
                </div>

            </div>


            <div class="progress-line">

                <div class="progress-segment done"></div>
                <div class="progress-segment done"></div>
                <div class="progress-segment active"></div>
                <div class="progress-segment"></div>
                <div class="progress-segment"></div>
                <div class="progress-segment"></div>

            </div>

        </div>


        {{-- =====================================================
             CONTENT
        ====================================================== --}}

        <div class="aadhaar-content">


            {{-- HEADER --}}

            <div class="aadhaar-header">

                <div class="aadhaar-main-icon">
                    <i class="fa-solid fa-id-card"></i>
                </div>

                <div>

                    <h1>
                        Aadhaar <span>Verification</span>
                    </h1>

                    <p>
                        Complete your identity verification securely
                        through the authorized verification provider.
                        This helps us keep the SmartBasket Seller Partner
                        Program safe and trusted.
                    </p>

                </div>

            </div>


            {{-- =================================================
                 SERVICE NOT CONFIGURED
            ================================================== --}}

            @if(! $configured)

                <div class="aadhaar-alert">

                    <i class="fa-solid fa-triangle-exclamation"></i>

                    <div>

                        <strong>
                            Aadhaar verification service is currently unavailable.
                        </strong>

                        <br>

                        Please contact the SmartBasket administrator or
                        configure the authorized verification provider
                        before continuing.

                    </div>

                </div>

            @else


                {{-- =================================================
                     SECURITY NOTICE
                ================================================== --}}

                <div class="security-box">

                    <div class="security-icon">

                        <i class="fa-solid fa-shield-halved"></i>

                    </div>

                    <div>

                        <h3>
                            Secure &amp; Privacy Protected
                        </h3>

                        <p>
                            Verification is completed through the authorized
                            provider. SmartBasket does not permanently retain
                            your Aadhaar number or provider OTP.
                        </p>

                    </div>

                </div>


                {{-- =================================================
                     VERIFICATION GRID
                ================================================== --}}

                <div class="verification-grid">


                    {{-- START VERIFICATION --}}

                    <div class="verification-box">

                        <div class="verification-box-header">

                            <div class="box-icon">
                                <i class="fa-solid fa-fingerprint"></i>
                            </div>

                            <div>

                                <h2>
                                    Start Verification
                                </h2>

                                <div class="box-description">
                                    Begin your Aadhaar verification
                                </div>

                            </div>

                        </div>


                        <form
                            method="POST"
                            action="{{ route('seller.verification.aadhaar.start') }}"
                        >

                            @csrf


                            <label class="aadhaar-label">

                                Aadhaar Identifier

                                <span class="required-mark">*</span>

                            </label>


                            <input
                                type="text"
                                name="aadhaar_identifier"
                                value="{{ old('aadhaar_identifier', $seller->verification_reference_id ?? '') }}"
                                class="aadhaar-input"
                                autocomplete="off"
                                inputmode="numeric"
                                maxlength="12"
                                placeholder="Enter Aadhaar identifier"
                                required
                            >


                            <small class="input-help">

                                Enter the identifier requested by the
                                authorized verification provider.

                            </small>


                            <button
                                type="submit"
                                class="verify-button"
                            >

                                <i class="fa-solid fa-arrow-right"></i>

                                Start Authorized Verification

                            </button>

                        </form>

                    </div>


                    {{-- OTP --}}

                    <div class="verification-box">

                        <div class="verification-box-header">

                            <div class="box-icon">

                                <i class="fa-solid fa-key"></i>

                            </div>

                            <div>

                                <h2>
                                    Verify OTP
                                </h2>

                                <div class="box-description">
                                    Confirm the OTP from your provider
                                </div>

                            </div>

                        </div>


                        <form
                            method="POST"
                            action="{{ route('seller.verification.aadhaar.verify') }}"
                        >

                            @csrf


                            <label class="aadhaar-label">

                                Provider OTP

                                <span class="required-mark">*</span>

                            </label>


                            <input
                                type="text"
                                name="otp"
                                class="aadhaar-input otp-input"
                                inputmode="numeric"
                                autocomplete="one-time-code"
                                maxlength="8"
                                placeholder="Enter OTP"
                                required
                            >


                            <small class="input-help">

                                Enter the one-time password received from
                                the authorized verification provider.

                            </small>


                            <button
                                type="submit"
                                class="verify-button"
                            >

                                <i class="fa-solid fa-circle-check"></i>

                                Verify Provider OTP

                            </button>

                        </form>

                    </div>

                </div>

            @endif


            {{-- =================================================
                 NAVIGATION
            ================================================== --}}

            <div class="aadhaar-actions">

                <a
                    href="{{ route('seller.verification.documents') }}"
                    class="aadhaar-btn aadhaar-back"
                >

                    <i class="fa-solid fa-arrow-left"></i>

                    Back to Documents

                </a>


                @if($configured)

                    <a
                        href="{{ route('seller.verification.business-details') }}"
                        class="aadhaar-btn aadhaar-continue"
                    >

                        Continue to Business Details

                        <i class="fa-solid fa-arrow-right"></i>

                    </a>

                @endif

            </div>


            {{-- FOOTER --}}

            <div class="aadhaar-footer">

                <i class="fa-solid fa-lock"></i>

                Secure seller verification powered by SmartBasket

            </div>

        </div>

    </div>

</div>

@endsection