@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-primary-dark: #254035;
        --connector-soft: #EEF4F1;
        --connector-bg: #F7FAF8;
        --connector-text: #183028;
        --connector-muted: #65786F;
        --connector-border: #E1EAE6;
        --connector-gold: #C99A3B;
        --connector-danger: #C95A43;
        --connector-white: #ffffff;
        --connector-shadow: 0 10px 30px rgba(37, 64, 53, .07);
        --connector-shadow-lg: 0 20px 50px rgba(37, 64, 53, .10);
    }

    .dashboard-page {
        background: var(--connector-bg);
        min-height: calc(100vh - 70px);
        padding: 28px 0 40px;
    }

    .dashboard-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 0 28px;
    }

    /* Header */

    .dashboard-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 28px;
    }

    .dashboard-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: var(--connector-primary);
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 7px;
    }

    .dashboard-eyebrow span {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--connector-primary);
        display: inline-block;
    }

    .dashboard-title {
        color: var(--connector-text);
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -.03em;
        margin: 0;
    }

    .dashboard-subtitle {
        color: var(--connector-muted);
        font-size: 14px;
        margin: 7px 0 0;
    }

    .dashboard-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dashboard-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        padding: 0 16px;
        border-radius: 11px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid var(--connector-border);
        background: var(--connector-white);
        color: var(--connector-text);
        transition: .2s ease;
    }

    .dashboard-btn:hover {
        color: var(--connector-primary-dark);
        border-color: #cbdad4;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .dashboard-btn.primary {
        background: var(--connector-primary-dark);
        color: #fff;
        border-color: var(--connector-primary-dark);
    }

    .dashboard-btn.primary:hover {
        color: #fff;
        background: #1d342b;
    }


    /* KPI Cards */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: var(--connector-white);
        border: 1px solid var(--connector-border);
        border-radius: 16px;
        padding: 20px;
        box-shadow: var(--connector-shadow);
        position: relative;
        overflow: hidden;
        transition: .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--connector-shadow-lg);
    }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .stat-label {
        color: var(--connector-muted);
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--connector-soft);
        color: var(--connector-primary-dark);
        font-size: 16px;
    }

    .stat-value {
        color: var(--connector-text);
        font-size: 25px;
        line-height: 1.1;
        font-weight: 800;
        letter-spacing: -.03em;
        margin-bottom: 8px;
    }

    .stat-meta {
        color: var(--connector-muted);
        font-size: 12px;
    }

    .stat-meta strong {
        color: var(--connector-primary-dark);
        font-weight: 800;
    }


    /* Main chart cards */

    .dashboard-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.55fr) minmax(300px, .85fr);
        gap: 18px;
        margin-bottom: 18px;
    }

    .dashboard-card {
        background: var(--connector-white);
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        box-shadow: var(--connector-shadow);
        overflow: hidden;
    }

    .dashboard-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 19px 20px;
        border-bottom: 1px solid var(--connector-border);
    }

    .card-title-wrap {
        min-width: 0;
    }

    .card-title {
        color: var(--connector-text);
        font-size: 15px;
        font-weight: 800;
        margin: 0;
    }

    .card-subtitle {
        color: var(--connector-muted);
        font-size: 12px;
        margin: 4px 0 0;
    }

    .card-action {
        color: var(--connector-primary);
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
    }

    .card-action:hover {
        color: var(--connector-primary-dark);
        text-decoration: none;
    }

    .chart-body {
        height: 330px;
        padding: 20px;
        position: relative;
    }

    .chart-body.small {
        height: 330px;
    }


    /* Lower section */

    .lower-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(300px, .6fr);
        gap: 18px;
    }


    /* Quick actions */

    .quick-actions {
        padding: 18px;
    }

    .quick-action {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 13px;
        border: 1px solid var(--connector-border);
        border-radius: 13px;
        text-decoration: none;
        margin-bottom: 10px;
        transition: .2s ease;
        background: #fff;
    }

    .quick-action:last-child {
        margin-bottom: 0;
    }

    .quick-action:hover {
        background: var(--connector-soft);
        border-color: #cbdad4;
        text-decoration: none;
        transform: translateX(2px);
    }

    .quick-action-icon {
        width: 38px;
        height: 38px;
        min-width: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: var(--connector-soft);
        color: var(--connector-primary-dark);
    }

    .quick-action-content {
        min-width: 0;
        flex: 1;
    }

    .quick-action-title {
        display: block;
        color: var(--connector-text);
        font-size: 13px;
        font-weight: 800;
    }

    .quick-action-description {
        display: block;
        color: var(--connector-muted);
        font-size: 11px;
        margin-top: 2px;
    }

    .quick-action-arrow {
        color: #9aa9a2;
        font-size: 12px;
    }


    /* Recent bookings */

    .table-responsive {
        overflow-x: auto;
    }

    .recent-table {
        width: 100%;
        border-collapse: collapse;
    }

    .recent-table th {
        color: var(--connector-muted);
        background: #FAFCFB;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
        padding: 12px 20px;
        border-bottom: 1px solid var(--connector-border);
        white-space: nowrap;
    }

    .recent-table td {
        color: var(--connector-text);
        font-size: 13px;
        padding: 14px 20px;
        border-bottom: 1px solid #edf2ef;
        vertical-align: middle;
    }

    .recent-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .recent-table tbody tr:hover {
        background: #fbfdfc;
    }

    .booking-id {
        color: var(--connector-primary-dark);
        font-weight: 800;
    }

    .booking-date {
        color: var(--connector-muted);
        font-size: 12px;
    }

    .amount {
        font-weight: 800;
        white-space: nowrap;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 5px 9px;
        font-size: 10px;
        font-weight: 800;
        text-transform: capitalize;
        background: var(--connector-soft);
        color: var(--connector-primary-dark);
    }

    .status-badge::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }


    /* Empty state */

    .empty-state {
        text-align: center;
        padding: 45px 20px;
        color: var(--connector-muted);
    }

    .empty-state-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
    }

    .empty-state-title {
        color: var(--connector-text);
        font-weight: 800;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .empty-state-text {
        font-size: 12px;
    }


    /* Responsive */

    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-grid,
        .lower-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 0 16px;
        }

        .dashboard-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .dashboard-actions {
            width: 100%;
        }

        .dashboard-btn {
            flex: 1;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-title {
            font-size: 23px;
        }

        .chart-body,
        .chart-body.small {
            height: 280px;
        }

        .recent-table th,
        .recent-table td {
            padding: 12px;
        }
    }

    @media (max-width: 480px) {
        .dashboard-page {
            padding-top: 20px;
        }

        .dashboard-actions {
            flex-direction: column;
        }

        .dashboard-btn {
            width: 100%;
        }

        .stat-value {
            font-size: 22px;
        }
    }
