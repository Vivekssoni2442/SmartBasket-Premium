<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Seller Verification - {{ $seller->shop_name ?? 'Seller' }}
    </title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f7fb;
            color: #172033;
        }

        .page {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .title h1 {
            margin: 0;
            font-size: 30px;
            font-weight: 800;
        }

        .title p {
            margin: 7px 0 0;
            color: #667085;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 17px;
            border-radius: 10px;
            text-decoration: none;
            background: #111827;
            color: #fff;
            font-weight: 700;
        }

        .status {
            display: inline-flex;
            padding: 8px 13px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 800;
            margin-top: 12px;
            background: #fff7ed;
            color: #c2410c;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
        }

        .card.full {
            grid-column: 1 / -1;
        }

        .card h2 {
            margin: 0 0 20px;
            font-size: 20px;
        }

        .profile {
            display: flex;
            gap: 18px;
            align-items: center;
            margin-bottom: 22px;
        }

        .logo {
            width: 90px;
            height: 90px;
            border-radius: 16px;
            object-fit: cover;
            background: #eef2f7;
            border: 1px solid #e5e7eb;
        }

        .logo-placeholder {
            width: 90px;
            height: 90px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eef2f7;
            color: #64748b;
            font-size: 28px;
            font-weight: 800;
        }

        .shop-name {
            font-size: 23px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .seller-name {
            color: #667085;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .info {
            padding: 14px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #edf0f4;
        }

        .label {
            font-size: 12px;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .value {
            font-size: 15px;
            font-weight: 700;
            word-break: break-word;
        }

        .documents {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .document {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 15px;
            background: #fafafa;
        }

        .document h3 {
            margin: 0 0 12px;
            font-size: 15px;
        }

        .document img {
            width: 100%;
            height: 260px;
            object-fit: contain;
            border-radius: 10px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
        }

        .document-link {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            font-weight: 700;
            color: #2563eb;
        }

        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .btn {
            border: 0;
            border-radius: 10px;
            padding: 12px 18px;
            font-weight: 800;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-success {
            background: #16a34a;
            color: #fff;
        }

        .btn-danger {
            background: #dc2626;
            color: #fff;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .timeline {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .log {
            padding: 15px;
            border-left: 4px solid #2563eb;
            background: #f8fafc;
            border-radius: 8px;
        }

        .log-title {
            font-weight: 800;
            margin-bottom: 5px;
        }

        .log-meta {
            color: #64748b;
            font-size: 13px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #64748b;
        }

        @media (max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .card.full {
                grid-column: auto;
            }

            .documents,
            .info-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .page {
                padding: 15px;
            }

            .title h1 {
                font-size: 24px;
            }

            .profile {
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

<div class="page">

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
            ← Back to Verifications
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
                            Open Document →
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
                            ✓ Approve Seller
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
                            ✕ Reject Seller
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

</body>
</html>

