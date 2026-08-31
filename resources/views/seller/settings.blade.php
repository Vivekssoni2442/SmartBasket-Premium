@extends('seller.partials.premium-layout')

@section('title', 'Seller Settings')

@section('content')

<style>
/* =========================================================
   SMART BASKET — SELLER SETTINGS
   PREMIUM SETTINGS UI — FULL REPLACEMENT
========================================================= */

:root {
    --sb-set-bg: #f4f7fb;
    --sb-set-surface: rgba(255,255,255,.88);
    --sb-set-surface-solid: #ffffff;
    --sb-set-soft: #f7f9fc;
    --sb-set-text: #101828;
    --sb-set-muted: #667085;
    --sb-set-border: rgba(16,24,40,.08);

    --sb-set-primary: #635bff;
    --sb-set-primary-2: #8b5cf6;
    --sb-set-cyan: #06b6d4;
    --sb-set-green: #10b981;
    --sb-set-red: #ef4444;

    --sb-set-radius: 24px;
    --sb-set-shadow:
        0 20px 60px rgba(16,24,40,.08);

    --sb-set-shadow-hover:
        0 25px 70px rgba(16,24,40,.13);
}

html[data-theme="dark"],
html[data-sb-theme="dark"],
html[data-seller-theme="dark"] {
    --sb-set-bg: #070a11;
    --sb-set-surface: rgba(17,23,34,.90);
    --sb-set-surface-solid: #111722;
    --sb-set-soft: #171e2b;
    --sb-set-text: #f8fafc;
    --sb-set-muted: #98a2b3;
    --sb-set-border: rgba(255,255,255,.075);

    --sb-set-shadow:
        0 25px 75px rgba(0,0,0,.34);

    --sb-set-shadow-hover:
        0 30px 90px rgba(0,0,0,.48);
}

* {
    box-sizing: border-box;
}

.seller-settings-page {
    min-height: calc(100vh - 70px);
    padding: 30px;
    position: relative;
    overflow: hidden;

    background:
        radial-gradient(
            circle at 5% 5%,
            rgba(99,91,255,.10),
            transparent 27%
        ),
        radial-gradient(
            circle at 95% 10%,
            rgba(6,182,212,.08),
            transparent 25%
        ),
        var(--sb-set-bg);

    color: var(--sb-set-text);

    transition:
        background .3s ease,
        color .3s ease;
}

.seller-settings-page::before {
    content: "";
    position: absolute;
    width: 360px;
    height: 360px;
    right: -180px;
    top: 260px;
    border-radius: 50%;
    background: rgba(139,92,246,.07);
    filter: blur(80px);
    pointer-events: none;
}

.settings-wrapper {
    width: 100%;
    max-width: 1450px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

/* =========================================================
   TOP HEADER
========================================================= */

.settings-hero {
    position: relative;
    overflow: hidden;

    padding: 28px 30px;
    margin-bottom: 22px;

    border: 1px solid var(--sb-set-border);
    border-radius: 28px;

    background:
        linear-gradient(
            135deg,
            rgba(99,91,255,.10),
            rgba(139,92,246,.05)
        ),
        var(--sb-set-surface);

    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);

    box-shadow: var(--sb-set-shadow);
}

.settings-hero::after {
    content: "";
    position: absolute;
    width: 230px;
    height: 230px;
    right: -80px;
    top: -100px;
    border-radius: 50%;

    background:
        linear-gradient(
            135deg,
            rgba(99,91,255,.18),
            rgba(139,92,246,.05)
        );

    filter: blur(4px);
}

.settings-hero-content {
    position: relative;
    z-index: 2;

    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 25px;
}

.settings-hero-left {
    display: flex;
    align-items: center;
    gap: 18px;
}

.settings-hero-icon {
    width: 58px;
    height: 58px;
    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 18px;

    color: #fff;
    font-size: 21px;

    background:
        linear-gradient(
            135deg,
            var(--sb-set-primary),
            var(--sb-set-primary-2)
        );

    box-shadow:
        0 14px 35px rgba(99,91,255,.28);
}

.settings-kicker {
    margin-bottom: 5px;

    font-size: 10px;
    font-weight: 900;
    letter-spacing: 1.6px;
    text-transform: uppercase;

    color: var(--sb-set-primary);
}

.settings-title {
    margin: 0;

    font-size: 31px;
    line-height: 1.1;
    font-weight: 950;
    letter-spacing: -.9px;
}

.settings-title span {
    background:
        linear-gradient(
            135deg,
            var(--sb-set-primary),
            var(--sb-set-primary-2)
        );

    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.settings-subtitle {
    margin: 8px 0 0;

    max-width: 650px;

    color: var(--sb-set-muted);
    font-size: 13px;
    line-height: 1.6;
}

.settings-profile {
    min-width: 230px;

    display: flex;
    align-items: center;
    gap: 12px;

    padding: 10px 13px;

    border: 1px solid var(--sb-set-border);
    border-radius: 17px;

    background: var(--sb-set-surface-solid);
}

.settings-profile-avatar {
    width: 45px;
    height: 45px;
    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    overflow: hidden;

    border-radius: 14px;

    color: #fff;
    font-weight: 950;
    font-size: 15px;

    background:
        linear-gradient(
            135deg,
            var(--sb-set-primary),
            var(--sb-set-primary-2)
        );
}

.settings-profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.settings-profile-name {
    font-size: 12px;
    font-weight: 900;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.settings-profile-email {
    margin-top: 3px;

    color: var(--sb-set-muted);
    font-size: 10px;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* =========================================================
   ALERT
========================================================= */

.settings-alert {
    display: flex;
    align-items: flex-start;
    gap: 11px;

    margin-bottom: 18px;
    padding: 14px 16px;

    border-radius: 16px;

    font-size: 12px;
    font-weight: 800;

    animation: sbAlert .35s ease;
}

@keyframes sbAlert {
    from {
        opacity: 0;
        transform: translateY(-7px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.settings-alert.success {
    color: #047857;
    background: rgba(16,185,129,.10);
    border: 1px solid rgba(16,185,129,.20);
}

.settings-alert.error {
    color: #b91c1c;
    background: rgba(239,68,68,.09);
    border: 1px solid rgba(239,68,68,.18);
}

html[data-theme="dark"] .settings-alert.success,
html[data-sb-theme="dark"] .settings-alert.success {
    color: #6ee7b7;
}

html[data-theme="dark"] .settings-alert.error,
html[data-sb-theme="dark"] .settings-alert.error {
    color: #fca5a5;
}

/* =========================================================
   MAIN LAYOUT
========================================================= */

.settings-layout {
    display: grid;
    grid-template-columns: 245px minmax(0,1fr);
    gap: 22px;

    align-items: start;
}

/* =========================================================
   SIDEBAR
========================================================= */

.settings-nav {
    position: sticky;
    top: 20px;

    padding: 10px;

    border: 1px solid var(--sb-set-border);
    border-radius: 23px;

    background: var(--sb-set-surface);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);

    box-shadow: var(--sb-set-shadow);
}

.settings-nav-head {
    padding: 12px 12px 10px;

    display: flex;
    align-items: center;
    gap: 9px;
}

.settings-nav-head-icon {
    width: 29px;
    height: 29px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    color: var(--sb-set-primary);
    background: rgba(99,91,255,.10);

    font-size: 12px;
}

.settings-nav-head-text {
    font-size: 10px;
    font-weight: 950;
    letter-spacing: 1.2px;
    text-transform: uppercase;

    color: var(--sb-set-muted);
}

.settings-nav-item {
    position: relative;

    width: 100%;
    min-height: 48px;

    display: flex;
    align-items: center;
    gap: 12px;

    margin: 3px 0;
    padding: 0 13px;

    border: 0;
    border-radius: 14px;

    background: transparent;
    color: var(--sb-set-muted);

    font-family: inherit;
    font-size: 12px;
    font-weight: 850;

    cursor: pointer;
    text-align: left;

    transition:
        background .2s ease,
        color .2s ease,
        transform .2s ease;
}

.settings-nav-item i {
    width: 19px;

    text-align: center;
    font-size: 14px;

    transition: transform .2s ease;
}

.settings-nav-item:hover {
    color: var(--sb-set-text);
    background: var(--sb-set-soft);
    transform: translateX(2px);
}

.settings-nav-item:hover i {
    transform: scale(1.1);
}

.settings-nav-item.active {
    color: #fff;

    background:
        linear-gradient(
            135deg,
            var(--sb-set-primary),
            var(--sb-set-primary-2)
        );

    box-shadow:
        0 12px 28px rgba(99,91,255,.24);
}

.settings-nav-item.active::after {
    content: "";

    position: absolute;
    right: 9px;

    width: 5px;
    height: 5px;

    border-radius: 50%;

    background: #fff;
}

/* =========================================================
   SECTION
========================================================= */

.settings-section {
    display: none;

    animation: sbSection .28s ease;
}

.settings-section.active {
    display: block;
}

@keyframes sbSection {
    from {
        opacity: 0;
        transform: translateY(8px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* =========================================================
   CARD
========================================================= */

.settings-card {
    margin-bottom: 20px;
    padding: 27px;

    border: 1px solid var(--sb-set-border);
    border-radius: var(--sb-set-radius);

    background: var(--sb-set-surface);

    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);

    box-shadow: var(--sb-set-shadow);

    transition:
        box-shadow .25s ease,
        transform .25s ease;
}

.settings-card:hover {
    box-shadow: var(--sb-set-shadow-hover);
}

.settings-card-header {
    display: flex;
    align-items: center;
    gap: 14px;

    margin-bottom: 25px;
}

.settings-card-icon {
    width: 48px;
    height: 48px;
    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 15px;

    color: #fff;
    font-size: 16px;

    background:
        linear-gradient(
            135deg,
            var(--sb-set-primary),
            var(--sb-set-primary-2)
        );

    box-shadow:
        0 11px 25px rgba(99,91,255,.20);
}

.settings-card-title {
    font-size: 16px;
    font-weight: 950;
    letter-spacing: -.2px;
}

.settings-card-description {
    margin-top: 4px;

    color: var(--sb-set-muted);
    font-size: 11px;
    line-height: 1.5;
}

/* =========================================================
   STORE PROFILE BANNER
========================================================= */

.seller-profile-banner {
    position: relative;
    overflow: hidden;

    display: flex;
    align-items: center;
    gap: 14px;

    margin-bottom: 24px;
    padding: 17px;

    border: 1px solid rgba(99,91,255,.13);
    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            rgba(99,91,255,.10),
            rgba(139,92,246,.035)
        );
}

.seller-profile-banner::after {
    content: "";

    position: absolute;
    width: 150px;
    height: 150px;
    right: -60px;
    top: -70px;

    border-radius: 50%;

    background: rgba(99,91,255,.08);
}

.seller-avatar {
    position: relative;
    z-index: 2;

    width: 54px;
    height: 54px;
    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    overflow: hidden;

    border-radius: 16px;

    color: #fff;
    font-size: 15px;
    font-weight: 950;

    background:
        linear-gradient(
            135deg,
            var(--sb-set-primary),
            var(--sb-set-primary-2)
        );
}

.seller-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.seller-profile-name {
    position: relative;
    z-index: 2;

    font-size: 14px;
    font-weight: 950;
}

.seller-profile-email {
    position: relative;
    z-index: 2;

    margin-top: 3px;

    color: var(--sb-set-muted);
    font-size: 10px;
}

/* =========================================================
   FORM
========================================================= */

.settings-grid {
    display: grid;
    grid-template-columns: repeat(2,minmax(0,1fr));
    gap: 17px;
}

.settings-field {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.settings-field.full {
    grid-column: 1 / -1;
}

.settings-field label {
    font-size: 10px;
    font-weight: 950;
    letter-spacing: .2px;
}

.settings-input,
.settings-select {
    width: 100%;
    min-height: 46px;

    padding: 11px 13px;

    border: 1px solid var(--sb-set-border);
    border-radius: 13px;

    outline: none;

    background: var(--sb-set-soft);
    color: var(--sb-set-text);

    font-family: inherit;
    font-size: 12px;

    transition:
        border-color .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}

.settings-input::placeholder {
    color: var(--sb-set-muted);
}

.settings-input:focus,
.settings-select:focus {
    border-color: var(--sb-set-primary);

    box-shadow:
        0 0 0 4px rgba(99,91,255,.09);

    background: var(--sb-set-surface-solid);
}

.settings-input[readonly] {
    cursor: default;
    opacity: .82;
}

textarea.settings-input {
    min-height: 110px;
    resize: vertical;
}

/* =========================================================
   SETTING ROW
========================================================= */

.setting-row {
    min-height: 70px;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;

    padding: 15px 0;

    border-bottom: 1px solid var(--sb-set-border);

    transition:
        background .2s ease,
        padding .2s ease;
}

.setting-row:last-child {
    border-bottom: 0;
}

.setting-row.setting-changed {
    padding-left: 10px;
    padding-right: 10px;

    border-radius: 13px;

    background: rgba(99,91,255,.06);
}

.setting-info strong {
    display: block;

    font-size: 12px;
    font-weight: 950;
}

.setting-info span {
    display: block;

    max-width: 620px;

    margin-top: 4px;

    color: var(--sb-set-muted);
    font-size: 10px;
    line-height: 1.5;
}

/* =========================================================
   TOGGLE
========================================================= */

.toggle {
    position: relative;

    width: 49px;
    height: 28px;
    flex-shrink: 0;
}

.toggle input {
    position: absolute;

    width: 1px;
    height: 1px;

    opacity: 0;
}

.toggle-slider {
    position: absolute;
    inset: 0;

    border-radius: 30px;

    cursor: pointer;

    background: #cbd5e1;

    transition: .25s ease;
}

.toggle-slider::before {
    content: "";

    position: absolute;

    width: 22px;
    height: 22px;

    left: 3px;
    top: 3px;

    border-radius: 50%;

    background: #fff;

    box-shadow:
        0 3px 8px rgba(0,0,0,.18);

    transition: .25s ease;
}

.toggle input:checked + .toggle-slider {
    background:
        linear-gradient(
            135deg,
            var(--sb-set-primary),
            var(--sb-set-primary-2)
        );
}

.toggle input:checked + .toggle-slider::before {
    transform: translateX(21px);
}

/* =========================================================
   BUTTONS
========================================================= */

.settings-save,
.security-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    min-height: 43px;

    border-radius: 12px;

    font-family: inherit;
    font-size: 10px;
    font-weight: 950;

    cursor: pointer;

    transition:
        transform .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}

.settings-save {
    margin-top: 20px;

    padding: 0 18px;

    border: 0;

    color: #fff;

    background:
        linear-gradient(
            135deg,
            var(--sb-set-primary),
            var(--sb-set-primary-2)
        );

    box-shadow:
        0 11px 25px rgba(99,91,255,.22);
}

.settings-save:hover {
    transform: translateY(-2px);

    box-shadow:
        0 15px 30px rgba(99,91,255,.28);
}

.security-btn {
    padding: 0 14px;

    border: 1px solid rgba(99,91,255,.18);

    color: var(--sb-set-primary);
    background: rgba(99,91,255,.07);

    text-decoration: none;

    white-space: nowrap;
}

.security-btn:hover {
    color: #fff;

    background: var(--sb-set-primary);

    transform: translateY(-1px);
}

/* =========================================================
   THEME SELECTOR
========================================================= */

.theme-options {
    display: grid;
    grid-template-columns: repeat(3,minmax(0,1fr));
    gap: 15px;
}

.theme-option input {
    display: none;
}

.theme-label {
    display: block;

    padding: 10px;

    border: 2px solid var(--sb-set-border);
    border-radius: 18px;

    cursor: pointer;

    transition:
        border-color .2s ease,
        transform .2s ease,
        box-shadow .2s ease;
}

.theme-label:hover {
    transform: translateY(-3px);
}

.theme-option input:checked + .theme-label {
    border-color: var(--sb-set-primary);

    box-shadow:
        0 0 0 4px rgba(99,91,255,.08),
        0 15px 35px rgba(99,91,255,.10);
}

.theme-preview {
    position: relative;

    height: 105px;

    margin-bottom: 11px;

    overflow: hidden;

    border-radius: 12px;
}

.theme-preview::before {
    content: "";

    position: absolute;

    left: 10px;
    top: 10px;

    width: 27%;
    height: 85px;

    border-radius: 6px;
}

.theme-preview::after {
    content: "";

    position: absolute;

    left: 40%;
    top: 18px;

    width: 48%;
    height: 13px;

    border-radius: 5px;

    box-shadow:
        0 23px 0,
        0 46px 0,
        0 69px 0;
}

.theme-preview.dark {
    background: #080c14;
}

.theme-preview.dark::before {
    background: #171e2c;
}

.theme-preview.dark::after {
    background: #252d3d;
    box-shadow:
        0 23px 0 #252d3d,
        0 46px 0 #6366f1,
        0 69px 0 #252d3d;
}

.theme-preview.light {
    background: #edf2f7;
}

.theme-preview.light::before {
    background: #dfe5ec;
}

.theme-preview.light::after {
    background: #fff;
    box-shadow:
        0 23px 0 #fff,
        0 46px 0 #6366f1,
        0 69px 0 #fff;
}

.theme-preview.auto {
    background:
        linear-gradient(
            90deg,
            #edf2f7 0 50%,
            #080c14 50% 100%
        );
}

.theme-preview.auto::before {
    background:
        linear-gradient(
            90deg,
            #dfe5ec 0 50%,
            #171e2c 50% 100%
        );
}

.theme-preview.auto::after {
    background:
        linear-gradient(
            90deg,
            #fff 0 50%,
            #252d3d 50% 100%
        );

    box-shadow:
        0 23px 0 #fff,
        0 46px 0 #6366f1,
        0 69px 0 #252d3d;
}

.theme-name {
    font-size: 12px;
    font-weight: 950;
}

.theme-description {
    margin-top: 4px;

    color: var(--sb-set-muted);
    font-size: 9px;
}

/* =========================================================
   SECURITY
========================================================= */

.security-item {
    min-height: 68px;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;

    padding: 15px 0;

    border-bottom: 1px solid var(--sb-set-border);
}

.security-item:last-child {
    border-bottom: 0;
}

.security-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.security-icon {
    width: 41px;
    height: 41px;
    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    color: var(--sb-set-primary);
    background: var(--sb-set-soft);

    font-size: 13px;
}

.security-title {
    font-size: 12px;
    font-weight: 950;
}

.security-text {
    margin-top: 3px;

    color: var(--sb-set-muted);
    font-size: 10px;
}

/* =========================================================
   QR
========================================================= */

.qr-preview {
    display: flex;
    align-items: center;
    gap: 15px;

    margin-top: 16px;
    padding: 15px;

    border: 1px solid var(--sb-set-border);
    border-radius: 16px;

    background: var(--sb-set-soft);
}

.qr-preview img {
    width: 88px;
    height: 88px;

    object-fit: contain;

    padding: 5px;

    border-radius: 10px;

    background: #fff;
}

.qr-preview-info strong {
    display: block;

    font-size: 12px;
    font-weight: 950;
}

.qr-preview-info span {
    display: block;

    margin-top: 4px;

    color: var(--sb-set-muted);
    font-size: 10px;
}

/* =========================================================
   TRANSITION
========================================================= */

html.theme-transition,
html.theme-transition * {
    transition:
        background-color .25s ease,
        color .25s ease,
        border-color .25s ease,
        box-shadow .25s ease !important;
}

/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 1050px) {

    .seller-settings-page {
        padding: 22px 17px;
    }

    .settings-hero-content {
        align-items: flex-start;
    }

    .settings-profile {
        min-width: 205px;
    }

    .settings-layout {
        grid-template-columns: 1fr;
    }

    .settings-nav {
        position: relative;
        top: 0;

        display: flex;
        align-items: center;

        overflow-x: auto;

        gap: 4px;

        padding: 8px;
    }

    .settings-nav-head {
        display: none;
    }

    .settings-nav-item {
        width: auto;
        min-width: max-content;
        margin: 0;
    }

    .settings-nav-item.active::after {
        display: none;
    }
}

@media (max-width: 720px) {

    .seller-settings-page {
        padding: 16px 12px;
    }

    .settings-hero {
        padding: 21px;
        border-radius: 22px;
    }

    .settings-hero-content {
        flex-direction: column;
    }

    .settings-hero-left {
        align-items: flex-start;
    }

    .settings-hero-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
    }

    .settings-title {
        font-size: 25px;
    }

    .settings-subtitle {
        font-size: 11px;
    }

    .settings-profile {
        width: 100%;
        min-width: 0;
    }

    .settings-card {
        padding: 20px;
        border-radius: 20px;
    }

    .settings-grid,
    .theme-options {
        grid-template-columns: 1fr;
    }

    .settings-field.full {
        grid-column: auto;
    }

    .setting-row,
    .security-item {
        align-items: flex-start;
    }

    .setting-info {
        min-width: 0;
    }
}

@media (max-width: 480px) {

    .settings-hero-left {
        gap: 12px;
    }

    .settings-hero-icon {
        width: 43px;
        height: 43px;
        font-size: 16px;
    }

    .settings-title {
        font-size: 22px;
    }

    .settings-card-header {
        gap: 11px;
    }

    .settings-card-icon {
        width: 43px;
        height: 43px;
        border-radius: 13px;
    }

    .settings-card-title {
        font-size: 14px;
    }

    .settings-nav {
        border-radius: 17px;
    }

    .settings-nav-item {
        min-height: 43px;
        padding: 0 11px;
        font-size: 10px;
    }

    .settings-nav-item i {
        font-size: 12px;
    }

    .security-item,
    .setting-row {
        gap: 12px;
    }

    .security-btn {
        min-height: 38px;
        padding: 0 11px;
    }

    .settings-save {
        width: 100%;
    }
}
</style>


<div class="seller-settings-page">

    <div class="settings-wrapper">

        {{-- =====================================================
             PREMIUM HEADER
        ====================================================== --}}

        <div class="settings-hero">

            <div class="settings-hero-content">

                <div class="settings-hero-left">

                    <div class="settings-hero-icon">
                        <i class="fa-solid fa-sliders"></i>
                    </div>

                    <div>

                        <div class="settings-kicker">
                            Smart Basket Seller Center
                        </div>

                        <h1 class="settings-title">
                            Seller <span>Settings</span>
                        </h1>

                        <p class="settings-subtitle">
                            Manage your store, account, notifications,
                            payments, appearance and security from one place.
                        </p>

                    </div>

                </div>


                <div class="settings-profile">

                    <div class="settings-profile-avatar">

                        @if(!empty($seller->shop_logo))

                            <img
                                src="{{ asset('storage/' . ltrim($seller->shop_logo, '/')) }}?v={{ optional($seller->updated_at)->timestamp ?? time() }}"
                                alt="Shop Logo"
                            >

                        @else

                            {{ strtoupper(substr($seller->seller_name ?? 'S', 0, 1)) }}

                        @endif

                    </div>

                    <div>

                        <div class="settings-profile-name">
                            {{ $seller->seller_name ?? 'Seller' }}
                        </div>

                        <div class="settings-profile-email">
                            {{ $seller->email ?? 'Seller account' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             ALERTS
        ====================================================== --}}

        @if(session('success'))

            <div class="settings-alert success">

                <i class="fa-solid fa-circle-check"></i>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif


        @if(session('error'))

            <div class="settings-alert error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <div>
                    {{ session('error') }}
                </div>

            </div>

        @endif


        @if($errors->any())

            <div class="settings-alert error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <div>

                    @foreach($errors->all() as $error)

                        <div>{{ $error }}</div>

                    @endforeach

                </div>

            </div>

        @endif


        {{-- =====================================================
             MAIN SETTINGS
        ====================================================== --}}

        <div class="settings-layout">


            {{-- =================================================
                 NAVIGATION
            ================================================== --}}

            <aside class="settings-nav">

                <div class="settings-nav-head">

                    <div class="settings-nav-head-icon">
                        <i class="fa-solid fa-gear"></i>
                    </div>

                    <div class="settings-nav-head-text">
                        Settings Menu
                    </div>

                </div>


                <button
                    type="button"
                    class="settings-nav-item active"
                    data-section="store"
                >
                    <i class="fa-solid fa-store"></i>
                    <span>Store</span>
                </button>


                <button
                    type="button"
                    Security
                    class="settings-nav-item"

                <button
                    type="button"
                    class="settings-nav-item"
                    data-section="operations"
                >
                    <i class="fa-solid fa-sliders"></i>
                    Operations
            
                    <i class="fa-solid fa-user"></i>
                    <span>Account</span>
                </button>


                <button
                    type="button"
                    class="settings-nav-item"
                    data-section="notifications"
                >
                    <i class="fa-solid fa-bell"></i>
                    <span>Notifications</span>
                </button>


                <button
                    type="button"
                    class="settings-nav-item"
                    data-section="payments"
                >
                    <i class="fa-solid fa-credit-card"></i>
                    <span>Payments</span>
                </button>


                <button
                    type="button"
                    class="settings-nav-item"
                    data-section="shipping"
                >
                    <i class="fa-solid fa-truck"></i>
                    <span>Shipping</span>
                </button>


                <button
                    type="button"
                    class="settings-nav-item"
                    data-section="appearance"
                >
                    <i class="fa-solid fa-palette"></i>
                    <span>Appearance</span>
                </button>


                <button
                    type="button"
                    class="settings-nav-item"
                    data-section="security"
                >
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Security</span>
                </button>

            </aside>


            {{-- =================================================
                 CONTENT
            ================================================== --}}

            <div class="settings-content">


                {{-- =================================================
                     STORE
                ================================================== --}}

                <section
                    class="settings-section active"
                    data-content="store"
                >

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-store"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Store Information
                                </div>

                                <div class="settings-card-description">
                                    View your store identity and seller information.
                                </div>

                            </div>

                        </div>


                        <div class="seller-profile-banner">

                            <div class="seller-avatar">

                                @if(!empty($seller->shop_logo))

                                    <img
                                        src="{{ asset('storage/' . ltrim($seller->shop_logo, '/')) }}?v={{ optional($seller->updated_at)->timestamp ?? time() }}"
                                        alt="Shop Logo"
                                    >

                                @else

                                    SB

                                @endif

                            </div>

                            <div>

                                <div class="seller-profile-name">
                                    {{ $seller->shop_name ?? $seller->seller_name ?? 'Smart Basket Seller' }}
                                </div>

                                <div class="seller-profile-email">
                                    {{ $seller->email ?? '' }}
                                </div>

                            </div>

                        </div>


                        <form
                            method="POST"
                            action="{{ route('seller.settings.update') }}"
                        >

                            @csrf
                            @method('PUT')

                            <input
                                type="hidden"
                                name="theme"
                                value="{{ $seller->theme ?? 'light' }}"
                            >

                            <input
                                type="hidden"
                                name="notifications_enabled"
                                value="{{ (bool)($seller->notifications_enabled ?? true) ? 1 : 0 }}"
                            >

                            <input
                                type="hidden"
                                name="online_payments_enabled"
                                value="{{ (bool)($seller->online_payments_enabled ?? false) ? 1 : 0 }}"
                            >


                            <div class="settings-grid">

                                <div class="settings-field">

                                    <label>
                                        Store Name
                                    </label>

                                    <input
                                        type="text"
                                        class="settings-input"
                                        value="{{ $seller->shop_name ?? '' }}"
                                        readonly
                                    >

                                </div>


                                <div class="settings-field">

                                    <label>
                                        Seller Name
                                    </label>

                                    <input
                                        type="text"
                                        class="settings-input"
                                        value="{{ $seller->seller_name ?? '' }}"
                                        readonly
                                    >

                                </div>


                                <div class="settings-field">

                                    <label>
                                        Email Address
                                    </label>

                                    <input
                                        type="email"
                                        class="settings-input"
                                        value="{{ $seller->email ?? '' }}"
                                        readonly
                                    >

                                </div>


                                <div class="settings-field">

                                    <label>
                                        Mobile Number
                                    </label>

                                    <input
                                        type="text"
                                        class="settings-input"
                                        value="{{ $seller->mobile_number ?? '' }}"
                                        readonly
                                    >

                                </div>

                            </div>


                            <a
                                href="{{ route('seller.profile') }}"
                                class="security-btn"
                                style="margin-top:20px;"
                            >
                                <i class="fa-solid fa-pen"></i>
                                Edit Store Profile
                            </a>

                        </form>

                    </div>

                </section>

                {{-- =================================================
                     OPERATIONS
                ================================================== --}}

                <section
                    class="settings-section"
                    data-content="operations"
                >

                    <form method="POST" action="{{ route('seller.settings.update') }}">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="theme" value="{{ $seller->theme ?? 'light' }}">
                        <input type="hidden" name="notifications_enabled" value="{{ (bool)($seller->notifications_enabled ?? true) ? 1 : 0 }}">
                        <input type="hidden" name="online_payments_enabled" value="{{ (bool)($seller->online_payments_enabled ?? false) ? 1 : 0 }}">

                        @php
                            $operationGroups = [
                                'Order Settings' => [
                                    'auto_accept_orders' => 'Auto accept orders',
                                    'allow_order_cancellation' => 'Allow order cancellation',
                                    'allow_return_requests' => 'Allow return requests',
                                    'allow_exchange_requests' => 'Allow exchange requests',
                                    'auto_update_order_status' => 'Auto update order status',
                                    'order_confirmation_notification' => 'Order confirmation notification',
                                    'delivery_status_notification' => 'Delivery status notification',
                                ],
                                'Product Settings' => [
                                    'allow_customer_reviews' => 'Allow customer reviews',
                                    'allow_customer_questions' => 'Allow customer questions',
                                    'show_stock_quantity' => 'Show stock quantity',
                                    'product_visibility_enabled' => 'Enable product visibility',
                                    'auto_hide_out_of_stock' => 'Auto hide out-of-stock products',
                                ],
                                'Shipping and Delivery' => [
                                    'shipping_enabled' => 'Shipping enabled',
                                    'seller_delivery' => 'Seller delivery',
                                    'platform_delivery' => 'Platform delivery',
                                    'pickup_option' => 'Pickup option',
                                    'same_day_delivery' => 'Same-day delivery',
                                    'express_delivery' => 'Express delivery',
                                ],
                                'Privacy and Store Visibility' => [
                                    'profile_visibility' => 'Profile visibility',
                                    'shop_visibility' => 'Shop visibility',
                                    'show_mobile_number' => 'Show mobile number',
                                    'show_email' => 'Show email',
                                    'show_business_information' => 'Show business information',
                                    'store_active' => 'Store active',
                                    'temporarily_closed' => 'Store temporarily closed',
                                    'vacation_mode' => 'Vacation mode',
                                    'allow_customer_messages' => 'Allow customer messages',
                                    'auto_reply' => 'Automatic customer reply',
                                ],
                                'Invoice and Receipt' => [
                                    'show_seller_logo_on_invoice' => 'Show seller logo',
                                    'show_gst_on_invoice' => 'Show GST',
                                    'show_seller_address_on_invoice' => 'Show seller address',
                                    'show_customer_address_on_invoice' => 'Show customer address',
                                    'show_payment_details_on_invoice' => 'Show payment details',
                                    'show_qr_on_invoice' => 'Show payment QR',
                                ],
                            ];
                        @endphp

                        @foreach($operationGroups as $groupTitle => $groupSettings)
                            <div class="settings-card">
                                <div class="settings-card-header">
                                    <div class="settings-card-icon"><i class="fa-solid fa-sliders"></i></div>
                                    <div>
                                        <div class="settings-card-title">{{ $groupTitle }}</div>
                                        <div class="settings-card-description">These preferences are saved to your seller account.</div>
                                    </div>
                                </div>

                                @foreach($groupSettings as $settingKey => $settingLabel)
                                    <div class="setting-row">
                                        <div class="setting-info"><strong>{{ $settingLabel }}</strong><span>Apply this preference across the relevant seller workflow.</span></div>
                                        <label class="toggle">
                                            <input type="hidden" name="preferences[{{ $settingKey }}]" value="0">
                                            <input type="checkbox" name="preferences[{{ $settingKey }}]" value="1" {{ !empty($preferences[$settingKey]) ? 'checked' : '' }}>
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <div class="settings-card">
                            <div class="settings-grid">
                                <div class="settings-field">
                                    <label>Delivery Charge</label>
                                    <input class="settings-input" type="number" min="0" step="0.01" name="preferences[delivery_charge]" value="{{ $preferences['delivery_charge'] }}">
                                </div>
                                <div class="settings-field">
                                    <label>Free Shipping Threshold</label>
                                    <input class="settings-input" type="number" min="0" step="0.01" name="preferences[free_shipping_threshold]" value="{{ $preferences['free_shipping_threshold'] }}">
                                </div>
                                <div class="settings-field">
                                    <label>Estimated Delivery Days</label>
                                    <input class="settings-input" type="number" min="1" name="preferences[estimated_delivery_days]" value="{{ $preferences['estimated_delivery_days'] }}">
                                </div>
                                <div class="settings-field">
                                    <label>Low Stock Threshold</label>
                                    <input class="settings-input" type="number" min="0" name="preferences[low_stock_threshold]" value="{{ $preferences['low_stock_threshold'] }}">
                                </div>
                                <div class="settings-field">
                                    <label>Default Product Status</label>
                                    <select class="settings-select" name="preferences[default_product_status]"><option value="active" @selected($preferences['default_product_status'] === 'active')>Active</option><option value="inactive" @selected($preferences['default_product_status'] === 'inactive')>Inactive</option></select>
                                </div>
                                <div class="settings-field">
                                    <label>Default Rating</label>
                                    <input class="settings-input" type="number" min="0" max="5" step="0.1" name="preferences[default_rating]" value="{{ $preferences['default_rating'] }}">
                                </div>
                                <div class="settings-field">
                                    <label>Invoice Prefix</label>
                                    <input class="settings-input" type="text" maxlength="30" name="preferences[invoice_prefix]" value="{{ $preferences['invoice_prefix'] }}">
                                </div>
                                <div class="settings-field full">
                                    <label>Invoice Footer</label>
                                    <textarea class="settings-input" name="preferences[invoice_footer]" rows="3">{{ $preferences['invoice_footer'] }}</textarea>
                                </div>
                            </div>
                            <button type="submit" class="settings-save"><i class="fa-solid fa-floppy-disk"></i>Save Operations Settings</button>
                        </div>
                    </form>

                    <div class="settings-card">
                        <div class="settings-card-header">
                            <div class="settings-card-icon"><i class="fa-solid fa-comments"></i></div>
                            <div><div class="settings-card-title">Customer Communication</div><div class="settings-card-description">Configure predefined messages shown during the order lifecycle.</div></div>
                        </div>
                        <form method="POST" action="{{ route('seller.settings.update') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="theme" value="{{ $seller->theme ?? 'light' }}">
                            <input type="hidden" name="notifications_enabled" value="{{ (bool)($seller->notifications_enabled ?? true) ? 1 : 0 }}">
                            <input type="hidden" name="online_payments_enabled" value="{{ (bool)($seller->online_payments_enabled ?? false) ? 1 : 0 }}">
                            @foreach(['welcome_message' => 'Welcome message', 'order_message' => 'Order message', 'cancellation_message' => 'Cancellation message', 'delivery_message' => 'Delivery message'] as $messageKey => $messageLabel)
                                <div class="settings-field" style="margin-top:14px;"><label>{{ $messageLabel }}</label><textarea class="settings-input" name="preferences[{{ $messageKey }}]" rows="2">{{ $preferences[$messageKey] }}</textarea></div>
                            @endforeach
                            <button type="submit" class="settings-save"><i class="fa-solid fa-floppy-disk"></i>Save Messages</button>
                        </form>
                    </div>

                </section>


                {{-- =================================================
                     ACCOUNT
                ================================================== --}}

                <section
                    class="settings-section"
                    data-content="account"
                >

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Account Information
                                </div>

                                <div class="settings-card-description">
                                    Your Smart Basket seller account details.
                                </div>

                            </div>

                        </div>


                        <div class="settings-grid">

                            <div class="settings-field">

                                <label>Seller Name</label>

                                <input
                                    class="settings-input"
                                    value="{{ $seller->seller_name ?? '' }}"
                                    readonly
                                >

                            </div>


                            <div class="settings-field">

                                <label>Email Address</label>

                                <input
                                    class="settings-input"
                                    value="{{ $seller->email ?? '' }}"
                                    readonly
                                >

                            </div>


                            <div class="settings-field">

                                <label>Mobile Number</label>

                                <input
                                    class="settings-input"
                                    value="{{ $seller->mobile_number ?? '' }}"
                                    readonly
                                >

                            </div>


                            <div class="settings-field">

                                <label>Seller ID</label>

                                <input
                                    class="settings-input"
                                    value="#{{ $seller->id }}"
                                    readonly
                                >

                            </div>

                        </div>


                        <a
                            href="{{ route('seller.profile') }}"
                            class="security-btn"
                            style="margin-top:20px;"
                        >
                            <i class="fa-solid fa-user-pen"></i>
                            Edit Profile
                        </a>

                    </div>

                </section>


                {{-- =================================================
                     NOTIFICATIONS
                ================================================== --}}

                <section
                    class="settings-section"
                    data-content="notifications"
                >

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-bell"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Notification Preferences
                                </div>

                                <div class="settings-card-description">
                                    Control seller alerts and important account notifications.
                                </div>

                            </div>

                        </div>


                        <form
                            method="POST"
                            action="{{ route('seller.settings.update') }}"
                            id="notification-form"
                        >

                            @csrf
                            @method('PUT')

                            <input
                                type="hidden"
                                name="theme"
                                value="{{ $seller->theme ?? 'light' }}"
                            >

                            <input
                                type="hidden"
                                name="online_payments_enabled"
                                value="{{ (bool)($seller->online_payments_enabled ?? false) ? 1 : 0 }}"
                            >


                            <div class="setting-row">

                                <div class="setting-info">

                                    <strong>
                                        Seller Notifications
                                    </strong>

                                    <span>
                                        Receive order alerts, account updates
                                        and important seller notifications.
                                    </span>

                                </div>


                                <label class="toggle">

                                    <input
                                        type="checkbox"
                                        name="notifications_enabled"
                                        value="1"
                                        {{ (bool)($seller->notifications_enabled ?? true) ? 'checked' : '' }}
                                    >

                                    <span class="toggle-slider"></span>

                                </label>

                            </div>

                            @php
                                $notificationPreferences = [
                                    'new_order_notification' => 'New order notification',
                                    'order_cancellation_notification' => 'Order cancellation',
                                    'payment_received_notification' => 'Payment received',
                                    'payment_failed_notification' => 'Payment failed',
                                    'low_stock_alert' => 'Low stock alert',
                                    'customer_message_notification' => 'Customer message',
                                    'seller_verification_notification' => 'Seller verification notification',
                                    'promotional_notifications' => 'Promotional notifications',
                                    'email_notifications' => 'Email notifications',
                                    'browser_notifications' => 'Browser notifications',
                                ];
                            @endphp

                            @foreach($notificationPreferences as $notificationKey => $notificationLabel)
                                <div class="setting-row">
                                    <div class="setting-info">
                                        <strong>{{ $notificationLabel }}</strong>
                                        <span>Receive this alert in your seller workspace.</span>
                                    </div>
                                    <label class="toggle">
                                        <input type="hidden" name="preferences[{{ $notificationKey }}]" value="0">
                                        <input type="checkbox" name="preferences[{{ $notificationKey }}]" value="1" {{ !empty($preferences[$notificationKey]) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            @endforeach
                                Save Notifications
                            </button>

                        </form>

                    </div>

                </section>


                {{-- =================================================
                     PAYMENTS
                ================================================== --}}

                <section
                    class="settings-section"
                    data-content="payments"
                >

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-credit-card"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Payment Settings
                                </div>

                                <div class="settings-card-description">
                                    Control online payments and payment QR configuration.
                                </div>

                            </div>

                        </div>


                        <form
                            method="POST"
                            action="{{ route('seller.settings.update') }}"
                        >

                            @csrf
                            @method('PUT')

                            <input
                                type="hidden"
                                name="theme"
                                value="{{ $seller->theme ?? 'light' }}"
                            >

                            <input
                                type="hidden"
                                name="notifications_enabled"
                                value="{{ (bool)($seller->notifications_enabled ?? true) ? 1 : 0 }}"
                            >


                            <div class="setting-row">

                                <div class="setting-info">

                                    <strong>
                                        Online Payments
                                    </strong>

                                    <span>
                                        Allow customers to use online payment
                                        methods for your products.
                                    </span>

                                </div>


                                <label class="toggle">

                                    <input
                                        type="checkbox"
                                        name="online_payments_enabled"
                                        value="1"
                                        {{ (bool)($seller->online_payments_enabled ?? false) ? 'checked' : '' }}
                                    >

                                    <span class="toggle-slider"></span>

                                </label>

                            </div>


                            <button
                                type="submit"
                                class="settings-save"
                            >
                                <i class="fa-solid fa-floppy-disk"></i>
                                Save Payment Settings
                            </button>

                        </form>


                        <div
                            class="setting-row"
                            style="margin-top:15px;"
                        >

                            <div class="setting-info">

                                <strong>
                                    Payment QR
                                </strong>

                                <span>
                                    Manage the QR code customers use
                                    to make payments.
                                </span>

                            </div>


                            <a
                                href="{{ route('seller.profile') }}"
                                class="security-btn"
                            >
                                <i class="fa-solid fa-qrcode"></i>
                                Manage QR
                            </a>

                        </div>


                        @if(!empty($seller->payment_qr))

                            <div class="qr-preview">

                                <img
                                    src="{{ asset('storage/' . ltrim($seller->payment_qr, '/')) }}?v={{ optional($seller->updated_at)->timestamp ?? time() }}"
                                    alt="Payment QR"
                                >

                                <div class="qr-preview-info">

                                    <strong>
                                        Payment QR Active
                                    </strong>

                                    <span>
                                        Your current payment QR is configured
                                        and ready for customer payments.
                                    </span>

                                </div>

                            </div>

                        @endif

                    </div>

                </section>


                {{-- =================================================
                     SHIPPING
                ================================================== --}}

                <section
                    class="settings-section"
                    data-content="shipping"
                >

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-truck"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Shipping Preferences
                                </div>

                                <div class="settings-card-description">
                                    Manage orders, delivery and product inventory.
                                </div>

                            </div>

                        </div>


                        <div class="setting-row">

                            <div class="setting-info">

                                <strong>
                                    Shipping Management
                                </strong>

                                <span>
                                    Manage order delivery and shipping
                                    status from your seller dashboard.
                                </span>

                            </div>

                            <a
                                href="{{ route('seller.dashboard') }}"
                                class="security-btn"
                            >
                                <i class="fa-solid fa-box"></i>
                                Open Orders
                            </a>

                        </div>


                        <div class="setting-row">

                            <div class="setting-info">

                                <strong>
                                    Product Stock
                                </strong>

                                <span>
                                    Manage available stock and product
                                    inventory.
                                </span>

                            </div>

                            <a
                                href="{{ route('seller.products') }}"
                                class="security-btn"
                            >
                                <i class="fa-solid fa-boxes-stacked"></i>
                                Products
                            </a>

                        </div>

                    </div>

                </section>


                {{-- =================================================
                     APPEARANCE
                ================================================== --}}

                <section
                    class="settings-section"
                    data-content="appearance"
                >

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-palette"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Appearance & Theme
                                </div>

                                <div class="settings-card-description">
                                    Choose how your Smart Basket seller dashboard looks.
                                </div>

                            </div>

                        </div>


                        <form
                            id="theme-settings-form"
                            method="POST"
                            action="{{ route('seller.settings.update') }}"
                        >

                            @csrf
                            @method('PUT')

                            <input
                                type="hidden"
                                name="notifications_enabled"
                                value="{{ (bool)($seller->notifications_enabled ?? true) ? 1 : 0 }}"
                            >

                            <input
                                type="hidden"
                                name="online_payments_enabled"
                                value="{{ (bool)($seller->online_payments_enabled ?? false) ? 1 : 0 }}"
                            >


                            <div class="theme-options">


                                {{-- DARK --}}

                                <div class="theme-option">

                                    <input
                                        type="radio"
                                        name="theme"
                                        value="dark"
                                        id="theme-dark"
                                        {{ ($seller->theme ?? 'light') === 'dark' ? 'checked' : '' }}
                                    >

                                    <label
                                        for="theme-dark"
                                        class="theme-label"
                                    >

                                        <div class="theme-preview dark"></div>

                                        <div class="theme-name">
                                            Dark Premium
                                        </div>

                                        <div class="theme-description">
                                            Premium dark dashboard
                                        </div>

                                    </label>

                                </div>


                                {{-- LIGHT --}}

                                <div class="theme-option">

                                    <input
                                        type="radio"
                                        name="theme"
                                        value="light"
                                        id="theme-light"
                                        {{ ($seller->theme ?? 'light') === 'light' ? 'checked' : '' }}
                                    >

                                    <label
                                        for="theme-light"
                                        class="theme-label"
                                    >

                                        <div class="theme-preview light"></div>

                                        <div class="theme-name">
                                            Light
                                        </div>

                                        <div class="theme-description">
                                            Clean bright interface
                                        </div>

                                    </label>

                                </div>


                                {{-- SYSTEM --}}

                                <div class="theme-option">

                                    <input
                                        type="radio"
                                        name="theme"
                                        value="system"
                                        id="theme-system"
                                        {{ ($seller->theme ?? 'light') === 'system' ? 'checked' : '' }}
                                    >

                                    <label
                                        for="theme-system"
                                        class="theme-label"
                                    >

                                        <div class="theme-preview auto"></div>

                                        <div class="theme-name">
                                            System
                                        </div>

                                        <div class="theme-description">
                                            Follow device appearance
                                        </div>

                                    </label>

                                </div>

                            </div>


                            <button
                                type="submit"
                                class="settings-save"
                            >

                                <i class="fa-solid fa-palette"></i>

                                Save Theme

                            </button>

                        </form>

                    </div>

                </section>


                {{-- =================================================
                     SECURITY
                ================================================== --}}

                <section
                    class="settings-section"
                    data-content="security"
                >

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Security
                                </div>

                                <div class="settings-card-description">
                                    Manage your seller account security and access.
                                </div>

                            </div>

                        </div>

                        <form method="POST" action="{{ route('seller.settings.password') }}" class="settings-grid" style="margin-top:20px;">
                            @csrf
                            @method('PUT')
                            <div class="settings-field">
                                <label for="current_password">Current Password</label>
                                <input id="current_password" class="settings-input" type="password" name="current_password" required autocomplete="current-password">
                            </div>
                            <div class="settings-field">
                                <label for="password">New Password</label>
                                <input id="password" class="settings-input" type="password" name="password" required autocomplete="new-password">
                            </div>
                            <div class="settings-field">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input id="password_confirmation" class="settings-input" type="password" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div class="settings-field" style="justify-content:end;">
                                <button type="submit" class="settings-save"><i class="fa-solid fa-key"></i>Change Password</button>
                            </div>
                        </form>


                        <div class="security-item">

                            <div class="security-left">

                                <div class="security-icon">
                                    <i class="fa-solid fa-key"></i>
                                </div>

                                <div>

                                    <div class="security-title">
                                        Password
                                    </div>

                                    <div class="security-text">
                                        Change your account password.
                                    </div>

                                </div>

                            </div>


                            <a
                                href="{{ url('/forgot-password') }}"
                                class="security-btn"
                            >
                                <i class="fa-solid fa-arrow-right"></i>
                                Change
                            </a>

                        </div>


                        <div class="security-item">

                            <div class="security-left">

                                <div class="security-icon">
                                    <i class="fa-solid fa-user-shield"></i>
                                </div>

                                <div>

                                    <div class="security-title">
                                        Seller Profile
                                    </div>

                                    <div class="security-text">
                                        Review and update your seller information.
                                    </div>

                                </div>

                            </div>


                            <a
                                href="{{ route('seller.profile') }}"
                                class="security-btn"
                            >
                                <i class="fa-solid fa-arrow-right"></i>
                                Open
                            </a>

                        </div>


                        <div class="security-item">

                            <div class="security-left">

                                <div class="security-icon">
                                    <i class="fa-solid fa-store"></i>
                                </div>

                                <div>

                                    <div class="security-title">
                                        Seller Dashboard
                                    </div>

                                    <div class="security-text">
                                        Return to your seller workspace.
                                    </div>

                                </div>

                            </div>


                            <a
                                href="{{ route('seller.dashboard') }}"
                                class="security-btn"
                            >
                                <i class="fa-solid fa-arrow-right"></i>
                                Dashboard
                            </a>

                        </div>

                    </div>

                </section>


            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       SETTINGS TABS
    ===================================================== */

    const buttons = document.querySelectorAll(
        '.settings-nav-item'
    );

    const sections = document.querySelectorAll(
        '.settings-section'
    );


    function openSection(sectionName) {

        buttons.forEach(function (button) {

            button.classList.toggle(
                'active',
                button.dataset.section === sectionName
            );

        });


        sections.forEach(function (section) {

            section.classList.toggle(
                'active',
                section.dataset.content === sectionName
            );

        });


        try {

            localStorage.setItem(
                'smartbasket_settings_section',
                sectionName
            );

        } catch (e) {}

    }


    buttons.forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                openSection(
                    this.dataset.section
                );

            }
        );

    });


    let savedSection = null;

    try {

        savedSection = localStorage.getItem(
            'smartbasket_settings_section'
        );

    } catch (e) {}


    if (
        savedSection &&
        document.querySelector(
            '[data-content="' + savedSection + '"]'
        )
    ) {

        openSection(savedSection);

    }


    /* =====================================================
       THEME SYSTEM
    ===================================================== */

    const themeRadios = document.querySelectorAll(
        'input[name="theme"]'
    );

    const html = document.documentElement;


    function systemTheme() {

        return window.matchMedia(
            '(prefers-color-scheme: dark)'
        ).matches
            ? 'dark'
            : 'light';

    }


    function applySellerTheme(theme) {

        let finalTheme = theme;


        if (theme === 'system') {

            finalTheme = systemTheme();

        }


        if (
            finalTheme !== 'dark' &&
            finalTheme !== 'light'
        ) {

            finalTheme = 'light';

        }


        html.classList.add(
            'theme-transition'
        );


        html.setAttribute(
            'data-theme',
            finalTheme
        );

        html.setAttribute(
            'data-sb-theme',
            finalTheme
        );

        html.setAttribute(
            'data-seller-theme',
            theme
        );


        try {

            localStorage.setItem(
                'smartbasket_seller_theme',
                theme
            );

        } catch (e) {}


        window.dispatchEvent(
            new CustomEvent(
                'smartbasket-theme-changed',
                {
                    detail: {
                        theme: theme,
                        finalTheme: finalTheme
                    }
                }
            )
        );


        setTimeout(function () {

            html.classList.remove(
                'theme-transition'
            );

        }, 300);

    }


    themeRadios.forEach(function (radio) {

        radio.addEventListener(
            'change',
            function () {

                if (this.checked) {

                    applySellerTheme(
                        this.value
                    );

                }

            }
        );

    });


    /* =====================================================
       DATABASE THEME
    ===================================================== */

    const databaseTheme =
        @json($seller->theme ?? 'light');


    const initialTheme = databaseTheme;


    const initialRadio =
        document.querySelector(
            'input[name="theme"][value="' +
            initialTheme +
            '"]'
        );


    if (initialRadio) {

        initialRadio.checked = true;

    }


    applySellerTheme(
        initialTheme
    );


    /* =====================================================
       SYSTEM THEME CHANGE
    ===================================================== */

    const mediaQuery =
        window.matchMedia(
            '(prefers-color-scheme: dark)'
        );


    function handleSystemThemeChange() {

        let current = null;

        try {

            current = localStorage.getItem(
                'smartbasket_seller_theme'
            );

        } catch (e) {}


        if (current === 'system') {

            applySellerTheme(
                'system'
            );

        }

    }


    if (
        typeof mediaQuery.addEventListener ===
        'function'
    ) {

        mediaQuery.addEventListener(
            'change',
            handleSystemThemeChange
        );

    } else {

        mediaQuery.addListener(
            handleSystemThemeChange
        );

    }


    /* =====================================================
       THEME FORM SAVE
    ===================================================== */

    const themeForm =
        document.getElementById(
            'theme-settings-form'
        );


    if (themeForm) {

        themeForm.addEventListener(
            'submit',
            function () {

                const checked =
                    document.querySelector(
                        'input[name="theme"]:checked'
                    );


                if (checked) {

                    try {

                        localStorage.setItem(
                            'smartbasket_seller_theme',
                            checked.value
                        );

                    } catch (e) {}

                }

            }
        );

    }


    /* =====================================================
       TOGGLE VISUAL FEEDBACK
    ===================================================== */

    document.querySelectorAll(
        '.toggle input'
    ).forEach(function (input) {

        input.addEventListener(
            'change',
            function () {

                const row =
                    this.closest('.setting-row');


                if (!row) {

                    return;

                }


                row.classList.add(
                    'setting-changed'
                );


                setTimeout(function () {

                    row.classList.remove(
                        'setting-changed'
                    );

                }, 500);

            }
        );

    });


    /* =====================================================
       AUTO HIDE ALERT
    ===================================================== */

    const alerts =
        document.querySelectorAll(
            '.settings-alert'
        );


    alerts.forEach(function (alert) {

        setTimeout(function () {

            alert.style.transition =
                'opacity .3s ease, transform .3s ease';

            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-5px)';


            setTimeout(function () {

                if (alert.parentNode) {

                    alert.parentNode.removeChild(
                        alert
                    );

                }

            }, 300);

        }, 5000);

    });

});
</script>

@endsection