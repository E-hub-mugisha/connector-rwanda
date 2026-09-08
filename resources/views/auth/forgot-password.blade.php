<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forgot Password | Connector</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >

    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        :root {
            --connector-primary: #6B9080;
            --connector-primary-dark: #254035;
            --connector-primary-soft: #EEF4F1;
            --connector-primary-pale: #F7FAF8;

            --connector-text: #183028;
            --connector-muted: #708078;
            --connector-border: #DFE8E3;

            --connector-white: #FFFFFF;
            --connector-danger: #C95A43;
            --connector-success: #2F8065;

            --connector-shadow: 0 24px 70px rgba(37, 64, 53, .12);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            font-family: "DM Sans", sans-serif;
            background:
                radial-gradient(
                    circle at top left,
                    rgba(107, 144, 128, .12),
                    transparent 32%
                ),
                linear-gradient(
                    135deg,
                    #F7FAF8 0%,
                    #EEF4F1 100%
                );
            color: var(--connector-text);
            -webkit-font-smoothing: antialiased;
        }

        button,
        input {
            font-family: inherit;
        }

        a {
            text-decoration: none;
        }

        .connector-auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .connector-auth-shell {
            width: 100%;
            max-width: 1080px;
            min-height: 650px;
            display: grid;
            grid-template-columns: 42% 58%;
            background: var(--connector-white);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: var(--connector-shadow);
        }

        /* =========================================================
           BRAND PANEL
        ========================================================= */

        .connector-brand-panel {
            position: relative;
            overflow: hidden;
            background: var(--connector-primary-dark);
            color: white;
            padding: 52px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .connector-brand-panel::before {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .10);
            top: -100px;
            right: -110px;
        }

        .connector-brand-panel::after {
            content: "";
            position: absolute;
            width: 360px;
            height: 360px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .07);
            bottom: -210px;
            left: -150px;
        }

        .connector-brand-content,
        .connector-brand-bottom {
            position: relative;
            z-index: 2;
        }

        .connector-brand-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-size: 27px;
            font-weight: 700;
            letter-spacing: -.7px;
        }

        .connector-logo-mark {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--connector-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .connector-brand-copy {
            margin-top: 90px;
        }

        .connector-brand-copy .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .09);
            color: #DDE9E4;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .connector-brand-copy h1 {
            margin-top: 24px;
            max-width: 370px;
            font-family: "Playfair Display", serif;
            font-size: clamp(38px, 4vw, 52px);
            line-height: 1.08;
            letter-spacing: -1.5px;
        }

        .connector-brand-copy p {
            max-width: 365px;
            margin-top: 22px;
            color: #C4D4CE;
            font-size: 15px;
            line-height: 1.8;
        }

        .connector-brand-features {
            list-style: none;
            margin-top: 34px;
            display: grid;
            gap: 13px;
        }

        .connector-brand-features li {
            display: flex;
            align-items: center;
            gap: 11px;
            color: #DCE8E3;
            font-size: 14px;
        }

        .connector-brand-features i {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: rgba(107, 144, 128, .25);
            color: #BFD8CC;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }

        .connector-brand-bottom {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #AFC3BB;
            font-size: 12px;
        }

        .connector-brand-bottom i {
            color: #A9CCBC;
        }

        /* =========================================================
           FORM PANEL
        ========================================================= */

        .connector-form-panel {
            padding: 60px 72px;
            display: flex;
            align-items: center;
        }

        .connector-form-container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .connector-mobile-logo {
            display: none;
        }

        .connector-form-heading {
            margin-bottom: 32px;
        }

        .connector-form-heading .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--connector-muted);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 26px;
            transition: .2s ease;
        }

        .connector-form-heading .back-link:hover {
            color: var(--connector-primary-dark);
        }

        .connector-form-heading h2 {
            font-size: 32px;
            line-height: 1.2;
            letter-spacing: -.8px;
            color: var(--connector-text);
            font-weight: 700;
        }

        .connector-form-heading p {
            margin-top: 10px;
            color: var(--connector-muted);
            font-size: 14px;
            line-height: 1.7;
            max-width: 430px;
        }

        /* =========================================================
           STATUS MESSAGE
        ========================================================= */

        .connector-status {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            padding: 14px 15px;
            margin-bottom: 24px;
            border-radius: 12px;
            background: #ECF8F2;
            border: 1px solid #CDEBDD;
            color: var(--connector-success);
            font-size: 13px;
            line-height: 1.6;
        }

        .connector-status i {
            font-size: 17px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* =========================================================
           FORM
        ========================================================= */

        .connector-field {
            margin-bottom: 22px;
        }

        .connector-field label {
            display: block;
            margin-bottom: 9px;
            color: var(--connector-text);
            font-size: 13px;
            font-weight: 700;
        }

        .connector-input-wrapper {
            position: relative;
        }

        .connector-input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #8A9992;
            font-size: 17px;
            pointer-events: none;
        }

        .connector-input {
            width: 100%;
            height: 54px;
            padding: 0 16px 0 45px;
            border: 1px solid var(--connector-border);
            border-radius: 12px;
            outline: none;
            background: #FBFCFC;
            color: var(--connector-text);
            font-size: 14px;
            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }

        .connector-input::placeholder {
            color: #A3ADA8;
        }

        .connector-input:hover {
            border-color: #C7D7CF;
        }

        .connector-input:focus {
            background: white;
            border-color: var(--connector-primary);
            box-shadow: 0 0 0 4px rgba(107, 144, 128, .10);
        }

        .connector-error {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            margin-top: 8px;
            color: var(--connector-danger);
            font-size: 12px;
            line-height: 1.5;
        }

        .connector-error i {
            margin-top: 2px;
        }

        /* =========================================================
           BUTTON
        ========================================================= */

        .connector-submit {
            width: 100%;
            height: 54px;
            border: none;
            border-radius: 12px;
            background: var(--connector-primary-dark);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition:
                transform .2s ease,
                background .2s ease,
                box-shadow .2s ease;
        }

        .connector-submit:hover {
            background: var(--connector-primary);
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(37, 64, 53, .15);
        }

        .connector-submit:active {
            transform: translateY(0);
        }

        .connector-submit i {
            font-size: 16px;
        }

        /* =========================================================
           FOOT LINKS
        ========================================================= */

        .connector-form-footer {
            margin-top: 28px;
            padding-top: 23px;
            border-top: 1px solid #EAF0ED;
            text-align: center;
        }

        .connector-form-footer p {
            color: var(--connector-muted);
            font-size: 13px;
        }

        .connector-form-footer a {
            color: var(--connector-primary-dark);
            font-weight: 700;
            transition: .2s ease;
        }

        .connector-form-footer a:hover {
            color: var(--connector-primary);
        }

        .connector-security-note {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 7px;
            margin-top: 18px;
            color: #94A09B;
            font-size: 11px;
        }

        .connector-security-note i {
            font-size: 13px;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 991px) {
            .connector-auth-shell {
                max-width: 760px;
                grid-template-columns: 1fr;
            }

            .connector-brand-panel {
                display: none;
            }

            .connector-form-panel {
                min-height: 650px;
                padding: 55px 60px;
            }

            .connector-mobile-logo {
                display: inline-flex;
                align-items: center;
                gap: 9px;
                margin-bottom: 42px;
                color: var(--connector-primary-dark);
                font-size: 23px;
                font-weight: 700;
            }

            .connector-mobile-logo .connector-logo-mark {
                width: 38px;
                height: 38px;
                border-radius: 10px;
                font-size: 18px;
            }
        }

        @media (max-width: 575px) {
            .connector-auth-page {
                padding: 0;
                align-items: stretch;
            }

            .connector-auth-shell {
                min-height: 100vh;
                border-radius: 0;
                box-shadow: none;
            }

            .connector-form-panel {
                min-height: 100vh;
                padding: 32px 22px;
                align-items: flex-start;
            }

            .connector-form-container {
                max-width: 100%;
            }

            .connector-mobile-logo {
                margin-bottom: 54px;
            }

            .connector-form-heading h2 {
                font-size: 28px;
            }

            .connector-form-heading {
                margin-bottom: 28px;
            }

            .connector-form-heading .back-link {
                margin-bottom: 21px;
            }

            .connector-input {
                height: 52px;
            }

            .connector-submit {
                height: 52px;
            }
        }
    </style>
