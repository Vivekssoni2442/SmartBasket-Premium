{{-- =========================================================
    SMART BASKET PREMIUM
    AI CAMERA ASSISTANT — PREMIUM STYLE STUDIO
    Download / Share / History REMOVED
========================================================= --}}

<link rel="stylesheet" href="{{ asset('css/ai-camera-assistant.css') }}">

<style>
/* =========================================================
   SMART BASKET — AI STYLE STUDIO
========================================================= */

.ai-camera-premium {
    --ai-primary: #635bff;
    --ai-primary-dark: #5148e8;
    --ai-purple: #8b5cf6;
    --ai-success: #10b981;
    --ai-text: #111827;
    --ai-muted: #64748b;
    --ai-border: #e7eaf0;
    --ai-bg: #f6f7fb;
    --ai-card: #ffffff;

    min-height: 100vh;
    padding: 30px;
    color: var(--ai-text);

    background:
        radial-gradient(
            circle at 5% 0%,
            rgba(99,91,255,.12),
            transparent 28%
        ),
        radial-gradient(
            circle at 95% 8%,
            rgba(139,92,246,.10),
            transparent 25%
        ),
        linear-gradient(
            180deg,
            #f8f9fd 0%,
            #f3f5fa 100%
        );
}

.ai-camera-premium *,
.ai-camera-premium *::before,
.ai-camera-premium *::after {
    box-sizing: border-box;
}

/* =========================================================
   HEADER
========================================================= */

.ai-premium-header {
    max-width: 1250px;
    margin: 0 auto 24px;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.ai-premium-heading {
    display: flex;
    align-items: center;
    gap: 15px;
}

.ai-premium-icon {
    width: 58px;
    height: 58px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 18px;

    color: #fff;
    font-size: 23px;

    background:
        linear-gradient(
            135deg,
            var(--ai-primary),
            var(--ai-purple)
        );

    box-shadow:
        0 15px 35px rgba(99,91,255,.25);
}

.ai-premium-header h1 {
    margin: 0;

    font-size: clamp(1.5rem, 3vw, 2.2rem);
    font-weight: 900;

    letter-spacing: -.045em;
}

.ai-premium-header p {
    margin: 5px 0 0;

    color: var(--ai-muted);
    font-size: .82rem;
}

.ai-premium-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    padding: 9px 14px;

    border-radius: 999px;

    color: var(--ai-primary);
    background: rgba(99,91,255,.08);

    border: 1px solid rgba(99,91,255,.14);

    font-size: .68rem;
    font-weight: 900;
    letter-spacing: .06em;
}

/* =========================================================
   MAIN GRID
========================================================= */

.ai-premium-main {
    max-width: 1250px;
    margin: 0 auto;

    display: grid;
    grid-template-columns:
        minmax(0, 1.12fr)
        minmax(360px, .88fr);

    gap: 22px;
}

/* =========================================================
   COMMON CARD
========================================================= */

.ai-camera-card,
.ai-analysis-card,
.ai-recommendations {
    background: rgba(255,255,255,.94);

    border: 1px solid rgba(226,230,238,.9);

    border-radius: 25px;

    box-shadow:
        0 18px 55px rgba(15,23,42,.07);

    backdrop-filter: blur(15px);
}

/* =========================================================
   CAMERA CARD
========================================================= */

.ai-camera-card {
    padding: 18px;
}

.ai-camera-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;

    margin-bottom: 15px;
}

.ai-camera-card-head h2 {
    margin: 0;

    font-size: 1rem;
    font-weight: 850;
}

.ai-camera-card-head h2 i {
    color: var(--ai-primary);
}

.ai-camera-status {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    color: #64748b;

    font-size: .67rem;
    font-weight: 800;
}

.ai-camera-status-dot {
    width: 8px;
    height: 8px;

    border-radius: 50%;

    background: #cbd5e1;
}

.ai-camera-status.active .ai-camera-status-dot {
    background: var(--ai-success);

    box-shadow:
        0 0 0 5px rgba(16,185,129,.10);
}

/* =========================================================
   CAMERA VIEWPORT
========================================================= */

.ai-camera-viewport {
    position: relative;

    width: 100%;
    height: min(64vh, 570px);
    min-height: 400px;

    overflow: hidden;

    border-radius: 21px;

    background:
        radial-gradient(
            circle at 50% 35%,
            #252b43 0%,
            #0d1324 55%,
            #050811 100%
        );

    border: 1px solid rgba(255,255,255,.08);

    box-shadow:
        inset 0 0 50px rgba(0,0,0,.25);
}

.ai-camera-viewport video {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;

    background: #080b14;
}

/* =========================================================
   CAMERA PLACEHOLDER
========================================================= */

.ai-camera-placeholder {
    position: absolute;
    inset: 0;

    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;

    text-align: center;

    padding: 25px;

    color: #cbd5e1;
}

.ai-camera-placeholder i {
    width: 74px;
    height: 74px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 15px;

    border-radius: 23px;

    color: #dbeafe;

    background: rgba(255,255,255,.07);

    border: 1px solid rgba(255,255,255,.12);

    font-size: 28px;

    box-shadow:
        0 15px 40px rgba(0,0,0,.20);
}

.ai-camera-placeholder p {
    margin: 0;

    color: #94a3b8;

    font-size: .78rem;
}

/* =========================================================
   FULL BODY GUIDE
========================================================= */

.ai-camera-guide {
    pointer-events: none;

    position: absolute;
    inset: 0;
}

.ai-camera-guide::before {
    content: "";

    position: absolute;

    left: 50%;
    top: 7%;

    width: 44%;
    height: 84%;

    transform: translateX(-50%);

    border:
        1px dashed
        rgba(255,255,255,.22);

    border-radius:
        45% 45% 25% 25%;
}

.ai-camera-guide::after {
    content: "FULL BODY";

    position: absolute;

    left: 50%;
    bottom: 17px;

    transform: translateX(-50%);

    padding: 6px 11px;

    border-radius: 999px;

    color: rgba(255,255,255,.65);

    background:
        rgba(0,0,0,.28);

    font-size: .58rem;
    font-weight: 900;

    letter-spacing: .12em;
}

/* =========================================================
   CAMERA LOADING
========================================================= */

.ai-camera-cam-loading {
    position: absolute;
    inset: 0;

    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;

    gap: 13px;

    color: #fff;

    background:
        rgba(4,7,18,.78);

    backdrop-filter: blur(10px);
}

.ai-camera-cam-loading p {
    margin: 0;

    color: #cbd5e1;

    font-size: .76rem;
}

/* =========================================================
   PRIVACY
========================================================= */

.ai-camera-privacy {
    display: flex;
    align-items: center;
    gap: 9px;

    margin-top: 13px;
    padding: 11px 13px;

    border-radius: 13px;

    color: #64748b;

    background: #f8fafc;

    border: 1px solid #edf0f4;

    font-size: .68rem;
}

.ai-camera-privacy i {
    color: var(--ai-success);
}

/* =========================================================
   ALERT
========================================================= */

.ai-ca-alerts {
    width: 100%;
}

.ai-alert {
    padding: 10px 12px;

    margin-top: 10px;

    border-radius: 11px;

    font-size: .7rem;
}

/* =========================================================
   CAMERA CONTROLS
========================================================= */

.ai-camera-controls {
    display: flex;
    flex-wrap: wrap;

    gap: 8px;

    margin-top: 13px;
}

.ai-camera-controls button {
    min-height: 41px;

    padding: 0 15px;

    border-radius: 11px;

    border: 0;

    font-size: .7rem;
    font-weight: 850;

    transition:
        .2s ease;
}

.ai-camera-controls button:hover:not(:disabled) {
    transform: translateY(-2px);
}

