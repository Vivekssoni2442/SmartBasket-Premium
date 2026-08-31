@php
    $aadhaarVerified = !empty($seller->aadhaar_verified_at);
@endphp

<div class="sb-step-content">
    <div class="sb-step-header">
        <div>
            <div class="sb-step-number">Step 3</div>
            <h2>Aadhaar verification</h2>
        </div>
    </div>

    <div class="sb-form-grid">
        <div class="sb-form-field full">
            <label for="aadhaar_number">Aadhaar number</label>
            <input id="aadhaar_number" type="text" name="aadhaar_number" inputmode="numeric" maxlength="12" placeholder="12-digit Aadhaar number" value="{{ old('aadhaar_number', $seller->aadhaar_number ?? '') }}">
        </div>
    </div>

    <div class="sb-status-box {{ $aadhaarVerified ? 'success' : 'warning' }}">
        {{ $aadhaarVerified ? 'Aadhaar verification complete.' : 'Verification status remains pending until the provider confirms the record.' }}
    </div>
</div>
