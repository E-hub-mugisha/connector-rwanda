<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
        content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Connector')
    </title>

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">

    {{-- Google Font --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #6B9080;
            --primary-dark: #254035;
            --primary-light: #E8F0ED;
            --body-bg: #F6F8F7;
            --sidebar-width: 260px;
            --header-height: 72px;
            --border-color: #E5EAE7;
            --text-dark: #17221E;
            --text-muted: #7A8580;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--body-bg);
            color: var(--text-dark);
        }

        a {
            text-decoration: none;
        }

        /* =========================
           APP WRAPPER
        ========================= */

        .app-wrapper {
            min-height: 100vh;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .app-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: #ffffff;
            border-right: 1px solid var(--border-color);
            z-index: 1050;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--primary-dark);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            font-weight: 700;
            margin-right: 11px;
        }

        .brand-name {
            font-size: 19px;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 0;
        }

        .brand-subtitle {
            font-size: 10px;
            color: var(--text-muted);
            margin: 2px 0 0;
        }

        .sidebar-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px 14px;
        }

        .sidebar-section {
            margin-bottom: 24px;
        }

        .sidebar-title {
            padding: 0 12px;
            margin-bottom: 8px;
            color: #9AA39F;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 13px;
            margin-bottom: 3px;
            color: #59655F;
            font-size: 13px;
            font-weight: 500;
            border-radius: 10px;
            transition: all .2s ease;
        }

        .sidebar-link i {
            width: 20px;
            font-size: 17px;
            text-align: center;
        }

        .sidebar-link:hover {
            color: var(--primary-dark);
            background: var(--primary-light);
        }

        .sidebar-link.active {
            background: var(--primary-dark);
            color: #fff;
        }

        .sidebar-link.active i {
            color: #fff;
        }

        .sidebar-user {
            padding: 14px;
            border-top: 1px solid var(--border-color);
        }

        .sidebar-user-box {
            background: var(--body-bg);
            padding: 11px;
            border-radius: 12px;
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 10px;
        }

        .user-name {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .user-role {
            font-size: 10px;
            color: var(--text-muted);
        }

        /* =========================
           MAIN
        ========================= */

        .app-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* =========================
           HEADER
        ========================= */

        .app-header {
            height: var(--header-height);
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .sidebar-toggle {
            width: 40px;
            height: 40px;
            border: 1px solid var(--border-color);
            background: #fff;
            border-radius: 10px;
            display: none;
            align-items: center;
            justify-content: center;
            color: var(--text-dark);
        }

        .page-heading h5 {
            margin: 0;
            font-size: 17px;
            font-weight: 700;
        }

        .page-heading small {
            color: var(--text-muted);
            font-size: 11px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #56625C;
            background: #fff;
        }

        .header-icon:hover {
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        .header-profile {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-left: 6px;
            padding-left: 12px;
            border-left: 1px solid var(--border-color);
        }

        .header-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--primary-dark);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
        }

        .header-user-name {
            font-size: 12px;
            font-weight: 600;
        }

        .header-user-role {
            color: var(--text-muted);
            font-size: 10px;
        }

        /* =========================
           CONTENT
        ========================= */

        .app-content {
            flex: 1;
            padding: 28px;
        }

        /* =========================
           FOOTER
        ========================= */

        .app-footer {
            padding: 18px 28px;
            background: #fff;
            border-top: 1px solid var(--border-color);
            font-size: 11px;
            color: var(--text-muted);
        }

        .footer-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* =========================
           MOBILE OVERLAY
        ========================= */

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .35);
            z-index: 1040;
            display: none;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 991.98px) {

            .app-sidebar {
                transform: translateX(-100%);
            }

            .app-sidebar.show {
                transform: translateX(0);
            }

            .app-main {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: flex;
            }

            .sidebar-overlay.show {
                display: block;
            }

            .header-user-info {
                display: none;
            }

            .app-content {
                padding: 20px;
            }
        }

        @media (max-width: 575.98px) {

            .app-header {
                padding: 0 15px;
            }

            .app-content {
                padding: 15px;
            }

            .header-icon.notification {
                display: none;
            }

            .app-footer {
                padding: 15px;
            }

            .footer-content {
                flex-direction: column;
                gap: 5px;
                text-align: center;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="app-wrapper">

        {{-- Sidebar --}}
        @include('layouts.partials.sidebar')

        {{-- Mobile overlay --}}
        <div
            class="sidebar-overlay"
            id="sidebarOverlay">
        </div>

        <div class="app-main">

            {{-- Header --}}
            @include('layouts.partials.header')

            {{-- Main content --}}
            <main class="app-content">

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>
                </div>
                @endif

                @yield('content')

            </main>

            {{-- Footer --}}
            @include('layouts.partials.footer')

        </div>

    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    <script>
        const sidebar = document.getElementById('appSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('sidebarToggle');

        if (toggle) {
            toggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }
    </script>

    @stack('scripts')

</body>

</html>