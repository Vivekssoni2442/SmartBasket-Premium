@extends('layouts.admin')

@section('title', 'Seller Profile')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | Safe Seller Data
    |--------------------------------------------------------------------------
    */
    $products = collect($seller->products ?? []);

    $productCount = $products->count();

    try {
        $orderCount = $seller->orders()->count();
    } catch (\Throwable $e) {
        $orderCount = 0;
    }

    $sellerName = $seller->name
        ?? $seller->seller_name
        ?? 'Seller';

    $businessName = $seller->business_name
        ?? $seller->shop_name
        ?? $sellerName;

    $phone = $seller->phone
        ?? $seller->mobile
        ?? $seller->mobile_number
        ?? null;

    $businessType = $seller->business_type ?? null;

    $city = $seller->business_city
        ?? $seller->city
        ?? null;

    $state = $seller->business_state
        ?? $seller->state
        ?? null;

    $pincode = $seller->business_pincode
        ?? $seller->pincode
        ?? null;

    $location = collect([
        $city,
        $state,
        $pincode
    ])->filter()->implode(', ');

    try {
        $verificationStatus = $seller->getApplicationStatusLabel();
    } catch (\Throwable $e) {
        $verificationStatus = $seller->verification_status
            ?? 'Not available';
    }
@endphp

<style>
    .seller-profile-page {
        width: 100%;
    }

    .seller-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .seller-page-title-wrap {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .seller-page-icon {
        width: 52px;
        height: 52px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #4f46e5;
        font-size: 22px;
        flex-shrink: 0;
    }

    .seller-page-title {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        color: #111827;
        letter-spacing: -0.5px;
    }

    .seller-page-description {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .seller-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .seller-back-btn,
    .seller-kyc-btn {
        min-height: 42px;
        padding: 0 16px;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        transition: .2s ease;
    }

    .seller-back-btn {
        background: #ffffff;
        color: #374151;
        border: 1px solid #e5e7eb;
    }

    .seller-back-btn:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }

    .seller-kyc-btn {
        background: #4f46e5;
        color: #ffffff;
        border: 1px solid #4f46e5;
        box-shadow: 0 8px 20px rgba(79, 70, 229, .18);
    }

    .seller-kyc-btn:hover {
        background: #4338ca;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .seller-stat-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 22px;
    }

    .seller-stat-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, .04);
    }

    .seller-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        color: #4f46e5;
        font-size: 18px;
        flex-shrink: 0;
    }

    .seller-stat-label {
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 4px;
    }

    .seller-stat-value {
        color: #111827;
        font-size: 23px;
        font-weight: 800;
        line-height: 1.2;
    }

    .seller-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 17px;
        margin-bottom: 22px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(15, 23, 42, .04);
    }

    .seller-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #eef0f3;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .seller-card-title {
        margin: 0;
        color: #111827;
        font-size: 16px;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .seller-card-title i {
        color: #4f46e5;
    }

    .seller-card-body {
        padding: 0;
    }

    .seller-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .seller-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .seller-table th,
    .seller-table td {
        padding: 15px 20px;
        border-bottom: 1px solid #f0f1f3;
        text-align: left;
        vertical-align: middle;
        font-size: 13px;
    }

    .seller-table tr:last-child th,
    .seller-table tr:last-child td {
        border-bottom: none;
    }

    .seller-table th {
        width: 180px;
        color: #6b7280;
        font-weight: 700;
        background: #fafafa;
    }

    .seller-table td {
        color: #1f2937;
        font-weight: 500;
    }

    .seller-product-name {
        font-weight: 700;
        color: #111827;
    }

    .seller-price {
        font-weight: 800;
        color: #111827;
    }

    .seller-stock {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 8px;
        background: #f3f4f6;
        color: #374151;
        font-size: 12px;
        font-weight: 700;
    }

    .seller-view-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 9px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #374151;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        transition: .2s ease;
    }

    .seller-view-btn:hover {
        background: #f9fafb;
        color: #4f46e5;
        border-color: #c7d2fe;
    }

    .seller-empty {
        text-align: center !important;
        padding: 38px 20px !important;
        color: #9ca3af !important;
    }

    .seller-empty-icon {
        width: 52px;
        height: 52px;
        margin: 0 auto 12px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        color: #9ca3af;
        font-size: 20px;
    }

    .seller-empty-title {
        color: #374151;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .seller-empty-text {
        color: #9ca3af;
        font-size: 12px;
    }

    .seller-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        border-radius: 999px;
        background: #f3f4f6;
        color: #374151;
        font-size: 12px;
        font-weight: 800;
    }

    @media (max-width: 900px) {
        .seller-stat-grid {
            grid-template-columns: 1fr;
        }

        .seller-page-title {
            font-size: 23px;
        }
    }

    @media (max-width: 600px) {
        .seller-page-header {
            align-items: flex-start;
        }

        .seller-page-title-wrap {
            width: 100%;
        }

        .seller-actions {
            width: 100%;
        }

        .seller-back-btn,
        .seller-kyc-btn {
            flex: 1;
        }

        .seller-card-header {
            padding: 16px;
        }

        .seller-table th,
        .seller-table td {
            padding: 13px 15px;
        }
    }
