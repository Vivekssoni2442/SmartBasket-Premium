<!DOCTYPE html>
<html lang="en" data-sb-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Seller Order #{{ $order->id }} | Smart Basket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/order-tracking.css') }}">

    <style>
        /* =====================================================
           SMART BASKET THEME SYNC
        ===================================================== */

        :root {
            --sb-bg: #020617;
            --sb-bg-secondary: #0b1120;
            --sb-card: rgba(255,255,255,.055);
            --sb-card-border: rgba(255,255,255,.10);
            --sb-text: #f8fafc;
            --sb-muted: #94a3b8;
            --sb-border: rgba(255,255,255,.10);
            --sb-primary: #00ff99;
            --sb-primary-soft: rgba(0,255,153,.10);
            --sb-input: rgba(255,255,255,.055);
        }

        html[data-sb-theme="dark"],
        body[data-sb-theme="dark"] {
            --sb-bg: #020617;
            --sb-bg-secondary: #0b1120;
            --sb-card: rgba(255,255,255,.055);
            --sb-card-border: rgba(255,255,255,.10);
            --sb-text: #f8fafc;
            --sb-muted: #94a3b8;
            --sb-border: rgba(255,255,255,.10);
            --sb-input: rgba(255,255,255,.055);
        }

        html[data-sb-theme="light"],
        body[data-sb-theme="light"] {
            --sb-bg: #f1f5f9;
            --sb-bg-secondary: #ffffff;
            --sb-card: rgba(255,255,255,.92);
            --sb-card-border: rgba(15,23,42,.10);
            --sb-text: #0f172a;
            --sb-muted: #64748b;
            --sb-border: rgba(15,23,42,.10);
            --sb-input: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            color: var(--sb-text);

            background:
                radial-gradient(
                    circle at top left,
                    rgba(0,255,153,.10),
                    transparent 35%
                ),
                radial-gradient(
                    circle at bottom right,
                    rgba(59,130,246,.08),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    var(--sb-bg),
                    var(--sb-bg-secondary)
                );

            transition:
                background .25s ease,
                color .25s ease;
        }

        /* =====================================================
           MAIN
        ===================================================== */

        .order-page {
            min-height: 100vh;
            padding: 35px 15px 70px;
        }

        .order-page .container {
            max-width: 1250px;
        }

        /* =====================================================
           BACK BUTTON
        ===================================================== */

        .seller-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            color: var(--sb-text);
            background: var(--sb-card);

            border: 1px solid var(--sb-border);

            border-radius: 11px;

            padding: 9px 14px;

            text-decoration: none;
            font-size: 13px;
            font-weight: 700;

            transition: .2s ease;
        }

        .seller-back-btn:hover {
            color: var(--sb-primary);
            border-color: rgba(0,255,153,.35);
            transform: translateY(-1px);
        }

        /* =====================================================
           PAGE TITLE
        ===================================================== */

        .page-title {
            color: var(--sb-text);
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 25px;
        }

        .page-title span {
            color: var(--sb-primary);
        }

        /* =====================================================
           ALERT
        ===================================================== */

        .theme-alert {
            border-radius: 14px;
            border: 1px solid rgba(0,255,153,.25);
            background: var(--sb-primary-soft);
            color: var(--sb-primary);
        }

        /* =====================================================
           CARDS
        ===================================================== */

        .order-card,
        .delivery-card {
            color: var(--sb-text);

            background:
                linear-gradient(
                    145deg,
                    var(--sb-card),
                    rgba(255,255,255,.025)
                );

            border: 1px solid var(--sb-card-border);

            border-radius: 22px;

            padding: 25px;

            backdrop-filter: blur(22px);

            box-shadow:
                0 25px 70px rgba(0,0,0,.25);

            transition:
                background .25s ease,
                border-color .25s ease,
                color .25s ease;
        }

        html[data-sb-theme="light"] .order-card,
        html[data-sb-theme="light"] .delivery-card {
            box-shadow: 0 18px 45px rgba(15,23,42,.08);
        }

        .order-card h2,
        .delivery-card h2 {
            color: var(--sb-text);
            font-weight: 800;
        }

        .order-card hr,
        .delivery-card hr {
            border-color: var(--sb-border);
            opacity: 1;
            margin: 22px 0;
        }

        /* =====================================================
           CUSTOMER
        ===================================================== */

        .customer-name-large {
            color: var(--sb-text);
            font-size: 17px;
            font-weight: 800;
        }

        .order-meta {
            color: var(--sb-muted) !important;
        }

        /* =====================================================
           PRODUCTS
        ===================================================== */

        .order-product {
            display: flex;
            align-items: center;
            gap: 15px;

            padding: 13px;

            border-radius: 15px;

            background: var(--sb-input);

            border: 1px solid var(--sb-border);
        }

        .order-product img {
            width: 72px;
            height: 72px;

            object-fit: cover;

            border-radius: 13px;

            border: 1px solid var(--sb-border);

            background: #111827;
        }

        .order-product strong {
            color: var(--sb-text);
        }

        /* =====================================================
           PAYMENT STATUS
        ===================================================== */

        .payment-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 8px 13px;

            border-radius: 30px;

            background: var(--sb-primary-soft);

            border: 1px solid rgba(0,255,153,.22);

            color: var(--sb-primary);

            font-size: 12px;
            font-weight: 800;
        }

        /* =====================================================
           FORM
        ===================================================== */

        .delivery-card .form-label {
            color: var(--sb-muted);
            font-size: 12px;
            font-weight: 700;
        }

        .delivery-card .form-control,
        .delivery-card .form-select {
            color: var(--sb-text);

            background: var(--sb-input);

            border: 1px solid var(--sb-border);

            border-radius: 11px;

            padding: 11px 13px;

            box-shadow: none;
        }

        .delivery-card .form-control::placeholder {
            color: var(--sb-muted);
        }

        .delivery-card .form-control:focus,
        .delivery-card .form-select:focus {
            color: var(--sb-text);

            background: var(--sb-input);

            border-color: var(--sb-primary);

            box-shadow:
                0 0 0 .18rem rgba(0,255,153,.10);
        }

        .delivery-card .form-select option {
            background: #111827;
            color: #fff;
        }

        html[data-sb-theme="light"] .delivery-card .form-select option {
            background: #fff;
            color: #0f172a;
        }

        /* =====================================================
           ASSIGN BUTTON
        ===================================================== */

        .assign-btn {
            border: 0;

            border-radius: 12px;

            padding: 12px 18px;

            font-weight: 800;

            background: linear-gradient(
                135deg,
                #00ff99,
                #00d982
            );

            color: #03130d;

            box-shadow:
                0 10px 30px rgba(0,255,153,.15);

            transition: .2s ease;
        }

        .assign-btn:hover {
            transform: translateY(-2px);

            color: #03130d;

            box-shadow:
                0 14px 35px rgba(0,255,153,.25);
        }

        /* =====================================================
           THEME SAFE BOOTSTRAP
        ===================================================== */

        .btn-outline-primary {
            color: var(--sb-text);
            border-color: var(--sb-border);
        }

        .btn-outline-primary:hover {
            color: var(--sb-primary);
            background: var(--sb-primary-soft);
            border-color: rgba(0,255,153,.35);
        }

        /* =====================================================
           MOBILE
        ===================================================== */

        @media(max-width: 768px) {

            .order-page {
                padding: 22px 10px 45px;
            }

            .page-title {
                font-size: 26px;
            }

            .order-card,
            .delivery-card {
                padding: 18px;
                border-radius: 18px;
            }

            .order-product {
                align-items: flex-start;
            }

            .order-product img {
                width: 60px;
                height: 60px;
            }
        }
    </style>

    {{-- =====================================================
         THEME: APPLY SAVED SETTING BEFORE PAGE PAINT
    ====================================================== --}}
    <script>
        (function () {

            const possibleKeys = [
                'sb-theme',
                'smartbasket-theme',
                'theme',
                'themeMode',
                'appearance'
            ];

            let savedTheme = null;

            for (const key of possibleKeys) {
                try {
                    const value = localStorage.getItem(key);

                    if (
                        value === 'dark' ||
                        value === 'light'
                    ) {
                        savedTheme = value;
                        break;
                    }
                } catch (e) {}
            }

            if (!savedTheme) {
                savedTheme = 'dark';
            }

            document.documentElement.setAttribute(
                'data-sb-theme',
                savedTheme
            );

        })();
    </script>

