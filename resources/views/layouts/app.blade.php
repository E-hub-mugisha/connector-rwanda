<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        http-equiv="X-UA-Compatible"
        content="IE=edge"
    >

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no"
    >

    <meta
        name="description"
        content="Connector Administration Portal"
    >

    <meta
        name="author"
        content="Connector"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >


    <title>
        @yield('title', 'Dashboard') | Connector Admin
    </title>


    {{-- =====================================================
         FAVICON
    ====================================================== --}}

    <link
        rel="icon"
        type="image/png"
        sizes="32x32"
        href="{{ asset('asset/images/fav-icon/fav-connector.png') }}"
    >

    <link
        rel="icon"
        type="image/png"
        sizes="16x16"
        href="{{ asset('asset/images/fav-icon/fav-connector.png') }}"
    >

    <link
        rel="shortcut icon"
        href="{{ asset('asset/images/fav-icon/fav-connector.png') }}"
    >


    {{-- =====================================================
         FONTS
    ====================================================== --}}

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
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >


    {{-- =====================================================
         FONT AWESOME
    ====================================================== --}}

    <link
        href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}"
        rel="stylesheet"
    >


    {{-- =====================================================
         SB ADMIN
    ====================================================== --}}

    <link
        href="{{ asset('admin/css/sb-admin-2.min.css') }}"
        rel="stylesheet"
    >


    {{-- =====================================================
         DATATABLES
    ====================================================== --}}

    <link
        href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet"
    >


    {{-- =====================================================
         SUMMERNOTE
    ====================================================== --}}

    <link
        href="{{ asset('admin/vendor/summernote/summernote.min.css') }}"
        rel="stylesheet"
    >


    {{-- =====================================================
         GLOBAL CONNECTOR ADMIN OVERRIDES
    ====================================================== --}}

    <style>

        :root {
            --connector-primary: #6B9080;
            --connector-dark: #254035;
            --connector-soft: #EEF4F1;
            --connector-bg: #F6F8F7;
            --connector-border: #E5ECE8;
            --connector-text: #253A32;
            --connector-muted: #78857F;
        }


        html,
        body {
            font-family: "DM Sans", sans-serif;
        }


        body {
            background: var(--connector-bg);
            color: var(--connector-text);
        }


        #content-wrapper {
            background: var(--connector-bg);
        }


        main {
            min-height: calc(100vh - 150px);
        }


        .sticky-footer {
            border-top: 1px solid var(--connector-border);
            background: #fff !important;
        }


        .sticky-footer .copyright {
            color: #8A9791;
            font-size: 11px;
        }


        /* =====================================================
           CARDS
        ====================================================== */

        .card {
            border: 1px solid var(--connector-border);
            border-radius: 15px;

            box-shadow:
                0 5px 20px rgba(37, 64, 53, .045);
        }


        .card-header {
            border-bottom: 1px solid var(--connector-border);
            background: #fff;
        }


        /* =====================================================
           BUTTONS
        ====================================================== */

        .btn-primary {
            border-color: var(--connector-primary);
            background: var(--connector-primary);
        }


        .btn-primary:hover,
        .btn-primary:focus {
            border-color: var(--connector-dark);
            background: var(--connector-dark);
        }


        /* =====================================================
           LINKS
        ====================================================== */

        a {
            color: var(--connector-primary);
        }


        a:hover {
            color: var(--connector-dark);
        }


        /* =====================================================
           FORMS
        ====================================================== */

        .form-control {
            border-color: var(--connector-border);
            border-radius: 9px;
        }


        .form-control:focus {
            border-color: var(--connector-primary);

            box-shadow:
                0 0 0 3px rgba(107, 144, 128, .10);
        }


        /* =====================================================
           TABLES
        ====================================================== */

        .table thead th {
            border-bottom: 1px solid var(--connector-border);

            color: #728079;

            font-size: 11px;
            font-weight: 700;

            text-transform: uppercase;
            letter-spacing: .4px;
        }


        .table td {
            vertical-align: middle;

            border-color: #EDF1EF;

            font-size: 13px;
        }


        /* =====================================================
           SCROLL TO TOP
        ====================================================== */

        .scroll-to-top {
            background: var(--connector-dark);

            box-shadow:
                0 8px 20px rgba(37, 64, 53, .15);
        }


        .scroll-to-top:hover {
            background: var(--connector-primary);
        }


        /* =====================================================
           SWEET ALERT
        ====================================================== */

        .swal2-popup {
            border-radius: 16px !important;
            font-family: "DM Sans", sans-serif !important;
        }


        /* =====================================================
           MOBILE
        ====================================================== */

        @media (max-width: 767.98px) {

            main {
                min-height: calc(100vh - 120px);
            }

        }

    </style>


    @stack('styles')

</head>


<body id="page-top">


{{-- =========================================================
     PAGE WRAPPER
========================================================= --}}

<div id="wrapper">


    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

    @include('admin.includes.sidebar')


    {{-- =====================================================
         CONTENT WRAPPER
    ====================================================== --}}

    <div id="content-wrapper" class="d-flex flex-column">


        {{-- =================================================
             MAIN CONTENT
        ================================================== --}}

        <div id="content">


            {{-- Navbar --}}

            @include('admin.includes.navbar')


            {{-- Page content --}}

            <main>

                @yield('content')

            </main>


            {{-- SweetAlert --}}

            @include('sweetalert::alert')


        </div>


        {{-- =================================================
             FOOTER
        ================================================== --}}

        <footer class="sticky-footer">

            <div class="container my-auto">

                <div class="copyright text-center my-auto">

                    <span>
                        © {{ date('Y') }}
                        <strong>Connector</strong>.
                        All rights reserved.
                    </span>

                </div>

            </div>

        </footer>


    </div>

</div>


{{-- =========================================================
     SCROLL TO TOP
========================================================= --}}

<a
    class="scroll-to-top rounded"
    href="#page-top"
    aria-label="Back to top"
>

    <i class="fas fa-angle-up"></i>

</a>


{{-- =========================================================
     JQUERY
========================================================= --}}

<script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>


{{-- =========================================================
     BOOTSTRAP
========================================================= --}}

<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


{{-- =========================================================
     JQUERY EASING
========================================================= --}}

<script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>


{{-- =========================================================
     SB ADMIN
========================================================= --}}

<script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>


{{-- =========================================================
     DATATABLES
========================================================= --}}

<script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>


{{-- =========================================================
     DATATABLE DEMO
========================================================= --}}

<script src="{{ asset('admin/js/demo/datatables-demo.js') }}"></script>


{{-- =========================================================
     SUMMERNOTE
========================================================= --}}

<script src="{{ asset('admin/vendor/summernote/summernote.min.js') }}"></script>


{{-- =========================================================
     TINYMCE
========================================================= --}}

<script src="{{ asset('admin/vendor/tinymce/tinymce.min.js') }}"></script>


<script>

    document.addEventListener('DOMContentLoaded', function () {


        /* =====================================================
           TINYMCE
        ====================================================== */

        if (typeof tinymce !== 'undefined') {

            tinymce.init({
                selector: 'textarea#content',

                plugins: 'code table lists',

                toolbar:
                    'undo redo | blocks | bold italic | ' +
                    'alignleft aligncenter alignright | ' +
                    'indent outdent | bullist numlist | ' +
                    'code | table'
            });

        }


        /* =====================================================
           SUMMERNOTE
        ====================================================== */

        if (
            typeof jQuery !== 'undefined' &&
            typeof jQuery.fn.summernote !== 'undefined'
        ) {

            jQuery('#summernote').summernote();

        }


        /* =====================================================
           SEARCH SHORTCUT
           "/" focuses desktop search
        ====================================================== */

        document.addEventListener('keydown', function (event) {

            const target = event.target;

            const isTyping =
                target.tagName === 'INPUT' ||
                target.tagName === 'TEXTAREA' ||
                target.isContentEditable;

            if (
                event.key === '/' &&
                !isTyping
            ) {

                event.preventDefault();

                const searchInput =
                    document.querySelector(
                        '.connector-admin-search input'
                    );

                if (searchInput) {
                    searchInput.focus();
                }

            }

        });

    });

</script>


{{-- =========================================================
     GOOGLE ANALYTICS
========================================================= --}}

<script
    async
    src="https://www.googletagmanager.com/gtag/js?id=G-HWQ435LMGE"
></script>

<script>

    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag(
        'config',
        'G-HWQ435LMGE'
    );

</script>


{{-- =========================================================
     GOOGLE API
========================================================= --}}

<script
    async
    defer
    src="https://apis.google.com/js/api.js"
></script>


@stack('scripts')

</body>

</html>