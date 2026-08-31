<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- =========================================================
         SMART BASKET — PREMIUM AI CAMERA
         GLOBAL HEAD / THEME
    ========================================================== --}}

    @include('ai-hub.partials.head', [
        'title' => 'AI Camera Assistant'
    ])

    <link
        rel="stylesheet"
        href="{{ asset('css/ai-camera-assistant.css') }}"
    >

    {{-- =========================================================
         PREMIUM PAGE THEME
         Page-specific styling only.
         Global AI HUB remains SINGLE INSTANCE.
    ========================================================== --}}

    <style>

        /* =====================================================
           SMART BASKET — AI CAMERA PREMIUM THEME
        ===================================================== */

        :root {
            --sb-ai-primary: #6366f1;
            --sb-ai-primary-2: #8b5cf6;
            --sb-ai-accent: #06b6d4;

            --sb-ai-bg: #f5f7ff;
            --sb-ai-card: rgba(255,255,255,.88);
            --sb-ai-card-solid: #ffffff;

            --sb-ai-text: #111827;
            --sb-ai-muted: #6b7280;
            --sb-ai-border: rgba(99,102,241,.12);

            --sb-ai-shadow:
                0 20px 60px rgba(31,41,55,.08);

            --sb-ai-radius: 24px;
        }


        /* =====================================================
           PAGE BACKGROUND
        ===================================================== */

        .sb-ai-page {
            position: relative;
            min-height: 100vh;
        }

        .sb-ai-page::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: -1;

            background:
                radial-gradient(
                    circle at 8% 8%,
                    rgba(99,102,241,.12),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 92% 12%,
                    rgba(6,182,212,.10),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 50% 100%,
                    rgba(139,92,246,.08),
                    transparent 35%
                );
        }


        /* =====================================================
           PREMIUM HEADER
        ===================================================== */

        .sb-ai-heading {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;

            padding: 28px 30px;
            margin-bottom: 24px;

            border: 1px solid var(--sb-ai-border);
            border-radius: var(--sb-ai-radius);

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.96),
                    rgba(248,250,255,.82)
                );

            box-shadow: var(--sb-ai-shadow);
            overflow: hidden;
        }

        .sb-ai-heading::after {
            content: "";
            position: absolute;

            width: 180px;
            height: 180px;

            right: -80px;
            top: -100px;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    rgba(99,102,241,.18),
                    rgba(139,92,246,.08)
                );
        }

        .sb-ai-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            margin-bottom: 8px;

            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;

            color: var(--sb-ai-primary);
        }

        .sb-ai-eyebrow::before {
            content: "";
            width: 8px;
            height: 8px;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-ai-primary),
                    var(--sb-ai-accent)
                );

            box-shadow:
                0 0 0 5px rgba(99,102,241,.08);
        }

        .sb-ai-heading h1 {
            position: relative;
            z-index: 1;

            margin: 0;

            font-size: clamp(1.8rem, 3vw, 2.8rem);
            font-weight: 850;
            letter-spacing: -.04em;

            color: var(--sb-ai-text);
        }

        .sb-ai-heading p {
            position: relative;
            z-index: 1;

            margin: 9px 0 0;
            max-width: 680px;

            color: var(--sb-ai-muted);
            line-height: 1.65;
        }


        /* =====================================================
           PREMIUM BUTTONS
        ===================================================== */

        .sb-ai-page .btn {
            border-radius: 13px;
            font-weight: 700;
            transition:
                transform .2s ease,
                box-shadow .2s ease,
                border-color .2s ease;
        }

        .sb-ai-page .btn:hover {
            transform: translateY(-2px);
        }

        .sb-ai-page .btn-primary {
            border: 0;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-ai-primary),
                    var(--sb-ai-primary-2)
                );

            box-shadow:
                0 10px 24px rgba(99,102,241,.22);
        }

        .sb-ai-page .btn-primary:hover {
            box-shadow:
                0 15px 32px rgba(99,102,241,.30);
        }


        /* =====================================================
           ALERTS
        ===================================================== */

        .sb-ai-page .alert {
            border: 0;
            border-radius: 16px;
            padding: 14px 17px;
            box-shadow: 0 8px 25px rgba(0,0,0,.05);
        }


        /* =====================================================
           PRIVACY CARD
        ===================================================== */

        .sb-ai-privacy {
            display: flex;
            align-items: flex-start;
            gap: 14px;

            padding: 17px 20px;
            margin-bottom: 24px;

            border: 1px solid rgba(6,182,212,.15);
            border-radius: 18px;

            background:
                linear-gradient(
                    135deg,
                    rgba(236,254,255,.94),
                    rgba(239,246,255,.92)
                );

            box-shadow:
                0 12px 30px rgba(6,182,212,.07);
        }

        .sb-ai-privacy > i {
            flex: 0 0 auto;

            width: 42px;
            height: 42px;

            display: grid;
            place-items: center;

            border-radius: 13px;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-ai-accent),
                    var(--sb-ai-primary)
                );

            box-shadow:
                0 8px 18px rgba(6,182,212,.20);
        }

        .sb-ai-privacy strong {
            display: block;
            margin-bottom: 3px;

            color: #0f172a;
        }

        .sb-ai-privacy span {
            display: block;

            color: #64748b;
            font-size: .9rem;
            line-height: 1.55;
        }


        /* =====================================================
           MAIN CARDS
        ===================================================== */

        .sb-ai-card {
            position: relative;

            height: 100%;

            padding: 22px;

            border:
                1px solid var(--sb-ai-border);

            border-radius: var(--sb-ai-radius);

            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.96),
                    rgba(248,250,255,.88)
                );

            box-shadow: var(--sb-ai-shadow);

            overflow: hidden;
        }

        .sb-ai-card::before {
            content: "";

            position: absolute;

            width: 150px;
            height: 150px;

            top: -80px;
            right: -70px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(99,102,241,.12),
                    transparent 68%
                );

            pointer-events: none;
        }


        /* =====================================================
           CARD HEADER
        ===================================================== */

        .sb-ai-card-head {
            position: relative;
            z-index: 1;

            display: flex;
            align-items: center;
            gap: 13px;

            margin-bottom: 20px;
        }

        .sb-ai-card-icon {
            width: 48px;
            height: 48px;

            flex: 0 0 auto;

            display: grid;
            place-items: center;

            border-radius: 15px;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-ai-primary),
                    var(--sb-ai-primary-2)
                );

            box-shadow:
                0 10px 22px rgba(99,102,241,.20);
        }

        .sb-ai-icon-ai {
            background:
                linear-gradient(
                    135deg,
                    #8b5cf6,
                    #ec4899
                );

            box-shadow:
                0 10px 22px rgba(139,92,246,.22);
        }

        .sb-ai-card-head h2 {
            margin: 0;

            font-size: 1.18rem;
            font-weight: 800;

            color: var(--sb-ai-text);
        }

        .sb-ai-card-head small {
            display: block;

            margin-top: 3px;

            color: var(--sb-ai-muted);
        }


        /* =====================================================
           CAMERA VIEWPORT
        ===================================================== */

        .sb-ai-viewport {
            position: relative;

            min-height: 440px;

            display: flex;
            align-items: center;
            justify-content: center;

            overflow: hidden;

            border-radius: 20px;

            background:
                radial-gradient(
                    circle at 50% 30%,
                    rgba(99,102,241,.20),
                    transparent 35%
                ),
                linear-gradient(
                    145deg,
                    #111827,
                    #1e1b4b
                );

            border: 1px solid rgba(255,255,255,.08);

            box-shadow:
                inset 0 0 0 1px rgba(255,255,255,.04),
                0 15px 35px rgba(15,23,42,.16);
        }

        .sb-ai-viewport video {
            width: 100%;
            height: 100%;

            min-height: 440px;

            display: block;

            object-fit: cover;
        }

        .sb-ai-placeholder {
            position: absolute;
            inset: 0;

            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;

            padding: 30px;

            text-align: center;

            color: rgba(255,255,255,.80);
        }

        .sb-ai-placeholder i {
            width: 78px;
            height: 78px;

            display: grid;
            place-items: center;

            margin-bottom: 18px;

            border-radius: 24px;

            font-size: 2rem;

            color: white;

            background:
                rgba(255,255,255,.10);

            border:
                1px solid rgba(255,255,255,.14);

            box-shadow:
                0 15px 35px rgba(0,0,0,.18);
        }

        .sb-ai-placeholder p {
            max-width: 300px;

            margin: 0;

            color: rgba(255,255,255,.70);
        }


        /* =====================================================
           UPLOAD PREVIEW
        ===================================================== */

        .sb-ai-upload-preview {
            display: none;

            width: 100%;

            max-height: 300px;

            margin-top: 16px;

            object-fit: contain;

            border-radius: 18px;

            border:
                1px solid var(--sb-ai-border);

            background: #f8fafc;

            box-shadow:
                0 12px 28px rgba(15,23,42,.08);
        }


        /* =====================================================
           CAMERA CONTROLS
        ===================================================== */

        .sb-ai-capture-tools {
            display: grid;

            grid-template-columns:
                repeat(auto-fit, minmax(125px, 1fr));

            gap: 10px;

            margin-top: 17px;
        }

        .sb-ai-capture-tools .btn {
            min-height: 45px;
        }

        .sb-ai-cam-status {
            display: flex;
            align-items: center;
            justify-content: center;

            min-height: 42px;

            margin-top: 14px;

            padding: 10px 14px;

            border-radius: 13px;

            color: #64748b;

            background: #f8fafc;

            border:
                1px solid rgba(148,163,184,.16);

            font-size: .88rem;
            font-weight: 600;
        }


        /* =====================================================
           QUERY FORM
        ===================================================== */

        .sb-ai-query-form {
            display: grid;

            grid-template-columns: 1fr auto;

            gap: 10px;

            margin-bottom: 16px;
        }

        .sb-ai-query-form .form-control {
            min-height: 48px;

            border-radius: 14px;

            border:
                1px solid rgba(99,102,241,.14);

            background:
                rgba(255,255,255,.88);

            box-shadow:
                inset 0 1px 2px rgba(15,23,42,.02);

            transition:
                border-color .2s ease,
                box-shadow .2s ease;
        }

        .sb-ai-query-form .form-control:focus {
            border-color:
                rgba(99,102,241,.55);

            box-shadow:
                0 0 0 4px rgba(99,102,241,.10);
        }


        /* =====================================================
           ACTIONS
        ===================================================== */

        .sb-ai-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;

            padding: 14px;

            margin-bottom: 18px;

            border-radius: 17px;

            background:
                rgba(248,250,252,.75);

            border:
                1px solid rgba(148,163,184,.12);
        }

        .sb-ai-actions .btn {
            min-height: 42px;
        }


        /* =====================================================
           LOADING
        ===================================================== */

        .sb-ai-loading {
            text-align: center;

            padding: 35px 20px;

            border-radius: 18px;

            background:
                linear-gradient(
                    135deg,
                    rgba(99,102,241,.06),
                    rgba(139,92,246,.06)
                );

            border:
                1px solid rgba(99,102,241,.10);
        }

        .sb-ai-loader {
            display: flex;
            justify-content: center;
            gap: 7px;

            margin-bottom: 15px;
        }

        .sb-ai-loader span {
            width: 9px;
            height: 9px;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-ai-primary),
                    var(--sb-ai-accent)
                );

            animation:
                sbAiPulse 1.1s infinite ease-in-out;
        }

        .sb-ai-loader span:nth-child(2) {
            animation-delay: .12s;
        }

        .sb-ai-loader span:nth-child(3) {
            animation-delay: .24s;
        }

        .sb-ai-loader span:nth-child(4) {
            animation-delay: .36s;
        }

        .sb-ai-loader span:nth-child(5) {
            animation-delay: .48s;
        }

        @keyframes sbAiPulse {
            0%, 60%, 100% {
                transform: translateY(0);
                opacity: .45;
            }

            30% {
                transform: translateY(-7px);
                opacity: 1;
            }
        }


        /* =====================================================
           DETECTION GRID
        ===================================================== */

        .sb-ai-detection-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 12px;

            margin-bottom: 20px;
        }

        .sb-ai-detection-item {
            position: relative;

            display: flex;
            flex-direction: column;

            padding: 17px;

            border-radius: 18px;

            border:
                1px solid rgba(99,102,241,.10);

            background:
                linear-gradient(
                    145deg,
                    #ffffff,
                    #f8faff
                );

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }

        .sb-ai-detection-item:hover {
            transform: translateY(-3px);

            box-shadow:
                0 14px 30px rgba(99,102,241,.10);
        }

        .sb-ai-detection-item > i {
            width: 38px;
            height: 38px;

            display: grid;
            place-items: center;

            margin-bottom: 11px;

            border-radius: 12px;

            color: var(--sb-ai-primary);

            background:
                rgba(99,102,241,.09);
        }

        .sb-ai-detection-item strong {
            font-size: .82rem;
            color: var(--sb-ai-muted);
        }

        .sb-ai-detect-label {
            margin-top: 4px;

            font-size: 1rem;
            font-weight: 800;

            color: var(--sb-ai-text);
        }

        .sb-ai-confidence {
            margin-top: 5px;

            color: #94a3b8;
            font-size: .72rem;
        }


        /* =====================================================
           ANALYSIS GRID
        ===================================================== */

        .sb-ai-analysis-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 11px;

            margin-bottom: 20px;
        }

        .sb-ai-analysis-item {
            display: grid;

            grid-template-columns: 38px 1fr;

            column-gap: 10px;

            padding: 14px;

            border-radius: 16px;

            background:
                #f8fafc;

            border:
                1px solid rgba(148,163,184,.11);
        }

        .sb-ai-analysis-item > i {
            grid-row: span 2;

            width: 38px;
            height: 38px;

            display: grid;
            place-items: center;

            border-radius: 11px;

            color: var(--sb-ai-primary);

            background:
                rgba(99,102,241,.08);
        }

        .sb-ai-analysis-item strong {
            font-size: .8rem;
            color: var(--sb-ai-muted);
        }

        .sb-ai-analysis-item span {
            margin-top: 3px;

            color: var(--sb-ai-text);

            font-size: .9rem;
            font-weight: 700;
        }


        /* =====================================================
           COLORS
        ===================================================== */

        .sb-ai-color-section,
        .sb-ai-fashion-section {
            padding: 18px;

            margin-bottom: 18px;

            border-radius: 18px;

            background:
                linear-gradient(
                    135deg,
                    rgba(248,250,252,.96),
                    rgba(241,245,249,.80)
                );

            border:
                1px solid rgba(148,163,184,.12);
        }

        .sb-ai-color-section h4,
        .sb-ai-fashion-section h4 {
            margin: 0 0 13px;

            font-size: 1rem;
            font-weight: 800;

            color: var(--sb-ai-text);
        }

        .sb-ai-color-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .sb-ai-color-chip {
            display: inline-flex;
            align-items: center;

            min-height: 34px;

            padding: 7px 12px;

            border-radius: 999px;

            font-size: .8rem;
            font-weight: 700;

            color: var(--sb-ai-primary);

            background:
                rgba(99,102,241,.08);

            border:
                1px solid rgba(99,102,241,.12);
        }


        /* =====================================================
           FASHION LIST
        ===================================================== */

        .sb-ai-fashion-list {
            margin: 0;
            padding: 0;

            list-style: none;
        }

        .sb-ai-fashion-list li {
            position: relative;

            padding: 10px 12px 10px 30px;

            margin-bottom: 7px;

            border-radius: 12px;

            color: #475569;

            background: white;

            border:
                1px solid rgba(148,163,184,.10);
        }

        .sb-ai-fashion-list li::before {
            content: "✦";

            position: absolute;
            left: 11px;
            top: 9px;

            color: var(--sb-ai-primary);

            font-weight: 900;
        }


        /* =====================================================
           SUMMARY
        ===================================================== */

        .sb-ai-summary {
            position: relative;

            margin: 18px 0;

            padding: 18px 20px;

            border-left:
                4px solid var(--sb-ai-primary);

            border-radius: 0 16px 16px 0;

            background:
                linear-gradient(
                    135deg,
                    rgba(99,102,241,.06),
                    rgba(139,92,246,.05)
                );

            color: #475569;

            line-height: 1.7;
        }


        /* =====================================================
           PRODUCTS
        ===================================================== */

        .sb-ai-section-title {
            display: flex;
            align-items: center;
            gap: 8px;

            margin: 25px 0 14px;

            font-size: 1.15rem;
            font-weight: 850;

            color: var(--sb-ai-text);
        }

        .sb-ai-products {
            display: grid;

            grid-template-columns:
                repeat(auto-fit, minmax(250px, 1fr));

            gap: 15px;
        }

        .sb-ai-product {
            display: flex;
            flex-direction: column;

            overflow: hidden;

            border-radius: 19px;

            background: white;

            border:
                1px solid rgba(99,102,241,.10);

            box-shadow:
                0 10px 28px rgba(15,23,42,.06);

            transition:
                transform .22s ease,
                box-shadow .22s ease;
        }

        .sb-ai-product:hover {
            transform: translateY(-5px);

            box-shadow:
                0 18px 38px rgba(99,102,241,.13);
        }

        .sb-ai-product > img {
            width: 100%;
            height: 210px;

            display: block;

            object-fit: cover;

            background: #f8fafc;
        }

        .sb-ai-product-body {
            padding: 15px 16px 8px;
        }

        .sb-ai-product-body h4 {
            margin: 0 0 6px;

            font-size: .98rem;
            font-weight: 800;

            color: var(--sb-ai-text);
        }

        .sb-ai-product-body p {
            margin: 0;

            color: var(--sb-ai-muted);

            font-size: .78rem;
        }

        .sb-ai-reason {
            display: block;

            margin-top: 8px;

            color: #64748b;

            line-height: 1.45;
        }

        .sb-ai-product-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;

            padding: 12px 16px 16px;
        }

        .sb-ai-price {
            font-size: 1.05rem;
            font-weight: 850;

            color: var(--sb-ai-primary);

            white-space: nowrap;
        }

        .sb-ai-product-btn-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 6px;
        }

        .sb-ai-product-btn-group .btn {
            font-size: .72rem;
            padding: 7px 10px;
        }


        /* =====================================================
           EMPTY STATE
        ===================================================== */

        .sb-ai-empty {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;

            min-height: 300px;

            padding: 35px;

            text-align: center;

            border-radius: 20px;

            background:
                linear-gradient(
                    145deg,
                    #f8fafc,
                    #eef2ff
                );

            border:
                1px dashed rgba(99,102,241,.20);
        }

        .sb-ai-empty > i {
            width: 70px;
            height: 70px;

            display: grid;
            place-items: center;

            border-radius: 22px;

            margin-bottom: 15px;

            font-size: 1.7rem;

            color: var(--sb-ai-primary);

            background:
                rgba(99,102,241,.09);
        }

        .sb-ai-empty p {
            max-width: 430px;

            margin: 0;

            color: var(--sb-ai-muted);
            line-height: 1.6;
        }


        /* =====================================================
           CAMERA LOADING
        ===================================================== */

        .sb-ai-cam-loading {
            position: absolute;
            inset: 0;

            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;

            z-index: 5;

            color: white;

            background:
                rgba(15,23,42,.74);

            backdrop-filter: blur(8px);
        }

        .sb-ai-cam-loading p {
            margin: 12px 0 0;

            color: rgba(255,255,255,.78);
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 991.98px) {

            .sb-ai-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .sb-ai-heading .btn {
                width: 100%;
            }

            .sb-ai-viewport,
            .sb-ai-viewport video {
                min-height: 380px;
            }

        }


        @media (max-width: 767.98px) {

            .sb-ai-card {
                padding: 16px;

                border-radius: 20px;
            }

            .sb-ai-heading {
                padding: 21px;

                border-radius: 20px;
            }

            .sb-ai-heading h1 {
                font-size: 1.8rem;
            }

            .sb-ai-privacy {
                padding: 14px;
            }

            .sb-ai-viewport,
            .sb-ai-viewport video {
                min-height: 330px;
            }

            .sb-ai-query-form {
                grid-template-columns: 1fr;
            }

            .sb-ai-query-form .btn {
                width: 100%;
            }

            .sb-ai-detection-grid,
            .sb-ai-analysis-grid {
                grid-template-columns: 1fr;
            }

            .sb-ai-actions {
                display: grid;

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .sb-ai-actions .btn {
                width: 100%;
            }

            .sb-ai-product-actions {
                align-items: flex-start;
                flex-direction: column;
            }

            .sb-ai-product-btn-group {
                width: 100%;

                justify-content: stretch;
            }

            .sb-ai-product-btn-group .btn,
            .sb-ai-product-btn-group form {
                flex: 1;
            }

            .sb-ai-product-btn-group .btn {
                width: 100%;
            }

        }


        @media (max-width: 480px) {

            .sb-ai-actions {
                grid-template-columns: 1fr;
            }

            .sb-ai-capture-tools {
                grid-template-columns: 1fr 1fr;
            }

            .sb-ai-viewport,
            .sb-ai-viewport video {
                min-height: 290px;
            }

        }

    </style>

</head>


<body>


<div class="ai-hub-layout sb-ai-page">


    {{-- =========================================================
         GLOBAL AI HUB
         SINGLE INSTANCE ONLY
    ========================================================== --}}

    @include('ai-hub.partials.navigation')


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <main class="ai-hub-main">


        {{-- =====================================================
             PREMIUM HEADER
        ====================================================== --}}

        <header class="ai-hub-heading ai-ca-heading sb-ai-heading">

            <div>

                <span class="ai-hub-eyebrow sb-ai-eyebrow">
                    FUTURE-READY AI
                </span>

                <h1>
                    AI Camera Assistant 📷
                </h1>

                <p>
                    Capture or upload an image and let Smart Basket
                    AI prepare intelligent product recommendations.
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


        {{-- =====================================================
             ALERTS
        ====================================================== --}}

        @if(session('success'))

            <div
                class="alert alert-success d-flex align-items-center"
                role="alert"
            >

                <i class="fa-solid fa-circle-check me-2"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif


        @if(session('error'))

            <div
                class="alert alert-danger d-flex align-items-center"
                role="alert"
            >

                <i class="fa-solid fa-circle-exclamation me-2"></i>

                <span>
                    {{ session('error') }}
                </span>

            </div>

        @endif


        @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Please fix the following:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =====================================================
             PRIVACY
        ====================================================== --}}

        <div class="ai-ca-privacy sb-ai-privacy">

            <i class="fa-solid fa-shield-halved"></i>

            <div>

                <strong>
                    Your privacy matters.
                </strong>

                <span>
                    Your image is processed only for AI analysis.
                    Smart Basket does not permanently save your
                    original image unless your AI Camera workflow
                    explicitly requires history storage.
                </span>

            </div>

        </div>


        {{-- =====================================================
             CAMERA + RESULTS
        ====================================================== --}}

        <div class="row g-4">


            {{-- =================================================
                 CAMERA
            ================================================== --}}

            <div class="col-lg-5">

                <section class="ai-ca-card ai-ca-camera-card sb-ai-card">


                    <div class="ai-ca-card-head sb-ai-card-head">

                        <span class="ai-ca-card-icon sb-ai-card-icon">

                            <i class="fa-solid fa-camera"></i>

                        </span>

                        <div>

                            <h2>
                                Camera Assistant
                            </h2>

                            <small>
                                Capture or upload an image
                            </small>

                        </div>

                    </div>


                    <div
                        class="ai-ca-alerts"
                        id="caAlerts"
                        aria-live="polite"
                    ></div>


                    <div
                        class="ai-ca-viewport sb-ai-viewport"
                        id="caViewport"
                    >

                        <video
                            id="caVideo"
                            autoplay
                            playsinline
                            muted
                        ></video>


                        <div
                            class="ai-ca-placeholder sb-ai-placeholder"
                            id="caPlaceholder"
                        >

                            <i class="fa-solid fa-camera"></i>

                            <p>
                                Start the camera or upload an image
                                to begin your AI experience.
                            </p>

                        </div>


                        <canvas
                            id="caCanvas"
                            class="d-none"
                        ></canvas>


                        <div
                            class="ai-ca-cam-loading sb-ai-cam-loading d-none"
                            id="caCamLoading"
                        >

                            <div class="ai-ca-loader sb-ai-loader">

                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>

                            </div>

                            <p>
                                Starting camera...
                            </p>

                        </div>

                    </div>


                    {{-- =================================================
                         PREVIEW
                    ================================================== --}}

                    <img
                        id="caUploadPreview"
                        class="ai-ca-upload-preview sb-ai-upload-preview"
                        alt="Selected image preview"
                    >


                    {{-- =================================================
                         FILE INPUT
                    ================================================== --}}

                    <input
                        type="file"
                        id="caFile"
                        name="product_image"
                        accept="image/jpeg,image/png,image/webp"
                        capture="environment"
                        class="d-none"
                    >


                    {{-- =================================================
                         CONTROLS
                    ================================================== --}}

                    <div class="ai-ca-capture-tools sb-ai-capture-tools">


                        <button
                            type="button"
                            class="btn btn-primary"
                            id="caStartBtn"
                        >

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


                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            id="caUploadBtn"
                        >

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


                    <div
                        class="ai-ca-cam-status sb-ai-cam-status"
                        id="caStatus"
                        aria-live="polite"
                    >
                        Camera is off.
                    </div>

                </section>

            </div>


            {{-- =================================================
                 RESULTS
            ================================================== --}}

            <div class="col-lg-7">

                <section class="ai-ca-card ai-ca-result-card sb-ai-card">


                    <div class="ai-ca-card-head sb-ai-card-head">

                        <span
                            class="ai-ca-card-icon
                                   ai-ca-icon-ai
                                   sb-ai-card-icon"
                        >

                            <i class="fa-solid fa-wand-magic-sparkles"></i>

                        </span>

                        <div>

                            <h2>
                                AI Style Analysis
                            </h2>

                            <small>
                                Smart product & style recommendations
                            </small>

                        </div>

                    </div>


                    {{-- =================================================
                         FORM
                    ================================================== --}}

                    <form
                        id="caAnalyzeForm"
                        class="ai-ca-query-form sb-ai-query-form"
                        method="POST"
                        action="{{ route('ai-camera.analyze') }}"
                        enctype="multipart/form-data"
                    >

                        @csrf


                        <input
                            type="file"
                            id="caAnalysisImage"
                            name="product_image"
                            accept="image/jpeg,image/png,image/webp"
                            class="d-none"
                        >


                        <input
                            type="text"
                            id="caQuery"
                            name="query"
                            class="form-control"
                            placeholder="Ask AI, e.g. best outfit suggest karo..."
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


                    {{-- =================================================
                         ACTIONS
                    ================================================== --}}

                    <div class="ai-ca-actions sb-ai-actions">


                        @if(Route::has('virtual-try-on'))

                            <button
                                type="button"
                                class="btn btn-info"
                                id="caVirtualTryOnBtn"
                                disabled
                            >

                                <i class="fa-solid fa-wand-magic-sparkles me-1"></i>

                                Virtual Try-On

                            </button>

                        @endif


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

                        @endif


                        <button
                            type="button"
                            class="btn btn-danger"
                            id="caResetBtn"
                        >

                            <i class="fa-solid fa-rotate-left me-1"></i>

                            Reset

                        </button>

                    </div>


                    {{-- =================================================
                         LOADING
                    ================================================== --}}

                    <div
                        class="ai-ca-loading sb-ai-loading d-none"
                        id="caLoading"
                    >

                        <div class="ai-ca-loader sb-ai-loader">

                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>

                        </div>

                        <p class="mb-1 fw-bold">
                            AI is analyzing your image...
                        </p>

                        <small>
                            Preparing intelligent recommendations
                        </small>

                    </div>


                    {{-- =================================================
                         RESULTS
                    ================================================== --}}

                    <div
                        id="caResults"
                        class="ai-ca-results"
                    >


                        @if(!empty($analysis))


                            {{-- DETECTION --}}

                            <div class="ai-ca-detection-grid sb-ai-detection-grid">


                                <div class="ai-ca-detection-item sb-ai-detection-item">

                                    <i class="fa-solid fa-hand"></i>

                                    <strong>
                                        Skin Tone
                                    </strong>

                                    <span class="ai-ca-detect-label sb-ai-detect-label">

                                        {{ ucfirst(
                                            $analysis['detection']['skin_tone']['label']
                                            ?? '—'
                                        ) }}

                                    </span>

                                    <small class="ai-ca-confidence sb-ai-confidence">

                                        Confidence:
                                        {{ $analysis['detection']['skin_tone']['confidence'] ?? '—' }}%

                                    </small>

                                </div>


                                <div class="ai-ca-detection-item sb-ai-detection-item">

                                    <i class="fa-solid fa-face-smile"></i>

                                    <strong>
                                        Face Shape
                                    </strong>

                                    <span class="ai-ca-detect-label sb-ai-detect-label">

                                        {{ ucfirst(
                                            $analysis['detection']['face_shape']['label']
                                            ?? '—'
                                        ) }}

                                    </span>

                                    <small class="ai-ca-confidence sb-ai-confidence">

                                        Confidence:
                                        {{ $analysis['detection']['face_shape']['confidence'] ?? '—' }}%

                                    </small>

                                </div>


                                <div class="ai-ca-detection-item sb-ai-detection-item">

                                    <i class="fa-solid fa-shirt"></i>

                                    <strong>
                                        Style
                                    </strong>

                                    <span class="ai-ca-detect-label sb-ai-detect-label">

                                        {{ ucfirst(
                                            $analysis['style_preference']['suggested_style']
                                            ?? '—'
                                        ) }}

                                    </span>

                                    <small class="ai-ca-confidence sb-ai-confidence">
                                        AI Recommendation
                                    </small>

                                </div>


                                <div class="ai-ca-detection-item sb-ai-detection-item">

                                    <i class="fa-solid fa-palette"></i>

                                    <strong>
                                        Color
                                    </strong>

                                    <span class="ai-ca-detect-label sb-ai-detect-label">

                                        {{ ucfirst(
                                            $analysis['color_matching']['color_category']
                                            ?? '—'
                                        ) }}

                                    </span>

                                    <small class="ai-ca-confidence sb-ai-confidence">
                                        Color Matching
                                    </small>

                                </div>

                            </div>


                            {{-- ANALYSIS DETAILS --}}

                            <div class="ai-ca-analysis-grid sb-ai-analysis-grid">


                                <div class="ai-ca-analysis-item sb-ai-analysis-item">

                                    <i class="fa-solid fa-face-smile"></i>

                                    <strong>
                                        Face Features
                                    </strong>

                                    <span>

                                        {{
                                            $analysis['face_features']['skin_tone']
                                            ?? '—'
                                        }}

                                        ·

                                        {{
                                            $analysis['face_features']['tone']
                                            ?? '—'
                                        }}

                                    </span>

                                </div>


                                <div class="ai-ca-analysis-item sb-ai-analysis-item">

                                    <i class="fa-solid fa-person"></i>

                                    <strong>
                                        Body Appearance
                                    </strong>

                                    <span>

                                        {{
                                            ucfirst(
                                                $analysis['body_appearance']['frame']
                                                ?? 'balanced'
                                            )
                                        }}

                                        frame

                                    </span>

                                </div>


                                <div class="ai-ca-analysis-item sb-ai-analysis-item">

                                    <i class="fa-solid fa-shirt"></i>

                                    <strong>
                                        Style Preference
                                    </strong>

                                    <span>

                                        {{
                                            ucfirst(
                                                $analysis['style_preference']['suggested_style']
                                                ?? 'casual'
                                            )
                                        }}

                                        ·

                                        {{
                                            $analysis['style_preference']['fit']
                                            ?? 'regular'
                                        }}

                                        fit

                                    </span>

                                </div>


                                <div class="ai-ca-analysis-item sb-ai-analysis-item">

                                    <i class="fa-solid fa-palette"></i>

                                    <strong>
                                        Color Matching
                                    </strong>

                                    <span>

                                        {{
                                            ucfirst(
                                                $analysis['color_matching']['color_category']
                                                ?? 'neutral'
                                            )
                                        }}

                                        tones

                                    </span>

                                </div>

                            </div>


                            {{-- COLORS --}}

                            @if(
                                collect(
                                    $analysis['color_matching']['suitable_colors']
                                    ?? []
                                )->isNotEmpty()
                            )

                                <div class="ai-ca-color-section sb-ai-color-section">

                                    <h4>

                                        <i class="fa-solid fa-palette me-1"></i>

                                        Suitable Colors

                                    </h4>

                                    <div class="ai-ca-color-chips sb-ai-color-chips">

                                        @foreach(
                                            $analysis['color_matching']['suitable_colors']
                                            as $color
                                        )

                                            <span class="ai-ca-color-chip sb-ai-color-chip">
                                                {{ $color }}
                                            </span>

                                        @endforeach

                                    </div>

                                </div>

                            @endif


                            {{-- FASHION --}}

                            @if(
                                collect(
                                    $analysis['fashion_recommendations']['outfit_ideas']
                                    ?? []
                                )->isNotEmpty()
                            )

                                <div class="ai-ca-fashion-section sb-ai-fashion-section">

                                    <h4>

                                        <i class="fa-solid fa-shirt me-1"></i>

                                        Fashion Recommendations

                                    </h4>

                                    <ul class="ai-ca-fashion-list sb-ai-fashion-list">

                                        @foreach(
                                            $analysis['fashion_recommendations']['outfit_ideas']
                                            as $idea
                                        )

                                            <li>
                                                {{ $idea }}
                                            </li>

                                        @endforeach

                                    </ul>

                                </div>

                            @endif


                            {{-- SUMMARY --}}

                            @if(!empty($analysis['summary']))

                                <p class="ai-ca-summary sb-ai-summary">

                                    {{ $analysis['summary'] }}

                                </p>

                            @endif


                        @else


                            {{-- EMPTY --}}

                            <div class="ai-ca-empty sb-ai-empty">

                                <i class="fa-solid fa-sparkles"></i>

                                <p>

                                    Capture or upload an image to get
                                    AI-powered shopping recommendations.

                                </p>

                            </div>

                        @endif


                        {{-- =================================================
                             RECOMMENDED PRODUCTS
                        ================================================== --}}

                        @if(
                            isset($recommendations)
                            && $recommendations->isNotEmpty()
                        )

                            <h3 class="ai-ca-section-title sb-ai-section-title">

                                <i class="fa-solid fa-bag-shopping"></i>

                                Recommended For You

                            </h3>


                            <div class="ai-ca-products sb-ai-products">

                                @foreach($recommendations as $item)

                                    @php

                                        $product =
                                            is_array($item)
                                                ? ($item['product'] ?? null)
                                                : $item;

                                    @endphp


                                    @if($product)

                                        <article class="ai-ca-product sb-ai-product">


                                            <img
                                                src="{{ asset(
                                                    'products/' . $product->image
                                                ) }}"
                                                alt="{{ $product->name }}"
                                                loading="lazy"
                                            >


                                            <div class="ai-ca-product-body sb-ai-product-body">

                                                <h4>
                                                    {{ $product->name }}
                                                </h4>

                                                <p>

                                                    {{
                                                        $product->category
                                                        ?: 'Smart Basket product'
                                                    }}

                                                    ·

                                                    <span class="text-warning">
                                                        ★
                                                    </span>

                                                    {{
                                                        number_format(
                                                            (float) (
                                                                $product->rating ?? 0
                                                            ),
                                                            1
                                                        )
                                                    }}

                                                </p>


                                                @if(
                                                    is_array($item)
                                                    && !empty($item['reasons'])
                                                )

                                                    <small class="ai-ca-reason sb-ai-reason">

                                                        {{
                                                            collect(
                                                                $item['reasons']
                                                            )->implode(' · ')
                                                        }}

                                                    </small>

                                                @endif

                                            </div>


                                            <div class="ai-ca-product-actions sb-ai-product-actions">

                                                <span class="ai-ca-price sb-ai-price">

                                                    ₹{{
                                                        number_format(
                                                            (float) $product->price,
                                                            2
                                                        )
                                                    }}

                                                </span>


                                                <div
                                                    class="ai-ca-product-btn-group
                                                           sb-ai-product-btn-group"
                                                >


                                                    @if(Route::has('cart.add'))

                                                        <form
                                                            action="{{
                                                                route(
                                                                    'cart.add',
                                                                    $product->id
                                                                )
                                                            }}"
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
                                                            href="{{
                                                                route(
                                                                    'products.show',
                                                                    $product->id
                                                                )
                                                            }}"
                                                            class="btn btn-sm btn-primary"
                                                        >

                                                            <i class="fa-solid fa-eye me-1"></i>

                                                            View Product

                                                        </a>

                                                    @endif

                                                </div>

                                            </div>

                                        </article>

                                    @endif

                                @endforeach

                            </div>

                        @endif

                    </div>

                </section>

            </div>

        </div>

    </main>

