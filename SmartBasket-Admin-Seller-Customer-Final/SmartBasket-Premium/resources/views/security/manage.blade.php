{{-- =========================================================
     SMART BASKET
     SECURITY PIN MANAGE PAGE
     resources/views/security/manage.blade.php
========================================================= --}}

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Manage Security PIN - Smart Basket</title>

    {{-- Font Awesome --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        body {
            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:
                radial-gradient(
                    circle at top left,
                    #312e81 0%,
                    #111827 42%,
                    #020617 100%
                );

            color: #ffffff;

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 30px 16px;
        }

        /* =====================================================
           MAIN WRAPPER
        ===================================================== */

        .security-wrapper {
            width: 100%;
            max-width: 520px;
        }

        /* =====================================================
           CARD
        ===================================================== */

        .security-card {

            width: 100%;

            background:
                rgba(15, 23, 42, 0.92);

            border:
                1px solid rgba(255, 255, 255, 0.10);

            border-radius: 28px;

            padding: 34px;

            box-shadow:
                0 30px 80px rgba(0, 0, 0, 0.45),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);

            backdrop-filter: blur(18px);

            -webkit-backdrop-filter: blur(18px);
        }

        /* =====================================================
           HEADER ICON
        ===================================================== */

        .security-icon {

            width: 76px;

            height: 76px;

            margin: 0 auto 20px;

            border-radius: 22px;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                linear-gradient(
                    135deg,
                    #7c3aed,
                    #4f46e5
                );

            box-shadow:
                0 15px 35px rgba(99, 102, 241, 0.30);
        }

        .security-icon i {
            font-size: 31px;
            color: #ffffff;
        }

        /* =====================================================
           TITLES
        ===================================================== */

        .security-title {

            margin: 0;

            text-align: center;

            font-size: 29px;

            font-weight: 800;

            letter-spacing: -0.5px;
        }

        .security-subtitle {

            margin: 10px auto 0;

            max-width: 410px;

            text-align: center;

            color: #94a3b8;

            font-size: 14px;

            line-height: 1.6;
        }

        .brand {
            color: #c4b5fd;
            font-weight: 800;
        }

        /* =====================================================
           STATUS
        ===================================================== */

        .status-box {

            display: flex;

            align-items: center;

            gap: 13px;

            margin-top: 25px;

            padding: 14px 16px;

            border-radius: 16px;

            background:
                rgba(34, 197, 94, 0.08);

            border:
                1px solid rgba(34, 197, 94, 0.20);
        }

        .status-icon {

            width: 40px;

            height: 40px;

            flex-shrink: 0;

            border-radius: 12px;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                rgba(34, 197, 94, 0.15);

            color: #4ade80;
        }

        .status-title {

            font-size: 14px;

            font-weight: 700;

            color: #dcfce7;
        }

        .status-text {

            margin-top: 2px;

            font-size: 12px;

            color: #86efac;
        }

        /* =====================================================
           ALERT
        ===================================================== */

        .alert {

            display: flex;

            align-items: flex-start;

            gap: 10px;

            margin-top: 20px;

            padding: 13px 15px;

            border-radius: 14px;

            font-size: 13px;

            line-height: 1.5;
        }

        .alert-error {

            color: #fecaca;

            background:
                rgba(239, 68, 68, 0.10);

            border:
                1px solid rgba(239, 68, 68, 0.22);
        }

        .alert-success {

            color: #bbf7d0;

            background:
                rgba(34, 197, 94, 0.10);

            border:
                1px solid rgba(34, 197, 94, 0.22);
        }

        .alert i {
            margin-top: 2px;
        }

        /* =====================================================
           FORM
        ===================================================== */

        .form-section {
            margin-top: 27px;
        }

        .form-title {

            display: flex;

            align-items: center;

            gap: 9px;

            margin-bottom: 17px;

            color: #e2e8f0;

            font-size: 16px;

            font-weight: 750;
        }

        .form-title i {
            color: #a78bfa;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {

            display: block;

            margin-bottom: 8px;

            color: #cbd5e1;

            font-size: 13px;

            font-weight: 650;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {

            width: 100%;

            height: 52px;

            padding:
                0 48px
                0 16px;

            border-radius: 15px;

            border:
                1px solid rgba(148, 163, 184, 0.20);

            outline: none;

            background:
                rgba(30, 41, 59, 0.85);

            color: #ffffff;

            font-size: 16px;

            letter-spacing: 4px;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }

        .form-input::placeholder {
            color: #64748b;
            letter-spacing: 1px;
        }

        .form-input:focus {

            border-color: #8b5cf6;

            background:
                rgba(30, 41, 59, 1);

            box-shadow:
                0 0 0 4px rgba(139, 92, 246, 0.12);
        }

        .input-icon {

            position: absolute;

            right: 16px;

            top: 50%;

            transform: translateY(-50%);

            width: 25px;

            height: 25px;

            border: none;

            padding: 0;

            background: transparent;

            color: #64748b;

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;

            transition: color 0.2s ease;
        }

        .input-icon:hover {
            color: #c4b5fd;
        }

        /* =====================================================
           PASSWORD ERROR
        ===================================================== */

        .field-error {

            margin-top: 7px;

            color: #fca5a5;

            font-size: 12px;
        }

        /* =====================================================
           BUTTON
        ===================================================== */

        .update-button {

            width: 100%;

            height: 54px;

            margin-top: 5px;

            border: none;

            border-radius: 16px;

            cursor: pointer;

            background:
                linear-gradient(
                    135deg,
                    #7c3aed,
                    #4f46e5
                );

            color: #ffffff;

            font-size: 15px;

            font-weight: 750;

            box-shadow:
                0 12px 30px rgba(99, 102, 241, 0.25);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                opacity 0.2s ease;
        }

        .update-button:hover {

            transform: translateY(-2px);

            box-shadow:
                0 16px 35px rgba(99, 102, 241, 0.35);
        }

        .update-button:active {
            transform: translateY(0);
        }

        .update-button i {
            margin-right: 8px;
        }

        /* =====================================================
           BACK BUTTON
        ===================================================== */

        .back-button {

            width: 100%;

            height: 50px;

            margin-top: 12px;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            border-radius: 15px;

            border:
                1px solid rgba(148, 163, 184, 0.18);

            background:
                rgba(30, 41, 59, 0.55);

            color: #cbd5e1;

            text-decoration: none;

            font-size: 14px;

            font-weight: 650;

            transition:
                background 0.2s ease,
                color 0.2s ease,
                border-color 0.2s ease;
        }

        .back-button:hover {

            background:
                rgba(51, 65, 85, 0.70);

            color: #ffffff;

            border-color:
                rgba(148, 163, 184, 0.30);
        }

        /* =====================================================
           SECURITY NOTE
        ===================================================== */

        .security-note {

            display: flex;

            align-items: flex-start;

            gap: 9px;

            margin-top: 22px;

            padding: 13px 14px;

            border-radius: 14px;

            background:
                rgba(59, 130, 246, 0.07);

            border:
                1px solid rgba(59, 130, 246, 0.15);

            color: #93c5fd;

            font-size: 11.5px;

            line-height: 1.55;
        }

        .security-note i {
            margin-top: 2px;
        }

        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {

            margin-top: 22px;

            text-align: center;

            color: #64748b;

            font-size: 11px;
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 600px) {

            body {
                padding: 18px 12px;
            }

            .security-card {
                padding: 25px 20px;
                border-radius: 23px;
            }

            .security-icon {
                width: 68px;
                height: 68px;
                border-radius: 19px;
            }

            .security-icon i {
                font-size: 27px;
            }

            .security-title {
                font-size: 25px;
            }

            .security-subtitle {
                font-size: 13px;
            }

        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {

                animation-duration: 0.01ms !important;

                animation-iteration-count: 1 !important;

                transition-duration: 0.01ms !important;
            }

        }

    </style>

</head>


<body>

<div class="security-wrapper">

    <div class="security-card">

        {{-- =================================================
             HEADER
        ================================================== --}}

        <div class="security-icon">

            <i class="fa-solid fa-shield-halved"></i>

        </div>


        <h1 class="security-title">
            Manage Security PIN
        </h1>


        <p class="security-subtitle">

            Your Security PIN is already enabled.
            Verify your current PIN and create a new PIN
            for your <span class="brand">Smart Basket</span> account.

        </p>


        {{-- =================================================
             CURRENT STATUS
        ================================================== --}}

        <div class="status-box">

            <div class="status-icon">

                <i class="fa-solid fa-shield-check"></i>

            </div>

            <div>

                <div class="status-title">
                    Security PIN Enabled
                </div>

                <div class="status-text">
                    Your account has an extra layer of protection.
                </div>

            </div>

        </div>


        {{-- =================================================
             ERROR
        ================================================== --}}

        @if(session('error'))

            <div class="alert alert-error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <span>
                    {{ session('error') }}
                </span>

            </div>

        @endif


        {{-- =================================================
             SUCCESS
        ================================================== --}}

        @if(session('success'))

            <div class="alert alert-success">

                <i class="fa-solid fa-circle-check"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif


        {{-- =================================================
             VALIDATION ERRORS
        ================================================== --}}

        @if($errors->any())

            <div class="alert alert-error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <div>

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            </div>

        @endif


        {{-- =================================================
             STEP 1
             VERIFY CURRENT PIN
        ================================================== --}}

        @if(!$verified)

            <div class="form-section">

                <div class="form-title">

                    <i class="fa-solid fa-lock"></i>

                    <span>
                        Verify Current Security PIN
                    </span>

                </div>


                <form
                    action="{{ route('security.manage.verify') }}"
                    method="POST"
                >

                    @csrf


                    {{-- CURRENT PIN --}}

                    <div class="form-group">

                        <label
                            for="current_pin"
                            class="form-label"
                        >
                            Enter Current Security PIN
                        </label>


                        <div class="input-wrapper">

                            <input
                                type="password"
                                name="pin"
                                id="current_pin"
                                class="form-input"
                                maxlength="6"
                                minlength="4"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                autocomplete="off"
                                placeholder="••••••"
                                required
                                autofocus
                            >


                            <button
                                type="button"
                                class="input-icon"
                                onclick="togglePin(
                                    'current_pin',
                                    this
                                )"
                                aria-label="Show PIN"
                            >

                                <i class="fa-solid fa-eye"></i>

                            </button>

                        </div>


                        @error('pin')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <button
                        type="submit"
                        class="update-button"
                    >

                        <i class="fa-solid fa-unlock-keyhole"></i>

                        Verify Current PIN

                    </button>

                </form>

            </div>


        @else

            {{-- =================================================
                 STEP 2
                 NEW PIN
            ================================================== --}}

            <div class="form-section">

                <div class="form-title">

                    <i class="fa-solid fa-key"></i>

                    <span>
                        Create New Security PIN
                    </span>

                </div>


                <form
                    action="{{ route('security.manage.update') }}"
                    method="POST"
                >

                    @csrf


                    {{-- NEW PIN --}}

                    <div class="form-group">

                        <label
                            for="new_pin"
                            class="form-label"
                        >
                            New Security PIN
                        </label>


                        <div class="input-wrapper">

                            <input
                                type="password"
                                name="pin"
                                id="new_pin"
                                class="form-input"
                                maxlength="6"
                                minlength="4"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                autocomplete="new-password"
                                placeholder="4–6 digit PIN"
                                required
                                autofocus
                            >


                            <button
                                type="button"
                                class="input-icon"
                                onclick="togglePin(
                                    'new_pin',
                                    this
                                )"
                                aria-label="Show PIN"
                            >

                                <i class="fa-solid fa-eye"></i>

                            </button>

                        </div>


                        @error('pin')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- CONFIRM PIN --}}

                    <div class="form-group">

                        <label
                            for="pin_confirmation"
                            class="form-label"
                        >
                            Confirm New Security PIN
                        </label>


                        <div class="input-wrapper">

                            <input
                                type="password"
                                name="pin_confirmation"
                                id="pin_confirmation"
                                class="form-input"
                                maxlength="6"
                                minlength="4"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                autocomplete="new-password"
                                placeholder="Confirm new PIN"
                                required
                            >


                            <button
                                type="button"
                                class="input-icon"
                                onclick="togglePin(
                                    'pin_confirmation',
                                    this
                                )"
                                aria-label="Show PIN"
                            >

                                <i class="fa-solid fa-eye"></i>

                            </button>

                        </div>


                        @error('pin_confirmation')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <button
                        type="submit"
                        class="update-button"
                    >

                        <i class="fa-solid fa-shield-halved"></i>

                        Update Security PIN

                    </button>

                </form>

            </div>

        @endif


        {{-- =================================================
             SECURITY NOTE
        ================================================== --}}

        <div class="security-note">

            <i class="fa-solid fa-circle-info"></i>

            <span>
                Your Security PIN is securely stored in encrypted
                hash form. Never share your PIN with anyone.
            </span>

        </div>


        {{-- =================================================
             BACK
        ================================================== --}}

        <a
            href="{{ route('settings') }}"
            class="back-button"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Back to Settings

        </a>


        {{-- =================================================
             FOOTER
        ================================================== --}}

        <div class="footer">

            <i class="fa-solid fa-lock"></i>

            &nbsp; Smart Basket Security Center

        </div>

    </div>

