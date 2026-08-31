{{-- resources/views/seller/profile.blade.php --}}

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Seller Profile | Smart Basket</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    {{-- Cropper.js --}}
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
            $logoPath = ltrim($seller->shop_logo, '/');

            if (str_starts_with($logoPath, 'storage/')) {
                $logoUrl = asset($logoPath);
            } else {
                $logoUrl = Storage::disk('public')->url($logoPath);
            }
        }

        $qrUrl = null;

        if (!empty($seller->payment_qr)) {
            $qrPath = ltrim($seller->payment_qr, '/');

            if (str_starts_with($qrPath, 'storage/')) {
                $qrUrl = asset($qrPath);
            } else {
                $qrUrl = Storage::disk('public')->url($qrPath);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | INITIALS
        |--------------------------------------------------------------------------
        */

        $sellerName = $seller->seller_name ?: 'Seller';

        $words = preg_split('/\s+/', trim($sellerName));

        if (count($words) >= 2) {
            $initials = strtoupper(
                substr($words[0], 0, 1) .
                substr($words[count($words) - 1], 0, 1)
            );
        } else {
            $initials = strtoupper(substr($sellerName, 0, 2));
        }

        /*
        |--------------------------------------------------------------------------
        | DATES
        |--------------------------------------------------------------------------
        */

        $registeredAt = $seller->created_at
            ? $seller->created_at->format('d M Y, h:i A')
            : '—';

        $updatedAt = $seller->updated_at
            ? $seller->updated_at->format('d M Y, h:i A')
            : '—';
    @endphp


    <style>

        /* =========================================================
           SMART BASKET — SELLER PROFILE
           PREMIUM PROFILE + LARGE LOGO CROPPER
        ========================================================= */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #f4f7fb;
            --card: #ffffff;
            --card-soft: #f8fafc;

            --border: #e5e7eb;
            --border-soft: #edf0f4;

            --text: #111827;
            --text-2: #334155;
            --muted: #64748b;
            --muted-2: #94a3b8;

            --primary: #4f46e5;
            --primary-2: #7c3aed;

            --success: #16a34a;
            --danger: #dc2626;

            --shadow-sm:
                0 4px 14px rgba(15, 23, 42, .06);

            --shadow:
                0 18px 55px rgba(15, 23, 42, .08);

            --shadow-lg:
                0 30px 80px rgba(15, 23, 42, .11);
        }


        html {
            background: var(--bg);
        }


        body {
            min-height: 100vh;

            color: var(--text);

            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:
                radial-gradient(
                    circle at 5% 0%,
                    rgba(99, 102, 241, .10),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 95% 5%,
                    rgba(124, 58, 237, .08),
                    transparent 25%
                ),
                linear-gradient(
                    145deg,
                    #f8fafc 0%,
                    #f3f6fa 48%,
                    #eef2f7 100%
                );

            overflow-x: hidden;
        }


        body::before {
            content: "";

            position: fixed;
            inset: 0;

            pointer-events: none;

            opacity: .45;

            background-image:
                linear-gradient(
                    rgba(15,23,42,.025) 1px,
                    transparent 1px
                ),
                linear-gradient(
                    90deg,
                    rgba(15,23,42,.025) 1px,
                    transparent 1px
                );

            background-size: 42px 42px;

            mask-image:
                linear-gradient(
                    to bottom,
                    black,
                    transparent 85%
                );
        }


        a {
            color: inherit;
            text-decoration: none;
        }


        button,
        input,
        textarea,
        select {
            font: inherit;
        }


        /* =========================================================
           PAGE
        ========================================================= */

        .profile-page {
            width: min(1400px, calc(100% - 36px));

            margin: 0 auto;

            padding: 30px 0 70px;

            position: relative;
            z-index: 1;
        }


        /* =========================================================
           TOPBAR
        ========================================================= */

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 24px;
        }


        .brand {
            display: flex;
            align-items: center;

            gap: 12px;
        }


        .brand-icon {
            width: 46px;
            height: 46px;

            border-radius: 14px;

            display: grid;
            place-items: center;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary-2)
                );

            box-shadow:
                0 12px 28px rgba(79,70,229,.22);
        }


        .brand-icon span {
            font-size: 16px;
            font-weight: 950;
            letter-spacing: -.7px;
        }


        .brand-title {
            color: var(--text);

            font-size: 17px;
            font-weight: 900;

            letter-spacing: -.3px;
        }


        .brand-subtitle {
            margin-top: 2px;

            color: var(--muted);

            font-size: 12px;
            font-weight: 550;
        }


        .back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            min-height: 42px;

            padding: 0 15px;

            border:
                1px solid var(--border);

            border-radius: 12px;

            background: rgba(255,255,255,.85);

            color: var(--text-2);

            font-size: 13px;
            font-weight: 750;

            box-shadow: var(--shadow-sm);

            transition: .2s ease;
        }


        .back-btn:hover {
            color: var(--primary);

            border-color:
                rgba(79,70,229,.25);

            transform: translateY(-1px);

            box-shadow:
                0 8px 22px rgba(15,23,42,.09);
        }


        /* =========================================================
           ALERTS
        ========================================================= */

        .alert {
            display: flex;
            align-items: flex-start;

            gap: 10px;

            margin-bottom: 18px;

            padding: 14px 16px;

            border-radius: 13px;

            font-size: 13px;
            font-weight: 700;
        }


        .alert-success {
            color: #166534;

            background: #f0fdf4;

            border:
                1px solid #bbf7d0;
        }


        .alert-error {
            color: #991b1b;

            background: #fef2f2;

            border:
                1px solid #fecaca;
        }


        .errors {
            display: grid;
            gap: 5px;
        }


        /* =========================================================
           HERO
        ========================================================= */

        .hero {
            position: relative;

            overflow: hidden;

            padding: 30px;

            margin-bottom: 20px;

            border:
                1px solid var(--border);

            border-radius: 25px;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.99),
                    rgba(248,250,252,.96)
                );

            box-shadow: var(--shadow-lg);
        }


        .hero::before {
            content: "";

            position: absolute;

            width: 330px;
            height: 330px;

            right: -140px;
            top: -180px;

            background:
                radial-gradient(
                    circle,
                    rgba(99,102,241,.14),
                    transparent 68%
                );

            pointer-events: none;
        }


        .hero::after {
            content: "";

            position: absolute;

            width: 220px;
            height: 220px;

            left: -150px;
            bottom: -170px;

            background:
                radial-gradient(
                    circle,
                    rgba(124,58,237,.08),
                    transparent 70%
                );

            pointer-events: none;
        }


        .hero-content {
            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;

            gap: 22px;
        }


        /* =========================================================
           PREMIUM LOGO
        ========================================================= */

        .avatar-wrap {
            position: relative;

            flex-shrink: 0;

            padding: 5px;

            border-radius: 30px;

            background:
                linear-gradient(
                    135deg,
                    #4f46e5,
                    #7c3aed,
                    #a855f7
                );

            box-shadow:
                0 18px 40px rgba(79,70,229,.22);
        }


        .avatar-wrap::before {
            content: "";

            position: absolute;

            inset: -3px;

            border-radius: 33px;

            background:
                linear-gradient(
                    135deg,
                    rgba(79,70,229,.20),
                    rgba(168,85,247,.08),
                    transparent
                );

            z-index: -1;
        }


        .avatar {
            width: 112px;
            height: 112px;

            overflow: hidden;

            display: grid;
            place-items: center;

            border-radius: 25px;

            background:
                linear-gradient(
                    135deg,
                    #ffffff,
                    #f5f3ff
                );

            border:
                3px solid rgba(255,255,255,.95);

            box-shadow:
                inset 0 0 0 1px rgba(79,70,229,.08),
                0 8px 25px rgba(15,23,42,.12);
        }


        .avatar img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            display: block;
        }


        .avatar-fallback {
            width: 100%;
            height: 100%;

            display: grid;
            place-items: center;

            font-size: 31px;
            font-weight: 950;

            background:
                linear-gradient(
                    135deg,
                    #eef2ff,
                    #faf5ff
                );

            color: var(--primary);
        }


        .online-dot {
            position: absolute;

            right: -3px;
            bottom: -3px;

            width: 21px;
            height: 21px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle at 35% 30%,
                    #4ade80,
                    #16a34a
                );

            border:
                4px solid white;

            box-shadow:
                0 3px 12px rgba(22,163,74,.30);
        }


        .hero-info h1 {
            color: var(--text);

            font-size: clamp(25px, 4vw, 34px);

            line-height: 1.15;

            letter-spacing: -1px;

            font-weight: 950;
        }


        .hero-shop {
            margin-top: 6px;

            color: var(--text-2);

            font-size: 15px;
            font-weight: 650;
        }


        .hero-meta {
            display: flex;
            flex-wrap: wrap;

            gap: 7px;

            margin-top: 13px;
        }


        .pill {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            min-height: 29px;

            padding: 0 10px;

            border-radius: 999px;

            background: #f8fafc;

            border:
                1px solid var(--border);

            color: var(--muted);

            font-size: 11px;
            font-weight: 750;
        }


        .pill.green {
            color: #15803d;

            background: #f0fdf4;

            border-color: #bbf7d0;
        }


        /* =========================================================
           GRID
        ========================================================= */

        .main-grid {
            display: grid;

            grid-template-columns:
                minmax(0, 1.35fr)
                minmax(320px, .65fr);

            gap: 20px;

            align-items: start;
        }


        .left-stack,
        .side-stack {
            display: grid;
            gap: 20px;
        }


        /* =========================================================
           CARD
        ========================================================= */

        .card {
            overflow: hidden;

            border:
                1px solid var(--border);

            border-radius: 20px;

            background:
                rgba(255,255,255,.95);

            box-shadow: var(--shadow);

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }


        .card:hover {
            box-shadow:
                0 22px 65px rgba(15,23,42,.10);
        }


        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding: 19px 22px;

            border-bottom:
                1px solid var(--border-soft);
        }


        .section-title {
            display: flex;
            align-items: center;

            gap: 10px;

            color: var(--text);

            font-size: 15px;
            font-weight: 900;
        }


        .section-icon {
            width: 35px;
            height: 35px;

            display: grid;
            place-items: center;

            border-radius: 10px;

            color: var(--primary);

            background:
                #eef2ff;

            border:
                1px solid #e0e7ff;

            font-size: 16px;
        }


        .card-header small {
            color: var(--muted-2);

            font-size: 11px;
            font-weight: 600;
        }


        /* =========================================================
           INFORMATION
        ========================================================= */

        .info-body {
            padding: 5px 22px 20px;
        }


        .info-row {
            display: grid;

            grid-template-columns:
                170px
                minmax(0,1fr);

            gap: 18px;

            padding: 16px 0;

            border-bottom:
                1px solid #f1f5f9;
        }


        .info-row:last-child {
            border-bottom: 0;
        }


        .info-label {
            color: var(--muted);

            font-size: 12px;
            font-weight: 650;
        }


        .info-value {
            color: var(--text);

            font-size: 13px;
            font-weight: 750;

            word-break: break-word;
        }


        .info-value.muted {
            color: var(--muted-2);
        }


        /* =========================================================
           EDIT
        ========================================================= */

        .edit-body {
            padding: 23px;
        }


        .edit-intro {
            margin-bottom: 20px;

            padding: 13px 15px;

            border-radius: 12px;

            color: #475569;

            background:
                #f8fafc;

            border:
                1px solid #e5e7eb;

            font-size: 12px;

            line-height: 1.6;
        }


        .edit-intro strong {
            color: var(--text);
        }


        .form-grid {
            display: grid;

            grid-template-columns:
                repeat(2,minmax(0,1fr));

            gap: 17px;
        }


        .field {
            display: grid;

            gap: 7px;
        }


        .field.full {
            grid-column: 1 / -1;
        }


        .field label {
            color: #334155;

            font-size: 12px;
            font-weight: 800;
        }


        .required {
            color: var(--danger);
        }


        .field input,
        .field textarea,
        .field select {
            width: 100%;

            min-height: 46px;

            padding: 0 13px;

            outline: none;

            border:
                1px solid #dbe2ea;

            border-radius: 11px;

            background: white;

            color: var(--text);

            font-size: 13px;
            font-weight: 600;

            box-shadow:
                0 2px 5px rgba(15,23,42,.025);

            transition: .2s ease;
        }


        .field textarea {
            min-height: 105px;

            padding-top: 12px;
            padding-bottom: 12px;

            resize: vertical;

            line-height: 1.55;
        }


        .field input::placeholder,
        .field textarea::placeholder {
            color: #a8b2c1;
        }


        .field input:hover,
        .field textarea:hover,
        .field select:hover {
            border-color: #cbd5e1;
        }


        .field input:focus,
        .field textarea:focus,
        .field select:focus {
            border-color:
                rgba(79,70,229,.65);

            box-shadow:
                0 0 0 4px rgba(79,70,229,.08);
        }


        .field-note {
            color: var(--muted-2);

            font-size: 10.5px;
            line-height: 1.45;
        }


        /* =========================================================
           UPLOAD
        ========================================================= */

        .upload-box {
            padding: 16px;

            border-radius: 15px;

            background:
                linear-gradient(
                    145deg,
                    #f8fafc,
                    #ffffff
                );

            border:
                1px dashed #cbd5e1;
        }


        .upload-box input[type="file"] {
            width: 100%;

            min-height: 44px;

            padding: 7px;

            border:
                1px solid #dbe2ea;

            border-radius: 10px;

            background: white;

            color: var(--text-2);

            cursor: pointer;
        }


        .upload-note {
            margin-top: 8px;

            color: var(--muted-2);

            font-size: 11px;
        }


        /* =========================================================
           CURRENT LOGO PREMIUM
        ========================================================= */

        .current-logo {
            display: flex;
            align-items: center;

            gap: 15px;

            margin-bottom: 15px;

            padding: 13px;

            border-radius: 16px;

            background:
                linear-gradient(
                    135deg,
                    #ffffff,
                    #f8fafc
                );

            border:
                1px solid #e8eaf0;
        }


        .current-logo-frame {
            width: 78px;
            height: 78px;

            flex-shrink: 0;

            padding: 4px;

            display: grid;
            place-items: center;

            border-radius: 21px;

            background:
                linear-gradient(
                    135deg,
                    #4f46e5,
                    #7c3aed,
                    #c084fc
                );

            box-shadow:
                0 10px 25px rgba(79,70,229,.18);
        }


        .current-logo-frame img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            border-radius: 17px;

            border:
                3px solid white;

            background: white;

            display: block;
        }


        .current-logo-text strong {
            display: block;

            color: var(--text);

            font-size: 12px;
            font-weight: 850;
        }


        .current-logo-text span {
            display: block;

            margin-top: 4px;

            color: var(--muted);

            font-size: 11px;

            line-height: 1.5;
        }


        /* =========================================================
           CROPPED PREVIEW
        ========================================================= */

        .crop-preview-wrapper {
            display: none;

            margin-top: 14px;

            padding: 13px;

            border-radius: 15px;

            background:
                linear-gradient(
                    135deg,
                    #eef2ff,
                    #faf5ff
                );

            border:
                1px solid #ddd6fe;
        }


        .crop-preview-wrapper.active {
            display: block;
        }


        .crop-preview-title {
            display: flex;
            align-items: center;
            gap: 7px;

            margin-bottom: 10px;

            color: #4338ca;

            font-size: 11px;
            font-weight: 850;
        }


        .crop-preview {
            width: 90px;
            height: 90px;

            padding: 4px;

            border-radius: 23px;

            background:
                linear-gradient(
                    135deg,
                    #4f46e5,
                    #7c3aed,
                    #c084fc
                );

            box-shadow:
                0 10px 25px rgba(79,70,229,.18);
        }


        .crop-preview img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            border-radius: 19px;

            border: 3px solid white;

            background: white;
        }


        /* =========================================================
           ACTIONS
        ========================================================= */

        .actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;

            gap: 10px;

            margin-top: 23px;
            padding-top: 20px;

            border-top:
                1px solid var(--border-soft);
        }


        .btn {
            min-height: 45px;

            padding: 0 18px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            border-radius: 11px;

            border:
                1px solid var(--border);

            cursor: pointer;

            font-size: 12px;
            font-weight: 850;

            transition: .2s ease;
        }


        .btn-secondary {
            color: var(--text-2);

            background:
                #ffffff;
        }


        .btn-secondary:hover {
            background: #f8fafc;

            border-color:
                #cbd5e1;
        }


        .btn-primary {
            color: white;

            border-color:
                rgba(79,70,229,.45);

            background:
                linear-gradient(
                    135deg,
                    #4f46e5,
                    #7c3aed
                );

            box-shadow:
                0 10px 25px rgba(79,70,229,.20);
        }


        .btn-primary:hover {
            transform: translateY(-1px);

            box-shadow:
                0 14px 32px rgba(79,70,229,.28);
        }


        /* =========================================================
           QR
        ========================================================= */

        .qr-body {
            padding: 24px;

            text-align: center;
        }


        .qr-box {
            width: 215px;
            height: 215px;

            margin: 0 auto 18px;

            padding: 10px;

            display: grid;
            place-items: center;

            border-radius: 18px;

            background: white;

            border:
                1px solid #e2e8f0;

            box-shadow:
                0 15px 35px rgba(15,23,42,.09);
        }


        .qr-box img {
            width: 100%;
            height: 100%;

            object-fit: contain;
        }


        .qr-empty {
            color: var(--muted-2);

            font-size: 12px;
            font-weight: 650;
        }


        .qr-title {
            color: var(--text);

            font-size: 14px;
            font-weight: 900;
        }


        .qr-description {
            max-width: 280px;

            margin: 7px auto 0;

            color: var(--muted);

            font-size: 12px;

            line-height: 1.6;
        }


        /* =========================================================
           STATUS
        ========================================================= */

        .status-value {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }


        .status-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: var(--success);
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .page-footer {
            margin-top: 25px;

            text-align: center;

            color: #94a3b8;

            font-size: 11px;
            font-weight: 600;
        }


        /* =========================================================
           CROP MODAL
        ========================================================= */

        .crop-modal {
            position: fixed;

            inset: 0;

            z-index: 99999;

            display: none;

            align-items: center;
            justify-content: center;

            padding: 20px;

            background:
                rgba(15,23,42,.72);

            backdrop-filter:
                blur(10px);

            -webkit-backdrop-filter:
                blur(10px);
        }


        .crop-modal.active {
            display: flex;
        }


        .crop-modal-card {
            width: min(950px, 100%);

            max-height: calc(100vh - 40px);

            overflow: hidden;

            border-radius: 24px;

            background:
                #ffffff;

            border:
                1px solid rgba(255,255,255,.55);

            box-shadow:
                0 35px 100px rgba(0,0,0,.35);

            animation:
                cropModalIn .22s ease;
        }


        @keyframes cropModalIn {

            from {
                opacity: 0;
                transform: translateY(15px) scale(.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

        }


        .crop-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding: 18px 22px;

            border-bottom:
                1px solid #eef2f7;
        }


        .crop-modal-heading {
            display: flex;
            align-items: center;

            gap: 12px;
        }


        .crop-modal-icon {
            width: 42px;
            height: 42px;

            display: grid;
            place-items: center;

            border-radius: 13px;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    #4f46e5,
                    #7c3aed
                );

            box-shadow:
                0 8px 20px rgba(79,70,229,.22);
        }


        .crop-modal-title {
            color: var(--text);

            font-size: 15px;
            font-weight: 900;
        }


        .crop-modal-subtitle {
            margin-top: 2px;

            color: var(--muted);

            font-size: 11px;
        }


        .crop-close {
            width: 38px;
            height: 38px;

            display: grid;
            place-items: center;

            border-radius: 11px;

            border:
                1px solid #e2e8f0;

            background:
                #f8fafc;

            color: #475569;

            cursor: pointer;

            font-size: 19px;

            transition: .2s ease;
        }


        .crop-close:hover {
            color: #dc2626;

            background: #fef2f2;

            border-color: #fecaca;
        }


        /* =========================================================
           LARGE CROP AREA
        ========================================================= */

        .crop-workspace {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr)
                190px;

            gap: 18px;

            padding: 20px;

            background:
                #f8fafc;
        }


        .crop-stage {
            min-height: 510px;

            display: flex;
            align-items: center;
            justify-content: center;

            overflow: hidden;

            border-radius: 18px;

            background:
                radial-gradient(
                    circle at center,
                    #334155,
                    #0f172a
                );

            border:
                1px solid #1e293b;

            box-shadow:
                inset 0 0 40px rgba(0,0,0,.28);
        }


        .crop-stage img {
            display: block;

            max-width: 100%;
        }


        .crop-side {
            display: flex;

            flex-direction: column;

            gap: 13px;
        }


        .crop-info {
            padding: 14px;

            border-radius: 14px;

            background: white;

            border:
                1px solid #e2e8f0;
        }


        .crop-info strong {
            display: block;

            color: var(--text);

            font-size: 12px;
            font-weight: 900;

            margin-bottom: 5px;
        }


        .crop-info span {
            display: block;

            color: var(--muted);

            font-size: 10.5px;

            line-height: 1.55;
        }


        .crop-tools {
            display: grid;

            grid-template-columns:
                repeat(2,1fr);

            gap: 8px;
        }


        .crop-tool {
            min-height: 42px;

            border-radius: 11px;

            border:
                1px solid #e2e8f0;

            background: white;

            color: #334155;

            cursor: pointer;

            font-size: 12px;
            font-weight: 800;

            transition: .2s ease;
        }


        .crop-tool:hover {
            color: var(--primary);

            border-color:
                #c7d2fe;

            background:
                #eef2ff;
        }


        .crop-modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;

            gap: 10px;

            padding: 16px 20px;

            border-top:
                1px solid #eef2f7;

            background: white;
        }


        .crop-btn {
            min-height: 43px;

            padding: 0 17px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            border-radius: 11px;

            cursor: pointer;

            font-size: 12px;
            font-weight: 850;

            transition: .2s ease;
        }


        .crop-btn-cancel {
            color: #475569;

            background: white;

            border:
                1px solid #dbe2ea;
        }


        .crop-btn-cancel:hover {
            background: #f8fafc;
        }


        .crop-btn-apply {
            color: white;

            border:
                1px solid #4f46e5;

            background:
                linear-gradient(
                    135deg,
                    #4f46e5,
                    #7c3aed
                );

            box-shadow:
                0 9px 22px rgba(79,70,229,.22);
        }


        .crop-btn-apply:hover {
            transform: translateY(-1px);

            box-shadow:
                0 13px 28px rgba(79,70,229,.28);
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1050px) {

            .main-grid {
                grid-template-columns: 1fr;
            }

            .side-stack {
                grid-template-columns:
                    repeat(2,minmax(0,1fr));
            }

        }


        @media (max-width: 820px) {

            .crop-workspace {
                grid-template-columns: 1fr;
            }

            .crop-side {
                display: grid;

                grid-template-columns:
                    1fr 1fr;
            }

            .crop-info {
                grid-column: 1 / -1;
            }

            .crop-stage {
                min-height: 430px;
            }

        }


        @media (max-width: 720px) {

            .profile-page {
                width: min(100% - 22px, 680px);

                padding-top: 17px;
            }


            .topbar {
                margin-bottom: 17px;
            }


            .brand-subtitle {
                display: none;
            }


            .back-btn {
                min-height: 40px;

                padding: 0 11px;
            }


            .hero {
                padding: 21px;

                border-radius: 19px;
            }


            .hero-content {
                align-items: flex-start;
            }


            .avatar {
                width: 88px;
                height: 88px;

                border-radius: 21px;
            }


            .avatar-wrap {
                border-radius: 25px;
            }


            .avatar-fallback {
                font-size: 24px;
            }


            .hero-info h1 {
                font-size: 24px;
            }


            .main-grid {
                gap: 16px;
            }


            .side-stack {
                grid-template-columns: 1fr;

                gap: 16px;
            }


            .info-row {
                grid-template-columns: 1fr;

                gap: 6px;
            }


            .form-grid {
                grid-template-columns: 1fr;
            }


            .field.full {
                grid-column: auto;
            }


            .actions {
                flex-direction: column-reverse;
            }


            .btn {
                width: 100%;
            }


            .crop-modal {
                padding: 10px;
            }


            .crop-modal-card {
                max-height: calc(100vh - 20px);

                border-radius: 19px;
            }


            .crop-modal-header {
                padding: 14px 15px;
            }


            .crop-workspace {
                padding: 12px;

                gap: 11px;
            }


            .crop-stage {
                min-height: 360px;

                border-radius: 14px;
            }


            .crop-side {
                grid-template-columns: 1fr 1fr;
            }


            .crop-modal-footer {
                padding: 12px;
            }


            .crop-btn {
                flex: 1;
            }

        }


        @media (max-width: 470px) {

            .profile-page {
                width: calc(100% - 16px);
            }


            .brand-title {
                font-size: 14px;
            }


            .brand-icon {
                width: 42px;
                height: 42px;
            }


            .hero-content {
                flex-direction: column;
            }


            .hero {
                padding: 18px;
            }


            .card-header,
            .edit-body,
            .info-body {
                padding-left: 16px;
                padding-right: 16px;
            }


            .hero-meta {
                flex-direction: column;
                align-items: flex-start;
            }


            .qr-box {
                width: 195px;
                height: 195px;
            }


            .crop-stage {
                min-height: 310px;
            }


            .crop-side {
                grid-template-columns: 1fr;
            }


            .crop-info {
                grid-column: auto;
            }

        }

    </style>

