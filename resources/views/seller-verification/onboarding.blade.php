<x-seller-verification.layout :seller="$seller">

@php
    $steps = [
        1 => 'Account Created',
        2 => 'Email Verified',
        3 => 'Business Documents',
        4 => 'Application Submitted',
        5 => 'Admin Review',
        6 => 'Application Approved',
        7 => 'Seller Activation',
        8 => 'Seller Dashboard',
    ];

    $status = $seller->verification_status;

    /*
    |--------------------------------------------------------------------------
    | STEP DISPLAY
    |--------------------------------------------------------------------------
    | Step display is controlled by verification_status.
    | onboarding_step is intentionally not used because the database may still
    | contain an old/default value.
    |--------------------------------------------------------------------------
    */

    $current = match ($status) {
        'pending_email_verification' => 1,

        'email_verified' => 2,

        'documents_pending',
        'aadhaar_pending',
        'aadhaar_verified' => 3,

        'pending_admin_review' => 5,

        'approved' => 7,

        'active' => 8,

        'rejected' => 5,

        default => 1,
    };

    $next = match ($status) {
        'pending_email_verification'
            => 'Verify your email to continue your seller onboarding.',

        'email_verified'
            => 'Upload your business documents to continue.',

        'documents_pending'
            => 'Submit your required documents and continue your verification.',

        'aadhaar_pending'
            => 'Complete Aadhaar verification to continue.',

        'aadhaar_verified'
            => 'Submit your application for admin review.',

        'pending_admin_review'
            => 'Application submitted successfully. Waiting for admin review.',

        'approved'
            => 'Application approved. Complete seller activation to continue.',

        'active'
            => 'Your seller account is active and ready to use.',

        'rejected'
            => 'Your application was rejected. Review the required changes and resubmit.',

        default
            => 'Review your application status and continue the verification process.',
    };

    /*
    |--------------------------------------------------------------------------
    | STATUS PRESENTATION
    |--------------------------------------------------------------------------
    */

    $statusLabel = match ($status) {
        'pending_email_verification' => 'Email Verification Pending',
        'email_verified' => 'Email Verified',
        'documents_pending' => 'Documents Pending',
        'aadhaar_pending' => 'Aadhaar Verification Pending',
        'aadhaar_verified' => 'Aadhaar Verified',
        'pending_admin_review' => 'Under Admin Review',
        'approved' => 'Approved',
        'active' => 'Seller Active',
        'rejected' => 'Application Rejected',
        default => 'Verification Pending',
    };

    $statusClass = match ($status) {
        'active' => 'status-active',

        'approved',
        'aadhaar_verified',
        'email_verified' => 'status-success',

        'pending_admin_review' => 'status-review',

        'rejected' => 'status-danger',

        default => 'status-pending',
    };

    $statusIcon = match ($status) {
        'active' => 'fa-circle-check',

        'approved',
        'aadhaar_verified',
        'email_verified' => 'fa-shield-check',

        'pending_admin_review' => 'fa-hourglass-half',

        'rejected' => 'fa-circle-xmark',

        default => 'fa-clock',
    };

    /*
    |--------------------------------------------------------------------------
    | PROGRESS
    |--------------------------------------------------------------------------
    */

    $progress = match ($status) {
        'active' => 100,
        'approved' => 88,
        'pending_admin_review' => 62,
        'aadhaar_verified' => 50,
        'aadhaar_pending' => 42,
        'documents_pending' => 35,
        'email_verified' => 25,
        'rejected' => 62,
        default => 12,
    };

    /*
    |--------------------------------------------------------------------------
    | SELLER DISPLAY DATA
    |--------------------------------------------------------------------------
    */

    $sellerName =
        $seller->seller_name
        ?? $seller->business_name
        ?? $seller->name
        ?? 'Seller';

    $sellerInitial = strtoupper(
        substr(
            trim((string) $sellerName),
            0,
            1
        )
    );

    $email =
        $seller->email
        ?? 'Not provided';

    $businessName =
        $seller->business_name
        ?? $seller->shop_name
        ?? 'Business not provided';

@endphp

