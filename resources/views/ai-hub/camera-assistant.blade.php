<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('ai-hub.partials.head', [
        'title' => 'AI Camera Assistant'
    ])

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/ai-camera-assistant.css') }}">

    <style>
        /* =========================================================
           SMART BASKET — AI CAMERA ASSISTANT
           ONE MAIN TASKBAR + THEME-AWARE THREE-DOT MENU
        ========================================================= */

        :root {
            color-scheme: light;

            --ca-bg: #f4f7ff;
            --ca-surface: #ffffff;
            --ca-surface-soft: #f8faff;
            --ca-text: #172554;
            --ca-muted: #64748b;
            --ca-border: #e2e8f0;
            --ca-primary: #2563eb;
            --ca-primary-dark: #1d4ed8;
            --ca-purple: #7c3aed;
            --ca-cyan: #06b6d4;
            --ca-shadow: 0 16px 45px rgba(15, 23, 42, .07);
            --ca-radius: 22px;

            --ca-taskbar-bg: rgba(255, 255, 255, .94);
            --ca-taskbar-text: #172554;
            --ca-menu-bg: rgba(255, 255, 255, .98);
            --ca-menu-hover: #eff6ff;
        }

        html[data-theme="dark"] {
            color-scheme: dark;

            --ca-bg: #080e1d;
            --ca-surface: #111a2e;
            --ca-surface-soft: #172238;
            --ca-text: #e5edff;
            --ca-muted: #a4b2cc;
            --ca-border: #293650;
            --ca-primary: #60a5fa;
            --ca-primary-dark: #3b82f6;
            --ca-purple: #a78bfa;
            --ca-cyan: #22d3ee;
            --ca-shadow: 0 18px 50px rgba(0, 0, 0, .24);

            --ca-taskbar-bg: rgba(13, 22, 40, .96);
            --ca-taskbar-text: #edf4ff;
            --ca-menu-bg: rgba(17, 26, 46, .99);
            --ca-menu-hover: #202f4b;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background:
                radial-gradient(ellipse at 5% 0%, rgba(37, 99, 235, .09), transparent 34%),
                radial-gradient(ellipse at 100% 15%, rgba(124, 58, 237, .08), transparent 30%),
                var(--ca-bg) !important;
            color: var(--ca-text);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            transition: background .25s ease, color .25s ease;
        }

        body,
        .ai-hub-layout,
        .ai-hub-main,
        .ai-ca-card,
        .ai-ca-card * {
            box-sizing: border-box;
        }

        a {
            text-decoration: none;
        }

        /* =========================================================
           PAGE LAYOUT
        ========================================================= */

        .ai-hub-layout {
            min-height: 100vh;
            background: transparent;
        }

        .ai-hub-main {
            width: min(1600px, 100%);
            margin: 0 auto;
            padding: 32px clamp(14px, 3vw, 40px) 55px;
            color: var(--ca-text);
        }

        .ai-ca-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
            margin-bottom: 27px;
            padding: clamp(23px, 3vw, 38px);
            border: 1px solid var(--ca-border);
            border-radius: 26px;
            background:
                radial-gradient(circle at 100% 0%, rgba(124, 58, 237, .12), transparent 36%),
                linear-gradient(135deg, var(--ca-surface), var(--ca-surface-soft));
            box-shadow: var(--ca-shadow);
        }

        .ai-ca-heading > div {
            min-width: 0;
        }

        .ai-hub-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 13px;
            padding: 7px 12px;
            border: 1px solid rgba(37, 99, 235, .18);
            border-radius: 999px;
            background: rgba(37, 99, 235, .08);
            color: var(--ca-primary);
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 1.6px;
        }

        .ai-ca-heading h1 {
            margin: 0;
            color: var(--ca-text);
            font-size: clamp(28px, 3vw, 43px);
            font-weight: 900;
            letter-spacing: -1.4px;
            line-height: 1.15;
        }

        .ai-ca-heading p {
            max-width: 700px;
            margin: 13px 0 0;
            color: var(--ca-muted);
            font-size: 14px;
            line-height: 1.8;
        }

        .ai-ca-heading > a {
            flex: 0 0 auto;
            border-radius: 12px;
            font-weight: 750;
        }

        /* =========================================================
           PRIVACY + ALERTS
        ========================================================= */

        .ai-ca-privacy {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 24px;
            padding: 18px 21px;
            border: 1px solid rgba(16, 185, 129, .22);
            border-radius: 17px;
            background: rgba(16, 185, 129, .07);
            color: var(--ca-text);
        }

        .ai-ca-privacy > i {
            margin-top: 3px;
            color: #10b981;
            font-size: 23px;
        }

        .ai-ca-privacy strong,
        .ai-ca-privacy span {
            display: block;
        }

        .ai-ca-privacy strong {
            margin-bottom: 5px;
            font-size: 13px;
        }

        .ai-ca-privacy span {
            color: var(--ca-muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .ai-hub-main .alert {
            border-radius: 14px;
        }

        /* =========================================================
           MAIN CARDS
        ========================================================= */

        .ai-ca-card {
            height: 100%;
            overflow: hidden;
            border: 1px solid var(--ca-border);
            border-radius: var(--ca-radius);
            background: var(--ca-surface);
            box-shadow: var(--ca-shadow);
            color: var(--ca-text);
        }

        .ai-ca-card-head {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 22px;
            border-bottom: 1px solid var(--ca-border);
            background: linear-gradient(
                135deg,
                var(--ca-surface),
                var(--ca-surface-soft)
            );
        }

        .ai-ca-card-icon {
            width: 49px;
            height: 49px;
            display: grid;
            place-items: center;
            flex: 0 0 49px;
            border-radius: 15px;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            color: #fff;
            font-size: 21px;
            box-shadow: 0 8px 22px rgba(37, 99, 235, .2);
        }

        .ai-ca-icon-ai {
            background: linear-gradient(135deg, #7c3aed, #2563eb);
        }

        .ai-ca-card-head h2 {
            margin: 0 0 6px;
            color: var(--ca-text);
            font-size: 18px;
            font-weight: 850;
        }

        .ai-ca-card-head small {
            color: var(--ca-muted);
            font-size: 11px;
            line-height: 1.6;
        }

        .ai-ca-viewport {
            position: relative;
            display: grid;
            place-items: center;
            min-height: 310px;
            margin: 20px;
            overflow: hidden;
            border: 1px dashed var(--ca-border);
            border-radius: 19px;
            background:
                radial-gradient(circle at 50% 30%, rgba(37, 99, 235, .10), transparent 50%),
                var(--ca-surface-soft);
        }

        #caVideo {
            display: block;
            width: 100%;
            height: auto;
            max-height: 530px;
            object-fit: contain;
            background: #070b14;
        }

        .ai-ca-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 13px;
            padding: 25px;
            color: var(--ca-muted);
            text-align: center;
            pointer-events: none;
        }

        .ai-ca-placeholder > i {
            color: var(--ca-primary);
            font-size: 48px;
            opacity: .75;
        }

        .ai-ca-placeholder p {
            max-width: 260px;
            margin: 0;
            font-size: 13px;
            line-height: 1.7;
        }

        #caCanvas {
            display: none;
        }

        .ai-ca-cam-loading {
            position: absolute;
            inset: 0;
            z-index: 5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 15px;
            background: var(--ca-surface);
            color: var(--ca-text);
        }

        .ai-ca-cam-loading.d-none {
            display: none !important;
        }

        .ai-ca-upload-preview {
            display: none;
            width: calc(100% - 40px);
            max-height: 400px;
            margin: 0 20px 20px;
            object-fit: contain;
            border-radius: 16px;
            background: var(--ca-surface-soft);
        }

        .ai-ca-upload-preview[src]:not([src=""]) {
            display: block;
        }

        .ai-ca-capture-tools {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
            padding: 0 20px 18px;
        }

        .ai-ca-capture-tools .btn,
        .ai-ca-actions .btn {
            border-radius: 11px;
            font-size: 12px;
            font-weight: 750;
            padding: 10px 13px;
        }

        .ai-ca-cam-status {
            margin: 0 20px 20px;
            padding: 11px 13px;
            border-radius: 11px;
            background: var(--ca-surface-soft);
            color: var(--ca-muted);
            font-size: 12px;
        }

        /* =========================================================
           ANALYSIS FORM + ACTIONS
        ========================================================= */

        .ai-ca-query-form {
            display: flex;
            gap: 10px;
            padding: 20px 20px 12px;
        }

        .ai-ca-query-form .form-control {
            min-width: 0;
            min-height: 46px;
            border-color: var(--ca-border);
            border-radius: 12px;
            background: var(--ca-surface-soft);
            color: var(--ca-text);
            font-size: 13px;
        }

        .ai-ca-query-form .form-control::placeholder {
            color: var(--ca-muted);
        }

        .ai-ca-query-form .btn {
            flex: 0 0 auto;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 800;
        }

        .ai-ca-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 0 20px 20px;
            border-bottom: 1px solid var(--ca-border);
        }

        .ai-ca-loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 45px 20px;
            text-align: center;
        }

        .ai-ca-loading.d-none {
            display: none !important;
        }

        .ai-ca-loader {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            height: 34px;
        }

        .ai-ca-loader span {
            width: 5px;
            height: 13px;
            border-radius: 8px;
            background: linear-gradient(180deg, #2563eb, #7c3aed);
            animation: caLoader 1s ease-in-out infinite;
        }

        .ai-ca-loader span:nth-child(2) { animation-delay: .1s; }
        .ai-ca-loader span:nth-child(3) { animation-delay: .2s; }
        .ai-ca-loader span:nth-child(4) { animation-delay: .3s; }
        .ai-ca-loader span:nth-child(5) { animation-delay: .4s; }

        @keyframes caLoader {
            0%, 100% { height: 12px; opacity: .5; }
            50% { height: 32px; opacity: 1; }
        }

        .ai-ca-loading p,
        .ai-ca-cam-loading p {
            margin: 0;
            color: var(--ca-text);
            font-size: 14px;
            font-weight: 800;
        }

        .ai-ca-loading small {
            color: var(--ca-muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .ai-ca-results {
            padding: 20px;
            color: var(--ca-text);
        }

        .ai-ca-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 35px 20px;
            border: 1px dashed var(--ca-border);
            border-radius: 16px;
            background: var(--ca-surface-soft);
            color: var(--ca-muted);
            text-align: center;
            font-size: 13px;
            line-height: 1.8;
        }

        .ai-ca-empty > i {
            color: var(--ca-purple);
            font-size: 32px;
        }

        .ai-ca-empty p {
            max-width: 390px;
            margin: 0;
        }

        .ai-ca-detection-grid,
        .ai-ca-analysis-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }

        .ai-ca-detection-item,
        .ai-ca-analysis-item {
            min-width: 0;
            padding: 15px;
            border: 1px solid var(--ca-border);
            border-radius: 15px;
            background: var(--ca-surface-soft);
        }

        .ai-ca-detection-item > i,
        .ai-ca-analysis-item > i {
            display: block;
            margin-bottom: 10px;
            color: var(--ca-primary);
            font-size: 19px;
        }

        .ai-ca-detection-item strong,
        .ai-ca-analysis-item strong {
            display: block;
            margin-bottom: 7px;
            color: var(--ca-text);
            font-size: 12px;
            font-weight: 850;
        }

        .ai-ca-detect-label,
        .ai-ca-analysis-item span {
            display: block;
            overflow-wrap: anywhere;
            color: var(--ca-muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .ai-ca-confidence {
            display: block;
            margin-top: 7px;
            color: var(--ca-muted);
            font-size: 10px;
        }

        .ai-ca-color-section,
        .ai-ca-fashion-section {
            margin-top: 20px;
            padding: 18px;
            border: 1px solid var(--ca-border);
            border-radius: 16px;
            background: var(--ca-surface);
        }

        .ai-ca-color-section h4,
        .ai-ca-fashion-section h4 {
            margin: 0 0 14px;
            color: var(--ca-text);
            font-size: 14px;
            font-weight: 850;
        }

        .ai-ca-color-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .ai-ca-color-chip {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border: 1px solid var(--ca-border);
            border-radius: 999px;
            background: var(--ca-surface-soft);
            color: var(--ca-text);
            font-size: 11px;
            font-weight: 750;
        }

        .ai-ca-fashion-list {
            display: grid;
            gap: 9px;
            margin: 0;
            padding-left: 20px;
            color: var(--ca-muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .ai-ca-summary {
            margin: 20px 0 0;
            padding: 17px;
            border-left: 3px solid var(--ca-primary);
            border-radius: 0 13px 13px 0;
            background: var(--ca-menu-hover);
            color: var(--ca-text);
            font-size: 13px;
            line-height: 1.8;
        }

        /* =========================================================
           HISTORY
        ========================================================= */

        .ai-ca-history {
            margin: 20px;
            padding: 18px;
            border: 1px solid var(--ca-border);
            border-radius: 16px;
            background: var(--ca-surface-soft);
        }

        .ai-ca-history.d-none {
            display: none !important;
        }

        .ai-ca-history-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 15px;
        }

        .ai-ca-history-head h4 {
            margin: 0;
            color: var(--ca-text);
            font-size: 14px;
            font-weight: 850;
        }

        .ai-ca-history .btn-close {
            filter: none;
        }

        html[data-theme="dark"] .ai-ca-history .btn-close {
            filter: invert(1);
        }

        /* =========================================================
           PRODUCT RECOMMENDATIONS
        ========================================================= */

        .ai-ca-section-title {
            margin: 25px 0 15px;
            color: var(--ca-text);
            font-size: 18px;
            font-weight: 900;
        }

        .ai-ca-products {
            display: grid;
            gap: 12px;
        }

        .ai-ca-product {
            display: grid;
            grid-template-columns: 90px minmax(0, 1fr);
            gap: 15px;
            padding: 14px;
            border: 1px solid var(--ca-border);
            border-radius: 16px;
            background: var(--ca-surface-soft);
            transition: border-color .2s ease, transform .2s ease;
        }

        .ai-ca-product:hover {
            border-color: var(--ca-primary);
            transform: translateY(-2px);
        }

        .ai-ca-product > img {
            width: 90px;
            height: 105px;
            object-fit: contain;
            border-radius: 12px;
            background: var(--ca-surface);
        }

        .ai-ca-product-body {
            min-width: 0;
        }

        .ai-ca-product-body h4 {
            margin: 3px 0 8px;
            color: var(--ca-text);
            font-size: 13px;
            font-weight: 850;
            overflow-wrap: anywhere;
        }

        .ai-ca-product-body p {
            margin: 0 0 8px;
            color: var(--ca-muted);
            font-size: 11px;
        }

        .ai-ca-reason {
            display: block;
            color: var(--ca-muted);
            font-size: 10px;
            line-height: 1.7;
        }

        .ai-ca-product-actions {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            padding-top: 12px;
            border-top: 1px solid var(--ca-border);
        }

        .ai-ca-price {
            color: var(--ca-primary);
            font-size: 17px;
            font-weight: 900;
        }

        .ai-ca-product-btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .ai-ca-product-btn-group .btn {
            border-radius: 10px;
            font-size: 11px;
            font-weight: 750;
        }

        /* =========================================================
           DARK THEME — BOOTSTRAP FORM AND BUTTON ADJUSTMENTS
        ========================================================= */

        html[data-theme="dark"] .form-control {
            border-color: var(--ca-border);
            background-color: var(--ca-surface-soft);
            color: var(--ca-text);
        }

        html[data-theme="dark"] .form-control:focus {
            border-color: var(--ca-primary);
            background-color: var(--ca-surface-soft);
            color: var(--ca-text);
            box-shadow: 0 0 0 .2rem rgba(96, 165, 250, .14);
        }

        html[data-theme="dark"] .btn-outline-secondary {
            border-color: var(--ca-border);
            color: var(--ca-text);
        }

        html[data-theme="dark"] .btn-outline-secondary:hover {
            background: var(--ca-menu-hover);
        }

        html[data-theme="dark"] .text-dark {
            color: var(--ca-text) !important;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */



        @media (max-width: 1050px) {






            .ai-hub-main {
                padding-top: 22px;
            }
        }

        @media (max-width: 700px) {











            .ai-hub-main {
                padding: 17px 12px 35px;
            }

            .ai-ca-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 17px;
                padding: 23px 18px;
                border-radius: 19px;
            }

            .ai-ca-heading h1 {
                font-size: 29px;
                letter-spacing: -.8px;
            }

            .ai-ca-heading p {
                font-size: 12px;
            }

            .ai-ca-card {
                border-radius: 18px;
            }

            .ai-ca-card-head {
                padding: 17px;
            }

            .ai-ca-viewport {
                min-height: 250px;
                margin: 13px;
            }

            .ai-ca-capture-tools {
                padding-right: 13px;
                padding-left: 13px;
            }

            .ai-ca-query-form {
                flex-direction: column;
                padding: 15px 14px 10px;
            }

            .ai-ca-query-form .btn {
                min-height: 43px;
            }

            .ai-ca-actions {
                padding: 0 14px 15px;
            }

            .ai-ca-results {
                padding: 14px;
            }

            .ai-ca-detection-grid,
            .ai-ca-analysis-grid {
                gap: 9px;
            }

            .ai-ca-detection-item,
            .ai-ca-analysis-item {
                padding: 12px;
            }

            .ai-ca-product {
                grid-template-columns: 72px minmax(0, 1fr);
                gap: 11px;
                padding: 11px;
            }

            .ai-ca-product > img {
                width: 72px;
                height: 85px;
            }

            .ai-ca-product-actions {
                align-items: flex-start;
                flex-direction: column;
            }

            .ai-ca-product-btn-group {
                width: 100%;
            }
        }

        @media (max-width: 390px) {



            .ai-ca-detection-grid,
            .ai-ca-analysis-grid {
                grid-template-columns: 1fr;
            }

            .ai-ca-capture-tools .btn,
            .ai-ca-actions .btn {
                font-size: 11px;
            }
        }

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
    <link rel="stylesheet" href="{{ asset('css/customer-page-title.css') }}">
</head>

<body>

@include('ai-hub.partials.navigation')

    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <main class="ai-hub-main">

        {{-- PAGE HEADER --}}

        <header class="ai-hub-heading ai-ca-heading">

            <div>
                <span class="ai-hub-eyebrow">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    VIRTUAL STYLE & PRODUCT RECOMMENDATION
                </span>

                <x-customer-page-hero>
<h1 class="sb-customer-page-title">AI Camera Assistant 📷</h1>
</x-customer-page-hero>

                <p>
                    Capture or upload a photo to explore AI-assisted
                    style suggestions and relevant Smart Basket products.
                    Recommendations are suggestions, not definitive
                    judgments about your appearance.
                </p>
            </div>

            @if(Route::has('products.index'))
                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-outline-primary"
                >
                    <i class="fa-solid fa-store me-1"></i>
                    Browse Products
                </a>
            @endif

        </header>

        {{-- SUCCESS MESSAGE --}}

        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- ERROR MESSAGE --}}

        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- VALIDATION ERRORS --}}

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong>Something went wrong:</strong>

                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- PRIVACY NOTICE --}}

        <div class="ai-ca-privacy">
            <i class="fa-solid fa-shield-halved"></i>

            <div>
                <strong>Your privacy matters.</strong>

                <span>
                    Your image should only be processed and retained
                    according to the application's actual backend privacy
                    implementation. Avoid uploading sensitive images.
                </span>
            </div>
        </div>

        {{-- CAMERA + RESULTS --}}

        <div class="row g-4">

            {{-- CAMERA CARD --}}

            <div class="col-lg-5">

                <section class="ai-ca-card ai-ca-camera-card">

                    <div class="ai-ca-card-head">
                        <span class="ai-ca-card-icon">
                            <i class="fa-solid fa-camera"></i>
                        </span>

                        <div>
                            <h2>Live Camera</h2>
                            <small>Front camera / webcam · full-body framing</small>
                        </div>
                    </div>

                    <div
                        class="ai-ca-alerts"
                        id="caAlerts"
                        aria-live="polite"
                    ></div>

                    <div class="ai-ca-viewport" id="caViewport">

                        <video
                            id="caVideo"
                            autoplay
                            playsinline
                            muted
                        ></video>

                        <div class="ai-ca-placeholder" id="caPlaceholder">
                            <i class="fa-solid fa-user-large"></i>

                            <p>
                                Press "Start Camera" to preview your
                                camera before capturing a photo.
                            </p>
                        </div>

                        <canvas id="caCanvas" class="d-none"></canvas>

                        <div
                            class="ai-ca-cam-loading d-none"
                            id="caCamLoading"
                        >
                            <div class="ai-ca-loader">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                            <p>Starting camera...</p>
                        </div>

                    </div>

                    <input
                        type="file"
                        id="caFile"
                        accept="image/jpeg,image/png,image/webp"
                        class="d-none"
                    >

                    <img
                        id="caUploadPreview"
                        class="ai-ca-upload-preview"
                        alt="Selected photo preview"
                    >

                    <div class="ai-ca-capture-tools">

                        <button type="button" class="btn btn-primary" id="caStartBtn">
                            <i class="fa-solid fa-video me-1"></i>
                            Start Camera
                        </button>

                        <button
                            type="button"
                            class="btn btn-warning d-none"
                            id="caCaptureBtn"
                        >
                            <i class="fa-solid fa-camera me-1"></i>
                            Capture
                        </button>

                        <button
                            type="button"
                            class="btn btn-info d-none"
                            id="caRetakeBtn"
                        >
                            <i class="fa-solid fa-rotate-right me-1"></i>
                            Retake
                        </button>

                        <button type="button" class="btn btn-outline-secondary" id="caUploadBtn">
                            <i class="fa-solid fa-upload me-1"></i>
                            Upload
                        </button>

                        <button
                            type="button"
                            class="btn btn-danger d-none"
                            id="caStopBtn"
                        >
                            <i class="fa-solid fa-stop me-1"></i>
                            Stop
                        </button>

                    </div>

                    <div class="ai-ca-cam-status" id="caStatus" aria-live="polite">
                        Camera is off.
                    </div>

                </section>

            </div>

            {{-- AI RESULT CARD --}}

            <div class="col-lg-7">

                <section class="ai-ca-card ai-ca-result-card">

                    <div class="ai-ca-card-head">
                        <span class="ai-ca-card-icon ai-ca-icon-ai">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </span>

                        <div>
                            <h2>AI Style Analysis</h2>
                            <small>Style ideas · colors · outfits · product recommendations</small>
                        </div>
                    </div>

                    {{-- AI QUERY FORM --}}

                    <form id="caAnalyzeForm" class="ai-ca-query-form">

                        <input
                            type="text"
                            id="caQuery"
                            name="query"
                            class="form-control"
                            placeholder="Ask AI, e.g. 'Suggest a casual outfit'"
                            autocomplete="off"
                        >

                        <button
                            type="submit"
                            class="btn btn-primary"
                            id="caAnalyzeBtn"
                        >
                            <i class="fa-solid fa-wand-magic-sparkles me-1"></i>
                            Analyze My Style
                        </button>

                    </form>

                    {{-- ACTION BUTTONS --}}

                    <div class="ai-ca-actions">

                        <button
                            type="button"
                            class="btn btn-info"
                            id="caVirtualTryOnBtn"
                            disabled
                        >
                            <i class="fa-solid fa-wand-magic-sparkles me-1"></i>
                            Virtual Try-On
                        </button>

                        <button
                            type="button"
                            class="btn btn-success"
                            id="caDownloadBtn"
                            disabled
                        >
                            <i class="fa-solid fa-file-pdf me-1"></i>
                            Download
                        </button>

                        <button
                            type="button"
                            class="btn btn-warning"
                            id="caShareBtn"
                            disabled
                        >
                            <i class="fa-solid fa-share-nodes me-1"></i>
                            Share
                        </button>

                        @if(Route::has('ai-camera-assistant.history'))
                            <a
                                href="{{ route('ai-camera-assistant.history') }}"
                                class="btn btn-outline-secondary"
                                id="caHistoryBtn"
                            >
                                <i class="fa-solid fa-clock-rotate-left me-1"></i>
                                History
                            </a>
                        @else
                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                id="caHistoryBtn"
                            >
                                <i class="fa-solid fa-clock-rotate-left me-1"></i>
                                History
                            </button>
                        @endif

                        <button type="button" class="btn btn-danger" id="caResetBtn">
                            <i class="fa-solid fa-rotate-left me-1"></i>
                            Reset
                        </button>

                    </div>

                    {{-- INLINE HISTORY PANEL --}}

                    <div class="ai-ca-history d-none" id="caHistoryPanel">

                        <div class="ai-ca-history-head">
                            <h4>
                                <i class="fa-solid fa-clock-rotate-left me-1"></i>
                                Your Analysis History
                            </h4>

                            <button
                                type="button"
                                class="btn-close"
                                id="caHistoryClose"
                                aria-label="Close history"
                            ></button>
                        </div>

                        <div id="caHistoryList">
                            <span class="ai-ca-empty">Loading history...</span>
                        </div>

                    </div>

                    {{-- AI LOADING --}}

                    <div class="ai-ca-loading d-none" id="caLoading">

                        <div class="ai-ca-loader">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                        <p>AI is analyzing your style...</p>

                        <small>
                            Preparing suggestions from the submitted photo
                            and the configured AI service.
                        </small>

                    </div>

                    {{-- ANALYSIS RESULTS --}}

                    <div id="caResults" class="ai-ca-results">

                        @if($analysis)

                            {{-- DETECTION --}}

                            <div class="ai-ca-detection-grid">

                                <div class="ai-ca-detection-item">
                                    <i class="fa-solid fa-palette"></i>
                                    <strong>Color Information</strong>

                                    <span class="ai-ca-detect-label">
                                        {{ ucfirst($analysis['detection']['skin_tone']['label'] ?? 'Not available') }}
                                    </span>

                                    <small class="ai-ca-confidence">
                                        Confidence:
                                        {{ $analysis['detection']['skin_tone']['confidence'] ?? '—' }}%
                                    </small>
                                </div>

                                <div class="ai-ca-detection-item">
                                    <i class="fa-solid fa-face-smile"></i>
                                    <strong>Face Shape</strong>

                                    <span class="ai-ca-detect-label">
                                        {{ ucfirst($analysis['detection']['face_shape']['label'] ?? 'Not available') }}
                                    </span>

                                    <small class="ai-ca-confidence">
                                        Confidence:
                                        {{ $analysis['detection']['face_shape']['confidence'] ?? '—' }}%
                                    </small>
                                </div>

                                <div class="ai-ca-detection-item">
                                    <i class="fa-solid fa-shirt"></i>
                                    <strong>Style Direction</strong>

                                    <span class="ai-ca-detect-label">
                                        {{ $analysis['style_preference']['suggested_style'] ?? 'Not available' }}
                                    </span>

                                    <small class="ai-ca-confidence">
                                        Style suggestions are estimates.
                                    </small>
                                </div>

                                <div class="ai-ca-detection-item">
                                    <i class="fa-solid fa-swatchbook"></i>
                                    <strong>Color Matching</strong>

                                    <span class="ai-ca-detect-label">
                                        {{ ucfirst($analysis['color_matching']['color_category'] ?? 'Not available') }}
                                    </span>

                                    <small class="ai-ca-confidence">
                                        Use these as optional styling ideas.
                                    </small>
                                </div>

                            </div>

                            {{-- ANALYSIS GRID --}}

                            <div class="ai-ca-analysis-grid">

                                <div class="ai-ca-analysis-item">
                                    <i class="fa-solid fa-face-smile"></i>
                                    <strong>Face Features</strong>

                                    <span>
                                        {{ $analysis['face_features']['skin_tone'] ?? '—' }}
                                        ·
                                        {{ $analysis['face_features']['tone'] ?? '—' }}
                                    </span>
                                </div>

                                <div class="ai-ca-analysis-item">
                                    <i class="fa-solid fa-person"></i>
                                    <strong>Appearance Notes</strong>

                                    <span>
                                        {{ $analysis['body_appearance']['frame'] ?? '—' }}
                                    </span>
                                </div>

                                <div class="ai-ca-analysis-item">
                                    <i class="fa-solid fa-shirt"></i>
                                    <strong>Style Preference</strong>

                                    <span>
                                        {{ ucfirst($analysis['style_preference']['suggested_style'] ?? 'casual') }}
                                        ·
                                        {{ $analysis['style_preference']['fit'] ?? 'regular' }} fit
                                    </span>
                                </div>

                                <div class="ai-ca-analysis-item">
                                    <i class="fa-solid fa-palette"></i>
                                    <strong>Color Matching</strong>

                                    <span>
                                        {{ ucfirst($analysis['color_matching']['color_category'] ?? 'neutral') }}
                                        tones
                                    </span>
                                </div>

                            </div>

                            {{-- SUITABLE COLORS --}}

                            @if(collect($analysis['color_matching']['suitable_colors'] ?? [])->isNotEmpty())

                                <div class="ai-ca-color-section">

                                    <h4>
                                        <i class="fa-solid fa-palette me-1"></i>
                                        Color Ideas
                                    </h4>

                                    <div class="ai-ca-color-chips">
                                        @foreach($analysis['color_matching']['suitable_colors'] as $color)
                                            <span class="ai-ca-color-chip">
                                                {{ $color }}
                                            </span>
                                        @endforeach
                                    </div>

                                </div>

                            @endif

                            {{-- FASHION RECOMMENDATIONS --}}

                            @if(collect($analysis['fashion_recommendations']['outfit_ideas'] ?? [])->isNotEmpty())

                                <div class="ai-ca-fashion-section">

                                    <h4>
                                        <i class="fa-solid fa-shirt me-1"></i>
                                        Fashion Recommendations
                                    </h4>

                                    <ul class="ai-ca-fashion-list">
                                        @foreach($analysis['fashion_recommendations']['outfit_ideas'] as $idea)
                                            <li>{{ $idea }}</li>
                                        @endforeach
                                    </ul>

                                </div>

                            @endif

                            {{-- SUMMARY --}}

                            @if(!empty($analysis['summary']))
                                <p class="ai-ca-summary">
                                    {{ $analysis['summary'] }}
                                </p>
                            @endif

                        @else

                            <div class="ai-ca-empty">
                                <i class="fa-solid fa-sparkles"></i>

                                <p>
                                    Capture or upload a photo to view
                                    the analysis returned by your configured
                                    AI service and explore product recommendations.
                                </p>
                            </div>

                        @endif

                        {{-- PRODUCT RECOMMENDATIONS --}}

                        @if(isset($recommendations) && $recommendations->isNotEmpty())

                            <h3 class="ai-ca-section-title">
                                <i class="fa-solid fa-bag-shopping me-1"></i>
                                Recommended for You
                            </h3>

                            <div class="ai-ca-products">

                                @foreach($recommendations as $item)

                                    @php
                                        $product = $item['product'];
                                    @endphp

                                    <article class="ai-ca-product">

                                        <img
                                            src="{{ asset('products/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            loading="lazy"
                                        >

                                        <div class="ai-ca-product-body">

                                            <h4>{{ $product->name }}</h4>

                                            <p>
                                                {{ $product->category ?: 'Smart Basket product' }}
                                                ·
                                                <span class="text-warning">★</span>
                                                {{ number_format((float) ($product->rating ?? 0), 1) }}
                                            </p>

                                            @if(!empty($item['reasons']))
                                                <small class="ai-ca-reason">
                                                    {{ collect($item['reasons'])->implode(' · ') }}
                                                </small>
                                            @endif

                                        </div>

                                        <div class="ai-ca-product-actions">

                                            <span class="ai-ca-price">
                                                ₹{{ number_format((float) $product->price, 2) }}
                                            </span>

                                            <div class="ai-ca-product-btn-group">

                                                @if(Route::has('cart.add'))
                                                    <form
                                                        action="{{ route('cart.add', $product->id) }}"
                                                        method="POST"
                                                        class="d-inline"
                                                    >
                                                        @csrf

                                                        <button
                                                            type="submit"
                                                            class="btn btn-sm btn-outline-primary"
                                                        >
                                                            <i class="fa-solid fa-cart-plus me-1"></i>
                                                            Add to Cart
                                                        </button>
                                                    </form>
                                                @endif

                                                @if(Route::has('products.show'))
                                                    <a
                                                        href="{{ route('products.show', $product->id) }}"
                                                        class="btn btn-sm btn-primary"
                                                    >
                                                        <i class="fa-solid fa-eye me-1"></i>
                                                        View Product
                                                    </a>
                                                @endif

                                            </div>

                                        </div>

                                    </article>

                                @endforeach

                            </div>

                        @endif

                    </div>

                </section>

            </div>

        </div>

    </main>

</div>

{{-- CAMERA FEATURE SCRIPT --}}

<script
    src="{{ asset('js/ai-camera-assistant.js') }}"
    defer
></script>

@stack('scripts')
    
</body>
</html>