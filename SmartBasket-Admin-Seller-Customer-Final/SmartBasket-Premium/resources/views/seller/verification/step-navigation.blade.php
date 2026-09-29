@php
    /*
    |--------------------------------------------------------------------------
    | CURRENT STEP
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | The current page/route decides the active step.
    | Do NOT calculate the active step from uploaded documents.
    |
    */

    $routeName = request()->route()?->getName();

    $routeToStep = [
        'seller.verification.email' => 1,

        'seller.verification.documents' => 2,

        'seller.verification.aadhaar' => 3,

        'seller.verification.review' => 4,

        'seller.verification.status' => 5,

        'seller.activation' => 6,

        // Compatibility routes
        'seller.verification.business-details' => 2,
        'seller.verification.business-details.update' => 2,

        'seller.verification.bank-details' => 4,
        'seller.verification.bank-details.update' => 4,
    ];

    /*
    |--------------------------------------------------------------------------
    | Determine current step from CURRENT PAGE
    |--------------------------------------------------------------------------
    */

    $currentStep = $routeToStep[$routeName] ?? null;

    /*
    |--------------------------------------------------------------------------
    | Fallback only when current route has no mapping
    |--------------------------------------------------------------------------
    */

    if (!$currentStep) {
        $currentStep = (int) ($seller->onboarding_step ?? 1);

        if ($currentStep < 1) {
            $currentStep = 1;
        }

        if ($currentStep > 6) {
            $currentStep = 6;
        }
    }

    $currentStep = min(max($currentStep, 1), 6);

    /*
    |--------------------------------------------------------------------------
    | Six Seller Onboarding Steps
    |--------------------------------------------------------------------------
    */

    $steps = [
        1 => [
            'title' => 'Email',
            'subtitle' => 'Verify email',
            'icon' => 'fa-envelope',
            'route' => 'seller.verification.email',
        ],

        2 => [
            'title' => 'Documents',
            'subtitle' => 'Upload documents',
            'icon' => 'fa-file-shield',
            'route' => 'seller.verification.documents',
        ],

        3 => [
            'title' => 'Aadhaar',
            'subtitle' => 'Identity verification',
            'icon' => 'fa-id-card',
            'route' => 'seller.verification.aadhaar',
        ],

        4 => [
            'title' => 'Review',
            'subtitle' => 'Check details',
            'icon' => 'fa-clipboard-check',
            'route' => 'seller.verification.review',
        ],

        5 => [
            'title' => 'Approval',
            'subtitle' => 'Application status',
            'icon' => 'fa-circle-check',
            'route' => 'seller.verification.status',
        ],

        6 => [
            'title' => 'Activation',
            'subtitle' => 'Start selling',
            'icon' => 'fa-rocket',
            'route' => 'seller.activation',
        ],
    ];

    /*
    |--------------------------------------------------------------------------
    | Previously visited steps can be opened again
    |--------------------------------------------------------------------------
    */

    $canOpenStep = function (int $number) use ($currentStep) {
        return $number <= $currentStep;
    };

    /*
    |--------------------------------------------------------------------------
    | Back Routes
    |--------------------------------------------------------------------------
    */

    $backRoutes = [
        1 => null,
        2 => 'seller.verification.email',
        3 => 'seller.verification.documents',
        4 => 'seller.verification.aadhaar',
        5 => 'seller.verification.review',
        6 => 'seller.verification.status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Next Routes
    |--------------------------------------------------------------------------
    */

    $nextRoutes = [
        1 => 'seller.verification.documents',
        2 => 'seller.verification.aadhaar',
        3 => 'seller.verification.review',
        4 => 'seller.verification.status',
        5 => 'seller.activation',
        6 => null,
    ];

    $backRoute = $backRoutes[$currentStep] ?? null;
    $nextRoute = $nextRoutes[$currentStep] ?? null;

    /*
    |--------------------------------------------------------------------------
    | Progress
    |--------------------------------------------------------------------------
    */

    $progressPercentage = ($currentStep / 6) * 100;
@endphp


<style>
    /*
    |--------------------------------------------------------------------------
    | SMART BASKET — SELLER VERIFICATION WIZARD
    | LIGHT PREMIUM / BLUE + WHITE
    |--------------------------------------------------------------------------
    */

    .sb-wizard,
    .sb-wizard * {
        box-sizing: border-box;
    }

    .sb-wizard {
        --sb-primary: #2563eb;
        --sb-primary-dark: #1d4ed8;
        --sb-primary-deep: #1e40af;
        --sb-blue: #3b82f6;
        --sb-blue-soft: #eff6ff;
        --sb-blue-soft-2: #dbeafe;
        --sb-blue-border: #bfdbfe;

        --sb-green: #16a34a;
        --sb-green-soft: #f0fdf4;
        --sb-green-border: #bbf7d0;

        --sb-text: #0f172a;
        --sb-text-2: #334155;
        --sb-muted: #64748b;
        --sb-muted-2: #94a3b8;

        --sb-border: #e2e8f0;
        --sb-border-soft: #edf2f7;

        width: 100%;
        margin: 0 0 30px;
        color: var(--sb-text);
        font-family:
            Inter,
            ui-sans-serif,
            system-ui,
            -apple-system,
            BlinkMacSystemFont,
            "Segoe UI",
            sans-serif;
    }


    /*
    |--------------------------------------------------------------------------
    | MAIN WIZARD CARD
    |--------------------------------------------------------------------------
    */

    .sb-wizard-shell {
        width: 100%;
        position: relative;
        overflow: hidden;

        padding: 24px;

        border: 1px solid var(--sb-border);

        border-radius: 24px;

        background:
            radial-gradient(
                circle at 100% 0%,
                rgba(59, 130, 246, .10),
                transparent 30%
            ),
            radial-gradient(
                circle at 0% 100%,
                rgba(37, 99, 235, .06),
                transparent 30%
            ),
            #ffffff;

        box-shadow:
            0 18px 50px rgba(15, 23, 42, .07),
            0 4px 16px rgba(15, 23, 42, .035);
    }


    /*
    |--------------------------------------------------------------------------
    | TOP HEADER
    |--------------------------------------------------------------------------
    */

    .sb-wizard-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;

        margin-bottom: 22px;
    }

    .sb-wizard-brand {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .sb-wizard-logo {
        width: 50px;
        height: 50px;
        flex: 0 0 50px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 15px;

        background:
            linear-gradient(
                135deg,
                var(--sb-primary),
                var(--sb-primary-deep)
            );

        color: #ffffff;

        font-size: 15px;
        font-weight: 900;
        letter-spacing: .5px;

        box-shadow:
            0 12px 26px rgba(37, 99, 235, .22);
    }

    .sb-wizard-heading {
        min-width: 0;
    }

    .sb-wizard-title {
        color: var(--sb-text);

        font-size: 18px;
        line-height: 1.25;
        font-weight: 850;

        letter-spacing: -.2px;
    }

    .sb-wizard-subtitle {
        margin-top: 4px;

        color: var(--sb-muted);

        font-size: 12px;
        line-height: 1.4;

        font-weight: 600;

        letter-spacing: .3px;
        text-transform: uppercase;
    }

    .sb-step-count {
        flex: 0 0 auto;

        display: inline-flex;
        align-items: center;
        gap: 8px;

        min-height: 38px;

        padding: 8px 13px;

        border: 1px solid var(--sb-blue-border);
        border-radius: 12px;

        background: var(--sb-blue-soft);

        color: var(--sb-primary-deep);

        font-size: 13px;
        font-weight: 800;

        white-space: nowrap;
    }

    .sb-step-count-dot {
        width: 7px;
        height: 7px;

        border-radius: 50%;

        background: var(--sb-primary);

        box-shadow:
            0 0 0 4px rgba(37, 99, 235, .10);
    }


    /*
    |--------------------------------------------------------------------------
    | PROGRESS AREA
    |--------------------------------------------------------------------------
    */

    .sb-progress-wrapper {
        width: 100%;
        margin-bottom: 22px;
    }

    .sb-progress-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;

        margin-bottom: 8px;
    }

    .sb-progress-label {
        color: var(--sb-text-2);

        font-size: 11px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .55px;
    }

    .sb-progress-percent {
        color: var(--sb-primary);

        font-size: 12px;
        font-weight: 850;
    }

    .sb-progress {
        position: relative;

        width: 100%;
        height: 7px;

        overflow: hidden;

        border-radius: 999px;

        background: #eaf0f8;

        box-shadow:
            inset 0 1px 2px rgba(15, 23, 42, .04);
    }

    .sb-progress-fill {
        height: 100%;

        border-radius: inherit;

        background:
            linear-gradient(
                90deg,
                var(--sb-primary),
                var(--sb-blue)
            );

        box-shadow:
            0 2px 8px rgba(37, 99, 235, .20);

        transition:
            width .45s cubic-bezier(.22, .61, .36, 1);
    }


    /*
    |--------------------------------------------------------------------------
    | STEP GRID
    |--------------------------------------------------------------------------
    */

    .sb-steps {
        display: grid;

        grid-template-columns:
            repeat(6, minmax(0, 1fr));

        gap: 10px;

        width: 100%;
    }

    .sb-step {
        position: relative;
        min-width: 0;
    }

    .sb-step-link {
        position: relative;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        min-height: 112px;

        padding: 14px 10px;

        border: 1px solid var(--sb-border);

        border-radius: 17px;

        background:
            linear-gradient(
                180deg,
                #ffffff,
                #fbfdff
            );

        color: var(--sb-text);

        text-decoration: none;

        transition:
            transform .22s ease,
            border-color .22s ease,
            background .22s ease,
            box-shadow .22s ease;
    }

    .sb-step-link:hover {
        transform: translateY(-2px);

        border-color: var(--sb-blue-border);

        background:
            linear-gradient(
                180deg,
                #ffffff,
                var(--sb-blue-soft)
            );

        box-shadow:
            0 10px 25px rgba(37, 99, 235, .09);
    }

    .sb-step-number {
        position: relative;

        width: 40px;
        height: 40px;

        margin-bottom: 9px;

        display: flex;
        align-items: center;
        justify-content: center;

        border: 1px solid #dbe4ef;

        border-radius: 50%;

        background: #f8fafc;

        color: var(--sb-muted);

        font-size: 13px;
        font-weight: 850;

        transition:
            background .22s ease,
            border-color .22s ease,
            color .22s ease,
            box-shadow .22s ease,
            transform .22s ease;
    }

    .sb-step-number i {
        font-size: 14px;
    }

    .sb-step-title {
        max-width: 100%;

        color: var(--sb-text-2);

        font-size: 12px;
        line-height: 1.25;

        font-weight: 800;

        text-align: center;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sb-step-subtitle {
        max-width: 100%;

        margin-top: 4px;

        color: var(--sb-muted-2);

        font-size: 9px;
        line-height: 1.25;

        font-weight: 600;

        text-align: center;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVE STEP
    |--------------------------------------------------------------------------
    */

    .sb-step.active .sb-step-link {
        border-color: var(--sb-primary);

        background:
            linear-gradient(
                180deg,
                #ffffff 0%,
                #f4f8ff 100%
            );

        box-shadow:
            0 12px 30px rgba(37, 99, 235, .12),
            inset 0 0 0 1px rgba(37, 99, 235, .05);
    }

    .sb-step.active .sb-step-link::before {
        content: "";

        position: absolute;

        top: -1px;
        left: 18px;
        right: 18px;

        height: 3px;

        border-radius: 0 0 999px 999px;

        background:
            linear-gradient(
                90deg,
                var(--sb-primary),
                var(--sb-blue)
            );
    }

    .sb-step.active .sb-step-number {
        border-color: var(--sb-primary);

        background:
            linear-gradient(
                135deg,
                var(--sb-primary),
                var(--sb-primary-deep)
            );

        color: #ffffff;

        box-shadow:
            0 8px 18px rgba(37, 99, 235, .22);

        transform: scale(1.04);
    }

    .sb-step.active .sb-step-title {
        color: var(--sb-primary-deep);
    }

    .sb-step.active .sb-step-subtitle {
        color: var(--sb-primary);
    }


    /*
    |--------------------------------------------------------------------------
    | COMPLETED STEP
    |--------------------------------------------------------------------------
    */

    .sb-step.completed .sb-step-link {
        border-color: var(--sb-green-border);

        background:
            linear-gradient(
                180deg,
                #ffffff,
                var(--sb-green-soft)
            );
    }

    .sb-step.completed .sb-step-link:hover {
        border-color: #86efac;

        box-shadow:
            0 10px 24px rgba(22, 163, 74, .09);
    }

    .sb-step.completed .sb-step-number {
        border-color: var(--sb-green-border);

        background: var(--sb-green-soft);

        color: var(--sb-green);

        box-shadow:
            0 5px 14px rgba(22, 163, 74, .08);
    }

    .sb-step.completed .sb-step-title {
        color: #166534;
    }

    .sb-step.completed .sb-step-subtitle {
        color: #4d7c5a;
    }


    /*
    |--------------------------------------------------------------------------
    | LOCKED STEP
    |--------------------------------------------------------------------------
    */

    .sb-step.locked .sb-step-link {
        cursor: not-allowed;

        background: #f8fafc;

        opacity: .68;
    }

    .sb-step.locked .sb-step-number {
        background: #f1f5f9;

        color: #a0aec0;

        border-color: #e2e8f0;
    }

    .sb-step.locked .sb-step-title {
        color: #94a3b8;
    }

    .sb-step.locked .sb-step-subtitle {
        color: #b0bac7;
    }


    /*
    |--------------------------------------------------------------------------
    | NAVIGATION
    |--------------------------------------------------------------------------
    */

    .sb-navigation {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            minmax(0, 1fr);

        gap: 12px;

        margin-top: 20px;

        padding-top: 20px;

        border-top: 1px solid var(--sb-border-soft);
    }

    .sb-nav-btn {
        min-height: 48px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;

        padding: 11px 18px;

        border: 1px solid var(--sb-border);

        border-radius: 13px;

        background: #ffffff;

        color: var(--sb-text-2);

        text-decoration: none;

        font-size: 13px;
        font-weight: 850;

        transition:
            transform .2s ease,
            background .2s ease,
            border-color .2s ease,
            box-shadow .2s ease,
            color .2s ease;
    }

    .sb-nav-btn:hover {
        transform: translateY(-1px);

        border-color: var(--sb-blue-border);

        background: var(--sb-blue-soft);

        color: var(--sb-primary-deep);

        box-shadow:
            0 8px 20px rgba(37, 99, 235, .08);
    }

    .sb-nav-btn.primary {
        border-color: var(--sb-primary);

        background:
            linear-gradient(
                135deg,
                var(--sb-primary),
                var(--sb-primary-deep)
            );

        color: #ffffff;

        box-shadow:
            0 10px 22px rgba(37, 99, 235, .18);
    }

    .sb-nav-btn.primary:hover {
        border-color: var(--sb-primary-dark);

        background:
            linear-gradient(
                135deg,
                var(--sb-primary-dark),
                var(--sb-primary-deep)
            );

        color: #ffffff;

        box-shadow:
            0 13px 26px rgba(37, 99, 235, .23);
    }

    .sb-nav-btn.disabled {
        opacity: .48;

        cursor: not-allowed;
        pointer-events: none;

        background: #f8fafc;
    }

    .sb-nav-icon {
        font-size: 13px;
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT NOTE
    |--------------------------------------------------------------------------
    */

    .sb-edit-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        margin-top: 14px;

        color: var(--sb-muted);

        font-size: 11px;
        font-weight: 600;

        text-align: center;
    }

    .sb-edit-note i {
        color: var(--sb-green);

        font-size: 12px;
    }


    /*
    |--------------------------------------------------------------------------
    | SECURITY / INFO STRIP
    |--------------------------------------------------------------------------
    */

    .sb-wizard-info {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        margin-top: 15px;

        padding: 9px 12px;

        border: 1px solid var(--sb-blue-border);

        border-radius: 11px;

        background: var(--sb-blue-soft);

        color: #36598f;

        font-size: 10px;
        font-weight: 650;

        text-align: center;
    }

    .sb-wizard-info i {
        color: var(--sb-primary);

        font-size: 11px;
    }


    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE — 1180px
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1180px) {

        .sb-wizard-shell {
            padding: 20px;
        }

        .sb-steps {
            gap: 8px;
        }

        .sb-step-link {
            min-height: 105px;
            padding: 12px 7px;
        }

        .sb-step-number {
            width: 38px;
            height: 38px;

            margin-bottom: 8px;
        }

        .sb-step-title {
            font-size: 11px;
        }

        .sb-step-subtitle {
            font-size: 8px;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE — 900px
    |--------------------------------------------------------------------------
    */

    @media (max-width: 900px) {

        .sb-steps {
            grid-template-columns:
                repeat(3, minmax(0, 1fr));
        }

        .sb-step-link {
            min-height: 108px;
        }

        .sb-step-title {
            font-size: 12px;
        }

        .sb-step-subtitle {
            font-size: 9px;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE — 680px
    |--------------------------------------------------------------------------
    */

    @media (max-width: 680px) {

        .sb-wizard {
            margin-bottom: 22px;
        }

        .sb-wizard-shell {
            padding: 16px;

            border-radius: 20px;
        }

        .sb-wizard-header {
            align-items: flex-start;

            margin-bottom: 18px;
        }

        .sb-wizard-logo {
            width: 44px;
            height: 44px;
            flex-basis: 44px;

            border-radius: 13px;

            font-size: 13px;
        }

        .sb-wizard-title {
            font-size: 16px;
        }

        .sb-wizard-subtitle {
            font-size: 10px;
        }

        .sb-step-count {
            min-height: 34px;

            padding: 7px 10px;

            font-size: 11px;
        }

        .sb-progress-wrapper {
            margin-bottom: 18px;
        }

        .sb-progress {
            height: 6px;
        }

        .sb-navigation {
            gap: 9px;
        }

        .sb-nav-btn {
            min-height: 45px;

            padding: 10px 12px;

            font-size: 12px;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE — 480px
    |--------------------------------------------------------------------------
    */

    @media (max-width: 480px) {

        .sb-wizard-shell {
            padding: 13px;

            border-radius: 18px;
        }

        .sb-wizard-header {
            gap: 10px;
        }

        .sb-wizard-brand {
            gap: 10px;
        }

        .sb-wizard-logo {
            width: 40px;
            height: 40px;
            flex-basis: 40px;

            border-radius: 12px;

            font-size: 12px;
        }

        .sb-wizard-title {
            font-size: 14px;
        }

        .sb-wizard-subtitle {
            font-size: 9px;

            letter-spacing: .15px;
        }

        .sb-step-count {
            padding: 6px 8px;

            font-size: 10px;
        }

        .sb-step-count-dot {
            width: 5px;
            height: 5px;
        }

        .sb-steps {
            gap: 6px;
        }

        .sb-step-link {
            min-height: 94px;

            padding: 9px 4px;

            border-radius: 13px;
        }

        .sb-step-number {
            width: 32px;
            height: 32px;

            margin-bottom: 6px;

            font-size: 11px;
        }

        .sb-step-number i {
            font-size: 11px;
        }

        .sb-step-title {
            font-size: 10px;
        }

        .sb-step-subtitle {
            display: none;
        }

        .sb-step.active .sb-step-link::before {
            left: 10px;
            right: 10px;
        }

        .sb-navigation {
            grid-template-columns:
                minmax(0, 1fr)
                minmax(0, 1fr);

            gap: 7px;

            margin-top: 16px;
            padding-top: 16px;
        }

        .sb-nav-btn {
            min-height: 42px;

            padding: 8px 6px;

            border-radius: 11px;

            font-size: 11px;
        }

        .sb-edit-note {
            font-size: 9px;

            line-height: 1.4;
        }

        .sb-wizard-info {
            font-size: 9px;

            line-height: 1.4;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | VERY SMALL DEVICES
    |--------------------------------------------------------------------------
    */

    @media (max-width: 360px) {

        .sb-wizard-header {
            flex-direction: column;
        }

        .sb-step-count {
            align-self: flex-start;
        }

        .sb-step-link {
            min-height: 88px;
        }

        .sb-step-title {
            font-size: 9px;
        }

        .sb-nav-btn {
            font-size: 10px;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | REDUCED MOTION
    |--------------------------------------------------------------------------
    */

    @media (prefers-reduced-motion: reduce) {

        .sb-wizard *,
        .sb-wizard *::before,
        .sb-wizard *::after {
            scroll-behavior: auto !important;
            transition: none !important;
            animation: none !important;
        }
    }
</style>


<div class="sb-wizard">

    <div class="sb-wizard-shell">

        {{-- ================================================================
             HEADER
        ================================================================= --}}

        <div class="sb-wizard-header">

            <div class="sb-wizard-brand">

                <div class="sb-wizard-logo" aria-hidden="true">
                    SB
                </div>

                <div class="sb-wizard-heading">

                    <div class="sb-wizard-title">
                        Seller Partner Program
                    </div>

                    <div class="sb-wizard-subtitle">
                        Smart Basket Premium · Seller Onboarding
                    </div>

                </div>

            </div>


            <div class="sb-step-count">

                <span class="sb-step-count-dot"></span>

                <span>
                    Step {{ $currentStep }} of 6
                </span>

            </div>

        </div>


        {{-- ================================================================
             PROGRESS
        ================================================================= --}}

        <div class="sb-progress-wrapper">

            <div class="sb-progress-meta">

                <div class="sb-progress-label">
                    Application Progress
                </div>

                <div class="sb-progress-percent">
                    {{ (int) $progressPercentage }}%
                </div>

            </div>

            <div
                class="sb-progress"
                role="progressbar"
                aria-valuemin="1"
                aria-valuemax="6"
                aria-valuenow="{{ $currentStep }}"
                aria-label="Seller onboarding progress"
            >

                <div
                    class="sb-progress-fill"
                    style="width: {{ $progressPercentage }}%;"
                ></div>

            </div>

        </div>


        {{-- ================================================================
             STEP CARDS
        ================================================================= --}}

        <div class="sb-steps">

            @foreach($steps as $number => $step)

                @php
                    $completed = $number < $currentStep;
                    $active = $number === $currentStep;
                    $allowed = $canOpenStep($number);
                    $locked = !$allowed;
                @endphp

                <div
                    class="
                        sb-step
                        {{ $active ? 'active' : '' }}
                        {{ $completed ? 'completed' : '' }}
                        {{ $locked ? 'locked' : '' }}
                    "
                >

                    @if($allowed)

                        <a
                            href="{{ route($step['route']) }}"
                            class="sb-step-link"
                            title="Open {{ $step['title'] }} step"
                            aria-current="{{ $active ? 'step' : 'false' }}"
                        >

                            <div class="sb-step-number">

                                @if($completed)

                                    <i
                                        class="fa-solid fa-check"
                                        aria-hidden="true"
                                    ></i>

                                @elseif($active)

                                    <i
                                        class="fa-solid {{ $step['icon'] }}"
                                        aria-hidden="true"
                                    ></i>

                                @else

                                    {{ $number }}

                                @endif

                            </div>


                            <div class="sb-step-title">
                                {{ $step['title'] }}
                            </div>


                            <div class="sb-step-subtitle">
                                {{ $step['subtitle'] }}
                            </div>

                        </a>

                    @else

                        <div
                            class="sb-step-link"
                            aria-disabled="true"
                            title="Complete previous steps first"
                        >

                            <div class="sb-step-number">

                                <i
                                    class="fa-solid fa-lock"
                                    aria-hidden="true"
                                ></i>

                            </div>


                            <div class="sb-step-title">
                                {{ $step['title'] }}
                            </div>


                            <div class="sb-step-subtitle">
                                Complete previous step
                            </div>

                        </div>

                    @endif

                </div>

            @endforeach

        </div>


        {{-- ================================================================
             BACK / NEXT NAVIGATION
        ================================================================= --}}

        <div class="sb-navigation">

            @if($backRoute)

                <a
                    href="{{ route($backRoute) }}"
                    class="sb-nav-btn"
                >

                    <i
                        class="fa-solid fa-arrow-left sb-nav-icon"
                        aria-hidden="true"
                    ></i>

                    <span>
                        Back
                    </span>

                </a>

            @else

                <span
                    class="sb-nav-btn disabled"
                    aria-disabled="true"
                >

                    <i
                        class="fa-solid fa-arrow-left sb-nav-icon"
                        aria-hidden="true"
                    ></i>

                    <span>
                        Back
                    </span>

                </span>

            @endif


            @if($nextRoute)

                <a
                    href="{{ route($nextRoute) }}"
                    class="sb-nav-btn primary"
                >

                    <span>

                        @if($currentStep === 4)
                            Review
                        @elseif($currentStep === 5)
                            Activate
                        @else
                            Next
                        @endif

                    </span>

                    <i
                        class="fa-solid fa-arrow-right sb-nav-icon"
                        aria-hidden="true"
                    ></i>

                </a>

            @else

                <span
                    class="sb-nav-btn disabled"
                    aria-disabled="true"
                >

                    <span>
                        Completed
                    </span>

                    <i
                        class="fa-solid fa-circle-check sb-nav-icon"
                        aria-hidden="true"
                    ></i>

                </span>

            @endif

        </div>


        {{-- ================================================================
             EDIT NOTE
        ================================================================= --}}

        <div class="sb-edit-note">

            <i
                class="fa-solid fa-circle-check"
                aria-hidden="true"
            ></i>

            <span>
                Completed steps can be opened again and edited.
            </span>

        </div>


        {{-- ================================================================
             INFO / SECURITY STRIP
        ================================================================= --}}

        <div class="sb-wizard-info">

            <i
                class="fa-solid fa-shield-halved"
                aria-hidden="true"
            ></i>

            <span>
                Your seller application information is securely handled by
                Smart Basket Premium.
            </span>

        </div>

    </div>

</div>