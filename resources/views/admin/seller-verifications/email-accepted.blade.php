<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Seller Accepted</title>
</head>

<body style="
    margin:0;
    padding:40px;
    background:#f1f5f9;
    font-family:Arial,sans-serif;
">

<div style="
    max-width:650px;
    margin:auto;
    background:white;
    border-radius:18px;
    padding:45px;
    text-align:center;
">

    <div style="font-size:55px;">✓</div>

    <h1 style="color:#16a34a;">
        Seller Accepted Successfully
    </h1>

    <p style="color:#475569;font-size:16px;">
        <strong>{{ $seller->name }}</strong>
        is now an ACTIVE SMART BASKET seller.
    </p>

    <div style="
        background:#f0fdf4;
        padding:20px;
        border-radius:12px;
        margin-top:25px;
        color:#166534;
    ">
        The seller can now login and access the Seller Dashboard
        and add products.
    </div>

</div>

</body>
</html>