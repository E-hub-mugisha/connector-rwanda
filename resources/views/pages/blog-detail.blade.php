@extends('layouts.base')

@section('title', $blog->title . ' ')

@section('content')

@php
$blogUrl = request()->fullUrl();

$category = $blog->category;
$subcategory = $blog->subcategory;

$commentCount = $blog->comments->count();

$publishedDate = $blog->created_at
? $blog->created_at->format('F d, Y')
: '';

$readingTime = max(
1,
(int) ceil(
str_word_count(strip_tags($blog->content)) / 200
)
);
@endphp


{{-- =========================================================
     BLOG HERO
========================================================= --}}
<section class="blog-detail-hero">
    <div class="container">
        <div class="blog-detail-hero-inner">

            <div class="blog-breadcrumb">
                <a href="{{ route('home.blogs') }}">
                    <i class="bi bi-journal-text"></i>
                    Blog
                </a>

                <i class="bi bi-chevron-right"></i>

                <span>Article</span>
            </div>

            <div class="hero-content">

                @if($category)
                <a
                    href="{{ route('home.blogs', ['category' => $category->id]) }}"
                    class="hero-category">
                    <i class="bi bi-folder2-open"></i>
                    {{ $category->name }}
                </a>
                @endif

                <h1>
                    {{ $blog->title }}
                </h1>

                <div class="hero-meta">

                    @if($publishedDate)
                    <span>
                        <i class="bi bi-calendar3"></i>
                        {{ $publishedDate }}
                    </span>
                    @endif

                    <span>
                        <i class="bi bi-clock"></i>
                        {{ $readingTime }} min read
                    </span>

                    <span>
                        <i class="bi bi-eye"></i>
                        {{ number_format($blog->views ?? 0) }} views
                    </span>

                    <span>
                        <i class="bi bi-chat-left-text"></i>
                        {{ $commentCount }}
                        {{ $commentCount === 1 ? 'comment' : 'comments' }}
                    </span>

                </div>

            </div>

        </div>
    </div>
</section>


{{-- =========================================================
     ARTICLE
========================================================= --}}
<section class="blog-detail-section">

    <div class="container">

        <div class="row g-4 g-xl-5">

            {{-- =================================================
                 MAIN CONTENT
            ================================================== --}}
            <div class="col-lg-8">

                <article class="blog-article">

                    {{-- Featured Image --}}
                    @if($blog->image)
                    <div class="article-featured-image">

                        <img
                            src="{{ asset('image/blog/' . $blog->image) }}"
                            alt="{{ $blog->title }}"
                            loading="eager">

                    </div>
                    @endif


                    {{-- Article Header --}}
                    <div class="article-header">

                        <div class="article-meta">

                            @if($category)
                            <a
                                href="{{ route('home.blogs', ['category' => $category->id]) }}"
                                class="article-category">
                                <i class="bi bi-folder2-open"></i>
                                {{ $category->name }}
                            </a>
                            @endif

                            @if($subcategory)
                            <span class="article-subcategory">
                                <i class="bi bi-folder2"></i>
                                {{ $subcategory->name }}
                            </span>
                            @endif

                        </div>

                        <h2>
                            {{ $blog->title }}
                        </h2>

                        <div class="article-byline">

                            <div class="author-avatar">
                                <i class="bi bi-person"></i>
                            </div>

                            <div>
                                <span class="byline-label">
                                    Published by
                                </span>

                                <strong>
                                    {{ $blog->user->name ?? 'Connector Team' }}
                                </strong>
                            </div>

                            <span class="byline-divider"></span>

                            @if($publishedDate)
                            <span>
                                {{ $publishedDate }}
                            </span>
                            @endif

                        </div>

                    </div>


                    {{-- Article Content --}}
                    <div class="article-content">
                        {!! $blog->content !!}
                    </div>


                    {{-- Tags / Share --}}
                    <div class="article-footer">

                        <div class="article-tags">

                            <span class="footer-label">
                                <i class="bi bi-tag"></i>
                                Category
                            </span>

                            @if($category)
                            <a
                                href="{{ route('home.blogs', ['category' => $category->id]) }}">
                                {{ $category->name }}
                            </a>
                            @else
                            <span class="tag-muted">
                                General
                            </span>
                            @endif

                            @if($subcategory)
                            <a
                                href="{{ route('home.blogs', ['subcategory' => $subcategory->id]) }}">
                                {{ $subcategory->name }}
                            </a>
                            @endif

                        </div>


                        <div class="article-share">

                            <span class="footer-label">
                                Share
                            </span>

                            <a
                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($blogUrl) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Share on Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>

                            <a
                                href="https://twitter.com/intent/tweet?url={{ urlencode($blogUrl) }}&text={{ urlencode($blog->title) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Share on X">
                                <i class="bi bi-twitter-x"></i>
                            </a>

                            <a
                                href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($blogUrl) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Share on LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>

                            <a
                                href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' ' . $blogUrl) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Share on WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>

                            <a
                                href="mailto:?subject={{ urlencode($blog->title) }}&body={{ urlencode($blogUrl) }}"
                                aria-label="Share by email">
                                <i class="bi bi-envelope"></i>
                            </a>

                        </div>

                    </div>

                </article>


                {{-- =================================================
                     COMMENTS
                ================================================== --}}
                <section class="comments-section">

                    <div class="section-heading">

                        <div>
                            <span class="section-eyebrow">
                                Community
                            </span>

                            <h3>
                                Comments
                                <span>{{ $commentCount }}</span>
                            </h3>
                        </div>

                    </div>


                    @forelse($blog->comments as $comment)

                    <div class="comment-card">

                        <div class="comment-avatar">
                            <i class="bi bi-person"></i>
                        </div>

                        <div class="comment-body">

                            <div class="comment-top">

                                <div>
                                    <h4>
                                        {{ $comment->user->name ?? 'Guest User' }}
                                    </h4>

                                    <span>
                                        {{ $comment->created_at?->format('F d, Y \a\t H:i') }}
                                    </span>
                                </div>

                            </div>

                            <p>
                                {{ $comment->comment_body }}
                            </p>

                        </div>

                    </div>

                    @empty

                    <div class="empty-comments">

                        <div class="empty-icon">
                            <i class="bi bi-chat-left-text"></i>
                        </div>

                        <h4>
                            No comments yet
                        </h4>

                        <p>
                            Be the first to share your thoughts about this article.
                        </p>

                    </div>

                    @endforelse

                </section>


                {{-- =================================================
                     COMMENT FORM
                ================================================== --}}
                <section class="comment-form-section">

                    <div class="section-heading">

                        <div>
                            <span class="section-eyebrow">
                                Join the conversation
                            </span>

                            <h3>
                                Leave a comment
                            </h3>

                            <p>
                                Share your thoughts, questions or perspective.
                            </p>
                        </div>

                    </div>


                    @if(session('success'))
                    <div class="alert alert-success border-0 mb-4">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                    @endif


                    @if($errors->any())
                    <div class="alert alert-danger border-0 mb-4">

                        <div class="fw-semibold mb-2">
                            Please check the following:
                        </div>

                        <ul class="mb-0 ps-3">

                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>
                    @endif


                    <form
                        action="{{ url('/sendComment') }}"
                        method="POST"
                        class="comment-form">

                        @csrf

                        <input
                            type="hidden"
                            name="blog_id"
                            value="{{ $blog->id }}">

                        <div class="form-group">

                            <label for="comment_body">
                                Your comment
                            </label>

                            <textarea
                                id="comment_body"
                                name="comment_body"
                                rows="6"
                                placeholder="Write your comment here..."
                                required>{{ old('comment_body') }}</textarea>

                        </div>

                        <button
                            type="submit"
                            class="comment-submit">
                            <span>Post comment</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>

                    </form>

                </section>

            </div>


            {{-- =================================================
                 SIDEBAR
            ================================================== --}}
            <div class="col-lg-4">

                <aside class="blog-detail-sidebar">


                    {{-- Back to blog --}}
                    <a
                        href="{{ route('home.blogs') }}"
                        class="back-to-blog">
                        <i class="bi bi-arrow-left"></i>
                        Back to all articles
                    </a>


                    {{-- Article Information --}}
                    <div class="sidebar-card">

                        <div class="sidebar-card-heading">

                            <span class="sidebar-icon">
                                <i class="bi bi-info-circle"></i>
                            </span>

                            <div>
                                <span>Article</span>
                                <h4>Information</h4>
                            </div>

                        </div>


                        <div class="article-info-list">

                            @if($category)

                            <div class="info-row">

                                <span class="info-label">
                                    Category
                                </span>

                                <a
                                    href="{{ route('home.blogs', ['category' => $category->id]) }}"
                                    class="info-value">
                                    {{ $category->name }}
                                </a>

                            </div>

                            @endif


                            @if($subcategory)

                            <div class="info-row">

                                <span class="info-label">
                                    Subcategory
                                </span>

                                <a
                                    href="{{ route('home.blogs', ['subcategory' => $subcategory->id]) }}"
                                    class="info-value">
                                    {{ $subcategory->name }}
                                </a>

                            </div>

                            @endif


                            <div class="info-row">

                                <span class="info-label">
                                    Published
                                </span>

                                <span class="info-value plain">
                                    {{ $publishedDate }}
                                </span>

                            </div>


                            <div class="info-row">

                                <span class="info-label">
                                    Reading time
                                </span>

                                <span class="info-value plain">
                                    {{ $readingTime }} minutes
                                </span>

                            </div>


                            <div class="info-row">

                                <span class="info-label">
                                    Views
                                </span>

                                <span class="info-value plain">
                                    {{ number_format($blog->views ?? 0) }}
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- Recent Articles --}}
                    <div class="sidebar-card">

                        <div class="sidebar-card-heading">

                            <span class="sidebar-icon">
                                <i class="bi bi-journal-text"></i>
                            </span>

                            <div>
                                <span>Explore</span>
                                <h4>Recent articles</h4>
                            </div>

                        </div>


                        <div class="recent-articles">

                            @forelse($r_blog as $recent)

                            <a
                                href="{{ route('home.blog_detail', ['blog_slug' => $recent->slug]) }}"
                                class="recent-article">

                                <div class="recent-image">

                                    @if($recent->image)

                                    <img
                                        src="{{ asset('image/blog/' . $recent->image) }}"
                                        alt="{{ $recent->title }}"
                                        loading="lazy">

                                    @else

                                    <div class="recent-image-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>

                                    @endif

                                </div>


                                <div class="recent-content">

                                    @if($recent->category)

                                    <span class="recent-category">
                                        {{ $recent->category->name }}
                                    </span>

                                    @endif

                                    <h5>
                                        {{ \Illuminate\Support\Str::limit($recent->title, 65) }}
                                    </h5>

                                    <span class="recent-date">
                                        {{ $recent->created_at?->format('M d, Y') }}
                                    </span>

                                </div>

                            </a>

                            @empty

                            <p class="sidebar-empty">
                                No recent articles available.
                            </p>

                            @endforelse

                        </div>


                        <a
                            href="{{ route('home.blogs') }}"
                            class="view-all-articles">
                            View all articles
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>


                    {{-- Share Card --}}
                    <div class="sidebar-share-card">

                        <div class="share-card-icon">
                            <i class="bi bi-share"></i>
                        </div>

                        <h4>
                            Found this useful?
                        </h4>

                        <p>
                            Share this article with your network and help others discover it.
                        </p>

                        <div class="share-card-links">

                            <a
                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($blogUrl) }}"
                                target="_blank"
                                rel="noopener noreferrer">
                                <i class="bi bi-facebook"></i>
                            </a>

                            <a
                                href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($blogUrl) }}"
                                target="_blank"
                                rel="noopener noreferrer">
                                <i class="bi bi-linkedin"></i>
                            </a>

                            <a
                                href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' ' . $blogUrl) }}"
                                target="_blank"
                                rel="noopener noreferrer">
                                <i class="bi bi-whatsapp"></i>
                            </a>

                            <a
                                href="mailto:?subject={{ urlencode($blog->title) }}&body={{ urlencode($blogUrl) }}">
                                <i class="bi bi-envelope"></i>
                            </a>

                        </div>

                    </div>

                </aside>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     CONNECTOR CTA
