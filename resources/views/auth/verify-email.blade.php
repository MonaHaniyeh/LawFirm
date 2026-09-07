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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f7f4ed;
            font-family: Arial, Helvetica, sans-serif;
            color: #181815;
        }

        .container {
            width: 100%;
            max-width: 560px;
            padding: 40px 24px;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e6dfd1;
            padding: 50px 45px;
            text-align: center;
            box-shadow: 0 15px 45px rgba(24, 24, 21, 0.08);
        }

        .logo {
            font-size: 14px;
            letter-spacing: 5px;
            font-weight: 700;
            margin-bottom: 35px;
        }

        .line {
            width: 60px;
            height: 2px;
            background: #b89452;
            margin: 0 auto 30px;
        }

        h1 {
            margin: 0 0 20px;
            font-size: 30px;
            font-weight: 500;
        }

        .greeting {
            font-size: 17px;
            margin-bottom: 18px;
        }

        .message {
            color: #666;
            line-height: 1.7;
            font-size: 15px;
            margin-bottom: 30px;
        }

        .status {
            background: #f1eadc;
            border: 1px solid #d8be8a;
            padding: 12px 15px;
            margin-bottom: 25px;
            font-size: 14px;
            color: #594722;
        }

        .verify-button {
            display: inline-block;
            width: 100%;
            border: 0;
            background: #181815;
            color: #ffffff;
            padding: 15px 25px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .verify-button:hover {
            background: #b89452;
        }

        .logout-form {
            margin-top: 20px;
        }

        .logout-button {
            border: 0;
            background: transparent;
            color: #777;
            cursor: pointer;
            font-size: 13px;
        }

        .logout-button:hover {
            color: #181815;
        }

        .footer {
            margin-top: 35px;
            padding-top: 20px;
            border-top: 1px solid #eee8dd;
            font-size: 11px;
            letter-spacing: 2px;
            color: #999;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <div class="logo">
            LAW FIRM
        </div>

        <div class="line"></div>

        <h1>Verify Your Email</h1>

        <p class="greeting">
            Hello {{ Auth::user()->name }},
        </p>

        <p class="message">
            Thank you for registering with our Law Firm portal.
            Please verify your email address by clicking the button below.
        </p>

        @if (session('status') === 'verification-link-sent')
            <div class="status">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('verification.send') }}"
        >
            @csrf

            <button
                type="submit"
                class="verify-button"
            >
                Resend Verification Email
            </button>
        </form>

        <form
            method="POST"
            action="{{ route('logout') }}"
            class="logout-form"
        >
            @csrf

            <button
                type="submit"
                class="logout-button"
            >
                Log Out
            </button>
        </form>

        <div class="footer">
            SECURE & CONFIDENTIAL
        </div>

    </div>

</div>

</body>
</html>