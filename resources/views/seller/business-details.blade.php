@extends('seller.partials.premium-layout')

@section('title', 'Business Details')

@php
    $step = 4;
@endphp

@section('content')

<style>
/* =========================================================
   SMART BASKET — SELLER VERIFICATION
   STEP 4 — BUSINESS DETAILS
   PREMIUM LIGHT ONBOARDING UI
========================================================= */

.business-page {
    --bd-bg: #f5f8f7;
    --bd-card: #ffffff;
    --bd-card-soft: #f8fbfa;
    --bd-text: #172033;
    --bd-heading: #101828;
    --bd-muted: #718096;
    --bd-border: #e3ebe7;
    --bd-border-soft: #edf2ef;

    --bd-green: #00a968;
    --bd-green-2: #00c978;
    --bd-green-dark: #087a4c;

    --bd-blue: #2563eb;

    width: 100%;
    min-height: calc(100vh - 80px);

    padding: 34px 20px 70px;

    color: var(--bd-text);

    background:
        radial-gradient(
            circle at 5% 0%,
            rgba(0, 201, 120, .07),
            transparent 28%
        ),
        radial-gradient(
            circle at 95% 5%,
            rgba(59, 130, 246, .055),
            transparent 28%
        );
}

.business-page *,
.business-page *::before,
.business-page *::after {
    box-sizing: border-box;
}


/* =========================================================
   MAIN CONTAINER
========================================================= */

.business-container {
    width: min(1040px, 100%);
    margin: 0 auto;
}


/* =========================================================
   TOP PROGRESS
========================================================= */

.bd-progress-wrap {
    margin-bottom: 18px;
}

.bd-progress-top {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;

    margin-bottom: 9px;
}

.bd-progress-label {
    color: #64748b;

    font-size: 10px;
    font-weight: 800;

    letter-spacing: .12em;
    text-transform: uppercase;
}

.bd-progress-number {
    color: var(--bd-green);

    font-size: 11px;
    font-weight: 850;
}

.bd-progress {
    width: 100%;
    height: 5px;

    overflow: hidden;

    border-radius: 999px;

    background: #e8efec;
}

.bd-progress-bar {
    width: 66.666%;

    height: 100%;

    border-radius: inherit;

    background:
        linear-gradient(
            90deg,
            #00a968,
            #00d98a
        );

    box-shadow:
        0 0 14px rgba(0, 201, 120, .20);
}


/* =========================================================
   CARD
========================================================= */

.business-card {
    position: relative;

    overflow: hidden;

    border:
        1px solid var(--bd-border);

    border-radius: 26px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #fbfdfc
        );

    box-shadow:
        0 25px 70px rgba(15, 23, 42, .075),
        0 4px 15px rgba(15, 23, 42, .025),
        inset 0 1px 0 #ffffff;
}

.business-card::before {
    content: "";

    position: absolute;

    width: 280px;
    height: 280px;

    top: -175px;
    right: -110px;

    border-radius: 50%;

    background: #00c978;

    opacity: .055;

    filter: blur(38px);

    pointer-events: none;
}

.business-card::after {
    content: "";

    position: absolute;

    width: 220px;
    height: 220px;

    left: -130px;
    bottom: -150px;

    border-radius: 50%;

    background: #3b82f6;

    opacity: .025;

    filter: blur(40px);

    pointer-events: none;
}


/* =========================================================
   CARD INNER
========================================================= */

.business-card-inner {
    position: relative;
    z-index: 2;

    padding: 34px;
}


/* =========================================================
   STEP BADGE
========================================================= */

.bd-step {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    min-height: 30px;

    padding: 0 12px;

    border:
        1px solid rgba(0, 169, 104, .18);

    border-radius: 999px;

    background:
        rgba(0, 169, 104, .055);

    color: var(--bd-green-dark);

    font-size: 9px;
    font-weight: 850;

    letter-spacing: .12em;

    text-transform: uppercase;
}

.bd-step-dot {
    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: var(--bd-green-2);

    box-shadow:
        0 0 0 4px rgba(0, 201, 120, .09);
}


/* =========================================================
   HEADER
========================================================= */

.bd-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;

    gap: 25px;

    margin-top: 19px;
    margin-bottom: 31px;
}

.bd-header-content {
    max-width: 720px;
}

.bd-header h1 {
    margin: 0;

    color: var(--bd-heading);

    font-size: clamp(27px, 4vw, 38px);
    line-height: 1.13;

    font-weight: 850;

    letter-spacing: -.9px;
}

.bd-header h1 span {
    color: var(--bd-green);

    text-shadow:
        0 0 25px rgba(0, 169, 104, .08);
}

.bd-description {
    max-width: 650px;

    margin: 10px 0 0;

    color: var(--bd-muted);

    font-size: 12px;

    line-height: 1.7;
}

.bd-header-icon {
    width: 58px;
    height: 58px;

    flex: 0 0 58px;

    display: flex;
    align-items: center;
    justify-content: center;

    border:
        1px solid rgba(0, 169, 104, .14);

    border-radius: 17px;

    background:
        rgba(0, 169, 104, .055);

    color: var(--bd-green);

    font-size: 21px;

    box-shadow:
        0 10px 25px rgba(0, 169, 104, .06);
}


/* =========================================================
   ALERTS
========================================================= */

.bd-alert {
    display: flex;
    align-items: flex-start;

    gap: 11px;

    margin-bottom: 20px;

    padding: 14px 16px;

    border-radius: 14px;

    font-size: 11px;
    font-weight: 650;

    line-height: 1.55;
}

.bd-alert-success {
    color: #087a4c;

    background:
        rgba(0, 169, 104, .055);

    border:
        1px solid rgba(0, 169, 104, .18);
}

.bd-alert-error {
    color: #c62828;

    background:
        rgba(239, 68, 68, .055);

    border:
        1px solid rgba(239, 68, 68, .16);
}

.bd-alert-icon {
    width: 25px;
    height: 25px;

    flex: 0 0 25px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 8px;

    font-weight: 900;
}

.bd-alert-success .bd-alert-icon {
    background: rgba(0, 169, 104, .10);
}

.bd-alert-error .bd-alert-icon {
    background: rgba(239, 68, 68, .08);
}

.bd-alert ul {
    width: 100%;

    margin: 0;

    padding-left: 17px;
}

.bd-alert li + li {
    margin-top: 4px;
}


/* =========================================================
   FORM
========================================================= */

.bd-form {
    position: relative;
    z-index: 3;
}

.bd-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 18px;
}


/* =========================================================
   FIELD
========================================================= */

.bd-field {
    min-width: 0;

    padding: 18px;

    border:
        1px solid var(--bd-border-soft);

    border-radius: 17px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #fbfdfc
        );

    transition:
        border-color .22s ease,
        box-shadow .22s ease,
        transform .22s ease;
}

.bd-field:hover {
    border-color:
        rgba(0, 169, 104, .20);

    box-shadow:
        0 10px 25px rgba(15, 23, 42, .035);
}

.bd-field:focus-within {
    border-color:
        rgba(0, 169, 104, .32);

    box-shadow:
        0 12px 30px rgba(0, 169, 104, .055);
}


/* =========================================================
   FIELD LABEL
========================================================= */

.bd-label {
    display: flex;
    align-items: center;
    gap: 5px;

    margin-bottom: 9px;

    color: #273449;

    font-size: 11px;
    font-weight: 800;
}

.bd-required {
    color: #00a968;
}


/* =========================================================
   FIELD ICON
========================================================= */

.bd-field-head {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 10px;

    margin-bottom: 9px;
}

.bd-field-icon {
    width: 27px;
    height: 27px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 8px;

    background:
        rgba(0, 169, 104, .06);

    color: var(--bd-green);

    font-size: 10px;
}


/* =========================================================
   INPUTS
========================================================= */

.bd-input,
.bd-select {
    width: 100%;

    height: 49px;

    padding: 0 14px;

    outline: none;

    border:
        1px solid #dfe8e4;

    border-radius: 12px;

    background: #ffffff;

    color: #172033;

    font-family: inherit;

    font-size: 12px;
    font-weight: 550;

    box-shadow:
        inset 0 1px 2px rgba(15, 23, 42, .025);

    transition:
        border-color .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}

.bd-input::placeholder {
    color: #a1acba;
    opacity: 1;
}

.bd-input:hover,
.bd-select:hover {
    border-color:
        rgba(0, 169, 104, .28);
}

.bd-input:focus,
.bd-select:focus {
    border-color:
        #00a968;

    background: #ffffff;

    box-shadow:
        0 0 0 3px rgba(0, 169, 104, .075),
        0 8px 20px rgba(0, 169, 104, .045);
}

.bd-select {
    cursor: pointer;

    appearance: auto;

    color-scheme: light;
}

.bd-select option {
    background: #ffffff;
    color: #172033;
}


/* =========================================================
   HELP TEXT
========================================================= */

.bd-help {
    display: flex;
    align-items: flex-start;
    gap: 5px;

    margin-top: 8px;

    color: #94a3b8;

    font-size: 9px;

    line-height: 1.5;
}

.bd-help i {
    margin-top: 2px;

    color: #00a968;

    font-size: 8px;
}


/* =========================================================
   DIVIDER
========================================================= */

.bd-divider {
    height: 1px;

    margin: 29px 0 22px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #e4ebe8 12%,
            #e4ebe8 88%,
            transparent
        );
}


/* =========================================================
   SECURITY CARD
========================================================= */

.bd-security {
    display: flex;
    align-items: center;

    gap: 12px;

    padding: 14px 16px;

    border:
        1px solid #e2ebe7;

    border-radius: 14px;

    background:
        linear-gradient(
            135deg,
            #f8fbfa,
            #ffffff
        );

    color: #718096;

    font-size: 9.5px;

    line-height: 1.55;
}

.bd-security-icon {
    width: 35px;
    height: 35px;

    flex: 0 0 35px;

    display: flex;
    align-items: center;
    justify-content: center;

    border:
        1px solid rgba(0, 169, 104, .12);

    border-radius: 10px;

    background:
        rgba(0, 169, 104, .06);

    color: #00a968;

    font-size: 12px;
}

.bd-security strong {
    color: #334155;

    font-weight: 800;
}


/* =========================================================
   ACTION AREA
========================================================= */

.bd-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;

    margin-top: 27px;
    padding-top: 22px;

    border-top:
        1px solid #edf2ef;
}

.bd-btn {
    min-height: 49px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 8px;

    padding: 0 20px;

    border:
        1px solid #dfe7e3;

    border-radius: 12px;

    background: #ffffff;

    color: #475569;

    text-decoration: none;

    font-family: inherit;

    font-size: 11px;
    font-weight: 800;

    cursor: pointer;

    box-shadow:
        0 5px 15px rgba(15, 23, 42, .035);

    transition:
        transform .22s ease,
        border-color .22s ease,
        color .22s ease,
        box-shadow .22s ease;
}

.bd-btn:hover {
    transform: translateY(-2px);

    border-color:
        rgba(0, 169, 104, .28);

    color: #087a4c;

    box-shadow:
        0 10px 25px rgba(15, 23, 42, .07);
}

.bd-btn-primary {
    min-width: 210px;

    border: 0;

    background:
        linear-gradient(
            135deg,
            #00b875,
            #00d98a
        );

    color: #ffffff !important;

    box-shadow:
        0 11px 27px rgba(0, 201, 120, .17);
}

.bd-btn-primary:hover {
    color: #ffffff !important;

    box-shadow:
        0 16px 34px rgba(0, 201, 120, .24);
}

.bd-btn-primary span {
    transition:
        transform .2s ease;
}

.bd-btn-primary:hover span {
    transform: translateX(3px);
}


/* =========================================================
   BOTTOM STEP INDICATORS
========================================================= */

.bd-mini-steps {
    display: flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    margin-top: 23px;
}

.bd-mini-step {
    width: 24px;
    height: 4px;

    border-radius: 999px;

    background: #e4ebe8;
}

.bd-mini-step.done {
    background: #8dddbd;
}

