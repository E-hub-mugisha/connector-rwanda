@extends('layouts.app')

@section('title', 'Reviews & Ratings')

@section('content')

@php
$providerName = $sprovider->user->name ?? 'Service Provider';

$averageRating = (float) ($stats['average'] ?? 0);

$ratingCounts = [
5 => $stats['five_star'] ?? 0,
4 => $stats['four_star'] ?? 0,
3 => $stats['three_star'] ?? 0,
2 => $stats['two_star'] ?? 0,
1 => $stats['one_star'] ?? 0,
];

$totalRatings = $stats['total'] ?? 0;

$getPercentage = function ($count) use ($totalRatings) {
return $totalRatings > 0
? round(($count / $totalRatings) * 100)
: 0;
};
@endphp

<div class="content-wrapper">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="review-hero mb-4">

        <div class="review-hero-content">

            <div>
                <div class="hero-label">
                    <i class="mdi mdi-star-circle"></i>
                    Customer Experience
                </div>

                <h2>
                    Reviews & Ratings
                </h2>

                <p>
                    See what customers are saying about
                    <strong>{{ $providerName }}</strong>.
                </p>
            </div>

            <div class="hero-rating">
                <div class="hero-rating-number">
                    {{ number_format($averageRating, 1) }}
                </div>

                <div class="hero-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="mdi mdi-star
                            {{ $i <= round($averageRating) ? 'active' : '' }}">
                        </i>
                        @endfor
                </div>

                <span>
                    {{ $totalRatings }}
                    {{ Str::plural('review', $totalRatings) }}
                </span>
            </div>

        </div>

    </div>


    {{-- =========================================================
        SUMMARY CARDS
    ========================================================== --}}
    <div class="row g-3 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="mdi mdi-star"></i>
                </div>

                <div>
                    <div class="stat-label">
                        Average Rating
                    </div>

                    <div class="stat-value">
                        {{ number_format($averageRating, 1) }}
                        <small>/ 5</small>
                    </div>
                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="mdi mdi-comment-multiple-outline"></i>
                </div>

                <div>
                    <div class="stat-label">
                        Total Reviews
                    </div>

                    <div class="stat-value">
                        {{ number_format($totalRatings) }}
                    </div>
                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="mdi mdi-star-check"></i>
                </div>

                <div>
                    <div class="stat-label">
                        5 Star Reviews
                    </div>

                    <div class="stat-value">
                        {{ number_format($ratingCounts[5]) }}
                    </div>
                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="mdi mdi-account-check-outline"></i>
                </div>

                <div>
                    <div class="stat-label">
                        Approved Reviews
                    </div>

                    <div class="stat-value">
                        {{ number_format($totalRatings) }}
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        RATING DISTRIBUTION
    ========================================================== --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-5">

            <div class="dashboard-card h-100">

                <div class="card-header-custom">

                    <div>
                        <h5>Rating Overview</h5>
                        <p>Customer rating distribution</p>
                    </div>

                    <div class="overview-icon">
                        <i class="mdi mdi-chart-bar"></i>
                    </div>

                </div>


                <div class="rating-overview">

                    @foreach($ratingCounts as $star => $count)

                    @php
                    $percentage = $getPercentage($count);
                    @endphp

                    <div class="rating-row">

                        <div class="rating-label">
                            <span>{{ $star }}</span>
                            <i class="mdi mdi-star"></i>
                        </div>

                        <div class="rating-progress">

                            <div
                                class="rating-progress-bar"
                                style="width: {{ $percentage }}%;">
                            </div>

                        </div>

                        <div class="rating-count">
                            {{ $count }}
                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>


        {{-- =====================================================
            OVERALL SCORE
        ====================================================== --}}
        <div class="col-xl-7">

            <div class="dashboard-card h-100 score-card">

                <div class="score-content">

                    <div class="score-circle">

                        <span>
                            {{ number_format($averageRating, 1) }}
                        </span>

                        <small>/5</small>

                    </div>

                    <div class="score-details">

                        <h4>
                            Overall Customer Rating
                        </h4>

                        <div class="large-stars">

                            @for($i = 1; $i <= 5; $i++)

                                <i class="mdi mdi-star
                                    {{ $i <= round($averageRating) ? 'active' : '' }}">
                                </i>

                                @endfor

                        </div>

                        <p>
                            Based on
                            <strong>{{ $totalRatings }}</strong>
                            approved
                            {{ Str::plural('review', $totalRatings) }}
                            from your customers.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        REVIEWS
    ========================================================== --}}
    <div class="dashboard-card">

        <div class="card-header-custom">

            <div>
                <h5>Customer Reviews</h5>
                <p>
                    Feedback and ratings from your customers
                </p>
            </div>

            <div class="review-count-badge">
                {{ $totalRatings }}
                {{ Str::plural('review', $totalRatings) }}
            </div>

        </div>


        @if($ratings->count())

        <div class="reviews-list">

            @foreach($ratings as $rating)

            @php
            $customerName = trim(
            $rating->user->name ?? 'Customer'
            );

            $initials = collect(
            preg_split('/\s+/', $customerName)
            )
            ->filter()
            ->take(2)
            ->map(function ($name) {
            return strtoupper(substr($name, 0, 1));
            })
            ->implode('');

            $ratingValue = (int) ($rating->rating ?? 0);
            @endphp

            <div class="review-item">

                {{-- Customer Avatar --}}
                <div class="customer-avatar">
                    {{ $initials ?: 'C' }}
                </div>

                <div class="review-content">

                    <div class="review-top">

                        <div>

                            <h6>
                                {{ $customerName }}
                            </h6>

                            <div class="review-date">

                                <i class="mdi mdi-calendar-outline"></i>

                                {{ optional($rating->created_at)->format('M d, Y') }}

                                @if($rating->created_at)
                                <span class="dot">•</span>
                                {{ $rating->created_at->diffForHumans() }}
                                @endif

                            </div>

                        </div>

                        <span class="approved-badge">
                            <i class="mdi mdi-check-circle"></i>
                            Approved
                        </span>

                    </div>


                    {{-- Rating --}}
                    <div class="review-stars">

                        @for($i = 1; $i <= 5; $i++)

                            <i class="mdi mdi-star
                        {{ $i <= $ratingValue ? 'active' : '' }}">
                            </i>

                            @endfor

                            <span class="rating-number">
                                {{ $ratingValue }}.0
                            </span>

                    </div>


                    {{-- Comment --}}
                    @if(!empty($rating->comment))

                    <div class="review-message">

                        <i class="mdi mdi-format-quote-open"></i>

                        <p>
                            {{ $rating->comment }}
                        </p>

                    </div>

                    @else

                    <div class="no-message">
                        Customer left a rating without a written comment.
                    </div>

                    @endif

                </div>

            </div>

            @endforeach

        </div>


        {{-- Pagination --}}
        @if($ratings->hasPages())

        <div class="pagination-wrapper">

            <div class="pagination-info">

                Showing
                <strong>{{ $ratings->firstItem() }}</strong>
                –
                <strong>{{ $ratings->lastItem() }}</strong>
                of
                <strong>{{ $ratings->total() }}</strong>

            </div>

            <div>
                {{ $ratings->links() }}
            </div>

        </div>

        @endif


        @else

        {{-- Empty State --}}
        <div class="empty-state">

            <div class="empty-icon">
                <i class="mdi mdi-star-outline"></i>
            </div>

            <h4>
                No reviews yet
            </h4>

            <p>
                Your approved customer ratings will appear here
                once customers start reviewing your services.
            </p>

        </div>

        @endif

    </div>