</head>


<body>


<div class="profile-page">


    {{-- =========================================================
         TOP BAR
    ========================================================== --}}

    <div class="topbar">

        <div class="brand">

            <div class="brand-icon">
                <span>SB</span>
            </div>

            <div>

                <div class="brand-title">
                    SMART BASKET
                </div>

                <div class="brand-subtitle">
                    Seller Center · Profile
                </div>

            </div>

        </div>


        <a
            href="{{ route('seller.dashboard') }}"
            class="back-btn"
        >
            ← Dashboard
        </a>

    </div>


    {{-- =========================================================
         ALERTS
    ========================================================== --}}

    @if(session('success'))

        <div class="alert alert-success">

            <span>✓</span>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-error">

            <span>!</span>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-error">

            <div class="errors">

                @foreach($errors->all() as $error)

                    <div>
                        • {{ $error }}
                    </div>

                @endforeach

            </div>

        </div>

    @endif


    {{-- =========================================================
         HERO
    ========================================================== --}}

    <section class="hero">

        <div class="hero-content">


            <div class="avatar-wrap">

                <div class="avatar">

                    @if($logoUrl)

                        <img
                            src="{{ $logoUrl }}?v={{ optional($seller->updated_at)->timestamp ?? time() }}"
                            alt="{{ $seller->shop_name ?: 'Seller Logo' }}"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
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


            <div class="hero-info">

                <h1>
                    {{ $seller->seller_name ?: 'Seller' }}
                </h1>


                <div class="hero-shop">
                    {{ $seller->shop_name ?: 'Your Shop' }}
                </div>


                <div class="hero-meta">

                    <span class="pill green">
                        ● Active Seller
                    </span>


                    <span class="pill">
                        Seller ID #{{ $seller->id }}
                    </span>


                    @if($seller->email)

                        <span class="pill">
                            {{ $seller->email }}
                        </span>

                    @endif

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
         MAIN GRID
    ========================================================== --}}

    <div class="main-grid">


        {{-- =====================================================
             LEFT
        ====================================================== --}}

        <div class="left-stack">


            {{-- ACCOUNT INFORMATION --}}

            <section class="card">

                <div class="card-header">

                    <div class="section-title">

                        <div class="section-icon">
                            👤
                        </div>

                        <span>
                            Account Information
                        </span>

                    </div>


                    <small>
                        Complete seller details
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
                            Email
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


            {{-- EDIT ACCOUNT --}}

            <section class="card">

                <div class="card-header">

                    <div class="section-title">

                        <div class="section-icon">
                            ✎
                        </div>

                        <span>
                            Edit Account Information
                        </span>

                    </div>


                    <small>
                        Update all profile details
                    </small>

                </div>


                <div class="edit-body">


                    <div class="edit-intro">

                        <strong>
                            Update your seller profile.
                        </strong>

                        You can edit your personal, shop,
                        contact and business information below.
                        Changes will be saved to your seller account.

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
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="seller_name"
                                    value="{{ old('seller_name', $seller->seller_name) }}"
                                    placeholder="Enter seller name"
                                    maxlength="100"
                                    required
                                >

                            </div>


                            {{-- SHOP NAME --}}

                            <div class="field">

                                <label>
                                    Shop Name
                                    <span class="required">*</span>
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
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $seller->email) }}"
                                    placeholder="seller@example.com"
                                    maxlength="150"
                                    required
                                >

                            </div>


                            {{-- MOBILE --}}

                            <div class="field">

                                <label>
                                    Mobile Number
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="mobile_number"
                                    value="{{ old('mobile_number', $seller->mobile_number) }}"
                                    placeholder="Enter mobile number"
                                    maxlength="15"
                                    inputmode="numeric"
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
                                    Enter your complete business/shop address.
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


                            {{-- =================================================
                                 SHOP LOGO
                            ================================================== --}}

                            <div class="field full">

                                <label>
                                    Shop Logo / Profile Photo
                                </label>


                                <div class="upload-box">


                                    {{-- CURRENT LOGO --}}

                                    @if($logoUrl)

                                        <div class="current-logo">

                                            <div class="current-logo-frame">

                                                <img
                                                    src="{{ $logoUrl }}?v={{ optional($seller->updated_at)->timestamp ?? time() }}"
                                                    alt="Current Shop Logo"
                                                    onerror="this.style.display='none';"
                                                >

                                            </div>


                                            <div class="current-logo-text">

                                                <strong>
                                                    Current shop logo
                                                </strong>

                                                <span>
                                                    Your logo is displayed with a premium border.
                                                    Upload a new image to replace it.
                                                </span>

                                            </div>

                                        </div>

                                    @endif


                                    {{-- FILE INPUT --}}

                                    <input
                                        type="file"
                                        id="shopLogoInput"
                                        name="shop_logo"
                                        accept="image/jpeg,image/png,image/jpg,image/webp"
                                    >


                                    <div class="upload-note">
                                        JPG, PNG or WEBP · Maximum 4 MB ·
                                        Select an image and crop it before saving.
                                    </div>


                                    {{-- CROPPED PREVIEW --}}

                                    <div
                                        class="crop-preview-wrapper"
                                        id="cropPreviewWrapper"
                                    >

                                        <div class="crop-preview-title">
                                            ✓ Cropped Logo Preview
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


                        {{-- ACTIONS --}}

                        <div class="actions">

                            <a
                                href="{{ route('seller.profile') }}"
                                class="btn btn-secondary"
                            >
                                Cancel
                            </a>


                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                ✓ Save All Changes
                            </button>

                        </div>

                    </form>

                </div>

            </section>

        </div>


        {{-- =====================================================
             RIGHT
        ====================================================== --}}

        <div class="side-stack">


            {{-- PAYMENT QR --}}

            <section class="card">

                <div class="card-header">

                    <div class="section-title">

                        <div class="section-icon">
                            ▣
                        </div>

                        <span>
                            Payment QR
                        </span>

                    </div>

                </div>


                <div class="qr-body">

                    @if($qrUrl)

                        <div class="qr-box">

                            <img
                                src="{{ $qrUrl }}?v={{ optional($seller->updated_at)->timestamp ?? time() }}"
                                alt="Seller Payment QR"
                                onerror="this.style.display='none';"
                            >

                        </div>


                        <div class="qr-title">
                            Customer Payment QR
                        </div>


                        <div class="qr-description">
                            This QR is shown to customers
                            when they pay for your products.
                        </div>

                    @else

                        <div class="qr-box">

                            <div class="qr-empty">
                                No QR uploaded
                            </div>

                        </div>


                        <div class="qr-title">
                            Payment QR
                        </div>


                        <div class="qr-description">
                            Upload your payment QR from
                            Seller Settings.
                        </div>

                    @endif

                </div>

            </section>


            {{-- ACCOUNT STATUS --}}

            <section class="card">

                <div class="card-header">

                    <div class="section-title">

                        <div class="section-icon">
                            ✓
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


                </div>

            </section>

        </div>

    </div>


    <div class="page-footer">
        Smart Basket Seller Center · Secure Seller Profile
    </div>