.bd-mini-step.active {
    width: 38px;

    background:
        linear-gradient(
            90deg,
            #00a968,
            #00d98a
        );
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 760px) {

    .business-page {
        padding:
            22px 13px 50px;
    }

    .business-card-inner {
        padding: 25px 18px;
    }

    .bd-grid {
        grid-template-columns: 1fr;

        gap: 13px;
    }

    .bd-header {
        margin-bottom: 24px;
    }

    .bd-header-icon {
        width: 50px;
        height: 50px;

        flex-basis: 50px;

        border-radius: 14px;
    }

    .bd-actions {
        flex-direction: column-reverse;

        align-items: stretch;
    }

    .bd-btn,
    .bd-btn-primary {
        width: 100%;
    }
}


@media (max-width: 520px) {

    .business-page {
        padding:
            17px 10px 40px;
    }

    .business-card {
        border-radius: 21px;
    }

    .business-card-inner {
        padding: 21px 14px;
    }

    .bd-header {
        gap: 12px;
    }

    .bd-header h1 {
        font-size: 25px;
    }

    .bd-description {
        font-size: 10.5px;
    }

    .bd-header-icon {
        display: none;
    }

    .bd-field {
        padding: 15px;
    }

    .bd-input,
    .bd-select {
        height: 47px;
    }

    .bd-security {
        align-items: flex-start;
    }

    .bd-mini-step {
        width: 19px;
    }

    .bd-mini-step.active {
        width: 30px;
    }
}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .bd-field,
    .bd-input,
    .bd-select,
    .bd-btn,
    .bd-btn-primary span {
        transition: none !important;
    }
}
</style>


