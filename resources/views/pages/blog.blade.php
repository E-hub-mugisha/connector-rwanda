@extends('layouts.base')

@section('title', 'Blogs')

@section('content')

@php
    $selectedCategoryId = request('category');
    $selectedSubcategoryId = request('subcategory');
    $searchQuery = request('query');

    $selectedCategory = $selectedCategoryId
        ? $categories->firstWhere('id', $selectedCategoryId)
        : null;

    $selectedSubcategory = $selectedSubcategoryId
        ? $subcategories->firstWhere('id', $selectedSubcategoryId)
        : null;
@endphp

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

    .blogs-page {
        background: #ffffff;
        color: var(--connector-text);
    }

    /* =========================================================
       HERO
    ========================================================= */

    .blogs-hero {
        position: relative;
        overflow: hidden;
        padding: 85px 0 80px;
        background:
            linear-gradient(
                135deg,
                #f7faf8 0%,
                #edf3f0 100%
            );
        border-bottom: 1px solid var(--connector-border);
    }

    .blogs-hero::before {
        content: "";
        position: absolute;
        width: 380px;
        height: 380px;
        border-radius: 50%;
        background: rgba(107, 144, 128, 0.08);
        top: -180px;
        right: -100px;
    }

    .blogs-hero::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(37, 64, 53, 0.04);
        bottom: -130px;
        left: -70px;
    }

    .blogs-hero-content {
        position: relative;
        z-index: 2;
        max-width: 780px;
    }

    .blogs-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 13px;
        background: #ffffff;
        border: 1px solid var(--connector-border);
        border-radius: 50px;
        color: var(--connector-primary);
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 18px;
    }

    .blogs-eyebrow i {
        color: var(--connector-accent);
    }

    .blogs-hero h1 {
        margin: 0;
        font-size: clamp(38px, 5vw, 62px);
        line-height: 1.05;
        font-weight: 700;
        letter-spacing: -1.8px;
        color: var(--connector-primary);
    }

    .blogs-hero p {
        margin: 20px 0 0;
        max-width: 650px;
        color: var(--connector-muted);
        font-size: 18px;
        line-height: 1.7;
    }

    /* =========================================================
       MAIN
    ========================================================= */

    .blogs-main {
        padding: 70px 0 100px;
    }

    /* =========================================================
       SIDEBAR
    ========================================================= */

    .blog-sidebar {
        position: sticky;
        top: 100px;
    }

    .filter-card {
        background: var(--connector-white);
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        padding: 24px;
    }

    .filter-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 22px;
    }

    .filter-heading h3 {
        margin: 0;
        color: var(--connector-primary);
        font-size: 18px;
        font-weight: 700;
    }

    .filter-heading i {
        color: var(--connector-accent);
        font-size: 19px;
    }

    .filter-label {
        display: block;
        margin-bottom: 10px;
        color: var(--connector-text);
        font-size: 13px;
        font-weight: 600;
    }

    /* =========================================================
       SEARCH
    ========================================================= */

    .blog-search {
        position: relative;
        margin-bottom: 28px;
    }

    .blog-search i {
        position: absolute;
        top: 50%;
        left: 17px;
        transform: translateY(-50%);
        color: var(--connector-muted);
        font-size: 17px;
        z-index: 2;
    }

    .blog-search input {
        width: 100%;
        height: 52px;
        border: 1px solid var(--connector-border);
        border-radius: 12px;
        padding: 0 50px 0 47px;
        background: #ffffff;
        color: var(--connector-text);
        font-size: 14px;
        outline: none;
        transition: all .2s ease;
    }

    .blog-search input:focus {
        border-color: var(--connector-accent);
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .10);
    }

    .blog-search button {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 40px;
        height: 40px;
        border: 0;
        border-radius: 9px;
        background: var(--connector-primary);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* =========================================================
       CATEGORY LIST
    ========================================================= */

    .category-list {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .category-list li {
        margin: 0;
        padding: 0;
    }

    .category-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        width: 100%;
        padding: 11px 12px;
        border-radius: 10px;
        color: var(--connector-muted);
        text-decoration: none;
        font-size: 14px;
        transition: all .2s ease;
    }

    .category-link .category-name {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 0;
    }

    .category-link .category-name i {
        color: var(--connector-accent);
        font-size: 15px;
    }

    .category-count {
        min-width: 27px;
        height: 24px;
        padding: 0 7px;
        border-radius: 50px;
        background: var(--connector-soft);
        color: var(--connector-muted);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 600;
    }

    .category-link:hover {
        background: var(--connector-accent-soft);
        color: var(--connector-primary);
    }

    .category-link.active {
        background: var(--connector-primary);
        color: #ffffff;
    }

    .category-link.active .category-name i {
        color: #ffffff;
    }

    .category-link.active .category-count {
        background: rgba(255,255,255,.13);
        color: #ffffff;
    }

    /* =========================================================
       SELECT
    ========================================================= */

    .subcategory-wrapper {
        margin-top: 26px;
        padding-top: 24px;
        border-top: 1px solid var(--connector-border);
    }

    .filter-select {
        width: 100%;
        height: 48px;
        border: 1px solid var(--connector-border);
        border-radius: 11px;
        padding: 0 40px 0 13px;
        background-color: #ffffff;
        color: var(--connector-text);
        font-size: 13px;
        outline: none;
        cursor: pointer;
        transition: all .2s ease;
    }

    .filter-select:focus {
        border-color: var(--connector-accent);
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .10);
    }

    .subcategory-help {
        display: flex;
        gap: 7px;
        align-items: flex-start;
        margin-top: 9px;
        color: var(--connector-muted);
        font-size: 11px;
        line-height: 1.5;
    }

    .subcategory-help i {
        margin-top: 2px;
        color: var(--connector-accent);
    }

    /* =========================================================
       CLEAR FILTERS
    ========================================================= */

    .clear-filters {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        margin-top: 20px;
        padding: 11px 15px;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        color: var(--connector-muted);
        background: #ffffff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all .2s ease;
    }

    .clear-filters:hover {
        border-color: var(--connector-primary);
        color: var(--connector-primary);
        background: var(--connector-soft);
    }

    /* =========================================================
       CONTENT HEADER
    ========================================================= */

    .blogs-content-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 25px;
    }

    .blogs-result-title {
        margin: 0;
        color: var(--connector-primary);
        font-size: 22px;
        font-weight: 700;
    }

    .blogs-result-count {
        margin-top: 5px;
        color: var(--connector-muted);
        font-size: 13px;
    }

    /* =========================================================
       FILTER CHIPS
    ========================================================= */

    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 24px;
    }

    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        border-radius: 50px;
        background: var(--connector-accent-soft);
        color: var(--connector-primary);
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
    }

    .filter-chip i {
        font-size: 12px;
    }

    .filter-chip:hover {
        background: #e1ebe6;
        color: var(--connector-primary);
    }

    /* =========================================================
       BLOG CARD
    ========================================================= */

    .blog-card {
        height: 100%;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--connector-border);
        border-radius: 17px;
        transition:
            transform .25s ease,
            box-shadow .25s ease,
            border-color .25s ease;
    }

    .blog-card:hover {
        transform: translateY(-4px);
        border-color: #d5e0db;
        box-shadow: 0 14px 35px rgba(37, 64, 53, .08);
    }

    .blog-image {
        position: relative;
        overflow: hidden;
        height: 220px;
        background: var(--connector-soft);
    }

    .blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .45s ease;
    }

    .blog-card:hover .blog-image img {
        transform: scale(1.035);
    }

    .blog-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--connector-accent-soft);
        color: var(--connector-accent);
        font-size: 40px;
    }

    .blog-category-badge {
        position: absolute;
        left: 14px;
        bottom: 14px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 50px;
        background: rgba(255,255,255,.95);
        color: var(--connector-primary);
        font-size: 11px;
        font-weight: 700;
        box-shadow: 0 5px 15px rgba(0,0,0,.08);
    }

    .blog-card-body {
        padding: 21px;
    }

    .blog-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        color: var(--connector-muted);
        font-size: 11px;
        margin-bottom: 11px;
    }

    .blog-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .blog-meta .dot {
        width: 3px;
        height: 3px;
        border-radius: 50%;
        background: #b8c3bd;
    }

    .blog-card-title {
        margin: 0;
        font-size: 18px;
        line-height: 1.4;
        font-weight: 700;
    }

    .blog-card-title a {
        color: var(--connector-primary);
        text-decoration: none;
        transition: color .2s ease;
    }

    .blog-card-title a:hover {
        color: var(--connector-accent);
    }

    .blog-excerpt {
        margin: 11px 0 0;
        color: var(--connector-muted);
        font-size: 13px;
        line-height: 1.65;
    }

    .blog-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 18px;
        padding-top: 15px;
        border-top: 1px solid var(--connector-border);
    }

    .blog-author {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
        color: var(--connector-muted);
        font-size: 11px;
    }

    .blog-author i {
        color: var(--connector-accent);
    }

    .read-more {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--connector-primary);
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .read-more i {
        transition: transform .2s ease;
    }

    .read-more:hover {
        color: var(--connector-accent);
    }

    .read-more:hover i {
        transform: translateX(3px);
    }

    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .blog-empty {
        padding: 70px 30px;
        text-align: center;
        background: var(--connector-soft);
        border: 1px dashed var(--connector-border);
        border-radius: 18px;
    }

    .blog-empty-icon {
        width: 65px;
        height: 65px;
        margin: 0 auto 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--connector-accent-soft);
        color: var(--connector-accent);
        font-size: 25px;
    }

    .blog-empty h3 {
        margin: 0;
        color: var(--connector-primary);
        font-size: 20px;
        font-weight: 700;
    }

    .blog-empty p {
        max-width: 460px;
        margin: 9px auto 20px;
        color: var(--connector-muted);
        font-size: 13px;
        line-height: 1.6;
    }

    .empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 17px;
        border-radius: 9px;
        background: var(--connector-primary);
        color: #ffffff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .empty-btn:hover {
        background: #1d332a;
        color: #ffffff;
    }

    /* =========================================================
       PAGINATION
    ========================================================= */

    .blogs-pagination {
        margin-top: 40px;
    }

    .blogs-pagination .pagination {
        margin: 0;
        justify-content: center;
        gap: 5px;
    }

    .blogs-pagination .page-item .page-link {
        min-width: 38px;
        height: 38px;
        padding: 0 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--connector-border);
        border-radius: 9px !important;
        color: var(--connector-primary);
        background: #ffffff;
        font-size: 13px;
    }

    .blogs-pagination .page-item.active .page-link {
        background: var(--connector-primary);
        border-color: var(--connector-primary);
        color: #ffffff;
    }

    .blogs-pagination .page-item .page-link:hover {
        background: var(--connector-accent-soft);
        border-color: var(--connector-accent);
    }

    /* =========================================================
       CTA
    ========================================================= */

    .blogs-cta {
        padding: 0 0 90px;
    }

    .blogs-cta-card {
        position: relative;
        overflow: hidden;
        padding: 45px;
        border-radius: 20px;
        background: var(--connector-primary);
        color: #ffffff;
    }

    .blogs-cta-card::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,.08);
        right: -80px;
        top: -100px;
    }

    .blogs-cta-content {
        position: relative;
        z-index: 2;
    }

    .blogs-cta h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
    }

    .blogs-cta p {
        margin: 9px 0 0;
        color: rgba(255,255,255,.72);
        font-size: 14px;
    }

    .blogs-cta-actions {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 10px;
    }

    .cta-primary,
    .cta-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 11px 18px;
        border-radius: 9px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all .2s ease;
    }

    .cta-primary {
        background: #ffffff;
        color: var(--connector-primary);
    }

    .cta-primary:hover {
        background: var(--connector-accent-soft);
        color: var(--connector-primary);
    }

    .cta-secondary {
        border: 1px solid rgba(255,255,255,.25);
        color: #ffffff;
    }

    .cta-secondary:hover {
        background: rgba(255,255,255,.08);
        color: #ffffff;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .blogs-hero {
            padding: 65px 0 60px;
        }

        .blogs-main {
            padding: 50px 0 70px;
        }

        .blog-sidebar {
            position: static;
            margin-bottom: 35px;
        }

        .blogs-content-header {
            margin-top: 10px;
        }

        .blogs-cta-card {
            padding: 35px 28px;
        }

        .blogs-cta-actions {
            justify-content: flex-start;
            margin-top: 25px;
        }
    }

    @media (max-width: 575.98px) {

        .blogs-hero h1 {
            letter-spacing: -1px;
        }

        .blogs-hero p {
            font-size: 15px;
        }

        .filter-card {
            padding: 20px;
        }

        .blogs-content-header {
            display: block;
        }

        .blogs-result-title {
            font-size: 20px;
        }

        .blog-image {
            height: 200px;
        }

        .blogs-cta-card {
            padding: 30px 22px;
        }

        .blogs-cta h2 {
            font-size: 24px;
        }

        .blogs-cta-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .cta-primary,
        .cta-secondary {
            width: 100%;
        }
    }
</style>


<div class="blogs-page">

    {{-- =========================================================
         HERO
    ========================================================== --}}
    <section class="blogs-hero">

        <div class="container">

            <div class="blogs-hero-content">

                <div class="blogs-eyebrow">
                    <i class="bi bi-journal-text"></i>
                    Connector Insights
                </div>

                <h1>
                    Ideas, stories and useful insights.
                </h1>

                <p>
                    Explore practical knowledge, service insights and stories
                    designed to help you make better decisions and connect
                    with the right services.
                </p>

            </div>

        </div>

    </section>


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}
    <section class="blogs-main">

        <div class="container">

            <div class="row g-4 g-xl-5">

                {{-- =====================================================
                     SIDEBAR
                ====================================================== --}}
                <div class="col-lg-4 col-xl-3">

                    <aside class="blog-sidebar">

                        <div class="filter-card">

                            <div class="filter-heading">

                                <h3>
                                    Filter articles
                                </h3>

                                <i class="bi bi-sliders"></i>

                            </div>


                            {{-- =========================================
                                 SEARCH
                            ========================================== --}}
                            <form
                                action="{{ route('home.blogs') }}"
                                method="GET"
                                id="blogFilterForm"
                            >

                                <div class="blog-search">

                                    <i class="bi bi-search"></i>

                                    <input
                                        type="text"
                                        name="query"
                                        value="{{ request('query') }}"
                                        placeholder="Search articles..."
                                        autocomplete="off"
                                    >

                                    <button type="submit" aria-label="Search">
                                        <i class="bi bi-arrow-right"></i>
                                    </button>

                                </div>


                                {{-- =====================================
                                     CATEGORY
                                ====================================== --}}
                                <div>

                                    <label class="filter-label">
                                        Category
                                    </label>

                                    <ul class="category-list">

                                        {{-- All categories --}}
                                        <li>

                                            @php
                                                $allCategoriesUrl = route(
                                                    'home.blogs',
                                                    array_filter([
                                                        'query' => request('query'),
                                                    ])
                                                );
                                            @endphp

                                            <a
                                                href="{{ $allCategoriesUrl }}"
                                                class="category-link {{ !$selectedCategoryId ? 'active' : '' }}"
                                            >

                                                <span class="category-name">

                                                    <i class="bi bi-grid"></i>

                                                    <span>
                                                        All categories
                                                    </span>

                                                </span>

                                                <span class="category-count">
                                                    {{ $categories->sum('published_blogs_count') }}
                                                </span>

                                            </a>

                                        </li>


                                        {{-- Individual categories --}}
                                        @foreach($categories as $category)

                                            @php
                                                /*
                                                 * IMPORTANT:
                                                 * Selecting a new category must
                                                 * remove the existing subcategory.
                                                 */
                                                $categoryUrl = route(
                                                    'home.blogs',
                                                    array_filter([
                                                        'query' => request('query'),
                                                        'category' => $category->id,
                                                    ])
                                                );
                                            @endphp

                                            <li>

                                                <a
                                                    href="{{ $categoryUrl }}"
                                                    class="category-link {{ (string) $selectedCategoryId === (string) $category->id ? 'active' : '' }}"
                                                >

                                                    <span class="category-name">

                                                        <i class="bi bi-folder2-open"></i>

                                                        <span>
                                                            {{ $category->name }}
                                                        </span>

                                                    </span>

                                                    <span class="category-count">
                                                        {{ $category->published_blogs_count }}
                                                    </span>

                                                </a>

                                            </li>

                                        @endforeach

                                    </ul>

                                </div>


                                {{-- =====================================
                                     SUBCATEGORY
                                ====================================== --}}
                                <div class="subcategory-wrapper">

                                    <label
                                        for="blogSubcategory"
                                        class="filter-label"
                                    >
                                        Subcategory
                                    </label>

                                    <select
                                        name="subcategory"
                                        id="blogSubcategory"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            All subcategories
                                        </option>

                                        @foreach($subcategories as $subcategory)

                                            <option
                                                value="{{ $subcategory->id }}"
                                                data-category-id="{{ $subcategory->service_category_id }}"
                                                {{ (string) $selectedSubcategoryId === (string) $subcategory->id ? 'selected' : '' }}
                                            >
                                                {{ $subcategory->name }}
                                                ({{ $subcategory->published_blogs_count }})
                                            </option>

                                        @endforeach

                                    </select>


                                    <div class="subcategory-help">

                                        <i class="bi bi-info-circle"></i>

                                        <span>
                                            Selecting a subcategory will
                                            automatically apply its parent
                                            category.
                                        </span>

                                    </div>

                                </div>


                                {{-- =====================================
                                     HIDDEN CATEGORY
                                     Used by JS when subcategory changes
                                ====================================== --}}
                                <input
                                    type="hidden"
                                    name="category"
                                    id="blogCategoryInput"
                                    value="{{ $selectedCategoryId }}"
                                >

                            </form>


                            {{-- =========================================
                                 CLEAR
                            ========================================== --}}
                            @if(request()->filled('query') ||
                                request()->filled('category') ||
                                request()->filled('subcategory'))

                                <a
                                    href="{{ route('home.blogs') }}"
                                    class="clear-filters"
                                >
                                    <i class="bi bi-x-circle"></i>
                                    Clear all filters
                                </a>

                            @endif

                        </div>

                    </aside>

                </div>


                {{-- =====================================================
                     BLOG CONTENT
                ====================================================== --}}
                <div class="col-lg-8 col-xl-9">

                    {{-- ================================================
                         HEADER
                    ================================================= --}}
                    <div class="blogs-content-header">

                        <div>

                            <h2 class="blogs-result-title">
                                Latest articles
                            </h2>

                            <div class="blogs-result-count">

                                @if($blogs->total() > 0)

                                    Showing
                                    <strong>
                                        {{ $blogs->firstItem() }}
                                    </strong>
                                    –
                                    <strong>
                                        {{ $blogs->lastItem() }}
                                    </strong>
                                    of
                                    <strong>
                                        {{ $blogs->total() }}
                                    </strong>
                                    articles

                                @else

                                    No articles found

                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- ================================================
                         ACTIVE FILTERS
                    ================================================= --}}
                    @if(
                        request()->filled('query') ||
                        request()->filled('category') ||
                        request()->filled('subcategory')
                    )

                        <div class="active-filters">

                            {{-- Search filter --}}
                            @if(request()->filled('query'))

                                <a
                                    href="{{ route('home.blogs', array_filter([
                                        'category' => $selectedCategoryId,
                                        'subcategory' => $selectedSubcategoryId,
                                    ])) }}"
                                    class="filter-chip"
                                >

                                    <i class="bi bi-search"></i>

                                    {{ request('query') }}

                                    <i class="bi bi-x"></i>

                                </a>

                            @endif


                            {{-- Category filter --}}
                            @if($selectedCategory)

                                <a
                                    href="{{ route('home.blogs', array_filter([
                                        'query' => request('query'),
                                    ])) }}"
                                    class="filter-chip"
                                >

                                    <i class="bi bi-folder2-open"></i>

                                    {{ $selectedCategory->name }}

                                    <i class="bi bi-x"></i>

                                </a>

                            @endif


                            {{-- Subcategory filter --}}
                            @if($selectedSubcategory)

                                <a
                                    href="{{ route('home.blogs', array_filter([
                                        'query' => request('query'),
                                        'category' => $selectedCategoryId,
                                    ])) }}"
                                    class="filter-chip"
                                >

                                    <i class="bi bi-tag"></i>

                                    {{ $selectedSubcategory->name }}

                                    <i class="bi bi-x"></i>

                                </a>

                            @endif

                        </div>

                    @endif


                    {{-- ================================================
                         BLOG GRID
                    ================================================= --}}
                    @if($blogs->count())

                        <div class="row g-4">

                            @foreach($blogs as $blog)

                                @php
                                    $categoryName = optional($blog->category)->name;
                                    $subcategoryName = optional($blog->subcategory)->name;

                                    $excerpt = trim(
                                        preg_replace(
                                            '/\s+/',
                                            ' ',
                                            strip_tags($blog->content ?? '')
                                        )
                                    );
                                @endphp

                                <div class="col-md-6 col-xl-4">

                                    <article class="blog-card">

                                        {{-- IMAGE --}}
                                        <div class="blog-image">

                                            @if($blog->image)

                                                <img
                                                    src="{{ asset('image/blog/' . $blog->image) }}"
                                                    alt="{{ $blog->title }}"
                                                    loading="lazy"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                >

                                                <div
                                                    class="blog-image-placeholder"
                                                    style="display:none;"
                                                >
                                                    <i class="bi bi-journal-text"></i>
                                                </div>

                                            @else

                                                <div class="blog-image-placeholder">

                                                    <i class="bi bi-journal-text"></i>

                                                </div>

                                            @endif


                                            @if($categoryName)

                                                <span class="blog-category-badge">

                                                    <i class="bi bi-folder2-open"></i>

                                                    {{ $categoryName }}

                                                </span>

                                            @endif

                                        </div>


                                        {{-- BODY --}}
                                        <div class="blog-card-body">

                                            <div class="blog-meta">

                                                @if($subcategoryName)

                                                    <span>
                                                        <i class="bi bi-tag"></i>
                                                        {{ $subcategoryName }}
                                                    </span>

                                                    <span class="dot"></span>

                                                @endif

                                                <span>
                                                    <i class="bi bi-calendar3"></i>
                                                    {{ optional($blog->created_at)->format('M d, Y') }}
                                                </span>

                                                <span class="dot"></span>

                                                <span>
                                                    <i class="bi bi-eye"></i>
                                                    {{ number_format($blog->views ?? 0) }}
                                                </span>

                                            </div>


                                            <h3 class="blog-card-title">

                                                <a
                                                    href="{{ route('home.blog_detail', ['blog_slug' => $blog->slug]) }}"
                                                >
                                                    {{ $blog->title }}
                                                </a>

                                            </h3>


                                            @if($excerpt)

                                                <p class="blog-excerpt">

                                                    {{ \Illuminate\Support\Str::limit($excerpt, 120) }}

                                                </p>

                                            @endif


                                            <div class="blog-card-footer">

                                                <div class="blog-author">

                                                    <i class="bi bi-person"></i>

                                                    <span>
                                                        {{ optional($blog->user)->name ?? 'Connector' }}
                                                    </span>

                                                </div>


                                                <a
                                                    href="{{ route('home.blog_detail', ['blog_slug' => $blog->slug]) }}"
                                                    class="read-more"
                                                >

                                                    Read article

                                                    <i class="bi bi-arrow-right"></i>

                                                </a>

                                            </div>

                                        </div>

                                    </article>

                                </div>

                            @endforeach

                        </div>


                        {{-- =============================================
                             PAGINATION
                        ============================================== --}}
                        @if($blogs->hasPages())

                            <div class="blogs-pagination">

                                {{ $blogs->onEachSide(1)->links('pagination::bootstrap-5') }}

                            </div>

                        @endif


                    @else

                        {{-- =============================================
                             EMPTY STATE
                        ============================================== --}}
                        <div class="blog-empty">

                            <div class="blog-empty-icon">

                                <i class="bi bi-search"></i>

                            </div>

                            <h3>
                                No articles found
                            </h3>

                            <p>
                                We couldn't find any articles matching your
                                current filters. Try another category,
                                subcategory or search term.
                            </p>

                            <a
                                href="{{ route('home.blogs') }}"
                                class="empty-btn"
                            >
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Reset filters
                            </a>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
         CTA
    ========================================================== --}}
    <section class="blogs-cta">

        <div class="container">

            <div class="blogs-cta-card">

                <div class="blogs-cta-content">

                    <div class="row align-items-center">

                        <div class="col-lg-7">

                            <h2>
                                Looking for the right service?
                            </h2>

                            <p>
                                Explore service providers and find the
                                expertise you need on Connector.
                            </p>

                        </div>

                        <div class="col-lg-5">

                            <div class="blogs-cta-actions">

                                <a
                                    href="{{ route('home.services') }}"
                                    class="cta-primary"
                                >
                                    <i class="bi bi-search"></i>
                                    Find a service
                                </a>

                                <a
                                    href="{{ route('register') }}"
                                    class="cta-secondary"
                                >
                                    <i class="bi bi-person-plus"></i>
                                    Join Connector
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>


{{-- =============================================================
     SUBCATEGORY → PARENT CATEGORY LOGIC
============================================================== --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('blogFilterForm');
        const subcategory = document.getElementById('blogSubcategory');
        const categoryInput = document.getElementById('blogCategoryInput');

        if (!form || !subcategory || !categoryInput) {
            return;
        }

        subcategory.addEventListener('change', function () {

            const selectedOption =
                this.options[this.selectedIndex];

            /*
             * User selected "All subcategories"
             */
            if (!selectedOption.value) {

                /*
                 * Keep the currently selected parent category.
                 */
                form.submit();

                return;
            }

            /*
             * Get the parent category from the selected
             * subcategory.
             */
            const parentCategoryId =
                selectedOption.getAttribute('data-category-id');

            if (parentCategoryId) {

                /*
                 * Automatically set the parent category.
                 */
                categoryInput.value = parentCategoryId;

            }

            /*
             * Submit the complete filter.
             *
             * Example:
             *
             * /blogs?category=9&subcategory=10
             */
            form.submit();

        });

    });
</script>

@endsection