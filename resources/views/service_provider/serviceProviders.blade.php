@extends('layouts.base')

@section('title', 'Service Providers')

@section('content')

@php
    $currentSearch   = request('search', '');
    $currentCategory = request('category', '');
    $currentLocation = request('location', '');
    $currentSort     = request('sort', 'latest');

    $providerCount = $sproviders->total();

    $selectedCategory = collect($categories ?? [])->firstWhere('slug', $currentCategory);

    $defaultWhatsapp = config(
        'services.whatsapp.default_number',
        '250780000000'
    );

    $hasFilters = $currentSearch || $currentCategory || $currentLocation;

    $buildFilterUrl = function ($params = []) {
        $query = array_merge(request()->query(), $params);

        foreach ($query as $key => $value) {
            if ($value === null || $value === '') {
                unset($query[$key]);
            }
        }

        return url()->current() . '?' . http_build_query($query);
    };
@endphp


<style>
    :root {
        --connector-primary: #6B9080;
        --connector-primary-dark: #254035;
        --connector-soft: #EEF4F1;
        --connector-bg: #F7FAF8;
        --connector-text: #183028;
        --connector-muted: #65786F;
        --connector-border: #E1EAE6;
        --connector-gold: #C99A3B;
        --connector-danger: #C95A43;
        --connector-whatsapp: #25D366;

        --connector-radius: 16px;
        --connector-card-radius: 18px;
        --connector-shadow: 0 10px 30px rgba(37, 64, 53, .07);
        --connector-shadow-hover: 0 18px 40px rgba(37, 64, 53, .12);
    }

    /* =====================================================
       GLOBAL
    ===================================================== */

    .connector-providers-page {
        background: var(--connector-bg);
        color: var(--connector-text);
        min-height: 100vh;
    }

    .connector-providers-page *,
    .connector-providers-page *::before,
    .connector-providers-page *::after {
        box-sizing: border-box;
    }

    .connector-providers-page a {
        text-decoration: none;
    }

    /* =====================================================
       HERO
    ===================================================== */

    .provider-hero {
        position: relative;
        overflow: hidden;
        background:
            linear-gradient(
                135deg,
                var(--connector-primary-dark) 0%,
                #355C4E 50%,
                var(--connector-primary) 100%
            );
        padding: 72px 0 76px;
    }

    .provider-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(
                90deg,
                rgba(255,255,255,.04) 1px,
                transparent 1px
            ),
            linear-gradient(
                rgba(255,255,255,.04) 1px,
                transparent 1px
            );
        background-size: 42px 42px;
        opacity: .35;
        pointer-events: none;
    }

    .provider-hero-content {
        position: relative;
        z-index: 2;
    }

    .provider-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 12px;
        border: 1px solid rgba(255,255,255,.16);
        background: rgba(255,255,255,.10);
        border-radius: 999px;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    .provider-eyebrow i {
        font-size: 8px;
        color: #B9D7C9;
    }

    .provider-hero h1 {
        margin: 0;
        max-width: 760px;
        color: #fff;
        font-size: clamp(34px, 4vw, 54px);
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -.035em;
    }

    .provider-hero-description {
        max-width: 650px;
        margin: 18px 0 0;
        color: rgba(255,255,255,.78);
        font-size: 17px;
        line-height: 1.7;
    }

    /* =====================================================
       SEARCH
    ===================================================== */

    .provider-search-wrap {
        position: relative;
        z-index: 5;
        margin-top: -30px;
    }

    .provider-search-box {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 230px 125px;
        gap: 10px;
        align-items: center;
        padding: 10px;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        box-shadow: var(--connector-shadow-hover);
    }

    .provider-search-input {
        position: relative;
        min-width: 0;
    }

    .provider-search-input i {
        position: absolute;
        left: 17px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--connector-primary);
        font-size: 17px;
        z-index: 2;
    }

    .provider-search-input input {
        width: 100%;
        height: 56px;
        border: 0;
        outline: 0;
        background: #fff;
        color: var(--connector-text);
        padding: 0 18px 0 48px;
        border-radius: 12px;
        font-size: 14px;
    }

    .provider-search-input input::placeholder {
        color: #93A29C;
    }

    .provider-search-category {
        min-width: 0;
    }

    .provider-search-category select {
        width: 100%;
        height: 56px;
        border: 1px solid var(--connector-border);
        outline: 0;
        background: var(--connector-soft);
        color: var(--connector-text);
        border-radius: 12px;
        padding: 0 15px;
        font-size: 14px;
        font-weight: 600;
    }

    .provider-search-button {
        height: 56px;
        border: 0;
        border-radius: 12px;
        background: var(--connector-primary);
        color: #fff;
        padding: 0 22px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .provider-search-button:hover {
        background: var(--connector-primary-dark);
    }

    /* =====================================================
       CONTENT AREA
    ===================================================== */

    .providers-section {
        padding: 55px 0 100px;
    }

    .providers-layout {
        display: grid;
        grid-template-columns: 250px minmax(0, 1fr);
        gap: 30px;
        align-items: start;
    }

    /* =====================================================
       FILTER SIDEBAR
    ===================================================== */

    .provider-filter {
        position: sticky;
        top: 25px;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: var(--connector-card-radius);
        box-shadow: var(--connector-shadow);
        overflow: hidden;
    }

    .filter-header {
        padding: 20px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .filter-header h3 {
        margin: 0;
        color: var(--connector-text);
        font-size: 16px;
        font-weight: 800;
    }

    .filter-clear {
        color: var(--connector-primary);
        font-size: 12px;
        font-weight: 700;
    }

    .filter-clear:hover {
        color: var(--connector-primary-dark);
    }

    .filter-body {
        padding: 20px;
    }

    .filter-group {
        padding-bottom: 22px;
        margin-bottom: 22px;
        border-bottom: 1px solid var(--connector-border);
    }

    .filter-group:last-child {
        padding-bottom: 0;
        margin-bottom: 0;
        border-bottom: 0;
    }

    .filter-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .filter-title h4 {
        margin: 0;
        font-size: 12px;
        font-weight: 800;
        color: var(--connector-text);
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .filter-count {
        color: var(--connector-muted);
        font-size: 11px;
    }

    /* =====================================================
       FILTER SEARCH
    ===================================================== */

    .filter-search {
        position: relative;
    }

    .filter-search i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--connector-muted);
        font-size: 13px;
    }

    .filter-search input {
        width: 100%;
        height: 43px;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        padding: 0 12px 0 36px;
        outline: none;
        color: var(--connector-text);
        background: #fff;
        font-size: 13px;
    }

    .filter-search input:focus {
        border-color: var(--connector-primary);
        box-shadow: 0 0 0 3px rgba(107,144,128,.10);
    }

    /* =====================================================
       CATEGORY / LOCATION LIST
    ===================================================== */

    .filter-options {
        display: flex;
        flex-direction: column;
        gap: 5px;
        max-height: 265px;
        overflow-y: auto;
        padding-right: 3px;
    }

    .filter-options::-webkit-scrollbar {
        width: 4px;
    }

    .filter-options::-webkit-scrollbar-thumb {
        background: #D2DFD9;
        border-radius: 20px;
    }

    .filter-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        width: 100%;
        min-height: 40px;
        padding: 8px 10px;
        border-radius: 9px;
        color: var(--connector-muted);
        background: transparent;
        transition: .18s ease;
    }

    .filter-option-main {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 0;
    }

    .filter-option-icon {
        width: 26px;
        height: 26px;
        flex: 0 0 26px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        font-size: 11px;
    }

    .filter-option-label {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 13px;
        font-weight: 600;
    }

    .filter-option:hover {
        color: var(--connector-primary-dark);
        background: var(--connector-soft);
    }

    .filter-option.active {
        color: var(--connector-primary-dark);
        background: var(--connector-soft);
    }

    .filter-option.active .filter-option-icon {
        background: var(--connector-primary);
        color: #fff;
    }

    .filter-check {
        width: 17px;
        height: 17px;
        flex: 0 0 17px;
        border: 1px solid #D2DED8;
        border-radius: 50%;
        position: relative;
    }

    .filter-option.active .filter-check {
        border-color: var(--connector-primary);
        background: var(--connector-primary);
    }

    .filter-option.active .filter-check::after {
        content: "";
        position: absolute;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #fff;
        top: 5px;
        left: 5px;
    }

    /* =====================================================
       ACTIVE FILTERS
    ===================================================== */

    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-bottom: 22px;
    }

    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 10px;
        border-radius: 999px;
        background: var(--connector-soft);
        color: var(--connector-primary-dark);
        font-size: 11px;
        font-weight: 700;
    }

    .filter-chip i {
        font-size: 9px;
    }

    /* =====================================================
       RESULTS
    ===================================================== */

    .providers-results {
        min-width: 0;
    }

    .results-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 20px;
    }

    .results-title {
        min-width: 0;
    }

    .results-title h2 {
        margin: 0;
        font-size: 23px;
        line-height: 1.2;
        font-weight: 800;
        color: var(--connector-text);
    }

    .results-title p {
        margin: 5px 0 0;
        color: var(--connector-muted);
        font-size: 13px;
    }

    .results-sort {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 0 0 auto;
    }

    .results-sort span {
        color: var(--connector-muted);
        font-size: 12px;
        font-weight: 600;
    }

    .sort-links {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 4px;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
    }

    .sort-link {
        padding: 7px 10px;
        border-radius: 7px;
        color: var(--connector-muted);
        font-size: 11px;
        font-weight: 700;
    }

    .sort-link:hover {
        color: var(--connector-primary-dark);
    }

    .sort-link.active {
        background: var(--connector-soft);
        color: var(--connector-primary-dark);
    }

    /* =====================================================
       PROVIDER GRID
    ===================================================== */

    .providers-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    /* =====================================================
       PROVIDER CARD
    ===================================================== */

    .provider-card {
        min-width: 0;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: var(--connector-card-radius);
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(37,64,53,.045);
        transition:
            transform .22s ease,
            box-shadow .22s ease,
            border-color .22s ease;
    }

    .provider-card:hover {
        transform: translateY(-4px);
        border-color: #D0DFD8;
        box-shadow: var(--connector-shadow-hover);
    }

    .provider-image-wrap {
        position: relative;
        width: 100%;
        aspect-ratio: 1 / .88;
        overflow: hidden;
        background: var(--connector-soft);
    }

    .provider-image {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .35s ease;
    }

    .provider-card:hover .provider-image {
        transform: scale(1.035);
    }

    .provider-image-overlay {
        position: absolute;
        inset: auto 0 0;
        height: 45%;
        background: linear-gradient(
            to top,
            rgba(24,48,40,.30),
            transparent
        );
        pointer-events: none;
    }

    .provider-category-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        max-width: calc(100% - 24px);
        padding: 6px 9px;
        border-radius: 8px;
        background: rgba(255,255,255,.94);
        color: var(--connector-primary-dark);
        font-size: 10px;
        line-height: 1.2;
        font-weight: 800;
        box-shadow: 0 5px 15px rgba(0,0,0,.08);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .provider-body {
        padding: 16px;
    }

    .provider-name {
        display: block;
        margin: 0;
        color: var(--connector-text);
        font-size: 15px;
        line-height: 1.35;
        font-weight: 800;

        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .provider-name:hover {
        color: var(--connector-primary);
    }

    .provider-service {
        min-height: 18px;
        margin-top: 5px;
        color: var(--connector-primary);
        font-size: 11px;
        line-height: 1.4;
        font-weight: 700;

        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .provider-meta {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin-top: 13px;
        padding-top: 12px;
        border-top: 1px solid var(--connector-border);
    }

    .provider-meta-item {
        display: flex;
        align-items: center;
        gap: 7px;
        min-width: 0;
        color: var(--connector-muted);
        font-size: 11px;
        line-height: 1.3;
    }

    .provider-meta-item i {
        width: 16px;
        flex: 0 0 16px;
        color: var(--connector-primary);
        text-align: center;
    }

    .provider-meta-item span {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .provider-actions {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 42px;
        gap: 8px;
        margin-top: 15px;
    }

    .provider-profile-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 0;
        height: 39px;
        padding: 0 12px;
        border-radius: 9px;
        background: var(--connector-primary);
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        transition: .2s ease;
    }

    .provider-profile-btn:hover {
        background: var(--connector-primary-dark);
        color: #fff;
    }

    .provider-whatsapp-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 39px;
        border-radius: 9px;
        background: #EAF8EF;
        color: #179447;
        font-size: 16px;
        transition: .2s ease;
    }

    .provider-whatsapp-btn:hover {
        background: var(--connector-whatsapp);
        color: #fff;
    }

    /* =====================================================
       EMPTY STATE
    ===================================================== */

    .provider-empty {
        grid-column: 1 / -1;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: var(--connector-card-radius);
        padding: 70px 25px;
        text-align: center;
    }

    .empty-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        font-size: 23px;
    }

    .provider-empty h3 {
        margin: 0;
        color: var(--connector-text);
        font-size: 20px;
        font-weight: 800;
    }

    .provider-empty p {
        max-width: 450px;
        margin: 9px auto 20px;
        color: var(--connector-muted);
        font-size: 13px;
        line-height: 1.6;
    }

    .empty-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 0 16px;
        border-radius: 9px;
        background: var(--connector-primary);
        color: #fff;
        font-size: 12px;
        font-weight: 800;
    }

    .empty-reset:hover {
        background: var(--connector-primary-dark);
        color: #fff;
    }

    /* =====================================================
       PAGINATION
    ===================================================== */

    .providers-pagination {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }

    .providers-pagination nav {
        display: flex;
        justify-content: center;
    }

    .providers-pagination .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .providers-pagination .page-item {
        margin: 0;
    }

    .providers-pagination .page-link {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--connector-border);
        border-radius: 9px;
        background: #fff;
        color: var(--connector-muted);
        font-size: 12px;
        font-weight: 700;
    }

    .providers-pagination .page-link:hover {
        background: var(--connector-soft);
        color: var(--connector-primary-dark);
    }

    .providers-pagination .active .page-link {
        background: var(--connector-primary);
        border-color: var(--connector-primary);
        color: #fff;
    }

    .providers-pagination .disabled .page-link {
        opacity: .45;
        pointer-events: none;
    }

    /* =====================================================
       MOBILE FILTER BUTTON
    ===================================================== */

    .mobile-filter-button {
        display: none;
        width: 100%;
        height: 46px;
        border: 1px solid var(--connector-border);
        border-radius: 11px;
        background: #fff;
        color: var(--connector-text);
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        margin-bottom: 15px;
    }

    .mobile-filter-button i {
        color: var(--connector-primary);
        margin-right: 7px;
    }

    /* =====================================================
       MOBILE FILTER DRAWER
    ===================================================== */

    .filter-overlay {
        display: none;
        position: fixed;
        z-index: 9998;
        inset: 0;
        background: rgba(24,48,40,.45);
        backdrop-filter: blur(3px);
    }

    .mobile-filter-drawer {
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: min(340px, 88vw);
        height: 100vh;
        background: #fff;
        transform: translateX(-105%);
        transition: transform .25s ease;
        overflow-y: auto;
        box-shadow: 15px 0 40px rgba(0,0,0,.12);
    }

    body.filter-open {
        overflow: hidden;
    }

    body.filter-open .filter-overlay {
        display: block;
    }

    body.filter-open .mobile-filter-drawer {
        transform: translateX(0);
    }

    .drawer-header {
        position: sticky;
        top: 0;
        z-index: 2;
        padding: 17px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fff;
        border-bottom: 1px solid var(--connector-border);
    }

    .drawer-header strong {
        font-size: 15px;
        color: var(--connector-text);
    }

    .drawer-close {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 8px;
        background: var(--connector-soft);
        color: var(--connector-text);
        cursor: pointer;
    }

    .drawer-body {
        padding: 18px;
    }

    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 1399px) {
        .providers-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 1199px) {
        .providers-layout {
            grid-template-columns: 225px minmax(0, 1fr);
            gap: 22px;
        }

        .providers-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
        }

        .provider-body {
            padding: 14px;
        }

        .provider-search-box {
            grid-template-columns: minmax(0, 1fr) 200px 115px;
        }
    }

    @media (max-width: 991px) {
        .provider-hero {
            padding: 55px 0 65px;
        }

        .provider-search-box {
            grid-template-columns: 1fr;
        }

        .provider-search-button {
            width: 100%;
        }

        .providers-section {
            padding-top: 40px;
        }

        .providers-layout {
            display: block;
        }

        .desktop-filter {
            display: none;
        }

        .mobile-filter-button {
            display: block;
        }

        .providers-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px) {
        .provider-hero {
            padding: 45px 0 58px;
        }

        .provider-hero h1 {
            font-size: 34px;
        }

        .provider-hero-description {
            font-size: 14px;
        }

        .provider-search-wrap {
            margin-top: -25px;
        }

        .providers-section {
            padding: 32px 0 70px;
        }

        .providers-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 13px;
        }

        .results-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 12px;
        }

        .results-sort {
            width: 100%;
            justify-content: space-between;
        }

        .sort-links {
            margin-left: auto;
        }

        .provider-image-wrap {
            aspect-ratio: 1 / .92;
        }

        .provider-body {
            padding: 13px;
        }

        .provider-name {
            font-size: 14px;
        }

        .provider-service {
            font-size: 10px;
        }

        .provider-actions {
            grid-template-columns: minmax(0, 1fr) 38px;
        }

        .provider-whatsapp-btn {
            width: 38px;
        }
    }

    @media (max-width: 480px) {
        .provider-hero h1 {
            font-size: 29px;
        }

        .provider-eyebrow {
            font-size: 10px;
        }

        .provider-search-box {
            padding: 8px;
            border-radius: 14px;
        }

        .provider-search-input input,
        .provider-search-category select,
        .provider-search-button {
            height: 50px;
        }

        .providers-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .provider-card {
            border-radius: 14px;
        }

        .provider-body {
            padding: 11px;
        }

        .provider-category-badge {
            top: 8px;
            left: 8px;
            max-width: calc(100% - 16px);
            padding: 5px 7px;
            font-size: 9px;
        }

        .provider-meta {
            margin-top: 10px;
            padding-top: 10px;
            gap: 5px;
        }

        .provider-meta-item {
            font-size: 9px;
        }

        .provider-actions {
            margin-top: 11px;
            gap: 5px;
            grid-template-columns: minmax(0, 1fr) 34px;
        }

        .provider-profile-btn {
            height: 35px;
            padding: 0 7px;
            font-size: 9px;
        }

        .provider-whatsapp-btn {
            width: 34px;
            height: 35px;
            font-size: 14px;
        }

        .results-title h2 {
            font-size: 20px;
        }
    }
