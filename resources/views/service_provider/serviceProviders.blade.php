@extends('layouts.base')

@section('title', 'Service Providers')

@section('content')

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
        --connector-white: #FFFFFF;
        --connector-shadow: 0 10px 30px rgba(37, 64, 53, .07);
        --connector-shadow-lg: 0 20px 50px rgba(37, 64, 53, .12);
    }

    body {
        background: var(--connector-bg);
    }

    /* =========================================================
       HERO
    ========================================================= */

    .providers-hero {
        position: relative;
        overflow: hidden;
        background:
            linear-gradient(
                135deg,
                var(--connector-primary-dark) 0%,
                #355A4C 55%,
                var(--connector-primary) 100%
            );
        padding: 65px 0 72px;
    }

    .providers-hero-content {
        position: relative;
        z-index: 2;
        max-width: 780px;
        margin: 0 auto;
        text-align: center;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 999px;
        background: rgba(255,255,255,.10);
        color: #fff;
        font-size: 11px;
        font-weight: 750;
        letter-spacing: .05em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
    }

    .hero-badge-dot {
        width: 7px;
        height: 7px;
        background: #B7D7C9;
        border-radius: 50%;
    }

    .providers-hero h1 {
        color: #fff;
        font-size: 42px;
        line-height: 1.12;
        font-weight: 850;
        letter-spacing: -.035em;
        margin: 18px 0 12px;
    }

    .providers-hero p {
        color: rgba(255,255,255,.78);
        font-size: 15px;
        line-height: 1.65;
        margin: 0 auto;
        max-width: 620px;
    }

    .hero-decoration {
        position: absolute;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,.08);
        pointer-events: none;
    }

    .hero-decoration.one {
        width: 360px;
        height: 360px;
        right: -130px;
        top: -170px;
    }

    .hero-decoration.two {
        width: 240px;
        height: 240px;
        left: -100px;
        bottom: -130px;
    }

    /* =========================================================
       MAIN
    ========================================================= */

    .providers-section {
        padding: 34px 0 90px;
        background: var(--connector-bg);
    }

    .providers-layout {
        display: grid;
        grid-template-columns: 255px minmax(0, 1fr);
        gap: 22px;
        align-items: start;
    }

    /* =========================================================
       FILTER SIDEBAR
    ========================================================= */

    .filter-sidebar {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        box-shadow: var(--connector-shadow);
        overflow: hidden;
        position: sticky;
        top: 20px;
    }

    .filter-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 17px;
        border-bottom: 1px solid var(--connector-border);
    }

    .filter-header-title {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--connector-text);
        font-size: 14px;
        font-weight: 800;
    }

    .filter-header-title svg {
        color: var(--connector-primary);
    }

    .reset-link {
        border: 0;
        background: transparent;
        color: var(--connector-primary);
        font-size: 10px;
        font-weight: 800;
        padding: 0;
        cursor: pointer;
    }

    .filter-body {
        padding: 17px;
    }

    .filter-group {
        margin-bottom: 21px;
    }

    .filter-group:last-child {
        margin-bottom: 0;
    }

    .filter-label {
        display: block;
        color: var(--connector-text);
        font-size: 11px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .filter-input-wrap {
        position: relative;
    }

    .filter-input-wrap svg {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #8A9993;
        pointer-events: none;
    }

    .filter-input,
    .filter-select {
        width: 100%;
        min-height: 39px;
        border: 1px solid var(--connector-border);
        border-radius: 9px;
        background: #FBFDFC;
        color: var(--connector-text);
        font-size: 11px;
        outline: none;
        transition: .2s;
    }

    .filter-input {
        padding: 0 10px 0 34px;
    }

    .filter-select {
        padding: 0 10px;
    }

    .filter-input:focus,
    .filter-select:focus {
        border-color: var(--connector-primary);
        box-shadow: 0 0 0 3px rgba(107,144,128,.09);
        background: #fff;
    }

    .filter-check {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--connector-muted);
        font-size: 11px;
        font-weight: 650;
        margin-bottom: 9px;
        cursor: pointer;
    }

    .filter-check:last-child {
        margin-bottom: 0;
    }

    .filter-check input {
        width: 15px;
        height: 15px;
        accent-color: var(--connector-primary);
    }

    .apply-filter {
        width: 100%;
        min-height: 41px;
        border: 0;
        border-radius: 10px;
        background: var(--connector-primary);
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
        transition: .2s;
    }

    .apply-filter:hover {
        background: var(--connector-primary-dark);
    }

    /* =========================================================
       CONTENT
    ========================================================= */

    .providers-content {
        min-width: 0;
    }

    .content-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 17px;
    }

    .results-title {
        color: var(--connector-text);
        font-size: 17px;
        font-weight: 850;
        margin: 0;
        letter-spacing: -.02em;
    }

    .results-meta {
        color: var(--connector-muted);
        font-size: 11px;
        margin-top: 4px;
    }

    .toolbar-right {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .mobile-filter-button {
        display: none;
    }

    .sort-select {
        min-height: 38px;
        min-width: 145px;
        border: 1px solid var(--connector-border);
        border-radius: 9px;
        background: #fff;
        color: var(--connector-text);
        font-size: 11px;
        font-weight: 700;
        padding: 0 10px;
        outline: none;
    }

    .sort-select:focus {
        border-color: var(--connector-primary);
    }

    /* =========================================================
       ACTIVE FILTERS
    ========================================================= */

    .active-filters {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 16px;
    }

    .active-filter {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: var(--connector-soft);
        border: 1px solid #D7E5DF;
        border-radius: 999px;
        padding: 5px 8px;
        color: var(--connector-primary-dark);
        font-size: 9px;
        font-weight: 800;
    }

    .active-filter a {
        color: inherit;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    /* =========================================================
       PROVIDER GRID
    ========================================================= */

    .provider-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 13px;
    }

    .provider-card {
        position: relative;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--connector-shadow);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        min-width: 0;
    }

    .provider-card:hover {
        transform: translateY(-3px);
        border-color: #C8D9D2;
        box-shadow: 0 16px 34px rgba(37,64,53,.10);
    }

    .provider-image-wrap {
        position: relative;
        height: 150px;
        background: var(--connector-soft);
        overflow: hidden;
    }

    .provider-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .35s ease;
    }

    .provider-card:hover .provider-image {
        transform: scale(1.035);
    }

    .provider-image-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--connector-primary);
        background: linear-gradient(
            135deg,
            #EEF4F1,
            #E3EEE9
        );
    }

    .provider-favourite {
        position: absolute;
        right: 9px;
        top: 9px;
        width: 29px;
        height: 29px;
        border: 0;
        border-radius: 50%;
        background: rgba(255,255,255,.94);
        color: var(--connector-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 5px 15px rgba(0,0,0,.08);
        transition: .2s;
    }

    .provider-favourite:hover {
        color: var(--connector-danger);
        background: #fff;
    }

    .provider-badges {
        position: absolute;
        left: 9px;
        bottom: 9px;
        display: flex;
        gap: 5px;
    }

    .provider-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 7px;
        border-radius: 999px;
        background: rgba(255,255,255,.94);
        color: var(--connector-primary-dark);
        font-size: 8px;
        font-weight: 850;
        box-shadow: 0 4px 12px rgba(0,0,0,.07);
    }

    .provider-badge.featured {
        color: #8B671E;
    }

    .provider-body {
        padding: 13px;
    }

    .provider-category {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: var(--connector-primary);
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .035em;
        margin-bottom: 5px;
    }

    .provider-name {
        margin: 0;
        font-size: 14px;
        line-height: 1.3;
        font-weight: 850;
        letter-spacing: -.015em;
    }

    .provider-name a {
        color: var(--connector-text);
        text-decoration: none;
    }

    .provider-name a:hover {
        color: var(--connector-primary);
    }

    .provider-location {
        display: flex;
        align-items: center;
        gap: 5px;
        color: var(--connector-muted);
        font-size: 9px;
        margin-top: 5px;
        min-width: 0;
    }

    .provider-location span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .provider-rating {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 10px;
        padding-top: 9px;
        border-top: 1px solid #EFF3F1;
    }

    .rating-stars {
        display: inline-flex;
        gap: 1px;
        color: var(--connector-gold);
    }

    .rating-number {
        color: var(--connector-text);
        font-size: 10px;
        font-weight: 800;
    }

    .rating-reviews {
        color: var(--connector-muted);
        font-size: 9px;
    }

    .provider-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
        margin-top: 11px;
    }

    .provider-action {
        min-height: 33px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        border-radius: 8px;
        font-size: 9px;
        font-weight: 800;
        text-decoration: none !important;
        transition: .2s;
    }

    .provider-view {
        background: var(--connector-primary);
        color: #fff !important;
    }

    .provider-view:hover {
        background: var(--connector-primary-dark);
    }

    .provider-message {
        background: var(--connector-soft);
        border: 1px solid #DCE9E4;
        color: var(--connector-primary-dark) !important;
    }

    .provider-message:hover {
        background: #E0ECE7;
    }

    /* =========================================================
       EMPTY
    ========================================================= */

    .empty-state {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 17px;
        padding: 70px 25px;
        text-align: center;
        box-shadow: var(--connector-shadow);
        grid-column: 1 / -1;
    }

    .empty-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        border-radius: 17px;
        background: var(--connector-soft);
        color: var(--connector-primary);
    }

    .empty-state h3 {
        margin: 0 0 7px;
        color: var(--connector-text);
        font-size: 17px;
        font-weight: 850;
    }

    .empty-state p {
        margin: 0 auto 18px;
        color: var(--connector-muted);
        font-size: 12px;
        max-width: 420px;
    }

    .reset-all {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 15px;
        border-radius: 9px;
        background: var(--connector-primary);
        color: #fff !important;
        text-decoration: none !important;
        font-size: 11px;
        font-weight: 800;
    }

    /* =========================================================
       PAGINATION
    ========================================================= */

    .pagination-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 22px;
        padding: 15px 17px;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        box-shadow: var(--connector-shadow);
    }

    .pagination-info {
        color: var(--connector-muted);
        font-size: 10px;
    }

    .pagination-info strong {
        color: var(--connector-text);
        font-weight: 800;
    }

    .pagination-wrapper .pagination {
        margin: 0;
    }

    .pagination-wrapper .page-link {
        border-color: var(--connector-border);
        color: var(--connector-primary-dark);
        font-size: 10px;
        font-weight: 750;
        border-radius: 7px !important;
        margin: 0 2px;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: var(--connector-primary);
        border-color: var(--connector-primary);
        color: #fff;
    }

    /* =========================================================
       MOBILE FILTER
    ========================================================= */

    .filter-offcanvas {
        width: 310px !important;
        border: 0;
    }

    .filter-offcanvas .offcanvas-header {
        border-bottom: 1px solid var(--connector-border);
    }

    .filter-offcanvas .offcanvas-title {
        color: var(--connector-text);
        font-size: 15px;
        font-weight: 850;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1350px) {
        .provider-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 1100px) {
        .providers-layout {
            grid-template-columns: 220px minmax(0, 1fr);
        }

        .provider-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .provider-image-wrap {
            height: 135px;
        }
    }

    @media (max-width: 991px) {
        .providers-layout {
            display: block;
        }

        .desktop-filter {
            display: none;
        }

        .mobile-filter-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 38px;
            padding: 0 12px;
            border: 1px solid var(--connector-border);
            border-radius: 9px;
            background: #fff;
            color: var(--connector-text);
            font-size: 10px;
            font-weight: 800;
        }

        .provider-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px) {
        .providers-hero {
            padding: 45px 0 52px;
        }

        .providers-hero h1 {
            font-size: 32px;
        }

        .providers-section {
            padding-top: 22px;
        }

        .content-toolbar {
            align-items: flex-start;
        }

        .toolbar-right {
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .sort-select {
            min-width: 130px;
        }

        .provider-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .provider-image-wrap {
            height: 140px;
        }

        .provider-body {
            padding: 11px;
        }
    }

    @media (max-width: 500px) {
        .providers-hero h1 {
            font-size: 27px;
        }

        .providers-hero p {
            font-size: 13px;
        }

        .content-toolbar {
            display: block;
        }

        .toolbar-right {
            margin-top: 12px;
            justify-content: space-between;
        }

        .mobile-filter-button {
            flex: 1;
        }

        .sort-select {
            flex: 1;
        }

        .provider-grid {
            grid-template-columns: 1fr 1fr;
        }

        .provider-image-wrap {
            height: 125px;
        }

        .provider-actions {
            grid-template-columns: 1fr;
        }

        .provider-action {
            min-height: 32px;
        }

        .provider-message {
            display: none;
        }

        .pagination-wrapper {
            display: block;
        }

        .pagination-info {
            margin-bottom: 12px;
        }

        .pagination-wrapper .pagination {
            overflow-x: auto;
            display: flex;
            flex-wrap: nowrap;
        }
    }

    @media (max-width: 360px) {
        .provider-grid {
            grid-template-columns: 1fr;
        }

        .provider-image-wrap {
            height: 170px;
        }

        .provider-message {
            display: inline-flex;
        }

        .provider-actions {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>


{{-- =========================================================
     HERO
========================================================= --}}
<section class="providers-hero">

    <div class="hero-decoration one"></div>
    <div class="hero-decoration two"></div>

    <div class="container">

        <div class="providers-hero-content">

            <span class="hero-badge">
                <span class="hero-badge-dot"></span>
                Connector Marketplace
            </span>

            <h1>
                Find trusted service providers
            </h1>

            <p>
                Discover skilled professionals, compare their services,
                explore their profiles and connect with the right provider
                for your needs.
            </p>

        </div>

    </div>

</section>


{{-- =========================================================
     PROVIDERS SECTION
========================================================= --}}
<section class="providers-section">

    <div class="container">

        <div class="providers-layout">


            {{-- =================================================
                 DESKTOP FILTER SIDEBAR
            ================================================== --}}
            <aside class="filter-sidebar desktop-filter">

                <div class="filter-header">

                    <div class="filter-header-title">
                        <i data-lucide="sliders-horizontal" width="15"></i>
                        Filter Providers
                    </div>

                    <a
                        href="{{ route('home.service_provider') }}"
                        class="reset-link"
                    >
                        Reset
                    </a>

                </div>


                <form
                    method="GET"
                    action="{{ route('home.service_provider') }}"
                    class="filter-body"
                >

                    {{-- Search --}}
                    <div class="filter-group">

                        <label class="filter-label">
                            Search
                        </label>

                        <div class="filter-input-wrap">

                            <i data-lucide="search" width="14"></i>

                            <input
                                type="text"
                                name="search"
                                class="filter-input"
                                placeholder="Provider or service..."
                                value="{{ request('search') }}"
                            >

                        </div>

                    </div>


                    {{-- Category --}}
                    <div class="filter-group">

                        <label class="filter-label">
                            Category
                        </label>

                        <select
                            name="category"
                            class="filter-select"
                        >

                            <option value="">
                                All categories
                            </option>

                            @foreach($categories ?? [] as $category)

                                <option
                                    value="{{ $category->slug }}"
                                    @selected(request('category') == $category->slug)
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Location --}}
                    <div class="filter-group">

                        <label class="filter-label">
                            Location
                        </label>

                        <select
                            name="location"
                            class="filter-select"
                        >

                            <option value="">
                                All locations
                            </option>

                            @foreach($locations ?? [] as $location)

                                <option
                                    value="{{ $location }}"
                                    @selected(request('location') == $location)
                                >
                                    {{ $location }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Availability --}}
                    <div class="filter-group">

                        <label class="filter-label">
                            Availability
                        </label>

                        <label class="filter-check">
                            <input
                                type="radio"
                                name="availability"
                                value=""
                                @checked(!request('availability'))
                            >
                            <span>All providers</span>
                        </label>

                        <label class="filter-check">
                            <input
                                type="radio"
                                name="availability"
                                value="available"
                                @checked(request('availability') === 'available')
                            >
                            <span>Available now</span>
                        </label>

                        <label class="filter-check">
                            <input
                                type="radio"
                                name="availability"
                                value="verified"
                                @checked(request('availability') === 'verified')
                            >
                            <span>Verified providers</span>
                        </label>

                    </div>


                    {{-- Sort --}}
                    <div class="filter-group">

                        <label class="filter-label">
                            Sort By
                        </label>

                        <select
                            name="sort"
                            class="filter-select"
                        >

                            <option
                                value="latest"
                                @selected(request('sort', 'latest') === 'latest')
                            >
                                Newest
                            </option>

                            <option
                                value="name"
                                @selected(request('sort') === 'name')
                            >
                                Name A–Z
                            </option>

                            <option
                                value="rating"
                                @selected(request('sort') === 'rating')
                            >
                                Highest rated
                            </option>

                        </select>

                    </div>


                    <button
                        type="submit"
                        class="apply-filter"
                    >
                        Apply Filters
                    </button>

                </form>

            </aside>


            {{-- =================================================
                 PROVIDERS CONTENT
            ================================================== --}}
            <main class="providers-content">


                {{-- =================================================
                     TOOLBAR
                ================================================== --}}
                <div class="content-toolbar">

                    <div>

                        <h2 class="results-title">
                            Service Providers
                        </h2>

                        <div class="results-meta">

                            @if(method_exists($sproviders, 'total'))

                                Showing
                                <strong>
                                    {{ number_format($sproviders->total()) }}
                                </strong>
                                providers

                            @else

                                {{ $sproviders->count() }}
                                providers

                            @endif

                        </div>

                    </div>


                    <div class="toolbar-right">

                        {{-- Mobile filter --}}
                        <button
                            type="button"
                            class="mobile-filter-button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#mobileProviderFilter"
                        >
                            <i data-lucide="sliders-horizontal" width="14"></i>
                            Filters

                            @php
                                $filterCount = collect([
                                    request('search'),
                                    request('category'),
                                    request('location'),
                                    request('availability'),
                                ])->filter(fn($value) => filled($value))->count();
                            @endphp

                            @if($filterCount > 0)
                                <span
                                    style="
                                        width:17px;
                                        height:17px;
                                        display:inline-flex;
                                        align-items:center;
                                        justify-content:center;
                                        background:var(--connector-primary);
                                        color:#fff;
                                        border-radius:50%;
                                        font-size:8px;
                                    "
                                >
                                    {{ $filterCount }}
                                </span>
                            @endif

                        </button>


                        {{-- Sort --}}
                        <form
                            method="GET"
                            action="{{ route('home.service_provider') }}"
                        >

                            @foreach(request()->except('sort', 'page') as $key => $value)

                                @if(is_array($value))

                                    @foreach($value as $item)
                                        <input
                                            type="hidden"
                                            name="{{ $key }}[]"
                                            value="{{ $item }}"
                                        >
                                    @endforeach

                                @else

                                    <input
                                        type="hidden"
                                        name="{{ $key }}"
                                        value="{{ $value }}"
                                    >

                                @endif

                            @endforeach

                            <select
                                name="sort"
                                class="sort-select"
                                onchange="this.form.submit()"
                            >

                                <option
                                    value="latest"
                                    @selected(request('sort', 'latest') === 'latest')
                                >
                                    Newest
                                </option>

                                <option
                                    value="name"
                                    @selected(request('sort') === 'name')
                                >
                                    Name A–Z
                                </option>

                                <option
                                    value="rating"
                                    @selected(request('sort') === 'rating')
                                >
                                    Top rated
                                </option>

                            </select>

                        </form>

                    </div>

                </div>


                {{-- =================================================
                     ACTIVE FILTERS
                ================================================== --}}
                @if(
                    request('search') ||
                    request('category') ||
                    request('location') ||
                    request('availability')
                )

                    <div class="active-filters">

                        <span
                            style="
                                font-size:9px;
                                color:var(--connector-muted);
                                font-weight:800;
                            "
                        >
                            Active:
                        </span>

                        @if(request('search'))

                            <span class="active-filter">

                                Search:
                                {{ request('search') }}

                                <a
                                    href="{{ request()->fullUrlWithQuery(['search' => null, 'page' => null]) }}"
                                >
                                    <i data-lucide="x" width="10"></i>
                                </a>

                            </span>

                        @endif


                        @if(request('category'))

                            <span class="active-filter">

                                Category:
                                {{ request('category') }}

                                <a
                                    href="{{ request()->fullUrlWithQuery(['category' => null, 'page' => null]) }}"
                                >
                                    <i data-lucide="x" width="10"></i>
                                </a>

                            </span>

                        @endif


                        @if(request('location'))

                            <span class="active-filter">

                                Location:
                                {{ request('location') }}

                                <a
                                    href="{{ request()->fullUrlWithQuery(['location' => null, 'page' => null]) }}"
                                >
                                    <i data-lucide="x" width="10"></i>
                                </a>

                            </span>

                        @endif


                        @if(request('availability'))

                            <span class="active-filter">

                                {{ ucfirst(request('availability')) }}

                                <a
                                    href="{{ request()->fullUrlWithQuery(['availability' => null, 'page' => null]) }}"
                                >
                                    <i data-lucide="x" width="10"></i>
                                </a>

                            </span>

                        @endif

                    </div>

                @endif


                {{-- =================================================
                     PROVIDER GRID
                ================================================== --}}
                <div class="provider-grid">

                    @forelse($sproviders as $sprovider)

                        @php

                            $providerImage = !empty($sprovider->image)
                                ? asset('image/profile/' . $sprovider->image)
                                : asset('asset/images/lazy.svg');

                            $providerName = $sprovider->sprovider_name
                                ?: 'Service Provider';

                            $categoryName = '';

                            if(
                                !empty($sprovider->service_category_id) &&
                                isset($sprovider->category)
                            ) {
                                $categoryName = $sprovider->category->name;
                            }

                            $location = $sprovider->city
                                ?: $sprovider->service_locations
                                ?: 'Location not specified';

                            /*
                             * Support different possible rating fields.
                             */
                            $rating = $sprovider->rating
                                ?? $sprovider->average_rating
                                ?? 0;

                            $rating = is_numeric($rating)
                                ? round((float)$rating, 1)
                                : 0;

                            $reviewCount = $sprovider->reviews_count
                                ?? $sprovider->ratings_count
                                ?? 0;

                        @endphp


                        <article class="provider-card">

                            {{-- IMAGE --}}
                            <div class="provider-image-wrap">

                                <a
                                    href="{{ route('home.service-provider_profile', ['sprovider_id' => $sprovider->id]) }}"
                                >

                                    <img
                                        src="{{ $providerImage }}"
                                        alt="{{ $providerName }}"
                                        class="provider-image"
                                        loading="lazy"
                                        onerror="
                                            this.style.display='none';
                                            this.nextElementSibling.style.display='flex';
                                        "
                                    >

                                    <div
                                        class="provider-image-fallback"
                                        style="display:none;"
                                    >
                                        <i data-lucide="user-round" width="38"></i>
                                    </div>

                                </a>


                                {{-- Favourite --}}
                                <a
                                    href="{{ route('home.service-provider_profile', ['sprovider_id' => $sprovider->id]) }}"
                                    class="provider-favourite"
                                    aria-label="View provider"
                                >
                                    <i data-lucide="heart" width="14"></i>
                                </a>


                                {{-- Badges --}}
                                <div class="provider-badges">

                                    @if(!empty($sprovider->featured))
                                        <span class="provider-badge featured">
                                            <i data-lucide="star" width="9"></i>
                                            Featured
                                        </span>
                                    @endif

                                    @if(!empty($sprovider->verified))
                                        <span class="provider-badge">
                                            <i data-lucide="badge-check" width="9"></i>
                                            Verified
                                        </span>
                                    @endif

                                </div>

                            </div>


                            {{-- BODY --}}
                            <div class="provider-body">

                                @if($categoryName)

                                    <div class="provider-category">
                                        <i data-lucide="briefcase-business" width="10"></i>
                                        {{ $categoryName }}
                                    </div>

                                @endif


                                <h3 class="provider-name">

                                    <a
                                        href="{{ route('home.service-provider_profile', ['sprovider_id' => $sprovider->id]) }}"
                                    >
                                        {{ $providerName }}
                                    </a>

                                </h3>


                                <div class="provider-location">

                                    <i data-lucide="map-pin" width="11"></i>

                                    <span>
                                        {{ $location }}
                                    </span>

                                </div>


                                {{-- Rating --}}
                                <div class="provider-rating">

                                    <span class="rating-stars">

                                        @for($i = 1; $i <= 5; $i++)

                                            @if($rating >= $i)

                                                <i
                                                    data-lucide="star"
                                                    width="10"
                                                    fill="currentColor"
                                                ></i>

                                            @elseif($rating >= $i - .5)

                                                <i
                                                    data-lucide="star-half"
                                                    width="10"
                                                    fill="currentColor"
                                                ></i>

                                            @else

                                                <i
                                                    data-lucide="star"
                                                    width="10"
                                                ></i>

                                            @endif

                                        @endfor

                                    </span>

                                    <span class="rating-number">
                                        {{ number_format($rating, 1) }}
                                    </span>

                                    @if($reviewCount > 0)

                                        <span class="rating-reviews">
                                            ({{ number_format($reviewCount) }})
                                        </span>

                                    @endif

                                </div>


                                {{-- Actions --}}
                                <div class="provider-actions">

                                    <a
                                        href="{{ route('home.service-provider_profile', ['sprovider_id' => $sprovider->id]) }}"
                                        class="provider-action provider-view"
                                    >
                                        <i data-lucide="eye" width="12"></i>
                                        View Profile
                                    </a>


                                    @if(!empty($sprovider->proEmail))

                                        <a
                                            href="mailto:{{ $sprovider->proEmail }}"
                                            class="provider-action provider-message"
                                        >
                                            <i data-lucide="message-circle" width="12"></i>
                                            Message
                                        </a>

                                    @else

                                        <a
                                            href="{{ route('home.service-provider_profile', ['sprovider_id' => $sprovider->id]) }}"
                                            class="provider-action provider-message"
                                        >
                                            <i data-lucide="message-circle" width="12"></i>
                                            Contact
                                        </a>

                                    @endif

                                </div>

                            </div>

                        </article>

                    @empty

                        <div class="empty-state">

                            <div class="empty-icon">
                                <i data-lucide="users-round-search" width="28"></i>
                            </div>

                            <h3>
                                No service providers found
                            </h3>

                            <p>
                                We couldn't find providers matching your current
                                filters. Try changing the category, location or
                                search keywords.
                            </p>

                            <a
                                href="{{ route('home.service_provider') }}"
                                class="reset-all"
                            >
                                <i data-lucide="rotate-ccw" width="13"></i>
                                Reset Filters
                            </a>

                        </div>

                    @endforelse

                </div>


                {{-- =================================================
                     PAGINATION
                ================================================== --}}
                @if(method_exists($sproviders, 'hasPages') && $sproviders->hasPages())

                    <div class="pagination-wrapper">

                        <div class="pagination-info">

                            Showing

                            <strong>
                                {{ $sproviders->firstItem() ?? 0 }}
                            </strong>

                            to

                            <strong>
                                {{ $sproviders->lastItem() ?? 0 }}
                            </strong>

                            of

                            <strong>
                                {{ number_format($sproviders->total()) }}
                            </strong>

                            providers

                        </div>


                        <div>
                            {{ $sproviders->onEachSide(1)->links() }}
                        </div>

                    </div>

                @endif

            </main>

        </div>

    </div>

