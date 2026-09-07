<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, viewport-fit=cover"
    >

    <title>LAWFIRM — Sign In</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet"
    >

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
            font-family: 'DM Sans', sans-serif;
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
                minmax(0, 1fr)
                minmax(0, 1fr);

            overflow: hidden;

            animation:
                pageEnter .65s cubic-bezier(.22, 1, .36, 1);
        }

        @keyframes pageEnter {
            from {
                opacity: 0;
                transform: translateX(25px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
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

            padding: clamp(30px, 5vw, 70px);

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
            margin-bottom: 30px;
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
                clamp(
                    43px,
                    5vw,
                    58px
                );

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
           FORM
        ====================================================== */

        .login-form {
            display: flex;
            flex-direction: column;

            gap: 17px;
        }

        .field {
            display: flex;
            flex-direction: column;

            gap: 7px;
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

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .input {
            width: 100%;
            height: 50px;

            padding: 0 15px;

            border: 1px solid #35383a;
            outline: none;

            background: #111315;
            color: #f2efe8;

            font-family:
                'DM Sans',
                sans-serif;

            font-size: 13px;

            border-radius: 0;

            transition:
                border-color .2s ease,
                background .2s ease,
                box-shadow .2s ease;
        }

        .input::placeholder {
            color: #656865;
            font-size: 12px;
        }

        .input:hover {
            border-color: #4a4d4c;
        }

        .input:focus {
            border-color: #c9a45c;

            background: #141618;

            box-shadow:
                0 0 0 3px rgba(201, 164, 92, .06);
        }

        .password-input {
            padding-right: 50px;
        }


        /* =====================================================
           PASSWORD TOGGLE
        ====================================================== */

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

            transition:
                color .2s ease;
        }

        .password-toggle:hover {
            color: #c9a45c;
        }

        .password-toggle svg {
            width: 18px;
            height: 18px;
        }


        /* =====================================================
           OPTIONS
        ====================================================== */

        .login-options {
            display: flex;

            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin-top: -2px;
        }

        .remember {
            display: flex;

            align-items: center;

            gap: 8px;

            color: #7c7f7b;

            font-size: 11px;

            cursor: pointer;
        }

        .remember input {
            width: 14px;
            height: 14px;

            accent-color: #c9a45c;

            cursor: pointer;
        }

        .forgot-password {
            color: #c9a45c;

            font-size: 11px;

            text-decoration: none;

            transition:
                color .2s ease;
        }

        .forgot-password:hover {
            color: #e1c47d;
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
           MAIN BUTTON
        ====================================================== */

        .submit-button {
            width: 100%;

            min-height: 51px;

            margin-top: 4px;

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
           GOOGLE LOGIN
        ====================================================== */

        .google-section {
            margin-top: 20px;
        }

        .google-divider {
            display: flex;

            align-items: center;

            gap: 13px;

            margin-bottom: 16px;
        }

        .google-divider-line {
            flex: 1;

            height: 1px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    #35383a
                );
        }

        .google-divider-line:last-child {
            background:
                linear-gradient(
                    90deg,
                    #35383a,
                    transparent
                );
        }

        .google-divider-text {
            flex-shrink: 0;

            color: #666966;

            font-size: 8px;

            font-weight: 600;

            letter-spacing: .20em;

            text-transform: uppercase;
        }


        /* =====================================================
           GOOGLE BUTTON
        ====================================================== */

        .google-button {
            position: relative;

            width: 100%;

            min-height: 51px;

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 11px;

            border:
                1px solid #35383a;

            background: #111315;

            color: #d8d5cd;

            font-family:
                'DM Sans',
                sans-serif;

            font-size: 10px;

            font-weight: 600;

            letter-spacing: .12em;

            text-transform: uppercase;

            text-decoration: none;

            overflow: hidden;

            transition:
                border-color .25s ease,
                background .25s ease,
                color .25s ease,
                transform .2s ease,
                box-shadow .25s ease;
        }

        .google-button::before {
            content: "";

            position: absolute;

            inset: 0;

            background:
                linear-gradient(
                    90deg,
                    transparent 0%,
                    rgba(201, 164, 92, .035) 45%,
                    rgba(201, 164, 92, .08) 50%,
                    rgba(201, 164, 92, .035) 55%,
                    transparent 100%
                );

            transform:
                translateX(-100%);

            transition:
                transform .65s ease;
        }

        .google-button:hover {
            border-color:
                rgba(201, 164, 92, .70);

            background: #141618;

            color: #f3f0e9;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, .20);
        }

        .google-button:hover::before {
            transform:
                translateX(100%);
        }

        .google-button:active {
            transform:
                translateY(1px);
        }

        .google-icon-wrapper {
            position: relative;

            z-index: 1;

            width: 21px;
            height: 21px;

            display: flex;

            align-items: center;
            justify-content: center;

            flex-shrink: 0;
        }

        .google-icon {
            width: 18px;
            height: 18px;

            display: block;
        }

        .google-button > span:last-child {
            position: relative;
            z-index: 1;
        }


        /* =====================================================
           REGISTER LINK
        ====================================================== */

        .register-link {
            margin-top: 19px;

            text-align: center;

            color: #7c7f7b;

            font-size: 11px;
        }

        .register-link a {
            margin-left: 5px;

            color: #c9a45c;

            text-decoration: none;

            font-weight: 500;

            position: relative;
            z-index: 10;

            cursor: pointer;

            transition:
                color .2s ease;
        }

        .register-link a:hover {
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

            margin-top: 16px;

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

            border-left:
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
                saturate(.65)
                contrast(1.06);

            z-index: 0;
        }

        .brand-overlay {
            position: absolute;

            inset: 0;

            z-index: 1;

            background:
                linear-gradient(
                    270deg,
                    rgba(8, 10, 11, .93) 0%,
                    rgba(8, 10, 11, .70) 45%,
                    rgba(8, 10, 11, .88) 100%
                ),
                linear-gradient(
                    180deg,
                    rgba(8, 10, 11, .60) 0%,
                    rgba(8, 10, 11, .18) 45%,
                    rgba(8, 10, 11, .94) 100%
                );
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
           CONTENT
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
                clamp(
                    60px,
                    7vw,
                    100px
                );

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
                clamp(24px, 4vh, 32px)
                0
                0;

            color: #c0beb8;

            font-size:
                clamp(
                    12px,
                    1vw,
                    14px
                );

            line-height: 1.85;
        }

        .brand-line {
            width: 72px;
            height: 1px;

            margin-top: 28px;

            background: #c9a45c;
        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .brand-footer {
            margin-top: auto;

            padding-top: 20px;

            color: #aaa69d;

            font-size: 9px;

            letter-spacing: .14em;

            text-transform: uppercase;

            text-align: right;
        }


        /* =====================================================
           TABLET
        ====================================================== */

        @media (max-width: 900px) {

            .auth-page {
                grid-template-columns: 1fr;

                overflow: visible;

                min-height: 100dvh;
            }

            .form-side {
                min-height: auto;

                padding:
                    60px 30px 55px;

                order: 1;
            }

            .brand-side {
                min-height: 500px;

                padding:
                    35px 30px;

                border-left: none;

                border-top:
                    1px solid rgba(201, 164, 92, .20);

                order: 2;
            }

            .brand-content {
                margin-top: 60px;
            }

            .brand-footer {
                display: none;
            }
        }


        /* =====================================================
           MOBILE
        ====================================================== */

        @media (max-width: 600px) {

            .form-side {
                padding:
                    45px 22px 45px;
            }

            .form-container {
                max-width: 100%;
            }

            .form-header {
                margin-bottom: 26px;
            }

            .form-title {
                font-size:
                    clamp(
                        40px,
                        13vw,
                        52px
                    );
            }

            .form-subtitle {
                font-size: 11px;

                line-height: 1.75;
            }

            .login-form {
                gap: 15px;
            }

            .input {
                height: 51px;
            }

            .login-options {
                align-items: flex-start;
            }

            .remember,
            .forgot-password {
                font-size: 10px;
            }

            .submit-button {
                min-height: 52px;
            }

            .google-button {
                min-height: 52px;
            }

            .brand-side {
                min-height: 440px;

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
                margin-top: 50px;
            }

            .eyebrow {
                font-size: 9px;
            }

            .brand-title {
                font-size:
                    clamp(
                        55px,
                        16vw,
                        72px
                    );
            }

            .brand-description {
                font-size: 11px;

                line-height: 1.75;
            }

            .brand-background {
                object-position: center;
            }
        }


        /* =====================================================
           VERY SMALL PHONES
        ====================================================== */

        @media (max-width: 380px) {

            .form-side {
                padding:
                    38px 18px 40px;
            }

            .form-title {
                font-size: 39px;
            }

            .brand-side {
                padding:
                    25px 18px;
            }

            .brand-title {
                font-size: 51px;
            }

            .google-button {
                font-size: 9px;

                letter-spacing: .10em;
            }
        }


        /* =====================================================
           SHORT LAPTOPS
        ====================================================== */

        @media (min-width: 601px) and (max-height: 720px) {

            .form-side {
                padding-top: 25px;
                padding-bottom: 25px;
            }

            .form-header {
                margin-bottom: 19px;
            }

            .form-title {
                font-size: 45px;
            }

            .login-form {
                gap: 10px;
            }

            .input {
                height: 43px;
            }

            .submit-button {
                min-height: 44px;
            }

            .google-button {
                min-height: 44px;
            }

            .google-section {
                margin-top: 13px;
            }

            .register-link {
                margin-top: 10px;
            }

            .security-note {
                margin-top: 8px;
            }

            .brand-side {
                padding-top: 25px;
                padding-bottom: 25px;
            }

            .brand-content {
                margin-top: 45px;
            }

            .brand-title {
                font-size: 70px;
            }

            .brand-description {
                margin-top: 20px;

                font-size: 12px;
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
             LEFT — LOGIN
        ====================================================== -->

        <section class="form-side">

            <div class="form-container">

                <!-- HEADER -->

                <div class="form-header">

                    <div class="form-kicker">
                        Welcome Back
                    </div>

                    <h1 class="form-title">
                        Sign in to LAWFIRM
                    </h1>

                    <p class="form-subtitle">
                        Access your secure legal workspace and continue
                        managing your cases, appointments, documents,
                        and communications.
                    </p>

                </div>


                <!-- LOGIN FORM -->

                <form
                    method="POST"
                    action="{{ route('login') }}"
                    class="login-form"
                >

                    @csrf


                    <!-- EMAIL -->

                    <div class="field">

                        <label for="email">
                            Email Address
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="name@example.com"
                            class="input"
                        >

                        @error('email')
                            <span class="error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- PASSWORD -->

                    <div
                        class="field"
                        x-data="{ showPassword: false }"
                    >

                        <label for="password">
                            Password
                        </label>

                        <div class="input-wrapper">

                            <input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="input password-input"
                            >


                            <!-- PASSWORD TOGGLE -->

                            <button
                                type="button"
                                class="password-toggle"
                                @click="showPassword = !showPassword"
                                :aria-label="showPassword ? 'Hide password' : 'Show password'"
                            >

                                <!-- SHOW PASSWORD -->

                                <svg
                                    x-show="!showPassword"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />

                                </svg>


                                <!-- HIDE PASSWORD -->

                                <svg
                                    x-show="showPassword"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M3 3l18 18"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M10.584 10.587a2 2 0 002.829 2.829"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M9.88 5.09A10.94 10.94 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.98 10.98 0 01-4.044 5.034"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M6.61 6.61A10.97 10.97 0 002.458 12C3.732 16.057 7.523 19 12 19c1.61 0 3.14-.35 4.51-.978"
                                    />

                                </svg>

                            </button>

                        </div>


                        @error('password')
                            <span class="error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- OPTIONS -->

                    <div class="login-options">

                        <label class="remember">

                            <input
                                type="checkbox"
                                name="remember"
                            >

                            <span>
                                Remember me
                            </span>

                        </label>


                        @if (Route::has('password.request'))

                            <a
                                href="{{ route('password.request') }}"
                                class="forgot-password"
                            >
                                Forgot password?
                            </a>

                        @endif

                    </div>


                    <!-- SIGN IN -->

                    <button
                        type="submit"
                        class="submit-button"
                    >
                        Sign In
                    </button>

                </form>


                <!-- =================================================
                     GOOGLE LOGIN
                ================================================== -->

                <div class="google-section">

                    <div class="google-divider">

                        <span class="google-divider-line"></span>

                        <span class="google-divider-text">
                            Or continue with
                        </span>

                        <span class="google-divider-line"></span>

                    </div>


                    <!-- GOOGLE BUTTON -->

                    <a
                        href="{{ route('social.redirect', ['provider' => 'google']) }}"
                        class="google-button"
                    >

                        <span class="google-icon-wrapper">

                            <svg
                                class="google-icon"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >

                                <path
                                    fill="#4285F4"
                                    d="M21.35 12.27c0-.79-.07-1.55-.23-2.27H12v4.3h5.24a4.48 4.48 0 0 1-1.94 2.94v2.45h3.14c1.84-1.69 2.91-4.18 2.91-7.42Z"
                                />

                                <path
                                    fill="#34A853"
                                    d="M12 21.75c2.63 0 4.84-.87 6.45-2.36l-3.14-2.45c-.87.58-1.98.92-3.31.92-2.54 0-4.69-1.72-5.46-4.03H3.3v2.53A9.75 9.75 0 0 0 12 21.75Z"
                                />

                                <path
                                    fill="#FBBC05"
                                    d="M6.54 13.83A5.86 5.86 0 0 1 6.23 12c0-.64.11-1.26.31-1.83V7.64H3.3A9.75 9.75 0 0 0 2.25 12c0 1.57.38 3.05 1.05 4.36l3.24-2.53Z"
                                />

                                <path
                                    fill="#EA4335"
                                    d="M12 6.14c1.43 0 2.71.49 3.72 1.46l2.79-2.79C16.84 3.23 14.63 2.25 12 2.25a9.75 9.75 0 0 0-8.7 5.39l3.24 2.53C7.31 7.86 9.46 6.14 12 6.14Z"
                                />

                            </svg>

                        </span>

                        <span>
                            Continue with Google
                        </span>

                    </a>

                </div>


                <!-- REGISTER -->

                <div class="register-link">

                    Don't have an account?

                    <a href="{{ route('register') }}">
                        Create account
                    </a>

                </div>


                <!-- SECURITY -->

                <div class="security-note">

                    <span class="security-icon"></span>

                    Your information is protected and kept confidential.

                </div>

            </div>

        </section>


        <!-- =====================================================
             RIGHT — BRAND
        ====================================================== -->

        <section class="brand-side">


            <!-- BACKGROUND -->

            <img
                src="{{ asset('storage/backgrounds/instagram.jpeg') }}"
                alt=""
                class="brand-background"
            >


            <!-- OVERLAY -->

            <div class="brand-overlay"></div>


            <div class="brand-wrapper">


                <!-- BRAND -->

                <div class="brand-row">

                    <div class="brand-icon">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.3"
                                d="M12 3v2m0 0v16m-7-9h14M5 12l-3 6h6l-3-6zm14 0l-3 6h6l-3-6zM8 21h8"
                            />

                        </svg>

                    </div>


                    <div class="brand-name">
                        LAWFIRM
                    </div>

                </div>


                <!-- CONTENT -->

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


                <!-- FOOTER -->

                <div class="brand-footer">

                    Confidential Legal Services · Established 2026

                </div>

            </div>

        </section>

    </div>

</body>

</html>