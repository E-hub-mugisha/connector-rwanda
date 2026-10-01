@extends('layouts.app')

@section('title', 'Customer Feedback')

@section('content')

<div class="content-wrapper feedback-page">

    {{-- =========================================================
        HEADER
    ========================================================== --}}

    <div class="feedback-header mb-4">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <span class="header-eyebrow">
                    CUSTOMER EXPERIENCE
                </span>

                <h1>
                    User Feedback
                </h1>

                <p>
                    See what customers are saying about your services
                    and understand their experience.
                </p>

            </div>


            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">

                <div class="provider-badge">

                    <div class="provider-avatar">
                        {{ strtoupper(substr($sprovider->user->name ?? 'P', 0, 1)) }}
                    </div>

                    <div class="text-start">

                        <span>Service Provider</span>

                        <strong>
                            {{ $sprovider->user->name ?? 'Provider' }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        STATISTICS
    ========================================================== --}}

    <div class="row g-3 mb-4">

        <div class="col-md-4">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="mdi mdi-message-text-outline"></i>
                </div>

                <div>

                    <span class="stat-label">
                        TOTAL FEEDBACK
                    </span>

                    <h3>
                        {{ number_format($stats['total']) }}
                    </h3>

                    <small>
                        Approved customer responses
                    </small>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="mdi mdi-calendar-month-outline"></i>
                </div>

                <div>

                    <span class="stat-label">
                        THIS MONTH
                    </span>

                    <h3>
                        {{ number_format($stats['this_month']) }}
                    </h3>

                    <small>
                        Feedback received this month
                    </small>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="mdi mdi-star-outline"></i>
                </div>

                <div>

                    <span class="stat-label">
                        CUSTOMER VOICE
                    </span>

                    <h3>
                        {{ $stats['total'] > 0 ? 'Active' : 'Waiting' }}
                    </h3>

                    <small>
                        Customer engagement
                    </small>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        FEEDBACK LIST
    ========================================================== --}}

    <div class="feedback-card">

        <div class="feedback-card-header">

            <div>

                <div class="section-title">

                    <div class="section-icon">
                        <i class="mdi mdi-message-processing-outline"></i>
                    </div>

                    <div>

                        <h4>
                            Customer Feedback
                        </h4>

                        <p>
                            Recent approved feedback from your customers
                        </p>

                    </div>

                </div>

            </div>


            <div class="feedback-count">

                {{ $feedbacks->total() }}

                {{ $feedbacks->total() === 1 ? 'Feedback' : 'Feedbacks' }}

            </div>

        </div>


        @if($feedbacks->count())

            <div class="feedback-list">

                @foreach($feedbacks as $feedback)

                    @php

                        $customerName =
                            trim($feedback->name ?? 'Anonymous');

                        $initials = collect(
                            preg_split('/\s+/', $customerName)
                        )
                        ->filter()
                        ->take(2)
                        ->map(
                            fn($name) =>
                                strtoupper(substr($name, 0, 1))
                        )
                        ->implode('');

                        $message =
                            trim($feedback->message ?? '');

                    @endphp


                    <div class="feedback-item">

                        {{-- CUSTOMER --}}

                        <div class="customer-avatar">

                            {{ $initials ?: 'A' }}

                        </div>


                        {{-- CONTENT --}}

                        <div class="feedback-content">

                            <div class="feedback-top">

                                <div>

                                    <h5>
                                        {{ $customerName }}
                                    </h5>

                                    <div class="feedback-meta">

                                        <span>
                                            <i class="mdi mdi-check-circle"></i>
                                            Verified Feedback
                                        </span>

                                        @if($feedback->created_at)

                                            <span>
                                                <i class="mdi mdi-calendar-outline"></i>
                                                {{ $feedback->created_at->format('d M Y') }}
                                            </span>

                                        @endif

                                    </div>

                                </div>


                                <span class="approved-badge">
                                    <i class="mdi mdi-check-circle"></i>
                                    Approved
                                </span>

                            </div>


                            <div class="message-box">

                                <p>
                                    {{ $message ?: 'No message provided.' }}
                                </p>

                            </div>


                            @if(strlen($message) > 180)

                                <button
                                    type="button"
                                    class="view-feedback-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#feedbackModal{{ $feedback->id }}"
                                >
                                    Read full feedback
                                    <i class="mdi mdi-arrow-right"></i>
                                </button>

                            @endif

                        </div>

                    </div>



                    {{-- =================================================
                        FEEDBACK MODAL
                    ================================================== --}}

                    <div
                        class="modal fade"
                        id="feedbackModal{{ $feedback->id }}"
                        tabindex="-1"
                        aria-hidden="true"
                    >

                        <div class="modal-dialog modal-dialog-centered">

                            <div class="modal-content feedback-modal">

                                <div class="modal-header">

                                    <div class="modal-customer">

                                        <div class="customer-avatar small">
                                            {{ $initials ?: 'A' }}
                                        </div>

                                        <div>

                                            <h5>
                                                {{ $customerName }}
                                            </h5>

                                            <span>
                                                Customer Feedback
                                            </span>

                                        </div>

                                    </div>

                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                    ></button>

                                </div>


                                <div class="modal-body">

                                    <div class="full-message">

                                        <div class="quote-icon">
                                            <i class="mdi mdi-format-quote-open"></i>
                                        </div>

                                        <p>
                                            {{ $message ?: 'No message provided.' }}
                                        </p>

                                    </div>

                                    <div class="modal-feedback-meta">

                                        <span>
                                            <i class="mdi mdi-check-circle"></i>
                                            Approved feedback
                                        </span>

                                        @if($feedback->created_at)

                                            <span>
                                                {{ $feedback->created_at->format('d F Y') }}
                                            </span>

                                        @endif

                                    </div>

                                </div>


                                <div class="modal-footer">

                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal"
                                    >
                                        Close
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- PAGINATION --}}

            @if($feedbacks->hasPages())

                <div class="feedback-pagination">

                    <div class="pagination-info">

                        Showing
                        <strong>
                            {{ $feedbacks->firstItem() }}
                        </strong>

                        to

                        <strong>
                            {{ $feedbacks->lastItem() }}
                        </strong>

                        of

                        <strong>
                            {{ $feedbacks->total() }}
                        </strong>

                    </div>


                    <div>
                        {{ $feedbacks->links() }}
                    </div>

                </div>

            @endif


        @else

            {{-- EMPTY STATE --}}

            <div class="empty-feedback">

                <div class="empty-icon">

                    <i class="mdi mdi-message-text-outline"></i>

                </div>

                <h4>
                    No customer feedback yet
                </h4>

                <p>
                    Approved customer feedback will appear here
                    once customers share their experience.
                </p>

            </div>

        @endif

    </div>

