<x-seller-verification.layout :seller="$seller">

@php
    $steps = [
        'Account Created',
        'Email Verified',
        'Business Documents Uploaded',
        'Application Submitted',
        'Admin Review',
        'Application Approved',
        'Seller Activation',
        'Seller Dashboard',
    ];

    $status = $seller->verification_status;

    /*
    |--------------------------------------------------------------------------
    | IMPORTANT:
    | Step display is controlled by verification_status.
    | onboarding_step is NOT used here because the database may still contain
    | an old/default value such as 1.
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
            => 'Verify your email.',

        'email_verified'
            => 'Upload your business documents.',

        'documents_pending'
            => 'Submit your application for review.',

        'aadhaar_pending'
            => 'Complete Aadhaar verification.',

        'aadhaar_verified'
            => 'Submit your application for admin review.',

        'pending_admin_review'
            => 'Application submitted. Waiting for admin review.',

        'approved'
            => 'Application approved. Enter your activation code.',

        'active'
            => 'Your seller account is active.',

        'rejected'
            => 'Your application was rejected. Please review and resubmit.',

        default
            => 'Review your application status.',
    };
@endphp

<div class="seller-onboarding-page">

    <h2>Seller Onboarding</h2>

    <p>
        Current status:
        <strong>{{ str_replace('_', ' ', $status) }}</strong>
    </p>

    <p>{{ $next }}</p>

    <ol style="line-height: 2.4; list-style: none; padding-left: 0;">

        @foreach($steps as $index => $step)

            @php
                $stepNumber = $index + 1;

                if ($status === 'rejected') {
                    $icon = $stepNumber === $current ? '✕' : '○';
                } elseif ($stepNumber < $current) {
                    $icon = '✓';
                } elseif ($stepNumber === $current) {
                    $icon = '●';
                } else {
                    $icon = '○';
                }
            @endphp

            <li>
                <span style="font-weight: 700;">
                    {{ $icon }}
                </span>

                {{ $step }}
            </li>

        @endforeach

    </ol>

    @if($logs->isNotEmpty())

        <h3>Verification Timeline</h3>

        <ul>
            @foreach($logs as $log)
                <li>
                    {{ str_replace('_', ' ', $log->event) }}
                    —
                    {{ $log->created_at->format('d M Y, H:i') }}
                </li>
            @endforeach
        </ul>

    @endif

</div>

</x-seller-verification.layout>