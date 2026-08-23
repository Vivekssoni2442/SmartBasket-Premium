<h1>SmartBasket Seller Account Activated</h1>
<p>A seller has completed onboarding and is now <strong>ACTIVE</strong>.</p>
<h2>Seller information</h2>
<ul><li>Seller ID: {{ $seller->id }}</li><li>Name: {{ $seller->seller_name }}</li><li>Shop: {{ $seller->shop_name }}</li><li>Email: {{ $seller->email }}</li><li>Mobile: {{ $seller->mobile_number }}</li><li>Business type: {{ $seller->business_type ?: 'Not provided' }}</li></ul>
<h2>Business information</h2>
<ul><li>Address: {{ $seller->shop_address }}</li><li>City/State: {{ $seller->city }}, {{ $seller->state }}</li><li>Pincode: {{ $seller->pincode }}</li><li>GST: {{ $seller->gst_number ?: 'Not provided' }}</li><li>PAN: {{ $seller->pan_number ? 'Provided' : 'Not provided' }}</li><li>Udyam: {{ $seller->udyam_number ? 'Provided' : 'Not provided' }}</li></ul>
<h2>Bank information</h2>
<ul><li>Bank: {{ $seller->bank_name ?: 'Not provided' }}</li><li>Account holder: {{ $seller->bank_account_holder ?: 'Not provided' }}</li><li>Account: {{ $seller->bank_account_number ? str_repeat('*', max(0, strlen($seller->bank_account_number) - 4)).substr($seller->bank_account_number, -4) : 'Not provided' }}</li><li>IFSC: {{ $seller->bank_ifsc ?: 'Not provided' }}</li></ul>
<h2>Verification</h2>
<ul><li>Email verified: {{ optional($seller->email_verified_at)->toDayDateTimeString() ?: 'No' }}</li><li>Documents uploaded: {{ optional($seller->business_certificate_uploaded_at)->toDayDateTimeString() ?: 'No' }}</li><li>Submitted: {{ optional($seller->verification_submitted_at)->toDayDateTimeString() ?: 'No' }}</li><li>Reviewed: {{ optional($seller->admin_reviewed_at)->toDayDateTimeString() ?: 'No' }}</li><li>Approved: {{ optional($seller->approved_at)->toDayDateTimeString() ?: 'No' }}</li><li>Activated: {{ optional($seller->activation_verified_at)->toDayDateTimeString() }}</li></ul>
<h2>Documents</h2><p>Business Certificate: {{ $seller->business_certificate_path ? 'YES' : 'NO' }}<br>Aadhaar Document: {{ $seller->aadhaar_document_path ? 'YES' : 'NO' }}<br>PAN Document: {{ $seller->pan_document_path ? 'YES' : 'NO' }}<br>Shop Proof: {{ $seller->shop_proof_path ? 'YES' : 'NO' }}<br>Bank Proof: {{ $seller->bank_proof_path ? 'YES' : 'NO' }}</p>
@if($documentsNotAttached)<p>Some documents were not attached because of the email attachment size limit. Use the secure admin document routes to review them.</p>@endif
