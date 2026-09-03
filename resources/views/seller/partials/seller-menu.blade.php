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

    font-family: 'Poppins', sans-serif;
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

    border: 1px solid rgba(255, 255, 255, .10);
    border-radius: 15px;

    background:
        linear-gradient(
            145deg,
            #26364d 0%,
            #0b1220 100%
        );

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;

    box-shadow:
        0 12px 30px rgba(0, 0, 0, .28),
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
        rgba(0, 255, 153, .45);

    background:
        linear-gradient(
            145deg,
            #30445f 0%,
            #0d1728 100%
        );

    box-shadow:
        0 16px 36px rgba(0, 0, 0, .34),
        0 0 0 4px rgba(0, 255, 153, .06),
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

    color: #ffffff;

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
        #00ff99;

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
        1px solid rgba(0, 255, 153, .16);

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
        'Poppins',
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
            rgba(0, 255, 153, .12),
            rgba(0, 255, 153, .035)
        );

    color:
        #00ff99;

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
        #00ff99;

    background:
        rgba(0, 255, 153, .10);

    border-color:
        rgba(0, 255, 153, .18);

    transform:
        scale(1.04);

}


/* =========================================================
   ACTIVE MENU ITEM
   ========================================================= */

.sb-common-menu a.sb-menu-active {

    color:
        #00ff99;

    background:
        linear-gradient(
            90deg,
            rgba(0, 255, 153, .15),
            rgba(0, 255, 153, .035)
        );

    box-shadow:
        inset 3px 0 #00ff99;

}


/* Active icon */

.sb-common-menu a.sb-menu-active
.sb-common-menu-icon {

    color:
        #00ff99;

    background:
        rgba(0, 255, 153, .11);

    border-color:
        rgba(0, 255, 153, .20);

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
        2px solid #00ff99;

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

@media (prefers-reduced-motion: reduce) {

    .sb-common-menu,
    .sb-common-menu-button,
    .sb-menu-logo,
    .sb-common-menu a,
    .sb-common-menu button,
    .sb-common-menu-icon {

        transition:
            none !important;

    }

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


        <!-- ==================================================
             PAYMENTS
             ================================================== -->

        <a
            href="{{ route('seller.payments.index') }}"
            class="{{ request()->routeIs('seller.payments.*') ? 'sb-menu-active' : '' }}"
        >

            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-wallet" aria-hidden="true"></i>
            </span>

            <span>Payments</span>

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
