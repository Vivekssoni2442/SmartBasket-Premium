<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Seller Verification Status | SmartBasket Premium
    </title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>

        /* =========================================================
           SMART BASKET — SELLER VERIFICATION STATUS
           PREMIUM LIGHT UI
        ========================================================= */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {

            --green: #00a968;
            --green-dark: #008f58;
            --green-light: #00c978;

            --blue: #2563eb;
            --blue-light: #3b82f6;

            --orange: #d97706;
            --red: #dc2626;

            --text: #172033;
            --text-dark: #111827;
            --muted: #64748b;
            --muted-light: #94a3b8;

            --border: #e1e8ef;
            --border-soft: #edf1f5;

            --card: #ffffff;
            --card-soft: #f8fafc;

            --page:
                linear-gradient(
                    135deg,
                    #f8fafc 0%,
                    #f4f7fb 48%,
                    #eef3f8 100%
                );
        }


        /* =========================================================
           BODY
        ========================================================= */

        body {

            min-height: 100vh;

            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Arial,
                sans-serif;

            background:
                radial-gradient(
                    circle at 5% 0%,
                    rgba(0, 201, 120, .08),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 95% 5%,
                    rgba(59, 130, 246, .07),
                    transparent 28%
                ),
                var(--page);

            color: var(--text);

            padding:
                0 18px 55px;
        }


        /* =========================================================
           COMMON SELLER TOPBAR
        ========================================================= */

        .seller-status-page {

            width: 100%;

            display: flex;

            justify-content: center;
        }


        /* =========================================================
           PAGE CONTAINER
        ========================================================= */

        .container {

            width:
                min(920px, 100%);

            margin:
                34px auto 0;
        }


        /* =========================================================
           BRAND
        ========================================================= */

        .brand {

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 9px;

            margin-bottom: 27px;
        }

        .brand-mark {

            width: 38px;
            height: 38px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    #00a968,
                    #00d98a
                );

            color: #ffffff;

            box-shadow:
                0 9px 22px
                rgba(0, 169, 104, .18);
        }

        .brand h1 {

            color: #111827;

            font-size: 25px;

            line-height: 1;

            font-weight: 900;

            letter-spacing: .5px;
        }

        .brand span {

            color: var(--green);

            font-weight: 900;
        }


        /* =========================================================
           MAIN CARD
        ========================================================= */

        .card {

            position: relative;

            overflow: hidden;

            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.98),
                    rgba(248,250,252,.96)
                );

            border:
                1px solid var(--border);

            border-radius: 26px;

            padding: 34px;

            box-shadow:
                0 25px 70px
                rgba(15, 23, 42, .09),

                0 5px 18px
                rgba(15, 23, 42, .035),

                inset 0 1px 0
                rgba(255,255,255,.95);
        }

        .card::before {

            content: "";

            position: absolute;

            width: 230px;
            height: 230px;

            right: -110px;
            top: -110px;

            border-radius: 50%;

            background: var(--green);

            opacity: .045;

            filter: blur(35px);

            pointer-events: none;
        }


        /* =========================================================
           ALERTS
        ========================================================= */

        .alert {

            position: relative;

            display: flex;

            align-items: center;

            gap: 10px;

            padding:
                13px 15px;

            border-radius: 13px;

            margin-bottom: 18px;

            font-size: 12px;

            font-weight: 700;
        }

        .alert.success {

            background:
                rgba(34,197,94,.07);

            border:
                1px solid rgba(34,197,94,.20);

            color: #15803d;
        }

        .alert.error {

            background:
                rgba(239,68,68,.07);

            border:
                1px solid rgba(239,68,68,.20);

            color: #dc2626;
        }


        /* =========================================================
           TITLE
        ========================================================= */

        .title {

            position: relative;

            text-align: center;

            margin-bottom: 27px;
        }

        .title-icon {

            width: 56px;
            height: 56px;

            display: flex;

            align-items: center;
            justify-content: center;

            margin:
                0 auto 14px;

            border-radius: 17px;

            background:
                rgba(0,169,104,.065);

            border:
                1px solid rgba(0,169,104,.14);

            color: var(--green);

            font-size: 22px;

            box-shadow:
                0 10px 25px
                rgba(0,169,104,.07);
        }

        .title h2 {

            color: var(--text-dark);

            font-size: 28px;

            line-height: 1.2;

            font-weight: 850;

            letter-spacing: -.6px;

            margin-bottom: 7px;
        }

        .title p {

            color: var(--muted);

            font-size: 12px;

            line-height: 1.5;
        }


        /* =========================================================
           SELLER INFORMATION
        ========================================================= */

        .seller-info {

            position: relative;

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 12px;

            margin:
                0 0 23px;
        }

        .info {

            min-width: 0;

            padding:
                15px 16px;

            border:
                1px solid var(--border);

            border-radius: 15px;

            background:
                rgba(255,255,255,.78);

            box-shadow:
                0 7px 18px
                rgba(15,23,42,.035);
        }

        .info small {

            display: block;

            color: var(--muted-light);

            font-size: 9px;

            font-weight: 750;

            text-transform: uppercase;

            letter-spacing: .08em;

            margin-bottom: 6px;
        }

        .info strong {

            display: block;

            overflow: hidden;

            color: var(--text);

            font-size: 12px;

            font-weight: 800;

            white-space: nowrap;

            text-overflow: ellipsis;

            word-break: break-word;
        }


        /* =========================================================
           STATUS
        ========================================================= */

        .status {

            position: relative;

            text-align: center;

            padding:
                25px 20px;

            border-radius: 19px;

            margin-bottom: 27px;
        }

        .status.pending {

            background:
                rgba(245,158,11,.065);

            border:
                1px solid rgba(245,158,11,.20);
        }

        .status.approved {

            background:
                rgba(34,197,94,.065);

            border:
                1px solid rgba(34,197,94,.20);
        }

        .status.rejected,
        .status.suspended {

            background:
                rgba(239,68,68,.065);

            border:
                1px solid rgba(239,68,68,.20);
        }

        .status-icon {

            width: 55px;
            height: 55px;

            display: flex;

            align-items: center;
            justify-content: center;

            margin:
                0 auto 11px;

            border-radius: 50%;

            background: #ffffff;

            box-shadow:
                0 8px 22px
                rgba(15,23,42,.07);

            font-size: 24px;
        }

        .status h3 {

            color: var(--text-dark);

            font-size: 20px;

            font-weight: 850;

            margin-bottom: 6px;
        }

        .status p {

            max-width: 650px;

            margin:
                0 auto;

            color: var(--muted);

            font-size: 11px;

            line-height: 1.65;
        }


        /* =========================================================
           PROGRESS HEADER
        ========================================================= */

        .steps {

            position: relative;

            margin-top: 4px;
        }

        .steps-header {

            display: flex;

            align-items: flex-end;

            justify-content: space-between;

            gap: 15px;

            margin-bottom: 15px;
        }

        .steps h3 {

            color: var(--text-dark);

            font-size: 17px;

            font-weight: 850;
        }

        .steps-count {

            color: var(--muted-light);

            font-size: 10px;

            font-weight: 800;
        }


        /* =========================================================
           PROGRESS BAR
        ========================================================= */

        .progress-track {

            width: 100%;

            height: 7px;

            margin-bottom: 19px;

            overflow: hidden;

            border-radius: 999px;

            background: #e8eef3;
        }

        .progress-fill {

            height: 100%;

            border-radius: inherit;

            background:
                linear-gradient(
                    90deg,
                    #00a968,
                    #00d98a
                );

            box-shadow:
                0 0 14px
                rgba(0,201,120,.18);

            transition:
                width .35s ease;
        }


        /* =========================================================
           STEP
        ========================================================= */

        .step {

            position: relative;

            display: flex;

            align-items: center;

            gap: 14px;

            min-height: 66px;

            padding:
                11px 13px;

            margin-bottom: 9px;

            border:
                1px solid var(--border);

            border-radius: 15px;

            background:
                rgba(255,255,255,.80);

            box-shadow:
                0 5px 16px
                rgba(15,23,42,.025);

            transition:
                transform .22s ease,
                border-color .22s ease,
                box-shadow .22s ease;
        }

        .step:hover {

            transform:
                translateX(2px);

            border-color:
                rgba(0,169,104,.20);

            box-shadow:
                0 9px 22px
                rgba(15,23,42,.055);
        }


        /* =========================================================
           CIRCLE
        ========================================================= */

        .circle {

            width: 38px;
            height: 38px;

            min-width: 38px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background:
                #edf2f6;

            color:
                #94a3b8;

            border:
                1px solid #e0e7ed;

            font-size: 12px;

            font-weight: 850;
        }

        .circle.done {

            background:
                linear-gradient(
                    135deg,
                    #00b875,
                    #00d98a
                );

            color: #ffffff;

            border-color:
                transparent;

            box-shadow:
                0 7px 17px
                rgba(0,201,120,.16);
        }

        .circle.current {

            background:
                rgba(59,130,246,.09);

            color:
                #2563eb;

            border:
                1px solid
                rgba(59,130,246,.20);

            box-shadow:
                0 0 0 5px
                rgba(59,130,246,.07);
        }


        /* =========================================================
           STEP TEXT
        ========================================================= */

        .step-text {

            flex: 1;

            min-width: 0;
        }

        .step-text strong {

            display: block;

            color: var(--text);

            font-size: 11px;

            font-weight: 800;

            margin-bottom: 4px;
        }

        .step-text small {

            display: block;

            color: var(--muted-light);

            font-size: 9px;

            font-weight: 650;
        }


        /* =========================================================
           STEP LINK
        ========================================================= */

        .step-link {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            min-height: 32px;

            padding:
                0 11px;

            border-radius: 9px;

            background:
                rgba(0,169,104,.06);

            border:
                1px solid
                rgba(0,169,104,.14);

            color:
                var(--green);

            text-decoration: none;

            font-size: 9px;

            font-weight: 850;

            transition:
                .2s ease;
        }

        .step-link:hover {

            background:
                var(--green);

            border-color:
                var(--green);

            color: #ffffff;

            transform:
                translateY(-1px);
        }


        /* =========================================================
           NOTE
        ========================================================= */

        .note {

            position: relative;

            margin-top: 20px;

            padding:
                15px 17px;

            border-radius: 14px;

            background:
                rgba(59,130,246,.055);

            border:
                1px solid
                rgba(59,130,246,.15);

            color:
                #475569;

            font-size: 10px;

            line-height: 1.7;

            text-align: center;
        }


        /* =========================================================
           ACTIONS
        ========================================================= */

        .actions {

            display: flex;

            flex-wrap: wrap;

            justify-content: center;

            gap: 10px;

            margin-top: 25px;
        }

        .btn {

            min-height: 43px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 8px;

            padding:
                0 18px;

            border-radius: 11px;

            text-decoration: none;

            font-size: 10px;

            font-weight: 850;

            cursor: pointer;

            transition:
                transform .22s ease,
                box-shadow .22s ease,
                filter .22s ease;
        }

        .btn:hover {

            transform:
                translateY(-2px);
        }

        .btn-primary {

            background:
                linear-gradient(
                    135deg,
                    #00b875,
                    #00d98a
                );

            color: #ffffff;

            box-shadow:
                0 9px 22px
                rgba(0,201,120,.16);
        }

        .btn-primary:hover {

            color: #ffffff;

            box-shadow:
                0 13px 28px
                rgba(0,201,120,.22);

            filter:
                brightness(1.02);
        }

        .btn-success {

            background:
                linear-gradient(
                    135deg,
                    #16a34a,
                    #22c55e
                );

            color: #ffffff;

            box-shadow:
                0 9px 22px
                rgba(34,197,94,.16);
        }

        .btn-success:hover {

            color: #ffffff;

            box-shadow:
                0 13px 28px
                rgba(34,197,94,.22);
        }

        .btn-secondary {

            background:
                #ffffff;

            color:
                var(--text);

            border:
                1px solid var(--border);

            box-shadow:
                0 7px 18px
                rgba(15,23,42,.05);
        }

        .btn-secondary:hover {

            border-color:
                rgba(0,169,104,.25);

            color:
                var(--green);
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .page-footer {

            margin-top: 18px;

            text-align: center;

            color:
                #94a3b8;

            font-size: 9px;
        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 650px) {

            body {

                padding:
                    0 12px 35px;
            }

            .container {

                margin-top: 20px;
            }

            .brand {

                margin-bottom: 20px;
            }

            .brand h1 {

                font-size: 21px;
            }

            .brand-mark {

                width: 34px;
                height: 34px;

                border-radius: 10px;
            }

            .card {

                padding:
                    21px 15px;

                border-radius: 21px;
            }

            .title h2 {

                font-size: 22px;
            }

            .title p {

                font-size: 10px;
            }

            .seller-info {

                grid-template-columns: 1fr;

                gap: 9px;
            }

            .info {

                padding:
                    13px 14px;
            }

            .status {

                padding:
                    21px 14px;
            }

            .status h3 {

                font-size: 17px;
            }

            .step {

                gap: 10px;

                min-height: 62px;

                padding:
                    10px;
            }

            .circle {

                width: 34px;
                height: 34px;

                min-width: 34px;
            }

            .step-text strong {

                font-size: 10px;
            }

            .step-text small {

                font-size: 8px;
            }

            .step-link {

                min-height: 29px;

                padding:
                    0 8px;

                font-size: 8px;
            }

            .actions {

                flex-direction: column;
            }

            .btn {

                width: 100%;
            }
        }


        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {

                transition: none !important;
            }
        }

    </style>

</head>


<body>


{{-- =========================================================
     COMMON SELLER TOP TASKBAR
     ========================================================== --}}

@include('seller.partials.topbar')


<div class="seller-status-page">

    <div class="container">


        @php

            /*
            |--------------------------------------------------------------------------
            | BASIC VALUES
            |--------------------------------------------------------------------------
            */

            $status =
                $seller->verification_status
                ?? \App\Models\SellerProfile::STATUS_PENDING_EMAIL;


            /*
            |--------------------------------------------------------------------------
            | STEP 1 — EMAIL
            |--------------------------------------------------------------------------
            */

            $emailDone =
                !empty($seller->email_verified_at);


            /*
            |--------------------------------------------------------------------------
            | STEP 2 — DOCUMENTS
            |--------------------------------------------------------------------------
            */

            $documentsDone =
                !empty($seller->business_certificate_path)
                &&
                !empty($seller->aadhaar_document_path);


            /*
            |--------------------------------------------------------------------------
            | STEP 3 — AADHAAR
            |--------------------------------------------------------------------------
            */

            $aadhaarDone =
                !empty($seller->aadhaar_verified_at);


            /*
            |--------------------------------------------------------------------------
            | STEP 4 — BUSINESS DETAILS
            |--------------------------------------------------------------------------
            */

            $businessDone =
                !empty($seller->business_type)
                &&
                !empty($seller->pan_number)
                &&
                !empty($seller->udyam_number);


            /*
            |--------------------------------------------------------------------------
            | STEP 5 — BANK DETAILS
            |--------------------------------------------------------------------------
            */

            $bankDone =
                !empty($seller->bank_account_holder)
                &&
                !empty($seller->bank_account_number)
                &&
                !empty($seller->bank_ifsc)
                &&
                !empty($seller->bank_name);


            /*
            |--------------------------------------------------------------------------
            | STEP 6 — REVIEW / SUBMIT
            |--------------------------------------------------------------------------
            */

            $reviewDone =
                in_array(
                    $status,
                    [
                        \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW,
                        \App\Models\SellerProfile::STATUS_PENDING_REVIEW,
                        \App\Models\SellerProfile::STATUS_APPROVED,
                        \App\Models\SellerProfile::STATUS_ACTIVE,
                    ],
                    true
                );


            /*
            |--------------------------------------------------------------------------
            | APPROVAL
            |--------------------------------------------------------------------------
            */

            $applicationApproved =
                in_array(
                    $status,
                    [
                        \App\Models\SellerProfile::STATUS_APPROVED,
                        \App\Models\SellerProfile::STATUS_ACTIVE,
                    ],
                    true
                );


            /*
            |--------------------------------------------------------------------------
            | CURRENT STEP — 1 TO 6 ONLY
            |--------------------------------------------------------------------------
            */

            if (!$emailDone) {

                $currentStep = 1;

            } elseif (!$documentsDone) {

                $currentStep = 2;

            } elseif (!$aadhaarDone) {

                $currentStep = 3;

            } elseif (!$businessDone) {

                $currentStep = 4;

            } elseif (!$bankDone) {

                $currentStep = 5;

            } elseif (!$reviewDone) {

                $currentStep = 6;

            } else {

                $currentStep = 6;
            }


            /*
            |--------------------------------------------------------------------------
            | PROGRESS %
            |--------------------------------------------------------------------------
            */

            $completedSteps = 0;

            if ($emailDone) {
                $completedSteps++;
            }

            if ($documentsDone) {
                $completedSteps++;
            }

            if ($aadhaarDone) {
                $completedSteps++;
            }

            if ($businessDone) {
                $completedSteps++;
            }

            if ($bankDone) {
                $completedSteps++;
            }

            if ($reviewDone) {
                $completedSteps++;
            }

            $progressPercent =
                round(
                    ($completedSteps / 6) * 100
                );


            /*
            |--------------------------------------------------------------------------
            | STATUS MESSAGE
            |--------------------------------------------------------------------------
            */

            $statusMap = [

                \App\Models\SellerProfile::STATUS_PENDING_EMAIL => [
                    'class' => 'pending',
                    'icon' => 'fa-envelope',
                    'title' => 'Email Verification Pending',
                    'message' =>
                        'Please verify your registered seller email to continue.'
                ],

                \App\Models\SellerProfile::STATUS_EMAIL_VERIFICATION => [
                    'class' => 'pending',
                    'icon' => 'fa-envelope-circle-check',
                    'title' => 'Email Verification Pending',
                    'message' =>
                        'Please complete your email verification to continue.'
                ],

                \App\Models\SellerProfile::STATUS_DOCUMENTS_PENDING => [
                    'class' => 'pending',
                    'icon' => 'fa-file-circle-check',
                    'title' => 'Documents Required',
                    'message' =>
                        'Your email has been verified. Please upload all required seller documents.'
                ],

                \App\Models\SellerProfile::STATUS_AADHAAR_VERIFICATION => [
                    'class' => 'pending',
                    'icon' => 'fa-id-card',
                    'title' => 'Aadhaar Verification Pending',
                    'message' =>
                        'Your documents are available. Please complete Aadhaar verification.'
                ],

                \App\Models\SellerProfile::STATUS_BUSINESS_DETAILS => [
                    'class' => 'pending',
                    'icon' => 'fa-building',
                    'title' => 'Business Details Pending',
                    'message' =>
                        'Please complete your business information to continue.'
                ],

                \App\Models\SellerProfile::STATUS_BANK_DETAILS => [
                    'class' => 'pending',
                    'icon' => 'fa-building-columns',
                    'title' => 'Bank Details Pending',
                    'message' =>
                        'Please complete your bank information before submitting the application.'
                ],

                \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW => [
                    'class' => 'pending',
                    'icon' => 'fa-hourglass-half',
                    'title' => 'Application Under Review',
                    'message' =>
                        'Your complete seller application has been submitted and is waiting for admin approval.'
                ],

                \App\Models\SellerProfile::STATUS_PENDING_REVIEW => [
                    'class' => 'pending',
                    'icon' => 'fa-hourglass-half',
                    'title' => 'Application Under Review',
                    'message' =>
                        'Your seller application is currently being reviewed by the SmartBasket admin team.'
                ],

                \App\Models\SellerProfile::STATUS_APPROVED => [
                    'class' => 'approved',
                    'icon' => 'fa-circle-check',
                    'title' => 'Application Approved',
                    'message' =>
                        'Congratulations! Your seller application has been approved.'
                ],

                \App\Models\SellerProfile::STATUS_ACTIVE => [
                    'class' => 'approved',
                    'icon' => 'fa-circle-check',
                    'title' => 'Seller Account Active',
                    'message' =>
                        'Your seller account is fully verified and active.'
                ],

                \App\Models\SellerProfile::STATUS_REJECTED => [
                    'class' => 'rejected',
                    'icon' => 'fa-circle-xmark',
                    'title' => 'Application Rejected',
                    'message' =>
                        !empty($seller->rejection_reason)
                            ? 'Reason: '.$seller->rejection_reason
                            : 'Your seller application was rejected.'
                ],

                'suspended' => [
                    'class' => 'suspended',
                    'icon' => 'fa-triangle-exclamation',
                    'title' => 'Seller Account Suspended',
                    'message' =>
                        'Your seller account is currently suspended.'
                ],

            ];


            $currentStatus =
                $statusMap[$status]
                ?? [
                    'class' => 'pending',
                    'icon' => 'fa-shield-halved',
                    'title' => 'Verification Status',
                    'message' =>
                        'Your seller verification is currently being processed.'
                ];

        @endphp


        {{-- =========================================================
             BRAND
        ========================================================== --}}

        <div class="brand">

            <div class="brand-mark">

                <i class="fa-solid fa-store"></i>

            </div>

            <h1>
                SMART BASKET
                <span>PREMIUM</span>
            </h1>

        </div>


        {{-- =========================================================
             MAIN CARD
        ========================================================== --}}

        <div class="card">


            {{-- =====================================================
                 SUCCESS
            ====================================================== --}}

            @if(session('success'))

                <div class="alert success">

                    <i class="fa-solid fa-circle-check"></i>

                    {{ session('success') }}

                </div>

            @endif


            {{-- =====================================================
                 ERROR
            ====================================================== --}}

            @if(session('error'))

                <div class="alert error">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    {{ session('error') }}

                </div>

            @endif


            {{-- =====================================================
                 TITLE
            ====================================================== --}}

            <div class="title">

                <div class="title-icon">

                    <i class="fa-solid fa-shield-halved"></i>

                </div>

                <h2>
                    Seller Verification Status
                </h2>

                <p>
                    Your complete seller onboarding progress is shown below.
                </p>

            </div>


            {{-- =====================================================
                 SELLER INFORMATION
            ====================================================== --}}

            <div class="seller-info">


                <div class="info">

                    <small>
                        Seller Name
                    </small>

                    <strong>
                        {{ $seller->seller_name ?? 'Seller' }}
                    </strong>

                </div>


                <div class="info">

                    <small>
                        Email
                    </small>

                    <strong>
                        {{ $seller->email ?? '-' }}
                    </strong>

                </div>


                <div class="info">

                    <small>
                        Application ID
                    </small>

                    <strong>
                        #{{ $seller->id }}
                    </strong>

                </div>


                <div class="info">

                    <small>
                        Current Progress
                    </small>

                    <strong>
                        {{ $completedSteps }} / 6 Completed
                    </strong>

                </div>


            </div>


            {{-- =====================================================
                 CURRENT STATUS
            ====================================================== --}}

            <div class="status {{ $currentStatus['class'] }}">


                <div class="status-icon">

                    <i class="fa-solid {{ $currentStatus['icon'] }}"></i>

                </div>


                <h3>
                    {{ $currentStatus['title'] }}
                </h3>


                <p>
                    {{ $currentStatus['message'] }}
                </p>


            </div>


            {{-- =====================================================
                 VERIFICATION PROGRESS
            ====================================================== --}}

            <div class="steps">


                <div class="steps-header">

                    <h3>
                        Verification Progress
                    </h3>

                    <div class="steps-count">

                        Step {{ $currentStep }} of 6

                    </div>

                </div>


                {{-- PROGRESS BAR --}}

                <div class="progress-track">

                    <div
                        class="progress-fill"
                        style="width: {{ $progressPercent }}%;"
                    ></div>

                </div>


                {{-- =================================================
                     STEP 1
                ================================================== --}}

                <div class="step">

                    <div class="circle
                        {{ $emailDone
                            ? 'done'
                            : ($currentStep === 1 ? 'current' : '') }}">

                        @if($emailDone)

                            <i class="fa-solid fa-check"></i>

                        @else

                            1

                        @endif

                    </div>


                    <div class="step-text">

                        <strong>
                            Step 1 — Email Verification
                        </strong>

                        <small>
                            {{ $emailDone ? 'Completed' : 'Pending' }}
                        </small>

                    </div>


                    @if(!$emailDone)

                        <a
                            href="{{ route('seller.verification.email') }}"
                            class="step-link"
                        >
                            Open
                        </a>

                    @endif

                </div>


                {{-- =================================================
                     STEP 2
                ================================================== --}}

                <div class="step">

                    <div class="circle
                        {{ $documentsDone
                            ? 'done'
                            : ($currentStep === 2 ? 'current' : '') }}">

                        @if($documentsDone)

                            <i class="fa-solid fa-check"></i>

                        @else

                            2

                        @endif

                    </div>


                    <div class="step-text">

                        <strong>
                            Step 2 — Documents
                        </strong>

                        <small>
                            {{ $documentsDone ? 'Completed' : 'Pending' }}
                        </small>

                    </div>


                    @if($emailDone && !$documentsDone)

                        <a
                            href="{{ route('seller.verification.documents') }}"
                            class="step-link"
                        >
                            Open
                        </a>

                    @endif

                </div>


                {{-- =================================================
                     STEP 3
                ================================================== --}}

                <div class="step">

                    <div class="circle
                        {{ $aadhaarDone
                            ? 'done'
                            : ($currentStep === 3 ? 'current' : '') }}">

                        @if($aadhaarDone)

                            <i class="fa-solid fa-check"></i>

                        @else

                            3

                        @endif

                    </div>


                    <div class="step-text">

                        <strong>
                            Step 3 — Aadhaar Verification
                        </strong>

                        <small>
                            {{ $aadhaarDone ? 'Completed' : 'Pending' }}
                        </small>

                    </div>


                    @if($documentsDone && !$aadhaarDone)

                        <a
                            href="{{ route('seller.verification.aadhaar') }}"
                            class="step-link"
                        >
                            Open
                        </a>

                    @endif

                </div>


                {{-- =================================================
                     STEP 4
                ================================================== --}}

                <div class="step">

                    <div class="circle
                        {{ $businessDone
                            ? 'done'
                            : ($currentStep === 4 ? 'current' : '') }}">

                        @if($businessDone)

                            <i class="fa-solid fa-check"></i>

                        @else

                            4

                        @endif

                    </div>


                    <div class="step-text">

                        <strong>
                            Step 4 — Business Details
                        </strong>

                        <small>
                            {{ $businessDone ? 'Completed' : 'Pending' }}
                        </small>

                    </div>


                    @if($aadhaarDone && !$businessDone)

                        <a
                            href="{{ route('seller.verification.business-details') }}"
                            class="step-link"
                        >
                            Open
                        </a>

                    @endif

                </div>


                {{-- =================================================
                     STEP 5
                ================================================== --}}

                <div class="step">

                    <div class="circle
                        {{ $bankDone
                            ? 'done'
                            : ($currentStep === 5 ? 'current' : '') }}">

                        @if($bankDone)

                            <i class="fa-solid fa-check"></i>

                        @else

                            5

                        @endif

                    </div>


                    <div class="step-text">

                        <strong>
                            Step 5 — Bank Details
                        </strong>

                        <small>
                            {{ $bankDone ? 'Completed' : 'Pending' }}
                        </small>

                    </div>


                    @if($businessDone && !$bankDone)

                        <a
                            href="{{ route('seller.verification.bank-details') }}"
                            class="step-link"
                        >
                            Open
                        </a>

                    @endif

                </div>


                {{-- =================================================
                     STEP 6
                ================================================== --}}

                <div class="step">

                    <div class="circle
                        {{ $reviewDone
                            ? 'done'
                            : ($currentStep === 6 ? 'current' : '') }}">

                        @if($reviewDone)

                            <i class="fa-solid fa-check"></i>

                        @else

                            6

                        @endif

                    </div>


                    <div class="step-text">

                        <strong>
                            Step 6 — Review &amp; Submit
                        </strong>

                        <small>
                            {{ $reviewDone
                                ? 'Application Submitted'
                                : 'Ready for Review' }}
                        </small>

                    </div>


                    @if($bankDone && !$reviewDone)

                        <a
                            href="{{ route('seller.verification.review') }}"
                            class="step-link"
                        >
                            Open
                        </a>

                    @endif

                </div>


            </div>


            {{-- =====================================================
                 INFORMATION NOTE
            ====================================================== --}}

            @if($status === \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW)

                <div class="note">

                    <i class="fa-solid fa-hourglass-half"></i>

                    Your application has been submitted successfully.
                    Please wait while the SmartBasket admin team reviews your
                    documents and seller information.

                </div>


            @elseif(
                $status === \App\Models\SellerProfile::STATUS_PENDING_REVIEW
            )

                <div class="note">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    Your seller application is currently under review.
                    We will update your verification status after the review.

                </div>


            @elseif(
                $status === \App\Models\SellerProfile::STATUS_APPROVED
                ||
                $status === \App\Models\SellerProfile::STATUS_ACTIVE
            )

                <div class="note">

                    <i class="fa-solid fa-circle-check"></i>

                    Your seller application has been approved.
                    Your SmartBasket seller account is ready.

                </div>


            @elseif($status === \App\Models\SellerProfile::STATUS_REJECTED)

                <div class="note">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    Please review the rejection reason and update your
                    application if resubmission is allowed.

                </div>

            @endif


            {{-- =====================================================
                 ACTION BUTTONS
            ====================================================== --}}

            <div class="actions">


                @if(!$reviewDone)

                    <a
                        href="{{ route('seller.verification.index') }}"
                        class="btn btn-primary"
                    >

                        <i class="fa-solid fa-arrow-right"></i>

                        Continue Verification

                    </a>


                @elseif(
                    $status === \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW
                    ||
                    $status === \App\Models\SellerProfile::STATUS_PENDING_REVIEW
                )

                    <a
                        href="{{ route('seller.verification.application.summary') }}"
                        class="btn btn-primary"
                    >

                        <i class="fa-solid fa-file-lines"></i>

                        View Complete Application

                    </a>


                @elseif(
                    $status === \App\Models\SellerProfile::STATUS_APPROVED
                )

                    <a
                        href="{{ route('seller.verification.application.summary') }}"
                        class="btn btn-success"
                    >

                        <i class="fa-solid fa-circle-check"></i>

                        View Approved Application

                    </a>


                @elseif(
                    $status === \App\Models\SellerProfile::STATUS_ACTIVE
                )

                    <a
                        href="{{ route('seller.dashboard') }}"
                        class="btn btn-success"
                    >

                        <i class="fa-solid fa-store"></i>

                        Go To Seller Dashboard

                    </a>


                @elseif(
                    $status === \App\Models\SellerProfile::STATUS_REJECTED
                )

                    <a
                        href="{{ route('seller.verification.index') }}"
                        class="btn btn-primary"
                    >

                        <i class="fa-solid fa-rotate-right"></i>

                        Update Application

                    </a>


                @endif


            </div>


        </div>


        <div class="page-footer">

            SMART BASKET PREMIUM
            &nbsp;•&nbsp;
            Seller Verification Center

        </div>


    </div>

</div>


</body>

</html>