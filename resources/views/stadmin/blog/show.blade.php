@extends('layouts.app')

@section('title', $blog->title . ' | Blog Detail')

@push('styles')
<style>
    :root {
        --connector-primary: #254035;
        --connector-secondary: #6B9080;
        --connector-light: #f3f7f5;
        --connector-border: #e3ebe7;
        --connector-text: #24342d;
        --connector-muted: #718078;
    }

    .blog-detail-page {
        background: #f7f9f8;
        min-height: calc(100vh - 70px);
        padding: 30px 0 60px;
    }

    /* =========================================================
       Header
    ========================================================= */

    .blog-page-header {
        background: linear-gradient(
            135deg,
            var(--connector-primary),
            #355b4b
        );
        border-radius: 18px;
        padding: 25px 30px;
        margin-bottom: 25px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .blog-page-header::before {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .05);
        right: -80px;
        top: -130px;
    }

    .blog-page-header::after {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .04);
        left: 40%;
        bottom: -100px;
    }

    .header-content {
        position: relative;
        z-index: 2;
    }

    .header-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: rgba(255,255,255,.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    .blog-page-header h1 {
        font-size: 23px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .blog-page-header p {
        margin: 0;
        color: rgba(255,255,255,.72);
        font-size: 13px;
    }

    /* =========================================================
       Main Article
    ========================================================= */

    .article-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 6px 25px rgba(37, 64, 53, .05);
    }

    .article-cover {
        width: 100%;
        height: 430px;
        object-fit: cover;
        display: block;
    }

    .article-body {
        padding: 32px;
    }

    .article-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        color: var(--connector-muted);
        font-size: 13px;
        margin-bottom: 15px;
    }

    .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .meta-item i {
        color: var(--connector-secondary);
    }

    .meta-separator {
        color: #c7d2cd;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--connector-light);
        color: var(--connector-primary);
        border-radius: 30px;
        padding: 7px 13px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .article-title {
        color: var(--connector-text);
        font-size: 34px;
        line-height: 1.25;
        font-weight: 750;
        margin-bottom: 15px;
        letter-spacing: -.5px;
    }

    .article-intro {
        color: var(--connector-muted);
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 28px;
    }

    /* =========================================================
       Article Content
    ========================================================= */

    .entry-content {
        color: #394840;
        font-size: 16px;
        line-height: 1.85;
    }

    .entry-content p {
        margin-bottom: 20px;
    }

    .entry-content h1,
    .entry-content h2,
    .entry-content h3,
    .entry-content h4,
    .entry-content h5,
    .entry-content h6 {
        color: var(--connector-text);
        font-weight: 700;
        line-height: 1.35;
        margin-top: 32px;
        margin-bottom: 15px;
    }

    .entry-content h2 {
        font-size: 25px;
    }

    .entry-content h3 {
        font-size: 21px;
    }

    .entry-content h4 {
        font-size: 18px;
    }

    .entry-content ul,
    .entry-content ol {
        margin-bottom: 22px;
        padding-left: 25px;
    }

    .entry-content li {
        margin-bottom: 8px;
    }

    .entry-content a {
        color: var(--connector-secondary);
        text-decoration: underline;
    }

    .entry-content blockquote {
        border-left: 4px solid var(--connector-secondary);
        background: var(--connector-light);
        padding: 18px 20px;
        margin: 25px 0;
        border-radius: 0 10px 10px 0;
        color: var(--connector-primary);
        font-style: italic;
    }

    .entry-content pre {
        background: #1f2d27;
        color: #e9f1ed;
        border-radius: 10px;
        padding: 18px;
        overflow-x: auto;
        margin: 22px 0;
    }

    .entry-content img {
        max-width: 100%;
        height: auto;
        border-radius: 13px;
        margin: 20px 0;
    }

    .article-thumbnail {
        width: 100%;
        max-height: 380px;
        object-fit: cover;
        border-radius: 14px;
        margin-top: 25px;
        border: 1px solid var(--connector-border);
    }

    /* =========================================================
       Article Footer
    ========================================================= */

    .article-footer {
        margin-top: 35px;
        padding-top: 23px;
        border-top: 1px solid #edf1ef;
    }

    .author-box {
        background: var(--connector-light);
        border-radius: 13px;
        padding: 15px;
    }

    .author-avatar {
        width: 43px;
        height: 43px;
        border-radius: 50%;
        background: var(--connector-primary);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
    }

    .author-name {
        color: var(--connector-text);
        font-size: 13px;
        font-weight: 700;
    }

    .author-role {
        color: var(--connector-muted);
        font-size: 11px;
        margin-top: 2px;
    }

    /* =========================================================
       Sidebar
    ========================================================= */

    .side-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 17px;
        overflow: hidden;
        box-shadow: 0 6px 22px rgba(37, 64, 53, .045);
        margin-bottom: 20px;
    }

    .side-card-header {
        padding: 17px 20px;
        border-bottom: 1px solid #edf1ef;
    }

    .side-card-header h6 {
        margin: 0;
        color: var(--connector-text);
        font-weight: 700;
        font-size: 14px;
    }

    .side-card-body {
        padding: 20px;
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding-bottom: 15px;
        margin-bottom: 15px;
        border-bottom: 1px solid #edf1ef;
    }

    .info-row:last-child {
        padding-bottom: 0;
        margin-bottom: 0;
        border-bottom: 0;
    }

    .info-icon {
        width: 35px;
        height: 35px;
        border-radius: 9px;
        background: var(--connector-light);
        color: var(--connector-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .info-label {
        color: var(--connector-muted);
        font-size: 11px;
        margin-bottom: 2px;
    }

    .info-value {
        color: var(--connector-text);
        font-size: 13px;
        font-weight: 600;
    }

    .sub-category {
        color: var(--connector-muted);
        font-weight: 400;
    }

    /* =========================================================
       Buttons
    ========================================================= */

    .btn-connector {
        background: var(--connector-primary);
        color: #fff;
        border: 0;
        border-radius: 10px;
        min-height: 44px;
        padding: 0 18px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        transition: .2s ease;
    }

    .btn-connector:hover {
        background: #1c3229;
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-outline-connector {
        background: #fff;
        color: var(--connector-primary);
        border: 1px solid #cedad4;
        border-radius: 10px;
        min-height: 44px;
        padding: 0 17px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        transition: .2s ease;
    }

    .btn-outline-connector:hover {
        background: var(--connector-light);
        color: var(--connector-primary);
        border-color: var(--connector-secondary);
    }

    /* =========================================================
       Status
    ========================================================= */

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 30px;
        padding: 6px 11px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-approved,
    .status-published,
    .status-active,
    .status-1 {
        background: #eaf7ef;
        color: #207344;
    }

    .status-pending,
    .status-0 {
        background: #fff6df;
        color: #9a7012;
    }

    .status-rejected,
    .status-inactive {
        background: #fdeeee;
        color: #a53d3d;
    }

    /* =========================================================
       Back Link
    ========================================================= */

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: var(--connector-muted);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 17px;
    }

    .back-link:hover {
        color: var(--connector-primary);
    }

    /* =========================================================
       Responsive
    ========================================================= */

    @media (max-width: 991.98px) {

        .article-cover {
            height: 330px;
        }

        .article-title {
            font-size: 29px;
        }

        .article-body {
            padding: 25px;
        }

    }

    @media (max-width: 575.98px) {

        .blog-detail-page {
            padding: 18px 0 40px;
        }

        .blog-page-header {
            padding: 20px;
            border-radius: 14px;
        }

        .blog-page-header h1 {
            font-size: 20px;
        }

        .article-cover {
            height: 240px;
        }

        .article-body {
            padding: 20px;
        }

        .article-title {
            font-size: 25px;
        }

        .article-meta {
            gap: 7px;
        }

        .entry-content {
            font-size: 15px;
        }

    }
</style>
@endpush


@section('content')

<div class="blog-detail-page">

    <div class="container-fluid px-3 px-lg-4">

        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <div class="blog-page-header">

            <div class="header-content">

                <div class="d-flex align-items-center gap-3">

                    <div class="header-icon">
                        <i class="bi bi-journal-text"></i>
                    </div>

                    <div>

                        <h1>Blog Detail</h1>

                        <p>
                            View and manage your published article.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             BACK
        ====================================================== --}}

        <a
            href="{{ url()->previous() }}"
            class="back-link"
        >
            <i class="bi bi-arrow-left"></i>
            Back to Blogs
        </a>


        <div class="row g-4">

            {{-- =================================================
                 MAIN ARTICLE
            ================================================== --}}

            <div class="col-xl-8 col-lg-8">

                <article class="article-card">

                    {{-- Cover Image --}}
                    @if (!empty($blog->image))

                        <img
                            src="{{ asset('image/blog/' . $blog->image) }}"
                            alt="{{ $blog->title }}"
                            class="article-cover"
                        >

                    @else

                        <div
                            class="article-cover d-flex align-items-center justify-content-center"
                            style="background: #eef4f1;"
                        >
                            <i
                                class="bi bi-image"
                                style="font-size: 50px; color: #6B9080;"
                            ></i>
                        </div>

                    @endif


                    <div class="article-body">

                        {{-- Category --}}
                        @if ($blog->category)

                            <div class="category-badge">

                                <i class="bi bi-folder2-open"></i>

                                {{ $blog->category->name }}

                                @if ($blog->subcategory)
                                    <span>/</span>
                                    {{ $blog->subcategory->name }}
                                @endif

                            </div>

                        @endif


                        {{-- Meta --}}
                        <div class="article-meta">

                            <span class="meta-item">
                                <i class="bi bi-calendar3"></i>

                                {{ optional($blog->created_at)->format('F j, Y') }}
                            </span>


                            <span class="meta-separator">
                                |
                            </span>


                            <span class="meta-item">
                                <i class="bi bi-clock"></i>

                                {{ optional($blog->created_at)->diffForHumans() }}
                            </span>


                            @if (isset($blog->views))

                                <span class="meta-separator">
                                    |
                                </span>

                                <span class="meta-item">

                                    <i class="bi bi-eye"></i>

                                    {{ number_format($blog->views) }}
                                    {{ $blog->views == 1 ? 'view' : 'views' }}

                                </span>

                            @endif

                        </div>


                        {{-- Title --}}
                        <h2 class="article-title">
                            {{ $blog->title }}
                        </h2>


                        {{-- Intro --}}
                        <div class="article-intro">

                            {{ Str::limit(
                                trim(strip_tags($blog->content)),
                                220
                            ) }}

                        </div>


                        {{-- Content --}}
                        <div class="entry-content">

                            {!! $blog->content !!}


                            {{-- Thumbnail --}}
                            @if (
                                !empty($blog->thumbnail) &&
                                $blog->thumbnail !== $blog->image
                            )

                                <img
                                    src="{{ asset('image/blog/' . $blog->thumbnail) }}"
                                    alt="{{ $blog->title }}"
                                    class="article-thumbnail"
                                >

                            @endif

                        </div>


                        {{-- =================================================
                             ARTICLE FOOTER
                        ================================================== --}}

                        <div class="article-footer">

                            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">

                                {{-- Author --}}
                                <div class="author-box">

                                    <div class="d-flex align-items-center gap-3">

                                        @php

                                            $authorName =
                                                $blog->user->name
                                                ?? 'Service Provider';

                                            $initials = collect(
                                                preg_split(
                                                    '/\s+/',
                                                    trim($authorName)
                                                )
                                            )
                                            ->filter()
                                            ->take(2)
                                            ->map(function ($name) {
                                                return strtoupper(
                                                    substr($name, 0, 1)
                                                );
                                            })
                                            ->implode('');

                                        @endphp


                                        <div class="author-avatar">
                                            {{ $initials ?: 'SP' }}
                                        </div>


                                        <div>

                                            <div class="author-name">
                                                {{ $authorName }}
                                            </div>

                                            <div class="author-role">
                                                Blog Author
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- Edit --}}
                                <a
                                    href="{{ route('serviceProviderBlog.editBlog', $blog->id) }}"
                                    class="btn btn-connector"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                    Edit Blog
                                </a>

                            </div>

                        </div>

                    </div>

                </article>

            </div>


            {{-- =================================================
                 SIDEBAR
            ================================================== --}}

            <div class="col-xl-4 col-lg-4">


                {{-- Blog Information --}}
                <div class="side-card">

                    <div class="side-card-header">

                        <h6>
                            <i class="bi bi-info-circle me-2"></i>
                            Blog Information
                        </h6>

                    </div>


                    <div class="side-card-body">


                        {{-- Category --}}
                        <div class="info-row">

                            <div class="info-icon">
                                <i class="bi bi-folder"></i>
                            </div>

                            <div>

                                <div class="info-label">
                                    Category
                                </div>

                                <div class="info-value">

                                    {{ $blog->category->name ?? 'Not assigned' }}

                                    @if ($blog->subcategory)

                                        <span class="sub-category">
                                            / {{ $blog->subcategory->name }}
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- Published Date --}}
                        <div class="info-row">

                            <div class="info-icon">
                                <i class="bi bi-calendar-event"></i>
                            </div>

                            <div>

                                <div class="info-label">
                                    Created
                                </div>

                                <div class="info-value">

                                    {{ optional($blog->created_at)->format('M d, Y') }}

                                </div>

                            </div>

                        </div>


                        {{-- Updated --}}
                        @if ($blog->updated_at)

                            <div class="info-row">

                                <div class="info-icon">
                                    <i class="bi bi-arrow-repeat"></i>
                                </div>

                                <div>

                                    <div class="info-label">
                                        Last Updated
                                    </div>

                                    <div class="info-value">

                                        {{ $blog->updated_at->format('M d, Y') }}

                                    </div>

                                </div>

                            </div>

                        @endif


                        {{-- Views --}}
                        @if (isset($blog->views))

                            <div class="info-row">

                                <div class="info-icon">
                                    <i class="bi bi-eye"></i>
                                </div>

                                <div>

                                    <div class="info-label">
                                        Views
                                    </div>

                                    <div class="info-value">

                                        {{ number_format($blog->views) }}

                                    </div>

                                </div>

                            </div>

                        @endif


                        {{-- Status --}}
                        @if (isset($blog->status))

                            @php
                                $status = strtolower((string) $blog->status);

                                $statusClass = match ($status) {
                                    'approved',
                                    'published',
                                    'active',
                                    '1' => 'status-approved',

                                    'pending',
                                    '0' => 'status-pending',

                                    'rejected',
                                    'inactive' => 'status-rejected',

                                    default => 'status-pending',
                                };

                                $statusLabel = match ($status) {
                                    'approved' => 'Approved',
                                    'published' => 'Published',
                                    'active' => 'Active',
                                    'pending' => 'Pending',
                                    'rejected' => 'Rejected',
                                    'inactive' => 'Inactive',
                                    '1' => 'Active',
                                    '0' => 'Pending',
                                    default => ucfirst($status),
                                };
                            @endphp

                            <div class="info-row">

                                <div class="info-icon">
                                    <i class="bi bi-check2-circle"></i>
                                </div>

                                <div>

                                    <div class="info-label">
                                        Status
                                    </div>

                                    <div class="info-value">

                                        <span class="status-badge {{ $statusClass }}">

                                            <i class="bi bi-circle-fill"
                                               style="font-size: 6px;"></i>

                                            {{ $statusLabel }}

                                        </span>

                                    </div>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- Actions --}}
                <div class="side-card">

                    <div class="side-card-header">

                        <h6>
                            <i class="bi bi-gear me-2"></i>
                            Blog Actions
                        </h6>

                    </div>


                    <div class="side-card-body">

                        <div class="d-grid gap-2">

                            <a
                                href="{{ route('serviceProviderBlog.editBlog', $blog->id) }}"
                                class="btn btn-connector"
                            >
                                <i class="bi bi-pencil-square"></i>
                                Edit Blog
                            </a>


                            <a
                                href="{{ url()->previous() }}"
                                class="btn btn-outline-connector"
                            >
                                <i class="bi bi-arrow-left"></i>
                                Back to Blogs
                            </a>

                        </div>

                    </div>

                </div>


                {{-- Category Card --}}
                <div class="side-card">

                    <div class="side-card-body">

                        <div class="d-flex align-items-start gap-3">

                            <div class="info-icon">
                                <i class="bi bi-lightbulb"></i>
                            </div>

                            <div>

                                <div
                                    style="
                                        font-size: 13px;
                                        font-weight: 700;
                                        color: #254035;
                                        margin-bottom: 5px;
                                    "
                                >
                                    Keep your content useful
                                </div>

                                <div
                                    style="
                                        font-size: 12px;
                                        line-height: 1.6;
                                        color: #718078;
                                    "
                                >
                                    Well-structured articles with clear
                                    headings and relevant information are
                                    easier for readers to follow.
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection