@extends('layouts.app')

@section('title', 'Edit Service')

@section('content')

@php
    $image = $service->image ?: 'default.png';

    $imagePath = public_path('image/services/' . $image);

    $imageUrl = file_exists($imagePath)
        ? asset('image/services/' . $image)
        : asset('image/services/default.png');
@endphp

<style>
    .service-edit-page {
        padding: 8px 0 35px;
    }

    /* --------------------------------------------------
       Header
    -------------------------------------------------- */

    .edit-header {
        background: linear-gradient(
            135deg,
            #254035 0%,
            #315646 50%,
            #6B9080 100%
        );
        border-radius: 20px;
        padding: 28px;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .edit-header::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,.06);
        right: -100px;
        top: -130px;
    }

    .edit-header-content {
        position: relative;
        z-index: 2;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: rgba(255,255,255,.78);
        text-decoration: none;
        font-size: 13px;
        margin-bottom: 16px;
    }

    .back-link:hover {
        color: #fff;
    }

    .edit-header h2 {
        font-size: 27px;
        font-weight: 750;
        margin: 0 0 6px;
    }

    .edit-header p {
        margin: 0;
        color: rgba(255,255,255,.76);
        font-size: 13px;
    }

    /* --------------------------------------------------
       Cards
    -------------------------------------------------- */

    .edit-card {
        background: #fff;
        border: 1px solid #edf0ef;
        border-radius: 18px;
        box-shadow: 0 4px 18px rgba(37,64,53,.045);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .edit-card-header {
        padding: 19px 22px;
        border-bottom: 1px solid #edf0ef;
    }

    .edit-card-title {
        color: #254035;
        font-size: 16px;
        font-weight: 700;
        margin: 0;
    }

    .edit-card-description {
        color: #8c9691;
        font-size: 12px;
        margin: 4px 0 0;
    }

    .edit-card-body {
        padding: 22px;
    }

    /* --------------------------------------------------
       Form
    -------------------------------------------------- */

    .form-label-custom {
        color: #3f4d46;
        font-size: 12px;
        font-weight: 650;
        margin-bottom: 7px;
    }

    .required {
        color: #b85c5c;
    }

    .form-control-custom,
    .form-select-custom {
        border: 1px solid #e2e8e4;
        border-radius: 9px;
        min-height: 43px;
        color: #35443c;
        font-size: 13px;
        background-color: #fff;
        box-shadow: none;
    }

    .form-control-custom:focus,
    .form-select-custom:focus {
        border-color: #6B9080;
        box-shadow: 0 0 0 3px rgba(107,144,128,.10);
    }

    textarea.form-control-custom {
        min-height: 130px;
        resize: vertical;
        line-height: 1.6;
    }

    .form-text-custom {
        color: #929b97;
        font-size: 11px;
        margin-top: 5px;
    }

    .invalid-feedback {
        font-size: 11px;
    }

    /* --------------------------------------------------
       Image
    -------------------------------------------------- */

    .current-image-wrapper {
        background: #f5f8f6;
        border: 1px solid #e8eeea;
        border-radius: 14px;
        overflow: hidden;
        position: relative;
        margin-bottom: 13px;
    }

    .current-image {
        width: 100%;
        height: 260px;
        object-fit: cover;
        display: block;
    }

    .image-label {
        position: absolute;
        left: 12px;
        top: 12px;
        background: rgba(37,64,53,.88);
        color: #fff;
        border-radius: 7px;
        padding: 6px 9px;
        font-size: 10px;
        font-weight: 600;
    }

    .file-upload {
        border: 1px dashed #ccd8d2;
        border-radius: 11px;
        padding: 15px;
        background: #fafcfb;
    }

    .file-upload input {
        font-size: 12px;
    }

    /* --------------------------------------------------
       Input groups
    -------------------------------------------------- */

    .input-group-custom .input-group-text {
        background: #f6f9f7;
        border: 1px solid #e2e8e4;
        color: #6f7b75;
        font-size: 12px;
    }

    .input-group-custom .form-control {
        border-color: #e2e8e4;
        font-size: 13px;
    }

    .input-group-custom .form-control:focus {
        border-color: #6B9080;
        box-shadow: none;
    }

    /* --------------------------------------------------
       Checkbox
    -------------------------------------------------- */

    .status-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #e7ece9;
        border-radius: 11px;
        padding: 13px 15px;
        background: #fafcfb;
    }

    .status-title {
        color: #254035;
        font-size: 13px;
        font-weight: 650;
    }

    .status-description {
        color: #8c9691;
        font-size: 11px;
        margin-top: 2px;
    }

    .form-switch .form-check-input {
        width: 40px;
        height: 21px;
        cursor: pointer;
    }

    .form-switch .form-check-input:checked {
        background-color: #254035;
        border-color: #254035;
    }

    /* --------------------------------------------------
       Tips
    -------------------------------------------------- */

    .tips-card {
        background: #f5f9f7;
        border: 1px solid #e5ede8;
        border-radius: 14px;
        padding: 17px;
    }

    .tips-title {
        color: #254035;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .tips-list {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .tips-list li {
        display: flex;
        gap: 8px;
        color: #68736e;
        font-size: 11px;
        line-height: 1.5;
        margin-bottom: 8px;
    }

    .tips-list li:last-child {
        margin-bottom: 0;
    }

    .tips-list i {
        color: #6B9080;
        margin-top: 1px;
    }

    /* --------------------------------------------------
       Bottom actions
    -------------------------------------------------- */

    .form-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
        background: #fff;
        border: 1px solid #edf0ef;
        border-radius: 16px;
        padding: 17px 20px;
        box-shadow: 0 4px 18px rgba(37,64,53,.04);
    }

    .btn-cancel {
        border: 1px solid #dfe6e2;
        background: #fff;
        color: #68736e;
        border-radius: 9px;
        padding: 10px 17px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: #f7f9f8;
        color: #254035;
    }

    .btn-save {
        background: #254035;
        border: none;
        color: #fff;
        border-radius: 9px;
        padding: 10px 20px;
        font-size: 12px;
        font-weight: 650;
    }

    .btn-save:hover {
        background: #1d332a;
        color: #fff;
    }

    @media (max-width: 767px) {
        .edit-header {
            padding: 22px;
        }

        .edit-header h2 {
            font-size: 22px;
        }

        .edit-card-body {
            padding: 18px;
        }

        .current-image {
            height: 220px;
        }

        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .form-actions > div {
            width: 100%;
        }

        .btn-cancel,
        .btn-save {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
</style>


<div class="service-edit-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="edit-header">

        <div class="edit-header-content">

            <a
                href="{{ route('serviceProvider.show', $service->slug) }}"
                class="back-link"
            >
                <i class="mdi mdi-arrow-left"></i>
                Back to Service
            </a>

            <h2>Edit Service</h2>

            <p>
                Update your service information, pricing, availability and presentation.
            </p>

        </div>

    </div>


    {{-- =====================================================
         VALIDATION ERRORS
    ====================================================== --}}

    @if($errors->any())

        <div class="alert alert-danger border-0 shadow-sm mb-4">

            <div class="d-flex align-items-start">

                <i class="mdi mdi-alert-circle-outline fs-5 me-2"></i>

                <div>

                    <strong>
                        Please correct the following:
                    </strong>

                    <ul class="mb-0 mt-2 ps-3">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    <form
        action="{{ route('serviceProvider.update', $service->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf
        @method('PUT')


        <div class="row">

            {{-- =================================================
                 MAIN CONTENT
            ================================================== --}}

            <div class="col-lg-8">

                {{-- Service Information --}}
                <div class="edit-card">

                    <div class="edit-card-header">

                        <h4 class="edit-card-title">
                            Service Information
                        </h4>

                        <p class="edit-card-description">
                            Basic information customers will see about your service.
                        </p>

                    </div>

                    <div class="edit-card-body">

                        <div class="row g-3">

                            {{-- Name --}}
                            <div class="col-12">

                                <label class="form-label-custom">
                                    Service Name
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $service->name) }}"
                                    class="form-control form-control-custom @error('name') is-invalid @enderror"
                                    placeholder="e.g. Professional Web Design"
                                    required
                                >

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Category --}}
                            <div class="col-md-6">

                                <label class="form-label-custom">
                                    Category
                                    <span class="required">*</span>
                                </label>

                                <select
                                    name="service_category_id"
                                    id="service_category_id"
                                    class="form-select form-select-custom @error('service_category_id') is-invalid @enderror"
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
                                                $service->service_category_id
                                            ) == $category->id ? 'selected' : '' }}
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

                                <label class="form-label-custom">
                                    Subcategory
                                </label>

                                <select
                                    name="sub_category_id"
                                    id="sub_category_id"
                                    class="form-select form-select-custom @error('sub_category_id') is-invalid @enderror"
                                >

                                    <option value="">
                                        Select subcategory
                                    </option>

                                    @foreach($subcategories as $subcategory)

                                        <option
                                            value="{{ $subcategory->id }}"
                                            data-category="{{ $subcategory->service_category_id ?? $subcategory->category_id }}"
                                            {{ old(
                                                'sub_category_id',
                                                $service->sub_category_id
                                            ) == $subcategory->id ? 'selected' : '' }}
                                        >
                                            {{ $subcategory->name }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('sub_category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Description --}}
                            <div class="col-12">

                                <label class="form-label-custom">
                                    Description
                                    <span class="required">*</span>
                                </label>

                                <textarea
                                    name="description"
                                    class="form-control form-control-custom @error('description') is-invalid @enderror"
                                    placeholder="Describe what your service provides..."
                                    required
                                >{{ old('description', $service->description) }}</textarea>

                                <div class="form-text-custom">
                                    Give customers a clear understanding of what this service offers.
                                </div>

                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Pricing --}}
                <div class="edit-card">

                    <div class="edit-card-header">

                        <h4 class="edit-card-title">
                            Pricing & Duration
                        </h4>

                        <p class="edit-card-description">
                            Set your service price and optional discount.
                        </p>

                    </div>

                    <div class="edit-card-body">

                        <div class="row g-3">

                            {{-- Price --}}
                            <div class="col-md-6">

                                <label class="form-label-custom">
                                    Price
                                    <span class="required">*</span>
                                </label>

                                <div class="input-group input-group-custom">

                                    <span class="input-group-text">
                                        RWF
                                    </span>

                                    <input
                                        type="number"
                                        name="price"
                                        value="{{ old('price', $service->price) }}"
                                        class="form-control @error('price') is-invalid @enderror"
                                        min="0"
                                        step="0.01"
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


                            {{-- Duration --}}
                            <div class="col-md-6">

                                <label class="form-label-custom">
                                    Duration
                                </label>

                                <input
                                    type="text"
                                    name="duration"
                                    value="{{ old('duration', $service->duration) }}"
                                    class="form-control form-control-custom @error('duration') is-invalid @enderror"
                                    placeholder="e.g. 2 hours, 3 days"
                                >

                                @error('duration')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Discount --}}
                            <div class="col-md-6">

                                <label class="form-label-custom">
                                    Discount
                                </label>

                                <div class="input-group input-group-custom">

                                    <input
                                        type="number"
                                        name="discount"
                                        value="{{ old('discount', $service->discount) }}"
                                        class="form-control @error('discount') is-invalid @enderror"
                                        min="0"
                                        step="0.01"
                                        placeholder="0"
                                    >

                                    <select
                                        name="discount_type"
                                        class="form-select"
                                        style="max-width:130px;"
                                    >

                                        <option
                                            value="percentage"
                                            {{ old(
                                                'discount_type',
                                                $service->discount_type
                                            ) == 'percentage' ? 'selected' : '' }}
                                        >
                                            %
                                        </option>

                                        <option
                                            value="fixed"
                                            {{ old(
                                                'discount_type',
                                                $service->discount_type
                                            ) == 'fixed' ? 'selected' : '' }}
                                        >
                                            RWF
                                        </option>

                                    </select>

                                </div>

                                @error('discount')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Service Details --}}
                <div class="edit-card">

                    <div class="edit-card-header">

                        <h4 class="edit-card-title">
                            Service Details
                        </h4>

                        <p class="edit-card-description">
                            Specify what is included and excluded from the service.
                        </p>

                    </div>

                    <div class="edit-card-body">

                        <div class="row g-3">

                            {{-- Inclusion --}}
                            <div class="col-md-6">

                                <label class="form-label-custom">
                                    What's Included
                                </label>

                                <textarea
                                    name="inclusion"
                                    class="form-control form-control-custom @error('inclusion') is-invalid @enderror"
                                    placeholder="Website design|Responsive layout|Basic SEO"
                                >{{ old('inclusion', $service->inclusion) }}</textarea>

                                <div class="form-text-custom">
                                    Separate each item using <strong>|</strong>
                                </div>

                                @error('inclusion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Exclusion --}}
                            <div class="col-md-6">

                                <label class="form-label-custom">
                                    What's Excluded
                                </label>

                                <textarea
                                    name="exclusion"
                                    class="form-control form-control-custom @error('exclusion') is-invalid @enderror"
                                    placeholder="Domain registration|Hosting|Third-party fees"
                                >{{ old('exclusion', $service->exclusion) }}</textarea>

                                <div class="form-text-custom">
                                    Separate each item using <strong>|</strong>
                                </div>

                                @error('exclusion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Location --}}
                <div class="edit-card">

                    <div class="edit-card-header">

                        <h4 class="edit-card-title">
                            Service Location
                        </h4>

                        <p class="edit-card-description">
                            Tell customers where this service is available.
                        </p>

                    </div>

                    <div class="edit-card-body">

                        <label class="form-label-custom">
                            Location
                        </label>

                        <div class="input-group input-group-custom">

                            <span class="input-group-text">
                                <i class="mdi mdi-map-marker-outline"></i>
                            </span>

                            <input
                                type="text"
                                name="location"
                                value="{{ old('location', $service->location) }}"
                                class="form-control @error('location') is-invalid @enderror"
                                placeholder="e.g. Kigali, Rwanda"
                            >

                        </div>

                        @error('location')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- =================================================
                 SIDEBAR
            ================================================== --}}

            <div class="col-lg-4">

                {{-- Image --}}
                <div class="edit-card">

                    <div class="edit-card-header">

                        <h4 class="edit-card-title">
                            Service Image
                        </h4>

                        <p class="edit-card-description">
                            Use a clear image representing your service.
                        </p>

                    </div>

                    <div class="edit-card-body">

                        <div class="current-image-wrapper">

                            <span class="image-label">
                                Current Image
                            </span>

                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $service->name }}"
                                class="current-image"
                                id="imagePreview"
                                onerror="this.onerror=null;this.src='{{ asset('image/services/default.png') }}';"
                            >

                        </div>


                        <div class="file-upload">

                            <label class="form-label-custom">
                                Replace Image
                            </label>

                            <input
                                type="file"
                                name="image"
                                id="serviceImage"
                                class="form-control @error('image') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                            >

                            <div class="form-text-custom">
                                JPG, PNG or WebP. Recommended: 1200 × 800px.
                            </div>

                            @error('image')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Status --}}
                <div class="edit-card">

                    <div class="edit-card-header">

                        <h4 class="edit-card-title">
                            Service Status
                        </h4>

                        <p class="edit-card-description">
                            Control whether this service is active.
                        </p>

                    </div>

                    <div class="edit-card-body">

                        <div class="status-box">

                            <div>

                                <div class="status-title">
                                    Active Service
                                </div>

                                <div class="status-description">
                                    Allow this service to appear publicly.
                                </div>

                            </div>

                            <div class="form-check form-switch mb-0">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="status"
                                    value="1"
                                    id="status"
                                    {{ old('status', $service->status) ? 'checked' : '' }}
                                >

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Service Summary --}}
                <div class="edit-card">

                    <div class="edit-card-header">

                        <h4 class="edit-card-title">
                            Current Service
                        </h4>

                    </div>

                    <div class="edit-card-body">

                        <div class="mb-3">

                            <div class="form-text-custom mb-1">
                                Service
                            </div>

                            <div style="
                                color:#254035;
                                font-size:13px;
                                font-weight:650;
                            ">
                                {{ $service->name }}
                            </div>

                        </div>


                        <div class="mb-3">

                            <div class="form-text-custom mb-1">
                                Category
                            </div>

                            <div style="
                                color:#68736e;
                                font-size:12px;
                            ">
                                {{ $service->category?->name ?? 'Not specified' }}
                            </div>

                        </div>


                        <div>

                            <div class="form-text-custom mb-1">
                                Last Updated
                            </div>

                            <div style="
                                color:#68736e;
                                font-size:12px;
                            ">
                                {{ $service->updated_at?->format('d M Y, H:i') ?? 'Not available' }}
                            </div>

                        </div>

                    </div>

                </div>


                {{-- Tips --}}
                <div class="tips-card mb-4">

                    <div class="tips-title">
                        Tips for a good service listing
                    </div>

                    <ul class="tips-list">

                        <li>
                            <i class="mdi mdi-check-circle-outline"></i>
                            Use a clear and descriptive service name.
                        </li>

                        <li>
                            <i class="mdi mdi-check-circle-outline"></i>
                            Explain exactly what customers receive.
                        </li>

                        <li>
                            <i class="mdi mdi-check-circle-outline"></i>
                            Keep pricing accurate and up to date.
                        </li>

                        <li>
                            <i class="mdi mdi-check-circle-outline"></i>
                            Use a high-quality service image.
                        </li>

                    </ul>

                </div>

            </div>

        </div>


        {{-- =====================================================
             ACTIONS
        ====================================================== --}}

        <div class="form-actions">

            <div>

                <a
                    href="{{ route('serviceProvider.show', $service->slug) }}"
                    class="btn-cancel"
                >
                    <i class="mdi mdi-close me-1"></i>
                    Cancel
                </a>

            </div>

            <div class="d-flex gap-2">

                <a
                    href="{{ route('serviceProvider.index') }}"
                    class="btn-cancel"
                >
                    <i class="mdi mdi-view-list-outline me-1"></i>
                    Services
                </a>

                <button
                    type="submit"
                    class="btn btn-save"
                >
                    <i class="mdi mdi-content-save-outline me-1"></i>
                    Save Changes
                </button>

            </div>

        </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Image Preview
    |--------------------------------------------------------------------------
    */

    const imageInput = document.getElementById('serviceImage');
    const imagePreview = document.getElementById('imagePreview');

    if (imageInput && imagePreview) {

        imageInput.addEventListener('change', function (event) {

            const file = event.target.files[0];

            if (!file) {
                return;
            }

            if (!file.type.startsWith('image/')) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(file);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Filter Subcategories by Category
    |--------------------------------------------------------------------------
    */

    const categorySelect = document.getElementById('service_category_id');
    const subcategorySelect = document.getElementById('sub_category_id');

    if (categorySelect && subcategorySelect) {

        function filterSubcategories() {

            const categoryId = categorySelect.value;

            const options = subcategorySelect.querySelectorAll('option');

            options.forEach(function (option, index) {

                if (index === 0) {
                    option.hidden = false;
                    return;
                }

                const optionCategory =
                    option.getAttribute('data-category');

                if (!categoryId || optionCategory === categoryId) {

                    option.hidden = false;

                } else {

                    option.hidden = true;

                    if (option.selected) {
                        subcategorySelect.value = '';
                    }

                }

            });

        }

        categorySelect.addEventListener(
            'change',
            filterSubcategories
        );

        filterSubcategories();

    }

});
</script>

@endsection