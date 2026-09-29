{{-- resources/views/seller/profile.blade.php --}}

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>Seller Profile | Smart Basket</title>

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css"
    >

    @php

        use Illuminate\Support\Facades\Storage;

        /*
        |--------------------------------------------------------------------------
        | IMAGE URL HELPERS
        |--------------------------------------------------------------------------
        */

        $logoUrl = null;

        if (!empty($seller->shop_logo)) {

            $logoPath = ltrim(
                $seller->shop_logo,
                '/'
            );

            if (str_starts_with($logoPath, 'storage/')) {

                $logoUrl = asset($logoPath);

            } else {

                $logoUrl = Storage::disk('public')
                    ->url($logoPath);

            }

        }


        $qrUrl = null;

        if (!empty($seller->payment_qr)) {

            $qrPath = ltrim(
                $seller->payment_qr,
                '/'
            );

            if (str_starts_with($qrPath, 'storage/')) {

                $qrPath = substr(
                    $qrPath,
                    strlen('storage/')
                );

            }

            $qrUrl = Storage::disk('public')
                ->url($qrPath);

        }


        /*
        |--------------------------------------------------------------------------
        | SELLER INITIALS
        |--------------------------------------------------------------------------
        */

        $sellerName =
            $seller->seller_name ?: 'Seller';

        $words =
            preg_split(
                '/\s+/',
                trim($sellerName)
            );

        if (count($words) >= 2) {

            $initials = strtoupper(
                substr($words[0], 0, 1) .
                substr(
                    $words[count($words) - 1],
                    0,
                    1
                )
            );

        } else {

            $initials = strtoupper(
                substr(
                    $sellerName,
                    0,
                    2
                )
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATES
        |--------------------------------------------------------------------------
        */

        $registeredAt =
            $seller->created_at
                ? $seller->created_at->format(
                    'd M Y, h:i A'
                )
                : '—';

        $updatedAt =
            $seller->updated_at
                ? $seller->updated_at->format(
                    'd M Y, h:i A'
                )
                : '—';

    @endphp


    <style>

        /* =========================================================
           SMART BASKET SELLER PROFILE
           PREMIUM FULL-WIDTH DESIGN
        ========================================================== */

        :root {

            --sb-primary: #2563eb;
            --sb-primary-dark: #1d4ed8;
            --sb-primary-deep: #1e3a8a;
            --sb-blue: #3b82f6;
            --sb-cyan: #0ea5e9;

            --sb-blue-soft: #eff6ff;
            --sb-blue-soft-2: #dbeafe;
            --sb-blue-border: #bfdbfe;

            --sb-success: #16a34a;
            --sb-success-dark: #15803d;
            --sb-success-soft: #f0fdf4;
            --sb-success-border: #bbf7d0;

            --sb-danger: #dc2626;
            --sb-danger-soft: #fef2f2;
            --sb-danger-border: #fecaca;

            --sb-warning: #d97706;
            --sb-warning-soft: #fffbeb;
            --sb-warning-border: #fde68a;

            --sb-bg: #f3f6fb;
            --sb-surface: #ffffff;
            --sb-surface-soft: #f8fafc;

            --sb-border: #e2e8f0;
            --sb-border-soft: #edf2f7;

            --sb-text: #0f172a;
            --sb-text-2: #334155;
            --sb-muted: #64748b;
            --sb-muted-light: #94a3b8;

            --sb-shadow-xs:
                0 2px 8px rgba(15, 23, 42, .035);

            --sb-shadow-sm:
                0 6px 20px rgba(15, 23, 42, .055);

            --sb-shadow:
                0 14px 40px rgba(15, 23, 42, .065);

            --sb-shadow-lg:
                0 25px 70px rgba(15, 23, 42, .09);

            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-xl: 25px;

        }


        /* =========================================================
           SAFE GLOBAL BASICS
           Scoped so seller taskbar/menu are not disturbed
        ========================================================== */

        html {

            scroll-behavior: smooth;

            background:
                var(--sb-bg);

        }


        body {

            min-height: 100vh;

            margin: 0;

            overflow-x: hidden;

            color:
                var(--sb-text);

            font-family:
                "Inter",
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:

                radial-gradient(
                    circle at 0% 0%,
                    rgba(37, 99, 235, .075),
                    transparent 24%
                ),

                radial-gradient(
                    circle at 100% 0%,
                    rgba(14, 165, 233, .055),
                    transparent 22%
                ),

                linear-gradient(
                    145deg,
                    #fafdff 0%,
                    #f3f6fb 50%,
                    #edf2f8 100%
                );

        }


        body::before {

            content: "";

            position: fixed;

            inset: 0;

            pointer-events: none;

            z-index: 0;

            opacity: .30;

            background-image:

                linear-gradient(
                    rgba(15, 23, 42, .018) 1px,
                    transparent 1px
                ),

                linear-gradient(
                    90deg,
                    rgba(15, 23, 42, .018) 1px,
                    transparent 1px
                );

            background-size:
                44px 44px;

            mask-image:
                linear-gradient(
                    to bottom,
                    black,
                    transparent 82%
                );

            -webkit-mask-image:
                linear-gradient(
                    to bottom,
                    black,
                    transparent 82%
                );

        }


        button,
        input,
        textarea,
        select {

            font: inherit;

        }


        button {

            -webkit-tap-highlight-color:
                transparent;

        }


        /* =========================================================
           PAGE WRAPPER
           FULL WIDTH / NO NARROW CONTAINER
        ========================================================== */

        .profile-page {

            position: relative;

            z-index: 2;

            width: 100%;

            max-width: none;

            margin: 0;

            padding:
                clamp(14px, 1.5vw, 26px)
                clamp(12px, 1.7vw, 30px)
                50px;

            overflow: visible;

        }


        .profile-page *,
        .crop-modal * {

            box-sizing: border-box;

        }


        /* =========================================================
           PREMIUM TITLE CARD
        ========================================================== */

        .profile-title-card {

            position: relative;

            overflow: hidden;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            width: 100%;

            min-height: 112px;

            margin-bottom: 17px;

            padding:
                22px clamp(18px, 2vw, 28px);

            border:
                1px solid
                rgba(255,255,255,.96);

            border-radius:
                var(--radius-xl);

            background:

                linear-gradient(
                    135deg,
                    rgba(255,255,255,.99) 0%,
                    rgba(248,251,255,.98) 55%,
                    rgba(239,246,255,.96) 100%
                );

            box-shadow:
                var(--sb-shadow-lg);

        }


        .profile-title-card::before {

            content: "";

            position: absolute;

            top: -130px;

            right: -80px;

            width: 360px;

            height: 360px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(37,99,235,.18),
                    transparent 68%
                );

            pointer-events: none;

        }


        .profile-title-card::after {

            content: "";

            position: absolute;

            left: 0;

            bottom: 0;

            width: 45%;

            height: 3px;

            background:
                linear-gradient(
                    90deg,
                    var(--sb-primary),
                    var(--sb-blue),
                    transparent
                );

            border-radius:
                0 10px 0 0;

        }


        .title-card-left {

            position: relative;

            z-index: 2;

            display: flex;

            align-items: center;

            gap: 15px;

            min-width: 0;

        }


        .title-card-icon {

            width: 54px;

            height: 54px;

            flex: 0 0 54px;

            display: grid;

            place-items: center;

            border-radius: 16px;

            color: #ffffff;

            background:

                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            box-shadow:
                0 13px 28px
                rgba(37,99,235,.23);

        }


        .title-card-icon i {

            font-size: 19px;

        }


        .title-card-content {

            min-width: 0;

        }


        .title-card-eyebrow {

            display: flex;

            align-items: center;

            gap: 7px;

            margin-bottom: 4px;

            color:
                var(--sb-primary);

            font-size: 9px;

            font-weight: 900;

            letter-spacing:
                .14em;

            text-transform:
                uppercase;

        }


        .title-card-eyebrow i {

            font-size: 7px;

        }


        .title-card-content h1 {

            margin: 0;

            color:
                var(--sb-text);

            font-size:
                clamp(23px, 2.6vw, 32px);

            line-height: 1.08;

            font-weight: 900;

            letter-spacing: -1px;

        }


        .title-card-content p {

            margin: 6px 0 0;

            color:
                var(--sb-muted);

            font-size: 11px;

            line-height: 1.55;

        }


        .title-card-right {

            position: relative;

            z-index: 2;

            flex-shrink: 0;

            display: flex;

            align-items: center;

            gap: 8px;

        }


        .account-live {

            min-height: 39px;

            padding:
                0 13px;

            display: inline-flex;

            align-items: center;

            gap: 8px;

            border:
                1px solid
                var(--sb-success-border);

            border-radius: 12px;

            color:
                var(--sb-success-dark);

            background:
                rgba(240,253,244,.92);

            font-size: 9.5px;

            font-weight: 900;

            box-shadow:
                var(--sb-shadow-xs);

            white-space: nowrap;

        }


        .account-live-dot {

            width: 8px;

            height: 8px;

            border-radius: 50%;

            background:
                #22c55e;

            box-shadow:
                0 0 0 4px
                rgba(34,197,94,.11);

        }


        /* =========================================================
           ALERTS
        ========================================================== */

        .profile-page .alert {

            display: flex;

            align-items: flex-start;

            gap: 11px;

            width: 100%;

            margin:
                0 0 15px;

            padding:
                13px 15px;

            border-radius: 13px;

            font-size: 11px;

            font-weight: 700;

            line-height: 1.5;

            animation:
                alertIn .3s ease;

        }


        @keyframes alertIn {

            from {

                opacity: 0;

                transform:
                    translateY(-6px);

            }

            to {

                opacity: 1;

                transform:
                    translateY(0);

            }

        }


        .profile-page .alert-success {

            color:
                #166534;

            background:
                var(--sb-success-soft);

            border:
                1px solid
                var(--sb-success-border);

        }


        .profile-page .alert-error {

            color:
                #991b1b;

            background:
                var(--sb-danger-soft);

            border:
                1px solid
                var(--sb-danger-border);

        }


        .alert-icon {

            width: 21px;

            height: 21px;

            display: grid;

            place-items: center;

            flex: 0 0 21px;

        }


        .errors {

            display: grid;

            gap: 5px;

            min-width: 0;

        }


        /* =========================================================
           PROFILE HERO
        ========================================================== */

        .profile-hero {

            position: relative;

            overflow: hidden;

            width: 100%;

            min-height: 138px;

            margin-bottom: 17px;

            padding:
                clamp(19px, 2vw, 25px);

            border:
                1px solid
                rgba(255,255,255,.96);

            border-radius:
                var(--radius-xl);

            background:

                linear-gradient(
                    135deg,
                    rgba(255,255,255,.99),
                    rgba(247,250,255,.98)
                );

            box-shadow:
                var(--sb-shadow-lg);

        }


        .profile-hero::before {

            content: "";

            position: absolute;

            width: 520px;

            height: 520px;

            top: -380px;

            right: -90px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(37,99,235,.15),
                    transparent 69%
                );

        }


        .profile-hero::after {

            content: "";

            position: absolute;

            width: 310px;

            height: 310px;

            bottom: -250px;

            left: -120px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(14,165,233,.10),
                    transparent 70%
                );

        }


        .hero-content {

            position: relative;

            z-index: 2;

            display: flex;

            align-items: center;

            gap: 20px;

            min-width: 0;

        }


        /* =========================================================
           AVATAR
        ========================================================== */

        .avatar-wrap {

            position: relative;

            flex: 0 0 102px;

            width: 102px;

            height: 102px;

            padding: 4px;

            border-radius: 27px;

            background:

                linear-gradient(
                    135deg,
                    #2563eb,
                    #3b82f6,
                    #60a5fa
                );

            box-shadow:
                0 17px 38px
                rgba(37,99,235,.21);

        }


        .avatar {

            width: 100%;

            height: 100%;

            overflow: hidden;

            display: grid;

            place-items: center;

            border:
                3px solid
                #ffffff;

            border-radius: 23px;

            background:
                #ffffff;

        }


        .avatar img {

            width: 100%;

            height: 100%;

            display: block;

            object-fit: cover;

        }


        .avatar-fallback {

            width: 100%;

            height: 100%;

            display: grid;

            place-items: center;

            color:
                var(--sb-primary);

            background:
                linear-gradient(
                    135deg,
                    #eff6ff,
                    #dbeafe
                );

            font-size: 27px;

            font-weight: 900;

            letter-spacing: -.7px;

        }


        .online-dot {

            position: absolute;

            right: -4px;

            bottom: -3px;

            width: 20px;

            height: 20px;

            border-radius: 50%;

            background:
                #22c55e;

            border:
                4px solid
                #ffffff;

            box-shadow:
                0 5px 14px
                rgba(34,197,94,.30);

        }


        .hero-info {

            min-width: 0;

            flex: 1;

        }


        .hero-info h2 {

            margin: 0;

            overflow: hidden;

            color:
                var(--sb-text);

            font-size:
                clamp(22px, 2.7vw, 33px);

            line-height: 1.08;

            font-weight: 900;

            letter-spacing: -1px;

            text-overflow: ellipsis;

        }


        .hero-shop {

            display: flex;

            align-items: center;

            gap: 7px;

            margin-top: 7px;

            color:
                var(--sb-text-2);

            font-size: 12px;

            font-weight: 750;

        }


        .hero-shop i {

            color:
                var(--sb-primary);

            font-size: 11px;

        }


        .hero-meta {

            display: flex;

            flex-wrap: wrap;

            gap: 7px;

            margin-top: 12px;

        }


        .pill {

            min-height: 28px;

            max-width: 100%;

            padding:
                0 10px;

            display: inline-flex;

            align-items: center;

            gap: 6px;

            overflow: hidden;

            border:
                1px solid
                var(--sb-border);

            border-radius: 999px;

            color:
                var(--sb-muted);

            background:
                rgba(255,255,255,.9);

            font-size: 9px;

            font-weight: 800;

            text-overflow: ellipsis;

            white-space: nowrap;

        }


        .pill.green {

            color:
                #15803d;

            background:
                var(--sb-success-soft);

            border-color:
                var(--sb-success-border);

        }


        .pill.blue {

            color:
                var(--sb-primary-dark);

            background:
                var(--sb-blue-soft);

            border-color:
                var(--sb-blue-border);

        }


        .pill i {

            flex-shrink: 0;

            font-size: 7px;

        }


        /* =========================================================
           MAIN CONTENT GRID
           BALANCED + NO RIGHT SIDE CUT
        ========================================================== */

        .main-grid {

            display: grid;

            grid-template-columns:
                minmax(0, 1.62fr)
                minmax(300px, .68fr);

            gap: 17px;

            width: 100%;

            align-items: start;

        }


        .left-stack,
        .side-stack {

            display: grid;

            gap: 17px;

            min-width: 0;

        }


        .left-stack > *,
        .side-stack > * {

            min-width: 0;

        }


        /* =========================================================
           PREMIUM CARD
        ========================================================== */

        .profile-page .card {

            position: relative;

            overflow: hidden;

            width: 100%;

            min-width: 0;

            border:
                1px solid
                rgba(226,232,240,.96);

            border-radius:
                var(--radius-lg);

            background:
                rgba(255,255,255,.975);

            box-shadow:
                var(--sb-shadow);

            transition:
                box-shadow .22s ease,
                transform .22s ease;

        }


        .profile-page .card:hover {

            box-shadow:
                0 20px 55px
                rgba(15,23,42,.085);

        }


        .profile-page .card::before {

            content: "";

            position: absolute;

            top: 0;

            left: 0;

            right: 0;

            height: 3px;

            background:

                linear-gradient(
                    90deg,
                    var(--sb-primary),
                    var(--sb-blue),
                    #93c5fd
                );

        }


        /* =========================================================
           CARD HEADER
        ========================================================== */

        .card-header {

            min-height: 64px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 12px;

            padding:
                14px 18px;

            border-bottom:
                1px solid
                var(--sb-border-soft);

            background:
                linear-gradient(
                    180deg,
                    #ffffff,
                    #fbfdff
                );

        }


        .section-title {

            display: flex;

            align-items: center;

            gap: 9px;

            min-width: 0;

            color:
                var(--sb-text);

            font-size: 12px;

            font-weight: 900;

        }


        .section-icon {

            width: 35px;

            height: 35px;

            flex: 0 0 35px;

            display: grid;

            place-items: center;

            border:
                1px solid
                var(--sb-blue-border);

            border-radius: 10px;

            color:
                var(--sb-primary);

            background:

                linear-gradient(
                    135deg,
                    #eff6ff,
                    #dbeafe
                );

        }


        .section-icon i {

            font-size: 12px;

        }


        .card-header small {

            flex-shrink: 0;

            color:
                var(--sb-muted-light);

            font-size: 8.5px;

            font-weight: 750;

            white-space: nowrap;

        }


        /* =========================================================
           INFORMATION BODY
        ========================================================== */

        .info-body {

            padding:
                2px 18px 10px;

        }


        .info-row {

            display: grid;

            grid-template-columns:
                165px
                minmax(0, 1fr);

            gap: 18px;

            align-items: center;

            min-height: 51px;

            padding:
                10px 0;

            border-bottom:
                1px solid
                #f1f5f9;

        }


        .info-row:last-child {

            border-bottom: 0;

        }


        .info-label {

            color:
                var(--sb-muted);

            font-size: 10px;

            font-weight: 750;

        }


        .info-value {

            min-width: 0;

            color:
                var(--sb-text);

            font-size: 11px;

            font-weight: 750;

            line-height: 1.5;

            word-break: break-word;

        }


        .info-value.empty {

            color:
                var(--sb-muted-light);

            font-weight: 650;

        }


        .status-value {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            min-height: 25px;

            padding:
                0 9px;

            border:
                1px solid
                var(--sb-success-border);

            border-radius: 999px;

            color:
                #15803d;

            background:
                var(--sb-success-soft);

            font-size: 9px;

            font-weight: 850;

        }


        .status-dot {

            width: 7px;

            height: 7px;

            border-radius: 50%;

            background:
                #22c55e;

            box-shadow:
                0 0 0 3px
                rgba(34,197,94,.11);

        }


        /* =========================================================
           EDIT BODY
        ========================================================== */

        .edit-body {

            padding:
                18px;

        }


        .edit-intro {

            display: flex;

            align-items: flex-start;

            gap: 10px;

            margin-bottom: 16px;

            padding:
                11px 12px;

            border:
                1px solid
                var(--sb-blue-border);

            border-radius: 12px;

            color:
                #475569;

            background:
                linear-gradient(
                    135deg,
                    #f8fbff,
                    #eff6ff
                );

            font-size: 10px;

            line-height: 1.6;

        }


        .edit-intro::before {

            content: "\f05a";

            font-family:
                "Font Awesome 6 Free";

            font-weight: 900;

            color:
                var(--sb-primary);

            flex-shrink: 0;

            margin-top: 2px;

        }


        .edit-intro strong {

            color:
                var(--sb-text);

            margin-right: 3px;

        }


        /* =========================================================
           FORM
        ========================================================== */

        .form-grid {

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 14px;

        }


        .field {

            display: grid;

            gap: 6px;

            min-width: 0;

        }


        .field.full {

            grid-column:
                1 / -1;

        }


        .field label {

            color:
                var(--sb-text-2);

            font-size: 9.5px;

            font-weight: 850;

        }


        .required {

            color:
                var(--sb-danger);

        }


        .field input,
        .field textarea,
        .field select {

            width: 100%;

            max-width: 100%;

            min-height: 43px;

            padding:
                0 11px;

            outline: none;

            border:
                1px solid
                #d9e2ec;

            border-radius: 10px;

            color:
                var(--sb-text);

            background:
                #ffffff;

            font-size: 11px;

            font-weight: 600;

            box-shadow:
                0 2px 5px
                rgba(15,23,42,.018);

            transition:
                border-color .18s ease,
                box-shadow .18s ease,
                background .18s ease;

        }


        .field input::placeholder,
        .field textarea::placeholder {

            color:
                #a3afbf;

            font-weight: 500;

        }


        .field textarea {

            min-height: 96px;

            padding-top: 10px;

            padding-bottom: 10px;

            resize: vertical;

            line-height: 1.55;

        }


        .field input:hover,
        .field textarea:hover,
        .field select:hover {

            border-color:
                #c4d0dd;

        }


        .field input:focus,
        .field textarea:focus,
        .field select:focus {

            border-color:
                var(--sb-primary);

            background:
                #ffffff;

            box-shadow:
                0 0 0 4px
                rgba(37,99,235,.075);

        }


        .field-note {

            color:
                var(--sb-muted-light);

            font-size: 8.5px;

            line-height: 1.45;

        }


        /* =========================================================
           UPLOAD BOX
        ========================================================== */

        .upload-box {

            width: 100%;

            padding:
                13px;

            border:
                1px dashed
                #bfd0e3;

            border-radius: 13px;

            background:
                linear-gradient(
                    145deg,
                    #f8fbff,
                    #ffffff
                );

        }


        .upload-box input[type="file"] {

            width: 100%;

            max-width: 100%;

            min-height: 41px;

            padding: 5px;

            cursor: pointer;

            border:
                1px solid
                #d9e2ec;

            border-radius: 9px;

            color:
                var(--sb-text-2);

            background:
                #ffffff;

            font-size: 10px;

        }


        .upload-box input[type="file"]::file-selector-button {

            margin-right: 8px;

            padding:
                6px 10px;

            border: 0;

            border-radius: 7px;

            color:
                var(--sb-primary-dark);

            background:
                var(--sb-blue-soft);

            font-size: 9px;

            font-weight: 850;

            cursor: pointer;

        }


        .upload-note {

            margin-top: 7px;

            color:
                var(--sb-muted-light);

            font-size: 8.7px;

            line-height: 1.5;

        }


        /* =========================================================
           CURRENT LOGO
        ========================================================== */

        .current-logo {

            display: flex;

            align-items: center;

            gap: 11px;

            width: 100%;

            margin-bottom: 11px;

            padding:
                10px;

            border:
                1px solid
                var(--sb-border);

            border-radius: 13px;

            background:
                linear-gradient(
                    135deg,
                    #ffffff,
                    #f8fbff
                );

        }


        .current-logo-frame {

            width: 62px;

            height: 62px;

            flex: 0 0 62px;

            padding: 3px;

            display: grid;

            place-items: center;

            border-radius: 15px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #3b82f6
                );

            box-shadow:
                0 8px 21px
                rgba(37,99,235,.15);

        }


        .current-logo-frame img {

            width: 100%;

            height: 100%;

            display: block;

            object-fit: cover;

            border:
                3px solid
                white;

            border-radius: 12px;

            background:
                white;

        }


        .current-logo-text {

            min-width: 0;

        }


        .current-logo-text strong {

            display: block;

            color:
                var(--sb-text);

            font-size: 10px;

            font-weight: 900;

        }


        .current-logo-text span {

            display: block;

            margin-top: 3px;

            color:
                var(--sb-muted);

            font-size: 8.5px;

            line-height: 1.5;

        }


        /* =========================================================
           CROP PREVIEW
        ========================================================== */

        .crop-preview-wrapper {

            display: none;

            margin-top: 11px;

            padding: 11px;

            border:
                1px solid
                var(--sb-blue-border);

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    #eff6ff,
                    #f8fbff
                );

        }


        .crop-preview-wrapper.active {

            display: block;

        }


        .crop-preview-title {

            display: flex;

            align-items: center;

            gap: 6px;

            margin-bottom: 8px;

            color:
                var(--sb-primary-dark);

            font-size: 9px;

            font-weight: 900;

        }


        .crop-preview {

            width: 78px;

            height: 78px;

            padding: 3px;

            border-radius: 18px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #60a5fa
                );

            box-shadow:
                0 8px 20px
                rgba(37,99,235,.15);

        }


        .crop-preview img {

            width: 100%;

            height: 100%;

            object-fit: cover;

            border:
                3px solid white;

            border-radius: 15px;

            background:
                white;

        }


        /* =========================================================
           ACTIONS
        ========================================================== */

        .actions {

            display: flex;

            align-items: center;

            justify-content: flex-end;

            gap: 8px;

            margin-top: 18px;

            padding-top: 15px;

            border-top:
                1px solid
                var(--sb-border-soft);

        }


        .btn {

            min-height: 42px;

            padding:
                0 15px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            cursor: pointer;

            border-radius: 10px;

            font-size: 10px;

            font-weight: 900;

            transition:
                transform .18s ease,
                box-shadow .18s ease,
                background .18s ease,
                border-color .18s ease;

        }


        .btn-secondary {

            color:
                var(--sb-text-2);

            background:
                #ffffff;

            border:
                1px solid
                var(--sb-border);

        }


        .btn-secondary:hover {

            background:
                #f8fafc;

            border-color:
                #cbd5e1;

            transform:
                translateY(-1px);

        }


        .btn-primary {

            color:
                #ffffff;

            border:
                1px solid
                var(--sb-primary-dark);

            background:

                linear-gradient(
                    135deg,
                    var(--sb-primary),
                    var(--sb-primary-dark)
                );

            box-shadow:
                0 9px 23px
                rgba(37,99,235,.20);

        }


        .btn-primary:hover {

            transform:
                translateY(-2px);

            box-shadow:
                0 13px 30px
                rgba(37,99,235,.28);

        }


        .btn-primary:disabled {

            opacity: .72;

            cursor:
                not-allowed;

            transform:
                none;

        }


        /* =========================================================
           PAYMENT QR
        ========================================================== */

        .qr-body {

            padding:
                18px;

            text-align: center;

        }


        .qr-box {

            width:
                min(220px, 100%);

            aspect-ratio: 1 / 1;

            margin:
                0 auto 14px;

            padding: 9px;

            display: grid;

            place-items: center;

            border:
                1px solid
                var(--sb-border);

            border-radius: 17px;

            background:
                #ffffff;

            box-shadow:
                0 12px 31px
                rgba(15,23,42,.07);

        }


        .qr-box img {

            width: 100%;

            height: 100%;

            display: block;

            object-fit: contain;

        }


        .qr-empty {

            color:
                var(--sb-muted-light);

            font-size: 9px;

            font-weight: 750;

            line-height: 1.2;

        }


        .qr-empty i {

            font-size: 40px;

            color:
                #cbd5e1;

        }


        .qr-title {

            color:
                var(--sb-text);

            font-size: 12px;

            font-weight: 900;

        }


        .qr-description {

            max-width: 370px;

            margin:
                5px auto 0;

            color:
                var(--sb-muted);

            font-size: 9px;

            line-height: 1.6;

        }


        .qr-live-badge {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            margin-top: 9px;

            padding:
                6px 9px;

            border:
                1px solid
                var(--sb-success-border);

            border-radius: 999px;

            color:
                #166534;

            background:
                var(--sb-success-soft);

            font-size: 8px;

            font-weight: 850;

        }


        .qr-live-badge i {

            font-size: 6px;

        }


        /* =========================================================
           QR MANAGEMENT
        ========================================================== */

        .qr-management {

            margin-top: 17px;

            padding-top: 15px;

            border-top:
                1px solid
                var(--sb-border-soft);

            text-align: left;

        }


        .qr-management-title {

            display: flex;

            align-items: center;

            gap: 7px;

            margin-bottom: 6px;

            color:
                var(--sb-text);

            font-size: 10px;

            font-weight: 900;

        }


        .qr-management-title i {

            color:
                var(--sb-primary);

        }


        .qr-management-description {

            margin-bottom: 10px;

            color:
                var(--sb-muted);

            font-size: 8.7px;

            line-height: 1.6;

        }


        .qr-upload {

            padding:
                10px;

            border:
                1px dashed
                #c6d4e3;

            border-radius: 12px;

            background:
                linear-gradient(
                    145deg,
                    #f8fbff,
                    #ffffff
                );

        }


        .qr-upload input[type="file"] {

            width: 100%;

            min-height: 40px;

            padding: 5px;

            cursor: pointer;

            border:
                1px solid
                #dbe3ec;

            border-radius: 9px;

            color:
                var(--sb-text-2);

            background:
                #ffffff;

            font-size: 9px;

        }


        .qr-upload input[type="file"]::file-selector-button {

            margin-right: 7px;

            padding:
                6px 9px;

            border: 0;

            border-radius: 7px;

            color:
                var(--sb-primary-dark);

            background:
                var(--sb-blue-soft);

            font-size: 8.5px;

            font-weight: 850;

            cursor: pointer;

        }


        .qr-upload-note {

            margin-top: 6px;

            color:
                var(--sb-muted-light);

            font-size: 8px;

            line-height: 1.5;

        }


        .qr-new-preview {

            display: none;

            margin-top: 10px;

            padding: 9px;

            border:
                1px solid
                var(--sb-blue-border);

            border-radius: 11px;

            background:
                linear-gradient(
                    135deg,
                    #eff6ff,
                    #f8fbff
                );

        }


        .qr-new-preview.active {

            display: block;

        }


        .qr-new-preview-title {

            display: flex;

            align-items: center;

            gap: 5px;

            margin-bottom: 7px;

            color:
                var(--sb-primary-dark);

            font-size: 8.5px;

            font-weight: 900;

        }


        .qr-new-image {

            width: 130px;

            height: 130px;

            margin:
                0 auto;

            padding: 7px;

            display: grid;

            place-items: center;

            border:
                1px solid
                var(--sb-border);

            border-radius: 13px;

            background:
                #ffffff;

            box-shadow:
                0 8px 21px
                rgba(15,23,42,.055);

        }


        .qr-new-image img {

            width: 100%;

            height: 100%;

            object-fit: contain;

            display: block;

        }


        .qr-actions {

            display: grid;

            grid-template-columns:
                1fr;

            gap: 7px;

            margin-top: 9px;

        }


        .qr-action-btn {

            width: 100%;

            min-height: 39px;

            padding:
                0 10px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            cursor: pointer;

            border-radius: 9px;

            font-size: 8.8px;

            font-weight: 900;

            transition:
                transform .18s ease,
                box-shadow .18s ease,
                background .18s ease;

        }


        .qr-action-save {

            color:
                #ffffff;

            border:
                1px solid
                var(--sb-primary-dark);

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary),
                    var(--sb-primary-dark)
                );

            box-shadow:
                0 7px 18px
                rgba(37,99,235,.17);

        }


        .qr-action-save:hover {

            transform:
                translateY(-1px);

            box-shadow:
                0 11px 24px
                rgba(37,99,235,.23);

        }


        .qr-action-save:disabled {

            opacity: .7;

            cursor:
                not-allowed;

            transform:
                none;

        }


        .qr-action-delete {

            color:
                #b91c1c;

            background:
                #ffffff;

            border:
                1px solid
                var(--sb-danger-border);

        }


        .qr-action-delete:hover {

            color:
                #991b1b;

            background:
                var(--sb-danger-soft);

            border-color:
                #fca5a5;

        }


        /* =========================================================
           CROP MODAL
        ========================================================== */

        .crop-modal {

            position: fixed;

            inset: 0;

            z-index: 99999;

            display: none;

            align-items: center;

            justify-content: center;

            padding: 15px;

            background:
                rgba(15,23,42,.76);

            backdrop-filter:
                blur(10px);

            -webkit-backdrop-filter:
                blur(10px);

        }


        .crop-modal.active {

            display: flex;

        }


        .crop-modal-card {

            width:
                min(960px, 100%);

            max-height:
                calc(100vh - 30px);

            overflow: hidden;

            border:
                1px solid
                rgba(255,255,255,.6);

            border-radius: 21px;

            background:
                #ffffff;

            box-shadow:
                0 40px 110px
                rgba(0,0,0,.36);

            animation:
                cropModalIn .22s ease;

        }


        @keyframes cropModalIn {

            from {

                opacity: 0;

                transform:
                    translateY(13px)
                    scale(.975);

            }

            to {

                opacity: 1;

                transform:
                    translateY(0)
                    scale(1);

            }

        }


        .crop-modal-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 12px;

            padding:
                14px 17px;

            border-bottom:
                1px solid
                var(--sb-border-soft);

        }


        .crop-modal-heading {

            display: flex;

            align-items: center;

            gap: 9px;

            min-width: 0;

        }


        .crop-modal-icon {

            width: 39px;

            height: 39px;

            flex: 0 0 39px;

            display: grid;

            place-items: center;

            border-radius: 11px;

            color:
                #ffffff;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary),
                    var(--sb-primary-dark)
                );

            box-shadow:
                0 8px 20px
                rgba(37,99,235,.20);

        }


        .crop-modal-title {

            color:
                var(--sb-text);

            font-size: 13px;

            font-weight: 900;

        }


        .crop-modal-subtitle {

            margin-top: 2px;

            color:
                var(--sb-muted);

            font-size: 8.8px;

        }


        .crop-close {

            width: 36px;

            height: 36px;

            flex: 0 0 36px;

            display: grid;

            place-items: center;

            cursor: pointer;

            border:
                1px solid
                var(--sb-border);

            border-radius: 9px;

            background:
                #f8fafc;

            color:
                #475569;

            font-size: 15px;

            transition:
                .18s ease;

        }


        .crop-close:hover {

            color:
                var(--sb-danger);

            background:
                var(--sb-danger-soft);

            border-color:
                var(--sb-danger-border);

        }


        /* =========================================================
           CROP WORKSPACE
        ========================================================== */

        .crop-workspace {

            display: grid;

            grid-template-columns:
                minmax(0, 1fr)
                190px;

            gap: 13px;

            padding: 13px;

            background:
                #f5f8fc;

        }


        .crop-stage {

            min-width: 0;

            min-height: 450px;

            display: flex;

            align-items: center;

            justify-content: center;

            overflow: hidden;

            border:
                1px solid
                #1e293b;

            border-radius: 15px;

            background:
                radial-gradient(
                    circle at center,
                    #334155,
                    #0f172a
                );

            box-shadow:
                inset 0 0 40px
                rgba(0,0,0,.26);

        }


        .crop-stage img {

            display: block;

            max-width: 100%;

        }


        .crop-side {

            display: flex;

            flex-direction: column;

            gap: 9px;

            min-width: 0;

        }


        .crop-info {

            padding:
                11px;

            border:
                1px solid
                var(--sb-border);

            border-radius: 11px;

            background:
                #ffffff;

        }


        .crop-info strong {

            display: block;

            margin-bottom: 4px;

            color:
                var(--sb-text);

            font-size: 10px;

            font-weight: 900;

        }


        .crop-info span {

            display: block;

            color:
                var(--sb-muted);

            font-size: 8.5px;

            line-height: 1.55;

        }


        .crop-tools {

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 6px;

        }


        .crop-tool {

            min-height: 38px;

            cursor: pointer;

            border:
                1px solid
                var(--sb-border);

            border-radius: 8px;

            background:
                #ffffff;

            color:
                var(--sb-text-2);

            font-size: 8.5px;

            font-weight: 850;

            transition:
                .18s ease;

        }


        .crop-tool:hover {

            color:
                var(--sb-primary-dark);

            border-color:
                var(--sb-blue-border);

            background:
                var(--sb-blue-soft);

        }


        .crop-modal-footer {

            display: flex;

            align-items: center;

            justify-content: flex-end;

            gap: 8px;

            padding:
                12px 14px;

            border-top:
                1px solid
                var(--sb-border-soft);

            background:
                #ffffff;

        }


        .crop-btn {

            min-height: 40px;

            padding:
                0 14px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            cursor: pointer;

            border-radius: 9px;

            font-size: 9px;

            font-weight: 900;

            transition:
                .18s ease;

        }


        .crop-btn-cancel {

            color:
                var(--sb-text-2);

            background:
                #ffffff;

            border:
                1px solid
                var(--sb-border);

        }


        .crop-btn-cancel:hover {

            background:
                #f8fafc;

        }


        .crop-btn-apply {

            color:
                #ffffff;

            border:
                1px solid
                var(--sb-primary-dark);

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary),
                    var(--sb-primary-dark)
                );

            box-shadow:
                0 8px 20px
                rgba(37,99,235,.19);

        }


        .crop-btn-apply:hover {

            transform:
                translateY(-1px);

            box-shadow:
                0 11px 26px
                rgba(37,99,235,.25);

        }


        /* =========================================================
           FOOTER
        ========================================================== */

        .page-footer {

            width: 100%;

            margin-top: 17px;

            padding-top: 3px;

            text-align: center;

            color:
                var(--sb-muted-light);

            font-size: 8px;

            font-weight: 650;

        }


        /* =========================================================
           LARGE DESKTOP
        ========================================================== */

        @media (min-width: 1500px) {

            .profile-page {

                padding-left:
                    clamp(22px, 1.7vw, 34px);

                padding-right:
                    clamp(22px, 1.7vw, 34px);

            }


            .main-grid {

                grid-template-columns:
                    minmax(0, 1.7fr)
                    minmax(330px, .6fr);

            }

        }


        /* =========================================================
           LAPTOP
        ========================================================== */

        @media (max-width: 1200px) {

            .main-grid {

                grid-template-columns:
                    minmax(0, 1.45fr)
                    minmax(285px, .65fr);

                gap: 14px;

            }


            .info-row {

                grid-template-columns:
                    145px
                    minmax(0, 1fr);

                gap: 13px;

            }


            .qr-body {

                padding-left: 14px;

                padding-right: 14px;

            }


            .qr-box {

                width: 195px;

            }

        }


        /* =========================================================
           TABLET
        ========================================================== */

        @media (max-width: 1020px) {

            .main-grid {

                grid-template-columns:
                    1fr;

            }


            .side-stack {

                display: grid;

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

                align-items: start;

            }


            .side-stack .card {

                height: 100%;

            }


            .qr-box {

                width:
                    min(210px, 100%);

            }

        }


        /* =========================================================
           SMALL TABLET
        ========================================================== */

        @media (max-width: 820px) {

            .profile-page {

                padding:
                    13px 13px 40px;

            }


            .profile-title-card {

                align-items: flex-start;

                flex-direction: column;

                min-height: auto;

                gap: 14px;

                padding: 18px;

            }


            .title-card-right {

                width: 100%;

            }


            .account-live {

                width: 100%;

                justify-content: center;

            }


            .profile-hero {

                padding: 18px;

            }


            .hero-content {

                align-items: flex-start;

            }


            .crop-workspace {

                grid-template-columns:
                    1fr;

            }


            .crop-side {

                display: grid;

                grid-template-columns:
                    1fr 1fr;

            }


            .crop-info {

                grid-column:
                    1 / -1;

            }


            .crop-stage {

                min-height: 390px;

            }

        }


        /* =========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 680px) {

            .profile-page {

                padding:
                    10px 10px 35px;

            }


            .title-card-left {

                align-items: flex-start;

            }


            .title-card-icon {

                width: 47px;

                height: 47px;

                flex-basis: 47px;

                border-radius: 13px;

            }


            .title-card-icon i {

                font-size: 16px;

            }


            .title-card-content h1 {

                font-size: 22px;

            }


            .title-card-content p {

                font-size: 9.5px;

            }


            .profile-hero {

                padding: 17px;

            }


            .hero-content {

                gap: 14px;

            }


            .avatar-wrap {

                flex-basis: 86px;

                width: 86px;

                height: 86px;

                border-radius: 23px;

            }


            .avatar {

                border-radius: 19px;

            }


            .hero-info h2 {

                font-size: 22px;

            }


            .hero-shop {

                font-size: 10px;

            }


            .hero-meta {

                margin-top: 9px;

            }


            .pill {

                min-height: 26px;

                font-size: 8px;

            }


            .side-stack {

                grid-template-columns:
                    1fr;

            }


            .form-grid {

                grid-template-columns:
                    1fr;

            }


            .field.full {

                grid-column:
                    auto;

            }


            .info-row {

                grid-template-columns:
                    1fr;

                gap: 3px;

                align-items:
                    start;

            }


            .info-label {

                font-size: 9px;

            }


            .info-value {

                font-size: 10.5px;

            }


            .actions {

                flex-direction:
                    column-reverse;

            }


            .btn {

                width: 100%;

            }


            .crop-modal {

                padding: 7px;

            }


            .crop-modal-card {

                max-height:
                    calc(100vh - 14px);

                border-radius: 16px;

            }


            .crop-workspace {

                padding: 8px;

            }


            .crop-stage {

                min-height: 320px;

            }

        }


        /* =========================================================
           SMALL MOBILE
        ========================================================== */

        @media (max-width: 480px) {

            .profile-page {

                padding:
                    8px 7px 30px;

            }


            .profile-title-card {

                border-radius: 18px;

                padding: 15px;

            }


            .title-card-left {

                gap: 10px;

            }


            .title-card-icon {

                width: 43px;

                height: 43px;

                flex-basis: 43px;

            }


            .title-card-content h1 {

                font-size: 20px;

            }


            .title-card-content p {

                font-size: 8.7px;

            }


            .profile-hero {

                padding: 15px;

                border-radius: 18px;

            }


            .hero-content {

                flex-direction:
                    column;

            }


            .avatar-wrap {

                width: 82px;

                height: 82px;

                flex-basis: 82px;

            }


            .hero-info {

                width: 100%;

            }


            .hero-info h2 {

                font-size: 21px;

            }


            .hero-meta {

                flex-direction:
                    column;

                align-items:
                    flex-start;

            }


            .pill {

                max-width: 100%;

            }


            .card-header {

                min-height: 59px;

                padding:
                    12px 13px;

            }


            .section-icon {

                width: 32px;

                height: 32px;

                flex-basis: 32px;

            }


            .section-title {

                font-size: 10.5px;

            }


            .card-header small {

                display:
                    none;

            }


            .info-body,
            .edit-body,
            .qr-body {

                padding-left:
                    13px;

                padding-right:
                    13px;

            }


            .current-logo {

                align-items:
                    flex-start;

            }


            .current-logo-frame {

                width: 57px;

                height: 57px;

                flex-basis: 57px;

            }


            .qr-box {

                width: 190px;

            }


            .qr-new-image {

                width: 120px;

                height: 120px;

            }


            .crop-modal-header {

                padding:
                    11px;

            }


            .crop-modal-subtitle {

                display:
                    none;

            }


            .crop-side {

                grid-template-columns:
                    1fr;

            }


            .crop-info {

                grid-column:
                    auto;

            }


            .crop-stage {

                min-height: 285px;

            }


            .crop-modal-footer {

                padding:
                    9px;

            }


            .crop-btn {

                flex: 1;

                padding-left: 8px;

                padding-right: 8px;

            }

        }


        /* =========================================================
           REDUCED MOTION
        ========================================================== */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {

                scroll-behavior:
                    auto !important;

                animation-duration:
                    .01ms !important;

                animation-iteration-count:
                    1 !important;

                transition-duration:
                    .01ms !important;

            }

        }

    </style>

