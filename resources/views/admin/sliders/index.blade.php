@extends('layouts.app')

@section('title', 'Sliders')

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

    .slider-page {
        padding: 10px 0 40px;
    }

    /* =========================================================
       PAGE HEADER
    ========================================================= */

    .slider-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .slider-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .slider-page-icon {
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

    .slider-page-icon svg {
        width: 23px;
        height: 23px;
    }

    .slider-header h1 {
        margin: 0;
        color: var(--connector-dark);
        font-size: 24px;
        font-weight: 700;
        letter-spacing: -.3px;
    }

    .slider-header p {
        margin: 4px 0 0;
        color: var(--connector-muted);
        font-size: 14px;
    }

    .btn-add-slider {
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
        transition: .2s ease;
        cursor: pointer;
    }

    .btn-add-slider:hover {
        background: var(--connector-primary);
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-add-slider svg {
        width: 17px;
        height: 17px;
    }

    /* =========================================================
       STATISTICS
    ========================================================= */

    .slider-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 4px 16px rgba(37, 64, 53, .04);
    }

    .stat-icon {
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

    .stat-icon svg {
        width: 20px;
        height: 20px;
    }

    .stat-label {
        color: var(--connector-muted);
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 3px;
    }

    .stat-value {
        color: var(--connector-dark);
        font-size: 21px;
        line-height: 1.2;
        font-weight: 700;
    }

    /* =========================================================
       ALERT
    ========================================================= */

    .slider-alert {
        margin-bottom: 20px;
        padding: 13px 16px;
        border-radius: 10px;
        font-size: 13px;
    }

    .slider-alert-success {
        background: #EDF7F1;
        color: #2E6B49;
        border: 1px solid #CDE8D8;
    }

    .slider-alert-error {
        background: var(--connector-danger-soft);
        color: #A63E3E;
        border: 1px solid #F2D0D0;
    }

    /* =========================================================
       MAIN CARD
    ========================================================= */

    .slider-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 16px;
        box-shadow: 0 6px 24px rgba(37, 64, 53, .05);
        overflow: hidden;
    }

    .slider-card-header {
        padding: 19px 22px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .slider-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .slider-card-title h2 {
        margin: 0;
        font-size: 16px;
        color: var(--connector-dark);
        font-weight: 700;
    }

    .slider-count {
        background: var(--connector-soft);
        color: var(--connector-dark);
        font-size: 12px;
        font-weight: 700;
        padding: 5px 9px;
        border-radius: 20px;
    }

    .slider-table-wrapper {
        overflow-x: auto;
    }

    /* =========================================================
       TABLE
    ========================================================= */

    .slider-table {
        width: 100%;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 760px;
    }

    .slider-table thead th {
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

    .slider-table tbody td {
        padding: 15px 18px;
        border-bottom: 1px solid #EEF2F0;
        vertical-align: middle;
        color: var(--connector-text);
        font-size: 13px;
    }

    .slider-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .slider-table tbody tr {
        transition: background .15s ease;
    }

    .slider-table tbody tr:hover {
        background: #FAFCFB;
    }

    .slider-number {
        color: #8A9690;
        font-weight: 600;
        width: 50px;
    }

    /* =========================================================
       IMAGE
    ========================================================= */

    .slider-image {
        width: 110px;
        height: 64px;
        border-radius: 9px;
        object-fit: cover;
        border: 1px solid var(--connector-border);
        background: #F5F7F6;
        display: block;
    }

    .slider-image-placeholder {
        width: 110px;
        height: 64px;
        border-radius: 9px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slider-image-placeholder svg {
        width: 23px;
        height: 23px;
    }

    .slider-title {
        color: var(--connector-dark);
        font-weight: 650;
        font-size: 14px;
        max-width: 300px;
    }

    /* =========================================================
       STATUS
    ========================================================= */

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 20px;
        padding: 6px 10px;
        font-size: 11px;
        font-weight: 700;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-active {
        color: #28704A;
        background: #EAF6EF;
    }

    .status-active .status-dot {
        background: #4BA875;
    }

    .status-inactive {
        color: #707A75;
        background: #F0F2F1;
    }

    .status-inactive .status-dot {
        background: #9BA49F;
    }

    .slider-date {
        color: var(--connector-muted);
        white-space: nowrap;
        font-size: 12px;
    }

    /* =========================================================
       ACTIONS
    ========================================================= */

    .slider-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
        white-space: nowrap;
    }

    .slider-action {
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

    .slider-action svg {
        width: 16px;
        height: 16px;
    }

    .slider-action-edit {
        color: var(--connector-primary);
    }

    .slider-action-edit:hover {
        color: #fff;
        background: var(--connector-primary);
        border-color: var(--connector-primary);
    }

    .slider-action-delete {
        color: var(--connector-danger);
    }

    .slider-action-delete:hover {
        color: #fff;
        background: var(--connector-danger);
        border-color: var(--connector-danger);
    }

    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .slider-empty {
        padding: 65px 25px;
        text-align: center;
    }

    .slider-empty-icon {
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

    .slider-empty-icon svg {
        width: 26px;
        height: 26px;
    }

    .slider-empty h3 {
        margin: 0 0 6px;
        color: var(--connector-dark);
        font-size: 17px;
        font-weight: 700;
    }

    .slider-empty p {
        color: var(--connector-muted);
        font-size: 13px;
        margin: 0 0 18px;
    }

    /* =========================================================
       CUSTOM MODAL
    ========================================================= */

    .custom-modal {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .custom-modal.show {
        display: flex;
    }

    .custom-modal-overlay {
        position: absolute;
        inset: 0;
        background: rgba(20, 31, 26, .58);
        backdrop-filter: blur(3px);
    }

    .custom-modal-dialog {
        position: relative;
        width: 100%;
        max-width: 540px;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
        background: #fff;
        border-radius: 17px;
        box-shadow: 0 25px 80px rgba(0, 0, 0, .20);
        z-index: 2;
        animation: modalIn .18s ease-out;
    }

    @keyframes modalIn {
        from {
            opacity: 0;
            transform: translateY(12px) scale(.98);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .custom-modal-header {
        padding: 19px 22px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .modal-heading {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .modal-heading-icon {
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

    .modal-heading-icon svg {
        width: 19px;
        height: 19px;
    }

    .custom-modal-title {
        margin: 0;
        color: var(--connector-dark);
        font-size: 17px;
        font-weight: 700;
    }

    .custom-modal-subtitle {
        color: var(--connector-muted);
        font-size: 12px;
        margin-top: 2px;
    }

    .modal-close {
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
        transition: .18s ease;
    }

    .modal-close:hover {
        background: #E9EEEB;
        color: var(--connector-dark);
    }

    .custom-modal-body {
        padding: 22px;
    }

    .custom-modal-footer {
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

    .slider-form-group {
        margin-bottom: 18px;
    }

    .slider-form-label {
        display: block;
        color: var(--connector-dark);
        font-size: 13px;
        font-weight: 650;
        margin-bottom: 7px;
    }

    .required-mark {
        color: var(--connector-danger);
    }

    .slider-form-control {
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

    .slider-form-control:focus {
        border-color: var(--connector-primary);
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .12);
    }

    .slider-file-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px dashed #C8D7D0;
        border-radius: 9px;
        background: #FAFCFB;
        color: var(--connector-muted);
        font-size: 12px;
    }

    .slider-file-help {
        margin-top: 6px;
        color: #8A9690;
        font-size: 11px;
    }

    .slider-error {
        margin-top: 5px;
        color: var(--connector-danger);
        font-size: 11px;
    }

    /* =========================================================
       IMAGE PREVIEW
    ========================================================= */

    .image-preview-box {
        margin-top: 10px;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        padding: 7px;
        background: #FAFCFB;
    }

    .image-preview-box img {
        width: 100%;
        height: 145px;
        object-fit: cover;
        display: block;
        border-radius: 7px;
    }

    .current-image-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: var(--connector-muted);
        font-size: 11px;
        margin-bottom: 6px;
    }

    /* =========================================================
       BUTTONS
    ========================================================= */

    .btn-modal-cancel {
        border: 1px solid #D9E2DE;
        background: #fff;
        color: var(--connector-dark);
        border-radius: 9px;
        padding: 9px 15px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-modal-cancel:hover {
        background: #F5F8F6;
    }

    .btn-modal-save {
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

    .btn-modal-save:hover {
        background: var(--connector-primary);
    }

    .btn-modal-save:disabled {
        opacity: .65;
        cursor: not-allowed;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 768px) {

        .slider-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .btn-add-slider {
            width: 100%;
        }

        .slider-stats {
            grid-template-columns: 1fr;
        }

        .slider-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .custom-modal {
            padding: 12px;
        }

        .custom-modal-dialog {
            max-height: calc(100vh - 24px);
        }
    }
</style>


<div class="container-fluid slider-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="slider-header">

        <div class="slider-header-left">

            <div class="slider-page-icon">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                    <circle cx="8.5" cy="9" r="1.5"></circle>
                    <path d="M21 15l-4.5-4.5L10 17l-2.5-2.5L3 19"></path>
                </svg>
            </div>

            <div>
                <h1>Sliders</h1>
                <p>
                    Manage the promotional banners displayed across your platform.
                </p>
            </div>

        </div>

        <button
            type="button"
            class="btn-add-slider"
            onclick="openSliderModal('addSliderModal')"
        >
            <svg viewBox="0 0 24 24" fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round">
                <path d="M12 5v14"></path>
                <path d="M5 12h14"></path>
            </svg>

            Add Slider
        </button>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    @php
        $totalSliders = $sliders->count();
        $activeSliders = $sliders->where('status', 1)->count();
        $inactiveSliders = $sliders->where('status', 0)->count();
    @endphp


    <div class="slider-stats">

        <div class="stat-card">

            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                    <path d="M7 15l3-3 2 2 3-4 3 5"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Total Sliders</div>
                <div class="stat-value">{{ $totalSliders }}</div>
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M20 6L9 17l-5-5"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Active</div>
                <div class="stat-value">{{ $activeSliders }}</div>
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9"></circle>
                    <path d="M9 9l6 6"></path>
                    <path d="M15 9l-6 6"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Inactive</div>
                <div class="stat-value">{{ $inactiveSliders }}</div>
            </div>

        </div>

    </div>


    {{-- =====================================================
         FLASH MESSAGE
    ====================================================== --}}

    @if(Session::has('message'))

        <div class="slider-alert slider-alert-success">
            {{ Session::get('message') }}
        </div>

    @endif


    {{-- =====================================================
         VALIDATION ERRORS
    ====================================================== --}}

    @if($errors->any())

        <div class="slider-alert slider-alert-error">

            <strong>Please check the form.</strong>

            <ul class="mb-0 mt-1 pl-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    {{-- =====================================================
         SLIDERS TABLE
    ====================================================== --}}

    <div class="slider-card">

        <div class="slider-card-header">

            <div class="slider-card-title">

                <h2>All Sliders</h2>

                <span class="slider-count">
                    {{ $totalSliders }}
                </span>

            </div>

            <div style="font-size:12px;color:#8A9690;">
                Promotional banners
            </div>

        </div>


        @if($sliders->count())

            <div class="slider-table-wrapper">

                <table class="slider-table">

                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Preview</th>
                            <th>Slider</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="text-right">Actions</th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach($sliders as $slider)

                            <tr>

                                <td class="slider-number">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- IMAGE --}}
                                <td>

                                    @if(
                                        $slider->image &&
                                        file_exists(public_path('image/slider/' . $slider->image))
                                    )

                                        <img
                                            src="{{ asset('image/slider/' . $slider->image) }}"
                                            alt="{{ $slider->title }}"
                                            class="slider-image"
                                        >

                                    @else

                                        <div class="slider-image-placeholder">

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


                                {{-- TITLE --}}
                                <td>

                                    <div class="slider-title">
                                        {{ $slider->title }}
                                    </div>

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @if($slider->status)

                                        <span class="status-badge status-active">
                                            <span class="status-dot"></span>
                                            Active
                                        </span>

                                    @else

                                        <span class="status-badge status-inactive">
                                            <span class="status-dot"></span>
                                            Inactive
                                        </span>

                                    @endif

                                </td>


                                {{-- CREATED --}}
                                <td>

                                    <div class="slider-date">
                                        {{ $slider->created_at?->format('d M Y') }}
                                    </div>

                                    <div style="font-size:11px;color:#A0AAA5;margin-top:2px;">
                                        {{ $slider->created_at?->format('H:i') }}
                                    </div>

                                </td>


                                {{-- ACTIONS --}}
                                <td>

                                    <div class="slider-actions">

                                        {{-- EDIT MODAL BUTTON --}}
                                        <button
                                            type="button"
                                            class="slider-action slider-action-edit"
                                            title="Edit slider"
                                            onclick="openEditSliderModal(
                                                {{ $slider->id }},
                                                @js($slider->title),
                                                {{ $slider->status ? 1 : 0 }},
                                                @js($slider->image)
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
                                            action="{{ route('admin.delete_slider', $slider->id) }}"
                                            method="POST"
                                            class="m-0"
                                            onsubmit="return confirm('Are you sure you want to delete this slider?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="slider-action slider-action-delete"
                                                title="Delete slider"
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

            <div class="slider-empty">

                <div class="slider-empty-icon">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.7"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <rect x="3" y="4"
                              width="18"
                              height="16"
                              rx="2">
                        </rect>

                        <path d="M7 15l3-3 2 2 3-4 3 5"></path>

                    </svg>

                </div>

                <h3>No sliders yet</h3>

                <p>
                    Create your first promotional slider to start displaying banners.
                </p>

                <button
                    type="button"
                    class="btn-add-slider"
                    onclick="openSliderModal('addSliderModal')"
                >

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round">

                        <path d="M12 5v14"></path>
                        <path d="M5 12h14"></path>

                    </svg>

                    Add Slider

                </button>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     ADD SLIDER MODAL
========================================================= --}}

<div
    id="addSliderModal"
    class="custom-modal"
    aria-hidden="true"
>

    <div
        class="custom-modal-overlay"
        onclick="closeSliderModal('addSliderModal')"
    ></div>


    <div class="custom-modal-dialog">

        <div class="custom-modal-header">

            <div class="modal-heading">

                <div class="modal-heading-icon">

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

                        <path d="M7 15l3-3 2 2 3-4 3 5"></path>

                    </svg>

                </div>

                <div>

                    <h5 class="custom-modal-title">
                        Add New Slider
                    </h5>

                    <div class="custom-modal-subtitle">
                        Create a promotional banner.
                    </div>

                </div>

            </div>


            <button
                type="button"
                class="modal-close"
                onclick="closeSliderModal('addSliderModal')"
                aria-label="Close"
            >
                &times;
            </button>

        </div>


        <form
            action="{{ route('admin.add_slider') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="custom-modal-body">

                {{-- TITLE --}}
                <div class="slider-form-group">

                    <label
                        for="add_title"
                        class="slider-form-label"
                    >
                        Slider title
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        type="text"
                        class="slider-form-control"
                        id="add_title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Enter slider title"
                        required
                    >

                    @error('title')
                        <div class="slider-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- STATUS --}}
                <div class="slider-form-group">

                    <label
                        for="add_status"
                        class="slider-form-label"
                    >
                        Status
                    </label>

                    <select
                        class="slider-form-control"
                        id="add_status"
                        name="status"
                    >

                        <option value="0"
                            {{ old('status', '0') == '0' ? 'selected' : '' }}>
                            Inactive
                        </option>

                        <option value="1"
                            {{ old('status') == '1' ? 'selected' : '' }}>
                            Active
                        </option>

                    </select>

                </div>


                {{-- IMAGE --}}
                <div class="slider-form-group mb-0">

                    <label
                        for="add_image"
                        class="slider-form-label"
                    >
                        Slider image
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        type="file"
                        class="slider-file-control"
                        id="add_image"
                        name="image"
                        accept=".jpg,.jpeg,.png"
                        required
                    >

                    <div class="slider-file-help">
                        JPG, JPEG or PNG. Maximum size 5MB.
                    </div>

                    <div
                        id="addImagePreviewBox"
                        class="image-preview-box"
                        style="display:none;"
                    >
                        <img id="addImagePreview" src="" alt="Preview">
                    </div>

                    @error('image')
                        <div class="slider-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            <div class="custom-modal-footer">

                <button
                    type="button"
                    class="btn-modal-cancel"
                    onclick="closeSliderModal('addSliderModal')"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="btn-modal-save"
                >
                    Add Slider
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     EDIT SLIDER MODAL
========================================================= --}}

<div
    id="editSliderModal"
    class="custom-modal"
    aria-hidden="true"
>

    <div
        class="custom-modal-overlay"
        onclick="closeSliderModal('editSliderModal')"
    ></div>


    <div class="custom-modal-dialog">

        <div class="custom-modal-header">

            <div class="modal-heading">

                <div class="modal-heading-icon">

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

                    <h5 class="custom-modal-title">
                        Edit Slider
                    </h5>

                    <div class="custom-modal-subtitle">
                        Update slider information and image.
                    </div>

                </div>

            </div>


            <button
                type="button"
                class="modal-close"
                onclick="closeSliderModal('editSliderModal')"
                aria-label="Close"
            >
                &times;
            </button>

        </div>


        <form
            id="editSliderForm"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')


            <div class="custom-modal-body">

                {{-- TITLE --}}
                <div class="slider-form-group">

                    <label
                        for="edit_title"
                        class="slider-form-label"
                    >
                        Slider title
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        type="text"
                        class="slider-form-control"
                        id="edit_title"
                        name="title"
                        required
                    >

                </div>


                {{-- STATUS --}}
                <div class="slider-form-group">

                    <label
                        for="edit_status"
                        class="slider-form-label"
                    >
                        Status
                    </label>

                    <select
                        class="slider-form-control"
                        id="edit_status"
                        name="status"
                    >

                        <option value="0">
                            Inactive
                        </option>

                        <option value="1">
                            Active
                        </option>

                    </select>

                </div>


                {{-- CURRENT IMAGE --}}
                <div class="slider-form-group">

                    <label class="slider-form-label">
                        Current image
                    </label>

                    <div class="image-preview-box">

                        <div class="current-image-label">

                            <span>
                                Current slider image
                            </span>

                            <span>
                                Optional replacement
                            </span>

                        </div>

                        <img
                            id="editCurrentImage"
                            src=""
                            alt="Current slider image"
                        >

                    </div>

                </div>


                {{-- NEW IMAGE --}}
                <div class="slider-form-group mb-0">

                    <label
                        for="edit_image"
                        class="slider-form-label"
                    >
                        Replace image
                    </label>

                    <input
                        type="file"
                        class="slider-file-control"
                        id="edit_image"
                        name="image"
                        accept=".jpg,.jpeg,.png"
                    >

                    <div class="slider-file-help">
                        Leave empty to keep the current image.
                    </div>


                    <div
                        id="editImagePreviewBox"
                        class="image-preview-box"
                        style="display:none;"
                    >

                        <div class="current-image-label">
                            <span>New image preview</span>
                        </div>

                        <img
                            id="editImagePreview"
                            src=""
                            alt="New image preview"
                        >

                    </div>

                </div>

            </div>


            <div class="custom-modal-footer">

                <button
                    type="button"
                    class="btn-modal-cancel"
                    onclick="closeSliderModal('editSliderModal')"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="btn-modal-save"
                    id="editSubmitButton"
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
    | Modal Functions
    |--------------------------------------------------------------------------
    */

    window.openSliderModal = function (modalId) {

        const modal = document.getElementById(modalId);

        if (!modal) {
            return;
        }

        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');

        document.body.style.overflow = 'hidden';
    };


    window.closeSliderModal = function (modalId) {

        const modal = document.getElementById(modalId);

        if (!modal) {
            return;
        }

        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');

        /*
        |--------------------------------------------------------------------------
        | Only restore body scrolling when no modal is open
        |--------------------------------------------------------------------------
        */

        const openedModal = document.querySelector('.custom-modal.show');

        if (!openedModal) {
            document.body.style.overflow = '';
        }
    };


    /*
    |--------------------------------------------------------------------------
    | Close Modal With ESC
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') {
            return;
        }

        const openModal = document.querySelector('.custom-modal.show');

        if (openModal) {
            closeSliderModal(openModal.id);
        }

    });


    /*
    |--------------------------------------------------------------------------
    | Add Image Preview
    |--------------------------------------------------------------------------
    */

    const addImage = document.getElementById('add_image');
    const addPreview = document.getElementById('addImagePreview');
    const addPreviewBox = document.getElementById('addImagePreviewBox');

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
    | Edit Slider Modal
    |--------------------------------------------------------------------------
    */

    window.openEditSliderModal = function (
        id,
        title,
        status,
        image
    ) {

        const modal = document.getElementById('editSliderModal');

        const form = document.getElementById('editSliderForm');

        const titleInput = document.getElementById('edit_title');

        const statusInput = document.getElementById('edit_status');

        const currentImage = document.getElementById('editCurrentImage');

        const imageInput = document.getElementById('edit_image');

        const newPreview = document.getElementById('editImagePreview');

        const newPreviewBox = document.getElementById(
            'editImagePreviewBox'
        );


        /*
        |--------------------------------------------------------------------------
        | Populate Form
        |--------------------------------------------------------------------------
        */

        titleInput.value = title || '';

        statusInput.value = status ? '1' : '0';


        /*
        |--------------------------------------------------------------------------
        | Set Update URL
        |--------------------------------------------------------------------------
        */

        form.action =
            "{{ url('/admin/slider/update') }}/" + id;


        /*
        |--------------------------------------------------------------------------
        | Current Image
        |--------------------------------------------------------------------------
        */

        if (image) {

            currentImage.src =
                "{{ asset('image/slider') }}/" +
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
        | Open Modal
        |--------------------------------------------------------------------------
        */

        openSliderModal('editSliderModal');
    };


    /*
    |--------------------------------------------------------------------------
    | Edit Image Preview
    |--------------------------------------------------------------------------
    */

    const editImage = document.getElementById('edit_image');

    const editPreview =
        document.getElementById('editImagePreview');

    const editPreviewBox =
        document.getElementById('editImagePreviewBox');


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
    | Form Loading State
    |--------------------------------------------------------------------------
    */

    const editForm =
        document.getElementById('editSliderForm');

    const editButton =
        document.getElementById('editSubmitButton');


    if (editForm && editButton) {

        editForm.addEventListener('submit', function () {

            editButton.disabled = true;

            editButton.textContent = 'Saving...';

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Open Add Modal Automatically After Validation Error
    |--------------------------------------------------------------------------
    */

    @if($errors->any() && old('title'))
        openSliderModal('addSliderModal');
    @endif

})();
</script>

@endsection