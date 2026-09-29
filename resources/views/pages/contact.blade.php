@extends('layouts.base')

@section('title', 'Contact')

@section('content')

<style>
    :root {
        --connector-primary: #254035;
        --connector-accent: #6B9080;
        --connector-accent-soft: #edf3f0;
        --connector-text: #18231e;
        --connector-muted: #6f7b75;
        --connector-border: #e4ebe7;
        --connector-soft: #f8faf9;
        --connector-white: #ffffff;
    }

    /* =========================================================
       CONTACT PAGE
    ========================================================= */

    .contact-page {
        background: #ffffff;
        color: var(--connector-text);
    }

    /* =========================================================
       HERO
    ========================================================= */

    .contact-hero {
        position: relative;
        overflow: hidden;
        padding: 90px 0 85px;
        background: linear-gradient(
            135deg,
            #f7faf8 0%,
            #edf3f0 100%
        );
        border-bottom: 1px solid var(--connector-border);
    }

    .contact-hero::before {
        content: "";
        position: absolute;
        width: 430px;
        height: 430px;
        border-radius: 50%;
        background: rgba(107, 144, 128, 0.08);
        top: -240px;
        right: -100px;
    }

    .contact-hero::after {
        content: "";
        position: absolute;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        background: rgba(37, 64, 53, 0.035);
        bottom: -180px;
        left: -100px;
    }

    .contact-hero-content {
        position: relative;
        z-index: 2;
        max-width: 760px;
        margin: auto;
        text-align: center;
    }

    .contact-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        margin-bottom: 18px;
        background: #ffffff;
        border: 1px solid var(--connector-border);
        border-radius: 50px;
        color: var(--connector-primary);
        font-size: 13px;
        font-weight: 600;
    }

    .contact-eyebrow i {
        color: var(--connector-accent);
    }

    .contact-hero h1 {
        margin: 0;
        color: var(--connector-primary);
        font-size: clamp(40px, 5vw, 62px);
        line-height: 1.05;
        font-weight: 700;
        letter-spacing: -1.8px;
    }

    .contact-hero p {
        max-width: 650px;
        margin: 20px auto 0;
        color: var(--connector-muted);
        font-size: 17px;
        line-height: 1.7;
    }

    /* =========================================================
       MAIN
    ========================================================= */

    .contact-main {
        padding: 75px 0 95px;
    }

    /* =========================================================
       SECTION INTRO
    ========================================================= */

    .contact-intro {
        max-width: 700px;
        margin: 0 auto 50px;
        text-align: center;
    }

    .contact-intro h2 {
        margin: 0;
        color: var(--connector-primary);
        font-size: 34px;
        line-height: 1.2;
        font-weight: 700;
        letter-spacing: -.7px;
    }

    .contact-intro p {
        margin: 13px auto 0;
        max-width: 590px;
        color: var(--connector-muted);
        font-size: 14px;
        line-height: 1.7;
    }

    /* =========================================================
       CONTACT INFORMATION
    ========================================================= */

    .contact-info-card {
        height: 100%;
        padding: 30px;
        background: var(--connector-soft);
        border: 1px solid var(--connector-border);
        border-radius: 18px;
    }

    .contact-info-header {
        margin-bottom: 25px;
    }

    .contact-info-header h3 {
        margin: 0;
        color: var(--connector-primary);
        font-size: 21px;
        font-weight: 700;
    }

    .contact-info-header p {
        margin: 7px 0 0;
        color: var(--connector-muted);
        font-size: 13px;
        line-height: 1.6;
    }

    .contact-info-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 18px 0;
        border-bottom: 1px solid var(--connector-border);
    }

    .contact-info-item:first-of-type {
        padding-top: 5px;
    }

    .contact-info-item:last-child {
        border-bottom: 0;
        padding-bottom: 5px;
    }

    .contact-info-icon {
        flex: 0 0 44px;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        border: 1px solid var(--connector-border);
        color: var(--connector-accent);
        font-size: 18px;
    }

    .contact-info-content {
        min-width: 0;
    }

    .contact-info-content span {
        display: block;
        margin-bottom: 4px;
        color: var(--connector-muted);
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .contact-info-content h4 {
        margin: 0;
        color: var(--connector-primary);
        font-size: 15px;
        line-height: 1.5;
        font-weight: 600;
    }

    .contact-info-content p {
        margin: 2px 0 0;
        color: var(--connector-muted);
        font-size: 13px;
        line-height: 1.55;
    }

    .contact-info-content a {
        color: var(--connector-primary);
        text-decoration: none;
        transition: color .2s ease;
    }

    .contact-info-content a:hover {
        color: var(--connector-accent);
    }

    /* =========================================================
       SUPPORT NOTE
    ========================================================= */

    .support-note {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        margin-top: 25px;
        padding: 15px;
        background: var(--connector-accent-soft);
        border-radius: 12px;
    }

    .support-note i {
        color: var(--connector-accent);
        font-size: 17px;
        margin-top: 1px;
    }

    .support-note p {
        margin: 0;
        color: var(--connector-primary);
        font-size: 12px;
        line-height: 1.6;
    }

    /* =========================================================
       FORM CARD
    ========================================================= */

    .contact-form-card {
        padding: 35px;
        background: #ffffff;
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        box-shadow: 0 15px 45px rgba(37, 64, 53, .06);
    }

    .contact-form-header {
        margin-bottom: 28px;
    }

    .contact-form-header h3 {
        margin: 0;
        color: var(--connector-primary);
        font-size: 23px;
        font-weight: 700;
    }

    .contact-form-header p {
        margin: 7px 0 0;
        color: var(--connector-muted);
        font-size: 13px;
        line-height: 1.6;
    }

    /* =========================================================
       ALERT
    ========================================================= */

    .contact-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 25px;
        padding: 14px 16px;
        border: 1px solid #cfe4d7;
        border-radius: 11px;
        background: #f2faf5;
        color: #28613e;
        font-size: 13px;
    }

    .contact-alert i {
        font-size: 17px;
        margin-top: 1px;
    }

    /* =========================================================
       FORM
    ========================================================= */

    .contact-form-group {
        margin-bottom: 21px;
    }

    .contact-form-label {
        display: block;
        margin-bottom: 8px;
        color: var(--connector-text);
        font-size: 12px;
        font-weight: 600;
    }

    .contact-form-control {
        width: 100%;
        min-height: 50px;
        padding: 12px 14px;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        background: #ffffff;
        color: var(--connector-text);
        font-size: 13px;
        outline: none;
        transition:
            border-color .2s ease,
            box-shadow .2s ease,
            background .2s ease;
    }

    .contact-form-control::placeholder {
        color: #a1aaa5;
    }

    .contact-form-control:focus {
        border-color: var(--connector-accent);
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .10);
    }

    textarea.contact-form-control {
        min-height: 150px;
        resize: vertical;
    }

    .contact-error {
        display: block;
        margin-top: 6px;
        color: #c0392b;
        font-size: 11px;
    }

    /* =========================================================
       SUBMIT BUTTON
    ========================================================= */

    .contact-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 50px;
        padding: 12px 24px;
        border: 0;
        border-radius: 10px;
        background: var(--connector-primary);
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition:
            background .2s ease,
            transform .2s ease,
            box-shadow .2s ease;
    }

    .contact-submit:hover {
        background: #1d332a;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(37, 64, 53, .15);
    }

    .contact-submit i {
        font-size: 15px;
    }

    /* =========================================================
       MAP
    ========================================================= */

    .contact-map-section {
        border-top: 1px solid var(--connector-border);
    }

    .contact-map {
        position: relative;
        height: 430px;
        overflow: hidden;
        background: var(--connector-soft);
    }

    .contact-map iframe {
        width: 100%;
        height: 100%;
        border: 0;
        display: block;
    }

    .map-overlay-card {
        position: absolute;
        left: 7%;
        top: 50%;
        transform: translateY(-50%);
        width: min(330px, 85%);
        padding: 22px;
        background: rgba(255,255,255,.96);
        border: 1px solid var(--connector-border);
        border-radius: 15px;
        box-shadow: 0 12px 35px rgba(0,0,0,.10);
    }

    .map-overlay-icon {
        width: 40px;
        height: 40px;
        margin-bottom: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: var(--connector-accent-soft);
        color: var(--connector-accent);
        font-size: 17px;
    }

    .map-overlay-card h4 {
        margin: 0;
        color: var(--connector-primary);
        font-size: 16px;
        font-weight: 700;
    }

    .map-overlay-card p {
        margin: 5px 0 0;
        color: var(--connector-muted);
        font-size: 12px;
        line-height: 1.6;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .contact-hero {
            padding: 70px 0 65px;
        }

        .contact-main {
            padding: 60px 0 75px;
        }

        .contact-info-card {
            margin-bottom: 25px;
        }

        .map-overlay-card {
            left: 30px;
        }
    }

    @media (max-width: 575.98px) {

        .contact-hero {
            padding: 55px 0 50px;
        }

        .contact-hero h1 {
            font-size: 40px;
            letter-spacing: -1px;
        }

        .contact-hero p {
            font-size: 14px;
        }

        .contact-main {
            padding: 50px 0 60px;
        }

        .contact-intro {
            margin-bottom: 35px;
        }

        .contact-intro h2 {
            font-size: 28px;
        }

        .contact-info-card,
        .contact-form-card {
            padding: 24px 20px;
        }

        .contact-map {
            height: 350px;
        }

        .map-overlay-card {
            position: absolute;
            left: 20px;
            right: 20px;
            bottom: 20px;
            top: auto;
            width: auto;
            transform: none;
        }
    }
</style>


<div class="contact-page">

    {{-- =========================================================
         HERO
    ========================================================== --}}
    <section class="contact-hero">

        <div class="container">

            <div class="contact-hero-content">

                <div class="contact-eyebrow">
                    <i class="bi bi-chat-dots"></i>
                    Connector Support
                </div>

                <h1>
                    Let's talk.
                </h1>

                <p>
                    Have a question, need help finding a service, or want to
                    learn more about Connector? Our team is here to help.
                </p>

            </div>

        </div>

    </section>


    {{-- =========================================================
         MAIN CONTACT SECTION
    ========================================================== --}}
    <section class="contact-main">

        <div class="container">

            {{-- INTRO --}}
            <div class="contact-intro">

                <h2>
                    Get in touch
                </h2>

                <p>
                    Send us a message and our team will get back to you.
                    Whether you are looking for a service or need assistance
                    using the platform, we're happy to help.
                </p>

            </div>


            <div class="row g-4 g-xl-5">

                {{-- =====================================================
                     CONTACT INFORMATION
                ====================================================== --}}
                <div class="col-lg-5">

                    <div class="contact-info-card">

                        <div class="contact-info-header">

                            <h3>
                                Contact information
                            </h3>

                            <p>
                                You can also reach us directly through the
                                contact details below.
                            </p>

                        </div>


                        {{-- ADDRESS --}}
                        <div class="contact-info-item">

                            <div class="contact-info-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>

                            <div class="contact-info-content">

                                <span>
                                    Our location
                                </span>

                                <h4>
                                    Kigali, Rwanda
                                </h4>

                                <p>
                                    Serving customers and service providers
                                    across Rwanda.
                                </p>

                            </div>

                        </div>


                        {{-- PHONE --}}
                        <div class="contact-info-item">

                            <div class="contact-info-icon">
                                <i class="bi bi-telephone"></i>
                            </div>

                            <div class="contact-info-content">

                                <span>
                                    Phone
                                </span>

                                <h4>
                                    <a href="tel:+250791957955">
                                        +250 791 957 955
                                    </a>
                                </h4>

                                <p>
                                    Contact our team for assistance.
                                </p>

                            </div>

                        </div>


                        {{-- SUPPORT --}}
                        <div class="contact-info-item">

                            <div class="contact-info-icon">
                                <i class="bi bi-headset"></i>
                            </div>

                            <div class="contact-info-content">

                                <span>
                                    Support
                                </span>

                                <h4>
                                    Connector Support
                                </h4>

                                <p>
                                    General platform and service inquiries.
                                </p>

                            </div>

                        </div>


                        {{-- SUPPORT NOTE --}}
                        <div class="support-note">

                            <i class="bi bi-info-circle"></i>

                            <p>
                                Tell us what you need help with and provide
                                enough detail for our team to assist you
                                effectively.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                     CONTACT FORM
                ====================================================== --}}
                <div class="col-lg-7">

                    <div class="contact-form-card">

                        <div class="contact-form-header">

                            <h3>
                                Send us a message
                            </h3>

                            <p>
                                Complete the form below and we'll get back
                                to you as soon as possible.
                            </p>

                        </div>


                        {{-- SUCCESS MESSAGE --}}
                        @if (Session::has('message'))

                            <div
                                class="contact-alert"
                                role="alert"
                            >

                                <i class="bi bi-check-circle"></i>

                                <span>
                                    {{ Session::get('message') }}
                                </span>

                            </div>

                        @endif


                        <form
                            action="{{ url('/sendMessage') }}"
                            method="POST"
                        >

                            @csrf

                            <div class="row">

                                {{-- NAME --}}
                                <div class="col-md-6">

                                    <div class="contact-form-group">

                                        <label
                                            for="name"
                                            class="contact-form-label"
                                        >
                                            Full name *
                                        </label>

                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            class="contact-form-control"
                                            value="{{ old('name') }}"
                                            placeholder="Enter your name"
                                            autocomplete="name"
                                            required
                                        >

                                        @error('name')

                                            <span class="contact-error">
                                                {{ $message }}
                                            </span>

                                        @enderror

                                    </div>

                                </div>


                                {{-- EMAIL --}}
                                <div class="col-md-6">

                                    <div class="contact-form-group">

                                        <label
                                            for="email"
                                            class="contact-form-label"
                                        >
                                            Email address *
                                        </label>

                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            class="contact-form-control"
                                            value="{{ old('email') }}"
                                            placeholder="you@example.com"
                                            autocomplete="email"
                                            required
                                        >

                                        @error('email')

                                            <span class="contact-error">
                                                {{ $message }}
                                            </span>

                                        @enderror

                                    </div>

                                </div>


                                {{-- PHONE --}}
                                <div class="col-md-6">

                                    <div class="contact-form-group">

                                        <label
                                            for="phone"
                                            class="contact-form-label"
                                        >
                                            Phone number
                                        </label>

                                        <input
                                            type="text"
                                            id="phone"
                                            name="phone"
                                            class="contact-form-control"
                                            value="{{ old('phone') }}"
                                            placeholder="+250 ..."
                                            autocomplete="tel"
                                        >

                                        @error('phone')

                                            <span class="contact-error">
                                                {{ $message }}
                                            </span>

                                        @enderror

                                    </div>

                                </div>


                                {{-- SUBJECT --}}
                                <div class="col-md-6">

                                    <div class="contact-form-group">

                                        <label
                                            for="subject"
                                            class="contact-form-label"
                                        >
                                            Subject
                                        </label>

                                        <input
                                            type="text"
                                            id="subject"
                                            name="subject"
                                            class="contact-form-control"
                                            value="{{ old('subject') }}"
                                            placeholder="What can we help with?"
                                        >

                                        @error('subject')

                                            <span class="contact-error">
                                                {{ $message }}
                                            </span>

                                        @enderror

                                    </div>

                                </div>


                                {{-- MESSAGE --}}
                                <div class="col-12">

                                    <div class="contact-form-group">

                                        <label
                                            for="message"
                                            class="contact-form-label"
                                        >
                                            Message *
                                        </label>

                                        <textarea
                                            id="message"
                                            name="message"
                                            class="contact-form-control"
                                            placeholder="Tell us how we can help..."
                                            required
                                        >{{ old('message') }}</textarea>

                                        @error('message')

                                            <span class="contact-error">
                                                {{ $message }}
                                            </span>

                                        @enderror

                                    </div>

                                </div>


                                {{-- SUBMIT --}}
                                <div class="col-12">

                                    <button
                                        type="submit"
                                        class="contact-submit"
                                    >

                                        <i class="bi bi-send"></i>

                                        Send message

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
         MAP
    ========================================================== --}}
    <section class="contact-map-section">

        <div class="contact-map">

            <iframe
                src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=kigali&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
                loading="lazy"
                title="Connector location in Kigali, Rwanda"
            ></iframe>


            <div class="map-overlay-card">

                <div class="map-overlay-icon">

                    <i class="bi bi-geo-alt"></i>

                </div>

                <h4>
                    Connector in Kigali
                </h4>

                <p>
                    Our platform connects customers with service providers
                    across Rwanda.
                </p>

            </div>

        </div>

    </section>

</div>

@endsection