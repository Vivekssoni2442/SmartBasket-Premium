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
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
    /* =========================================================
       SMART BASKET — SELLER PREMIUM GREEN THEME
       Primary: rgb(0, 255, 153)
    ========================================================= */

    * {
        box-sizing: border-box;
    }

    :root {
        --seller-primary: rgb(0, 255, 153);
        --seller-primary-dark: rgb(0, 210, 125);

        --seller-bg: #050807;
        --seller-bg-2: #08110d;

        --seller-card: rgba(10, 20, 16, 0.88);
        --seller-card-solid: #0b1511;

        --seller-border: rgba(0, 255, 153, 0.14);
        --seller-border-hover: rgba(0, 255, 153, 0.35);

        --seller-text: #f1fff8;
        --seller-text-secondary: #b7c9c1;
        --seller-muted: #71847b;

        --seller-input: rgba(4, 13, 9, 0.90);

        --seller-shadow:
            0 25px 70px rgba(0, 0, 0, 0.42);

        --seller-glow:
            0 0 30px rgba(0, 255, 153, 0.10);

        --seller-radius: 22px;
        --seller-transition: .25s ease;
    }


    /* =========================================================
       HTML / BODY
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
                circle at 10% 5%,
                rgba(0, 255, 153, 0.10),
                transparent 28%
            ),
            radial-gradient(
                circle at 90% 15%,
                rgba(0, 255, 153, 0.07),
                transparent 30%
            ),
            radial-gradient(
                circle at 50% 100%,
                rgba(0, 255, 153, 0.05),
                transparent 35%
            ),
            var(--seller-bg);

        color: var(--seller-text);

        min-height: 100vh;

        overflow-x: hidden;

        transition:
            background .25s ease,
            color .25s ease;
    }


    /* =========================================================
       BACKGROUND GLOW
    ========================================================= */

    body::before {
        content: "";

        position: fixed;

        width: 430px;
        height: 430px;

        top: -200px;
        left: -170px;

        background:
            rgba(0, 255, 153, 0.08);

        filter: blur(100px);

        border-radius: 50%;

        pointer-events: none;

        z-index: 0;
    }

    body::after {
        content: "";

        position: fixed;

        width: 430px;
        height: 430px;

        right: -190px;
        bottom: -190px;

        background:
            rgba(0, 255, 153, 0.06);

        filter: blur(100px);

        border-radius: 50%;

        pointer-events: none;

        z-index: 0;
    }


    /* =========================================================
       MAIN WRAPPER
    ========================================================= */

    .page-wrapper {
        width: 100%;

        min-height: 100vh;

        padding: 35px 22px 60px;

        position: relative;

        z-index: 1;
    }

    .main-container {
        max-width: 1150px;

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

        padding: 18px 22px;

        background:
            linear-gradient(
                145deg,
                rgba(12, 28, 21, 0.94),
                rgba(7, 16, 12, 0.90)
            );

        border:
            1px solid var(--seller-border);

        border-radius: 20px;

        box-shadow:
            var(--seller-shadow),
            inset 0 1px 0 rgba(255,255,255,.025);

        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);

        transition:
            border-color var(--seller-transition),
            box-shadow var(--seller-transition);
    }

    .topbar:hover {
        border-color:
            var(--seller-border-hover);

        box-shadow:
            var(--seller-shadow),
            var(--seller-glow);
    }


    /* =========================================================
       BRAND
    ========================================================= */

    .brand-area {
        display: flex;

        align-items: center;

        gap: 14px;
    }

    .brand-icon {
        width: 46px;
        height: 46px;

        border-radius: 14px;

        display: flex;

        align-items: center;
        justify-content: center;

        background:
            linear-gradient(
                135deg,
                rgb(0, 255, 153),
                rgb(0, 190, 120)
            );

        color: #001b10;

        font-size: 20px;

        box-shadow:
            0 10px 35px rgba(0,255,153,.20);
    }

    .brand-title {
        margin: 0;

        font-size: 18px;

        font-weight: 800;

        letter-spacing: .3px;

        color: var(--seller-text);
    }

    .brand-subtitle {
        margin: 3px 0 0;

        color: var(--seller-muted);

        font-size: 12px;
    }


    /* =========================================================
       DASHBOARD BUTTON
    ========================================================= */

    .dashboard-btn {
        display: inline-flex;

        align-items: center;

        gap: 8px;

        padding: 11px 17px;

        border-radius: 12px;

        border:
            1px solid var(--seller-border);

        background:
            rgba(0, 255, 153, 0.04);

        color:
            var(--seller-primary);

        text-decoration: none;

        font-size: 13px;

        font-weight: 700;

        transition:
            all var(--seller-transition);
    }

    .dashboard-btn:hover {
        color: #001b10;

        background:
            var(--seller-primary);

        border-color:
            var(--seller-primary);

        transform:
            translateY(-2px);

        box-shadow:
            0 10px 30px rgba(0,255,153,.18);
    }


    /* =========================================================
       PAGE HEADER
    ========================================================= */

    .page-header {
        margin-bottom: 24px;
    }

    .page-header h1 {
        margin: 0;

        font-size: 30px;

        font-weight: 800;

        letter-spacing: -.5px;

        color: var(--seller-text);
    }

    .page-header h1 i {
        color:
            var(--seller-primary);
    }

    .page-header p {
        margin: 7px 0 0;

        color:
            var(--seller-text-secondary);

        font-size: 14px;
    }


    /* =========================================================
       PRODUCT ID
    ========================================================= */

    .product-id {
        display: inline-flex;

        align-items: center;

        gap: 7px;

        margin-top: 14px;

        padding: 7px 12px;

        border-radius: 999px;

        background:
            rgba(0,255,153,.06);

        border:
            1px solid rgba(0,255,153,.16);

        color:
            var(--seller-primary);

        font-size: 12px;

        font-weight: 700;
    }


    /* =========================================================
       ALERTS
    ========================================================= */

    .custom-alert {
        border-radius: 15px;

        padding: 15px 17px;

        margin-bottom: 20px;

        font-size: 13px;

        font-weight: 600;

        backdrop-filter: blur(15px);
    }

    .alert-error {
        background:
            rgba(127,29,29,.22);

        border:
            1px solid rgba(248,113,113,.25);

        color:
            #fca5a5;
    }

    .alert-success {
        background:
            rgba(0,255,153,.07);

        border:
            1px solid rgba(0,255,153,.20);

        color:
            var(--seller-primary);
    }


    /* =========================================================
       FORM CARD
    ========================================================= */

    .form-card {
        background:
            linear-gradient(
                145deg,
                rgba(11,24,17,.94),
                rgba(5,13,9,.92)
            );

        border:
            1px solid var(--seller-border);

        border-radius: 26px;

        padding: 30px;

        box-shadow:
            var(--seller-shadow),
            inset 0 1px 0 rgba(255,255,255,.025);

        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
    }


    /* =========================================================
       FORM SECTION
    ========================================================= */

    .form-section {
        margin-bottom: 32px;
    }

    .section-heading {
        display: flex;

        align-items: center;

        gap: 12px;

        padding-bottom: 14px;

        margin-bottom: 20px;

        border-bottom:
            1px solid rgba(0,255,153,.10);
    }

    .section-icon {
        width: 38px;
        height: 38px;

        border-radius: 11px;

        display: flex;

        align-items: center;
        justify-content: center;

        background:
            rgba(0,255,153,.08);

        color:
            var(--seller-primary);

        border:
            1px solid rgba(0,255,153,.12);

        font-size: 15px;
    }

    .section-heading h2 {
        margin: 0;

        font-size: 16px;

        font-weight: 800;

        color:
            var(--seller-text);
    }

    .section-heading p {
        margin: 3px 0 0;

        color:
            var(--seller-muted);

        font-size: 11px;
    }


    /* =========================================================
       LABELS
    ========================================================= */

    .form-label {
        color:
            var(--seller-text-secondary);

        font-size: 12px;

        font-weight: 700;

        margin-bottom: 8px;
    }

    .required {
        color:
            #ff6b6b;
    }


    /* =========================================================
       INPUTS
    ========================================================= */

    .form-control,
    .form-select {
        width: 100%;

        min-height: 48px;

        background:
            var(--seller-input) !important;

        border:
            1px solid rgba(0,255,153,.12) !important;

        border-radius:
            13px !important;

        color:
            var(--seller-text) !important;

        padding:
            12px 14px;

        font-size:
            13px;

        box-shadow:
            none !important;

        transition:
            all .20s ease;
    }

    textarea.form-control {
        min-height: 120px;

        resize: vertical;
    }

    .form-control::placeholder {
        color:
            #647970 !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color:
            var(--seller-primary) !important;

        background:
            rgba(5,20,13,.96) !important;

        color:
            var(--seller-text) !important;

        box-shadow:
            0 0 0 3px rgba(0,255,153,.10) !important;
    }

    .form-select option {
        background:
            var(--seller-card-solid);

        color:
            var(--seller-text);
    }


    /* =========================================================
       FILE INPUT
    ========================================================= */

    input[type="file"].form-control {
        padding-top: 10px;
    }

    input[type="file"]::file-selector-button {
        background:
            rgba(0,255,153,.10);

        color:
            var(--seller-primary);

        border:
            1px solid rgba(0,255,153,.18);

        border-radius:
            9px;

        padding:
            7px 12px;

        margin-right:
            10px;

        font-weight:
            700;

        cursor:
            pointer;
    }

    input[type="file"]::file-selector-button:hover {
        background:
            rgba(0,255,153,.18);
    }


    /* =========================================================
       NUMBER INPUT
    ========================================================= */

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        opacity: .5;
    }


    /* =========================================================
       IMAGE AREA
    ========================================================= */

    .image-box {
        background:
            rgba(3,12,8,.60);

        border:
            1px solid rgba(0,255,153,.10);

        border-radius:
            18px;

        padding:
            18px;
    }

    .image-title {
        font-size: 12px;

        font-weight: 800;

        color:
            var(--seller-text);

        margin-bottom: 12px;
    }

    .image-title i {
        color:
            var(--seller-primary);
    }

    .current-image {
        display: block;

        width: 100%;

        max-width: 350px;

        height: 230px;

        object-fit: contain;

        background:
            #020806;

        border-radius:
            15px;

        border:
            1px solid rgba(0,255,153,.12);

        margin-bottom:
            15px;
    }

    .image-note {
        color:
            var(--seller-muted);

        font-size:
            11px;

        margin-top:
            7px;
    }

    .extra-images {
        display: flex;

        flex-wrap: wrap;

        gap: 10px;

        margin-top: 15px;
    }

    .extra-image {
        width: 88px;

        height: 72px;

        object-fit: cover;

        border-radius: 10px;

        border:
            1px solid rgba(0,255,153,.14);

        transition:
            all .20s ease;
    }

    .extra-image:hover {
        transform:
            translateY(-3px);

        border-color:
            var(--seller-primary);

        box-shadow:
            0 8px 25px rgba(0,255,153,.15);
    }


    /* =========================================================
       BUTTONS
    ========================================================= */

    .bottom-actions {
        display: flex;

        align-items: center;

        gap: 12px;

        padding-top: 24px;

        margin-top: 5px;

        border-top:
            1px solid rgba(0,255,153,.10);
    }

    .btn-cancel {
        flex: 1;

        min-height: 50px;

        display: flex;

        align-items: center;
        justify-content: center;

        gap: 8px;

        border-radius: 13px;

        border:
            1px solid rgba(0,255,153,.15);

        background:
            rgba(0,255,153,.03);

        color:
            var(--seller-text-secondary);

        text-decoration: none;

        font-size: 13px;

        font-weight: 800;

        transition:
            all .25s ease;
    }

    .btn-cancel:hover {
        color:
            var(--seller-primary);

        background:
            rgba(0,255,153,.08);

        border-color:
            rgba(0,255,153,.30);

        transform:
            translateY(-2px);
    }

    .btn-update {
        flex: 2;

        min-height: 50px;

        border: 0;

        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                rgb(0,255,153),
                rgb(0,205,125)
            );

        color:
            #001b10;

        font-size: 13px;

        font-weight: 900;

        letter-spacing: .2px;

        box-shadow:
            0 12px 30px rgba(0,255,153,.18);

        transition:
            all .25s ease;

        cursor: pointer;
    }

    .btn-update:hover {
        transform:
            translateY(-2px);

        color:
            #001b10;

        box-shadow:
            0 18px 42px rgba(0,255,153,.28);
    }


    /* =========================================================
       FOOTER
    ========================================================= */

    .page-footer {
        text-align: center;

        color:
            #4f655b;

        font-size: 11px;

        margin-top: 25px;
    }


    /* =========================================================
       TEXT SECONDARY OVERRIDE
    ========================================================= */

    .text-secondary {
        color:
            var(--seller-muted) !important;
    }


    /* =========================================================
       MOBILE
    ========================================================= */

    @media (max-width: 768px) {

        .page-wrapper {
            padding:
                18px 12px 40px;
        }

        .topbar {
            padding: 15px;

            border-radius: 16px;
        }

        .brand-subtitle {
            display: none;
        }

        .brand-title {
            font-size: 15px;
        }

        .brand-icon {
            width: 40px;
            height: 40px;

            border-radius: 11px;
        }

        .dashboard-btn span {
            display: none;
        }

        .dashboard-btn {
            width: 42px;
            height: 42px;

            padding: 0;

            justify-content: center;
        }

        .page-header h1 {
            font-size: 24px;
        }

        .form-card {
            padding: 18px;

            border-radius: 20px;
        }

        .bottom-actions {
            flex-direction: column-reverse;
        }

        .btn-cancel,
        .btn-update {
            width: 100%;

            flex: none;
        }
    }
