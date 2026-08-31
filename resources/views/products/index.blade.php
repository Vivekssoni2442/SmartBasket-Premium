<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Smart Basket — Products</title>

<script>
(() => {
    const saved = localStorage.getItem('sb-theme');

    const userTheme =
        @auth @json(auth()->user()->dark_mode ?? auth()->user()->theme ?? 'dark') @else 'dark' @endauth;

    const theme = ['light','dark'].includes(saved)
        ? saved
        : (['light','dark'].includes(userTheme) ? userTheme : 'dark');

    document.documentElement.setAttribute('data-theme', theme);
    window.SB_THEME = theme;
})();
</script>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">

<link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    rel="stylesheet">

<style>

:root {
    --bg:#f5f7fb;
    --surface:#ffffff;
    --surface2:#f8fafc;
    --text:#102033;
    --muted:#718096;
    --border:#e3eaf3;
    --primary:#2563eb;
    --primary2:#7c3aed;
    --success:#16a34a;
    --danger:#e05b72;

    --rgb-cyan:#00f6ff;
    --rgb-blue:#287bff;
    --rgb-purple:#8b35ff;
    --rgb-pink:#ff20c8;
    --rgb-red:#ff405d;
    --rgb-yellow:#ffe45c;

    --shadow:0 18px 55px rgba(15,23,42,.09);
    --menu-shadow:0 25px 70px rgba(15,23,42,.18);
}

html[data-theme="dark"] {
    --bg:#040914;
    --surface:#091322;
    --surface2:#0d1b2d;
    --text:#f5f9ff;
    --muted:#9aacbf;
    --border:#21364f;
    --primary:#65a5ff;
    --primary2:#9a7cff;
    --success:#45cf8c;
    --danger:#ef8095;
    --shadow:0 22px 65px rgba(0,0,0,.42);
    --menu-shadow:0 28px 80px rgba(0,0,0,.62);
}

* {
    box-sizing:border-box;
}

html {
    scroll-behavior:smooth;
    background:var(--bg);
}

body {
    margin:0;
    min-height:100vh;
    color:var(--text);
    font-family:
        Inter,
        Poppins,
        system-ui,
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        sans-serif;

    background:
        radial-gradient(circle at 8% 0%,rgba(0,246,255,.07),transparent 24%),
        radial-gradient(circle at 92% 0%,rgba(255,32,200,.07),transparent 24%),
        var(--bg);

    transition:background .25s ease,color .25s ease;
}

a {
    text-decoration:none !important;
}

button,
input,
select {
    font-family:inherit;
}


/* =========================================================
   TOP BAR
========================================================= */

.sb-topbar {
    position:sticky;
    top:0;
    z-index:3000;

    min-height:76px;
    width:100%;

    display:flex;
    align-items:center;
    justify-content:space-between;

    padding:12px 24px;

    background:color-mix(
        in srgb,
        var(--surface) 91%,
        transparent
    );

    border-bottom:1px solid var(--border);

    backdrop-filter:blur(24px);

    box-shadow:0 8px 30px var(--shadow);
}

.sb-brand {
    display:flex;
    align-items:center;
    gap:12px;
    color:var(--text);
}

.sb-brand-icon {
    width:46px;
    height:46px;

    display:grid;
    place-items:center;

    border-radius:15px;
    color:#fff;

    background:
        linear-gradient(
            135deg,
            var(--primary),
            var(--primary2)
        );

    box-shadow:0 10px 28px rgba(37,99,235,.25);
}

.sb-brand-text strong {
    display:block;
    color:var(--primary);
    font-size:14px;
    letter-spacing:.14em;
    font-weight:950;
}

.sb-brand-text small {
    display:block;
    color:var(--muted);
    font-size:9px;
    letter-spacing:.14em;
    margin-top:3px;
}


/* =========================================================
   PREMIUM RGB GREETING
========================================================= */

.sb-menu-wrap {
    position:relative;
    display:flex;
    align-items:center;
    gap:10px;
}

.sb-greeting {
    position:relative;
    display:flex;
    align-items:center;
    gap:5px;

    padding:10px 16px;

    border-radius:15px;
    border:1px solid transparent;

    background:
        linear-gradient(var(--surface),var(--surface)) padding-box,
        linear-gradient(
            90deg,
            var(--rgb-cyan),
            var(--rgb-blue),
            var(--rgb-purple),
            var(--rgb-pink),
            var(--rgb-red),
            var(--rgb-yellow),
            var(--rgb-cyan)
        ) border-box;

    background-size:100% 100%,500% 100%;

    animation:
        greetingRGB 5s linear infinite,
        greetingFloat 3s ease-in-out infinite;

    color:var(--text);

    font-size:12px;
    font-weight:850;

    white-space:nowrap;

    box-shadow:
        0 8px 28px rgba(0,0,0,.08);
}

.sb-greeting::before {
    content:"";

    width:7px;
    height:7px;

    flex-shrink:0;

    border-radius:50%;

    background:var(--rgb-cyan);

    box-shadow:
        0 0 7px var(--rgb-cyan),
        0 0 16px var(--rgb-purple),
        0 0 28px var(--rgb-pink);

    animation:greetingPulse 1.5s ease-in-out infinite;
}

.sb-greeting strong {
    font-weight:950;

    background:
        linear-gradient(
            90deg,
            var(--rgb-cyan),
            var(--rgb-blue),
            var(--rgb-purple),
            var(--rgb-pink),
            var(--rgb-red),
            var(--rgb-yellow),
            var(--rgb-cyan)
        );

    background-size:500% 100%;

    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;

    animation:rgbText 4s linear infinite;
}

@keyframes greetingRGB {
    from {
        background-position:0 0,0% 50%;
    }
    to {
        background-position:0 0,500% 50%;
    }
}

@keyframes greetingFloat {
    0%,100% {transform:translateY(0);}
    50% {transform:translateY(-2px);}
}

@keyframes greetingPulse {
    0%,100% {
        transform:scale(.75);
        opacity:.55;
    }
    50% {
        transform:scale(1.35);
        opacity:1;
    }
}

@keyframes rgbText {
    from {background-position:0% 50%;}
    to {background-position:500% 50%;}
}


/* =========================================================
   THREE DOT MENU
========================================================= */

.sb-menu-button {
    width:48px;
    height:48px;

    display:grid;
    place-items:center;

    border:1px solid var(--border);
    border-radius:15px;

    background:var(--surface2);
    color:var(--text);

    cursor:pointer;

    font-size:20px;

    transition:.25s ease;

    box-shadow:0 8px 24px var(--shadow);
}

.sb-menu-button:hover,
.sb-menu-button.active {
    color:#fff;
    border-color:transparent;

    background:
        linear-gradient(
            135deg,
            var(--primary),
            var(--primary2)
        );

    transform:translateY(-2px);
}


/* =========================================================
   MENU
========================================================= */

.sb-menu {
    position:absolute;
    top:calc(100% + 12px);
    right:0;

    width:285px;
    padding:10px;

    border:1px solid var(--border);
    border-radius:20px;

    background:var(--surface);
    box-shadow:var(--menu-shadow);

    backdrop-filter:blur(25px);

    opacity:0;
    visibility:hidden;

    transform:translateY(-8px) scale(.97);
    transform-origin:top right;

    transition:
        opacity .2s ease,
        visibility .2s ease,
        transform .2s ease;
}

.sb-menu.open {
    opacity:1;
    visibility:visible;
    transform:translateY(0) scale(1);
}

.sb-menu-header {
    padding:13px 14px;
    margin-bottom:6px;

    border-radius:15px;

    background:
        linear-gradient(
            135deg,
            rgba(0,246,255,.08),
            rgba(139,53,255,.08),
            rgba(255,32,200,.07)
        );

    border:1px solid var(--border);
}

.sb-menu-header strong {
    display:block;
    color:var(--text);
    font-size:14px;
    font-weight:900;
}

.sb-menu-header span {
    display:block;
    margin-top:3px;
    color:var(--muted);
    font-size:11px;
}

.sb-menu-item {
    width:100%;

    display:flex;
    align-items:center;
    gap:12px;

    padding:12px;
    margin:3px 0;

    border:1px solid transparent;
    border-radius:13px;

    color:var(--text);
    background:transparent;

    transition:.18s ease;

    font-size:12px;
    font-weight:800;
}

.sb-menu-item:hover {
    color:var(--primary);
    background:var(--surface2);
    border-color:var(--border);
    transform:translateX(3px);
}

.sb-menu-icon {
    width:35px;
    height:35px;

    display:grid;
    place-items:center;
    flex-shrink:0;

    border-radius:11px;

    color:var(--primary);
    background:rgba(37,99,235,.10);
}

.sb-menu-item.logout {
    color:var(--danger);
}

.sb-menu-item.logout .sb-menu-icon {
    color:var(--danger);
    background:rgba(224,91,114,.10);
}

.sb-menu-divider {
    height:1px;
    margin:8px 4px;
    background:var(--border);
}

.sb-menu-overlay {
    position:fixed;
    inset:0;
    z-index:2500;

    background:rgba(2,6,23,.18);
    backdrop-filter:blur(2px);

    opacity:0;
    visibility:hidden;

    transition:.2s ease;
}

.sb-menu-overlay.open {
    opacity:1;
    visibility:visible;
}


/* =========================================================
   MAIN
========================================================= */

.sb-wrap {
    max-width:1420px;
    margin:auto;
    padding:26px 24px 70px;
}


/* =========================================================
   ULTRA PREMIUM FUTURISTIC HERO
========================================================= */

.hero {
    position:relative;
    isolation:isolate;
    overflow:hidden;

    min-height:325px;

    margin-bottom:30px;
    padding:42px 48px;

    display:flex;
    align-items:center;

    border-radius:34px;

    background:
        linear-gradient(
            135deg,
            color-mix(in srgb,var(--surface) 96%,transparent),
            color-mix(in srgb,var(--surface2) 91%,transparent)
        );

    border:1px solid rgba(255,255,255,.12);

    box-shadow:
        0 30px 90px rgba(0,0,0,.14),
        inset 0 1px 0 rgba(255,255,255,.10);

    animation:heroAppear .8s ease both;
}


/* animated RGB frame */

.hero::before {
    content:"";

    position:absolute;
    inset:-2px;

    z-index:-4;

    border-radius:36px;

    background:
        conic-gradient(
            from 0deg,
            var(--rgb-cyan),
            var(--rgb-blue),
            var(--rgb-purple),
            var(--rgb-pink),
            var(--rgb-red),
            var(--rgb-yellow),
            var(--rgb-cyan)
        );

    filter:blur(2px);

    animation:heroFrame 8s linear infinite;
}

.hero::after {
    content:"";

    position:absolute;
    inset:2px;

    z-index:-3;

    border-radius:32px;

    background:
        linear-gradient(
            135deg,
            color-mix(in srgb,var(--surface) 98%,transparent),
            color-mix(in srgb,var(--surface2) 94%,transparent)
        );
}


/* =========================================================
   RGB LIGHT CLOUDS
========================================================= */

.hero-glow {
    position:absolute;

    width:420px;
    height:420px;

    border-radius:50%;

    filter:blur(70px);

    pointer-events:none;

    opacity:.20;

    z-index:-2;
}

.hero-glow.one {
    right:-80px;
    top:-180px;

    background:
        conic-gradient(
            var(--rgb-cyan),
            var(--rgb-purple),
            var(--rgb-pink),
            var(--rgb-cyan)
        );

    animation:glowOne 9s ease-in-out infinite;
}

.hero-glow.two {
    left:-160px;
    bottom:-250px;

    background:
        radial-gradient(
            circle,
            var(--rgb-cyan),
            var(--rgb-blue),
            transparent 68%
        );

    animation:glowTwo 8s ease-in-out infinite;
}

.hero-glow.three {
    right:28%;
    bottom:-300px;

    width:300px;
    height:300px;

    background:
        radial-gradient(
            circle,
            var(--rgb-pink),
            var(--rgb-purple),
            transparent 70%
        );

    opacity:.11;

    animation:glowThree 7s ease-in-out infinite;
}

@keyframes glowOne {
    0%,100% {
        transform:translate(0,0) scale(1);
    }
    50% {
        transform:translate(-100px,90px) scale(1.25);
    }
}

@keyframes glowTwo {
    0%,100% {
        transform:translate(0,0);
    }
    50% {
        transform:translate(120px,-40px) scale(1.2);
    }
}

@keyframes glowThree {
    0%,100% {
        transform:translateX(0);
    }
    50% {
        transform:translateX(-80px) scale(1.2);
    }
}


/* =========================================================
   HERO GRID
========================================================= */

