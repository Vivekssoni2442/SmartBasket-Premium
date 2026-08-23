<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Seller Approved</title>
</head>

<body style="
    margin:0;
    padding:30px;
    background:#f1f5f9;
    font-family:Arial,sans-serif;
">

<div style="
    max-width:650px;
    margin:auto;
    background:#ffffff;
    border-radius:18px;
    padding:40px;
    text-align:center;
">

    <div style="
        font-size:28px;
        font-weight:bold;
        color:#111827;
    ">
        SMART BASKET
    </div>

    <div style="
        margin-top:30px;
        font-size:48px;
    ">
        ✓
    </div>

    <h1 style="color:#16a34a;">
        Seller Application Approved
    </h1>

    <p style="
        color:#475569;
        line-height:1.7;
        font-size:16px;
    ">
        Congratulations {{ $seller->name ?? 'Seller' }}!
        Your SMART BASKET Seller Partner Program application
        has been approved.
    </p>

    <div style="
        background:#f0fdf4;
        border:1px solid #bbf7d0;
        border-radius:12px;
        padding:20px;
        margin:25px 0;
    ">

        <strong style="color:#166534;">
            Your seller account is now ACTIVE.
        </strong>

        <p style="
            color:#475569;
            margin-bottom:0;
        ">
            You can now login to your Seller account and access
            your Seller Dashboard.
        </p>

    </div>

    <a
        href="{{ url('/seller-login') }}"
        style="
            display:inline-block;
            background:#111827;
            color:#ffffff;
            text-decoration:none;
            padding:15px 30px;
            border-radius:10px;
            font-weight:bold;
        "
    >
        LOGIN TO SELLER DASHBOARD
    </a>

    <p style="
        margin-top:35px;
        color:#94a3b8;
        font-size:12px;
    ">
        SMART BASKET Seller Partner Program
    </p>

</div>

</body>
</html>