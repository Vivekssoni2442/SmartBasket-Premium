@php
    $holder = old('bank_account_holder', $seller->bank_account_holder ?? '');
    $bankName = old('bank_name', $seller->bank_name ?? '');
    $ifsc = old('bank_ifsc', $seller->bank_ifsc ?? '');
@endphp

<div class="sb-step-content">
    <div class="sb-step-header">
        <div>
            <div class="sb-step-number">Step 5</div>
            <h2>Bank details</h2>
        </div>
    </div>

    <div class="sb-form-grid">
        <div class="sb-form-field">
            <label for="bank_account_holder">Account holder name</label>
            <input id="bank_account_holder" type="text" name="bank_account_holder" value="{{ $holder }}" placeholder="Account holder name">
        </div>

        <div class="sb-form-field">
            <label for="bank_name">Bank name</label>
            <input id="bank_name" type="text" name="bank_name" value="{{ $bankName }}" placeholder="Bank name">
        </div>

        <div class="sb-form-field">
            <label for="bank_account_number">Account number</label>
            <input id="bank_account_number" type="text" name="bank_account_number" inputmode="numeric" placeholder="Enter account number">
        </div>

        <div class="sb-form-field">
            <label for="bank_account_number_confirmation">Confirm account number</label>
            <input id="bank_account_number_confirmation" type="text" name="bank_account_number_confirmation" inputmode="numeric" placeholder="Confirm account number">
        </div>

        <div class="sb-form-field">
            <label for="bank_ifsc">IFSC code</label>
            <input id="bank_ifsc" type="text" name="bank_ifsc" value="{{ $ifsc }}" placeholder="SBIN0001234">
        </div>

        <div class="sb-form-field">
            <label for="account_type">Account type</label>
            <select id="account_type" name="account_type">
                <option value="">Select account type</option>
                <option value="Savings">Savings</option>
                <option value="Current">Current</option>
                <option value="Business">Business</option>
            </select>
        </div>
    </div>
</div>
