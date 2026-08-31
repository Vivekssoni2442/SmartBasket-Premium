@extends('seller.partials.premium-layout')

@section('title', 'Seller Dashboard')

@section('content')

<style>
/* =========================================================
   SMART BASKET — SELLER DASHBOARD
   PREMIUM LIGHT SELLER CENTER
========================================================= */

.seller-dashboard {
    min-height: 100vh;
    padding: 32px;
    color: #172033;

    background:
        radial-gradient(
            circle at 5% 0%,
            rgba(0, 255, 153, .08),
            transparent 25%
        ),
        radial-gradient(
            circle at 95% 5%,
            rgba(59, 130, 246, .06),
            transparent 25%
        ),
        linear-gradient(
            135deg,
            #f8fafc 0%,
            #f4f7fb 50%,
            #eef3f8 100%
        );
}

.seller-dashboard *,
.seller-dashboard *::before,
.seller-dashboard *::after {
    box-sizing: border-box;
}


/* =========================================================
   HEADER
========================================================= */

.sd-top {
    position: relative;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 24px;
    margin-bottom: 30px;
}

.sd-title h1 {
    margin: 0;

    color: #111827;

    font-size: 32px;
    line-height: 1.15;
    font-weight: 850;

    letter-spacing: -.8px;
}

.sd-title h1 span {
    color: #00a968;

    text-shadow:
        0 0 22px rgba(0, 169, 104, .12);
}

.sd-subtitle {
    margin-top: 8px;

    color: #64748b;

    font-size: 13px;
    line-height: 1.5;
}


/* =========================================================
   HEADER RIGHT
========================================================= */

.sd-header-right {
    display: flex;
    align-items: center;
    gap: 12px;
}


/* =========================================================
   ACCOUNT STATUS
========================================================= */

.sd-status {
    display: inline-flex;
    align-items: center;
    gap: 9px;

    min-height: 46px;

    padding: 0 16px;

    border: 1px solid rgba(0, 169, 104, .16);
    border-radius: 14px;

    background:
        rgba(255, 255, 255, .82);

    color: #087a4c;

    font-size: 11px;
    font-weight: 750;

    white-space: nowrap;

    box-shadow:
        0 8px 24px rgba(15, 23, 42, .06),
        inset 0 1px 0 rgba(255, 255, 255, .9);
}

.sd-status-dot {
    width: 8px;
    height: 8px;

    flex-shrink: 0;

    border-radius: 50%;

    background: #00c978;

    box-shadow:
        0 0 0 4px rgba(0, 201, 120, .10),
        0 0 12px rgba(0, 201, 120, .30);
}


/* =========================================================
   SELLER CENTER
========================================================= */

.seller-center-wrap {
    position: relative;
}

.seller-center-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;

    min-height: 46px;

    padding: 0 17px;

    border: 1px solid #dce4ec;
    border-radius: 14px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #f8fafc
        );

    color: #172033;

    font-size: 12px;
    font-weight: 800;

    cursor: pointer;

    box-shadow:
        0 10px 25px rgba(15, 23, 42, .07),
        inset 0 1px 0 #ffffff;

    transition:
        transform .25s ease,
        border-color .25s ease,
        box-shadow .25s ease,
        background .25s ease;
}

.seller-center-btn:hover {
    transform: translateY(-2px);

    border-color: rgba(0, 169, 104, .28);

    background: #ffffff;

    box-shadow:
        0 15px 35px rgba(15, 23, 42, .10),
        0 0 22px rgba(0, 169, 104, .05);
}

.seller-center-btn > i:first-child {
    color: #00a968;

    font-size: 15px;
}

.seller-center-arrow {
    margin-left: 2px;

    color: #94a3b8;

    font-size: 9px;

    transition:
        transform .25s ease;
}

.seller-center-wrap.active
.seller-center-arrow {
    transform: rotate(180deg);
}


/* =========================================================
   SELLER CENTER MENU
========================================================= */

.seller-center-menu {
    position: absolute;

    top: calc(100% + 12px);
    right: 0;

    z-index: 99999;

    width: 310px;

    padding: 10px;

    border: 1px solid #e2e8f0;
    border-radius: 20px;

    background:
        rgba(255, 255, 255, .98);

    backdrop-filter: blur(22px);

    box-shadow:
        0 25px 65px rgba(15, 23, 42, .16),
        0 4px 15px rgba(15, 23, 42, .05);

    opacity: 0;
    visibility: hidden;

    transform:
        translateY(-8px)
        scale(.97);

    transform-origin: top right;

    transition:
        opacity .22s ease,
        visibility .22s ease,
        transform .22s ease;
}

.seller-center-wrap.active
.seller-center-menu {
    opacity: 1;
    visibility: visible;

    transform:
        translateY(0)
        scale(1);
}


/* =========================================================
   SELLER CENTER HEADER
========================================================= */

.seller-center-header {
    padding: 14px 13px 13px;

    margin-bottom: 7px;

    border-bottom:
        1px solid #edf1f5;
}

.seller-center-header-title {
    color: #172033;

    font-size: 14px;
    font-weight: 850;
}

.seller-center-header-title i {
    margin-right: 7px;

    color: #00a968;
}

.seller-center-header-text {
    margin-top: 5px;

    color: #94a3b8;

    font-size: 10px;
}


/* =========================================================
   SELLER CENTER ITEM
========================================================= */

.seller-center-item {
    display: flex;
    align-items: center;
    gap: 12px;

    width: 100%;
    min-height: 58px;

    padding: 8px 11px;

    border-radius: 13px;

    color: #475569;

    text-decoration: none;

    transition:
        background .2s ease,
        color .2s ease,
        transform .2s ease;
}

.seller-center-item:hover {
    background:
        rgba(0, 169, 104, .055);

    color: #172033;

    transform: translateX(3px);
}

.seller-center-item-icon {
    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border:
        1px solid rgba(0, 169, 104, .13);

    border-radius: 11px;

    background:
        rgba(0, 169, 104, .055);

    color: #00a968;

    font-size: 13px;
}

.seller-center-item-content {
    flex: 1;

    min-width: 0;
}

.seller-center-item-title {
    color: #1e293b;

    font-size: 11px;
    font-weight: 800;
}

.seller-center-item-text {
    margin-top: 3px;

    color: #94a3b8;

    font-size: 9px;
}

.seller-center-item-arrow {
    color: #cbd5e1;

    font-size: 9px;

    transition: .2s ease;
}

.seller-center-item:hover
.seller-center-item-arrow {
    color: #00a968;
}


/* =========================================================
   KYC CARD
========================================================= */

.sd-kyc-card {
    position: relative;

    overflow: hidden;

    margin: 0 0 28px;
    padding: 22px 24px;

    border: 1px solid #dfe7ee;
    border-radius: 21px;

    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.98),
            rgba(248,250,252,.95)
        );

    box-shadow:
        0 16px 38px rgba(15, 23, 42, .07),
        inset 0 1px 0 #ffffff;
}

.sd-kyc-card::after {
    content: "";

    position: absolute;

    right: -70px;
    top: -70px;

    width: 180px;
    height: 180px;

    border-radius: 50%;

    background: #00c978;

    opacity: .045;

    filter: blur(25px);

    pointer-events: none;
}

.sd-kyc-header {
    position: relative;
    z-index: 1;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 16px;

    margin-bottom: 16px;
}

.sd-kyc-title-wrap {
    display: flex;
    align-items: center;
    gap: 14px;
}

.sd-kyc-badge {
    width: 44px;
    height: 44px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 13px;

    background:
        rgba(0, 169, 104, .07);

    border:
        1px solid rgba(0, 169, 104, .15);

    color: #00a968;

    box-shadow:
        0 8px 20px rgba(0, 169, 104, .07);
}

.sd-kyc-title {
    color: #172033;

    font-size: 18px;
    font-weight: 850;

    letter-spacing: -.4px;
}

.sd-kyc-subtitle {
    color: #94a3b8;

    font-size: 12px;

    margin-top: 2px;
}

.sd-kyc-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 8px 12px;

    border-radius: 999px;

    background:
        rgba(59, 130, 246, .08);

    border:
        1px solid rgba(59, 130, 246, .16);

    color: #2563eb;

    font-size: 10px;
    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .08em;
}

.sd-kyc-body {
    position: relative;
    z-index: 1;

    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 12px;

    margin-bottom: 16px;
    padding-top: 14px;

    border-top:
        1px solid #edf1f5;
}

.sd-kyc-label {
    color: #94a3b8;

    font-size: 11px;

    text-transform: uppercase;

    letter-spacing: .08em;
}

.sd-kyc-progress {
    color: #172033;

    font-size: 15px;
    font-weight: 800;
}

.sd-kyc-button {
    position: relative;
    z-index: 1;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 44px;

    padding: 0 18px;

    border-radius: 12px;

    background:
        linear-gradient(
            135deg,
            #00b875,
            #00d98a
        );

    color: #ffffff !important;

    font-size: 12px;
    font-weight: 850;

    text-decoration: none;

    box-shadow:
        0 10px 25px rgba(0, 201, 120, .18);

    transition:
        transform .22s ease,
        box-shadow .22s ease,
        filter .22s ease;
}

.sd-kyc-button:hover {
    transform: translateY(-2px);

    filter: brightness(1.03);

    color: #ffffff !important;

    box-shadow:
        0 15px 30px rgba(0, 201, 120, .24);
}


/* =========================================================
   QUICK ACTIONS
========================================================= */

.sd-actions {
    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 16px;

    margin-bottom: 24px;
}

.sd-action {
    position: relative;

    overflow: hidden;

    min-height: 145px;

    padding: 20px;

    border:
        1px solid #e1e8ef;

    border-radius: 20px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #f8fafc
        );

    color: #172033;

    text-decoration: none;

    box-shadow:
        0 14px 32px rgba(15, 23, 42, .06),
        inset 0 1px 0 #ffffff;

    transition:
        transform .25s ease,
        border-color .25s ease,
        box-shadow .25s ease;
}

.sd-action::before {
    content: "";

    position: absolute;

    top: -50px;
    right: -45px;

    width: 120px;
    height: 120px;

    border-radius: 50%;

    background: #00c978;

    opacity: .055;

    filter: blur(25px);

    pointer-events: none;
}

.sd-action:hover {
    transform: translateY(-5px);

    border-color:
        rgba(0, 169, 104, .25);

    color: #172033;

    box-shadow:
        0 22px 45px rgba(15, 23, 42, .10),
        0 0 25px rgba(0, 169, 104, .04);
}

.sd-action-icon {
    width: 46px;
    height: 46px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 16px;

    border:
        1px solid rgba(0, 169, 104, .14);

    border-radius: 14px;

    background:
        rgba(0, 169, 104, .06);

    color: #00a968;

    font-size: 17px;
}

.sd-action-title {
    color: #172033;

    font-size: 14px;
    font-weight: 800;
}

.sd-action-text {
    margin-top: 5px;

    color: #94a3b8;

    font-size: 11px;
}


/* =========================================================
   STATISTICS
========================================================= */

.sd-stats {
    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 18px;
}

.sd-stat {
    position: relative;

    overflow: hidden;

    min-height: 165px;

    padding: 22px;

    border:
        1px solid #e1e8ef;

    border-radius: 22px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #f8fafc
        );

    box-shadow:
        0 16px 36px rgba(15, 23, 42, .06),
        inset 0 1px 0 #ffffff;

    transition:
        transform .28s ease,
        border-color .28s ease,
        box-shadow .28s ease;
}

.sd-stat:hover {
    transform: translateY(-5px);

    border-color:
        rgba(0, 169, 104, .22);

    box-shadow:
        0 24px 48px rgba(15, 23, 42, .10),
        0 0 28px rgba(0, 169, 104, .04);
}

.sd-stat::after {
    content: "";

    position: absolute;

    right: -50px;
    bottom: -50px;

    width: 140px;
    height: 140px;

    border-radius: 50%;

    background: #00c978;

    opacity: .045;

    filter: blur(25px);

    pointer-events: none;
}

.sd-stat-icon {
    width: 47px;
    height: 47px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 18px;

    border:
        1px solid rgba(0, 169, 104, .14);

    border-radius: 14px;

    background:
        rgba(0, 169, 104, .06);

    color: #00a968;

    font-size: 18px;
}

.sd-stat-number {
    position: relative;
    z-index: 1;

    color: #111827;

    font-size: 28px;
    line-height: 1;

    font-weight: 850;

    letter-spacing: -.5px;
}

.sd-stat-label {
    position: relative;
    z-index: 1;

    margin-top: 9px;

    color: #94a3b8;

    font-size: 11px;
    font-weight: 650;
}


/* =========================================================
   PRODUCTS
========================================================= */

.sd-products {
    margin-top: 38px;
}

.sd-section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;

    margin-bottom: 20px;
}

.sd-section-title {
    color: #111827;

    font-size: 21px;
    font-weight: 850;

    letter-spacing: -.3px;
}

.sd-section-subtitle {
    margin-top: 5px;

    color: #94a3b8;

    font-size: 11px;
}

.sd-add {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 8px;

    padding: 12px 18px;

    border: 0;
    border-radius: 13px;

    background:
        linear-gradient(
            135deg,
            #00b875,
            #00d98a
        );

    color: #ffffff !important;

    font-size: 12px;
    font-weight: 850;

    text-decoration: none;

    box-shadow:
        0 10px 25px rgba(0, 201, 120, .14);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        filter .25s ease;
}

.sd-add:hover {
    transform: translateY(-2px);

    color: #ffffff !important;

    filter: brightness(1.03);

    box-shadow:
        0 15px 35px rgba(0, 201, 120, .22);
}


/* =========================================================
   PRODUCT GRID
========================================================= */

.sd-product-grid {
    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 18px;
}

.sd-product {
    overflow: hidden;

    min-width: 0;

    border:
        1px solid #e1e8ef;

    border-radius: 20px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #f8fafc
        );

    box-shadow:
        0 15px 35px rgba(15, 23, 42, .06),
        inset 0 1px 0 #ffffff;

    transition:
        transform .3s ease,
        border-color .3s ease,
        box-shadow .3s ease;
}

.sd-product:hover {
    transform: translateY(-6px);

    border-color:
        rgba(0, 169, 104, .22);

    box-shadow:
        0 25px 50px rgba(15, 23, 42, .10),
        0 0 25px rgba(0, 169, 104, .04);
}

.sd-product-image {
    position: relative;

    height: 195px;

    overflow: hidden;

    background:
        linear-gradient(
            135deg,
            #f1f5f9,
            #e9eef4
        );
}

.sd-product-image::after {
    content: "";

    position: absolute;

    inset: 0;

    background:
        linear-gradient(
            to bottom,
            transparent 60%,
            rgba(15, 23, 42, .10)
        );

    pointer-events: none;
}

.sd-product-image img {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;

    transition:
        transform .45s ease;
}

.sd-product:hover
.sd-product-image img {
    transform: scale(1.06);
}

.sd-product-body {
    padding: 17px;
}

.sd-product-name {
    overflow: hidden;

    color: #172033;

    font-size: 14px;
    font-weight: 800;

    white-space: nowrap;
    text-overflow: ellipsis;
}

.sd-product-category {
    margin-top: 5px;

    overflow: hidden;

    color: #94a3b8;

    font-size: 10px;

    white-space: nowrap;
    text-overflow: ellipsis;
}

.sd-product-price {
    margin-top: 12px;

    color: #00a968;

    font-size: 19px;
    font-weight: 850;
}

.sd-product-stock {
    margin-top: 6px;

    color: #64748b;

    font-size: 10px;
}

.sd-product-stock i {
    margin-right: 3px;

    color: #00b875;
}

.sd-product-actions {
    display: flex;

    gap: 8px;

    margin-top: 15px;
}

.sd-edit,
.sd-delete {
    flex: 1;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 5px;

    min-height: 37px;

    padding: 8px 10px;

    border-radius: 10px;

    font-size: 10px;
    font-weight: 750;

    text-decoration: none;

    cursor: pointer;

    transition: .22s ease;
}

.sd-edit {
    border:
        1px solid rgba(245, 158, 11, .20);

    background:
        rgba(245, 158, 11, .07);

    color: #d97706;
}

.sd-edit:hover {
    background:
        rgba(245, 158, 11, .13);

    border-color:
        rgba(245, 158, 11, .35);

    color: #b45309;
}

.sd-delete {
    width: 100%;

    border:
        1px solid rgba(239, 68, 68, .18);

    background:
        rgba(239, 68, 68, .06);

    color: #dc2626;
}

.sd-delete:hover {
    background:
        rgba(239, 68, 68, .12);

    border-color:
        rgba(239, 68, 68, .32);

    color: #b91c1c;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.sd-empty {
    grid-column: 1 / -1;

    padding: 75px 25px;

    text-align: center;

    border:
        1px dashed #cbd5e1;

    border-radius: 23px;

    background:
        rgba(255, 255, 255, .70);
}

.sd-empty i {
    color: #94a3b8;

    font-size: 42px;
}

.sd-empty h3 {
    margin: 16px 0 0;

    color: #172033;

    font-size: 18px;
    font-weight: 800;
}

.sd-empty p {
    margin: 8px 0 22px;

    color: #94a3b8;

    font-size: 11px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1200px) {

    .sd-product-grid {
        grid-template-columns:
            repeat(3, minmax(0, 1fr));
    }

}

@media (max-width: 1050px) {

    .sd-actions,
    .sd-stats {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

}

@media (max-width: 768px) {

    .seller-dashboard {
        padding: 22px 15px;
    }

    .sd-top {
        align-items: flex-start;
    }

    .sd-title h1 {
        font-size: 25px;
    }

    .sd-subtitle {
        font-size: 11px;
    }

    .sd-header-right {
        align-items: flex-end;
    }

    .sd-status {
        display: none;
    }

    .seller-center-btn {
        min-height: 42px;

        padding: 0 13px;
    }

    .seller-center-btn span {
        display: none;
    }

    .seller-center-menu {
        right: 0;

        width: 280px;
    }

    .sd-product-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 12px;
    }

    .sd-product-image {
        height: 170px;
    }

}

@media (max-width: 560px) {

    .sd-top {
        gap: 10px;
    }

    .sd-actions,
    .sd-stats {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 10px;
    }

    .sd-action {
        min-height: 130px;

        padding: 15px;
    }

    .sd-action-icon {
        width: 40px;
        height: 40px;

        margin-bottom: 12px;
    }

    .sd-action-title {
        font-size: 12px;
    }

    .sd-action-text {
        font-size: 9px;
    }

    .sd-stat {
        min-height: 135px;

        padding: 16px;
    }

    .sd-stat-icon {
        width: 40px;
        height: 40px;

        margin-bottom: 14px;
    }

    .sd-stat-number {
        font-size: 21px;
    }

    .sd-stat-label {
        font-size: 9px;
    }

    .sd-section-head {
        align-items: flex-start;

        flex-direction: column;
    }

    .sd-add {
        width: 100%;
    }

    .sd-product-grid {
        grid-template-columns: 1fr;
    }

    .sd-product-image {
        height: 210px;
    }

    .seller-center-menu {
        width: calc(100vw - 30px);

        max-width: 300px;
    }

    .sd-kyc-card {
        padding: 18px;
    }

    .sd-kyc-header,
    .sd-kyc-body {
        flex-direction: column;

        align-items: flex-start;
    }

    .sd-kyc-status {
        align-self: flex-start;
    }

    .sd-kyc-button {
        width: 100%;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .sd-action,
    .sd-stat,
    .sd-product,
    .sd-product-image img,
    .sd-add,
    .sd-edit,
    .sd-delete,
    .seller-center-btn,
    .seller-center-menu,
    .seller-center-item,
    .sd-kyc-button {
        transition: none !important;
    }

}
</style>


<div class="seller-dashboard">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="sd-top">

        <div class="sd-title">

            <h1>
                Seller <span>Dashboard</span>
            </h1>

            <div class="sd-subtitle">
                Welcome back. Manage your SMART BASKET store from one place.
            </div>

        </div>


        <div class="sd-header-right">


            {{-- =================================================
                 SELLER CENTER
                 ONLY PROFILE + KYC
            ================================================== --}}

            <div
                class="seller-center-wrap"
                id="sellerCenterWrap"
            >

                <button
                    type="button"
                    class="seller-center-btn"
                    id="sellerCenterButton"
                    aria-expanded="false"
                    aria-haspopup="true"
                >

                    <i class="fa-solid fa-store"></i>

                    <span>
                        Seller Center
                    </span>

                    <i
                        class="fa-solid fa-chevron-down seller-center-arrow"
                    ></i>

                </button>


                <div
                    class="seller-center-menu"
                    id="sellerCenterMenu"
                >


                    {{-- =================================================
                         SELLER CENTER HEADER
                    ================================================== --}}

                    <div class="seller-center-header">

                        <div class="seller-center-header-title">

                            <i class="fa-solid fa-store"></i>

                            Seller Center

                        </div>

                        <div class="seller-center-header-text">

                            Manage your seller profile and verification

                        </div>

                    </div>


                    {{-- =================================================
                         MY PROFILE
                    ================================================== --}}

                    <a
                        href="{{ route('seller.profile') }}"
                        class="seller-center-item"
                    >

                        <div class="seller-center-item-icon">

                            <i class="fa-solid fa-user"></i>

                        </div>

                        <div class="seller-center-item-content">

                            <div class="seller-center-item-title">
                                My Profile
                            </div>

                            <div class="seller-center-item-text">
                                Manage your personal details
                            </div>

                        </div>

                        <i
                            class="fa-solid fa-chevron-right seller-center-item-arrow"
                        ></i>

                    </a>


                    {{-- =================================================
                         VERIFICATION & KYC
                    ================================================== --}}

                    <a
                        href="{{ route('seller.verification.index') }}"
                        class="seller-center-item"
                    >

                        <div class="seller-center-item-icon">

                            <i class="fa-solid fa-shield-halved"></i>

                        </div>

                        <div class="seller-center-item-content">

                            <div class="seller-center-item-title">
                                Verification &amp; KYC
                            </div>

                            <div class="seller-center-item-text">
                                Complete seller verification and review status
                            </div>

                        </div>

                        <i
                            class="fa-solid fa-chevron-right seller-center-item-arrow"
                        ></i>

                    </a>


                </div>

            </div>


            {{-- =================================================
                 ACCOUNT STATUS
            ================================================== --}}

            @php

                $sellerDashboardStatus = match (
                    $seller->verification_status ?? null
                ) {

                    \App\Models\SellerProfile::STATUS_APPROVED,
                    \App\Models\SellerProfile::STATUS_ACTIVE
                        => 'Seller account active',

                    \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW,
                    \App\Models\SellerProfile::STATUS_PENDING_REVIEW
                        => 'Application under review',

                    \App\Models\SellerProfile::STATUS_REJECTED
                        => 'Application rejected',

                    \App\Models\SellerProfile::STATUS_EMAIL_VERIFICATION,
                    \App\Models\SellerProfile::STATUS_PENDING_EMAIL,
                    \App\Models\SellerProfile::STATUS_PENDING,
                    \App\Models\SellerProfile::STATUS_DRAFT
                        => 'Verification pending',

                    default
                        => 'Verification in progress',
                };

            @endphp


            <div class="sd-status">

                <span class="sd-status-dot"></span>

                {{ $sellerDashboardStatus }}

            </div>


        </div>

    </div>


    {{-- =====================================================
         KYC STATUS CALCULATION
    ====================================================== --}}

    @php

        $kycCurrentStep = 1;

        if (!empty($seller->email_verified_at)) {
            $kycCurrentStep = 2;
        }

        if (
            !empty($seller->business_certificate_path)
            &&
            !empty($seller->aadhaar_document_path)
        ) {
            $kycCurrentStep = 3;
        }

        if (!empty($seller->aadhaar_verified_at)) {
            $kycCurrentStep = 4;
        }

        if (
            !empty($seller->business_type)
            &&
            !empty($seller->pan_number)
            &&
            !empty($seller->udyam_number)
        ) {
            $kycCurrentStep = 5;
        }

        if (
            !empty($seller->bank_account_holder)
            &&
            !empty($seller->bank_account_number)
            &&
            !empty($seller->bank_ifsc)
            &&
            !empty($seller->bank_name)
        ) {
            $kycCurrentStep = 6;
        }


        $kycStatusValue =
            $seller->verification_status ?? null;


        $kycStatusText = match ($kycStatusValue) {

            \App\Models\SellerProfile::STATUS_APPROVED,
            \App\Models\SellerProfile::STATUS_ACTIVE
                => 'Verified',

            \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW,
            \App\Models\SellerProfile::STATUS_PENDING_REVIEW
                => 'Under Review',

            \App\Models\SellerProfile::STATUS_REJECTED
                => 'Action Required',

            \App\Models\SellerProfile::STATUS_DRAFT,
            \App\Models\SellerProfile::STATUS_PENDING,
            \App\Models\SellerProfile::STATUS_EMAIL_VERIFICATION,
            \App\Models\SellerProfile::STATUS_DOCUMENTS_PENDING,
            \App\Models\SellerProfile::STATUS_AADHAAR_VERIFICATION,
            \App\Models\SellerProfile::STATUS_BUSINESS_DETAILS,
            \App\Models\SellerProfile::STATUS_BANK_DETAILS
                => 'Incomplete',

            default
                => 'Incomplete',
        };


        $kycActionText = match ($kycStatusValue) {

            \App\Models\SellerProfile::STATUS_APPROVED,
            \App\Models\SellerProfile::STATUS_ACTIVE
                => 'VIEW COMPLETE APPLICATION',

            \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW,
            \App\Models\SellerProfile::STATUS_PENDING_REVIEW
                => 'VIEW COMPLETE APPLICATION',

            \App\Models\SellerProfile::STATUS_REJECTED
                => 'UPDATE APPLICATION',

            default
                => 'CONTINUE VERIFICATION',
        };


        $kycActionRoute = match ($kycStatusValue) {

            \App\Models\SellerProfile::STATUS_APPROVED,
            \App\Models\SellerProfile::STATUS_ACTIVE
                => route(
                    'seller.verification.application.summary'
                ),

            \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW,
            \App\Models\SellerProfile::STATUS_PENDING_REVIEW
                => route(
                    'seller.verification.application.summary'
                ),

            \App\Models\SellerProfile::STATUS_REJECTED
                => route(
                    'seller.verification.index'
                ),

            default
                => route(
                    'seller.verification.index'
                ),
        };

    @endphp


    {{-- =====================================================
         VERIFICATION & KYC CARD
    ====================================================== --}}

    <div class="sd-kyc-card">


        <div class="sd-kyc-header">


            <div class="sd-kyc-title-wrap">


                <div class="sd-kyc-badge">

                    <i class="fa-solid fa-shield-halved"></i>

                </div>


                <div>

                    <div class="sd-kyc-title">
                        Verification &amp; KYC
                    </div>

                    <div class="sd-kyc-subtitle">
                        Seller onboarding status
                    </div>

                </div>


            </div>


            <span class="sd-kyc-status">

                {{ $kycStatusText }}

            </span>


        </div>


        <div class="sd-kyc-body">


            <div class="sd-kyc-label">
                Progress
            </div>


            <div class="sd-kyc-progress">

                Step {{ $kycCurrentStep }} of 6

            </div>


        </div>


        <a
            href="{{ $kycActionRoute }}"
            class="sd-kyc-button"
        >

            {{ $kycActionText }}

        </a>


    </div>


    {{-- =====================================================
         QUICK ACTIONS
    ====================================================== --}}

    <div class="sd-actions">


        {{-- ADD PRODUCT --}}

        <a
            href="{{ route('seller.product.add') }}"
            class="sd-action"
        >

            <div class="sd-action-icon">

                <i class="fa-solid fa-plus"></i>

            </div>

            <div class="sd-action-title">
                Add Product
            </div>

            <div class="sd-action-text">
                List a new product
            </div>

        </a>


        {{-- MY PRODUCTS --}}

        <a
            href="{{ route('seller.products.index') }}"
            class="sd-action"
        >

            <div class="sd-action-icon">

                <i class="fa-solid fa-box"></i>

            </div>

            <div class="sd-action-title">
                My Products
            </div>

            <div class="sd-action-text">
                Manage your products
            </div>

        </a>


        {{-- ORDERS --}}

        <a
            href="{{ route('seller.orders.index') }}"
            class="sd-action"
        >

            <div class="sd-action-icon">

                <i class="fa-solid fa-cart-shopping"></i>

            </div>

            <div class="sd-action-title">
                Orders
            </div>

            <div class="sd-action-text">
                View customer orders
            </div>

        </a>


        {{-- PAYMENTS --}}

        <a
            href="{{ route('seller.payments.index') }}"
            class="sd-action"
        >

            <div class="sd-action-icon">

                <i class="fa-solid fa-wallet"></i>

            </div>

            <div class="sd-action-title">
                Payments
            </div>

            <div class="sd-action-text">
                Track your earnings
            </div>

        </a>


    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="sd-stats">


        {{-- PRODUCTS --}}

        <div class="sd-stat">

            <div class="sd-stat-icon">

                <i class="fa-solid fa-box"></i>

            </div>

            <div class="sd-stat-number">

                {{ $totalProducts }}

            </div>

            <div class="sd-stat-label">

                Total Products

            </div>

        </div>


        {{-- ORDERS --}}

        <div class="sd-stat">

            <div class="sd-stat-icon">

                <i class="fa-solid fa-cart-shopping"></i>

            </div>

            <div class="sd-stat-number">

                {{ $totalOrders }}

            </div>

            <div class="sd-stat-label">

                Total Orders

            </div>

        </div>


        {{-- PENDING ORDERS --}}

        <div class="sd-stat">

            <div class="sd-stat-icon">

                <i class="fa-solid fa-clock"></i>

            </div>

            <div class="sd-stat-number">

                {{ $pendingOrders }}

            </div>

            <div class="sd-stat-label">

                Pending Orders

            </div>

        </div>


        {{-- REVENUE --}}

        <div class="sd-stat">

            <div class="sd-stat-icon">

                <i class="fa-solid fa-indian-rupee-sign"></i>

            </div>

            <div class="sd-stat-number">

                ₹ {{ number_format($totalRevenue) }}

            </div>

            <div class="sd-stat-label">

                Total Earnings

            </div>

        </div>


    </div>


    {{-- =====================================================
         PRODUCTS
    ====================================================== --}}

    <section class="sd-products">


        <div class="sd-section-head">


            <div>

                <div class="sd-section-title">
                    My Products
                </div>

                <div class="sd-section-subtitle">
                    Manage your listed products
                </div>

            </div>


            <a
                href="{{ route('seller.product.add') }}"
                class="sd-add"
            >

                <i class="fa-solid fa-plus"></i>

                Add Product

            </a>


        </div>


        <div class="sd-product-grid">


            @forelse($products as $product)


                <div class="sd-product">


                    {{-- PRODUCT IMAGE --}}

                    <div class="sd-product-image">

                        <img
                            src="{{ asset('products/'.$product->image) }}"
                            alt="{{ $product->name }}"
                            loading="lazy"
                        >

                    </div>


                    {{-- PRODUCT BODY --}}

                    <div class="sd-product-body">


                        <div class="sd-product-name">

                            {{ $product->name }}

                        </div>


                        <div class="sd-product-category">

                            {{ $product->category }}

                        </div>


                        <div class="sd-product-price">

                            ₹ {{ number_format($product->price) }}

                        </div>


                        <div class="sd-product-stock">

                            <i class="fa-solid fa-cubes"></i>

                            Stock:
                            {{ $product->stock }}

                        </div>


                        <div class="sd-product-actions">


                            {{-- EDIT --}}

                            <a
                                href="{{ route('seller.product.edit', $product->id) }}"
                                class="sd-edit"
                            >

                                <i class="fa-solid fa-pen"></i>

                                Edit

                            </a>


                            {{-- DELETE --}}

                            <form
                                action="{{ route('seller.product.delete', $product->id) }}"
                                method="POST"
                                style="
                                    flex: 1;
                                    margin: 0;
                                "
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="sd-delete"
                                    onclick="
                                        return confirm(
                                            'Delete this product?'
                                        )
                                    "
                                >

                                    <i class="fa-solid fa-trash"></i>

                                    Delete

                                </button>

                            </form>


                        </div>


                    </div>


                </div>


            @empty


                {{-- EMPTY STATE --}}

                <div class="sd-empty">

                    <i class="fa-solid fa-box-open"></i>

                    <h3>
                        No Products Added
                    </h3>

                    <p>
                        Start selling by adding your first product.
                    </p>

                    <a
                        href="{{ route('seller.product.add') }}"
                        class="sd-add"
                    >

                        <i class="fa-solid fa-plus"></i>

                        Add Your First Product

                    </a>

                </div>


            @endforelse


        </div>


    </section>


</div>


{{-- =========================================================
     SELLER CENTER JAVASCRIPT
========================================================= --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const wrapper =
            document.getElementById(
                'sellerCenterWrap'
            );

        const button =
            document.getElementById(
                'sellerCenterButton'
            );

        if (!wrapper || !button) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | OPEN / CLOSE SELLER CENTER
        |--------------------------------------------------------------------------
        */

        button.addEventListener(
            'click',
            function (event) {

                event.stopPropagation();

                const active =
                    wrapper.classList.toggle(
                        'active'
                    );

                button.setAttribute(
                    'aria-expanded',
                    active
                        ? 'true'
                        : 'false'
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | CLOSE WHEN CLICKING OUTSIDE
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            function (event) {

                if (
                    !wrapper.contains(
                        event.target
                    )
                ) {

                    wrapper.classList.remove(
                        'active'
                    );

                    button.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | ESCAPE KEY
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key === 'Escape'
                ) {

                    wrapper.classList.remove(
                        'active'
                    );

                    button.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                    button.focus();

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | CLOSE AFTER SELECTING SELLER CENTER ITEM
        |--------------------------------------------------------------------------
        */

        const menuItems =
            wrapper.querySelectorAll(
                '.seller-center-item'
            );

        menuItems.forEach(
            function (item) {

                item.addEventListener(
                    'click',
                    function () {

                        wrapper.classList.remove(
                            'active'
                        );

                        button.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                    }
                );

            }
        );

    }
);

</script>

@endsection