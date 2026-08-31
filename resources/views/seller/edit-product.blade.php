<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Product | SMART BASKET</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    <style>
    /* =========================================================
       SMART BASKET
       SELLER — EDIT PRODUCT
       PREMIUM LIGHT THEME
       ========================================================= */

    * {
        box-sizing: border-box;
    }

    :root {
        --primary: #00c878;
        --primary-dark: #00a968;
        --primary-soft: #ecfdf5;
        --primary-soft-2: #f0fdf8;

        --page-bg: #f5f7fa;
        --page-bg-2: #eef2f6;

        --card: #ffffff;
        --card-soft: #f8fafc;

        --border: #e2e8f0;
        --border-soft: #edf1f5;

        --text: #172033;
        --text-dark: #0f172a;
        --text-secondary: #475569;
        --muted: #64748b;
        --placeholder: #94a3b8;

        --danger: #ef4444;
        --danger-soft: #fef2f2;

        --shadow-sm:
            0 4px 15px rgba(15, 23, 42, .05);

        --shadow:
            0 15px 45px rgba(15, 23, 42, .08);

        --shadow-lg:
            0 25px 70px rgba(15, 23, 42, .10);

        --radius: 20px;
        --transition: .25s ease;
    }


    /* =========================================================
       PAGE
       ========================================================= */

    html,
    body {
        margin: 0;
        padding: 0;
        min-height: 100%;
    }

    body {
        font-family: 'Inter', sans-serif;

        background:
            radial-gradient(
                circle at 8% 0%,
                rgba(0, 200, 120, .07),
                transparent 28%
            ),
            radial-gradient(
                circle at 92% 8%,
                rgba(59, 130, 246, .045),
                transparent 25%
            ),
            linear-gradient(
                135deg,
                #f8fafc 0%,
                #f4f7fa 50%,
                #eef2f6 100%
            );

        color: var(--text);

        min-height: 100vh;

        overflow-x: hidden;
    }


    /* =========================================================
       DECORATIVE BACKGROUND
       ========================================================= */

    body::before {
        content: "";

        position: fixed;

        width: 420px;
        height: 420px;

        top: -220px;
        left: -180px;

        border-radius: 50%;

        background:
            rgba(0, 200, 120, .055);

        filter: blur(90px);

        pointer-events: none;

        z-index: 0;
    }

    body::after {
        content: "";

        position: fixed;

        width: 400px;
        height: 400px;

        right: -190px;
        bottom: -190px;

        border-radius: 50%;

        background:
            rgba(59, 130, 246, .035);

        filter: blur(90px);

        pointer-events: none;

        z-index: 0;
    }


    /* =========================================================
       MAIN WRAPPER
       ========================================================= */

    .page-wrapper {
        position: relative;
        z-index: 1;

        width: 100%;
        min-height: 100vh;

        padding: 30px 22px 55px;
    }

    .main-container {
        width: 100%;
        max-width: 1180px;

        margin: 0 auto;
    }


    /* =========================================================
       TOP BAR
       ========================================================= */

    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        margin-bottom: 28px;

        padding: 17px 20px;

        background:
            rgba(255,255,255,.88);

        border:
            1px solid rgba(226,232,240,.95);

        border-radius: 18px;

        box-shadow:
            var(--shadow-sm);

        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);

        transition:
            box-shadow var(--transition),
            border-color var(--transition);
    }

    .topbar:hover {
        border-color:
            rgba(0,200,120,.20);

        box-shadow:
            var(--shadow);
    }


    /* =========================================================
       BRAND
       ========================================================= */

    .brand-area {
        display: flex;
        align-items: center;

        gap: 13px;
    }

    .brand-icon {
        width: 46px;
        height: 46px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #00d986,
                #00b96f
            );

        color: #ffffff;

        font-size: 19px;

        box-shadow:
            0 9px 25px rgba(0,200,120,.20);
    }

    .brand-title {
        margin: 0;

        color: var(--text-dark);

        font-size: 17px;

        font-weight: 900;

        letter-spacing: .2px;
    }

    .brand-subtitle {
        margin: 3px 0 0;

        color: var(--muted);

        font-size: 11px;

        font-weight: 500;
    }


    /* =========================================================
       DASHBOARD BUTTON
       ========================================================= */

    .dashboard-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        min-height: 42px;

        padding: 0 16px;

        border-radius: 11px;

        border:
            1px solid #cdeee0;

        background:
            #f0fdf7;

        color:
            #009c62;

        text-decoration: none;

        font-size: 12px;

        font-weight: 800;

        transition:
            all var(--transition);
    }

    .dashboard-btn:hover {
        color: #ffffff;

        background:
            linear-gradient(
                135deg,
                #00d986,
                #00b96f
            );

        border-color:
            #00c878;

        transform:
            translateY(-2px);

        box-shadow:
            0 10px 25px rgba(0,200,120,.18);
    }


    /* =========================================================
       PAGE HEADER
       ========================================================= */

    .page-header {
        margin-bottom: 22px;
    }

    .page-header h1 {
        margin: 0;

        color: var(--text-dark);

        font-size: 30px;

        line-height: 1.2;

        font-weight: 900;

        letter-spacing: -.7px;
    }

    .page-header h1 i {
        color:
            var(--primary);
    }

    .page-header p {
        margin: 7px 0 0;

        color:
            var(--text-secondary);

        font-size: 13px;
    }


    /* =========================================================
       PRODUCT ID
       ========================================================= */

    .product-id {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        margin-top: 13px;

        padding: 7px 12px;

        border-radius: 999px;

        background:
            var(--primary-soft);

        border:
            1px solid #ccefe0;

        color:
            #008b58;

        font-size: 11px;

        font-weight: 800;
    }


    /* =========================================================
       ALERTS
       ========================================================= */

    .custom-alert {
        display: block;

        border-radius: 14px;

        padding: 14px 16px;

        margin-bottom: 18px;

        font-size: 12px;

        font-weight: 600;

        box-shadow:
            0 5px 18px rgba(15,23,42,.04);
    }

    .alert-error {
        background:
            var(--danger-soft);

        border:
            1px solid #fecaca;

        color:
            #b91c1c;
    }

    .alert-success {
        background:
            var(--primary-soft);

        border:
            1px solid #b7ebd5;

        color:
            #008b58;
    }


    /* =========================================================
       FORM CARD
       ========================================================= */

    .form-card {
        padding: 30px;

        background:
            rgba(255,255,255,.96);

        border:
            1px solid rgba(226,232,240,.95);

        border-radius:
            24px;

        box-shadow:
            var(--shadow-lg);

        backdrop-filter:
            blur(18px);

        -webkit-backdrop-filter:
            blur(18px);
    }


    /* =========================================================
       FORM SECTION
       ========================================================= */

    .form-section {
        margin-bottom: 34px;
    }

    .form-section:last-of-type {
        margin-bottom: 5px;
    }

    .section-heading {
        display: flex;

        align-items: center;

        gap: 12px;

        padding-bottom: 14px;

        margin-bottom: 21px;

        border-bottom:
            1px solid var(--border-soft);
    }

    .section-icon {
        width: 39px;
        height: 39px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 11px;

        background:
            var(--primary-soft);

        color:
            var(--primary-dark);

        border:
            1px solid #ccefe0;

        font-size: 14px;
    }

    .section-heading h2 {
        margin: 0;

        color:
            var(--text-dark);

        font-size: 15px;

        font-weight: 850;
    }

    .section-heading p {
        margin: 3px 0 0;

        color:
            var(--muted);

        font-size: 10px;

        font-weight: 500;
    }


    /* =========================================================
       LABELS
       ========================================================= */

    .form-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--text-secondary);

        font-size: 11px;

        font-weight: 800;
    }

    .required {
        color:
            #ef4444;
    }


    /* =========================================================
       INPUTS
       ========================================================= */

    .form-control,
    .form-select {
        width: 100%;

        min-height: 48px;

        padding:
            11px 14px;

        background:
            #ffffff !important;

        color:
            var(--text-dark) !important;

        border:
            1px solid #dce3eb !important;

        border-radius:
            12px !important;

        font-size:
            12px;

        font-weight:
            500;

        box-shadow:
            0 2px 7px rgba(15,23,42,.025) !important;

        transition:
            border-color .20s ease,
            box-shadow .20s ease,
            background .20s ease;
    }

    .form-control:hover,
    .form-select:hover {
        border-color:
            #c7d2de !important;
    }

    .form-control:focus,
    .form-select:focus {
        background:
            #ffffff !important;

        color:
            var(--text-dark) !important;

        border-color:
            #00c878 !important;

        box-shadow:
            0 0 0 3px rgba(0,200,120,.10),
            0 5px 15px rgba(15,23,42,.04) !important;

        outline:
            none !important;
    }

    .form-control::placeholder {
        color:
            var(--placeholder) !important;

        opacity: 1;
    }

    .form-select option {
        background:
            #ffffff;

        color:
            var(--text-dark);
    }

    textarea.form-control {
        min-height: 125px;

        resize: vertical;

        line-height: 1.6;
    }


    /* =========================================================
       FILE INPUT
       ========================================================= */

    input[type="file"].form-control {
        padding-top: 9px;
        padding-bottom: 9px;
    }

    input[type="file"]::file-selector-button {
        margin-right: 10px;

        padding: 7px 12px;

        border:
            1px solid #bcebd7;

        border-radius: 8px;

        background:
            #ecfdf5;

        color:
            #008b58;

        font-size: 11px;

        font-weight: 800;

        cursor: pointer;

        transition:
            all .2s ease;
    }

    input[type="file"]::file-selector-button:hover {
        background:
            #d9faec;

        border-color:
            #8fe0bd;
    }


    /* =========================================================
       IMAGE BOX
       ========================================================= */

    .image-box {
        padding: 18px;

        background:
            #f8fafc;

        border:
            1px solid var(--border);

        border-radius:
            17px;
    }

    .image-title {
        margin-bottom: 13px;

        color:
            var(--text-dark);

        font-size: 11px;

        font-weight: 850;
    }

    .image-title i {
        color:
            var(--primary-dark);
    }

    .current-image {
        display: block;

        width: 100%;

        max-width: 350px;

        height: 230px;

        object-fit: contain;

        padding: 8px;

        background:
            #ffffff;

        border:
            1px solid #e2e8f0;

        border-radius:
            14px;

        margin-bottom: 12px;

        box-shadow:
            0 8px 25px rgba(15,23,42,.06);
    }

    .image-note {
        margin-top: 7px;

        color:
            var(--muted);

        font-size:
            10px;

        line-height:
            1.5;
    }

    .extra-images {
        display: flex;

        flex-wrap: wrap;

        gap: 10px;

        margin-top: 14px;
    }

    .extra-image {
        width: 88px;
        height: 72px;

        object-fit: cover;

        padding: 2px;

        background: #ffffff;

        border:
            1px solid #dce3eb;

        border-radius:
            10px;

        transition:
            all .20s ease;
    }

    .extra-image:hover {
        transform:
            translateY(-3px);

        border-color:
            var(--primary);

        box-shadow:
            0 9px 22px rgba(0,200,120,.15);
    }


    /* =========================================================
       BOTTOM ACTIONS
       ========================================================= */

    .bottom-actions {
        display: flex;

        align-items: center;

        gap: 12px;

        padding-top: 25px;

        margin-top: 8px;

        border-top:
            1px solid var(--border-soft);
    }

    .btn-cancel,
    .btn-update {
        min-height: 50px;

        display: flex;

        align-items: center;
        justify-content: center;

        gap: 8px;

        border-radius: 12px;

        font-size: 12px;

        font-weight: 850;

        transition:
            all .25s ease;
    }

    .btn-cancel {
        flex: 1;

        background:
            #ffffff;

        border:
            1px solid #dce3eb;

        color:
            var(--text-secondary);

        text-decoration:
            none;
    }

    .btn-cancel:hover {
        color:
            #008b58;

        background:
            var(--primary-soft);

        border-color:
            #bcebd7;

        transform:
            translateY(-2px);
    }

    .btn-update {
        flex: 2;

        border:
            0;

        background:
            linear-gradient(
                135deg,
                #00d986,
                #00b96f
            );

        color:
            #ffffff;

        box-shadow:
            0 10px 28px rgba(0,200,120,.18);

        cursor:
            pointer;
    }

    .btn-update:hover {
        color:
            #ffffff;

        transform:
            translateY(-2px);

        box-shadow:
            0 16px 38px rgba(0,200,120,.25);
    }

    .btn-update:active,
    .btn-cancel:active,
    .dashboard-btn:active {
        transform:
            translateY(0);
    }


    /* =========================================================
       FOOTER
       ========================================================= */

    .page-footer {
        margin-top: 24px;

        text-align: center;

        color:
            #94a3b8;

        font-size:
            10px;

        font-weight:
            500;
    }


    /* =========================================================
       SECONDARY TEXT
       ========================================================= */

    .text-secondary {
        color:
            var(--muted) !important;
    }


    /* =========================================================
       MOBILE
       ========================================================= */

    @media (max-width: 768px) {

        .page-wrapper {
            padding:
                16px 11px 38px;
        }

        .topbar {
            padding:
                13px;

            border-radius:
                15px;
        }

        .brand-icon {
            width:
                40px;

            height:
                40px;

            border-radius:
                11px;
        }

        .brand-title {
            font-size:
                14px;
        }

        .brand-subtitle {
            display:
                none;
        }

        .dashboard-btn {
            width:
                42px;

            height:
                42px;

            padding:
                0;
        }

        .dashboard-btn span {
            display:
                none;
        }

        .page-header h1 {
            font-size:
                24px;
        }

        .page-header p {
            font-size:
                11px;

            line-height:
                1.6;
        }

        .form-card {
            padding:
                18px;

            border-radius:
                19px;
        }

        .section-heading {
            margin-bottom:
                18px;
        }

        .bottom-actions {
            flex-direction:
                column-reverse;
        }

        .btn-cancel,
        .btn-update {
            width:
                100%;

            flex:
                none;
        }

        .current-image {
            max-width:
                100%;

            height:
                210px;
        }
    }


    /* =========================================================
       SMALL MOBILE
       ========================================================= */

    @media (max-width: 480px) {

        .page-wrapper {
            padding-left:
                8px;

            padding-right:
                8px;
        }

        .form-card {
            padding:
                15px;
        }

        .topbar {
            margin-bottom:
                20px;
        }

        .page-header h1 {
            font-size:
                22px;
        }

        .product-id {
            font-size:
                10px;
        }

        .section-icon {
            width:
                36px;

            height:
                36px;
        }

        .section-heading h2 {
            font-size:
                14px;
        }

        .form-control,
        .form-select {
            min-height:
                46px;
        }
    }


    /* =========================================================
       REDUCED MOTION
       ========================================================= */

    @media (prefers-reduced-motion: reduce) {

        *,
        *::before,
        *::after {
            transition:
                none !important;
        }
    }
    </style>
</head>

<body>

<div class="page-wrapper">

    <div class="main-container">


        {{-- =====================================================
             TOP BAR
        ====================================================== --}}

        <div class="topbar">

            <div class="brand-area">

                <div class="brand-icon">
                    <i class="fa-solid fa-basket-shopping"></i>
                </div>

                <div>

                    <h3 class="brand-title">
                        SMART BASKET
                    </h3>

                    <p class="brand-subtitle">
                        Seller Partner Panel
                    </p>

                </div>

            </div>


            <a
                href="{{ route('seller.dashboard') }}"
                class="dashboard-btn"
            >

                <i class="fa-solid fa-house"></i>

                <span>
                    Dashboard
                </span>

            </a>

        </div>


        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <div class="page-header">

            <h1>
                <i class="fa-solid fa-pen-to-square me-2"></i>
                Edit Product
            </h1>

            <p>
                Update your product information, pricing, stock and images.
            </p>

            <div class="product-id">

                <i class="fa-solid fa-hashtag"></i>

                Product ID:
                {{ $product->id }}

            </div>

        </div>


        {{-- =====================================================
             ALERTS
        ====================================================== --}}

        @if(session('success'))

            <div class="custom-alert alert-success">

                <i class="fa-solid fa-circle-check me-2"></i>

                {{ session('success') }}

            </div>

        @endif


        @if(session('error'))

            <div class="custom-alert alert-error">

                <i class="fa-solid fa-circle-exclamation me-2"></i>

                {{ session('error') }}

            </div>

        @endif


        @if($errors->any())

            <div class="custom-alert alert-error">

                @foreach($errors->all() as $error)

                    <div class="mb-1">

                        <i class="fa-solid fa-triangle-exclamation me-2"></i>

                        {{ $error }}

                    </div>

                @endforeach

            </div>

        @endif


        {{-- =====================================================
             FORM CARD
        ====================================================== --}}

        <div class="form-card">

            <form
                method="POST"
                action="{{ route('seller.product.update', $product->id) }}"
                enctype="multipart/form-data"
            >

                @csrf


                {{-- =================================================
                     BASIC INFORMATION
                ================================================== --}}

                <div class="form-section">

                    <div class="section-heading">

                        <div class="section-icon">
                            <i class="fa-solid fa-box"></i>
                        </div>

                        <div>

                            <h2>
                                Basic Information
                            </h2>

                            <p>
                                Enter the main product details
                            </p>

                        </div>

                    </div>


                    <div class="row g-4">


                        <div class="col-md-6">

                            <label class="form-label">

                                Product Name

                                <span class="required">
                                    *
                                </span>

                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name', $product->name) }}"
                                placeholder="Enter product name"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">

                                Category

                                <span class="required">
                                    *
                                </span>

                            </label>

                            <input
                                type="text"
                                name="category"
                                class="form-control"
                                value="{{ old('category', $product->category) }}"
                                placeholder="e.g. Home Decor"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Brand
                            </label>

                            <input
                                type="text"
                                name="brand"
                                class="form-control"
                                value="{{ old('brand', $product->brand) }}"
                                placeholder="Enter brand name"
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select"
                            >

                                <option
                                    value="active"
                                    {{ old('status', $product->status ?? 'active') === 'active' ? 'selected' : '' }}
                                >
                                    Active
                                </option>

                                <option
                                    value="inactive"
                                    {{ old('status', $product->status ?? '') === 'inactive' ? 'selected' : '' }}
                                >
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     PRICE & INVENTORY
                ================================================== --}}

                <div class="form-section">

                    <div class="section-heading">

                        <div class="section-icon">
                            <i class="fa-solid fa-indian-rupee-sign"></i>
                        </div>

                        <div>

                            <h2>
                                Price &amp; Inventory
                            </h2>

                            <p>
                                Manage pricing and available stock
                            </p>

                        </div>

                    </div>


                    <div class="row g-4">


                        <div class="col-md-4">

                            <label class="form-label">

                                Price (₹)

                                <span class="required">
                                    *
                                </span>

                            </label>

                            <input
                                type="number"
                                name="price"
                                class="form-control"
                                value="{{ old('price', $product->price) }}"
                                step="0.01"
                                min="0"
                                required
                            >

                        </div>


                        <div class="col-md-4">

                            <label class="form-label">
                                Discount Price (₹)
                            </label>

                            <input
                                type="number"
                                name="discount_price"
                                class="form-control"
                                value="{{ old('discount_price', $product->discount_price) }}"
                                step="0.01"
                                min="0"
                                placeholder="Optional"
                            >

                        </div>


                        <div class="col-md-4">

                            <label class="form-label">

                                Stock Quantity

                                <span class="required">
                                    *
                                </span>

                            </label>

                            <input
                                type="number"
                                name="stock"
                                class="form-control"
                                value="{{ old('stock', $product->stock) }}"
                                min="0"
                                required
                            >

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     PRODUCT DETAILS
                ================================================== --}}

                <div class="form-section">

                    <div class="section-heading">

                        <div class="section-icon">
                            <i class="fa-solid fa-sliders"></i>
                        </div>

                        <div>

                            <h2>
                                Product Details
                            </h2>

                            <p>
                                Add size, color and product description
                            </p>

                        </div>

                    </div>


                    <div class="row g-4">


                        <div class="col-md-6">

                            <label class="form-label">
                                Size
                            </label>

                            <input
                                type="text"
                                name="size"
                                class="form-control"
                                value="{{ old('size', $product->size) }}"
                                placeholder="e.g. Medium"
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Color
                            </label>

                            <input
                                type="text"
                                name="color"
                                class="form-control"
                                value="{{ old('color', $product->color) }}"
                                placeholder="e.g. Golden"
                            >

                        </div>


                        <div class="col-12">

                            <label class="form-label">
                                Product Description
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="5"
                                placeholder="Describe your product..."
                            >{{ old('description', $product->description) }}</textarea>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     PRODUCT IMAGES
                ================================================== --}}

                <div class="form-section">

                    <div class="section-heading">

                        <div class="section-icon">
                            <i class="fa-solid fa-images"></i>
                        </div>

                        <div>

                            <h2>
                                Product Images
                            </h2>

                            <p>
                                Manage your main and additional product images
                            </p>

                        </div>

                    </div>


                    {{-- CURRENT IMAGE --}}

                    <div class="image-box mb-4">

                        <div class="image-title">

                            <i class="fa-solid fa-image me-2"></i>

                            Current Main Image

                        </div>


                        @if($product->image)

                            <img
                                src="{{ asset('products/' . $product->image) }}"
                                class="current-image"
                                alt="{{ $product->name }}"
                            >

                            <div class="image-note">

                                This is your current main product image.

                            </div>

                        @else

                            <div class="text-secondary py-4">

                                <i class="fa-solid fa-image me-2"></i>

                                No main image available.

                            </div>

                        @endif

                    </div>


                    <div class="row g-4">


                        {{-- MAIN IMAGE --}}

                        <div class="col-12">

                            <label class="form-label">

                                Change Main Image

                                <span class="text-secondary">
                                    (Optional)
                                </span>

                            </label>

                            <input
                                type="file"
                                name="image"
                                class="form-control"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                            >

                            <div class="image-note">

                                Supported formats:
                                JPG, JPEG, PNG and WEBP.

                            </div>

                        </div>


                        {{-- EXTRA IMAGES --}}

                        <div class="col-12">

                            <label class="form-label">

                                Add More Product Images

                                <span class="text-secondary">
                                    (Multiple allowed)
                                </span>

                            </label>

                            <input
                                type="file"
                                name="images[]"
                                class="form-control"
                                multiple
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                            >

                            <div class="image-note">

                                You can select multiple product images at once.

                            </div>


                            @if($product->images->isNotEmpty())

                                <div class="extra-images">

                                    @foreach($product->images as $extraImage)

                                        <img
                                            src="{{ asset('storage/' . $extraImage->path) }}"
                                            class="extra-image"
                                            alt="Product image"
                                        >

                                    @endforeach

                                </div>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     ACTION BUTTONS
                ================================================== --}}

                <div class="bottom-actions">

                    <a
                        href="{{ route('seller.products.index') }}"
                        class="btn-cancel"
                    >

                        <i class="fa-solid fa-arrow-left"></i>

                        Cancel

                    </a>


                    <button
                        type="submit"
                        class="btn-update"
                    >

                        <i class="fa-solid fa-floppy-disk"></i>

                        UPDATE PRODUCT

                    </button>

                </div>

            </form>

        </div>


        {{-- =====================================================
             FOOTER
        ====================================================== --}}

        <div class="page-footer">

            SMART BASKET
            <span>•</span>
            Seller Partner Panel

        </div>

    </div>

</div>

</body>

    @include('seller.partials.seller-menu')
</html>