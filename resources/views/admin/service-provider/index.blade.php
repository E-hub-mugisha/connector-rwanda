@extends('layouts.app')

@section('title', 'Service Providers')

@section('content')

@php
    $currentSearch = request('search');
    $currentStatus = request('status');
    $currentCategory = request('category');
    $currentSort = request('sort', 'latest');

    $providerCount = method_exists($sproviders, 'total')
        ? $sproviders->total()
        : $sproviders->count();
@endphp


<style>

    /*
    |--------------------------------------------------------------------------
    | PAGE
    |--------------------------------------------------------------------------
    */

    .providers-page {
        min-height: 100vh;
        background: #f4f8f6;
        padding: 28px 0 50px;
    }


    /*
    |--------------------------------------------------------------------------
    | PAGE HEADER
    |--------------------------------------------------------------------------
    */

    .providers-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 25px;
    }

    .providers-eyebrow {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #6b9080;
        font-size: 11px;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 7px;
    }

    .providers-eyebrow i {
        font-size: 15px;
    }

    .providers-title {
        margin: 0;
        color: #254035;
        font-size: 28px;
        line-height: 1.2;
        font-weight: 800;
    }

    .providers-description {
        max-width: 650px;
        margin: 7px 0 0;
        color: #7b8983;
        font-size: 13px;
        line-height: 1.65;
    }

    .btn-add-provider {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 42px;
        padding: 9px 16px;
        border: 0;
        border-radius: 9px;
        background: #254035;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: .2s ease;
    }

    .btn-add-provider:hover {
        background: #315646;
        color: #fff;
        transform: translateY(-1px);
    }


    /*
    |--------------------------------------------------------------------------
    | STAT CARDS
    |--------------------------------------------------------------------------
    */

    .provider-stat-card {
        position: relative;
        overflow: hidden;
        height: 100%;
        padding: 18px;
        background: #fff;
        border: 1px solid #e4ece8;
        border-radius: 14px;
        box-shadow: 0 4px 16px rgba(37,64,53,.035);
    }

    .provider-stat-card::after {
        content: "";
        position: absolute;
        width: 85px;
        height: 85px;
        border-radius: 50%;
        right: -35px;
        top: -40px;
        background: #f0f6f3;
    }

    .provider-stat-top {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .provider-stat-icon {
        width: 39px;
        height: 39px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #edf5f1;
        color: #254035;
        font-size: 18px;
    }

    .provider-stat-label {
        color: #8b9792;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .provider-stat-value {
        margin-top: 5px;
        color: #254035;
        font-size: 23px;
        font-weight: 800;
        line-height: 1;
    }

    .provider-stat-note {
        position: relative;
        z-index: 1;
        margin-top: 13px;
        color: #87928d;
        font-size: 10px;
    }


    /*
    |--------------------------------------------------------------------------
    | MAIN CARD
    |--------------------------------------------------------------------------
    */

    .providers-card {
        overflow: hidden;
        margin-top: 25px;
        background: #fff;
        border: 1px solid #e4ece8;
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(37,64,53,.045);
    }


    /*
    |--------------------------------------------------------------------------
    | TOOLBAR
    |--------------------------------------------------------------------------
    */

    .providers-toolbar {
        padding: 18px 20px;
        border-bottom: 1px solid #edf2ef;
    }

    .toolbar-heading {
        margin: 0;
        color: #254035;
        font-size: 15px;
        font-weight: 750;
    }

    .toolbar-subheading {
        margin: 4px 0 0;
        color: #8b9691;
        font-size: 11px;
    }

    .toolbar-row {
        display: flex;
        align-items: flex-end;
        gap: 10px;
        margin-top: 17px;
    }

    .filter-field {
        flex: 1;
        min-width: 150px;
    }

    .filter-label {
        display: block;
        margin-bottom: 6px;
        color: #66746e;
        font-size: 10px;
        font-weight: 700;
    }

    .filter-control {
        width: 100%;
        min-height: 39px;
        padding: 7px 11px;
        border: 1px solid #dfe8e4;
        border-radius: 8px;
        background: #fff;
        color: #254035;
        font-size: 11px;
        outline: none;
        box-shadow: none;
    }

    .filter-control:focus {
        border-color: #6b9080;
        box-shadow: 0 0 0 3px rgba(107,144,128,.10);
    }

    .search-wrapper {
        position: relative;
    }

    .search-wrapper i {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #9aa6a1;
        font-size: 16px;
        pointer-events: none;
    }

    .search-wrapper .filter-control {
        padding-left: 35px;
    }

    .btn-filter {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-height: 39px;
        padding: 7px 13px;
        border: 0;
        border-radius: 8px;
        background: #254035;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .btn-filter:hover {
        background: #315646;
        color: #fff;
    }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 39px;
        padding: 7px 11px;
        border: 1px solid #dfe8e4;
        border-radius: 8px;
        background: #fff;
        color: #65736d;
        font-size: 11px;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-reset:hover {
        background: #f5f8f6;
        color: #254035;
    }


    /*
    |--------------------------------------------------------------------------
    | ALERT
    |--------------------------------------------------------------------------
    */

    .provider-alert {
        margin: 18px 20px 0;
        padding: 11px 13px;
        border: 1px solid #cfe5d9;
        border-radius: 9px;
        background: #f0f8f4;
        color: #315f4c;
        font-size: 12px;
    }


    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    .providers-table-wrapper {
        overflow-x: auto;
    }

    .providers-table {
        width: 100%;
        min-width: 980px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .providers-table thead th {
        padding: 12px 15px;
        border-bottom: 1px solid #e8efec;
        background: #fafcfb;
        color: #89958f;
        font-size: 9px;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: .06em;
        white-space: nowrap;
    }

    .providers-table tbody td {
        padding: 13px 15px;
        border-bottom: 1px solid #edf2ef;
        vertical-align: middle;
        color: #56655e;
        font-size: 11px;
    }

    .providers-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .providers-table tbody tr {
        transition: background .15s ease;
    }

    .providers-table tbody tr:hover {
        background: #fbfdfc;
    }


    /*
    |--------------------------------------------------------------------------
    | PROVIDER ID
    |--------------------------------------------------------------------------
    */

    .provider-id {
        color: #9aa5a0;
        font-size: 10px;
        font-weight: 700;
    }


    /*
    |--------------------------------------------------------------------------
    | PROVIDER PROFILE
    |--------------------------------------------------------------------------
    */

    .provider-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 190px;
    }

    .provider-avatar {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #eaf3ef;
        color: #254035;
        font-size: 13px;
        font-weight: 800;
    }

    .provider-avatar img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .provider-profile-name {
        color: #254035;
        font-size: 12px;
        font-weight: 750;
        line-height: 1.3;
    }

    .provider-profile-phone {
        margin-top: 3px;
        color: #98a29e;
        font-size: 10px;
    }


    /*
    |--------------------------------------------------------------------------
    | CATEGORY
    |--------------------------------------------------------------------------
    */

    .category-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 8px;
        border-radius: 7px;
        background: #f0f5f3;
        color: #53675f;
        font-size: 10px;
        font-weight: 650;
        white-space: nowrap;
    }

    .category-pill i {
        color: #6b9080;
        font-size: 13px;
    }


    /*
    |--------------------------------------------------------------------------
    | LOCATION
    |--------------------------------------------------------------------------
    */

    .provider-location {
        display: flex;
        align-items: flex-start;
        gap: 5px;
        max-width: 180px;
        color: #65736d;
        line-height: 1.45;
    }

    .provider-location i {
        flex: 0 0 auto;
        color: #6b9080;
        font-size: 14px;
        margin-top: 1px;
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 9px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 750;
        text-transform: capitalize;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .status-approved {
        background: #e9f6ef;
        color: #28734d;
    }

    .status-approved .status-dot {
        background: #36a269;
    }

    .status-pending {
        background: #fff7e7;
        color: #9b6a1c;
    }

    .status-pending .status-dot {
        background: #d99a32;
    }

    .status-rejected,
    .status-declined {
        background: #fff0f0;
        color: #b34c4c;
    }

    .status-rejected .status-dot,
    .status-declined .status-dot {
        background: #c95d5d;
    }

    .status-default {
        background: #f0f3f2;
        color: #68746f;
    }

    .status-default .status-dot {
        background: #929c98;
    }


    /*
    |--------------------------------------------------------------------------
    | SERVICE COUNT
    |--------------------------------------------------------------------------
    */

    .service-count {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #52645b;
        font-size: 11px;
        font-weight: 700;
    }

    .service-count i {
        color: #6b9080;
        font-size: 14px;
    }


    /*
    |--------------------------------------------------------------------------
    | DATE
    |--------------------------------------------------------------------------
    */

    .created-date {
        color: #7e8a85;
        white-space: nowrap;
    }

    .created-date strong {
        display: block;
        color: #52625a;
        font-size: 10px;
        font-weight: 700;
    }

    .created-date span {
        display: block;
        margin-top: 2px;
        color: #a0aaa6;
        font-size: 9px;
    }


    /*
    |--------------------------------------------------------------------------
    | ACTION
    |--------------------------------------------------------------------------
    */

    .btn-view-provider {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 7px 10px;
        border: 1px solid #dce7e2;
        border-radius: 8px;
        background: #fff;
        color: #254035;
        font-size: 10px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
        white-space: nowrap;
    }

    .btn-view-provider:hover {
        background: #edf5f1;
        border-color: #cbdcd4;
        color: #254035;
    }


    /*
    |--------------------------------------------------------------------------
    | EMPTY
    |--------------------------------------------------------------------------
    */

    .providers-empty {
        padding: 65px 20px;
        text-align: center;
    }

    .providers-empty-icon {
        width: 65px;
        height: 65px;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 17px;
        background: #eaf3ef;
        color: #254035;
        font-size: 27px;
    }

    .providers-empty h5 {
        color: #254035;
        font-size: 15px;
        font-weight: 750;
        margin-bottom: 6px;
    }

    .providers-empty p {
        max-width: 440px;
        margin: 0 auto 18px;
        color: #89958f;
        font-size: 12px;
        line-height: 1.6;
    }


    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    */

    .providers-pagination {
        padding: 17px 20px;
        border-top: 1px solid #edf2ef;
    }

    .providers-pagination .pagination {
        margin: 0;
        justify-content: flex-end;
    }

    .providers-pagination .page-link {
        min-width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 4px;
        padding: 4px 9px;
        border: 1px solid #dfe8e4;
        border-radius: 7px !important;
        color: #52645b;
        background: #fff;
        font-size: 10px;
        box-shadow: none;
    }

    .providers-pagination .page-item.active .page-link {
        border-color: #254035;
        background: #254035;
        color: #fff;
    }

    .providers-pagination .page-item.disabled .page-link {
        color: #b1bab6;
        background: #f8faf9;
    }


    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 991px) {

        .providers-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .toolbar-row {
            flex-wrap: wrap;
        }

        .filter-field {
            min-width: calc(50% - 10px);
        }

    }

    @media (max-width: 575px) {

        .providers-page {
            padding-top: 20px;
        }

        .providers-title {
            font-size: 23px;
        }

        .btn-add-provider {
            width: 100%;
        }

        .toolbar-row {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-field {
            width: 100%;
            min-width: 100%;
        }

        .btn-filter,
        .btn-reset {
            width: 100%;
        }

        .provider-stat-value {
            font-size: 20px;
        }

    }

</style>


<div class="providers-page">

    <div class="container-fluid px-3 px-lg-4">


        {{-- =====================================================
            PAGE HEADER
        ====================================================== --}}

        <div class="providers-header">

            <div>

                <div class="providers-eyebrow">

                    <i class="mdi mdi-account-group-outline"></i>

                    Provider Management

                </div>

                <h1 class="providers-title">
                    Service Providers
                </h1>

                <p class="providers-description">
                    Manage registered service providers, their categories,
                    locations, services and account status.
                </p>

            </div>


            <a href="{{ route('admin.AddServiceProviders') }}"
               class="btn-add-provider">

                <i class="mdi mdi-plus"></i>

                Add Service Provider

            </a>

        </div>


        {{-- =====================================================
            STATISTICS
        ====================================================== --}}

        <div class="row g-3">


            <div class="col-6 col-xl-3">

                <div class="provider-stat-card">

                    <div class="provider-stat-top">

                        <div>

                            <div class="provider-stat-label">
                                Total Providers
                            </div>

                            <div class="provider-stat-value">
                                {{ number_format($totalProviders) }}
                            </div>

                        </div>

                        <div class="provider-stat-icon">

                            <i class="mdi mdi-account-group-outline"></i>

                        </div>

                    </div>

                    <div class="provider-stat-note">
                        All registered providers
                    </div>

                </div>

            </div>


            <div class="col-6 col-xl-3">

                <div class="provider-stat-card">

                    <div class="provider-stat-top">

                        <div>

                            <div class="provider-stat-label">
                                Approved
                            </div>

                            <div class="provider-stat-value">
                                {{ number_format($approvedProviders) }}
                            </div>

                        </div>

                        <div class="provider-stat-icon">

                            <i class="mdi mdi-check-circle-outline"></i>

                        </div>

                    </div>

                    <div class="provider-stat-note">
                        Approved service providers
                    </div>

                </div>

            </div>


            <div class="col-6 col-xl-3">

                <div class="provider-stat-card">

                    <div class="provider-stat-top">

                        <div>

                            <div class="provider-stat-label">
                                Pending
                            </div>

                            <div class="provider-stat-value">
                                {{ number_format($pendingProviders) }}
                            </div>

                        </div>

                        <div class="provider-stat-icon">

                            <i class="mdi mdi-clock-outline"></i>

                        </div>

                    </div>

                    <div class="provider-stat-note">
                        Awaiting review
                    </div>

                </div>

            </div>


            <div class="col-6 col-xl-3">

                <div class="provider-stat-card">

                    <div class="provider-stat-top">

                        <div>

                            <div class="provider-stat-label">
                                Total Services
                            </div>

                            <div class="provider-stat-value">
                                {{ number_format($totalServices) }}
                            </div>

                        </div>

                        <div class="provider-stat-icon">

                            <i class="mdi mdi-briefcase-outline"></i>

                        </div>

                    </div>

                    <div class="provider-stat-note">
                        Services offered
                    </div>

                </div>

            </div>


        </div>


        {{-- =====================================================
            MAIN PROVIDERS CARD
        ====================================================== --}}

        <div class="providers-card">


            {{-- =================================================
                TOOLBAR
            ================================================== --}}

            <div class="providers-toolbar">

                <div>

                    <h2 class="toolbar-heading">
                        Provider Directory
                    </h2>

                    <p class="toolbar-subheading">

                        Showing
                        <strong>{{ $providerCount }}</strong>
                        {{ $providerCount == 1 ? 'provider' : 'providers' }}

                    </p>

                </div>


                <form method="GET"
                      action="{{ route('admin.service_providers') }}">

                    <div class="toolbar-row">


                        {{-- SEARCH --}}

                        <div class="filter-field">

                            <label class="filter-label">
                                Search
                            </label>

                            <div class="search-wrapper">

                                <i class="mdi mdi-magnify"></i>

                                <input type="text"
                                       name="search"
                                       class="filter-control"
                                       value="{{ $currentSearch }}"
                                       placeholder="Name, phone, location...">

                            </div>

                        </div>


                        {{-- STATUS --}}

                        <div class="filter-field">

                            <label class="filter-label">
                                Status
                            </label>

                            <select name="status"
                                    class="filter-control">

                                <option value="">
                                    All statuses
                                </option>

                                <option value="approved"
                                    @selected($currentStatus === 'approved')>
                                    Approved
                                </option>

                                <option value="pending"
                                    @selected($currentStatus === 'pending')>
                                    Pending
                                </option>

                                <option value="rejected"
                                    @selected($currentStatus === 'rejected')>
                                    Rejected
                                </option>

                            </select>

                        </div>


                        {{-- CATEGORY --}}

                        <div class="filter-field">

                            <label class="filter-label">
                                Category
                            </label>

                            <select name="category"
                                    class="filter-control">

                                <option value="">
                                    All categories
                                </option>

                                @foreach($categories as $category)

                                    <option value="{{ $category->id }}"
                                        @selected((string) $currentCategory === (string) $category->id)>

                                        {{ $category->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- SORT --}}

                        <div class="filter-field">

                            <label class="filter-label">
                                Sort
                            </label>

                            <select name="sort"
                                    class="filter-control">

                                <option value="latest"
                                    @selected($currentSort === 'latest')>
                                    Newest first
                                </option>

                                <option value="oldest"
                                    @selected($currentSort === 'oldest')>
                                    Oldest first
                                </option>

                                <option value="name"
                                    @selected($currentSort === 'name')>
                                    Name A-Z
                                </option>

                                <option value="services"
                                    @selected($currentSort === 'services')>
                                    Most services
                                </option>

                            </select>

                        </div>


                        <button type="submit"
                                class="btn-filter">

                            <i class="mdi mdi-filter-outline"></i>

                            Filter

                        </button>


                        @if(
                            $currentSearch
                            || $currentStatus
                            || $currentCategory
                            || $currentSort !== 'latest'
                        )

                            <a href="{{ route('admin.ServiceProviders') }}"
                               class="btn-reset">

                                Reset

                            </a>

                        @endif


                    </div>

                </form>

            </div>


            {{-- =================================================
                SUCCESS MESSAGE
            ================================================== --}}

            @if(Session::has('message'))

                <div class="provider-alert">

                    <i class="mdi mdi-check-circle-outline me-1"></i>

                    {{ Session::get('message') }}

                </div>

            @endif


            {{-- =================================================
                TABLE
            ================================================== --}}

            <div class="providers-table-wrapper">

                @if($sproviders->count())

                    <table class="providers-table">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>
                                    Provider
                                </th>

                                <th>
                                    Category
                                </th>

                                <th>
                                    Location
                                </th>

                                <th>
                                    Services
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Created
                                </th>

                                <th class="text-end">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($sproviders as $sprovider)

                                @php

                                    $providerName =
                                        $sprovider->user?->name
                                        ?? 'Unknown Provider';

                                    $providerPhone =
                                        $sprovider->user?->phone
                                        ?? null;

                                    $providerImage =
                                        $sprovider->image
                                        ? asset(
                                            'image/profile/' .
                                            $sprovider->image
                                        )
                                        : asset(
                                            'assets/images/sproviders/avatar.jpg'
                                        );

                                    $status =
                                        strtolower(
                                            $sprovider->status ?? 'unknown'
                                        );

                                    $statusClass =
                                        match ($status) {

                                            'approved'
                                                => 'status-approved',

                                            'pending'
                                                => 'status-pending',

                                            'rejected'
                                                => 'status-rejected',

                                            'declined'
                                                => 'status-declined',

                                            default
                                                => 'status-default',
                                        };

                                    $initials =
                                        collect(
                                            preg_split(
                                                '/\s+/',
                                                trim($providerName)
                                            )
                                        )
                                        ->filter()
                                        ->take(2)
                                        ->map(
                                            fn ($name) =>
                                                strtoupper(
                                                    substr(
                                                        $name,
                                                        0,
                                                        1
                                                    )
                                                )
                                        )
                                        ->implode('');

                                @endphp


                                <tr>


                                    {{-- ID --}}

                                    <td>

                                        <span class="provider-id">

                                            #{{ $sprovider->id }}

                                        </span>

                                    </td>


                                    {{-- PROVIDER --}}

                                    <td>

                                        <div class="provider-profile">


                                            <div class="provider-avatar">

                                                <img src="{{ $providerImage }}"
                                                     alt="{{ $providerName }}"
                                                     onerror="this.onerror=null;this.src='{{ asset('assets/images/sproviders/avatar.jpg') }}';">

                                            </div>


                                            <div>

                                                <div class="provider-profile-name">

                                                    {{ $providerName }}

                                                </div>


                                                @if($providerPhone)

                                                    <div class="provider-profile-phone">

                                                        <i class="mdi mdi-phone-outline"></i>

                                                        {{ $providerPhone }}

                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- CATEGORY --}}

                                    <td>

                                        <span class="category-pill">

                                            <i class="mdi mdi-shape-outline"></i>

                                            {{ $sprovider->category?->name ?? 'No Category' }}

                                        </span>

                                    </td>


                                    {{-- LOCATION --}}

                                    <td>

                                        <div class="provider-location">

                                            <i class="mdi mdi-map-marker-outline"></i>

                                            <span>

                                                {{ $sprovider->service_locations ?: 'Location not specified' }}

                                            </span>

                                        </div>

                                    </td>


                                    {{-- SERVICES --}}

                                    <td>

                                        <span class="service-count">

                                            <i class="mdi mdi-briefcase-outline"></i>

                                            {{ $sprovider->services_count }}

                                        </span>

                                    </td>


                                    {{-- STATUS --}}

                                    <td>

                                        <span class="status-pill {{ $statusClass }}">

                                            <span class="status-dot"></span>

                                            {{ ucfirst($status) }}

                                        </span>

                                    </td>


                                    {{-- CREATED --}}

                                    <td>

                                        <div class="created-date">

                                            <strong>
                                                {{ optional($sprovider->created_at)->format('d M Y') }}
                                            </strong>

                                            <span>
                                                {{ optional($sprovider->created_at)->format('H:i') }}
                                            </span>

                                        </div>

                                    </td>


                                    {{-- ACTION --}}

                                    <td class="text-end">

                                        <a href="{{ route(
                                            'admin.ShowServiceProviders',
                                            $sprovider->id
                                        ) }}"
                                           class="btn-view-provider">

                                            <i class="mdi mdi-eye-outline"></i>

                                            View

                                        </a>

                                    </td>


                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else


                    <div class="providers-empty">

                        <div class="providers-empty-icon">

                            <i class="mdi mdi-account-search-outline"></i>

                        </div>

                        <h5>
                            No service providers found
                        </h5>

                        <p>

                            No providers match your current search or
                            filter criteria.

                        </p>


                        @if(
                            $currentSearch
                            || $currentStatus
                            || $currentCategory
                            || $currentSort !== 'latest'
                        )

                            <a href="{{ route('admin.ServiceProviders') }}"
                               class="btn-add-provider">

                                <i class="mdi mdi-refresh"></i>

                                Clear Filters

                            </a>

                        @else

                            <a href="{{ route('admin.AddServiceProviders') }}"
                               class="btn-add-provider">

                                <i class="mdi mdi-plus"></i>

                                Add Service Provider

                            </a>

                        @endif

                    </div>

                @endif

            </div>


            {{-- =================================================
                PAGINATION
            ================================================== --}}

            @if(
                method_exists($sproviders, 'hasPages')
                && $sproviders->hasPages()
            )

                <div class="providers-pagination">

                    {{ $sproviders->links() }}

                </div>

            @endif


        </div>

    </div>

</div>

@endsection