<div class="business-page">

    <div class="business-container">

        {{-- =====================================================
             PROGRESS
        ====================================================== --}}

        <div class="bd-progress-wrap">

            <div class="bd-progress-top">

                <div class="bd-progress-label">
                    Seller Partner Program
                </div>

                <div class="bd-progress-number">
                    STEP 4 OF 6
                </div>

            </div>

            <div class="bd-progress">
                <div class="bd-progress-bar"></div>
            </div>

        </div>


        {{-- =====================================================
             MAIN CARD
        ====================================================== --}}

        <div class="business-card">

            <div class="business-card-inner">


                {{-- =================================================
                     STEP BADGE
                ================================================== --}}

                <div class="bd-step">

                    <span class="bd-step-dot"></span>

                    STEP 4 OF 6

                </div>


                {{-- =================================================
                     HEADER
                ================================================== --}}

                <div class="bd-header">

                    <div class="bd-header-content">

                        <h1>
                            Tell us about your
                            <span>business</span>
                        </h1>

                        <p class="bd-description">
                            Provide your business and tax information
                            to complete your SmartBasket seller verification.
                            These details help us verify and protect your seller account.
                        </p>

                    </div>


                    <div class="bd-header-icon">

                        <i class="fa-solid fa-building"></i>

                    </div>

                </div>


                {{-- =================================================
                     SUCCESS
                ================================================== --}}

                @if(session('success'))

                    <div class="bd-alert bd-alert-success">

                        <div class="bd-alert-icon">
                            <i class="fa-solid fa-check"></i>
                        </div>

                        <div>
                            {{ session('success') }}
                        </div>

                    </div>

                @endif


                {{-- =================================================
                     ERROR
                ================================================== --}}

                @if(session('error'))

                    <div class="bd-alert bd-alert-error">

                        <div class="bd-alert-icon">
                            <i class="fa-solid fa-exclamation"></i>
                        </div>

                        <div>
                            {{ session('error') }}
                        </div>

                    </div>

                @endif


                {{-- =================================================
                     VALIDATION ERRORS
                ================================================== --}}

                @if($errors->any())

                    <div class="bd-alert bd-alert-error">

                        <div class="bd-alert-icon">
                            <i class="fa-solid fa-exclamation"></i>
                        </div>

                        <ul>

                            @foreach($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- =================================================
                     FORM
                ================================================== --}}

                <form
                    method="POST"
                    action="{{ route('seller.verification.business-details.update') }}"
                    class="bd-form"
                >

                    @csrf

                    @method('PUT')


                    <div class="bd-grid">


                        {{-- =================================================
                             BUSINESS TYPE
                        ================================================== --}}

                        <div class="bd-field">

                            <div class="bd-field-head">

                                <label
                                    for="business_type"
                                    class="bd-label"
                                >
                                    <span>
                                        Business Type
                                        <span class="bd-required">*</span>
                                    </span>
                                </label>

                                <div class="bd-field-icon">

                                    <i class="fa-solid fa-briefcase"></i>

                                </div>

                            </div>


                            <select
                                id="business_type"
                                name="business_type"
                                class="bd-select"
                                required
                            >

                                <option value="">
                                    Select business type
                                </option>

                                @foreach([
                                    'Individual Seller',
                                    'Proprietorship',
                                    'Partnership',
                                    'Private Limited',
                                    'LLP',
                                    'Other'
                                ] as $type)

                                    <option
                                        value="{{ $type }}"
                                        @selected(
                                            old(
                                                'business_type',
                                                $seller->business_type
                                            ) === $type
                                        )
                                    >
                                        {{ $type }}
                                    </option>

                                @endforeach

                            </select>

                            <small class="bd-help">

                                <i class="fa-solid fa-circle-info"></i>

                                Select the legal structure of your business.

                            </small>

                        </div>


                        <div class="bd-field">
                            <label for="business_name" class="bd-label">Business Name <span class="bd-required">*</span></label>
                            <input id="business_name" type="text" name="business_name" class="bd-input" value="{{ old('business_name', $seller->business_name) }}" required>
                        </div>

                        <div class="bd-field">
                            <label for="business_address" class="bd-label">Business Address <span class="bd-required">*</span></label>
                            <textarea id="business_address" name="business_address" class="bd-input" rows="3" required>{{ old('business_address', $seller->business_address) }}</textarea>
                        </div>

                        <div class="bd-field">
                            <label for="business_city" class="bd-label">City <span class="bd-required">*</span></label>
                            <input id="business_city" type="text" name="business_city" class="bd-input" value="{{ old('business_city', $seller->business_city ?: $seller->city) }}" required>
                        </div>

                        <div class="bd-field">
                            <label for="business_state" class="bd-label">State <span class="bd-required">*</span></label>
                            <input id="business_state" type="text" name="business_state" class="bd-input" value="{{ old('business_state', $seller->business_state ?: $seller->state) }}" required>
                        </div>

                        <div class="bd-field">
                            <label for="business_pincode" class="bd-label">Pincode <span class="bd-required">*</span></label>
                            <input id="business_pincode" type="text" name="business_pincode" class="bd-input" value="{{ old('business_pincode', $seller->business_pincode ?: $seller->pincode) }}" inputmode="numeric" maxlength="6" required>
                        </div>

                        {{-- =================================================
                             GST
                        ================================================== --}}

                        <div class="bd-field">

                            <div class="bd-field-head">

                                <label
                                    for="gst_number"
                                    class="bd-label"
                                >
                                    GST Number
                                </label>

                                <div class="bd-field-icon">

                                    <i class="fa-solid fa-receipt"></i>

                                </div>

                            </div>


                            <input
                                id="gst_number"
                                type="text"
                                name="gst_number"
                                class="bd-input"
                                value="{{ old('gst_number', $seller->gst_number) }}"
                                placeholder="Enter GSTIN"
                                autocomplete="off"
                                maxlength="15"
                                style="text-transform: uppercase;"
                            >


                            <small class="bd-help">

                                <i class="fa-solid fa-circle-info"></i>

                                Optional. Enter your registered GSTIN if applicable.

                            </small>

                        </div>


                        {{-- =================================================
                             PAN
                        ================================================== --}}

                        <div class="bd-field">

                            <div class="bd-field-head">

                                <label
                                    for="pan_number"
                                    class="bd-label"
                                >
                                    PAN Number
                                    <span class="bd-required">*</span>
                                </label>

                                <div class="bd-field-icon">

                                    <i class="fa-solid fa-id-card"></i>

                                </div>

                            </div>


                            <input
                                id="pan_number"
                                type="text"
                                name="pan_number"
                                class="bd-input"
                                value="{{ old('pan_number', $seller->pan_number) }}"
                                placeholder="Enter PAN number"
                                autocomplete="off"
                                maxlength="10"
                                style="text-transform: uppercase;"
                                required
                            >


                            <small class="bd-help">

                                <i class="fa-solid fa-shield-halved"></i>

                                Your PAN is used for seller verification and compliance.

                            </small>

                        </div>


                        {{-- =================================================
                             UDYAM
                        ================================================== --}}

                        <div class="bd-field">

                            <div class="bd-field-head">

                                <label
                                    for="udyam_number"
                                    class="bd-label"
                                >
                                    Udyam Number
                                    <span class="bd-required">*</span>
                                </label>

                                <div class="bd-field-icon">

                                    <i class="fa-solid fa-certificate"></i>

                                </div>

                            </div>


                            <input
                                id="udyam_number"
                                type="text"
                                name="udyam_number"
                                class="bd-input"
                                value="{{ old('udyam_number', $seller->udyam_number) }}"
                                placeholder="Enter Udyam registration number"
                                autocomplete="off"
                                required
                            >


                            <small class="bd-help">

                                <i class="fa-solid fa-circle-info"></i>

                                Enter your Udyam registration number if applicable.

                            </small>

                        </div>


                    </div>


                    {{-- =================================================
                         SECURITY
                    ================================================== --}}

                    <div class="bd-divider"></div>


                    <div class="bd-security">

                        <div class="bd-security-icon">

                            <i class="fa-solid fa-lock"></i>

                        </div>

                        <div>

                            <strong>
                                Your information is protected.
                            </strong>

                            <br>

                            Your business information is securely stored
                            and used only for SmartBasket seller verification
                            and compliance purposes.

                        </div>

                    </div>


                    {{-- =================================================
                         ACTIONS
                    ================================================== --}}

                    <div class="bd-actions">


                        {{-- BACK --}}

                        <a
                            href="{{ route('seller.verification.aadhaar') }}"
                            class="bd-btn"
                        >

                            <i class="fa-solid fa-arrow-left"></i>

                            Back

                        </a>


                        {{-- NEXT --}}

                        <button
                            type="submit"
                            class="bd-btn bd-btn-primary"
                        >

                            Save & Continue

                            <span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>

                        </button>


                    </div>


                </form>


                {{-- =================================================
                     MINI PROGRESS
                ================================================== --}}

                <div class="bd-mini-steps">

                    <span class="bd-mini-step done"></span>

                    <span class="bd-mini-step done"></span>

                    <span class="bd-mini-step done"></span>

                    <span class="bd-mini-step active"></span>

                    <span class="bd-mini-step"></span>

                    <span class="bd-mini-step"></span>

                </div>


            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | PAN
    |--------------------------------------------------------------------------
    */

    const pan =
        document.querySelector(
            '[name="pan_number"]'
        );

    if (pan) {

        pan.addEventListener(
            'input',
            function () {

                this.value =
                    this.value
                        .toUpperCase()
                        .replace(/\s/g, '')
                        .slice(0, 10);

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | GST
    |--------------------------------------------------------------------------
    */

    const gst =
        document.querySelector(
            '[name="gst_number"]'
        );

    if (gst) {

        gst.addEventListener(
            'input',
            function () {

                this.value =
                    this.value
                        .toUpperCase()
                        .replace(/\s/g, '')
                        .slice(0, 15);

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | UDYAM
    |--------------------------------------------------------------------------
    */

    const udyam =
        document.querySelector(
            '[name="udyam_number"]'
        );

    if (udyam) {

        udyam.addEventListener(
            'input',
            function () {

                this.value =
                    this.value
                        .toUpperCase()
                        .replace(/\s/g, '');

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | SUBMIT LOADING STATE
    |--------------------------------------------------------------------------
    */

    const form =
        document.querySelector('.bd-form');

    if (form) {

        form.addEventListener(
            'submit',
            function () {

                const button =
                    form.querySelector(
                        '.bd-btn-primary'
                    );

                if (!button) {
                    return;
                }

                button.disabled = true;

                button.innerHTML =
                    '<i class="fa-solid fa-spinner fa-spin"></i>' +
                    ' Saving...';

            }
        );

    }

});
</script>

@endsection