</head>

<body>

<main class="order-page">

<div class="container">

    {{-- BACK --}}

    <a href="{{ route('seller.orders.index') }}"
       class="seller-back-btn mb-3">

        <i class="fa-solid fa-arrow-left"></i>

        Seller Orders

    </a>


    {{-- TITLE --}}

    <h1 class="page-title">

        Seller Order
        <span>#{{ $order->id }}</span>

    </h1>


    {{-- SUCCESS --}}

    @if(session('success'))

        <div class="alert theme-alert">

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- ERROR --}}

    @if(session('error'))

        <div class="alert alert-danger">

            <i class="fa-solid fa-triangle-exclamation me-2"></i>

            {{ session('error') }}

        </div>

    @endif


    {{-- VALIDATION --}}

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                Please fix the following:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="row g-4">


        {{-- =================================================
             CUSTOMER + PRODUCT
        ================================================== --}}

        <div class="col-lg-7">

            <section class="order-card">

                <h2 class="h5 mb-3">

                    <i class="fa-solid fa-user me-2"
                       style="color:var(--sb-primary)"></i>

                    Customer Information

                </h2>


                <p class="mb-1 customer-name-large">

                    {{ $order->name }}

                </p>


                <p class="order-meta mb-1">

                    <i class="fa-solid fa-phone me-1"></i>

                    {{ $order->mobile }}

                </p>


                <p class="order-meta mb-0">

                    <i class="fa-solid fa-location-dot me-1"></i>

                    {{ $order->address }}, {{ $order->city }}

                </p>


                <hr>


                <h2 class="h5 mb-3">

                    <i class="fa-solid fa-box me-2"
                       style="color:var(--sb-primary)"></i>

                    Product Information

                </h2>


                @forelse($order->seller_items ?? [] as $item)

                    @php

                        $product =
                            $products[$item['product_id'] ?? null] ?? null;

                    @endphp


                    <div class="order-product mb-3">

                        <img
                            src="{{ $product && $product->image
                                ? asset('products/'.$product->image)
                                : 'https://placehold.co/160x160/1E293B/FFFFFF?text=Product' }}"
                            alt="{{ $item['name'] ?? 'Product' }}"
                        >


                        <div>

                            <strong>

                                {{ $item['name'] ?? ($product?->name ?? 'Product') }}

                            </strong>


                            <span class="d-block order-meta mt-1">

                                ₹{{ number_format((float)($item['price'] ?? 0), 2) }}

                                · Quantity {{ $item['quantity'] ?? 1 }}

                            </span>

                        </div>

                    </div>

                @empty

                    <p class="order-meta">

                        No product information available.

                    </p>

                @endforelse


                <div class="mt-3">

                    <span class="payment-status-pill">

                        <i class="fa-solid fa-credit-card"></i>

                        Payment:
                        {{ $order->payment_status ?? 'Pending' }}

                    </span>

                </div>

            </section>

        </div>


        {{-- =================================================
             DELIVERY ASSIGNMENT
        ================================================== --}}

        <div class="col-lg-5">

            <section class="delivery-card">

                <h2 class="h5 mb-4">

                    <i class="fa-solid fa-truck me-2"
                       style="color:var(--sb-primary)"></i>

                    Assign Delivery Partner

                </h2>


                <form
                    action="{{ route('delivery.assign', $order) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="assignment-form"
                >

                    @csrf


                    {{-- EXISTING PARTNER --}}

                    @if($deliveryPartners->isNotEmpty())

                        <label class="form-label">

                            Existing partner

                        </label>


                        <select
                            name="delivery_partner_id"
                            class="form-select mb-3"
                        >

                            <option value="">
                                Create a new partner
                            </option>


                            @foreach($deliveryPartners as $partner)

                                <option
                                    value="{{ $partner->id }}"
                                    {{ $order->deliveryDetail?->delivery_partner_id == $partner->id ? 'selected' : '' }}
                                >

                                    {{ $partner->name }}
                                    —
                                    {{ $partner->phone }}

                                </option>

                            @endforeach

                        </select>

                    @endif


                    {{-- NAME --}}

                    <label class="form-label">

                        Delivery person name

                    </label>


                    <input
                        name="name"
                        class="form-control mb-3"
                        value="{{ old('name', $order->deliveryDetail?->deliveryPartner?->name) }}"
                        placeholder="Enter delivery partner name"
                    >


                    {{-- IMAGE --}}

                    <label class="form-label">

                        Profile image

                    </label>


                    <input
                        type="file"
                        name="image"
                        class="form-control mb-3"
                        accept="image/jpeg,image/png,image/webp"
                    >


                    {{-- PHONE --}}

                    <label class="form-label">

                        Mobile number

                    </label>


                    <input
                        name="phone"
                        class="form-control mb-3"
                        value="{{ old('phone', $order->deliveryDetail?->deliveryPartner?->phone) }}"
                        placeholder="Enter mobile number"
                    >


                    {{-- VEHICLE --}}

                    <label class="form-label">

                        Vehicle number

                    </label>


                    <input
                        name="vehicle_number"
                        class="form-control mb-3"
                        value="{{ old('vehicle_number', $order->deliveryDetail?->deliveryPartner?->vehicle_number) }}"
                        placeholder="GJ01AB1234"
                    >


                    {{-- CURRENT LOCATION --}}

                    <label class="form-label">

                        Current location

                    </label>


                    <input
                        name="current_location"
                        class="form-control mb-3"
                        value="{{ old('current_location', $order->deliveryDetail?->current_location) }}"
                        placeholder="Seller warehouse"
                    >


                    {{-- STATUS --}}

                    <label class="form-label">

                        Tracking status

                    </label>


                    <select
                        name="status"
                        class="form-select mb-4"
                    >

                        @foreach([
                            'Order Placed',
                            'Seller Confirmed',
                            'Packed',
                            'Picked By Delivery Partner',
                            'Out For Delivery',
                            'Near Customer',
                            'Delivered'
                        ] as $status)

                            <option
                                value="{{ $status }}"
                                {{ old(
                                    'status',
                                    $order->deliveryDetail?->status ?? 'Seller Confirmed'
                                ) == $status ? 'selected' : '' }}
                            >

                                {{ $status }}

                            </option>

                        @endforeach

                    </select>


                    {{-- SUBMIT --}}

                    <button
                        type="submit"
                        class="assign-btn w-100"
                    >

                        <i class="fa-solid fa-truck-fast me-2"></i>

                        Assign Delivery Partner

                    </button>


                </form>

            </section>

        </div>

    </div>

