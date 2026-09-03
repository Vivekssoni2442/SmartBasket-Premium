@extends('seller.partials.premium-layout')

@section('title', 'Aadhaar Verification')

@php
    $step = 3;
@endphp

@section('content')

<style>
/* =========================================================
   SMARTBASKET — STEP 3 AADHAAR VERIFICATION
   PREMIUM LIGHT UI
========================================================= */

.aadhaar-page {
    width: 100%;
    max-width: 1050px;
    margin: 0 auto;
    padding: 8px 0 45px;

    --a-text: #111827;
    --a-muted: #64748b;
    --a-border: #e5e7eb;
    --a-bg: #f8fafc;
    --a-card: #ffffff;
    --a-green: #00a86b;
    --a-green-dark: #008f5b;
    --a-green-soft: #ecfdf5;
    --a-blue: #2563eb;
}

/* =========================================================
   MAIN CARD
========================================================= */

.aadhaar-card {
    position: relative;
    overflow: hidden;

    background: #ffffff;

    border: 1px solid #e5e7eb;

    border-radius: 28px;

    padding: 32px;

    box-shadow:
        0 24px 70px rgba(15, 23, 42, .09),
        0 5px 20px rgba(15, 23, 42, .04);
}

.aadhaar-card::after {
    content: "";

    position: absolute;

    width: 280px;
    height: 280px;

    right: -140px;
    top: -150px;

    border-radius: 50%;

    background: rgba(0, 168, 107, .08);

    filter: blur(35px);

    pointer-events: none;
}

/* =========================================================
   TOP STEP
========================================================= */

.aadhaar-step {
    position: relative;
    z-index: 2;

    display: inline-flex;
    align-items: center;
    gap: 8px;

    padding: 7px 13px;

    margin-bottom: 16px;

    border-radius: 999px;

    color: #008f5b;

    background: #ecfdf5;

    border: 1px solid #bbf7d0;

    font-size: 10px;

    font-weight: 800;

    letter-spacing: .08em;

    text-transform: uppercase;
}

/* =========================================================
   HEADER
========================================================= */

.aadhaar-header {
    position: relative;
    z-index: 2;

    display: flex;

    align-items: center;

    gap: 17px;

    padding-bottom: 25px;

    border-bottom: 1px solid #eef2f7;
}

.aadhaar-icon {
    width: 62px;
    height: 62px;

    flex: 0 0 62px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 18px;

    color: #008f5b;

    background: linear-gradient(
        145deg,
        #ecfdf5,
        #d1fae5
    );

    border: 1px solid #bbf7d0;

    font-size: 24px;

    box-shadow:
        0 10px 28px rgba(0, 168, 107, .10);
}

.aadhaar-header h1 {
    margin: 0;

    color: #111827;

    font-size: clamp(24px, 3vw, 31px);

    font-weight: 850;

    letter-spacing: -.6px;
}

.aadhaar-header h1 span {
    color: #00a86b;
}

.aadhaar-header p {
    margin: 7px 0 0;

    color: #64748b;

    font-size: 12px;

    line-height: 1.6;
}

/* =========================================================
   INFO BOX
========================================================= */

.security-box {
    position: relative;
    z-index: 2;

    display: flex;

    align-items: flex-start;

    gap: 13px;

    margin-top: 23px;

    padding: 17px 18px;

    border-radius: 17px;

    background: #f0fdf8;

    border: 1px solid #d1fae5;
}

.security-icon {
    width: 40px;
    height: 40px;

    flex: 0 0 40px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 12px;

    color: #008f5b;

    background: #dcfce7;

    font-size: 15px;
}

.security-box h3 {
    margin: 0;

    color: #111827;

    font-size: 12px;

    font-weight: 800;
}

.security-box p {
    margin: 4px 0 0;

    color: #64748b;

    font-size: 10px;

    line-height: 1.6;
}

/* =========================================================
   SELLER INFO
========================================================= */

.seller-info {
    position: relative;
    z-index: 2;

    margin-top: 20px;

    padding: 18px;

    border-radius: 17px;

    background: #f8fafc;

    border: 1px solid #e5e7eb;
}

.seller-info-title {
    display: flex;

    align-items: center;

    gap: 9px;

    margin-bottom: 10px;

    color: #111827;

    font-size: 13px;

    font-weight: 800;
}

.seller-info-title i {
    color: #00a86b;
}

.seller-info p {
    margin: 4px 0;

    color: #64748b;

    font-size: 11px;
}

.seller-info strong {
    color: #111827;
}

/* =========================================================
   DOCUMENT STATUS
========================================================= */

.document-grid {
    position: relative;
    z-index: 2;

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 16px;

    margin-top: 20px;
}

.document-card {
    display: flex;

    align-items: center;

    gap: 13px;

    padding: 17px;

    border-radius: 16px;

    background: #ffffff;

    border: 1px solid #e5e7eb;

    transition: .2s ease;
}

.document-card:hover {
    border-color: #a7f3d0;

    transform: translateY(-2px);

    box-shadow:
        0 10px 25px rgba(15, 23, 42, .06);
}

.document-icon {
    width: 43px;
    height: 43px;

    flex: 0 0 43px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: #f0fdf4;

    color: #00a86b;

    font-size: 15px;
}

.document-card h4 {
    margin: 0 0 4px;

    color: #111827;

    font-size: 11px;

    font-weight: 800;
}

.document-status {
    display: inline-flex;

    align-items: center;

    gap: 5px;

    color: #16a34a;

    font-size: 10px;

    font-weight: 700;
}

.document-status.pending {
    color: #dc2626;
}

/* =========================================================
   FORM CARD
========================================================= */

.verify-card {
    position: relative;
    z-index: 2;

    margin-top: 21px;

    padding: 23px;

    border-radius: 20px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #f8fafc
        );

    border: 1px solid #e5e7eb;

    box-shadow:
        0 10px 30px rgba(15, 23, 42, .045);
}

.verify-card-header {
    display: flex;

    align-items: center;

    gap: 12px;

    margin-bottom: 20px;
}

.verify-card-icon {
    width: 45px;
    height: 45px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 13px;

    background: #ecfdf5;

    color: #00a86b;

    border: 1px solid #d1fae5;
}

.verify-card-header h2 {
    margin: 0;

    color: #111827;

    font-size: 15px;

    font-weight: 800;
}

.verify-card-header p {
    margin: 3px 0 0;

    color: #64748b;

    font-size: 10px;
}

/* =========================================================
   INPUT
========================================================= */

.aadhaar-field {
    margin-top: 4px;
}

.aadhaar-label {
    display: block;

    margin-bottom: 8px;

    color: #111827;

    font-size: 11px;

    font-weight: 800;
}

.required {
    color: #dc2626;
}

.aadhaar-input {
    width: 100%;

    min-height: 52px;

    padding: 13px 15px;

    border-radius: 13px;

    background: #ffffff;

    color: #111827;

    border: 1px solid #dbe2ea;

    outline: none;

    font-family: inherit;

    font-size: 14px;

    letter-spacing: .12em;

    transition: .2s ease;
}

.aadhaar-input:hover {
    border-color: #86efac;
}

.aadhaar-input:focus {
    border-color: #00a86b;

    box-shadow:
        0 0 0 4px rgba(0, 168, 107, .09);
}

.aadhaar-input::placeholder {
    color: #94a3b8;

    letter-spacing: normal;
}

.input-help {
    display: block;

    margin-top: 8px;

    color: #94a3b8;

    font-size: 9px;

    line-height: 1.5;
}

/* =========================================================
   ACTIONS
========================================================= */

.aadhaar-actions {
    position: relative;
    z-index: 2;

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 14px;

    margin-top: 25px;

    padding-top: 23px;

    border-top: 1px solid #eef2f7;
}

.aadhaar-btn {
    min-height: 48px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    padding: 0 20px;

    border-radius: 13px;

    text-decoration: none;

    font-size: 11px;

    font-weight: 800;

    transition: .2s ease;
}

.aadhaar-back {
    color: #64748b;

    background: #f8fafc;

    border: 1px solid #e5e7eb;
}

.aadhaar-back:hover {
    color: #111827;

    background: #f1f5f9;

    transform: translateY(-1px);
}

.aadhaar-submit {
    border: 0;

    color: #ffffff;

    background:
        linear-gradient(
            135deg,
            #00b878,
            #008f5b
        );

    box-shadow:
        0 10px 25px rgba(0, 168, 107, .18);

    cursor: pointer;
}

.aadhaar-submit:hover {
    transform: translateY(-2px);

    box-shadow:
        0 15px 32px rgba(0, 168, 107, .25);
}

/* =========================================================
   ALERTS
========================================================= */

.aadhaar-alert {
    position: relative;
    z-index: 2;

    display: flex;

    align-items: flex-start;

    gap: 10px;

    margin-top: 20px;

    padding: 14px 16px;

    border-radius: 13px;

    font-size: 11px;

    line-height: 1.5;
}

.aadhaar-success {
    color: #166534;

    background: #f0fdf4;

    border: 1px solid #bbf7d0;
}

.aadhaar-error {
    color: #991b1b;

    background: #fef2f2;

    border: 1px solid #fecaca;
}

/* =========================================================
   FOOTER
========================================================= */

.aadhaar-footer {
    position: relative;
    z-index: 2;

    display: flex;

    justify-content: center;

    align-items: center;

    gap: 6px;

    margin-top: 18px;

    color: #94a3b8;

    font-size: 9px;
}

.aadhaar-footer i {
    color: #00a86b;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width: 700px) {

    .aadhaar-card {
        padding: 23px 17px;

        border-radius: 22px;
    }

    .document-grid {
        grid-template-columns: 1fr;
    }

    .aadhaar-header {
        align-items: flex-start;
    }

    .aadhaar-actions {
        flex-direction: column;
    }

    .aadhaar-btn {
        width: 100%;
    }
}

@media(max-width: 480px) {

    .aadhaar-header h1 {
        font-size: 22px;
    }

    .aadhaar-header p {
        font-size: 10px;
    }

    .verify-card {
        padding: 18px;
    }
}
</style>


