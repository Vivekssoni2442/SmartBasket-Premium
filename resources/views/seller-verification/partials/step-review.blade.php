@php
    $verified = !empty($seller->email_verified_at);
    $documentsOk = !empty($seller->business_certificate_path) && !empty($seller->aadhaar_document_path);
    $aadhaarOk = !empty($seller->aadhaar_verified_at);
    $businessOk = !empty($seller->business_type) && !empty($seller->pan_number) && !empty($seller->udyam_number);
    $bankOk = !empty($seller->bank_account_holder) && !empty($seller->bank_account_number) && !empty($seller->bank_ifsc) && !empty($seller->bank_name);
@endphp

<div class="sb-step-content">
    <div class="sb-step-header">
        <div>
            <div class="sb-step-number">Step 6</div>
            <h2>Review &amp; submit</h2>
        </div>
    </div>

    <div class="sb-review-grid">
        <div class="sb-review-card">
            <h3>Personal / Seller information</h3>
            <p><strong>Name:</strong> {{ $seller->seller_name ?? 'Not provided' }}</p>
            <p><strong>Email:</strong> {{ $seller->email ?? 'Not provided' }}</p>
            <p><strong>Mobile:</strong> {{ $seller->mobile_number ?? 'Not provided' }}</p>
        </div>

        <div class="sb-review-card">
            <h3>Email verification</h3>
            <p>{{ $verified ? '✓ Verified' : 'Not verified' }}</p>
        </div>

        <div class="sb-review-card">
            <h3>Documents</h3>
            <p>{{ $documentsOk ? '✓ Uploaded and available' : 'Required documents missing' }}</p>
        </div>

        <div class="sb-review-card">
            <h3>Aadhaar verification</h3>
            <p>{{ $aadhaarOk ? '✓ Verified' : 'Pending / failed' }}</p>
        </div>

        <div class="sb-review-card">
            <h3>Business details</h3>
            <p>{{ $businessOk ? '✓ Complete' : 'Incomplete' }}</p>
        </div>

        <div class="sb-review-card">
            <h3>Bank details</h3>
            <p>{{ $bankOk ? '✓ Complete' : 'Incomplete' }}</p>
            @if(!empty($seller->bank_account_number))
                <p><strong>Masked account:</strong> XXXXX{{ substr((string) $seller->bank_account_number, -4) }}</p>
            @endif
        </div>
    </div>
</div>