</head>


<body>


{{-- =========================================================
     COMMON SELLER TASKBAR
========================================================== --}}

@include('seller.partials.topbar')


{{-- =========================================================
     COMMON SELLER MENU
========================================================== --}}

@include('seller.partials.seller-menu')


<main class="profile-page">


    {{-- =========================================================
         PREMIUM PAGE TITLE CARD
    ========================================================== --}}

    <section class="profile-title-card">

        <div class="title-card-left">

            <div class="title-card-icon">

                <i class="fa-solid fa-user-circle"></i>

            </div>


            <div class="title-card-content">

                <div class="title-card-eyebrow">

                    <i class="fa-solid fa-sparkles"></i>

                    Seller Center

                </div>


                <h1>
                    Seller Profile
                </h1>


                <p>
                    Manage your seller identity, shop information,
                    contact details and payment settings.
                </p>

            </div>

        </div>


        <div class="title-card-right">

            <div class="account-live">

                <span class="account-live-dot"></span>

                Seller Account Active

            </div>

        </div>

    </section>


    {{-- =========================================================
         ALERTS
    ========================================================== --}}

    @if(session('success'))

        <div class="alert alert-success">

            <span class="alert-icon">

                <i class="fa-solid fa-circle-check"></i>

            </span>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-error">

            <span class="alert-icon">

                <i class="fa-solid fa-circle-exclamation"></i>

            </span>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-error">

            <span class="alert-icon">

                <i class="fa-solid fa-triangle-exclamation"></i>

            </span>

            <div class="errors">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        </div>

    @endif


    {{-- =========================================================
         SELLER HERO
    ========================================================== --}}

    <section class="profile-hero">

        <div class="hero-content">


            {{-- AVATAR --}}

            <div class="avatar-wrap">

                <div class="avatar">

                    @if($logoUrl)

                        <img
                            src="{{ $logoUrl }}?v={{ optional($seller->updated_at)->timestamp ?? time() }}"
                            alt="{{ $seller->shop_name ?: 'Seller Logo' }}"
                            onerror="
                                this.style.display='none';
                                this.nextElementSibling.style.display='grid';
                            "
                        >

                    @endif


                    <div
                        class="avatar-fallback"
                        style="{{ $logoUrl ? 'display:none;' : 'display:grid;' }}"
                    >

                        {{ $initials }}

                    </div>

                </div>


                <span class="online-dot"></span>

            </div>


            {{-- SELLER INFORMATION --}}

            <div class="hero-info">

                <h2>
                    {{ $seller->seller_name ?: 'Seller' }}
                </h2>


                <div class="hero-shop">

                    <i class="fa-solid fa-store"></i>

                    <span>
                        {{ $seller->shop_name ?: 'Your Shop' }}
                    </span>

                </div>


                <div class="hero-meta">

                    <span class="pill green">

                        <i class="fa-solid fa-circle"></i>

                        Active Seller

                    </span>


                    <span class="pill blue">

                        <i class="fa-solid fa-id-card"></i>

                        Seller ID #{{ $seller->id }}

                    </span>


                    @if($seller->email)

                        <span class="pill">

                            <i class="fa-solid fa-envelope"></i>

                            {{ $seller->email }}

                        </span>

                    @endif

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
         MAIN FULL WIDTH GRID
    ========================================================== --}}

    <div class="main-grid">


        {{-- =====================================================
             LEFT COLUMN
        ====================================================== --}}

        <div class="left-stack">


            {{-- =================================================
                 ACCOUNT INFORMATION
            ================================================== --}}

            <section class="card">

                <div class="card-header">

                    <div class="section-title">

                        <div class="section-icon">

                            <i class="fa-solid fa-address-card"></i>

                        </div>

                        <span>
                            Account Information
                        </span>

                    </div>


                    <small>
                        Seller account details
                    </small>

                </div>


                <div class="info-body">


                    <div class="info-row">

                        <div class="info-label">
                            Seller Name
                        </div>

                        <div class="info-value">
                            {{ $seller->seller_name ?: '—' }}
                        </div>

                    </div>


                    <div class="info-row">

                        <div class="info-label">
                            Shop Name
                        </div>

                        <div class="info-value">
                            {{ $seller->shop_name ?: '—' }}
                        </div>

                    </div>


                    <div class="info-row">

                        <div class="info-label">
                            Email Address
                        </div>

                        <div class="info-value">
                            {{ $seller->email ?: '—' }}
                        </div>

                    </div>


                    <div class="info-row">

                        <div class="info-label">
                            Mobile Number
                        </div>

                        <div class="info-value">
                            {{ $seller->mobile_number ?: '—' }}
                        </div>

                    </div>


                    <div class="info-row">

                        <div class="info-label">
                            Shop Address
                        </div>

                        <div class="info-value">
                            {{ $seller->shop_address ?: '—' }}
                        </div>

                    </div>


                    <div class="info-row">

                        <div class="info-label">
                            City
                        </div>

                        <div class="info-value">
                            {{ $seller->city ?: '—' }}
                        </div>

                    </div>


                    <div class="info-row">

                        <div class="info-label">
                            State
                        </div>

                        <div class="info-value">
                            {{ $seller->state ?: '—' }}
                        </div>

                    </div>


                    <div class="info-row">

                        <div class="info-label">
                            Pincode
                        </div>

                        <div class="info-value">
                            {{ $seller->pincode ?: '—' }}
                        </div>

                    </div>


                    <div class="info-row">

                        <div class="info-label">
                            GST Number
                        </div>

                        <div class="info-value">
                            {{ $seller->gst_number ?: '—' }}
                        </div>

                    </div>


                    <div class="info-row">

                        <div class="info-label">
                            Registration Date
                        </div>

                        <div class="info-value">
                            {{ $registeredAt }}
                        </div>

                    </div>


                    <div class="info-row">

                        <div class="info-label">
                            Last Updated
                        </div>

                        <div class="info-value">
                            {{ $updatedAt }}
                        </div>

                    </div>

                </div>

            </section>


            {{-- =================================================
                 EDIT ACCOUNT
            ================================================== --}}

            <section class="card">

                <div class="card-header">

                    <div class="section-title">

                        <div class="section-icon">

                            <i class="fa-solid fa-pen-to-square"></i>

                        </div>

                        <span>
                            Edit Account Information
                        </span>

                    </div>


                    <small>
                        Update seller profile
                    </small>

                </div>


                <div class="edit-body">


                    <div class="edit-intro">

                        <div>

                            <strong>
                                Keep your seller information updated.
                            </strong>

                            Update your personal, shop, contact
                            and business information below.

                        </div>

                    </div>


                    <form
                        id="sellerProfileForm"
                        action="{{ route('seller.profile.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf

                        @method('PUT')


                        <div class="form-grid">


                            {{-- SELLER NAME --}}

                            <div class="field">

                                <label>

                                    Seller Name

                                    <span class="required">
                                        *
                                    </span>

                                </label>


                                <input
                                    type="text"
                                    name="seller_name"
                                    value="{{ old('seller_name', $seller->seller_name) }}"
                                    placeholder="Enter seller name"
                                    maxlength="100"
                                    autocomplete="name"
                                    required
                                >

                            </div>


                            {{-- SHOP NAME --}}

                            <div class="field">

                                <label>

                                    Shop Name

                                    <span class="required">
                                        *
                                    </span>

                                </label>


                                <input
                                    type="text"
                                    name="shop_name"
                                    value="{{ old('shop_name', $seller->shop_name) }}"
                                    placeholder="Enter shop name"
                                    maxlength="150"
                                    required
                                >

                            </div>


                            {{-- EMAIL --}}

                            <div class="field">

                                <label>

                                    Email Address

                                    <span class="required">
                                        *
                                    </span>

                                </label>


                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $seller->email) }}"
                                    placeholder="seller@example.com"
                                    maxlength="150"
                                    autocomplete="email"
                                    required
                                >

                            </div>


                            {{-- MOBILE --}}

                            <div class="field">

                                <label>

                                    Mobile Number

                                    <span class="required">
                                        *
                                    </span>

                                </label>


                                <input
                                    type="text"
                                    name="mobile_number"
                                    value="{{ old('mobile_number', $seller->mobile_number) }}"
                                    placeholder="Enter mobile number"
                                    maxlength="15"
                                    inputmode="numeric"
                                    autocomplete="tel"
                                    required
                                >

                            </div>


                            {{-- ADDRESS --}}

                            <div class="field full">

                                <label>
                                    Shop Address
                                </label>


                                <textarea
                                    name="shop_address"
                                    placeholder="Enter complete shop address"
                                    maxlength="500"
                                >{{ old('shop_address', $seller->shop_address) }}</textarea>


                                <div class="field-note">

                                    Enter your complete
                                    business/shop address.

                                </div>

                            </div>


                            {{-- CITY --}}

                            <div class="field">

                                <label>
                                    City
                                </label>


                                <input
                                    type="text"
                                    name="city"
                                    value="{{ old('city', $seller->city) }}"
                                    placeholder="Enter city"
                                    maxlength="100"
                                >

                            </div>


                            {{-- STATE --}}

                            <div class="field">

                                <label>
                                    State
                                </label>


                                <input
                                    type="text"
                                    name="state"
                                    value="{{ old('state', $seller->state) }}"
                                    placeholder="Enter state"
                                    maxlength="100"
                                >

                            </div>


                            {{-- PINCODE --}}

                            <div class="field">

                                <label>
                                    Pincode
                                </label>


                                <input
                                    type="text"
                                    name="pincode"
                                    value="{{ old('pincode', $seller->pincode) }}"
                                    placeholder="Enter pincode"
                                    maxlength="10"
                                    inputmode="numeric"
                                >

                            </div>


                            {{-- GST --}}

                            <div class="field">

                                <label>
                                    GST Number
                                </label>


                                <input
                                    type="text"
                                    name="gst_number"
                                    value="{{ old('gst_number', $seller->gst_number) }}"
                                    placeholder="Enter GST number"
                                    maxlength="30"
                                    style="text-transform:uppercase;"
                                >

                            </div>


                            {{-- SHOP LOGO --}}

                            <div class="field full">

                                <label>
                                    Shop Logo / Profile Photo
                                </label>


                                <div class="upload-box">


                                    @if($logoUrl)

                                        <div class="current-logo">

                                            <div class="current-logo-frame">

                                                <img
                                                    src="{{ $logoUrl }}?v={{ optional($seller->updated_at)->timestamp ?? time() }}"
                                                    alt="Current Shop Logo"
                                                    onerror="
                                                        this.style.display='none';
                                                    "
                                                >

                                            </div>


                                            <div class="current-logo-text">

                                                <strong>
                                                    Current Shop Logo
                                                </strong>


                                                <span>

                                                    Select a new image
                                                    below to replace the
                                                    existing logo.

                                                </span>

                                            </div>

                                        </div>

                                    @endif


                                    <input
                                        type="file"
                                        id="shopLogoInput"
                                        name="shop_logo"
                                        accept="image/jpeg,image/png,image/jpg,image/webp"
                                    >


                                    <div class="upload-note">

                                        JPG, PNG or WEBP ·
                                        Maximum 4 MB ·
                                        Image will open in the
                                        crop editor before saving.

                                    </div>


                                    <div
                                        class="crop-preview-wrapper"
                                        id="cropPreviewWrapper"
                                    >

                                        <div class="crop-preview-title">

                                            <i class="fa-solid fa-circle-check"></i>

                                            Cropped Logo Preview

                                        </div>


                                        <div class="crop-preview">

                                            <img
                                                id="croppedLogoPreview"
                                                src=""
                                                alt="Cropped Logo Preview"
                                            >

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- FORM ACTIONS --}}

                        <div class="actions">


                            <a
                                href="{{ route('seller.profile') }}"
                                class="btn btn-secondary"
                            >

                                <i class="fa-solid fa-rotate-left"></i>

                                Reset

                            </a>


                            <button
                                type="submit"
                                class="btn btn-primary"
                                id="saveProfileBtn"
                            >

                                <i class="fa-solid fa-floppy-disk"></i>

                                Save All Changes

                            </button>

                        </div>

                    </form>

                </div>

            </section>

        </div>


        {{-- =====================================================
             RIGHT COLUMN
        ====================================================== --}}

        <div class="side-stack">


            {{-- =================================================
                 PAYMENT QR
            ================================================== --}}

            <section class="card">

                <div class="card-header">

                    <div class="section-title">

                        <div class="section-icon">

                            <i class="fa-solid fa-qrcode"></i>

                        </div>

                        <span>
                            Payment QR
                        </span>

                    </div>


                    <small>
                        UPI payments
                    </small>

                </div>


                <div class="qr-body">


                    @if($qrUrl)

                        <div class="qr-box">

                            <img
                                src="{{ $qrUrl }}?v={{ optional($seller->updated_at)->timestamp ?? time() }}"
                                alt="Seller Payment QR"
                            >

                        </div>


                        <div class="qr-title">
                            Current Payment QR
                        </div>


                        <div class="qr-description">

                            Customers can use this seller-level
                            QR when they choose UPI payment.

                        </div>


                        <div class="qr-live-badge">

                            <i class="fa-solid fa-circle"></i>

                            Active seller QR

                        </div>

                    @else

                        <div class="qr-box">

                            <div class="qr-empty">

                                <i class="fa-solid fa-qrcode"></i>

                                <br><br>

                                No QR uploaded

                            </div>

                        </div>


                        <div class="qr-title">

                            Payment QR Not Set

                        </div>


                        <div class="qr-description">

                            Upload your seller payment QR below
                            to receive customer UPI payments.

                        </div>

                    @endif


                    {{-- CHANGE QR --}}

                    <div class="qr-management">


                        <div class="qr-management-title">

                            <i class="fa-solid fa-arrows-rotate"></i>

                            Change Payment QR

                        </div>


                        <div class="qr-management-description">

                            Upload a clear UPI QR image.
                            After saving, the new QR will become
                            the latest QR for your seller account.

                        </div>


                        <form
                            id="paymentQrForm"
                            action="{{ route('seller.payment-qr.update') }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >

                            @csrf


                            <div class="qr-upload">

                                <input
                                    type="file"
                                    id="paymentQrInput"
                                    name="payment_qr"
                                    accept="image/jpeg,image/png,image/jpg,image/webp"
                                    required
                                >


                                <div class="qr-upload-note">

                                    JPG, PNG or WEBP ·
                                    Maximum 2 MB ·
                                    Use a clear and complete QR image.

                                </div>


                                <div
                                    class="qr-new-preview"
                                    id="qrNewPreview"
                                >

                                    <div class="qr-new-preview-title">

                                        <i class="fa-solid fa-circle-check"></i>

                                        New QR Preview

                                    </div>


                                    <div class="qr-new-image">

                                        <img
                                            id="qrNewPreviewImage"
                                            src=""
                                            alt="New Payment QR Preview"
                                        >

                                    </div>

                                </div>


                                <div class="qr-actions">

                                    <button
                                        type="submit"
                                        class="qr-action-btn qr-action-save"
                                        id="saveQrBtn"
                                    >

                                        <i class="fa-solid fa-cloud-arrow-up"></i>

                                        Change QR

                                    </button>

                                </div>

                            </div>

                        </form>


                        {{-- DELETE CURRENT QR --}}

                        @if($qrUrl)

                            <form
                                action="{{ route('seller.payment-qr.delete') }}"
                                method="POST"
                                style="margin-top:8px;"
                                onsubmit="
                                    return confirm(
                                        'Are you sure you want to remove your current payment QR?'
                                    );
                                "
                            >

                                @csrf

                                @method('DELETE')


                                <button
                                    type="submit"
                                    class="qr-action-btn qr-action-delete"
                                >

                                    <i class="fa-solid fa-trash-can"></i>

                                    Remove Current QR

                                </button>

                            </form>

                        @endif

                    </div>

                </div>

            </section>


            {{-- =================================================
                 ACCOUNT STATUS
            ================================================== --}}

            <section class="card">

                <div class="card-header">

                    <div class="section-title">

                        <div class="section-icon">

                            <i class="fa-solid fa-shield-halved"></i>

                        </div>

                        <span>
                            Account Status
                        </span>

                    </div>

                </div>


                <div class="info-body">


                    <div class="info-row">

                        <div class="info-label">
                            Account
                        </div>


                        <div class="info-value">

                            <span class="status-value">

                                <span class="status-dot"></span>

                                Active

                            </span>

                        </div>

                    </div>


                    @if(isset($seller->verification_status))

                        <div class="info-row">

                            <div class="info-label">
                                Verification
                            </div>


                            <div class="info-value">

                                {{ ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $seller->verification_status
                                    )
                                ) }}

                            </div>

                        </div>

                    @endif


                    <div class="info-row">

                        <div class="info-label">
                            Seller ID
                        </div>


                        <div class="info-value">
                            #{{ $seller->id }}
                        </div>

                    </div>


                    <div class="info-row">

                        <div class="info-label">
                            Registered
                        </div>


                        <div class="info-value">
                            {{ $registeredAt }}
                        </div>

                    </div>


                    <div class="info-row">

                        <div class="info-label">
                            Last Updated
                        </div>


                        <div class="info-value">
                            {{ $updatedAt }}
                        </div>

                    </div>

                </div>

            </section>

        </div>

    </div>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}

    <div class="page-footer">

        Smart Basket Seller Center ·
        Secure Seller Profile

    </div>

