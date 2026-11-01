<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify seller sign-in | Smart Basket</title>
    <style>
        *{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:22px;background:linear-gradient(140deg,#07152e,#152b4e);font-family:Arial,sans-serif;color:#17243a}.card{width:min(100%,460px);padding:34px;border:1px solid #dce5f2;border-radius:24px;background:#fff;box-shadow:0 25px 70px #02081766;text-align:center}.icon{width:76px;height:76px;margin:0 auto 20px;display:grid;place-items:center;border-radius:24px;background:#eaf1ff;color:#2457a6;font-size:35px}h1{margin:0 0 10px;font-size:26px}p{margin:0 0 22px;color:#637189;line-height:1.6}.seller{margin-bottom:20px;color:#30425d;font-weight:700}.verify{width:100%;min-height:52px;border:0;border-radius:14px;background:#174ea6;color:#fff;font-size:16px;font-weight:700;cursor:pointer}.message{min-height:24px;margin-top:14px;color:#a43131;font-size:14px}.cancel{display:inline-block;margin-top:12px;color:#52637c;text-decoration:none}
    </style>
</head>
<body>
    <main class="card">
        <div class="icon" aria-hidden="true">🔒</div>
        <h1>Verify it’s you</h1>
        <p>Your password was accepted. Confirm with the device passkey you registered to finish seller sign-in.</p>
        <div class="seller">{{ $seller->email }}</div>
        <button class="verify" id="sellerFaceUnlockVerify" type="button">Continue with device unlock</button>
        <div class="message" id="sellerFaceUnlockMessage" role="status" aria-live="polite"></div>
        <a class="cancel" href="{{ route('seller.login') }}">Cancel and return to seller login</a>
    </main>
    @vite('resources/js/seller-face-unlock.js')
</body>
</html>
