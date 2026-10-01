@extends('layouts.app')

@section('title', 'Jobs Management')

@section('content')

@php
$totalJobs = $stats['total'] ?? 0;
$openJobs = $stats['open'] ?? 0;
$closedJobs = $stats['closed'] ?? 0;
$totalApplications = $stats['applications'] ?? 0;
@endphp

<div class="content-wrapper jobs-page">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="jobs-hero mb-4">

        <div class="jobs-hero-content">

            <div>

                <div class="hero-eyebrow">
                    <i class="mdi mdi-briefcase-outline"></i>
                    Recruitment Management
                </div>

                <h2>
                    Jobs
                </h2>

                <p>
                    Create, manage and monitor job opportunities
                    published by your service business.
                </p>

            </div>

            <button
                type="button"
                class="btn btn-light hero-add-btn"
                data-bs-toggle="modal"
                data-bs-target="#addJobModal">

                <i class="mdi mdi-plus"></i>

                Add New Job

            </button>

        </div>

    </div>


    {{-- =========================================================
        ALERTS
    ========================================================== --}}

    @if(session('success'))

    <div class="alert alert-success custom-alert alert-dismissible fade show">

        <div class="alert-icon">
            <i class="mdi mdi-check-circle"></i>
        </div>

        <div>
            <strong>Success</strong>
            <div>{{ session('success') }}</div>
        </div>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    @endif


    @if(session('error'))

    <div class="alert alert-danger custom-alert alert-dismissible fade show">

        <div class="alert-icon">
            <i class="mdi mdi-alert-circle"></i>
        </div>

        <div>
            <strong>Something went wrong</strong>
            <div>{{ session('error') }}</div>
        </div>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    @endif


    @if($errors->any())

    <div class="alert alert-danger custom-alert alert-dismissible fade show">

        <div class="alert-icon">
            <i class="mdi mdi-alert-circle"></i>
        </div>

        <div>

            <strong>Please check the following:</strong>

            <ul class="mb-0 mt-1 ps-3">

                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    @endif


    {{-- =========================================================
        STATISTICS
    ========================================================== --}}
    <div class="row g-3 mb-4">

        {{-- Total --}}
        <div class="col-xl-3 col-md-6">

            <div class="job-stat-card">

                <div class="stat-icon">
                    <i class="mdi mdi-briefcase-outline"></i>
                </div>

                <div>

                    <span class="stat-label">
                        Total Jobs
                    </span>

                    <h3>
                        {{ number_format($totalJobs) }}
                    </h3>

                    <small>
                        All published jobs
                    </small>

                </div>

            </div>

        </div>


        {{-- Open --}}
        <div class="col-xl-3 col-md-6">

            <div class="job-stat-card">

                <div class="stat-icon open">
                    <i class="mdi mdi-briefcase-check-outline"></i>
                </div>

                <div>

                    <span class="stat-label">
                        Open Jobs
                    </span>

                    <h3>
                        {{ number_format($openJobs) }}
                    </h3>

                    <small>
                        Currently accepting applications
                    </small>

                </div>

            </div>

        </div>


        {{-- Closed --}}
        <div class="col-xl-3 col-md-6">

            <div class="job-stat-card">

                <div class="stat-icon closed">
                    <i class="mdi mdi-briefcase-remove-outline"></i>
                </div>

                <div>

                    <span class="stat-label">
                        Closed Jobs
                    </span>

                    <h3>
                        {{ number_format($closedJobs) }}
                    </h3>

                    <small>
                        No longer accepting applications
                    </small>

                </div>

            </div>

        </div>


        {{-- Applications --}}
        <div class="col-xl-3 col-md-6">

            <div class="job-stat-card">

                <div class="stat-icon applications">
                    <i class="mdi mdi-account-group-outline"></i>
                </div>

                <div>

                    <span class="stat-label">
                        Applications
                    </span>

                    <h3>
                        {{ number_format($totalApplications) }}
                    </h3>

                    <small>
                        Applications received
                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        JOB MANAGEMENT
    ========================================================== --}}
    <div class="jobs-card">

        <div class="jobs-card-header">

            <div>

                <h4>
                    Job Opportunities
                </h4>

                <p>
                    Manage your vacancies and review applicants.
                </p>

            </div>

            <button
                type="button"
                class="btn btn-connector"
                data-bs-toggle="modal"
                data-bs-target="#addJobModal">

                <i class="mdi mdi-plus"></i>

                Add Job

            </button>

        </div>


        @if($jobs->count())

        <div class="jobs-list">

            @foreach($jobs as $job)

            @php

            $isOpen = strtolower($job->status) === 'open';

            $deadlinePassed =
            $job->deadline &&
            $job->deadline->isPast();

            $jobType = ucfirst(
            str_replace(
            ['-', '_'],
            ' ',
            $job->type
            )
            );

            @endphp


            <div class="job-item">

                {{-- Job Icon --}}
                <div class="job-icon">

                    <i class="mdi mdi-briefcase-outline"></i>

                </div>


                {{-- Main Information --}}
                <div class="job-main">

                    <div class="job-title-row">

                        <h5>
                            {{ $job->title }}
                        </h5>

                        @if($isOpen)

                        <span class="status-badge open">
                            <span></span>
                            Open
                        </span>

                        @else

                        <span class="status-badge closed">
                            <span></span>
                            Closed
                        </span>

                        @endif

                    </div>


                    <div class="job-meta">

                        <span>
                            <i class="mdi mdi-clock-outline"></i>
                            {{ $jobType }}
                        </span>

                        <span>
                            <i class="mdi mdi-map-marker-outline"></i>
                            {{ $job->location ?: 'Location not specified' }}
                        </span>

                        <span>

                            <i class="mdi mdi-calendar-outline"></i>

                            @if($job->deadline)

                            {{ $job->deadline->format('d M Y') }}

                            @else

                            No deadline

                            @endif

                        </span>

                    </div>


                    <div class="job-bottom">

                        <div class="application-summary">

                            <i class="mdi mdi-account-group-outline"></i>

                            <strong>
                                {{ $job->applications_count }}
                            </strong>

                            {{ Str::plural(
                                        'application',
                                        $job->applications_count
                                    ) }}

                        </div>


                        @if($job->deadline)

                        @if($deadlinePassed)

                        <span class="deadline-expired">
                            <i class="mdi mdi-alert-circle-outline"></i>
                            Deadline passed
                        </span>

                        @else

                        <span class="deadline-active">
                            <i class="mdi mdi-calendar-clock-outline"></i>
                            Deadline:
                            {{ $job->deadline->format('d M Y') }}
                        </span>

                        @endif

                        @endif

                    </div>

                </div>


                {{-- Actions --}}
                <div class="job-actions">

                    <!-- view details -->
                    <a 
                        href="{{ route('provider.jobs.show', $job->id) }}"
                        class="action-btn"
                        title="View Job Details">

                        <i class="mdi mdi-eye-outline"></i>
                    </a>

                    <button
                        type="button"
                        class="action-btn"
                        title="Edit Job"
                        data-bs-toggle="modal"
                        data-bs-target="#editJobModal{{ $job->id }}">

                        <i class="mdi mdi-pencil-outline"></i>

                    </button>


                    <button
                        type="button"
                        class="action-btn"
                        title="Update Status"
                        data-bs-toggle="modal"
                        data-bs-target="#updateStatusModal{{ $job->id }}">

                        <i class="mdi mdi-swap-horizontal"></i>

                    </button>


                    <a
                        href="{{ route(
                                    'provider.jobs.applications',
                                    $job->id
                                ) }}"
                        class="action-btn applicants"
                        title="View Applicants">

                        <i class="mdi mdi-account-group-outline"></i>

                        <span>
                            {{ $job->applications_count }}
                        </span>

                    </a>


                    <button
                        type="button"
                        class="action-btn delete"
                        title="Delete Job"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteJobModal{{ $job->id }}">

                        <i class="mdi mdi-delete-outline"></i>

                    </button>

                </div>

            </div>

            @endforeach

        </div>


        {{-- Pagination --}}
        @if(method_exists($jobs, 'links'))

        <div class="jobs-pagination">

            <div class="pagination-info">

                @if($jobs->total() > 0)

                Showing
                <strong>{{ $jobs->firstItem() }}</strong>
                -
                <strong>{{ $jobs->lastItem() }}</strong>
                of
                <strong>{{ $jobs->total() }}</strong>
                jobs

                @endif

            </div>

            <div>
                {{ $jobs->links() }}
            </div>

        </div>

        @endif

        @else

        {{-- Empty State --}}
        <div class="jobs-empty">

            <div class="empty-icon">
                <i class="mdi mdi-briefcase-outline"></i>
            </div>

            <h4>
                No jobs yet
            </h4>

            <p>
                Create your first job opportunity and start
                receiving applications from qualified candidates.
            </p>

            <button
                type="button"
                class="btn btn-connector"
                data-bs-toggle="modal"
                data-bs-target="#addJobModal">

                <i class="mdi mdi-plus"></i>

                Create Your First Job

            </button>

        </div>

        @endif

    </div>

</div>


{{-- =============================================================
     VIEW JOB MODALS
============================================================== --}}

@foreach($jobs as $job)

<div
    class="modal fade"
    id="viewJobModal{{ $job->id }}"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content modern-modal">

            <div class="modal-header modal-header-view">

                <div>

                    <span class="modal-eyebrow">
                        Job Details
                    </span>

                    <h5 class="modal-title">
                        {{ $job->title }}
                    </h5>

                </div>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                {{-- Summary --}}
                <div class="detail-summary">

                    <div class="detail-summary-item">

                        <span>
                            Type
                        </span>

                        <strong>
                            {{ ucfirst(
                                    str_replace(
                                        ['-', '_'],
                                        ' ',
                                        $job->type
                                    )
                                ) }}
                        </strong>

                    </div>


                    <div class="detail-summary-item">

                        <span>
                            Location
                        </span>

                        <strong>
                            {{ $job->location ?: 'Not specified' }}
                        </strong>

                    </div>


                    <div class="detail-summary-item">

                        <span>
                            Deadline
                        </span>

                        <strong>
                            {{ $job->deadline
                                    ? $job->deadline->format('d M Y')
                                    : 'No deadline'
                                }}
                        </strong>

                    </div>


                    <div class="detail-summary-item">

                        <span>
                            Applications
                        </span>

                        <strong>
                            {{ $job->applications_count }}
                        </strong>

                    </div>

                </div>


                {{-- Description --}}
                <div class="detail-section">

                    <h6>
                        <i class="mdi mdi-text-box-outline"></i>
                        Description
                    </h6>

                    <div class="detail-box">
                        {!! nl2br(
                        e($job->description ?: 'No description provided.')
                        ) !!}
                    </div>

                </div>


                {{-- Requirements --}}
                <div class="detail-section">

                    <h6>
                        <i class="mdi mdi-format-list-checks"></i>
                        Requirements
                    </h6>

                    <div class="detail-box">

                        {!! nl2br(
                        e($job->requirements ?: 'No requirements specified.')
                        ) !!}

                    </div>

                </div>


                {{-- Responsibilities --}}
                <div class="detail-section">

                    <h6>
                        <i class="mdi mdi-clipboard-text-outline"></i>
                        Responsibilities
                    </h6>

                    <div class="detail-box">

                        {!! nl2br(
                        e(
                        $job->responsibilities
                        ?: 'No responsibilities specified.'
                        )
                        ) !!}

                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Close

                </button>

                <a
                    href="{{ route(
                            'provider.jobs.applications',
                            $job->id
                        ) }}"
                    class="btn btn-connector">

                    <i class="mdi mdi-account-group-outline"></i>

                    View Applicants

                </a>

            </div>

        </div>

    </div>

