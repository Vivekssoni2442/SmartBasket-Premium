<!DOCTYPE html>
<html lang="en">

<head>
    @include('ai-hub.partials.head', ['title' => 'AI HUB'])
</head>

<body>

<div class="ai-hub-layout">

    @include('ai-hub.partials.navigation')

    <main class="ai-hub-main">

        <header class="ai-hub-heading">

            <div>

                <span class="ai-hub-eyebrow">
                    Personal shopping tools
                </span>

                <h1>
                    Your AI HUB
                </h1>

                <p>
                    Explore smarter ways to discover, compare, and shop products.
                </p>

            </div>

            <a href="{{ route('products.index') }}"
               class="btn btn-outline-primary">

                <i class="fa-solid fa-store me-1"></i>
                Browse products

            </a>

        </header>


        <section class="ai-hub-grid">

            <a class="ai-tool-card"
               href="{{ route('ai-camera-assistant') }}">

                <span class="ai-tool-icon">📷</span>

                <h2>
                    AI Camera Assistant
                </h2>

                <p>
                    Show your face & body to the camera for AI style analysis
                    and product recommendations.
                </p>

                <i class="fa-solid fa-arrow-right ai-tool-arrow"></i>

            </a>


            <a class="ai-tool-card"
               href="{{ route('budget-shopping') }}">

                <span class="ai-tool-icon">💰</span>

                <h2>
                    Budget Shopping
                </h2>

                <p>
                    Find products that fit perfectly within your spending limit.
                </p>

                <i class="fa-solid fa-arrow-right ai-tool-arrow"></i>

            </a>


            <a class="ai-tool-card"
               href="{{ route('gift-finder') }}">

                <span class="ai-tool-icon">🎁</span>

                <h2>
                    Gift Finder
                </h2>

                <p>
                    Get curated product ideas for any celebration.
                </p>

                <i class="fa-solid fa-arrow-right ai-tool-arrow"></i>

            </a>


            <a class="ai-tool-card"
               href="{{ route('trending-products') }}">

                <span class="ai-tool-icon">🌟</span>

                <h2>
                    Trending Products
                </h2>

                <p>
                    See top-selling products and highly rated picks.
                </p>

                <i class="fa-solid fa-arrow-right ai-tool-arrow"></i>

            </a>


            <a class="ai-tool-card"
               href="{{ route('compare-products') }}">

                <span class="ai-tool-icon">⚖</span>

                <h2>
                    Compare Products
                </h2>

                <p>
                    Put two products side by side before you decide.
                </p>

                <i class="fa-solid fa-arrow-right ai-tool-arrow"></i>

            </a>


            <a class="ai-tool-card"
               href="{{ route('wishlist') }}">

                <span class="ai-tool-icon">❤️</span>

                <h2>
                    Wishlist
                </h2>

                <p>
                    Keep favourite products close and add them to your cart.
                </p>

                <i class="fa-solid fa-arrow-right ai-tool-arrow"></i>

            </a>


            <a class="ai-tool-card"
               href="{{ route('cart.index') }}">

                <span class="ai-tool-icon">🛒</span>

                <h2>
                    Cart
                </h2>

                <p>
                    Continue securely with your existing Smart Basket cart.
                </p>

                <i class="fa-solid fa-arrow-right ai-tool-arrow"></i>

            </a>


            <a class="ai-tool-card"
               href="{{ route('profile') }}">

                <span class="ai-tool-icon">👤</span>

                <h2>
                    Profile
                </h2>

                <p>
                    Manage your existing Smart Basket customer profile.
                </p>

                <i class="fa-solid fa-arrow-right ai-tool-arrow"></i>

            </a>

        </section>

    </main>

</div>

</body>
</html>