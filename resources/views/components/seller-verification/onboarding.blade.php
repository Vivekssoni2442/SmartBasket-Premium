<x-seller-verification.layout :seller="$seller">

@php
    /*
    |--------------------------------------------------------------------------
    | Seller Onboarding Steps
    |--------------------------------------------------------------------------
    */
    $steps = [
        1 => 'Account Created',
        2 => 'Email Verified',
        3 => 'Business Documents Uploaded',
        4 => 'Application Submitted',
        5 => 'Admin Review',
        6 => 'Application Approved',
        7 => 'Seller Activation',
        8 => 'Seller Dashboard',
    ];

    $status = $seller->verification_status;

    /*
    |--------------------------------------------------------------------------
    | IMPORTANT:
    | Database onboarding_step is the primary source.
    |--------------------------------------------------------------------------
    */
    $currentStep = (int) ($seller->onboarding_step ?? 1);

    /*
    |--------------------------------------------------------------------------
    | Status based correction
    |--------------------------------------------------------------------------
    | This prevents old/wrong onboarding_step values from showing an
    | incorrect step.
    |--------------------------------------------------------------------------
    */

    switch ($status) {

        case 'pending_email_verification':
            $currentStep = 1;
            break;

        case 'email_verified':
            $currentStep = 2;
            break;

        case 'documents_pending':
        case 'aadhaar_pending':
        case 'aadhaar_verified':
            $currentStep = 3;
            break;

        case 'pending_admin_review':
            $currentStep = 5;
            break;

        case 'approved':
            $currentStep = 7;
            break;

        case 'active':
            $currentStep = 8;
            break;

        case 'rejected':
            /*
             * Rejected applications remain around the review stage.
             */
            $currentStep = 5;
            break;

        default:
            $currentStep = max(1, min(8, $currentStep));
            break;
    }

    /*
    |--------------------------------------------------------------------------
    | Message
    |--------------------------------------------------------------------------
    */

    $nextMessage = match ($status) {

        'pending_email_verification'
            => 'Please verify your email address to continue.',

        'email_verified'
            => 'Your email is verified. Please upload your business documents.',

        'documents_pending'
            => 'Your documents are uploaded. Please submit your application for review.',

        'aadhaar_pending'
            => 'Please complete Aadhaar verification.',

        'aadhaar_verified'
            => 'Your Aadhaar is verified. Your application is ready for review.',

        'pending_admin_review'
            => 'Your application has been submitted and is currently waiting for admin review.',

        'approved'
            => 'Your application has been approved. Enter your activation code to activate your seller account.',

        'active'
            => 'Your seller account is active. You can now access your seller dashboard.',

        'rejected'
            => 'Your application was rejected. Please review the reason and update your information.',

        default
            => 'Please review your seller application status.',
    };

    $statusLabel = ucwords(str_replace('_', ' ', $status));
@endphp


<style>
    .seller-onboarding-page {
        max-width: 1000px;
        margin: 0 auto;
        padding: 30px 20px 60px;
    }

    .onboarding-header {
        margin-bottom: 30px;
    }

    .onboarding-header h2 {
        margin: 0 0 8px;
        font-size: 30px;
        font-weight: 800;
    }

    .onboarding-header p {
        margin: 0;
        opacity: .75;
    }

    .status-card {
        padding: 20px;
        border-radius: 18px;
        margin-bottom: 30px;
        border: 1px solid rgba(127,127,127,.18);
        background: rgba(127,127,127,.06);
    }

    .status-title {
        font-size: 14px;
        opacity: .65;
        margin-bottom: 6px;
    }

    .status-value {
        font-size: 22px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .status-message {
        margin: 0;
        line-height: 1.6;
        opacity: .8;
    }

    .progress-wrapper {
        margin-bottom: 35px;
    }

    .progress-bar {
        height: 8px;
        width: 100%;
        border-radius: 20px;
        background: rgba(127,127,127,.15);
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 20px;
        background: currentColor;
        transition: width .3s ease;
    }

    .progress-text {
        margin-top: 8px;
        font-size: 13px;
        opacity: .65;
    }

    .steps {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .step {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        position: relative;
        padding-bottom: 25px;
    }

    .step:last-child {
        padding-bottom: 0;
    }

    .step-marker {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        border: 2px solid rgba(127,127,127,.3);
        background: transparent;
        position: relative;
        z-index: 2;
    }

    .step.completed .step-marker {
        background: #22c55e;
        color: white;
        border-color: #22c55e;
    }

    .step.current .step-marker {
        background: #2563eb;
        color: white;
        border-color: #2563eb;
        box-shadow: 0 0 0 5px rgba(37,99,235,.12);
    }

    .step.rejected .step-marker {
        background: #ef4444;
        color: white;
        border-color: #ef4444;
    }

    .step-content {
        padding-top: 5px;
    }

    .step-title {
        font-weight: 750;
        font-size: 16px;
    }

    .step-subtitle {
        margin-top: 3px;
        font-size: 13px;
        opacity: .6;
    }

    .step-line {
        position: absolute;
        left: 18px;
        top: 38px;
        width: 2px;
        height: calc(100% - 38px);
        background: rgba(127,127,127,.2);
    }

    .step.completed .step-line {
        background: #22c55e;
    }

    .timeline {
        margin-top: 45px;
        padding: 22px;
        border-radius: 18px;
        border: 1px solid rgba(127,127,127,.18);
        background: rgba(127,127,127,.04);
    }

    .timeline h3 {
        margin: 0 0 18px;
    }

    .timeline-item {
        padding: 12px 0;
        border-bottom: 1px solid rgba(127,127,127,.12);
    }

    .timeline-item:last-child {
        border-bottom: 0;
    }

    .timeline-event {
        font-weight: 700;
    }

    .timeline-date {
        font-size: 12px;
        opacity: .55;
        margin-top: 4px;
    }

    @media (max-width: 600px) {
        .seller-onboarding-page {
            padding: 20px 14px 40px;
        }

        .onboarding-header h2 {
            font-size: 24px;
        }

        .step-title {
            font-size: 15px;
        }
    }
</style>


<div class="seller-onboarding-page">

    <div class="onboarding-header">
        <h2>Seller Onboarding</h2>

        <p>
            Complete all verification steps to activate your seller account.
        </p>
    </div>


    {{-- CURRENT STATUS --}}

    <div class="status-card">

        <div class="status-title">
            Current Status
        </div>

        <div class="status-value">
            {{ $statusLabel }}
        </div>

        <p class="status-message">
            {{ $nextMessage }}
        </p>

    </div>


    {{-- PROGRESS --}}

    @php
        $progress = (($currentStep - 1) / 7) * 100;
    @endphp

    <div class="progress-wrapper">

        <div class="progress-bar">
            <div
                class="progress-fill"
                style="width: {{ $progress }}%;"
            ></div>
        </div>

        <div class="progress-text">
            Step {{ $currentStep }} of {{ count($steps) }}
        </div>

    </div>


    {{-- STEPS --}}

    <ol class="steps">

        @foreach($steps as $stepNumber => $stepName)

            @php

                if ($status === 'rejected' && $stepNumber === 5) {

                    $stepClass = 'rejected';

                    $marker = '✕';

                } elseif ($stepNumber < $currentStep) {

                    $stepClass = 'completed';

                    $marker = '✓';

                } elseif ($stepNumber === $currentStep) {

                    $stepClass = 'current';

                    $marker = '●';

                } else {

                    $stepClass = '';

                    $marker = '○';
                }

            @endphp


            <li class="step {{ $stepClass }}">

                <div class="step-marker">
                    {{ $marker }}
                </div>


                <div class="step-content">

                    <div class="step-title">
                        {{ $stepName }}
                    </div>

                    <div class="step-subtitle">

                        @if($stepNumber < $currentStep)
                            Completed

                        @elseif($stepNumber === $currentStep)

                            @if($status === 'pending_admin_review')
                                Waiting for admin review
                            @elseif($status === 'approved')
                                Activation required
                            @elseif($status === 'active')
                                Completed
                            @elseif($status === 'rejected')
                                Action required
                            @else
                                Current step
                            @endif

                        @else
                            Upcoming
                        @endif

                    </div>

                </div>


                @if($stepNumber < count($steps))
                    <div class="step-line"></div>
                @endif

            </li>

        @endforeach

    </ol>


    {{-- VERIFICATION TIMELINE --}}

    @if($logs->isNotEmpty())

        <div class="timeline">

            <h3>
                Verification Timeline
            </h3>

            @foreach($logs as $log)

                <div class="timeline-item">

                    <div class="timeline-event">
                        {{ ucwords(str_replace('_', ' ', $log->event)) }}
                    </div>

                    <div class="timeline-date">
                        {{ $log->created_at->format('d M Y, H:i') }}
                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

</x-seller-verification.layout>