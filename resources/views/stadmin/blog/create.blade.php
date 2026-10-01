@extends('layouts.app')

@section('title', 'Create Blog')

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
            --connector-light: #f4f8f6;
            --connector-border: #e2e9e5;
            --connector-text: #24342d;
            --connector-muted: #718078;
        }

        .blog-page {
            background: #f7f9f8;
            min-height: calc(100vh - 70px);
            padding: 30px 0 60px;
        }

        .page-header {
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

        .page-header::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .06);
            right: -70px;
            top: -100px;
        }

        .page-header h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .page-header p {
            margin: 0;
            color: rgba(255, 255, 255, .78);
            font-size: 14px;
        }

        .header-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            background: rgba(255, 255, 255, .12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        .form-card {
            background: #fff;
            border: 1px solid var(--connector-border);
            border-radius: 17px;
            box-shadow: 0 5px 20px rgba(37, 64, 53, .05);
            overflow: hidden;
        }

        .card-section {
            padding: 25px;
            border-bottom: 1px solid #edf1ef;
        }

        .card-section:last-child {
            border-bottom: 0;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 22px;
        }

        .section-title-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--connector-light);
            color: var(--connector-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-title h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--connector-text);
        }

        .section-title small {
            display: block;
            color: var(--connector-muted);
            margin-top: 2px;
        }

        .form-label {
            color: var(--connector-text);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
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
            box-shadow: 0 0 0 3px rgba(107, 144, 128, .12) !important;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .form-control::placeholder {
            color: #a4aea9;
        }

        .required {
            color: #dc3545;
        }

        .field-help {
            font-size: 12px;
            color: var(--connector-muted);
            margin-top: 6px;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 6px;
        }

        /*
        |--------------------------------------------------------------------------
        | Quill
        |--------------------------------------------------------------------------
        */

        .editor-wrapper {
            border: 1px solid #dce5e0;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            transition: .2s ease;
        }

        .editor-wrapper:focus-within {
            border-color: var(--connector-secondary);
            box-shadow: 0 0 0 3px rgba(107, 144, 128, .12);
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

        .ql-snow .ql-picker {
            color: var(--connector-text);
        }

        .ql-snow .ql-stroke {
            stroke: var(--connector-text);
        }

        .ql-snow .ql-fill {
            fill: var(--connector-text);
        }

        /*
        |--------------------------------------------------------------------------
        | Image upload
        |--------------------------------------------------------------------------
        */

        .upload-box {
            border: 1.5px dashed #cbd8d2;
            border-radius: 13px;
            padding: 22px;
            background: #fbfcfb;
            transition: .2s ease;
        }

        .upload-box:hover {
            border-color: var(--connector-secondary);
            background: #f8fbf9;
        }

        .upload-icon {
            width: 45px;
            height: 45px;
            border-radius: 11px;
            background: var(--connector-light);
            color: var(--connector-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            font-size: 19px;
        }

        .preview-wrapper {
            margin-top: 15px;
            display: none;
        }

        .preview-wrapper img {
            width: 100%;
            max-height: 220px;
            object-fit: cover;
            border-radius: 11px;
            border: 1px solid var(--connector-border);
        }

        /*
        |--------------------------------------------------------------------------
        | Right sidebar
        |--------------------------------------------------------------------------
        */

        .side-card {
            background: #fff;
            border: 1px solid var(--connector-border);
            border-radius: 17px;
            box-shadow: 0 5px 20px rgba(37, 64, 53, .05);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .side-card-header {
            padding: 18px 20px;
            border-bottom: 1px solid #edf1ef;
        }

        .side-card-header h6 {
            margin: 0;
            font-weight: 700;
            color: var(--connector-text);
        }

        .side-card-body {
            padding: 20px;
        }

        .publish-info {
            background: var(--connector-light);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 18px;
        }

        .publish-info-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 13px;
        }

        .publish-info-item:last-child {
            margin-bottom: 0;
        }

        .publish-info-icon {
            color: var(--connector-secondary);
            margin-top: 2px;
        }

        .publish-info strong {
            display: block;
            color: var(--connector-text);
            font-size: 13px;
            margin-bottom: 2px;
        }

        .publish-info span {
            color: var(--connector-muted);
            font-size: 12px;
        }

        .btn-connector {
            background: var(--connector-primary);
            color: #fff;
            border: 0;
            border-radius: 10px;
            min-height: 46px;
            font-size: 14px;
            font-weight: 600;
            padding: 0 20px;
            transition: .2s ease;
        }

        .btn-connector:hover {
            background: #1c3229;
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-outline-connector {
            background: #fff;
            color: var(--connector-primary);
            border: 1px solid #ccd8d2;
            border-radius: 10px;
            min-height: 46px;
            font-size: 14px;
            font-weight: 600;
            padding: 0 20px;
        }

        .btn-outline-connector:hover {
            border-color: var(--connector-secondary);
            color: var(--connector-primary);
            background: var(--connector-light);
        }

        .validation-alert {
            border: 0;
            border-left: 4px solid #dc3545;
            border-radius: 10px;
            background: #fff5f5;
            color: #842029;
            font-size: 13px;
        }

        .validation-alert ul {
            margin-bottom: 0;
            padding-left: 18px;
        }

        .loading-spinner {
            display: none;
        }

        .file-name {
            font-size: 12px;
            color: var(--connector-muted);
            margin-top: 8px;
            word-break: break-word;
        }

        @media (max-width: 991.98px) {
            .blog-page {
                padding: 20px 0 40px;
            }

            .page-header {
                padding: 22px;
            }

            .card-section {
                padding: 20px;
            }
        }
    </style>
@endpush


@section('content')

<div class="blog-page">

    <div class="container-fluid px-3 px-lg-4">

        {{-- Page Header --}}
        <div class="page-header">

            <div class="d-flex align-items-center gap-3 position-relative" style="z-index: 2;">

                <div class="header-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>

                <div>
                    <h1>Create Blog</h1>
                    <p>
                        Share useful knowledge, stories and insights with the Connector community.
                    </p>
                </div>

            </div>

        </div>


        {{-- Validation Errors --}}
        @if ($errors->any())

            <div class="alert validation-alert mb-4">

                <div class="d-flex gap-2">

                    <i class="bi bi-exclamation-circle-fill mt-1"></i>

                    <div>
                        <strong>Please correct the following:</strong>

                        <ul class="mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>

            </div>

        @endif


        @if (session('success'))

            <div class="alert alert-success border-0 rounded-3 mb-4">
                {{ session('success') }}
            </div>

        @endif


        @if (session('error'))

            <div class="alert alert-danger border-0 rounded-3 mb-4">
                {{ session('error') }}
            </div>

        @endif


        {{-- Prepare category/subcategory data safely --}}
        @php

            $oldCategory = old('service_category_id');
            $oldSubcategory = old('service_sub_category_id');

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


        <form
            action="{{ route('serviceProviderBlog.StoreBlog') }}"
            method="POST"
            enctype="multipart/form-data"
            id="createBlogForm"
        >

            @csrf


            <div class="row g-4">

                {{-- =========================================================
                     MAIN CONTENT
                ========================================================== --}}
                <div class="col-lg-8">

                    <div class="form-card">

                        {{-- Basic Information --}}
                        <div class="card-section">

                            <div class="section-title">

                                <div class="section-title-icon">
                                    <i class="bi bi-file-text"></i>
                                </div>

                                <div>
                                    <h5>Blog Information</h5>
                                    <small>Enter the main details of your article.</small>
                                </div>

                            </div>


                            {{-- Title --}}
                            <div class="mb-4">

                                <label for="title" class="form-label">
                                    Blog Title
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}"
                                    placeholder="Enter a clear and engaging blog title"
                                    maxlength="255"
                                    required
                                >

                                @error('title')
                                    <div class="error-message">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="field-help">
                                    Keep your title clear and descriptive.
                                </div>

                            </div>


                            {{-- Category --}}
                            <div class="row g-3 mb-4">

                                <div class="col-md-6">

                                    <label for="service_category_id" class="form-label">
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
                                                {{ (string) $oldCategory === (string) $category->id ? 'selected' : '' }}
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


                                {{-- Subcategory --}}
                                <div class="col-md-6">

                                    <label for="service_sub_category_id" class="form-label">
                                        Subcategory
                                        <span class="required">*</span>
                                    </label>

                                    <select
                                        name="service_sub_category_id"
                                        id="service_sub_category_id"
                                        class="form-select @error('service_sub_category_id') is-invalid @enderror"
                                        {{ $oldCategory ? '' : 'disabled' }}
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

                                </div>

                            </div>

                        </div>


                        {{-- Blog Editor --}}
                        <div class="card-section">

                            <div class="section-title">

                                <div class="section-title-icon">
                                    <i class="bi bi-body-text"></i>
                                </div>

                                <div>
                                    <h5>Blog Content</h5>
                                    <small>
                                        Write and format your article.
                                    </small>
                                </div>

                            </div>


                            <div class="mb-2">

                                <label class="form-label">
                                    Content
                                    <span class="required">*</span>
                                </label>

                                <div class="editor-wrapper">

                                    <div id="blog-editor"></div>

                                </div>

                                {{-- Actual field submitted to Laravel --}}
                                <textarea
                                    name="content"
                                    id="content"
                                    class="d-none"
                                >{{ old('content') }}</textarea>

                                @error('content')
                                    <div class="error-message">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="field-help">
                                    Use headings, lists, links, quotes and text formatting to make your article easier to read.
                                </div>

                            </div>

                        </div>


                        {{-- Images --}}
                        <div class="card-section">

                            <div class="section-title">

                                <div class="section-title-icon">
                                    <i class="bi bi-images"></i>
                                </div>

                                <div>
                                    <h5>Blog Images</h5>
                                    <small>
                                        Add the main article image and thumbnail.
                                    </small>
                                </div>

                            </div>


                            <div class="row g-4">

                                {{-- Main Image --}}
                                <div class="col-md-7">

                                    <div class="upload-box">

                                        <div class="upload-icon">
                                            <i class="bi bi-image"></i>
                                        </div>

                                        <label
                                            for="image"
                                            class="form-label"
                                        >
                                            Main Blog Image
                                            <span class="required">*</span>
                                        </label>

                                        <input
                                            type="file"
                                            name="image"
                                            id="image"
                                            class="form-control @error('image') is-invalid @enderror"
                                            accept="image/jpeg,image/png,image/jpg,image/webp"
                                            required
                                        >

                                        <div class="field-help">
                                            Recommended: JPG, PNG or WebP. Maximum 5MB.
                                        </div>

                                        <div
                                            class="file-name"
                                            id="imageFileName"
                                        ></div>

                                        <div
                                            class="preview-wrapper"
                                            id="imagePreviewWrapper"
                                        >
                                            <img
                                                src=""
                                                alt="Blog image preview"
                                                id="imagePreview"
                                            >
                                        </div>

                                    </div>

                                    @error('image')
                                        <div class="error-message">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                {{-- Thumbnail --}}
                                <div class="col-md-5">

                                    <div class="upload-box">

                                        <div class="upload-icon">
                                            <i class="bi bi-card-image"></i>
                                        </div>

                                        <label
                                            for="thumbnail"
                                            class="form-label"
                                        >
                                            Thumbnail
                                            <span class="required">*</span>
                                        </label>

                                        <input
                                            type="file"
                                            name="thumbnail"
                                            id="thumbnail"
                                            class="form-control @error('thumbnail') is-invalid @enderror"
                                            accept="image/jpeg,image/png,image/jpg,image/webp"
                                            required
                                        >

                                        <div class="field-help">
                                            Recommended: JPG, PNG or WebP. Maximum 2MB.
                                        </div>

                                        <div
                                            class="file-name"
                                            id="thumbnailFileName"
                                        ></div>

                                        <div
                                            class="preview-wrapper"
                                            id="thumbnailPreviewWrapper"
                                        >
                                            <img
                                                src=""
                                                alt="Thumbnail preview"
                                                id="thumbnailPreview"
                                            >
                                        </div>

                                    </div>

                                    @error('thumbnail')
                                        <div class="error-message">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                        </div>


                        {{-- Form Actions --}}
                        <div class="card-section">

                            <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">

                                <a
                                    href="{{ url()->previous() }}"
                                    class="btn btn-outline-connector"
                                >
                                    <i class="bi bi-arrow-left me-1"></i>
                                    Cancel
                                </a>

                                <button
                                    type="submit"
                                    class="btn btn-connector"
                                    id="submitButton"
                                >

                                    <span id="submitText">
                                        <i class="bi bi-send me-1"></i>
                                        Submit Blog
                                    </span>

                                    <span
                                        class="loading-spinner"
                                        id="submitSpinner"
                                    >
                                        <span
                                            class="spinner-border spinner-border-sm me-1"
                                            role="status"
                                        ></span>
                                        Submitting...
                                    </span>

                                </button>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =========================================================
                     SIDEBAR
                ========================================================== --}}
                <div class="col-lg-4">

                    {{-- Publishing Information --}}
                    <div class="side-card">

                        <div class="side-card-header">
                            <h6>
                                <i class="bi bi-info-circle me-2"></i>
                                Publishing Information
                            </h6>
                        </div>

                        <div class="side-card-body">

                            <div class="publish-info">

                                <div class="publish-info-item">

                                    <div class="publish-info-icon">
                                        <i class="bi bi-check-circle"></i>
                                    </div>

                                    <div>
                                        <strong>Review your content</strong>
                                        <span>
                                            Check the title, category, images and article before submitting.
                                        </span>
                                    </div>

                                </div>


                                <div class="publish-info-item">

                                    <div class="publish-info-icon">
                                        <i class="bi bi-image"></i>
                                    </div>

                                    <div>
                                        <strong>Use quality images</strong>
                                        <span>
                                            Choose clear images that represent your article.
                                        </span>
                                    </div>

                                </div>


                                <div class="publish-info-item">

                                    <div class="publish-info-icon">
                                        <i class="bi bi-text-paragraph"></i>
                                    </div>

                                    <div>
                                        <strong>Keep content readable</strong>
                                        <span>
                                            Use headings and short paragraphs where appropriate.
                                        </span>
                                    </div>

                                </div>

                            </div>

                            <div class="small text-muted">
                                <i class="bi bi-shield-check me-1"></i>
                                Your blog will be submitted using your service provider account.
                            </div>

                        </div>

                    </div>


                    {{-- Content Checklist --}}
                    <div class="side-card">

                        <div class="side-card-header">
                            <h6>
                                <i class="bi bi-list-check me-2"></i>
                                Content Checklist
                            </h6>
                        </div>

                        <div class="side-card-body">

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i
                                    class="bi bi-check-circle text-success"
                                    id="checkTitle"
                                ></i>

                                <span class="small">
                                    Blog title
                                </span>
                            </div>

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i
                                    class="bi bi-circle text-muted"
                                    id="checkCategory"
                                ></i>

                                <span class="small">
                                    Category and subcategory
                                </span>
                            </div>

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i
                                    class="bi bi-circle text-muted"
                                    id="checkContent"
                                ></i>

                                <span class="small">
                                    Blog content
                                </span>
                            </div>

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i
                                    class="bi bi-circle text-muted"
                                    id="checkImage"
                                ></i>

                                <span class="small">
                                    Main image
                                </span>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <i
                                    class="bi bi-circle text-muted"
                                    id="checkThumbnail"
                                ></i>

                                <span class="small">
                                    Thumbnail
                                </span>
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

            const form = document.getElementById('createBlogForm');

            const categorySelect = document.getElementById(
                'service_category_id'
            );

            const subcategorySelect = document.getElementById(
                'service_sub_category_id'
            );

            const contentField = document.getElementById('content');

            const titleField = document.getElementById('title');

            const imageField = document.getElementById('image');

            const thumbnailField = document.getElementById('thumbnail');


            /*
            |--------------------------------------------------------------------------
            | Subcategories
            |--------------------------------------------------------------------------
            */

            const allSubcategories = @json($subcategoriesJson);

            const oldSubcategory = @json($oldSubcategory);


            function loadSubcategories(selectedId = '') {

                const categoryId = categorySelect.value;

                subcategorySelect.innerHTML = '';

                const defaultOption = document.createElement('option');

                defaultOption.value = '';
                defaultOption.textContent = 'Select subcategory';

                subcategorySelect.appendChild(defaultOption);


                if (!categoryId) {

                    subcategorySelect.disabled = true;

                    return;
                }


                const filtered = allSubcategories.filter(function (item) {

                    return String(item.category_id) === String(categoryId);

                });


                if (filtered.length === 0) {

                    const emptyOption = document.createElement('option');

                    emptyOption.value = '';
                    emptyOption.textContent = 'No subcategories available';

                    subcategorySelect.appendChild(emptyOption);

                    subcategorySelect.disabled = true;

                    return;
                }


                filtered.forEach(function (item) {

                    const option = document.createElement('option');

                    option.value = item.id;
                    option.textContent = item.name;

                    if (
                        selectedId !== '' &&
                        String(selectedId) === String(item.id)
                    ) {
                        option.selected = true;
                    }

                    subcategorySelect.appendChild(option);

                });


                subcategorySelect.disabled = false;

            }


            categorySelect.addEventListener('change', function () {

                loadSubcategories();

                updateChecklist();

            });


            /*
            |--------------------------------------------------------------------------
            | Initial category/subcategory
            |--------------------------------------------------------------------------
            */

            loadSubcategories(oldSubcategory);


            /*
            |--------------------------------------------------------------------------
            | Quill Editor
            |--------------------------------------------------------------------------
            */

            let quill = null;


            if (typeof Quill !== 'undefined') {

                quill = new Quill('#blog-editor', {

                    theme: 'snow',

                    placeholder: 'Write your blog article here...',

                    modules: {

                        toolbar: [

                            [
                                {
                                    header: [1, 2, 3, false]
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

                });


                /*
                |--------------------------------------------------------------------------
                | Restore old content after validation error
                |--------------------------------------------------------------------------
                */

                const oldContent = contentField.value.trim();

                if (oldContent !== '') {

                    quill.clipboard.dangerouslyPasteHTML(
                        oldContent
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Sync Quill -> textarea
                |--------------------------------------------------------------------------
                */

                quill.on('text-change', function () {

                    contentField.value =
                        quill.root.innerHTML;

                    updateChecklist();

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Image Preview Helper
            |--------------------------------------------------------------------------
            */

            function setupImagePreview(
                input,
                previewWrapper,
                previewImage,
                fileNameElement
            ) {

                if (!input) {
                    return;
                }

                input.addEventListener('change', function () {

                    const file = this.files && this.files[0];

                    if (!file) {

                        previewWrapper.style.display = 'none';
                        previewImage.src = '';
                        fileNameElement.textContent = '';

                        updateChecklist();

                        return;
                    }


                    fileNameElement.textContent =
                        file.name;


                    if (!file.type.startsWith('image/')) {

                        previewWrapper.style.display = 'none';

                        updateChecklist();

                        return;
                    }


                    const reader = new FileReader();


                    reader.onload = function (event) {

                        previewImage.src =
                            event.target.result;

                        previewWrapper.style.display =
                            'block';

                    };


                    reader.readAsDataURL(file);

                    updateChecklist();

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Main Image Preview
            |--------------------------------------------------------------------------
            */

            setupImagePreview(

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
            | Thumbnail Preview
            |--------------------------------------------------------------------------
            */

            setupImagePreview(

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
            | Checklist
            |--------------------------------------------------------------------------
            */

            function setChecklistState(elementId, completed) {

                const element =
                    document.getElementById(elementId);

                if (!element) {
                    return;
                }


                if (completed) {

                    element.className =
                        'bi bi-check-circle-fill text-success';

                } else {

                    element.className =
                        'bi bi-circle text-muted';

                }

            }


            function updateChecklist() {

                const titleComplete =
                    titleField &&
                    titleField.value.trim().length > 0;


                const categoryComplete =
                    categorySelect &&
                    categorySelect.value !== '' &&
                    subcategorySelect &&
                    subcategorySelect.value !== '';


                let contentComplete = false;


                if (quill) {

                    contentComplete =
                        quill.getText().trim().length > 0;

                } else {

                    contentComplete =
                        contentField.value.trim().length > 0;

                }


                const imageComplete =
                    imageField &&
                    imageField.files &&
                    imageField.files.length > 0;


                const thumbnailComplete =
                    thumbnailField &&
                    thumbnailField.files &&
                    thumbnailField.files.length > 0;


                setChecklistState(
                    'checkTitle',
                    titleComplete
                );

                setChecklistState(
                    'checkCategory',
                    categoryComplete
                );

                setChecklistState(
                    'checkContent',
                    contentComplete
                );

                setChecklistState(
                    'checkImage',
                    imageComplete
                );

                setChecklistState(
                    'checkThumbnail',
                    thumbnailComplete
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Title Checklist
            |--------------------------------------------------------------------------
            */

            titleField.addEventListener(
                'input',
                updateChecklist
            );


            /*
            |--------------------------------------------------------------------------
            | Initial Checklist
            |--------------------------------------------------------------------------
            */

            updateChecklist();


            /*
            |--------------------------------------------------------------------------
            | Form Submit
            |--------------------------------------------------------------------------
            */

            form.addEventListener('submit', function (event) {

                /*
                 * Always sync editor before Laravel receives request.
                 */
                if (quill) {

                    contentField.value =
                        quill.root.innerHTML;

                }


                /*
                 * Validate editor content.
                 */
                let contentText = '';

                if (quill) {

                    contentText =
                        quill.getText().trim();

                } else {

                    contentText =
                        contentField.value
                            .replace(/<[^>]*>/g, '')
                            .trim();

                }


                if (!contentText) {

                    event.preventDefault();

                    alert(
                        'Please enter your blog content.'
                    );

                    if (quill) {
                        quill.focus();
                    }

                    return;

                }


                /*
                 * Prevent accidental double submission.
                 */

                const submitButton =
                    document.getElementById(
                        'submitButton'
                    );

                const submitText =
                    document.getElementById(
                        'submitText'
                    );

                const submitSpinner =
                    document.getElementById(
                        'submitSpinner'
                    );


                if (submitButton.dataset.submitting === 'true') {

                    event.preventDefault();

                    return;

                }


                submitButton.dataset.submitting =
                    'true';

                submitButton.disabled = true;

                submitText.style.display =
                    'none';

                submitSpinner.style.display =
                    'inline-flex';

            });

        });
    </script>

@endpush