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
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-lg: 22px;
        --shadow-card: 0 2px 16px rgba(37, 64, 53, .07);
        --shadow-hover: 0 8px 32px rgba(37, 64, 53, .13);
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

    /* ─── HERO ─── */
    .hero {
        position: relative;
        padding-top: 80px;
        overflow: hidden;
    }

    .hero .carousel-item img {
        width: 100%;
        height: 620px;
        object-fit: cover;
        filter: brightness(.52);
    }

    .hero .carousel-item::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, rgba(37, 64, 53, .6) 0%, rgba(37, 64, 53, .25) 60%, transparent 100%);
        pointer-events: none;
    }

    .hero-caption {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0 24px;
        z-index: 5;
    }

    .hero-caption h1 {
        font-family: var(--font-display);
        font-size: clamp(34px, 6vw, 68px);
        font-weight: 700;
        color: #fff;
        line-height: 1.12;
        max-width: 800px;
        margin-bottom: 16px;
    }

    .hero-caption p {
        font-size: 17px;
        color: rgba(255, 255, 255, .82);
        margin-bottom: 40px;
        max-width: 500px;
    }

    .hero-stats {
        display: flex;
        gap: 40px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .hero-stat {
        text-align: center;
    }

    .hero-stat .count {
        font-family: var(--font-display);
        font-size: 36px;
        font-weight: 700;
        color: #fff;
        line-height: 1;
    }

    .hero-stat p {
        font-size: 13px;
        color: rgba(255, 255, 255, .7);
        margin-top: 4px;
    }

    .hero-stat-divider {
        width: 1px;
        height: 50px;
        background: rgba(255, 255, 255, .25);
        align-self: center;
    }

    /* carousel controls */
    .hero .carousel-control-prev,
    .hero .carousel-control-next {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, .18);
        backdrop-filter: blur(6px);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 1;
        transition: background var(--transition);
    }

    .hero .carousel-control-prev {
        left: 24px;
    }

    .hero .carousel-control-next {
        right: 24px;
    }

    .hero .carousel-control-prev:hover,
    .hero .carousel-control-next:hover {
        background: rgba(255, 255, 255, .32);
    }

    .hero .carousel-indicators {
        bottom: 20px;
        gap: 6px;
    }

    .hero .carousel-indicators li {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .5);
        border: none;
        transition: background var(--transition), transform var(--transition);
    }

    .hero .carousel-indicators li.active {
        background: #fff;
        transform: scale(1.35);
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

    .service-card .book-btn {
        display: block;
        text-align: center;
        background: var(--clr-sage-lt);
        color: var(--clr-forest);
        font-size: 14px;
        font-weight: 700;
        padding: 12px;
        border-radius: var(--radius-sm);
        transition: background var(--transition), color var(--transition);
        margin-top: auto;
    }

    .service-card .book-btn:hover {
        background: var(--clr-forest);
        color: #fff;
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

    .provider-card .card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
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
        background: var(--clr-forest);
        color: #fff;
    }

    .provider-card .btn-msg:hover {
        background: var(--clr-forest-lt);
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

    .promo-card .card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-top: auto;
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

    .promo-card .btn-book {
        background: var(--clr-forest);
        color: #fff;
    }

    .promo-card .btn-book:hover {
        background: var(--clr-forest-lt);
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

    .how-step .info {}

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
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- ── HERO ─────────────────────────────────── -->
<div class="hero">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($sliders as $index => $slider)
            <li data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach($sliders as $index => $slider)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <img src="{{ asset('image/slider') }}/{{ $slider->image }}" alt="Slide {{ $index + 1 }}">
                <div class="hero-caption">
                    <h1>{{ $slider->title }}</h1>
                    <p>Discover your path to prosperity — connect with trusted experts today.</p>
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <div class="count"><span class="counter">{{ $totalSales }}</span>+</div>
                            <p>Total Sales</p>
                        </div>
                        <div class="hero-stat-divider"></div>
                        <div class="hero-stat">
                            <div class="count"><span class="counter">{{ $totalSprovider }}</span>+</div>
                            <p>Service Providers</p>
                        </div>
                        <div class="hero-stat-divider"></div>
                        <div class="hero-stat">
                            <div class="count"><span class="counter">{{ $totalDone }}</span>+</div>
                            <p>Services Done</p>
                        </div>
                    </div>
                </div>
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
</div>

<!-- ── CATEGORY MENU ─────────────────────────────────── -->
<nav class="cat-menu">
    <ul>
        @foreach($subcategories as $scat)
        <li><a href="{{ route('home.service_by_subcategory', ['subcategory_slug' => $scat->slug]) }}">{{ $scat->name }}</a></li>
        @endforeach
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">More</a>
            <ul class="dropdown-menu">
                @foreach($subcategories as $scat)
                <li><a class="dropdown-item" href="{{ route('home.service_by_subcategory', ['subcategory_slug' => $scat->slug]) }}">{{ $scat->name }}</a></li>
                @endforeach
            </ul>
        </li>
    </ul>
</nav>

<!-- ── CATEGORIES ─────────────────────────────────── -->
<section class="section-wrap">
    <div class="container-lg">
        <div class="section-header">
            <div>
                <span class="section-tag">Explore</span>
                <h2 class="section-title">Most demanding<br>job categories</h2>
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
            if($service->discount) {
            if($service->discount_type == 'fixed') { $total = $total - $service->discount; }
            elseif($service->discount_type == 'percent') { $total = $total - ($total * $service->discount / 100); }
            }
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
                    <a href="{{ route('home.booking', ['service_slug' => $service->slug]) }}" class="book-btn">Book Now</a>
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
                        <a href="mailto:{{ $sprovider->proEmail }}" class="btn-msg">Message</a>
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
                        <a href="{{ route('home.service_details', ['service_slug' => $promotion->service->slug]) }}" class="btn-view">View Service</a>
                        <a href="{{ route('home.booking', ['service_slug' => $promotion->service->slug]) }}" class="btn-book">Book Now</a>
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
                        <div class="label">Get work done quickly with connector.</div>
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