<div class="seller-onboarding-page">

    {{-- ================================================================
         HERO
    ================================================================= --}}

    <section class="onboarding-hero">

        <div class="hero-content">

            <div class="hero-kicker">
                <span class="kicker-dot"></span>
                SMART BASKET
                <span class="kicker-divider"></span>
                SELLER VERIFICATION
            </div>

            <div class="hero-title-row">

                <div class="hero-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>

                <div>

                    <h1>
                        Seller Onboarding
                    </h1>

                    <p>
                        Track your seller verification, KYC and account activation
                        progress from one secure place.
                    </p>

                </div>

            </div>

        </div>

        <div class="hero-status {{ $statusClass }}">

            <span class="hero-status-icon">
                <i class="fa-solid {{ $statusIcon }}"></i>
            </span>

            <span>
                <small>Current Status</small>
                <strong>{{ $statusLabel }}</strong>
            </span>

        </div>

    </section>


    {{-- ================================================================
         STATUS OVERVIEW
    ================================================================= --}}

    <section class="overview-grid">

        <div class="overview-card progress-card">

            <div class="overview-card-top">

                <div>

                    <span class="overview-label">
                        VERIFICATION PROGRESS
                    </span>

                    <div class="progress-number">
                        {{ $progress }}%
                    </div>

                </div>

                <div class="overview-icon blue">
                    <i class="fa-solid fa-chart-line"></i>
                </div>

            </div>

            <div class="progress-track">

                <div
                    class="progress-fill"
                    style="width: {{ $progress }}%;"
                ></div>

            </div>

            <div class="progress-meta">

                <span>
                    Step {{ $current }} of {{ count($steps) }}
                </span>

                <span>
                    {{ $steps[$current] ?? 'Verification' }}
                </span>

            </div>

        </div>


        <div class="overview-card">

            <div class="overview-card-top">

                <div>

                    <span class="overview-label">
                        SELLER ACCOUNT
                    </span>

                    <div class="seller-mini">

                        <div class="seller-avatar">
                            {{ $sellerInitial }}
                        </div>

                        <div>

                            <strong>
                                {{ $sellerName }}
                            </strong>

                            <span>
                                {{ $email }}
                            </span>

                        </div>

                    </div>

                </div>

                <div class="overview-icon cyan">
                    <i class="fa-solid fa-store"></i>
                </div>

            </div>

            <div class="business-line">

                <i class="fa-solid fa-building"></i>

                <span>
                    {{ $businessName }}
                </span>

            </div>

        </div>


        <div class="overview-card next-card">

            <div class="overview-card-top">

                <div>

                    <span class="overview-label">
                        NEXT ACTION
                    </span>

                    <div class="next-action-title">
                        {{ $steps[$current] ?? 'Verification' }}
                    </div>

                </div>

                <div class="overview-icon amber">
                    <i class="fa-solid fa-arrow-right"></i>
                </div>

            </div>

            <p>
                {{ $next }}
            </p>

        </div>

    </section>


    {{-- ================================================================
         MAIN CONTENT
    ================================================================= --}}

    <div class="onboarding-content">


        {{-- ============================================================
             STEP TIMELINE
        ============================================================= --}}

        <section class="verification-card">

            <div class="card-heading">

                <div>

                    <span class="section-kicker">
                        ONBOARDING JOURNEY
                    </span>

                    <h2>
                        Verification Progress
                    </h2>

                    <p>
                        Follow each stage of your SmartBasket seller activation.
                    </p>

                </div>

                <div class="step-count-badge">
                    <i class="fa-solid fa-list-check"></i>
                    {{ $current }} / {{ count($steps) }}
                </div>

            </div>


            <div class="timeline">

                @foreach($steps as $stepNumber => $step)

                    @php

                        if ($status === 'rejected') {

                            if ($stepNumber === $current) {
                                $stepState = 'rejected';
                            } elseif ($stepNumber < $current) {
                                $stepState = 'completed';
                            } else {
                                $stepState = 'upcoming';
                            }

                        } elseif ($stepNumber < $current) {

                            $stepState = 'completed';

                        } elseif ($stepNumber === $current) {

                            $stepState = 'current';

                        } else {

                            $stepState = 'upcoming';

                        }

                    @endphp

                    <div class="timeline-item {{ $stepState }}">

                        <div class="timeline-line-wrap">

                            <div class="timeline-marker">

                                @if($stepState === 'completed')

                                    <i class="fa-solid fa-check"></i>

                                @elseif($stepState === 'rejected')

                                    <i class="fa-solid fa-xmark"></i>

                                @elseif($stepState === 'current')

                                    <span class="current-marker-dot"></span>

                                @else

                                    <span>
                                        {{ $stepNumber }}
                                    </span>

                                @endif

                            </div>

                            @if($stepNumber < count($steps))

                                <div class="timeline-line"></div>

                            @endif

                        </div>


                        <div class="timeline-content">

                            <div class="timeline-top">

                                <div>

                                    <span class="timeline-step">
                                        STEP {{ str_pad($stepNumber, 2, '0', STR_PAD_LEFT) }}
                                    </span>

                                    <h3>
                                        {{ $step }}
                                    </h3>

                                </div>


                                <span class="timeline-status">

                                    @if($stepState === 'completed')

                                        <i class="fa-solid fa-circle-check"></i>
                                        Completed

                                    @elseif($stepState === 'current')

                                        <i class="fa-solid fa-spinner"></i>
                                        Current

                                    @elseif($stepState === 'rejected')

                                        <i class="fa-solid fa-circle-xmark"></i>
                                        Rejected

                                    @else

                                        <i class="fa-regular fa-circle"></i>
                                        Upcoming

                                    @endif

                                </span>

                            </div>


                            <p>

                                @if($stepState === 'completed')

                                    This verification stage has been completed successfully.

                                @elseif($stepState === 'current' && $status === 'pending_email_verification')

                                    Verify your registered seller email to continue.

                                @elseif($stepState === 'current' && $status === 'email_verified')

                                    Your email is verified. Continue with the required KYC documents.

                                @elseif($stepState === 'current' && $status === 'documents_pending')

                                    Upload the required business and identity documents.

                                @elseif($stepState === 'current' && $status === 'aadhaar_pending')

                                    Complete the Aadhaar verification process.

                                @elseif($stepState === 'current' && $status === 'aadhaar_verified')

                                    Your Aadhaar is verified. Submit your seller application for review.

                                @elseif($stepState === 'current' && $status === 'pending_admin_review')

                                    Your application has been submitted and is waiting for administrator review.

                                @elseif($stepState === 'current' && $status === 'approved')

                                    Your seller application has been approved. Complete account activation.

                                @elseif($stepState === 'current' && $status === 'active')

                                    Your seller account is fully activated.

                                @elseif($stepState === 'rejected')

                                    Your application requires attention before it can proceed.

                                @else

                                    This stage will become available after the previous verification steps are completed.

                                @endif

                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

        </section>


        {{-- ============================================================
             CURRENT STATUS CARD
        ============================================================= --}}

        <aside class="status-side-card">

            <div class="side-card-header">

                <div class="side-card-icon {{ $statusClass }}">
                    <i class="fa-solid {{ $statusIcon }}"></i>
                </div>

                <div>

                    <span>
                        LIVE STATUS
                    </span>

                    <h3>
                        {{ $statusLabel }}
                    </h3>

                </div>

            </div>


            <div class="status-message {{ $statusClass }}">

                <div class="message-icon">

                    @if($status === 'rejected')

                        <i class="fa-solid fa-triangle-exclamation"></i>

                    @elseif($status === 'active')

                        <i class="fa-solid fa-circle-check"></i>

                    @elseif($status === 'pending_admin_review')

                        <i class="fa-solid fa-hourglass-half"></i>

                    @else

                        <i class="fa-solid fa-shield-halved"></i>

                    @endif

                </div>

                <div>

                    <strong>
                        {{ $next }}
                    </strong>

                    <p>
                        Keep your information and submitted documents accurate
                        throughout the verification process.
                    </p>

                </div>

            </div>


            <div class="status-details">

                <div class="detail-row">

                    <span>
                        <i class="fa-solid fa-user"></i>
                        Seller
                    </span>

                    <strong>
                        {{ $sellerName }}
                    </strong>

                </div>

                <div class="detail-row">

                    <span>
                        <i class="fa-solid fa-envelope"></i>
                        Email
                    </span>

                    <strong>
                        {{ $email }}
                    </strong>

                </div>

                <div class="detail-row">

                    <span>
                        <i class="fa-solid fa-store"></i>
                        Business
                    </span>

                    <strong>
                        {{ $businessName }}
                    </strong>

                </div>

                <div class="detail-row">

                    <span>
                        <i class="fa-solid fa-layer-group"></i>
                        Current Step
                    </span>

                    <strong>
                        {{ $current }} / {{ count($steps) }}
                    </strong>

                </div>

            </div>

        </aside>

    </div>


    {{-- ================================================================
         VERIFICATION TIMELINE / LOGS
    ================================================================= --}}

    @if($logs->isNotEmpty())

        <section class="logs-card">

            <div class="card-heading logs-heading">

                <div>

                    <span class="section-kicker">
                        ACTIVITY HISTORY
                    </span>

                    <h2>
                        Verification Timeline
                    </h2>

                    <p>
                        A secure record of important verification events.
                    </p>

                </div>

                <div class="activity-icon">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>

            </div>


            <div class="activity-list">

                @foreach($logs as $log)

                    <div class="activity-item">

                        <div class="activity-marker">
                            <i class="fa-solid fa-check"></i>
                        </div>

                        <div class="activity-content">

                            <div class="activity-main">

                                <h3>
                                    {{ str_replace('_', ' ', $log->event) }}
                                </h3>

                                <span class="activity-badge">
                                    Verification Event
                                </span>

                            </div>

                            <div class="activity-time">

                                <i class="fa-regular fa-calendar"></i>

                                {{ $log->created_at->format('d M Y') }}

                                <span class="time-divider">•</span>

                                <i class="fa-regular fa-clock"></i>

                                {{ $log->created_at->format('H:i') }}

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </section>

    @else

        <section class="empty-activity-card">

            <div class="empty-icon">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>

            <div>

                <h3>
                    No verification activity yet
                </h3>

                <p>
                    Your verification events will appear here as you progress
                    through the seller onboarding process.
                </p>

            </div>

        </section>

    @endif


    {{-- ================================================================
         SECURITY FOOTER
    ================================================================= --}}

    <div class="security-footer">

        <div class="security-footer-icon">
            <i class="fa-solid fa-lock"></i>
        </div>

        <div>

            <strong>
                Your verification data is protected
            </strong>

            <p>
                SmartBasket uses secure verification workflows to protect
                seller information and submitted documents.
            </p>

        </div>

        <div class="secure-badge">
            <i class="fa-solid fa-shield-check"></i>
            Secure
        </div>

    </div>

