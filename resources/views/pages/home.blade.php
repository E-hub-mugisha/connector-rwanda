@extends('layouts.base')

@section('title', 'Home')

@section('content')

@php
    $defaultWhatsapp = config('services.whatsapp.default_number', '250780000000');
@endphp

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-primary-dark: #557767;
        --connector-forest: #254035;
        --connector-forest-2: #315448;

        --connector-soft: #EEF5F2;
        --connector-soft-2: #F6F9F7;
        --connector-border: #DFE9E4;

        --connector-text: #17251F;
        --connector-muted: #6A7C74;
        --connector-light: #F8FAF9;

        --connector-white: #FFFFFF;
        --connector-danger: #D65A3A;
        --connector-whatsapp: #25D366;
        --connector-gold: #D19B3D;

        --connector-radius: 16px;
        --connector-radius-lg: 24px;

        --connector-shadow-sm:
            0 2px 10px rgba(37, 64, 53, .05);

        --connector-shadow:
            0 10px 35px rgba(37, 64, 53, .08);

        --connector-shadow-lg:
            0 24px 60px rgba(37, 64, 53, .13);

        --connector-transition:
            .22s cubic-bezier(.4, 0, .2, 1);

        --connector-display:
            'Playfair Display', Georgia, serif;

        --connector-body:
            'DM Sans', Arial, sans-serif;
    }

    /* =========================================================
       BASE
    ========================================================= */

    .connector-home {
        font-family: var(--connector-body);
        color: var(--connector-text);
        background: var(--connector-white);
        overflow: hidden;
    }

    .connector-home *,
    .connector-home *::before,
    .connector-home *::after {
        box-sizing: border-box;
    }

    .connector-home a {
        text-decoration: none;
    }

    .connector-home img {
        display: block;
        max-width: 100%;
    }

    .connector-home button,
    .connector-home input,
    .connector-home select {
        font-family: inherit;
    }

    .connector-container {
        width: min(1240px, calc(100% - 48px));
        margin-inline: auto;
    }

    @media (max-width: 767px) {
        .connector-container {
            width: min(100% - 32px, 1240px);
        }
    }

    /* =========================================================
       TYPOGRAPHY
    ========================================================= */

    .connector-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--connector-primary-dark);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .14em;
        margin-bottom: 14px;
    }

    .connector-eyebrow::before {
        content: "";
        width: 22px;
        height: 1px;
        background: var(--connector-primary);
    }

    .connector-title {
        margin: 0;
        color: var(--connector-forest);
        font-family: var(--connector-display);
        font-size: clamp(30px, 4vw, 44px);
        line-height: 1.15;
        font-weight: 700;
        letter-spacing: -.025em;
    }

    .connector-description {
        margin: 14px 0 0;
        color: var(--connector-muted);
        font-size: 15px;
        line-height: 1.7;
        max-width: 600px;
    }

    .connector-section {
        padding: 92px 0;
    }

    .connector-section-soft {
        background: var(--connector-soft-2);
    }

    @media (max-width: 767px) {
        .connector-section {
            padding: 64px 0;
        }
    }

    /* =========================================================
       HERO
    ========================================================= */

    .connector-hero {
        position: relative;
        background:
            linear-gradient(
                135deg,
                #F4F8F6 0%,
                #FFFFFF 52%,
                #F1F7F4 100%
            );
        border-bottom: 1px solid var(--connector-border);
    }

    .connector-hero::before {
        content: "";
        position: absolute;
        width: 460px;
        height: 460px;
        right: -160px;
        top: -180px;
        border-radius: 50%;
        background: rgba(107, 144, 128, .08);
        pointer-events: none;
    }

    .connector-hero-inner {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 500px;
        align-items: center;
        gap: 76px;
        min-height: 690px;
        padding: 72px 0 88px;
    }

    .connector-hero-copy {
        max-width: 650px;
    }

    .connector-hero-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 11px;
        border: 1px solid #CBDCD5;
        background: rgba(255,255,255,.85);
        color: var(--connector-forest);
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin-bottom: 22px;
    }

    .connector-hero-label span {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--connector-primary);
    }

    .connector-hero h1 {
        margin: 0;
        color: var(--connector-forest);
        font-family: var(--connector-display);
        font-size: clamp(42px, 5.2vw, 68px);
        line-height: 1.06;
        letter-spacing: -.045em;
        font-weight: 700;
        max-width: 700px;
    }

    .connector-hero h1 em {
        color: var(--connector-primary);
        font-style: normal;
    }

    .connector-hero-text {
        max-width: 570px;
        margin: 24px 0 30px;
        color: var(--connector-muted);
        font-size: 17px;
        line-height: 1.75;
    }

    /* Hero search */

    .connector-main-search {
        width: min(100%, 640px);
        display: flex;
        align-items: center;
        padding: 6px;
        background: #fff;
        border: 1px solid #D8E5DF;
        border-radius: 14px;
        box-shadow: var(--connector-shadow);
        transition: border-color var(--connector-transition),
                    box-shadow var(--connector-transition);
    }

    .connector-main-search:focus-within {
        border-color: var(--connector-primary);
        box-shadow: 0 12px 35px rgba(37, 64, 53, .12);
    }

    .connector-search-field {
        flex: 1;
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 0 16px;
    }

    .connector-search-field svg {
        flex-shrink: 0;
        color: var(--connector-primary);
    }

    .connector-search-field input {
        width: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        padding: 13px 0;
        color: var(--connector-text);
        font-size: 14px;
    }

    .connector-search-field input::placeholder {
        color: #8B9B94;
    }

    .connector-search-category {
        width: 190px;
        border-left: 1px solid var(--connector-border);
        padding-left: 8px;
    }

    .connector-search-category select {
        width: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        padding: 13px 10px;
        color: var(--connector-text);
        font-size: 13px;
        cursor: pointer;
    }

    .connector-search-button {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 46px;
        padding: 0 22px;
        border: 0;
        border-radius: 10px;
        background: var(--connector-forest);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: background var(--connector-transition),
                    transform var(--connector-transition);
    }

    .connector-search-button:hover {
        background: var(--connector-primary-dark);
        transform: translateY(-1px);
    }

    /* Popular searches */

    .connector-popular {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 14px;
    }

    .connector-popular-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--connector-muted);
        margin-right: 3px;
    }

    .connector-popular a {
        color: var(--connector-primary-dark);
        font-size: 12px;
        font-weight: 600;
    }

    .connector-popular a:hover {
        text-decoration: underline;
    }

    /* Hero trust */

    .connector-trust {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0;
        margin-top: 40px;
    }

    .connector-trust-item {
        min-width: 130px;
        padding-right: 28px;
        margin-right: 28px;
        border-right: 1px solid var(--connector-border);
    }

    .connector-trust-item:last-child {
        border-right: 0;
        margin-right: 0;
    }

    .connector-trust-number {
        color: var(--connector-forest);
        font-size: 25px;
        font-weight: 700;
        line-height: 1;
    }

    .connector-trust-label {
        margin-top: 7px;
        color: var(--connector-muted);
        font-size: 11px;
        font-weight: 500;
    }

    /* Hero visual */

    .connector-hero-visual {
        position: relative;
    }

    .connector-hero-image {
        position: relative;
        aspect-ratio: .83;
        overflow: hidden;
        border-radius: 22px;
        background: var(--connector-soft);
        box-shadow: var(--connector-shadow-lg);
    }

    .connector-hero-image .carousel,
    .connector-hero-image .carousel-inner,
    .connector-hero-image .carousel-item {
        height: 100%;
    }

    .connector-hero-image .carousel-item {
        position: relative;
    }

    .connector-hero-image .carousel-item::after {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(
                180deg,
                rgba(37,64,53,0) 45%,
                rgba(37,64,53,.65) 100%
            );
        pointer-events: none;
    }

    .connector-hero-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .connector-slide-content {
        position: absolute;
        left: 26px;
        right: 26px;
        bottom: 28px;
        z-index: 3;
        color: #fff;
    }

    .connector-slide-content small {
        display: block;
        margin-bottom: 7px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        opacity: .8;
    }

    .connector-slide-content strong {
        display: block;
        max-width: 330px;
        font-family: var(--connector-display);
        font-size: 23px;
        line-height: 1.25;
    }

    .connector-hero-image .carousel-control-prev,
    .connector-hero-image .carousel-control-next {
        width: 38px;
        height: 38px;
        top: auto;
        bottom: 24px;
        border-radius: 8px;
        background: rgba(255,255,255,.16);
        backdrop-filter: blur(8px);
        opacity: 1;
        z-index: 5;
    }

    .connector-hero-image .carousel-control-prev {
        left: auto;
        right: 72px;
    }

    .connector-hero-image .carousel-control-next {
        right: 24px;
    }

    .connector-verified {
        position: absolute;
        left: -35px;
        bottom: 42px;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 13px 16px;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 12px;
        box-shadow: var(--connector-shadow);
    }

    .connector-verified-icon {
        width: 36px;
        height: 36px;
        display: grid;
        place-items: center;
        border-radius: 9px;
        background: var(--connector-soft);
        color: var(--connector-primary-dark);
    }

    .connector-verified strong {
        display: block;
        color: var(--connector-forest);
        font-size: 12px;
    }

    .connector-verified span {
        display: block;
        margin-top: 3px;
        color: var(--connector-muted);
        font-size: 10px;
    }

    @media (max-width: 1050px) {
        .connector-hero-inner {
            grid-template-columns: 1fr;
            gap: 48px;
        }

        .connector-hero-copy {
            max-width: 760px;
        }

        .connector-hero-visual {
            max-width: 620px;
        }

        .connector-hero-image {
            aspect-ratio: 1.1;
        }

        .connector-verified {
            left: 18px;
        }
    }

    @media (max-width: 700px) {
        .connector-hero-inner {
            min-height: auto;
            padding: 48px 0 60px;
        }

        .connector-hero h1 {
            font-size: clamp(38px, 12vw, 52px);
        }

        .connector-hero-text {
            font-size: 15px;
        }

        .connector-main-search {
            flex-wrap: wrap;
            border-radius: 12px;
        }

        .connector-search-category {
            width: 100%;
            border-left: 0;
            border-top: 1px solid var(--connector-border);
            padding-left: 0;
        }

        .connector-search-button {
            width: 100%;
        }

        .connector-trust {
            gap: 22px;
        }

        .connector-trust-item {
            min-width: auto;
            padding-right: 18px;
            margin-right: 18px;
        }

        .connector-trust-item:nth-child(2) {
            border-right: 0;
        }

        .connector-trust-number {
            font-size: 21px;
        }

        .connector-hero-image {
            aspect-ratio: .9;
            border-radius: 18px;
        }

        .connector-verified {
            bottom: 18px;
            left: 12px;
        }
    }

    /* =========================================================
       SECTION HEADER
    ========================================================= */

    .connector-section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 25px;
        margin-bottom: 38px;
    }

    .connector-section-header > div:first-child {
        max-width: 650px;
    }

    .connector-view-all {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
        color: var(--connector-forest);
        font-size: 13px;
        font-weight: 700;
        padding-bottom: 6px;
        border-bottom: 1px solid var(--connector-primary);
        transition: gap var(--connector-transition),
                    color var(--connector-transition);
    }

    .connector-view-all:hover {
        color: var(--connector-primary-dark);
        gap: 12px;
    }

    @media (max-width: 650px) {
        .connector-section-header {
            align-items: flex-start;
            flex-direction: column;
            margin-bottom: 28px;
        }
    }

    /* =========================================================
       CATEGORIES
    ========================================================= */

    .connector-category-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 14px;
    }

    .connector-category-card {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 160px;
        padding: 22px 14px;
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        background: #fff;
        text-align: center;
        transition:
            transform var(--connector-transition),
            border-color var(--connector-transition),
            box-shadow var(--connector-transition);
    }

    .connector-category-card:hover {
        transform: translateY(-4px);
        border-color: #BDD2C9;
        box-shadow: var(--connector-shadow);
    }

    .connector-category-icon {
        width: 60px;
        height: 60px;
        display: grid;
        place-items: center;
        margin-bottom: 15px;
        border-radius: 12px;
        background: var(--connector-soft);
        transition: background var(--connector-transition);
    }

    .connector-category-card:hover .connector-category-icon {
        background: #DCEBE5;
    }

    .connector-category-icon img {
        width: 34px;
        height: 34px;
        object-fit: contain;
    }

    .connector-category-name {
        color: var(--connector-forest);
        font-size: 12.5px;
        font-weight: 700;
        line-height: 1.35;
    }

    @media (max-width: 1100px) {
        .connector-category-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 650px) {
        .connector-category-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* =========================================================
       SERVICES
    ========================================================= */

    .connector-service-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .connector-service-card {
        display: flex;
        flex-direction: column;
        min-width: 0;
        overflow: hidden;
        border: 1px solid var(--connector-border);
        border-radius: 16px;
        background: #fff;
        transition:
            transform var(--connector-transition),
            box-shadow var(--connector-transition),
            border-color var(--connector-transition);
    }

    .connector-service-card:hover {
        transform: translateY(-4px);
        border-color: #C8D9D2;
        box-shadow: var(--connector-shadow);
    }

    .connector-service-image {
        position: relative;
        height: 190px;
        overflow: hidden;
        background: var(--connector-soft);
    }

    .connector-service-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .45s ease;
    }

    .connector-service-card:hover .connector-service-image img {
        transform: scale(1.04);
    }

    .connector-duration {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 5px 9px;
        border-radius: 6px;
        background: rgba(37,64,53,.88);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
    }

    .connector-service-body {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 17px;
    }

    .connector-service-category {
        margin-bottom: 6px;
        color: var(--connector-primary-dark);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .connector-service-name {
        display: block;
        color: var(--connector-forest);
        font-size: 15px;
        font-weight: 700;
        line-height: 1.4;
        min-height: 42px;
    }

    .connector-service-name:hover {
        color: var(--connector-primary-dark);
    }

    .connector-service-location {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 12px;
        color: var(--connector-muted);
        font-size: 11.5px;
    }

    .connector-service-location svg {
        flex-shrink: 0;
        color: var(--connector-primary);
    }

    .connector-service-location a {
        color: inherit;
    }

    .connector-service-price {
        display: flex;
        align-items: baseline;
        gap: 5px;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid var(--connector-border);
    }

    .connector-price-current {
        color: var(--connector-forest);
        font-size: 18px;
        font-weight: 800;
    }

    .connector-price-currency {
        color: var(--connector-muted);
        font-size: 10px;
        font-weight: 600;
    }

    .connector-price-original {
        color: #9AA8A2;
        font-size: 10px;
        text-decoration: line-through;
        margin-left: 2px;
    }

    .connector-discount {
        margin-left: auto;
        padding: 3px 7px;
        border-radius: 5px;
        background: #FFF1ED;
        color: var(--connector-danger);
        font-size: 9px;
        font-weight: 800;
    }

    .connector-service-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 7px;
        margin-top: 16px;
    }

    .connector-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 0 8px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        transition:
            background var(--connector-transition),
            color var(--connector-transition);
    }

    .connector-action-primary {
        background: var(--connector-soft);
        color: var(--connector-forest);
    }

    .connector-action-primary:hover {
        background: var(--connector-forest);
        color: #fff;
    }

    .connector-action-whatsapp {
        gap: 5px;
        background: var(--connector-whatsapp);
        color: #fff;
    }

    .connector-action-whatsapp:hover {
        background: #1EB957;
        color: #fff;
    }

    @media (max-width: 1100px) {
        .connector-service-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .connector-service-grid {
            grid-template-columns: 1fr;
        }
    }

    /* =========================================================
       PROVIDERS
    ========================================================= */

    .connector-provider-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .connector-provider-card {
        position: relative;
        overflow: hidden;
        border: 1px solid var(--connector-border);
        border-radius: 16px;
        background: #fff;
        transition:
            transform var(--connector-transition),
            box-shadow var(--connector-transition);
    }

    .connector-provider-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--connector-shadow);
    }

    .connector-provider-image {
        height: 210px;
        overflow: hidden;
        background: var(--connector-soft);
    }

    .connector-provider-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .45s ease;
    }

    .connector-provider-card:hover .connector-provider-image img {
        transform: scale(1.04);
    }

    .connector-provider-favorite {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        border: 0;
        border-radius: 8px;
        background: rgba(255,255,255,.92);
        color: var(--connector-muted);
        cursor: pointer;
        z-index: 3;
        transition: color var(--connector-transition),
                    background var(--connector-transition);
    }

    .connector-provider-favorite:hover {
        color: var(--connector-danger);
        background: #fff;
    }

    .connector-provider-body {
        padding: 18px;
    }

    .connector-provider-name {
        color: var(--connector-forest);
        font-size: 15px;
        font-weight: 800;
    }

    .connector-provider-category {
        margin-top: 4px;
        color: var(--connector-primary-dark);
        font-size: 11px;
        font-weight: 700;
    }

    .connector-provider-meta {
        display: flex;
        gap: 20px;
        margin-top: 17px;
        padding-top: 14px;
        border-top: 1px solid var(--connector-border);
    }

    .connector-provider-meta-item {
        min-width: 0;
    }

    .connector-provider-meta-label {
        display: block;
        margin-bottom: 3px;
        color: var(--connector-muted);
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .connector-provider-meta-value {
        display: block;
        overflow: hidden;
        color: var(--connector-text);
        font-size: 11.5px;
        font-weight: 600;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .connector-provider-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 7px;
        margin-top: 17px;
    }

    .connector-provider-actions a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
    }

    .connector-provider-view {
        background: var(--connector-soft);
        color: var(--connector-forest);
    }

    .connector-provider-view:hover {
        background: var(--connector-forest);
        color: #fff;
    }

    .connector-provider-message {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        background: var(--connector-whatsapp);
        color: #fff;
    }

    .connector-provider-message:hover {
        background: #1EB957;
        color: #fff;
    }

    @media (max-width: 1100px) {
        .connector-provider-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .connector-provider-grid {
            grid-template-columns: 1fr;
        }
    }

    /* =========================================================
       PROMOTIONS
    ========================================================= */

    .connector-promotion-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .connector-promotion-card {
        position: relative;
        overflow: hidden;
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        background: #fff;
        transition:
            transform var(--connector-transition),
            box-shadow var(--connector-transition);
    }

    .connector-promotion-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--connector-shadow);
    }

    .connector-promotion-image {
        height: 220px;
        overflow: hidden;
    }

    .connector-promotion-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .connector-promotion-badge {
        position: absolute;
        left: 14px;
        top: 14px;
        padding: 6px 9px;
        border-radius: 6px;
        background: var(--connector-danger);
        color: #fff;
        font-size: 10px;
        font-weight: 800;
    }

    .connector-promotion-body {
        padding: 19px;
    }

    .connector-promotion-title {
        color: var(--connector-forest);
        font-size: 17px;
        font-weight: 800;
    }

    .connector-promotion-description {
        min-height: 38px;
        margin-top: 7px;
        color: var(--connector-muted);
        font-size: 12px;
        line-height: 1.55;
    }

    .connector-promotion-meta {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-top: 16px;
        padding: 12px;
        border-radius: 10px;
        background: var(--connector-soft-2);
    }

    .connector-promotion-meta-label {
        display: block;
        margin-bottom: 4px;
        color: var(--connector-muted);
        font-size: 9px;
        font-weight: 600;
    }

    .connector-promotion-meta-value {
        color: var(--connector-forest);
        font-size: 11px;
        font-weight: 700;
    }

    .connector-promotion-end {
        color: var(--connector-danger);
    }

    .connector-promotion-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 7px;
        margin-top: 14px;
    }

    .connector-promotion-actions a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-height: 39px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
    }

    @media (max-width: 900px) {
        .connector-promotion-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 600px) {
        .connector-promotion-grid {
            grid-template-columns: 1fr;
        }
    }

    /* =========================================================
       HOW IT WORKS
    ========================================================= */

    .connector-how {
        padding: 86px 0;
        background: var(--connector-forest);
        color: #fff;
    }

    .connector-how-header {
        max-width: 650px;
        margin-bottom: 50px;
    }

    .connector-how .connector-eyebrow {
        color: var(--connector-sage-md);
    }

    .connector-how .connector-eyebrow::before {
        background: var(--connector-sage);
    }

    .connector-how-title {
        color: #fff;
        font-family: var(--connector-display);
        font-size: clamp(32px, 4vw, 46px);
        line-height: 1.15;
        margin: 0;
    }

    .connector-how-title span {
        color: #BFD7CD;
    }

    .connector-how-description {
        margin-top: 14px;
        color: rgba(255,255,255,.65);
        font-size: 15px;
        line-height: 1.7;
    }

    .connector-steps {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0;
    }

    .connector-step {
        position: relative;
        padding: 0 42px 0 0;
    }

    .connector-step:not(:last-child)::after {
        content: "";
        position: absolute;
        top: 22px;
        right: 42px;
        width: calc(100% - 110px);
        height: 1px;
        background: rgba(255,255,255,.15);
        transform: translateX(50%);
    }

    .connector-step-number {
        position: relative;
        z-index: 2;
        width: 46px;
        height: 46px;
        display: grid;
        place-items: center;
        border: 1px solid rgba(255,255,255,.25);
        border-radius: 10px;
        background: rgba(255,255,255,.08);
        color: #fff;
        font-size: 14px;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .connector-step h3 {
        margin: 0 0 8px;
        color: #fff;
        font-size: 15px;
        font-weight: 700;
    }

    .connector-step p {
        margin: 0;
        max-width: 260px;
        color: rgba(255,255,255,.58);
        font-size: 12.5px;
        line-height: 1.65;
    }

    .connector-step a {
        display: inline-flex;
        margin-top: 17px;
        color: #BFD7CD;
        font-size: 11px;
        font-weight: 700;
    }

    .connector-step a:hover {
        color: #fff;
    }

    @media (max-width: 700px) {
        .connector-steps {
            grid-template-columns: 1fr;
            gap: 38px;
        }

        .connector-step {
            padding: 0;
        }

        .connector-step:not(:last-child)::after {
            display: none;
        }
    }

    /* =========================================================
       CTA
    ========================================================= */

    .connector-cta {
        padding: 76px 0;
    }

    .connector-cta-card {
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: center;
        gap: 35px;
        padding: 42px 46px;
        border: 1px solid var(--connector-border);
        border-radius: 20px;
        background:
            linear-gradient(
                135deg,
                #F5F9F7,
                #FFFFFF
            );
    }

    .connector-cta-card h2 {
        margin: 0;
        color: var(--connector-forest);
        font-family: var(--connector-display);
        font-size: clamp(26px, 3vw, 36px);
        line-height: 1.2;
    }

    .connector-cta-card p {
        margin: 9px 0 0;
        color: var(--connector-muted);
        font-size: 14px;
    }

    .connector-cta-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
    }

    .connector-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 0 20px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        transition:
            background var(--connector-transition),
            color var(--connector-transition),
            border-color var(--connector-transition),
            transform var(--connector-transition);
    }

    .connector-button:hover {
        transform: translateY(-1px);
    }

    .connector-button-dark {
        background: var(--connector-forest);
        color: #fff;
    }

    .connector-button-dark:hover {
        background: var(--connector-primary-dark);
        color: #fff;
    }

    .connector-button-outline {
        border: 1px solid #BFD2C9;
        background: #fff;
        color: var(--connector-forest);
    }

    .connector-button-outline:hover {
        border-color: var(--connector-primary);
        background: var(--connector-soft);
        color: var(--connector-forest);
    }

    @media (max-width: 700px) {
        .connector-cta-card {
            grid-template-columns: 1fr;
            padding: 30px 24px;
        }

        .connector-cta-actions {
            width: 100%;
        }

        .connector-button {
            flex: 1;
        }
    }

    /* =========================================================
       BLOG
    ========================================================= */

    .connector-blog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
    }

    .connector-blog-card {
        overflow: hidden;
        border: 1px solid var(--connector-border);
        border-radius: 16px;
        background: #fff;
        transition:
            transform var(--connector-transition),
            box-shadow var(--connector-transition);
    }

    .connector-blog-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--connector-shadow);
    }

    .connector-blog-image {
        position: relative;
        height: 215px;
        overflow: hidden;
    }

    .connector-blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .45s ease;
    }

    .connector-blog-card:hover .connector-blog-image img {
        transform: scale(1.04);
    }

    .connector-blog-category {
        position: absolute;
        left: 13px;
        top: 13px;
        padding: 5px 8px;
        border-radius: 5px;
        background: rgba(37,64,53,.92);
        color: #fff;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .connector-blog-body {
        padding: 19px;
    }

    .connector-blog-author {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--connector-muted);
        font-size: 10.5px;
    }

    .connector-blog-author a {
        color: var(--connector-primary-dark);
        font-weight: 700;
    }

    .connector-blog-title {
        display: block;
        margin-top: 10px;
        color: var(--connector-forest);
        font-family: var(--connector-display);
        font-size: 18px;
        font-weight: 700;
        line-height: 1.3;
    }

    .connector-blog-title:hover {
        color: var(--connector-primary-dark);
    }

    .connector-blog-read {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-top: 17px;
        color: var(--connector-primary-dark);
        font-size: 11px;
        font-weight: 800;
    }

    .connector-blog-read:hover {
        gap: 10px;
    }

    @media (max-width: 800px) {
        .connector-blog-grid {
            grid-template-columns: 1fr;
        }
    }

    /* =========================================================
       TESTIMONIALS
    ========================================================= */

    .connector-testimonials {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .connector-testimonial {
        padding: 28px;
        border: 1px solid var(--connector-border);
        border-radius: 16px;
        background: #fff;
    }

    .connector-testimonial-quote {
        color: var(--connector-forest);
        font-size: 14px;
        line-height: 1.75;
        margin: 0;
    }

    .connector-testimonial-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 25px;
        padding-top: 17px;
        border-top: 1px solid var(--connector-border);
    }

    .connector-testimonial-name {
        color: var(--connector-forest);
        font-size: 12px;
        font-weight: 800;
    }

    .connector-stars {
        color: var(--connector-gold);
        font-size: 12px;
        letter-spacing: 2px;
    }

    @media (max-width: 850px) {
        .connector-testimonials {
            grid-template-columns: 1fr;
        }
    }

    /* =========================================================
       PARTNERS
    ========================================================= */

    .connector-partners {
        padding: 58px 0;
        border-top: 1px solid var(--connector-border);
    }

    .connector-partners-label {
        margin-bottom: 30px;
        text-align: center;
        color: var(--connector-muted);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .connector-partner-list {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 38px;
    }

    .connector-partner-list img {
        max-width: 130px;
        max-height: 42px;
        object-fit: contain;
        filter: grayscale(1);
        opacity: .55;
        transition:
            filter var(--connector-transition),
            opacity var(--connector-transition);
    }

    .connector-partner-list img:hover {
        filter: grayscale(0);
        opacity: 1;
    }

    /* =========================================================
       EMPTY STATES
    ========================================================= */

    .connector-empty {
        padding: 45px 20px;
        text-align: center;
        border: 1px dashed var(--connector-border);
        border-radius: 14px;
        color: var(--connector-muted);
        font-size: 13px;
    }

    /* =========================================================
       MOBILE
    ========================================================= */

    @media (max-width: 480px) {
        .connector-container {
            width: calc(100% - 28px);
        }

        .connector-hero-inner {
            padding-top: 38px;
        }

        .connector-hero h1 {
            font-size: 38px;
        }

        .connector-trust {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }

        .connector-trust-item {
            border-right: 0;
            margin-right: 0;
            padding-right: 0;
        }

        .connector-trust-item:last-child {
            grid-column: 1 / -1;
        }

        .connector-verified {
            position: relative;
            left: auto;
            bottom: auto;
            margin-top: -45px;
            margin-left: 12px;
            width: fit-content;
        }

        .connector-category-card {
            min-height: 145px;
        }

        .connector-category-icon {
            width: 52px;
            height: 52px;
        }

        .connector-category-icon img {
            width: 29px;
            height: 29px;
        }

        .connector-cta-actions {
            flex-direction: column;
        }

        .connector-button {
            width: 100%;
        }
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">


<div class="connector-home">

    {{-- =====================================================
         HERO
    ====================================================== --}}
    <section class="connector-hero">
        <div class="connector-container connector-hero-inner">

            <div class="connector-hero-copy">

                <div class="connector-hero-label">
                    <span></span>
                    Rwanda's service marketplace
                </div>

                <h1>
                    Find the right
                    <em>people</em>
                    for the job.
                </h1>

                <p class="connector-hero-text">
                    Discover trusted service providers, compare services,
                    connect directly and get things done with confidence.
                </p>

                <form
                    class="connector-main-search"
                    action="{{ route('home.services') }}"
                    method="GET"
                >

                    <div class="connector-search-field">
                        <svg width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor"
                             stroke-width="2">
                            <circle cx="11" cy="11" r="7"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>

                        <input
                            type="text"
                            name="q"
                            placeholder="What service do you need?"
                            autocomplete="off"
                        >
                    </div>

                    <div class="connector-search-category">
                        <select name="category">
                            <option value="">All categories</option>

                            @foreach($scategories ?? [] as $scategory)
                                <option value="{{ $scategory->slug }}">
                                    {{ $scategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button
                        type="submit"
                        class="connector-search-button"
                    >
                        Search
                    </button>

                </form>

                <div class="connector-popular">
                    <span class="connector-popular-label">
                        Popular:
                    </span>

                    @foreach(($scategories ?? collect())->take(4) as $popularCategory)
                        <a href="{{ route('home.service_by_category', ['category_slug' => $popularCategory->slug]) }}">
                            {{ $popularCategory->name }}
                        </a>

                        @if(!$loop->last)
                            <span style="color:#B8C6C0;">·</span>
                        @endif
                    @endforeach
                </div>

                <div class="connector-trust">

                    <div class="connector-trust-item">
                        <div class="connector-trust-number">
                            {{ number_format($totalSales ?? 0) }}+
                        </div>

                        <div class="connector-trust-label">
                            Total sales
                        </div>
                    </div>

                    <div class="connector-trust-item">
                        <div class="connector-trust-number">
                            {{ number_format($totalSprovider ?? 0) }}+
                        </div>

                        <div class="connector-trust-label">
                            Service providers
                        </div>
                    </div>

                    <div class="connector-trust-item">
                        <div class="connector-trust-number">
                            {{ number_format($totalDone ?? 0) }}+
                        </div>

                        <div class="connector-trust-label">
                            Services completed
                        </div>
                    </div>

                </div>

            </div>


            <div class="connector-hero-visual">

                <div class="connector-hero-image">

                    <div
                        id="connectorHeroCarousel"
                        class="carousel slide"
                        data-bs-ride="carousel"
                    >

                        <div class="carousel-inner">

                            @forelse($sliders as $index => $slider)

                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">

                                    <img
                                        src="{{ asset('image/slider') }}/{{ $slider->image }}"
                                        alt="{{ $slider->title ?? 'Connector service' }}"
                                    >

                                    <div class="connector-slide-content">

                                        <small>
                                            Connector marketplace
                                        </small>

                                        <strong>
                                            {{ $slider->title }}
                                        </strong>

                                    </div>

                                </div>

                            @empty

                                <div class="carousel-item active">

                                    <img
                                        src="{{ asset('image/services/default.png') }}"
                                        alt="Connector services"
                                    >

                                    <div class="connector-slide-content">
                                        <small>Connector marketplace</small>
                                        <strong>
                                            Trusted people. Better services.
                                        </strong>
                                    </div>

                                </div>

                            @endforelse

                        </div>

                        @if(($sliders ?? collect())->count() > 1)

                            <button
                                class="carousel-control-prev"
                                type="button"
                                data-bs-target="#connectorHeroCarousel"
                                data-bs-slide="prev"
                            >
                                <span
                                    class="carousel-control-prev-icon"
                                    aria-hidden="true"
                                ></span>

                                <span class="visually-hidden">
                                    Previous
                                </span>
                            </button>

                            <button
                                class="carousel-control-next"
                                type="button"
                                data-bs-target="#connectorHeroCarousel"
                                data-bs-slide="next"
                            >
                                <span
                                    class="carousel-control-next-icon"
                                    aria-hidden="true"
                                ></span>

                                <span class="visually-hidden">
                                    Next
                                </span>
                            </button>

                        @endif

                    </div>

                </div>


                <div class="connector-verified">

                    <div class="connector-verified-icon">

                        <svg
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M12 3l7 4v5c0 4.5-3 7.8-7 9-4-1.2-7-4.5-7-9V7l7-4z"/>
                            <path d="m9 12 2 2 4-4"/>
                        </svg>

                    </div>

                    <div>
                        <strong>Trusted providers</strong>
                        <span>Profiles reviewed by Connector</span>
                    </div>

                </div>

            </div>

        </div>
    </section>


    {{-- =====================================================
         CATEGORIES
    ====================================================== --}}
    <section class="connector-section">

        <div class="connector-container">

            <div class="connector-section-header">

                <div>
                    <div class="connector-eyebrow">
                        Explore services
                    </div>

                    <h2 class="connector-title">
                        What do you need help with?
                    </h2>

                    <p class="connector-description">
                        Browse popular categories and find experienced
                        professionals ready to help.
                    </p>
                </div>

                <a
                    href="{{ route('home.service_categories') }}"
                    class="connector-view-all"
                >
                    View all categories
                    <span>→</span>
                </a>

            </div>


            @if(($scategories ?? collect())->count())

                <div class="connector-category-grid">

                    @foreach($scategories as $scategory)

                        <a
                            href="{{ route('home.service_by_category', ['category_slug' => $scategory->slug]) }}"
                            class="connector-category-card"
                        >

                            <div class="connector-category-icon">

                                <img
                                    src="{{ asset('image/categories') }}/{{ $scategory->image }}"
                                    alt="{{ $scategory->name }}"
                                >

                            </div>

                            <div class="connector-category-name">
                                {{ $scategory->name }}
                            </div>

                        </a>

                    @endforeach

                </div>

            @else

                <div class="connector-empty">
                    Service categories will appear here soon.
                </div>

            @endif

        </div>

    </section>


    {{-- =====================================================
         SERVICES
    ====================================================== --}}
    <section class="connector-section connector-section-soft">

        <div class="connector-container">

            <div class="connector-section-header">

                <div>
                    <div class="connector-eyebrow">
                        Featured services
                    </div>

                    <h2 class="connector-title">
                        Services people are booking
                    </h2>

                    <p class="connector-description">
                        Compare services, pricing and locations before
                        connecting with a provider.
                    </p>
                </div>

                <a
                    href="{{ route('home.services') }}"
                    class="connector-view-all"
                >
                    Browse all services
                    <span>→</span>
                </a>

            </div>


            @if(($services ?? collect())->count())

                <div class="connector-service-grid">

                    @foreach($services as $service)

                        @php

                            $total = $service->price;

                            if ($service->discount) {

                                if ($service->discount_type === 'fixed') {
                                    $total = $total - $service->discount;
                                }

                                if ($service->discount_type === 'percent') {
                                    $total = $total -
                                        ($total * $service->discount / 100);
                                }
                            }

                            $waRawPhone =
                                optional($service->sprovider ?? null)->phone
                                ?? $defaultWhatsapp;

                            $waPhone =
                                preg_replace('/\D+/', '', $waRawPhone);

                            $waMessage = rawurlencode(
                                'Hello! I\'m interested in booking "' .
                                $service->name .
                                '" (' .
                                number_format($total) .
                                ' RWF). Is it available?'
                            );

                        @endphp

                        <article class="connector-service-card">

                            <div class="connector-service-image">

                                <a
                                    href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}"
                                >
                                    <img
                                        src="{{ asset('image/services/' . ($service->image ?? 'default.png')) }}"
                                        alt="{{ $service->name }}"
                                    >
                                </a>

                                @if($service->duration)

                                    <span class="connector-duration">
                                        {{ $service->duration }}
                                    </span>

                                @endif

                            </div>


                            <div class="connector-service-body">

                                <div class="connector-service-category">
                                    {{ optional($service->category)->name }}
                                </div>

                                <a
                                    href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}"
                                    class="connector-service-name"
                                >
                                    {{ $service->name }}
                                </a>


                                <div class="connector-service-location">

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

                                    <a
                                        href="{{ route('home.service_location', ['service_location' => $service->location]) }}"
                                    >
                                        {{ $service->location }}
                                    </a>

                                </div>


                                <div class="connector-service-price">

                                    <span class="connector-price-current">
                                        {{ number_format($total) }}
                                    </span>

                                    <span class="connector-price-currency">
                                        RWF
                                    </span>

                                    @if($service->discount)

                                        <span class="connector-price-original">
                                            {{ number_format($service->price) }}
                                        </span>

                                        <span class="connector-discount">

                                            @if($service->discount_type === 'fixed')
                                                -{{ number_format($service->discount) }}
                                            @else
                                                -{{ $service->discount }}%
                                            @endif

                                        </span>

                                    @endif

                                </div>


                                <div class="connector-service-actions">

                                    <a
                                        href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}"
                                        class="connector-action connector-action-primary"
                                    >
                                        View service
                                    </a>

                                    <a
                                        href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}"
                                        target="_blank"
                                        rel="noopener"
                                        class="connector-action connector-action-whatsapp"
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

                        </article>

                    @endforeach

                </div>

            @else

                <div class="connector-empty">
                    No services are currently available.
                </div>

            @endif

        </div>

    </section>


    {{-- =====================================================
         PROVIDERS
    ====================================================== --}}
    <section class="connector-section">

        <div class="connector-container">

            <div class="connector-section-header">

                <div>

                    <div class="connector-eyebrow">
                        Meet the professionals
                    </div>

                    <h2 class="connector-title">
                        Find trusted service providers
                    </h2>

                    <p class="connector-description">
                        Connect directly with professionals offering
                        services across different locations.
                    </p>

                </div>

                <a
                    href="{{ route('home.service_provider') }}"
                    class="connector-view-all"
                >
                    View providers
                    <span>→</span>
                </a>

            </div>


            @if(($sproviders ?? collect())->count())

                <div class="connector-provider-grid">

                    @foreach($sproviders as $sprovider)

                        @if(!empty($sprovider->sprovider_name))

                            @php

                                $provWaPhone =
                                    preg_replace(
                                        '/\D+/',
                                        '',
                                        $sprovider->phone ?? $defaultWhatsapp
                                    );

                                $provWaMessage = rawurlencode(
                                    'Hello ' .
                                    $sprovider->sprovider_name .
                                    ', I found your profile on Connector and would like to get in touch.'
                                );

                            @endphp

                            <article class="connector-provider-card">

                                <a
                                    href="{{ route('home.service-provider_profile', ['sprovider_id' => $sprovider->id]) }}"
                                    class="connector-provider-favorite"
                                    aria-label="View provider profile"
                                >
                                    ♡
                                </a>


                                <div class="connector-provider-image">

                                    <a
                                        href="{{ route('home.service-provider_profile', ['sprovider_id' => $sprovider->id]) }}"
                                    >
                                        <img
                                            src="{{ asset('image/profile') }}/{{ $sprovider->image }}"
                                            alt="{{ $sprovider->sprovider_name }}"
                                        >
                                    </a>

                                </div>


                                <div class="connector-provider-body">

                                    <div class="connector-provider-name">
                                        {{ $sprovider->sprovider_name }}
                                    </div>

                                    <div class="connector-provider-category">

                                        @if($sprovider->service_category_id)
                                            {{ optional($sprovider->category)->name }}
                                        @else
                                            Service provider
                                        @endif

                                    </div>


                                    <div class="connector-provider-meta">

                                        <div class="connector-provider-meta-item">

                                            <span class="connector-provider-meta-label">
                                                Category
                                            </span>

                                            <span class="connector-provider-meta-value">

                                                @if($sprovider->service_category_id)
                                                    {{ optional($sprovider->category)->name }}
                                                @else
                                                    —
                                                @endif

                                            </span>

                                        </div>


                                        <div class="connector-provider-meta-item">

                                            <span class="connector-provider-meta-label">
                                                Location
                                            </span>

                                            <span class="connector-provider-meta-value">
                                                {{ $sprovider->city ?? '—' }}
                                            </span>

                                        </div>

                                    </div>


                                    <div class="connector-provider-actions">

                                        <a
                                            href="{{ route('home.service-provider_profile', ['sprovider_id' => $sprovider->id]) }}"
                                            class="connector-provider-view"
                                        >
                                            View profile
                                        </a>

                                        <a
                                            href="https://wa.me/{{ $provWaPhone }}?text={{ $provWaMessage }}"
                                            target="_blank"
                                            rel="noopener"
                                            class="connector-provider-message"
                                        >

                                            <svg
                                                width="14"
                                                height="14"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                            >
                                                <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.87 9.87 0 004.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2z"/>
                                            </svg>

                                            Message

                                        </a>

                                    </div>

                                </div>

                            </article>

                        @endif

                    @endforeach

                </div>

            @else

                <div class="connector-empty">
                    No service providers are currently available.
                </div>

            @endif

        </div>

    </section>


    {{-- =====================================================
         PROMOTIONS
    ====================================================== --}}
    <section class="connector-section connector-section-soft">

        <div class="connector-container">

            <div class="connector-section-header">

                <div>

                    <div class="connector-eyebrow">
                        Limited offers
                    </div>

                    <h2 class="connector-title">
                        Save on selected services
                    </h2>

                    <p class="connector-description">
                        Explore current promotions and connect with
                        providers before the offers expire.
                    </p>

                </div>

            </div>


            @php
                $activePromotions = collect($promotions ?? [])
                    ->filter(function ($promotion) {
                        return \Carbon\Carbon::now()->lessThanOrEqualTo($promotion->end_date);
                    });
            @endphp


            @if($activePromotions->count())

                <div class="connector-promotion-grid">

                    @foreach($activePromotions as $promotion)

                        @php

                            $promoTotal =
                                $promotion->service->price -
                                (
                                    $promotion->service->price *
                                    $promotion->discount /
                                    100
                                );

                            $promoWaPhone =
                                preg_replace(
                                    '/\D+/',
                                    '',
                                    optional(
                                        $promotion->service->sprovider ?? null
                                    )->phone ?? $defaultWhatsapp
                                );

                            $promoWaMessage = rawurlencode(
                                'Hello! I\'d like to book the promotion "' .
                                $promotion->title .
                                '" for ' .
                                number_format($promoTotal) .
                                ' RWF.'
                            );

                        @endphp


                        <article class="connector-promotion-card">

                            <span class="connector-promotion-badge">
                                {{ $promotion->discount }}% OFF
                            </span>


                            <div class="connector-promotion-image">

                                <img
                                    src="{{ asset('image/services') }}/{{ $promotion->service->image }}"
                                    alt="{{ $promotion->title }}"
                                >

                            </div>


                            <div class="connector-promotion-body">

                                <h3 class="connector-promotion-title">
                                    {{ $promotion->title }}
                                </h3>

                                <p class="connector-promotion-description">
                                    {{ Str::limit($promotion->description, 90) }}
                                </p>


                                <div class="connector-promotion-meta">

                                    <div>
                                        <span class="connector-promotion-meta-label">
                                            Now
                                        </span>

                                        <span class="connector-promotion-meta-value">
                                            {{ number_format($promoTotal) }} RWF
                                        </span>
                                    </div>

                                    <div>
                                        <span class="connector-promotion-meta-label">
                                            Duration
                                        </span>

                                        <span class="connector-promotion-meta-value">
                                            {{ $promotion->service->duration }}
                                        </span>
                                    </div>

                                    <div>
                                        <span class="connector-promotion-meta-label">
                                            Ends
                                        </span>

                                        <span class="connector-promotion-meta-value connector-promotion-end">
                                            {{ \Carbon\Carbon::parse($promotion->end_date)->format('d M') }}
                                        </span>
                                    </div>

                                </div>


                                <div class="connector-promotion-actions">

                                    <a
                                        href="{{ route('home.service_details', ['service_slug' => $promotion->service->slug]) }}"
                                        class="connector-action connector-action-primary"
                                    >
                                        View offer
                                    </a>

                                    <a
                                        href="https://wa.me/{{ $promoWaPhone }}?text={{ $promoWaMessage }}"
                                        target="_blank"
                                        rel="noopener"
                                        class="connector-action connector-action-whatsapp"
                                    >
                                        WhatsApp
                                    </a>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                <div class="connector-empty">
                    There are no active promotions right now.
                </div>

            @endif

        </div>

    </section>


    {{-- =====================================================
         HOW IT WORKS
    ====================================================== --}}
    <section class="connector-how">

        <div class="connector-container">

            <div class="connector-how-header">

                <div class="connector-eyebrow">
                    How Connector works
                </div>

                <h2 class="connector-how-title">
                    From search to service,
                    <span>without the hassle.</span>
                </h2>

                <p class="connector-how-description">
                    Connector makes it easier to discover professionals,
                    compare options and contact the right person for
                    your needs.
                </p>

            </div>


            <div class="connector-steps">

                <div class="connector-step">

                    <div class="connector-step-number">
                        01
                    </div>

                    <h3>
                        Create your account
                    </h3>

                    <p>
                        Join Connector and create your profile in just
                        a few minutes.
                    </p>

                    <a href="{{ route('register') }}">
                        Create account →
                    </a>

                </div>


                <div class="connector-step">

                    <div class="connector-step-number">
                        02
                    </div>

                    <h3>
                        Find what you need
                    </h3>

                    <p>
                        Search services or browse providers based on
                        your needs and location.
                    </p>

                    <a href="{{ route('home.services') }}">
                        Browse services →
                    </a>

                </div>


                <div class="connector-step">

                    <div class="connector-step-number">
                        03
                    </div>

                    <h3>
                        Connect and get it done
                    </h3>

                    <p>
                        Contact your chosen provider directly and
                        arrange the service.
                    </p>

                    <a href="{{ route('home.service_provider') }}">
                        Meet providers →
                    </a>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         CTA
    ====================================================== --}}
    <section class="connector-cta">

        <div class="connector-container">

            <div class="connector-cta-card">

                <div>

                    <h2>
                        Ready to get started?
                    </h2>

                    <p>
                        Find a service or join Connector as a professional.
                    </p>

                </div>


                <div class="connector-cta-actions">

                    <a
                        href="{{ route('home.services') }}"
                        class="connector-button connector-button-outline"
                    >
                        Find a service
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="connector-button connector-button-dark"
                    >
                        Join Connector
                    </a>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         BLOG
    ====================================================== --}}
    <section class="connector-section connector-section-soft">

        <div class="connector-container">

            <div class="connector-section-header">

                <div>

                    <div class="connector-eyebrow">
                        From the Connector blog
                    </div>

                    <h2 class="connector-title">
                        Ideas, guides & updates
                    </h2>

                </div>

                <a
                    href="{{ route('home.blogs') }}"
                    class="connector-view-all"
                >
                    View all articles
                    <span>→</span>
                </a>

            </div>


            @if(($blogs ?? collect())->count())

                <div class="connector-blog-grid">

                    @foreach($blogs as $blog)

                        <article class="connector-blog-card">

                            <div class="connector-blog-image">

                                <a
                                    href="{{ route('home.blog_detail', ['blog_slug' => $blog->slug]) }}"
                                >

                                    <img
                                        src="{{ asset('image/blog') }}/{{ $blog->image }}"
                                        alt="{{ $blog->title }}"
                                    >

                                </a>


                                <a
                                    href="{{ route('blogCategory.show', $blog->blog_category) }}"
                                    class="connector-blog-category"
                                >
                                    {{ $blog->blog_category }}
                                </a>

                            </div>


                            <div class="connector-blog-body">

                                <div class="connector-blog-author">

                                    <svg
                                        width="13"
                                        height="13"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <circle cx="12" cy="8" r="4"/>
                                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                                    </svg>


                                    @if($blog->author && $blog->author->utype === 'SVP')

                                        @php
                                            $blogProvider =
                                                \App\Models\ServiceProvider::where(
                                                    'user_id',
                                                    $blog->author->id
                                                )->first();
                                        @endphp

                                        @if($blogProvider)

                                            <a
                                                href="{{ url('/profile/' . $blogProvider->id) }}"
                                            >
                                                {{ $blog->author->name }}
                                            </a>

                                        @else

                                            <span>
                                                {{ $blog->author->name ?? 'Unknown' }}
                                            </span>

                                        @endif

                                    @else

                                        <span>
                                            {{ $blog->author->name ?? 'Unknown' }}
                                        </span>

                                    @endif

                                </div>


                                <a
                                    href="{{ route('home.blog_detail', ['blog_slug' => $blog->slug]) }}"
                                    class="connector-blog-title"
                                >
                                    {{ Str::limit($blog->title, 70) }}
                                </a>


                                <a
                                    href="{{ route('home.blog_detail', ['blog_slug' => $blog->slug]) }}"
                                    class="connector-blog-read"
                                >
                                    Continue reading
                                    <span>→</span>
                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                <div class="connector-empty">
                    No blog articles are currently available.
                </div>

            @endif

        </div>

    </section>


    {{-- =====================================================
         TESTIMONIALS
    ====================================================== --}}
    <section class="connector-section">

        <div class="connector-container">

            <div class="connector-section-header">

                <div>

                    <div class="connector-eyebrow">
                        Customer experiences
                    </div>

                    <h2 class="connector-title">
                        What people say about Connector
                    </h2>

                </div>

            </div>


            @if(($feedbacks ?? collect())->count())

                <div class="connector-testimonials">

                    @foreach($feedbacks as $feedback)

                        <article class="connector-testimonial">

                            <p class="connector-testimonial-quote">
                                “{{ $feedback->message }}”
                            </p>


                            <div class="connector-testimonial-footer">

                                <div class="connector-testimonial-name">
                                    {{ $feedback->name }}
                                </div>

                                <div
                                    class="connector-stars"
                                    aria-label="4.5 out of 5 stars"
                                >
                                    ★★★★☆
                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                <div class="connector-empty">
                    Customer testimonials will appear here.
                </div>

            @endif

        </div>

    </section>


    {{-- =====================================================
         PARTNERS
    ====================================================== --}}
    @if(($partners ?? collect())->count())

        <section class="connector-partners">

            <div class="connector-container">

                <div class="connector-partners-label">
                    Trusted by partners and organizations
                </div>

                <div class="connector-partner-list">

                    @foreach($partners as $partner)

                        <img
                            src="{{ asset('image/partner') }}/{{ $partner->image }}"
                            alt="{{ $partner->name }}"
                            loading="lazy"
                        >

                    @endforeach

                </div>

            </div>

        </section>

    @endif

</div>

@endsection