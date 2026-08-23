@extends('seller.partials.premium-layout')

@section('title', 'Review Seller Application')

@php
    $step = 6;
@endphp

@section('content')

<div class="sb-card">

    <div class="sb-step">
        STEP 6 OF 6
    </div>

    <h1 class="sb-title">
        Review your application
    </h1>

    <p class="sb-description">
        Everything looks good? You can still edit any section before submitting.
    </p>


    {{-- ACCOUNT --}}

    <div class="sb-summary">

        <div class="sb-summary-row">

            <div>
                <div class="sb-summary-label">
                    Seller Name
                </div>

                <div class="sb-summary-value">
                    {{ $seller->seller_name }}
                </div>
            </div>

            <a
                href="{{ route('seller.verification.email') }}"
                class="sb-btn"
            >
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
                    {{ $seller->business_type ?: 'Not provided' }}
                </div>
            </div>

            <a
                href="{{ route('seller.business-details') }}"
                class="sb-btn"
            >
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
                        ✓ Documents uploaded
                    @else
                        Documents incomplete
                    @endif
                </div>
            </div>

            <a
                href="{{ route('seller.verification.documents') }}"
                class="sb-btn"
            >
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
                        ✓ Verified
                    @else
                        Pending
                    @endif

                </div>

            </div>

            <a
                href="{{ route('seller.verification.aadhaar') }}"
                class="sb-btn"
            >
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
                    {{ $seller->bank_name ?: 'Not provided' }}
                </div>

            </div>

            <a
                href="{{ route('seller.bank-details') }}"
                class="sb-btn"
            >
                Edit
            </a>

        </div>

    </div>


    <div class="sb-actions">

        {{-- FIXED: seller.verification.bank does not exist --}}
        <a
    href="{{ route('seller.verification.bank-details') }}"
    class="sb-btn"
>
    ← Back
</a>

        <form
            method="POST"
            action="{{ route('seller.verification.submit') }}"
        >

            @csrf

            <button
                type="submit"
                class="sb-btn sb-btn-primary"
            >
                ✓ Submit Seller Application
            </button>

        </form>

    </div>

</div>

@endsection