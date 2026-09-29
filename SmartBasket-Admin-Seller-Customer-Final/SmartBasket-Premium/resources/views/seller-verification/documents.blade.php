@extends('seller.partials.premium-layout')

@section('title', 'Seller Documents | SmartBasket Premium')

@php
    $step = 2;
@endphp

@section('content')

<style>
/* =========================================================
   SMART BASKET — STEP 2 DOCUMENTS
   PREMIUM LIGHT / DARK RESPONSIVE UI
========================================================= */

.sb-doc-page {
    width: 100%;
    max-width: 1080px;
    margin: 0 auto;
    padding: 10px 0 50px;
}

/* HEADER */

.sb-doc-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 24px;
}

.sb-doc-heading {
    display: flex;
    align-items: center;
    gap: 14px;
}

.sb-doc-icon {
    width: 52px;
    height: 52px;
    flex: 0 0 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;

    background: rgba(0, 255, 153, .10);
    border: 1px solid rgba(0, 255, 153, .20);

    color: #00c982;
    font-size: 20px;

    box-shadow: 0 8px 25px rgba(0, 201, 130, .08);
}

.sb-doc-step {
    color: #00b878;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .14em;
    text-transform: uppercase;
    margin-bottom: 3px;
}

.sb-doc-title {
    margin: 0;
    color: var(--sb-text, #111827);
    font-size: 25px;
    font-weight: 800;
    line-height: 1.15;
}

.sb-doc-subtitle {
    margin: 5px 0 0;
    color: var(--sb-muted, #6b7280);
    font-size: 11px;
}

.sb-doc-secure {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    padding: 9px 13px;

    border-radius: 999px;

    color: #00a86b;
    background: rgba(0, 200, 130, .07);
    border: 1px solid rgba(0, 200, 130, .16);

    font-size: 10px;
    font-weight: 700;
    white-space: nowrap;
}

/* CARD */

.sb-doc-card {
    position: relative;
    overflow: hidden;

    padding: 28px;

    border-radius: 24px;

    background:
        var(
            --sb-card,
            #ffffff
        );

    border:
        1px solid
        var(--sb-border, rgba(15, 23, 42, .08));

    box-shadow:
        0 18px 55px rgba(15, 23, 42, .07);
}

.sb-doc-card::before {
    content: "";
    position: absolute;

    width: 230px;
    height: 230px;

    top: -150px;
    right: -100px;

    border-radius: 50%;

    background: #00d98b;

    opacity: .035;

    filter: blur(25px);

    pointer-events: none;
}

/* ALERTS */

.sb-doc-alert {
    display: flex;
    align-items: flex-start;
    gap: 10px;

    padding: 14px 15px;

    margin-bottom: 20px;

    border-radius: 13px;

    font-size: 11px;
    line-height: 1.6;
}

.sb-doc-alert i {
    margin-top: 2px;
}

.sb-doc-alert-success {
    color: #00865a;
    background: rgba(0, 200, 130, .07);
    border: 1px solid rgba(0, 200, 130, .18);
}

.sb-doc-alert-error {
    color: #dc4545;
    background: rgba(239, 68, 68, .06);
    border: 1px solid rgba(239, 68, 68, .16);
}

.sb-doc-alert-error ul {
    margin: 0;
    padding-left: 18px;
}

.sb-doc-alert-error li + li {
    margin-top: 4px;
}

/* SECTION INTRO */

.sb-doc-section {
    margin-bottom: 24px;
}

.sb-doc-section-title {
    margin: 0;

    color: var(--sb-text, #111827);

    font-size: 16px;
    font-weight: 800;
}

.sb-doc-section-text {
    margin: 4px 0 0;

    color: var(--sb-muted, #6b7280);

    font-size: 10px;
}

/* DOCUMENT GRID */

.sb-document-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 16px;

    margin-top: 20px;
}

/* DOCUMENT BOX */

.sb-document-box {
    position: relative;

    padding: 20px;

    border-radius: 18px;

    background:
        var(
            --sb-input-bg,
            #f8fafc
        );

    border:
        1px solid
        var(--sb-border, rgba(15, 23, 42, .08));

    transition: .25s ease;
}

.sb-document-box:hover {
    transform: translateY(-2px);

    border-color:
        rgba(0, 200, 130, .28);

    box-shadow:
        0 12px 30px rgba(0, 200, 130, .07);
}

.sb-document-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;

    margin-bottom: 17px;
}

.sb-document-info {
    display: flex;
    align-items: center;
    gap: 11px;
}

.sb-document-icon {
    width: 42px;
    height: 42px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 13px;

    background: rgba(0, 200, 130, .08);

    color: #00b878;

    font-size: 17px;
}

.sb-document-name {
    color: var(--sb-text, #111827);

    font-size: 13px;
    font-weight: 800;
}

.sb-document-required {
    display: block;

    margin-top: 2px;

    color: #e45c5c;

    font-size: 9px;
    font-weight: 700;
}

.sb-upload-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;

    padding: 6px 9px;

    border-radius: 999px;

    color: #00865a;

    background: rgba(0, 200, 130, .07);

    font-size: 9px;
    font-weight: 800;

    white-space: nowrap;
}

/* FILE INPUT */

.sb-file-wrapper {
    position: relative;
}

.sb-file-input {
    width: 100%;

    padding: 11px;

    border-radius: 12px;

    background:
        var(
            --sb-card,
            #ffffff
        );

    border:
        1px solid
        var(--sb-border, rgba(15, 23, 42, .10));

    color: var(--sb-muted, #6b7280);

    font-size: 10px;

    cursor: pointer;

    outline: none;

    transition: .2s ease;
}

.sb-file-input:hover {
    border-color:
        rgba(0, 200, 130, .35);
}

.sb-file-input:focus {
    border-color:
        rgba(0, 200, 130, .55);

    box-shadow:
        0 0 0 3px
        rgba(0, 200, 130, .07);
}

.sb-file-input::file-selector-button {
    border: none;

    padding: 8px 12px;

    margin-right: 10px;

    border-radius: 9px;

    background:
        rgba(0, 200, 130, .10);

    color: #00a86b;

    font-size: 10px;
    font-weight: 800;

    cursor: pointer;
}

/* HELP TEXT */

.sb-document-help {
    display: block;

    margin-top: 8px;

    color: var(--sb-muted, #6b7280);

    font-size: 9px;

    line-height: 1.5;
}

/* CURRENT FILE */

.sb-current-file {
    display: flex;
    align-items: center;
    gap: 7px;

    margin-top: 10px;

    padding: 9px 10px;

    border-radius: 10px;

    background: rgba(0, 200, 130, .055);

    color: #00865a;

    font-size: 9px;
    font-weight: 700;
}

.sb-current-file i {
    font-size: 11px;
}

/* SECURITY */

.sb-security {
    display: flex;
    align-items: flex-start;
    gap: 11px;

    margin-top: 22px;

    padding: 14px 15px;

    border-radius: 13px;

    background:
        rgba(59, 130, 246, .045);

    border:
        1px solid
        rgba(59, 130, 246, .12);
}

.sb-security-icon {
    color: #3b82f6;
    font-size: 14px;
    margin-top: 2px;
}

.sb-security-title {
    color: var(--sb-text, #111827);

    font-size: 10px;
    font-weight: 800;
}

.sb-security-text {
    margin-top: 3px;

    color: var(--sb-muted, #6b7280);

    font-size: 9px;
    line-height: 1.5;
}

/* ACTIONS */

.sb-doc-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;

    margin-top: 26px;

    padding-top: 20px;

    border-top:
        1px solid
        var(--sb-border, rgba(15, 23, 42, .08));
}

.sb-doc-back,
.sb-doc-submit {
    min-height: 48px;

    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    padding: 0 18px;

    border-radius: 13px;

    text-decoration: none;

    font-size: 11px;
    font-weight: 800;

    transition: .25s ease;
}

.sb-doc-back {
    color: var(--sb-muted, #6b7280);

    background:
        var(--sb-input-bg, #f8fafc);

    border:
        1px solid
        var(--sb-border, rgba(15, 23, 42, .09));
}

.sb-doc-back:hover {
    color: var(--sb-text, #111827);

    transform: translateY(-2px);
}

.sb-doc-submit {
    border: none;

    color: #062017;

    background:
        linear-gradient(
            135deg,
            #63e6b3,
            #00c982
        );

    box-shadow:
        0 10px 25px
        rgba(0, 200, 130, .14);

    cursor: pointer;
}

.sb-doc-submit:hover {
    transform: translateY(-2px);

    box-shadow:
        0 15px 32px
        rgba(0, 200, 130, .23);
}

/* COMPLETED */

.sb-completed {
    display: flex;
    align-items: center;
    gap: 10px;

    margin-top: 18px;

    padding: 13px 15px;

    border-radius: 12px;

    color: #00865a;

    background:
        rgba(0, 200, 130, .06);

    border:
        1px solid
        rgba(0, 200, 130, .16);

    font-size: 10px;
    font-weight: 700;
}

.sb-completed i {
    font-size: 15px;
}

/* =========================================================
   DARK THEME
========================================================= */

html:not(.light) .sb-doc-card,
body:not(.light) .sb-doc-card {
    --sb-card: rgba(15, 29, 28, .84);
    --sb-input-bg: rgba(255,255,255,.035);
    --sb-text: #e8f0ee;
    --sb-muted: #8fa6a0;
    --sb-border: rgba(190,220,209,.13);
}

html:not(.light) .sb-file-input,
body:not(.light) .sb-file-input {
    color: #aabdb7;
}

html:not(.light) .sb-file-input::file-selector-button,
body:not(.light) .sb-file-input::file-selector-button {
    background: rgba(99,230,179,.10);
    color: #63e6b3;
}

/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 760px) {

    .sb-doc-header {
        align-items: flex-start;
    }

    .sb-doc-secure {
        display: none;
    }

    .sb-document-grid {
        grid-template-columns: 1fr;
    }

    .sb-doc-card {
        padding: 21px 17px;
        border-radius: 20px;
    }

    .sb-doc-title {
        font-size: 21px;
    }

    .sb-doc-actions {
        flex-direction: column-reverse;
        align-items: stretch;
    }

    .sb-doc-back,
    .sb-doc-submit {
        width: 100%;
    }
}

@media (max-width: 480px) {

    .sb-doc-heading {
        align-items: flex-start;
    }

    .sb-doc-icon {
        width: 45px;
        height: 45px;
        flex-basis: 45px;
        border-radius: 14px;
    }

    .sb-doc-title {
        font-size: 19px;
    }

    .sb-doc-subtitle {
        font-size: 9px;
    }

    .sb-document-box {
        padding: 16px;
    }

    .sb-document-top {
        align-items: flex-start;
    }

    .sb-upload-status {
        font-size: 8px;
    }
}
</style>


<div class="sb-doc-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="sb-doc-header">

        <div class="sb-doc-heading">

            <div class="sb-doc-icon">
                <i class="fa-solid fa-file-shield"></i>
            </div>

            <div>

                <div class="sb-doc-step">
                    STEP 2 OF 6
                </div>

                <h1 class="sb-doc-title">
                    Upload your documents
                </h1>

                <p class="sb-doc-subtitle">
                    Securely upload the documents required for seller verification.
                </p>

            </div>

        </div>

        <div class="sb-doc-secure">
            <i class="fa-solid fa-lock"></i>
            Secure Upload
        </div>

    </div>


    {{-- =====================================================
         CARD
    ====================================================== --}}

    <div class="sb-doc-card">


        {{-- SUCCESS --}}

        @if(session('success'))

            <div class="sb-doc-alert sb-doc-alert-success">

                <i class="fa-solid fa-circle-check"></i>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif


        {{-- ERROR --}}

        @if(session('error'))

            <div class="sb-doc-alert sb-doc-alert-error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <div>
                    {{ session('error') }}
                </div>

            </div>

        @endif


        {{-- VALIDATION ERRORS --}}

        @if($errors->any())

            <div class="sb-doc-alert sb-doc-alert-error">

                <i class="fa-solid fa-triangle-exclamation"></i>

                <div>

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif


        <div class="sb-doc-section">

            <h2 class="sb-doc-section-title">
                KYC & Business Documents
            </h2>

            <p class="sb-doc-section-text">
                Both documents are required to complete Step 2.
                Existing documents can be replaced whenever required.
            </p>

        </div>


        {{-- =====================================================
             FORM
        ====================================================== --}}

        <form
            method="POST"
            action="{{ route('seller.verification.documents.upload') }}"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="sb-document-grid">


                {{-- =================================================
                     BUSINESS CERTIFICATE
                ================================================== --}}

                <div class="sb-document-box">

                    <div class="sb-document-top">

                        <div class="sb-document-info">

                            <div class="sb-document-icon">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>

                            <div>

                                <div class="sb-document-name">
                                    Business Certificate
                                </div>

                                @if(!$seller->business_certificate_path)

                                    <span class="sb-document-required">
                                        REQUIRED
                                    </span>

                                @endif

                            </div>

                        </div>


                        @if($seller->business_certificate_path)

                            <div class="sb-upload-status">

                                <i class="fa-solid fa-check"></i>

                                Uploaded

                            </div>

                        @endif

                    </div>


                    <input
                        type="file"
                        name="business_certificate"
                        class="sb-file-input"
                        accept=".pdf,.jpg,.jpeg,.png,.webp"
                        {{ $seller->business_certificate_path ? '' : 'required' }}
                    >


                    @if($seller->business_certificate_path)

                        <div class="sb-current-file">

                            <i class="fa-solid fa-circle-check"></i>

                            Existing certificate saved. Select a new file
                            only if you want to replace it.

                        </div>

                    @else

                        <small class="sb-document-help">

                            PDF, JPG, JPEG, PNG or WEBP · Maximum 5 MB

                        </small>

                    @endif

                </div>


                {{-- =================================================
                     AADHAAR
                ================================================== --}}

                <div class="sb-document-box">

                    <div class="sb-document-top">

                        <div class="sb-document-info">

                            <div class="sb-document-icon">
                                <i class="fa-solid fa-id-card"></i>
                            </div>

                            <div>

                                <div class="sb-document-name">
                                    Aadhaar Document
                                </div>

                                @if(!$seller->aadhaar_document_path)

                                    <span class="sb-document-required">
                                        REQUIRED
                                    </span>

                                @endif

                            </div>

                        </div>


                        @if($seller->aadhaar_document_path)

                            <div class="sb-upload-status">

                                <i class="fa-solid fa-check"></i>

                                Uploaded

                            </div>

                        @endif

                    </div>


                    <input
                        type="file"
                        name="aadhaar_document"
                        class="sb-file-input"
                        accept=".pdf,.jpg,.jpeg,.png,.webp"
                        {{ $seller->aadhaar_document_path ? '' : 'required' }}
                    >


                    @if($seller->aadhaar_document_path)

                        <div class="sb-current-file">

                            <i class="fa-solid fa-circle-check"></i>

                            Existing Aadhaar document saved. Select a new
                            file only if you want to replace it.

                        </div>

                    @else

                        <small class="sb-document-help">

                            PDF, JPG, JPEG, PNG or WEBP · Maximum 5 MB

                        </small>

                    @endif

                </div>


            </div>


            {{-- SECURITY NOTICE --}}

            <div class="sb-security">

                <div class="sb-security-icon">

                    <i class="fa-solid fa-shield-halved"></i>

                </div>

                <div>

                    <div class="sb-security-title">
                        Your documents are protected
                    </div>

                    <div class="sb-security-text">
                        Documents are stored privately and are intended only
                        for authorized SmartBasket verification and review.
                    </div>

                </div>

            </div>


            {{-- ACTIONS --}}

            <div class="sb-doc-actions">

                <a
                    href="{{ route('seller.verification.email') }}"
                    class="sb-doc-back"
                >
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Step 1
                </a>


                <button
                    type="submit"
                    class="sb-doc-submit"
                >
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    Save & Continue to Step 3
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

            </div>

        </form>


        {{-- =====================================================
             COMPLETED STATE
        ====================================================== --}}

        @if(
            $seller->business_certificate_path &&
            $seller->aadhaar_document_path
        )

            <div class="sb-completed">

                <i class="fa-solid fa-circle-check"></i>

                <span>
                    Step 2 completed — Business Certificate and Aadhaar
                    Document are already uploaded.
                </span>

            </div>

        @endif

    </div>

</div>

@endsection