@php
    $emailVerified = !empty($seller->email_verified_at);
@endphp

<div class="sb-step-content">
    <div class="sb-step-header">
        <div>
            <div class="sb-step-number">Step 1</div>
            <h2>Email verification</h2>
        </div>
    </div>

    <div class="sb-form-grid">
        <div class="sb-form-field full">
            <label for="seller_email">Seller email</label>
            <input id="seller_email" type="email" value="{{ old('email', $seller->email ?? '') }}" readonly>
        </div>

        <div class="sb-form-field full">
            <label for="verification_code">Verification code</label>
            <input id="verification_code" type="text" inputmode="numeric" maxlength="16" placeholder="Enter 16-digit code" name="code">
        </div>
    </div>

    <div class="sb-status-box {{ $emailVerified ? 'success' : 'warning' }}">
        {{ $emailVerified ? 'Email verified successfully.' : 'A secure verification code will be sent to your registered seller email.' }}
    </div>
</div>
