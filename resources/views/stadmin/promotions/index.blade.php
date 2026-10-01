@extends('layouts.app')

@section('title', 'Promotions')

@section('content')

@php
    $today = now()->startOfDay();

    $totalPromotions = $promotions->count();

    $activePromotions = $promotions->filter(function ($promotion) use ($today) {
        return $promotion->start_date
            && $promotion->end_date
            && $promotion->start_date->startOfDay()->lte($today)
            && $promotion->end_date->endOfDay()->gte($today);
    })->count();

    $upcomingPromotions = $promotions->filter(function ($promotion) use ($today) {
        return $promotion->start_date
            && $promotion->start_date->startOfDay()->gt($today);
    })->count();

    $expiredPromotions = $promotions->filter(function ($promotion) use ($today) {
        return $promotion->end_date
            && $promotion->end_date->endOfDay()->lt($today);
    })->count();

    $averageDiscount = $promotions->count()
        ? round((float) $promotions->avg('discount'), 1)
        : 0;
@endphp

<style>
    :root {
        --connector-green: #6B9080;
        --connector-dark: #254035;
        --connector-light: #F4F8F6;
        --connector-border: #E2EBE6;
        --connector-muted: #77847E;
        --connector-bg: #F7F9F8;
        --connector-white: #FFFFFF;
        --connector-success: #4D896B;
        --connector-warning: #B78632;
        --connector-danger: #B85C5C;
    }

    .promotions-page {
        min-height: calc(100vh - 70px);
        background: var(--connector-bg);
        padding: 28px;
    }

    /* =========================================================
       HEADER
    ========================================================= */

    .promotion-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(
            135deg,
            #254035 0%,
            #315847 58%,
            #6B9080 100%
        );
        border-radius: 18px;
        padding: 30px;
        margin-bottom: 24px;
        color: #fff;
    }

    .promotion-hero::before {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border: 1px solid rgba(255,255,255,.10);
        border-radius: 50%;
        right: -100px;
        top: -130px;
    }

    .promotion-hero::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 50%;
        right: 100px;
        bottom: -125px;
    }

    .promotion-hero-content {
        position: relative;
        z-index: 2;
    }

    .promotion-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.1px;
        color: rgba(255,255,255,.70);
        margin-bottom: 8px;
    }

    .promotion-eyebrow i {
        font-size: 13px;
    }

    .promotion-hero h2 {
        margin: 0 0 8px;
        font-size: 28px;
        font-weight: 750;
        letter-spacing: -.4px;
    }

    .promotion-hero p {
        margin: 0;
        max-width: 650px;
        color: rgba(255,255,255,.78);
        font-size: 13px;
        line-height: 1.7;
    }

    .btn-add-promotion {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #fff;
        color: var(--connector-dark);
        border: 0;
        border-radius: 10px;
        padding: 11px 18px;
        font-size: 12px;
        font-weight: 750;
        transition: all .2s ease;
    }

    .btn-add-promotion:hover {
        background: #f0f5f2;
        color: var(--connector-dark);
        transform: translateY(-1px);
    }

    /* =========================================================
       STATISTICS
    ========================================================= */

    .promotion-stat-card {
        height: 100%;
        background: var(--connector-white);
        border: 1px solid var(--connector-border);
        border-radius: 15px;
        padding: 18px;
        transition: all .2s ease;
    }

    .promotion-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(37,64,53,.07);
    }

    .promotion-stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .promotion-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        background: var(--connector-light);
        color: var(--connector-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .promotion-stat-label {
        color: var(--connector-muted);
        font-size: 11px;
        font-weight: 650;
        margin-bottom: 5px;
    }

    .promotion-stat-value {
        color: var(--connector-dark);
        font-size: 25px;
        line-height: 1;
        font-weight: 750;
    }

    /* =========================================================
       MAIN CARD
    ========================================================= */

    .promotion-main-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 17px;
        overflow: hidden;
    }

    .promotion-main-header {
        padding: 20px 23px;
        border-bottom: 1px solid var(--connector-border);
    }

    .promotion-main-title {
        color: var(--connector-dark);
        font-size: 16px;
        font-weight: 750;
        margin: 0;
    }

    .promotion-main-subtitle {
        color: var(--connector-muted);
        font-size: 11px;
        margin: 5px 0 0;
    }

    .promotion-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 11px;
        border-radius: 20px;
        background: var(--connector-light);
        color: var(--connector-dark);
        font-size: 10px;
        font-weight: 700;
    }

    /* =========================================================
       TABLE
    ========================================================= */

    .promotion-table {
        margin: 0;
        min-width: 1000px;
    }

    .promotion-table thead th {
        background: #FAFCFB;
        color: #75827C;
        border-bottom: 1px solid var(--connector-border);
        padding: 13px 17px;
        font-size: 10px;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    .promotion-table tbody td {
        padding: 16px 17px;
        border-bottom: 1px solid #EDF2EF;
        vertical-align: middle;
        font-size: 12px;
        color: #4F5E57;
    }

    .promotion-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .promotion-table tbody tr {
        transition: background .15s ease;
    }

    .promotion-table tbody tr:hover {
        background: #FBFDFC;
    }

    /* =========================================================
       PROMOTION INFO
    ========================================================= */

    .promotion-info {
        min-width: 190px;
    }

    .promotion-name {
        color: var(--connector-dark);
        font-size: 13px;
        font-weight: 750;
        margin-bottom: 4px;
    }

    .promotion-description {
        max-width: 230px;
        color: var(--connector-muted);
        font-size: 10px;
        line-height: 1.5;

        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* =========================================================
       SERVICE
    ========================================================= */

    .service-info {
        min-width: 160px;
    }

    .service-name {
        color: var(--connector-dark);
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .service-category {
        color: var(--connector-muted);
        font-size: 10px;
    }

    /* =========================================================
       DISCOUNT
    ========================================================= */

    .discount-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 58px;
        padding: 6px 9px;
        border-radius: 8px;
        background: #EDF7F2;
        color: var(--connector-success);
        font-size: 11px;
        font-weight: 750;
    }

    /* =========================================================
       PRICE
    ========================================================= */

    .service-price {
        color: var(--connector-dark);
        font-size: 12px;
        font-weight: 750;
        white-space: nowrap;
    }

    .price-label {
        color: var(--connector-muted);
        font-size: 9px;
        margin-top: 2px;
    }

    /* =========================================================
       STATUS
    ========================================================= */

    .promotion-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 750;
        letter-spacing: .35px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .promotion-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .status-active {
        background: #EDF7F2;
        color: #39765A;
    }

    .status-active .promotion-status-dot {
        background: #4D896B;
    }

    .status-upcoming {
        background: #FFF7E8;
        color: #97702F;
    }

    .status-upcoming .promotion-status-dot {
        background: #B78632;
    }

    .status-expired {
        background: #F9EEEE;
        color: #995252;
    }

    .status-expired .promotion-status-dot {
        background: #B85C5C;
    }

    /* =========================================================
       DATES
    ========================================================= */

    .promotion-dates {
        white-space: nowrap;
        font-size: 10px;
    }

    .date-label {
        color: var(--connector-muted);
        font-size: 9px;
        margin-right: 3px;
    }

    .date-value {
        color: #46554E;
        font-weight: 650;
    }

    .date-separator {
        color: #A5B0AB;
        margin: 0 5px;
    }

    /* =========================================================
       ACTION
    ========================================================= */

    .promotion-action {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        color: var(--connector-green);
        border: 1px solid var(--connector-border);
        border-radius: 9px;
        transition: all .2s ease;
    }

    .promotion-action:hover {
        background: var(--connector-light);
        border-color: var(--connector-green);
        color: var(--connector-dark);
    }

    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .promotion-empty {
        text-align: center;
        padding: 70px 25px;
    }

    .promotion-empty-icon {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        background: var(--connector-light);
        color: var(--connector-green);
        border-radius: 18px;
        font-size: 28px;
    }

    .promotion-empty h5 {
        color: var(--connector-dark);
        font-size: 16px;
        font-weight: 750;
        margin-bottom: 7px;
    }

    .promotion-empty p {
        max-width: 420px;
        margin: 0 auto 20px;
        color: var(--connector-muted);
        font-size: 12px;
        line-height: 1.7;
    }

    /* =========================================================
       MODALS
    ========================================================= */

    .promotion-modal .modal-content {
        border: 0;
        border-radius: 17px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(37,64,53,.18);
    }

    .promotion-modal .modal-header {
        background: var(--connector-dark);
        color: #fff;
        border: 0;
        padding: 19px 23px;
    }

    .promotion-modal .modal-title {
        font-size: 16px;
        font-weight: 750;
        margin: 0;
    }

    .modal-subtitle {
        color: rgba(255,255,255,.65);
        font-size: 10px;
        margin-top: 3px;
    }

    .promotion-modal .btn-close {
        filter: brightness(0) invert(1);
        opacity: .75;
    }

    .promotion-modal .modal-body {
        padding: 24px;
        max-height: 72vh;
        overflow-y: auto;
    }

    .promotion-modal .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .promotion-modal .modal-body::-webkit-scrollbar-thumb {
        background: #CCD8D2;
        border-radius: 10px;
    }

    .form-section {
        margin-bottom: 20px;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--connector-dark);
        font-size: 11px;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: .65px;
        margin-bottom: 14px;
    }

    .form-section-title i {
        color: var(--connector-green);
        font-size: 14px;
    }

    .promotion-label {
        color: #46554E;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .promotion-input,
    .promotion-select {
        min-height: 43px;
        border: 1px solid #DFE8E3;
        border-radius: 9px;
        color: #35453E;
        font-size: 12px;
        padding: 9px 12px;
        background: #fff;
    }

    .promotion-input:focus,
    .promotion-select:focus {
        border-color: var(--connector-green);
        box-shadow: 0 0 0 3px rgba(107,144,128,.12);
    }

    textarea.promotion-input {
        min-height: 105px;
        resize: vertical;
    }

    .input-group .promotion-input {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .input-group-text {
        border: 1px solid #DFE8E3;
        background: var(--connector-light);
        color: var(--connector-dark);
        font-weight: 700;
        font-size: 12px;
    }

    .promotion-form-help {
        color: var(--connector-muted);
        font-size: 9px;
        margin-top: 5px;
    }

    .promotion-modal-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 9px;
        padding: 15px 23px;
        border-top: 1px solid var(--connector-border);
        background: #FCFDFC;
    }

    .btn-modal-cancel {
        background: #fff;
        color: #627069;
        border: 1px solid var(--connector-border);
        border-radius: 9px;
        padding: 9px 16px;
        font-size: 11px;
        font-weight: 700;
    }

    .btn-modal-cancel:hover {
        background: #f6f8f7;
        color: var(--connector-dark);
    }

    .btn-modal-save {
        background: var(--connector-green);
        color: #fff;
        border: 0;
        border-radius: 9px;
        padding: 9px 17px;
        font-size: 11px;
        font-weight: 750;
    }

    .btn-modal-save:hover {
        background: var(--connector-dark);
        color: #fff;
    }

    /* =========================================================
       VALIDATION
    ========================================================= */

    .invalid-feedback {
        font-size: 10px;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {
        .promotions-page {
            padding: 18px;
        }

        .promotion-hero {
            padding: 24px;
        }

        .promotion-hero h2 {
            font-size: 24px;
        }

        .btn-add-promotion {
            margin-top: 18px;
        }
    }

    @media (max-width: 575.98px) {
        .promotions-page {
            padding: 12px;
        }

        .promotion-hero {
            padding: 20px;
            border-radius: 14px;
        }

        .promotion-hero h2 {
            font-size: 21px;
        }

        .promotion-main-card {
            border-radius: 13px;
        }

        .promotion-table {
            min-width: 1000px;
        }

        .promotion-modal .modal-body {
            padding: 18px;
        }

        .promotion-modal-footer {
            padding: 14px 18px;
        }
    }
</style>


<div class="promotions-page">

    {{-- =====================================================
         FLASH MESSAGE
    ====================================================== --}}

    @if(session('success'))

        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
        </div>

    @endif


    {{-- =====================================================
         VALIDATION ERRORS
    ====================================================== --}}

    @if($errors->any())

        <div class="alert alert-danger border-0 shadow-sm mb-4">

            <div class="fw-bold mb-1">
                Please correct the following:
            </div>

            <ul class="mb-0 ps-3 small">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <div class="promotion-hero">

        <div class="promotion-hero-content">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <div class="promotion-eyebrow">
                        <i class="bi bi-megaphone"></i>
                        Service Marketing
                    </div>

                    <h2>
                        Promotions
                    </h2>

                    <p>
                        Create special offers for your services, manage
                        promotion periods and keep your customers informed
                        about your latest deals.
                    </p>

                </div>

                <div class="col-lg-4 text-lg-end">

                    <button
                        type="button"
                        class="btn btn-add-promotion"
                        data-bs-toggle="modal"
                        data-bs-target="#addPromotionModal"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Add Promotion
                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="row g-3 mb-4">

        {{-- Total --}}
        <div class="col-xl-3 col-md-6">

            <div class="promotion-stat-card">

                <div class="promotion-stat-top">

                    <div class="promotion-stat-icon">
                        <i class="bi bi-megaphone"></i>
                    </div>

                </div>

                <div class="promotion-stat-label">
                    Total Promotions
                </div>

                <div class="promotion-stat-value">
                    {{ $totalPromotions }}
                </div>

            </div>

        </div>


        {{-- Active --}}
        <div class="col-xl-3 col-md-6">

            <div class="promotion-stat-card">

                <div class="promotion-stat-top">

                    <div class="promotion-stat-icon">
                        <i class="bi bi-lightning-charge"></i>
                    </div>

                </div>

                <div class="promotion-stat-label">
                    Active Promotions
                </div>

                <div class="promotion-stat-value">
                    {{ $activePromotions }}
                </div>

            </div>

        </div>


        {{-- Upcoming --}}
        <div class="col-xl-3 col-md-6">

            <div class="promotion-stat-card">

                <div class="promotion-stat-top">

                    <div class="promotion-stat-icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>

                </div>

                <div class="promotion-stat-label">
                    Upcoming Promotions
                </div>

                <div class="promotion-stat-value">
                    {{ $upcomingPromotions }}
                </div>

            </div>

        </div>


        {{-- Average --}}
        <div class="col-xl-3 col-md-6">

            <div class="promotion-stat-card">

                <div class="promotion-stat-top">

                    <div class="promotion-stat-icon">
                        <i class="bi bi-percent"></i>
                    </div>

                </div>

                <div class="promotion-stat-label">
                    Average Discount
                </div>

                <div class="promotion-stat-value">
                    {{ $averageDiscount }}%
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         PROMOTION LIST
    ====================================================== --}}

    <div class="promotion-main-card">

        <div class="promotion-main-header">

            <div class="d-flex align-items-center justify-content-between gap-3">

                <div>

                    <h5 class="promotion-main-title">
                        Your Promotions
                    </h5>

                    <p class="promotion-main-subtitle">
                        Promotions are attached directly to your services.
                    </p>

                </div>

                <div class="promotion-count">
                    {{ $totalPromotions }}
                    {{ Str::plural('Promotion', $totalPromotions) }}
                </div>

            </div>

        </div>


        @if($promotions->count())

            <div class="table-responsive">

                <table class="table promotion-table">

                    <thead>

                        <tr>

                            <th>
                                Promotion
                            </th>

                            <th>
                                Service
                            </th>

                            <th>
                                Discount
                            </th>

                            <th>
                                Price
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Promotion Period
                            </th>

                            <th class="text-end">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($promotions as $promotion)

                            @php

                                $isActive =
                                    $promotion->start_date &&
                                    $promotion->end_date &&
                                    $promotion->start_date->startOfDay()->lte($today) &&
                                    $promotion->end_date->endOfDay()->gte($today);

                                $isUpcoming =
                                    $promotion->start_date &&
                                    $promotion->start_date->startOfDay()->gt($today);

                                $isExpired =
                                    $promotion->end_date &&
                                    $promotion->end_date->endOfDay()->lt($today);

                            @endphp


                            <tr>

                                {{-- Promotion --}}
                                <td>

                                    <div class="promotion-info">

                                        <div class="promotion-name">
                                            {{ $promotion->title }}
                                        </div>

                                        @if($promotion->description)

                                            <div class="promotion-description">
                                                {{ $promotion->description }}
                                            </div>

                                        @endif

                                    </div>

                                </td>


                                {{-- Service --}}
                                <td>

                                    <div class="service-info">

                                        <div class="service-name">
                                            {{ $promotion->service?->name ?? 'Service unavailable' }}
                                        </div>

                                        <div class="service-category">

                                            {{ $promotion->service?->category?->name ?? 'Uncategorized' }}

                                        </div>

                                    </div>

                                </td>


                                {{-- Discount --}}
                                <td>

                                    <span class="discount-badge">

                                        {{ rtrim(rtrim(number_format((float) $promotion->discount, 2), '0'), '.') }}%

                                    </span>

                                </td>


                                {{-- Price --}}
                                <td>

                                    @if($promotion->service?->price !== null)

                                        <div class="service-price">
                                            {{ number_format((float) $promotion->service->price, 0) }}
                                        </div>

                                        <div class="price-label">
                                            Service price
                                        </div>

                                    @else

                                        <span class="text-muted">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td>

                                    @if($isActive)

                                        <span class="promotion-status status-active">

                                            <span class="promotion-status-dot"></span>

                                            Active

                                        </span>

                                    @elseif($isUpcoming)

                                        <span class="promotion-status status-upcoming">

                                            <span class="promotion-status-dot"></span>

                                            Upcoming

                                        </span>

                                    @else

                                        <span class="promotion-status status-expired">

                                            <span class="promotion-status-dot"></span>

                                            Expired

                                        </span>

                                    @endif

                                </td>


                                {{-- Period --}}
                                <td>

                                    <div class="promotion-dates">

                                        <span class="date-label">
                                            From
                                        </span>

                                        <span class="date-value">
                                            {{ $promotion->start_date?->format('d M Y') ?? '—' }}
                                        </span>

                                        <span class="date-separator">
                                            →
                                        </span>

                                        <span class="date-label">
                                            To
                                        </span>

                                        <span class="date-value">
                                            {{ $promotion->end_date?->format('d M Y') ?? '—' }}
                                        </span>

                                    </div>

                                </td>


                                {{-- Action --}}
                                <td class="text-end">

                                    <button
                                        type="button"
                                        class="promotion-action"
                                        title="Edit promotion"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editPromotionModal"

                                        data-service="{{ $promotion->service_id }}"

                                        data-title="{{ $promotion->title }}"

                                        data-description="{{ $promotion->description }}"

                                        data-discount="{{ $promotion->discount }}"

                                        data-start="{{ $promotion->start_date?->format('Y-m-d') }}"

                                        data-end="{{ $promotion->end_date?->format('Y-m-d') }}"

                                        data-action="{{ route('promotions.update', $promotion->id) }}"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </button>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            {{-- Empty State --}}

            <div class="promotion-empty">

                <div class="promotion-empty-icon">
                    <i class="bi bi-megaphone"></i>
                </div>

                <h5>
                    No promotions yet
                </h5>

                <p>
                    You haven't created any promotions for your services.
                    Create your first offer to start highlighting special
                    prices and deals.
                </p>

                <button
                    type="button"
                    class="btn btn-modal-save"
                    data-bs-toggle="modal"
                    data-bs-target="#addPromotionModal"
                >
                    <i class="bi bi-plus-lg me-1"></i>
                    Create Promotion
                </button>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     ADD PROMOTION MODAL
========================================================= --}}

