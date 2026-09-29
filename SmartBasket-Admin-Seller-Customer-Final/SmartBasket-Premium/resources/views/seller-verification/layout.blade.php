<!doctype html>
<html lang="en" data-sb-theme="dark">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Seller Verification | SmartBasket')
    </title>


    {{-- =========================================================
        BOOTSTRAP
    ========================================================== --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    {{-- =========================================================
        FONT AWESOME
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >


    {{-- =========================================================
        SMARTBASKET PREMIUM THEME
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="{{ asset('css/premium-dark-theme.css') }}"
    >


    <style>

        /* =====================================================
           SMARTBASKET SELLER VERIFICATION LAYOUT
        ===================================================== */

        :root {

            --sb-bg: #07111f;

            --sb-surface: rgba(15, 23, 42, 0.96);

            --sb-surface-2: rgba(30, 41, 59, 0.72);

            --sb-border: rgba(148, 163, 184, 0.18);

            --sb-text: #e2e8f0;

            --sb-muted: #94a3b8;

            --sb-green: #22c55e;

            --sb-green-dark: #16a34a;

            --sb-blue: #2563eb;

            --sb-danger: #ef4444;

            --sb-warning: #f59e0b;

        }


        /* =====================================================
           BODY
        ===================================================== */

        html,
        body {

            min-height: 100%;

            margin: 0;

            padding: 0;

        }


        body {

            min-height: 100vh;

            background:

                radial-gradient(
                    circle at top left,
                    rgba(34, 197, 94, 0.10),
                    transparent 25%
                ),

                radial-gradient(
                    circle at top right,
                    rgba(59, 130, 246, 0.10),
                    transparent 25%
                ),

                radial-gradient(
                    circle at bottom right,
                    rgba(168, 85, 247, 0.08),
                    transparent 25%
                ),

                var(--sb-bg);

            color: var(--sb-text);

            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

        }


        /* =====================================================
           COMMON SELLER TASKBAR
        ===================================================== */

        .sb-seller-taskbar {

            position: sticky;

            top: 12px;

            z-index: 1000;

            width: min(1150px, calc(100% - 20px));

            margin: 12px auto 22px;

            padding: 9px;

            display: flex;

            align-items: center;

            gap: 8px;

            border-radius: 18px;

            background:
                rgba(8, 18, 31, .88);

            border:
                1px solid
                rgba(148, 163, 184, .16);

            box-shadow:
                0 18px 45px
                rgba(0, 0, 0, .22);

            backdrop-filter:
                blur(22px);

            -webkit-backdrop-filter:
                blur(22px);

        }


        .sb-seller-taskbar-brand {

            flex: 0 0 auto;

            display: inline-flex;

            align-items: center;

            gap: 9px;

            padding: 7px 10px;

            color: #f8fafc;

            text-decoration: none;

            border-radius: 13px;

            transition: .2s ease;

        }


        .sb-seller-taskbar-brand:hover {

            color: #ffffff;

            background:
                rgba(255,255,255,.045);

        }


        .sb-seller-taskbar-logo {

            width: 34px;

            height: 34px;

            flex: 0 0 34px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            border-radius: 11px;

            background:
                linear-gradient(
                    135deg,
                    #63e6b3,
                    #00c982
                );

            color: #042016;

            box-shadow:
                0 8px 20px
                rgba(0, 201, 130, .18);

            font-size: 14px;

        }


        .sb-seller-taskbar-brand-text {

            display: flex;

            flex-direction: column;

            line-height: 1.05;

        }


        .sb-seller-taskbar-brand-name {

            font-size: 12px;

            font-weight: 900;

            letter-spacing: -.01em;

        }


        .sb-seller-taskbar-brand-subtitle {

            margin-top: 3px;

            color: #7f968f;

            font-size: 7px;

            font-weight: 700;

            letter-spacing: .10em;

            text-transform: uppercase;

        }


        .sb-seller-taskbar-nav {

            flex: 1 1 auto;

            min-width: 0;

            display: flex;

            align-items: center;

            gap: 4px;

            overflow-x: auto;

            scrollbar-width: none;

        }


        .sb-seller-taskbar-nav::-webkit-scrollbar {

            display: none;

        }


        .sb-seller-taskbar-link {

            flex: 0 0 auto;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            min-height: 36px;

            padding: 0 10px;

            border-radius: 10px;

            color: #8fa6a0;

            text-decoration: none;

            font-size: 9px;

            font-weight: 800;

            white-space: nowrap;

            transition:
                color .18s ease,
                background .18s ease,
                transform .18s ease;

        }


        .sb-seller-taskbar-link i {

            font-size: 10px;

        }


        .sb-seller-taskbar-link:hover {

            color: #e8f0ee;

            background:
                rgba(255,255,255,.055);

            transform:
                translateY(-1px);

        }


        .sb-seller-taskbar-link.active {

            color: #63e6b3;

            background:
                rgba(0, 200, 130, .10);

            box-shadow:
                inset 0 0 0 1px
                rgba(0, 200, 130, .12);

        }


        .sb-seller-taskbar-add {

            flex: 0 0 auto;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            min-height: 36px;

            padding: 0 12px;

            border-radius: 10px;

            color: #052016;

            background:
                linear-gradient(
                    135deg,
                    #63e6b3,
                    #00c982
                );

            text-decoration: none;

            font-size: 9px;

            font-weight: 900;

            box-shadow:
                0 7px 18px
                rgba(0, 200, 130, .15);

            transition:
                transform .18s ease,
                filter .18s ease;

        }


        .sb-seller-taskbar-add:hover {

            color: #052016;

            transform:
                translateY(-1px);

            filter:
                brightness(1.05);

        }


        /* =====================================================
           THREE DOT MENU
        ===================================================== */

        .sb-seller-taskbar-more {

            position: relative;

            flex: 0 0 auto;

        }


        .sb-seller-taskbar-more-btn {

            width: 36px;

            height: 36px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            border: 1px solid
                rgba(148, 163, 184, .15);

            border-radius: 10px;

            background:
                rgba(255,255,255,.035);

            color: #a8bbb5;

            cursor: pointer;

            transition: .18s ease;

        }


        .sb-seller-taskbar-more-btn:hover {

            color: #63e6b3;

            border-color:
                rgba(0, 200, 130, .25);

            background:
                rgba(0, 200, 130, .07);

        }


        .sb-seller-taskbar-dropdown {

            position: absolute;

            top: calc(100% + 9px);

            right: 0;

            width: 225px;

            padding: 7px;

            border-radius: 15px;

            background:
                rgba(9, 20, 33, .98);

            border:
                1px solid
                rgba(148, 163, 184, .16);

            box-shadow:
                0 22px 55px
                rgba(0,0,0,.34);

            backdrop-filter:
                blur(20px);

            -webkit-backdrop-filter:
                blur(20px);

            opacity: 0;

            visibility: hidden;

            transform:
                translateY(-6px);

            transition:
                opacity .18s ease,
                visibility .18s ease,
                transform .18s ease;

        }


        .sb-seller-taskbar-more.open
        .sb-seller-taskbar-dropdown {

            opacity: 1;

            visibility: visible;

            transform:
                translateY(0);

        }


        .sb-taskbar-dropdown-title {

            padding:
                8px 10px 6px;

            color: #647b74;

            font-size: 7px;

            font-weight: 900;

            letter-spacing: .13em;

            text-transform: uppercase;

        }


        .sb-taskbar-dropdown-link {

            width: 100%;

            display: flex;

            align-items: center;

            gap: 9px;

            padding: 10px;

            border-radius: 10px;

            color: #a8bbb5;

            text-decoration: none;

            font-size: 9px;

            font-weight: 750;

            transition: .16s ease;

        }


        .sb-taskbar-dropdown-link i {

            width: 17px;

            text-align: center;

            color: #63e6b3;

        }


        .sb-taskbar-dropdown-link:hover {

            color: #f1f7f5;

            background:
                rgba(0, 200, 130, .07);

        }


        .sb-taskbar-dropdown-divider {

            height: 1px;

            margin: 6px 4px;

            background:
                rgba(148,163,184,.10);

        }


        .sb-taskbar-dropdown-logout {

            color: #fca5a5;

            background: transparent;

            border: 0;

            width: 100%;

            text-align: left;

            cursor: pointer;

        }


        .sb-taskbar-dropdown-logout i {

            color: #f87171;

        }


        /* =====================================================
           LIGHT THEME TASKBAR
        ===================================================== */

        html.light .sb-seller-taskbar,
        body.light .sb-seller-taskbar {

            background:
                rgba(255,255,255,.90);

            border-color:
                rgba(15,23,42,.10);

            box-shadow:
                0 18px 45px
                rgba(15,23,42,.10);

        }


        html.light .sb-seller-taskbar-brand,
        body.light .sb-seller-taskbar-brand {

            color: #111827;

        }


        html.light .sb-seller-taskbar-brand:hover,
        body.light .sb-seller-taskbar-brand:hover {

            color: #111827;

            background:
                rgba(15,23,42,.035);

        }


        html.light .sb-seller-taskbar-brand-subtitle,
        body.light .sb-seller-taskbar-brand-subtitle {

            color: #718096;

        }


        html.light .sb-seller-taskbar-link,
        body.light .sb-seller-taskbar-link {

            color: #64748b;

        }


        html.light .sb-seller-taskbar-link:hover,
        body.light .sb-seller-taskbar-link:hover {

            color: #111827;

            background:
                rgba(15,23,42,.045);

        }


        html.light .sb-seller-taskbar-link.active,
        body.light .sb-seller-taskbar-link.active {

            color: #00865a;

            background:
                rgba(0,200,130,.09);

        }


        html.light .sb-seller-taskbar-more-btn,
        body.light .sb-seller-taskbar-more-btn {

            color: #64748b;

            background:
                rgba(15,23,42,.035);

            border-color:
                rgba(15,23,42,.10);

        }


        html.light .sb-seller-taskbar-dropdown,
        body.light .sb-seller-taskbar-dropdown {

            background:
                rgba(255,255,255,.98);

            border-color:
                rgba(15,23,42,.10);

            box-shadow:
                0 22px 55px
                rgba(15,23,42,.15);

        }


        html.light .sb-taskbar-dropdown-title,
        body.light .sb-taskbar-dropdown-title {

            color: #94a3b8;

        }


        html.light .sb-taskbar-dropdown-link,
        body.light .sb-taskbar-dropdown-link {

            color: #475569;

        }


        html.light .sb-taskbar-dropdown-link:hover,
        body.light .sb-taskbar-dropdown-link:hover {

            color: #111827;

            background:
                rgba(0,200,130,.07);

        }


        /* =====================================================
           MAIN WRAPPER
        ===================================================== */

        .seller-verification-page {

            min-height: 100vh;

            width: 100%;

            padding: 0 16px 50px;

        }


        .seller-verification-container {

            width: min(1150px, 100%);

            margin: 0 auto;

        }


        /* =====================================================
           OLD TOP NAV
           Kept for compatibility with existing layout.
        ===================================================== */

        .seller-verification-topbar {

            display: none;

        }


        .seller-brand {

            display: inline-flex;

            align-items: center;

            gap: 10px;

            color: var(--sb-text);

            text-decoration: none;

            font-weight: 800;

            letter-spacing: -0.02em;

        }


        .seller-brand:hover {

            color: var(--sb-text);

        }


        .seller-brand-icon {

            width: 38px;

            height: 38px;

            border-radius: 12px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            background:
                linear-gradient(
                    135deg,
                    #22c55e,
                    #16a34a
                );

            color: #04130a;

            box-shadow:
                0 10px 25px
                rgba(34, 197, 94, 0.20);

        }


        .seller-brand-text {

            display: flex;

            flex-direction: column;

            line-height: 1.1;

        }


        .seller-brand-name {

            font-size: 1rem;

            font-weight: 900;

        }


        .seller-brand-subtitle {

            font-size: .68rem;

            color: var(--sb-muted);

            margin-top: 3px;

            letter-spacing: .08em;

            text-transform: uppercase;

        }


        .seller-login-link {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 9px 14px;

            border-radius: 999px;

            border: 1px solid var(--sb-border);

            background: rgba(148, 163, 184, .05);

            color: var(--sb-text);

            text-decoration: none;

            font-size: .82rem;

            font-weight: 700;

            transition: .18s ease;

        }


        .seller-login-link:hover {

            color: #fff;

            border-color:
                rgba(34, 197, 94, .40);

            background:
                rgba(34, 197, 94, .08);

            transform: translateY(-1px);

        }


        /* =====================================================
           FLASH MESSAGES
        ===================================================== */

        .sb-global-alert {

            width: min(1150px, 100%);

            margin: 0 auto 16px;

            border-radius: 14px;

            padding: 13px 16px;

            border: 1px solid transparent;

            font-size: .88rem;

            line-height: 1.5;

        }


        .sb-global-alert.success {

            color: #bbf7d0;

            background:
                rgba(34, 197, 94, .08);

            border-color:
                rgba(34, 197, 94, .20);

        }


        .sb-global-alert.error {

            color: #fecaca;

            background:
                rgba(239, 68, 68, .08);

            border-color:
                rgba(239, 68, 68, .20);

        }


        .sb-global-errors {

            margin: 0;

            padding-left: 20px;

        }


        /* =====================================================
           CARD
        ===================================================== */

        .verification-card {

            width: 100%;

            overflow: hidden;

            border-radius: 30px;

            background:
                var(--sb-surface);

            border:
                1px solid var(--sb-border);

            box-shadow:
                0 35px 90px
                rgba(0, 0, 0, .30);

            backdrop-filter: blur(18px);

        }


        /* =====================================================
           HEADER
        ===================================================== */

        .verification-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            padding: 30px 32px 26px;

            color: #f8fafc;

            background:
                linear-gradient(
                    135deg,
                    rgba(15, 23, 42, .98),
                    rgba(8, 74, 58, .92)
                );

            border-bottom:
                1px solid
                rgba(148, 163, 184, .12);

        }


        .verification-eyebrow {

            color: #86efac;

            font-size: .68rem;

            font-weight: 800;

            letter-spacing: .18em;

            text-transform: uppercase;

            margin-bottom: 7px;

        }


        .verification-header h1 {

            margin: 0;

            font-size:
                clamp(1.7rem, 3vw, 2.6rem);

            font-weight: 900;

            letter-spacing: -.045em;

        }


        .verification-header-description {

            margin-top: 8px;

            color: #cbd5e1;

            font-size: .88rem;

        }


        .verification-step-pill {

            flex-shrink: 0;

            padding: 9px 15px;

            border-radius: 999px;

            border:
                1px solid
                rgba(255, 255, 255, .14);

            background:
                rgba(255, 255, 255, .07);

            color: #ecfeff;

            font-size: .78rem;

            font-weight: 800;

            white-space: nowrap;

        }


        /* =====================================================
           CONTENT
        ===================================================== */

        .verification-body {

            padding: 0;

        }


        /* =====================================================
           LEGACY BOOTSTRAP COMPATIBILITY
        ===================================================== */

        .verification-body .form-control,
        .verification-body .form-select {

            border-radius: 12px;

        }


        .verification-body .btn {

            border-radius: 12px;

        }


        /* =====================================================
           DARK BOOTSTRAP OVERRIDES
        ===================================================== */

        .verification-body .text-muted {

            color:
                var(--sb-muted) !important;

        }


        .verification-body .form-control,
        .verification-body .form-select {

            background-color:
                rgba(15, 23, 42, .55);

            border-color:
                var(--sb-border);

            color:
                var(--sb-text);

        }


        .verification-body .form-control:focus,
        .verification-body .form-select:focus {

            background-color:
                rgba(15, 23, 42, .75);

            color:
                #fff;

            border-color:
                rgba(34, 197, 94, .55);

            box-shadow:
                0 0 0 3px
                rgba(34, 197, 94, .12);

        }


        .verification-body .form-control::placeholder {

            color:
                #64748b;

        }


        .verification-body .form-select option {

            background:
                #111827;

            color:
                #f8fafc;

        }


        /* =====================================================
           ALERTS INSIDE CONTENT
        ===================================================== */

        .verification-body .alert {

            border-radius: 14px;

            border-width: 1px;

        }


        /* =====================================================
           GENERIC SB CARD
        ===================================================== */

        .sb-card {

            width: 100%;

            padding: 28px;

        }


        .sb-step {

            display: inline-flex;

            align-items: center;

            padding: 7px 11px;

            border-radius: 999px;

            background:
                rgba(34, 197, 94, .09);

            border:
                1px solid
                rgba(34, 197, 94, .18);

            color:
                #86efac;

            font-size: .68rem;

            font-weight: 900;

            letter-spacing: .10em;

        }


        .sb-title {

            margin:
                16px 0 8px;

            color:
                var(--sb-text);

            font-size:
                clamp(1.6rem, 3vw, 2.2rem);

            font-weight:
                900;

            letter-spacing:
                -.04em;

        }


        .sb-description {

            margin:
                0 0 24px;

            color:
                var(--sb-muted);

            line-height:
                1.7;

        }


        /* =====================================================
           FORM GRID
        ===================================================== */

        .sb-grid {

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 18px;

        }


        .sb-field {

            display:
                flex;

            flex-direction:
                column;

            gap:
                8px;

        }


        .sb-label {

            color:
                var(--sb-text);

            font-size:
                .86rem;

            font-weight:
                800;

        }


        .sb-input,
        .sb-select {

            width:
                100%;

            min-height:
                46px;

            padding:
                11px 13px;

            border:
                1px solid
                var(--sb-border);

            border-radius:
                12px;

            background:
                rgba(15, 23, 42, .48);

            color:
                var(--sb-text);

            outline:
                none;

            transition:
                border-color .18s ease,
                box-shadow .18s ease,
                background .18s ease;

        }


        .sb-input:focus,
        .sb-select:focus {

            border-color:
                rgba(34, 197, 94, .55);

            box-shadow:
                0 0 0 3px
                rgba(34, 197, 94, .12);

            background:
                rgba(15, 23, 42, .72);

        }


        .sb-input::placeholder {

            color:
                #64748b;

        }


        .sb-field small {

            color:
                var(--sb-muted);

            font-size:
                .74rem;

            line-height:
                1.5;

        }


        /* =====================================================
           ACTIONS
        ===================================================== */

        .sb-actions {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                14px;

            margin-top:
                26px;

            padding-top:
                22px;

            border-top:
                1px solid
                var(--sb-border);

        }


        .sb-btn {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            min-height:
                44px;

            padding:
                10px 17px;

            border-radius:
                12px;

            border:
                1px solid
                var(--sb-border);

            background:
                rgba(148, 163, 184, .06);

            color:
                var(--sb-text);

            text-decoration:
                none;

            font-size:
                .85rem;

            font-weight:
                800;

            cursor:
                pointer;

            transition:
                transform .15s ease,
                filter .15s ease,
                border-color .15s ease;

        }


        .sb-btn:hover {

            color:
                #fff;

            transform:
                translateY(-1px);

            border-color:
                rgba(34, 197, 94, .35);

        }


        .sb-btn-primary {

            border:
                none;

            background:
                linear-gradient(
                    135deg,
                    #22c55e,
                    #16a34a
                );

            color:
                #03150b;

            box-shadow:
                0 10px 24px
                rgba(34, 197, 94, .16);

        }


        .sb-btn-primary:hover {

            color:
                #03150b;

            filter:
                brightness(1.05);

        }


        /* =====================================================
           FILE INPUT
        ===================================================== */

        input[type="file"] {

            cursor:
                pointer;

        }


        input[type="file"]::file-selector-button {

            margin-right:
                10px;

            border:
                0;

            border-radius:
                9px;

            padding:
                7px 10px;

            background:
                rgba(34, 197, 94, .12);

            color:
                #86efac;

            font-weight:
                700;

            cursor:
                pointer;

        }


        /* =====================================================
           LIGHT THEME
        ===================================================== */

        html.light,
        body.light {

            --sb-bg: #f5f7fb;

            --sb-surface: #ffffff;

            --sb-surface-2: #f8fafc;

            --sb-border:
                rgba(15, 23, 42, .10);

            --sb-text: #111827;

            --sb-muted: #64748b;

        }


        html.light body,
        body.light {

            background:
                radial-gradient(
                    circle at top left,
                    rgba(34, 197, 94, .10),
                    transparent 25%
                ),

                radial-gradient(
                    circle at top right,
                    rgba(59, 130, 246, .08),
                    transparent 25%
                ),

                #f5f7fb;

            color:
                var(--sb-text);

        }


        html.light .verification-card,
        body.light .verification-card {

            background:
                rgba(255, 255, 255, .96);

            box-shadow:
                0 30px 80px
                rgba(15, 23, 42, .10);

        }


        html.light .verification-header,
        body.light .verification-header {

            background:
                linear-gradient(
                    135deg,
                    #111827,
                    #064e3b
                );

        }


        html.light .sb-input,
        html.light .sb-select,
        body.light .sb-input,
        body.light .sb-select {

            background:
                #ffffff;

            color:
                #111827;

        }


        html.light .sb-input:focus,
        html.light .sb-select:focus,
        body.light .sb-input:focus,
        body.light .sb-select:focus {

            background:
                #ffffff;

            color:
                #111827;

        }


        html.light .sb-select option,
        body.light .sb-select option {

            background:
                #ffffff;

            color:
                #111827;

        }


        html.light .sb-btn,
        body.light .sb-btn {

            background:
                #ffffff;

            color:
                #111827;

        }


        html.light .sb-btn-primary,
        body.light .sb-btn-primary {

            background:
                linear-gradient(
                    135deg,
                    #22c55e,
                    #16a34a
                );

            color:
                #03150b;

        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 950px) {

            .sb-seller-taskbar-brand-text {

                display: none;

            }

            .sb-seller-taskbar-brand {

                padding:
                    7px;

            }

            .sb-seller-taskbar-link {

                padding:
                    0 9px;

            }

            .sb-seller-taskbar-add span {

                display: none;

            }

            .sb-seller-taskbar-add {

                width: 36px;

                padding: 0;

            }

        }


        @media (max-width: 768px) {

            .seller-verification-page {

                padding:
                    0 10px 35px;

            }


            .sb-seller-taskbar {

                position:
                    sticky;

                top:
                    7px;

                width:
                    calc(100% - 10px);

                margin:
                    7px auto 16px;

                padding:
                    7px;

                border-radius:
                    15px;

            }


            .sb-seller-taskbar-nav {

                gap:
                    2px;

            }


            .sb-seller-taskbar-link {

                min-height:
                    34px;

                padding:
                    0 9px;

                font-size:
                    8px;

            }


            .sb-seller-taskbar-link i {

                font-size:
                    9px;

            }


            .sb-seller-taskbar-add {

                min-height:
                    34px;

                width:
                    34px;

                height:
                    34px;

            }


            .sb-seller-taskbar-more-btn {

                width:
                    34px;

                height:
                    34px;

            }


            .seller-verification-topbar {

                align-items:
                    flex-start;

            }


            .seller-brand-subtitle {

                display:
                    none;

            }


            .verification-card {

                border-radius:
                    22px;

            }


            .verification-header {

                padding:
                    23px 20px;

                flex-direction:
                    column;

                align-items:
                    flex-start;

            }


            .verification-header h1 {

                font-size:
                    1.75rem;

            }


            .sb-card {

                padding:
                    20px 16px;

            }


            .sb-grid {

                grid-template-columns:
                    1fr;

            }


            .sb-actions {

                flex-direction:
                    column-reverse;

                align-items:
                    stretch;

            }


            .sb-btn {

                width:
                    100%;

            }

        }


        @media (max-width: 560px) {

            .sb-seller-taskbar {

                gap:
                    5px;

            }


            .sb-seller-taskbar-brand {

                display:
                    none;

            }


            .sb-seller-taskbar-nav {

                flex:
                    1 1 auto;

            }


            .sb-seller-taskbar-link {

                min-width:
                    37px;

                padding:
                    0 8px;

            }


            .sb-seller-taskbar-link span {

                display:
                    none;

            }


            .sb-seller-taskbar-link i {

                font-size:
                    11px;

            }


            .sb-seller-taskbar-add {

                display:
                    inline-flex;

            }


            .seller-verification-page {

                padding:
                    0 7px 25px;

            }


            .seller-login-link {

                padding:
                    8px 10px;

                font-size:
                    .72rem;

            }


            .seller-brand-name {

                font-size:
                    .9rem;

            }

        }


        @media (max-width: 380px) {

            .sb-seller-taskbar-link {

                min-width:
                    33px;

                padding:
                    0 6px;

            }


            .sb-seller-taskbar-more-btn {

                width:
                    32px;

                height:
                    32px;

            }


            .sb-seller-taskbar-add {

                width:
                    32px;

                height:
                    32px;

            }

        }

    </style>


    @stack('styles')

</head>


<body>


{{-- =========================================================
     COMMON SELLER TASKBAR
========================================================== --}}

@php

    $sellerCurrentRoute = Route::currentRouteName();

    $sellerProductsActive =
        in_array(
            $sellerCurrentRoute,
            [
                'seller.products.index',
                'seller.products',
                'seller.product.add',
                'seller.product.edit',
            ],
            true
        );

    $sellerOrdersActive =
        in_array(
            $sellerCurrentRoute,
            [
                'seller.orders.index',
                'seller.orders.show',
            ],
            true
        );

    $sellerPaymentsActive =
        in_array(
            $sellerCurrentRoute,
            [
                'seller.payments.index',
                'seller.payments.show',
                'seller.payments.receipt',
                'seller.payments.premium-receipt',
            ],
            true
        );

    $sellerVerificationActive =
        is_string($sellerCurrentRoute)
        && str_starts_with(
            $sellerCurrentRoute,
            'seller.verification.'
        );

@endphp


<nav
    class="sb-seller-taskbar"
    aria-label="Seller Navigation"
>

    {{-- BRAND --}}

    <a
        href="{{ route('seller.dashboard') }}"
        class="sb-seller-taskbar-brand"
        title="Seller Dashboard"
    >

        <span class="sb-seller-taskbar-logo">
            <i class="fa-solid fa-basket-shopping"></i>
        </span>

        <span class="sb-seller-taskbar-brand-text">

            <span class="sb-seller-taskbar-brand-name">
                SmartBasket
            </span>

            <span class="sb-seller-taskbar-brand-subtitle">
                Seller Panel
            </span>

        </span>

    </a>


    {{-- MAIN NAVIGATION --}}

    <div class="sb-seller-taskbar-nav">

        {{-- DASHBOARD --}}

        <a
            href="{{ route('seller.dashboard') }}"
            class="sb-seller-taskbar-link
                {{ $sellerCurrentRoute === 'seller.dashboard' ? 'active' : '' }}"
            title="Dashboard"
        >

            <i class="fa-solid fa-chart-line"></i>

            <span>
                Dashboard
            </span>

        </a>


        {{-- PRODUCTS --}}

        <a
            href="{{ route('seller.products.index') }}"
            class="sb-seller-taskbar-link
                {{ $sellerProductsActive ? 'active' : '' }}"
            title="Products"
        >

            <i class="fa-solid fa-box-open"></i>

            <span>
                Products
            </span>

        </a>


        {{-- ORDERS --}}

        <a
            href="{{ route('seller.orders.index') }}"
            class="sb-seller-taskbar-link
                {{ $sellerOrdersActive ? 'active' : '' }}"
            title="Orders"
        >

            <i class="fa-solid fa-cart-shopping"></i>

            <span>
                Orders
            </span>

        </a>


        {{-- PAYMENTS --}}

        <a
            href="{{ route('seller.payments.index') }}"
            class="sb-seller-taskbar-link
                {{ $sellerPaymentsActive ? 'active' : '' }}"
            title="Payments"
        >

            <i class="fa-solid fa-credit-card"></i>

            <span>
                Payments
            </span>

        </a>


        {{-- PROFILE --}}

        <a
            href="{{ route('seller.profile') }}"
            class="sb-seller-taskbar-link
                {{ $sellerCurrentRoute === 'seller.profile' ? 'active' : '' }}"
            title="Profile"
        >

            <i class="fa-solid fa-user"></i>

            <span>
                Profile
            </span>

        </a>


        {{-- SETTINGS --}}

        <a
            href="{{ route('seller.settings') }}"
            class="sb-seller-taskbar-link
                {{ $sellerCurrentRoute === 'seller.settings' ? 'active' : '' }}"
            title="Settings"
        >

            <i class="fa-solid fa-gear"></i>

            <span>
                Settings
            </span>

        </a>


        {{-- VERIFICATION --}}

        <a
            href="{{ route('seller.verification.index') }}"
            class="sb-seller-taskbar-link
                {{ $sellerVerificationActive ? 'active' : '' }}"
            title="Seller Verification"
        >

            <i class="fa-solid fa-shield-halved"></i>

            <span>
                Verification
            </span>

        </a>

    </div>


    {{-- ADD PRODUCT --}}

    <a
        href="{{ route('seller.product.add') }}"
        class="sb-seller-taskbar-add"
        title="Add Product"
    >

        <i class="fa-solid fa-plus"></i>

        <span>
            Add Product
        </span>

    </a>


    {{-- THREE DOT MENU --}}

    <div
        class="sb-seller-taskbar-more"
        id="sellerTaskbarMore"
    >

        <button
            type="button"
            class="sb-seller-taskbar-more-btn"
            id="sellerTaskbarMoreButton"
            aria-label="More Seller Options"
            aria-expanded="false"
            title="More"
        >

            <i class="fa-solid fa-ellipsis-vertical"></i>

        </button>


        <div
            class="sb-seller-taskbar-dropdown"
            id="sellerTaskbarDropdown"
        >

            <div class="sb-taskbar-dropdown-title">
                Seller Quick Menu
            </div>


            {{-- ADD PRODUCT --}}

            <a
                href="{{ route('seller.product.add') }}"
                class="sb-taskbar-dropdown-link"
            >

                <i class="fa-solid fa-plus"></i>

                <span>
                    Add New Product
                </span>

            </a>


            {{-- VERIFICATION --}}

            <a
                href="{{ route('seller.verification.index') }}"
                class="sb-taskbar-dropdown-link"
            >

                <i class="fa-solid fa-shield-halved"></i>

                <span>
                    Seller Verification
                </span>

            </a>


            {{-- PROFILE --}}

            <a
                href="{{ route('seller.profile') }}"
                class="sb-taskbar-dropdown-link"
            >

                <i class="fa-solid fa-user"></i>

                <span>
                    My Profile
                </span>

            </a>


            {{-- SETTINGS --}}

            <a
                href="{{ route('seller.settings') }}"
                class="sb-taskbar-dropdown-link"
            >

                <i class="fa-solid fa-gear"></i>

                <span>
                    Seller Settings
                </span>

            </a>


            <div class="sb-taskbar-dropdown-divider"></div>


            {{-- LOGOUT --}}

            <form
                method="POST"
                action="{{ route('seller.logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="sb-taskbar-dropdown-link sb-taskbar-dropdown-logout"
                >

                    <i class="fa-solid fa-right-from-bracket"></i>

                    <span>
                        Logout
                    </span>

                </button>

            </form>

        </div>

    </div>

</nav>


<div class="seller-verification-page">

    <div class="seller-verification-container">


        {{-- =====================================================
             OLD TOP BAR
             Hidden because common Seller taskbar is now used.
        ====================================================== --}}

        <div class="seller-verification-topbar">

            <a
                href="{{ route('seller.login') }}"
                class="seller-brand"
            >

                <span class="seller-brand-icon">
                    <i class="fa-solid fa-basket-shopping"></i>
                </span>

                <span class="seller-brand-text">

                    <span class="seller-brand-name">
                        SmartBasket
                    </span>

                    <span class="seller-brand-subtitle">
                        Seller Partner Program
                    </span>

                </span>

            </a>


            <a
                href="{{ route('seller.login') }}"
                class="seller-login-link"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Seller Login

            </a>

        </div>


        {{-- =====================================================
             FLASH SUCCESS
        ====================================================== --}}

        @if(session('success'))

            <div class="sb-global-alert success">

                <i class="fa-solid fa-circle-check me-1"></i>

                {{ session('success') }}

            </div>

        @endif


        {{-- =====================================================
             FLASH ERROR
        ====================================================== --}}

        @if(session('error'))

            <div class="sb-global-alert error">

                <i class="fa-solid fa-circle-exclamation me-1"></i>

                {{ session('error') }}

            </div>

        @endif


        {{-- =====================================================
             VALIDATION ERRORS
        ====================================================== --}}

        @if($errors->any())

            <div class="sb-global-alert error">

                <strong>
                    Please fix the following:
                </strong>

                <ul class="sb-global-errors mt-2 mb-0">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =====================================================
             MAIN CARD
        ====================================================== --}}

        <div class="verification-card">


            <header class="verification-header">

                <div>

                    <div class="verification-eyebrow">
                        Secure Seller Onboarding
                    </div>

                    <h1>
                        Verification &amp; KYC
                    </h1>

                    <div class="verification-header-description">
                        Complete all 6 steps to activate your SmartBasket seller account.
                    </div>

                </div>


                @if(isset($currentStep))

                    <div class="verification-step-pill">

                        Step {{ (int) $currentStep }} / 6

                    </div>

                @endif

            </header>


            <div class="verification-body">

                @yield('content')

            </div>


        </div>

    </div>

</div>


{{-- =========================================================
     BOOTSTRAP JS
========================================================== --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


{{-- =========================================================
     SELLER TASKBAR 3-DOTS MENU
========================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const moreWrapper =
        document.getElementById('sellerTaskbarMore');

    const moreButton =
        document.getElementById('sellerTaskbarMoreButton');


    if (!moreWrapper || !moreButton) {
        return;
    }


    moreButton.addEventListener('click', function (event) {

        event.stopPropagation();

        const isOpen =
            moreWrapper.classList.toggle('open');

        moreButton.setAttribute(
            'aria-expanded',
            isOpen ? 'true' : 'false'
        );

    });


    document.addEventListener('click', function (event) {

        if (!moreWrapper.contains(event.target)) {

            moreWrapper.classList.remove('open');

            moreButton.setAttribute(
                'aria-expanded',
                'false'
            );

        }

    });


    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {

            moreWrapper.classList.remove('open');

            moreButton.setAttribute(
                'aria-expanded',
                'false'
            );

        }

    });

});

</script>


{{-- =========================================================
     THEME SYNC
========================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
     * SmartBasket theme is normally controlled from
     * the main Settings page.
     *
     * Read the saved theme from localStorage first.
     */

    let savedTheme = null;

    try {

        savedTheme =
            localStorage.getItem('sb-theme') ||
            localStorage.getItem('smartbasket-theme') ||
            localStorage.getItem('theme');

    } catch (error) {

        savedTheme = null;

    }


    /*
     * Detect old theme class if localStorage
     * does not contain a value.
     */

    if (!savedTheme) {

        if (
            document.documentElement.classList.contains('light') ||
            document.body.classList.contains('light')
        ) {

            savedTheme = 'light';

        } else {

            savedTheme = 'dark';

        }

    }


    /*
     * Normalize theme values.
     */

    if (
        savedTheme === 'light' ||
        savedTheme === 'light-mode'
    ) {

        savedTheme = 'light';

    } else {

        savedTheme = 'dark';

    }


    /*
     * Apply theme.
     */

    document.documentElement.setAttribute(
        'data-sb-theme',
        savedTheme
    );

    document.documentElement.classList.toggle(
        'light',
        savedTheme === 'light'
    );

    document.body.classList.toggle(
        'light',
        savedTheme === 'light'
    );


    /*
     * Listen for theme changes from another tab/page.
     */

    window.addEventListener('storage', function (event) {

        if (
            event.key === 'sb-theme' ||
            event.key === 'smartbasket-theme' ||
            event.key === 'theme'
        ) {

            const theme =
                event.newValue === 'light'
                    ? 'light'
                    : 'dark';


            document.documentElement.setAttribute(
                'data-sb-theme',
                theme
            );

            document.documentElement.classList.toggle(
                'light',
                theme === 'light'
            );

            document.body.classList.toggle(
                'light',
                theme === 'light'
            );

        }

    });

});


/*
 * ==========================================================
 * GLOBAL CONFIRMATION FOR FINAL SUBMISSION
 * ==========================================================
 */

document.addEventListener('submit', function (event) {

    const form = event.target;

    if (!form) {
        return;
    }


    const submitButton =
        form.querySelector(
            'button[type="submit"]'
        );


    if (!submitButton) {
        return;
    }


    const buttonText =
        submitButton.textContent
            .trim()
            .toUpperCase();


    if (
        buttonText.includes('SUBMIT APPLICATION')
    ) {

        const confirmed = window.confirm(
            'Are you sure you want to submit your Seller Verification & KYC application? Once submitted, the application will be sent for SmartBasket admin review.'
        );


        if (!confirmed) {

            event.preventDefault();

            return;

        }

    }

});

</script>


@stack('scripts')

</body>

</html>