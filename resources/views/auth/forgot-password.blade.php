<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forgot Password — LAWFIRM</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet"
    >

    <style>

        /* ========================================
           ROOT
        ======================================== */

        :root {
            --gold: #c9a45c;
            --gold-light: #dfc487;

            --ivory: #f3f0e9;

            --muted: rgba(243, 240, 233, .62);
            --soft: rgba(243, 240, 233, .45);

            --dark: #0b0b0b;
            --border: rgba(243, 240, 233, .18);
        }


        /* ========================================
           RESET
        ======================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        html,
        body {
            width: 100%;
            height: 100%;
        }


        body {
            overflow: hidden;

            background: var(--dark);

            color: var(--ivory);

            font-family: 'DM Sans', sans-serif;
        }


        /* ========================================
           PAGE
        ======================================== */

        .forgot-page {

            position: relative;

            width: 100%;
            height: 100vh;

            min-height: 600px;

            overflow: hidden;

            background: #0b0b0b;

            animation:
                pageReveal
                .8s
                ease
                both;
        }


        /* ========================================
           BACKGROUND IMAGE
        ======================================== */

        .background-image {

            position: absolute;

            inset: 0;

            width: 100%;
            height: 100%;

            object-fit: cover;

            opacity: .72;

            filter:
                grayscale(8%)
                contrast(108%)
                brightness(52%);

            transform: scale(1.03);

            animation:
                backgroundReveal
                1.4s
                cubic-bezier(.2,.8,.2,1)
                both;
        }


        /* ========================================
           BACKGROUND OVERLAY
        ======================================== */

        .background-overlay {

            position: absolute;

            inset: 0;

            background:
                linear-gradient(
                    90deg,
                    rgba(5,5,5,.35) 0%,
                    rgba(5,5,5,.42) 50%,
                    rgba(5,5,5,.50) 100%
                );
        }


        /* ========================================
           GOLD CENTER GLOW
        ======================================== */

        .gold-glow {

            position: absolute;

            width: 700px;
            height: 700px;

            left: 50%;
            top: 50%;

            transform:
                translate(-50%, -50%);

            background:
                radial-gradient(
                    circle,
                    rgba(201,164,92,.10) 0%,
                    rgba(201,164,92,.04) 35%,
                    transparent 70%
                );

            pointer-events: none;
        }


        /* ========================================
           BACK TO SIGN IN
        ======================================== */

        .back-link {

            position: absolute;

            top: 42px;
            right: 6vw;

            z-index: 20;

            display: inline-flex;

            align-items: center;

            gap: 10px;

            color:
                rgba(243,240,233,.82);

            font-size: 10px;

            font-weight: 500;

            letter-spacing: .20em;

            text-transform: uppercase;

            text-decoration: none;

            padding-bottom: 9px;

            transition:
                color .25s ease;
        }


        .back-link::after {

            content: '';

            position: absolute;

            left: 0;
            bottom: 0;

            width: 100%;

            height: 1px;

            background: var(--gold);

            transform:
                scaleX(0);

            transform-origin: right;

            transition:
                transform .3s ease;
        }


        .back-link:hover {

            color: var(--gold);
        }


        .back-link:hover::after {

            transform:
                scaleX(1);

            transform-origin: left;
        }


        .back-arrow {

            color: var(--gold);

            font-size: 16px;

            line-height: 1;

            transition:
                transform .25s ease;
        }


        .back-link:hover .back-arrow {

            transform:
                translateX(-5px);
        }


        /* ========================================
           FORM AREA
        ======================================== */

        .form-area {

            position: absolute;

            inset: 0;

            z-index: 10;

            width: 100%;
            height: 100%;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 80px 25px 40px;
        }


        /* ========================================
           FORM CONTAINER
           NO BOX
        ======================================== */

        .form-container {

            width: min(500px, 100%);

            padding: 20px;

            background: transparent;

            border: none;

            backdrop-filter: none;

            -webkit-backdrop-filter: none;

            box-shadow: none;

            animation:
                formReveal
                .9s
                .10s
                cubic-bezier(.2,.8,.2,1)
                both;
        }


        /* ========================================
           KICKER
        ======================================== */

        .form-kicker {

            margin-bottom: 15px;

            color: var(--gold);

            font-size: 9px;

            font-weight: 600;

            letter-spacing: .30em;

            text-transform: uppercase;
        }


        /* ========================================
           TITLE
        ======================================== */

        .form-title {

            margin-bottom: 18px;

            font-family:
                'Cormorant Garamond',
                serif;

            font-size:
                clamp(44px, 5vw, 62px);

            font-weight: 400;

            line-height: .95;

            letter-spacing: -.025em;

            color: var(--ivory);
        }


        /* ========================================
           DESCRIPTION
        ======================================== */

        .form-subtitle {

            max-width: 430px;

            margin-bottom: 34px;

            color: var(--muted);

            font-size: 12px;

            line-height: 1.85;
        }


        /* ========================================
           STATUS MESSAGE
        ======================================== */

        .status-message {

            margin-bottom: 23px;

            padding: 13px 15px;

            border-left:
                2px solid var(--gold);

            background:
                rgba(201,164,92,.06);

            color:
                rgba(243,240,233,.72);

            font-size: 10px;

            line-height: 1.7;
        }


        /* ========================================
           FORM GROUP
        ======================================== */

        .form-group {

            margin-bottom: 22px;
        }


        /* ========================================
           LABEL
        ======================================== */

        .form-label {

            display: block;

            margin-bottom: 9px;

            color:
                rgba(243,240,233,.72);

            font-size: 9px;

            font-weight: 500;

            letter-spacing: .18em;

            text-transform: uppercase;
        }


        /* ========================================
           INPUT
        ======================================== */

        .form-input {

            width: 100%;

            height: 53px;

            padding: 0 16px;

            border:

                1px solid
                rgba(243,240,233,.24);

            outline: none;

            border-radius: 0;

            background:
                rgba(0,0,0,.28);

            color: var(--ivory);

            font-family:
                'DM Sans',
                sans-serif;

            font-size: 12px;

            transition:
                border-color .25s ease,
                background .25s ease,
                box-shadow .25s ease;
        }


        .form-input::placeholder {

            color:
                rgba(243,240,233,.30);
        }


        .form-input:hover {

            border-color:
                rgba(243,240,233,.40);
        }


        .form-input:focus {

            border-color:
                rgba(201,164,92,.80);

            background:
                rgba(0,0,0,.38);

            box-shadow:
                0 0 0 3px
                rgba(201,164,92,.055);
        }


        /* ========================================
           ERROR
        ======================================== */

        .error-message {

            margin-top: 7px;

            color:
                #c98f8f;

            font-size: 10px;

            line-height: 1.5;
        }


        /* ========================================
           SUBMIT BUTTON
        ======================================== */

        .submit-button {

            position: relative;

            width: 100%;

            height: 53px;

            margin-top: 5px;

            border:
                1px solid
                var(--gold);

            background:
                var(--gold);

            color: #111;

            font-family:
                'DM Sans',
                sans-serif;

            font-size: 10px;

            font-weight: 600;

            letter-spacing: .20em;

            text-transform: uppercase;

            cursor: pointer;

            overflow: hidden;

            transition:
                color .3s ease;
        }


        .submit-button::before {

            content: '';

            position: absolute;

            inset: 0;

            background: #171717;

            transform:
                translateX(-101%);

            transition:
                transform .35s
                cubic-bezier(.2,.8,.2,1);
        }


        .submit-button span {

            position: relative;

            z-index: 2;
        }


        .submit-button:hover {

            color: var(--ivory);
        }


        .submit-button:hover::before {

            transform:
                translateX(0);
        }


        /* ========================================
           BOTTOM LINK
        ======================================== */

        .form-bottom {

            margin-top: 27px;

            text-align: center;

            color:
                rgba(243,240,233,.50);

            font-size: 10px;
        }


        .form-bottom a {

            position: relative;

            margin-left: 5px;

            color: var(--gold);

            text-decoration: none;
        }


        .form-bottom a::after {

            content: '';

            position: absolute;

            left: 0;
            right: 0;

            bottom: -3px;

            height: 1px;

            background: var(--gold);

            transform:
                scaleX(0);

            transform-origin: right;

            transition:
                transform .25s ease;
        }


        .form-bottom a:hover::after {

            transform:
                scaleX(1);

            transform-origin: left;
        }


        /* ========================================
           PAGE ANIMATIONS
        ======================================== */

        @keyframes pageReveal {

            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }


        @keyframes backgroundReveal {

            from {

                opacity: 0;

                transform:
                    scale(1.08);
            }

            to {

                opacity: .72;

                transform:
                    scale(1.03);
            }
        }


        @keyframes formReveal {

            from {

                opacity: 0;

                transform:
                    translateY(25px);
            }

            to {

                opacity: 1;

                transform:
                    translateY(0);
            }
        }


        /* ========================================
           PAGE LEAVE
        ======================================== */

        .forgot-page.page-leaving {

            animation:
                pageLeave
                .32s
                ease
                forwards;
        }


        @keyframes pageLeave {

            to {

                opacity: 0;

                transform:
                    translateY(-8px);
            }
        }


        /* ========================================
           TABLET
        ======================================== */

        @media (max-width: 900px) {

            .form-container {

                width:
                    min(480px, 100%);
            }

            .background-overlay {

                background:
                    rgba(5,5,5,.45);
            }
        }


        /* ========================================
           MOBILE
        ======================================== */

        @media (max-width: 760px) {

            body {

                overflow: hidden;
            }


            .forgot-page {

                min-height: 100vh;
            }


            .background-image {

                opacity: .66;
            }


            .background-overlay {

                background:
                    rgba(5,5,5,.50);
            }


            .gold-glow {

                width: 450px;

                height: 450px;
            }


            .back-link {

                top: 25px;

                right: 25px;

                font-size: 9px;
            }


            .form-area {

                padding:
                    75px 20px 30px;
            }


            .form-container {

                width: 100%;

                padding: 15px;
            }


            .form-title {

                font-size: 44px;
            }


            .form-subtitle {

                font-size: 11px;

                line-height: 1.75;

                margin-bottom: 28px;
            }


            .form-input {

                height: 50px;
            }


            .submit-button {

                height: 51px;
            }
        }


        /* ========================================
           SMALL MOBILE
        ======================================== */

        @media (max-width: 500px) {

            .back-link {

                top: 22px;

                right: 20px;
            }


            .form-area {

                padding:
                    70px 18px 25px;
            }


            .form-container {

                padding: 10px;
            }


            .form-kicker {

                font-size: 8px;

                letter-spacing: .27em;
            }


            .form-title {

                font-size: 39px;
            }


            .form-subtitle {

                font-size: 10.5px;

                line-height: 1.7;
            }


            .form-label {

                font-size: 8px;
            }


            .form-input {

                height: 48px;

                font-size: 11px;
            }


            .submit-button {

                height: 50px;

                font-size: 9px;
            }


            .form-bottom {

                font-size: 9px;
            }
        }


        /* ========================================
           VERY SMALL MOBILE
        ======================================== */

        @media (max-width: 380px) {

            .form-area {

                padding:
                    65px 15px 20px;
            }


            .form-container {

                padding: 5px;
            }


            .form-title {

                font-size: 35px;
            }


            .form-subtitle {

                font-size: 10px;
            }


            .form-group {

                margin-bottom: 18px;
            }
        }


        /* ========================================
           SHORT SCREENS
        ======================================== */

        @media (max-height: 720px) and (min-width: 761px) {

            .form-container {

                padding:
                    10px 20px;
            }


            .form-title {

                font-size: 48px;
            }


            .form-subtitle {

                margin-bottom: 23px;
            }


            .form-group {

                margin-bottom: 17px;
            }


            .form-input {

                height: 48px;
            }


            .submit-button {

                height: 49px;
            }
        }


        /* ========================================
           REDUCED MOTION
        ======================================== */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {

                animation-duration:
                    .01ms !important;

                animation-iteration-count:
                    1 !important;

                transition-duration:
                    .01ms !important;
            }
        }

    </style>

