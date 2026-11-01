@if(session('seller_login_welcome'))
    <div class="seller-welcome" role="dialog" aria-modal="true" aria-label="Welcome to your Smart Basket Seller Studio">
        <div class="seller-welcome__scene" aria-hidden="true">
            <i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i>
            <div class="seller-welcome__watermark">SMART BASKET</div>
        </div>
        <div class="seller-welcome__aura"></div>
        <div class="seller-welcome__card">
            <div class="seller-welcome__icon-wrap" aria-hidden="true">
                <span class="seller-welcome__orbit seller-welcome__orbit--one"></span>
                <span class="seller-welcome__orbit seller-welcome__orbit--two"></span>
                <i class="fa-solid fa-store"></i>
                <b class="seller-welcome__spark seller-welcome__spark--one">✦</b>
                <b class="seller-welcome__spark seller-welcome__spark--two">✧</b>
            </div>
            <div class="seller-welcome__eyebrow">SMART BASKET · SELLER STUDIO</div>
            <h1>Welcome to your<br><span>Seller Studio</span></h1>
            <p>Your shop is ready. Let’s make today a great day.</p>
            <button class="seller-welcome__voice" id="sellerWelcomeVoice" type="button"><i class="fa-solid fa-volume-high"></i><span>Hear the welcome</span></button>
            <div class="seller-welcome__progress"><i></i></div>
            <div class="seller-welcome__caption">Your business, moving forward.</div>
        </div>
    </div>
    <style>
        .seller-welcome{position:fixed;isolation:isolate;inset:0;z-index:30000;display:flex;align-items:center;justify-content:center;padding:22px;overflow:hidden;background:radial-gradient(ellipse at 15% 16%,rgba(67,236,181,.13),transparent 34%),radial-gradient(ellipse at 86% 24%,rgba(222,180,105,.12),transparent 36%),radial-gradient(ellipse at 50% 110%,rgba(19,111,80,.2),transparent 45%),rgba(5,12,15,.975);backdrop-filter:blur(17px);-webkit-backdrop-filter:blur(17px);animation:swFadeIn .45s ease both}
        .seller-welcome__scene{position:absolute;z-index:0;inset:0;overflow:hidden;pointer-events:none;background-image:linear-gradient(rgba(143,217,181,.028) 1px,transparent 1px),linear-gradient(90deg,rgba(143,217,181,.028) 1px,transparent 1px);background-size:56px 56px;mask-image:radial-gradient(ellipse at center,#000 0,transparent 72%);animation:swGrid 26s linear infinite}
        .seller-welcome__scene:before{content:"";position:absolute;left:50%;top:50%;width:min(82vw,820px);aspect-ratio:1;transform:translate(-50%,-50%);border:1px solid rgba(117,223,175,.12);border-radius:50%;box-shadow:0 0 0 38px rgba(117,223,175,.025),0 0 0 92px rgba(227,194,125,.025),inset 0 0 90px rgba(91,213,158,.045);animation:swPortal 18s ease-in-out infinite}
        .seller-welcome__scene:after{content:"";position:absolute;inset:-20%;background:linear-gradient(112deg,transparent 35%,rgba(104,237,184,.055) 49%,transparent 63%);transform:translateX(-60%);animation:swBackgroundSweep 8s ease-in-out infinite}
        .seller-welcome__scene i{position:absolute;width:4px;height:4px;border-radius:50%;background:#b5f5d4;box-shadow:0 0 13px 3px rgba(103,237,182,.48);animation:swParticle 5s ease-in-out infinite}
        .seller-welcome__watermark{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);color:rgba(209,235,216,.035);font:900 clamp(35px,9vw,112px)/1 system-ui,sans-serif;letter-spacing:.15em;white-space:nowrap;animation:swWatermark 13s ease-in-out infinite alternate}
        .seller-welcome__scene i:nth-child(1){left:12%;top:24%;animation-delay:-.6s}.seller-welcome__scene i:nth-child(2){left:22%;top:70%;animation-delay:-2.2s}.seller-welcome__scene i:nth-child(3){left:32%;top:14%;animation-delay:-1.4s}.seller-welcome__scene i:nth-child(4){left:41%;top:84%;animation-delay:-3.3s}.seller-welcome__scene i:nth-child(5){left:57%;top:11%;animation-delay:-.3s}.seller-welcome__scene i:nth-child(6){left:69%;top:77%;animation-delay:-2.8s}.seller-welcome__scene i:nth-child(7){left:82%;top:30%;animation-delay:-1.8s}.seller-welcome__scene i:nth-child(8){left:91%;top:64%;animation-delay:-3.8s}.seller-welcome__scene i:nth-child(9){left:8%;top:51%;width:3px;height:3px;background:#e8cb8c}.seller-welcome__scene i:nth-child(10){left:74%;top:48%;width:3px;height:3px;background:#e8cb8c;animation-delay:-1s}.seller-welcome__scene i:nth-child(11){left:49%;top:25%;width:3px;height:3px;background:#e8cb8c;animation-delay:-2s}.seller-welcome__scene i:nth-child(12){left:61%;top:91%;width:3px;height:3px;background:#e8cb8c;animation-delay:-3s}
        .seller-welcome__aura{position:absolute;z-index:1;left:50%;top:50%;width:min(76vw,690px);aspect-ratio:1;transform:translate(-50%,-50%);border-radius:50%;background:conic-gradient(from 15deg,rgba(53,224,164,.2),rgba(215,180,105,.13),rgba(74,166,207,.13),rgba(53,224,164,.2));filter:blur(70px);animation:swAura 8s linear infinite,swAuraPulse 4s ease-in-out infinite}
        .seller-welcome__card{position:relative;z-index:2;isolation:isolate;overflow:hidden;width:min(100%,510px);padding:34px 30px 25px;text-align:center;border:1px solid rgba(161,225,197,.28);border-radius:10px 30px 10px 30px;background:linear-gradient(145deg,rgba(18,48,41,.92),rgba(12,28,27,.95) 58%,rgba(27,35,28,.94));box-shadow:0 38px 110px rgba(0,0,0,.62),0 0 60px rgba(56,193,138,.1),inset 0 1px rgba(255,255,255,.14);animation:swCardIn .8s cubic-bezier(.16,1,.3,1) both}
        .seller-welcome__card:before{content:"";position:absolute;z-index:-1;inset:0;background:linear-gradient(115deg,transparent 18%,rgba(255,255,255,.075) 49%,transparent 68%);transform:translateX(-110%);animation:swShine 1.35s .35s ease-out both}
        .seller-welcome__icon-wrap{position:relative;display:grid;place-items:center;width:105px;height:105px;margin:0 auto 22px;border:1px solid rgba(110,235,183,.35);border-radius:50%;background:radial-gradient(circle,rgba(49,199,143,.2),rgba(49,199,143,.025) 72%);color:#83efbd;font-size:36px;animation:swIconIn .8s .18s both}
        .seller-welcome__icon-wrap:before{content:"";position:absolute;inset:9px;border:1px solid rgba(221,185,116,.24);border-radius:50%}.seller-welcome__orbit{position:absolute;inset:-6px;border:1px solid rgba(111,237,183,.25);border-radius:50%;animation:swOrbit 9s linear infinite}.seller-welcome__orbit--two{inset:-13px;border-color:rgba(226,192,124,.2);animation-direction:reverse;animation-duration:14s}.seller-welcome__spark{position:absolute;color:#e5cc91;text-shadow:0 0 14px rgba(229,204,145,.75);animation:swTwinkle 1.8s ease-in-out infinite}.seller-welcome__spark--one{right:-9px;top:13px;font-size:18px}.seller-welcome__spark--two{left:-6px;bottom:14px;font-size:15px;animation-delay:.7s}
        .seller-welcome__eyebrow{color:#a3ddc1;font:750 9px/1.5 system-ui,sans-serif;letter-spacing:.2em}.seller-welcome h1{margin:12px 0 10px;color:#f5fff9;font:800 clamp(29px,6.5vw,42px)/1.08 system-ui,sans-serif;letter-spacing:-.045em}.seller-welcome h1 span{background:linear-gradient(90deg,#7ce9b9,#e6d092);-webkit-background-clip:text;background-clip:text;color:transparent}.seller-welcome p{margin:0;color:#b7cdc2;font:400 13px/1.6 system-ui,sans-serif}
        .seller-welcome__voice{display:inline-flex;align-items:center;gap:9px;margin-top:18px;padding:9px 15px;border:1px solid rgba(129,227,182,.28);border-radius:999px;background:rgba(73,196,142,.1);color:#e3fff0;font:650 11px system-ui,sans-serif;cursor:pointer;transition:background .2s,transform .2s}.seller-welcome__voice:hover{transform:translateY(-2px);background:rgba(73,196,142,.2)}.seller-welcome__voice i{color:#88efc0}
        .seller-welcome__progress{width:135px;height:2px;margin:20px auto 11px;overflow:hidden;border-radius:5px;background:rgba(255,255,255,.12)}.seller-welcome__progress i{display:block;width:0;height:100%;background:linear-gradient(90deg,#69dbad,#e1c57f);animation:swProgress 6s linear forwards}.seller-welcome__caption{color:#8fa99c;font:500 10px/1.4 system-ui,sans-serif;letter-spacing:.04em}
        body.seller-welcome-zoom .sb-dashboard-page,body.seller-welcome-zoom .seller-layout-content{animation:sellerPageZoom 1.1s cubic-bezier(.16,1,.3,1) both}
        @keyframes swFadeIn{from{opacity:0}to{opacity:1}}@keyframes swCardIn{0%{opacity:0;transform:translateY(22px) scale(.93)}72%{transform:translateY(-3px) scale(1.01)}100%{opacity:1;transform:translateY(0) scale(1)}}@keyframes swIconIn{from{opacity:0;transform:scale(.6) rotate(-12deg)}to{opacity:1;transform:scale(1) rotate(0)}}@keyframes swAura{to{transform:translate(-50%,-50%) rotate(360deg)}}@keyframes swAuraPulse{50%{opacity:.68;scale:1.1}}@keyframes swOrbit{to{transform:rotate(360deg)}}@keyframes swTwinkle{50%{opacity:.4;transform:scale(.78) rotate(22deg)}}@keyframes swShine{to{transform:translateX(110%)}}@keyframes swProgress{to{width:100%}}@keyframes swGrid{to{background-position:56px 56px}}@keyframes swPortal{50%{transform:translate(-50%,-50%) scale(1.06) rotate(8deg);opacity:.6}}@keyframes swBackgroundSweep{50%,100%{transform:translateX(60%)}}@keyframes swParticle{0%,100%{opacity:.25;transform:translate3d(0,12px,0) scale(.7)}50%{opacity:1;transform:translate3d(9px,-16px,0) scale(1.3)}}@keyframes swWatermark{to{transform:translate(-50%,-54%) scale(1.06);opacity:.72}}@keyframes sellerPageZoom{from{opacity:0;transform:scale(.92);filter:blur(6px)}to{opacity:1;transform:scale(1);filter:blur(0)}}
        @media(max-width:480px){.seller-welcome__card{padding:29px 20px 22px;border-radius:9px 25px 9px 25px}.seller-welcome__icon-wrap{width:92px;height:92px}}
        @media(prefers-reduced-motion:reduce){.seller-welcome,.seller-welcome *{animation-duration:.01ms!important;animation-iteration-count:1!important}}
    </style>
    <script>
    (() => {
        const overlay=document.querySelector('.seller-welcome');
        const button=document.getElementById('sellerWelcomeVoice');
        if(!overlay||!button)return;
        const speak=()=>{
            if(!('speechSynthesis'in window)||!('SpeechSynthesisUtterance'in window)){button.hidden=true;return;}
            window.speechSynthesis.cancel();
            const greeting=new SpeechSynthesisUtterance('Welcome to your Smart Basket Seller Studio. Your shop is ready. Let us make today a great day.');
            const voices=window.speechSynthesis.getVoices();
            greeting.voice=voices.find(voice=>/^en-IN$/i.test(voice.lang))||voices.find(voice=>/^en-/i.test(voice.lang))||null;
            greeting.lang=greeting.voice?.lang||'en-US';greeting.rate=.91;greeting.pitch=1.05;greeting.volume=.95;
            greeting.onstart=()=>{button.querySelector('span').textContent='Playing welcome';};
            greeting.onend=()=>{button.querySelector('span').textContent='Hear it again';};
            greeting.onerror=()=>{button.querySelector('span').textContent='Tap to hear welcome';};
            window.speechSynthesis.speak(greeting);
        };
        button.addEventListener('click',speak);
        window.setTimeout(speak,500);
        window.setTimeout(()=>{
            document.body.classList.add('seller-welcome-zoom');
            overlay.style.transition='opacity .65s ease,visibility .65s ease';
            overlay.style.opacity='0';overlay.style.visibility='hidden';
            window.setTimeout(()=>{window.speechSynthesis?.cancel();overlay.remove();},700);
        },6000);
    })();
    </script>
@endif