</style>


<div class="connector-providers-page">

    {{-- =====================================================
         HERO
    ====================================================== --}}
    <section class="provider-hero">
        <div class="container">
            <div class="provider-hero-content">

                <div class="provider-eyebrow">
                    <i class="fa-solid fa-circle"></i>
                    Connector Marketplace
                </div>

                <h1>
                    Find trusted service providers
                </h1>

                <p class="provider-hero-description">
                    Discover skilled professionals and reliable providers
                    for the services you need.
                </p>

            </div>
        </div>
    </section>


    {{-- =====================================================
         SEARCH
    ====================================================== --}}
    <div class="provider-search-wrap">
        <div class="container">

            <form
                method="GET"
                action="{{ url()->current() }}"
                class="provider-search-box"
            >

                <div class="provider-search-input">
                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="search"
                        name="search"
                        value="{{ $currentSearch }}"
                        placeholder="Search providers, services or locations..."
                        autocomplete="off"
                    >
                </div>

                <div class="provider-search-category">
                    <select name="category">
                        <option value="">All categories</option>

                        @foreach($categories ?? [] as $category)
                            <option
                                value="{{ $category->slug }}"
                                @selected($currentCategory === $category->slug)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if($currentLocation)
                    <input
                        type="hidden"
                        name="location"
                        value="{{ $currentLocation }}"
                    >
                @endif

                @if($currentSort)
                    <input
                        type="hidden"
                        name="sort"
                        value="{{ $currentSort }}"
                    >
                @endif

                <button type="submit" class="provider-search-button">
                    Search
                </button>

            </form>

        </div>
    </div>


    {{-- =====================================================
         PROVIDERS
    ====================================================== --}}
    <section class="providers-section">
        <div class="container">

            {{-- Mobile filter button --}}
            <button
                type="button"
                class="mobile-filter-button"
                id="openProviderFilter"
            >
                <i class="fa-solid fa-sliders"></i>
                Filter providers
            </button>


            <div class="providers-layout">

                {{-- =================================================
                     DESKTOP FILTER
                ================================================== --}}
                <aside class="provider-filter desktop-filter">

                    <div class="filter-header">

                        <h3>Filters</h3>

                        @if($hasFilters)
                            <a
                                href="{{ url()->current() }}"
                                class="filter-clear"
                            >
                                Clear all
                            </a>
                        @endif

                    </div>

                    <div class="filter-body">

                        {{-- Search --}}
                        <div class="filter-group">

                            <div class="filter-title">
                                <h4>Search</h4>
                            </div>

                            <div class="filter-search">
                                <i class="fa-solid fa-magnifying-glass"></i>

                                <input
                                    type="text"
                                    id="sidebarProviderSearch"
                                    value="{{ $currentSearch }}"
                                    placeholder="Search..."
                                >
                            </div>

                        </div>


                        {{-- Category --}}
                        <div class="filter-group">

                            <div class="filter-title">
                                <h4>Category</h4>

                                <span class="filter-count">
                                    {{ count($categories ?? []) }}
                                </span>
                            </div>

                            <div class="filter-options">

                                <a
                                    href="{{ $buildFilterUrl(['category' => null, 'page' => null]) }}"
                                    class="filter-option {{ !$currentCategory ? 'active' : '' }}"
                                >
                                    <span class="filter-option-main">

                                        <span class="filter-option-icon">
                                            <i class="fa-solid fa-layer-group"></i>
                                        </span>

                                        <span class="filter-option-label">
                                            All categories
                                        </span>

                                    </span>

                                    <span class="filter-check"></span>
                                </a>


                                @foreach($categories ?? [] as $category)

                                    <a
                                        href="{{ $buildFilterUrl([
                                            'category' => $category->slug,
                                            'page' => null
                                        ]) }}"
                                        class="filter-option {{ $currentCategory === $category->slug ? 'active' : '' }}"
                                    >

                                        <span class="filter-option-main">

                                            <span class="filter-option-icon">
                                                <i class="fa-solid fa-briefcase"></i>
                                            </span>

                                            <span
                                                class="filter-option-label"
                                                title="{{ $category->name }}"
                                            >
                                                {{ $category->name }}
                                            </span>

                                        </span>

                                        <span class="filter-check"></span>

                                    </a>

                                @endforeach

                            </div>

                        </div>


                        {{-- Location --}}
                        <div class="filter-group">

                            <div class="filter-title">
                                <h4>Location</h4>

                                <span class="filter-count">
                                    {{ count($locations ?? []) }}
                                </span>
                            </div>

                            <div class="filter-options">

                                <a
                                    href="{{ $buildFilterUrl(['location' => null, 'page' => null]) }}"
                                    class="filter-option {{ !$currentLocation ? 'active' : '' }}"
                                >

                                    <span class="filter-option-main">

                                        <span class="filter-option-icon">
                                            <i class="fa-solid fa-globe"></i>
                                        </span>

                                        <span class="filter-option-label">
                                            All locations
                                        </span>

                                    </span>

                                    <span class="filter-check"></span>

                                </a>


                                @foreach($locations ?? [] as $location)

                                    <a
                                        href="{{ $buildFilterUrl([
                                            'location' => $location,
                                            'page' => null
                                        ]) }}"
                                        class="filter-option {{ $currentLocation === $location ? 'active' : '' }}"
                                    >

                                        <span class="filter-option-main">

                                            <span class="filter-option-icon">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </span>

                                            <span
                                                class="filter-option-label"
                                                title="{{ $location }}"
                                            >
                                                {{ $location }}
                                            </span>

                                        </span>

                                        <span class="filter-check"></span>

                                    </a>

                                @endforeach

                            </div>

                        </div>

                    </div>

                </aside>


                {{-- =================================================
                     RESULTS
                ================================================== --}}
                <main class="providers-results">

                    {{-- Active filters --}}
                    @if($hasFilters)

                        <div class="active-filters">

                            @if($currentSearch)
                                <span class="filter-chip">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    {{ $currentSearch }}
                                </span>
                            @endif

                            @if($selectedCategory)
                                <span class="filter-chip">
                                    <i class="fa-solid fa-briefcase"></i>
                                    {{ $selectedCategory->name }}
                                </span>
                            @endif

                            @if($currentLocation)
                                <span class="filter-chip">
                                    <i class="fa-solid fa-location-dot"></i>
                                    {{ $currentLocation }}
                                </span>
                            @endif

                        </div>

                    @endif


                    {{-- Results header --}}
                    <div class="results-header">

                        <div class="results-title">

                            <h2>
                                Service providers
                            </h2>

                            <p>
                                {{ number_format($providerCount) }}
                                {{ $providerCount === 1 ? 'provider' : 'providers' }}
                                available
                            </p>

                        </div>


                        <div class="results-sort">

                            <span>Sort:</span>

                            <div class="sort-links">

                                <a
                                    href="{{ $buildFilterUrl(['sort' => 'latest', 'page' => null]) }}"
                                    class="sort-link {{ $currentSort === 'latest' ? 'active' : '' }}"
                                >
                                    Newest
                                </a>

                                <a
                                    href="{{ $buildFilterUrl(['sort' => 'name', 'page' => null]) }}"
                                    class="sort-link {{ $currentSort === 'name' ? 'active' : '' }}"
                                >
                                    A–Z
                                </a>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         PROVIDER GRID
                    ================================================== --}}
                    <div class="providers-grid">

                        @forelse($sproviders as $sprovider)

                            @php
                                $providerName = trim($sprovider->sprovider_name ?? '');

                                $categoryName = optional($sprovider->category)->name
                                    ?? 'Service Provider';

                                $city = trim($sprovider->city ?? '');

                                $serviceLocations = trim(
                                    $sprovider->service_locations ?? ''
                                );

                                $image = !empty($sprovider->image)
                                    ? asset('image/profile/' . $sprovider->image)
                                    : asset('image/profile/default.png');

                                $whatsappNumber = preg_replace(
                                    '/[^0-9]/',
                                    '',
                                    $sprovider->phone ?? $defaultWhatsapp
                                );

                                $whatsappMessage = urlencode(
                                    'Hello ' . $providerName .
                                    ', I found your profile on Connector and would like to know more about your services.'
                                );
                            @endphp


                            <article class="provider-card">

                                {{-- Image --}}
                                <div class="provider-image-wrap">

                                    <img
                                        src="{{ $image }}"
                                        alt="{{ $providerName }}"
                                        class="provider-image"
                                        loading="lazy"
                                        onerror="this.onerror=null;this.src='{{ asset('image/profile/default.png') }}';"
                                    >

                                    <div class="provider-image-overlay"></div>

                                    <span
                                        class="provider-category-badge"
                                        title="{{ $categoryName }}"
                                    >
                                        {{ $categoryName }}
                                    </span>

                                </div>


                                {{-- Body --}}
                                <div class="provider-body">

                                    <a
                                        href="{{ route('home.service-provider_profile', [
                                            'sprovider_id' => $sprovider->id
                                        ]) }}"
                                        class="provider-name"
                                        title="{{ $providerName }}"
                                    >
                                        {{ $providerName }}
                                    </a>


                                    <div
                                        class="provider-service"
                                        title="{{ $categoryName }}"
                                    >
                                        {{ $categoryName }}
                                    </div>


                                    <div class="provider-meta">

                                        @if($city)
                                            <div class="provider-meta-item">

                                                <i class="fa-solid fa-location-dot"></i>

                                                <span title="{{ $city }}">
                                                    {{ $city }}
                                                </span>

                                            </div>
                                        @endif


                                        @if($serviceLocations)

                                            <div class="provider-meta-item">

                                                <i class="fa-solid fa-map-location-dot"></i>

                                                <span title="{{ $serviceLocations }}">
                                                    {{ $serviceLocations }}
                                                </span>

                                            </div>

                                        @elseif($city)

                                            <div class="provider-meta-item">

                                                <i class="fa-solid fa-globe"></i>

                                                <span>
                                                    Service available locally
                                                </span>

                                            </div>

                                        @endif

                                    </div>


                                    <div class="provider-actions">

                                        <a
                                            href="{{ route('home.service-provider_profile', [
                                                'sprovider_id' => $sprovider->id
                                            ]) }}"
                                            class="provider-profile-btn"
                                        >
                                            View profile
                                        </a>


                                        <a
                                            href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappMessage }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="provider-whatsapp-btn"
                                            aria-label="Contact {{ $providerName }} on WhatsApp"
                                            title="WhatsApp"
                                        >
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>

                                    </div>

                                </div>

                            </article>

                        @empty

                            <div class="provider-empty">

                                <div class="empty-icon">
                                    <i class="fa-solid fa-user-group"></i>
                                </div>

                                <h3>
                                    No service providers found
                                </h3>

                                <p>
                                    We couldn't find providers matching your
                                    current filters. Try another category,
                                    location, or search term.
                                </p>

                                <a
                                    href="{{ url()->current() }}"
                                    class="empty-reset"
                                >
                                    Clear filters
                                </a>

                            </div>

                        @endforelse

                    </div>


                    {{-- Pagination --}}
                    @if($sproviders->hasPages())

                        <div class="providers-pagination">

                            {{ $sproviders->onEachSide(1)->links() }}

                        </div>

                    @endif

                </main>

            </div>

        </div>
    </section>

