@extends('layouts.base')

@section('title', 'Privacy Policy')

@section('content')

<style>
    :root {
        --privacy-primary: #254035;
        --privacy-accent: #6B9080;
        --privacy-text: #18231e;
        --privacy-muted: #6f7b75;
        --privacy-border: #e6ebe8;
        --privacy-bg: #f8faf9;
        --privacy-white: #ffffff;
    }

    .privacy-page {
        color: var(--privacy-text);
        overflow: hidden;
    }

    .privacy-page p {
        color: var(--privacy-muted);
        line-height: 1.8;
    }

    /* HERO */
    .privacy-hero {
        background: var(--privacy-bg);
        padding: 90px 0 95px;
        text-align: center;
    }

    .privacy-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--privacy-accent);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .privacy-eyebrow:before {
        content: "";
        width: 25px;
        height: 1px;
        background: var(--privacy-accent);
    }

    .privacy-hero h1 {
        font-size: clamp(40px, 5vw, 62px);
        line-height: 1.1;
        font-weight: 500;
        letter-spacing: -2px;
        margin: 18px 0 18px;
    }

    .privacy-hero p {
        max-width: 620px;
        margin: auto;
        font-size: 17px;
    }

    .privacy-breadcrumb {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        list-style: none;
        padding: 0;
        margin: 25px 0 0;
        font-size: 13px;
    }

    .privacy-breadcrumb a {
        color: var(--privacy-muted);
        text-decoration: none;
    }

    .privacy-breadcrumb li:last-child {
        color: var(--privacy-primary);
        font-weight: 600;
    }

    .privacy-breadcrumb i {
        font-size: 10px;
        color: #a0aaa5;
    }

    /* CONTENT */
    .privacy-content {
        padding: 90px 0 110px;
    }

    .privacy-layout {
        display: grid;
        grid-template-columns: 250px 1fr;
        gap: 70px;
        max-width: 1100px;
        margin: auto;
    }

    /* SIDEBAR */
    .privacy-sidebar {
        position: sticky;
        top: 100px;
        align-self: start;
    }

    .privacy-sidebar-title {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: #929b96;
        margin-bottom: 15px;
    }

    .privacy-nav {
        list-style: none;
        padding: 0;
        margin: 0;
        border-left: 1px solid var(--privacy-border);
    }

    .privacy-nav li a {
        display: block;
        padding: 8px 0 8px 18px;
        color: var(--privacy-muted);
        font-size: 13px;
        text-decoration: none;
        border-left: 2px solid transparent;
        margin-left: -1px;
        transition: all .2s ease;
    }

    .privacy-nav li a:hover {
        color: var(--privacy-primary);
        border-left-color: var(--privacy-accent);
    }

    /* DOCUMENT */
    .privacy-document {
        max-width: 760px;
    }

    .privacy-intro {
        padding-bottom: 35px;
        margin-bottom: 10px;
        border-bottom: 1px solid var(--privacy-border);
    }

    .privacy-intro p {
        font-size: 16px;
    }

    .privacy-section {
        padding: 38px 0;
        border-bottom: 1px solid var(--privacy-border);
    }

    .privacy-section:last-child {
        border-bottom: 0;
    }

    .privacy-section-number {
        display: block;
        color: var(--privacy-accent);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .privacy-section h2 {
        font-size: 23px;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--privacy-text);
    }

    .privacy-section p {
        font-size: 15px;
        margin-bottom: 15px;
    }

    .privacy-section p:last-child {
        margin-bottom: 0;
    }

    .privacy-list {
        padding: 0;
        margin: 15px 0 0;
        list-style: none;
    }

    .privacy-list li {
        position: relative;
        padding-left: 25px;
        margin-bottom: 12px;
        color: var(--privacy-muted);
        font-size: 15px;
        line-height: 1.7;
    }

    .privacy-list li:before {
        content: "";
        position: absolute;
        width: 6px;
        height: 6px;
        left: 3px;
        top: 10px;
        border-radius: 50%;
        background: var(--privacy-accent);
    }

    /* CONTACT CARD */
    .privacy-contact {
        margin-top: 55px;
        padding: 30px;
        background: var(--privacy-bg);
        border: 1px solid var(--privacy-border);
        border-radius: 14px;
    }

    .privacy-contact-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: var(--privacy-primary);
        color: #fff;
        margin-bottom: 18px;
    }

    .privacy-contact h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .privacy-contact p {
        margin-bottom: 18px;
        font-size: 14px;
    }

    .privacy-contact a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--privacy-primary);
        font-weight: 600;
        text-decoration: none;
        font-size: 14px;
    }

    /* CTA */
    .privacy-cta-section {
        padding: 0 0 100px;
    }

    .privacy-cta {
        position: relative;
        overflow: hidden;
        background: var(--privacy-primary);
        border-radius: 22px;
        padding: 55px 60px;
    }

    .privacy-cta-content {
        position: relative;
        z-index: 2;
        max-width: 680px;
    }

    .privacy-cta h2 {
        color: #fff;
        font-size: clamp(30px, 4vw, 44px);
        line-height: 1.15;
        font-weight: 500;
        letter-spacing: -1px;
        margin: 10px 0 12px;
    }

    .privacy-cta p {
        color: rgba(255,255,255,.7);
        max-width: 570px;
        margin-bottom: 25px;
    }

    .privacy-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        min-height: 50px;
        padding: 0 23px;
        border-radius: 8px;
        background: #fff;
        color: var(--privacy-primary) !important;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all .2s ease;
    }

    .privacy-cta-btn:hover {
        transform: translateY(-2px);
        background: #f2f5f3;
    }

    .privacy-cta-decoration {
        position: absolute;
        width: 280px;
        height: 280px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 50%;
        right: -80px;
        top: -130px;
    }

    .privacy-cta-decoration-two {
        position: absolute;
        width: 180px;
        height: 180px;
        border: 1px solid rgba(255,255,255,.06);
        border-radius: 50%;
        right: 80px;
        bottom: -110px;
    }

    @media (max-width: 991px) {

        .privacy-layout {
            display: block;
        }

        .privacy-sidebar {
            display: none;
        }

        .privacy-content {
            padding: 70px 0 80px;
        }

        .privacy-document {
            max-width: 100%;
        }

        .privacy-cta {
            padding: 45px 35px;
        }
    }

    @media (max-width: 575px) {

        .privacy-hero {
            padding: 65px 0 70px;
        }

        .privacy-content {
            padding: 55px 0 65px;
        }

        .privacy-section {
            padding: 30px 0;
        }

        .privacy-cta {
            border-radius: 16px;
            padding: 35px 25px;
        }
    }
</style>


<div class="privacy-page">

    <!-- =====================================================
         HERO
    ====================================================== -->
    <section class="privacy-hero">

        <div class="container">

            <div class="privacy-eyebrow">
                Privacy & Security
            </div>

            <h1>
                Privacy Policy
            </h1>

            <p>
                Learn how we collect, use and protect information
                when you use our service marketplace.
            </p>

            <ul class="privacy-breadcrumb">

                <li>
                    <a href="{{ url('/') }}">
                        Home
                    </a>
                </li>

                <li>
                    <i class="bi bi-chevron-right"></i>
                </li>

                <li>
                    Privacy Policy
                </li>

            </ul>

        </div>

    </section>


    <!-- =====================================================
         POLICY CONTENT
    ====================================================== -->
    <section class="privacy-content">

        <div class="container">

            <div class="privacy-layout">

                <!-- SIDEBAR -->
                <aside class="privacy-sidebar">

                    <div class="privacy-sidebar-title">
                        On this page
                    </div>

                    <ul class="privacy-nav">

                        <li>
                            <a href="#information">
                                Information Collection
                            </a>
                        </li>

                        <li>
                            <a href="#use">
                                Use of Information
                            </a>
                        </li>

                        <li>
                            <a href="#security">
                                Information Security
                            </a>
                        </li>

                        <li>
                            <a href="#changes">
                                Policy Changes
                            </a>
                        </li>

                        <li>
                            <a href="#children">
                                Children's Privacy
                            </a>
                        </li>

                        <li>
                            <a href="#third-party">
                                Third-Party Links
                            </a>
                        </li>

                    </ul>

                </aside>


                <!-- DOCUMENT -->
                <main class="privacy-document">

                    <div class="privacy-intro">

                        <p>
                            We respect your privacy and are committed to
                            protecting the information you share with us.
                            This policy explains how information is handled
                            when you use our marketplace.
                        </p>

                    </div>


                    <!-- INFORMATION -->
                    <section class="privacy-section" id="information">

                        <span class="privacy-section-number">
                            01
                        </span>

                        <h2>
                            Information Collection
                        </h2>

                        <p>
                            We may collect information that you provide
                            when creating an account, creating a provider
                            profile, requesting a service or communicating
                            through the platform.
                        </p>

                        <p>
                            This may include:
                        </p>

                        <ul class="privacy-list">

                            <li>
                                Name and contact information
                            </li>

                            <li>
                                Business or service information
                            </li>

                            <li>
                                Location information provided by you
                            </li>

                            <li>
                                Account and profile information
                            </li>

                            <li>
                                Information related to your use of the platform
                            </li>

                        </ul>

                    </section>


                    <!-- USE -->
                    <section class="privacy-section" id="use">

                        <span class="privacy-section-number">
                            02
                        </span>

                        <h2>
                            Use of Information
                        </h2>

                        <p>
                            Information is used to operate and improve
                            the marketplace and to provide a better
                            experience for customers and service providers.
                        </p>

                        <ul class="privacy-list">

                            <li>
                                Provide and maintain the platform
                            </li>

                            <li>
                                Connect customers with service providers
                            </li>

                            <li>
                                Improve services and platform functionality
                            </li>

                            <li>
                                Communicate important account information
                            </li>

                            <li>
                                Provide relevant notifications and updates
                            </li>

                        </ul>

                    </section>


                    <!-- SECURITY -->
                    <section class="privacy-section" id="security">

                        <span class="privacy-section-number">
                            03
                        </span>

                        <h2>
                            Information Security
                        </h2>

                        <p>
                            We take reasonable measures to protect
                            information stored through the platform
                            against unauthorized access, alteration,
                            disclosure or destruction.
                        </p>

                        <p>
                            Your account is protected by your login
                            credentials. You are responsible for keeping
                            your password confidential and signing out
                            when using a shared device.
                        </p>

                    </section>


                    <!-- CHANGES -->
                    <section class="privacy-section" id="changes">

                        <span class="privacy-section-number">
                            04
                        </span>

                        <h2>
                            Changes to This Policy
                        </h2>

                        <p>
                            We may update this Privacy Policy as the
                            platform develops or when our practices change.
                        </p>

                        <p>
                            When material changes are made, we will take
                            reasonable steps to communicate the update.
                            We encourage users to review this page
                            periodically.
                        </p>

                    </section>


                    <!-- CHILDREN -->
                    <section class="privacy-section" id="children">

                        <span class="privacy-section-number">
                            05
                        </span>

                        <h2>
                            Children's Privacy
                        </h2>

                        <p>
                            Our marketplace is intended for a general
                            audience and is not directed toward children
                            under 18.
                        </p>

                        <p>
                            We do not knowingly collect personal information
                            from children in circumstances where such
                            collection is prohibited by applicable law.
                        </p>

                    </section>


                    <!-- THIRD PARTY -->
                    <section class="privacy-section" id="third-party">

                        <span class="privacy-section-number">
                            06
                        </span>

                        <h2>
                            Third-Party Links
                        </h2>

                        <p>
                            Our platform may contain links to websites
                            or services operated by third parties.
                            These platforms have their own privacy policies
                            and practices.
                        </p>

                        <p>
                            We recommend reviewing the privacy policy of
                            any third-party service you choose to visit.
                        </p>

                    </section>


                    <!-- CONTACT -->
                    <div class="privacy-contact">

                        <div class="privacy-contact-icon">
                            <i class="bi bi-envelope"></i>
                        </div>

                        <h4>
                            Questions about privacy?
                        </h4>

                        <p>
                            If you have questions about this policy or
                            how your information is handled, our team
                            is available to help.
                        </p>

                        <a href="{{ route('home.contact') }}">
                            Contact our team
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                </main>

            </div>

        </div>

    </section>


    <!-- =====================================================
         CTA
    ====================================================== -->
    <section class="privacy-cta-section">

        <div class="container">

            <div class="privacy-cta">

                <div class="privacy-cta-decoration"></div>
                <div class="privacy-cta-decoration-two"></div>

                <div class="privacy-cta-content">

                    <div class="privacy-eyebrow"
                         style="color:#b7d5c8;">
                        Need help?
                    </div>

                    <h2>
                        Have a question about your privacy?
                    </h2>

                    <p>
                        We're here to help you understand how your
                        information is handled on the marketplace.
                    </p>

                    <a href="{{ route('home.contact') }}"
                       class="privacy-cta-btn">

                        Contact Us

                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection