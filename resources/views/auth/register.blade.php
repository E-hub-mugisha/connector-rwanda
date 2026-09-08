<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Account | Connector</title>

    <meta name="description"
          content="Create your Connector account and connect with trusted professionals and services.">

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
            --connector-primary-light: #F6F9F7;

            --connector-text: #183028;
            --connector-muted: #718078;

            --connector-border: #DFE8E3;

            --connector-white: #FFFFFF;

            --connector-danger: #C84E4E;

            --connector-shadow:
                0 25px 70px rgba(37, 64, 53, 0.12);
        }


        /* =========================================================
           RESET
        ========================================================= */

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

            color: var(--connector-text);

            background: #F5F8F6;

            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
        }

        button,
        input,
        select {
            font-family: inherit;
        }


        /* =========================================================
           PAGE
        ========================================================= */

        .connector-register-page {

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 30px 20px;

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
           BACKGROUND SHAPES
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
           MAIN CARD
        ========================================================= */

        .connector-register-container {

            position: relative;

            z-index: 2;

            width: 100%;

            max-width: 1080px;
        }

        .connector-register-card {

            display: grid;

            grid-template-columns: 40% 60%;

            background: #fff;

            border-radius: 20px;

            overflow: hidden;

            border: 1px solid rgba(37, 64, 53, 0.05);

            box-shadow: var(--connector-shadow);
        }


        /* =========================================================
           LEFT BRAND PANEL
        ========================================================= */

        .connector-brand-panel {

            position: relative;

            overflow: hidden;

            padding: 42px;

            display: flex;
            flex-direction: column;

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

            width: 390px;
            height: 390px;

            right: -230px;
            top: -170px;

            border-radius: 50%;

            border: 1px solid rgba(255,255,255,.11);
        }

        .connector-brand-panel::after {

            content: "";

            position: absolute;

            width: 320px;
            height: 320px;

            left: -210px;
            bottom: -190px;

            border-radius: 50%;

            border: 1px solid rgba(255,255,255,.08);
        }


        /* =========================================================
           BRAND
        ========================================================= */

        .connector-brand {

            position: relative;

            z-index: 2;

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

            background: rgba(255,255,255,.13);

            border: 1px solid rgba(255,255,255,.16);

            font-size: 17px;
        }

        .connector-brand-name {

            color: #fff;

            font-size: 20px;

            font-weight: 700;

            letter-spacing: -.5px;
        }


        /* =========================================================
           BRAND CONTENT
        ========================================================= */

        .connector-brand-content {

            position: relative;

            z-index: 2;

            margin-top: auto;

            margin-bottom: auto;

            padding: 50px 0 45px;
        }

        .connector-eyebrow {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            margin-bottom: 17px;

            color: rgba(255,255,255,.62);

            font-size: 10px;

            font-weight: 700;

            letter-spacing: 1.8px;
        }

        .connector-eyebrow::before {

            content: "";

            width: 22px;
            height: 1px;

            background: rgba(255,255,255,.45);
        }

        .connector-brand-content h1 {

            max-width: 350px;

            margin: 0 0 19px;

            font-family: "Playfair Display", serif;

            font-size: 39px;

            line-height: 1.09;

            letter-spacing: -1.2px;
        }

        .connector-brand-content h1 span {

            color: #D8E9E1;
        }

        .connector-brand-content p {

            max-width: 330px;

            margin: 0;

            color: rgba(255,255,255,.69);

            font-size: 13px;

            line-height: 1.75;
        }


        /* =========================================================
           BENEFITS
        ========================================================= */

        .connector-benefits {

            position: relative;

            z-index: 2;

            display: flex;

            flex-direction: column;

            gap: 14px;
        }

        .connector-benefit {

            display: flex;

            align-items: center;

            gap: 12px;
        }

        .connector-benefit-icon {

            flex: 0 0 36px;

            width: 36px;
            height: 36px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: rgba(255,255,255,.10);

            border: 1px solid rgba(255,255,255,.08);

            font-size: 14px;
        }

        .connector-benefit strong {

            display: block;

            margin-bottom: 2px;

            font-size: 12px;

            font-weight: 600;
        }

        .connector-benefit span {

            display: block;

            color: rgba(255,255,255,.52);

            font-size: 10px;
        }


        /* =========================================================
           FORM PANEL
        ========================================================= */

        .connector-form-panel {

            padding: 42px 58px 38px;

            background: #fff;
        }

        .connector-form-container {

            width: 100%;

            max-width: 500px;

            margin: auto;
        }


        /* =========================================================
           MOBILE BRAND
        ========================================================= */

        .connector-mobile-brand {

            display: none;

            align-items: center;

            gap: 10px;

            margin-bottom: 24px;
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


        /* =========================================================
           HEADER
        ========================================================= */

        .connector-form-header {

            margin-bottom: 25px;
        }

        .connector-form-header h2 {

            margin: 0 0 7px;

            color: var(--connector-text);

            font-size: 29px;

            line-height: 1.2;

            font-weight: 700;

            letter-spacing: -.8px;
        }

        .connector-form-header p {

            margin: 0;

            color: var(--connector-muted);

            font-size: 12px;

            line-height: 1.6;
        }


        /* =========================================================
           FORM GRID
        ========================================================= */

        .connector-fields-grid {

            display: grid;

            grid-template-columns: 1fr 1fr;

            column-gap: 14px;
        }

        .connector-full-field {

            grid-column: 1 / -1;
        }


        /* =========================================================
           FORM GROUP
        ========================================================= */

        .connector-form-group {

            margin-bottom: 16px;
        }

        .connector-form-group label {

            display: block;

            margin-bottom: 7px;

            color: var(--connector-text);

            font-size: 11px;

            font-weight: 600;
        }


        /* =========================================================
           INPUT
        ========================================================= */

        .connector-input {

            position: relative;
        }

        .connector-input > i {

            position: absolute;

            left: 14px;

            top: 50%;

            transform: translateY(-50%);

            color: #94A09A;

            font-size: 14px;

            pointer-events: none;

            transition: color .2s ease;
        }

        .connector-input input,
        .connector-input select {

            width: 100%;

            height: 47px;

            padding: 0 40px;

            border: 1px solid var(--connector-border);

            border-radius: 9px;

            outline: none;

            background: #FBFCFB;

            color: var(--connector-text);

            font-size: 12px;

            transition:
                border-color .2s ease,
                background .2s ease,
                box-shadow .2s ease;
        }

        .connector-input select {

            padding-left: 40px;

            appearance: none;

            cursor: pointer;
        }

        .connector-select-arrow {

            position: absolute;

            right: 14px;

            top: 50%;

            transform: translateY(-50%);

            color: #899690;

            font-size: 11px;

            pointer-events: none;
        }

        .connector-input input::placeholder {

            color: #A7B1AC;
        }

        .connector-input input:hover,
        .connector-input select:hover {

            border-color: #CBD8D2;
        }

        .connector-input input:focus,
        .connector-input select:focus {

            background: #fff;

            border-color: var(--connector-primary);

            box-shadow:
                0 0 0 3px rgba(107,144,128,.10);
        }

        .connector-input:focus-within > i {

            color: var(--connector-primary);
        }


        /* =========================================================
           PASSWORD TOGGLE
        ========================================================= */

        .connector-password-toggle {

            position: absolute;

            right: 10px;

            top: 50%;

            width: 28px;
            height: 28px;

            display: flex;

            align-items: center;
            justify-content: center;

            transform: translateY(-50%);

            border: 0;

            background: transparent;

            color: #89958F;

            cursor: pointer;
        }

        .connector-password-toggle:hover {

            color: var(--connector-primary-dark);
        }


        /* =========================================================
           VALIDATION
        ========================================================= */

        .connector-input input.is-invalid,
        .connector-input select.is-invalid {

            border-color: #D86A6A;
        }

        .connector-error {

            display: flex;

            align-items: center;

            gap: 5px;

            margin-top: 5px;

            color: var(--connector-danger);

            font-size: 10px;
        }

        .connector-error i {

            font-size: 11px;
        }


        /* =========================================================
           PASSWORD STRENGTH
        ========================================================= */

        .connector-password-hint {

            display: flex;

            align-items: center;

            gap: 5px;

            margin-top: 6px;

            color: #98A39E;

            font-size: 9px;
        }

        .connector-password-hint i {

            color: var(--connector-primary);

            font-size: 10px;
        }


        /* =========================================================
           TERMS
        ========================================================= */

        .connector-terms {

            display: flex;

            align-items: flex-start;

            gap: 9px;

            margin: 3px 0 18px;
        }

        .connector-terms input {

            position: absolute;

            opacity: 0;

            pointer-events: none;
        }

        .connector-terms-check {

            flex: 0 0 17px;

            width: 17px;
            height: 17px;

            display: flex;

            align-items: center;
            justify-content: center;

            margin-top: 1px;

            border: 1px solid #CBD7D1;

            border-radius: 4px;

            background: #fff;

            transition: all .2s ease;
        }

        .connector-terms input:checked + .connector-terms-check {

            background: var(--connector-primary);

            border-color: var(--connector-primary);
        }

        .connector-terms input:checked + .connector-terms-check::after {

            content: "✓";

            color: #fff;

            font-size: 10px;

            font-weight: 700;
        }

        .connector-terms label {

            margin: 0;

            color: #78857F;

            font-size: 10px;

            line-height: 1.55;

            cursor: pointer;
        }

        .connector-terms label a {

            color: var(--connector-primary-dark);

            font-weight: 600;
        }

        .connector-terms label a:hover {

            color: var(--connector-primary);
        }


        /* =========================================================
           REGISTER BUTTON
        ========================================================= */

        .connector-register-button {

            width: 100%;

            height: 49px;

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 9px;

            border: 0;

            border-radius: 9px;

            background: var(--connector-primary-dark);

            color: #fff;

            font-size: 12px;

            font-weight: 600;

            cursor: pointer;

            box-shadow:
                0 8px 20px rgba(37,64,53,.13);

            transition:
                background .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }

        .connector-register-button i {

            font-size: 13px;

            transition: transform .2s ease;
        }

        .connector-register-button:hover {

            background: var(--connector-primary-deep);

            transform: translateY(-1px);

            box-shadow:
                0 11px 24px rgba(37,64,53,.18);
        }

        .connector-register-button:hover i {

            transform: translateX(3px);
        }


        /* =========================================================
           DIVIDER
        ========================================================= */

        .connector-divider {

            display: flex;

            align-items: center;

            gap: 12px;

            margin: 22px 0 14px;
        }

        .connector-divider span {

            flex: 1;

            height: 1px;

            background: #E8EEEA;
        }

        .connector-divider small {

            color: #98A49F;

            font-size: 8px;

            font-weight: 600;

            letter-spacing: .8px;
        }


        /* =========================================================
           SOCIAL
        ========================================================= */

        .connector-social-buttons {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 9px;
        }

        .connector-social-button {

            height: 43px;

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 8px;

            border: 1px solid var(--connector-border);

            border-radius: 8px;

            background: #fff;

            color: #43534C;

            font-size: 11px;

            font-weight: 600;

            transition:
                background .2s ease,
                border-color .2s ease,
                transform .2s ease;
        }

        .connector-social-button img {

            width: 16px;
            height: 16px;

            object-fit: contain;
        }

        .connector-social-button:hover {

            background: #F8FAF9;

            border-color: #CBD8D2;

            color: var(--connector-primary-dark);

            transform: translateY(-1px);
        }


        /* =========================================================
           LOGIN LINK
        ========================================================= */

        .connector-login-link {

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 5px;

            margin-top: 19px;

            color: #89948F;

            font-size: 10px;
        }

        .connector-login-link a {

            display: inline-flex;

            align-items: center;

            gap: 3px;

            color: var(--connector-primary-dark);

            font-weight: 700;
        }

        .connector-login-link a:hover {

            color: var(--connector-primary);
        }

        .connector-login-link i {

            font-size: 8px;
        }


        /* =========================================================
           SECURITY
        ========================================================= */

        .connector-security {

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 5px;

            margin-top: 15px;

            color: #A0AAA5;

            font-size: 9px;
        }

        .connector-security i {

            color: var(--connector-primary);

            font-size: 10px;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 900px) {

            .connector-register-card {

                grid-template-columns: 1fr;

                max-width: 560px;

                margin: auto;
            }

            .connector-brand-panel {

                display: none;
            }

            .connector-form-panel {

                padding: 38px 45px 32px;
            }

            .connector-mobile-brand {

                display: flex;
            }
        }


        @media (max-width: 600px) {

            .connector-register-page {

                padding: 15px;
            }

            .connector-register-card {

                border-radius: 15px;
            }

            .connector-form-panel {

                padding: 30px 21px 25px;
            }

            .connector-form-header {

                margin-bottom: 23px;
            }

            .connector-form-header h2 {

                font-size: 26px;
            }

            .connector-fields-grid {

                grid-template-columns: 1fr;
            }

            .connector-full-field {

                grid-column: auto;
            }

            .connector-social-buttons {

                grid-template-columns: 1fr;
            }

            .connector-login-link {

                flex-direction: column;

                gap: 3px;
            }
        }


        @media (max-width: 360px) {

            .connector-register-page {

                padding: 8px;
            }

            .connector-form-panel {

                padding: 27px 17px 23px;
            }

            .connector-form-header h2 {

                font-size: 24px;
            }
        }


        /* =========================================================
           ACCESSIBILITY
        ========================================================= */

        .connector-register-button:focus-visible,
        .connector-social-button:focus-visible,
        .connector-password-toggle:focus-visible,
        .connector-login-link a:focus-visible,
        .connector-terms label a:focus-visible {

            outline: 3px solid rgba(107,144,128,.25);

            outline-offset: 3px;
        }


        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {

                transition: none !important;
            }
        }

    </style>
</head>


<body>

<div class="connector-register-page">

    <!-- Background decoration -->
    <div class="connector-bg-shape connector-bg-shape-one"></div>
    <div class="connector-bg-shape connector-bg-shape-two"></div>


    <main class="connector-register-container">

        <div class="connector-register-card">


            <!-- =====================================================
                 BRAND PANEL
            ====================================================== -->

            <section class="connector-brand-panel">

                <!-- Brand -->

                <div class="connector-brand">

                    <div class="connector-brand-icon">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                    </div>

                    <span class="connector-brand-name">
                        Connector
                    </span>

                </div>


                <!-- Main Copy -->

                <div class="connector-brand-content">

                    <div class="connector-eyebrow">
                        JOIN CONNECTOR
                    </div>

                    <h1>
                        Your next
                        <span>connection</span>
                        starts here.
                    </h1>

                    <p>
                        Create your account and discover a simpler
                        way to find services, connect with professionals,
                        and get things done.
                    </p>

                </div>


                <!-- Benefits -->

                <div class="connector-benefits">

                    <div class="connector-benefit">

                        <div class="connector-benefit-icon">
                            <i class="bi bi-search"></i>
                        </div>

                        <div>
                            <strong>Discover services</strong>

                            <span>
                                Explore services that match your needs
                            </span>
                        </div>

                    </div>


                    <div class="connector-benefit">

                        <div class="connector-benefit-icon">
                            <i class="bi bi-people"></i>
                        </div>

                        <div>
                            <strong>Meet professionals</strong>

                            <span>
                                Connect directly with service providers
                            </span>
                        </div>

                    </div>


                    <div class="connector-benefit">

                        <div class="connector-benefit-icon">
                            <i class="bi bi-check2-circle"></i>
                        </div>

                        <div>
                            <strong>Get things done</strong>

                            <span>
                                Find the right person for the job
                            </span>
                        </div>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 FORM PANEL
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
                            Create your account
                        </h2>

                        <p>
                            Join Connector and start connecting with
                            people and services.
                        </p>

                    </div>


                    <!-- Registration Form -->

                    <form
                        method="POST"
                        action="{{ route('register') }}"
                        autocomplete="on"
                    >

                        @csrf


                        <div class="connector-fields-grid">


                            <!-- =================================================
                                 NAME
                            ================================================== -->

                            <div class="connector-form-group connector-full-field">

                                <label for="name">
                                    Full name
                                </label>

                                <div class="connector-input">

                                    <i class="bi bi-person"></i>

                                    <input
                                        id="name"
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        class="@error('name') is-invalid @enderror"
                                        placeholder="Enter your full name"
                                        autocomplete="name"
                                        required
                                        autofocus
                                    >

                                </div>

                                @error('name')

                                    <div class="connector-error">

                                        <i class="bi bi-exclamation-circle"></i>

                                        <span>
                                            {{ $message }}
                                        </span>

                                    </div>

                                @enderror

                            </div>


                            <!-- =================================================
                                 EMAIL
                            ================================================== -->

                            <div class="connector-form-group">

                                <label for="email">
                                    Email address
                                </label>

                                <div class="connector-input">

                                    <i class="bi bi-envelope"></i>

                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="@error('email') is-invalid @enderror"
                                        placeholder="you@example.com"
                                        autocomplete="email"
                                        required
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


                            <!-- =================================================
                                 PHONE
                            ================================================== -->

                            <div class="connector-form-group">

                                <label for="phone">
                                    Phone number
                                </label>

                                <div class="connector-input">

                                    <i class="bi bi-telephone"></i>

                                    <input
                                        id="phone"
                                        type="tel"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        class="@error('phone') is-invalid @enderror"
                                        placeholder="+250 7XX XXX XXX"
                                        autocomplete="tel"
                                        required
                                    >

                                </div>

                                @error('phone')

                                    <div class="connector-error">

                                        <i class="bi bi-exclamation-circle"></i>

                                        <span>
                                            {{ $message }}
                                        </span>

                                    </div>

                                @enderror

                            </div>


                            <!-- =================================================
                                 ACCOUNT TYPE
                            ================================================== -->

                            <div class="connector-form-group connector-full-field">

                                <label for="registeras">
                                    Account type
                                </label>

                                <div class="connector-input">

                                    <i class="bi bi-person-badge"></i>

                                    <select
                                        id="registeras"
                                        name="registeras"
                                        class="@error('registeras') is-invalid @enderror"
                                        required
                                    >

                                        <option value="">
                                            Select how you want to use Connector
                                        </option>

                                        <option
                                            value="CST"
                                            {{ old('registeras', 'CST') === 'CST' ? 'selected' : '' }}
                                        >
                                            Customer — I want to find services
                                        </option>

                                        <option
                                            value="SVP"
                                            {{ old('registeras') === 'SVP' ? 'selected' : '' }}
                                        >
                                            Service Provider — I offer services
                                        </option>

                                    </select>

                                    <span class="connector-select-arrow">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>

                                </div>

                                @error('registeras')

                                    <div class="connector-error">

                                        <i class="bi bi-exclamation-circle"></i>

                                        <span>
                                            {{ $message }}
                                        </span>

                                    </div>

                                @enderror

                            </div>


                            <!-- =================================================
                                 PASSWORD
                            ================================================== -->

                            <div class="connector-form-group">

                                <label for="password">
                                    Password
                                </label>

                                <div class="connector-input">

                                    <i class="bi bi-lock"></i>

                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        class="@error('password') is-invalid @enderror"
                                        placeholder="Create a password"
                                        autocomplete="new-password"
                                        required
                                    >

                                    <button
                                        type="button"
                                        class="connector-password-toggle"
                                        data-target="password"
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

                                @else

                                    <div class="connector-password-hint">

                                        <i class="bi bi-shield-check"></i>

                                        <span>
                                            Use a strong password to protect your account
                                        </span>

                                    </div>

                                @enderror

                            </div>


                            <!-- =================================================
                                 CONFIRM PASSWORD
                            ================================================== -->

                            <div class="connector-form-group">

                                <label for="password_confirmation">
                                    Confirm password
                                </label>

                                <div class="connector-input">

                                    <i class="bi bi-lock-fill"></i>

                                    <input
                                        id="password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        class="@error('password_confirmation') is-invalid @enderror"
                                        placeholder="Repeat your password"
                                        autocomplete="new-password"
                                        required
                                    >

                                    <button
                                        type="button"
                                        class="connector-password-toggle"
                                        data-target="password_confirmation"
                                        aria-label="Show password"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </button>

                                </div>

                                @error('password_confirmation')

                                    <div class="connector-error">

                                        <i class="bi bi-exclamation-circle"></i>

                                        <span>
                                            {{ $message }}
                                        </span>

                                    </div>

                                @enderror

                            </div>


                        </div>


                        <!-- =====================================================
                             TERMS
                        ====================================================== -->

                        <div class="connector-terms">

                            <input
                                type="checkbox"
                                id="terms"
                                name="terms"
                                value="1"
                                required
                                {{ old('terms') ? 'checked' : '' }}
                            >

                            <span class="connector-terms-check"></span>

                            <label for="terms">

                                By creating an account, you agree to the
                                <a href="{{ route('terms') }}">
                                    Terms & Conditions
                                </a>
                                and
                                <a href="{{ route('policy') }}">
                                    Privacy Policy
                                </a>.

                            </label>

                        </div>


                        <!-- =====================================================
                             REGISTER BUTTON
                        ====================================================== -->

                        <button
                            type="submit"
                            class="connector-register-button"
                        >

                            <span>
                                Create account
                            </span>

                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </form>


                    <!-- =====================================================
                         SOCIAL
                    ====================================================== -->

                    <div class="connector-divider">

                        <span></span>

                        <small>
                            OR SIGN UP WITH
                        </small>

                        <span></span>

                    </div>


                    <div class="connector-social-buttons">

                        <a
                            href="#"
                            class="connector-social-button"
                            aria-label="Sign up with Google"
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
                            aria-label="Sign up with Facebook"
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


                    <!-- =====================================================
                         LOGIN
                    ====================================================== -->

                    <div class="connector-login-link">

                        <span>
                            Already have an account?
                        </span>

                        <a href="{{ route('login') }}">

                            Sign in

                            <i class="bi bi-arrow-up-right"></i>

                        </a>

                    </div>


                    <!-- =====================================================
                         SECURITY
                    ====================================================== -->

                    <div class="connector-security">

                        <i class="bi bi-shield-check"></i>

                        <span>
                            Your information is securely protected
                        </span>

                    </div>


                </div>

            </section>

        </div>

    </main>

</div>


<script>

    document.addEventListener('DOMContentLoaded', function () {

        /*
         * Password visibility
         */

        document
            .querySelectorAll('.connector-password-toggle')
            .forEach(function (button) {

                button.addEventListener('click', function () {

                    const targetId =
                        this.getAttribute('data-target');

                    const input =
                        document.getElementById(targetId);

                    if (!input) {
                        return;
                    }

                    const icon =
                        this.querySelector('i');


                    if (input.type === 'password') {

                        input.type = 'text';

                        icon.classList.remove('bi-eye');

                        icon.classList.add('bi-eye-slash');

                        this.setAttribute(
                            'aria-label',
                            'Hide password'
                        );

                    } else {

                        input.type = 'password';

                        icon.classList.remove('bi-eye-slash');

                        icon.classList.add('bi-eye');

                        this.setAttribute(
                            'aria-label',
                            'Show password'
                        );

                    }

                });

            });


        /*
         * Password confirmation visual feedback
         */

        const password =
            document.getElementById('password');

        const passwordConfirmation =
            document.getElementById('password_confirmation');


        function validatePasswordMatch() {

            if (
                !password ||
                !passwordConfirmation ||
                !passwordConfirmation.value
            ) {
                return;
            }

            if (
                password.value !==
                passwordConfirmation.value
            ) {

                passwordConfirmation.style.borderColor =
                    '#D86A6A';

            } else {

                passwordConfirmation.style.borderColor =
                    '#6B9080';

            }

        }


        if (passwordConfirmation) {

            passwordConfirmation.addEventListener(
                'input',
                validatePasswordMatch
            );

        }

        if (password) {

            password.addEventListener(
                'input',
                validatePasswordMatch
            );

        }

    });

</script>

</body>
</html>