</div>


<script>

    function togglePin(inputId, button) {

        const input =
            document.getElementById(inputId);

        const icon =
            button.querySelector('i');

        if (!input) {
            return;
        }

        if (input.type === 'password') {

            input.type = 'text';

            icon.classList.remove(
                'fa-eye'
            );

            icon.classList.add(
                'fa-eye-slash'
            );

            button.setAttribute(
                'aria-label',
                'Hide PIN'
            );

        } else {

            input.type = 'password';

            icon.classList.remove(
                'fa-eye-slash'
            );

            icon.classList.add(
                'fa-eye'
            );

            button.setAttribute(
                'aria-label',
                'Show PIN'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | ALLOW ONLY NUMBERS IN PIN INPUTS
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            'input[name="pin"], input[name="pin_confirmation"]'
        )
        .forEach(function(input) {

            input.addEventListener(
                'input',
                function() {

                    this.value =
                        this.value
                            .replace(/\D/g, '')
                            .slice(0, 6);

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | CONFIRM NEW PIN
    |--------------------------------------------------------------------------
    */

    const newPin =
        document.getElementById('new_pin');

    const confirmPin =
        document.getElementById('pin_confirmation');


    if (newPin && confirmPin) {

        const form =
            confirmPin.closest('form');

        form.addEventListener(
            'submit',
            function(event) {

                if (
                    newPin.value !==
                    confirmPin.value
                ) {

                    event.preventDefault();

                    alert(
                        'New Security PIN and Confirm PIN do not match.'
                    );

                    confirmPin.focus();

                }

            }
        );

    }

</script>


</body>

</html>