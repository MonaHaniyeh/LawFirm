<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Page Not Found | LawFirm</title> @vite(['resources/css/app.css', 'resources/js/app.js']) <style>
        :root {
            --charcoal: #151515;
            --ivory: #f7f4ed;
            --paper: #ffffff;
            --muted: #7d7b76;
            --line: #e5e1d8;
            --gold: #b69a68;
            --gold-dark: #9d8253;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body {
            background: var(--ivory);
            color: var(--charcoal);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .error-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        /* |-------------------------------------------------------------------------- | BACKGROUND DETAILS |-------------------------------------------------------------------------- */
        .background-line {
            position: absolute;
            pointer-events: none;
            background: var(--line);
            opacity: 0.65;
        }

        .background-line.horizontal {
            width: 100%;
            height: 1px;
            left: 0;
        }

        .background-line.vertical {
            width: 1px;
            height: 100%;
            top: 0;
        }

        .line-one {
            top: 112px;
        }

        .line-two {
            bottom: 92px;
        }

        .line-three {
            left: 8%;
        }

        .line-four {
            right: 8%;
        }

        /* |-------------------------------------------------------------------------- | HEADER |-------------------------------------------------------------------------- */
        .site-header {
            width: 100%;
            position: relative;
            z-index: 2;
            padding: 30px 6vw;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: var(--charcoal);
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            border: 1px solid var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 15px;
            letter-spacing: -1px;
            position: relative;
        }

        .brand-mark::after {
            content: "";
            position: absolute;
            width: 7px;
            height: 7px;
            right: -4px;
            bottom: -4px;
            background: var(--gold);
        }

        .brand-name {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .brand-title {
            font-family: Georgia, "Times New Roman", serif;
            font-size: 20px;
            letter-spacing: 0.03em;
            line-height: 1;
        }

        .brand-subtitle {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.22em;
            color: var(--muted);
        }

        /* |-------------------------------------------------------------------------- | MAIN |-------------------------------------------------------------------------- */
        .error-main {
            flex: 1;
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 70px 6vw 90px;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .error-grid {
            width: 100%;
            display: grid;
            grid-template-columns: minmax(280px, 0.9fr) minmax(320px, 1.1fr);
            gap: clamp(50px, 9vw, 140px);
            align-items: center;
        }

        /* |-------------------------------------------------------------------------- | 404 VISUAL |-------------------------------------------------------------------------- */
        .visual-section {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .number-wrapper {
            width: min(390px, 72vw);
            aspect-ratio: 1 / 1;
            border: 1px solid var(--line);
            border-radius: 50%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .number-wrapper::before {
            content: "";
            position: absolute;
            inset: 20px;
            border: 1px solid var(--line);
            border-radius: 50%;
        }

        .number-wrapper::after {
            content: "";
            position: absolute;
            width: 65%;
            height: 1px;
            background: var(--gold);
            transform: rotate(-45deg);
            opacity: 0.7;
        }

        .number {
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(90px, 14vw, 170px);
            font-weight: 400;
            letter-spacing: -0.09em;
            line-height: 1;
            position: relative;
            z-index: 2;
        }

        .number span {
            color: var(--gold);
        }

        .visual-label {
            position: absolute;
            bottom: 12%;
            right: 3%;
            background: var(--ivory);
            padding: 9px 14px;
            border: 1px solid var(--line);
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--muted);
        }

        /* |-------------------------------------------------------------------------- | CONTENT |-------------------------------------------------------------------------- */
        .content-section {
            max-width: 610px;
        }

        .eyebrow {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            color: var(--gold-dark);
        }

        .eyebrow-line {
            width: 34px;
            height: 1px;
            background: var(--gold);
        }

        .heading {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 400;
            font-size: clamp(42px, 5.2vw, 76px);
            line-height: 0.98;
            letter-spacing: -0.045em;
        }

        .heading em {
            color: var(--gold-dark);
            font-style: italic;
        }

        .description {
            max-width: 500px;
            margin: 30px 0 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.9;
        }

        /* |-------------------------------------------------------------------------- | ACTIONS |-------------------------------------------------------------------------- */
        .actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 36px;
        }

        .button {
            min-height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0 21px;
            text-decoration: none;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
        }

        .button:hover {
            transform: translateY(-1px);
        }

        .primary-button {
            background: var(--charcoal);
            color: var(--paper);
            border: 1px solid var(--charcoal);
        }

        .primary-button:hover {
            background: var(--gold);
            border-color: var(--gold);
            color: var(--charcoal);
        }

        .secondary-button {
            background: transparent;
            color: var(--charcoal);
            border: 1px solid var(--line);
        }

        .secondary-button:hover {
            border-color: var(--gold);
            background: var(--paper);
        }

        .button-icon {
            width: 15px;
            height: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* |-------------------------------------------------------------------------- | FOOTER |-------------------------------------------------------------------------- */
        .site-footer {
            position: relative;
            z-index: 2;
            padding: 24px 6vw;
            border-top: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            color: var(--muted);
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.18em;
        }

        .footer-right {
            color: var(--gold-dark);
        }

        /* |-------------------------------------------------------------------------- | RESPONSIVE |-------------------------------------------------------------------------- */
        @media (max-width: 900px) {
            .error-main {
                padding-top: 50px;
            }

            .error-grid {
                grid-template-columns: 1fr;
                gap: 60px;
            }

            .visual-section {
                justify-content: flex-start;
            }

            .number-wrapper {
                width: min(320px, 65vw);
            }

            .content-section {
                max-width: 700px;
            }
        }

        @media (max-width: 600px) {
            .site-header {
                padding: 24px;
            }

            .error-main {
                padding: 35px 24px 60px;
            }

            .error-grid {
                gap: 45px;
            }

            .number-wrapper {
                width: 250px;
            }

            .number {
                font-size: 105px;
            }

            .visual-label {
                right: -2px;
                bottom: 8%;
            }

            .heading {
                font-size: 46px;
            }

            .description {
                font-size: 13px;
                line-height: 1.8;
            }

            .actions {
                flex-direction: column;
                align-items: stretch;
            }

            .button {
                width: 100%;
            }

            .site-footer {
                padding: 20px 24px;
                flex-direction: column;
                align-items: flex-start;
            }

            .background-line.vertical {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="error-page"> {{-- ========================================================= BACKGROUND GRID ========================================================== --}} <div class="background-line horizontal line-one"></div>
        <div class="background-line horizontal line-two"></div>
        <div class="background-line vertical line-three"></div>
        <div class="background-line vertical line-four"></div> {{-- ========================================================= HEADER ========================================================== --}} <header class="site-header"> <a
                href="{{ url('/') }}" class="brand">
                <div class="brand-mark"> LF </div>
                <div class="brand-name"> <span class="brand-title"> LawFirm </span> <span class="brand-subtitle"> Legal
                        Management System </span> </div>
            </a> </header> {{-- ========================================================= MAIN ERROR CONTENT ========================================================== --}} <main class="error-main">
            <div class="error-grid"> {{-- ================================================= 404 VISUAL ================================================== --}} <div class="visual-section">
                    <div class="number-wrapper">
                        <div class="number"> 4<span>0</span>4 </div>
                    </div>
                    <div class="visual-label"> Page unavailable </div>
                </div> {{-- ================================================= CONTENT ================================================== --}} <div class="content-section">
                    <div class="eyebrow"> <span class="eyebrow-line"></span> Secure Workspace </div>
                    <h1 class="heading"> This page is <br> <em>not found.</em> </h1>
                    <p class="description"> The page you are looking for could not be found. It may have been moved,
                        removed, or is no longer available at this address. </p> {{-- ================================================= ACTIONS ================================================== --}} <div
                        class="actions"> {{-- ================================================= RETURN TO USER DASHBOARD ================================================== --}} @auth @php
                            $dashboardRoute = match (auth()->user()->role) {
                                'admin' => 'admin.dashboard',
                                'lawyer' => 'lawyer.dashboard',
                                'accountant' => 'accountant.dashboard',
                                'client' => 'client.dashboard',
                                default => null,
                            };
                        @endphp @if ($dashboardRoute && Route::has($dashboardRoute))
                            <a href="{{ route($dashboardRoute) }}" class="button primary-button"> <span
                                    class="button-icon"> <svg width="15" height="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1.7">
                                        <path d="M3 10.5L12 3l9 7.5"></path>
                                        <path d="M5.5 9.5V21h13V9.5"></path>
                                        <path d="M9.5 21v-7h5v7"></path>
                                    </svg> </span> Return to Dashboard </a>
                        @else
                            <a href="{{ url('/') }}" class="button primary-button"> <span class="button-icon"> <svg
                                        width="15" height="15" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.7">
                                        <path d="M3 10.5L12 3l9 7.5"></path>
                                        <path d="M5.5 9.5V21h13V9.5"></path>
                                        <path d="M9.5 21v-7h5v7"></path>
                                    </svg> </span> Return Home </a>
                        @endif
                    @else
                        {{-- ================================================= GUEST USER ================================================== --}} <a href="{{ route('login') }}" class="button primary-button"> <span
                                class="button-icon"> <svg width="15" height="15" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.7">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                    <path d="M10 17l5-5-5-5"></path>
                                    <path d="M15 12H3"></path>
                            </svg> </span> Sign In </a> @endauth {{-- ================================================= GO BACK ================================================== --}} <button type="button"
                        onclick="window.history.back()" class="button secondary-button"> <span class="button-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.7">
                                <path d="M19 12H5"></path>
                                <path d="M12 19l-7-7 7-7"></path>
                            </svg> </span> Go Back </button> </div>
            </div>
        </div>
    </main> {{-- ========================================================= FOOTER ========================================================== --}} <footer class="site-footer"> <span> LawFirm · Legal Management System </span>
        <span class="footer-right"> Secure Workspace </span> </footer>
</div>
</body>

</html>
