@extends('layouts.base')
@section('title', $service->name)
@section('content')

<style>
    :root {
        --clr-white: #ffffff;
        --clr-sage: #6B9080;
        --clr-forest: #254035;
        --clr-sage-lt: #EBF2EF;
        --clr-sage-md: #C2D9D1;
        --clr-forest-lt: #3A6354;
        --clr-text: #1A2E26;
        --clr-muted: #5C7268;
        --clr-border: #D8E8E2;
        --clr-bg-soft: #F6FAF8;
        --clr-whatsapp: #25D366;
        --clr-whatsapp-dark: #1DA851;
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-lg: 22px;
        --shadow-card: 0 2px 16px rgba(37, 64, 53, .07);
        --shadow-hover: 0 8px 32px rgba(37, 64, 53, .13);
        --font-display: 'Playfair Display', Georgia, serif;
        --font-body: 'DM Sans', sans-serif;
        --transition: .22s cubic-bezier(.4, 0, .2, 1);
    }

    .svc-page * {
        box-sizing: border-box;
    }

    .svc-page {
        font-family: var(--font-body);
        color: var(--clr-text);
        background: var(--clr-white);
    }

    .svc-page a {
        text-decoration: none;
        color: inherit;
    }

    .svc-page img {
        display: block;
        max-width: 100%;
    }

    .container-lg {
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* ─── BANNER ─── */
    .svc-banner {
        position: relative;
        background:
            radial-gradient(circle at 12% 15%, rgba(107, 144, 128, .35) 0%, transparent 55%),
            radial-gradient(circle at 90% 85%, rgba(107, 144, 128, .2) 0%, transparent 50%),
            linear-gradient(135deg, var(--clr-forest) 0%, #1B2E26 100%);
        padding: 56px 0 92px;
        overflow: hidden;
    }

    .svc-banner .crumbs {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: rgba(255, 255, 255, .6);
        margin-bottom: 22px;
    }

    .svc-banner .crumbs a {
        color: rgba(255, 255, 255, .8);
        font-weight: 500;
        transition: color var(--transition);
    }

    .svc-banner .crumbs a:hover {
        color: #fff;
    }

    .svc-header-card {
        display: flex;
        align-items: center;
        gap: 22px;
        flex-wrap: wrap;
    }

    .svc-header-card .avatar {
        width: 92px;
        height: 92px;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 3px solid rgba(255, 255, 255, .18);
        flex-shrink: 0;
    }

    .svc-header-card .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .svc-header-card h1 {
        font-family: var(--font-display);
        font-size: clamp(24px, 3.2vw, 34px);
        font-weight: 700;
        color: #fff;
        line-height: 1.2;
    }

    .svc-header-card .cat-pill {
        display: inline-block;
        margin-top: 8px;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: var(--clr-forest);
        background: var(--clr-sage-md);
        padding: 5px 13px;
        border-radius: 100px;
    }

    /* ─── OVERLAP SUMMARY BAR ─── */
    .svc-summary-bar {
        position: relative;
        margin-top: -52px;
        background: var(--clr-white);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-hover);
        padding: 24px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        z-index: 3;
    }

    .svc-summary-bar .metrics {
        display: flex;
        flex-wrap: wrap;
        gap: 34px;
    }

    .svc-summary-bar .metric span {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--clr-muted);
        margin-bottom: 4px;
    }

    .svc-summary-bar .metric div {
        font-size: 15px;
        font-weight: 700;
        color: var(--clr-forest);
    }

    .svc-summary-bar .metric .price-orig {
        font-size: 12px;
        font-weight: 500;
        color: var(--clr-muted);
        text-decoration: line-through;
        margin-right: 6px;
    }

    .svc-summary-bar .metric .discount-pill {
        display: inline-block;
        font-size: 10.5px;
        font-weight: 700;
        color: #fff;
        background: #D85A30;
        padding: 2px 9px;
        border-radius: 100px;
        margin-left: 8px;
        vertical-align: middle;
    }

    .svc-summary-bar .actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .fav-circle-btn {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        border: 1.5px solid var(--clr-border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--clr-muted);
        transition: color var(--transition), border-color var(--transition);
        flex-shrink: 0;
    }

    .fav-circle-btn:hover {
        color: #D85A30;
        border-color: #D85A30;
    }

    .btn-whatsapp-lg {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        background: var(--clr-whatsapp);
        color: #fff;
        font-size: 14.5px;
        font-weight: 700;
        padding: 14px 26px;
        border-radius: 100px;
        transition: background var(--transition), box-shadow var(--transition);
        white-space: nowrap;
    }

    .btn-whatsapp-lg:hover {
        background: var(--clr-whatsapp-dark);
        color: #fff;
        box-shadow: 0 6px 20px rgba(37, 211, 102, .32);
    }

    /* ─── BODY LAYOUT ─── */
    .svc-body {
        padding: 56px 0 90px;
    }

    .svc-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
    }

    @media(min-width:992px) {
        .svc-grid {
            grid-template-columns: 300px 1fr;
            align-items: start;
        }
    }

    /* ─── SIDEBAR ─── */
    .svc-sidebar {
        position: sticky;
        top: 90px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .sb-card {
        background: var(--clr-white);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        padding: 22px;
    }

    .sb-card .thumb {
        border-radius: var(--radius-md);
        overflow: hidden;
        margin-bottom: 16px;
    }

    .sb-card .thumb img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .sb-card h3 {
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 700;
        color: var(--clr-forest);
        margin-bottom: 4px;
    }

    .sb-card .sub {
        font-size: 13px;
        color: var(--clr-sage);
        font-weight: 600;
        margin-bottom: 16px;
    }

    .sb-meta-row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: var(--clr-muted);
        margin-bottom: 12px;
    }

    .sb-meta-row svg {
        color: var(--clr-sage);
        flex-shrink: 0;
    }

    .sb-socials {
        display: flex;
        gap: 8px;
        margin: 16px 0 4px;
    }

    .sb-socials a {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--clr-sage-lt);
        color: var(--clr-forest);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background var(--transition), color var(--transition);
    }

    .sb-socials a:hover {
        background: var(--clr-forest);
        color: #fff;
    }

    .sb-card .btn-whatsapp-full {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background: var(--clr-whatsapp);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        padding: 13px;
        border-radius: var(--radius-sm);
        margin-top: 18px;
        transition: background var(--transition), box-shadow var(--transition);
    }

    .sb-card .btn-whatsapp-full:hover {
        background: var(--clr-whatsapp-dark);
        color: #fff;
        box-shadow: 0 4px 16px rgba(37, 211, 102, .32);
    }

    .sb-card .eyebrow {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--clr-sage);
        margin-bottom: 8px;
        display: block;
    }

    .gmap_canvas iframe {
        width: 100%;
        height: 230px;
        border: 0;
        border-radius: var(--radius-md);
        display: block;
    }

    .rate-stars {
        display: flex;
        gap: 6px;
        color: #F4A027;
        font-size: 22px;
        cursor: pointer;
    }

    /* ─── CONTENT CARDS ─── */
    .content-card {
        background: var(--clr-white);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-lg);
        padding: 30px 32px;
        margin-bottom: 28px;
    }

    .content-card .section-tag {
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--clr-sage);
        background: var(--clr-sage-lt);
        padding: 5px 13px;
        border-radius: 100px;
        margin-bottom: 12px;
    }

    .content-card h3 {
        font-family: var(--font-display);
        font-size: 22px;
        font-weight: 700;
        color: var(--clr-forest);
        margin-bottom: 16px;
    }

    .content-card p {
        font-size: 15px;
        color: var(--clr-muted);
        line-height: 1.8;
    }

    /* ─── MEDIA GALLERY ─── */
    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 18px;
    }

    .media-item {
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-md);
        overflow: hidden;
        background: var(--clr-bg-soft);
        transition: box-shadow var(--transition), transform var(--transition);
    }

    .media-item:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-3px);
    }

    .media-item img,
    .media-item video {
        width: 100%;
        height: 150px;
        object-fit: cover;
        display: block;
    }

    .media-item .m-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 14px;
    }

    .media-item .m-foot span {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--clr-forest);
    }

    .media-item .m-foot a {
        font-size: 12px;
        font-weight: 700;
        color: var(--clr-sage);
    }

    .media-item .m-foot a:hover {
        color: var(--clr-forest);
    }

    /* ─── INCLUSION / EXCLUSION ─── */
    .io-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }

    @media(min-width:768px) {
        .io-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    .io-block {
        border-radius: var(--radius-md);
        padding: 22px 24px;
    }

    .io-block.inclusion {
        background: var(--clr-sage-lt);
        border: 1px solid var(--clr-sage-md);
    }

    .io-block.exclusion {
        background: #FBEDE8;
        border: 1px solid #F0CFC1;
    }

    .io-block h4 {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 14px;
    }

    .io-block.inclusion h4 {
        color: var(--clr-forest);
    }

    .io-block.exclusion h4 {
        color: #B4441F;
    }

    .io-block ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .io-block li {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        font-size: 13.5px;
        color: var(--clr-text);
        line-height: 1.6;
        margin-bottom: 10px;
    }

    .io-block li:last-child {
        margin-bottom: 0;
    }

    .io-block li svg {
        flex-shrink: 0;
        margin-top: 2px;
    }

    .io-block.inclusion li svg {
        color: var(--clr-sage);
    }

    .io-block.exclusion li svg {
        color: #C24E2A;
    }

    /* ─── RELATED ─── */
    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 22px;
    }

    .service-card {
        background: var(--clr-white);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: box-shadow var(--transition), transform var(--transition);
        display: flex;
        flex-direction: column;
    }

    .service-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-5px);
    }

    .service-card .thumb {
        position: relative;
        overflow: hidden;
    }

    .service-card .thumb img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        transition: transform .5s ease;
    }

    .service-card:hover .thumb img {
        transform: scale(1.05);
    }

    .service-card .duration-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(37, 64, 53, .82);
        backdrop-filter: blur(4px);
        color: #fff;
        font-size: 11.5px;
        font-weight: 600;
        padding: 4px 11px;
        border-radius: 100px;
    }

    .service-card .body {
        padding: 16px 18px 18px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .service-card .cat-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: var(--clr-sage);
        margin-bottom: 5px;
    }

    .service-card .svc-name {
        font-family: var(--font-display);
        font-size: 15.5px;
        font-weight: 700;
        color: var(--clr-forest);
        margin-bottom: 12px;
        line-height: 1.3;
        display: block;
    }

    .service-card .price-row {
        font-size: 18px;
        font-weight: 700;
        color: var(--clr-forest);
        margin-bottom: 4px;
    }

    .service-card .price-row .price-cur {
        font-size: 12px;
        font-weight: 500;
        color: var(--clr-muted);
    }

    .service-card .location-row {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12.5px;
        color: var(--clr-muted);
        margin-top: 6px;
        margin-bottom: 16px;
    }

    .service-card .location-row a {
        color: var(--clr-sage);
        font-weight: 500;
    }

    .service-card .card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 7px;
        margin-top: auto;
    }

    .btn-view-detail {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        background: var(--clr-sage-lt);
        color: var(--clr-forest);
        font-size: 12.5px;
        font-weight: 700;
        padding: 11px 6px;
        border-radius: var(--radius-sm);
        text-align: center;
        transition: background var(--transition), color var(--transition);
    }

    .btn-view-detail:hover {
        background: var(--clr-forest);
        color: #fff;
    }

    .btn-whatsapp {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        background: var(--clr-whatsapp);
        color: #fff;
        font-size: 12.5px;
        font-weight: 700;
        padding: 11px 6px;
        border-radius: var(--radius-sm);
        text-align: center;
        transition: background var(--transition), box-shadow var(--transition);
    }

    .btn-whatsapp:hover {
        background: var(--clr-whatsapp-dark);
        color: #fff;
        box-shadow: 0 4px 14px rgba(37, 211, 102, .35);
    }

    .btn-whatsapp svg {
        flex-shrink: 0;
    }

    /* ─── CTA STRIP ─── */
    .svc-cta {
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-lg);
        padding: 36px 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
        background: var(--clr-bg-soft);
    }

    .svc-cta h2 {
        font-family: var(--font-display);
        font-size: clamp(20px, 3vw, 28px);
        color: var(--clr-forest);
        font-weight: 700;
        margin-bottom: 4px;
    }

    .svc-cta p {
        font-size: 15px;
        color: var(--clr-muted);
    }

    .svc-cta .actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-outline-forest {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: var(--clr-forest);
        border: 1.5px solid var(--clr-forest);
        padding: 11px 26px;
        border-radius: 100px;
        transition: background var(--transition), color var(--transition);
    }

    .btn-outline-forest:hover {
        background: var(--clr-forest);
        color: #fff;
    }

    .btn-fill-forest {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        background: var(--clr-forest);
        padding: 11px 28px;
        border-radius: 100px;
        border: none;
        cursor: pointer;
        transition: background var(--transition), box-shadow var(--transition);
    }

    .btn-fill-forest:hover {
        background: var(--clr-forest-lt);
        box-shadow: 0 4px 16px rgba(37, 64, 53, .22);
        color: #fff;
    }

    @media(max-width:576px) {
        .svc-cta {
            flex-direction: column;
            align-items: flex-start;
        }

        .svc-summary-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .svc-summary-bar .actions {
            width: 100%;
        }

        .btn-whatsapp-lg {
            flex: 1;
            justify-content: center;
        }
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

@php
    $total = $service->price;
    if ($service->discount) {
        if ($service->discount_type == 'fixed') {
            $total = $total - $service->discount;
        } elseif ($service->discount_type == 'percent') {
            $total = $total - ($total * $service->discount / 100);
        }
    }

    // WhatsApp booking: uses the provider's phone number when available,
    // otherwise falls back to the platform's default WhatsApp line.
    // Adjust the relation/field names below ($service->sprovider->phone)
    // to match your actual schema.
    $waRawPhone = optional($service->sprovider ?? null)->phone
        ?? config('services.whatsapp.default_number', '250780000000');
    $waPhone = preg_replace('/\D+/', '', $waRawPhone);
    $waMessage = rawurlencode('Hello! I\'m interested in booking "' . $service->name . '" (' . number_format($total) . ' RWF). Is it available?');
@endphp

<div class="svc-page">

    <!-- ── BANNER ─────────────────────────────────── -->
    <div class="svc-banner">
        <div class="container-lg">
            <div class="crumbs">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <a href="{{ route('home.service_by_category', ['category_slug' => $service->category->slug]) }}">{{ $service->category->name }}</a>
                <span>/</span>
                <span style="color:#fff;">{{ $service->name }}</span>
            </div>
            <div class="svc-header-card">
                <div class="avatar">
                    <img src="{{ asset('image/services/' . ($service->image ?? 'default.png')) }}" alt="{{ $service->name }}">
                </div>
                <div>
                    <h1>{{ $service->name }}</h1>
                    <span class="cat-pill">{{ $service->category->name }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ── SUMMARY BAR (overlapping banner) ─────────────────────────────────── -->
    <div class="container-lg">
        <div class="svc-summary-bar">
            <div class="metrics">
                <div class="metric">
                    <span>Location</span>
                    <div>{{ $service->location }}</div>
                </div>
                <div class="metric">
                    <span>Duration</span>
                    <div>{{ $service->duration }}</div>
                </div>
                <div class="metric">
                    <span>Price</span>
                    <div>
                        @if($service->discount)
                        <span class="price-orig">{{ number_format($service->price) }} RWF</span>
                        @endif
                        {{ number_format($total) }} RWF
                        @if($service->discount)
                        <span class="discount-pill">
                            @if($service->discount_type == 'fixed')-{{ $service->discount }} RWF
                            @else-{{ $service->discount }}%
                            @endif
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="actions">
                <a href="#" class="fav-circle-btn" aria-label="Save"><i class="bi bi-heart"></i></a>
                <a href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}" target="_blank" rel="noopener" class="btn-whatsapp-lg">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 004.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2zm5.8 14.1c-.24.68-1.4 1.3-1.93 1.38-.5.08-1.12.11-1.8-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.13-4.9-4.32-.14-.19-1.17-1.55-1.17-2.96 0-1.4.73-2.09 1-2.38.26-.28.57-.35.76-.35h.55c.18 0 .42-.07.65.5.24.58.82 2 .89 2.15.07.15.12.32.02.51-.09.19-.14.31-.28.48-.14.16-.29.36-.42.49-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.28.36-.23.6-.14.24.09 1.55.73 1.82.86.27.14.44.2.51.32.07.12.07.68-.17 1.36z"/></svg>
                    Book via WhatsApp
                </a>
            </div>
        </div>
    </div>

    <!-- ── BODY ─────────────────────────────────── -->
    <section class="svc-body">
        <div class="container-lg">
            <div class="svc-grid">

                <!-- SIDEBAR -->
                <aside class="svc-sidebar">
                    <div class="sb-card">
                        <div class="thumb">
                            <a href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}">
                                <img src="{{ asset('image/services/' . ($service->image ?? 'default.png')) }}" alt="{{ $service->name }}">
                            </a>
                        </div>
                        <h3>{{ $service->name }}</h3>
                        <div class="sub">{{ $service->category->name }}</div>

                        <div class="sb-meta-row">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z" /><circle cx="12" cy="10" r="3" /></svg>
                            {{ $service->location }}
                        </div>
                        <div class="sb-meta-row">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 3" /></svg>
                            {{ $service->duration }}
                        </div>

                        <span class="eyebrow" style="margin-top:10px;">Social</span>
                        <div class="sb-socials">
                            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        </div>

                        <a href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}" target="_blank" rel="noopener" class="btn-whatsapp-full">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 004.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2zm5.8 14.1c-.24.68-1.4 1.3-1.93 1.38-.5.08-1.12.11-1.8-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.13-4.9-4.32-.14-.19-1.17-1.55-1.17-2.96 0-1.4.73-2.09 1-2.38.26-.28.57-.35.76-.35h.55c.18 0 .42-.07.65.5.24.58.82 2 .89 2.15.07.15.12.32.02.51-.09.19-.14.31-.28.48-.14.16-.29.36-.42.49-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.28.36-.23.6-.14.24.09 1.55.73 1.82.86.27.14.44.2.51.32.07.12.07.68-.17 1.36z"/></svg>
                            Book via WhatsApp
                        </a>
                    </div>

                    <div class="sb-card">
                        <span class="eyebrow">Find us</span>
                        <h3 style="font-size:15.5px;margin-bottom:12px;">Location</h3>
                        <div class="gmap_canvas">
                            <iframe class="gmap_iframe" src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q={{ $service->location }}&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" loading="lazy"></iframe>
                        </div>
                    </div>

                    <div class="sb-card">
                        <span class="eyebrow">Your feedback</span>
                        <h3 style="font-size:15.5px;margin-bottom:10px;">Rate {{ $service->name }}</h3>
                        <div class="rate-stars">
                            <span>&#9734;</span><span>&#9734;</span><span>&#9734;</span><span>&#9734;</span><span>&#9734;</span>
                        </div>
                    </div>
                </aside>

                <!-- MAIN CONTENT -->
                <div>
                    <div class="content-card">
                        <span class="section-tag">About this service</span>
                        <h3>Overview</h3>
                        <p>{!! $service->description !!}</p>
                    </div>

                    @if($service->media->isNotEmpty())
                    <div class="content-card">
                        <span class="section-tag">Gallery</span>
                        <h3>Service Media</h3>
                        <div class="media-grid">
                            @foreach($service->media as $media)
                            <div class="media-item">
                                @if($media->type === 'image')
                                <img src="{{ asset('image/services/' . $media->file_path) }}" alt="Service media">
                                @elseif($media->type === 'video')
                                <video controls>
                                    <source src="{{ asset('image/services/' . $media->file_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                @endif
                                <div class="m-foot">
                                    <span>Media</span>
                                    <a href="{{ asset('image/services/' . $media->file_path) }}" target="_blank" rel="noopener">View full &rarr;</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="content-card">
                        <span class="section-tag">Details</span>
                        <h3>What's included</h3>
                        <div class="io-grid">
                            <div class="io-block inclusion">
                                <h4>
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6 9 17l-5-5" /></svg>
                                    Inclusion
                                </h4>
                                <ul>
                                    @foreach(explode('|', $service->inclusion) as $inclusion)
                                    @if(trim($inclusion) !== '')
                                    <li>
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6 9 17l-5-5" /></svg>
                                        {!! $inclusion !!}
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="io-block exclusion">
                                <h4>
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M18 6 6 18M6 6l12 12" /></svg>
                                    Exclusion
                                </h4>
                                <ul>
                                    @foreach(explode('|', $service->exclusion) as $exclusion)
                                    @if(trim($exclusion) !== '')
                                    <li>
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M18 6 6 18M6 6l12 12" /></svg>
                                        {!! $exclusion !!}
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    @if($r_service)
                    @php
                        $rTotal = $r_service->price;
                        if ($r_service->discount) {
                            if ($r_service->discount_type == 'fixed') {
                                $rTotal = $rTotal - $r_service->discount;
                            } elseif ($r_service->discount_type == 'percent') {
                                $rTotal = $rTotal - ($rTotal * $r_service->discount / 100);
                            }
                        }
                        $rWaPhone = preg_replace('/\D+/', '', optional($r_service->sprovider ?? null)->phone ?? config('services.whatsapp.default_number', '250780000000'));
                        $rWaMessage = rawurlencode('Hello! I\'m interested in booking "' . $r_service->name . '" (' . number_format($rTotal) . ' RWF). Is it available?');
                    @endphp
                    <div class="content-card">
                        <span class="section-tag">You might also like</span>
                        <h3>Related Service</h3>
                        <div class="related-grid">
                            <div class="service-card">
                                <div class="thumb">
                                    <a href="{{ route('home.service_details', ['service_slug' => $r_service->slug]) }}">
                                        <img src="{{ asset('image/services/' . ($r_service->image ?? 'default.png')) }}" alt="{{ $r_service->name }}">
                                    </a>
                                    <span class="duration-badge">{{ $r_service->duration }}</span>
                                </div>
                                <div class="body">
                                    <div class="cat-label">{{ $r_service->category->name }}</div>
                                    <a href="{{ route('home.service_details', ['service_slug' => $r_service->slug]) }}" class="svc-name">{{ $r_service->name }}</a>
                                    <div class="price-row">{{ number_format($rTotal) }} <span class="price-cur">RWF</span></div>
                                    <div class="location-row">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z" /><circle cx="12" cy="10" r="3" /></svg>
                                        <a href="{{ route('home.service_location', ['service_location' => $r_service->location]) }}">{{ $r_service->location }}</a>
                                    </div>
                                    <div class="card-actions">
                                        <a href="{{ route('home.service_details', ['service_slug' => $r_service->slug]) }}" class="btn-view-detail">View Detail</a>
                                        <a href="https://wa.me/{{ $rWaPhone }}?text={{ $rWaMessage }}" target="_blank" rel="noopener" class="btn-whatsapp">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 004.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2zm5.8 14.1c-.24.68-1.4 1.3-1.93 1.38-.5.08-1.12.11-1.8-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.13-4.9-4.32-.14-.19-1.17-1.55-1.17-2.96 0-1.4.73-2.09 1-2.38.26-.28.57-.35.76-.35h.55c.18 0 .42-.07.65.5.24.58.82 2 .89 2.15.07.15.12.32.02.51-.09.19-.14.31-.28.48-.14.16-.29.36-.42.49-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.28.36-.23.6-.14.24.09 1.55.73 1.82.86.27.14.44.2.51.32.07.12.07.68-.17 1.36z"/></svg>
                                            WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- ── CTA STRIP ─────────────────────────────────── -->
    <div class="container-lg" style="padding-bottom:80px;">
        <div class="svc-cta">
            <div>
                <h2>Most complete service portal.</h2>
                <p>Sign up and start finding services or talents.</p>
            </div>
            <div class="actions">
                <a href="{{ route('home.services') }}" class="btn-outline-forest">Looking for a Service?</a>
                <a href="{{ route('register') }}" class="btn-fill-forest">Join the Team</a>
            </div>
        </div>
    </div>

</div>

@endsection