</div>



<style>

/* =========================================================
   CONNECTOR FEEDBACK PAGE
========================================================= */

.feedback-page {
    --connector-green: #6B9080;
    --connector-dark: #254035;
    --connector-light: #F4F8F6;
    --connector-border: #E5ECE8;
    --connector-muted: #7A8781;

    color: var(--connector-dark);
}


/* =========================================================
   HEADER
========================================================= */

.feedback-header {

    background: linear-gradient(
        135deg,
        #254035,
        #6B9080
    );

    border-radius: 18px;

    padding: 32px;

    color: white;

    box-shadow:
        0 8px 30px rgba(37,64,53,.10);
}


.header-eyebrow {

    display: block;

    font-size: 10px;

    letter-spacing: 1.8px;

    font-weight: 700;

    opacity: .7;

    margin-bottom: 6px;
}


.feedback-header h1 {

    margin: 0;

    font-size: 30px;

    font-weight: 700;
}


.feedback-header p {

    margin: 8px 0 0;

    color: rgba(255,255,255,.72);

    font-size: 14px;

    max-width: 620px;
}


/* =========================================================
   PROVIDER BADGE
========================================================= */

.provider-badge {

    display: inline-flex;

    align-items: center;

    gap: 12px;

    padding: 10px 14px;

    border-radius: 12px;

    background: rgba(255,255,255,.10);

    border: 1px solid rgba(255,255,255,.14);
}


