<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SMART BASKET - Password Recovery</title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#080808;
    font-family:Arial, Helvetica, sans-serif;
    color:#111111;
">

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        width:100%;
        margin:0;
        padding:35px 12px;
        background:#080808;
    "
>
    <tr>
        <td align="center">

            <!-- =====================================================
                 MAIN CARD
            ====================================================== -->

            <table
                width="100%"
                cellpadding="0"
                cellspacing="0"
                border="0"
                style="
                    width:100%;
                    max-width:650px;
                    background:#ffffff;
                    border-radius:22px;
                    overflow:hidden;
                    border:1px solid #292929;
                "
            >

                <!-- =================================================
                     HEADER
                ================================================== -->

                <tr>
                    <td
                        align="center"
                        style="
                            background:#111111;
                            padding:38px 20px 34px 20px;
                            border-bottom:5px solid #f5c400;
                        "
                    >

                        <div
                            style="
                                font-family:Arial, Helvetica, sans-serif;
                                font-size:34px;
                                line-height:42px;
                                font-weight:900;
                                letter-spacing:4px;
                                color:#f5c400;
                            "
                        >
                            SMART BASKET
                        </div>

                        <div
                            style="
                                margin-top:9px;
                                font-size:11px;
                                line-height:18px;
                                font-weight:bold;
                                letter-spacing:3px;
                                color:#999999;
                            "
                        >
                            SMART SHOPPING • SMART SECURITY
                        </div>

                    </td>
                </tr>


                <!-- =================================================
                     CONTENT
                ================================================== -->

                <tr>
                    <td
                        style="
                            padding:42px 30px 40px 30px;
                            background:#ffffff;
                        "
                    >

                        <!-- =================================================
                             ICON
                        ================================================== -->

                        <table
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            align="center"
                        >
                            <tr>
                                <td
                                    align="center"
                                    valign="middle"
                                    style="
                                        width:68px;
                                        height:68px;
                                        background:#111111;
                                        border:4px solid #f5c400;
                                        border-radius:50%;
                                        font-size:29px;
                                        line-height:68px;
                                    "
                                >
                                    🔐
                                </td>
                            </tr>
                        </table>


                        <!-- =================================================
                             TITLE
                        ================================================== -->

                        <h1
                            style="
                                margin:22px 0 0 0;
                                padding:0;
                                text-align:center;
                                font-size:29px;
                                line-height:38px;
                                font-weight:900;
                                color:#111111;
                            "
                        >
                            Password Recovery
                        </h1>


                        <p
                            style="
                                margin:12px auto 0 auto;
                                max-width:510px;
                                text-align:center;
                                font-size:14px;
                                line-height:24px;
                                color:#6b6b6b;
                            "
                        >
                            We received a request to verify your
                            SMART BASKET account and reset your password.
                        </p>


                        <!-- =================================================
                             ACCOUNT EMAIL
                        ================================================== -->

                        @if(!empty($email))

                        <table
                            width="100%"
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            style="
                                width:100%;
                                margin-top:28px;
                                background:#f5f5f5;
                                border:1px solid #dddddd;
                                border-radius:13px;
                            "
                        >
                            <tr>

                                <td
                                    width="125"
                                    valign="middle"
                                    style="
                                        padding:15px 12px;
                                        font-size:10px;
                                        line-height:16px;
                                        font-weight:900;
                                        letter-spacing:1.5px;
                                        color:#777777;
                                        white-space:nowrap;
                                    "
                                >
                                    ACCOUNT EMAIL
                                </td>

                                <td
                                    valign="middle"
                                    style="
                                        padding:15px 14px;
                                        text-align:right;
                                        font-size:13px;
                                        line-height:18px;
                                        font-weight:700;
                                        color:#111111;
                                        white-space:nowrap;
                                        word-break:normal;
                                        overflow:hidden;
                                    "
                                >
                                    {{ $email }}
                                </td>

                            </tr>
                        </table>

                        @endif


                        <!-- =================================================
                             OTP PREMIUM BOX
                        ================================================== -->

                        <table
                            width="100%"
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            style="
                                width:100%;
                                margin-top:30px;
                                background:#f5c400;
                                border:2px solid #111111;
                                border-radius:18px;
                            "
                        >

                            <tr>
                                <td
                                    align="center"
                                    style="
                                        padding:27px 15px 29px 15px;
                                    "
                                >

                                    <!-- LABEL -->

                                    <div
                                        style="
                                            font-size:10px;
                                            line-height:17px;
                                            font-weight:900;
                                            letter-spacing:3px;
                                            color:#111111;
                                        "
                                    >
                                        YOUR VERIFICATION CODE
                                    </div>


                                    <!-- =================================================
                                         OTP DIRECTLY ON YELLOW BACKGROUND
                                    ================================================== -->

                                    <div
                                        style="
                                            margin-top:13px;
                                            font-family:Arial, Helvetica, sans-serif;
                                            font-size:42px;
                                            line-height:52px;
                                            font-weight:900;
                                            letter-spacing:9px;
                                            color:#000000;
                                            text-align:center;
                                            white-space:nowrap;
                                        "
                                    >
                                        {{ $otp }}
                                    </div>


                                    <!-- INSTRUCTION -->

                                    <div
                                        style="
                                            margin-top:11px;
                                            font-size:11px;
                                            line-height:18px;
                                            font-weight:900;
                                            letter-spacing:1px;
                                            color:#222222;
                                        "
                                    >
                                        ENTER THIS CODE TO CONTINUE
                                    </div>

                                </td>
                            </tr>

                        </table>


                        <!-- =================================================
                             EXPIRY
                        ================================================== -->

                        <table
                            width="100%"
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            style="
                                width:100%;
                                margin-top:22px;
                                background:#fffdf0;
                                border:1px solid #eadc8b;
                                border-radius:13px;
                            "
                        >
                            <tr>
                                <td
                                    align="center"
                                    style="
                                        padding:17px 15px;
                                    "
                                >

                                    <div
                                        style="
                                            font-size:13px;
                                            line-height:20px;
                                            font-weight:900;
                                            color:#222222;
                                        "
                                    >
                                        ⏱ Code expires in 5 minutes
                                    </div>

                                    <div
                                        style="
                                            margin-top:3px;
                                            font-size:11px;
                                            line-height:18px;
                                            color:#777777;
                                        "
                                    >
                                        Please enter the verification code before it expires.
                                    </div>

                                </td>
                            </tr>
                        </table>


                        <!-- =================================================
                             SECURITY NOTICE
                        ================================================== -->

                        <table
                            width="100%"
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            style="
                                width:100%;
                                margin-top:22px;
                                background:#f6f6f6;
                                border-left:5px solid #f5c400;
                                border-radius:12px;
                            "
                        >
                            <tr>
                                <td
                                    style="
                                        padding:17px 18px;
                                    "
                                >

                                    <div
                                        style="
                                            font-size:13px;
                                            line-height:20px;
                                            font-weight:900;
                                            color:#111111;
                                        "
                                    >
                                        🛡️ Security Notice
                                    </div>

                                    <div
                                        style="
                                            margin-top:6px;
                                            font-size:12px;
                                            line-height:20px;
                                            color:#666666;
                                        "
                                    >
                                        Never share this verification code with anyone.
                                        SMART BASKET support will never ask for your OTP
                                        or password.
                                    </div>

                                </td>
                            </tr>
                        </table>


                        <!-- =================================================
                             NOT REQUESTED
                        ================================================== -->

                        <p
                            style="
                                margin:23px 0 0 0;
                                padding:0;
                                text-align:center;
                                font-size:11px;
                                line-height:19px;
                                color:#888888;
                            "
                        >
                            If you did not request this password recovery,
                            you can safely ignore this email.
                        </p>

                    </td>
                </tr>


                <!-- =================================================
                     FOOTER
                ================================================== -->

                <tr>
                    <td
                        align="center"
                        style="
                            background:#111111;
                            padding:29px 20px 31px 20px;
                            border-top:5px solid #f5c400;
                        "
                    >

                        <div
                            style="
                                font-size:19px;
                                line-height:25px;
                                font-weight:900;
                                letter-spacing:3px;
                                color:#f5c400;
                            "
                        >
                            SMART BASKET
                        </div>

                        <div
                            style="
                                margin-top:7px;
                                font-size:11px;
                                line-height:18px;
                                color:#999999;
                            "
                        >
                            Your trusted smart shopping destination.
                        </div>


                        <table
                            width="100%"
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            style="
                                max-width:390px;
                                margin-top:18px;
                            "
                        >
                            <tr>
                                <td
                                    style="
                                        height:1px;
                                        background:#303030;
                                        font-size:1px;
                                        line-height:1px;
                                    "
                                >
                                    &nbsp;
                                </td>
                            </tr>
                        </table>


                        <div
                            style="
                                margin-top:15px;
                                font-size:10px;
                                line-height:17px;
                                color:#707070;
                            "
                        >
                            © {{ date('Y') }} SMART BASKET
                        </div>

                        <div
                            style="
                                margin-top:3px;
                                font-size:9px;
                                line-height:16px;
                                color:#5f5f5f;
                            "
                        >
                            All rights reserved.
                        </div>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>

</html>