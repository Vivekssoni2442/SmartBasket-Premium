@extends('seller.partials.premium-layout')

@section('title', 'Business Details')

@php
    $step = 4;
@endphp

@section('content')

<div class="sb-card">

    <div class="sb-step">
        STEP 4 OF 6
    </div>

    <h1 class="sb-title">
        Tell us about your business
    </h1>

    <p class="sb-description">
        Enter your business information. You can return and edit
        these details later.
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


    <form
        method="POST"
        action="{{ route('seller.verification.business-details.update') }}"
    >

        @csrf
        @method('PUT')


        <div class="sb-grid">


            {{-- BUSINESS TYPE --}}

            <div class="sb-field">

                <label class="sb-label">
                    Business Type *
                </label>

                <select
                    name="business_type"
                    class="sb-select"
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

            </div>


            {{-- GST --}}

            <div class="sb-field">

                <label class="sb-label">
                    GST Number
                </label>

                <input
                    type="text"
                    name="gst_number"
                    class="sb-input"
                    value="{{ old('gst_number', $seller->gst_number) }}"
                    placeholder="Enter GST number"
                    autocomplete="off"
                >

            </div>


            {{-- PAN --}}

            <div class="sb-field">

                <label class="sb-label">
                    PAN Number *
                </label>

                <input
                    type="text"
                    name="pan_number"
                    class="sb-input"
                    value="{{ old('pan_number', $seller->pan_number) }}"
                    placeholder="Enter PAN number"
                    autocomplete="off"
                    required
                >

            </div>


            {{-- UDYAM --}}

            <div class="sb-field">

                <label class="sb-label">
                    Udyam Number *
                </label>

                <input
                    type="text"
                    name="udyam_number"
                    class="sb-input"
                    value="{{ old('udyam_number', $seller->udyam_number) }}"
                    placeholder="Enter Udyam number"
                    autocomplete="off"
                    required
                >

            </div>

        </div>


        <div class="sb-actions">


            {{-- BACK TO STEP 3 --}}

            <a
                href="{{ route('seller.verification.aadhaar') }}"
                class="sb-btn"
            >
                ← Back
            </a>


            {{-- CONTINUE TO STEP 5 --}}

            <button
                type="submit"
                class="sb-btn sb-btn-primary"
            >
                Save & Continue →
            </button>

        </div>

    </form>

</div>

@endsection


<style>

    /*
     * Dark theme dropdown
     */

    .sb-select {
        color: #f8fafc !important;
        background-color: #111827 !important;
        color-scheme: dark;
    }

    .sb-select option {
        color: #f8fafc !important;
        background-color: #111827 !important;
    }

    .sb-select option:checked,
    .sb-select option:hover {
        color: #ffffff !important;
        background-color: #1f2937 !important;
    }

    /*
     * Placeholder
     */

    .sb-select option[value=""] {
        color: #9ca3af !important;
        background-color: #111827 !important;
    }


    /*
     * Light theme
     */

    html.light .sb-select,
    body.light .sb-select {
        color: #111827 !important;
        background-color: #ffffff !important;
        color-scheme: light;
    }

    html.light .sb-select option,
    body.light .sb-select option {
        color: #111827 !important;
        background-color: #ffffff !important;
    }

    html.light .sb-select option[value=""],
    body.light .sb-select option[value=""] {
        color: #6b7280 !important;
    }

</style>