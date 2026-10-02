@extends('layouts.app')

@section('title', 'Job Applications')

@section('content')

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-dark: #254035;
        --connector-soft: #eef5f2;
        --connector-border: #e2e9e5;
        --connector-text: #26332e;
        --connector-muted: #7b8983;
        --connector-danger: #b94b4b;
        --connector-warning: #9a7217;
    }

    .applications-page {
        padding: 28px 0 50px;
    }

    /* =========================================================
       HEADER
    ========================================================== */

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 22px;
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
        border-color: var(--connector-primary);
        color: var(--connector-primary);
        text-decoration: none;
    }

    .page-heading h1 {
        margin: 0;
        color: var(--connector-dark);
        font-size: 25px;
        font-weight: 750;
        letter-spacing: -.4px;
    }

    .page-heading p {
        margin: 5px 0 0;
        color: var(--connector-muted);
        font-size: 12px;
    }

    .header-count {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 12px;
        border: 1px solid var(--connector-border);
        background: #fff;
        border-radius: 9px;
        color: var(--connector-dark);
        font-size: 12px;
        font-weight: 650;
    }

    .count-number {
        min-width: 25px;
        height: 25px;
        padding: 0 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--connector-soft);
        color: var(--connector-primary);
        border-radius: 7px;
        font-weight: 750;
    }

    /* =========================================================
       JOB SUMMARY
    ========================================================== */

    .job-summary {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        padding: 18px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .job-summary-main {
        display: flex;
        align-items: center;
        gap: 13px;
        min-width: 0;
    }

    .job-icon {
        width: 43px;
        height: 43px;
        border-radius: 11px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .job-summary-title {
        color: var(--connector-dark);
        font-size: 14px;
        font-weight: 700;
        margin: 0;
    }

    .job-summary-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 6px 15px;
        margin-top: 5px;
    }

    .summary-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: var(--connector-muted);
        font-size: 10px;
    }

    .summary-meta-item svg {
        color: var(--connector-primary);
    }

    .job-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }

    .job-action {
        min-height: 38px;
        padding: 0 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border: 1px solid var(--connector-border);
        border-radius: 8px;
        background: #fff;
        color: var(--connector-dark);
        font-size: 11px;
        font-weight: 650;
        text-decoration: none;
        transition: .2s ease;
    }

    .job-action:hover {
        background: var(--connector-soft);
        border-color: var(--connector-primary);
        color: var(--connector-primary);
        text-decoration: none;
    }

    /* =========================================================
       APPLICATION CARD
    ========================================================== */

    .applications-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        overflow: hidden;
    }

    .applications-card-header {
        padding: 17px 20px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .card-title {
        color: var(--connector-dark);
        font-size: 14px;
        font-weight: 700;
        margin: 0;
    }

    .card-subtitle {
        color: var(--connector-muted);
        font-size: 10px;
        margin-top: 3px;
    }

    /* =========================================================
       TABLE
    ========================================================== */

    .applications-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .applications-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .applications-table thead th {
        background: #fafcfb;
        border-bottom: 1px solid var(--connector-border);
        color: #829089;
        font-size: 9px;
        font-weight: 750;
        letter-spacing: .45px;
        text-transform: uppercase;
        padding: 12px 17px;
        white-space: nowrap;
        text-align: left;
    }

    .applications-table tbody td {
        border-bottom: 1px solid #edf1ef;
        padding: 14px 17px;
        vertical-align: middle;
    }

    .applications-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .applications-table tbody tr {
        transition: .15s ease;
    }

    .applications-table tbody tr:hover {
        background: #fbfdfc;
    }

    /* =========================================================
       APPLICANT
    ========================================================== */

    .applicant {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 190px;
    }

    .applicant-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: var(--connector-soft);
        color: var(--connector-dark);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 750;
        flex-shrink: 0;
    }

    .applicant-name {
        color: var(--connector-dark);
        font-size: 12px;
        font-weight: 700;
        line-height: 1.35;
    }

    .applicant-email {
        color: var(--connector-muted);
        font-size: 10px;
        margin-top: 3px;
    }

    /* =========================================================
       JOB
    ========================================================== */

    .job-name {
        color: var(--connector-dark);
        font-size: 11px;
        font-weight: 650;
        max-width: 190px;
    }

    .application-id {
        color: var(--connector-muted);
        font-size: 10px;
        margin-top: 3px;
    }

    /* =========================================================
       STATUS
    ========================================================== */

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 750;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .status-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-pending {
        background: #fff6df;
        color: #946b12;
    }

    .status-reviewed {
        background: #edf3f7;
        color: #536c7b;
    }

    .status-shortlisted {
        background: #eaf5ef;
        color: #26734d;
    }

    .status-accepted {
        background: #e4f4ec;
        color: #1f7049;
    }

    .status-rejected {
        background: #fff0f0;
        color: #b34b4b;
    }

    .status-default {
        background: #f0f3f2;
        color: #66736d;
    }

    /* =========================================================
       DATE
    ========================================================== */

    .applied-date {
        color: var(--connector-dark);
        font-size: 11px;
        font-weight: 600;
    }

    .applied-time {
        color: var(--connector-muted);
        font-size: 9px;
        margin-top: 3px;
    }

    /* =========================================================
       ACTIONS
    ========================================================== */

    .actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .action-button {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--connector-border);
        border-radius: 7px;
        background: #fff;
        color: #65746d;
        cursor: pointer;
        transition: .2s ease;
    }

    .action-button:hover {
        background: var(--connector-soft);
        border-color: var(--connector-primary);
        color: var(--connector-primary);
    }

    .accept-button:hover {
        background: #eaf6ef;
        border-color: #91c3a8;
        color: #28714d;
    }

    .reject-button:hover {
        background: #fff1f1;
        border-color: #dfaaaa;
        color: #b34b4b;
    }

    /* =========================================================
       EMPTY STATE
    ========================================================== */

    .empty-state {
        padding: 65px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 54px;
        height: 54px;
        border-radius: 13px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 13px;
    }

    .empty-state h3 {
        margin: 0 0 5px;
        color: var(--connector-dark);
        font-size: 14px;
        font-weight: 700;
    }

    .empty-state p {
        max-width: 340px;
        margin: 0 auto;
        color: var(--connector-muted);
        font-size: 11px;
        line-height: 1.6;
    }

    /* =========================================================
       MODAL
    ========================================================== */

    .custom-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .custom-modal.show {
        display: flex;
    }

    .modal-overlay {
        position: absolute;
        inset: 0;
        background: rgba(24, 39, 32, .52);
        backdrop-filter: blur(2px);
    }

    .custom-modal-dialog {
        position: relative;
        z-index: 2;
        width: min(700px, 100%);
        max-height: calc(100vh - 40px);
        overflow-y: auto;
        background: #fff;
        border-radius: 15px;
        border: 1px solid var(--connector-border);
        box-shadow: 0 20px 55px rgba(25, 45, 36, .18);
        animation: modalIn .18s ease;
    }

    @keyframes modalIn {
        from {
            opacity: 0;
            transform: translateY(8px) scale(.985);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-header-custom {
        padding: 18px 20px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .modal-applicant {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .modal-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--connector-soft);
        color: var(--connector-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 750;
    }

    .modal-title {
        margin: 0;
        color: var(--connector-dark);
        font-size: 14px;
        font-weight: 700;
    }

    .modal-subtitle {
        margin-top: 3px;
        color: var(--connector-muted);
        font-size: 10px;
    }

    .modal-close {
        width: 32px;
        height: 32px;
        border: 1px solid var(--connector-border);
        border-radius: 7px;
        background: #fff;
        color: #6f7d76;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .modal-close:hover {
        background: #f5f8f6;
        color: var(--connector-dark);
    }

    .modal-body-custom {
        padding: 20px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 18px;
    }

    .detail-box {
        padding: 13px;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        background: #fafcfb;
    }

    .detail-label {
        color: var(--connector-muted);
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: .4px;
        font-weight: 750;
        margin-bottom: 5px;
    }

    .detail-value {
        color: var(--connector-dark);
        font-size: 11px;
        font-weight: 600;
        word-break: break-word;
    }

    .detail-section {
        margin-top: 18px;
    }

    .detail-section-title {
        color: var(--connector-dark);
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .cover-letter {
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        background: #fafcfb;
        padding: 14px;
        color: #53625b;
        font-size: 12px;
        line-height: 1.7;
        white-space: pre-line;
        max-height: 230px;
        overflow-y: auto;
    }

    .resume-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        padding: 12px 14px;
        background: #fafcfb;
    }

    .resume-info {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .resume-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: #fff0f0;
        color: #b34b4b;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .resume-name {
        color: var(--connector-dark);
        font-size: 11px;
        font-weight: 650;
    }

    .resume-description {
        color: var(--connector-muted);
        font-size: 9px;
        margin-top: 2px;
    }

    .download-button {
        min-height: 34px;
        padding: 0 11px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid var(--connector-primary);
        border-radius: 7px;
        background: #fff;
        color: var(--connector-primary);
        font-size: 10px;
        font-weight: 650;
        text-decoration: none;
    }

    .download-button:hover {
        background: var(--connector-soft);
        color: var(--connector-dark);
        text-decoration: none;
    }

    .modal-footer-custom {
        padding: 14px 20px;
        border-top: 1px solid var(--connector-border);
        display: flex;
        justify-content: flex-end;
    }

    .close-button {
        min-height: 37px;
        padding: 0 14px;
        border: 1px solid var(--connector-border);
        border-radius: 8px;
        background: #fff;
        color: var(--connector-dark);
        font-size: 11px;
        font-weight: 650;
        cursor: pointer;
    }

    .close-button:hover {
        background: var(--connector-soft);
    }

    /* =========================================================
       RESPONSIVE
    ========================================================== */

    @media (max-width: 750px) {

        .page-header,
        .job-summary {
            align-items: flex-start;
            flex-direction: column;
        }

        .header-count,
        .job-actions {
            width: 100%;
        }

        .header-count {
            justify-content: space-between;
        }

        .job-action {
            flex: 1;
        }

    }

    @media (max-width: 600px) {

        .applications-page {
            padding-top: 20px;
        }

        .page-heading h1 {
            font-size: 21px;
        }

        .job-summary {
            padding: 15px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .custom-modal {
            padding: 10px;
        }

        .custom-modal-dialog {
            max-height: calc(100vh - 20px);
        }

    }
</style>


<div class="container-fluid applications-page">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div class="page-header">

        <div class="heading-left">

            <a
                href="{{ route('admin.jobs.show', $job->id) }}"
                class="back-button"
                title="Back to job"
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

            <div class="page-heading">

                <div>
                    <h1>Job Applications</h1>

                    <p>
                        Review and manage applicants for this opportunity.
                    </p>
                </div>

            </div>

        </div>


        <div class="header-count">

            <span>Total Applications</span>

            <span class="count-number">
                {{ $job->applications->count() }}
            </span>

        </div>

    </div>


    {{-- =========================================================
         JOB SUMMARY
    ========================================================== --}}

    <div class="job-summary">

        <div class="job-summary-main">

            <div class="job-icon">

                <svg width="20" height="20"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8">
                    <rect x="3" y="7" width="18" height="13" rx="2"/>
                    <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                </svg>

            </div>


            <div>

                <h2 class="job-summary-title">
                    {{ $job->title ?? 'Unknown Job' }}
                </h2>


                <div class="job-summary-meta">

                    @if($job->location)

                        <span class="summary-meta-item">

                            <svg width="12" height="12"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/>
                                <circle cx="12" cy="10" r="2.5"/>
                            </svg>

                            {{ $job->location }}

                        </span>

                    @endif


                    @if($job->type)

                        <span class="summary-meta-item">

                            <svg width="12" height="12"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <rect x="3" y="7" width="18" height="13" rx="2"/>
                                <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            </svg>

                            {{ ucfirst($job->type) }}

                        </span>

                    @endif


                    @if($job->deadline)

                        <span class="summary-meta-item">

                            <svg width="12" height="12"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>
                            </svg>

                            Deadline:
                            {{ $job->deadline->format('d M Y') }}

                        </span>

                    @endif

                </div>

            </div>

        </div>


        <div class="job-actions">

            <a
                href="{{ route('admin.jobs.show', $job->id) }}"
                class="job-action"
            >

                <svg width="14" height="14"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">
                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>

                View Job

            </a>


            <a
                href="{{ route('admin.jobs.edit', $job->id) }}"
                class="job-action"
            >

                <svg width="14" height="14"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                </svg>

                Edit Job

            </a>

        </div>

    </div>


    {{-- =========================================================
         APPLICATIONS
    ========================================================== --}}

    <div class="applications-card">

        <div class="applications-card-header">

            <div>

                <h2 class="card-title">
                    Applicants
                </h2>

                <div class="card-subtitle">
                    Review submitted applications and take action.
                </div>

            </div>

        </div>


        @if($job->applications->count())


            <div class="applications-table-wrapper">

                <table class="applications-table">

                    <thead>

                        <tr>

                            <th>
                                Applicant
                            </th>

                            <th>
                                Job
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Applied On
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($job->applications as $app)

                            @php

                                $applicantName =
                                    $app->user?->name ??
                                    'Unknown Applicant';

                                $applicantEmail =
                                    $app->user?->email ??
                                    'No email available';

                                $words = preg_split(
                                    '/\s+/',
                                    trim($applicantName)
                                );

                                if (count($words) >= 2) {

                                    $initials =
                                        substr($words[0], 0, 1) .
                                        substr(
                                            $words[count($words) - 1],
                                            0,
                                            1
                                        );

                                } else {

                                    $initials =
                                        substr(
                                            $applicantName,
                                            0,
                                            2
                                        );

                                }

                                $status =
                                    strtolower(
                                        $app->status ?? 'pending'
                                    );

                            @endphp


                            <tr>

                                {{-- Applicant --}}

                                <td>

                                    <div class="applicant">

                                        <div class="applicant-avatar">

                                            {{ strtoupper($initials) }}

                                        </div>


                                        <div>

                                            <div class="applicant-name">

                                                {{ $applicantName }}

                                            </div>

                                            <div class="applicant-email">

                                                {{ $applicantEmail }}

                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- Job --}}

                                <td>

                                    <div class="job-name">

                                        {{ $app->job?->title ?? $job->title ?? 'N/A' }}

                                    </div>

                                    <div class="application-id">

                                        Application #{{ $app->id }}

                                    </div>

                                </td>


                                {{-- Status --}}

                                <td>

                                    <span class="status-badge status-{{ $status }}">

                                        <span class="status-dot"></span>

                                        {{ ucfirst($status) }}

                                    </span>

                                </td>


                                {{-- Date --}}

                                <td>

                                    <div class="applied-date">

                                        {{ $app->created_at?->format('d M Y') }}

                                    </div>

                                    <div class="applied-time">

                                        {{ $app->created_at?->format('H:i') }}

                                    </div>

                                </td>


                                {{-- Actions --}}

                                <td>

                                    <div class="actions">


                                        {{-- View --}}

                                        <button
                                            type="button"
                                            class="action-button"
                                            title="View application"
                                            onclick="openApplicantModal({{ $app->id }})"
                                        >

                                            <svg width="15" height="15"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="2">
                                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>

                                        </button>


                                        {{-- Accept --}}

                                        @if($status === 'pending')

                                            <form
                                                action="{{ route('admin.applications.accept', $app->id) }}"
                                                method="POST"
                                                style="display:inline;"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="action-button accept-button"
                                                    title="Accept application"
                                                >

                                                    <svg width="15" height="15"
                                                         viewBox="0 0 24 24"
                                                         fill="none"
                                                         stroke="currentColor"
                                                         stroke-width="2">
                                                        <path d="m5 12 4 4L19 6"/>
                                                    </svg>

                                                </button>

                                            </form>


                                            {{-- Reject --}}

                                            <form
                                                action="{{ route('admin.applications.reject', $app->id) }}"
                                                method="POST"
                                                style="display:inline;"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="action-button reject-button"
                                                    title="Reject application"
                                                >

                                                    <svg width="15" height="15"
                                                         viewBox="0 0 24 24"
                                                         fill="none"
                                                         stroke="currentColor"
                                                         stroke-width="2">
                                                        <path d="M6 6l12 12"/>
                                                        <path d="M18 6 6 18"/>
                                                    </svg>

                                                </button>

                                            </form>

                                        @endif


                                    </div>

                                </td>

                            </tr>


                            {{-- =================================================
                                 APPLICANT MODAL
                            ================================================== --}}

                            <div
                                class="custom-modal"
                                id="applicantModal{{ $app->id }}"
                            >

                                <div
                                    class="modal-overlay"
                                    onclick="closeApplicantModal({{ $app->id }})"
                                ></div>


                                <div class="custom-modal-dialog">

                                    <div class="modal-header-custom">

                                        <div class="modal-applicant">

                                            <div class="modal-avatar">

                                                {{ strtoupper($initials) }}

                                            </div>


                                            <div>

                                                <h3 class="modal-title">

                                                    {{ $applicantName }}

                                                </h3>

                                                <div class="modal-subtitle">

                                                    Application #{{ $app->id }}

                                                </div>

                                            </div>

                                        </div>


                                        <button
                                            type="button"
                                            class="modal-close"
                                            onclick="closeApplicantModal({{ $app->id }})"
                                            aria-label="Close"
                                        >

                                            <svg width="15" height="15"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="2">
                                                <path d="M6 6l12 12"/>
                                                <path d="M18 6 6 18"/>
                                            </svg>

                                        </button>

                                    </div>


                                    <div class="modal-body-custom">


                                        {{-- Contact --}}

                                        <div class="detail-grid">

                                            <div class="detail-box">

                                                <div class="detail-label">
                                                    Applicant
                                                </div>

                                                <div class="detail-value">
                                                    {{ $applicantName }}
                                                </div>

                                            </div>


                                            <div class="detail-box">

                                                <div class="detail-label">
                                                    Email
                                                </div>

                                                <div class="detail-value">
                                                    {{ $applicantEmail }}
                                                </div>

                                            </div>


                                            <div class="detail-box">

                                                <div class="detail-label">
                                                    Applied
                                                </div>

                                                <div class="detail-value">

                                                    {{ $app->created_at?->format('d M Y H:i') }}

                                                </div>

                                            </div>


                                            <div class="detail-box">

                                                <div class="detail-label">
                                                    Status
                                                </div>

                                                <div class="detail-value">

                                                    {{ ucfirst($status) }}

                                                </div>

                                            </div>

                                        </div>


                                        {{-- Job --}}

                                        <div class="detail-section">

                                            <div class="detail-section-title">

                                                Job Applied For

                                            </div>

                                            <div class="detail-box">

                                                <div class="detail-value">

                                                    {{ $app->job?->title ?? $job->title ?? 'N/A' }}

                                                </div>

                                            </div>

                                        </div>


                                        {{-- Cover Letter --}}

                                        <div class="detail-section">

                                            <div class="detail-section-title">

                                                Cover Letter

                                            </div>


                                            @if($app->cover_letter)

                                                <div class="cover-letter">

                                                    {{ $app->cover_letter }}

                                                </div>

                                            @else

                                                <div class="cover-letter">

                                                    No cover letter was submitted.

                                                </div>

                                            @endif

                                        </div>


                                        {{-- Resume --}}

                                        <div class="detail-section">

                                            <div class="detail-section-title">

                                                Resume / CV

                                            </div>


                                            @if($app->resume)

                                                <div class="resume-box">

                                                    <div class="resume-info">

                                                        <div class="resume-icon">

                                                            <svg width="17" height="17"
                                                                 viewBox="0 0 24 24"
                                                                 fill="none"
                                                                 stroke="currentColor"
                                                                 stroke-width="2">
                                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/>
                                                                <path d="M14 2v6h6"/>
                                                                <path d="M8 13h8"/>
                                                                <path d="M8 17h6"/>
                                                            </svg>

                                                        </div>


                                                        <div>

                                                            <div class="resume-name">
                                                                Applicant Resume
                                                            </div>

                                                            <div class="resume-description">
                                                                Uploaded document
                                                            </div>

                                                        </div>

                                                    </div>


                                                    <a
                                                        href="{{ asset($app->resume) }}"
                                                        target="_blank"
                                                        rel="noopener"
                                                        class="download-button"
                                                    >

                                                        <svg width="13" height="13"
                                                             viewBox="0 0 24 24"
                                                             fill="none"
                                                             stroke="currentColor"
                                                             stroke-width="2">
                                                            <path d="M12 3v12"/>
                                                            <path d="m7 10 5 5 5-5"/>
                                                            <path d="M5 21h14"/>
                                                        </svg>

                                                        View Resume

                                                    </a>

                                                </div>

                                            @else

                                                <div class="resume-box">

                                                    <div class="resume-info">

                                                        <div class="resume-icon">

                                                            <svg width="16" height="16"
                                                                 viewBox="0 0 24 24"
                                                                 fill="none"
                                                                 stroke="currentColor"
                                                                 stroke-width="2">
                                                                <path d="M6 3h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/>
                                                                <path d="M8 8h8"/>
                                                                <path d="M8 12h8"/>
                                                            </svg>

                                                        </div>

                                                        <div>

                                                            <div class="resume-name">
                                                                No resume
                                                            </div>

                                                            <div class="resume-description">
                                                                The applicant did not upload a CV.
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            @endif

                                        </div>

                                    </div>


                                    <div class="modal-footer-custom">

                                        <button
                                            type="button"
                                            class="close-button"
                                            onclick="closeApplicantModal({{ $app->id }})"
                                        >
                                            Close
                                        </button>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </tbody>

                </table>

            </div>


        @else


            {{-- =================================================
                 EMPTY
            ================================================== --}}

            <div class="empty-state">

                <div class="empty-icon">

                    <svg width="24" height="24"
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

                <h3>
                    No applications yet
                </h3>

                <p>
                    Applications submitted for this job will appear here.
                </p>

            </div>


        @endif

    </div>

</div>


<script>
(function () {

    window.openApplicantModal = function (id) {

        const modal =
            document.getElementById(
                'applicantModal' + id
            );

        if (!modal) {
            return;
        }

        modal.classList.add('show');

        document.body.style.overflow = 'hidden';

    };


    window.closeApplicantModal = function (id) {

        const modal =
            document.getElementById(
                'applicantModal' + id
            );

        if (!modal) {
            return;
        }

        modal.classList.remove('show');

        document.body.style.overflow = '';

    };


    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Escape') {
                return;
            }

            document
                .querySelectorAll('.custom-modal.show')
                .forEach(function (modal) {

                    modal.classList.remove('show');

                });

            document.body.style.overflow = '';

        }
    );


    /*
     * Confirmation before accepting or rejecting.
     */

    document
        .querySelectorAll(
            '.accept-button, .reject-button'
        )
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function (event) {

                    const isAccept =
                        this.classList.contains(
                            'accept-button'
                        );

                    const action =
                        isAccept
                            ? 'accept this application'
                            : 'reject this application';

                    if (!confirm(
                        'Are you sure you want to ' +
                        action +
                        '?'
                    )) {

                        event.preventDefault();

                    }

                }
            );

        });

})();
</script>

@endsection