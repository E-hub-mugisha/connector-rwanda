@extends('layouts.app')

@section('title', $service->name)

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | Pricing
    |--------------------------------------------------------------------------
    */

    $price = (float) ($service->price ?? 0);
    $discount = (float) ($service->discount ?? 0);

    $total = $price;
    $discountLabel = null;

    if ($discount > 0) {
        if ($service->discount_type === 'fixed') {
            $total = max(0, $price - $discount);
            $discountLabel = 'RWF ' . number_format($discount, 0);
        } elseif ($service->discount_type === 'percent') {
            $total = max(0, $price - ($price * $discount / 100));
            $discountLabel = number_format($discount, 0) . '%';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Ratings
    |--------------------------------------------------------------------------
    */

    $ratings = $service->ratings ?? collect();

    $ratingCount = $ratings->count();

    $averageRating = $ratingCount > 0
        ? round($ratings->avg('rating'), 1)
        : 0;

    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */

    $bookingCount = $service->serviceBookings
        ? $service->serviceBookings->count()
        : 0;

    $mediaCount = $service->media
        ? $service->media->count()
        : 0;

    $portfolioCount = $service->portfolios
        ? $service->portfolios->count()
        : 0;

    $staffCount = $service->staffMembers
        ? $service->staffMembers->count()
        : 0;

    /*
    |--------------------------------------------------------------------------
    | Active Promotions
    |--------------------------------------------------------------------------
    */

    $activePromotions = $service->promotions
        ? $service->promotions->filter(function ($promotion) {
            return (!$promotion->start_date || $promotion->start_date->isPast() || $promotion->start_date->isToday())
                && (!$promotion->end_date || $promotion->end_date->isFuture() || $promotion->end_date->isToday());
        })
        : collect();

    /*
    |--------------------------------------------------------------------------
    | Main Image
    |--------------------------------------------------------------------------
    */

    $mainImage = null;

    if (!empty($service->image)) {
        if (filter_var($service->image, FILTER_VALIDATE_URL)) {
            $mainImage = $service->image;
        } else {
            $mainImage = asset('image/services/' . ltrim($service->image, '/'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Provider
    |--------------------------------------------------------------------------
    */

    $provider = $service->provider;

    $providerName = $provider?->user?->name
        ?? $provider?->name
        ?? ($provider ? 'Provider #' . $provider->id : 'Service Provider');

    /*
    |--------------------------------------------------------------------------
    | Inclusion / Exclusion
    |--------------------------------------------------------------------------
    */

    $inclusions = collect(
        preg_split('/\|/', (string) $service->inclusion)
    )->map(fn ($item) => trim($item))->filter();

    $exclusions = collect(
        preg_split('/\|/', (string) $service->exclusion)
    )->map(fn ($item) => trim($item))->filter();
@endphp


<style>
    .service-show-page {
        background: #f6f8f7;
        min-height: 100vh;
        padding: 28px 0 60px;
    }

    .service-show-page .container-fluid {
        max-width: 1500px;
    }

    /* --------------------------------------------------------------
       Header
    -------------------------------------------------------------- */

    .service-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
    }

    .page-eyebrow {
        color: #6B9080;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        margin-bottom: 7px;
    }

    .page-title {
        color: #254035;
        font-size: 30px;
        font-weight: 800;
        margin: 0;
        line-height: 1.2;
    }

    .page-subtitle {
        color: #6d7d76;
        font-size: 14px;
        margin: 8px 0 0;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-connector {
        background: #6B9080;
        border: 1px solid #6B9080;
        color: #fff;
        border-radius: 10px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 700;
        transition: .2s ease;
    }

    .btn-connector:hover {
        background: #254035;
        border-color: #254035;
        color: #fff;
    }

    .btn-light-connector {
        background: #fff;
        border: 1px solid #dfe7e3;
        color: #254035;
        border-radius: 10px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 700;
    }

    .btn-light-connector:hover {
        background: #eef4f1;
        color: #254035;
    }

    /* --------------------------------------------------------------
       Cards
    -------------------------------------------------------------- */

    .connector-card {
        background: #fff;
        border: 1px solid #e6ece9;
        border-radius: 18px;
        box-shadow: 0 8px 28px rgba(37, 64, 53, .05);
        overflow: hidden;
    }

    .card-section {
        padding: 26px;
    }

    .section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 20px;
    }

    .section-title {
        color: #254035;
        font-size: 18px;
        font-weight: 800;
        margin: 0;
    }

    .section-description {
        color: #7a8983;
        font-size: 13px;
        margin: 5px 0 0;
    }

    /* --------------------------------------------------------------
       Hero
    -------------------------------------------------------------- */

    .service-hero {
        position: relative;
        min-height: 430px;
        background: #e9efec;
        overflow: hidden;
    }

    .service-hero img {
        width: 100%;
        height: 430px;
        object-fit: cover;
        display: block;
    }

    .service-image-placeholder {
        height: 430px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8b9c94;
        background: linear-gradient(135deg, #edf3f0, #dce8e2);
    }

    .service-image-placeholder svg {
        width: 70px;
        height: 70px;
    }

    .hero-overlay {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 70px 28px 26px;
        background: linear-gradient(
            to top,
            rgba(20, 38, 31, .9),
            rgba(20, 38, 31, .45),
            transparent
        );
    }

    .hero-category {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.22);
        backdrop-filter: blur(8px);
        color: #fff;
        padding: 7px 11px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .hero-title {
        color: #fff;
        font-size: 30px;
        font-weight: 800;
        margin: 0;
    }

    .hero-location {
        color: rgba(255,255,255,.85);
        font-size: 13px;
        margin-top: 9px;
    }

    /* --------------------------------------------------------------
       Price
    -------------------------------------------------------------- */

    .price-card {
        padding: 26px;
    }

    .price-label {
        color: #829089;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .7px;
    }

    .current-price {
        color: #254035;
        font-size: 30px;
        font-weight: 900;
        margin-top: 5px;
    }

    .original-price {
        color: #99a49f;
        font-size: 14px;
        text-decoration: line-through;
        margin-top: 2px;
    }

    .discount-badge {
        display: inline-flex;
        align-items: center;
        background: #e8f5ef;
        color: #267052;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 11px;
        font-weight: 800;
        margin-top: 10px;
    }

    /* --------------------------------------------------------------
       Info items
    -------------------------------------------------------------- */

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .info-item {
        background: #f8faf9;
        border: 1px solid #e9efec;
        border-radius: 12px;
        padding: 15px;
    }

    .info-label {
        color: #89958f;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        margin-bottom: 5px;
    }

    .info-value {
        color: #254035;
        font-size: 14px;
        font-weight: 700;
    }

    /* --------------------------------------------------------------
       Provider
    -------------------------------------------------------------- */

    .provider-card {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .provider-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #e5f0eb;
        color: #254035;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 17px;
        flex: 0 0 auto;
    }

    .provider-name {
        color: #254035;
        font-size: 15px;
        font-weight: 800;
    }

    .provider-meta {
        color: #89958f;
        font-size: 12px;
        margin-top: 3px;
    }

    /* --------------------------------------------------------------
       Description
    -------------------------------------------------------------- */

    .rich-text {
        color: #596963;
        font-size: 14px;
        line-height: 1.8;
    }

    .rich-text p:last-child {
        margin-bottom: 0;
    }

    /* --------------------------------------------------------------
       Inclusion
    -------------------------------------------------------------- */

    .feature-list {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .feature-list li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        color: #596963;
        font-size: 13px;
        line-height: 1.6;
        padding: 9px 0;
        border-bottom: 1px solid #edf1ef;
    }

    .feature-list li:last-child {
        border-bottom: 0;
    }

    .feature-icon {
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #e7f4ee;
        color: #34775d;
        flex: 0 0 auto;
        font-size: 12px;
        font-weight: 900;
    }

    .feature-icon.excluded {
        background: #f8e9e6;
        color: #b55748;
    }

    /* --------------------------------------------------------------
       Gallery
    -------------------------------------------------------------- */

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .gallery-item {
        height: 160px;
        border-radius: 12px;
        overflow: hidden;
        background: #edf2ef;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .25s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.04);
    }

    /* --------------------------------------------------------------
       Portfolio
    -------------------------------------------------------------- */

    .portfolio-card {
        overflow: hidden;
        border-radius: 14px;
        border: 1px solid #e7ece9;
        background: #fff;
        height: 100%;
    }

    .portfolio-image {
        height: 180px;
        overflow: hidden;
        background: #edf2ef;
    }

    .portfolio-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .portfolio-body {
        padding: 14px;
    }

    .portfolio-tag {
        color: #6B9080;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .6px;
    }

    /* --------------------------------------------------------------
       Promotions
    -------------------------------------------------------------- */

    .promotion-card {
        border: 1px solid #dcebe4;
        background: #f4faf7;
        border-radius: 13px;
        padding: 17px;
        height: 100%;
    }

    .promotion-title {
        color: #254035;
        font-size: 15px;
        font-weight: 800;
    }

    .promotion-description {
        color: #6c7c75;
        font-size: 13px;
        line-height: 1.6;
        margin-top: 6px;
    }

    .promotion-discount {
        color: #34775d;
        font-size: 12px;
        font-weight: 800;
        margin-top: 12px;
    }

    /* --------------------------------------------------------------
       Staff
    -------------------------------------------------------------- */

    .staff-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #edf1ef;
    }

    .staff-item:last-child {
        border-bottom: 0;
    }

    .staff-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #e7f0ec;
        color: #254035;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 800;
    }

    .staff-name {
        color: #254035;
        font-size: 13px;
        font-weight: 800;
    }

    /* --------------------------------------------------------------
       Rating
    -------------------------------------------------------------- */

    .rating-summary {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 18px;
        background: #f8faf9;
        border-radius: 14px;
        margin-bottom: 20px;
    }

    .rating-number {
        color: #254035;
        font-size: 35px;
        font-weight: 900;
        line-height: 1;
    }

    .stars {
        color: #d79d24;
        letter-spacing: 2px;
        font-size: 16px;
    }

    .rating-meta {
        color: #8a9691;
        font-size: 12px;
        margin-top: 4px;
    }

    .review-item {
        padding: 16px 0;
        border-bottom: 1px solid #edf1ef;
    }

    .review-item:last-child {
        border-bottom: 0;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        gap: 15px;
    }

    .review-user {
        color: #254035;
        font-size: 13px;
        font-weight: 800;
    }

    .review-date {
        color: #98a39e;
        font-size: 11px;
    }

    .review-comment {
        color: #65746d;
        font-size: 13px;
        line-height: 1.7;
        margin-top: 8px;
    }

    /* --------------------------------------------------------------
       Map
    -------------------------------------------------------------- */

    .map-wrapper {
        height: 380px;
        overflow: hidden;
        border-radius: 14px;
        border: 1px solid #e6ece9;
        background: #edf2ef;
    }

    .map-wrapper iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }

    /* --------------------------------------------------------------
       Statistics
    -------------------------------------------------------------- */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .stat-box {
        background: #f8faf9;
        border: 1px solid #e9efec;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
    }

    .stat-value {
        color: #254035;
        font-size: 22px;
        font-weight: 900;
    }

    .stat-label {
        color: #8a9691;
        font-size: 11px;
        margin-top: 2px;
    }

    /* --------------------------------------------------------------
       Status
    -------------------------------------------------------------- */

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 11px;
        font-size: 11px;
        font-weight: 800;
    }

    .status-active {
        background: #e7f5ed;
        color: #34775d;
    }

    .status-inactive {
        background: #f3e9e7;
        color: #a34d40;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* --------------------------------------------------------------
       Responsive
    -------------------------------------------------------------- */

    @media (max-width: 991.98px) {
        .service-page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 575.98px) {
        .service-show-page {
            padding-top: 18px;
        }

        .page-title {
            font-size: 24px;
        }

        .card-section,
        .price-card {
            padding: 20px;
        }

        .service-hero img,
        .service-image-placeholder {
            height: 320px;
        }

        .hero-title {
            font-size: 23px;
        }

        .info-grid,
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .gallery-grid {
            grid-template-columns: 1fr 1fr;
        }

        .gallery-item {
            height: 130px;
        }
    }
</style>


<div class="service-show-page">

    <div class="container-fluid px-3 px-lg-4">

        {{-- ==========================================================
             PAGE HEADER
        =========================================================== --}}

        <div class="service-page-header">

            <div>
                <div class="page-eyebrow">
                    Service Management
                </div>

                <h1 class="page-title">
                    Service Details
                </h1>

                <p class="page-subtitle">
                    View complete information about this service.
                </p>
            </div>

            <div class="header-actions">

                <a href="{{ route('admin.all_services') }}"
                   class="btn btn-light-connector">
                    ← Back to Services
                </a>

                @if(Route::has('admin.edit_service'))
                    <a href="{{ route('admin.edit_service', $service->id) }}"
                       class="btn btn-connector">
                        Edit Service
                    </a>
                @endif

            </div>

        </div>


        {{-- ==========================================================
             MAIN GRID
        =========================================================== --}}

        <div class="row g-4">

            {{-- ======================================================
                 LEFT COLUMN
            ======================================================= --}}

            <div class="col-xl-8">

                {{-- HERO --}}
                <div class="connector-card mb-4">

                    <div class="service-hero">

                        @if($mainImage)

                            <img src="{{ $mainImage }}"
                                 alt="{{ $service->name }}">

                        @else

                            <div class="service-image-placeholder">

                                <svg viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.5">
                                    <rect x="3"
                                          y="3"
                                          width="18"
                                          height="18"
                                          rx="2"/>
                                    <circle cx="8.5"
                                            cy="8.5"
                                            r="1.5"/>
                                    <path d="m21 15-5-5L5 21"/>
                                </svg>

                            </div>

                        @endif


                        <div class="hero-overlay">

                            <div class="hero-category">

                                {{ $service->category?->name ?? 'Uncategorized' }}

                                @if($service->subcategory)
                                    <span>•</span>
                                    {{ $service->subcategory->name }}
                                @endif

                            </div>

                            <h2 class="hero-title">
                                {{ $service->name }}
                            </h2>

                            @if($service->location)
                                <div class="hero-location">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    {{ $service->location }}
                                </div>
                            @endif

                        </div>

                    </div>

                </div>


                {{-- DESCRIPTION --}}
                <div class="connector-card mb-4">

                    <div class="card-section">

                        <div class="section-heading">

                            <div>
                                <h3 class="section-title">
                                    About This Service
                                </h3>

                                <p class="section-description">
                                    Detailed information about what the service offers.
                                </p>
                            </div>

                        </div>

                        <div class="rich-text">
                            {!! $service->description !!}
                        </div>

                    </div>

                </div>


                {{-- INCLUDED / EXCLUDED --}}
                <div class="connector-card mb-4">

                    <div class="card-section">

                        <div class="section-heading">

                            <div>
                                <h3 class="section-title">
                                    Service Scope
                                </h3>

                                <p class="section-description">
                                    What's included and excluded from this service.
                                </p>
                            </div>

                        </div>

                        <div class="row g-4">

                            {{-- INCLUDED --}}
                            <div class="col-md-6">

                                <h6 class="font-weight-bold mb-3"
                                    style="color:#254035;">
                                    What's Included
                                </h6>

                                @if($inclusions->count())

                                    <ul class="feature-list">

                                        @foreach($inclusions as $inclusion)

                                            <li>

                                                <span class="feature-icon">
                                                    ✓
                                                </span>

                                                <span>
                                                    {!! $inclusion !!}
                                                </span>

                                            </li>

                                        @endforeach

                                    </ul>

                                @else

                                    <p class="text-muted small mb-0">
                                        No inclusion information provided.
                                    </p>

                                @endif

                            </div>


                            {{-- EXCLUDED --}}
                            <div class="col-md-6">

                                <h6 class="font-weight-bold mb-3"
                                    style="color:#254035;">
                                    What's Excluded
                                </h6>

                                @if($exclusions->count())

                                    <ul class="feature-list">

                                        @foreach($exclusions as $exclusion)

                                            <li>

                                                <span class="feature-icon excluded">
                                                    ×
                                                </span>

                                                <span>
                                                    {!! $exclusion !!}
                                                </span>

                                            </li>

                                        @endforeach

                                    </ul>

                                @else

                                    <p class="text-muted small mb-0">
                                        No exclusion information provided.
                                    </p>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>


                {{-- GALLERY --}}
                @if($mediaCount > 0)

                    <div class="connector-card mb-4">

                        <div class="card-section">

                            <div class="section-heading">

                                <div>
                                    <h3 class="section-title">
                                        Service Gallery
                                    </h3>

                                    <p class="section-description">
                                        Additional media associated with this service.
                                    </p>
                                </div>

                                <span class="badge badge-light">
                                    {{ $mediaCount }} {{ Str::plural('item', $mediaCount) }}
                                </span>

                            </div>

                            <div class="gallery-grid">

                                @foreach($service->media as $media)

                                    @php
                                        $mediaUrl = filter_var($media->file_path, FILTER_VALIDATE_URL)
                                            ? $media->file_path
                                            : asset(ltrim($media->file_path, '/'));
                                    @endphp

                                    <div class="gallery-item">

                                        <img src="{{ $mediaUrl }}"
                                             alt="{{ $service->name }}">

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endif


                {{-- PORTFOLIO --}}
                @if($portfolioCount > 0)

                    <div class="connector-card mb-4">

                        <div class="card-section">

                            <div class="section-heading">

                                <div>
                                    <h3 class="section-title">
                                        Portfolio
                                    </h3>

                                    <p class="section-description">
                                        Previous work related to this service.
                                    </p>
                                </div>

                                <span class="badge badge-light">
                                    {{ $portfolioCount }} {{ Str::plural('project', $portfolioCount) }}
                                </span>

                            </div>

                            <div class="row g-3">

                                @foreach($service->portfolios as $portfolio)

                                    <div class="col-md-4">

                                        <div class="portfolio-card">

                                            @if($portfolio->image)

                                                @php
                                                    $portfolioImage = filter_var($portfolio->image, FILTER_VALIDATE_URL)
                                                        ? $portfolio->image
                                                        : asset('image/portfolio/' . ltrim($portfolio->image, '/'));
                                                @endphp

                                                <div class="portfolio-image">
                                                    <img src="{{ $portfolioImage }}"
                                                         alt="{{ $portfolio->tag ?? 'Portfolio' }}">
                                                </div>

                                            @endif

                                            <div class="portfolio-body">

                                                @if($portfolio->tag)
                                                    <div class="portfolio-tag">
                                                        {{ $portfolio->tag }}
                                                    </div>
                                                @else
                                                    <div class="portfolio-tag">
                                                        Previous Work
                                                    </div>
                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endif


                {{-- PROMOTIONS --}}
                @if($activePromotions->count() > 0)

                    <div class="connector-card mb-4">

                        <div class="card-section">

                            <div class="section-heading">

                                <div>
                                    <h3 class="section-title">
                                        Active Promotions
                                    </h3>

                                    <p class="section-description">
                                        Current promotions available for this service.
                                    </p>
                                </div>

                            </div>

                            <div class="row g-3">

                                @foreach($activePromotions as $promotion)

                                    <div class="col-md-6">

                                        <div class="promotion-card">

                                            <div class="promotion-title">
                                                {{ $promotion->title }}
                                            </div>

                                            @if($promotion->description)

                                                <div class="promotion-description">
                                                    {{ $promotion->description }}
                                                </div>

                                            @endif

                                            @if($promotion->discount)

                                                <div class="promotion-discount">
                                                    Discount:
                                                    {{ number_format((float) $promotion->discount, 0) }}
                                                </div>

                                            @endif

                                            @if($promotion->start_date || $promotion->end_date)

                                                <div class="small text-muted mt-2">

                                                    @if($promotion->start_date)
                                                        {{ $promotion->start_date->format('d M Y') }}
                                                    @endif

                                                    @if($promotion->start_date && $promotion->end_date)
                                                        —
                                                    @endif

                                                    @if($promotion->end_date)
                                                        {{ $promotion->end_date->format('d M Y') }}
                                                    @endif

                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endif


                {{-- REVIEWS --}}
                <div class="connector-card mb-4">

                    <div class="card-section">

                        <div class="section-heading">

                            <div>
                                <h3 class="section-title">
                                    Ratings & Reviews
                                </h3>

                                <p class="section-description">
                                    Customer feedback associated with this service.
                                </p>
                            </div>

                        </div>


                        <div class="rating-summary">

                            <div class="rating-number">
                                {{ number_format($averageRating, 1) }}
                            </div>

                            <div>

                                <div class="stars">

                                    @for($i = 1; $i <= 5; $i++)

                                        @if($averageRating >= $i)
                                            ★
                                        @elseif($averageRating >= $i - .5)
                                            ★
                                        @else
                                            ☆
                                        @endif

                                    @endfor

                                </div>

                                <div class="rating-meta">
                                    Based on {{ $ratingCount }}
                                    {{ Str::plural('review', $ratingCount) }}
                                </div>

                            </div>

                        </div>


                        @if($ratingCount > 0)

                            @foreach($ratings->take(5) as $rating)

                                <div class="review-item">

                                    <div class="review-header">

                                        <div class="review-user">

                                            {{ $rating->user?->name
                                                ?? $rating->name
                                                ?? 'Customer' }}

                                        </div>

                                        @if($rating->created_at)

                                            <div class="review-date">
                                                {{ $rating->created_at->format('d M Y') }}
                                            </div>

                                        @endif

                                    </div>


                                    @if(isset($rating->rating))

                                        <div class="stars mt-1">

                                            @for($i = 1; $i <= 5; $i++)

                                                {{ $i <= $rating->rating ? '★' : '☆' }}

                                            @endfor

                                        </div>

                                    @endif


                                    @if($rating->comment ?? $rating->review ?? null)

                                        <div class="review-comment">

                                            {{ $rating->comment
                                                ?? $rating->review }}

                                        </div>

                                    @endif

                                </div>

                            @endforeach

                        @else

                            <div class="text-center py-4">

                                <div class="text-muted mb-2">
                                    No reviews yet.
                                </div>

                                <small class="text-muted">
                                    Customer reviews will appear here once submitted.
                                </small>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- MAP --}}
                @if($service->location)

                    <div class="connector-card mb-4">

                        <div class="card-section">

                            <div class="section-heading">

                                <div>
                                    <h3 class="section-title">
                                        Service Location
                                    </h3>

                                    <p class="section-description">
                                        Approximate location associated with this service.
                                    </p>
                                </div>

                            </div>

                            <div class="map-wrapper">

                                <iframe
                                    src="https://maps.google.com/maps?width=600&height=400&hl=en&q={{ urlencode($service->location) }}&t=&z=12&ie=UTF8&iwloc=B&output=embed"
                                    loading="lazy"
                                    allowfullscreen>
                                </iframe>

                            </div>

                        </div>

                    </div>

                @endif

            </div>


            {{-- ======================================================
                 RIGHT COLUMN
            ======================================================= --}}

            <div class="col-xl-4">


                {{-- PRICE --}}
                <div class="connector-card mb-4">

                    <div class="price-card">

                        <div class="price-label">
                            Service Price
                        </div>

                        @if($discount > 0)

                            <div class="original-price">
                                RWF {{ number_format($price, 0) }}
                            </div>

                            <div class="current-price">
                                RWF {{ number_format($total, 0) }}
                            </div>

                            <div class="discount-badge">
                                Save {{ $discountLabel }}
                            </div>

                        @else

                            <div class="current-price">
                                RWF {{ number_format($price, 0) }}
                            </div>

                        @endif

                    </div>

                </div>


                {{-- SERVICE INFORMATION --}}
                <div class="connector-card mb-4">

                    <div class="card-section">

                        <div class="section-heading">

                            <div>
                                <h3 class="section-title">
                                    Service Information
                                </h3>
                            </div>

                        </div>

                        <div class="info-grid">

                            <div class="info-item">

                                <div class="info-label">
                                    Category
                                </div>

                                <div class="info-value">
                                    {{ $service->category?->name ?? '—' }}
                                </div>

                            </div>


                            <div class="info-item">

                                <div class="info-label">
                                    Subcategory
                                </div>

                                <div class="info-value">
                                    {{ $service->subcategory?->name ?? '—' }}
                                </div>

                            </div>


                            <div class="info-item">

                                <div class="info-label">
                                    Duration
                                </div>

                                <div class="info-value">
                                    {{ $service->duration ?: 'Not specified' }}
                                </div>

                            </div>


                            <div class="info-item">

                                <div class="info-label">
                                    Location
                                </div>

                                <div class="info-value">
                                    {{ $service->location ?: 'Not specified' }}
                                </div>

                            </div>


                            <div class="info-item">

                                <div class="info-label">
                                    Discount Type
                                </div>

                                <div class="info-value">

                                    @if($discount > 0)
                                        {{ ucfirst($service->discount_type ?? '—') }}
                                    @else
                                        No discount
                                    @endif

                                </div>

                            </div>


                            <div class="info-item">

                                <div class="info-label">
                                    Service ID
                                </div>

                                <div class="info-value">
                                    #{{ $service->id }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- PROVIDER --}}
                <div class="connector-card mb-4">

                    <div class="card-section">

                        <div class="section-heading">

                            <div>
                                <h3 class="section-title">
                                    Service Provider
                                </h3>
                            </div>
                        </div>


                        <div class="provider-card">

                            <div class="provider-avatar">

                                {{ strtoupper(
                                    collect(explode(' ', $providerName))
                                        ->filter()
                                        ->take(2)
                                        ->map(fn($word) => substr($word, 0, 1))
                                        ->implode('')
                                ) }}

                            </div>

                            <div>

                                <div class="provider-name">
                                    {{ $providerName }}
                                </div>

                                <div class="provider-meta">
                                    Service Provider
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- STATISTICS --}}
                <div class="connector-card mb-4">

                    <div class="card-section">

                        <div class="section-heading">

                            <div>
                                <h3 class="section-title">
                                    Service Overview
                                </h3>
                            </div>
                        </div>


                        <div class="stats-grid">

                            <div class="stat-box">

                                <div class="stat-value">
                                    {{ $bookingCount }}
                                </div>

                                <div class="stat-label">
                                    Bookings
                                </div>

                            </div>


                            <div class="stat-box">

                                <div class="stat-value">
                                    {{ $ratingCount }}
                                </div>

                                <div class="stat-label">
                                    Reviews
                                </div>

                            </div>


                            <div class="stat-box">

                                <div class="stat-value">
                                    {{ $mediaCount }}
                                </div>

                                <div class="stat-label">
                                    Media
                                </div>

                            </div>


                            <div class="stat-box">

                                <div class="stat-value">
                                    {{ $portfolioCount }}
                                </div>

                                <div class="stat-label">
                                    Portfolio
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- STAFF --}}
                @if($staffCount > 0)

                    <div class="connector-card mb-4">

                        <div class="card-section">

                            <div class="section-heading">

                                <div>
                                    <h3 class="section-title">
                                        Service Team
                                    </h3>

                                    <p class="section-description">
                                        Staff assigned to this service.
                                    </p>
                                </div>

                            </div>


                            @foreach($service->staffMembers as $staff)

                                @php
                                    $staffName = $staff->name
                                        ?? $staff->user?->name
                                        ?? 'Staff Member';
                                @endphp

                                <div class="staff-item">

                                    <div class="staff-avatar">

                                        {{ strtoupper(
                                            collect(explode(' ', $staffName))
                                                ->filter()
                                                ->take(2)
                                                ->map(fn($word) => substr($word, 0, 1))
                                                ->implode('')
                                        ) }}

                                    </div>

                                    <div>

                                        <div class="staff-name">
                                            {{ $staffName }}
                                        </div>

                                        @if(isset($staff->position))

                                            <div class="provider-meta">
                                                {{ $staff->position }}
                                            </div>

                                        @endif

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif


                {{-- STATUS --}}
                <div class="connector-card">

                    <div class="card-section">

                        <div class="section-heading">

                            <div>
                                <h3 class="section-title">
                                    Publishing Status
                                </h3>
                            </div>
                        </div>


                        @if($service->status ?? false)

                            <span class="status-badge status-active">

                                <span class="status-dot"></span>

                                Active

                            </span>

                            <p class="text-muted small mt-3 mb-0">
                                This service is currently available on the marketplace.
                            </p>

                        @else

                            <span class="status-badge status-inactive">

                                <span class="status-dot"></span>

                                Inactive

                            </span>

                            <p class="text-muted small mt-3 mb-0">
                                This service is currently not active on the marketplace.
                            </p>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection