@extends('layouts.app')

@section('title', 'Provider Blogs')

@section('content')

@php
    use Illuminate\Support\Str;

    $currentStatus = request('status');
    $currentSearch = request('search');

    /*
    |--------------------------------------------------------------------------
    | Status helper
    |--------------------------------------------------------------------------
    */
    $statusConfig = function ($status) {

        $status = strtolower((string) $status);

        return match ($status) {
            'published', 'approved', 'active' => [
                'label' => ucfirst($status),
                'class' => 'status-success',
                'icon'  => 'mdi-check-circle-outline',
            ],

            'pending', 'submitted' => [
                'label' => 'Pending',
                'class' => 'status-warning',
                'icon'  => 'mdi-clock-outline',
            ],

            'draft', 'inactive' => [
                'label' => ucfirst($status),
                'class' => 'status-secondary',
                'icon'  => 'mdi-file-document-outline',
            ],

            'rejected' => [
                'label' => 'Rejected',
                'class' => 'status-danger',
                'icon'  => 'mdi-close-circle-outline',
            ],

            default => [
                'label' => ucfirst($status ?: 'Unknown'),
                'class' => 'status-secondary',
                'icon'  => 'mdi-information-outline',
            ],
        };
    };
@endphp

<div class="content-wrapper provider-blog-page">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="blog-header">

        <div class="header-content">

            <div class="header-icon">
                <i class="mdi mdi-post-outline"></i>
            </div>

            <div>
                <div class="header-eyebrow">
                    CONTENT MANAGEMENT
                </div>

                <h2>
                    Provider Blogs
                </h2>

                <p>
                    Create, manage and monitor your published content.
                </p>
            </div>

        </div>

        <a
            href="{{ route('serviceProviderBlog.CreateBlog') }}"
            class="btn btn-create"
        >
            <i class="mdi mdi-plus"></i>
            Add Blog
        </a>

    </div>


    {{-- =========================================================
        STATISTICS
    ========================================================== --}}
    <div class="row g-4 mb-4">

        {{-- Total --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="mdi mdi-post-outline"></i>
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Total Blogs
                    </span>

                    <strong>
                        {{ number_format($stats['total']) }}
                    </strong>

                    <small>
                        All your articles
                    </small>

                </div>

            </div>

        </div>


        {{-- Published --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon success">
                    <i class="mdi mdi-check-circle-outline"></i>
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Published
                    </span>

                    <strong>
                        {{ number_format($stats['published']) }}
                    </strong>

                    <small>
                        Live content
                    </small>

                </div>

            </div>

        </div>


        {{-- Pending --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon warning">
                    <i class="mdi mdi-clock-outline"></i>
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Pending
                    </span>

                    <strong>
                        {{ number_format($stats['pending']) }}
                    </strong>

                    <small>
                        Awaiting review
                    </small>

                </div>

            </div>

        </div>


        {{-- Views --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon views">
                    <i class="mdi mdi-eye-outline"></i>
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Total Views
                    </span>

                    <strong>
                        {{ number_format($stats['views']) }}
                    </strong>

                    <small>
                        Across all blogs
                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        MAIN CARD
    ========================================================== --}}
    <div class="blog-card">

        {{-- Card Header --}}
        <div class="blog-card-header">

            <div>

                <h4>
                    Your Blog Posts
                </h4>

                <p>
                    Manage your articles and content.
                </p>

            </div>

            <div class="blog-count">
                {{ $blogs->total() }}
                {{ Str::plural('blog', $blogs->total()) }}
            </div>

        </div>


        {{-- =====================================================
            FILTERS
        ====================================================== --}}
        <div class="filter-section">

            <form
                method="GET"
                action="{{ route('serviceProviderBlog.index') }}"
                class="row g-3 align-items-end"
            >

                {{-- Search --}}
                <div class="col-lg-6">

                    <label class="filter-label">
                        Search blogs
                    </label>

                    <div class="search-box">

                        <i class="mdi mdi-magnify"></i>

                        <input
                            type="text"
                            name="search"
                            value="{{ $currentSearch }}"
                            class="form-control"
                            placeholder="Search by title or content..."
                        >

                    </div>

                </div>


                {{-- Status --}}
                <div class="col-lg-3">

                    <label class="filter-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select"
                    >

                        <option value="">
                            All statuses
                        </option>

                        <option
                            value="published"
                            {{ $currentStatus === 'published' ? 'selected' : '' }}
                        >
                            Published
                        </option>

                        <option
                            value="pending"
                            {{ $currentStatus === 'pending' ? 'selected' : '' }}
                        >
                            Pending
                        </option>

                        <option
                            value="draft"
                            {{ $currentStatus === 'draft' ? 'selected' : '' }}
                        >
                            Draft
                        </option>

                        <option
                            value="rejected"
                            {{ $currentStatus === 'rejected' ? 'selected' : '' }}
                        >
                            Rejected
                        </option>

                    </select>

                </div>


                {{-- Buttons --}}
                <div class="col-lg-3">

                    <div class="filter-actions">

                        <button
                            type="submit"
                            class="btn btn-filter"
                        >
                            <i class="mdi mdi-filter-outline"></i>
                            Filter
                        </button>

                        <a
                            href="{{ route('serviceProviderBlog.index') }}"
                            class="btn btn-clear"
                        >
                            Clear
                        </a>

                    </div>

                </div>

            </form>

        </div>


        {{-- =====================================================
            BLOG LIST
        ====================================================== --}}
        @if($blogs->count())

            <div class="table-responsive">

                <table class="table blog-table">

                    <thead>

                        <tr>

                            <th>
                                Blog
                            </th>

                            <th>
                                Category
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Views
                            </th>

                            <th>
                                Created
                            </th>

                            <th class="text-end">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($blogs as $blog)

                            @php
                                $status = $statusConfig($blog->status);

                                $title = $blog->title ?: 'Untitled Blog';

                                $categoryName =
                                    $blog->category?->name
                                    ?? $blog->blog_category
                                    ?? 'Uncategorized';

                                $subcategoryName =
                                    $blog->subcategory?->name;

                                $image = $blog->thumbnail
                                    ?: $blog->image;
                            @endphp

                            <tr>

                                {{-- Blog --}}
                                <td>

                                    <div class="blog-info">

                                        <div class="blog-thumbnail">

                                            @if($image)

                                                <img
                                                    src="{{ asset('image/blogs/' . $image) }}"
                                                    alt="{{ $title }}"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                >

                                                <div
                                                    class="thumbnail-placeholder"
                                                    style="display:none;"
                                                >
                                                    <i class="mdi mdi-post-outline"></i>
                                                </div>

                                            @else

                                                <div class="thumbnail-placeholder">

                                                    <i class="mdi mdi-post-outline"></i>

                                                </div>

                                            @endif

                                        </div>


                                        <div class="blog-text">

                                            <h6>
                                                {{ Str::limit($title, 55) }}
                                            </h6>

                                            @if($blog->slug)

                                                <span>
                                                    /{{ Str::limit($blog->slug, 45) }}
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Category --}}
                                <td>

                                    <div class="category-wrapper">

                                        <span class="category-name">
                                            {{ $categoryName }}
                                        </span>

                                        @if($subcategoryName)

                                            <small>
                                                {{ $subcategoryName }}
                                            </small>

                                        @endif

                                    </div>

                                </td>


                                {{-- Status --}}
                                <td>

                                    <span class="status-badge {{ $status['class'] }}">

                                        <i class="mdi {{ $status['icon'] }}"></i>

                                        {{ $status['label'] }}

                                    </span>

                                </td>


                                {{-- Views --}}
                                <td>

                                    <div class="views-count">

                                        <i class="mdi mdi-eye-outline"></i>

                                        {{ number_format($blog->views ?? 0) }}

                                    </div>

                                </td>


                                {{-- Created --}}
                                <td>

                                    <div class="date-wrapper">

                                        <strong>
                                            {{ optional($blog->created_at)->format('d M Y') }}
                                        </strong>

                                        <small>
                                            {{ optional($blog->created_at)->format('h:i A') }}
                                        </small>

                                    </div>

                                </td>


                                {{-- Actions --}}
                                <td class="text-end">

                                    <div class="action-buttons">

                                        {{-- View --}}
                                        <a
                                            href="{{ route('serviceProviderBlog.blogDetail', $blog->slug) }}"
                                            class="action-btn view"
                                            title="View blog"
                                        >
                                            <i class="mdi mdi-eye-outline"></i>
                                        </a>


                                        {{-- Delete --}}
                                        <form
                                            action="{{ route('serviceProviderBlog.blogDelete', $blog->id) }}"
                                            method="POST"
                                            class="delete-blog-form"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn delete"
                                                title="Delete blog"
                                            >
                                                <i class="mdi mdi-delete-outline"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- =================================================
                PAGINATION
            ================================================== --}}
            @if($blogs->hasPages())

                <div class="pagination-wrapper">

                    <div class="pagination-info">

                        Showing

                        <strong>
                            {{ $blogs->firstItem() }}
                        </strong>

                        to

                        <strong>
                            {{ $blogs->lastItem() }}
                        </strong>

                        of

                        <strong>
                            {{ $blogs->total() }}
                        </strong>

                    </div>

                    <div>
                        {{ $blogs->links() }}
                    </div>

                </div>

            @endif

        @else

            {{-- =================================================
                EMPTY STATE
            ================================================== --}}
            <div class="empty-state">

                <div class="empty-icon">

                    <i class="mdi mdi-post-outline"></i>

                </div>

                @if($currentSearch || $currentStatus)

                    <h5>
                        No blogs found
                    </h5>

                    <p>
                        No blog posts match your current filters.
                    </p>

                    <a
                        href="{{ route('serviceProviderBlog.index') }}"
                        class="btn btn-clear"
                    >
                        Clear Filters
                    </a>

                @else

                    <h5>
                        No blogs yet
                    </h5>

                    <p>
                        Start sharing your expertise by creating your first blog post.
                    </p>

                    <a
                        href="{{ route('serviceProviderBlog.CreateBlog') }}"
                        class="btn btn-create"
                    >
                        <i class="mdi mdi-plus"></i>
                        Create Your First Blog
                    </a>

                @endif

            </div>

        @endif

    </div>

</div>


{{-- =============================================================
    STYLES
============================================================= --}}
<style>

.provider-blog-page {
    background: #f7f9f8;
    min-height: calc(100vh - 70px);
    padding: 28px;
}


/* =============================================================
   HEADER
============================================================= */

.blog-header {
    background: linear-gradient(
        135deg,
        #254035 0%,
        #6B9080 100%
    );

    border-radius: 18px;
    padding: 28px 30px;
    margin-bottom: 25px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    box-shadow: 0 10px 30px rgba(37, 64, 53, .12);
}

.header-content {
    display: flex;
    align-items: center;
    gap: 18px;
}

.header-icon {
    width: 58px;
    height: 58px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 15px;

    background: rgba(255,255,255,.14);
    color: #fff;

    font-size: 28px;
}

.header-eyebrow {
    color: rgba(255,255,255,.7);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    margin-bottom: 4px;
}

.blog-header h2 {
    margin: 0;
    color: #fff;
    font-size: 25px;
    font-weight: 700;
}

.blog-header p {
    margin: 5px 0 0;
    color: rgba(255,255,255,.78);
    font-size: 13px;
}


/* =============================================================
   CREATE BUTTON
============================================================= */

.btn-create {
    background: #fff;
    color: #254035 !important;

    border: 0;
    border-radius: 10px;

    padding: 11px 17px;

    font-size: 13px;
    font-weight: 700;

    display: inline-flex;
    align-items: center;
    gap: 7px;

    transition: all .2s ease;
}

.btn-create:hover {
    background: #f3f7f5;
    transform: translateY(-1px);
}


/* =============================================================
   STAT CARDS
============================================================= */

.stat-card {
    background: #fff;

    border: 1px solid #e8eeeb;
    border-radius: 15px;

    padding: 20px;

    display: flex;
    align-items: center;
    gap: 15px;

    height: 100%;

    transition: all .2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(37,64,53,.07);
}

.stat-icon {
    width: 48px;
    height: 48px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: rgba(107,144,128,.12);
    color: #254035;

    font-size: 22px;
}

.stat-icon.success {
    background: rgba(25,135,84,.10);
    color: #198754;
}

.stat-icon.warning {
    background: rgba(255,193,7,.13);
    color: #a87900;
}

.stat-icon.views {
    background: rgba(13,110,253,.10);
    color: #0d6efd;
}

.stat-content {
    min-width: 0;
}

.stat-label {
    display: block;
    color: #7a8882;
    font-size: 12px;
    margin-bottom: 2px;
}

.stat-content strong {
    display: block;
    color: #254035;
    font-size: 22px;
    line-height: 1.2;
}

.stat-content small {
    color: #9aa59f;
    font-size: 11px;
}


/* =============================================================
   MAIN CARD
============================================================= */

.blog-card {
    background: #fff;

    border: 1px solid #e7eeea;
    border-radius: 17px;

    overflow: hidden;

    box-shadow: 0 5px 20px rgba(37,64,53,.04);
}

.blog-card-header {
    padding: 23px 25px;

    display: flex;
    justify-content: space-between;
    align-items: center;

    border-bottom: 1px solid #edf1ef;
}

.blog-card-header h4 {
    color: #254035;
    margin: 0 0 4px;
    font-size: 17px;
    font-weight: 700;
}

.blog-card-header p {
    margin: 0;
    color: #89958f;
    font-size: 12px;
}

.blog-count {
    background: #eef4f1;
    color: #254035;

    border-radius: 20px;

    padding: 7px 13px;

    font-size: 12px;
    font-weight: 700;
}


/* =============================================================
   FILTER
============================================================= */

.filter-section {
    background: #fafcfb;
    padding: 20px 25px;

    border-bottom: 1px solid #edf1ef;
}

.filter-label {
    display: block;
    color: #52635b;
    font-size: 11px;
    font-weight: 700;

    margin-bottom: 7px;
}

.search-box {
    position: relative;
}

.search-box i {
    position: absolute;

    left: 13px;
    top: 50%;

    transform: translateY(-50%);

    color: #829189;
    font-size: 18px;

    z-index: 2;
}

.search-box .form-control {
    padding-left: 40px;
}

.filter-section .form-control,
.filter-section .form-select {
    height: 42px;

    border: 1px solid #dfe8e3;
    border-radius: 9px;

    color: #254035;
    font-size: 13px;

    box-shadow: none;
}

.filter-section .form-control:focus,
.filter-section .form-select:focus {
    border-color: #6B9080;
    box-shadow: 0 0 0 3px rgba(107,144,128,.10);
}

.filter-actions {
    display: flex;
    gap: 8px;
}

.btn-filter {
    height: 42px;

    background: #254035;
    color: #fff;

    border: 0;
    border-radius: 9px;

    padding: 0 17px;

    font-size: 12px;
    font-weight: 700;

    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

.btn-filter:hover {
    background: #1c3028;
    color: #fff;
}

.btn-clear {
    height: 42px;

    background: #fff;
    color: #52635b;

    border: 1px solid #dfe8e3;
    border-radius: 9px;

    padding: 0 15px;

    font-size: 12px;
    font-weight: 600;

    display: inline-flex;
    align-items: center;
    justify-content: center;
}


/* =============================================================
   TABLE
============================================================= */

.blog-table {
    margin: 0;
}

.blog-table thead th {
    background: #fbfcfc;

    color: #7c8983;

    border-bottom: 1px solid #e8eeeb;
    border-top: 0;

    padding: 14px 18px;

    font-size: 10px;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: .7px;

    white-space: nowrap;
}

.blog-table tbody td {
    padding: 16px 18px;

    vertical-align: middle;

    border-color: #edf1ef;

    color: #52635b;

    font-size: 12px;
}

.blog-table tbody tr {
    transition: background .15s ease;
}

.blog-table tbody tr:hover {
    background: #fafcfb;
}


/* =============================================================
   BLOG INFO
============================================================= */

.blog-info {
    display: flex;
    align-items: center;
    gap: 12px;

    min-width: 280px;
}

.blog-thumbnail {
    width: 54px;
    height: 54px;

    flex-shrink: 0;

    border-radius: 10px;
    overflow: hidden;

    background: #edf3f0;
}

.blog-thumbnail img {
    width: 100%;
    height: 100%;

    object-fit: cover;
}

.thumbnail-placeholder {
    width: 100%;
    height: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #6B9080;
    font-size: 22px;
}

.blog-text {
    min-width: 0;
}

.blog-text h6 {
    color: #254035;

    font-size: 13px;
    font-weight: 700;

    margin: 0 0 4px;

    line-height: 1.45;
}

.blog-text span {
    display: block;

    color: #9aa59f;

    font-size: 10px;

    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;

    max-width: 230px;
}


/* =============================================================
   CATEGORY
============================================================= */

.category-wrapper {
    min-width: 120px;
}

.category-name {
    display: block;

    color: #254035;

    font-weight: 600;
}

.category-wrapper small {
    display: block;

    color: #99a49f;

    font-size: 10px;

    margin-top: 3px;
}


/* =============================================================
   STATUS
============================================================= */

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;

    padding: 6px 9px;

    border-radius: 20px;

    font-size: 10px;
    font-weight: 700;

    white-space: nowrap;
}

.status-success {
    background: #eaf7ef;
    color: #198754;
}

.status-warning {
    background: #fff6dc;
    color: #a87900;
}

.status-danger {
    background: #fdecec;
    color: #c0392b;
}

.status-secondary {
    background: #eef1f0;
    color: #68756f;
}


/* =============================================================
   VIEWS
============================================================= */

.views-count {
    display: inline-flex;
    align-items: center;
    gap: 5px;

    color: #52635b;
    font-weight: 600;
}

.views-count i {
    color: #6B9080;
    font-size: 16px;
}


/* =============================================================
   DATE
============================================================= */

.date-wrapper strong {
    display: block;

    color: #52635b;

    font-size: 11px;
    font-weight: 600;
}

.date-wrapper small {
    display: block;

    color: #a0aaa5;

    font-size: 10px;

    margin-top: 3px;
}


/* =============================================================
   ACTIONS
============================================================= */

.action-buttons {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.action-buttons form {
    margin: 0;
}

.action-btn {
    width: 34px;
    height: 34px;

    border-radius: 8px;

    border: 1px solid #e3eae6;

    background: #fff;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    font-size: 17px;

    transition: all .15s ease;
}

.action-btn.view {
    color: #254035;
}

.action-btn.view:hover {
    background: #eef5f1;
    border-color: #cbdcd3;
}

.action-btn.delete {
    color: #c0392b;
}

.action-btn.delete:hover {
    background: #fff0ef;
    border-color: #f1cbc7;
}


/* =============================================================
   PAGINATION
============================================================= */

.pagination-wrapper {
    padding: 18px 25px;

    border-top: 1px solid #edf1ef;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.pagination-info {
    color: #89958f;
    font-size: 11px;
}

.pagination-info strong {
    color: #52635b;
}


/* Bootstrap pagination */
.pagination {
    margin: 0;
    gap: 4px;
}

.pagination .page-link {
    border: 1px solid #e0e8e3;
    border-radius: 7px !important;

    color: #52635b;

    font-size: 11px;

    padding: 7px 11px;
}

.pagination .page-item.active .page-link {
    background: #254035;
    border-color: #254035;
    color: #fff;
}

.pagination .page-link:hover {
    background: #eef4f1;
    color: #254035;
}


/* =============================================================
   EMPTY STATE
============================================================= */

.empty-state {
    padding: 70px 25px;

    text-align: center;
}

.empty-icon {
    width: 70px;
    height: 70px;

    margin: 0 auto 17px;

    border-radius: 18px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #edf4f1;
    color: #6B9080;

    font-size: 30px;
}

.empty-state h5 {
    color: #254035;

    font-size: 17px;
    font-weight: 700;

    margin-bottom: 7px;
}

.empty-state p {
    color: #89958f;

    font-size: 12px;

    margin-bottom: 20px;
}


/* =============================================================
   RESPONSIVE
============================================================= */

@media (max-width: 991px) {

    .provider-blog-page {
        padding: 20px;
    }

    .blog-header {
        align-items: flex-start;
        flex-direction: column;
        gap: 20px;
    }

    .btn-create {
        width: 100%;
        justify-content: center;
    }

    .filter-actions {
        width: 100%;
    }

    .btn-filter,
    .btn-clear {
        flex: 1;
    }

}

@media (max-width: 767px) {

    .provider-blog-page {
        padding: 15px;
    }

    .blog-header {
        padding: 22px;
        border-radius: 14px;
    }

    .header-icon {
        width: 48px;
        height: 48px;
        font-size: 22px;
    }

    .blog-header h2 {
        font-size: 21px;
    }

    .blog-card-header {
        padding: 18px;
    }

    .filter-section {
        padding: 18px;
    }

    .pagination-wrapper {
        align-items: flex-start;
        flex-direction: column;
        padding: 18px;
    }

}

</style>


{{-- =============================================================
    DELETE CONFIRMATION
============================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-blog-form').forEach(function (form) {

        form.addEventListener('submit', function (event) {

            const confirmed = confirm(
                'Are you sure you want to delete this blog? This action cannot be undone.'
            );

            if (!confirmed) {
                event.preventDefault();
            }

        });

    });

});
</script>

@endsection