========================================================= --}}
<section class="blog-detail-cta">

    <div class="container">

        <div class="cta-wrapper">

            <div class="cta-content">

                <span class="cta-eyebrow">
                    CONNECT WITH THE RIGHT PEOPLE
                </span>

                <h2>
                    Looking for a service?
                </h2>

                <p>
                    Discover trusted service providers and find the right
                    expertise for what you need.
                </p>

            </div>

            <div class="cta-actions">

                <a
                    href="{{ route('home.services') }}"
                    class="cta-primary">
                    Explore services
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a
                    href="{{ route('register') }}"
                    class="cta-secondary">
                    Join Connector
                </a>

            </div>

        </div>

    </div>

</section>


<style>
    :root {
        --connector-primary: #254035;
        --connector-accent: #6B9080;
        --connector-accent-soft: #edf3f0;
        --connector-text: #18231e;
        --connector-muted: #6f7b75;
        --connector-border: #e4ebe7;
        --connector-soft: #f8faf9;
        --connector-white: #ffffff;
    }


    /* =========================================================
   HERO
========================================================= */

    .blog-detail-hero {
        background: var(--connector-primary);
        padding: 75px 0 85px;
        position: relative;
        overflow: hidden;
    }

    .blog-detail-hero::before {
        content: "";
        position: absolute;
        width: 420px;
        height: 420px;
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 50%;
        right: -160px;
        top: -220px;
    }

    .blog-detail-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border: 1px solid rgba(255, 255, 255, .06);
        border-radius: 50%;
        left: -130px;
        bottom: -160px;
    }

    .blog-detail-hero-inner {
        position: relative;
        z-index: 2;
    }

    .blog-breadcrumb {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: rgba(255, 255, 255, .6);
        font-size: 13px;
        margin-bottom: 30px;
    }

    .blog-breadcrumb a {
        color: rgba(255, 255, 255, .9);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .blog-breadcrumb a:hover {
        color: #fff;
    }

    .hero-content {
        max-width: 850px;
        margin: 0 auto;
        text-align: center;
    }

    .hero-category {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(255, 255, 255, .10);
        border: 1px solid rgba(255, 255, 255, .12);
        color: #fff;
        padding: 8px 13px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        margin-bottom: 20px;
    }

    .hero-category:hover {
        background: rgba(255, 255, 255, .16);
        color: #fff;
    }

    .hero-content h1 {
        color: #fff;
        font-size: clamp(34px, 4.5vw, 58px);
        line-height: 1.1;
        letter-spacing: -1.5px;
        font-weight: 700;
        margin: 0 auto 28px;
    }

    .hero-meta {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 9px 20px;
        color: rgba(255, 255, 255, .65);
        font-size: 13px;
    }

    .hero-meta span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .hero-meta i {
        color: #fff;
    }


    /* =========================================================
   MAIN SECTION
========================================================= */

    .blog-detail-section {
        padding: 75px 0 100px;
        background: #fff;
    }

    .blog-article {
        background: #fff;
    }


    /* =========================================================
   FEATURED IMAGE
========================================================= */

    .article-featured-image {
        width: 100%;
        height: 460px;
        overflow: hidden;
        border-radius: 18px;
        margin-bottom: 38px;
        background: var(--connector-soft);
    }

    .article-featured-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }


    /* =========================================================
   ARTICLE HEADER
========================================================= */

    .article-header {
        padding-bottom: 30px;
        border-bottom: 1px solid var(--connector-border);
    }

    .article-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px;
        margin-bottom: 18px;
    }

    .article-category,
    .article-subcategory {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .article-category {
        background: var(--connector-accent-soft);
        color: var(--connector-primary);
        text-decoration: none;
    }

    .article-category:hover {
        background: var(--connector-accent);
        color: #fff;
    }

    .article-subcategory {
        background: #f5f7f6;
        color: var(--connector-muted);
    }

    .article-header h2 {
        color: var(--connector-text);
        font-size: clamp(28px, 3vw, 42px);
        line-height: 1.2;
        letter-spacing: -.7px;
        font-weight: 700;
        margin: 0 0 24px;
    }

    .article-byline {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        color: var(--connector-muted);
        font-size: 13px;
    }

    .author-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--connector-accent-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .article-byline>div:nth-child(2) {
        display: flex;
        flex-direction: column;
        gap: 1px;
    }

    .byline-label {
        font-size: 11px;
        color: var(--connector-muted);
    }

    .article-byline strong {
        color: var(--connector-text);
        font-size: 13px;
    }

    .byline-divider {
        width: 1px;
        height: 20px;
        background: var(--connector-border);
    }


    /* =========================================================
   ARTICLE CONTENT
========================================================= */

    .article-content {
        padding: 38px 0 35px;
        color: #3f4c46;
        font-size: 16px;
        line-height: 1.85;
    }

    .article-content p {
        margin-bottom: 22px;
    }

    .article-content h1,
    .article-content h2,
    .article-content h3,
    .article-content h4,
    .article-content h5,
    .article-content h6 {
        color: var(--connector-text);
        font-weight: 700;
        line-height: 1.3;
        margin-top: 35px;
        margin-bottom: 15px;
    }

    .article-content h2 {
        font-size: 29px;
    }

    .article-content h3 {
        font-size: 24px;
    }

    .article-content h4 {
        font-size: 20px;
    }

    .article-content ul,
    .article-content ol {
        padding-left: 25px;
        margin-bottom: 25px;
    }

    .article-content li {
        margin-bottom: 9px;
    }

    .article-content a {
        color: var(--connector-primary);
        font-weight: 600;
    }

    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 20px 0;
    }

    .article-content blockquote {
        margin: 30px 0;
        padding: 20px 25px;
        border-left: 4px solid var(--connector-accent);
        background: var(--connector-soft);
        color: var(--connector-primary);
        font-size: 18px;
        font-style: italic;
        border-radius: 0 10px 10px 0;
    }

    .article-content table {
        width: 100%;
        margin: 25px 0;
        border-collapse: collapse;
    }

    .article-content th,
    .article-content td {
        border: 1px solid var(--connector-border);
        padding: 12px;
        text-align: left;
    }


    /* =========================================================
   ARTICLE FOOTER
========================================================= */

    .article-footer {
        border-top: 1px solid var(--connector-border);
        border-bottom: 1px solid var(--connector-border);
        padding: 20px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .article-tags,
    .article-share {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .footer-label {
        color: var(--connector-muted);
        font-size: 12px;
        font-weight: 600;
        margin-right: 4px;
    }

    .article-tags a,
    .tag-muted {
        display: inline-flex;
        align-items: center;
        padding: 7px 11px;
        border-radius: 6px;
        background: var(--connector-soft);
        border: 1px solid var(--connector-border);
        color: var(--connector-primary);
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    .article-tags a:hover {
        background: var(--connector-accent-soft);
    }

    .tag-muted {
        color: var(--connector-muted);
    }

    .article-share a {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--connector-border);
        border-radius: 7px;
        color: var(--connector-primary);
        text-decoration: none;
        transition: .2s ease;
    }

    .article-share a:hover {
        background: var(--connector-primary);
        color: #fff;
        border-color: var(--connector-primary);
    }


    /* =========================================================
   COMMENTS
========================================================= */

    .comments-section {
        margin-top: 65px;
    }

    .section-heading {
        margin-bottom: 28px;
    }

    .section-eyebrow {
        display: block;
        text-transform: uppercase;
        letter-spacing: 1.3px;
        color: var(--connector-accent);
        font-size: 10px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .section-heading h3 {
        color: var(--connector-text);
        font-size: 27px;
        font-weight: 700;
        margin: 0;
    }

    .section-heading h3 span {
        color: var(--connector-muted);
        font-size: 15px;
        font-weight: 500;
        margin-left: 5px;
    }

    .comment-card {
        display: flex;
        gap: 17px;
        padding: 23px 0;
        border-top: 1px solid var(--connector-border);
    }

    .comment-avatar {
        width: 43px;
        min-width: 43px;
        height: 43px;
        border-radius: 50%;
        background: var(--connector-accent-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .comment-body {
        flex: 1;
    }

    .comment-top h4 {
        margin: 0 0 3px;
        color: var(--connector-text);
        font-size: 14px;
        font-weight: 700;
    }

    .comment-top span {
        color: var(--connector-muted);
        font-size: 11px;
    }

    .comment-body p {
        margin: 12px 0 0;
        color: #526059;
        font-size: 14px;
        line-height: 1.7;
    }

    .empty-comments {
        padding: 40px 25px;
        text-align: center;
        border: 1px solid var(--connector-border);
        border-radius: 12px;
        background: var(--connector-soft);
    }

    .empty-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 14px;
        border-radius: 50%;
        background: #fff;
        color: var(--connector-accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .empty-comments h4 {
        color: var(--connector-text);
        font-size: 16px;
        margin-bottom: 7px;
    }

    .empty-comments p {
        margin: 0;
        color: var(--connector-muted);
        font-size: 13px;
    }


    /* =========================================================
   COMMENT FORM
========================================================= */

    .comment-form-section {
        margin-top: 60px;
        padding: 35px;
        background: var(--connector-soft);
        border: 1px solid var(--connector-border);
        border-radius: 15px;
    }

    .section-heading p {
        color: var(--connector-muted);
        font-size: 13px;
        margin: 7px 0 0;
    }

    .comment-form .form-group {
        margin-bottom: 20px;
    }

    .comment-form label {
        display: block;
        color: var(--connector-text);
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 9px;
    }

    .comment-form textarea {
        width: 100%;
        resize: vertical;
        min-height: 150px;
        border: 1px solid var(--connector-border);
        background: #fff;
        border-radius: 9px;
        padding: 14px 15px;
        outline: none;
        color: var(--connector-text);
        font-size: 14px;
        transition: .2s ease;
    }

    .comment-form textarea:focus {
        border-color: var(--connector-accent);
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .10);
    }

    .comment-submit {
        border: 0;
        border-radius: 8px;
        background: var(--connector-primary);
        color: #fff;
        padding: 12px 18px;
        display: inline-flex;
        align-items: center;
        gap: 15px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s ease;
    }

    .comment-submit:hover {
        background: #1c3027;
        transform: translateY(-1px);
    }

    .comment-submit i {
        font-size: 15px;
    }


    /* =========================================================
   SIDEBAR
========================================================= */

    .blog-detail-sidebar {
        position: sticky;
        top: 25px;
    }

    .back-to-blog {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--connector-primary);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .back-to-blog:hover {
        color: var(--connector-accent);
    }

    .sidebar-card {
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        background: #fff;
        padding: 23px;
        margin-bottom: 20px;
    }

    .sidebar-card-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 18px;
        margin-bottom: 3px;
        border-bottom: 1px solid var(--connector-border);
    }

    .sidebar-icon {
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: var(--connector-accent-soft);
        color: var(--connector-primary);
    }

    .sidebar-card-heading span:not(.sidebar-icon) {
        display: block;
        color: var(--connector-muted);
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
    }

    .sidebar-card-heading h4 {
        color: var(--connector-text);
        font-size: 17px;
        font-weight: 700;
        margin: 2px 0 0;
    }


    /* =========================================================
   ARTICLE INFO
========================================================= */

    .info-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        padding: 14px 0;
        border-bottom: 1px solid var(--connector-border);
    }

    .info-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .info-label {
        color: var(--connector-muted);
        font-size: 12px;
    }

    .info-value {
        color: var(--connector-primary);
        font-size: 12px;
        font-weight: 600;
        text-align: right;
        text-decoration: none;
    }

    .info-value:hover {
        color: var(--connector-accent);
    }

    .info-value.plain {
        color: var(--connector-text);
    }


    /* =========================================================
   RECENT ARTICLES
========================================================= */

    .recent-articles {
        margin-top: 4px;
    }

    .recent-article {
        display: flex;
        gap: 12px;
        padding: 16px 0;
        border-bottom: 1px solid var(--connector-border);
        text-decoration: none;
    }

    .recent-article:last-child {
        border-bottom: 0;
    }

    .recent-image {
        width: 75px;
        min-width: 75px;
        height: 68px;
        border-radius: 8px;
        overflow: hidden;
        background: var(--connector-soft);
    }

    .recent-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .recent-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--connector-muted);
    }

    .recent-content {
        min-width: 0;
    }

    .recent-category {
        display: block;
        color: var(--connector-accent);
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: .7px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .recent-content h5 {
        color: var(--connector-text);
        font-size: 13px;
        line-height: 1.4;
        font-weight: 650;
        margin: 0 0 5px;
        transition: .2s ease;
    }

    .recent-article:hover h5 {
        color: var(--connector-accent);
    }

    .recent-date {
        color: var(--connector-muted);
        font-size: 10px;
    }

    .sidebar-empty {
        color: var(--connector-muted);
        font-size: 13px;
        margin: 20px 0 0;
    }

    .view-all-articles {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: var(--connector-primary);
        border-top: 1px solid var(--connector-border);
        padding-top: 17px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
    }

    .view-all-articles:hover {
        color: var(--connector-accent);
    }


    /* =========================================================
   SHARE CARD
========================================================= */

    .sidebar-share-card {
        background: var(--connector-primary);
        color: #fff;
        border-radius: 14px;
        padding: 27px;
    }

    .share-card-icon {
        width: 42px;
        height: 42px;
        border-radius: 9px;
        background: rgba(255, 255, 255, .10);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
    }

    .sidebar-share-card h4 {
        color: #fff;
        font-size: 19px;
        margin-bottom: 8px;
    }

    .sidebar-share-card p {
        color: rgba(255, 255, 255, .65);
        font-size: 12px;
        line-height: 1.7;
        margin-bottom: 20px;
    }

    .share-card-links {
        display: flex;
        gap: 8px;
    }

    .share-card-links a {
        width: 34px;
        height: 34px;
        border-radius: 7px;
        background: rgba(255, 255, 255, .09);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: .2s ease;
    }

    .share-card-links a:hover {
        background: #fff;
        color: var(--connector-primary);
    }


    /* =========================================================
   CTA
========================================================= */

    .blog-detail-cta {
        padding: 0 0 90px;
    }

    .cta-wrapper {
        background: var(--connector-accent-soft);
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        padding: 42px 45px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 35px;
    }

    .cta-eyebrow {
        display: block;
        color: var(--connector-accent);
        font-size: 10px;
        letter-spacing: 1.3px;
        font-weight: 700;
        margin-bottom: 9px;
    }

    .cta-content h2 {
        color: var(--connector-primary);
        font-size: 29px;
        margin: 0 0 8px;
    }

    .cta-content p {
        color: var(--connector-muted);
        font-size: 13px;
        max-width: 570px;
        margin: 0;
        line-height: 1.7;
    }

    .cta-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .cta-primary,
    .cta-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px 17px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .cta-primary {
        background: var(--connector-primary);
        color: #fff;
    }

    .cta-primary:hover {
        background: #1c3027;
        color: #fff;
    }

    .cta-secondary {
        background: #fff;
        border: 1px solid var(--connector-border);
        color: var(--connector-primary);
    }

    .cta-secondary:hover {
        border-color: var(--connector-primary);
        color: var(--connector-primary);
    }


    /* =========================================================
   RESPONSIVE
========================================================= */

    @media (max-width: 991.98px) {

        .blog-detail-hero {
            padding: 55px 0 65px;
        }

        .blog-detail-section {
            padding: 55px 0 75px;
        }

        .article-featured-image {
            height: 390px;
        }

        .blog-detail-sidebar {
            position: static;
            margin-top: 20px;
        }

        .cta-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }

        .cta-actions {
            width: 100%;
        }

    }

    @media (max-width: 767.98px) {

        .blog-detail-hero {
            padding: 45px 0 55px;
        }

        .hero-content h1 {
            font-size: 34px;
            letter-spacing: -.8px;
        }

        .hero-meta {
            gap: 8px 13px;
        }

        .article-featured-image {
            height: 270px;
            border-radius: 12px;
            margin-bottom: 28px;
        }

        .article-content {
            font-size: 15px;
            line-height: 1.8;
            padding-top: 28px;
        }

        .article-footer {
            align-items: flex-start;
            flex-direction: column;
        }

        .comment-form-section {
            padding: 25px 20px;
        }

        .cta-wrapper {
            padding: 30px 25px;
        }

        .cta-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .cta-primary,
        .cta-secondary {
            width: 100%;
        }

    }

    @media (max-width: 480px) {

        .hero-content h1 {
            font-size: 29px;
        }

        .article-header h2 {
            font-size: 27px;
        }

        .article-byline {
            align-items: flex-start;
        }

        .byline-divider {
            display: none;
        }

        .recent-image {
            width: 65px;
            min-width: 65px;
            height: 60px;
        }

    }
</style>

@endsection