</div>


{{-- =============================================================
     CROP MODAL
============================================================== --}}

<div
    class="crop-modal"
    id="cropModal"
    aria-hidden="true"
>

    <div class="crop-modal-card">


        {{-- HEADER --}}

        <div class="crop-modal-header">

            <div class="crop-modal-heading">

                <div class="crop-modal-icon">
                    ✂
                </div>

                <div>

                    <div class="crop-modal-title">
                        Adjust Your Shop Logo
                    </div>

                    <div class="crop-modal-subtitle">
                        Crop, zoom or rotate your image before saving.
                    </div>

                </div>

            </div>


            <button
                type="button"
                class="crop-close"
                id="cropClose"
                aria-label="Close"
            >
                ×
            </button>

        </div>


        {{-- WORKSPACE --}}

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
                        Large Crop Area
                    </strong>

                    <span>
                        The crop area is intentionally larger so your
                        logo doesn't get unnecessarily cut.
                    </span>

                </div>


                <div class="crop-tools">

                    <button
                        type="button"
                        class="crop-tool"
                        id="zoomOut"
                    >
                        − Zoom
                    </button>


                    <button
                        type="button"
                        class="crop-tool"
                        id="zoomIn"
                    >
                        + Zoom
                    </button>


                    <button
                        type="button"
                        class="crop-tool"
                        id="rotateLeft"
                    >
                        ↶ Rotate
                    </button>


                    <button
                        type="button"
                        class="crop-tool"
                        id="rotateRight"
                    >
                        ↷ Rotate
                    </button>


                    <button
                        type="button"
                        class="crop-tool"
                        id="resetCrop"
                        style="grid-column:1/-1;"
                    >
                        ↺ Reset
                    </button>

                </div>


            </div>

        </div>


        {{-- FOOTER --}}

        <div class="crop-modal-footer">

            <button
                type="button"
                class="crop-btn crop-btn-cancel"
                id="cropCancel"
            >
                Cancel
            </button>


            <button
                type="button"
                class="crop-btn crop-btn-apply"
                id="cropApply"
            >
                ✓ Apply Crop
            </button>

        </div>

    </div>

