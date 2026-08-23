@extends('seller.partials.premium-layout')

@section('title', 'Aadhaar Verification')

@php
    $step = 3;
@endphp

@section('content')

<div class="sb-card">

    <div class="sb-step">
        STEP 3 OF 6
    </div>

    <h1 class="sb-title">
        Aadhaar Verification
    </h1>

    <p class="sb-description">
        Verify your Aadhaar identity using the 12-digit Aadhaar number
        associated with the uploaded document.
    </p>


    {{-- SUCCESS MESSAGE --}}

    @if(session('success'))
        <div class="sb-alert sb-alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- ERROR MESSAGE --}}

    @if(session('error'))
        <div class="sb-alert sb-alert-error">
            {{ session('error') }}
        </div>
    @endif


    {{-- VALIDATION ERRORS --}}

    @if($errors->any())
        <div class="sb-alert sb-alert-error">

            <ul style="margin:0;padding-left:20px;">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>
    @endif


    {{-- SELLER INFORMATION --}}

    <div class="sb-info-box">

        <h3>
            Identity Verification
        </h3>

        <p>
            Seller:
            <strong>
                {{ $seller->email }}
            </strong>
        </p>

        <p>
            Enter the Aadhaar number belonging to the document
            uploaded in Step 2.
        </p>

    </div>


    {{-- DOCUMENT STATUS --}}

    <div class="sb-grid">

        <div class="sb-field">

            <label class="sb-label">
                Business Certificate
            </label>

            <div class="sb-input">

                @if($seller->business_certificate_path)

                    ✓ Uploaded

                @else

                    Not uploaded

                @endif

            </div>

        </div>


        <div class="sb-field">

            <label class="sb-label">
                Aadhaar Document
            </label>

            <div class="sb-input">

                @if($seller->aadhaar_document_path)

                    ✓ Uploaded

                @else

                    Not uploaded

                @endif

            </div>

        </div>

    </div>


    {{-- AADHAAR FORM --}}

    <form
        method="POST"
        action="{{ route('seller.verification.aadhaar.verify') }}"
    >

        @csrf

        <div class="sb-field">

            <label
                class="sb-label"
                for="aadhaar_number"
            >
                Aadhaar Number *
            </label>

            <input
                id="aadhaar_number"
                type="text"
                name="aadhaar_number"
                class="sb-input"
                inputmode="numeric"
                autocomplete="off"
                maxlength="12"
                minlength="12"
                pattern="[0-9]{12}"
                placeholder="Enter 12-digit Aadhaar number"
                value="{{ old('aadhaar_number', $seller->aadhaar_number ?? '') }}"
                required
            >

        </div>


        <div class="sb-actions">

            {{-- BACK TO STEP 2 --}}

            <a
                href="{{ route('seller.verification.documents') }}"
                class="sb-btn"
            >
                ← Back
            </a>


            {{-- CONTINUE TO STEP 4 --}}

            <button
                type="submit"
                class="sb-btn sb-btn-primary"
            >
                Verify & Continue →
            </button>

        </div>

    </form>

</div>

@endsection