</style>


<div class="dashboard-page">

    <div class="dashboard-container">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div class="dashboard-header">

            <div>
                <div class="dashboard-eyebrow">
                    <span></span>
                    Connector Admin
                </div>

                <h1 class="dashboard-title">
                    Good {{ now()->format('A') === 'AM' ? 'morning' : 'afternoon' }},
                    {{ auth()->user()->name ?? 'Admin' }}
                </h1>

                <p class="dashboard-subtitle">
                    Here's what's happening across your marketplace today.
                </p>
            </div>

            <div class="dashboard-actions">

                <a href="{{ route('exportExcel') }}"
                   class="dashboard-btn">
                    <i class="fas fa-download"></i>
                    Export
                </a>

                <a href="{{ route('admin.create_service') }}"
                   class="dashboard-btn primary">
                    <i class="fas fa-plus"></i>
                    Add Service
                </a>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- KPI CARDS --}}
        {{-- ========================================================= --}}

        <div class="stats-grid">

            {{-- Revenue --}}
            <div class="stat-card">

                <div class="stat-top">

                    <span class="stat-label">
                        Booking Revenue
                    </span>

                    <div class="stat-icon">
                        <i class="fas fa-wallet"></i>
                    </div>

                </div>

                <div class="stat-value">
                    {{ number_format($totalRevenue) }}
                    <span style="font-size:13px;font-weight:700;">RWF</span>
                </div>

                <div class="stat-meta">
                    Total value of recorded bookings
                </div>

            </div>


            {{-- Bookings --}}
            <div class="stat-card">

                <div class="stat-top">

                    <span class="stat-label">
                        Bookings
                    </span>

                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>

                </div>

                <div class="stat-value">
                    {{ number_format($totalBooking) }}
                </div>

                <div class="stat-meta">
                    <strong>{{ $pendingBookings }}</strong>
                    currently pending
                </div>

            </div>


            {{-- Providers --}}
            <div class="stat-card">

                <div class="stat-top">

                    <span class="stat-label">
                        Providers
                    </span>

                    <div class="stat-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>

                </div>

                <div class="stat-value">
                    {{ number_format($totalSprovider) }}
                </div>

                <div class="stat-meta">
                    Service providers on platform
                </div>

            </div>


            {{-- Users --}}
            <div class="stat-card">

                <div class="stat-top">

                    <span class="stat-label">
                        Users
                    </span>

                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>

                </div>

                <div class="stat-value">
                    {{ number_format($totalUsers) }}
                </div>

                <div class="stat-meta">
                    Registered marketplace users
                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- CHARTS --}}
        {{-- ========================================================= --}}

        <div class="dashboard-grid">


            {{-- Booking Trend --}}
            <div class="dashboard-card">

                <div class="dashboard-card-header">

                    <div class="card-title-wrap">

                        <h2 class="card-title">
                            Booking activity
                        </h2>

                        <p class="card-subtitle">
                            Weekly booking volume
                        </p>

                    </div>

                    <a href="{{ route('admin.bookings') }}"
                       class="card-action">
                        View bookings
                    </a>

                </div>

                <div class="chart-body">
                    <canvas id="booking-chart"></canvas>
                </div>

            </div>


            {{-- Booking Status --}}
            <div class="dashboard-card">

                <div class="dashboard-card-header">

                    <div class="card-title-wrap">

                        <h2 class="card-title">
                            Booking status
                        </h2>

                        <p class="card-subtitle">
                            Current booking distribution
                        </p>

                    </div>

                </div>

                <div class="chart-body small">
                    <canvas id="service-chart"></canvas>
                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- RECENT BOOKINGS + QUICK ACTIONS --}}
        {{-- ========================================================= --}}

        <div class="lower-grid">


            {{-- Recent bookings --}}
            <div class="dashboard-card">

                <div class="dashboard-card-header">

                    <div class="card-title-wrap">

                        <h2 class="card-title">
                            Recent bookings
                        </h2>

                        <p class="card-subtitle">
                            Latest marketplace activity
                        </p>

                    </div>

                    <a href="{{ route('admin.bookings') }}"
                       class="card-action">
                        View all
                    </a>

                </div>


                @if(isset($orders) && $orders->count())

                    <div class="table-responsive">

                        <table class="recent-table">

                            <thead>

                                <tr>
                                    <th>Booking</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach($orders as $booking)

                                    <tr>

                                        <td>
                                            <span class="booking-id">
                                                #{{ $booking->id }}
                                            </span>
                                        </td>

                                        <td>

                                            <span class="status-badge">
                                                {{ $booking->status ?? 'Unknown' }}
                                            </span>

                                        </td>

                                        <td>
                                            {{ $booking->payment_mode ?? '—' }}
                                        </td>

                                        <td>
                                            <span class="amount">
                                                {{ number_format((float) ($booking->total ?? 0)) }}
                                                RWF
                                            </span>
                                        </td>

                                        <td>
                                            <span class="booking-date">
                                                {{ optional($booking->created_at)->format('d M Y') }}
                                            </span>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="empty-state">

                        <div class="empty-state-icon">
                            <i class="fas fa-calendar"></i>
                        </div>

                        <div class="empty-state-title">
                            No bookings yet
                        </div>

                        <div class="empty-state-text">
                            New bookings will appear here.
                        </div>

                    </div>

                @endif

            </div>


            {{-- Quick actions --}}
            <div class="dashboard-card">

                <div class="dashboard-card-header">

                    <div class="card-title-wrap">

                        <h2 class="card-title">
                            Quick actions
                        </h2>

                        <p class="card-subtitle">
                            Manage your marketplace
                        </p>

                    </div>

                </div>


                <div class="quick-actions">


                    <a href="{{ route('admin.create_service') }}"
                       class="quick-action">

                        <div class="quick-action-icon">
                            <i class="fas fa-plus"></i>
                        </div>

                        <div class="quick-action-content">

                            <span class="quick-action-title">
                                Add service
                            </span>

                            <span class="quick-action-description">
                                Publish a new marketplace service
                            </span>

                        </div>

                        <i class="fas fa-chevron-right quick-action-arrow"></i>

                    </a>


                    <a href="{{ route('admin.service_providers') }}"
                       class="quick-action">

                        <div class="quick-action-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>

                        <div class="quick-action-content">

                            <span class="quick-action-title">
                                Manage providers
                            </span>

                            <span class="quick-action-description">
                                Review service providers
                            </span>

                        </div>

                        <i class="fas fa-chevron-right quick-action-arrow"></i>

                    </a>


                    <a href="{{ route('admin.users') }}"
                       class="quick-action">

                        <div class="quick-action-icon">
                            <i class="fas fa-users"></i>
                        </div>

                        <div class="quick-action-content">

                            <span class="quick-action-title">
                                Manage users
                            </span>

                            <span class="quick-action-description">
                                View registered users
                            </span>

                        </div>

                        <i class="fas fa-chevron-right quick-action-arrow"></i>

                    </a>


                    <a href="{{ route('admin.jobs') }}"
                       class="quick-action">

                        <div class="quick-action-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>

                        <div class="quick-action-content">

                            <span class="quick-action-title">
                                Job postings
                            </span>

                            <span class="quick-action-description">
                                Manage marketplace jobs
                            </span>

                        </div>

                        <i class="fas fa-chevron-right quick-action-arrow"></i>

                    </a>


                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- PROVIDER CATEGORY CHART --}}
        {{-- ========================================================= --}}

        @if(!empty($providerCategoryData))

            <div class="dashboard-card" style="margin-top:18px;">

                <div class="dashboard-card-header">

                    <div class="card-title-wrap">

                        <h2 class="card-title">
                            Provider distribution
                        </h2>

                        <p class="card-subtitle">
                            Service providers by category
                        </p>

                    </div>

                </div>

                <div class="chart-body">
                    <canvas id="provider-category-chart"></canvas>
                </div>

            </div>

        @endif

    </div>

