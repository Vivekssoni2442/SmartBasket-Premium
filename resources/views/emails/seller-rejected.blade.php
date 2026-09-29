<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Seller Application Rejected</title>
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
">

    <div style="
        text-align:center;
        font-size:28px;
        font-weight:bold;
        color:#111827;
    ">
        SMART BASKET
    </div>

    <h1 style="
        text-align:center;
        color:#dc2626;
        margin-top:35px;
    ">
        Application Rejected
    </h1>

    <p style="
        color:#475569;
        line-height:1.8;
        font-size:16px;
    ">
        Hello {{ $seller->name ?? 'Seller' }},
    </p>

    <p style="
        color:#475569;
        line-height:1.8;
        font-size:16px;
    ">
        Your SMART BASKET Seller Partner Program application
        could not be approved at this time.
    </p>

    <div style="
        background:#fef2f2;
        border:1px solid #fecaca;
        border-radius:12px;
        padding:20px;
        margin:25px 0;
    ">

        <strong style="color:#991b1b;">
            Rejection Reason
        </strong>

        <p style="
            color:#475569;
            line-height:1.7;
            margin-bottom:0;
        ">
            {{ $seller->rejection_reason ?? 'Please contact SMART BASKET support for more information.' }}
        </p>

    </div>

    <p style="
        color:#64748b;
        line-height:1.7;
    ">
        Please correct the required information/documents and
        submit your application again.
    </p>

    <div style="
        text-align:center;
        margin-top:30px;
    ">
        <a
            href="{{ url('/seller-login') }}"
            style="
                display:inline-block;
                background:#111827;
                color:#ffffff;
                text-decoration:none;
                padding:14px 28px;
                border-radius:10px;
                font-weight:bold;
            "
        >
            SELLER LOGIN
        </a>
    </div>

</div>

</body>
</html>