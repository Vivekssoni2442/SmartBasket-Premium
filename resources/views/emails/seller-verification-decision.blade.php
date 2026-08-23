<div style="max-width:620px;margin:0 auto;padding:28px;font-family:Arial,sans-serif;color:#172033">
    <h2>{{ $decision === 'approved' ? 'Your seller application is approved' : 'Your seller application was not approved' }}</h2>
    <p>Hello {{ $seller->seller_name }},</p>
    @if($decision === 'approved')
        <p>Your SmartBasket seller account has been approved. Enter the 16-digit activation code sent separately to finish activating your account.</p>
    @else
        <p>Your application was reviewed but could not be approved at this time.</p>
        <p><strong>Reason:</strong> {{ $seller->rejection_reason }}</p>
        <p>Please correct the relevant information and contact SmartBasket support before re-applying.</p>
    @endif
    <p><strong>Application ID:</strong> {{ $seller->verification_reference_id ?: 'SB-'.$seller->id }}</p>
</div>
