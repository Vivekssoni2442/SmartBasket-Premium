<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('ai-hub.partials.head', [
        'title' => 'Wishlist'
    ])

</head>

<body>

<div class="ai-hub-layout">

    {{-- =========================================================
         GLOBAL AI HUB
         SINGLE INSTANCE ONLY

         This is the ONLY AI HUB navigation instance.
         Do not add any other AI HUB button/sidebar here.
    ========================================================== --}}

    @include('ai-hub.partials.navigation')


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <main class="ai-hub-main">

        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <header class="ai-hub-heading">

            <div>

                <span class="ai-hub-eyebrow">
                    SAVED FOR LATER
                </span>

                <h1>
                    Your Wishlist ❤️
                </h1>

                <p>
                    Save your favourite products and move them
                    to your Smart Basket cart whenever you're ready.
                </p>

            </div>


            {{-- =================================================
                 BROWSE PRODUCTS
            ================================================== --}}

            @if(Route::has('products.index'))

                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-outline-primary"
                >

                    <i class="fa-solid fa-store me-1"></i>

                    Browse Products

                </a>

            @endif

        </header>


        {{-- =====================================================
             FLASH MESSAGES
        ====================================================== --}}

        @if(session('success'))

            <div class="alert alert-success mb-4">

                <i class="fa-solid fa-circle-check me-1"></i>

                {{ session('success') }}

            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger mb-4">

                <i class="fa-solid fa-circle-exclamation me-1"></i>

                {{ session('error') }}

            </div>

        @endif


        {{-- =====================================================
             WISHLIST
        ====================================================== --}}

        <section class="ai-panel">

            @if($wishlistItems->isNotEmpty())

                {{-- =================================================
                     WISHLIST HEADER
                ================================================== --}}

                <div
                    class="d-flex flex-wrap
                           align-items-center
                           justify-content-between
                           gap-3 mb-4"
                >

                    <div>

                        <span class="ai-hub-eyebrow">
                            YOUR SAVED PRODUCTS
                        </span>

                        <p class="text-muted mb-0 mt-1">

                            <strong>
                                {{ $wishlistItems->count() }}
                            </strong>

                            saved
                            {{ $wishlistItems->count() === 1
                                ? 'product'
                                : 'products'
                            }}

                        </p>

                    </div>


                    {{-- =================================================
                         CART
                    ================================================== --}}

                    @if(Route::has('cart.index'))

                        <a
                            href="{{ route('cart.index') }}"
                            class="btn btn-primary"
                        >

                            <i class="fa-solid fa-cart-shopping me-1"></i>

                            Open Cart

                        </a>

                    @endif

                </div>


                {{-- =================================================
                     PRODUCT GRID
                ================================================== --}}

                <div class="ai-product-grid">

                    @foreach($wishlistItems as $wishlistItem)

                        @php
                            $product = $wishlistItem->product;
                        @endphp


                        @if($product)

                            <article class="ai-product-card">


                                {{-- =================================
                                     PRODUCT IMAGE
                                ================================== --}}

                                <a
                                    href="{{ route(
                                        'products.show',
                                        $product->id
                                    ) }}"
                                    class="text-decoration-none"
                                >

                                    @if(!empty($product->image))

                                        <img
                                            src="{{ asset(
                                                'products/' . $product->image
                                            ) }}"
                                            alt="{{ $product->name }}"
                                            loading="lazy"
                                        >

                                    @else

                                        <div
                                            class="d-flex
                                                   align-items-center
                                                   justify-content-center
                                                   bg-body-secondary"
                                            style="height:220px;"
                                        >

                                            <i
                                                class="fa-solid
                                                       fa-image
                                                       fa-2x
                                                       text-muted"
                                            ></i>

                                        </div>

                                    @endif

                                </a>


                                {{-- =================================
                                     PRODUCT INFORMATION
                                ================================== --}}

                                <div class="ai-product-card-body">


                                    {{-- PRODUCT NAME --}}

                                    <h3>

                                        <a
                                            href="{{ route(
                                                'products.show',
                                                $product->id
                                            ) }}"
                                            class="text-decoration-none"
                                        >

                                            {{ $product->name }}

                                        </a>

                                    </h3>


                                    {{-- CATEGORY + RATING --}}

                                    <p>

                                        {{ $product->category
                                            ?: 'Smart Basket product'
                                        }}

                                        <span class="mx-1">
                                            ·
                                        </span>

                                        <span class="text-warning">
                                            ★
                                        </span>

                                        {{ number_format(
                                            (float) ($product->rating ?? 0),
                                            1
                                        ) }}

                                    </p>


                                    {{-- PRICE --}}

                                    <div class="ai-price mb-3">

                                        ₹{{ number_format(
                                            (float) $product->price,
                                            2
                                        ) }}

                                    </div>


                                    {{-- =================================
                                         ACTIONS
                                    ================================== --}}

                                    <div
                                        class="d-flex
                                               flex-wrap
                                               gap-2"
                                    >


                                        {{-- =============================
                                             ADD TO CART
                                        ============================== --}}

                                        @if(Route::has('cart.add'))

                                            <form
                                                method="POST"
                                                action="{{ route(
                                                    'cart.add',
                                                    $product->id
                                                ) }}"
                                                class="flex-grow-1"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="btn
                                                           btn-primary
                                                           btn-sm
                                                           w-100"
                                                >

                                                    <i
                                                        class="fa-solid
                                                               fa-cart-plus
                                                               me-1"
                                                    ></i>

                                                    Add to Cart

                                                </button>

                                            </form>

                                        @endif


                                        {{-- =============================
                                             VIEW PRODUCT
                                        ============================== --}}

                                        @if(Route::has('products.show'))

                                            <a
                                                href="{{ route(
                                                    'products.show',
                                                    $product->id
                                                ) }}"
                                                class="btn
                                                       btn-outline-primary
                                                       btn-sm"
                                                title="View Product"
                                            >

                                                <i
                                                    class="fa-solid
                                                           fa-eye"
                                                ></i>

                                                <span
                                                    class="d-none
                                                           d-sm-inline
                                                           ms-1"
                                                >
                                                    View
                                                </span>

                                            </a>

                                        @endif


                                        {{-- =============================
                                             REMOVE WISHLIST
                                        ============================== --}}

                                        @if(Route::has('wishlist.remove'))

                                            <form
                                                method="POST"
                                                action="{{ route(
                                                    'wishlist.remove',
                                                    $wishlistItem
                                                ) }}"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn
                                                           btn-outline-danger
                                                           btn-sm"
                                                    aria-label="Remove from wishlist"
                                                    title="Remove from wishlist"
                                                    onclick="
                                                        return confirm(
                                                            'Remove this product from your wishlist?'
                                                        );
                                                    "
                                                >

                                                    <i
                                                        class="fa-solid
                                                               fa-trash"
                                                    ></i>

                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </div>

                            </article>

                        @endif

                    @endforeach

                </div>


            @else

                {{-- =================================================
                     EMPTY WISHLIST
                ================================================== --}}

                <div class="ai-empty text-center">

                    <i class="fa-regular fa-heart"></i>

                    <h4 class="mt-3 mb-2">
                        Your Wishlist is Empty
                    </h4>

                    <p class="text-muted mb-4">

                        Save your favourite products from the
                        Smart Basket catalog and they will appear here.

                    </p>


                    @if(Route::has('products.index'))

                        <a
                            href="{{ route('products.index') }}"
                            class="btn btn-primary"
                        >

                            <i class="fa-solid fa-bag-shopping me-1"></i>

                            Explore Products

                        </a>

                    @endif

                </div>

            @endif

        </section>

    </main>

</div>


{{-- =========================================================
     IMPORTANT

     AI HUB IS LOADED ONLY ONCE:

     @include('ai-hub.partials.navigation')

     Do NOT add:
     - another floating AI button
     - another sidebar
     - another drawer
     - another overlay
     - another AI HUB JavaScript
========================================================= --}}

</body>

</html>