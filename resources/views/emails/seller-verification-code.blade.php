<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>SMART BASKET Verification Code</title>
</head>

<body
    style="
        margin:0;
        padding:0;
        background:#f1f5f9;
        font-family:Arial,Helvetica,sans-serif;
    "
>

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="padding:40px 15px;"
>

<tr>

<td align="center">

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        max-width:600px;
        background:#ffffff;
        border-radius:18px;
        overflow:hidden;
        box-shadow:0 10px 35px rgba(15,23,42,.12);
    "
>

<tr>

<td
    style="
        padding:30px;
        text-align:center;
        background:#2563eb;
        color:#ffffff;
    "
>

<h1
    style="
        margin:0;
        font-size:25px;
    "
>
    SMART BASKET
</h1>

<p
    style="
        margin:8px 0 0;
        font-size:14px;
        opacity:.9;
    "
>
    Seller Verification
</p>

</td>

</tr>

<tr>

<td style="padding:35px;">

<h2
    style="
        margin:0 0 15px;
        color:#0f172a;
        font-size:22px;
    "
>
    Verify your email
</h2>

<p
    style="
        margin:0 0 20px;
        color:#475569;
        font-size:15px;
        line-height:1.7;
    "
>
    Use the following 16-digit verification code
    to verify your SMART BASKET seller account.
</p>

<div
    style="
        padding:22px;
        margin:25px 0;
        text-align:center;
        background:#eff6ff;
        border:2px solid #bfdbfe;
        border-radius:14px;
    "
>

<div
    style="
        font-size:28px;
        font-weight:800;
        letter-spacing:5px;
        color:#1d4ed8;
        word-break:break-all;
    "
>
    {{ $code }}
</div>

</div>

<p
    style="
        margin:0;
        color:#64748b;
        font-size:13px;
        line-height:1.6;
    "
>
    This verification code is valid for a limited time.
    Do not share this code with anyone.
</p>

<p
    style="
        margin:25px 0 0;
        color:#64748b;
        font-size:13px;
    "
>
    If you did not request this verification,
    you can safely ignore this email.
</p>

</td>

</tr>

<tr>

<td
    style="
        padding:20px 30px;
        text-align:center;
        background:#f8fafc;
        color:#94a3b8;
        font-size:12px;
    "
>
    © {{ date('Y') }} SMART BASKET
</td>

</tr>

</table>

</td>

</tr>

</table>

</body>
</html>