</div>


{{-- =========================================================
     MOBILE FILTER DRAWER
========================================================= --}}

<div class="filter-overlay" id="providerFilterOverlay"></div>

<aside
    class="mobile-filter-drawer"
    id="providerFilterDrawer"
    aria-label="Provider filters"
>

    <div class="drawer-header">

        <strong>
            Filter providers
        </strong>

        <button
            type="button"
            class="drawer-close"
            id="closeProviderFilter"
            aria-label="Close filters"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>

    </div>


    <div class="drawer-body">

        <div class="filter-group">

            <div class="filter-title">
                <h4>Search</h4>
            </div>

            <form
                method="GET"
                action="{{ url()->current() }}"
                class="filter-search"
            >

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="search"
                    name="search"
                    value="{{ $currentSearch }}"
                    placeholder="Search providers..."
                >

                @if($currentCategory)
                    <input
                        type="hidden"
                        name="category"
                        value="{{ $currentCategory }}"
                    >
                @endif

                @if($currentLocation)
                    <input
                        type="hidden"
                        name="location"
                        value="{{ $currentLocation }}"
                    >
                @endif

                <input
                    type="hidden"
                    name="sort"
                    value="{{ $currentSort }}"
                >

            </form>

        </div>


        <div class="filter-group">

            <div class="filter-title">

                <h4>Category</h4>

                <span class="filter-count">
                    {{ count($categories ?? []) }}
                </span>

            </div>


            <div class="filter-options">

                <a
                    href="{{ $buildFilterUrl([
                        'category' => null,
                        'page' => null
                    ]) }}"
                    class="filter-option {{ !$currentCategory ? 'active' : '' }}"
                >

                    <span class="filter-option-main">

                        <span class="filter-option-icon">
                            <i class="fa-solid fa-layer-group"></i>
                        </span>

                        <span class="filter-option-label">
                            All categories
                        </span>

                    </span>

                    <span class="filter-check"></span>

                </a>


                @foreach($categories ?? [] as $category)

                    <a
                        href="{{ $buildFilterUrl([
                            'category' => $category->slug,
                            'page' => null
                        ]) }}"
                        class="filter-option {{ $currentCategory === $category->slug ? 'active' : '' }}"
                    >

                        <span class="filter-option-main">

                            <span class="filter-option-icon">
                                <i class="fa-solid fa-briefcase"></i>
                            </span>

                            <span
                                class="filter-option-label"
                                title="{{ $category->name }}"
                            >
                                {{ $category->name }}
                            </span>

                        </span>

                        <span class="filter-check"></span>

                    </a>

                @endforeach

            </div>

        </div>


        <div class="filter-group">

            <div class="filter-title">

                <h4>Location</h4>

                <span class="filter-count">
                    {{ count($locations ?? []) }}
                </span>

            </div>


            <div class="filter-options">

                <a
                    href="{{ $buildFilterUrl([
                        'location' => null,
                        'page' => null
                    ]) }}"
                    class="filter-option {{ !$currentLocation ? 'active' : '' }}"
                >

                    <span class="filter-option-main">

                        <span class="filter-option-icon">
                            <i class="fa-solid fa-globe"></i>
                        </span>

                        <span class="filter-option-label">
                            All locations
                        </span>

                    </span>

                    <span class="filter-check"></span>

                </a>


                @foreach($locations ?? [] as $location)

                    <a
                        href="{{ $buildFilterUrl([
                            'location' => $location,
                            'page' => null
                        ]) }}"
                        class="filter-option {{ $currentLocation === $location ? 'active' : '' }}"
                    >

                        <span class="filter-option-main">

                            <span class="filter-option-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </span>

                            <span
                                class="filter-option-label"
                                title="{{ $location }}"
                            >
                                {{ $location }}
                            </span>

                        </span>

                        <span class="filter-check"></span>

                    </a>

                @endforeach

            </div>

        </div>


        <a
            href="{{ url()->current() }}"
            class="empty-reset"
            style="width:100%;"
        >
            Clear all filters
        </a>

    </div>

