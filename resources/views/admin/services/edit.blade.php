@extends('layouts.app')

@section('title', 'Edit Service')

@section('content')

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-primary-dark: #254035;
        --connector-primary-soft: #edf4f1;
        --connector-bg: #f7f9f8;
        --connector-border: #e2ebe7;
        --connector-text: #24332d;
        --connector-muted: #7a8983;
        --connector-danger: #c94c4c;
        --connector-shadow: 0 10px 30px rgba(37, 64, 53, .07);
    }

    .service-edit-page {
        min-height: calc(100vh - 80px);
        background: var(--connector-bg);
        padding: 28px 0 55px;
    }

    /* Header */
    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-eyebrow {
        color: var(--connector-primary);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .13em;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .page-title {
        color: var(--connector-primary-dark);
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -.03em;
        margin: 0;
    }

    .page-description {
        color: var(--connector-muted);
        font-size: 13px;
        margin: 7px 0 0;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 15px;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        background: #fff;
        color: var(--connector-primary-dark);
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        transition: .2s ease;
    }

    .back-btn:hover {
        color: var(--connector-primary-dark);
        border-color: var(--connector-primary);
        background: var(--connector-primary-soft);
    }

    /* Main card */
    .form-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 17px;
        box-shadow: var(--connector-shadow);
        overflow: hidden;
    }

    .form-card-header {
        padding: 20px 23px;
        border-bottom: 1px solid var(--connector-border);
        background: #fff;
    }

    .form-card-title {
        margin: 0;
        color: var(--connector-primary-dark);
        font-size: 16px;
        font-weight: 800;
    }

    .form-card-subtitle {
        margin: 4px 0 0;
        color: var(--connector-muted);
        font-size: 12px;
    }

    .form-card-body {
        padding: 24px;
    }

    /* Section */
    .form-section {
        margin-bottom: 30px;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .section-heading {
        display: flex;
        align-items: center;
        gap: 11px;
        padding-bottom: 12px;
        margin-bottom: 19px;
        border-bottom: 1px solid #edf1ef;
    }

    .section-icon {
        width: 35px;
        height: 35px;
        border-radius: 9px;
        background: var(--connector-primary-soft);
        color: var(--connector-primary-dark);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .section-title {
        color: var(--connector-primary-dark);
        font-size: 14px;
        font-weight: 800;
        margin: 0;
    }

    .section-description {
        color: var(--connector-muted);
        font-size: 11px;
        margin: 2px 0 0;
    }

    /* Form */
    .form-label {
        color: var(--connector-text);
        font-size: 12px;
        font-weight: 750;
        margin-bottom: 7px;
    }

    .required {
        color: var(--connector-danger);
    }

    .form-control,
    .form-select {
        min-height: 43px;
        border: 1px solid var(--connector-border);
        border-radius: 9px;
        color: var(--connector-text);
        background-color: #fff;
        font-size: 13px;
        padding: 9px 12px;
        box-shadow: none;
    }

    .form-control::placeholder {
        color: #a7b0ac;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--connector-primary);
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .10);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
        line-height: 1.55;
    }

    .small-help {
        color: var(--connector-muted);
        font-size: 11px;
        margin-top: 6px;
    }

    .invalid-feedback {
        font-size: 11px;
    }

    /* Price */
    .price-input-group {
        position: relative;
    }

    .price-currency {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--connector-muted);
        font-size: 11px;
        font-weight: 800;
        z-index: 2;
    }

    .price-input {
        padding-left: 51px !important;
    }

    /* Image */
    .image-upload {
        border: 1.5px dashed #cbd9d3;
        background: #fafcfb;
        border-radius: 13px;
        padding: 17px;
        transition: .2s ease;
    }

    .image-upload:hover {
        border-color: var(--connector-primary);
        background: var(--connector-primary-soft);
    }

    .current-image {
        position: relative;
        margin-bottom: 15px;
    }

    .current-image img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--connector-border);
    }

    .current-image-label {
        position: absolute;
        top: 10px;
        left: 10px;
        background: var(--connector-primary-dark);
        color: #fff;
        border-radius: 7px;
        padding: 5px 9px;
        font-size: 10px;
        font-weight: 800;
    }

    .image-preview {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--connector-border);
        display: none;
        margin-bottom: 13px;
    }

    .upload-placeholder {
        min-height: 170px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: var(--connector-muted);
    }

    .upload-icon {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        background: var(--connector-primary-soft);
        color: var(--connector-primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }

    .upload-title {
        color: var(--connector-primary-dark);
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .upload-text {
        font-size: 11px;
        margin-bottom: 13px;
    }

    .upload-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--connector-primary-dark);
        color: #fff;
        border-radius: 8px;
        padding: 8px 13px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }

    .upload-btn:hover {
        background: var(--connector-primary);
        color: #fff;
    }

    /* List */
    .list-help {
        background: var(--connector-primary-soft);
        border-radius: 8px;
        padding: 9px 11px;
        color: var(--connector-primary-dark);
        font-size: 11px;
        margin-top: 7px;
    }

    /* Settings */
    .settings-box {
        border: 1px solid var(--connector-border);
        background: #fafcfb;
        border-radius: 12px;
        padding: 16px;
    }

    .setting-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 11px 0;
        border-bottom: 1px solid #e9efec;
    }

    .setting-row:first-child {
        padding-top: 0;
    }

    .setting-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .setting-title {
        color: var(--connector-text);
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 2px;
    }

    .setting-description {
        color: var(--connector-muted);
        font-size: 10px;
    }

    .form-check-input {
        width: 39px;
        height: 21px;
        margin-top: 0;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--connector-primary);
        border-color: var(--connector-primary);
    }

    /* Footer */
    .form-footer {
        margin-top: 27px;
        padding-top: 20px;
        border-top: 1px solid var(--connector-border);
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 9px 17px;
        border: 1px solid var(--connector-border);
        background: #fff;
        color: var(--connector-text);
        border-radius: 9px;
        font-size: 12px;
        font-weight: 750;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: #f6f8f7;
        color: var(--connector-text);
    }

    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 42px;
        padding: 9px 18px;
        border: 0;
        background: var(--connector-primary-dark);
        color: #fff;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
    }

    .btn-save:hover {
        background: var(--connector-primary);
        color: #fff;
    }

    .btn-save:disabled {
        opacity: .7;
        cursor: not-allowed;
    }

    .alert-errors {
        background: #fff1f1;
        border: 1px solid #f2d0d0;
        color: #963d3d;
        border-radius: 10px;
        font-size: 12px;
        margin-bottom: 22px;
    }

    /* Current status */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 9px;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 800;
        margin-top: 7px;
    }

    .status-active {
        background: #e8f5ef;
        color: #26704d;
    }

    .status-inactive {
        background: #f3eeee;
        color: #8a5555;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* Summary */
    .summary-card {
        background: var(--connector-primary-dark);
        color: #fff;
        border-radius: 16px;
        padding: 21px;
        position: sticky;
        top: 20px;
    }

    .summary-eyebrow {
        color: #a8c6b9;
        text-transform: uppercase;
        letter-spacing: .11em;
        font-size: 10px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .summary-title {
        font-size: 17px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .summary-description {
        color: #c7d6d0;
        font-size: 11px;
        line-height: 1.6;
        margin-bottom: 19px;
    }

    .summary-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 11px 0;
        border-top: 1px solid rgba(255,255,255,.10);
    }

    .summary-item-icon {
        color: #9fc0b2;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .summary-item-title {
        font-size: 11px;
        font-weight: 800;
        margin-bottom: 2px;
    }

    .summary-item-text {
        color: #b9cbc4;
        font-size: 10px;
        line-height: 1.45;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .summary-card {
            position: static;
            margin-top: 20px;
        }
    }

    @media (max-width: 575px) {
        .service-edit-page {
            padding-top: 18px;
        }

        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .page-title {
            font-size: 23px;
        }

        .form-card-body {
            padding: 17px;
        }

        .form-footer {
            flex-direction: column-reverse;
        }

        .btn-save,
        .btn-cancel {
            width: 100%;
        }
    }
</style>


<div class="service-edit-page">

    <div class="container-fluid px-3 px-lg-4">

        {{-- Page Header --}}
        <div class="page-header">

            <div>
                <div class="page-eyebrow">
                    Service Management
                </div>

                <h1 class="page-title">
                    Edit Service
                </h1>

                <p class="page-description">
                    Update the service information and marketplace settings.
                </p>
            </div>

            <a href="{{ route('admin.all_services') }}" class="back-btn">

                <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M19 12H5M11 18L5 12L11 6"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

                Back to Services

            </a>

        </div>


        {{-- Validation Errors --}}
        @if($errors->any())

            <div class="alert alert-errors">

                <div class="fw-bold mb-2">
                    Please correct the following:
                </div>

                <ul class="mb-0 ps-3">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <div class="row g-4">

            {{-- Main Form --}}
            <div class="col-xl-9">

                <div class="form-card">

                    <div class="form-card-header">

                        <h2 class="form-card-title">
                            Service Information
                        </h2>

                        <p class="form-card-subtitle">
                            Update the information customers see when viewing this service.
                        </p>

                    </div>


                    <div class="form-card-body">

                        <form
                            action="{{ route('admin.update_service', $service->id) }}"
                            method="POST"
                            enctype="multipart/form-data"
                            id="serviceForm"
                        >

                            @csrf
                            @method('PUT')


                            {{-- Basic Information --}}
                            <div class="form-section">

                                <div class="section-heading">

                                    <div class="section-icon">

                                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">

                                            <path
                                                d="M5 6.5C5 5.67 5.67 5 6.5 5H17.5C18.33 5 19 5.67 19 6.5V17.5C19 18.33 18.33 19 17.5 19H6.5C5.67 19 5 18.33 5 17.5V6.5Z"
                                                stroke="currentColor"
                                                stroke-width="1.7"
                                            />

                                            <path
                                                d="M8 9H16M8 12H16M8 15H13"
                                                stroke="currentColor"
                                                stroke-width="1.7"
                                                stroke-linecap="round"
                                            />

                                        </svg>

                                    </div>

                                    <div>

                                        <h3 class="section-title">
                                            Basic Information
                                        </h3>

                                        <p class="section-description">
                                            Update the service identity and classification.
                                        </p>

                                    </div>

                                </div>


                                <div class="row g-3">

                                    {{-- Service Name --}}
                                    <div class="col-md-8">

                                        <label class="form-label">

                                            Service Name
                                            <span class="required">*</span>

                                        </label>

                                        <input
                                            type="text"
                                            name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $service->name) }}"
                                            placeholder="e.g. Professional House Cleaning"
                                            required
                                        >

                                        @error('name')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    {{-- Provider --}}
                                    <div class="col-md-4">

                                        <label class="form-label">

                                            Service Provider
                                            <span class="required">*</span>

                                        </label>

                                        <select
                                            name="service_provider_id"
                                            class="form-select @error('service_provider_id') is-invalid @enderror"
                                            required
                                        >

                                            <option value="">
                                                Select provider
                                            </option>

                                            @foreach($sprovider as $provider)

                                                <option
                                                    value="{{ $provider->id }}"
                                                    @selected(
                                                        old(
                                                            'service_provider_id',
                                                            $service->service_provider_id
                                                        ) == $provider->id
                                                    )
                                                >
                                                    {{ $provider->user?->name ?? 'Provider #' . $provider->id }}
                                                </option>

                                            @endforeach

                                        </select>

                                        @error('service_provider_id')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    {{-- Category --}}
                                    <div class="col-md-6">

                                        <label class="form-label">

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

                                            @foreach($categories as $category)

                                                <option
                                                    value="{{ $category->id }}"
                                                    @selected(
                                                        old(
                                                            'service_category_id',
                                                            $service->service_category_id
                                                        ) == $category->id
                                                    )
                                                >
                                                    {{ $category->name }}
                                                </option>

                                            @endforeach

                                        </select>

                                        @error('service_category_id')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    {{-- Subcategory --}}
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Subcategory
                                        </label>

                                        <select
                                            name="sub_category_id"
                                            id="sub_category_id"
                                            class="form-select @error('sub_category_id') is-invalid @enderror"
                                        >

                                            <option value="">
                                                Select subcategory
                                            </option>

                                            @foreach($subcategories as $subcategory)

                                                <option
                                                    value="{{ $subcategory->id }}"
                                                    data-category="{{ $subcategory->service_category_id }}"
                                                    @selected(
                                                        old(
                                                            'sub_category_id',
                                                            $service->sub_category_id
                                                        ) == $subcategory->id
                                                    )
                                                >
                                                    {{ $subcategory->name }}
                                                </option>

                                            @endforeach

                                        </select>

                                        <div class="small-help">
                                            Select a category first to see its subcategories.
                                        </div>

                                        @error('sub_category_id')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>

                                </div>

                            </div>


                            {{-- Pricing --}}
                            <div class="form-section">

                                <div class="section-heading">

                                    <div class="section-icon">

                                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">

                                            <path
                                                d="M7 4H17L20 7L12 20L4 7L7 4Z"
                                                stroke="currentColor"
                                                stroke-width="1.7"
                                                stroke-linejoin="round"
                                            />

                                            <path
                                                d="M4 7H20M9 4L12 7L15 4"
                                                stroke="currentColor"
                                                stroke-width="1.7"
                                                stroke-linejoin="round"
                                            />

                                        </svg>

                                    </div>

                                    <div>

                                        <h3 class="section-title">
                                            Pricing & Availability
                                        </h3>

                                        <p class="section-description">
                                            Update the price, duration and service location.
                                        </p>

                                    </div>

                                </div>


                                <div class="row g-3">

                                    {{-- Price --}}
                                    <div class="col-md-4">

                                        <label class="form-label">

                                            Price
                                            <span class="required">*</span>

                                        </label>

                                        <div class="price-input-group">

                                            <span class="price-currency">
                                                RWF
                                            </span>

                                            <input
                                                type="number"
                                                name="price"
                                                min="0"
                                                step="0.01"
                                                class="form-control price-input @error('price') is-invalid @enderror"
                                                value="{{ old('price', $service->price) }}"
                                                placeholder="0"
                                                required
                                            >

                                        </div>

                                        @error('price')

                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    {{-- Discount --}}
                                    <div class="col-md-4">

                                        <label class="form-label">
                                            Discount
                                        </label>

                                        <input
                                            type="number"
                                            name="discount"
                                            min="0"
                                            step="0.01"
                                            class="form-control @error('discount') is-invalid @enderror"
                                            value="{{ old('discount', $service->discount ?? 0) }}"
                                            placeholder="0"
                                        >

                                        @error('discount')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    {{-- Discount Type --}}
                                    <div class="col-md-4">

                                        <label class="form-label">
                                            Discount Type
                                        </label>

                                        <select
                                            name="discount_type"
                                            class="form-select @error('discount_type') is-invalid @enderror"
                                        >

                                            <option value="">
                                                No discount type
                                            </option>

                                            <option
                                                value="percentage"
                                                @selected(
                                                    old(
                                                        'discount_type',
                                                        $service->discount_type
                                                    ) === 'percentage'
                                                )
                                            >
                                                Percentage (%)
                                            </option>

                                            <option
                                                value="fixed"
                                                @selected(
                                                    old(
                                                        'discount_type',
                                                        $service->discount_type
                                                    ) === 'fixed'
                                                )
                                            >
                                                Fixed Amount
                                            </option>

                                        </select>

                                        @error('discount_type')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    {{-- Duration --}}
                                    <div class="col-md-6">

                                        <label class="form-label">

                                            Duration
                                            <span class="required">*</span>

                                        </label>

                                        <input
                                            type="text"
                                            name="duration"
                                            class="form-control @error('duration') is-invalid @enderror"
                                            value="{{ old('duration', $service->duration) }}"
                                            placeholder="e.g. 2 hours"
                                            required
                                        >

                                        @error('duration')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    {{-- Location --}}
                                    <div class="col-md-6">

                                        <label class="form-label">

                                            Service Location
                                            <span class="required">*</span>

                                        </label>

                                        <input
                                            type="text"
                                            name="location"
                                            class="form-control @error('location') is-invalid @enderror"
                                            value="{{ old('location', $service->location) }}"
                                            placeholder="e.g. Kigali, Rwanda"
                                            required
                                        >

                                        @error('location')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>

                                </div>

                            </div>


                            {{-- Description --}}
                            <div class="form-section">

                                <div class="section-heading">

                                    <div class="section-icon">

                                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">

                                            <path
                                                d="M5 5H19V19H5V5Z"
                                                stroke="currentColor"
                                                stroke-width="1.7"
                                                stroke-linejoin="round"
                                            />

                                            <path
                                                d="M8 9H16M8 12H16M8 15H13"
                                                stroke="currentColor"
                                                stroke-width="1.7"
                                                stroke-linecap="round"
                                            />

                                        </svg>

                                    </div>

                                    <div>

                                        <h3 class="section-title">
                                            Service Description
                                        </h3>

                                        <p class="section-description">
                                            Explain what customers should expect from this service.
                                        </p>

                                    </div>

                                </div>


                                <label class="form-label">

                                    Description
                                    <span class="required">*</span>

                                </label>

                                <textarea
                                    name="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Describe the service, what is included, how it works and what customers should expect..."
                                    required
                                >{{ old('description', $service->description) }}</textarea>

                                @error('description')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- Inclusion / Exclusion --}}
                            <div class="form-section">

                                <div class="section-heading">

                                    <div class="section-icon">

                                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">

                                            <path
                                                d="M5 12L9 16L19 6"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />

                                        </svg>

                                    </div>

                                    <div>

                                        <h3 class="section-title">
                                            What's Included
                                        </h3>

                                        <p class="section-description">
                                            Clearly define what customers receive and what is excluded.
                                        </p>

                                    </div>

                                </div>


                                <div class="row g-3">

                                    {{-- Included --}}
                                    <div class="col-md-6">

                                        <label class="form-label">

                                            Included
                                            <span class="required">*</span>

                                        </label>

                                        <textarea
                                            name="inclusion"
                                            class="form-control @error('inclusion') is-invalid @enderror"
                                            placeholder="Professional cleaning&#10;Cleaning materials&#10;Equipment"
                                            required
                                        >{{ old('inclusion', $service->inclusion) }}</textarea>

                                        <div class="list-help">
                                            Enter one item per line.
                                        </div>

                                        @error('inclusion')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    {{-- Excluded --}}
                                    <div class="col-md-6">

                                        <label class="form-label">

                                            Excluded
                                            <span class="required">*</span>

                                        </label>

                                        <textarea
                                            name="exclusion"
                                            class="form-control @error('exclusion') is-invalid @enderror"
                                            placeholder="Special equipment&#10;Transport fees&#10;Additional materials"
                                            required
                                        >{{ old('exclusion', $service->exclusion) }}</textarea>

                                        <div class="list-help">
                                            Enter one item per line.
                                        </div>

                                        @error('exclusion')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>

                                </div>

                            </div>


                            {{-- Image --}}
                            <div class="form-section">

                                <div class="section-heading">

                                    <div class="section-icon">

                                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">

                                            <rect
                                                x="4"
                                                y="4"
                                                width="16"
                                                height="16"
                                                rx="2"
                                                stroke="currentColor"
                                                stroke-width="1.7"
                                            />

                                            <circle
                                                cx="9"
                                                cy="9"
                                                r="1.5"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            />

                                            <path
                                                d="M5 17L10 12L13 15L15 13L19 17"
                                                stroke="currentColor"
                                                stroke-width="1.7"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />

                                        </svg>

                                    </div>

                                    <div>

                                        <h3 class="section-title">
                                            Service Image
                                        </h3>

                                        <p class="section-description">
                                            Keep the existing image or upload a replacement.
                                        </p>

                                    </div>

                                </div>


                                <div class="image-upload">

                                    {{-- Current Image --}}
                                    @if(!empty($service->image))

                                        <div
                                            class="current-image"
                                            id="currentImageContainer"
                                        >

                                            <img
                                                src="{{ asset('storage/' . $service->image) }}"
                                                alt="{{ $service->name }}"
                                                id="currentImage"
                                                onerror="this.parentElement.style.display='none';"
                                            >

                                            <div class="current-image-label">
                                                Current Image
                                            </div>

                                        </div>

                                    @endif


                                    {{-- New Image Preview --}}
                                    <img
                                        src=""
                                        alt="New service preview"
                                        id="imagePreview"
                                        class="image-preview"
                                    >


                                    {{-- Upload Area --}}
                                    <div
                                        class="upload-placeholder"
                                        id="uploadPlaceholder"
                                    >

                                        <div class="upload-icon">

                                            <svg width="23" height="23" viewBox="0 0 24 24" fill="none">

                                                <path
                                                    d="M12 16V4M12 4L8 8M12 4L16 8"
                                                    stroke="currentColor"
                                                    stroke-width="1.7"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                />

                                                <path
                                                    d="M5 13V18C5 19.1 5.9 20 7 20H17C18.1 20 19 19.1 19 18V13"
                                                    stroke="currentColor"
                                                    stroke-width="1.7"
                                                    stroke-linecap="round"
                                                />

                                            </svg>

                                        </div>


                                        <div class="upload-title">
                                            Replace service image
                                        </div>

                                        <div class="upload-text">
                                            JPG, PNG or WEBP · Maximum 2MB
                                        </div>

                                        <label
                                            for="serviceImage"
                                            class="upload-btn"
                                        >
                                            Choose New Image
                                        </label>

                                    </div>


                                    <input
                                        type="file"
                                        name="image"
                                        id="serviceImage"
                                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                        class="d-none @error('image') is-invalid @enderror"
                                    >

                                </div>


                                @error('image')

                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>

                                @enderror


                                <div class="small-help">
                                    Leave the image unchanged if you do not want to replace it.
                                </div>

                            </div>


                            {{-- Publishing Settings --}}
                            <div class="form-section">

                                <div class="section-heading">

                                    <div class="section-icon">

                                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">

                                            <path
                                                d="M12 8V12L14.5 14.5"
                                                stroke="currentColor"
                                                stroke-width="1.7"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="8"
                                                stroke="currentColor"
                                                stroke-width="1.7"
                                            />

                                        </svg>

                                    </div>

                                    <div>

                                        <h3 class="section-title">
                                            Publishing Settings
                                        </h3>

                                        <p class="section-description">
                                            Control the visibility and marketplace placement of this service.
                                        </p>

                                    </div>

                                </div>


                                <div class="settings-box">

                                    {{-- Status --}}
                                    <div class="setting-row">

                                        <div>

                                            <div class="setting-title">
                                                Active Service
                                            </div>

                                            <div class="setting-description">
                                                Allow customers to view and use this service.
                                            </div>

                                            @if($service->status)

                                                <span class="status-badge status-active">
                                                    <span class="status-dot"></span>
                                                    Currently Active
                                                </span>

                                            @else

                                                <span class="status-badge status-inactive">
                                                    <span class="status-dot"></span>
                                                    Currently Inactive
                                                </span>

                                            @endif

                                        </div>


                                        <div class="form-check form-switch">

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="status"
                                                value="1"
                                                id="status"
                                                @checked(old('status', $service->status))
                                            >

                                        </div>

                                    </div>


                                    {{-- Featured --}}
                                    <div class="setting-row">

                                        <div>

                                            <div class="setting-title">
                                                Featured Service
                                            </div>

                                            <div class="setting-description">
                                                Highlight this service in featured marketplace sections.
                                            </div>

                                        </div>


                                        <div class="form-check form-switch">

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="featured"
                                                value="1"
                                                id="featured"
                                                @checked(old('featured', $service->featured))
                                            >

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- Footer --}}
                            <div class="form-footer">

                                <a
                                    href="{{ route('admin.all_services') }}"
                                    class="btn-cancel"
                                >
                                    Cancel
                                </a>


                                <button
                                    type="submit"
                                    class="btn-save"
                                    id="updateButton"
                                >

                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none">

                                        <path
                                            d="M5 4H16L19 7V20H5V4Z"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                            stroke-linejoin="round"
                                        />

                                        <path
                                            d="M8 4V10H16V4M8 20V14H16V20"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                            stroke-linejoin="round"
                                        />

                                    </svg>

                                    Update Service

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>


            {{-- Right Information Panel --}}
            <div class="col-xl-3">

                <div class="summary-card">

                    <div class="summary-eyebrow">
                        Connector Marketplace
                    </div>

                    <div class="summary-title">
                        Keep your service accurate
                    </div>

                    <div class="summary-description">
                        Review the service information before saving. Accurate details help customers understand what they are booking.
                    </div>


                    {{-- Item --}}
                    <div class="summary-item">

                        <div class="summary-item-icon">

                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">

                                <path
                                    d="M5 12L9 16L19 6"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                            </svg>

                        </div>

                        <div>

                            <div class="summary-item-title">
                                Review the service name
                            </div>

                            <div class="summary-item-text">
                                Make sure the name clearly explains the service customers are booking.
                            </div>

                        </div>

                    </div>


                    {{-- Item --}}
                    <div class="summary-item">

                        <div class="summary-item-icon">

                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">

                                <path
                                    d="M12 21C16 17 19 14 19 10C19 6.69 16.31 4 13 4C9.69 4 7 6.69 7 10C7 14 10 17 12 21Z"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                />

                                <circle
                                    cx="13"
                                    cy="10"
                                    r="2"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                />

                            </svg>

                        </div>

                        <div>

                            <div class="summary-item-title">
                                Verify the location
                            </div>

                            <div class="summary-item-text">
                                Keep the service location accurate so customers know where it is available.
                            </div>

                        </div>

                    </div>


                    {{-- Item --}}
                    <div class="summary-item">

                        <div class="summary-item-icon">

                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">

                                <rect
                                    x="4"
                                    y="5"
                                    width="16"
                                    height="14"
                                    rx="2"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                />

                                <path
                                    d="M4 10H20"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                />

                                <path
                                    d="M8 15H12"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                />

                            </svg>

                        </div>

                        <div>

                            <div class="summary-item-title">
                                Check pricing
                            </div>

                            <div class="summary-item-text">
                                Confirm the current price, discount and discount type before updating.
                            </div>

                        </div>

                    </div>


                    {{-- Item --}}
                    <div class="summary-item">

                        <div class="summary-item-icon">

                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">

                                <rect
                                    x="4"
                                    y="4"
                                    width="16"
                                    height="16"
                                    rx="2"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                />

                                <path
                                    d="M5 16L10 11L13 14L15 12L19 16"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                            </svg>

                        </div>

                        <div>

                            <div class="summary-item-title">
                                Update the image
                            </div>

                            <div class="summary-item-text">
                                Replace the image only when you have a clearer or more relevant service image.
                            </div>

                        </div>

                    </div>


                    {{-- Item --}}
                    <div class="summary-item">

                        <div class="summary-item-icon">

                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">

                                <path
                                    d="M12 3V21M3 12H21"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                />

                            </svg>

                        </div>

                        <div>

                            <div class="summary-item-title">
                                Publishing status
                            </div>

                            <div class="summary-item-text">
                                Turn the service off when it should no longer be visible to customers.
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Category → Subcategory
    |--------------------------------------------------------------------------
    */

    const categorySelect =
        document.getElementById('service_category_id');

    const subcategorySelect =
        document.getElementById('sub_category_id');

    function filterSubcategories() {

        if (!categorySelect || !subcategorySelect) {
            return;
        }

        const categoryId =
            categorySelect.value;

        const options =
            subcategorySelect.querySelectorAll(
                'option[data-category]'
            );

        options.forEach(function (option) {

            const belongsToCategory =
                option.dataset.category === categoryId;

            option.hidden =
                !belongsToCategory;

            option.disabled =
                !belongsToCategory;

        });


        const selectedOption =
            subcategorySelect.options[
                subcategorySelect.selectedIndex
            ];


        if (
            selectedOption &&
            selectedOption.dataset.category &&
            selectedOption.dataset.category !== categoryId
        ) {
            subcategorySelect.value = '';
        }
    }


    if (categorySelect && subcategorySelect) {

        categorySelect.addEventListener(
            'change',
            filterSubcategories
        );

        filterSubcategories();

    }


    /*
    |--------------------------------------------------------------------------
    | Image Preview
    |--------------------------------------------------------------------------
    */

    const imageInput =
        document.getElementById('serviceImage');

    const imagePreview =
        document.getElementById('imagePreview');

    const uploadPlaceholder =
        document.getElementById('uploadPlaceholder');

    const currentImageContainer =
        document.getElementById('currentImageContainer');


    if (imageInput) {

        imageInput.addEventListener(
            'change',
            function () {

                const file =
                    this.files[0];


                if (!file) {

                    imagePreview.style.display = 'none';

                    imagePreview.src = '';

                    uploadPlaceholder.style.display = 'flex';

                    if (currentImageContainer) {
                        currentImageContainer.style.display = 'block';
                    }

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | File Size
                |--------------------------------------------------------------------------
                */

                if (file.size > 2 * 1024 * 1024) {

                    alert(
                        'The selected image is larger than 2MB.'
                    );

                    this.value = '';

                    imagePreview.style.display = 'none';

                    imagePreview.src = '';

                    uploadPlaceholder.style.display = 'flex';

                    if (currentImageContainer) {
                        currentImageContainer.style.display = 'block';
                    }

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | File Type
                |--------------------------------------------------------------------------
                */

                const allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];


                if (!allowedTypes.includes(file.type)) {

                    alert(
                        'Please select a JPG, PNG or WEBP image.'
                    );

                    this.value = '';

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Preview
                |--------------------------------------------------------------------------
                */

                const reader =
                    new FileReader();


                reader.onload =
                    function (event) {

                        imagePreview.src =
                            event.target.result;

                        imagePreview.style.display =
                            'block';

                        uploadPlaceholder.style.display =
                            'flex';


                        /*
                        |--------------------------------------------------------------------------
                        | Hide current image when replacement selected
                        |--------------------------------------------------------------------------
                        */

                        if (currentImageContainer) {

                            currentImageContainer.style.display =
                                'none';

                        }

                    };


                reader.readAsDataURL(file);

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Discount Validation
    |--------------------------------------------------------------------------
    */

    const discountInput =
        document.querySelector(
            '[name="discount"]'
        );

    const discountType =
        document.querySelector(
            '[name="discount_type"]'
        );


    if (discountInput && discountType) {

        function validateDiscount() {

            const value =
                parseFloat(
                    discountInput.value || 0
                );


            if (
                discountType.value === 'percentage' &&
                value > 100
            ) {

                discountInput.value = 100;

            }

        }


        discountInput.addEventListener(
            'input',
            validateDiscount
        );

        discountType.addEventListener(
            'change',
            validateDiscount
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Prevent Double Submission
    |--------------------------------------------------------------------------
    */

    const form =
        document.getElementById('serviceForm');

    if (form) {

        form.addEventListener(
            'submit',
            function () {

                const button =
                    document.getElementById(
                        'updateButton'
                    );


                if (button) {

                    button.disabled =
                        true;

                    button.innerHTML = `
                        <span
                            class="spinner-border spinner-border-sm"
                            role="status"
                            aria-hidden="true"
                        ></span>

                        Updating...
                    `;

                }

            }
        );

    }

});
</script>

@endsection