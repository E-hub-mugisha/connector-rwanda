@extends('layouts.base')

@section('title', $scategory->name . ' Service Category')

@section('content')

<style>
    :root {
        --service-primary: #6B9080;
        --service-dark: #254035;
        --service-white: #FFFFFF;

        --service-soft: #F1F6F3;
        --service-soft-2: #F7FAF8;
        --service-border: #DDE8E3;
        --service-muted: #708078;
        --service-text: #1C3028;

        --service-radius-sm: 10px;
        --service-radius-md: 16px;
        --service-radius-lg: 22px;

        --service-shadow: 0 4px 20px rgba(37, 64, 53, .07);
        --service-shadow-hover: 0 14px 34px rgba(37, 64, 53, .14);

        --service-transition: .22s ease;
    }

    * {
        box-sizing: border-box;
    }

    .service-category-page {
        background: var(--service-white);
        color: var(--service-text);
        min-height: 100vh;
        font-family: "DM Sans", sans-serif;
    }

    .service-category-page a {
        text-decoration: none;
    }

    .service-container {
        width: min(1240px, calc(100% - 40px));
        margin: 0 auto;
    }

    /* =========================================================
       HERO
    ========================================================= */

    .category-hero {
        position: relative;
        overflow: hidden;
        background:
            linear-gradient(
                135deg,
                rgba(37, 64, 53, .98),
                rgba(37, 64, 53, .92)
            );
        padding: 58px 0 62px;
    }

    .category-hero::before {
        content: "";
        position: absolute;
        width: 420px;
        height: 420px;
        border-radius: 50%;
        background: rgba(107, 144, 128, .14);
        top: -250px;
        right: -120px;
    }

    .category-hero::after {
        content: "";
        position: absolute;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        background: rgba(107, 144, 128, .10);
        bottom: -180px;
        left: -100px;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 850px;
        margin: 0 auto;
        text-align: center;
    }

    .hero-breadcrumb {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
        color: rgba(255, 255, 255, .55);
        font-size: 13px;
        margin-bottom: 18px;
    }

    .hero-breadcrumb a {
        color: rgba(255, 255, 255, .82);
        transition: var(--service-transition);
    }

    .hero-breadcrumb a:hover {
        color: var(--service-white);
    }

    .hero-breadcrumb .current {
        color: var(--service-white);
        font-weight: 600;
    }

    .hero-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #fff;
        background: rgba(255, 255, 255, .10);
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 100px;
        padding: 7px 14px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    .hero-label span {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--service-primary);
    }

    .category-hero h1 {
        margin: 0;
        color: #fff;
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(34px, 5vw, 58px);
        line-height: 1.1;
        font-weight: 700;
    }

    .category-hero p {
        max-width: 650px;
        margin: 17px auto 0;
        color: rgba(255, 255, 255, .68);
        font-size: 15px;
        line-height: 1.7;
    }

    /* =========================================================
       MAIN
    ========================================================= */

    .category-main {
        padding: 48px 0 90px;
    }

    .category-layout {
        display: grid;
        grid-template-columns: 290px minmax(0, 1fr);
        gap: 30px;
        align-items: start;
    }

    /* =========================================================
       SIDEBAR
    ========================================================= */

    .category-sidebar {
        position: sticky;
        top: 90px;
        border: 1px solid var(--service-border);
        border-radius: var(--service-radius-lg);
        background: var(--service-white);
        box-shadow: var(--service-shadow);
        overflow: hidden;
    }

    .sidebar-header {
        padding: 21px 21px 17px;
        border-bottom: 1px solid var(--service-border);
    }

    .sidebar-header .eyebrow {
        color: var(--service-primary);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .11em;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .sidebar-header h3 {
        margin: 0;
        color: var(--service-dark);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 21px;
        font-weight: 700;
    }

    .sidebar-search {
        margin: 16px 16px 8px;
        display: flex;
        align-items: center;
        gap: 9px;
        background: var(--service-soft-2);
        border: 1px solid var(--service-border);
        border-radius: 100px;
        padding: 10px 14px;
    }

    .sidebar-search svg {
        flex-shrink: 0;
        color: var(--service-primary);
    }

    .sidebar-search input {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;
        color: var(--service-text);
        font-size: 13px;
    }

    .sidebar-search input::placeholder {
        color: #8B9A93;
    }

    .category-list {
        list-style: none;
        padding: 10px 10px 14px;
        margin: 0;
        max-height: 530px;
        overflow-y: auto;
    }

    .category-list::-webkit-scrollbar {
        width: 5px;
    }

    .category-list::-webkit-scrollbar-thumb {
        background: #C5D7CF;
        border-radius: 10px;
    }

    .category-item {
        margin-bottom: 3px;
        border-radius: var(--service-radius-sm);
    }

    .category-row {
        display: flex;
        align-items: center;
        min-height: 45px;
        border-radius: var(--service-radius-sm);
        transition: var(--service-transition);
    }

    .category-row:hover {
        background: var(--service-soft-2);
    }

    .category-item.active .category-row {
        background: var(--service-soft);
    }

    .category-link {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
        padding: 11px 10px;
        color: var(--service-text);
        font-size: 13.5px;
        font-weight: 500;
    }

    .category-item.active .category-link {
        color: var(--service-dark);
        font-weight: 700;
    }

    .category-icon {
        width: 29px;
        height: 29px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: var(--service-soft-2);
        color: var(--service-primary);
    }

    .category-item.active .category-icon {
        background: var(--service-primary);
        color: #fff;
    }

    .category-name {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .category-chevron {
        width: 30px;
        height: 30px;
        margin-right: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        color: var(--service-muted);
        cursor: pointer;
        border-radius: 50%;
        transition: var(--service-transition);
    }

    .category-chevron:hover {
        background: var(--service-soft);
        color: var(--service-dark);
    }

    .category-chevron svg {
        transition: transform var(--service-transition);
    }

    .category-item.open .category-chevron svg {
        transform: rotate(90deg);
    }

    .subcategory-list {
        display: none;
        list-style: none;
        padding: 3px 10px 9px 49px;
        margin: 0;
    }

    .category-item.open .subcategory-list {
        display: block;
    }

    .subcategory-list a {
        display: block;
        padding: 7px 9px;
        border-radius: 7px;
        color: var(--service-muted);
        font-size: 12.5px;
        transition: var(--service-transition);
    }

    .subcategory-list a:hover {
        background: var(--service-soft);
        color: var(--service-dark);
    }

    .subcategory-list a.current-subcategory {
        color: var(--service-primary);
        font-weight: 700;
    }

    /* =========================================================
       MOBILE FILTER
    ========================================================= */

    .mobile-category-toggle {
        display: none;
        width: 100%;
        border: none;
        background: var(--service-dark);
        color: #fff;
        padding: 13px 16px;
        border-radius: var(--service-radius-sm);
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        margin-bottom: 18px;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    /* =========================================================
       RESULTS HEADER
    ========================================================= */

    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--service-border);
    }

    .results-heading {
        min-width: 0;
    }

    .results-heading .eyebrow {
        color: var(--service-primary);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .11em;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .results-heading h2 {
        margin: 0;
        color: var(--service-dark);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 27px;
        font-weight: 700;
    }

    .results-heading p {
        margin: 5px 0 0;
        color: var(--service-muted);
        font-size: 13px;
    }

    .results-heading p strong {
        color: var(--service-primary);
    }

    .results-tools {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .service-search {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 230px;
        padding: 9px 13px;
        border: 1px solid var(--service-border);
        border-radius: 100px;
        background: var(--service-white);
    }

    .service-search svg {
        color: var(--service-primary);
        flex-shrink: 0;
    }

    .service-search input {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;
        color: var(--service-text);
        font-size: 12.5px;
    }

    .service-search input::placeholder {
        color: #8B9A93;
    }

    .sort-select {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .sort-select label {
        color: var(--service-muted);
        font-size: 12.5px;
        font-weight: 600;
    }

    .sort-select select {
        min-width: 115px;
        padding: 9px 11px;
        border: 1px solid var(--service-border);
        border-radius: var(--service-radius-sm);
        outline: none;
        color: var(--service-text);
        background: #fff;
        font-size: 12.5px;
        cursor: pointer;
    }

    .sort-select select:focus {
        border-color: var(--service-primary);
    }

    /* =========================================================
       SERVICE GRID
    ========================================================= */

    .services-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    .service-card {
        display: flex;
        flex-direction: column;
        min-width: 0;
        overflow: hidden;
        border: 1px solid var(--service-border);
        border-radius: var(--service-radius-lg);
        background: #fff;
        box-shadow: var(--service-shadow);
        transition:
            transform var(--service-transition),
            box-shadow var(--service-transition),
            border-color var(--service-transition);
    }

    .service-card:hover {
        transform: translateY(-4px);
        border-color: #C9DAD3;
        box-shadow: var(--service-shadow-hover);
    }

    .service-image {
        position: relative;
        height: 170px;
        overflow: hidden;
        background: var(--service-soft);
    }

    .service-image a {
        display: block;
        height: 100%;
    }

    .service-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s ease;
    }

    .service-card:hover .service-image img {
        transform: scale(1.045);
    }

    .image-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            rgba(37, 64, 53, .03),
            rgba(37, 64, 53, .32)
        );
        pointer-events: none;
    }

    .duration-badge {
        position: absolute;
        top: 11px;
        right: 11px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 100px;
        background: rgba(37, 64, 53, .88);
        color: #fff;
        font-size: 10.5px;
        font-weight: 700;
        backdrop-filter: blur(5px);
    }

    .service-content {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 17px 17px 16px;
    }

    .service-category {
        display: inline-flex;
        align-items: center;
        width: fit-content;
        margin-bottom: 6px;
        color: var(--service-primary);
        font-size: 9.5px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .service-name {
        display: -webkit-box;
        overflow: hidden;
        color: var(--service-dark);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 12px;

        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .service-price {
        display: flex;
        align-items: baseline;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 6px;
    }

    .price-original {
        color: var(--service-muted);
        text-decoration: line-through;
        font-size: 11.5px;
    }

    .price-main {
        color: var(--service-dark);
        font-size: 18px;
        font-weight: 800;
    }

    .price-currency {
        color: var(--service-muted);
        font-size: 10.5px;
        font-weight: 600;
    }

    .discount {
        color: #fff;
        background: var(--service-primary);
        border-radius: 100px;
        padding: 3px 7px;
        font-size: 9.5px;
        font-weight: 800;
    }

    .service-location {
        display: flex;
        align-items: center;
        gap: 6px;
        margin: 2px 0 15px;
        color: var(--service-muted);
        font-size: 11.5px;
        min-width: 0;
    }

    .service-location svg {
        flex-shrink: 0;
        color: var(--service-primary);
    }

    .service-location a {
        color: var(--service-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .service-location a:hover {
        color: var(--service-primary);
    }

    .provider-row {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 9px 0;
        margin-bottom: 13px;
        border-top: 1px solid var(--service-border);
        border-bottom: 1px solid var(--service-border);
    }

    .provider-avatar {
        width: 32px;
        height: 32px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--service-soft);
        color: var(--service-primary);
        font-size: 12px;
        font-weight: 800;
    }

    .provider-info {
        min-width: 0;
    }

    .provider-label {
        display: block;
        color: var(--service-muted);
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: .07em;
        font-weight: 700;
    }

    .provider-name {
        display: block;
        color: var(--service-dark);
        font-size: 11.5px;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .service-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 7px;
        margin-top: auto;
    }

    .service-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-height: 39px;
        border-radius: var(--service-radius-sm);
        font-size: 11.5px;
        font-weight: 700;
        transition: var(--service-transition);
    }

    .service-btn-detail {
        color: var(--service-dark);
        background: var(--service-soft);
    }

    .service-btn-detail:hover {
        color: #fff;
        background: var(--service-dark);
    }

    .service-btn-whatsapp {
        color: #fff;
        background: var(--service-primary);
    }

    .service-btn-whatsapp:hover {
        color: #fff;
        background: var(--service-dark);
    }

    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 70px 25px;
        border: 1px dashed var(--service-border);
        border-radius: var(--service-radius-lg);
        background: var(--service-soft-2);
    }

    .empty-icon {
        width: 62px;
        height: 62px;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--service-soft);
        color: var(--service-primary);
    }

    .empty-state h3 {
        margin: 0 0 6px;
        color: var(--service-dark);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 20px;
    }

    .empty-state p {
        margin: 0;
        color: var(--service-muted);
        font-size: 13px;
    }

    /* =========================================================
       NO SEARCH RESULTS
    ========================================================= */

    .search-empty {
        display: none;
        grid-column: 1 / -1;
        padding: 55px 20px;
        text-align: center;
        border-radius: var(--service-radius-lg);
        background: var(--service-soft-2);
        border: 1px dashed var(--service-border);
    }

    .search-empty.show {
        display: block;
    }

    .search-empty h4 {
        margin: 0 0 5px;
        color: var(--service-dark);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 19px;
    }

    .search-empty p {
        margin: 0;
        color: var(--service-muted);
        font-size: 13px;
    }

    /* =========================================================
       BOTTOM CTA
    ========================================================= */

    .category-cta {
        margin-top: 65px;
        padding: 38px 42px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
        border-radius: var(--service-radius-lg);
        background: var(--service-dark);
        overflow: hidden;
        position: relative;
    }

    .category-cta::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -100px;
        top: -120px;
        background: rgba(107, 144, 128, .13);
    }

    .cta-content {
        position: relative;
        z-index: 2;
    }

    .cta-content h2 {
        margin: 0 0 5px;
        color: #fff;
        font-family: "Playfair Display", Georgia, serif;
        font-size: 26px;
    }

    .cta-content p {
        margin: 0;
        color: rgba(255, 255, 255, .62);
        font-size: 13.5px;
    }

    .cta-actions {
        position: relative;
        z-index: 2;
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
    }

    .cta-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 11px 20px;
        border-radius: 100px;
        font-size: 12.5px;
        font-weight: 700;
        transition: var(--service-transition);
    }

    .cta-btn-light {
        color: var(--service-dark);
        background: #fff;
    }

    .cta-btn-light:hover {
        color: var(--service-dark);
        transform: translateY(-2px);
    }

    .cta-btn-outline {
        color: #fff;
        border: 1px solid rgba(255, 255, 255, .35);
        background: transparent;
    }

    .cta-btn-outline:hover {
        color: #fff;
        border-color: #fff;
        background: rgba(255, 255, 255, .08);
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media(max-width:1100px) {
        .services-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .results-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .results-tools {
            width: 100%;
        }

        .service-search {
            flex: 1;
        }
    }

    @media(max-width:991px) {
        .category-layout {
            display: block;
        }

        .mobile-category-toggle {
            display: flex;
        }

        .category-sidebar {
            position: static;
            display: none;
            margin-bottom: 25px;
        }

        .category-sidebar.show {
            display: block;
        }

        .category-list {
            max-height: 400px;
        }
    }

    @media(max-width:700px) {
        .service-container {
            width: min(100% - 28px, 1240px);
        }

        .category-hero {
            padding: 45px 0 48px;
        }

        .category-main {
            padding: 32px 0 65px;
        }

        .category-hero p {
            font-size: 13.5px;
        }

        .results-heading h2 {
            font-size: 23px;
        }

        .results-tools {
            flex-direction: column;
            align-items: stretch;
        }

        .service-search {
            width: 100%;
        }

        .sort-select {
            justify-content: space-between;
        }

        .sort-select select {
            flex: 1;
        }

        .services-grid {
            grid-template-columns: 1fr;
        }

        .service-image {
            height: 190px;
        }

        .category-cta {
            padding: 30px 24px;
            flex-direction: column;
            align-items: flex-start;
        }

        .cta-actions {
            width: 100%;
        }

        .cta-btn {
            flex: 1;
        }
    }

    @media(max-width:480px) {
        .hero-breadcrumb {
            font-size: 11.5px;
        }

        .category-hero h1 {
            font-size: 35px;
        }

        .results-header {
            margin-bottom: 20px;
        }

        .service-content {
            padding: 15px;
        }

        .service-image {
            height: 180px;
        }

        .category-cta {
            margin-top: 45px;
        }

        .cta-actions {
            flex-direction: column;
        }

        .cta-btn {
            width: 100%;
        }
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">


<div class="service-category-page">

    {{-- =====================================================
         HERO
    ====================================================== --}}
    <section class="category-hero">
        <div class="service-container">

            <div class="hero-content">

                <div class="hero-breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>

                    <a href="{{ route('home.services') }}">
                        Services
                    </a>

                    <span>/</span>

                    <span class="current">
                        {{ $scategory->name }}
                    </span>
                </div>

                <div class="hero-label">
                    <span></span>
                    Service Category
                </div>

                <h1>
                    {{ $scategory->name }}
                </h1>

                <p>
                    Discover trusted services in
                    {{ strtolower($scategory->name) }}
                    and connect with professionals ready to help.
                </p>

            </div>

        </div>
    </section>


    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}
    <main class="category-main">

        <div class="service-container">

            {{-- Mobile category button --}}
            <button
                type="button"
                class="mobile-category-toggle"
                id="mobileCategoryToggle"
            >
                <svg width="17" height="17"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">
                    <path d="M4 6h16"/>
                    <path d="M7 12h10"/>
                    <path d="M10 18h4"/>
                </svg>

                Browse Categories
            </button>


            <div class="category-layout">

                {{-- =================================================
                     SIDEBAR
                ================================================== --}}
                <aside class="category-sidebar" id="categorySidebar">

                    <div class="sidebar-header">

                        <div class="eyebrow">
                            Explore
                        </div>

                        <h3>
                            Service Categories
                        </h3>

                    </div>


                    {{-- Sidebar search --}}
                    <div class="sidebar-search">

                        <svg width="15"
                             height="15"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <circle cx="11" cy="11" r="7"/>
                            <path d="m21 21-4.3-4.3"/>

                        </svg>

                        <input
                            type="text"
                            id="categorySearch"
                            placeholder="Search categories..."
                            autocomplete="off"
                        >

                    </div>


                    <ul class="category-list" id="categoryList">

                        @foreach($scategories as $scateg)

                            <li
                                class="category-item {{ $scateg->slug === $scategory->slug ? 'active open' : '' }}"
                                data-category-name="{{ strtolower($scateg->name) }}"
                            >

                                <div class="category-row">

                                    <a
                                        href="{{ route('home.service_by_category', ['category_slug' => $scateg->slug]) }}"
                                        class="category-link"
                                    >

                                        <span class="category-icon">

                                            <svg width="14"
                                                 height="14"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="2">

                                                <rect x="3" y="3" width="7" height="7" rx="1"/>
                                                <rect x="14" y="3" width="7" height="7" rx="1"/>
                                                <rect x="3" y="14" width="7" height="7" rx="1"/>
                                                <rect x="14" y="14" width="7" height="7" rx="1"/>

                                            </svg>

                                        </span>

                                        <span class="category-name">
                                            {{ $scateg->name }}
                                        </span>

                                    </a>


                                    @if(count($scateg->subcategories) > 0)

                                        <button
                                            type="button"
                                            class="category-chevron"
                                            aria-label="Show subcategories"
                                        >

                                            <svg width="14"
                                                 height="14"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="2.4">

                                                <path d="m9 6 6 6-6 6"/>

                                            </svg>

                                        </button>

                                    @endif

                                </div>


                                {{-- Subcategories --}}
                                @if(count($scateg->subcategories) > 0)

                                    <ul class="subcategory-list">

                                        @foreach($scateg->subcategories as $scat)

                                            <li>

                                                <a
                                                    href="{{ route('home.service_by_subcategory', ['subcategory_slug' => $scat->slug]) }}"
                                                >
                                                    {{ $scat->name }}
                                                </a>

                                            </li>

                                        @endforeach

                                    </ul>

                                @endif

                            </li>

                        @endforeach

                    </ul>

                </aside>


                {{-- =================================================
                     RESULTS
                ================================================== --}}
                <section>

                    {{-- Results header --}}
                    <div class="results-header">

                        <div class="results-heading">

                            <div class="eyebrow">
                                Available Services
                            </div>

                            <h2>
                                {{ $scategory->name }}
                            </h2>

                            <p>
                                <strong>
                                    {{ $scategory->services->count() }}
                                </strong>

                                service{{ $scategory->services->count() == 1 ? '' : 's' }}
                                available in this category.
                            </p>

                        </div>


                        <div class="results-tools">

                            {{-- Search --}}
                            <div class="service-search">

                                <svg width="15"
                                     height="15"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <circle cx="11" cy="11" r="7"/>
                                    <path d="m21 21-4.3-4.3"/>

                                </svg>

                                <input
                                    type="text"
                                    id="serviceSearch"
                                    placeholder="Search services..."
                                    autocomplete="off"
                                >

                            </div>


                            {{-- Sort --}}
                            <div class="sort-select">

                                <label for="sortServices">
                                    Sort
                                </label>

                                <select id="sortServices">

                                    <option value="latest">
                                        Latest
                                    </option>

                                    <option value="price-low">
                                        Price: Low
                                    </option>

                                    <option value="price-high">
                                        Price: High
                                    </option>

                                    <option value="name">
                                        Name
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>


                    {{-- Services --}}
                    <div class="services-grid" id="servicesGrid">

                        @if($scategory->services->count() > 0)

                            @foreach($scategory->services as $service)

                                @php

                                    $originalPrice = (float) $service->price;
                                    $total = $originalPrice;

                                    if ($service->discount) {

                                        if ($service->discount_type === 'fixed') {

                                            $total = $originalPrice - (float) $service->discount;

                                        } elseif ($service->discount_type === 'percent') {

                                            $total = $originalPrice -
                                                (
                                                    $originalPrice *
                                                    (float) $service->discount /
                                                    100
                                                );

                                        }

                                    }

                                    $total = max(0, $total);


                                    /*
                                    |--------------------------------------------------------------------------
                                    | WhatsApp
                                    |--------------------------------------------------------------------------
                                    */

                                    $waRawPhone =
                                        optional($service->sprovider ?? null)->phone
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
                                        'Hello! I\'m interested in booking "' .
                                        $service->name .
                                        '" (' .
                                        number_format($total) .
                                        ' RWF). Is it available?'
                                    );


                                    /*
                                    |--------------------------------------------------------------------------
                                    | Provider
                                    |--------------------------------------------------------------------------
                                    */

                                    $provider =
                                        optional($service->sprovider ?? null)->name
                                        ?? 'Service Provider';

                                @endphp


                                <article
                                    class="service-card"
                                    data-service-name="{{ strtolower($service->name) }}"
                                    data-service-price="{{ $total }}"
                                >

                                    {{-- Image --}}
                                    <div class="service-image">

                                        <a
                                            href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}"
                                        >

                                            <img
                                                src="{{ asset('image/services/' . ($service->image ?? 'default.png')) }}"
                                                alt="{{ $service->name }}"
                                                loading="lazy"
                                            >

                                        </a>

                                        <div class="image-overlay"></div>


                                        @if($service->duration)

                                            <span class="duration-badge">

                                                <svg width="11"
                                                     height="11"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="2">

                                                    <circle cx="12" cy="12" r="9"/>
                                                    <path d="M12 7v5l3 2"/>

                                                </svg>

                                                {{ $service->duration }}

                                            </span>

                                        @endif

                                    </div>


                                    {{-- Content --}}
                                    <div class="service-content">

                                        <span class="service-category">
                                            {{ $service->category->name ?? $scategory->name }}
                                        </span>


                                        <a
                                            href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}"
                                            class="service-name"
                                        >
                                            {{ $service->name }}
                                        </a>


                                        {{-- Price --}}
                                        <div class="service-price">

                                            @if($service->discount)

                                                <span class="price-original">
                                                    {{ number_format($originalPrice) }}
                                                </span>

                                                @if($service->discount_type === 'fixed')

                                                    <span class="discount">
                                                        -{{ number_format($service->discount) }}
                                                    </span>

                                                @else

                                                    <span class="discount">
                                                        -{{ $service->discount }}%
                                                    </span>

                                                @endif

                                            @endif

                                            <span class="price-main">
                                                {{ number_format($total) }}
                                            </span>

                                            <span class="price-currency">
                                                RWF
                                            </span>

                                        </div>


                                        {{-- Location --}}
                                        <div class="service-location">

                                            <svg width="13"
                                                 height="13"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="2">

                                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/>
                                                <circle cx="12" cy="10" r="3"/>

                                            </svg>

                                            <a
                                                href="{{ route('home.service_location', ['service_location' => $service->location]) }}"
                                            >
                                                {{ $service->location }}
                                            </a>

                                        </div>


                                        {{-- Provider --}}
                                        <div class="provider-row">

                                            <div class="provider-avatar">

                                                {{ strtoupper(substr($provider, 0, 1)) }}

                                            </div>

                                            <div class="provider-info">

                                                <span class="provider-label">
                                                    Provided by
                                                </span>

                                                <span class="provider-name">
                                                    {{ $provider }}
                                                </span>

                                            </div>

                                        </div>


                                        {{-- Actions --}}
                                        <div class="service-actions">

                                            <a
                                                href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}"
                                                class="service-btn service-btn-detail"
                                            >

                                                <svg width="13"
                                                     height="13"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="2">

                                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                                                    <circle cx="12" cy="12" r="3"/>

                                                </svg>

                                                View Details

                                            </a>


                                            <a
                                                href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="service-btn service-btn-whatsapp"
                                            >

                                                <svg width="14"
                                                     height="14"
                                                     viewBox="0 0 24 24"
                                                     fill="currentColor">

                                                    <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 004.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2zm5.8 14.1c-.24.68-1.4 1.3-1.93 1.38-.5.08-1.12.11-1.8-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.13-4.9-4.32-.14-.19-1.17-1.55-1.17-2.96 0-1.4.73-2.09 1-2.38.26-.28.57-.35.76-.35h.55c.18 0 .42-.07.65.5.24.58.82 2 .89 2.15.07.15.12.32.02.51-.09.19-.14.31-.28.48-.14.16-.29.36-.42.49-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.28.36-.23.6-.14.24.09 1.55.73 1.82.86.27.14.44.2.51.32.07.12.07.68-.17 1.36z"/>

                                                </svg>

                                                WhatsApp

                                            </a>

                                        </div>

                                    </div>

                                </article>

                            @endforeach


                            {{-- Search empty state --}}
                            <div
                                class="search-empty"
                                id="searchEmpty"
                            >

                                <div class="empty-icon">

                                    <svg width="24"
                                         height="24"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">

                                        <circle cx="11" cy="11" r="7"/>
                                        <path d="m21 21-4.3-4.3"/>

                                    </svg>

                                </div>

                                <h4>
                                    No matching services
                                </h4>

                                <p>
                                    Try another service name or clear your search.
                                </p>

                            </div>

                        @else

                            <div class="empty-state">

                                <div class="empty-icon">

                                    <svg width="25"
                                         height="25"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">

                                        <circle cx="11" cy="11" r="7"/>
                                        <path d="m21 21-4.3-4.3"/>

                                    </svg>

                                </div>

                                <h3>
                                    No services available yet
                                </h3>

                                <p>
                                    There are currently no services listed in this category.
                                    Please check back soon or explore another category.
                                </p>

                            </div>

                        @endif

                    </div>

                </section>

            </div>


            {{-- =================================================
                 CTA
            ================================================== --}}
            <div class="category-cta">

                <div class="cta-content">

                    <h2>
                        Need help finding the right service?
                    </h2>

                    <p>
                        Explore more categories or join our growing service marketplace.
                    </p>

                </div>


                <div class="cta-actions">

                    <a
                        href="{{ route('home.services') }}"
                        class="cta-btn cta-btn-light"
                    >
                        Explore Services
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="cta-btn cta-btn-outline"
                    >
                        Join as Provider
                    </a>

                </div>

            </div>

        </div>

    </main>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | CATEGORY SIDEBAR
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.category-chevron').forEach(function (button) {

        button.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            const item = this.closest('.category-item');

            if (item) {
                item.classList.toggle('open');
            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | CATEGORY SEARCH
    |--------------------------------------------------------------------------
    */

    const categorySearch =
        document.getElementById('categorySearch');

    if (categorySearch) {

        categorySearch.addEventListener('input', function () {

            const term =
                this.value
                    .trim()
                    .toLowerCase();

            document
                .querySelectorAll('.category-item')
                .forEach(function (item) {

                    const name =
                        item.dataset.categoryName || '';

                    item.style.display =
                        name.includes(term)
                            ? ''
                            : 'none';

                });

        });

    }


    /*
    |--------------------------------------------------------------------------
    | MOBILE CATEGORY SIDEBAR
    |--------------------------------------------------------------------------
    */

    const mobileToggle =
        document.getElementById('mobileCategoryToggle');

    const categorySidebar =
        document.getElementById('categorySidebar');

    if (mobileToggle && categorySidebar) {

        mobileToggle.addEventListener('click', function () {

            categorySidebar.classList.toggle('show');

            const isOpen =
                categorySidebar.classList.contains('show');

            this.innerHTML = isOpen
                ? `
                    <svg width="17" height="17"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="M18 6 6 18"/>
                        <path d="m6 6 12 12"/>
                    </svg>
                    Close Categories
                  `
                : `
                    <svg width="17" height="17"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="M4 6h16"/>
                        <path d="M7 12h10"/>
                        <path d="M10 18h4"/>
                    </svg>
                    Browse Categories
                  `;

        });

    }


    /*
    |--------------------------------------------------------------------------
    | SERVICE SEARCH
    |--------------------------------------------------------------------------
    */

    const serviceSearch =
        document.getElementById('serviceSearch');

    const serviceCards =
        Array.from(
            document.querySelectorAll('.service-card')
        );

    const searchEmpty =
        document.getElementById('searchEmpty');


    function filterServices() {

        const term =
            serviceSearch
                ? serviceSearch.value.trim().toLowerCase()
                : '';

        let visibleCount = 0;

        serviceCards.forEach(function (card) {

            const name =
                card.dataset.serviceName || '';

            const matches =
                name.includes(term);

            card.style.display =
                matches ? '' : 'none';

            if (matches) {
                visibleCount++;
            }

        });

        if (searchEmpty) {

            searchEmpty.classList.toggle(
                'show',
                term.length > 0 && visibleCount === 0
            );

        }

    }


    if (serviceSearch) {

        serviceSearch.addEventListener(
            'input',
            filterServices
        );

    }


    /*
    |--------------------------------------------------------------------------
    | SORT SERVICES
    |--------------------------------------------------------------------------
    */

    const sortServices =
        document.getElementById('sortServices');


    if (sortServices) {

        sortServices.addEventListener('change', function () {

            const grid =
                document.getElementById('servicesGrid');

            if (!grid) return;

            const cards =
                Array.from(
                    grid.querySelectorAll('.service-card')
                );

            const sort =
                this.value;


            cards.sort(function (a, b) {

                if (sort === 'price-low') {

                    return Number(a.dataset.servicePrice)
                        - Number(b.dataset.servicePrice);

                }

                if (sort === 'price-high') {

                    return Number(b.dataset.servicePrice)
                        - Number(a.dataset.servicePrice);

                }

                if (sort === 'name') {

                    return (
                        a.dataset.serviceName || ''
                    ).localeCompare(
                        b.dataset.serviceName || ''
                    );

                }

                return 0;

            });


            cards.forEach(function (card) {
                grid.appendChild(card);
            });

        });

    }

});
</script>

@endsection