</aside>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const body = document.body;

    const openButton = document.getElementById('openProviderFilter');
    const closeButton = document.getElementById('closeProviderFilter');
    const overlay = document.getElementById('providerFilterOverlay');

    function openFilter() {
        body.classList.add('filter-open');
    }

    function closeFilter() {
        body.classList.remove('filter-open');
    }

    if (openButton) {
        openButton.addEventListener('click', openFilter);
    }

    if (closeButton) {
        closeButton.addEventListener('click', closeFilter);
    }

    if (overlay) {
        overlay.addEventListener('click', closeFilter);
    }


    /*
     * Sidebar search:
     * Press Enter to submit the search while preserving
     * currently selected category/location.
     */
    const sidebarSearch = document.getElementById(
        'sidebarProviderSearch'
    );

    if (sidebarSearch) {

        sidebarSearch.addEventListener('keydown', function (event) {

            if (event.key !== 'Enter') {
                return;
            }

            event.preventDefault();

            const url = new URL(window.location.href);

            const value = this.value.trim();

            if (value) {
                url.searchParams.set('search', value);
            } else {
                url.searchParams.delete('search');
            }

            url.searchParams.delete('page');

            window.location.href = url.toString();

        });

    }


    /*
     * Escape closes mobile filter drawer.
     */
    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {
            closeFilter();
        }

    });

});
</script>


@endsection