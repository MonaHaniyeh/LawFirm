<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <title>LAWFIRM — Create Account</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">

    <style>
        /* =====================================================
           RESET
        ====================================================== */

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family:
                'DM Sans',
                sans-serif;

            background: #17191b;
            color: #f3f0e9;
        }


        /* =====================================================
           PAGE
        ====================================================== */

        .auth-page {
            width: 100%;
            min-height: 100vh;
            min-height: 100dvh;

            display: grid;

            grid-template-columns:
                minmax(0, 1fr) minmax(0, 1fr);

            overflow: hidden;

            animation:
                pageEnter .65s cubic-bezier(.22, 1, .36, 1);
        }

        @keyframes pageEnter {

            from {
                opacity: 0;

                transform:
                    translateX(-25px);
            }

            to {
                opacity: 1;

                transform:
                    translateX(0);
            }
        }

        .auth-page.page-leaving {
            animation:
                pageLeave .3s ease forwards;
        }

        @keyframes pageLeave {

            from {
                opacity: 1;

                transform:
                    translateX(0);
            }

            to {
                opacity: 0;

                transform:
                    translateX(-25px);
            }
        }


        /* =====================================================
           BRAND SIDE
        ====================================================== */

        .brand-side {
            position: relative;

            min-width: 0;
            min-height: 100vh;

            padding:
                clamp(30px, 4vw, 55px);

            display: flex;
            flex-direction: column;

            overflow: hidden;

            border-right:
                1px solid rgba(201, 164, 92, .22);

            background: #111315;
        }


        /* =====================================================
           BACKGROUND
        ====================================================== */

        .brand-background {
            position: absolute;

            inset: 0;

            width: 100%;
            height: 100%;

            object-fit: cover;
            object-position: center;

            opacity: .64;

            filter:
                saturate(.65) contrast(1.06);

            z-index: 0;
        }

        .brand-overlay {
            position: absolute;

            inset: 0;

            z-index: 1;

            background:
                linear-gradient(90deg,
                    rgba(8, 10, 11, .93) 0%,
                    rgba(8, 10, 11, .70) 45%,
                    rgba(8, 10, 11, .88) 100%),
                linear-gradient(180deg,
                    rgba(8, 10, 11, .60) 0%,
                    rgba(8, 10, 11, .18) 45%,
                    rgba(8, 10, 11, .94) 100%);
        }


        /* =====================================================
           BRAND WRAPPER
        ====================================================== */

        .brand-wrapper {
            position: relative;

            z-index: 2;

            width: 100%;
            height: 100%;

            display: flex;
            flex-direction: column;

            overflow: hidden;
        }


        /* =====================================================
           BRAND ROW
        ====================================================== */

        .brand-row {
            display: flex;

            align-items: center;

            gap: 14px;

            width: 100%;

            flex-shrink: 0;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            min-width: 42px;

            display: flex;

            align-items: center;
            justify-content: center;

            border:
                1px solid rgba(201, 164, 92, .78);

            background:
                rgba(15, 17, 18, .32);

            backdrop-filter:
                blur(5px);
        }

        .brand-icon svg {
            width: 28px;
            height: 28px;

            color: #c9a45c;
        }

        .brand-name {
            display: flex;

            align-items: center;

            height: 42px;

            color: #f3f0e8;

            font-size: 14px;

            font-weight: 600;

            letter-spacing: .30em;

            line-height: 1;

            white-space: nowrap;
        }


        /* =====================================================
           BRAND CONTENT
           SAME X LEVEL AS ICON
        ====================================================== */

        .brand-content {
            width: 100%;
            max-width: 530px;

            margin-top:
                clamp(50px, 8vh, 85px);

            margin-left: 0;

            flex-shrink: 0;
        }

        .eyebrow {
            margin-bottom: 21px;

            color: #c9a45c;

            font-size: 10px;

            font-weight: 600;

            letter-spacing: .27em;

            text-transform: uppercase;
        }

        .brand-title {
            margin: 0;

            font-family:
                'Cormorant Garamond',
                serif;

            font-size:
                clamp(60px,
                    7vw,
                    100px);

            line-height: .82;

            font-weight: 500;

            letter-spacing: -.045em;

            color: #f4f1ea;
        }

        .brand-title span {
            display: block;

            margin-top: 8px;

            color: #d0ad62;

            font-style: italic;
        }

        .brand-description {
            max-width: 430px;

            margin:
                clamp(24px, 4vh, 32px) 0 0;

            color: #c0beb8;

            font-size:
                clamp(12px,
                    1vw,
                    14px);

            line-height: 1.85;
        }

        .brand-line {
            width: 72px;
            height: 1px;

            margin-top: 28px;

            background: #c9a45c;
        }

        .brand-footer {
            margin-top: auto;

            padding-top: 20px;

            color: #aaa69d;

            font-size: 9px;

            letter-spacing: .14em;

            text-transform: uppercase;
        }


        /* =====================================================
           FORM SIDE
        ====================================================== */

        .form-side {
            min-width: 0;
            min-height: 100vh;

            display: flex;

            align-items: center;
            justify-content: center;

            padding:
                clamp(30px, 5vw, 70px);

            background: #17191b;
        }

        .form-container {
            width: 100%;

            max-width: 450px;
        }


        /* =====================================================
           HEADER
        ====================================================== */

        .form-header {
            margin-bottom: 26px;
        }

        .form-kicker {
            margin-bottom: 11px;

            color: #c9a45c;

            font-size: 10px;

            font-weight: 600;

            letter-spacing: .25em;

            text-transform: uppercase;
        }

        .form-title {
            margin: 0;

            font-family:
                'Cormorant Garamond',
                serif;

            font-size:
                clamp(42px,
                    5vw,
                    56px);

            line-height: .92;

            font-weight: 500;

            letter-spacing: -.035em;

            color: #f3f0e9;
        }

        .form-subtitle {
            max-width: 440px;

            margin:
                16px 0 0;

            color: #969894;

            font-size: 12px;

            line-height: 1.75;
        }


        /* =====================================================
           REGISTER FORM
        ====================================================== */

        .register-form {
            display: flex;

            flex-direction: column;

            gap: 13px;
        }

        .field {
            display: flex;

            flex-direction: column;

            gap: 6px;
        }

        .field label {
            color: #b7b5b0;

            font-size: 10px;

            font-weight: 500;

            letter-spacing: .11em;

            text-transform: uppercase;
        }


        /* =====================================================
           INPUT
        ====================================================== */

        .input,
        .select {
            width: 100%;

            height: 47px;

            padding:
                0 14px;

            border:
                1px solid #35383a;

            outline: none;

            background: #111315;

            color: #f2efe8;

            font-family:
                'DM Sans',
                sans-serif;

            font-size: 12px;

            border-radius: 0;

            transition:
                border-color .2s ease,
                background .2s ease,
                box-shadow .2s ease;
        }

        .input::placeholder {
            color: #656865;
        }

        .input:hover,
        .select:hover {
            border-color: #4a4d4c;
        }

        .input:focus,
        .select:focus {
            border-color: #c9a45c;

            background: #141618;

            box-shadow:
                0 0 0 3px rgba(201, 164, 92, .06);
        }

        .select {
            cursor: pointer;

            appearance: none;

            background-image:
                linear-gradient(45deg,
                    transparent 50%,
                    #888 50%),
                linear-gradient(135deg,
                    #888 50%,
                    transparent 50%);

            background-position:
                calc(100% - 17px) 20px,
                calc(100% - 12px) 20px;

            background-size:
                5px 5px,
                5px 5px;

            background-repeat: no-repeat;
        }

        .select option {
            background: #17191b;

            color: #f3f0e9;
        }


        /* =====================================================
           PASSWORD
        ====================================================== */

        .input-wrapper {
            position: relative;

            width: 100%;
        }

        .password-input {
            padding-right: 50px;
        }

        .password-toggle {
            position: absolute;

            right: 12px;

            top: 50%;

            transform:
                translateY(-50%);

            border: none;

            background: transparent;

            color: #777a76;

            padding: 5px;

            cursor: pointer;
        }

        .password-toggle:hover {
            color: #c9a45c;
        }

        .password-toggle svg {
            width: 18px;
            height: 18px;
        }


        /* =====================================================
           ERRORS
        ====================================================== */

        .error {
            color: #d18b8b;

            font-size: 10px;

            line-height: 1.4;
        }


        /* =====================================================
           SUBMIT
        ====================================================== */

        .submit-button {
            width: 100%;

            min-height: 50px;

            margin-top: 5px;

            border:
                1px solid #c9a45c;

            background: #c9a45c;

            color: #111315;

            font-family:
                'DM Sans',
                sans-serif;

            font-size: 10px;

            font-weight: 600;

            letter-spacing: .20em;

            text-transform: uppercase;

            cursor: pointer;

            transition:
                background .25s ease,
                color .25s ease,
                transform .2s ease;
        }

        .submit-button:hover {
            background: transparent;

            color: #d8b86b;
        }

        .submit-button:active {
            transform:
                translateY(1px);
        }


        /* =====================================================
           GOOGLE REGISTER
        ====================================================== */

        .google-divider {
            display: flex;

            align-items: center;

            gap: 12px;

            margin-top: 14px;

            margin-bottom: 14px;
        }

        .google-divider-line {
            flex: 1;

            height: 1px;

            background: #35383a;
        }

        .google-divider-text {
            color: #666966;

            font-size: 9px;

            letter-spacing: .12em;

            text-transform: uppercase;
        }

        .google-button {
            width: 100%;

            min-height: 50px;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 10px;

            border:
                1px solid #35383a;

            background: #111315;

            color: #d8d6d0;

            text-decoration: none;

            font-family:
                'DM Sans',
                sans-serif;

            font-size: 10px;

            font-weight: 500;

            letter-spacing: .10em;

            text-transform: uppercase;

            transition:
                border-color .25s ease,
                color .25s ease,
                background .25s ease,
                box-shadow .25s ease;
        }

        .google-button:hover {
            border-color: #c9a45c;

            background: #141618;

            color: #f3f0e9;

            box-shadow:
                0 0 0 3px rgba(201, 164, 92, .05);
        }

        .google-button:active {
            transform:
                translateY(1px);
        }

        .google-button svg {
            width: 18px;

            height: 18px;

            flex-shrink: 0;
        }


        /* =====================================================
           LOGIN LINK
        ====================================================== */

        .login-link {
            margin-top: 17px;

            text-align: center;

            color: #7c7f7b;

            font-size: 11px;
        }

        .login-link a {
            margin-left: 5px;

            color: #c9a45c;

            text-decoration: none;

            font-weight: 500;
        }

        .login-link a:hover {
            color: #e1c47d;
        }


        /* =====================================================
           SECURITY
        ====================================================== */

        .security-note {
            display: flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            margin-top: 14px;

            color: #666966;

            font-size: 9px;

            text-align: center;

            line-height: 1.5;
        }

        .security-icon {
            width: 7px;
            height: 7px;

            flex-shrink: 0;

            border:
                1px solid #8b7548;

            transform:
                rotate(45deg);
        }


        /* =====================================================
           TABLET
        ====================================================== */

        @media (max-width: 900px) {

            .auth-page {
                grid-template-columns: 1fr;

                overflow: visible;
            }

            .brand-side {
                min-height: 460px;

                padding:
                    35px 30px;

                border-right: none;

                border-bottom:
                    1px solid rgba(201, 164, 92, .20);

                order: 1;
            }

            .form-side {
                min-height: auto;

                padding:
                    55px 30px;

                order: 2;
            }

            .brand-footer {
                display: none;
            }

            .brand-content {
                margin-top: 55px;
            }
        }


        /* =====================================================
           MOBILE
        ====================================================== */

        @media (max-width: 600px) {

            .brand-side {
                min-height: 425px;

                padding:
                    28px 22px;
            }

            .brand-row {
                gap: 11px;
            }

            .brand-icon {
                width: 38px;

                height: 38px;

                min-width: 38px;
            }

            .brand-icon svg {
                width: 25px;

                height: 25px;
            }

            .brand-name {
                height: 38px;

                font-size: 12px;

                letter-spacing: .25em;
            }

            .brand-content {
                margin-top: 47px;
            }

            .brand-title {
                font-size:
                    clamp(52px,
                        16vw,
                        70px);
            }

            .brand-description {
                font-size: 11px;

                line-height: 1.75;
            }

            .form-side {
                padding:
                    42px 22px 45px;
            }

            .form-header {
                margin-bottom: 24px;
            }

            .form-title {
                font-size:
                    clamp(39px,
                        13vw,
                        52px);
            }

            .form-subtitle {
                font-size: 11px;
            }

            .register-form {
                gap: 14px;
            }

            .input,
            .select {
                height: 51px;
            }

            .submit-button {
                min-height: 52px;
            }

            .google-button {
                min-height: 52px;
            }
        }


        /* =====================================================
           VERY SMALL PHONES
        ====================================================== */

        @media (max-width: 380px) {

            .brand-side {
                min-height: 400px;

                padding:
                    24px 18px;
            }

            .brand-content {
                margin-top: 40px;
            }

            .brand-title {
                font-size: 49px;
            }

            .form-side {
                padding:
                    36px 18px 40px;
            }

            .form-title {
                font-size: 38px;
            }
        }


        /* =====================================================
           SHORT LAPTOPS
        ====================================================== */

        @media (min-width: 601px) and (max-height: 720px) {

            .brand-side,
            .form-side {
                padding-top: 23px;

                padding-bottom: 23px;
            }

            .brand-content {
                margin-top: 40px;
            }

            .brand-title {
                font-size: 68px;
            }

            .brand-description {
                margin-top: 19px;

                font-size: 12px;
            }

            .form-header {
                margin-bottom: 18px;
            }

            .form-title {
                font-size: 44px;
            }

            .register-form {
                gap: 9px;
            }

            .input,
            .select {
                height: 42px;
            }

            .submit-button {
                min-height: 43px;
            }

            .google-button {
                min-height: 43px;
            }

            .login-link {
                margin-top: 9px;
            }

            .security-note {
                margin-top: 7px;
            }
        }


        /* =====================================================
           REDUCED MOTION
        ====================================================== */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation: none !important;

                transition: none !important;
            }
        }
    </style>

</head>


<body>

    <div class="auth-page">


        <!-- =====================================================
         LEFT — BRAND
    ====================================================== -->

        <section class="brand-side">

            <img src="{{ asset('storage/backgrounds/instagram.jpeg') }}" alt="" class="brand-background">

            <div class="brand-overlay"></div>

            <div class="brand-wrapper">


                <div class="brand-row">

                    <div class="brand-icon">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3"
                                d="M12 3v2m0 0v16m-7-9h14M5 12l-3 6h6l-3-6zm14 0l-3 6h6l-3-6zM8 21h8" />

                        </svg>

                    </div>


                    <div class="brand-name">
                        LAWFIRM
                    </div>

                </div>


                <div class="brand-content">

                    <div class="eyebrow">
                        Private Legal Platform
                    </div>


                    <h2 class="brand-title">

                        Law.

                        <span>
                            With purpose.
                        </span>

                    </h2>


                    <p class="brand-description">

                        A secure legal environment designed to keep
                        your cases, documents, appointments, and
                        communications organized in one private place.

                    </p>


                    <div class="brand-line"></div>

                </div>


                <div class="brand-footer">

                    Confidential Legal Services · Established 2026

                </div>


            </div>

        </section>


        <!-- =====================================================
         RIGHT — REGISTER FORM
    ====================================================== -->

        <section class="form-side">

            <div class="form-container">


                <div class="form-header">

                    <div class="form-kicker">
                        Create Your Account
                    </div>


                    <h1 class="form-title">
                        Begin with LAWFIRM
                    </h1>


                    <p class="form-subtitle">

                        Create your secure account to access your
                        legal services, case information, appointments,
                        and documents in one private environment.

                    </p>

                </div>


                <form method="POST" action="{{ route('register') }}" class="register-form">

                    @csrf


                    <!-- FULL NAME -->

                    <div class="field">

                        <label for="name">
                            Full Name
                        </label>

                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                            autofocus autocomplete="name" placeholder="Enter your full name" class="input">

                        @error('name')
                            <span class="error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- EMAIL -->

                    <div class="field">

                        <label for="email">
                            Email Address
                        </label>

                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            autocomplete="username" placeholder="name@example.com" class="input">

                        @error('email')
                            <span class="error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- ACCOUNT TYPE -->

                    <div class="field">

                        <label for="role">
                            Account Type
                        </label>


                        <select id="role" name="role" required class="select">

                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>
                                Select account type
                            </option>


                            <option value="client" {{ old('role') === 'client' ? 'selected' : '' }}>
                                Client
                            </option>


                            <option value="lawyer" {{ old('role') === 'lawyer' ? 'selected' : '' }}>
                                Lawyer
                            </option>

                        </select>


                        @error('role')
                            <span class="error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- PASSWORD -->

                    <div class="field">

                        <label for="password">
                            Password
                        </label>


                        <div class="input-wrapper">

                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                placeholder="Create a secure password" class="input password-input">


                            <button type="button" class="password-toggle" onclick="togglePassword('password', this)"
                                aria-label="Show password">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                </svg>

                            </button>

                        </div>


                        @error('password')
                            <span class="error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- CONFIRM PASSWORD -->

                    <div class="field">

                        <label for="password_confirmation">
                            Confirm Password
                        </label>


                        <div class="input-wrapper">

                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                autocomplete="new-password" placeholder="Confirm your password"
                                class="input password-input">


                            <button type="button" class="password-toggle"
                                onclick="togglePassword('password_confirmation', this)" aria-label="Show password">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                </svg>

                            </button>

                        </div>


                        @error('password_confirmation')
                            <span class="error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- SUBMIT -->

                    <button type="submit" class="submit-button">
                        Create Account
                    </button>

                </form>


                <!-- GOOGLE REGISTER -->

                <div class="google-divider">

                    <div class="google-divider-line"></div>

                    <span class="google-divider-text">
                        Or
                    </span>

                    <div class="google-divider-line"></div>

                </div>


                <a href="{{ route('social.redirect', ['provider' => 'google']) }}" class="google-button">

                    <svg viewBox="0 0 24 24" aria-hidden="true">

                        <path fill="#4285F4"
                            d="M21.35 12.27c0-.79-.07-1.55-.23-2.27H12v4.3h5.24a4.48 4.48 0 0 1-1.94 2.94v2.45h3.14c1.84-1.69 2.91-4.18 2.91-7.42Z" />

                        <path fill="#34A853"
                            d="M12 21.75c2.63 0 4.84-.87 6.45-2.36l-3.14-2.45c-.87.58-1.98.92-3.31.92-2.54 0-4.69-1.72-5.46-4.03H3.3v2.53A9.75 9.75 0 0 0 12 21.75Z" />

                        <path fill="#FBBC05"
                            d="M6.54 13.83A5.86 5.86 0 0 1 6.23 12c0-.64.11-1.26.31-1.83V7.64H3.3A9.75 9.75 0 0 0 2.25 12c0 1.57.38 3.05 1.05 4.36l3.24-2.53Z" />

                        <path fill="#EA4335"
                            d="M12 6.14c1.43 0 2.71.49 3.72 1.46l2.79-2.79C16.84 3.23 14.63 2.25 12 2.25a9.75 9.75 0 0 0-8.7 5.39l3.24 2.53C7.31 7.86 9.46 6.14 12 6.14Z" />

                    </svg>


                    <span>
                        Continue with Google
                    </span>

                </a>


                <!-- LOGIN -->

                <div class="login-link">

                    Already have an account?

                    <a href="{{ route('login') }}" class="transition-link">
                        Sign in
                    </a>

                </div>


                <!-- SECURITY -->

                <div class="security-note">

                    <span class="security-icon"></span>

                    Your information is protected and kept confidential.

                </div>


            </div>

        </section>


    </div>


    <script>
        /* =====================================================
           PASSWORD TOGGLE
        ====================================================== */

        function togglePassword(id, button) {

            const input =
                document.getElementById(id);

            if (input.type === 'password') {

                input.type = 'text';

                button.setAttribute(
                    'aria-label',
                    'Hide password'
                );

            } else {

                input.type = 'password';

                button.setAttribute(
                    'aria-label',
                    'Show password'
                );

            }

        }


        /* =====================================================
           PAGE TRANSITION
        ====================================================== */

        document.addEventListener(
            'DOMContentLoaded',
            function() {

                const links =
                    document.querySelectorAll(
                        '.transition-link'
                    );


                links.forEach(function(link) {

                    link.addEventListener(
                        'click',
                        function(event) {

                            const href =
                                this.href;

                            if (!href) {
                                return;
                            }


                            event.preventDefault();


                            const page =
                                document.querySelector(
                                    '.auth-page'
                                );


                            page.classList.add(
                                'page-leaving'
                            );


                            setTimeout(function() {

                                window.location.href =
                                    href;

                            }, 300);

                        }
                    );

                });

            }
        );
    </script>


</body>

</html>
