@extends('layouts.base')

@section('title', 'Search Services')

@section('content')

<style>
    :root {
        --search-white: #ffffff;
        --search-sage: #6B9080;
        --search-sage-dark: #527866;
        --search-sage-soft: #EDF4F1;
        --search-sage-pale: #F6FAF8;
        --search-forest: #254035;
        --search-forest-dark: #1B3027;
        --search-text: #182B24;
        --search-muted: #71837B;
        --search-border: #E2EAE6;
        --search-bg: #F8FAF9;
        --search-discount: #D85A30;
        --search-success: #25D366;

        --search-radius-sm: 10px;
        --search-radius-md: 14px;
        --search-radius-lg: 20px;
        --search-radius-xl: 26px;

        --search-shadow-sm: 0 2px 12px rgba(37, 64, 53, .05);
        --search-shadow-md: 0 10px 32px rgba(37, 64, 53, .08);
        --search-shadow-lg: 0 20px 50px rgba(37, 64, 53, .12);

        --search-display: 'Playfair Display', Georgia, serif;
        --search-body: 'DM Sans', sans-serif;

        --search-transition: .22s cubic-bezier(.4, 0, .2, 1);
    }

    /* =========================================================
       PAGE
    ========================================================= */

    .service-search-page,
    .service-search-page * {
        box-sizing: border-box;
    }

    .service-search-page {
        min-height: 100vh;
        background: var(--search-bg);
        color: var(--search-text);
        font-family: var(--search-body);
    }

    .service-search-page a {
        text-decoration: none;
    }

    .search-container {
        width: min(1280px, calc(100% - 40px));
        margin: 0 auto;
    }

    /* =========================================================
       HERO
    ========================================================= */

    .search-hero {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(
                circle at 10% 20%,
                rgba(107, 144, 128, .28),
                transparent 34%
            ),
            radial-gradient(
                circle at 90% 90%,
                rgba(107, 144, 128, .20),
                transparent 32%
            ),
            linear-gradient(
                135deg,
                #254035 0%,
                #1C3028 58%,
                #14251F 100%
            );
    }

    .search-hero::before {
        content: "";
        position: absolute;
        width: 500px;
        height: 500px;
        left: -280px;
        bottom: -330px;
        border: 1px solid rgba(255,255,255,.07);
        border-radius: 50%;
    }

    .search-hero::after {
        content: "";
        position: absolute;
        width: 400px;
        height: 400px;
        right: -180px;
        top: -210px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 50%;
    }

    .search-hero-inner {
        position: relative;
        z-index: 1;
        padding: 58px 0 76px;
    }

    .search-breadcrumb {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-bottom: 19px;
        color: rgba(255,255,255,.50);
        font-size: 12px;
    }

    .search-breadcrumb a {
        color: rgba(255,255,255,.82);
    }

    .search-breadcrumb a:hover {
        color: #fff;
    }

    .search-breadcrumb svg {
        opacity: .45;
    }

    .search-kicker {
        width: fit-content;
        margin: 0 auto 14px;
        padding: 7px 13px;
        border: 1px solid rgba(255,255,255,.14);
        border-radius: 100px;
        background: rgba(255,255,255,.07);
        backdrop-filter: blur(8px);
        color: rgba(255,255,255,.78);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .search-hero h1 {
        margin: 0;
        color: #fff;
        text-align: center;
        font-family: var(--search-display);
        font-size: clamp(36px, 5vw, 56px);
        line-height: 1.08;
        font-weight: 700;
        letter-spacing: -.025em;
    }

    .search-hero-description {
        max-width: 610px;
        margin: 18px auto 0;
        color: rgba(255,255,255,.66);
        text-align: center;
        font-size: 15px;
        line-height: 1.75;
    }

    /* =========================================================
       SEARCH PANEL
    ========================================================= */

    .search-box-wrap {
        position: relative;
        z-index: 5;
        width: min(100%, 1080px);
        margin: -32px auto 0;
    }

    .search-box {
        padding: 10px;
        background: rgba(255,255,255,.97);
        border: 1px solid rgba(255,255,255,.75);
        border-radius: 19px;
        box-shadow: var(--search-shadow-lg);
    }

    .search-form-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1fr auto;
        gap: 8px;
        align-items: center;
    }

    .search-field {
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 9px;
        min-height: 48px;
        padding: 0 13px;
        border: 1px solid var(--search-border);
        border-radius: 11px;
        background: #fff;
        transition: border-color var(--search-transition),
                    box-shadow var(--search-transition);
    }

    .search-field:focus-within {
        border-color: var(--search-sage);
        box-shadow: 0 0 0 3px rgba(107,144,128,.10);
    }

    .search-field svg {
        flex-shrink: 0;
        color: var(--search-sage);
    }

    .search-field input,
    .search-field select {
        width: 100%;
        min-width: 0;
        height: 46px;
        border: 0;
        outline: 0;
        background: transparent;
        color: var(--search-text);
        font-family: inherit;
        font-size: 12.5px;
    }

    .search-field select {
        cursor: pointer;
    }

    .search-field input::placeholder {
        color: #9AA9A2;
    }

    .search-submit {
        min-height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 0 20px;
        border: 0;
        border-radius: 11px;
        background: var(--search-forest);
        color: #fff;
        font-family: inherit;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        transition: background var(--search-transition),
                    transform var(--search-transition);
    }

    .search-submit:hover {
        background: var(--search-forest-dark);
        transform: translateY(-1px);
    }

    .clear-search {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        padding: 0 14px;
        border-radius: 11px;
        background: var(--search-sage-soft);
        color: var(--search-forest);
        font-size: 11px;
        font-weight: 800;
    }

    .clear-search:hover {
        background: var(--search-forest);
        color: #fff;
    }

    /* =========================================================
       CONTENT
    ========================================================= */

    .search-content {
        padding: 54px 0 80px;
    }

    .search-layout {
        display: grid;
        grid-template-columns: 250px minmax(0, 1fr);
        gap: 32px;
        align-items: start;
    }

    /* =========================================================
       FILTER SIDEBAR
    ========================================================= */

    .search-filter-sidebar {
        position: sticky;
        top: 90px;
    }

    .filter-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--search-border);
        border-radius: var(--search-radius-lg);
        box-shadow: var(--search-shadow-sm);
    }

    .filter-card-header {
        padding: 20px;
        border-bottom: 1px solid var(--search-border);
    }

    .filter-eyebrow {
        margin-bottom: 4px;
        color: var(--search-sage);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .filter-title {
        margin: 0;
        color: var(--search-forest);
        font-family: var(--search-display);
        font-size: 21px;
        line-height: 1.2;
    }

    .filter-list {
        list-style: none;
        margin: 0;
        padding: 10px;
    }

    .filter-item {
        margin-bottom: 3px;
    }

    .filter-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 10px 11px;
        border-radius: 9px;
        color: var(--search-text);
        font-size: 12.5px;
        font-weight: 600;
        transition: background var(--search-transition),
                    color var(--search-transition);
    }

    .filter-link:hover {
        background: var(--search-sage-soft);
        color: var(--search-forest);
    }

    .filter-link.active {
        background: var(--search-sage-soft);
        color: var(--search-forest);
        font-weight: 800;
    }

    .filter-link span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .filter-arrow {
        flex-shrink: 0;
        color: var(--search-sage);
    }

    .filter-footer {
        padding: 15px;
        border-top: 1px solid var(--search-border);
    }

    .clear-filter-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        padding: 11px 13px;
        border-radius: 10px;
        background: var(--search-sage-soft);
        color: var(--search-forest);
        font-size: 11.5px;
        font-weight: 800;
    }

    .clear-filter-btn:hover {
        background: var(--search-forest);
        color: #fff;
    }

    /* =========================================================
       RESULTS HEADER
    ========================================================= */

    .results-area {
        min-width: 0;
    }

    .results-toolbar {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 25px;
    }

    .results-heading small {
        display: block;
        margin-bottom: 5px;
        color: var(--search-muted);
        font-size: 11.5px;
    }

    .results-heading h2 {
        margin: 0;
        color: var(--search-forest);
        font-family: var(--search-display);
        font-size: 27px;
        line-height: 1.15;
    }

    .results-heading h2 span {
        color: var(--search-sage);
    }

    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 11px;
    }

    .active-filter {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 100px;
        background: var(--search-sage-soft);
        color: var(--search-forest);
        font-size: 10px;
        font-weight: 700;
    }

    /* =========================================================
       RESULTS GRID
    ========================================================= */

    .search-services-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 19px;
    }

    /* =========================================================
       SERVICE CARD
    ========================================================= */

    .search-service-card {
        min-width: 0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--search-border);
        border-radius: var(--search-radius-lg);
        box-shadow: var(--search-shadow-sm);
        transition: transform var(--search-transition),
                    box-shadow var(--search-transition),
                    border-color var(--search-transition);
    }

    .search-service-card:hover {
        transform: translateY(-5px);
        border-color: #CFE0D9;
        box-shadow: var(--search-shadow-lg);
    }

    /* IMAGE */

    .search-service-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 1.28 / 1;
        background: var(--search-sage-soft);
    }

    .search-service-image a {
        display: block;
        height: 100%;
    }

    .search-service-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .6s cubic-bezier(.2,.7,.2,1);
    }

    .search-service-card:hover .search-service-image img {
        transform: scale(1.06);
    }

    .search-image-overlay {
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: linear-gradient(
            180deg,
            rgba(0,0,0,.14),
            transparent 40%,
            rgba(0,0,0,.06)
        );
    }

    /* BADGES */

    .search-card-badges {
        position: absolute;
        z-index: 2;
        top: 11px;
        left: 11px;
        right: 11px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 7px;
    }

    .search-badges-left {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .search-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 8px;
        border-radius: 100px;
        background: rgba(255,255,255,.95);
        backdrop-filter: blur(8px);
        color: var(--search-forest);
        font-size: 9.5px;
        font-weight: 800;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
    }

    .search-badge.discount {
        background: var(--search-discount);
        color: #fff;
    }

    .search-badge.duration {
        background: rgba(37,64,53,.90);
        color: #fff;
    }

    .favorite-btn {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 0;
        border-radius: 50%;
        background: rgba(255,255,255,.95);
        color: var(--search-forest);
        cursor: pointer;
        box-shadow: 0 3px 13px rgba(0,0,0,.10);
        transition: transform var(--search-transition),
                    color var(--search-transition);
    }

    .favorite-btn:hover {
        transform: scale(1.06);
        color: var(--search-discount);
    }

    .favorite-btn.is-favorite {
        color: var(--search-discount);
    }

    /* BODY */

    .search-service-body {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 16px;
    }

    .search-service-category {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 6px;
        color: var(--search-sage);
        font-size: 9.5px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .search-service-name {
        display: -webkit-box;
        min-height: 46px;
        margin: 0 0 10px;
        overflow: hidden;
        color: var(--search-forest);
        font-family: var(--search-display);
        font-size: 18px;
        font-weight: 700;
        line-height: 1.28;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        transition: color var(--search-transition);
    }

    .search-service-name:hover {
        color: var(--search-sage-dark);
    }

    /* PRICE */

    .search-price {
        display: flex;
        align-items: baseline;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }

    .search-current-price {
        color: var(--search-forest);
        font-size: 18px;
        font-weight: 800;
        letter-spacing: -.02em;
    }

    .search-currency {
        color: var(--search-muted);
        font-size: 9.5px;
        font-weight: 800;
    }

    .search-original-price {
        color: #9AA7A1;
        font-size: 10.5px;
        text-decoration: line-through;
    }

    /* META */

    .search-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 15px;
        color: var(--search-muted);
        font-size: 10.5px;
    }

    .search-meta svg {
        flex-shrink: 0;
        color: var(--search-sage);
    }

    .search-meta a {
        overflow: hidden;
        color: inherit;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .search-meta a:hover {
        color: var(--search-sage-dark);
    }

    /* ACTIONS */

    .search-card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 7px;
        margin-top: auto;
    }

    .search-card-action {
        min-height: 39px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 7px 9px;
        border-radius: 10px;
        font-size: 10.5px;
        font-weight: 800;
        transition: transform var(--search-transition),
                    background var(--search-transition),
                    color var(--search-transition);
    }

    .search-card-action:hover {
        transform: translateY(-1px);
    }

    .search-details {
        background: var(--search-sage-soft);
        color: var(--search-forest);
    }

    .search-details:hover {
        background: var(--search-forest);
        color: #fff;
    }

    .search-whatsapp {
        background: var(--search-success);
        color: #fff;
    }

    .search-whatsapp:hover {
        background: #1DA851;
        color: #fff;
        box-shadow: 0 5px 15px rgba(37,211,102,.22);
    }

    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .search-empty {
        grid-column: 1 / -1;
        min-height: 390px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 45px 25px;
        border: 1px dashed #CBDDD5;
        border-radius: var(--search-radius-xl);
        background: #fff;
        text-align: center;
    }

    .search-empty-icon {
        width: 68px;
        height: 68px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 17px;
        border-radius: 19px;
        background: var(--search-sage-soft);
        color: var(--search-sage);
    }

    .search-empty h3 {
        margin: 0 0 7px;
        color: var(--search-forest);
        font-family: var(--search-display);
        font-size: 23px;
    }

    .search-empty p {
        max-width: 420px;
        margin: 0;
        color: var(--search-muted);
        font-size: 12.5px;
        line-height: 1.7;
    }

    .search-empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-top: 19px;
        padding: 10px 16px;
        border-radius: 10px;
        background: var(--search-forest);
        color: #fff !important;
        font-size: 11px;
        font-weight: 800;
    }

    .search-empty-btn:hover {
        background: var(--search-forest-dark);
    }

    /* =========================================================
       PAGINATION
    ========================================================= */

    .search-pagination {
        display: flex;
        justify-content: center;
        margin-top: 38px;
    }

    .search-pagination nav {
        display: flex;
        justify-content: center;
    }

    .search-pagination nav > div {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 5px;
    }

    .search-pagination a,
    .search-pagination span {
        min-width: 37px;
        height: 37px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 9px;
        border: 1px solid var(--search-border);
        border-radius: 9px;
        background: #fff;
        color: var(--search-forest);
        font-size: 11px;
        font-weight: 800;
        transition: background var(--search-transition),
                    color var(--search-transition),
                    border-color var(--search-transition);
    }

    .search-pagination a:hover {
        background: var(--search-sage-soft);
        border-color: #CFE0D9;
    }

    .search-pagination span[aria-current="page"],
    .search-pagination .active span {
        background: var(--search-forest);
        border-color: var(--search-forest);
        color: #fff;
    }

    .search-pagination svg {
        width: 14px;
        height: 14px;
    }

    /* =========================================================
       MOBILE FILTER BUTTON
    ========================================================= */

    .mobile-filter-button {
        display: none;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1199px) {

        .search-form-grid {
            grid-template-columns: 1.5fr 1fr 1fr;
        }

        .search-submit {
            width: 100%;
        }

        .search-form-grid .search-submit {
            grid-column: span 2;
        }

        .clear-search {
            width: 100%;
        }

        .search-services-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 991px) {

        .search-container {
            width: min(100% - 30px, 760px);
        }

        .search-layout {
            display: block;
        }

        .mobile-filter-button {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
            padding: 13px 15px;
            border: 1px solid var(--search-border);
            border-radius: 12px;
            background: #fff;
            color: var(--search-forest);
            font-family: inherit;
            font-size: 12.5px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: var(--search-shadow-sm);
        }

        .mobile-filter-button span {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .mobile-filter-button svg {
            color: var(--search-sage);
        }

        .search-filter-sidebar {
            position: static;
            margin-bottom: 23px;
        }

        .results-toolbar {
            align-items: center;
        }
    }

    @media (max-width: 767px) {

        .search-container {
            width: min(100% - 24px, 620px);
        }

        .search-hero-inner {
            padding: 40px 0 60px;
        }

        .search-hero h1 {
            font-size: 38px;
        }

        .search-hero-description {
            font-size: 13px;
        }

        .search-box {
            padding: 7px;
            border-radius: 15px;
        }

        .search-form-grid {
            grid-template-columns: 1fr;
        }

        .search-form-grid .search-submit {
            grid-column: auto;
        }

        .search-submit,
        .clear-search {
            width: 100%;
        }

        .search-content {
            padding: 38px 0 55px;
        }

        .results-toolbar {
            display: block;
            margin-bottom: 20px;
        }

        .results-heading {
            margin-bottom: 17px;
        }

        .results-heading h2 {
            font-size: 23px;
        }

        .search-services-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 13px;
        }

        .search-service-image {
            aspect-ratio: 1.05 / 1;
        }

        .search-service-body {
            padding: 13px;
        }

        .search-service-name {
            font-size: 15px;
            min-height: 39px;
        }

        .search-current-price {
            font-size: 16px;
        }

        .search-card-action {
            font-size: 10px;
        }

        .search-badge {
            padding: 5px 7px;
            font-size: 8.5px;
        }

        .favorite-btn {
            width: 32px;
            height: 32px;
        }
    }

    @media (max-width: 480px) {

        .search-hero h1 {
            font-size: 33px;
        }

        .search-services-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .search-service-image {
            aspect-ratio: 1.5 / 1;
        }

        .search-service-name {
            min-height: auto;
            font-size: 18px;
        }

        .search-current-price {
            font-size: 18px;
        }
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap"
    rel="stylesheet"
>

<div class="service-search-page">

    {{-- =========================================================
         HERO
    ========================================================== --}}

    <section class="search-hero">

        <div class="search-container search-hero-inner">

            <div class="search-breadcrumb">

                <a href="{{ route('home') }}">
                    Home
                </a>

                <svg width="13"
                     height="13"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <path d="m9 18 6-6-6-6"/>

                </svg>

                <span>
                    Search Services
                </span>

            </div>

            <div class="search-kicker">
                Service Marketplace
            </div>

            <h1>
                Find the service<br>
                you need.
            </h1>

            <p class="search-hero-description">

                Search by service, category, subcategory or location
                and connect with providers offering the right solution.

            </p>

        </div>

    </section>


    {{-- =========================================================
         SEARCH FORM
    ========================================================== --}}

    <div class="search-container">

        <div class="search-box-wrap">

            <div class="search-box">

                <form
                    action="{{ route('services.search') }}"
                    method="GET"
                    class="search-form-grid"
                >

                    {{-- SERVICE NAME --}}

                    <div class="search-field">

                        <svg width="17"
                             height="17"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <circle cx="11"
                                    cy="11"
                                    r="7"/>

                            <path d="m20 20-4-4"/>

                        </svg>

                        <input
                            type="text"
                            name="name"
                            value="{{ request('name') }}"
                            placeholder="Search service..."
                            autocomplete="off"
                        >

                    </div>


                    {{-- CATEGORY --}}

                    <div class="search-field">

                        <svg width="16"
                             height="16"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <rect x="3"
                                  y="3"
                                  width="7"
                                  height="7"
                                  rx="1"/>

                            <rect x="14"
                                  y="3"
                                  width="7"
                                  height="7"
                                  rx="1"/>

                            <rect x="3"
                                  y="14"
                                  width="7"
                                  height="7"
                                  rx="1"/>

                            <rect x="14"
                                  y="14"
                                  width="7"
                                  height="7"
                                  rx="1"/>

                        </svg>

                        <select name="category_id">

                            <option value="">
                                Category
                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- SUBCATEGORY --}}

                    <div class="search-field">

                        <svg width="16"
                             height="16"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <path d="M4 6h16"/>
                            <path d="M7 12h10"/>
                            <path d="M10 18h4"/>

                        </svg>

                        <select name="subcategory_id">

                            <option value="">
                                Subcategory
                            </option>

                            @foreach($subcategories as $subcategory)

                                <option
                                    value="{{ $subcategory->id }}"
                                    {{ (string) request('subcategory_id') === (string) $subcategory->id ? 'selected' : '' }}
                                >
                                    {{ $subcategory->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- LOCATION --}}

                    <div class="search-field">

                        <svg width="16"
                             height="16"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/>

                            <circle cx="12"
                                    cy="10"
                                    r="3"/>

                        </svg>

                        <select name="location">

                            <option value="">
                                Location
                            </option>

                            @foreach($locations as $location)

                                <option
                                    value="{{ $location }}"
                                    {{ request('location') === $location ? 'selected' : '' }}
                                >
                                    {{ $location }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- SEARCH --}}

                    <button
                        type="submit"
                        class="search-submit"
                    >

                        <svg width="15"
                             height="15"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <circle cx="11"
                                    cy="11"
                                    r="7"/>

                            <path d="m20 20-4-4"/>

                        </svg>

                        Search

                    </button>


                    @if(
                        request()->filled('name') ||
                        request()->filled('category_id') ||
                        request()->filled('subcategory_id') ||
                        request()->filled('location')
                    )

                        <a
                            href="{{ route('services.search') }}"
                            class="clear-search"
                        >
                            Clear filters
                        </a>

                    @endif

                </form>

            </div>

        </div>

    </div>


    {{-- =========================================================
         CONTENT
    ========================================================== --}}

    <main class="search-content">

        <div class="search-container">

            <div class="search-layout">


                {{-- =================================================
                     SIDEBAR
                ================================================== --}}

                <aside class="search-filter-sidebar">

                    <button
                        type="button"
                        class="mobile-filter-button"
                        data-bs-toggle="collapse"
                        data-bs-target="#searchFilterPanel"
                        aria-expanded="false"
                    >

                        <span>

                            <svg width="17"
                                 height="17"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">

                                <path d="M4 6h16"/>
                                <path d="M7 12h10"/>
                                <path d="M10 18h4"/>

                            </svg>

                            Browse categories

                        </span>

                        <svg width="15"
                             height="15"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <path d="m6 9 6 6 6-6"/>

                        </svg>

                    </button>


                    <div
                        class="collapse d-lg-block"
                        id="searchFilterPanel"
                    >

                        <div class="filter-card">

                            <div class="filter-card-header">

                                <div class="filter-eyebrow">
                                    Explore
                                </div>

                                <h3 class="filter-title">
                                    Categories
                                </h3>

                            </div>


                            <ul class="filter-list">

                                @foreach($categories as $category)

                                    <li class="filter-item">

                                        <a
                                            href="{{ route('home.service_by_category', ['category_slug' => $category->slug]) }}"
                                            class="filter-link
                                            {{ request('category_id') == $category->id ? 'active' : '' }}"
                                        >

                                            <span>
                                                {{ $category->name }}
                                            </span>

                                            <svg
                                                class="filter-arrow"
                                                width="13"
                                                height="13"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >

                                                <path d="m9 18 6-6-6-6"/>

                                            </svg>

                                        </a>

                                    </li>

                                @endforeach

                            </ul>


                            <div class="filter-footer">

                                <a
                                    href="{{ route('home.services') }}"
                                    class="clear-filter-btn"
                                >

                                    View all services

                                    <svg width="13"
                                         height="13"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">

                                        <path d="M5 12h14"/>
                                        <path d="m13 6 6 6-6 6"/>

                                    </svg>

                                </a>

                            </div>

                        </div>

                    </div>

                </aside>


                {{-- =================================================
                     RESULTS
                ================================================== --}}

                <section class="results-area">

                    <div class="results-toolbar">

                        <div class="results-heading">

                            <small>
                                Search results
                            </small>

                            <h2>

                                {{ $services->total() }}

                                <span>
                                    service{{ $services->total() == 1 ? '' : 's' }}
                                </span>

                            </h2>


                            {{-- ACTIVE FILTERS --}}

                            @if(
                                request()->filled('name') ||
                                request()->filled('category_id') ||
                                request()->filled('subcategory_id') ||
                                request()->filled('location')
                            )

                                <div class="active-filters">

                                    @if(request('name'))

                                        <span class="active-filter">

                                            Search:
                                            {{ request('name') }}

                                        </span>

                                    @endif


                                    @if(request('category_id'))

                                        @php
                                            $selectedCategory = $categories->firstWhere(
                                                'id',
                                                request('category_id')
                                            );
                                        @endphp

                                        @if($selectedCategory)

                                            <span class="active-filter">

                                                {{ $selectedCategory->name }}

                                            </span>

                                        @endif

                                    @endif


                                    @if(request('subcategory_id'))

                                        @php
                                            $selectedSubcategory = $subcategories->firstWhere(
                                                'id',
                                                request('subcategory_id')
                                            );
                                        @endphp

                                        @if($selectedSubcategory)

                                            <span class="active-filter">

                                                {{ $selectedSubcategory->name }}

                                            </span>

                                        @endif

                                    @endif


                                    @if(request('location'))

                                        <span class="active-filter">

                                            {{ request('location') }}

                                        </span>

                                    @endif

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- =================================================
                         SERVICE GRID
                    ================================================== --}}

                    <div class="search-services-grid">

                        @forelse($services as $service)

                            @php

                                /*
                                |--------------------------------------------------------------------------
                                | Calculate discounted price
                                |--------------------------------------------------------------------------
                                */

                                $total = (float) $service->price;

                                if ($service->discount) {

                                    if ($service->discount_type === 'fixed') {

                                        $total = $total - (float) $service->discount;

                                    } elseif ($service->discount_type === 'percent') {

                                        $total = $total -
                                            ($total * (float) $service->discount / 100);

                                    }

                                }

                                $total = max(0, $total);


                                /*
                                |--------------------------------------------------------------------------
                                | Provider / WhatsApp
                                |--------------------------------------------------------------------------
                                */

                                $provider = $service->provider ?? null;

                                $waRawPhone = optional($provider)->phone
                                    ?? optional(optional($provider)->user)->phone
                                    ?? config(
                                        'services.whatsapp.default_number',
                                        '250780000000'
                                    );

                                $waPhone = preg_replace(
                                    '/\D+/',
                                    '',
                                    $waRawPhone
                                );

                                $waMessage = rawurlencode(
                                    'Hello! I am interested in booking "' .
                                    $service->name .
                                    '" (' .
                                    number_format($total) .
                                    ' RWF). Is it available?'
                                );

                            @endphp


                            <article
                                class="search-service-card"
                                data-service-name="{{ strtolower($service->name ?? '') }}"
                                data-service-category="{{ strtolower($service->category->name ?? '') }}"
                                data-service-location="{{ strtolower($service->location ?? '') }}"
                            >

                                {{-- IMAGE --}}

                                <div class="search-service-image">

                                    <a
                                        href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}"
                                    >

                                        <img
                                            src="{{ asset('image/services/' . ($service->image ?: 'default.png')) }}"
                                            alt="{{ $service->name }}"
                                            loading="lazy"
                                            onerror="this.onerror=null;this.src='{{ asset('image/services/default.png') }}';"
                                        >

                                    </a>


                                    <div class="search-image-overlay"></div>


                                    {{-- BADGES --}}

                                    <div class="search-card-badges">

                                        <div class="search-badges-left">

                                            @if($service->discount)

                                                <span class="search-badge discount">

                                                    <svg
                                                        width="10"
                                                        height="10"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    >

                                                        <path d="m20 12-8 8-8-8V4h8z"/>
                                                        <circle cx="8" cy="8" r="1"/>

                                                    </svg>

                                                    @if($service->discount_type === 'fixed')

                                                        Save
                                                        {{ number_format($service->discount) }}
                                                        RWF

                                                    @else

                                                        Save
                                                        {{ $service->discount }}%

                                                    @endif

                                                </span>

                                            @endif


                                            @if($service->duration)

                                                <span class="search-badge duration">

                                                    <svg
                                                        width="10"
                                                        height="10"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    >

                                                        <circle cx="12"
                                                                cy="12"
                                                                r="9"/>

                                                        <path d="M12 7v5l3 2"/>

                                                    </svg>

                                                    {{ $service->duration }}

                                                </span>

                                            @endif

                                        </div>


                                        <button
                                            type="button"
                                            class="favorite-btn"
                                            aria-label="Save service"
                                        >

                                            <svg
                                                width="16"
                                                height="16"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >

                                                <path d="M20.8 8.7c0 5.5-8.8 11-8.8 11S3.2 14.2 3.2 8.7A4.7 4.7 0 0 1 12 6.3a4.7 4.7 0 0 1 8.8 2.4z"/>

                                            </svg>

                                        </button>

                                    </div>

                                </div>


                                {{-- BODY --}}

                                <div class="search-service-body">

                                    {{-- CATEGORY --}}

                                    <div class="search-service-category">

                                        <svg
                                            width="10"
                                            height="10"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >

                                            <path d="M20 13.5V6a2 2 0 0 0-2-2h-7.5L4 10.5a2 2 0 0 0 0 3L10.5 20a2 2 0 0 0 3 0z"/>

                                            <circle cx="14.5"
                                                    cy="8.5"
                                                    r="1"/>

                                        </svg>

                                        {{ $service->category->name ?? 'Service' }}

                                    </div>


                                    {{-- NAME --}}

                                    <a
                                        href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}"
                                        class="search-service-name"
                                    >

                                        {{ $service->name }}

                                    </a>


                                    {{-- PRICE --}}

                                    <div class="search-price">

                                        <span class="search-current-price">

                                            {{ number_format($total) }}

                                        </span>

                                        <span class="search-currency">
                                            RWF
                                        </span>

                                        @if($service->discount)

                                            <span class="search-original-price">

                                                {{ number_format($service->price) }}

                                            </span>

                                        @endif

                                    </div>


                                    {{-- LOCATION --}}

                                    @if($service->location)

                                        <div class="search-meta">

                                            <svg
                                                width="13"
                                                height="13"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >

                                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/>

                                                <circle cx="12"
                                                        cy="10"
                                                        r="3"/>

                                            </svg>


                                            <a
                                                href="{{ route('home.service_location', ['service_location' => $service->location]) }}"
                                            >

                                                {{ $service->location }}

                                            </a>

                                        </div>

                                    @endif


                                    {{-- ACTIONS --}}

                                    <div class="search-card-actions">

                                        <a
                                            href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}"
                                            class="search-card-action search-details"
                                        >

                                            View details

                                            <svg
                                                width="12"
                                                height="12"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >

                                                <path d="M5 12h14"/>
                                                <path d="m13 6 6 6-6 6"/>

                                            </svg>

                                        </a>


                                        <a
                                            href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="search-card-action search-whatsapp"
                                        >

                                            <svg
                                                width="13"
                                                height="13"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                            >

                                                <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 0 0 4.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm5.8 14.1c-.24.68-1.4 1.3-1.93 1.38-.5.08-1.12.11-1.8-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.13-4.9-4.32-.14-.19-1.17-1.55-1.17-2.96 0-1.4.73-2.09 1-2.38.26-.28.57-.35.76-.35h.55c.18 0 .42-.07.65.5.24.58.82 2 .89 2.15.07.15.12.32.02.51-.09.19-.14.31-.28.48-.14.16-.29.36-.42.49-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.28.36-.23.6-.14.24.09 1.55.73 1.82.86.27.14.44.2.51.32.07.12.07.68-.17 1.36z"/>

                                            </svg>

                                            WhatsApp

                                        </a>

                                    </div>

                                </div>

                            </article>

                        @empty

                            {{-- EMPTY STATE --}}

                            <div class="search-empty">

                                <div class="search-empty-icon">

                                    <svg
                                        width="28"
                                        height="28"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >

                                        <circle cx="11"
                                                cy="11"
                                                r="7"/>

                                        <path d="m21 21-4.3-4.3"/>

                                    </svg>

                                </div>


                                <h3>
                                    No services found
                                </h3>


                                <p>

                                    We couldn't find any services matching
                                    your current search. Try changing your
                                    filters or browse all available services.

                                </p>


                                <a
                                    href="{{ route('home.services') }}"
                                    class="search-empty-btn"
                                >

                                    Browse all services

                                    <svg
                                        width="13"
                                        height="13"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >

                                        <path d="M5 12h14"/>
                                        <path d="m13 6 6 6-6 6"/>

                                    </svg>

                                </a>

                            </div>

                        @endforelse

                    </div>


                    {{-- =================================================
                         PAGINATION
                    ================================================== --}}

                    @if($services->hasPages())

                        <div class="search-pagination">

                            {{ $services->links() }}

                        </div>

                    @endif

                </section>

            </div>

        </div>

    </main>

</div>


<script>

(function () {

    /*
    |--------------------------------------------------------------------------
    | Favorite buttons
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.favorite-btn')
        .forEach(function (button) {

            button.addEventListener('click', function (event) {

                event.preventDefault();
                event.stopPropagation();

                const svg = button.querySelector('svg');

                const active =
                    button.classList.toggle('is-favorite');

                if (active) {

                    if (svg) {
                        svg.setAttribute(
                            'fill',
                            'currentColor'
                        );
                    }

                } else {

                    if (svg) {
                        svg.setAttribute(
                            'fill',
                            'none'
                        );
                    }

                }

            });

        });


    /*
    |--------------------------------------------------------------------------
    | Prevent accidental form submission when clearing
    |--------------------------------------------------------------------------
    */

    const forms =
        document.querySelectorAll('.search-form-grid');

    forms.forEach(function (form) {

        const input =
            form.querySelector('input[name="name"]');

        if (!input) {
            return;
        }

        input.addEventListener('keydown', function (event) {

            if (event.key === 'Enter') {

                event.preventDefault();

                form.submit();

            }

        });

    });

})();

</script>

@endsection