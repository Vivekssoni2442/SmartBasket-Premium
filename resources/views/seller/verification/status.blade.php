<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Seller Verification Status | SmartBasket Premium</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: Inter, Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(99,102,241,.20), transparent 35%),
                radial-gradient(circle at bottom right, rgba(14,165,233,.15), transparent 35%),
                #070b14;
            color: #fff;
            padding: 30px 18px;
        }

        .container {
            width: min(900px, 100%);
            margin: auto;
        }

        .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand h1 {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: .5px;
        }

        .brand span {
            color: #60a5fa;
        }

        .card {
            background: rgba(15, 23, 42, .88);
            border: 1px solid rgba(148,163,184,.18);
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 25px 80px rgba(0,0,0,.35);
            backdrop-filter: blur(18px);
        }

        .title {
            text-align: center;
            margin-bottom: 25px;
        }

        .title h2 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .title p {
            color: #94a3b8;
        }

        .seller-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 25px 0;
        }

        .info {
            background: rgba(30,41,59,.65);
            border: 1px solid rgba(148,163,184,.12);
            padding: 16px;
            border-radius: 14px;
        }

        .info small {
            display: block;
            color: #94a3b8;
            margin-bottom: 6px;
        }

        .info strong {
            color: #f8fafc;
            word-break: break-word;
        }

        .status {
            text-align: center;
            padding: 25px;
            border-radius: 18px;
            margin: 25px 0;
        }

        .status.pending {
            background: rgba(245,158,11,.10);
            border: 1px solid rgba(245,158,11,.35);
        }

        .status.approved {
            background: rgba(34,197,94,.10);
            border: 1px solid rgba(34,197,94,.35);
        }

        .status.rejected {
            background: rgba(239,68,68,.10);
            border: 1px solid rgba(239,68,68,.35);
        }

        .status.suspended {
            background: rgba(239,68,68,.10);
            border: 1px solid rgba(239,68,68,.35);
        }

        .status-icon {
            font-size: 45px;
            margin-bottom: 10px;
        }

        .status h3 {
            font-size: 22px;
            margin-bottom: 8px;
        }

        .status p {
            color: #cbd5e1;
            line-height: 1.6;
        }

        .steps {
            margin-top: 30px;
        }

        .steps h3 {
            margin-bottom: 18px;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 14px;
            background: rgba(30,41,59,.55);
            border: 1px solid rgba(148,163,184,.08);
        }

        .circle {
            width: 38px;
            height: 38px;
            min-width: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #334155;
            color: #cbd5e1;
            font-weight: 700;
        }

        .circle.done {
            background: #22c55e;
            color: #052e16;
        }

        .circle.current {
            background: #3b82f6;
            color: #fff;
            box-shadow: 0 0 0 5px rgba(59,130,246,.12);
        }

        .step-text {
            flex: 1;
        }

        .step-text strong {
            display: block;
            margin-bottom: 3px;
        }

        .step-text small {
            color: #94a3b8;
        }

        .step-link {
            color: #60a5fa;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
        }

        .step-link:hover {
            text-decoration: underline;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            margin-top: 30px;
        }

        .btn {
            display: inline-block;
            padding: 13px 22px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            border: 0;
            cursor: pointer;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-success {
            background: #16a34a;
            color: white;
        }

        .btn-secondary {
            background: #1e293b;
            color: white;
            border: 1px solid #334155;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .alert.success {
            background: rgba(34,197,94,.12);
            border: 1px solid rgba(34,197,94,.3);
            color: #86efac;
        }

        .alert.error {
            background: rgba(239,68,68,.12);
            border: 1px solid rgba(239,68,68,.3);
            color: #fca5a5;
        }

        .note {
            margin-top: 22px;
            padding: 15px;
            border-radius: 14px;
            background: rgba(59,130,246,.08);
            border: 1px solid rgba(59,130,246,.20);
            color: #bfdbfe;
            font-size: 14px;
            line-height: 1.6;
            text-align: center;
        }

        @media(max-width: 650px) {
            body {
                padding: 18px 12px;
            }

            .card {
                padding: 22px;
            }

            .seller-info {
                grid-template-columns: 1fr;
            }

            .title h2 {
                font-size: 23px;
            }

            .step {
                padding: 13px;
            }
        }
    </style>
</head>

<body>

@php

    /*
    |--------------------------------------------------------------------------
    | BASIC VALUES
    |--------------------------------------------------------------------------
    */

    $status = $seller->verification_status ?? 'pending_email';

    $emailDone = !empty($seller->email_verified_at);

    $documentsDone =
        !empty($seller->business_certificate_path)
        && !empty($seller->aadhaar_document_path);

    $aadhaarDone = !empty($seller->aadhaar_verified_at);

    $businessDone =
        !empty($seller->business_type);

    $bankDone =
        !empty($seller->bank_account_number)
        || !empty($seller->account_number);

    $reviewDone =
        in_array(
            $status,
            [
                'pending_admin_review',
                'approved',
            ],
            true
        );

    $applicationApproved =
        $status === 'approved';

    $activationDone =
        !empty($seller->activation_verified_at);


    /*
    |--------------------------------------------------------------------------
    | CURRENT STEP
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

    } elseif (!$applicationApproved) {

        $currentStep = 7;

    } elseif (!$activationDone) {

        $currentStep = 7;

    } else {

        $currentStep = 7;
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS MESSAGE
    |--------------------------------------------------------------------------
    */

    $statusMap = [

        'pending_email' => [
            'class' => 'pending',
            'icon' => '✉️',
            'title' => 'Email Verification Pending',
            'message' => 'Please verify your registered seller email to continue.'
        ],

        'email_verified' => [
            'class' => 'pending',
            'icon' => '📄',
            'title' => 'Documents Required',
            'message' => 'Your email has been verified. Please complete the required documents.'
        ],

        'documents_pending' => [
            'class' => 'pending',
            'icon' => '🪪',
            'title' => 'Aadhaar Verification Pending',
            'message' => 'Your documents are uploaded. Please complete Aadhaar verification.'
        ],

        'aadhaar_pending' => [
            'class' => 'pending',
            'icon' => '🔍',
            'title' => 'Aadhaar Verification In Progress',
            'message' => 'Your Aadhaar verification is currently being processed.'
        ],

        'pending_admin_review' => [
            'class' => 'pending',
            'icon' => '⏳',
            'title' => 'Application Under Review',
            'message' => 'Your complete seller application has been submitted and is waiting for admin approval.'
        ],

        'approved' => [
            'class' => 'approved',
            'icon' => '✅',
            'title' => 'Application Approved',
            'message' => 'Congratulations! Your seller application has been approved.'
        ],

        'rejected' => [
            'class' => 'rejected',
            'icon' => '❌',
            'title' => 'Application Rejected',
            'message' => !empty($seller->rejection_reason)
                ? 'Reason: '.$seller->rejection_reason
                : 'Your seller application was rejected.'
        ],

        'suspended' => [
            'class' => 'suspended',
            'icon' => '⚠️',
            'title' => 'Seller Account Suspended',
            'message' => 'Your seller account is currently suspended.'
        ],

    ];

    $currentStatus = $statusMap[$status] ?? [
        'class' => 'pending',
        'icon' => 'ℹ️',
        'title' => 'Verification Status',
        'message' => 'Your seller verification is being processed.'
    ];

@endphp


<div class="container">

    <div class="brand">
        <h1>
            SMART BASKET
            <span>PREMIUM</span>
        </h1>
    </div>


    <div class="card">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif


        {{-- ERROR MESSAGE --}}
        @if(session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif


        {{-- TITLE --}}
        <div class="title">

            <h2>
                Seller Verification Status
            </h2>

            <p>
                Your complete seller onboarding progress is shown below.
            </p>

        </div>


        {{-- SELLER INFORMATION --}}
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
                    Current Step
                </small>

                <strong>
                    {{ $currentStep }} / 7
                </strong>

            </div>

        </div>


        {{-- CURRENT STATUS --}}
        <div class="status {{ $currentStatus['class'] }}">

            <div class="status-icon">
                {{ $currentStatus['icon'] }}
            </div>

            <h3>
                {{ $currentStatus['title'] }}
            </h3>

            <p>
                {{ $currentStatus['message'] }}
            </p>

        </div>


        {{-- 7 STEP PROGRESS --}}
        <div class="steps">

            <h3>
                Verification Progress
            </h3>


            {{-- STEP 1 --}}
            <div class="step">

                <div class="circle
                    {{ $emailDone ? 'done' : ($currentStep === 1 ? 'current' : '') }}">

                    {{ $emailDone ? '✓' : '1' }}

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
                        class="step-link">
                        Open
                    </a>
                @endif

            </div>


            {{-- STEP 2 --}}
            <div class="step">

                <div class="circle
                    {{ $documentsDone ? 'done' : ($currentStep === 2 ? 'current' : '') }}">

                    {{ $documentsDone ? '✓' : '2' }}

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
                        class="step-link">
                        Open
                    </a>
                @endif

            </div>


            {{-- STEP 3 --}}
            <div class="step">

                <div class="circle
                    {{ $aadhaarDone ? 'done' : ($currentStep === 3 ? 'current' : '') }}">

                    {{ $aadhaarDone ? '✓' : '3' }}

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
                        class="step-link">
                        Open
                    </a>
                @endif

            </div>


            {{-- STEP 4 --}}
            <div class="step">

                <div class="circle
                    {{ $businessDone ? 'done' : ($currentStep === 4 ? 'current' : '') }}">

                    {{ $businessDone ? '✓' : '4' }}

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
                        class="step-link">
                        Open
                    </a>
                @endif

            </div>


            {{-- STEP 5 --}}
            <div class="step">

                <div class="circle
                    {{ $bankDone ? 'done' : ($currentStep === 5 ? 'current' : '') }}">

                    {{ $bankDone ? '✓' : '5' }}

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
                        class="step-link">
                        Open
                    </a>
                @endif

            </div>


            {{-- STEP 6 --}}
            <div class="step">

                <div class="circle
                    {{ $reviewDone ? 'done' : ($currentStep === 6 ? 'current' : '') }}">

                    {{ $reviewDone ? '✓' : '6' }}

                </div>

                <div class="step-text">

                    <strong>
                        Step 6 — Review & Submit
                    </strong>

                    <small>
                        {{ $reviewDone ? 'Application Submitted' : 'Ready for Review' }}
                    </small>

                </div>

                @if($bankDone && !$reviewDone)
                    <a
                        href="{{ route('seller.verification.review') }}"
                        class="step-link">
                        Open
                    </a>
                @endif

            </div>


            {{-- STEP 7 --}}
            <div class="step">

                <div class="circle
                    {{ $applicationApproved ? 'done' : ($currentStep === 7 ? 'current' : '') }}">

                    {{ $applicationApproved ? '✓' : '7' }}

                </div>

                <div class="step-text">

                    <strong>
                        Step 7 — Application Status
                    </strong>

                    <small>

                        @if($applicationApproved)
                            Approved

                        @elseif($status === 'pending_admin_review')
                            Waiting for Admin Approval

                        @elseif($status === 'rejected')
                            Rejected

                        @else
                            Pending

                        @endif

                    </small>

                </div>

                <a
                    href="{{ route('seller.verification.status') }}"
                    class="step-link">
                    View
                </a>

            </div>

        </div>


        {{-- INFORMATION --}}
        @if($status === 'pending_admin_review')

            <div class="note">
                ⏳ Your application has been submitted successfully.
                Please wait while the SmartBasket admin team reviews your
                documents and seller information.
            </div>

        @elseif($status === 'approved' && !$activationDone)

            <div class="note">
                🎉 Your application has been approved.
                Complete seller activation to access your seller dashboard.
            </div>

        @elseif($status === 'approved' && $activationDone)

            <div class="note">
                ✅ Your seller account is fully activated.
                You can now access the Seller Dashboard.
            </div>

        @elseif($status === 'rejected')

            <div class="note">
                Please review the rejection reason and update your application
                if resubmission is allowed.
            </div>

        @endif


        {{-- ACTION BUTTONS --}}
        <div class="actions">

            {{-- STEP 1 --}}
            @if(!$emailDone)

                <a
                    href="{{ route('seller.verification.email') }}"
                    class="btn btn-primary">

                    Verify Email

                </a>


            {{-- STEP 2 --}}
            @elseif(!$documentsDone)

                <a
                    href="{{ route('seller.verification.documents') }}"
                    class="btn btn-primary">

                    Continue to Documents

                </a>


            {{-- STEP 3 --}}
            @elseif(!$aadhaarDone)

                <a
                    href="{{ route('seller.verification.aadhaar') }}"
                    class="btn btn-primary">

                    Continue to Aadhaar

                </a>


            {{-- STEP 4 --}}
            @elseif(!$businessDone)

                <a
                    href="{{ route('seller.verification.business-details') }}"
                    class="btn btn-primary">

                    Continue to Business Details

                </a>


            {{-- STEP 5 --}}
            @elseif(!$bankDone)

                <a
                    href="{{ route('seller.verification.bank-details') }}"
                    class="btn btn-primary">

                    Continue to Bank Details

                </a>


            {{-- STEP 6 --}}
            @elseif(!$reviewDone)

                <a
                    href="{{ route('seller.verification.review') }}"
                    class="btn btn-primary">

                    Review Application

                </a>


            {{-- STEP 7 --}}
            @elseif($status === 'approved' && !$activationDone)

                <a
                    href="{{ route('seller.verification.activation') }}"
                    class="btn btn-success">

                    Activate Seller Account

                </a>

            @endif


            {{-- APPLICATION SUMMARY --}}
            <a
                href="{{ route('seller.verification.application.summary') }}"
                class="btn btn-secondary">

                Application Summary

            </a>


            {{-- SELLER LOGIN --}}
            <a
                href="{{ route('seller.login') }}"
                class="btn btn-secondary">

                Seller Login

            </a>

        </div>

    </div>

</div>

</body>
</html>