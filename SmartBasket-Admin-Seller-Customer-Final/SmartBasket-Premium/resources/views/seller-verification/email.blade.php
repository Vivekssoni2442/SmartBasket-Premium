@extends('seller.partials.premium-layout')

@section('title', 'Email Verification | SmartBasket Premium')

@php
    $step = 1;
@endphp

@section('content')

<div class="sb-card">

    <div class="sb-step">
        STEP 1 OF 6
    </div>

    <h1 class="sb-title">
        Verify your seller email
    </h1>

    <p class="sb-description">
        Verify your registered Seller Email ID to begin your
        SmartBasket Seller Verification & KYC application.
    </p>


    {{-- SUCCESS MESSAGE --}}

    @if(session('success'))
        <div class="sb-alert sb-alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- ERROR MESSAGE --}}

    @if(session('error'))
        <div class="sb-alert sb-alert-error">
            {{ session('error') }}
        </div>
    @endif


    {{-- VALIDATION ERRORS --}}

    @if($errors->any())
        <div class="sb-alert sb-alert-error">

            <ul style="margin:0;padding-left:20px;">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>
    @endif


    {{-- =========================================================
        SEND VERIFICATION CODE
    ========================================================== --}}

    <form
        method="POST"
        action="{{ route('seller.verification.email.send') }}"
    >

        @csrf

        <div class="sb-field">

            <label class="sb-label" for="email">
                Seller Email Address *
            </label>

            <input
                id="email"
                type="email"
                name="email"
                class="sb-input"
                value="{{ old('email', $seller->email ?? '') }}"
                placeholder="Enter your registered email address"
                autocomplete="email"
                required
            >

            <small>
                A secure 16-digit verification code will be sent
                to this email address.
            </small>

        </div>


        <div class="sb-actions">

            <a
                href="{{ route('seller-dashboard') }}"
                class="sb-btn"
            >
                ← Back
            </a>

            <button
                type="submit"
                class="sb-btn sb-btn-primary"
            >
                Send Verification Code →
            </button>

        </div>

    </form>


    {{-- =========================================================
        VERIFY CODE
    ========================================================== --}}

    @if(
        session('verification_code_sent') ||
        session('email_verification_sent') ||
        old('email')
    )

        <div
            style="
                margin-top:28px;
                padding-top:26px;
                border-top:1px solid rgba(148,163,184,.18);
            "
        >

            <h2
                style="
                    margin:0 0 8px;
                    font-size:18px;
                    font-weight:700;
                "
            >
                Enter verification code
            </h2>

            <p
                style="
                    margin:0 0 20px;
                    color:#94a3b8;
                    font-size:13px;
                    line-height:1.6;
                "
            >
                Enter the 16-digit code sent to your registered
                email address.
            </p>


            <form
                method="POST"
                action="{{ route('seller.verification.email.verify') }}"
            >

                @csrf

                <div class="sb-field">

                    <label
                        class="sb-label"
                        for="code"
                    >
                        16-Digit Verification Code *
                    </label>

                    <input
                        id="code"
                        type="text"
                        name="code"
                        class="sb-input"
                        inputmode="numeric"
                        pattern="[0-9]{16}"
                        maxlength="16"
                        minlength="16"
                        autocomplete="one-time-code"
                        placeholder="Enter 16-digit code"
                        required
                    >

                    <small>
                        The verification code is valid for a limited
                        time and can only be used once.
                    </small>

                </div>


                <div class="sb-actions">

                    <button
                        type="submit"
                        class="sb-btn sb-btn-primary"
                    >
                        ✓ Verify Email & Continue →
                    </button>

                </div>

            </form>

        </div>

    @endif


    {{-- =========================================================
        VERIFICATION STATUS
    ========================================================== --}}

    @if(!empty($seller->email_verified_at))

        <div
            class="sb-alert sb-alert-success"
            style="margin-top:24px;"
        >

            ✓ Your email address has already been verified.

            <br>

            <small>
                Verified on
                {{ $seller->email_verified_at->format('d M Y, h:i A') }}
            </small>

        </div>


        <div class="sb-actions">

            <a
                href="{{ route('seller.verification.documents') }}"
                class="sb-btn sb-btn-primary"
            >
                Continue to Step 2 →
            </a>

        </div>

    @endif

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const codeInput = document.getElementById('code');

    if (!codeInput) {
        return;
    }

    codeInput.addEventListener('input', function () {

        this.value = this.value
            .replace(/\D/g, '')
            .slice(0, 16);

    });

});
</script>

@endsection