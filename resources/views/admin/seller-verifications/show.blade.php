@extends('layouts.admin')

@section('title', 'Seller Verification - ' . ($seller->shop_name ?? 'Seller'))

@section('breadcrumbs')
    <span>/</span>
    <a href="{{ route('admin.seller-verifications.index') }}">Seller verifications</a>
    <span>/</span>
    <span>{{ $seller->shop_name ?? 'Seller' }}</span>
@endsection

@section('extra-css')
<style>
body.admin-layout .admin-content .admin-verification-detail { width:100%; max-width:1500px; margin:0 auto; color:#E2E8F0; }
body.admin-layout .admin-content .admin-verification-detail .topbar { display:flex; align-items:flex-start; justify-content:space-between; gap:18px; margin:0 0 22px; flex-wrap:wrap; }
body.admin-layout .admin-content .admin-verification-detail .title h1 { margin:0; color:#F8FAFC; font-size:clamp(1.4rem,2vw,1.85rem); line-height:1.25; font-weight:800; letter-spacing:-.025em; }
body.admin-layout .admin-content .admin-verification-detail .title p { margin:7px 0 0; color:#94A3B8; line-height:1.6; }
body.admin-layout .admin-content .admin-verification-detail .status { display:inline-flex; align-items:center; margin-top:12px; padding:6px 10px; border:1px solid rgba(245,158,11,.28); border-radius:999px; background:rgba(245,158,11,.12); color:#FDE68A; font-size:.78rem; font-weight:700; }
body.admin-layout .admin-content .admin-verification-detail .grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:18px; }
body.admin-layout .admin-content .admin-verification-detail .card { min-width:0; padding:20px; color:#CBD5E1; background:#151C2F; border:1px solid #263249; border-radius:15px; box-shadow:0 10px 28px rgba(0,0,0,.16); }
body.admin-layout .admin-content .admin-verification-detail .card.full { grid-column:1/-1; }
body.admin-layout .admin-content .admin-verification-detail .card h2 { margin:0 0 16px; color:#F8FAFC; font-size:1rem; line-height:1.35; font-weight:750; }
body.admin-layout .admin-content .admin-verification-detail .profile { display:flex; align-items:center; gap:15px; margin-bottom:18px; min-width:0; }
body.admin-layout .admin-content .admin-verification-detail .logo,
body.admin-layout .admin-content .admin-verification-detail .logo-placeholder { width:68px; height:68px; flex:0 0 68px; object-fit:cover; border:1px solid #35435D; border-radius:14px; background:#0F1728; }
body.admin-layout .admin-content .admin-verification-detail .logo-placeholder { display:grid; place-items:center; color:#93C5FD; font-size:1.35rem; font-weight:800; }
body.admin-layout .admin-content .admin-verification-detail .shop-name { overflow-wrap:anywhere; color:#F8FAFC; font-size:1.1rem; line-height:1.4; font-weight:750; }
body.admin-layout .admin-content .admin-verification-detail .seller-name { margin-top:3px; color:#94A3B8; }
body.admin-layout .admin-content .admin-verification-detail .info-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:10px; }
body.admin-layout .admin-content .admin-verification-detail .info { min-width:0; padding:12px; border:1px solid #263249; border-radius:11px; background:#10182B; }
body.admin-layout .admin-content .admin-verification-detail .label { margin-bottom:5px; color:#94A3B8; font-size:.68rem; font-weight:750; letter-spacing:.055em; text-transform:uppercase; }
body.admin-layout .admin-content .admin-verification-detail .value { color:#E2E8F0; font-size:.88rem; line-height:1.5; font-weight:600; overflow-wrap:anywhere; }
body.admin-layout .admin-content .admin-verification-detail .documents { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:14px; }
body.admin-layout .admin-content .admin-verification-detail .document { min-width:0; padding:14px; border:1px solid #263249; border-radius:12px; background:#10182B; }
body.admin-layout .admin-content .admin-verification-detail .document h3 { margin:0 0 10px; color:#F1F5F9; font-size:.9rem; font-weight:700; }
body.admin-layout .admin-content .admin-verification-detail .document img { display:block; width:100%; height:240px; object-fit:contain; border:1px solid #35435D; border-radius:9px; background:#0B1020; }
body.admin-layout .admin-content .admin-verification-detail .document-link { display:inline-flex; align-items:center; gap:7px; margin-top:10px; color:#93C5FD; font-weight:700; text-decoration:none; }
body.admin-layout .admin-content .admin-verification-detail .document-link:hover { color:#BFDBFE; text-decoration:underline; }
body.admin-layout .admin-content .admin-verification-detail .actions { display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-top:8px; }
body.admin-layout .admin-content .admin-verification-detail .actions form { margin:0; }
body.admin-layout .admin-content .admin-verification-detail .btn { min-height:40px; display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:9px 14px; border:1px solid transparent; border-radius:9px; color:#fff; font:inherit; font-size:.85rem; font-weight:700; text-decoration:none; cursor:pointer; transition:filter .16s ease,transform .16s ease; }
body.admin-layout .admin-content .admin-verification-detail .btn:hover { filter:brightness(1.08); transform:translateY(-1px); }
body.admin-layout .admin-content .admin-verification-detail .btn-success { background:#059669; }
body.admin-layout .admin-content .admin-verification-detail .btn-danger { background:#E11D48; }
body.admin-layout .admin-content .admin-verification-detail .btn-secondary { color:#D7E0EF; background:#1A2439; border-color:#35435D; }
body.admin-layout .admin-content .admin-verification-detail .timeline { display:flex; flex-direction:column; gap:10px; }
body.admin-layout .admin-content .admin-verification-detail .log { padding:13px 14px; border:1px solid #263249; border-left:3px solid #3B82F6; border-radius:9px; background:#10182B; color:#CBD5E1; overflow-wrap:anywhere; }
body.admin-layout .admin-content .admin-verification-detail .log-title { margin-bottom:4px; color:#F1F5F9; font-weight:700; }
body.admin-layout .admin-content .admin-verification-detail .log-meta { margin-top:7px; color:#94A3B8; font-size:.78rem; }
body.admin-layout .admin-content .admin-verification-detail .empty { padding:22px 12px; color:#94A3B8; text-align:center; }
body.admin-layout .admin-content .admin-verification-detail :focus-visible { outline:3px solid #22D3EE; outline-offset:3px; }
@media (max-width:900px) { body.admin-layout .admin-content .admin-verification-detail .grid { grid-template-columns:minmax(0,1fr); } body.admin-layout .admin-content .admin-verification-detail .card.full { grid-column:auto; } }
@media (max-width:620px) { body.admin-layout .admin-content .admin-verification-detail .card { padding:15px; } body.admin-layout .admin-content .admin-verification-detail .info-grid, body.admin-layout .admin-content .admin-verification-detail .documents { grid-template-columns:minmax(0,1fr); } body.admin-layout .admin-content .admin-verification-detail .actions, body.admin-layout .admin-content .admin-verification-detail .actions form { width:100%; } body.admin-layout .admin-content .admin-verification-detail .actions .btn { width:100%; } body.admin-layout .admin-content .admin-verification-detail .document img { height:200px; } }
@media (prefers-reduced-motion:reduce) { body.admin-layout .admin-content .admin-verification-detail *, body.admin-layout .admin-content .admin-verification-detail *::before, body.admin-layout .admin-content .admin-verification-detail *::after { transition-duration:.01ms!important; animation-duration:.01ms!important; } }
</style>
@endsection

@section('content')
<div class="admin-verification-detail">

    <div class="topbar">
        <div class="title">
            <h1>Seller Verification</h1>
            <p>Review seller application and submitted documents.</p>

            <div class="status">
                {{ ucwords(str_replace('_', ' ', $seller->verification_status ?? 'pending')) }}
            </div>
        </div>

        <a
            href="{{ route('admin.seller-verifications.index') }}"
            class="back-btn"
        >
            <i class="fas fa-arrow-left" aria-hidden="true"></i> Back to Verifications
        </a>
    </div>


    <div class="grid">

        {{-- Seller Profile --}}
        <div class="card">

            <h2>Seller Profile</h2>

            <div class="profile">

                @if(!empty($seller->shop_logo))
                    <img
                        class="logo"
                        src="{{ asset('storage/' . $seller->shop_logo) }}"
                        alt="Shop Logo"
                    >
                @else
                    <div class="logo-placeholder">
                        {{ strtoupper(substr($seller->seller_name ?? 'S', 0, 1)) }}
                    </div>
                @endif

                <div>
                    <div class="shop-name">
                        {{ $seller->shop_name ?? 'N/A' }}
                    </div>

                    <div class="seller-name">
                        {{ $seller->seller_name ?? 'N/A' }}
                    </div>
                </div>

            </div>

            <div class="info-grid">

                <div class="info">
                    <div class="label">Seller ID</div>
                    <div class="value">{{ $seller->id ?? 'N/A' }}</div>
                </div>

                <div class="info">
                    <div class="label">Business Type</div>
                    <div class="value">{{ $seller->business_type ?? 'N/A' }}</div>
                </div>

                <div class="info">
                    <div class="label">Email</div>
                    <div class="value">{{ $seller->email ?? 'N/A' }}</div>
                </div>

                <div class="info">
                    <div class="label">Mobile</div>
                    <div class="value">{{ $seller->mobile_number ?? 'N/A' }}</div>
                </div>

                <div class="info">
                    <div class="label">Shop Name</div>
                    <div class="value">{{ $seller->shop_name ?? 'N/A' }}</div>
                </div>

                <div class="info">
                    <div class="label">GST Number</div>
                    <div class="value">{{ $seller->gst_number ?? 'N/A' }}</div>
                </div>

            </div>

        </div>


        {{-- Business Details --}}
        <div class="card">

            <h2>Business Details</h2>

            <div class="info-grid">

                <div class="info">
                    <div class="label">Business Name</div>
                    <div class="value">
                        {{ $seller->business_name ?? 'N/A' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">PAN Number</div>
                    <div class="value">
                        {{ $seller->pan_number ?? 'N/A' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">Udyam Number</div>
                    <div class="value">
                        {{ $seller->udyam_number ?? 'N/A' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">GST Number</div>
                    <div class="value">
                        {{ $seller->gst_number ?? 'N/A' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">Address</div>
                    <div class="value">
                        {{ $seller->business_address ?? $seller->shop_address ?? 'N/A' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">City</div>
                    <div class="value">
                        {{ $seller->business_city ?? $seller->city ?? 'N/A' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">State</div>
                    <div class="value">
                        {{ $seller->business_state ?? $seller->state ?? 'N/A' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">Pincode</div>
                    <div class="value">
                        {{ $seller->business_pincode ?? $seller->pincode ?? 'N/A' }}
                    </div>
                </div>

            </div>

        </div>


        {{-- Bank Details --}}
        <div class="card">

            <h2>Bank Details</h2>

            <div class="info-grid">

                <div class="info">
                    <div class="label">Account Holder</div>
                    <div class="value">
                        {{ $seller->bank_account_holder_name ?? $seller->bank_account_holder ?? 'N/A' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">Bank Name</div>
                    <div class="value">
                        {{ $seller->bank_name ?? 'N/A' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">Account Number</div>
                    <div class="value">
                        {{ $seller->bank_account_number ?? 'N/A' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">IFSC</div>
                    <div class="value">
                        {{ $seller->bank_ifsc ?? 'N/A' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">Branch</div>
                    <div class="value">
                        {{ $seller->bank_branch ?? 'N/A' }}
                    </div>
                </div>

            </div>

        </div>


        {{-- Verification Information --}}
        <div class="card">

            <h2>Verification Information</h2>

            <div class="info-grid">

                <div class="info">
                    <div class="label">Email Verified</div>
                    <div class="value">
                        {{ $seller->email_verified_at ? 'Yes' : 'No' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">Aadhaar Verified</div>
                    <div class="value">
                        {{ $seller->aadhaar_verified ? 'Yes' : ($seller->aadhaar_verified_at ? 'Yes' : 'No') }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">Application Step</div>
                    <div class="value">
                        {{ $seller->onboarding_step ?? 'N/A' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">Submitted At</div>
                    <div class="value">
                        {{ $seller->application_submitted_at ?? $seller->verification_submitted_at ?? 'N/A' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">Admin Review</div>
                    <div class="value">
                        {{ $seller->admin_reviewed_at ?? 'Pending' }}
                    </div>
                </div>

                <div class="info">
                    <div class="label">Current Status</div>
                    <div class="value">
                        {{ ucwords(str_replace('_', ' ', $seller->verification_status ?? 'pending')) }}
                    </div>
                </div>

            </div>

        </div>


        {{-- Documents --}}
        <div class="card full">

            <h2>Submitted Documents</h2>

            <div class="documents">

                {{-- Business Certificate --}}
                <div class="document">
                    <h3>Business Certificate</h3>

                    @if(!empty($seller->business_certificate_path))
                        <img
                            src="{{ asset('storage/' . $seller->business_certificate_path) }}"
                            alt="Business Certificate"
                        >

                        <a
                            class="document-link"
                            href="{{ asset('storage/' . $seller->business_certificate_path) }}"
                            target="_blank"
                        >
                            <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i> Open Document
                        </a>
                    @else
                        <div class="empty">Not uploaded</div>
                    @endif
                </div>


                {{-- Aadhaar --}}
                <div class="document">
                    <h3>Aadhaar Document</h3>

                    @if(!empty($seller->aadhaar_document_path))
                        <img
                            src="{{ asset('storage/' . $seller->aadhaar_document_path) }}"
                            alt="Aadhaar Document"
                        >

                        <a
                            class="document-link"
                            href="{{ asset('storage/' . $seller->aadhaar_document_path) }}"
                            target="_blank"
                        >
                            Open Document →
                        </a>
                    @else
                        <div class="empty">Not uploaded</div>
                    @endif
                </div>


                {{-- PAN --}}
                <div class="document">
                    <h3>PAN Document</h3>

                    @if(!empty($seller->pan_document_path))
                        <img
                            src="{{ asset('storage/' . $seller->pan_document_path) }}"
                            alt="PAN Document"
                        >

                        <a
                            class="document-link"
                            href="{{ asset('storage/' . $seller->pan_document_path) }}"
                            target="_blank"
                        >
                            Open Document →
                        </a>
                    @else
                        <div class="empty">Not uploaded</div>
                    @endif
                </div>


                {{-- Shop Proof --}}
                <div class="document">
                    <h3>Shop Proof</h3>

                    @if(!empty($seller->shop_proof_path))
                        <img
                            src="{{ asset('storage/' . $seller->shop_proof_path) }}"
                            alt="Shop Proof"
                        >

                        <a
                            class="document-link"
                            href="{{ asset('storage/' . $seller->shop_proof_path) }}"
                            target="_blank"
                        >
                            Open Document →
                        </a>
                    @else
                        <div class="empty">Not uploaded</div>
                    @endif
                </div>


                {{-- Bank Proof --}}
                <div class="document">
                    <h3>Bank Proof</h3>

                    @if(!empty($seller->bank_proof_path))
                        <img
                            src="{{ asset('storage/' . $seller->bank_proof_path) }}"
                            alt="Bank Proof"
                        >

                        <a
                            class="document-link"
                            href="{{ asset('storage/' . $seller->bank_proof_path) }}"
                            target="_blank"
                        >
                            Open Document →
                        </a>
                    @else
                        <div class="empty">Not uploaded</div>
                    @endif
                </div>

            </div>

        </div>


        {{-- Verification Logs --}}
        <div class="card full">

            <h2>Verification History</h2>

            @if(isset($logs) && $logs->count())

                <div class="timeline">

                    @foreach($logs as $log)

                        <div class="log">

                            <div class="log-title">
                                {{ $log->action ?? $log->event ?? 'Verification Update' }}
                            </div>

                            @if(!empty($log->description))
                                <div>
                                    {{ $log->description }}
                                </div>
                            @endif

                            <div class="log-meta">
                                {{ $log->created_at ?? '' }}
                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="empty">
                    No verification history available.
                </div>

            @endif

        </div>


        {{-- Admin Actions --}}
        <div class="card full">

            <h2>Admin Actions</h2>

            <div class="actions">

                @if(Route::has('admin.seller-verifications.approve'))
                    <form
                        method="POST"
                        action="{{ route('admin.seller-verifications.approve', $seller->id) }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="btn btn-success"
                            onclick="return confirm('Approve this seller verification?')"
                        >
                            <i class="fas fa-check" aria-hidden="true"></i> Approve Seller
                        </button>
                    </form>
                @endif


                @if(Route::has('admin.seller-verifications.reject'))
                    <form
                        method="POST"
                        action="{{ route('admin.seller-verifications.reject', $seller->id) }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="btn btn-danger"
                            onclick="return confirm('Reject this seller verification?')"
                        >
                            <i class="fas fa-xmark" aria-hidden="true"></i> Reject Seller
                        </button>
                    </form>
                @endif


                <a
                    href="{{ route('admin.seller-verifications.index') }}"
                    class="btn btn-secondary"
                >
                    Back
                </a>

            </div>

        </div>

    </div>

</div>
@endsection
