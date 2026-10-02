@extends('layouts.app')

@section('title', 'Partners')

@section('content')

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-primary-dark: #557968;
        --connector-dark: #254035;
        --connector-soft: #EEF4F1;
        --connector-border: #E3EBE7;
        --connector-text: #25332D;
        --connector-muted: #78857F;
        --connector-danger: #C94C4C;
        --connector-danger-soft: #FDF0F0;
    }

    .partner-page {
        padding: 10px 0 40px;
    }

    /* =========================================================
       HEADER
    ========================================================= */

    .partner-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .partner-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .partner-page-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .partner-page-icon svg {
        width: 23px;
        height: 23px;
    }

    .partner-header h1 {
        margin: 0;
        color: var(--connector-dark);
        font-size: 24px;
        font-weight: 700;
        letter-spacing: -.3px;
    }

    .partner-header p {
        margin: 4px 0 0;
        color: var(--connector-muted);
        font-size: 14px;
    }

    .btn-add-partner {
        border: 0;
        background: var(--connector-dark);
        color: #fff;
        border-radius: 10px;
        padding: 11px 17px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-add-partner:hover {
        background: var(--connector-primary);
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-add-partner svg {
        width: 17px;
        height: 17px;
    }

    /* =========================================================
       STATS
    ========================================================= */

    .partner-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    .partner-stat-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 4px 16px rgba(37, 64, 53, .04);
    }

    .partner-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .partner-stat-icon svg {
        width: 20px;
        height: 20px;
    }

    .partner-stat-label {
        color: var(--connector-muted);
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 3px;
    }

    .partner-stat-value {
        color: var(--connector-dark);
        font-size: 21px;
        line-height: 1.2;
        font-weight: 700;
    }

    /* =========================================================
       ALERTS
    ========================================================= */

    .partner-alert {
        margin-bottom: 20px;
        padding: 13px 16px;
        border-radius: 10px;
        font-size: 13px;
    }

    .partner-alert-success {
        background: #EDF7F1;
        color: #2E6B49;
        border: 1px solid #CDE8D8;
    }

    .partner-alert-error {
        background: var(--connector-danger-soft);
        color: #A63E3E;
        border: 1px solid #F2D0D0;
    }

    /* =========================================================
       MAIN CARD
    ========================================================= */

    .partner-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 16px;
        box-shadow: 0 6px 24px rgba(37, 64, 53, .05);
        overflow: hidden;
    }

    .partner-card-header {
        padding: 19px 22px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .partner-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .partner-card-title h2 {
        margin: 0;
        font-size: 16px;
        color: var(--connector-dark);
        font-weight: 700;
    }

    .partner-count {
        background: var(--connector-soft);
        color: var(--connector-dark);
        font-size: 12px;
        font-weight: 700;
        padding: 5px 9px;
        border-radius: 20px;
    }

    /* =========================================================
       TABLE
    ========================================================= */

    .partner-table-wrapper {
        overflow-x: auto;
    }

    .partner-table {
        width: 100%;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 680px;
    }

    .partner-table thead th {
        background: #FAFCFB;
        color: #74817B;
        border-bottom: 1px solid var(--connector-border);
        padding: 13px 18px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    .partner-table tbody td {
        padding: 15px 18px;
        border-bottom: 1px solid #EEF2F0;
        vertical-align: middle;
        color: var(--connector-text);
        font-size: 13px;
    }

    .partner-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .partner-table tbody tr {
        transition: background .15s ease;
    }

    .partner-table tbody tr:hover {
        background: #FAFCFB;
    }

    .partner-number {
        color: #8A9690;
        font-weight: 600;
        width: 60px;
    }

    /* =========================================================
       PARTNER IMAGE
    ========================================================= */

    .partner-image {
        width: 76px;
        height: 58px;
        border-radius: 9px;
        object-fit: contain;
        padding: 7px;
        background: #fff;
        border: 1px solid var(--connector-border);
        display: block;
    }

    .partner-image-placeholder {
        width: 76px;
        height: 58px;
        border-radius: 9px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .partner-image-placeholder svg {
        width: 23px;
        height: 23px;
    }

    /* =========================================================
       NAME
    ========================================================= */

    .partner-name {
        color: var(--connector-dark);
        font-size: 14px;
        font-weight: 650;
    }

    .partner-description {
        color: var(--connector-muted);
        font-size: 11px;
        margin-top: 3px;
    }

    /* =========================================================
       ACTIONS
    ========================================================= */

    .partner-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
        white-space: nowrap;
    }

    .partner-action {
        width: 35px;
        height: 35px;
        border-radius: 9px;
        border: 1px solid var(--connector-border);
        background: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: .18s ease;
        text-decoration: none;
        padding: 0;
        cursor: pointer;
    }

    .partner-action svg {
        width: 16px;
        height: 16px;
    }

    .partner-action-edit {
        color: var(--connector-primary);
    }

    .partner-action-edit:hover {
        color: #fff;
        background: var(--connector-primary);
        border-color: var(--connector-primary);
    }

    .partner-action-delete {
        color: var(--connector-danger);
    }

    .partner-action-delete:hover {
        color: #fff;
        background: var(--connector-danger);
        border-color: var(--connector-danger);
    }

    /* =========================================================
       EMPTY
    ========================================================= */

    .partner-empty {
        padding: 65px 25px;
        text-align: center;
    }

    .partner-empty-icon {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        margin: 0 auto 14px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .partner-empty-icon svg {
        width: 26px;
        height: 26px;
    }

    .partner-empty h3 {
        margin: 0 0 6px;
        color: var(--connector-dark);
        font-size: 17px;
        font-weight: 700;
    }

    .partner-empty p {
        color: var(--connector-muted);
        font-size: 13px;
        margin: 0 0 18px;
    }

    /* =========================================================
       CUSTOM MODAL
    ========================================================= */

    .partner-modal {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .partner-modal.show {
        display: flex;
    }

    .partner-modal-overlay {
        position: absolute;
        inset: 0;
        background: rgba(20, 31, 26, .58);
        backdrop-filter: blur(3px);
    }

    .partner-modal-dialog {
        position: relative;
        width: 100%;
        max-width: 520px;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
        background: #fff;
        border-radius: 17px;
        box-shadow: 0 25px 80px rgba(0, 0, 0, .20);
        z-index: 2;
        animation: partnerModalIn .18s ease-out;
    }

    @keyframes partnerModalIn {
        from {
            opacity: 0;
            transform: translateY(12px) scale(.98);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .partner-modal-header {
        padding: 19px 22px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .partner-modal-heading {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .partner-modal-icon {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .partner-modal-icon svg {
        width: 19px;
        height: 19px;
    }

    .partner-modal-title {
        margin: 0;
        color: var(--connector-dark);
        font-size: 17px;
        font-weight: 700;
    }

    .partner-modal-subtitle {
        color: var(--connector-muted);
        font-size: 12px;
        margin-top: 2px;
    }

    .partner-modal-close {
        width: 34px;
        height: 34px;
        border: 0;
        background: #F4F6F5;
        color: #68756F;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 21px;
        line-height: 1;
    }

    .partner-modal-close:hover {
        background: #E9EEEB;
        color: var(--connector-dark);
    }

    .partner-modal-body {
        padding: 22px;
    }

    .partner-modal-footer {
        padding: 16px 22px;
        border-top: 1px solid var(--connector-border);
        background: #FAFCFB;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 9px;
    }

    /* =========================================================
       FORM
    ========================================================= */

    .partner-form-group {
        margin-bottom: 18px;
    }

    .partner-form-label {
        display: block;
        color: var(--connector-dark);
        font-size: 13px;
        font-weight: 650;
        margin-bottom: 7px;
    }

    .required-mark {
        color: var(--connector-danger);
    }

    .partner-form-control {
        width: 100%;
        height: 44px;
        border: 1px solid #DCE5E0;
        border-radius: 9px;
        padding: 0 12px;
        color: var(--connector-text);
        font-size: 13px;
        background: #fff;
        outline: none;
        transition: .18s ease;
    }

    .partner-form-control:focus {
        border-color: var(--connector-primary);
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .12);
    }

    .partner-file-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px dashed #C8D7D0;
        border-radius: 9px;
        background: #FAFCFB;
        color: var(--connector-muted);
        font-size: 12px;
    }

    .partner-file-help {
        margin-top: 6px;
        color: #8A9690;
        font-size: 11px;
    }

    .partner-error {
        margin-top: 5px;
        color: var(--connector-danger);
        font-size: 11px;
    }

    /* =========================================================
       IMAGE PREVIEW
    ========================================================= */

    .partner-preview-box {
        margin-top: 10px;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        padding: 7px;
        background: #FAFCFB;
    }

    .partner-preview-box img {
        width: 100%;
        height: 140px;
        object-fit: contain;
        display: block;
        border-radius: 7px;
        background: #fff;
    }

    .partner-preview-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: var(--connector-muted);
        font-size: 11px;
        margin-bottom: 6px;
    }

    /* =========================================================
       MODAL BUTTONS
    ========================================================= */

    .btn-partner-cancel {
        border: 1px solid #D9E2DE;
        background: #fff;
        color: var(--connector-dark);
        border-radius: 9px;
        padding: 9px 15px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-partner-cancel:hover {
        background: #F5F8F6;
    }

    .btn-partner-save {
        border: 0;
        background: var(--connector-dark);
        color: #fff;
        border-radius: 9px;
        padding: 10px 17px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: .18s ease;
    }

    .btn-partner-save:hover {
        background: var(--connector-primary);
    }

    .btn-partner-save:disabled {
        opacity: .65;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {

        .partner-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .btn-add-partner {
            width: 100%;
        }

        .partner-stats {
            grid-template-columns: 1fr;
        }

        .partner-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .partner-modal {
            padding: 12px;
        }

        .partner-modal-dialog {
            max-height: calc(100vh - 24px);
        }
    }
</style>


@php
    $totalPartners = $partners->count();
@endphp


<div class="container-fluid partner-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="partner-header">

        <div class="partner-header-left">

            <div class="partner-page-icon">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <rect x="3" y="4"
                          width="18"
                          height="16"
                          rx="2">
                    </rect>

                    <circle cx="8.5"
                            cy="9"
                            r="1.5">
                    </circle>

                    <path d="M21 15l-4.5-4.5L10 17l-2.5-2.5L3 19"></path>

                </svg>

            </div>

            <div>

                <h1>Partners</h1>

                <p>
                    Manage organizations and partners displayed on the platform.
                </p>

            </div>

        </div>


        <button
            type="button"
            class="btn-add-partner"
            onclick="openPartnerModal('addPartnerModal')"
        >

            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round">

                <path d="M12 5v14"></path>
                <path d="M5 12h14"></path>

            </svg>

            Add Partner

        </button>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="partner-stats">

        <div class="partner-stat-card">

            <div class="partner-stat-icon">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <circle cx="9" cy="8" r="3"></circle>
                    <circle cx="17" cy="10" r="2"></circle>

                    <path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"></path>

                    <path d="M15 15c3.1-.1 5.5 1.8 6 5"></path>

                </svg>

            </div>

            <div>

                <div class="partner-stat-label">
                    Total Partners
                </div>

                <div class="partner-stat-value">
                    {{ $totalPartners }}
                </div>

            </div>

        </div>


        <div class="partner-stat-card">

            <div class="partner-stat-icon">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <rect x="3" y="3"
                          width="18"
                          height="18"
                          rx="2">
                    </rect>

                    <path d="M7 12l3 3 7-7"></path>

                </svg>

            </div>

            <div>

                <div class="partner-stat-label">
                    Partner Logos
                </div>

                <div class="partner-stat-value">
                    {{ $totalPartners }}
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         FLASH MESSAGE
    ====================================================== --}}

    @if(Session::has('message'))

        <div class="partner-alert partner-alert-success">
            {{ Session::get('message') }}
        </div>

    @endif


    {{-- =====================================================
         VALIDATION ERRORS
    ====================================================== --}}

    @if($errors->any())

        <div class="partner-alert partner-alert-error">

            <strong>Please check the form.</strong>

            <ul class="mb-0 mt-1 pl-3">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- =====================================================
         PARTNERS TABLE
    ====================================================== --}}

    <div class="partner-card">

        <div class="partner-card-header">

            <div class="partner-card-title">

                <h2>All Partners</h2>

                <span class="partner-count">
                    {{ $totalPartners }}
                </span>

            </div>

            <div style="font-size:12px;color:#8A9690;">
                Partner organizations
            </div>

        </div>


        @if($partners->count())

            <div class="partner-table-wrapper">

                <table class="partner-table">

                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Logo</th>
                            <th>Partner</th>
                            <th class="text-right">Actions</th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach($partners as $partner)

                            <tr>

                                <td class="partner-number">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- LOGO --}}
                                <td>

                                    @if(
                                        $partner->image &&
                                        file_exists(public_path('image/partner/' . $partner->image))
                                    )

                                        <img
                                            src="{{ asset('image/partner/' . $partner->image) }}"
                                            alt="{{ $partner->name }}"
                                            class="partner-image"
                                        >

                                    @else

                                        <div class="partner-image-placeholder">

                                            <svg viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="1.7"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round">

                                                <rect x="3" y="3"
                                                      width="18"
                                                      height="18"
                                                      rx="2">
                                                </rect>

                                                <circle cx="8.5"
                                                        cy="8.5"
                                                        r="1.5">
                                                </circle>

                                                <path d="M21 15l-5-5L6 20"></path>

                                            </svg>

                                        </div>

                                    @endif

                                </td>


                                {{-- NAME --}}
                                <td>

                                    <div class="partner-name">
                                        {{ $partner->name }}
                                    </div>

                                    <div class="partner-description">
                                        Partner organization
                                    </div>

                                </td>


                                {{-- ACTIONS --}}
                                <td>

                                    <div class="partner-actions">

                                        {{-- EDIT --}}
                                        <button
                                            type="button"
                                            class="partner-action partner-action-edit"
                                            title="Edit partner"
                                            onclick="openEditPartnerModal(
                                                {{ $partner->id }},
                                                @js($partner->name),
                                                @js($partner->image)
                                            )"
                                        >

                                            <svg viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="1.8"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round">

                                                <path d="M12 20h9"></path>

                                                <path d="M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4L16.5 3.5z"></path>

                                            </svg>

                                        </button>


                                        {{-- DELETE --}}
                                        <form
                                            action="{{ route('admin.delete_partner', $partner->id) }}"
                                            method="POST"
                                            class="m-0"
                                            onsubmit="return confirm('Are you sure you want to delete this partner?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="partner-action partner-action-delete"
                                                title="Delete partner"
                                            >

                                                <svg viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.8"
                                                     stroke-linecap="round"
                                                     stroke-linejoin="round">

                                                    <polyline points="3 6 5 6 21 6"></polyline>

                                                    <path d="M19 6l-1 14H6L5 6"></path>

                                                    <path d="M10 11v5"></path>

                                                    <path d="M14 11v5"></path>

                                                    <path d="M9 6V4h6v2"></path>

                                                </svg>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="partner-empty">

                <div class="partner-empty-icon">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.7"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <circle cx="9" cy="8" r="3"></circle>

                        <circle cx="17" cy="10" r="2"></circle>

                        <path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"></path>

                    </svg>

                </div>

                <h3>No partners yet</h3>

                <p>
                    Add your first partner organization and upload its logo.
                </p>

                <button
                    type="button"
                    class="btn-add-partner"
                    onclick="openPartnerModal('addPartnerModal')"
                >

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round">

                        <path d="M12 5v14"></path>
                        <path d="M5 12h14"></path>

                    </svg>

                    Add Partner

                </button>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     ADD PARTNER MODAL
========================================================= --}}

<div
    id="addPartnerModal"
    class="partner-modal"
    aria-hidden="true"
>

    <div
        class="partner-modal-overlay"
        onclick="closePartnerModal('addPartnerModal')"
    ></div>


    <div class="partner-modal-dialog">

        <div class="partner-modal-header">

            <div class="partner-modal-heading">

                <div class="partner-modal-icon">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <circle cx="9" cy="8" r="3"></circle>

                        <path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"></path>

                        <path d="M17 11v6"></path>
                        <path d="M14 14h6"></path>

                    </svg>

                </div>

                <div>

                    <h5 class="partner-modal-title">
                        Add New Partner
                    </h5>

                    <div class="partner-modal-subtitle">
                        Add a partner organization and logo.
                    </div>

                </div>

            </div>


            <button
                type="button"
                class="partner-modal-close"
                onclick="closePartnerModal('addPartnerModal')"
            >
                &times;
            </button>

        </div>


        <form
            action="{{ route('admin.add_partner') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="partner-modal-body">

                {{-- NAME --}}
                <div class="partner-form-group">

                    <label
                        for="add_partner_name"
                        class="partner-form-label"
                    >
                        Partner name
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        type="text"
                        id="add_partner_name"
                        name="name"
                        class="partner-form-control"
                        value="{{ old('name') }}"
                        placeholder="Enter partner name"
                        required
                    >

                    @error('name')
                        <div class="partner-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- IMAGE --}}
                <div class="partner-form-group mb-0">

                    <label
                        for="add_partner_image"
                        class="partner-form-label"
                    >
                        Partner logo
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        type="file"
                        id="add_partner_image"
                        name="image"
                        class="partner-file-control"
                        accept=".jpg,.jpeg,.png"
                        required
                    >

                    <div class="partner-file-help">
                        JPG, JPEG or PNG. Maximum size 5MB.
                    </div>


                    <div
                        id="addPartnerPreviewBox"
                        class="partner-preview-box"
                        style="display:none;"
                    >

                        <div class="partner-preview-label">
                            <span>Logo preview</span>
                        </div>

                        <img
                            id="addPartnerPreview"
                            src=""
                            alt="Partner logo preview"
                        >

                    </div>


                    @error('image')
                        <div class="partner-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            <div class="partner-modal-footer">

                <button
                    type="button"
                    class="btn-partner-cancel"
                    onclick="closePartnerModal('addPartnerModal')"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="btn-partner-save"
                >
                    Add Partner
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     EDIT PARTNER MODAL
========================================================= --}}