</div>


@push('styles')

<style>

:root {
    --onb-blue: #2563eb;
    --onb-blue-dark: #1d4ed8;
    --onb-blue-deep: #1e40af;
    --onb-blue-soft: #eff6ff;
    --onb-blue-soft-2: #dbeafe;

    --onb-cyan: #0891b2;
    --onb-green: #16a34a;
    --onb-green-soft: #ecfdf3;

    --onb-amber: #d97706;
    --onb-amber-soft: #fffbeb;

    --onb-red: #dc2626;
    --onb-red-soft: #fef2f2;

    --onb-bg: #f4f8ff;
    --onb-card: #ffffff;
    --onb-border: #e2e8f0;

    --onb-text: #0f172a;
    --onb-text-2: #334155;
    --onb-muted: #64748b;
    --onb-light: #94a3b8;

    --onb-shadow:
        0 14px 40px rgba(15, 23, 42, .07);

    --onb-shadow-hover:
        0 20px 50px rgba(37, 99, 235, .12);
}


/* ================================================================
   PAGE
================================================================ */

.seller-onboarding-page {
    width: 100%;
    max-width: 1580px;
    margin: 0 auto;
    padding: 24px 28px 45px;

    color: var(--onb-text);

    background:
        radial-gradient(
            circle at 0% 0%,
            rgba(37, 99, 235, .07),
            transparent 25%
        ),
        radial-gradient(
            circle at 100% 10%,
            rgba(14, 165, 233, .06),
            transparent 25%
        );
}


