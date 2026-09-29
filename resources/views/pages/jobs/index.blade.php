@extends('layouts.base')

@section('title', 'Job Openings')

@section('content')

@php
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;
    use Illuminate\Support\Str;

    $jobCount = $jobs instanceof LengthAwarePaginator
        ? $jobs->total()
        : $jobs->count();

    $currentSort = request('sort', 'latest');
    $currentQuery = request('query');
@endphp

<style>
    :root {
        --connector-green: #254035;
        --connector-green-dark: #1b3027;
        --connector-accent: #6B9080;
        --connector-soft: #f4f7f5;
        --connector-soft-2: #edf3f0;
        --connector-text: #18231e;
        --connector-muted: #738078;
        --connector-border: #e3eae6;
        --connector-white: #ffffff;
    }

    /* =========================================================
       PAGE
    ========================================================= */

    .jobs-page {
        min-height: 100vh;
        background: #fbfcfb;
        color: var(--connector-text);
    }

    /* =========================================================
       HERO
    ========================================================= */

    .jobs-hero {
        position: relative;
        overflow: hidden;
        background: var(--connector-green);
        padding: 64px 0 115px;
        margin-top: 30px;
    }

    .jobs-hero::before {
        content: "";
        position: absolute;
        width: 430px;
        height: 430px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,.08);
        right: -170px;
        top: -250px;
    }

    .jobs-hero::after {
        content: "";
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,.05);
        left: -160px;
        bottom: -220px;
    }

    .jobs-hero-content {
        position: relative;
        z-index: 2;
        max-width: 780px;
        margin: 0 auto;
        text-align: center;
    }

    .jobs-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        margin-bottom: 18px;
        border: 1px solid rgba(255,255,255,.14);
        border-radius: 50px;
        background: rgba(255,255,255,.07);
        color: #dbe8e2;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .3px;
    }

    .jobs-eyebrow i {
        color: #a9c5b8;
        font-size: 13px;
    }

    .jobs-hero h1 {
        margin: 0;
        color: #fff;
        font-size: clamp(38px, 5vw, 58px);
        line-height: 1.05;
        font-weight: 800;
        letter-spacing: -2px;
    }

    .jobs-hero h1 span {
        color: #a9c5b8;
    }

    .jobs-hero-description {
        max-width: 600px;
        margin: 17px auto 0;
        color: rgba(255,255,255,.67);
        font-size: 14px;
        line-height: 1.7;
    }

    /* =========================================================
       SEARCH
    ========================================================= */

    .jobs-search-wrapper {
        position: relative;
        z-index: 20;
        margin-top: -58px;
    }

    .jobs-search-card {
        padding: 8px;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(37,64,53,.10);
    }

    .jobs-search-form {
        display: flex;
        gap: 8px;
    }

    .jobs-search-input-wrapper {
        position: relative;
        flex: 1;
    }

    .jobs-search-input-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--connector-accent);
        pointer-events: none;
    }

    .jobs-search-input {
        width: 100%;
        height: 50px;
        padding: 0 16px 0 44px;
        border: 0;
        border-radius: 10px;
        background: var(--connector-soft);
        color: var(--connector-text);
        font-size: 12px;
        outline: none;
    }

    .jobs-search-input:focus {
        box-shadow: inset 0 0 0 1px var(--connector-accent);
    }

    .jobs-search-button {
        height: 50px;
        min-width: 125px;
        border: 0;
        border-radius: 10px;
        background: var(--connector-green);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        font-size: 11px;
        font-weight: 700;
        transition: .2s ease;
    }

    .jobs-search-button:hover {
        background: var(--connector-green-dark);
        color: #fff;
    }

    /* =========================================================
       MAIN
    ========================================================= */

    .jobs-main {
        padding: 58px 0 90px;
    }

    /* =========================================================
       TOOLBAR
    ========================================================= */

    .jobs-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 22px;
    }

    .jobs-heading {
        margin: 0;
        color: var(--connector-green);
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -.4px;
    }

    .jobs-count {
        margin: 4px 0 0;
        color: var(--connector-muted);
        font-size: 11px;
    }

    .jobs-count strong {
        color: var(--connector-green);
    }

    .jobs-sort {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .jobs-sort label {
        color: var(--connector-muted);
        font-size: 10px;
        font-weight: 600;
    }

    .jobs-sort select {
        height: 38px;
        min-width: 125px;
        padding: 0 28px 0 11px;
        border: 1px solid var(--connector-border);
        border-radius: 8px;
        background: #fff;
        color: var(--connector-green);
        font-size: 10px;
        font-weight: 600;
        outline: none;
    }

    .jobs-sort select:focus {
        border-color: var(--connector-accent);
    }

    /* =========================================================
       ACTIVE SEARCH
    ========================================================= */

    .jobs-filter {
        margin-bottom: 20px;
    }

    .jobs-filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 10px;
        background: var(--connector-soft-2);
        border: 1px solid #dce8e2;
        border-radius: 8px;
        color: var(--connector-green);
        font-size: 10px;
        text-decoration: none;
    }

    .jobs-filter-tag:hover {
        color: var(--connector-green-dark);
        border-color: var(--connector-accent);
    }

    .jobs-filter-tag i:last-child {
        color: var(--connector-muted);
    }

    /* =========================================================
       JOB GRID
    ========================================================= */

    .jobs-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    /* =========================================================
       JOB CARD
    ========================================================= */

    .job-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        padding: 18px;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        transition:
            transform .2s ease,
            box-shadow .2s ease,
            border-color .2s ease;
    }

    .job-card:hover {
        transform: translateY(-4px);
        border-color: #cedbd4;
        box-shadow: 0 14px 30px rgba(37,64,53,.09);
    }

    /* =========================================================
       CARD TOP
    ========================================================= */

    .job-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
    }

    .job-provider {
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .job-provider-logo {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: var(--connector-soft-2);
        border: 1px solid var(--connector-border);
        color: var(--connector-accent);
        font-size: 15px;
    }

    .job-provider-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .job-provider-info {
        min-width: 0;
    }

    .job-provider-name {
        margin: 0;
        max-width: 135px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: var(--connector-green);
        font-size: 10px;
        font-weight: 700;
    }

    .job-provider-label {
        display: block;
        margin-top: 2px;
        color: var(--connector-muted);
        font-size: 8px;
    }

    .job-open-icon {
        width: 30px;
        height: 30px;
        flex: 0 0 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--connector-border);
        border-radius: 8px;
        background: #fff;
        color: var(--connector-muted);
        text-decoration: none;
        transition: .2s ease;
    }

    .job-open-icon:hover {
        background: var(--connector-soft-2);
        border-color: var(--connector-accent);
        color: var(--connector-green);
    }

    /* =========================================================
       JOB CONTENT
    ========================================================= */

    .job-title {
        margin: 17px 0 8px;
        font-size: 15px;
        line-height: 1.4;
        font-weight: 800;
        letter-spacing: -.2px;
    }

    .job-title a {
        color: var(--connector-green);
        text-decoration: none;
    }

    .job-title a:hover {
        color: var(--connector-accent);
    }

    .job-description {
        margin: 0;
        color: var(--connector-muted);
        font-size: 10px;
        line-height: 1.65;
    }

    /* =========================================================
       META
    ========================================================= */

    .job-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-top: 15px;
    }

    .job-meta-item {
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 7px;
        color: var(--connector-muted);
        font-size: 9px;
    }

    .job-meta-item i {
        width: 15px;
        color: var(--connector-accent);
        font-size: 10px;
        text-align: center;
    }

    /* =========================================================
       DEADLINE
    ========================================================= */

    .job-deadline {
        margin-top: 12px;
        padding: 8px 9px;
        border-radius: 7px;
        background: var(--connector-soft);
        color: var(--connector-muted);
        font-size: 8px;
    }

    .job-deadline i {
        margin-right: 4px;
        color: var(--connector-accent);
    }

    .job-deadline strong {
        color: var(--connector-green);
    }

    /* =========================================================
       FOOTER
    ========================================================= */

    .job-card-footer {
        margin-top: auto;
        padding-top: 15px;
        margin-top: 17px;
        border-top: 1px solid var(--connector-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .job-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: var(--connector-accent);
        font-size: 9px;
        font-weight: 700;
        text-transform: capitalize;
    }

    .job-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--connector-accent);
    }

    .job-status.closed {
        color: #8c7777;
    }

    .job-status.closed .job-status-dot {
        background: #8c7777;
    }

    .job-view-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 8px 10px;
        border-radius: 7px;
        background: var(--connector-green);
        color: #fff;
        text-decoration: none;
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
        transition: .2s ease;
    }

    .job-view-button:hover {
        background: var(--connector-green-dark);
        color: #fff;
    }

    /* =========================================================
       EMPTY
    ========================================================= */

    .jobs-empty {
        padding: 70px 25px;
        text-align: center;
        background: var(--connector-soft);
        border: 1px dashed var(--connector-border);
        border-radius: 15px;
    }

    .jobs-empty-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--connector-soft-2);
        color: var(--connector-accent);
        font-size: 21px;
    }

    .jobs-empty h3 {
        margin: 0;
        color: var(--connector-green);
        font-size: 18px;
        font-weight: 800;
    }

    .jobs-empty p {
        max-width: 430px;
        margin: 8px auto 18px;
        color: var(--connector-muted);
        font-size: 11px;
        line-height: 1.6;
    }

    .jobs-reset {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 13px;
        border-radius: 8px;
        background: var(--connector-green);
        color: #fff;
        text-decoration: none;
        font-size: 10px;
        font-weight: 700;
    }

    .jobs-reset:hover {
        background: var(--connector-green-dark);
        color: #fff;
    }

    /* =========================================================
       PAGINATION
    ========================================================= */

    .jobs-pagination {
        margin-top: 38px;
    }

    .jobs-pagination .pagination {
        justify-content: center;
        gap: 5px;
    }

    .jobs-pagination .page-link {
        min-width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--connector-border);
        border-radius: 8px !important;
        color: var(--connector-green);
        background: #fff;
        font-size: 10px;
        box-shadow: none;
    }

    .jobs-pagination .page-item.active .page-link {
        background: var(--connector-green);
        border-color: var(--connector-green);
        color: #fff;
    }

    .jobs-pagination .page-link:hover {
        background: var(--connector-soft-2);
        border-color: var(--connector-accent);
    }

    /* =========================================================
       LARGE TABLETS
    ========================================================= */

    @media (max-width: 1199.98px) {

        .jobs-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

    }

    /* =========================================================
       TABLETS
    ========================================================= */

    @media (max-width: 991.98px) {

        .jobs-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .jobs-hero {
            padding: 55px 0 105px;
        }

    }

    /* =========================================================
       MOBILE
    ========================================================= */

    @media (max-width: 767.98px) {

        .jobs-hero {
            padding: 48px 0 95px;
        }

        .jobs-hero h1 {
            font-size: 39px;
            letter-spacing: -1.4px;
        }

        .jobs-hero-description {
            font-size: 12px;
        }

        .jobs-search-wrapper {
            margin-top: -50px;
        }

        .jobs-search-form {
            display: block;
        }

        .jobs-search-button {
            width: 100%;
            margin-top: 7px;
        }

        .jobs-main {
            padding-top: 48px;
        }

        .jobs-toolbar {
            display: block;
        }

        .jobs-sort {
            margin-top: 14px;
        }

        .jobs-sort select {
            flex: 1;
        }

    }

    @media (max-width: 575.98px) {

        .jobs-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .jobs-hero h1 {
            font-size: 34px;
        }

        .jobs-toolbar {
            margin-bottom: 18px;
        }

    }
