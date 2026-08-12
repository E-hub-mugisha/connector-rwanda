@extends('layouts.base')
@section('title', 'service by location')
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

    .loc-page * {
        box-sizing: border-box;
    }

    .loc-page {
        font-family: var(--font-body);
        color: var(--clr-text);
        background: var(--clr-white);
    }

    .loc-page a {
        text-decoration: none;
        color: inherit;
    }

    .loc-page img {
        display: block;
        max-width: 100%;
    }

    .container-lg {
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* ─── BANNER ─── */
    .loc-banner {
        position: relative;
        background:
            radial-gradient(circle at 15% 20%, rgba(107, 144, 128, .35) 0%, transparent 55%),
            radial-gradient(circle at 85% 80%, rgba(107, 144, 128, .22) 0%, transparent 50%),
            linear-gradient(135deg, var(--clr-forest) 0%, #1B2E26 100%);
        padding: 64px 0 56px;
        overflow: hidden;
    }

    .loc-banner .crumbs {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 13px;
        color: rgba(255, 255, 255, .6);
        margin-bottom: 18px;
    }

    .loc-banner .crumbs a {
        color: rgba(255, 255, 255, .8);
        font-weight: 500;
        transition: color var(--transition);
    }

    .loc-banner .crumbs a:hover {
        color: #fff;
    }

    .loc-banner .pin-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .2);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .04em;
        padding: 6px 16px;
        border-radius: 100px;
        margin: 0 auto 16px;
        width: fit-content;
        display: flex;
    }

    .loc-banner h1 {
        font-family: var(--font-display);
        font-size: clamp(30px, 4.4vw, 48px);
        font-weight: 700;
        color: #fff;
        text-align: center;
        line-height: 1.2;
    }

    .loc-banner p {
        text-align: center;
        font-size: 15.5px;
        color: rgba(255, 255, 255, .68);
        max-width: 460px;
        margin: 14px auto 0;
    }

    /* ─── LAYOUT ─── */
    .loc-layout {
        padding: 56px 0 60px;
    }

    .loc-grid-wrap {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
    }

    @media(min-width:992px) {
        .loc-grid-wrap {
            grid-template-columns: 272px 1fr;
            align-items: start;
        }
    }

    /* ─── FILTER SIDEBAR ─── */
    .filter-toggle-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background: var(--clr-forest);
        color: #fff;
        border: none;
        border-radius: var(--radius-sm);
        padding: 13px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        margin-bottom: 16px;
    }

    @media(min-width:992px) {
        .filter-toggle-btn {
            display: none;
        }
    }

    .filter-panel {
        background: var(--clr-white);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        position: sticky;
        top: 90px;
    }

    .filter-panel .fp-head {
        padding: 20px 22px 16px;
        border-bottom: 1px solid var(--clr-border);
    }

    .filter-panel .fp-head .eyebrow {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--clr-sage);
    }

    .filter-panel .fp-head h3 {
        font-family: var(--font-display);
        font-size: 19px;
        color: var(--clr-forest);
        font-weight: 700;
        margin-top: 4px;
    }

    .filter-search {
        margin: 18px 22px 4px;
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--clr-bg-soft);
        border: 1px solid var(--clr-border);
        border-radius: 100px;
        padding: 10px 16px;
    }

    .filter-search svg {
        color: var(--clr-sage);
        flex-shrink: 0;
    }

    .filter-search input {
        border: none;
        outline: none;
        background: transparent;
        font-size: 13.5px;
        width: 100%;
        color: var(--clr-text);
    }

    .filter-cat-list {
        list-style: none;
        padding: 10px 12px 8px;
        margin: 0;
        max-height: 400px;
        overflow-y: auto;
    }

    .filter-cat-list::-webkit-scrollbar {
        width: 5px;
    }

    .filter-cat-list::-webkit-scrollbar-thumb {
        background: var(--clr-sage-md);
        border-radius: 10px;
    }

    .filter-cat-item {
        border-radius: var(--radius-sm);
        margin-bottom: 2px;
    }

    .fc-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: var(--radius-sm);
        transition: background var(--transition);
    }

    .fc-row:hover {
        background: var(--clr-bg-soft);
    }

    .fc-row a.fc-link {
        flex: 1;
        padding: 10px 12px;
        font-size: 13.5px;
        font-weight: 500;
        color: var(--clr-text);
    }

    .fc-toggle {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--clr-muted);
        background: none;
        border: none;
        cursor: pointer;
        margin-right: 6px;
        border-radius: 50%;
        transition: transform var(--transition), background var(--transition);
    }

    .fc-toggle:hover {
        background: var(--clr-sage-lt);
    }

    .fc-toggle svg {
        transition: transform var(--transition);
    }

    .filter-cat-item.open .fc-toggle svg {
        transform: rotate(90deg);
    }

    .fc-sub {
        list-style: none;
        margin: 0;
        padding: 0 10px 8px 30px;
        display: none;
    }

    .filter-cat-item.open .fc-sub {
        display: block;
    }

    .fc-sub li {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .fc-sub li input[type="checkbox"] {
        accent-color: var(--clr-sage);
        width: 14px;
        height: 14px;
        flex-shrink: 0;
        cursor: pointer;
    }

    .fc-sub li label {
        flex: 1;
        cursor: pointer;
    }

    .fc-sub li a {
        display: block;
        padding: 7px 10px 7px 0;
        font-size: 12.5px;
        color: var(--clr-muted);
        border-radius: var(--radius-sm);
        transition: color var(--transition);
    }

    .fc-sub li:hover a {
        color: var(--clr-forest);
    }

    .filter-panel .fp-foot {
        padding: 16px 22px 22px;
        border-top: 1px solid var(--clr-border);
    }

    .btn-apply-filter {
        display: block;
        text-align: center;
        width: 100%;
        background: var(--clr-forest);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        padding: 12px;
        border-radius: 100px;
        border: none;
        cursor: pointer;
        transition: background var(--transition);
    }

    .btn-apply-filter:hover {
        background: var(--clr-forest-lt);
        color: #fff;
    }

    /* ─── RESULTS AREA ─── */
    .results-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 28px;
    }

    .results-top .count {
        font-family: var(--font-display);
        font-size: 22px;
        font-weight: 700;
        color: var(--clr-forest);
    }

    .results-top .count span {
        color: var(--clr-sage);
    }

    .sort-select {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sort-select label {
        font-size: 13.5px;
        color: var(--clr-muted);
        font-weight: 500;
    }

    .sort-select select {
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-sm);
        padding: 8px 14px;
        font-size: 13.5px;
        color: var(--clr-text);
        background: var(--clr-white);
        cursor: pointer;
        outline: none;
        transition: border-color var(--transition);
    }

    .sort-select select:focus {
        border-color: var(--clr-sage);
    }

    /* ─── SERVICE CARDS (shared design language) ─── */
    .services-grid {
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
        display: flex;
        align-items: baseline;
        gap: 7px;
        flex-wrap: wrap;
        margin-bottom: 4px;
    }

    .service-card .price-orig {
        font-size: 12px;
        color: var(--clr-muted);
        text-decoration: line-through;
    }

    .service-card .price-total {
        font-size: 18px;
        font-weight: 700;
        color: var(--clr-forest);
    }

    .service-card .price-cur {
        font-size: 12px;
        color: var(--clr-muted);
    }

    .service-card .discount-pill {
        font-size: 10.5px;
        font-weight: 700;
        color: #fff;
        background: #D85A30;
        padding: 3px 9px;
        border-radius: 100px;
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

    /* ─── EMPTY STATE ─── */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 70px 20px;
        background: var(--clr-bg-soft);
        border-radius: var(--radius-lg);
        border: 1px dashed var(--clr-sage-md);
    }

    .empty-state .icon-wrap {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--clr-sage-lt);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        color: var(--clr-sage);
    }

    .empty-state h4 {
        font-family: var(--font-display);
        font-size: 18px;
        color: var(--clr-forest);
        margin-bottom: 6px;
    }

    .empty-state p {
        font-size: 13.5px;
        color: var(--clr-muted);
    }

    /* ─── CTA STRIP ─── */
    .loc-cta {
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

    .loc-cta h2 {
        font-family: var(--font-display);
        font-size: clamp(20px, 3vw, 28px);
        color: var(--clr-forest);
        font-weight: 700;
        margin-bottom: 4px;
    }

    .loc-cta p {
        font-size: 15px;
        color: var(--clr-muted);
    }

    .loc-cta .actions {
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
        .loc-cta {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

@php
    // The location name is read from the route parameter used by the
    // home.service_location route. Pass a $location variable from the
    // controller instead if you'd rather not rely on the route param.
    $locationName = $location ?? request()->route('service_location') ?? 'this area';
@endphp

<div class="loc-page">

    <!-- ── BANNER ─────────────────────────────────── -->
    <div class="loc-banner">
        <div class="container-lg">
            <div class="crumbs">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <a href="{{ route('home.services') }}">Services</a>
                <span>/</span>
                <span style="color:#fff;">{{ $locationName }}</span>
            </div>
            <div class="pin-badge">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z" /><circle cx="12" cy="10" r="3" /></svg>
                Location
            </div>
            <h1>Services available in {{ $locationName }}</h1>
            <p>We deliver fast, reliable and vetted service providers ready to help near {{ $locationName }}.</p>
        </div>
    </div>

    <!-- ── LAYOUT ─────────────────────────────────── -->
    <section class="loc-layout">
        <div class="container-lg">
            <div class="loc-grid-wrap">

                <!-- FILTER SIDEBAR -->
                <aside>
                    <button class="filter-toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target="#filterPanelCollapse">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M7 12h10M10 18h4" /></svg>
                        Filter Services
                    </button>

                    <div class="collapse d-lg-block" id="filterPanelCollapse">
                        <div class="filter-panel">
                            <div class="fp-head">
                                <div class="eyebrow">Browse by</div>
                                <h3>Categories</h3>
                            </div>

                            <div class="filter-search">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7" /><path d="m21 21-4.3-4.3" /></svg>
                                <input type="text" id="filterCatSearch" placeholder="Search categories">
                            </div>

                            <ul class="filter-cat-list" id="filterCatList">
                                @foreach($scategories as $scateg)
                                <li class="filter-cat-item">
                                    <div class="fc-row">
                                        <a class="fc-link" href="{{ route('home.service_by_category', ['category_slug' => $scateg->slug]) }}">{{ $scateg->name }}</a>
                                        @if(count($scateg->subcategories) > 0)
                                        <button type="button" class="fc-toggle" aria-label="Toggle subcategories">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="m9 6 6 6-6 6" /></svg>
                                        </button>
                                        @endif
                                    </div>
                                    @if(count($scateg->subcategories) > 0)
                                    <ul class="fc-sub">
                                        @foreach($scateg->subcategories as $scat)
                                        <li>
                                            <input type="checkbox" id="subcat-{{ $scat->slug }}" name="JobType" value="{{ $scat->slug }}">
                                            <label for="subcat-{{ $scat->slug }}">
                                                <a href="{{ route('home.service_by_subcategory', ['subcategory_slug' => $scat->slug]) }}">{{ $scat->name }}</a>
                                            </label>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>

                            <div class="fp-foot">
                                <a href="{{ route('home.service_location', ['service_location' => $locationName]) }}" class="btn-apply-filter">Apply Filter</a>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- RESULTS -->
                <div>
                    <div class="results-top">
                        <div class="count">{{ $locations->count() }} <span>service{{ $locations->count() == 1 ? '' : 's' }} in {{ $locationName }}</span></div>
                        <div class="sort-select">
                            <label for="sortby">Sort:</label>
                            <select id="sortby">
                                <option value="0">Latest</option>
                                <option value="1">Category</option>
                                <option value="2">Job Type</option>
                            </select>
                        </div>
                    </div>

                    <div class="services-grid">
                        @forelse($locations as $service)
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
                        <div class="service-card">
                            <div class="thumb">
                                <a href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}">
                                    <img src="{{ asset('image/services/' . ($service->image ?? 'default.png')) }}" alt="{{ $service->name }}">
                                </a>
                                <span class="duration-badge">{{ $service->duration }}</span>
                            </div>
                            <div class="body">
                                <div class="cat-label">{{ $service->category->name }}</div>
                                <a href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}" class="svc-name">{{ $service->name }}</a>
                                <div class="price-row">
                                    @if($service->discount)
                                    <span class="price-orig">{{ $service->price }}</span>
                                    @if($service->discount_type == 'fixed')
                                    <span class="discount-pill">-{{ $service->discount }} RWF</span>
                                    @else
                                    <span class="discount-pill">-{{ $service->discount }}%</span>
                                    @endif
                                    @endif
                                    <span class="price-total">{{ number_format($total) }}</span>
                                    <span class="price-cur">RWF</span>
                                </div>
                                <div class="location-row">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    <a href="{{ route('home.service_location', ['service_location' => $service->location]) }}">{{ $service->location }}</a>
                                </div>
                                <div class="card-actions">
                                    <a href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}" class="btn-view-detail">View Detail</a>
                                    <a href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}" target="_blank" rel="noopener" class="btn-whatsapp">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 004.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2zm5.8 14.1c-.24.68-1.4 1.3-1.93 1.38-.5.08-1.12.11-1.8-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.13-4.9-4.32-.14-.19-1.17-1.55-1.17-2.96 0-1.4.73-2.09 1-2.38.26-.28.57-.35.76-.35h.55c.18 0 .42-.07.65.5.24.58.82 2 .89 2.15.07.15.12.32.02.51-.09.19-.14.31-.28.48-.14.16-.29.36-.42.49-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.28.36-.23.6-.14.24.09 1.55.73 1.82.86.27.14.44.2.51.32.07.12.07.68-.17 1.36z"/></svg>
                                        WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <div class="icon-wrap">
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z" /><circle cx="12" cy="10" r="3" /></svg>
                            </div>
                            <h4>No services found in {{ $locationName }}</h4>
                            <p>Try browsing a different location or explore all services instead.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ── CTA STRIP ─────────────────────────────────── -->
    <div class="container-lg" style="padding-bottom:80px;">
        <div class="loc-cta">
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

<script>
    (function () {
        // Toggle subcategory lists
        document.querySelectorAll('.fc-toggle').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                btn.closest('.filter-cat-item').classList.toggle('open');
            });
        });

        // Live search within the filter category list
        var searchInput = document.getElementById('filterCatSearch');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                var term = this.value.trim().toLowerCase();
                document.querySelectorAll('#filterCatList > .filter-cat-item').forEach(function (item) {
                    var name = item.querySelector('.fc-link').textContent.toLowerCase();
                    item.style.display = name.includes(term) ? '' : 'none';
                });
            });
        }
    })();
</script>

@endsection