/* ================================================================
   HERO
================================================================ */

.onboarding-hero {
    position: relative;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 30px;

    padding: 32px 34px;

    overflow: hidden;

    border-radius: 24px;

    background:
        linear-gradient(
            135deg,
            #ffffff 0%,
            #f8fbff 58%,
            #eff6ff 100%
        );

    border: 1px solid #dbe7f5;

    box-shadow: var(--onb-shadow);
}


.onboarding-hero::before {
    content: "";

    position: absolute;

    width: 250px;
    height: 250px;

    right: -100px;
    top: -130px;

    border-radius: 50%;

    background:
        rgba(37, 99, 235, .08);
}


.onboarding-hero::after {
    content: "";

    position: absolute;

    width: 170px;
    height: 170px;

    right: 180px;
    bottom: -120px;

    border-radius: 50%;

    background:
        rgba(14, 165, 233, .06);
}


.hero-content,
.hero-status {
    position: relative;
    z-index: 1;
}


.hero-kicker {
    display: flex;
    align-items: center;
    gap: 8px;

    margin-bottom: 14px;

    color: var(--onb-blue);

    font-size: .68rem;
    font-weight: 900;
    letter-spacing: .17em;
}


.kicker-dot {
    width: 7px;
    height: 7px;

    border-radius: 50%;

    background: var(--onb-blue);

    box-shadow:
        0 0 0 5px rgba(37, 99, 235, .10);
}


.kicker-divider {
    width: 24px;
    height: 1px;

    background: #bfdbfe;
}


.hero-title-row {
    display: flex;
    align-items: center;
    gap: 16px;
}


.hero-icon {
    width: 58px;
    height: 58px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 17px;

    color: #ffffff;

    background:
        linear-gradient(
            135deg,
            var(--onb-blue),
            var(--onb-blue-dark)
        );

    box-shadow:
        0 10px 24px rgba(37, 99, 235, .22);

    font-size: 1.35rem;
}


.onboarding-hero h1 {
    margin: 0 0 6px;

    color: var(--onb-text);

    font-size: clamp(1.8rem, 3vw, 2.65rem);
    line-height: 1.08;

    font-weight: 900;

    letter-spacing: -.045em;
}


