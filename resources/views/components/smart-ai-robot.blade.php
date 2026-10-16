@props([])

@once

{{-- ============================================================
     SMART BASKET — PREMIUM SMART AI ROBOT
     Existing backend, routes, taskbar integration and JS preserved
============================================================ --}}

<link
    rel="stylesheet"
    href="{{ asset('css/smart-ai-robot.css') }}?v={{ filemtime(public_path('css/smart-ai-robot.css')) }}"
>



<section
    class="smart-ai"
    data-smart-ai

    {{-- BACKEND --}}
    data-endpoint="{{ route('customer-ai.message') }}"
    data-csrf="{{ csrf_token() }}"

    {{-- EXISTING SMART BASKET ROUTES --}}
    data-home-url="{{ url('/') }}"
    data-products-url="{{ route('products.index') }}"
    data-cart-url="{{ route('cart.index') }}"
    data-checkout-url="{{ url('/checkout') }}"
    data-orders-url="{{ route('orders.index') }}"
    data-wishlist-url="{{ route('wishlist') }}"
    data-profile-url="{{ route('profile') }}"
    data-addresses-url="{{ route('addresses.index') }}"
    data-payments-url="{{ route('payments.index') }}"
    data-settings-url="{{ route('settings') }}"
    data-login-url="{{ route('login') }}"
    data-clear-url="{{ route('customer-ai.clear') }}"
    data-history-url="{{ route('customer-ai.history') }}"

    {{-- PRODUCT / CART ACTION ROUTES --}}
    data-product-url="{{ url('/product') }}"
    data-cart-add-url="{{ url('/cart/add') }}"
    data-cart-remove-url="{{ url('/cart/remove') }}"

    {{-- AI CONFIG --}}
    data-ai-name="Smart AI"
    data-ai-language="{{ app()->getLocale() }}"
    data-ai-voice="default"
    data-auto-speak="true"
    data-search-status="{{ (filled(config('services.customer_ai_web.key')) || (bool) config('services.customer_ai_web.keyless')) ? 'configured' : 'missing' }}"
    data-search-provider="{{ config('services.customer_ai_web.provider', 'unavailable') }}"
    data-live-storage-key="{{ auth()->check() ? 'customer-' . hash_hmac('sha256', (string) auth()->id(), (string) config('app.key')) : 'guest' }}"
