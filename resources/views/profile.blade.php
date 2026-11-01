<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>My Profile | SMART BASKET</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet"
    >

    <style>
        :root {
            --bg: #f5f7fb;
            --card: rgba(255,255,255,.90);
            --solid: #ffffff;
            --text: #111827;
            --muted: #64748b;
            --border: rgba(15,23,42,.08);
            --input: #ffffff;
            --input-border: #dbe3ef;
            --primary: #2563eb;
            --purple: #7c3aed;
            --gold: #b8860b;
            --gold2: #e4bd50;
            --green: #16a34a;
            --red: #dc2626;
            --shadow: 0 25px 70px rgba(15,23,42,.10);
        }

        html[data-theme="dark"] {
            --bg: #020617;
            --card: rgba(15,23,42,.88);
            --solid: #0f172a;
            --text: #f8fafc;
            --muted: #94a3b8;
            --border: rgba(255,255,255,.09);
            --input: #111c31;
            --input-border: rgba(255,255,255,.12);
            --primary: #3b82f6;
            --purple: #8b5cf6;
            --gold: #d2a93b;
            --gold2: #f0cc64;
            --green: #22c55e;
            --red: #ef4444;
            --shadow: 0 30px 90px rgba(0,0,0,.48);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
            color: var(--text);

            background:
                radial-gradient(
                    circle at 5% 5%,
                    rgba(37,99,235,.13),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 95% 10%,
                    rgba(124,58,237,.12),
                    transparent 28%
                ),
                var(--bg);

            transition:
                background .35s ease,
                color .35s ease;
        }

        /* =====================================================
           MAIN
        ===================================================== */

        .page {
            min-height: 100vh;
            padding: 35px 18px 100px;
        }

        .container-premium {
            width: 100%;
            max-width: none;
            margin: 0;
        }

        /* =====================================================
           ALERT
        ===================================================== */

        .alert-premium {
            border: 1px solid var(--border);
            border-radius: 17px;
            background: var(--card);
            color: var(--text);
            padding: 15px 18px;
            margin-bottom: 22px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(18px);
        }

        .alert-premium ul {
            padding-left: 20px;
        }

        /* =====================================================
           CARDS
        ===================================================== */

        .card-premium {
            position: relative;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 27px;
            background: var(--card);
            box-shadow: var(--shadow);
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            transition:
                transform .3s ease,
                box-shadow .3s ease;
        }

        .card-premium::before {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            top: -120px;
            right: -100px;
            border-radius: 50%;
            background:
                radial-gradient(
                    circle,
                    rgba(59,130,246,.13),
                    transparent 70%
                );
            pointer-events: none;
        }

        .card-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 32px 80px rgba(15,23,42,.14);
        }

        /* =====================================================
           PROFILE HERO
        ===================================================== */

        .profile-hero {
            text-align: center;
            padding: 32px 20px 25px;
            position: relative;
            z-index: 2;
        }

        .avatar-zone {
            position: relative;
            width: 152px;
            height: 152px;
            margin: 0 auto 18px;
        }

        .avatar-ring {
            position: absolute;
            inset: 0;
            padding: 3px;
            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    #8b6508,
                    #c49a28,
                    #f1d778,
                    #b8860b,
                    #8b6508
                );

            box-shadow:
                0 8px 25px rgba(139,101,8,.22);

            z-index: 1;
        }

        .avatar-inner {
            width: 100%;
            height: 100%;
            padding: 3px;
            border-radius: 50%;
            background: var(--solid);
        }

        .avatar,
        .avatar-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            overflow: hidden;
        }

        .avatar {
            object-fit: cover;
        }

        .avatar-placeholder {
            color: white;
            font-size: 50px;
            font-weight: 900;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--purple)
                );
        }

        .online {
            position: absolute;
            width: 20px;
            height: 20px;
            right: 5px;
            bottom: 9px;
            border-radius: 50%;
            background: #22c55e;
            border: 4px solid var(--solid);
            z-index: 8;
            box-shadow:
                0 0 0 3px rgba(34,197,94,.16);
        }

        /* =====================================================
           CELEBRATION
        ===================================================== */

        .celebration-stars {
            position: absolute;
            inset: -35px;
            pointer-events: none;
            z-index: 10;
            opacity: 0;
        }

        .profile-complete .celebration-stars {
            opacity: 1;
        }

        .star {
            position: absolute;
            color: #f5c542;
            font-size: 14px;

            filter:
                drop-shadow(
                    0 0 8px
                    rgba(245,197,66,.8)
                );

            animation:
                starCelebrate
                2.8s
                ease-out
                infinite;
        }

        .star:nth-child(1) {
            left: 50%;
            top: 0;
            animation-delay: .1s;
        }

        .star:nth-child(2) {
            right: 7%;
            top: 25%;
            animation-delay: .35s;
        }

        .star:nth-child(3) {
            right: 12%;
            bottom: 13%;
            animation-delay: .6s;
        }

        .star:nth-child(4) {
            left: 15%;
            bottom: 8%;
            animation-delay: .85s;
        }

        .star:nth-child(5) {
            left: 0;
            top: 28%;
            animation-delay: 1.1s;
        }

        .star:nth-child(6) {
            left: 25%;
            top: 5%;
            animation-delay: 1.35s;
        }

        .star:nth-child(7) {
            right: 24%;
            top: 3%;
            animation-delay: 1.6s;
        }

        .star:nth-child(8) {
            left: 7%;
            bottom: 27%;
            animation-delay: 1.85s;
        }

        @keyframes starCelebrate {
            0% {
                opacity: 0;
                transform:
                    scale(.2)
                    rotate(0deg)
                    translateY(10px);
            }

            20% {
                opacity: 1;
                transform:
                    scale(1.35)
                    rotate(45deg);
            }

            50% {
                opacity: 1;
                transform:
                    scale(.85)
                    rotate(120deg);
            }

            80% {
                opacity: .7;
                transform:
                    scale(1.15)
                    rotate(220deg)
                    translateY(-8px);
            }

            100% {
                opacity: 0;
                transform:
                    scale(.2)
                    rotate(360deg)
                    translateY(-20px);
            }
        }

        .profile-complete .avatar-ring {
            animation:
                premiumRing
                1.8s
                ease-in-out
                infinite;
        }

        @keyframes premiumRing {
            0%,100% {
                box-shadow:
                    0 8px 25px
                    rgba(139,101,8,.22);
            }

            50% {
                box-shadow:
                    0 0 0 6px
                    rgba(228,189,80,.10),
                    0 0 30px
                    rgba(228,189,80,.55),
                    0 10px 35px
                    rgba(139,101,8,.35);
            }
        }

        .completion-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 13px;
            padding: 7px 13px;
            border-radius: 999px;

            color: var(--gold);

            background:
                rgba(212,175,55,.10);

            border:
                1px solid
                rgba(212,175,55,.25);

            font-size: 12px;
            font-weight: 850;
        }

        .completion-badge.complete {
            color: #a87900;

            background:
                linear-gradient(
                    135deg,
                    rgba(245,197,66,.16),
                    rgba(255,224,120,.09)
                );

            border-color:
                rgba(212,175,55,.40);

            box-shadow:
                0 0 25px
                rgba(212,175,55,.13);
        }

        html[data-theme="dark"] .completion-badge.complete {
            color: #f0cc64;
        }

        /* =====================================================
           COMPLETION
        ===================================================== */

        .completion-box {
            margin: 0 20px 24px;
            padding: 17px;
            border-radius: 18px;

            background:
                rgba(37,99,235,.06);

            border:
                1px solid
                rgba(37,99,235,.12);
        }

        .completion-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 9px;
        }

        .completion-title {
            font-size: 13px;
            font-weight: 850;
        }

        .completion-percent {
            font-size: 15px;
            font-weight: 950;
            color: var(--primary);
        }

        .progress {
            height: 9px;
            border-radius: 999px;
            background: rgba(100,116,139,.13);
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 999px;

            background:
                linear-gradient(
                    90deg,
                    var(--primary),
                    var(--purple)
                );

            transition:
                width .8s
                cubic-bezier(.2,.8,.2,1);
        }

        .profile-complete .progress-bar {
            background:
                linear-gradient(
                    90deg,
                    #b8860b,
                    #e8c85c,
                    #b8860b
                );

            background-size: 200% 100%;

            animation:
                goldMove
                2s
                linear
                infinite;
        }

        @keyframes goldMove {
            from {
                background-position: 0 0;
            }

            to {
                background-position: 200% 0;
            }
        }

        /* =====================================================
           SECTION
        ===================================================== */

        .section {
            padding: 25px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 20px;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            color: var(--primary);
            background: rgba(37,99,235,.08);
        }

        .section-title h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 900;
        }

        .section-title p {
            margin: 2px 0 0;
            color: var(--muted);
            font-size: 12px;
        }

        /* =====================================================
           FORM
        ===================================================== */

        .form-label {
            color: var(--text);
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .form-control,
        .form-select {
            min-height: 49px;
            color: var(--text) !important;
            background: var(--input) !important;

            border:
                1px solid
                var(--input-border) !important;

            border-radius: 13px !important;

            box-shadow: none !important;
            transition: .2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color:
                var(--primary) !important;

            box-shadow:
                0 0 0 4px
                rgba(37,99,235,.10)
                !important;
        }

        textarea.form-control {
            min-height: 105px;
        }

        .form-select option {
            color: #111827;
            background: #ffffff;
        }

        html[data-theme="dark"] .form-select option {
            color: #ffffff;
            background: #0f172a;
        }

        /* =====================================================
           PASSWORD FIX
        ===================================================== */

        .password-box {
            position: relative;
        }

        .password-input-wrap {
            position: relative;
        }

        .password-input-wrap .form-control {
            padding-right: 52px;
        }

        .password-eye {
            position: absolute;
            top: 50%;
            right: 12px;

            width: 34px;
            height: 34px;

            transform: translateY(-50%);

            display: flex;
            align-items: center;
            justify-content: center;

            border: 0;
            border-radius: 9px;

            color: var(--muted);
            background: transparent;

            cursor: pointer;
        }

        .password-eye:hover {
            color: var(--primary);
            background: rgba(37,99,235,.08);
        }

        .password-match-message {
            display: none;
            margin-top: 7px;
            font-size: 11px;
            font-weight: 800;
        }

        .password-match-message.match {
            display: block;
            color: #16a34a;
        }

        .password-match-message.mismatch {
            display: block;
            color: #dc2626;
        }

        .password-help {
            margin-top: 7px;
            color: var(--muted);
            font-size: 11px;
        }

        .password-error-border {
            border-color: #dc2626 !important;
            box-shadow:
                0 0 0 4px
                rgba(220,38,38,.08) !important;
        }

        .password-success-border {
            border-color: #16a34a !important;
            box-shadow:
                0 0 0 4px
                rgba(22,163,74,.08) !important;
        }

        /* =====================================================
           IMAGE
        ===================================================== */

        .image-upload {
            border:
                1px dashed
                rgba(37,99,235,.30);

            border-radius: 17px;
            padding: 15px;
            background: rgba(37,99,235,.035);
            transition: .25s ease;
        }

        .image-upload:hover {
            border-color: var(--primary);
            background: rgba(37,99,235,.06);
        }

        .upload-row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .choose-btn {
            position: relative;

            display: inline-flex;
            align-items: center;
            gap: 8px;

            min-height: 44px;
            padding: 0 16px;

            border-radius: 12px;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--purple)
                );

            font-weight: 800;
            cursor: pointer;

            box-shadow:
                0 10px 24px
                rgba(37,99,235,.20);
        }

        .choose-btn input {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .image-info {
            color: var(--muted);
            font-size: 11px;
        }

        .image-preview {
            display: none;
            margin-top: 13px;
            width: 100%;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .image-preview img {
            width: 100%;
            max-height: 220px;
            object-fit: contain;
            background: rgba(0,0,0,.04);
        }

        /* =====================================================
           BUTTONS
        ===================================================== */

        .save-button {
            min-height: 51px;
            padding: 0 24px;
            border: 0;
            border-radius: 14px;
            color: white;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--purple)
                );

            font-weight: 850;

            box-shadow:
                0 12px 30px
                rgba(37,99,235,.23);

            transition: .25s ease;
        }

        .save-button:hover {
            color: white;
            transform: translateY(-2px);

            box-shadow:
                0 18px 38px
                rgba(37,99,235,.32);
        }

        .save-button:disabled {
            opacity: .65;
            cursor: not-allowed;
            transform: none;
        }

        .back-button {
            min-height: 51px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 0 20px;

            border-radius: 14px;

            border:
                1px solid
                var(--border);

            color: var(--text);
            text-decoration: none;
            font-weight: 750;
        }

        /* =====================================================
           SECURITY
        ===================================================== */

        .security {
            padding: 16px;
            border-radius: 17px;
            margin-bottom: 20px;
        }

        .security.enabled {
            background: rgba(34,197,94,.08);
            border: 1px solid rgba(34,197,94,.18);
        }

        .security.disabled {
            background: rgba(245,158,11,.08);
            border: 1px solid rgba(245,158,11,.18);
        }

        .security-icon {
            width: 42px;
            height: 42px;

            border-radius: 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 17px;
        }

        .security.enabled .security-icon {
            color: #22c55e;
            background: rgba(34,197,94,.12);
        }

        .security.disabled .security-icon {
            color: #f59e0b;
            background: rgba(245,158,11,.12);
        }

        /* =====================================================
           ORDERS
        ===================================================== */

        .orders {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 17px;
            scroll-margin-top: 90px;
        }

        #ordersSection {
            scroll-margin-top: 90px;
        }

        .orders-highlight {
            animation:
                ordersHighlight
                1.4s
                ease;
        }

        @keyframes ordersHighlight {
            0% {
                box-shadow:
                    0 0 0 0
                    rgba(37,99,235,.0);
            }

            35% {
                box-shadow:
                    0 0 0 7px
                    rgba(37,99,235,.16);
            }

            100% {
                box-shadow:
                    0 0 0 0
                    rgba(37,99,235,.0);
            }
        }

        .table {
            margin: 0;
            color: var(--text) !important;
        }

        .table > :not(caption) > * > * {
            color: var(--text) !important;
            background: transparent !important;
            border-color: var(--border) !important;
            padding: 14px;
        }

        .order-id {
            color: var(--primary);
            font-weight: 850;
        }

        .status {
            display: inline-flex;
            padding: 6px 10px;
            border-radius: 999px;
            color: var(--primary);
            background: rgba(37,99,235,.08);
            font-size: 11px;
            font-weight: 850;
        }

        .empty {
            text-align: center;
            padding: 35px;
            color: var(--muted);
        }

        .empty i {
            display: block;
            font-size: 40px;
            margin-bottom: 10px;
            opacity: .5;
        }

        /* =====================================================
           LOGOUT
        ===================================================== */

        .logout {
            width: 100%;
            min-height: 52px;
            margin-top: 24px;
            border-radius: 15px;

            border:
                1px solid
                rgba(239,68,68,.20);

            color: var(--red);
            background: rgba(239,68,68,.06);

            font-weight: 850;
            transition: .25s ease;
        }

        .logout:hover {
            color: white;
            background: var(--red);
            transform: translateY(-2px);
        }

        /* =====================================================
           COMPLETE MESSAGE
        ===================================================== */

        .complete-message {
            display: none;
            margin: 0 20px 20px;
            padding: 13px;
            text-align: center;
            border-radius: 15px;

            color: #9a7100;

            background:
                linear-gradient(
                    135deg,
                    rgba(245,197,66,.15),
                    rgba(255,231,140,.08)
                );

            border:
                1px solid
                rgba(212,175,55,.25);

            font-size: 12px;
            font-weight: 850;
        }

        .profile-complete .complete-message {
            display: block;
            animation: messagePop .7s ease both;
        }

        @keyframes messagePop {
            from {
                opacity: 0;
                transform:
                    translateY(8px)
                    scale(.97);
            }

            to {
                opacity: 1;
                transform:
                    translateY(0)
                    scale(1);
            }
        }

        /* =====================================================
           CUSTOMER TASKBAR
        ===================================================== */



        html[data-theme="dark"],
        html[data-sb-theme="dark"] {
            --sb-tbar-bg: rgba(5,11,22,.94);
            --sb-tbar-panel: #0b1728;
            --sb-tbar-text: #f7fbff;
            --sb-tbar-muted: #9aacbf;
            --sb-tbar-border: rgba(101,165,255,.20);
            --sb-tbar-blue: #65a5ff;
            --sb-tbar-blue2: #8b7cff;
            --sb-tbar-soft: rgba(37,99,235,.16);
            --sb-tbar-shadow: 0 20px 60px rgba(0,0,0,.42);
        }































































































        .ai-hub-fab {
            z-index: 99980 !important;
        }

        .ai-hub-drawer {
            z-index: 99999 !important;
        }

        html[data-theme="light"] .ai-hub-drawer {
            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.99),
                    rgba(242,246,252,.99)
                ) !important;

            color: #101828 !important;

            border-right-color:
                rgba(37,99,235,.14) !important;

            box-shadow:
                24px 0 70px
                rgba(15,23,42,.20) !important;
        }

        html[data-theme="light"] .ai-hub-drawer-header strong,
        html[data-theme="light"] .ai-hub-tool-text strong {
            color: #101828 !important;
        }

        html[data-theme="light"] .ai-hub-drawer-header small,
        html[data-theme="light"] .ai-hub-tool-text small {
            color: #667085 !important;
        }

        html[data-theme="light"] .ai-hub-fab {
            background:
                linear-gradient(
                    145deg,
                    #fff,
                    #eef4ff
                ) !important;

            color: #172033 !important;
            border-color: rgba(37,99,235,.25) !important;
        }

        html[data-theme="dark"] .ai-hub-drawer {
            background:
                linear-gradient(
                    145deg,
                    #09111f,
                    #020711
                ) !important;
        }

        html[data-theme="dark"] .ai-hub-fab {
            background:
                linear-gradient(
                    145deg,
                    #1e293b,
                    #050a14
                ) !important;
        }





        /* =====================================================
           MOBILE
        ===================================================== */





        @media (max-width: 700px) {
            .page {
                padding: 22px 10px 70px;
            }



















            .topbar {
                flex-direction: column;
                align-items: stretch;
                padding-right: 0;
            }

            .save-button,
            .back-button {
                width: 100%;
            }

            .table {
                min-width: 600px;
            }

            .section {
                padding: 20px 17px;
            }

            .card-premium {
                border-radius: 22px;
            }

            .avatar-zone {
                width: 135px;
                height: 135px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/customer-page-title.css') }}">
</head>

@php
    /*
    |--------------------------------------------------------------------------
    | THEME
    |--------------------------------------------------------------------------
    */

    $theme = auth()->user()->dark_mode ?? 'light';

    if (!in_array($theme, ['light', 'dark', 'system'], true)) {
        $theme = 'light';
    }

    /*
    |--------------------------------------------------------------------------
    | LANGUAGE OPTIONS
    |--------------------------------------------------------------------------
    */

    $localeConfig = config('locales', []);

    if (is_array($localeConfig) && count($localeConfig) > 0) {
        $languages = $localeConfig;
    } else {
        $languages = [
            'en' => 'English',
            'hi' => 'Hindi',
            'gu' => 'Gujarati',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | PROFILE COMPLETION
    |--------------------------------------------------------------------------
    */

    $profileFields = [
        'name' => $user->name,
        'username' => $user->username,
        'email' => $user->email,
        'phone' => $user->phone,
        'date_of_birth' => $user->date_of_birth,
        'gender' => $user->gender,
        'address' => $user->address,
        'house_no' => $user->house_no,
        'street' => $user->street,
        'area' => $user->area,
        'landmark' => $user->landmark,
        'city' => $user->city,
        'state' => $user->state,
        'country' => $user->country,
        'pin_code' => $user->pin_code,
        'language' => $user->language,
        'profile_image' => $user->profile_image,
    ];

    $filledFields = collect($profileFields)
        ->filter(function ($value) {
            return filled($value);
        })
        ->count();

    $totalFields = count($profileFields);

    $completion = $totalFields > 0
        ? (int) round(($filledFields / $totalFields) * 100)
        : 0;
@endphp

<body>

@auth

@php
    $currentRoute = request()->route()?->getName();

    $ordersRoute = Route::has('orders.index')
        ? 'orders.index'
        : (Route::has('orders') ? 'orders' : null);
@endphp

{{-- =========================================================
     CUSTOMER TASKBAR
========================================================= --}}

<x-products-customer-taskbar :include-robot="false" />

@endauth


<div class="page">

    <div class="container-premium">

        {{-- SUCCESS --}}

        @if(session('success'))

            <div class="alert-premium">

                <i class="fa-solid fa-circle-check text-success me-2"></i>

                {{ session('success') }}

            </div>

        @endif


        {{-- ERRORS --}}

        @if($errors->any())

            <div class="alert-premium">

                <strong class="text-danger">

                    <i class="fa-solid fa-circle-exclamation me-2"></i>

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


        <x-customer-page-hero title="My Profile" />

        <div class="row g-4">


            {{-- =================================================
                 LEFT
            ================================================= --}}

            <div class="col-lg-4">

                <div
                    class="card-premium {{ $completion >= 100 ? 'profile-complete' : '' }}"
                    id="profileCard"
                >

                    {{-- PROFILE HERO --}}

                    <div
                        class="profile-hero"
                        id="profileHero"
                    >

                        <div class="avatar-zone">

                            <div class="celebration-stars">

                                <span class="star">★</span>
                                <span class="star">✦</span>
                                <span class="star">★</span>
                                <span class="star">✦</span>
                                <span class="star">★</span>
                                <span class="star">✦</span>
                                <span class="star">★</span>
                                <span class="star">✦</span>

                            </div>

                            <div class="avatar-ring">

                                <div class="avatar-inner">

                                    @if($user->profile_image)

                                        <img
                                            src="{{ asset('storage/profile/'.$user->profile_image) }}"
                                            class="avatar"
                                            alt="Profile"
                                        >

                                    @else

                                        <div class="avatar-placeholder">
                                            {{ strtoupper(substr($user->name ?: 'U', 0, 1)) }}
                                        </div>

                                    @endif

                                </div>

                            </div>

                            <span class="online"></span>

                        </div>

                        <div class="fw-black fs-4">
                            {{ $user->name }}
                        </div>

                        <div
                            style="
                                color:var(--muted);
                                font-size:13px;
                                margin-top:4px;
                            "
                        >
                            {{ $user->email }}
                        </div>

                        <div
                            class="completion-badge {{ $completion >= 100 ? 'complete' : '' }}"
                        >

                            @if($completion >= 100)

                                <i class="fa-solid fa-star"></i>

                                Profile 100% Complete

                            @else

                                <i class="fa-solid fa-shield-halved"></i>

                                Account Protected

                            @endif

                        </div>

                    </div>


                    {{-- COMPLETION --}}

                    <div class="completion-box">

                        <div class="completion-top">

                            <span class="completion-title">
                                Profile Completion
                            </span>

                            <span
                                class="completion-percent"
                                id="completionPercent"
                            >
                                {{ $completion }}%
                            </span>

                        </div>

                        <div class="progress">

                            <div
                                id="completionBar"
                                class="progress-bar"
                                role="progressbar"
                                style="width:{{ $completion }}%"
                            ></div>

                        </div>

                        <div
                            style="
                                color:var(--muted);
                                font-size:11px;
                                margin-top:8px;
                            "
                            id="completionText"
                        >

                            @if($completion >= 100)
                                🎉 Everything looks perfect!
                            @else
                                Complete all details to reach 100%.
                            @endif

                        </div>

                    </div>


                    <div class="complete-message">

                        <i class="fa-solid fa-crown me-1"></i>

                        🎉 Congratulations! Your SMART BASKET profile
                        is completely filled.

                    </div>


                    {{-- =================================================
                         PROFILE FORM
                    ================================================= --}}

                    <form
                        action="{{ route('profile.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        id="profileForm"
                        autocomplete="off"
                        novalidate
                    >

                        @csrf

                        <div class="section">

                            {{-- PERSONAL --}}

                            <div class="section-title">

                                <div class="section-icon">
                                    <i class="fa-solid fa-id-card"></i>
                                </div>

                                <div>

                                    <h2>
                                        Personal Details
                                    </h2>

                                    <p>
                                        Keep your information updated
                                    </p>

                                </div>

                            </div>


                            {{-- PROFILE IMAGE --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Profile Photo
                                </label>

                                <div class="image-upload">

                                    <div class="upload-row">

                                        <label class="choose-btn">

                                            <i class="fa-solid fa-camera"></i>

                                            Choose Photo

                                            <input
                                                type="file"
                                                name="profile_image"
                                                id="profileImage"
                                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                                autocomplete="off"
                                            >

                                        </label>

                                        <span
                                            class="image-info"
                                            id="imageInfo"
                                        >
                                            JPG, PNG, WEBP • Max 2 MB
                                        </span>

                                    </div>

                                    <div
                                        class="image-preview"
                                        id="imagePreview"
                                    >

                                        <img
                                            id="previewImage"
                                            alt="Preview"
                                        >

                                    </div>

                                </div>

                            </div>


                            {{-- NAME --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="form-control profile-input"
                                    value="{{ old('name', $user->name) }}"
                                    autocomplete="name"
                                    required
                                >

                            </div>


                            {{-- USERNAME --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Username
                                </label>

                                <input
                                    type="text"
                                    name="username"
                                    class="form-control profile-input"
                                    value="{{ old('username', $user->username) }}"
                                    autocomplete="username"
                                >

                            </div>


                            {{-- EMAIL --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control profile-input"
                                    value="{{ old('email', $user->email) }}"
                                    autocomplete="email"
                                    required
                                >

                            </div>


                            {{-- PHONE --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Phone
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control profile-input"
                                    value="{{ old('phone', $user->phone) }}"
                                    autocomplete="tel"
                                >

                            </div>


                            {{-- DOB / GENDER --}}

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Date Of Birth
                                    </label>

                                    <input
                                        type="date"
                                        name="date_of_birth"
                                        class="form-control profile-input"
                                        value="{{ old('date_of_birth', $user->date_of_birth) }}"
                                        autocomplete="bday"
                                    >

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Gender
                                    </label>

                                    <select
                                        name="gender"
                                        class="form-select profile-input"
                                    >

                                        <option value="">
                                            Select
                                        </option>

                                        <option
                                            value="Male"
                                            @selected(old('gender', $user->gender) === 'Male')
                                        >
                                            Male
                                        </option>

                                        <option
                                            value="Female"
                                            @selected(old('gender', $user->gender) === 'Female')
                                        >
                                            Female
                                        </option>

                                        <option
                                            value="Other"
                                            @selected(old('gender', $user->gender) === 'Other')
                                        >
                                            Other
                                        </option>

                                    </select>

                                </div>

                            </div>


                            {{-- ADDRESS --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Address
                                </label>

                                <textarea
                                    name="address"
                                    class="form-control profile-input"
                                    rows="3"
                                >{{ old('address', $user->address) }}</textarea>

                            </div>


                            {{-- HOUSE / STREET --}}

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        House No
                                    </label>

                                    <input
                                        type="text"
                                        name="house_no"
                                        class="form-control profile-input"
                                        value="{{ old('house_no', $user->house_no) }}"
                                    >

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Street
                                    </label>

                                    <input
                                        type="text"
                                        name="street"
                                        class="form-control profile-input"
                                        value="{{ old('street', $user->street) }}"
                                    >

                                </div>

                            </div>


                            {{-- AREA / LANDMARK --}}

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Area
                                    </label>

                                    <input
                                        type="text"
                                        name="area"
                                        class="form-control profile-input"
                                        value="{{ old('area', $user->area) }}"
                                    >

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Landmark
                                    </label>

                                    <input
                                        type="text"
                                        name="landmark"
                                        class="form-control profile-input"
                                        value="{{ old('landmark', $user->landmark) }}"
                                    >

                                </div>

                            </div>


                            {{-- CITY / STATE --}}

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        City
                                    </label>

                                    <input
                                        type="text"
                                        name="city"
                                        class="form-control profile-input"
                                        value="{{ old('city', $user->city) }}"
                                    >

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        State
                                    </label>

                                    <input
                                        type="text"
                                        name="state"
                                        class="form-control profile-input"
                                        value="{{ old('state', $user->state) }}"
                                    >

                                </div>

                            </div>


                            {{-- COUNTRY / PIN --}}

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Country
                                    </label>

                                    <input
                                        type="text"
                                        name="country"
                                        class="form-control profile-input"
                                        value="{{ old('country', $user->country) }}"
                                    >

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        PIN Code
                                    </label>

                                    <input
                                        type="text"
                                        name="pin_code"
                                        class="form-control profile-input"
                                        value="{{ old('pin_code', $user->pin_code) }}"
                                    >

                                </div>

                            </div>


                            {{-- LANGUAGE --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Language
                                </label>

                                <select
                                    name="language"
                                    class="form-select profile-input"
                                >

                                    @foreach($languages as $locale => $label)

                                        @php
                                            $displayLabel = is_array($label)
                                                ? ($label['name'] ?? $label['label'] ?? $locale)
                                                : $label;
                                        @endphp

                                        <option
                                            value="{{ $locale }}"
                                            @selected(
                                                old(
                                                    'language',
                                                    $user->language ?: array_key_first($languages)
                                                ) === $locale
                                            )
                                        >
                                            {{ $displayLabel }}
                                        </option>

                                    @endforeach

                                </select>

                                <small
                                    style="
                                        color:var(--muted);
                                        font-size:11px;
                                    "
                                >
                                    Select your preferred language.
                                </small>

                            </div>


                            {{-- THEME --}}

                            <div class="mb-3">

                                <label class="form-label">

                                    <i class="fa-solid fa-palette me-1"></i>

                                    Appearance

                                </label>

                                <select
                                    name="dark_mode"
                                    id="themeSelect"
                                    class="form-select profile-input"
                                >

                                    <option
                                        value="light"
                                        @selected(old('dark_mode', $user->dark_mode) === 'light')
                                    >
                                        ☀️ Light
                                    </option>

                                    <option
                                        value="dark"
                                        @selected(old('dark_mode', $user->dark_mode) === 'dark')
                                    >
                                        🌙 Dark
                                    </option>

                                    <option
                                        value="system"
                                        @selected(old('dark_mode', $user->dark_mode) === 'system')
                                    >
                                        💻 System Default
                                    </option>

                                </select>

                            </div>


                            {{-- NOTIFICATIONS --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Notifications
                                </label>

                                <select
                                    name="notifications"
                                    class="form-select profile-input"
                                >

                                    <option
                                        value="enabled"
                                        @selected(old('notifications', $user->notifications) === 'enabled')
                                    >
                                        🔔 Enabled
                                    </option>

                                    <option
                                        value="disabled"
                                        @selected(old('notifications', $user->notifications) === 'disabled')
                                    >
                                        🔕 Disabled
                                    </option>

                                </select>

                            </div>


                            <div class="section-title">
                                <div class="section-icon"><i class="fa-solid fa-building-columns"></i></div>
                                <div>
                                    <h2>Refund details</h2>
                                    <p>Saved securely and filled in automatically when you request a refund.</p>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-12">
                                    <label class="form-label" for="refundUpiId">UPI ID</label>
                                    <input class="form-control profile-input" id="refundUpiId" name="refund_upi_id" value="{{ old('refund_upi_id', $user->refund_upi_id) }}" maxlength="120" placeholder="name@bank" autocomplete="off">
                                    @error('refund_upi_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="refundAccountHolder">Bank account holder</label>
                                    <input class="form-control profile-input" id="refundAccountHolder" name="refund_account_holder" value="{{ old('refund_account_holder', $user->refund_account_holder) }}" maxlength="150" autocomplete="name">
                                    @error('refund_account_holder')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="refundBankName">Bank name</label>
                                    <input class="form-control profile-input" id="refundBankName" name="refund_bank_name" value="{{ old('refund_bank_name', $user->refund_bank_name) }}" maxlength="150" autocomplete="organization">
                                    @error('refund_bank_name')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label" for="refundAccountNumber">Account number</label>
                                    <input class="form-control profile-input" id="refundAccountNumber" name="refund_account_number" value="{{ old('refund_account_number', $user->refund_account_number) }}" inputmode="numeric" minlength="6" maxlength="20" autocomplete="off">
                                    @error('refund_account_number')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label" for="refundIfsc">IFSC code</label>
                                    <input class="form-control profile-input text-uppercase" id="refundIfsc" name="refund_ifsc" value="{{ old('refund_ifsc', $user->refund_ifsc) }}" maxlength="11" autocapitalize="characters" autocomplete="off">
                                    @error('refund_ifsc')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>

                            <hr
                                style="
                                    border-color:var(--border);
                                    margin:25px 0;
                                "
                            >


                            {{-- =================================================
                                 PASSWORD
                            ================================================= --}}

                            <div class="section-title">

                                <div class="section-icon">
                                    <i class="fa-solid fa-lock"></i>
                                </div>

                                <div>

                                    <h2>
                                        Change Password
                                    </h2>

                                    <p>
                                        Leave both fields empty if you don't
                                        want to change your password.
                                    </p>

                                </div>

                            </div>


                            {{-- NEW PASSWORD --}}

                            <div class="mb-3 password-box">

                                <label class="form-label">
                                    New Password
                                </label>

                                <div class="password-input-wrap">

                                    <input
                                        type="password"
                                        name="password"
                                        id="newPassword"
                                        class="form-control"
                                        placeholder="Enter new password"
                                        autocomplete="new-password"
                                        spellcheck="false"
                                        autocapitalize="off"
                                        autocorrect="off"
                                        inputmode="text"
                                    >

                                    <button
                                        type="button"
                                        class="password-eye"
                                        data-password-toggle="newPassword"
                                        aria-label="Show password"
                                    >
                                        <i class="fa-regular fa-eye"></i>
                                    </button>

                                </div>

                                <div class="password-help">
                                    Minimum 8 characters. Leave empty to keep your current password.
                                </div>

                            </div>


                            {{-- CONFIRM PASSWORD --}}

                            <div class="mb-4 password-box">

                                <label class="form-label">
                                    Confirm Password
                                </label>

                                <div class="password-input-wrap">

                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        id="passwordConfirmation"
                                        class="form-control"
                                        placeholder="Confirm new password"
                                        autocomplete="new-password"
                                        spellcheck="false"
                                        autocapitalize="off"
                                        autocorrect="off"
                                        inputmode="text"
                                    >

                                    <button
                                        type="button"
                                        class="password-eye"
                                        data-password-toggle="passwordConfirmation"
                                        aria-label="Show password"
                                    >
                                        <i class="fa-regular fa-eye"></i>
                                    </button>

                                </div>

                                <div
                                    id="passwordMatchMessage"
                                    class="password-match-message"
                                    aria-live="polite"
                                ></div>

                            </div>


                            {{-- BUTTONS --}}

                            <div class="d-flex gap-2 flex-wrap">

                                <button
                                    type="submit"
                                    class="save-button"
                                    id="saveProfileButton"
                                >

                                    <i class="fa-solid fa-floppy-disk me-2"></i>

                                    Save Profile

                                </button>

                                <a
                                    href="{{ Route::has('products.index') ? route('products.index') : url('/products') }}"
                                    class="back-button"
                                >
                                    Back
                                </a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            {{-- =================================================
                 RIGHT
            ================================================= --}}

            <div class="col-lg-8">

                <section class="card-premium mb-4" id="deliveryAddressesSection">
                    <div class="section">
                        <div class="section-title">
                            <div class="section-icon"><i class="fa-solid fa-location-dot"></i></div>
                            <div><h2>Saved delivery addresses</h2><p>Save multiple locations with recipient and PIN code details for checkout.</p></div>
                        </div>
                        @if(session('success'))<div class="alert-premium">{{ session('success') }}</div>@endif
                        @if($errors->any())<div class="alert alert-danger rounded-4">{{ $errors->first() }}</div>@endif
                        <div class="row g-3 mb-4">
                            @forelse($addresses as $savedAddress)
                                <div class="col-12 col-xl-6">
                                    <article class="p-3 h-100 rounded-4 border bg-white">
                                        <div class="d-flex justify-content-between gap-2"><strong>{{ $savedAddress->label }}</strong>@if($savedAddress->is_default)<span class="badge text-bg-primary">Default</span>@endif</div>
                                        <div class="mt-2 fw-semibold">{{ $savedAddress->recipient_name }} &middot; {{ $savedAddress->phone }}</div>
                                        <div class="text-muted small mt-1">{{ $savedAddress->address_line }}, {{ $savedAddress->city }}, {{ $savedAddress->state }} &middot; PIN {{ $savedAddress->pincode }}, {{ $savedAddress->country }}</div>
                                        <div class="d-flex flex-wrap gap-2 mt-3">
                                            @unless($savedAddress->is_default)<form method="POST" action="{{ route('addresses.default', $savedAddress) }}">@csrf<button class="btn btn-sm btn-outline-primary" type="submit">Set as default</button></form>@endunless
                                            <form method="POST" action="{{ route('addresses.destroy', $savedAddress) }}" onsubmit="return confirm('Remove this saved address?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" type="submit">Remove</button></form>
                                        </div>
                                    </article>
                                </div>
                            @empty
                                <div class="col-12"><p class="text-muted mb-0">No saved delivery addresses yet. Add your first address below.</p></div>
                            @endforelse
                        </div>
                        <h3 class="h5 fw-bold mb-3">Add another address</h3>
                        <form method="POST" action="{{ route('addresses.store') }}" class="row g-3">
                            @csrf
                            <div class="col-sm-4"><label class="form-label" for="addressLabel">Label</label><input class="form-control" id="addressLabel" name="label" value="{{ old('label', 'Home') }}" placeholder="Home, Work" required maxlength="50"></div>
                            <div class="col-sm-8"><label class="form-label" for="addressRecipient">Recipient</label><input class="form-control" id="addressRecipient" name="recipient_name" value="{{ old('recipient_name', $user->name) }}" required></div>
                            <div class="col-sm-6"><label class="form-label" for="addressPhone">Delivery phone</label><input class="form-control" id="addressPhone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}" required maxlength="20"></div>
                            <div class="col-sm-6"><label class="form-label" for="addressPincode">PIN code</label><input class="form-control" id="addressPincode" name="pincode" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" value="{{ old('pincode', $user->pin_code) }}" placeholder="6-digit PIN code" required></div>
                            <div class="col-12"><label class="form-label" for="addressLine">House, street and area</label><textarea class="form-control" id="addressLine" name="address_line" rows="2" required maxlength="1000">{{ old('address_line') }}</textarea></div>
                            <div class="col-sm-4"><label class="form-label" for="addressCity">City</label><input class="form-control" id="addressCity" name="city" value="{{ old('city', $user->city) }}" required></div>
                            <div class="col-sm-4"><label class="form-label" for="addressState">State</label><input class="form-control" id="addressState" name="state" value="{{ old('state', $user->state) }}" required></div>
                            <div class="col-sm-4"><label class="form-label" for="addressCountry">Country</label><input class="form-control" id="addressCountry" name="country" value="{{ old('country', 'India') }}" required></div>
                            <div class="col-12"><label class="d-flex align-items-center gap-2"><input class="form-check-input m-0" type="checkbox" name="is_default" value="1"> Use as my default checkout address</label></div>
                            <div class="col-12"><button class="save-button" type="submit"><i class="fa-solid fa-plus me-2"></i>Save delivery address</button> <a class="back-button ms-2" href="{{ route('addresses.index') }}">Manage all addresses</a></div>
                        </form>
                    </div>
                </section>


                {{-- SECURITY --}}

                <div
                    class="card-premium mb-4"
                    id="securitySection"
                >

                    <div class="section">

                        <div class="section-title">

                            <div class="section-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>

                            <div>

                                <h2>
                                    Security Center
                                </h2>

                                <p>
                                    Protect your SMART BASKET account
                                </p>

                            </div>

                        </div>


                        @if(session('security_success'))

                            <div class="alert-premium">
                                {{ session('security_success') }}
                            </div>

                        @endif


                        @if(
                            $user->securitySetting &&
                            $user->securitySetting->security_enabled
                        )

                            <div class="security enabled d-flex gap-3">

                                <div class="security-icon">

                                    <i class="fa-solid fa-shield-check"></i>

                                </div>

                                <div>

                                    <strong>
                                        Security PIN Enabled
                                    </strong>

                                    <div
                                        style="
                                            color:var(--muted);
                                            font-size:12px;
                                            margin-top:3px;
                                        "
                                    >
                                        Your account has an extra
                                        layer of protection.
                                    </div>

                                </div>

                            </div>


                            <form
                                action="{{ route('security.disable') }}"
                                method="POST"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-danger rounded-4 px-4 fw-bold"
                                >

                                    <i class="fa-solid fa-lock-open me-2"></i>

                                    Disable PIN

                                </button>

                            </form>

                        @else

                            <div class="security disabled d-flex gap-3">

                                <div class="security-icon">

                                    <i class="fa-solid fa-triangle-exclamation"></i>

                                </div>

                                <div>

                                    <strong>
                                        Security PIN Not Setup
                                    </strong>

                                    <div
                                        style="
                                            color:var(--muted);
                                            font-size:12px;
                                            margin-top:3px;
                                        "
                                    >
                                        Create a PIN to improve
                                        account security.
                                    </div>

                                </div>

                            </div>


                            <form
                                action="{{ route('security.save') }}"
                                method="POST"
                                autocomplete="off"
                            >

                                @csrf

                                <div class="mb-3">

                                    <label class="form-label">
                                        Create Security PIN
                                    </label>

                                    <input
                                        type="password"
                                        name="pin"
                                        maxlength="6"
                                        minlength="4"
                                        inputmode="numeric"
                                        class="form-control"
                                        placeholder="4–6 digit PIN"
                                        autocomplete="new-password"
                                        required
                                    >

                                </div>


                                <div class="mb-3">

                                    <label class="form-label">
                                        Confirm PIN
                                    </label>

                                    <input
                                        type="password"
                                        name="pin_confirmation"
                                        maxlength="6"
                                        minlength="4"
                                        inputmode="numeric"
                                        class="form-control"
                                        placeholder="Confirm PIN"
                                        autocomplete="new-password"
                                        required
                                    >

                                </div>


                                <button
                                    class="save-button"
                                    type="submit"
                                >

                                    <i class="fa-solid fa-shield me-2"></i>

                                    Enable Security PIN

                                </button>

                            </form>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                     ORDERS
                ================================================= --}}

                <div
                    class="card-premium"
                    id="ordersSection"
                >

                    <div class="section">

                        <div class="section-title">

                            <div class="section-icon">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </div>

                            <div>

                                <h2>
                                    My Orders
                                </h2>

                                <p>
                                    Your recent shopping activity
                                </p>

                            </div>

                        </div>


                        @php
                            $orders = $user
                                ->orders()
                                ->latest()
                                ->get();
                        @endphp


                        @if($orders->count() === 0)

                            <div class="empty">

                                <i class="fa-solid fa-box-open"></i>

                                <strong>
                                    No Orders Yet
                                </strong>

                                <div>
                                    Start shopping and your
                                    orders will appear here.
                                </div>

                            </div>

                        @else

                            <div
                                class="orders"
                                id="ordersTable"
                            >

                                <div class="table-responsive">

                                    <table class="table align-middle">

                                        <thead>

                                            <tr>

                                                <th>
                                                    Order
                                                </th>

                                                <th>
                                                    Date
                                                </th>

                                                <th>
                                                    Total
                                                </th>

                                                <th>
                                                    Status
                                                </th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach($orders as $order)

                                                <tr>

                                                    <td>

                                                        <span class="order-id">
                                                            #{{ $order->id }}
                                                        </span>

                                                    </td>

                                                    <td>

                                                        {{ $order->created_at?->format('d M Y') }}

                                                    </td>

                                                    <td class="fw-bold">

                                                        ₹{{ number_format((float)($order->total ?? 0), 2) }}

                                                    </td>

                                                    <td>

                                                        <span class="status">
                                                            {{ $order->status ?? 'Pending' }}
                                                        </span>

                                                    </td>

                                                </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
             MAIN LOGOUT
        ================================================= --}}

        <form
            action="{{ route('logout') }}"
            method="POST"
            id="mainLogoutForm"
        >

            @csrf

            <button
                type="submit"
                class="logout"
            >

                <i class="fa-solid fa-right-from-bracket me-2"></i>

                Logout from SMART BASKET

            </button>

        </form>

    </div>

</div>


<div
    class="sb-products-smart-ai-host"
    aria-hidden="false"
>
    <x-smart-ai-robot />
</div>

<x-ai-hub-sidebar :without-menu="true" />





<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        'use strict';


        /* =====================================================
           ELEMENTS
        ===================================================== */

        const form =
            document.getElementById('profileForm');

        const newPassword =
            document.getElementById('newPassword');

        const passwordConfirmation =
            document.getElementById('passwordConfirmation');

        const passwordMessage =
            document.getElementById('passwordMatchMessage');

        const saveButton =
            document.getElementById('saveProfileButton');

        const themeSelect =
            document.getElementById('themeSelect');

        const profileCard =
            document.getElementById('profileCard');


        /* =====================================================
           PASSWORD TOGGLE
        ===================================================== */

        document
            .querySelectorAll('[data-password-toggle]')
            .forEach(function (button) {

                button.addEventListener(
                    'click',
                    function () {

                        const targetId =
                            button.getAttribute(
                                'data-password-toggle'
                            );

                        const target =
                            document.getElementById(
                                targetId
                            );

                        if (!target) {
                            return;
                        }

                        const icon =
                            button.querySelector('i');

                        if (target.type === 'password') {

                            target.type = 'text';

                            button.setAttribute(
                                'aria-label',
                                'Hide password'
                            );

                            if (icon) {
                                icon.className =
                                    'fa-regular fa-eye-slash';
                            }

                        } else {

                            target.type = 'password';

                            button.setAttribute(
                                'aria-label',
                                'Show password'
                            );

                            if (icon) {
                                icon.className =
                                    'fa-regular fa-eye';
                            }

                        }

                    }
                );

            });


        /* =====================================================
           PASSWORD MATCH CHECK
        ===================================================== */

        function checkPasswordMatch() {

            if (!newPassword || !passwordConfirmation) {
                return true;
            }

            const password =
                newPassword.value;

            const confirmation =
                passwordConfirmation.value;


            /*
            -----------------------------------------------------
            BOTH EMPTY
            -----------------------------------------------------
            This is the important fix.

            If customer is editing name/email/address/etc.
            and password fields are empty, password validation
            should NOT interfere.
            -----------------------------------------------------
            */

            if (
                password === '' &&
                confirmation === ''
            ) {

                passwordMessage.textContent = '';

                passwordMessage.className =
                    'password-match-message';

                newPassword.classList.remove(
                    'password-error-border',
                    'password-success-border'
                );

                passwordConfirmation.classList.remove(
                    'password-error-border',
                    'password-success-border'
                );

                return true;
            }


            /*
            -----------------------------------------------------
            PASSWORD ENTERED BUT CONFIRMATION EMPTY
            -----------------------------------------------------
            */

            if (
                password !== '' &&
                confirmation === ''
            ) {

                passwordMessage.textContent =
                    'Please confirm your new password.';

                passwordMessage.className =
                    'password-match-message mismatch';

                newPassword.classList.remove(
                    'password-error-border'
                );

                passwordConfirmation.classList.add(
                    'password-error-border'
                );

                return false;
            }


            /*
            -----------------------------------------------------
            CONFIRMATION ENTERED BUT PASSWORD EMPTY
            -----------------------------------------------------
            */

            if (
                password === '' &&
                confirmation !== ''
            ) {

                passwordMessage.textContent =
                    'Please enter the new password first.';

                passwordMessage.className =
                    'password-match-message mismatch';

                newPassword.classList.add(
                    'password-error-border'
                );

                passwordConfirmation.classList.add(
                    'password-error-border'
                );

                return false;
            }


            /*
            -----------------------------------------------------
            MATCH
            -----------------------------------------------------
            */

            if (password === confirmation) {

                passwordMessage.textContent =
                    '✓ Passwords match.';

                passwordMessage.className =
                    'password-match-message match';

                newPassword.classList.remove(
                    'password-error-border'
                );

                newPassword.classList.add(
                    'password-success-border'
                );

                passwordConfirmation.classList.remove(
                    'password-error-border'
                );

                passwordConfirmation.classList.add(
                    'password-success-border'
                );

                return true;
            }


            /*
            -----------------------------------------------------
            MISMATCH
            -----------------------------------------------------
            */

            passwordMessage.textContent =
                '✕ Passwords do not match.';

            passwordMessage.className =
                'password-match-message mismatch';

            newPassword.classList.add(
                'password-error-border'
            );

            passwordConfirmation.classList.add(
                'password-error-border'
            );

            newPassword.classList.remove(
                'password-success-border'
            );

            passwordConfirmation.classList.remove(
                'password-success-border'
            );

            return false;
        }


        if (newPassword) {

            newPassword.addEventListener(
                'input',
                checkPasswordMatch
            );

        }


        if (passwordConfirmation) {

            passwordConfirmation.addEventListener(
                'input',
                checkPasswordMatch
            );

        }


        /* =====================================================
           PROFILE FORM SUBMIT
           ===================================================== */

        if (form) {

            form.addEventListener(
                'submit',
                function (event) {

                    /*
                    -------------------------------------------------
                    IMPORTANT:
                    If both password fields are blank, explicitly
                    remove them from the submitted form.

                    This protects against browser autofill /
                    password-manager generated values.
                    -------------------------------------------------
                    */

                    if (
                        newPassword &&
                        passwordConfirmation
                    ) {

                        const password =
                            newPassword.value.trim();

                        const confirmation =
                            passwordConfirmation.value.trim();


                        if (
                            password === '' &&
                            confirmation === ''
                        ) {

                            newPassword.value = '';
                            passwordConfirmation.value = '';

                        } else {

                            if (!checkPasswordMatch()) {

                                event.preventDefault();

                                passwordConfirmation.focus();

                                passwordConfirmation.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });

                                return false;
                            }


                            /*
                            -------------------------------------------------
                            MINIMUM LENGTH
                            -------------------------------------------------
                            */

                            if (password.length < 8) {

                                event.preventDefault();

                                passwordMessage.textContent =
                                    'Password must be at least 8 characters.';

                                passwordMessage.className =
                                    'password-match-message mismatch';

                                newPassword.classList.add(
                                    'password-error-border'
                                );

                                newPassword.focus();

                                return false;
                            }

                        }

                    }


                    /*
                    -------------------------------------------------
                    Prevent accidental double submit.
                    -------------------------------------------------
                    */

                    if (saveButton) {

                        saveButton.disabled = true;

                        saveButton.innerHTML =
                            '<i class="fa-solid fa-spinner fa-spin me-2"></i> Saving...';

                    }

                }
            );

        }


        /* =====================================================
           THEME SELECT
        ===================================================== */

        function applyTheme(theme) {

            let finalTheme = theme;

            if (theme === 'system') {

                finalTheme =
                    window.matchMedia(
                        '(prefers-color-scheme: dark)'
                    ).matches
                        ? 'dark'
                        : 'light';

            }

            document.documentElement.setAttribute(
                'data-theme',
                finalTheme
            );

            document.documentElement.setAttribute(
                'data-sb-theme',
                finalTheme
            );

            document.body.setAttribute(
                'data-sb-theme',
                finalTheme
            );

        }


        applyTheme(
            @json($theme)
        );


        if (themeSelect) {

            themeSelect.addEventListener(
                'change',
                function () {

                    applyTheme(
                        this.value
                    );

                }
            );

        }


        /* =====================================================
           LIVE PROFILE COMPLETION
        ===================================================== */

        const percent =
            document.getElementById(
                'completionPercent'
            );

        const bar =
            document.getElementById(
                'completionBar'
            );

        const completionText =
            document.getElementById(
                'completionText'
            );


        if (form) {

            const fields = [

                'name',
                'username',
                'email',
                'phone',
                'date_of_birth',
                'gender',
                'address',
                'house_no',
                'street',
                'area',
                'landmark',
                'city',
                'state',
                'country',
                'pin_code',
                'language',
                'profile_image'

            ];


            function calculateCompletion() {

                let filled = 0;


                fields.forEach(
                    function (name) {

                        const field =
                            form.querySelector(
                                '[name="' + name + '"]'
                            );


                        if (!field) {
                            return;
                        }


                        if (field.type === 'file') {

                            const existingImage =
                                {{ $user->profile_image ? 'true' : 'false' }};


                            if (
                                existingImage ||
                                field.files.length > 0
                            ) {
                                filled++;
                            }

                            return;
                        }


                        if (
                            field.value &&
                            field.value.trim() !== ''
                        ) {
                            filled++;
                        }

                    }
                );


                const total =
                    fields.length;

                const result =
                    Math.round(
                        (filled / total) * 100
                    );


                if (percent) {
                    percent.textContent =
                        result + '%';
                }


                if (bar) {
                    bar.style.width =
                        result + '%';
                }


                if (profileCard) {

                    if (result >= 100) {

                        profileCard.classList.add(
                            'profile-complete'
                        );

                        if (completionText) {
                            completionText.innerHTML =
                                '🎉 Everything looks perfect!';
                        }

                    } else {

                        profileCard.classList.remove(
                            'profile-complete'
                        );

                        if (completionText) {
                            completionText.innerHTML =
                                'Complete all details to reach 100%.';
                        }

                    }

                }

            }


            form.querySelectorAll(
                '.profile-input'
            ).forEach(
                function (field) {

                    field.addEventListener(
                        'input',
                        calculateCompletion
                    );

                    field.addEventListener(
                        'change',
                        calculateCompletion
                    );

                }
            );


            calculateCompletion();

        }


        /* =====================================================
           IMAGE PREVIEW
        ===================================================== */

        const imageInput =
            document.getElementById(
                'profileImage'
            );

        const previewBox =
            document.getElementById(
                'imagePreview'
            );

        const previewImage =
            document.getElementById(
                'previewImage'
            );

        const imageInfo =
            document.getElementById(
                'imageInfo'
            );


        if (imageInput) {

            imageInput.addEventListener(
                'change',
                function () {

                    const file =
                        this.files[0];


                    if (!file) {
                        return;
                    }


                    const maxSize =
                        2 * 1024 * 1024;


                    if (file.size > maxSize) {

                        if (imageInfo) {

                            imageInfo.innerHTML =
                                '<span style="color:#dc2626;font-weight:800;">' +
                                'Image is larger than 2 MB. Please choose a smaller image.' +
                                '</span>';

                        }


                        this.value = '';


                        if (previewBox) {
                            previewBox.style.display = 'none';
                        }

                        return;
                    }


                    if (imageInfo) {

                        imageInfo.innerHTML =
                            '<span style="color:#16a34a;font-weight:800;">' +
                            file.name +
                            ' • ' +
                            (file.size / 1024 / 1024)
                                .toFixed(2) +
                            ' MB' +
                            '</span>';

                    }


                    if (previewImage && previewBox) {

                        const reader =
                            new FileReader();


                        reader.onload =
                            function (event) {

                                previewImage.src =
                                    event.target.result;

                                previewBox.style.display =
                                    'block';

                            };


                        reader.readAsDataURL(file);

                    }


                    calculateCompletionSafely();

                }
            );

        }


        function calculateCompletionSafely() {

            if (typeof calculateCompletion === 'function') {
                calculateCompletion();
            }

        }


        /* =====================================================
           ORDERS / SECURITY MENU SUPPORT
        ===================================================== */

        const myOrdersButton =
            document.getElementById(
                'myOrdersMenuButton'
            );

        const ordersSection =
            document.getElementById(
                'ordersSection'
            );


        if (myOrdersButton) {

            myOrdersButton.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();
                    event.stopPropagation();

                    window.closeMenu();

                    if (ordersSection) {

                        ordersSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });


                        ordersSection.classList.remove(
                            'orders-highlight'
                        );

                        void ordersSection.offsetWidth;

                        ordersSection.classList.add(
                            'orders-highlight'
                        );


                        setTimeout(
                            function () {

                                ordersSection.classList.remove(
                                    'orders-highlight'
                                );

                            },
                            1600
                        );

                    }

                }
            );

        }


        const securityButton =
            document.getElementById(
                'securityMenuButton'
            );

        const securitySection =
            document.getElementById(
                'securitySection'
            );


        if (securityButton) {

            securityButton.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();
                    event.stopPropagation();

                    window.closeMenu();

                    if (securitySection) {

                        securitySection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });

                    }

                }
            );

        }


        const profileDetailsButton =
            document.getElementById(
                'profileDetailsMenuButton'
            );


        if (profileDetailsButton) {

            profileDetailsButton.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();
                    event.stopPropagation();

                    window.closeMenu();

                    if (form) {

                        form.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });


                        setTimeout(
                            function () {

                                const firstInput =
                                    form.querySelector(
                                        'input[name="name"]'
                                    );

                                if (firstInput) {

                                    firstInput.focus({
                                        preventScroll: true
                                    });

                                }

                            },
                            650
                        );

                    }

                }
            );

        }


        /* =====================================================
           ALERT AUTO HIDE
        ===================================================== */

        setTimeout(
            function () {

                document
                    .querySelectorAll(
                        '.alert-premium'
                    )
                    .forEach(
                        function (alert) {

                            alert.style.transition =
                                'opacity .5s ease';

                            alert.style.opacity =
                                '0';


                            setTimeout(
                                function () {

                                    if (alert) {
                                        alert.remove();
                                    }

                                },
                                600
                            );

                        }
                    );

            },
            4500
        );


        /* =====================================================
           CLOSE MENU AFTER MENU-CLOSE LINKS
        ===================================================== */

        document
            .querySelectorAll('.menu-close')
            .forEach(
                function (link) {

                    link.addEventListener(
                        'click',
                        function () {

                            window.closeMenu();

                        }
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | FINAL PASSWORD RESET
        |--------------------------------------------------------------------------
        | Do not allow browser restoration of old password values
        | after page load / back-forward cache.
        |--------------------------------------------------------------------------
        */

        if (newPassword) {
            newPassword.value = '';
        }

        if (passwordConfirmation) {
            passwordConfirmation.value = '';
        }

        if (passwordMessage) {
            passwordMessage.textContent = '';
            passwordMessage.className =
                'password-match-message';
        }

    }
);
</script>

</body>
</html>