.onboarding-hero p {
    max-width: 700px;

    margin: 0;

    color: var(--onb-muted);

    font-size: .91rem;
    line-height: 1.6;
}


.hero-status {
    min-width: 255px;

    display: flex;
    align-items: center;
    gap: 12px;

    padding: 15px 18px;

    border-radius: 16px;

    background: #ffffff;

    border: 1px solid #dbe7f5;

    box-shadow:
        0 8px 25px rgba(15, 23, 42, .05);
}


.hero-status-icon {
    width: 43px;
    height: 43px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 13px;

    font-size: 1rem;
}


.hero-status small {
    display: block;

    margin-bottom: 3px;

    color: var(--onb-light);

    font-size: .62rem;
    font-weight: 900;

    letter-spacing: .12em;
    text-transform: uppercase;
}


.hero-status strong {
    display: block;

    color: var(--onb-text);

    font-size: .82rem;
    font-weight: 850;
}


/* ================================================================
   STATUS COLORS
================================================================ */

.status-active .hero-status-icon,
.status-active.side-card-icon,
.status-active .message-icon {
    color: var(--onb-green);
    background: var(--onb-green-soft);
}


.status-success .hero-status-icon,
.status-success.side-card-icon,
.status-success .message-icon {
    color: var(--onb-blue);
    background: var(--onb-blue-soft);
}


.status-review .hero-status-icon,
.status-review.side-card-icon,
.status-review .message-icon {
    color: var(--onb-amber);
    background: var(--onb-amber-soft);
}


.status-pending .hero-status-icon,
.status-pending.side-card-icon,
.status-pending .message-icon {
    color: var(--onb-blue);
    background: var(--onb-blue-soft);
}


.status-danger .hero-status-icon,
.status-danger.side-card-icon,
.status-danger .message-icon {
    color: var(--onb-red);
    background: var(--onb-red-soft);
}


/* ================================================================
   OVERVIEW
================================================================ */

.overview-grid {
    display: grid;

    grid-template-columns:
        minmax(0, 1.15fr)
        minmax(0, 1fr)
        minmax(0, .95fr);

    gap: 18px;

    margin-top: 20px;
}


.overview-card {
    min-width: 0;

    padding: 22px;

    border-radius: 20px;

    background: var(--onb-card);

    border: 1px solid var(--onb-border);

    box-shadow: var(--onb-shadow);

    transition:
        transform .2s ease,
        box-shadow .2s ease,
        border-color .2s ease;
}


.overview-card:hover {
    transform: translateY(-2px);

    box-shadow: var(--onb-shadow-hover);

    border-color: #cbdcf4;
}


.overview-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;

    gap: 15px;
}


.overview-label {
    display: block;

    margin-bottom: 5px;

    color: var(--onb-light);

    font-size: .63rem;
    font-weight: 900;

    letter-spacing: .12em;
}


.overview-icon {
    width: 42px;
    height: 42px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 13px;

    font-size: .95rem;
}


.overview-icon.blue {
    color: var(--onb-blue);
    background: var(--onb-blue-soft);
}


.overview-icon.cyan {
    color: var(--onb-cyan);
    background: #ecfeff;
}


.overview-icon.amber {
    color: var(--onb-amber);
    background: var(--onb-amber-soft);
}


.progress-number {
    color: var(--onb-blue);

    font-size: 1.8rem;
    font-weight: 900;

    letter-spacing: -.04em;
}


.progress-track {
    height: 8px;

    margin-top: 18px;

    overflow: hidden;

    border-radius: 999px;

    background: #e8eef7;
}


.progress-fill {
    height: 100%;

    border-radius: inherit;

    background:
        linear-gradient(
            90deg,
            var(--onb-blue-deep),
            var(--onb-blue),
            #38bdf8
        );

    transition: width .5s ease;
}


.progress-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 10px;

    margin-top: 10px;

    color: var(--onb-muted);

    font-size: .7rem;
    font-weight: 700;
}


.seller-mini {
    display: flex;
    align-items: center;
    gap: 10px;

    margin-top: 8px;
}


.seller-avatar {
    width: 39px;
    height: 39px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 12px;

    color: #ffffff;

    background:
        linear-gradient(
            135deg,
            var(--onb-blue),
            var(--onb-blue-deep)
        );

    font-size: .82rem;
    font-weight: 900;
}


.seller-mini strong {
    display: block;

    max-width: 180px;

    overflow: hidden;

    color: var(--onb-text);

    font-size: .84rem;

    text-overflow: ellipsis;
    white-space: nowrap;
}


.seller-mini span {
    display: block;

    max-width: 190px;

    margin-top: 2px;

    overflow: hidden;

    color: var(--onb-muted);

    font-size: .69rem;

    text-overflow: ellipsis;
    white-space: nowrap;
}


.business-line {
    display: flex;
    align-items: center;
    gap: 8px;

    margin-top: 17px;
    padding-top: 13px;

    color: var(--onb-muted);

    border-top: 1px solid #edf1f6;

    font-size: .75rem;
    font-weight: 700;
}


.business-line i {
    color: var(--onb-blue);
}


.next-action-title {
    max-width: 220px;

    color: var(--onb-text);

    font-size: 1.02rem;
    line-height: 1.35;

    font-weight: 850;
}


.next-card p {
    margin: 15px 0 0;

    color: var(--onb-muted);

    font-size: .76rem;
    line-height: 1.6;
}


/* ================================================================
   MAIN CONTENT
================================================================ */

.onboarding-content {
    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        350px;

    gap: 20px;

    margin-top: 20px;
}


.verification-card,
.status-side-card,
.logs-card,
.empty-activity-card {
    background: #ffffff;

    border: 1px solid var(--onb-border);

    box-shadow: var(--onb-shadow);
}


/* ================================================================
   CARD HEADER
================================================================ */

.verification-card {
    padding: 27px;

    border-radius: 22px;
}


.card-heading {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;

    gap: 20px;

    padding-bottom: 20px;

    border-bottom: 1px solid #edf1f6;
}


.section-kicker {
    display: block;

    margin-bottom: 5px;

    color: var(--onb-blue);

    font-size: .63rem;
    font-weight: 900;

    letter-spacing: .14em;
}


.card-heading h2 {
    margin: 0;

    color: var(--onb-text);

    font-size: 1.35rem;
    font-weight: 900;

    letter-spacing: -.025em;
}


.card-heading p {
    margin: 5px 0 0;

    color: var(--onb-muted);

    font-size: .78rem;
}


.step-count-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    padding: 9px 12px;

    flex-shrink: 0;

    border-radius: 999px;

    color: var(--onb-blue);

    background: var(--onb-blue-soft);

    border: 1px solid #dbeafe;

    font-size: .68rem;
    font-weight: 900;
}


/* ================================================================
   TIMELINE
================================================================ */

.timeline {
    padding-top: 25px;
}


.timeline-item {
    display: grid;

    grid-template-columns: 46px minmax(0, 1fr);

    gap: 15px;

    min-height: 90px;
}


.timeline-line-wrap {
    position: relative;

    display: flex;
    justify-content: center;
}


.timeline-marker {
    position: relative;
    z-index: 2;

    width: 36px;
    height: 36px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    color: #94a3b8;

    background: #f8fafc;

    border: 2px solid #dbe3ed;

    font-size: .72rem;
    font-weight: 900;
}


.timeline-line {
    position: absolute;

    top: 36px;
    bottom: -4px;

    width: 2px;

    background: #e2e8f0;
}


.timeline-item.completed .timeline-marker {
    color: #ffffff;

    background:
        linear-gradient(
            135deg,
            var(--onb-green),
            #15803d
        );

    border-color: var(--onb-green);

    box-shadow:
        0 5px 15px rgba(22, 163, 74, .16);
}


.timeline-item.completed .timeline-line {
    background:
        #bbf7d0;
}


.timeline-item.current .timeline-marker {
    color: #ffffff;

    background:
        linear-gradient(
            135deg,
            var(--onb-blue),
            var(--onb-blue-deep)
        );

    border-color: var(--onb-blue);

    box-shadow:
        0 0 0 6px rgba(37, 99, 235, .10),
        0 6px 18px rgba(37, 99, 235, .18);
}


.current-marker-dot {
    width: 9px;
    height: 9px;

    border-radius: 50%;

    background: #ffffff;

    box-shadow:
        0 0 0 4px rgba(255,255,255,.16);
}


.timeline-item.rejected .timeline-marker {
    color: #ffffff;

    background:
        linear-gradient(
            135deg,
            var(--onb-red),
            #b91c1c
        );

    border-color: var(--onb-red);

    box-shadow:
        0 5px 15px rgba(220, 38, 38, .15);
}


.timeline-content {
    padding: 0 0 24px;
}


.timeline-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;

    gap: 15px;
}


.timeline-step {
    display: block;

    margin-bottom: 3px;

    color: var(--onb-light);

    font-size: .59rem;
    font-weight: 900;

    letter-spacing: .12em;
}


.timeline-content h3 {
    margin: 0;

    color: var(--onb-text);

    font-size: .95rem;
    font-weight: 850;
}


.timeline-content p {
    max-width: 680px;

    margin: 7px 0 0;

    color: var(--onb-muted);

    font-size: .76rem;
    line-height: 1.55;
}


