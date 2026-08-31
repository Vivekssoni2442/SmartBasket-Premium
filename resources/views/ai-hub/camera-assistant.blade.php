<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- =========================================================
         SMART BASKET — GLOBAL AI HUB HEAD
    ========================================================== --}}

    @include('ai-hub.partials.head', [
        'title' => 'AI Camera Assistant'
    ])


    {{-- =========================================================
         AI CAMERA ASSISTANT CSS
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="{{ asset('css/ai-camera-assistant.css') }}"
    >

    {{-- AI HUB CSS is already loaded globally by navigation/head.
         Do not create another sidebar stylesheet instance. --}}

</head>


<body>


<div class="ai-hub-layout">


    {{-- =========================================================
         GLOBAL AI HUB
         
         SINGLE INSTANCE ONLY.
         
         Same FAB + same drawer + same tools on every AI page.
    ========================================================== --}}

    @include('ai-hub.partials.navigation')


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <main class="ai-hub-main">


        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <header class="ai-hub-heading ai-ca-heading">

            <div>

                <span class="ai-hub-eyebrow">
                    VIRTUAL STYLE & PRODUCT RECOMMENDATION
                </span>

                <h1>
                    AI Camera Assistant 📷
                </h1>

                <p>
                    Show your face & full body to the camera —
                    AI will suggest the best Smart Basket
                    outfits for you.
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
             SUCCESS MESSAGE
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


        {{-- =====================================================
             ERROR MESSAGE
        ====================================================== --}}

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


        {{-- =====================================================
             VALIDATION ERRORS
        ====================================================== --}}

        @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Something went wrong:
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
             PRIVACY NOTICE
        ====================================================== --}}

        <div class="ai-ca-privacy">

            <i class="fa-solid fa-shield-halved"></i>

            <div>

                <strong>
                    Your privacy matters.
                </strong>

                <span>
                    Your image is processed in memory only and
                    <em>never saved</em> to our servers or database.
                    It is deleted immediately after analysis.
                </span>

            </div>

        </div>


        {{-- =====================================================
             CAMERA + AI RESULT
        ====================================================== --}}

        <div class="row g-4">


            {{-- =================================================
                 CAMERA CARD
            ================================================== --}}

            <div class="col-lg-5">

                <section class="ai-ca-card ai-ca-camera-card">


                    {{-- CARD HEADER --}}

                    <div class="ai-ca-card-head">

                        <span class="ai-ca-card-icon">

                            <i class="fa-solid fa-camera"></i>

                        </span>

                        <div>

                            <h2>
                                Live Camera
                            </h2>

                            <small>
                                Front camera / webcam · full body view
                            </small>

                        </div>

                    </div>


                    {{-- CAMERA ALERT AREA --}}

                    <div
                        class="ai-ca-alerts"
                        id="caAlerts"
                        aria-live="polite"
                    ></div>


                    {{-- CAMERA VIEWPORT --}}

                    <div
                        class="ai-ca-viewport"
                        id="caViewport"
                    >

                        <video
                            id="caVideo"
                            autoplay
                            playsinline
                            muted
                        ></video>


                        <div
                            class="ai-ca-placeholder"
                            id="caPlaceholder"
                        >

                            <i class="fa-solid fa-user-large"></i>

                            <p>
                                Press "Start Camera" to show
                                your face & full body.
                            </p>

                        </div>


                        <canvas
                            id="caCanvas"
                            class="d-none"
                        ></canvas>


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

                            <p>
                                Starting camera...
                            </p>

                        </div>

                    </div>


                    {{-- HIDDEN FILE INPUT --}}

                    <input
                        type="file"
                        id="caFile"
                        accept="image/jpeg,image/png,image/webp"
                        class="d-none"
                    >


                    {{-- UPLOAD PREVIEW --}}

                    <img
                        id="caUploadPreview"
                        class="ai-ca-upload-preview"
                        alt="Uploaded preview"
                    >


                    {{-- CAMERA CONTROLS --}}

                    <div class="ai-ca-capture-tools">


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


                    {{-- CAMERA STATUS --}}

                    <div
                        class="ai-ca-cam-status"
                        id="caStatus"
                        aria-live="polite"
                    >

                        Camera is off.

                    </div>

                </section>

            </div>


            {{-- =================================================
                 AI RESULT CARD
            ================================================== --}}

            <div class="col-lg-7">

                <section class="ai-ca-card ai-ca-result-card">


                    {{-- CARD HEADER --}}

                    <div class="ai-ca-card-head">

                        <span
                            class="ai-ca-card-icon ai-ca-icon-ai"
                        >

                            <i class="fa-solid fa-wand-magic-sparkles"></i>

                        </span>

                        <div>

                            <h2>
                                AI Style Analysis
                            </h2>

                            <small>
                                Face features · body · color · style · outfits
                            </small>

                        </div>

                    </div>


                    {{-- =================================================
                         AI QUERY FORM
                    ================================================== --}}

                    <form
                        id="caAnalyzeForm"
                        class="ai-ca-query-form"
                    >

                        <input
                            type="text"
                            id="caQuery"
                            name="query"
                            class="form-control"
                            placeholder="Ask AI, e.g. 'Iske liye best outfit suggest karo'"
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
                         ACTION BUTTONS
                    ================================================== --}}

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
                         INLINE HISTORY PANEL
                    ================================================== --}}

                    <div
                        class="ai-ca-history d-none"
                        id="caHistoryPanel"
                    >

                        <div class="ai-ca-history-head">

                            <h4>

                                <i class="fa-solid fa-clock-rotate-left me-1"></i>

                                Your Analysis History

                            </h4>


                            <button
                                type="button"
                                class="btn-close btn-close-white"
                                id="caHistoryClose"
                                aria-label="Close history"
                            ></button>

                        </div>


                        <div id="caHistoryList">

                            <span class="ai-ca-empty">
                                Loading history...
                            </span>

                        </div>

                    </div>


                    {{-- =================================================
                         AI LOADING
                    ================================================== --}}

                    <div
                        class="ai-ca-loading d-none"
                        id="caLoading"
                    >

                        <div class="ai-ca-loader">

                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>

                        </div>

                        <p>
                            AI is analyzing your style...
                        </p>

                        <small>
                            Detecting face features,
                            body appearance & color matching
                        </small>

                    </div>


                    {{-- =================================================
                         ANALYSIS RESULTS
                    ================================================== --}}

                    <div
                        id="caResults"
                        class="ai-ca-results"
                    >


                        @if($analysis)

                            {{-- =========================================
                                 DETECTION
                            ========================================== --}}

                            <div class="ai-ca-detection-grid">


                                <div class="ai-ca-detection-item">

                                    <i class="fa-solid fa-hand"></i>

                                    <strong>
                                        Skin Tone
                                    </strong>

                                    <span class="ai-ca-detect-label">

                                        {{ ucfirst(
                                            $analysis['detection']['skin_tone']['label']
                                            ?? '—'
                                        ) }}

                                    </span>

                                    <small class="ai-ca-confidence">

                                        Confidence:
                                        {{ $analysis['detection']['skin_tone']['confidence'] ?? '—' }}%

                                    </small>

                                </div>


                                <div class="ai-ca-detection-item">

                                    <i class="fa-solid fa-face-smile"></i>

                                    <strong>
                                        Face Shape
                                    </strong>

                                    <span class="ai-ca-detect-label">

                                        {{ ucfirst(
                                            $analysis['detection']['face_shape']['label']
                                            ?? '—'
                                        ) }}

                                    </span>

                                    <small class="ai-ca-confidence">

                                        Confidence:
                                        {{ $analysis['detection']['face_shape']['confidence'] ?? '—' }}%

                                    </small>

                                </div>


                                <div class="ai-ca-detection-item">

                                    <i class="fa-solid fa-venus-mars"></i>

                                    <strong>
                                        Gender
                                    </strong>

                                    <span class="ai-ca-detect-label">

                                        {{ $analysis['detection']['gender']['label'] ?? '—' }}

                                    </span>

                                    <small class="ai-ca-confidence">

                                        Confidence:
                                        {{ $analysis['detection']['gender']['confidence'] ?? '—' }}%

                                    </small>

                                </div>


                                <div class="ai-ca-detection-item">

                                    <i class="fa-solid fa-cake-candles"></i>

                                    <strong>
                                        Age Group
                                    </strong>

                                    <span class="ai-ca-detect-label">

                                        {{ $analysis['detection']['age_group']['label'] ?? '—' }}

                                    </span>

                                    <small class="ai-ca-confidence">

                                        Confidence:
                                        {{ $analysis['detection']['age_group']['confidence'] ?? '—' }}%

                                    </small>

                                </div>

                            </div>


                            {{-- =========================================
                                 ANALYSIS GRID
                            ========================================== --}}

                            <div class="ai-ca-analysis-grid">


                                <div class="ai-ca-analysis-item">

                                    <i class="fa-solid fa-face-smile"></i>

                                    <strong>
                                        Face Features
                                    </strong>

                                    <span>

                                        {{ $analysis['face_features']['skin_tone'] ?? '—' }}

                                        ·

                                        {{ $analysis['face_features']['tone'] ?? '—' }}

                                        tone

                                    </span>

                                </div>


                                <div class="ai-ca-analysis-item">

                                    <i class="fa-solid fa-person"></i>

                                    <strong>
                                        Body Appearance
                                    </strong>

                                    <span>

                                        {{ ucfirst(
                                            $analysis['body_appearance']['frame']
                                            ?? 'balanced'
                                        ) }}

                                        frame

                                    </span>

                                </div>


                                <div class="ai-ca-analysis-item">

                                    <i class="fa-solid fa-shirt"></i>

                                    <strong>
                                        Style Preference
                                    </strong>

                                    <span>

                                        {{ ucfirst(
                                            $analysis['style_preference']['suggested_style']
                                            ?? 'casual'
                                        ) }}

                                        ·

                                        {{ $analysis['style_preference']['fit'] ?? 'regular' }}

                                        fit

                                    </span>

                                </div>


                                <div class="ai-ca-analysis-item">

                                    <i class="fa-solid fa-palette"></i>

                                    <strong>
                                        Color Matching
                                    </strong>

                                    <span>

                                        {{ ucfirst(
                                            $analysis['color_matching']['color_category']
                                            ?? 'neutral'
                                        ) }}

                                        tones

                                    </span>

                                </div>

                            </div>


                            {{-- =========================================
                                 SUITABLE COLORS
                            ========================================== --}}

                            @if(
                                collect(
                                    $analysis['color_matching']['suitable_colors'] ?? []
                                )->isNotEmpty()
                            )

                                <div class="ai-ca-color-section">

                                    <h4>

                                        <i class="fa-solid fa-palette me-1"></i>

                                        Suitable Colors For You

                                    </h4>


                                    <div class="ai-ca-color-chips">

                                        @foreach(
                                            $analysis['color_matching']['suitable_colors']
                                            as $color
                                        )

                                            <span class="ai-ca-color-chip">

                                                {{ $color }}

                                            </span>

                                        @endforeach

                                    </div>

                                </div>

                            @endif


                            {{-- =========================================
                                 FASHION RECOMMENDATIONS
                            ========================================== --}}

                            @if(
                                collect(
                                    $analysis['fashion_recommendations']['outfit_ideas'] ?? []
                                )->isNotEmpty()
                            )

                                <div class="ai-ca-fashion-section">

                                    <h4>

                                        <i class="fa-solid fa-shirt me-1"></i>

                                        Fashion Recommendations

                                    </h4>


                                    <ul class="ai-ca-fashion-list">

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


                            {{-- =========================================
                                 SUMMARY
                            ========================================== --}}

                            @if(!empty($analysis['summary']))

                                <p class="ai-ca-summary">

                                    {{ $analysis['summary'] }}

                                </p>

                            @endif


                        @else


                            {{-- =========================================
                                 EMPTY AI RESULT
                            ========================================== --}}

                            <div class="ai-ca-empty">

                                <i class="fa-solid fa-sparkles"></i>

                                <p>

                                    Capture or upload a photo to see
                                    your AI style analysis and product
                                    recommendations.

                                </p>

                            </div>

                        @endif


                        {{-- =================================================
                             PRODUCT RECOMMENDATIONS
                        ================================================== --}}

                        @if($recommendations->isNotEmpty())

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


                                        {{-- PRODUCT IMAGE --}}

                                        <img
                                            src="{{ asset(
                                                'products/' . $product->image
                                            ) }}"
                                            alt="{{ $product->name }}"
                                            loading="lazy"
                                        >


                                        {{-- PRODUCT INFO --}}

                                        <div class="ai-ca-product-body">

                                            <h4>
                                                {{ $product->name }}
                                            </h4>

                                            <p>

                                                {{ $product->category ?: 'Smart Basket product' }}

                                                ·

                                                <span class="text-warning">
                                                    ★
                                                </span>

                                                {{ number_format(
                                                    (float) ($product->rating ?? 0),
                                                    1
                                                ) }}

                                            </p>


                                            @if(!empty($item['reasons']))

                                                <small class="ai-ca-reason">

                                                    {{ collect(
                                                        $item['reasons']
                                                    )->implode(' · ') }}

                                                </small>

                                            @endif

                                        </div>


                                        {{-- PRODUCT ACTIONS --}}

                                        <div class="ai-ca-product-actions">


                                            <span class="ai-ca-price">

                                                ₹{{ number_format(
                                                    (float) $product->price,
                                                    2
                                                ) }}

                                            </span>


                                            <div
                                                class="ai-ca-product-btn-group"
                                            >


                                                {{-- ADD TO CART --}}

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

                                                            <i class="fa-solid fa-cart-plus me-1"></i>

                                                            Add to Cart

                                                        </button>

                                                    </form>

                                                @endif


                                                {{-- VIEW PRODUCT --}}

                                                @if(Route::has('products.show'))

                                                    <a
                                                        href="{{ route(
                                                            'products.show',
                                                            $product->id
                                                        ) }}"
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


{{-- =========================================================
     AI CAMERA JAVASCRIPT
     
     IMPORTANT:
     navigation.blade.php already loads the GLOBAL
     ai-hub-sidebar.js.
     
     This page only loads its CAMERA script.
========================================================= --}}

<script
    src="{{ asset('js/ai-camera-assistant.js') }}"
    defer
></script>


@stack('scripts')


</body>
</html>