</div>


{{-- =============================================================
     CROPPER JS
============================================================== --}}

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"
></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const fileInput = document.getElementById('shopLogoInput');

    const cropModal = document.getElementById('cropModal');

    const cropImage = document.getElementById('cropImage');

    const cropClose = document.getElementById('cropClose');

    const cropCancel = document.getElementById('cropCancel');

    const cropApply = document.getElementById('cropApply');

    const zoomIn = document.getElementById('zoomIn');

    const zoomOut = document.getElementById('zoomOut');

    const rotateLeft = document.getElementById('rotateLeft');

    const rotateRight = document.getElementById('rotateRight');

    const resetCrop = document.getElementById('resetCrop');

    const cropPreviewWrapper =
        document.getElementById('cropPreviewWrapper');

    const croppedLogoPreview =
        document.getElementById('croppedLogoPreview');


    let cropper = null;

    let selectedObjectUrl = null;


    /*
    |--------------------------------------------------------------------------
    | OPEN CROP MODAL
    |--------------------------------------------------------------------------
    */

    fileInput.addEventListener('change', function (event) {

        const file = event.target.files[0];

        if (!file) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | FILE VALIDATION
        |--------------------------------------------------------------------------
        */

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/jpg',
            'image/webp'
        ];


        if (!allowedTypes.includes(file.type)) {

            alert(
                'Please select JPG, PNG or WEBP image.'
            );

            fileInput.value = '';

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | MAX 4 MB
        |--------------------------------------------------------------------------
        */

        if (file.size > 4 * 1024 * 1024) {

            alert(
                'Image size must be less than 4 MB.'
            );

            fileInput.value = '';

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE IMAGE URL
        |--------------------------------------------------------------------------
        */

        if (selectedObjectUrl) {
            URL.revokeObjectURL(selectedObjectUrl);
        }


        selectedObjectUrl =
            URL.createObjectURL(file);


        cropImage.src =
            selectedObjectUrl;


        /*
        |--------------------------------------------------------------------------
        | OPEN MODAL
        |--------------------------------------------------------------------------
        */

        cropModal.classList.add('active');

        cropModal.setAttribute(
            'aria-hidden',
            'false'
        );


        document.body.style.overflow = 'hidden';


        /*
        |--------------------------------------------------------------------------
        | INITIALIZE CROPPER
        |--------------------------------------------------------------------------
        */

        if (cropper) {

            cropper.destroy();

            cropper = null;

        }


        cropImage.onload = function () {

            cropper = new Cropper(
                cropImage,
                {

                    /*
                    |--------------------------------------------------------------------------
                    | LARGE CROP AREA
                    |--------------------------------------------------------------------------
                    */

                    aspectRatio: 1,

                    viewMode: 1,

                    dragMode: 'move',

                    autoCropArea: 0.88,

                    responsive: true,

                    restore: true,

                    guides: true,

                    center: true,

                    highlight: false,

                    cropBoxMovable: false,

                    cropBoxResizable: true,

                    toggleDragModeOnDblclick: false,

                    background: false,

                    modal: true,

                    zoomable: true,

                    zoomOnWheel: true,

                    wheelZoomRatio: 0.08,

                    rotatable: true,

                    scalable: true,

                    checkOrientation: true,

                    minContainerWidth: 300,

                    minContainerHeight: 300,

                    ready: function () {

                        /*
                        |--------------------------------------------------------------------------
                        | START WITH LARGE CROP
                        |--------------------------------------------------------------------------
                        */

                        try {

                            const containerData =
                                cropper.getContainerData();

                            const cropBoxSize =
                                Math.min(
                                    containerData.width,
                                    containerData.height
                                ) * 0.82;

                            cropper.setCropBoxData({

                                width: cropBoxSize,
                                height: cropBoxSize,

                                left:
                                    (containerData.width -
                                        cropBoxSize) / 2,

                                top:
                                    (containerData.height -
                                        cropBoxSize) / 2

                            });

                        } catch (error) {

                            console.log(
                                'Crop box initialization:',
                                error
                            );

                        }

                    }

                }
            );

        };

    });


    /*
    |--------------------------------------------------------------------------
    | ZOOM IN
    |--------------------------------------------------------------------------
    */

    zoomIn.addEventListener('click', function () {

        if (!cropper) {
            return;
        }

        cropper.zoom(0.12);

    });


    /*
    |--------------------------------------------------------------------------
    | ZOOM OUT
    |--------------------------------------------------------------------------
    */

    zoomOut.addEventListener('click', function () {

        if (!cropper) {
            return;
        }

        cropper.zoom(-0.12);

    });


    /*
    |--------------------------------------------------------------------------
    | ROTATE LEFT
    |--------------------------------------------------------------------------
    */

    rotateLeft.addEventListener('click', function () {

        if (!cropper) {
            return;
        }

        cropper.rotate(-90);

    });


    /*
    |--------------------------------------------------------------------------
    | ROTATE RIGHT
    |--------------------------------------------------------------------------
    */

    rotateRight.addEventListener('click', function () {

        if (!cropper) {
            return;
        }

        cropper.rotate(90);

    });


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    resetCrop.addEventListener('click', function () {

        if (!cropper) {
            return;
        }

        cropper.reset();

    });


    /*
    |--------------------------------------------------------------------------
    | APPLY CROP
    |--------------------------------------------------------------------------
    */

    cropApply.addEventListener('click', function () {

        if (!cropper) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | HIGH QUALITY OUTPUT
        |--------------------------------------------------------------------------
        */

        const canvas =
            cropper.getCroppedCanvas({

                width: 1200,

                height: 1200,

                minWidth: 800,

                minHeight: 800,

                maxWidth: 1600,

                maxHeight: 1600,

                fillColor: '#ffffff',

                imageSmoothingEnabled: true,

                imageSmoothingQuality: 'high'

            });


        if (!canvas) {

            alert(
                'Unable to crop this image. Please try another image.'
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | CREATE PREVIEW
        |--------------------------------------------------------------------------
        */

        const previewUrl =
            canvas.toDataURL(
                'image/jpeg',
                0.94
            );


        croppedLogoPreview.src =
            previewUrl;


        cropPreviewWrapper.classList.add(
            'active'
        );


        /*
        |--------------------------------------------------------------------------
        | REPLACE ORIGINAL FILE WITH CROPPED FILE
        |--------------------------------------------------------------------------
        */

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
                        [blob],
                        'shop-logo-cropped.jpg',
                        {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | DATA TRANSFER
                |--------------------------------------------------------------------------
                */

                try {

                    const dataTransfer =
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

                }


                closeCropper();

            },
            'image/jpeg',
            0.94
        );

    });


    /*
    |--------------------------------------------------------------------------
    | CLOSE
    |--------------------------------------------------------------------------
    */

    function closeCropper() {

        cropModal.classList.remove(
            'active'
        );

        cropModal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.style.overflow = '';


        if (cropper) {

            cropper.destroy();

            cropper = null;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | CANCEL
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | CLICK OUTSIDE
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | ESC KEY
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                cropModal.classList.contains('active')
            ) {

                cancelCrop();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CLEAN OBJECT URL
    |--------------------------------------------------------------------------
    */

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

});

</script>


</body>

    @include('seller.partials.seller-menu')
</html>