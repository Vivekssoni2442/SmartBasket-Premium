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
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet"
    >

    <style>

        /* =========================================================
           SMART BASKET
           PREMIUM LIGHT SELLER — ADD PRODUCT
        ========================================================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {

            --primary: #00c878;
            --primary-dark: #009f60;
            --primary-soft: #e9fff5;

            --bg: #f5f8f7;
            --bg-secondary: #eef4f1;

            --card: rgba(255,255,255,.94);
            --card-solid: #ffffff;

            --text: #14211b;
            --text-secondary: #52635b;
            --muted: #82918b;

            --border: #e1eae6;
            --border-soft: #edf2ef;

            --input: #fbfdfc;

            --danger: #e05252;
            --danger-bg: #fff3f3;

            --shadow:
                0 22px 60px rgba(22, 49, 38, .08);

            --shadow-soft:
                0 10px 30px rgba(22, 49, 38, .06);

            --radius-xl: 28px;
            --radius-lg: 20px;
            --radius-md: 14px;

            --transition: .25s ease;
        }


        /* =========================================================
           BODY
        ========================================================= */

        html {
            scroll-behavior: smooth;
        }

        body {

            min-height: 100vh;

            font-family: 'Inter', sans-serif;

            color: var(--text);

            background:

                radial-gradient(
                    circle at 0% 0%,
                    rgba(0,200,120,.10),
                    transparent 27%
                ),

                radial-gradient(
                    circle at 100% 5%,
                    rgba(57,189,255,.08),
                    transparent 25%
                ),

                linear-gradient(
                    180deg,
                    #f9fcfa 0%,
                    #f3f7f5 100%
                );

            overflow-x: hidden;
        }


        /* =========================================================
           BACKGROUND DECORATION
        ========================================================= */

        body::before {

            content: "";

            position: fixed;

            width: 380px;
            height: 380px;

            top: -180px;
            left: -150px;

            border-radius: 50%;

            background:
                rgba(0,200,120,.07);

            filter: blur(90px);

            pointer-events: none;

            z-index: 0;
        }

        body::after {

            content: "";

            position: fixed;

            width: 420px;
            height: 420px;

            right: -200px;
            bottom: -200px;

            border-radius: 50%;

            background:
                rgba(0,200,120,.055);

            filter: blur(100px);

            pointer-events: none;

            z-index: 0;
        }


        /* =========================================================
           PAGE
        ========================================================= */

        .product-page {

            width: 100%;

            min-height: 100vh;

            padding:
                34px 24px 70px;

            position: relative;

            z-index: 1;
        }

        .product-container {

            width: 100%;

            max-width: 1120px;

            margin: auto;
        }


        /* =========================================================
           HEADER
        ========================================================= */

        .seller-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            margin-bottom: 25px;

            padding:
                17px 19px;

            background:
                rgba(255,255,255,.84);

            border:
                1px solid var(--border);

            border-radius:
                20px;

            box-shadow:
                var(--shadow-soft);

            backdrop-filter:
                blur(18px);
        }


        .header-left {

            display: flex;

            align-items: center;

            gap: 14px;
        }


        .header-icon {

            width: 52px;
            height: 52px;

            flex-shrink: 0;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 16px;

            background:
                linear-gradient(
                    135deg,
                    #00d986,
                    #00b86e
                );

            color: white;

            font-size: 20px;

            box-shadow:
                0 10px 25px rgba(0,200,120,.20);
        }


        .seller-header h1 {

            font-size: 21px;

            font-weight: 800;

            color: var(--text);

            letter-spacing: -.4px;
        }


        .seller-header h1 span {

            color:
                var(--primary);
        }


        .header-subtitle {

            margin-top: 3px;

            color:
                var(--muted);

            font-size: 11px;

            font-weight: 500;
        }


        .back-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            min-height: 42px;

            padding:
                0 15px;

            border-radius:
                12px;

            color:
                var(--text-secondary);

            background:
                #ffffff;

            border:
                1px solid var(--border);

            text-decoration: none;

            font-size: 12px;

            font-weight: 700;

            transition:
                var(--transition);

            box-shadow:
                0 5px 15px rgba(22,49,38,.04);
        }


        .back-btn:hover {

            color:
                var(--primary-dark);

            border-color:
                rgba(0,200,120,.35);

            background:
                var(--primary-soft);

            transform:
                translateY(-2px);

            box-shadow:
                0 10px 25px rgba(0,200,120,.10);
        }


        /* =========================================================
           PAGE INTRO
        ========================================================= */

        .page-intro {

            margin:
                0 4px 20px;
        }


        .page-intro h2 {

            font-size: 28px;

            font-weight: 800;

            letter-spacing: -.8px;

            color: var(--text);
        }


        .page-intro h2 i {

            color:
                var(--primary);

            margin-right: 8px;
        }


        .page-intro p {

            margin-top: 5px;

            color:
                var(--text-secondary);

            font-size: 13px;
        }


        .intro-badge {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            margin-top: 12px;

            padding:
                7px 11px;

            border-radius:
                999px;

            background:
                var(--primary-soft);

            border:
                1px solid #ccefe1;

            color:
                var(--primary-dark);

            font-size: 10px;

            font-weight: 800;

            letter-spacing: .2px;
        }


        /* =========================================================
           FORM CARD
        ========================================================= */

        .form-card {

            position: relative;

            overflow: hidden;

            width: 100%;

            padding: 31px;

            background:
                rgba(255,255,255,.94);

            border:
                1px solid var(--border);

            border-radius:
                var(--radius-xl);

            box-shadow:
                var(--shadow);

            backdrop-filter:
                blur(22px);
        }


        .form-card::before {

            content: "";

            position: absolute;

            width: 320px;
            height: 320px;

            top: -230px;
            right: -130px;

            border-radius: 50%;

            background:
                rgba(0,200,120,.075);

            filter: blur(35px);

            pointer-events: none;
        }


        .form-card::after {

            content: "";

            position: absolute;

            width: 250px;
            height: 250px;

            bottom: -190px;
            left: -120px;

            border-radius: 50%;

            background:
                rgba(0,200,120,.035);

            filter: blur(40px);

            pointer-events: none;
        }


        /* =========================================================
           SECTION HEADER
        ========================================================= */

        .form-section-header {

            position: relative;

            z-index: 2;

            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 25px;

            padding-bottom: 17px;

            border-bottom:
                1px solid var(--border-soft);
        }


        .section-mini-icon {

            width: 39px;
            height: 39px;

            display: flex;

            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 12px;

            background:
                var(--primary-soft);

            color:
                var(--primary-dark);

            border:
                1px solid #d4f3e5;

            font-size: 14px;
        }


        .form-section-header h2 {

            font-size: 16px;

            font-weight: 800;

            color:
                var(--text);
        }


        .form-section-header p {

            margin-top: 3px;

            color:
                var(--muted);

            font-size: 10px;

            font-weight: 500;
        }


        /* =========================================================
           ALERTS
        ========================================================= */

        .alert-success-custom,
        .alert-error-custom {

            position: relative;

            z-index: 5;

            padding:
                14px 16px;

            border-radius:
                14px;

            margin-bottom:
                20px;

            font-size:
                12px;

            font-weight:
                600;

            display:
                flex;

            align-items:
                flex-start;

            gap: 9px;
        }


        .alert-success-custom {

            color:
                #08794d;

            background:
                #edfff7;

            border:
                1px solid #c9f2df;
        }


        .alert-error-custom {

            color:
                #b42323;

            background:
                var(--danger-bg);

            border:
                1px solid #f4cccc;
        }


        .alert-error-custom div + div {

            margin-top:
                7px;
        }


        /* =========================================================
           FORM
        ========================================================= */

        .form-content {

            position:
                relative;

            z-index:
                2;
        }


        .form-label {

            display:
                block;

            color:
                #34443d;

            font-size:
                11px;

            font-weight:
                800;

            margin-bottom:
                8px;

            letter-spacing:
                .1px;
        }


        .required {

            color:
                #e05252;

            margin-left:
                2px;
        }


        /* =========================================================
           INPUTS
        ========================================================= */

        .form-control,
        .form-select {

            width:
                100%;

            min-height:
                49px;

            padding:
                12px 14px;

            border-radius:
                13px;

            background:
                var(--input);

            border:
                1px solid #dce6e1;

            color:
                var(--text);

            outline:
                none;

            font-family:
                'Inter', sans-serif;

            font-size:
                12px;

            font-weight:
                500;

            transition:
                all .22s ease;

            box-shadow:
                inset 0 1px 2px rgba(20,33,27,.02);
        }


        .form-control::placeholder {

            color:
                #a1ada7;
        }


        .form-control:hover,
        .form-select:hover {

            border-color:
                #c4d5ce;

            background:
                #ffffff;

            box-shadow:
                0 5px 15px rgba(22,49,38,.035);
        }


        .form-control:focus,
        .form-select:focus {

            border-color:
                var(--primary);

            background:
                #ffffff;

            color:
                var(--text);

            box-shadow:
                0 0 0 3px rgba(0,200,120,.10),
                0 8px 24px rgba(0,200,120,.07);
        }


        .form-select {

            cursor:
                pointer;
        }


        .form-select option {

            background:
                #ffffff;

            color:
                var(--text);
        }


        textarea.form-control {

            min-height:
                125px;

            resize:
                vertical;

            line-height:
                1.6;
        }


        /* =========================================================
           PRICE INPUT
        ========================================================= */

        .input-wrapper {

            position:
                relative;
        }


        .input-prefix {

            position:
                absolute;

            left:
                14px;

            top:
                50%;

            transform:
                translateY(-50%);

            color:
                var(--primary-dark);

            font-size:
                13px;

            font-weight:
                800;

            z-index:
                2;

            pointer-events:
                none;
        }


        .price-input {

            padding-left:
                31px !important;
        }


        /* =========================================================
           UPLOAD ZONE
        ========================================================= */

        .upload-zone {

            position:
                relative;

            min-height:
                205px;

            display:
                flex;

            flex-direction:
                column;

            align-items:
                center;

            justify-content:
                center;

            text-align:
                center;

            padding:
                25px;

            border-radius:
                20px;

            border:
                1.5px dashed #b7dfcf;

            background:
                linear-gradient(
                    145deg,
                    #f3fff9,
                    #fbfdfc
                );

            cursor:
                pointer;

            transition:
                all .3s ease;

            overflow:
                hidden;
        }


        .upload-zone::before {

            content:
                "";

            position:
                absolute;

            inset:
                0;

            background:
                radial-gradient(
                    circle at center,
                    rgba(0,200,120,.10),
                    transparent 60%
                );

            opacity:
                0;

            transition:
                .3s ease;
        }


        .upload-zone:hover {

            border-color:
                var(--primary);

            background:
                #f0fff8;

            transform:
                translateY(-2px);

            box-shadow:
                0 16px 35px rgba(0,200,120,.10);
        }


        .upload-zone:hover::before {

            opacity:
                1;
        }


        .upload-icon {

            position:
                relative;

            z-index:
                2;

            width:
                60px;

            height:
                60px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border-radius:
                18px;

            background:
                linear-gradient(
                    145deg,
                    #e4fff2,
                    #f5fffa
                );

            border:
                1px solid #ccefe0;

            color:
                var(--primary-dark);

            font-size:
                22px;

            margin-bottom:
                12px;

            box-shadow:
                0 8px 20px rgba(0,200,120,.08);
        }


        .upload-title {

            position:
                relative;

            z-index:
                2;

            color:
                var(--text);

            font-size:
                13px;

            font-weight:
                800;
        }


        .upload-subtitle {

            position:
                relative;

            z-index:
                2;

            margin-top:
                6px;

            color:
                var(--muted);

            font-size:
                10px;

            font-weight:
                500;
        }


        /* =========================================================
           IMAGE PREVIEW
        ========================================================= */

        .preview-wrapper {

            margin-top:
                14px;

            display:
                none;

            padding:
                10px;

            background:
                #ffffff;

            border:
                1px solid var(--border);

            border-radius:
                17px;

            box-shadow:
                var(--shadow-soft);
        }


        .preview-wrapper.show {

            display:
                block;

            animation:
                previewShow .3s ease;
        }


        .image-preview {

            width:
                100%;

            max-height:
                310px;

            object-fit:
                contain;

            border-radius:
                12px;

            display:
                block;

            background:
                #f7faf8;
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


        /* =========================================================
           EXTRA UPLOAD
        ========================================================= */

        .extra-upload {

            width:
                100%;

            padding:
                12px;

            border-radius:
                13px;

            background:
                #fbfdfc;

            border:
                1px solid #dce6e1;

            color:
                var(--text-secondary);

            font-family:
                'Inter', sans-serif;

            font-size:
                11px;

            cursor:
                pointer;

            transition:
                .2s ease;
        }


        .extra-upload:hover {

            border-color:
                #bfd6cc;

            background:
                #ffffff;
        }


        .extra-upload::file-selector-button {

            border:
                1px solid #c9ecdd;

            border-radius:
                9px;

            padding:
                8px 12px;

            margin-right:
                10px;

            background:
                var(--primary-soft);

            color:
                var(--primary-dark);

            font-weight:
                800;

            cursor:
                pointer;

            transition:
                .2s ease;
        }


        .extra-upload::file-selector-button:hover {

            background:
                #d9faea;
        }


        .help-text {

            display:
                block;

            margin-top:
                7px;

            color:
                var(--muted);

            font-size:
                9px;

            line-height:
                1.5;
        }


        /* =========================================================
           FORM ACTIONS
        ========================================================= */

        .form-actions {

            margin-top:
                28px;

            padding-top:
                22px;

            border-top:
                1px solid var(--border-soft);

            display:
                flex;

            gap:
                12px;
        }


        .btn-submit {

            flex:
                1;

            min-height:
                52px;

            border:
                none;

            border-radius:
                14px;

            background:
                linear-gradient(
                    135deg,
                    #00d986,
                    #00b96f
                );

            color:
                #ffffff;

            font-size:
                12px;

            font-weight:
                900;

            letter-spacing:
                .3px;

            cursor:
                pointer;

            transition:
                .25s ease;

            box-shadow:
                0 12px 28px rgba(0,200,120,.18);
        }


        .btn-submit:hover {

            transform:
                translateY(-2px);

            box-shadow:
                0 17px 38px rgba(0,200,120,.26);

            background:
                linear-gradient(
                    135deg,
                    #00e38c,
                    #00c477
                );
        }


        .btn-submit:active {

            transform:
                translateY(0);
        }


        .btn-cancel {

            min-height:
                52px;

            padding:
                0 23px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                8px;

            border-radius:
                14px;

            text-decoration:
                none;

            background:
                #ffffff;

            border:
                1px solid #dce6e1;

            color:
                var(--text-secondary);

            font-size:
                12px;

            font-weight:
                800;

            transition:
                .25s ease;

            box-shadow:
                0 5px 15px rgba(22,49,38,.035);
        }


        .btn-cancel:hover {

            color:
                #b23a3a;

            background:
                #fff7f7;

            border-color:
                #f0caca;

            transform:
                translateY(-2px);

            box-shadow:
                0 10px 25px rgba(180,60,60,.08);
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .page-footer {

            text-align:
                center;

            margin-top:
                20px;

            color:
                #96a39d;

            font-size:
                10px;

            font-weight:
                500;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 768px) {

            .product-page {

                padding:
                    20px 13px 45px;
            }


            .seller-header {

                padding:
                    14px;

                border-radius:
                    17px;
            }


            .header-icon {

                width:
                    45px;

                height:
                    45px;

                border-radius:
                    13px;

                font-size:
                    17px;
            }


            .seller-header h1 {

                font-size:
                    17px;
            }


            .header-subtitle {

                font-size:
                    9px;
            }


            .back-btn {

                min-height:
                    40px;

                padding:
                    0 12px;

                font-size:
                    10px;
            }


            .page-intro h2 {

                font-size:
                    23px;
            }


            .page-intro p {

                font-size:
                    11px;
            }


            .form-card {

                padding:
                    21px 17px;

                border-radius:
                    21px;
            }


            .upload-zone {

                min-height:
                    180px;
            }

        }


        @media (max-width: 560px) {

            .seller-header {

                align-items:
                    flex-start;
            }


            .header-left {

                width:
                    100%;
            }


            .back-btn {

                padding:
                    0 11px;
            }


            .back-btn span {

                display:
                    none;
            }


            .form-actions {

                flex-direction:
                    column-reverse;
            }


            .btn-cancel,
            .btn-submit {

                width:
                    100%;
            }


            .btn-cancel {

                padding:
                    0 15px;
            }


            .upload-zone {

                min-height:
                    165px;
            }

        }


    </style>

</head>


<body>


<div class="product-page">

    <div class="product-container">


        {{-- =====================================================
             TOP HEADER
        ====================================================== --}}

        <div class="seller-header">

            <div class="header-left">

                <div class="header-icon">

                    <i class="fa-solid fa-basket-shopping"></i>

                </div>

                <div>

                    <h1>
                        SMART BASKET
                        <span>Seller</span>
                    </h1>

                    <div class="header-subtitle">
                        Seller Partner Panel • Product Management
                    </div>

                </div>

            </div>


            <a
                href="{{ route('seller.dashboard') }}"
                class="back-btn"
            >

                <i class="fa-solid fa-arrow-left"></i>

                <span>Dashboard</span>

            </a>

        </div>



        {{-- =====================================================
             PAGE INTRO
        ====================================================== --}}

        <div class="page-intro">

            <h2>

                <i class="fa-solid fa-box-open"></i>

                Add New Product

            </h2>

            <p>
                Create a professional product listing for your SMART BASKET store.
            </p>

            <div class="intro-badge">

                <i class="fa-solid fa-shield-check"></i>

                Seller Product Center

            </div>

        </div>



        {{-- =====================================================
             MAIN CARD
        ====================================================== --}}

        <div class="form-card">


            {{-- =================================================
                 ALERTS
            ================================================== --}}

            @if(session('success'))

                <div class="alert-success-custom">

                    <i class="fa-solid fa-circle-check"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            @if(session('error'))

                <div class="alert-error-custom">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif


            @if ($errors->any())

                <div class="alert-error-custom">

                    <div>

                        <i class="fa-solid fa-triangle-exclamation"></i>

                        <strong>
                            Please fix the following:
                        </strong>

                    </div>

                    <div>

                        @foreach($errors->all() as $error)

                            <div>
                                • {{ $error }}
                            </div>

                        @endforeach

                    </div>

                </div>

            @endif



            {{-- =================================================
                 SECTION HEADER
            ================================================== --}}

            <div class="form-section-header">

                <div class="section-mini-icon">

                    <i class="fa-solid fa-pen-to-square"></i>

                </div>

                <div>

                    <h2>
                        Product Information
                    </h2>

                    <p>
                        Add complete details so customers can understand your product
                    </p>

                </div>

            </div>



            <div class="form-content">


                {{-- =================================================
                     FORM
                ================================================== --}}

                <form
                    method="POST"
                    action="{{ route('seller.product.store') }}"
                    enctype="multipart/form-data"
                >

                    @csrf


                    <div class="row g-4">


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

                                    JPG • JPEG • PNG • WEBP
                                    &nbsp;·&nbsp;
                                    Maximum 2MB

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


                            <div
                                id="previewWrapper"
                                class="preview-wrapper"
                            >

                                <img
                                    id="imagePreview"
                                    class="image-preview"
                                    src=""
                                    alt="Product Preview"
                                >

                            </div>

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

                                Optional — upload up to 8 additional product
                                views such as front, back, side and detail images.

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


        <div class="page-footer">

            SMART BASKET • Seller Partner Panel

        </div>


    </div>

</div>



<script>

function previewImage(input) {

    const preview =
        document.getElementById('imagePreview');

    const previewWrapper =
        document.getElementById('previewWrapper');

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


        /* FILE TYPE */

        if (!allowedTypes.includes(file.type)) {

            alert(
                'Please select a valid image: JPG, JPEG, PNG or WEBP.'
            );

            input.value = '';

            previewWrapper.classList.remove('show');

            return;
        }


        /* FILE SIZE */

        if (file.size > 2 * 1024 * 1024) {

            alert(
                'Image size must be less than 2MB.'
            );

            input.value = '';

            previewWrapper.classList.remove('show');

            return;
        }


        /* PREVIEW */

        const reader =
            new FileReader();


        reader.onload =
            function(event) {

                preview.src =
                    event.target.result;

                previewWrapper.classList.add('show');


                uploadZone.style.borderColor =
                    'rgba(0,200,120,.60)';

                uploadZone.style.background =
                    '#f0fff8';

            };


        reader.readAsDataURL(file);

    }

}

</script>


</body>

    @include('seller.partials.seller-menu')

</html>