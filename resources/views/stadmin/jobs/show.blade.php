@extends('layouts.app')

@section('title', 'Job Details')

@section('content')

@php
$jobType = ucfirst(
str_replace(
['-', '_'],
' ',
$job->type
)
);

$isOpen = strtolower($job->status) === 'open';

$deadlinePassed =
$job->deadline &&
$job->deadline->isPast();

$applicationStatuses = [
'pending' => 'Pending',
'shortlisted' => 'Shortlisted',
'accepted' => 'Accepted',
'rejected' => 'Rejected',
];
@endphp


<div class="content-wrapper job-details-page">

    {{-- =========================================================
        BACK NAVIGATION
    ========================================================== --}}

    <div class="page-back mb-3">

        <a
            href="{{ route('provider.jobs.index') }}"
            class="back-link">

            <i class="mdi mdi-arrow-left"></i>

            Back to Jobs

        </a>

    </div>


    {{-- =========================================================
        JOB HEADER
    ========================================================== --}}

    <div class="job-detail-hero mb-4">

        <div class="job-detail-icon">

            <i class="mdi mdi-briefcase-outline"></i>

        </div>

        <div class="job-detail-heading">

            <div class="d-flex align-items-center gap-2 flex-wrap">

                <h2>
                    {{ $job->title }}
                </h2>

                @if($isOpen)

                <span class="hero-status open">
                    <span></span>
                    Open
                </span>

                @else

                <span class="hero-status closed">
                    <span></span>
                    Closed
                </span>

                @endif

            </div>

            <p>
                Manage this job and review applications from candidates.
            </p>

        </div>

        <div class="job-detail-actions">

            <a
                href="{{ route('provider.jobs.index') }}"
                class="btn btn-light">

                <i class="mdi mdi-format-list-bulleted"></i>

                All Jobs

            </a>

        </div>

    </div>


    {{-- =========================================================
        SUMMARY
    ========================================================== --}}

    <div class="row g-3 mb-4">

        <div class="col-lg-3 col-md-6">

            <div class="summary-card">

                <div class="summary-icon">
                    <i class="mdi mdi-account-group-outline"></i>
                </div>

                <div>
                    <span>Total Applications</span>
                    <strong>
                        {{ $applicationStats['total'] }}
                    </strong>
                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="summary-card">

                <div class="summary-icon pending">
                    <i class="mdi mdi-clock-outline"></i>
                </div>

                <div>
                    <span>Pending</span>
                    <strong>
                        {{ $applicationStats['pending'] }}
                    </strong>
                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="summary-card">

                <div class="summary-icon shortlisted">
                    <i class="mdi mdi-star-outline"></i>
                </div>

                <div>
                    <span>Shortlisted</span>
                    <strong>
                        {{ $applicationStats['shortlisted'] }}
                    </strong>
                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="summary-card">

                <div class="summary-icon accepted">
                    <i class="mdi mdi-check-circle-outline"></i>
                </div>

                <div>
                    <span>Accepted</span>
                    <strong>
                        {{ $applicationStats['accepted'] }}
                    </strong>
                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}

    <div class="row g-4">


        {{-- =====================================================
            LEFT: JOB DETAILS
        ====================================================== --}}

        <div class="col-xl-7 col-lg-7">

            <div class="details-card">

                <div class="details-card-header">

                    <div>

                        <h4>
                            Job Information
                        </h4>

                        <p>
                            Complete details of this opportunity.
                        </p>

                    </div>

                </div>


                <div class="details-card-body">


                    {{-- Job Metadata --}}
                    <div class="job-info-grid">

                        <div class="info-box">

                            <div class="info-icon">
                                <i class="mdi mdi-briefcase-outline"></i>
                            </div>

                            <div>
                                <span>Job Type</span>

                                <strong>
                                    {{ $jobType }}
                                </strong>
                            </div>

                        </div>


                        <div class="info-box">

                            <div class="info-icon">
                                <i class="mdi mdi-map-marker-outline"></i>
                            </div>

                            <div>
                                <span>Location</span>

                                <strong>
                                    {{ $job->location ?: 'Not specified' }}
                                </strong>
                            </div>

                        </div>


                        <div class="info-box">

                            <div class="info-icon">
                                <i class="mdi mdi-calendar-outline"></i>
                            </div>

                            <div>
                                <span>Application Deadline</span>

                                <strong>

                                    @if($job->deadline)

                                    {{ $job->deadline->format('d M Y') }}

                                    @else

                                    No deadline

                                    @endif

                                </strong>
                            </div>

                        </div>


                        <div class="info-box">

                            <div class="info-icon">
                                <i class="mdi mdi-check-circle-outline"></i>
                            </div>

                            <div>
                                <span>Status</span>

                                <strong>
                                    {{ ucfirst($job->status) }}
                                </strong>
                            </div>

                        </div>

                    </div>


                    {{-- Description --}}
                    <div class="detail-section">

                        <h5>
                            <i class="mdi mdi-text-box-outline"></i>
                            Job Description
                        </h5>

                        <div class="detail-content">

                            {!! nl2br(
                            e(
                            $job->description
                            ?: 'No description provided.'
                            )
                            ) !!}

                        </div>

                    </div>


                    {{-- Requirements --}}
                    <div class="detail-section">

                        <h5>
                            <i class="mdi mdi-format-list-checks"></i>
                            Requirements
                        </h5>

                        <div class="detail-content">

                            {!! nl2br(
                            e(
                            $job->requirements
                            ?: 'No requirements specified.'
                            )
                            ) !!}

                        </div>

                    </div>


                    {{-- Responsibilities --}}
                    <div class="detail-section">

                        <h5>
                            <i class="mdi mdi-clipboard-text-outline"></i>
                            Responsibilities
                        </h5>

                        <div class="detail-content">

                            {!! nl2br(
                            e(
                            $job->responsibilities
                            ?: 'No responsibilities specified.'
                            )
                            ) !!}

                        </div>

                    </div>


                    {{-- Provider --}}
                    <div class="provider-section">

                        <div class="provider-avatar">

                            {{ strtoupper(
                                substr(
                                    $sprovider->user->name ?? 'P',
                                    0,
                                    1
                                )
                            ) }}

                        </div>

                        <div>

                            <span>
                                Published by
                            </span>

                            <strong>
                                {{ $sprovider->user->name ?? 'Service Provider' }}
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            RIGHT: APPLICATIONS
        ====================================================== --}}

        <div class="col-xl-5 col-lg-5">

            <div class="applications-card">

                <div class="applications-header">

                    <div>

                        <h4>
                            Applications
                        </h4>

                        <p>
                            Candidates who applied for this job.
                        </p>

                    </div>

                    <div class="application-count">
                        {{ $applicationStats['total'] }}
                    </div>

                </div>


                @if($job->applications->count())

                <div class="applications-list">

                    @foreach($job->applications as $application)

                    @php

                    $candidateName =
                    $application->user->name
                    ?? 'Unknown Candidate';

                    $candidateInitials =
                    collect(
                    preg_split(
                    '/\s+/',
                    trim($candidateName)
                    )
                    )
                    ->filter()
                    ->take(2)
                    ->map(function ($name) {
                    return strtoupper(
                    substr($name, 0, 1)
                    );
                    })
                    ->implode('');

                    $applicationStatus =
                    strtolower(
                    $application->status
                    ?? 'pending'
                    );

                    @endphp


                    <div class="application-item">

                        {{-- Candidate --}}
                        <div class="candidate-top">

                            <div class="candidate-avatar">

                                {{ $candidateInitials ?: 'C' }}

                            </div>

                            <div class="candidate-info">

                                <h6>
                                    {{ $candidateName }}
                                </h6>

                                @if($application->user?->email)

                                <span>
                                    <i class="mdi mdi-email-outline"></i>
                                    {{ $application->user->email }}
                                </span>

                                @endif

                            </div>

                        </div>


                        {{-- Application Status --}}
                        <div class="application-status-row">

                            @switch($applicationStatus)

                            @case('accepted')

                            <span class="application-status accepted">
                                <i class="mdi mdi-check-circle"></i>
                                Accepted
                            </span>

                            @break

                            @case('shortlisted')

                            <span class="application-status shortlisted">
                                <i class="mdi mdi-star"></i>
                                Shortlisted
                            </span>

                            @break

                            @case('rejected')

                            <span class="application-status rejected">
                                <i class="mdi mdi-close-circle"></i>
                                Rejected
                            </span>

                            @break

                            @default

                            <span class="application-status pending">
                                <i class="mdi mdi-clock-outline"></i>
                                Pending
                            </span>

                            @endswitch

                            <small>
                                {{ $application->created_at?->diffForHumans() }}
                            </small>

                        </div>


                        {{-- Cover Letter --}}
                        @if($application->cover_letter)

                        <div class="cover-preview">

                            <i class="mdi mdi-format-quote-open"></i>

                            <p>
                                {{ \Illuminate\Support\Str::limit(
                                                $application->cover_letter,
                                                140
                                            ) }}
                            </p>

                        </div>

                        @endif


                        {{-- Actions --}}
                        <div class="application-actions">

                            <button
                                type="button"
                                class="btn btn-sm btn-outline-connector"
                                data-bs-toggle="modal"
                                data-bs-target="#applicationModal{{ $application->id }}">

                                <i class="mdi mdi-eye-outline"></i>

                                View Application

                            </button>


                            @if($application->resume)

                            <a
                                href="{{ asset('storage/' . $application->resume) }}"
                                target="_blank"
                                class="btn btn-sm btn-outline-secondary">

                                <i class="mdi mdi-file-document-outline"></i>

                                Resume

                            </a>

                            @endif

                        </div>

                    </div>

                    @endforeach

                </div>

                @else

                <div class="applications-empty">

                    <div class="empty-icon">
                        <i class="mdi mdi-account-search-outline"></i>
                    </div>

                    <h5>
                        No applications yet
                    </h5>

                    <p>
                        Applications from candidates will appear
                        here when they apply for this job.
                    </p>

                </div>

                @endif

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     APPLICATION MODALS
============================================================== --}}

@foreach($job->applications as $application)

@php

$candidateName =
$application->user->name
?? 'Unknown Candidate';

$applicationStatus =
strtolower(
$application->status ?? 'pending'
);

@endphp


<div
    class="modal fade"
    id="applicationModal{{ $application->id }}"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content application-modal">

            {{-- Header --}}
            <div class="modal-header application-modal-header">

                <div class="candidate-modal-heading">

                    <div class="candidate-modal-avatar">

                        {{ strtoupper(
                                substr(
                                    $candidateName,
                                    0,
                                    1
                                )
                            ) }}

                    </div>

                    <div>

                        <span>
                            Job Application
                        </span>

                        <h5>
                            {{ $candidateName }}
                        </h5>

                    </div>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            {{-- Body --}}
            <div class="modal-body">


                {{-- Candidate Information --}}
                <div class="candidate-contact">

                    <div>

                        <span>
                            Email
                        </span>

                        <strong>
                            {{ $application->user->email ?? 'Not provided' }}
                        </strong>

                    </div>


                    @if($application->user?->phone)

                    <div>

                        <span>
                            Phone
                        </span>

                        <strong>
                            {{ $application->user->phone }}
                        </strong>

                    </div>

                    @endif


                    <div>

                        <span>
                            Applied
                        </span>

                        <strong>
                            {{ $application->created_at?->format('d M Y, H:i') }}
                        </strong>

                    </div>

                </div>


                {{-- Cover Letter --}}
                <div class="modal-detail-section">

                    <h6>
                        <i class="mdi mdi-email-edit-outline"></i>
                        Cover Letter
                    </h6>

                    <div class="modal-detail-box">

                        {!! nl2br(
                        e(
                        $application->cover_letter
                        ?: 'No cover letter provided.'
                        )
                        ) !!}

                    </div>

                </div>


                {{-- Resume --}}
                @if($application->resume)

                <div class="resume-box">

                    <div class="resume-icon">
                        <i class="mdi mdi-file-document-outline"></i>
                    </div>

                    <div>

                        <strong>
                            Candidate Resume
                        </strong>

                        <small>
                            Resume submitted with this application
                        </small>

                    </div>

                    <a
                        href="{{ asset('storage/' . $application->resume) }}"
                        target="_blank"
                        class="btn btn-sm btn-connector">

                        <i class="mdi mdi-open-in-new"></i>

                        Open Resume

                    </a>

                </div>

                @endif


                {{-- Status --}}
                <div class="modal-detail-section">

                    <h6>
                        <i class="mdi mdi-swap-horizontal"></i>
                        Application Status
                    </h6>

                    <form
                        action="{{ route(
                                'provider.jobs.applications.updateStatus',
                                $application->id
                            ) }}"
                        method="POST">

                        @csrf
                        @method('PUT')

                        <div class="status-action-box">

                            <select
                                name="status"
                                class="form-select"
                                required>

                                @foreach($applicationStatuses as $value => $label)

                                <option
                                    value="{{ $value }}"
                                    {{ $applicationStatus === $value ? 'selected' : '' }}>

                                    {{ $label }}

                                </option>

                                @endforeach

                            </select>

                            <button
                                type="submit"
                                class="btn btn-connector">

                                <i class="mdi mdi-content-save-outline"></i>

                                Update Status

                            </button>

                        </div>

                    </form>

                </div>

            </div>


            {{-- Footer --}}
            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>

@endforeach


{{-- =============================================================
     STYLES
============================================================== --}}

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-dark: #254035;
        --connector-light: #eef5f2;
        --connector-border: #e4ebe7;
        --connector-muted: #7b8782;
        --connector-text: #293831;
    }


    /* =============================================================
   BACK LINK
============================================================= */

    .page-back {
        padding-top: 3px;
    }

    .back-link {
        display: inline-flex;

        align-items: center;

        gap: 6px;

        color: var(--connector-muted);

        text-decoration: none;

        font-size: 12px;

        font-weight: 600;
    }

    .back-link:hover {
        color: var(--connector-dark);
    }


    /* =============================================================
   HERO
============================================================= */

    .job-detail-hero {
        background: linear-gradient(135deg,
                var(--connector-dark),
                var(--connector-primary));

        border-radius: 17px;

        padding: 25px;

        display: flex;

        align-items: center;

        gap: 17px;

        position: relative;

        overflow: hidden;
    }

    .job-detail-hero::after {
        content: "";

        position: absolute;

        width: 220px;
        height: 220px;

        border: 35px solid rgba(255, 255, 255, .07);

        border-radius: 50%;

        right: -80px;
        top: -90px;
    }

    .job-detail-icon {
        width: 58px;
        height: 58px;

        flex: 0 0 58px;

        background: rgba(255, 255, 255, .13);

        border-radius: 14px;

        display: flex;

        align-items: center;

        justify-content: center;

        color: #fff;

        font-size: 27px;
    }

    .job-detail-heading {
        flex: 1;

        position: relative;

        z-index: 2;
    }

    .job-detail-heading h2 {
        margin: 0;

        color: #fff;

        font-size: 23px;

        font-weight: 700;
    }

    .job-detail-heading p {
        margin: 5px 0 0;

        color: rgba(255, 255, 255, .72);

        font-size: 12px;
    }

    .job-detail-actions {
        position: relative;

        z-index: 2;
    }

    .hero-status {
        display: inline-flex;

        align-items: center;

        gap: 5px;

        padding: 5px 9px;

        border-radius: 20px;

        font-size: 9px;

        font-weight: 700;
    }

    .hero-status span {
        width: 5px;
        height: 5px;

        border-radius: 50%;
    }

    .hero-status.open {
        background: rgba(255, 255, 255, .15);

        color: #fff;
    }

    .hero-status.open span {
        background: #fff;
    }

    .hero-status.closed {
        background: rgba(0, 0, 0, .15);

        color: rgba(255, 255, 255, .75);
    }

    .hero-status.closed span {
        background: rgba(255, 255, 255, .6);
    }


    /* =============================================================
   SUMMARY
============================================================= */

    .summary-card {
        background: #fff;

        border: 1px solid var(--connector-border);

        border-radius: 13px;

        padding: 17px;

        display: flex;

        align-items: center;

        gap: 13px;

        height: 100%;
    }

    .summary-icon {
        width: 43px;
        height: 43px;

        border-radius: 11px;

        background: var(--connector-light);

        color: var(--connector-primary);

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 20px;
    }

    .summary-icon.pending {
        background: #f5f2e9;

        color: #a88b4b;
    }

    .summary-icon.shortlisted {
        background: #eef3f0;

        color: #657d70;
    }

    .summary-icon.accepted {
        background: #edf7f1;

        color: #38805c;
    }

    .summary-card span {
        display: block;

        color: var(--connector-muted);

        font-size: 10px;

        margin-bottom: 3px;
    }

    .summary-card strong {
        display: block;

        color: var(--connector-dark);

        font-size: 20px;

        font-weight: 700;
    }


    /* =============================================================
   DETAILS CARD
============================================================= */

    .details-card,
    .applications-card {
        background: #fff;

        border: 1px solid var(--connector-border);

        border-radius: 15px;

        overflow: hidden;
    }

    .details-card-header,
    .applications-header {
        padding: 20px;

        border-bottom: 1px solid var(--connector-border);

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 15px;
    }

    .details-card-header h4,
    .applications-header h4 {
        color: var(--connector-dark);

        font-size: 16px;

        font-weight: 700;

        margin: 0;
    }

    .details-card-header p,
    .applications-header p {
        color: var(--connector-muted);

        font-size: 11px;

        margin: 4px 0 0;
    }

    .details-card-body {
        padding: 20px;
    }


    /* =============================================================
   JOB INFO
============================================================= */

    .job-info-grid {
        display: grid;

        grid-template-columns: repeat(2, 1fr);

        gap: 10px;

        margin-bottom: 25px;
    }

    .info-box {
        display: flex;

        align-items: center;

        gap: 10px;

        padding: 13px;

        background: #f8faf9;

        border: 1px solid var(--connector-border);

        border-radius: 10px;
    }

    .info-icon {
        width: 36px;
        height: 36px;

        flex: 0 0 36px;

        background: var(--connector-light);

        color: var(--connector-primary);

        border-radius: 9px;

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 17px;
    }

    .info-box span {
        display: block;

        color: var(--connector-muted);

        font-size: 9px;

        margin-bottom: 3px;
    }

    .info-box strong {
        display: block;

        color: var(--connector-dark);

        font-size: 11px;

        font-weight: 700;
    }


    /* =============================================================
   DETAILS SECTIONS
============================================================= */

    .detail-section {
        margin-bottom: 23px;
    }

    .detail-section h5 {
        display: flex;

        align-items: center;

        gap: 6px;

        color: var(--connector-dark);

        font-size: 13px;

        font-weight: 700;

        margin-bottom: 9px;
    }

    .detail-section h5 i {
        color: var(--connector-primary);

        font-size: 17px;
    }

    .detail-content {
        background: #f8faf9;

        border: 1px solid var(--connector-border);

        border-radius: 10px;

        padding: 14px;

        color: #5c6963;

        font-size: 12px;

        line-height: 1.8;
    }


    /* =============================================================
   PROVIDER
============================================================= */

    .provider-section {
        border-top: 1px solid var(--connector-border);

        padding-top: 18px;

        display: flex;

        align-items: center;

        gap: 10px;
    }

    .provider-avatar {
        width: 40px;
        height: 40px;

        border-radius: 50%;

        background: var(--connector-dark);

        color: #fff;

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 13px;

        font-weight: 700;
    }

    .provider-section span {
        display: block;

        color: var(--connector-muted);

        font-size: 9px;
    }

    .provider-section strong {
        display: block;

        color: var(--connector-dark);

        font-size: 12px;

        margin-top: 2px;
    }


    /* =============================================================
   APPLICATIONS
============================================================= */

    .application-count {
        min-width: 32px;
        height: 32px;

        border-radius: 9px;

        background: var(--connector-light);

        color: var(--connector-dark);

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 12px;

        font-weight: 700;
    }

    .applications-list {
        padding: 0 18px;
    }

    .application-item {
        padding: 18px 0;

        border-bottom: 1px solid var(--connector-border);
    }

    .application-item:last-child {
        border-bottom: 0;
    }

    .candidate-top {
        display: flex;

        align-items: center;

        gap: 10px;
    }

    .candidate-avatar {
        width: 42px;
        height: 42px;

        flex: 0 0 42px;

        border-radius: 50%;

        background: var(--connector-dark);

        color: #fff;

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 12px;

        font-weight: 700;
    }

    .candidate-info {
        min-width: 0;
    }

    .candidate-info h6 {
        color: var(--connector-dark);

        font-size: 12px;

        font-weight: 700;

        margin: 0 0 4px;
    }

    .candidate-info span {
        display: flex;

        align-items: center;

        gap: 3px;

        color: var(--connector-muted);

        font-size: 9px;

        overflow: hidden;

        text-overflow: ellipsis;

        white-space: nowrap;
    }


    /* =============================================================
   APPLICATION STATUS
============================================================= */

    .application-status-row {
        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 10px;

        margin: 11px 0;
    }

    .application-status {
        display: inline-flex;

        align-items: center;

        gap: 4px;

        padding: 5px 8px;

        border-radius: 20px;

        font-size: 9px;

        font-weight: 700;
    }

    .application-status.pending {
        background: #f6f2e8;

        color: #9b8045;
    }

    .application-status.shortlisted {
        background: #eef3f0;

        color: #607b6d;
    }

    .application-status.accepted {
        background: #edf7f1;

        color: #34845c;
    }

    .application-status.rejected {
        background: #fbeeee;

        color: #b05e5e;
    }

    .application-status-row small {
        color: var(--connector-muted);

        font-size: 9px;
    }


    /* =============================================================
   COVER LETTER PREVIEW
============================================================= */

    .cover-preview {
        display: flex;

        gap: 7px;

        background: #f8faf9;

        border-radius: 9px;

        padding: 10px;

        margin-bottom: 11px;
    }

    .cover-preview i {
        color: var(--connector-primary);

        font-size: 17px;
    }

    .cover-preview p {
        color: #68746e;

        font-size: 10px;

        line-height: 1.6;

        margin: 0;
    }


    /* =============================================================
   APPLICATION ACTIONS
============================================================= */

    .application-actions {
        display: flex;

        flex-wrap: wrap;

        gap: 6px;
    }

    .btn-outline-connector {
        border: 1px solid var(--connector-primary);

        color: var(--connector-dark);

        background: #fff;

        border-radius: 7px;

        font-size: 10px;
    }

    .btn-outline-connector:hover {
        background: var(--connector-light);

        color: var(--connector-dark);
    }


    /* =============================================================
   EMPTY
============================================================= */

    .applications-empty {
        text-align: center;

        padding: 50px 20px;
    }

    .applications-empty .empty-icon {
        width: 55px;
        height: 55px;

        margin: 0 auto 12px;

        border-radius: 50%;

        background: var(--connector-light);

        color: var(--connector-primary);

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 25px;
    }

    .applications-empty h5 {
        color: var(--connector-dark);

        font-size: 14px;

        font-weight: 700;
    }

    .applications-empty p {
        color: var(--connector-muted);

        font-size: 11px;

        line-height: 1.6;

        margin: 0 auto;

        max-width: 300px;
    }


    /* =============================================================
   APPLICATION MODAL
============================================================= */

    .application-modal {
        border: 0;

        border-radius: 15px;

        overflow: hidden;
    }

    .application-modal-header {
        background: var(--connector-light);

        border-bottom: 1px solid var(--connector-border);

        padding: 18px 20px;
    }

    .candidate-modal-heading {
        display: flex;

        align-items: center;

        gap: 10px;
    }

    .candidate-modal-avatar {
        width: 43px;
        height: 43px;

        border-radius: 50%;

        background: var(--connector-dark);

        color: #fff;

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 12px;

        font-weight: 700;
    }

    .candidate-modal-heading span {
        color: var(--connector-muted);

        font-size: 9px;

        display: block;
    }

    .candidate-modal-heading h5 {
        color: var(--connector-dark);

        font-size: 15px;

        font-weight: 700;

        margin: 3px 0 0;
    }


    /* =============================================================
   CANDIDATE CONTACT
============================================================= */

    .candidate-contact {
        display: grid;

        grid-template-columns: repeat(3, 1fr);

        gap: 10px;

        margin-bottom: 23px;
    }

    .candidate-contact>div {
        padding: 11px;

        background: #f8faf9;

        border: 1px solid var(--connector-border);

        border-radius: 9px;
    }

    .candidate-contact span {
        display: block;

        color: var(--connector-muted);

        font-size: 9px;

        margin-bottom: 4px;
    }

    .candidate-contact strong {
        display: block;

        color: var(--connector-dark);

        font-size: 10px;

        word-break: break-word;
    }


    /* =============================================================
   MODAL DETAILS
============================================================= */

    .modal-detail-section {
        margin-bottom: 20px;
    }

    .modal-detail-section h6 {
        color: var(--connector-dark);

        font-size: 12px;

        font-weight: 700;

        margin-bottom: 8px;

        display: flex;

        align-items: center;

        gap: 5px;
    }

    .modal-detail-section h6 i {
        color: var(--connector-primary);

        font-size: 16px;
    }

    .modal-detail-box {
        background: #f8faf9;

        border: 1px solid var(--connector-border);

        border-radius: 10px;

        padding: 14px;

        color: #5b6862;

        font-size: 11px;

        line-height: 1.8;
    }


    /* =============================================================
   RESUME
============================================================= */

    .resume-box {
        display: flex;

        align-items: center;

        gap: 10px;

        padding: 13px;

        background: var(--connector-light);

        border-radius: 10px;

        margin-bottom: 20px;
    }

    .resume-icon {
        width: 40px;
        height: 40px;

        border-radius: 9px;

        background: #fff;

        color: var(--connector-primary);

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 19px;
    }

    .resume-box>div:nth-child(2) {
        flex: 1;
    }

    .resume-box strong {
        display: block;

        color: var(--connector-dark);

        font-size: 11px;
    }

    .resume-box small {
        display: block;

        color: var(--connector-muted);

        font-size: 9px;

        margin-top: 2px;
    }


    /* =============================================================
   STATUS ACTION
============================================================= */

    .status-action-box {
        display: flex;

        gap: 8px;
    }

    .status-action-box .form-select {
        flex: 1;

        font-size: 11px;

        border-color: var(--connector-border);

        border-radius: 8px;
    }

    .status-action-box .btn {
        white-space: nowrap;
    }


    /* =============================================================
   PAGINATION
============================================================= */

    .pagination {
        margin: 0;
    }


    /* =============================================================
   RESPONSIVE
============================================================= */

    @media(max-width: 991px) {

        .job-detail-hero {
            flex-wrap: wrap;
        }

        .job-detail-actions {
            width: 100%;
        }

        .candidate-contact {
            grid-template-columns: 1fr;
        }

    }

    @media(max-width: 767px) {

        .job-detail-hero {
            padding: 20px;
        }

        .job-detail-heading {
            width: calc(100% - 75px);
        }

        .job-detail-heading h2 {
            font-size: 19px;
        }

        .job-info-grid {
            grid-template-columns: 1fr;
        }

        .application-status-row {
            align-items: flex-start;

            flex-direction: column;
        }

        .status-action-box {
            flex-direction: column;
        }

    }
</style>

@endsection