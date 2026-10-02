@extends('layouts.app')

@section('title', 'Edit Service Provider')

@push('styles')

<style>

    :root {
        --connector-primary: #254035;
        --connector-accent: #6B9080;
        --connector-light: #eef4f1;
        --connector-bg: #f6f8f7;
        --connector-border: #dfe8e4;
        --connector-muted: #71807a;
        --connector-danger: #c0392b;
        --connector-warning: #b7791f;
        --connector-success: #2e7d5b;
    }

    .provider-edit-page {
        min-height: calc(100vh - 70px);
        background: var(--connector-bg);
        padding: 28px 0 50px;
    }

    .provider-edit-container {
        max-width: 1250px;
    }

    /* Header */

    .page-header {
        margin-bottom: 24px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--connector-muted);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .back-link:hover {
        color: var(--connector-primary);
    }

    .page-header h1 {
        color: var(--connector-primary);
        font-size: 27px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .page-header p {
        color: var(--connector-muted);
        font-size: 14px;
        margin: 0;
    }

    /* Card */

    .form-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(37, 64, 53, .05);
        overflow: hidden;
    }

    .form-section {
        padding: 25px;
        border-bottom: 1px solid var(--connector-border);
    }

    .form-section:last-child {
        border-bottom: 0;
    }

    /* Section */

    .section-header {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        margin-bottom: 22px;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 11px;
        background: var(--connector-light);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .section-header h3 {
        color: var(--connector-primary);
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 3px;
    }

    .section-header p {
        color: var(--connector-muted);
        font-size: 12px;
        margin: 0;
    }

    /* Form */

    .form-label {
        color: var(--connector-primary);
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .required {
        color: var(--connector-danger);
    }

    .form-control,
    .form-select {
        min-height: 46px;
        border: 1px solid #dce5e1;
        border-radius: 10px;
        font-size: 13px;
        color: #33433c;
        box-shadow: none;
        padding: 10px 13px;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--connector-accent);
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .12);
    }

    .form-control::placeholder {
        color: #a1aaa6;
    }

    .form-text {
        color: var(--connector-muted);
        font-size: 11px;
        margin-top: 6px;
    }

    .invalid-feedback {
        font-size: 12px;
    }

    /* Password */

    .password-wrapper {
        position: relative;
    }

    .password-wrapper .form-control {
        padding-right: 44px;
    }

    .password-toggle {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        border: 0;
        background: transparent;
        color: var(--connector-muted);
        padding: 4px;
    }

    .password-toggle:hover {
        color: var(--connector-primary);
    }

    /* Image */

    .image-upload-box {
        border: 1px dashed #b9cbc3;
        border-radius: 14px;
        padding: 20px;
        background: #fafcfb;
    }

    .image-preview-wrapper {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 18px;
    }

    .image-preview {
        width: 110px;
        height: 110px;
        border-radius: 15px;
        object-fit: cover;
        background: var(--connector-light);
        border: 1px solid var(--connector-border);
        display: block;
    }

    .image-current-title {
        color: var(--connector-primary);
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .image-current-text {
        color: var(--connector-muted);
        font-size: 11px;
        line-height: 1.6;
    }

    .upload-title {
        color: var(--connector-primary);
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .upload-description {
        color: var(--connector-muted);
        font-size: 11px;
        margin-bottom: 12px;
    }

    /* Status */

    .status-card {
        border: 1px solid var(--connector-border);
        border-radius: 13px;
        padding: 16px;
        background: #fafcfb;
    }

    .status-option {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .status-option .form-check-input {
        width: 18px;
        height: 18px;
        margin-top: 0;
        cursor: pointer;
    }

    .status-option label {
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        color: var(--connector-primary);
    }

    .status-description {
        color: var(--connector-muted);
        font-size: 11px;
        margin-top: 5px;
        margin-left: 28px;
    }

    /* Account info */

    .account-meta {
        background: var(--connector-light);
        border: 1px solid #dce9e3;
        border-radius: 12px;
        padding: 14px 16px;
    }

    .account-meta-item {
        display: flex;
        align-items: center;
        gap: 9px;
        color: var(--connector-primary);
        font-size: 12px;
    }

    .account-meta-item i {
        color: var(--connector-accent);
        font-size: 17px;
    }

    /* Notice */

    .provider-notice {
        background: var(--connector-light);
        border: 1px solid #dce9e3;
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        gap: 10px;
        color: var(--connector-primary);
        font-size: 12px;
        line-height: 1.6;
    }

    .provider-notice i {
        font-size: 18px;
        color: var(--connector-accent);
    }

    /* Footer */

    .form-footer {
        padding: 20px 25px;
        background: #fafcfb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .footer-left {
        color: var(--connector-muted);
        font-size: 11px;
    }

    .footer-actions {
        display: flex;
        gap: 10px;
    }

    .btn-cancel {
        background: #fff;
        color: var(--connector-primary);
        border: 1px solid #d7e1dc;
        border-radius: 10px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-cancel:hover {
        background: var(--connector-light);
        color: var(--connector-primary);
    }

    .btn-submit {
        background: var(--connector-primary);
        color: #fff;
        border: 0;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-submit:hover {
        background: #1b3028;
        color: #fff;
    }

    /* Alert */

    .validation-alert {
        border: 0;
        border-radius: 12px;
        font-size: 13px;
    }

    /* Responsive */

    @media (max-width: 767px) {

        .provider-edit-page {
            padding: 18px 0 35px;
        }

        .form-section {
            padding: 20px;
        }

        .form-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .footer-actions {
            flex-direction: column;
        }

        .footer-actions .btn {
            width: 100%;
        }

        .page-header h1 {
            font-size: 23px;
        }

        .image-preview-wrapper {
            align-items: flex-start;
            flex-direction: column;
        }

    }

</style>

@endpush


@section('content')

<div class="provider-edit-page">

    <div class="container-fluid provider-edit-container">

        {{-- Page Header --}}

        <div class="page-header">

            <a
                href="{{ route('admin.ShowServiceProviders', $provider->id) }}"
                class="back-link"
            >
                <i class="mdi mdi-arrow-left"></i>
                Back to Provider Profile
            </a>

            <h1>
                Edit Service Provider
            </h1>

            <p>
                Update the provider's account, professional information,
                profile image and status.
            </p>

        </div>


        {{-- Validation Errors --}}

        @if($errors->any())

            <div class="alert alert-danger validation-alert mb-4">

                <div class="fw-semibold mb-2">
                    Please correct the following errors:
                </div>

                <ul class="mb-0 ps-3">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Success Message --}}

        @if(session('message'))

            <div class="alert alert-success validation-alert mb-4">

                <i class="mdi mdi-check-circle-outline me-1"></i>

                {{ session('message') }}

            </div>

        @endif


        <form
            action="{{ route('admin.UpdateServiceProvider', $provider->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            @method('PUT')


            <div class="form-card">


                {{-- ACCOUNT INFORMATION --}}

                <div class="form-section">

                    <div class="section-header">

                        <div class="section-icon">
                            <i class="mdi mdi-account-outline"></i>
                        </div>

                        <div>

                            <h3>
                                Account Information
                            </h3>

                            <p>
                                Update the provider's login information
                            </p>

                        </div>

                    </div>


                    <div class="row g-4">

                        {{-- Name --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Full Name
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $provider->user?->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter provider's full name"
                                required
                            >

                            @error('name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Email --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Email Address
                                <span class="required">*</span>
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $provider->user?->email) }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="provider@example.com"
                                required
                            >

                            @error('email')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Password --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                New Password
                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Leave blank to keep current password"
                                    autocomplete="new-password"
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    onclick="togglePassword('password', this)"
                                >

                                    <i class="mdi mdi-eye-outline"></i>

                                </button>

                            </div>

                            <div class="form-text">
                                Leave this field empty if you do not want to
                                change the password.
                            </div>

                            @error('password')

                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Confirm Password --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Confirm New Password
                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    placeholder="Repeat new password"
                                    autocomplete="new-password"
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    onclick="togglePassword('password_confirmation', this)"
                                >

                                    <i class="mdi mdi-eye-outline"></i>

                                </button>

                            </div>

                        </div>


                        {{-- Account metadata --}}

                        <div class="col-12">

                            <div class="account-meta">

                                <div class="row g-3">

                                    <div class="col-md-4">

                                        <div class="account-meta-item">

                                            <i class="mdi mdi-account-badge-outline"></i>

                                            <span>
                                                Account Type:
                                                <strong>
                                                    SVP
                                                </strong>
                                            </span>

                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <div class="account-meta-item">

                                            <i class="mdi mdi-identifier"></i>

                                            <span>
                                                Provider ID:
                                                <strong>
                                                    #{{ $provider->id }}
                                                </strong>
                                            </span>

                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <div class="account-meta-item">

                                            <i class="mdi mdi-calendar-outline"></i>

                                            <span>
                                                Created:
                                                <strong>
                                                    {{ $provider->created_at?->format('d M Y') }}
                                                </strong>
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- PROFESSIONAL INFORMATION --}}

                <div class="form-section">

                    <div class="section-header">

                        <div class="section-icon">
                            <i class="mdi mdi-briefcase-outline"></i>
                        </div>

                        <div>

                            <h3>
                                Professional Information
                            </h3>

                            <p>
                                Update the provider's professional profile
                            </p>

                        </div>

                    </div>


                    <div class="row g-4">


                        {{-- Category --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Service Category
                            </label>

                            <select
                                name="service_category_id"
                                class="form-select @error('service_category_id') is-invalid @enderror"
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
                                                $provider->service_category_id
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


                        {{-- Location --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Service Location
                            </label>

                            <input
                                type="text"
                                name="service_locations"
                                value="{{ old(
                                    'service_locations',
                                    $provider->service_locations
                                ) }}"
                                class="form-control @error('service_locations') is-invalid @enderror"
                                placeholder="e.g. Kigali, Gasabo"
                            >

                            @error('service_locations')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Skills --}}

                        <div class="col-12">

                            <label class="form-label">
                                Skills & Expertise
                            </label>

                            <textarea
                                name="skills"
                                class="form-control @error('skills') is-invalid @enderror"
                                placeholder="e.g. Plumbing, pipe installation, maintenance"
                            >{{ old('skills', $provider->skills) }}</textarea>

                            <div class="form-text">
                                Separate multiple skills using commas,
                                semicolons, or new lines.
                            </div>

                            @error('skills')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Qualification --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Qualification
                            </label>

                            <textarea
                                name="qualification"
                                class="form-control @error('qualification') is-invalid @enderror"
                                placeholder="Education, certifications, licenses..."
                            >{{ old(
                                'qualification',
                                $provider->qualification
                            ) }}</textarea>

                            @error('qualification')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Experience --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Experience
                            </label>

                            <textarea
                                name="experience"
                                class="form-control @error('experience') is-invalid @enderror"
                                placeholder="Describe professional experience..."
                            >{{ old(
                                'experience',
                                $provider->experience
                            ) }}</textarea>

                            @error('experience')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- About --}}

                        <div class="col-12">

                            <label class="form-label">
                                About Provider
                            </label>

                            <textarea
                                name="about"
                                class="form-control @error('about') is-invalid @enderror"
                                rows="6"
                                placeholder="Write a professional description of the provider..."
                            >{{ old(
                                'about',
                                $provider->about
                            ) }}</textarea>

                            @error('about')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>


                {{-- PROFILE IMAGE --}}

                <div class="form-section">

                    <div class="section-header">

                        <div class="section-icon">
                            <i class="mdi mdi-camera-outline"></i>
                        </div>

                        <div>

                            <h3>
                                Profile Image
                            </h3>

                            <p>
                                Update the provider's profile image
                            </p>

                        </div>

                    </div>


                    <div class="image-upload-box">


                        <div class="image-preview-wrapper">

                            @php

                                $currentImage =
                                    $provider->image &&
                                    file_exists(
                                        public_path(
                                            'image/profile/' .
                                            $provider->image
                                        )
                                    )
                                    ? asset(
                                        'image/profile/' .
                                        $provider->image
                                    )
                                    : asset(
                                        'assets/images/sproviders/avatar.jpg'
                                    );

                            @endphp


                            <img
                                src="{{ $currentImage }}"
                                id="imagePreview"
                                class="image-preview"
                                alt="Provider profile image"
                            >


                            <div>

                                <div class="image-current-title">
                                    Current Profile Image
                                </div>

                                <div class="image-current-text">

                                    Select a new image below to replace
                                    the current profile photo.

                                    <br>

                                    JPG, JPEG or PNG.
                                    Maximum size: 2MB.

                                </div>

                            </div>

                        </div>


                        <div class="upload-title">
                            Replace Profile Photo
                        </div>

                        <div class="upload-description">
                            Choose a professional image for the provider.
                        </div>


                        <input
                            type="file"
                            name="image"
                            id="providerImage"
                            class="form-control @error('image') is-invalid @enderror"
                            accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                            onchange="previewImage(this)"
                        >


                        @error('image')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


                {{-- STATUS --}}

                <div class="form-section">

                    <div class="section-header">

                        <div class="section-icon">
                            <i class="mdi mdi-shield-check-outline"></i>
                        </div>

                        <div>

                            <h3>
                                Provider Status
                            </h3>

                            <p>
                                Control the provider's availability on
                                the platform
                            </p>

                        </div>

                    </div>


                    <div class="status-card">

                        <div class="row g-4">


                            {{-- Pending --}}

                            <div class="col-md-4">

                                <div class="status-option">

                                    <input
                                        type="radio"
                                        name="status"
                                        id="statusPending"
                                        value="pending"
                                        class="form-check-input"
                                        @checked(
                                            old(
                                                'status',
                                                $provider->status
                                            ) === 'pending'
                                        )
                                    >

                                    <label for="statusPending">
                                        Pending
                                    </label>

                                </div>

                                <div class="status-description">
                                    Provider is awaiting approval.
                                </div>

                            </div>


                            {{-- Approved --}}

                            <div class="col-md-4">

                                <div class="status-option">

                                    <input
                                        type="radio"
                                        name="status"
                                        id="statusApproved"
                                        value="approved"
                                        class="form-check-input"
                                        @checked(
                                            old(
                                                'status',
                                                $provider->status
                                            ) === 'approved'
                                        )
                                    >

                                    <label for="statusApproved">
                                        Approved
                                    </label>

                                </div>

                                <div class="status-description">
                                    Provider can operate on the platform.
                                </div>

                            </div>


                            {{-- Rejected --}}

                            <div class="col-md-4">

                                <div class="status-option">

                                    <input
                                        type="radio"
                                        name="status"
                                        id="statusRejected"
                                        value="rejected"
                                        class="form-check-input"
                                        @checked(
                                            old(
                                                'status',
                                                $provider->status
                                            ) === 'rejected'
                                        )
                                    >

                                    <label for="statusRejected">
                                        Rejected
                                    </label>

                                </div>

                                <div class="status-description">
                                    Provider has been rejected.
                                </div>

                            </div>


                        </div>

                    </div>

                </div>


                {{-- NOTICE --}}

                <div class="form-section">

                    <div class="provider-notice">

                        <i class="mdi mdi-information-outline"></i>

                        <div>

                            <strong>
                                Account information
                            </strong>

                            <br>

                            This profile is linked to the provider's
                            <strong>SVP</strong> user account.
                            Changing the email or password will update
                            the provider's login credentials.

                        </div>

                    </div>

                </div>


                {{-- FOOTER --}}

                <div class="form-footer">

                    <div class="footer-left">

                        Last updated:

                        <strong>
                            {{ $provider->updated_at?->format('d M Y, H:i') }}
                        </strong>

                    </div>


                    <div class="footer-actions">

                        <a
                            href="{{ route(
                                'admin.ShowServiceProviders',
                                $provider->id
                            ) }}"
                            class="btn btn-cancel"
                        >
                            Cancel
                        </a>


                        <button
                            type="submit"
                            class="btn btn-submit"
                        >

                            <i class="mdi mdi-content-save-outline me-1"></i>

                            Save Changes

                        </button>

                    </div>

                </div>


            </div>

        </form>

    </div>

</div>


@push('scripts')

<script>

    function togglePassword(inputId, button) {

        const input =
            document.getElementById(inputId);

        const icon =
            button.querySelector('i');


        if (input.type === 'password') {

            input.type = 'text';

            icon.classList.remove(
                'mdi-eye-outline'
            );

            icon.classList.add(
                'mdi-eye-off-outline'
            );

        } else {

            input.type = 'password';

            icon.classList.remove(
                'mdi-eye-off-outline'
            );

            icon.classList.add(
                'mdi-eye-outline'
            );

        }

    }


    function previewImage(input) {

        const preview =
            document.getElementById('imagePreview');


        if (
            !input.files ||
            !input.files[0]
        ) {
            return;
        }


        const file =
            input.files[0];


        if (
            !file.type.startsWith('image/')
        ) {
            return;
        }


        const reader =
            new FileReader();


        reader.onload =
            function (event) {

                preview.src =
                    event.target.result;

            };


        reader.readAsDataURL(file);

    }

</script>

@endpush

@endsection