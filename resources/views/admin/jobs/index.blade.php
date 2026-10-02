@extends('layouts.app')

@section('title', 'Jobs')

@section('content')

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-dark: #254035;
        --connector-soft: #eef5f2;
        --connector-border: #e6ece9;
        --connector-text: #26332e;
        --connector-muted: #7a8882;
    }

    .jobs-page {
        padding: 28px 0 45px;
    }

    .jobs-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .jobs-title h1 {
        margin: 0;
        color: var(--connector-dark);
        font-size: 27px;
        font-weight: 700;
        letter-spacing: -.4px;
    }

    .jobs-title p {
        margin: 7px 0 0;
        color: var(--connector-muted);
        font-size: 14px;
    }

    .btn-connector {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        background: var(--connector-primary);
        border: 0;
        color: #fff;
        padding: 11px 17px;
        border-radius: 9px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: .2s;
    }

    .btn-connector:hover {
        background: var(--connector-dark);
        color: #fff;
        text-decoration: none;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-label {
        color: var(--connector-muted);
        font-size: 12px;
        margin-bottom: 3px;
    }

    .stat-value {
        color: var(--connector-dark);
        font-size: 23px;
        font-weight: 700;
    }

    .jobs-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 15px;
        overflow: hidden;
    }

    .filters {
        padding: 18px;
        border-bottom: 1px solid var(--connector-border);
        background: #fcfdfc;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: 10px;
    }

    .form-control,
    .form-select {
        height: 43px;
        border: 1px solid #dfe7e3;
        border-radius: 8px;
        font-size: 13px;
        color: var(--connector-text);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--connector-primary);
        box-shadow: 0 0 0 .15rem rgba(107, 144, 128, .12);
    }

    .btn-filter {
        height: 43px;
        padding: 0 17px;
        border: 0;
        border-radius: 8px;
        background: var(--connector-dark);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
    }

    .table-wrap {
        overflow-x: auto;
    }

    .jobs-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .jobs-table th {
        padding: 14px 18px;
        background: #fafcfb;
        color: #74817b;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-weight: 700;
        border-bottom: 1px solid var(--connector-border);
    }

    .jobs-table td {
        padding: 15px 18px;
        border-bottom: 1px solid #edf1ef;
        vertical-align: middle;
        color: var(--connector-text);
        font-size: 13px;
    }

    .jobs-table tbody tr:hover {
        background: #fbfdfc;
    }

    .job-title {
        color: var(--connector-dark);
        font-weight: 650;
        text-decoration: none;
        display: block;
        margin-bottom: 4px;
    }

    .job-title:hover {
        color: var(--connector-primary);
    }

    .job-location,
    .provider-name {
        color: var(--connector-muted);
        font-size: 12px;
    }

    .provider-name {
        color: var(--connector-dark);
        font-weight: 600;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: capitalize;
    }

    .status-active {
        background: #e9f6ef;
        color: #26734d;
    }

    .status-pending {
        background: #fff6df;
        color: #946b12;
    }

    .status-closed {
        background: #f1f3f4;
        color: #66716c;
    }

    .status-draft {
        background: #edf1f5;
        color: #52606b;
    }

    .application-count {
        display: inline-flex;
        min-width: 28px;
        height: 28px;
        align-items: center;
        justify-content: center;
        padding: 0 8px;
        border-radius: 8px;
        background: var(--connector-soft);
        color: var(--connector-dark);
        font-weight: 700;
        font-size: 12px;
    }

    .deadline {
        font-weight: 600;
        color: var(--connector-text);
    }

    .deadline-expired {
        color: #b34b4b;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e0e7e4;
        background: #fff;
        color: #64736c;
        border-radius: 8px;
        text-decoration: none;
        transition: .2s;
    }

    .action-btn:hover {
        color: var(--connector-primary);
        border-color: var(--connector-primary);
        background: var(--connector-soft);
    }

    .action-btn.delete:hover {
        color: #b94a48;
        border-color: #e5b9b8;
        background: #fff5f5;
    }

    .empty-state {
        padding: 65px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 15px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-state h3 {
        color: var(--connector-dark);
        font-size: 18px;
        margin-bottom: 6px;
    }

    .empty-state p {
        color: var(--connector-muted);
        font-size: 13px;
        margin-bottom: 18px;
    }

    .pagination-wrap {
        padding: 17px 18px;
    }

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 600px) {
        .jobs-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }

        .jobs-page {
            padding-top: 18px;
        }
    }
</style>

