@extends('seller.partials.premium-layout')

@section('title', 'Application Summary | SmartBasket Premium')

@php
    $statusValue = $seller->verification_status ?: $seller->status ?: 'draft';

    $status = match ($statusValue) {
        'pending_admin_review',
        'pending_review',
        'under_review' => [
            'label' => 'UNDER REVIEW',
            'class' => 'status-review',
            'icon' => 'fa-clock'
        ],

        'approved',
        'active' => [
            'label' => 'APPROVED',
            'class' => 'status-approved',
            'icon' => 'fa-circle-check'
        ],

        'rejected' => [
            'label' => 'REJECTED',
            'class' => 'status-rejected',
            'icon' => 'fa-circle-xmark'
        ],

        default => [
            'label' => 'DRAFT',
            'class' => 'status-draft',
            'icon' => 'fa-file-pen'
        ],
    };

    $mask = function ($value) {
        if (!$value) {
            return 'Not provided';
        }

        $value = (string) $value;

        if (strlen($value) <= 4) {
            return str_repeat('*', strlen($value));
        }

        return str_repeat('*', strlen($value) - 4) . substr($value, -4);
    };

    $submittedAt = $seller->verification_submitted_at;

    $documentsUploaded =
        !empty($seller->business_certificate_path) &&
        !empty($seller->aadhaar_document_path);

    $businessComplete =
        !empty($seller->business_type) &&
        !empty($seller->pan_number) &&
        !empty($seller->udyam_number);

    $bankComplete =
        !empty($seller->bank_account_holder) &&
        !empty($seller->bank_account_number) &&
        !empty($seller->bank_ifsc) &&
        !empty($seller->bank_name);
@endphp


@section('content')

