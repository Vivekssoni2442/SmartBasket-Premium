@props([])

<link rel="stylesheet" href="{{ asset('css/smart-ai-robot.css') }}">

<section
    class="smart-ai"
    data-smart-ai
    data-endpoint="{{ route('customer-ai.message') }}"
    data-csrf="{{ csrf_token() }}"
    data-products-url="{{ route('products.index') }}"
    data-cart-url="{{ route('cart.index') }}"
    data-checkout-url="{{ url('/checkout') }}"
    data-orders-url="{{ route('orders.index') }}"
    data-settings-url="{{ route('settings') }}"
    data-login-url="{{ route('login') }}"
    data-product-url="{{ url('/product') }}"
    data-cart-add-url="{{ url('/cart/add') }}"
    data-cart-remove-url="{{ url('/cart/remove') }}"
>
    <button
        class="smart-ai__launch"
        type="button"
        data-smart-ai-open
        aria-haspopup="dialog"
        aria-controls="smartAiPanel"
        title="Ask Smart AI"
    >
        <span class="smart-ai__launch-orb">
            <i class="fa-solid fa-robot"></i>
        </span>

        <span class="smart-ai__launch-copy">
            <strong>Smart AI</strong>
            <small>Ask me anything</small>
        </span>

        <span class="smart-ai__launch-pulse" aria-hidden="true"></span>
    </button>

    <section
        class="smart-ai__panel"
        id="smartAiPanel"
        data-smart-ai-panel
        role="dialog"
        aria-modal="true"
        aria-label="Smart AI assistant"
        hidden
    >
        <header class="smart-ai__header">
            <div class="smart-ai__identity">
                <span class="smart-ai__status"></span>

                <div>
                    <strong>Smart AI</strong>
                    <small data-smart-ai-status>Ready to help</small>
                </div>
            </div>

            <div class="smart-ai__header-actions">
                <button
                    type="button"
                    data-smart-ai-minimize
                    aria-label="Minimize assistant"
                >—</button>

                <button
                    type="button"
                    data-smart-ai-close
                    aria-label="Close assistant"
                >×</button>
            </div>
        </header>

        <div
            class="smart-ai__stage"
            data-smart-ai-stage
            data-expression="normal"
        >
            <div class="smart-ai__stars" aria-hidden="true">
                <i></i>
                <i></i>
                <i></i>
            </div>

            <div
                class="smart-ai__robot"
                aria-label="Animated Smart AI robot"
                role="img"
            >
                <div class="smart-ai__antenna">
                    <span></span>
                </div>

                <div class="smart-ai__head">
                    <span class="smart-ai__ear smart-ai__ear--left"></span>
                    <span class="smart-ai__ear smart-ai__ear--right"></span>

                    <div class="smart-ai__brow smart-ai__brow--left"></div>
                    <div class="smart-ai__brow smart-ai__brow--right"></div>

                    <div class="smart-ai__eye smart-ai__eye--left">
                        <i></i>
                    </div>

                    <div class="smart-ai__eye smart-ai__eye--right">
                        <i></i>
                    </div>

                    <div class="smart-ai__nose"></div>

                    <div class="smart-ai__mouth">
                        <i></i>
                    </div>
                </div>

                <div class="smart-ai__neck"></div>

                <div class="smart-ai__body">
                    <span class="smart-ai__core">✦</span>
                </div>

                <div class="smart-ai__arm smart-ai__arm--left">
                    <i></i>
                </div>

                <div class="smart-ai__arm smart-ai__arm--right">
                    <i></i>
                </div>
            </div>

            <div
                class="smart-ai__thought"
                data-smart-ai-thought
            >
                How can I help you?
            </div>
        </div>

        <div
            class="smart-ai__chat"
            data-smart-ai-chat
            aria-live="polite"
        >
            <p class="smart-ai__empty">
                Ask me anything — products, shopping, Internet, study,
                weather, technology, or just say "dance".
            </p>
        </div>

        <form
            class="smart-ai__composer"
            data-smart-ai-form
        >
            <button
                class="smart-ai__mic"
                type="button"
                data-smart-ai-mic
                aria-label="Speak to Smart AI"
                title="Speak to Smart AI"
            >
                <i class="fa-solid fa-microphone"></i>
            </button>

            <input
                data-smart-ai-input
                maxlength="1000"
                autocomplete="off"
                placeholder="Ask Smart AI anything..."
                aria-label="Message Smart AI"
            >

            <button
                class="smart-ai__send"
                type="submit"
                aria-label="Send message"
            >
                <i class="fa-solid fa-arrow-up"></i>
            </button>
        </form>

        <p class="smart-ai__hint">
            Try:
            “Search shoes”
            · “Dance”
            · “What's new today?”
            · “Products under ₹1000”
            · “Explain AI”
        </p>
    </section>
</section>

<script src="{{ asset('js/smart-ai-robot.js') }}" defer></script>