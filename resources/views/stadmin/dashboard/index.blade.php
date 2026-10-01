@extends('layouts.app')

@section('title', 'Service Provider Dashboard')

@section('content')

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-dark: #254035;
        --connector-soft: #EEF5F2;
        --connector-border: #E3EBE7;
        --connector-muted: #71807A;
        --connector-bg: #F7F9F8;
    }

    .provider-dashboard {
        background: var(--connector-bg);
        min-height: calc(100vh - 70px);
        padding: 32px 0 50px;
    }

    .dashboard-container {
        max-width: 1400px;
    }

    .dashboard-header {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 20px;
        padding: 28px;
        margin-bottom: 24px;
    }

    .dashboard-title {
        color: var(--connector-dark);
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .dashboard-subtitle {
        color: var(--connector-muted);
        margin: 0;
    }

    .provider-avatar {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        object-fit: cover;
        background: var(--connector-soft);
        border: 1px solid var(--connector-border);
    }

    .provider-avatar-placeholder {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .btn-connector {
        background: var(--connector-primary);
        border-color: var(--connector-primary);
        color: #fff;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
    }

    .btn-connector:hover {
        background: var(--connector-dark);
        border-color: var(--connector-dark);
        color: #fff;
    }

    .btn-outline-connector {
        border: 1px solid var(--connector-border);
        background: #fff;
        color: var(--connector-dark);
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
    }

    .btn-outline-connector:hover {
        background: var(--connector-soft);
        color: var(--connector-dark);
    }

    .stat-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        padding: 22px;
        height: 100%;
        transition: .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        border-color: rgba(107, 144, 128, .45);
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        margin-bottom: 18px;
    }

    .stat-label {
        color: var(--connector-muted);
        font-size: 13px;
        margin-bottom: 6px;
    }

    .stat-value {
        color: var(--connector-dark);
        font-size: 26px;
        font-weight: 700;
        line-height: 1;
    }

    .dashboard-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        height: 100%;
        overflow: hidden;
    }

    .card-header-clean {
        padding: 20px 22px;
        border-bottom: 1px solid var(--connector-border);
        background: #fff;
    }

    .card-header-clean h5 {
        color: var(--connector-dark);
        font-size: 16px;
        font-weight: 700;
        margin: 0;
    }

    .card-header-clean p {
        color: var(--connector-muted);
        font-size: 13px;
        margin: 4px 0 0;
    }

    .card-body-clean {
        padding: 22px;
    }

    .service-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #EEF2F0;
    }

    .service-item:first-child {
        padding-top: 0;
    }

    .service-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .service-name {
        color: var(--connector-dark);
        font-weight: 600;
        margin-bottom: 3px;
    }

    .service-category {
        color: var(--connector-muted);
        font-size: 12px;
    }

    .service-price {
        color: var(--connector-dark);
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    .profile-section {
        display: flex;
        gap: 16px;
        align-items: center;
        margin-bottom: 24px;
    }

    .profile-name {
        color: var(--connector-dark);
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .profile-category {
        color: var(--connector-muted);
        font-size: 13px;
    }

    .progress {
        height: 8px;
        background: #E8EFEC;
        border-radius: 10px;
    }

    .progress-bar {
        background: var(--connector-primary);
        border-radius: 10px;
    }

    .completion-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 13px;
    }

    .completion-label span:first-child {
        color: var(--connector-muted);
    }

    .completion-label span:last-child {
        color: var(--connector-dark);
        font-weight: 700;
    }

    .category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 13px 0;
        border-bottom: 1px solid #EEF2F0;
    }

    .category-item:last-child {
        border-bottom: 0;
    }

    .category-name {
        color: var(--connector-dark);
        font-weight: 600;
        font-size: 14px;
    }

    .category-count {
        min-width: 32px;
        height: 28px;
        padding: 0 9px;
        border-radius: 8px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
    }

    .promotion-item {
        padding: 15px 0;
        border-bottom: 1px solid #EEF2F0;
    }

    .promotion-item:first-child {
        padding-top: 0;
    }

    .promotion-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .promotion-title {
        color: var(--connector-dark);
        font-weight: 600;
        margin-bottom: 4px;
    }

    .promotion-service {
        color: var(--connector-muted);
        font-size: 12px;
    }

    .discount-badge {
        background: var(--connector-soft);
        color: var(--connector-dark);
        border-radius: 8px;
        padding: 5px 8px;
        font-size: 11px;
        font-weight: 700;
    }

    .empty-state {
        padding: 28px 10px;
        text-align: center;
        color: var(--connector-muted);
    }

    .empty-state i {
        display: block;
        font-size: 28px;
        margin-bottom: 10px;
        color: var(--connector-primary);
    }

    .quick-action {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 0;
        color: var(--connector-dark);
        text-decoration: none;
        border-bottom: 1px solid #EEF2F0;
    }

    .quick-action:last-child {
        border-bottom: 0;
    }

    .quick-action:hover {
        color: var(--connector-primary);
    }

    .quick-action-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quick-action-text {
        font-size: 14px;
        font-weight: 600;
    }

    @media (max-width: 767px) {
        .provider-dashboard {
            padding: 20px 0 35px;
        }

        .dashboard-header {
            padding: 20px;
        }

        .dashboard-title {
            font-size: 23px;
        }

        .header-actions {
            margin-top: 18px;
            width: 100%;
        }

        .header-actions .btn {
            flex: 1;
        }
    }
