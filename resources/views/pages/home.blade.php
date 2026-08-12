@extends('layouts.base')
@section('title','Home')
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
        --clr-gold: #C99A3B;
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-lg: 22px;
        --radius-xl: 32px;
        --shadow-card: 0 2px 16px rgba(37, 64, 53, .07);
        --shadow-hover: 0 8px 32px rgba(37, 64, 53, .13);
        --shadow-deep: 0 24px 60px rgba(37, 64, 53, .22);
        --font-display: 'Playfair Display', Georgia, serif;
        --font-body: 'DM Sans', sans-serif;
        --transition: .22s cubic-bezier(.4, 0, .2, 1);
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: var(--font-body);
        color: var(--clr-text);
        background: var(--clr-white);
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    img {
        display: block;
        max-width: 100%;
    }

    button, input, select {
        font-family: inherit;
    }

    /* ─── TYPOGRAPHY ─── */
    .section-tag {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--clr-sage);
        background: var(--clr-sage-lt);
        padding: 5px 14px;
        border-radius: 100px;
        margin-bottom: 14px;
    }

    .section-title {
        font-family: var(--font-display);
        font-size: clamp(26px, 4vw, 40px);
        font-weight: 700;
        color: var(--clr-forest);
        line-height: 1.22;
    }

    .section-lead {
        font-size: 16px;
        color: var(--clr-muted);
        line-height: 1.7;
        max-width: 540px;
    }

    /* ─── HERO (redesigned) ─── */
    .hero {
        position: relative;
        padding-top: 64px;
        background:
            radial-gradient(circle at 85% 15%, rgba(107, 144, 128, .10) 0%, transparent 55%),
            linear-gradient(180deg, var(--clr-bg-soft) 0%, #ffffff 78%);
        overflow: hidden;
    }

    .hero-inner {
        max-width: 1240px;
        margin: 0 auto;
        padding: 44px 24px 72px;
        display: grid;
        grid-template-columns: 1fr;
        gap: 48px;
        align-items: center;
    }

    @media(min-width:992px) {
        .hero-inner {
            grid-template-columns: 1.02fr .98fr;
            gap: 56px;
            padding: 64px 24px 96px;
        }
    }

    .hero-content .section-tag {
        background: var(--clr-white);
        border: 1px solid var(--clr-sage-md);
        box-shadow: var(--shadow-card);
    }

    .hero-content h1 {
        font-family: var(--font-display);
        font-size: clamp(34px, 4.6vw, 56px);
        font-weight: 700;
        color: var(--clr-forest);
        line-height: 1.14;
        max-width: 620px;
        margin-bottom: 18px;
    }

    .hero-content h1 em {
        font-style: normal;
        color: var(--clr-sage);
        position: relative;
    }

    .hero-content p.lead {
        font-size: 16.5px;
        color: var(--clr-muted);
        line-height: 1.7;
        max-width: 470px;
        margin-bottom: 32px;
    }

    /* search bar */
    .hero-search {
        display: flex;
        align-items: stretch;
        gap: 6px;
        background: var(--clr-white);
        border: 1px solid var(--clr-border);
        border-radius: 100px;
        padding: 6px;
        box-shadow: var(--shadow-card);
        max-width: 540px;
        transition: box-shadow var(--transition);
    }

    .hero-search:focus-within {
        box-shadow: var(--shadow-hover);
    }

    .hero-search .field {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 16px;
        flex: 1;
        min-width: 0;
    }

    .hero-search .field svg {
        flex-shrink: 0;
        color: var(--clr-sage);
    }

    .hero-search input,
    .hero-search select {
        border: none;
        outline: none;
        background: transparent;
        font-size: 14px;
        color: var(--clr-text);
        width: 100%;
        padding: 12px 0;
    }

    .hero-search input::placeholder {
        color: #9AAFA6;
    }

    .hero-search .divider {
        width: 1px;
        background: var(--clr-border);
        margin: 8px 0;
        flex-shrink: 0;
    }

    .hero-search button {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: var(--clr-forest);
        color: #fff;
        border: none;
        border-radius: 100px;
        padding: 0 26px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background var(--transition);
    }

    .hero-search button:hover {
        background: var(--clr-forest-lt);
    }

    /* trust stats */
    .hero-trust {
        display: flex;
        gap: 36px;
        flex-wrap: wrap;
        margin-top: 38px;
    }

    .hero-trust .item {
        display: flex;
        flex-direction: column;
    }

    .hero-trust .count {
        font-family: var(--font-display);
        font-size: 28px;
        font-weight: 700;
        color: var(--clr-forest);
        line-height: 1;
    }

    .hero-trust .label {
        font-size: 12.5px;
        color: var(--clr-muted);
        margin-top: 6px;
        letter-spacing: .01em;
    }

    /* visual side */
    .hero-visual {
        position: relative;
    }

    .hero-visual .carousel {
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-deep);
        aspect-ratio: 4 / 4.6;
    }

    @media(min-width:992px) {
        .hero-visual .carousel {
            aspect-ratio: 4 / 4.9;
        }
    }

    .hero-visual .carousel-item,
    .hero-visual .carousel-item img {
        height: 100%;
    }

    .hero-visual .carousel-item img {
        width: 100%;
        object-fit: cover;
    }

    .hero-visual .carousel-item::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(0deg, rgba(37, 64, 53, .55) 0%, transparent 42%);
        pointer-events: none;
    }

    .hero-slide-title {
        position: absolute;
        left: 28px;
        right: 28px;
        bottom: 28px;
        z-index: 3;
        color: #fff;
        font-family: var(--font-display);
        font-size: 20px;
        font-weight: 700;
        line-height: 1.3;
    }

    .hero-visual .carousel-control-prev,
    .hero-visual .carousel-control-next {
        width: 42px;
        height: 42px;
        background: rgba(255, 255, 255, .2);
        backdrop-filter: blur(6px);
        border-radius: 50%;
        top: auto;
        bottom: 28px;
        opacity: 1;
        transition: background var(--transition);
    }

    .hero-visual .carousel-control-prev {
        left: auto;
        right: 84px;
    }

    .hero-visual .carousel-control-next {
        right: 28px;
    }

    .hero-visual .carousel-control-prev:hover,
    .hero-visual .carousel-control-next:hover {
        background: rgba(255, 255, 255, .35);
    }

    .hero-visual .carousel-control-prev-icon,
    .hero-visual .carousel-control-next-icon {
        width: 16px;
        height: 16px;
    }

    .hero-visual .carousel-indicators {
        display: none;
    }

    /* floating verified badge */
    .hero-badge {
        position: absolute;
        left: -18px;
        bottom: 40px;
        z-index: 5;
        background: var(--clr-white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-hover);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        max-width: 230px;
    }

    @media(max-width:560px) {
        .hero-badge {
            left: 16px;
            bottom: 16px;
        }
    }

    .hero-badge .avatar-stack {
        display: flex;
    }

    .hero-badge .avatar-stack .dot {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 2px solid #fff;
        background: var(--clr-sage-md);
        margin-left: -10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--clr-forest);
    }

    .hero-badge .avatar-stack .dot:first-child {
        margin-left: 0;
    }

    .hero-badge .text .top {
        font-size: 13px;
        font-weight: 700;
        color: var(--clr-forest);
    }

    .hero-badge .text .sub {
        font-size: 11.5px;
        color: var(--clr-muted);
    }

    /* ─── CATEGORY MENU ─── */
    .cat-menu {
        background: var(--clr-white);
        border-bottom: 1px solid var(--clr-border);
        position: sticky;
        top: 0;
        z-index: 100;
        display: none;
    }

    @media(min-width:992px) {
        .cat-menu {
            display: block;
        }
    }

    .cat-menu ul {
        list-style: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 0 24px;
        max-width: 1200px;
        margin: 0 auto;
        flex-wrap: wrap;
    }

    .cat-menu ul li a {
        display: block;
        padding: 14px 18px;
        font-size: 13.5px;
        font-weight: 500;
        color: var(--clr-muted);
        border-bottom: 2px solid transparent;
        transition: color var(--transition), border-color var(--transition);
    }

    .cat-menu ul li a:hover {
        color: var(--clr-forest);
        border-color: var(--clr-sage);
    }

    .cat-menu .dropdown-menu {
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-hover);
        padding: 8px;
    }

    .cat-menu .dropdown-item {
        border-radius: var(--radius-sm);
        font-size: 14px;
        color: var(--clr-text);
        padding: 9px 14px;
    }

    .cat-menu .dropdown-item:hover {
        background: var(--clr-sage-lt);
        color: var(--clr-forest);
    }

    /* ─── SECTION WRAPPER ─── */
    .section-wrap {
        padding: 80px 0;
    }

    .section-wrap-alt {
        background: var(--clr-bg-soft);
        padding: 80px 0;
    }

    .container-lg {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* ─── CATEGORY CARDS ─── */
    .cat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 16px;
        margin-top: 40px;
    }

    .cat-card {
        background: var(--clr-white);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-md);
        padding: 28px 16px 22px;
        text-align: center;
        transition: box-shadow var(--transition), transform var(--transition), border-color var(--transition);
        cursor: pointer;
    }

    .cat-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-4px);
        border-color: var(--clr-sage-md);
    }

    .cat-card .icon-wrap {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--clr-sage-lt);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px;
        transition: background var(--transition);
    }

    .cat-card:hover .icon-wrap {
        background: var(--clr-sage-md);
    }

    .cat-card .icon-wrap img {
        width: 34px;
        height: 34px;
        object-fit: contain;
    }

    .cat-card .title {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--clr-forest);
    }

    .section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 8px;
    }

    .btn-outline-sage {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 13.5px;
        font-weight: 600;
        color: var(--clr-forest);
        border: 1.5px solid var(--clr-sage-md);
        padding: 9px 22px;
        border-radius: 100px;
        transition: background var(--transition), color var(--transition), border-color var(--transition);
    }

    .btn-outline-sage:hover {
        background: var(--clr-sage);
        color: #fff;
        border-color: var(--clr-sage);
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

    /* ─── SERVICE CARDS ─── */
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
        margin-top: 40px;
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
        height: 200px;
        object-fit: cover;
        transition: transform .5s ease;
    }

    .service-card:hover .thumb img {
        transform: scale(1.05);
    }

    .service-card .duration-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(37, 64, 53, .82);
        backdrop-filter: blur(4px);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 100px;
    }

    .service-card .body {
        padding: 20px 22px 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .service-card .cat-label {
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--clr-sage);
        margin-bottom: 6px;
    }

    .service-card .svc-name {
        font-family: var(--font-display);
        font-size: 17px;
        font-weight: 700;
        color: var(--clr-forest);
        margin-bottom: 14px;
        line-height: 1.3;
    }

    .service-card .price-row {
        display: flex;
        align-items: baseline;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 4px;
    }

    .service-card .price-orig {
        font-size: 13px;
        color: var(--clr-muted);
        text-decoration: line-through;
    }

    .service-card .price-total {
        font-size: 20px;
        font-weight: 700;
        color: var(--clr-forest);
    }

    .service-card .price-cur {
        font-size: 13px;
        color: var(--clr-muted);
    }

    .service-card .discount-pill {
        font-size: 11.5px;
        font-weight: 700;
        color: #fff;
        background: #D85A30;
        padding: 3px 10px;
        border-radius: 100px;
    }

    .service-card .location-row {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        color: var(--clr-muted);
        margin-top: 6px;
        margin-bottom: 18px;
    }

    .service-card .location-row a {
        color: var(--clr-sage);
        font-weight: 500;
    }

    /* two-button action row: View Details + WhatsApp */
    .service-card .card-actions,
    .provider-card .card-actions,
    .promo-card .card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-top: auto;
    }

    .btn-view-detail {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: var(--clr-sage-lt);
        color: var(--clr-forest);
        font-size: 13.5px;
        font-weight: 700;
        padding: 12px 10px;
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
        gap: 6px;
        background: var(--clr-whatsapp);
        color: #fff;
        font-size: 13.5px;
        font-weight: 700;
        padding: 12px 10px;
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

    /* ─── SORT BAR ─── */
    .sort-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 8px;
    }

    .sort-bar select {
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

    .sort-bar select:focus {
        border-color: var(--clr-sage);
    }

    /* ─── PROVIDER CARDS ─── */
    .providers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        margin-top: 40px;
    }

    .provider-card {
        background: var(--clr-white);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        text-align: center;
        transition: box-shadow var(--transition), transform var(--transition);
        position: relative;
    }

    .provider-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-5px);
    }

    .provider-card .fav-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 34px;
        height: 34px;
        background: rgba(255, 255, 255, .9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--clr-muted);
        font-size: 16px;
        transition: color var(--transition), background var(--transition);
        z-index: 2;
    }

    .provider-card .fav-btn:hover {
        color: #D85A30;
    }

    .provider-card .thumb img {
        width: 100%;
        height: 190px;
        object-fit: cover;
        transition: transform .5s ease;
    }

    .provider-card:hover .thumb img {
        transform: scale(1.04);
    }

    .provider-card .body {
        padding: 20px 20px 22px;
    }

    .provider-card h4 {
        font-family: var(--font-display);
        font-size: 17px;
        font-weight: 700;
        color: var(--clr-forest);
        margin-bottom: 4px;
    }

    .provider-card .post {
        font-size: 13px;
        color: var(--clr-sage);
        font-weight: 600;
        margin-bottom: 14px;
    }

    .provider-card .meta-row {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 16px;
    }

    .provider-card .meta-item {
        text-align: center;
    }

    .provider-card .meta-item span {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--clr-muted);
        margin-bottom: 2px;
    }

    .provider-card .meta-item div {
        font-size: 14px;
        font-weight: 600;
        color: var(--clr-forest);
    }

    .provider-card .card-actions a {
        padding: 10px;
        border-radius: var(--radius-sm);
        font-size: 13.5px;
        font-weight: 600;
        text-align: center;
        transition: background var(--transition), color var(--transition);
    }

    .provider-card .btn-view {
        background: var(--clr-sage-lt);
        color: var(--clr-forest);
    }

    .provider-card .btn-view:hover {
        background: var(--clr-forest);
        color: #fff;
    }

    .provider-card .btn-msg {
        background: var(--clr-whatsapp);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .provider-card .btn-msg:hover {
        background: var(--clr-whatsapp-dark);
    }

    /* ─── PROMOTION CARDS ─── */
    .promos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 24px;
        margin-top: 40px;
    }

    .promo-card {
        background: var(--clr-white);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        text-align: center;
        transition: box-shadow var(--transition), transform var(--transition);
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .promo-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-4px);
    }

    .promo-card .discount-ribbon {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #D85A30;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        padding: 5px 14px;
        border-radius: 100px;
        z-index: 2;
    }

    .promo-card .thumb img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .promo-card .body {
        padding: 18px 20px 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .promo-card h4 {
        font-family: var(--font-display);
        font-size: 16px;
        font-weight: 700;
        color: var(--clr-forest);
        margin-bottom: 6px;
    }

    .promo-card .desc {
        font-size: 13px;
        color: var(--clr-muted);
        line-height: 1.5;
        margin-bottom: 14px;
    }

    .promo-card .promo-meta {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 14px;
        padding: 12px;
        background: var(--clr-bg-soft);
        border-radius: var(--radius-sm);
    }

    .promo-card .promo-meta .m-label {
        font-size: 11px;
        color: var(--clr-muted);
        margin-bottom: 2px;
    }

    .promo-card .promo-meta .m-val {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--clr-forest);
    }

    .promo-card .promo-meta .m-end {
        color: #D85A30;
    }

    .promo-card .card-actions a {
        padding: 10px;
        border-radius: var(--radius-sm);
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        transition: background var(--transition), color var(--transition);
    }

    .promo-card .btn-view {
        background: var(--clr-sage-lt);
        color: var(--clr-forest);
    }

    .promo-card .btn-view:hover {
        background: var(--clr-forest);
        color: #fff;
    }

    /* ─── HOW IT WORKS ─── */
    .how-banner {
        background: var(--clr-forest);
        border-radius: var(--radius-lg);
        padding: 60px 48px;
        position: relative;
        overflow: hidden;
    }

    .how-banner::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        background: rgba(107, 144, 128, .18);
    }

    .how-banner::after {
        content: '';
        position: absolute;
        bottom: -60px;
        left: -60px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(107, 144, 128, .12);
    }

    .how-banner h2 {
        font-family: var(--font-display);
        font-size: clamp(28px, 4vw, 42px);
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
        position: relative;
        z-index: 2;
    }

    .how-banner h2 span {
        color: var(--clr-sage-md);
    }

    .how-banner p {
        color: rgba(255, 255, 255, .7);
        font-size: 16px;
        margin-bottom: 40px;
        position: relative;
        z-index: 2;
    }

    .how-steps {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 24px;
        position: relative;
        z-index: 2;
    }

    .how-step {
        display: flex;
        gap: 16px;
        align-items: flex-start;
    }

    .how-step .num {
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .12);
        border: 1.5px solid rgba(255, 255, 255, .25);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        color: #fff;
    }

    .how-step .info .label {
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        margin-bottom: 4px;
    }

    .how-step .info a {
        font-size: 13px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--clr-sage-md);
        transition: color var(--transition);
    }

    .how-step .info a:hover {
        color: #fff;
    }

    /* ─── CTA STRIP ─── */
    .cta-strip {
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-lg);
        padding: 36px 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
        background: var(--clr-white);
    }

    .cta-strip h2 {
        font-family: var(--font-display);
        font-size: clamp(20px, 3vw, 30px);
        color: var(--clr-forest);
        font-weight: 700;
        margin-bottom: 4px;
    }

    .cta-strip p {
        font-size: 15px;
        color: var(--clr-muted);
    }

    .cta-strip .actions {
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

    /* ─── BLOG ─── */
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 28px;
        margin-top: 40px;
    }

    .blog-card {
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--clr-border);
        background: var(--clr-white);
        transition: box-shadow var(--transition), transform var(--transition);
        display: flex;
        flex-direction: column;
    }

    .blog-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-5px);
    }

    .blog-card .thumb {
        position: relative;
        overflow: hidden;
    }

    .blog-card .thumb img {
        width: 100%;
        height: 210px;
        object-fit: cover;
        transition: transform .5s ease;
    }

    .blog-card:hover .thumb img {
        transform: scale(1.05);
    }

    .blog-card .tag-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: var(--clr-forest);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 100px;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .blog-card .body {
        padding: 20px 22px 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .blog-card .author-row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--clr-muted);
        margin-bottom: 10px;
    }

    .blog-card .author-row a {
        color: var(--clr-sage);
        font-weight: 600;
    }

    .blog-card h4 {
        font-family: var(--font-display);
        font-size: 17px;
        font-weight: 700;
        color: var(--clr-forest);
        line-height: 1.3;
        margin-bottom: 16px;
        flex: 1;
    }

    .blog-card .read-more {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13.5px;
        font-weight: 700;
        color: var(--clr-sage);
        transition: color var(--transition), gap var(--transition);
    }

    .blog-card .read-more:hover {
        color: var(--clr-forest);
        gap: 10px;
    }

    /* ─── FEEDBACK ─── */
    .feedback-section {
        background: var(--clr-bg-soft);
        padding: 80px 0;
    }

    .feedback-slider {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
        margin-top: 40px;
    }

    .feedback-card {
        background: var(--clr-white);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-lg);
        padding: 30px 28px;
    }

    .feedback-card .quote {
        font-size: 15px;
        color: var(--clr-text);
        line-height: 1.7;
        font-style: italic;
        margin-bottom: 22px;
        border-left: 3px solid var(--clr-sage-md);
        padding-left: 16px;
    }

    .feedback-card .reviewer {
        font-weight: 700;
        color: var(--clr-forest);
        font-size: 15px;
    }

    .feedback-card .stars {
        display: flex;
        gap: 3px;
        color: #F4A027;
        font-size: 14px;
        margin-top: 10px;
    }

    .feedback-card .rating-label {
        font-size: 13px;
        color: var(--clr-muted);
        margin-top: 6px;
    }

    /* ─── PARTNERS ─── */
    .partners-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 32px;
        padding: 60px 24px;
    }

    .partners-row img {
        height: 36px;
        object-fit: contain;
        opacity: .55;
        filter: grayscale(1);
        transition: opacity var(--transition), filter var(--transition);
    }

    .partners-row img:hover {
        opacity: 1;
        filter: none;
    }

    /* ─── RESPONSIVE ─── */
    @media(max-width:768px) {

        .services-grid,
        .providers-grid,
        .promos-grid,
        .blog-grid {
            grid-template-columns: 1fr;
        }

        .how-banner {
            padding: 36px 24px;
        }

        .cta-strip {
            flex-direction: column;
            align-items: flex-start;
        }

        .how-steps {
            grid-template-columns: 1fr;
        }

        .hero-search {
            flex-wrap: wrap;
            border-radius: var(--radius-lg);
        }

        .hero-search .divider {
            display: none;
        }

        .hero-search button {
            width: 100%;
            padding: 12px;
            margin-top: 4px;
        }
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- ── HERO ─────────────────────────────────── -->
<div class="hero">
    <div class="hero-inner">
        <div class="hero-content">
            <span class="section-tag">Trusted marketplace</span>
            <h1>Find skilled help for <em>anything</em> you need done.</h1>
            <p class="lead">Connect with vetted, top-rated service providers near you — browse, compare and book in minutes, with real people ready to help.</p>

            <form class="hero-search" action="{{ route('home.services') }}" method="GET">
                <div class="field">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7" /><path d="m21 21-4.3-4.3" /></svg>
                    <input type="text" name="q" placeholder="What service are you looking for?">
                </div>
                <div class="divider"></div>
                <div class="field" style="flex:.7;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z" /><circle cx="12" cy="10" r="3" /></svg>
                    <select name="category">
                        <option value="">Any category</option>
                        @foreach($scategories ?? [] as $scategory)
                        <option value="{{ $scategory->slug }}">{{ $scategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit">Search</button>
            </form>

            <div class="hero-trust">
                <div class="item">
                    <div class="count"><span class="counter">{{ $totalSales }}</span>+</div>
                    <div class="label">Total Sales</div>
                </div>
                <div class="item">
                    <div class="count"><span class="counter">{{ $totalSprovider }}</span>+</div>
                    <div class="label">Service Providers</div>
                </div>
                <div class="item">
                    <div class="count"><span class="counter">{{ $totalDone }}</span>+</div>
                    <div class="label">Services Done</div>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($sliders as $index => $slider)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ asset('image/slider') }}/{{ $slider->image }}" alt="Slide {{ $index + 1 }}">
                        <div class="hero-slide-title">{{ $slider->title }}</div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="hero-badge">
                <div class="avatar-stack">
                    <div class="dot">✓</div>
                </div>
                <div class="text">
                    <div class="top">Verified providers</div>
                    <div class="sub">Every profile is manually reviewed</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── CATEGORIES ─────────────────────────────────── -->
<section class="section-wrap">
    <div class="container-lg">
        <div class="section-header">
            <div>
                <span class="section-tag">Explore</span>
                <h2 class="section-title">Most demanding<br>Service categories</h2>
            </div>
            <a href="{{ route('home.service_categories') }}" class="btn-outline-sage">All Categories &rarr;</a>
        </div>
        <div class="cat-grid">
            @foreach($scategories as $scategory)
            <a href="{{ route('home.service_by_category', ['category_slug' => $scategory->slug]) }}" class="cat-card">
                <div class="icon-wrap">
                    <img src="{{ asset('image/categories') }}/{{ $scategory->image }}" alt="{{ $scategory->name }}">
                </div>
                <div class="title">{{ $scategory->name }}</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ── SERVICES ─────────────────────────────────── -->
<section class="section-wrap-alt">
    <div class="container-lg">
        <div class="sort-bar">
            <div>
                <span class="section-tag">Browse</span>
                <h2 class="section-title">Services for you</h2>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:13.5px;color:var(--clr-muted);font-weight:500;">Sort:</span>
                <select name="sortby" id="sortby">
                    <option value="popularity">Most Popular</option>
                    <option value="rating">Most Rated</option>
                    <option value="date">Date</option>
                </select>
            </div>
        </div>
        <div class="services-grid">
            @foreach($services as $service)
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
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        <a href="{{ route('home.service_location', ['service_location' => $service->location]) }}">{{ $service->location }}</a>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}" class="btn-view-detail">View Detail</a>
                        <a href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}" target="_blank" rel="noopener" class="btn-whatsapp">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 004.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2zm5.8 14.1c-.24.68-1.4 1.3-1.93 1.38-.5.08-1.12.11-1.8-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.13-4.9-4.32-.14-.19-1.17-1.55-1.17-2.96 0-1.4.73-2.09 1-2.38.26-.28.57-.35.76-.35h.55c.18 0 .42-.07.65.5.24.58.82 2 .89 2.15.07.15.12.32.02.51-.09.19-.14.31-.28.48-.14.16-.29.36-.42.49-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.28.36-.23.6-.14.24.09 1.55.73 1.82.86.27.14.44.2.51.32.07.12.07.68-.17 1.36z"/></svg>
                            WhatsApp
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ── SERVICE PROVIDERS ─────────────────────────────────── -->
<section class="section-wrap">
    <div class="container-lg">
        <div class="section-header">
            <div>
                <span class="section-tag">Talent</span>
                <h2 class="section-title">Service providers<br>for you</h2>
            </div>
        </div>
        <div class="providers-grid">
            @foreach($sproviders as $sprovider)
            @if(!empty($sprovider->sprovider_name))
            @php
                $provWaPhone = preg_replace('/\D+/', '', $sprovider->phone ?? config('services.whatsapp.default_number', '250780000000'));
                $provWaMessage = rawurlencode('Hello ' . $sprovider->sprovider_name . ', I found your profile and would like to get in touch.');
            @endphp
            <div class="provider-card">
                <a href="{{ route('home.service-provider_profile', ['sprovider_id' => $sprovider->id]) }}" class="fav-btn">&#9825;</a>
                <div class="thumb">
                    <a href="{{ route('home.service-provider_profile', ['sprovider_id' => $sprovider->id]) }}">
                        <img src="{{ asset('image/profile') }}/{{ $sprovider->image }}" alt="{{ $sprovider->sprovider_name }}">
                    </a>
                </div>
                <div class="body">
                    <h4>{{ $sprovider->sprovider_name }}</h4>
                    <div class="post">@if($sprovider->service_category_id){{ $sprovider->category->name }}@endif</div>
                    <div class="meta-row">
                        <div class="meta-item">
                            <span>Category</span>
                            <div>@if($sprovider->service_category_id){{ $sprovider->category->name }}@else&mdash;@endif</div>
                        </div>
                        <div class="meta-item">
                            <span>Location</span>
                            <div>{{ $sprovider->city }}</div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('home.service-provider_profile', ['sprovider_id' => $sprovider->id]) }}" class="btn-view">View Profile</a>
                        <a href="https://wa.me/{{ $provWaPhone }}?text={{ $provWaMessage }}" target="_blank" rel="noopener" class="btn-msg">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 004.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2zm5.8 14.1c-.24.68-1.4 1.3-1.93 1.38-.5.08-1.12.11-1.8-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.13-4.9-4.32-.14-.19-1.17-1.55-1.17-2.96 0-1.4.73-2.09 1-2.38.26-.28.57-.35.76-.35h.55c.18 0 .42-.07.65.5.24.58.82 2 .89 2.15.07.15.12.32.02.51-.09.19-.14.31-.28.48-.14.16-.29.36-.42.49-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.28.36-.23.6-.14.24.09 1.55.73 1.82.86.27.14.44.2.51.32.07.12.07.68-.17 1.36z"/></svg>
                            Message
                        </a>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>

<!-- ── PROMOTIONS ─────────────────────────────────── -->
<section class="section-wrap-alt">
    <div class="container-lg">
        <div class="section-header">
            <div>
                <span class="section-tag">Deals</span>
                <h2 class="section-title">Promotion services<br>for you</h2>
            </div>
        </div>
        <div class="promos-grid">
            @foreach($promotions as $promotion)
            @if(\Carbon\Carbon::now()->lessThanOrEqualTo($promotion->end_date))
            @php
                $promoTotal = $promotion->service->price - ($promotion->service->price * $promotion->discount / 100);
                $promoWaPhone = preg_replace('/\D+/', '', optional($promotion->service->sprovider ?? null)->phone ?? config('services.whatsapp.default_number', '250780000000'));
                $promoWaMessage = rawurlencode('Hello! I\'d like to book the promo "' . $promotion->title . '" for ' . number_format($promoTotal) . ' RWF.');
            @endphp
            <div class="promo-card">
                <span class="discount-ribbon">{{ $promotion->discount }}% OFF</span>
                <div class="thumb">
                    <img src="{{ asset('image/services') }}/{{ $promotion->service->image }}" alt="{{ $promotion->title }}">
                </div>
                <div class="body">
                    <h4>{{ $promotion->title }}</h4>
                    <p class="desc">{{ Str::limit($promotion->description, 60) }}</p>
                    <div class="promo-meta">
                        <div>
                            <div class="m-label">Price</div>
                            <div class="m-val">{{ $promotion->service->price }} RWF</div>
                        </div>
                        <div>
                            <div class="m-label">Duration</div>
                            <div class="m-val">{{ $promotion->service->duration }}</div>
                        </div>
                        <div>
                            <div class="m-label">Ends</div>
                            <div class="m-val m-end">{{ \Carbon\Carbon::parse($promotion->end_date)->format('d M') }}</div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('home.service_details', ['service_slug' => $promotion->service->slug]) }}" class="btn-view-detail">View Detail</a>
                        <a href="https://wa.me/{{ $promoWaPhone }}?text={{ $promoWaMessage }}" target="_blank" rel="noopener" class="btn-whatsapp">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 004.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2zm5.8 14.1c-.24.68-1.4 1.3-1.93 1.38-.5.08-1.12.11-1.8-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.13-4.9-4.32-.14-.19-1.17-1.55-1.17-2.96 0-1.4.73-2.09 1-2.38.26-.28.57-.35.76-.35h.55c.18 0 .42-.07.65.5.24.58.82 2 .89 2.15.07.15.12.32.02.51-.09.19-.14.31-.28.48-.14.16-.29.36-.42.49-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.28.36-.23.6-.14.24.09 1.55.73 1.82.86.27.14.44.2.51.32.07.12.07.68-.17 1.36z"/></svg>
                            WhatsApp
                        </a>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>

