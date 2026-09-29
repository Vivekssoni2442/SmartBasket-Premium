@extends('layouts.admin')

@section('title', 'Seller Details')

@section('breadcrumbs')
    <span>/</span>
    <a href="{{ route('admin.sellers.index') }}" style="color:var(--text-primary);text-decoration:none;">Sellers</a>
    <span>/</span>
    <span style="color:var(--text-primary);">{{ $seller->seller_name ?: 'Seller' }}</span>
@endsection

@section('content')
@php
    $products = $seller->products ?? collect();
    $orders = $seller->orders ?? collect();
    $sellerName = $seller->seller_name ?: ($seller->user?->name ?? 'Seller');
    $businessName = $seller->business_name ?: ($seller->shop_name ?: $sellerName);
    $phone = $seller->phone ?: ($seller->mobile_number ?: ($seller->mobile ?: null));
    $location = collect([$seller->city, $seller->state, $seller->pincode])->filter()->implode(', ');
    $status = $seller->getApplicationStatusLabel();
    $logo = $seller->shop_logo;
@endphp

<style>
    .sb-admin-seller-page{max-width:1500px;margin:0 auto}
    .sb-seller-hero{display:flex;justify-content:space-between;gap:20px;align-items:center;padding:22px;margin-bottom:20px;border:1px solid var(--border-color);border-radius:18px;background:var(--card-bg)}
    .sb-seller-identity{display:flex;align-items:center;gap:16px}
    .sb-seller-logo{width:76px;height:76px;border-radius:18px;object-fit:cover;border:1px solid var(--border-color);background:rgba(255,215,0,.08);display:flex;align-items:center;justify-content:center;color:var(--primary-gold);font-size:28px}
    .sb-seller-identity h1{margin:0 0 5px;color:var(--text-primary);font-size:26px}
    .sb-seller-identity p{margin:0;color:var(--text-secondary);font-size:12px}
    .sb-seller-actions{display:flex;gap:8px;flex-wrap:wrap}
    .sb-seller-btn{display:inline-flex;align-items:center;gap:7px;padding:9px 13px;border-radius:9px;text-decoration:none;border:1px solid var(--border-color);color:var(--text-primary);font-size:11px;font-weight:700}
    .sb-seller-btn.primary{background:rgba(255,215,0,.10);border-color:rgba(255,215,0,.25);color:var(--primary-gold)}
    .sb-seller-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px;margin-bottom:18px}
    .sb-seller-card{border:1px solid var(--border-color);border-radius:16px;background:var(--card-bg);overflow:hidden}
    .sb-seller-card h2{margin:0;padding:15px 17px;border-bottom:1px solid var(--border-color);font-size:14px;color:var(--text-primary)}
    .sb-seller-card h2 i{color:var(--primary-gold);margin-right:7px}
    .sb-seller-body{padding:16px}
    .sb-info-row{display:flex;justify-content:space-between;gap:18px;padding:10px 0;border-bottom:1px solid var(--border-color);font-size:11px}
    .sb-info-row:last-child{border-bottom:0}
    .sb-info-row span:first-child{color:var(--text-secondary);font-weight:650}.sb-info-row span:last-child{color:var(--text-primary);font-weight:700;text-align:right;word-break:break-word}
    .sb-badge{display:inline-flex;padding:5px 9px;border-radius:999px;background:rgba(34,197,94,.10);color:#22c55e;font-size:9px;font-weight:800}
    .sb-table-wrap{overflow:auto}.sb-table{width:100%;border-collapse:collapse}.sb-table th,.sb-table td{padding:11px 14px;border-bottom:1px solid var(--border-color);text-align:left;font-size:11px;color:var(--text-primary)}.sb-table th{color:var(--text-secondary);font-size:9px;text-transform:uppercase;letter-spacing:.5px}.sb-table tr:last-child td{border-bottom:0}
    .sb-password-note{padding:11px 12px;border:1px solid rgba(245,158,11,.2);background:rgba(245,158,11,.06);border-radius:10px;color:var(--text-secondary);font-size:10px;line-height:1.5}
    @media(max-width:900px){.sb-seller-grid{grid-template-columns:1fr}.sb-seller-hero{align-items:flex-start;flex-direction:column}}
</style>

<div class="sb-admin-seller-page">
    <div class="sb-seller-hero">
        <div class="sb-seller-identity">
            @if($logo)
                <img class="sb-seller-logo" src="{{ \Illuminate\Support\Facades\Storage::url($logo) }}" alt="Seller logo">
            @else
                <div class="sb-seller-logo"><i class="fas fa-store"></i></div>
            @endif
            <div>
                <h1>{{ $sellerName }}</h1>
                <p>{{ $businessName }} · {{ $seller->email }}</p>
                <div style="margin-top:9px"><span class="sb-badge">{{ $status }}</span></div>
            </div>
        </div>
        <div class="sb-seller-actions">
            <a class="sb-seller-btn" href="{{ route('admin.sellers.index') }}"><i class="fas fa-arrow-left"></i> Back</a>
            @if(Route::has('admin.seller-verifications.show'))
                <a class="sb-seller-btn primary" href="{{ route('admin.seller-verifications.show', $seller) }}"><i class="fas fa-shield-halved"></i> Review KYC</a>
            @endif
        </div>
    </div>

    <div class="sb-seller-grid">
        <section class="sb-seller-card">
            <h2><i class="fas fa-user"></i>Account & Login</h2>
            <div class="sb-seller-body">
                <div class="sb-info-row"><span>Seller Profile ID</span><span>{{ $seller->id }}</span></div>
                <div class="sb-info-row"><span>Linked User ID</span><span>{{ $seller->user_id ?: 'Not linked' }}</span></div>
                <div class="sb-info-row"><span>Seller Name</span><span>{{ $sellerName }}</span></div>
                <div class="sb-info-row"><span>Login Email</span><span>{{ $seller->email }}</span></div>
                <div class="sb-info-row"><span>Mobile</span><span>{{ $phone ?: '—' }}</span></div>
                <div class="sb-info-row"><span>Password</span><span>Protected / hashed</span></div>
                <div class="sb-info-row"><span>Email Verified</span><span>{{ $seller->email_verified_at ? 'Yes' : 'No' }}</span></div>
                <div class="sb-info-row"><span>Active</span><span>{{ $seller->is_active ? 'Yes' : 'No' }}</span></div>
                <div class="sb-info-row"><span>Joined</span><span>{{ $seller->created_at?->format('d M Y, h:i A') }}</span></div>
                <div class="sb-password-note"><i class="fas fa-lock"></i> The existing password cannot be displayed because SmartBasket stores passwords as one-way hashes. A new password can be set through the seller password/settings flow.</div>
            </div>
        </section>

        <section class="sb-seller-card">
            <h2><i class="fas fa-building"></i>Business & Contact</h2>
            <div class="sb-seller-body">
                <div class="sb-info-row"><span>Shop Name</span><span>{{ $seller->shop_name ?: '—' }}</span></div>
                <div class="sb-info-row"><span>Business Name</span><span>{{ $seller->business_name ?: '—' }}</span></div>
                <div class="sb-info-row"><span>Business Type</span><span>{{ $seller->business_type ?: '—' }}</span></div>
                <div class="sb-info-row"><span>GST Number</span><span>{{ $seller->gst_number ?: '—' }}</span></div>
                <div class="sb-info-row"><span>PAN Number</span><span>{{ $seller->pan_number ?: '—' }}</span></div>
                <div class="sb-info-row"><span>Udyam Number</span><span>{{ $seller->udyam_number ?: '—' }}</span></div>
                <div class="sb-info-row"><span>Aadhaar</span><span>{{ $seller->aadhaar_number ?: '—' }}</span></div>
                <div class="sb-info-row"><span>Location</span><span>{{ $location ?: '—' }}</span></div>
                <div class="sb-info-row"><span>Shop Address</span><span>{{ $seller->shop_address ?: ($seller->address ?: '—') }}</span></div>
            </div>
        </section>
    </div>

    <div class="sb-seller-grid">
        <section class="sb-seller-card">
            <h2><i class="fas fa-university"></i>Bank & Payment Details</h2>
            <div class="sb-seller-body">
                <div class="sb-info-row"><span>Account Holder</span><span>{{ $seller->bank_account_holder ?: ($seller->account_holder_name ?? '—') }}</span></div>
                <div class="sb-info-row"><span>Account Number</span><span>{{ $seller->bank_account_number ?: ($seller->account_number ?? '—') }}</span></div>
                <div class="sb-info-row"><span>IFSC</span><span>{{ $seller->bank_ifsc ?: ($seller->ifsc_code ?? '—') }}</span></div>
                <div class="sb-info-row"><span>Bank</span><span>{{ $seller->bank_name ?: '—' }}</span></div>
                <div class="sb-info-row"><span>Branch</span><span>{{ $seller->bank_branch ?: ($seller->branch_name ?? '—') }}</span></div>
                <div class="sb-info-row"><span>Online Payments</span><span>{{ $seller->online_payments_enabled ? 'Enabled' : 'Disabled' }}</span></div>
                <div class="sb-info-row"><span>Payment QR</span><span>{{ $seller->payment_qr ? 'Uploaded' : 'Not uploaded' }}</span></div>
            </div>
        </section>

        <section class="sb-seller-card">
            <h2><i class="fas fa-shield-halved"></i>Verification & KYC</h2>
            <div class="sb-seller-body">
                <div class="sb-info-row"><span>Status</span><span>{{ $status }}</span></div>
                <div class="sb-info-row"><span>Verification Step</span><span>{{ $seller->verification_step ?: '—' }}</span></div>
                <div class="sb-info-row"><span>Onboarding Step</span><span>{{ $seller->onboarding_step ?: '—' }}</span></div>
                <div class="sb-info-row"><span>Application Submitted</span><span>{{ $seller->application_submitted_at?->format('d M Y, h:i A') ?: '—' }}</span></div>
                <div class="sb-info-row"><span>Approved At</span><span>{{ $seller->approved_at?->format('d M Y, h:i A') ?: '—' }}</span></div>
                <div class="sb-info-row"><span>Rejected At</span><span>{{ $seller->rejected_at?->format('d M Y, h:i A') ?: '—' }}</span></div>
                <div class="sb-info-row"><span>Rejection Reason</span><span>{{ $seller->rejection_reason ?: '—' }}</span></div>
                <div class="sb-info-row"><span>Admin Notes</span><span>{{ $seller->admin_notes ?: '—' }}</span></div>
            </div>
        </section>
    </div>

    <section class="sb-seller-card" style="margin-bottom:18px;">
        <h2><i class="fas fa-chart-simple"></i>Seller Summary</h2>
        <div class="sb-seller-body" style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
            <div class="sb-info-row" style="display:block;border:1px solid var(--border-color);padding:14px;border-radius:10px"><span>Products</span><div style="font-size:20px;margin-top:5px">{{ $products->count() }}</div></div>
            <div class="sb-info-row" style="display:block;border:1px solid var(--border-color);padding:14px;border-radius:10px"><span>Linked Orders</span><div style="font-size:20px;margin-top:5px">{{ $orders->count() }}</div></div>
            <div class="sb-info-row" style="display:block;border:1px solid var(--border-color);padding:14px;border-radius:10px"><span>Store Theme</span><div style="font-size:20px;margin-top:5px">{{ ucfirst($seller->theme ?: 'light') }}</div></div>
        </div>
    </section>

    <section class="sb-seller-card" style="margin-bottom:18px;">
        <h2><i class="fas fa-box-open"></i>Products</h2>
        <div class="sb-table-wrap">
            <table class="sb-table">
                <thead><tr><th>ID</th><th>Product</th><th>Price</th><th>Stock</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>#{{ $product->id }}</td><td>{{ $product->name ?: 'Unnamed' }}</td><td>₹{{ number_format((float)($product->price ?? 0),2) }}</td><td>{{ $product->stock ?? 0 }}</td><td>{{ ucfirst($product->status ?? 'active') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--text-secondary);padding:25px">No products found for this seller.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="sb-seller-card">
        <h2><i class="fas fa-receipt"></i>Recent Orders</h2>
        <div class="sb-table-wrap">
            <table class="sb-table">
                <thead><tr><th>Order</th><th>Customer</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td><td>{{ $order->user?->name ?? $order->user?->email ?? 'Customer' }}</td><td>₹{{ number_format((float)($order->amount ?? $order->total ?? 0),2) }}</td><td>{{ ucfirst($order->order_status ?? $order->status ?? 'pending') }}</td><td>{{ $order->created_at?->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--text-secondary);padding:25px">No orders linked to this seller.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
