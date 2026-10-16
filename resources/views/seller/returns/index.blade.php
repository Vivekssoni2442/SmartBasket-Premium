@extends('seller.partials.premium-layout')

@section('title', 'Return Requests')

@section('content')
<style>
    /* =========================================================
       SMART BASKET — SELLER RETURNS PREMIUM BLUE THEME
       Scoped styles: does not modify other seller pages.
    ========================================================= */

    .sb-returns-page {
        --sr-blue: #155eef;
        --sr-blue-dark: #1049c7;
        --sr-blue-soft: #edf5ff;
        --sr-ink: #14233d;
        --sr-muted: #64748b;
        --sr-border: #dce6f3;
        --sr-surface: #ffffff;

        width: 100%;
        max-width: 100%;
        min-width: 0;
        padding: 24px clamp(12px, 2vw, 30px) 36px;
        color: var(--sr-ink);
    }

    .sb-returns-page *,
    .sb-returns-page *::before,
    .sb-returns-page *::after {
        box-sizing: border-box;
    }

    .sb-returns-page .sr-hero {
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 22px;
        padding: clamp(22px, 3vw, 34px);
        margin-bottom: 22px;
        overflow: hidden;
        border: 1px solid #d6e5fb;
        border-radius: 22px;
        background:
            radial-gradient(ellipse at 100% 0%, rgba(96,165,250,.19), transparent 42%),
            linear-gradient(125deg, #ffffff 0%, #f5f9ff 62%, #edf5ff 100%);
        box-shadow: 0 12px 35px rgba(25, 70, 140, .07);
    }

    .sb-returns-page .sr-hero::after {
        content: "";
        position: absolute;
        right: -65px;
        bottom: -100px;
        width: 250px;
        height: 250px;
        border: 1px solid rgba(21,94,239,.10);
        border-radius: 50%;
        box-shadow:
            0 0 0 25px rgba(21,94,239,.025),
            0 0 0 55px rgba(21,94,239,.02);
        pointer-events: none;
    }

    .sb-returns-page .sr-hero-content {
        position: relative;
        z-index: 1;
        min-width: 0;
    }

    .sb-returns-page .sr-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 11px;
        color: var(--sr-blue);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .15em;
        text-transform: uppercase;
    }

    .sb-returns-page .sr-eyebrow-dot {
        width: 8px;
        height: 8px;
        flex: 0 0 8px;
        border-radius: 50%;
        background: #2d75f0;
        box-shadow: 0 0 0 4px rgba(45,117,240,.11);
    }

    .sb-returns-page .sr-title {
        margin: 0;
        color: #10213e;
        font-size: clamp(23px, 2.5vw, 34px);
        font-weight: 800;
        line-height: 1.25;
        letter-spacing: -.8px;
        overflow-wrap: anywhere;
    }

    .sb-returns-page .sr-description {
        max-width: 720px;
        margin: 12px 0 0;
        color: #60718b;
        font-size: 12px;
        line-height: 1.9;
    }

    .sb-returns-page .sr-hero-icon {
        position: relative;
        z-index: 1;
        display: grid;
        place-items: center;
        width: 82px;
        height: 82px;
        flex: 0 0 82px;
        border: 1px solid #cfe0ff;
        border-radius: 23px;
        color: #ffffff;
        background: linear-gradient(145deg, #4d91ff, #155eef 65%, #1049c7);
        box-shadow: 0 15px 32px rgba(21,94,239,.22);
        font-size: 29px;
    }

    /* Flash messages */
    .sb-returns-page .sr-alert {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        padding: 14px 16px;
        margin-bottom: 18px;
        border: 1px solid;
        border-radius: 13px;
        font-size: 12px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .sb-returns-page .sr-alert i {
        margin-top: 3px;
    }

    .sb-returns-page .sr-alert-success {
        color: #146c43;
        background: #effcf5;
        border-color: #b8ebce;
    }

    .sb-returns-page .sr-alert-danger {
        color: #a32138;
        background: #fff3f4;
        border-color: #fecdd3;
    }

    /* Summary strip */
    .sb-returns-page .sr-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 22px;
    }

    .sb-returns-page .sr-summary-card {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
        padding: 19px;
        border: 1px solid var(--sr-border);
        border-radius: 17px;
        background: #ffffff;
        box-shadow: 0 6px 20px rgba(25,70,140,.035);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .sb-returns-page .sr-summary-card:hover {
        transform: translateY(-2px);
        border-color: #bfd5fb;
        box-shadow: 0 12px 27px rgba(25,70,140,.075);
    }

    .sb-returns-page .sr-summary-icon {
        display: grid;
        place-items: center;
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        border: 1px solid #d7e6ff;
        border-radius: 14px;
        color: var(--sr-blue);
        background: #edf5ff;
        font-size: 18px;
    }

    .sb-returns-page .sr-summary-label {
        margin: 0 0 4px;
        color: #74839a;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .055em;
        text-transform: uppercase;
    }

    .sb-returns-page .sr-summary-value {
        margin: 0;
        color: #14233d;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    /* Main requests panel */
    .sb-returns-page .sr-panel {
        min-width: 0;
        overflow: hidden;
        border: 1px solid var(--sr-border);
        border-radius: 19px;
        background: var(--sr-surface);
        box-shadow: 0 12px 35px rgba(25,70,140,.055);
    }

    .sb-returns-page .sr-panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 20px 23px;
        border-bottom: 1px solid #e7edf6;
        background: linear-gradient(110deg, #ffffff, #f7faff);
    }

    .sb-returns-page .sr-panel-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .sb-returns-page .sr-panel-heading-icon {
        display: grid;
        place-items: center;
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        border-radius: 13px;
        color: #155eef;
        background: #edf5ff;
        font-size: 16px;
    }

    .sb-returns-page .sr-panel-title {
        margin: 0;
        color: #14233d;
        font-size: 15px;
        font-weight: 800;
    }

    .sb-returns-page .sr-panel-subtitle {
        margin: 4px 0 0;
        color: #78879c;
        font-size: 10px;
        line-height: 1.6;
    }

    .sb-returns-page .sr-record-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 30px;
        padding: 5px 11px;
        border: 1px solid #d6e5ff;
        border-radius: 999px;
        color: #1552b5;
        background: #edf5ff;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    /* Full-width table */
    .sb-returns-page .sr-table-wrap {
        width: 100%;
        overflow-x: auto;
        overscroll-behavior-x: contain;
        scrollbar-width: thin;
        scrollbar-color: #b9cce8 #f3f7fd;
    }

    .sb-returns-page .sr-table {
        width: 100%;
        min-width: 950px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
        color: #334760;
        font-size: 11px;
        vertical-align: middle;
    }

    .sb-returns-page .sr-table thead th {
        padding: 15px 16px;
        border: 0;
        border-bottom: 1px solid #e1eaf6;
        color: #526781;
        background: #f6f9ff;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .075em;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .sb-returns-page .sr-table tbody td {
        padding: 19px 16px;
        border-bottom: 1px solid #edf1f7;
        background: #ffffff;
        line-height: 1.75;
        vertical-align: top;
        overflow-wrap: anywhere;
    }

    .sb-returns-page .sr-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .sb-returns-page .sr-table tbody tr {
        transition: background .18s ease;
    }

    .sb-returns-page .sr-table tbody tr:hover td {
        background: #f9fbff;
    }

    .sb-returns-page .sr-id {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #1552b5;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .sb-returns-page .sr-muted {
        display: block;
        margin-top: 4px;
        color: #8290a4;
        font-size: 10px;
        line-height: 1.65;
    }

    .sb-returns-page .sr-order {
        color: #263e5b;
        font-weight: 700;
    }

    .sb-returns-page .sr-customer {
        color: #6b7c93;
        font-weight: 500;
    }

    .sb-returns-page .sr-item-list {
        display: grid;
        gap: 7px;
        min-width: 150px;
    }

    .sb-returns-page .sr-item {
        display: flex;
        align-items: flex-start;
        gap: 7px;
        color: #354963;
        line-height: 1.65;
    }

    .sb-returns-page .sr-item i {
        margin-top: 4px;
        color: #4b83e7;
        font-size: 10px;
    }

    .sb-returns-page .sr-reason {
        color: #334760;
        font-weight: 700;
    }

    .sb-returns-page .sr-description {
        overflow-wrap: anywhere;
    }

    /* Status badges */
    .sb-returns-page .sr-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        max-width: 100%;
        padding: 6px 10px;
        border: 1px solid #dce6f3;
        border-radius: 999px;
        color: #526781;
        background: #f5f8fc;
        font-size: 9px;
        font-weight: 800;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .sb-returns-page .sr-status-dot {
        width: 6px;
        height: 6px;
        flex: 0 0 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .sb-returns-page .sr-status-requested,
    .sb-returns-page .sr-status-pending {
        color: #975a06;
        background: #fff8e8;
        border-color: #f5dfaa;
    }

    .sb-returns-page .sr-status-approved,
    .sb-returns-page .sr-status-completed,
    .sb-returns-page .sr-status-refunded {
        color: #147547;
        background: #effcf5;
        border-color: #bcebd0;
    }

    .sb-returns-page .sr-status-rejected,
    .sb-returns-page .sr-status-cancelled,
    .sb-returns-page .sr-status-denied {
        color: #b4233a;
        background: #fff1f2;
        border-color: #fecdd3;
    }

    .sb-returns-page .sr-status-processing,
    .sb-returns-page .sr-status-in_review {
        color: #1552b5;
        background: #edf5ff;
        border-color: #cfe0ff;
    }

    .sb-returns-page .sr-notes {
        display: grid;
        gap: 8px;
        margin-top: 10px;
    }

    .sb-returns-page .sr-note {
        padding: 9px 10px;
        border: 1px solid #e5edf8;
        border-radius: 9px;
        background: #f8faff;
        color: #526781;
        font-size: 10px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .sb-returns-page .sr-note-label {
        display: block;
        margin-bottom: 3px;
        color: #1552b5;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    /* Seller note form */
    .sb-returns-page .sr-note-form {
        min-width: 190px;
        margin-top: 13px;
        padding: 12px;
        border: 1px solid #dce8fa;
        border-radius: 12px;
        background: #f7faff;
    }

    .sb-returns-page .sr-note-form label {
        display: block;
        margin: 0 0 7px;
        color: #344b68;
        font-size: 10px;
        font-weight: 700;
    }

    .sb-returns-page .sr-note-form textarea {
        display: block;
        width: 100%;
        min-height: 82px;
        padding: 10px 11px;
        resize: vertical;
        border: 1px solid #cddbee;
        border-radius: 9px;
        outline: none;
        color: #14233d;
        background: #ffffff;
        font: inherit;
        font-size: 10px;
        line-height: 1.7;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .sb-returns-page .sr-note-form textarea::placeholder {
        color: #8b9bb1;
    }

    .sb-returns-page .sr-note-form textarea:focus {
        border-color: #155eef;
        box-shadow: 0 0 0 3px rgba(21,94,239,.10);
    }

    .sb-returns-page .sr-note-form .sr-note-submit {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 7px;
        width: 100%;
        min-height: 37px;
        margin-top: 9px;
        padding: 8px 12px;
        border: 1px solid #155eef;
        border-radius: 8px;
        color: #ffffff;
        background: linear-gradient(135deg, #3478f6, #155eef);
        box-shadow: 0 5px 12px rgba(21,94,239,.14);
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .sb-returns-page .sr-note-form .sr-note-submit:hover {
        background: linear-gradient(135deg, #2563eb, #1049c7);
        box-shadow: 0 7px 16px rgba(21,94,239,.23);
        transform: translateY(-1px);
    }

    .sb-returns-page .sr-note-form .sr-note-submit:active {
        transform: translateY(0);
    }

    /* Empty state */
    .sb-returns-page .sr-empty {
        padding: 60px 20px !important;
        text-align: center;
        background: linear-gradient(180deg, #ffffff, #f9fbff) !important;
    }

    .sb-returns-page .sr-empty-icon {
        display: grid;
        place-items: center;
        width: 66px;
        height: 66px;
        margin: 0 auto 16px;
        border: 1px solid #d7e6ff;
        border-radius: 20px;
        color: #155eef;
        background: #edf5ff;
        font-size: 23px;
    }

    .sb-returns-page .sr-empty-title {
        margin: 0;
        color: #203653;
        font-size: 15px;
        font-weight: 800;
    }

    .sb-returns-page .sr-empty-text {
        margin: 8px 0 0;
        color: #78879c;
        font-size: 11px;
        line-height: 1.8;
    }

    /* Pagination */
    .sb-returns-page .sr-pagination {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
        padding: 15px 17px;
        border: 1px solid var(--sr-border);
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 6px 18px rgba(25,70,140,.035);
    }

    .sb-returns-page .sr-pagination nav {
        max-width: 100%;
    }

    .sb-returns-page .sr-pagination nav > div:first-child {
        color: #71829a;
        font-size: 11px;
    }

    .sb-returns-page .sr-pagination nav a,
    .sb-returns-page .sr-pagination nav span[aria-current],
    .sb-returns-page .sr-pagination nav span[aria-disabled] {
        border-radius: 8px;
    }

    .sb-returns-page :focus-visible {
        outline: 3px solid rgba(21,94,239,.4);
        outline-offset: 3px;
    }

    /* Responsive layouts */
    @media (max-width: 1000px) {
        .sb-returns-page .sr-table {
            min-width: 900px;
        }

        .sb-returns-page .sr-hero {
            padding: 25px;
        }
    }

    @media (max-width: 700px) {
        .sb-returns-page {
            padding: 18px 12px 28px;
        }

        .sb-returns-page .sr-hero {
            align-items: flex-start;
            padding: 22px 19px;
            border-radius: 17px;
        }

        .sb-returns-page .sr-hero-icon {
            width: 57px;
            height: 57px;
            flex-basis: 57px;
            border-radius: 16px;
            font-size: 21px;
        }

        .sb-returns-page .sr-description {
            font-size: 11px;
        }

        .sb-returns-page .sr-summary {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .sb-returns-page .sr-summary-card {
            padding: 14px 16px;
        }

        .sb-returns-page .sr-summary-icon {
            width: 42px;
            height: 42px;
            flex-basis: 42px;
        }

        .sb-returns-page .sr-panel {
            border-radius: 15px;
        }

        .sb-returns-page .sr-panel-header {
            padding: 16px;
        }

        .sb-returns-page .sr-panel-title {
            font-size: 13px;
        }

        .sb-returns-page .sr-pagination {
            justify-content: center;
            padding: 12px;
        }
    }

    @media (max-width: 420px) {
        .sb-returns-page .sr-hero {
            gap: 12px;
        }

        .sb-returns-page .sr-hero-icon {
            width: 46px;
            height: 46px;
            flex-basis: 46px;
            border-radius: 13px;
            font-size: 17px;
        }

        .sb-returns-page .sr-title {
            font-size: 22px;
        }

        .sb-returns-page .sr-eyebrow {
            font-size: 9px;
            letter-spacing: .09em;
        }

        .sb-returns-page .sr-record-count {
            font-size: 9px;
            padding: 5px 8px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .sb-returns-page *,
        .sb-returns-page *::before,
        .sb-returns-page *::after {
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important;
        }
    }
</style>

<main class="sb-returns-page">

    {{-- Premium page header --}}
    <section class="sr-hero">
        <div class="sr-hero-content">
            <div class="sr-eyebrow">
                <span class="sr-eyebrow-dot"></span>
                Seller Workspace
            </div>

            <h1 class="sr-title">Return &amp; Refund Requests</h1>

            <p class="sr-description">
                Review return requests related to your products, check customer reasons,
                and communicate important information to customers and administrators.
                Final approval and refund processing are managed by Smart Basket administrators.
            </p>
        </div>

        <div class="sr-hero-icon" aria-hidden="true">
            <i class="fas fa-arrow-rotate-left"></i>
        </div>
    </section>

    {{-- Session feedback --}}
    @if(session('success'))
        <div class="sr-alert sr-alert-success" role="status">
            <i class="fas fa-circle-check" aria-hidden="true"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="sr-alert sr-alert-danger" role="alert">
            <i class="fas fa-circle-exclamation" aria-hidden="true"></i>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Summary cards: count uses the current paginator collection --}}
    <section class="sr-summary" aria-label="Return request overview">

        <article class="sr-summary-card">
            <div class="sr-summary-icon" aria-hidden="true">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div>
                <p class="sr-summary-label">Requests on this page</p>
                <p class="sr-summary-value">
                    {{ $returns->count() }} request{{ $returns->count() === 1 ? '' : 's' }}
                </p>
            </div>
        </article>

        <article class="sr-summary-card">
            <div class="sr-summary-icon" aria-hidden="true">
                <i class="fas fa-shield-halved"></i>
            </div>
            <div>
                <p class="sr-summary-label">Approval authority</p>
                <p class="sr-summary-value">Smart Basket Admin</p>
            </div>
        </article>

        <article class="sr-summary-card">
            <div class="sr-summary-icon" aria-hidden="true">
                <i class="fas fa-comments"></i>
            </div>
            <div>
                <p class="sr-summary-label">Seller communication</p>
                <p class="sr-summary-value">Notes to customer &amp; admin</p>
            </div>
        </article>

    </section>

    {{-- Requests table --}}
    <section class="sr-panel" aria-labelledby="sr-requests-heading">

        <header class="sr-panel-header">
            <div class="sr-panel-heading">
                <div class="sr-panel-heading-icon" aria-hidden="true">
                    <i class="fas fa-list-check"></i>
                </div>

                <div>
                    <h2 class="sr-panel-title" id="sr-requests-heading">
                        Return Requests
                    </h2>
                    <p class="sr-panel-subtitle">
                        Customer details, affected products, reasons and request status
                    </p>
                </div>
            </div>

            <span class="sr-record-count">
                {{ $returns->count() }} shown
            </span>
        </header>

        <div class="sr-table-wrap">
            <table class="sr-table">
                <thead>
                    <tr>
                        <th scope="col">Request</th>
                        <th scope="col">Order / Customer</th>
                        <th scope="col">Your Items</th>
                        <th scope="col">Reason</th>
                        <th scope="col">Status &amp; Notes</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($returns as $return)
                        @php
                            $status = strtolower((string) $return->status);
                            $statusClass = preg_replace('/[^a-z0-9_-]/', '', $status);
                            $statusLabel = ucfirst(str_replace('_', ' ', $status));
                        @endphp

                        <tr>
                            {{-- Request information --}}
                            <td>
                                <span class="sr-id">
                                    <i class="fas fa-hashtag" aria-hidden="true"></i>
                                    {{ $return->id }}
                                </span>

                                <span class="sr-muted">
                                    <i class="far fa-calendar" aria-hidden="true"></i>
                                    {{ $return->created_at?->format('d M Y') ?? 'Date unavailable' }}
                                </span>
                            </td>

                            {{-- Order and customer --}}
                            <td>
                                <div class="sr-order">
                                    Order #{{ $return->order_id }}
                                </div>

                                <span class="sr-muted">
                                    <i class="far fa-user" aria-hidden="true"></i>
                                    <span class="sr-customer">
                                        {{ $return->order?->user?->name ?? 'Customer' }}
                                    </span>
                                </span>
                            </td>

                            {{-- Seller's affected items --}}
                            <td>
                                <div class="sr-item-list">
                                    @forelse(($return->seller_items ?? []) as $item)
                                        <div class="sr-item">
                                            <i class="fas fa-box" aria-hidden="true"></i>
                                            <span>
                                                {{ $item['name'] ?? 'Product' }}
                                                <strong>× {{ $item['quantity'] ?? 0 }}</strong>
                                            </span>
                                        </div>
                                    @empty
                                        <span class="sr-muted">No item details available.</span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- Reason and customer description --}}
                            <td>
                                <div class="sr-reason">
                                    {{ ucfirst(str_replace('_', ' ', (string) $return->reason)) }}
                                </div>

                                @if(filled($return->description))
                                    <span class="sr-muted">
                                        {{ $return->description }}
                                    </span>
                                @else
                                    <span class="sr-muted">No additional description.</span>
                                @endif
                            </td>

                            {{-- Status, admin decision and seller notes --}}
                            <td>
                                <span class="sr-status sr-status-{{ $statusClass }}">
                                    <span class="sr-status-dot" aria-hidden="true"></span>
                                    {{ $statusLabel }}
                                </span>

                                @if(filled($return->decision_note) || filled($return->seller_note))
                                    <div class="sr-notes">
                                        @if(filled($return->decision_note))
                                            <div class="sr-note">
                                                <span class="sr-note-label">
                                                    <i class="fas fa-shield-halved" aria-hidden="true"></i>
                                                    Admin decision
                                                </span>
                                                {{ $return->decision_note }}
                                            </div>
                                        @endif

                                        @if(filled($return->seller_note))
                                            <div class="sr-note">
                                                <span class="sr-note-label">
                                                    <i class="fas fa-comment-dots" aria-hidden="true"></i>
                                                    Seller note
                                                </span>
                                                {{ $return->seller_note }}
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if(in_array($return->status, ['requested', 'approved'], true))
                                    <form
                                        method="POST"
                                        action="{{ route('seller.returns.note', $return) }}"
                                        class="sr-note-form"
                                    >
                                        @csrf

                                        <label for="seller-return-note-{{ $return->id }}">
                                            <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                                            Add a note
                                        </label>

                                        <textarea
                                            id="seller-return-note-{{ $return->id }}"
                                            name="note"
                                            maxlength="2000"
                                            required
                                            placeholder="Write a note for the customer and administrator..."
                                        ></textarea>

                                        <button class="sr-note-submit" type="submit">
                                            <i class="fas fa-paper-plane" aria-hidden="true"></i>
                                            Add Note
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="sr-empty">
                                <div class="sr-empty-icon" aria-hidden="true">
                                    <i class="fas fa-inbox"></i>
                                </div>

                                <h3 class="sr-empty-title">No return requests yet</h3>

                                <p class="sr-empty-text">
                                    Return requests related to your products will appear here
                                    when customers submit them.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Existing Laravel pagination --}}
    @if(method_exists($returns, 'links'))
        <div class="sr-pagination">
            {{ $returns->links() }}
        </div>
    @endif

</main>
@endsection