</div>


{{-- =============================================================== --}}
{{-- CHART.JS --}}
{{-- =============================================================== --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Shared chart settings
    |--------------------------------------------------------------------------
    */

    Chart.defaults.font.family =
        "'Inter', 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif";

    Chart.defaults.color = '#65786F';

    const connectorGreen = '#6B9080';
    const connectorDark = '#254035';
    const connectorSoft = '#EEF4F1';
    const connectorGold = '#C99A3B';
    const connectorDanger = '#C95A43';


    /*
    |--------------------------------------------------------------------------
    | Booking activity
    |--------------------------------------------------------------------------
    */

    const bookingData = @json($data ?? []);

    const bookingCanvas = document.getElementById('booking-chart');

    if (bookingCanvas) {

        const labels = bookingData.map(item => item.week);
        const values = bookingData.map(item => Number(item.count));

        const context = bookingCanvas.getContext('2d');

        const gradient = context.createLinearGradient(0, 0, 0, 330);

        gradient.addColorStop(0, 'rgba(107, 144, 128, .24)');
        gradient.addColorStop(1, 'rgba(107, 144, 128, .02)');

        new Chart(context, {

            type: 'line',

            data: {

                labels: labels,

                datasets: [{
                    label: 'Bookings',

                    data: values,

                    borderColor: connectorGreen,

                    backgroundColor: gradient,

                    fill: true,

                    tension: .4,

                    borderWidth: 2.5,

                    pointRadius: 3,

                    pointHoverRadius: 6,

                    pointBackgroundColor: '#ffffff',

                    pointBorderColor: connectorGreen,

                    pointBorderWidth: 2
                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                interaction: {
                    intersect: false,
                    mode: 'index'
                },

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {

                        backgroundColor: connectorDark,

                        titleColor: '#ffffff',

                        bodyColor: '#ffffff',

                        padding: 12,

                        displayColors: false,

                        cornerRadius: 10

                    }

                },

                scales: {

                    x: {
                        grid: {
                            display: false
                        },

                        border: {
                            display: false
                        },

                        ticks: {
                            maxTicksLimit: 8
                        }
                    },

                    y: {

                        beginAtZero: true,

                        border: {
                            display: false
                        },

                        grid: {
                            color: '#EDF2EF'
                        },

                        ticks: {
                            precision: 0
                        }
                    }

                }

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Booking status
    |--------------------------------------------------------------------------
    */

    const statusData = @json($done ?? []);

    const statusCanvas = document.getElementById('service-chart');

    if (statusCanvas) {

        const labels = statusData.map(item => item.status);
        const values = statusData.map(item => Number(item.count));

        new Chart(statusCanvas.getContext('2d'), {

            type: 'doughnut',

            data: {

                labels: labels,

                datasets: [{

                    data: values,

                    backgroundColor: [
                        '#6B9080',
                        '#254035',
                        '#C99A3B',
                        '#7EA393',
                        '#9BB6AA',
                        '#C95A43'
                    ],

                    borderWidth: 0,

                    hoverOffset: 5

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: '68%',

                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {

                            usePointStyle: true,

                            pointStyle: 'circle',

                            padding: 16,

                            font: {
                                size: 11,
                                weight: '600'
                            }

                        }

                    },

                    tooltip: {

                        backgroundColor: connectorDark,

                        padding: 11,

                        cornerRadius: 10

                    }

                }

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Providers by category
    |--------------------------------------------------------------------------
    */

    const providerData = @json($providerCategoryData ?? []);

    const providerCanvas =
        document.getElementById('provider-category-chart');

    if (providerCanvas && providerData.length) {

        const labels = providerData.map(item => item.category);

        const values = providerData.map(item => Number(item.count));

        new Chart(providerCanvas.getContext('2d'), {

            type: 'bar',

            data: {

                labels: labels,

                datasets: [{

                    label: 'Providers',

                    data: values,

                    backgroundColor: connectorSoft,

                    borderColor: connectorGreen,

                    borderWidth: 1.5,

                    borderRadius: 7,

                    maxBarThickness: 45

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {

                        backgroundColor: connectorDark,

                        padding: 11,

                        cornerRadius: 10

                    }

                },

                scales: {

                    x: {

                        grid: {
                            display: false
                        },

                        border: {
                            display: false
                        }

                    },

                    y: {

                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        },

                        grid: {
                            color: '#EDF2EF'
                        },

                        border: {
                            display: false
                        }

                    }

                }

            }

        });

    }

});
</script>

@endsection