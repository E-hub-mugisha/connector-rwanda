@extends('layouts.base')

@section('title', 'Service Categories')

@section('content')

<style>
    :root {
        --market-primary: #6B9080;
        --market-primary-dark: #254035;
        --market-primary-light: #EAF1EE;
        --market-bg: #F7FAF8;
        --market-border: #E2EAE6;
        --market-text: #254035;
        --market-muted: #718078;
        --market-white: #ffffff;
        --market-shadow: 0 15px 45px rgba(37, 64, 53, 0.08);
        --market-shadow-hover: 0 20px 55px rgba(37, 64, 53, 0.14);
        --market-radius: 18px;
    }

    /* ================================
       GLOBAL
    ================================= */

    .service-marketplace {
        background: var(--market-white);
        color: var(--market-text);
    }

    .service-marketplace a {
        text-decoration: none;
    }

    .service-marketplace .container {
        position: relative;
        z-index: 2;
    }

    .market-section {
        padding: 95px 0;
    }

    .market-section.soft-bg {
        background: var(--market-bg);
    }

    .market-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 13px;
        border-radius: 50px;
        background: var(--market-primary-light);
        color: var(--market-primary-dark);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .market-eyebrow .dot {
        width: 7px;
        height: 7px;
        background: var(--market-primary);
        border-radius: 50%;
    }

    .market-heading {
        color: var(--market-primary-dark);
        font-size: clamp(30px, 4vw, 46px);
        line-height: 1.15;
        font-weight: 700;
        letter-spacing: -1.3px;
        margin: 14px 0 15px;
    }

    .market-heading span {
        color: var(--market-primary);
    }

    .market-description {
        max-width: 650px;
        color: var(--market-muted);
        font-size: 16px;
        line-height: 1.8;
    }

    /* ================================
       HERO
    ================================= */

    .service-hero {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at 85% 20%, rgba(107, 144, 128, .22), transparent 30%),
            linear-gradient(135deg, #254035 0%, #315447 55%, #6B9080 140%);
        padding: 105px 0 110px;
    }

    .service-hero::before {
        content: "";
        position: absolute;
        width: 450px;
        height: 450px;
        border: 1px solid rgba(255,255,255,.10);
        border-radius: 50%;
        right: -160px;
        top: -160px;
    }

    .service-hero::after {
        content: "";
        position: absolute;
        width: 300px;
        height: 300px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 50%;
        left: -150px;
        bottom: -170px;
    }

    .hero-content {
        max-width: 850px;
        margin: auto;
        text-align: center;
        position: relative;
        z-index: 3;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border-radius: 50px;
        background: rgba(255,255,255,.11);
        border: 1px solid rgba(255,255,255,.17);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }

    .hero-badge i {
        color: #C8DED4;
    }

    .hero-title {
        color: #fff;
        font-size: clamp(38px, 5vw, 64px);
        line-height: 1.05;
        font-weight: 750;
        letter-spacing: -2px;
        margin: 22px 0 18px;
    }

    .hero-title span {
        color: #BFD5CB;
    }

    .hero-text {
        max-width: 680px;
        margin: 0 auto;
        color: rgba(255,255,255,.78);
        font-size: 17px;
        line-height: 1.8;
    }

    .hero-search {
        max-width: 700px;
        margin: 35px auto 0;
        padding: 8px;
        display: flex;
        align-items: center;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 20px 50px rgba(0,0,0,.16);
    }

    .hero-search .search-icon {
        width: 50px;
        text-align: center;
        color: var(--market-primary);
        font-size: 19px;
    }

    .hero-search input {
        flex: 1;
        border: 0;
        outline: 0;
        background: transparent;
        color: var(--market-primary-dark);
        height: 52px;
        font-size: 15px;
    }

    .hero-search input::placeholder {
        color: #9AA7A1;
    }

    .hero-search-btn {
        border: 0;
        min-height: 52px;
        padding: 0 25px;
        border-radius: 11px;
        background: var(--market-primary-dark);
        color: #fff;
        font-weight: 700;
        transition: .25s ease;
    }

    .hero-search-btn:hover {
        background: var(--market-primary);
        color: #fff;
        transform: translateY(-1px);
    }

    .hero-stats {
        margin-top: 38px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 35px;
        color: rgba(255,255,255,.8);
    }

    .hero-stat {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 13px;
    }

    .hero-stat i {
        color: #C8DED4;
    }

    .hero-divider {
        width: 1px;
        height: 24px;
        background: rgba(255,255,255,.18);
    }

    /* ================================
       CATEGORY SECTION
    ================================= */

    .categories-section {
        padding: 100px 0;
        background: #fff;
    }

    .section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 48px;
    }

    .section-header-content {
        max-width: 700px;
    }

    .view-all-btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 12px 18px;
        border-radius: 10px;
        border: 1px solid var(--market-border);
        color: var(--market-primary-dark);
        background: #fff;
        font-size: 14px;
        font-weight: 700;
        transition: .25s ease;
        white-space: nowrap;
    }

    .view-all-btn:hover {
        background: var(--market-primary-dark);
        color: #fff;
        border-color: var(--market-primary-dark);
        transform: translateY(-2px);
    }

    .category-group {
        margin-bottom: 70px;
    }

    .category-group:last-child {
        margin-bottom: 0;
    }

    .category-group-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .category-group-title {
        display: flex;
        align-items: center;
        gap: 13px;
        margin: 0;
        color: var(--market-primary-dark);
        font-size: 23px;
        font-weight: 700;
        letter-spacing: -.4px;
    }

    .category-group-title-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 43px;
        height: 43px;
        border-radius: 12px;
        background: var(--market-primary-light);
        color: var(--market-primary-dark);
    }

    .category-group-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: var(--market-primary);
        font-size: 13px;
        font-weight: 700;
        transition: .2s ease;
    }

    .category-group-link:hover {
        color: var(--market-primary-dark);
        gap: 10px;
    }

    /* ================================
       CATEGORY CARDS
    ================================= */

    .category-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 15px;
    }

    .category-card {
        position: relative;
        min-height: 155px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 20px;
        border: 1px solid var(--market-border);
        border-radius: var(--market-radius);
        background: #fff;
        overflow: hidden;
        transition: .3s ease;
    }

    .category-card::before {
        content: "";
        position: absolute;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: var(--market-primary-light);
        right: -35px;
        bottom: -35px;
        transition: .3s ease;
    }

    .category-card:hover {
        border-color: rgba(107,144,128,.45);
        box-shadow: var(--market-shadow-hover);
        transform: translateY(-5px);
    }

    .category-card:hover::before {
        width: 130px;
        height: 130px;
        background: rgba(107,144,128,.16);
    }

    .category-icon {
        position: relative;
        z-index: 1;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: var(--market-primary-light);
        color: var(--market-primary-dark);
        font-size: 17px;
        transition: .25s ease;
    }

    .category-card:hover .category-icon {
        background: var(--market-primary);
        color: #fff;
    }

    .category-name {
        position: relative;
        z-index: 1;
        color: var(--market-primary-dark);
        font-size: 14px;
        line-height: 1.45;
        font-weight: 700;
        margin-top: 17px;
        padding-right: 8px;
    }

    .category-arrow {
        position: absolute;
        z-index: 2;
        right: 17px;
        bottom: 17px;
        color: var(--market-primary);
        font-size: 13px;
        opacity: 0;
        transform: translateX(-5px);
        transition: .25s ease;
    }

    .category-card:hover .category-arrow {
        opacity: 1;
        transform: translateX(0);
    }

    /* ================================
       PROVIDERS SECTION
    ================================= */

    .providers-section {
        position: relative;
        padding: 100px 0;
        background: var(--market-bg);
        overflow: hidden;
    }

    .providers-section::before {
        content: "";
        position: absolute;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        border: 1px solid rgba(107,144,128,.12);
        left: -260px;
        top: 50px;
    }

    .provider-heading {
        text-align: center;
        max-width: 680px;
        margin: 0 auto 50px;
    }

    .provider-heading .market-description {
        margin-left: auto;
        margin-right: auto;
    }

    .provider-list {
        max-width: 1000px;
        margin: 0 auto;
        display: grid;
        gap: 14px;
    }

    .provider-card {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 18px;
        border: 1px solid var(--market-border);
        border-radius: 17px;
        background: #fff;
        transition: .3s ease;
    }

    .provider-card:hover {
        transform: translateY(-3px);
        border-color: rgba(107,144,128,.4);
        box-shadow: var(--market-shadow);
    }

    .provider-avatar {
        flex: 0 0 65px;
        width: 65px;
        height: 65px;
        border-radius: 15px;
        overflow: hidden;
        background: var(--market-primary-light);
    }

    .provider-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .provider-details {
        flex: 1;
        min-width: 0;
    }

    .provider-name {
        margin: 0 0 4px;
        color: var(--market-primary-dark);
        font-size: 16px;
        font-weight: 750;
    }

    .provider-name a {
        color: inherit;
    }

    .provider-category {
        color: var(--market-primary);
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .provider-location {
        display: flex;
        align-items: center;
        gap: 5px;
        color: var(--market-muted);
        font-size: 12px;
    }

    .provider-location i {
        color: var(--market-primary);
    }

    .provider-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 50px;
        background: #EDF6F1;
        color: #387052;
        font-size: 11px;
        font-weight: 700;
    }

    .provider-status span {
        width: 6px;
        height: 6px;
        background: #4F9B6E;
        border-radius: 50%;
    }

    .provider-view-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 11px 16px;
        border: 1px solid var(--market-border);
        border-radius: 10px;
        color: var(--market-primary-dark);
        font-size: 13px;
        font-weight: 700;
        transition: .25s ease;
    }

    .provider-view-btn:hover {
        background: var(--market-primary-dark);
        border-color: var(--market-primary-dark);
        color: #fff;
    }

    .provider-empty {
        padding: 45px 25px;
        border: 1px dashed #CBD8D2;
        border-radius: 18px;
        text-align: center;
        background: #fff;
        color: var(--market-muted);
    }

    .provider-empty i {
        display: block;
        font-size: 32px;
        color: var(--market-primary);
        margin-bottom: 10px;
    }

    /* ================================
       HOW IT WORKS
    ================================= */

    .how-section {
        padding: 100px 0;
        background: #fff;
    }

    .how-header {
        text-align: center;
        max-width: 650px;
        margin: 0 auto 55px;
    }

    .steps-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    .step-card {
        position: relative;
        padding: 35px 30px;
        border: 1px solid var(--market-border);
        border-radius: 20px;
        text-align: center;
        transition: .3s ease;
    }

    .step-card:hover {
        box-shadow: var(--market-shadow);
        transform: translateY(-4px);
    }

    .step-number {
        position: absolute;
        top: 20px;
        right: 22px;
        color: #DCE7E2;
        font-size: 30px;
        line-height: 1;
        font-weight: 800;
    }

    .step-icon {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        border-radius: 18px;
        background: var(--market-primary-light);
        color: var(--market-primary-dark);
        font-size: 22px;
    }

    .step-title {
        color: var(--market-primary-dark);
        font-size: 18px;
        font-weight: 750;
        margin-bottom: 9px;
    }

    .step-text {
        color: var(--market-muted);
        font-size: 13px;
        line-height: 1.75;
        margin: 0;
    }

    /* ================================
       PAGINATION
    ================================= */

    .market-pagination {
        margin-top: 60px;
    }

    .market-pagination nav {
        display: flex;
        justify-content: center;
    }

    .market-pagination nav > div:first-child {
        display: none;
    }

    .market-pagination svg {
        width: 18px;
        height: 18px;
    }

    .market-pagination nav div:last-child > span,
    .market-pagination nav div:last-child > a {
        border-radius: 9px;
    }

    /* ================================
       RESPONSIVE
    ================================= */

    @media (max-width: 1199px) {
        .category-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 991px) {
        .market-section,
        .categories-section,
        .providers-section,
        .how-section {
            padding: 75px 0;
        }

        .service-hero {
            padding: 80px 0 85px;
        }

        .category-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .steps-grid {
            grid-template-columns: 1fr;
        }

        .step-card {
            max-width: 600px;
            margin: auto;
            width: 100%;
        }
    }

    @media (max-width: 767px) {
        .service-hero {
            padding: 65px 0 70px;
        }

        .hero-title {
            letter-spacing: -1.2px;
        }

        .hero-search {
            display: block;
            padding: 8px;
        }

        .hero-search .search-icon {
            display: none;
        }

        .hero-search input {
            width: 100%;
            height: 48px;
            padding: 0 12px;
        }

        .hero-search-btn {
            width: 100%;
        }

        .hero-stats {
            flex-wrap: wrap;
            gap: 15px 20px;
        }

        .hero-divider {
            display: none;
        }

        .section-header {
            align-items: flex-start;
            flex-direction: column;
            margin-bottom: 35px;
        }

        .category-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .category-group {
            margin-bottom: 50px;
        }

        .category-group-header {
            align-items: flex-start;
        }

        .category-group-title {
            font-size: 19px;
        }

        .category-group-link {
            font-size: 12px;
        }

        .provider-card {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .provider-details {
            flex: 1 1 calc(100% - 85px);
        }

        .provider-status {
            margin-left: 83px;
            margin-top: -10px;
        }

        .provider-view-btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .category-grid {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .category-card {
            min-height: 140px;
            padding: 16px;
        }

        .category-name {
            font-size: 13px;
        }

        .provider-card {
            padding: 15px;
        }
    }
</style>


<div class="service-marketplace">

    {{-- =========================================================
        HERO / SERVICE DISCOVERY
    ========================================================== --}}
    <section class="service-hero">

        <div class="container">

            <div class="hero-content">

                <div class="hero-badge">
                    <i class="bi bi-stars"></i>
                    Trusted service marketplace
                </div>

                <h1 class="hero-title">
                    Find the right <span>service provider</span> for you.
                </h1>

                <p class="hero-text">
                    Discover trusted professionals and businesses near you.
                    Browse services, compare providers and connect with the
                    right person for your needs.
                </p>

                <form
                    action="{{ route('home.service_provider') }}"
                    method="GET"
                    class="hero-search"
                >
                    <div class="search-icon">
                        <i class="bi bi-search"></i>
                    </div>

                    <input
                        type="text"
                        name="search"
                        placeholder="What service are you looking for?"
                        autocomplete="off"
                    >

                    <button type="submit" class="hero-search-btn">
                        Find Services
                    </button>
                </form>

                <div class="hero-stats">

                    <div class="hero-stat">
                        <i class="bi bi-grid-3x3-gap"></i>
                        <span>Multiple categories</span>
                    </div>

                    <div class="hero-divider"></div>

                    <div class="hero-stat">
                        <i class="bi bi-person-check"></i>
                        <span>Verified providers</span>
                    </div>

                    <div class="hero-divider"></div>

                    <div class="hero-stat">
                        <i class="bi bi-geo-alt"></i>
                        <span>Local services</span>
                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
        CATEGORIES
    ========================================================== --}}
    <section class="categories-section">

        <div class="container">

            <div class="section-header">

                <div class="section-header-content">

                    <div class="market-eyebrow">
                        <span class="dot"></span>
                        Explore services
                    </div>

                    <h2 class="market-heading">
                        Find services for <span>every need.</span>
                    </h2>

                    <p class="market-description">
                        Explore our service categories and discover professionals
                        ready to help. From everyday services to specialized
                        expertise, find what you need in one place.
                    </p>

                </div>

                <a
                    href="{{ route('home.service_categories') }}"
                    class="view-all-btn"
                >
                    View all categories
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>


            {{-- Category groups --}}
            @forelse($scategories as $scategory)

                <div class="category-group">

                    <div class="category-group-header">

                        <h3 class="category-group-title">

                            <span class="category-group-title-icon">
                                <i class="bi bi-grid"></i>
                            </span>

                            {{ $scategory->name }}

                        </h3>

                        <a
                            href="{{ route('home.service_by_category', [
                                'category_slug' => $scategory->slug
                            ]) }}"
                            class="category-group-link"
                        >
                            Explore {{ $scategory->name }}
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>


                    @if($scategory->subcategories && $scategory->subcategories->count())

                        <div class="category-grid">

                            @foreach($scategory->subcategories as $scat)

                                <a
                                    href="{{ route('home.service_by_subcategory', [
                                        'subcategory_slug' => $scat->slug
                                    ]) }}"
                                    class="category-card"
                                >

                                    <div class="category-icon">
                                        <i class="bi bi-briefcase"></i>
                                    </div>

                                    <div class="category-name">
                                        {{ $scat->name }}
                                    </div>

                                    <span class="category-arrow">
                                        <i class="bi bi-arrow-up-right"></i>
                                    </span>

                                </a>

                            @endforeach

                        </div>

                    @else

                        <div class="provider-empty">
                            <i class="bi bi-folder2-open"></i>
                            <p class="mb-0">
                                No services available in this category yet.
                            </p>
                        </div>

                    @endif

                </div>

            @empty

                <div class="provider-empty">
                    <i class="bi bi-search"></i>

                    <h5 style="color: var(--market-primary-dark);">
                        No service categories available
                    </h5>

                    <p class="mb-0">
                        Please check back later for available services.
                    </p>
                </div>

            @endforelse


            {{-- Pagination --}}
            @if(method_exists($scategories, 'links'))

                <div class="market-pagination">
                    {{ $scategories->links() }}
                </div>

            @endif

        </div>

    </section>


    {{-- =========================================================
        SERVICE PROVIDERS
    ========================================================== --}}
    <section class="providers-section">

        <div class="container">

            <div class="provider-heading">

                <div class="market-eyebrow">
                    <span class="dot"></span>
                    Meet professionals
                </div>

                <h2 class="market-heading">
                    Connect with <span>trusted providers.</span>
                </h2>

                <p class="market-description">
                    Find experienced service providers and connect with
                    professionals who can help you get the job done.
                </p>

            </div>


            <div class="provider-list">

                @forelse($sproviders as $sprovider)

                    @if(!empty($sprovider->sprovider_name))

                        <div class="provider-card">

                            {{-- Avatar --}}
                            <div class="provider-avatar">

                                <a
                                    href="{{ route('home.service-provider_profile', [
                                        'sprovider_id' => $sprovider->id
                                    ]) }}"
                                >

                                    @if(!empty($sprovider->image))

                                        <img
                                            src="{{ asset('asset/images/lazy.svg') }}"
                                            data-src="{{ asset('image/profile') }}/{{ $sprovider->image }}"
                                            alt="{{ $sprovider->sprovider_name }}"
                                            class="lazy-img"
                                        >

                                    @else

                                        <img
                                            src="{{ asset('asset/images/lazy.svg') }}"
                                            data-src="{{ asset('asset/images/avatar.png') }}"
                                            alt="{{ $sprovider->sprovider_name }}"
                                            class="lazy-img"
                                        >

                                    @endif

                                </a>

                            </div>


                            {{-- Provider details --}}
                            <div class="provider-details">

                                <h4 class="provider-name">

                                    <a
                                        href="{{ route('home.service-provider_profile', [
                                            'sprovider_id' => $sprovider->id
                                        ]) }}"
                                    >
                                        {{ $sprovider->sprovider_name }}
                                    </a>

                                </h4>


                                <div class="provider-category">

                                    @if($sprovider->service_category_id && $sprovider->category)

                                        {{ $sprovider->category->name }}

                                    @else

                                        Professional Service Provider

                                    @endif

                                </div>


                                <div class="provider-location">

                                    <i class="bi bi-geo-alt"></i>

                                    <span>
                                        {{ $sprovider->city ?: 'Location not specified' }}
                                    </span>

                                </div>

                            </div>


                            {{-- Status --}}
                            <div class="provider-status">

                                <span></span>

                                Available

                            </div>


                            {{-- View profile --}}
                            <a
                                href="{{ route('home.service-provider_profile', [
                                    'sprovider_id' => $sprovider->id
                                ]) }}"
                                class="provider-view-btn"
                            >

                                View Profile

                                <i class="bi bi-arrow-right"></i>

                            </a>

                        </div>

                    @endif

                @empty

                    <div class="provider-empty">

                        <i class="bi bi-people"></i>

                        <h5 style="color: var(--market-primary-dark);">
                            No service providers found
                        </h5>

                        <p class="mb-0">
                            New professionals will appear here as they join
                            the platform.
                        </p>

                    </div>

                @endforelse

            </div>


            <div class="text-center mt-45">

                <a
                    href="{{ route('home.service_provider') }}"
                    class="view-all-btn"
                >
                    Explore all providers
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>

        </div>

    </section>


    {{-- =========================================================
        HOW IT WORKS
    ========================================================== --}}
    <section class="how-section">

        <div class="container">

            <div class="how-header">

                <div class="market-eyebrow">
                    <span class="dot"></span>
                    Simple & convenient
                </div>

                <h2 class="market-heading">
                    How it <span>works.</span>
                </h2>

                <p class="market-description mx-auto">
                    Getting the service you need should be simple.
                    Find a provider in just a few steps.
                </p>

            </div>


            <div class="steps-grid">

                {{-- Step 1 --}}
                <div class="step-card">

                    <div class="step-number">
                        01
                    </div>

                    <div class="step-icon">
                        <i class="bi bi-search"></i>
                    </div>

                    <h3 class="step-title">
                        Search for a service
                    </h3>

                    <p class="step-text">
                        Browse categories or search directly for the service
                        you need.
                    </p>

                </div>


                {{-- Step 2 --}}
                <div class="step-card">

                    <div class="step-number">
                        02
                    </div>

                    <div class="step-icon">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>

                    <h3 class="step-title">
                        Compare providers
                    </h3>

                    <p class="step-text">
                        Explore provider profiles and choose a professional
                        that matches your requirements.
                    </p>

                </div>


                {{-- Step 3 --}}
                <div class="step-card">

                    <div class="step-number">
                        03
                    </div>

                    <div class="step-icon">
                        <i class="bi bi-chat-dots"></i>
                    </div>

                    <h3 class="step-title">
                        Connect & get started
                    </h3>

                    <p class="step-text">
                        Contact the provider directly and discuss your service
                        requirements.
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
        EXISTING CTA
    ========================================================== --}}
    @include('includes.call-to-action')

</div>

@endsection