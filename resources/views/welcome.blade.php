<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>LAWFIRM — Legal Platform</title>

    {{-- Google Fonts --}}
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

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
        ===================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #111315;
            color: #f3f0e9;
        }


        /* =====================================================
           PAGE
        ===================================================== */

        .welcome-page {
            position: relative;
            width: 100%;
            height: 100vh;
            min-height: 100vh;
            overflow: hidden;
            isolation: isolate;
            background: #111315;
        }


        /* =====================================================
           FULL BACKGROUND
        ===================================================== */

        .background-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            z-index: -5;

            filter:
                brightness(.43)
                saturate(.48)
                contrast(1.08);

            transform: scale(1.04);

            animation:
                backgroundReveal
                1.4s
                ease-out
                forwards;
        }

        @keyframes backgroundReveal {

            from {
                opacity: 0;
                transform: scale(1.09);
            }

            to {
                opacity: 1;
                transform: scale(1.04);
            }

        }


        /* =====================================================
           BACKGROUND OVERLAY
        ===================================================== */

        .background-overlay {
            position: absolute;
            inset: 0;
            z-index: -4;

            background:
                linear-gradient(
                    90deg,
                    rgba(7, 9, 10, .90) 0%,
                    rgba(7, 9, 10, .76) 27%,
                    rgba(7, 9, 10, .43) 54%,
                    rgba(7, 9, 10, .18) 78%,
                    rgba(7, 9, 10, .35) 100%
                ),

                linear-gradient(
                    180deg,
                    rgba(7, 9, 10, .48) 0%,
                    transparent 35%,
                    transparent 65%,
                    rgba(7, 9, 10, .65) 100%
                );
        }


        /* =====================================================
           GOLD AMBIENT LIGHT
        ===================================================== */

        .gold-glow {
            position: absolute;

            width: 750px;
            height: 750px;

            right: 0;
            top: 50%;

            transform: translateY(-50%);

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(201, 164, 92, .15) 0%,
                    rgba(201, 164, 92, .05) 38%,
                    transparent 72%
                );

            filter: blur(15px);

            pointer-events: none;
            z-index: -3;
        }


        /* =====================================================
           TOP RIGHT NAVIGATION
        ===================================================== */

        .top-navigation {
            position: absolute;

            top: 42px;
            right: 6vw;

            z-index: 100;

            animation:
                contentReveal
                .9s
                .15s
                ease
                both;
        }

        .top-signin {
            position: relative;

            display: inline-flex;
            align-items: center;

            gap: 10px;

            color: rgba(243, 240, 233, .82);

            font-size: 10px;
            font-weight: 500;

            letter-spacing: .20em;
            text-transform: uppercase;

            text-decoration: none;

            padding-bottom: 9px;

            transition:
                color .25s ease;
        }

        .top-signin::after {
            content: '';

            position: absolute;

            left: 0;
            bottom: 0;

            width: 100%;
            height: 1px;

            background: #c9a45c;

            transform: scaleX(0);
            transform-origin: right;

            transition:
                transform .3s ease;
        }

        .top-signin:hover {
            color: #c9a45c;
        }

        .top-signin:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .top-arrow {
            color: #c9a45c;
            font-size: 16px;
            line-height: 1;

            transition:
                transform .25s ease;
        }

        .top-signin:hover .top-arrow {
            transform: translateX(5px);
        }


        /* =====================================================
           MAIN PAGE LAYOUT
        ===================================================== */

        .page-content {
            position: relative;

            width: 100%;
            height: 100%;

            display: flex;

            align-items: stretch;
            justify-content: space-between;

            padding: 45px 6vw;

            z-index: 2;
        }


        /* =====================================================
           LEFT SIDE
        ===================================================== */

        .brand-section {
            width: 50%;
            max-width: 720px;

            height: 100%;

            display: flex;
            flex-direction: column;

            justify-content: space-between;
        }


        /* =====================================================
           BRAND HEADER
        ===================================================== */

        .brand-header {
            display: flex;

            align-items: center;
            justify-content: flex-start;

            animation:
                contentReveal
                .9s
                .15s
                ease
                both;
        }

        .brand {
            display: inline-flex;

            align-items: center;
            justify-content: flex-start;

            gap: 15px;

            color: #f3f0e9;

            text-decoration: none;
            white-space: nowrap;
        }


        /* =====================================================
           BRAND ICON
        ===================================================== */

        .brand-icon {
            width: 46px;
            height: 46px;
            min-width: 46px;

            display: flex;

            align-items: center;
            justify-content: center;

            border:
                1px solid
                rgba(201, 164, 92, .78);

            background:
                rgba(15, 17, 18, .35);

            backdrop-filter:
                blur(7px);

            flex-shrink: 0;
        }

        .brand-icon svg {
            width: 30px;
            height: 30px;

            color: #c9a45c;

            display: block;
        }


        /* =====================================================
           BRAND NAME
        ===================================================== */

        .brand-name {
            display: block;

            color: #f3f0e8;

            font-size: 15px;
            font-weight: 600;

            letter-spacing: .30em;
            line-height: 1;

            white-space: nowrap;
        }


        /* =====================================================
           MAIN CONTENT
        ===================================================== */

        .content {
            flex: 1;

            display: flex;
            flex-direction: column;

            justify-content: center;

            padding: 30px 0 45px;
        }


        /* =====================================================
           KICKER
        ===================================================== */

        .kicker {
            display: flex;

            align-items: center;

            gap: 14px;

            margin-bottom: 26px;

            color: #c9a45c;

            font-size: 11px;
            font-weight: 600;

            letter-spacing: .25em;
            text-transform: uppercase;

            animation:
                contentReveal
                .9s
                .25s
                ease
                both;
        }

        .kicker::before {
            content: '';

            width: 45px;
            height: 1px;

            background: #c9a45c;
        }


        /* =====================================================
           MAIN TITLE
        ===================================================== */

        .main-title {
            max-width: 720px;

            color: #f4f1ea;

            font-family:
                'Cormorant Garamond',
                serif;

            font-size:
                clamp(
                    82px,
                    7.8vw,
                    118px
                );

            font-weight: 500;

            line-height: .76;

            letter-spacing: -.055em;

            animation:
                titleReveal
                1s
                .3s
                cubic-bezier(.2,.8,.2,1)
                both;
        }

        .main-title span {
            display: block;

            margin-top: 10px;

            color: #c9a45c;

            font-style: italic;
            font-weight: 400;
        }


        /* =====================================================
           DESCRIPTION
        ===================================================== */

        .description {
            max-width: 530px;

            margin-top: 36px;

            color:
                rgba(243, 240, 233, .74);

            font-size: 15px;

            line-height: 1.9;

            letter-spacing: .01em;

            animation:
                contentReveal
                .9s
                .48s
                ease
                both;
        }


        /* =====================================================
           DIVIDER
        ===================================================== */

        .divider {
            width: 100%;
            max-width: 540px;

            height: 1px;

            margin: 32px 0;

            background:
                linear-gradient(
                    90deg,
                    rgba(201,164,92,.55),
                    rgba(255,255,255,.18),
                    transparent
                );

            animation:
                dividerReveal
                .9s
                .58s
                ease
                both;
        }


        /* =====================================================
           ACTION BUTTONS
        ===================================================== */

        .actions {
            display: flex;

            align-items: center;

            gap: 14px;

            flex-wrap: wrap;

            animation:
                contentReveal
                .9s
                .65s
                ease
                both;
        }

        .action {
            height: 56px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            padding: 0 38px;

            font-size: 10px;
            font-weight: 600;

            letter-spacing: .18em;
            text-transform: uppercase;

            text-decoration: none;

            transition:
                transform .25s ease,
                background .25s ease,
                border-color .25s ease,
                color .25s ease,
                box-shadow .25s ease;
        }

        .action:hover {
            transform: translateY(-3px);
        }


        /* =====================================================
           PRIMARY BUTTON
        ===================================================== */

        .action-primary {
            background: #c9a45c;

            border:
                1px solid
                #c9a45c;

            color: #111315;

            box-shadow:
                0 12px 30px
                rgba(0,0,0,.25);
        }

        .action-primary:hover {
            background: #d8b56e;

            border-color: #d8b56e;

            box-shadow:
                0 16px 35px
                rgba(0,0,0,.35);
        }


        /* =====================================================
           SECONDARY BUTTON
        ===================================================== */

        .action-secondary {
            background:
                rgba(17,19,21,.18);

            border:
                1px solid
                rgba(243,240,233,.30);

            color: #f0ece4;

            backdrop-filter:
                blur(6px);
        }

        .action-secondary:hover {
            border-color: #c9a45c;

            color: #c9a45c;

            background:
                rgba(17,19,21,.32);
        }


        /* =====================================================
           SECURITY
        ===================================================== */

        .security {
            display: flex;

            align-items: center;

            gap: 10px;

            margin-top: 24px;

            color:
                rgba(243,240,233,.48);

            font-size: 9px;

            letter-spacing: .15em;

            text-transform: uppercase;

            animation:
                contentReveal
                .9s
                .75s
                ease
                both;
        }

        .security-dot {
            width: 6px;
            height: 6px;

            border-radius: 50%;

            background: #c9a45c;

            box-shadow:
                0 0 12px
                rgba(201,164,92,.55);

            flex-shrink: 0;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .brand-footer {
            display: flex;

            align-items: center;

            color:
                rgba(243,240,233,.40);

            font-size: 9px;

            letter-spacing: .16em;

            text-transform: uppercase;

            animation:
                contentReveal
                .9s
                .85s
                ease
                both;
        }

        .footer-line {
            width: 55px;
            height: 1px;

            margin: 0 18px;

            background:
                rgba(243,240,233,.20);
        }


        /* =====================================================
           RIGHT VISUAL
        ===================================================== */

        .visual-section {
            position: relative;

            width: 50%;
            height: 100%;

            display: flex;

            align-items: center;
            justify-content: center;

            pointer-events: none;
        }


        /* =====================================================
           JUSTICE OBJECT
        ===================================================== */

        .justice-object {
            position: relative;

            z-index: 4;

            width:
                min(
                    820px,
                    108%
                );

            height: auto;

            max-height: 94vh;

            object-fit: contain;

            opacity: .99;

            filter:
                drop-shadow(
                    0 45px 55px
                    rgba(0,0,0,.68)
                )

                drop-shadow(
                    0 0 35px
                    rgba(201,164,92,.13)
                );

            animation:
                objectReveal
                1.2s
                .15s
                cubic-bezier(.2,.8,.2,1)
                both;
        }


        /* =====================================================
           OBJECT FRAME
        ===================================================== */

        .object-frame {
            position: absolute;

            width:
                min(
                    720px,
                    95%
                );

            height:
                min(
                    720px,
                    88%
                );

            border:
                1px solid
                rgba(201,164,92,.15);

            transform:
                rotate(3deg);

            z-index: 1;

            opacity: .7;

            animation:
                frameReveal
                1.2s
                .35s
                ease
                both;
        }

        .object-frame::before {
            content: '';

            position: absolute;

            inset: 17px;

            border:
                1px solid
                rgba(243,240,233,.08);
        }


        /* =====================================================
           VISUAL CORNER
        ===================================================== */

        .visual-corner {
            position: absolute;

            top: 5px;
            right: 20px;

            color:
                rgba(243,240,233,.30);

            font-family:
                'Cormorant Garamond',
                serif;

            font-size: 18px;
        }


        /* =====================================================
           VISUAL LABEL
        ===================================================== */

        .visual-label {
            position: absolute;

            right: 0;
            bottom: 8px;

            display: flex;

            align-items: center;

            gap: 13px;

            color:
                rgba(243,240,233,.50);

            font-size: 9px;

            letter-spacing: .23em;

            text-transform: uppercase;
        }

        .visual-label::before {
            content: '';

            width: 35px;
            height: 1px;

            background: #c9a45c;
        }


        /* =====================================================
           ANIMATIONS
        ===================================================== */

        @keyframes contentReveal {

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

        @keyframes titleReveal {

            from {
                opacity: 0;

                transform:
                    translateX(-35px)
                    translateY(12px);
            }

            to {
                opacity: 1;

                transform:
                    translateX(0)
                    translateY(0);
            }

        }

        @keyframes dividerReveal {

            from {
                opacity: 0;

                transform:
                    scaleX(0);

                transform-origin:
                    left;
            }

            to {
                opacity: 1;

                transform:
                    scaleX(1);

                transform-origin:
                    left;
            }

        }

        @keyframes objectReveal {

            from {
                opacity: 0;

                transform:
                    translateX(70px)
                    scale(.88);
            }

            to {
                opacity: .99;

                transform:
                    translateX(0)
                    scale(1);
            }

        }

        @keyframes frameReveal {

            from {
                opacity: 0;

                transform:
                    rotate(3deg)
                    scale(.90);
            }

            to {
                opacity: .7;

                transform:
                    rotate(3deg)
                    scale(1);
            }

        }


        /* =====================================================
           TABLET
        ===================================================== */

        @media (max-width: 1100px) {

            .page-content {
                padding: 38px 4vw;
            }

            .top-navigation {
                right: 4vw;
            }

            .brand-section {
                width: 52%;
            }

            .visual-section {
                width: 48%;
            }

            .main-title {
                font-size:
                    clamp(
                        70px,
                        8vw,
                        96px
                    );
            }

            .description {
                font-size: 13px;
            }

            .justice-object {
                width: 110%;
                max-height: 82vh;
            }

        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 760px) {

            html,
            body {
                overflow: hidden;
            }

            .welcome-page {
                min-height: 100dvh;
                height: 100dvh;
            }

            .background-image {
                filter:
                    brightness(.30)
                    saturate(.45)
                    contrast(1.05);
            }

            .page-content {
                padding: 28px 24px;
                display: block;
            }

            .top-navigation {
                top: 27px;
                right: 24px;
            }

            .top-signin {
                font-size: 9px;
                letter-spacing: .16em;
            }

            .brand-section {
                width: 100%;
                max-width: none;
                height: 100%;

                position: relative;
                z-index: 5;
            }

            .visual-section {
                position: absolute;

                inset: 0;

                width: 100%;
                height: 100%;

                z-index: 0;

                opacity: .32;
            }

            .justice-object {
                width: 105%;
                max-height: 72vh;
            }

            .object-frame,
            .visual-label,
            .visual-corner {
                display: none;
            }

            .brand-icon {
                width: 40px;
                height: 40px;
                min-width: 40px;
            }

            .brand-icon svg {
                width: 26px;
                height: 26px;
            }

            .brand-name {
                font-size: 13px;
            }

            .main-title {
                font-size:
                    clamp(
                        68px,
                        18vw,
                        90px
                    );
            }

            .description {
                font-size: 12px;
                max-width: 420px;
            }

            .actions {
                width: 100%;
            }

            .action {
                flex: 1;
                min-width: 145px;
                padding: 0 20px;
            }

        }


        /* =====================================================
           SMALL MOBILE
        ===================================================== */

        @media (max-width: 500px) {

            .page-content {
                padding: 24px 20px;
            }

            .top-navigation {
                top: 24px;
                right: 20px;
            }

            .top-signin {
                font-size: 8px;
                letter-spacing: .14em;
            }

            .brand {
                gap: 11px;
            }

            .brand-icon {
                width: 37px;
                height: 37px;
                min-width: 37px;
            }

            .brand-icon svg {
                width: 24px;
                height: 24px;
            }

            .brand-name {
                font-size: 11px;
                letter-spacing: .24em;
            }

            .content {
                padding: 20px 0 35px;
            }

            .kicker {
                gap: 10px;
                margin-bottom: 20px;
                font-size: 8px;
                letter-spacing: .19em;
            }

            .kicker::before {
                width: 30px;
            }

            .main-title {
                font-size:
                    clamp(
                        58px,
                        18vw,
                        76px
                    );
            }

            .description {
                margin-top: 24px;
                font-size: 11px;
                line-height: 1.75;
            }

            .divider {
                margin: 24px 0;
            }

            .actions {
                gap: 9px;
            }

            .action {
                height: 50px;
                min-width: 0;
                padding: 0 15px;
                font-size: 8px;
                letter-spacing: .13em;
            }

            .security {
                margin-top: 17px;
                font-size: 7px;
                letter-spacing: .10em;
            }

            .justice-object {
                width: 120%;
                max-height: 65vh;
            }

            .brand-footer {
                font-size: 7px;
                letter-spacing: .11em;
            }

            .footer-line {
                width: 30px;
                margin: 0 10px;
            }

        }


        /* =====================================================
           VERY SMALL PHONES
        ===================================================== */

        @media (max-width: 380px) {

            .page-content {
                padding: 20px 17px;
            }

            .top-navigation {
                top: 20px;
                right: 17px;
            }

            .top-signin {
                font-size: 7px;
                letter-spacing: .12em;
            }

            .brand-icon {
                width: 34px;
                height: 34px;
                min-width: 34px;
            }

            .brand-icon svg {
                width: 22px;
                height: 22px;
            }

            .brand-name {
                font-size: 10px;
                letter-spacing: .20em;
            }

            .content {
                padding: 15px 0 25px;
            }

            .kicker {
                margin-bottom: 16px;
                font-size: 7px;
            }

            .main-title {
                font-size: 52px;
            }

            .description {
                margin-top: 20px;
                font-size: 10px;
            }

            .divider {
                margin: 20px 0;
            }

            .action {
                height: 46px;
                padding: 0 11px;
                font-size: 7px;
            }

            .security {
                margin-top: 13px;
                font-size: 6px;
            }

            .justice-object {
                width: 125%;
                max-height: 60vh;
            }

            .brand-footer {
                font-size: 6px;
            }

        }


        /* =====================================================
           SHORT DESKTOP SCREENS
        ===================================================== */

        @media (max-height: 720px) and (min-width: 761px) {

            .page-content {
                padding-top: 28px;
                padding-bottom: 28px;
            }

            .top-navigation {
                top: 28px;
            }

            .main-title {
                font-size:
                    clamp(
                        68px,
                        6.5vw,
                        90px
                    );
            }

            .description {
                margin-top: 22px;
                font-size: 13px;
            }

            .divider {
                margin: 23px 0;
            }

            .action {
                height: 48px;
            }

            .security {
                margin-top: 15px;
            }

            .justice-object {
                max-height: 82vh;
                width: 105%;
            }

        }


        /* =====================================================
           TABLET PORTRAIT
        ===================================================== */

        @media
        (min-width: 761px)
        and
        (max-width: 900px)
        and
        (orientation: portrait) {

            .page-content {
                padding: 30px 35px;
            }

            .brand-section {
                width: 56%;
            }

            .visual-section {
                width: 44%;
            }

            .main-title {
                font-size:
                    clamp(
                        62px,
                        9vw,
                        82px
                    );
            }

            .description {
                max-width: 420px;
                font-size: 12px;
            }

            .action {
                padding: 0 25px;
            }

            .justice-object {
                width: 125%;
                max-height: 75vh;
            }

        }


        /* =====================================================
           LANDSCAPE PHONES
        ===================================================== */

        @media
        (max-width: 760px)
        and
        (orientation: landscape)
        and
        (max-height: 550px) {

            .page-content {
                padding: 18px 25px;
            }

            .top-navigation {
                top: 18px;
                right: 25px;
            }

            .brand-icon {
                width: 34px;
                height: 34px;
                min-width: 34px;
            }

            .brand-icon svg {
                width: 22px;
                height: 22px;
            }

            .brand-name {
                font-size: 10px;
            }

            .content {
                padding: 10px 0 15px;
            }

            .kicker {
                margin-bottom: 12px;
                font-size: 7px;
            }

            .main-title {
                font-size: 48px;
                line-height: .78;
            }

            .description {
                max-width: 390px;
                margin-top: 14px;
                font-size: 9px;
                line-height: 1.55;
            }

            .divider {
                margin: 14px 0;
            }

            .actions {
                gap: 8px;
            }

            .action {
                height: 40px;
                min-width: 120px;
                padding: 0 16px;
                font-size: 7px;
            }

            .security {
                margin-top: 10px;
                font-size: 6px;
            }

            .brand-footer {
                font-size: 6px;
            }

            .visual-section {
                opacity: .27;
            }

            .justice-object {
                width: 90%;
                max-height: 75vh;
            }

        }

    </style>

</head>


<body>

<div
    class="welcome-page"
    id="welcomePage"
>

    {{-- =====================================================
         FULL BALANZA BACKGROUND
    ====================================================== --}}

    <img
        src="{{ asset('storage/backgrounds/balanza.jpeg') }}"
        alt=""
        class="background-image"
    >


    {{-- Background Overlay --}}

    <div class="background-overlay"></div>


    {{-- Gold Glow --}}

    <div class="gold-glow"></div>


    {{-- =====================================================
         TOP RIGHT SIGN IN
    ====================================================== --}}

    <nav class="top-navigation">

        <a
            href="{{ route('login') }}"
            class="top-signin"
        >

            <span>
                Sign In
            </span>

            <span class="top-arrow">
                →
            </span>

        </a>

    </nav>


    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

    <div class="page-content">


        {{-- =================================================
             LEFT SIDE
        ================================================== --}}

        <section class="brand-section">


            {{-- =================================================
                 BRAND
            ================================================== --}}

            <header class="brand-header">

                <a
                    href="{{ route('welcome') }}"
                    class="brand"
                >

                    {{-- Brand Icon --}}

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


                    {{-- Brand Name --}}

                    <div class="brand-name">
                        LAWFIRM
                    </div>

                </a>

            </header>


            {{-- =================================================
                 MAIN CONTENT
            ================================================== --}}

            <main class="content">


                {{-- Kicker --}}

                <div class="kicker">
                    Private Legal Platform
                </div>


                {{-- Main Title --}}

                <h1 class="main-title">

                    Law

                    <span>
                        with purpose.
                    </span>

                </h1>


                {{-- Description --}}

                <p class="description">

                    A private digital environment designed to bring
                    legal services, case management, documents,
                    appointments, and communication together.

                </p>


                {{-- Divider --}}

                <div class="divider"></div>


                {{-- =================================================
                     BUTTONS
                ================================================== --}}

                <div class="actions">


                    {{-- Create Account --}}

                    <a
                        href="{{ route('register') }}"
                        class="action action-primary"
                    >

                        Create Account

                    </a>


                    {{-- Sign In --}}

                    <a
                        href="{{ route('login') }}"
                        class="action action-secondary"
                    >

                        Sign In

                    </a>


                </div>


                {{-- Security --}}

                <div class="security">

                    <span class="security-dot"></span>

                    Secure · Private · Confidential

                </div>


            </main>


            {{-- =================================================
                 FOOTER
            ================================================== --}}

            <footer class="brand-footer">

                <span>
                    Established 2026
                </span>

                <span class="footer-line"></span>

                <span>
                    Legal Platform
                </span>

            </footer>


        </section>


        {{-- =====================================================
             RIGHT — JUSTICE OBJECT
        ====================================================== --}}

        <section class="visual-section">


            {{-- Decorative Frame --}}

            <div class="object-frame"></div>


            {{-- Justice Object --}}

            <img
                src="{{ asset('storage/objects/object.png') }}"
                alt="Justice Object"
                class="justice-object"
            >



            {{-- Object Label --}}

            <div class="visual-label">
                Law · Justice · Integrity
            </div>


        </section>


    </div>

</div>

</body>

</html>
