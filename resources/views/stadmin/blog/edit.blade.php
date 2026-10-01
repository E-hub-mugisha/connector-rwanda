@extends('layouts.app')

@section('title', 'Edit Blog')

@push('styles')

    {{-- Quill Rich Text Editor --}}
    <link
        href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css"
        rel="stylesheet"
    >

    <style>
        :root {
            --connector-primary: #254035;
            --connector-secondary: #6B9080;
            --connector-light: #f3f7f5;
            --connector-border: #e2ebe6;
            --connector-text: #24342d;
            --connector-muted: #718078;
        }

        /* =========================================================
           PAGE
        ========================================================= */

        .blog-edit-page {
            background: #f7f9f8;
            min-height: calc(100vh - 70px);
            padding: 30px 0 60px;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .blog-header {
            background: linear-gradient(
                135deg,
                var(--connector-primary),
                #355b4b
            );
            border-radius: 18px;
            padding: 28px 30px;
            margin-bottom: 25px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .blog-header::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
            right: -90px;
            top: -130px;
        }

        .blog-header::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
            left: 45%;
            bottom: -100px;
        }

        .blog-header-content {
            position: relative;
            z-index: 2;
        }

        .header-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            background: rgba(255,255,255,.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .blog-header h1 {
            font-size: 25px;
            font-weight: 700;
            margin: 0 0 5px;
        }

        .blog-header p {
            margin: 0;
            font-size: 13px;
            color: rgba(255,255,255,.74);
        }

        /* =========================================================
           CARDS
        ========================================================= */

        .edit-card,
        .side-card {
            background: #fff;
            border: 1px solid var(--connector-border);
            border-radius: 17px;
            box-shadow: 0 6px 25px rgba(37,64,53,.05);
            overflow: hidden;
        }

        .edit-section {
            padding: 25px;
            border-bottom: 1px solid #edf1ef;
        }

        .edit-section:last-child {
            border-bottom: 0;
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 22px;
        }

        .section-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--connector-light);
            color: var(--connector-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-heading h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--connector-text);
        }

        .section-heading small {
            display: block;
            color: var(--connector-muted);
            font-size: 12px;
            margin-top: 2px;
        }

        /* =========================================================
           FORM
        ========================================================= */

        .form-label {
            color: var(--connector-text);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .required {
            color: #dc3545;
        }

        .form-control,
        .form-select {
            min-height: 47px;
            border: 1px solid #dce5e0;
            border-radius: 10px;
            color: var(--connector-text);
            font-size: 14px;
            box-shadow: none !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--connector-secondary);
            box-shadow: 0 0 0 3px rgba(107,144,128,.12) !important;
        }

        .field-help {
            color: var(--connector-muted);
            font-size: 12px;
            margin-top: 6px;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 6px;
        }

        /* =========================================================
           QUILL
        ========================================================= */

        .editor-wrapper {
            border: 1px solid #dce5e0;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }

        .editor-wrapper:focus-within {
            border-color: var(--connector-secondary);
            box-shadow: 0 0 0 3px rgba(107,144,128,.12);
        }

        #blog-editor {
            min-height: 330px;
        }

        .ql-toolbar.ql-snow {
            border: 0;
            border-bottom: 1px solid #e9efec;
            background: #f8faf9;
            padding: 11px;
        }

        .ql-container.ql-snow {
            border: 0;
            min-height: 280px;
            font-family: inherit;
            font-size: 15px;
        }

        .ql-editor {
            min-height: 280px;
            line-height: 1.75;
            color: var(--connector-text);
        }

        .ql-editor.ql-blank::before {
            color: #a4aea9;
            font-style: normal;
            left: 18px;
        }

        .ql-snow .ql-stroke {
            stroke: var(--connector-text);
        }

        .ql-snow .ql-fill {
            fill: var(--connector-text);
        }

        /* =========================================================
           IMAGE
        ========================================================= */

        .image-upload-box {
            border: 1.5px dashed #ccd9d3;
            border-radius: 13px;
            padding: 20px;
            background: #fbfcfb;
        }

        .image-upload-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: var(--connector-light);
            color: var(--connector-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            font-size: 18px;
        }

        .current-image {
            margin-top: 15px;
        }

        .current-image-label {
            font-size: 11px;
            color: var(--connector-muted);
            font-weight: 600;
            margin-bottom: 7px;
        }

        .current-image img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 11px;
            border: 1px solid var(--connector-border);
            background: #f4f7f5;
        }

        .new-preview {
            display: none;
            margin-top: 15px;
        }

        .new-preview img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 11px;
            border: 1px solid var(--connector-border);
        }

        .file-name {
            font-size: 12px;
            color: var(--connector-muted);
            margin-top: 8px;
            word-break: break-word;
        }

        /* =========================================================
           SIDEBAR
        ========================================================= */

        .side-card {
            margin-bottom: 20px;
        }

        .side-card-header {
            padding: 17px 20px;
            border-bottom: 1px solid #edf1ef;
        }

        .side-card-header h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: var(--connector-text);
        }

        .side-card-body {
            padding: 20px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            margin-bottom: 17px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-icon {
            width: 35px;
            height: 35px;
            border-radius: 9px;
            background: var(--connector-light);
            color: var(--connector-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-label {
            color: var(--connector-muted);
            font-size: 11px;
            margin-bottom: 2px;
        }

        .info-value {
            color: var(--connector-text);
            font-size: 13px;
            font-weight: 600;
        }

        /* =========================================================
           STATUS
        ========================================================= */

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 30px;
            padding: 6px 11px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-published {
            background: #eaf7ef;
            color: #207344;
        }

        .status-pending {
            background: #fff6df;
            color: #9a7012;
        }

        .status-rejected {
            background: #fdeeee;
            color: #a53d3d;
        }

        /* =========================================================
           BUTTONS
        ========================================================= */

        .btn-connector {
            min-height: 46px;
            border: 0;
            border-radius: 10px;
            background: var(--connector-primary);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            padding: 0 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: .2s ease;
        }

        .btn-connector:hover {
            background: #1c3229;
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-outline-connector {
            min-height: 46px;
            border: 1px solid #cedad4;
            border-radius: 10px;
            background: #fff;
            color: var(--connector-primary);
            font-size: 13px;
            font-weight: 600;
            padding: 0 19px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .btn-outline-connector:hover {
            background: var(--connector-light);
            border-color: var(--connector-secondary);
            color: var(--connector-primary);
        }

        /* =========================================================
           ALERT
        ========================================================= */

        .alert-modern {
            border: 0;
            border-radius: 11px;
            font-size: 13px;
        }

        .alert-modern ul {
            margin-bottom: 0;
            padding-left: 18px;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 991.98px) {

            .blog-edit-page {
                padding: 20px 0 40px;
            }

            .blog-header {
                padding: 22px;
            }

            .edit-section {
                padding: 20px;
            }

        }

        @media (max-width: 575.98px) {

            .blog-header h1 {
                font-size: 21px;
            }

            .edit-section {
                padding: 18px;
            }

            .article-actions {
                flex-direction: column;
            }

            .article-actions .btn {
                width: 100%;
            }

        }
    </style>

@endpush


@section('content')

<div class="blog-edit-page">

    <div class="container-fluid px-3 px-lg-4">

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="blog-header">

            <div class="blog-header-content">

                <div class="d-flex align-items-center gap-3">

                    <div class="header-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>

                    <div>

                        <h1>Edit Blog</h1>

                        <p>
                            Update your article, category, content and images.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             ALERTS
        ====================================================== --}}

        @if (Session::has('message'))

            <div class="alert alert-success alert-modern mb-4">

                <i class="bi bi-check-circle me-2"></i>

                {{ Session::get('message') }}

            </div>

        @endif


        @if (Session::has('success'))

            <div class="alert alert-success alert-modern mb-4">

                <i class="bi bi-check-circle me-2"></i>

                {{ Session::get('success') }}

            </div>

        @endif


        @if (Session::has('error'))

            <div class="alert alert-danger alert-modern mb-4">

                <i class="bi bi-exclamation-circle me-2"></i>

                {{ Session::get('error') }}

            </div>

        @endif


        @if ($errors->any())

            <div class="alert alert-danger alert-modern mb-4">

                <div class="d-flex gap-2">

                    <i class="bi bi-exclamation-triangle-fill mt-1"></i>

                    <div>

                        <strong>
                            Please correct the following:
                        </strong>

                        <ul class="mt-2">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- =====================================================
             OLD VALUES
        ====================================================== --}}

        @php

            $selectedCategory =
                old(
                    'service_category_id',
                    $blog->service_category_id
                );

            $selectedSubcategory =
                old(
                    'service_sub_category_id',
                    $blog->service_sub_category_id
                );

            $subcategoriesJson = collect($subcategory ?? [])
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'category_id' => $item->service_category_id,
                    ];
                })
                ->values()
                ->toArray();

        @endphp


        {{-- =====================================================
             FORM
        ====================================================== --}}

        <form
            action="{{ route('serviceProviderBlog.blogUpdate', $blog->id) }}"
            method="POST"
            enctype="multipart/form-data"
            id="editBlogForm"
        >

            @csrf

            @method('PUT')


            <div class="row g-4">


                {{-- =================================================
                     MAIN COLUMN
                ================================================== --}}

                <div class="col-xl-8 col-lg-8">

                    <div class="edit-card">


                        {{-- =================================================
                             BLOG INFORMATION
                        ================================================== --}}

                        <div class="edit-section">

                            <div class="section-heading">

                                <div class="section-icon">
                                    <i class="bi bi-file-text"></i>
                                </div>

                                <div>

                                    <h5>
                                        Blog Information
                                    </h5>

                                    <small>
                                        Update the basic information of your article.
                                    </small>

                                </div>

                            </div>


                            {{-- Title --}}
                            <div class="mb-4">

                                <label
                                    for="title"
                                    class="form-label"
                                >
                                    Blog Title
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $blog->title) }}"
                                    placeholder="Enter blog title"
                                    maxlength="255"
                                    required
                                >

                                @error('title')

                                    <div class="error-message">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- Category + Subcategory --}}
                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label
                                        for="service_category_id"
                                        class="form-label"
                                    >
                                        Category
                                        <span class="required">*</span>
                                    </label>

                                    <select
                                        name="service_category_id"
                                        id="service_category_id"
                                        class="form-select @error('service_category_id') is-invalid @enderror"
                                        required
                                    >

                                        <option value="">
                                            Select category
                                        </option>

                                        @foreach ($categories as $category)

                                            <option
                                                value="{{ $category->id }}"
                                                {{ (string) $selectedCategory === (string) $category->id ? 'selected' : '' }}
                                            >
                                                {{ $category->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                    @error('service_category_id')

                                        <div class="error-message">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                <div class="col-md-6">

                                    <label
                                        for="service_sub_category_id"
                                        class="form-label"
                                    >
                                        Subcategory
                                        <span class="required">*</span>
                                    </label>

                                    <select
                                        name="service_sub_category_id"
                                        id="service_sub_category_id"
                                        class="form-select @error('service_sub_category_id') is-invalid @enderror"
                                        required
                                    >

                                        <option value="">
                                            Select subcategory
                                        </option>

                                    </select>

                                    @error('service_sub_category_id')

                                        <div class="error-message">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                    <div class="field-help">
                                        Subcategories are filtered according to the selected category.
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                             CONTENT
                        ================================================== --}}

                        <div class="edit-section">

                            <div class="section-heading">

                                <div class="section-icon">
                                    <i class="bi bi-body-text"></i>
                                </div>

                                <div>

                                    <h5>
                                        Blog Content
                                    </h5>

                                    <small>
                                        Edit and format the article content.
                                    </small>

                                </div>

                            </div>


                            <label class="form-label">

                                Content

                                <span class="required">*</span>

                            </label>


                            <div class="editor-wrapper">

                                <div id="blog-editor"></div>

                            </div>


                            {{-- Hidden Laravel field --}}
                            <textarea
                                name="content"
                                id="content"
                                class="d-none"
                            >{{ old('content', $blog->content) }}</textarea>


                            @error('content')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror


                            <div class="field-help">

                                Use headings, lists, links, quotes and formatting
                                to make your article easier to read.

                            </div>

                        </div>


                        {{-- =================================================
                             IMAGES
                        ================================================== --}}

                        <div class="edit-section">

                            <div class="section-heading">

                                <div class="section-icon">
                                    <i class="bi bi-images"></i>
                                </div>

                                <div>

                                    <h5>
                                        Blog Images
                                    </h5>

                                    <small>
                                        Replace the existing images if needed.
                                    </small>

                                </div>

                            </div>


                            <div class="row g-4">


                                {{-- Main Image --}}
                                <div class="col-md-7">

                                    <div class="image-upload-box">

                                        <div class="image-upload-icon">
                                            <i class="bi bi-image"></i>
                                        </div>

                                        <label
                                            for="image"
                                            class="form-label"
                                        >
                                            Main Blog Image
                                        </label>

                                        <input
                                            type="file"
                                            name="image"
                                            id="image"
                                            class="form-control @error('image') is-invalid @enderror"
                                            accept="image/jpeg,image/png,image/jpg,image/webp"
                                        >

                                        <div class="field-help">
                                            Leave empty to keep the current image.
                                            JPG, PNG or WebP. Maximum 5MB.
                                        </div>


                                        @error('image')

                                            <div class="error-message">
                                                {{ $message }}
                                            </div>

                                        @enderror


                                        @if (!empty($blog->image))

                                            <div class="current-image">

                                                <div class="current-image-label">
                                                    CURRENT IMAGE
                                                </div>

                                                <img
                                                    src="{{ asset('image/blog/' . $blog->image) }}"
                                                    alt="{{ $blog->title }}"
                                                >

                                            </div>

                                        @endif


                                        <div
                                            class="new-preview"
                                            id="imagePreviewWrapper"
                                        >

                                            <div class="current-image-label">
                                                NEW IMAGE PREVIEW
                                            </div>

                                            <img
                                                src=""
                                                alt="New blog image"
                                                id="imagePreview"
                                            >

                                            <div
                                                class="file-name"
                                                id="imageFileName"
                                            ></div>

                                        </div>

                                    </div>

                                </div>


                                {{-- Thumbnail --}}
                                <div class="col-md-5">

                                    <div class="image-upload-box">

                                        <div class="image-upload-icon">
                                            <i class="bi bi-card-image"></i>
                                        </div>

                                        <label
                                            for="thumbnail"
                                            class="form-label"
                                        >
                                            Thumbnail
                                        </label>

                                        <input
                                            type="file"
                                            name="thumbnail"
                                            id="thumbnail"
                                            class="form-control @error('thumbnail') is-invalid @enderror"
                                            accept="image/jpeg,image/png,image/jpg,image/webp"
                                        >

                                        <div class="field-help">
                                            Leave empty to keep the current thumbnail.
                                            JPG, PNG or WebP. Maximum 2MB.
                                        </div>


                                        @error('thumbnail')

                                            <div class="error-message">
                                                {{ $message }}
                                            </div>

                                        @enderror


                                        @if (!empty($blog->thumbnail))

                                            <div class="current-image">

                                                <div class="current-image-label">
                                                    CURRENT THUMBNAIL
                                                </div>

                                                <img
                                                    src="{{ asset('image/blog/' . $blog->thumbnail) }}"
                                                    alt="{{ $blog->title }} thumbnail"
                                                >

                                            </div>

                                        @endif


                                        <div
                                            class="new-preview"
                                            id="thumbnailPreviewWrapper"
                                        >

                                            <div class="current-image-label">
                                                NEW THUMBNAIL PREVIEW
                                            </div>

                                            <img
                                                src=""
                                                alt="New thumbnail"
                                                id="thumbnailPreview"
                                            >

                                            <div
                                                class="file-name"
                                                id="thumbnailFileName"
                                            ></div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                             STATUS
                        ================================================== --}}

                        <div class="edit-section">

                            <div class="section-heading">

                                <div class="section-icon">
                                    <i class="bi bi-toggle-on"></i>
                                </div>

                                <div>

                                    <h5>
                                        Publishing Status
                                    </h5>

                                    <small>
                                        Control the current state of this article.
                                    </small>

                                </div>

                            </div>


                            <div class="row">

                                <div class="col-md-6">

                                    <label
                                        for="status"
                                        class="form-label"
                                    >
                                        Status
                                    </label>

                                    @php
                                        $currentStatus = old(
                                            'status',
                                            $blog->status
                                        );
                                    @endphp

                                    <select
                                        name="status"
                                        id="status"
                                        class="form-select @error('status') is-invalid @enderror"
                                    >

                                        <option value="pending"
                                            {{ (string) $currentStatus === 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>

                                        <option value="published"
                                            {{ (string) $currentStatus === 'published' ? 'selected' : '' }}>
                                            Published
                                        </option>

                                        <option value="rejected"
                                            {{ (string) $currentStatus === 'rejected' ? 'selected' : '' }}>
                                            Rejected
                                        </option>

                                    </select>

                                    @error('status')

                                        <div class="error-message">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                             ACTIONS
                        ================================================== --}}

                        <div class="edit-section">

                            <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 article-actions">

                                <a
                                    href="{{ url()->previous() }}"
                                    class="btn btn-outline-connector"
                                >
                                    <i class="bi bi-arrow-left"></i>
                                    Cancel
                                </a>


                                <button
                                    type="submit"
                                    class="btn btn-connector"
                                    id="updateButton"
                                >

                                    <span id="updateText">

                                        <i class="bi bi-check2-circle"></i>

                                        Update Blog

                                    </span>


                                    <span
                                        id="updateSpinner"
                                        style="display:none;"
                                    >

                                        <span
                                            class="spinner-border spinner-border-sm me-1"
                                            role="status"
                                        ></span>

                                        Updating...

                                    </span>

                                </button>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     SIDEBAR
                ================================================== --}}

                <div class="col-xl-4 col-lg-4">


                    {{-- Blog Summary --}}
                    <div class="side-card">

                        <div class="side-card-header">

                            <h6>
                                <i class="bi bi-file-earmark-text me-2"></i>
                                Blog Summary
                            </h6>

                        </div>


                        <div class="side-card-body">


                            {{-- Title --}}
                            <div class="info-item">

                                <div class="info-icon">
                                    <i class="bi bi-type"></i>
                                </div>

                                <div>

                                    <div class="info-label">
                                        Title
                                    </div>

                                    <div class="info-value">
                                        {{ Str::limit($blog->title, 55) }}
                                    </div>

                                </div>

                            </div>


                            {{-- Category --}}
                            <div class="info-item">

                                <div class="info-icon">
                                    <i class="bi bi-folder"></i>
                                </div>

                                <div>

                                    <div class="info-label">
                                        Category
                                    </div>

                                    <div class="info-value">
                                        {{ $blog->category->name ?? 'Not assigned' }}
                                    </div>

                                </div>

                            </div>


                            {{-- Subcategory --}}
                            <div class="info-item">

                                <div class="info-icon">
                                    <i class="bi bi-folder2-open"></i>
                                </div>

                                <div>

                                    <div class="info-label">
                                        Subcategory
                                    </div>

                                    <div class="info-value">
                                        {{ $blog->subcategory->name ?? 'Not assigned' }}
                                    </div>

                                </div>

                            </div>


                            {{-- Created --}}
                            <div class="info-item">

                                <div class="info-icon">
                                    <i class="bi bi-calendar3"></i>
                                </div>

                                <div>

                                    <div class="info-label">
                                        Created
                                    </div>

                                    <div class="info-value">

                                        {{ optional($blog->created_at)->format('M d, Y') }}

                                    </div>

                                </div>

                            </div>


                            {{-- Views --}}
                            @if (isset($blog->views))

                                <div class="info-item">

                                    <div class="info-icon">
                                        <i class="bi bi-eye"></i>
                                    </div>

                                    <div>

                                        <div class="info-label">
                                            Views
                                        </div>

                                        <div class="info-value">
                                            {{ number_format($blog->views) }}
                                        </div>

                                    </div>

                                </div>

                            @endif


                        </div>

                    </div>


                    {{-- Status Information --}}
                    <div class="side-card">

                        <div class="side-card-header">

                            <h6>
                                <i class="bi bi-activity me-2"></i>
                                Current Status
                            </h6>

                        </div>


                        <div class="side-card-body">

                            @php

                                $status = strtolower(
                                    (string) $blog->status
                                );

                                $statusClass = match ($status) {

                                    'published',
                                    'approved',
                                    'active',
                                    '1'
                                        => 'status-published',

                                    'rejected',
                                    'inactive'
                                        => 'status-rejected',

                                    default
                                        => 'status-pending',

                                };

                                $statusLabel = match ($status) {

                                    'published'
                                        => 'Published',

                                    'approved'
                                        => 'Approved',

                                    'active'
                                        => 'Active',

                                    'rejected'
                                        => 'Rejected',

                                    'inactive'
                                        => 'Inactive',

                                    '1'
                                        => 'Active',

                                    default
                                        => 'Pending',

                                };

                            @endphp


                            <span class="status-badge {{ $statusClass }}">

                                <i
                                    class="bi bi-circle-fill"
                                    style="font-size: 6px;"
                                ></i>

                                {{ $statusLabel }}

                            </span>


                            <div class="field-help mt-3">

                                Changing the status controls the current
                                publishing state of this blog.

                            </div>

                        </div>

                    </div>


                    {{-- Editing Tips --}}
                    <div class="side-card">

                        <div class="side-card-header">

                            <h6>
                                <i class="bi bi-lightbulb me-2"></i>
                                Editing Tips
                            </h6>

                        </div>


                        <div class="side-card-body">

                            <div class="info-item">

                                <div class="info-icon">
                                    <i class="bi bi-check2"></i>
                                </div>

                                <div>

                                    <div class="info-value">
                                        Clear title
                                    </div>

                                    <div class="field-help mt-1">
                                        Keep the title concise and descriptive.
                                    </div>

                                </div>

                            </div>


                            <div class="info-item">

                                <div class="info-icon">
                                    <i class="bi bi-list-ul"></i>
                                </div>

                                <div>

                                    <div class="info-value">
                                        Structure content
                                    </div>

                                    <div class="field-help mt-1">
                                        Use headings and lists where appropriate.
                                    </div>

                                </div>

                            </div>


                            <div class="info-item">

                                <div class="info-icon">
                                    <i class="bi bi-image"></i>
                                </div>

                                <div>

                                    <div class="info-value">
                                        Quality images
                                    </div>

                                    <div class="field-help mt-1">
                                        Use clear and relevant images.
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection


@push('scripts')

    {{-- Quill --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | Elements
            |--------------------------------------------------------------------------
            */

            const form =
                document.getElementById('editBlogForm');

            const contentField =
                document.getElementById('content');

            const categorySelect =
                document.getElementById('service_category_id');

            const subcategorySelect =
                document.getElementById('service_sub_category_id');

            const imageField =
                document.getElementById('image');

            const thumbnailField =
                document.getElementById('thumbnail');


            /*
            |--------------------------------------------------------------------------
            | Existing category/subcategory
            |--------------------------------------------------------------------------
            */

            const allSubcategories =
                @json($subcategoriesJson);

            const selectedCategory =
                @json((string) $selectedCategory);

            const selectedSubcategory =
                @json((string) $selectedSubcategory);


            /*
            |--------------------------------------------------------------------------
            | Load subcategories
            |--------------------------------------------------------------------------
            */

            function loadSubcategories(
                selectedId = ''
            ) {

                const categoryId =
                    categorySelect.value;


                subcategorySelect.innerHTML = '';


                const defaultOption =
                    document.createElement('option');

                defaultOption.value = '';
                defaultOption.textContent =
                    'Select subcategory';

                subcategorySelect.appendChild(
                    defaultOption
                );


                if (!categoryId) {

                    subcategorySelect.disabled =
                        true;

                    return;

                }


                const filtered =
                    allSubcategories.filter(function (item) {

                        return String(
                            item.category_id
                        ) === String(categoryId);

                    });


                if (filtered.length === 0) {

                    const emptyOption =
                        document.createElement('option');

                    emptyOption.value = '';

                    emptyOption.textContent =
                        'No subcategories available';

                    subcategorySelect.appendChild(
                        emptyOption
                    );

                    subcategorySelect.disabled =
                        true;

                    return;

                }


                filtered.forEach(function (item) {

                    const option =
                        document.createElement('option');

                    option.value =
                        item.id;

                    option.textContent =
                        item.name;


                    if (
                        selectedId !== '' &&
                        String(selectedId) ===
                        String(item.id)
                    ) {

                        option.selected =
                            true;

                    }


                    subcategorySelect.appendChild(
                        option
                    );

                });


                subcategorySelect.disabled =
                    false;

            }


            /*
            |--------------------------------------------------------------------------
            | Initial subcategory
            |--------------------------------------------------------------------------
            */

            if (categorySelect.value) {

                loadSubcategories(
                    selectedSubcategory
                );

            } else {

                subcategorySelect.disabled =
                    true;

            }


            /*
            |--------------------------------------------------------------------------
            | Category change
            |--------------------------------------------------------------------------
            */

            categorySelect.addEventListener(
                'change',
                function () {

                    loadSubcategories();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Quill Editor
            |--------------------------------------------------------------------------
            */

            let quill = null;


            if (typeof Quill !== 'undefined') {

                quill = new Quill(
                    '#blog-editor',
                    {
                        theme: 'snow',

                        placeholder:
                            'Edit your blog content here...',

                        modules: {

                            toolbar: [

                                [
                                    {
                                        header: [
                                            1,
                                            2,
                                            3,
                                            false
                                        ]
                                    }
                                ],

                                [
                                    'bold',
                                    'italic',
                                    'underline',
                                    'strike'
                                ],

                                [
                                    {
                                        color: []
                                    },
                                    {
                                        background: []
                                    }
                                ],

                                [
                                    {
                                        list: 'ordered'
                                    },
                                    {
                                        list: 'bullet'
                                    }
                                ],

                                [
                                    {
                                        align: []
                                    }
                                ],

                                [
                                    'blockquote',
                                    'code-block'
                                ],

                                [
                                    'link'
                                ],

                                [
                                    'clean'
                                ]

                            ]

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Load existing blog content
                |--------------------------------------------------------------------------
                */

                const existingContent =
                    contentField.value.trim();


                if (existingContent !== '') {

                    quill.clipboard.dangerouslyPasteHTML(
                        existingContent
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Keep textarea synchronized
                |--------------------------------------------------------------------------
                */

                quill.on(
                    'text-change',
                    function () {

                        contentField.value =
                            quill.root.innerHTML;

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Image preview helper
            |--------------------------------------------------------------------------
            */

            function setupPreview(
                input,
                wrapper,
                image,
                fileName
            ) {

                if (!input) {
                    return;
                }


                input.addEventListener(
                    'change',
                    function () {

                        const file =
                            this.files &&
                            this.files[0];


                        if (!file) {

                            wrapper.style.display =
                                'none';

                            image.src = '';

                            fileName.textContent =
                                '';

                            return;

                        }


                        fileName.textContent =
                            file.name;


                        if (
                            !file.type.startsWith(
                                'image/'
                            )
                        ) {

                            wrapper.style.display =
                                'none';

                            return;

                        }


                        const reader =
                            new FileReader();


                        reader.onload =
                            function (event) {

                                image.src =
                                    event.target.result;

                                wrapper.style.display =
                                    'block';

                            };


                        reader.readAsDataURL(
                            file
                        );

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Main image preview
            |--------------------------------------------------------------------------
            */

            setupPreview(

                imageField,

                document.getElementById(
                    'imagePreviewWrapper'
                ),

                document.getElementById(
                    'imagePreview'
                ),

                document.getElementById(
                    'imageFileName'
                )

            );


            /*
            |--------------------------------------------------------------------------
            | Thumbnail preview
            |--------------------------------------------------------------------------
            */

            setupPreview(

                thumbnailField,

                document.getElementById(
                    'thumbnailPreviewWrapper'
                ),

                document.getElementById(
                    'thumbnailPreview'
                ),

                document.getElementById(
                    'thumbnailFileName'
                )

            );


            /*
            |--------------------------------------------------------------------------
            | Submit
            |--------------------------------------------------------------------------
            */

            form.addEventListener(
                'submit',
                function (event) {

                    /*
                     * Synchronize Quill with Laravel field.
                     */

                    if (quill) {

                        contentField.value =
                            quill.root.innerHTML;

                    }


                    /*
                     * Validate editor.
                     */

                    let textContent = '';


                    if (quill) {

                        textContent =
                            quill.getText().trim();

                    } else {

                        textContent =
                            contentField.value
                                .replace(
                                    /<[^>]*>/g,
                                    ''
                                )
                                .trim();

                    }


                    if (!textContent) {

                        event.preventDefault();

                        alert(
                            'Blog content cannot be empty.'
                        );

                        if (quill) {

                            quill.focus();

                        }

                        return;

                    }


                    /*
                     * Prevent duplicate submissions.
                     */

                    const button =
                        document.getElementById(
                            'updateButton'
                        );

                    const text =
                        document.getElementById(
                            'updateText'
                        );

                    const spinner =
                        document.getElementById(
                            'updateSpinner'
                        );


                    if (
                        button.dataset.submitting ===
                        'true'
                    ) {

                        event.preventDefault();

                        return;

                    }


                    button.dataset.submitting =
                        'true';

                    button.disabled =
                        true;

                    text.style.display =
                        'none';

                    spinner.style.display =
                        'inline-flex';

                }
            );

        });
    </script>

@endpush