<!-- ── HOW IT WORKS ─────────────────────────────────── -->
<section class="section-wrap">
    <div class="container-lg">
        <div class="how-banner">
            <h2>Let's get started.<br>It's <span>simple.</span></h2>
            <p>Get access to top 1% talent and a complete set of hybrid workforce management tools.</p>
            <div class="how-steps">
                <div class="how-step">
                    <div class="num">1</div>
                    <div class="info">
                        <div class="label">Open an account in 2 minutes.</div>
                        <a href="{{ route('register') }}">Create Account &rarr;</a>
                    </div>
                </div>
                <div class="how-step">
                    <div class="num">2</div>
                    <div class="info">
                        <div class="label">Find talent or your desired work.</div>
                        <a href="{{ route('home.services') }}">Browse Services &rarr;</a>
                    </div>
                </div>
                <div class="how-step">
                    <div class="num">3</div>
                    <div class="info">
                        <div class="label">Message on WhatsApp and get it done.</div>
                        <a href="#">Payment Methods &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── CTA STRIP ─────────────────────────────────── -->
<div class="container-lg" style="padding-bottom:80px;">
    <div class="cta-strip">
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

<!-- ── BLOG ─────────────────────────────────── -->
<section class="section-wrap-alt">
    <div class="container-lg">
        <div class="section-header">
            <div>
                <span class="section-tag">News</span>
                <h2 class="section-title">Today's latest</h2>
            </div>
            <a href="{{ route('home.blogs') }}" class="btn-outline-sage">Explore All &rarr;</a>
        </div>
        <div class="blog-grid">
            @foreach($blogs as $blog)
            <article class="blog-card">
                <div class="thumb">
                    <a href="{{ route('home.blog_detail', ['blog_slug' => $blog->slug]) }}">
                        <img src="{{ asset('image/blog') }}/{{ $blog->image }}" alt="{{ $blog->title }}">
                    </a>
                    <a href="{{ route('blogCategory.show', $blog->blog_category) }}" class="tag-badge">{{ $blog->blog_category }}</a>
                </div>
                <div class="body">
                    <div class="author-row">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                        </svg>
                        @if($blog->author && $blog->author->utype === 'SVP')
                        @php $sprovider = \App\Models\ServiceProvider::where('user_id', $blog->author->id)->first(); @endphp
                        @if($sprovider)
                        <a href="https://connector.rw/profile/{{ $sprovider->id }}">{{ $blog->author->name }}</a>
                        @else
                        <span>{{ $blog->author->name ?? 'Unknown' }}</span>
                        @endif
                        @else
                        <span>{{ $blog->author->name ?? 'Unknown' }}</span>
                        @endif
                    </div>
                    <h4>{{ Str::limit($blog->title, 60) }}</h4>
                    <a href="{{ route('home.blog_detail', ['blog_slug' => $blog->slug]) }}" class="read-more">
                        Continue Reading <span>&rarr;</span>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

<!-- ── TESTIMONIALS ─────────────────────────────────── -->
<section class="feedback-section">
    <div class="container-lg">
        <div>
            <span class="section-tag">Testimonials</span>
            <h2 class="section-title">Hear from our clients</h2>
        </div>
        <div class="feedback-slider">
            @foreach($feedbacks as $feedback)
            <div class="feedback-card">
                <p class="quote">"{{ $feedback->message }}"</p>
                <div class="reviewer">{{ $feedback->name }}</div>
                <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9734;</div>
                <div class="rating-label">4.5 Excellent</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ── PARTNERS ─────────────────────────────────── -->
<div class="container-lg">
    <div class="partners-row">
        @foreach($partners as $partner)
        <img src="{{ asset('image/partner') }}/{{ $partner->image }}" alt="{{ $partner->name }}">
        @endforeach
    </div>
</div>

@endsection