</style>
</head>

<body>

<div class="page-wrapper">

    <div class="main-container">

        {{-- ============================
             TOP BAR
        ============================= --}}

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
                <span>Dashboard</span>
            </a>

        </div>


        {{-- ============================
             PAGE HEADER
        ============================= --}}

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
                Product ID: {{ $product->id }}
            </div>

        </div>


        {{-- ============================
             ALERTS
        ============================= --}}

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


        {{-- ============================
             FORM
        ============================= --}}

        <div class="form-card">

            <form
                method="POST"
                action="{{ route('seller.product.update', $product->id) }}"
                enctype="multipart/form-data"
            >

                @csrf


                {{-- BASIC INFORMATION --}}

                <div class="form-section">

                    <div class="section-heading">

                        <div class="section-icon">
                            <i class="fa-solid fa-box"></i>
                        </div>

                        <div>
                            <h2>Basic Information</h2>
                            <p>Enter the main product details</p>
                        </div>

                    </div>


                    <div class="row g-4">

                        <div class="col-md-6">

                            <label class="form-label">
                                Product Name
                                <span class="required">*</span>
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
                                <span class="required">*</span>
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


                {{-- PRICE & INVENTORY --}}

                <div class="form-section">

                    <div class="section-heading">

                        <div class="section-icon">
                            <i class="fa-solid fa-indian-rupee-sign"></i>
                        </div>

                        <div>
                            <h2>Price & Inventory</h2>
                            <p>Manage pricing and available stock</p>
                        </div>

                    </div>


                    <div class="row g-4">

                        <div class="col-md-4">

                            <label class="form-label">
                                Price (₹)
                                <span class="required">*</span>
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
                                <span class="required">*</span>
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


                {{-- PRODUCT DETAILS --}}

                <div class="form-section">

                    <div class="section-heading">

                        <div class="section-icon">
                            <i class="fa-solid fa-sliders"></i>
                        </div>

                        <div>
                            <h2>Product Details</h2>
                            <p>Add size, color and product description</p>
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


                {{-- PRODUCT IMAGES --}}

                <div class="form-section">

                    <div class="section-heading">

                        <div class="section-icon">
                            <i class="fa-solid fa-images"></i>
                        </div>

                        <div>
                            <h2>Product Images</h2>
                            <p>Manage your main and additional product images</p>
                        </div>

                    </div>


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
                                Supported formats: JPG, JPEG, PNG and WEBP.
                            </div>

                        </div>


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


                {{-- ACTION BUTTONS --}}

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
                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        UPDATE PRODUCT
                    </button>

                </div>

            </form>

        </div>


        <div class="page-footer">
            SMART BASKET • Seller Partner Panel
        </div>

    </div>

</div>

</body>
</html>