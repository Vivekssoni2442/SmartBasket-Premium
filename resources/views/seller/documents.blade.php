@extends('seller.partials.premium-layout')

@section('title', 'Seller Documents')

@php
    $step = 2;
@endphp

@section('content')

<style>
/* =========================================================
   SMART BASKET — SELLER DOCUMENTS
   PREMIUM LIGHT THEME
========================================================= */

.documents-page {
    --doc-bg: #f6f8fc;
    --doc-card: #ffffff;
    --doc-card-soft: #f8fafc;
    --doc-text: #111827;
    --doc-muted: #64748b;
    --doc-line: rgba(15, 23, 42, .09);

    --doc-accent: #00a86b;
    --doc-accent-light: #00c98a;
    --doc-accent-dark: #008f5b;

    width: 100%;
    max-width: 1050px;
    margin: 0 auto;
    padding: 15px 20px 60px;

    color: var(--doc-text);
}

/* =========================================================
   MAIN CARD
========================================================= */

.documents-card {
    position: relative;
    overflow: hidden;

    padding: 36px;

    border-radius: 28px;

    background:
        linear-gradient(
            145deg,
            #ffffff 0%,
            #fbfdff 55%,
            #f7fafc 100%
        );

    border: 1px solid rgba(15, 23, 42, .08);

    box-shadow:
        0 30px 80px rgba(15, 23, 42, .10),
        0 8px 25px rgba(15, 23, 42, .04);
}

/* Decorative glow */

.documents-card::before {
    content: "";

    position: absolute;

    width: 330px;
    height: 330px;

    top: -190px;
    right: -110px;

    border-radius: 50%;

    background: #00c98a;

    opacity: .055;

    filter: blur(45px);

    pointer-events: none;
}

.documents-card::after {
    content: "";

    position: absolute;

    width: 220px;
    height: 220px;

    bottom: -150px;
    left: -100px;

    border-radius: 50%;

    background: #38bdf8;

    opacity: .035;

    filter: blur(45px);

    pointer-events: none;
}

/* =========================================================
   STEP BADGE
========================================================= */

.document-step {
    position: relative;
    z-index: 2;

    display: inline-flex;
    align-items: center;
    gap: 8px;

    margin-bottom: 15px;

    padding: 7px 12px;

    border-radius: 999px;

    color: var(--doc-accent);

    background: rgba(0, 168, 107, .075);

    border: 1px solid rgba(0, 168, 107, .18);

    font-size: 10px;
    font-weight: 850;

    letter-spacing: .10em;
}

.document-step::before {
    content: "2";

    width: 18px;
    height: 18px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    color: #ffffff;

    background:
        linear-gradient(
            135deg,
            var(--doc-accent-light),
            var(--doc-accent)
        );

    font-size: 9px;
    font-weight: 900;
}

/* =========================================================
   HEADER
========================================================= */

.documents-header {
    position: relative;
    z-index: 2;

    display: flex;
    align-items: center;

    gap: 17px;

    margin-bottom: 28px;
    padding-bottom: 25px;

    border-bottom: 1px solid var(--doc-line);
}

.documents-icon {
    width: 60px;
    height: 60px;

    flex: 0 0 60px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 18px;

    color: var(--doc-accent);

    background:
        linear-gradient(
            145deg,
            rgba(0, 200, 130, .12),
            rgba(0, 168, 107, .055)
        );

    border: 1px solid rgba(0, 168, 107, .16);

    font-size: 22px;

    box-shadow:
        0 12px 30px rgba(0, 168, 107, .08);
}

.documents-header h1 {
    margin: 0;

    color: var(--doc-text);

    font-size: clamp(25px, 3vw, 32px);

    line-height: 1.15;

    font-weight: 850;

    letter-spacing: -.7px;
}

.documents-header h1 span {
    color: var(--doc-accent);
}

.documents-header p {
    margin: 7px 0 0;

    max-width: 680px;

    color: var(--doc-muted);

    font-size: 12px;

    line-height: 1.65;
}

/* =========================================================
   ALERTS
========================================================= */

.sb-alert {
    position: relative;
    z-index: 3;

    display: flex;
    align-items: flex-start;

    gap: 10px;

    margin-bottom: 20px;

    padding: 14px 16px;

    border-radius: 14px;

    font-size: 12px;

    line-height: 1.55;
}

.sb-alert-success {
    color: #087f5b;

    background: rgba(16, 185, 129, .08);

    border: 1px solid rgba(16, 185, 129, .20);
}

.sb-alert-error {
    color: #c62828;

    background: rgba(239, 68, 68, .07);

    border: 1px solid rgba(239, 68, 68, .18);
}

/* =========================================================
   DOCUMENT GRID
========================================================= */

.documents-grid {
    position: relative;
    z-index: 2;

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 20px;

    margin-top: 8px;
}

/* =========================================================
   DOCUMENT BOX
========================================================= */

.document-box {
    position: relative;

    padding: 24px;

    border-radius: 20px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #f8fafc
        );

    border: 1px solid rgba(15, 23, 42, .08);

    box-shadow:
        0 10px 30px rgba(15, 23, 42, .035);

    transition:
        transform .25s ease,
        border-color .25s ease,
        box-shadow .25s ease;
}

.document-box:hover {
    transform: translateY(-4px);

    border-color: rgba(0, 168, 107, .28);

    box-shadow:
        0 18px 40px rgba(15, 23, 42, .08),
        0 8px 25px rgba(0, 168, 107, .06);
}

/* =========================================================
   DOCUMENT HEADER
========================================================= */

.document-box-header {
    display: flex;

    align-items: flex-start;

    justify-content: space-between;

    gap: 15px;

    margin-bottom: 20px;
}

.document-info {
    display: flex;

    align-items: center;

    gap: 13px;
}

.document-type-icon {
    width: 45px;
    height: 45px;

    flex: 0 0 45px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 14px;

    color: var(--doc-accent);

    background:
        linear-gradient(
            145deg,
            rgba(0, 200, 130, .12),
            rgba(0, 168, 107, .055)
        );

    border: 1px solid rgba(0, 168, 107, .13);

    font-size: 17px;
}

.document-title {
    margin: 0;

    color: var(--doc-text);

    font-size: 13px;

    font-weight: 850;
}

.document-description {
    margin-top: 4px;

    color: var(--doc-muted);

    font-size: 9px;

    line-height: 1.5;
}

/* =========================================================
   STATUS
========================================================= */

.document-status {
    padding: 6px 9px;

    border-radius: 999px;

    white-space: nowrap;

    font-size: 8px;

    font-weight: 850;

    letter-spacing: .05em;
}

.document-status.required {
    color: #a16207;

    background: rgba(245, 158, 11, .10);

    border: 1px solid rgba(245, 158, 11, .20);
}

.document-status.uploaded {
    color: #087f5b;

    background: rgba(16, 185, 129, .09);

    border: 1px solid rgba(16, 185, 129, .20);
}

/* =========================================================
   FILE INPUT
========================================================= */

.document-file-input {
    width: 100%;

    padding: 13px;

    border-radius: 14px;

    color: var(--doc-muted);

    background: #f8fafc;

    border: 1px dashed rgba(100, 116, 139, .28);

    font-size: 10px;

    cursor: pointer;

    transition: .25s ease;
}

.document-file-input:hover {
    border-color: rgba(0, 168, 107, .40);

    background: rgba(0, 200, 130, .035);
}

.document-file-input:focus {
    outline: none;

    border-color: var(--doc-accent);

    box-shadow:
        0 0 0 3px rgba(0, 168, 107, .08);
}

.document-file-input::file-selector-button {
    margin-right: 10px;

    padding: 8px 13px;

    border: none;

    border-radius: 9px;

    color: #087f5b;

    background: rgba(0, 168, 107, .10);

    font-family: inherit;

    font-size: 10px;

    font-weight: 850;

    cursor: pointer;

    transition: .2s ease;
}

.document-file-input::file-selector-button:hover {
    background: rgba(0, 168, 107, .17);
}

/* =========================================================
   HELP
========================================================= */

.document-help {
    display: block;

    margin-top: 9px;

    color: var(--doc-muted);

    font-size: 9px;

    line-height: 1.5;
}

.document-existing {
    display: flex;

    align-items: center;

    gap: 8px;

    margin-top: 10px;

    padding: 10px 12px;

    border-radius: 11px;

    color: #087f5b;

    background: rgba(16, 185, 129, .065);

    border: 1px solid rgba(16, 185, 129, .14);

    font-size: 9px;

    font-weight: 650;

    line-height: 1.5;
}

.document-existing i {
    font-size: 11px;
}

/* =========================================================
   ACTIONS
========================================================= */

.documents-actions {
    position: relative;
    z-index: 2;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 14px;

    margin-top: 30px;

    padding-top: 24px;

    border-top: 1px solid var(--doc-line);
}

.document-btn {
    min-height: 50px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    padding: 0 20px;

    border-radius: 13px;

    text-decoration: none;

    font-family: inherit;

    font-size: 11px;

    font-weight: 850;

    cursor: pointer;

    transition: .25s ease;
}

.document-btn-back {
    color: #64748b;

    background: #f8fafc;

    border: 1px solid rgba(100, 116, 139, .18);
}

.document-btn-back:hover {
    color: #111827;

    background: #f1f5f9;

    transform: translateY(-2px);
}

.document-btn-primary {
    min-width: 210px;

    border: none;

    color: #ffffff;

    background:
        linear-gradient(
            135deg,
            #00c98a,
            #00a86b
        );

    box-shadow:
        0 10px 28px rgba(0, 168, 107, .18);
}

.document-btn-primary:hover {
    transform: translateY(-2px);

    box-shadow:
        0 15px 35px rgba(0, 168, 107, .25);
}

.document-btn-primary:active {
    transform: translateY(0);
}

/* =========================================================
   SECURITY
========================================================= */

.documents-security {
    position: relative;
    z-index: 2;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    margin-top: 19px;

    color: #94a3b8;

    font-size: 9px;

    text-align: center;
}

.documents-security i {
    color: var(--doc-accent);
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 760px) {

    .documents-page {
        padding: 8px 14px 40px;
    }

    .documents-card {
        padding: 25px 18px;

        border-radius: 22px;
    }

    .documents-header {
        align-items: flex-start;

        margin-bottom: 23px;
    }

    .documents-icon {
        width: 50px;
        height: 50px;

        flex-basis: 50px;

        border-radius: 15px;

        font-size: 19px;
    }

    .documents-grid {
        grid-template-columns: 1fr;

        gap: 15px;
    }

    .document-box {
        padding: 20px;
    }
}

@media (max-width: 500px) {

    .documents-page {
        padding-left: 10px;
        padding-right: 10px;
    }

    .documents-card {
        padding: 21px 15px;

        border-radius: 20px;
    }

    .documents-header {
        gap: 12px;
    }

    .documents-header h1 {
        font-size: 22px;
    }

    .documents-header p {
        font-size: 10px;
    }

    .document-box-header {
        flex-direction: column;
    }

    .documents-actions {
        flex-direction: column-reverse;
    }

    .document-btn,
    .document-btn-primary {
        width: 100%;
    }
}
</style>


