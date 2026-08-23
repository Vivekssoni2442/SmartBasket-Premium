<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Product | SMART BASKET Seller</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/premium-dark-theme.css') }}"
    >

    <style>

        /* =====================================================
           GLOBAL
        ===================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;

            color: #fff;

            background:
                radial-gradient(
                    circle at 5% 5%,
                    rgba(0,255,153,.10),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 95% 15%,
                    rgba(59,130,246,.10),
                    transparent 25%
                ),
                radial-gradient(
                    circle at 50% 100%,
                    rgba(0,255,153,.06),
                    transparent 35%
                ),
                #020617;

            overflow-x: hidden;
        }


        /* =====================================================
           PAGE
        ===================================================== */

        .product-page {

            width: 100%;

            min-height: 100vh;

            padding: 35px 25px 70px;
        }


        .product-container {

            width: 100%;

            max-width: 1100px;

            margin: auto;
        }


        /* =====================================================
           TOP HEADER
        ===================================================== */

        .seller-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            margin-bottom: 28px;
        }


        .header-left {

            display: flex;

            align-items: center;

            gap: 16px;
        }


        .header-icon {

            width: 58px;

            height: 58px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 18px;

            background:
                linear-gradient(
                    135deg,
                    rgba(0,255,153,.18),
                    rgba(0,255,153,.05)
                );

            border: 1px solid rgba(0,255,153,.20);

            color: #00ff99;

            font-size: 23px;

            box-shadow:
                0 0 30px rgba(0,255,153,.08);
        }


        .seller-header h1 {

            font-size: 27px;

            font-weight: 800;

            color: #fff;

            letter-spacing: -.3px;
        }


        .seller-header h1 span {

            color: #00ff99;
        }


        .header-subtitle {

            margin-top: 4px;

            color: rgba(255,255,255,.42);

            font-size: 11px;
        }


        .back-btn {

            display: inline-flex;

            align-items: center;

            gap: 9px;

            padding: 12px 17px;

            border-radius: 13px;

            color: rgba(255,255,255,.75);

            background:
                rgba(255,255,255,.045);

            border: 1px solid rgba(255,255,255,.10);

            text-decoration: none;

            font-size: 12px;

            font-weight: 700;

            transition: .25s ease;
        }


        .back-btn:hover {

            color: #00ff99;

            border-color:
                rgba(0,255,153,.30);

            background:
                rgba(0,255,153,.07);

            transform: translateY(-2px);
        }


        /* =====================================================
           MAIN FORM CARD
        ===================================================== */

        .form-card {

            position: relative;

            overflow: hidden;

            width: 100%;

            padding: 32px;

            border-radius: 26px;

            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.075),
                    rgba(255,255,255,.025)
                );

            border: 1px solid rgba(255,255,255,.09);

            backdrop-filter: blur(22px);

            box-shadow:
                0 30px 80px rgba(0,0,0,.35),
                0 0 40px rgba(0,255,153,.035);
        }


        .form-card::before {

            content: "";

            position: absolute;

            width: 250px;

            height: 250px;

            top: -150px;

            right: -100px;

            border-radius: 50%;

            background: #00ff99;

            opacity: .035;

            filter: blur(30px);

            pointer-events: none;
        }


        /* =====================================================
           FORM SECTION HEADER
        ===================================================== */

        .form-section-header {

            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 25px;

            padding-bottom: 18px;

            border-bottom:
                1px solid rgba(255,255,255,.07);
        }


        .section-mini-icon {

            width: 38px;

            height: 38px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 12px;

            background:
                rgba(0,255,153,.08);

            color: #00ff99;

            font-size: 15px;
        }


        .form-section-header h2 {

            font-size: 16px;

            font-weight: 800;

            color: #fff;
        }


        .form-section-header p {

            margin-top: 2px;

            color: rgba(255,255,255,.38);

            font-size: 10px;
        }


        /* =====================================================
           ALERTS
        ===================================================== */

        .alert-success-custom,
        .alert-error-custom {

            padding: 14px 16px;

            border-radius: 14px;

            margin-bottom: 20px;

            font-size: 12px;

            font-weight: 600;
        }


        .alert-success-custom {

            color: #78ffc4;

            background:
                rgba(0,255,153,.08);

            border:
                1px solid rgba(0,255,153,.22);
        }


        .alert-error-custom {

            color: #ff8585;

            background:
                rgba(239,68,68,.08);

            border:
                1px solid rgba(239,68,68,.20);
        }


        .alert-error-custom div + div {

            margin-top: 7px;
        }


        /* =====================================================
           FORM
        ===================================================== */

        .form-group {

            margin-bottom: 4px;
        }


        .form-label {

            display: block;

            color: rgba(255,255,255,.72);

            font-size: 11px;

            font-weight: 700;

            margin-bottom: 8px;

            letter-spacing: .15px;
        }


        .required {

            color: #00ff99;
        }


        .form-control,
        .form-select {

            width: 100%;

            min-height: 48px;

            padding: 12px 15px;

            border-radius: 13px;

            background:
                rgba(255,255,255,.045);

            border:
                1px solid rgba(255,255,255,.10);

            color: #fff;

            outline: none;

            font-size: 12px;

            transition: .25s ease;

            box-shadow: none;
        }


        textarea.form-control {

            min-height: 120px;

            resize: vertical;
        }


        .form-control::placeholder {

            color: rgba(255,255,255,.25);
        }


        .form-control:hover,
        .form-select:hover {

            border-color:
                rgba(255,255,255,.18);

            background:
                rgba(255,255,255,.055);
        }


        .form-control:focus,
        .form-select:focus {

            background:
                rgba(0,255,153,.045);

            color: #fff;

            border-color:
                rgba(0,255,153,.55);

            box-shadow:
                0 0 0 3px rgba(0,255,153,.07),
                0 0 25px rgba(0,255,153,.05);
        }


        .form-select option {

            background: #0b1220;

            color: #fff;
        }


        /* =====================================================
           PRICE INPUT
        ===================================================== */

        .input-wrapper {

            position: relative;
        }


        .input-prefix {

            position: absolute;

            left: 14px;

            top: 50%;

            transform: translateY(-50%);

            color: #00ff99;

            font-size: 13px;

            font-weight: 800;

            z-index: 2;
        }


        .price-input {

            padding-left: 30px;
        }


        /* =====================================================
           UPLOAD ZONE
        ===================================================== */

        .upload-zone {

            position: relative;

            min-height: 190px;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            text-align: center;

            padding: 25px;

            border-radius: 18px;

            border:
                1px dashed rgba(0,255,153,.30);

            background:
                linear-gradient(
                    145deg,
                    rgba(0,255,153,.055),
                    rgba(255,255,255,.025)
                );

            cursor: pointer;

            transition: .3s ease;

            overflow: hidden;
        }


        .upload-zone::before {

            content: "";

            position: absolute;

            inset: 0;

            background:
                radial-gradient(
                    circle at center,
                    rgba(0,255,153,.08),
                    transparent 60%
                );

            opacity: 0;

            transition: .3s ease;
        }


        .upload-zone:hover {

            border-color: #00ff99;

            background:
                rgba(0,255,153,.075);

            transform: translateY(-2px);

            box-shadow:
                0 15px 35px rgba(0,255,153,.07);
        }


        .upload-zone:hover::before {

            opacity: 1;
        }


        .upload-icon {

            position: relative;

            z-index: 2;

            width: 58px;

            height: 58px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 17px;

            background:
                rgba(0,255,153,.09);

            color: #00ff99;

            font-size: 23px;

            margin-bottom: 12px;
        }


        .upload-title {

            position: relative;

            z-index: 2;

            color: #fff;

            font-size: 13px;

            font-weight: 700;
        }


        .upload-subtitle {

            position: relative;

            z-index: 2;

            margin-top: 5px;

            color: rgba(255,255,255,.35);

            font-size: 10px;
        }


        .image-preview {

            width: 100%;

            max-height: 280px;

            object-fit: cover;

            border-radius: 17px;

            margin-top: 14px;

            display: none;

            border:
                1px solid rgba(0,255,153,.25);

            box-shadow:
                0 15px 35px rgba(0,0,0,.30);
        }


        .image-preview.show {

            display: block;

            animation:
                previewShow .3s ease;
        }


        @keyframes previewShow {

            from {

                opacity: 0;

                transform: scale(.97);
            }

            to {

                opacity: 1;

                transform: scale(1);
            }

        }


        /* =====================================================
           EXTRA IMAGES
        ===================================================== */

        .extra-upload {

            width: 100%;

            padding: 13px;

            border-radius: 13px;

            background:
                rgba(255,255,255,.04);

            border:
                1px solid rgba(255,255,255,.09);

            color: rgba(255,255,255,.55);

            font-size: 11px;
        }


        .extra-upload::file-selector-button {

            border: none;

            border-radius: 9px;

            padding: 8px 12px;

            margin-right: 10px;

            background:
                rgba(0,255,153,.12);

            color: #00ff99;

            font-weight: 700;

            cursor: pointer;
        }


        .help-text {

            display: block;

            margin-top: 7px;

            color: rgba(255,255,255,.28);

            font-size: 9px;
        }


        /* =====================================================
           BOTTOM ACTIONS
        ===================================================== */

        .form-actions {

            margin-top: 28px;

            padding-top: 22px;

            border-top:
                1px solid rgba(255,255,255,.07);

            display: flex;

            gap: 12px;
        }


        .btn-submit {

            flex: 1;

            min-height: 52px;

            border: none;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    #00ff99,
                    #00d681
                );

            color: #020617;

            font-size: 13px;

            font-weight: 800;

            cursor: pointer;

            transition: .25s ease;

            box-shadow:
                0 10px 25px rgba(0,255,153,.10);
        }


        .btn-submit:hover {

            transform:
                translateY(-2px);

            box-shadow:
                0 15px 35px rgba(0,255,153,.25);
        }


        .btn-cancel {

            min-height: 52px;

            padding: 0 22px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            border-radius: 14px;

            text-decoration: none;

            background:
                rgba(255,255,255,.045);

            border:
                1px solid rgba(255,255,255,.10);

            color:
                rgba(255,255,255,.65);

            font-size: 12px;

            font-weight: 700;

            transition: .25s ease;
        }


        .btn-cancel:hover {

            color: #fff;

            background:
                rgba(255,255,255,.08);

            transform:
                translateY(-2px);
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media(max-width:768px) {

            .product-page {

                padding:
                    25px 15px 50px;
            }


            .seller-header {

                align-items: flex-start;
            }


            .header-icon {

                width: 48px;

                height: 48px;

                border-radius: 15px;
            }


            .seller-header h1 {

                font-size: 21px;
            }


            .header-subtitle {

                font-size: 9px;
            }


            .back-btn {

                padding: 10px 12px;

                font-size: 10px;
            }


            .form-card {

                padding: 22px 18px;

                border-radius: 21px;
            }

        }


        @media(max-width:550px) {

            .seller-header {

                flex-direction: column;
            }


            .back-btn {

                width: 100%;

                justify-content: center;
            }


            .header-left {

                width: 100%;
            }


            .form-actions {

                flex-direction: column;
            }


            .btn-cancel,
            .btn-submit {

                width: 100%;
            }


            .upload-zone {

                min-height: 170px;
            }

        }

    </style>

</head>


<body>


<div class="product-page">

    <div class="product-container">


        {{-- =================================================
             HEADER
        ================================================== --}}

        <div class="seller-header">

            <div class="header-left">

                <div class="header-icon">

                    <i class="fa-solid fa-box-open"></i>

                </div>

                <div>

                    <h1>
                        Add New <span>Product</span>
                    </h1>

                    <div class="header-subtitle">
                        Add a new product to your SMART BASKET store
                    </div>

                </div>

            </div>


            <a
                href="{{ route('seller.dashboard') }}"
                class="back-btn"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Dashboard

            </a>

        </div>



        {{-- =================================================
             FORM CARD
        ================================================== --}}

        <div class="form-card">


            {{-- ALERTS --}}

            @if(session('success'))

                <div class="alert-success-custom">

                    <i class="fa-solid fa-circle-check"></i>

                    {{ session('success') }}

                </div>

            @endif


            @if(session('error'))

                <div class="alert-error-custom">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    {{ session('error') }}

                </div>

            @endif


            @if ($errors->any())

                <div class="alert-error-custom">

                    @foreach($errors->all() as $error)

                        <div>

                            <i class="fa-solid fa-triangle-exclamation"></i>

                            {{ $error }}

                        </div>

                    @endforeach

                </div>

            @endif



            {{-- FORM SECTION TITLE --}}

            <div class="form-section-header">

                <div class="section-mini-icon">

                    <i class="fa-solid fa-pen-to-square"></i>

                </div>

                <div>

                    <h2>
                        Product Information
                    </h2>

                    <p>
                        Enter the details of the product you want to sell
                    </p>

                </div>

            </div>



            {{-- =================================================
                 FORM
            ================================================== --}}

            <form
                method="POST"
                action="{{ route('seller.product.store') }}"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="row g-3">


                    {{-- PRODUCT NAME --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Product Name

                            <span class="required">*</span>

                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Enter product name"
                            value="{{ old('name') }}"
                            required
                        >

                    </div>



                    {{-- CATEGORY --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Category

                            <span class="required">*</span>

                        </label>

                        <input
                            type="text"
                            name="category"
                            class="form-control"
                            placeholder="e.g. Electronics, Fashion"
                            value="{{ old('category') }}"
                            required
                        >

                    </div>



                    {{-- BRAND --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Brand

                        </label>

                        <input
                            type="text"
                            name="brand"
                            class="form-control"
                            placeholder="e.g. Samsung, Nike"
                            value="{{ old('brand') }}"
                        >

                    </div>



                    {{-- PRICE --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Price

                            <span class="required">*</span>

                        </label>

                        <div class="input-wrapper">

                            <span class="input-prefix">
                                ₹
                            </span>

                            <input
                                type="number"
                                name="price"
                                class="form-control price-input"
                                placeholder="0.00"
                                step="0.01"
                                min="0"
                                value="{{ old('price') }}"
                                required
                            >

                        </div>

                    </div>



                    {{-- DISCOUNT PRICE --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Discount Price

                        </label>

                        <div class="input-wrapper">

                            <span class="input-prefix">
                                ₹
                            </span>

                            <input
                                type="number"
                                name="discount_price"
                                class="form-control price-input"
                                placeholder="0.00"
                                step="0.01"
                                min="0"
                                value="{{ old('discount_price') }}"
                            >

                        </div>

                    </div>



                    {{-- STOCK --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Stock Quantity

                            <span class="required">*</span>

                        </label>

                        <input
                            type="number"
                            name="stock"
                            class="form-control"
                            placeholder="Enter available quantity"
                            min="0"
                            value="{{ old('stock') }}"
                            required
                        >

                    </div>



                    {{-- SIZE --}}

                    <div class="col-md-4">

                        <label class="form-label">

                            Size

                        </label>

                        <input
                            type="text"
                            name="size"
                            class="form-control"
                            placeholder="S, M, L, XL"
                            value="{{ old('size') }}"
                        >

                    </div>



                    {{-- COLOR --}}

                    <div class="col-md-4">

                        <label class="form-label">

                            Color

                        </label>

                        <input
                            type="text"
                            name="color"
                            class="form-control"
                            placeholder="Black, Red, Blue"
                            value="{{ old('color') }}"
                        >

                    </div>



                    {{-- STATUS --}}

                    <div class="col-md-4">

                        <label class="form-label">

                            Product Status

                        </label>

                        <select
                            name="status"
                            class="form-select"
                        >

                            <option
                                value="active"
                                {{ old('status','active') === 'active' ? 'selected' : '' }}
                            >
                                Active
                            </option>

                            <option
                                value="inactive"
                                {{ old('status') === 'inactive' ? 'selected' : '' }}
                            >
                                Inactive
                            </option>

                        </select>

                    </div>



                    {{-- DESCRIPTION --}}

                    <div class="col-12">

                        <label class="form-label">

                            Product Description

                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="4"
                            placeholder="Describe your product, features, specifications..."
                        >{{ old('description') }}</textarea>

                    </div>



                    {{-- =================================================
                         MAIN IMAGE
                    ================================================== --}}

                    <div class="col-12">

                        <label class="form-label">

                            Product Main Image

                            <span class="required">*</span>

                        </label>


                        <div
                            class="upload-zone"
                            onclick="document.getElementById('imageInput').click()"
                            id="uploadZone"
                        >

                            <div class="upload-icon">

                                <i class="fa-solid fa-cloud-arrow-up"></i>

                            </div>


                            <div class="upload-title">

                                Click to upload product image

                            </div>


                            <div class="upload-subtitle">

                                JPEG, PNG, JPG or WEBP • Maximum 2MB

                            </div>

                        </div>


                        <input
                            type="file"
                            name="image"
                            id="imageInput"
                            class="d-none"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            required
                            onchange="previewImage(this)"
                        >


                        <img
                            id="imagePreview"
                            class="image-preview"
                            src=""
                            alt="Product Preview"
                        >

                    </div>



                    {{-- =================================================
                         EXTRA IMAGES
                    ================================================== --}}

                    <div class="col-12">

                        <label class="form-label">

                            Additional Product Images

                        </label>


                        <input
                            type="file"
                            name="images[]"
                            class="extra-upload"
                            multiple
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                        >


                        <small class="help-text">

                            Optional — upload up to 8 extra product views
                            such as front, back, side and detail images.

                        </small>

                    </div>



                    {{-- =================================================
                         ACTIONS
                    ================================================== --}}

                    <div class="col-12">

                        <div class="form-actions">


                            <a
                                href="{{ route('seller.dashboard') }}"
                                class="btn-cancel"
                            >

                                <i class="fa-solid fa-xmark"></i>

                                Cancel

                            </a>


                            <button
                                type="submit"
                                class="btn-submit"
                            >

                                <i class="fa-solid fa-plus"></i>

                                ADD PRODUCT

                            </button>


                        </div>

                    </div>


                </div>

            </form>

        </div>

    </div>

</div>



<script>

function previewImage(input) {

    const preview =
        document.getElementById('imagePreview');

    const uploadZone =
        document.getElementById('uploadZone');


    if (
        input.files &&
        input.files[0]
    ) {

        const file =
            input.files[0];


        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/jpg',
            'image/webp'
        ];


        if (!allowedTypes.includes(file.type)) {

            alert(
                'Please select a valid image: JPG, JPEG, PNG or WEBP.'
            );

            input.value = '';

            return;
        }


        if (file.size > 2 * 1024 * 1024) {

            alert(
                'Image size must be less than 2MB.'
            );

            input.value = '';

            return;
        }


        const reader =
            new FileReader();


        reader.onload =
            function (event) {

                preview.src =
                    event.target.result;

                preview.classList.add('show');


                uploadZone.style.borderColor =
                    'rgba(0,255,153,.55)';

            };


        reader.readAsDataURL(file);

    }

}

</script>


</body>

</html>