</div>

@endforeach


{{-- =============================================================
     UPDATE STATUS MODALS
============================================================== --}}

@foreach($jobs as $job)

<div
    class="modal fade"
    id="updateStatusModal{{ $job->id }}"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <form
            action="{{ route(
                    'provider.jobs.updateStatus',
                    $job->id
                ) }}"
            method="POST"
            class="modal-content modern-modal">

            @csrf
            @method('PUT')

            <div class="modal-header modal-header-status">

                <div>

                    <span class="modal-eyebrow">
                        Job Management
                    </span>

                    <h5 class="modal-title">
                        Update Job Status
                    </h5>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                <div class="status-job-preview">

                    <div class="status-preview-icon">
                        <i class="mdi mdi-briefcase-outline"></i>
                    </div>

                    <div>

                        <strong>
                            {{ $job->title }}
                        </strong>

                        <small>
                            Change the availability of this job.
                        </small>

                    </div>

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Job Status
                    </label>

                    <select
                        name="status"
                        class="form-select"
                        required>

                        <option
                            value="open"
                            {{ $job->status === 'open' ? 'selected' : '' }}>

                            Open — Accepting Applications

                        </option>

                        <option
                            value="closed"
                            {{ $job->status === 'closed' ? 'selected' : '' }}>

                            Closed — Not Accepting Applications

                        </option>

                    </select>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="btn btn-connector">

                    Update Status

                </button>

            </div>

        </form>

    </div>

