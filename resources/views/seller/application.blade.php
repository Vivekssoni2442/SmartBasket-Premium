@extends('seller.partials.premium-layout')

@section('title', 'Seller Application Summary | SmartBasket Premium')

@section('content')

<style>
/* =========================================================
   SMART BASKET — SELLER APPLICATION SUMMARY
   PREMIUM LIGHT UI
========================================================= */

:root {
    --sum-bg: #f4f7f8;
    --sum-card: #ffffff;
    --sum-card-soft: #f8fbfa;
    --sum-text: #17211f;
    --sum-muted: #71807b;
    --sum-line: #e4ece9;
    --sum-green: #12a875;
    --sum-green-dark: #07845b;
    --sum-green-soft: #e9faf3;
    --sum-blue: #3b82f6;
    --sum-warning: #d89b18;
    --sum-danger: #dc5c5c;
    --sum-shadow: 0 18px 50px rgba(26, 54, 47, .08);
}

/* PAGE */

.summary-page {
    min-height: 100vh;
    padding: 34px 24px 70px;
    background:
        radial-gradient(
            circle at 5% 0%,
            rgba(18,168,117,.10),
            transparent 28%
        ),
        radial-gradient(
            circle at 95% 10%,
            rgba(59,130,246,.06),
            transparent 24%
        ),
        var(--sum-bg);
    color: var(--sum-text);
}

.summary-container {
    width: 100%;
    max-width: 1120px;
    margin: 0 auto;
}


/* =========================================================
   HERO
========================================================= */

.summary-hero {
    position: relative;
    overflow: hidden;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 25px;

    padding: 30px;

    margin-bottom: 22px;

    border: 1px solid var(--sum-line);
    border-radius: 24px;

    background:
        linear-gradient(
            135deg,
            #ffffff,
            #f8fcfa
        );

    box-shadow: var(--sum-shadow);
}

.summary-hero::after {
    content: "";
    position: absolute;

    width: 220px;
    height: 220px;

    right: -80px;
    top: -120px;

    border-radius: 50%;

    background: rgba(18,168,117,.09);

    filter: blur(8px);

    pointer-events: none;
}

.hero-left {
    display: flex;
    align-items: center;
    gap: 17px;

    position: relative;
    z-index: 2;
}

.hero-icon {
    width: 58px;
    height: 58px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex: 0 0 58px;

    border-radius: 17px;

    color: var(--sum-green);

    background: var(--sum-green-soft);

    border: 1px solid #ccefe1;

    font-size: 22px;
}

.hero-eyebrow {
    margin-bottom: 4px;

    color: var(--sum-green);

    font-size: 10px;
    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .13em;
}

.hero-title {
    margin: 0;

    font-size: clamp(23px, 3vw, 32px);

    line-height: 1.15;

    font-weight: 800;

    color: var(--sum-text);
}

.hero-title span {
    color: var(--sum-green);
}

.hero-description {
    margin: 7px 0 0;

    color: var(--sum-muted);

    font-size: 12px;
    line-height: 1.6;
}

.hero-badge {
    position: relative;
    z-index: 2;

    display: inline-flex;
    align-items: center;
    gap: 8px;

    padding: 10px 14px;

    border-radius: 999px;

    color: var(--sum-green-dark);

    background: var(--sum-green-soft);

    border: 1px solid #ccefe1;

    font-size: 10px;
    font-weight: 800;

    white-space: nowrap;
}

.hero-badge::before {
    content: "";

    width: 7px;
    height: 7px;

    border-radius: 50%;

    background: var(--sum-green);
}


/* =========================================================
   INFO NOTICE
========================================================= */

.summary-notice {
    display: flex;
    align-items: center;

    gap: 12px;

    margin-bottom: 22px;

    padding: 14px 17px;

    border-radius: 14px;

    background: #eef8ff;

    border: 1px solid #d9ecfb;

    color: #557080;

    font-size: 11px;

    line-height: 1.5;
}

.summary-notice i {
    color: var(--sum-blue);

    font-size: 15px;

    flex: 0 0 auto;
}


/* =========================================================
   SUMMARY GRID
========================================================= */

.summary-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 18px;
}


/* =========================================================
   SUMMARY CARD
========================================================= */

