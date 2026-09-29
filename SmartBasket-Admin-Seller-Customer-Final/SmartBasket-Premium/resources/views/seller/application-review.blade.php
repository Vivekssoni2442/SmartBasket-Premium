@extends('seller.partials.premium-layout')

@section('title', 'Review Seller Application')

@php
    $step = 6;
@endphp

@section('content')

<style>
/* =========================================================
   SMART BASKET — SELLER VERIFICATION
   STEP 6 — PREMIUM LIGHT REVIEW UI
========================================================= */

:root {
    --sb-primary: #00c978;
    --sb-primary-dark: #009f5e;

    --sb-bg: #f4f8f6;
    --sb-card: #ffffff;
    --sb-card-soft: #f8fbfa;

    --sb-text: #14221d;
    --sb-text-2: #52645c;
    --sb-muted: #81918b;

    --sb-border: #e2ebe7;
    --sb-border-hover: #b9ded0;

    --sb-success: #059669;
    --sb-success-bg: #ecfdf5;

    --sb-warning: #d97706;
    --sb-warning-bg: #fff7ed;

    --sb-shadow:
        0 25px 70px rgba(21, 54, 42, .09);

    --sb-shadow-soft:
        0 10px 35px rgba(21, 54, 42, .06);

    --sb-radius: 24px;
}


/* =========================================================
   CARD
========================================================= */

.sb-card {
    position: relative;
    width: 100%;
    max-width: 900px;

    margin: 0 auto;

    padding: 38px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #fbfefd
        );

    border: 1px solid var(--sb-border);

    border-radius: var(--sb-radius);

    box-shadow:
        var(--sb-shadow);

    overflow: hidden;

    animation:
        sbCardIn .45s ease both;
}


/* Decorative glow */

.sb-card::before {
    content: "";

    position: absolute;

    width: 300px;
    height: 300px;

    top: -190px;
    right: -120px;

    border-radius: 50%;

    background:
        rgba(0, 201, 120, .08);

    filter: blur(15px);

    pointer-events: none;
}


.sb-card::after {
    content: "";

    position: absolute;

    width: 220px;
    height: 220px;

    bottom: -150px;
    left: -100px;

    border-radius: 50%;

    background:
        rgba(0, 201, 120, .045);

    filter: blur(20px);

    pointer-events: none;
}