</section>


{{-- =========================================================
     MOBILE FILTER OFFCANVAS
========================================================= --}}
<div
    class="offcanvas offcanvas-start filter-offcanvas"
    tabindex="-1"
    id="mobileProviderFilter"
    aria-labelledby="mobileProviderFilterLabel"
>

    <div class="offcanvas-header">

        <h5
            class="offcanvas-title"
            id="mobileProviderFilterLabel"
        >
            Filter Providers
        </h5>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>

    </div>


    <div class="offcanvas-body p-0">

        <form
            method="GET"
            action="{{ route('home.service_provider') }}"
            class="filter-body"
        >

            {{-- Search --}}
            <div class="filter-group">

                <label class="filter-label">
                    Search
                </label>

                <div class="filter-input-wrap">

                    <i data-lucide="search" width="14"></i>

                    <input
                        type="text"
                        name="search"
                        class="filter-input"
                        placeholder="Provider or service..."
                        value="{{ request('search') }}"
                    >

                </div>

            </div>


            {{-- Category --}}
            <div class="filter-group">

                <label class="filter-label">
                    Category
                </label>

                <select
                    name="category"
                    class="filter-select"
                >

                    <option value="">
                        All categories
                    </option>

                    @foreach($categories ?? [] as $category)

                        <option
                            value="{{ $category->slug }}"
                            @selected(request('category') == $category->slug)
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Location --}}
            <div class="filter-group">

                <label class="filter-label">
                    Location
                </label>

                <select
                    name="location"
                    class="filter-select"
                >

                    <option value="">
                        All locations
                    </option>

                    @foreach($locations ?? [] as $location)

                        <option
                            value="{{ $location }}"
                            @selected(request('location') == $location)
                        >
                            {{ $location }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Availability --}}
            <div class="filter-group">

                <label class="filter-label">
                    Availability
                </label>

                <label class="filter-check">
                    <input
                        type="radio"
                        name="availability"
                        value=""
                        @checked(!request('availability'))
                    >
                    <span>All providers</span>
                </label>

                <label class="filter-check">
                    <input
                        type="radio"
                        name="availability"
                        value="available"
                        @checked(request('availability') === 'available')
                    >
                    <span>Available now</span>
                </label>

                <label class="filter-check">
                    <input
                        type="radio"
                        name="availability"
                        value="verified"
                        @checked(request('availability') === 'verified')
                    >
                    <span>Verified providers</span>
                </label>

            </div>


            {{-- Sort --}}
            <div class="filter-group">

                <label class="filter-label">
                    Sort By
                </label>

                <select
                    name="sort"
                    class="filter-select"
                >

                    <option
                        value="latest"
                        @selected(request('sort', 'latest') === 'latest')
                    >
                        Newest
                    </option>

                    <option
                        value="name"
                        @selected(request('sort') === 'name')
                    >
                        Name A–Z
                    </option>

                    <option
                        value="rating"
                        @selected(request('sort') === 'rating')
                    >
                        Highest rated
                    </option>

                </select>

            </div>


            <button
                type="submit"
                class="apply-filter"
            >
                Apply Filters
            </button>

        </form>

    </div>

</div>


{{-- =========================================================
     CALL TO ACTION
========================================================= --}}
@include('includes.call-to-action')


<script>
    document.addEventListener('DOMContentLoaded', function () {

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

    });
</script>

@endsection