.hero-grid {
    position:absolute;
    inset:0;

    z-index:-1;

    opacity:.16;

    background-image:
        linear-gradient(
            rgba(0,246,255,.10) 1px,
            transparent 1px
        ),
        linear-gradient(
            90deg,
            rgba(139,53,255,.10) 1px,
            transparent 1px
        );

    background-size:38px 38px;

    mask-image:
        radial-gradient(
            circle at 75% 50%,
            black,
            transparent 70%
        );

    animation:gridMove 16s linear infinite;
}

@keyframes gridMove {
    from {
        transform:translate(0,0);
    }
    to {
        transform:translate(38px,38px);
    }
}


/* =========================================================
   LIGHT SWEEP
========================================================= */

.hero-light {
    position:absolute;

    top:-100%;
    left:-30%;

    width:24%;
    height:300%;

    z-index:1;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.75),
            transparent
        );

    filter:blur(12px);

    opacity:.12;

    transform:rotate(22deg);

    animation:lightSweep 7s ease-in-out infinite;
}

@keyframes lightSweep {
    0%,25% {
        left:-35%;
    }
    70%,100% {
        left:125%;
    }
}


/* =========================================================
   HERO CONTENT
========================================================= */

.hero-content {
    position:relative;
    z-index:10;

    max-width:720px;
}

.eyebrow {
    display:inline-flex;
    align-items:center;
    gap:9px;

    padding:8px 14px;

    border-radius:999px;

    border:1px solid transparent;

    background:
        linear-gradient(var(--surface),var(--surface)) padding-box,
        linear-gradient(
            90deg,
            var(--rgb-cyan),
            var(--rgb-blue),
            var(--rgb-purple),
            var(--rgb-pink),
            var(--rgb-yellow),
            var(--rgb-cyan)
        ) border-box;

    background-size:100% 100%,500% 100%;

    color:transparent;

    font-size:9px;
    font-weight:950;
    letter-spacing:.16em;

    -webkit-background-clip:padding-box;

    animation:
        eyebrowRGB 4s linear infinite,
        heroEntry .7s ease both;
}

.eyebrow i {
    background:
        linear-gradient(
            90deg,
            var(--rgb-cyan),
            var(--rgb-purple),
            var(--rgb-pink),
            var(--rgb-yellow)
        );

    background-size:300% 100%;

    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;

    animation:
        rgbText 3s linear infinite,
        magicPulse 2s ease-in-out infinite;
}

.eyebrow {
    background:
        linear-gradient(var(--surface),var(--surface)) padding-box,
        linear-gradient(
            90deg,
            var(--rgb-cyan),
            var(--rgb-blue),
            var(--rgb-purple),
            var(--rgb-pink),
            var(--rgb-red),
            var(--rgb-yellow),
            var(--rgb-cyan)
        ) border-box;

    color:var(--text);
}

@keyframes eyebrowRGB {
    from {
        background-position:0 0,0% 50%;
    }
    to {
        background-position:0 0,500% 50%;
    }
}

@keyframes magicPulse {
    0%,100% {
        transform:scale(1) rotate(0);
    }
    50% {
        transform:scale(1.22) rotate(12deg);
    }
}


/* =========================================================
   HERO TITLE — FULL RGB
========================================================= */

.hero h1 {
    margin:18px 0 13px;

    font-size:clamp(40px,5vw,68px);
    line-height:.98;

    letter-spacing:-.065em;
    font-weight:950;

    animation:heroEntry .8s ease .08s both;

    background:
        linear-gradient(
            90deg,
            var(--rgb-cyan),
            var(--rgb-blue),
            var(--rgb-purple),
            var(--rgb-pink),
            var(--rgb-red),
            var(--rgb-yellow),
            var(--rgb-cyan)
        );

    background-size:600% 100%;

    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;

    animation:
        heroEntry .8s ease .08s both,
        rgbTitle 6s linear infinite;
}

.hero h1 .hero-gradient {
    display:inline;

    background:
        linear-gradient(
            90deg,
            var(--rgb-pink),
            var(--rgb-purple),
            var(--rgb-blue),
            var(--rgb-cyan),
            var(--rgb-yellow),
            var(--rgb-pink)
        );

    background-size:600% 100%;

    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;

    animation:rgbTitle 5s linear infinite reverse;
}

@keyframes rgbTitle {
    from {
        background-position:0% 50%;
    }
    to {
        background-position:600% 50%;
    }
}


/* =========================================================
   HERO SUBTITLE — RGB WORD HIGHLIGHT
========================================================= */

.hero-subtitle {
    max-width:600px;

    margin:0;

    color:var(--muted);

    font-size:13px;
    line-height:1.75;

    animation:heroEntry .8s ease .16s both;
}

.hero-subtitle strong {
    font-weight:950;

    background:
        linear-gradient(
            90deg,
            var(--rgb-cyan),
            var(--rgb-blue),
            var(--rgb-purple),
            var(--rgb-pink),
            var(--rgb-yellow),
            var(--rgb-cyan)
        );

    background-size:500% 100%;

    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;

    animation:rgbText 4s linear infinite;
}


/* =========================================================
   HERO BUTTONS
========================================================= */

.hero-actions {
    display:flex;
    gap:10px;
    flex-wrap:wrap;

    margin-top:21px;

    animation:heroEntry .8s ease .22s both;
}

.hero-btn {
    min-height:44px;

    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    padding:0 17px;

    border-radius:13px;

    font-size:10px;
    font-weight:900;

    transition:.25s ease;
}

.hero-btn-primary {
    color:#fff;

    background:
        linear-gradient(
            110deg,
            var(--rgb-cyan),
            var(--rgb-blue),
            var(--rgb-purple),
            var(--rgb-pink),
            var(--rgb-red),
            var(--rgb-yellow),
            var(--rgb-cyan)
        );

    background-size:600% 100%;

    box-shadow:
        0 12px 35px rgba(75,80,255,.25);

    animation:buttonRGB 5s linear infinite;
}

.hero-btn-primary:hover {
    color:#fff;
    transform:translateY(-3px) scale(1.025);

    box-shadow:
        0 18px 48px rgba(139,53,255,.35);
}

.hero-btn-secondary {
    color:var(--text);

    border:1px solid var(--border);

    background:
        color-mix(
            in srgb,
            var(--surface) 76%,
            transparent
        );

    backdrop-filter:blur(15px);
}

.hero-btn-secondary:hover {
    color:var(--rgb-purple);
    border-color:var(--rgb-purple);

    transform:translateY(-3px);
}

