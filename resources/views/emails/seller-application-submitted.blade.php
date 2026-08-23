<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>SMART BASKET Seller Application</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="
    margin:0;
    padding:0;
    background:#f1f5f9;
    font-family:Arial,Helvetica,sans-serif;
">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 10px;">
    <tr>
        <td align="center">

            <table
                width="700"
                cellpadding="0"
                cellspacing="0"
                style="
                    max-width:700px;
                    width:100%;
                    background:#ffffff;
                    border-radius:18px;
                    overflow:hidden;
                    box-shadow:0 10px 35px rgba(0,0,0,.10);
                "
            >

                {{-- HEADER --}}
                <tr>
                    <td style="
                        background:#111827;
                        padding:30px;
                        text-align:center;
                    ">

                        <div style="
                            font-size:28px;
                            font-weight:bold;
                            color:#ffffff;
                        ">
                            SMART BASKET
                        </div>

                        <div style="
                            margin-top:8px;
                            color:#cbd5e1;
                            font-size:14px;
                        ">
                            SELLER PARTNER PROGRAM
                        </div>

                    </td>
                </tr>


                {{-- TITLE --}}
                <tr>
                    <td style="padding:35px 35px 15px;">

                        <h1 style="
                            margin:0;
                            color:#111827;
                            font-size:25px;
                        ">
                            New Seller Application
                        </h1>

                        <p style="
                            color:#64748b;
                            font-size:15px;
                            line-height:1.7;
                        ">
                            A new seller has completed the SMART BASKET
                            Seller Partner Program application.
                            Please review the submitted information and
                            documents.
                        </p>

                    </td>
                </tr>


                {{-- SELLER DETAILS --}}
                <tr>
                    <td style="padding:10px 35px;">

                        <div style="
                            background:#f8fafc;
                            border:1px solid #e2e8f0;
                            border-radius:14px;
                            padding:22px;
                        ">

                            <h2 style="
                                margin:0 0 18px;
                                color:#111827;
                                font-size:19px;
                            ">
                                Seller Details
                            </h2>

                            <table width="100%" cellpadding="7">

                                <tr>
                                    <td width="40%" style="color:#64748b;">
                                        Seller ID
                                    </td>
                                    <td style="font-weight:bold;color:#111827;">
                                        #{{ $seller->id }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        Name
                                    </td>
                                    <td style="font-weight:bold;color:#111827;">
                                        {{ $seller->name ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        Email
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->email ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        Phone
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->phone ?? $seller->mobile ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        Business Type
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->business_type ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        Business Name
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->business_name ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        Submitted At
                                    </td>
                                    <td style="color:#111827;">
                                        {{ optional($seller->verification_submitted_at)->format('d M Y, h:i A') ?? now()->format('d M Y, h:i A') }}
                                    </td>
                                </tr>

                            </table>

                        </div>

                    </td>
                </tr>


                {{-- BUSINESS DETAILS --}}
                <tr>
                    <td style="padding:10px 35px;">

                        <div style="
                            background:#f8fafc;
                            border:1px solid #e2e8f0;
                            border-radius:14px;
                            padding:22px;
                        ">

                            <h2 style="
                                margin:0 0 18px;
                                color:#111827;
                                font-size:19px;
                            ">
                                Business Information
                            </h2>

                            <table width="100%" cellpadding="7">

                                <tr>
                                    <td width="40%" style="color:#64748b;">
                                        GST Number
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->gst_number ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        PAN Number
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->pan_number ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        Aadhaar Number
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->aadhaar_number ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        Address
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->address ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        City
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->city ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        State
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->state ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        Pincode
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->pincode ?? 'N/A' }}
                                    </td>
                                </tr>

                            </table>

                        </div>

                    </td>
                </tr>


                {{-- BANK DETAILS --}}
                <tr>
                    <td style="padding:10px 35px;">

                        <div style="
                            background:#f8fafc;
                            border:1px solid #e2e8f0;
                            border-radius:14px;
                            padding:22px;
                        ">

                            <h2 style="
                                margin:0 0 18px;
                                color:#111827;
                                font-size:19px;
                            ">
                                Bank Information
                            </h2>

                            <table width="100%" cellpadding="7">

                                <tr>
                                    <td width="40%" style="color:#64748b;">
                                        Account Holder
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->bank_account_name ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        Account Number
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->bank_account_number ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        IFSC
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->bank_ifsc ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color:#64748b;">
                                        Bank Name
                                    </td>
                                    <td style="color:#111827;">
                                        {{ $seller->bank_name ?? 'N/A' }}
                                    </td>
                                </tr>

                            </table>

                        </div>

                    </td>
                </tr>


                {{-- DOCUMENTS --}}
                <tr>
                    <td style="padding:10px 35px;">

                        <div style="
                            background:#eff6ff;
                            border:1px solid #bfdbfe;
                            border-radius:14px;
                            padding:22px;
                        ">

                            <h2 style="
                                margin:0 0 12px;
                                color:#1e3a8a;
                                font-size:19px;
                            ">
                                Documents
                            </h2>

                            <p style="
                                margin:0;
                                color:#475569;
                                line-height:1.6;
                            ">
                                The seller's submitted documents are attached
                                to this email.
                            </p>

                            <ul style="
                                color:#334155;
                                line-height:1.9;
                            ">

                                @if(filled($seller->business_certificate_path))
                                    <li>Business Certificate</li>
                                @endif

                                @if(filled($seller->aadhaar_document_path))
                                    <li>Aadhaar Document</li>
                                @endif

                                @if(filled($seller->pan_document_path))
                                    <li>PAN Document</li>
                                @endif

                                @if(filled($seller->shop_proof_path))
                                    <li>Shop Proof</li>
                                @endif

                                @if(filled($seller->bank_proof_path))
                                    <li>Bank Proof</li>
                                @endif

                            </ul>

                        </div>

                    </td>
                </tr>


                {{-- ACTION --}}
                <tr>
                    <td style="padding:35px;">

                        <div style="
                            text-align:center;
                            background:#f8fafc;
                            border-radius:16px;
                            padding:30px 20px;
                        ">

                            <h2 style="
                                margin:0 0 10px;
                                color:#111827;
                            ">
                                Admin Decision
                            </h2>

                            <p style="
                                color:#64748b;
                                margin-bottom:25px;
                            ">
                                Please review the application before making
                                your decision.
                            </p>


                            <a
                                href="{{ $acceptUrl }}"
                                style="
                                    display:inline-block;
                                    background:#16a34a;
                                    color:#ffffff;
                                    text-decoration:none;
                                    padding:15px 35px;
                                    border-radius:10px;
                                    font-weight:bold;
                                    margin:5px;
                                "
                            >
                                ✓ ACCEPT SELLER
                            </a>


                            <a
                                href="{{ $rejectUrl }}"
                                style="
                                    display:inline-block;
                                    background:#dc2626;
                                    color:#ffffff;
                                    text-decoration:none;
                                    padding:15px 35px;
                                    border-radius:10px;
                                    font-weight:bold;
                                    margin:5px;
                                "
                            >
                                ✕ REJECT SELLER
                            </a>

                        </div>

                    </td>
                </tr>


                {{-- FOOTER --}}
                <tr>
                    <td style="
                        background:#111827;
                        padding:25px;
                        text-align:center;
                    ">

                        <div style="
                            color:#ffffff;
                            font-weight:bold;
                        ">
                            SMART BASKET
                        </div>

                        <div style="
                            color:#94a3b8;
                            font-size:12px;
                            margin-top:7px;
                        ">
                            Seller Partner Program
                        </div>

                        <div style="
                            color:#64748b;
                            font-size:11px;
                            margin-top:12px;
                        ">
                            This email contains confidential seller
                            verification information.
                        </div>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>