@extends('seller.partials.premium-layout')

@section('title', 'Seller Documents')

@php
    $step = 2;
@endphp

@section('content')

<div class="sb-card">

    <div class="sb-step">
        STEP 2 OF 6
    </div>

    <h1 class="sb-title">
        Upload your documents
    </h1>

    <p class="sb-description">
        Upload your Business Certificate and Aadhaar document.
        You can replace either document later if needed.
    </p>

    @if(session('success'))
        <div class="sb-alert sb-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="sb-alert sb-alert-error">
            {{ session('error') }}
        </div>
    @endif

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
        action="{{ route('seller.verification.documents.upload') }}"
        enctype="multipart/form-data"
    >

        @csrf

        <div class="sb-grid">

            {{-- BUSINESS CERTIFICATE --}}

            <div class="sb-field">

                <label class="sb-label">
                    Business Certificate
                    @if(!$seller->business_certificate_path)
                        *
                    @endif
                </label>

                <input
                    type="file"
                    name="business_certificate"
                    class="sb-input"
                    accept=".pdf,.jpg,.jpeg,.png,.webp"
                >

                @if($seller->business_certificate_path)

                    <small>
                        ✓ Business Certificate already uploaded.
                        You can select a new file to replace it.
                    </small>

                @else

                    <small>
                        PDF, JPG, JPEG, PNG or WEBP — Maximum 5 MB.
                    </small>

                @endif

            </div>


            {{-- AADHAAR DOCUMENT --}}

            <div class="sb-field">

                <label class="sb-label">
                    Aadhaar Document
                    @if(!$seller->aadhaar_document_path)
                        *
                    @endif
                </label>

                <input
                    type="file"
                    name="aadhaar_document"
                    class="sb-input"
                    accept=".pdf,.jpg,.jpeg,.png,.webp"
                >

                @if($seller->aadhaar_document_path)

                    <small>
                        ✓ Aadhaar document already uploaded.
                        You can select a new file to replace it.
                    </small>

                @else

                    <small>
                        PDF, JPG, JPEG, PNG or WEBP — Maximum 5 MB.
                    </small>

                @endif

            </div>

        </div>


        <div class="sb-actions">

            {{-- BACK TO STEP 1 --}}

            <a
                href="{{ route('seller.verification.email') }}"
                class="sb-btn"
            >
                ← Back
            </a>


            {{-- SAVE / CONTINUE --}}

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