.timeline-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;

    flex-shrink: 0;

    padding: 6px 9px;

    border-radius: 999px;

    color: #64748b;

    background: #f8fafc;

    border: 1px solid #e2e8f0;

    font-size: .6rem;
    font-weight: 850;
}


.timeline-item.completed .timeline-status {
    color: var(--onb-green);

    background: var(--onb-green-soft);

    border-color: #bbf7d0;
}


.timeline-item.current .timeline-status {
    color: var(--onb-blue);

    background: var(--onb-blue-soft);

    border-color: #bfdbfe;
}


.timeline-item.rejected .timeline-status {
    color: var(--onb-red);

    background: var(--onb-red-soft);

    border-color: #fecaca;
}


/* ================================================================
   SIDE STATUS CARD
================================================================ */

.status-side-card {
    align-self: start;

    padding: 22px;

    border-radius: 22px;
}


.side-card-header {
    display: flex;
    align-items: center;
    gap: 12px;

    padding-bottom: 18px;

    border-bottom: 1px solid #edf1f6;
}


.side-card-icon {
    width: 43px;
    height: 43px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 13px;
}


.side-card-header span {
    display: block;

    margin-bottom: 3px;

    color: var(--onb-light);

    font-size: .59rem;
    font-weight: 900;

    letter-spacing: .12em;
}


.side-card-header h3 {
    margin: 0;

    color: var(--onb-text);

    font-size: .92rem;
    font-weight: 850;
}


.status-message {
    display: flex;
    align-items: flex-start;
    gap: 10px;

    margin-top: 18px;
    padding: 14px;

    border-radius: 15px;

    border: 1px solid #dbeafe;

    background: var(--onb-blue-soft);
}


.message-icon {
    width: 31px;
    height: 31px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 9px;
}


.status-message strong {
    display: block;

    color: var(--onb-text);

    font-size: .76rem;
    line-height: 1.45;
}


.status-message p {
    margin: 5px 0 0;

    color: var(--onb-muted);

    font-size: .68rem;
    line-height: 1.5;
}


.status-details {
    margin-top: 17px;
}


.detail-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;

    gap: 12px;

    padding: 11px 0;

    border-bottom: 1px solid #f0f3f7;
}


.detail-row:last-child {
    border-bottom: 0;
}


.detail-row span {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    color: var(--onb-muted);

    font-size: .68rem;
    font-weight: 700;
}


.detail-row span i {
    width: 15px;

    color: var(--onb-blue);

    text-align: center;
}


.detail-row strong {
    max-width: 175px;

    overflow: hidden;

    color: var(--onb-text-2);

    font-size: .69rem;
    font-weight: 800;

    text-align: right;
    text-overflow: ellipsis;
    white-space: nowrap;
}


/* ================================================================
   ACTIVITY LOGS
================================================================ */

.logs-card {
    margin-top: 20px;

    padding: 27px;

    border-radius: 22px;
}


.logs-heading {
    align-items: center;
}


.activity-icon {
    width: 43px;
    height: 43px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 13px;

    color: var(--onb-blue);

    background: var(--onb-blue-soft);

    border: 1px solid #dbeafe;
}


.activity-list {
    padding-top: 8px;
}


.activity-item {
    display: flex;
    align-items: center;

    gap: 13px;

    padding: 15px 0;

    border-bottom: 1px solid #edf1f6;
}


.activity-item:last-child {
    border-bottom: 0;
}


.activity-marker {
    width: 34px;
    height: 34px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 11px;

    color: var(--onb-blue);

    background: var(--onb-blue-soft);

    border: 1px solid #dbeafe;

    font-size: .7rem;
}


.activity-content {
    min-width: 0;

    flex: 1;
}


.activity-main {
    display: flex;
    align-items: center;

    gap: 9px;

    flex-wrap: wrap;
}


.activity-main h3 {
    margin: 0;

    color: var(--onb-text);

    font-size: .82rem;
    font-weight: 800;

    text-transform: capitalize;
}


.activity-badge {
    padding: 4px 7px;

    border-radius: 999px;

    color: var(--onb-blue);

    background: var(--onb-blue-soft);

    font-size: .56rem;
    font-weight: 800;
}


.activity-time {
    display: flex;
    align-items: center;

    gap: 5px;

    margin-top: 5px;

    color: var(--onb-muted);

    font-size: .65rem;
}


.time-divider {
    margin: 0 2px;

    color: #cbd5e1;
}


/* ================================================================
   EMPTY ACTIVITY
================================================================ */

.empty-activity-card {
    display: flex;
    align-items: center;

    gap: 15px;

    margin-top: 20px;

    padding: 22px;

    border-radius: 20px;
}


.empty-icon {
    width: 45px;
    height: 45px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 13px;

    color: var(--onb-blue);

    background: var(--onb-blue-soft);

    font-size: 1rem;
}