</div>


{{-- =============================================================
    STYLES
============================================================= --}}
<style>
    :root {
        --connector-primary: #6B9080;
        --connector-dark: #254035;
        --connector-light: #edf4f1;
        --connector-border: #e5ebe8;
        --connector-text: #24332d;
        --connector-muted: #7b8782;
    }


    /* -------------------------------------------------------------
   HERO
------------------------------------------------------------- */

    .review-hero {
        background: linear-gradient(135deg,
                var(--connector-dark),
                var(--connector-primary));

        border-radius: 18px;
        padding: 30px;
        color: #fff;
        overflow: hidden;
        position: relative;
    }

    .review-hero::after {
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        border: 35px solid rgba(255, 255, 255, .08);
        right: -70px;
        top: -80px;
    }

    .review-hero-content {
        position: relative;
        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 30px;
    }

    .hero-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;

        background: rgba(255, 255, 255, .12);
        padding: 7px 13px;
        border-radius: 30px;

        font-size: 12px;
        font-weight: 600;

        margin-bottom: 12px;
    }

    .review-hero h2 {
        color: #fff;
        margin: 0 0 8px;
        font-size: 28px;
        font-weight: 700;
    }

    .review-hero p {
        margin: 0;
        color: rgba(255, 255, 255, .78);
    }

    .hero-rating {
        min-width: 160px;
        text-align: center;
    }

    .hero-rating-number {
        font-size: 42px;
        line-height: 1;
        font-weight: 800;
    }

    .hero-stars {
        margin: 7px 0;
    }

    .hero-stars i {
        font-size: 19px;
        color: rgba(255, 255, 255, .35);
    }

    .hero-stars i.active {
        color: #fff;
    }

    .hero-rating span {
        font-size: 12px;
        color: rgba(255, 255, 255, .75);
    }


    /* -------------------------------------------------------------
   STAT CARDS
------------------------------------------------------------- */

    .stat-card {
        background: #fff;
        border: 1px solid var(--connector-border);

        border-radius: 14px;
        padding: 20px;

        display: flex;
        align-items: center;
        gap: 15px;

        height: 100%;

        transition: .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 64, 53, .08);
    }

    .stat-icon {
        width: 48px;
        height: 48px;

        border-radius: 12px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: var(--connector-light);
        color: var(--connector-primary);

        font-size: 23px;
    }

    .stat-label {
        color: var(--connector-muted);
        font-size: 12px;
        margin-bottom: 4px;
    }

    .stat-value {
        color: var(--connector-dark);
        font-size: 23px;
        font-weight: 700;
    }

    .stat-value small {
        font-size: 12px;
        color: var(--connector-muted);
        font-weight: 500;
    }


    /* -------------------------------------------------------------
   DASHBOARD CARD
------------------------------------------------------------- */

    .dashboard-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 16px;
        overflow: hidden;
    }

    .card-header-custom {
        padding: 20px 22px;

        border-bottom: 1px solid var(--connector-border);

        display: flex;
        justify-content: space-between;
        align-items: center;

        gap: 15px;
    }

    .card-header-custom h5 {
        margin: 0;
        color: var(--connector-dark);
        font-size: 16px;
        font-weight: 700;
    }

    .card-header-custom p {
        margin: 4px 0 0;
        color: var(--connector-muted);
        font-size: 12px;
    }

    .overview-icon {
        width: 40px;
        height: 40px;

        border-radius: 10px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: var(--connector-light);
        color: var(--connector-primary);

        font-size: 19px;
    }


    /* -------------------------------------------------------------
   RATING DISTRIBUTION
------------------------------------------------------------- */

    .rating-overview {
        padding: 22px;
    }

    .rating-row {
        display: grid;

        grid-template-columns: 42px 1fr 40px;

        align-items: center;

        gap: 10px;

        margin-bottom: 15px;
    }

    .rating-row:last-child {
        margin-bottom: 0;
    }

    .rating-label {
        display: flex;
        align-items: center;
        gap: 3px;

        color: var(--connector-dark);
        font-size: 13px;
        font-weight: 600;
    }

    .rating-label i {
        color: #e5a82d;
        font-size: 15px;
    }

    .rating-progress {
        height: 8px;

        background: #edf0ef;

        border-radius: 20px;

        overflow: hidden;
    }

    .rating-progress-bar {
        height: 100%;

        background: var(--connector-primary);

        border-radius: inherit;

        transition: width .3s ease;
    }

    .rating-count {
        color: var(--connector-muted);
        text-align: right;
        font-size: 12px;
    }


    /* -------------------------------------------------------------
   SCORE
------------------------------------------------------------- */

    .score-card {
        display: flex;
        align-items: center;
    }

    .score-content {
        padding: 25px;

        display: flex;
        align-items: center;

        gap: 30px;
    }

    .score-circle {
        width: 125px;
        height: 125px;

        flex: 0 0 125px;

        border-radius: 50%;

        background: var(--connector-light);

        border: 9px solid rgba(107, 144, 128, .18);

        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;

        color: var(--connector-dark);
    }

    .score-circle span {
        font-size: 32px;
        line-height: 1;
        font-weight: 800;
    }

    .score-circle small {
        color: var(--connector-muted);
        margin-top: 3px;
    }

    .score-details h4 {
        margin: 0 0 10px;
        color: var(--connector-dark);
        font-size: 19px;
        font-weight: 700;
    }

    .large-stars {
        margin-bottom: 10px;
    }

    .large-stars i {
        color: #dfe4e1;
        font-size: 22px;
    }

    .large-stars i.active {
        color: #e5a82d;
    }

    .score-details p {
        color: var(--connector-muted);
        font-size: 13px;
        margin: 0;
    }


    /* -------------------------------------------------------------
   REVIEWS
------------------------------------------------------------- */

    .review-count-badge {
        background: var(--connector-light);
        color: var(--connector-dark);

        padding: 7px 12px;

        border-radius: 20px;

        font-size: 12px;
        font-weight: 600;
    }

    .reviews-list {
        padding: 0 22px;
    }

    .review-item {
        display: flex;
        gap: 16px;

        padding: 24px 0;

        border-bottom: 1px solid var(--connector-border);
    }

    .review-item:last-child {
        border-bottom: 0;
    }

    .customer-avatar {
        width: 46px;
        height: 46px;

        flex: 0 0 46px;

        border-radius: 50%;

        background: var(--connector-dark);
        color: #fff;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 13px;
        font-weight: 700;
    }

    .review-content {
        flex: 1;
        min-width: 0;
    }

    .review-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;

        gap: 15px;
    }

    .review-top h6 {
        margin: 0 0 4px;

        color: var(--connector-dark);

        font-size: 14px;
        font-weight: 700;
    }

    .review-date {
        color: var(--connector-muted);
        font-size: 11px;

        display: flex;
        align-items: center;
        gap: 4px;
    }

    .dot {
        margin: 0 3px;
    }

    .approved-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;

        background: #edf7f1;
        color: #34845c;

        border-radius: 20px;

        padding: 5px 9px;

        font-size: 10px;
        font-weight: 600;

        white-space: nowrap;
    }

    .review-stars {
        margin: 9px 0;
    }

    .review-stars i {
        color: #dfe4e1;
        font-size: 17px;
    }

    .review-stars i.active {
        color: #e5a82d;
    }

    .rating-number {
        color: var(--connector-muted);
        font-size: 11px;
        margin-left: 5px;
    }

    .review-message {
        background: #f7f9f8;

        border-radius: 10px;

        padding: 12px 14px;

        display: flex;
        gap: 8px;
    }

    .review-message i {
        color: var(--connector-primary);
        font-size: 19px;
    }

    .review-message p {
        color: #58645f;

        margin: 0;

        font-size: 13px;
        line-height: 1.7;
    }

    .no-message {
        color: var(--connector-muted);
        font-size: 12px;
        font-style: italic;
    }


    /* -------------------------------------------------------------
   PAGINATION
------------------------------------------------------------- */

    .pagination-wrapper {
        border-top: 1px solid var(--connector-border);

        padding: 18px 22px;

        display: flex;
        justify-content: space-between;
        align-items: center;

        gap: 15px;
    }

    .pagination-info {
        color: var(--connector-muted);
        font-size: 12px;
    }

    .pagination {
        margin: 0;
    }


    /* -------------------------------------------------------------
   EMPTY STATE
------------------------------------------------------------- */

    .empty-state {
        text-align: center;
        padding: 70px 25px;
    }

    .empty-icon {
        width: 70px;
        height: 70px;

        margin: 0 auto 18px;

        border-radius: 50%;

        background: var(--connector-light);
        color: var(--connector-primary);

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 34px;
    }

    .empty-state h4 {
        color: var(--connector-dark);
        font-size: 18px;
        font-weight: 700;
    }

    .empty-state p {
        color: var(--connector-muted);

        max-width: 480px;

        margin: 0 auto;

        font-size: 13px;
        line-height: 1.7;
    }


    /* -------------------------------------------------------------
   RESPONSIVE
------------------------------------------------------------- */

    @media (max-width: 767px) {

        .review-hero {
            padding: 22px;
        }

        .review-hero-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .hero-rating {
            text-align: left;
        }

        .review-hero h2 {
            font-size: 23px;
        }

        .score-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .review-top {
            flex-direction: column;
        }

        .pagination-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }

    }
</style>

@endsection