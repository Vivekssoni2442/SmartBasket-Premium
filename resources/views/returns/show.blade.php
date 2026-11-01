@extends('layouts.app')

@section('title', 'Return Request #' . $returnRequest->id)

@section('content')
{{-- The shared customer taskbar is rendered by layouts.app navigation. --}}
@php
$returnStatus = strtolower((string) ($returnRequest->status ?? 'requested'));


$statusClass = match ($returnStatus) {
    'approved', 'completed', 'refunded', 'resolved' => 'sb-status-success',
    'rejected', 'cancelled', 'canceled', 'failed' => 'sb-status-danger',
    'processing', 'under_review', 'refund_processing' => 'sb-status-warning',
    default => 'sb-status-info',
};

$returnItems = $returnRequest->items ?? [];
$returnHistory = $returnRequest->history ?? [];


@endphp

<style>
    /* ==========================================================
       SMART BASKET — PREMIUM RETURN REQUEST DETAILS
       Responsive full-width layout + automatic light/dark theme
       All styles are scoped to prevent affecting other pages.
    ========================================================== */

    .sb-return-details {
        --sb-bg: #f3f7ff;
        --sb-surface: #ffffff;
        --sb-surface-soft: #f7faff;
        --sb-text: #172747;
        --sb-muted: #71809a;
        --sb-border: #e0e8f5;
        --sb-primary: #1769ff;
        --sb-primary-dark: #1050d5;
        --sb-primary-soft: rgba(23, 105, 255, .09);
        --sb-shadow: 0 12px 36px rgba(30, 64, 120, .08);
        --sb-row-hover: #f3f7ff;

        position: relative;
        isolation: isolate;
        width: 100%;
        max-width: 100%;
        min-height: 75vh;
        padding: clamp(14px, 2.5vw, 30px);
        overflow: hidden;
        color: var(--sb-text);
        background:
            radial-gradient(ellipse at 5% 0%, rgba(23, 105, 255, .09), transparent 38%),
            var(--sb-bg);
        border-radius: 24px;
        transition: background .25s ease, color .25s ease;
    }

    /* Dark mode: follows the existing website/system theme. */
    html[data-bs-theme="dark"] .sb-return-details,
    [data-theme="dark"] .sb-return-details,
    [data-theme-mode="dark"] .sb-return-details,
    body.dark-mode .sb-return-details,
    body.dark .sb-return-details,
    .dark .sb-return-details {
        --sb-bg: #080f1d;
        --sb-surface: #101b2e;
        --sb-surface-soft: #142239;
        --sb-text: #edf4ff;
        --sb-muted: #9eafca;
        --sb-border: #263752;
        --sb-primary: #6ea4ff;
        --sb-primary-dark: #91b8ff;
        --sb-primary-soft: rgba(76, 137, 255, .15);
        --sb-shadow: 0 16px 40px rgba(0, 0, 0, .2);
        --sb-row-hover: #172741;

        background:
            radial-gradient(ellipse at 5% 0%, rgba(41, 104, 230, .17), transparent 40%),
            var(--sb-bg);
    }

    .sb-return-details *,
    .sb-return-details *::before,
    .sb-return-details *::after {
        box-sizing: border-box;
    }

    .sb-return-details a {
        color: var(--sb-primary);
    }

    .sb-return-details .sb-return-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 15px;
        margin-bottom: 22px;
        color: var(--sb-text);
        font-weight: 700;
        font-size: .9rem;
        text-decoration: none;
        background: var(--sb-surface);
        border: 1px solid var(--sb-border);
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(20, 50, 100, .04);
        transition: transform .2s ease, border-color .2s ease;
    }

    .sb-return-details .sb-return-back:hover {
        transform: translateX(-3px);
        border-color: var(--sb-primary);
    }

    .sb-return-details .sb-return-hero {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 22px;
        padding: clamp(22px, 4vw, 38px);
        margin-bottom: 24px;
        overflow: hidden;
        color: #fff;
        background: linear-gradient(125deg, #103b91 0%, #1769ff 55%, #3789ff 100%);
        border: 1px solid rgba(255, 255, 255, .2);
        border-radius: 22px;
        box-shadow: 0 18px 40px rgba(23, 105, 255, .2);
    }

    .sb-return-details .sb-return-hero::before {
        content: "";
        position: absolute;
        width: 280px;
        height: 280px;
        right: -65px;
        top: -155px;
        border: 1px solid rgba(255, 255, 255, .2);
        border-radius: 50%;
        box-shadow:
            0 0 0 28px rgba(255, 255, 255, .045),
            0 0 0 58px rgba(255, 255, 255, .035);
        pointer-events: none;
    }

    .sb-return-details .sb-return-hero-content,
    .sb-return-details .sb-return-hero-side {
        position: relative;
        z-index: 1;
    }

    .sb-return-details .sb-return-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
        color: #e0ebff;
        font-size: .76rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .sb-return-details .sb-return-hero h1 {
        margin: 0 0 10px;
        color: #fff;
        font-size: clamp(1.55rem, 3vw, 2.4rem);
        font-weight: 850;
        letter-spacing: -.7px;
        overflow-wrap: anywhere;
    }

    .sb-return-details .sb-return-order-line {
        margin: 0;
        color: #e0ebff;
        font-size: .98rem;
    }

    .sb-return-details .sb-return-order-line strong {
        color: #fff;
    }

    .sb-return-details .sb-return-hero-side {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .sb-return-details .sb-return-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 16px;
        color: #fff;
        font-size: .82rem;
        font-weight: 800;
        letter-spacing: .35px;
        background: rgba(255, 255, 255, .15);
        border: 1px solid rgba(255, 255, 255, .35);
        border-radius: 999px;
        backdrop-filter: blur(10px);
        overflow-wrap: anywhere;
    }

    .sb-return-details .sb-return-status-dot {
        width: 8px;
        height: 8px;
        flex: 0 0 8px;
        background: #a8f5c6;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(168, 245, 198, .6);
    }

    .sb-return-details .sb-return-meta {
        color: #e0ebff;
        font-size: .82rem;
    }

    .sb-return-details .sb-return-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(270px, .8fr);
        gap: 24px;
        align-items: start;
    }

    .sb-return-details .sb-return-main-column,
    .sb-return-details .sb-return-side-column {
        display: grid;
        gap: 24px;
        min-width: 0;
    }

    .sb-return-details .sb-return-card {
        min-width: 0;
        overflow: hidden;
        color: var(--sb-text);
        background: var(--sb-surface);
        border: 1px solid var(--sb-border);
        border-radius: 19px;
        box-shadow: var(--sb-shadow);
        transition: background .25s ease, border-color .25s ease;
    }

    .sb-return-details .sb-return-card-header {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 21px 23px;
        border-bottom: 1px solid var(--sb-border);
    }

    .sb-return-details .sb-return-card-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 43px;
        height: 43px;
        flex: 0 0 43px;
        color: var(--sb-primary);
        font-size: 1.2rem;
        font-weight: 900;
        background: var(--sb-primary-soft);
        border-radius: 13px;
    }

    .sb-return-details .sb-return-card-header h2 {
        margin: 0;
        color: var(--sb-text);
        font-size: 1.04rem;
        font-weight: 850;
    }

    .sb-return-details .sb-return-card-header p {
        margin: 4px 0 0;
        color: var(--sb-muted);
        font-size: .82rem;
    }

    .sb-return-details .sb-return-card-body {
        padding: 22px 23px;
    }

    .sb-return-details .sb-return-product-list {
        display: grid;
        gap: 12px;
    }

    .sb-return-details .sb-return-product {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 17px;
        background: var(--sb-surface-soft);
        border: 1px solid var(--sb-border);
        border-radius: 14px;
        transition: background .2s ease, border-color .2s ease;
    }

    .sb-return-details .sb-return-product:hover {
        background: var(--sb-row-hover);
        border-color: rgba(23, 105, 255, .35);
    }

    .sb-return-details .sb-return-product-info {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        min-width: 0;
    }

    .sb-return-details .sb-return-product-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        color: var(--sb-primary);
        font-size: 1.1rem;
        background: var(--sb-primary-soft);
        border-radius: 12px;
    }

    .sb-return-details .sb-return-product-name {
        margin: 0 0 6px;
        color: var(--sb-text);
        font-size: .96rem;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .sb-return-details .sb-return-product-quantity {
        margin: 0;
        color: var(--sb-muted);
        font-size: .82rem;
    }

    .sb-return-details .sb-return-product-price {
        flex: 0 0 auto;
        color: var(--sb-text);
        font-size: 1rem;
        font-weight: 850;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .sb-return-details .sb-return-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 19px 3px 0;
        margin-top: 18px;
        border-top: 1px dashed var(--sb-border);
    }

    .sb-return-details .sb-return-total span {
        color: var(--sb-muted);
        font-size: .9rem;
        font-weight: 700;
    }

    .sb-return-details .sb-return-total strong {
        color: var(--sb-primary);
        font-size: 1.35rem;
        font-weight: 900;
        overflow-wrap: anywhere;
    }

    .sb-return-details .sb-return-reason {
        padding: 17px;
        background: var(--sb-primary-soft);
        border: 1px solid rgba(23, 105, 255, .18);
        border-radius: 14px;
    }

    .sb-return-details .sb-return-label {
        display: block;
        margin-bottom: 7px;
        color: var(--sb-muted);
        font-size: .76rem;
        font-weight: 850;
        letter-spacing: .8px;
        text-transform: uppercase;
    }

    .sb-return-details .sb-return-reason-value {
        margin: 0;
        color: var(--sb-text);
        font-size: 1rem;
        font-weight: 850;
        overflow-wrap: anywhere;
    }

    .sb-return-details .sb-return-description {
        margin-top: 17px;
    }

    .sb-return-details .sb-return-description p {
        margin: 0;
        color: var(--sb-text);
        line-height: 1.75;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    .sb-return-details .sb-return-note {
        padding: 17px;
        margin: 0 0 14px;
        color: var(--sb-text);
        background: var(--sb-surface-soft);
        border: 1px solid var(--sb-border);
        border-left: 4px solid var(--sb-primary);
        border-radius: 12px;
        overflow-wrap: anywhere;
    }

    .sb-return-details .sb-return-note:last-child {
        margin-bottom: 0;
    }

    .sb-return-details .sb-return-note-heading {
        display: block;
        margin-bottom: 8px;
        font-size: .84rem;
        font-weight: 850;
    }

    .sb-return-details .sb-return-note p {
        margin: 0;
        color: var(--sb-muted);
        font-size: .92rem;
        line-height: 1.7;
        white-space: pre-line;
    }

    .sb-return-details .sb-return-note-admin {
        border-left-color: #0ea5e9;
    }

    .sb-return-details .sb-return-note-seller {
        border-left-color: #8b5cf6;
    }

    .sb-return-details .sb-return-note-refund {
        border-left-color: #10b981;
    }

    .sb-return-details .sb-return-note-refund p {
        color: var(--sb-text);
        font-size: 1.35rem;
        font-weight: 900;
    }

    .sb-return-details .sb-status-success {
        color: #087443;
        background: #e5f8ee;
        border-color: #b9ebd0;
    }

    .sb-return-details .sb-status-danger {
        color: #b42335;
        background: #fff0f1;
        border-color: #ffd0d5;
    }

    .sb-return-details .sb-status-warning {
        color: #8a5700;
        background: #fff5d9;
        border-color: #f5df9c;
    }

    .sb-return-details .sb-status-info {
        color: #1555b7;
        background: #eaf2ff;
        border-color: #c7dcff;
    }

    .sb-return-details .sb-return-history {
        position: relative;
        display: grid;
        gap: 0;
        padding: 0;
        margin: 0;
        list-style: none;
        counter-reset: sb-return-event;
    }

    .sb-return-details .sb-return-history-item {
        position: relative;
        display: grid;
        grid-template-columns: 37px minmax(0, 1fr);
        gap: 13px;
        padding-bottom: 24px;
        counter-increment: sb-return-event;
    }

    .sb-return-details .sb-return-history-item:last-child {
        padding-bottom: 0;
    }

    .sb-return-details .sb-return-history-marker {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 37px;
        height: 37px;
        color: var(--sb-primary);
        font-size: .8rem;
        font-weight: 900;
        background: var(--sb-primary-soft);
        border: 1px solid rgba(23, 105, 255, .2);
        border-radius: 50%;
    }

    .sb-return-details .sb-return-history-item:not(:last-child) .sb-return-history-marker::after {
        content: "";
        position: absolute;
        width: 2px;
        height: calc(100% + 25px);
        top: 36px;
        left: 50%;
        background: var(--sb-border);
        transform: translateX(-50%);
    }

    .sb-return-details .sb-return-history-content {
        min-width: 0;
        padding-top: 3px;
    }

    .sb-return-details .sb-return-history-title {
        margin: 0 0 6px;
        color: var(--sb-text);
        font-size: .92rem;
        font-weight: 850;
        overflow-wrap: anywhere;
    }

    .sb-return-details .sb-return-history-note {
        margin: 0 0 8px;
        color: var(--sb-muted);
        font-size: .88rem;
        line-height: 1.65;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    .sb-return-details .sb-return-history-date {
        color: var(--sb-muted);
        font-size: .77rem;
        overflow-wrap: anywhere;
    }

    .sb-return-details .sb-return-empty-history {
        padding: 24px 18px;
        color: var(--sb-muted);
        text-align: center;
        background: var(--sb-surface-soft);
        border: 1px dashed var(--sb-border);
        border-radius: 13px;
    }

    .sb-return-details .sb-return-actions {
        display: grid;
        gap: 12px;
    }

    .sb-return-details .sb-return-cancel-form {
        margin: 0;
    }

    .sb-return-details .sb-return-cancel-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        width: 100%;
        min-height: 48px;
        padding: 12px 18px;
        color: #dc3545;
        font-weight: 800;
        background: transparent;
        border: 1px solid rgba(220, 53, 69, .45);
        border-radius: 12px;
        transition: color .2s ease, background .2s ease, transform .2s ease;
    }

    .sb-return-details .sb-return-cancel-btn:hover {
        color: #fff;
        background: #dc3545;
        transform: translateY(-1px);
    }

    .sb-return-details .sb-return-cancel-help {
        margin: 10px 0 0;
        color: var(--sb-muted);
        font-size: .79rem;
        line-height: 1.6;
    }

    .sb-return-details .sb-return-info-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        padding: 12px 0;
        border-bottom: 1px solid var(--sb-border);
    }

    .sb-return-details .sb-return-info-row:first-child {
        padding-top: 0;
    }

    .sb-return-details .sb-return-info-row:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .sb-return-details .sb-return-info-label {
        color: var(--sb-muted);
        font-size: .84rem;
    }

    .sb-return-details .sb-return-info-value {
        color: var(--sb-text);
        font-size: .85rem;
        font-weight: 800;
        text-align: right;
        overflow-wrap: anywhere;
    }

    @media (max-width: 991.98px) {
        .sb-return-details .sb-return-grid {
            grid-template-columns: minmax(0, 1fr);
        }

        .sb-return-details .sb-return-side-column {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 650px) {
        .sb-return-details {
            padding: 12px;
            border-radius: 16px;
        }

        .sb-return-details .sb-return-hero {
            align-items: flex-start;
            flex-direction: column;
            padding: 23px 19px;
            border-radius: 17px;
        }

        .sb-return-details .sb-return-hero-side {
            width: 100%;
        }

        .sb-return-details .sb-return-card {
            border-radius: 15px;
        }

        .sb-return-details .sb-return-card-header {
            padding: 17px;
        }

        .sb-return-details .sb-return-card-body {
            padding: 17px;
        }

        .sb-return-details .sb-return-side-column {
            grid-template-columns: minmax(0, 1fr);
        }

        .sb-return-details .sb-return-product {
            align-items: flex-start;
            gap: 10px;
            padding: 13px;
        }

        .sb-return-details .sb-return-product-info {
            gap: 10px;
        }

        .sb-return-details .sb-return-product-icon {
            width: 35px;
            height: 35px;
            flex-basis: 35px;
            font-size: 1rem;
        }

        .sb-return-details .sb-return-product-name {
            font-size: .87rem;
        }

        .sb-return-details .sb-return-product-price {
            font-size: .9rem;
        }

        .sb-return-details .sb-return-total strong {
            font-size: 1.15rem;
        }
    }

    </style>

<main class="sb-return-details">
  


{{-- Premium header --}}
<x-customer-page-hero :subtitle="'Order #' . $returnRequest->order_id . ' · Return and refund details'">
    <h1 class="sb-customer-page-title">Return Request #{{ $returnRequest->id }}</h1>
</x-customer-page-hero>
<div class="sb-return-hero-side">
    <span class="sb-return-status {{ $statusClass }}"><span class="sb-return-status-dot" aria-hidden="true"></span>{{ ucfirst(str_replace('_', ' ', $returnStatus)) }}</span>
    @if($returnRequest->created_at)<span class="sb-return-meta">Submitted {{ $returnRequest->created_at->format('d M Y') }}</span>@endif
</div>

<div class="sb-return-grid">
    {{-- Main column --}}
    <div class="sb-return-main-column">

        {{-- Requested products --}}
        <section class="sb-return-card">
            <div class="sb-return-card-header">
                <span class="sb-return-card-icon" aria-hidden="true">▤</span>
                <div>
                    <h2>Requested Products</h2>
                    <p>{{ count($returnItems) }} {{ count($returnItems) === 1 ? 'product' : 'products' }} in this return request</p>
                </div>
            </div>

            <div class="sb-return-card-body">
                @if(count($returnItems))
                    <div class="sb-return-product-list">
                        @foreach($returnItems as $item)
                            @php
                                $itemName = $item['name'] ?? 'Product';
                                $itemQuantity = max(0, (int) ($item['quantity'] ?? 0));
                                $itemUnitPrice = (float) ($item['unit_price'] ?? 0);
                                $itemTotal = $itemUnitPrice * $itemQuantity;
                            @endphp

                            <div class="sb-return-product">
                                <div class="sb-return-product-info">
                                    <span class="sb-return-product-icon" aria-hidden="true">▣</span>
                                    <div>
                                        <p class="sb-return-product-name">{{ $itemName }}</p>
                                        <p class="sb-return-product-quantity">
                                            Quantity: {{ $itemQuantity }}
                                            <span aria-hidden="true"> · </span>
                                            ₹{{ number_format($itemUnitPrice, 2) }} each
                                        </p>
                                    </div>
                                </div>

                                <div class="sb-return-product-price">
                                    ₹{{ number_format($itemTotal, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="sb-return-total">
                        <span>Requested items total</span>
                        <strong>
                            ₹{{ number_format(collect($returnItems)->sum(fn ($item) => (float) ($item['unit_price'] ?? 0) * max(0, (int) ($item['quantity'] ?? 0))), 2) }}
                        </strong>
                    </div>
                @else
                    <div class="sb-return-empty-history">
                        Product details are not available for this request.
                    </div>
                @endif
            </div>
        </section>

        {{-- Return reason --}}
        <section class="sb-return-card">
            <div class="sb-return-card-header">
                <span class="sb-return-card-icon" aria-hidden="true">?</span>
                <div>
                    <h2>Return Information</h2>
                    <p>Reason and details submitted with your request</p>
                </div>
            </div>

            <div class="sb-return-card-body">
                <div class="sb-return-reason">
                    <span class="sb-return-label">Reason for return</span>
                    <p class="sb-return-reason-value">
                        {{ ucfirst(str_replace('_', ' ', $returnRequest->reason ?? 'Not specified')) }}
                    </p>
                </div>

                @if($returnRequest->description)
                    <div class="sb-return-description">
                        <span class="sb-return-label">Your note</span>
                        <p>{{ $returnRequest->description }}</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- Request history --}}
        <section class="sb-return-card">
            <div class="sb-return-card-header">
                <span class="sb-return-card-icon" aria-hidden="true">↻</span>
                <div>
                    <h2>Request History</h2>
                    <p>Updates recorded for this return request</p>
                </div>
            </div>

            <div class="sb-return-card-body">
                @if(count($returnHistory))
                    <ol class="sb-return-history">
                        @foreach($returnHistory as $event)
                            <li class="sb-return-history-item">
                                <span class="sb-return-history-marker" aria-hidden="true">
                                    {{ $loop->iteration }}
                                </span>

                                <div class="sb-return-history-content">
                                    <h3 class="sb-return-history-title">
                                        {{ ucfirst(str_replace('_', ' ', $event['status'] ?? 'updated')) }}
                                    </h3>

                                    @if(!empty($event['note']))
                                        <p class="sb-return-history-note">{{ $event['note'] }}</p>
                                    @endif

                                    @if(!empty($event['at']))
                                        <time class="sb-return-history-date">
                                            {{ $event['at'] }}
                                        </time>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ol>
                @else
                    <div class="sb-return-empty-history">
                        <div class="mb-2" aria-hidden="true" style="font-size: 1.7rem;">◷</div>
                        <strong>No history updates yet</strong>
                        <p class="mb-0 mt-1">Updates will appear here when your request changes.</p>
                    </div>
                @endif
            </div>
        </section>
    </div>

    {{-- Side column --}}
    <aside class="sb-return-side-column">

        {{-- Status and decision --}}
        <section class="sb-return-card">
            <div class="sb-return-card-header">
                <span class="sb-return-card-icon" aria-hidden="true">✓</span>
                <div>
                    <h2>Request Updates</h2>
                    <p>Administrator and seller responses</p>
                </div>
            </div>

            <div class="sb-return-card-body">
                @if($returnRequest->decision_note)
                    <div class="sb-return-note sb-return-note-admin">
                        <span class="sb-return-note-heading">Administrator Decision</span>
                        <p>{{ $returnRequest->decision_note }}</p>
                    </div>
                @endif

                @if($returnRequest->seller_note)
                    <div class="sb-return-note sb-return-note-seller">
                        <span class="sb-return-note-heading">Seller Note</span>
                        <p>{{ $returnRequest->seller_note }}</p>
                    </div>
                @endif

                @if(!$returnRequest->decision_note && !$returnRequest->seller_note)
                    <div class="sb-return-empty-history">
                        <div class="mb-2" aria-hidden="true" style="font-size: 1.5rem;">◌</div>
                        <strong>No response yet</strong>
                        <p class="mb-0 mt-1">Administrator or seller updates will appear here.</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- Refund details --}}
        @if($returnRequest->refund_amount !== null && $returnRequest->refund_amount !== '')
            <section class="sb-return-card">
                <div class="sb-return-card-header">
                    <span class="sb-return-card-icon" aria-hidden="true">₹</span>
                    <div>
                        <h2>Refund Details</h2>
                        <p>Refund amount recorded for this request</p>
                    </div>
                </div>

                <div class="sb-return-card-body">
                    <div class="sb-return-note sb-return-note-refund">
                        <span class="sb-return-note-heading">Refund Amount</span>
                        <p>₹{{ number_format((float) $returnRequest->refund_amount, 2) }}</p>
                    </div>
                    <p class="mb-0" style="color: var(--sb-muted); font-size: .8rem; line-height: 1.6;">
                        The amount displayed here is the amount recorded for this request. It does not independently confirm that the refund has reached your payment account.
                    </p>
                </div>
            </section>
        @endif

        {{-- Request summary --}}
        <section class="sb-return-card">
            <div class="sb-return-card-header">
                <span class="sb-return-card-icon" aria-hidden="true">☰</span>
                <div>
                    <h2>Request Summary</h2>
                    <p>Quick overview</p>
                </div>
            </div>

            <div class="sb-return-card-body">
                <div class="sb-return-info-row">
                    <span class="sb-return-info-label">Request ID</span>
                    <span class="sb-return-info-value">#{{ $returnRequest->id }}</span>
                </div>

                <div class="sb-return-info-row">
                    <span class="sb-return-info-label">Order ID</span>
                    <span class="sb-return-info-value">#{{ $returnRequest->order_id }}</span>
                </div>

                <div class="sb-return-info-row">
                    <span class="sb-return-info-label">Status</span>
                    <span class="sb-return-info-value">{{ ucfirst(str_replace('_', ' ', $returnStatus)) }}</span>
                </div>

                <div class="sb-return-info-row">
                    <span class="sb-return-info-label">Items</span>
                    <span class="sb-return-info-value">{{ count($returnItems) }}</span>
                </div>

                @if($returnRequest->created_at)
                    <div class="sb-return-info-row">
                        <span class="sb-return-info-label">Submitted</span>
                        <span class="sb-return-info-value">{{ $returnRequest->created_at->format('d M Y') }}</span>
                    </div>
                @endif
            </div>
        </section>

        {{-- Cancel action: same route and condition as original --}}
        @if($returnRequest->status === 'requested')
            <section class="sb-return-card">
                <div class="sb-return-card-header">
                    <span class="sb-return-card-icon" aria-hidden="true">×</span>
                    <div>
                        <h2>Cancel Request</h2>
                        <p>Manage your pending return</p>
                    </div>
                </div>

                <div class="sb-return-card-body">
                    <div class="sb-return-actions">
                        <form
                            method="POST"
                            action="{{ route('returns.cancel', $returnRequest) }}"
                            class="sb-return-cancel-form"
                            onsubmit="return confirm('Cancel this return request?')"
                        >
                            @csrf
                            <button type="submit" class="sb-return-cancel-btn">
                                <span aria-hidden="true">×</span>
                                Cancel Return Request
                            </button>
                        </form>
                    </div>

                    <p class="sb-return-cancel-help">
                        Cancellation is available only while your request is in the requested state.
                    </p>
                </div>
            </section>
        @endif
    </aside>
</div>


</main>
@endsection