.summary-card {
    position: relative;

    overflow: hidden;

    padding: 22px;

    border-radius: 19px;

    background: var(--sum-card);

    border: 1px solid var(--sum-line);

    box-shadow:
        0 10px 30px rgba(24, 54, 46, .055);

    transition: .25s ease;
}

.summary-card:hover {
    transform: translateY(-2px);

    box-shadow:
        0 16px 38px rgba(24, 54, 46, .09);

    border-color: #d5e8e1;
}

.summary-card::after {
    content: "";

    position: absolute;

    width: 120px;
    height: 120px;

    right: -70px;
    bottom: -70px;

    border-radius: 50%;

    background: rgba(18,168,117,.035);

    pointer-events: none;
}


/* CARD HEADER */

.summary-card-header {
    display: flex;

    align-items: center;

    gap: 12px;

    padding-bottom: 16px;

    margin-bottom: 17px;

    border-bottom: 1px solid var(--sum-line);
}

.summary-card-icon {
    width: 39px;
    height: 39px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex: 0 0 39px;

    border-radius: 12px;

    color: var(--sum-green);

    background: var(--sum-green-soft);

    font-size: 14px;
}

.summary-card-title {
    margin: 0;

    color: var(--sum-text);

    font-size: 15px;

    font-weight: 800;
}

.summary-card-subtitle {
    margin-top: 2px;

    color: var(--sum-muted);

    font-size: 9px;
}


/* =========================================================
   DETAILS
========================================================= */

.detail-list {
    display: grid;

    gap: 0;
}

.detail-row {
    display: grid;

    grid-template-columns:
        minmax(105px, .65fr)
        minmax(0, 1.35fr);

    gap: 15px;

    padding: 11px 0;

    border-bottom: 1px solid #edf2f0;
}

.detail-row:last-child {
    border-bottom: none;

    padding-bottom: 0;
}

.detail-label {
    color: #8a9995;

    font-size: 9px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .07em;
}

.detail-value {
    color: var(--sum-text);

    font-size: 11px;

    font-weight: 600;

    line-height: 1.5;

    word-break: break-word;
}

.detail-value.muted {
    color: #9aa7a3;

    font-weight: 500;
}

.detail-value.success {
    color: var(--sum-green-dark);

    font-weight: 700;
}

.detail-value.warning {
    color: var(--sum-warning);

    font-weight: 700;
}

.detail-value.danger {
    color: var(--sum-danger);

    font-weight: 700;
}


/* =========================================================
   VERIFICATION STATUS
========================================================= */

.status-line {
    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 6px 10px;

    border-radius: 8px;

    background: var(--sum-green-soft);

    border: 1px solid #d0eee2;

    color: var(--sum-green-dark);

    font-size: 9px;

    font-weight: 800;

    text-transform: uppercase;
}

.status-line::before {
    content: "";

    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: var(--sum-green);
}


/* =========================================================
   DOCUMENT STATUS
========================================================= */

.document-status {
    display: inline-flex;

    align-items: center;

    gap: 6px;

    font-size: 10px;

    font-weight: 700;
}

.document-status.uploaded {
    color: var(--sum-green-dark);
}

.document-status.missing {
    color: #9aa7a3;
}

.document-status i {
    font-size: 10px;
}


/* =========================================================
   BOTTOM ACTION
========================================================= */

.summary-actions {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    margin-top: 22px;

    padding: 20px 22px;

    border-radius: 18px;

    background: #ffffff;

    border: 1px solid var(--sum-line);

    box-shadow:
        0 10px 30px rgba(24,54,46,.055);
}

.action-info {
    display: flex;
    align-items: center;

    gap: 11px;
}

.action-icon {
    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 11px;

    color: var(--sum-green);

    background: var(--sum-green-soft);
}

.action-title {
    color: var(--sum-text);

    font-size: 12px;

    font-weight: 800;
}

.action-text {
    margin-top: 2px;

    color: var(--sum-muted);

    font-size: 9px;
}

.review-btn {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 9px;

    min-height: 45px;

    padding: 0 20px;

    border: none;

    border-radius: 12px;

    background:
        linear-gradient(
            135deg,
            #16b97e,
            #079a69
        );

    color: #ffffff;

    text-decoration: none;

    font-size: 11px;

    font-weight: 800;

    box-shadow:
        0 9px 22px rgba(18,168,117,.18);

    transition: .25s ease;
}

