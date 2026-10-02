@extends('layouts.app')

@section('title', 'Service Provider Profile')

@section('content')

<style>
    :root {
        --connector-primary: #254035;
        --connector-accent: #6B9080;
        --connector-light: #eef4f1;
        --connector-bg: #f6f8f7;
        --connector-border: #e3ebe7;
        --connector-muted: #71807a;
        --connector-success: #2f855a;
        --connector-warning: #c98a16;
        --connector-danger: #c0392b;
    }

    .provider-profile-page {
        background: var(--connector-bg);
        min-height: calc(100vh - 70px);
        padding: 28px 0 50px;
    }

    .profile-container {
        max-width: 1400px;
    }

    /* Header */

    .profile-header {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 8px 30px rgba(37, 64, 53, .06);
    }

    .profile-cover {
        height: 145px;
        background:
            linear-gradient(135deg,
                rgba(37, 64, 53, .98),
                rgba(107, 144, 128, .92));
        position: relative;
    }

    .profile-cover::after {
        content: "";
        position: absolute;
        inset: 0;
        opacity: .15;
        background-image:
            radial-gradient(circle at 20% 30%, #fff 1px, transparent 1px),
            radial-gradient(circle at 80% 70%, #fff 1px, transparent 1px);
        background-size: 28px 28px;
    }

    .profile-header-content {
        padding: 0 32px 28px;
    }

    .profile-main {
        display: flex;
        align-items: flex-end;
        gap: 24px;
        margin-top: -55px;
        position: relative;
        z-index: 2;
    }

    .provider-avatar {
        width: 120px;
        height: 120px;
        border-radius: 22px;
        object-fit: cover;
        border: 5px solid #fff;
        background: #fff;
        box-shadow: 0 8px 25px rgba(0, 0, 0, .12);
    }

    .provider-heading {
        padding-bottom: 4px;
        flex: 1;
    }

    .provider-heading h1 {
        color: var(--connector-primary);
        font-size: 27px;
        font-weight: 700;
        margin: 0 0 7px;
    }

    .provider-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 18px;
        color: var(--connector-muted);
        font-size: 14px;
    }

    .provider-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .provider-meta i {
        color: var(--connector-accent);
        font-size: 17px;
    }

    .profile-actions {
        display: flex;
        gap: 8px;
        padding-bottom: 5px;
    }

    .btn-connector {
        background: var(--connector-primary);
        color: #fff;
        border: 0;
        border-radius: 10px;
        padding: 10px 16px;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-connector:hover {
        background: #1b3028;
        color: #fff;
    }

    .btn-soft {
        background: var(--connector-light);
        color: var(--connector-primary);
        border: 1px solid transparent;
        border-radius: 10px;
        padding: 10px 16px;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-soft:hover {
        background: #dfeae5;
        color: var(--connector-primary);
    }

    /* Status */

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 11px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        text-transform: capitalize;
    }

    .status-pill.approved {
        background: #e8f6ee;
        color: var(--connector-success);
    }

    .status-pill.pending {
        background: #fff5df;
        color: var(--connector-warning);
    }

    .status-pill.rejected {
        background: #fcebea;
        color: var(--connector-danger);
    }

    /* Statistics */

    .profile-stats {
        margin-top: 24px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 15px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .stat-icon {
        width: 43px;
        height: 43px;
        border-radius: 12px;
        background: var(--connector-light);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-label {
        color: var(--connector-muted);
        font-size: 12px;
        margin-bottom: 2px;
    }

    .stat-value {
        color: var(--connector-primary);
        font-size: 19px;
        font-weight: 700;
    }

    /* Main content */

    .profile-grid {
        margin-top: 24px;
    }

    .profile-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        box-shadow: 0 6px 24px rgba(37, 64, 53, .04);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .card-heading {
        padding: 19px 22px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .card-heading h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: var(--connector-primary);
    }

    .card-heading p {
        margin: 4px 0 0;
        color: var(--connector-muted);
        font-size: 12px;
    }

    .card-heading-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--connector-light);
        color: var(--connector-primary);
        font-size: 19px;
    }

    .card-body-custom {
        padding: 22px;
    }

    /* About */

    .about-text {
        color: #4f5f59;
        font-size: 14px;
        line-height: 1.8;
        margin: 0;
    }

    /* Information */

    .info-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        padding: 13px 0;
        border-bottom: 1px solid #edf1ef;
    }

    .info-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .info-label {
        color: var(--connector-muted);
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-label i {
        color: var(--connector-accent);
        font-size: 17px;
    }

    .info-value {
        color: var(--connector-primary);
        font-size: 13px;
        font-weight: 600;
        text-align: right;
        max-width: 60%;
    }

    /* Tags */

    .skill-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .skill-tag {
        background: var(--connector-light);
        color: var(--connector-primary);
        border-radius: 8px;
        padding: 7px 11px;
        font-size: 12px;
        font-weight: 600;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--connector-light);
        color: var(--connector-primary);
        padding: 7px 11px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Services */

    .service-item {
        border: 1px solid var(--connector-border);
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 10px;
        transition: .2s ease;
    }

    .service-item:last-child {
        margin-bottom: 0;
    }

    .service-item:hover {
        border-color: var(--connector-accent);
        transform: translateY(-1px);
    }

    .service-name {
        color: var(--connector-primary);
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 3px;
    }

    .service-meta {
        color: var(--connector-muted);
        font-size: 12px;
    }

    /* Rating */

    .rating-summary {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 18px;
        background: var(--connector-light);
        border-radius: 13px;
        margin-bottom: 18px;
    }

    .rating-number {
        color: var(--connector-primary);
        font-size: 34px;
        line-height: 1;
        font-weight: 800;
    }

    .rating-stars {
        color: #e4a72c;
        font-size: 15px;
        letter-spacing: 2px;
    }

    .rating-count {
        color: var(--connector-muted);
        font-size: 12px;
        margin-top: 4px;
    }

    .review-item {
        padding: 16px 0;
        border-bottom: 1px solid #edf1ef;
    }

    .review-item:first-child {
        padding-top: 0;
    }

    .review-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .review-rating {
        color: #e4a72c;
        font-size: 12px;
        margin-bottom: 6px;
    }

    .review-comment {
        color: #4f5f59;
        font-size: 13px;
        line-height: 1.6;
        margin: 0;
    }

    /* Map */

    .map-wrapper {
        border-radius: 13px;
        overflow: hidden;
        border: 1px solid var(--connector-border);
    }

    .map-wrapper iframe {
        width: 100%;
        height: 280px;
        border: 0;
        display: block;
    }

    /* Empty */

    .empty-state {
        text-align: center;
        padding: 28px 15px;
        color: var(--connector-muted);
    }

    .empty-state i {
        font-size: 30px;
        margin-bottom: 10px;
        color: var(--connector-accent);
    }

    .empty-state p {
        margin: 0;
        font-size: 13px;
    }

    /* Responsive */

    @media (max-width: 991px) {

        .profile-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .profile-main {
            align-items: flex-start;
            flex-direction: column;
            margin-top: -45px;
        }

        .profile-actions {
            padding-bottom: 0;
        }
    }

    @media (max-width: 575px) {

        .provider-profile-page {
            padding: 15px 0 35px;
        }

        .profile-header-content {
            padding: 0 18px 22px;
        }

        .profile-cover {
            height: 115px;
        }

        .provider-avatar {
            width: 95px;
            height: 95px;
            border-radius: 18px;
        }

        .provider-heading h1 {
            font-size: 22px;
        }

        .profile-stats {
            grid-template-columns: 1fr 1fr;
            gap: 9px;
        }

        .stat-card {
            padding: 13px;
        }

        .stat-icon {
            width: 37px;
            height: 37px;
            font-size: 17px;
        }

        .stat-value {
            font-size: 16px;
        }

        .profile-actions {
            width: 100%;
        }

        .profile-actions .btn {
            flex: 1;
        }

        .info-row {
            flex-direction: column;
            gap: 5px;
        }

        .info-value {
            max-width: 100%;
            text-align: left;
        }
    }
</style>



<div class="provider-profile-page">

    <div class="container-fluid profile-container">

        {{-- Back --}}
        <div class="mb-3">
            <a href="{{ route('admin.service_providers') }}"
                class="btn btn-soft">
                <i class="mdi mdi-arrow-left me-1"></i>
                Back to Providers
            </a>

            <a
                href="{{ route('admin.EditServiceProvider', $UserProvide->id) }}"
                class="btn btn-sm"
                style="
        background:#254035;
        color:#fff;
        border-radius:9px;
        padding:9px 15px;
        font-weight:600;
    ">
                <i class="mdi mdi-pencil-outline me-1"></i>
                Edit Provider
            </a>
        </div>


        {{-- =========================================================
            PROFILE HEADER
        ========================================================== --}}

        <div class="profile-header">

            <div class="profile-cover"></div>

            <div class="profile-header-content">

                <div class="profile-main">

                    {{-- Avatar --}}
                    <img
                        src="{{ $UserProvide->image
                            ? asset('image/profile/' . $UserProvide->image)
                            : asset('assets/images/sproviders/avatar.jpg') }}"
                        alt="{{ $UserProvide->user?->name ?? 'Service Provider' }}"
                        class="provider-avatar">

                    {{-- Main information --}}
                    <div class="provider-heading">

                        <div class="d-flex flex-wrap align-items-center gap-2 mb-1">

                            <h1>
                                {{ $UserProvide->user?->name ?? 'Unknown Provider' }}
                            </h1>

                            <span class="status-pill {{ $UserProvide->status }}">
                                <i class="mdi mdi-circle-small"></i>
                                {{ ucfirst($UserProvide->status) }}
                            </span>

                        </div>

                        <div class="provider-meta">

                            @if($UserProvide->category)
                            <span>
                                <i class="mdi mdi-briefcase-outline"></i>
                                {{ $UserProvide->category->name }}
                            </span>
                            @endif

                            @if($UserProvide->service_locations)
                            <span>
                                <i class="mdi mdi-map-marker-outline"></i>
                                {{ $UserProvide->service_locations }}
                            </span>
                            @endif

                            @if($UserProvide->user?->email)
                            <span>
                                <i class="mdi mdi-email-outline"></i>
                                {{ $UserProvide->user->email }}
                            </span>
                            @endif

                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="profile-actions">

                        <a href="{{ route('admin.service_providers') }}"
                            class="btn btn-soft">
                            <i class="mdi mdi-view-list-outline me-1"></i>
                            Providers
                        </a>

                    </div>

                </div>


                {{-- Statistics --}}
                <div class="profile-stats">

                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="mdi mdi-briefcase-outline"></i>
                        </div>

                        <div>
                            <div class="stat-label">Services</div>
                            <div class="stat-value">
                                {{ $UserProvide->services_count ?? $services->count() }}
                            </div>
                        </div>
                    </div>


                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="mdi mdi-star-outline"></i>
                        </div>

                        <div>
                            <div class="stat-label">Reviews</div>
                            <div class="stat-value">
                                {{ $UserProvide->ratings_count ?? $reviews->count() }}
                            </div>
                        </div>
                    </div>


                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="mdi mdi-account-group-outline"></i>
                        </div>

                        <div>
                            <div class="stat-label">Staff</div>
                            <div class="stat-value">
                                {{ $UserProvide->staff_members_count ?? 0 }}
                            </div>
                        </div>
                    </div>


                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="mdi mdi-clock-outline"></i>
                        </div>

                        <div>
                            <div class="stat-label">Working Hours</div>
                            <div class="stat-value">
                                {{ $UserProvide->working_hours_count ?? 0 }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>


        {{-- =========================================================
            MAIN PROFILE
        ========================================================== --}}

        <div class="row profile-grid">

            {{-- =====================================================
                LEFT COLUMN
            ====================================================== --}}

            <div class="col-xl-8">

                {{-- About --}}
                <div class="profile-card">

                    <div class="card-heading">

                        <div>
                            <h3>About Provider</h3>
                            <p>Professional overview and background</p>
                        </div>

                        <div class="card-heading-icon">
                            <i class="mdi mdi-account-outline"></i>
                        </div>

                    </div>

                    <div class="card-body-custom">

                        @if($UserProvide->about)
                        <p class="about-text">
                            {!! nl2br(e($UserProvide->about)) !!}
                        </p>
                        @else
                        <div class="empty-state">
                            <i class="mdi mdi-information-outline"></i>
                            <p>No professional description has been provided.</p>
                        </div>
                        @endif

                    </div>

                </div>


                {{-- Services --}}
                <div class="profile-card">

                    <div class="card-heading">

                        <div>
                            <h3>Services Offered</h3>
                            <p>Services currently listed by this provider</p>
                        </div>

                        <span class="category-badge">
                            <i class="mdi mdi-briefcase-outline"></i>
                            {{ $services->count() }} Services
                        </span>

                    </div>

                    <div class="card-body-custom">

                        @if($services->isNotEmpty())

                        <div class="row g-3">

                            @foreach($services as $service)

                            <div class="col-md-6">

                                <div class="service-item">

                                    <div class="d-flex align-items-start gap-2">

                                        <div class="card-heading-icon flex-shrink-0"
                                            style="width:34px;height:34px;font-size:16px;">
                                            <i class="mdi mdi-briefcase-outline"></i>
                                        </div>

                                        <div>
                                            <div class="service-name">
                                                {{ $service->name }}
                                            </div>

                                            @if(isset($service->description) && $service->description)
                                            <div class="service-meta">
                                                {{ \Illuminate\Support\Str::limit($service->description, 90) }}
                                            </div>
                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                            @endforeach

                        </div>

                        @else

                        <div class="empty-state">
                            <i class="mdi mdi-briefcase-remove-outline"></i>
                            <p>No services have been added by this provider.</p>
                        </div>

                        @endif

                    </div>

                </div>


                {{-- Skills --}}
                <div class="profile-card">

                    <div class="card-heading">

                        <div>
                            <h3>Skills & Expertise</h3>
                            <p>Professional skills provided by the service provider</p>
                        </div>

                        <div class="card-heading-icon">
                            <i class="mdi mdi-lightbulb-outline"></i>
                        </div>

                    </div>

                    <div class="card-body-custom">

                        @if($UserProvide->skills)

                        <div class="skill-list">

                            @foreach(
                            preg_split(
                            '/[,;\n]+/',
                            $UserProvide->skills,
                            -1,
                            PREG_SPLIT_NO_EMPTY
                            )
                            as $skill
                            )

                            <span class="skill-tag">
                                {{ trim($skill) }}
                            </span>

                            @endforeach

                        </div>

                        @else

                        <div class="empty-state">
                            <i class="mdi mdi-lightbulb-off-outline"></i>
                            <p>No skills have been provided.</p>
                        </div>

                        @endif

                    </div>

                </div>


                {{-- Qualification & Experience --}}
                <div class="row">

                    <div class="col-md-6">

                        <div class="profile-card h-100">

                            <div class="card-heading">

                                <div>
                                    <h3>Qualification</h3>
                                    <p>Education and certifications</p>
                                </div>

                                <div class="card-heading-icon">
                                    <i class="mdi mdi-school-outline"></i>
                                </div>

                            </div>

                            <div class="card-body-custom">

                                @if($UserProvide->qualification)

                                <p class="about-text">
                                    {!! nl2br(e($UserProvide->qualification)) !!}
                                </p>

                                @else

                                <div class="empty-state">
                                    <i class="mdi mdi-school-outline"></i>
                                    <p>No qualification information provided.</p>
                                </div>

                                @endif

                            </div>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="profile-card h-100">

                            <div class="card-heading">

                                <div>
                                    <h3>Experience</h3>
                                    <p>Professional background</p>
                                </div>

                                <div class="card-heading-icon">
                                    <i class="mdi mdi-chart-line"></i>
                                </div>

                            </div>

                            <div class="card-body-custom">

                                @if($UserProvide->experience)

                                <p class="about-text">
                                    {!! nl2br(e($UserProvide->experience)) !!}
                                </p>

                                @else

                                <div class="empty-state">
                                    <i class="mdi mdi-briefcase-clock-outline"></i>
                                    <p>No experience information provided.</p>
                                </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Reviews --}}
                <div class="profile-card">

                    <div class="card-heading">

                        <div>
                            <h3>Customer Reviews</h3>
                            <p>Feedback and ratings received</p>
                        </div>

                        <div class="card-heading-icon">
                            <i class="mdi mdi-star-outline"></i>
                        </div>

                    </div>

                    <div class="card-body-custom">

                        @if($reviews->isNotEmpty())

                        @php
                        $averageRating = round(
                        (float) ($UserProvide->ratings_avg_rating ?? 0),
                        1
                        );
                        @endphp

                        <div class="rating-summary">

                            <div class="rating-number">
                                {{ number_format($averageRating, 1) }}
                            </div>

                            <div>

                                <div class="rating-stars">

                                    @for($i = 1; $i <= 5; $i++)

                                        @if($i <=round($averageRating))
                                        <i class="mdi mdi-star"></i>
                                        @else
                                        <i class="mdi mdi-star-outline"></i>
                                        @endif

                                        @endfor

                                </div>

                                <div class="rating-count">
                                    Based on {{ $reviews->count() }} review{{ $reviews->count() === 1 ? '' : 's' }}
                                </div>

                            </div>

                        </div>


                        @foreach($reviews as $review)

                        <div class="review-item">

                            <div class="review-rating">

                                @for($i = 1; $i <= 5; $i++)

                                    @if($i <=(int) $review->rating)
                                    <i class="mdi mdi-star"></i>
                                    @else
                                    <i class="mdi mdi-star-outline"></i>
                                    @endif

                                    @endfor

                            </div>

                            <p class="review-comment">
                                {{ $review->comment ?? 'No comment provided.' }}
                            </p>

                        </div>

                        @endforeach

                        @else

                        <div class="empty-state">
                            <i class="mdi mdi-star-off-outline"></i>
                            <p>No reviews have been submitted for this provider.</p>
                        </div>

                        @endif

                    </div>

                </div>

            </div>


            {{-- =====================================================
                RIGHT COLUMN
            ====================================================== --}}

            <div class="col-xl-4">

                {{-- Provider Information --}}
                <div class="profile-card">

                    <div class="card-heading">

                        <div>
                            <h3>Provider Information</h3>
                            <p>Account and service details</p>
                        </div>

                        <div class="card-heading-icon">
                            <i class="mdi mdi-information-outline"></i>
                        </div>

                    </div>

                    <div class="card-body-custom">

                        <div class="info-row">

                            <div class="info-label">
                                <i class="mdi mdi-account-outline"></i>
                                Provider
                            </div>

                            <div class="info-value">
                                {{ $UserProvide->user?->name ?? 'N/A' }}
                            </div>

                        </div>


                        <div class="info-row">

                            <div class="info-label">
                                <i class="mdi mdi-email-outline"></i>
                                Email
                            </div>

                            <div class="info-value text-break">
                                {{ $UserProvide->user?->email ?? 'N/A' }}
                            </div>

                        </div>


                        <div class="info-row">

                            <div class="info-label">
                                <i class="mdi mdi-tag-outline"></i>
                                Category
                            </div>

                            <div class="info-value">

                                @if($UserProvide->category)

                                <span class="category-badge">
                                    {{ $UserProvide->category->name }}
                                </span>

                                @else
                                N/A
                                @endif

                            </div>

                        </div>


                        <div class="info-row">

                            <div class="info-label">
                                <i class="mdi mdi-map-marker-outline"></i>
                                Location
                            </div>

                            <div class="info-value">
                                {{ $UserProvide->service_locations ?? 'Not provided' }}
                            </div>

                        </div>


                        <div class="info-row">

                            <div class="info-label">
                                <i class="mdi mdi-check-circle-outline"></i>
                                Status
                            </div>

                            <div class="info-value">

                                <span class="status-pill {{ $UserProvide->status }}">
                                    <i class="mdi mdi-circle-small"></i>
                                    {{ ucfirst($UserProvide->status) }}
                                </span>

                            </div>

                        </div>


                        <div class="info-row">

                            <div class="info-label">
                                <i class="mdi mdi-calendar-outline"></i>
                                Joined
                            </div>

                            <div class="info-value">
                                {{ optional($UserProvide->created_at)->format('d M Y') }}
                            </div>

                        </div>


                        <div class="info-row">

                            <div class="info-label">
                                <i class="mdi mdi-account-key-outline"></i>
                                Account Type
                            </div>

                            <div class="info-value">
                                {{ $UserProvide->user?->utype ?? 'N/A' }}
                            </div>

                        </div>

                    </div>

                </div>


                {{-- Location --}}
                <div class="profile-card">

                    <div class="card-heading">

                        <div>
                            <h3>Service Location</h3>
                            <p>Provider's operating area</p>
                        </div>

                        <div class="card-heading-icon">
                            <i class="mdi mdi-map-marker-outline"></i>
                        </div>

                    </div>

                    <div class="card-body-custom">

                        @if($UserProvide->service_locations)

                        <div class="mb-3">

                            <span class="category-badge">
                                <i class="mdi mdi-map-marker"></i>
                                {{ $UserProvide->service_locations }}
                            </span>

                        </div>

                        <div class="map-wrapper">

                            <iframe
                                src="https://maps.google.com/maps?q={{ urlencode($UserProvide->service_locations) }}&t=&z=12&ie=UTF8&iwloc=B&output=embed"
                                loading="lazy"
                                allowfullscreen>
                            </iframe>

                        </div>

                        @else

                        <div class="empty-state">
                            <i class="mdi mdi-map-marker-off-outline"></i>
                            <p>No service location has been provided.</p>
                        </div>

                        @endif

                    </div>

                </div>


                {{-- Staff --}}
                <div class="profile-card">

                    <div class="card-heading">

                        <div>
                            <h3>Team & Staff</h3>
                            <p>People associated with this provider</p>
                        </div>

                        <div class="card-heading-icon">
                            <i class="mdi mdi-account-group-outline"></i>
                        </div>

                    </div>

                    <div class="card-body-custom">

                        <div class="d-flex align-items-center gap-3">

                            <div class="stat-icon">
                                <i class="mdi mdi-account-group-outline"></i>
                            </div>

                            <div>
                                <div class="stat-value">
                                    {{ $UserProvide->staff_members_count ?? 0 }}
                                </div>

                                <div class="stat-label">
                                    Staff members
                                </div>
                            </div>

                        </div>

                    </div>

                </div>


                {{-- Working Hours --}}
                <div class="profile-card">

                    <div class="card-heading">

                        <div>
                            <h3>Working Schedule</h3>
                            <p>Configured working hours</p>
                        </div>

                        <div class="card-heading-icon">
                            <i class="mdi mdi-clock-outline"></i>
                        </div>

                    </div>

                    <div class="card-body-custom">

                        <div class="d-flex align-items-center gap-3">

                            <div class="stat-icon">
                                <i class="mdi mdi-clock-outline"></i>
                            </div>

                            <div>
                                <div class="stat-value">
                                    {{ $UserProvide->working_hours_count ?? 0 }}
                                </div>

                                <div class="stat-label">
                                    Schedule entries configured
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection