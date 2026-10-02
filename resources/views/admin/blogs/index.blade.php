@extends('layouts.app')

@section('title', 'Blog')

@section('content')

@php
    $totalBlogs = $blogs->count();

    $publishedBlogs = $blogs->where('status', 'approved')->count();

    $pendingBlogs = $blogs->where('status', 'pending')->count();

    $featuredBlogs = $blogs->where('featured', 1)->count();

    $totalViews = $blogs->sum('views');

    $categories = $blogs
        ->pluck('blog_category')
        ->filter()
        ->unique()
        ->sort();
@endphp

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-dark: #254035;
        --connector-light: #edf4f1;
        --connector-border: #e3ebe7;
        --connector-muted: #75837c;
        --connector-bg: #f7f9f8;
    }

    .blog-page {
        padding: 24px 0 45px;
        background: var(--connector-bg);
        min-height: calc(100vh - 100px);
    }

    /* HEADER */

    .blog-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 25px;
    }

    .blog-heading h1 {
        margin: 0 0 5px;
        color: var(--connector-dark);
        font-size: 25px;
        font-weight: 850;
        letter-spacing: -.5px;
    }

    .blog-heading p {
        margin: 0;
        color: var(--connector-muted);
        font-size: 12px;
    }

    .create-blog-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 42px;
        padding: 0 17px;
        border-radius: 10px;
        background: var(--connector-dark);
        color: #fff;
        text-decoration: none;
        font-size: 12px;
        font-weight: 750;
        transition: .2s ease;
    }

    .create-blog-btn:hover {
        background: #1d332a;
        color: #fff;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .create-blog-btn svg {
        width: 16px;
        height: 16px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
    }

    /* ALERT */

    .blog-alert {
        border: 0;
        border-radius: 11px;
        padding: 13px 16px;
        margin-bottom: 20px;
        background: #edf7f1;
        color: #2e6548;
        font-size: 12px;
        font-weight: 650;
    }

    /* STATISTICS */

    .blog-stat {
        height: 100%;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 13px;
        box-shadow: 0 5px 20px rgba(37, 64, 53, .035);
    }

    .blog-stat-icon {
        width: 43px;
        height: 43px;
        flex: 0 0 43px;
        border-radius: 11px;
        background: var(--connector-light);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .blog-stat-icon svg {
        width: 20px;
        height: 20px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.7;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .blog-stat-label {
        margin-bottom: 3px;
        color: var(--connector-muted);
        font-size: 10px;
        font-weight: 650;
    }

    .blog-stat-value {
        color: var(--connector-dark);
        font-size: 20px;
        font-weight: 850;
        line-height: 1;
    }

    /* TOOLBAR */

    .blog-toolbar {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        padding: 14px;
        margin-top: 25px;
        margin-bottom: 15px;
    }

    .blog-toolbar-inner {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .blog-search {
        position: relative;
        flex: 1;
        min-width: 230px;
    }

    .blog-search svg {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        fill: none;
        stroke: #84918b;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .blog-search input,
    .blog-filter {
        height: 40px;
        border: 1px solid var(--connector-border);
        background: #fafcfb;
        border-radius: 9px;
        color: var(--connector-dark);
        font-size: 11px;
        outline: none;
    }

    .blog-search input {
        width: 100%;
        padding: 0 13px 0 38px;
    }

    .blog-filter {
        min-width: 145px;
        padding: 0 12px;
    }

    .blog-search input:focus,
    .blog-filter:focus {
        border-color: var(--connector-primary);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .08);
    }

    /* BLOG LIST */

    .blog-list-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(37, 64, 53, .035);
    }

    .blog-list-header {
        padding: 16px 18px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .blog-list-title {
        color: var(--connector-dark);
        font-size: 13px;
        font-weight: 800;
        margin: 0;
    }

    .blog-list-subtitle {
        color: var(--connector-muted);
        font-size: 10px;
    }

    .blog-table {
        width: 100%;
        border-collapse: collapse;
    }

    .blog-table thead th {
        background: #fafcfb;
        color: #7b8982;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .5px;
        padding: 12px 15px;
        border-bottom: 1px solid var(--connector-border);
        white-space: nowrap;
    }

    .blog-table tbody td {
        padding: 13px 15px;
        border-bottom: 1px solid #edf1ef;
        vertical-align: middle;
    }

    .blog-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .blog-table tbody tr {
        transition: .15s ease;
    }

    .blog-table tbody tr:hover {
        background: #fbfcfc;
    }

    /* BLOG */

    .blog-info {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 300px;
    }

    .blog-image {
        width: 62px;
        height: 48px;
        flex: 0 0 62px;
        border-radius: 9px;
        overflow: hidden;
        background: var(--connector-light);
    }

    .blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .blog-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--connector-primary);
    }

    .blog-image-placeholder svg {
        width: 20px;
        height: 20px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.5;
    }

    .blog-title {
        color: var(--connector-dark);
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        display: block;
        max-width: 330px;
    }

    .blog-title:hover {
        color: var(--connector-primary);
        text-decoration: none;
    }

    .blog-excerpt {
        color: #8a9690;
        font-size: 10px;
        margin-top: 4px;
        max-width: 330px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* CATEGORY */

    .category-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 7px;
        background: var(--connector-light);
        color: var(--connector-dark);
        font-size: 9px;
        font-weight: 750;
        white-space: nowrap;
    }

    /* STATUS */

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 7px;
        font-size: 9px;
        font-weight: 750;
        text-transform: capitalize;
    }

    .status-badge::before {
        content: "";
        width: 5px;
        height: 5px;
        border-radius: 50%;
    }

    .status-approved {
        background: #edf7f1;
        color: #347153;
    }

    .status-approved::before {
        background: #4e9b70;
    }

    .status-pending {
        background: #fff7e8;
        color: #9b7131;
    }

    .status-pending::before {
        background: #d59b3c;
    }

    .status-rejected {
        background: #fff0f0;
        color: #a54e4e;
    }

    .status-rejected::before {
        background: #c76060;
    }

    /* FEATURED */

    .featured-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: #a07828;
        font-size: 10px;
        font-weight: 750;
    }

    .featured-badge svg {
        width: 13px;
        height: 13px;
        fill: currentColor;
        stroke: currentColor;
        stroke-width: 1.3;
    }

    /* META */

    .blog-meta {
        color: #7f8c86;
        font-size: 10px;
        white-space: nowrap;
    }

    .blog-meta strong {
        color: var(--connector-dark);
        font-weight: 750;
    }

    /* ACTIONS */

    .blog-actions {
        display: flex;
        align-items: center;
        gap: 5px;
        justify-content: flex-end;
    }

    .blog-action {
        width: 32px;
        height: 32px;
        border: 1px solid var(--connector-border);
        border-radius: 8px;
        background: #fff;
        color: #718078;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        cursor: pointer;
        transition: .18s ease;
    }

    .blog-action:hover {
        background: var(--connector-light);
        color: var(--connector-dark);
        border-color: #cad9d2;
        text-decoration: none;
    }

    .blog-action.delete:hover {
        background: #fff1f1;
        border-color: #efcccc;
        color: #b34f4f;
    }

    .blog-action.approve:hover {
        background: #edf7f1;
        color: #347153;
    }

    .blog-action svg {
        width: 15px;
        height: 15px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.7;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* EMPTY */

    .blog-empty {
        text-align: center;
        padding: 65px 25px;
    }

    .blog-empty-icon {
        width: 65px;
        height: 65px;
        margin: 0 auto 15px;
        background: var(--connector-light);
        color: var(--connector-primary);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .blog-empty-icon svg {
        width: 29px;
        height: 29px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.5;
    }

    .blog-empty h3 {
        margin: 0 0 6px;
        color: var(--connector-dark);
        font-size: 16px;
        font-weight: 800;
    }

    .blog-empty p {
        margin: 0 0 18px;
        color: var(--connector-muted);
        font-size: 11px;
    }

    /* MOBILE */

    @media (max-width: 991px) {

        .blog-info {
            min-width: 250px;
        }

        .blog-table-wrapper {
            overflow-x: auto;
        }

        .blog-table {
            min-width: 950px;
        }
    }

    @media (max-width: 767px) {

        .blog-page {
            padding-top: 15px;
        }

        .blog-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .create-blog-btn {
            width: 100%;
            justify-content: center;
        }

        .blog-toolbar-inner {
            flex-direction: column;
            align-items: stretch;
        }

        .blog-search {
            min-width: 100%;
        }

        .blog-filter {
            width: 100%;
        }
    }
</style>


<div class="blog-page">

    <div class="container-fluid">

        {{-- HEADER --}}

        <div class="blog-header">

            <div class="blog-heading">

                <h1>Blog</h1>

                <p>
                    Create, manage and publish content on Connector.
                </p>

            </div>

            <a
                href="{{ route('admin.add_blog') }}"
                class="create-blog-btn"
            >

                <svg viewBox="0 0 24 24">
                    <path d="M12 5v14"></path>
                    <path d="M5 12h14"></path>
                </svg>

                Create article

            </a>

        </div>


        {{-- FLASH MESSAGE --}}

        @if(Session::has('message'))

            <div class="blog-alert">
                {{ Session::get('message') }}
            </div>

        @endif


        {{-- STATISTICS --}}

        <div class="row">

            <div class="col-xl-3 col-md-6 mb-3">

                <div class="blog-stat">

                    <div class="blog-stat-icon">

                        <svg viewBox="0 0 24 24">
                            <path d="M4 5h16v14H4z"></path>
                            <path d="M8 9h8"></path>
                            <path d="M8 13h6"></path>
                        </svg>

                    </div>

                    <div>
                        <div class="blog-stat-label">
                            Total articles
                        </div>

                        <div class="blog-stat-value">
                            {{ $totalBlogs }}
                        </div>
                    </div>

                </div>

            </div>


            <div class="col-xl-3 col-md-6 mb-3">

                <div class="blog-stat">

                    <div class="blog-stat-icon">

                        <svg viewBox="0 0 24 24">
                            <path d="M5 12.5 9.5 17 19 7"></path>
                        </svg>

                    </div>

                    <div>
                        <div class="blog-stat-label">
                            Published
                        </div>

                        <div class="blog-stat-value">
                            {{ $publishedBlogs }}
                        </div>
                    </div>

                </div>

            </div>


            <div class="col-xl-3 col-md-6 mb-3">

                <div class="blog-stat">

                    <div class="blog-stat-icon">

                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="8"></circle>
                            <path d="M12 8v5l3 2"></path>
                        </svg>

                    </div>

                    <div>
                        <div class="blog-stat-label">
                            Pending
                        </div>

                        <div class="blog-stat-value">
                            {{ $pendingBlogs }}
                        </div>
                    </div>

                </div>

            </div>


            <div class="col-xl-3 col-md-6 mb-3">

                <div class="blog-stat">

                    <div class="blog-stat-icon">

                        <svg viewBox="0 0 24 24">
                            <path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3Z"></path>
                        </svg>

                    </div>

                    <div>
                        <div class="blog-stat-label">
                            Featured
                        </div>

                        <div class="blog-stat-value">
                            {{ $featuredBlogs }}
                        </div>
                    </div>

                </div>

            </div>

        </div>


        {{-- FILTERS --}}

        <div class="blog-toolbar">

            <div class="blog-toolbar-inner">

                <div class="blog-search">

                    <svg viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="7"></circle>
                        <path d="m20 20-4-4"></path>
                    </svg>

                    <input
                        type="text"
                        id="blogSearch"
                        placeholder="Search articles..."
                    >

                </div>


                <select
                    class="blog-filter"
                    id="categoryFilter"
                >

                    <option value="">
                        All categories
                    </option>

                    @foreach($categories as $category)

                        <option value="{{ strtolower($category) }}">
                            {{ $category }}
                        </option>

                    @endforeach

                </select>


                <select
                    class="blog-filter"
                    id="statusFilter"
                >

                    <option value="">
                        All statuses
                    </option>

                    <option value="approved">
                        Published
                    </option>

                    <option value="pending">
                        Pending
                    </option>

                    <option value="rejected">
                        Rejected
                    </option>

                </select>


                <select
                    class="blog-filter"
                    id="featuredFilter"
                >

                    <option value="">
                        All articles
                    </option>

                    <option value="featured">
                        Featured
                    </option>

                    <option value="regular">
                        Regular
                    </option>

                </select>

            </div>

        </div>


        {{-- BLOG LIST --}}

        <div class="blog-list-card">

            <div class="blog-list-header">

                <div>

                    <h3 class="blog-list-title">
                        Articles
                    </h3>

                    <div class="blog-list-subtitle">
                        Manage your published and draft content
                    </div>

                </div>

                <div class="blog-list-subtitle">
                    {{ $totalBlogs }} total
                </div>

            </div>


            @if($blogs->count())

                <div class="blog-table-wrapper">

                    <table class="blog-table">

                        <thead>

                            <tr>

                                <th>
                                    Article
                                </th>

                                <th>
                                    Category
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Performance
                                </th>

                                <th>
                                    Date
                                </th>

                                <th class="text-right">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody id="blogTableBody">

                            @foreach($blogs as $blog)

                                <tr
                                    class="blog-row"
                                    data-title="{{ strtolower($blog->title ?? '') }}"
                                    data-category="{{ strtolower($blog->blog_category ?? '') }}"
                                    data-status="{{ strtolower($blog->status ?? '') }}"
                                    data-featured="{{ $blog->featured ? 'featured' : 'regular' }}"
                                >

                                    {{-- ARTICLE --}}

                                    <td>

                                        <div class="blog-info">

                                            <div class="blog-image">

                                                @if($blog->image)

                                                    <img
                                                        src="{{ asset('image/blog/' . $blog->image) }}"
                                                        alt="{{ $blog->title }}"
                                                    >

                                                @else

                                                    <div class="blog-image-placeholder">

                                                        <svg viewBox="0 0 24 24">
                                                            <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                                                            <circle cx="8.5" cy="9" r="1.5"></circle>
                                                            <path d="m4 17 5-5 3 3 2-2 6 5"></path>
                                                        </svg>

                                                    </div>

                                                @endif

                                            </div>


                                            <div>

                                                <a
                                                    href="{{ route('admin.blog_detail', $blog->slug) }}"
                                                    class="blog-title"
                                                >
                                                    {{ Str::limit($blog->title, 55) }}
                                                </a>

                                                <div class="blog-excerpt">
                                                    {{ Str::limit(strip_tags($blog->content), 75) }}
                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- CATEGORY --}}

                                    <td>

                                        <span class="category-badge">

                                            {{ $blog->blog_category ?: 'Uncategorized' }}

                                        </span>

                                    </td>


                                    {{-- STATUS --}}

                                    <td>

                                        @php
                                            $status = strtolower($blog->status ?? 'pending');

                                            $statusClass = match ($status) {
                                                'approved', 'published' => 'status-approved',
                                                'rejected' => 'status-rejected',
                                                default => 'status-pending',
                                            };
                                        @endphp

                                        <span class="status-badge {{ $statusClass }}">
                                            {{ $status === 'approved' ? 'Published' : ucfirst($status) }}
                                        </span>

                                    </td>


                                    {{-- PERFORMANCE --}}

                                    <td>

                                        <div class="blog-meta">

                                            <strong>
                                                {{ number_format($blog->views ?? 0) }}
                                            </strong>
                                            views

                                            @if(method_exists($blog, 'comments'))

                                                <span class="ml-1">
                                                    ·
                                                    <strong>
                                                        {{ $blog->comments()->count() }}
                                                    </strong>
                                                    comments
                                                </span>

                                            @endif

                                        </div>


                                        @if($blog->featured)

                                            <div class="featured-badge mt-1">

                                                <svg viewBox="0 0 24 24">
                                                    <path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3Z"></path>
                                                </svg>

                                                Featured

                                            </div>

                                        @endif

                                    </td>


                                    {{-- DATE --}}

                                    <td>

                                        <div class="blog-meta">

                                            {{ $blog->created_at ? $blog->created_at->format('M d, Y') : '-' }}

                                        </div>

                                    </td>


                                    {{-- ACTIONS --}}

                                    <td>

                                        <div class="blog-actions">

                                            {{-- VIEW --}}

                                            <a
                                                href="{{ route('admin.blog_detail', $blog->slug) }}"
                                                class="blog-action"
                                                title="View article"
                                            >

                                                <svg viewBox="0 0 24 24">
                                                    <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"></path>
                                                    <circle cx="12" cy="12" r="2.7"></circle>
                                                </svg>

                                            </a>


                                            {{-- EDIT --}}

                                            <a
                                                href="{{ route('admin.edit_blog', $blog->id) }}"
                                                class="blog-action"
                                                title="Edit article"
                                            >

                                                <svg viewBox="0 0 24 24">
                                                    <path d="M12 20h9"></path>
                                                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4L16.5 3.5Z"></path>
                                                </svg>

                                            </a>


                                            {{-- APPROVE --}}

                                            @if(strtolower($blog->status ?? '') !== 'approved')

                                                <a
                                                    href="{{ route('admin.blogApprove', $blog->id) }}"
                                                    class="blog-action approve"
                                                    title="Approve article"
                                                    onclick="return confirm('Approve this article?')"
                                                >

                                                    <svg viewBox="0 0 24 24">
                                                        <path d="m5 12 4 4L19 6"></path>
                                                    </svg>

                                                </a>

                                            @endif


                                            {{-- DELETE --}}

                                            <form
                                                action="{{ route('admin.blog_delete', $blog->id) }}"
                                                method="POST"
                                                style="margin:0;"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="blog-action delete"
                                                    title="Delete article"
                                                    onclick="return confirm('Are you sure you want to delete this blog?')"
                                                >

                                                    <svg viewBox="0 0 24 24">
                                                        <path d="M4 7h16"></path>
                                                        <path d="M9 7V4h6v3"></path>
                                                        <path d="M7 7l1 13h8l1-13"></path>
                                                        <path d="M10 11v5"></path>
                                                        <path d="M14 11v5"></path>
                                                    </svg>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- NO SEARCH RESULTS --}}

                <div
                    id="noSearchResults"
                    class="blog-empty"
                    style="display:none;"
                >

                    <div class="blog-empty-icon">

                        <svg viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="m20 20-4-4"></path>
                        </svg>

                    </div>

                    <h3>
                        No articles found
                    </h3>

                    <p>
                        Try changing your search or filters.
                    </p>

                </div>

            @else

                {{-- EMPTY DATABASE --}}

                <div class="blog-empty">

                    <div class="blog-empty-icon">

                        <svg viewBox="0 0 24 24">
                            <path d="M4 5h16v14H4z"></path>
                            <path d="M8 9h8"></path>
                            <path d="M8 13h6"></path>
                        </svg>

                    </div>

                    <h3>
                        No articles yet
                    </h3>

                    <p>
                        Start publishing useful content for your Connector community.
                    </p>

                    <a
                        href="{{ route('admin.create_blog') }}"
                        class="create-blog-btn"
                    >
                        <svg viewBox="0 0 24 24">
                            <path d="M12 5v14"></path>
                            <path d="M5 12h14"></path>
                        </svg>

                        Create your first article
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const search = document.getElementById('blogSearch');
    const category = document.getElementById('categoryFilter');
    const status = document.getElementById('statusFilter');
    const featured = document.getElementById('featuredFilter');

    const rows = document.querySelectorAll('.blog-row');
    const empty = document.getElementById('noSearchResults');


    function filterBlogs() {

        const searchValue = search
            ? search.value.toLowerCase().trim()
            : '';

        const categoryValue = category
            ? category.value.toLowerCase()
            : '';

        const statusValue = status
            ? status.value.toLowerCase()
            : '';

        const featuredValue = featured
            ? featured.value.toLowerCase()
            : '';

        let visibleCount = 0;


        rows.forEach(function (row) {

            const title = row.dataset.title || '';
            const rowCategory = row.dataset.category || '';
            const rowStatus = row.dataset.status || '';
            const rowFeatured = row.dataset.featured || '';


            const matchesSearch =
                !searchValue ||
                title.includes(searchValue);


            const matchesCategory =
                !categoryValue ||
                rowCategory === categoryValue;


            const matchesStatus =
                !statusValue ||
                rowStatus === statusValue;


            const matchesFeatured =
                !featuredValue ||
                rowFeatured === featuredValue;


            const visible =
                matchesSearch &&
                matchesCategory &&
                matchesStatus &&
                matchesFeatured;


            if (visible) {

                row.style.display = '';

                visibleCount++;

            } else {

                row.style.display = 'none';

            }

        });


        if (empty) {

            empty.style.display =
                visibleCount === 0
                    ? 'block'
                    : 'none';

        }

    }


    if (search) {
        search.addEventListener('input', filterBlogs);
    }

    if (category) {
        category.addEventListener('change', filterBlogs);
    }

    if (status) {
        status.addEventListener('change', filterBlogs);
    }

    if (featured) {
        featured.addEventListener('change', filterBlogs);
    }

});
</script>

@endsection