@keyframes buttonRGB {
    from {background-position:0% 50%;}
    to {background-position:600% 50%;}
}


/* =========================================================
   FUTURISTIC SHOPPING CORE
========================================================= */

.hero-art {
    position:absolute;

    right:15px;
    top:50%;

    width:390px;
    height:310px;

    transform:translateY(-50%);

    z-index:5;

    pointer-events:none;
}


/* central energy sphere */

.rgb-core {
    position:absolute;

    left:50%;
    top:50%;

    width:165px;
    height:165px;

    transform:translate(-50%,-50%);

    border-radius:50%;

    background:
        radial-gradient(
            circle at 30% 25%,
            rgba(255,255,255,.95) 0 4%,
            transparent 13%
        ),
        conic-gradient(
            from 0deg,
            var(--rgb-cyan),
            var(--rgb-blue),
            var(--rgb-purple),
            var(--rgb-pink),
            var(--rgb-red),
            var(--rgb-yellow),
            var(--rgb-cyan)
        );

    box-shadow:
        0 0 30px var(--rgb-cyan),
        0 0 65px rgba(139,53,255,.7),
        0 0 110px rgba(255,32,200,.38);

    animation:
        coreRotate 7s linear infinite,
        corePulse 3s ease-in-out infinite;
}

.rgb-core::before {
    content:"";

    position:absolute;
    inset:12px;

    border-radius:50%;

    background:
        radial-gradient(
            circle at 30% 25%,
            rgba(255,255,255,.20),
            transparent 35%
        ),
        color-mix(
            in srgb,
            var(--surface) 88%,
            transparent
        );

    backdrop-filter:blur(4px);

    box-shadow:
        inset 0 0 35px rgba(0,246,255,.16);
}

.rgb-core::after {
    content:"";

    position:absolute;
    inset:-22px;

    border-radius:50%;

    border:1px solid rgba(0,246,255,.30);

    box-shadow:
        0 0 20px rgba(0,246,255,.20);

    animation:coreHalo 2.5s ease-in-out infinite;
}

@keyframes coreRotate {
    from {
        transform:translate(-50%,-50%) rotate(0deg);
    }
    to {
        transform:translate(-50%,-50%) rotate(360deg);
    }
}

@keyframes corePulse {
    0%,100% {
        scale:.94;
    }
    50% {
        scale:1.06;
    }
}

@keyframes coreHalo {
    0%,100% {
        transform:scale(.9);
        opacity:.35;
    }
    50% {
        transform:scale(1.18);
        opacity:.8;
    }
}


/* basket center */

.hero-basket {
    position:absolute;

    left:50%;
    top:50%;

    z-index:15;

    width:78px;
    height:78px;

    display:grid;
    place-items:center;

    transform:translate(-50%,-50%);

    border-radius:25px;

    color:#fff;

    font-size:31px;

    background:
        linear-gradient(
            135deg,
            rgba(0,246,255,.96),
            rgba(139,53,255,.96),
            rgba(255,32,200,.96)
        );

    background-size:300% 300%;

    box-shadow:
        0 18px 40px rgba(0,0,0,.25),
        0 0 30px rgba(0,246,255,.40);

    animation:
        basketRGB 4s linear infinite,
        basketFloat 3s ease-in-out infinite;
}

@keyframes basketRGB {
    from {background-position:0% 50%;}
    to {background-position:300% 50%;}
}

@keyframes basketFloat {
    0%,100% {
        transform:translate(-50%,-50%) rotate(-2deg);
    }
    50% {
        transform:translate(-50%,-57%) rotate(2deg);
    }
}


/* =========================================================
   ORBIT RINGS
========================================================= */

.core-ring {
    position:absolute;

    left:50%;
    top:50%;

    border-radius:50%;

    transform:translate(-50%,-50%);

    border:1px solid;
}

.core-ring.one {
    width:215px;
    height:215px;

    border-color:rgba(0,246,255,.42);

    animation:ringA 7s linear infinite;
}

.core-ring.two {
    width:285px;
    height:150px;

    border-color:rgba(255,32,200,.42);

    animation:ringB 10s linear infinite reverse;
}

.core-ring.three {
    width:320px;
    height:105px;

    border-color:rgba(255,228,92,.34);

    animation:ringC 13s linear infinite;
}

.core-ring.four {
    width:250px;
    height:275px;

    border-color:rgba(139,53,255,.25);

    animation:ringD 11s linear infinite reverse;
}

@keyframes ringA {
    to {
        transform:translate(-50%,-50%) rotate(360deg);
    }
}

@keyframes ringB {
    to {
        transform:translate(-50%,-50%) rotate(-360deg);
    }
}

@keyframes ringC {
    to {
        transform:translate(-50%,-50%) rotate(360deg);
    }
}

@keyframes ringD {
    to {
        transform:translate(-50%,-50%) rotate(-360deg);
    }
}


/* =========================================================
   FLOATING RGB PARTICLES
========================================================= */

.core-particle {
    position:absolute;

    width:7px;
    height:7px;

    border-radius:50%;

    box-shadow:
        0 0 9px currentColor,
        0 0 22px currentColor,
        0 0 40px currentColor;
}

.core-particle.p1 {
    top:25px;
    right:100px;
    color:var(--rgb-cyan);
    animation:particleOne 4s ease-in-out infinite;
}

.core-particle.p2 {
    top:115px;
    right:12px;
    color:var(--rgb-pink);
    animation:particleTwo 5s ease-in-out infinite;
}

.core-particle.p3 {
    bottom:30px;
    right:100px;
    color:var(--rgb-yellow);
    animation:particleThree 4.5s ease-in-out infinite;
}

.core-particle.p4 {
    bottom:65px;
    left:25px;
    color:var(--rgb-purple);
    animation:particleFour 5.5s ease-in-out infinite;
}

.core-particle.p5 {
    top:70px;
    left:25px;
    color:var(--rgb-blue);
    animation:particleFive 4.2s ease-in-out infinite;
}

@keyframes particleOne {
    0%,100% {transform:translate(0,0) scale(.7);}
    50% {transform:translate(-15px,18px) scale(1.3);}
}

@keyframes particleTwo {
    0%,100% {transform:translate(0,0);}
    50% {transform:translate(-18px,-12px) scale(1.35);}
}

@keyframes particleThree {
    0%,100% {transform:translate(0,0) scale(.8);}
    50% {transform:translate(15px,-20px) scale(1.3);}
}

@keyframes particleFour {
    0%,100% {transform:translate(0,0);}
    50% {transform:translate(25px,10px) scale(1.4);}
}

@keyframes particleFive {
    0%,100% {transform:translate(0,0);}
    50% {transform:translate(15px,-20px) scale(1.25);}
}


/* =========================================================
   GLASS INFO CARDS
========================================================= */

.hero-float {
    position:absolute;

    z-index:20;

    display:flex;
    align-items:center;
    gap:8px;

    padding:9px 12px;

    border:1px solid rgba(255,255,255,.18);
    border-radius:14px;

    background:
        color-mix(
            in srgb,
            var(--surface) 68%,
            transparent
        );

    backdrop-filter:blur(18px);

    box-shadow:
        0 16px 38px rgba(0,0,0,.15);

    animation:floatCard 4s ease-in-out infinite;
}

.hero-float.one {
    top:18px;
    right:20px;
}

.hero-float.two {
    bottom:18px;
    left:15px;

    animation-delay:1.2s;
}

.hero-float-icon {
    width:29px;
    height:29px;

    display:grid;
    place-items:center;

    border-radius:9px;

    color:var(--rgb-cyan);

    background:rgba(0,246,255,.09);

    box-shadow:
        inset 0 0 12px rgba(0,246,255,.08);
}

.hero-float strong {
    display:block;
    color:var(--text);
    font-size:11px;
    line-height:1;
}

.hero-float small {
    display:block;
    margin-top:3px;
    color:var(--muted);
    font-size:7px;
    letter-spacing:.05em;
}

@keyframes floatCard {
    0%,100% {
        transform:translateY(0);
    }
    50% {
        transform:translateY(-8px);
    }
}


/* =========================================================
   HERO ENTRY
========================================================= */

@keyframes heroEntry {
    from {
        opacity:0;
        transform:translateY(20px);
    }
    to {
        opacity:1;
        transform:translateY(0);
    }
}

@keyframes heroAppear {
    from {
        opacity:0;
        transform:translateY(18px) scale(.985);
    }
    to {
        opacity:1;
        transform:translateY(0) scale(1);
    }
}

@keyframes heroFrame {
    from {
        transform:rotate(0deg);
    }
    to {
        transform:rotate(360deg);
    }
}


/* =========================================================
   PRODUCTS / FILTERS
========================================================= */

.section-head {
    display:flex;
    align-items:end;
    justify-content:space-between;
    gap:15px;
    margin:30px 0 14px;
}

.section-head h2 {
    margin:0;
    color:var(--text);
    font-size:27px;
    font-weight:950;
    letter-spacing:-.03em;
}

.section-head p {
    margin:5px 0 0;
    color:var(--muted);
    font-size:12px;
}

.count {
    padding:8px 12px;
    border:1px solid var(--border);
    border-radius:999px;
    background:var(--surface);
    color:var(--muted);
    font-size:11px;
    font-weight:800;
}

.filters {
    margin-bottom:25px;
    padding:18px;

    border:1px solid var(--border);
    border-radius:20px;

    background:var(--surface);

    box-shadow:0 10px 35px var(--shadow);
}

.filters label {
    display:block;
    margin-bottom:6px;

    color:var(--muted);

    font-size:10px;
    font-weight:900;

    text-transform:uppercase;
    letter-spacing:.08em;
}

.filters .form-control,
.filters .form-select {
    min-height:45px;

    border:1px solid var(--border);
    border-radius:12px;

    background:var(--surface2);
    color:var(--text);

    font-size:13px;
}

.filters .form-control::placeholder {
    color:var(--muted);
}

.filters .form-control:focus,
.filters .form-select:focus {
    border-color:var(--primary);
    box-shadow:0 0 0 3px rgba(37,99,235,.10);
}

.apply {
    height:45px;

    border:0;
    border-radius:12px;

    color:#fff;

    background:
        linear-gradient(
            135deg,
            var(--primary),
            var(--primary2)
        );

    font-weight:900;
}


/* =========================================================
   PRODUCT CARDS
========================================================= */

.product-card {
    height:100%;
    position:relative;
    overflow:hidden;

    display:flex;
    flex-direction:column;

    border:1px solid var(--border) !important;
    border-radius:23px !important;

    background:var(--surface) !important;

    box-shadow:0 10px 35px var(--shadow) !important;

    transition:
        transform .28s ease,
        box-shadow .28s ease,
        border-color .28s ease;
}

.product-card:hover {
    transform:translateY(-7px);

    border-color:
        color-mix(
            in srgb,
            var(--primary) 55%,
            var(--border)
        ) !important;

    box-shadow:0 22px 55px var(--shadow) !important;
}

.product-card--clickable {
    cursor:pointer;
}

.media {
    height:255px;

    position:relative;

    display:grid;
    place-items:center;

    overflow:hidden;

    background:
        radial-gradient(
            circle at center,
            rgba(37,99,235,.08),
            transparent 65%
        ),
        var(--surface2);
}

.media img {
    width:100%;
    height:100%;

    object-fit:contain;
    padding:17px;

    transition:.35s ease;
}

.product-card:hover .media img {
    transform:scale(1.045);
}

.discount {
    position:absolute;
    left:12px;
    top:12px;

    padding:7px 9px;

    border-radius:9px;

    color:var(--success);
    background:#eaf9ef;

    font-size:10px;
    font-weight:950;
}

html[data-theme="dark"] .discount {
    background:rgba(69,207,140,.12);
}

.wishlist {
    position:absolute;
    right:12px;
    top:12px;

    width:39px;
    height:39px;

    display:grid;
    place-items:center;

    border:1px solid var(--border);
    border-radius:50%;

    background:var(--surface);
    color:var(--danger);

    box-shadow:0 8px 20px var(--shadow);

    transition:.2s ease;
    cursor:pointer;
}

.wishlist:hover {
    transform:scale(1.08);
    border-color:var(--danger);
}

.body {
    padding:17px;

    display:flex;
    flex-direction:column;
    flex:1;
}

.category {
    color:var(--primary);
    font-size:9px;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:.1em;
}

.title {
    margin:5px 0;

    color:var(--text);

    font-size:16px;
    line-height:1.35;
    font-weight:900;

    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.rating {
    display:flex;
    align-items:center;
    gap:5px;

    margin:5px 0 8px;

    color:var(--muted);
    font-size:11px;
}

.rating i {
    color:#f5b82e;
}

.description {
    min-height:51px;

    margin:0 0 10px;

    color:var(--muted);

    font-size:11px;
    line-height:1.55;

    display:-webkit-box;
    -webkit-line-clamp:3;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.price {
    color:var(--text);
    font-size:22px;
    font-weight:950;
}

.old {
    margin-left:7px;
    color:var(--muted);
    font-size:11px;
}

.stock {
    margin:3px 0 12px;

    color:var(--success);

    font-size:10px;
    font-weight:800;
}

.stock.out {
    color:var(--danger);
}

.actions {
    display:grid;
    grid-template-columns:1fr 1fr 1fr;
    gap:7px;
    margin-top:auto;
}

.action {
    min-height:40px;

    display:flex;
    align-items:center;
    justify-content:center;
    gap:5px;

    padding:7px;

    border:1px solid var(--border);
    border-radius:10px;

    background:var(--surface2);
    color:var(--text);

    font-size:10px;
    font-weight:900;

    transition:.2s ease;
}

.action:hover {
    color:var(--primary);
    border-color:var(--primary);
    transform:translateY(-1px);
}

.action.primary {
    color:#fff;
    border-color:transparent;

    background:
        linear-gradient(
            135deg,
            var(--primary),
            var(--primary2)
        );
}

.action.primary:hover {
    color:#fff;
}

.action:disabled {
    opacity:.5;
    cursor:not-allowed;
    transform:none !important;
}


/* =========================================================
   EMPTY / PAGINATION / FOOTER
========================================================= */

.empty {
    padding:70px 20px;

    text-align:center;

    border:1px dashed var(--border);
    border-radius:22px;

    background:var(--surface);
}

.empty i {
    margin-bottom:15px;
    color:var(--primary);
    font-size:35px;
}

.empty h3 {
    color:var(--text);
    font-weight:900;
}

.empty p {
    color:var(--muted);
}

.pagination {
    gap:5px;
    flex-wrap:wrap;
}

.pagination .page-link {
    border:1px solid var(--border);
    border-radius:10px !important;

    background:var(--surface);
    color:var(--text);
}

.pagination .active .page-link {
    color:#fff;
    border-color:var(--primary);
    background:var(--primary);
}

.footer {
    padding:35px 0 55px;

    text-align:center;

    color:var(--muted);
    font-size:10px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width:1100px) {

    .hero-art {
        right:-65px;
        opacity:.58;
    }

    .hero-content {
        max-width:650px;
    }
}

@media (max-width:900px) {

    .hero-art {
        display:none;
    }

    .hero {
        min-height:290px;
        padding:36px 38px;
    }

    .hero-content {
        max-width:100%;
    }
}

@media (max-width:768px) {

    .sb-topbar {
        padding:10px 13px;
        min-height:68px;
    }

    .sb-brand-text small {
        display:none;
    }

    .sb-brand-icon {
        width:42px;
        height:42px;
    }

    .sb-menu-wrap {
        gap:6px;
    }

    .sb-greeting {
        padding:8px 10px;
        font-size:11px;
        border-radius:11px;
    }

    .sb-menu-button {
        width:43px;
        height:43px;
    }

    .sb-menu {
        position:fixed;
        top:72px;
        right:12px;

        width:min(
            300px,
            calc(100vw - 24px)
        );
    }

    .sb-wrap {
        padding:18px 13px 55px;
    }

    .hero {
        min-height:270px;
        padding:31px 23px;
        border-radius:25px;
    }

    .hero h1 {
        font-size:42px;
    }

    .hero-subtitle {
        font-size:12px;
    }

    .hero-actions {
        flex-direction:column;
    }

    .hero-btn {
        width:100%;
    }

    .media {
        height:220px;
    }

    .actions {
        grid-template-columns:1fr 1fr;
    }

    .actions .cart-action {
        grid-column:1 / -1;
    }
}

@media (max-width:430px) {

    .section-head {
        align-items:flex-start;
        flex-direction:column;
    }

    .hero {
        padding:28px 19px;
    }

    .hero h1 {
        font-size:37px;
    }

    .sb-greeting {
        max-width:135px;
        overflow:hidden;
        text-overflow:ellipsis;
    }

    .media {
        height:205px;
    }
}

@media (prefers-reduced-motion:reduce) {

    *,
    *::before,
    *::after {
        animation-duration:.01ms !important;
        animation-iteration-count:1 !important;
        transition-duration:.01ms !important;
    }
}

</style>
</head>

<body>


<!-- MENU OVERLAY -->

<div
    class="sb-menu-overlay"
    id="sbMenuOverlay"
    hidden
></div>


<!-- TOP BAR -->

<header class="sb-topbar">

    <a
        href="{{ route('products.index') }}"
        class="sb-brand"
    >

        <span class="sb-brand-icon">
            <i class="fa-solid fa-basket-shopping"></i>
        </span>

        <span class="sb-brand-text">

            <strong>SMART BASKET</strong>

            <small>SMARTER WAY TO SHOP</small>

        </span>

    </a>


    @auth
        <x-smart-ai-robot />
    @endauth


    <div class="sb-menu-wrap">

        @auth

            <span class="sb-greeting">

                Hi,

                <strong>
                    {{ auth()->user()->name ?? 'Customer' }}
                </strong>

            </span>

        @endauth


        <button
            type="button"
            class="sb-menu-button"
            id="sbMenuButton"
            aria-label="Open menu"
            aria-expanded="false"
        >

            <i class="fa-solid fa-ellipsis-vertical"></i>

        </button>


        <div
            class="sb-menu"
            id="sbMenu"
        >

            <div class="sb-menu-header">

                @auth

                    <strong>
                        Hi, {{ auth()->user()->name ?? 'Customer' }}
                    </strong>

                    <span>
                        Manage your Smart Basket account
                    </span>

                @else

                    <strong>SMART BASKET</strong>

                    <span>
                        Your smarter shopping menu
                    </span>

                @endauth

            </div>


            <a
                href="{{ route('products.index') }}"
                class="sb-menu-item"
            >

                <span class="sb-menu-icon">
                    <i class="fa-solid fa-house"></i>
                </span>

                <span>Home / Products</span>

            </a>


            <a
                href="{{ route('cart.index') }}"
                class="sb-menu-item"
            >

                <span class="sb-menu-icon">
                    <i class="fa-solid fa-cart-shopping"></i>
                </span>

                <span>My Cart</span>

            </a>


            @auth

                <a
                    href="{{ route('wishlist') }}"
                    class="sb-menu-item"
                >

                    <span class="sb-menu-icon">
                        <i class="fa-regular fa-heart"></i>
                    </span>

                    <span>Wishlist</span>

                </a>


                @if(Route::has('profile'))

                    <a
                        href="{{ route('profile') }}"
                        class="sb-menu-item"
                    >

                        <span class="sb-menu-icon">
                            <i class="fa-solid fa-user"></i>
                        </span>

                        <span>My Profile</span>

                    </a>

                @endif


                @if(Route::has('orders'))

                    <a
                        href="{{ route('orders') }}"
                        class="sb-menu-item"
                    >

                        <span class="sb-menu-icon">
                            <i class="fa-solid fa-box"></i>
                        </span>

                        <span>My Orders</span>

                    </a>

                @endif


                @if(Route::has('settings'))

                    <a
                        href="{{ route('settings') }}"
                        class="sb-menu-item"
                    >

                        <span class="sb-menu-icon">
                            <i class="fa-solid fa-gear"></i>
                        </span>

                        <span>Settings</span>

                    </a>

                @endif


                <div class="sb-menu-divider"></div>


                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    style="margin:0"
                >

                    @csrf

                    <button
                        type="submit"
                        class="sb-menu-item logout"
                    >

                        <span class="sb-menu-icon">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </span>

                        <span>Logout</span>

                    </button>

                </form>

            @endauth

        </div>

    </div>

</header>


<div class="sb-wrap">


<!-- =========================================================
     PREMIUM RGB HERO
========================================================= -->

<section class="hero">

    <div class="hero-glow one"></div>
    <div class="hero-glow two"></div>
    <div class="hero-glow three"></div>

    <div class="hero-grid"></div>

    <div class="hero-light"></div>


    <div class="hero-content">

        <span class="eyebrow">

            <i class="fa-solid fa-wand-magic-sparkles"></i>

            SMART SHOPPING EXPERIENCE

        </span>


        <h1>

            Shop smarter.

            <br>

            <span class="hero-gradient">
                Live better.
            </span>

        </h1>


        <p class="hero-subtitle">

            Discover
            <strong>quality products</strong>
            with a beautiful, fast and intelligent
            shopping experience designed for you.

        </p>


        <div class="hero-actions">

            <a
                href="#products"
                class="hero-btn hero-btn-primary"
            >

                <i class="fa-solid fa-bag-shopping"></i>

                <span>
                    Explore Products
                </span>

                <i class="fa-solid fa-arrow-right"></i>

            </a>


            <a
                href="#products"
                class="hero-btn hero-btn-secondary"
            >

                <i class="fa-solid fa-sparkles"></i>

                <span>
                    Start Shopping
                </span>

            </a>

        </div>

    </div>


    <!-- FUTURISTIC RGB SHOPPING CORE -->

    <div class="hero-art">

        <div class="core-ring one"></div>
        <div class="core-ring two"></div>
        <div class="core-ring three"></div>
        <div class="core-ring four"></div>


        <span class="core-particle p1"></span>
        <span class="core-particle p2"></span>
        <span class="core-particle p3"></span>
        <span class="core-particle p4"></span>
        <span class="core-particle p5"></span>


        <div class="rgb-core"></div>


        <div class="hero-basket">

            <i class="fa-solid fa-basket-shopping"></i>

        </div>


        <div class="hero-float one">

            <span class="hero-float-icon">
                <i class="fa-solid fa-box-open"></i>
            </span>

            <div>

                <strong>
                    {{ $pagedProducts->total() }}
                </strong>

                <small>
                    PRODUCTS
                </small>

            </div>

        </div>


        <div class="hero-float two">

            <span class="hero-float-icon">
                <i class="fa-solid fa-bolt"></i>
            </span>

            <div>

                <strong>24/7</strong>

                <small>
                    SMART SHOPPING
                </small>

            </div>

        </div>

    </div>

</section>


<!-- PRODUCTS -->

<div
    class="section-head"
    id="products"
>

    <div>

        <h2>
            Find your next favorite
        </h2>

        <p>
            Fresh products added by sellers,
            ready for customers.
        </p>

    </div>


    <span class="count">

        {{ $pagedProducts->total() }}

        Products

    </span>

</div>


<!-- FILTERS -->

<form
    method="GET"
    action="{{ route('products.index') }}"
    class="filters"
>

    <div class="row g-3">

        <div class="col-12 col-md-6">

            <label>
                Search products
            </label>

            <input
                type="text"
                name="search"
                class="form-control"
                value="{{ $search }}"
                placeholder="Search by product name..."
            >

        </div>


        <div class="col-12 col-md-4">

            <label>
                Category
            </label>

            <select
                name="category"
                class="form-select"
            >

                <option value="">
                    All Categories
                </option>

                @foreach($categories as $categoryOption)

                    <option
                        value="{{ $categoryOption }}"
                        {{ $category === $categoryOption ? 'selected' : '' }}
                    >
                        {{ $categoryOption }}
                    </option>

                @endforeach

            </select>

        </div>


        <div class="col-12 col-md-2 d-flex align-items-end">

            <button
                class="apply w-100"
                type="submit"
            >

                <i class="fa-solid fa-magnifying-glass me-1"></i>

                Apply

            </button>

        </div>

    </div>

</form>


<!-- FEATURED -->

<div class="section-head">

    <div>

        <h2>
            Featured products
        </h2>

        <p>
            Curated products selected for you.
        </p>

    </div>


    <span class="count">

        Showing
        {{ $pagedProducts->count() }}
        of
        {{ $pagedProducts->total() }}

    </span>

</div>


@if($pagedProducts->count() > 0)

    <div class="row g-4">

        @foreach($pagedProducts as $product)

            @php

                $originalPrice =
                    (float) $product->price;

                $currentPrice =
                    (float) (
                        $product->discount_price
                        ?: $product->price
                    );

                $hasDiscount =
                    $currentPrice > 0 &&
                    $originalPrice > $currentPrice;

                $discountPercent =
                    $hasDiscount
                    ? round(
                        (
                            ($originalPrice - $currentPrice)
                            / $originalPrice
                        ) * 100
                    )
                    : 0;

            @endphp


            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                <article
                    class="product-card product-card--clickable"
                    data-smart-ai-product-id="{{ $product->id }}"
                    data-product-url="{{ route('product.show', $product) }}"
                    tabindex="0"
                    role="link"
                    aria-label="View {{ $product->name }}"
                >

                    <div class="media">

                        <img
                            src="{{ asset('products/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            loading="lazy"
                            onerror="this.style.display='none';this.nextElementSibling.hidden=false;"
                        >

                        <div
                            hidden
                            style="text-align:center;color:var(--muted)"
                        >

                            <i class="fa-solid fa-image fa-2x mb-2"></i>

                            <div>
                                No image
                            </div>

                        </div>


                        @if($hasDiscount)

                            <span class="discount">
                                {{ $discountPercent }}% OFF
                            </span>

                        @endif


                        @auth

                            <form
                                method="POST"
                                action="{{ route('wishlist.add', $product->id) }}"
                                class="product-card-action"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="wishlist"
                                    title="Add to wishlist"
                                >

                                    <i class="fa-regular fa-heart"></i>

                                </button>

                            </form>

                        @endauth

                    </div>


                    <div class="body">

                        <div class="category">
                            {{ $product->category ?: 'General' }}
                        </div>


                        <h3 class="title">
                            {{ $product->name }}
                        </h3>


                        <div class="rating">

                            <i class="fa-solid fa-star"></i>

                            <strong>
                                {{ number_format((float)$product->rating, 1) }}
                            </strong>

                            <span>•</span>

                            <span>
                                {{ $product->stock ?? 0 }} left
                            </span>

                        </div>


                        <p class="description">

                            {{
                                $product->description
                                ? \Illuminate\Support\Str::limit(
                                    $product->description,
                                    95
                                )
                                : 'Premium quality product from Smart Basket.'
                            }}

                        </p>


                        <div class="price">

                            ₹{{ number_format($currentPrice, 2) }}

                            @if($hasDiscount)

                                <del class="old">

                                    ₹{{ number_format($originalPrice, 2) }}

                                </del>

                            @endif

                        </div>


                        <div
                            class="stock {{ (int)$product->stock < 1 ? 'out' : '' }}"
                        >

                            <i
                                class="fa-solid {{
                                    (int)$product->stock > 0
                                    ? 'fa-circle-check'
                                    : 'fa-circle-xmark'
                                }}"
                            ></i>

                            {{
                                (int)$product->stock > 0
                                ? 'In Stock'
                                : 'Sold Out'
                            }}

                        </div>


                        <div class="actions product-card-action">

                            <a
                                href="{{ route('product.show', $product) }}"
                                class="action"
                            >

                                <i class="fa-regular fa-eye"></i>

                                View Product

                            </a>


                            <a
                                href="{{ url('/buy-now/' . $product->id) }}"
                                class="action"
                            >

                                <i class="fa-solid fa-bolt"></i>

                                Buy

                            </a>


                            <form
                                action="{{ route('cart.add', $product->id) }}"
                                method="POST"
                                class="cart-action"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="action primary w-100"
                                    {{ (int)$product->stock < 1 ? 'disabled' : '' }}
                                >

                                    <i class="fa-solid fa-cart-plus"></i>

                                    Cart

                                </button>

                            </form>

                        </div>

                    </div>

                </article>

            </div>

        @endforeach

    </div>


    <div class="d-flex justify-content-center mt-5">

        {{
            $pagedProducts
                ->appends(request()->query())
                ->links('pagination::bootstrap-5')
        }}

    </div>


@else

    <div class="empty">

        <i class="fa-solid fa-box-open"></i>

        <h3>
            No products found
        </h3>

        <p>
            Try adjusting your search or category filter.
        </p>

        <a
            href="{{ route('products.index') }}"
            class="action d-inline-flex mt-2 px-4"
        >
            Clear filters
        </a>

    </div>

@endif


<div class="footer">

    © {{ date('Y') }}

    SMART BASKET

    · Quality products, smarter shopping.

</div>

</div>


<x-site-menu />

<x-ai-hub-sidebar :without-menu="true" />


<script>

(() => {

    const menuButton =
        document.getElementById('sbMenuButton');

    const menu =
        document.getElementById('sbMenu');

    const overlay =
        document.getElementById('sbMenuOverlay');


    function openMenu() {

        menu.classList.add('open');

        overlay.classList.add('open');

        overlay.hidden = false;

        menuButton.classList.add('active');

        menuButton.setAttribute(
            'aria-expanded',
            'true'
        );
    }


    function closeMenu() {

        menu.classList.remove('open');

        overlay.classList.remove('open');

        menuButton.classList.remove('active');

        menuButton.setAttribute(
            'aria-expanded',
            'false'
        );

        setTimeout(() => {

            if (!overlay.classList.contains('open')) {
                overlay.hidden = true;
            }

        }, 200);
    }


    menuButton.addEventListener(
        'click',
        event => {

            event.stopPropagation();

            if (menu.classList.contains('open')) {
                closeMenu();
            } else {
                openMenu();
            }

        }
    );


    overlay.addEventListener(
        'click',
        closeMenu
    );


    document.addEventListener(
        'keydown',
        event => {

            if (event.key === 'Escape') {
                closeMenu();
            }

        }
    );


    document
        .querySelectorAll('.sb-menu a')
        .forEach(link => {

            link.addEventListener(
                'click',
                closeMenu
            );

        });


    document
        .querySelectorAll('.product-card-action')
        .forEach(element => {

            element.addEventListener(
                'click',
                event => {
                    event.stopPropagation();
                }
            );

        });


    document
        .querySelectorAll('.product-card--clickable')
        .forEach(card => {

            const visitProduct = event => {

                if (
                    event.target.closest(
                        'a, button, form, input, select, textarea, label'
                    )
                ) {
                    return;
                }

                window.location.href =
                    card.dataset.productUrl;
            };


            card.addEventListener(
                'click',
                visitProduct
            );


            card.addEventListener(
                'keydown',
                event => {

                    if (
                        (
                            event.key === 'Enter' ||
                            event.key === ' '
                        )
                        &&
                        !event.target.closest(
                            'a, button, form, input, select, textarea, label'
                        )
                    ) {

                        event.preventDefault();

                        window.location.href =
                            card.dataset.productUrl;
                    }

                }
            );

        });


    window.addEventListener(
        'sb-theme-changed',
        event => {

            const theme =
                event.detail?.theme;

            if (
                ['light','dark'].includes(theme)
            ) {

                document.documentElement
                    .setAttribute(
                        'data-theme',
                        theme
                    );

                localStorage.setItem(
                    'sb-theme',
                    theme
                );

            }

        }
    );

})();

</script>

</body>
</html>
