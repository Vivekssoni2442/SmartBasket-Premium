@extends('seller.partials.premium-layout')

@section('title', 'Bank Details | SmartBasket Premium')

@php
    $step = 5;
@endphp

@section('content')

<style>
/* =========================================================
   SMART BASKET — BANK DETAILS
   PREMIUM LIGHT SELLER VERIFICATION UI
========================================================= */

:root {
    --bank-bg: #f4f8f6;
    --bank-card: #ffffff;
    --bank-soft: #f8fbfa;
    --bank-text: #17211f;
    --bank-muted: #71807b;
    --bank-line: #e2ebe7;
    --bank-green: #10a874;
    --bank-green-dark: #07885e;
    --bank-green-soft: #e8faf3;
    --bank-red: #d95c5c;
    --bank-red-soft: #fff2f2;
    --bank-shadow: 0 20px 55px rgba(25, 55, 47, .08);
}


/* =========================================================
   PAGE
========================================================= */

.bank-page {
    width: 100%;
    min-height: 100vh;

    padding: 30px 20px 65px;

    background:
        radial-gradient(
            circle at 5% 0%,
            rgba(16,168,116,.10),
            transparent 28%
        ),
        radial-gradient(
            circle at 95% 10%,
            rgba(59,130,246,.055),
            transparent 25%
        ),
        var(--bank-bg);

    color: var(--bank-text);
}

.bank-container {
    width: 100%;
    max-width: 980px;

    margin: 0 auto;
}


/* =========================================================
   MAIN CARD
========================================================= */

.bank-card {
    position: relative;
    overflow: hidden;

    padding: 32px;

    border-radius: 25px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #f9fcfb
        );

    border: 1px solid var(--bank-line);

    box-shadow: var(--bank-shadow);
}

.bank-card::before {
    content: "";

    position: absolute;

    width: 250px;
    height: 250px;

    right: -130px;
    top: -130px;

    border-radius: 50%;

    background: rgba(16,168,116,.07);

    filter: blur(10px);

    pointer-events: none;
}


/* =========================================================
   HEADER
========================================================= */

.bank-header {
    position: relative;
    z-index: 2;

    display: flex;
    align-items: flex-start;

    gap: 15px;

    padding-bottom: 23px;

    margin-bottom: 23px;

    border-bottom: 1px solid var(--bank-line);
}

.bank-header-icon {
    width: 50px;
    height: 50px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex: 0 0 50px;

    border-radius: 15px;

    background: var(--bank-green-soft);

    border: 1px solid #cdeee1;

    color: var(--bank-green);

    font-size: 19px;
}

.bank-step {
    margin-bottom: 5px;

    color: var(--bank-green);

    font-size: 9px;

    font-weight: 800;

    letter-spacing: .14em;

    text-transform: uppercase;
}

.bank-title {
    margin: 0;

    color: var(--bank-text);

    font-size: clamp(22px, 3vw, 30px);

    line-height: 1.2;

    font-weight: 800;
}

.bank-title span {
    color: var(--bank-green);
}

.bank-description {
    margin: 7px 0 0;

    max-width: 650px;

    color: var(--bank-muted);

    font-size: 11px;

    line-height: 1.65;
}


/* =========================================================
   SECURITY BADGE
========================================================= */

.security-badge {
    margin-left: auto;

    display: inline-flex;
    align-items: center;

    gap: 7px;

    padding: 9px 12px;

    border-radius: 999px;

    background: var(--bank-green-soft);

    border: 1px solid #cdeee1;

    color: var(--bank-green-dark);

    font-size: 9px;

    font-weight: 800;

    white-space: nowrap;
}

.security-badge i {
    font-size: 10px;
}


/* =========================================================
   ALERTS
========================================================= */

.bank-alert {
    position: relative;
    z-index: 2;

    display: flex;
    align-items: flex-start;

    gap: 10px;

    padding: 13px 15px;

    margin-bottom: 17px;

    border-radius: 13px;

    font-size: 10px;

    line-height: 1.55;
}

.bank-alert i {
    margin-top: 1px;

    flex: 0 0 auto;
}

.bank-alert-success {
    color: #087b55;

    background: var(--bank-green-soft);

    border: 1px solid #c9eddf;
}

.bank-alert-error {
    color: #b84b4b;

    background: var(--bank-red-soft);

    border: 1px solid #f3d2d2;
}

.bank-alert ul {
    margin: 0;

    padding-left: 17px;
}

.bank-alert li + li {
    margin-top: 4px;
}


/* =========================================================
   SECTION INTRO
========================================================= */

.form-intro {
    position: relative;
    z-index: 2;

    display: flex;
    align-items: center;

    gap: 11px;

    padding: 14px 16px;

    margin-bottom: 22px;

    border-radius: 14px;

    background: #f7faf9;

    border: 1px solid var(--bank-line);
}

.form-intro-icon {
    width: 34px;
    height: 34px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #ffffff;

    color: var(--bank-green);

    border: 1px solid #dce9e5;

    font-size: 12px;
}

.form-intro-title {
    color: var(--bank-text);

    font-size: 11px;

    font-weight: 800;
}

.form-intro-text {
    margin-top: 2px;

    color: var(--bank-muted);

    font-size: 9px;
}


/* =========================================================
   FORM GRID
========================================================= */

.bank-form {
    position: relative;
    z-index: 2;
}

.bank-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 18px;
}


/* =========================================================
   FIELD
========================================================= */

.bank-field {
    min-width: 0;
}

.bank-field.full {
    grid-column: 1 / -1;
}

.bank-label {
    display: flex;
    align-items: center;
    gap: 4px;

    margin-bottom: 7px;

    color: #52635e;

    font-size: 10px;

    font-weight: 800;
}

.required {
    color: var(--bank-green);

    font-size: 11px;
}

.bank-input {
    width: 100%;

    min-height: 47px;

    padding: 11px 13px;

    border-radius: 12px;

    border: 1px solid #dfe8e5;

    outline: none;

    background: #fbfdfc;

    color: var(--bank-text);

    font-family: inherit;

    font-size: 11px;

    transition: .22s ease;
}

.bank-input::placeholder {
    color: #aab6b2;
}

.bank-input:hover {
    border-color: #cbdad5;

    background: #ffffff;
}

.bank-input:focus {
    border-color: rgba(16,168,116,.65);

    background: #ffffff;

    box-shadow:
        0 0 0 3px rgba(16,168,116,.08),
        0 8px 20px rgba(16,168,116,.05);
}

.bank-input[type="file"] {
    padding: 7px;

    cursor: pointer;
}

.bank-input[type="file"]::file-selector-button {
    border: none;

    padding: 8px 11px;

    margin-right: 9px;

    border-radius: 8px;

    background: var(--bank-green-soft);

    color: var(--bank-green-dark);

    font-family: inherit;

    font-size: 9px;

    font-weight: 800;

    cursor: pointer;
}

.bank-help {
    display: block;

    margin-top: 6px;

    color: #9aa8a4;

    font-size: 8.5px;

    line-height: 1.5;
}


/* =========================================================
   INPUT ICON WRAPPER
========================================================= */

.input-wrap {
    position: relative;
}

.input-wrap .bank-input {
    padding-left: 40px;
}

.input-icon {
    position: absolute;

    left: 14px;
    top: 50%;

    transform: translateY(-50%);

    color: #8ba39b;

    font-size: 12px;

    pointer-events: none;

    z-index: 2;
}


/* =========================================================
   EXISTING ACCOUNT NOTICE
========================================================= */

.saved-notice {
    display: flex;

    align-items: flex-start;

    gap: 8px;

    margin-top: 7px;

    padding: 9px 10px;

    border-radius: 9px;

    background: #f3f8f6;

    border: 1px solid #e1ebe7;

    color: #73817d;

    font-size: 8.5px;

    line-height: 1.5;
}

.saved-notice i {
    color: var(--bank-green);

    margin-top: 1px;
}


/* =========================================================
   ACTIONS
========================================================= */

.bank-actions {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 12px;

    margin-top: 27px;

    padding-top: 21px;

    border-top: 1px solid var(--bank-line);
}

.bank-btn {
    min-height: 47px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    padding: 0 18px;

    border-radius: 12px;

    text-decoration: none;

    font-family: inherit;

    font-size: 10px;

    font-weight: 800;

    cursor: pointer;

    transition: .25s ease;
}

.bank-btn-back {
    color: #657570;

    background: #ffffff;

    border: 1px solid #dfe8e5;
}

.bank-btn-back:hover {
    color: var(--bank-green-dark);

    border-color: #bfe2d4;

    background: var(--bank-green-soft);

    transform: translateY(-2px);
}

.bank-btn-primary {
    border: none;

    color: #ffffff;

    background:
        linear-gradient(
            135deg,
            #13b47d,
            #078e61
        );

    box-shadow:
        0 9px 23px rgba(16,168,116,.18);
}

.bank-btn-primary:hover {
    transform: translateY(-2px);

    box-shadow:
        0 13px 29px rgba(16,168,116,.26);
}

.bank-btn-primary:active,
.bank-btn-back:active {
    transform: translateY(0);
}


/* =========================================================
   SECURITY FOOTER
========================================================= */

.bank-security {
    display: flex;

    align-items: center;
    justify-content: center;

    gap: 7px;

    margin-top: 18px;

    color: #9aa8a4;

    font-size: 8.5px;
}

.bank-security i {
    color: var(--bank-green);
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 720px) {

    .bank-page {
        padding:
            22px 14px 50px;
    }

    .bank-card {
        padding: 24px 18px;

        border-radius: 21px;
    }

    .bank-grid {
        grid-template-columns: 1fr;
    }

    .bank-field.full {
        grid-column: auto;
    }

    .security-badge {
        display: none;
    }
}


@media (max-width: 480px) {

    .bank-page {
        padding:
            16px 10px 40px;
    }

    .bank-card {
        padding: 20px 15px;
    }

    .bank-header {
        gap: 11px;
    }

    .bank-header-icon {
        width: 44px;
        height: 44px;

        flex-basis: 44px;

        border-radius: 13px;
    }

    .bank-title {
        font-size: 21px;
    }

    .bank-description {
        font-size: 10px;
    }

    .bank-actions {
        flex-direction: column-reverse;
    }

    .bank-btn {
        width: 100%;
    }
}
</style>


<div class="bank-page">

    <div class="bank-container">

        <div class="bank-card">


            {{-- =================================================
                 HEADER
            ================================================== --}}

            <div class="bank-header">

                <div class="bank-header-icon">

                    <i class="fa-solid fa-building-columns"></i>

                </div>

                <div>

                    <div class="bank-step">
                        Seller Verification · Step 5 of 6
                    </div>

                    <h1 class="bank-title">
                        Add your <span>bank details</span>
                    </h1>

                    <p class="bank-description">
                        Enter the bank account details that will be used
                        for your SmartBasket seller payments.
                    </p>

                </div>


                <div class="security-badge">

                    <i class="fa-solid fa-shield-halved"></i>

                    Secure & Protected

                </div>

            </div>


            {{-- =================================================
                 SUCCESS
            ================================================== --}}

            @if(session('success'))

                <div class="bank-alert bank-alert-success">

                    <i class="fa-solid fa-circle-check"></i>

                    <div>
                        {{ session('success') }}
                    </div>

                </div>

            @endif


            {{-- =================================================
                 ERROR
            ================================================== --}}

            @if(session('error'))

                <div class="bank-alert bank-alert-error">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    <div>
                        {{ session('error') }}
                    </div>

                </div>

            @endif


            {{-- =================================================
                 VALIDATION ERRORS
            ================================================== --}}

            @if($errors->any())

                <div class="bank-alert bank-alert-error">

                    <i class="fa-solid fa-triangle-exclamation"></i>

                    <div>

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


            {{-- =================================================
                 FORM INTRO
            ================================================== --}}

            <div class="form-intro">

                <div class="form-intro-icon">

                    <i class="fa-solid fa-wallet"></i>

                </div>

                <div>

                    <div class="form-intro-title">
                        Payment Account Information
                    </div>

                    <div class="form-intro-text">
                        Make sure the account holder name matches your
                        seller/business verification details.
                    </div>

                </div>

            </div>


            {{-- =================================================
                 FORM
            ================================================== --}}

            <form
                method="POST"
                action="{{ route('seller.verification.bank-details.update') }}"
                enctype="multipart/form-data"
                class="bank-form"
            >

                @csrf

                @method('PUT')


                <div class="bank-grid">


                    {{-- ACCOUNT HOLDER --}}

                    <div class="bank-field">

                        <label class="bank-label">

                            Account Holder Name

                            <span class="required">*</span>

                        </label>

                        <div class="input-wrap">

                            <i class="fa-solid fa-user input-icon"></i>

                            <input
                                type="text"
                                name="bank_account_holder"
                                class="bank-input"
                                value="{{ old('bank_account_holder', $seller->bank_account_holder) }}"
                                placeholder="Enter account holder name"
                                autocomplete="name"
                                required
                            >

                        </div>

                    </div>


                    {{-- BANK NAME --}}

                    <div class="bank-field">

                        <label class="bank-label">

                            Bank Name

                            <span class="required">*</span>

                        </label>

                        <div class="input-wrap">

                            <i class="fa-solid fa-building-columns input-icon"></i>

                            <input
                                type="text"
                                name="bank_name"
                                class="bank-input"
                                value="{{ old('bank_name', $seller->bank_name) }}"
                                placeholder="Enter bank name"
                                autocomplete="organization"
                                required
                            >

                        </div>

                    </div>


                    {{-- ACCOUNT NUMBER --}}

                    <div class="bank-field">

                        <label class="bank-label">

                            Account Number

                            <span class="required">*</span>

                        </label>

                        <div class="input-wrap">

                            <i class="fa-solid fa-credit-card input-icon"></i>

                            <input
                                type="password"
                                name="bank_account_number"
                                id="bankAccountNumber"
                                class="bank-input"
                                inputmode="numeric"
                                autocomplete="new-password"
                                placeholder="Enter bank account number"
                                required
                            >

                        </div>

                        @if($seller->bank_account_number)

                            <div class="saved-notice">

                                <i class="fa-solid fa-lock"></i>

                                <span>
                                    Existing account number is already saved
                                    securely. Enter it again only if you want
                                    to replace it.
                                </span>

                            </div>

                        @endif

                    </div>


                    {{-- CONFIRM ACCOUNT NUMBER --}}

                    <div class="bank-field">

                        <label class="bank-label">

                            Confirm Account Number

                            <span class="required">*</span>

                        </label>

                        <div class="input-wrap">

                            <i class="fa-solid fa-check-double input-icon"></i>

                            <input
                                type="password"
                                name="bank_account_number_confirmation"
                                id="bankAccountConfirmation"
                                class="bank-input"
                                inputmode="numeric"
                                autocomplete="new-password"
                                placeholder="Confirm account number"
                                required
                            >

                        </div>

                    </div>


                    {{-- IFSC --}}

                    <div class="bank-field">

                        <label class="bank-label">

                            IFSC Code

                            <span class="required">*</span>

                        </label>

                        <div class="input-wrap">

                            <i class="fa-solid fa-code input-icon"></i>

                            <input
                                type="text"
                                name="bank_ifsc"
                                id="bankIfsc"
                                class="bank-input"
                                value="{{ old('bank_ifsc', $seller->bank_ifsc) }}"
                                placeholder="e.g. SBIN0001234"
                                autocomplete="off"
                                maxlength="20"
                                style="text-transform:uppercase;"
                                required
                            >

                        </div>

                        <small class="bank-help">
                            Enter the IFSC exactly as shown on your bank
                            passbook, cheque or bank statement.
                        </small>

                    </div>


                    {{-- BANK PROOF --}}

                    <div class="bank-field">
                        <label class="bank-label">Branch <span class="required">*</span></label>
                        <div class="input-wrap">
                            <i class="fa-solid fa-location-dot input-icon"></i>
                            <input type="text" name="bank_branch" class="bank-input" value="{{ old('bank_branch', $seller->bank_branch) }}" placeholder="Enter bank branch" required>
                        </div>
                    </div>

                    <div class="bank-field">

                        <label class="bank-label">

                            Bank Proof

                            <span style="color:#9aa8a4;font-weight:600;">
                                (Optional)
                            </span>

                        </label>

                        <input
                            type="file"
                            name="bank_proof"
                            class="bank-input"
                            accept=".pdf,.jpg,.jpeg,.png,.webp"
                        >

                        <small class="bank-help">

                            PDF, JPG, JPEG, PNG or WEBP · Maximum 5 MB.

                        </small>

                    </div>


                </div>


                {{-- =================================================
                     ACTIONS
                ================================================== --}}

                <div class="bank-actions">

                    <a
                        href="{{ route('seller.verification.business-details') }}"
                        class="bank-btn bank-btn-back"
                    >

                        <i class="fa-solid fa-arrow-left"></i>

                        Back to Business Details

                    </a>


                    <button
                        type="submit"
                        class="bank-btn bank-btn-primary"
                    >

                        Save & Continue

                        <i class="fa-solid fa-arrow-right"></i>

                    </button>

                </div>

            </form>


            {{-- =================================================
                 SECURITY FOOTER
            ================================================== --}}

            <div class="bank-security">

                <i class="fa-solid fa-shield-halved"></i>

                Your payment information is securely handled by SmartBasket.

            </div>


        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('.bank-form');

    if (!form) {
        return;
    }


    const accountNumber =
        form.querySelector(
            '[name="bank_account_number"]'
        );


    const confirmation =
        form.querySelector(
            '[name="bank_account_number_confirmation"]'
        );


    const ifsc =
        form.querySelector(
            '[name="bank_ifsc"]'
        );


    /*
    |--------------------------------------------------------------------------
    | IFSC AUTO UPPERCASE
    |--------------------------------------------------------------------------
    */

    if (ifsc) {

        ifsc.addEventListener('input', function () {

            this.value =
                this.value.toUpperCase();

        });

    }


    /*
    |--------------------------------------------------------------------------
    | ACCOUNT NUMBER — NUMBERS ONLY
    |--------------------------------------------------------------------------
    */

    if (accountNumber) {

        accountNumber.addEventListener('input', function () {

            this.value =
                this.value.replace(/\D/g, '');

        });

    }


    if (confirmation) {

        confirmation.addEventListener('input', function () {

            this.value =
                this.value.replace(/\D/g, '');

        });

    }


    /*
    |--------------------------------------------------------------------------
    | ACCOUNT NUMBER MATCH
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', function (event) {

        if (
            accountNumber &&
            confirmation &&
            accountNumber.value !== confirmation.value
        ) {

            event.preventDefault();

            alert(
                'Bank account number and confirmation do not match.'
            );

            confirmation.focus();

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | BASIC ACCOUNT NUMBER VALIDATION
        |--------------------------------------------------------------------------
        */

        if (
            accountNumber &&
            (
                accountNumber.value.length < 6 ||
                accountNumber.value.length > 18
            )
        ) {

            event.preventDefault();

            alert(
                'Please enter a valid bank account number.'
            );

            accountNumber.focus();

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | BASIC IFSC VALIDATION
        |--------------------------------------------------------------------------
        */

        if (ifsc) {

            const ifscPattern =
                /^[A-Z]{4}0[A-Z0-9]{6}$/;

            if (!ifscPattern.test(ifsc.value)) {

                event.preventDefault();

                alert(
                    'Please enter a valid IFSC code.'
                );

                ifsc.focus();

                return;
            }

        }

    });

});

</script>

@endsection