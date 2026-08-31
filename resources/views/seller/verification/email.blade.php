<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Seller Email Verification | SmartBasket Premium</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>
        /* =========================================================
           SMART BASKET PREMIUM
           SELLER EMAIL VERIFICATION — LIGHT THEME
        ========================================================= */

        * {
            box-sizing: border-box;
        }

        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-soft: #eff6ff;

            --text: #111827;
            --text-soft: #475569;
            --muted: #64748b;

            --border: #e2e8f0;
            --border-light: #edf2f7;

            --card: #ffffff;
            --page: #f6f8fc;

            --success-bg: #ecfdf3;
            --success-border: #bbf7d0;
            --success-text: #15803d;

            --error-bg: #fef2f2;
            --error-border: #fecaca;
            --error-text: #dc2626;

            --info-bg: #eff6ff;
            --info-border: #bfdbfe;
            --info-text: #1d4ed8;

            --shadow:
                0 20px 60px rgba(15, 23, 42, 0.08),
                0 4px 16px rgba(15, 23, 42, 0.04);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
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
                    circle at 10% 5%,
                    rgba(37, 99, 235, 0.08),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 90% 90%,
                    rgba(59, 130, 246, 0.06),
                    transparent 30%
                ),
                var(--page);

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 45px 20px;
        }

        /* =========================================================
           MAIN CONTAINER
        ========================================================= */

        .container {
            width: 100%;
            max-width: 650px;
        }

        /* =========================================================
           PREMIUM CARD
        ========================================================= */

        .card {
            position: relative;

            width: 100%;

            background: rgba(255, 255, 255, 0.96);

            border: 1px solid rgba(226, 232, 240, 0.95);

            border-radius: 26px;

            padding: 38px;

            box-shadow: var(--shadow);

            overflow: hidden;
        }

        .card::before {
            content: "";

            position: absolute;

            top: 0;
            left: 0;
            right: 0;

            height: 4px;

            background:
                linear-gradient(
                    90deg,
                    #2563eb,
                    #3b82f6,
                    #60a5fa
                );
        }

        /* =========================================================
           BRAND
        ========================================================= */

        .brand {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-icon {
            width: 58px;
            height: 58px;

            margin: 0 auto 15px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 17px;

            background: var(--primary-soft);

            color: var(--primary);

            font-size: 23px;

            border: 1px solid #dbeafe;

            box-shadow:
                0 8px 20px rgba(37, 99, 235, 0.08);
        }

        .brand h1 {
            margin: 0;

            font-size: 25px;

            font-weight: 800;

            letter-spacing: -0.5px;

            color: var(--text);
        }

        .brand p {
            margin: 7px 0 0;

            font-size: 14px;

            color: var(--muted);

            font-weight: 500;
        }

        /* =========================================================
           STEPS
        ========================================================= */

        .steps {
            position: relative;

            display: flex;

            justify-content: space-between;

            gap: 7px;

            margin-bottom: 38px;

            padding: 0 4px;
        }

        .steps::before {
            content: "";

            position: absolute;

            top: 20px;
            left: 8%;
            right: 8%;

            height: 2px;

            background: #e5e7eb;

            z-index: 0;
        }

        .step {
            position: relative;

            z-index: 1;

            flex: 1;

            text-align: center;
        }

        .circle {
            width: 41px;
            height: 41px;

            margin: auto;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #ffffff;

            border: 2px solid #dbe3ee;

            color: #94a3b8;

            font-size: 13px;

            font-weight: 700;

            transition: 0.25s ease;
        }

        .step.active .circle {
            background: var(--primary);

            border-color: var(--primary);

            color: #ffffff;

            box-shadow:
                0 7px 18px rgba(37, 99, 235, 0.24);
        }

        .step-title {
            margin-top: 8px;

            font-size: 9px;

            font-weight: 700;

            letter-spacing: 0.45px;

            color: #94a3b8;
        }

        .step.active .step-title {
            color: var(--primary);
        }

        /* =========================================================
           CONTENT
        ========================================================= */

        h2 {
            margin: 0 0 9px;

            font-size: 24px;

            line-height: 1.3;

            font-weight: 800;

            letter-spacing: -0.5px;

            color: var(--text);
        }

        .description {
            color: var(--text-soft);

            line-height: 1.65;

            font-size: 14px;

            margin-bottom: 24px;
        }

        /* =========================================================
           EMAIL BOX
        ========================================================= */

        .email-box {
            background:
                linear-gradient(
                    135deg,
                    #f8fbff,
                    #f4f7fb
                );

            border: 1px solid #e1e9f3;

            padding: 17px 18px;

            border-radius: 15px;

            margin-bottom: 20px;
        }

        .email-row {
            display: flex;

            align-items: center;

            gap: 13px;
        }

        .email-icon {
            flex-shrink: 0;

            width: 40px;
            height: 40px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background: #eaf2ff;

            color: var(--primary);

            font-size: 16px;
        }

        .email-content {
            min-width: 0;
        }

        .email-label {
            color: #64748b;

            font-size: 10px;

            font-weight: 700;

            letter-spacing: 0.8px;

            margin-bottom: 4px;
        }

        .email {
            color: #172033;

            font-size: 14px;

            font-weight: 700;

            word-break: break-all;
        }

        /* =========================================================
           ALERTS
        ========================================================= */

        .alert {
            padding: 13px 15px;

            border-radius: 12px;

            margin-bottom: 18px;

            line-height: 1.5;

            font-size: 13px;
        }

        .success {
            background: var(--success-bg);

            border: 1px solid var(--success-border);

            color: var(--success-text);
        }

        .error {
            background: var(--error-bg);

            border: 1px solid var(--error-border);

            color: var(--error-text);
        }

        .info {
            background: var(--info-bg);

            border: 1px solid var(--info-border);

            color: var(--info-text);
        }

        /* =========================================================
           FORM
        ========================================================= */

        label {
            display: block;

            margin-bottom: 8px;

            font-size: 13px;

            font-weight: 700;

            color: #334155;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;

            left: 15px;

            top: 50%;

            transform: translateY(-50%);

            color: #94a3b8;

            font-size: 14px;

            pointer-events: none;
        }

        input {
            width: 100%;

            padding: 15px 16px 15px 43px;

            border-radius: 13px;

            border: 1px solid #d8e1ec;

            background: #ffffff;

            color: #111827;

            outline: none;

            font-size: 17px;

            letter-spacing: 4px;

            text-align: center;

            font-weight: 600;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }

        input::placeholder {
            color: #cbd5e1;

            letter-spacing: 4px;
        }

        input:hover {
            border-color: #bfccdc;
        }

        input:focus {
            border-color: var(--primary);

            background: #ffffff;

            box-shadow:
                0 0 0 4px rgba(37, 99, 235, 0.10);
        }

        /* =========================================================
           BUTTONS
        ========================================================= */

        button {
            width: 100%;

            min-height: 49px;

            padding: 14px 18px;

            border: 0;

            border-radius: 13px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            color: #ffffff;

            font-size: 13px;

            font-weight: 800;

            letter-spacing: 0.25px;

            cursor: pointer;

            margin-top: 15px;

            box-shadow:
                0 8px 18px rgba(37, 99, 235, 0.18);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                opacity 0.2s ease;
        }

        button:hover {
            transform: translateY(-1px);

            box-shadow:
                0 11px 24px rgba(37, 99, 235, 0.23);
        }

        button:active {
            transform: translateY(0);
        }

        button i {
            margin-right: 7px;
        }

        .secondary {
            background: #ffffff;

            color: #334155;

            border: 1px solid #dbe3ee;

            box-shadow: none;
        }

        .secondary:hover {
            background: #f8fafc;

            box-shadow:
                0 6px 15px rgba(15, 23, 42, 0.06);
        }

        /* =========================================================
           DIVIDER
        ========================================================= */

        .divider {
            position: relative;

            height: 1px;

            background: #edf1f6;

            margin: 30px 0;
        }

        .divider span {
            position: absolute;

            left: 50%;

            top: 50%;

            transform: translate(-50%, -50%);

            padding: 0 12px;

            background: #ffffff;

            color: #94a3b8;

            font-size: 10px;

            font-weight: 700;

            letter-spacing: 0.8px;
        }

        /* =========================================================
           HINT
        ========================================================= */

        .hint {
            display: flex;

            align-items: flex-start;

            gap: 8px;

            color: #7c8a9d;

            font-size: 11px;

            margin-top: 16px;

            line-height: 1.6;

            text-align: left;
        }

        .hint i {
            margin-top: 2px;

            color: #94a3b8;

            flex-shrink: 0;
        }

        /* =========================================================
           SECURITY NOTE
        ========================================================= */

        .security-note {
            margin-top: 22px;

            padding: 12px 14px;

            border-radius: 12px;

            background: #f8fafc;

            border: 1px solid #edf2f7;

            display: flex;

            gap: 9px;

            align-items: flex-start;

            color: #64748b;

            font-size: 11px;

            line-height: 1.55;
        }

        .security-note i {
            color: #64748b;

            margin-top: 2px;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 650px) {

            body {
                padding: 25px 14px;
                align-items: flex-start;
            }

            .container {
                margin-top: 15px;
            }

            .card {
                padding: 28px 22px;
                border-radius: 22px;
            }

            .brand h1 {
                font-size: 22px;
            }

            .brand p {
                font-size: 13px;
            }

            .steps {
                gap: 2px;
            }

            .steps::before {
                left: 9%;
                right: 9%;
            }

            .circle {
                width: 35px;
                height: 35px;
                font-size: 11px;
            }

            .step-title {
                font-size: 7px;
                letter-spacing: 0.2px;
            }

            h2 {
                font-size: 21px;
            }

            input {
                font-size: 16px;
                letter-spacing: 3px;
            }
        }

        @media (max-width: 400px) {

            .card {
                padding: 24px 17px;
            }

            .brand-icon {
                width: 52px;
                height: 52px;
            }

            .brand h1 {
                font-size: 20px;
            }

            .step-title {
                font-size: 6px;
            }

            .circle {
                width: 32px;
                height: 32px;
            }

            .email-box {
                padding: 14px;
            }
        }
    </style>
</head>

<body>

    @include('seller.partials.seller-menu')

    <div class="container">

        <div class="card">

            <!-- =================================================
                 BRAND
            ================================================== -->

            <div class="brand">

                <div class="brand-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>

                <h1>
                    SMART BASKET PREMIUM
                </h1>

                <p>
                    Seller Partner Program
                </p>

            </div>


            <!-- =================================================
                 STEPS
            ================================================== -->

            <div class="steps">

                <div class="step active">

                    <div class="circle">
                        1
                    </div>

                    <div class="step-title">
                        EMAIL
                    </div>

                </div>


                <div class="step">

                    <div class="circle">
                        2
                    </div>

                    <div class="step-title">
                        DOCUMENTS
                    </div>

                </div>


                <div class="step">

                    <div class="circle">
                        3
                    </div>

                    <div class="step-title">
                        AADHAAR
                    </div>

                </div>


                <div class="step">

                    <div class="circle">
                        4
                    </div>

                    <div class="step-title">
                        BUSINESS
                    </div>

                </div>


                <div class="step">

                    <div class="circle">
                        5
                    </div>

                    <div class="step-title">
                        BANK
                    </div>

                </div>


                <div class="step">

                    <div class="circle">
                        6
                    </div>

                    <div class="step-title">
                        REVIEW
                    </div>

                </div>

            </div>


            <!-- =================================================
                 MESSAGES
            ================================================== -->

            @if(session('success'))

                <div class="alert success">
                    <i class="fa-solid fa-circle-check"></i>
                    &nbsp;
                    {{ session('success') }}
                </div>

            @endif


            @if(session('error'))

                <div class="alert error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    &nbsp;
                    {{ session('error') }}
                </div>

            @endif


            @if(session('info'))

                <div class="alert info">
                    <i class="fa-solid fa-circle-info"></i>
                    &nbsp;
                    {{ session('info') }}
                </div>

            @endif


            <!-- =================================================
                 TITLE
            ================================================== -->

            <h2>
                Verify Your Email
            </h2>

            <div class="description">

                Before continuing with your Seller Partner
                application, please verify your registered
                email address.

            </div>


            <!-- =================================================
                 SELLER EMAIL
            ================================================== -->

            <div class="email-box">

                <div class="email-row">

                    <div class="email-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>

                    <div class="email-content">

                        <div class="email-label">
                            REGISTERED EMAIL
                        </div>

                        <div class="email">
                            {{ $seller->email }}
                        </div>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 SEND VERIFICATION CODE
            ================================================== -->

            <form
                method="POST"
                action="{{ route('seller.verification.email.send') }}"
            >

                @csrf

                <button type="submit">

                    <i class="fa-solid fa-paper-plane"></i>

                    SEND VERIFICATION CODE

                </button>

            </form>


            <!-- =================================================
                 DIVIDER
            ================================================== -->

            <div class="divider">

                <span>
                    VERIFICATION
                </span>

            </div>


            <!-- =================================================
                 VERIFY CODE
            ================================================== -->

            <form
                method="POST"
                action="{{ route('seller.verification.email.verify') }}"
            >

                @csrf

                <label for="code">
                    Enter 16-digit verification code
                </label>

                <div class="input-wrapper">

                    <i class="fa-solid fa-key input-icon"></i>

                    <input
                        type="text"
                        id="code"
                        name="code"
                        maxlength="16"
                        minlength="16"
                        pattern="[0-9]{16}"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        placeholder="••••••••••••••••"
                        value="{{ old('code') }}"
                        required
                    >

                </div>


                @error('code')

                    <div
                        class="alert error"
                        style="margin-top:12px; margin-bottom:0;"
                    >
                        <i class="fa-solid fa-circle-exclamation"></i>
                        &nbsp;
                        {{ $message }}
                    </div>

                @enderror


                <button type="submit">

                    <i class="fa-solid fa-circle-check"></i>

                    VERIFY EMAIL & CONTINUE

                </button>

            </form>


            <!-- =================================================
                 HINT
            ================================================== -->

            <div class="hint">

                <i class="fa-solid fa-clock"></i>

                <span>
                    A 16-digit verification code will be sent to your
                    registered email address. The code is valid for
                    10 minutes.
                </span>

            </div>


            <!-- =================================================
                 SECURITY NOTE
            ================================================== -->

            <div class="security-note">

                <i class="fa-solid fa-lock"></i>

                <span>
                    Your verification information is securely processed
                    by SmartBasket Premium and is used only for seller
                    partner verification.
                </span>

            </div>

        </div>

    </div>

</body>
</html>