</style>


<div class="jobs-page">

    {{-- =========================================================
         HERO
    ========================================================== --}}

    <section class="jobs-hero">

        <div class="container">

            <div class="jobs-hero-content">

                <div class="jobs-eyebrow">

                    <i class="bi bi-briefcase"></i>

                    Connector Opportunities

                </div>

                <h1>

                    Find your next
                    <span>opportunity.</span>

                </h1>

                <p class="jobs-hero-description">

                    Discover jobs from businesses, organizations and
                    service providers looking for talented people.

                </p>

            </div>

        </div>

    </section>


    {{-- =========================================================
         SEARCH
    ========================================================== --}}

    <div class="jobs-search-wrapper">

        <div class="container">

            <div class="jobs-search-card">

                <form
                    action="{{ url()->current() }}"
                    method="GET"
                    class="jobs-search-form"
                >

                    <div class="jobs-search-input-wrapper">

                        <i class="bi bi-search"></i>

                        <input
                            type="search"
                            name="query"
                            value="{{ $currentQuery }}"
                            class="jobs-search-input"
                            placeholder="Search jobs, skills, companies or locations..."
                            autocomplete="off"
                        >

                    </div>

                    <input
                        type="hidden"
                        name="sort"
                        value="{{ $currentSort }}"
                    >

                    <button
                        type="submit"
                        class="jobs-search-button"
                    >

                        <i class="bi bi-search"></i>

                        Search

                    </button>

                </form>

            </div>

        </div>

    </div>


    {{-- =========================================================
         MAIN
    ========================================================== --}}

    <section class="jobs-main">

        <div class="container">

            {{-- TOOLBAR --}}

            <div class="jobs-toolbar">

                <div>

                    <h2 class="jobs-heading">
                        Latest opportunities
                    </h2>

                    <p class="jobs-count">

                        <strong>
                            {{ number_format($jobCount) }}
                        </strong>

                        {{ $jobCount === 1 ? 'opportunity' : 'opportunities' }}
                        available

                    </p>

                </div>


                <div class="jobs-sort">

                    <label for="jobSort">
                        Sort by
                    </label>

                    <select
                        id="jobSort"
                        onchange="sortJobs(this.value)"
                    >

                        <option
                            value="latest"
                            {{ $currentSort === 'latest' ? 'selected' : '' }}
                        >
                            Latest
                        </option>

                        <option
                            value="deadline"
                            {{ $currentSort === 'deadline' ? 'selected' : '' }}
                        >
                            Deadline
                        </option>

                        <option
                            value="title"
                            {{ $currentSort === 'title' ? 'selected' : '' }}
                        >
                            Title A–Z
                        </option>

                    </select>

                </div>

            </div>


            {{-- ACTIVE SEARCH --}}

            @if($currentQuery)

                <div class="jobs-filter">

                    <a
                        href="{{ url()->current() }}"
                        class="jobs-filter-tag"
                    >

                        <i class="bi bi-search"></i>

                        <span>
                            "{{ $currentQuery }}"
                        </span>

                        <i class="bi bi-x"></i>

                    </a>

                </div>

            @endif


            {{-- =================================================
                 JOBS
            ================================================== --}}

            @if($jobs->count())

                <div class="jobs-grid">

                    @foreach($jobs as $job)

                        @php

                            /*
                             * Safe relationship handling.
                             */
                            $provider = $job->serviceProvider;

                            $providerName = $provider?->user->name
                                ?: 'Service Provider';

                            $description = trim(
                                preg_replace(
                                    '/\s+/',
                                    ' ',
                                    strip_tags($job->description ?? '')
                                )
                            );

                            $status = strtolower(
                                trim($job->status ?? 'open')
                            );

                            $isClosed = in_array(
                                $status,
                                [
                                    'closed',
                                    'expired',
                                    'inactive',
                                    'filled'
                                ],
                                true
                            );

                            $deadline = $job->deadline
                                ? $job->deadline->format('M d, Y')
                                : null;

                        @endphp


                        <article class="job-card">

                            {{-- =====================================
                                 TOP
                            ====================================== --}}

                            <div class="job-card-top">

                                <div class="job-provider">

                                    <div class="job-provider-logo">

                                        @if($provider && !empty($provider->logo))

                                            <img
                                                src="{{ asset('image/service-provider/' . $provider->logo) }}"
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


                                    <div class="job-provider-info">

                                        <p class="job-provider-name">
                                            {{ $providerName }}
                                        </p>

                                        <span class="job-provider-label">
                                            Service provider
                                        </span>

                                    </div>

                                </div>


                                <a
                                    href="{{ route('home.jobs.show', $job->id) }}"
                                    class="job-open-icon"
                                    aria-label="View {{ $job->title }}"
                                    title="View opportunity"
                                >
                                    <i class="bi bi-arrow-up-right"></i>
                                </a>

                            </div>


                            {{-- =====================================
                                 TITLE
                            ====================================== --}}

                            <h3 class="job-title">

                                <a
                                    href="{{ route('home.jobs.show', $job->id) }}"
                                >

                                    {{ $job->title }}

                                </a>

                            </h3>


                            {{-- =====================================
                                 DESCRIPTION
                            ====================================== --}}

                            <p class="job-description">

                                @if($description)

                                    {{ Str::limit($description, 105) }}

                                @else

                                    Explore this opportunity to learn
                                    more about the position.

                                @endif

                            </p>


                            {{-- =====================================
                                 META
                            ====================================== --}}

                            <div class="job-meta">

                                @if(filled($job->location))

                                    <div class="job-meta-item">

                                        <i class="bi bi-geo-alt"></i>

                                        <span>
                                            {{ $job->location }}
                                        </span>

                                    </div>

                                @endif


                                @if(filled($job->type))

                                    <div class="job-meta-item">

                                        <i class="bi bi-briefcase"></i>

                                        <span>
                                            {{ $job->type }}
                                        </span>

                                    </div>

                                @endif

                            </div>


                            {{-- =====================================
                                 DEADLINE
                            ====================================== --}}

                            @if($deadline)

                                <div class="job-deadline">

                                    <i class="bi bi-calendar3"></i>

                                    Deadline:

                                    <strong>
                                        {{ $deadline }}
                                    </strong>

                                </div>

                            @endif


                            {{-- =====================================
                                 FOOTER
                            ====================================== --}}

                            <div class="job-card-footer">

                                <span
                                    class="job-status {{ $isClosed ? 'closed' : '' }}"
                                >

                                    <span class="job-status-dot"></span>

                                    {{ ucfirst($status) }}

                                </span>


                                <a
                                    href="{{ route('home.jobs.show', $job->id) }}"
                                    class="job-view-button"
                                >

                                    View job

                                    <i class="bi bi-arrow-right"></i>

                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- PAGINATION --}}

                @if(
                    $jobs instanceof LengthAwarePaginator &&
                    $jobs->hasPages()
                )

                    <div class="jobs-pagination">

                        {{ $jobs->onEachSide(1)->links('pagination::bootstrap-5') }}

                    </div>

                @endif


            @else

                {{-- EMPTY STATE --}}

                <div class="jobs-empty">

                    <div class="jobs-empty-icon">

                        <i class="bi bi-search"></i>

                    </div>

                    <h3>
                        No opportunities found
                    </h3>

                    <p>
                        We couldn't find any opportunities matching
                        your search. Try another keyword or browse
                        all available jobs.
                    </p>

                    <a
                        href="{{ url()->current() }}"
                        class="jobs-reset"
                    >

                        <i class="bi bi-arrow-counterclockwise"></i>

                        View all jobs

                    </a>

                </div>

            @endif

        </div>

    </section>

</div>


<script>
    function sortJobs(value) {

        const url = new URL(window.location.href);

        url.searchParams.set('sort', value);

        // Always restart pagination after changing sorting.
        url.searchParams.delete('page');

        window.location.href = url.toString();
    }
</script>

@endsection