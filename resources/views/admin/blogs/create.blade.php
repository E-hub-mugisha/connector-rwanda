@extends('layouts.app')

@section('title', 'Create Blog')

@section('content')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css">

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-dark: #254035;
        --connector-soft: #eef5f2;
        --connector-border: #e4ebe8;
        --connector-text: #25332d;
        --connector-muted: #7b8983;
        --connector-danger: #c94c4c;
    }

    .blog-create-page {
        padding: 10px 0 40px;
        color: var(--connector-text);
    }

    /* Header */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 25px;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .page-icon {
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

    .page-icon svg {
        width: 23px;
        height: 23px;
    }

    .page-title {
        margin: 0;
        font-size: 25px;
        font-weight: 700;
        color: var(--connector-dark);
        letter-spacing: -0.3px;
    }

    .page-subtitle {
        margin: 4px 0 0;
        color: var(--connector-muted);
        font-size: 14px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--connector-border);
        background: #fff;
        color: var(--connector-dark);
        padding: 10px 15px;
        border-radius: 10px;
        text-decoration: none !important;
        font-size: 13px;
        font-weight: 600;
        transition: .2s ease;
    }

    .back-button:hover {
        border-color: var(--connector-primary);
        color: var(--connector-primary);
        background: var(--connector-soft);
    }

    .back-button svg {
        width: 16px;
        height: 16px;
    }

    /* Alerts */
    .alert-modern {
        border: 0;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 22px;
        font-size: 14px;
    }

    .alert-success-modern {
        background: #edf8f2;
        color: #28734d;
    }

    .alert-danger-modern {
        background: #fff0f0;
        color: #a53e3e;
    }

    /* Main grid */
    .create-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 22px;
        align-items: start;
    }

    .content-card,
    .side-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(37, 64, 53, .045);
    }

    .content-card {
        overflow: hidden;
    }

    .card-section {
        padding: 24px;
    }

    .card-section + .card-section {
        border-top: 1px solid var(--connector-border);
    }

    .section-heading {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 21px;
    }

    .section-number {
        width: 30px;
        height: 30px;
        border-radius: 9px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .section-heading h3 {
        margin: 0;
        color: var(--connector-dark);
        font-size: 16px;
        font-weight: 700;
    }

    .section-heading p {
        margin: 3px 0 0;
        color: var(--connector-muted);
        font-size: 12px;
    }

    /* Form */
    .form-label-modern {
        display: block;
        margin-bottom: 7px;
        color: var(--connector-dark);
        font-size: 13px;
        font-weight: 650;
    }

    .required {
        color: var(--connector-danger);
    }

    .form-control-modern,
    .select-modern {
        width: 100%;
        min-height: 45px;
        border: 1px solid #dfe7e3;
        border-radius: 10px;
        background: #fff;
        color: var(--connector-text);
        padding: 10px 13px;
        font-size: 13px;
        outline: none;
        transition: .2s ease;
    }

    .form-control-modern:focus,
    .select-modern:focus {
        border-color: var(--connector-primary);
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .12);
    }

    textarea.form-control-modern {
        min-height: 120px;
        resize: vertical;
    }

    .field-help {
        color: var(--connector-muted);
        font-size: 11px;
        margin-top: 6px;
    }

    .field-error {
        color: var(--connector-danger);
        font-size: 12px;
        margin-top: 6px;
    }

    .title-wrapper {
        position: relative;
    }

    .title-counter {
        position: absolute;
        right: 12px;
        bottom: 9px;
        font-size: 11px;
        color: var(--connector-muted);
        pointer-events: none;
        background: #fff;
        padding-left: 5px;
    }

    /* Category */
    .form-row-modern {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    /* Summernote */
    .note-editor.note-frame {
        border: 1px solid #dfe7e3 !important;
        border-radius: 10px !important;
        overflow: hidden;
        box-shadow: none !important;
    }

    .note-editor.note-frame:focus-within {
        border-color: var(--connector-primary) !important;
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .12) !important;
    }

    .note-toolbar {
        background: #f8faf9 !important;
        border-bottom: 1px solid var(--connector-border) !important;
    }

    .note-statusbar {
        background: #f8faf9 !important;
    }

    .note-editable {
        font-size: 14px !important;
        line-height: 1.75 !important;
        color: #34443c !important;
    }

    /* Side cards */
    .side-column {
        display: flex;
        flex-direction: column;
        gap: 18px;
        position: sticky;
        top: 20px;
    }

    .side-card {
        padding: 20px;
    }

    .side-card-title {
        display: flex;
        align-items: center;
        gap: 9px;
        color: var(--connector-dark);
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 18px;
    }

    .side-card-title svg {
        width: 17px;
        height: 17px;
        color: var(--connector-primary);
    }

    /* Select */
    .select-wrapper {
        position: relative;
    }

    .select-wrapper select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 38px;
    }

    .select-arrow {
        position: absolute;
        right: 13px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: var(--connector-muted);
    }

    .select-arrow svg {
        width: 15px;
        height: 15px;
    }

    /* Status */
    .status-options {
        display: grid;
        gap: 9px;
    }

    .status-option {
        position: relative;
    }

    .status-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .status-option label {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 12px;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        cursor: pointer;
        transition: .2s ease;
        font-size: 13px;
        color: var(--connector-text);
    }

    .status-option label:hover {
        border-color: var(--connector-primary);
    }

    .status-option input:checked + label {
        border-color: var(--connector-primary);
        background: var(--connector-soft);
        color: var(--connector-dark);
        font-weight: 600;
    }

    .status-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #b5c0bb;
    }

    .status-dot.pending {
        background: #d79b36;
    }

    .status-dot.approved {
        background: #48a868;
    }

    .status-dot.declined {
        background: #c94c4c;
    }

    /* Featured toggle */
    .featured-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 14px;
        background: #f8faf9;
        border: 1px solid var(--connector-border);
        border-radius: 11px;
    }

    .featured-info strong {
        display: block;
        color: var(--connector-dark);
        font-size: 13px;
        margin-bottom: 3px;
    }

    .featured-info span {
        color: var(--connector-muted);
        font-size: 11px;
        line-height: 1.4;
    }

    .switch {
        position: relative;
        width: 43px;
        height: 24px;
        flex-shrink: 0;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .switch-slider {
        position: absolute;
        inset: 0;
        cursor: pointer;
        background: #cbd5d0;
        border-radius: 30px;
        transition: .2s;
    }

    .switch-slider:before {
        content: "";
        position: absolute;
        width: 18px;
        height: 18px;
        left: 3px;
        top: 3px;
        background: #fff;
        border-radius: 50%;
        transition: .2s;
        box-shadow: 0 1px 3px rgba(0,0,0,.15);
    }

    .switch input:checked + .switch-slider {
        background: var(--connector-primary);
    }

    .switch input:checked + .switch-slider:before {
        transform: translateX(19px);
    }

    /* Upload */
    .upload-box {
        border: 1.5px dashed #cddbd5;
        border-radius: 12px;
        padding: 15px;
        background: #fafcfb;
        transition: .2s ease;
    }

    .upload-box:hover {
        border-color: var(--connector-primary);
        background: #f8fbf9;
    }

    .upload-label {
        display: flex;
        align-items: center;
        gap: 11px;
        cursor: pointer;
        margin: 0;
    }

    .upload-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .upload-icon svg {
        width: 19px;
        height: 19px;
    }

    .upload-text strong {
        display: block;
        font-size: 12px;
        color: var(--connector-dark);
        margin-bottom: 2px;
    }

    .upload-text span {
        display: block;
        color: var(--connector-muted);
        font-size: 10px;
    }

    .upload-box input {
        display: none;
    }

    .preview {
        display: none;
        margin-top: 12px;
        position: relative;
    }

    .preview img {
        width: 100%;
        max-height: 180px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--connector-border);
    }

    .preview-name {
        font-size: 10px;
        color: var(--connector-muted);
        margin-top: 6px;
        word-break: break-all;
    }

    /* Publish box */
    .publish-card {
        background: var(--connector-dark);
        border-color: var(--connector-dark);
        color: #fff;
    }

    .publish-card .side-card-title {
        color: #fff;
    }

    .publish-card .side-card-title svg {
        color: #a9c5b8;
    }

    .publish-description {
        color: rgba(255,255,255,.68);
        font-size: 12px;
        line-height: 1.6;
        margin-bottom: 18px;
    }

    .publish-button {
        width: 100%;
        border: 0;
        border-radius: 10px;
        background: #fff;
        color: var(--connector-dark);
        min-height: 45px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .publish-button:hover {
        background: var(--connector-soft);
    }

    .publish-button:disabled {
        opacity: .65;
        cursor: not-allowed;
    }

    .cancel-link {
        display: block;
        text-align: center;
        margin-top: 12px;
        color: rgba(255,255,255,.68);
        font-size: 12px;
        text-decoration: none !important;
    }

    .cancel-link:hover {
        color: #fff;
    }

    /* Image requirements */
    .requirements {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .requirements li {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        color: var(--connector-muted);
        font-size: 11px;
        line-height: 1.5;
        margin-bottom: 9px;
    }

    .requirements li:last-child {
        margin-bottom: 0;
    }

    .check-icon {
        color: var(--connector-primary);
        flex-shrink: 0;
        margin-top: 1px;
    }

    .check-icon svg {
        width: 13px;
        height: 13px;
    }

    /* Footer */
    .form-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 18px 24px;
        background: #fafcfb;
        border-top: 1px solid var(--connector-border);
    }

    .footer-note {
        color: var(--connector-muted);
        font-size: 11px;
    }

    .footer-actions {
        display: flex;
        gap: 9px;
    }

    .btn-secondary-modern {
        border: 1px solid var(--connector-border);
        background: #fff;
        color: var(--connector-dark);
        border-radius: 9px;
        padding: 10px 16px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none !important;
    }

    .btn-secondary-modern:hover {
        border-color: var(--connector-primary);
        color: var(--connector-primary);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .create-grid {
            grid-template-columns: 1fr;
        }

        .side-column {
            position: static;
        }
    }

    @media (max-width: 767px) {
        .page-header {
            align-items: flex-start;
        }

        .page-title {
            font-size: 21px;
        }

        .back-button {
            padding: 9px 11px;
        }

        .back-button span {
            display: none;
        }

        .form-row-modern {
            grid-template-columns: 1fr;
        }

        .card-section {
            padding: 18px;
        }

        .form-footer {
            padding: 16px 18px;
            flex-direction: column;
            align-items: stretch;
        }

        .footer-actions {
            width: 100%;
        }

        .footer-actions a,
        .footer-actions button {
            flex: 1;
            text-align: center;
        }
    }
</style>

<div class="container-fluid blog-create-page">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-left">

            <div class="page-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16v16H4z"/>
                    <path d="M8 8h8"/>
                    <path d="M8 12h8"/>
                    <path d="M8 16h5"/>
                </svg>
            </div>

            <div>
                <h1 class="page-title">Create Blog Article</h1>
                <p class="page-subtitle">
                    Write, organize and publish a new article on Connector.
                </p>
            </div>

        </div>

        <a href="{{ route('admin.blogs') }}" class="back-button">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5"/>
                <path d="M12 19l-7-7 7-7"/>
            </svg>
            <span>Back to blogs</span>
        </a>
    </div>

    {{-- Flash message --}}
    @if(Session::has('message'))
        <div class="alert-modern alert-success-modern">
            {{ Session::get('message') }}
        </div>
    @endif

    {{-- Validation summary --}}
    @if($errors->any())
        <div class="alert-modern alert-danger-modern">
            <strong>Please review the form.</strong>
            <ul style="margin:7px 0 0 18px; padding:0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.blog_create') }}"
          method="POST"
          enctype="multipart/form-data"
          id="blogCreateForm">

        @csrf

        <div class="create-grid">

            {{-- =====================================================
                 MAIN CONTENT
            ====================================================== --}}
            <div class="content-card">

                {{-- Article Information --}}
                <div class="card-section">

                    <div class="section-heading">
                        <div class="section-number">01</div>
                        <div>
                            <h3>Article information</h3>
                            <p>Define the title and classification of your article.</p>
                        </div>
                    </div>

                    {{-- Title --}}
                    <div class="form-group">
                        <label for="title" class="form-label-modern">
                            Article title <span class="required">*</span>
                        </label>

                        <div class="title-wrapper">
                            <input
                                type="text"
                                class="form-control-modern"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                maxlength="120"
                                placeholder="Enter a clear and engaging article title"
                                required
                            >

                            <span class="title-counter">
                                <span id="titleCount">0</span>/120
                            </span>
                        </div>

                        <div class="field-help">
                            Keep your title concise and descriptive.
                        </div>

                        @error('title')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row-modern">

                        {{-- Category --}}
                        <div class="form-group mb-0">
                            <label for="blog_category" class="form-label-modern">
                                Category <span class="required">*</span>
                            </label>

                            <div class="select-wrapper">
                                <select
                                    class="select-modern"
                                    id="blog_category"
                                    name="blog_category"
                                    required
                                >
                                    <option value="">Select category</option>

                                    @foreach($categories as $category)
                                        <option
                                            value="{{ $category->name }}"
                                            {{ old('blog_category') == $category->name ? 'selected' : '' }}
                                        >
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <span class="select-arrow">
                                    <svg viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor"
                                         stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <path d="m6 9 6 6 6-6"/>
                                    </svg>
                                </span>
                            </div>

                            @error('blog_category')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Sub Category --}}
                        <div class="form-group mb-0">
                            <label for="sub_category" class="form-label-modern">
                                Sub category
                            </label>

                            <div class="select-wrapper">
                                <select
                                    class="select-modern"
                                    id="sub_category"
                                    name="sub_category"
                                >
                                    <option value="">Select sub category</option>

                                    @foreach($subcategory as $category)
                                        <option
                                            value="{{ $category->name }}"
                                            {{ old('sub_category') == $category->name ? 'selected' : '' }}
                                        >
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <span class="select-arrow">
                                    <svg viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor"
                                         stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <path d="m6 9 6 6 6-6"/>
                                    </svg>
                                </span>
                            </div>

                            @error('sub_category')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                </div>

                {{-- Article Content --}}
                <div class="card-section">

                    <div class="section-heading">
                        <div class="section-number">02</div>
                        <div>
                            <h3>Article content</h3>
                            <p>Write the main content that readers will see.</p>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label for="content" class="form-label-modern">
                            Content <span class="required">*</span>
                        </label>

                        <textarea
                            class="form-control"
                            id="content"
                            name="content"
                        >{{ old('content') }}</textarea>

                        @error('content')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Footer --}}
                <div class="form-footer">

                    <div class="footer-note">
                        Fields marked with <span class="required">*</span> are required.
                    </div>

                    <div class="footer-actions">

                        <a href="{{ route('admin.blogs') }}"
                           class="btn-secondary-modern">
                            Cancel
                        </a>

                        <button type="submit"
                                class="publish-button"
                                id="desktopSubmit"
                                style="width:auto; padding:0 22px;">
                            Create article
                        </button>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 SIDEBAR
            ====================================================== --}}
            <div class="side-column">

                {{-- Publishing --}}
                <div class="side-card publish-card">

                    <div class="side-card-title">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <path d="M12 3v12"/>
                            <path d="m7 8 5-5 5 5"/>
                            <path d="M5 12v7h14v-7"/>
                        </svg>

                        Publishing
                    </div>

                    <div class="publish-description">
                        Choose how this article should appear on the platform.
                    </div>

                    <div class="status-options">

                        <div class="status-option">
                            <input
                                type="radio"
                                name="status"
                                id="status_pending"
                                value="pending"
                                {{ old('status', 'pending') === 'pending' ? 'checked' : '' }}
                            >

                            <label for="status_pending">
                                <span class="status-dot pending"></span>
                                Pending review
                            </label>
                        </div>

                        <div class="status-option">
                            <input
                                type="radio"
                                name="status"
                                id="status_approved"
                                value="approved"
                                {{ old('status') === 'approved' ? 'checked' : '' }}
                            >

                            <label for="status_approved">
                                <span class="status-dot approved"></span>
                                Approved
                            </label>
                        </div>

                        <div class="status-option">
                            <input
                                type="radio"
                                name="status"
                                id="status_declined"
                                value="declined"
                                {{ old('status') === 'declined' ? 'checked' : '' }}
                            >

                            <label for="status_declined">
                                <span class="status-dot declined"></span>
                                Declined
                            </label>
                        </div>

                    </div>

                    <div style="margin-top:17px;">

                        <div class="featured-box"
                             style="background:rgba(255,255,255,.07); border-color:rgba(255,255,255,.12);">

                            <div class="featured-info">
                                <strong style="color:#fff;">Featured article</strong>
                                <span style="color:rgba(255,255,255,.58);">
                                    Highlight this article on the platform.
                                </span>
                            </div>

                            <label class="switch">
                                <input
                                    type="checkbox"
                                    name="featured"
                                    value="1"
                                    id="featured"
                                    {{ old('featured', 0) ? 'checked' : '' }}
                                >
                                <span class="switch-slider"></span>
                            </label>

                        </div>

                        {{-- Important for unchecked checkbox --}}
                        <input type="hidden" name="featured" value="0">

                    </div>

                </div>


                {{-- Featured note --}}
                <div class="side-card">

                    <div class="side-card-title">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3z"/>
                        </svg>

                        Featured content
                    </div>

                    <div class="field-help" style="margin-top:-8px; line-height:1.6;">
                        Featured articles can receive additional visibility across
                        Connector's content areas.
                    </div>

                </div>


                {{-- Main Image --}}
                <div class="side-card">

                    <div class="side-card-title">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="m21 15-5-5L5 21"/>
                        </svg>

                        Article image
                    </div>

                    <div class="upload-box">

                        <label for="image" class="upload-label">

                            <div class="upload-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="M12 16V4"/>
                                    <path d="m7 9 5-5 5 5"/>
                                    <path d="M4 20h16"/>
                                </svg>
                            </div>

                            <div class="upload-text">
                                <strong>Upload article image</strong>
                                <span>JPG, JPEG or PNG</span>
                            </div>

                        </label>

                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept="image/jpeg,image/png,image/jpg"
                            required
                        >

                        <div id="imagePreview" class="preview">
                            <img src="" alt="Article image preview">
                            <div class="preview-name" id="imageName"></div>
                        </div>

                    </div>

                    @error('image')
                        <div class="field-error">{{ $message }}</div>
                    @enderror

                </div>


                {{-- Thumbnail --}}
                <div class="side-card">

                    <div class="side-card-title">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <path d="m3 16 5-5 4 4 3-3 6 6"/>
                        </svg>

                        Thumbnail
                    </div>

                    <div class="upload-box">

                        <label for="thumbnail" class="upload-label">

                            <div class="upload-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                                    <circle cx="8.5" cy="9" r="1.5"/>
                                    <path d="m21 15-5-5L5 19"/>
                                </svg>
                            </div>

                            <div class="upload-text">
                                <strong>Upload thumbnail</strong>
                                <span>JPG, JPEG or PNG</span>
                            </div>

                        </label>

                        <input
                            type="file"
                            id="thumbnail"
                            name="thumbnail"
                            accept="image/jpeg,image/png,image/jpg"
                            required
                        >

                        <div id="thumbnailPreview" class="preview">
                            <img src="" alt="Thumbnail preview">
                            <div class="preview-name" id="thumbnailName"></div>
                        </div>

                    </div>

                    @error('thumbnail')
                        <div class="field-error">{{ $message }}</div>
                    @enderror

                </div>


                {{-- Requirements --}}
                <div class="side-card">

                    <div class="side-card-title">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="m9 12 2 2 4-4"/>
                        </svg>

                        Content checklist
                    </div>

                    <ul class="requirements">

                        <li>
                            <span class="check-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="m5 12 4 4L19 6"/>
                                </svg>
                            </span>
                            Use a clear and descriptive title.
                        </li>

                        <li>
                            <span class="check-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="m5 12 4 4L19 6"/>
                                </svg>
                            </span>
                            Select the appropriate category.
                        </li>

                        <li>
                            <span class="check-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="m5 12 4 4L19 6"/>
                                </svg>
                            </span>
                            Add meaningful article content.
                        </li>

                        <li>
                            <span class="check-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="m5 12 4 4L19 6"/>
                                </svg>
                            </span>
                            Upload both required images.
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </form>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