</main>


{{-- =========================================================
     CROP MODAL
========================================================== --}}

<div
    class="crop-modal"
    id="cropModal"
    aria-hidden="true"
>

    <div class="crop-modal-card">


        <div class="crop-modal-header">

            <div class="crop-modal-heading">

                <div class="crop-modal-icon">

                    <i class="fa-solid fa-crop-simple"></i>

                </div>


                <div>

                    <div class="crop-modal-title">
                        Adjust Your Shop Logo
                    </div>


                    <div class="crop-modal-subtitle">

                        Crop, zoom or rotate your image
                        before saving.

                    </div>

                </div>

            </div>


            <button
                type="button"
                class="crop-close"
                id="cropClose"
                aria-label="Close crop editor"
            >

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>


        <div class="crop-workspace">


            <div class="crop-stage">

                <img
                    id="cropImage"
                    src=""
                    alt="Crop Image"
                >

            </div>


            <div class="crop-side">


                <div class="crop-info">

                    <strong>
                        Logo Crop Area
                    </strong>


                    <span>

                        Adjust the crop area,
                        zoom or rotate the image
                        before applying.

                    </span>

                </div>


                <div class="crop-tools">


                    <button
                        type="button"
                        class="crop-tool"
                        id="zoomOut"
                    >

                        <i class="fa-solid fa-minus"></i>

                        Zoom Out

                    </button>


                    <button
                        type="button"
                        class="crop-tool"
                        id="zoomIn"
                    >

                        <i class="fa-solid fa-plus"></i>

                        Zoom In

                    </button>


                    <button
                        type="button"
                        class="crop-tool"
                        id="rotateLeft"
                    >

                        <i class="fa-solid fa-rotate-left"></i>

                        Rotate

                    </button>


                    <button
                        type="button"
                        class="crop-tool"
                        id="rotateRight"
                    >

                        <i class="fa-solid fa-rotate-right"></i>

                        Rotate

                    </button>


                    <button
                        type="button"
                        class="crop-tool"
                        id="resetCrop"
                        style="grid-column:1/-1;"
                    >

                        <i class="fa-solid fa-rotate"></i>

                        Reset Crop

                    </button>

                </div>

            </div>

        </div>


        <div class="crop-modal-footer">


            <button
                type="button"
                class="crop-btn crop-btn-cancel"
                id="cropCancel"
            >

                <i class="fa-solid fa-xmark"></i>

                Cancel

            </button>


            <button
                type="button"
                class="crop-btn crop-btn-apply"
                id="cropApply"
            >

                <i class="fa-solid fa-check"></i>

                Apply Crop

            </button>

        </div>

    </div>

