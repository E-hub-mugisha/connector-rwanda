@extends('layouts.app')

@section('title', 'My Services')

@section('content')

@php
    $currency = 'RWF';
@endphp

<style>
    .provider-dashboard {
        padding: 10px 0 30px;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #254035 0%, #6B9080 100%);
        border-radius: 18px;
        padding: 30px;
        color: #fff;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::after {
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
        right: -80px;
        top: -100px;
    }

    .dashboard-header-content {
        position: relative;
        z-index: 2;
    }

    .dashboard-header h2 {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .dashboard-header p {
        margin: 0;
        opacity: .85;
        font-size: 14px;
    }

    .btn-add-service {
        background: #fff;
        color: #254035;
        border: none;
        border-radius: 10px;
        padding: 11px 18px;
        font-weight: 600;
        transition: .2s ease;
    }

    .btn-add-service:hover {
        background: #f5f7f6;
        color: #254035;
        transform: translateY(-1px);
    }

    .stat-card {
        background: #fff;
        border: 1px solid #edf0ef;
        border-radius: 16px;
        padding: 21px;
        height: 100%;
        transition: .2s ease;
        box-shadow: 0 3px 15px rgba(37, 64, 53, .04);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 64, 53, .08);
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        background: #edf5f1;
        color: #254035;
    }

    .stat-label {
        font-size: 12px;
        color: #7a8580;
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #254035;
        line-height: 1.2;
    }

    .services-card {
        background: #fff;
        border: 1px solid #edf0ef;
        border-radius: 18px;
        box-shadow: 0 3px 15px rgba(37, 64, 53, .04);
        overflow: hidden;
    }

    .services-card-header {
        padding: 22px 24px;
        border-bottom: 1px solid #edf0ef;
    }

    .services-title {
        font-size: 18px;
        font-weight: 700;
        color: #254035;
        margin-bottom: 3px;
    }

    .services-subtitle {
        font-size: 13px;
        color: #8a938f;
        margin: 0;
    }

    .service-search {
        position: relative;
        min-width: 230px;
    }

    .service-search i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ba49f;
    }

    .service-search input {
        height: 40px;
        padding-left: 38px;
        border: 1px solid #e4e9e6;
        border-radius: 9px;
        font-size: 13px;
        outline: none;
    }

    .service-search input:focus {
        border-color: #6B9080;
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .10);
    }

    .service-table {
        margin-bottom: 0;
    }

    .service-table thead th {
        background: #fafbfa;
        color: #7d8782;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .4px;
        font-weight: 700;
        border-bottom: 1px solid #edf0ef;
        padding: 14px 20px;
        white-space: nowrap;
    }

    .service-table tbody td {
        padding: 15px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f2f1;
    }

    .service-table tbody tr:last-child td {
        border-bottom: none;
    }

    .service-table tbody tr {
        transition: .15s ease;
    }

    .service-table tbody tr:hover {
        background: #fbfcfb;
    }

    .service-image {
        width: 52px;
        height: 52px;
        border-radius: 11px;
        object-fit: cover;
        border: 1px solid #edf0ef;
        background: #f5f7f6;
    }

    .service-name {
        color: #254035;
        font-size: 14px;
        font-weight: 650;
        margin-bottom: 3px;
    }

    .service-slug {
        color: #9aa39f;
        font-size: 11px;
    }

    .category-text {
        color: #68736e;
        font-size: 13px;
    }

    .price-text {
        color: #254035;
        font-size: 14px;
        font-weight: 700;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-badge::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .status-active {
        background: #eaf7ef;
        color: #28794c;
    }

    .status-active::before {
        background: #36a866;
    }

    .status-inactive {
        background: #f5f1f1;
        color: #8b5e5e;
    }

    .status-inactive::before {
        background: #a97979;
    }

    .action-group {
        display: flex;
        gap: 6px;
        justify-content: flex-end;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e7ebe9;
        background: #fff;
        color: #68736e;
        transition: .15s ease;
    }

    .action-btn:hover {
        background: #f5f8f6;
        color: #254035;
        border-color: #d7e1dc;
    }

    .action-btn.delete:hover {
        background: #fff5f5;
        color: #b64e4e;
        border-color: #f0dada;
    }

    .empty-state {
        text-align: center;
        padding: 65px 20px;
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        border-radius: 18px;
        background: #edf5f1;
        color: #6B9080;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        font-size: 30px;
    }

    .empty-state h5 {
        color: #254035;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .empty-state p {
        color: #8a938f;
        font-size: 13px;
        max-width: 420px;
        margin: 0 auto 20px;
    }

    .btn-primary-custom {
        background: #254035;
        border: none;
        color: #fff;
        border-radius: 9px;
        padding: 10px 17px;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-primary-custom:hover {
        background: #1d332a;
        color: #fff;
    }

    @media (max-width: 767px) {
        .dashboard-header {
            padding: 22px;
        }

        .dashboard-header h2 {
            font-size: 21px;
        }

        .header-action {
            margin-top: 18px;
        }

        .services-card-header {
            padding: 18px;
        }

        .service-search {
            width: 100%;
            margin-top: 15px;
        }

        .table-responsive {
            overflow-x: auto;
        }
    }
</style>

<div class="provider-dashboard">

    {{-- Dashboard Header --}}
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2>Service Management</h2>
                    <p>
                        Manage the services you offer and keep your provider profile up to date.
                    </p>
                </div>

                <div class="col-lg-4 text-lg-end header-action">
                    <a href="{{ route('serviceProvider.create') }}"
                       class="btn btn-add-service">
                        <i class="mdi mdi-plus me-1"></i>
                        Add New Service
                    </a>
                </div>
            </div>
        </div>
    </div>


    {{-- Statistics --}}
    <div class="row g-3 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Total Services</div>
                        <div class="stat-value">
                            {{ number_format($stats['total']) }}
                        </div>
                    </div>

                    <div class="stat-icon">
                        <i class="mdi mdi-briefcase-outline"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Active Services</div>
                        <div class="stat-value">
                            {{ number_format($stats['active']) }}
                        </div>
                    </div>

                    <div class="stat-icon">
                        <i class="mdi mdi-check-circle-outline"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Inactive Services</div>
                        <div class="stat-value">
                            {{ number_format($stats['inactive']) }}
                        </div>
                    </div>

                    <div class="stat-icon">
                        <i class="mdi mdi-pause-circle-outline"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Categories</div>
                        <div class="stat-value">
                            {{ number_format($stats['categories']) }}
                        </div>
                    </div>

                    <div class="stat-icon">
                        <i class="mdi mdi-shape-outline"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- Services --}}
    <div class="services-card">

        <div class="services-card-header">

            <div class="row align-items-center">

                <div class="col-md-6">
                    <div class="services-title">
                        My Services
                    </div>

                    <p class="services-subtitle">
                        Services currently listed on your provider profile.
                    </p>
                </div>

                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end">
                        <div class="service-search">
                            <i class="mdi mdi-magnify"></i>

                            <input
                                type="text"
                                id="serviceSearch"
                                class="form-control"
                                placeholder="Search services..."
                            >
                        </div>
                    </div>
                </div>

            </div>

        </div>


        @if($services->count())

            <div class="table-responsive">

                <table class="table service-table" id="servicesTable">

                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($services as $service)

                            <tr class="service-row">

                                {{-- Service --}}
                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        <img
                                            src="{{ asset('image/services/' . ($service->image ?: 'default.png')) }}"
                                            alt="{{ $service->name }}"
                                            class="service-image"
                                            onerror="this.onerror=null;this.src='{{ asset('image/services/default.png') }}';"
                                        >

                                        <div>
                                            <div class="service-name">
                                                {{ $service->name }}
                                            </div>

                                            @if($service->slug)
                                                <div class="service-slug">
                                                    /{{ $service->slug }}
                                                </div>
                                            @endif
                                        </div>

                                    </div>

                                </td>


                                {{-- Category --}}
                                <td>

                                    <span class="category-text">
                                        {{ $service->category?->name ?? 'Uncategorized' }}
                                    </span>

                                </td>


                                {{-- Price --}}
                                <td>

                                    <span class="price-text">
                                        {{ number_format((float) $service->price) }}
                                        <small class="text-muted">{{ $currency }}</small>
                                    </span>

                                </td>


                                {{-- Status --}}
                                <td>

                                    @if($service->status)

                                        <span class="status-badge status-active">
                                            Active
                                        </span>

                                    @else

                                        <span class="status-badge status-inactive">
                                            Inactive
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="action-group">

                                        {{-- View --}}
                                        <a
                                            href="{{ route('serviceProvider.show', $service->slug) }}"
                                            class="action-btn"
                                            title="View service"
                                        >
                                            <i class="mdi mdi-eye-outline"></i>
                                        </a>


                                        {{-- Edit --}}
                                        @if(Route::has('serviceProvider.edit'))

                                            <a
                                                href="{{ route('serviceProvider.edit', $service->id) }}"
                                                class="action-btn"
                                                title="Edit service"
                                            >
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </a>

                                        @endif


                                        {{-- Delete --}}
                                        <form
                                            action="{{ route('serviceProvider.destroy', $service->id) }}"
                                            method="POST"
                                            class="delete-service-form"
                                            style="display:inline;"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn delete"
                                                title="Delete service"
                                            >
                                                <i class="mdi mdi-delete-outline"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            {{-- Empty State --}}
            <div class="empty-state">

                <div class="empty-icon">
                    <i class="mdi mdi-briefcase-plus-outline"></i>
                </div>

                <h5>No services yet</h5>

                <p>
                    Start building your service profile by adding the services
                    you provide to customers.
                </p>

                <a
                    href="{{ route('serviceProvider.create') }}"
                    class="btn btn-primary-custom"
                >
                    <i class="mdi mdi-plus me-1"></i>
                    Add Your First Service
                </a>

            </div>

        @endif

    </div>

</div>


{{-- Search --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('serviceSearch');

    if (searchInput) {

        searchInput.addEventListener('keyup', function () {

            const query = this.value.toLowerCase().trim();

            document.querySelectorAll('.service-row').forEach(function (row) {

                const text = row.textContent.toLowerCase();

                row.style.display = text.includes(query)
                    ? ''
                    : 'none';

            });

        });

    }


    {{-- Delete confirmation --}}
    document.querySelectorAll('.delete-service-form').forEach(function (form) {

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