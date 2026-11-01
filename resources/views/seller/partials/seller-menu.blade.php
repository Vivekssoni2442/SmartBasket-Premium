<script>
(() => {
    const key = 'smartbasket_seller_theme';
    const fallback = @json($seller->theme ?? 'light');
    const normalize = value => ['light', 'dark', 'system'].includes(value) ? value : 'light';
    const prefersDark = () => Boolean(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
    const resolve = value => value === 'system'
        ? (prefersDark() ? 'dark' : 'light')
        : value;
    const apply = value => {
        const selected = normalize(value);
        const resolved = resolve(selected);
        document.documentElement.dataset.theme = resolved;
        document.documentElement.dataset.sbTheme = resolved;
        document.documentElement.dataset.sellerTheme = selected;
    };
    let saved = fallback;
    try { saved = localStorage.getItem(key) || fallback; } catch (error) {}
    apply(saved);
    window.addEventListener('storage', event => {
        if (event.key === key && event.newValue) {
            saved = event.newValue;
            apply(saved);
        }
    });
    window.addEventListener('smartbasket-theme-changed', event => {
        if (event.detail?.theme) {
            saved = event.detail.theme;
            apply(saved);
        }
    });
    if (window.matchMedia) {
        const systemTheme = window.matchMedia('(prefers-color-scheme: dark)');
        systemTheme.addEventListener?.('change', () => {
            if (normalize(saved) === 'system') apply(saved);
        });
    }
})();
</script>

<script>
(() => {
    const icons = [
        [/dashboard|workspace|home/i, '\u{1F3E0}'],
        [/order|delivery/i, '\u{1F4E6}'],
        [/product|inventory|catalog/i, '\u{1F6CD}\uFE0F'],
        [/payment|earning|payout|wallet|bank/i, '\u{1F4B3}'],
        [/return|refund/i, '\u{21A9}\uFE0F'],
        [/profile|account/i, '\u{1F464}'],
        [/setting|preference/i, '\u{2699}\uFE0F'],
        [/verification|document|identity|kyc|security/i, '\u{1F6E1}\uFE0F'],
        [/application|business/i, '\u{1F4CB}'],
        [/store|seller|shop|mart/i, '\u{1F3EA}'],
    ];
    function enhanceSellerTitle() {
        const visible = (heading) => heading.getClientRects().length > 0 && !heading.closest('.modal,[hidden]');
        const title = Array.from(document.querySelectorAll('main h1')).find((heading) =>
            visible(heading) && !heading.closest('.brand,.seller-brand')
        ) || Array.from(document.querySelectorAll('main .title h2')).find(visible);
        if (!title) return;

        const text = title.textContent.replace(/\s+/g, ' ').trim();
        const emoji = icons.find(([pattern]) => pattern.test(text))?.[1] || '✨';
        let hero = title.closest([
            '.sb-commandbar', '.profile-title-card', '.orders-header', '.order-hero',
            '.sb-products-header', '.settings-hero', '.sr-hero', '.payment-header',
            '.summary-hero', '.ep-header', '.bank-header', '.bd-header', '.title',
            '.seller-page-header', '.page-header', '.seller-title-hero', 'header'
        ].join(', '));
        if (!hero) {
            hero = document.createElement('section');
            title.parentNode.insertBefore(hero, title);
            hero.appendChild(title);
            const subtitle = hero.nextElementSibling;
            if (subtitle?.tagName === 'P' && !subtitle.closest('form')) hero.appendChild(subtitle);
        }
        if (!hero) return;

        hero.classList.add('seller-title-hero');
        title.classList.remove('sb-page-brand-title');
        const hasSellerLogo = Boolean(hero.querySelector('.sb-brand-mark'));
        if (hasSellerLogo) {
            hero.querySelectorAll('.sb-eyebrow i').forEach((oldIcon) => oldIcon.remove());
        }
        hero.querySelectorAll('.header-icon,.sb-header-icon,.title-card-icon,.settings-hero-icon,.payment-title-icon,.sr-hero-icon,.hero-icon,.ep-header-icon,.bank-header-icon,.bd-header-icon,.title-icon')
            .forEach((oldIcon) => oldIcon.remove());

        const walker = document.createTreeWalker(title, NodeFilter.SHOW_TEXT);
        const textNodes = [];
        while (walker.nextNode()) textNodes.push(walker.currentNode);
        textNodes.forEach((node) => {
            node.textContent = node.textContent.replace(/[\p{Extended_Pictographic}\uFE0F\u200D]/gu, '').replace(/\s+/g, ' ');
        });

        title.querySelectorAll('i.fa-solid,i.fa-regular,i.fa-brands,i.fas,i.far,i.fab')
            .forEach((oldIcon) => oldIcon.remove());
        let icon = title.querySelector(':scope > .seller-title-emoji');
        if (hasSellerLogo) {
            icon?.remove();
        } else {
            if (!icon) {
                icon = document.createElement('span');
                icon.className = 'seller-title-emoji';
                icon.setAttribute('aria-hidden', 'true');
                title.insertBefore(icon, title.firstChild);
            }
            icon.textContent = emoji;
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', enhanceSellerTitle, { once: true });
    } else {
        enhanceSellerTitle();
    }
})();
</script>

<style>
/* =========================================================
   SMART BASKET — GLOBAL SELLER MENU
   PREMIUM ICON MENU
   ========================================================= */

.sb-common-menu-wrapper {
    position: fixed;
    top: 13px;
    right: 18px;
    z-index: 99999;

    font-family: 'Inter', sans-serif;
}


/* =========================================================
   PREMIUM MENU BUTTON
   ========================================================= */

.sb-common-menu-button {
    position: relative;

    width: 50px;
    height: 50px;

    padding: 0;
    margin: 0;

    border: 1px solid rgba(59, 130, 246, .58);
    border-radius: 15px;

    background:
        linear-gradient(
            145deg,
            #172f59 0%,
            #0b1220 100%
        );

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;

    box-shadow:
        0 12px 30px rgba(0, 0, 0, .28),
        0 0 0 3px rgba(37, 99, 235, .12),
        inset 0 1px 0 rgba(255, 255, 255, .13);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease,
        background .25s ease;

    outline: none;

    -webkit-tap-highlight-color: transparent;
}


/* =========================================================
   MENU BUTTON HOVER
   ========================================================= */

.sb-common-menu-button:hover {

    transform:
        translateY(-2px);

    border-color:
        rgba(96, 165, 250, .85);

    background:
        linear-gradient(
            145deg,
            #1e40af 0%,
            #0d1728 100%
        );

    box-shadow:
        0 16px 36px rgba(0, 0, 0, .34),
        0 0 0 4px rgba(37, 99, 235, .18),
        inset 0 1px 0 rgba(255, 255, 255, .15);
}


/* =========================================================
   ACTIVE / CLICK
   ========================================================= */

.sb-common-menu-button:active {

    transform:
        scale(.94);

}


/* =========================================================
   REAL MENU ICON
   IMPORTANT:
   Font Awesome icon — NO Unicode square/dots.
   ========================================================= */

.sb-menu-logo {

    width: 24px;
    height: 24px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    color: #60a5fa;

    font-family:
        "Font Awesome 6 Free" !important;

    font-size: 19px;

    font-weight: 900;

    line-height: 1;

    transition:
        transform .25s ease,
        color .25s ease;

}


/* Font Awesome menu glyph */

.sb-menu-logo::before {

    content: "\f0c9";

    font-family:
        "Font Awesome 6 Free" !important;

    font-weight:
        900;

    line-height:
        1;

}


/* Hover icon */

.sb-common-menu-button:hover
.sb-menu-logo {

    color:
        #93c5fd;

}


/* =========================================================
   OPEN STATE
   ========================================================= */

.sb-common-menu-button.is-open
.sb-menu-logo {

    transform:
        rotate(90deg);

}


/* =========================================================
   MENU PANEL
   ========================================================= */

.sb-common-menu {

    position: absolute;

    top: 57px;
    right: 0;

    width: 255px;

    padding: 9px;

    background:
        linear-gradient(
            145deg,
            rgba(18, 28, 44, .99),
            rgba(7, 13, 24, .99)
        );

    border:
        1px solid rgba(59, 130, 246, .30);

    border-radius: 20px;

    box-shadow:
        0 28px 70px rgba(0, 0, 0, .48),
        0 8px 25px rgba(0, 0, 0, .22);

    backdrop-filter:
        blur(20px);

    -webkit-backdrop-filter:
        blur(20px);

    visibility:
        hidden;

    opacity:
        0;

    transform:
        translateY(-10px)
        scale(.96);

    transform-origin:
        top right;

    pointer-events:
        none;

    transition:
        opacity .20s ease,
        transform .20s ease,
        visibility .20s ease;

}


/* =========================================================
   OPEN
   ========================================================= */

.sb-common-menu.active {

    visibility:
        visible;

    opacity:
        1;

    transform:
        translateY(0)
        scale(1);

    pointer-events:
        auto;

}


/* =========================================================
   MENU ITEMS
   ========================================================= */

.sb-common-menu a,
.sb-common-menu button {

    width:
        100%;

    min-height:
        48px;

    box-sizing:
        border-box;

    display:
        flex;

    align-items:
        center;

    gap:
        13px;

    padding:
        10px 13px;

    margin:
        0;

    border:
        0;

    border-radius:
        13px;

    background:
        transparent;

    color:
        #e8edf5;

    text-decoration:
        none;

    font-family:
        'Inter',
        sans-serif !important;

    font-size:
        13px;

    font-weight:
        600;

    line-height:
        1.2;

    text-align:
        left;

    cursor:
        pointer;

    transition:
        background .20s ease,
        color .20s ease,
        transform .20s ease,
        box-shadow .20s ease;

    outline:
        none;

}


/* =========================================================
   MENU ITEM HOVER
   ========================================================= */

.sb-common-menu a:hover,
.sb-common-menu button:hover {

    background:
        linear-gradient(
            90deg,
            rgba(59, 130, 246, .16),
            rgba(59, 130, 246, .045)
        );

    color:
        #60a5fa;

    transform:
        translateX(3px);

    text-decoration:
        none;

}


/* =========================================================
   ICON BOX
   ========================================================= */

.sb-common-menu-icon {

    width:
        32px;

    min-width:
        32px;

    height:
        32px;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    border-radius:
        10px;

    background:
        rgba(255, 255, 255, .055);

    border:
        1px solid rgba(255, 255, 255, .06);

    color:
        #cbd5e1;

    font-size:
        14px;

    line-height:
        1;

    text-align:
        center;

    flex-shrink:
        0;

    transition:
        background .20s ease,
        color .20s ease,
        border-color .20s ease,
        transform .20s ease;

}


/* =========================================================
   ICON FONT — CRITICAL FIX
   ========================================================= */

.sb-common-menu-icon i,
.sb-common-menu-icon .fa,
.sb-common-menu-icon .fas,
.sb-common-menu-icon .far,
.sb-common-menu-icon .fab,
.sb-common-menu-icon .fa-solid,
.sb-common-menu-icon .fa-regular,
.sb-common-menu-icon .fa-brands {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    width:
        100%;

    height:
        100%;

    line-height:
        1;

    font-style:
        normal;

}


/* Free Solid icons */

.sb-common-menu-icon .fa,
.sb-common-menu-icon .fas,
.sb-common-menu-icon .fa-solid {

    font-family:
        "Font Awesome 6 Free" !important;

    font-weight:
        900 !important;

}


/* Regular icons */

.sb-common-menu-icon .far,
.sb-common-menu-icon .fa-regular {

    font-family:
        "Font Awesome 6 Free" !important;

    font-weight:
        400 !important;

}


/* Brand icons */

.sb-common-menu-icon .fab,
.sb-common-menu-icon .fa-brands {

    font-family:
        "Font Awesome 6 Brands" !important;

    font-weight:
        400 !important;

}


/* =========================================================
   HOVER ICON
   ========================================================= */

.sb-common-menu a:hover
.sb-common-menu-icon,
.sb-common-menu button:hover
.sb-common-menu-icon {

    color:
        #60a5fa;

    background:
        rgba(59, 130, 246, .14);

    border-color:
        rgba(59, 130, 246, .22);

    transform:
        scale(1.04);

}


/* =========================================================
   ACTIVE MENU ITEM
   ========================================================= */

.sb-common-menu a.sb-menu-active {

    color:
        #60a5fa;

    background:
        linear-gradient(
            90deg,
            rgba(59, 130, 246, .16),
            rgba(59, 130, 246, .045)
        );

    box-shadow:
        inset 3px 0 #60a5fa;

}


/* Active icon */

.sb-common-menu a.sb-menu-active
.sb-common-menu-icon {

    color:
        #60a5fa;

    background:
        rgba(59, 130, 246, .14);

    border-color:
        rgba(59, 130, 246, .24);

}


/* =========================================================
   DIVIDER
   ========================================================= */

.sb-common-menu-divider {

    height:
        1px;

    margin:
        8px 5px;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.10),
            transparent
        );

}


