@extends('layouts.base')

@section('title', 'Services in ' . ($locationName ?? request()->route('service_location') ?? 'Your Area'))

@section('content')

@php
    $locationName = $location ?? request()->route('service_location') ?? 'this area';

    /*
    |--------------------------------------------------------------------------
    | Total result count
    |--------------------------------------------------------------------------
    | Use total() when $locations is a paginator.
    | This prevents showing only the number of records on the current page.
    */
    $locationCount = method_exists($locations, 'total')
        ? $locations->total()
        : $locations->count();
@endphp

<style>
    :root {
        --location-primary: #6B9080;
        --location-dark: #254035;
        --location-white: #FFFFFF;

        --location-soft: #F1F6F3;
        --location-soft-2: #F7FAF8;
        --location-border: #DDE8E3;
        --location-muted: #708078;
        --location-text: #1C3028;

        --location-radius-sm: 10px;
        --location-radius-md: 16px;
        --location-radius-lg: 22px;

        --location-shadow: 0 4px 20px rgba(37, 64, 53, .07);
        --location-shadow-hover: 0 14px 34px rgba(37, 64, 53, .14);

        --location-transition: .22s ease;
    }

    * {
        box-sizing: border-box;
    }

    .location-page {
        min-height: 100vh;
        background: var(--location-white);
        color: var(--location-text);
        font-family: "DM Sans", sans-serif;
    }

    .location-page a {
        text-decoration: none;
    }

    .location-container {
        width: min(1240px, calc(100% - 40px));
        margin: 0 auto;
    }

    /* =========================================================
       HERO
    ========================================================= */

    .location-hero {
        position: relative;
        overflow: hidden;
        padding: 58px 0 62px;
        background:
            linear-gradient(
                135deg,
                rgba(37, 64, 53, .98),
                rgba(37, 64, 53, .92)
            );
    }

    .location-hero::before {
        content: "";
        position: absolute;
        width: 430px;
        height: 430px;
        border-radius: 50%;
        background: rgba(107, 144, 128, .14);
        top: -250px;
        right: -120px;
    }

    .location-hero::after {
        content: "";
        position: absolute;
        width: 290px;
        height: 290px;
        border-radius: 50%;
        background: rgba(107, 144, 128, .10);
        bottom: -190px;
        left: -100px;
    }

    .location-hero-content {
        position: relative;
        z-index: 2;
        max-width: 850px;
        margin: 0 auto;
        text-align: center;
    }

    .location-breadcrumb {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
        color: rgba(255,255,255,.55);
        font-size: 13px;
    }

    .location-breadcrumb a {
        color: rgba(255,255,255,.82);
        transition: var(--location-transition);
    }

    .location-breadcrumb a:hover {
        color: #fff;
    }

    .location-breadcrumb .current {
        color: #fff;
        font-weight: 600;
    }

    .location-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 16px;
        padding: 7px 14px;
        color: #fff;
        background: rgba(255,255,255,.10);
        border: 1px solid rgba(255,255,255,.16);
        border-radius: 100px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .location-label svg {
        color: var(--location-primary);
    }

    .location-hero h1 {
        margin: 0;
        color: #fff;
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(34px, 5vw, 58px);
        line-height: 1.1;
        font-weight: 700;
    }

    .location-hero p {
        max-width: 650px;
        margin: 17px auto 0;
        color: rgba(255,255,255,.68);
        font-size: 15px;
        line-height: 1.7;
    }

    .hero-location-name {
        color: var(--location-primary);
    }

    /* =========================================================
       MAIN
    ========================================================= */

    .location-main {
        padding: 48px 0 90px;
    }

    .location-layout {
        display: grid;
        grid-template-columns: 290px minmax(0, 1fr);
        gap: 30px;
        align-items: start;
    }

    /* =========================================================
       SIDEBAR
    ========================================================= */

    .location-sidebar {
        position: sticky;
        top: 90px;
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--location-border);
        border-radius: var(--location-radius-lg);
        box-shadow: var(--location-shadow);
    }

    .sidebar-header {
        padding: 21px 21px 17px;
        border-bottom: 1px solid var(--location-border);
    }

    .sidebar-header .eyebrow {
        margin-bottom: 4px;
        color: var(--location-primary);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .11em;
        text-transform: uppercase;
    }

    .sidebar-header h3 {
        margin: 0;
        color: var(--location-dark);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 21px;
        font-weight: 700;
    }

    .sidebar-header p {
        margin: 6px 0 0;
        color: var(--location-muted);
        font-size: 12px;
        line-height: 1.5;
    }

    .sidebar-search {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 16px 16px 8px;
        padding: 10px 14px;
        background: var(--location-soft-2);
        border: 1px solid var(--location-border);
        border-radius: 100px;
    }

    .sidebar-search svg {
        flex-shrink: 0;
        color: var(--location-primary);
    }

    .sidebar-search input {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;
        color: var(--location-text);
        font-size: 13px;
    }

    .sidebar-search input::placeholder {
        color: #8B9A93;
    }

    .category-list {
        max-height: 530px;
        overflow-y: auto;
        list-style: none;
        padding: 10px 10px 14px;
        margin: 0;
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
        border-radius: var(--location-radius-sm);
    }

    .category-row {
        display: flex;
        align-items: center;
        min-height: 45px;
        border-radius: var(--location-radius-sm);
        transition: var(--location-transition);
    }

    .category-row:hover {
        background: var(--location-soft-2);
    }

    .category-link {
        display: flex;
        align-items: center;
        flex: 1;
        gap: 10px;
        min-width: 0;
        padding: 11px 10px;
        color: var(--location-text);
        font-size: 13.5px;
        font-weight: 500;
    }

    .category-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 29px;
        height: 29px;
        flex-shrink: 0;
        border-radius: 8px;
        background: var(--location-soft-2);
        color: var(--location-primary);
    }

    .category-name {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .category-chevron {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        margin-right: 5px;
        border: none;
        background: transparent;
        color: var(--location-muted);
        cursor: pointer;
        border-radius: 50%;
        transition: var(--location-transition);
    }

    .category-chevron:hover {
        background: var(--location-soft);
        color: var(--location-dark);
    }

    .category-chevron svg {
        transition: transform var(--location-transition);
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
        color: var(--location-muted);
        border-radius: 7px;
        font-size: 12.5px;
        transition: var(--location-transition);
    }

    .subcategory-list a:hover {
        background: var(--location-soft);
        color: var(--location-dark);
    }

    /* =========================================================
       MOBILE FILTER
    ========================================================= */

    .mobile-filter-toggle {
        display: none;
        align-items: center;
        justify-content: center;
        width: 100%;
        gap: 8px;
        margin-bottom: 18px;
        padding: 13px 16px;
        border: none;
        border-radius: var(--location-radius-sm);
        background: var(--location-dark);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
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
        border-bottom: 1px solid var(--location-border);
    }

    .results-heading {
        min-width: 0;
    }

    .results-heading .eyebrow {
        margin-bottom: 4px;
        color: var(--location-primary);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .11em;
        text-transform: uppercase;
    }

    .results-heading h2 {
        margin: 0;
        color: var(--location-dark);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 27px;
        font-weight: 700;
    }

    .results-heading p {
        margin: 5px 0 0;
        color: var(--location-muted);
        font-size: 13px;
    }

    .results-heading p strong {
        color: var(--location-primary);
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
        background: #fff;
        border: 1px solid var(--location-border);
        border-radius: 100px;
    }

    .service-search svg {
        flex-shrink: 0;
        color: var(--location-primary);
    }

    .service-search input {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;
        color: var(--location-text);
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
        color: var(--location-muted);
        font-size: 12.5px;
        font-weight: 600;
    }

    .sort-select select {
        min-width: 115px;
        padding: 9px 11px;
        outline: none;
        border: 1px solid var(--location-border);
        border-radius: var(--location-radius-sm);
        background: #fff;
        color: var(--location-text);
        font-size: 12.5px;
        cursor: pointer;
    }

    .sort-select select:focus {
        border-color: var(--location-primary);
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
        background: #fff;
        border: 1px solid var(--location-border);
        border-radius: var(--location-radius-lg);
        box-shadow: var(--location-shadow);
        transition:
            transform var(--location-transition),
            box-shadow var(--location-transition),
            border-color var(--location-transition);
    }

    .service-card:hover {
        transform: translateY(-4px);
        border-color: #C9DAD3;
        box-shadow: var(--location-shadow-hover);
    }

    .service-image {
        position: relative;
        height: 170px;
        overflow: hidden;
        background: var(--location-soft);
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
            rgba(37,64,53,.03),
            rgba(37,64,53,.32)
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
        background: rgba(37,64,53,.88);
        backdrop-filter: blur(5px);
        color: #fff;
        border-radius: 100px;
        font-size: 10.5px;
        font-weight: 700;
    }

    .location-badge {
        position: absolute;
        left: 11px;
        top: 11px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        max-width: calc(100% - 100px);
        padding: 6px 10px;
        background: rgba(255,255,255,.92);
        backdrop-filter: blur(5px);
        color: var(--location-dark);
        border-radius: 100px;
        font-size: 10.5px;
        font-weight: 700;
    }

    .location-badge span {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
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
        color: var(--location-primary);
        font-size: 9.5px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .service-name {
        display: -webkit-box;
        overflow: hidden;
        margin-bottom: 12px;
        color: var(--location-dark);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.3;

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
        color: var(--location-muted);
        text-decoration: line-through;
        font-size: 11.5px;
    }

    .price-main {
        color: var(--location-dark);
        font-size: 18px;
        font-weight: 800;
    }

    .price-currency {
        color: var(--location-muted);
        font-size: 10.5px;
        font-weight: 600;
    }

    .discount {
        padding: 3px 7px;
        background: var(--location-primary);
        color: #fff;
        border-radius: 100px;
        font-size: 9.5px;
        font-weight: 800;
    }

    .service-location {
        display: flex;
        align-items: center;
        gap: 6px;
        min-width: 0;
        margin: 2px 0 15px;
        color: var(--location-muted);
        font-size: 11.5px;
    }

    .service-location svg {
        flex-shrink: 0;
        color: var(--location-primary);
    }

    .service-location a {
        overflow: hidden;
        color: var(--location-muted);
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .service-location a:hover {
        color: var(--location-primary);
    }

    /* =========================================================
       PROVIDER
    ========================================================= */

    .provider-row {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 9px 0;
        margin-bottom: 13px;
        border-top: 1px solid var(--location-border);
        border-bottom: 1px solid var(--location-border);
    }

    .provider-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        flex-shrink: 0;
        overflow: hidden;
        border-radius: 50%;
        background: var(--location-soft);
        color: var(--location-primary);
        font-size: 12px;
        font-weight: 800;
    }

    .provider-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .provider-info {
        min-width: 0;
    }

    .provider-label {
        display: block;
        color: var(--location-muted);
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
    }

    .provider-name {
        display: block;
        overflow: hidden;
        color: var(--location-dark);
        font-size: 11.5px;
        font-weight: 700;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    /* =========================================================
       ACTIONS
    ========================================================= */

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
        border-radius: var(--location-radius-sm);
        font-size: 11.5px;
        font-weight: 700;
        transition: var(--location-transition);
    }

    .service-btn-detail {
        background: var(--location-soft);
        color: var(--location-dark);
    }

    .service-btn-detail:hover {
        background: var(--location-dark);
        color: #fff;
    }

    .service-btn-whatsapp {
        background: var(--location-primary);
        color: #fff;
    }

    .service-btn-whatsapp:hover {
        background: var(--location-dark);
        color: #fff;
    }

    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .empty-state {
        grid-column: 1 / -1;
        padding: 70px 25px;
        text-align: center;
        background: var(--location-soft-2);
        border: 1px dashed var(--location-border);
        border-radius: var(--location-radius-lg);
    }

    .empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 62px;
        height: 62px;
        margin: 0 auto 15px;
        background: var(--location-soft);
        color: var(--location-primary);
        border-radius: 50%;
    }

    .empty-state h3 {
        margin: 0 0 6px;
        color: var(--location-dark);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 20px;
    }

    .empty-state p {
        margin: 0;
        color: var(--location-muted);
        font-size: 13px;
    }

    .empty-state-actions {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .empty-state-actions a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 18px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 700;
    }

    .empty-primary {
        background: var(--location-dark);
        color: #fff;
    }

    .empty-primary:hover {
        color: #fff;
        background: var(--location-primary);
    }

    .empty-secondary {
        background: var(--location-soft);
        color: var(--location-dark);
    }

    .empty-secondary:hover {
        background: var(--location-border);
        color: var(--location-dark);
    }

    /* =========================================================
       SEARCH EMPTY
    ========================================================= */

    .search-empty {
        display: none;
        grid-column: 1 / -1;
        padding: 55px 20px;
        text-align: center;
        background: var(--location-soft-2);
        border: 1px dashed var(--location-border);
        border-radius: var(--location-radius-lg);
    }

    .search-empty.show {
        display: block;
    }

    .search-empty h4 {
        margin: 0 0 5px;
        color: var(--location-dark);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 19px;
    }

    .search-empty p {
        margin: 0;
        color: var(--location-muted);
        font-size: 13px;
    }

    /* =========================================================
       CTA
    ========================================================= */

    .location-cta {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
        overflow: hidden;
        margin-top: 65px;
        padding: 38px 42px;
        background: var(--location-dark);
        border-radius: var(--location-radius-lg);
    }

    .location-cta::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        top: -120px;
        right: -100px;
        background: rgba(107,144,128,.13);
        border-radius: 50%;
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
        color: rgba(255,255,255,.62);
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
        transition: var(--location-transition);
    }

    .cta-btn-light {
        background: #fff;
        color: var(--location-dark);
    }

    .cta-btn-light:hover {
        color: var(--location-dark);
        transform: translateY(-2px);
    }

    .cta-btn-outline {
        background: transparent;
        border: 1px solid rgba(255,255,255,.35);
        color: #fff;
    }

    .cta-btn-outline:hover {
        background: rgba(255,255,255,.08);
        border-color: #fff;
        color: #fff;
    }

    /* =========================================================
       PAGINATION
    ========================================================= */

    .location-pagination {
        display: flex;
        justify-content: center;
        margin-top: 35px;
    }

    .location-pagination nav {
        width: 100%;
    }

    .location-pagination .pagination {
        justify-content: center;
        margin-bottom: 0;
    }

    .location-pagination .page-link {
        color: var(--location-dark);
        border-color: var(--location-border);
    }

    .location-pagination .page-item.active .page-link {
        background: var(--location-primary);
        border-color: var(--location-primary);
        color: #fff;
    }

    .location-pagination .page-link:hover {
        background: var(--location-soft);
        color: var(--location-dark);
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
        .location-layout {
            display: block;
        }

        .mobile-filter-toggle {
            display: flex;
        }

        .location-sidebar {
            position: static;
            display: none;
            margin-bottom: 25px;
        }

        .location-sidebar.show {
            display: block;
        }

        .category-list {
            max-height: 400px;
        }
    }

    @media(max-width:700px) {
        .location-container {
            width: min(100% - 28px, 1240px);
        }

        .location-hero {
            padding: 45px 0 48px;
        }

        .location-main {
            padding: 32px 0 65px;
        }

        .location-hero p {
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

        .location-cta {
            flex-direction: column;
            align-items: flex-start;
            padding: 30px 24px;
        }

        .cta-actions {
            width: 100%;
        }

        .cta-btn {
            flex: 1;
        }
    }

    @media(max-width:480px) {
        .location-breadcrumb {
            font-size: 11.5px;
        }

        .location-hero h1 {
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

        .location-cta {
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
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="location-page">

    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="location-hero">
        <div class="location-container">

            <div class="location-hero-content">

                <div class="location-breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>

                    <a href="{{ route('home.services') }}">
                        Services
                    </a>

                    <span>/</span>

                    <span class="current">
                        {{ $locationName }}
                    </span>
                </div>

                <div class="location-label">
                    <svg width="13"
                         height="13"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>

                    Service Location
                </div>

                <h1>
                    Services in
                    <span class="hero-location-name">
                        {{ $locationName }}
                    </span>
                </h1>

                <p>
                    Discover trusted professionals and reliable services
                    available in {{ $locationName }}.
                    Find the right service and connect directly with a provider.
                </p>

            </div>

        </div>
    </section>


    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

    <main class="location-main">

        <div class="location-container">

            <button
                type="button"
                class="mobile-filter-toggle"
                id="mobileFilterToggle">

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

                Browse Categories
            </button>


            <div class="location-layout">

                {{-- =================================================
                     SIDEBAR
                ================================================== --}}

                <aside
                    class="location-sidebar"
                    id="locationSidebar">

                    <div class="sidebar-header">

                        <div class="eyebrow">
                            Explore services
                        </div>

                        <h3>
                            Categories
                        </h3>

                        <p>
                            Browse {{ $locationName }} services
                            by category.
                        </p>

                    </div>


                    <div class="sidebar-search">

                        <svg width="15"
                             height="15"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <circle cx="11"
                                    cy="11"
                                    r="7"/>

                            <path d="m21 21-4.3-4.3"/>

                        </svg>

                        <input
                            type="text"
                            id="categorySearch"
                            placeholder="Search categories">

                    </div>


                    <ul
                        class="category-list"
                        id="categoryList">

                        @foreach($scategories as $scateg)

                            <li class="category-item">

                                <div class="category-row">

                                    <a
                                        href="{{ route('home.service_by_category', [
                                            'category_slug' => $scateg->slug
                                        ]) }}"
                                        class="category-link">

                                        <span class="category-icon">

                                            <svg width="14"
                                                 height="14"
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

                                        </span>

                                        <span class="category-name">
                                            {{ $scateg->name }}
                                        </span>

                                    </a>


                                    @if($scateg->subcategories->count())

                                        <button
                                            type="button"
                                            class="category-chevron"
                                            aria-label="Toggle {{ $scateg->name }}">

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


                                @if($scateg->subcategories->count())

                                    <ul class="subcategory-list">

                                        @foreach($scateg->subcategories as $subcategory)

                                            <li>

                                                <a
                                                    href="{{ route('home.service_by_subcategory', [
                                                        'subcategory_slug' => $subcategory->slug
                                                    ]) }}">

                                                    {{ $subcategory->name }}

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

                    <div class="results-header">

                        <div class="results-heading">

                            <div class="eyebrow">
                                Local services
                            </div>

                            <h2>
                                Services in {{ $locationName }}
                            </h2>

                            <p>
                                <strong>{{ number_format($locationCount) }}</strong>
                                service{{ $locationCount == 1 ? '' : 's' }}
                                available in this location.
                            </p>

                        </div>


                        <div class="results-tools">

                            <div class="service-search">

                                <svg width="15"
                                     height="15"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <circle cx="11"
                                            cy="11"
                                            r="7"/>

                                    <path d="m21 21-4.3-4.3"/>

                                </svg>

                                <input
                                    type="text"
                                    id="serviceSearch"
                                    placeholder="Search services...">

                            </div>


                            <div class="sort-select">

                                <label for="sortBy">
                                    Sort
                                </label>

                                <select id="sortBy">

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


                    <div
                        class="services-grid"
                        id="servicesGrid">

                        @forelse($locations as $service)

                            @php

                                /*
                                |--------------------------------------------------------------------------
                                | Calculate final price
                                |--------------------------------------------------------------------------
                                */

                                $price = (float) ($service->price ?? 0);

                                $discount = (float) ($service->discount ?? 0);

                                $total = $price;

                                if ($discount > 0) {

                                    if ($service->discount_type === 'fixed') {

                                        $total = max(
                                            0,
                                            $price - $discount
                                        );

                                    } elseif ($service->discount_type === 'percent') {

                                        $total = max(
                                            0,
                                            $price - ($price * $discount / 100)
                                        );

                                    }

                                }

                                /*
                                |--------------------------------------------------------------------------
                                | Provider
                                |--------------------------------------------------------------------------
                                */

                                $provider =
                                    $service->provider
                                    ?? $service->sprovider
                                    ?? null;

                                $providerUser =
                                    $provider?->user;

                                $providerName =
                                    $providerUser?->name
                                    ?? 'Service Provider';

                                /*
                                |--------------------------------------------------------------------------
                                | Provider image
                                |--------------------------------------------------------------------------
                                */

                                $providerImage = null;

                                if ($provider?->image) {

                                    $providerImage =
                                        asset(
                                            'image/service_provider/' .
                                            $provider->image
                                        );

                                }

                                /*
                                |--------------------------------------------------------------------------
                                | Provider phone
                                |--------------------------------------------------------------------------
                                */

                                $waRawPhone =
                                    $provider?->phone
                                    ?? config(
                                        'services.whatsapp.default_number',
                                        '250780000000'
                                    );

                                $waPhone =
                                    preg_replace(
                                        '/\D+/',
                                        '',
                                        $waRawPhone
                                    );

                                $waMessage =
                                    rawurlencode(
                                        'Hello! I\'m interested in booking "' .
                                        $service->name .
                                        '" (' .
                                        number_format($total) .
                                        ' RWF). Is it available?'
                                    );

                                /*
                                |--------------------------------------------------------------------------
                                | Initial
                                |--------------------------------------------------------------------------
                                */

                                $providerInitial =
                                    strtoupper(
                                        substr(
                                            $providerName,
                                            0,
                                            1
                                        )
                                    );

                            @endphp


                            <article
                                class="service-card"
                                data-name="{{ strtolower($service->name) }}"
                                data-category="{{ strtolower($service->category?->name ?? '') }}"
                                data-price="{{ $total }}"
                                data-date="{{ optional($service->created_at)->timestamp ?? 0 }}">

                                {{-- IMAGE --}}

                                <div class="service-image">

                                    <a
                                        href="{{ route('home.service_details', [
                                            'service_slug' => $service->slug
                                        ]) }}">

                                        <img
                                            src="{{ asset(
                                                'image/services/' .
                                                ($service->image ?? 'default.png')
                                            ) }}"
                                            alt="{{ $service->name }}"
                                            loading="lazy">

                                    </a>

                                    <div class="image-overlay"></div>


                                    @if($service->location)

                                        <div class="location-badge">

                                            <svg width="11"
                                                 height="11"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="2">

                                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/>

                                                <circle cx="12"
                                                        cy="10"
                                                        r="3"/>

                                            </svg>

                                            <span>
                                                {{ $service->location }}
                                            </span>

                                        </div>

                                    @endif


                                    @if($service->duration)

                                        <span class="duration-badge">

                                            <svg width="11"
                                                 height="11"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="2">

                                                <circle cx="12"
                                                        cy="12"
                                                        r="9"/>

                                                <path d="M12 7v5l3 2"/>

                                            </svg>

                                            {{ $service->duration }}

                                        </span>

                                    @endif

                                </div>


                                {{-- CONTENT --}}

                                <div class="service-content">

                                    <div class="service-category">

                                        {{ $service->category?->name ?? 'Service' }}

                                    </div>


                                    <a
                                        href="{{ route('home.service_details', [
                                            'service_slug' => $service->slug
                                        ]) }}"
                                        class="service-name">

                                        {{ $service->name }}

                                    </a>


                                    {{-- PRICE --}}

                                    <div class="service-price">

                                        @if($discount > 0)

                                            <span class="price-original">

                                                {{ number_format($price) }}

                                            </span>

                                            @if($service->discount_type === 'fixed')

                                                <span class="discount">

                                                    -{{ number_format($discount) }}
                                                    RWF

                                                </span>

                                            @else

                                                <span class="discount">

                                                    -{{ number_format($discount) }}%

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


                                    {{-- LOCATION --}}

                                    <div class="service-location">

                                        <svg width="13"
                                             height="13"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="2">

                                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/>

                                            <circle cx="12"
                                                    cy="10"
                                                    r="3"/>

                                        </svg>

                                        <a
                                            href="{{ route('home.service_location', [
                                                'service_location' => $service->location
                                            ]) }}">

                                            {{ $service->location }}

                                        </a>

                                    </div>


                                    {{-- PROVIDER --}}

                                    <div class="provider-row">

                                        <div class="provider-avatar">

                                            @if($providerImage)

                                                <img
                                                    src="{{ $providerImage }}"
                                                    alt="{{ $providerName }}">

                                            @else

                                                {{ $providerInitial }}

                                            @endif

                                        </div>


                                        <div class="provider-info">

                                            <span class="provider-label">
                                                Service provider
                                            </span>

                                            <span class="provider-name">
                                                {{ $providerName }}
                                            </span>

                                        </div>

                                    </div>


                                    {{-- ACTIONS --}}

                                    <div class="service-actions">

                                        <a
                                            href="{{ route('home.service_details', [
                                                'service_slug' => $service->slug
                                            ]) }}"
                                            class="service-btn service-btn-detail">

                                            <svg width="13"
                                                 height="13"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="2">

                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>

                                                <circle cx="12"
                                                        cy="12"
                                                        r="3"/>

                                            </svg>

                                            View Detail

                                        </a>


                                        <a
                                            href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}"
                                            target="_blank"
                                            rel="noopener"
                                            class="service-btn service-btn-whatsapp">

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

                        @empty

                            <div class="empty-state">

                                <div class="empty-icon">

                                    <svg width="26"
                                         height="26"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">

                                        <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/>

                                        <circle cx="12"
                                                cy="10"
                                                r="3"/>

                                    </svg>

                                </div>

                                <h3>
                                    No services found in {{ $locationName }}
                                </h3>

                                <p>
                                    There are currently no services listed
                                    in this location.
                                </p>

                                <div class="empty-state-actions">

                                    <a
                                        href="{{ route('home.services') }}"
                                        class="empty-primary">

                                        Browse all services

                                    </a>

                                    <a
                                        href="{{ route('home') }}"
                                        class="empty-secondary">

                                        Back to home

                                    </a>

                                </div>

                            </div>

                        @endforelse


                        {{-- SEARCH EMPTY STATE --}}

                        <div
                            class="search-empty"
                            id="searchEmpty">

                            <h4>
                                No matching services
                            </h4>

                            <p>
                                Try another service name or category.
                            </p>

                        </div>

                    </div>


                    {{-- PAGINATION --}}

                    @if(method_exists($locations, 'links'))

                        <div class="location-pagination">

                            {{ $locations->withQueryString()->links() }}

                        </div>

                    @endif

                </section>

            </div>


            {{-- =================================================
                 CTA
            ================================================== --}}

            <div class="location-cta">

                <div class="cta-content">

                    <h2>
                        Looking for something specific?
                    </h2>

                    <p>
                        Explore more services or join the platform
                        as a service provider.
                    </p>

                </div>


                <div class="cta-actions">

                    <a
                        href="{{ route('home.services') }}"
                        class="cta-btn cta-btn-light">

                        <svg width="14"
                             height="14"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <circle cx="11"
                                    cy="11"
                                    r="7"/>

                            <path d="m21 21-4.3-4.3"/>

                        </svg>

                        Browse Services

                    </a>


                    <a
                        href="{{ route('register') }}"
                        class="cta-btn cta-btn-outline">

                        Join the Team

                        <svg width="14"
                             height="14"
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

    </main>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        /*
        |--------------------------------------------------------------------------
        | Mobile sidebar
        |--------------------------------------------------------------------------
        */

        const mobileFilterToggle =
            document.getElementById('mobileFilterToggle');

        const locationSidebar =
            document.getElementById('locationSidebar');

        if (mobileFilterToggle && locationSidebar) {

            mobileFilterToggle.addEventListener('click', function () {

                locationSidebar.classList.toggle('show');

                if (locationSidebar.classList.contains('show')) {

                    this.innerHTML = `
                        <svg width="16"
                             height="16"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <path d="M18 6 6 18"/>
                            <path d="m6 6 12 12"/>
                        </svg>
                        Close Categories
                    `;

                } else {

                    this.innerHTML = `
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
                        Browse Categories
                    `;

                }

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Category accordion
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.category-chevron')
            .forEach(function (button) {

                button.addEventListener('click', function (event) {

                    event.preventDefault();
                    event.stopPropagation();

                    const item =
                        button.closest('.category-item');

                    if (item) {
                        item.classList.toggle('open');
                    }

                });

            });


        /*
        |--------------------------------------------------------------------------
        | Sidebar category search
        |--------------------------------------------------------------------------
        */

        const categorySearch =
            document.getElementById('categorySearch');

        const categoryItems =
            document.querySelectorAll('.category-item');

        if (categorySearch) {

            categorySearch.addEventListener('input', function () {

                const term =
                    this.value
                        .trim()
                        .toLowerCase();

                categoryItems.forEach(function (item) {

                    const name =
                        item
                            .querySelector('.category-name')
                            ?.textContent
                            .toLowerCase() || '';

                    const subcategories =
                        item
                            .querySelector('.subcategory-list')
                            ?.textContent
                            .toLowerCase() || '';

                    const match =
                        name.includes(term) ||
                        subcategories.includes(term);

                    item.style.display =
                        match ? '' : 'none';

                    if (
                        term &&
                        match &&
                        subcategories.includes(term)
                    ) {
                        item.classList.add('open');
                    }

                });

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Service search
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
                    ? serviceSearch.value
                        .trim()
                        .toLowerCase()
                    : '';

            let visible = 0;

            serviceCards.forEach(function (card) {

                const name =
                    card.dataset.name || '';

                const category =
                    card.dataset.category || '';

                const matches =
                    !term ||
                    name.includes(term) ||
                    category.includes(term);

                card.style.display =
                    matches ? '' : 'none';

                if (matches) {
                    visible++;
                }

            });

            if (searchEmpty) {

                searchEmpty.classList.toggle(
                    'show',
                    visible === 0 && serviceCards.length > 0
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
        | Client-side sorting
        |--------------------------------------------------------------------------
        */

        const sortBy =
            document.getElementById('sortBy');

        const servicesGrid =
            document.getElementById('servicesGrid');

        if (sortBy && servicesGrid) {

            sortBy.addEventListener('change', function () {

                const cards =
                    Array.from(
                        servicesGrid.querySelectorAll(
                            '.service-card'
                        )
                    );

                const mode = this.value;

                cards.sort(function (a, b) {

                    if (mode === 'price-low') {

                        return (
                            parseFloat(a.dataset.price || 0) -
                            parseFloat(b.dataset.price || 0)
                        );

                    }

                    if (mode === 'price-high') {

                        return (
                            parseFloat(b.dataset.price || 0) -
                            parseFloat(a.dataset.price || 0)
                        );

                    }

                    if (mode === 'name') {

                        return (
                            a.dataset.name || ''
                        ).localeCompare(
                            b.dataset.name || ''
                        );

                    }

                    return (
                        parseInt(b.dataset.date || 0) -
                        parseInt(a.dataset.date || 0)
                    );

                });

                const empty =
                    servicesGrid.querySelector('.empty-state');

                const searchEmptyElement =
                    servicesGrid.querySelector('.search-empty');

                cards.forEach(function (card) {

                    servicesGrid.appendChild(card);

                });

                if (empty) {
                    servicesGrid.appendChild(empty);
                }

                if (searchEmptyElement) {
                    servicesGrid.appendChild(
                        searchEmptyElement
                    );
                }

            });

        }

    });
</script>

@endsection