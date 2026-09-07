<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Your Password | LAWFIRM</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@400;500;600&display=swap');

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            background-color: #0b0b0b;
        }

        body {
            font-family: 'DM Sans', Arial, Helvetica, sans-serif;
            color: #f3f0e9;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        img {
            border: 0;
            display: block;
            max-width: 100%;
        }

        a {
            color: inherit;
        }

        .wrapper {
            width: 100%;
            background-color: #0b0b0b;
            padding: 50px 20px;
        }

        .container {
            width: 100%;
            max-width: 620px;
            margin: 0 auto;
            background-color: #111111;
            border: 1px solid #2a2a2a;
        }

        .header {
            padding: 42px 50px 30px;
            border-bottom: 1px solid #292929;
        }

        .brand {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 32px;
            font-weight: 600;
            letter-spacing: 5px;
            color: #c9a45c;
            text-align: center;
        }

        .brand-subtitle {
            margin-top: 7px;
            font-family: 'DM Sans', Arial, Helvetica, sans-serif;
            font-size: 9px;
            font-weight: 500;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #858585;
            text-align: center;
        }

        .content {
            padding: 55px 50px 50px;
        }

        .kicker {
            margin: 0 0 14px;
            font-family: 'DM Sans', Arial, Helvetica, sans-serif;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #c9a45c;
        }

        .title {
            margin: 0;
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 48px;
            line-height: 1.05;
            font-weight: 500;
            color: #f3f0e9;
        }

        .gold-line {
            width: 55px;
            height: 1px;
            margin: 25px 0 28px;
            background-color: #c9a45c;
        }

        .message {
            margin: 0 0 20px;
            font-family: 'DM Sans', Arial, Helvetica, sans-serif;
            font-size: 15px;
            line-height: 1.8;
            color: #b8b8b8;
        }

        .message strong {
            color: #f3f0e9;
            font-weight: 500;
        }

        .button-wrapper {
            padding: 18px 0 30px;
            text-align: left;
        }

        .button {
            display: inline-block;
            padding: 17px 32px;
            background-color: #c9a45c;
            color: #0b0b0b !important;
            text-decoration: none;
            font-family: 'DM Sans', Arial, Helvetica, sans-serif;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .security-box {
            margin-top: 10px;
            padding: 22px;
            background-color: #181818;
            border-left: 2px solid #c9a45c;
        }

        .security-title {
            margin: 0 0 7px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #c9a45c;
        }

        .security-text {
            margin: 0;
            font-size: 12px;
            line-height: 1.7;
            color: #888888;
        }

        .fallback {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #292929;
        }

        .fallback-label {
            margin: 0 0 10px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #777777;
        }

        .fallback-url {
            margin: 0;
            font-size: 11px;
            line-height: 1.7;
            word-break: break-all;
            color: #a9905e;
        }

        .footer {
            padding: 28px 50px 35px;
            border-top: 1px solid #292929;
            text-align: center;
        }

        .footer-brand {
            margin: 0 0 8px;
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 19px;
            letter-spacing: 3px;
            color: #c9a45c;
        }

        .footer-text {
            margin: 0;
            font-size: 10px;
            line-height: 1.7;
            color: #666666;
        }

        .footer-link {
            color: #c9a45c;
            text-decoration: none;
        }

        @media only screen and (max-width: 600px) {

            .wrapper {
                padding: 20px 10px;
            }

            .header {
                padding: 30px 25px 25px;
            }

            .content {
                padding: 40px 25px;
            }

            .footer {
                padding: 25px;
            }

            .title {
                font-size: 38px;
            }

            .button {
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>

<table role="presentation" width="100%" class="wrapper">
    <tr>
        <td align="center">

            <table role="presentation" class="container">

                {{-- HEADER --}}
                <tr>
                    <td class="header">

                        <div class="brand">
                            LAWFIRM
                        </div>

                        <div class="brand-subtitle">
                            Legal Excellence · Trusted Counsel
                        </div>

                    </td>
                </tr>


                {{-- CONTENT --}}
                <tr>
                    <td class="content">

                        <p class="kicker">
                            Account Recovery
                        </p>

                        <h1 class="title">
                            Reset Your Password
                        </h1>

                        <div class="gold-line"></div>

                        <p class="message">
                            Hello,
                        </p>

                        <p class="message">
                            We received a request to reset the password associated
                            with your <strong>LAWFIRM</strong> account.
                        </p>

                        <p class="message">
                            Click the button below to create a new password and
                            regain access to your account.
                        </p>


                        {{-- BUTTON --}}
                        <div class="button-wrapper">

                            <a href="{{ $url }}"
                               class="button">
                                Reset Password
                            </a>

                        </div>


                        {{-- SECURITY MESSAGE --}}
                        <div class="security-box">

                            <p class="security-title">
                                Security Notice
                            </p>

                            <p class="security-text">
                                This password reset link will expire in
                                <strong>60 minutes</strong>.
                                If you did not request a password reset,
                                you can safely ignore this email.
                            </p>

                        </div>


                        {{-- FALLBACK URL --}}
                        <div class="fallback">

                            <p class="fallback-label">
                                Button not working?
                            </p>

                            <p class="fallback-url">
                                {{ $url }}
                            </p>

                        </div>

                    </td>
                </tr>


                {{-- FOOTER --}}
                <tr>
                    <td class="footer">

                        <p class="footer-brand">
                            LAWFIRM
                        </p>

                        <p class="footer-text">
                            This email was sent to
                            {{ $email }}.
                        </p>

                        <p class="footer-text">
                            If you did not request this password reset,
                            no further action is required.
                        </p>

                        <br>

                        <p class="footer-text">
                            © {{ date('Y') }} LAWFIRM.
                            All rights reserved.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>