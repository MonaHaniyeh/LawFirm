<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Law Firm')
    </title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Laravel Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        :root {
            --ink: #151515;
            --ink-soft: #1d1d1d;

            --ivory: #f7f4ed;
            --paper: #ffffff;

            --muted: #7d7b76;

            --line: #e7e3db;

            --gold: #b69a68;
            --gold-dark: #927849;

            --success: #3f7458;
            --success-bg: #edf5ef;

            --danger: #9b4c48;
            --danger-bg: #faeeee;

            --sidebar-width: 290px;
        }


        * {
            box-sizing: border-box;
        }


        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }


        body {
            background: var(--ivory);
            color: var(--ink);

            font-family: 'DM Sans', sans-serif;

            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }


        /* =====================================================
           PAGE
        ====================================================== */

        .page {
            min-height: 100vh;
            display: flex;
        }


        /* =====================================================
           SIDEBAR
        ====================================================== */

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;

            width: var(--sidebar-width);
            min-width: var(--sidebar-width);

            background: var(--ink);
            color: white;

            padding: 30px 20px;

            display: flex;
            flex-direction: column;

            z-index: 100;

            overflow-y: auto;

            transition: transform .25s ease;

            scrollbar-width: thin;
            scrollbar-color: #333 transparent;
        }


        .sidebar::-webkit-scrollbar {
            width: 5px;
        }


        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }


        .sidebar::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 999px;
        }


        /* =====================================================
           BRAND
        ====================================================== */

        .brand {
            padding: 0 13px 32px;

            border-bottom:
                1px solid rgba(255, 255, 255, .10);
        }


        .brand-title {
            font-family:
                'Cormorant Garamond',
                serif;

            font-size: 27px;
            font-weight: 600;

            letter-spacing: .03em;

            line-height: 1;
        }


        .brand-subtitle {
            margin-top: 6px;

            font-size: 10px;
            font-weight: 500;

            text-transform: uppercase;
            letter-spacing: .20em;

            color: #aaa59b;
        }


        /* =====================================================
           NAVIGATION
        ====================================================== */

        .sidebar-nav {
            flex: 1;
        }


        .nav-section {
            margin-top: 30px;
        }


        .nav-label {
            padding: 0 13px;

            margin-bottom: 10px;

            color: #77736b;

            font-size: 10px;
            font-weight: 600;

            text-transform: uppercase;
            letter-spacing: .18em;
        }


        /*
         * Elegant rounded navigation buttons
         */

        .nav-link {
            position: relative;

            display: flex;
            align-items: center;

            gap: 12px;

            padding: 11px 15px;

            margin-bottom: 4px;

            color: #aaa69e;

            text-decoration: none;

            font-family: 'DM Sans', sans-serif;

            font-size: 13px;
            font-weight: 500;

            letter-spacing: .01em;

            border-radius: 999px;

            transition:
                background .2s ease,
                color .2s ease,
                transform .2s ease;

            white-space: nowrap;
        }


        .nav-link:hover {
            color: #ffffff;

            background:
                rgba(255, 255, 255, .06);

            transform:
                translateX(2px);
        }


        .nav-link.active {
            color: #ffffff;

            background:
                rgba(255, 255, 255, .09);
        }


        /*
         * Gold active indicator
         */

        .nav-link.active::before {
            content: "";

            position: absolute;

            left: 6px;

            top: 10px;
            bottom: 10px;

            width: 2px;

            background: var(--gold);

            border-radius: 999px;
        }


        .nav-icon {
            width: 17px;
            height: 17px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            color: currentColor;

            flex-shrink: 0;
        }


        .nav-icon svg {
            display: block;
        }


        /* =====================================================
           SIDEBAR BOTTOM
        ====================================================== */

        .sidebar-bottom {
            margin-top: auto;

            padding: 18px 13px 0;

            border-top:
                1px solid rgba(255, 255, 255, .10);
        }


        /* =====================================================
           PROFILE
        ====================================================== */

        .profile-mini {
            display: flex;

            align-items: center;

            gap: 11px;

            margin-bottom: 15px;
        }


        .avatar {
            width: 36px;
            height: 36px;

            flex-shrink: 0;

            border-radius: 50%;

            background: #302f2c;

            border:
                1px solid rgba(255, 255, 255, .12);

            display: flex;

            align-items: center;
            justify-content: center;

            color: #ddd7cb;

            font-size: 13px;
            font-weight: 600;
        }


        .profile-details {
            min-width: 0;
        }


        .profile-name {
            color: #eeeae2;

            font-size: 12px;
            font-weight: 500;

            white-space: nowrap;

            overflow: hidden;
            text-overflow: ellipsis;
        }


        .profile-role {
            margin-top: 3px;

            color: #77736b;

            font-size: 10px;
            font-weight: 500;

            text-transform: uppercase;
            letter-spacing: .12em;
        }


        /* =====================================================
           LOGOUT
        ====================================================== */

        .logout-form {
            width: 100%;
        }


        /*
         * Elegant rounded logout button
         */

        .logout-button {
            width: 100%;

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 11px 15px;

            border: 0;

            border-radius: 999px;

            background: transparent;

            color: #aaa69e;

            font-family: 'DM Sans', sans-serif;

            font-size: 13px;
            font-weight: 500;

            letter-spacing: .01em;

            cursor: pointer;

            text-align: left;

            transition:
                background .2s ease,
                color .2s ease,
                transform .2s ease;

            white-space: nowrap;
        }


        .logout-button:hover {
            color: #ffffff;

            background:
                rgba(255, 255, 255, .06);

            transform:
                translateX(2px);
        }


        .logout-icon {
            width: 17px;
            height: 17px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            flex-shrink: 0;
        }


        /* =====================================================
           MAIN
        ====================================================== */

        .main {
            width:
                calc(100% - var(--sidebar-width));

            margin-left:
                var(--sidebar-width);

            min-height: 100vh;
        }


        /* =====================================================
           TOPBAR
        ====================================================== */

        .topbar {
            height: 76px;

            padding: 0 48px;

            background:
                rgba(251, 250, 246, .92);

            border-bottom:
                1px solid var(--line);

            display: flex;

            align-items: center;

            justify-content: space-between;

            backdrop-filter: blur(10px);
        }


        .topbar-left {
            display: flex;

            align-items: center;
        }


        .breadcrumb {
            font-size: 12px;

            color: var(--muted);

            font-weight: 400;
        }


        .breadcrumb strong,
        .breadcrumb span {
            color: var(--ink);

            font-weight: 500;
        }


        .top-role {
            font-size: 11px;

            text-transform: uppercase;

            letter-spacing: .14em;

            color: var(--muted);

            font-weight: 500;
        }


        /* =====================================================
           CONTENT
        ====================================================== */

        .content {
            width: 100%;

            max-width: 1120px;

            margin: 0 auto;

            padding:
                46px 48px 70px;
        }


        /* =====================================================
           MOBILE MENU BUTTON
        ====================================================== */

        .mobile-toggle {
            display: none;

            width: 38px;
            height: 38px;

            border:
                1px solid var(--line);

            background:
                var(--paper);

            color:
                var(--ink);

            border-radius: 999px;

            cursor: pointer;

            transition:
                background .2s ease,
                border-color .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }


        .mobile-toggle:hover {
            background:
                var(--ivory);

            border-color:
                var(--gold);

            transform:
                translateY(-1px);

            box-shadow:
                0 4px 12px rgba(0, 0, 0, .06);
        }


        .mobile-toggle:active {
            transform:
                translateY(0);
        }


        /* =====================================================
           SIDEBAR OVERLAY
        ====================================================== */

        .sidebar-overlay {
            display: none;
        }


        /* =====================================================
           GLOBAL ELEGANT BUTTON HELPERS
        ====================================================== */

        .btn-primary {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 8px;

            padding: 11px 20px;

            border: 0;

            border-radius: 999px;

            background:
                var(--ink);

            color:
                #ffffff;

            font-family:
                'DM Sans',
                sans-serif;

            font-size: 12px;
            font-weight: 500;

            letter-spacing: .02em;

            text-decoration: none;

            cursor: pointer;

            box-shadow:
                0 2px 5px rgba(0, 0, 0, .08);

            transition:
                background .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }


        .btn-primary:hover {
            background:
                var(--ink-soft);

            transform:
                translateY(-1px);

            box-shadow:
                0 5px 14px rgba(0, 0, 0, .10);
        }


        .btn-gold {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 8px;

            padding: 11px 20px;

            border: 0;

            border-radius: 999px;

            background:
                var(--gold);

            color:
                #ffffff;

            font-family:
                'DM Sans',
                sans-serif;

            font-size: 12px;
            font-weight: 500;

            letter-spacing: .02em;

            text-decoration: none;

            cursor: pointer;

            box-shadow:
                0 2px 5px rgba(0, 0, 0, .06);

            transition:
                background .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }


        .btn-gold:hover {
            background:
                var(--gold-dark);

            transform:
                translateY(-1px);

            box-shadow:
                0 5px 14px rgba(0, 0, 0, .10);
        }


        .btn-secondary {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 8px;

            padding: 10px 18px;

            border:
                1px solid var(--line);

            border-radius: 999px;

            background:
                var(--paper);

            color:
                var(--ink);

            font-family:
                'DM Sans',
                sans-serif;

            font-size: 12px;
            font-weight: 500;

            letter-spacing: .02em;

            text-decoration: none;

            cursor: pointer;

            transition:
                background .2s ease,
                border-color .2s ease,
                transform .2s ease;
        }


        .btn-secondary:hover {
            background:
                var(--ivory);

            border-color:
                var(--gold);

            transform:
                translateY(-1px);
        }


        .btn-danger {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 8px;

            padding: 10px 18px;

            border:
                1px solid #e1c9c5;

            border-radius: 999px;

            background:
                var(--danger-bg);

            color:
                var(--danger);

            font-family:
                'DM Sans',
                sans-serif;

            font-size: 12px;
            font-weight: 500;

            letter-spacing: .02em;

            text-decoration: none;

            cursor: pointer;

            transition:
                background .2s ease,
                transform .2s ease;
        }


        .btn-danger:hover {
            background:
                #f6e7e4;

            transform:
                translateY(-1px);
        }


        /* =====================================================
           FORM BUTTONS
        ====================================================== */

        button,
        input[type="submit"],
        input[type="button"] {
            font-family:
                'DM Sans',
                sans-serif;
        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 900px) {

            .sidebar {
                width:
                    var(--sidebar-width);

                min-width:
                    var(--sidebar-width);

                transform:
                    translateX(-100%);
            }


            .sidebar.open {
                transform:
                    translateX(0);
            }


            .main {
                width: 100%;

                margin-left: 0;
            }


            .topbar {
                padding:
                    0 24px;
            }


            .mobile-toggle {
                display: inline-flex;

                align-items: center;
                justify-content: center;

                margin-right: 12px;
            }


            .sidebar-overlay {
                position: fixed;

                inset: 0;

                background:
                    rgba(0, 0, 0, .35);

                z-index: 90;

                backdrop-filter:
                    blur(2px);
            }


            .sidebar-overlay.open {
                display: block;
            }


            .content {
                max-width: 100%;

                padding:
                    36px 28px 50px;
            }
        }


        @media (max-width: 600px) {

            .topbar {
                padding:
                    0 20px;
            }


            .content {
                padding:
                    32px 20px 50px;
            }


            .sidebar {
                padding:
                    25px 16px;
            }
        }


        @media (max-width: 500px) {

            .top-role {
                display: none;
            }


            .content {
                padding:
                    28px 16px 45px;
            }


            .mobile-toggle {
                width: 36px;
                height: 36px;
            }
        }
    </style>

    @stack('styles')

