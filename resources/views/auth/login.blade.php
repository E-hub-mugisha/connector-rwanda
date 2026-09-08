<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Connector</title>

    <meta name="description"
          content="Sign in to your Connector account and connect with trusted service professionals.">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
          rel="stylesheet">

    <style>
        :root {
            --connector-primary: #6B9080;
            --connector-primary-dark: #254035;
            --connector-primary-deep: #1B3027;
            --connector-primary-soft: #EEF4F1;
            --connector-primary-light: #F6FAF8;

            --connector-text: #183028;
            --connector-muted: #6F7D76;
            --connector-border: #DFE8E3;

            --connector-white: #FFFFFF;
            --connector-danger: #C84E4E;

            --connector-shadow:
                0 25px 70px rgba(37, 64, 53, 0.12);

            --connector-radius: 18px;
        }

        * {
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
            font-family: "DM Sans", sans-serif;
            background: #F5F8F6;
            color: var(--connector-text);
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
        }

        button,
        input {
            font-family: inherit;
        }

        /* =========================================================
           PAGE
        ========================================================= */

        .connector-auth-page {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 35px 20px;

            position: relative;
            overflow: hidden;

            background:
                radial-gradient(
                    circle at 8% 10%,
                    rgba(107, 144, 128, 0.12),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 92% 90%,
                    rgba(107, 144, 128, 0.10),
                    transparent 30%
                ),
                #F6F9F7;
        }


        /* =========================================================
           BACKGROUND DETAILS
        ========================================================= */

        .connector-bg-shape {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .connector-bg-shape-one {
            width: 420px;
            height: 420px;

            top: -250px;
            right: -170px;

            border: 1px solid rgba(107, 144, 128, 0.12);
        }

        .connector-bg-shape-two {
            width: 300px;
            height: 300px;

            bottom: -200px;
            left: -120px;

            border: 1px solid rgba(107, 144, 128, 0.10);
        }


        /* =========================================================
           AUTH CONTAINER
        ========================================================= */

        .connector-auth-container {
            width: 100%;
            max-width: 1050px;

            position: relative;
            z-index: 2;
        }

        .connector-auth-card {
            display: grid;

            grid-template-columns: 44% 56%;

            min-height: 650px;

            background: var(--connector-white);

            border-radius: var(--connector-radius);

            overflow: hidden;

            box-shadow: var(--connector-shadow);

            border: 1px solid rgba(37, 64, 53, 0.05);
        }


        /* =========================================================
           LEFT BRAND PANEL
        ========================================================= */

        .connector-brand-panel {
            position: relative;

            padding: 46px 44px;

            display: flex;
            flex-direction: column;

            overflow: hidden;

            color: #fff;

            background:
                linear-gradient(
                    145deg,
                    #20392F 0%,
                    #315747 55%,
                    #6B9080 100%
                );
        }

        .connector-brand-panel::before {
            content: "";

            position: absolute;

            width: 380px;
            height: 380px;

            right: -220px;
            top: -160px;

            border-radius: 50%;

            border: 1px solid rgba(255, 255, 255, 0.11);
        }

        .connector-brand-panel::after {
            content: "";

            position: absolute;

            width: 300px;
            height: 300px;

            left: -190px;
            bottom: -180px;

            border-radius: 50%;

            border: 1px solid rgba(255, 255, 255, 0.08);
        }


        /* =========================================================
           BRAND
        ========================================================= */

        .connector-brand {
            position: relative;
            z-index: 3;

            display: flex;
            align-items: center;
            gap: 11px;
        }

        .connector-brand-icon {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            color: #fff;

            background: rgba(255, 255, 255, 0.13);

            border: 1px solid rgba(255, 255, 255, 0.16);

            font-size: 17px;
        }

        .connector-brand-name {
            font-size: 20px;
            font-weight: 700;

            letter-spacing: -0.5px;
        }


        /* =========================================================
           BRAND CONTENT
        ========================================================= */

        .connector-brand-content {
            position: relative;
            z-index: 3;

            margin-top: auto;
            margin-bottom: auto;

            padding: 60px 0 50px;
        }

        .connector-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 18px;

            color: rgba(255, 255, 255, 0.62);

            font-size: 10px;
            font-weight: 700;

            letter-spacing: 1.8px;
        }

        .connector-eyebrow::before {
            content: "";

            width: 22px;
            height: 1px;

            background: rgba(255, 255, 255, 0.45);
        }

        .connector-brand-content h1 {
            max-width: 360px;

            margin: 0 0 20px;

            font-family: "Playfair Display", serif;

            font-size: 41px;
            line-height: 1.08;

            font-weight: 700;

            letter-spacing: -1.2px;
        }

        .connector-brand-content h1 span {
            color: #D9EAE2;
        }

        .connector-brand-content p {
            max-width: 330px;

            margin: 0;

            color: rgba(255, 255, 255, 0.70);

            font-size: 14px;
            line-height: 1.75;
        }


        /* =========================================================
           FEATURES
        ========================================================= */

        .connector-brand-features {
            position: relative;
            z-index: 3;

            display: flex;
            flex-direction: column;

            gap: 14px;
        }

        .connector-feature {
            display: flex;
            align-items: center;

            gap: 12px;
        }

        .connector-feature-icon {
            flex: 0 0 36px;

            width: 36px;
            height: 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            color: #fff;

            background: rgba(255, 255, 255, 0.10);

            border: 1px solid rgba(255, 255, 255, 0.08);

            font-size: 14px;
        }

        .connector-feature-text strong {
            display: block;

            margin-bottom: 2px;

            color: #fff;

            font-size: 12px;
            font-weight: 600;
        }

        .connector-feature-text span {
            display: block;

            color: rgba(255, 255, 255, 0.52);

            font-size: 10px;
        }


        /* =========================================================
           FORM PANEL
        ========================================================= */

        .connector-form-panel {
            position: relative;

            display: flex;
            align-items: center;

            padding: 55px 70px;

            background: #fff;
        }

        .connector-form-container {
            width: 100%;
            max-width: 410px;

            margin: 0 auto;
        }


        /* =========================================================
           MOBILE LOGO
        ========================================================= */

        .connector-mobile-brand {
            display: none;
        }


        /* =========================================================
           HEADER
        ========================================================= */

        .connector-form-header {
            margin-bottom: 31px;
        }

        .connector-form-header h2 {
            margin: 0 0 9px;

            color: var(--connector-text);

            font-size: 30px;
            line-height: 1.2;

            font-weight: 700;

            letter-spacing: -0.9px;
        }

        .connector-form-header p {
            margin: 0;

            color: var(--connector-muted);

            font-size: 13px;
            line-height: 1.6;
        }

        .connector-form-header p a {
            color: var(--connector-primary-dark);

            font-weight: 700;
        }

        .connector-form-header p a:hover {
            color: var(--connector-primary);
        }


        /* =========================================================
           FORM GROUP
        ========================================================= */

        .connector-form-group {
            margin-bottom: 20px;
        }

        .connector-form-group label {
            display: block;

            margin-bottom: 8px;

            color: var(--connector-text);

            font-size: 12px;
            font-weight: 600;
        }


        /* =========================================================
           INPUT
        ========================================================= */

        .connector-input {
            position: relative;
        }

        .connector-input i {
            position: absolute;

            left: 15px;
            top: 50%;

            transform: translateY(-50%);

            color: #93A09A;

            font-size: 15px;

            pointer-events: none;

            transition: color .2s ease;
        }

        .connector-input input {
            width: 100%;
            height: 51px;

            padding: 0 44px;

            border: 1px solid var(--connector-border);

            border-radius: 10px;

            outline: none;

            background: #FBFCFB;

            color: var(--connector-text);

            font-size: 13px;

            transition:
                border-color .2s ease,
                background .2s ease,
                box-shadow .2s ease;
        }

        .connector-input input::placeholder {
            color: #A7B1AC;
        }

        .connector-input input:hover {
            border-color: #CBD8D2;
        }

        .connector-input input:focus {
            background: #fff;

            border-color: var(--connector-primary);

            box-shadow:
                0 0 0 3px rgba(107, 144, 128, 0.10);
        }

        .connector-input:focus-within i {
            color: var(--connector-primary);
        }


        /* =========================================================
           PASSWORD
        ========================================================= */

        .connector-password-toggle {
            position: absolute;

            top: 50%;
            right: 12px;

            width: 30px;
            height: 30px;

            display: flex;
            align-items: center;
            justify-content: center;

            transform: translateY(-50%);

            border: 0;

            background: transparent;

            color: #89958F;

            cursor: pointer;

            transition: color .2s ease;
        }

        .connector-password-toggle:hover {
            color: var(--connector-primary-dark);
        }


        /* =========================================================
           LABEL ROW
        ========================================================= */

        .connector-label-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .connector-label-row label {
            margin-bottom: 8px;
        }

        .connector-forgot {
            margin-bottom: 8px;

            color: var(--connector-primary);

            font-size: 11px;
            font-weight: 600;

            transition: color .2s ease;
        }

        .connector-forgot:hover {
            color: var(--connector-primary-dark);
        }


        /* =========================================================
           ERROR
        ========================================================= */

        .connector-error {
            display: flex;
            align-items: center;

            gap: 5px;

            margin-top: 7px;

            color: var(--connector-danger);

            font-size: 11px;
        }

        .connector-error i {
            font-size: 12px;
        }

        .connector-input input.is-invalid {
            border-color: #D96C6C;
        }


        /* =========================================================
           REMEMBER ME
        ========================================================= */

        .connector-login-options {
            margin: 4px 0 20px;
        }

        .connector-checkbox {
            display: inline-flex;

            align-items: center;

            gap: 8px;

            color: #6E7B75;

            font-size: 11px;

            cursor: pointer;
        }

        .connector-checkbox input {
            position: absolute;

            opacity: 0;

            pointer-events: none;
        }

        .connector-checkmark {
            width: 17px;
            height: 17px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 1px solid #CCD8D2;

            border-radius: 4px;

            background: #fff;

            transition: all .2s ease;
        }

        .connector-checkbox input:checked + .connector-checkmark {
            background: var(--connector-primary);

            border-color: var(--connector-primary);
        }

        .connector-checkbox input:checked + .connector-checkmark::after {
            content: "✓";

            color: #fff;

            font-size: 10px;
            font-weight: 700;
        }


        /* =========================================================
           LOGIN BUTTON
        ========================================================= */

        .connector-login-button {
            width: 100%;
            height: 51px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 9px;

            border: 0;

            border-radius: 10px;

            background: var(--connector-primary-dark);

            color: #fff;

            font-size: 13px;
            font-weight: 600;

            cursor: pointer;

            box-shadow:
                0 8px 20px rgba(37, 64, 53, 0.13);

            transition:
                background .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }

        .connector-login-button i {
            font-size: 14px;

            transition: transform .2s ease;
        }

        .connector-login-button:hover {
            background: var(--connector-primary-deep);

            transform: translateY(-1px);

            box-shadow:
                0 11px 25px rgba(37, 64, 53, 0.18);
        }

        .connector-login-button:hover i {
            transform: translateX(3px);
        }


        /* =========================================================
           DIVIDER
        ========================================================= */

        .connector-divider {
            display: flex;

            align-items: center;

            gap: 12px;

            margin: 27px 0 17px;
        }

        .connector-divider span {
            flex: 1;

            height: 1px;

            background: #E8EEEA;
        }

        .connector-divider small {
            color: #98A49F;

            font-size: 9px;

            font-weight: 600;

            letter-spacing: .8px;
        }


        /* =========================================================
           SOCIAL BUTTONS
        ========================================================= */

        .connector-social-buttons {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 10px;
        }

        .connector-social-button {
            height: 46px;

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 8px;

            border: 1px solid var(--connector-border);

            border-radius: 9px;

            background: #fff;

            color: #43534C;

            font-size: 12px;

            font-weight: 600;

            transition:
                background .2s ease,
                border-color .2s ease,
                transform .2s ease;
        }

        .connector-social-button img {
            width: 17px;
            height: 17px;

            object-fit: contain;
        }

        .connector-social-button:hover {
            background: #F8FAF9;

            border-color: #CBD8D2;

            color: var(--connector-primary-dark);

            transform: translateY(-1px);
        }


        /* =========================================================
           REGISTER
        ========================================================= */

        .connector-register {
            display: flex;

            justify-content: center;
            align-items: center;

            gap: 5px;

            margin-top: 26px;

            color: #89948F;

            font-size: 11px;
        }

        .connector-register a {
            display: inline-flex;

            align-items: center;

            gap: 3px;

            color: var(--connector-primary-dark);

            font-weight: 700;
        }

        .connector-register a:hover {
            color: var(--connector-primary);
        }

        .connector-register i {
            font-size: 9px;
        }


        /* =========================================================
           SECURITY NOTE
        ========================================================= */

        .connector-security {
            display: flex;

            align-items: center;
            justify-content: center;

            gap: 5px;

            margin-top: 22px;

            color: #A1AAA5;

            font-size: 10px;
        }

        .connector-security i {
            color: var(--connector-primary);

            font-size: 11px;
        }


        /* =========================================================
           RESPONSIVE — TABLET
        ========================================================= */

        @media (max-width: 900px) {

            .connector-auth-card {
                grid-template-columns: 1fr;

                max-width: 520px;

                min-height: auto;
            }

            .connector-brand-panel {
                display: none;
            }

            .connector-form-panel {
                padding: 42px 45px;
            }

            .connector-mobile-brand {
                display: flex;

                align-items: center;

                gap: 10px;

                margin-bottom: 28px;
            }

            .connector-mobile-brand .connector-brand-icon {
                color: var(--connector-primary-dark);

                background: var(--connector-primary-soft);

                border-color: var(--connector-primary-soft);
            }

            .connector-mobile-brand .connector-brand-name {
                color: var(--connector-primary-dark);

                font-size: 19px;
            }
        }


        /* =========================================================
           RESPONSIVE — MOBILE
        ========================================================= */

        @media (max-width: 576px) {

            .connector-auth-page {
                padding: 15px;
            }

            .connector-auth-card {
                border-radius: 15px;
            }

            .connector-form-panel {
                padding: 32px 22px 27px;
            }

            .connector-form-header {
                margin-bottom: 26px;
            }

            .connector-form-header h2 {
                font-size: 26px;
            }

            .connector-mobile-brand {
                margin-bottom: 24px;
            }

            .connector-social-buttons {
                grid-template-columns: 1fr;
            }

            .connector-register {
                flex-direction: column;

                gap: 3px;
            }

            .connector-security {
                margin-top: 19px;
            }
        }


        /* =========================================================
           VERY SMALL DEVICES
        ========================================================= */

        @media (max-width: 360px) {

            .connector-auth-page {
                padding: 8px;
            }

            .connector-form-panel {
                padding: 28px 17px 24px;
            }

            .connector-form-header h2 {
                font-size: 24px;
            }
        }


        /* =========================================================
           ACCESSIBILITY
        ========================================================= */

        .connector-login-button:focus-visible,
        .connector-social-button:focus-visible,
        .connector-password-toggle:focus-visible,
        .connector-forgot:focus-visible,
        .connector-register a:focus-visible {
            outline: 3px solid rgba(107, 144, 128, .25);
            outline-offset: 3px;
        }


        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition: none !important;
            }
        }
    </style>
</head>

<body>

<div class="connector-auth-page">

    <!-- Background decoration -->
    <div class="connector-bg-shape connector-bg-shape-one"></div>
    <div class="connector-bg-shape connector-bg-shape-two"></div>


    <main class="connector-auth-container">

        <div class="connector-auth-card">


            <!-- =====================================================
                 BRAND PANEL
            ====================================================== -->

            <section class="connector-brand-panel">

                <div class="connector-brand">

                    <div class="connector-brand-icon">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                    </div>

                    <span class="connector-brand-name">
                        Connector
                    </span>

                </div>


                <div class="connector-brand-content">

                    <div class="connector-eyebrow">
                        CONNECTOR MARKETPLACE
                    </div>

                    <h1>
                        Connect with the right
                        <span>professionals.</span>
                    </h1>

                    <p>
                        Discover services, find skilled professionals,
                        and connect with people who can help you get
                        the job done.
                    </p>

                </div>


                <div class="connector-brand-features">

                    <div class="connector-feature">

                        <div class="connector-feature-icon">
                            <i class="bi bi-search"></i>
                        </div>

                        <div class="connector-feature-text">
                            <strong>Find the right service</strong>
                            <span>Explore services from local professionals</span>
                        </div>

                    </div>


                    <div class="connector-feature">

                        <div class="connector-feature-icon">
                            <i class="bi bi-chat-dots"></i>
                        </div>

                        <div class="connector-feature-text">
                            <strong>Connect directly</strong>
                            <span>Communicate with service providers</span>
                        </div>

                    </div>


                    <div class="connector-feature">

                        <div class="connector-feature-icon">
                            <i class="bi bi-check2-circle"></i>
                        </div>

                        <div class="connector-feature-text">
                            <strong>Get the job done</strong>
                            <span>Work with the professional you choose</span>
                        </div>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 LOGIN PANEL
            ====================================================== -->

            <section class="connector-form-panel">

                <div class="connector-form-container">


                    <!-- Mobile Logo -->

                    <div class="connector-mobile-brand">

                        <div class="connector-brand-icon">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                        </div>

                        <span class="connector-brand-name">
                            Connector
                        </span>

                    </div>


                    <!-- Header -->

                    <div class="connector-form-header">

                        <h2>
                            Welcome back
                        </h2>

                        <p>
                            Sign in to continue to your Connector account.
                        </p>

                    </div>


                    <!-- Login Form -->

                    <form
                        method="POST"
                        action="{{ route('login') }}"
                        autocomplete="on"
                    >

                        @csrf


                        <!-- Email -->

                        <div class="connector-form-group">

                            <label for="email">
                                Email address
                            </label>

                            <div class="connector-input">

                                <i class="bi bi-envelope"></i>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="@error('email') is-invalid @enderror"
                                    placeholder="you@example.com"
                                    autocomplete="email"
                                    required
                                    autofocus
                                >

                            </div>

                            @error('email')

                                <div class="connector-error">

                                    <i class="bi bi-exclamation-circle"></i>

                                    <span>
                                        {{ $message }}
                                    </span>

                                </div>

                            @enderror

                        </div>


                        <!-- Password -->

                        <div class="connector-form-group">

                            <div class="connector-label-row">

                                <label for="password">
                                    Password
                                </label>

                                @if (Route::has('password.request'))

                                    <a
                                        href="{{ route('password.request') }}"
                                        class="connector-forgot"
                                    >
                                        Forgot password?
                                    </a>

                                @endif

                            </div>


                            <div class="connector-input">

                                <i class="bi bi-lock"></i>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="@error('password') is-invalid @enderror"
                                    placeholder="Enter your password"
                                    autocomplete="current-password"
                                    required
                                >


                                <button
                                    type="button"
                                    class="connector-password-toggle"
                                    id="togglePassword"
                                    aria-label="Show password"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>

                            </div>


                            @error('password')

                                <div class="connector-error">

                                    <i class="bi bi-exclamation-circle"></i>

                                    <span>
                                        {{ $message }}
                                    </span>

                                </div>

                            @enderror

                        </div>


                        <!-- Remember Me -->

                        <div class="connector-login-options">

                            <label
                                for="remember_me"
                                class="connector-checkbox"
                            >

                                <input
                                    type="checkbox"
                                    id="remember_me"
                                    name="remember"
                                    value="1"
                                    {{ old('remember') ? 'checked' : '' }}
                                >

                                <span class="connector-checkmark"></span>

                                <span>
                                    Keep me logged in
                                </span>

                            </label>

                        </div>


                        <!-- Login -->

                        <button
                            type="submit"
                            class="connector-login-button"
                        >

                            <span>
                                Sign in
                            </span>

                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </form>


                    <!-- Divider -->

                    <div class="connector-divider">

                        <span></span>

                        <small>
                            OR CONTINUE WITH
                        </small>

                        <span></span>

                    </div>


                    <!-- Social Login -->

                    <div class="connector-social-buttons">

                        <a
                            href="#"
                            class="connector-social-button"
                            aria-label="Login with Google"
                        >

                            <img
                                src="{{ asset('asset/images/icon/google.png') }}"
                                alt="Google"
                            >

                            <span>
                                Google
                            </span>

                        </a>


                        <a
                            href="#"
                            class="connector-social-button"
                            aria-label="Login with Facebook"
                        >

                            <img
                                src="{{ asset('asset/images/icon/facebook.png') }}"
                                alt="Facebook"
                            >

                            <span>
                                Facebook
                            </span>

                        </a>

                    </div>


                    <!-- Register -->

                    <div class="connector-register">

                        <span>
                            Don't have an account?
                        </span>

                        <a href="{{ route('register') }}">

                            Create an account

                            <i class="bi bi-arrow-up-right"></i>

                        </a>

                    </div>


                    <!-- Security -->

                    <div class="connector-security">

                        <i class="bi bi-shield-check"></i>

                        <span>
                            Your account information is securely protected
                        </span>

                    </div>

                </div>

            </section>

        </div>

    </main>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        if (passwordInput && togglePassword) {

            togglePassword.addEventListener('click', function () {

                const icon = this.querySelector('i');

                if (passwordInput.type === 'password') {

                    passwordInput.type = 'text';

                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');

                    this.setAttribute(
                        'aria-label',
                        'Hide password'
                    );

                } else {

                    passwordInput.type = 'password';

                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');

                    this.setAttribute(
                        'aria-label',
                        'Show password'
                    );
                }

            });

        }

    });
</script>

</body>
</html>