<div class="aadhaar-page">

    <div class="aadhaar-card">

        {{-- =====================================================
             STEP
        ====================================================== --}}

        <div class="aadhaar-step">
            <i class="fa-solid fa-shield-halved"></i>
            STEP 3 OF 6
        </div>


        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="aadhaar-header">

            <div class="aadhaar-icon">
                <i class="fa-solid fa-id-card"></i>
            </div>

            <div>

                <h1>
                    Aadhaar <span>Verification</span>
                </h1>

                <p>
                    Verify your identity securely before continuing
                    to your business details.
                </p>

            </div>

        </div>


        {{-- =====================================================
             SUCCESS
        ====================================================== --}}

        @if(session('success'))

            <div class="aadhaar-alert aadhaar-success">

                <i class="fa-solid fa-circle-check"></i>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif


        {{-- =====================================================
             ERROR
        ====================================================== --}}

        @if(session('error'))

            <div class="aadhaar-alert aadhaar-error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <div>
                    {{ session('error') }}
                </div>

            </div>

        @endif


        {{-- =====================================================
             VALIDATION ERRORS
        ====================================================== --}}

        @if($errors->any())

            <div class="aadhaar-alert aadhaar-error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <div>

                    <ul style="margin:0;padding-left:18px;">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif


        {{-- =====================================================
             SECURITY
        ====================================================== --}}

        <div class="security-box">

            <div class="security-icon">
                <i class="fa-solid fa-lock"></i>
            </div>

            <div>

                <h3>
                    Secure Identity Verification
                </h3>

                <p>
                    Enter the Aadhaar number belonging to the document
                    uploaded in Step 2. Your information is processed
                    securely according to the verification workflow.
                </p>

            </div>

        </div>


        {{-- =====================================================
             SELLER INFO
        ====================================================== --}}

        <div class="seller-info">

            <div class="seller-info-title">

                <i class="fa-solid fa-user-shield"></i>

                Seller Information

            </div>

            <p>
                Seller Email:
                <strong>{{ $seller->email }}</strong>
            </p>

            <p>
                Step 2 document verification is required before
                completing Aadhaar verification.
            </p>

        </div>


        {{-- =====================================================
             DOCUMENT STATUS
        ====================================================== --}}

        <div class="document-grid">

            {{-- BUSINESS --}}

            <div class="document-card">

                <div class="document-icon">

                    <i class="fa-solid fa-file-lines"></i>

                </div>

                <div>

                    <h4>
                        Business Certificate
                    </h4>

                    @if($seller->business_certificate_path)

                        <div class="document-status">

                            <i class="fa-solid fa-circle-check"></i>

                            Uploaded

                        </div>

                    @else

                        <div class="document-status pending">

                            <i class="fa-solid fa-circle-xmark"></i>

                            Not uploaded

                        </div>

                    @endif

                </div>

            </div>


            {{-- AADHAAR DOCUMENT --}}

            <div class="document-card">

                <div class="document-icon">

                    <i class="fa-solid fa-address-card"></i>

                </div>

                <div>

                    <h4>
                        Aadhaar Document
                    </h4>

                    @if($seller->aadhaar_document_path)

                        <div class="document-status">

                            <i class="fa-solid fa-circle-check"></i>

                            Uploaded

                        </div>

                    @else

                        <div class="document-status pending">

                            <i class="fa-solid fa-circle-xmark"></i>

                            Not uploaded

                        </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- =====================================================
             VERIFICATION FORM
        ====================================================== --}}

        <div class="verify-card">

            <div class="verify-card-header">

                <div class="verify-card-icon">

                    <i class="fa-solid fa-fingerprint"></i>

                </div>

                <div>

                    <h2>
                        Verify Aadhaar Number
                    </h2>

                    <p>
                        Enter your 12-digit Aadhaar number
                    </p>

                </div>

            </div>


            <form
                method="POST"
                action="{{ route('seller.verification.aadhaar.verify') }}"
            >

                @csrf

                <div class="aadhaar-field">

                    <label
                        class="aadhaar-label"
                        for="aadhaar_number"
                    >

                        Aadhaar Number

                        <span class="required">*</span>

                    </label>

                    <input
                        id="aadhaar_number"
                        type="text"
                        name="aadhaar_number"
                        class="aadhaar-input"
                        inputmode="numeric"
                        autocomplete="off"
                        maxlength="12"
                        minlength="12"
                        pattern="[0-9]{12}"
                        placeholder="Enter 12-digit Aadhaar number"
                        value="{{ old('aadhaar_number') }}"
                        required
                    >

                    <small class="input-help">

                        Please enter exactly 12 digits.
                        Do not enter spaces or dashes.

                    </small>

                </div>


                {{-- ACTIONS --}}

                <div class="aadhaar-actions">

                    <a
                        href="{{ route('seller.verification.documents') }}"
                        class="aadhaar-btn aadhaar-back"
                    >

                        <i class="fa-solid fa-arrow-left"></i>

                        Back to Step 2

                    </a>


                    <button
                        type="submit"
                        class="aadhaar-btn aadhaar-submit"
                    >

                        Verify & Continue

                        <i class="fa-solid fa-arrow-right"></i>

                    </button>

                </div>

            </form>

        </div>


        {{-- =====================================================
             FOOTER
        ====================================================== --}}

        <div class="aadhaar-footer">

            <i class="fa-solid fa-shield-halved"></i>

            SmartBasket Seller Verification • Step 3 of 6

        </div>

    </div>

</div>

@endsection