.empty-activity-card h3 {
    margin: 0 0 4px;

    color: var(--onb-text);

    font-size: .9rem;
    font-weight: 850;
}


.empty-activity-card p {
    margin: 0;

    color: var(--onb-muted);

    font-size: .72rem;
    line-height: 1.55;
}


/* ================================================================
   SECURITY FOOTER
================================================================ */

.security-footer {
    display: flex;
    align-items: center;

    gap: 13px;

    margin-top: 20px;
    padding: 16px 18px;

    border-radius: 17px;

    background:
        linear-gradient(
            135deg,
            #f8fbff,
            #eff6ff
        );

    border: 1px solid #dbeafe;
}


.security-footer-icon {
    width: 37px;
    height: 37px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 11px;

    color: var(--onb-blue);

    background: #ffffff;

    border: 1px solid #dbeafe;
}


.security-footer strong {
    display: block;

    color: var(--onb-text);

    font-size: .76rem;
    font-weight: 850;
}


.security-footer p {
    margin: 3px 0 0;

    color: var(--onb-muted);

    font-size: .66rem;
    line-height: 1.5;
}


.secure-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;

    margin-left: auto;

    padding: 7px 10px;

    flex-shrink: 0;

    border-radius: 999px;

    color: var(--onb-green);

    background: #ffffff;

    border: 1px solid #bbf7d0;

    font-size: .62rem;
    font-weight: 850;
}


/* ================================================================
   RESPONSIVE
================================================================ */

@media (max-width: 1200px) {

    .overview-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .progress-card {
        grid-column: span 2;
    }

    .onboarding-content {
        grid-template-columns: minmax(0, 1fr);
    }

    .status-side-card {
        width: 100%;
    }

}


@media (max-width: 800px) {

    .seller-onboarding-page {
        padding: 18px 16px 35px;
    }

    .onboarding-hero {
        padding: 25px 22px;

        flex-direction: column;
        align-items: flex-start;
    }

    .hero-status {
        width: 100%;
        min-width: 0;
    }

    .overview-grid {
        grid-template-columns: 1fr;
    }

    .progress-card {
        grid-column: auto;
    }

}


@media (max-width: 600px) {

    .seller-onboarding-page {
        padding: 12px 10px 28px;
    }

    .onboarding-hero {
        border-radius: 19px;
        padding: 21px 18px;
    }

    .hero-title-row {
        align-items: flex-start;
        gap: 11px;
    }

    .hero-icon {
        width: 46px;
        height: 46px;

        border-radius: 13px;

        font-size: 1rem;
    }

    .onboarding-hero h1 {
        font-size: 1.75rem;
    }

    .onboarding-hero p {
        font-size: .78rem;
    }

    .hero-kicker {
        font-size: .58rem;
        letter-spacing: .11em;
    }

    .verification-card,
    .logs-card {
        padding: 19px;
        border-radius: 18px;
    }

    .card-heading {
        flex-direction: column;
        gap: 12px;
    }

    .step-count-badge {
        align-self: flex-start;
    }

    .timeline-item {
        grid-template-columns: 39px minmax(0, 1fr);
        gap: 11px;
    }

    .timeline-marker {
        width: 32px;
        height: 32px;
    }

    .timeline-line {
        top: 32px;
    }

    .timeline-top {
        flex-direction: column;
        gap: 7px;
    }

    .timeline-status {
        align-self: flex-start;
    }

    .timeline-content {
        padding-bottom: 21px;
    }

    .status-side-card {
        padding: 19px;
        border-radius: 18px;
    }

    .security-footer {
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .secure-badge {
        margin-left: 50px;
    }

}


@media (max-width: 420px) {

    .hero-status {
        padding: 12px;
    }

    .overview-card {
        padding: 18px;
    }

    .progress-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 3px;
    }

    .detail-row {
        flex-direction: column;
        gap: 4px;
    }

    .detail-row strong {
        max-width: 100%;

        text-align: left;
        white-space: normal;
    }

    .activity-item {
        align-items: flex-start;
    }

    .activity-main {
        align-items: flex-start;
        flex-direction: column;
        gap: 5px;
    }

    .secure-badge {
        margin-left: 50px;
    }

}


/* ================================================================
   ACCESSIBILITY / REDUCED MOTION
================================================================ */

.timeline-marker,
.overview-card,
.activity-marker,
.hero-status {
    -webkit-tap-highlight-color: transparent;
}


@media (prefers-reduced-motion: reduce) {

    *,
    *::before,
    *::after {
        scroll-behavior: auto !important;
        transition: none !important;
        animation: none !important;
    }

}

</style>

@endpush

</x-seller-verification.layout>