</div>

@endforeach


{{-- =============================================================
     EDIT JOB MODALS
============================================================== --}}

@foreach($jobs as $job)

<div
    class="modal fade"
    id="editJobModal{{ $job->id }}"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

        <form
            action="{{ route(
                    'provider.jobs.update',
                    $job->id
                ) }}"
            method="POST"
            class="modal-content modern-modal">

            @csrf
            @method('PUT')

            <div class="modal-header modal-header-edit">

                <div>

                    <span class="modal-eyebrow">
                        Job Management
                    </span>

                    <h5 class="modal-title">
                        Edit Job
                    </h5>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                @include(
                'stadmin.jobs.form',
                ['job' => $job]
                )

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="btn btn-connector">

                    <i class="mdi mdi-content-save-outline"></i>

                    Save Changes

                </button>

            </div>

        </form>

    </div>

</div>

@endforeach


{{-- =============================================================
     DELETE MODALS
============================================================== --}}

@foreach($jobs as $job)

<div
    class="modal fade"
    id="deleteJobModal{{ $job->id }}"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <form
            action="{{ route(
                    'provider.jobs.destroy',
                    $job->id
                ) }}"
            method="POST"
            class="modal-content modern-modal">

            @csrf
            @method('DELETE')

            <div class="modal-body delete-modal-body">

                <div class="delete-icon">
                    <i class="mdi mdi-delete-outline"></i>
                </div>

                <h4>
                    Delete this job?
                </h4>

                <p>
                    You are about to permanently delete
                    <strong>{{ $job->title }}</strong>.
                    This action cannot be undone.
                </p>

            </div>


            <div class="modal-footer justify-content-center">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="btn btn-danger">

                    Delete Job

                </button>

            </div>

        </form>

    </div>

</div>

@endforeach


{{-- =============================================================
     ADD JOB MODAL
============================================================== --}}

<div
    class="modal fade"
    id="addJobModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

        <form
            action="{{ route('provider.jobs.store') }}"
            method="POST"
            class="modal-content modern-modal">

            @csrf

            <div class="modal-header modal-header-add">

                <div>

                    <span class="modal-eyebrow">
                        Recruitment
                    </span>

                    <h5 class="modal-title">
                        Create New Job
                    </h5>

                </div>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                @include(
                'stadmin.jobs.form',
                ['job' => null]
                )

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="btn btn-connector">

                    <i class="mdi mdi-plus"></i>

                    Create Job

                </button>

            </div>

        </form>

    </div>

</div>