<div
    class="modal fade promotion-modal"
    id="addPromotionModal"
    tabindex="-1"
    aria-labelledby="addPromotionModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title"
                        id="addPromotionModalLabel"
                    >
                        Create Promotion
                    </h5>

                    <div class="modal-subtitle">
                        Add a special offer to one of your services.
                    </div>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form
                action="{{ route('promotions.store') }}"
                method="POST"
            >

                @csrf

                <div class="modal-body">

                    {{-- Promotion information --}}
                    <div class="form-section">

                        <div class="form-section-title">

                            <i class="bi bi-megaphone"></i>

                            Promotion Information

                        </div>


                        <div class="row g-3">

                            {{-- Service --}}
                            <div class="col-12">

                                <label class="promotion-label">
                                    Service
                                </label>

                                <select
                                    name="service_id"
                                    class="form-select promotion-select @error('service_id') is-invalid @enderror"
                                    required
                                >

                                    <option value="">
                                        Select a service
                                    </option>

                                    @foreach($services as $service)

                                        <option
                                            value="{{ $service->id }}"
                                            {{ old('service_id') == $service->id ? 'selected' : '' }}
                                        >

                                            {{ $service->name }}

                                            @if($service->category)
                                                — {{ $service->category->name }}
                                            @endif

                                        </option>

                                    @endforeach

                                </select>

                                @error('service_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                                <div class="promotion-form-help">
                                    Only services belonging to your provider account are available.
                                </div>

                            </div>


                            {{-- Title --}}
                            <div class="col-12">

                                <label class="promotion-label">
                                    Promotion Title
                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    class="form-control promotion-input @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}"
                                    placeholder="Example: Weekend Special Offer"
                                    maxlength="255"
                                    required
                                >

                                @error('title')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- Description --}}
                            <div class="col-12">

                                <label class="promotion-label">
                                    Description
                                </label>

                                <textarea
                                    name="description"
                                    class="form-control promotion-input @error('description') is-invalid @enderror"
                                    placeholder="Describe what customers will receive..."
                                    required
                                >{{ old('description') }}</textarea>

                                @error('description')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Discount and dates --}}
                    <div class="form-section">

                        <div class="form-section-title">

                            <i class="bi bi-calendar3"></i>

                            Discount & Schedule

                        </div>


                        <div class="row g-3">

                            {{-- Discount --}}
                            <div class="col-md-4">

                                <label class="promotion-label">
                                    Discount
                                </label>

                                <div class="input-group">

                                    <input
                                        type="number"
                                        name="discount"
                                        class="form-control promotion-input @error('discount') is-invalid @enderror"
                                        value="{{ old('discount') }}"
                                        placeholder="10"
                                        min="0.01"
                                        max="100"
                                        step="0.01"
                                        required
                                    >

                                    <span class="input-group-text">
                                        %
                                    </span>

                                </div>

                                @error('discount')

                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>

                                @enderror

                                <div class="promotion-form-help">
                                    Maximum discount: 100%.
                                </div>

                            </div>


                            {{-- Start date --}}
                            <div class="col-md-4">

                                <label class="promotion-label">
                                    Start Date
                                </label>

                                <input
                                    type="date"
                                    name="start_date"
                                    class="form-control promotion-input @error('start_date') is-invalid @enderror"
                                    value="{{ old('start_date') }}"
                                    required
                                >

                                @error('start_date')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- End date --}}
                            <div class="col-md-4">

                                <label class="promotion-label">
                                    End Date
                                </label>

                                <input
                                    type="date"
                                    name="end_date"
                                    class="form-control promotion-input @error('end_date') is-invalid @enderror"
                                    value="{{ old('end_date') }}"
                                    required
                                >

                                @error('end_date')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>

                </div>


                <div class="promotion-modal-footer">

                    <button
                        type="button"
                        class="btn btn-modal-cancel"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-modal-save"
                    >
                        <i class="bi bi-check2 me-1"></i>
                        Create Promotion
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =========================================================
     EDIT PROMOTION MODAL
