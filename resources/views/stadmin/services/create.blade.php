@extends('layouts.app')

@section('title', 'Add Service')

@section('content')

@php
    $oldCategory = old('service_category_id');
    $oldSubcategory = old('sub_category_id');
@endphp

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="service-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('serviceProvider.index') }}"
                       class="back-button">
                        <i class="bi bi-arrow-left"></i>
                    </a>

                    <div>
                        <span class="header-label">
                            SERVICE MANAGEMENT
                        </span>

                        <h1 class="header-title mb-1">
                            Add New Service
                        </h1>

                        <p class="header-text mb-0">
                            Create a service that customers can discover
                            and request from your business.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('serviceProvider.index') }}"
                   class="btn btn-light header-action">
                    <i class="bi bi-grid me-2"></i>
                    My Services
                </a>
            </div>
        </div>
    </div>


    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <div class="d-flex align-items-start gap-3">
                <i class="bi bi-exclamation-triangle-fill fs-4"></i>

                <div>
                    <strong>Please correct the following errors:</strong>

                    <ul class="mb-0 mt-2 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif


    <form
        action="{{ route('serviceProvider.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        <div class="row g-4">

            {{-- LEFT --}}
            <div class="col-xl-8">

                {{-- Service Information --}}
                <div class="form-card mb-4">

                    <div class="card-heading">
                        <div class="heading-icon">
                            <i class="bi bi-briefcase"></i>
                        </div>

                        <div>
                            <h5>Service Information</h5>
                            <p>Basic information about your service.</p>
                        </div>
                    </div>

                    <div class="row g-4">

                        {{-- Service Name --}}
                        <div class="col-md-12">
                            <label class="form-label">
                                Service Name
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                placeholder="e.g. Website Design"
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

                            <label class="form-label">
                                Category
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="service_category_id"
                                id="serviceCategory"
                                class="form-select form-select-lg @error('service_category_id') is-invalid @enderror"
                                required
                            >

                                <option value="">
                                    Select Category
                                </option>

                                @foreach ($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        {{ $oldCategory == $category->id ? 'selected' : '' }}
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
                                id="serviceSubcategory"
                                class="form-select form-select-lg @error('sub_category_id') is-invalid @enderror"
                                disabled
                            >

                                <option value="">
                                    Select Subcategory
                                </option>

                                @foreach ($subcategories as $subcategory)

                                    <option
                                        value="{{ $subcategory->id }}"
                                        data-category="{{ $subcategory->service_category_id ?? $subcategory->category_id }}"
                                        {{ $oldSubcategory == $subcategory->id ? 'selected' : '' }}
                                    >
                                        {{ $subcategory->name }}
                                    </option>

                                @endforeach

                            </select>

                            <div
                                id="subcategoryHelp"
                                class="form-text"
                            >
                                Select a category first.
                            </div>

                            @error('sub_category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Description --}}
                        <div class="col-12">

                            <label class="form-label">
                                Description
                                <span class="text-danger">*</span>
                            </label>

                            <textarea
                                name="description"
                                rows="5"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Describe what your service offers..."
                                required
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Pricing --}}
                <div class="form-card mb-4">

                    <div class="card-heading">

                        <div class="heading-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>

                        <div>
                            <h5>Pricing & Duration</h5>
                            <p>Set the price and expected service duration.</p>
                        </div>

                    </div>

                    <div class="row g-4">

                        {{-- Price --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Price
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group input-group-lg">

                                <span class="input-group-text">
                                    RWF
                                </span>

                                <input
                                    type="number"
                                    name="price"
                                    value="{{ old('price') }}"
                                    min="0"
                                    step="0.01"
                                    class="form-control @error('price') is-invalid @enderror"
                                    placeholder="0"
                                    required
                                >

                            </div>

                            @error('price')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Duration --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Duration
                            </label>

                            <input
                                type="text"
                                name="duration"
                                value="{{ old('duration') }}"
                                class="form-control form-control-lg @error('duration') is-invalid @enderror"
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

                            <label class="form-label">
                                Discount
                            </label>

                            <input
                                type="number"
                                name="discount"
                                value="{{ old('discount') }}"
                                min="0"
                                step="0.01"
                                class="form-control form-control-lg @error('discount') is-invalid @enderror"
                                placeholder="0"
                            >

                            @error('discount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Discount Type --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Discount Type
                            </label>

                            <select
                                name="discount_type"
                                class="form-select form-select-lg"
                            >

                                <option value="">
                                    No Discount
                                </option>

                                <option
                                    value="percentage"
                                    {{ old('discount_type') === 'percentage' ? 'selected' : '' }}
                                >
                                    Percentage (%)
                                </option>

                                <option
                                    value="fixed"
                                    {{ old('discount_type') === 'fixed' ? 'selected' : '' }}
                                >
                                    Fixed Amount (RWF)
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                {{-- Service Details --}}
                <div class="form-card mb-4">

                    <div class="card-heading">

                        <div class="heading-icon">
                            <i class="bi bi-list-check"></i>
                        </div>

                        <div>
                            <h5>Service Details</h5>
                            <p>
                                Tell customers what is included and excluded.
                            </p>
                        </div>

                    </div>

                    <div class="row g-4">

                        {{-- Inclusion --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                What's Included
                            </label>

                            <textarea
                                name="inclusion"
                                rows="6"
                                class="form-control"
                                placeholder="Website setup | Mobile responsive design | Basic SEO"
                            >{{ old('inclusion') }}</textarea>

                            <small class="text-muted">
                                Separate items using <strong>|</strong>
                            </small>

                        </div>


                        {{-- Exclusion --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                What's Not Included
                            </label>

                            <textarea
                                name="exclusion"
                                rows="6"
                                class="form-control"
                                placeholder="Domain registration | Hosting | Paid plugins"
                            >{{ old('exclusion') }}</textarea>

                            <small class="text-muted">
                                Separate items using <strong>|</strong>
                            </small>

                        </div>


                        {{-- Location --}}
                        <div class="col-12">

                            <label class="form-label">
                                Service Location
                            </label>

                            <input
                                type="text"
                                name="location"
                                value="{{ old('location') }}"
                                class="form-control form-control-lg"
                                placeholder="e.g. Kigali, Rwanda"
                            >

                        </div>

                    </div>

                </div>


                {{-- Image --}}
                <div class="form-card mb-4">

                    <div class="card-heading">

                        <div class="heading-icon">
                            <i class="bi bi-image"></i>
                        </div>

                        <div>
                            <h5>Service Image</h5>
                            <p>
                                Add an attractive image representing your service.
                            </p>
                        </div>

                    </div>


                    <div class="image-upload-wrapper">

                        <div
                            class="image-preview"
                            id="imagePreview"
                        >
                            <div id="imagePlaceholder">

                                <i class="bi bi-cloud-arrow-up"></i>

                                <span>
                                    Upload service image
                                </span>

                                <small>
                                    JPG, PNG or WEBP · Max 5MB
                                </small>

                            </div>
                        </div>

                        <div class="mt-3">

                            <label
                                for="serviceImage"
                                class="btn btn-outline-primary"
                            >
                                <i class="bi bi-upload me-2"></i>
                                Choose Image
                            </label>

                            <input
                                type="file"
                                name="image"
                                id="serviceImage"
                                class="d-none"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                            <div
                                id="selectedFile"
                                class="small text-muted mt-2"
                            ></div>

                        </div>

                    </div>

                    @error('image')
                        <div class="text-danger small mt-2">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            {{-- RIGHT --}}
            <div class="col-xl-4">

                {{-- Publish --}}
                <div class="form-card mb-4">

                    <div class="card-heading">

                        <div class="heading-icon">
                            <i class="bi bi-eye"></i>
                        </div>

                        <div>
                            <h5>Visibility</h5>
                            <p>Control whether customers can see this service.</p>
                        </div>

                    </div>


                    <div class="status-box">

                        <div>

                            <strong>
                                Active Service
                            </strong>

                            <p>
                                Customers can see this service.
                            </p>

                        </div>

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="status"
                                value="1"
                                id="serviceStatus"
                                {{ old('status', true) ? 'checked' : '' }}
                            >

                        </div>

                    </div>

                </div>


                {{-- Summary --}}
                <div class="summary-card mb-4">

                    <div class="summary-header">
                        <span>
                            <i class="bi bi-info-circle me-2"></i>
                            Service Summary
                        </span>
                    </div>

                    <div class="summary-body">

                        <div class="summary-item">
                            <span>Name</span>
                            <strong id="summaryName">
                                New Service
                            </strong>
                        </div>

                        <div class="summary-item">
                            <span>Category</span>
                            <strong id="summaryCategory">
                                Not selected
                            </strong>
                        </div>

                        <div class="summary-item">
                            <span>Subcategory</span>
                            <strong id="summarySubcategory">
                                Not selected
                            </strong>
                        </div>

                        <div class="summary-item">
                            <span>Price</span>
                            <strong id="summaryPrice">
                                RWF 0
                            </strong>
                        </div>

                    </div>

                </div>


                {{-- Tips --}}
                <div class="tips-card">

                    <div class="tips-icon">
                        <i class="bi bi-lightbulb"></i>
                    </div>

                    <div>

                        <h6>
                            Tips for a good service
                        </h6>

                        <ul>
                            <li>Use a clear service name.</li>
                            <li>Choose the most relevant category.</li>
                            <li>Describe exactly what customers receive.</li>
                            <li>Use a high-quality service image.</li>
                            <li>Keep your pricing accurate.</li>
                        </ul>

                    </div>

                </div>

            </div>

        </div>


        {{-- Actions --}}
        <div class="form-actions mt-4">

            <a
                href="{{ route('serviceProvider.index') }}"
                class="btn btn-light btn-lg"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="btn btn-primary btn-lg px-5"
            >
                <i class="bi bi-check2-circle me-2"></i>
                Create Service
            </button>

        </div>

    </form>

</div>


<style>

:root {
    --connector-green: #6B9080;
    --connector-dark: #254035;
    --connector-light: #f4f8f6;
}


/* HEADER */

.service-header {
    background: linear-gradient(
        135deg,
        var(--connector-dark),
        var(--connector-green)
    );
    border-radius: 18px;
    padding: 30px;
    color: white;
}

.back-button {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    background: rgba(255,255,255,.15);
    color: white;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: .2s;
}

.back-button:hover {
    background: rgba(255,255,255,.25);
    color: white;
}

.header-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    opacity: .75;
}

.header-title {
    font-size: 30px;
    font-weight: 700;
}

.header-text {
    color: rgba(255,255,255,.78);
}

.header-action {
    border: 0;
    font-weight: 600;
}


/* CARDS */

.form-card,
.summary-card,
.tips-card {
    background: #fff;
    border: 1px solid #e8eeeb;
    border-radius: 16px;
    box-shadow: 0 5px 25px rgba(37,64,53,.05);
}

.form-card {
    padding: 28px;
}

.card-heading {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 28px;
}

.heading-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(107,144,128,.12);
    color: var(--connector-green);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.card-heading h5 {
    margin: 0;
    color: var(--connector-dark);
    font-weight: 700;
}

.card-heading p {
    margin: 3px 0 0;
    color: #7a8781;
    font-size: 13px;
}


/* FORM */

.form-label {
    color: var(--connector-dark);
    font-weight: 600;
    margin-bottom: 8px;
}

.form-control,
.form-select {
    border-color: #dfe8e3;
    border-radius: 10px;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--connector-green);
    box-shadow: 0 0 0 .2rem rgba(107,144,128,.12);
}

.input-group-text {
    background: var(--connector-light);
    border-color: #dfe8e3;
    color: var(--connector-dark);
    font-weight: 600;
}


/* STATUS */

.status-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--connector-light);
    padding: 18px;
    border-radius: 12px;
}

.status-box strong {
    color: var(--connector-dark);
}

.status-box p {
    margin: 4px 0 0;
    font-size: 13px;
    color: #7a8781;
}

.form-check-input {
    width: 2.7em;
    height: 1.4em;
    cursor: pointer;
}

.form-check-input:checked {
    background-color: var(--connector-green);
    border-color: var(--connector-green);
}


/* IMAGE */

.image-preview {
    min-height: 250px;
    border: 2px dashed #d7e3dd;
    border-radius: 14px;
    background: #f9fbfa;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

#imagePlaceholder {
    text-align: center;
    color: #8b9993;
}

#imagePlaceholder i {
    display: block;
    font-size: 45px;
    color: var(--connector-green);
    margin-bottom: 10px;
}

#imagePlaceholder span {
    display: block;
    font-weight: 600;
    color: var(--connector-dark);
}

#imagePlaceholder small {
    display: block;
    margin-top: 5px;
}


/* SUMMARY */

.summary-header {
    background: var(--connector-dark);
    color: white;
    padding: 17px 20px;
    border-radius: 16px 16px 0 0;
    font-weight: 600;
}

.summary-body {
    padding: 10px 20px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #edf1ef;
}

.summary-item:last-child {
    border-bottom: 0;
}

.summary-item span {
    color: #7b8782;
    font-size: 13px;
}

.summary-item strong {
    color: var(--connector-dark);
    font-size: 13px;
    text-align: right;
    max-width: 60%;
}


/* TIPS */

.tips-card {
    padding: 22px;
    display: flex;
    gap: 15px;
}

.tips-icon {
    width: 42px;
    height: 42px;
    min-width: 42px;
    border-radius: 11px;
    background: #fff6dd;
    color: #a87900;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tips-card h6 {
    color: var(--connector-dark);
    font-weight: 700;
}

.tips-card ul {
    padding-left: 18px;
    margin-bottom: 0;
}

.tips-card li {
    color: #6f7d76;
    font-size: 13px;
    margin-bottom: 7px;
}


/* ACTIONS */

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 20px 0;
    border-top: 1px solid #e8eeeb;
}

.btn-primary {
    background: var(--connector-dark);
    border-color: var(--connector-dark);
}

.btn-primary:hover {
    background: var(--connector-green);
    border-color: var(--connector-green);
}


/* RESPONSIVE */

@media (max-width: 767px) {

    .service-header {
        padding: 22px;
    }

    .header-title {
        font-size: 24px;
    }

    .form-card {
        padding: 20px;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .form-actions .btn {
        width: 100%;
    }

}

</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const category = document.getElementById('serviceCategory');
    const subcategory = document.getElementById('serviceSubcategory');
    const help = document.getElementById('subcategoryHelp');

    const nameInput = document.querySelector('[name="name"]');
    const priceInput = document.querySelector('[name="price"]');

    const summaryName = document.getElementById('summaryName');
    const summaryCategory = document.getElementById('summaryCategory');
    const summarySubcategory = document.getElementById('summarySubcategory');
    const summaryPrice = document.getElementById('summaryPrice');


    /*
    |--------------------------------------------------------------------------
    | Category → Subcategory
    |--------------------------------------------------------------------------
    */

    function loadSubcategories(keepSelected = false) {

        const selectedCategory = category.value;
        const currentSubcategory = "{{ $oldSubcategory }}";

        subcategory.disabled = true;

        subcategory.querySelectorAll('option').forEach(function (option) {

            if (!option.value) {
                option.hidden = false;
                option.selected = true;
                return;
            }

            const optionCategory = option.dataset.category;

            if (
                selectedCategory &&
                String(optionCategory) === String(selectedCategory)
            ) {

                option.hidden = false;

            } else {

                option.hidden = true;
                option.selected = false;

            }

        });


        if (!selectedCategory) {

            subcategory.disabled = true;

            help.textContent = 'Select a category first.';

            return;
        }


        const matchingOptions = Array.from(
            subcategory.options
        ).filter(function (option) {

            return (
                option.value &&
                !option.hidden
            );

        });


        if (matchingOptions.length > 0) {

            subcategory.disabled = false;

            help.textContent =
                matchingOptions.length +
                ' subcategor' +
                (matchingOptions.length === 1 ? 'y' : 'ies') +
                ' available.';

            if (keepSelected && currentSubcategory) {

                const selected = Array.from(
                    subcategory.options
                ).find(function (option) {

                    return (
                        option.value == currentSubcategory &&
                        !option.hidden
                    );

                });

                if (selected) {
                    selected.selected = true;
                }

            }

        } else {

            subcategory.disabled = true;

            help.textContent =
                'No subcategories available for this category.';

        }

        updateSummary();

    }


    category.addEventListener('change', function () {

        loadSubcategories(false);

    });


    /*
    |--------------------------------------------------------------------------
    | Image Preview
    |--------------------------------------------------------------------------
    */

    const imageInput = document.getElementById('serviceImage');
    const imagePreview = document.getElementById('imagePreview');
    const selectedFile = document.getElementById('selectedFile');

    imageInput.addEventListener('change', function () {

        const file = this.files[0];

        if (!file) {
            return;
        }

        selectedFile.textContent = file.name;

        const reader = new FileReader();

        reader.onload = function (event) {

            imagePreview.innerHTML = `
                <img
                    src="${event.target.result}"
                    alt="Service Preview"
                    style="
                        width:100%;
                        height:250px;
                        object-fit:cover;
                    "
                >
            `;

        };

        reader.readAsDataURL(file);

    });


    /*
    |--------------------------------------------------------------------------
    | Live Summary
    |--------------------------------------------------------------------------
    */

    function updateSummary() {

        summaryName.textContent =
            nameInput.value.trim() || 'New Service';


        const selectedCategory =
            category.options[category.selectedIndex];

        summaryCategory.textContent =
            selectedCategory && selectedCategory.value
                ? selectedCategory.textContent.trim()
                : 'Not selected';


        const selectedSubcategory =
            subcategory.options[subcategory.selectedIndex];

        summarySubcategory.textContent =
            selectedSubcategory &&
            selectedSubcategory.value &&
            !selectedSubcategory.hidden
                ? selectedSubcategory.textContent.trim()
                : 'Not selected';


        const price =
            parseFloat(priceInput.value || 0);

        summaryPrice.textContent =
            'RWF ' +
            price.toLocaleString();
    }


    nameInput.addEventListener(
        'input',
        updateSummary
    );

    priceInput.addEventListener(
        'input',
        updateSummary
    );

    subcategory.addEventListener(
        'change',
        updateSummary
    );


    /*
    |--------------------------------------------------------------------------
    | Initial Load
    |--------------------------------------------------------------------------
    */

    loadSubcategories(true);
    updateSummary();

});
</script>

@endsection