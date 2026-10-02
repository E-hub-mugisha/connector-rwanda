@extends('layouts.app')

@section('title', 'Edit Blog')

@section('content')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css">

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-dark: #254035;
        --connector-soft: #eef5f2;
        --connector-border: #e4ebe8;
        --connector-text: #26352e;
        --connector-muted: #7b8983;
        --connector-success: #3f9560;
        --connector-warning: #c58b2a;
        --connector-danger: #c94c4c;
    }

    .blog-edit-page {
        padding: 10px 0 45px;
        color: var(--connector-text);
    }

    /* Header */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 13px;
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
        color: var(--connector-dark);
        font-size: 24px;
        font-weight: 700;
        letter-spacing: -.3px;
    }

    .page-subtitle {
        margin: 4px 0 0;
        color: var(--connector-muted);
        font-size: 13px;
    }

    .header-actions {
        display: flex;
        gap: 9px;
    }

    .btn-outline-modern,
    .btn-primary-modern {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 40px;
        padding: 9px 14px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 650;
        text-decoration: none !important;
        transition: .2s ease;
    }

    .btn-outline-modern {
        background: #fff;
        border: 1px solid var(--connector-border);
        color: var(--connector-dark);
    }

    .btn-outline-modern:hover {
        border-color: var(--connector-primary);
        color: var(--connector-primary);
        background: var(--connector-soft);
    }

    .btn-primary-modern {
        background: var(--connector-dark);
        border: 1px solid var(--connector-dark);
        color: #fff;
    }

    .btn-primary-modern:hover {
        background: var(--connector-primary);
        border-color: var(--connector-primary);
        color: #fff;
    }

    .btn-outline-modern svg,
    .btn-primary-modern svg {
        width: 15px;
        height: 15px;
    }

    /* Alerts */
    .alert-modern {
        border: 0;
        border-radius: 11px;
        padding: 13px 15px;
        margin-bottom: 20px;
        font-size: 13px;
    }

    .alert-success-modern {
        background: #edf8f1;
        color: #28734d;
    }

    .alert-danger-modern {
        background: #fff0f0;
        color: #a53e3e;
    }

    /* Main */
    .edit-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 330px;
        gap: 22px;
        align-items: start;
    }

    .main-column {
        min-width: 0;
    }

    .side-column {
        position: sticky;
        top: 20px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    /* Cards */
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

    .side-card {
        padding: 20px;
    }

    /* Section heading */
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

    .title-wrapper {
        position: relative;
    }

    .title-counter {
        position: absolute;
        right: 12px;
        bottom: 9px;
        font-size: 11px;
        color: var(--connector-muted);
        background: #fff;
        padding-left: 5px;
        pointer-events: none;
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

    .form-row-modern {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
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
        color: #34443c !important;
        font-size: 14px !important;
        line-height: 1.75 !important;
    }

    /* Side titles */
    .side-title {
        display: flex;
        align-items: center;
        gap: 9px;
        color: var(--connector-dark);
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 17px;
    }

    .side-title svg {
        width: 17px;
        height: 17px;
        color: var(--connector-primary);
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

    /* Featured */
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

    /* Image */
    .current-image {
        margin-bottom: 13px;
    }

    .current-image-label {
        color: var(--connector-muted);
        font-size: 10px;
        margin-bottom: 7px;
    }

    .current-image img {
        display: block;
        width: 100%;
        height: 155px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--connector-border);
    }

    .image-placeholder {
        width: 100%;
        height: 155px;
        border-radius: 10px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-placeholder svg {
        width: 38px;
        height: 38px;
    }

    .upload-box {
        border: 1.5px dashed #cddbd5;
        border-radius: 12px;
        padding: 14px;
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
        gap: 10px;
        cursor: pointer;
        margin: 0;
    }

    .upload-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .upload-icon svg {
        width: 18px;
        height: 18px;
    }

    .upload-text strong {
        display: block;
        font-size: 11px;
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

    .new-preview {
        display: none;
        margin-top: 12px;
    }

    .new-preview img {
        display: block;
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: 9px;
        border: 1px solid var(--connector-border);
    }

    .preview-name {
        color: var(--connector-muted);
        font-size: 10px;
        margin-top: 5px;
        word-break: break-all;
    }

    /* Publishing card */
    .publish-card {
        background: var(--connector-dark);
        border-color: var(--connector-dark);
        color: #fff;
    }

    .publish-card .side-title {
        color: #fff;
    }

    .publish-card .side-title svg {
        color: #a9c5b8;
    }

    .publish-description {
        color: rgba(255,255,255,.68);
        font-size: 12px;
        line-height: 1.6;
        margin-bottom: 17px;
    }

    /* Article info */
    .info-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #edf1ef;
    }

    .info-item:first-child {
        padding-top: 0;
    }

    .info-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .info-label {
        color: var(--connector-muted);
        font-size: 11px;
    }

    .info-value {
        color: var(--connector-dark);
        font-size: 11px;
        font-weight: 650;
        text-align: right;
    }

    /* Form footer */
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

    .save-button {
        min-height: 40px;
        padding: 9px 17px;
        border: 0;
        border-radius: 9px;
        background: var(--connector-dark);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .save-button:hover {
        background: var(--connector-primary);
    }

    .save-button:disabled {
        opacity: .65;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .edit-grid {
            grid-template-columns: 1fr;
        }

        .side-column {
            position: static;
        }
    }

    @media (max-width: 767px) {
        .page-title {
            font-size: 20px;
        }

        .header-actions .btn-primary-modern span {
            display: none;
        }

        .form-row-modern {
            grid-template-columns: 1fr;
        }

        .card-section {
            padding: 18px;
        }

        .article-title {
            font-size: 23px;
        }

        .form-footer {
            padding: 16px 18px;
            flex-direction: column;
            align-items: stretch;
        }

        .footer-actions {
            width: 100%;
        }

        .footer-actions > * {
            flex: 1;
            text-align: center;
        }
    }
</style>


<div class="container-fluid blog-edit-page">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}
    <div class="page-header">

        <div class="page-header-left">

            <div class="page-icon">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                </svg>
            </div>

            <div>
                <h1 class="page-title">Edit Blog Article</h1>
                <p class="page-subtitle">
                    Update the content, classification and publishing settings.
                </p>
            </div>

        </div>

        <div class="header-actions">

            <a href="{{ route('admin.blogs') }}"
               class="btn-outline-modern">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M19 12H5"/>
                    <path d="m12 19-7-7 7-7"/>
                </svg>

                <span>Back to blogs</span>

            </a>

            <a href="{{ route('admin.blog_detail', $blog->slug) }}"
               class="btn-primary-modern">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>

                <span>View article</span>

            </a>

        </div>

    </div>


    {{-- =========================================================
         FLASH MESSAGE
    ========================================================== --}}
    @if(Session::has('message'))

        <div class="alert-modern alert-success-modern">
            {{ Session::get('message') }}
        </div>

    @endif


    {{-- =========================================================
         VALIDATION
    ========================================================== --}}
    @if($errors->any())

        <div class="alert-modern alert-danger-modern">

            <strong>Please review the following:</strong>

            <ul style="margin:7px 0 0 18px; padding:0;">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- =========================================================
         FORM
    ========================================================== --}}
    <form
        action="{{ route('admin.blog_update', $blog->id) }}"
        method="POST"
        enctype="multipart/form-data"
        id="blogEditForm"
    >

        @csrf
        @method('PUT')


        <div class="edit-grid">

            {{-- =================================================
                 MAIN CONTENT
            ================================================== --}}
            <div class="main-column">

                <div class="content-card">

                    {{-- Article information --}}
                    <div class="card-section">

                        <div class="section-heading">

                            <div class="section-number">
                                01
                            </div>

                            <div>
                                <h3>Article information</h3>
                                <p>
                                    Update the article title and classification.
                                </p>
                            </div>

                        </div>


                        {{-- Title --}}
                        <div class="form-group">

                            <label for="title" class="form-label-modern">
                                Article title
                                <span class="required">*</span>
                            </label>

                            <div class="title-wrapper">

                                <input
                                    type="text"
                                    class="form-control-modern"
                                    id="title"
                                    name="title"
                                    value="{{ old('title', $blog->title) }}"
                                    maxlength="120"
                                    required
                                >

                                <span class="title-counter">
                                    <span id="titleCount">
                                        {{ strlen(old('title', $blog->title)) }}
                                    </span>/120
                                </span>

                            </div>

                            @error('title')
                                <div class="field-error">{{ $message }}</div>
                            @enderror

                        </div>


                        {{-- Category --}}
                        <div class="form-row-modern">

                            <div class="form-group mb-0">

                                <label
                                    for="service_category_id"
                                    class="form-label-modern"
                                >
                                    Category
                                    <span class="required">*</span>
                                </label>

                                <div class="select-wrapper">

                                    <select
                                        class="select-modern"
                                        id="service_category_id"
                                        name="service_category_id"
                                        required
                                    >

                                        <option value="">
                                            Select category
                                        </option>

                                        @foreach($categories as $category)

                                            <option
                                                value="{{ $category->id }}"
                                                {{ old(
                                                    'service_category_id',
                                                    $blog->service_category_id
                                                ) == $category->id ? 'selected' : '' }}
                                            >
                                                {{ $category->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                    <span class="select-arrow">
                                        <svg viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="2"
                                             stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path d="m6 9 6 6 6-6"/>
                                        </svg>
                                    </span>

                                </div>

                                @error('service_category_id')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror

                            </div>


                            {{-- Subcategory --}}
                            <div class="form-group mb-0">

                                <label
                                    for="service_sub_category_id"
                                    class="form-label-modern"
                                >
                                    Sub category
                                </label>

                                <div class="select-wrapper">

                                    <select
                                        class="select-modern"
                                        id="service_sub_category_id"
                                        name="service_sub_category_id"
                                    >

                                        <option value="">
                                            Select sub category
                                        </option>

                                        @foreach($subcategory as $sub)

                                            <option
                                                value="{{ $sub->id }}"
                                                {{ old(
                                                    'service_sub_category_id',
                                                    $blog->service_sub_category_id
                                                ) == $sub->id ? 'selected' : '' }}
                                            >
                                                {{ $sub->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                    <span class="select-arrow">
                                        <svg viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="2"
                                             stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path d="m6 9 6 6 6-6"/>
                                        </svg>
                                    </span>

                                </div>

                                @error('service_sub_category_id')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         CONTENT
                    ================================================== --}}
                    <div class="card-section">

                        <div class="section-heading">

                            <div class="section-number">
                                02
                            </div>

                            <div>
                                <h3>Article content</h3>
                                <p>
                                    Edit the content displayed to your readers.
                                </p>
                            </div>

                        </div>


                        <div class="form-group mb-0">

                            <label for="content" class="form-label-modern">
                                Content
                                <span class="required">*</span>
                            </label>

                            <textarea
                                class="form-control"
                                id="content"
                                name="content"
                            >{{ old('content', $blog->content) }}</textarea>

                            @error('content')
                                <div class="field-error">{{ $message }}</div>
                            @enderror

                        </div>

                    </div>


                    {{-- =================================================
                         FOOTER
                    ================================================== --}}
                    <div class="form-footer">

                        <div class="footer-note">
                            Last updated:
                            {{ optional($blog->updated_at)->format('M d, Y H:i') }}
                        </div>

                        <div class="footer-actions">

                            <a
                                href="{{ route('admin.blogs') }}"
                                class="btn-outline-modern"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="save-button"
                                id="saveButton"
                            >
                                Save changes
                            </button>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 SIDEBAR
            ================================================== --}}
            <div class="side-column">


                {{-- =============================================
                     PUBLISHING
                ============================================== --}}
                <div class="side-card publish-card">

                    <div class="side-title">

                        <svg viewBox="0 0 24 24"
                             fill="none"
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
                        Control the current publication status of this article.
                    </div>


                    <div class="status-options">

                        <div class="status-option">

                            <input
                                type="radio"
                                name="status"
                                id="status_pending"
                                value="pending"
                                {{ old('status', $blog->status) === 'pending' ? 'checked' : '' }}
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
                                {{ old('status', $blog->status) === 'approved' ? 'checked' : '' }}
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
                                {{ old('status', $blog->status) === 'declined' ? 'checked' : '' }}
                            >

                            <label for="status_declined">

                                <span class="status-dot declined"></span>

                                Declined

                            </label>

                        </div>

                    </div>

                </div>


                {{-- =============================================
                     FEATURED
                ============================================== --}}
                <div class="side-card">

                    <div class="side-title">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3z"/>
                        </svg>

                        Visibility

                    </div>


                    <div class="featured-box">

                        <div class="featured-info">

                            <strong>
                                Featured article
                            </strong>

                            <span>
                                Highlight this article across Connector.
                            </span>

                        </div>


                        <label class="switch">

                            <input
                                type="checkbox"
                                name="featured"
                                value="1"
                                id="featured"
                                {{ old('featured', $blog->featured) ? 'checked' : '' }}
                            >

                            <span class="switch-slider"></span>

                        </label>

                    </div>

                    {{-- Value sent when switch is OFF --}}
                    <input
                        type="hidden"
                        name="featured"
                        value="0"
                    >

                </div>


                {{-- =============================================
                     CURRENT IMAGE
                ============================================== --}}
                <div class="side-card">

                    <div class="side-title">

                        <svg viewBox="0 0 24 24"
                             fill="none"
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


                    <div class="current-image">

                        <div class="current-image-label">
                            Current image
                        </div>

                        @if(!empty($blog->image))

                            <div class="current-image">

                                <img
                                    src="{{ asset('image/blog/' . $blog->image) }}"
                                    alt="{{ $blog->title }}"
                                >

                            </div>

                        @else

                            <div class="image-placeholder">

                                <svg viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.5"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <path d="m21 15-5-5L5 21"/>
                                </svg>

                            </div>

                        @endif

                    </div>


                    <div class="upload-box">

                        <label
                            for="image"
                            class="upload-label"
                        >

                            <div class="upload-icon">

                                <svg viewBox="0 0 24 24"
                                     fill="none"
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

                                <strong>
                                    Replace image
                                </strong>

                                <span>
                                    JPG, JPEG or PNG
                                </span>

                            </div>

                        </label>

                        <input
                            type="file"
                            name="image"
                            id="image"
                            accept="image/jpeg,image/png,image/jpg"
                        >

                        <div
                            class="new-preview"
                            id="imagePreview"
                        >

                            <img src="" alt="New image preview">

                            <div
                                class="preview-name"
                                id="imageName"
                            ></div>

                        </div>

                    </div>

                    @error('image')
                        <div class="field-error">{{ $message }}</div>
                    @enderror

                </div>


                {{-- =============================================
                     THUMBNAIL
                ============================================== --}}
                <div class="side-card">

                    <div class="side-title">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                            <circle cx="8.5" cy="9" r="1.5"/>
                            <path d="m21 15-5-5L5 19"/>
                        </svg>

                        Thumbnail

                    </div>


                    @if(!empty($blog->thumbnail))

                        <div class="current-image">

                            <div class="current-image-label">
                                Current thumbnail
                            </div>

                            <img
                                src="{{ asset('thumbnail/blog/' . $blog->thumbnail) }}"
                                alt="{{ $blog->title }} thumbnail"
                                style="display:block;width:100%;height:140px;object-fit:cover;border-radius:10px;border:1px solid var(--connector-border);"
                            >

                        </div>

                    @endif


                    <div class="upload-box">

                        <label
                            for="thumbnail"
                            class="upload-label"
                        >

                            <div class="upload-icon">

                                <svg viewBox="0 0 24 24"
                                     fill="none"
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

                                <strong>
                                    Replace thumbnail
                                </strong>

                                <span>
                                    JPG, JPEG or PNG
                                </span>

                            </div>

                        </label>

                        <input
                            type="file"
                            name="thumbnail"
                            id="thumbnail"
                            accept="image/jpeg,image/png,image/jpg"
                        >

                        <div
                            class="new-preview"
                            id="thumbnailPreview"
                        >

                            <img src="" alt="New thumbnail preview">

                            <div
                                class="preview-name"
                                id="thumbnailName"
                            ></div>

                        </div>

                    </div>

                    @error('thumbnail')
                        <div class="field-error">{{ $message }}</div>
                    @enderror

                </div>


                {{-- =============================================
                     ARTICLE INFORMATION
                ============================================== --}}
                <div class="side-card">

                    <div class="side-title">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 11v5"/>
                            <path d="M12 8h.01"/>
                        </svg>

                        Article information

                    </div>


                    <ul class="info-list">

                        <li class="info-item">

                            <span class="info-label">
                                Article ID
                            </span>

                            <span class="info-value">
                                #{{ $blog->id }}
                            </span>

                        </li>


                        <li class="info-item">

                            <span class="info-label">
                                Views
                            </span>

                            <span class="info-value">
                                {{ number_format((int)($blog->views ?? 0)) }}
                            </span>

                        </li>


                        <li class="info-item">

                            <span class="info-label">
                                Created
                            </span>

                            <span class="info-value">
                                {{ optional($blog->created_at)->format('M d, Y') }}
                            </span>

                        </li>


                        <li class="info-item">

                            <span class="info-label">
                                Slug
                            </span>

                            <span class="info-value">
                                {{ $blog->slug }}
                            </span>

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
            placeholder: 'Write your article content...',
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

            if (!title || !titleCount) {
                return;
            }

            titleCount.textContent = title.value.length;
        }

        if (title) {
            title.addEventListener('input', updateTitleCount);
            updateTitleCount();
        }


        /* =========================================================
           IMAGE PREVIEW
        ========================================================== */

        function setupPreview(inputId, previewId, nameId) {

            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const previewImage = preview
                ? preview.querySelector('img')
                : null;
            const previewName = document.getElementById(nameId);

            if (!input || !preview || !previewImage) {
                return;
            }

            input.addEventListener('change', function () {

                const file = this.files[0];

                if (!file) {
                    preview.style.display = 'none';
                    previewImage.src = '';

                    if (previewName) {
                        previewName.textContent = '';
                    }

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

                    if (previewName) {
                        previewName.textContent = file.name;
                    }

                    preview.style.display = 'block';
                };

                reader.readAsDataURL(file);

            });
        }


        setupPreview(
            'image',
            'imagePreview',
            'imageName'
        );

        setupPreview(
            'thumbnail',
            'thumbnailPreview',
            'thumbnailName'
        );


        /* =========================================================
           FORM SUBMIT
        ========================================================== */

        $('#blogEditForm').on('submit', function () {

            const button = document.getElementById('saveButton');

            if (button) {

                button.disabled = true;
                button.textContent = 'Saving changes...';

            }

        });

    });
</script>

@endsection