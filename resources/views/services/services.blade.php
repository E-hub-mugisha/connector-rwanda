@extends('layouts.base')
@section('title', 'Services')
@section('content')

<style>
    :root {
        --clr-white: #fff;
        --clr-sage: #6B9080;
        --clr-sage-dark: #527866;
        --clr-sage-soft: #EDF4F1;
        --clr-sage-pale: #F6FAF8;

        --clr-forest: #254035;
        --clr-forest-2: #1B3027;

        --clr-text: #182B24;
        --clr-muted: #71837B;
        --clr-border: #E2EAE6;
        --clr-bg: #F8FAF9;

        --clr-success: #25D366;
        --clr-success-dark: #1DA851;

        --clr-discount: #D85A30;

        --radius-sm: 10px;
        --radius-md: 16px;
        --radius-lg: 22px;
        --radius-xl: 28px;

        --shadow-sm: 0 2px 10px rgba(37, 64, 53, .05);
        --shadow-md: 0 8px 30px rgba(37, 64, 53, .08);
        --shadow-lg: 0 18px 45px rgba(37, 64, 53, .12);

        --font-display: 'Playfair Display', Georgia, serif;
        --font-body: 'DM Sans', sans-serif;

        --transition: .22s cubic-bezier(.4, 0, .2, 1);
    }

    /* =========================================================
       BASE
    ========================================================= */

    .svcs-page,
    .svcs-page * {
        box-sizing: border-box;
    }

    .svcs-page {
        min-height: 100vh;
        background: var(--clr-bg);
        color: var(--clr-text);
        font-family: var(--font-body);
    }

    .svcs-page a {
        color: inherit;
        text-decoration: none;
    }

    .svcs-page img {
        display: block;
        width: 100%;
    }

    .svcs-container {
        width: min(1280px, calc(100% - 40px));
        margin: 0 auto;
    }

    /* =========================================================
       HERO
    ========================================================= */

    .services-hero {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(
                circle at 8% 20%,
                rgba(107, 144, 128, .30),
                transparent 34%
            ),
            radial-gradient(
                circle at 92% 85%,
                rgba(107, 144, 128, .20),
                transparent 32%
            ),
            linear-gradient(
                135deg,
                #254035 0%,
                #1C3028 55%,
                #14251F 100%
            );
    }

    .services-hero::after {
        content: "";
        position: absolute;
        width: 380px;
        height: 380px;
        right: -150px;
        top: -180px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 50%;
    }

    .services-hero-inner {
        position: relative;
        z-index: 1;
        padding: 58px 0 76px;
    }

    .hero-breadcrumb {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        margin-bottom: 20px;
        color: rgba(255,255,255,.55);
        font-size: 13px;
    }

    .hero-breadcrumb a {
        color: rgba(255,255,255,.82);
        transition: color var(--transition);
    }

    .hero-breadcrumb a:hover {
        color: #fff;
    }

    .hero-breadcrumb svg {
        opacity: .45;
    }

    .hero-kicker {
        width: fit-content;
        margin: 0 auto 13px;
        padding: 7px 13px;
        border: 1px solid rgba(255,255,255,.15);
        border-radius: 100px;
        background: rgba(255,255,255,.07);
        backdrop-filter: blur(8px);
        color: rgba(255,255,255,.78);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .11em;
        text-transform: uppercase;
    }

    .services-hero h1 {
        margin: 0;
        color: #fff;
        text-align: center;
        font-family: var(--font-display);
        font-size: clamp(36px, 5vw, 58px);
        line-height: 1.08;
        font-weight: 700;
        letter-spacing: -.025em;
    }

    .services-hero-description {
        max-width: 620px;
        margin: 18px auto 0;
        color: rgba(255,255,255,.67);
        font-size: 15px;
        line-height: 1.75;
        text-align: center;
    }

    /* =========================================================
       SEARCH / QUICK FILTER
    ========================================================= */

    .hero-search-wrap {
        position: relative;
        z-index: 5;
        width: min(850px, 100%);
        margin: -31px auto 0;
    }

    .hero-search {
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: center;
        gap: 10px;
        padding: 9px;
        background: rgba(255,255,255,.97);
        border: 1px solid rgba(255,255,255,.7);
        border-radius: 18px;
        box-shadow: var(--shadow-lg);
    }

    .hero-search-input {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 13px 16px;
        min-width: 0;
    }

    .hero-search-input svg {
        flex-shrink: 0;
        color: var(--clr-sage);
    }

    .hero-search-input input {
        width: 100%;
        min-width: 0;
        border: 0;
        outline: 0;
        background: transparent;
        color: var(--clr-text);
        font-family: inherit;
        font-size: 14px;
    }

    .hero-search-input input::placeholder {
        color: #9AA9A2;
    }

    .hero-search-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 48px;
        padding: 0 23px;
        border: 0;
        border-radius: 12px;
        background: var(--clr-forest);
        color: #fff;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition:
            transform var(--transition),
            background var(--transition);
    }

    .hero-search-button:hover {
        background: var(--clr-forest-2);
        transform: translateY(-1px);
    }

    /* =========================================================
       MAIN
    ========================================================= */

    .services-content {
        padding: 54px 0 75px;
    }

    .services-layout {
        display: grid;
        grid-template-columns: 260px minmax(0, 1fr);
        gap: 34px;
        align-items: start;
    }

    /* =========================================================
       FILTER SIDEBAR
    ========================================================= */

    .filter-mobile-toggle {
        display: none;
    }

    .filter-sidebar {
        position: sticky;
        top: 92px;
        min-width: 0;
    }

    .filter-card {
        overflow: hidden;
        background: var(--clr-white);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
    }

    .filter-header {
        padding: 21px 20px 18px;
        border-bottom: 1px solid var(--clr-border);
    }

    .filter-header-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .filter-eyebrow {
        margin-bottom: 4px;
        color: var(--clr-sage);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .filter-title {
        margin: 0;
        color: var(--clr-forest);
        font-family: var(--font-display);
        font-size: 21px;
        line-height: 1.2;
    }

    .filter-icon {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: var(--clr-sage-soft);
        color: var(--clr-sage);
    }

    .category-search {
        margin: 16px 15px 8px;
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 10px 12px;
        border: 1px solid var(--clr-border);
        border-radius: 11px;
        background: var(--clr-bg);
    }

    .category-search svg {
        flex-shrink: 0;
        color: var(--clr-muted);
    }

    .category-search input {
        width: 100%;
        min-width: 0;
        border: 0;
        outline: 0;
        background: transparent;
        color: var(--clr-text);
        font-family: inherit;
        font-size: 12.5px;
    }

    .category-search input::placeholder {
        color: #9AA9A2;
    }

    .category-list {
        max-height: 430px;
        overflow-y: auto;
        list-style: none;
        margin: 0;
        padding: 7px 10px 10px;
    }

    .category-list::-webkit-scrollbar {
        width: 4px;
    }

    .category-list::-webkit-scrollbar-thumb {
        background: var(--clr-sage-md, #C2D9D1);
        border-radius: 20px;
    }

    .category-item {
        margin-bottom: 2px;
    }

    .category-row {
        display: flex;
        align-items: center;
        gap: 4px;
        border-radius: 10px;
        transition: background var(--transition);
    }

    .category-row:hover {
        background: var(--clr-sage-pale);
    }

    .category-link {
        flex: 1;
        min-width: 0;
        padding: 10px 9px;
        overflow: hidden;
        color: var(--clr-text);
        font-size: 13px;
        font-weight: 600;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .category-toggle {
        width: 30px;
        height: 30px;
        margin-right: 3px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: var(--clr-muted);
        cursor: pointer;
    }

    .category-toggle:hover {
        background: var(--clr-sage-soft);
        color: var(--clr-sage);
    }

    .category-toggle svg {
        transition: transform var(--transition);
    }

    .category-item.open .category-toggle svg {
        transform: rotate(90deg);
    }

    .subcategory-list {
        display: none;
        list-style: none;
        margin: 0;
        padding: 0 8px 7px 22px;
    }

    .category-item.open .subcategory-list {
        display: block;
    }

    .subcategory-list a {
        display: block;
        padding: 7px 10px;
        border-radius: 8px;
        color: var(--clr-muted);
        font-size: 12px;
        transition:
            background var(--transition),
            color var(--transition);
    }

    .subcategory-list a:hover {
        background: var(--clr-sage-soft);
        color: var(--clr-forest);
    }

    .filter-footer {
        padding: 15px;
        border-top: 1px solid var(--clr-border);
    }

    .all-services-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        padding: 11px 14px;
        border-radius: 11px;
        background: var(--clr-sage-soft);
        color: var(--clr-forest);
        font-size: 12.5px;
        font-weight: 700;
        transition:
            background var(--transition),
            color var(--transition);
    }

    .all-services-btn:hover {
        background: var(--clr-forest);
        color: #fff;
    }

    /* =========================================================
       RESULTS HEADER
    ========================================================= */

    .results-area {
        min-width: 0;
    }

    .results-toolbar {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 26px;
    }

    .results-heading small {
        display: block;
        margin-bottom: 5px;
        color: var(--clr-muted);
        font-size: 12px;
        font-weight: 500;
    }

    .results-heading h2 {
        margin: 0;
        color: var(--clr-forest);
        font-family: var(--font-display);
        font-size: 26px;
        line-height: 1.15;
    }

    .results-heading h2 span {
        color: var(--clr-sage);
    }

    .sort-wrapper {
        display: flex;
        align-items: center;
        gap: 9px;
        flex-shrink: 0;
    }

    .sort-label {
        color: var(--clr-muted);
        font-size: 12px;
        font-weight: 600;
    }

    .sort-select {
        min-width: 155px;
        padding: 10px 34px 10px 12px;
        border: 1px solid var(--clr-border);
        border-radius: 10px;
        outline: none;
        background: #fff;
        color: var(--clr-text);
        font-family: inherit;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
    }

    .sort-select:focus {
        border-color: var(--clr-sage);
    }

    /* =========================================================
       SERVICES GRID
    ========================================================= */

    .services-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    /* =========================================================
       SERVICE CARD
    ========================================================= */

    .service-card {
        position: relative;
        min-width: 0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: var(--clr-white);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        transition:
            transform var(--transition),
            box-shadow var(--transition),
            border-color var(--transition);
    }

    .service-card:hover {
        transform: translateY(-5px);
        border-color: #CFE0D9;
        box-shadow: var(--shadow-lg);
    }

    /* IMAGE */

    .service-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 1.25 / 1;
        background: var(--clr-sage-soft);
    }

    .service-image a {
        display: block;
        height: 100%;
    }

    .service-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .6s cubic-bezier(.2,.7,.2,1);
    }

    .service-card:hover .service-image img {
        transform: scale(1.06);
    }

    .image-overlay {
        position: absolute;
        inset: 0;
        pointer-events: none;
        background:
            linear-gradient(
                180deg,
                rgba(0,0,0,.15) 0%,
                transparent 35%,
                rgba(0,0,0,.08) 100%
            );
    }

    /* BADGES */

    .service-top-badges {
        position: absolute;
        z-index: 2;
        top: 12px;
        left: 12px;
        right: 12px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
    }

    .service-badges-left {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .service-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 9px;
        border-radius: 100px;
        background: rgba(255,255,255,.94);
        backdrop-filter: blur(8px);
        color: var(--clr-forest);
        font-size: 10.5px;
        font-weight: 800;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
    }

    .service-badge.discount {
        background: var(--clr-discount);
        color: #fff;
    }

    .service-badge.duration {
        background: rgba(37,64,53,.88);
        color: #fff;
    }

    .favorite-button {
        width: 37px;
        height: 37px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 0;
        border-radius: 50%;
        background: rgba(255,255,255,.95);
        backdrop-filter: blur(8px);
        color: var(--clr-forest);
        cursor: pointer;
        box-shadow: 0 3px 14px rgba(0,0,0,.10);
        transition:
            transform var(--transition),
            background var(--transition),
            color var(--transition);
    }

    .favorite-button:hover {
        transform: scale(1.06);
        background: #fff;
        color: #D85A30;
    }

    /* CARD BODY */

    .service-body {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 17px 17px 16px;
    }

    .service-category {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 7px;
        color: var(--clr-sage);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .service-name {
        display: -webkit-box;
        margin: 0 0 12px;
        overflow: hidden;
        color: var(--clr-forest);
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 700;
        line-height: 1.28;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        transition: color var(--transition);
    }

    .service-name:hover {
        color: var(--clr-sage-dark);
    }

    /* PRICE */

    .price-block {
        display: flex;
        align-items: baseline;
        gap: 7px;
        flex-wrap: wrap;
        margin-bottom: 9px;
    }

    .current-price {
        color: var(--clr-forest);
        font-size: 19px;
        font-weight: 800;
        letter-spacing: -.02em;
    }

    .currency {
        color: var(--clr-muted);
        font-size: 10.5px;
        font-weight: 700;
    }

    .original-price {
        color: #9AA7A1;
        font-size: 11.5px;
        text-decoration: line-through;
    }

    /* META */

    .service-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 16px;
        color: var(--clr-muted);
        font-size: 11.5px;
    }

    .service-meta svg {
        flex-shrink: 0;
        color: var(--clr-sage);
    }

    .service-location {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .service-location-link {
        transition: color var(--transition);
    }

    .service-location-link:hover {
        color: var(--clr-sage-dark);
    }

    /* ACTIONS */

    .service-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-top: auto;
    }

    .service-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 40px;
        padding: 8px 10px;
        border-radius: 10px;
        font-size: 11.5px;
        font-weight: 800;
        transition:
            transform var(--transition),
            background var(--transition),
            color var(--transition);
    }

    .service-action:hover {
        transform: translateY(-1px);
    }

    .detail-action {
        background: var(--clr-sage-soft);
        color: var(--clr-forest);
    }

    .detail-action:hover {
        background: var(--clr-forest);
        color: #fff;
    }

    .whatsapp-action {
        background: var(--clr-success);
        color: #fff;
    }

    .whatsapp-action:hover {
        background: var(--clr-success-dark);
        color: #fff;
        box-shadow: 0 5px 15px rgba(37,211,102,.25);
    }

    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .empty-state {
        grid-column: 1 / -1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 390px;
        padding: 50px 25px;
        background: #fff;
        border: 1px dashed #CBDDD5;
        border-radius: var(--radius-xl);
        text-align: center;
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        border-radius: 20px;
        background: var(--clr-sage-soft);
        color: var(--clr-sage);
    }

    .empty-state h3 {
        margin: 0 0 7px;
        color: var(--clr-forest);
        font-family: var(--font-display);
        font-size: 23px;
    }

    .empty-state p {
        max-width: 400px;
        margin: 0;
        color: var(--clr-muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .empty-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-top: 20px;
        padding: 10px 16px;
        border-radius: 10px;
        background: var(--clr-forest);
        color: #fff !important;
        font-size: 12px;
        font-weight: 700;
    }

    /* =========================================================
       PAGINATION
    ========================================================= */

    .services-pagination {
        display: flex;
        justify-content: center;
        margin-top: 42px;
    }

    .services-pagination nav {
        display: flex;
        justify-content: center;
    }

    .services-pagination nav > div {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .services-pagination svg {
        width: 15px;
        height: 15px;
    }

    .services-pagination a,
    .services-pagination span {
        min-width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 9px;
        border: 1px solid var(--clr-border);
        border-radius: 10px;
        background: #fff;
        color: var(--clr-forest);
        font-size: 12px;
        font-weight: 700;
        transition:
            background var(--transition),
            color var(--transition),
            border-color var(--transition);
    }

    .services-pagination a:hover {
        border-color: var(--clr-sage-md, #C2D9D1);
        background: var(--clr-sage-soft);
    }

    .services-pagination span[aria-current="page"],
    .services-pagination .active span {
        border-color: var(--clr-forest);
        background: var(--clr-forest);
        color: #fff;
    }

    /* =========================================================
       MOBILE FILTER BAR
    ========================================================= */

    .mobile-filter-bar {
        display: none;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1199px) {
        .services-layout {
            grid-template-columns: 235px minmax(0, 1fr);
            gap: 25px;
        }

        .services-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 991px) {
        .svcs-container {
            width: min(100% - 30px, 760px);
        }

        .services-hero-inner {
            padding: 45px 0 65px;
        }

        .services-layout {
            display: block;
        }

        .filter-mobile-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 16px;
            padding: 13px 15px;
            border: 1px solid var(--clr-border);
            border-radius: 12px;
            background: #fff;
            color: var(--clr-forest);
            font-family: inherit;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: var(--shadow-sm);
        }

        .filter-mobile-toggle-content {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-mobile-toggle svg {
            color: var(--clr-sage);
        }

        .filter-sidebar {
            position: static;
            margin-bottom: 22px;
        }

        .filter-card {
            border-radius: 16px;
        }

        .results-toolbar {
            align-items: center;
        }
    }

    @media (max-width: 767px) {
        .svcs-container {
            width: min(100% - 24px, 620px);
        }

        .services-hero-inner {
            padding: 38px 0 58px;
        }

        .hero-breadcrumb {
            font-size: 11.5px;
        }

        .services-hero h1 {
            font-size: 38px;
        }

        .services-hero-description {
            font-size: 13.5px;
            line-height: 1.65;
        }

        .hero-search {
            grid-template-columns: 1fr;
            padding: 7px;
            border-radius: 15px;
        }

        .hero-search-button {
            width: 100%;
        }

        .services-content {
            padding: 38px 0 55px;
        }

        .results-toolbar {
            display: block;
            margin-bottom: 20px;
        }

        .results-heading {
            margin-bottom: 17px;
        }

        .results-heading h2 {
            font-size: 23px;
        }

        .sort-wrapper {
            justify-content: space-between;
        }

        .sort-select {
            flex: 1;
        }

        .services-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 13px;
        }

        .service-image {
            aspect-ratio: 1.05 / 1;
        }

        .service-body {
            padding: 13px;
        }

        .service-name {
            font-size: 15px;
            margin-bottom: 9px;
        }

        .current-price {
            font-size: 16px;
        }

        .service-meta {
            margin-bottom: 12px;
            font-size: 10.5px;
        }

        .service-actions {
            grid-template-columns: 1fr;
            gap: 6px;
        }

        .service-action {
            min-height: 36px;
            font-size: 10.5px;
        }

        .service-badge {
            padding: 5px 7px;
            font-size: 9px;
        }

        .favorite-button {
            width: 33px;
            height: 33px;
        }

        .favorite-button svg {
            width: 15px;
            height: 15px;
        }
    }

    @media (max-width: 480px) {
        .services-hero h1 {
            font-size: 33px;
        }

        .services-hero-description {
            max-width: 340px;
        }

        .services-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .service-image {
            aspect-ratio: 1.55 / 1;
        }

        .service-actions {
            grid-template-columns: 1fr 1fr;
        }

        .service-name {
            font-size: 18px;
        }

        .current-price {
            font-size: 18px;
        }
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap"
    rel="stylesheet"
>

<div class="svcs-page">

    {{-- =========================================================
         HERO
    ========================================================== --}}
    <section class="services-hero">
        <div class="svcs-container services-hero-inner">

            <div class="hero-breadcrumb">
                <a href="{{ route('home') }}">Home</a>

                <svg width="13" height="13" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m9 18 6-6-6-6"/>
                </svg>

                <span>Services</span>
            </div>

            <div class="hero-kicker">
                Professional Services Marketplace
            </div>

            <h1>Find the right service<br>for what you need.</h1>

            <p class="services-hero-description">
                Explore trusted services, compare options and connect
                directly with providers through our platform.
            </p>

        </div>
    </section>

    {{-- =========================================================
         HERO SEARCH
    ========================================================== --}}
    <div class="svcs-container">
        <div class="hero-search-wrap">

            <div class="hero-search">

                <div class="hero-search-input">

                    <svg width="19" height="19"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <circle cx="11" cy="11" r="7"/>
                        <path d="m20 20-4-4"/>
                    </svg>

                    <input
                        type="text"
                        id="serviceSearch"
                        placeholder="Search services or categories..."
                        autocomplete="off"
                    >

                </div>

                <button
                    type="button"
                    class="hero-search-button"
                    id="searchServicesButton"
                >
                    <svg width="16" height="16"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <circle cx="11" cy="11" r="7"/>
                        <path d="m20 20-4-4"/>
                    </svg>

                    Search
                </button>

            </div>

        </div>
    </div>

    {{-- =========================================================
         CONTENT
    ========================================================== --}}
    <main class="services-content">

        <div class="svcs-container">

            <div class="services-layout">

                {{-- =================================================
                     FILTER SIDEBAR
                ================================================== --}}
                <aside class="filter-sidebar">

                    <button
                        class="filter-mobile-toggle"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#filterPanel"
                        aria-expanded="false"
                    >
                        <span class="filter-mobile-toggle-content">

                            <svg width="17" height="17"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path d="M4 6h16"/>
                                <path d="M7 12h10"/>
                                <path d="M10 18h4"/>
                            </svg>

                            Browse categories

                        </span>

                        <svg width="15" height="15"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>

                    <div class="collapse d-lg-block" id="filterPanel">

                        <div class="filter-card">

                            <div class="filter-header">

                                <div class="filter-header-top">

                                    <div>
                                        <div class="filter-eyebrow">
                                            Explore
                                        </div>

                                        <h3 class="filter-title">
                                            Categories
                                        </h3>
                                    </div>

                                    <div class="filter-icon">

                                        <svg width="17" height="17"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <rect x="3" y="3" width="7" height="7" rx="1"/>
                                            <rect x="14" y="3" width="7" height="7" rx="1"/>
                                            <rect x="3" y="14" width="7" height="7" rx="1"/>
                                            <rect x="14" y="14" width="7" height="7" rx="1"/>
                                        </svg>

                                    </div>

                                </div>

                            </div>

                            <div class="category-search">

                                <svg width="14" height="14"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <circle cx="11" cy="11" r="7"/>
                                    <path d="m21 21-4.3-4.3"/>
                                </svg>

                                <input
                                    type="text"
                                    id="filterCatSearch"
                                    placeholder="Search categories..."
                                >

                            </div>

                            <ul class="category-list" id="filterCatList">

                                @foreach($scategories as $scateg)

                                    <li class="category-item">

                                        <div class="category-row">

                                            <a
                                                href="{{ route('home.service_by_category', ['category_slug' => $scateg->slug]) }}"
                                                class="category-link"
                                            >
                                                {{ $scateg->name }}
                                            </a>

                                            @if(count($scateg->subcategories) > 0)

                                                <button
                                                    type="button"
                                                    class="category-toggle"
                                                    aria-label="Show subcategories"
                                                >
                                                    <svg width="14" height="14"
                                                         viewBox="0 0 24 24"
                                                         fill="none"
                                                         stroke="currentColor"
                                                         stroke-width="2.3">
                                                        <path d="m9 6 6 6-6 6"/>
                                                    </svg>
                                                </button>

                                            @endif

                                        </div>

                                        @if(count($scateg->subcategories) > 0)

                                            <ul class="subcategory-list">

                                                @foreach($scateg->subcategories as $scat)

                                                    <li>
                                                        <a
                                                            href="{{ route('home.service_by_subcategory', ['subcategory_slug' => $scat->slug]) }}"
                                                        >
                                                            {{ $scat->name }}
                                                        </a>
                                                    </li>

                                                @endforeach

                                            </ul>

                                        @endif

                                    </li>

                                @endforeach

                            </ul>

                            <div class="filter-footer">

                                <a
                                    href="{{ route('home.services') }}"
                                    class="all-services-btn"
                                >
                                    View all services

                                    <svg width="14" height="14"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path d="M5 12h14"/>
                                        <path d="m13 6 6 6-6 6"/>
                                    </svg>

                                </a>

                            </div>

                        </div>

                    </div>

                </aside>

                {{-- =================================================
                     RESULTS
                ================================================== --}}
                <section class="results-area">

                    <div class="results-toolbar">

                        <div class="results-heading">

                            <small>
                                Discover services
                            </small>

                            <h2>
                                {{ $services->total() }}
                                <span>
                                    service{{ $services->total() == 1 ? '' : 's' }}
                                </span>
                            </h2>

                        </div>

                        <div class="sort-wrapper">

                            <label
                                for="sortby"
                                class="sort-label"
                            >
                                Sort by
                            </label>

                            <select
                                name="sortby"
                                id="sortby"
                                class="sort-select"
                            >
                                <option value="popularity">
                                    Most Popular
                                </option>

                                <option value="rating">
                                    Highest Rated
                                </option>

                                <option value="date">
                                    Newest
                                </option>
                            </select>

                        </div>

                    </div>

                    {{-- =================================================
                         SERVICE GRID
                    ================================================== --}}
                    <div
                        class="services-grid"
                        id="servicesGrid"
                    >

                        @forelse($services as $service)

                            @php

                                $total = $service->price;

                                if ($service->discount) {

                                    if ($service->discount_type == 'fixed') {

                                        $total = $total - $service->discount;

                                    } elseif ($service->discount_type == 'percent') {

                                        $total = $total -
                                            ($total * $service->discount / 100);

                                    }

                                }

                                $waRawPhone = optional($service->sprovider ?? null)->phone
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

                            <article
                                class="service-card"
                                data-service-name="{{ strtolower($service->name) }}"
                                data-service-category="{{ strtolower($service->category->name ?? '') }}"
                                data-service-location="{{ strtolower($service->location ?? '') }}"
                            >

                                {{-- IMAGE --}}
                                <div class="service-image">

                                    <a
                                        href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}"
                                    >

                                        <img
                                            src="{{ asset('image/services/' . ($service->image ?? 'default.png')) }}"
                                            alt="{{ $service->name }}"
                                            loading="lazy"
                                        >

                                    </a>

                                    <div class="image-overlay"></div>

                                    {{-- BADGES --}}
                                    <div class="service-top-badges">

                                        <div class="service-badges-left">

                                            @if($service->discount)

                                                <span class="service-badge discount">

                                                    <svg width="11" height="11"
                                                         viewBox="0 0 24 24"
                                                         fill="none"
                                                         stroke="currentColor"
                                                         stroke-width="2">
                                                        <path d="m20 12-8 8-8-8V4h8z"/>
                                                        <circle cx="8" cy="8" r="1"/>
                                                    </svg>

                                                    @if($service->discount_type == 'fixed')
                                                        Save {{ number_format($service->discount) }} RWF
                                                    @else
                                                        Save {{ $service->discount }}%
                                                    @endif

                                                </span>

                                            @endif

                                            @if($service->duration)

                                                <span class="service-badge duration">

                                                    <svg width="11" height="11"
                                                         viewBox="0 0 24 24"
                                                         fill="none"
                                                         stroke="currentColor"
                                                         stroke-width="2">
                                                        <circle cx="12" cy="12" r="9"/>
                                                        <path d="M12 7v5l3 2"/>
                                                    </svg>

                                                    {{ $service->duration }}

                                                </span>

                                            @endif

                                        </div>

                                        <button
                                            type="button"
                                            class="favorite-button"
                                            aria-label="Save service"
                                        >
                                            <svg width="17" height="17"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="1.8">
                                                <path d="M20.8 8.7c0 5.5-8.8 11-8.8 11S3.2 14.2 3.2 8.7A4.7 4.7 0 0 1 12 6.3a4.7 4.7 0 0 1 8.8 2.4z"/>
                                            </svg>
                                        </button>

                                    </div>

                                </div>

                                {{-- BODY --}}
                                <div class="service-body">

                                    <div class="service-category">

                                        <svg width="11" height="11"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <path d="M20 13.5V6a2 2 0 0 0-2-2h-7.5L4 10.5a2 2 0 0 0 0 3L10.5 20a2 2 0 0 0 3 0z"/>
                                            <circle cx="14.5" cy="8.5" r="1"/>
                                        </svg>

                                        {{ $service->category->name }}

                                    </div>

                                    <a
                                        href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}"
                                        class="service-name"
                                    >
                                        {{ $service->name }}
                                    </a>

                                    {{-- PRICE --}}
                                    <div class="price-block">

                                        <span class="current-price">
                                            {{ number_format($total) }}
                                        </span>

                                        <span class="currency">
                                            RWF
                                        </span>

                                        @if($service->discount)

                                            <span class="original-price">
                                                {{ number_format($service->price) }}
                                            </span>

                                        @endif

                                    </div>

                                    {{-- LOCATION --}}
                                    <div class="service-meta">

                                        <svg width="13" height="13"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>

                                        <a
                                            href="{{ route('home.service_location', ['service_location' => $service->location]) }}"
                                            class="service-location service-location-link"
                                        >
                                            {{ $service->location }}
                                        </a>

                                    </div>

                                    {{-- ACTIONS --}}
                                    <div class="service-actions">

                                        <a
                                            href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}"
                                            class="service-action detail-action"
                                        >
                                            View details

                                            <svg width="13" height="13"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="2">
                                                <path d="M5 12h14"/>
                                                <path d="m13 6 6 6-6 6"/>
                                            </svg>

                                        </a>

                                        <a
                                            href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="service-action whatsapp-action"
                                        >

                                            <svg width="14" height="14"
                                                 viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 0 0 4.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm5.8 14.1c-.24.68-1.4 1.3-1.93 1.38-.5.08-1.12.11-1.8-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.13-4.9-4.32-.14-.19-1.17-1.55-1.17-2.96 0-1.4.73-2.09 1-2.38.26-.28.57-.35.76-.35h.55c.18 0 .42-.07.65.5.24.58.82 2 .89 2.15.07.15.12.32.02.51-.09.19-.14.31-.28.48-.14.16-.29.36-.42.49-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.28.36-.23.6-.14.24.09 1.55.73 1.82.86.27.14.44.2.51.32.07.12.07.68-.17 1.36z"/>
                                            </svg>

                                            WhatsApp

                                        </a>

                                    </div>

                                </div>

                            </article>

                        @empty

                            <div class="empty-state">

                                <div class="empty-icon">

                                    <svg width="28" height="28"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <circle cx="11" cy="11" r="7"/>
                                        <path d="m21 21-4.3-4.3"/>
                                    </svg>

                                </div>

                                <h3>
                                    No services found
                                </h3>

                                <p>
                                    We couldn't find services matching your
                                    current selection. Try another category
                                    or browse all available services.
                                </p>

                                <a
                                    href="{{ route('home.services') }}"
                                    class="empty-link"
                                >
                                    Browse all services

                                    <svg width="14" height="14"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path d="M5 12h14"/>
                                        <path d="m13 6 6 6-6 6"/>
                                    </svg>

                                </a>

                            </div>

                        @endforelse

                    </div>

                    {{-- PAGINATION --}}
                    @if($services->hasPages())

                        <div class="services-pagination">
                            {{ $services->links() }}
                        </div>

                    @endif

                </section>

            </div>

        </div>

    </main>

    {{-- CTA --}}
    @include('includes.call-to-action')

</div>

<script>
(function () {

    /* =========================================================
       CATEGORY TOGGLES
    ========================================================== */

    document.querySelectorAll('.category-toggle').forEach(function (button) {

        button.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            const item = button.closest('.category-item');

            if (item) {
                item.classList.toggle('open');
            }

        });

    });


    /* =========================================================
       CATEGORY SEARCH
    ========================================================== */

    const categorySearch =
        document.getElementById('filterCatSearch');

    if (categorySearch) {

        categorySearch.addEventListener('input', function () {

            const term =
                this.value.trim().toLowerCase();

            document
                .querySelectorAll('#filterCatList > .category-item')
                .forEach(function (item) {

                    const categoryLink =
                        item.querySelector('.category-link');

                    if (!categoryLink) {
                        return;
                    }

                    const categoryName =
                        categoryLink.textContent
                            .trim()
                            .toLowerCase();

                    const subcategories =
                        Array.from(
                            item.querySelectorAll(
                                '.subcategory-list a'
                            )
                        )
                        .map(function (link) {
                            return link.textContent
                                .trim()
                                .toLowerCase();
                        })
                        .join(' ');

                    const matches =
                        categoryName.includes(term) ||
                        subcategories.includes(term);

                    item.style.display =
                        matches ? '' : 'none';

                    if (
                        term &&
                        matches &&
                        subcategories.includes(term)
                    ) {
                        item.classList.add('open');
                    }

                });

        });

    }


    /* =========================================================
       SERVICE SEARCH
    ========================================================== */

    const serviceSearch =
        document.getElementById('serviceSearch');

    const searchButton =
        document.getElementById('searchServicesButton');

    const serviceCards =
        Array.from(
            document.querySelectorAll('.service-card')
        );

    function performServiceSearch() {

        if (!serviceSearch) {
            return;
        }

        const term =
            serviceSearch.value
                .trim()
                .toLowerCase();

        let visibleCount = 0;

        serviceCards.forEach(function (card) {

            const name =
                card.dataset.serviceName || '';

            const category =
                card.dataset.serviceCategory || '';

            const location =
                card.dataset.serviceLocation || '';

            const matches =
                !term ||
                name.includes(term) ||
                category.includes(term) ||
                location.includes(term);

            card.style.display =
                matches ? '' : 'none';

            if (matches) {
                visibleCount++;
            }

        });

    }

    if (serviceSearch) {

        serviceSearch.addEventListener(
            'input',
            performServiceSearch
        );

        serviceSearch.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Enter') {
                    event.preventDefault();
                    performServiceSearch();
                }

            }
        );

    }

    if (searchButton) {

        searchButton.addEventListener(
            'click',
            performServiceSearch
        );

    }


    /* =========================================================
       FAVORITE BUTTON VISUAL STATE
    ========================================================== */

    document
        .querySelectorAll('.favorite-button')
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();
                    event.stopPropagation();

                    const svg =
                        button.querySelector('svg');

                    const active =
                        button.classList.toggle('is-favorite');

                    if (active) {

                        button.style.color = '#D85A30';

                        if (svg) {
                            svg.setAttribute(
                                'fill',
                                'currentColor'
                            );
                        }

                    } else {

                        button.style.color = '';

                        if (svg) {
                            svg.setAttribute(
                                'fill',
                                'none'
                            );
                        }

                    }

                }
            );

        });

})();
</script>

@endsection