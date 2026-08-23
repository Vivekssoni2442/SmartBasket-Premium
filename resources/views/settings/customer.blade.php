<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart Basket — Customer Settings</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">

    @php
        $currentTheme = $user->dark_mode ?? session('customer_theme', 'system');

        if (!in_array($currentTheme, ['light', 'dark', 'system'], true)) {
            $currentTheme = 'system';
        }

        $notifications = $user->notifications ?? 'enabled';
        $language = $user->language ?? 'english';
    @endphp

    <script>
        (() => {
            const saved = @json($currentTheme);

            const systemDark = window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches;

            const theme = saved === 'system'
                ? (systemDark ? 'dark' : 'light')
                : saved;

            document.documentElement.dataset.sbTheme = theme;
        })();
    </script>

    <style>

        /* =========================================================
           SMART BASKET CUSTOMER SETTINGS
        ========================================================= */

        :root {
            --settings-radius: 24px;
            --settings-transition: .28s ease;
        }

        /* =========================================================
           DARK THEME
        ========================================================= */

        html[data-sb-theme="dark"] {
            --sb-bg: #020617;
            --sb-bg-secondary: #07111f;
            --sb-card: rgba(15, 23, 42, .82);
            --sb-card-solid: #0f172a;
            --sb-surface: rgba(30, 41, 59, .65);
            --sb-input: #0b1220;
            --sb-border: rgba(148, 163, 184, .13);
            --sb-text: #f8fafc;
            --sb-text-secondary: #94a3b8;
            --sb-muted: #64748b;
            --sb-primary: #38bdf8;
            --sb-primary-2: #6366f1;
            --sb-primary-soft: rgba(56, 189, 248, .12);
            --sb-shadow: 0 25px 70px rgba(0, 0, 0, .38);
        }

        /* =========================================================
           LIGHT THEME
        ========================================================= */

        html[data-sb-theme="light"] {
            --sb-bg: #f4f7fb;
            --sb-bg-secondary: #eaf0f8;
            --sb-card: rgba(255, 255, 255, .92);
            --sb-card-solid: #ffffff;
            --sb-surface: #f8fafc;
            --sb-input: #ffffff;
            --sb-border: rgba(15, 23, 42, .10);
            --sb-text: #0f172a;
            --sb-text-secondary: #64748b;
            --sb-muted: #94a3b8;
            --sb-primary: #2563eb;
            --sb-primary-2: #7c3aed;
            --sb-primary-soft: rgba(37, 99, 235, .10);
            --sb-shadow: 0 20px 55px rgba(15, 23, 42, .10);
        }

        /* =========================================================
           BODY
        ========================================================= */

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            color: var(--sb-text);

            background:
                radial-gradient(
                    circle at 10% 10%,
                    var(--sb-primary-soft),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 90% 20%,
                    rgba(99, 102, 241, .08),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    var(--sb-bg),
                    var(--sb-bg-secondary)
                );

            transition:
                background var(--settings-transition),
                color var(--settings-transition);
        }

        /* =========================================================
           PAGE
        ========================================================= */

        .settings-page {
            min-height: 100vh;
            padding: 35px 20px 90px;
        }

        .settings-wrapper {
            width: min(1100px, 100%);
            margin: auto;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .settings-header {
            position: relative;
            overflow: hidden;

            padding: 30px;
            margin-bottom: 25px;

            border: 1px solid var(--sb-border);
            border-radius: 28px;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-card),
                    var(--sb-surface)
                );

            box-shadow: var(--sb-shadow);
            backdrop-filter: blur(22px);
        }

        .settings-header::after {
            content: "";

            position: absolute;
            width: 180px;
            height: 180px;

            right: -70px;
            top: -80px;

            border-radius: 50%;

            background: var(--sb-primary-soft);
            filter: blur(5px);
        }

        .brand-text {
            color: var(--sb-primary);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 3px;
        }

        .settings-title {
            position: relative;
            z-index: 2;

            margin: 8px 0 0;

            font-size: clamp(30px, 5vw, 46px);
            font-weight: 900;
            letter-spacing: -1.5px;

            color: var(--sb-text);
        }

        .settings-title span {
            color: var(--sb-primary);
        }

        .settings-subtitle {
            position: relative;
            z-index: 2;

            margin: 8px 0 0;

            color: var(--sb-text-secondary);
        }

        /* =========================================================
           BUTTONS
        ========================================================= */

        .premium-btn {
            border-radius: 999px !important;
            font-weight: 750;
            transition: .25s ease;
        }

        .premium-btn:hover {
            transform: translateY(-2px);
        }

        .back-btn {
            color: var(--sb-text) !important;
            border-color: var(--sb-border) !important;
            background: var(--sb-surface) !important;
        }

        /* =========================================================
           CARDS
        ========================================================= */

        .settings-card {
            position: relative;
            overflow: hidden;

            padding: 26px;
            margin-bottom: 20px;

            border: 1px solid var(--sb-border);
            border-radius: var(--settings-radius);

            background: var(--sb-card);

            box-shadow: var(--sb-shadow);

            backdrop-filter: blur(22px);

            transition:
                transform .25s ease,
                border-color .25s ease,
                background .25s ease;
        }

        .settings-card:hover {
            transform: translateY(-2px);
            border-color: var(--sb-primary-soft);
        }

        .settings-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 23px;
        }

        .settings-icon {
            width: 52px;
            height: 52px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 16px;

            color: var(--sb-primary);
            background: var(--sb-primary-soft);

            font-size: 20px;

            box-shadow:
                0 10px 30px var(--sb-primary-soft);
        }

        .settings-card-title {
            margin: 0;

            color: var(--sb-text);

            font-size: 20px;
            font-weight: 850;
        }

        .settings-card-description {
            margin: 4px 0 0;

            color: var(--sb-text-secondary);

            font-size: 12px;
        }

        /* =========================================================
           THEME SELECTOR
        ========================================================= */

        .theme-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .theme-option {
            position: relative;
        }

        .theme-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .theme-label {
            position: relative;
            overflow: hidden;

            min-height: 150px;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            gap: 9px;

            padding: 20px;

            border-radius: 20px;
            border: 1px solid var(--sb-border);

            background: var(--sb-surface);
            color: var(--sb-text);

            cursor: pointer;

            transition: .28s ease;
        }

        .theme-label::before {
            content: "";

            position: absolute;

            width: 100px;
            height: 100px;

            border-radius: 50%;

            background: var(--sb-primary-soft);

            filter: blur(18px);

            opacity: 0;

            transition: .28s ease;
        }

        .theme-label i,
        .theme-label span,
        .theme-label small {
            position: relative;
            z-index: 2;
        }

        .theme-label i {
            font-size: 29px;
            color: var(--sb-primary);
        }

        .theme-label span {
            font-size: 15px;
            font-weight: 800;
        }

        .theme-label small {
            color: var(--sb-text-secondary);
        }

        .theme-label:hover {
            transform: translateY(-4px);
            border-color: var(--sb-primary);
        }

        .theme-label:hover::before {
            opacity: 1;
        }

        .theme-option input:checked + .theme-label {
            border-color: var(--sb-primary);

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary-soft),
                    var(--sb-surface)
                );

            box-shadow:
                0 0 0 2px var(--sb-primary-soft),
                0 20px 45px var(--sb-primary-soft);

            transform: translateY(-4px);
        }

        /* =========================================================
           SETTING ROW
        ========================================================= */

        .setting-row {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            padding: 18px 0;

            border-bottom: 1px solid var(--sb-border);
        }

        .setting-row:last-child {
            border-bottom: 0;
        }

        .setting-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .setting-small-icon {
            width: 44px;
            height: 44px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 14px;

            color: var(--sb-primary);
            background: var(--sb-surface);

            border: 1px solid var(--sb-border);
        }

        .setting-name {
            color: var(--sb-text);
            font-weight: 750;
            margin-bottom: 3px;
        }

        .setting-description {
            color: var(--sb-text-secondary);
            font-size: 12px;
        }

        /* =========================================================
           SELECT
        ========================================================= */

        .premium-select {
            min-width: 210px;

            border-radius: 14px !important;

            padding: 11px 14px !important;

            background-color: var(--sb-input) !important;
            color: var(--sb-text) !important;

            border: 1px solid var(--sb-border) !important;
        }

        .premium-select:focus {
            border-color: var(--sb-primary) !important;

            box-shadow:
                0 0 0 4px var(--sb-primary-soft) !important;
        }

        .premium-select option {
            background: var(--sb-card-solid);
            color: var(--sb-text);
        }

        /* =========================================================
           SWITCH
        ========================================================= */

        .premium-switch .form-check-input {
            width: 54px;
            height: 29px;

            cursor: pointer;

            background-color: var(--sb-muted);

            border: 0;
        }

        .premium-switch .form-check-input:checked {
            background-color: var(--sb-primary);
        }

        /* =========================================================
           PREVIEW
        ========================================================= */

        .preview-box {
            padding: 18px;

            border-radius: 20px;

            background: var(--sb-surface);
            border: 1px solid var(--sb-border);
        }

        .preview-top {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 15px;

            color: var(--sb-text);
        }

        .preview-dot {
            width: 10px;
            height: 10px;

            border-radius: 50%;

            background: #22c55e;

            box-shadow: 0 0 15px rgba(34,197,94,.65);
        }

        .preview-content {
            padding: 18px;

            border-radius: 16px;

            background: var(--sb-card);
            border: 1px solid var(--sb-border);

            color: var(--sb-text);
        }

        /* =========================================================
           SAVE BAR
        ========================================================= */

        .save-area {
            position: sticky;
            bottom: 15px;

            z-index: 50;

            margin-top: 25px;
        }

        .save-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            padding: 16px 20px;

            border-radius: 22px;

            background: var(--sb-card);
            border: 1px solid var(--sb-border);

            box-shadow: var(--sb-shadow);

            backdrop-filter: blur(25px);
        }

        .save-bar strong {
            color: var(--sb-text);
        }

        .save-btn {
            min-width: 190px;
            height: 50px;

            border: 0 !important;
            border-radius: 999px !important;

            font-weight: 800;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary),
                    var(--sb-primary-2)
                ) !important;

            color: white !important;

            box-shadow:
                0 12px 30px var(--sb-primary-soft);
        }

        .save-btn:hover {
            transform: translateY(-3px);
            box-shadow:
                0 18px 40px var(--sb-primary-soft);
        }

        /* =========================================================
           ALERT
        ========================================================= */

        .success-alert {
            border-radius: 18px;

            color: var(--sb-text);

            border: 1px solid rgba(34,197,94,.25);

            background: rgba(34,197,94,.10);

            box-shadow: var(--sb-shadow);
        }

        /* =========================================================
           MOBILE
        ========================================================= */

        @media(max-width: 768px) {

            .settings-page {
                padding: 15px 10px 70px;
            }

            .settings-header {
                padding: 22px;
                border-radius: 22px;
            }

            .settings-card {
                padding: 19px;
                border-radius: 20px;
            }

            .theme-options {
                grid-template-columns: 1fr;
            }

            .theme-label {
                min-height: 95px;
                flex-direction: row;
                justify-content: flex-start;
            }

            .setting-row {
                align-items: flex-start;
                flex-direction: column;
            }

            .setting-info {
                width: 100%;
            }

            .premium-select {
                width: 100%;
            }

            .premium-switch {
                margin-left: 58px;
            }

            .save-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .save-btn {
                width: 100%;
            }
        }

    </style>