>

    {{-- ========================================================
         TASKBAR / FLOATING LAUNCH BUTTON
         Existing data-smart-ai-open hook preserved.
    ========================================================= --}}

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

    {{-- ========================================================
         SMART AI PANEL
    ========================================================= --}}

    <section
        class="smart-ai__panel"
        id="smartAiPanel"
        data-smart-ai-panel
        role="dialog"
        aria-modal="true"
        aria-label="Smart AI assistant"
        hidden
    >

        {{-- HEADER --}}
        <header class="smart-ai__header">

            <div class="smart-ai__identity">
                <span class="smart-ai__status" data-smart-ai-online></span>

                <div>
                    <strong>Smart AI</strong>
                    <small data-smart-ai-status>Ready to help</small>
                </div>
            </div>

            <div class="smart-ai__header-actions">

                <button type="button" class="smart-ai__live-open" data-smart-ai-live-open aria-label="Start LIVE voice session" aria-controls="smartAiLiveOverlay" aria-pressed="false" title="Start or end LIVE voice session">
                    <span class="smart-ai__live-dot" aria-hidden="true"></span><i class="fa-solid fa-microphone-lines" aria-hidden="true"></i><span>LIVE</span>
                </button>

                <button
                    type="button"
                    class="smart-ai__header-button"
                    data-smart-ai-settings
                    aria-controls="smartAiSettings"
                    aria-expanded="false"
                    aria-label="Open Smart AI settings"
                    title="Settings"
                >
                    <i class="fa-solid fa-sliders"></i>
                </button>

                <button
                    type="button"
                    class="smart-ai__header-button"
                    data-smart-ai-maximize
                    aria-label="Expand assistant"
                    aria-pressed="false"
                    title="Zoom or maximize assistant"
                >
                    <i class="fa-solid fa-up-right-and-down-left-from-center" aria-hidden="true"></i>
                </button>

                <button
                    type="button"
                    class="smart-ai__header-button"
                    data-smart-ai-close
                    aria-label="Close assistant"
                    title="Close"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>
        </header>

        {{-- VOICE SETTINGS --}}
        <div
            class="smart-ai__voice-settings"
            id="smartAiSettings"
            data-smart-ai-voice-settings
            hidden
        >
            <div class="smart-ai__voice-settings-header">
                <div><strong>Smart AI Settings</strong><small>Voice, appearance, and privacy</small></div>

                <button
                    type="button"
                    data-smart-ai-close-settings
                    aria-label="Close voice settings"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <section class="smart-ai__settings-group" aria-label="Voice playback settings">
                <h3>Voice &amp; responses</h3>
                <label class="smart-ai__toggle-setting"><span><strong>Spoken responses</strong><small>Read normal answers aloud, including when LIVE is off</small></span><input type="checkbox" data-smart-ai-auto-speak aria-label="Speak AI responses automatically"></label>
                <label class="smart-ai__toggle-setting"><span><strong>Voice output</strong><small>Allow Smart AI to speak responses</small></span><input type="checkbox" data-smart-ai-voice-enabled aria-label="Enable voice output"></label>
                <label class="smart-ai__toggle-setting"><span><strong>Voice input</strong><small>Enable the microphone button when supported</small></span><input type="checkbox" data-smart-ai-voice-input aria-label="Enable voice input"></label>
                <div class="smart-ai__settings-actions">
                    <button type="button" data-smart-ai-test-voice><i class="fa-solid fa-play" aria-hidden="true"></i> Test voice</button>
                    <button type="button" data-smart-ai-stop-speaking><i class="fa-solid fa-stop" aria-hidden="true"></i> Stop speaking</button>
                </div>
                <p class="smart-ai__settings-note" data-smart-ai-mic-permission>Microphone permission is requested only when you start voice input or LIVE.</p>
            </section>

            <section class="smart-ai__settings-group" aria-label="Session settings">
                <h3>LIVE session</h3>
                <p class="smart-ai__settings-note" data-smart-ai-live-settings-status>LIVE is off. Spoken responses work independently of LIVE.</p>
                <button type="button" class="smart-ai__settings-danger" data-smart-ai-end-live><i class="fa-solid fa-power-off" aria-hidden="true"></i> End LIVE session</button>
                <small class="smart-ai__settings-note">A full page reload interrupts browser microphone and speech sessions.</small>
            </section>

            <section class="smart-ai__settings-group" aria-label="Appearance and assistant settings">
                <h3>Appearance &amp; assistant</h3>
                <label class="smart-ai__setting"><span>Theme</span><select data-smart-ai-theme aria-label="Smart AI theme"><option value="system">Use site theme</option><option value="dark">Dark</option><option value="light">Light</option></select></label>
                <label class="smart-ai__setting"><span>Popup size</span><select data-smart-ai-popup-size aria-label="Smart AI popup size"><option value="normal">Compact</option><option value="expanded">Expanded</option></select></label>
                <label class="smart-ai__toggle-setting"><span><strong>Animations</strong><small>Honor reduced motion settings</small></span><input type="checkbox" data-smart-ai-animations aria-label="Enable Smart AI animations"></label>
                <label class="smart-ai__toggle-setting"><span><strong>Status indicators</strong><small>Show assistant state and connection indicators</small></span><input type="checkbox" data-smart-ai-status-indicators aria-label="Show status indicators"></label>
                <div class="smart-ai__settings-actions"><button type="button" data-smart-ai-clear><i class="fa-regular fa-trash-can" aria-hidden="true"></i> Clear conversation</button></div>
            </section>

            <section class="smart-ai__settings-group" aria-label="Search and privacy status">
                <h3>Search &amp; privacy</h3>
                <p class="smart-ai__settings-note" data-smart-ai-search-status>Web search status is not available.</p>
                <p class="smart-ai__settings-note">Voice input uses your browser microphone. Only recognized text is sent to Smart Basket. API credentials remain on the server.</p>
            </section>

            <label class="smart-ai__setting">
                <span>Language</span>

                <select data-smart-ai-language aria-label="AI language">
                    <option value="auto">Auto Detect</option>
                    <option value="en-US">English</option>
                    <option value="hi-IN">Hindi</option>
                    <option value="gu-IN">Gujarati</option>
                    <option value="mr-IN">Marathi</option>
                    <option value="bn-IN">Bengali</option>
                    <option value="ta-IN">Tamil</option>
                    <option value="te-IN">Telugu</option>
                    <option value="kn-IN">Kannada</option>
                </select>
            </label>

            <label class="smart-ai__setting">
                <span>Speech speed</span>
                <input
                    type="range"
                    min="0.7"
                    max="1.3"
                    step="0.1"
                    data-smart-ai-rate
                    aria-label="Speech speed"
                >
            </label>

            <label class="smart-ai__setting">
                <span>Voice volume</span>
                <input
                    type="range"
                    min="0"
                    max="1"
                    step="0.1"
                    data-smart-ai-volume
                    aria-label="Voice volume"
                >
            </label>

            <label class="smart-ai__setting">
                <span>Voice</span>

                <select data-smart-ai-voice aria-label="AI voice">
                    <option value="default">Default Voice</option>
                </select>
            </label>

        </div>

        <div class="smart-ai__speaking-status" data-smart-ai-speaking-status role="status" aria-live="polite" hidden>
            <span><i class="fa-solid fa-volume-high" aria-hidden="true"></i> Smart AI is speaking</span>
            <button type="button" data-smart-ai-stop-speaking aria-label="Stop speaking" title="Stop speaking"><i class="fa-solid fa-stop" aria-hidden="true"></i></button>
        </div>

        {{-- ROBOT STAGE --}}
        <div
            class="smart-ai__stage"
            data-smart-ai-stage
            data-expression="normal"
        >

            <div class="smart-ai__stars" aria-hidden="true">
                <i></i><i></i><i></i><i></i><i></i>
            </div>

            <div
                class="smart-ai__robot"
                data-smart-ai-robot
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

                    <span class="smart-ai__tear smart-ai__tear--left"></span>
                    <span class="smart-ai__tear smart-ai__tear--right"></span>

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

                <div
                    class="smart-ai__action-effect"
                    data-smart-ai-action-effect
                    aria-hidden="true"
                ></div>

            </div>



            <div
                class="smart-ai__action-status"
                data-smart-ai-action-status
                hidden
            ></div>

        </div>

        {{-- CHAT AREA --}}
        <div
            class="smart-ai__chat"
            data-smart-ai-chat
            aria-live="polite"
            aria-relevant="additions"
        >
            <div
                class="smart-ai__welcome-message"
                data-smart-ai-welcome
            >
                <div class="smart-ai__message-avatar">
                    <i class="fa-solid fa-robot"></i>
                </div>

                <div class="smart-ai__message-content">
                    <strong>Smart AI</strong>

                    <p>
                        Hello! 👋 I'm your Smart Basket AI assistant.
                    </p>

                    <p>
                        You can ask me questions, search for products,
                        get shopping help, or tell me things like

                    </p>

                </div>
            </div>
        </div>



        {{-- MESSAGE COMPOSER --}}
        <form class="smart-ai__composer" data-smart-ai-form>

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
                type="text"
                data-smart-ai-input
                maxlength="1000"
                autocomplete="off"
                spellcheck="true"
                placeholder="Ask Smart AI anything..."
                aria-label="Message Smart AI"
            >

            <button
                class="smart-ai__send"
                type="submit"
                aria-label="Send message"
                title="Send message"
            >
                <i class="fa-solid fa-arrow-up"></i>
            </button>

        </form>

        {{-- VOICE STATUS --}}
        <div
            class="smart-ai__voice-status"
            data-smart-ai-voice-status
            hidden
        >
            <span class="smart-ai__voice-bars">
                <i></i><i></i><i></i><i></i><i></i>
            </span>

            <span data-smart-ai-voice-text>Listening...</span>

            <button
                type="button"
                data-smart-ai-stop-listening
                aria-label="Stop listening"
            >
                <i class="fa-solid fa-stop"></i>
            </button>
        </div>

        {{-- HINT --}}
        <p class="smart-ai__hint">
            <span>Try:</span>
            “Search shoes” <b>·</b>
            “Dance” <b>·</b>
            “Cry” <b>·</b>
            “What's new today?” <b>·</b>
            “Products under ₹1000” <b>·</b>
            “Explain AI”
        </p>

        {{-- SCREEN READER STATUS --}}
        <div
            class="smart-ai__sr-status"
            data-smart-ai-sr-status
            aria-live="assertive"
        ></div>

    </section>

    <div class="smart-ai__live-overlay" id="smartAiLiveOverlay" data-smart-ai-live-overlay data-mode="welcome" hidden>
        <section class="smart-ai__live-welcome" data-smart-ai-live-welcome role="dialog" aria-modal="true" aria-labelledby="smartAiLiveWelcomeTitle">
            <div class="smart-ai__live-brand"><i class="fa-solid fa-basket-shopping" aria-hidden="true"></i><span>Smart Basket <small>SMART AI</small></span></div>
            <div class="smart-ai__welcome-avatar" aria-hidden="true"><i class="fa-solid fa-robot"></i><span></span></div>
            <p class="smart-ai__welcome-kicker">YOUR PERSONAL SHOPPING ASSISTANT</p>
            <h2 id="smartAiLiveWelcomeTitle">How can I help you today?</h2>
            <p class="smart-ai__welcome-copy">Ask about products, your cart, orders, or anything you’re curious about. Start voice mode when you’re ready, or continue with text.</p>
            <p class="smart-ai__permission-note" data-smart-ai-permission-note role="status"><i class="fa-solid fa-microphone" aria-hidden="true"></i> Your browser will ask for microphone access only when you choose Go Live.</p>
            <button type="button" class="smart-ai__welcome-start" data-smart-ai-live-start><i class="fa-solid fa-microphone-lines" aria-hidden="true"></i> Go Live</button>
            <button type="button" class="smart-ai__welcome-text" data-smart-ai-live-text>Continue with text</button>
            <button type="button" class="smart-ai__welcome-close" data-smart-ai-live-dismiss aria-label="Close Smart AI welcome"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
        </section>
        <aside class="smart-ai__live-card smart-ai__live" role="region" aria-label="Smart Basket LIVE voice assistant">
            <div class="smart-ai__live-brand"><i class="fa-solid fa-basket-shopping" aria-hidden="true"></i><span>Smart Basket <small data-smart-ai-live-state-label>LIVE</small></span></div>
            <div class="smart-ai__live-orb-wrap" data-smart-ai-live-orb data-state="idle">
                <span class="smart-ai__live-ring" aria-hidden="true"></span>
                <button type="button" class="smart-ai__live-orb" data-smart-ai-live-mic aria-label="Start listening"><i class="fa-solid fa-microphone" aria-hidden="true"></i></button>
            </div>
            <p class="smart-ai__live-status" data-smart-ai-live-status role="status" aria-live="polite">LIVE ready. Tap the microphone to start listening.</p>
            <p class="smart-ai__live-privacy">The browser handles speech recognition. Smart Basket receives recognized text only.</p>
            <div class="smart-ai__live-controls">
                <button type="button" class="smart-ai__live-action" data-smart-ai-live-mute aria-pressed="false"><i class="fa-solid fa-volume-high" aria-hidden="true"></i><span>Mute voice</span></button>
                <button type="button" class="smart-ai__live-action smart-ai__live-action--stop" data-smart-ai-live-stop aria-label="Stop current speech and pause listening"><i class="fa-solid fa-stop" aria-hidden="true"></i><span>Stop</span></button>
                <button type="button" class="smart-ai__live-action smart-ai__live-action--end" data-smart-ai-live-end aria-label="Turn off LIVE assistant"><i class="fa-solid fa-power-off" aria-hidden="true"></i><span>Turn off</span></button>
            </div>
            <div class="smart-ai__live-transcript" data-smart-ai-live-transcript role="log" aria-live="polite" aria-relevant="additions text"></div>
        </aside>
    </div>

</section>

{{-- Move the existing host out of page wrappers before its deferred JS binds.
     Keeping the host preserves taskbar launcher rules while avoiding clipped
     or lower ancestor stacking contexts on every page. --}}
<script>
(() => {
    const root = document.querySelector('[data-smart-ai]');
    if (!root || root.dataset.portalMounted === 'true') return;

    const host = root.closest(
        '.sb-products-smart-ai-host, .sb-smart-ai-robot-host, .customer-global-smart-ai'
    ) || root;

    if (host.parentElement !== document.body) {
        document.body.appendChild(host);
    }

    root.dataset.portalMounted = 'true';
})();
</script>

{{-- EXISTING SMART AI JAVASCRIPT --}}
<script
    src="{{ asset('js/smart-ai-robot.js') }}?v={{ filemtime(public_path('js/smart-ai-robot.js')) }}"
    defer
></script>

{{-- ============================================================
     LAUNCHER FALLBACK
     Preserves taskbar click-to-open behavior.
     ============================================================ --}}

<script>
(() => {
    if (window.__smartAiLauncherDelegationBound) return;

    window.__smartAiLauncherDelegationBound = true;

    document.addEventListener('click', event => {
        const target = event.target instanceof Element
            ? event.target
            : event.target?.parentElement;

        const launcher = target?.closest('[data-smart-ai-open]');

        if (!launcher) return;

        const root = launcher.closest('[data-smart-ai]');

        const panel = root?.querySelector('[data-smart-ai-panel]');

        if (!panel) return;

        /*
         * Let the existing robot JavaScript handle the click first.
         * This fallback only opens the panel if it remains closed.
         */
        window.setTimeout(() => {
            if (panel.hidden) {
                panel.hidden = false;
                window.SmartBasketAI?.gesture?.('wave');
            }
        }, 0);
    });
})();
</script>

@endonce
