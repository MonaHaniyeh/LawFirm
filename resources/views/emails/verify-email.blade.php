<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verify Your Email | Law Firm</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background: #F7F4ED;
            font-family: Arial, Helvetica, sans-serif;
            color: #41403C;
        }

        .page {
            width: 100%;
            padding: 40px 20px;
            background: #F7F4ED;
        }

        .card {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #E8E6E1;
        }

        /* Header */
        .header {
            background: #181815;
            padding: 35px 30px;
            text-align: center;
            border-bottom: 2px solid #B89452;
        }

        .brand {
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 4px;
            color: #D8BE8A;
        }

        .portal {
            margin-top: 10px;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 25px;
            color: #F7F4ED;
        }

        .line {
            width: 50px;
            height: 1px;
            background: #B89452;
            margin: 18px auto 0;
        }

        /* Content */
        .content {
            padding: 45px 40px;
            text-align: center;
        }

        .label {
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #B89452;
            text-transform: uppercase;
        }

        h1 {
            margin: 15px 0 0;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 30px;
            font-weight: normal;
            color: #181815;
        }

        .greeting {
            margin: 25px 0 0;
            font-size: 15px;
            line-height: 1.7;
            color: #41403C;
        }

        .message {
            margin: 15px 0 0;
            font-size: 15px;
            line-height: 1.7;
            color: #77756F;
        }

        /* Verify Button */
        .verify-container {
            margin: 35px 0;
            text-align: center;
        }

        .verify-button {
            display: inline-block;
            padding: 15px 32px;
            background: #181815;
            border: 1px solid #B89452;
            color: #F7F4ED !important;
            text-decoration: none !important;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Information Box */
        .notice {
            margin: 30px 0;
            padding: 20px;
            background: #F7F4ED;
            border: 1px solid #E8E6E1;
            text-align: left;
        }

        .notice-title {
            margin: 0 0 8px;
            font-size: 12px;
            font-weight: bold;
            color: #41403C;
        }

        .notice-text {
            margin: 0;
            font-size: 12px;
            line-height: 1.6;
            color: #77756F;
        }

        /* Expiration */
        .expiry {
            margin: 25px 0 0;
            font-size: 12px;
            line-height: 1.6;
            color: #9B9992;
        }

        /* Fallback Link */
        .link-section {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #E8E6E1;
            text-align: left;
        }

        .link-title {
            margin: 0 0 8px;
            font-size: 11px;
            font-weight: bold;
            color: #41403C;
        }

        .verification-link {
            word-break: break-all;
            font-size: 11px;
            line-height: 1.6;
            color: #B89452;
        }

        /* Footer */
        .footer {
            background: #11110F;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #B89452;
        }

        .footer-brand {
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 3px;
            color: #D8BE8A;
        }

        .footer-text {
            margin-top: 8px;
            font-size: 11px;
            color: #77756F;
        }

        /* Mobile */
        @media (max-width: 600px) {
            .page {
                padding: 20px 12px;
            }

            .content {
                padding: 35px 25px;
            }

            h1 {
                font-size: 26px;
            }

            .portal {
                font-size: 22px;
            }

            .verify-button {
                display: block;
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <div class="page">

        <div class="card">

            {{-- Header --}}
            <div class="header">

                <div class="brand">
                    LAW FIRM
                </div>

                <div class="portal">
                    Secure Legal Portal
                </div>

                <div class="line"></div>

            </div>


            {{-- Content --}}
            <div class="content">

                <div class="label">
                    Email Verification
                </div>

                <h1>
                    Verify Your Email
                </h1>


                {{-- User Greeting --}}
                <p class="greeting">
                    Hello {{ $user->name }},
                </p>


                {{-- Message --}}
                <p class="message">
                    Thank you for creating your account with our Law Firm.
                    Before accessing your secure legal portal, please verify
                    your email address.
                </p>


                {{-- Verify Email Button --}}
                <div class="verify-container">

                    <a
                        href="{{ $verificationUrl }}"
                        class="verify-button"
                    >
                        Verify Email
                    </a>

                </div>


                {{-- Information Box --}}
                <div class="notice">

                    <p class="notice-title">
                        What happens next?
                    </p>

                    <p class="notice-text">
                        Click the "Verify Email" button above to confirm your
                        email address and activate your secure legal portal
                        account.
                    </p>

                </div>


                {{-- Expiration --}}
                <p class="expiry">
                    This verification link will expire in 60 minutes.
                    If you did not create this account, you can safely ignore
                    this email.
                </p>


                {{-- Fallback URL --}}
                <div class="link-section">

                    <p class="link-title">
                        Button not working?
                    </p>

                    <div class="verification-link">
                        {{ $verificationUrl }}
                    </div>

                </div>

            </div>


            {{-- Footer --}}
            <div class="footer">

                <div class="footer-brand">
                    LAW FIRM
                </div>

                <div class="footer-text">
                    Secure &amp; Confidential
                </div>

            </div>

        </div>

    </div>

</body>

</html>