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
            font-family: Inter, Arial, sans-serif;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(99,102,241,.20), transparent 35%),
                radial-gradient(circle at bottom right, rgba(16,185,129,.15), transparent 35%),
                #070b14;
            color: #f8fafc;
            padding: 30px 18px;
        }

        .container {
            width: 100%;
            max-width: 900px;
            margin: auto;
        }

        .brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand h1 {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: .5px;
        }

        .brand p {
            color: #94a3b8;
            margin-top: 7px;
        }

        .card {
            background: rgba(15, 23, 42, .88);
            border: 1px solid rgba(148,163,184,.16);
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 25px 70px rgba(0,0,0,.35);
            backdrop-filter: blur(18px);
        }

        .alert {
            padding: 14px 16px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .success {
            background: rgba(16,185,129,.12);
            border: 1px solid rgba(16,185,129,.3);
            color: #6ee7b7;
        }

        .error {
            background: rgba(239,68,68,.12);
            border: 1px solid rgba(239,68,68,.3);
            color: #fca5a5;
        }

        .info {
            background: rgba(59,130,246,.12);
            border: 1px solid rgba(59,130,246,.3);
            color: #93c5fd;
        }

        .seller {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding-bottom: 25px;
            border-bottom: 1px solid rgba(148,163,184,.13);
        }

        .seller-info h2 {
            font-size: 24px;
            margin-bottom: 6px;
        }

        .seller-info p {
            color: #94a3b8;
            font-size: 14px;
        }

        .badge {
            padding: 9px 15px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
        }

        .pending {
            color: #fde68a;
            background: rgba(245,158,11,.13);
            border: 1px solid rgba(245,158,11,.3);
        }

        .approved {
            color: #6ee7b7;
            background: rgba(16,185,129,.13);
            border: 1px solid rgba(16,185,129,.3);
        }

        .rejected {
            color: #fca5a5;
            background: rgba(239,68,68,.13);
            border: 1px solid rgba(239,68,68,.3);
        }

        .suspended {
            color: #c4b5fd;
            background: rgba(139,92,246,.13);
            border: 1px solid rgba(139,92,246,.3);
        }

        .progress {
            margin: 30px 0;
        }

        .progress-title {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #cbd5e1;
            font-size: 14px;
        }

        .bar {
            width: 100%;
            height: 10px;
            border-radius: 99px;
            background: #1e293b;
            overflow: hidden;
        }

        .bar span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #6366f1, #22c55e);
        }

        .steps {
            display: grid;
            gap: 14px;
            margin-top: 28px;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 17px;
            border-radius: 16px;
            background: rgba(30,41,59,.55);
            border: 1px solid rgba(148,163,184,.10);
        }

        .circle {
            width: 38px;
            height: 38px;
            min-width: 38px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-weight: 800;
            background: #1e293b;
            color: #94a3b8;
        }

        .step.done .circle {
            background: #059669;
            color: white;
        }

        .step.current .circle {
            background: #4f46e5;
            color: white;
        }

        .step-text strong {
            display: block;
            margin-bottom: 3px;
        }

        .step-text span {
            color: #94a3b8;
            font-size: 13px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .btn {
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 13px 19px;
            border-radius: 13px;
            font-weight: 700;
            font-size: 14px;
            display: inline-block;
        }

        .primary {
            background: #4f46e5;
            color: white;
        }

        .primary:hover {
            background: #4338ca;
        }

        .secondary {
            background: #1e293b;
            color: #e2e8f0;
            border: 1px solid rgba(148,163,184,.16);
        }

        .danger-box {
            margin-top: 25px;
            padding: 18px;
            border-radius: 15px;
            background: rgba(239,68,68,.08);
            border: 1px solid rgba(239,68,68,.25);
        }

        .danger-box h3 {
            color: #fca5a5;
            margin-bottom: 7px;
        }

        .danger-box p {
            color: #cbd5e1;
            font-size: 14px;
            line-height: 1.6;
        }

        .footer {
            text-align: center;
            color: #64748b;
            font-size: 12px;
            margin-top: 22px;
        }

        @media (max-width: 650px) {
            body {
                padding: 18px 12px;
            }

            .card {
                padding: 22px 17px;
            }

            .seller {
                align-items: flex-start;
                flex-direction: column;
            }

            .brand h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="brand">
        <h1>SMART BASKET PREMIUM</h1>
        <p>Seller Partner Verification</p>
    </div>

    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert error">
            {{ session('error') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert info">
            {{ session('info') }}
        </div>
    @endif

    @php
        $status = $seller->verification_status ?? 'pending';

        $statusText = match($status) {
            \App\Models\SellerProfile::STATUS_APPROVED => 'Approved',
            \App\Models\SellerProfile::STATUS_REJECTED => 'Rejected',
            \App\Models\SellerProfile::STATUS_SUSPENDED => 'Suspended',
            \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW => 'Under Admin Review',
            \App\Models\SellerProfile::STATUS_AADHAAR_PENDING => 'Aadhaar Verification Pending',
            \App\Models\SellerProfile::STATUS_DOCUMENTS_PENDING => 'Documents Pending',
            \App\Models\SellerProfile::STATUS_EMAIL_VERIFIED => 'Email Verified',
            \App\Models\SellerProfile::STATUS_PENDING_EMAIL => 'Email Verification Pending',
            default => ucwords(str_replace('_', ' ', $status)),
        };

        $badgeClass = match($status) {
            \App\Models\SellerProfile::STATUS_APPROVED => 'approved',
            \App\Models\SellerProfile::STATUS_REJECTED => 'rejected',
            \App\Models\SellerProfile::STATUS_SUSPENDED => 'suspended',
            default => 'pending',
        };

        $step = (int) ($seller->onboarding_step ?? 1);

        if ($seller->activation_verified_at) {
            $step = 6;
        }

        $progress = min(100, max(16, ($step / 6) * 100));
    @endphp

    <div class="card">

        <div class="seller">
            <div class="seller-info">
                <h2>
                    {{ $seller->seller_name ?? 'Seller' }}
                </h2>

                <p>
                    {{ $seller->email }}
                </p>

                @if($seller->id)
                    <p style="margin-top:5px;">
                        Seller ID: #{{ $seller->id }}
                    </p>
                @endif
            </div>

            <div class="badge {{ $badgeClass }}">
                {{ $statusText }}
            </div>
        </div>

        <div class="progress">

            <div class="progress-title">
                <span>Verification Progress</span>
                <strong>{{ $step }}/6</strong>
            </div>

            <div class="bar">
                <span style="width: {{ $progress }}%;"></span>
            </div>

        </div>

        <div class="steps">

            <div class="step {{ $seller->email_verified_at ? 'done' : ($step == 1 ? 'current' : '') }}">
                <div class="circle">
                    {{ $seller->email_verified_at ? '✓' : '1' }}
                </div>

                <div class="step-text">
                    <strong>Email Verification</strong>
                    <span>
                        {{ $seller->email_verified_at ? 'Email verified successfully.' : 'Verify your registered email address.' }}
                    </span>
                </div>
            </div>


            <div class="step {{ $seller->business_certificate_path && $seller->aadhaar_document_path ? 'done' : ($step == 2 ? 'current' : '') }}">
                <div class="circle">
                    {{ $seller->business_certificate_path && $seller->aadhaar_document_path ? '✓' : '2' }}
                </div>

                <div class="step-text">
                    <strong>Document Upload</strong>
                    <span>
                        {{ $seller->business_certificate_path && $seller->aadhaar_document_path ? 'Required documents uploaded.' : 'Upload business certificate and Aadhaar.' }}
                    </span>
                </div>
            </div>


            <div class="step {{ $seller->aadhaar_verified_at ? 'done' : ($step == 3 ? 'current' : '') }}">
                <div class="circle">
                    {{ $seller->aadhaar_verified_at ? '✓' : '3' }}
                </div>

                <div class="step-text">
                    <strong>Aadhaar Verification</strong>
                    <span>
                        {{ $seller->aadhaar_verified_at ? 'Aadhaar verification completed.' : 'Complete Aadhaar verification.' }}
                    </span>
                </div>
            </div>


            <div class="step {{ $seller->aadhaar_verified_at && $seller->verification_status === \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW ? 'done' : ($step == 4 ? 'current' : '') }}">
                <div class="circle">
                    {{ $seller->verification_status === \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW ? '✓' : '4' }}
                </div>

                <div class="step-text">
                    <strong>Application Submission</strong>
                    <span>
                        {{ $seller->verification_status === \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW ? 'Application submitted to admin.' : 'Submit your completed application.' }}
                    </span>
                </div>
            </div>


            <div class="step {{ $seller->verification_status === \App\Models\SellerProfile::STATUS_APPROVED ? 'done' : ($seller->verification_status === \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW ? 'current' : '') }}">
                <div class="circle">
                    {{ $seller->verification_status === \App\Models\SellerProfile::STATUS_APPROVED ? '✓' : '5' }}
                </div>

                <div class="step-text">
                    <strong>Admin Review</strong>
                    <span>
                        @if($seller->verification_status === \App\Models\SellerProfile::STATUS_APPROVED)
                            Application approved by admin.
                        @elseif($seller->verification_status === \App\Models\SellerProfile::STATUS_REJECTED)
                            Application rejected by admin.
                        @else
                            Waiting for admin verification.
                        @endif
                    </span>
                </div>
            </div>


            <div class="step {{ $seller->activation_verified_at ? 'done' : ($seller->verification_status === \App\Models\SellerProfile::STATUS_APPROVED ? 'current' : '') }}">
                <div class="circle">
                    {{ $seller->activation_verified_at ? '✓' : '6' }}
                </div>

                <div class="step-text">
                    <strong>Seller Activation</strong>
                    <span>
                        @if($seller->activation_verified_at)
                            Seller account activated.
                        @elseif($seller->verification_status === \App\Models\SellerProfile::STATUS_APPROVED)
                            Enter the activation code sent to your email.
                        @else
                            Available after admin approval.
                        @endif
                    </span>
                </div>
            </div>

        </div>


        @if($seller->verification_status === \App\Models\SellerProfile::STATUS_REJECTED)

            <div class="danger-box">
                <h3>Application Rejected</h3>

                <p>
                    {{ $seller->rejection_reason ?: 'Your seller application was rejected by the administrator.' }}
                </p>
            </div>

        @elseif($seller->verification_status === \App\Models\SellerProfile::STATUS_SUSPENDED)

            <div class="danger-box">
                <h3>Seller Account Suspended</h3>

                <p>
                    Your seller account is currently suspended.
                    Please contact the administrator for further assistance.
                </p>
            </div>

        @elseif($seller->verification_status === \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW)

            <div class="alert info" style="margin-top:25px; margin-bottom:0;">
                <strong>Application Under Review</strong><br>
                Your documents and verification details have been submitted.
                The SmartBasket administrator will review your application.
            </div>

        @elseif($seller->verification_status === \App\Models\SellerProfile::STATUS_APPROVED)

            <div class="alert success" style="margin-top:25px; margin-bottom:0;">
                <strong>Congratulations!</strong><br>
                Your seller application has been approved.
                You can now activate your seller account.
            </div>

        @endif


        <div class="actions">

            @if(!$seller->email_verified_at)

                <a
                    href="{{ route('seller.verification.email') }}"
                    class="btn primary"
                >
                    Verify Email
                </a>

            @elseif(!$seller->business_certificate_path || !$seller->aadhaar_document_path)

                <a
                    href="{{ route('seller.verification.documents') }}"
                    class="btn primary"
                >
                    Upload Documents
                </a>

            @elseif(!$seller->aadhaar_verified_at)

                <a
                    href="{{ route('seller.verification.aadhaar') }}"
                    class="btn primary"
                >
                    Complete Aadhaar Verification
                </a>

            @elseif($seller->verification_status === \App\Models\SellerProfile::STATUS_APPROVED)

                <a
                    href="{{ route('seller.activation') }}"
                    class="btn primary"
                >
                    Activate Seller Account
                </a>

            @elseif($seller->verification_status === \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW)

                <span class="btn secondary">
                    Waiting for Admin Approval
                </span>

            @endif


            @if($seller->isActive())

                <a
                    href="{{ route('seller.dashboard') }}"
                    class="btn primary"
                >
                    Seller Dashboard
                </a>

            @endif

        </div>

    </div>

    <div class="footer">
        © {{ date('Y') }} SmartBasket Premium · Seller Partner Program
    </div>

</div>

</body>
</html>