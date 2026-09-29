<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Seller Verification · SmartBasket Premium</title>

    <link rel="stylesheet" href="{{ asset('css/smartbasket-premium.css') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --bg: #030623;
            --card-border: rgba(2, 1, 24, 0.09);
            --input: rgba(255,255,255,.045);
            --input-border: rgba(255,255,255,.10);
            --text: #f7f7fb;
            --muted: #9296aa;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            color: var(--text);

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(7, 1, 22, 0.18),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 90% 20%,
                    rgba(2, 2, 28, 0.15),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 50% 100%,
                    rgba(48, 11, 84, 0.1),
                    transparent 35%
                ),
                #0f133d;

            overflow-x: hidden;
        }

        .verification-page {
            min-height: 100vh;
            padding: 45px 20px;

            display: flex;
            justify-content: center;
            align-items: center;

            position: relative;
            overflow: hidden;
        }

        .glow {
            position: fixed;

            width: 320px;
            height: 320px;

            border-radius: 50%;
            filter: blur(100px);
            opacity: .18;

            pointer-events: none;
            z-index: 0;
        }

        .glow.one {
            background: #7c3aed;
            top: -120px;
            left: -100px;
        }

        .glow.two {
            background: #2563eb;
            right: -120px;
            bottom: -100px;
        }

        .glow.three {
            background: #c084fc;
            left: 45%;
            top: 45%;
            opacity: .08;
        }

        .verification-card {
            width: min(100%, 950px);

            position: relative;
            z-index: 2;

            padding: 42px;

            border-radius: 30px;

            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.065),
                    rgba(255,255,255,.025)
                );

            border: 1px solid var(--card-border);

            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);

            box-shadow:
                0 35px 100px rgba(69, 60, 239, 0.55),
                inset 0 1px 0 rgba(255,255,255,.05);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            color: white;
            text-decoration: none;

            font-size: 21px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .brand span {
            background:
                linear-gradient(
                    90deg,
                    #a78bfa,
                    #c084fc
                );

            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .brand:hover {
            color: white;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            margin-top: 18px;

            color: #8f93a8;
            text-decoration: none;

            font-size: 13px;
            font-weight: 600;

            transition: .2s ease;
        }

        .back-link:hover {
            color: #c4b5fd;
            transform: translateX(-2px);
        }

        .verification-header {
            margin-top: 30px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            margin: 0 0 13px;

            color: #a78bfa;

            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.8px;
        }

        .eyebrow::before {
            content: "";

            width: 22px;
            height: 2px;

            border-radius: 10px;

            background:
                linear-gradient(
                    90deg,
                    #8b5cf6,
                    #c084fc
                );
        }

        .verification-header h1 {
            margin: 0;

            font-size: clamp(30px, 4vw, 44px);
            line-height: 1.08;
            letter-spacing: -1.5px;

            background:
                linear-gradient(
                    135deg,
                    #ffffff 20%,
                    #c4b5fd 70%,
                    #a78bfa
                );

            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .verification-header > p:not(.eyebrow) {
            margin: 14px 0 0;

            color: var(--muted);

            font-size: 14px;
            line-height: 1.6;
        }

        /* =====================================================
           DYNAMIC SELLER ONBOARDING PROGRESS
           ===================================================== */

        .progress-wrapper {
            margin-top: 30px;
        }

        .progress-top {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 10px;
        }

        .progress-text {
            color: #d5d7e5;

            font-size: 12px;
            font-weight: 700;
        }

        .progress-percent {
            color: #a78bfa;

            font-size: 12px;
            font-weight: 800;
        }

        .progress {
            width: 100%;
            height: 7px;

            display: flex;
            gap: 5px;
        }

        .progress span {
            flex: 1;

            height: 100%;

            border-radius: 20px;

            background: rgba(255,255,255,.08);

            transition:
                background .3s ease,
                box-shadow .3s ease,
                transform .3s ease;
        }

        .progress span.active {
            background:
                linear-gradient(
                    90deg,
                    #7c3aed,
                    #a855f7,
                    #c084fc
                );

            box-shadow:
                0 0 12px rgba(12, 2, 37, 0.45);
        }

        .verification-content {
            margin-top: 35px;
        }

        .verification-content h2 {
            margin: 0 0 10px;

            color: #f8f8fc;

            font-size: 22px;
            font-weight: 800;
        }

        .verification-content p {
            color: #9296aa;

            font-size: 14px;
            line-height: 1.6;
        }

        .verification-content form {
            margin-top: 22px;

            padding: 24px;

            border-radius: 20px;

            background: rgba(255,255,255,.025);

            border: 1px solid rgba(255,255,255,.07);

            box-shadow:
                inset 0 1px 0 rgba(255,255,255,.025);
        }

        .verification-content label {
            display: block;

            margin-bottom: 8px;

            color: #d9dbea;

            font-size: 12px;
            font-weight: 700;
        }

        .verification-content input,
        .verification-content textarea,
        .verification-content select {
            width: 100%;

            border: 1px solid var(--input-border);
            border-radius: 14px;

            padding: 14px 15px;

            background: var(--input);
            color: #f8f8fc;

            font-family: inherit;
            font-size: 14px;

            outline: none;

            transition:
                border-color .2s ease,
                background .2s ease,
                box-shadow .2s ease;
        }

        .verification-content input::placeholder,
        .verification-content textarea::placeholder {
            color: #666a7e;
        }

        .verification-content input:hover,
        .verification-content textarea:hover,
        .verification-content select:hover {
            background: rgba(255,255,255,.06);
            border-color: rgba(255,255,255,.16);
        }

        .verification-content input:focus,
        .verification-content textarea:focus,
        .verification-content select:focus {
            border-color: #8b5cf6;

            background: rgba(60, 24, 144, 0.06);

            box-shadow:
                0 0 0 3px rgba(13, 4, 33, 0.12),
                0 0 25px rgba(139,92,246,.08);
        }

        .verification-content button {
            margin-top: 15px;

            border: 0;
            border-radius: 14px;

            padding: 13px 20px;

            color: white;

            font-family: inherit;
            font-size: 13px;
            font-weight: 800;

            cursor: pointer;

            background:
                linear-gradient(
                    100deg,
                    #034820,
                    #5730b3 45%,
                    #1d0348
                );

            box-shadow:
                0 10px 25px rgba(124,58,237,.25),
                inset 0 1px 0 rgba(255,255,255,.18);

            transition:
                transform .2s ease,
                box-shadow .2s ease,
                filter .2s ease;
        }

        .verification-content button:hover {
            transform: translateY(-2px);
            filter: brightness(1.08);

            box-shadow:
                0 16px 35px rgba(66, 19, 146, 0.35),
                inset 0 1px 0 rgba(255,255,255,.2);
        }

        .verification-content button:active {
            transform: translateY(0);
        }

        .verification-content .btn-success,
        .verification-content .btn-primary {
            background:
                linear-gradient(
                    100deg,
                    #260958,
                    #9870f5 45%,
                    #260958
                ) !important;

            border: 0 !important;
        }

        .verification-content hr {
            margin: 28px 0;

            border: 0;
            border-top: 1px solid rgba(255, 255, 255, 0.05);

            opacity: 1;
        }

        .alert {
            margin-top: 22px;

            padding: 14px 17px;

            border-radius: 14px;

            font-size: 13px;
        }

        .alert ul {
            margin: 0;
            padding-left: 18px;
        }

        .alert-danger,
        .alert-error {
            color: #24ed39;

            background: rgba(239,68,68,.08);

            border: 1px solid rgba(239,68,68,.20);
        }

        .alert-success {
            color: #13e460;

            background: rgba(34,197,94,.08);

            border: 1px solid rgba(34,197,94,.20);
        }

        .verification-footer {
            margin-top: 30px;

            padding-top: 22px;

            border-top: 1px solid rgba(255,255,255,.07);

            text-align: center;

            color: #777b90;

            font-size: 13px;
        }

        .verification-footer a {
            color: #b9a4ff;

            text-decoration: none;

            font-weight: 700;
        }

        .verification-footer a:hover {
            color: #d8ccff;
        }

        @media (max-width: 700px) {

            .verification-page {
                padding: 20px 12px;
                align-items: flex-start;
            }

            .verification-card {
                padding: 27px 20px;
                border-radius: 24px;
            }

            .verification-header {
                margin-top: 27px;
            }

            .verification-header h1 {
                font-size: 31px;
            }

            .verification-content form {
                padding: 18px;
            }

            .progress {
                gap: 3px;
                height: 6px;
            }
        }
    </style>
</head>

<body>

<div class="verification-page">

    <div class="glow one"></div>
    <div class="glow two"></div>
    <div class="glow three"></div>

    <main class="verification-card">

        {{-- =====================================================
             BRAND
        ====================================================== --}}

        <a href="{{ url('/') }}" class="brand">
            SmartBasket <span>Premium</span>
        </a>

        {{-- =====================================================
             BACK
        ====================================================== --}}

        <a href="{{ route('seller.login') }}" class="back-link">
            ← Back to Seller Login
        </a>

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <header class="verification-header">

            <p class="eyebrow">
                SELLER PARTNER PROGRAM
            </p>

            <h1>
                Seller Verification &amp; KYC
            </h1>

            <p>
                Complete your verification securely to activate
                your SmartBasket Premium seller account.
            </p>

            {{-- =================================================
                 DYNAMIC PROGRESS
                 Status ke according automatically step change hoga.
            ================================================== --}}

            @php

                $verificationStatus = $seller->verification_status ?? null;

                $currentStep = match ($verificationStatus) {

                    /*
                     * STEP 1
                     * Seller ne login/register kiya hai,
                     * email verification pending hai.
                     */
                    \App\Models\SellerProfile::STATUS_PENDING_EMAIL
                        => 1,

                    /*
                     * STEP 2
                     * Email verify ho chuka hai.
                     */
                    \App\Models\SellerProfile::STATUS_EMAIL_VERIFIED
                        => 2,

                    /*
                     * STEP 3
                     * Documents upload/pending stage.
                     */
                    \App\Models\SellerProfile::STATUS_DOCUMENTS_PENDING
                        => 3,

                    /*
                     * STEP 4
                     * Aadhaar verification stage.
                     */
                    \App\Models\SellerProfile::STATUS_AADHAAR_PENDING
                        => 4,

                    /*
                     * STEP 5
                     * Application admin review me hai.
                     */
                    \App\Models\SellerProfile::STATUS_PENDING_REVIEW
                        => 5,

                    /*
                     * STEP 6
                     * Admin ne seller approve kar diya.
                     */
                    \App\Models\SellerProfile::STATUS_APPROVED
                        => 6,

                    /*
                     * Seller active ho gaya = onboarding completed.
                     */
                    \App\Models\SellerProfile::STATUS_ACTIVE
                        => 6,

                    /*
                     * Unknown/null status ke liye safe fallback.
                     */
                    default
                        => 1,
                };

                $totalSteps = 6;

                $progressPercent = (int) round(
                    ($currentStep / $totalSteps) * 100
                );

            @endphp

            <div class="progress-wrapper">

                <div class="progress-top">

                    <span class="progress-text">
                        Seller onboarding
                    </span>

                    <span class="progress-percent">
                        Step {{ $currentStep }} of {{ $totalSteps }}
                        · {{ $progressPercent }}%
                    </span>

                </div>

                <div
                    class="progress"
                    role="progressbar"
                    aria-valuemin="1"
                    aria-valuemax="{{ $totalSteps }}"
                    aria-valuenow="{{ $currentStep }}"
                >

                    @for ($step = 1; $step <= $totalSteps; $step++)

                        <span
                            class="{{ $step <= $currentStep ? 'active' : '' }}"
                        ></span>

                    @endfor

                </div>

            </div>

        </header>

        {{-- =====================================================
             FLASH SUCCESS
        ====================================================== --}}

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif

        {{-- =====================================================
             FLASH ERROR
        ====================================================== --}}

        @if(session('error'))

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

        @endif

        {{-- =====================================================
             VALIDATION ERRORS
        ====================================================== --}}

        @if($errors->any())

            <div class="alert alert-danger">

                <ul>

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- =====================================================
             PAGE CONTENT
        ====================================================== --}}

        <section class="verification-content">

            {{ $slot }}

        </section>

        {{-- =====================================================
             FOOTER
        ====================================================== --}}

        <footer class="verification-footer">

            <a href="{{ route('seller.login') }}">
                Seller Login
            </a>

            &nbsp; · &nbsp;

            <a href="{{ route('login') }}">
                Customer Login
            </a>

            <br>

            <span>
                @ {{ date('Y') }} SmartBasket Premium
            </span>

        </footer>

    </main>

</div>

</body>
</html>