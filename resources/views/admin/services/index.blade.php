@extends('layouts.app')

@section('title', 'Services')

@section('content')

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-primary-dark: #254035;
        --connector-primary-soft: #edf4f1;
        --connector-bg: #f7f9f8;
        --connector-border: #e4ebe8;
        --connector-text: #24332d;
        --connector-muted: #7a8983;
        --connector-danger: #c94c4c;
        --connector-warning: #b98528;
        --connector-shadow: 0 10px 30px rgba(37, 64, 53, .07);
    }

    .services-page {
        padding: 28px 0 50px;
        background: var(--connector-bg);
        min-height: calc(100vh - 80px);
    }

    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-eyebrow {
        color: var(--connector-primary);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .page-title {
        margin: 0;
        color: var(--connector-primary-dark);
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -.03em;
    }

    .page-description {
        color: var(--connector-muted);
        margin: 7px 0 0;
        font-size: 14px;
    }

    .btn-connector {
        background: var(--connector-primary-dark);
        border: 1px solid var(--connector-primary-dark);
        color: #fff;
        border-radius: 10px;
        padding: 11px 17px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: .2s ease;
    }

    .btn-connector:hover {
        background: var(--connector-primary);
        border-color: var(--connector-primary);
        color: #fff;
        transform: translateY(-1px);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 15px;
        padding: 18px;
        box-shadow: var(--connector-shadow);
    }

    .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        background: var(--connector-primary-soft);
        color: var(--connector-primary-dark);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .stat-label {
        color: var(--connector-muted);
        font-size: 12px;
        font-weight: 700;
    }

    .stat-value {
        color: var(--connector-primary-dark);
        font-size: 25px;
        font-weight: 800;
        line-height: 1;
    }

    .services-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 17px;
        box-shadow: var(--connector-shadow);
        overflow: hidden;
    }

    .services-toolbar {
        padding: 18px 20px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .toolbar-title {
        color: var(--connector-primary-dark);
        font-size: 15px;
        font-weight: 800;
        margin: 0;
    }

    .toolbar-subtitle {
        color: var(--connector-muted);
        font-size: 12px;
        margin-top: 3px;
    }

    .search-box {
        position: relative;
        width: 280px;
    }

    .search-box input {
        width: 100%;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        padding: 10px 12px 10px 38px;
        font-size: 13px;
        outline: none;
        background: #fafcfb;
    }

    .search-box input:focus {
        border-color: var(--connector-primary);
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .10);
    }

    .search-box svg {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--connector-muted);
    }

    .table-wrap {
        overflow-x: auto;
    }

    .services-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1050px;
    }

    .services-table thead th {
        background: #fafcfb;
        color: var(--connector-muted);
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
        padding: 14px 18px;
        border-bottom: 1px solid var(--connector-border);
        white-space: nowrap;
    }

    .services-table tbody td {
        padding: 15px 18px;
        border-bottom: 1px solid #edf1ef;
        vertical-align: middle;
        color: var(--connector-text);
        font-size: 13px;
    }

    .services-table tbody tr {
        transition: background .18s ease;
    }

    .services-table tbody tr:hover {
        background: #fbfdfc;
    }

    .service-id {
        color: var(--connector-muted);
        font-weight: 700;
        font-size: 12px;
    }

    .service-info {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 230px;
    }

    .service-image {
        width: 52px;
        height: 52px;
        border-radius: 11px;
        object-fit: cover;
        border: 1px solid var(--connector-border);
        background: #f2f5f3;
        flex-shrink: 0;
    }

    .service-name {
        color: var(--connector-primary-dark);
        font-weight: 800;
        margin-bottom: 3px;
        line-height: 1.25;
    }

    .service-slug {
        color: var(--connector-muted);
        font-size: 11px;
    }

    .category-name {
        font-weight: 700;
        color: var(--connector-text);
    }

    .subcategory-name {
        color: var(--connector-muted);
        font-size: 11px;
        margin-top: 3px;
    }

    .provider-name {
        font-weight: 700;
        color: var(--connector-text);
    }

    .price {
        color: var(--connector-primary-dark);
        font-weight: 800;
        white-space: nowrap;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .badge-status::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-active {
        color: #26704d;
        background: #eaf6ef;
    }

    .status-inactive {
        color: #8b5e23;
        background: #fff5df;
    }

    .featured-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: var(--connector-primary-dark);
        background: var(--connector-primary-soft);
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 11px;
        font-weight: 800;
    }

    .not-featured {
        color: var(--connector-muted);
        font-size: 12px;
        font-weight: 700;
    }

    .date-text {
        color: var(--connector-muted);
        white-space: nowrap;
        font-size: 12px;
    }

    .action-group {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .action-btn {
        width: 35px;
        height: 35px;
        border: 1px solid var(--connector-border);
        background: #fff;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: .18s ease;
        cursor: pointer;
    }

    .action-btn:hover {
        transform: translateY(-1px);
    }

    .action-view {
        color: var(--connector-primary-dark);
    }

    .action-view:hover {
        background: var(--connector-primary-soft);
        border-color: #c8dad2;
    }

    .action-edit {
        color: #80641f;
    }

    .action-edit:hover {
        background: #fff8e8;
        border-color: #ead9a9;
    }

    .action-delete {
        color: var(--connector-danger);
    }

    .action-delete:hover {
        background: #fff0f0;
        border-color: #f0caca;
    }

    .empty-state {
        text-align: center;
        padding: 65px 25px;
    }

    .empty-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 15px;
        border-radius: 15px;
        background: var(--connector-primary-soft);
        color: var(--connector-primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-title {
        color: var(--connector-primary-dark);
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .empty-text {
        color: var(--connector-muted);
        font-size: 13px;
    }

    .pagination-wrap {
        padding: 17px 20px;
        border-top: 1px solid var(--connector-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .results-text {
        color: var(--connector-muted);
        font-size: 12px;
    }

    .alert-connector {
        border: 0;
        border-radius: 11px;
        background: #eaf6ef;
        color: #276548;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 18px;
    }

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 576px) {
        .services-page {
            padding-top: 18px;
        }

        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .page-title {
            font-size: 23px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .search-box {
            width: 100%;
        }

        .pagination-wrap {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="services-page">

    <div class="container-fluid px-3 px-lg-4">

        {{-- Header --}}
        <div class="page-header">

            <div>
                <div class="page-eyebrow">Service Management</div>

                <h1 class="page-title">
                    Services
                </h1>

                <p class="page-description">
                    Manage services, providers, categories, pricing and visibility.
                </p>
            </div>

            @if(Route::has('admin.create_service'))
                <a href="{{ route('admin.create_service') }}" class="btn-connector">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                        <path d="M12 5V19M5 12H19"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"/>
                    </svg>
                    Add Service
                </a>
            @endif

        </div>

        {{-- Flash message --}}
        @if(session()->has('message'))
            <div class="alert alert-connector">
                {{ session('message') }}
            </div>
        @endif

        {{-- Statistics --}}
        @php
            $serviceCollection = $services instanceof \Illuminate\Pagination\AbstractPaginator
                ? collect($services->items())
                : collect($services);

            $totalServices = $services instanceof \Illuminate\Pagination\AbstractPaginator
                ? $services->total()
                : $serviceCollection->count();

            $activeServices = $serviceCollection->where('status', true)->count();

            $featuredServices = $serviceCollection->where('featured', true)->count();

            $providerCount = $serviceCollection
                ->pluck('service_provider_id')
                ->filter()
                ->unique()
                ->count();
        @endphp

        <div class="stats-grid">

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Total Services</span>

                    <span class="stat-icon">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                            <path d="M4 6.5C4 5.67 4.67 5 5.5 5H18.5C19.33 5 20 5.67 20 6.5V17.5C20 18.33 19.33 19 18.5 19H5.5C4.67 19 4 18.33 4 17.5V6.5Z"
                                  stroke="currentColor"
                                  stroke-width="1.7"/>
                            <path d="M8 9H16M8 13H13"
                                  stroke="currentColor"
                                  stroke-width="1.7"
                                  stroke-linecap="round"/>
                        </svg>
                    </span>
                </div>

                <div class="stat-value">
                    {{ number_format($totalServices) }}
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Active</span>

                    <span class="stat-icon">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                            <path d="M5 12.5L9.2 16.5L19 7.5"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </span>
                </div>

                <div class="stat-value">
                    {{ number_format($activeServices) }}
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Featured</span>

                    <span class="stat-icon">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                            <path d="M12 4L14.47 9.01L20 9.81L16 13.71L16.94 19.21L12 16.61L7.06 19.21L8 13.71L4 9.81L9.53 9.01L12 4Z"
                                  stroke="currentColor"
                                  stroke-width="1.7"
                                  stroke-linejoin="round"/>
                        </svg>
                    </span>
                </div>

                <div class="stat-value">
                    {{ number_format($featuredServices) }}
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Providers</span>

                    <span class="stat-icon">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                            <path d="M16 20V18C16 16.34 14.66 15 13 15H6C4.34 15 3 16.34 3 18V20"
                                  stroke="currentColor"
                                  stroke-width="1.7"
                                  stroke-linecap="round"/>
                            <circle cx="9.5" cy="8" r="3"
                                    stroke="currentColor"
                                    stroke-width="1.7"/>
                            <path d="M17 11C18.66 11 20 12.34 20 14V16"
                                  stroke="currentColor"
                                  stroke-width="1.7"
                                  stroke-linecap="round"/>
                            <path d="M15 5.2C16.66 5.2 18 6.54 18 8.2"
                                  stroke="currentColor"
                                  stroke-width="1.7"
                                  stroke-linecap="round"/>
                        </svg>
                    </span>
                </div>

                <div class="stat-value">
                    {{ number_format($providerCount) }}
                </div>
            </div>

        </div>

        {{-- Services --}}
        <div class="services-card">

            <div class="services-toolbar">

                <div>
                    <h2 class="toolbar-title">
                        Service Directory
                    </h2>

                    <div class="toolbar-subtitle">
                        Browse and manage all registered services.
                    </div>
                </div>

                <div class="search-box">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="6.5"
                                stroke="currentColor"
                                stroke-width="1.7"/>
                        <path d="M16 16L20 20"
                              stroke="currentColor"
                              stroke-width="1.7"
                              stroke-linecap="round"/>
                    </svg>

                    <input
                        type="text"
                        id="serviceSearch"
                        placeholder="Search services..."
                        autocomplete="off"
                    >
                </div>

            </div>

            <div class="table-wrap">

                <table class="services-table" id="servicesTable">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Category</th>
                            <th>Provider</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($services as $service)

                            <tr class="service-row">

                                <td>
                                    <span class="service-id">
                                        {{ $service->id }}
                                    </span>
                                </td>

                                <td>
                                    <div class="service-info">

                                        @if($service->image)
                                            <img
                                                src="{{ asset('image/services/' . $service->image) }}"
                                                alt="{{ $service->name }}"
                                                class="service-image"
                                                onerror="this.onerror=null;this.src='{{ asset('assets/images/services/service-placeholder.jpg') }}';"
                                            >
                                        @else
                                            <div class="service-image d-flex align-items-center justify-content-center">
                                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                                    <rect x="4" y="4" width="16" height="16" rx="2"
                                                          stroke="#6B9080"
                                                          stroke-width="1.5"/>
                                                    <path d="M7 15L10 12L13 15L15 13L18 16"
                                                          stroke="#6B9080"
                                                          stroke-width="1.5"
                                                          stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                        @endif

                                        <div>
                                            <div class="service-name">
                                                {{ $service->name }}
                                            </div>

                                            <div class="service-slug">
                                                {{ $service->slug }}
                                            </div>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <div class="category-name">
                                        {{ $service->category?->name ?? 'Uncategorized' }}
                                    </div>

                                    @if($service->subcategory)
                                        <div class="subcategory-name">
                                            {{ $service->subcategory->name }}
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    <div class="provider-name">
                                        {{ $service->provider?->user?->name
                                            ?? $service->provider?->name
                                            ?? 'No provider' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="price">
                                        {{ number_format((float) $service->price, 0) }} RWF
                                    </span>
                                </td>

                                <td>
                                    @if($service->status)
                                        <span class="badge-status status-active">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge-status status-inactive">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($service->featured)
                                        <span class="featured-badge">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                                                <path d="M12 4L14.47 9.01L20 9.81L16 13.71L16.94 19.21L12 16.61L7.06 19.21L8 13.71L4 9.81L9.53 9.01L12 4Z"
                                                      stroke="currentColor"
                                                      stroke-width="2"
                                                      stroke-linejoin="round"/>
                                            </svg>
                                            Featured
                                        </span>
                                    @else
                                        <span class="not-featured">
                                            Standard
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span class="date-text">
                                        {{ optional($service->created_at)->format('d M Y') }}
                                    </span>
                                </td>

                                <td>
                                    <div class="action-group justify-content-end">

                                        <a
                                            href="{{ route('admin.show_service', $service->slug) }}"
                                            class="action-btn action-view"
                                            title="View service"
                                            aria-label="View service"
                                        >
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                <path d="M2.5 12C4.3 8.5 7.5 6 12 6C16.5 6 19.7 8.5 21.5 12C19.7 15.5 16.5 18 12 18C7.5 18 4.3 15.5 2.5 12Z"
                                                      stroke="currentColor"
                                                      stroke-width="1.7"/>
                                                <circle cx="12" cy="12" r="3"
                                                        stroke="currentColor"
                                                        stroke-width="1.7"/>
                                            </svg>
                                        </a>

                                        <a
                                            href="{{ route('admin.edit_service', $service->id) }}"
                                            class="action-btn action-edit"
                                            title="Edit service"
                                            aria-label="Edit service"
                                        >
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                <path d="M4 20H8L18.5 9.5C19.33 8.67 19.33 7.33 18.5 6.5C17.67 5.67 16.33 5.67 15.5 6.5L5 17V20Z"
                                                      stroke="currentColor"
                                                      stroke-width="1.7"
                                                      stroke-linejoin="round"/>
                                                <path d="M14 8L18 12"
                                                      stroke="currentColor"
                                                      stroke-width="1.7"/>
                                            </svg>
                                        </a>

                                        <form
                                            action="{{ route('admin.delete_service', $service->id) }}"
                                            method="POST"
                                            class="d-inline service-delete-form"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn action-delete"
                                                title="Delete service"
                                                aria-label="Delete service"
                                            >
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                    <path d="M5 7H19"
                                                          stroke="currentColor"
                                                          stroke-width="1.7"
                                                          stroke-linecap="round"/>
                                                    <path d="M9 7V5H15V7"
                                                          stroke="currentColor"
                                                          stroke-width="1.7"
                                                          stroke-linecap="round"/>
                                                    <path d="M8 10V18M12 10V18M16 10V18"
                                                          stroke="currentColor"
                                                          stroke-width="1.7"
                                                          stroke-linecap="round"/>
                                                    <path d="M6 7L7 20H17L18 7"
                                                          stroke="currentColor"
                                                          stroke-width="1.7"
                                                          stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">

                                        <div class="empty-icon">
                                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none">
                                                <rect x="4" y="4" width="16" height="16" rx="2"
                                                      stroke="currentColor"
                                                      stroke-width="1.6"/>
                                                <path d="M8 9H16M8 13H14M8 17H11"
                                                      stroke="currentColor"
                                                      stroke-width="1.6"
                                                      stroke-linecap="round"/>
                                            </svg>
                                        </div>

                                        <div class="empty-title">
                                            No services found
                                        </div>

                                        <div class="empty-text">
                                            Services added to the platform will appear here.
                                        </div>

                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if($services instanceof \Illuminate\Pagination\AbstractPaginator)

                <div class="pagination-wrap">

                    <div class="results-text">
                        Showing
                        {{ $services->firstItem() ?? 0 }}
                        to
                        {{ $services->lastItem() ?? 0 }}
                        of
                        {{ $services->total() }}
                        services
                    </div>

                    <div>
                        {{ $services->links() }}
                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('serviceSearch');
    const rows = document.querySelectorAll('.service-row');

    if (searchInput) {
        searchInput.addEventListener('input', function () {

            const query = this.value.toLowerCase().trim();

            rows.forEach(function (row) {

                const text = row.textContent.toLowerCase();

                row.style.display = text.includes(query) ? '' : 'none';

            });
        });
    }

    document.querySelectorAll('.service-delete-form').forEach(function (form) {

        form.addEventListener('submit', function (event) {

            const confirmed = confirm(
                'Are you sure you want to delete this service? This action cannot be undone.'
            );

            if (!confirmed) {
                event.preventDefault();
            }

        });

    });

});
</script>

@endsection