</div>


<script
    src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js">
</script>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /* =========================================================
           SHOP LOGO CROPPER
        ========================================================== */

        const fileInput =
            document.getElementById(
                'shopLogoInput'
            );


        const cropModal =
            document.getElementById(
                'cropModal'
            );


        const cropImage =
            document.getElementById(
                'cropImage'
            );


        const cropClose =
            document.getElementById(
                'cropClose'
            );


        const cropCancel =
            document.getElementById(
                'cropCancel'
            );


        const cropApply =
            document.getElementById(
                'cropApply'
            );


        const zoomIn =
            document.getElementById(
                'zoomIn'
            );


        const zoomOut =
            document.getElementById(
                'zoomOut'
            );


        const rotateLeft =
            document.getElementById(
                'rotateLeft'
            );


        const rotateRight =
            document.getElementById(
                'rotateRight'
            );


        const resetCrop =
            document.getElementById(
                'resetCrop'
            );


        const cropPreviewWrapper =
            document.getElementById(
                'cropPreviewWrapper'
            );


        const croppedLogoPreview =
            document.getElementById(
                'croppedLogoPreview'
            );


        let cropper = null;

        let selectedObjectUrl = null;


        if (
            fileInput &&
            cropModal &&
            cropImage
        ) {


            fileInput.addEventListener(
                'change',
                function (event) {

                    const file =
                        event.target.files[0];


                    if (!file) {

                        return;

                    }


                    const allowedTypes = [

                        'image/jpeg',

                        'image/png',

                        'image/jpg',

                        'image/webp'

                    ];


                    if (
                        !allowedTypes.includes(
                            file.type
                        )
                    ) {

                        alert(
                            'Please select JPG, PNG or WEBP image.'
                        );

                        fileInput.value = '';

                        return;

                    }


                    if (
                        file.size >
                        4 * 1024 * 1024
                    ) {

                        alert(
                            'Image size must be less than 4 MB.'
                        );

                        fileInput.value = '';

                        return;

                    }


                    if (selectedObjectUrl) {

                        URL.revokeObjectURL(
                            selectedObjectUrl
                        );

                    }


                    selectedObjectUrl =
                        URL.createObjectURL(
                            file
                        );


                    cropImage.src =
                        selectedObjectUrl;


                    cropModal.classList.add(
                        'active'
                    );


                    cropModal.setAttribute(
                        'aria-hidden',
                        'false'
                    );


                    document.body.style.overflow =
                        'hidden';


                    if (cropper) {

                        cropper.destroy();

                        cropper = null;

                    }


                    cropImage.onload =
                        function () {

                            cropper =
                                new Cropper(
                                    cropImage,
                                    {

                                        aspectRatio: 1,

                                        viewMode: 1,

                                        dragMode: 'move',

                                        autoCropArea: .88,

                                        responsive: true,

                                        restore: true,

                                        guides: true,

                                        center: true,

                                        highlight: false,

                                        cropBoxMovable: false,

                                        cropBoxResizable: true,

                                        toggleDragModeOnDblclick:
                                            false,

                                        background: false,

                                        modal: true,

                                        zoomable: true,

                                        zoomOnWheel: true,

                                        wheelZoomRatio: .08,

                                        rotatable: true,

                                        scalable: true,

                                        checkOrientation: true,

                                        minContainerWidth: 300,

                                        minContainerHeight: 300,

                                        ready:
                                            function () {

                                                try {

                                                    const
                                                        containerData =
                                                        cropper
                                                            .getContainerData();


                                                    const
                                                        cropBoxSize =
                                                        Math.min(
                                                            containerData.width,
                                                            containerData.height
                                                        ) * .82;


                                                    cropper
                                                        .setCropBoxData(
                                                            {

                                                                width:
                                                                    cropBoxSize,

                                                                height:
                                                                    cropBoxSize,

                                                                left:
                                                                    (
                                                                        containerData.width -
                                                                        cropBoxSize
                                                                    ) / 2,

                                                                top:
                                                                    (
                                                                        containerData.height -
                                                                        cropBoxSize
                                                                    ) / 2

                                                            }
                                                        );

                                                } catch (error) {

                                                    console.error(
                                                        'Crop box initialization:',
                                                        error
                                                    );

                                                }

                                            }

                                    }
                                );

                        };

                }
            );


            zoomIn.addEventListener(
                'click',
                function () {

                    if (cropper) {

                        cropper.zoom(.12);

                    }

                }
            );


            zoomOut.addEventListener(
                'click',
                function () {

                    if (cropper) {

                        cropper.zoom(-.12);

                    }

                }
            );


            rotateLeft.addEventListener(
                'click',
                function () {

                    if (cropper) {

                        cropper.rotate(-90);

                    }

                }
            );


            rotateRight.addEventListener(
                'click',
                function () {

                    if (cropper) {

                        cropper.rotate(90);

                    }

                }
            );


            resetCrop.addEventListener(
                'click',
                function () {

                    if (cropper) {

                        cropper.reset();

                    }

                }
            );


            cropApply.addEventListener(
                'click',
                function () {

                    if (!cropper) {

                        return;

                    }


                    const canvas =
                        cropper.getCroppedCanvas(
                            {

                                width: 1200,

                                height: 1200,

                                minWidth: 800,

                                minHeight: 800,

                                maxWidth: 1600,

                                maxHeight: 1600,

                                fillColor:
                                    '#ffffff',

                                imageSmoothingEnabled:
                                    true,

                                imageSmoothingQuality:
                                    'high'

                            }
                        );


                    if (!canvas) {

                        alert(
                            'Unable to crop this image. Please try another image.'
                        );

                        return;

                    }


                    const previewUrl =
                        canvas.toDataURL(
                            'image/jpeg',
                            .94
                        );


                    croppedLogoPreview.src =
                        previewUrl;


                    cropPreviewWrapper.classList.add(
                        'active'
                    );


                    canvas.toBlob(
                        function (blob) {

                            if (!blob) {

                                alert(
                                    'Unable to prepare cropped image.'
                                );

                                return;

                            }


                            const croppedFile =
                                new File(
                                    [
                                        blob
                                    ],
                                    'shop-logo-cropped.jpg',
                                    {

                                        type:
                                            'image/jpeg',

                                        lastModified:
                                            Date.now()

                                    }
                                );


                            try {

                                const
                                    dataTransfer =
                                    new DataTransfer();


                                dataTransfer.items.add(
                                    croppedFile
                                );


                                fileInput.files =
                                    dataTransfer.files;

                            } catch (error) {

                                console.error(
                                    'File replacement error:',
                                    error
                                );

                                alert(
                                    'Your browser could not prepare the cropped image. Please try again.'
                                );

                                return;

                            }


                            closeCropper();

                        },
                        'image/jpeg',
                        .94
                    );

                }
            );


            function closeCropper() {

                cropModal.classList.remove(
                    'active'
                );


                cropModal.setAttribute(
                    'aria-hidden',
                    'true'
                );


                document.body.style.overflow =
                    '';


                if (cropper) {

                    cropper.destroy();

                    cropper = null;

                }

            }


            function cancelCrop() {

                closeCropper();

                fileInput.value = '';

                cropPreviewWrapper.classList.remove(
                    'active'
                );

                croppedLogoPreview.src = '';

            }


            cropClose.addEventListener(
                'click',
                cancelCrop
            );


            cropCancel.addEventListener(
                'click',
                cancelCrop
            );


            cropModal.addEventListener(
                'click',
                function (event) {

                    if (
                        event.target === cropModal
                    ) {

                        cancelCrop();

                    }

                }
            );


            document.addEventListener(
                'keydown',
                function (event) {

                    if (
                        event.key === 'Escape' &&
                        cropModal.classList.contains(
                            'active'
                        )
                    ) {

                        cancelCrop();

                    }

                }
            );


            window.addEventListener(
                'beforeunload',
                function () {

                    if (selectedObjectUrl) {

                        URL.revokeObjectURL(
                            selectedObjectUrl
                        );

                    }

                }
            );

        }


        /* =========================================================
           PROFILE FORM LOADING
        ========================================================== */

        const sellerProfileForm =
            document.getElementById(
                'sellerProfileForm'
            );


        const saveProfileBtn =
            document.getElementById(
                'saveProfileBtn'
            );


        if (
            sellerProfileForm &&
            saveProfileBtn
        ) {

            sellerProfileForm.addEventListener(
                'submit',
                function () {

                    saveProfileBtn.disabled =
                        true;

                    saveProfileBtn.innerHTML =
                        '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

                }
            );

        }


        /* =========================================================
           PAYMENT QR PREVIEW
        ========================================================== */

        const paymentQrInput =
            document.getElementById(
                'paymentQrInput'
            );


        const qrNewPreview =
            document.getElementById(
                'qrNewPreview'
            );


        const qrNewPreviewImage =
            document.getElementById(
                'qrNewPreviewImage'
            );


        const saveQrBtn =
            document.getElementById(
                'saveQrBtn'
            );


        let qrObjectUrl = null;


        if (
            paymentQrInput &&
            qrNewPreview &&
            qrNewPreviewImage
        ) {


            paymentQrInput.addEventListener(
                'change',
                function (event) {

                    const file =
                        event.target.files[0];


                    if (!file) {

                        qrNewPreview.classList.remove(
                            'active'
                        );

                        qrNewPreviewImage.src = '';

                        return;

                    }


                    const allowedTypes = [

                        'image/jpeg',

                        'image/png',

                        'image/jpg',

                        'image/webp'

                    ];


                    if (
                        !allowedTypes.includes(
                            file.type
                        )
                    ) {

                        alert(
                            'Please select a JPG, PNG or WEBP QR image.'
                        );

                        paymentQrInput.value = '';

                        qrNewPreview.classList.remove(
                            'active'
                        );

                        return;

                    }


                    if (
                        file.size >
                        2 * 1024 * 1024
                    ) {

                        alert(
                            'Payment QR image must be less than 2 MB.'
                        );

                        paymentQrInput.value = '';

                        qrNewPreview.classList.remove(
                            'active'
                        );

                        return;

                    }


                    if (qrObjectUrl) {

                        URL.revokeObjectURL(
                            qrObjectUrl
                        );

                    }


                    qrObjectUrl =
                        URL.createObjectURL(
                            file
                        );


                    qrNewPreviewImage.src =
                        qrObjectUrl;


                    qrNewPreview.classList.add(
                        'active'
                    );

                }
            );

        }


        /* =========================================================
           QR FORM LOADING STATE
        ========================================================== */

        const paymentQrForm =
            document.getElementById(
                'paymentQrForm'
            );


        if (
            paymentQrForm &&
            saveQrBtn
        ) {

            paymentQrForm.addEventListener(
                'submit',
                function (event) {

                    if (
                        !paymentQrInput ||
                        !paymentQrInput.files.length
                    ) {

                        alert(
                            'Please select a new payment QR first.'
                        );

                        event.preventDefault();

                        return;

                    }


                    saveQrBtn.disabled =
                        true;


                    saveQrBtn.innerHTML =
                        '<i class="fa-solid fa-spinner fa-spin"></i> Updating...';

                }
            );

        }


        /* =========================================================
           CLEAN QR OBJECT URL
        ========================================================== */

        window.addEventListener(
            'beforeunload',
            function () {

                if (qrObjectUrl) {

                    URL.revokeObjectURL(
                        qrObjectUrl
                    );

                }

            }
        );

    }
);

</script>


</body>

</html>