</head>

<body>

<div class="connector-auth-page">

    <div class="connector-auth-shell">

        {{-- =====================================================
             BRAND PANEL
        ====================================================== --}}
        <aside class="connector-brand-panel">

            <div class="connector-brand-content">

                <a href="{{ route('home') }}" class="connector-brand-logo">
                    <span class="connector-logo-mark">
                        <i class="bi bi-link-45deg"></i>
                    </span>

                    Connector
                </a>

                <div class="connector-brand-copy">

                    <span class="eyebrow">
                        <i class="bi bi-shield-check"></i>
                        Account recovery
                    </span>

                    <h1>
                        Get back to what matters.
                    </h1>

                    <p>
                        Forgot your password? No problem. Enter your email
                        address and we'll send you a secure link to create
                        a new password.
                    </p>

                    <ul class="connector-brand-features">

                        <li>
                            <i class="bi bi-check-lg"></i>
                            Secure password recovery
                        </li>

                        <li>
                            <i class="bi bi-check-lg"></i>
                            Quick and simple process
                        </li>

                        <li>
                            <i class="bi bi-check-lg"></i>
                            Your account stays protected
                        </li>

                    </ul>

                </div>
            </div>

            <div class="connector-brand-bottom">
                <i class="bi bi-lock-fill"></i>
                <span>Your information is securely protected.</span>
            </div>

        </aside>


        {{-- =====================================================
             FORM PANEL
        ====================================================== --}}
        <main class="connector-form-panel">

            <div class="connector-form-container">

                {{-- Mobile logo --}}
                <a href="{{ route('home') }}" class="connector-mobile-logo">

                    <span class="connector-logo-mark">
                        <i class="bi bi-link-45deg"></i>
                    </span>

                    Connector

                </a>


                {{-- Heading --}}
                <div class="connector-form-heading">

                    <a href="{{ route('login') }}" class="back-link">
                        <i class="bi bi-arrow-left"></i>
                        Back to sign in
                    </a>

                    <h2>
                        Forgot your password?
                    </h2>

                    <p>
                        Enter the email address associated with your account
                        and we'll send you a password reset link.
                    </p>

                </div>


                {{-- Session status --}}
                @if (session('status'))

                    <div class="connector-status">

                        <i class="bi bi-check-circle-fill"></i>

                        <div>
                            {{ session('status') }}
                        </div>

                    </div>

                @endif


                {{-- Validation errors --}}
                @if ($errors->any())

                    <div class="connector-status"
                         style="background:#FFF4F1;border-color:#F2D4CB;color:#B84F39;">

                        <i class="bi bi-exclamation-circle-fill"></i>

                        <div>
                            Please check the email address and try again.
                        </div>

                    </div>

                @endif


                {{-- Reset form --}}
                <form
                    method="POST"
                    action="{{ route('password.email') }}"
                >

                    @csrf

                    <div class="connector-field">

                        <label for="email">
                            Email address
                        </label>

                        <div class="connector-input-wrapper">

                            <i class="bi bi-envelope connector-input-icon"></i>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="connector-input"
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                autocomplete="email"
                                required
                                autofocus
                            >

                        </div>

                        @error('email')

                            <div class="connector-error">

                                <i class="bi bi-exclamation-circle"></i>

                                <span>{{ $message }}</span>

                            </div>

                        @enderror

                    </div>


                    <button
                        type="submit"
                        class="connector-submit"
                    >
                        <span>Send reset link</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>

                </form>


                {{-- Footer --}}
                <div class="connector-form-footer">

                    <p>
                        Remember your password?
                        <a href="{{ route('login') }}">
                            Sign in
                        </a>
                    </p>

                    <div class="connector-security-note">

                        <i class="bi bi-shield-lock"></i>

                        <span>
                            Secure password recovery
                        </span>

                    </div>

                </div>

            </div>

        </main>

    </div>

</div>

</body>
</html>