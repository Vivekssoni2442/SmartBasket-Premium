<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Seller Rejected</title>
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

    <div style="font-size:55px;">✕</div>

    <h1 style="color:#dc2626;">
        Seller Application Rejected
    </h1>

    <p style="color:#475569;font-size:16px;">
        The application of
        <strong>{{ $seller->name }}</strong>
        has been rejected.
    </p>

    <div style="
        background:#fef2f2;
        padding:20px;
        border-radius:12px;
        margin-top:25px;
        color:#991b1b;
    ">
        {{ $seller->rejection_reason }}
    </div>

</div>

</body>
</html>