{{-- =============================================================
     STYLES
============================================================== --}}

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-dark: #254035;
        --connector-light: #eef5f2;
        --connector-border: #e5ebe8;
        --connector-text: #26352f;
        --connector-muted: #7a8781;
    }


    /* =============================================================
   HERO
============================================================= */

    .jobs-hero {
        background: linear-gradient(135deg,
                #254035 0%,
                #6B9080 100%);

        border-radius: 18px;

        padding: 30px;

        color: #fff;

        position: relative;
        overflow: hidden;
    }

    .jobs-hero::after {
        content: "";

        position: absolute;

        width: 280px;
        height: 280px;

        border-radius: 50%;

        border: 45px solid rgba(255, 255, 255, .07);

        right: -80px;
        top: -100px;
    }

    .jobs-hero-content {
        position: relative;
        z-index: 2;

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 25px;
    }

    .hero-eyebrow {
        display: inline-flex;

        align-items: center;

        gap: 6px;

        padding: 6px 12px;

        border-radius: 20px;

        background: rgba(255, 255, 255, .12);

        font-size: 11px;

        font-weight: 600;

        margin-bottom: 10px;
    }

    .jobs-hero h2 {
        color: #fff;

        font-size: 28px;

        font-weight: 700;

        margin: 0 0 7px;
    }

    .jobs-hero p {
        color: rgba(255, 255, 255, .78);

        margin: 0;

        font-size: 13px;
    }

    .hero-add-btn {
        position: relative;

        z-index: 3;

        border: 0;

        border-radius: 10px;

        padding: 11px 18px;

        color: var(--connector-dark);

        font-weight: 600;

        white-space: nowrap;
    }


    /* =============================================================
   ALERTS
============================================================= */

    .custom-alert {
        display: flex;

        align-items: flex-start;

        gap: 12px;

        border: 0;

        border-radius: 12px;

        padding: 14px 16px;

        font-size: 13px;
    }

    .alert-icon {
        font-size: 20px;
    }


    /* =============================================================
   STAT CARDS
============================================================= */

    .job-stat-card {
        background: #fff;

        border: 1px solid var(--connector-border);

        border-radius: 14px;

        padding: 19px;

        display: flex;

        align-items: center;

        gap: 14px;

        height: 100%;

        transition: .2s ease;
    }

    .job-stat-card:hover {
        transform: translateY(-2px);

        box-shadow:
            0 10px 30px rgba(37, 64, 53, .07);
    }

    .stat-icon {
        width: 48px;
        height: 48px;

        flex: 0 0 48px;

        border-radius: 12px;

        display: flex;

        align-items: center;
        justify-content: center;

        background: var(--connector-light);

        color: var(--connector-primary);

        font-size: 22px;
    }

    .stat-icon.open {
        color: #36805e;

        background: #edf7f1;
    }

    .stat-icon.closed {
        color: #7d8783;

        background: #f1f3f2;
    }

    .stat-icon.applications {
        color: #547b6c;

        background: #edf4f1;
    }

    .stat-label {
        display: block;

        color: var(--connector-muted);

        font-size: 11px;

        margin-bottom: 3px;
    }

    .job-stat-card h3 {
        color: var(--connector-dark);

        margin: 0;

        font-size: 23px;

        font-weight: 700;
    }

    .job-stat-card small {
        color: var(--connector-muted);

        font-size: 10px;
    }


    /* =============================================================
   JOB CARD
============================================================= */

    .jobs-card {
        background: #fff;

        border: 1px solid var(--connector-border);

        border-radius: 16px;

        overflow: hidden;
    }

    .jobs-card-header {
        padding: 21px 23px;

        border-bottom: 1px solid var(--connector-border);

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 20px;
    }

    .jobs-card-header h4 {
        color: var(--connector-dark);

        font-size: 17px;

        font-weight: 700;

        margin: 0;
    }

    .jobs-card-header p {
        color: var(--connector-muted);

        font-size: 12px;

        margin: 4px 0 0;
    }


    /* =============================================================
   CONNECTOR BUTTON
============================================================= */

    .btn-connector {
        background: var(--connector-dark);

        color: #fff;

        border: 0;

        border-radius: 9px;

        padding: 9px 15px;

        font-size: 12px;

        font-weight: 600;
    }

    .btn-connector:hover {
        background: var(--connector-primary);

        color: #fff;
    }


    /* =============================================================
   JOB LIST
============================================================= */

    .jobs-list {
        padding: 0 22px;
    }

    .job-item {
        display: flex;

        align-items: center;

        gap: 16px;

        padding: 20px 0;

        border-bottom: 1px solid var(--connector-border);
    }

    .job-item:last-child {
        border-bottom: 0;
    }

    .job-icon {
        width: 48px;
        height: 48px;

        flex: 0 0 48px;

        border-radius: 12px;

        display: flex;

        align-items: center;
        justify-content: center;

        background: var(--connector-light);

        color: var(--connector-dark);

        font-size: 21px;
    }

    .job-main {
        flex: 1;

        min-width: 0;
    }

    .job-title-row {
        display: flex;

        align-items: center;

        gap: 9px;

        margin-bottom: 7px;
    }

    .job-title-row h5 {
        margin: 0;

        color: var(--connector-dark);

        font-size: 14px;

        font-weight: 700;

        white-space: nowrap;

        overflow: hidden;

        text-overflow: ellipsis;
    }

    .status-badge {
        display: inline-flex;

        align-items: center;

        gap: 5px;

        padding: 4px 8px;

        border-radius: 20px;

        font-size: 9px;

        font-weight: 700;

        white-space: nowrap;
    }

    .status-badge span {
        width: 5px;
        height: 5px;

        border-radius: 50%;
    }

    .status-badge.open {
        background: #edf7f1;

        color: #34845c;
    }

    .status-badge.open span {
        background: #34845c;
    }

    .status-badge.closed {
        background: #f0f2f1;

        color: #7c8581;
    }

    .status-badge.closed span {
        background: #7c8581;
    }

    .job-meta {
        display: flex;

        flex-wrap: wrap;

        gap: 15px;

        color: var(--connector-muted);

        font-size: 11px;
    }

    .job-meta span {
        display: inline-flex;

        align-items: center;

        gap: 4px;
    }

    .job-meta i {
        font-size: 14px;

        color: var(--connector-primary);
    }

    .job-bottom {
        display: flex;

        align-items: center;

        gap: 15px;

        margin-top: 9px;

        flex-wrap: wrap;
    }

    .application-summary {
        color: var(--connector-muted);

        font-size: 11px;
    }

    .application-summary i {
        color: var(--connector-primary);
    }

    .application-summary strong {
        color: var(--connector-dark);
    }

    .deadline-active,
    .deadline-expired {
        font-size: 10px;
    }

    .deadline-active {
        color: var(--connector-primary);
    }

    .deadline-expired {
        color: #b06b6b;
    }


    /* =============================================================
   ACTIONS
============================================================= */

    .job-actions {
        display: flex;

        align-items: center;

        gap: 5px;
    }

    .action-btn {
        width: 34px;
        height: 34px;

        border: 1px solid var(--connector-border);

        border-radius: 8px;

        background: #fff;

        color: var(--connector-muted);

        display: inline-flex;

        align-items: center;
        justify-content: center;

        text-decoration: none;

        transition: .2s ease;

        font-size: 16px;
    }

    .action-btn:hover {
        background: var(--connector-light);

        border-color: var(--connector-primary);

        color: var(--connector-dark);
    }

    .action-btn.applicants {
        gap: 3px;

        width: auto;

        padding: 0 9px;

        font-size: 15px;
    }

    .action-btn.applicants span {
        font-size: 10px;

        font-weight: 700;
    }

    .action-btn.delete:hover {
        background: #fff1f1;

        border-color: #e1b6b6;

        color: #bd5d5d;
    }


    /* =============================================================
   PAGINATION
============================================================= */

    .jobs-pagination {
        border-top: 1px solid var(--connector-border);

        padding: 18px 22px;

        display: flex;

        justify-content: space-between;

        align-items: center;

        gap: 15px;
    }

    .pagination-info {
        color: var(--connector-muted);

        font-size: 11px;
    }

    .pagination {
        margin: 0;
    }


    /* =============================================================
   EMPTY STATE
============================================================= */

    .jobs-empty {
        text-align: center;

        padding: 70px 25px;
    }

    .empty-icon {
        width: 70px;
        height: 70px;

        margin: 0 auto 17px;

        border-radius: 50%;

        background: var(--connector-light);

        color: var(--connector-primary);

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 32px;
    }

    .jobs-empty h4 {
        color: var(--connector-dark);

        font-size: 18px;

        font-weight: 700;

        margin-bottom: 7px;
    }

    .jobs-empty p {
        max-width: 480px;

        margin: 0 auto 20px;

        color: var(--connector-muted);

        font-size: 12px;

        line-height: 1.7;
    }


    /* =============================================================
   MODALS
============================================================= */

    .modern-modal {
        border: 0;

        border-radius: 16px;

        overflow: hidden;
    }

    .modal-header {
        padding: 20px 23px;

        border-bottom: 0;
    }

    .modal-header-view {
        background: linear-gradient(135deg,
                #254035,
                #6B9080);

        color: #fff;
    }

    .modal-header-add {
        background: linear-gradient(135deg,
                #254035,
                #6B9080);

        color: #fff;
    }

    .modal-header-edit {
        background: var(--connector-light);

        color: var(--connector-dark);

        border-bottom: 1px solid var(--connector-border);
    }

    .modal-header-status {
        background: #f4f6f5;

        color: var(--connector-dark);

        border-bottom: 1px solid var(--connector-border);
    }

    .modal-eyebrow {
        display: block;

        font-size: 9px;

        text-transform: uppercase;

        letter-spacing: .08em;

        opacity: .7;

        margin-bottom: 4px;
    }

    .modal-title {
        margin: 0;

        font-size: 18px;

        font-weight: 700;
    }

    .modal-body {
        padding: 23px;
    }

    .modal-footer {
        padding: 15px 23px;

        border-top: 1px solid var(--connector-border);
    }


    /* =============================================================
   VIEW DETAILS
============================================================= */

    .detail-summary {
        display: grid;

        grid-template-columns: repeat(4, 1fr);

        gap: 10px;

        margin-bottom: 25px;
    }

    .detail-summary-item {
        background: var(--connector-light);

        border-radius: 10px;

        padding: 13px;
    }

    .detail-summary-item span {
        display: block;

        color: var(--connector-muted);

        font-size: 10px;

        margin-bottom: 5px;
    }

    .detail-summary-item strong {
        color: var(--connector-dark);

        font-size: 12px;

        font-weight: 700;
    }

    .detail-section {
        margin-bottom: 20px;
    }

    .detail-section h6 {
        color: var(--connector-dark);

        font-size: 13px;

        font-weight: 700;

        margin-bottom: 8px;

        display: flex;

        align-items: center;

        gap: 6px;
    }

    .detail-section h6 i {
        color: var(--connector-primary);

        font-size: 17px;
    }

    .detail-box {
        background: #f8faf9;

        border: 1px solid var(--connector-border);

        border-radius: 10px;

        padding: 14px;

        color: #59665f;

        font-size: 12px;

        line-height: 1.7;
    }


    /* =============================================================
   STATUS MODAL
============================================================= */

    .status-job-preview {
        display: flex;

        align-items: center;

        gap: 12px;

        background: var(--connector-light);

        padding: 14px;

        border-radius: 11px;

        margin-bottom: 20px;
    }

    .status-preview-icon {
        width: 42px;
        height: 42px;

        border-radius: 10px;

        background: #fff;

        color: var(--connector-primary);

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 19px;
    }

    .status-job-preview strong {
        display: block;

        color: var(--connector-dark);

        font-size: 13px;
    }

    .status-job-preview small {
        display: block;

        color: var(--connector-muted);

        font-size: 10px;

        margin-top: 3px;
    }


    /* =============================================================
   DELETE MODAL
============================================================= */

    .delete-modal-body {
        text-align: center;

        padding: 35px 25px 20px;
    }

    .delete-icon {
        width: 64px;
        height: 64px;

        margin: 0 auto 15px;

        border-radius: 50%;

        background: #fff0f0;

        color: #c55c5c;

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 29px;
    }

    .delete-modal-body h4 {
        color: var(--connector-dark);

        font-size: 18px;

        font-weight: 700;
    }

    .delete-modal-body p {
        color: var(--connector-muted);

        font-size: 12px;

        line-height: 1.7;

        max-width: 420px;

        margin: 0 auto;
    }


    /* =============================================================
   RESPONSIVE
============================================================= */

    @media(max-width: 991px) {

        .job-item {
            align-items: flex-start;
        }

        .job-actions {
            flex-wrap: wrap;

            justify-content: flex-end;

            max-width: 160px;
        }

        .detail-summary {
            grid-template-columns: repeat(2, 1fr);
        }

    }

    @media(max-width: 767px) {

        .jobs-hero-content {
            flex-direction: column;

            align-items: flex-start;
        }

        .jobs-card-header {
            flex-direction: column;

            align-items: flex-start;
        }

        .job-item {
            flex-wrap: wrap;
        }

        .job-main {
            width: calc(100% - 65px);
        }

        .job-actions {
            width: 100%;

            max-width: none;

            justify-content: flex-start;

            padding-left: 64px;
        }

        .jobs-pagination {
            flex-direction: column;

            align-items: flex-start;
        }

    }

    @media(max-width: 575px) {

        .jobs-hero {
            padding: 22px;
        }

        .jobs-hero h2 {
            font-size: 23px;
        }

        .job-meta {
            flex-direction: column;

            gap: 5px;
        }

        .detail-summary {
            grid-template-columns: 1fr;
        }

    }
</style>

@endsection