<script>
    $(document).ready(function () {

        /* =========================================================
           SUMMERNOTE
        ========================================================== */

        $('#content').summernote({
            height: 400,
            minHeight: 300,
            maxHeight: 700,
            placeholder: 'Start writing your article...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });


        /* =========================================================
           TITLE COUNTER
        ========================================================== */

        const title = document.getElementById('title');
        const titleCount = document.getElementById('titleCount');

        function updateTitleCount() {
            titleCount.textContent = title.value.length;
        }

        title.addEventListener('input', updateTitleCount);

        updateTitleCount();


        /* =========================================================
           IMAGE PREVIEW
        ========================================================== */

        function setupImagePreview(inputId, previewId, nameId) {

            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const previewImage = preview.querySelector('img');
            const name = document.getElementById(nameId);

            input.addEventListener('change', function () {

                const file = this.files[0];

                if (!file) {
                    preview.style.display = 'none';
                    previewImage.src = '';
                    name.textContent = '';
                    return;
                }

                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    this.value = '';
                    preview.style.display = 'none';
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (event) {
                    previewImage.src = event.target.result;
                    name.textContent = file.name;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(file);
            });
        }

        setupImagePreview(
            'image',
            'imagePreview',
            'imageName'
        );

        setupImagePreview(
            'thumbnail',
            'thumbnailPreview',
            'thumbnailName'
        );


        /* =========================================================
           FORM SUBMIT PROTECTION
        ========================================================== */

        $('#blogCreateForm').on('submit', function () {

            const submitButtons = $(this).find('button[type="submit"]');

            submitButtons.prop('disabled', true);

            submitButtons.each(function () {
                $(this).text('Creating article...');
            });

        });


        /* =========================================================
           CHECKBOX / HIDDEN FIELD HANDLING
        ========================================================== */

        $('#featured').on('change', function () {

            /*
             * The checkbox and hidden input intentionally use the same
             * field name. Laravel receives the checked checkbox value
             * when enabled and 0 when disabled.
             */

        });

    });
</script>

@endsection