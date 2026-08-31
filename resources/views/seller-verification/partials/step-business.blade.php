@php
    $businessType = old('business_type', $seller->business_type ?? '');
    $panNumber = old('pan_number', $seller->pan_number ?? '');
    $udyamNumber = old('udyam_number', $seller->udyam_number ?? '');
    $businessName = old('business_name', $seller->business_name ?? '');
    $businessAddress = old('shop_address', $seller->shop_address ?? '');
    $city = old('city', $seller->city ?? '');
    $state = old('state', $seller->state ?? '');
    $pincode = old('pincode', $seller->pincode ?? '');
@endphp

<div class="sb-step-content">
    <div class="sb-step-header">
        <div>
            <div class="sb-step-number">Step 4</div>
            <h2>Business details</h2>
        </div>
    </div>

    <div class="sb-form-grid">
        <div class="sb-form-field">
            <label for="business_type">Business type</label>
            <select id="business_type" name="business_type">
                <option value="">Select business type</option>
                <option value="Individual Seller" {{ $businessType === 'Individual Seller' ? 'selected' : '' }}>Individual Seller</option>
                <option value="Proprietorship" {{ $businessType === 'Proprietorship' ? 'selected' : '' }}>Proprietorship</option>
                <option value="Partnership" {{ $businessType === 'Partnership' ? 'selected' : '' }}>Partnership</option>
                <option value="Private Limited" {{ $businessType === 'Private Limited' ? 'selected' : '' }}>Private Limited</option>
                <option value="LLP" {{ $businessType === 'LLP' ? 'selected' : '' }}>LLP</option>
                <option value="Other" {{ $businessType === 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="sb-form-field">
            <label for="business_name">Business name</label>
            <input id="business_name" type="text" name="business_name" value="{{ $businessName }}" placeholder="Enter business name">
        </div>

        <div class="sb-form-field">
            <label for="pan_number">PAN</label>
            <input id="pan_number" type="text" name="pan_number" value="{{ $panNumber }}" placeholder="ABCDE1234F">
        </div>

        <div class="sb-form-field">
            <label for="udyam_number">Udyam number</label>
            <input id="udyam_number" type="text" name="udyam_number" value="{{ $udyamNumber }}" placeholder="UDYAM-XXXX">
        </div>

        <div class="sb-form-field full">
            <label for="shop_address">Business address</label>
            <textarea id="shop_address" name="shop_address" rows="3" placeholder="Street, area, landmark">{{ $businessAddress }}</textarea>
        </div>

        <div class="sb-form-field">
            <label for="city">City</label>
            <input id="city" type="text" name="city" value="{{ $city }}" placeholder="City">
        </div>

        <div class="sb-form-field">
            <label for="state">State</label>
            <input id="state" type="text" name="state" value="{{ $state }}" placeholder="State">
        </div>

        <div class="sb-form-field">
            <label for="pincode">Pincode</label>
            <input id="pincode" type="text" name="pincode" value="{{ $pincode }}" placeholder="6-digit pincode">
        </div>
    </div>
</div>
