@extends('layouts.base')

@section('title', $service->name)

@section('content')

<style>
    :root {
        --svc-primary: #6B9080;
        --svc-primary-dark: #4F7566;
        --svc-forest: #254035;
        --svc-forest-2: #1B3027;

        --svc-soft: #EBF2EF;
        --svc-soft-2: #F5F9F7;
        --svc-border: #DCE8E2;

        --svc-text: #1A2E26;
        --svc-muted: #687B73;
        --svc-white: #FFFFFF;

        --svc-success: #25D366;
        --svc-success-dark: #1DA851;

        --svc-warning: #F4A027;
        --svc-danger: #C24E2A;

        --svc-radius-sm: 10px;
        --svc-radius-md: 16px;
        --svc-radius-lg: 22px;

        --svc-shadow:
            0 4px 24px rgba(37, 64, 53, .07);

        --svc-shadow-lg:
            0 12px 40px rgba(37, 64, 53, .12);

        --svc-transition:
            .22s cubic-bezier(.4, 0, .2, 1);

        --svc-display:
            'Playfair Display', Georgia, serif;

        --svc-body:
            'DM Sans', sans-serif;
    }

    /* =========================================================
       BASE
    ========================================================= */

    .svc-page,
    .svc-page * {
        box-sizing: border-box;
    }

    .svc-page {
        background: #F8FAF9;
        color: var(--svc-text);
        font-family: var(--svc-body);
        min-height: 100vh;
    }

    .svc-page a {
        color: inherit;
        text-decoration: none;
    }

    .svc-page img {
        display: block;
        max-width: 100%;
    }

    .svc-container {
        width: min(1240px, calc(100% - 40px));
        margin: 0 auto;
    }

    /* =========================================================
       HERO
    ========================================================= */

    .svc-hero {
        position: relative;
        overflow: hidden;
        padding: 42px 0 110px;
        background:
            radial-gradient(
                circle at 8% 10%,
                rgba(107, 144, 128, .38),
                transparent 40%
            ),
            radial-gradient(
                circle at 90% 80%,
                rgba(107, 144, 128, .18),
                transparent 38%
            ),
            linear-gradient(
                135deg,
                var(--svc-forest),
                var(--svc-forest-2)
            );
    }

    .svc-hero::after {
        content: "";
        position: absolute;
        width: 420px;
        height: 420px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 50%;
        right: -160px;
        top: -180px;
    }

    .svc-breadcrumb {
        position: relative;
        z-index: 2;

        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;

        color: rgba(255,255,255,.55);
        font-size: 13px;
        margin-bottom: 28px;
    }

    .svc-breadcrumb a {
        color: rgba(255,255,255,.82);
        transition: color var(--svc-transition);
    }

    .svc-breadcrumb a:hover {
        color: #fff;
    }

    .svc-breadcrumb .current {
        color: #fff;
        font-weight: 600;
    }

    .svc-hero-content {
        position: relative;
        z-index: 2;

        display: flex;
        align-items: center;
        gap: 24px;
    }

    .svc-hero-image {
        width: 100px;
        height: 100px;

        flex: 0 0 100px;

        overflow: hidden;
        border-radius: 20px;

        border: 3px solid rgba(255,255,255,.18);

        background: var(--svc-soft);

        box-shadow:
            0 10px 30px rgba(0,0,0,.18);
    }

    .svc-hero-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .svc-hero-copy {
        min-width: 0;
    }

    .svc-category {
        display: inline-flex;
        align-items: center;
        gap: 7px;

        padding: 6px 12px;
        border-radius: 100px;

        background: rgba(194,217,209,.18);
        border: 1px solid rgba(194,217,209,.25);

        color: #DCEDE7;

        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;

        margin-bottom: 10px;
    }

    .svc-category-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--svc-primary);
    }

    .svc-hero h1 {
        margin: 0;

        color: #fff;

        font-family: var(--svc-display);
        font-size: clamp(30px, 4vw, 46px);
        line-height: 1.1;

        max-width: 800px;
    }

    .svc-hero-subtitle {
        margin-top: 12px;

        color: rgba(255,255,255,.7);

        font-size: 15px;
        line-height: 1.7;
        max-width: 700px;
    }

    /* =========================================================
       QUICK INFO BAR
    ========================================================= */

    .svc-quick-wrap {
        position: relative;
        margin-top: -62px;
        z-index: 10;
    }

    .svc-quick-bar {
        background: #fff;
        border: 1px solid var(--svc-border);
        border-radius: var(--svc-radius-lg);

        box-shadow: var(--svc-shadow-lg);

        padding: 20px 24px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;
    }

    .svc-quick-info {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 30px;
    }

    .svc-quick-item {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .svc-quick-icon {
        width: 38px;
        height: 38px;

        border-radius: 11px;

        display: flex;
        align-items: center;
        justify-content: center;

        color: var(--svc-primary);
        background: var(--svc-soft);
    }

    .svc-quick-text small {
        display: block;

        color: var(--svc-muted);

        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;

        margin-bottom: 2px;
    }

    .svc-quick-text strong {
        display: block;

        color: var(--svc-forest);

        font-size: 14px;
        font-weight: 700;
    }

    .svc-price {
        white-space: nowrap;
    }

    .svc-price-old {
        color: var(--svc-muted);
        font-size: 12px;
        text-decoration: line-through;
        margin-right: 5px;
    }

    .svc-price-current {
        color: var(--svc-forest);

        font-size: 20px;
        font-weight: 800;
    }

    .svc-price-currency {
        color: var(--svc-muted);
        font-size: 11px;
        font-weight: 600;
    }

    .svc-discount {
        display: inline-flex;
        align-items: center;

        margin-left: 6px;

        padding: 3px 8px;

        border-radius: 100px;

        color: #fff;
        background: var(--svc-danger);

        font-size: 10px;
        font-weight: 800;
    }

    /* =========================================================
       BUTTONS
    ========================================================= */

    .svc-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;

        border: none;
        cursor: pointer;

        font-family: inherit;
        font-size: 14px;
        font-weight: 700;

        border-radius: 12px;

        transition:
            transform var(--svc-transition),
            background var(--svc-transition),
            box-shadow var(--svc-transition);
    }

    .svc-btn:hover {
        transform: translateY(-1px);
    }

    .svc-btn-whatsapp {
        padding: 13px 20px;

        color: #fff;
        background: var(--svc-success);

        box-shadow:
            0 6px 18px rgba(37,211,102,.18);
    }

    .svc-btn-whatsapp:hover {
        color: #fff;
        background: var(--svc-success-dark);

        box-shadow:
            0 8px 24px rgba(37,211,102,.28);
    }

    .svc-btn-outline {
        padding: 11px 18px;

        color: var(--svc-forest);

        background: #fff;

        border: 1px solid var(--svc-border);
    }

    .svc-btn-outline:hover {
        color: var(--svc-forest);
        background: var(--svc-soft);
    }

    /* =========================================================
       PAGE BODY
    ========================================================= */

    .svc-body {
        padding: 46px 0 100px;
    }

    .svc-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            330px;

        gap: 30px;

        align-items: start;
    }

    /* =========================================================
       MAIN CONTENT
    ========================================================= */

    .svc-main {
        min-width: 0;
    }

    /* =========================================================
       STICKY CONTENT NAVIGATION
    ========================================================= */

    .svc-content-nav {
        position: sticky;
        top: 78px;
        z-index: 8;

        display: flex;
        align-items: center;
        gap: 4px;

        padding: 6px;

        margin-bottom: 22px;

        background: rgba(255,255,255,.94);

        border: 1px solid var(--svc-border);
        border-radius: 14px;

        box-shadow: 0 5px 20px rgba(37,64,53,.06);

        backdrop-filter: blur(12px);
    }

    .svc-content-nav a {
        padding: 9px 13px;

        border-radius: 9px;

        color: var(--svc-muted);

        font-size: 12px;
        font-weight: 700;

        white-space: nowrap;

        transition:
            color var(--svc-transition),
            background var(--svc-transition);
    }

    .svc-content-nav a:hover,
    .svc-content-nav a.active {
        color: var(--svc-forest);
        background: var(--svc-soft);
    }

    /* =========================================================
       CONTENT CARD
    ========================================================= */

    .svc-card {
        background: #fff;

        border: 1px solid var(--svc-border);
        border-radius: var(--svc-radius-lg);

        padding: 30px;

        margin-bottom: 22px;

        box-shadow: var(--svc-shadow);
        scroll-margin-top: 145px;
    }

    .svc-section-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 20px;

        margin-bottom: 20px;
    }

    .svc-section-label {
        display: inline-flex;

        padding: 5px 11px;

        border-radius: 100px;

        color: var(--svc-primary-dark);
        background: var(--svc-soft);

        font-size: 10px;
        font-weight: 800;

        letter-spacing: .09em;
        text-transform: uppercase;

        margin-bottom: 8px;
    }

    .svc-card h2 {
        margin: 0;

        color: var(--svc-forest);

        font-family: var(--svc-display);

        font-size: 25px;
        line-height: 1.2;
    }

    .svc-description {
        color: var(--svc-muted);

        font-size: 15px;
        line-height: 1.9;
    }

    .svc-description p {
        margin-bottom: 14px;
    }

    .svc-description p:last-child {
        margin-bottom: 0;
    }

    /* =========================================================
       GALLERY
    ========================================================= */

    .svc-gallery {
        display: grid;

        grid-template-columns:
            repeat(auto-fill, minmax(210px, 1fr));

        gap: 15px;
    }

    .svc-media {
        position: relative;

        overflow: hidden;

        border-radius: 14px;

        background: var(--svc-soft-2);
        border: 1px solid var(--svc-border);

        aspect-ratio: 4 / 3;
    }

    .svc-media img,
    .svc-media video {
        width: 100%;
        height: 100%;

        object-fit: cover;

        transition: transform .4s ease;
    }

    .svc-media:hover img {
        transform: scale(1.04);
    }

    .svc-media-overlay {
        position: absolute;

        left: 0;
        right: 0;
        bottom: 0;

        padding: 20px 14px 12px;

        background:
            linear-gradient(
                transparent,
                rgba(0,0,0,.65)
            );

        color: #fff;

        display: flex;
        justify-content: flex-end;
    }

    .svc-media-overlay a {
        width: 34px;
        height: 34px;

        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        background: rgba(255,255,255,.18);

        backdrop-filter: blur(6px);
    }

    /* =========================================================
       INCLUSION / EXCLUSION
    ========================================================= */

    .svc-details-grid {
        display: grid;

        grid-template-columns: 1fr 1fr;

        gap: 16px;
    }

    .svc-detail-box {
        padding: 22px;

        border-radius: 16px;
    }

    .svc-detail-box.included {
        background: var(--svc-soft);
        border: 1px solid #CFE1D9;
    }

    .svc-detail-box.excluded {
        background: #FCF1ED;
        border: 1px solid #F0D7CD;
    }

    .svc-detail-heading {
        display: flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 17px;

        font-size: 15px;
        font-weight: 800;
    }

    .included .svc-detail-heading {
        color: var(--svc-forest);
    }

    .excluded .svc-detail-heading {
        color: var(--svc-danger);
    }

    .svc-detail-list {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .svc-detail-list li {
        display: flex;
        align-items: flex-start;

        gap: 9px;

        margin-bottom: 11px;

        color: var(--svc-text);

        font-size: 13.5px;
        line-height: 1.6;
    }

    .svc-detail-list li:last-child {
        margin-bottom: 0;
    }

    .included .svc-detail-list svg {
        color: var(--svc-primary);
    }

    .excluded .svc-detail-list svg {
        color: var(--svc-danger);
    }

    /* =========================================================
       RELATED SERVICES
    ========================================================= */

    .svc-related-card {
        display: grid;

        grid-template-columns: 190px 1fr;

        overflow: hidden;

        border: 1px solid var(--svc-border);
        border-radius: 16px;

        background: #fff;

        transition:
            box-shadow var(--svc-transition),
            transform var(--svc-transition);
    }

    .svc-related-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--svc-shadow-lg);
    }

    .svc-related-image {
        min-height: 190px;
        overflow: hidden;
    }

    .svc-related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .svc-related-body {
        padding: 22px;
    }

    .svc-related-category {
        color: var(--svc-primary);

        font-size: 10px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .08em;

        margin-bottom: 7px;
    }

    .svc-related-title {
        display: block;

        color: var(--svc-forest);

        font-family: var(--svc-display);

        font-size: 20px;
        font-weight: 700;

        line-height: 1.25;

        margin-bottom: 12px;
    }

    .svc-related-meta {
        display: flex;
        flex-wrap: wrap;

        gap: 14px;

        color: var(--svc-muted);

        font-size: 12px;

        margin-bottom: 12px;
    }

    .svc-related-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .svc-related-price {
        color: var(--svc-forest);

        font-size: 19px;
        font-weight: 800;

        margin-bottom: 15px;
    }

    .svc-related-actions {
        display: flex;
        gap: 8px;
    }

    .svc-related-actions a {
        flex: 1;
    }

    /* =========================================================
       STICKY SIDEBAR
    ========================================================= */

    .svc-sidebar {
        position: sticky;
        top: 78px;

        display: flex;
        flex-direction: column;

        gap: 18px;

        max-height:
            calc(100vh - 95px);

        overflow-y: auto;

        scrollbar-width: thin;
        scrollbar-color:
            var(--svc-border)
            transparent;

        padding-bottom: 5px;
    }

    .svc-sidebar-card {
        background: #fff;

        border: 1px solid var(--svc-border);
        border-radius: var(--svc-radius-lg);

        padding: 20px;

        box-shadow: var(--svc-shadow);
    }

    /* =========================================================
       BOOKING CARD
    ========================================================= */

    .svc-booking-card {
        overflow: hidden;
    }

    .svc-booking-image {
        position: relative;

        margin: -20px -20px 18px;

        height: 205px;

        overflow: hidden;
    }

    .svc-booking-image img {
        width: 100%;
        height: 100%;

        object-fit: cover;
    }

    .svc-booking-image::after {
        content: "";

        position: absolute;

        inset: 0;

        background:
            linear-gradient(
                transparent 45%,
                rgba(0,0,0,.35)
            );
    }

    .svc-bookmark {
        position: absolute;

        z-index: 2;

        top: 13px;
        right: 13px;

        width: 40px;
        height: 40px;

        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        color: var(--svc-forest);

        background: rgba(255,255,255,.94);

        border: none;

        cursor: pointer;

        box-shadow: 0 5px 16px rgba(0,0,0,.14);

        transition:
            color var(--svc-transition),
            transform var(--svc-transition);
    }

    .svc-bookmark:hover {
        color: var(--svc-danger);
        transform: scale(1.05);
    }

    .svc-booking-category {
        color: var(--svc-primary);

        font-size: 10px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .08em;

        margin-bottom: 5px;
    }

    .svc-booking-title {
        margin: 0 0 15px;

        color: var(--svc-forest);

        font-family: var(--svc-display);

        font-size: 22px;
        line-height: 1.2;
    }

    .svc-booking-price {
        padding: 15px;

        border-radius: 13px;

        background: var(--svc-soft);

        margin-bottom: 16px;
    }

    .svc-booking-price-label {
        display: block;

        color: var(--svc-muted);

        font-size: 10px;
        font-weight: 700;

        text-transform: uppercase;
        letter-spacing: .08em;

        margin-bottom: 4px;
    }

    .svc-booking-price-value {
        color: var(--svc-forest);

        font-size: 25px;
        font-weight: 800;
    }

    .svc-booking-price-value small {
        color: var(--svc-muted);

        font-size: 11px;
        font-weight: 600;
    }

    .svc-booking-price-old {
        color: var(--svc-muted);

        font-size: 12px;

        text-decoration: line-through;

        margin-left: 5px;
    }

    .svc-booking-saving {
        display: block;

        color: var(--svc-primary-dark);

        font-size: 11px;
        font-weight: 700;

        margin-top: 3px;
    }

    .svc-booking-button {
        width: 100%;

        padding: 14px;
    }

    /* =========================================================
       PROVIDER / INFO
    ========================================================= */

    .svc-info-title {
        display: flex;
        align-items: center;
        gap: 8px;

        margin-bottom: 16px;

        color: var(--svc-forest);

        font-size: 14px;
        font-weight: 800;
    }

    .svc-info-title svg {
        color: var(--svc-primary);
    }

    .svc-info-row {
        display: flex;
        align-items: flex-start;

        gap: 10px;

        margin-bottom: 13px;

        color: var(--svc-muted);

        font-size: 13px;
        line-height: 1.5;
    }

    .svc-info-row:last-child {
        margin-bottom: 0;
    }

    .svc-info-row svg {
        flex-shrink: 0;
        color: var(--svc-primary);
        margin-top: 2px;
    }

    /* =========================================================
       SOCIALS
    ========================================================= */

    .svc-socials {
        display: flex;
        gap: 8px;

        margin-top: 16px;
    }

    .svc-social {
        width: 36px;
        height: 36px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        color: var(--svc-forest);
        background: var(--svc-soft);

        transition:
            color var(--svc-transition),
            background var(--svc-transition);
    }

    .svc-social:hover {
        color: #fff;
        background: var(--svc-forest);
    }

    /* =========================================================
       MAP
    ========================================================= */

    .svc-map {
        overflow: hidden;

        border-radius: 13px;

        border: 1px solid var(--svc-border);
    }

    .svc-map iframe {
        display: block;

        width: 100%;
        height: 220px;

        border: 0;
    }

    /* =========================================================
       RATING
    ========================================================= */

    .svc-stars {
        display: flex;
        gap: 4px;

        color: var(--svc-warning);

        font-size: 24px;

        margin-bottom: 6px;
    }

    .svc-rating-note {
        color: var(--svc-muted);

        font-size: 12px;
    }

    /* =========================================================
       CTA
    ========================================================= */

    .svc-bottom-cta {
        margin-top: 28px;

        padding: 35px;

        border-radius: var(--svc-radius-lg);

        background:
            radial-gradient(
                circle at 90% 10%,
                rgba(107,144,128,.35),
                transparent 35%
            ),
            var(--svc-forest);

        color: #fff;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 25px;

        overflow: hidden;
    }

    .svc-bottom-cta h2 {
        margin: 0 0 7px;

        font-family: var(--svc-display);

        font-size: 27px;
    }

    .svc-bottom-cta p {
        margin: 0;

        color: rgba(255,255,255,.68);

        font-size: 14px;
    }

    .svc-bottom-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .svc-bottom-actions .svc-btn-outline {
        color: #fff;

        border-color: rgba(255,255,255,.25);

        background: rgba(255,255,255,.08);
    }

    .svc-bottom-actions .svc-btn-outline:hover {
        color: var(--svc-forest);
        background: #fff;
    }

    /* =========================================================
       MOBILE STICKY BOOKING BAR
    ========================================================= */

    .svc-mobile-booking {
        display: none;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media(max-width: 1100px) {
        .svc-layout {
            grid-template-columns:
                minmax(0, 1fr)
                290px;
        }

        .svc-quick-info {
            gap: 20px;
        }
    }

    @media(max-width: 991px) {

        .svc-container {
            width: min(100% - 30px, 760px);
        }

        .svc-layout {
            grid-template-columns: 1fr;
        }

        .svc-sidebar {
            position: static;

            max-height: none;
            overflow: visible;

            order: -1;

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

        .svc-booking-card {
            grid-column: 1 / -1;
        }

        .svc-sidebar-card.map-card,
        .svc-sidebar-card.rating-card {
            height: 100%;
        }

        .svc-content-nav {
            top: 70px;

            overflow-x: auto;
            scrollbar-width: none;
        }

        .svc-content-nav::-webkit-scrollbar {
            display: none;
        }
    }

    @media(max-width: 767px) {

        body {
            padding-bottom: 76px;
        }

        .svc-container {
            width: min(100% - 24px, 680px);
        }

        .svc-hero {
            padding: 30px 0 90px;
        }

        .svc-hero-content {
            align-items: flex-start;
        }

        .svc-hero-image {
            width: 76px;
            height: 76px;
            flex-basis: 76px;
            border-radius: 15px;
        }

        .svc-hero h1 {
            font-size: 29px;
        }

        .svc-hero-subtitle {
            display: none;
        }

        .svc-quick-wrap {
            margin-top: -45px;
        }

        .svc-quick-bar {
            padding: 16px;

            align-items: flex-start;
        }

        .svc-quick-info {
            width: 100%;

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 13px;
        }

        .svc-quick-item {
            min-width: 0;
        }

        .svc-quick-icon {
            width: 34px;
            height: 34px;
        }

        .svc-quick-text strong {
            font-size: 12px;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .svc-quick-bar > .svc-btn {
            display: none;
        }

        .svc-body {
            padding-top: 28px;
            padding-bottom: 50px;
        }

        .svc-sidebar {
            display: block;
        }

        .svc-sidebar-card {
            margin-bottom: 18px;
        }

        .svc-sidebar-card.map-card,
        .svc-sidebar-card.rating-card {
            display: none;
        }

        .svc-content-nav {
            top: 0;

            position: relative;

            margin-bottom: 16px;
        }

        .svc-card {
            padding: 22px 18px;
            border-radius: 17px;
        }

        .svc-card h2 {
            font-size: 22px;
        }

        .svc-details-grid {
            grid-template-columns: 1fr;
        }

        .svc-gallery {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 10px;
        }

        .svc-related-card {
            grid-template-columns: 1fr;
        }

        .svc-related-image {
            height: 190px;
            min-height: 0;
        }

        .svc-bottom-cta {
            padding: 25px 20px;

            align-items: flex-start;
            flex-direction: column;
        }

        .svc-mobile-booking {
            position: fixed;

            left: 0;
            right: 0;
            bottom: 0;

            z-index: 999;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            padding:
                10px
                max(12px, env(safe-area-inset-right))
                calc(10px + env(safe-area-inset-bottom))
                max(12px, env(safe-area-inset-left));

            background: rgba(255,255,255,.96);

            border-top: 1px solid var(--svc-border);

            box-shadow:
                0 -8px 30px rgba(37,64,53,.12);

            backdrop-filter: blur(14px);
        }

        .svc-mobile-price {
            min-width: 0;
        }

        .svc-mobile-price small {
            display: block;

            color: var(--svc-muted);

            font-size: 9px;
            font-weight: 700;

            text-transform: uppercase;
        }

        .svc-mobile-price strong {
            color: var(--svc-forest);

            font-size: 18px;
            font-weight: 800;
        }

        .svc-mobile-price span {
            color: var(--svc-muted);
            font-size: 9px;
        }

        .svc-mobile-booking .svc-btn {
            flex: 1;
            max-width: 230px;

            padding: 12px 15px;

            border-radius: 10px;
        }
    }

    @media(max-width: 480px) {

        .svc-breadcrumb {
            font-size: 11px;
        }

        .svc-hero-content {
            gap: 14px;
        }

        .svc-hero-image {
            width: 64px;
            height: 64px;
            flex-basis: 64px;
        }

        .svc-hero h1 {
            font-size: 24px;
        }

        .svc-category {
            font-size: 9px;
            padding: 5px 9px;
        }

        .svc-gallery {
            grid-template-columns: 1fr 1fr;
        }

        .svc-media {
            aspect-ratio: 1 / 1;
        }

        .svc-bottom-actions {
            width: 100%;
        }

        .svc-bottom-actions .svc-btn {
            flex: 1;
        }
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap"
    rel="stylesheet"
>

@php

    /*
    |--------------------------------------------------------------------------
    | PRICE
    |--------------------------------------------------------------------------
    */

    $total = $service->price;

    if ($service->discount) {

        if ($service->discount_type === 'fixed') {
            $total = $total - $service->discount;
        }

        if ($service->discount_type === 'percent') {
            $total = $total - (
                $total * $service->discount / 100
            );
        }
    }

    $total = max(0, $total);

    /*
    |--------------------------------------------------------------------------
    | WHATSAPP
    |--------------------------------------------------------------------------
    */

    $waRawPhone =
        optional($service->sprovider ?? null)->phone
        ?? config(
            'services.whatsapp.default_number',
            '250780000000'
        );

    $waPhone = preg_replace(
        '/\D+/',
        '',
        $waRawPhone
    );

    $waMessage = rawurlencode(
        'Hello! I\'m interested in booking "' .
        $service->name .
        '" (' .
        number_format($total) .
        ' RWF). Is it available?'
    );

@endphp


<div class="svc-page">

    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="svc-hero">

        <div class="svc-container">

            <nav class="svc-breadcrumb">

                <a href="{{ route('home') }}">
                    Home
                </a>

                <span>/</span>

                <a href="{{ route(
                    'home.service_by_category',
                    ['category_slug' => $service->category->slug]
                ) }}">
                    {{ $service->category->name }}
                </a>

                <span>/</span>

                <span class="current">
                    {{ $service->name }}
                </span>

            </nav>


            <div class="svc-hero-content">

                <div class="svc-hero-image">

                    <img
                        src="{{ asset(
                            'image/services/' .
                            ($service->image ?? 'default.png')
                        ) }}"
                        alt="{{ $service->name }}"
                    >

                </div>


                <div class="svc-hero-copy">

                    <span class="svc-category">

                        <span class="svc-category-dot"></span>

                        {{ $service->category->name }}

                    </span>

                    <h1>
                        {{ $service->name }}
                    </h1>

                    <div class="svc-hero-subtitle">
                        Find everything you need to know about this
                        service, including pricing, availability,
                        location and booking information.
                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         QUICK INFO
    ====================================================== --}}

    <div class="svc-container svc-quick-wrap">

        <div class="svc-quick-bar">

            <div class="svc-quick-info">

                {{-- LOCATION --}}
                <div class="svc-quick-item">

                    <div class="svc-quick-icon">
                        <svg width="17" height="17"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>

                    <div class="svc-quick-text">

                        <small>
                            Location
                        </small>

                        <strong>
                            {{ $service->location }}
                        </strong>

                    </div>

                </div>


                {{-- DURATION --}}
                <div class="svc-quick-item">

                    <div class="svc-quick-icon">
                        <svg width="17" height="17"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 7v5l3 3"/>
                        </svg>
                    </div>

                    <div class="svc-quick-text">

                        <small>
                            Duration
                        </small>

                        <strong>
                            {{ $service->duration }}
                        </strong>

                    </div>

                </div>


                {{-- PRICE --}}
                <div class="svc-quick-item">

                    <div class="svc-quick-icon">
                        <svg width="17" height="17"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <path d="M12 1v22"/>
                            <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                        </svg>
                    </div>

                    <div class="svc-quick-text">

                        <small>
                            Starting price
                        </small>

                        <div class="svc-price">

                            @if($service->discount)

                                <span class="svc-price-old">
                                    {{ number_format($service->price) }}
                                    RWF
                                </span>

                            @endif

                            <span class="svc-price-current">
                                {{ number_format($total) }}
                            </span>

                            <span class="svc-price-currency">
                                RWF
                            </span>

                            @if($service->discount)

                                <span class="svc-discount">

                                    @if($service->discount_type === 'fixed')
                                        -{{ number_format($service->discount) }}
                                        RWF
                                    @else
                                        -{{ $service->discount }}%
                                    @endif

                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>


            <a
                href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}"
                target="_blank"
                rel="noopener"
                class="svc-btn svc-btn-whatsapp"
            >

                <svg width="17" height="17"
                     viewBox="0 0 24 24"
                     fill="currentColor">

                    <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 004.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2z"/>
                </svg>

                Book via WhatsApp

            </a>

        </div>

    </div>


    {{-- =====================================================
         BODY
    ====================================================== --}}

    <section class="svc-body">

        <div class="svc-container">

            <div class="svc-layout">


                {{-- =================================================
                     MAIN
                ================================================== --}}

                <main class="svc-main">


                    {{-- CONTENT NAV --}}
                    <nav class="svc-content-nav">

                        <a href="#overview" class="active">
                            Overview
                        </a>

                        @if($service->media->isNotEmpty())
                            <a href="#gallery">
                                Gallery
                            </a>
                        @endif

                        <a href="#details">
                            What's Included
                        </a>

                        @if($r_service)
                            <a href="#related">
                                Related
                            </a>
                        @endif

                    </nav>


                    {{-- =================================================
                         OVERVIEW
                    ================================================== --}}

                    <section
                        id="overview"
                        class="svc-card"
                    >

                        <div class="svc-section-heading">

                            <div>

                                <span class="svc-section-label">
                                    About this service
                                </span>

                                <h2>
                                    Overview
                                </h2>

                            </div>

                        </div>

                        <div class="svc-description">
                            {!! $service->description !!}
                        </div>

                    </section>


                    {{-- =================================================
                         GALLERY
                    ================================================== --}}

                    @if($service->media->isNotEmpty())

                        <section
                            id="gallery"
                            class="svc-card"
                        >

                            <div class="svc-section-heading">

                                <div>

                                    <span class="svc-section-label">
                                        Visuals
                                    </span>

                                    <h2>
                                        Service Gallery
                                    </h2>

                                </div>

                                <span style="
                                    color:var(--svc-muted);
                                    font-size:12px;
                                ">
                                    {{ $service->media->count() }}
                                    items
                                </span>

                            </div>


                            <div class="svc-gallery">

                                @foreach($service->media as $media)

                                    <div class="svc-media">

                                        @if($media->type === 'image')

                                            <img
                                                src="{{ asset(
                                                    'image/services/' .
                                                    $media->file_path
                                                ) }}"
                                                alt="{{ $service->name }}"
                                                loading="lazy"
                                            >

                                        @elseif($media->type === 'video')

                                            <video
                                                controls
                                                preload="metadata"
                                            >
                                                <source
                                                    src="{{ asset(
                                                        'image/services/' .
                                                        $media->file_path
                                                    ) }}"
                                                    type="video/mp4"
                                                >
                                            </video>

                                        @endif


                                        <div class="svc-media-overlay">

                                            <a
                                                href="{{ asset(
                                                    'image/services/' .
                                                    $media->file_path
                                                ) }}"
                                                target="_blank"
                                                rel="noopener"
                                                aria-label="View media"
                                            >

                                                <svg
                                                    width="15"
                                                    height="15"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path d="M15 3h6v6"/>
                                                    <path d="M10 14L21 3"/>
                                                    <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                                                </svg>

                                            </a>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </section>

                    @endif


                    {{-- =================================================
                         DETAILS
                    ================================================== --}}

                    <section
                        id="details"
                        class="svc-card"
                    >

                        <div class="svc-section-heading">

                            <div>

                                <span class="svc-section-label">
                                    Service details
                                </span>

                                <h2>
                                    What's included
                                </h2>

                            </div>

                        </div>


                        <div class="svc-details-grid">


                            {{-- INCLUDED --}}

                            <div class="svc-detail-box included">

                                <div class="svc-detail-heading">

                                    <svg
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                    >
                                        <path d="M20 6 9 17l-5-5"/>
                                    </svg>

                                    Included

                                </div>


                                <ul class="svc-detail-list">

                                    @foreach(
                                        explode('|', $service->inclusion)
                                        as $inclusion
                                    )

                                        @if(trim($inclusion) !== '')

                                            <li>

                                                <svg
                                                    width="15"
                                                    height="15"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2.5"
                                                >
                                                    <path d="M20 6 9 17l-5-5"/>
                                                </svg>

                                                <span>
                                                    {!! $inclusion !!}
                                                </span>

                                            </li>

                                        @endif

                                    @endforeach

                                </ul>

                            </div>


                            {{-- EXCLUDED --}}

                            <div class="svc-detail-box excluded">

                                <div class="svc-detail-heading">

                                    <svg
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                    >
                                        <path d="M18 6 6 18M6 6l12 12"/>
                                    </svg>

                                    Not Included

                                </div>


                                <ul class="svc-detail-list">

                                    @foreach(
                                        explode('|', $service->exclusion)
                                        as $exclusion
                                    )

                                        @if(trim($exclusion) !== '')

                                            <li>

                                                <svg
                                                    width="15"
                                                    height="15"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2.5"
                                                >
                                                    <path d="M18 6 6 18M6 6l12 12"/>
                                                </svg>

                                                <span>
                                                    {!! $exclusion !!}
                                                </span>

                                            </li>

                                        @endif

                                    @endforeach

                                </ul>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                         RELATED
                    ================================================== --}}

                    @if($r_service)

                        @php

                            $rTotal = $r_service->price;

                            if ($r_service->discount) {

                                if ($r_service->discount_type === 'fixed') {

                                    $rTotal =
                                        $rTotal -
                                        $r_service->discount;

                                }

                                if ($r_service->discount_type === 'percent') {

                                    $rTotal =
                                        $rTotal -
                                        (
                                            $rTotal *
                                            $r_service->discount /
                                            100
                                        );

                                }
                            }

                            $rTotal = max(0, $rTotal);

                            $rWaPhone =
                                preg_replace(
                                    '/\D+/',
                                    '',
                                    optional(
                                        $r_service->sprovider ?? null
                                    )->phone
                                    ??
                                    config(
                                        'services.whatsapp.default_number',
                                        '250780000000'
                                    )
                                );

                            $rWaMessage = rawurlencode(
                                'Hello! I\'m interested in booking "' .
                                $r_service->name .
                                '" (' .
                                number_format($rTotal) .
                                ' RWF). Is it available?'
                            );

                        @endphp


                        <section
                            id="related"
                            class="svc-card"
                        >

                            <div class="svc-section-heading">

                                <div>

                                    <span class="svc-section-label">
                                        Explore more
                                    </span>

                                    <h2>
                                        You might also like
                                    </h2>

                                </div>

                            </div>


                            <div class="svc-related-card">

                                <div class="svc-related-image">

                                    <a href="{{ route(
                                        'home.service_details',
                                        ['service_slug' => $r_service->slug]
                                    ) }}">

                                        <img
                                            src="{{ asset(
                                                'image/services/' .
                                                ($r_service->image ?? 'default.png')
                                            ) }}"
                                            alt="{{ $r_service->name }}"
                                            loading="lazy"
                                        >

                                    </a>

                                </div>


                                <div class="svc-related-body">

                                    <div class="svc-related-category">
                                        {{ $r_service->category->name }}
                                    </div>

                                    <a
                                        href="{{ route(
                                            'home.service_details',
                                            ['service_slug' => $r_service->slug]
                                        ) }}"
                                        class="svc-related-title"
                                    >
                                        {{ $r_service->name }}
                                    </a>


                                    <div class="svc-related-meta">

                                        <span>

                                            <svg
                                                width="13"
                                                height="13"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/>
                                                <circle cx="12" cy="10" r="3"/>
                                            </svg>

                                            {{ $r_service->location }}

                                        </span>


                                        <span>

                                            <svg
                                                width="13"
                                                height="13"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <circle cx="12" cy="12" r="9"/>
                                                <path d="M12 7v5l3 3"/>
                                            </svg>

                                            {{ $r_service->duration }}

                                        </span>

                                    </div>


                                    <div class="svc-related-price">

                                        {{ number_format($rTotal) }}

                                        <span style="
                                            color:var(--svc-muted);
                                            font-size:11px;
                                            font-weight:600;
                                        ">
                                            RWF
                                        </span>

                                    </div>


                                    <div class="svc-related-actions">

                                        <a
                                            href="{{ route(
                                                'home.service_details',
                                                ['service_slug' => $r_service->slug]
                                            ) }}"
                                            class="svc-btn svc-btn-outline"
                                        >
                                            View service
                                        </a>


                                        <a
                                            href="https://wa.me/{{ $rWaPhone }}?text={{ $rWaMessage }}"
                                            target="_blank"
                                            rel="noopener"
                                            class="svc-btn svc-btn-whatsapp"
                                        >

                                            <svg
                                                width="14"
                                                height="14"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                            >
                                                <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 004.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2z"/>
                                            </svg>

                                            WhatsApp

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </section>

                    @endif


                </main>


                {{-- =================================================
                     STICKY SIDEBAR
                ================================================== --}}

                <aside class="svc-sidebar">


                    {{-- =================================================
                         BOOKING
                    ================================================== --}}

                    <div class="svc-sidebar-card svc-booking-card">

                        <div class="svc-booking-image">

                            <img
                                src="{{ asset(
                                    'image/services/' .
                                    ($service->image ?? 'default.png')
                                ) }}"
                                alt="{{ $service->name }}"
                            >


                            <button
                                type="button"
                                class="svc-bookmark"
                                aria-label="Save service"
                                onclick="this.classList.toggle('saved')"
                            >

                                <i class="bi bi-heart"></i>

                            </button>

                        </div>


                        <div class="svc-booking-category">
                            {{ $service->category->name }}
                        </div>


                        <h3 class="svc-booking-title">
                            {{ $service->name }}
                        </h3>


                        {{-- PRICE BOX --}}

                        <div class="svc-booking-price">

                            <span class="svc-booking-price-label">
                                Service price
                            </span>


                            <div class="svc-booking-price-value">

                                {{ number_format($total) }}

                                <small>RWF</small>


                                @if($service->discount)

                                    <span class="svc-booking-price-old">
                                        {{ number_format($service->price) }}
                                        RWF
                                    </span>

                                @endif

                            </div>


                            @if($service->discount)

                                <span class="svc-booking-saving">

                                    You save

                                    @if($service->discount_type === 'fixed')

                                        {{ number_format($service->discount) }}
                                        RWF

                                    @else

                                        {{ $service->discount }}%

                                    @endif

                                </span>

                            @endif

                        </div>


                        <a
                            href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}"
                            target="_blank"
                            rel="noopener"
                            class="svc-btn svc-btn-whatsapp svc-booking-button"
                        >

                            <svg
                                width="17"
                                height="17"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                            >
                                <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 004.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2z"/>
                            </svg>

                            Book via WhatsApp

                        </a>

                    </div>


                    {{-- =================================================
                         SERVICE INFORMATION
                    ================================================== --}}

                    <div class="svc-sidebar-card">

                        <div class="svc-info-title">

                            <svg
                                width="17"
                                height="17"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 8h.01M11 12h1v4h1"/>
                            </svg>

                            Service information

                        </div>


                        <div class="svc-info-row">

                            <svg
                                width="15"
                                height="15"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>

                            <span>
                                {{ $service->location }}
                            </span>

                        </div>


                        <div class="svc-info-row">

                            <svg
                                width="15"
                                height="15"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 3"/>
                            </svg>

                            <span>
                                {{ $service->duration }}
                            </span>

                        </div>


                        <div class="svc-info-row">

                            <svg
                                width="15"
                                height="15"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M12 1v22"/>
                                <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                            </svg>

                            <span>
                                {{ number_format($total) }} RWF
                            </span>

                        </div>


                        <div class="svc-socials">

                            <a href="#"
                               class="svc-social"
                               aria-label="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>

                            <a href="#"
                               class="svc-social"
                               aria-label="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>

                            <a href="#"
                               class="svc-social"
                               aria-label="Twitter">
                                <i class="bi bi-twitter"></i>
                            </a>

                            <a href="#"
                               class="svc-social"
                               aria-label="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>

                        </div>

                    </div>


                    {{-- =================================================
                         MAP
                    ================================================== --}}

                    <div class="svc-sidebar-card map-card">

                        <div class="svc-info-title">

                            <svg
                                width="17"
                                height="17"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1116 0z"/>
                                <circle cx="12" cy="10" r="2.5"/>
                            </svg>

                            Find us

                        </div>


                        <div class="svc-map">

                            <iframe
                                src="https://maps.google.com/maps?width=600&height=400&hl=en&q={{ urlencode($service->location) }}&t=&z=12&ie=UTF8&iwloc=B&output=embed"
                                loading="lazy"
                                title="Service location"
                            ></iframe>

                        </div>

                    </div>


                    {{-- =================================================
                         RATING
                    ================================================== --}}

                    <div class="svc-sidebar-card rating-card">

                        <div class="svc-info-title">

                            <svg
                                width="17"
                                height="17"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1.1 6.2L12 17.3 6.4 20.2l1.1-6.2L3 9.6l6.2-.9L12 3z"/>
                            </svg>

                            Your feedback

                        </div>


                        <div class="svc-stars">

                            <span>☆</span>
                            <span>☆</span>
                            <span>☆</span>
                            <span>☆</span>
                            <span>☆</span>

                        </div>


                        <div class="svc-rating-note">
                            How would you rate this service?
                        </div>

                    </div>


                </aside>

            </div>


            {{-- =====================================================
                 BOTTOM CTA
            ====================================================== --}}

            <div class="svc-bottom-cta">

                <div>

                    <h2>
                        Ready to find the right service?
                    </h2>

                    <p>
                        Explore more services or join our growing
                        service marketplace.
                    </p>

                </div>


                <div class="svc-bottom-actions">

                    <a
                        href="{{ route('home.services') }}"
                        class="svc-btn svc-btn-outline"
                    >
                        Browse services
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="svc-btn svc-btn-whatsapp"
                        style="background:var(--svc-primary);"
                    >
                        Join the platform
                    </a>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         MOBILE STICKY BOOKING
    ====================================================== --}}

    <div class="svc-mobile-booking">

        <div class="svc-mobile-price">

            <small>
                Service price
            </small>

            <strong>
                {{ number_format($total) }}
            </strong>

            <span>
                RWF
            </span>

        </div>


        <a
            href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}"
            target="_blank"
            rel="noopener"
            class="svc-btn svc-btn-whatsapp"
        >

            <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="currentColor"
            >
                <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 004.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2z"/>
            </svg>

            Book now

        </a>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | ACTIVE CONTENT NAVIGATION
    |--------------------------------------------------------------------------
    */

    const navLinks =
        document.querySelectorAll(
            '.svc-content-nav a'
        );

    const sections =
        document.querySelectorAll(
            '.svc-card[id]'
        );


    function updateActiveNavigation() {

        let current =
            '';

        sections.forEach(function (section) {

            const sectionTop =
                section.getBoundingClientRect().top;

            if (sectionTop <= 190) {

                current =
                    section.getAttribute('id');

            }

        });


        navLinks.forEach(function (link) {

            link.classList.remove('active');

            const href =
                link.getAttribute('href');

            if (href === '#' + current) {

                link.classList.add('active');

            }

        });

    }


    window.addEventListener(
        'scroll',
        updateActiveNavigation,
        { passive: true }
    );


    /*
    |--------------------------------------------------------------------------
    | SMOOTH SCROLL
    |--------------------------------------------------------------------------
    */

    navLinks.forEach(function (link) {

        link.addEventListener(
            'click',
            function (event) {

                const targetId =
                    this.getAttribute('href');

                if (!targetId ||
                    !targetId.startsWith('#')) {
                    return;
                }

                const target =
                    document.querySelector(
                        targetId
                    );

                if (!target) {
                    return;
                }

                event.preventDefault();

                const offset =
                    135;

                const top =
                    target.getBoundingClientRect().top +
                    window.pageYOffset -
                    offset;

                window.scrollTo({
                    top: top,
                    behavior: 'smooth'
                });

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | BOOKMARK
    |--------------------------------------------------------------------------
    */

    const bookmark =
        document.querySelector(
            '.svc-bookmark'
        );

    if (bookmark) {

        bookmark.addEventListener(
            'click',
            function () {

                const icon =
                    this.querySelector('i');

                this.classList.toggle(
                    'saved'
                );

                if (
                    this.classList.contains(
                        'saved'
                    )
                ) {

                    icon.classList.remove(
                        'bi-heart'
                    );

                    icon.classList.add(
                        'bi-heart-fill'
                    );

                } else {

                    icon.classList.remove(
                        'bi-heart-fill'
                    );

                    icon.classList.add(
                        'bi-heart'
                    );

                }

            }
        );

    }

});

</script>

@endsection