</head>


<body>

<div class="settings-page">

    <div class="settings-wrapper">

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="settings-header">

            <a
                href="{{ route('products.index') }}"
                class="btn btn-outline-primary premium-btn back-btn mb-4"
            >
                <i class="fa-solid fa-arrow-left me-2"></i>
                Back to Products
            </a>

            <div class="brand-text">
                SMART BASKET
            </div>

            <h1 class="settings-title">
                Customer <span>Settings</span>
            </h1>

            <p class="settings-subtitle">
                Personalize your shopping experience, appearance and preferences.
            </p>

        </div>


        {{-- =====================================================
             SUCCESS
        ====================================================== --}}

        @if(session('success'))

            <div class="alert success-alert mb-4">

                <i class="fa-solid fa-circle-check me-2"></i>

                {{ session('success') }}

            </div>

        @endif


        {{-- =====================================================
             ERRORS
        ====================================================== --}}

        @if($errors->any())

            <div class="alert alert-danger rounded-4 mb-4">

                <strong>Please fix the following:</strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('settings.update') }}"
            id="customerSettingsForm"
        >

            @csrf
            @method('PUT')


            {{-- =================================================
                 APPEARANCE
            ================================================== --}}

            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-icon">
                        <i class="fa-solid fa-palette"></i>
                    </div>

                    <div>

                        <h2 class="settings-card-title">
                            Appearance & Theme
                        </h2>

                        <p class="settings-card-description">
                            Choose your preferred Smart Basket interface.
                        </p>

                    </div>

                </div>


                <div class="theme-options">

                    {{-- LIGHT --}}

                    <div class="theme-option">

                        <input
                            type="radio"
                            name="dark_mode"
                            id="themeLight"
                            value="light"
                            {{ $currentTheme === 'light' ? 'checked' : '' }}
                        >

                        <label
                            for="themeLight"
                            class="theme-label"
                        >

                            <i class="fa-solid fa-sun"></i>

                            <span>Light Mode</span>

                            <small>Clean & bright</small>

                        </label>

                    </div>


                    {{-- DARK --}}

                    <div class="theme-option">

                        <input
                            type="radio"
                            name="dark_mode"
                            id="themeDark"
                            value="dark"
                            {{ $currentTheme === 'dark' ? 'checked' : '' }}
                        >

                        <label
                            for="themeDark"
                            class="theme-label"
                        >

                            <i class="fa-solid fa-moon"></i>

                            <span>Dark Mode</span>

                            <small>Premium night UI</small>

                        </label>

                    </div>


                    {{-- SYSTEM --}}

                    <div class="theme-option">

                        <input
                            type="radio"
                            name="dark_mode"
                            id="themeSystem"
                            value="system"
                            {{ $currentTheme === 'system' ? 'checked' : '' }}
                        >

                        <label
                            for="themeSystem"
                            class="theme-label"
                        >

                            <i class="fa-solid fa-desktop"></i>

                            <span>System</span>

                            <small>Follow device theme</small>

                        </label>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 GENERAL
            ================================================== --}}

            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-icon">
                        <i class="fa-solid fa-sliders"></i>
                    </div>

                    <div>

                        <h2 class="settings-card-title">
                            General Preferences
                        </h2>

                        <p class="settings-card-description">
                            Manage language and notification preferences.
                        </p>

                    </div>

                </div>


                {{-- LANGUAGE --}}

                <div class="setting-row">

                    <div class="setting-info">

                        <div class="setting-small-icon">
                            <i class="fa-solid fa-language"></i>
                        </div>

                        <div>

                            <div class="setting-name">
                                Language
                            </div>

                            <div class="setting-description">
                                Select your preferred language.
                            </div>

                        </div>

                    </div>


                    <select
                        name="language"
                        class="form-select premium-select"
                    >

                        <option
                            value="english"
                            {{ $language === 'english' ? 'selected' : '' }}
                        >
                            English
                        </option>

                        <option
                            value="hindi"
                            {{ $language === 'hindi' ? 'selected' : '' }}
                        >
                            हिन्दी
                        </option>

                        <option
                            value="gujarati"
                            {{ $language === 'gujarati' ? 'selected' : '' }}
                        >
                            ગુજરાતી
                        </option>

                    </select>

                </div>


                {{-- NOTIFICATIONS --}}

                <div class="setting-row">

                    <div class="setting-info">

                        <div class="setting-small-icon">
                            <i class="fa-solid fa-bell"></i>
                        </div>

                        <div>

                            <div class="setting-name">
                                Notifications
                            </div>

                            <div class="setting-description">
                                Receive order and account notifications.
                            </div>

                        </div>

                    </div>


                    <div class="form-check form-switch premium-switch">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="notificationSwitch"
                            {{ $notifications === 'enabled' ? 'checked' : '' }}
                        >

                        <input
                            type="hidden"
                            name="notifications"
                            id="notificationValue"
                            value="{{ $notifications === 'enabled' ? 'enabled' : 'disabled' }}"
                        >

                    </div>

                </div>

            </div>


            {{-- =================================================
                 LIVE PREVIEW
            ================================================== --}}

            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-icon">
                        <i class="fa-solid fa-eye"></i>
                    </div>

                    <div>

                        <h2 class="settings-card-title">
                            Live Preview
                        </h2>

                        <p class="settings-card-description">
                            See how your selected theme looks instantly.
                        </p>

                    </div>

                </div>


                <div class="preview-box">

                    <div class="preview-top">

                        <strong>
                            <i class="fa-solid fa-basket-shopping me-2"></i>
                            Smart Basket
                        </strong>

                        <span class="preview-dot"></span>

                    </div>


                    <div class="preview-content">

                        <div class="d-flex justify-content-between align-items-center">

                            <span class="fw-bold">
                                Premium Product
                            </span>

                            <span
                                style="color:var(--sb-primary)"
                                class="fw-bold"
                            >
                                ₹999
                            </span>

                        </div>

                        <small style="color:var(--sb-text-secondary)">
                            Your selected appearance is applied instantly.
                        </small>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 SECURITY
            ================================================== --}}

            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <div>

                        <h2 class="settings-card-title">
                            Security Center
                        </h2>

                        <p class="settings-card-description">
                            Manage your Smart Basket account protection.
                        </p>

                    </div>

                </div>


                <div class="setting-row">

                    <div class="setting-info">

                        <div class="setting-small-icon">
                            <i class="fa-solid fa-lock"></i>
                        </div>

                        <div>

                            <div class="setting-name">
                                Security PIN
                            </div>

                            <div class="setting-description">
                                Protect your account with a security PIN.
                            </div>

                        </div>

                    </div>


                    <a
                        href="{{ route('security.verify.page') }}"
                        class="btn btn-outline-primary premium-btn px-4"
                    >
                        <i class="fa-solid fa-shield me-2"></i>
                        Manage
                    </a>

                </div>

            </div>


            {{-- =================================================
                 SAVE
            ================================================== --}}

            <div class="save-area">

                <div class="save-bar">

                    <div>

                        <strong>
                            <i class="fa-solid fa-gear me-2"></i>
                            Settings
                        </strong>

                        <div
                            class="small"
                            style="color:var(--sb-text-secondary)"
                        >
                            Your preferences are saved to your account.
                        </div>

                    </div>


                    <button
                        type="submit"
                        class="btn save-btn"
                    >

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Save Settings

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