<div
    id="editPartnerModal"
    class="partner-modal"
    aria-hidden="true"
>

    <div
        class="partner-modal-overlay"
        onclick="closePartnerModal('editPartnerModal')"
    ></div>


    <div class="partner-modal-dialog">

        <div class="partner-modal-header">

            <div class="partner-modal-heading">

                <div class="partner-modal-icon">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <path d="M12 20h9"></path>

                        <path d="M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4L16.5 3.5z"></path>

                    </svg>

                </div>

                <div>

                    <h5 class="partner-modal-title">
                        Edit Partner
                    </h5>

                    <div class="partner-modal-subtitle">
                        Update partner information and logo.
                    </div>

                </div>

            </div>


            <button
                type="button"
                class="partner-modal-close"
                onclick="closePartnerModal('editPartnerModal')"
            >
                &times;
            </button>

        </div>


        <form
            id="editPartnerForm"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')


            <div class="partner-modal-body">

                {{-- NAME --}}
                <div class="partner-form-group">

                    <label
                        for="edit_partner_name"
                        class="partner-form-label"
                    >
                        Partner name
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        type="text"
                        id="edit_partner_name"
                        name="name"
                        class="partner-form-control"
                        required
                    >

                </div>


                {{-- CURRENT IMAGE --}}
                <div class="partner-form-group">

                    <label class="partner-form-label">
                        Current logo
                    </label>

                    <div class="partner-preview-box">

                        <div class="partner-preview-label">
                            <span>Current partner logo</span>
                            <span>Logo</span>
                        </div>

                        <img
                            id="editCurrentPartnerImage"
                            src=""
                            alt="Current partner logo"
                        >

                    </div>

                </div>


                {{-- NEW IMAGE --}}
                <div class="partner-form-group mb-0">

                    <label
                        for="edit_partner_image"
                        class="partner-form-label"
                    >
                        Replace logo
                    </label>

                    <input
                        type="file"
                        id="edit_partner_image"
                        name="image"
                        class="partner-file-control"
                        accept=".jpg,.jpeg,.png"
                    >

                    <div class="partner-file-help">
                        Leave empty to keep the current logo.
                    </div>


                    <div
                        id="editPartnerPreviewBox"
                        class="partner-preview-box"
                        style="display:none;"
                    >

                        <div class="partner-preview-label">
                            <span>New logo preview</span>
                        </div>

                        <img
                            id="editPartnerPreview"
                            src=""
                            alt="New partner logo preview"
                        >

                    </div>

                </div>

            </div>


            <div class="partner-modal-footer">

                <button
                    type="button"
                    class="btn-partner-cancel"
                    onclick="closePartnerModal('editPartnerModal')"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="btn-partner-save"
                    id="editPartnerSubmit"
                >
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>


