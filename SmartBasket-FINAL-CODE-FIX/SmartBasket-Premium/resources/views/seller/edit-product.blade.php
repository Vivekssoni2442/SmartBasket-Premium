<!DOCTYPE html>
<html lang="en" data-sb-theme="light">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Product | SMART BASKET</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

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
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>

        /* =========================================================
           SMART BASKET EDIT PRODUCT
           FULL WIDTH PREMIUM DESIGN
        ========================================================== */

        :root {

            --ep-primary: #2563eb;
            --ep-primary-dark: #1d4ed8;
            --ep-primary-deep: #1e40af;
            --ep-blue: #3b82f6;

            --ep-page: #f5f8ff;
            --ep-card: #ffffff;
            --ep-soft: #f8faff;

            --ep-border: #dbe5f4;
            --ep-border-light: #e8eef8;

            --ep-text: #172033;
            --ep-text-soft: #526078;
            --ep-muted: #7b879d;

            --ep-success: #16a34a;
            --ep-danger: #dc2626;
            --ep-warning: #d97706;

            --ep-shadow:
                0 18px 50px rgba(30, 64, 175, .08);

            --ep-shadow-small:
                0 8px 24px rgba(30, 64, 175, .07);

        }


        * {
            box-sizing: border-box;
        }


        html,
        body {

            width: 100%;
            max-width: 100%;

            margin: 0;
            padding: 0;

            font-family: "Inter", sans-serif;

            background:
                #f5f8ff;

            color:
                var(--ep-text);

        }


        body {

            overflow-x:
                hidden;

        }


        /* =========================================================
           FULL WIDTH PAGE
        ========================================================== */

        .sb-edit-product-page {

            position: relative;

            isolation: isolate;

            width: 100% !important;
            max-width: none !important;

            min-height: 100vh;

            margin: 0 !important;

            padding:
                28px 18px 34px;

            background:

                radial-gradient(
                    circle at 8% 5%,
                    rgba(59, 130, 246, .10),
                    transparent 28%
                ),

                radial-gradient(
                    circle at 94% 18%,
                    rgba(37, 99, 235, .08),
                    transparent 25%
                ),

                linear-gradient(
                    180deg,
                    #f8fbff 0%,
                    #f3f7fd 100%
                );

        }


        .sb-edit-product-page .ep-container {

            width: 100% !important;

            max-width: none !important;

            margin: 0 auto !important;

        }


        /* =========================================================
           TITLE CARD
        ========================================================== */

        .sb-edit-product-page .ep-header {

            width: 100%;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            padding: 22px 24px;

            margin-bottom: 18px;

            border:
                1px solid rgba(37, 99, 235, .13);

            border-radius: 22px;

            background:

                linear-gradient(
                    135deg,
                    #ffffff 0%,
                    #f7faff 100%
                );

            box-shadow:
                0 14px 45px rgba(30, 64, 175, .09);

            position: relative;

            overflow: hidden;

        }


        .sb-edit-product-page .ep-header::before {

            content: "";

            position: absolute;

            top: 0;
            left: 0;

            width: 5px;
            height: 100%;

            background:
                linear-gradient(
                    180deg,
                    var(--ep-primary),
                    #60a5fa
                );

        }


        .sb-edit-product-page .ep-header::after {

            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            right: -70px;
            top: -100px;

            border-radius: 50%;

            background:
                rgba(59, 130, 246, .07);

            pointer-events: none;

        }


        .sb-edit-product-page .ep-header-left {

            min-width: 0;

            display: flex;

            align-items: center;

            gap: 16px;

            position: relative;

            z-index: 2;

        }


        .sb-edit-product-page .ep-header-icon {

            width: 58px;
            height: 58px;

            flex: 0 0 58px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 16px;

            color: #fff;

            font-size: 21px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            box-shadow:
                0 10px 24px rgba(37, 99, 235, .25);

        }


        .sb-edit-product-page .ep-header-content {

            min-width: 0;

        }


        .sb-edit-product-page .ep-eyebrow {

            display: flex;

            align-items: center;

            gap: 7px;

            margin-bottom: 5px;

            color:
                var(--ep-primary);

            font-size: 11px;

            font-weight: 800;

            letter-spacing: .08em;

            text-transform: uppercase;

        }


        .sb-edit-product-page .ep-eyebrow-dot {

            width: 7px;
            height: 7px;

            border-radius: 50%;

            background:
                #22c55e;

            box-shadow:
                0 0 0 4px rgba(34, 197, 94, .10);

        }


        .sb-edit-product-page .ep-title {

            margin: 0;

            color:
                #172033;

            font-size: 27px;

            line-height: 1.15;

            font-weight: 800;

            letter-spacing: -.03em;

        }


        .sb-edit-product-page .ep-subtitle {

            margin: 6px 0 0;

            color:
                var(--ep-text-soft);

            font-size: 12px;

            line-height: 1.6;

        }


        .sb-edit-product-page .ep-product-id {

            position: relative;

            z-index: 2;

            flex-shrink: 0;

            display: inline-flex;

            align-items: center;

            gap: 7px;

            padding: 10px 13px;

            border:
                1px solid #d7e3f5;

            border-radius: 12px;

            background:
                #f8fbff;

            color:
                #31527e;

            font-size: 11px;

            font-weight: 700;

            white-space: nowrap;

        }


        .sb-edit-product-page .ep-product-id i {

            color:
                var(--ep-primary);

        }


        /* =========================================================
           ALERTS
        ========================================================== */

        .sb-edit-product-page .ep-alert {

            width: 100%;

            display: flex;

            align-items: flex-start;

            gap: 11px;

            margin-bottom: 16px;

            padding: 13px 15px;

            border-radius: 13px;

            font-size: 12px;

            line-height: 1.5;

        }


        .sb-edit-product-page .ep-alert i {

            margin-top: 1px;

            font-size: 15px;

            flex-shrink: 0;

        }


        .sb-edit-product-page .ep-alert-success {

            color: #166534;

            border:
                1px solid #bbf7d0;

            background:
                #f0fdf4;

        }


        .sb-edit-product-page .ep-alert-error {

            color: #991b1b;

            border:
                1px solid #fecaca;

            background:
                #fef2f2;

        }


        .sb-edit-product-page .ep-validation-list {

            display: grid;

            gap: 4px;

        }


        /* =========================================================
           FORM CARD
        ========================================================== */

        .sb-edit-product-page .ep-form-card {

            width: 100%;

            margin: 0;

            padding: 26px;

            border:
                1px solid var(--ep-border);

            border-radius: 22px;

            background:
                rgba(255,255,255,.96);

            box-shadow:
                var(--ep-shadow);

        }


        /* =========================================================
           SECTION
        ========================================================== */

        .sb-edit-product-page .ep-section {

            width: 100%;

            margin-bottom: 34px;

        }


        .sb-edit-product-page .ep-section:last-child {

            margin-bottom: 0;

        }


        .sb-edit-product-page .ep-section-heading {

            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 20px;

            padding-bottom: 13px;

            border-bottom:
                1px solid var(--ep-border-light);

        }


        .sb-edit-product-page .ep-section-icon {

            width: 42px;
            height: 42px;

            flex: 0 0 42px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 12px;

            color:
                var(--ep-primary);

            background:
                linear-gradient(
                    135deg,
                    #eff6ff,
                    #e8f1ff
                );

            border:
                1px solid #dbeafe;

            font-size: 15px;

        }


        .sb-edit-product-page .ep-section-title-wrap {

            min-width: 0;

        }


        .sb-edit-product-page .ep-section-title {

            margin: 0;

            color:
                #182338;

            font-size: 17px;

            font-weight: 800;

        }


        .sb-edit-product-page .ep-section-description {

            margin: 3px 0 0;

            color:
                var(--ep-muted);

            font-size: 11px;

            line-height: 1.5;

        }


        /* =========================================================
           FIELDS
        ========================================================== */

        .sb-edit-product-page .ep-fields {

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 18px;

        }


        .sb-edit-product-page .ep-fields-three {

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

        }


        .sb-edit-product-page .ep-field {

            min-width: 0;

        }


        .sb-edit-product-page .ep-field-full {

            grid-column:
                1 / -1;

        }


        .sb-edit-product-page .ep-label {

            display: block;

            margin-bottom: 7px;

            color:
                #334155;

            font-size: 11px;

            font-weight: 700;

        }


        .sb-edit-product-page .ep-required {

            color:
                #dc2626;

        }


        .sb-edit-product-page .ep-optional {

            color:
                #94a3b8;

            font-weight: 500;

        }


        .sb-edit-product-page .ep-input-wrap {

            position: relative;

        }


        .sb-edit-product-page .ep-field-icon {

            position: absolute;

            left: 13px;

            top: 50%;

            transform:
                translateY(-50%);

            color:
                #7190ba;

            font-size: 13px;

            pointer-events: none;

            z-index: 2;

        }


        .sb-edit-product-page .ep-control,
        .sb-edit-product-page .ep-select {

            width: 100%;

            min-height: 47px;

            border:
                1px solid #d7e1ef;

            border-radius: 12px;

            outline: none;

            background:
                #ffffff;

            color:
                #1e293b;

            font-family: inherit;

            font-size: 12px;

            font-weight: 500;

            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease;

        }


        .sb-edit-product-page .ep-control {

            padding: 12px 13px;

        }


        .sb-edit-product-page .ep-control.has-icon {

            padding-left: 40px;

        }


        .sb-edit-product-page .ep-select {

            padding:
                0 38px 0 13px;

            cursor: pointer;

        }


        .sb-edit-product-page .ep-control:focus,
        .sb-edit-product-page .ep-select:focus {

            border-color:
                var(--ep-primary);

            box-shadow:
                0 0 0 4px rgba(37,99,235,.09);

            background:
                #fbfdff;

        }


        .sb-edit-product-page textarea.ep-control {

            min-height: 135px;

            resize: vertical;

            line-height: 1.65;

        }


        .sb-edit-product-page .ep-status-help {

            display: flex;

            align-items: center;

            gap: 6px;

            margin-top: 7px;

            color:
                #718096;

            font-size: 10px;

        }


        .sb-edit-product-page .ep-status-help i {

            color:
                var(--ep-primary);

        }


        /* =========================================================
           IMAGE LAYOUT
        ========================================================== */

        .sb-edit-product-page .ep-image-layout {

            display: grid;

            grid-template-columns:
                minmax(300px, .85fr)
                minmax(0, 1.15fr);

            gap: 20px;

        }


        .sb-edit-product-page .ep-image-card,
        .sb-edit-product-page .ep-upload-card,
        .sb-edit-product-page .ep-video-card,
        .sb-edit-product-page .ep-tool-card {

            min-width: 0;

            padding: 17px;

            border:
                1px solid var(--ep-border);

            border-radius: 16px;

            background:
                #fbfdff;

        }


        .sb-edit-product-page .ep-card-title,
        .sb-edit-product-page .ep-upload-title,
        .sb-edit-product-page .ep-tool-card-title {

            display: flex;

            align-items: center;

            gap: 8px;

            margin-bottom: 14px;

            color:
                #25344e;

            font-size: 12px;

            font-weight: 800;

        }


        .sb-edit-product-page .ep-card-title i,
        .sb-edit-product-page .ep-upload-title i,
        .sb-edit-product-page .ep-tool-card-title i {

            color:
                var(--ep-primary);

        }


        .sb-edit-product-page .ep-current-image-wrap {

            width: 100%;

            min-height: 310px;

            display: flex;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            border-radius: 14px;

            border:
                1px solid #e2e8f0;

            background:
                linear-gradient(
                    135deg,
                    #f8fafc,
                    #eef4fb
                );

        }


        .sb-edit-product-page .ep-current-image {

            width: 100%;

            height: 300px;

            display: block;

            object-fit: contain;

        }


        .sb-edit-product-page .ep-no-image {

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            gap: 10px;

            color:
                #94a3b8;

            font-size: 11px;

        }


        .sb-edit-product-page .ep-no-image i {

            font-size: 36px;

        }


        .sb-edit-product-page .ep-note {

            margin-top: 10px;

            color:
                #718096;

            font-size: 10px;

            line-height: 1.55;

        }


        .sb-edit-product-page .ep-note i {

            color:
                var(--ep-primary);

            margin-right: 4px;

        }


        .sb-edit-product-page .ep-upload-stack {

            display: grid;

            gap: 14px;

        }


        .sb-edit-product-page .ep-info-box {

            display: flex;

            align-items: flex-start;

            gap: 10px;

            padding: 13px;

            border:
                1px solid #dbeafe;

            border-radius: 13px;

            color:
                #31527e;

            background:
                #eff6ff;

            font-size: 10px;

            line-height: 1.55;

        }


        .sb-edit-product-page .ep-info-box i {

            margin-top: 2px;

            color:
                var(--ep-primary);

        }


        /* =========================================================
           GALLERY
        ========================================================== */

        .sb-edit-product-page .ep-gallery-heading {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;

            margin-top: 17px;

            margin-bottom: 10px;

        }


        .sb-edit-product-page .ep-gallery-label {

            color:
                #334155;

            font-size: 11px;

            font-weight: 800;

        }


        .sb-edit-product-page .ep-image-count {

            padding:
                5px 8px;

            border-radius: 8px;

            color:
                #31527e;

            background:
                #eff6ff;

            font-size: 9px;

            font-weight: 700;

        }


        .sb-edit-product-page .ep-gallery {

            display: grid;

            grid-template-columns:
                repeat(5, minmax(0, 1fr));

            gap: 9px;

        }


        .sb-edit-product-page .ep-gallery-card {

            aspect-ratio: 1;

            overflow: hidden;

            border:
                1px solid #dce5f1;

            border-radius: 10px;

            background:
                #fff;

        }


        .sb-edit-product-page .ep-gallery-image {

            width: 100%;
            height: 100%;

            display: block;

            object-fit: cover;

        }


        /* =========================================================
           VIDEO
        ========================================================== */

        .sb-edit-product-page .ep-video-layout {

            display: grid;

            grid-template-columns:
                minmax(0, 1.1fr)
                minmax(340px, .9fr);

            gap: 20px;

        }


        .sb-edit-product-page .ep-video-card {

            padding: 18px;

        }


        .sb-edit-product-page .ep-video-card-head {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 12px;

            margin-bottom: 13px;

        }


        .sb-edit-product-page .ep-video-card-title {

            display: flex;

            align-items: center;

            gap: 8px;

            color:
                #25344e;

            font-size: 12px;

            font-weight: 800;

        }


        .sb-edit-product-page .ep-video-card-title i {

            color:
                var(--ep-primary);

        }


        .sb-edit-product-page .ep-video-status {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding: 6px 9px;

            border:
                1px solid #bbf7d0;

            border-radius: 8px;

            color: #166534;

            background: #f0fdf4;

            font-size: 8px;

            font-weight: 800;

            letter-spacing: .04em;

        }


        .sb-edit-product-page .ep-video-status-dot {

            width: 6px;
            height: 6px;

            border-radius: 50%;

            background:
                #22c55e;

        }


        .sb-edit-product-page .ep-video-preview {

            width: 100%;

            min-height: 390px;

            overflow: hidden;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 14px;

            background:
                #0f172a;

        }


        .sb-edit-product-page .ep-video-element {

            width: 100%;

            height: 390px;

            display: block;

            object-fit: contain;

            background:
                #0f172a;

        }


        .sb-edit-product-page .ep-video-placeholder {

            width: 100%;

            min-height: 390px;

            display: flex;

            flex-direction: column;

            align-items: center;
            justify-content: center;

            gap: 10px;

            padding: 25px;

            text-align: center;

            color:
                #cbd5e1;

            background:
                radial-gradient(
                    circle at center,
                    #1e293b,
                    #0f172a
                );

        }


        .sb-edit-product-page .ep-video-placeholder strong {

            color:
                #f8fafc;

            font-size: 14px;

        }


        .sb-edit-product-page .ep-video-placeholder span {

            max-width: 360px;

            color:
                #94a3b8;

            font-size: 10px;

            line-height: 1.55;

        }


        .sb-edit-product-page .ep-video-placeholder-icon {

            width: 72px;
            height: 72px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 20px;

            color:
                #93c5fd;

            background:
                rgba(59,130,246,.15);

            border:
                1px solid rgba(147,197,253,.18);

            font-size: 27px;

        }


        /* =========================================================
           VIDEO META
        ========================================================== */

        .sb-edit-product-page .ep-video-meta {

            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 9px;

            margin-top: 12px;

        }


        .sb-edit-product-page .ep-video-meta-item {

            padding: 10px;

            border:
                1px solid #e2e8f0;

            border-radius: 10px;

            background:
                #fff;

        }


        .sb-edit-product-page .ep-video-meta-label {

            display: block;

            margin-bottom: 4px;

            color:
                #94a3b8;

            font-size: 8px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .05em;

        }


        .sb-edit-product-page .ep-video-meta-value {

            color:
                #334155;

            font-size: 11px;

            font-weight: 800;

        }


        /* =========================================================
           VIDEO TOOLS
        ========================================================== */

        .sb-edit-product-page .ep-video-tools {

            display: grid;

            gap: 13px;

        }


        .sb-edit-product-page .ep-video-upload {

            min-height: 145px;

            display: flex;

            flex-direction: column;

            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 18px;

            border:
                1.5px dashed #a9c4ee;

            border-radius: 13px;

            text-align: center;

            cursor: pointer;

            background:
                #f8fbff;

            transition:
                .2s ease;

        }


        .sb-edit-product-page .ep-video-upload:hover,
        .sb-edit-product-page .ep-video-upload.dragover {

            border-color:
                var(--ep-primary);

            background:
                #eff6ff;

        }


        .sb-edit-product-page .ep-video-upload strong {

            color:
                #334155;

            font-size: 11px;

        }


        .sb-edit-product-page .ep-video-upload span {

            color:
                #94a3b8;

            font-size: 9px;

        }


        .sb-edit-product-page .ep-video-upload-icon {

            width: 46px;
            height: 46px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 13px;

            color:
                var(--ep-primary);

            background:
                #eaf2ff;

            font-size: 17px;

        }


        .sb-edit-product-page .ep-hidden-file {

            display: none;

        }


        .sb-edit-product-page .ep-selected-file {

            display: none;

            align-items: center;

            gap: 8px;

            margin-top: 10px;

            padding: 9px 10px;

            border:
                1px solid #bbf7d0;

            border-radius: 9px;

            color:
                #166534;

            background:
                #f0fdf4;

            font-size: 10px;

            font-weight: 700;

        }


        .sb-edit-product-page .ep-selected-file.show {

            display: flex;

        }


        .sb-edit-product-page .ep-video-notice {

            display: flex;

            align-items: flex-start;

            gap: 8px;

            margin-top: 10px;

            padding: 10px;

            border:
                1px solid #dbeafe;

            border-radius: 9px;

            color:
                #52709b;

            background:
                #eff6ff;

            font-size: 9px;

            line-height: 1.5;

        }


        .sb-edit-product-page .ep-video-notice i {

            color:
                var(--ep-primary);

            margin-top: 2px;

        }


        /* =========================================================
           TOOL GRID
        ========================================================== */

        .sb-edit-product-page .ep-tool-grid {

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 8px;

        }


        .sb-edit-product-page .ep-tool-button {

            min-height: 40px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 8px 10px;

            border:
                1px solid #d8e2ef;

            border-radius: 10px;

            background:
                #fff;

            color:
                #3c4c65;

            font-family: inherit;

            font-size: 10px;

            font-weight: 700;

            cursor: pointer;

            transition:
                .2s ease;

        }


        .sb-edit-product-page .ep-tool-button:hover {

            color:
                var(--ep-primary);

            border-color:
                #9bbdf2;

            background:
                #eff6ff;

            transform:
                translateY(-1px);

        }


        .sb-edit-product-page .ep-tool-button i {

            color:
                var(--ep-primary);

        }


        .sb-edit-product-page .ep-tool-select {

            width: 100%;

            min-height: 43px;

            padding: 0 12px;

            border:
                1px solid #d7e1ef;

            border-radius: 10px;

            outline: none;

            background:
                #fff;

            color:
                #334155;

            font-family: inherit;

            font-size: 10px;

            font-weight: 600;

        }


        .sb-edit-product-page .ep-range-label {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 9px;

            color:
                #64748b;

            font-size: 9px;

            font-weight: 600;

        }


        .sb-edit-product-page .ep-range-value {

            color:
                var(--ep-primary);

            font-weight: 800;

        }


        .sb-edit-product-page .ep-range {

            width: 100%;

            accent-color:
                var(--ep-primary);

            cursor: pointer;

        }


        /* =========================================================
           TOGGLES
        ========================================================== */

        .sb-edit-product-page .ep-toggle-row {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            padding: 11px 0;

            border-bottom:
                1px solid #edf2f7;

        }


        .sb-edit-product-page .ep-toggle-row:last-child {

            border-bottom: 0;

        }


        .sb-edit-product-page .ep-toggle-info {

            min-width: 0;

        }


        .sb-edit-product-page .ep-toggle-title {

            color:
                #334155;

            font-size: 10px;

            font-weight: 800;

        }


        .sb-edit-product-page .ep-toggle-desc {

            margin-top: 3px;

            color:
                #94a3b8;

            font-size: 8px;

            line-height: 1.45;

        }


        .sb-edit-product-page .ep-switch {

            position: relative;

            width: 42px;
            height: 23px;

            flex: 0 0 42px;

        }


        .sb-edit-product-page .ep-switch input {

            opacity: 0;

            width: 0;
            height: 0;

        }


        .sb-edit-product-page .ep-slider {

            position: absolute;

            inset: 0;

            border-radius: 30px;

            cursor: pointer;

            background:
                #cbd5e1;

            transition:
                .2s ease;

        }


        .sb-edit-product-page .ep-slider::before {

            content: "";

            position: absolute;

            width: 17px;
            height: 17px;

            left: 3px;
            top: 3px;

            border-radius: 50%;

            background:
                #fff;

            box-shadow:
                0 2px 5px rgba(0,0,0,.15);

            transition:
                .2s ease;

        }


        .sb-edit-product-page .ep-switch input:checked + .ep-slider {

            background:
                var(--ep-primary);

        }


        .sb-edit-product-page .ep-switch input:checked + .ep-slider::before {

            transform:
                translateX(19px);

        }


        /* =========================================================
           ACTION
        ========================================================== */

        .sb-edit-product-page .ep-actions {

            display: flex;

            justify-content: flex-end;

            margin-top: 10px;

            padding-top: 23px;

            border-top:
                1px solid var(--ep-border-light);

        }


        .sb-edit-product-page .ep-update-button {

            min-width: 230px;

            min-height: 51px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 10px;

            padding: 0 22px;

            border: 0;

            border-radius: 13px;

            color:
                #fff;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            box-shadow:
                0 10px 24px rgba(37,99,235,.22);

            font-family: inherit;

            font-size: 11px;

            font-weight: 800;

            letter-spacing: .04em;

            cursor: pointer;

            transition:
                .2s ease;

        }


        .sb-edit-product-page .ep-update-button:hover {

            transform:
                translateY(-2px);

            box-shadow:
                0 14px 30px rgba(37,99,235,.28);

        }


        .sb-edit-product-page .ep-update-button:active {

            transform:
                translateY(0);

        }


        .sb-edit-product-page .ep-button-icon {

            width: 27px;
            height: 27px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background:
                rgba(255,255,255,.14);

        }


        .sb-edit-product-page .ep-loading-spinner {

            display: none;

            width: 15px;
            height: 15px;

            border:
                2px solid rgba(255,255,255,.35);

            border-top-color:
                #fff;

            border-radius: 50%;

            animation:
                epSpin .7s linear infinite;

        }


        .sb-edit-product-page .ep-update-button.loading {

            pointer-events: none;

            opacity: .82;

        }


        .sb-edit-product-page .ep-update-button.loading
        .ep-loading-spinner {

            display: block;

        }


        .sb-edit-product-page .ep-update-button.loading
        .ep-button-icon {

            display: none;

        }


        @keyframes epSpin {

            to {
                transform: rotate(360deg);
            }

        }


        /* =========================================================
           FOOTER
        ========================================================== */

        .sb-edit-product-page .ep-footer {

            width: 100%;

            padding-top: 18px;

            text-align: center;

            color:
                #8a98ad;

            font-size: 9px;

            font-weight: 600;

            letter-spacing: .04em;

        }


        .sb-edit-product-page .ep-footer span {

            margin: 0 5px;

            color:
                #b4c0d0;

        }


        /* =========================================================
           LARGE SCREEN
        ========================================================== */

        @media (min-width: 1600px) {

            .sb-edit-product-page {

                padding-left: 28px;
                padding-right: 28px;

            }

            .sb-edit-product-page .ep-form-card {

                padding: 30px;

            }

            .sb-edit-product-page .ep-video-preview,
            .sb-edit-product-page .ep-video-element,
            .sb-edit-product-page .ep-video-placeholder {

                min-height: 450px;
                height: 450px;

            }

        }


        /* =========================================================
           TABLET / SMALL DESKTOP
        ========================================================== */

        @media (max-width: 1150px) {

            .sb-edit-product-page .ep-image-layout,
            .sb-edit-product-page .ep-video-layout {

                grid-template-columns: 1fr;

            }

            .sb-edit-product-page .ep-video-tools {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

            }

        }


        @media (max-width: 850px) {

            .sb-edit-product-page {

                padding:
                    20px 12px 25px;

            }


            .sb-edit-product-page .ep-header {

                align-items: flex-start;

                flex-direction: column;

                padding: 18px;

            }


            .sb-edit-product-page .ep-product-id {

                align-self: flex-start;

            }


            .sb-edit-product-page .ep-fields-three {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

            }


            .sb-edit-product-page .ep-video-tools {

                grid-template-columns: 1fr;

            }

        }


        /* =========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 650px) {

            .sb-edit-product-page {

                padding:
                    15px 9px 20px;

            }


            .sb-edit-product-page .ep-header {

                padding:
                    15px;

                border-radius:
                    17px;

            }


            .sb-edit-product-page .ep-header-left {

                gap:
                    11px;

            }


            .sb-edit-product-page .ep-header-icon {

                width: 46px;
                height: 46px;

                flex-basis: 46px;

                border-radius:
                    12px;

                font-size:
                    17px;

            }


            .sb-edit-product-page .ep-title {

                font-size:
                    21px;

            }


            .sb-edit-product-page .ep-subtitle {

                font-size:
                    9px;

            }


            .sb-edit-product-page .ep-product-id {

                padding:
                    8px 10px;

                font-size:
                    9px;

            }


            .sb-edit-product-page .ep-form-card {

                padding:
                    15px;

                border-radius:
                    17px;

            }


            .sb-edit-product-page .ep-fields,
            .sb-edit-product-page .ep-fields-three {

                grid-template-columns:
                    1fr;

                gap:
                    14px;

            }


            .sb-edit-product-page .ep-field-full {

                grid-column:
                    auto;

            }


            .sb-edit-product-page .ep-video-meta {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

            }


            .sb-edit-product-page .ep-gallery {

                grid-template-columns:
                    repeat(4, minmax(0, 1fr));

            }


            .sb-edit-product-page .ep-actions {

                justify-content:
                    stretch;

            }


            .sb-edit-product-page .ep-update-button {

                width:
                    100%;

            }

        }


        /* =========================================================
           SMALL MOBILE
        ========================================================== */

        @media (max-width: 360px) {

            .sb-edit-product-page {

                padding:
                    10px 6px 18px;

            }


            .sb-edit-product-page .ep-form-card {

                padding:
                    10px;

            }


            .sb-edit-product-page .ep-title {

                font-size:
                    18px;

            }


            .sb-edit-product-page .ep-video-meta {

                grid-template-columns:
                    1fr 1fr;

            }


            .sb-edit-product-page .ep-gallery {

                grid-template-columns:
                    repeat(3, minmax(0, 1fr));

            }

        }


        /* =========================================================
           REDUCED MOTION
        ========================================================== */

        @media (prefers-reduced-motion: reduce) {

            .sb-edit-product-page *,
            .sb-edit-product-page *::before,
            .sb-edit-product-page *::after {

                scroll-behavior:
                    auto !important;

                transition:
                    none !important;

                animation:
                    none !important;

            }

        }

    </style>

</head>


<body>


    {{-- =========================================================
         COMMON SELLER TOPBAR
         DO NOT MODIFY
    ========================================================== --}}

    @include('seller.partials.topbar')


    {{-- =========================================================
         COMMON SELLER MENU
         DO NOT MODIFY
    ========================================================== --}}

    @include('seller.partials.seller-menu')


    {{-- =========================================================
         EDIT PRODUCT PAGE
    ========================================================== --}}

    <main class="sb-edit-product-page">

        <div class="ep-container">


            {{-- =====================================================
                 PREMIUM TITLE CARD
            ====================================================== --}}

            <header class="ep-header">

                <div class="ep-header-left">

                    <div class="ep-header-icon">

                        <i
                            class="fa-solid fa-pen-to-square"
                            aria-hidden="true"
                        ></i>

                    </div>


                    <div class="ep-header-content">

                        <div class="ep-eyebrow">

                            <span class="ep-eyebrow-dot"></span>

                            Seller Product Center

                        </div>


                        <h1 class="ep-title">
                            Edit Product
                        </h1>


                        <p class="ep-subtitle">
                            Update product details, pricing, inventory,
                            images and product video.
                        </p>

                    </div>

                </div>


                <div class="ep-product-id">

                    <i
                        class="fa-solid fa-hashtag"
                        aria-hidden="true"
                    ></i>

                    Product ID:
                    {{ $product->id }}

                </div>

            </header>


            {{-- SUCCESS --}}

            @if(session('success'))

                <div
                    class="ep-alert ep-alert-success"
                    role="alert"
                >

                    <i
                        class="fa-solid fa-circle-check"
                        aria-hidden="true"
                    ></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            {{-- ERROR --}}

            @if(session('error'))

                <div
                    class="ep-alert ep-alert-error"
                    role="alert"
                >

                    <i
                        class="fa-solid fa-circle-exclamation"
                        aria-hidden="true"
                    ></i>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif


            {{-- VALIDATION --}}

            @if($errors->any())

                <div
                    class="ep-alert ep-alert-error"
                    role="alert"
                >

                    <i
                        class="fa-solid fa-triangle-exclamation"
                        aria-hidden="true"
                    ></i>


                    <div class="ep-validation-list">

                        @foreach($errors->all() as $error)

                            <div>
                                {{ $error }}
                            </div>

                        @endforeach

                    </div>

                </div>

            @endif


            {{-- =====================================================
                 FORM
            ====================================================== --}}

            <section class="ep-form-card">

                <form
                    id="editProductForm"
                    method="POST"
                    action="{{ route('seller.product.update', $product->id) }}"
                    enctype="multipart/form-data"
                >

                    @csrf


                    {{-- BASIC INFORMATION --}}

                    <section class="ep-section">

                        <div class="ep-section-heading">

                            <div class="ep-section-icon">
                                <i class="fa-solid fa-box"></i>
                            </div>

                            <div class="ep-section-title-wrap">

                                <h2 class="ep-section-title">
                                    Basic Information
                                </h2>

                                <p class="ep-section-description">
                                    Update the core information of your product
                                </p>

                            </div>

                        </div>


                        <div class="ep-fields">


                            <div class="ep-field">

                                <label
                                    for="productName"
                                    class="ep-label"
                                >
                                    Product Name
                                    <span class="ep-required">*</span>
                                </label>


                                <div class="ep-input-wrap">

                                    <i
                                        class="fa-solid fa-tag ep-field-icon"
                                    ></i>

                                    <input
                                        id="productName"
                                        type="text"
                                        name="name"
                                        class="ep-control has-icon"
                                        value="{{ old('name', $product->name) }}"
                                        placeholder="Enter product name"
                                        autocomplete="off"
                                        required
                                    >

                                </div>

                            </div>


                            <div class="ep-field">

                                <label
                                    for="productCategory"
                                    class="ep-label"
                                >
                                    Category
                                    <span class="ep-required">*</span>
                                </label>


                                <div class="ep-input-wrap">

                                    <i
                                        class="fa-solid fa-layer-group ep-field-icon"
                                    ></i>

                                    <input
                                        id="productCategory"
                                        type="text"
                                        name="category"
                                        class="ep-control has-icon"
                                        value="{{ old('category', $product->category) }}"
                                        placeholder="e.g. Home Decor"
                                        required
                                    >

                                </div>

                            </div>


                            <div class="ep-field">

                                <label
                                    for="productBrand"
                                    class="ep-label"
                                >
                                    Brand
                                </label>


                                <div class="ep-input-wrap">

                                    <i
                                        class="fa-solid fa-certificate ep-field-icon"
                                    ></i>

                                    <input
                                        id="productBrand"
                                        type="text"
                                        name="brand"
                                        class="ep-control has-icon"
                                        value="{{ old('brand', $product->brand) }}"
                                        placeholder="Enter brand name"
                                    >

                                </div>

                            </div>


                            <div class="ep-field">

                                <label
                                    for="productStatus"
                                    class="ep-label"
                                >
                                    Product Status
                                </label>


                                <select
                                    id="productStatus"
                                    name="status"
                                    class="ep-select"
                                >

                                    <option
                                        value="active"
                                        {{ old('status', $product->status ?? 'active') === 'active' ? 'selected' : '' }}
                                    >
                                        Active
                                    </option>

                                    <option
                                        value="inactive"
                                        {{ old('status', $product->status ?? '') === 'inactive' ? 'selected' : '' }}
                                    >
                                        Inactive
                                    </option>

                                </select>


                                <div class="ep-status-help">

                                    <i class="fa-solid fa-circle-info"></i>

                                    Active products can be displayed to customers.

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- PRICE --}}

                    <section class="ep-section">

                        <div class="ep-section-heading">

                            <div class="ep-section-icon">
                                <i class="fa-solid fa-indian-rupee-sign"></i>
                            </div>

                            <div class="ep-section-title-wrap">

                                <h2 class="ep-section-title">
                                    Price &amp; Inventory
                                </h2>

                                <p class="ep-section-description">
                                    Manage pricing and available product quantity
                                </p>

                            </div>

                        </div>


                        <div class="ep-fields ep-fields-three">


                            <div class="ep-field">

                                <label
                                    for="productPrice"
                                    class="ep-label"
                                >
                                    Selling Price (₹)
                                    <span class="ep-required">*</span>
                                </label>


                                <div class="ep-input-wrap">

                                    <i class="fa-solid fa-indian-rupee-sign ep-field-icon"></i>

                                    <input
                                        id="productPrice"
                                        type="number"
                                        name="price"
                                        class="ep-control has-icon"
                                        value="{{ old('price', $product->price) }}"
                                        step="0.01"
                                        min="0"
                                        required
                                    >

                                </div>

                            </div>


                            <div class="ep-field">

                                <label
                                    for="discountPrice"
                                    class="ep-label"
                                >
                                    Discount Price (₹)
                                    <span class="ep-optional">· Optional</span>
                                </label>


                                <div class="ep-input-wrap">

                                    <i class="fa-solid fa-tags ep-field-icon"></i>

                                    <input
                                        id="discountPrice"
                                        type="number"
                                        name="discount_price"
                                        class="ep-control has-icon"
                                        value="{{ old('discount_price', $product->discount_price) }}"
                                        step="0.01"
                                        min="0"
                                        placeholder="Optional"
                                    >

                                </div>

                            </div>


                            <div class="ep-field">

                                <label
                                    for="productStock"
                                    class="ep-label"
                                >
                                    Stock Quantity
                                    <span class="ep-required">*</span>
                                </label>


                                <div class="ep-input-wrap">

                                    <i class="fa-solid fa-boxes-stacked ep-field-icon"></i>

                                    <input
                                        id="productStock"
                                        type="number"
                                        name="stock"
                                        class="ep-control has-icon"
                                        value="{{ old('stock', $product->stock) }}"
                                        min="0"
                                        required
                                    >

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- PRODUCT DETAILS --}}

                    <section class="ep-section">

                        <div class="ep-section-heading">

                            <div class="ep-section-icon">
                                <i class="fa-solid fa-sliders"></i>
                            </div>

                            <div class="ep-section-title-wrap">

                                <h2 class="ep-section-title">
                                    Product Details
                                </h2>

                                <p class="ep-section-description">
                                    Add specifications and product description
                                </p>

                            </div>

                        </div>


                        <div class="ep-fields">


                            <div class="ep-field">

                                <label
                                    for="productSize"
                                    class="ep-label"
                                >
                                    Size
                                </label>


                                <div class="ep-input-wrap">

                                    <i class="fa-solid fa-ruler-combined ep-field-icon"></i>

                                    <input
                                        id="productSize"
                                        type="text"
                                        name="size"
                                        class="ep-control has-icon"
                                        value="{{ old('size', $product->size) }}"
                                        placeholder="e.g. Medium"
                                    >

                                </div>

                            </div>


                            <div class="ep-field">

                                <label
                                    for="productColor"
                                    class="ep-label"
                                >
                                    Color
                                </label>


                                <div class="ep-input-wrap">

                                    <i class="fa-solid fa-palette ep-field-icon"></i>

                                    <input
                                        id="productColor"
                                        type="text"
                                        name="color"
                                        class="ep-control has-icon"
                                        value="{{ old('color', $product->color) }}"
                                        placeholder="e.g. Golden"
                                    >

                                </div>

                            </div>


                            <div class="ep-field ep-field-full">

                                <label
                                    for="productDescription"
                                    class="ep-label"
                                >
                                    Product Description
                                </label>


                                <textarea
                                    id="productDescription"
                                    name="description"
                                    class="ep-control"
                                    rows="5"
                                    placeholder="Describe your product, features, material, usage and other important details..."
                                >{{ old('description', $product->description) }}</textarea>

                            </div>

                        </div>

                    </section>


                    {{-- PRODUCT IMAGES --}}

                    <section class="ep-section">

                        <div class="ep-section-heading">

                            <div class="ep-section-icon">
                                <i class="fa-solid fa-images"></i>
                            </div>

                            <div class="ep-section-title-wrap">

                                <h2 class="ep-section-title">
                                    Product Images
                                </h2>

                                <p class="ep-section-description">
                                    Manage the main product image and gallery
                                </p>

                            </div>

                        </div>


                        <div class="ep-image-layout">


                            <div class="ep-image-card">

                                <div class="ep-card-title">

                                    <i class="fa-solid fa-image"></i>

                                    Current Main Image

                                </div>


                                @if($product->image)

                                    <div class="ep-current-image-wrap">

                                        <img
                                            src="{{ asset('products/' . $product->image) }}"
                                            class="ep-current-image"
                                            alt="{{ $product->name }}"
                                        >

                                    </div>


                                    <div class="ep-note">

                                        <i class="fa-solid fa-circle-info"></i>

                                        This image is currently used as the
                                        primary image for this product.

                                    </div>

                                @else

                                    <div class="ep-current-image-wrap">

                                        <div class="ep-no-image">

                                            <i class="fa-regular fa-image"></i>

                                            <span>
                                                No main image available
                                            </span>

                                        </div>

                                    </div>

                                @endif

                            </div>


                            <div class="ep-upload-stack">

                                <div class="ep-upload-card">

                                    <div class="ep-upload-title">

                                        <i class="fa-solid fa-camera"></i>

                                        Change Main Image

                                    </div>


                                    <label
                                        for="mainProductImage"
                                        class="ep-label"
                                    >
                                        New Main Product Image
                                        <span class="ep-optional">· Optional</span>
                                    </label>


                                    <input
                                        id="mainProductImage"
                                        type="file"
                                        name="image"
                                        class="ep-control"
                                        accept="image/jpeg,image/png,image/jpg,image/webp"
                                    >


                                    <div class="ep-note">
                                        Supported formats:
                                        JPG, JPEG, PNG and WEBP.
                                    </div>

                                </div>


                                <div class="ep-upload-card">

                                    <div class="ep-upload-title">

                                        <i class="fa-solid fa-photo-film"></i>

                                        Add More Product Images

                                    </div>


                                    <label
                                        for="additionalProductImages"
                                        class="ep-label"
                                    >
                                        Product Gallery
                                        <span class="ep-optional">· Multiple allowed</span>
                                    </label>


                                    <input
                                        id="additionalProductImages"
                                        type="file"
                                        name="images[]"
                                        class="ep-control"
                                        multiple
                                        accept="image/jpeg,image/png,image/jpg,image/webp"
                                    >


                                    <div class="ep-note">
                                        You can select multiple product images
                                        at once to expand your product gallery.
                                    </div>


                                    @if($product->images->isNotEmpty())

                                        <div class="ep-gallery-heading">

                                            <div class="ep-gallery-label">
                                                Existing Gallery Images
                                            </div>

                                            <div class="ep-image-count">

                                                {{ $product->images->count() }}

                                                {{ $product->images->count() === 1 ? 'Image' : 'Images' }}

                                            </div>

                                        </div>


                                        <div class="ep-gallery">

                                            @foreach($product->images as $extraImage)

                                                <div class="ep-gallery-card">

                                                    <img
                                                        src="{{ asset('storage/' . $extraImage->path) }}"
                                                        class="ep-gallery-image"
                                                        alt="Product gallery image"
                                                        loading="lazy"
                                                    >

                                                </div>

                                            @endforeach

                                        </div>

                                    @endif

                                </div>


                                <div class="ep-info-box">

                                    <i class="fa-solid fa-shield-halved"></i>

                                    <span>
                                        Use clear, high-quality product images
                                        with a clean background for the best
                                        customer experience.
                                    </span>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- PRODUCT VIDEO --}}

                    <section class="ep-section ep-video-section">

                        <div class="ep-section-heading">

                            <div class="ep-section-icon">
                                <i class="fa-solid fa-video"></i>
                            </div>

                            <div class="ep-section-title-wrap">

                                <h2 class="ep-section-title">
                                    Product Video
                                </h2>

                                <p class="ep-section-description">
                                    Add, preview and customize the product video
                                </p>

                            </div>

                        </div>


                        <div class="ep-video-layout">


                            {{-- VIDEO PREVIEW --}}

                            <div class="ep-video-card">

                                <div class="ep-video-card-head">

                                    <div class="ep-video-card-title">

                                        <i class="fa-solid fa-circle-play"></i>

                                        Current Product Video

                                    </div>


                                    @if(!empty($product->video))

                                        <div
                                            class="ep-video-status"
                                            id="videoStatusBadge"
                                        >

                                            <span class="ep-video-status-dot"></span>

                                            VIDEO AVAILABLE

                                        </div>

                                    @else

                                        <div
                                            class="ep-video-status"
                                            id="videoStatusBadge"
                                            style="color:#92400e;background:#fffbeb;border-color:#fde68a;"
                                        >

                                            <span
                                                class="ep-video-status-dot"
                                                style="background:#d97706;"
                                            ></span>

                                            NO VIDEO

                                        </div>

                                    @endif

                                </div>


                                <div
                                    class="ep-video-preview"
                                    id="videoPreviewBox"
                                >

                                    @if(!empty($product->video))

                                        <video
                                            id="productVideo"
                                            class="ep-video-element"
                                            preload="metadata"
                                            playsinline
                                            controls
                                        >

                                            <source
                                                src="{{ asset('storage/' . $product->video) }}"
                                                type="video/mp4"
                                            >

                                            Your browser does not support video playback.

                                        </video>

                                    @else

                                        <div
                                            class="ep-video-placeholder"
                                            id="videoPlaceholder"
                                        >

                                            <div class="ep-video-placeholder-icon">

                                                <i class="fa-solid fa-film"></i>

                                            </div>

                                            <strong>
                                                No product video uploaded
                                            </strong>

                                            <span>
                                                Upload a product video from the
                                                video tools panel to preview it here.
                                            </span>

                                        </div>

                                    @endif

                                </div>


                                <div class="ep-video-meta">

                                    <div class="ep-video-meta-item">

                                        <span class="ep-video-meta-label">
                                            Duration
                                        </span>

                                        <span
                                            class="ep-video-meta-value"
                                            id="videoDuration"
                                        >
                                            —
                                        </span>

                                    </div>


                                    <div class="ep-video-meta-item">

                                        <span class="ep-video-meta-label">
                                            Resolution
                                        </span>

                                        <span
                                            class="ep-video-meta-value"
                                            id="videoResolution"
                                        >
                                            —
                                        </span>

                                    </div>


                                    <div class="ep-video-meta-item">

                                        <span class="ep-video-meta-label">
                                            Status
                                        </span>

                                        <span
                                            class="ep-video-meta-value"
                                            id="videoPlayStatus"
                                        >
                                            Ready
                                        </span>

                                    </div>


                                    <div class="ep-video-meta-item">

                                        <span class="ep-video-meta-label">
                                            Speed
                                        </span>

                                        <span
                                            class="ep-video-meta-value"
                                            id="videoSpeedMeta"
                                        >
                                            1×
                                        </span>

                                    </div>

                                </div>

                            </div>


                            {{-- VIDEO TOOLS --}}

                            <div class="ep-video-tools">


                                <div class="ep-tool-card">

                                    <div class="ep-tool-card-title">

                                        <i class="fa-solid fa-cloud-arrow-up"></i>

                                        Upload / Replace Video

                                    </div>


                                    <label
                                        for="productVideoUpload"
                                        class="ep-video-upload"
                                        id="videoDropZone"
                                    >

                                        <div class="ep-video-upload-icon">

                                            <i class="fa-solid fa-video"></i>

                                        </div>


                                        <strong>
                                            Click or drag video here
                                        </strong>


                                        <span>
                                            MP4, WebM or MOV · Recommended MP4
                                        </span>


                                        <input
                                            id="productVideoUpload"
                                            type="file"
                                            name="video"
                                            class="ep-hidden-file"
                                            accept="video/mp4,video/webm,video/quicktime"
                                        >

                                    </label>


                                    <div
                                        class="ep-selected-file"
                                        id="selectedVideoFile"
                                    >

                                        <i class="fa-solid fa-circle-check"></i>

                                        <span id="selectedVideoFileName">
                                            Video selected
                                        </span>

                                    </div>


                                    <div class="ep-video-notice">

                                        <i class="fa-solid fa-circle-info"></i>

                                        <span>
                                            Uploading a new video will replace the
                                            current product video after the form
                                            is successfully saved.
                                        </span>

                                    </div>

                                </div>


                                <div class="ep-tool-card">

                                    <div class="ep-tool-card-title">

                                        <i class="fa-solid fa-sliders"></i>

                                        Video Tools

                                    </div>


                                    <div class="ep-tool-grid">

                                        <button
                                            type="button"
                                            class="ep-tool-button"
                                            id="videoPlayButton"
                                        >
                                            <i class="fa-solid fa-play"></i>
                                            Play
                                        </button>


                                        <button
                                            type="button"
                                            class="ep-tool-button"
                                            id="videoPauseButton"
                                        >
                                            <i class="fa-solid fa-pause"></i>
                                            Pause
                                        </button>


                                        <button
                                            type="button"
                                            class="ep-tool-button"
                                            id="videoMuteButton"
                                        >
                                            <i class="fa-solid fa-volume-xmark"></i>
                                            Mute
                                        </button>


                                        <button
                                            type="button"
                                            class="ep-tool-button"
                                            id="videoFullscreenButton"
                                        >
                                            <i class="fa-solid fa-expand"></i>
                                            Fullscreen
                                        </button>


                                        <button
                                            type="button"
                                            class="ep-tool-button"
                                            id="videoResetButton"
                                        >
                                            <i class="fa-solid fa-rotate-left"></i>
                                            Reset View
                                        </button>


                                        <button
                                            type="button"
                                            class="ep-tool-button"
                                            id="videoRemoveButton"
                                        >
                                            <i class="fa-solid fa-trash-can"></i>
                                            Remove
                                        </button>

                                    </div>

                                </div>


                                <div class="ep-tool-card">

                                    <div class="ep-tool-card-title">

                                        <i class="fa-solid fa-gauge-high"></i>

                                        Playback Speed

                                    </div>


                                    <select
                                        id="videoSpeed"
                                        class="ep-tool-select"
                                    >

                                        <option value="0.5">
                                            0.5× — Slow
                                        </option>

                                        <option value="0.75">
                                            0.75×
                                        </option>

                                        <option value="1" selected>
                                            1× — Normal
                                        </option>

                                        <option value="1.25">
                                            1.25×
                                        </option>

                                        <option value="1.5">
                                            1.5×
                                        </option>

                                        <option value="2">
                                            2× — Fast
                                        </option>

                                    </select>

                                </div>


                                <div class="ep-tool-card">

                                    <div class="ep-tool-card-title">

                                        <i class="fa-solid fa-volume-high"></i>

                                        Volume

                                    </div>


                                    <div class="ep-range-label">

                                        <span>
                                            Video Volume
                                        </span>

                                        <span
                                            class="ep-range-value"
                                            id="videoVolumeValue"
                                        >
                                            100%
                                        </span>

                                    </div>


                                    <input
                                        id="videoVolume"
                                        type="range"
                                        class="ep-range"
                                        min="0"
                                        max="1"
                                        step="0.01"
                                        value="1"
                                    >

                                </div>


                                <div class="ep-tool-card">

                                    <div class="ep-tool-card-title">

                                        <i class="fa-solid fa-gear"></i>

                                        Video Settings

                                    </div>


                                    <div class="ep-toggle-row">

                                        <div class="ep-toggle-info">

                                            <div class="ep-toggle-title">
                                                Autoplay
                                            </div>

                                            <div class="ep-toggle-desc">
                                                Play video automatically where supported.
                                            </div>

                                        </div>


                                        <label class="ep-switch">

                                            <input
                                                type="checkbox"
                                                id="videoAutoplay"
                                                name="video_autoplay"
                                                value="1"
                                                {{ old('video_autoplay', $product->video_autoplay ?? false) ? 'checked' : '' }}
                                            >

                                            <span class="ep-slider"></span>

                                        </label>

                                    </div>


                                    <div class="ep-toggle-row">

                                        <div class="ep-toggle-info">

                                            <div class="ep-toggle-title">
                                                Loop Video
                                            </div>

                                            <div class="ep-toggle-desc">
                                                Repeat the video continuously.
                                            </div>

                                        </div>


                                        <label class="ep-switch">

                                            <input
                                                type="checkbox"
                                                id="videoLoop"
                                                name="video_loop"
                                                value="1"
                                                {{ old('video_loop', $product->video_loop ?? false) ? 'checked' : '' }}
                                            >

                                            <span class="ep-slider"></span>

                                        </label>

                                    </div>


                                    <div class="ep-toggle-row">

                                        <div class="ep-toggle-info">

                                            <div class="ep-toggle-title">
                                                Muted
                                            </div>

                                            <div class="ep-toggle-desc">
                                                Start the video without sound.
                                            </div>

                                        </div>


                                        <label class="ep-switch">

                                            <input
                                                type="checkbox"
                                                id="videoMuted"
                                                name="video_muted"
                                                value="1"
                                                {{ old('video_muted', $product->video_muted ?? false) ? 'checked' : '' }}
                                            >

                                            <span class="ep-slider"></span>

                                        </label>

                                    </div>

                                </div>


                                <div class="ep-tool-card">

                                    <div class="ep-tool-card-title">

                                        <i class="fa-solid fa-image"></i>

                                        Video Thumbnail / Poster

                                    </div>


                                    <label
                                        for="videoPoster"
                                        class="ep-label"
                                    >

                                        Poster Image

                                        <span class="ep-optional">
                                            · Optional
                                        </span>

                                    </label>


                                    <input
                                        id="videoPoster"
                                        type="file"
                                        name="video_poster"
                                        class="ep-control"
                                        accept="image/jpeg,image/png,image/webp"
                                    >


                                    <div class="ep-note">

                                        Use a clean frame or thumbnail to make
                                        the video look better before playback.

                                    </div>

                                </div>

                            </div>

                        </div>


                        <input
                            type="hidden"
                            name="video_playback_speed"
                            id="videoPlaybackSpeedInput"
                            value="{{ old('video_playback_speed', $product->video_playback_speed ?? 1) }}"
                        >


                        <input
                            type="hidden"
                            name="video_volume"
                            id="videoVolumeInput"
                            value="{{ old('video_volume', $product->video_volume ?? 1) }}"
                        >


                        <input
                            type="hidden"
                            name="remove_video"
                            id="removeVideoInput"
                            value="0"
                        >


                        <input
                            type="hidden"
                            name="video_rotation"
                            id="videoRotationInput"
                            value="0"
                        >

                    </section>


                    {{-- FINAL ACTION --}}

                    <div class="ep-actions">

                        <button
                            id="updateProductButton"
                            type="submit"
                            class="ep-update-button"
                        >

                            <span
                                class="ep-button-icon"
                                aria-hidden="true"
                            >

                                <i class="fa-solid fa-floppy-disk"></i>

                            </span>


                            <span
                                class="ep-loading-spinner"
                                aria-hidden="true"
                            ></span>


                            <span class="ep-button-text">
                                UPDATE PRODUCT
                            </span>

                        </button>

                    </div>

                </form>

            </section>


            <footer class="ep-footer">

                SMART BASKET

                <span>•</span>

                Seller Product Management

            </footer>

        </div>

    </main>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const form =
                document.getElementById('editProductForm');

            const button =
                document.getElementById('updateProductButton');


            let video =
                document.getElementById('productVideo');


            const uploadInput =
                document.getElementById('productVideoUpload');

            const dropZone =
                document.getElementById('videoDropZone');

            const selectedFile =
                document.getElementById('selectedVideoFile');

            const selectedFileName =
                document.getElementById('selectedVideoFileName');


            const durationElement =
                document.getElementById('videoDuration');

            const resolutionElement =
                document.getElementById('videoResolution');

            const playStatusElement =
                document.getElementById('videoPlayStatus');

            const speedMeta =
                document.getElementById('videoSpeedMeta');


            const playButton =
                document.getElementById('videoPlayButton');

            const pauseButton =
                document.getElementById('videoPauseButton');

            const muteButton =
                document.getElementById('videoMuteButton');

            const fullscreenButton =
                document.getElementById('videoFullscreenButton');

            const resetButton =
                document.getElementById('videoResetButton');

            const removeButton =
                document.getElementById('videoRemoveButton');


            const speedSelect =
                document.getElementById('videoSpeed');

            const volumeRange =
                document.getElementById('videoVolume');

            const volumeValue =
                document.getElementById('videoVolumeValue');

            const autoplayToggle =
                document.getElementById('videoAutoplay');

            const loopToggle =
                document.getElementById('videoLoop');

            const mutedToggle =
                document.getElementById('videoMuted');


            const playbackSpeedInput =
                document.getElementById('videoPlaybackSpeedInput');

            const volumeInput =
                document.getElementById('videoVolumeInput');

            const removeVideoInput =
                document.getElementById('removeVideoInput');

            const rotationInput =
                document.getElementById('videoRotationInput');


            function formatDuration(seconds) {

                if (!Number.isFinite(seconds)) {
                    return '—';
                }

                const total =
                    Math.floor(seconds);

                const minutes =
                    Math.floor(total / 60);

                const remainingSeconds =
                    total % 60;

                return (
                    String(minutes).padStart(2, '0') +
                    ':' +
                    String(remainingSeconds).padStart(2, '0')
                );

            }


            function updateVideoMeta() {

                if (!video) {
                    return;
                }

                if (video.readyState >= 1) {

                    durationElement.textContent =
                        formatDuration(video.duration);

                    if (
                        video.videoWidth &&
                        video.videoHeight
                    ) {

                        resolutionElement.textContent =
                            video.videoWidth +
                            ' × ' +
                            video.videoHeight;

                    }

                }

            }


            function updateMuteButton() {

                if (!muteButton || !video) {
                    return;
                }

                if (video.muted) {

                    muteButton.innerHTML =
                        '<i class="fa-solid fa-volume-high"></i> Unmute';

                } else {

                    muteButton.innerHTML =
                        '<i class="fa-solid fa-volume-xmark"></i> Mute';

                }

            }


            function attachVideoEvents() {

                if (!video) {
                    return;
                }


                video.addEventListener(
                    'loadedmetadata',
                    updateVideoMeta
                );


                video.addEventListener(
                    'play',
                    function () {

                        playStatusElement.textContent =
                            'Playing';

                    }
                );


                video.addEventListener(
                    'pause',
                    function () {

                        playStatusElement.textContent =
                            'Paused';

                    }
                );


                video.addEventListener(
                    'ended',
                    function () {

                        playStatusElement.textContent =
                            'Ended';

                    }
                );


                updateVideoMeta();

                updateMuteButton();

            }


            attachVideoEvents();


            if (playButton) {

                playButton.addEventListener(
                    'click',
                    function () {

                        if (!video) {
                            return;
                        }

                        video.play().catch(function () {});

                    }
                );

            }


            if (pauseButton) {

                pauseButton.addEventListener(
                    'click',
                    function () {

                        if (!video) {
                            return;
                        }

                        video.pause();

                    }
                );

            }


            if (muteButton) {

                muteButton.addEventListener(
                    'click',
                    function () {

                        if (!video) {
                            return;
                        }

                        video.muted =
                            !video.muted;

                        mutedToggle.checked =
                            video.muted;

                        updateMuteButton();

                    }
                );

            }


            if (fullscreenButton) {

                fullscreenButton.addEventListener(
                    'click',
                    async function () {

                        if (!video) {
                            return;
                        }

                        try {

                            if (video.requestFullscreen) {

                                await video.requestFullscreen();

                            } else if (
                                video.webkitEnterFullscreen
                            ) {

                                video.webkitEnterFullscreen();

                            }

                        } catch (error) {

                            console.warn(
                                'Fullscreen unavailable.',
                                error
                            );

                        }

                    }
                );

            }


            if (resetButton) {

                resetButton.addEventListener(
                    'click',
                    function () {

                        if (!video) {
                            return;
                        }

                        video.style.transform =
                            'rotate(0deg)';

                        video.style.filter =
                            'none';

                        video.currentTime =
                            0;

                        video.playbackRate =
                            1;

                        video.volume =
                            1;

                        video.muted =
                            false;

                        rotationInput.value =
                            0;

                        speedSelect.value =
                            '1';

                        volumeRange.value =
                            '1';

                        volumeValue.textContent =
                            '100%';

                        playbackSpeedInput.value =
                            '1';

                        volumeInput.value =
                            '1';

                        mutedToggle.checked =
                            false;

                        speedMeta.textContent =
                            '1×';

                        updateMuteButton();

                    }
                );

            }


            if (removeButton) {

                removeButton.addEventListener(
                    'click',
                    function () {

                        const confirmed =
                            window.confirm(
                                'Are you sure you want to remove the current product video?'
                            );

                        if (!confirmed) {
                            return;
                        }


                        removeVideoInput.value =
                            '1';


                        const previewBox =
                            document.getElementById(
                                'videoPreviewBox'
                            );


                        if (video) {

                            video.pause();

                            video.removeAttribute('src');

                            video.load();

                        }


                        if (previewBox) {

                            previewBox.innerHTML = `
                                <div
                                    class="ep-video-placeholder"
                                    id="videoPlaceholder"
                                >
                                    <div class="ep-video-placeholder-icon">
                                        <i class="fa-solid fa-film"></i>
                                    </div>

                                    <strong>
                                        Video marked for removal
                                    </strong>

                                    <span>
                                        Upload a new video if you want to replace it.
                                    </span>
                                </div>
                            `;

                        }


                        video = null;


                        const statusBadge =
                            document.getElementById(
                                'videoStatusBadge'
                            );


                        if (statusBadge) {

                            statusBadge.innerHTML = `
                                <span
                                    class="ep-video-status-dot"
                                    style="background:#d97706;"
                                ></span>
                                VIDEO WILL BE REMOVED
                            `;

                            statusBadge.style.color =
                                '#92400e';

                            statusBadge.style.background =
                                '#fffbeb';

                            statusBadge.style.borderColor =
                                '#fde68a';

                        }

                    }
                );

            }


            if (speedSelect) {

                speedSelect.addEventListener(
                    'change',
                    function () {

                        const speed =
                            parseFloat(this.value) || 1;

                        playbackSpeedInput.value =
                            speed;

                        speedMeta.textContent =
                            speed + '×';

                        if (video) {

                            video.playbackRate =
                                speed;

                        }

                    }
                );

            }


            if (volumeRange) {

                volumeRange.addEventListener(
                    'input',
                    function () {

                        const volume =
                            parseFloat(this.value);

                        const percentage =
                            Math.round(volume * 100);

                        volumeValue.textContent =
                            percentage + '%';

                        volumeInput.value =
                            volume;

                        if (video) {

                            video.volume =
                                volume;

                            if (volume > 0) {

                                video.muted =
                                    false;

                                mutedToggle.checked =
                                    false;

                                updateMuteButton();

                            }

                        }

                    }
                );

            }


            if (autoplayToggle) {

                autoplayToggle.addEventListener(
                    'change',
                    function () {

                        if (video) {

                            video.autoplay =
                                this.checked;

                        }

                    }
                );

            }


            if (loopToggle) {

                loopToggle.addEventListener(
                    'change',
                    function () {

                        if (video) {

                            video.loop =
                                this.checked;

                        }

                    }
                );

            }


            if (mutedToggle) {

                mutedToggle.addEventListener(
                    'change',
                    function () {

                        if (!video) {
                            return;
                        }

                        video.muted =
                            this.checked;

                        updateMuteButton();

                    }
                );

            }


            function createVideoPreview(file) {

                if (!file) {
                    return;
                }


                if (!file.type.startsWith('video/')) {

                    window.alert(
                        'Please select a valid video file.'
                    );

                    return;

                }


                removeVideoInput.value =
                    '0';


                const objectUrl =
                    URL.createObjectURL(file);


                const previewBox =
                    document.getElementById(
                        'videoPreviewBox'
                    );


                if (!previewBox) {
                    return;
                }


                previewBox.innerHTML = `
                    <video
                        id="productVideo"
                        class="ep-video-element"
                        preload="metadata"
                        playsinline
                        controls
                    >
                        <source
                            src="${objectUrl}"
                            type="${file.type}"
                        >
                        Your browser does not support video playback.
                    </video>
                `;


                video =
                    document.getElementById(
                        'productVideo'
                    );


                attachVideoEvents();


                video.playbackRate =
                    parseFloat(speedSelect.value) || 1;

                video.volume =
                    parseFloat(volumeRange.value) || 1;

                video.loop =
                    loopToggle.checked;

                video.autoplay =
                    autoplayToggle.checked;

                video.muted =
                    mutedToggle.checked;


                const statusBadge =
                    document.getElementById(
                        'videoStatusBadge'
                    );


                if (statusBadge) {

                    statusBadge.innerHTML = `
                        <span class="ep-video-status-dot"></span>
                        NEW VIDEO READY
                    `;

                    statusBadge.style.color =
                        '#166534';

                    statusBadge.style.background =
                        '#f0fdf4';

                    statusBadge.style.borderColor =
                        '#bbf7d0';

                }

            }


            if (uploadInput) {

                uploadInput.addEventListener(
                    'change',
                    function () {

                        const file =
                            this.files &&
                            this.files[0];

                        if (!file) {
                            return;
                        }

                        selectedFile.classList.add(
                            'show'
                        );

                        selectedFileName.textContent =
                            file.name;

                        createVideoPreview(
                            file
                        );

                    }
                );

            }


            if (dropZone) {

                [
                    'dragenter',
                    'dragover'
                ].forEach(function (eventName) {

                    dropZone.addEventListener(
                        eventName,
                        function (event) {

                            event.preventDefault();

                            dropZone.classList.add(
                                'dragover'
                            );

                        }
                    );

                });


                [
                    'dragleave',
                    'drop'
                ].forEach(function (eventName) {

                    dropZone.addEventListener(
                        eventName,
                        function (event) {

                            event.preventDefault();

                            dropZone.classList.remove(
                                'dragover'
                            );

                        }
                    );

                });


                dropZone.addEventListener(
                    'drop',
                    function (event) {

                        const files =
                            event.dataTransfer.files;

                        if (
                            !files ||
                            !files.length
                        ) {
                            return;
                        }


                        const file =
                            files[0];


                        if (!file.type.startsWith('video/')) {

                            window.alert(
                                'Please drop a valid video file.'
                            );

                            return;

                        }


                        try {

                            const dataTransfer =
                                new DataTransfer();

                            dataTransfer.items.add(
                                file
                            );

                            uploadInput.files =
                                dataTransfer.files;

                        } catch (error) {

                            console.warn(
                                'Could not assign dropped file.',
                                error
                            );

                        }


                        selectedFile.classList.add(
                            'show'
                        );

                        selectedFileName.textContent =
                            file.name;

                        createVideoPreview(
                            file
                        );

                    }
                );

            }


            if (form && button) {

                form.addEventListener(
                    'submit',
                    function (event) {

                        if (
                            form.dataset.submitting ===
                            'true'
                        ) {

                            event.preventDefault();

                            return;

                        }


                        if (video) {

                            playbackSpeedInput.value =
                                video.playbackRate || 1;

                            volumeInput.value =
                                video.volume ?? 1;

                        }


                        form.dataset.submitting =
                            'true';


                        button.classList.add(
                            'loading'
                        );


                        const buttonText =
                            button.querySelector(
                                '.ep-button-text'
                            );


                        if (buttonText) {

                            buttonText.textContent =
                                'UPDATING PRODUCT...';

                        }

                    }
                );

            }

        });

    </script>


</body>

</html>