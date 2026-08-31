<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('ai-hub.partials.head', [
        'title' => 'Virtual Try-On'
    ])

    <link
        rel="stylesheet"
        href="{{ asset('css/ai-camera-assistant.css') }}"
    >

    <style>
        /* =========================================================
           SMART BASKET — PREMIUM VIRTUAL TRY-ON
           LIGHT + DARK THEME COMPATIBLE
        ========================================================= */

        .sb-vto-page {
            --vto-primary: #6366f1;
            --vto-primary-2: #4f46e5;
            --vto-cyan: #06b6d4;

            --vto-bg: var(--sb-bg, #f5f7fb);
            --vto-card: var(--sb-card, #ffffff);
            --vto-card-2: var(--sb-card-2, #f8fafc);

            --vto-text: var(--sb-text, #111827);
            --vto-muted: var(--sb-muted, #64748b);

            --vto-border:
                var(
                    --sb-border,
                    rgba(148,163,184,.22)
                );

            --vto-shadow:
                0 24px 70px
                rgba(15,23,42,.09);

            min-height: calc(100vh - 40px);

            padding:
                30px 0 70px;

            color: var(--vto-text);

            position: relative;
        }


        /* =========================================================
           BACKGROUND
        ========================================================= */

        .sb-vto-page::before {
            content: "";

            position: fixed;

            inset: 0;

            z-index: -2;

            pointer-events: none;

            background:
                radial-gradient(
                    circle at 5% 5%,
                    rgba(99,102,241,.09),
                    transparent 27%
                ),
                radial-gradient(
                    circle at 95% 20%,
                    rgba(6,182,212,.07),
                    transparent 27%
                ),
                radial-gradient(
                    circle at 50% 100%,
                    rgba(139,92,246,.05),
                    transparent 30%
                );
        }


        /* =========================================================
           HERO
        ========================================================= */

        .sb-vto-hero {
            position: relative;

            overflow: hidden;

            margin-bottom: 24px;

            padding: 30px;

            border:
                1px solid
                var(--vto-border);

            border-radius: 27px;

            background:
                radial-gradient(
                    circle at 90% 10%,
                    rgba(99,102,241,.14),
                    transparent 32%
                ),
                radial-gradient(
                    circle at 5% 100%,
                    rgba(6,182,212,.08),
                    transparent 34%
                ),
                var(--vto-card);

            box-shadow:
                var(--vto-shadow);

            transition:
                .25s ease;
        }


        .sb-vto-hero::after {
            content: "";

            position: absolute;

            width: 260px;
            height: 260px;

            right: -120px;
            top: -150px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(99,102,241,.18),
                    transparent 68%
                );

            pointer-events: none;
        }


        .sb-vto-eyebrow {
            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding:
                7px 12px;

            border-radius: 999px;

            background:
                rgba(99,102,241,.10);

            color:
                var(--vto-primary);

            font-size: .68rem;

            font-weight: 900;

            letter-spacing: .12em;

            text-transform: uppercase;
        }


        .sb-vto-hero h1 {
            position: relative;

            z-index: 1;

            margin:
                13px 0 8px;

            color:
                var(--vto-text);

            font-size:
                clamp(
                    1.9rem,
                    4vw,
                    2.75rem
                );

            font-weight: 950;

            letter-spacing: -.045em;
        }


        .sb-vto-hero p {
            position: relative;

            z-index: 1;

            max-width: 720px;

            margin: 0;

            color:
                var(--vto-muted);

            font-size: .94rem;

            line-height: 1.7;
        }


        .sb-vto-back {
            position: relative;

            z-index: 2;

            border-radius: 12px;

            font-weight: 800;

            padding:
                11px 16px;
        }


        /* =========================================================
           PRIVACY
        ========================================================= */

        .sb-vto-privacy {
            display: flex;

            align-items: flex-start;

            gap: 14px;

            margin-bottom: 24px;

            padding: 17px 19px;

            border:
                1px solid
                rgba(16,185,129,.20);

            border-radius: 17px;

            background:
                rgba(16,185,129,.065);

            color:
                var(--vto-text);
        }


        .sb-vto-privacy-icon {
            display: grid;

            place-items: center;

            flex: 0 0 auto;

            width: 42px;
            height: 42px;

            border-radius: 13px;

            background:
                rgba(16,185,129,.12);

            color:
                #10b981;

            font-size: 1rem;
        }


        .sb-vto-privacy strong {
            display: block;

            margin-bottom: 3px;

            font-size: .84rem;

            font-weight: 900;
        }


        .sb-vto-privacy span {
            display: block;

            color:
                var(--vto-muted);

            font-size: .78rem;

            line-height: 1.6;
        }


        /* =========================================================
           MAIN CARDS
        ========================================================= */

        .sb-vto-card {
            overflow: hidden;

            height: 100%;

            border:
                1px solid
                var(--vto-border);

            border-radius: 23px;

            background:
                var(--vto-card);

            box-shadow:
                var(--vto-shadow);

            transition:
                transform .25s ease,
                border-color .25s ease,
                box-shadow .25s ease;
        }


        .sb-vto-card:hover {
            border-color:
                rgba(99,102,241,.32);

            box-shadow:
                0 28px 75px
                rgba(15,23,42,.12);
        }


        .sb-vto-card-head {
            display: flex;

            align-items: center;

            gap: 13px;

            padding:
                20px 22px;

            border-bottom:
                1px solid
                var(--vto-border);

            background:
                linear-gradient(
                    135deg,
                    rgba(99,102,241,.065),
                    transparent
                );
        }


        .sb-vto-card-icon {
            display: grid;

            place-items: center;

            width: 44px;
            height: 44px;

            flex: 0 0 auto;

            border-radius: 14px;

            background:
                rgba(99,102,241,.10);

            color:
                var(--vto-primary);

            font-size: 1rem;
        }


        .sb-vto-card-icon.ai {
            background:
                linear-gradient(
                    135deg,
                    rgba(99,102,241,.15),
                    rgba(6,182,212,.12)
                );

            color:
                var(--vto-primary);
        }


        .sb-vto-card-head h2 {
            margin: 0;

            color:
                var(--vto-text);

            font-size: 1rem;

            font-weight: 900;
        }


        .sb-vto-card-head small {
            display: block;

            margin-top: 3px;

            color:
                var(--vto-muted);

            font-size: .73rem;
        }


        /* =========================================================
           PHOTO VIEWPORT
        ========================================================= */

        .sb-vto-viewport {
            position: relative;

            display: grid;

            place-items: center;

            min-height: 430px;

            margin: 18px;

            overflow: hidden;

            border:
                1px solid
                var(--vto-border);

            border-radius: 19px;

            background:
                linear-gradient(
                    135deg,
                    var(--vto-card-2),
                    var(--vto-card)
                );
        }


        .sb-vto-viewport::before {
            content: "";

            position: absolute;

            inset: 15px;

            border:
                1px dashed
                rgba(99,102,241,.20);

            border-radius: 15px;

            pointer-events: none;
        }


        .sb-vto-placeholder {
            position: relative;

            z-index: 2;

            padding: 30px;

            text-align: center;

            color:
                var(--vto-muted);
        }


        .sb-vto-placeholder-icon {
            display: grid;

            place-items: center;

            width: 82px;
            height: 82px;

            margin:
                0 auto 17px;

            border-radius: 25px;

            background:
                rgba(99,102,241,.09);

            color:
                var(--vto-primary);

            font-size: 1.9rem;
        }


        .sb-vto-placeholder strong {
            display: block;

            margin-bottom: 6px;

            color:
                var(--vto-text);

            font-size: .95rem;

            font-weight: 900;
        }


        .sb-vto-placeholder span {
            display: block;

            max-width: 300px;

            font-size: .76rem;

            line-height: 1.6;
        }


        .sb-vto-image {
            position: relative;

            z-index: 3;

            display: block;

            max-width: 100%;

            width: auto;

            height: 405px;

            object-fit: contain;

            border-radius: 14px;

            box-shadow:
                0 20px 50px
                rgba(15,23,42,.18);

            animation:
                sbVtoFade .35s ease;
        }


        @keyframes sbVtoFade {

            from {
                opacity: 0;
                transform: scale(.97);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }

        }


        /* =========================================================
           UPLOAD CONTROLS
        ========================================================= */

        .sb-vto-controls {
            display: flex;

            flex-wrap: wrap;

            gap: 10px;

            padding:
                0 20px 16px;
        }


        .sb-vto-controls .btn {
            min-height: 44px;

            border-radius: 11px;

            font-weight: 800;
        }


        .sb-vto-status {
            margin:
                0 20px 20px;

            padding:
                11px 13px;

            border-radius: 11px;

            background:
                var(--vto-card-2);

            color:
                var(--vto-muted);

            font-size: .74rem;

            font-weight: 700;

            border:
                1px solid
                var(--vto-border);
        }


        .sb-vto-status.ready {
            background:
                rgba(16,185,129,.08);

            color:
                #059669;

            border-color:
                rgba(16,185,129,.18);
        }


        /* =========================================================
           OUTFIT GRID
        ========================================================= */

        .sb-vto-products {
            display: grid;

            grid-template-columns:
                repeat(
                    2,
                    minmax(0,1fr)
                );

            gap: 15px;

            padding: 18px;
        }


        .sb-vto-product {
            position: relative;

            min-width: 0;

            overflow: hidden;

            border:
                1px solid
                var(--vto-border);

            border-radius: 17px;

            background:
                var(--vto-card-2);

            cursor: pointer;

            transition:
                transform .23s ease,
                border-color .23s ease,
                box-shadow .23s ease;
        }


        .sb-vto-product:hover {
            transform:
                translateY(-3px);

            border-color:
                rgba(99,102,241,.38);

            box-shadow:
                0 15px 35px
                rgba(15,23,42,.10);
        }


        .sb-vto-product.selected {
            border-color:
                var(--vto-primary);

            box-shadow:
                0 0 0 3px
                rgba(99,102,241,.12),
                0 17px 38px
                rgba(79,70,229,.15);
        }


        .sb-vto-selected {
            position: absolute;

            top: 10px;
            right: 10px;

            z-index: 5;

            display: none;

            align-items: center;

            gap: 5px;

            padding:
                5px 8px;

            border-radius: 999px;

            background:
                var(--vto-primary);

            color: #fff;

            font-size: .64rem;

            font-weight: 900;
        }


        .sb-vto-product.selected
        .sb-vto-selected {
            display: inline-flex;
        }


        .sb-vto-product-image {
            position: relative;

            display: grid;

            place-items: center;

            min-height: 185px;

            padding: 14px;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.70),
                    rgba(248,250,252,.42)
                );

            border-bottom:
                1px solid
                var(--vto-border);
        }


        .sb-vto-product-image img {
            width: 100%;

            height: 160px;

            object-fit: contain;

            transition:
                transform .3s ease;
        }


        .sb-vto-product:hover
        .sb-vto-product-image img {
            transform:
                scale(1.045);
        }


        .sb-vto-image-fallback {
            display: grid;

            place-items: center;

            width: 65px;
            height: 65px;

            border-radius: 19px;

            background:
                rgba(99,102,241,.08);

            color:
                var(--vto-primary);

            font-size: 1.4rem;
        }


        .sb-vto-product-body {
            padding: 14px;
        }


        .sb-vto-product-body h3 {
            overflow: hidden;

            margin: 0 0 5px;

            color:
                var(--vto-text);

            font-size: .86rem;

            font-weight: 850;

            line-height: 1.4;

            display:
                -webkit-box;

            -webkit-line-clamp: 2;

            -webkit-box-orient: vertical;
        }


        .sb-vto-product-meta {
            overflow: hidden;

            margin: 0;

            color:
                var(--vto-muted);

            font-size: .69rem;

            white-space: nowrap;

            text-overflow: ellipsis;
        }


        .sb-vto-product-footer {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 8px;

            padding:
                0 14px 14px;
        }


        .sb-vto-price {
            color:
                var(--vto-primary);

            font-size: .98rem;

            font-weight: 950;

            white-space: nowrap;
        }


        .sb-vto-actions {
            display: flex;

            flex-wrap: wrap;

            justify-content: flex-end;

            gap: 5px;
        }


        .sb-vto-actions .btn {
            border-radius: 9px;

            font-size: .67rem;

            font-weight: 800;
        }


        /* =========================================================
           EMPTY
        ========================================================= */

        .sb-vto-empty {
            padding: 65px 25px;

            text-align: center;

            color:
                var(--vto-muted);
        }


        .sb-vto-empty-icon {
            display: grid;

            place-items: center;

            width: 72px;
            height: 72px;

            margin:
                0 auto 15px;

            border-radius: 22px;

            background:
                rgba(99,102,241,.09);

            color:
                var(--vto-primary);

            font-size: 1.7rem;
        }


        .sb-vto-empty h3 {
            margin-bottom: 6px;

            color:
                var(--vto-text);

            font-size: 1rem;

            font-weight: 900;
        }


        .sb-vto-empty p {
            max-width: 400px;

            margin: 0 auto;

            font-size: .77rem;

            line-height: 1.65;
        }


        /* =========================================================
           AI INFO BAR
        ========================================================= */

        .sb-vto-info {
            display: flex;

            align-items: center;

            gap: 14px;

            margin-top: 20px;

            padding: 18px 20px;

            border:
                1px solid
                var(--vto-border);

            border-radius: 18px;

            background:
                var(--vto-card);

            box-shadow:
                0 14px 40px
                rgba(15,23,42,.06);
        }


        .sb-vto-info-icon {
            display: grid;

            place-items: center;

            flex: 0 0 auto;

            width: 43px;
            height: 43px;

            border-radius: 13px;

            background:
                linear-gradient(
                    135deg,
                    rgba(99,102,241,.13),
                    rgba(6,182,212,.10)
                );

            color:
                var(--vto-primary);
        }


        .sb-vto-info strong {
            display: block;

            margin-bottom: 3px;

            color:
                var(--vto-text);

            font-size: .8rem;

            font-weight: 900;
        }


        .sb-vto-info span {
            color:
                var(--vto-muted);

            font-size: .73rem;

            line-height: 1.55;
        }


        /* =========================================================
           DARK THEME
        ========================================================= */

        [data-theme="dark"] .sb-vto-page,
        [data-sb-theme="dark"] .sb-vto-page {

            --vto-bg: #020617;

            --vto-card: #0f172a;

            --vto-card-2: #111c31;

            --vto-text: #f8fafc;

            --vto-muted: #94a3b8;

            --vto-border:
                rgba(148,163,184,.17);

            --vto-shadow:
                0 25px 70px
                rgba(0,0,0,.30);
        }


        [data-theme="dark"] .sb-vto-page::before,
        [data-sb-theme="dark"] .sb-vto-page::before {

            background:
                radial-gradient(
                    circle at 5% 5%,
                    rgba(99,102,241,.13),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 95% 20%,
                    rgba(6,182,212,.08),
                    transparent 30%
                );
        }


        [data-theme="dark"] .sb-vto-product-image,
        [data-sb-theme="dark"] .sb-vto-product-image {

            background:
                linear-gradient(
                    135deg,
                    rgba(15,23,42,.88),
                    rgba(30,41,59,.55)
                );
        }


        [data-theme="dark"] .sb-vto-viewport,
        [data-sb-theme="dark"] .sb-vto-viewport {

            background:
                linear-gradient(
                    135deg,
                    #0b1220,
                    #111c31
                );
        }


        [data-theme="dark"] .sb-vto-status,
        [data-sb-theme="dark"] .sb-vto-status {

            background:
                #0b1220;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 991.98px) {

            .sb-vto-products {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(0,1fr)
                    );
            }

        }


        @media (max-width: 767.98px) {

            .sb-vto-page {
                padding:
                    20px 0 50px;
            }


            .sb-vto-hero {
                padding:
                    23px 19px;

                border-radius: 21px;
            }


            .sb-vto-hero h1 {
                font-size: 1.8rem;
            }


            .sb-vto-privacy {
                padding: 14px;
            }


            .sb-vto-viewport {
                min-height: 360px;

                margin: 14px;
            }


            .sb-vto-image {
                height: 340px;
            }


            .sb-vto-products {
                padding: 14px;

                gap: 11px;
            }


            .sb-vto-product-image {
                min-height: 155px;
            }


            .sb-vto-product-image img {
                height: 135px;
            }


            .sb-vto-product-footer {
                align-items: flex-start;

                flex-direction: column;
            }


            .sb-vto-actions {
                width: 100%;

                justify-content: stretch;
            }


            .sb-vto-actions .btn {
                flex: 1;
            }

        }


        @media (max-width: 480px) {

            .sb-vto-products {
                grid-template-columns: 1fr;
            }


            .sb-vto-product-image {
                min-height: 190px;
            }


            .sb-vto-product-image img {
                height: 165px;
            }


            .sb-vto-controls {
                flex-direction: column;
            }


            .sb-vto-controls .btn {
                width: 100%;
            }


            .sb-vto-info {
                align-items: flex-start;
            }

        }
    </style>

</head>


<body>

<div class="sb-vto-page">

    <div class="container-fluid px-3 px-lg-4">


        {{-- =====================================================
             HERO
        ====================================================== --}}

        <header class="sb-vto-hero">

            <div
                class="d-flex flex-wrap
                       align-items-center
                       justify-content-between
                       gap-3"
            >

                <div>

                    <span class="sb-vto-eyebrow">

                        <i class="fa-solid fa-wand-magic-sparkles"></i>

                        AI STYLE EXPERIENCE

                    </span>

                    <h1>
                        Virtual Try-On 👗
                    </h1>

                    <p>
                        Upload your photo, choose an outfit and
                        preview your selected style with Smart Basket.
                    </p>

                </div>


                @if(Route::has('ai-camera-assistant'))

                    <a
                        href="{{ route('ai-camera-assistant') }}"
                        class="btn btn-outline-primary sb-vto-back"
                    >

                        <i class="fa-solid fa-arrow-left me-1"></i>

                        Camera Assistant

                    </a>

                @endif

            </div>

        </header>


        {{-- =====================================================
             SUCCESS
        ====================================================== --}}

        @if(session('success'))

            <div class="alert alert-success rounded-4 mb-4">

                <i class="fa-solid fa-circle-check me-1"></i>

                {{ session('success') }}

            </div>

        @endif


        {{-- =====================================================
             PRIVACY
        ====================================================== --}}

        <div class="sb-vto-privacy">

            <div class="sb-vto-privacy-icon">

                <i class="fa-solid fa-shield-halved"></i>

            </div>

            <div>

                <strong>
                    Your photo stays private
                </strong>

                <span>
                    Your selected image is used only for this
                    Virtual Try-On session. This page does not
                    permanently store your uploaded photo.
                </span>

            </div>

        </div>


        {{-- =====================================================
             MAIN
        ====================================================== --}}

        <div class="row g-4">


            {{-- =================================================
                 PHOTO CARD
            ================================================== --}}

            <div class="col-lg-5">

                <section class="sb-vto-card">

                    <div class="sb-vto-card-head">

                        <span class="sb-vto-card-icon">

                            <i class="fa-solid fa-user-large"></i>

                        </span>

                        <div>

                            <h2>
                                Your Photo
                            </h2>

                            <small>
                                Upload a clear photo to begin
                            </small>

                        </div>

                    </div>


                    {{-- VIEWPORT --}}

                    <div
                        class="sb-vto-viewport"
                        id="vtoViewport"
                    >

                        <div
                            id="vtoPlaceholder"
                            class="sb-vto-placeholder"
                        >

                            <div class="sb-vto-placeholder-icon">

                                <i class="fa-solid fa-user-large"></i>

                            </div>

                            <strong>
                                Upload your photo
                            </strong>

                            <span>
                                Use a clear front-facing photo
                                for the best Virtual Try-On experience.
                            </span>

                        </div>


                        <img
                            id="vtoImage"
                            class="sb-vto-image d-none"
                            alt="Uploaded photo for Virtual Try-On"
                        >

                    </div>


                    {{-- CONTROLS --}}

                    <div class="sb-vto-controls">

                        <input
                            type="file"
                            id="vtoFile"
                            accept="image/jpeg,image/png,image/webp"
                            class="d-none"
                        >


                        <button
                            type="button"
                            class="btn btn-primary"
                            id="vtoUploadBtn"
                        >

                            <i class="fa-solid fa-cloud-arrow-up me-1"></i>

                            Upload Photo

                        </button>


                        <button
                            type="button"
                            class="btn btn-outline-secondary d-none"
                            id="vtoClearBtn"
                        >

                            <i class="fa-solid fa-rotate me-1"></i>

                            Change Photo

                        </button>

                    </div>


                    <div
                        id="vtoStatus"
                        class="sb-vto-status"
                    >
                        No photo selected.
                    </div>

                </section>

            </div>


            {{-- =================================================
                 OUTFITS
            ================================================== --}}

            <div class="col-lg-7">

                <section class="sb-vto-card">

                    <div class="sb-vto-card-head">

                        <span class="sb-vto-card-icon ai">

                            <i class="fa-solid fa-shirt"></i>

                        </span>

                        <div>

                            <h2>
                                Outfits To Try On
                            </h2>

                            <small>
                                Select an outfit for your preview
                            </small>

                        </div>

                    </div>


                    <div class="sb-vto-products">

                        @forelse($recommendations as $product)

                            <article
                                class="sb-vto-product"
                                data-vto-product="{{ $product->image }}"
                                data-product-name="{{ $product->name }}"
                                data-product-id="{{ $product->id }}"
                            >

                                <span class="sb-vto-selected">

                                    <i class="fa-solid fa-check"></i>

                                    Selected

                                </span>


                                {{-- PRODUCT IMAGE --}}

                                <div class="sb-vto-product-image">

                                    @if(!empty($product->image))

                                        <img
                                            src="{{ asset('products/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            loading="lazy"
                                            onerror="
                                                this.style.display='none';
                                                this.nextElementSibling.classList.remove('d-none');
                                            "
                                        >

                                        <div
                                            class="sb-vto-image-fallback d-none"
                                        >

                                            <i class="fa-solid fa-shirt"></i>

                                        </div>

                                    @else

                                        <div class="sb-vto-image-fallback">

                                            <i class="fa-solid fa-shirt"></i>

                                        </div>

                                    @endif

                                </div>


                                {{-- PRODUCT BODY --}}

                                <div class="sb-vto-product-body">

                                    <h3>
                                        {{ $product->name }}
                                    </h3>

                                    <p class="sb-vto-product-meta">

                                        {{ $product->category ?: 'Smart Basket Product' }}

                                        ·

                                        <span class="text-warning">
                                            ★
                                        </span>

                                        {{ number_format(
                                            (float) ($product->rating ?? 0),
                                            1
                                        ) }}

                                    </p>

                                </div>


                                {{-- FOOTER --}}

                                <div class="sb-vto-product-footer">

                                    <span class="sb-vto-price">

                                        ₹{{ number_format(
                                            (float) $product->price,
                                            2
                                        ) }}

                                    </span>


                                    <div class="sb-vto-actions">

                                        @if(Route::has('cart.add'))

                                            <form
                                                action="{{ route(
                                                    'cart.add',
                                                    $product->id
                                                ) }}"
                                                method="POST"
                                                class="d-inline"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-primary"
                                                >

                                                    <i
                                                        class="fa-solid
                                                               fa-cart-plus
                                                               me-1"
                                                    ></i>

                                                    Cart

                                                </button>

                                            </form>

                                        @endif


                                        @if(Route::has('products.show'))

                                            <a
                                                href="{{ route(
                                                    'products.show',
                                                    $product->id
                                                ) }}"
                                                class="btn btn-sm btn-primary"
                                            >

                                                <i
                                                    class="fa-solid
                                                           fa-eye
                                                           me-1"
                                                ></i>

                                                View

                                            </a>

                                        @endif

                                    </div>

                                </div>

                            </article>

                        @empty

                            <div
                                class="sb-vto-empty"
                                style="grid-column: 1 / -1;"
                            >

                                <div class="sb-vto-empty-icon">

                                    <i class="fa-solid fa-shirt"></i>

                                </div>

                                <h3>
                                    No outfits available
                                </h3>

                                <p>
                                    Smart Basket does not have
                                    recommended outfits available
                                    for Virtual Try-On right now.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </section>

            </div>

        </div>


        {{-- =====================================================
             INFO
        ====================================================== --}}

        <div class="sb-vto-info">

            <div class="sb-vto-info-icon">

                <i class="fa-solid fa-sparkles"></i>

            </div>

            <div>

                <strong>
                    Smart Basket Style Preview
                </strong>

                <span>
                    Select an outfit above to mark it as your
                    preferred style. Your selection can then be
                    used by the Virtual Try-On experience.
                </span>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     VIRTUAL TRY-ON JAVASCRIPT
