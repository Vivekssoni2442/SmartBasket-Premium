<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seller application #{{ $application->id }} · SmartBasket Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <main class="container py-5">
        <a class="btn btn-outline-secondary btn-sm mb-3" href="{{ route('admin.seller-verifications.index') }}">← All requests</a>
        <h1 class="h3">Seller application #{{ $application->id }}</h1>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <div class="row g-4">
            <section class="col-lg-7"><div class="card shadow-sm"><div class="card-body">
                <h2 class="h5">Seller information</h2>
                <dl class="row mb-0">
                    <dt class="col-sm-4">Seller</dt><dd class="col-sm-8">{{ $application->seller_name }}</dd>
                    <dt class="col-sm-4">Email</dt><dd class="col-sm-8">{{ $application->email }}</dd>
                    <dt class="col-sm-4">Shop</dt><dd class="col-sm-8">{{ $application->shop_name }}</dd>
                    <dt class="col-sm-4">Status</dt><dd class="col-sm-8">{{ str_replace('_', ' ', $application->verification_status) }}</dd>
                    <dt class="col-sm-4">Email verified</dt><dd class="col-sm-8">{{ $application->email_verified_at?->format('d M Y, H:i') ?? 'No' }}</dd>
                    <dt class="col-sm-4">Aadhaar status</dt><dd class="col-sm-8">{{ $application->aadhaar_verified_at ? 'Verified by provider' : 'Not verified' }}</dd>
                    <dt class="col-sm-4">Provider reference</dt><dd class="col-sm-8">{{ $application->verification_reference_id ?? '—' }}</dd>
                    <dt class="col-sm-4">Submitted</dt><dd class="col-sm-8">{{ $application->verification_submitted_at?->format('d M Y, H:i') ?? '—' }}</dd>
                    <dt class="col-sm-4">Certificate</dt><dd class="col-sm-8">@if($application->business_certificate_path)<a href="{{ route('admin.seller-verifications.document', $application) }}">Download private certificate</a>@else — @endif</dd>
                </dl>
            </div></div></section>
            <aside class="col-lg-5"><div class="card shadow-sm"><div class="card-body"><h2 class="h5">Decision</h2>
                @if($application->verification_status === \App\Models\SellerProfile::STATUS_PENDING_REVIEW)
                    <form method="post" action="{{ route('admin.seller-verifications.approve', $application) }}" class="mb-3">@csrf<button class="btn btn-success w-100">Approve seller</button></form>
                    <form method="post" action="{{ route('admin.seller-verifications.reject', $application) }}">@csrf<textarea class="form-control mb-2" name="reason" maxlength="2000" required placeholder="Rejection reason"></textarea><button class="btn btn-outline-danger w-100">Reject seller</button></form>
                @else
                    <p class="mb-0">Decision: {{ str_replace('_', ' ', $application->verification_status) }}</p>
                    @if($application->rejection_reason)<p class="text-danger mt-2 mb-0">{{ $application->rejection_reason }}</p>@endif
                @endif
            </div></div></aside>
            <section class="col-12"><div class="card shadow-sm"><div class="card-body"><h2 class="h5">Verification history</h2><ul class="mb-0">@forelse($history as $entry)<li>{{ $entry->created_at->format('d M Y, H:i') }} — {{ str_replace('_', ' ', $entry->event) }}</li>@empty<li class="text-muted">No history recorded.</li>@endforelse</ul></div></div></section>
        </div>
    </main>
</body>
</html>
