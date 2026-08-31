@php
    $businessUploaded = !empty($seller->business_certificate_path);
    $aadhaarUploaded = !empty($seller->aadhaar_document_path);
@endphp

<div class="sb-step-content">
    <div class="sb-step-header">
        <div>
            <div class="sb-step-number">Step 2</div>
            <h2>Documents / KYC</h2>
        </div>
    </div>

    <div class="sb-upload-grid">
        <div class="sb-upload-box {{ $businessUploaded ? 'done' : '' }}">
            <div class="sb-upload-label">Business certificate</div>
            <div class="sb-upload-state">{{ $businessUploaded ? 'Uploaded' : 'Required' }}</div>
            <input type="file" name="business_certificate" accept=".pdf,.jpg,.jpeg,.png,.webp">
        </div>

        <div class="sb-upload-box {{ $aadhaarUploaded ? 'done' : '' }}">
            <div class="sb-upload-label">Aadhaar document</div>
            <div class="sb-upload-state">{{ $aadhaarUploaded ? 'Uploaded' : 'Required' }}</div>
            <input type="file" name="aadhaar_document" accept=".pdf,.jpg,.jpeg,.png,.webp">
        </div>
    </div>
</div>