========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const vtoImage =
        document.getElementById('vtoImage');

    const vtoFile =
        document.getElementById('vtoFile');

    const vtoUploadBtn =
        document.getElementById('vtoUploadBtn');

    const vtoClearBtn =
        document.getElementById('vtoClearBtn');

    const vtoPlaceholder =
        document.getElementById('vtoPlaceholder');

    const vtoStatus =
        document.getElementById('vtoStatus');


    /* =========================================================
       PHOTO PREVIEW
    ========================================================== */

    function showPhoto(src, message) {

        if (!vtoImage) {
            return;
        }

        vtoImage.src = src;

        vtoImage.classList.remove('d-none');

        if (vtoPlaceholder) {

            vtoPlaceholder.classList.add('d-none');

        }

        if (vtoClearBtn) {

            vtoClearBtn.classList.remove('d-none');

        }

        if (vtoStatus) {

            vtoStatus.textContent =
                message ||
                'Photo ready for Virtual Try-On.';

            vtoStatus.classList.add('ready');

        }

    }


    /* =========================================================
       CLEAR PHOTO
    ========================================================== */

    function clearPhoto() {

        if (vtoImage) {

            vtoImage.removeAttribute('src');

            vtoImage.classList.add('d-none');

        }

        if (vtoPlaceholder) {

            vtoPlaceholder.classList.remove('d-none');

        }

        if (vtoClearBtn) {

            vtoClearBtn.classList.add('d-none');

        }

        if (vtoStatus) {

            vtoStatus.textContent =
                'No photo selected.';

            vtoStatus.classList.remove('ready');

        }

        if (vtoFile) {

            vtoFile.value = '';

        }

        try {

            sessionStorage.removeItem(
                'vto_image_data'
            );

        } catch (error) {

            console.warn(
                'Session storage unavailable.'
            );

        }

    }


    /* =========================================================
       UPLOAD BUTTON
    ========================================================== */

    if (vtoUploadBtn && vtoFile) {

        vtoUploadBtn.addEventListener(
            'click',
            function () {

                vtoFile.click();

            }
        );

    }


    /* =========================================================
       FILE CHANGE
    ========================================================== */

    if (vtoFile) {

        vtoFile.addEventListener(
            'change',
            function () {

                const file =
                    this.files &&
                    this.files[0];


                if (!file) {

                    return;

                }


                const allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];


                if (!allowedTypes.includes(file.type)) {

                    alert(
                        'Please select a JPG, PNG or WEBP image.'
                    );

                    this.value = '';

                    return;

                }


                if (file.size > 5 * 1024 * 1024) {

                    alert(
                        'Image size must be less than 5 MB.'
                    );

                    this.value = '';

                    return;

                }


                /*
                 * Convert image to Data URL.
                 *
                 * This is more reliable than storing
                 * blob: Object URLs in sessionStorage.
                 */

                const reader =
                    new FileReader();


                reader.onload = function (event) {

                    const imageData =
                        event.target.result;


                    showPhoto(
                        imageData,
                        'Photo uploaded successfully.'
                    );


                    try {

                        sessionStorage.setItem(
                            'vto_image_data',
                            imageData
                        );

                    } catch (error) {

                        /*
                         * Large images may exceed storage.
                         * Preview will still work.
                         */

                        console.warn(
                            'Could not save photo to session storage.'
                        );

                    }

                };


                reader.onerror = function () {

                    alert(
                        'Unable to read this image. Please try another photo.'
                    );

                };


                reader.readAsDataURL(file);

            }
        );

    }


    /* =========================================================
       CHANGE PHOTO
    ========================================================== */

    if (vtoClearBtn) {

        vtoClearBtn.addEventListener(
            'click',
            function () {

                clearPhoto();

            }
        );

    }


    /* =========================================================
       RESTORE PHOTO
    ========================================================== */

    try {

        const storedImage =
            sessionStorage.getItem(
                'vto_image_data'
            );


        if (storedImage) {

            showPhoto(
                storedImage,
                'Your previous session photo has been restored.'
            );

        }

    } catch (error) {

        console.warn(
            'Unable to restore previous photo.'
        );

    }


    /* =========================================================
       PRODUCT SELECTION
    ========================================================== */

    document
        .querySelectorAll('[data-vto-product]')
        .forEach(function (card) {

            card.addEventListener(
                'click',
                function (event) {

                    /*
                     * Do not select product when clicking
                     * Add to Cart or View Product.
                     */

                    if (
                        event.target.closest('a') ||
                        event.target.closest('button') ||
                        event.target.closest('form')
                    ) {

                        return;

                    }


                    document
                        .querySelectorAll(
                            '[data-vto-product]'
                        )
                        .forEach(function (item) {

                            item.classList.remove(
                                'selected'
                            );

                        });


                    card.classList.add(
                        'selected'
                    );


                    const productName =
                        card.dataset.productName ||
                        'Selected outfit';


                    if (vtoStatus) {

                        vtoStatus.textContent =
                            productName +
                            ' selected for Virtual Try-On.';

                        vtoStatus.classList.add(
                            'ready'
                        );

                    }

                }
            );

        });

});

</script>

</body>

</html>