<style>

    /* =========================================================
       SMART BASKET — APPLICATION SUMMARY
       PREMIUM LIGHT / DARK THEME
    ========================================================= */

    .application-summary-page {

        width: 100%;

        max-width: 1180px;

        margin: 0 auto;

        padding: 22px 0 65px;

        color: var(
            --sb-text,
            #f8fafc
        );
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

        padding: 32px;

        border-radius: 25px;

        background:
            linear-gradient(
                135deg,
                rgba(0,217,139,.11),
                rgba(59,130,246,.055),
                rgba(255,255,255,.035)
            );

        border:
            1px solid var(
                --sb-border,
                rgba(255,255,255,.10)
            );

        box-shadow:
            0 25px 65px rgba(0,0,0,.16);

        backdrop-filter: blur(20px);
    }


    .summary-hero::before {

        content: "";

        position: absolute;

        width: 280px;

        height: 280px;

        top: -170px;

        right: -100px;

        border-radius: 50%;

        background: #00d98b;

        opacity: .06;

        filter: blur(40px);

        pointer-events: none;
    }


    .summary-hero-left {

        position: relative;

        z-index: 2;
    }


    .summary-eyebrow {

        color: #00d98b;

        font-size: 10px;

        font-weight: 800;

        letter-spacing: .15em;

        text-transform: uppercase;
    }


    .summary-title {

        margin: 8px 0 7px;

        color: var(
            --sb-text,
            #f8fafc
        );

        font-size: clamp(
            27px,
            4vw,
            40px
        );

        font-weight: 800;

        letter-spacing: -.7px;
    }


    .summary-title span {

        color: #00d98b;
    }


    .summary-description {

        margin: 0;

        max-width: 650px;

        color: var(
            --sb-muted,
            #8fa6a0
        );

        font-size: 12px;

        line-height: 1.7;
    }


    /* =========================================================
       STATUS
    ========================================================= */

    .summary-status {

        position: relative;

        z-index: 2;

        min-width: 190px;

        text-align: right;
    }


    .status-badge {

        display: inline-flex;

        align-items: center;

        gap: 8px;

        padding: 9px 14px;

        border-radius: 999px;

        font-size: 10px;

        font-weight: 800;

        letter-spacing: .07em;

        border: 1px solid currentColor;
    }


    .status-badge::before {

        content: "";

        width: 7px;

        height: 7px;

        border-radius: 50%;

        background: currentColor;

        box-shadow:
            0 0 10px currentColor;
    }


    .status-review {
        color: #f5cb72;
    }


    .status-approved {
        color: #00d98b;
    }


    .status-rejected {
        color: #ff8585;
    }


    .status-draft {
        color: #94a3b8;
    }


    .application-id {

        margin-top: 12px;

        color: var(
            --sb-muted,
            #8fa6a0
        );

        font-size: 10px;
    }


    .application-id strong {

        display: block;

        margin-top: 3px;

        color: var(
            --sb-text,
            #f8fafc
        );

        font-size: 12px;
    }


    /* =========================================================
       SUMMARY GRID
    ========================================================= */

    .summary-grid {

        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 16px;

        margin-top: 18px;
    }


    .summary-card {

        position: relative;

        overflow: hidden;

        padding: 23px;

        border-radius: 18px;

        background:
            var(
                --sb-card-bg,
                rgba(15,29,28,.80)
            );

        border:
            1px solid var(
                --sb-border,
                rgba(255,255,255,.09)
            );

        box-shadow:
            0 15px 45px rgba(0,0,0,.08);
    }


    .summary-card-header {

        display: flex;

        align-items: center;

        gap: 12px;

        padding-bottom: 17px;

        margin-bottom: 18px;

        border-bottom:
            1px solid var(
                --sb-border,
                rgba(255,255,255,.07)
            );
    }


    .summary-card-icon {

        width: 40px;

        height: 40px;

        flex: 0 0 40px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 12px;

        color: #00d98b;

        background:
            rgba(0,217,139,.09);

        border:
            1px solid rgba(0,217,139,.14);

        font-size: 14px;
    }


    .summary-card-title {

        margin: 0;

        color: var(
            --sb-text,
            #f8fafc
        );

        font-size: 14px;

        font-weight: 800;
    }


    .summary-card-subtitle {

        margin-top: 2px;

        color: var(
            --sb-muted,
            #8fa6a0
        );

        font-size: 9px;
    }


    /* =========================================================
       DETAILS
    ========================================================= */

    .detail-list {

        display: grid;

        gap: 14px;
    }


    .detail-row {

        display: flex;

        justify-content: space-between;

        align-items: flex-start;

        gap: 18px;
    }


    .detail-label {

        color: var(
            --sb-muted,
            #8fa6a0
        );

        font-size: 10px;

        font-weight: 600;

        text-transform: uppercase;

        letter-spacing: .07em;
    }


    .detail-value {

        max-width: 65%;

        color: var(
            --sb-text,
            #e8f0ee
        );

        font-size: 12px;

        font-weight: 600;

        line-height: 1.55;

        text-align: right;

        word-break: break-word;
    }


    .detail-value.success {

        color: #00d98b;
    }


    .detail-value.warning {

        color: #f5cb72;
    }


    .detail-value.danger {

        color: #ff8585;
    }


    /* =========================================================
       DOCUMENT STATUS
    ========================================================= */

    .document-status {

        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0,1fr)
            );

        gap: 10px;
    }


    .document-item {

        display: flex;

        align-items: center;

        gap: 10px;

        padding: 12px;

        border-radius: 12px;

        background:
            var(
                --sb-input-bg,
                rgba(255,255,255,.035)
            );

        border:
            1px solid var(
                --sb-border,
                rgba(255,255,255,.08)
            );
    }


    .document-icon {

        width: 32px;

        height: 32px;

        flex: 0 0 32px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 9px;

        font-size: 12px;
    }


    .document-icon.uploaded {

        color: #00d98b;

        background:
            rgba(0,217,139,.09);
    }


    .document-icon.pending {

        color: #f5cb72;

        background:
            rgba(245,203,114,.08);
    }


    .document-name {

        color: var(
            --sb-text,
            #e8f0ee
        );

        font-size: 10px;

        font-weight: 700;
    }


    .document-state {

        margin-top: 2px;

        color: var(
            --sb-muted,
            #8fa6a0
        );

        font-size: 9px;
    }


    /* =========================================================
       PROGRESS
    ========================================================= */

    .summary-progress {

        margin-top: 18px;

        padding: 23px;

        border-radius: 18px;

        background:
            var(
                --sb-card-bg,
                rgba(15,29,28,.80)
            );

        border:
            1px solid var(
                --sb-border,
                rgba(255,255,255,.09)
            );
    }


    .progress-header {

        display: flex;

        justify-content: space-between;

        align-items: center;

        margin-bottom: 14px;
    }


    .progress-title {

        color: var(
            --sb-text,
            #f8fafc
        );

        font-size: 13px;

        font-weight: 800;
    }


    .progress-percent {

        color: #00d98b;

        font-size: 11px;

        font-weight: 800;
    }


    .progress-track {

        width: 100%;

        height: 7px;

        overflow: hidden;

        border-radius: 999px;

        background:
            var(
                --sb-border,
                rgba(255,255,255,.08)
            );
    }


    .progress-fill {

        height: 100%;

        border-radius: inherit;

        background:
            linear-gradient(
                90deg,
                #00d98b,
                #63e6b3
            );

        box-shadow:
            0 0 18px rgba(0,217,139,.25);

        transition: width .4s ease;
    }


    /* =========================================================
       SUBMISSION
    ========================================================= */

    .submission-card {

        margin-top: 18px;

        padding: 22px;

        border-radius: 18px;

        background:
            linear-gradient(
                135deg,
                rgba(0,217,139,.07),
                rgba(255,255,255,.025)
            );

        border:
            1px solid rgba(0,217,139,.16);
    }


    .submission-row {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 20px;
    }


    .submission-left {

        display: flex;

        align-items: center;

        gap: 12px;
    }


    .submission-icon {

        width: 42px;

        height: 42px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 12px;

        color: #00d98b;

        background:
            rgba(0,217,139,.10);
    }


    .submission-title {

        color: var(
            --sb-text,
            #f8fafc
        );

        font-size: 12px;

        font-weight: 800;
    }


    .submission-text {

        margin-top: 2px;

        color: var(
            --sb-muted,
            #8fa6a0
        );

        font-size: 9px;
    }


    .submission-date {

        color: var(
            --sb-text,
            #e8f0ee
        );

        font-size: 10px;

        font-weight: 700;

        text-align: right;
    }


    /* =========================================================
       ACTIONS
    ========================================================= */

    .summary-actions {

        display: flex;

        justify-content: flex-end;

        gap: 10px;

        margin-top: 20px;
    }


    .summary-btn {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 8px;

        min-height: 46px;

        padding: 0 18px;

        border-radius: 12px;

        text-decoration: none;

        font-size: 11px;

        font-weight: 800;

        transition: .25s ease;
    }


    .summary-btn-back {

        color: var(
            --sb-muted,
            #8fa6a0
        );

        background:
            var(
                --sb-input-bg,
                rgba(255,255,255,.04)
            );

        border:
            1px solid var(
                --sb-border,
                rgba(255,255,255,.10)
            );
    }


    .summary-btn-back:hover {

        color: #00d98b;

        border-color:
            rgba(0,217,139,.30);

        transform:
            translateY(-2px);
    }


    /* =========================================================
       LIGHT MODE
    ========================================================= */

    html.light .summary-card,
    body.light .summary-card,
    html.light .summary-progress,
    body.light .summary-progress {

        --sb-card-bg: #ffffff;

        --sb-border: rgba(15,23,42,.09);

        --sb-text: #111827;

        --sb-muted: #64748b;

        --sb-input-bg: #f8fafc;

        box-shadow:
            0 12px 35px rgba(15,23,42,.06);
    }


    html.light .summary-hero,
    body.light .summary-hero {

        background:
            linear-gradient(
                135deg,
                #ffffff,
                #f0fdf9
            );

        border-color:
            rgba(15,23,42,.08);
    }


    html.light .document-item,
    body.light .document-item {

        background: #f8fafc;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media(max-width:800px) {

        .application-summary-page {
            padding:
                12px 0 50px;
        }

        .summary-hero {

            display: block;

            padding: 25px 20px;
        }

        .summary-status {

            margin-top: 22px;

            text-align: left;
        }

        .summary-grid {

            grid-template-columns: 1fr;
        }

    }


    @media(max-width:500px) {

        .summary-title {
            font-size: 26px;
        }

        .summary-card,
        .summary-progress {
            padding: 18px 16px;
        }

        .document-status {
            grid-template-columns: 1fr;
        }

        .detail-row {
            display: block;
        }

        .detail-value {

            max-width: 100%;

            margin-top: 4px;

            text-align: left;
        }

        .submission-row {

            align-items: flex-start;

            flex-direction: column;
        }

        .submission-date {

            text-align: left;
        }

        .summary-actions {
            justify-content: stretch;
        }

        .summary-btn {
            width: 100%;
        }

    }