.ai-btn-primary {
    color: #fff;

    background:
        linear-gradient(
            135deg,
            var(--ai-primary),
            var(--ai-purple)
        );

    box-shadow:
        0 8px 22px rgba(99,91,255,.22);
}

.ai-btn-capture {
    color: #fff;

    background: #111827;
}

.ai-btn-retake {
    color: #fff;

    background: #475569;
}

.ai-btn-upload {
    color: #334155;

    background: #f1f5f9;

    border: 1px solid #e2e8f0 !important;
}

.ai-camera-controls button:disabled {
    opacity: .45;
}

/* =========================================================
   QUERY
========================================================= */

.ai-query-card {
    margin-top: 14px;
}

.ai-query-card label {
    display: block;

    margin-bottom: 7px;

    color: #64748b;

    font-size: .68rem;
    font-weight: 800;
}

.ai-query-row {
    display: flex;
    gap: 8px;
}

.ai-query-row input {
    min-width: 0;
    flex: 1;

    height: 43px;

    padding: 0 13px;

    border:
        1px solid
        #e2e8f0;

    border-radius: 11px;

    outline: none;

    color: #111827;

    background: #fff;

    font-size: .75rem;
}

.ai-query-row input:focus {
    border-color: rgba(99,91,255,.5);

    box-shadow:
        0 0 0 4px
        rgba(99,91,255,.08);
}

.ai-query-row button {
    height: 43px;

    padding: 0 16px;

    border: 0;

    border-radius: 11px;

    color: #fff;

    background:
        linear-gradient(
            135deg,
            var(--ai-primary),
            var(--ai-purple)
        );

    font-size: .7rem;
    font-weight: 850;
}

/* =========================================================
   ANALYSIS CARD
========================================================= */

.ai-analysis-card {
    padding: 20px;
}

.ai-analysis-head {
    margin-bottom: 16px;
}

.ai-analysis-head h2 {
    margin: 0;

    font-size: 1.02rem;
    font-weight: 900;
}

.ai-analysis-head h2 i {
    color: var(--ai-primary);
}

.ai-analysis-head p {
    margin: 5px 0 0;

    color: var(--ai-muted);

    font-size: .68rem;
}

/* =========================================================
   DETECTION GRID
========================================================= */

.ai-detection-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0,1fr));

    gap: 9px;
}

.ai-detection-card {
    min-width: 0;
    min-height: 124px;

    padding: 13px;

    border-radius: 16px;

    border: 1px solid #e9edf3;

    background:
        linear-gradient(
            145deg,
            #fff,
            #f8fafc
        );

    transition: .2s ease;
}

.ai-detection-card:hover {
    transform: translateY(-2px);

    box-shadow:
        0 10px 25px
        rgba(15,23,42,.06);
}

.ai-detection-icon {
    width: 33px;
    height: 33px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 9px;

    border-radius: 10px;

    color: var(--ai-primary);

    background:
        rgba(99,91,255,.08);
}

.ai-detection-card strong {
    display: block;

    margin-bottom: 3px;

    color: #64748b;

    font-size: .64rem;
}

.ai-detection-value {
    display: block;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

    color: #111827;

    font-size: .82rem;
    font-weight: 900;
}

.ai-confidence {
    display: block;

    margin-top: 5px;

    color: #94a3b8;

    font-size: .58rem;
}

/* =========================================================
   MINI ANALYSIS
========================================================= */

.ai-mini-analysis {
    display: grid;

    grid-template-columns:
        repeat(3,minmax(0,1fr));

    gap: 8px;

    margin-top: 11px;
}

.ai-mini-card {
    min-width: 0;

    padding: 11px 8px;

    text-align: center;

    border-radius: 13px;

    background: #f8fafc;

    border: 1px solid #edf0f4;
}

.ai-mini-card i {
    display: block;

    margin-bottom: 6px;

    color: var(--ai-primary);
}