<script>

    /* =========================================================
       NOTIFICATION SWITCH
    ========================================================= */

    const notificationSwitch =
        document.getElementById('notificationSwitch');

    const notificationValue =
        document.getElementById('notificationValue');

    if (notificationSwitch && notificationValue) {

        notificationSwitch.addEventListener('change', function () {

            notificationValue.value =
                this.checked
                    ? 'enabled'
                    : 'disabled';

        });

    }


    /* =========================================================
       THEME FUNCTION
    ========================================================= */

    function applyCustomerTheme(selectedTheme) {

        let actualTheme = selectedTheme;

        if (selectedTheme === 'system') {

            actualTheme =
                window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches
                    ? 'dark'
                    : 'light';
        }

        document.documentElement.dataset.sbTheme =
            actualTheme;

        document.body.dataset.sbTheme =
            actualTheme;

    }


    /* =========================================================
       INSTANT THEME PREVIEW
    ========================================================= */

    document
        .querySelectorAll('input[name="dark_mode"]')
        .forEach(input => {

            input.addEventListener('change', function () {

                applyCustomerTheme(this.value);

            });

        });


    /* =========================================================
       SYSTEM THEME CHANGE
    ========================================================= */

    if (window.matchMedia) {

        const media =
            window.matchMedia(
                '(prefers-color-scheme: dark)'
            );

        const updateSystemTheme = () => {

            const systemRadio =
                document.getElementById('themeSystem');

            if (
                systemRadio &&
                systemRadio.checked
            ) {

                applyCustomerTheme('system');

            }

        };

        if (media.addEventListener) {

            media.addEventListener(
                'change',
                updateSystemTheme
            );

        } else {

            media.addListener(
                updateSystemTheme
            );

        }

    }


    /* =========================================================
       SAVE BUTTON FEEDBACK
    ========================================================= */

    const form =
        document.getElementById('customerSettingsForm');

    if (form) {

        form.addEventListener('submit', function () {

            const button =
                form.querySelector('.save-btn');

            if (button) {

                button.innerHTML =
                    '<i class="fa-solid fa-spinner fa-spin me-2"></i> Saving...';

                button.disabled = true;

            }

        });

    }

</script>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


<x-ai-hub-sidebar />


</body>

</html>