@extends('layouts.app')

@section('title', 'Blog Details')

@section('content')

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-dark: #254035;
        --connector-soft: #eef5f2;
        --connector-border: #e4ebe8;
        --connector-text: #26352e;
        --connector-muted: #7b8983;
        --connector-success: #3f9560;
        --connector-warning: #c58b2a;
        --connector-danger: #c94c4c;
    }

    .blog-show-page {
        padding: 10px 0 45px;
        color: var(--connector-text);
    }

    /* Header */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .page-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .page-icon svg {
        width: 23px;
        height: 23px;
    }

    .page-title {
        margin: 0;
        color: var(--connector-dark);
        font-size: 24px;
        font-weight: 700;
        letter-spacing: -.3px;
    }

    .page-subtitle {
        margin: 4px 0 0;
        color: var(--connector-muted);
        font-size: 13px;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .btn-outline-modern,
    .btn-primary-modern,
    .btn-danger-modern {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 40px;
        padding: 9px 14px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 650;
        text-decoration: none !important;
        transition: .2s ease;
        cursor: pointer;
    }

    .btn-outline-modern {
        background: #fff;
        border: 1px solid var(--connector-border);
        color: var(--connector-dark);
    }

    .btn-outline-modern:hover {
        border-color: var(--connector-primary);
        color: var(--connector-primary);
        background: var(--connector-soft);
    }

    .btn-primary-modern {
        background: var(--connector-dark);
        border: 1px solid var(--connector-dark);
        color: #fff;
    }

    .btn-primary-modern:hover {
        background: var(--connector-primary);
        border-color: var(--connector-primary);
        color: #fff;
    }

    .btn-danger-modern {
        background: #fff;
        border: 1px solid #efcccc;
        color: var(--connector-danger);
    }

    .btn-danger-modern:hover {
        background: #fff2f2;
        border-color: var(--connector-danger);
    }

    .btn-outline-modern svg,
    .btn-primary-modern svg,
    .btn-danger-modern svg {
        width: 15px;
        height: 15px;
    }

    /* Main layout */
    .blog-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 22px;
        align-items: start;
    }

    .main-column,
    .side-column {
        min-width: 0;
    }

    .side-column {
        position: sticky;
        top: 20px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    /* Cards */
    .card-modern {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(37, 64, 53, .045);
        overflow: hidden;
    }

    .card-padding {
        padding: 23px;
    }

    /* Article */
    .article-card {
        overflow: hidden;
    }

    .article-image {
        width: 100%;
        height: 360px;
        object-fit: cover;
        display: block;
        background: #f3f6f4;
    }

    .article-image-placeholder {
        width: 100%;
        height: 360px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .article-image-placeholder svg {
        width: 55px;
        height: 55px;
    }

    .article-body {
        padding: 30px;
    }

    .article-meta-top {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 15px;
    }

    .badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 9px;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .35px;
    }

    .badge-category {
        background: var(--connector-soft);
        color: var(--connector-primary);
    }

    .badge-approved {
        background: #edf8f1;
        color: var(--connector-success);
    }

    .badge-pending {
        background: #fff7e8;
        color: var(--connector-warning);
    }

    .badge-declined {
        background: #fff0f0;
        color: var(--connector-danger);
    }

    .badge-featured {
        background: #f3f0ff;
        color: #6d58a5;
    }

    .article-title {
        margin: 0 0 15px;
        color: var(--connector-dark);
        font-size: 31px;
        line-height: 1.25;
        font-weight: 750;
        letter-spacing: -.6px;
    }

    .article-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 15px;
        color: var(--connector-muted);
        font-size: 12px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--connector-border);
    }

    .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .meta-item svg {
        width: 14px;
        height: 14px;
        color: var(--connector-primary);
    }

    /* Content */
    .article-content {
        padding-top: 25px;
        color: #3c4a44;
        font-size: 15px;
        line-height: 1.85;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .article-content h1,
    .article-content h2,
    .article-content h3,
    .article-content h4 {
        color: var(--connector-dark);
        line-height: 1.35;
        margin-top: 28px;
        margin-bottom: 12px;
    }

    .article-content p {
        margin-bottom: 17px;
    }

    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .article-content a {
        color: var(--connector-primary);
    }

    .article-content blockquote {
        margin: 22px 0;
        padding: 15px 18px;
        border-left: 4px solid var(--connector-primary);
        background: var(--connector-soft);
        color: #4b5c54;
        border-radius: 0 8px 8px 0;
    }

    .article-content ul,
    .article-content ol {
        margin-bottom: 18px;
        padding-left: 25px;
    }

    /* Sidebar */
    .side-card {
        padding: 20px;
    }

    .side-title {
        display: flex;
        align-items: center;
        gap: 9px;
        color: var(--connector-dark);
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 17px;
    }

    .side-title svg {
        width: 17px;
        height: 17px;
        color: var(--connector-primary);
    }

    /* Stats */
    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .stat-box {
        padding: 13px;
        border: 1px solid var(--connector-border);
        background: #fafcfb;
        border-radius: 10px;
    }

    .stat-label {
        color: var(--connector-muted);
        font-size: 10px;
        margin-bottom: 5px;
    }

    .stat-value {
        color: var(--connector-dark);
        font-size: 18px;
        font-weight: 750;
    }

    /* Details */
    .detail-list {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 11px 0;
        border-bottom: 1px solid #edf1ef;
    }

    .detail-item:first-child {
        padding-top: 0;
    }

    .detail-item:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .detail-label {
        color: var(--connector-muted);
        font-size: 11px;
    }

    .detail-value {
        color: var(--connector-dark);
        font-size: 11px;
        font-weight: 650;
        text-align: right;
        word-break: break-word;
    }

    /* Thumbnail */
    .thumbnail-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--connector-border);
        display: block;
    }

    .thumbnail-placeholder {
        height: 150px;
        border-radius: 10px;
        background: var(--connector-soft);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--connector-primary);
    }

    .thumbnail-placeholder svg {
        width: 35px;
        height: 35px;
    }

    /* Actions */
    .action-list {
        display: grid;
        gap: 9px;
    }

    .action-button {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
        min-height: 42px;
        padding: 10px 12px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none !important;
        cursor: pointer;
        transition: .2s ease;
    }

    .action-button svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    .action-edit {
        background: var(--connector-soft);
        border: 1px solid #dce9e4;
        color: var(--connector-dark);
    }

    .action-edit:hover {
        background: #e3efea;
        color: var(--connector-dark);
    }

    .action-approve {
        background: #edf8f1;
        border: 1px solid #d7ecde;
        color: var(--connector-success);
    }

    .action-approve:hover {
        background: #e1f4e8;
    }

    .action-delete {
        background: #fff2f2;
        border: 1px solid #f0d4d4;
        color: var(--connector-danger);
    }

    .action-delete:hover {
        background: #ffe7e7;
    }

    /* Author */
    .author-box {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .author-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 750;
        flex-shrink: 0;
    }

    .author-name {
        color: var(--connector-dark);
        font-size: 12px;
        font-weight: 700;
    }

    .author-role {
        color: var(--connector-muted);
        font-size: 10px;
        margin-top: 2px;
    }

    /* Flash */
    .alert-modern {
        border: 0;
        border-radius: 11px;
        padding: 13px 15px;
        margin-bottom: 20px;
        font-size: 13px;
    }

    .alert-success-modern {
        background: #edf8f1;
        color: #28734d;
    }

    /* Empty */
    .not-found {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 16px;
        padding: 60px 20px;
        text-align: center;
    }

    .not-found-icon {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }

    .not-found-icon svg {
        width: 25px;
        height: 25px;
    }

    .not-found h3 {
        color: var(--connector-dark);
        font-size: 18px;
        margin-bottom: 6px;
    }

    .not-found p {
        color: var(--connector-muted);
        font-size: 13px;
        margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .blog-layout {
            grid-template-columns: 1fr;
        }

        .side-column {
            position: static;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .side-card:last-child {
            grid-column: span 2;
        }
    }

    @media (max-width: 767px) {
        .page-header {
            align-items: flex-start;
        }

        .page-title {
            font-size: 20px;
        }

        .header-actions {
            flex-shrink: 0;
        }

        .header-actions .btn-primary-modern span {
            display: none;
        }

        .article-image,
        .article-image-placeholder {
            height: 230px;
        }

        .article-body {
            padding: 20px;
        }

        .article-title {
            font-size: 24px;
        }

        .side-column {
            display: flex;
        }

        .side-card:last-child {
            grid-column: auto;
        }
    }
</style>


<div class="container-fluid blog-show-page">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}
    <div class="page-header">

        <div class="page-header-left">

            <div class="page-icon">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M4 4h16v16H4z"/>
                    <path d="M8 8h8"/>
                    <path d="M8 12h8"/>
                    <path d="M8 16h5"/>
                </svg>
            </div>

            <div>
                <h1 class="page-title">Blog Details</h1>
                <p class="page-subtitle">
                    Review and manage this article.
                </p>
            </div>

        </div>

        <div class="header-actions">

            <a href="{{ route('admin.blogs') }}"
               class="btn-outline-modern">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M19 12H5"/>
                    <path d="m12 19-7-7 7-7"/>
                </svg>

                <span>Back</span>
            </a>

            @if(isset($blog) && $blog)
                <a href="{{ route('admin.edit_blog', $blog->id) }}"
                   class="btn-primary-modern">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M12 20h9"/>
                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                    </svg>

                    <span>Edit article</span>
                </a>
            @endif

        </div>

    </div>


    {{-- =========================================================
         FLASH MESSAGE
    ========================================================== --}}
    @if(Session::has('message'))
        <div class="alert-modern alert-success-modern">
            {{ Session::get('message') }}
        </div>
    @endif


    @if(!$blog)

        <div class="not-found">

            <div class="not-found-icon">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <circle cx="11" cy="11" r="7"/>
                    <path d="m20 20-4-4"/>
                </svg>
            </div>

            <h3>Article not found</h3>

            <p>
                The blog article you're looking for could not be found.
            </p>

            <a href="{{ route('admin.blogs') }}"
               class="btn-primary-modern">
                Return to blogs
            </a>

        </div>

    @else

        {{-- =====================================================
             BLOG LAYOUT
        ====================================================== --}}
        <div class="blog-layout">

            {{-- =================================================
                 MAIN ARTICLE
            ================================================== --}}
            <div class="main-column">

                <article class="card-modern article-card">

                    {{-- Main image --}}
                    @if(!empty($blog->image))
                        <img
                            src="{{ asset('image/blog/' . $blog->image) }}"
                            alt="{{ $blog->title }}"
                            class="article-image"
                        >
                    @else
                        <div class="article-image-placeholder">
                            <svg viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.5"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="m21 15-5-5L5 21"/>
                            </svg>
                        </div>
                    @endif


                    <div class="article-body">

                        {{-- Badges --}}
                        <div class="article-meta-top">

                            @if(isset($blog->category) && $blog->category)
                                <span class="badge-modern badge-category">
                                    {{ $blog->category->name }}
                                </span>
                            @elseif(!empty($blog->blog_category))
                                <span class="badge-modern badge-category">
                                    {{ $blog->blog_category }}
                                </span>
                            @endif

                            @php
                                $status = strtolower($blog->status ?? 'pending');
                            @endphp

                            @if($status === 'approved')
                                <span class="badge-modern badge-approved">
                                    Approved
                                </span>
                            @elseif($status === 'declined')
                                <span class="badge-modern badge-declined">
                                    Declined
                                </span>
                            @else
                                <span class="badge-modern badge-pending">
                                    Pending
                                </span>
                            @endif

                            @if(!empty($blog->featured))
                                <span class="badge-modern badge-featured">
                                    Featured
                                </span>
                            @endif

                        </div>


                        {{-- Title --}}
                        <h2 class="article-title">
                            {{ $blog->title }}
                        </h2>


                        {{-- Meta --}}
                        <div class="article-meta">

                            <div class="meta-item">
                                <svg viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <circle cx="12" cy="7" r="4"/>
                                    <path d="M5 21a7 7 0 0 1 14 0"/>
                                </svg>

                                <span>
                                    @if(isset($blog->user) && $blog->user)
                                        {{ $blog->user->name }}
                                    @else
                                        Admin
                                    @endif
                                </span>
                            </div>


                            <div class="meta-item">
                                <svg viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="17" rx="2"/>
                                    <path d="M16 2v4"/>
                                    <path d="M8 2v4"/>
                                    <path d="M3 10h18"/>
                                </svg>

                                <span>
                                    {{ optional($blog->created_at)->format('M d, Y') }}
                                </span>
                            </div>


                            <div class="meta-item">
                                <svg viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>

                                <span>
                                    {{ number_format((int)($blog->views ?? 0)) }} views
                                </span>
                            </div>


                            <div class="meta-item">
                                <svg viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="M21 11.5a8 8 0 0 1-8.5 8 8.5 8.5 0 0 1-4.2-1.1L3 20l1.7-4.8A8 8 0 1 1 21 11.5Z"/>
                                </svg>

                                <span>
                                    {{ $blog->comments_count ?? ($blog->comments ? $blog->comments->count() : 0) }}
                                    comments
                                </span>
                            </div>

                        </div>


                        {{-- Article content --}}
                        <div class="article-content">
                            {!! $blog->content !!}
                        </div>

                    </div>

                </article>

            </div>


            {{-- =================================================
                 SIDEBAR
            ================================================== --}}
            <div class="side-column">


                {{-- =============================================
                     QUICK STATS
                ============================================== --}}
                <div class="card-modern side-card">

                    <div class="side-title">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <path d="M4 19V5"/>
                            <path d="M4 19h17"/>
                            <path d="m7 15 4-4 3 2 5-6"/>
                        </svg>

                        Article performance
                    </div>

                    <div class="stats-grid">

                        <div class="stat-box">
                            <div class="stat-label">Views</div>
                            <div class="stat-value">
                                {{ number_format((int)($blog->views ?? 0)) }}
                            </div>
                        </div>

                        <div class="stat-box">
                            <div class="stat-label">Comments</div>
                            <div class="stat-value">
                                {{ $blog->comments_count ?? ($blog->comments ? $blog->comments->count() : 0) }}
                            </div>
                        </div>

                    </div>

                </div>


                {{-- =============================================
                     ARTICLE DETAILS
                ============================================== --}}
                <div class="card-modern side-card">

                    <div class="side-title">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 11v5"/>
                            <path d="M12 8h.01"/>
                        </svg>

                        Article details
                    </div>

                    <ul class="detail-list">

                        <li class="detail-item">
                            <span class="detail-label">Article ID</span>
                            <span class="detail-value">
                                #{{ $blog->id }}
                            </span>
                        </li>

                        <li class="detail-item">
                            <span class="detail-label">Status</span>
                            <span class="detail-value">
                                {{ ucfirst($blog->status ?? 'pending') }}
                            </span>
                        </li>

                        <li class="detail-item">
                            <span class="detail-label">Featured</span>
                            <span class="detail-value">
                                {{ !empty($blog->featured) ? 'Yes' : 'No' }}
                            </span>
                        </li>

                        <li class="detail-item">
                            <span class="detail-label">Category</span>
                            <span class="detail-value">
                                @if(isset($blog->category) && $blog->category)
                                    {{ $blog->category->name }}
                                @elseif(!empty($blog->blog_category))
                                    {{ $blog->blog_category }}
                                @else
                                    —
                                @endif
                            </span>
                        </li>

                        <li class="detail-item">
                            <span class="detail-label">Sub category</span>
                            <span class="detail-value">
                                @if(isset($blog->subcategory) && $blog->subcategory)
                                    {{ $blog->subcategory->name }}
                                @elseif(!empty($blog->sub_category))
                                    {{ $blog->sub_category }}
                                @else
                                    —
                                @endif
                            </span>
                        </li>

                        <li class="detail-item">
                            <span class="detail-label">Created</span>
                            <span class="detail-value">
                                {{ optional($blog->created_at)->format('M d, Y H:i') }}
                            </span>
                        </li>

                        <li class="detail-item">
                            <span class="detail-label">Updated</span>
                            <span class="detail-value">
                                {{ optional($blog->updated_at)->format('M d, Y H:i') }}
                            </span>
                        </li>

                        <li class="detail-item">
                            <span class="detail-label">Slug</span>
                            <span class="detail-value">
                                {{ $blog->slug }}
                            </span>
                        </li>

                    </ul>

                </div>


                {{-- =============================================
                     AUTHOR
                ============================================== --}}
                <div class="card-modern side-card">

                    <div class="side-title">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 21a8 8 0 0 1 16 0"/>
                        </svg>

                        Author
                    </div>

                    <div class="author-box">

                        <div class="author-avatar">
                            @php
                                $authorName = isset($blog->user) && $blog->user
                                    ? $blog->user->name
                                    : 'Admin';

                                $authorInitials = collect(
                                    preg_split('/\s+/', trim($authorName))
                                )
                                ->filter()
                                ->take(2)
                                ->map(function ($name) {
                                    return strtoupper(substr($name, 0, 1));
                                })
                                ->implode('');
                            @endphp

                            {{ $authorInitials ?: 'A' }}
                        </div>

                        <div>
                            <div class="author-name">
                                {{ $authorName }}
                            </div>

                            <div class="author-role">
                                Article author
                            </div>
                        </div>

                    </div>

                </div>


                {{-- =============================================
                     THUMBNAIL
                ============================================== --}}
                <div class="card-modern side-card">

                    <div class="side-title">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                            <circle cx="8.5" cy="9" r="1.5"/>
                            <path d="m21 15-5-5L5 19"/>
                        </svg>

                        Thumbnail
                    </div>

                    @if(!empty($blog->thumbnail))

                        <img
                            src="{{ asset('thumbnail/blog/' . $blog->thumbnail) }}"
                            alt="{{ $blog->title }} thumbnail"
                            class="thumbnail-image"
                        >

                    @else

                        <div class="thumbnail-placeholder">
                            <svg viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.5"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="m21 15-5-5L5 21"/>
                            </svg>
                        </div>

                    @endif

                </div>


                {{-- =============================================
                     ACTIONS
                ============================================== --}}
                <div class="card-modern side-card">

                    <div class="side-title">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1-1.7 1.7-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5v.2h-2.4v-.2a1.7 1.7 0 0 0-1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1-1.7-1.7.1-.1A1.7 1.7 0 0 0 8.4 15a1.7 1.7 0 0 0-1.5-1H6.7v-2.4h.2a1.7 1.7 0 0 0 1.5-1 1.7 1.7 0 0 0-.3-1.9L8 8.6l1.7-1.7.1.1a1.7 1.7 0 0 0 1.9.3 1.7 1.7 0 0 0 1-1.5v-.2h2.4v.2a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1 1.7 1.7-.1.1a1.7 1.7 0 0 0-.3 1.9 1.7 1.7 0 0 0 1.5 1h.2V14h-.2a1.7 1.7 0 0 0-1.5 1Z"/>
                        </svg>

                        Manage article
                    </div>

                    <div class="action-list">

                        {{-- Edit --}}
                        <a href="{{ route('admin.edit_blog', $blog->id) }}"
                           class="action-button action-edit">

                            <svg viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                            </svg>

                            Edit article
                        </a>


                        {{-- Approve --}}
                        @if(($blog->status ?? '') !== 'approved')

                            <form action="{{ route('admin.blogApprove', $blog->id) }}"
                                  method="POST"
                                  class="approve-form">

                                @csrf

                                {{-- Use this if your route expects PATCH/PUT --}}
                                {{-- @method('PATCH') --}}

                                <button type="submit"
                                        class="action-button action-approve">

                                    <svg viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8"
                                         stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <path d="m5 12 4 4L19 6"/>
                                    </svg>

                                    Approve article
                                </button>

                            </form>

                        @endif


                        {{-- Delete --}}
                        <form action="{{ route('admin.blog_delete', $blog->id) }}"
                              method="POST"
                              class="delete-form">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="action-button action-delete">

                                <svg viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="M3 6h18"/>
                                    <path d="M8 6V4h8v2"/>
                                    <path d="M19 6l-1 15H6L5 6"/>
                                    <path d="M10 11v6"/>
                                    <path d="M14 11v6"/>
                                </svg>

                                Delete article
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    @endif

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ================================================
           DELETE CONFIRMATION
        ================================================= */

        document.querySelectorAll('.delete-form').forEach(function (form) {

            form.addEventListener('submit', function (event) {

                const confirmed = window.confirm(
                    'Are you sure you want to permanently delete this article?'
                );

                if (!confirmed) {
                    event.preventDefault();
                }

            });

        });


        /* ================================================
           APPROVE CONFIRMATION
        ================================================= */

        document.querySelectorAll('.approve-form').forEach(function (form) {

            form.addEventListener('submit', function (event) {

                const confirmed = window.confirm(
                    'Approve this article and make it available as approved content?'
                );

                if (!confirmed) {
                    event.preventDefault();
                }

            });

        });

    });
</script>

@endsection