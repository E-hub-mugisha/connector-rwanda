@extends('layouts.app')

@section('title', 'Users')

@section('content')

@php
    $totalUsers = $users->total();

    $adminCount = \App\Models\User::where('utype', 'ADM')->count();
    $customerCount = \App\Models\User::where('utype', 'CST')->count();
    $providerCount = \App\Models\User::where('utype', 'SVP')->count();

    $verifiedCount = \App\Models\User::whereNotNull('email_verified_at')->count();
    $unverifiedCount = max(0, $totalUsers - $verifiedCount);
@endphp

<style>
    .users-page {
        background: #f6f8f7;
        min-height: calc(100vh - 70px);
        padding: 30px 0 60px;
    }

    .users-page .container-fluid {
        max-width: 1500px;
    }

    /* HEADER */

    .users-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 25px;
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
        font-size: 30px;
        font-weight: 800;
        margin: 0;
        line-height: 1.2;
    }

    .page-subtitle {
        color: #7c8984;
        font-size: 13px;
        margin: 8px 0 0;
    }

    /* BUTTONS */

    .btn-connector {
        background: #6B9080;
        border: 1px solid #6B9080;
        color: #fff;
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
        border: 1px solid #dfe7e3;
        color: #254035;
        border-radius: 10px;
        padding: 10px 17px;
        font-size: 13px;
        font-weight: 700;
        transition: .2s ease;
    }

    .btn-light-connector:hover {
        background: #edf4f1;
        color: #254035;
    }

    /* STATISTICS */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #e5ebe8;
        border-radius: 15px;
        padding: 19px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 6px 22px rgba(37, 64, 53, .04);
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #e8f1ed;
        color: #254035;
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
    }

    .stat-icon svg {
        width: 20px;
        height: 20px;
    }

    .stat-label {
        color: #89958f;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .6px;
    }

    .stat-value {
        color: #254035;
        font-size: 21px;
        font-weight: 900;
        margin-top: 2px;
    }

    /* MAIN CARD */

    .users-card {
        background: #fff;
        border: 1px solid #e5ebe8;
        border-radius: 18px;
        overflow: visible;
        box-shadow: 0 8px 30px rgba(37, 64, 53, .05);
    }

    .users-card-header {
        padding: 21px 24px;
        border-bottom: 1px solid #edf1ef;
    }

    .card-header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 18px;
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

    /* FILTERS */

    .filters {
        display: grid;
        grid-template-columns: minmax(250px, 1.8fr) 1fr 1fr auto;
        gap: 10px;
        align-items: center;
    }

    .search-wrapper {
        position: relative;
    }

    .search-wrapper svg {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 15px;
        height: 15px;
        color: #8a9892;
    }

    .filter-control {
        width: 100%;
        height: 42px;
        border: 1px solid #dfe7e3;
        border-radius: 10px;
        background: #fff;
        color: #42564d;
        font-size: 12px;
        padding: 0 13px;
        outline: none;
    }

    .search-input {
        padding-left: 38px;
    }

    .filter-control:focus {
        border-color: #6B9080;
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .10);
    }

    .filter-btn {
        height: 42px;
        border: 0;
        background: #254035;
        color: #fff;
        padding: 0 17px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        transition: .2s ease;
    }

    .filter-btn:hover {
        background: #6B9080;
    }

    /* TABLE */

    .table-wrapper {
        overflow-x: auto;
        overflow-y: visible;
    }

    .users-table {
        width: 100%;
        min-width: 1100px;
        border-collapse: collapse;
    }

    .users-table thead th {
        background: #fafcfb;
        color: #87938e;
        padding: 14px 18px;
        border-bottom: 1px solid #e8eeeb;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .7px;
        white-space: nowrap;
    }

    .users-table tbody td {
        padding: 15px 18px;
        border-bottom: 1px solid #edf1ef;
        vertical-align: middle;
    }

    .users-table tbody tr {
        transition: .15s ease;
    }

    .users-table tbody tr:hover {
        background: #fafcfb;
    }

    .users-table tbody tr:last-child td {
        border-bottom: 0;
    }

    /* USER */

    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 220px;
    }

    .user-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        overflow: hidden;
        background: #e5efeb;
        color: #254035;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 900;
        flex: 0 0 auto;
        border: 2px solid #fff;
        box-shadow: 0 2px 8px rgba(37,64,53,.08);
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-name {
        color: #254035;
        font-size: 13px;
        font-weight: 800;
        line-height: 1.4;
    }

    .user-id {
        color: #99a39f;
        font-size: 10px;
        margin-top: 2px;
    }

    .user-email {
        color: #52645c;
        font-size: 12px;
    }

    /* ROLE */

    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .role-admin {
        background: #eeeaf8;
        color: #68539b;
    }

    .role-customer {
        background: #e9f4ef;
        color: #36745b;
    }

    .role-provider {
        background: #f8f0df;
        color: #94702b;
    }

    .role-unknown {
        background: #eef1f0;
        color: #68756f;
    }

    /* VERIFICATION */

    .verification-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .verified {
        background: #e8f5ee;
        color: #32745a;
    }

    .unverified {
        background: #f2f3f2;
        color: #7c8782;
    }

    /* DATE */

    .date-main {
        color: #596a62;
        font-size: 12px;
        white-space: nowrap;
    }

    .date-sub {
        color: #a0aaa6;
        font-size: 10px;
        margin-top: 3px;
    }

    /* ACTIONS */

    .actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
        position: relative;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        border: 1px solid #e0e7e3;
        background: #fff;
        color: #60726a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: .2s ease;
        text-decoration: none;
        cursor: pointer;
        padding: 0;
    }

    .action-btn:hover {
        background: #edf4f1;
        color: #254035;
        border-color: #d3e1da;
    }

    .action-btn svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
    }

    .action-btn.verify:hover {
        background: #e8f5ee;
        color: #32745a;
    }

    .action-btn.delete:hover {
        background: #faecea;
        color: #b14f43;
    }

    /* CUSTOM MORE MENU */

    .more-wrapper {
        position: relative;
    }

    .more-menu {
        position: absolute;
        right: 0;
        top: calc(100% + 7px);
        width: 205px;
        background: #fff;
        border: 1px solid #e3ebe7;
        border-radius: 12px;
        padding: 7px;
        box-shadow: 0 14px 35px rgba(37, 64, 53, .14);
        z-index: 9999;
        display: none;
    }

    .more-menu.show {
        display: block;
    }

    .more-menu-title {
        padding: 7px 10px 8px;
        color: #9aa59f;
        font-size: 9px;
        font-weight: 900;
        letter-spacing: .8px;
        text-transform: uppercase;
    }

    .more-item {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 0;
        background: transparent;
        border-radius: 8px;
        padding: 9px 10px;
        color: #42564d;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        text-align: left;
    }

    .more-item:hover {
        background: #f2f7f4;
        color: #254035;
        text-decoration: none;
    }

    .more-item svg {
        width: 15px;
        height: 15px;
        stroke: currentColor;
        flex: 0 0 auto;
    }

    .more-item.provider:hover {
        color: #94702b;
        background: #faf5e8;
    }

    .more-item.admin:hover {
        color: #68539b;
        background: #f3f0fa;
    }

    .more-item.customer:hover {
        color: #36745b;
        background: #edf7f2;
    }

    .more-divider {
        height: 1px;
        background: #edf1ef;
        margin: 5px 3px;
    }

    /* PAGINATION */

    .pagination-area {
        padding: 18px 24px;
        border-top: 1px solid #edf1ef;
    }

    .pagination-area .pagination {
        margin: 0;
    }

    .pagination-area .page-link {
        color: #254035;
        border-color: #e1e8e4;
        font-size: 12px;
        border-radius: 8px;
        margin: 0 2px;
    }

    .pagination-area .page-item.active .page-link {
        background: #6B9080;
        border-color: #6B9080;
        color: #fff;
    }

    /* EMPTY */

    .empty-state {
        padding: 70px 25px;
        text-align: center;
    }

    .empty-icon {
        width: 66px;
        height: 66px;
        margin: 0 auto 16px;
        background: #edf4f1;
        color: #6B9080;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-icon svg {
        width: 27px;
        height: 27px;
    }

    .empty-title {
        color: #254035;
        font-size: 17px;
        font-weight: 800;
    }

    .empty-description {
        color: #89958f;
        font-size: 13px;
        margin: 7px 0 20px;
    }

    /* MODAL */

    .user-modal .modal-content {
        border: 0;
        border-radius: 18px;
        overflow: hidden;
    }

    .user-modal .modal-header {
        background: #254035;
        color: #fff;
        border: 0;
        padding: 20px 24px;
    }

    .user-modal .modal-title {
        font-size: 17px;
        font-weight: 800;
    }

    .user-profile {
        text-align: center;
        padding: 10px 0 25px;
    }

    .modal-avatar {
        width: 82px;
        height: 82px;
        border-radius: 50%;
        margin: 0 auto 12px;
        background: #e6f0ec;
        color: #254035;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        font-weight: 900;
        overflow: hidden;
    }

    .modal-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .modal-user-name {
        color: #254035;
        font-size: 19px;
        font-weight: 900;
    }

    .modal-user-email {
        color: #89958f;
        font-size: 12px;
        margin-top: 4px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 12px 0;
        border-bottom: 1px solid #edf1ef;
    }

    .detail-label {
        color: #89958f;
        font-size: 11px;
        font-weight: 700;
    }

    .detail-value {
        color: #254035;
        font-size: 12px;
        font-weight: 700;
        text-align: right;
    }

    @media (max-width: 1199.98px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filters {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 767.98px) {
        .users-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .filters {
            grid-template-columns: 1fr;
        }

        .users-card-header {
            padding: 18px;
        }

        .card-header-top {
            align-items: flex-start;
        }
    }
</style>

<div class="users-page">

    <div class="container-fluid px-3 px-lg-4">

        {{-- HEADER --}}
        <div class="users-header">
            <div>
                <div class="page-eyebrow">
                    Connector Administration
                </div>

                <h1 class="page-title">
                    Users
                </h1>

                <p class="page-subtitle">
                    Manage customers, service providers and administrators.
                </p>
            </div>
        </div>

        {{-- FLASH --}}
        @if(session('message'))
            <div class="alert alert-success border-0 shadow-sm mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- STATISTICS --}}
        <div class="stats-grid">

            <div class="stat-card">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>

                <div>
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value">{{ number_format($totalUsers) }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="16" rx="2"/>
                        <path d="M8 9h8"/>
                        <path d="M8 13h5"/>
                        <path d="M8 17h3"/>
                    </svg>
                </div>

                <div>
                    <div class="stat-label">Service Providers</div>
                    <div class="stat-value">{{ number_format($providerCount) }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="m8 12 2.5 2.5L16 9"/>
                    </svg>
                </div>

                <div>
                    <div class="stat-label">Verified Users</div>
                    <div class="stat-value">{{ number_format($verifiedCount) }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 3 4 6v5c0 5 3.4 8.7 8 10 4.6-1.3 8-5 8-10V6l-8-3Z"/>
                        <path d="M9 12l2 2 4-4"/>
                    </svg>
                </div>

                <div>
                    <div class="stat-label">Administrators</div>
                    <div class="stat-value">{{ number_format($adminCount) }}</div>
                </div>
            </div>

        </div>

        {{-- MAIN CARD --}}
        <div class="users-card">

            {{-- HEADER --}}
            <div class="users-card-header">

                <div class="card-header-top">

                    <div>
                        <h2 class="card-title">
                            User Directory
                        </h2>

                        <p class="card-subtitle">
                            Search, filter and manage Connector accounts.
                        </p>
                    </div>

                    <div class="count-badge">
                        {{ number_format($totalUsers) }}
                        {{ Str::plural('user', $totalUsers) }}
                    </div>

                </div>

                {{-- FILTERS --}}
                <form method="GET"
                      action="{{ route('admin.users') }}"
                      class="filters">

                    <div class="search-wrapper">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <circle cx="11" cy="11" r="7"/>
                            <path d="m20 20-4-4"/>
                        </svg>

                        <input
                            type="text"
                            name="search"
                            class="filter-control search-input"
                            placeholder="Search name or email..."
                            value="{{ request('search') }}"
                        >

                    </div>

                    <select name="utype" class="filter-control">

                        <option value="">All Roles</option>

                        <option value="ADM"
                            @selected(request('utype') === 'ADM')}>
                            Administrators
                        </option>

                        <option value="CST"
                            @selected(request('utype') === 'CST')}>
                            Customers
                        </option>

                        <option value="SVP"
                            @selected(request('utype') === 'SVP')}>
                            Service Providers
                        </option>

                    </select>

                    <select name="verification" class="filter-control">

                        <option value="">All Verification</option>

                        <option value="verified"
                            @selected(request('verification') === 'verified')}>
                            Verified
                        </option>

                        <option value="unverified"
                            @selected(request('verification') === 'unverified')}>
                            Unverified
                        </option>

                    </select>

                    <button type="submit" class="filter-btn">
                        Filter
                    </button>

                </form>

            </div>

            @if($users->count())

                <div class="table-wrapper">

                    <table class="users-table">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Contact</th>
                                <th>Role</th>
                                <th>Verification</th>
                                <th>Joined</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach($users as $user)

                            @php
                                $userName = $user->name ?? 'Unnamed User';

                                $initials = collect(
                                    preg_split('/\s+/', trim($userName))
                                )
                                ->filter()
                                ->take(2)
                                ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                ->implode('');

                                $isVerified = !empty($user->email_verified_at);

                                $profileImage = $user->profile_photo_path ?? null;

                                if (
                                    $profileImage &&
                                    !filter_var($profileImage, FILTER_VALIDATE_URL)
                                ) {
                                    $profileImage = asset(
                                        'storage/' . ltrim($profileImage, '/')
                                    );
                                }
                            @endphp

                            <tr>

                                {{-- ID --}}
                                <td>
                                    <span class="text-muted small">
                                        #{{ $user->id }}
                                    </span>
                                </td>

                                {{-- USER --}}
                                <td>

                                    <div class="user-cell">

                                        <div class="user-avatar">

                                            @if($profileImage)

                                                <img
                                                    src="{{ $profileImage }}"
                                                    alt="{{ $userName }}"
                                                >

                                            @else

                                                {{ $initials ?: 'U' }}

                                            @endif

                                        </div>

                                        <div>

                                            <div class="user-name">
                                                {{ $userName }}
                                            </div>

                                            <div class="user-id">
                                                User #{{ $user->id }}
                                            </div>

                                        </div>

                                    </div>

                                </td>

                                {{-- CONTACT --}}
                                <td>

                                    <div class="user-email">
                                        {{ $user->email }}
                                    </div>

                                </td>

                                {{-- ROLE --}}
                                <td>

                                    @switch($user->utype)

                                        @case('ADM')
                                            <span class="role-badge role-admin">
                                                Administrator
                                            </span>
                                            @break

                                        @case('SVP')
                                            <span class="role-badge role-provider">
                                                Provider
                                            </span>
                                            @break

                                        @case('CST')
                                            <span class="role-badge role-customer">
                                                Customer
                                            </span>
                                            @break

                                        @default
                                            <span class="role-badge role-unknown">
                                                {{ $user->utype ?: 'Unknown' }}
                                            </span>

                                    @endswitch

                                </td>

                                {{-- VERIFICATION --}}
                                <td>

                                    @if($isVerified)

                                        <span class="verification-badge verified">
                                            Verified
                                        </span>

                                    @else

                                        <span class="verification-badge unverified">
                                            Unverified
                                        </span>

                                    @endif

                                </td>

                                {{-- JOINED --}}
                                <td>

                                    @if($user->created_at)

                                        <div class="date-main">
                                            {{ $user->created_at->format('d M Y') }}
                                        </div>

                                        <div class="date-sub">
                                            {{ $user->created_at->format('H:i') }}
                                        </div>

                                    @else

                                        <span class="text-muted">—</span>

                                    @endif

                                </td>

                                {{-- ACTIONS --}}
                                <td>

                                    <div class="actions">

                                        {{-- VIEW --}}
                                        <button
                                            type="button"
                                            class="action-btn"
                                            data-toggle="modal"
                                            data-target="#userModal{{ $user->id }}"
                                            title="View user"
                                        >

                                            <svg viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="1.8">
                                                <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"/>
                                                <circle cx="12" cy="12" r="2.5"/>
                                            </svg>

                                        </button>

                                        {{-- VERIFY --}}
                                        @if(!$isVerified)

                                            <button
                                                type="button"
                                                class="action-btn verify"
                                                data-toggle="modal"
                                                data-target="#verifyModal{{ $user->id }}"
                                                title="Verify user"
                                            >

                                                <svg viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.8">
                                                    <circle cx="12" cy="12" r="9"/>
                                                    <path d="m8 12 2.5 2.5L16 9"/>
                                                </svg>

                                            </button>

                                        @endif

                                        {{-- DELETE --}}
                                        <form
                                            action="{{ route('users.delete', $user->id) }}"
                                            method="POST"
                                            class="delete-form"
                                            onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn delete"
                                                title="Delete user"
                                            >

                                                <svg viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.8">
                                                    <path d="M4 7h16"/>
                                                    <path d="M10 11v6"/>
                                                    <path d="M14 11v6"/>
                                                    <path d="M6 7l1 13h10l1-13"/>
                                                    <path d="M9 7V4h6v3"/>
                                                </svg>

                                            </button>

                                        </form>

                                        {{-- MORE --}}
                                        <div class="more-wrapper">

                                            <button
                                                type="button"
                                                class="action-btn more-trigger"
                                                title="More actions"
                                                onclick="toggleUserActions({{ $user->id }}, this)"
                                            >

                                                <svg viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="2">
                                                    <circle cx="5" cy="12" r="1"/>
                                                    <circle cx="12" cy="12" r="1"/>
                                                    <circle cx="19" cy="12" r="1"/>
                                                </svg>

                                            </button>

                                            <div
                                                class="more-menu"
                                                id="userActions{{ $user->id }}"
                                            >

                                                <div class="more-menu-title">
                                                    Change Role
                                                </div>

                                                {{-- ADMIN --}}
                                                @if($user->utype !== 'ADM')

                                                    <a
                                                        href="{{ route('admin.activate', $user->id) }}"
                                                        class="more-item admin"
                                                        onclick="return confirm('Change {{ addslashes($user->name) }} to Administrator?');"
                                                    >

                                                        <svg viewBox="0 0 24 24"
                                                             fill="none"
                                                             stroke="currentColor"
                                                             stroke-width="1.8">
                                                            <path d="M12 3 4 6v5c0 5 3.4 8.7 8 10 4.6-1.3 8-5 8-10V6l-8-3Z"/>
                                                            <path d="m9 12 2 2 4-4"/>
                                                        </svg>

                                                        Make Administrator

                                                    </a>

                                                @endif

                                                {{-- CUSTOMER --}}
                                                @if($user->utype !== 'CST')

                                                    <a
                                                        href="{{ route('customer.activate', $user->id) }}"
                                                        class="more-item customer"
                                                        onclick="return confirm('Change {{ addslashes($user->name) }} to Customer?');"
                                                    >

                                                        <svg viewBox="0 0 24 24"
                                                             fill="none"
                                                             stroke="currentColor"
                                                             stroke-width="1.8">
                                                            <circle cx="12" cy="8" r="4"/>
                                                            <path d="M4 21a8 8 0 0 1 16 0"/>
                                                        </svg>

                                                        Make Customer

                                                    </a>

                                                @endif

                                                {{-- PROVIDER --}}
                                                @if($user->utype !== 'SVP')

                                                    <a
                                                        href="{{ route('provider.activate', $user->id) }}"
                                                        class="more-item provider"
                                                        onclick="return confirm('Change {{ addslashes($user->name) }} to Service Provider?');"
                                                    >

                                                        <svg viewBox="0 0 24 24"
                                                             fill="none"
                                                             stroke="currentColor"
                                                             stroke-width="1.8">
                                                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                                                            <path d="M8 9h8"/>
                                                            <path d="M8 13h5"/>
                                                            <path d="M8 17h3"/>
                                                        </svg>

                                                        Make Provider

                                                    </a>

                                                @endif

                                                {{-- NO ROLE CHANGE --}}
                                                @if($user->utype === 'ADM' &&
                                                    $user->utype === 'CST' &&
                                                    $user->utype === 'SVP')

                                                    <div class="more-menu-title">
                                                        No actions available
                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </td>

                            </tr>

                            {{-- USER MODAL --}}
                            <div
                                class="modal fade user-modal"
                                id="userModal{{ $user->id }}"
                                tabindex="-1"
                                role="dialog"
                                aria-hidden="true"
                            >

                                <div class="modal-dialog modal-dialog-centered">

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                User Profile
                                            </h5>

                                            <button
                                                type="button"
                                                class="close text-white"
                                                data-dismiss="modal"
                                            >
                                                <span>&times;</span>
                                            </button>

                                        </div>

                                        <div class="modal-body">

                                            <div class="user-profile">

                                                <div class="modal-avatar">

                                                    @if($profileImage)

                                                        <img
                                                            src="{{ $profileImage }}"
                                                            alt="{{ $userName }}"
                                                        >

                                                    @else

                                                        {{ $initials ?: 'U' }}

                                                    @endif

                                                </div>

                                                <div class="modal-user-name">
                                                    {{ $userName }}
                                                </div>

                                                <div class="modal-user-email">
                                                    {{ $user->email }}
                                                </div>

                                            </div>

                                            <div class="detail-row">
                                                <span class="detail-label">
                                                    User ID
                                                </span>

                                                <span class="detail-value">
                                                    #{{ $user->id }}
                                                </span>
                                            </div>

                                            <div class="detail-row">
                                                <span class="detail-label">
                                                    Account Type
                                                </span>

                                                <span class="detail-value">

                                                    @switch($user->utype)

                                                        @case('ADM')
                                                            Administrator
                                                            @break

                                                        @case('SVP')
                                                            Service Provider
                                                            @break

                                                        @case('CST')
                                                            Customer
                                                            @break

                                                        @default
                                                            {{ $user->utype ?: 'Unknown' }}

                                                    @endswitch

                                                </span>
                                            </div>

                                            <div class="detail-row">
                                                <span class="detail-label">
                                                    Email
                                                </span>

                                                <span class="detail-value">
                                                    {{ $user->email }}
                                                </span>
                                            </div>

                                            <div class="detail-row">
                                                <span class="detail-label">
                                                    Verification
                                                </span>

                                                <span class="detail-value">

                                                    @if($isVerified)
                                                        Verified
                                                    @else
                                                        Not verified
                                                    @endif

                                                </span>
                                            </div>

                                            <div class="detail-row">
                                                <span class="detail-label">
                                                    Joined
                                                </span>

                                                <span class="detail-value">

                                                    {{ $user->created_at
                                                        ? $user->created_at->format('d M Y, H:i')
                                                        : '—' }}

                                                </span>
                                            </div>

                                        </div>

                                        <div class="modal-footer">

                                            <button
                                                type="button"
                                                class="btn btn-light-connector"
                                                data-dismiss="modal"
                                            >
                                                Close
                                            </button>

                                            @if(!$isVerified)

                                                <button
                                                    type="button"
                                                    class="btn btn-connector"
                                                    data-dismiss="modal"
                                                    data-toggle="modal"
                                                    data-target="#verifyModal{{ $user->id }}"
                                                >
                                                    Verify User
                                                </button>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                            {{-- VERIFY MODAL --}}
                            @if(!$isVerified)

                                <div
                                    class="modal fade"
                                    id="verifyModal{{ $user->id }}"
                                    tabindex="-1"
                                    role="dialog"
                                    aria-hidden="true"
                                >

                                    <div class="modal-dialog modal-dialog-centered">

                                        <form
                                            method="POST"
                                            action="{{ route('users.verify', $user->id) }}"
                                            class="w-100"
                                        >

                                            @csrf

                                            <div class="modal-content">

                                                <div
                                                    class="modal-header"
                                                    style="background:#254035;color:#fff;border:0;"
                                                >

                                                    <h5 class="modal-title">
                                                        Verify User
                                                    </h5>

                                                    <button
                                                        type="button"
                                                        class="close text-white"
                                                        data-dismiss="modal"
                                                    >
                                                        <span>&times;</span>
                                                    </button>

                                                </div>

                                                <div class="modal-body text-center py-4">

                                                    <div
                                                        class="mb-3"
                                                        style="color:#6B9080;"
                                                    >

                                                        <svg
                                                            width="46"
                                                            height="46"
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="1.5"
                                                        >
                                                            <circle cx="12" cy="12" r="9"/>
                                                            <path d="m8 12 2.5 2.5L16 9"/>
                                                        </svg>

                                                    </div>

                                                    <h5 style="color:#254035;font-weight:800;">
                                                        Verify {{ $user->name }}?
                                                    </h5>

                                                    <p class="text-muted small mb-0">
                                                        This will mark the user's email account
                                                        as verified.
                                                    </p>

                                                </div>

                                                <div class="modal-footer">

                                                    <button
                                                        type="button"
                                                        class="btn btn-light-connector"
                                                        data-dismiss="modal"
                                                    >
                                                        Cancel
                                                    </button>

                                                    <button
                                                        type="submit"
                                                        class="btn btn-connector"
                                                    >
                                                        Yes, Verify
                                                    </button>

                                                </div>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            @endif

                        @endforeach

                        </tbody>

                    </table>

                </div>

                {{-- PAGINATION --}}
                @if($users instanceof \Illuminate\Contracts\Pagination\Paginator ||
                    $users instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)

                    <div class="pagination-area">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">

                            <div class="small text-muted mb-2 mb-md-0">

                                Showing
                                <strong>{{ $users->firstItem() ?? 0 }}</strong>
                                to
                                <strong>{{ $users->lastItem() ?? 0 }}</strong>
                                of
                                <strong>{{ $users->total() }}</strong>
                                users

                            </div>

                            <div>
                                {{ $users->withQueryString()->links() }}
                            </div>

                        </div>

                    </div>

                @endif

            @else

                {{-- EMPTY STATE --}}
                <div class="empty-state">

                    <div class="empty-icon">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.7">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>

                    </div>

                    <div class="empty-title">
                        No users found
                    </div>

                    <p class="empty-description">

                        @if(request()->hasAny(['search', 'utype', 'verification']))

                            Try changing your search or filter criteria.

                        @else

                            There are currently no users registered on the platform.

                        @endif

                    </p>

                    @if(request()->hasAny(['search', 'utype', 'verification']))

                        <a
                            href="{{ route('admin.users') }}"
                            class="btn btn-light-connector"
                        >
                            Clear Filters
                        </a>

                    @endif

                </div>

            @endif

        </div>

    </div>

</div>

<script>
    /*
    |--------------------------------------------------------------------------
    | Connector User Action Menu
    |--------------------------------------------------------------------------
    | This does not depend on Bootstrap JavaScript.
    */

    function toggleUserActions(userId, button) {

        const menu = document.getElementById('userActions' + userId);

        if (!menu) {
            return;
        }

        // Close all other menus
        document.querySelectorAll('.more-menu.show').forEach(function (item) {
            if (item !== menu) {
                item.classList.remove('show');
            }
        });

        // Toggle current menu
        menu.classList.toggle('show');
    }

    /*
    |--------------------------------------------------------------------------
    | Close More Actions when clicking outside
    |--------------------------------------------------------------------------
    */

    document.addEventListener('click', function (event) {

        if (
            !event.target.closest('.more-wrapper')
        ) {
            document
                .querySelectorAll('.more-menu.show')
                .forEach(function (menu) {
                    menu.classList.remove('show');
                });
        }

    });

    /*
    |--------------------------------------------------------------------------
    | Close More Actions with Escape
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {

            document
                .querySelectorAll('.more-menu.show')
                .forEach(function (menu) {
                    menu.classList.remove('show');
                });

        }

    });
</script>

@endsection