/* =========================================================
   LOGOUT
   ========================================================= */

.sb-common-menu-logout {

    color:
        #ff8585 !important;

}


/* Logout icon */

.sb-common-menu-logout
.sb-common-menu-icon {

    color:
        #ff7777;

    background:
        rgba(239, 68, 68, .08);

    border-color:
        rgba(239, 68, 68, .12);

}


/* Logout hover */

.sb-common-menu-logout:hover {

    background:
        linear-gradient(
            90deg,
            rgba(239,68,68,.14),
            rgba(239,68,68,.035)
        ) !important;

    color:
        #ff6b6b !important;

}


/* Logout hover icon */

.sb-common-menu-logout:hover
.sb-common-menu-icon {

    color:
        #ff6b6b;

    background:
        rgba(239, 68, 68, .12);

    border-color:
        rgba(239, 68, 68, .18);

}


/* =========================================================
   FOCUS
   ========================================================= */

.sb-common-menu-button:focus-visible,
.sb-common-menu a:focus-visible,
.sb-common-menu button:focus-visible {

    outline:
        2px solid #60a5fa;

    outline-offset:
        2px;

}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 600px) {

    .sb-common-menu-wrapper {

        top:
            11px;

        right:
            13px;

    }


    .sb-common-menu-button {

        width:
            46px;

        height:
            46px;

        border-radius:
            14px;

    }


    .sb-menu-logo {

        width:
            22px;

        height:
            22px;

        font-size:
            17px;

    }


    .sb-common-menu {

        top:
            53px;

        width:
            225px;

        border-radius:
            18px;

    }


    .sb-common-menu a,
    .sb-common-menu button {

        min-height:
            45px;

        padding:
            9px 12px;

        font-size:
            12.5px;

    }


    .sb-common-menu-icon {

        width:
            30px;

        min-width:
            30px;

        height:
            30px;

        border-radius:
            9px;

        font-size:
            13px;

    }

}


/* =========================================================
   VERY SMALL MOBILE
   ========================================================= */

@media (max-width: 380px) {

    .sb-common-menu-wrapper {

        right:
            11px;

    }


    .sb-common-menu {

        width:
            215px;

    }

}


/* =========================================================
   REDUCED MOTION
   ========================================================= */


</style>

<style>
    .seller-title-hero {
        position: relative !important;
        display: flex !important;
        width: 100% !important;
        max-width: none !important;
        box-sizing: border-box !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 20px !important;
        min-width: 0;
        min-height: 100px;
        margin-bottom: 22px !important;
        padding: clamp(18px, 2.5vw, 26px) !important;
        overflow: hidden !important;
        border: 1px solid rgba(196,190,255,.38) !important;
        border-radius: 20px !important;
        color: #f8faff !important;
        background: radial-gradient(ellipse at 92% 0%, rgba(159,138,255,.32), transparent 40%), linear-gradient(115deg,#101F50 0%,#283879 48%,#5143A2 100%) !important;
        box-shadow: 0 16px 36px rgba(35,34,105,.22), inset 0 1px 0 rgba(255,255,255,.16) !important;
    }
    .seller-title-hero::before,
    .seller-title-hero::after,
    .profile-page .card::before,
    .seller-layout-content .card::before,
    .seller-page-content .card::before,
    .sb-edit-product-page .ep-header::before,
    .sb-products-page .sb-products-header::before,
    .payment-page .summary-card.received::before,
    .payment-page .filter-card::before,
    .payment-page .payment-row::before,
    .payment-detail-page .hero-card::before,
    .payment-detail-page .detail-card::before {
        display: none !important;
        content: none !important;
    }
    .seller-title-hero > * { position: relative; z-index: 1; min-width: 0; }
    .seller-title-hero h1,
    .seller-title-hero h2 {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        margin: 0 !important;
        color: #fff !important;
        font-size: clamp(1.25rem,2.2vw,1.8rem) !important;
        font-weight: 850 !important;
        line-height: 1.25 !important;
        letter-spacing: -.035em !important;
        overflow-wrap: anywhere;
    }
    .seller-title-hero h1 span:not(.seller-title-emoji),
    .seller-title-hero h2 span:not(.seller-title-emoji) {
        color: #f8faff !important;
        -webkit-text-fill-color: #f8faff !important;
        background: none !important;
    }
    .seller-title-hero .seller-title-emoji {
        display: inline-grid;
        width: 50px;
        height: 50px;
        flex: 0 0 50px;
        place-items: center;
        border: 1px solid rgba(232,226,255,.34);
        border-radius: 15px;
        background: linear-gradient(145deg,rgba(255,255,255,.23),rgba(255,255,255,.08));
        box-shadow: inset 0 1px 0 rgba(255,255,255,.24),0 7px 18px rgba(5,13,43,.2);
        font-family: "Apple Color Emoji","Segoe UI Emoji","Noto Color Emoji",sans-serif;
        font-size: 29px;
        line-height: 1;
    }
    .seller-title-hero p,
    .seller-title-hero .sb-page-subtitle,
    .seller-title-hero .settings-subtitle,
    .seller-title-hero .payment-subtitle,
    .seller-title-hero .sr-description {
        position: relative;
        z-index: 1;
        margin: 7px 0 0 !important;
        color: #D2D9F3 !important;
        font-size: .84rem;
        line-height: 1.55;
    }
    .seller-title-hero .sb-eyebrow,
    .seller-title-hero .header-eyebrow,
    .seller-title-hero .hero-eyebrow,
    .seller-title-hero .title-card-eyebrow,
    .seller-title-hero .settings-kicker { color: #DCE5FF !important; }
    .seller-title-hero .title-card-content p,
    .seller-title-hero .payment-subtitle { color: #DCE5FF !important; }
    .seller-title-hero .payment-subtitle strong { color: #fff !important; }
    .seller-title-hero :is([class*="subtitle"], [class*="description"]) { color: #DCE5FF !important; }
    .seller-title-hero .bank-step,
    .seller-title-hero .bd-step { color: #DCE5FF !important; }
    .seller-title-hero .account-live {
        border-color: rgba(203,255,226,.34) !important;
        background: rgba(20,125,87,.28) !important;
        color: #E7FFF2 !important;
    }
    .payment-page .summary-card {
        border: 1px solid rgba(139,157,190,.24) !important;
        background: linear-gradient(145deg,#fff 0%,#f8faff 100%) !important;
        box-shadow: 0 10px 28px rgba(25,43,82,.07), inset 0 1px 0 #fff !important;
    }
    .payment-page .summary-label { color: #53627b !important; }
    .payment-page .summary-value { color: #17243d !important; }
    .payment-page .summary-card.received .summary-value { color: #2857d8 !important; }
    .payment-page .summary-icon { color: rgba(54,83,145,.42) !important; }
    .payment-page .filter-card {
        border-color: rgba(139,157,190,.25) !important;
        box-shadow: 0 12px 30px rgba(25,43,82,.065) !important;
    }
    .payment-page .filter-title { color: #233451 !important; }
    .payment-page .filter-hint { color: #60718c !important; }
    .seller-title-hero .header-left,
    .seller-title-hero .hero-content,
    .seller-title-hero .title-card-left,
    .seller-title-hero .settings-hero-left,
    .seller-title-hero .payment-heading-wrap,
    .seller-title-hero .sr-hero-content { min-width: 0; }
    .seller-title-hero .title-card-right,
    .seller-title-hero .settings-profile,
    .seller-title-hero .header-status,
    .seller-title-hero .sb-header-status { color: #eef0ff !important; }
    .seller-title-hero img { max-width: 100%; }
    @media(max-width:700px) {
        .seller-title-hero { align-items: flex-start !important; flex-wrap: wrap; gap: 12px !important; min-height: auto; }
        .seller-title-hero h1,
        .seller-title-hero h2 { font-size: 1.28rem !important; }
        .seller-title-hero .seller-title-emoji { width: 44px; height: 44px; flex-basis: 44px; border-radius: 13px; font-size: 25px; }
    }
</style>


<!-- ========================================================
     GLOBAL SELLER MENU
     ======================================================== -->

<div
    class="sb-common-menu-wrapper"
    id="sbCommonMenuWrapper"
>

    <!-- ====================================================
         PREMIUM MENU BUTTON
         Real Font Awesome icon
         ==================================================== -->

    <button
        type="button"
        class="sb-common-menu-button"
        id="sbCommonMenuButton"
        aria-label="Seller Menu"
        aria-expanded="false"
        aria-controls="sbCommonMenu"
    >

        <span
            class="sb-menu-logo"
            aria-hidden="true"
        ></span>

    </button>


    <!-- ====================================================
         MENU PANEL
         ==================================================== -->

    <div
        class="sb-common-menu"
        id="sbCommonMenu"
    >


        <!-- ==================================================
             DASHBOARD
             ================================================== -->

        <a
            href="{{ route('seller.dashboard') }}"
            class="{{ request()->routeIs('seller.dashboard') ? 'sb-menu-active' : '' }}"
        >

            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-gauge-high" aria-hidden="true"></i>
            </span>

            <span>Dashboard</span>

        </a>


        <!-- ==================================================
             PRODUCTS
             ================================================== -->

        <a
            href="{{ route('seller.products.index') }}"
            class="{{ request()->routeIs('seller.products.*', 'seller.products', 'seller.product.edit') ? 'sb-menu-active' : '' }}"
        >

            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-box-open" aria-hidden="true"></i>
            </span>

            <span>My Products</span>

        </a>


        <!-- ==================================================
             ADD PRODUCT
             ================================================== -->

        <a
            href="{{ route('seller.product.add') }}"
            class="{{ request()->routeIs('seller.product.add') ? 'sb-menu-active' : '' }}"
        >

            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-circle-plus" aria-hidden="true"></i>
            </span>

            <span>Add Product</span>

        </a>


        <!-- ==================================================
             DIVIDER
             ================================================== -->

        <div class="sb-common-menu-divider"></div>


        <!-- ==================================================
             ORDERS
             ================================================== -->

        <a
            href="{{ route('seller.orders.index') }}"
            class="{{ request()->routeIs('seller.orders.*') ? 'sb-menu-active' : '' }}"
        >

            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
            </span>

            <span>Orders</span>

        </a>

        <a href="{{ route('seller.delivery-boys.index') }}" class="{{ request()->routeIs('seller.delivery-boys.*') ? 'sb-menu-active' : '' }}">
            <span class="sb-common-menu-icon"><i class="fa-solid fa-motorcycle" aria-hidden="true"></i></span>
            <span>Delivery Boy</span>
        </a>

        <a href="{{ route('seller.returns.index') }}" class="{{ request()->routeIs('seller.returns.*') ? 'sb-menu-active' : '' }}">
            <span class="sb-common-menu-icon"><i class="fa-solid fa-arrow-rotate-left" aria-hidden="true"></i></span>
            <span>Returns &amp; Cancellations</span>
        </a>



        <!-- ==================================================
             PAYMENTS
             ================================================== -->

        <a
            href="{{ route('seller.payments.index') }}"
            class="{{ request()->routeIs('seller.payments.index', 'seller.payments.show', 'seller.payments.receipt', 'seller.payments.premium-receipt') ? 'sb-menu-active' : '' }}"
        >

            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-wallet" aria-hidden="true"></i>
            </span>

            <span>Payments</span>

        </a>

        <a
            href="{{ route('seller.payments.upi-reviews') }}"
            class="{{ request()->routeIs('seller.payments.upi-reviews') ? 'sb-menu-active' : '' }}"
        >

            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-money-bill-transfer" aria-hidden="true"></i>
            </span>

            <span>UPI Review</span>

        </a>


        <!-- ==================================================
             DIVIDER
             ================================================== -->

        <div class="sb-common-menu-divider"></div>


        <!-- ==================================================
             PROFILE
             ================================================== -->

        <a
            href="{{ route('seller.profile') }}"
            class="{{ request()->routeIs('seller.profile') ? 'sb-menu-active' : '' }}"
        >

            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-user" aria-hidden="true"></i>
            </span>

            <span>Profile</span>

        </a>


        <!-- ==================================================
             SETTINGS
             ================================================== -->

        <a
            href="{{ route('seller.settings') }}"
            class="{{ request()->routeIs('seller.settings') ? 'sb-menu-active' : '' }}"
        >

            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-gear" aria-hidden="true"></i>
            </span>

            <span>Settings</span>

        </a>


        <!-- ==================================================
             DIVIDER
             ================================================== -->

        <div class="sb-common-menu-divider"></div>


        <!-- ==================================================
             LOGOUT
             ================================================== -->

        <form
            method="POST"
            action="{{ route('seller.logout') }}"
            style="margin:0; padding:0;"
        >

            @csrf

            <button
                type="submit"
                class="sb-common-menu-logout"
            >

                <span class="sb-common-menu-icon">
                    <i
                        class="fa-solid fa-right-from-bracket"
                        aria-hidden="true"
                    ></i>
                </span>

                <span>Logout</span>

            </button>

        </form>


    </div>

</div>


<script>
(function () {

    'use strict';


    function initSellerCommonMenu() {

        const button =
            document.getElementById(
                'sbCommonMenuButton'
            );

        const menu =
            document.getElementById(
                'sbCommonMenu'
            );

        const wrapper =
            document.getElementById(
                'sbCommonMenuWrapper'
            );


        if (
            !button ||
            !menu ||
            !wrapper
        ) {

            return;

        }


        /* =================================================
           PREVENT DUPLICATE INITIALIZATION
           ================================================= */

        if (
            wrapper.dataset.initialized === 'true'
        ) {

            return;

        }

        wrapper.dataset.initialized = 'true';


        /* =================================================
           CLOSE MENU
           ================================================= */

        function closeMenu() {

            menu.classList.remove(
                'active'
            );

            button.classList.remove(
                'is-open'
            );

            button.setAttribute(
                'aria-expanded',
                'false'
            );

        }


        /* =================================================
           OPEN MENU
           ================================================= */

        function openMenu() {

            menu.classList.add(
                'active'
            );

            button.classList.add(
                'is-open'
            );

            button.setAttribute(
                'aria-expanded',
                'true'
            );

        }


        /* =================================================
           TOGGLE MENU
           ================================================= */

        button.addEventListener(
            'click',
            function (event) {

                event.preventDefault();

                event.stopPropagation();


                const isOpen =
                    menu.classList.contains(
                        'active'
                    );


                if (isOpen) {

                    closeMenu();

                } else {

                    openMenu();

                }

            }
        );


        /* =================================================
           MENU CLICK
           ================================================= */

        menu.addEventListener(
            'click',
            function (event) {

                event.stopPropagation();

            }
        );


        /* =================================================
           OUTSIDE CLICK
           ================================================= */

        document.addEventListener(
            'click',
            function (event) {

                if (
                    !wrapper.contains(
                        event.target
                    )
                ) {

                    closeMenu();

                }

            }
        );


        /* =================================================
           ESCAPE KEY
           ================================================= */

        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key === 'Escape'
                ) {

                    closeMenu();

                }

            }
        );


        /* =================================================
           CLOSE AFTER LINK NAVIGATION
           ================================================= */

        menu.querySelectorAll(
            'a'
        ).forEach(
            function (link) {

                link.addEventListener(
                    'click',
                    function () {

                        closeMenu();

                    }
                );

            }
        );


        /* =================================================
           LOGOUT SUBMIT
           ================================================= */

        const logoutForm =
            menu.querySelector(
                'form'
            );


        if (logoutForm) {

            logoutForm.addEventListener(
                'submit',
                function () {

                    closeMenu();

                }
            );

        }

    }


    /* =====================================================
       INITIALIZE
       ===================================================== */

    if (
        document.readyState === 'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            initSellerCommonMenu,
            {
                once: true
            }
        );

    } else {

        initSellerCommonMenu();

    }

})();
</script>
