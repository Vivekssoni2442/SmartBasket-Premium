<div class="ai-panel-fragment ai-budget-premium">

    <style>
        /* =========================================================
           SMART BASKET — AI BUDGET SHOPPING
           STRICT SAME SIZE PRODUCT CARDS
        ========================================================= */

        .ai-budget-premium {
            width: 100%;
            box-sizing: border-box;
        }

        .ai-budget-premium *,
        .ai-budget-premium *::before,
        .ai-budget-premium *::after {
            box-sizing: border-box;
        }

        /* HEADER */
        .ai-budget-premium .budget-top {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 4px;
        }

        .ai-budget-premium .budget-icon {
            width: 38px;
            height: 38px;
            min-width: 38px;
            max-width: 38px;
            min-height: 38px;
            max-height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;
            background: rgba(34, 197, 94, .12);
            border: 1px solid rgba(74, 222, 128, .20);

            font-size: 17px;
        }

        .ai-budget-premium .budget-title {
            margin: 0;
            padding: 0;

            font-size: 16px;
            line-height: 20px;
            font-weight: 800;

            color: #ffffff;
        }

        .ai-budget-premium .budget-description {
            margin: 0 0 13px 48px;
            color: #94a3b8;
            font-size: 11px;
            line-height: 16px;
        }

        /* =========================================================
           SEARCH BOX
        ========================================================= */

        .ai-budget-premium .budget-form {
            width: 100%;
            padding: 10px;

            margin: 0 0 13px 0;

            border-radius: 13px;

            background: rgba(255, 255, 255, .035);
            border: 1px solid rgba(255, 255, 255, .075);
        }

        .ai-budget-premium .budget-input {
            display: flex;

            width: 100%;
            height: 38px;

            margin-bottom: 7px;
        }

        .ai-budget-premium .currency {
            width: 38px;
            min-width: 38px;
            max-width: 38px;

            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px 0 0 9px;

            color: #86efac;
            background: rgba(34, 197, 94, .10);

            border: 1px solid rgba(74, 222, 128, .18);
            border-right: 0;

            font-size: 13px;
            font-weight: 800;
        }

        .ai-budget-premium #ai-budget {
            width: calc(100% - 38px);
            height: 38px;

            margin: 0;
            padding: 0 10px;

            border-radius: 0 9px 9px 0;

            border: 1px solid rgba(255, 255, 255, .09);

            background: rgba(15, 23, 42, .75);

            color: #ffffff;

            font-size: 12px;
            outline: none;
        }

        .ai-budget-premium #ai-budget:focus {
            border-color: rgba(74, 222, 128, .40);
            box-shadow: none;
        }

        .ai-budget-premium .budget-button {
            width: 100%;
            height: 36px;

            padding: 0 10px;

            border: 0;
            border-radius: 9px;

            color: #ffffff;

            background: linear-gradient(
                135deg,
                #22c55e,
                #10b981
            );

            font-size: 11px;
            font-weight: 800;

            cursor: pointer;
        }

        /* =========================================================
           RESULT TITLE
        ========================================================= */

        .ai-budget-premium .budget-result {
            display: flex;
            align-items: center;
            justify-content: space-between;

            width: 100%;
            height: 34px;

            padding: 0 9px;

            margin-bottom: 8px;

            border-radius: 9px;

            background: rgba(34, 197, 94, .045);
            border: 1px solid rgba(74, 222, 128, .10);

            overflow: hidden;
        }

        .ai-budget-premium .budget-result-text {
            min-width: 0;

            color: #cbd5e1;

            font-size: 10px;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ai-budget-premium .budget-result-text strong {
            color: #86efac;
            font-weight: 800;
        }

        .ai-budget-premium .budget-result-count {
            flex-shrink: 0;

            margin-left: 6px;

            color: #64748b;

            font-size: 9px;
            font-weight: 700;
        }

        /* =========================================================
           PRODUCT LIST
        ========================================================= */

        .ai-budget-premium .budget-products {
            display: flex;
            flex-direction: column;

            width: 100%;

            gap: 7px;

            margin: 0;
            padding: 0;
        }

        /* =========================================================
           🔥 EVERY CARD EXACTLY SAME SIZE
        ========================================================= */

        .ai-budget-premium .budget-card {
            display: flex;
            align-items: center;

            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;

            height: 72px !important;
            min-height: 72px !important;
            max-height: 72px !important;

            flex: 0 0 72px !important;

            padding: 6px !important;
            margin: 0 !important;

            gap: 8px;

            border-radius: 11px;

            background: rgba(255, 255, 255, .045);

            border: 1px solid rgba(255, 255, 255, .075);

            text-decoration: none;

            overflow: hidden !important;

            transition: all .18s ease;
        }

        .ai-budget-premium .budget-card:hover {
            transform: translateY(-1px);

            background: rgba(34, 197, 94, .065);

            border-color: rgba(74, 222, 128, .22);
        }

        /* =========================================================
           🔥 IMAGE EXACT SAME SIZE
        ========================================================= */

        .ai-budget-premium .budget-image {
            width: 58px !important;
            min-width: 58px !important;
            max-width: 58px !important;

            height: 58px !important;
            min-height: 58px !important;
            max-height: 58px !important;

            flex: 0 0 58px !important;

            position: relative;

            display: block;

            overflow: hidden !important;

            border-radius: 8px;

            background: #ffffff;

            border: 1px solid rgba(255, 255, 255, .10);
        }

        .ai-budget-premium .budget-image img {
            position: absolute !important;

            top: 0 !important;
            left: 0 !important;

            width: 58px !important;
            min-width: 58px !important;
            max-width: 58px !important;

            height: 58px !important;
            min-height: 58px !important;
            max-height: 58px !important;

            display: block !important;

            margin: 0 !important;
            padding: 0 !important;

            border: 0 !important;

            object-fit: cover !important;
            object-position: center center !important;

            transform: none !important;
        }

        /* =========================================================
           PRODUCT INFORMATION
        ========================================================= */

        .ai-budget-premium .budget-info {
            width: calc(100% - 128px);

            min-width: 0;
            max-width: calc(100% - 128px);

            height: 58px;
            min-height: 58px;
            max-height: 58px;

            flex: 1 1 auto;

            display: flex;
            flex-direction: column;
            justify-content: center;

            overflow: hidden;
        }

        .ai-budget-premium .budget-name {
            width: 100%;
            max-width: 100%;

            height: 17px;
            min-height: 17px;
            max-height: 17px;

            margin: 0 0 2px 0;

            color: #f8fafc;

            font-size: 11px;
            line-height: 17px;
            font-weight: 700;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ai-budget-premium .budget-category {
            width: 100%;
            max-width: 100%;

            height: 14px;
            min-height: 14px;
            max-height: 14px;

            margin: 0;

            color: #64748b;

            font-size: 9px;
            line-height: 14px;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* =========================================================
           PRICE AREA — FIXED SIZE
        ========================================================= */

        .ai-budget-premium .budget-price {
            width: 62px !important;
            min-width: 62px !important;
            max-width: 62px !important;

            height: 58px !important;
            min-height: 58px !important;
            max-height: 58px !important;

            flex: 0 0 62px !important;

            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: center;

            overflow: hidden;
        }

        .ai-budget-premium .budget-price strong {
            display: block;

            width: 100%;

            color: #86efac;

            font-size: 10px;
            line-height: 15px;

            font-weight: 800;

            text-align: right;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ai-budget-premium .budget-price small {
            display: block;

            color: #475569;

            font-size: 8px;
            line-height: 12px;

            white-space: nowrap;
        }

        /* =========================================================
           EMPTY
        ========================================================= */

        .ai-budget-premium .budget-empty {
            width: 100%;
            height: 110px;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            background: rgba(255, 255, 255, .035);

            border: 1px dashed rgba(255, 255, 255, .10);
        }

        .ai-budget-premium .budget-empty i {
            margin-bottom: 7px;

            color: #fbbf24;

            font-size: 20px;
        }

        .ai-budget-premium .budget-empty strong {
            color: #cbd5e1;

            font-size: 11px;
        }

        .ai-budget-premium .budget-empty span {
            margin-top: 3px;

            color: #64748b;

            font-size: 9px;
        }

        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 420px) {

            .ai-budget-premium .budget-card {
                height: 68px !important;
                min-height: 68px !important;
                max-height: 68px !important;
                flex-basis: 68px !important;
            }

            .ai-budget-premium .budget-image {
                width: 54px !important;
                min-width: 54px !important;
                max-width: 54px !important;

                height: 54px !important;
                min-height: 54px !important;
                max-height: 54px !important;

                flex-basis: 54px !important;
            }

            .ai-budget-premium .budget-image img {
                width: 54px !important;
                height: 54px !important;

                min-width: 54px !important;
                max-width: 54px !important;

                min-height: 54px !important;
                max-height: 54px !important;
            }

            .ai-budget-premium .budget-info {
                height: 54px;
                min-height: 54px;
                max-height: 54px;
            }

            .ai-budget-premium .budget-price {
                height: 54px !important;
                min-height: 54px !important;
                max-height: 54px !important;
            }
        }
    </style>


    {{-- =========================================================
         HEADER
    ========================================================= --}}

    <div class="budget-top">

        <div class="budget-icon">
            💰
        </div>

        <h2 class="budget-title">
            Budget Shopping
        </h2>

    </div>

    <p class="budget-description">
        Find the best products within your budget.
    </p>


    {{-- =========================================================
         BUDGET FORM
    ========================================================= --}}

    <form
        action="{{ route('budget-shopping') }}"
        method="GET"
        data-ai-hub-form
        class="budget-form"
    >

        <div class="budget-input">

            <span class="currency">
                ₹
            </span>

            <input
                id="ai-budget"
                type="number"
                name="budget"
                min="0"
                step="0.01"
                value="{{ $budget }}"
                placeholder="Enter your budget"
                required
            >

        </div>

        <button
            type="submit"
            class="budget-button"
        >
            <i class="fa-solid fa-magnifying-glass"></i>
            Find Products
        </button>

    </form>


    {{-- =========================================================
         RESULTS
    ========================================================= --}}

    @if($budget !== null && $budget !== '')

        <div class="budget-result">

            <div class="budget-result-text">
                🎯 Products under
                <strong>
                    ₹{{ number_format((float) $budget, 2) }}
                </strong>
            </div>

            @if(isset($products))
                <div class="budget-result-count">
                    {{ $products->count() }} products
                </div>
            @endif

        </div>


        <div class="budget-products">

            @forelse($products as $product)

                {{-- =================================================
                     ONE FIXED SIZE CARD
                ================================================== --}}

                <a
                    href="{{ route('products.show', $product->id) }}"
                    class="budget-card"
                >

                    {{-- IMAGE --}}
                    <div class="budget-image">

                        @if($product->image)

                            <img
                                src="{{ asset('products/' . $product->image) }}"
                                alt="{{ $product->name }}"
                            >

                        @else

                            <div style="
                                width:58px;
                                height:58px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                color:#94a3b8;
                                background:#f8fafc;
                            ">
                                <i class="fa-solid fa-image"></i>
                            </div>

                        @endif

                    </div>


                    {{-- INFO --}}
                    <div class="budget-info">

                        <div class="budget-name">
                            {{ $product->name }}
                        </div>

                        <div class="budget-category">
                            {{ $product->category ?: 'Smart Basket Product' }}
                        </div>

                    </div>


                    {{-- PRICE --}}
                    <div class="budget-price">

                        <strong>
                            ₹{{ number_format((float) $product->price, 2) }}
                        </strong>

                        <small>
                            View <i class="fa-solid fa-chevron-right"></i>
                        </small>

                    </div>

                </a>

            @empty

                <div class="budget-empty">

                    <i class="fa-solid fa-wallet"></i>

                    <strong>
                        No products found
                    </strong>

                    <span>
                        Try increasing your budget.
                    </span>

                </div>

            @endforelse

        </div>

    @endif

</div>