========================================================= --}}

<div
    class="modal fade promotion-modal"
    id="editPromotionModal"
    tabindex="-1"
    aria-labelledby="editPromotionModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title"
                        id="editPromotionModalLabel"
                    >
                        Edit Promotion
                    </h5>

                    <div class="modal-subtitle">
                        Update your promotion information and schedule.
                    </div>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form
                id="editPromotionForm"
                method="POST"
            >

                @csrf

                @method('PUT')


                <div class="modal-body">

                    {{-- Promotion information --}}
                    <div class="form-section">

                        <div class="form-section-title">

                            <i class="bi bi-pencil-square"></i>

                            Promotion Information

                        </div>


                        <div class="row g-3">

                            {{-- Service --}}
                            <div class="col-12">

                                <label class="promotion-label">
                                    Service
                                </label>

                                <select
                                    name="service_id"
                                    id="edit_service_id"
                                    class="form-select promotion-select"
                                    required
                                >

                                    <option value="">
                                        Select a service
                                    </option>

                                    @foreach($services as $service)

                                        <option value="{{ $service->id }}">

                                            {{ $service->name }}

                                            @if($service->category)
                                                — {{ $service->category->name }}
                                            @endif

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- Title --}}
                            <div class="col-12">

                                <label class="promotion-label">
                                    Promotion Title
                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    id="edit_title"
                                    class="form-control promotion-input"
                                    maxlength="255"
                                    required
                                >

                            </div>


                            {{-- Description --}}
                            <div class="col-12">

                                <label class="promotion-label">
                                    Description
                                </label>

                                <textarea
                                    name="description"
                                    id="edit_description"
                                    class="form-control promotion-input"
                                    required
                                ></textarea>

                            </div>

                        </div>

                    </div>


                    {{-- Discount --}}
                    <div class="form-section">

                        <div class="form-section-title">

                            <i class="bi bi-calendar3"></i>

                            Discount & Schedule

                        </div>


                        <div class="row g-3">

                            {{-- Discount --}}
                            <div class="col-md-4">

                                <label class="promotion-label">
                                    Discount
                                </label>

                                <div class="input-group">

                                    <input
                                        type="number"
                                        name="discount"
                                        id="edit_discount"
                                        class="form-control promotion-input"
                                        min="0.01"
                                        max="100"
                                        step="0.01"
                                        required
                                    >

                                    <span class="input-group-text">
                                        %
                                    </span>

                                </div>

                            </div>


                            {{-- Start --}}
                            <div class="col-md-4">

                                <label class="promotion-label">
                                    Start Date
                                </label>

                                <input
                                    type="date"
                                    name="start_date"
                                    id="edit_start_date"
                                    class="form-control promotion-input"
                                    required
                                >

                            </div>


                            {{-- End --}}
                            <div class="col-md-4">

                                <label class="promotion-label">
                                    End Date
                                </label>

                                <input
                                    type="date"
                                    name="end_date"
                                    id="edit_end_date"
                                    class="form-control promotion-input"
                                    required
                                >

                            </div>

                        </div>

                    </div>

                </div>


                <div class="promotion-modal-footer">

                    <button
                        type="button"
                        class="btn btn-modal-cancel"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-modal-save"
                    >
                        <i class="bi bi-check2 me-1"></i>
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =========================================================
     EDIT MODAL JAVASCRIPT
