@extends('layouts.app')

@section('title', 'Edit Job')

@section('content')

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-dark: #254035;
        --connector-soft: #eef5f2;
        --connector-border: #e2e9e5;
        --connector-text: #26332e;
        --connector-muted: #78857f;
        --connector-danger: #b94b4b;
    }

    .edit-job-page {
        padding: 28px 0 50px;
    }

    /* =========================================================
       HEADER
    ========================================================== */

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-heading {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .back-button {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--connector-border);
        border-radius: 9px;
        background: #fff;
        color: var(--connector-dark);
        text-decoration: none;
        transition: .2s ease;
        flex-shrink: 0;
    }

    .back-button:hover {
        background: var(--connector-soft);
        color: var(--connector-primary);
        border-color: var(--connector-primary);
        text-decoration: none;
    }

    .page-heading h1 {
        margin: 0;
        color: var(--connector-dark);
        font-size: 26px;
        font-weight: 700;
        letter-spacing: -.4px;
    }

    .page-heading p {
        margin: 5px 0 0;
        color: var(--connector-muted);
        font-size: 13px;
    }

    .view-job-button {
        min-height: 40px;
        padding: 0 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1px solid var(--connector-border);
        border-radius: 8px;
        background: #fff;
        color: var(--connector-dark);
        font-size: 12px;
        font-weight: 650;
        text-decoration: none;
        transition: .2s ease;
    }

    .view-job-button:hover {
        background: var(--connector-soft);
        border-color: var(--connector-primary);
        color: var(--connector-primary);
        text-decoration: none;
    }

    /* =========================================================
       LAYOUT
    ========================================================== */

    .job-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 22px;
        align-items: start;
    }

    .job-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 15px;
        overflow: hidden;
    }

    .card-section {
        padding: 24px;
        border-bottom: 1px solid var(--connector-border);
    }

    .card-section:last-child {
        border-bottom: 0;
    }

    /* =========================================================
       SECTION HEADING
    ========================================================== */

    .section-heading {
        display: flex;
        align-items: center;
        gap: 11px;
        margin-bottom: 20px;
    }

    .section-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .section-heading h2 {
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

    /* =========================================================
       FORM
    ========================================================== */

    .form-label {
        display: block;
        color: var(--connector-dark);
        font-size: 13px;
        font-weight: 650;
        margin-bottom: 7px;
    }

    .required {
        color: var(--connector-danger);
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 17px;
    }

    .form-control,
    .form-select {
        width: 100%;
        min-height: 44px;
        border: 1px solid #dce5e0;
        border-radius: 9px;
        color: var(--connector-text);
        background: #fff;
        font-size: 13px;
        padding: 10px 12px;
        transition: border-color .2s, box-shadow .2s;
    }

    textarea.form-control {
        min-height: 145px;
        resize: vertical;
        line-height: 1.65;
    }

    textarea.small-textarea {
        min-height: 125px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--connector-primary);
        box-shadow: 0 0 0 .16rem rgba(107, 144, 128, .12);
        outline: none;
    }

    .form-control::placeholder {
        color: #a2aca7;
    }

    .field-help {
        color: var(--connector-muted);
        font-size: 11px;
        margin-top: 6px;
    }

    .invalid-feedback {
        display: block;
        color: var(--connector-danger);
        font-size: 11px;
        margin-top: 5px;
    }

    .is-invalid {
        border-color: #d88989 !important;
    }

    /* =========================================================
       SIDEBAR
    ========================================================== */

    .sidebar-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 15px;
        overflow: hidden;
    }

    .sidebar-header {
        padding: 18px 20px;
        border-bottom: 1px solid var(--connector-border);
    }

    .sidebar-header h3 {
        margin: 0;
        color: var(--connector-dark);
        font-size: 15px;
        font-weight: 700;
    }

    .sidebar-header p {
        margin: 4px 0 0;
        color: var(--connector-muted);
        font-size: 11px;
        line-height: 1.5;
    }

    .sidebar-body {
        padding: 20px;
    }

    /* =========================================================
       PROVIDER PREVIEW
    ========================================================== */

    .provider-preview {
        margin-top: 12px;
        padding: 13px;
        border-radius: 10px;
        background: var(--connector-soft);
        display: none;
        align-items: center;
        gap: 11px;
    }

    .provider-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: var(--connector-primary);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .provider-preview-name {
        color: var(--connector-dark);
        font-size: 12px;
        font-weight: 700;
    }

    .provider-preview-text {
        color: var(--connector-muted);
        font-size: 10px;
        margin-top: 2px;
    }

    /* =========================================================
       CURRENT JOB INFO
    ========================================================== */

    .current-job {
        margin-top: 16px;
        padding: 14px;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        background: #fafcfb;
    }

    .current-job-label {
        color: var(--connector-muted);
        font-size: 10px;
        margin-bottom: 4px;
    }

    .current-job-title {
        color: var(--connector-dark);
        font-size: 12px;
        font-weight: 700;
        line-height: 1.4;
    }

    .current-job-id {
        color: var(--connector-muted);
        font-size: 10px;
        margin-top: 5px;
    }

    /* =========================================================
       STATUS
    ========================================================== */

    .status-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
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
        min-height: 67px;
        padding: 10px;
        border: 1px solid var(--connector-border);
        border-radius: 9px;
        background: #fff;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 5px;
        text-align: center;
        transition: .2s ease;
    }

    .status-option label strong {
        font-size: 12px;
        color: var(--connector-dark);
    }

    .status-option label span {
        font-size: 10px;
        color: var(--connector-muted);
    }

    .status-option input:checked + label {
        border-color: var(--connector-primary);
        background: var(--connector-soft);
        box-shadow: 0 0 0 1px var(--connector-primary);
    }

    /* =========================================================
       TIPS
    ========================================================== */

    .tips {
        margin-top: 18px;
        padding: 15px;
        border-radius: 11px;
        background: #fafcfb;
        border: 1px solid var(--connector-border);
    }

    .tips-title {
        display: flex;
        align-items: center;
        gap: 7px;
        color: var(--connector-dark);
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .tips ul {
        padding-left: 17px;
        margin: 0;
    }

    .tips li {
        color: var(--connector-muted);
        font-size: 11px;
        line-height: 1.55;
        margin-bottom: 6px;
    }

    .tips li:last-child {
        margin-bottom: 0;
    }

    /* =========================================================
       ACTIONS
    ========================================================== */

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        padding: 18px 24px;
        background: #fafcfb;
        border-top: 1px solid var(--connector-border);
    }

    .btn-cancel,
    .btn-update {
        min-height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 650;
        text-decoration: none;
        transition: .2s ease;
    }

    .btn-cancel {
        border: 1px solid #dce4e0;
        background: #fff;
        color: #64736c;
    }

    .btn-cancel:hover {
        background: #f5f8f6;
        color: var(--connector-dark);
        text-decoration: none;
    }

    .btn-update {
        border: 0;
        background: var(--connector-primary);
        color: #fff;
        cursor: pointer;
    }

    .btn-update:hover {
        background: var(--connector-dark);
        color: #fff;
    }

    /* =========================================================
       ALERT
    ========================================================== */

    .error-summary {
        border: 1px solid #efcccc;
        border-radius: 10px;
        background: #fff5f5;
        color: #984848;
        padding: 13px 16px;
        margin-bottom: 20px;
        font-size: 12px;
    }

    .error-summary strong {
        font-size: 13px;
    }

    .error-summary ul {
        margin: 7px 0 0;
        padding-left: 18px;
    }

    .success-alert {
        border: 0;
        border-radius: 10px;
        background: #eaf6ef;
        color: #28714d;
        font-size: 13px;
        padding: 12px 15px;
        margin-bottom: 20px;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================== */

    @media (max-width: 1000px) {

        .job-layout {
            grid-template-columns: 1fr;
        }

        .job-sidebar {
            order: -1;
        }

    }

    @media (max-width: 700px) {

        .page-header {
            align-items: flex-start;
        }

        .page-heading h1 {
            font-size: 22px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .card-section {
            padding: 19px;
        }

        .form-actions {
            padding: 16px 19px;
        }

    }

    @media (max-width: 500px) {

        .page-header {
            flex-direction: column;
        }

        .view-job-button {
            width: 100%;
        }

        .status-options {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn-cancel,
        .btn-update {
            width: 100%;
        }

    }
</style>


<div class="container-fluid edit-job-page">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div class="page-header">

        <div class="page-heading">

            <a
                href="{{ route('admin.jobs') }}"
                class="back-button"
                title="Back to jobs"
            >
                <svg width="18" height="18"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">
                    <path d="M19 12H5"/>
                    <path d="m12 19-7-7 7-7"/>
                </svg>
            </a>

            <div>
                <h1>Edit Job</h1>

                <p>
                    Update the details, provider and publication status.
                </p>
            </div>

        </div>


        <a
            href="{{ route('admin.jobs.show', $job->id) }}"
            class="view-job-button"
        >

            <svg width="15" height="15"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">
                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>

            View Job

        </a>

    </div>


    {{-- =========================================================
         SUCCESS
    ========================================================== --}}

    @if(session('message'))

        <div class="success-alert">
            {{ session('message') }}
        </div>

    @endif


    {{-- =========================================================
         VALIDATION ERRORS
    ========================================================== --}}

    @if($errors->any())

        <div class="error-summary">

            <strong>
                Please correct the following errors:
            </strong>

            <ul>
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
        action="{{ route('admin.jobs.update', $job->id) }}"
        method="POST"
        id="editJobForm"
    >

        @csrf
        @method('PUT')


        <div class="job-layout">


            {{-- =================================================
                 LEFT
            ================================================== --}}

            <div class="job-card">


                {{-- =================================================
                     JOB INFORMATION
                ================================================== --}}

                <div class="card-section">

                    <div class="section-heading">

                        <div class="section-icon">

                            <svg width="18" height="18"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <rect x="3" y="7" width="18" height="13" rx="2"/>
                                <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            </svg>

                        </div>

                        <div>

                            <h2>Job Information</h2>

                            <p>
                                Update the main details of this opportunity.
                            </p>

                        </div>

                    </div>


                    {{-- Title --}}

                    <div class="form-group">

                        <label
                            for="title"
                            class="form-label"
                        >
                            Job Title
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $job->title) }}"
                            placeholder="e.g. Senior Customer Support Specialist"
                            maxlength="255"
                            required
                        >

                        @error('title')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Location / Type --}}

                    <div class="form-row">

                        <div class="form-group">

                            <label
                                for="location"
                                class="form-label"
                            >
                                Location
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="location"
                                id="location"
                                class="form-control @error('location') is-invalid @enderror"
                                value="{{ old('location', $job->location) }}"
                                placeholder="e.g. Kigali, Rwanda"
                                required
                            >

                            @error('location')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <div class="form-group">

                            <label
                                for="type"
                                class="form-label"
                            >
                                Job Type
                                <span class="required">*</span>
                            </label>

                            <select
                                name="type"
                                id="type"
                                class="form-select @error('type') is-invalid @enderror"
                                required
                            >

                                <option value="">
                                    Select job type
                                </option>

                                <option
                                    value="full-time"
                                    @selected(old('type', $job->type) === 'full-time')
                                >
                                    Full Time
                                </option>

                                <option
                                    value="part-time"
                                    @selected(old('type', $job->type) === 'part-time')
                                >
                                    Part Time
                                </option>

                                <option
                                    value="contract"
                                    @selected(old('type', $job->type) === 'contract')
                                >
                                    Contract
                                </option>

                                <option
                                    value="temporary"
                                    @selected(old('type', $job->type) === 'temporary')
                                >
                                    Temporary
                                </option>

                                <option
                                    value="internship"
                                    @selected(old('type', $job->type) === 'internship')
                                >
                                    Internship
                                </option>

                                <option
                                    value="remote"
                                    @selected(old('type', $job->type) === 'remote')
                                >
                                    Remote
                                </option>

                                <option
                                    value="hybrid"
                                    @selected(old('type', $job->type) === 'hybrid')
                                >
                                    Hybrid
                                </option>

                            </select>

                            @error('type')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- Description --}}

                    <div class="form-group">

                        <label
                            for="description"
                            class="form-label"
                        >
                            Job Description
                            <span class="required">*</span>
                        </label>

                        <textarea
                            name="description"
                            id="description"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Describe the role, organization, objectives and what the successful candidate will be doing..."
                            required
                        >{{ old('description', $job->description) }}</textarea>

                        <div class="field-help">
                            Provide enough information for applicants to understand the opportunity.
                        </div>

                        @error('description')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


                {{-- =================================================
                     REQUIREMENTS
                ================================================== --}}

                <div class="card-section">

                    <div class="section-heading">

                        <div class="section-icon">

                            <svg width="18" height="18"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path d="M9 11l3 3L22 4"/>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                            </svg>

                        </div>

                        <div>

                            <h2>Requirements & Responsibilities</h2>

                            <p>
                                Update the qualifications and duties for this role.
                            </p>

                        </div>

                    </div>


                    {{-- Requirements --}}

                    <div class="form-group">

                        <label
                            for="requirements"
                            class="form-label"
                        >
                            Requirements
                        </label>

                        <textarea
                            name="requirements"
                            id="requirements"
                            class="form-control small-textarea @error('requirements') is-invalid @enderror"
                            placeholder="List qualifications, skills, experience and other requirements..."
                        >{{ old('requirements', $job->requirements) }}</textarea>

                        <div class="field-help">
                            List qualifications, skills, experience and other requirements.
                        </div>

                        @error('requirements')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Responsibilities --}}

                    <div class="form-group">

                        <label
                            for="responsibilities"
                            class="form-label"
                        >
                            Responsibilities
                        </label>

                        <textarea
                            name="responsibilities"
                            id="responsibilities"
                            class="form-control small-textarea @error('responsibilities') is-invalid @enderror"
                            placeholder="Describe the key duties and responsibilities..."
                        >{{ old('responsibilities', $job->responsibilities) }}</textarea>

                        <div class="field-help">
                            Describe the key duties and responsibilities for this position.
                        </div>

                        @error('responsibilities')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


                {{-- =================================================
                     ACTIONS
                ================================================== --}}

                <div class="form-actions">

                    <a
                        href="{{ route('admin.jobs.show', $job->id) }}"
                        class="btn-cancel"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="btn-update"
                    >

                        <svg width="17" height="17"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/>
                            <path d="M17 21v-8H7v8"/>
                            <path d="M7 3v5h8"/>
                        </svg>

                        Update Job

                    </button>

                </div>

            </div>


            {{-- =================================================
                 RIGHT SIDEBAR
            ================================================== --}}

            <div class="job-sidebar">


                {{-- =================================================
                     PROVIDER
                ================================================== --}}

                <div class="sidebar-card">

                    <div class="sidebar-header">

                        <h3>Job Owner</h3>

                        <p>
                            Select the service provider responsible for this opportunity.
                        </p>

                    </div>


                    <div class="sidebar-body">

                        <div class="form-group">

                            <label
                                for="service_provider_id"
                                class="form-label"
                            >
                                Service Provider
                                <span class="required">*</span>
                            </label>

                            <select
                                name="service_provider_id"
                                id="service_provider_id"
                                class="form-select @error('service_provider_id') is-invalid @enderror"
                                required
                            >

                                <option value="">
                                    Select provider
                                </option>


                                @foreach($providers as $provider)

                                    <option
                                        value="{{ $provider->id }}"
                                        data-name="{{ $provider->user?->name ?? 'Unnamed provider' }}"
                                        @selected(
                                            old(
                                                'service_provider_id',
                                                $job->service_provider_id
                                            ) == $provider->id
                                        )
                                    >
                                        {{ $provider->user?->name ?? 'Unnamed provider' }}
                                    </option>

                                @endforeach

                            </select>


                            @error('service_provider_id')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Provider Preview --}}

                        <div
                            id="providerPreview"
                            class="provider-preview"
                        >

                            <div
                                id="providerAvatar"
                                class="provider-avatar"
                            >
                                —
                            </div>

                            <div>

                                <div
                                    id="providerName"
                                    class="provider-preview-name"
                                >
                                    Provider
                                </div>

                                <div class="provider-preview-text">
                                    Job owner
                                </div>

                            </div>

                        </div>


                        {{-- Current Job --}}

                        <div class="current-job">

                            <div class="current-job-label">
                                Editing
                            </div>

                            <div class="current-job-title">
                                {{ $job->title }}
                            </div>

                            <div class="current-job-id">
                                Job #{{ $job->id }}
                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     PUBLICATION
                ================================================== --}}

                <div
                    class="sidebar-card"
                    style="margin-top:18px;"
                >

                    <div class="sidebar-header">

                        <h3>Publication</h3>

                        <p>
                            Update the deadline and current job status.
                        </p>

                    </div>


                    <div class="sidebar-body">


                        {{-- Deadline --}}

                        <div class="form-group">

                            <label
                                for="deadline"
                                class="form-label"
                            >
                                Application Deadline
                                <span class="required">*</span>
                            </label>

                            <input
                                type="date"
                                name="deadline"
                                id="deadline"
                                class="form-control @error('deadline') is-invalid @enderror"
                                value="{{ old(
                                    'deadline',
                                    $job->deadline?->format('Y-m-d')
                                ) }}"
                                required
                            >

                            @error('deadline')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Status --}}

                        <div class="form-group">

                            <label class="form-label">

                                Status

                                <span class="required">*</span>

                            </label>


                            <div class="status-options">


                                {{-- Draft --}}

                                <div class="status-option">

                                    <input
                                        type="radio"
                                        id="statusDraft"
                                        name="status"
                                        value="draft"
                                        @checked(
                                            old(
                                                'status',
                                                $job->status
                                            ) === 'draft'
                                        )
                                    >

                                    <label for="statusDraft">

                                        <strong>Draft</strong>

                                        <span>
                                            Not visible
                                        </span>

                                    </label>

                                </div>


                                {{-- Pending --}}

                                <div class="status-option">

                                    <input
                                        type="radio"
                                        id="statusPending"
                                        name="status"
                                        value="pending"
                                        @checked(
                                            old(
                                                'status',
                                                $job->status
                                            ) === 'pending'
                                        )
                                    >

                                    <label for="statusPending">

                                        <strong>Pending</strong>

                                        <span>
                                            Needs review
                                        </span>

                                    </label>

                                </div>


                                {{-- Active --}}

                                <div class="status-option">

                                    <input
                                        type="radio"
                                        id="statusActive"
                                        name="status"
                                        value="active"
                                        @checked(
                                            old(
                                                'status',
                                                $job->status
                                            ) === 'active'
                                        )
                                    >

                                    <label for="statusActive">

                                        <strong>Active</strong>

                                        <span>
                                            Published
                                        </span>

                                    </label>

                                </div>


                                {{-- Closed --}}

                                <div class="status-option">

                                    <input
                                        type="radio"
                                        id="statusClosed"
                                        name="status"
                                        value="closed"
                                        @checked(
                                            old(
                                                'status',
                                                $job->status
                                            ) === 'closed'
                                        )
                                    >

                                    <label for="statusClosed">

                                        <strong>Closed</strong>

                                        <span>
                                            Unavailable
                                        </span>

                                    </label>

                                </div>


                            </div>


                            @error('status')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     TIPS
                ================================================== --}}

                <div class="tips">

                    <div class="tips-title">

                        <svg width="15" height="15"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 16v-4"/>
                            <path d="M12 8h.01"/>
                        </svg>

                        Before saving

                    </div>


                    <ul>

                        <li>
                            Confirm the job title is clear and specific.
                        </li>

                        <li>
                            Make sure the correct service provider is selected.
                        </li>

                        <li>
                            Review the application deadline.
                        </li>

                        <li>
                            Keep the requirements relevant to the position.
                        </li>

                        <li>
                            Set the appropriate publication status.
                        </li>

                    </ul>

                </div>


            </div>

        </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       PROVIDER PREVIEW
    ========================================================== */

    const providerSelect =
        document.getElementById('service_provider_id');

    const providerPreview =
        document.getElementById('providerPreview');

    const providerName =
        document.getElementById('providerName');

    const providerAvatar =
        document.getElementById('providerAvatar');


    function updateProviderPreview() {

        if (!providerSelect) {
            return;
        }

        const selectedOption =
            providerSelect.options[
                providerSelect.selectedIndex
            ];


        if (
            !selectedOption ||
            !selectedOption.value
        ) {
            providerPreview.style.display = 'none';
            return;
        }


        const name =
            selectedOption.getAttribute('data-name') ||
            selectedOption.textContent.trim();


        providerName.textContent = name;


        const words = name
            .trim()
            .split(/\s+/)
            .filter(Boolean);


        let initials = '';


        if (words.length >= 2) {

            initials =
                words[0].charAt(0) +
                words[words.length - 1].charAt(0);

        } else {

            initials =
                words[0]?.substring(0, 2) || 'P';

        }


        providerAvatar.textContent =
            initials.toUpperCase();


        providerPreview.style.display = 'flex';

    }


    providerSelect.addEventListener(
        'change',
        updateProviderPreview
    );


    updateProviderPreview();


    /* =========================================================
       DEADLINE VALIDATION
    ========================================================== */

    const deadlineInput =
        document.getElementById('deadline');


    if (deadlineInput) {

        deadlineInput.addEventListener(
            'change',
            function () {

                const today =
                    new Date()
                        .toISOString()
                        .split('T')[0];


                /*
                 * Do not block an existing expired deadline
                 * while simply editing an old job.
                 *
                 * A new deadline selected during editing
                 * must not be earlier than today.
                 */

                const originalDeadline =
                    @json(
                        $job->deadline?->format('Y-m-d')
                    );


                if (
                    this.value &&
                    this.value < today &&
                    this.value !== originalDeadline
                ) {

                    this.setCustomValidity(
                        'The application deadline cannot be in the past.'
                    );

                } else {

                    this.setCustomValidity('');

                }

            }
        );

    }


    /* =========================================================
       FORM SUBMIT
    ========================================================== */

    const form =
        document.getElementById('editJobForm');


    if (form) {

        form.addEventListener(
            'submit',
            function () {

                const submitButton =
                    form.querySelector(
                        '.btn-update'
                    );


                if (submitButton) {

                    submitButton.disabled = true;

                    submitButton.style.opacity = '.75';

                    submitButton.innerHTML = `
                        <svg width="16"
                             height="16"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             style="animation:spin .8s linear infinite;">
                            <path d="M12 2v4"/>
                            <path d="m16.24 7.76 2.83-2.83"/>
                            <path d="M18 12h4"/>
                            <path d="m16.24 16.24 2.83 2.83"/>
                            <path d="M12 18v4"/>
                            <path d="m7.76 16.24-2.83 2.83"/>
                            <path d="M6 12H2"/>
                            <path d="m7.76 7.76-2.83-2.83"/>
                        </svg>

                        Saving...
                    `;

                }

            }
        );

    }

});
</script>


<style>
@keyframes spin {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}
</style>

@endsection