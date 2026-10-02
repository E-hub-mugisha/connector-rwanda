@extends('layouts.app')

@section('title', 'Provider Feedbacks')

@section('content')

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-dark: #254035;
        --connector-soft: #eef5f2;
        --connector-border: #e3ebe7;
        --connector-text: #26332e;
        --connector-muted: #7c8984;
        --connector-success: #3f7d62;
        --connector-warning: #a4771d;
        --connector-danger: #b94b4b;
    }

    .feedback-page {
        padding: 24px 0 40px;
    }

    /* Header */
    .feedback-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 26px;
    }

    .feedback-header-left {
        min-width: 0;
    }

    .feedback-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .09em;
        color: var(--connector-primary);
        margin-bottom: 7px;
    }

    .feedback-eyebrow svg {
        width: 14px;
        height: 14px;
    }

    .feedback-title {
        margin: 0;
        color: var(--connector-dark);
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -.025em;
    }

    .feedback-subtitle {
        margin: 7px 0 0;
        color: var(--connector-muted);
        font-size: 14px;
    }

    /* Stats */
    .feedback-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        border-radius: 12px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon svg {
        width: 21px;
        height: 21px;
    }

    .stat-label {
        font-size: 12px;
        color: var(--connector-muted);
        margin-bottom: 3px;
    }

    .stat-value {
        font-size: 22px;
        line-height: 1;
        font-weight: 700;
        color: var(--connector-dark);
    }

    /* Main card */
    .feedback-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 16px;
        overflow: hidden;
    }

    .feedback-card-header {
        padding: 20px 22px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .card-heading {
        margin: 0;
        color: var(--connector-dark);
        font-size: 16px;
        font-weight: 700;
    }

    .card-description {
        margin: 4px 0 0;
        font-size: 12px;
        color: var(--connector-muted);
    }

    .feedback-count {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--connector-soft);
        color: var(--connector-dark);
        padding: 7px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* Alert */
    .feedback-alert {
        margin: 18px 22px 0;
        padding: 12px 14px;
        border-radius: 10px;
        background: #eef7f2;
        border: 1px solid #d7ebe0;
        color: #35634f;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .feedback-alert svg {
        width: 17px;
        height: 17px;
        flex: 0 0 auto;
    }

    /* Table */
    .feedback-table-wrap {
        overflow-x: auto;
    }

    .feedback-table {
        width: 100%;
        min-width: 1050px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .feedback-table thead th {
        background: #fafcfb;
        color: #718079;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .055em;
        padding: 13px 18px;
        border-bottom: 1px solid var(--connector-border);
        white-space: nowrap;
    }

    .feedback-table tbody td {
        padding: 16px 18px;
        border-bottom: 1px solid #edf1ef;
        vertical-align: middle;
        color: var(--connector-text);
        font-size: 13px;
    }

    .feedback-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .feedback-table tbody tr {
        transition: background .15s ease;
    }

    .feedback-table tbody tr:hover {
        background: #fbfdfc;
    }

    /* ID */
    .feedback-id {
        color: var(--connector-muted);
        font-weight: 600;
        font-size: 12px;
    }

    /* Provider */
    .provider-cell {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 200px;
    }

    .provider-avatar {
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        border-radius: 11px;
        background: var(--connector-soft);
        color: var(--connector-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .provider-name {
        font-weight: 700;
        color: var(--connector-dark);
        margin-bottom: 2px;
    }

    .provider-category {
        font-size: 11px;
        color: var(--connector-muted);
    }

    /* Contact */
    .contact-name {
        font-weight: 600;
        color: var(--connector-text);
        margin-bottom: 3px;
    }

    .contact-email {
        font-size: 12px;
        color: var(--connector-muted);
        word-break: break-word;
    }

    /* Message */
    .message-cell {
        max-width: 320px;
    }

    .message-text {
        color: #4d5a55;
        line-height: 1.55;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Status */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-badge::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-approved {
        color: var(--connector-success);
        background: #edf7f2;
    }

    .status-pending {
        color: var(--connector-warning);
        background: #fff7e5;
    }

    /* Date */
    .date-main {
        font-size: 12px;
        font-weight: 600;
        color: var(--connector-text);
    }

    .date-time {
        margin-top: 3px;
        font-size: 11px;
        color: var(--connector-muted);
    }

    /* Action */
    .action-group {
        display: flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
    }

    .action-btn {
        border: 1px solid var(--connector-border);
        background: #fff;
        color: var(--connector-dark);
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .15s ease;
        text-decoration: none;
    }

    .action-btn:hover {
        background: var(--connector-soft);
        border-color: #cbdcd4;
        color: var(--connector-dark);
        text-decoration: none;
    }

    .action-btn.approve {
        color: var(--connector-success);
    }

    .action-btn.approve:hover {
        background: #edf7f2;
        border-color: #cfe5da;
    }

    .action-btn svg {
        width: 16px;
        height: 16px;
    }

    /* Empty state */
    .empty-state {
        padding: 65px 25px;
        text-align: center;
    }

    .empty-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 15px;
        border-radius: 16px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-icon svg {
        width: 27px;
        height: 27px;
    }

    .empty-title {
        margin: 0 0 6px;
        font-size: 16px;
        font-weight: 700;
        color: var(--connector-dark);
    }

    .empty-text {
        margin: 0;
        color: var(--connector-muted);
        font-size: 13px;
    }

    /* Modal */
    .feedback-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .feedback-modal.active {
        display: flex;
    }

    .feedback-modal-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(20, 34, 28, .48);
        backdrop-filter: blur(3px);
    }

    .feedback-modal-dialog {
        position: relative;
        width: 100%;
        max-width: 620px;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 25px 70px rgba(20, 40, 31, .2);
        animation: modalIn .18s ease-out;
    }

    @keyframes modalIn {
        from {
            opacity: 0;
            transform: translateY(8px) scale(.98);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-header-custom {
        padding: 20px 22px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .modal-title-custom {
        margin: 0;
        color: var(--connector-dark);
        font-size: 18px;
        font-weight: 700;
    }

    .modal-subtitle-custom {
        margin: 5px 0 0;
        color: var(--connector-muted);
        font-size: 12px;
    }

    .modal-close {
        width: 34px;
        height: 34px;
        border: 1px solid var(--connector-border);
        background: #fff;
        color: var(--connector-muted);
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .modal-close:hover {
        background: #f5f8f6;
        color: var(--connector-dark);
    }

    .modal-close svg {
        width: 17px;
        height: 17px;
    }

    .modal-body-custom {
        padding: 22px;
    }

    .modal-provider {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 14px;
        border: 1px solid var(--connector-border);
        background: #fbfdfc;
        border-radius: 13px;
        margin-bottom: 20px;
    }

    .modal-provider-avatar {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: var(--connector-soft);
        color: var(--connector-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
    }

    .modal-provider-name {
        font-weight: 700;
        color: var(--connector-dark);
    }

    .modal-provider-category {
        margin-top: 3px;
        color: var(--connector-muted);
        font-size: 12px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    .detail-item {
        padding: 13px;
        border: 1px solid var(--connector-border);
        border-radius: 11px;
    }

    .detail-label {
        display: block;
        color: var(--connector-muted);
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .06em;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .detail-value {
        color: var(--connector-text);
        font-size: 13px;
        font-weight: 600;
        word-break: break-word;
    }

    .feedback-message-box {
        border: 1px solid var(--connector-border);
        border-radius: 12px;
        padding: 15px;
        background: #fbfdfc;
    }

    .feedback-message-title {
        font-size: 11px;
        font-weight: 700;
        color: var(--connector-muted);
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: 8px;
    }

    .feedback-message-content {
        color: var(--connector-text);
        font-size: 14px;
        line-height: 1.7;
        white-space: pre-wrap;
    }

    .modal-footer-custom {
        padding: 16px 22px;
        border-top: 1px solid var(--connector-border);
        display: flex;
        justify-content: flex-end;
        gap: 9px;
    }

    .modal-btn {
        border: 0;
        border-radius: 9px;
        padding: 9px 15px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .modal-btn-secondary {
        background: #f1f4f2;
        color: var(--connector-dark);
    }

    .modal-btn-primary {
        background: var(--connector-primary);
        color: #fff;
    }

    .modal-btn-primary:hover {
        background: var(--connector-dark);
    }

    /* Responsive */
    @media (max-width: 1100px) {
        .feedback-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 767px) {
        .feedback-page {
            padding-top: 15px;
        }

        .feedback-header {
            display: block;
        }

        .feedback-title {
            font-size: 23px;
        }

        .feedback-stats {
            grid-template-columns: 1fr;
        }

        .feedback-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .feedback-modal {
            padding: 10px;
        }

        .feedback-modal-dialog {
            max-height: calc(100vh - 20px);
        }
    }
</style>

<div class="container-fluid feedback-page">

    {{-- Header --}}
    <div class="feedback-header">

        <div class="feedback-header-left">

            <div class="feedback-eyebrow">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M21 11.5a8.38 8.38 0 0 1-9 8.5 9.3 9.3 0 0 1-4-.9L3 21l1.9-4.2A8.7 8.7 0 0 1 3 11.5 8.38 8.38 0 0 1 12 3a8.38 8.38 0 0 1 9 8.5Z"/>
                    <path d="M8 12h.01M12 12h.01M16 12h.01"/>
                </svg>
                Provider Management
            </div>

            <h1 class="feedback-title">
                Service Provider Feedback
            </h1>

            <p class="feedback-subtitle">
                Review and manage feedback submitted about your service providers.
            </p>

        </div>

    </div>


    {{-- Statistics --}}
    <div class="feedback-stats">

        {{-- Total --}}
        <div class="stat-card">

            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M21 11.5a8.38 8.38 0 0 1-9 8.5 9.3 9.3 0 0 1-4-.9L3 21l1.9-4.2A8.7 8.7 0 0 1 3 11.5 8.38 8.38 0 0 1 12 3a8.38 8.38 0 0 1 9 8.5Z"/>
                </svg>
            </div>

            <div>
                <div class="stat-label">Total Feedback</div>
                <div class="stat-value">{{ $totalFeedbacks }}</div>
            </div>

        </div>


        {{-- Approved --}}
        <div class="stat-card">

            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M20 6 9 17l-5-5"/>
                </svg>
            </div>

            <div>
                <div class="stat-label">Approved</div>
                <div class="stat-value">{{ $approvedFeedbacks }}</div>
            </div>

        </div>


        {{-- Pending --}}
        <div class="stat-card">

            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3 2"/>
                </svg>
            </div>

            <div>
                <div class="stat-label">Pending Review</div>
                <div class="stat-value">{{ $pendingFeedbacks }}</div>
            </div>

        </div>


        {{-- Providers --}}
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
                <div class="stat-label">Providers Reviewed</div>
                <div class="stat-value">{{ $providersWithFeedback }}</div>
            </div>

        </div>

    </div>


    {{-- Main Card --}}
    <div class="feedback-card">

        <div class="feedback-card-header">

            <div>
                <h2 class="card-heading">
                    Provider Feedback
                </h2>

                <p class="card-description">
                    Review customer feedback and approve content for publication.
                </p>
            </div>

            <div class="feedback-count">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 11.5a8.38 8.38 0 0 1-9 8.5 9.3 9.3 0 0 1-4-.9L3 21l1.9-4.2A8.7 8.7 0 0 1 3 11.5 8.38 8.38 0 0 1 12 3a8.38 8.38 0 0 1 9 8.5Z"/>
                </svg>

                {{ $totalFeedbacks }} {{ $totalFeedbacks === 1 ? 'Feedback' : 'Feedbacks' }}
            </div>

        </div>


        {{-- Success message --}}
        @if(Session::has('message'))

            <div class="feedback-alert">

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="m8.5 12 2.2 2.2 4.8-5"/>
                </svg>

                <span>{{ Session::get('message') }}</span>

            </div>

        @endif


        @if($feedbacks->count())

            <div class="feedback-table-wrap">

                <table class="feedback-table">

                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Service Provider</th>
                            <th>Contact</th>
                            <th>Feedback</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($feedbacks as $feedback)

                            @php

                                $provider = $feedback->serviceProvider;

                                $providerUser = $provider?->user;

                                $providerName = $providerUser?->name
                                    ?? $feedback->name
                                    ?? 'Unknown Provider';

                                $providerEmail = $providerUser?->email
                                    ?? $feedback->email
                                    ?? 'No email';

                                $categoryName = $provider?->category?->name
                                    ?? 'Service Provider';

                                $initials = collect(
                                    preg_split('/\s+/', trim($providerName))
                                )
                                ->filter()
                                ->take(2)
                                ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                                ->implode('');

                            @endphp

                            <tr>

                                {{-- ID --}}
                                <td>
                                    <span class="feedback-id">
                                        #{{ $feedback->id }}
                                    </span>
                                </td>


                                {{-- Provider --}}
                                <td>

                                    <div class="provider-cell">

                                        <div class="provider-avatar">
                                            {{ $initials ?: 'SP' }}
                                        </div>

                                        <div>

                                            <div class="provider-name">
                                                {{ $providerName }}
                                            </div>

                                            <div class="provider-category">
                                                {{ $categoryName }}
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- Contact --}}
                                <td>

                                    <div class="contact-name">
                                        {{ $feedback->name ?: $providerName }}
                                    </div>

                                    <div class="contact-email">
                                        {{ $feedback->email ?: $providerEmail }}
                                    </div>

                                </td>


                                {{-- Message --}}
                                <td>

                                    <div class="message-cell">

                                        <div class="message-text"
                                             title="{{ $feedback->message }}">
                                            {{ $feedback->message }}
                                        </div>

                                    </div>

                                </td>


                                {{-- Status --}}
                                <td>

                                    @if($feedback->approved)

                                        <span class="status-badge status-approved">
                                            Approved
                                        </span>

                                    @else

                                        <span class="status-badge status-pending">
                                            Pending
                                        </span>

                                    @endif

                                </td>


                                {{-- Date --}}
                                <td>

                                    <div class="date-main">
                                        {{ $feedback->created_at?->format('d M Y') }}
                                    </div>

                                    <div class="date-time">
                                        {{ $feedback->created_at?->format('H:i') }}
                                    </div>

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="action-group">

                                        {{-- View --}}
                                        <button
                                            type="button"
                                            class="action-btn view-feedback"
                                            title="View feedback"

                                            data-name="{{ e($feedback->name ?: $providerName) }}"
                                            data-email="{{ e($feedback->email ?: $providerEmail) }}"
                                            data-provider="{{ e($providerName) }}"
                                            data-category="{{ e($categoryName) }}"
                                            data-message="{{ e($feedback->message) }}"
                                            data-status="{{ $feedback->approved ? 'Approved' : 'Pending' }}"
                                            data-date="{{ $feedback->created_at?->format('d M Y H:i') }}"
                                        >

                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/>
                                                <circle cx="12" cy="12" r="2.7"/>
                                            </svg>

                                        </button>


                                        {{-- Approve --}}
                                        @if(!$feedback->approved)

                                            <form
                                                action="{{ route('admin.feedbackApprove', $feedback->id) }}"
                                                method="POST"
                                                class="approve-form"
                                            >

                                                @csrf
                                                @method('PUT')

                                                <button
                                                    type="submit"
                                                    class="action-btn approve"
                                                    title="Approve feedback"
                                                >

                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                        <path d="m5 12 4 4L19 6"/>
                                                    </svg>

                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            {{-- Empty state --}}
            <div class="empty-state">

                <div class="empty-icon">

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                        <path d="M21 11.5a8.38 8.38 0 0 1-9 8.5 9.3 9.3 0 0 1-4-.9L3 21l1.9-4.2A8.7 8.7 0 0 1 3 11.5 8.38 8.38 0 0 1 12 3a8.38 8.38 0 0 1 9 8.5Z"/>
                        <path d="M8 12h.01M12 12h.01M16 12h.01"/>
                    </svg>

                </div>

                <h3 class="empty-title">
                    No feedback available
                </h3>

                <p class="empty-text">
                    Provider feedback will appear here once customers submit reviews.
                </p>

            </div>

        @endif

    </div>

</div>


{{-- View Feedback Modal --}}
<div class="feedback-modal" id="feedbackModal">

    <div class="feedback-modal-backdrop"></div>

    <div class="feedback-modal-dialog">

        <div class="modal-header-custom">

            <div>
                <h3 class="modal-title-custom">
                    Feedback Details
                </h3>

                <p class="modal-subtitle-custom">
                    Review the submitted provider feedback.
                </p>
            </div>

            <button
                type="button"
                class="modal-close"
                id="closeFeedbackModal"
            >

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="m6 6 12 12M18 6 6 18"/>
                </svg>

            </button>

        </div>


        <div class="modal-body-custom">

            {{-- Provider --}}
            <div class="modal-provider">

                <div
                    class="modal-provider-avatar"
                    id="modalProviderInitials"
                >
                    SP
                </div>

                <div>

                    <div
                        class="modal-provider-name"
                        id="modalProviderName"
                    >
                        —
                    </div>

                    <div
                        class="modal-provider-category"
                        id="modalProviderCategory"
                    >
                        —
                    </div>

                </div>

            </div>


            {{-- Details --}}
            <div class="detail-grid">

                <div class="detail-item">

                    <span class="detail-label">
                        Submitted By
                    </span>

                    <div
                        class="detail-value"
                        id="modalName"
                    >
                        —
                    </div>

                </div>


                <div class="detail-item">

                    <span class="detail-label">
                        Email
                    </span>

                    <div
                        class="detail-value"
                        id="modalEmail"
                    >
                        —
                    </div>

                </div>


                <div class="detail-item">

                    <span class="detail-label">
                        Status
                    </span>

                    <div
                        class="detail-value"
                        id="modalStatus"
                    >
                        —
                    </div>

                </div>


                <div class="detail-item">

                    <span class="detail-label">
                        Submitted
                    </span>

                    <div
                        class="detail-value"
                        id="modalDate"
                    >
                        —
                    </div>

                </div>

            </div>


            {{-- Message --}}
            <div class="feedback-message-box">

                <div class="feedback-message-title">
                    Feedback Message
                </div>

                <div
                    class="feedback-message-content"
                    id="modalMessage"
                >
                    —
                </div>

            </div>

        </div>


        <div class="modal-footer-custom">

            <button
                type="button"
                class="modal-btn modal-btn-secondary"
                id="closeFeedbackModalBottom"
            >
                Close
            </button>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('feedbackModal');

    const closeTop = document.getElementById('closeFeedbackModal');
    const closeBottom = document.getElementById('closeFeedbackModalBottom');
    const backdrop = modal.querySelector('.feedback-modal-backdrop');

    const modalProviderInitials =
        document.getElementById('modalProviderInitials');

    const modalProviderName =
        document.getElementById('modalProviderName');

    const modalProviderCategory =
        document.getElementById('modalProviderCategory');

    const modalName =
        document.getElementById('modalName');

    const modalEmail =
        document.getElementById('modalEmail');

    const modalStatus =
        document.getElementById('modalStatus');

    const modalDate =
        document.getElementById('modalDate');

    const modalMessage =
        document.getElementById('modalMessage');


    function getInitials(name) {

        return name
            .trim()
            .split(/\s+/)
            .slice(0, 2)
            .map(word => word.charAt(0).toUpperCase())
            .join('') || 'SP';

    }


    function openModal(button) {

        const provider =
            button.dataset.provider || 'Unknown Provider';

        modalProviderName.textContent =
            provider;

        modalProviderCategory.textContent =
            button.dataset.category || 'Service Provider';

        modalProviderInitials.textContent =
            getInitials(provider);

        modalName.textContent =
            button.dataset.name || '—';

        modalEmail.textContent =
            button.dataset.email || '—';

        modalStatus.textContent =
            button.dataset.status || '—';

        modalDate.textContent =
            button.dataset.date || '—';

        modalMessage.textContent =
            button.dataset.message || 'No message provided.';

        modal.classList.add('active');

        document.body.style.overflow = 'hidden';

    }


    function closeModal() {

        modal.classList.remove('active');

        document.body.style.overflow = '';

    }


    document
        .querySelectorAll('.view-feedback')
        .forEach(button => {

            button.addEventListener('click', function () {
                openModal(this);
            });

        });


    closeTop.addEventListener('click', closeModal);

    closeBottom.addEventListener('click', closeModal);

    backdrop.addEventListener('click', closeModal);


    document.addEventListener('keydown', function (event) {

        if (
            event.key === 'Escape' &&
            modal.classList.contains('active')
        ) {
            closeModal();
        }

    });


    /* Approve confirmation */
    document
        .querySelectorAll('.approve-form')
        .forEach(form => {

            form.addEventListener('submit', function (event) {

                const confirmed = confirm(
                    'Are you sure you want to approve this feedback?'
                );

                if (!confirmed) {
                    event.preventDefault();
                }

            });

        });

});
</script>

@endsection