========================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const editModal = document.getElementById('editPromotionModal');

    if (!editModal) {
        return;
    }

    editModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        if (!button) {
            return;
        }

        const form = document.getElementById('editPromotionForm');

        const service = document.getElementById('edit_service_id');
        const title = document.getElementById('edit_title');
        const description = document.getElementById('edit_description');
        const discount = document.getElementById('edit_discount');
        const startDate = document.getElementById('edit_start_date');
        const endDate = document.getElementById('edit_end_date');


        /*
         * Set form action dynamically.
         */
        form.action = button.dataset.action;


        /*
         * Populate service.
         */
        service.value = button.dataset.service || '';


        /*
         * Populate promotion fields.
         */
        title.value = button.dataset.title || '';

        description.value = button.dataset.description || '';

        discount.value = button.dataset.discount || '';

        startDate.value = button.dataset.start || '';

        endDate.value = button.dataset.end || '';

    });

});
</script>


{{-- =========================================================
     REOPEN ADD MODAL AFTER VALIDATION ERROR
========================================================= --}}

@if($errors->any() && !old('_method'))

<script>
document.addEventListener('DOMContentLoaded', function () {

    const addModalElement =
        document.getElementById('addPromotionModal');

    if (addModalElement) {

        const addModal =
            new bootstrap.Modal(addModalElement);

        addModal.show();

    }

});
</script>

@endif

@endsection