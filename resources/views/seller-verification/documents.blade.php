<x-seller-verification.layout>

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h2 class="h4 mb-1">Step 2: Seller Business Verification</h2>

            <p class="text-muted mb-0">
                Both documents are required. They are stored privately and
                are only available to authorized SmartBasket reviewers.
            </p>
        </div>
    </div>


    {{-- ================================================================
        BACK TO STEP 1
    ================================================================= --}}

    <div class="mb-4">
        <a
            href="{{ route('seller.verification.email') }}"
            class="btn btn-outline-secondary"
        >
            ← Back to Email Verification
        </a>
    </div>


    {{-- ================================================================
        STEP 2 DOCUMENT UPLOAD
    ================================================================= --}}

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ route('seller.verification.documents.upload') }}"
    >

        @csrf


        {{-- BUSINESS CERTIFICATE --}}

        <div class="mb-3">

            <label
                class="form-label fw-semibold"
                for="business_certificate"
            >
                Shop / Business Certificate
            </label>

            <input
                class="form-control"
                id="business_certificate"
                type="file"
                name="business_certificate"
                accept=".jpg,.jpeg,.png,.webp"
                required
            >

            <div class="form-text">
                JPG, JPEG, PNG or WEBP · Maximum 5 MB
            </div>

        </div>


        {{-- AADHAAR DOCUMENT --}}

        <div class="mb-3">

            <label
                class="form-label fw-semibold"
                for="aadhaar_document"
            >
                Aadhaar Card
            </label>

            <input
                class="form-control"
                id="aadhaar_document"
                type="file"
                name="aadhaar_document"
                accept=".jpg,.jpeg,.png,.webp"
                required
            >

            <div class="form-text">
                JPG, JPEG, PNG or WEBP · Maximum 5 MB
            </div>

        </div>


        {{-- INFORMATION --}}

        <div class="alert alert-info small">

            <strong>Important:</strong>

            Both Business Certificate and Aadhaar Document are compulsory
            for completing Step 2.

        </div>


        {{-- ERRORS --}}

        @if ($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- SUCCESS --}}

        @if (session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        {{-- ERROR --}}

        @if (session('error'))

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

        @endif


        <div class="d-flex gap-2">

            <a
                href="{{ route('seller.verification.email') }}"
                class="btn btn-outline-secondary"
            >
                ← Back
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Upload Securely & Continue →
            </button>

        </div>

    </form>


    {{-- ================================================================
        DOCUMENTS ALREADY UPLOADED
    ================================================================= --}}

    @if(
        $seller->business_certificate_path &&
        $seller->aadhaar_document_path
    )

        <hr class="my-4">

        <div class="alert alert-success">

            <strong>Step 2 completed.</strong>

            <br>

            Business Certificate and Aadhaar Document have been uploaded
            successfully.

        </div>


        <div class="d-flex gap-2">

            <a
                href="{{ route('seller.verification.email') }}"
                class="btn btn-outline-secondary"
            >
                ← Step 1
            </a>

            <a
                href="{{ route('seller.verification.aadhaar') }}"
                class="btn btn-success"
            >
                Continue to Step 3 →
            </a>

        </div>

    @endif

</x-seller-verification.layout>