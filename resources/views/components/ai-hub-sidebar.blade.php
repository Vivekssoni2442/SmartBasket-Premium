<link rel="stylesheet" href="{{ asset('css/ai-hub-sidebar.css') }}">
<button class="ai-hub-fab" type="button" data-ai-hub-open aria-label="Open AI HUB"><span>🤖</span><small>AI HUB</small></button>
<div class="ai-hub-overlay" data-ai-hub-close></div>
<aside class="ai-hub-drawer" aria-label="AI HUB navigation" aria-hidden="true">
    <header class="ai-hub-drawer-header"><div><strong>🤖 AI HUB</strong><small>Smart Shopping Assistant</small></div><button type="button" data-ai-hub-close aria-label="Close AI HUB"></button></header>
<nav class="ai-hub-drawer-nav" aria-label="AI HUB features">
        <button type="button" data-ai-hub-feature="ai-camera-assistant" data-ai-hub-url="{{ route('ai-camera-assistant') }}">📷 <span>AI Camera Assistant</span></button>
        <button type="button" data-ai-hub-feature="budget-shopping" data-ai-hub-url="{{ route('budget-shopping') }}">💰 <span>Budget Shopping</span></button>
        <button type="button" data-ai-hub-feature="gift-finder" data-ai-hub-url="{{ route('gift-finder') }}">🎁 <span>Gift Finder</span></button>
        <button type="button" data-ai-hub-feature="trending-products" data-ai-hub-url="{{ route('trending-products') }}">🌟 <span>Trending Products</span></button>
        <button type="button" data-ai-hub-feature="compare-products" data-ai-hub-url="{{ route('compare-products') }}">⚖️ <span>Compare Products</span></button>
        <button type="button" data-ai-hub-feature="wishlist" data-ai-hub-url="{{ route('wishlist') }}">❤️ <span>Wishlist</span></button>
        <a href="{{ route('cart.index') }}">🛒 <span>Cart</span></a>
        <a href="{{ route('profile') }}">👤 <span>Profile</span></a>
    </nav>
    <section class="ai-hub-drawer-content" data-ai-hub-content><div class="ai-hub-drawer-empty"><span>✨</span><strong>Choose a shopping tool</strong><p>Its controls and suggestions will appear here without leaving this page.</p></div></section>
    <a class="ai-hub-overview" href="{{ route('overview') }}">📊 <span>Overview</span><i>→</i></a>
</aside>
<script src="{{ asset('js/ai-hub-sidebar.js') }}" defer></script>