</style>

<div class="seller-profile-page">

    {{-- PAGE HEADER --}}
    <div class="seller-page-header">

        <div class="seller-page-title-wrap">

            <div class="seller-page-icon">
                <i class="fas fa-store"></i>
            </div>

            <div>
                <h1 class="seller-page-title">
                    {{ $businessName }}
                </h1>

                <p class="seller-page-description">
                    Seller profile and live catalogue overview.
                </p>
            </div>

        </div>

        <div class="seller-actions">

            @if(Route::has('admin.sellers.index'))
                <a href="{{ route('admin.sellers.index') }}"
                   class="seller-back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
            @endif

            @if(Route::has('admin.seller-verifications.show'))
                <a class="seller-kyc-btn"
                   href="{{ route('admin.seller-verifications.show', $seller) }}">
                    <i class="fas fa-shield-halved"></i>
                    Review KYC
                </a>
            @endif

        </div>

    </div>


    {{-- STAT CARDS --}}
    <div class="seller-stat-grid">

        {{-- PRODUCTS --}}
        <div class="seller-stat-card">

            <div class="seller-stat-icon">
                <i class="fas fa-box"></i>
            </div>

            <div>
                <div class="seller-stat-label">
                    Products
                </div>

                <div class="seller-stat-value">
                    {{ $productCount }}
                </div>
            </div>

        </div>


        {{-- ORDERS --}}
        <div class="seller-stat-card">

            <div class="seller-stat-icon">
                <i class="fas fa-cart-shopping"></i>
            </div>

            <div>
                <div class="seller-stat-label">
                    Linked Orders
                </div>

                <div class="seller-stat-value">
                    {{ $orderCount }}
                </div>
            </div>

        </div>


        {{-- VERIFICATION --}}
        <div class="seller-stat-card">

            <div class="seller-stat-icon">
                <i class="fas fa-circle-check"></i>
            </div>

            <div>
                <div class="seller-stat-label">
                    Verification
                </div>

                <div class="seller-status">
                    <i class="fas fa-circle-check"></i>
                    {{ $verificationStatus }}
                </div>
            </div>

        </div>

    </div>


    {{-- BUSINESS INFORMATION --}}
    <div class="seller-card">

        <div class="seller-card-header">

            <h2 class="seller-card-title">
                <i class="fas fa-building"></i>
                Business Information
            </h2>

        </div>

        <div class="seller-card-body">

            <div class="seller-table-wrap">

                <table class="seller-table">

                    <tbody>

                        <tr>
                            <th>Seller Name</th>

                            <td>
                                {{ $sellerName }}
                            </td>
                        </tr>

                        <tr>
                            <th>Email</th>

                            <td>
                                {{ $seller->email ?? 'Not provided' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Contact</th>

                            <td>
                                {{ $phone ?: 'No phone provided' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Business</th>

                            <td>
                                {{ $businessName ?: 'Not provided' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Business Type</th>

                            <td>
                                {{ $businessType ?: 'Not provided' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Location</th>

                            <td>
                                {{ $location ?: 'Not provided' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Joined</th>

                            <td>
                                @if($seller->created_at)
                                    {{ \Carbon\Carbon::parse($seller->created_at)->format('d M Y, h:i A') }}
                                @else
                                    Not available
                                @endif
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- CATALOGUE --}}
    <div class="seller-card">

        <div class="seller-card-header">

            <h2 class="seller-card-title">
                <i class="fas fa-box-open"></i>
                Catalogue
            </h2>

            <span class="seller-status">
                {{ $productCount }} Products
            </span>

        </div>

        <div class="seller-card-body">

            <div class="seller-table-wrap">

                <table class="seller-table">

                    <thead>

                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($products as $product)

                            <tr>

                                <td>
                                    <div class="seller-product-name">
                                        {{ $product->name ?? 'Unnamed Product' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="seller-price">
                                        ₹{{ number_format((float)($product->price ?? 0), 2) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="seller-stock">
                                        {{ $product->stock ?? 0 }}
                                    </span>
                                </td>

                                <td>

                                    @if(Route::has('admin.products.show'))

                                        <a class="seller-view-btn"
                                           href="{{ route('admin.products.show', $product) }}">

                                            <i class="fas fa-eye"></i>
                                            View

                                        </a>

                                    @else

                                        <span class="seller-view-btn">
                                            <i class="fas fa-eye"></i>
                                            View
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="seller-empty">

                                    <div class="seller-empty-icon">
                                        <i class="fas fa-box-open"></i>
                                    </div>

                                    <div class="seller-empty-title">
                                        No products yet
                                    </div>

                                    <div class="seller-empty-text">
                                        This seller has not added any products to the catalogue.
                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection