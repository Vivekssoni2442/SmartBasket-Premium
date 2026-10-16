<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="theme-color" content="#020308">

<title>SMART BASKET</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root {
    --gold: #ffc400;
    --blue: #1769ff;
    --cyan: #00eaff;
    --purple: #9b4dff;
    --pink: #ff2bd6;
    --green: #00ff88;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html,
body {
    width: 100%;
    height: 100%;
}

body {
    min-height: 100vh;
    overflow: hidden;
    font-family: "Poppins", sans-serif;
    background: #020308;
    color: #fff;
}

.sb-splash {
    position: relative;
    isolation: isolate;
    width: 100%;
    height: 100vh;
    height: 100dvh;
    min-height: 360px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background:
        radial-gradient(ellipse at 50% 45%,
            rgba(19, 48, 110, .45),
            rgba(3, 6, 20, .92) 57%,
            #020308 100%);
}

/* ================= BACKGROUND SKY ================= */

.sb-sky {
    position: absolute;
    inset: 0;
    z-index: -5;
    pointer-events: none;
    background:
        linear-gradient(180deg, #030514, #080b20 48%, #020308);
}

.sb-stars {
    position: absolute;
    inset: 0;
    opacity: .65;
    background-image:
        radial-gradient(1px 1px at 8% 18%, #fff 98%, transparent),
        radial-gradient(2px 2px at 18% 42%, #bcecff 98%, transparent),
        radial-gradient(1px 1px at 30% 12%, #fff 98%, transparent),
        radial-gradient(2px 2px at 44% 30%, #fff 98%, transparent),
        radial-gradient(1px 1px at 56% 15%, #ffc400 98%, transparent),
        radial-gradient(2px 2px at 69% 38%, #fff 98%, transparent),
        radial-gradient(1px 1px at 82% 16%, #8cecff 98%, transparent),
        radial-gradient(2px 2px at 93% 46%, #fff 98%, transparent),
        radial-gradient(1px 1px at 12% 70%, #fff 98%, transparent),
        radial-gradient(1px 1px at 76% 76%, #fff 98%, transparent);
    animation: starTwinkle 3s ease-in-out infinite alternate;
}

@keyframes starTwinkle {
    from { opacity: .25; }
    to { opacity: .8; }
}

/* ================= ANIMATED LIGHTS ================= */

.sb-light {
    position: absolute;
    width: min(42vw, 440px);
    aspect-ratio: 1;
    border-radius: 50%;
    filter: blur(85px);
    pointer-events: none;
    z-index: -4;
    will-change: transform;
}

.sb-light-blue {
    top: -160px;
    left: -100px;
    background: rgba(0, 102, 255, .27);
    animation: blueMove 8s ease-in-out infinite;
}

.sb-light-gold {
    right: -120px;
    bottom: -150px;
    background: rgba(255, 174, 0, .20);
    animation: goldMove 9s ease-in-out infinite;
}

.sb-light-purple {
    right: 12%;
    top: -130px;
    background: rgba(155, 77, 255, .20);
    animation: purpleMove 10s ease-in-out infinite;
}

.sb-light-cyan {
    left: 35%;
    bottom: -210px;
    background: rgba(0, 234, 255, .14);
    animation: cyanMove 11s ease-in-out infinite;
}

@keyframes blueMove {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(75px, 70px) scale(1.15); }
}

@keyframes goldMove {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(-75px, -65px) scale(1.15); }
}

@keyframes purpleMove {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(-65px, 75px); }
}

@keyframes cyanMove {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(80px, -45px); }
}

/* ================= BACKGROUND GRID ================= */

.sb-grid {
    position: absolute;
    inset: 0;
    z-index: -2;
    pointer-events: none;
    opacity: .075;
    background-image:
        linear-gradient(rgba(255,255,255,.08) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px);
    background-size: 65px 65px;
    mask-image: radial-gradient(ellipse at center, #000, transparent 76%);
    -webkit-mask-image: radial-gradient(ellipse at center, #000, transparent 76%);
    animation: gridMove 15s linear infinite;
}

@keyframes gridMove {
    from { background-position: 0 0, 0 0; }
    to { background-position: 65px 65px, 65px 65px; }
}

/* ================= RGB DECORATIVE LINES ================= */

.sb-line {
    position: absolute;
    height: 1px;
    left: 6%;
    right: 6%;
    z-index: -1;
    pointer-events: none;
    opacity: .5;
    background: linear-gradient(
        90deg,
        transparent,
        var(--gold),
        var(--pink),
        var(--blue),
        var(--cyan),
        transparent
    );
    background-size: 300% 100%;
    animation: lineRGB 6s linear infinite;
}

.sb-line-top { top: 7%; }
.sb-line-bottom { bottom: 7%; }

@keyframes lineRGB {
    from { background-position: 0% 50%; }
    to { background-position: 300% 50%; }
}

/* ================= CORNER ACCENTS ================= */

.sb-corner {
    position: absolute;
    width: 55px;
    height: 55px;
    opacity: .45;
    pointer-events: none;
    z-index: 1;
}

.sb-corner::before,
.sb-corner::after {
    content: "";
    position: absolute;
    background: linear-gradient(
        90deg,
        var(--gold),
        var(--pink),
        var(--blue),
        var(--cyan)
    );
    background-size: 300% 100%;
    animation: cornerRGB 4s linear infinite;
}

.sb-corner::before {
    width: 55px;
    height: 1px;
}

.sb-corner::after {
    width: 1px;
    height: 55px;
}

.sb-corner-tl { top: 5%; left: 5%; }
.sb-corner-tr { top: 5%; right: 5%; transform: rotate(90deg); }
.sb-corner-bl { bottom: 5%; left: 5%; transform: rotate(-90deg); }
.sb-corner-br { bottom: 5%; right: 5%; transform: rotate(180deg); }

@keyframes cornerRGB {
    from { background-position: 0% 50%; }
    to { background-position: 300% 50%; }
}

/* ================= FIREWORKS CANVAS ================= */

.sb-fireworks {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    pointer-events: none;
}

/* ================= MAIN CONTENT ================= */

.sb-content {
    position: relative;
    z-index: 5;
    width: min(1000px, 94vw);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    animation: contentReveal 1s ease-out both;
}

@keyframes contentReveal {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* ================= RGB ANIMATED IMAGE FRAME ================= */

.sb-logo-frame {
    position: relative;
    isolation: isolate;
    width: min(560px, 72vw);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4px;
    border-radius: 23px;
    background: rgba(5, 10, 27, .8);
    box-shadow:
        0 25px 80px rgba(0,0,0,.6),
        0 0 30px rgba(23,105,255,.16);
    animation:
        logoReveal 1.3s cubic-bezier(.16,1,.3,1) both,
        logoFloat 5s ease-in-out 1.3s infinite;
}

/* Continuously rotating rainbow border */

.sb-logo-frame::before {
    content: "";
    position: absolute;
    inset: -1px;
    padding: 3px;
    border-radius: inherit;
    background: conic-gradient(
        from 0deg,
        #ffc400,
        #ff8a00,
        #ff2bd6,
        #9b4dff,
        #1769ff,
        #00eaff,
        #00ff88,
        #ffc400
    );
    -webkit-mask:
        linear-gradient(#fff 0 0) content-box,
        linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    z-index: -1;
    animation: borderRotate 3.5s linear infinite;
    filter:
        drop-shadow(0 0 5px rgba(255,196,0,.8))
        drop-shadow(0 0 13px rgba(0,234,255,.55))
        drop-shadow(0 0 22px rgba(255,43,214,.35));
}

/* Soft RGB aura outside the border */

.sb-logo-frame::after {
    content: "";
    position: absolute;
    inset: -10px;
    border-radius: 30px;
    background: conic-gradient(
        from 180deg,
        rgba(255,196,0,.36),
        rgba(255,43,214,.28),
        rgba(23,105,255,.35),
        rgba(0,234,255,.30),
        rgba(0,255,136,.25),
        rgba(255,196,0,.36)
    );
    filter: blur(22px);
    opacity: .6;
    z-index: -2;
    animation: auraPulse 4s ease-in-out infinite;
}

@keyframes borderRotate {
    to { transform: rotate(360deg); }
}

@keyframes auraPulse {
    0%, 100% { opacity: .35; transform: scale(.98); }
    50% { opacity: .8; transform: scale(1.025); }
}

@keyframes logoReveal {
    0% { opacity: 0; transform: scale(.82) translateY(20px); }
    70% { opacity: 1; transform: scale(1.025) translateY(0); }
    100% { opacity: 1; transform: scale(1); }
}

@keyframes logoFloat {
    0%, 100% { translate: 0 0; }
    50% { translate: 0 -4px; }
}

/* ================= LOGO IMAGE ================= */

.sb-logo {
    display: block;
    position: relative;
    width: 100%;
    height: auto;
    max-height: 57vh;
    object-fit: contain;
    border-radius: 19px;
    user-select: none;
    pointer-events: none;
    -webkit-user-drag: none;
    background: rgba(2,3,8,.35);
    filter: drop-shadow(0 18px 35px rgba(0,0,0,.55));
}

.sb-inner-glow {
    position: absolute;
    inset: 8px;
    border-radius: 17px;
    pointer-events: none;
    z-index: 2;
    background: radial-gradient(
        ellipse at center,
        transparent 55%,
        rgba(0,234,255,.07),
        rgba(255,196,0,.04),
        transparent 88%
    );
}

/* ================= LOADING INDICATOR ================= */

.sb-loading {
    width: min(300px, 78vw);
    margin-top: clamp(15px, 2.5vh, 24px);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    opacity: 0;
    animation: loadingReveal .8s ease-out 1s forwards;
}

.sb-loading-text {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 3px;
    text-transform: uppercase;
    text-align: center;
    color: rgba(255,255,255,.82);
    text-shadow: 0 0 14px rgba(0,234,255,.22);
}

.sb-loader {
    position: relative;
    width: 165px;
    max-width: 75%;
    height: 4px;
    border-radius: 100px;
    overflow: hidden;
    background: rgba(255,255,255,.12);
    box-shadow: 0 0 12px rgba(23,105,255,.15);
}

.sb-loader::before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    left: -65%;
    width: 65%;
    border-radius: inherit;
    background: linear-gradient(
        90deg,
        transparent,
        #ffc400,
        #ff2bd6,
        #9b4dff,
        #1769ff,
        #00eaff,
        #00ff88,
        transparent
    );
    box-shadow: 0 0 12px rgba(0,234,255,.65);
    animation: loaderMove 1.6s ease-in-out infinite;
}

.sb-loader-track {
    position: relative;
    width: min(245px, 80vw);
    height: 1px;
    background: rgba(255,255,255,.07);
    overflow: hidden;
}

.sb-loader-track::after {
    content: "";
    position: absolute;
    inset: 0;
    width: 35%;
    background: linear-gradient(90deg, transparent, #00eaff, #ffc400, transparent);
    animation: trackMove 2.4s linear infinite;
}

@keyframes loadingReveal {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes loaderMove {
    0% { left: -65%; }
    55%, 100% { left: 100%; }
}

@keyframes trackMove {
    from { transform: translateX(-120%); }
    to { transform: translateX(350%); }
}

/* ================= TABLET ================= */

@media (max-width: 900px) {
    .sb-logo-frame {
        width: min(520px, 76vw);
    }

    .sb-line {
        left: 5%;
        right: 5%;
    }
}

/* ================= MOBILE ================= */

@media (max-width: 600px) {
    .sb-splash {
        min-height: 100svh;
    }

    .sb-logo-frame {
        width: min(420px, 82vw);
        padding: 4px;
        border-radius: 18px;
    }

    .sb-logo {
        max-height: 45vh;
        border-radius: 15px;
    }

    .sb-logo-frame::before { border-radius: 18px; }
    .sb-logo-frame::after { border-radius: 23px; }

    .sb-loading {
        margin-top: 13px;
        gap: 8px;
    }

    .sb-loading-text {
        font-size: 8px;
        letter-spacing: 2px;
    }

    .sb-loader { width: 140px; }

    .sb-corner {
        width: 36px;
        height: 36px;
        opacity: .25;
    }

    .sb-corner::before { width: 36px; }
    .sb-corner::after { height: 36px; }

    .sb-light { filter: blur(60px); }
}

/* ================= SHORT SCREEN ================= */

@media (max-height: 600px) {
    .sb-logo-frame {
        width: min(440px, 58vw);
    }

    .sb-logo {
        max-height: 46vh;
    }

    .sb-loading {
        margin-top: 8px;
        gap: 6px;
    }

    .sb-loading-text {
        font-size: 8px;
    }

    .sb-loader { height: 3px; }
}

/* ================= REDUCED MOTION ================= */

@media (prefers-reduced-motion: reduce) {
    .sb-stars,
    .sb-light,
    .sb-grid,
    .sb-line,
    .sb-corner,
    .sb-logo-frame,
    .sb-logo-frame::before,
    .sb-logo-frame::after,
    .sb-loading,
    .sb-loader::before,
    .sb-loader-track::after {
        animation: none !important;
    }

    .sb-loading {
        opacity: 1;
    }
}
</style>
</head>

<body>

<main class="sb-splash">

    <div class="sb-sky" aria-hidden="true">
        <div class="sb-stars"></div>
    </div>

    <div class="sb-light sb-light-blue" aria-hidden="true"></div>
    <div class="sb-light sb-light-gold" aria-hidden="true"></div>
    <div class="sb-light sb-light-purple" aria-hidden="true"></div>
    <div class="sb-light sb-light-cyan" aria-hidden="true"></div>

    <canvas
        id="sbFireworks"
        class="sb-fireworks"
        aria-hidden="true"
    ></canvas>

    <div class="sb-grid" aria-hidden="true"></div>

    <div class="sb-line sb-line-top" aria-hidden="true"></div>
    <div class="sb-line sb-line-bottom" aria-hidden="true"></div>

    <div class="sb-corner sb-corner-tl" aria-hidden="true"></div>
    <div class="sb-corner sb-corner-tr" aria-hidden="true"></div>
    <div class="sb-corner sb-corner-bl" aria-hidden="true"></div>
    <div class="sb-corner sb-corner-br" aria-hidden="true"></div>

    <section class="sb-content">

        <div class="sb-logo-frame">

            <img
                src="{{ asset('images/smart-basket-logo.png') }}"
                alt="SMART BASKET"
                class="sb-logo"
                draggable="false"
            >

            <div class="sb-inner-glow" aria-hidden="true"></div>

        </div>

        <div class="sb-loading">

            <div class="sb-loading-text">
                PREMIUM SHOPPING EXPERIENCE
            </div>

            <div class="sb-loader" aria-label="Loading"></div>

            <div class="sb-loader-track" aria-hidden="true"></div>

        </div>

    </section>

</main>

<!-- ================= DIWALI ROCKET FIREWORKS ================= -->

<script>
(() => {
    "use strict";

    const canvas = document.getElementById("sbFireworks");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");
    if (!ctx) return;

    const reducedMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)"
    ).matches;

    if (reducedMotion) return;

    const isMobile = window.matchMedia(
        "(max-width: 600px)"
    ).matches;

    let width = 0;
    let height = 0;
    let dpr = 1;
    let frameId = 0;
    let previousTime = 0;
    let lastLaunch = 0;
    let disposed = false;

    const rockets = [];
    const particles = [];
    const flashes = [];

    const MAX_PARTICLES = isMobile ? 380 : 780;
    const MAX_ROCKETS = isMobile ? 3 : 5;

    const colors = [
        "#fff4c2",
        "#ffc400",
        "#ff9d00",
        "#ff3d81",
        "#ff2bd6",
        "#b45cff",
        "#4f8dff",
        "#00eaff",
        "#00ff88"
    ];

    const random = (min, max) =>
        Math.random() * (max - min) + min;

    function resize() {
        dpr = Math.min(window.devicePixelRatio || 1, 1.5);

        width = window.innerWidth;
        height = window.innerHeight;

        canvas.width = Math.round(width * dpr);
        canvas.height = Math.round(height * dpr);

        canvas.style.width = width + "px";
        canvas.style.height = height + "px";

        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    function launchRocket() {
        if (rockets.length >= MAX_ROCKETS) return;

        const targetX = random(width * .07, width * .93);
        const targetY = random(height * .10, height * .43);
        const startX = targetX + random(-width * .10, width * .10);

        rockets.push({
            x: startX,
            y: height + 10,
            vx: (targetX - startX) / random(32, 46),
            vy: -random(8, 11),
            gravity: .12,
            targetY,
            color: colors[Math.floor(Math.random() * colors.length)],
            trail: [],
            age: 0,
            maxAge: random(45, 70)
        });
    }

    function addParticle(x, y, vx, vy, color, options = {}) {
        if (particles.length >= MAX_PARTICLES) return;

        particles.push({
            x, y, vx, vy, color,
            radius: options.radius ?? random(.7, 1.8),
            alpha: 1,
            decay: options.decay ?? random(.009, .018),
            gravity: options.gravity ?? .05,
            drag: options.drag ?? .99,
            sparkle: options.sparkle ?? false,
            flicker: options.flicker ?? true
        });
    }

    function explode(x, y, color) {
        flashes.push({
            x, y, radius: 3, alpha: .9, color
        });

        const count = Math.min(
            isMobile ? 65 : 110,
            MAX_PARTICLES - particles.length
        );

        const burstType = Math.random();

        for (let i = 0; i < count; i++) {
            const angle = Math.PI * 2 * i / count
                + random(-.035, .035);

            const speed = burstType > .65
                ? random(1, 4)
                : random(1.5, 5.2);

            addParticle(
                x,
                y,
                Math.cos(angle) * speed,
                Math.sin(angle) * speed,
                Math.random() < .22 ? "#fff7d0" : color,
                {
                    radius: random(.7, 1.8),
                    decay: burstType > .65
                        ? random(.006, .011)
                        : random(.009, .019),
                    gravity: burstType > .65 ? .07 : .045,
                    drag: random(.982, .994)
                }
            );
        }

        const sparks = Math.min(
            isMobile ? 16 : 30,
            MAX_PARTICLES - particles.length
        );

        for (let i = 0; i < sparks; i++) {
            const angle = random(0, Math.PI * 2);
            const speed = random(.5, 2.7);

            addParticle(
                x, y,
                Math.cos(angle) * speed,
                Math.sin(angle) * speed,
                Math.random() < .35 ? "#ffffff" : "#ffc857",
                {
                    radius: random(.5, 1.2),
                    decay: random(.013, .028),
                    gravity: .06,
                    sparkle: true
                }
            );
        }
    }

    function drawRocket(rocket) {
        rocket.trail.push({ x: rocket.x, y: rocket.y });

        if (rocket.trail.length > 10) {
            rocket.trail.shift();
        }

        for (let i = 1; i < rocket.trail.length; i++) {
            const a = rocket.trail[i - 1];
            const b = rocket.trail[i];

            ctx.beginPath();
            ctx.moveTo(a.x, a.y);
            ctx.lineTo(b.x, b.y);
            ctx.strokeStyle = rocket.color;
            ctx.globalAlpha = i / rocket.trail.length * .55;
            ctx.lineWidth = 1.7;
            ctx.shadowBlur = 8;
            ctx.shadowColor = rocket.color;
            ctx.stroke();
        }

        ctx.globalAlpha = 1;
        ctx.beginPath();
        ctx.arc(rocket.x, rocket.y, 1.8, 0, Math.PI * 2);
        ctx.fillStyle = "#ffffff";
        ctx.shadowBlur = 12;
        ctx.shadowColor = rocket.color;
        ctx.fill();
        ctx.shadowBlur = 0;
    }

    function updateRockets(delta) {
        for (let i = rockets.length - 1; i >= 0; i--) {
            const rocket = rockets[i];

            rocket.age += delta;
            rocket.x += rocket.vx * delta;
            rocket.y += rocket.vy * delta;
            rocket.vy += rocket.gravity * delta;

            if (Math.random() < .4) {
                addParticle(
                    rocket.x + random(-2, 2),
                    rocket.y + random(0, 4),
                    random(-.5, .5),
                    random(.5, 1.8),
                    Math.random() < .5 ? "#ffc857" : "#fff1b0",
                    {
                        radius: random(.5, 1),
                        decay: random(.035, .06),
                        gravity: .04,
                        drag: .97
                    }
                );
            }

            drawRocket(rocket);

            const reachedApex =
                rocket.y <= rocket.targetY ||
                rocket.vy >= -.3 ||
                rocket.age >= rocket.maxAge;

            if (reachedApex) {
                explode(rocket.x, rocket.y, rocket.color);

                if (Math.random() < .28) {
                    explode(
                        rocket.x + random(-20, 20),
                        rocket.y + random(-16, 16),
                        colors[Math.floor(Math.random() * colors.length)]
                    );
                }

                rockets.splice(i, 1);
            }
        }
    }

    function updateParticles(delta) {
        for (let i = particles.length - 1; i >= 0; i--) {
            const p = particles[i];

            p.x += p.vx * delta;
            p.y += p.vy * delta;
            p.vy += p.gravity * delta;

            p.vx *= Math.pow(p.drag, delta);
            p.vy *= Math.pow(p.drag, delta);
            p.alpha -= p.decay * delta;

            if (p.alpha <= 0) {
                particles.splice(i, 1);
                continue;
            }

            ctx.globalAlpha = Math.max(0, p.alpha) *
                (p.flicker ? random(.65, 1) : 1);

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
            ctx.fillStyle = p.color;
            ctx.shadowBlur = p.sparkle ? 5 : 7;
            ctx.shadowColor = p.color;
            ctx.fill();
        }

        ctx.globalAlpha = 1;
        ctx.shadowBlur = 0;
    }

    function updateFlashes(delta) {
        for (let i = flashes.length - 1; i >= 0; i--) {
            const flash = flashes[i];

            flash.radius += 2.3 * delta;
            flash.alpha -= .075 * delta;

            if (flash.alpha <= 0) {
                flashes.splice(i, 1);
                continue;
            }

            ctx.beginPath();
            ctx.arc(flash.x, flash.y, flash.radius, 0, Math.PI * 2);
            ctx.globalAlpha = flash.alpha;
            ctx.strokeStyle = flash.color;
            ctx.lineWidth = 1.5;
            ctx.shadowBlur = 12;
            ctx.shadowColor = flash.color;
            ctx.stroke();
        }

        ctx.globalAlpha = 1;
        ctx.shadowBlur = 0;
    }

    function animate(timestamp) {
        if (disposed) return;

        frameId = requestAnimationFrame(animate);

        if (document.hidden) {
            previousTime = 0;
            return;
        }

        const delta = previousTime
            ? Math.min((timestamp - previousTime) / 16.667, 2)
            : 1;

        previousTime = timestamp;

        ctx.clearRect(0, 0, width, height);

        const launchInterval = isMobile
            ? random(1050, 1650)
            : random(750, 1350);

        if (
            timestamp - lastLaunch > launchInterval &&
            rockets.length < MAX_ROCKETS
        ) {
            launchRocket();
            lastLaunch = timestamp;
        }

        updateRockets(delta);
        updateParticles(delta);
        updateFlashes(delta);
    }

    function handleVisibility() {
        previousTime = 0;
    }

    function cleanup() {
        disposed = true;

        if (frameId) {
            cancelAnimationFrame(frameId);
        }

        window.removeEventListener("resize", resize);
        document.removeEventListener("visibilitychange", handleVisibility);
    }

    resize();

    window.addEventListener("resize", resize, { passive: true });
    document.addEventListener("visibilitychange", handleVisibility);
    window.addEventListener("pagehide", cleanup, { once: true });

    // Launch initial fireworks so the animation begins immediately.
    launchRocket();
    launchRocket();

    lastLaunch = performance.now();
    frameId = requestAnimationFrame(animate);
})();
</script>

<!-- ================= 8-SECOND LOGIN REDIRECT ================= -->

<script>
(() => {
    "use strict";

    window.setTimeout(() => {
        window.location.href = @json(route('login'));
    }, 8000);
})();
</script>

</body>
</html>