.ai-mini-card strong {
    display: block;

    margin-bottom: 4px;

    color: #64748b;

    font-size: .57rem;

    text-transform: uppercase;

    letter-spacing: .05em;
}

.ai-mini-card span {
    display: block;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

    font-size: .67rem;
    font-weight: 850;
}

/* =========================================================
   COLORS
========================================================= */

.ai-colors {
    margin-top: 14px;

    padding-top: 13px;

    border-top: 1px solid #edf0f4;
}

.ai-colors-title {
    margin-bottom: 8px;

    color: #475569;

    font-size: .68rem;
    font-weight: 850;
}

.ai-color-list {
    display: flex;
    flex-wrap: wrap;

    gap: 6px;
}

.ai-color-chip {
    display: inline-flex;
    align-items: center;

    min-height: 27px;

    padding: 0 9px;

    border-radius: 999px;

    color: #475569;

    background: #f1f5f9;

    border: 1px solid #e2e8f0;

    font-size: .59rem;
    font-weight: 750;
}

/* =========================================================
   SUMMARY
========================================================= */

.ai-summary {
    margin-top: 13px;

    padding: 12px 13px;

    border-left:
        3px solid
        var(--ai-primary);

    border-radius: 10px;

    color: #475569;

    background: #fafaff;

    font-size: .68rem;

    line-height: 1.6;
}

/* =========================================================
   EMPTY
========================================================= */

.ai-empty {
    min-height: 350px;

    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;

    text-align: center;

    padding: 25px;

    border:
        1px dashed
        #dbe2ea;

    border-radius: 18px;

    background: #fafbfc;
}

.ai-empty-icon {
    width: 60px;
    height: 60px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 12px;

    border-radius: 18px;

    color: var(--ai-primary);

    background:
        rgba(99,91,255,.08);

    font-size: 22px;
}

.ai-empty strong {
    font-size: .82rem;
}

.ai-empty span {
    max-width: 270px;

    margin-top: 6px;

    color: #94a3b8;

    font-size: .67rem;

    line-height: 1.55;
}

/* =========================================================
   LOADING
========================================================= */

.ai-analysis-loading {
    min-height: 350px;

    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;

    gap: 13px;
}

.ai-loader {
    width: 46px;
    height: 46px;

    border:
        3px solid
        #e5e7eb;

    border-top-color:
        var(--ai-primary);

    border-radius: 50%;

    animation:
        aiSpin .8s linear infinite;
}

@keyframes aiSpin {
    to {
        transform: rotate(360deg);
    }
}

.ai-analysis-loading p {
    margin: 0;

    color: #64748b;

    font-size: .7rem;
}

/* =========================================================
   RECOMMENDATIONS
========================================================= */

.ai-recommendations {
    max-width: 1250px;

    margin: 22px auto 0;

    padding: 19px;
}

.ai-recommendations-head {
    display: flex;
    align-items: center;
    justify-content: space-between;

    margin-bottom: 14px;
}

.ai-recommendations-head h2 {
    margin: 0;

    font-size: .98rem;
    font-weight: 900;
}

.ai-recommendations-head h2 i {
    color: var(--ai-primary);
}

.ai-recommendations-head span {
    color: #94a3b8;

    font-size: .62rem;
}

/* =========================================================
   PRODUCT GRID
========================================================= */

.ai-products-grid {
    display: grid;

    grid-template-columns:
        repeat(
            auto-fill,
            minmax(190px,1fr)
        );

    gap: 13px;
}

/* =========================================================
   PRODUCT CARD
========================================================= */

.ai-product-card {
    width: 100%;
    height: 315px;

    min-width: 0;

    display: flex;
    flex-direction: column;

    overflow: hidden;

    border:
        1px solid
        #e8edf3;

    border-radius: 17px;

    background: #fff;

    transition:
        transform .22s ease,
        box-shadow .22s ease;
}

.ai-product-card:hover {
    transform: translateY(-4px);

    box-shadow:
        0 15px 35px
        rgba(15,23,42,.10);
}

/* =========================================================
   EXACT SAME IMAGE BOX
========================================================= */

.ai-product-image-box {
    width: 100%;

    height: 175px;
    min-height: 175px;
    max-height: 175px;

    flex: 0 0 175px;

    padding: 9px;

    display: flex;
    align-items: center;
    justify-content: center;

    overflow: hidden;

    background:
        linear-gradient(
            145deg,
            #f8fafc,
            #f1f5f9
        );

    border-bottom:
        1px solid
        #edf0f4;
}

.ai-product-image-box img {
    width: 100%;
    height: 100%;

    min-width: 0;
    min-height: 0;

    max-width: 100%;
    max-height: 100%;

    display: block;

    /*
       IMPORTANT:
       Every image uses exactly the
       same box and same object-fit.
    */

    object-fit: contain !important;

    object-position: center center !important;
}

/* =========================================================
   PRODUCT BODY
========================================================= */

.ai-product-body {
    min-width: 0;

    flex: 1;

    display: flex;
    flex-direction: column;

    padding: 11px;
}

.ai-product-name {
    min-height: 34px;
    max-height: 34px;

    overflow: hidden;

    display: -webkit-box;

    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;

    margin: 0 0 5px;

    color: #172033;

    font-size: .71rem;

    line-height: 1.35;

    font-weight: 850;
}

.ai-product-price {
    margin-bottom: auto;

    color: var(--ai-primary);

    font-size: .84rem;

    font-weight: 900;
}

.ai-product-actions {
    display: flex;

    gap: 6px;

    margin-top: 9px;
}

.ai-product-actions form,
.ai-product-actions a {
    flex: 1;

    min-width: 0;
}

.ai-product-actions button,
.ai-product-actions a {
    width: 100%;
    height: 33px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    font-size: .61rem;
    font-weight: 850;

    text-decoration: none;
}

.ai-cart-btn {
    color: var(--ai-primary);

    background:
        #f3f1ff;

    border:
        1px solid
        #e5e0ff;
}

.ai-view-btn {
    color: #fff;

    background: #111827;

    border:
        1px solid
        #111827;
}

/* =========================================================
   REMOVE OLD DOWNLOAD / SHARE / HISTORY
========================================================= */

.ai-camera-premium .ai-ca-actions,
.ai-camera-premium .ai-ca-history,
.ai-camera-premium #caDownloadBtn,
.ai-camera-premium #caShareBtn,
.ai-camera-premium #caHistoryBtn,
.ai-camera-premium #caVirtualTryOnBtn,
.ai-camera-premium #caResetBtn {
    display: none !important;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 950px) {

    .ai-premium-main {
        grid-template-columns: 1fr;
    }

    .ai-camera-viewport {
        height: 520px;
    }
}

@media (max-width: 600px) {

    .ai-camera-premium {
        padding: 13px;
    }

    .ai-premium-header {
        align-items: flex-start;
    }

    .ai-premium-badge {
        display: none;
    }

    .ai-premium-icon {
        width: 48px;
        height: 48px;
        flex-basis: 48px;

        border-radius: 14px;

        font-size: 19px;
    }

    .ai-premium-header h1 {
        font-size: 1.4rem;
    }

    .ai-premium-header p {
        font-size: .7rem;
    }

    .ai-camera-card,
    .ai-analysis-card,
    .ai-recommendations {
        padding: 13px;

        border-radius: 18px;
    }

    .ai-camera-viewport {
        height: 62vh;
        min-height: 380px;

        border-radius: 16px;
    }

    .ai-camera-controls {
        display: grid;

        grid-template-columns:
            1fr 1fr;
    }

    .ai-camera-controls button {
        width: 100%;
    }

    .ai-query-row {
        flex-direction: column;
    }

    .ai-query-row button {
        width: 100%;
    }

    .ai-products-grid {
        grid-template-columns:
            repeat(2,minmax(0,1fr));

        gap: 9px;
    }

    .ai-product-card {
        height: 295px;

        border-radius: 14px;
    }

    .ai-product-image-box {
        height: 150px;
        min-height: 150px;
        max-height: 150px;

        flex-basis: 150px;
    }

    .ai-product-body {
        padding: 9px;
    }

    .ai-product-name {
        font-size: .65rem;
    }

    .ai-product-price {
        font-size: .76rem;
    }

    .ai-product-actions button,
    .ai-product-actions a {
        font-size: .56rem;
    }
}
</style>


<div class="ai-camera-premium">

    {{-- =====================================================
         PREMIUM HEADER
    ====================================================== --}}

    <div class="ai-premium-header">

        <div class="ai-premium-heading">

            <div class="ai-premium-icon">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>

            <div>

                <h1>
                    AI Style Studio
                </h1>

                <p>
                    Discover your style and get personalized outfit recommendations.
                </p>

            </div>

        </div>

        <div class="ai-premium-badge">

            <i class="fa-solid fa-sparkles"></i>

            AI POWERED

        </div>

    </div>


    {{-- =====================================================
         MAIN
    ====================================================== --}}

    <div class="ai-premium-main">

        {{-- =================================================
             CAMERA
        ================================================== --}}

        <section class="ai-camera-card">

            <div class="ai-camera-card-head">

                <h2>
                    <i class="fa-solid fa-camera me-2"></i>
                    Camera Studio
                </h2>

                <div
                    class="ai-camera-status"
                    id="aiCameraStatus"
                >

                    <span class="ai-camera-status-dot"></span>

                    <span id="aiCameraStatusText">
                        Camera Off
                    </span>

                </div>

            </div>


            {{-- CAMERA --}}

            <div
                class="ai-camera-viewport"
                id="caViewport"
            >

                <video
                    id="caVideo"
                    autoplay
                    playsinline
                    muted
                ></video>


                <div
                    class="ai-camera-placeholder"
                    id="caPlaceholder"
                >

                    <i class="fa-solid fa-user-large"></i>

                    <p>
                        Press "Start Camera" to show your face & full body.
                    </p>

                </div>


                <div class="ai-camera-guide"></div>


                <canvas
                    id="caCanvas"
                    class="d-none"
                ></canvas>


                <div
                    class="ai-camera-cam-loading d-none"
                    id="caCamLoading"
                >

                    <div class="ai-loader"></div>

                    <p>
                        Starting camera...
                    </p>

                </div>

            </div>


            {{-- PRIVACY --}}

            <div class="ai-camera-privacy">

                <i class="fa-solid fa-shield-halved"></i>

                <span>
                    Your image is processed securely in memory and is not saved.
                </span>

            </div>


            {{-- ALERTS --}}

            <div class="ai-ca-alerts"></div>


            {{-- FILE --}}

            <input
                type="file"
                id="caFile"
                accept="image/jpeg,image/png,image/webp"
                class="d-none"
            >


            <img
                id="caUploadPreview"
                class="d-none"
                alt="Uploaded preview"
            >


            {{-- CAMERA CONTROLS --}}

            <div class="ai-camera-controls">

                <button
                    type="button"
                    class="ai-btn-primary"
                    id="caStartBtn"
                >

                    <i class="fa-solid fa-video me-1"></i>

                    Start Camera

                </button>


                <button
                    type="button"
                    class="ai-btn-capture d-none"
                    id="caCaptureBtn"
                >

                    <i class="fa-solid fa-camera me-1"></i>

                    Capture Photo

                </button>


                <button
                    type="button"
                    class="ai-btn-retake d-none"
                    id="caRetakeBtn"
                >

                    <i class="fa-solid fa-rotate-right me-1"></i>

                    Retake

                </button>


                <button
                    type="button"
                    class="ai-btn-upload"
                    id="caUploadBtn"
                >

                    <i class="fa-solid fa-cloud-arrow-up me-1"></i>

                    Upload Photo

                </button>


                {{-- STOP IS KEPT FOR JS COMPATIBILITY --}}
                <button
                    type="button"
                    id="caStopBtn"
                    class="d-none"
                >
                    Stop
                </button>

            </div>


            {{-- QUERY --}}

            <div class="ai-query-card">

                <form
                    id="caAnalyzeForm"
                    class="ai-ca-query-form"
                >

                    <label for="caQuery">

                        What would you like AI to recommend?

                    </label>


                    <div class="ai-query-row">

                        <input
                            type="text"
                            id="caQuery"
                            name="query"
                            placeholder="Example: best casual outfit for me"
                        >


                        <button
                            type="submit"
                            id="caAnalyzeBtn"
                        >

                            <i class="fa-solid fa-wand-magic-sparkles me-1"></i>

                            Analyze Style

                        </button>

                    </div>

                </form>

            </div>

        </section>


        {{-- =================================================
             AI ANALYSIS
        ================================================== --}}

        <section class="ai-analysis-card">

            <div class="ai-analysis-head">

                <h2>

                    <i class="fa-solid fa-sparkles me-2"></i>

                    AI Style Analysis

                </h2>

                <p>
                    Face features · color · style · personalized insights
                </p>

            </div>


            {{-- LOADING --}}

            <div
                id="caLoading"
                class="ai-analysis-loading d-none"
            >

                <div class="ai-loader"></div>

                <p>
                    AI is analyzing your style...
                </p>

            </div>


            {{-- RESULTS --}}

            <div id="caResults">

                @if($analysis)

                    {{-- DETECTION --}}

                    <div class="ai-detection-grid">

                        <div class="ai-detection-card">

                            <div class="ai-detection-icon">
                                <i class="fa-solid fa-hand"></i>
                            </div>

                            <strong>
                                Skin Tone
                            </strong>

                            <span class="ai-detection-value">
                                {{ ucfirst($analysis['detection']['skin_tone']['label'] ?? '—') }}
                            </span>

                            <small class="ai-confidence">
                                Confidence:
                                {{ $analysis['detection']['skin_tone']['confidence'] ?? '—' }}%
                            </small>

                        </div>


                        <div class="ai-detection-card">

                            <div class="ai-detection-icon">
                                <i class="fa-solid fa-face-smile"></i>
                            </div>

                            <strong>
                                Face Shape
                            </strong>

                            <span class="ai-detection-value">
                                {{ ucfirst($analysis['detection']['face_shape']['label'] ?? '—') }}
                            </span>

                            <small class="ai-confidence">
                                Confidence:
                                {{ $analysis['detection']['face_shape']['confidence'] ?? '—' }}%
                            </small>

                        </div>


                        <div class="ai-detection-card">

                            <div class="ai-detection-icon">
                                <i class="fa-solid fa-venus-mars"></i>
                            </div>

                            <strong>
                                Gender
                            </strong>

                            <span class="ai-detection-value">
                                {{ $analysis['detection']['gender']['label'] ?? '—' }}
                            </span>

                            <small class="ai-confidence">
                                Confidence:
                                {{ $analysis['detection']['gender']['confidence'] ?? '—' }}%
                            </small>

                        </div>


                        <div class="ai-detection-card">

                            <div class="ai-detection-icon">
                                <i class="fa-solid fa-cake-candles"></i>
                            </div>

                            <strong>
                                Age Group
                            </strong>

                            <span class="ai-detection-value">
                                {{ $analysis['detection']['age_group']['label'] ?? '—' }}
                            </span>

                            <small class="ai-confidence">
                                Confidence:
                                {{ $analysis['detection']['age_group']['confidence'] ?? '—' }}%
                            </small>

                        </div>

                    </div>


                    {{-- MINI ANALYSIS --}}

                    <div class="ai-mini-analysis">

                        <div class="ai-mini-card">

                            <i class="fa-solid fa-face-smile"></i>

                            <strong>
                                Skin
                            </strong>

                            <span>
                                {{ ucfirst($analysis['face_features']['skin_tone'] ?? 'Neutral') }}
                            </span>

                        </div>


                        <div class="ai-mini-card">

                            <i class="fa-solid fa-shirt"></i>

                            <strong>
                                Style
                            </strong>

                            <span>
                                {{ ucfirst($analysis['style_preference']['suggested_style'] ?? 'Casual') }}
                            </span>

                        </div>


                        <div class="ai-mini-card">

                            <i class="fa-solid fa-palette"></i>

                            <strong>
                                Color
                            </strong>

                            <span>
                                {{ ucfirst($analysis['color_matching']['color_category'] ?? 'Neutral') }}
                            </span>

                        </div>

                    </div>


                    {{-- COLORS --}}

                    @if(
                        collect(
                            $analysis['color_matching']['suitable_colors'] ?? []
                        )->isNotEmpty()
                    )

                        <div class="ai-colors">

                            <div class="ai-colors-title">

                                <i class="fa-solid fa-palette me-1"></i>

                                Recommended Colors

                            </div>


                            <div class="ai-color-list">

                                @foreach(
                                    $analysis['color_matching']['suitable_colors']
                                    as $color
                                )

                                    <span class="ai-color-chip">
                                        {{ $color }}
                                    </span>

                                @endforeach

                            </div>

                        </div>

                    @endif


                    {{-- SUMMARY --}}

                    @if(!empty($analysis['summary']))

                        <div class="ai-summary">

                            <strong>
                                AI Stylist:
                            </strong>

                            {{ $analysis['summary'] }}

                        </div>

                    @endif

                @else

                    <div class="ai-empty">

                        <div class="ai-empty-icon">

                            <i class="fa-solid fa-sparkles"></i>

                        </div>

                        <strong>
                            Your AI style profile is waiting
                        </strong>

                        <span>
                            Capture a photo or upload one, then let AI
                            analyze your style and recommend suitable outfits.
                        </span>

                    </div>

                @endif

            </div>

        </section>

    </div>


    {{-- =====================================================
         RECOMMENDED PRODUCTS
    ====================================================== --}}

    @if($recommendations->isNotEmpty())

        <section class="ai-recommendations">

            <div class="ai-recommendations-head">

                <h2>

                    <i class="fa-solid fa-bag-shopping me-2"></i>

                    Recommended For You

                </h2>

                <span>
                    Curated by AI
                </span>

            </div>


            <div class="ai-products-grid">

                @foreach($recommendations as $item)

                    @php
                        $product = $item['product'];
                    @endphp


                    <article class="ai-product-card">

                        {{-- EXACT SAME IMAGE AREA --}}

                        <div class="ai-product-image-box">

                            <img
                                src="{{ asset('products/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                loading="lazy"
                            >

                        </div>


                        <div class="ai-product-body">

                            <h3 class="ai-product-name">
                                {{ $product->name }}
                            </h3>


                            <div class="ai-product-price">

                                ₹{{ number_format(
                                    (float) $product->price,
                                    2
                                ) }}

                            </div>


                            <div class="ai-product-actions">

                                <form
                                    action="{{ route(
                                        'cart.add',
                                        $product->id
                                    ) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="ai-cart-btn"
                                    >

                                        <i class="fa-solid fa-cart-plus me-1"></i>

                                        Cart

                                    </button>

                                </form>


                                <a
                                    href="{{ route(
                                        'products.show',
                                        $product->id
                                    ) }}"
                                    class="ai-view-btn"
                                >

                                    <i class="fa-solid fa-eye me-1"></i>

                                    View

                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        </section>

    @endif

</div>


{{-- =========================================================
     EXISTING AI CAMERA JAVASCRIPT
========================================================= --}}

<script
    src="{{ asset('js/ai-camera-assistant.js') }}"
    defer
></script>

@vite('resources/js/ai-camera-assistant.js')