<div class="documents-page">

    <div class="documents-card">

        {{-- STEP --}}

        <div class="document-step">
            STEP 2 OF 6
        </div>


        {{-- HEADER --}}

        <div class="documents-header">

            <div class="documents-icon">
                <i class="fa-solid fa-file-shield"></i>
            </div>

            <div>

                <h1>
                    Upload your <span>documents</span>
                </h1>

                <p>
                    Securely upload the documents required to verify your
                    SmartBasket seller account.
                </p>

            </div>

        </div>


        {{-- SUCCESS --}}

        @if(session('success'))

            <div class="sb-alert sb-alert-success">

                <i class="fa-solid fa-circle-check"></i>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif


        {{-- ERROR --}}

        @if(session('error'))

            <div class="sb-alert sb-alert-error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <div>
                    {{ session('error') }}
                </div>

            </div>

        @endif


        {{-- VALIDATION --}}

        @if($errors->any())

            <div class="sb-alert sb-alert-error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <ul style="margin:0;padding-left:18px;">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- FORM --}}

        <form
            method="POST"
            action="{{ route('seller.verification.documents.upload') }}"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="documents-grid">


                {{-- BUSINESS CERTIFICATE --}}

                <div class="document-box">

                    <div class="document-box-header">

                        <div class="document-info">

                            <div class="document-type-icon">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>

                            <div>

                                <h3 class="document-title">
                                    Business Certificate
                                </h3>

                                <div class="document-description">
                                    Proof of your registered business
                                </div>

                            </div>

                        </div>


                        @if($seller->business_certificate_path)

                            <span class="document-status uploaded">
                                <i class="fa-solid fa-check"></i>
                                UPLOADED
                            </span>

                        @else

                            <span class="document-status required">
                                REQUIRED
                            </span>

                        @endif

                    </div>


                    <input
                        type="file"
                        name="business_certificate"
                        class="document-file-input"
                        accept=".pdf,.jpg,.jpeg,.png,.webp"
                        @if(!$seller->business_certificate_path)
                            required
                        @endif
                    >


                    @if($seller->business_certificate_path)

                        <div class="document-existing">

                            <i class="fa-solid fa-circle-check"></i>

                            Business Certificate already uploaded.
                            Select another file only to replace it.

                        </div>

                    @else

                        <small class="document-help">
                            PDF, JPG, JPEG, PNG or WEBP · Maximum 5 MB
                        </small>

                    @endif

                </div>


                {{-- AADHAAR --}}

                <div class="document-box">

                    <div class="document-box-header">

                        <div class="document-info">

                            <div class="document-type-icon">
                                <i class="fa-solid fa-id-card"></i>
                            </div>

                            <div>

                                <h3 class="document-title">
                                    Aadhaar Document
                                </h3>

                                <div class="document-description">
                                    Government identity verification
                                </div>

                            </div>

                        </div>


                        @if($seller->aadhaar_document_path)

                            <span class="document-status uploaded">
                                <i class="fa-solid fa-check"></i>
                                UPLOADED
                            </span>

                        @else

                            <span class="document-status required">
                                REQUIRED
                            </span>

                        @endif

                    </div>


                    <input
                        type="file"
                        name="aadhaar_document"
                        class="document-file-input"
                        accept=".pdf,.jpg,.jpeg,.png,.webp"
                        @if(!$seller->aadhaar_document_path)
                            required
                        @endif
                    >


                    @if($seller->aadhaar_document_path)

                        <div class="document-existing">

                            <i class="fa-solid fa-circle-check"></i>

                            Aadhaar document already uploaded.
                            Select another file only to replace it.

                        </div>

                    @else

                        <small class="document-help">
                            PDF, JPG, JPEG, PNG or WEBP · Maximum 5 MB
                        </small>

                    @endif

                </div>

                @foreach([
                    ['name' => 'pan_document', 'field' => 'pan_document_path', 'title' => 'PAN Document', 'description' => 'Tax identity proof'],
                    ['name' => 'shop_proof', 'field' => 'shop_proof_path', 'title' => 'Shop / Business Proof', 'description' => 'Proof of business address'],
                    ['name' => 'bank_proof', 'field' => 'bank_proof_path', 'title' => 'Bank Proof', 'description' => 'Bank statement or cancelled cheque'],
                ] as $document)
                    <div class="document-box">
                        <div class="document-box-header">
                            <div class="document-info">
                                <div class="document-type-icon"><i class="fa-solid fa-file-lines"></i></div>
                                <div>
                                    <h3 class="document-title">{{ $document['title'] }}</h3>
                                    <div class="document-description">{{ $document['description'] }}</div>
                                </div>
                            </div>
                            @if($seller->{$document['field']})
                                <span class="document-status uploaded"><i class="fa-solid fa-check"></i> UPLOADED</span>
                            @else
                                <span class="document-status required">REQUIRED</span>
                            @endif
                        </div>
                        <input type="file" name="{{ $document['name'] }}" class="document-file-input" accept=".pdf,.jpg,.jpeg,.png,.webp" @if(!$seller->{$document['field']}) required @endif>
                        @if($seller->{$document['field']})
                            <div class="document-existing"><i class="fa-solid fa-circle-check"></i> Document already uploaded. Select another file only to replace it.</div>
                        @else
                            <small class="document-help">PDF, JPG, JPEG, PNG or WEBP · Maximum 5 MB</small>
                        @endif
                    </div>
                @endforeach

            </div>


            {{-- ACTIONS --}}

            <div class="documents-actions">

                <a
                    href="{{ route('seller.verification.email') }}"
                    class="document-btn document-btn-back"
                >
                    <i class="fa-solid fa-arrow-left"></i>
                    Back
                </a>


                <button
                    type="submit"
                    class="document-btn document-btn-primary"
                >
                    Save & Continue

                    <i class="fa-solid fa-arrow-right"></i>
                </button>

            </div>

        </form>


        {{-- SECURITY --}}

        <div class="documents-security">

            <i class="fa-solid fa-shield-halved"></i>

            Your documents are securely stored and used only for seller verification.

        </div>

    </div>

</div>

@endsection