</div>


{{-- =========================================================
     AI CAMERA JAVASCRIPT
     GLOBAL AI HUB JS IS NOT DUPLICATED.
========================================================= --}}

<script
    src="{{ asset('js/ai-camera-assistant.js') }}"
    defer
></script>


{{-- =========================================================
     IMAGE PREVIEW + CAMERA FALLBACK
========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const fileInput =
        document.getElementById('caFile');

    const preview =
        document.getElementById('caUploadPreview');

    const analysisImage =
        document.getElementById('caAnalysisImage');

    const uploadButton =
        document.getElementById('caUploadBtn');


    if (!fileInput) {
        return;
    }


    fileInput.addEventListener('change', function () {

        const file =
            this.files && this.files[0];

        if (!file) {
            return;
        }


        if (!file.type.startsWith('image/')) {

            alert('Please select a valid image.');

            this.value = '';

            return;
        }


        if (file.size > 5 * 1024 * 1024) {

            alert('Image size must be 5 MB or less.');

            this.value = '';

            return;
        }


        const objectUrl =
            URL.createObjectURL(file);


        if (preview) {

            preview.src =
                objectUrl;

            preview.style.display =
                'block';

        }


        if (analysisImage) {

            const dataTransfer =
                new DataTransfer();

            dataTransfer.items.add(file);

            analysisImage.files =
                dataTransfer.files;

        }

    });


    if (uploadButton) {

        uploadButton.addEventListener('click', function () {

            fileInput.click();

        });

    }

});

</script>


@stack('scripts')


</body>

</html>