.provider-avatar {

    width: 42px;
    height: 42px;

    border-radius: 11px;

    background: white;

    color: var(--connector-dark);

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 15px;

    font-weight: 700;
}


.provider-badge span {

    display: block;

    font-size: 10px;

    text-transform: uppercase;

    letter-spacing: 1px;

    opacity: .6;
}


.provider-badge strong {

    display: block;

    font-size: 13px;

    margin-top: 2px;
}


/* =========================================================
   STAT CARDS
========================================================= */

.stat-card {

    background: white;

    border: 1px solid var(--connector-border);

    border-radius: 14px;

    padding: 21px;

    display: flex;

    align-items: center;

    gap: 16px;

    min-height: 110px;

    box-shadow:
        0 5px 20px rgba(37,64,53,.04);
}


.stat-icon {

    width: 48px;
    height: 48px;

    border-radius: 12px;

    background: var(--connector-light);

    color: var(--connector-green);

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 22px;

    flex-shrink: 0;
}


.stat-label {

    display: block;

    font-size: 9px;

    letter-spacing: 1.3px;

    color: var(--connector-muted);

    font-weight: 700;
}


.stat-card h3 {

    margin: 3px 0;

    font-size: 23px;

    font-weight: 700;

    color: var(--connector-dark);
}


.stat-card small {

    color: var(--connector-muted);

    font-size: 11px;
}


/* =========================================================
   MAIN CARD
========================================================= */

.feedback-card {

    background: white;

    border: 1px solid var(--connector-border);

    border-radius: 16px;

    box-shadow:
        0 6px 25px rgba(37,64,53,.045);

    overflow: hidden;
}


.feedback-card-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    padding: 24px 27px;

    border-bottom: 1px solid var(--connector-border);
}


.section-title {

    display: flex;

    align-items: center;

    gap: 13px;
}


.section-icon {

    width: 43px;
    height: 43px;

    border-radius: 11px;

    background: rgba(107,144,128,.12);

    color: var(--connector-green);

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 20px;
}


.section-title h4 {

    margin: 0;

    font-size: 17px;

    font-weight: 700;
}


.section-title p {

    margin: 3px 0 0;

    color: var(--connector-muted);

    font-size: 12px;
}


.feedback-count {

    padding: 7px 12px;

    border-radius: 20px;

    background: var(--connector-light);

    color: var(--connector-dark);

    font-size: 11px;

    font-weight: 600;
}


/* =========================================================
   FEEDBACK ITEM
========================================================= */

.feedback-list {

    padding: 0 27px;
}


.feedback-item {

    display: flex;

    gap: 17px;

    padding: 24px 0;

    border-bottom: 1px solid var(--connector-border);
}


.feedback-item:last-child {
    border-bottom: 0;
}


.customer-avatar {

    width: 48px;
    height: 48px;

    min-width: 48px;

    border-radius: 13px;

    background: var(--connector-dark);

    color: white;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 14px;

    font-weight: 700;
}


.customer-avatar.small {

    width: 42px;
    height: 42px;

    min-width: 42px;

    border-radius: 11px;

    font-size: 13px;
}


.feedback-content {

    flex: 1;

    min-width: 0;
}


.feedback-top {

    display: flex;

    align-items: flex-start;

    justify-content: space-between;

    gap: 15px;

    margin-bottom: 12px;
}


.feedback-top h5 {

    margin: 0;

    font-size: 14px;

    font-weight: 700;

    color: var(--connector-dark);
}


.feedback-meta {

    display: flex;

    flex-wrap: wrap;

    gap: 12px;

    margin-top: 4px;
}


.feedback-meta span {

    color: var(--connector-muted);

    font-size: 11px;
}


.feedback-meta i {

    color: var(--connector-green);

    margin-right: 2px;
}


.approved-badge {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    white-space: nowrap;

    padding: 5px 9px;

    border-radius: 20px;

    background: #EDF7F2;

    color: #3F7760;

    font-size: 10px;

    font-weight: 600;
}


/* =========================================================
   MESSAGE
========================================================= */

.message-box {

    background: #F8FAF9;

    border-left: 3px solid var(--connector-green);

    padding: 13px 16px;

    border-radius: 0 9px 9px 0;
}


.message-box p {

    margin: 0;

    color: #5C6963;

    font-size: 13px;

    line-height: 1.7;

    display: -webkit-box;

    -webkit-line-clamp: 3;

    -webkit-box-orient: vertical;

    overflow: hidden;
}


.view-feedback-btn {

    margin-top: 9px;

    border: 0;

    padding: 0;

    background: transparent;

    color: var(--connector-green);

    font-size: 12px;

    font-weight: 600;
}


.view-feedback-btn:hover {

    color: var(--connector-dark);
}


.view-feedback-btn i {

    margin-left: 3px;
}


/* =========================================================
   MODAL
========================================================= */

.feedback-modal {

    border: 0;

    border-radius: 16px;

    overflow: hidden;
}


.feedback-modal .modal-header {

    padding: 20px 24px;

    border-bottom: 1px solid var(--connector-border);
}


.modal-customer {

    display: flex;

    align-items: center;

    gap: 12px;
}


.modal-customer h5 {

    margin: 0;

    font-size: 15px;

    font-weight: 700;
}


.modal-customer span {

    display: block;

    margin-top: 2px;

    color: var(--connector-muted);

    font-size: 11px;
}


.feedback-modal .modal-body {

    padding: 25px;
}


.full-message {

    position: relative;

    background: var(--connector-light);

    border-radius: 12px;

    padding: 25px;
}


.quote-icon {

    color: var(--connector-green);

    font-size: 28px;

    margin-bottom: 7px;
}


.full-message p {

    margin: 0;

    color: #52615A;

    font-size: 14px;

    line-height: 1.8;
}


.modal-feedback-meta {

    display: flex;

    justify-content: space-between;

    gap: 15px;

    margin-top: 15px;

    color: var(--connector-muted);

    font-size: 11px;
}


.modal-feedback-meta i {

    color: var(--connector-green);

    margin-right: 3px;
}


.feedback-modal .modal-footer {

    padding: 15px 24px;

    border-top: 1px solid var(--connector-border);
}


/* =========================================================
   EMPTY
========================================================= */

.empty-feedback {

    text-align: center;

    padding: 75px 25px;
}


.empty-icon {

    width: 70px;
    height: 70px;

    margin: 0 auto 18px;

    border-radius: 18px;

    background: var(--connector-light);

    color: var(--connector-green);

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 30px;
}


.empty-feedback h4 {

    margin: 0 0 7px;

    font-size: 17px;

    font-weight: 700;
}


.empty-feedback p {

    max-width: 450px;

    margin: auto;

    color: var(--connector-muted);

    font-size: 13px;

    line-height: 1.7;
}


/* =========================================================
   PAGINATION
========================================================= */

.feedback-pagination {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    padding: 20px 27px;

    border-top: 1px solid var(--connector-border);
}


.pagination-info {

    color: var(--connector-muted);

    font-size: 11px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width: 767px) {

    .feedback-header {
        padding: 23px;
    }


    .feedback-header h1 {
        font-size: 25px;
    }


    .feedback-card-header {
        align-items: flex-start;
        flex-direction: column;
    }


    .feedback-list {
        padding: 0 18px;
    }


    .feedback-item {
        gap: 12px;
    }


    .feedback-top {
        flex-direction: column;
    }


    .approved-badge {
        align-self: flex-start;
    }


    .feedback-pagination {
        flex-direction: column;
        align-items: flex-start;
    }

}

</style>

@endsection