<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>
        New Seller Application
    </title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#f4f4f5;
    font-family:Arial,Helvetica,sans-serif;
    color:#18181b;
">

<div style="
    max-width:760px;
    margin:30px auto;
    background:#ffffff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 10px 40px rgba(0,0,0,.10);
">

    <!-- HEADER -->

    <div style="
        background:#111111;
        color:#ffffff;
        padding:28px 30px;
    ">

        <div style="
            font-size:13px;
            letter-spacing:2px;
            opacity:.65;
            margin-bottom:8px;
        ">
            SMART BASKET PREMIUM
        </div>

        <div style="
            font-size:26px;
            font-weight:800;
        ">
            New Seller Application
        </div>

        <div style="
            margin-top:8px;
            color:#cfcfcf;
            font-size:14px;
        ">
            Seller Application #{{ $seller->id }}
        </div>

    </div>


    <!-- CONTENT -->

    <div style="padding:30px;">

        <div style="
            font-size:20px;
            font-weight:800;
            margin-bottom:20px;
        ">
            Seller Details
        </div>


        <table width="100%" cellpadding="10" cellspacing="0"
               style="
                    border-collapse:collapse;
                    font-size:14px;
               ">

            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                    width:40%;
                ">
                    Seller ID
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                    font-weight:700;
                ">
                    #{{ $seller->id }}
                </td>
            </tr>


            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                ">
                    Seller Name
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                    font-weight:700;
                ">
                    {{ $seller->seller_name ?: 'N/A' }}
                </td>
            </tr>


            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                ">
                    Shop Name
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                    font-weight:700;
                ">
                    {{ $seller->shop_name ?: 'N/A' }}
                </td>
            </tr>


            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                ">
                    Email
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                ">
                    {{ $seller->email ?: 'N/A' }}
                </td>
            </tr>


            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                ">
                    Mobile
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                ">
                    {{ $seller->mobile_number ?: 'N/A' }}
                </td>
            </tr>


            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                ">
                    Address
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                ">
                    {{ $seller->shop_address ?: 'N/A' }}
                </td>
            </tr>


            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                ">
                    City
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                ">
                    {{ $seller->city ?: 'N/A' }}
                </td>
            </tr>


            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                ">
                    State
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                ">
                    {{ $seller->state ?: 'N/A' }}
                </td>
            </tr>


            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                ">
                    Pincode
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                ">
                    {{ $seller->pincode ?: 'N/A' }}
                </td>
            </tr>

        </table>


        <!-- BUSINESS -->

        <div style="
            font-size:20px;
            font-weight:800;
            margin-top:32px;
            margin-bottom:15px;
        ">
            Business Details
        </div>


        <table width="100%" cellpadding="10" cellspacing="0"
               style="border-collapse:collapse;font-size:14px;">

            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                    width:40%;
                ">
                    Business Type
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                ">
                    {{ $seller->business_type ?: 'N/A' }}
                </td>
            </tr>


            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                ">
                    GST Number
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                ">
                    {{ $seller->gst_number ?: 'N/A' }}
                </td>
            </tr>


            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                ">
                    PAN Number
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                ">
                    {{ $seller->pan_number ?: 'N/A' }}
                </td>
            </tr>


            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                ">
                    Udyam Number
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                ">
                    {{ $seller->udyam_number ?: 'N/A' }}
                </td>
            </tr>

        </table>


        <!-- BANK -->

        <div style="
            font-size:20px;
            font-weight:800;
            margin-top:32px;
            margin-bottom:15px;
        ">
            Bank Details
        </div>


        <table width="100%" cellpadding="10" cellspacing="0"
               style="border-collapse:collapse;font-size:14px;">

            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                    width:40%;
                ">
                    Account Holder
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                ">
                    {{ $seller->bank_account_holder ?: 'N/A' }}
                </td>
            </tr>


            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                ">
                    Account Number
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                ">
                    {{ $seller->bank_account_number ?: 'N/A' }}
                </td>
            </tr>


            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                ">
                    IFSC
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                ">
                    {{ $seller->bank_ifsc ?: 'N/A' }}
                </td>
            </tr>


            <tr>
                <td style="
                    border-bottom:1px solid #e4e4e7;
                    color:#71717a;
                ">
                    Bank Name
                </td>

                <td style="
                    border-bottom:1px solid #e4e4e7;
                ">
                    {{ $seller->bank_name ?: 'N/A' }}
                </td>
            </tr>

        </table>


        <!-- VERIFICATION -->

        <div style="
            margin-top:30px;
            padding:18px;
            background:#f4f4f5;
            border-radius:12px;
        ">

            <strong>
                Verification Status:
            </strong>

            <span style="
                margin-left:8px;
                font-weight:700;
            ">
                {{ $seller->verificationStatusLabel() }}
            </span>

            <br><br>

            <strong>
                Submitted At:
            </strong>

            {{ optional($seller->verification_submitted_at)->format('d M Y, h:i A') }}

        </div>


        <!-- DOCUMENTS -->

        <div style="
            margin-top:30px;
            padding:18px;
            background:#fafafa;
            border:1px solid #e4e4e7;
            border-radius:12px;
        ">

            <div style="
                font-weight:800;
                margin-bottom:10px;
            ">
                Documents
            </div>

            <div style="font-size:14px;line-height:1.8;">

                Business Certificate:
                <strong>
                    {{ $seller->business_certificate_path ? 'Attached' : 'Not uploaded' }}
                </strong>

                <br>

                Aadhaar Document:
                <strong>
                    {{ $seller->aadhaar_document_path ? 'Attached' : 'Not uploaded' }}
                </strong>

            </div>

            <div style="
                margin-top:10px;
                color:#71717a;
                font-size:12px;
            ">
                Uploaded documents are attached to this email.
            </div>

        </div>


        <!-- ACTION -->

        <div style="
            margin-top:35px;
            padding:22px;
            border-radius:14px;
            background:#111111;
            color:#ffffff;
        ">

            <div style="
                font-size:18px;
                font-weight:800;
                margin-bottom:8px;
            ">
                Admin Review Required
            </div>

            <div style="
                font-size:13px;
                color:#cccccc;
            ">
                Please open the Smart Basket admin panel to review,
                approve or reject this seller application.
            </div>

        </div>


        <div style="
            margin-top:25px;
            color:#71717a;
            font-size:12px;
            line-height:1.6;
        ">
            This is an automated email from SMART BASKET PREMIUM.
            Please do not reply directly to this email.
        </div>

    </div>

</div>

</body>
</html> 