.review-btn:hover {
    color: #ffffff;

    transform: translateY(-2px);

    box-shadow:
        0 13px 28px rgba(18,168,117,.25);
}


/* =========================================================
   FOOTER
========================================================= */

.summary-footer {
    margin-top: 18px;

    text-align: center;

    color: #99a6a2;

    font-size: 9px;
}

.summary-footer i {
    color: var(--sum-green);
    margin-right: 4px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 800px) {

    .summary-page {
        padding:
            25px 16px 55px;
    }

    .summary-hero {
        padding: 24px 20px;
    }

    .summary-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 560px) {

    .summary-page {
        padding:
            18px 12px 45px;
    }

    .summary-hero {
        display: block;

        padding: 21px 17px;
    }

    .hero-badge {
        margin-top: 17px;
    }

    .hero-icon {
        width: 50px;
        height: 50px;

        flex-basis: 50px;
    }

    .summary-notice {
        align-items: flex-start;
    }

    .summary-card {
        padding: 18px 16px;
    }

    .detail-row {
        grid-template-columns: 1fr;

        gap: 4px;
    }

    .summary-actions {
        display: block;

        padding: 18px;
    }

    .review-btn {
        width: 100%;

        margin-top: 15px;
    }
}
</style>


<div class="summary-page">

    <div class="summary-container">


        {{-- =====================================================
             HERO
        ====================================================== --}}

        <div class="summary-hero">

            <div class="hero-left">

                <div class="hero-icon">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>

                <div>

                    <div class="hero-eyebrow">
                        Seller Verification & KYC
                    </div>

                    <h1 class="hero-title">
                        Seller Application <span>Summary</span>
                    </h1>

                    <p class="hero-description">
                        Review the information SmartBasket has securely stored
                        for your seller application.
                    </p>

                </div>

            </div>


            <div class="hero-badge">
                <i class="fa-solid fa-shield-halved"></i>
                Secure Information
            </div>

        </div>


        {{-- =====================================================
             NOTICE
        ====================================================== --}}

        <div class="summary-notice">

            <i class="fa-solid fa-circle-info"></i>

            <div>
                Sensitive information such as PAN and bank account numbers
                is partially masked for your security.
            </div>

        </div>


        {{-- =====================================================
             SUMMARY GRID
        ====================================================== --}}

        <div class="summary-grid">


            {{-- =================================================
                 PERSONAL DETAILS
            ================================================== --}}

            <div class="summary-card">

                <div class="summary-card-header">

                    <div class="summary-card-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div>

                        <h2 class="summary-card-title">
                            Personal Details
                        </h2>

                        <div class="summary-card-subtitle">
                            Seller account information
                        </div>

                    </div>

                </div>


                <div class="detail-list">

                    <div class="detail-row">

                        <span class="detail-label">
                            Seller Name
                        </span>

                        <span class="detail-value">
                            {{ $seller->seller_name ?: 'Not provided' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Email
                        </span>

                        <span class="detail-value">
                            {{ $seller->email ?: 'Not provided' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Mobile
                        </span>

                        <span class="detail-value">
                            {{ $seller->mobile_number ?: 'Not provided' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Address
                        </span>

                        <span class="detail-value">
                            {{ $seller->shop_address ?: 'Not provided' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Location
                        </span>

                        <span class="detail-value">

                            {{ collect([
                                $seller->city,
                                $seller->state,
                                $seller->pincode
                            ])->filter()->implode(', ') ?: 'Not provided' }}

                        </span>

                    </div>

                </div>

            </div>



            {{-- =================================================
                 BUSINESS DETAILS
            ================================================== --}}

            <div class="summary-card">

                <div class="summary-card-header">

                    <div class="summary-card-icon">
                        <i class="fa-solid fa-store"></i>
                    </div>

                    <div>

                        <h2 class="summary-card-title">
                            Business Details
                        </h2>

                        <div class="summary-card-subtitle">
                            Store and business information
                        </div>

                    </div>

                </div>


                <div class="detail-list">

                    <div class="detail-row">

                        <span class="detail-label">
                            Shop Name
                        </span>

                        <span class="detail-value">
                            {{ $seller->shop_name ?: 'Not provided' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Business Type
                        </span>

                        <span class="detail-value">
                            {{ $seller->business_type ?: 'Not provided' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            GST Number
                        </span>

                        <span class="detail-value">
                            {{ $seller->gst_number ?: 'Not provided' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Udyam
                        </span>

                        <span class="detail-value">
                            {{ $seller->udyam_number ?: 'Not provided' }}
                        </span>

                    </div>

                </div>

            </div>



            {{-- =================================================
                 KYC DETAILS
            ================================================== --}}

            <div class="summary-card">

                <div class="summary-card-header">

                    <div class="summary-card-icon">
                        <i class="fa-solid fa-id-card"></i>
                    </div>

                    <div>

                        <h2 class="summary-card-title">
                            KYC & Verification
                        </h2>

                        <div class="summary-card-subtitle">
                            Identity and shop verification
                        </div>

                    </div>

                </div>


                <div class="detail-list">

                    <div class="detail-row">

                        <span class="detail-label">
                            PAN
                        </span>

                        <span class="detail-value">

                            @if($seller->pan_number)

                                {{ substr($seller->pan_number, 0, 5) }}
                                ****
                                {{ substr($seller->pan_number, -1) }}

                            @else

                                Not provided

                            @endif

                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Aadhaar
                        </span>

                        <span class="detail-value">

                            @if($seller->aadhaar_verified_at)

                                <span class="status-line">
                                    Verified
                                </span>

                            @elseif($seller->aadhaar_document_path)

                                <span class="detail-value warning">
                                    Document Uploaded
                                </span>

                            @else

                                <span class="detail-value muted">
                                    Missing
                                </span>

                            @endif

                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Certificate
                        </span>

                        <span class="detail-value">

                            @if($seller->business_certificate_path)

                                <span class="document-status uploaded">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Uploaded
                                </span>

                            @else

                                <span class="document-status missing">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Missing
                                </span>

                            @endif

                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Shop Proof
                        </span>

                        <span class="detail-value">

                            @if($seller->shop_proof_path)

                                <span class="document-status uploaded">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Uploaded
                                </span>

                            @else

                                <span class="document-status missing">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Missing
                                </span>

                            @endif

                        </span>

                    </div>

                </div>

            </div>



            {{-- =================================================
                 BANK DETAILS
            ================================================== --}}

            <div class="summary-card">

                <div class="summary-card-header">

                    <div class="summary-card-icon">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>

                    <div>

                        <h2 class="summary-card-title">
                            Bank Details
                        </h2>

                        <div class="summary-card-subtitle">
                            Seller payment account
                        </div>

                    </div>

                </div>


                <div class="detail-list">

                    <div class="detail-row">

                        <span class="detail-label">
                            Account Holder
                        </span>

                        <span class="detail-value">
                            {{ $seller->bank_account_holder ?: 'Not provided' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Account
                        </span>

                        <span class="detail-value">

                            @if($seller->bank_account_number)

                                XXXX XXXX
                                {{ substr($seller->bank_account_number, -4) }}

                            @else

                                Not provided

                            @endif

                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            IFSC
                        </span>

                        <span class="detail-value">
                            {{ $seller->bank_ifsc ?: 'Not provided' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Bank
                        </span>

                        <span class="detail-value">
                            {{ $seller->bank_name ?: 'Not provided' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Bank Proof
                        </span>

                        <span class="detail-value">

                            @if($seller->bank_proof_path)

                                <span class="document-status uploaded">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Uploaded
                                </span>

                            @else

                                <span class="document-status missing">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Missing
                                </span>

                            @endif

                        </span>

                    </div>

                </div>

            </div>


        </div>


        {{-- =====================================================
             ACTION
        ====================================================== --}}

        <div class="summary-actions">

            <div class="action-info">

                <div class="action-icon">
                    <i class="fa-solid fa-file-signature"></i>
                </div>

                <div>

                    <div class="action-title">
                        Ready to review your application?
                    </div>

                    <div class="action-text">
                        Check every detail before continuing to the final review.
                    </div>

                </div>

            </div>


            <a
                href="{{ route('seller.verification.review') }}"
                class="review-btn"
            >

                Review Application

                <i class="fa-solid fa-arrow-right"></i>

            </a>

        </div>


        {{-- =====================================================
             FOOTER
        ====================================================== --}}

        <div class="summary-footer">

            <i class="fa-solid fa-shield-halved"></i>

            Your sensitive seller information is protected by SmartBasket.

        </div>

    </div>

</div>

@endsection