<script>
(function () {

    /*
    |--------------------------------------------------------------------------
    | Open Modal
    |--------------------------------------------------------------------------
    */

    window.openPartnerModal = function (modalId) {

        const modal = document.getElementById(modalId);

        if (!modal) {
            return;
        }

        modal.classList.add('show');

        modal.setAttribute('aria-hidden', 'false');

        document.body.style.overflow = 'hidden';
    };


    /*
    |--------------------------------------------------------------------------
    | Close Modal
    |--------------------------------------------------------------------------
    */

    window.closePartnerModal = function (modalId) {

        const modal = document.getElementById(modalId);

        if (!modal) {
            return;
        }

        modal.classList.remove('show');

        modal.setAttribute('aria-hidden', 'true');

        const openedModal =
            document.querySelector('.partner-modal.show');

        if (!openedModal) {
            document.body.style.overflow = '';
        }
    };


    /*
    |--------------------------------------------------------------------------
    | ESC Key
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') {
            return;
        }

        const openModal =
            document.querySelector('.partner-modal.show');

        if (openModal) {
            closePartnerModal(openModal.id);
        }

    });


    /*
    |--------------------------------------------------------------------------
    | Add Partner Image Preview
    |--------------------------------------------------------------------------
    */

    const addImage =
        document.getElementById('add_partner_image');

    const addPreview =
        document.getElementById('addPartnerPreview');

    const addPreviewBox =
        document.getElementById('addPartnerPreviewBox');


    if (addImage) {

        addImage.addEventListener('change', function () {

            const file = this.files[0];

            if (!file) {

                addPreviewBox.style.display = 'none';
                addPreview.src = '';

                return;
            }

            if (!file.type.startsWith('image/')) {

                addPreviewBox.style.display = 'none';

                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {

                addPreview.src = event.target.result;

                addPreviewBox.style.display = 'block';

            };

            reader.readAsDataURL(file);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Open Edit Partner Modal
    |--------------------------------------------------------------------------
    */

    window.openEditPartnerModal = function (
        id,
        name,
        image
    ) {

        const modal =
            document.getElementById('editPartnerModal');

        const form =
            document.getElementById('editPartnerForm');

        const nameInput =
            document.getElementById('edit_partner_name');

        const currentImage =
            document.getElementById('editCurrentPartnerImage');

        const imageInput =
            document.getElementById('edit_partner_image');

        const newPreview =
            document.getElementById('editPartnerPreview');

        const newPreviewBox =
            document.getElementById('editPartnerPreviewBox');


        /*
        |--------------------------------------------------------------------------
        | Populate Name
        |--------------------------------------------------------------------------
        */

        nameInput.value = name || '';


        /*
        |--------------------------------------------------------------------------
        | Update URL
        |--------------------------------------------------------------------------
        */

        form.action =
            "{{ url('/admin/partners/update') }}/" + id;


        /*
        |--------------------------------------------------------------------------
        | Current Image
        |--------------------------------------------------------------------------
        */

        if (image) {

            currentImage.src =
                "{{ asset('image/partner') }}/" +
                encodeURIComponent(image);

            currentImage.style.display = 'block';

        } else {

            currentImage.removeAttribute('src');

            currentImage.style.display = 'none';

        }


        /*
        |--------------------------------------------------------------------------
        | Reset New Image
        |--------------------------------------------------------------------------
        */

        imageInput.value = '';

        newPreview.src = '';

        newPreviewBox.style.display = 'none';


        /*
        |--------------------------------------------------------------------------
        | Open
        |--------------------------------------------------------------------------
        */

        openPartnerModal('editPartnerModal');
    };


    /*
    |--------------------------------------------------------------------------
    | Edit Image Preview
    |--------------------------------------------------------------------------
    */

    const editImage =
        document.getElementById('edit_partner_image');

    const editPreview =
        document.getElementById('editPartnerPreview');

    const editPreviewBox =
        document.getElementById('editPartnerPreviewBox');


    if (editImage) {

        editImage.addEventListener('change', function () {

            const file = this.files[0];

            if (!file) {

                editPreviewBox.style.display = 'none';

                editPreview.src = '';

                return;
            }

            if (!file.type.startsWith('image/')) {

                editPreviewBox.style.display = 'none';

                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {

                editPreview.src = event.target.result;

                editPreviewBox.style.display = 'block';

            };

            reader.readAsDataURL(file);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Edit Submit Loading
    |--------------------------------------------------------------------------
    */

    const editForm =
        document.getElementById('editPartnerForm');

    const editSubmit =
        document.getElementById('editPartnerSubmit');


    if (editForm && editSubmit) {

        editForm.addEventListener('submit', function () {

            editSubmit.disabled = true;

            editSubmit.textContent = 'Saving...';

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Reopen Add Modal After Validation Error
    |--------------------------------------------------------------------------
    */

    @if($errors->any() && old('name'))
        openPartnerModal('addPartnerModal');
    @endif

})();
</script>

@endsection