</div>

</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


{{-- =====================================================
     SMART BASKET THEME SYNC
     Works with Settings page localStorage
====================================================== --}}

<script>
(function () {

    function applySmartBasketTheme(theme) {

        if (theme !== 'dark' && theme !== 'light') {
            theme = 'dark';
        }

        document.documentElement.setAttribute(
            'data-sb-theme',
            theme
        );

        document.body.setAttribute(
            'data-sb-theme',
            theme
        );
    }


    function getSavedTheme() {

        const keys = [
            'sb-theme',
            'smartbasket-theme',
            'theme',
            'themeMode',
            'appearance'
        ];

        for (const key of keys) {

            try {

                const value = localStorage.getItem(key);

                if (
                    value === 'dark' ||
                    value === 'light'
                ) {
                    return value;
                }

            } catch (e) {}

        }

        return 'dark';
    }


    // Initial theme
    applySmartBasketTheme(getSavedTheme());


    // Listen for changes from another tab/window
    window.addEventListener('storage', function (event) {

        if (
            [
                'sb-theme',
                'smartbasket-theme',
                'theme',
                'themeMode',
                'appearance'
            ].includes(event.key)
        ) {

            applySmartBasketTheme(
                event.newValue || 'dark'
            );

        }

    });


    // Listen for same-page/custom settings event
    window.addEventListener(
        'smartbasket-theme-changed',
        function (event) {

            if (event.detail) {

                applySmartBasketTheme(
                    event.detail
                );

            }

        }
    );

})();
</script>

</body>
</html>