<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Share delivery location | SMART BASKET</title>
    <style>
        *{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:22px;background:radial-gradient(circle at 15% 10%,#163e39,#071119 62%);color:#f4fbf8;font:15px/1.55 Inter,system-ui,sans-serif}.share-card{width:min(100%,480px);padding:32px;border:1px solid #5dd8ad55;border-radius:26px;background:#10221feF;box-shadow:0 28px 80px #0008}.brand{color:#6be5b7;font-size:11px;font-weight:800;letter-spacing:.18em}.icon{display:grid;place-items:center;width:58px;height:58px;margin:22px 0 18px;border-radius:18px;background:#1d493e;color:#72edbd;font-size:28px}h1{margin:0;font-size:27px;letter-spacing:-.04em}p{color:#abc1b8}.driver{margin:8px 0 20px;color:#e2fff3;font-weight:650}.privacy{padding:12px 14px;border-radius:13px;background:#ffffff0b;color:#bcd3c9;font-size:12px}.share-button{width:100%;margin-top:20px;padding:14px;border:0;border-radius:13px;background:linear-gradient(110deg,#55dca9,#a2f3cd);color:#06241a;font-size:14px;font-weight:800;cursor:pointer}.share-button:disabled{opacity:.65;cursor:wait}.state{min-height:24px;margin:13px 0 0;color:#82e9be;font-size:13px}.coords{color:#93a89f;font:12px ui-monospace,monospace}
    </style>
</head>
<body>
    <main class="share-card">
        <div class="brand">SMART BASKET · DELIVERY</div>
        <div class="icon">🚚</div>
        <h1>Share your live location</h1>
        <div class="driver">{{ $detail->deliveryPartner?->name ?: 'Delivery partner' }} · Order #{{ $detail->order_id }}</div>
        <p>Allow location access while delivering so the customer can follow your vehicle on their order tracking page.</p>
        <div class="privacy">Sharing starts only after you tap the button. Keep this page open during delivery. Your location is shared with this order’s customer.</div>
        <button class="share-button" id="shareToggle" type="button">Start live location</button>
        <div class="state" id="shareState" role="status">Location sharing is off.</div>
        <div class="coords" id="coords"></div>
    </main>
    <script>
    (() => {
        const button = document.getElementById('shareToggle');
        const state = document.getElementById('shareState');
        const coords = document.getElementById('coords');
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        let watchId = null;
        let sending = false;
        let lastSentAt = 0;
        const stop = () => {
            if (watchId !== null) navigator.geolocation.clearWatch(watchId);
            watchId = null;
            button.textContent = 'Start live location';
            state.textContent = 'Location sharing is off.';
        };
        button.addEventListener('click', () => {
            if (watchId !== null) { stop(); return; }
            if (!navigator.geolocation) { state.textContent = 'This device does not support GPS location sharing.'; return; }
            if (!window.isSecureContext) { state.textContent = 'GPS sharing requires a secure HTTPS connection.'; return; }
            button.disabled = true;
            state.textContent = 'Waiting for GPS permission…';
            watchId = navigator.geolocation.watchPosition(async position => {
                if (Date.now() - lastSentAt < 8000) return;
                if (sending) return;
                sending = true;
                lastSentAt = Date.now();
                state.textContent = 'Sharing live location with the customer.';
                coords.textContent = `${position.coords.latitude.toFixed(5)}, ${position.coords.longitude.toFixed(5)} · ±${Math.round(position.coords.accuracy)} m`;
                try {
                    const response = await fetch(@json(route('delivery.live-location', $token)), {
                        method: 'POST', headers: {'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':csrf},
                        body: JSON.stringify({latitude:position.coords.latitude,longitude:position.coords.longitude,accuracy:position.coords.accuracy})
                    });
                    if (!response.ok) throw new Error('Location update failed');
                } catch (_) { state.textContent = 'Network issue. Trying again with the next GPS update…'; }
                finally { sending = false; button.disabled = false; button.textContent = 'Stop live location'; }
            }, error => {
                button.disabled = false;
                state.textContent = error.code === 1 ? 'Location permission was denied. Allow it in your browser settings to share.' : 'GPS signal is unavailable. Move outdoors and try again.';
                if (watchId !== null) { navigator.geolocation.clearWatch(watchId); watchId = null; }
                button.textContent = 'Try location again';
            }, {enableHighAccuracy:true,maximumAge:5000,timeout:20000});
        });
        window.addEventListener('pagehide', stop);
    })();
    </script>
</body>
</html>
