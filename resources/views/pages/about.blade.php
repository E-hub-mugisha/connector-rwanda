@extends('layouts.base')

@section('title', 'About Us')

@section('content')

<style>
    :root {
        --market-primary: #254035;
        --market-primary-soft: #eef4f1;
        --market-accent: #6B9080;
        --market-text: #18231e;
        --market-muted: #6f7b75;
        --market-border: #e8ece9;
        --market-bg: #f8faf9;
        --market-white: #ffffff;
    }

    .market-about {
        color: var(--market-text);
        overflow: hidden;
    }

    .market-about p {
        color: var(--market-muted);
        line-height: 1.75;
    }

    .market-section {
        padding: 110px 0;
    }

    .market-section-soft {
        background: var(--market-bg);
    }

    .market-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--market-accent);
    }

    .market-eyebrow:before {
        content: "";
        width: 25px;
        height: 1px;
        background: var(--market-accent);
    }

    .market-title {
        font-size: clamp(34px, 4vw, 52px);
        line-height: 1.12;
        font-weight: 500;
        letter-spacing: -1.5px;
        color: var(--market-text);
    }

    .market-title-sm {
        font-size: clamp(30px, 3vw, 42px);
        line-height: 1.15;
        font-weight: 500;
        letter-spacing: -1px;
    }

    /* HERO */
    .market-hero {
        position: relative;
        background: var(--market-bg);
        padding: 100px 0 115px;
    }

    .market-hero-content {
        max-width: 850px;
        margin: auto;
        text-align: center;
    }

    .market-hero h1 {
        font-size: clamp(42px, 6vw, 72px);
        line-height: 1.03;
        letter-spacing: -3px;
        font-weight: 500;
        margin: 18px 0 25px;
        color: var(--market-text);
    }

    .market-hero h1 span {
        color: var(--market-accent);
    }

    .market-hero-description {
        max-width: 650px;
        margin: auto;
        font-size: 18px;
        line-height: 1.7;
        color: var(--market-muted);
    }

    .market-hero-actions {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 35px;
    }

    .market-btn-primary,
    .market-btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 52px;
        padding: 0 25px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all .25s ease;
    }

    .market-btn-primary {
        background: var(--market-primary);
        color: #fff !important;
    }

    .market-btn-primary:hover {
        background: #1d3329;
        transform: translateY(-2px);
    }

    .market-btn-secondary {
        background: #fff;
        color: var(--market-text) !important;
        border: 1px solid var(--market-border);
    }

    .market-btn-secondary:hover {
        border-color: var(--market-accent);
        color: var(--market-primary) !important;
    }

    .market-hero-meta {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 22px;
        flex-wrap: wrap;
        margin-top: 28px;
        font-size: 13px;
        color: var(--market-muted);
    }

    .market-hero-meta span {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .market-hero-meta i {
        color: var(--market-accent);
    }

    /* INTRO */
    .market-intro {
        max-width: 700px;
    }

    .market-intro p {
        font-size: 17px;
    }

    .market-intro-side {
        padding-left: 40px;
    }

    .market-mini-point {
        display: flex;
        gap: 15px;
        padding: 18px 0;
        border-bottom: 1px solid var(--market-border);
    }

    .market-mini-point:last-child {
        border-bottom: 0;
    }

    .market-mini-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: var(--market-primary-soft);
        color: var(--market-primary);
    }

    .market-mini-point h6 {
        margin: 0 0 5px;
        font-size: 15px;
        font-weight: 600;
    }

    .market-mini-point p {
        margin: 0;
        font-size: 14px;
        line-height: 1.6;
    }

    /* MARKETPLACE CARDS */
    .marketplace-card {
        position: relative;
        height: 100%;
        padding: 40px;
        border: 1px solid var(--market-border);
        border-radius: 18px;
        background: #fff;
        transition: all .3s ease;
        overflow: hidden;
    }

    .marketplace-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(37, 64, 53, .08);
        border-color: #dce5e0;
    }

    .marketplace-card.provider {
        background: var(--market-primary);
        border-color: var(--market-primary);
    }

    .market-card-icon {
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: var(--market-primary-soft);
        color: var(--market-primary);
        font-size: 23px;
        margin-bottom: 28px;
    }

    .provider .market-card-icon {
        background: rgba(255,255,255,.1);
        color: #fff;
    }

    .marketplace-card .small-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.3px;
        text-transform: uppercase;
        color: var(--market-accent);
    }

    .provider .small-label {
        color: rgba(255,255,255,.7);
    }

    .marketplace-card h3 {
        font-size: 28px;
        font-weight: 500;
        margin: 8px 0 15px;
    }

    .provider h3 {
        color: #fff;
    }

    .marketplace-card > p {
        margin-bottom: 25px;
    }

    .provider > p {
        color: rgba(255,255,255,.7);
    }

    .market-check-list {
        padding: 0;
        margin: 0 0 30px;
        list-style: none;
    }

    .market-check-list li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 13px;
        font-size: 14px;
        color: var(--market-muted);
    }

    .provider .market-check-list li {
        color: rgba(255,255,255,.8);
    }

    .market-check-list i {
        color: var(--market-accent);
        margin-top: 2px;
    }

    .provider .market-check-list i {
        color: #b7d5c8;
    }

    .market-card-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        color: var(--market-primary);
    }

    .provider .market-card-link {
        color: #fff;
    }

    .market-card-link i {
        transition: transform .2s ease;
    }

    .market-card-link:hover i {
        transform: translateX(4px);
    }

    /* HOW IT WORKS */
    .process-wrapper {
        position: relative;
    }

    .process-line {
        position: absolute;
        top: 31px;
        left: 16%;
        right: 16%;
        border-top: 1px dashed #ccd7d1;
    }

    .process-item {
        position: relative;
        text-align: center;
        padding: 0 20px;
    }

    .process-number {
        position: relative;
        z-index: 2;
        width: 62px;
        height: 62px;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #dce5e0;
        color: var(--market-primary);
        font-size: 17px;
        font-weight: 600;
    }

    .process-item h5 {
        margin: 22px 0 9px;
        font-size: 17px;
        font-weight: 600;
    }

    .process-item p {
        max-width: 220px;
        margin: auto;
        font-size: 14px;
    }

    /* FEATURES */
    .benefit-item {
        padding: 28px 0;
        border-top: 1px solid var(--market-border);
    }

    .benefit-number {
        font-size: 12px;
        color: var(--market-accent);
        font-weight: 700;
        letter-spacing: 1px;
    }

    .benefit-item h5 {
        font-size: 18px;
        font-weight: 600;
        margin: 10px 0 7px;
    }

    .benefit-item p {
        margin: 0;
        font-size: 14px;
    }

    /* TESTIMONIALS */
    .testimonial-header {
        max-width: 650px;
    }

    .testimonial-card {
        height: 100%;
        padding: 32px;
        background: #fff;
        border: 1px solid var(--market-border);
        border-radius: 16px;
    }

    .testimonial-quote {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--market-primary-soft);
        color: var(--market-primary);
        margin-bottom: 22px;
    }

    .testimonial-message {
        color: var(--market-text) !important;
        font-size: 15px;
        line-height: 1.8;
        margin-bottom: 28px;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .testimonial-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--market-primary-soft);
        color: var(--market-primary);
        font-weight: 600;
    }

    .testimonial-author strong {
        display: block;
        font-size: 14px;
    }

    .testimonial-author span {
        display: block;
        color: var(--market-muted);
        font-size: 12px;
        margin-top: 2px;
    }

    /* PARTNERS */
    .trusted-section {
        padding: 65px 0;
        border-top: 1px solid var(--market-border);
        border-bottom: 1px solid var(--market-border);
    }

    .trusted-title {
        text-align: center;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #8a948f;
        margin-bottom: 35px;
    }

    .trusted-logos {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 55px;
        flex-wrap: wrap;
    }

    .trusted-logos > * {
        opacity: .65;
        filter: grayscale(100%);
        transition: all .2s ease;
    }

    .trusted-logos > *:hover {
        opacity: 1;
        filter: grayscale(0);
    }

    /* CTA */
    .market-cta-section {
        padding: 100px 0;
    }

    .market-cta {
        position: relative;
        overflow: hidden;
        background: var(--market-primary);
        border-radius: 24px;
        padding: 65px 70px;
    }

    .market-cta:after {
        content: "";
        position: absolute;
        width: 300px;
        height: 300px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 50%;
        right: -100px;
        top: -120px;
    }

    .market-cta:before {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border: 1px solid rgba(255,255,255,.06);
        border-radius: 50%;
        right: 60px;
        bottom: -100px;
    }

    .market-cta-content {
        position: relative;
        z-index: 2;
        max-width: 650px;
    }

    .market-cta h2 {
        color: #fff;
        font-size: clamp(32px, 4vw, 48px);
        line-height: 1.15;
        font-weight: 500;
        letter-spacing: -1.2px;
        margin: 10px 0 15px;
    }

    .market-cta p {
        color: rgba(255,255,255,.7);
        max-width: 580px;
        margin-bottom: 28px;
    }

    .market-cta .market-btn-primary {
        background: #fff;
        color: var(--market-primary) !important;
    }

    .market-cta .market-btn-primary:hover {
        background: #f1f4f2;
    }

    .market-cta .market-btn-secondary {
        background: transparent;
        border-color: rgba(255,255,255,.25);
        color: #fff !important;
    }

    .market-cta .market-btn-secondary:hover {
        border-color: #fff;
    }

    /* RESPONSIVE */
    @media (max-width: 991px) {

        .market-section {
            padding: 80px 0;
        }

        .market-hero {
            padding: 75px 0 85px;
        }

        .market-intro-side {
            padding-left: 0;
            margin-top: 40px;
        }

        .process-line {
            display: none;
        }

        .marketplace-card {
            padding: 30px;
        }

        .market-cta {
            padding: 50px 35px;
        }
    }

    @media (max-width: 575px) {

        .market-hero h1 {
            letter-spacing: -1.8px;
        }

        .market-hero-description {
            font-size: 16px;
        }

        .market-hero-meta {
            gap: 12px;
        }

        .market-btn-primary,
        .market-btn-secondary {
            width: 100%;
        }

        .marketplace-card {
            padding: 27px;
            border-radius: 14px;
        }

        .market-cta {
            border-radius: 18px;
            padding: 40px 25px;
        }

        .trusted-logos {
            gap: 25px;
        }
    }
</style>


<div class="market-about">

    <!-- =====================================================
         HERO
    ====================================================== -->
    <section class="market-hero">

        <div class="container">

            <div class="market-hero-content">

                <div class="market-eyebrow">
                    Service Marketplace
                </div>

                <h1>
                    Find services.<br>
                    <span>Meet trusted providers.</span>
                </h1>

                <p class="market-hero-description">
                    A simple marketplace that brings customers and
                    service providers together — making it easier to
                    discover, connect and get things done.
                </p>

                <div class="market-hero-actions">

                    <a href="{{ route('home.services') }}"
                       class="market-btn-primary">
                        Explore Services
                        <i class="bi bi-arrow-right"></i>
                    </a>

                    <a href="{{ route('register') }}"
                       class="market-btn-secondary">
                        Become a Provider
                    </a>

                </div>

                <div class="market-hero-meta">

                    <span>
                        <i class="bi bi-check-circle-fill"></i>
                        Discover services
                    </span>

                    <span>
                        <i class="bi bi-check-circle-fill"></i>
                        Compare providers
                    </span>

                    <span>
                        <i class="bi bi-check-circle-fill"></i>
                        Connect directly
                    </span>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         ABOUT
    ====================================================== -->
    <section class="market-section">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6">

                    <div class="market-intro">

                        <span class="market-eyebrow">
                            About the platform
                        </span>

                        <h2 class="market-title mt-15 mb-25">
                            A better way to find and offer services.
                        </h2>

                        <p>
                            We bring customers and service providers
                            together through one easy-to-use marketplace.
                        </p>

                        <p class="mb-0">
                            Customers can discover services and connect
                            with providers, while professionals can
                            showcase their expertise and reach new clients.
                        </p>

                    </div>

                </div>


                <div class="col-lg-5 ms-auto">

                    <div class="market-intro-side">

                        <div class="market-mini-point">

                            <div class="market-mini-icon">
                                <i class="bi bi-search"></i>
                            </div>

                            <div>
                                <h6>Discover</h6>
                                <p>
                                    Find services based on what you need.
                                </p>
                            </div>

                        </div>


                        <div class="market-mini-point">

                            <div class="market-mini-icon">
                                <i class="bi bi-person-lines-fill"></i>
                            </div>

                            <div>
                                <h6>Explore providers</h6>
                                <p>
                                    Understand who offers the service
                                    before connecting.
                                </p>
                            </div>

                        </div>


                        <div class="market-mini-point">

                            <div class="market-mini-icon">
                                <i class="bi bi-chat-dots"></i>
                            </div>

                            <div>
                                <h6>Connect</h6>
                                <p>
                                    Discuss your requirements directly
                                    with the provider.
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         TWO SIDED MARKETPLACE
    ====================================================== -->
    <section class="market-section market-section-soft">

        <div class="container">

            <div class="row justify-content-center text-center">

                <div class="col-xl-7 col-lg-8">

                    <span class="market-eyebrow">
                        One marketplace
                    </span>

                    <h2 class="market-title-sm mt-15">
                        Built for people who need services
                        and those who provide them.
                    </h2>

                </div>

            </div>


            <div class="row mt-55">

                <!-- CUSTOMER -->
                <div class="col-lg-6 mb-30">

                    <div class="marketplace-card">

                        <div class="market-card-icon">
                            <i class="bi bi-person"></i>
                        </div>

                        <span class="small-label">
                            For customers
                        </span>

                        <h3>
                            Find the right service
                        </h3>

                        <p>
                            Discover professionals and businesses
                            offering the services you need.
                        </p>

                        <ul class="market-check-list">

                            <li>
                                <i class="bi bi-check2-circle"></i>
                                Browse services by category
                            </li>

                            <li>
                                <i class="bi bi-check2-circle"></i>
                                Explore provider profiles
                            </li>

                            <li>
                                <i class="bi bi-check2-circle"></i>
                                Compare available options
                            </li>

                            <li>
                                <i class="bi bi-check2-circle"></i>
                                Connect and arrange your service
                            </li>

                        </ul>

                        <a href="{{ route('home.services') }}"
                           class="market-card-link">
                            Explore services
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                </div>


                <!-- PROVIDER -->
                <div class="col-lg-6 mb-30">

                    <div class="marketplace-card provider">

                        <div class="market-card-icon">
                            <i class="bi bi-briefcase"></i>
                        </div>

                        <span class="small-label">
                            For providers
                        </span>

                        <h3>
                            Put your expertise to work
                        </h3>

                        <p>
                            Create your presence, showcase your services
                            and connect with people looking for your expertise.
                        </p>

                        <ul class="market-check-list">

                            <li>
                                <i class="bi bi-check2-circle"></i>
                                Create your professional profile
                            </li>

                            <li>
                                <i class="bi bi-check2-circle"></i>
                                Showcase your services
                            </li>

                            <li>
                                <i class="bi bi-check2-circle"></i>
                                Reach potential customers
                            </li>

                            <li>
                                <i class="bi bi-check2-circle"></i>
                                Manage inquiries and bookings
                            </li>

                        </ul>

                        <a href="{{ route('register') }}"
                           class="market-card-link">
                            Become a provider
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         HOW IT WORKS
    ====================================================== -->
    <section class="market-section">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-xl-6 col-lg-8 text-center">

                    <span class="market-eyebrow">
                        How it works
                    </span>

                    <h2 class="market-title-sm mt-15">
                        Simple from search to service.
                    </h2>

                </div>

            </div>


            <div class="process-wrapper mt-60">

                <div class="process-line"></div>

                <div class="row">

                    <div class="col-lg-4 mb-40">

                        <div class="process-item">

                            <div class="process-number">
                                01
                            </div>

                            <h5>
                                Search
                            </h5>

                            <p>
                                Find the service that matches
                                what you need.
                            </p>

                        </div>

                    </div>


                    <div class="col-lg-4 mb-40">

                        <div class="process-item">

                            <div class="process-number">
                                02
                            </div>

                            <h5>
                                Choose
                            </h5>

                            <p>
                                Explore providers and select
                                an option that fits.
                            </p>

                        </div>

                    </div>


                    <div class="col-lg-4 mb-40">

                        <div class="process-item">

                            <div class="process-number">
                                03
                            </div>

                            <h5>
                                Connect
                            </h5>

                            <p>
                                Contact the provider and
                                arrange the service.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         BENEFITS
    ====================================================== -->
    <section class="market-section market-section-soft">

        <div class="container">

            <div class="row">

                <div class="col-lg-5 mb-40">

                    <span class="market-eyebrow">
                        Why the marketplace
                    </span>

                    <h2 class="market-title-sm mt-15">
                        Designed around real service connections.
                    </h2>

                    <p class="mt-20">
                        Everything is focused on making the journey
                        between customers and providers clearer and simpler.
                    </p>

                </div>


                <div class="col-lg-6 ms-auto">

                    <div class="benefit-item">

                        <span class="benefit-number">
                            01
                        </span>

                        <h5>
                            More choice
                        </h5>

                        <p>
                            Explore different services and providers
                            from one marketplace.
                        </p>

                    </div>


                    <div class="benefit-item">

                        <span class="benefit-number">
                            02
                        </span>

                        <h5>
                            Better visibility
                        </h5>

                        <p>
                            Providers can present their skills,
                            experience and services professionally.
                        </p>

                    </div>


                    <div class="benefit-item">

                        <span class="benefit-number">
                            03
                        </span>

                        <h5>
                            Direct communication
                        </h5>

                        <p>
                            Customers and providers can connect
                            around their specific requirements.
                        </p>

                    </div>


                    <div class="benefit-item">

                        <span class="benefit-number">
                            04
                        </span>

                        <h5>
                            Reviews and feedback
                        </h5>

                        <p>
                            Customer feedback helps users understand
                            previous experiences.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         TESTIMONIALS
    ====================================================== -->
    @if(isset($feedbacks) && $feedbacks->count())

    <section class="market-section">

        <div class="container">

            <div class="row align-items-end mb-50">

                <div class="col-lg-7">

                    <div class="testimonial-header">

                        <span class="market-eyebrow">
                            Community feedback
                        </span>

                        <h2 class="market-title-sm mt-15 mb-0">
                            Experiences from our community.
                        </h2>

                    </div>

                </div>

            </div>


            <div class="row g-4">

                @foreach($feedbacks->take(3) as $feedback)

                <div class="col-lg-4 col-md-6">

                    <div class="testimonial-card">

                        <div class="testimonial-quote">
                            <i class="bi bi-quote"></i>
                        </div>

                        <p class="testimonial-message">
                            “{{ $feedback->message }}”
                        </p>

                        <div class="testimonial-author">

                            <div class="testimonial-avatar">
                                {{ strtoupper(substr($feedback->name, 0, 1)) }}
                            </div>

                            <div>

                                <strong>
                                    {{ $feedback->name }}
                                </strong>

                                <span>
                                    Marketplace user
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </section>

    @endif


    <!-- =====================================================
         TRUSTED PARTNERS
    ====================================================== -->
    <section class="trusted-section">

        <div class="container">

            <div class="trusted-title">
                Trusted by our growing ecosystem
            </div>

            <div class="trusted-logos">

                @include('includes.brands')

            </div>

        </div>

    </section>


    <!-- =====================================================
         CTA
    ====================================================== -->
    <section class="market-cta-section">

        <div class="container">

            <div class="market-cta">

                <div class="market-cta-content">

                    <span class="market-eyebrow" style="color:#b7d5c8;">
                        Get started
                    </span>

                    <h2>
                        Your next service starts here.
                    </h2>

                    <p>
                        Looking for a professional or ready to offer
                        your expertise? Join the marketplace and make
                        the connection.
                    </p>

                    <div class="market-hero-actions"
                         style="justify-content:flex-start;">

                        <a href="{{ route('home.services') }}"
                           class="market-btn-primary">
                            Find a Service
                            <i class="bi bi-arrow-right"></i>
                        </a>

                        <a href="{{ route('register') }}"
                           class="market-btn-secondary">
                            Join as a Provider
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection