
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Appointment Approved | Law Firm</title>
</head>

<body style="margin:0; padding:0; background-color:#F7F4ED; color:#181815; font-family:Arial, Helvetica, sans-serif;">

    <!-- Main Wrapper -->
    <table
        width="100%"
        cellpadding="0"
        cellspacing="0"
        border="0"
        style="background-color:#F7F4ED; margin:0; padding:40px 15px;"
    >
        <tr>
            <td align="center">

                <!-- Email Container -->
                <table
                    width="100%"
                    cellpadding="0"
                    cellspacing="0"
                    border="0"
                    style="max-width:620px; background:#FFFFFF;"
                >

                    <!-- Header -->
                    <tr>
                        <td
                            style="
                                background:#11110F;
                                padding:32px 35px;
                                text-align:center;
                                border-bottom:1px solid #B89452;
                            "
                        >

                            <div
                                style="
                                    color:#D8BE8A;
                                    font-size:11px;
                                    line-height:18px;
                                    letter-spacing:4px;
                                    text-transform:uppercase;
                                    font-weight:bold;
                                "
                            >
                                LAW FIRM
                            </div>

                            <div
                                style="
                                    margin-top:10px;
                                    color:#F7F4ED;
                                    font-family:Georgia, 'Times New Roman', serif;
                                    font-size:24px;
                                    line-height:32px;
                                    font-weight:normal;
                                "
                            >
                                Appointment Notification
                            </div>

                        </td>
                    </tr>


                    <!-- Gold Accent -->
                    <tr>
                        <td style="height:4px; background:#B89452; font-size:0; line-height:0;">
                            &nbsp;
                        </td>
                    </tr>


                    <!-- Content -->
                    <tr>
                        <td
                            style="
                                padding:42px 42px 38px 42px;
                                border-left:1px solid #E8E6E1;
                                border-right:1px solid #E8E6E1;
                            "
                        >

                            <!-- Status -->
                            <table
                                width="100%"
                                cellpadding="0"
                                cellspacing="0"
                                border="0"
                                style="margin-bottom:28px;"
                            >
                                <tr>
                                    <td>

                                        <span
                                            style="
                                                display:inline-block;
                                                padding:7px 12px;
                                                background:#EFF8F2;
                                                border:1px solid #D6EBDD;
                                                color:#27633D;
                                                font-size:11px;
                                                line-height:16px;
                                                letter-spacing:1px;
                                                text-transform:uppercase;
                                                font-weight:bold;
                                            "
                                        >
                                            Approved
                                        </span>

                                    </td>
                                </tr>
                            </table>


                            <!-- Heading -->
                            <h1
                                style="
                                    margin:0 0 20px 0;
                                    color:#181815;
                                    font-family:Georgia, 'Times New Roman', serif;
                                    font-size:30px;
                                    line-height:38px;
                                    font-weight:normal;
                                "
                            >
                                Your Appointment<br>
                                Has Been Approved
                            </h1>


                            <!-- Greeting -->
                            <p
                                style="
                                    margin:0 0 14px 0;
                                    color:#41403C;
                                    font-size:14px;
                                    line-height:24px;
                                "
                            >
                                Dear
                                <strong style="color:#181815;">
                                    {{ $appointment->client->name }}
                                </strong>,
                            </p>

                            <p
                                style="
                                    margin:0 0 28px 0;
                                    color:#41403C;
                                    font-size:14px;
                                    line-height:24px;
                                "
                            >
                                Your appointment request has been reviewed and
                                <strong style="color:#181815;">
                                    approved by your lawyer.
                                </strong>
                                Please find the appointment details below.
                            </p>


                            <!-- Appointment Details -->
                            <table
                                width="100%"
                                cellpadding="0"
                                cellspacing="0"
                                border="0"
                                style="
                                    background:#FAF9F6;
                                    border:1px solid #E8E6E1;
                                    border-left:3px solid #B89452;
                                    margin:0 0 28px 0;
                                "
                            >

                                <!-- Section Header -->
                                <tr>
                                    <td
                                        colspan="2"
                                        style="
                                            padding:18px 20px;
                                            border-bottom:1px solid #E8E6E1;
                                            background:#F4F1E9;
                                        "
                                    >
                                        <span
                                            style="
                                                color:#77756F;
                                                font-size:10px;
                                                line-height:15px;
                                                letter-spacing:2px;
                                                text-transform:uppercase;
                                                font-weight:bold;
                                            "
                                        >
                                            Appointment Details
                                        </span>
                                    </td>
                                </tr>


                                <!-- Case -->
                                <tr>
                                    <td
                                        width="42%"
                                        style="
                                            padding:17px 20px 8px 20px;
                                            color:#77756F;
                                            font-size:10px;
                                            line-height:16px;
                                            letter-spacing:1.5px;
                                            text-transform:uppercase;
                                        "
                                    >
                                        Case
                                    </td>

                                    <td
                                        style="
                                            padding:17px 20px 8px 10px;
                                            color:#181815;
                                            font-size:14px;
                                            line-height:20px;
                                            font-weight:bold;
                                        "
                                    >
                                        #{{ $appointment->case->case_number }}
                                    </td>
                                </tr>


                                <!-- Date -->
                                <tr>
                                    <td
                                        style="
                                            padding:8px 20px;
                                            color:#77756F;
                                            font-size:10px;
                                            line-height:16px;
                                            letter-spacing:1.5px;
                                            text-transform:uppercase;
                                        "
                                    >
                                        Date
                                    </td>

                                    <td
                                        style="
                                            padding:8px 20px 8px 10px;
                                            color:#41403C;
                                            font-size:14px;
                                            line-height:20px;
                                        "
                                    >
                                        {{ $appointment->appointment_date->format('d M Y') }}
                                    </td>
                                </tr>


                                <!-- Time -->
                                <tr>
                                    <td
                                        style="
                                            padding:8px 20px;
                                            color:#77756F;
                                            font-size:10px;
                                            line-height:16px;
                                            letter-spacing:1.5px;
                                            text-transform:uppercase;
                                        "
                                    >
                                        Time
                                    </td>

                                    <td
                                        style="
                                            padding:8px 20px 8px 10px;
                                            color:#41403C;
                                            font-size:14px;
                                            line-height:20px;
                                        "
                                    >
                                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                    </td>
                                </tr>


                                @if ($appointment->meeting_location)

                                    <!-- Location -->
                                    <tr>
                                        <td
                                            style="
                                                padding:8px 20px 17px 20px;
                                                color:#77756F;
                                                font-size:10px;
                                                line-height:16px;
                                                letter-spacing:1.5px;
                                                text-transform:uppercase;
                                            "
                                        >
                                            Location
                                        </td>

                                        <td
                                            style="
                                                padding:8px 20px 17px 10px;
                                                color:#41403C;
                                                font-size:14px;
                                                line-height:20px;
                                            "
                                        >
                                            {{ $appointment->meeting_location }}
                                        </td>
                                    </tr>

                                @else

                                    <tr>
                                        <td colspan="2" style="height:8px; font-size:0;">
                                            &nbsp;
                                        </td>
                                    </tr>

                                @endif

                            </table>


                            <!-- Note -->
                            @if ($appointment->note)

                                <table
                                    width="100%"
                                    cellpadding="0"
                                    cellspacing="0"
                                    border="0"
                                    style="
                                        margin-bottom:28px;
                                        background:#FFFDF8;
                                        border:1px solid #E8E1D2;
                                    "
                                >
                                    <tr>
                                        <td
                                            style="
                                                padding:17px 20px;
                                            "
                                        >

                                            <div
                                                style="
                                                    margin-bottom:7px;
                                                    color:#795A18;
                                                    font-size:10px;
                                                    line-height:15px;
                                                    letter-spacing:1.5px;
                                                    text-transform:uppercase;
                                                    font-weight:bold;
                                                "
                                            >
                                                Note
                                            </div>

                                            <div
                                                style="
                                                    color:#41403C;
                                                    font-size:13px;
                                                    line-height:22px;
                                                "
                                            >
                                                {{ $appointment->note }}
                                            </div>

                                        </td>
                                    </tr>
                                </table>

                            @endif


                            <!-- Message -->
                            <p
                                style="
                                    margin:0;
                                    color:#77756F;
                                    font-size:13px;
                                    line-height:22px;
                                "
                            >
                                Please keep this confirmation for your records.
                                If you have any questions regarding your appointment,
                                please contact your legal representative through
                                the Law Firm portal.
                            </p>

                        </td>
                    </tr>


                    <!-- Footer -->
                    <tr>
                        <td
                            style="
                                padding:26px 35px;
                                background:#181815;
                                border-top:1px solid #B89452;
                                text-align:center;
                            "
                        >

                            <div
                                style="
                                    color:#D8BE8A;
                                    font-size:10px;
                                    line-height:16px;
                                    letter-spacing:2px;
                                    text-transform:uppercase;
                                    font-weight:bold;
                                "
                            >
                                LAW FIRM
                            </div>

                            <div
                                style="
                                    margin-top:9px;
                                    color:#9B9992;
                                    font-size:11px;
                                    line-height:18px;
                                "
                            >
                                Confidential communication
                            </div>

                            <div
                                style="
                                    margin-top:4px;
                                    color:#77756F;
                                    font-size:10px;
                                    line-height:16px;
                                "
                            >
                                This email was sent automatically. Please do not reply directly.
                            </div>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