</head>


<body>


<div
    class="forgot-page"
    id="forgotPasswordPage"
>


    {{-- ========================================
         FULL PAGE BACKGROUND
    ======================================== --}}

    <img
        src="{{ asset('storage/backgrounds/instagram.jpeg') }}"
        alt=""
        class="background-image"
    >


    <div class="background-overlay"></div>


    <div class="gold-glow"></div>


    {{-- ========================================
         BACK TO LOGIN
    ======================================== --}}

    <a
        href="{{ route('login') }}"
        class="back-link transition-link"
    >

        <span class="back-arrow">
            ←
        </span>

        <span>
            Back to Sign In
        </span>

    </a>


    {{-- ========================================
         CENTERED FORM
    ======================================== --}}

    <main class="form-area">


        <div class="form-container">


            {{-- KICKER --}}

            <div class="form-kicker">
                Account Recovery
            </div>


            {{-- TITLE --}}

            <h1 class="form-title">
                Forgot your password?
            </h1>


            {{-- DESCRIPTION --}}

            <p class="form-subtitle">

                No problem. Enter the email address associated
                with your LAWFIRM account and we will send you
                a secure link to create a new password.

            </p>


            {{-- ========================================
                 SUCCESS MESSAGE
            ======================================== --}}

            @if (session('status'))

                <div class="status-message">

                    {{ session('status') }}

                </div>

            @endif


            {{-- ========================================
                 PASSWORD RESET FORM
            ======================================== --}}

            <form
                method="POST"
                action="{{ route('password.email') }}"
            >

                @csrf


                {{-- EMAIL --}}

                <div class="form-group">


                    <label
                        for="email"
                        class="form-label"
                    >
                        Email Address
                    </label>


                    <input
                        id="email"
                        class="form-input"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="Enter your email address"
                    >


                    {{-- VALIDATION ERROR --}}

                    @if ($errors->get('email'))

                        <div class="error-message">

                            @foreach ($errors->get('email') as $error)

                                {{ $error }}

                            @endforeach

                        </div>

                    @endif


                </div>


                {{-- ========================================
                     BUTTON
                ======================================== --}}

                <button
                    type="submit"
                    class="submit-button"
                >

                    <span>
                        Email Password Reset Link
                    </span>

                </button>


            </form>


            {{-- ========================================
                 BOTTOM LOGIN LINK
            ======================================== --}}

            <div class="form-bottom">

                Remember your password?

                <a
                    href="{{ route('login') }}"
                    class="transition-link"
                >
                    Sign in
                </a>

            </div>


        </div>


    </main>


</div>


{{-- ========================================
     PAGE TRANSITION
======================================== --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const page =
            document.getElementById(
                'forgotPasswordPage'
            );


        const links =
            document.querySelectorAll(
                '.transition-link'
            );


        links.forEach(
            function (link) {

                link.addEventListener(
                    'click',
                    function (event) {

                        const href =
                            this.getAttribute(
                                'href'
                            );


                        if (!href) {
                            return;
                        }


                        event.preventDefault();


                        page.classList.add(
                            'page-leaving'
                        );


                        setTimeout(
                            function () {

                                window.location.href =
                                    href;

                            },
                            320
                        );

                    }
                );

            }
        );

    }
);

</script>


</body>

</html>
