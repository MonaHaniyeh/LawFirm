<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'LawFirm' }}</title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#f7f4ed;
    font-family:Arial, Helvetica, sans-serif;
    color:#151515;
">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f7f4ed; padding:40px 15px;">
        <tr>
            <td align="center">

                <!-- Main Container -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="
                    max-width:620px;
                    background:#ffffff;
                    border:1px solid #e7e3db;
                ">

                    <!-- =====================================================
                    HEADER
                    ====================================================== -->
                    <tr>
                        <td style="
                            background:#151515;
                            padding:34px 40px;
                        ">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td>
                                        <div style="
                                            color:#ffffff;
                                            font-family:Georgia, 'Times New Roman', serif;
                                            font-size:30px;
                                            font-weight:600;
                                            letter-spacing:1px;
                                            line-height:1;
                                        ">
                                            LawFirm
                                        </div>

                                        <div style="
                                            margin-top:8px;
                                            color:#aaa59b;
                                            font-size:10px;
                                            font-weight:bold;
                                            letter-spacing:3px;
                                            text-transform:uppercase;
                                        ">
                                            Legal Management System
                                        </div>
                                    </td>

                                    <td align="right" valign="top">
                                        <div style="
                                            width:34px;
                                            height:34px;
                                            border:1px solid #b69a68;
                                            color:#b69a68;
                                            text-align:center;
                                            line-height:34px;
                                            font-family:Georgia, serif;
                                            font-size:18px;
                                        ">
                                            L
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- =====================================================
                    GOLD LINE
                    ====================================================== -->
                    <tr>
                        <td style="
                            height:3px;
                            background:#b69a68;
                            font-size:0;
                            line-height:0;
                        ">
                            &nbsp;
                        </td>
                    </tr>

                    <!-- =====================================================
                    CONTENT
                    ====================================================== -->
                    <tr>
                        <td style="
                            padding:45px 40px 40px;
                        ">

                            <!-- Eyebrow -->
                            @if (isset($label))
                                <div style="
                                    margin-bottom:12px;
                                    color:#b69a68;
                                    font-size:10px;
                                    font-weight:bold;
                                    letter-spacing:2px;
                                    text-transform:uppercase;
                                ">
                                    {{ $label }}
                                </div>
                            @endif

                            <!-- Heading -->
                            @if (isset($heading))
                                <h1 style="
                                    margin:0 0 18px;
                                    color:#151515;
                                    font-family:Georgia, 'Times New Roman', serif;
                                    font-size:30px;
                                    font-weight:600;
                                    line-height:1.2;
                                ">
                                    {{ $heading }}
                                </h1>
                            @endif

                            <!-- Greeting -->
                            @if (isset($greeting))
                                <p style="
                                    margin:0 0 18px;
                                    color:#151515;
                                    font-size:14px;
                                    line-height:1.7;
                                ">
                                    {{ $greeting }}
                                </p>
                            @endif

                            <!-- Main Message -->
                            @if (isset($message))
                                <p style="
                                    margin:0 0 28px;
                                    color:#66635d;
                                    font-size:14px;
                                    line-height:1.8;
                                ">
                                    {{ $message }}
                                </p>
                            @endif

                            <!-- Information Box -->
                            @if (isset($details) && count($details))
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="
                                    margin:25px 0 30px;
                                    border:1px solid #e7e3db;
                                    background:#f7f4ed;
                                ">
                                    @foreach ($details as $key => $value)
                                        <tr>
                                            <td style="
                                                padding:13px 16px;
                                                border-bottom:1px solid #e7e3db;
                                                color:#7d7b76;
                                                font-size:11px;
                                                font-weight:bold;
                                                text-transform:uppercase;
                                                letter-spacing:1px;
                                                width:38%;
                                            ">
                                                {{ $key }}
                                            </td>

                                            <td style="
                                                padding:13px 16px;
                                                border-bottom:1px solid #e7e3db;
                                                color:#151515;
                                                font-size:13px;
                                                line-height:1.5;
                                            ">
                                                {{ $value }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif

                            <!-- Action Button -->
                            @if (isset($actionUrl) && isset($actionText))
                                <table cellpadding="0" cellspacing="0" border="0" style="margin:30px 0;">
                                    <tr>
                                        <td>
                                            <a href="{{ $actionUrl }}" style="
                                                display:inline-block;
                                                padding:13px 25px;
                                                background:#151515;
                                                color:#ffffff;
                                                text-decoration:none;
                                                font-size:12px;
                                                font-weight:bold;
                                                letter-spacing:.5px;
                                            ">
                                                {{ $actionText }}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            <!-- Security Note -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="
                                margin-top:30px;
                                border-top:1px solid #e7e3db;
                            ">
                                <tr>
                                    <td style="
                                        padding-top:20px;
                                        color:#8a8780;
                                        font-size:11px;
                                        line-height:1.7;
                                    ">
                                        This is an automated notification from LawFirm.
                                        Please do not reply directly to this email.
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- =====================================================
                    FOOTER
                    ====================================================== -->
                    <tr>
                        <td style="
                            background:#151515;
                            padding:28px 40px;
                        ">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td>
                                        <div style="
                                            color:#ffffff;
                                            font-family:Georgia, serif;
                                            font-size:17px;
                                        ">
                                            LawFirm
                                        </div>

                                        <div style="
                                            margin-top:6px;
                                            color:#77736b;
                                            font-size:10px;
                                            letter-spacing:1.5px;
                                            text-transform:uppercase;
                                        ">
                                            Secure Legal Management
                                        </div>
                                    </td>

                                    <td align="right" valign="middle">
                                        <div style="
                                            color:#b69a68;
                                            font-size:10px;
                                            letter-spacing:1px;
                                        ">
                                            © {{ date('Y') }} LawFirm
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>

                <!-- Outside Footer -->
                <div style="
                    max-width:620px;
                    padding-top:18px;
                    color:#99958d;
                    font-size:10px;
                    text-align:center;
                    line-height:1.6;
                ">
                    This email was sent by the LawFirm Management System.
                </div>

            </td>
        </tr>
    </table>

</body>

</html>