</style>


<div class="application-summary-page">


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <header class="summary-hero">

        <div class="summary-hero-left">

            <div class="summary-eyebrow">
                Seller Verification & KYC
            </div>

            <h1 class="summary-title">
                Application <span>Summary</span>
            </h1>

            <p class="summary-description">
                Review the information SmartBasket has securely
                stored for your seller application.
                Sensitive information is masked for your protection.
            </p>

        </div>


        <div class="summary-status">

            <span class="status-badge {{ $status['class'] }}">

                {{ $status['label'] }}

            </span>


            @if(isset($applicationId))

                <div class="application-id">

                    Application ID

                    <strong>
                        {{ $applicationId }}
                    </strong>

                </div>

            @endif

        </div>

    </header>



    {{-- =====================================================
         DETAILS
    ====================================================== --}}

    <div class="summary-grid">


        {{-- PERSONAL DETAILS --}}

        <section class="summary-card">

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
                        Seller
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

                        @if($seller->city || $seller->state)

                            <br>

                            {{ collect([
                                $seller->city,
                                $seller->state,
                                $seller->pincode
                            ])->filter()->implode(', ') }}

                        @endif

                    </span>

                </div>

            </div>

        </section>



        {{-- BUSINESS DETAILS --}}

        <section class="summary-card">

            <div class="summary-card-header">

                <div class="summary-card-icon">
                    <i class="fa-solid fa-store"></i>
                </div>

                <div>

                    <h2 class="summary-card-title">
                        Business Details
                    </h2>

                    <div class="summary-card-subtitle">
                        Business & registration information
                    </div>

                </div>

            </div>


            <div class="detail-list">

                <div class="detail-row">

                    <span class="detail-label">
                        Shop
                    </span>

                    <span class="detail-value">
                        {{ $seller->shop_name ?: ($seller->business_name ?: 'Not provided') }}
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
                        GST
                    </span>

                    <span class="detail-value">
                        {{ $seller->gst_number ?: 'Not provided' }}
                    </span>

                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        PAN
                    </span>

                    <span class="detail-value">
                        {{ $seller->pan_number ? $mask($seller->pan_number) : 'Not provided' }}
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

        </section>



        {{-- KYC DETAILS --}}

        <section class="summary-card">

            <div class="summary-card-header">

                <div class="summary-card-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>

                <div>

                    <h2 class="summary-card-title">
                        KYC & Verification
                    </h2>

                    <div class="summary-card-subtitle">
                        Identity and document verification
                    </div>

                </div>

            </div>


            <div class="detail-list">

                <div class="detail-row">

                    <span class="detail-label">
                        Aadhaar
                    </span>

                    <span class="detail-value {{ $seller->aadhaar_verified_at ? 'success' : 'warning' }}">

                        @if($seller->aadhaar_verified_at)
                            ✓ Verified
                        @elseif($seller->aadhaar_document_path)
                            Document Uploaded
                        @else
                            Pending
                        @endif

                    </span>

                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        Aadhaar Number
                    </span>

                    <span class="detail-value">
                        {{ $seller->aadhaar_number ? $mask($seller->aadhaar_number) : 'Not provided' }}
                    </span>

                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        Business Certificate
                    </span>

                    <span class="detail-value {{ $seller->business_certificate_path ? 'success' : 'warning' }}">

                        {{ $seller->business_certificate_path ? '✓ Uploaded' : 'Pending' }}

                    </span>

                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        Shop Proof
                    </span>

                    <span class="detail-value {{ $seller->shop_proof_path ? 'success' : 'warning' }}">

                        {{ $seller->shop_proof_path ? '✓ Uploaded' : 'Not uploaded' }}

                    </span>

                </div>

            </div>

        </section>



        {{-- BANK DETAILS --}}

        <section class="summary-card">

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
                        Account Number
                    </span>

                    <span class="detail-value">
                        {{ $mask($seller->bank_account_number) }}
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

                    <span class="detail-value {{ $seller->bank_proof_path ? 'success' : 'warning' }}">
                        {{ $seller->bank_proof_path ? '✓ Uploaded' : 'Not uploaded' }}
                    </span>

                </div>

            </div>

        </section>

    </div>



    {{-- =====================================================
         DOCUMENTS
    ====================================================== --}}

    <section class="summary-card" style="margin-top:18px;">

        <div class="summary-card-header">

            <div class="summary-card-icon">
                <i class="fa-solid fa-folder-open"></i>
            </div>

            <div>

                <h2 class="summary-card-title">
                    Document Status
                </h2>

                <div class="summary-card-subtitle">
                    Uploaded verification documents
                </div>

            </div>

        </div>


        <div class="document-status">


            <div class="document-item">

                <div class="document-icon {{ $seller->business_certificate_path ? 'uploaded' : 'pending' }}">

                    <i class="fa-solid fa-file-certificate"></i>

                </div>

                <div>

                    <div class="document-name">
                        Business Certificate
                    </div>

                    <div class="document-state">

                        {{ $seller->business_certificate_path
                            ? '✓ Uploaded'
                            : 'Pending' }}

                    </div>

                </div>

            </div>


            <div class="document-item">

                <div class="document-icon {{ $seller->aadhaar_document_path ? 'uploaded' : 'pending' }}">

                    <i class="fa-solid fa-id-card"></i>

                </div>

                <div>

                    <div class="document-name">
                        Aadhaar Document
                    </div>

                    <div class="document-state">

                        {{ $seller->aadhaar_document_path
                            ? '✓ Uploaded'
                            : 'Pending' }}

                    </div>

                </div>

            </div>


            <div class="document-item">

                <div class="document-icon {{ $seller->shop_proof_path ? 'uploaded' : 'pending' }}">

                    <i class="fa-solid fa-shop"></i>

                </div>

                <div>

                    <div class="document-name">
                        Shop Proof
                    </div>

                    <div class="document-state">

                        {{ $seller->shop_proof_path
                            ? '✓ Uploaded'
                            : 'Not uploaded' }}

                    </div>

                </div>

            </div>


            <div class="document-item">

                <div class="document-icon {{ $seller->bank_proof_path ? 'uploaded' : 'pending' }}">

                    <i class="fa-solid fa-building-columns"></i>

                </div>

                <div>

                    <div class="document-name">
                        Bank Proof
                    </div>

                    <div class="document-state">

                        {{ $seller->bank_proof_path
                            ? '✓ Uploaded'
                            : 'Not uploaded' }}

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- =====================================================
         COMPLETION PROGRESS
    ====================================================== --}}

    <section class="summary-progress">

        @php
            $completed = collect([
                !empty($seller->email_verified_at),
                $documentsUploaded,
                !empty($seller->aadhaar_verified_at),
                $businessComplete,
                $bankComplete,
                !empty($submittedAt),
            ])->filter()->count();

            $percentage = round(($completed / 6) * 100);
        @endphp


        <div class="progress-header">

            <span class="progress-title">
                Application Completion
            </span>

            <span class="progress-percent">
                {{ $percentage }}%
            </span>

        </div>


        <div class="progress-track">

            <div
                class="progress-fill"
                style="width: {{ $percentage }}%;"
            ></div>

        </div>

    </section>



    {{-- =====================================================
         SUBMISSION STATUS
    ====================================================== --}}

    <section class="submission-card">

        <div class="submission-row">

            <div class="submission-left">

                <div class="submission-icon">

                    <i class="fa-solid fa-paper-plane"></i>

                </div>

                <div>

                    <div class="submission-title">
                        Application Submission
                    </div>

                    <div class="submission-text">

                        @if($submittedAt)

                            Your seller application has been submitted
                            successfully for review.

                        @else

                            Your application has not been submitted yet.

                        @endif

                    </div>

                </div>

            </div>


            <div class="submission-date">

                @if($submittedAt)

                    {{ $submittedAt->format('d M Y, h:i A') }}

                @else

                    Not submitted

                @endif

            </div>

        </div>

    </section>



    {{-- =====================================================
         ACTION
    ====================================================== --}}

    <div class="summary-actions">

        <a
            href="{{ route('seller.verification.review') }}"
            class="summary-btn summary-btn-back"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Review Application

        </a>

    </div>

</div>

@endsection