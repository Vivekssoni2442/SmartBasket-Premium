<!DOCTYPE html>
<html lang="en" data-sb-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Product | SMART BASKET Seller</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet"
    >

    <style>
        /* =========================================================
           SMART BASKET
           PREMIUM SELLER PRODUCT CENTER
           LIGHT BLUE + WHITE DASHBOARD SYSTEM
        ========================================================= */

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        :root {
            --sb-primary: #2563eb;
            --sb-primary-dark: #1d4ed8;
            --sb-primary-deep: #1e40af;
            --sb-blue: #3b82f6;

            --sb-blue-soft: #eff6ff;
            --sb-blue-soft-2: #dbeafe;
            --sb-blue-border: #bfdbfe;

            --sb-indigo: #4f46e5;

            --sb-bg: #f4f7fb;
            --sb-bg-top: #f8fbff;

            --sb-card: #ffffff;
            --sb-card-soft: #f8fafc;

            --sb-text: #0f172a;
            --sb-text-2: #334155;
            --sb-muted: #64748b;
            --sb-muted-2: #94a3b8;

            --sb-border: #e2e8f0;
            --sb-border-soft: #edf2f7;

            --sb-input: #fbfdff;

            --sb-success: #16a34a;
            --sb-success-bg: #f0fdf4;
            --sb-success-border: #bbf7d0;

            --sb-danger: #dc2626;
            --sb-danger-bg: #fef2f2;
            --sb-danger-border: #fecaca;

            --sb-shadow:
                0 18px 50px rgba(15, 23, 42, .07);

            --sb-shadow-soft:
                0 8px 28px rgba(15, 23, 42, .055);

            --sb-radius-xl: 24px;
            --sb-radius-lg: 18px;
            --sb-radius-md: 14px;
            --sb-radius-sm: 10px;

            --sb-transition: .22s ease;
        }


        /* =========================================================
           BODY
        ========================================================= */

        body {
            min-height: 100vh;
            margin: 0;

            font-family: 'Inter', sans-serif;

            color: var(--sb-text);

            background:
                radial-gradient(
                    circle at 0% 0%,
                    rgba(37, 99, 235, .075),
                    transparent 25%
                ),
                radial-gradient(
                    circle at 100% 5%,
                    rgba(79, 70, 229, .045),
                    transparent 23%
                ),
                linear-gradient(
                    180deg,
                    var(--sb-bg-top) 0%,
                    var(--sb-bg) 100%
                );

            overflow-x: hidden;
        }


        body::before {
            content: "";

            position: fixed;

            width: 420px;
            height: 420px;

            top: -230px;
            left: -170px;

            border-radius: 50%;

            background:
                rgba(37, 99, 235, .045);

            filter: blur(85px);

            pointer-events: none;

            z-index: 0;
        }


        body::after {
            content: "";

            position: fixed;

            width: 430px;
            height: 430px;

            right: -230px;
            bottom: -230px;

            border-radius: 50%;

            background:
                rgba(79, 70, 229, .035);

            filter: blur(90px);

            pointer-events: none;

            z-index: 0;
        }


        /* =========================================================
           PAGE
        ========================================================= */

        .product-page {
            position: relative;
            z-index: 1;

            width: 100%;
            min-height: 100vh;

            padding:
                20px 18px 38px;
        }


        .product-container {
            width: 100%;
            max-width: 1680px;

            margin: 0 auto;
        }


        /* =========================================================
           PAGE INTRO
        ========================================================= */

        .page-intro {
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 18px;

            margin:
                0 0 17px;
        }


        .intro-main {
            min-width: 0;
        }


        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            margin-bottom: 6px;

            color:
                var(--sb-primary-dark);

            font-size: 9px;
            font-weight: 900;

            text-transform: uppercase;
            letter-spacing: .7px;
        }


        .eyebrow i {
            font-size: 9px;
        }


        .page-intro h2 {
            margin: 0;

            color:
                var(--sb-text);

            font-size:
                clamp(24px, 2.4vw, 33px);

            font-weight: 900;

            line-height: 1.12;

            letter-spacing: -1px;
        }


        .page-intro h2 i {
            margin-right: 8px;

            color:
                var(--sb-primary);

            font-size: .8em;
        }


        .page-intro p {
            margin: 7px 0 0;

            color:
                var(--sb-muted);

            font-size: 11px;
            font-weight: 500;

            line-height: 1.5;
        }


        .intro-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            flex-shrink: 0;

            padding: 9px 13px;

            color:
                var(--sb-primary-dark);

            background:
                var(--sb-blue-soft);

            border:
                1px solid var(--sb-blue-border);

            border-radius: 999px;

            font-size: 9px;
            font-weight: 800;

            white-space: nowrap;
        }


        /* =========================================================
           MAIN CARD
        ========================================================= */

        .form-card {
            position: relative;

            width: 100%;

            padding: 20px;

            background:
                rgba(255, 255, 255, .97);

            border:
                1px solid var(--sb-border);

            border-radius:
                var(--sb-radius-xl);

            box-shadow:
                var(--sb-shadow);

            overflow: hidden;
        }


        .form-card::before {
            content: "";

            position: absolute;

            width: 400px;
            height: 400px;

            top: -290px;
            right: -150px;

            border-radius: 50%;

            background:
                rgba(37, 99, 235, .055);

            filter: blur(45px);

            pointer-events: none;
        }


        .form-content {
            position: relative;
            z-index: 2;
        }


        /* =========================================================
           ALERTS
        ========================================================= */

        .alert-success-custom,
        .alert-error-custom {
            position: relative;
            z-index: 5;

            width: 100%;

            display: flex;
            align-items: flex-start;

            gap: 10px;

            margin-bottom: 13px;

            padding: 11px 13px;

            border-radius: 12px;

            font-size: 10px;
            font-weight: 600;

            line-height: 1.5;
        }


        .alert-success-custom {
            color: #15803d;

            background:
                var(--sb-success-bg);

            border:
                1px solid var(--sb-success-border);
        }


        .alert-error-custom {
            color: #b91c1c;

            background:
                var(--sb-danger-bg);

            border:
                1px solid var(--sb-danger-border);
        }


        .alert-success-custom > i,
        .alert-error-custom > i {
            margin-top: 1px;
            flex: 0 0 auto;
        }


        .errors-list {
            display: block;
        }


        .error-title {
            display: flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 6px;
        }


        .error-item {
            margin-top: 3px;
            padding-left: 21px;

            color:
                #991b1b;

            font-size: 9px;
            font-weight: 600;
        }


        /* =========================================================
           MAIN FORM GRID
        ========================================================= */

        .product-form-layout {
            display: grid;

            grid-template-columns:
                minmax(0, 1.72fr)
                minmax(300px, .78fr);

            gap: 18px;

            align-items: start;
        }


        .details-column,
        .media-column {
            min-width: 0;
        }


        .media-column {
            position: sticky;
            top: 16px;
        }


        /* =========================================================
           SECTION CARD
        ========================================================= */

        .section-card {
            width: 100%;

            padding: 17px;

            margin-bottom: 13px;

            background:
                #ffffff;

            border:
                1px solid var(--sb-border);

            border-radius:
                16px;

            box-shadow:
                0 7px 24px rgba(15, 23, 42, .035);
        }


        .section-card:last-child {
            margin-bottom: 0;
        }


        .section-heading {
            display: flex;
            align-items: center;

            gap: 10px;

            margin-bottom: 14px;

            padding-bottom: 12px;

            border-bottom:
                1px solid var(--sb-border-soft);
        }


        .section-icon {
            width: 37px;
            height: 37px;

            flex: 0 0 37px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            color:
                var(--sb-primary-dark);

            background:
                linear-gradient(
                    145deg,
                    #eff6ff,
                    #f8fbff
                );

            border:
                1px solid var(--sb-blue-border);

            font-size: 13px;
        }


        .section-heading h3 {
            margin: 0;

            color:
                var(--sb-text);

            font-size: 13px;
            font-weight: 900;
        }


        .section-heading p {
            margin: 3px 0 0;

            color:
                var(--sb-muted);

            font-size: 8px;
            font-weight: 500;

            line-height: 1.45;
        }


        .section-tag {
            margin-left: auto;

            padding: 5px 8px;

            color:
                var(--sb-primary-dark);

            background:
                var(--sb-blue-soft);

            border:
                1px solid var(--sb-blue-border);

            border-radius: 999px;

            font-size: 7px;
            font-weight: 900;

            white-space: nowrap;
        }


        /* =========================================================
           FIELD GRID
        ========================================================= */

        .fields-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 13px;
        }


        .field {
            min-width: 0;
        }


        .field-full {
            grid-column:
                1 / -1;
        }


        /* =========================================================
           LABELS
        ========================================================= */

        .form-label {
            display: flex;
            align-items: center;

            gap: 4px;

            margin:
                0 0 6px;

            color:
                var(--sb-text-2);

            font-size: 9px;
            font-weight: 800;
        }


        .required {
            color:
                var(--sb-danger);
        }


        .field-help {
            margin-top: 5px;

            color:
                var(--sb-muted-2);

            font-size: 7.5px;
            font-weight: 500;

            line-height: 1.45;
        }


        /* =========================================================
           INPUTS
        ========================================================= */

        .form-control,
        .form-select {
            width: 100%;

            min-height: 45px;

            padding:
                10px 12px;

            color:
                var(--sb-text);

            background:
                var(--sb-input);

            border:
                1px solid var(--sb-border);

            border-radius:
                10px;

            outline: none;

            font-family:
                'Inter', sans-serif;

            font-size: 10px;
            font-weight: 500;

            transition:
                all .2s ease;

            box-shadow:
                inset 0 1px 2px rgba(15, 23, 42, .012);
        }


        .form-control::placeholder {
            color:
                #9aa7b6;
        }


        .form-control:hover,
        .form-select:hover {
            background:
                #ffffff;

            border-color:
                #cbd5e1;
        }


        .form-control:focus,
        .form-select:focus {
            color:
                var(--sb-text);

            background:
                #ffffff;

            border-color:
                var(--sb-primary);

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, .09),
                0 7px 18px rgba(37, 99, 235, .05);
        }


        .form-select {
            cursor: pointer;
        }


        .form-select option {
            color:
                var(--sb-text);

            background:
                #ffffff;
        }


        textarea.form-control {
            min-height: 116px;

            resize: vertical;

            line-height: 1.6;
        }


        /* =========================================================
           PRICE
        ========================================================= */

        .input-wrapper {
            position: relative;
        }


        .input-prefix {
            position: absolute;

            z-index: 2;

            top: 50%;
            left: 12px;

            transform:
                translateY(-50%);

            color:
                var(--sb-primary-dark);

            font-size: 11px;
            font-weight: 900;

            pointer-events: none;
        }


        .price-input {
            padding-left:
                28px !important;
        }


        /* =========================================================
           MEDIA CARD
        ========================================================= */

        .media-card {
            padding: 17px;
        }


        .media-header {
            display: flex;
            align-items: flex-start;

            gap: 9px;

            margin-bottom: 13px;
        }


        .media-header-icon {
            width: 36px;
            height: 36px;

            flex: 0 0 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            color:
                var(--sb-primary-dark);

            background:
                var(--sb-blue-soft);

            border:
                1px solid var(--sb-blue-border);

            font-size: 12px;
        }


        .media-header h3 {
            margin: 0;

            color:
                var(--sb-text);

            font-size: 13px;
            font-weight: 900;
        }


        .media-header p {
            margin: 3px 0 0;

            color:
                var(--sb-muted);

            font-size: 8px;

            line-height: 1.45;
        }


        /* =========================================================
           UPLOAD ZONE
        ========================================================= */

        .upload-zone {
            position: relative;

            min-height: 220px;

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            padding: 22px 15px;

            overflow: hidden;

            text-align: center;

            cursor: pointer;

            border:
                1.5px dashed #b8c9e4;

            border-radius:
                16px;

            background:
                linear-gradient(
                    145deg,
                    #f5f9ff,
                    #fbfdff
                );

            transition:
                all .25s ease;
        }


        .upload-zone::before {
            content: "";

            position: absolute;
            inset: 0;

            background:
                radial-gradient(
                    circle at center,
                    rgba(37, 99, 235, .09),
                    transparent 64%
                );

            opacity: 0;

            transition:
                .25s ease;

            pointer-events: none;
        }


        .upload-zone:hover {
            border-color:
                var(--sb-primary);

            background:
                #f1f6ff;

            transform:
                translateY(-1px);

            box-shadow:
                0 14px 30px rgba(37, 99, 235, .09);
        }


        .upload-zone:hover::before {
            opacity: 1;
        }


        .upload-zone.has-image {
            border-color:
                rgba(37, 99, 235, .55);

            background:
                #f2f7ff;
        }


        .upload-icon {
            position: relative;
            z-index: 2;

            width: 58px;
            height: 58px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 11px;

            border-radius: 17px;

            color:
                var(--sb-primary-dark);

            background:
                linear-gradient(
                    145deg,
                    #e8f1ff,
                    #f7faff
                );

            border:
                1px solid var(--sb-blue-border);

            font-size: 20px;

            box-shadow:
                0 8px 20px rgba(37, 99, 235, .08);
        }


        .upload-title {
            position: relative;
            z-index: 2;

            color:
                var(--sb-text);

            font-size: 11px;
            font-weight: 900;
        }


        .upload-subtitle {
            position: relative;
            z-index: 2;

            margin-top: 6px;

            color:
                var(--sb-muted);

            font-size: 8px;
            font-weight: 500;

            line-height: 1.5;
        }


        .upload-hint {
            position: relative;
            z-index: 2;

            margin-top: 10px;

            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 6px 9px;

            color:
                var(--sb-primary-dark);

            background:
                var(--sb-blue-soft);

            border:
                1px solid #d6e6ff;

            border-radius: 999px;

            font-size: 7px;
            font-weight: 800;
        }


        /* =========================================================
           PREVIEW
        ========================================================= */

        .preview-wrapper {
            display: none;

            margin-top: 11px;

            padding: 9px;

            overflow: hidden;

            background:
                #ffffff;

            border:
                1px solid var(--sb-border);

            border-radius:
                14px;

            box-shadow:
                var(--sb-shadow-soft);
        }


        .preview-wrapper.show {
            display: block;

            animation:
                previewShow .25s ease;
        }


        .preview-header {
            display: flex;

            align-items: center;
            justify-content: space-between;

            gap: 8px;

            margin-bottom: 8px;

            padding:
                2px 2px 7px;

            border-bottom:
                1px solid var(--sb-border-soft);
        }


        .preview-label {
            display: inline-flex;

            align-items: center;

            gap: 6px;

            color:
                var(--sb-text-2);

            font-size: 8px;
            font-weight: 800;
        }


        .preview-label i {
            color:
                var(--sb-success);
        }


        .preview-format {
            max-width: 55%;

            overflow: hidden;

            color:
                var(--sb-muted);

            font-size: 7px;
            font-weight: 600;

            white-space: nowrap;
            text-overflow: ellipsis;
        }


        .image-preview {
            display: block;

            width: 100%;
            max-height: 250px;

            object-fit: contain;

            border-radius:
                9px;

            background:
                #f8fafc;
        }


        /* =========================================================
           VIDEO UPLOAD
           ADDED ONLY FOR PRODUCT VIDEO
        ========================================================= */

        .video-upload-zone {
            position: relative;

            min-height: 175px;

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            padding: 20px 14px;

            overflow: hidden;

            text-align: center;

            cursor: pointer;

            border:
                1.5px dashed #b8c9e4;

            border-radius:
                16px;

            background:
                linear-gradient(
                    145deg,
                    #f5f9ff,
                    #fbfdff
                );

            transition:
                all .25s ease;
        }


        .video-upload-zone::before {
            content: "";

            position: absolute;
            inset: 0;

            background:
                radial-gradient(
                    circle at center,
                    rgba(37, 99, 235, .09),
                    transparent 64%
                );

            opacity: 0;

            transition:
                .25s ease;

            pointer-events: none;
        }


        .video-upload-zone:hover {
            border-color:
                var(--sb-primary);

            background:
                #f1f6ff;

            transform:
                translateY(-1px);

            box-shadow:
                0 14px 30px rgba(37, 99, 235, .09);
        }


        .video-upload-zone:hover::before {
            opacity: 1;
        }


        .video-upload-zone.has-video {
            border-color:
                rgba(37, 99, 235, .55);

            background:
                #f2f7ff;
        }


        .video-upload-icon {
            position: relative;
            z-index: 2;

            width: 52px;
            height: 52px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 10px;

            border-radius: 15px;

            color:
                var(--sb-primary-dark);

            background:
                linear-gradient(
                    145deg,
                    #e8f1ff,
                    #f7faff
                );

            border:
                1px solid var(--sb-blue-border);

            font-size: 18px;

            box-shadow:
                0 8px 20px rgba(37, 99, 235, .08);
        }


        .video-upload-title {
            position: relative;
            z-index: 2;

            color:
                var(--sb-text);

            font-size: 10px;
            font-weight: 900;
        }


        .video-upload-subtitle {
            position: relative;
            z-index: 2;

            margin-top: 6px;

            color:
                var(--sb-muted);

            font-size: 7.5px;
            font-weight: 500;

            line-height: 1.5;
        }


        .video-upload-hint {
            position: relative;
            z-index: 2;

            margin-top: 9px;

            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 6px 9px;

            color:
                var(--sb-primary-dark);

            background:
                var(--sb-blue-soft);

            border:
                1px solid #d6e6ff;

            border-radius: 999px;

            font-size: 7px;
            font-weight: 800;
        }


        .video-preview-wrapper {
            display: none;

            margin-top: 11px;

            padding: 9px;

            overflow: hidden;

            background:
                #ffffff;

            border:
                1px solid var(--sb-border);

            border-radius:
                14px;

            box-shadow:
                var(--sb-shadow-soft);
        }


        .video-preview-wrapper.show {
            display: block;

            animation:
                previewShow .25s ease;
        }


        .video-preview {
            display: block;

            width: 100%;
            max-height: 280px;

            object-fit: contain;

            border-radius:
                9px;

            background:
                #0f172a;
        }


        .video-info-strip {
            display: flex;

            align-items: flex-start;

            gap: 7px;

            margin-top: 9px;

            padding: 9px 10px;

            color:
                var(--sb-muted);

            background:
                #f8fafc;

            border:
                1px solid var(--sb-border-soft);

            border-radius:
                10px;

            font-size: 7px;
            font-weight: 600;

            line-height: 1.5;
        }


        .video-info-strip i {
            flex: 0 0 auto;

            margin-top: 1px;

            color:
                var(--sb-primary);
        }


        @keyframes previewShow {
            from {
                opacity: 0;
                transform: scale(.98);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }


        /* =========================================================
           IMAGE INFO
        ========================================================= */

        .image-info-strip {
            display: flex;

            align-items: flex-start;

            gap: 7px;

            margin-top: 9px;

            padding: 9px 10px;

            color:
                var(--sb-muted);

            background:
                #f8fafc;

            border:
                1px solid var(--sb-border-soft);

            border-radius:
                10px;

            font-size: 7px;
            font-weight: 600;

            line-height: 1.5;
        }


        .image-info-strip i {
            flex: 0 0 auto;

            margin-top: 1px;

            color:
                var(--sb-primary);
        }


        /* =========================================================
           EXTRA IMAGES
        ========================================================= */

        .extra-upload {
            width: 100%;

            padding: 9px;

            color:
                var(--sb-text-2);

            background:
                var(--sb-input);

            border:
                1px solid var(--sb-border);

            border-radius:
                10px;

            font-family:
                'Inter', sans-serif;

            font-size: 9px;

            cursor: pointer;

            transition:
                .2s ease;
        }


        .extra-upload:hover {
            background:
                #ffffff;

            border-color:
                #c5d2e2;
        }


        .extra-upload:focus {
            outline: none;

            border-color:
                var(--sb-primary);

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, .09);
        }


        .extra-upload::file-selector-button {
            margin-right: 8px;

            padding: 7px 9px;

            color:
                var(--sb-primary-dark);

            background:
                var(--sb-blue-soft);

            border:
                1px solid var(--sb-blue-border);

            border-radius:
                8px;

            font-family:
                'Inter', sans-serif;

            font-size: 8px;
            font-weight: 800;

            cursor: pointer;
        }


        .help-text {
            display: block;

            margin-top: 6px;

            color:
                var(--sb-muted);

            font-size: 7.5px;

            line-height: 1.5;
        }


        /* =========================================================
           PUBLISHING
        ========================================================= */

        .publish-card {
            padding: 17px;
        }


        .publish-status {
            display: flex;

            align-items: center;
            justify-content: space-between;

            gap: 10px;

            padding: 10px;

            margin-bottom: 11px;

            background:
                var(--sb-blue-soft);

            border:
                1px solid var(--sb-blue-border);

            border-radius:
                11px;
        }


        .publish-status-left {
            display: flex;

            align-items: center;

            gap: 8px;
        }


        .status-icon {
            width: 29px;
            height: 29px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius:
                9px;

            color:
                var(--sb-primary-dark);

            background:
                #ffffff;

            border:
                1px solid var(--sb-blue-border);

            font-size: 10px;
        }


        .publish-status strong {
            display: block;

            color:
                var(--sb-text);

            font-size: 9px;
            font-weight: 900;
        }


        .publish-status small {
            display: block;

            margin-top: 2px;

            color:
                var(--sb-muted);

            font-size: 7px;
            font-weight: 500;
        }


        .status-dot {
            width: 7px;
            height: 7px;

            flex: 0 0 7px;

            border-radius: 50%;

            background:
                var(--sb-success);

            box-shadow:
                0 0 0 4px rgba(22, 163, 74, .10);
        }


        .publish-note {
            display: flex;

            align-items: flex-start;

            gap: 7px;

            margin-top: 9px;

            color:
                var(--sb-muted);

            font-size: 7px;

            line-height: 1.5;
        }


        .publish-note i {
            color:
                var(--sb-primary);

            margin-top: 1px;
        }


        /* =========================================================
           ACTIONS
        ========================================================= */

        .form-actions {
            display: flex;

            align-items: center;

            gap: 9px;

            margin: 0;

            padding: 0;

            border: 0;
        }


        .btn-submit {
            flex: 1;

            min-height: 47px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 8px;

            border: none;

            border-radius:
                11px;

            color:
                #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            font-family:
                'Inter', sans-serif;

            font-size: 10px;
            font-weight: 900;

            letter-spacing: .2px;

            cursor: pointer;

            transition:
                all .22s ease;

            box-shadow:
                0 10px 24px rgba(37, 99, 235, .18);
        }


        .btn-submit:hover {
            transform:
                translateY(-2px);

            background:
                linear-gradient(
                    135deg,
                    #3b82f6,
                    #2563eb
                );

            box-shadow:
                0 15px 32px rgba(37, 99, 235, .24);
        }


        .btn-submit:active {
            transform:
                translateY(0);
        }


        .btn-submit.is-loading {
            pointer-events: none;

            opacity: .78;
        }


        .btn-submit.is-loading .submit-icon {
            animation:
                spin .8s linear infinite;
        }


        .btn-cancel {
            min-height: 47px;

            padding:
                0 17px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 7px;

            flex-shrink: 0;

            color:
                var(--sb-text-2);

            background:
                #ffffff;

            border:
                1px solid var(--sb-border);

            border-radius:
                11px;

            text-decoration:
                none;

            font-size: 9px;
            font-weight: 800;

            transition:
                all .22s ease;
        }


        .btn-cancel:hover {
            color:
                var(--sb-danger);

            background:
                var(--sb-danger-bg);

            border-color:
                var(--sb-danger-border);

            transform:
                translateY(-2px);
        }


        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .page-footer {
            padding-top: 12px;

            text-align: center;

            color:
                var(--sb-muted-2);

            font-size: 7px;
            font-weight: 600;

            letter-spacing: .1px;
        }


        /* =========================================================
           ACCESSIBILITY
        ========================================================= */

        button:focus-visible,
        a:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline:
                3px solid rgba(37, 99, 235, .17);

            outline-offset:
                2px;
        }


        /* =========================================================
           LARGE DESKTOP
        ========================================================= */

        @media (min-width: 1500px) {

            .product-page {
                padding:
                    22px 25px 40px;
            }

            .form-card {
                padding:
                    22px;
            }

            .section-card {
                padding:
                    18px;
            }

            .upload-zone {
                min-height:
                    240px;
            }
        }


        /* =========================================================
           TABLET
        ========================================================= */

        @media (max-width: 1180px) {

            .product-form-layout {
                grid-template-columns:
                    minmax(0, 1.4fr)
                    minmax(280px, .8fr);

                gap:
                    15px;
            }
        }


        @media (max-width: 920px) {

            .product-form-layout {
                grid-template-columns:
                    1fr;
            }


            .media-column {
                position: static;

                display: grid;

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

                gap: 13px;
            }


            .media-column .section-card {
                margin-bottom: 0;
            }


            .media-column .media-card {
                grid-column:
                    1 / -1;
            }
        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 680px) {

            .product-page {
                padding:
                    14px 9px 28px;
            }


            .page-intro {
                display: block;

                margin-bottom:
                    13px;
            }


            .page-intro h2 {
                font-size:
                    23px;
            }


            .page-intro p {
                font-size:
                    9px;
            }


            .intro-badge {
                margin-top:
                    9px;

                font-size:
                    8px;
            }


            .form-card {
                padding:
                    12px;

                border-radius:
                    18px;
            }


            .section-card {
                padding:
                    13px;

                margin-bottom:
                    11px;

                border-radius:
                    14px;
            }


            .section-heading {
                margin-bottom:
                    12px;

                padding-bottom:
                    10px;
            }


            .section-icon {
                width:
                    35px;

                height:
                    35px;

                flex-basis:
                    35px;
            }


            .section-heading h3 {
                font-size:
                    12px;
            }


            .section-heading p {
                font-size:
                    7px;
            }


            .section-tag {
                display:
                    none;
            }


            .fields-grid {
                grid-template-columns:
                    1fr;

                gap:
                    11px;
            }


            .form-control,
            .form-select {
                min-height:
                    44px;

                font-size:
                    10px;
            }


            textarea.form-control {
                min-height:
                    110px;
            }


            .media-column {
                display:
                    block;
            }


            .media-column .section-card {
                margin-bottom:
                    11px;
            }


            .upload-zone {
                min-height:
                    185px;

                padding:
                    17px 11px;
            }


            .upload-icon {
                width:
                    53px;

                height:
                    53px;

                border-radius:
                    15px;

                font-size:
                    18px;
            }


            .upload-title {
                font-size:
                    10px;
            }


            .upload-subtitle {
                font-size:
                    7px;
            }


            .upload-hint {
                font-size:
                    6.5px;
            }


            .video-upload-zone {
                min-height:
                    165px;

                padding:
                    16px 10px;
            }


            .video-upload-icon {
                width:
                    50px;

                height:
                    50px;

                font-size:
                    17px;
            }


            .video-upload-title {
                font-size:
                    9px;
            }


            .video-upload-subtitle {
                font-size:
                    7px;
            }


            .video-upload-hint {
                font-size:
                    6.5px;
            }


            .form-actions {
                flex-direction:
                    column-reverse;

                align-items:
                    stretch;
            }


            .btn-submit,
            .btn-cancel {
                width:
                    100%;
            }


            .btn-cancel {
                padding:
                    0 13px;
            }
        }


        /* =========================================================
           SMALL MOBILE
        ========================================================= */

        @media (max-width: 420px) {

            .product-page {
                padding-left:
                    6px;

                padding-right:
                    6px;
            }


            .form-card {
                padding:
                    10px;
            }


            .section-card {
                padding:
                    11px;
            }


            .page-intro h2 {
                font-size:
                    21px;
            }
        }


        /* =========================================================
           REDUCE MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                scroll-behavior:
                    auto !important;

                transition-duration:
                    .01ms !important;

                animation-duration:
                    .01ms !important;

                animation-iteration-count:
                    1 !important;
            }
        }
    </style>
</head>


<body>


{{-- =========================================================
     COMMON SELLER TOPBAR / TASKBAR
========================================================= --}}

@include('seller.partials.topbar')


{{-- =========================================================
     GLOBAL SELLER MENU
========================================================= --}}

@include('seller.partials.seller-menu')


<main class="product-page">

    <div class="product-container">


        {{-- =====================================================
             PAGE INTRO
        ====================================================== --}}

        <div class="page-intro">

            <div class="intro-main">

                <div class="eyebrow">
                    <i class="fa-solid fa-store"></i>
                    Seller Product Center
                </div>

                <h2>
                    <i class="fa-solid fa-box-open"></i>
                    Add New Product
                </h2>

                <p>
                    Create a clean, complete and customer-ready product listing
                    for your SMART BASKET store.
                </p>

            </div>


            <div class="intro-badge">

                <i class="fa-solid fa-shield-halved"></i>

                Secure Seller Workspace

            </div>

        </div>



        {{-- =====================================================
             MAIN FORM CARD
        ====================================================== --}}

        <section class="form-card">


            {{-- =================================================
                 SUCCESS
            ================================================== --}}

            @if(session('success'))

                <div class="alert-success-custom">

                    <i class="fa-solid fa-circle-check"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif



            {{-- =================================================
                 ERROR
            ================================================== --}}

            @if(session('error'))

                <div class="alert-error-custom">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif



            {{-- =================================================
                 VALIDATION ERRORS
            ================================================== --}}

            @if ($errors->any())

                <div class="alert-error-custom errors-list">

                    <div class="error-title">

                        <i class="fa-solid fa-triangle-exclamation"></i>

                        <strong>
                            Please fix the following:
                        </strong>

                    </div>


                    @foreach($errors->all() as $error)

                        <div class="error-item">
                            • {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif



            <div class="form-content">


                {{-- =================================================
                     FORM
                ================================================== --}}

                <form
                    method="POST"
                    action="{{ route('seller.product.store') }}"
                    enctype="multipart/form-data"
                    id="addProductForm"
                >

                    @csrf


                    <div class="product-form-layout">


                        {{-- =================================================
                             LEFT COLUMN — DETAILS
                        ================================================== --}}

                        <div class="details-column">


                            {{-- =================================================
                                 PRODUCT INFORMATION
                            ================================================== --}}

                            <section class="section-card">

                                <div class="section-heading">

                                    <div class="section-icon">

                                        <i class="fa-solid fa-pen-to-square"></i>

                                    </div>


                                    <div>

                                        <h3>
                                            Product Information
                                        </h3>

                                        <p>
                                            Add the basic information customers
                                            will see on your product listing.
                                        </p>

                                    </div>


                                    <div class="section-tag">
                                        REQUIRED
                                    </div>

                                </div>


                                <div class="fields-grid">


                                    {{-- PRODUCT NAME --}}

                                    <div class="field">

                                        <label class="form-label">

                                            Product Name

                                            <span class="required">*</span>

                                        </label>


                                        <input
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            placeholder="Enter product name"
                                            value="{{ old('name') }}"
                                            autocomplete="off"
                                            required
                                        >


                                        <div class="field-help">
                                            Use a clear and customer-friendly product name.
                                        </div>

                                    </div>



                                    {{-- CATEGORY --}}

                                    <div class="field">

                                        <label class="form-label">

                                            Category

                                            <span class="required">*</span>

                                        </label>


                                        <input
                                            type="text"
                                            name="category"
                                            class="form-control"
                                            placeholder="e.g. Electronics, Fashion"
                                            value="{{ old('category') }}"
                                            autocomplete="off"
                                            required
                                        >


                                        <div class="field-help">
                                            Enter the category where this product belongs.
                                        </div>

                                    </div>



                                    {{-- BRAND --}}

                                    <div class="field">

                                        <label class="form-label">
                                            Brand
                                        </label>


                                        <input
                                            type="text"
                                            name="brand"
                                            class="form-control"
                                            placeholder="e.g. Samsung, Nike"
                                            value="{{ old('brand') }}"
                                            autocomplete="off"
                                        >

                                    </div>



                                    {{-- STOCK --}}

                                    <div class="field">

                                        <label class="form-label">

                                            Stock Quantity

                                            <span class="required">*</span>

                                        </label>


                                        <input
                                            type="number"
                                            name="stock"
                                            class="form-control"
                                            placeholder="Enter available quantity"
                                            min="0"
                                            value="{{ old('stock') }}"
                                            required
                                        >

                                    </div>

                                </div>

                            </section>



                            {{-- =================================================
                                 PRICING & INVENTORY
                            ================================================== --}}

                            <section class="section-card">

                                <div class="section-heading">

                                    <div class="section-icon">

                                        <i class="fa-solid fa-indian-rupee-sign"></i>

                                    </div>


                                    <div>

                                        <h3>
                                            Pricing & Inventory
                                        </h3>

                                        <p>
                                            Set your selling price, discount and
                                            product attributes.
                                        </p>

                                    </div>

                                </div>


                                <div class="fields-grid">


                                    {{-- PRICE --}}

                                    <div class="field">

                                        <label class="form-label">

                                            Selling Price

                                            <span class="required">*</span>

                                        </label>


                                        <div class="input-wrapper">

                                            <span class="input-prefix">
                                                ₹
                                            </span>


                                            <input
                                                type="number"
                                                name="price"
                                                class="form-control price-input"
                                                placeholder="0.00"
                                                step="0.01"
                                                min="0"
                                                value="{{ old('price') }}"
                                                required
                                            >

                                        </div>


                                        <div class="field-help">
                                            Enter the regular selling price.
                                        </div>

                                    </div>



                                    {{-- DISCOUNT PRICE --}}

                                    <div class="field">

                                        <label class="form-label">
                                            Discount Price
                                        </label>


                                        <div class="input-wrapper">

                                            <span class="input-prefix">
                                                ₹
                                            </span>


                                            <input
                                                type="number"
                                                name="discount_price"
                                                class="form-control price-input"
                                                placeholder="0.00"
                                                step="0.01"
                                                min="0"
                                                value="{{ old('discount_price') }}"
                                            >

                                        </div>


                                        <div class="field-help">
                                            Optional discounted customer price.
                                        </div>

                                    </div>



                                    {{-- SIZE --}}

                                    <div class="field">

                                        <label class="form-label">
                                            Size
                                        </label>


                                        <input
                                            type="text"
                                            name="size"
                                            class="form-control"
                                            placeholder="S, M, L, XL"
                                            value="{{ old('size') }}"
                                        >

                                    </div>



                                    {{-- COLOR --}}

                                    <div class="field">

                                        <label class="form-label">
                                            Color
                                        </label>


                                        <input
                                            type="text"
                                            name="color"
                                            class="form-control"
                                            placeholder="Black, Red, Blue"
                                            value="{{ old('color') }}"
                                        >

                                    </div>

                                </div>

                            </section>



                            {{-- =================================================
                                 DESCRIPTION
                            ================================================== --}}

                            <section class="section-card">

                                <div class="section-heading">

                                    <div class="section-icon">

                                        <i class="fa-solid fa-align-left"></i>

                                    </div>


                                    <div>

                                        <h3>
                                            Product Description
                                        </h3>

                                        <p>
                                            Give customers useful details about
                                            the product.
                                        </p>

                                    </div>

                                </div>


                                <div class="field">

                                    <label class="form-label">
                                        Description
                                    </label>


                                    <textarea
                                        name="description"
                                        class="form-control"
                                        rows="4"
                                        placeholder="Describe your product, features, specifications..."
                                    >{{ old('description') }}</textarea>


                                    <div class="field-help">

                                        Include important features,
                                        specifications, material, usage or
                                        other useful product information.

                                    </div>

                                </div>

                            </section>



                            {{-- =================================================
                                 ACTIONS
                            ================================================== --}}

                            <section class="section-card">

                                <div class="form-actions">


                                    <a
                                        href="{{ route('seller.dashboard') }}"
                                        class="btn-cancel"
                                    >

                                        <i class="fa-solid fa-xmark"></i>

                                        Cancel

                                    </a>


                                    <button
                                        type="submit"
                                        class="btn-submit"
                                        id="submitButton"
                                    >

                                        <i class="fa-solid fa-plus submit-icon"></i>

                                        <span>
                                            ADD PRODUCT
                                        </span>

                                    </button>

                                </div>

                            </section>

                        </div>



                        {{-- =================================================
                             RIGHT COLUMN — MEDIA
                        ================================================== --}}

                        <aside class="media-column">


                            {{-- =================================================
                                 MAIN PRODUCT IMAGE
                            ================================================== --}}

                            <section class="section-card media-card">


                                <div class="media-header">

                                    <div class="media-header-icon">

                                        <i class="fa-solid fa-image"></i>

                                    </div>


                                    <div>

                                        <h3>
                                            Product Media
                                        </h3>

                                        <p>
                                            Add a clear main image and optional
                                            supporting product images.
                                        </p>

                                    </div>

                                </div>


                                <label class="form-label">

                                    Main Product Image

                                    <span class="required">*</span>

                                </label>


                                <div
                                    class="upload-zone"
                                    id="uploadZone"
                                    onclick="document.getElementById('imageInput').click()"
                                    role="button"
                                    tabindex="0"
                                    aria-label="Upload product image"
                                >

                                    <div class="upload-icon">

                                        <i class="fa-solid fa-cloud-arrow-up"></i>

                                    </div>


                                    <div class="upload-title">
                                        Click to upload product image
                                    </div>


                                    <div class="upload-subtitle">

                                        JPG • JPEG • PNG • WEBP

                                        <br>

                                        Maximum file size: 2MB

                                    </div>


                                    <div class="upload-hint">

                                        <i class="fa-solid fa-wand-magic-sparkles"></i>

                                        High-quality image recommended

                                    </div>

                                </div>


                                <input
                                    type="file"
                                    name="image"
                                    id="imageInput"
                                    class="d-none"
                                    accept="image/jpeg,image/png,image/jpg,image/webp"
                                    required
                                    onchange="previewImage(this)"
                                >


                                <div
                                    id="previewWrapper"
                                    class="preview-wrapper"
                                >

                                    <div class="preview-header">

                                        <div class="preview-label">

                                            <i class="fa-solid fa-circle-check"></i>

                                            Image Preview

                                        </div>


                                        <div
                                            class="preview-format"
                                            id="previewFileName"
                                        >
                                            Ready
                                        </div>

                                    </div>


                                    <img
                                        id="imagePreview"
                                        class="image-preview"
                                        src=""
                                        alt="Product Preview"
                                    >

                                </div>


                                <div class="image-info-strip">

                                    <i class="fa-solid fa-circle-info"></i>

                                    <span>

                                        Main image should clearly show the
                                        product. Supported formats: JPG,
                                        JPEG, PNG and WEBP. Maximum file size:
                                        2MB.

                                    </span>

                                </div>

                            </section>



                            {{-- =================================================
                                 PRODUCT VIDEO
                                 NEW VIDEO UPLOAD SESSION
                            ================================================== --}}

                            <section class="section-card">

                                <div class="section-heading">

                                    <div class="section-icon">

                                        <i class="fa-solid fa-video"></i>

                                    </div>


                                    <div>

                                        <h3>
                                            Product Video
                                        </h3>

                                        <p>
                                            Add a short product video to help
                                            customers understand the product.
                                        </p>

                                    </div>


                                    <div class="section-tag">
                                        OPTIONAL
                                    </div>

                                </div>


                                <label class="form-label">

                                    Product Video

                                </label>


                                <div
                                    class="video-upload-zone"
                                    id="videoUploadZone"
                                    onclick="document.getElementById('videoInput').click()"
                                    role="button"
                                    tabindex="0"
                                    aria-label="Upload product video"
                                >

                                    <div class="video-upload-icon">

                                        <i class="fa-solid fa-cloud-arrow-up"></i>

                                    </div>


                                    <div class="video-upload-title">
                                        Click to upload product video
                                    </div>


                                    <div class="video-upload-subtitle">

                                        MP4 • WEBM • MOV

                                        <br>

                                        Maximum file size: 20MB

                                    </div>


                                    <div class="video-upload-hint">

                                        <i class="fa-solid fa-play"></i>

                                        Short & clear product video recommended

                                    </div>

                                </div>


                                <input
                                    type="file"
                                    name="video"
                                    id="videoInput"
                                    class="d-none"
                                    accept="video/mp4,video/webm,video/quicktime"
                                    onchange="previewVideo(this)"
                                >


                                <div
                                    id="videoPreviewWrapper"
                                    class="video-preview-wrapper"
                                >

                                    <div class="preview-header">

                                        <div class="preview-label">

                                            <i class="fa-solid fa-circle-check"></i>

                                            Video Preview

                                        </div>


                                        <div
                                            class="preview-format"
                                            id="videoPreviewFileName"
                                        >
                                            Ready
                                        </div>

                                    </div>


                                    <video
                                        id="videoPreview"
                                        class="video-preview"
                                        controls
                                        playsinline
                                        preload="metadata"
                                    >
                                        Your browser does not support video preview.
                                    </video>

                                </div>


                                <div class="video-info-strip">

                                    <i class="fa-solid fa-circle-info"></i>

                                    <span>

                                        Optional product video. Supported formats:
                                        MP4, WEBM and MOV. Maximum file size:
                                        20MB. A short, clear video is recommended.

                                    </span>

                                </div>

                            </section>



                            {{-- =================================================
                                 ADDITIONAL IMAGES
                            ================================================== --}}

                            <section class="section-card">


                                <div class="section-heading">

                                    <div class="section-icon">

                                        <i class="fa-solid fa-images"></i>

                                    </div>


                                    <div>

                                        <h3>
                                            Additional Images
                                        </h3>

                                        <p>
                                            Add extra product views if available.
                                        </p>

                                    </div>

                                </div>


                                <label class="form-label">

                                    Additional Product Images

                                </label>


                                <input
                                    type="file"
                                    name="images[]"
                                    class="extra-upload"
                                    multiple
                                    accept="image/jpeg,image/png,image/jpg,image/webp"
                                >


                                <small class="help-text">

                                    Optional — upload up to 8 additional
                                    product views such as front, back, side
                                    and detail images.

                                </small>

                            </section>



                            {{-- =================================================
                                 PUBLISH STATUS
                            ================================================== --}}

                            <section class="section-card publish-card">


                                <div class="section-heading">

                                    <div class="section-icon">

                                        <i class="fa-solid fa-bullhorn"></i>

                                    </div>


                                    <div>

                                        <h3>
                                            Publishing
                                        </h3>

                                        <p>
                                            Choose how this product should appear.
                                        </p>

                                    </div>

                                </div>


                                <div class="publish-status">


                                    <div class="publish-status-left">

                                        <div class="status-icon">

                                            <i class="fa-solid fa-eye"></i>

                                        </div>


                                        <div>

                                            <strong>
                                                Product Status
                                            </strong>

                                            <small>
                                                Control product visibility
                                            </small>

                                        </div>

                                    </div>


                                    <div class="status-dot"></div>

                                </div>


                                <label class="form-label">

                                    Product Status

                                </label>


                                <select
                                    name="status"
                                    class="form-select"
                                >

                                    <option
                                        value="active"
                                        {{ old('status','active') === 'active' ? 'selected' : '' }}
                                    >
                                        Active
                                    </option>


                                    <option
                                        value="inactive"
                                        {{ old('status') === 'inactive' ? 'selected' : '' }}
                                    >
                                        Inactive
                                    </option>

                                </select>


                                <div class="publish-note">

                                    <i class="fa-solid fa-circle-info"></i>

                                    <span>

                                        Active products can be displayed to
                                        customers according to your store
                                        settings.

                                    </span>

                                </div>

                            </section>

                        </aside>

                    </div>

                </form>

            </div>

        </section>



        {{-- =====================================================
             FOOTER
        ====================================================== --}}

        <div class="page-footer">

            SMART BASKET • Seller Partner Panel

        </div>

    </div>

</main>



<script>
    /* =========================================================
       PRODUCT IMAGE PREVIEW
    ========================================================= */

    function previewImage(input) {

        const preview =
            document.getElementById('imagePreview');

        const previewWrapper =
            document.getElementById('previewWrapper');

        const uploadZone =
            document.getElementById('uploadZone');

        const previewFileName =
            document.getElementById('previewFileName');


        if (
            !input.files ||
            !input.files[0]
        ) {

            previewWrapper.classList.remove('show');

            uploadZone.classList.remove('has-image');

            preview.src = '';

            if (previewFileName) {
                previewFileName.textContent = 'Ready';
            }

            return;
        }


        const file =
            input.files[0];


        const allowedTypes = [

            'image/jpeg',
            'image/png',
            'image/jpg',
            'image/webp'

        ];


        /* =====================================================
           FILE TYPE VALIDATION
        ====================================================== */

        if (!allowedTypes.includes(file.type)) {

            alert(
                'Please select a valid image: JPG, JPEG, PNG or WEBP.'
            );

            input.value = '';

            previewWrapper.classList.remove('show');

            uploadZone.classList.remove('has-image');

            preview.src = '';

            if (previewFileName) {
                previewFileName.textContent = 'Ready';
            }

            return;
        }


        /* =====================================================
           FILE SIZE VALIDATION
        ====================================================== */

        if (file.size > 2 * 1024 * 1024) {

            alert(
                'Image size must be less than 2MB.'
            );

            input.value = '';

            previewWrapper.classList.remove('show');

            uploadZone.classList.remove('has-image');

            preview.src = '';

            if (previewFileName) {
                previewFileName.textContent = 'Ready';
            }

            return;
        }


        /* =====================================================
           FILE NAME
        ====================================================== */

        if (previewFileName) {

            previewFileName.textContent =
                file.name;

        }


        /* =====================================================
           IMAGE PREVIEW
        ====================================================== */

        const reader =
            new FileReader();


        reader.onload =
            function(event) {

                preview.src =
                    event.target.result;

                previewWrapper.classList.add(
                    'show'
                );

                uploadZone.classList.add(
                    'has-image'
                );

            };


        reader.onerror =
            function() {

                alert(
                    'Unable to preview this image. Please try another file.'
                );

                input.value = '';

                previewWrapper.classList.remove(
                    'show'
                );

                uploadZone.classList.remove(
                    'has-image'
                );

                preview.src = '';

                if (previewFileName) {
                    previewFileName.textContent = 'Ready';
                }

            };


        reader.readAsDataURL(file);

    }



    /* =========================================================
       PRODUCT VIDEO PREVIEW
       NEW
    ========================================================= */

    function previewVideo(input) {

        const preview =
            document.getElementById('videoPreview');

        const previewWrapper =
            document.getElementById('videoPreviewWrapper');

        const uploadZone =
            document.getElementById('videoUploadZone');

        const previewFileName =
            document.getElementById('videoPreviewFileName');


        if (
            !input.files ||
            !input.files[0]
        ) {

            resetVideoPreview();

            return;
        }


        const file =
            input.files[0];


        const allowedTypes = [

            'video/mp4',
            'video/webm',
            'video/quicktime'

        ];


        /* =====================================================
           VIDEO TYPE VALIDATION
        ====================================================== */

        if (!allowedTypes.includes(file.type)) {

            alert(
                'Please select a valid video: MP4, WEBM or MOV.'
            );

            input.value = '';

            resetVideoPreview();

            return;
        }


        /* =====================================================
           VIDEO SIZE VALIDATION
        ====================================================== */

        if (file.size > 20 * 1024 * 1024) {

            alert(
                'Video size must be less than 20MB.'
            );

            input.value = '';

            resetVideoPreview();

            return;
        }


        /* =====================================================
           FILE NAME
        ====================================================== */

        if (previewFileName) {

            previewFileName.textContent =
                file.name;

        }


        /* =====================================================
           CREATE TEMPORARY PREVIEW URL
        ====================================================== */

        const videoUrl =
            URL.createObjectURL(file);


        preview.src =
            videoUrl;


        previewWrapper.classList.add(
            'show'
        );


        uploadZone.classList.add(
            'has-video'
        );


        preview.load();


        /* =====================================================
           CLEAN TEMPORARY OBJECT URL
        ====================================================== */

        preview.addEventListener(
            'loadeddata',
            function() {

                URL.revokeObjectURL(videoUrl);

            },
            {
                once: true
            }
        );


        preview.addEventListener(
            'error',
            function() {

                alert(
                    'Unable to preview this video. Please try another video file.'
                );

                input.value = '';

                resetVideoPreview();

            },
            {
                once: true
            }
        );

    }



    /* =========================================================
       RESET VIDEO PREVIEW
    ========================================================= */

    function resetVideoPreview() {

        const preview =
            document.getElementById('videoPreview');

        const previewWrapper =
            document.getElementById('videoPreviewWrapper');

        const uploadZone =
            document.getElementById('videoUploadZone');

        const previewFileName =
            document.getElementById('videoPreviewFileName');


        if (previewWrapper) {

            previewWrapper.classList.remove(
                'show'
            );

        }


        if (uploadZone) {

            uploadZone.classList.remove(
                'has-video'
            );

        }


        if (preview) {

            preview.pause();

            preview.removeAttribute('src');

            preview.load();

        }


        if (previewFileName) {

            previewFileName.textContent =
                'Ready';

        }

    }



    /* =========================================================
       KEYBOARD ACCESS FOR UPLOAD AREAS
    ========================================================= */

    document.addEventListener(
        'DOMContentLoaded',
        function() {

            const uploadZone =
                document.getElementById('uploadZone');

            const imageInput =
                document.getElementById('imageInput');


            if (
                uploadZone &&
                imageInput
            ) {

                uploadZone.addEventListener(
                    'keydown',
                    function(event) {

                        if (
                            event.key === 'Enter' ||
                            event.key === ' '
                        ) {

                            event.preventDefault();

                            imageInput.click();

                        }

                    }
                );

            }


            /* =================================================
               VIDEO KEYBOARD ACCESS
            ================================================= */

            const videoUploadZone =
                document.getElementById('videoUploadZone');

            const videoInput =
                document.getElementById('videoInput');


            if (
                videoUploadZone &&
                videoInput
            ) {

                videoUploadZone.addEventListener(
                    'keydown',
                    function(event) {

                        if (
                            event.key === 'Enter' ||
                            event.key === ' '
                        ) {

                            event.preventDefault();

                            videoInput.click();

                        }

                    }
                );

            }

        }
    );



    /* =========================================================
       FORM SUBMIT LOADING STATE
       Backend functionality unchanged.
    ========================================================= */

    document.addEventListener(
        'DOMContentLoaded',
        function() {

            const form =
                document.getElementById('addProductForm');

            const submitButton =
                document.getElementById('submitButton');


            if (
                !form ||
                !submitButton
            ) {

                return;

            }


            form.addEventListener(
                'submit',
                function() {

                    if (!form.checkValidity()) {

                        return;

                    }


                    submitButton.classList.add(
                        'is-loading'
                    );


                    const icon =
                        submitButton.querySelector(
                            '.submit-icon'
                        );


                    const text =
                        submitButton.querySelector(
                            'span'
                        );


                    if (icon) {

                        icon.className =
                            'fa-solid fa-spinner submit-icon';

                    }


                    if (text) {

                        text.textContent =
                            'ADDING PRODUCT...';

                    }

                }
            );

        }
    );
</script>


</body>

</html>
