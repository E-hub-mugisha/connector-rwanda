@extends('layouts.app')

@section('title', 'Service by Category')

@section('content')

@php
    $serviceCount = $services instanceof \Illuminate\Pagination\AbstractPaginator
        ? $services->total()
        : $services->count();
@endphp

<style>
    .category-services-page {
        background: #f6f8f7;
        min-height: calc(100vh - 70px);
        padding: 30px 0 60px;
    }

    .category-services-page .container-fluid {
        max-width: 1500px;
    }

    /* ---------------------------------------------------------
       Header
    --------------------------------------------------------- */

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 26px;
    }

    .page-eyebrow {
        color: #6B9080;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        margin-bottom: 7px;
    }

    .page-title {
        color: #254035;
        font-size: 29px;
        font-weight: 800;
        margin: 0;
        line-height: 1.2;
    }

    .page-subtitle {
        color: #7a8983;
        font-size: 13px;
        margin: 8px 0 0;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-connector {
        background: #6B9080;
        color: #fff;
        border: 1px solid #6B9080;
        border-radius: 10px;
        padding: 10px 17px;
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
        color: #254035;
        border: 1px solid #dfe7e3;
        border-radius: 10px;
        padding: 10px 17px;
        font-size: 13px;
        font-weight: 700;
    }

    .btn-light-connector:hover {
        background: #edf4f1;
        color: #254035;
    }

    /* ---------------------------------------------------------
       Summary cards
    --------------------------------------------------------- */

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 22px;
    }

    .summary-card {
        background: #fff;
        border: 1px solid #e6ece9;
        border-radius: 15px;
        padding: 19px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 6px 20px rgba(37, 64, 53, .04);
    }

    .summary-icon {
        width: 43px;
        height: 43px;
        border-radius: 12px;
        background: #e8f1ed;
        color: #254035;
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
    }

    .summary-icon i {
        font-size: 16px;
    }

    .summary-label {
        color: #89958f;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .summary-value {
        color: #254035;
        font-size: 20px;
        font-weight: 900;
        margin-top: 2px;
    }

    /* ---------------------------------------------------------
       Main card
    --------------------------------------------------------- */

    .services-card {
        background: #fff;
        border: 1px solid #e5ebe8;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 28px rgba(37, 64, 53, .05);
    }

    .services-card-header {
        padding: 21px 24px;
        border-bottom: 1px solid #edf1ef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .card-title {
        color: #254035;
        font-size: 17px;
        font-weight: 800;
        margin: 0;
    }

    .card-subtitle {
        color: #89958f;
        font-size: 12px;
        margin: 4px 0 0;
    }

    .count-badge {
        background: #edf4f1;
        color: #3e6858;
        padding: 7px 11px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    /* ---------------------------------------------------------
       Table
    --------------------------------------------------------- */

    .services-table-wrapper {
        overflow-x: auto;
    }

    .services-table {
        width: 100%;
        min-width: 980px;
        border-collapse: collapse;
    }

    .services-table thead th {
        background: #fafcfb;
        color: #87938e;
        border-bottom: 1px solid #e8eeeb;
        padding: 14px 18px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .7px;
        white-space: nowrap;
    }

    .services-table tbody td {
        padding: 15px 18px;
        border-bottom: 1px solid #edf1ef;
        vertical-align: middle;
    }

    .services-table tbody tr {
        transition: background .15s ease;
    }

    .services-table tbody tr:hover {
        background: #fafcfb;
    }

    .services-table tbody tr:last-child td {
        border-bottom: 0;
    }

    /* ---------------------------------------------------------
       Service
    --------------------------------------------------------- */

    .service-cell {
        display: flex;
        align-items: center;
        gap: 13px;
        min-width: 250px;
    }

    .service-image {
        width: 58px;
        height: 52px;
        border-radius: 10px;
        overflow: hidden;
        background: #edf2ef;
        flex: 0 0 auto;
        border: 1px solid #e5ebe8;
    }

    .service-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .service-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8a9891;
    }

    .service-image-placeholder i {
        font-size: 17px;
    }

    .service-name {
        color: #254035;
        font-size: 13px;
        font-weight: 800;
        line-height: 1.4;
        max-width: 230px;
    }

    .service-slug {
        color: #98a39e;
        font-size: 11px;
        margin-top: 3px;
    }

    /* ---------------------------------------------------------
       Category
    --------------------------------------------------------- */

    .category-name {
        color: #52645c;
        font-size: 12px;
        font-weight: 700;
    }

    .subcategory-name {
        color: #99a39f;
        font-size: 11px;
        margin-top: 3px;
    }

    /* ---------------------------------------------------------
       Price
    --------------------------------------------------------- */

    .price-main {
        color: #254035;
        font-size: 13px;
        font-weight: 800;
        white-space: nowrap;
    }

    .price-old {
        color: #9aa49f;
        font-size: 10px;
        text-decoration: line-through;
        margin-top: 2px;
    }

    .discount-badge {
        display: inline-block;
        background: #e9f5ef;
        color: #317359;
        border-radius: 999px;
        padding: 4px 7px;
        font-size: 9px;
        font-weight: 800;
        margin-top: 5px;
    }

    /* ---------------------------------------------------------
       Status
    --------------------------------------------------------- */

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-active {
        color: #32745a;
        background: #e8f5ee;
    }

    .status-inactive {
        color: #a14e43;
        background: #f8eae8;
    }

    /* ---------------------------------------------------------
       Location / date
    --------------------------------------------------------- */

    .location-text {
        color: #56675f;
        font-size: 12px;
        max-width: 150px;
    }

    .date-text {
        color: #63736c;
        font-size: 12px;
        white-space: nowrap;
    }

    .date-time {
        color: #9aa49f;
        font-size: 10px;
        margin-top: 3px;
    }

    /* ---------------------------------------------------------
       Actions
    --------------------------------------------------------- */

    .actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e1e8e4;
        background: #fff;
        color: #60726a;
        transition: .2s ease;
        text-decoration: none;
    }

    .action-btn:hover {
        background: #edf4f1;
        border-color: #d3e1da;
        color: #254035;
    }

    .action-btn.edit:hover {
        background: #edf4f1;
        color: #254035;
    }

    .action-btn.delete {
        border: 0;
        cursor: pointer;
    }

    .action-btn.delete:hover {
        background: #faecea;
        color: #b14f43;
    }

    .delete-form {
        margin: 0;
    }

    /* ---------------------------------------------------------
       Empty state
    --------------------------------------------------------- */

    .empty-state {
        text-align: center;
        padding: 70px 25px;
    }

    .empty-icon {
        width: 65px;
        height: 65px;
        margin: 0 auto 16px;
        border-radius: 18px;
        background: #edf4f1;
        color: #6B9080;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .empty-title {
        color: #254035;
        font-size: 17px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .empty-text {
        color: #89958f;
        font-size: 13px;
        margin-bottom: 20px;
    }

    /* ---------------------------------------------------------
       Pagination
    --------------------------------------------------------- */

    .pagination-wrapper {
        padding: 18px 24px;
        border-top: 1px solid #edf1ef;
    }

    .pagination-wrapper .pagination {
        margin-bottom: 0;
    }

    .pagination-wrapper .page-link {
        color: #254035;
        border-color: #e1e8e4;
        border-radius: 8px;
        margin: 0 2px;
        font-size: 12px;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: #6B9080;
        border-color: #6B9080;
        color: #fff;
    }

    /* ---------------------------------------------------------
       Responsive
    --------------------------------------------------------- */

    @media (max-width: 991.98px) {

        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 575.98px) {

        .category-services-page {
            padding-top: 18px;
        }

        .page-title {
            font-size: 24px;
        }

        .services-card-header {
            padding: 18px;
        }

    }
</style>


<div class="category-services-page">

    <div class="container-fluid px-3 px-lg-4">

        {{-- =========================================================
             PAGE HEADER
        ========================================================== --}}

        <div class="page-header">

            <div>

                <div class="page-eyebrow">
                    Service Management
                </div>

                <h1 class="page-title">
                    Services by Category
                </h1>

                <p class="page-subtitle">
                    Manage services available across the Connector marketplace.
                </p>

            </div>


            <div class="header-actions">

                <a href="{{ route('admin.all_services') }}"
                   class="btn btn-light-connector">

                    <i class="fas fa-layer-group mr-1"></i>

                    All Services

                </a>

                @if(Route::has('admin.add_service'))

                    <a href="{{ route('admin.add_service') }}"
                       class="btn btn-connector">

                        <i class="fas fa-plus mr-1"></i>

                        Add Service

                    </a>

                @endif

            </div>

        </div>


        {{-- =========================================================
             SUMMARY
        ========================================================== --}}

        <div class="summary-grid">

            <div class="summary-card">

                <div class="summary-icon">
                    <i class="fas fa-concierge-bell"></i>
                </div>

                <div>

                    <div class="summary-label">
                        Services
                    </div>

                    <div class="summary-value">
                        {{ number_format($serviceCount) }}
                    </div>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon">
                    <i class="fas fa-check-circle"></i>
                </div>

                <div>

                    <div class="summary-label">
                        Active
                    </div>

                    <div class="summary-value">

                        {{
                            number_format(
                                collect($services)->where('status', 1)->count()
                            )
                        }}

                    </div>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon">
                    <i class="fas fa-pause-circle"></i>
                </div>

                <div>

                    <div class="summary-label">
                        Inactive
                    </div>

                    <div class="summary-value">

                        {{
                            number_format(
                                collect($services)->where('status', 0)->count()
                            )
                        }}

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
             SERVICES CARD
        ========================================================== --}}

        <div class="services-card">

            <div class="services-card-header">

                <div>

                    <h2 class="card-title">
                        Service Directory
                    </h2>

                    <p class="card-subtitle">
                        Review pricing, category, availability and service details.
                    </p>

                </div>

                <div class="count-badge">

                    {{ number_format($serviceCount) }}

                    {{ Str::plural('service', $serviceCount) }}

                </div>

            </div>


            {{-- =====================================================
                 TABLE
            ====================================================== --}}

            @if($services->count())

                <div class="services-table-wrapper">

                    <table class="services-table">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>Service</th>

                                <th>Category</th>

                                <th>Price</th>

                                <th>Location</th>

                                <th>Status</th>

                                <th>Created</th>

                                <th class="text-right">Actions</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($services as $service)

                                @php

                                    $price = (float) ($service->price ?? 0);
                                    $discount = (float) ($service->discount ?? 0);

                                    $finalPrice = $price;

                                    if ($discount > 0) {

                                        if ($service->discount_type === 'fixed') {

                                            $finalPrice = max(
                                                0,
                                                $price - $discount
                                            );

                                        } elseif ($service->discount_type === 'percent') {

                                            $finalPrice = max(
                                                0,
                                                $price - ($price * $discount / 100)
                                            );

                                        }

                                    }

                                @endphp


                                <tr>

                                    {{-- ID --}}
                                    <td>

                                        <span class="text-muted small">
                                            #{{ $service->id }}
                                        </span>

                                    </td>


                                    {{-- SERVICE --}}
                                    <td>

                                        <div class="service-cell">

                                            <div class="service-image">

                                                @if($service->image)

                                                    <img
                                                        src="{{ asset('image/services/' . $service->image) }}"
                                                        alt="{{ $service->name }}"
                                                        loading="lazy"
                                                    >

                                                @else

                                                    <div class="service-image-placeholder">

                                                        <i class="fas fa-image"></i>

                                                    </div>

                                                @endif

                                            </div>


                                            <div>

                                                <div class="service-name">

                                                    {{ $service->name }}

                                                </div>

                                                @if($service->slug)

                                                    <div class="service-slug">

                                                        {{ $service->slug }}

                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- CATEGORY --}}
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


                                    {{-- PRICE --}}
                                    <td>

                                        @if($discount > 0)

                                            <div class="price-main">

                                                RWF {{ number_format($finalPrice, 0) }}

                                            </div>

                                            <div class="price-old">

                                                RWF {{ number_format($price, 0) }}

                                            </div>

                                            <span class="discount-badge">

                                                @if($service->discount_type === 'percent')

                                                    -{{ number_format($discount, 0) }}%

                                                @else

                                                    -RWF {{ number_format($discount, 0) }}

                                                @endif

                                            </span>

                                        @else

                                            <div class="price-main">

                                                RWF {{ number_format($price, 0) }}

                                            </div>

                                        @endif

                                    </td>


                                    {{-- LOCATION --}}
                                    <td>

                                        <div class="location-text">

                                            @if($service->location)

                                                <i class="fas fa-map-marker-alt mr-1"
                                                   style="color:#6B9080;"></i>

                                                {{ $service->location }}

                                            @else

                                                <span class="text-muted">
                                                    Not specified
                                                </span>

                                            @endif

                                        </div>

                                    </td>


                                    {{-- STATUS --}}
                                    <td>

                                        @if($service->status)

                                            <span class="status-pill status-active">

                                                <span class="status-dot"></span>

                                                Active

                                            </span>

                                        @else

                                            <span class="status-pill status-inactive">

                                                <span class="status-dot"></span>

                                                Inactive

                                            </span>

                                        @endif

                                    </td>


                                    {{-- CREATED --}}
                                    <td>

                                        @if($service->created_at)

                                            <div class="date-text">

                                                {{ $service->created_at->format('d M Y') }}

                                            </div>

                                            <div class="date-time">

                                                {{ $service->created_at->format('H:i') }}

                                            </div>

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    {{-- ACTIONS --}}
                                    <td>

                                        <div class="actions">

                                            {{-- VIEW --}}
                                            <a
                                                href="{{ route('admin.show_service', $service->slug) }}"
                                                class="action-btn"
                                                title="View service"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </a>


                                            {{-- EDIT --}}
                                            <a
                                                href="{{ route('admin.edit_service', $service->id) }}"
                                                class="action-btn edit"
                                                title="Edit service"
                                            >
                                                <i class="fas fa-pen"></i>
                                            </a>


                                            {{-- DELETE --}}
                                            <form
                                                action="{{ route('admin.delete_service', $service->id) }}"
                                                method="POST"
                                                class="delete-form"
                                                onsubmit="return confirm('Are you sure you want to delete this service? This action cannot be undone.');"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="action-btn delete"
                                                    title="Delete service"
                                                >

                                                    <i class="fas fa-trash-alt"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- =================================================
                     PAGINATION
                ================================================== --}}

                @if($services instanceof \Illuminate\Contracts\Pagination\Paginator ||
                    $services instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)

                    <div class="pagination-wrapper">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                            <div class="small text-muted">

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

                    </div>

                @endif


            @else

                {{-- =================================================
                     EMPTY STATE
                ================================================== --}}

                <div class="empty-state">

                    <div class="empty-icon">

                        <i class="fas fa-concierge-bell"></i>

                    </div>

                    <div class="empty-title">
                        No services found
                    </div>

                    <p class="empty-text">
                        There are currently no services available in this category.
                    </p>

                    @if(Route::has('admin.add_service'))

                        <a href="{{ route('admin.add_service') }}"
                           class="btn btn-connector">

                            <i class="fas fa-plus mr-1"></i>

                            Add First Service

                        </a>

                    @endif

                </div>

            @endif

        </div>

    </div>

</div>

@endsection