<div class="container-fluid jobs-page">

    <div class="jobs-header">

        <div class="jobs-title">
            <h1>Jobs</h1>
            <p>Manage job opportunities and applications on Connector.</p>
        </div>

        <a href="{{ route('admin.jobs.create') }}" class="btn-connector">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14" />
            </svg>
            Add Job
        </a>

    </div>

    @if(session('message'))
    <div class="alert alert-success border-0 mb-4">
        {{ session('message') }}
    </div>
    @endif

    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <rect x="3" y="7" width="18" height="13" rx="2" />
                    <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                    <path d="M3 12h18" />
                </svg>
            </div>

            <div>
                <div class="stat-label">Total Jobs</div>
                <div class="stat-value">{{ $totalJobs }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9" />
                    <path d="m9 12 2 2 4-4" />
                </svg>
            </div>

            <div>
                <div class="stat-label">Active Jobs</div>
                <div class="stat-value">{{ $activeJobs }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 7v5l3 2" />
                </svg>
            </div>

            <div>
                <div class="stat-label">Pending</div>
                <div class="stat-value">{{ $pendingJobs }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>

            <div>
                <div class="stat-label">Applications</div>
                <div class="stat-value">{{ $applications }}</div>
            </div>
        </div>

    </div>

    <div class="jobs-card">

        <div class="filters">

            <form method="GET" action="{{ route('admin.jobs') }}">

                <div class="filter-grid">

                    <input
                        type="text"
                        name="query"
                        class="form-control"
                        placeholder="Search jobs, locations or providers..."
                        value="{{ request('query') }}">

                    <select name="status" class="form-select">
                        <option value="">All statuses</option>
                        <option value="active" @selected(request('status')==='active' )>
                            Active
                        </option>
                        <option value="pending" @selected(request('status')==='pending' )>
                            Pending
                        </option>
                        <option value="closed" @selected(request('status')==='closed' )>
                            Closed
                        </option>
                        <option value="draft" @selected(request('status')==='draft' )>
                            Draft
                        </option>
                    </select>

                    <select name="type" class="form-select">
                        <option value="">All types</option>

                        @foreach($types as $type)
                        <option
                            value="{{ $type }}"
                            @selected(request('type')===$type)>
                            {{ ucfirst($type) }}
                        </option>
                        @endforeach
                    </select>

                    <select name="sort" class="form-select">
                        <option value="latest" @selected(request('sort', 'latest' )==='latest' )>
                            Latest
                        </option>
                        <option value="oldest" @selected(request('sort')==='oldest' )>
                            Oldest
                        </option>
                        <option value="deadline" @selected(request('sort')==='deadline' )>
                            Deadline
                        </option>
                        <option value="title" @selected(request('sort')==='title' )>
                            Title
                        </option>
                    </select>

                    <button type="submit" class="btn-filter">
                        Filter
                    </button>

                </div>

            </form>

        </div>

        <div class="table-wrap">

            @if($jobs->count())

            <table class="jobs-table">

                <thead>
                    <tr>
                        <th>Job</th>
                        <th>Service Provider</th>
                        <th>Type</th>
                        <th>Deadline</th>
                        <th>Applications</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($jobs as $job)

                    <tr>

                        <td>
                            <a
                                href="{{ route('admin.jobs.show', $job->id) }}"
                                class="job-title">
                                {{ $job->title }}
                            </a>

                            <div class="job-location">
                                {{ $job->location }}
                            </div>
                        </td>

                        <td>
                            @if($job->serviceProvider && $job->serviceProvider->user)

                            <div class="provider-name">
                                {{ $job->serviceProvider->user->name }}
                            </div>

                            @if($job->serviceProvider->category)
                            <div class="job-location">
                                {{ $job->serviceProvider->category->name ?? '' }}
                            </div>
                            @endif

                            @else

                            <span class="text-muted">
                                No provider
                            </span>

                            @endif
                        </td>

                        <td>
                            {{ ucfirst($job->type) }}
                        </td>

                        <td>
                            <span class="deadline
                                        {{ $job->deadline && $job->deadline->isPast() ? 'deadline-expired' : '' }}">
                                {{ $job->deadline?->format('d M Y') ?? '—' }}
                            </span>
                        </td>

                        <td>
                            <a
                                href="{{ route('admin.jobs.applications', $job->id) }}"
                                class="application-count"
                                title="View applications">
                                {{ $job->applications_count }}
                            </a>
                        </td>

                        <td>
                            <span class="badge-status status-{{ strtolower($job->status) }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    href="{{ route('admin.jobs.show', $job->id) }}"
                                    class="action-btn"
                                    title="View">
                                    <svg width="16" height="16"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>

                                <a
                                    href="{{ route('admin.jobs.edit', $job->id) }}"
                                    class="action-btn"
                                    title="Edit">
                                    <svg width="16" height="16"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M12 20h9" />
                                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                    </svg>
                                </a>

                                <form
                                    action="{{ route('admin.jobs.destroy', $job->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this job?');"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="action-btn delete"
                                        title="Delete">
                                        <svg width="16" height="16"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4h8v2" />
                                            <path d="M19 6l-1 14H6L5 6" />
                                            <path d="M10 11v5M14 11v5" />
                                        </svg>
                                    </button>
                                </form>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            @else

            <div class="empty-state">

                <div class="empty-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="7" width="18" height="13" rx="2" />
                        <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                    </svg>
                </div>

                <h3>No jobs found</h3>

                <p>
                    There are no jobs matching your current filters.
                </p>

                <a
                    href="{{ route('admin.jobs.create') }}"
                    class="btn-connector">
                    Add your first job
                </a>

            </div>

            @endif

        </div>

        @if($jobs->hasPages())
        <div class="pagination-wrap">
            {{ $jobs->links() }}
        </div>
        @endif

    </div>

</div>

@endsection