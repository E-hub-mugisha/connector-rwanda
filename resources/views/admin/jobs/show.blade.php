@extends('layouts.app')

@section('title', 'Job Details')

@section('content')

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-dark: #254035;
        --connector-soft: #eef5f2;
        --connector-border: #e2e9e5;
        --connector-text: #26332e;
        --connector-muted: #7a8882;
        --connector-danger: #b94b4b;
    }

    .job-show-page {
        padding: 28px 0 50px;
    }

    /* =========================================================
       PAGE HEADER
    ========================================================== */

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .heading-left {
        display: flex;
        align-items: center;
        gap: 13px;
        min-width: 0;
    }

    .back-button {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--connector-border);
        border-radius: 9px;
        background: #fff;
        color: var(--connector-dark);
        text-decoration: none;
        flex-shrink: 0;
        transition: .2s ease;
    }

    .back-button:hover {
        background: var(--connector-soft);
        color: var(--connector-primary);
        border-color: var(--connector-primary);
        text-decoration: none;
    }

    .heading-left h1 {
        margin: 0;
        color: var(--connector-dark);
        font-size: 26px;
        font-weight: 700;
        letter-spacing: -.4px;
    }

    .heading-left p {
        margin: 5px 0 0;
        color: var(--connector-muted);
        font-size: 13px;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .btn-light-action,
    .btn-primary-action {
        min-height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 650;
        text-decoration: none;
        transition: .2s ease;
    }

    .btn-light-action {
        border: 1px solid var(--connector-border);
        background: #fff;
        color: var(--connector-dark);
    }

    .btn-light-action:hover {
        background: var(--connector-soft);
        color: var(--connector-primary);
        border-color: var(--connector-primary);
        text-decoration: none;
    }

    .btn-primary-action {
        border: 0;
        background: var(--connector-primary);
        color: #fff;
    }

    .btn-primary-action:hover {
        background: var(--connector-dark);
        color: #fff;
        text-decoration: none;
    }

    /* =========================================================
       LAYOUT
    ========================================================== */

    .job-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        gap: 22px;
        align-items: start;
    }

    .content-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .content-card:last-child {
        margin-bottom: 0;
    }

    .card-header-custom {
        padding: 19px 22px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .card-header-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-icon {
        width: 35px;
        height: 35px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--connector-soft);
        color: var(--connector-primary);
        flex-shrink: 0;
    }

    .card-header-title h2 {
        margin: 0;
        color: var(--connector-dark);
        font-size: 15px;
        font-weight: 700;
    }

    .card-header-title p {
        margin: 3px 0 0;
        color: var(--connector-muted);
        font-size: 11px;
    }

    .card-body-custom {
        padding: 22px;
    }

    /* =========================================================
       JOB HERO
    ========================================================== */

    .job-hero {
        padding: 25px 22px;
        background:
            linear-gradient(
                135deg,
                #f6faf8 0%,
                #ffffff 70%
            );
        border-bottom: 1px solid var(--connector-border);
    }

    .job-hero-title {
        color: var(--connector-dark);
        font-size: 25px;
        line-height: 1.25;
        font-weight: 750;
        margin: 0 0 13px;
    }

    .job-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 17px;
    }

    .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--connector-muted);
        font-size: 12px;
    }

    .meta-item svg {
        color: var(--connector-primary);
        flex-shrink: 0;
    }

    /* =========================================================
       STATUS
    ========================================================== */

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .status-active {
        color: #26734d;
        background: #e9f6ef;
    }

    .status-pending {
        color: #946b12;
        background: #fff6df;
    }

    .status-closed {
        color: #66716c;
        background: #f1f3f4;
    }

    .status-draft {
        color: #52606b;
        background: #edf1f5;
    }

    /* =========================================================
       CONTENT
    ========================================================== */

    .content-text {
        color: #4e5d56;
        font-size: 13px;
        line-height: 1.75;
        white-space: pre-line;
    }

    .content-text p:last-child {
        margin-bottom: 0;
    }

    .empty-content {
        color: var(--connector-muted);
        font-size: 13px;
        font-style: italic;
    }

    /* =========================================================
       SIDEBAR
    ========================================================== */

    .sidebar-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 18px;
    }

    .sidebar-card:last-child {
        margin-bottom: 0;
    }

    .sidebar-title {
        padding: 18px 19px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .sidebar-title h3 {
        margin: 0;
        color: var(--connector-dark);
        font-size: 14px;
        font-weight: 700;
    }

    .application-total {
        min-width: 28px;
        height: 28px;
        padding: 0 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--connector-soft);
        color: var(--connector-dark);
        border-radius: 8px;
        font-size: 11px;
        font-weight: 750;
    }

    /* =========================================================
       APPLICATIONS
    ========================================================== */

    .applications-list {
        padding: 6px 0;
    }

    .application-item {
        padding: 14px 17px;
        border-bottom: 1px solid #edf1ef;
        transition: .2s ease;
    }

    .application-item:last-child {
        border-bottom: 0;
    }

    .application-item:hover {
        background: #fbfdfc;
    }

    .applicant-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .applicant-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: var(--connector-soft);
        color: var(--connector-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 750;
        flex-shrink: 0;
    }

    .applicant-info {
        min-width: 0;
        flex: 1;
    }

    .applicant-name {
        display: block;
        color: var(--connector-dark);
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .applicant-name:hover {
        color: var(--connector-primary);
        text-decoration: none;
    }

    .applicant-email {
        color: var(--connector-muted);
        font-size: 10px;
        margin-top: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .application-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: 9px;
    }

    .application-date {
        color: var(--connector-muted);
        font-size: 10px;
    }

    .application-status {
        display: inline-flex;
        padding: 4px 7px;
        border-radius: 12px;
        font-size: 9px;
        font-weight: 700;
        text-transform: capitalize;
    }

    .app-pending {
        background: #fff6df;
        color: #946b12;
    }

    .app-reviewed {
        background: #edf3f7;
        color: #536c7b;
    }

    .app-shortlisted {
        background: #e9f6ef;
        color: #26734d;
    }

    .app-accepted {
        background: #e4f4ec;
        color: #1f7049;
    }

    .app-rejected {
        background: #fff0f0;
        color: #b34b4b;
    }

    .application-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        margin: 12px 17px 15px;
        min-height: 39px;
        border: 1px solid var(--connector-border);
        border-radius: 8px;
        background: #fff;
        color: var(--connector-dark);
        font-size: 11px;
        font-weight: 650;
        text-decoration: none;
        transition: .2s;
    }

    .application-link:hover {
        background: var(--connector-soft);
        color: var(--connector-primary);
        border-color: var(--connector-primary);
        text-decoration: none;
    }

    .no-applications {
        padding: 38px 18px;
        text-align: center;
    }

    .no-applications-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 11px;
    }

    .no-applications h4 {
        color: var(--connector-dark);
        font-size: 13px;
        margin: 0 0 5px;
    }

    .no-applications p {
        color: var(--connector-muted);
        font-size: 10px;
        line-height: 1.5;
        margin: 0;
    }

    /* =========================================================
       PROVIDER DETAILS
    ========================================================== */

    .provider-box {
        padding: 18px;
    }

    .provider-profile {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .provider-avatar {
        width: 44px;
        height: 44px;
        border-radius: 11px;
        background: var(--connector-soft);
        color: var(--connector-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 750;
        font-size: 13px;
        flex-shrink: 0;
    }

    .provider-name {
        color: var(--connector-dark);
        font-size: 13px;
        font-weight: 700;
    }

    .provider-email {
        color: var(--connector-muted);
        font-size: 10px;
        margin-top: 3px;
    }

    .provider-details {
        margin-top: 16px;
        padding-top: 15px;
        border-top: 1px solid #edf1ef;
    }

    .detail-line {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 7px 0;
        font-size: 11px;
    }

    .detail-label {
        color: var(--connector-muted);
    }

    .detail-value {
        color: var(--connector-dark);
        font-weight: 600;
        text-align: right;
    }

    /* =========================================================
       JOB SUMMARY
    ========================================================== */

    .summary-list {
        padding: 10px 18px 15px;
    }

    .summary-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 0;
        border-bottom: 1px solid #edf1ef;
    }

    .summary-item:last-child {
        border-bottom: 0;
    }

    .summary-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .summary-label {
        color: var(--connector-muted);
        font-size: 10px;
        margin-bottom: 2px;
    }

    .summary-value {
        color: var(--connector-dark);
        font-size: 11px;
        font-weight: 650;
    }

    /* =========================================================
       ALERT
    ========================================================== */

    .success-alert {
        border: 0;
        border-radius: 10px;
        background: #eaf6ef;
        color: #28714d;
        font-size: 13px;
        padding: 12px 15px;
        margin-bottom: 20px;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================== */

    @media (max-width: 1050px) {
        .job-layout {
            grid-template-columns: minmax(0, 1fr) 310px;
        }
    }

    @media (max-width: 850px) {
        .job-layout {
            grid-template-columns: 1fr;
        }

        .sidebar-card {
            margin-bottom: 18px;
        }

        .job-sidebar {
            order: -1;
        }
    }

    @media (max-width: 650px) {
        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .header-actions {
            width: 100%;
        }

        .btn-light-action,
        .btn-primary-action {
            flex: 1;
        }

        .job-hero-title {
            font-size: 21px;
        }

        .card-header-custom,
        .card-body-custom,
        .job-hero {
            padding-left: 17px;
            padding-right: 17px;
        }
    }
</style>


<div class="container-fluid job-show-page">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="page-header">

        <div class="heading-left">

            <a
                href="{{ route('admin.jobs') }}"
                class="back-button"
                title="Back to jobs"
            >
                <svg width="18" height="18"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">
                    <path d="M19 12H5"/>
                    <path d="m12 19-7-7 7-7"/>
                </svg>
            </a>

            <div>
                <h1>Job Details</h1>
                <p>Review job information and applications.</p>
            </div>

        </div>


        <div class="header-actions">

            <a
                href="{{ route('admin.jobs.edit', $job->id) }}"
                class="btn-light-action"
            >
                <svg width="15" height="15"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                </svg>

                Edit Job
            </a>

            <a
                href="{{ route('admin.jobs.applications', $job->id) }}"
                class="btn-primary-action"
            >
                <svg width="15" height="15"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M19 8v6"/>
                    <path d="M22 11h-6"/>
                </svg>

                Applications
            </a>

        </div>

    </div>


    {{-- =========================================================
         SUCCESS MESSAGE
    ========================================================== --}}

    @if(session('message'))

        <div class="success-alert">
            {{ session('message') }}
        </div>

    @endif


    <div class="job-layout">


        {{-- =====================================================
             LEFT COLUMN
        ====================================================== --}}

        <div class="job-main">


            {{-- Job overview --}}

            <div class="content-card">

                <div class="job-hero">

                    <div style="display:flex; justify-content:space-between; gap:20px; align-items:flex-start;">

                        <div style="min-width:0;">

                            <h2 class="job-hero-title">
                                {{ $job->title }}
                            </h2>

                            <div class="job-meta">

                                <span class="meta-item">

                                    <svg width="14" height="14"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/>
                                        <circle cx="12" cy="10" r="2.5"/>
                                    </svg>

                                    {{ $job->location }}

                                </span>


                                <span class="meta-item">

                                    <svg width="14" height="14"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <rect x="3" y="7" width="18" height="13" rx="2"/>
                                        <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                    </svg>

                                    {{ ucfirst($job->type) }}

                                </span>


                                <span class="meta-item">

                                    <svg width="14" height="14"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 7v5l3 2"/>
                                    </svg>

                                    Deadline:
                                    {{ $job->deadline?->format('d M Y') ?? 'Not set' }}

                                </span>

                            </div>

                        </div>


                        <span class="status-badge status-{{ strtolower($job->status) }}">

                            <span style="
                                width:6px;
                                height:6px;
                                border-radius:50%;
                                background:currentColor;
                            "></span>

                            {{ ucfirst($job->status) }}

                        </span>

                    </div>

                </div>


                {{-- Description --}}

                <div class="card-header-custom">

                    <div class="card-header-title">

                        <div class="section-icon">

                            <svg width="17" height="17"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path d="M4 4h16v16H4z"/>
                                <path d="M8 8h8"/>
                                <path d="M8 12h8"/>
                                <path d="M8 16h5"/>
                            </svg>

                        </div>

                        <div>
                            <h2>Job Description</h2>
                            <p>Overview of the opportunity</p>
                        </div>

                    </div>

                </div>

                <div class="card-body-custom">

                    @if($job->description)

                        <div class="content-text">
                            {!! nl2br(e($job->description)) !!}
                        </div>

                    @else

                        <div class="empty-content">
                            No job description has been provided.
                        </div>

                    @endif

                </div>

            </div>


            {{-- Responsibilities --}}

            <div class="content-card">

                <div class="card-header-custom">

                    <div class="card-header-title">

                        <div class="section-icon">

                            <svg width="17" height="17"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path d="M9 11l3 3L22 4"/>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                            </svg>

                        </div>

                        <div>
                            <h2>Responsibilities</h2>
                            <p>Key duties associated with this position</p>
                        </div>

                    </div>

                </div>

                <div class="card-body-custom">

                    @if($job->responsibilities)

                        <div class="content-text">
                            {!! nl2br(e($job->responsibilities)) !!}
                        </div>

                    @else

                        <div class="empty-content">
                            No responsibilities have been provided.
                        </div>

                    @endif

                </div>

            </div>


            {{-- Requirements --}}

            <div class="content-card">

                <div class="card-header-custom">

                    <div class="card-header-title">

                        <div class="section-icon">

                            <svg width="17" height="17"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path d="M9 11l3 3L22 4"/>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                            </svg>

                        </div>

                        <div>
                            <h2>Requirements</h2>
                            <p>Qualifications and skills expected from applicants</p>
                        </div>

                    </div>

                </div>

                <div class="card-body-custom">

                    @if($job->requirements)

                        <div class="content-text">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>

                    @else

                        <div class="empty-content">
                            No requirements have been provided.
                        </div>

                    @endif

                </div>

            </div>


        </div>


        {{-- =====================================================
             RIGHT SIDEBAR
        ====================================================== --}}

        <div class="job-sidebar">


            {{-- =================================================
                 APPLICATIONS
            ================================================== --}}

            <div class="sidebar-card">

                <div class="sidebar-title">

                    <div>

                        <h3>Job Applications</h3>

                    </div>

                    <span class="application-total">
                        {{ $job->applications_count ?? $job->applications->count() }}
                    </span>

                </div>


                @if($job->applications->count())

                    <div class="applications-list">

                        @foreach($job->applications->take(6) as $application)

                            @php
                                $applicant = $application->user;

                                $applicantName =
                                    $applicant?->name ??
                                    'Unknown Applicant';

                                $words = preg_split(
                                    '/\s+/',
                                    trim($applicantName)
                                );

                                $initials = '';

                                if (count($words) >= 2) {
                                    $initials =
                                        substr($words[0], 0, 1) .
                                        substr($words[count($words) - 1], 0, 1);
                                } else {
                                    $initials =
                                        substr($applicantName, 0, 2);
                                }
                            @endphp

                            <div class="application-item">

                                <div class="applicant-row">

                                    <div class="applicant-avatar">
                                        {{ strtoupper($initials) }}
                                    </div>

                                    <div class="applicant-info">

                                        <a
                                            href="{{ route('admin.job-applications.show', $application->id) }}"
                                            class="applicant-name"
                                        >
                                            {{ $applicantName }}
                                        </a>

                                        @if($applicant?->email)

                                            <div class="applicant-email">
                                                {{ $applicant->email }}
                                            </div>

                                        @else

                                            <div class="applicant-email">
                                                No email available
                                            </div>

                                        @endif

                                    </div>

                                </div>


                                <div class="application-meta">

                                    <span class="application-date">

                                        {{ $application->created_at?->format('d M Y') }}

                                    </span>


                                    <span class="application-status
                                        app-{{ strtolower($application->status ?? 'pending') }}">

                                        {{ ucfirst($application->status ?? 'pending') }}

                                    </span>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    @if($job->applications->count() > 6)

                        <a
                            href="{{ route('admin.jobs.applications', $job->id) }}"
                            class="application-link"
                        >

                            View all
                            {{ $job->applications->count() }}
                            applications

                            <svg width="14" height="14"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path d="M5 12h14"/>
                                <path d="m13 6 6 6-6 6"/>
                            </svg>

                        </a>

                    @else

                        <a
                            href="{{ route('admin.jobs.applications', $job->id) }}"
                            class="application-link"
                        >

                            Manage applications

                            <svg width="14" height="14"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path d="M5 12h14"/>
                                <path d="m13 6 6 6-6 6"/>
                            </svg>

                        </a>

                    @endif


                @else

                    <div class="no-applications">

                        <div class="no-applications-icon">

                            <svg width="21" height="21"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>

                        </div>

                        <h4>No applications yet</h4>

                        <p>
                            Applications submitted for this job will appear here.
                        </p>

                    </div>

                @endif

            </div>


            {{-- =================================================
                 PROVIDER
            ================================================== --}}

            <div class="sidebar-card">

                <div class="sidebar-title">

                    <h3>Service Provider</h3>

                </div>


                <div class="provider-box">

                    @if($job->serviceProvider)

                        @php
                            $providerName =
                                $job->serviceProvider->user?->name ??
                                'Unnamed Provider';

                            $providerWords = preg_split(
                                '/\s+/',
                                trim($providerName)
                            );

                            if (count($providerWords) >= 2) {
                                $providerInitials =
                                    substr($providerWords[0], 0, 1) .
                                    substr(
                                        $providerWords[count($providerWords) - 1],
                                        0,
                                        1
                                    );
                            } else {
                                $providerInitials =
                                    substr($providerName, 0, 2);
                            }
                        @endphp


                        <div class="provider-profile">

                            <div class="provider-avatar">
                                {{ strtoupper($providerInitials) }}
                            </div>

                            <div>

                                <div class="provider-name">
                                    {{ $providerName }}
                                </div>

                                @if($job->serviceProvider->user?->email)

                                    <div class="provider-email">
                                        {{ $job->serviceProvider->user->email }}
                                    </div>

                                @endif

                            </div>

                        </div>


                        <div class="provider-details">

                            @if($job->serviceProvider->category)

                                <div class="detail-line">

                                    <span class="detail-label">
                                        Category
                                    </span>

                                    <span class="detail-value">
                                        {{ $job->serviceProvider->category->name }}
                                    </span>

                                </div>

                            @endif


                            <div class="detail-line">

                                <span class="detail-label">
                                    Provider ID
                                </span>

                                <span class="detail-value">
                                    #{{ $job->serviceProvider->id }}
                                </span>

                            </div>

                        </div>

                    @else

                        <div class="empty-content">
                            No service provider assigned.
                        </div>

                    @endif

                </div>

            </div>


            {{-- =================================================
                 JOB SUMMARY
            ================================================== --}}

            <div class="sidebar-card">

                <div class="sidebar-title">

                    <h3>Job Summary</h3>

                </div>


                <div class="summary-list">


                    {{-- Type --}}

                    <div class="summary-item">

                        <div class="summary-icon">

                            <svg width="14" height="14"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <rect x="3" y="7" width="18" height="13" rx="2"/>
                                <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            </svg>

                        </div>

                        <div>

                            <div class="summary-label">
                                Employment Type
                            </div>

                            <div class="summary-value">
                                {{ ucfirst($job->type) }}
                            </div>

                        </div>

                    </div>


                    {{-- Location --}}

                    <div class="summary-item">

                        <div class="summary-icon">

                            <svg width="14" height="14"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/>
                                <circle cx="12" cy="10" r="2.5"/>
                            </svg>

                        </div>

                        <div>

                            <div class="summary-label">
                                Location
                            </div>

                            <div class="summary-value">
                                {{ $job->location }}
                            </div>

                        </div>

                    </div>


                    {{-- Deadline --}}

                    <div class="summary-item">

                        <div class="summary-icon">

                            <svg width="14" height="14"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>
                            </svg>

                        </div>

                        <div>

                            <div class="summary-label">
                                Application Deadline
                            </div>

                            <div class="summary-value">
                                {{ $job->deadline?->format('d M Y') ?? 'Not set' }}
                            </div>

                        </div>

                    </div>


                    {{-- Created --}}

                    <div class="summary-item">

                        <div class="summary-icon">

                            <svg width="14" height="14"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <path d="M16 2v4"/>
                                <path d="M8 2v4"/>
                                <path d="M3 10h18"/>
                            </svg>

                        </div>

                        <div>

                            <div class="summary-label">
                                Posted
                            </div>

                            <div class="summary-value">
                                {{ $job->created_at?->format('d M Y') }}
                            </div>

                        </div>

                    </div>


                    {{-- Applications --}}

                    <div class="summary-item">

                        <div class="summary-icon">

                            <svg width="14" height="14"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                            </svg>

                        </div>

                        <div>

                            <div class="summary-label">
                                Applications
                            </div>

                            <div class="summary-value">
                                {{ $job->applications_count ?? $job->applications->count() }}
                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>

</div>

@endsection