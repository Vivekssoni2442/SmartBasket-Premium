@extends('seller.partials.premium-layout')

@section('title', 'Activate Seller Account | SmartBasket Premium')

@php
    $step = 6;
@endphp

@section('content')

<style>
    /* =========================================================
       SMART BASKET — SELLER ACTIVATION
       PREMIUM LIGHT / DARK THEME
    ========================================================= */

    .activation-page {
        width: 100%;
        max-width: 760px;
        margin: 0 auto;
        padding: 20px 0 60px;
    }

    .activation-card {
        position: relative;
        overflow: hidden;
        padding: 42px;
        border-radius: 28px;

        background:
            linear-gradient(
                145deg,
                var(--sb-card-bg, rgba(255,255,255,.075)),
                var(--sb-card-bg-2, rgba(255,255,255,.025))
            );

        border: 1px solid var(--sb-border, rgba(255,255,255,.10));

        box-shadow:
            0 25px 70px rgba(0,0,0,.18);

        backdrop-filter: blur(22px);
    }

    .activation-card::before {
        content: "";
        position: absolute;

        width: 300px;
        height: 300px;

        top: -170px;
        right: -120px;

        border-radius: 50%;

        background: #00d98b;
        opacity: .055;

        filter: blur(40px);

        pointer-events: none;
    }

    .activation-top {
        position: relative;
        z-index: 2;

        text-align: center;
    }

    .activation-icon {
        width: 78px;
        height: 78px;

        margin: 0 auto 20px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 24px;

        color: #00d98b;

        background:
            rgba(0,217,139,.10);

        border:
            1px solid rgba(0,217,139,.22);

        box-shadow:
            0 0 35px rgba(0,217,139,.08);

        font-size: 30px;
    }

    .activation-step {
        display: inline-flex;
        align-items: center;

        padding: 7px 13px;

        margin-bottom: 13px;

        border-radius: 999px;

        color: #00d98b;

        background:
            rgba(0,217,139,.08);

        border:
            1px solid rgba(0,217,139,.18);

        font-size: 10px;
        font-weight: 800;

        letter-spacing: .12em;
    }

    .activation-title {
        margin: 0;

        color: var(--sb-text, #f8fafc);

        font-size: clamp(25px, 4vw, 34px);

        font-weight: 800;

        letter-spacing: -.5px;
    }

    .activation-title span {
        color: #00d98b;
    }

    .activation-description {
        max-width: 560px;

        margin: 12px auto 0;

        color: var(--sb-muted, #8fa6a0);

        font-size: 12px;

        line-height: 1.8;
    }

    .activation-info {
        position: relative;
        z-index: 2;

        display: grid;
        grid-template-columns: repeat(3, 1fr);

        gap: 10px;

        margin: 30px 0;
    }

    .activation-info-item {
        padding: 15px 12px;

        text-align: center;

        border-radius: 14px;

        background:
            rgba(255,255,255,.035);

        border:
            1px solid var(--sb-border, rgba(255,255,255,.08));
    }

    .activation-info-item i {
        display: block;

        margin-bottom: 7px;

        color: #00d98b;

        font-size: 14px;
    }

    .activation-info-item strong {
        display: block;

        color: var(--sb-text, #f8fafc);

        font-size: 11px;
    }

    .activation-info-item small {
        display: block;

        margin-top: 3px;

        color: var(--sb-muted, #8fa6a0);

        font-size: 9px;
    }

    .activation-form {
        position: relative;
        z-index: 2;

        padding-top: 25px;

        border-top:
            1px solid var(--sb-border, rgba(255,255,255,.08));
    }

    .activation-label {
        display: block;

        margin-bottom: 9px;

        color: var(--sb-text, #e8f0ee);

        font-size: 11px;
        font-weight: 700;

        letter-spacing: .02em;
    }

    .activation-input-wrapper {
        position: relative;
    }

    .activation-input-icon {
        position: absolute;

        left: 17px;
        top: 50%;

        transform: translateY(-50%);

        color: #00d98b;

        font-size: 14px;

        pointer-events: none;
    }

    .activation-input {
        width: 100%;

        min-height: 56px;

        padding: 14px 17px 14px 46px;

        border-radius: 15px;

        border:
            1px solid var(--sb-border, rgba(255,255,255,.10));

        background:
            var(--sb-input-bg, rgba(255,255,255,.045));

        color:
            var(--sb-text, #fff);

        outline: none;

        font-size: 16px;
        font-weight: 700;

        letter-spacing: .20em;

        transition: .25s ease;
    }

    .activation-input::placeholder {
        color: var(--sb-muted, rgba(255,255,255,.25));

        font-size: 12px;
        letter-spacing: .05em;
    }

    .activation-input:hover {
        border-color:
            rgba(0,217,139,.30);
    }

    .activation-input:focus {
        border-color:
            rgba(0,217,139,.65);

        background:
            rgba(0,217,139,.045);

        box-shadow:
            0 0 0 3px rgba(0,217,139,.07),
            0 0 25px rgba(0,217,139,.05);
    }

    .activation-help {
        margin-top: 8px;

        color: var(--sb-muted, #8fa6a0);

        font-size: 9px;

        line-height: 1.6;
    }

    .activation-actions {
        display: flex;

        gap: 12px;

        margin-top: 23px;
    }

    .activation-button {
        flex: 1;

        min-height: 52px;

        border: none;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #00e89a,
                #00bd78
            );

        color: #02130d;

        font-size: 12px;
        font-weight: 800;

        cursor: pointer;

        transition: .25s ease;

        box-shadow:
            0 12px 28px rgba(0,217,139,.12);
    }

    .activation-button:hover {
        transform: translateY(-2px);

        box-shadow:
            0 16px 35px rgba(0,217,139,.22);
    }

    .resend-form {
        margin-top: 16px;

        text-align: center;
    }

    .resend-button {
        border: none;

        background: transparent;

        color: var(--sb-muted, #8fa6a0);

        font-size: 11px;
        font-weight: 700;

        cursor: pointer;

        transition: .2s ease;
    }

    .resend-button:hover {
        color: #00d98b;
    }

    .security-note {
        position: relative;
        z-index: 2;

        display: flex;
        align-items: flex-start;

        gap: 11px;

        margin-top: 25px;
        padding: 14px 16px;

        border-radius: 13px;

        background:
            rgba(59,130,246,.055);

        border:
            1px solid rgba(59,130,246,.12);
    }

    .security-note i {
        margin-top: 2px;

        color: #60a5fa;

        font-size: 13px;
    }

    .security-note p {
        margin: 0;

        color: var(--sb-muted, #8fa6a0);

        font-size: 10px;

        line-height: 1.65;
    }

    /* =========================================================
       LIGHT MODE
    ========================================================= */

    html.light .activation-card,
    body.light .activation-card {
        --sb-card-bg: #ffffff;
        --sb-card-bg-2: #f8fafc;
        --sb-border: rgba(15,23,42,.09);
        --sb-text: #111827;
        --sb-muted: #64748b;
        --sb-input-bg: #f8fafc;

        box-shadow:
            0 20px 60px rgba(15,23,42,.08);
    }

    html.light .activation-info-item,
    body.light .activation-info-item {
        background: #f8fafc;
    }

    html.light .activation-input,
    body.light .activation-input {
        background: #f8fafc;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media(max-width:650px) {

        .activation-page {
            padding:
                10px 0 45px;
        }

        .activation-card {
            padding:
                30px 20px;

            border-radius: 22px;
        }

        .activation-icon {
            width: 65px;
            height: 65px;

            border-radius: 20px;

            font-size: 24px;
        }

        .activation-info {
            grid-template-columns: 1fr;
        }

        .activation-actions {
            flex-direction: column;
        }

        .activation-button {
            width: 100%;
        }

    }

    @media(max-width:420px) {

        .activation-card {
            padding:
                25px 16px;
        }

        .activation-title {
            font-size: 24px;
        }

        .activation-description {
            font-size: 11px;
        }

        .activation-input {
            min-height: 52px;

            font-size: 14px;
        }

    }
</style>


<div class="activation-page">

    <div class="activation-card">

        {{-- =================================================
             HEADER
        ================================================== --}}

        <div class="activation-top">

            <div class="activation-icon">
                <i class="fa-solid fa-shield-halved"></i>
            </div>

            <div class="activation-step">
                SELLER ACTIVATION
            </div>

            <h1 class="activation-title">
                Activate your <span>Seller Account</span>
            </h1>

            <p class="activation-description">
                Your seller application has been approved.
                Enter the 16-digit activation code sent to your
                registered email address to activate your SmartBasket
                seller account.
            </p>

        </div>


        {{-- =================================================
             INFO
        ================================================== --}}

        <div class="activation-info">

            <div class="activation-info-item">

                <i class="fa-solid fa-key"></i>

                <strong>16-Digit Code</strong>

                <small>
                    Secure activation code
                </small>

            </div>


            <div class="activation-info-item">

                <i class="fa-regular fa-clock"></i>

                <strong>30 Minutes</strong>

                <small>
                    Code validity
                </small>

            </div>


            <div class="activation-info-item">

                <i class="fa-solid fa-lock"></i>

                <strong>Secure</strong>

                <small>
                    One-time activation
                </small>

            </div>

        </div>


        {{-- =================================================
             ALERTS
        ================================================== --}}

        @if(session('success'))

            <div class="sb-alert sb-alert-success">
                {{ session('success') }}
            </div>

        @endif


        @if(session('error'))

            <div class="sb-alert sb-alert-error">
                {{ session('error') }}
            </div>

        @endif


        @if($errors->any())

            <div class="sb-alert sb-alert-error">

                <ul style="margin:0;padding-left:20px;">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =================================================
             ACTIVATION FORM
        ================================================== --}}

        <div class="activation-form">

            <form
                method="POST"
                action="{{ route('seller.activation.verify') }}"
                id="activationForm"
            >

                @csrf


                <label
                    for="activationCode"
                    class="activation-label"
                >
                    Activation Code
                </label>


                <div class="activation-input-wrapper">

                    <i
                        class="fa-solid fa-key activation-input-icon"
                    ></i>


                    <input
                        type="text"
                        id="activationCode"
                        name="code"
                        class="activation-input"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        maxlength="16"
                        minlength="16"
                        pattern="[0-9]{16}"
                        placeholder="Enter 16-digit activation code"
                        value="{{ old('code') }}"
                        required
                    >

                </div>


                <div class="activation-help">
                    Enter all 16 digits exactly as received.
                    The activation code expires after 30 minutes.
                </div>


                <div class="activation-actions">

                    <button
                        type="submit"
                        class="activation-button"
                    >

                        <i class="fa-solid fa-circle-check"></i>

                        &nbsp;

                        Activate Seller Account

                    </button>

                </div>

            </form>


            {{-- =================================================
                 RESEND
            ================================================== --}}

            <form
                method="POST"
                action="{{ route('seller.activation.resend') }}"
                class="resend-form"
            >

                @csrf

                <button
                    type="submit"
                    class="resend-button"
                >

                    <i class="fa-solid fa-rotate"></i>

                    &nbsp;

                    Resend activation code

                </button>

            </form>


            {{-- =================================================
                 SECURITY NOTE
            ================================================== --}}

            <div class="security-note">

                <i class="fa-solid fa-shield-check"></i>

                <p>
                    <strong>Security notice:</strong>
                    Never share your activation code with anyone.
                    SmartBasket will never ask you to disclose this
                    code over phone, WhatsApp or social media.
                </p>

            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const input =
        document.getElementById('activationCode');

    const form =
        document.getElementById('activationForm');


    if (!input || !form) {
        return;
    }


    /* Only allow numbers */

    input.addEventListener('input', function () {

        this.value =
            this.value
                .replace(/\D/g, '')
                .slice(0, 16);

    });


    /* Submit validation */

    form.addEventListener('submit', function (event) {

        const code =
            input.value.trim();


        if (!/^\d{16}$/.test(code)) {

            event.preventDefault();

            alert(
                'Please enter a valid 16-digit activation code.'
            );

            input.focus();

        }

    });

});
</script>

@endsection