@keyframes sbCardIn {

    from {
        opacity: 0;
        transform: translateY(15px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}


/* =========================================================
   STEP BADGE
========================================================= */

.sb-step {
    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 8px 13px;

    margin-bottom: 15px;

    border-radius: 999px;

    background:
        #ecfdf5;

    border:
        1px solid #c8f1df;

    color:
        var(--sb-success);

    font-size: 10px;

    font-weight: 800;

    letter-spacing: .8px;
}


.sb-step::before {
    content: "";

    width: 7px;
    height: 7px;

    border-radius: 50%;

    background:
        var(--sb-primary);

    box-shadow:
        0 0 0 4px rgba(0,201,120,.10);
}


/* =========================================================
   TITLE
========================================================= */

.sb-title {
    position: relative;

    margin: 0;

    color:
        var(--sb-text);

    font-size: 30px;

    line-height: 1.25;

    font-weight: 800;

    letter-spacing: -.7px;

    z-index: 1;
}


.sb-description {
    position: relative;

    margin:
        9px 0 30px;

    max-width: 650px;

    color:
        var(--sb-text-2);

    font-size: 13px;

    line-height: 1.7;

    z-index: 1;
}


/* =========================================================
   SUMMARY CONTAINER
========================================================= */

.sb-summary {
    position: relative;

    display: flex;

    flex-direction: column;

    gap: 10px;

    z-index: 1;
}


/* =========================================================
   SUMMARY ROW
========================================================= */

.sb-summary-row {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    min-height: 78px;

    padding: 16px 17px 16px 20px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #f9fcfb
        );

    border:
        1px solid var(--sb-border);

    border-radius: 17px;

    box-shadow:
        0 5px 18px rgba(20,50,40,.035);

    transition:
        .25s ease;
}


.sb-summary-row:hover {
    border-color:
        var(--sb-border-hover);

    transform:
        translateY(-2px);

    box-shadow:
        var(--sb-shadow-soft);
}


/* =========================================================
   LABEL
========================================================= */

.sb-summary-label {
    margin-bottom: 4px;

    color:
        var(--sb-muted);

    font-size: 10px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .7px;
}


/* =========================================================
   VALUE
========================================================= */

.sb-summary-value {
    color:
        var(--sb-text);

    font-size: 13px;

    font-weight: 700;

    line-height: 1.5;
}


/* Success text */

.sb-summary-value:has(+ *) {
    color: var(--sb-text);
}


/* =========================================================
   EDIT BUTTON
========================================================= */

.sb-btn {
    position: relative;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    min-height: 38px;

    padding: 0 15px;

    border-radius: 11px;

    border:
        1px solid var(--sb-border);

    background:
        #ffffff;

    color:
        var(--sb-text-2);

    text-decoration: none;

    font-size: 11px;

    font-weight: 800;

    white-space: nowrap;

    cursor: pointer;

    transition:
        .25s ease;

    box-shadow:
        0 3px 10px rgba(20,50,40,.035);
}


.sb-btn:hover {
    color:
        var(--sb-primary-dark);

    border-color:
        #a9dfcb;

    background:
        #f0fdf8;

    transform:
        translateY(-2px);

    box-shadow:
        0 7px 20px rgba(0,201,120,.10);
}


/* =========================================================
   STATUS ICON STYLE
========================================================= */

.sb-summary-value {
    display: flex;

    align-items: center;

    gap: 7px;
}


/* =========================================================
   ACTION AREA
========================================================= */

.sb-actions {
    position: relative;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 14px;

    margin-top: 28px;

    padding-top: 23px;

    border-top:
        1px solid var(--sb-border);

    z-index: 1;
}


.sb-actions > form {
    margin: 0;
}


/* =========================================================
   BACK BUTTON
========================================================= */

.sb-actions > .sb-btn {
    min-height: 48px;

    padding:
        0 20px;

    background:
        #ffffff;
}


/* =========================================================
   PRIMARY SUBMIT
========================================================= */

.sb-btn-primary {
    min-height: 50px;

    padding:
        0 24px;

    border:
        1px solid transparent;

    background:
        linear-gradient(
            135deg,
            #00d986,
            #00b96d
        );

    color:
        #ffffff;

    box-shadow:
        0 12px 28px rgba(0,201,120,.20);
}


.sb-btn-primary:hover {
    color:
        #ffffff;

    border-color:
        transparent;

    background:
        linear-gradient(
            135deg,
            #00e28c,
            #00bd70
        );

    transform:
        translateY(-2px);

    box-shadow:
        0 17px 35px rgba(0,201,120,.28);
}


/* =========================================================
   REVIEW STATUS VISUAL
========================================================= */

.sb-summary-row:nth-child(1) {
    border-left:
        3px solid #00c978;
}


.sb-summary-row:nth-child(2) {
    border-left:
        3px solid #3b82f6;
}


.sb-summary-row:nth-child(3) {
    border-left:
        3px solid #8b5cf6;
}


.sb-summary-row:nth-child(4) {
    border-left:
        3px solid #10b981;
}


.sb-summary-row:nth-child(5) {
    border-left:
        3px solid #f59e0b;
}


/* =========================================================
   FORM BUTTON FIX
========================================================= */

.sb-actions form .sb-btn {
    border: none;
}


/* =========================================================
   FOCUS
========================================================= */

.sb-btn:focus-visible {
    outline:
        3px solid rgba(0,201,120,.16);

    outline-offset:
        2px;
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .sb-card {
        padding:
            25px 18px;

        border-radius:
            20px;
    }


    .sb-title {
        font-size:
            24px;

        letter-spacing:
            -.4px;
    }


    .sb-description {
        font-size:
            12px;

        margin-bottom:
            23px;
    }


    .sb-summary-row {
        min-height:
            72px;

        padding:
            14px;

        border-radius:
            15px;
    }


    .sb-summary-value {
        font-size:
            12px;
    }


    .sb-btn {
        min-height:
            36px;

        padding:
            0 12px;

        font-size:
            10px;
    }


    .sb-actions {
        flex-direction:
            column-reverse;

        align-items:
            stretch;
    }


    .sb-actions > .sb-btn,
    .sb-actions > form,
    .sb-actions > form .sb-btn {
        width:
            100%;
    }


    .sb-actions > form {
        display:
            block;
    }


    .sb-actions .sb-btn {
        min-height:
            50px;
    }
}


@media (max-width: 480px) {

    .sb-card {
        padding:
            22px 14px;
    }


    .sb-title {
        font-size:
            22px;
    }


    .sb-summary-row {
        align-items:
            flex-start;

        padding:
            14px;
    }


    .sb-summary-row > div {
        min-width:
            0;

        flex:
            1;
    }


    .sb-summary-value {
        word-break:
            break-word;
    }
}

</style>


<div class="sb-card">

    {{-- STEP --}}

    <div class="sb-step">
        STEP 6 OF 6
    </div>


    {{-- TITLE --}}

    <h1 class="sb-title">
        Review your application
    </h1>


    <p class="sb-description">
        Everything looks good? You can still edit any section before
        submitting your seller application.
    </p>


    {{-- =====================================================
         APPLICATION SUMMARY
    ====================================================== --}}

    <div class="sb-summary">


        {{-- ACCOUNT --}}

        <div class="sb-summary-row">

            <div>

                <div class="sb-summary-label">
                    Seller Name
                </div>

                <div class="sb-summary-value">

                    <i
                        class="fa-solid fa-circle-check"
                        style="color:#00b96d;"
                    ></i>

                    {{ $seller->seller_name }}

                </div>

            </div>


            <a
                href="{{ route('seller.verification.email') }}"
                class="sb-btn"
            >
                <i class="fa-solid fa-pen"></i>
                Edit
            </a>

        </div>


        {{-- BUSINESS --}}

        <div class="sb-summary-row">

            <div>

                <div class="sb-summary-label">
                    Business Type
                </div>

                <div class="sb-summary-value">

                    <i
                        class="fa-solid fa-store"
                        style="color:#3b82f6;"
                    ></i>

                    {{ $seller->business_type ?: 'Not provided' }}

                </div>

            </div>


            <a
                href="{{ route('seller.verification.business-details') }}"
                class="sb-btn"
            >
                <i class="fa-solid fa-pen"></i>
                Edit
            </a>

        </div>


        {{-- DOCUMENTS --}}

        <div class="sb-summary-row">

            <div>

                <div class="sb-summary-label">
                    Documents
                </div>

                <div class="sb-summary-value">

                    @if(
                        $seller->business_certificate_path &&
                        $seller->aadhaar_document_path
                    )

                        <i
                            class="fa-solid fa-circle-check"
                            style="color:#059669;"
                        ></i>

                        <span style="color:#059669;">
                            Documents uploaded
                        </span>

                    @else

                        <i
                            class="fa-solid fa-circle-exclamation"
                            style="color:#d97706;"
                        ></i>

                        <span style="color:#d97706;">
                            Documents incomplete
                        </span>

                    @endif

                </div>

            </div>


            <a
                href="{{ route('seller.verification.documents') }}"
                class="sb-btn"
            >
                <i class="fa-solid fa-pen"></i>
                Edit
            </a>

        </div>


        {{-- AADHAAR --}}

        <div class="sb-summary-row">

            <div>

                <div class="sb-summary-label">
                    Aadhaar Verification
                </div>

                <div class="sb-summary-value">

                    @if($seller->aadhaar_verified_at)

                        <i
                            class="fa-solid fa-circle-check"
                            style="color:#059669;"
                        ></i>

                        <span style="color:#059669;">
                            Verified
                        </span>

                    @else

                        <i
                            class="fa-solid fa-clock"
                            style="color:#d97706;"
                        ></i>

                        <span style="color:#d97706;">
                            Pending
                        </span>

                    @endif

                </div>

            </div>


            <a
                href="{{ route('seller.verification.aadhaar') }}"
                class="sb-btn"
            >
                <i class="fa-solid fa-pen"></i>
                Edit
            </a>

        </div>


        {{-- BANK --}}

        <div class="sb-summary-row">

            <div>

                <div class="sb-summary-label">
                    Bank Account
                </div>

                <div class="sb-summary-value">

                    @if($seller->bank_name)

                        <i
                            class="fa-solid fa-building-columns"
                            style="color:#f59e0b;"
                        ></i>

                        {{ $seller->bank_name }}

                    @else

                        <i
                            class="fa-solid fa-circle-exclamation"
                            style="color:#d97706;"
                        ></i>

                        <span style="color:#d97706;">
                            Not provided
                        </span>

                    @endif

                </div>

            </div>


            <a
                href="{{ route('seller.verification.bank-details') }}"
                class="sb-btn"
            >
                <i class="fa-solid fa-pen"></i>
                Edit
            </a>

        </div>

    </div>


    {{-- =====================================================
         ACTIONS
    ====================================================== --}}

    <div class="sb-actions">


        {{-- BACK --}}

        <a
            href="{{ route('seller.verification.bank-details') }}"
            class="sb-btn"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>


        {{-- SUBMIT --}}

        <form
            method="POST"
            action="{{ route('seller.verification.submit') }}"
        >

            @csrf

            <button
                type="submit"
                class="sb-btn sb-btn-primary"
            >
                <i class="fa-solid fa-circle-check"></i>
                Submit Seller Application
            </button>

        </form>

    </div>

</div>

@endsection