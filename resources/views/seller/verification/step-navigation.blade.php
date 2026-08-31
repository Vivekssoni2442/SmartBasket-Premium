@php
    /*
    |--------------------------------------------------------------------------
    | CURRENT STEP
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | Do NOT calculate the current step from uploaded documents.
    | The page currently being displayed decides the active step.
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
    | Determine step from CURRENT PAGE
    |--------------------------------------------------------------------------
    */

    $currentStep = $routeToStep[$routeName] ?? null;

    /*
    |--------------------------------------------------------------------------
    | Fallback only when a route does not have a mapping
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
    | Six steps
    |--------------------------------------------------------------------------
    */

    $steps = [
        1 => [
            'title' => 'Email',
            'icon' => '✉',
            'route' => 'seller.verification.email',
        ],

        2 => [
            'title' => 'Documents',
            'icon' => '▣',
            'route' => 'seller.verification.documents',
        ],

        3 => [
            'title' => 'Aadhaar',
            'icon' => '◉',
            'route' => 'seller.verification.aadhaar',
        ],

        4 => [
            'title' => 'Review',
            'icon' => '✓',
            'route' => 'seller.verification.review',
        ],

        5 => [
            'title' => 'Approval',
            'icon' => '◆',
            'route' => 'seller.verification.status',
        ],

        6 => [
            'title' => 'Activation',
            'icon' => '★',
            'route' => 'seller.activation',
        ],
    ];

    /*
    |--------------------------------------------------------------------------
    | Every previously visited step is editable.
    |--------------------------------------------------------------------------
    */

    $canOpenStep = function (int $number) use ($currentStep) {
        return $number <= $currentStep;
    };

    /*
    |--------------------------------------------------------------------------
    | Back route
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
    | Next route
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
@endphp


<style>
    .sb-wizard {
        width: 100%;
        margin-bottom: 28px;
    }

    .sb-wizard-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 20px;
    }

    .sb-wizard-brand {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sb-wizard-logo {
        width: 44px;
        height: 44px;
        border-radius: 14px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: linear-gradient(
            135deg,
            #ffffff,
            #d7d7d7
        );

        color: #111;
        font-weight: 900;

        box-shadow:
            0 10px 30px rgba(255,255,255,.12);
    }

    .sb-wizard-title {
        color: #fff;
        font-size: 18px;
        font-weight: 800;
        letter-spacing: .3px;
    }

    .sb-wizard-subtitle {
        color: rgba(255,255,255,.5);
        font-size: 12px;
        margin-top: 3px;
    }

    .sb-step-count {
        color: rgba(255,255,255,.55);
        font-size: 13px;
        white-space: nowrap;
    }

    .sb-progress {
        height: 5px;
        width: 100%;
        background: rgba(255,255,255,.08);
        border-radius: 100px;
        overflow: hidden;
        margin-bottom: 22px;
    }

    .sb-progress-fill {
        height: 100%;
        border-radius: inherit;

        background: linear-gradient(
            90deg,
            #ffffff,
            #8d8d8d
        );

        transition: width .4s ease;
    }

    .sb-steps {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 8px;
    }

    .sb-step {
        position: relative;
        min-width: 0;
    }

    .sb-step-link {
        text-decoration: none;
        display: block;

        padding: 12px 8px;

        border-radius: 16px;

        border: 1px solid rgba(255,255,255,.08);

        background: rgba(255,255,255,.035);

        transition: .25s ease;
    }

    .sb-step-link:hover {
        background: rgba(255,255,255,.075);
        border-color: rgba(255,255,255,.18);

        transform: translateY(-2px);
    }

    .sb-step-number {
        width: 34px;
        height: 34px;

        margin: 0 auto 7px;

        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 13px;
        font-weight: 800;

        background: rgba(255,255,255,.08);
        color: rgba(255,255,255,.55);

        border: 1px solid rgba(255,255,255,.10);
    }

    .sb-step-title {
        text-align: center;

        font-size: 11px;
        font-weight: 700;

        color: rgba(255,255,255,.5);

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /*
    |--------------------------------------------------------------------------
    | ACTIVE
    |--------------------------------------------------------------------------
    */

    .sb-step.active .sb-step-link {
        background: rgba(255,255,255,.10);

        border-color: rgba(255,255,255,.35);

        box-shadow:
            0 10px 35px rgba(0,0,0,.20);
    }

    .sb-step.active .sb-step-number {
        background: #fff;
        color: #111;

        border-color: #fff;
    }

    .sb-step.active .sb-step-title {
        color: #fff;
    }

    /*
    |--------------------------------------------------------------------------
    | COMPLETED
    |--------------------------------------------------------------------------
    */

    .sb-step.completed .sb-step-number {
        background: rgba(34,197,94,.15);
        border-color: rgba(34,197,94,.35);
        color: #86efac;
    }

    .sb-step.completed .sb-step-title {
        color: rgba(255,255,255,.75);
    }

    /*
    |--------------------------------------------------------------------------
    | NAVIGATION
    |--------------------------------------------------------------------------
    */

    .sb-navigation {
        display: flex;
        gap: 12px;

        margin-top: 22px;
    }

    .sb-nav-btn {
        flex: 1;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-height: 48px;

        padding: 12px 18px;

        border-radius: 14px;

        border: 1px solid rgba(255,255,255,.12);

        background: rgba(255,255,255,.05);

        color: #fff;

        text-decoration: none;

        font-size: 14px;
        font-weight: 800;

        transition: .2s ease;
    }

    .sb-nav-btn:hover {
        color: #fff;

        background: rgba(255,255,255,.10);

        border-color: rgba(255,255,255,.25);

        transform: translateY(-1px);
    }

    .sb-nav-btn.primary {
        background: #fff;
        color: #111;

        border-color: #fff;
    }

    .sb-nav-btn.primary:hover {
        background: #e5e5e5;
        color: #111;
    }

    .sb-nav-btn.disabled {
        opacity: .35;
        cursor: not-allowed;
        pointer-events: none;
    }

    .sb-edit-note {
        margin-top: 14px;

        text-align: center;

        color: rgba(255,255,255,.45);

        font-size: 12px;
    }

    @media (max-width: 768px) {

        .sb-steps {
            grid-template-columns: repeat(3, 1fr);
        }

        .sb-navigation {
            position: sticky;
            bottom: 10px;

            z-index: 20;

            padding: 10px;

            border-radius: 17px;

            background: rgba(18,18,18,.92);

            backdrop-filter: blur(18px);

            border: 1px solid rgba(255,255,255,.08);
        }

        .sb-nav-btn {
            min-width: 0;
        }
    }

    @media (max-width: 480px) {

        .sb-wizard-header {
            align-items: flex-start;
        }

        .sb-step-title {
            font-size: 10px;
        }

        .sb-step-link {
            padding: 9px 4px;
        }

        .sb-navigation {
            gap: 8px;
        }

        .sb-nav-btn {
            min-height: 44px;
            padding: 10px 8px;
            font-size: 13px;
        }
    }
</style>


<div class="sb-wizard">

    <!-- HEADER -->

    <div class="sb-wizard-header">

        <div class="sb-wizard-brand">

            <div class="sb-wizard-logo">
                SB
            </div>

            <div>

                <div class="sb-wizard-title">
                    Seller Partner Program
                </div>

                <div class="sb-wizard-subtitle">
                    SMART BASKET PREMIUM
                </div>

            </div>

        </div>

        <div class="sb-step-count">
            Step {{ $currentStep }} of 6
        </div>

    </div>


    <!-- PROGRESS -->

    <div class="sb-progress">

        <div
            class="sb-progress-fill"
            style="width: {{ ($currentStep / 6) * 100 }}%"
        ></div>

    </div>


    <!-- STEP BUTTONS -->

    <div class="sb-steps">

        @foreach($steps as $number => $step)

            @php
                $completed = $number < $currentStep;
                $active = $number === $currentStep;
                $allowed = $canOpenStep($number);
            @endphp

            <div
                class="
                    sb-step
                    {{ $active ? 'active' : '' }}
                    {{ $completed ? 'completed' : '' }}
                "
            >

                @if($allowed)

                    <a
                        href="{{ route($step['route']) }}"
                        class="sb-step-link"
                        title="Open {{ $step['title'] }} step"
                    >

                        <div class="sb-step-number">

                            @if($completed)
                                ✓
                            @else
                                {{ $number }}
                            @endif

                        </div>

                        <div class="sb-step-title">
                            {{ $step['title'] }}
                        </div>

                    </a>

                @else

                    <div class="sb-step-link">

                        <div class="sb-step-number">
                            {{ $number }}
                        </div>

                        <div class="sb-step-title">
                            {{ $step['title'] }}
                        </div>

                    </div>

                @endif

            </div>

        @endforeach

    </div>


    <!-- BACK / NEXT -->

    <div class="sb-navigation">

        @if($backRoute)

            <a
                href="{{ route($backRoute) }}"
                class="sb-nav-btn"
            >
                ← Back
            </a>

        @else

            <span class="sb-nav-btn disabled">
                ← Back
            </span>

        @endif


        @if($nextRoute)

            <a
                href="{{ route($nextRoute) }}"
                class="sb-nav-btn primary"
            >
                @if($currentStep === 4)
                    Review →
                @elseif($currentStep === 5)
                    Activate →
                @else
                    Next →
                @endif
            </a>

        @else

            <span class="sb-nav-btn disabled">
                Completed ✓
            </span>

        @endif

    </div>


    <div class="sb-edit-note">
        ✓ Completed steps can be opened again and edited.
    </div>

</div>