</style>

<div class="provider-dashboard">

    <div class="container dashboard-container">

        {{-- Header --}}
        <div class="dashboard-header">

            <div class="d-flex flex-column flex-md-row
                        align-items-md-center
                        justify-content-between">

                <div class="d-flex align-items-center gap-3">

                    @if($sprovider->image)
                        <img
                            src="{{ asset('storage/' . $sprovider->image) }}"
                            alt="{{ $sprovider->user?->name }}"
                            class="provider-avatar"
                        >
                    @else
                        <div class="provider-avatar-placeholder">
                            <i class="bi bi-building"></i>
                        </div>
                    @endif

                    <div>
                        <h1 class="dashboard-title">
                            Welcome back, {{ $sprovider->user?->name ?? 'Provider' }}
                        </h1>

                        <p class="dashboard-subtitle">
                            Manage your services, promotions and provider profile.
                        </p>
                    </div>

                </div>

                <div class="d-flex gap-2 header-actions">

                    <a href="{{ route('serviceProvider.create') }}"
                       class="btn btn-connector">
                        <i class="bi bi-plus-lg me-1"></i>
                        Add Service
                    </a>

                    <a href="{{ route('sprovider.profile') }}"
                       class="btn btn-outline-connector">
                        View Profile
                    </a>

                </div>

            </div>

        </div>


        {{-- Statistics --}}
        <div class="row g-3 mb-4">

            <div class="col-6 col-xl-3">
                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-grid"></i>
                    </div>

                    <div class="stat-label">
                        Total Services
                    </div>

                    <div class="stat-value">
                        {{ $totalServices }}
                    </div>

                </div>
            </div>


            <div class="col-6 col-xl-3">
                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-star"></i>
                    </div>

                    <div class="stat-label">
                        Average Rating
                    </div>

                    <div class="stat-value">
                        {{ number_format($averageRating, 1) }}
                    </div>

                </div>
            </div>


            <div class="col-6 col-xl-3">
                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-chat-square-text"></i>
                    </div>

                    <div class="stat-label">
                        Customer Feedback
                    </div>

                    <div class="stat-value">
                        {{ $totalFeedback }}
                    </div>

                </div>
            </div>


            <div class="col-6 col-xl-3">
                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-tag"></i>
                    </div>

                    <div class="stat-label">
                        Active Promotions
                    </div>

                    <div class="stat-value">
                        {{ $activePromotions }}
                    </div>

                </div>
            </div>

        </div>


        {{-- Main Content --}}
        <div class="row g-4 mb-4">

            {{-- Recent Services --}}
            <div class="col-lg-8">

                <div class="dashboard-card">

                    <div class="card-header-clean
                                d-flex justify-content-between
                                align-items-center">

                        <div>
                            <h5>Recent Services</h5>
                            <p>Your latest services</p>
                        </div>

                        <a href="{{ route('serviceProvider.create') }}"
                           class="btn btn-sm btn-outline-connector">
                            Add Service
                        </a>

                    </div>

                    <div class="card-body-clean">

                        @forelse($recentServices as $service)

                            <div class="service-item">

                                <div>
                                    <div class="service-name">
                                        {{ $service->name ?? 'Unnamed Service' }}
                                    </div>

                                    <div class="service-category">
                                        {{ $service->category?->name ?? 'Uncategorized' }}
                                    </div>
                                </div>

                                @if(isset($service->price))
                                    <div class="service-price">
                                        {{ number_format($service->price) }}
                                    </div>
                                @endif

                            </div>

                        @empty

                            <div class="empty-state">
                                <i class="bi bi-grid"></i>

                                <div>
                                    You have not added any services yet.
                                </div>
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            {{-- Profile --}}
            <div class="col-lg-4">

                <div class="dashboard-card">

                    <div class="card-header-clean">
                        <h5>Provider Profile</h5>
                        <p>Your profile overview</p>
                    </div>

                    <div class="card-body-clean">

                        <div class="profile-section">

                            @if($sprovider->image)

                                <img
                                    src="{{ asset('storage/' . $sprovider->image) }}"
                                    alt="{{ $sprovider->user?->name }}"
                                    class="provider-avatar"
                                >

                            @else

                                <div class="provider-avatar-placeholder">
                                    <i class="bi bi-person"></i>
                                </div>

                            @endif

                            <div>

                                <div class="profile-name">
                                    {{ $sprovider->user?->name ?? 'Provider' }}
                                </div>

                                <div class="profile-category">
                                    {{ $sprovider->category?->name ?? 'Service Provider' }}
                                </div>

                            </div>

                        </div>


                        <div class="completion-label">
                            <span>Profile completion</span>
                            <span>{{ $profileCompletion }}%</span>
                        </div>

                        <div class="progress mb-4">
                            <div
                                class="progress-bar"
                                style="width: {{ $profileCompletion }}%">
                            </div>
                        </div>


                        <a href="{{ route('sprovider.edit_profile') }}"
                           class="btn btn-connector w-100">
                            Edit Profile
                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- Secondary Content --}}
        <div class="row g-4">

            {{-- Promotions --}}
            <div class="col-lg-6">

                <div class="dashboard-card">

                    <div class="card-header-clean
                                d-flex justify-content-between
                                align-items-center">

                        <div>
                            <h5>Promotions</h5>
                            <p>Promotions attached to your services</p>
                        </div>

                        <span class="discount-badge">
                            {{ $activePromotions }} Active
                        </span>

                    </div>

                    <div class="card-body-clean">

                        @forelse($promotions->take(5) as $promotion)

                            <div class="promotion-item">

                                <div class="d-flex
                                            justify-content-between
                                            align-items-start
                                            gap-3">

                                    <div>

                                        <div class="promotion-title">
                                            {{ $promotion->title }}
                                        </div>

                                        <div class="promotion-service">
                                            Service:
                                            {{ $promotion->service?->name ?? 'Unknown service' }}
                                        </div>

                                    </div>

                                    @if($promotion->discount)
                                        <span class="discount-badge">
                                            {{ $promotion->discount }}%
                                        </span>
                                    @endif

                                </div>

                            </div>

                        @empty

                            <div class="empty-state">
                                <i class="bi bi-tag"></i>

                                <div>
                                    No promotions have been created yet.
                                </div>
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            {{-- Categories --}}
            <div class="col-lg-6">

                <div class="dashboard-card">

                    <div class="card-header-clean">
                        <h5>Service Categories</h5>
                        <p>Distribution of your services</p>
                    </div>

                    <div class="card-body-clean">

                        @forelse($servicesByCategory as $item)

                            <div class="category-item">

                                <div class="category-name">
                                    {{ $item['category'] }}
                                </div>

                                <div class="category-count">
                                    {{ $item['count'] }}
                                </div>

                            </div>

                        @empty

                            <div class="empty-state">
                                <i class="bi bi-layers"></i>

                                <div>
                                    No service categories available.
                                </div>
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            {{-- Quick Actions --}}
            <div class="col-lg-4">

                <div class="dashboard-card">

                    <div class="card-header-clean">
                        <h5>Quick Actions</h5>
                        <p>Common provider actions</p>
                    </div>

                    <div class="card-body-clean">

                        <a href="{{ route('serviceProvider.create') }}"
                           class="quick-action">

                            <span class="quick-action-icon">
                                <i class="bi bi-plus-lg"></i>
                            </span>

                            <span class="quick-action-text">
                                Add New Service
                            </span>

                        </a>


                        <a href="{{ route('sprovider.portfolio') }}"
                           class="quick-action">

                            <span class="quick-action-icon">
                                <i class="bi bi-grid"></i>
                            </span>

                            <span class="quick-action-text">
                                Manage Services
                            </span>

                        </a>


                        <a href="{{ route('working_hours.index') }}"
                           class="quick-action">

                            <span class="quick-action-icon">
                                <i class="bi bi-clock"></i>
                            </span>

                            <span class="quick-action-text">
                                Working Hours
                            </span>

                        </a>


                        <a href="{{ route('sprovider.edit_profile') }}"
                           class="quick-action">

                            <span class="quick-action-icon">
                                <i class="bi bi-person"></i>
                            </span>

                            <span class="quick-action-text">
                                Update Profile
                            </span>

                        </a>

                    </div>

                </div>

            </div>


            {{-- Provider Overview --}}
            <div class="col-lg-8">

                <div class="dashboard-card">

                    <div class="card-header-clean">
                        <h5>Provider Overview</h5>
                        <p>Current provider activity</p>
                    </div>

                    <div class="card-body-clean">

                        <div class="row g-3">

                            <div class="col-sm-6">
                                <div class="stat-card">
                                    <div class="stat-label">
                                        Ratings
                                    </div>

                                    <div class="stat-value">
                                        {{ $totalRatings }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="stat-card">
                                    <div class="stat-label">
                                        Staff Members
                                    </div>

                                    <div class="stat-value">
                                        {{ $totalStaff }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="stat-card">
                                    <div class="stat-label">
                                        Working Hours
                                    </div>

                                    <div class="stat-value">
                                        {{ $totalWorkingHours }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="stat-card">
                                    <div class="stat-label">
                                        Total Promotions
                                    </div>

                                    <div class="stat-value">
                                        {{ $totalPromotions }}
                                    </div>
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