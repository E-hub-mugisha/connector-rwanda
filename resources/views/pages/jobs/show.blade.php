@extends('layouts.base')

@section('title', ($job->title ?? 'Job Details') . ' | Connector')

@section('content')

@php
    use Illuminate\Support\Str;

    $provider = $job->serviceProvider;

    $providerName = $provider?->user->name ?: 'Service Provider';

    /*
    |--------------------------------------------------------------------------
    | Provider logo
    |--------------------------------------------------------------------------
    */
    $providerLogo = null;

    if ($provider) {
        if (!empty($provider->logo)) {
            $providerLogo = asset('image/service-provider/' . $provider->logo);
        } elseif (!empty($provider->image)) {
            $providerLogo = asset('image/profile/' . $provider->image);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Provider description
    |--------------------------------------------------------------------------
    */
    $providerAbout = '';

    if ($provider) {
        $providerAbout = trim(
            strip_tags(
                $provider->about
                    ?? $provider->description
                    ?? ''
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Job status
    |--------------------------------------------------------------------------
    */
    $status = strtolower(trim($job->status ?? 'open'));

    $isClosed = in_array(
        $status,
        ['closed', 'expired', 'inactive', 'filled'],
        true
    );

    /*
    |--------------------------------------------------------------------------
    | Deadline
    |--------------------------------------------------------------------------
    */
    $deadline = null;

    if ($job->deadline) {
        try {
            $deadline = \Carbon\Carbon::parse($job->deadline);
        } catch (\Throwable $e) {
            $deadline = null;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Description
    |--------------------------------------------------------------------------
    */
    $description = trim(
        preg_replace(
            '/\s+/',
            ' ',
            strip_tags($job->description ?? '')
        )
    );

    /*
    |--------------------------------------------------------------------------
    | Responsibilities
    |--------------------------------------------------------------------------
    */
    $responsibilities = trim(
        strip_tags($job->responsibilities ?? '')
    );

    /*
    |--------------------------------------------------------------------------
    | Requirements
    |--------------------------------------------------------------------------
    */
    $requirements = trim(
        strip_tags($job->requirements ?? '')
    );

    /*
    |--------------------------------------------------------------------------
    | Optional fields
    |--------------------------------------------------------------------------
    */
    $expertise = $job->expertise ?? null;
    $experience = $job->experience ?? null;
@endphp


<style>
    :root {
        --connector-green: #254035;
        --connector-green-dark: #1b3027;
        --connector-accent: #6B9080;
        --connector-accent-light: #eaf1ed;
        --connector-soft: #f6f8f7;
        --connector-soft-2: #edf3f0;
        --connector-text: #17211d;
        --connector-muted: #748079;
        --connector-border: #e2e9e5;
        --connector-white: #ffffff;
    }

    .job-details-page {
        background: #fbfcfb;
        color: var(--connector-text);
        min-height: 100vh;
    }

    /* =========================================================
       HERO
    ========================================================= */

    .job-details-hero {
        position: relative;
        overflow: hidden;
        padding: 65px 0 105px;
        background: var(--connector-green);
        margin-top: 30px;
    }

    .job-details-hero::before {
        content: "";
        position: absolute;
        width: 430px;
        height: 430px;
        right: -180px;
        top: -260px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 50%;
    }

    .job-details-hero::after {
        content: "";
        position: absolute;
        width: 320px;
        height: 320px;
        left: -190px;
        bottom: -250px;
        border: 1px solid rgba(255,255,255,.05);
        border-radius: 50%;
    }

    .job-hero-content {
        position: relative;
        z-index: 2;
        max-width: 850px;
        margin: 0 auto;
        text-align: center;
    }

    .job-breadcrumb {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
        color: rgba(255,255,255,.65);
        font-size: 10px;
    }

    .job-breadcrumb a {
        color: #b7cec2;
        text-decoration: none;
    }

    .job-breadcrumb a:hover {
        color: #fff;
    }

    .job-breadcrumb i {
        font-size: 9px;
    }

    .job-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        margin-bottom: 17px;
        border: 1px solid rgba(255,255,255,.13);
        border-radius: 50px;
        background: rgba(255,255,255,.07);
        color: #dce8e2;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .job-hero-badge i {
        color: #a9c5b8;
    }

    .job-hero-title {
        margin: 0;
        color: #fff;
        font-size: clamp(34px, 5vw, 55px);
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -1.8px;
    }

    .job-hero-subtitle {
        max-width: 650px;
        margin: 17px auto 0;
        color: rgba(255,255,255,.65);
        font-size: 13px;
        line-height: 1.7;
    }

    /* =========================================================
       MAIN
    ========================================================= */

    .job-details-main {
        padding: 55px 0 90px;
    }

    .job-main-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 30px;
        align-items: start;
    }

    /* =========================================================
       CONTENT CARD
    ========================================================= */

    .job-content-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        overflow: hidden;
    }

    .job-content-header {
        padding: 25px 28px;
        border-bottom: 1px solid var(--connector-border);
    }

    .job-published {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
        color: var(--connector-muted);
        font-size: 10px;
    }

    .job-published strong {
        color: var(--connector-green);
    }

    .job-published i {
        color: var(--connector-accent);
    }

    .job-company-link {
        color: var(--connector-green);
        font-weight: 700;
        text-decoration: none;
    }

    .job-company-link:hover {
        color: var(--connector-accent);
    }

    .job-content-title {
        margin: 12px 0 0;
        color: var(--connector-green);
        font-size: 25px;
        line-height: 1.3;
        font-weight: 800;
        letter-spacing: -.6px;
    }

    /* =========================================================
       QUICK INFO
    ========================================================= */

    .job-quick-info {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        padding: 18px 28px;
        background: var(--connector-soft);
        border-bottom: 1px solid var(--connector-border);
    }

    .job-quick-item {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 0;
    }

    .job-quick-icon {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: var(--connector-accent-light);
        color: var(--connector-accent);
        font-size: 13px;
    }

    .job-quick-text {
        min-width: 0;
    }

    .job-quick-label {
        display: block;
        margin-bottom: 2px;
        color: var(--connector-muted);
        font-size: 8px;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    .job-quick-value {
        display: block;
        overflow: hidden;
        color: var(--connector-green);
        font-size: 10px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* =========================================================
       SECTIONS
    ========================================================= */

    .job-section {
        padding: 30px 28px;
        border-bottom: 1px solid var(--connector-border);
    }

    .job-section:last-child {
        border-bottom: 0;
    }

    .job-section-heading {
        display: flex;
        align-items: center;
        gap: 11px;
        margin-bottom: 17px;
    }

    .job-section-number {
        width: 30px;
        height: 30px;
        flex: 0 0 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: var(--connector-green);
        color: #fff;
        font-size: 10px;
        font-weight: 800;
    }

    .job-section-heading h2 {
        margin: 0;
        color: var(--connector-green);
        font-size: 17px;
        font-weight: 800;
        letter-spacing: -.2px;
    }

    .job-section-content {
        color: #59655f;
        font-size: 12px;
        line-height: 1.9;
    }

    .job-section-content p {
        margin: 0;
    }

    .job-section-content p + p {
        margin-top: 12px;
    }

    /* =========================================================
       LIST CONTENT
    ========================================================= */

    .job-list {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .job-list li {
        position: relative;
        padding-left: 22px;
        margin-bottom: 10px;
        color: #59655f;
        font-size: 12px;
        line-height: 1.75;
    }

    .job-list li:last-child {
        margin-bottom: 0;
    }

    .job-list li::before {
        content: "";
        position: absolute;
        width: 7px;
        height: 7px;
        left: 2px;
        top: 8px;
        border-radius: 50%;
        background: var(--connector-accent);
    }

    /* =========================================================
       SIDEBAR
    ========================================================= */

    .job-sidebar {
        position: sticky;
        top: 25px;
    }

    .job-sidebar-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        overflow: hidden;
    }

    .provider-card-top {
        padding: 25px 22px;
        text-align: center;
    }

    .provider-logo {
        width: 78px;
        height: 78px;
        margin: 0 auto 13px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--connector-border);
        border-radius: 17px;
        background: var(--connector-soft-2);
        color: var(--connector-accent);
        font-size: 25px;
    }

    .provider-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .provider-name {
        margin: 0;
        color: var(--connector-green);
        font-size: 15px;
        font-weight: 800;
    }

    .provider-label {
        display: block;
        margin-top: 4px;
        color: var(--connector-muted);
        font-size: 9px;
    }

    .provider-about {
        margin: 14px 0 0;
        color: var(--connector-muted);
        font-size: 10px;
        line-height: 1.7;
    }

    .provider-profile-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        margin-top: 17px;
        padding: 11px 15px;
        border: 1px solid var(--connector-border);
        border-radius: 9px;
        background: #fff;
        color: var(--connector-green);
        text-decoration: none;
        font-size: 10px;
        font-weight: 700;
        transition: .2s ease;
    }

    .provider-profile-btn:hover {
        background: var(--connector-soft-2);
        border-color: var(--connector-accent);
        color: var(--connector-green);
    }

    /* =========================================================
       META
    ========================================================= */

    .job-meta-panel {
        padding: 22px;
        border-top: 1px solid var(--connector-border);
    }

    .job-meta-title {
        margin: 0 0 15px;
        color: var(--connector-green);
        font-size: 12px;
        font-weight: 800;
    }

    .job-meta-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px 12px;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .job-meta-item {
        min-width: 0;
    }

    .job-meta-label {
        display: block;
        margin-bottom: 3px;
        color: var(--connector-muted);
        font-size: 8px;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    .job-meta-value {
        display: block;
        overflow: hidden;
        color: var(--connector-green);
        font-size: 10px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .job-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .job-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--connector-accent);
    }

    .job-status.closed {
        color: #8a7474;
    }

    .job-status.closed .job-status-dot {
        background: #8a7474;
    }

    /* =========================================================
       APPLY
    ========================================================= */

    .job-apply-panel {
        padding: 22px;
        border-top: 1px solid var(--connector-border);
        background: var(--connector-soft);
    }

    .apply-button {
        width: 100%;
        min-height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 0;
        border-radius: 9px;
        background: var(--connector-green);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        transition: .2s ease;
    }

    .apply-button:hover {
        background: var(--connector-green-dark);
        color: #fff;
    }

    .apply-button.disabled {
        background: #b5bdb9;
        cursor: not-allowed;
    }

    .apply-note {
        margin: 10px 0 0;
        color: var(--connector-muted);
        text-align: center;
        font-size: 8px;
        line-height: 1.5;
    }

    /* =========================================================
       TAGS
    ========================================================= */

    .job-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 17px;
    }

    .job-tag {
        display: inline-flex;
        align-items: center;
        padding: 6px 9px;
        border: 1px solid var(--connector-border);
        border-radius: 7px;
        background: #fff;
        color: var(--connector-muted);
        font-size: 8px;
        text-decoration: none;
    }

    /* =========================================================
       RELATED JOBS
    ========================================================= */

    .related-jobs-section {
        padding: 75px 0 100px;
        background: var(--connector-soft);
        border-top: 1px solid var(--connector-border);
    }

    .related-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 25px;
    }

    .related-heading h2 {
        margin: 0;
        color: var(--connector-green);
        font-size: 25px;
        font-weight: 800;
        letter-spacing: -.6px;
    }

    .related-heading p {
        margin: 5px 0 0;
        color: var(--connector-muted);
        font-size: 10px;
    }

    .related-jobs-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 17px;
    }

    .related-job-card {
        min-width: 0;
        padding: 18px;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        transition: .2s ease;
    }

    .related-job-card:hover {
        transform: translateY(-3px);
        border-color: #cbd9d2;
        box-shadow: 0 12px 28px rgba(37,64,53,.08);
    }

    .related-job-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .related-provider {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
    }

    .related-provider-logo {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--connector-border);
        border-radius: 8px;
        background: var(--connector-soft-2);
        color: var(--connector-accent);
        font-size: 12px;
    }

    .related-provider-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .related-provider-name {
        max-width: 130px;
        overflow: hidden;
        color: var(--connector-green);
        font-size: 9px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .related-type {
        padding: 5px 7px;
        border-radius: 6px;
        background: var(--connector-accent-light);
        color: var(--connector-green);
        font-size: 7px;
        font-weight: 700;
        white-space: nowrap;
    }

    .related-job-title {
        display: block;
        margin: 17px 0 10px;
        color: var(--connector-green);
        font-size: 13px;
        line-height: 1.45;
        font-weight: 800;
        text-decoration: none;
    }

    .related-job-title:hover {
        color: var(--connector-accent);
    }

    .related-location {
        display: flex;
        align-items: center;
        gap: 5px;
        color: var(--connector-muted);
        font-size: 8px;
    }

    .related-location i {
        color: var(--connector-accent);
    }

    .related-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-top: 17px;
        padding-top: 13px;
        border-top: 1px solid var(--connector-border);
    }

    .related-date {
        color: var(--connector-muted);
        font-size: 8px;
    }

    .related-view {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: var(--connector-green);
        font-size: 8px;
        font-weight: 700;
        text-decoration: none;
    }

    .related-view:hover {
        color: var(--connector-accent);
    }

    /* =========================================================
       MODAL
    ========================================================= */

    .job-application-modal .modal-content {
        overflow: hidden;
        border: 0;
        border-radius: 17px;
        box-shadow: 0 25px 70px rgba(0,0,0,.18);
    }

    .job-application-header {
        padding: 21px 24px;
        background: var(--connector-green);
        color: #fff;
    }

    .job-application-header h5 {
        margin: 0;
        font-size: 15px;
        font-weight: 800;
    }

    .job-application-header p {
        margin: 5px 0 0;
        color: rgba(255,255,255,.62);
        font-size: 9px;
    }

    .job-application-body {
        padding: 24px;
        background: #fff;
    }

    .application-label {
        display: block;
        margin-bottom: 7px;
        color: var(--connector-green);
        font-size: 10px;
        font-weight: 700;
    }

    .application-label i {
        color: var(--connector-accent);
    }

    .application-input {
        border: 1px solid var(--connector-border);
        border-radius: 9px;
        background: var(--connector-soft);
        box-shadow: none !important;
        color: var(--connector-text);
        font-size: 11px;
    }

    .application-input:focus {
        border-color: var(--connector-accent);
        background: #fff;
    }

    .application-help {
        display: block;
        margin-top: 5px;
        color: var(--connector-muted);
        font-size: 8px;
    }

    .job-application-footer {
        padding: 17px 24px;
        border-top: 1px solid var(--connector-border);
        background: var(--connector-soft);
    }

    .application-cancel {
        border: 1px solid var(--connector-border);
        border-radius: 8px;
        color: var(--connector-muted);
        font-size: 10px;
        font-weight: 700;
    }

    .application-submit {
        border: 0;
        border-radius: 8px;
        background: var(--connector-green);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
    }

    .application-submit:hover {
        background: var(--connector-green-dark);
        color: #fff;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1199.98px) {

        .job-main-grid {
            grid-template-columns: minmax(0, 1fr) 300px;
        }

        .related-jobs-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991.98px) {

        .job-details-hero {
            padding: 50px 0 85px;
        }

        .job-details-main {
            padding-top: 40px;
        }

        .job-main-grid {
            grid-template-columns: 1fr;
        }

        .job-sidebar {
            position: static;
        }

        .job-quick-info {
            grid-template-columns: repeat(2, 1fr);
        }

        .related-jobs-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {

        .job-details-hero {
            padding: 43px 0 70px;
        }

        .job-hero-title {
            font-size: 34px;
            letter-spacing: -1.1px;
        }

        .job-hero-subtitle {
            font-size: 11px;
        }

        .job-content-header,
        .job-section {
            padding: 22px 19px;
        }

        .job-quick-info {
            padding: 15px 19px;
        }

        .job-content-title {
            font-size: 21px;
        }

        .related-heading {
            display: block;
        }

        .related-heading h2 {
            font-size: 22px;
        }

        .related-jobs-section {
            padding: 55px 0 75px;
        }
    }

    @media (max-width: 575.98px) {

        .job-quick-info {
            grid-template-columns: 1fr;
        }

        .job-meta-list {
            grid-template-columns: 1fr 1fr;
        }

        .related-jobs-grid {
            grid-template-columns: 1fr;
        }

        .job-application-body {
            padding: 19px;
        }

        .job-application-footer {
            padding: 14px 19px;
        }
    }
</style>


<div class="job-details-page">

    {{-- =========================================================
         HERO
    ========================================================== --}}

    <section class="job-details-hero">

        <div class="container">

            <div class="job-hero-content">

                <div class="job-breadcrumb">

                    <a href="{{ url('/') }}">
                        Home
                    </a>

                    <i class="bi bi-chevron-right"></i>

                    <a href="{{ route('home.jobs') }}">
                        Jobs
                    </a>

                    <i class="bi bi-chevron-right"></i>

                    <span>
                        Details
                    </span>

                </div>

                <div class="job-hero-badge">

                    <i class="bi bi-briefcase"></i>

                    Job Opportunity

                </div>

                <h1 class="job-hero-title">
                    {{ $job->title }}
                </h1>

                <p class="job-hero-subtitle">

                    @if($provider)
                        Join {{ $providerName }} and explore this
                        opportunity through Connector.
                    @else
                        Explore this opportunity and discover the
                        requirements, responsibilities and application
                        details.
                    @endif

                </p>

            </div>

        </div>

    </section>


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <section class="job-details-main">

        <div class="container">

            <div class="job-main-grid">


                {{-- =================================================
                     LEFT CONTENT
                ================================================== --}}

                <main>

                    <div class="job-content-card">

                        {{-- Header --}}

                        <div class="job-content-header">

                            <div class="job-published">

                                <i class="bi bi-calendar3"></i>

                                Posted
                                <strong>
                                    {{ optional($job->created_at)->format('d M Y') }}
                                </strong>

                                <span>•</span>

                                by

                                @if($provider)

                                    <a
                                        href="{{ route(
                                            'home.service-provider_profile',
                                            ['sprovider_id' => $provider->id]
                                        ) }}"
                                        class="job-company-link"
                                    >
                                        {{ $providerName }}
                                    </a>

                                @else

                                    <strong>
                                        Service Provider
                                    </strong>

                                @endif

                            </div>

                            <h2 class="job-content-title">
                                {{ $job->title }}
                            </h2>

                        </div>


                        {{-- Quick information --}}

                        <div class="job-quick-info">

                            <div class="job-quick-item">

                                <div class="job-quick-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>

                                <div class="job-quick-text">

                                    <span class="job-quick-label">
                                        Location
                                    </span>

                                    <span class="job-quick-value">
                                        {{ $job->location ?: 'Not specified' }}
                                    </span>

                                </div>

                            </div>


                            <div class="job-quick-item">

                                <div class="job-quick-icon">
                                    <i class="bi bi-briefcase"></i>
                                </div>

                                <div class="job-quick-text">

                                    <span class="job-quick-label">
                                        Job type
                                    </span>

                                    <span class="job-quick-value">
                                        {{ $job->type ?: 'Not specified' }}
                                    </span>

                                </div>

                            </div>


                            <div class="job-quick-item">

                                <div class="job-quick-icon">
                                    <i class="bi bi-calendar-check"></i>
                                </div>

                                <div class="job-quick-text">

                                    <span class="job-quick-label">
                                        Deadline
                                    </span>

                                    <span class="job-quick-value">

                                        @if($deadline)
                                            {{ $deadline->format('d M Y') }}
                                        @else
                                            No deadline
                                        @endif

                                    </span>

                                </div>

                            </div>


                            <div class="job-quick-item">

                                <div class="job-quick-icon">
                                    <i class="bi bi-circle-fill"></i>
                                </div>

                                <div class="job-quick-text">

                                    <span class="job-quick-label">
                                        Status
                                    </span>

                                    <span class="job-quick-value">
                                        {{ ucfirst($status) }}
                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- Overview --}}

                        <div class="job-section">

                            <div class="job-section-heading">

                                <div class="job-section-number">
                                    01
                                </div>

                                <h2>
                                    Overview
                                </h2>

                            </div>

                            <div class="job-section-content">

                                @if($providerAbout)

                                    <p>
                                        {{ $providerAbout }}
                                    </p>

                                @else

                                    <p>
                                        {{ $providerName }} has published
                                        this opportunity on Connector.
                                        Review the job description,
                                        responsibilities and requirements
                                        below before applying.
                                    </p>

                                @endif

                            </div>

                        </div>


                        {{-- Job Description --}}

                        <div class="job-section">

                            <div class="job-section-heading">

                                <div class="job-section-number">
                                    02
                                </div>

                                <h2>
                                    Job Description
                                </h2>

                            </div>

                            <div class="job-section-content">

                                @if($description)

                                    <p>
                                        {{ $description }}
                                    </p>

                                @else

                                    <p>
                                        The job description has not been
                                        provided. Please contact the service
                                        provider for additional information.
                                    </p>

                                @endif

                            </div>

                        </div>


                        {{-- Responsibilities --}}

                        @if($responsibilities)

                            <div class="job-section">

                                <div class="job-section-heading">

                                    <div class="job-section-number">
                                        03
                                    </div>

                                    <h2>
                                        Responsibilities
                                    </h2>

                                </div>

                                <div class="job-section-content">

                                    <ul class="job-list">

                                        @php
                                            $responsibilityItems = preg_split(
                                                '/\r\n|\r|\n|•/',
                                                $responsibilities
                                            );

                                            $responsibilityItems = array_filter(
                                                array_map(
                                                    'trim',
                                                    $responsibilityItems
                                                )
                                            );
                                        @endphp

                                        @foreach($responsibilityItems as $responsibility)

                                            <li>
                                                {{ $responsibility }}
                                            </li>

                                        @endforeach

                                    </ul>

                                </div>

                            </div>

                        @endif


                        {{-- Requirements --}}

                        @if($requirements)

                            <div class="job-section">

                                <div class="job-section-heading">

                                    <div class="job-section-number">
                                        04
                                    </div>

                                    <h2>
                                        Required Skills & Requirements
                                    </h2>

                                </div>

                                <div class="job-section-content">

                                    <ul class="job-list">

                                        @php
                                            $requirementItems = preg_split(
                                                '/\r\n|\r|\n|•/',
                                                $requirements
                                            );

                                            $requirementItems = array_filter(
                                                array_map(
                                                    'trim',
                                                    $requirementItems
                                                )
                                            );
                                        @endphp

                                        @foreach($requirementItems as $requirement)

                                            <li>
                                                {{ $requirement }}
                                            </li>

                                        @endforeach

                                    </ul>

                                </div>

                            </div>

                        @endif

                    </div>

                </main>


                {{-- =================================================
                     RIGHT SIDEBAR
                ================================================== --}}

                <aside class="job-sidebar">

                    <div class="job-sidebar-card">


                        {{-- Provider --}}

                        <div class="provider-card-top">

                            <div class="provider-logo">

                                @if($providerLogo)

                                    <img
                                        src="{{ $providerLogo }}"
                                        alt="{{ $providerName }}"
                                        loading="lazy"
                                        onerror="
                                            this.style.display='none';
                                            this.nextElementSibling.style.display='flex';
                                        "
                                    >

                                    <span
                                        style="
                                            display:none;
                                            align-items:center;
                                            justify-content:center;
                                            width:100%;
                                            height:100%;
                                        "
                                    >
                                        <i class="bi bi-building"></i>
                                    </span>

                                @else

                                    <i class="bi bi-building"></i>

                                @endif

                            </div>

                            <h3 class="provider-name">
                                {{ $providerName }}
                            </h3>

                            <span class="provider-label">
                                Service Provider
                            </span>

                            @if($providerAbout)

                                <p class="provider-about">

                                    {{ Str::limit($providerAbout, 145) }}

                                </p>

                            @endif

                            @if($provider)

                                <a
                                    href="{{ route(
                                        'home.service-provider_profile',
                                        ['sprovider_id' => $provider->id]
                                    ) }}"
                                    class="provider-profile-btn"
                                >

                                    <i class="bi bi-person"></i>

                                    View provider profile

                                    <i class="bi bi-arrow-up-right"></i>

                                </a>

                            @endif

                        </div>


                        {{-- Job metadata --}}

                        <div class="job-meta-panel">

                            <h3 class="job-meta-title">
                                Job information
                            </h3>

                            <ul class="job-meta-list">

                                <li class="job-meta-item">

                                    <span class="job-meta-label">
                                        Status
                                    </span>

                                    <span
                                        class="job-meta-value job-status {{ $isClosed ? 'closed' : '' }}"
                                    >

                                        <span class="job-status-dot"></span>

                                        {{ ucfirst($status) }}

                                    </span>

                                </li>


                                @if($expertise)

                                    <li class="job-meta-item">

                                        <span class="job-meta-label">
                                            Expertise
                                        </span>

                                        <span class="job-meta-value">
                                            {{ $expertise }}
                                        </span>

                                    </li>

                                @endif


                                <li class="job-meta-item">

                                    <span class="job-meta-label">
                                        Location
                                    </span>

                                    <span class="job-meta-value">
                                        {{ $job->location ?: 'Not specified' }}
                                    </span>

                                </li>


                                <li class="job-meta-item">

                                    <span class="job-meta-label">
                                        Job type
                                    </span>

                                    <span class="job-meta-value">
                                        {{ $job->type ?: 'Not specified' }}
                                    </span>

                                </li>


                                <li class="job-meta-item">

                                    <span class="job-meta-label">
                                        Deadline
                                    </span>

                                    <span class="job-meta-value">

                                        @if($deadline)

                                            {{ $deadline->format('d M Y') }}

                                        @else

                                            Not specified

                                        @endif

                                    </span>

                                </li>


                                @if($experience !== null && $experience !== '')

                                    <li class="job-meta-item">

                                        <span class="job-meta-label">
                                            Experience
                                        </span>

                                        <span class="job-meta-value">

                                            {{ $experience }}
                                            {{ ((int) $experience === 1) ? 'Year' : 'Years' }}

                                        </span>

                                    </li>

                                @endif

                            </ul>


                            {{-- Tags --}}

                            <div class="job-tags">

                                @if($job->type)
                                    <span class="job-tag">
                                        {{ $job->type }}
                                    </span>
                                @endif

                                @if($expertise)
                                    <span class="job-tag">
                                        {{ $expertise }}
                                    </span>
                                @endif

                                @if($job->location)
                                    <span class="job-tag">
                                        {{ $job->location }}
                                    </span>
                                @endif

                            </div>

                        </div>


                        {{-- Apply --}}

                        <div class="job-apply-panel">

                            @if(!$isClosed)

                                <button
                                    type="button"
                                    class="apply-button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#applyModal{{ $job->id }}"
                                >

                                    <i class="bi bi-send"></i>

                                    Apply for this job

                                </button>

                                <p class="apply-note">
                                    Submit your application through Connector.
                                </p>

                            @else

                                <button
                                    type="button"
                                    class="apply-button disabled"
                                    disabled
                                >

                                    <i class="bi bi-lock"></i>

                                    Applications closed

                                </button>

                                <p class="apply-note">
                                    This opportunity is no longer accepting
                                    applications.
                                </p>

                            @endif

                        </div>

                    </div>

                </aside>

            </div>

        </div>

    </section>


    {{-- =========================================================
         RELATED JOBS
    ========================================================== --}}

    @if($relatedJobs->count())

        <section class="related-jobs-section">

            <div class="container">

                <div class="related-heading">

                    <div>

                        <h2>
                            Related opportunities
                        </h2>

                        <p>
                            More opportunities from service providers
                            on Connector.
                        </p>

                    </div>

                </div>


                <div class="related-jobs-grid">

                    @foreach($relatedJobs as $relatedJob)

                        @php

                            $relatedProvider =
                                $relatedJob->serviceProvider;

                            $relatedProviderName =
                                $relatedProvider?->name
                                ?: 'Service Provider';

                            $relatedLogo = null;

                            if ($relatedProvider) {

                                if (!empty($relatedProvider->logo)) {

                                    $relatedLogo =
                                        asset(
                                            'image/service-provider/' .
                                            $relatedProvider->logo
                                        );

                                } elseif (!empty($relatedProvider->image)) {

                                    $relatedLogo =
                                        asset(
                                            'image/profile/' .
                                            $relatedProvider->image
                                        );

                                }

                            }

                            $relatedDeadline =
                                $relatedJob->deadline
                                    ? \Carbon\Carbon::parse(
                                        $relatedJob->deadline
                                    )
                                    : null;

                        @endphp


                        <article class="related-job-card">

                            <div class="related-job-top">

                                <div class="related-provider">

                                    <div class="related-provider-logo">

                                        @if($relatedLogo)

                                            <img
                                                src="{{ $relatedLogo }}"
                                                alt="{{ $relatedProviderName }}"
                                                loading="lazy"
                                                onerror="
                                                    this.style.display='none';
                                                    this.nextElementSibling.style.display='flex';
                                                "
                                            >

                                            <span
                                                style="
                                                    display:none;
                                                    align-items:center;
                                                    justify-content:center;
                                                    width:100%;
                                                    height:100%;
                                                "
                                            >
                                                <i class="bi bi-building"></i>
                                            </span>

                                        @else

                                            <i class="bi bi-building"></i>

                                        @endif

                                    </div>

                                    <span class="related-provider-name">
                                        {{ $relatedProviderName }}
                                    </span>

                                </div>


                                @if($relatedJob->type)

                                    <span class="related-type">
                                        {{ $relatedJob->type }}
                                    </span>

                                @endif

                            </div>


                            <a
                                href="{{ route(
                                    'home.jobs.show',
                                    $relatedJob->id
                                ) }}"
                                class="related-job-title"
                            >
                                {{ $relatedJob->title }}
                            </a>


                            @if($relatedJob->location)

                                <div class="related-location">

                                    <i class="bi bi-geo-alt"></i>

                                    <span>
                                        {{ $relatedJob->location }}
                                    </span>

                                </div>

                            @endif


                            <div class="related-footer">

                                <span class="related-date">

                                    @if($relatedDeadline)

                                        Deadline:
                                        {{ $relatedDeadline->format('d M Y') }}

                                    @else

                                        No deadline

                                    @endif

                                </span>


                                <a
                                    href="{{ route(
                                        'home.jobs.show',
                                        $relatedJob->id
                                    ) }}"
                                    class="related-view"
                                >

                                    View

                                    <i class="bi bi-arrow-right"></i>

                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>

    @endif

</div>


{{-- =============================================================
     APPLICATION MODAL
============================================================== --}}

@if(!$isClosed)

    <div
        class="modal fade job-application-modal"
        id="applyModal{{ $job->id }}"
        tabindex="-1"
        aria-labelledby="applyModalLabel{{ $job->id }}"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <form
                action="{{ route('apply.job') }}"
                method="POST"
                enctype="multipart/form-data"
                class="modal-content"
            >

                @csrf

                <input
                    type="hidden"
                    name="job_id"
                    value="{{ $job->id }}"
                >


                {{-- Header --}}

                <div class="job-application-header">

                    <div class="d-flex align-items-start justify-content-between gap-3">

                        <div>

                            <h5
                                id="applyModalLabel{{ $job->id }}"
                            >

                                <i class="bi bi-send me-2"></i>

                                Apply for {{ $job->title }}

                            </h5>

                            <p>
                                Your application will be submitted
                                to {{ $providerName }}.
                            </p>

                        </div>

                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>

                    </div>

                </div>


                {{-- Body --}}

                <div class="job-application-body">

                    @if(session('success'))

                        <div class="alert alert-success border-0 rounded-3 mb-4">

                            <i class="bi bi-check-circle me-1"></i>

                            {{ session('success') }}

                        </div>

                    @endif


                    @if(session('error'))

                        <div class="alert alert-danger border-0 rounded-3 mb-4">

                            <i class="bi bi-exclamation-circle me-1"></i>

                            {{ session('error') }}

                        </div>

                    @endif


                    @if($errors->any())

                        <div class="alert alert-danger border-0 rounded-3 mb-4">

                            <div class="fw-semibold mb-2">
                                Please correct the following:
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


                    {{-- Cover Letter --}}

                    <div class="mb-4">

                        <label
                            for="cover_letter_{{ $job->id }}"
                            class="application-label"
                        >

                            <i class="bi bi-pencil-square me-1"></i>

                            Cover Letter

                        </label>

                        <textarea
                            id="cover_letter_{{ $job->id }}"
                            name="cover_letter"
                            class="form-control application-input"
                            rows="7"
                            placeholder="Introduce yourself and explain why you are a good fit for this opportunity..."
                            required
                        >{{ old('cover_letter') }}</textarea>

                    </div>


                    {{-- Resume --}}

                    <div>

                        <label
                            for="resume_{{ $job->id }}"
                            class="application-label"
                        >

                            <i class="bi bi-file-earmark-arrow-up me-1"></i>

                            Resume / CV

                        </label>

                        <input
                            id="resume_{{ $job->id }}"
                            type="file"
                            name="resume"
                            class="form-control application-input"
                            accept=".pdf,.doc,.docx"
                        >

                        <small class="application-help">

                            PDF, DOC or DOCX. Maximum file size: 2MB.

                        </small>

                    </div>

                </div>


                {{-- Footer --}}

                <div class="job-application-footer">

                    <div class="d-flex justify-content-end gap-2">

                        <button
                            type="button"
                            class="btn application-cancel px-3"
                            data-bs-dismiss="modal"
                        >

                            Cancel

                        </button>

                        <button
                            type="submit"
                            class="btn application-submit px-4"
                        >

                            <i class="bi bi-send me-1"></i>

                            Submit Application

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

@endif


@endsection