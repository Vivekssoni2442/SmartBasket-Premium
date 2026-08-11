<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Profile | Smart Basket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>
<body class="bg-dark text-white" data-sb-theme="{{ $seller->theme ?? 'dark' }}">
<main class="container py-5" style="max-width:900px;">
    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
        <div>
            <p class="text-primary fw-semibold mb-1">SELLER PANEL</p>
            <h1 class="h2 mb-1">Seller Profile</h1>
            <p class="text-muted mb-0">Your registered Smart Basket seller information.</p>
        </div>
        <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <section class="card bg-black text-white border-secondary shadow-sm">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex align-items-center gap-3 mb-4">
                @if($seller->shop_logo)
                    @php($logoUrl = str_starts_with($seller->shop_logo, 'seller-logos/') ? asset('storage/'.$seller->shop_logo) : asset('seller-logos/'.$seller->shop_logo))
                    <img src="{{ $logoUrl }}" alt="{{ $seller->seller_name }}" class="rounded-circle border" width="80" height="80" style="object-fit:cover;">
                @else
                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width:80px;height:80px;font-size:2rem;"><i class="fa-solid fa-store"></i></div>
                @endif
                <div>
                    <h2 class="h4 mb-1">{{ $seller->seller_name }}</h2>
                    <p class="text-muted mb-0">Seller ID #{{ $seller->id }}</p>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6"><strong>Seller Name</strong><div class="text-muted">{{ $seller->seller_name }}</div></div>
                <div class="col-md-6"><strong>Shop Name</strong><div class="text-muted">{{ $seller->shop_name }}</div></div>
                <div class="col-md-6"><strong>Email</strong><div class="text-muted">{{ $seller->email }}</div></div>
                <div class="col-md-6"><strong>Mobile Number</strong><div class="text-muted">{{ $seller->mobile_number }}</div></div>
                <div class="col-md-6"><strong>Registration Date</strong><div class="text-muted">{{ $seller->created_at?->format('d M Y, h:i A') }}</div></div>
                <div class="col-md-6"><strong>Last Updated</strong><div class="text-muted">{{ $seller->updated_at?->format('d M Y, h:i A') }}</div></div>
                @if($seller->shop_address)<div class="col-md-6"><strong>Shop Address</strong><div class="text-muted">{{ $seller->shop_address }}</div></div>@endif
                @if($seller->city)<div class="col-md-4"><strong>City</strong><div class="text-muted">{{ $seller->city }}</div></div>@endif
                @if($seller->state)<div class="col-md-4"><strong>State</strong><div class="text-muted">{{ $seller->state }}</div></div>@endif
                @if($seller->pincode)<div class="col-md-4"><strong>Pincode</strong><div class="text-muted">{{ $seller->pincode }}</div></div>@endif
                @if($seller->gst_number)<div class="col-md-6"><strong>GST Number</strong><div class="text-muted">{{ $seller->gst_number }}</div></div>@endif
            </div>

            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#editProfile" aria-expanded="{{ $errors->any() ? 'true' : 'false' }}">
                <i class="fa-solid fa-pen me-1"></i> Edit Profile
            </button>

            <div class="collapse {{ $errors->any() ? 'show' : '' }} mt-4" id="editProfile">
                <hr class="border-secondary"><h3 class="h5 mb-3">Edit Profile</h3>
                <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6"><label class="form-label">Seller Name</label><input class="form-control" name="seller_name" value="{{ old('seller_name', $seller->seller_name) }}" required></div>
                    <div class="col-md-6"><label class="form-label">Shop Name</label><input class="form-control" name="shop_name" value="{{ old('shop_name', $seller->shop_name) }}" required></div>
                    <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="{{ old('email', $seller->email) }}" required></div>
                    <div class="col-md-6"><label class="form-label">Mobile Number</label><input class="form-control" name="mobile_number" value="{{ old('mobile_number', $seller->mobile_number) }}" required></div>
                    <div class="col-md-6"><label class="form-label">Shop Logo / Profile Photo</label><input class="form-control" type="file" name="shop_logo" accept="image/jpeg,image/png,image/jpg,image/webp"></div>
                    <div class="col-12 d-flex gap-2"><button class="btn btn-primary">Save Changes</button><a href="{{ route('seller.profile') }}" class="btn btn-outline-secondary">Cancel</a></div>
                </form>
            </div>
            <hr class="border-secondary"><h3 class="h5">Payment QR / QR Scanner</h3><p class="text-muted small">This QR is shown only to customers paying for your products.</p>
            @if($seller->payment_qr)<img src="{{ asset('storage/'.$seller->payment_qr) }}" alt="Your payment QR" width="150" class="mb-3 d-block">@endif
            <form method="POST" action="{{ route('seller.payment-qr.update') }}" enctype="multipart/form-data" class="row g-2">
                @csrf
                <div class="col-md-8"><input class="form-control" name="payment_qr" type="file" accept="image/jpeg,image/png,image/jpg,image/webp" required></div>
                <div class="col-md-4"><button class="btn btn-outline-primary w-100">Upload Payment QR</button></div>
            </form>
            @if($seller->payment_qr)
                <form method="POST" action="{{ route('seller.payment-qr.delete') }}" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm">Remove Payment QR</button>
                </form>
            @endif
        </div>
    </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
