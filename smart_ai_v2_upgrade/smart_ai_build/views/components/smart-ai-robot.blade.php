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
    data-profile-url="{{ route('profile') }}"
>
    {{-- Hidden launcher: the customer taskbar / 3-dot menu opens this. --}}
    <button class="smart-ai__launch" type="button" data-smart-ai-open aria-haspopup="dialog" aria-controls="smartAiPanel">
        <span class="smart-ai__launch-orb"><i class="fa-solid fa-robot"></i></span>
        <span class="smart-ai__launch-copy"><strong>Smart AI</strong><small>Ask me anything</small></span>
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
                    <small data-smart-ai-status>Ready • Google Search connected</small>
                </div>
            </div>

            <div class="smart-ai__header-actions">
                <button type="button" data-smart-ai-minimize aria-label="Minimize assistant">—</button>
                <button type="button" data-smart-ai-close aria-label="Close assistant">×</button>
            </div>
        </header>

        <div class="smart-ai__controls">
            <div class="smart-ai__mode-switch" role="tablist" aria-label="Input mode">
                <button type="button" class="is-active" data-ai-mode="type">⌨ Type</button>
                <button type="button" data-ai-mode="live">🎙 Live Voice</button>
            </div>

            <label class="smart-ai__select">
                <span>Language</span>
                <select data-ai-language>
                    <option value="auto">Auto</option>
                    <option value="en-IN">English (India)</option>
                    <option value="hi-IN">हिन्दी</option>
                    <option value="gu-IN">ગુજરાતી</option>
                    <option value="mr-IN">मराठी</option>
                    <option value="bn-IN">বাংলা</option>
                    <option value="ta-IN">தமிழ்</option>
                    <option value="te-IN">తెలుగు</option>
                    <option value="kn-IN">ಕನ್ನಡ</option>
                    <option value="ml-IN">മലയാളം</option>
                    <option value="pa-IN">ਪੰਜਾਬੀ</option>
                    <option value="ur-IN">اردو</option>
                </select>
            </label>

            <label class="smart-ai__select">
                <span>Voice</span>
                <select data-ai-voice>
                    <option value="auto">Auto voice</option>
                </select>
            </label>

            <button type="button" class="smart-ai__speak-toggle is-on" data-ai-autospeak title="Read AI replies aloud">
                <i class="fa-solid fa-volume-high"></i>
            </button>
        </div>

        <div class="smart-ai__stage" data-smart-ai-stage data-expression="normal">
            <div class="smart-ai__stars" aria-hidden="true"><i></i><i></i><i></i><i></i></div>

            <div class="smart-ai__robot" aria-label="Animated Smart AI robot" role="img">
                <div class="smart-ai__antenna"><span></span></div>
                <div class="smart-ai__head">
                    <span class="smart-ai__ear smart-ai__ear--left"></span>
                    <span class="smart-ai__ear smart-ai__ear--right"></span>
                    <div class="smart-ai__brow smart-ai__brow--left"></div>
                    <div class="smart-ai__brow smart-ai__brow--right"></div>
                    <div class="smart-ai__eye smart-ai__eye--left"><i></i></div>
                    <div class="smart-ai__eye smart-ai__eye--right"><i></i></div>
                    <div class="smart-ai__tear smart-ai__tear--left"></div>
                    <div class="smart-ai__tear smart-ai__tear--right"></div>
                    <div class="smart-ai__nose"></div>
                    <div class="smart-ai__mouth"><i></i></div>
                </div>
                <div class="smart-ai__neck"></div>
                <div class="smart-ai__body"><span class="smart-ai__core">✦</span></div>
                <div class="smart-ai__arm smart-ai__arm--left"><i></i></div>
                <div class="smart-ai__arm smart-ai__arm--right"><i></i></div>
                <div class="smart-ai__leg smart-ai__leg--left"></div>
                <div class="smart-ai__leg smart-ai__leg--right"></div>
            </div>

            <div class="smart-ai__thought" data-smart-ai-thought>How can I help you?</div>
            <div class="smart-ai__action-badge" data-smart-ai-action-badge hidden></div>
        </div>

        <div class="smart-ai__chat" data-smart-ai-chat aria-live="polite">
            <p class="smart-ai__empty">Ask anything. I can answer questions, search current information, help with shopping, and react with robot actions like <b>dance</b>, <b>cry</b>, <b>wave</b>, <b>laugh</b> and <b>jump</b>.</p>
        </div>

        <div class="smart-ai__live-bar" data-ai-live-bar hidden>
            <span class="smart-ai__live-dot"></span>
            <strong>Listening live…</strong>
            <span data-ai-live-text>Say something</span>
            <button type="button" data-ai-stop-live>Stop</button>
        </div>

        <form class="smart-ai__composer" data-smart-ai-form>
            <button class="smart-ai__mic" type="button" data-smart-ai-mic aria-label="Speak to Smart AI" title="Speak to Smart AI">
                <i class="fa-solid fa-microphone"></i>
            </button>
            <input data-smart-ai-input maxlength="4000" autocomplete="off" placeholder="Ask Smart AI anything…" aria-label="Message Smart AI">
            <button class="smart-ai__send" type="submit" aria-label="Send message"><i class="fa-solid fa-arrow-up"></i></button>
        </form>

        <div class="smart-ai__quick-actions">
            <button type="button" data-ai-quick="dance">💃 Dance</button>
            <button type="button" data-ai-quick="cry">😢 Cry</button>
            <button type="button" data-ai-quick="laugh">😂 Laugh</button>
            <button type="button" data-ai-quick="wave">👋 Wave</button>
            <button type="button" data-ai-quick="search latest news">🌐 Search web</button>
        </div>

        <p class="smart-ai__hint">Google Search grounding is used for current information when needed. Answers can include live web sources.</p>
    </section>
</section>

<script src="{{ asset('js/smart-ai-robot.js') }}" defer></script>