</head>


<body>

    @include('components.flash-notifications')

    <div class="page">

        {{-- =====================================================
             Shared Sidebar
        ====================================================== --}}

        @include('layouts.sidebar')


        {{-- =====================================================
             Mobile Overlay
        ====================================================== --}}

        <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>


        {{-- =====================================================
             Main Content
        ====================================================== --}}

        <main class="main">

            {{-- =================================================
                 Topbar
            ================================================== --}}

            <header class="topbar">

                <div class="topbar-left">

                    {{-- Mobile Menu Button --}}

                    <button type="button" class="mobile-toggle" onclick="toggleSidebar()" aria-label="Open menu"
                        aria-expanded="false" id="mobileMenuButton">

                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round">
                            <path d="M4 7h16"></path>
                            <path d="M4 12h16"></path>
                            <path d="M4 17h16"></path>
                        </svg>

                    </button>


                    {{-- Breadcrumb --}}

                    <div class="breadcrumb">

                        @yield('breadcrumb', 'Workspace')

                    </div>

                </div>


                {{-- =================================================
                     Dynamic Role
                ================================================== --}}

                @php

                    $currentUser = auth()->user();

                    $currentRole = $currentUser?->role;

                @endphp


                <div class="top-role">

                    {{ $currentRole ? ucfirst($currentRole) . ' Workspace' : 'Workspace' }}

                </div>

            </header>


            {{-- =================================================
                 Page Content
            ================================================== --}}

            <section class="content">

                @yield('content')

            </section>

        </main>

    </div>


    {{-- =========================================================
         Mobile Sidebar Script
    ========================================================== --}}

    <script>
        function toggleSidebar() {

            const sidebar =
                document.getElementById('sidebar');

            const overlay =
                document.getElementById('sidebarOverlay');

            const button =
                document.getElementById('mobileMenuButton');


            if (!sidebar) {
                return;
            }


            const isOpen =
                sidebar.classList.toggle('open');


            if (overlay) {

                overlay.classList.toggle(
                    'open',
                    isOpen
                );

            }


            if (button) {

                button.setAttribute(
                    'aria-expanded',
                    isOpen ? 'true' : 'false'
                );

            }

        }


        function closeSidebar() {

            const sidebar =
                document.getElementById('sidebar');

            const overlay =
                document.getElementById('sidebarOverlay');

            const button =
                document.getElementById('mobileMenuButton');


            if (sidebar) {

                sidebar.classList.remove('open');

            }


            if (overlay) {

                overlay.classList.remove('open');

            }


            if (button) {

                button.setAttribute(
                    'aria-expanded',
                    'false'
                );

            }

        }


        document.addEventListener(
            'DOMContentLoaded',
            function() {

                const sidebar =
                    document.getElementById('sidebar');


                if (!sidebar) {
                    return;
                }


                /*
                 * Close mobile sidebar after navigation
                 */

                sidebar
                    .querySelectorAll('.nav-link')
                    .forEach(function(link) {

                        link.addEventListener(
                            'click',
                            function() {

                                if (
                                    window.innerWidth <= 900
                                ) {

                                    closeSidebar();

                                }

                            }
                        );

                    });


                /*
                 * Close sidebar with Escape
                 */

                document.addEventListener(
                    'keydown',
                    function(event) {

                        if (
                            event.key === 'Escape' &&
                            window.innerWidth <= 900
                        ) {

                            closeSidebar();

                        }

                    }
                );


                /*
                 * Close sidebar when resizing
                 * back to desktop
                 */

                window.addEventListener(
                    'resize',
                    function() {

                        if (
                            window.innerWidth > 900
                        ) {

                            closeSidebar();

                        }

                    }
                );

            }
        );
    </script>


    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    @stack('scripts')

</body>

</html>
