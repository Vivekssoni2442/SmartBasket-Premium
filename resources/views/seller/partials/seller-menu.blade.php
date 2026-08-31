<style>

.sb-common-menu-wrapper {
    position: fixed;
    top: 20px;
    right: 22px;
    z-index: 99999;
}

.sb-common-menu-button {
    width: 50px;
    height: 50px;
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 15px;
    background: rgba(15,23,42,.96);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 25px;
    transition: .25s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,.35);
}

.sb-common-menu-button:hover {
    color: #00ff99;
    border-color: rgba(0,255,153,.45);
    transform: translateY(-2px);
}

.sb-common-menu {
    position: absolute;
    top: 60px;
    right: 0;
    width: 245px;
    padding: 9px;
    background: #0f172a;
    border: 1px solid rgba(0,255,153,.18);
    border-radius: 20px;
    box-shadow: 0 25px 60px rgba(0,0,0,.60);
    display: none;
}

.sb-common-menu.active {
    display: block;
}

.sb-common-menu a,
.sb-common-menu button {
    width: 100%;
    min-height: 46px;
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 11px 14px;
    border: 0;
    border-radius: 13px;
    background: transparent;
    color: #fff;
    text-decoration: none;
    font-family: inherit;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: .2s ease;
    text-align: left;
}

.sb-common-menu a:hover,
.sb-common-menu button:hover {
    background: rgba(0,255,153,.10);
    color: #00ff99;
    transform: translateX(3px);
}

.sb-common-menu-icon {
    width: 25px;
    min-width: 25px;
    text-align: center;
    font-size: 16px;
}

.sb-common-menu a.sb-menu-active {
    color: #00ff99;
    background: linear-gradient(
        90deg,
        rgba(0,255,153,.14),
        rgba(0,255,153,.035)
    );
    box-shadow: inset 3px 0 #00ff99;
}

.sb-common-menu-divider {
    height: 1px;
    background: rgba(255,255,255,.08);
    margin: 7px 4px;
}

.sb-common-menu-logout {
    color: #ff7777 !important;
}

.sb-common-menu-logout:hover {
    background: rgba(239,68,68,.12) !important;
    color: #ff6b6b !important;
}

@media(max-width:600px) {

    .sb-common-menu-wrapper {
        top: 14px;
        right: 14px;
    }

    .sb-common-menu-button {
        width: 46px;
        height: 46px;
    }

    .sb-common-menu {
        width: 220px;
    }

}

</style>


<div class="sb-common-menu-wrapper">

    <button
        type="button"
        class="sb-common-menu-button"
        id="sbCommonMenuButton"
        aria-label="Seller Menu"
        aria-expanded="false"
    >
        <span id="sbCommonMenuIcon">⋮</span>
    </button>


    <div
        class="sb-common-menu"
        id="sbCommonMenu"
    >

        <a
            href="{{ route('seller.dashboard') }}"
            class="{{ request()->routeIs('seller.dashboard') ? 'sb-menu-active' : '' }}"
        >
            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-chart-line"></i>
            </span>
            <span>Dashboard</span>
        </a>


        <a
            href="{{ route('seller.products.index') }}"
            class="{{ request()->routeIs('seller.products.*', 'seller.products', 'seller.product.edit') ? 'sb-menu-active' : '' }}"
        >
            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-box"></i>
            </span>
            <span>My Products</span>
        </a>


        <a
            href="{{ route('seller.product.add') }}"
            class="{{ request()->routeIs('seller.product.add') ? 'sb-menu-active' : '' }}"
        >
            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-plus"></i>
            </span>
            <span>Add Product</span>
        </a>


        <div class="sb-common-menu-divider"></div>


        <a
            href="{{ route('seller.orders.index') }}"
            class="{{ request()->routeIs('seller.orders.*') ? 'sb-menu-active' : '' }}"
        >
            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-cart-shopping"></i>
            </span>
            <span>Orders</span>
        </a>


        <a
            href="{{ route('seller.payments.index') }}"
            class="{{ request()->routeIs('seller.payments.*') ? 'sb-menu-active' : '' }}"
        >
            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-credit-card"></i>
            </span>
            <span>Payments</span>
        </a>


        <div class="sb-common-menu-divider"></div>


        <a
            href="{{ route('seller.profile') }}"
            class="{{ request()->routeIs('seller.profile') ? 'sb-menu-active' : '' }}"
        >
            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-user"></i>
            </span>
            <span>Profile</span>
        </a>


        <a
            href="{{ route('seller.settings') }}"
            class="{{ request()->routeIs('seller.settings') ? 'sb-menu-active' : '' }}"
        >
            <span class="sb-common-menu-icon">
                <i class="fa-solid fa-gear"></i>
            </span>
            <span>Settings</span>
        </a>


        <div class="sb-common-menu-divider"></div>


        <form
            method="POST"
            action="{{ route('seller.logout') }}"
            style="margin:0;"
        >

            @csrf

            <button
                type="submit"
                class="sb-common-menu-logout"
            >

                <span class="sb-common-menu-icon">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </span>

                <span>
                    Logout
                </span>

            </button>

        </form>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const button =
        document.getElementById('sbCommonMenuButton');

    const menu =
        document.getElementById('sbCommonMenu');

    const icon =
        document.getElementById('sbCommonMenuIcon');


    if (!button || !menu || !icon) {
        return;
    }


    button.addEventListener('click', function (event) {

        event.stopPropagation();

        const opened =
            menu.classList.contains('active');

        menu.classList.toggle(
            'active',
            !opened
        );

        button.setAttribute(
            'aria-expanded',
            String(!opened)
        );

        icon.textContent =
            opened ? '⋮' : '×';

    });


    menu.addEventListener('click', function (event) {

        event.stopPropagation();

    });


    document.addEventListener('click', function () {

        menu.classList.remove('active');

        button.setAttribute(
            'aria-expanded',
            'false'
        );

        icon.textContent = '⋮';

    });


    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {

            menu.classList.remove('active');

            button.setAttribute(
                'aria-expanded',
                'false'
            );

            icon.textContent = '⋮';

        }

    });

});

</script>