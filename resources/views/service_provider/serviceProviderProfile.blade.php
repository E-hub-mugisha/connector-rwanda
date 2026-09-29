@extends('layouts.base')

@section('title', 'Profile - ' . ($sprovider->user?->name ?? 'Service Provider'))

@section('content')

@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    /*
    |--------------------------------------------------------------------------
    | Safe / Display Variables
    |--------------------------------------------------------------------------
    */

    $providerName = trim($sprovider->user?->name ?? 'Service Provider');

    $categoryName = optional($sprovider->category)->name ?: 'Service Provider';

    $city = trim($sprovider->service_locations ?? '');

    $email = trim($sprovider->user?->email ?? '');

    $phone = trim(
        $sprovider->user?->phone
        ?? ($sprovider->phone ?? '')
    );

    $cleanPhone = preg_replace('/\D+/', '', $phone);

    $profileImage = !empty($sprovider->image)
        ? asset('image/profile/' . $sprovider->image)
        : asset('image/profile/default.png');

    $averageRating = (float) ($averageRating ?? 0);

    $ratingCount = (int) ($ratingCount ?? 0);

    $totalSales = (int) ($totalSales ?? 0);

    $serviceCount = (int) ($serviceCount ?? 0);

    $portfolioCount = (int) ($portfolioCount ?? 0);

    $reviewsAndFeedbackCount = (int) ($reviewsAndFeedbackCount ?? 0);

    $ratings = $ratings ?? collect();

    $feedback = $feedback ?? collect();

    $groupedServices = $groupedServices ?? collect();

    $activePromotions = $activePromotions ?? collect();

    $portfolios = $portfolios ?? collect();

    $workingHours = $sprovider->workingHours ?? collect();

    $profileUrl = url()->current();

    $hasAboutContent = $hasAboutContent ?? (
        filled($sprovider->about)
        || filled($sprovider->skills)
        || filled($sprovider->qualification)
        || filled($sprovider->experience)
    );

    /*
    |--------------------------------------------------------------------------
    | Working Hours
    |--------------------------------------------------------------------------
    */

    $workingHoursByDay = $workingHours->keyBy(function ($hour) {
        return strtolower(trim($hour->day ?? ''));
    });

    /*
    |--------------------------------------------------------------------------
    | Initials
    |--------------------------------------------------------------------------
    */

    $initials = collect(
        preg_split('/\s+/', $providerName, -1, PREG_SPLIT_NO_EMPTY)
    )
        ->take(2)
        ->map(fn ($word) => Str::upper(Str::substr($word, 0, 1)))
        ->implode('');

    /*
    |--------------------------------------------------------------------------
    | Google Maps
    |--------------------------------------------------------------------------
    */

    $mapQuery = $city ?: $providerName;

    /*
    |--------------------------------------------------------------------------
    | Provider Contact
    |--------------------------------------------------------------------------
    */

    $whatsappUrl = $cleanPhone
        ? 'https://wa.me/' . $cleanPhone
        : null;

    /*
    |--------------------------------------------------------------------------
    | Current Day
    |--------------------------------------------------------------------------
    */

    $today = strtolower(now()->format('l'));

    /*
    |--------------------------------------------------------------------------
    | Service Count
    |--------------------------------------------------------------------------
    */

    $displayedServiceCount = $serviceCount > 0
        ? $serviceCount
        : $groupedServices->flatten()->count();
@endphp


<style>
    /* =========================================================
       PROVIDER PROFILE
       ========================================================= */

    :root {
        --provider-primary: #6B9080;
        --provider-primary-dark: #254035;
        --provider-primary-soft: #EEF4F1;
        --provider-bg: #F7FAF8;
        --provider-card: #FFFFFF;
        --provider-text: #183028;
        --provider-muted: #65786F;
        --provider-border: #E3ECE7;
        --provider-gold: #C99A3B;
        --provider-danger: #C94A4A;
        --provider-shadow: 0 12px 35px rgba(37, 64, 53, .07);
        --provider-radius: 20px;
    }

    .provider-page {
        background: var(--provider-bg);
        min-height: 100vh;
        color: var(--provider-text);
        padding-bottom: 70px;
    }

    /* =========================================================
       HERO
       ========================================================= */

    .provider-hero {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(
                circle at 85% 15%,
                rgba(107, 144, 128, .18),
                transparent 32%
            ),
            linear-gradient(
                135deg,
                #254035 0%,
                #315646 55%,
                #6B9080 100%
            );
        color: #fff;
        padding: 48px 0 95px;
    }

    .provider-hero::before {
        content: "";
        position: absolute;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .04);
        top: -160px;
        right: -100px;
    }

    .provider-hero::after {
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, .08);
        bottom: -130px;
        left: 10%;
    }

    .provider-breadcrumb {
        position: relative;
        z-index: 2;
        margin-bottom: 35px;
    }

    .provider-breadcrumb a,
    .provider-breadcrumb span {
        color: rgba(255, 255, 255, .75);
        text-decoration: none;
        font-size: .88rem;
    }

    .provider-breadcrumb a:hover {
        color: #fff;
    }

    .provider-breadcrumb .separator {
        margin: 0 10px;
        opacity: .5;
    }

    .provider-hero-content {
        position: relative;
        z-index: 2;
    }

    .provider-profile-row {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .provider-avatar-wrap {
        position: relative;
        flex-shrink: 0;
    }

    .provider-avatar {
        width: 125px;
        height: 125px;
        object-fit: cover;
        border-radius: 28px;
        border: 5px solid rgba(255, 255, 255, .22);
        box-shadow: 0 15px 35px rgba(0, 0, 0, .18);
        background: #fff;
    }

    .provider-avatar-fallback {
        width: 125px;
        height: 125px;
        border-radius: 28px;
        background: rgba(255, 255, 255, .15);
        border: 5px solid rgba(255, 255, 255, .22);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        font-weight: 700;
    }

    .provider-online {
        position: absolute;
        right: 8px;
        bottom: 8px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #56D69A;
        border: 4px solid #315646;
    }

    .provider-hero-info {
        min-width: 0;
    }

    .provider-category {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        border-radius: 50px;
        background: rgba(255, 255, 255, .12);
        color: rgba(255, 255, 255, .92);
        font-size: .78rem;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .provider-title {
        font-size: clamp(2rem, 4vw, 3.1rem);
        line-height: 1.08;
        font-weight: 750;
        margin: 0 0 10px;
        letter-spacing: -.04em;
    }

    .provider-location {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, .72);
        font-size: .92rem;
    }

    .provider-location i {
        color: #D8E9E1;
    }

    .provider-actions {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .provider-action-btn {
        border: 0;
        min-height: 45px;
        padding: 0 17px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: .86rem;
        font-weight: 650;
        transition: all .2s ease;
        text-decoration: none;
    }

    .provider-action-primary {
        background: #fff;
        color: var(--provider-primary-dark);
    }

    .provider-action-primary:hover {
        background: #F2F7F4;
        color: var(--provider-primary-dark);
        transform: translateY(-2px);
    }

    .provider-action-outline {
        color: #fff;
        border: 1px solid rgba(255, 255, 255, .25);
        background: rgba(255, 255, 255, .08);
    }

    .provider-action-outline:hover {
        background: rgba(255, 255, 255, .16);
        color: #fff;
    }

    .provider-action-whatsapp {
        background: #fff;
        color: var(--provider-primary-dark);
    }

    .provider-action-whatsapp:hover {
        transform: translateY(-2px);
        color: var(--provider-primary-dark);
    }

    /* =========================================================
       STATS
       ========================================================= */

    .provider-stats {
        position: relative;
        z-index: 5;
        margin-top: -55px;
    }

    .provider-stats-card {
        background: #fff;
        border: 1px solid var(--provider-border);
        box-shadow: var(--provider-shadow);
        border-radius: 18px;
        padding: 20px 25px;
    }

    .provider-stat {
        display: flex;
        align-items: center;
        gap: 13px;
        min-height: 65px;
    }

    .provider-stat-icon {
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        border-radius: 13px;
        background: var(--provider-primary-soft);
        color: var(--provider-primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .provider-stat-value {
        font-size: 1.25rem;
        font-weight: 750;
        line-height: 1;
        color: var(--provider-primary-dark);
    }

    .provider-stat-label {
        font-size: .76rem;
        color: var(--provider-muted);
        margin-top: 5px;
    }

    .provider-stat-divider {
        width: 1px;
        height: 40px;
        background: var(--provider-border);
    }

    /* =========================================================
       NAVIGATION
       ========================================================= */

    .provider-tabs-wrapper {
        position: sticky;
        top: 10px;
        z-index: 30;
        margin-top: 28px;
    }

    .provider-tabs {
        display: flex;
        gap: 5px;
        overflow-x: auto;
        scrollbar-width: none;
        background: rgba(255, 255, 255, .95);
        backdrop-filter: blur(15px);
        border: 1px solid var(--provider-border);
        border-radius: 15px;
        padding: 6px;
        box-shadow: 0 8px 25px rgba(37, 64, 53, .05);
    }

    .provider-tabs::-webkit-scrollbar {
        display: none;
    }

    .provider-tab {
        flex: 0 0 auto;
        border: 0;
        background: transparent;
        color: var(--provider-muted);
        padding: 11px 16px;
        border-radius: 10px;
        font-size: .84rem;
        font-weight: 650;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all .2s ease;
        white-space: nowrap;
    }

    .provider-tab:hover {
        color: var(--provider-primary-dark);
        background: var(--provider-primary-soft);
    }

    .provider-tab.active {
        background: var(--provider-primary-dark);
        color: #fff;
        box-shadow: 0 5px 15px rgba(37, 64, 53, .15);
    }

    .provider-tab-count {
        min-width: 20px;
        height: 20px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .16);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .68rem;
    }

    .provider-tab:not(.active) .provider-tab-count {
        background: #E8F0EC;
    }

    /* =========================================================
       MAIN CONTENT
       ========================================================= */

    .provider-main {
        margin-top: 25px;
    }

    .provider-content-card {
        background: #fff;
        border: 1px solid var(--provider-border);
        border-radius: var(--provider-radius);
        box-shadow: 0 8px 25px rgba(37, 64, 53, .04);
        overflow: hidden;
    }

    .provider-section {
        padding: 30px;
    }

    .provider-section + .provider-section {
        border-top: 1px solid var(--provider-border);
    }

    .provider-section-heading {
        margin-bottom: 25px;
    }

    .provider-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: var(--provider-primary);
        text-transform: uppercase;
        letter-spacing: .1em;
        font-size: .68rem;
        font-weight: 750;
        margin-bottom: 7px;
    }

    .provider-section-title {
        font-size: 1.45rem;
        font-weight: 750;
        letter-spacing: -.025em;
        color: var(--provider-primary-dark);
        margin: 0;
    }

    .provider-section-description {
        color: var(--provider-muted);
        font-size: .87rem;
        margin: 7px 0 0;
    }

    /* =========================================================
       ABOUT
       ========================================================= */

    .provider-about {
        font-size: .94rem;
        line-height: 1.8;
        color: #52665D;
    }

    .provider-about p:last-child {
        margin-bottom: 0;
    }

    .provider-detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        margin-top: 25px;
    }

    .provider-detail-box {
        padding: 17px;
        background: #F8FBF9;
        border: 1px solid var(--provider-border);
        border-radius: 14px;
    }

    .provider-detail-label {
        font-size: .7rem;
        color: var(--provider-muted);
        text-transform: uppercase;
        letter-spacing: .06em;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .provider-detail-value {
        font-size: .9rem;
        color: var(--provider-text);
        font-weight: 600;
        line-height: 1.55;
    }

    /* =========================================================
       SKILLS
       ========================================================= */

    .provider-skills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .provider-skill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--provider-primary-soft);
        color: var(--provider-primary-dark);
        border-radius: 50px;
        padding: 8px 12px;
        font-size: .78rem;
        font-weight: 650;
    }

    /* =========================================================
       SERVICES
       ========================================================= */

    .service-category-block + .service-category-block {
        margin-top: 35px;
    }

    .service-category-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1rem;
        font-weight: 720;
        color: var(--provider-primary-dark);
        margin-bottom: 15px;
    }

    .service-category-title::before {
        content: "";
        width: 4px;
        height: 19px;
        border-radius: 5px;
        background: var(--provider-primary);
    }

    .provider-service-card {
        height: 100%;
        border: 1px solid var(--provider-border);
        border-radius: 17px;
        padding: 20px;
        background: #fff;
        transition: all .22s ease;
        display: flex;
        flex-direction: column;
    }

    .provider-service-card:hover {
        border-color: rgba(107, 144, 128, .5);
        box-shadow: 0 12px 28px rgba(37, 64, 53, .08);
        transform: translateY(-3px);
    }

    .service-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: var(--provider-primary-soft);
        color: var(--provider-primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }

    .service-name {
        font-size: 1rem;
        line-height: 1.35;
        font-weight: 720;
        color: var(--provider-primary-dark);
        margin-bottom: 8px;
    }

    .service-description {
        color: var(--provider-muted);
        font-size: .81rem;
        line-height: 1.65;
        margin-bottom: 15px;
        flex: 1;
    }

    .service-price-row {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding-top: 15px;
        border-top: 1px solid var(--provider-border);
    }

    .service-price {
        color: var(--provider-primary-dark);
        font-weight: 750;
        font-size: 1rem;
    }

    .service-old-price {
        color: #9AA9A2;
        font-size: .75rem;
        text-decoration: line-through;
        margin-left: 5px;
    }

    .service-discount {
        display: inline-flex;
        align-items: center;
        padding: 4px 7px;
        border-radius: 7px;
        background: #F9F1DF;
        color: #8A641C;
        font-size: .67rem;
        font-weight: 750;
        white-space: nowrap;
    }

    .service-action {
        border: 0;
        background: var(--provider-primary-dark);
        color: #fff;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all .2s ease;
    }

    .service-action:hover {
        background: var(--provider-primary);
        color: #fff;
    }

    /* =========================================================
       PROMOTIONS
       ========================================================= */

    .promotion-card {
        border: 1px solid var(--provider-border);
        background: linear-gradient(135deg, #F9FCFA, #F1F7F4);
        border-radius: 17px;
        overflow: hidden;
        height: 100%;
    }

    .promotion-image {
        width: 100%;
        height: 155px;
        object-fit: cover;
        background: #EAF1ED;
    }

    .promotion-content {
        padding: 17px;
    }

    .promotion-badge {
        display: inline-flex;
        padding: 5px 8px;
        background: var(--provider-primary-dark);
        color: #fff;
        border-radius: 7px;
        font-size: .66rem;
        font-weight: 750;
        margin-bottom: 10px;
    }

    .promotion-title {
        font-size: .94rem;
        font-weight: 720;
        color: var(--provider-primary-dark);
        margin-bottom: 7px;
    }

    .promotion-meta {
        color: var(--provider-muted);
        font-size: .76rem;
    }

    /* =========================================================
       PORTFOLIO
       ========================================================= */

    .portfolio-card {
        position: relative;
        overflow: hidden;
        border-radius: 17px;
        border: 1px solid var(--provider-border);
        background: #fff;
        height: 100%;
        transition: all .22s ease;
    }

    .portfolio-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(37, 64, 53, .1);
    }

    .portfolio-image-wrap {
        position: relative;
        overflow: hidden;
        background: #EDF3F0;
        aspect-ratio: 4 / 3;
    }

    .portfolio-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .35s ease;
    }

    .portfolio-card:hover .portfolio-image {
        transform: scale(1.04);
    }

    .portfolio-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to top,
            rgba(20, 43, 35, .75),
            transparent 60%
        );
        opacity: 0;
        transition: opacity .25s ease;
    }

    .portfolio-card:hover .portfolio-overlay {
        opacity: 1;
    }

    .portfolio-content {
        padding: 16px;
    }

    .portfolio-title {
        color: var(--provider-primary-dark);
        font-size: .91rem;
        font-weight: 720;
        margin-bottom: 5px;
    }

    .portfolio-service-name {
        color: var(--provider-muted);
        font-size: .74rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* =========================================================
       REVIEWS
       ========================================================= */

    .rating-summary {
        display: flex;
        align-items: center;
        gap: 25px;
        padding: 20px;
        background: var(--provider-primary-soft);
        border-radius: 17px;
        margin-bottom: 25px;
    }

    .rating-big {
        text-align: center;
        min-width: 90px;
    }

    .rating-number {
        color: var(--provider-primary-dark);
        font-size: 2.3rem;
        line-height: 1;
        font-weight: 800;
    }

    .rating-stars {
        color: var(--provider-gold);
        letter-spacing: 1px;
        font-size: .84rem;
        margin-top: 8px;
    }

    .rating-count {
        color: var(--provider-muted);
        font-size: .72rem;
        margin-top: 4px;
    }

    .rating-summary-text {
        color: var(--provider-muted);
        font-size: .83rem;
        line-height: 1.6;
    }

    .review-card {
        padding: 20px 0;
        border-bottom: 1px solid var(--provider-border);
    }

    .review-card:last-child {
        border-bottom: 0;
    }

    .review-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }

    .review-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--provider-primary-soft);
        color: var(--provider-primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 750;
        font-size: .84rem;
        flex-shrink: 0;
    }

    .review-author {
        color: var(--provider-primary-dark);
        font-weight: 700;
        font-size: .87rem;
    }

    .review-date {
        color: var(--provider-muted);
        font-size: .71rem;
        margin-top: 2px;
    }

    .review-rating {
        margin-left: auto;
        color: var(--provider-gold);
        font-size: .74rem;
    }

    .review-text {
        color: #5D7067;
        font-size: .84rem;
        line-height: 1.7;
        margin: 0;
    }

    /* =========================================================
       FEEDBACK
       ========================================================= */

    .feedback-card {
        background: #F9FBFA;
        border: 1px solid var(--provider-border);
        border-radius: 16px;
        padding: 20px;
        height: 100%;
    }

    .feedback-quote {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: var(--provider-primary-soft);
        color: var(--provider-primary);
        margin-bottom: 13px;
    }

    .feedback-text {
        color: #566A61;
        font-size: .83rem;
        line-height: 1.7;
    }

    .feedback-author {
        color: var(--provider-primary-dark);
        font-size: .78rem;
        font-weight: 700;
        margin-top: 13px;
    }

    /* =========================================================
       SIDEBAR
       ========================================================= */

    .provider-sidebar-card {
        background: #fff;
        border: 1px solid var(--provider-border);
        border-radius: var(--provider-radius);
        box-shadow: 0 8px 25px rgba(37, 64, 53, .04);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .provider-sidebar-section {
        padding: 22px;
    }

    .provider-sidebar-section + .provider-sidebar-section {
        border-top: 1px solid var(--provider-border);
    }

    .sidebar-title {
        color: var(--provider-primary-dark);
        font-size: .88rem;
        font-weight: 750;
        margin-bottom: 17px;
    }

    .sidebar-info {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
    }

    .sidebar-info:last-child {
        margin-bottom: 0;
    }

    .sidebar-info-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--provider-primary-soft);
        color: var(--provider-primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: .8rem;
    }

    .sidebar-info-label {
        font-size: .68rem;
        color: var(--provider-muted);
        margin-bottom: 2px;
    }

    .sidebar-info-value {
        color: var(--provider-text);
        font-size: .81rem;
        font-weight: 620;
        line-height: 1.45;
        word-break: break-word;
    }

    .sidebar-link {
        color: var(--provider-primary-dark);
        text-decoration: none;
    }

    .sidebar-link:hover {
        color: var(--provider-primary);
    }

    /* =========================================================
       HOURS
       ========================================================= */

    .hours-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 0;
        font-size: .77rem;
        border-bottom: 1px solid #F0F4F2;
    }

    .hours-row:last-child {
        border-bottom: 0;
    }

    .hours-day {
        color: var(--provider-muted);
    }

    .hours-time {
        color: var(--provider-text);
        font-weight: 650;
    }

    .hours-today .hours-day {
        color: var(--provider-primary-dark);
        font-weight: 750;
    }

    .hours-closed {
        color: #A36C6C;
    }

    /* =========================================================
       CONTACT
       ========================================================= */

    .contact-option {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 15px;
        border: 1px solid var(--provider-border);
        border-radius: 14px;
        text-decoration: none;
        color: var(--provider-text);
        transition: all .2s ease;
        height: 100%;
    }

    .contact-option:hover {
        color: var(--provider-primary-dark);
        border-color: rgba(107, 144, 128, .55);
        background: var(--provider-primary-soft);
        transform: translateY(-2px);
    }

    .contact-option-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: var(--provider-primary-soft);
        color: var(--provider-primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .contact-option-title {
        font-size: .82rem;
        font-weight: 720;
    }

    .contact-option-text {
        color: var(--provider-muted);
        font-size: .72rem;
        margin-top: 2px;
        word-break: break-word;
    }

    .contact-form-label {
        color: var(--provider-primary-dark);
        font-size: .77rem;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .contact-form-control {
        border: 1px solid var(--provider-border);
        border-radius: 11px;
        min-height: 45px;
        font-size: .83rem;
        box-shadow: none !important;
    }

    .contact-form-control:focus {
        border-color: var(--provider-primary);
    }

    textarea.contact-form-control {
        min-height: 120px;
        resize: vertical;
    }

    .provider-submit-btn {
        min-height: 45px;
        border: 0;
        border-radius: 11px;
        background: var(--provider-primary-dark);
        color: #fff;
        padding: 0 20px;
        font-size: .81rem;
        font-weight: 700;
    }

    .provider-submit-btn:hover {
        background: var(--provider-primary);
        color: #fff;
    }

    /* =========================================================
       EMPTY STATE
       ========================================================= */

    .provider-empty {
        text-align: center;
        padding: 45px 20px;
        border: 1px dashed #D5E2DC;
        border-radius: 16px;
        background: #FAFCFB;
    }

    .provider-empty-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        margin: 0 auto 15px;
        background: var(--provider-primary-soft);
        color: var(--provider-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .provider-empty h5 {
        color: var(--provider-primary-dark);
        font-size: .95rem;
        font-weight: 750;
    }

    .provider-empty p {
        color: var(--provider-muted);
        font-size: .78rem;
        margin: 5px 0 0;
    }

    /* =========================================================
       SHARE
       ========================================================= */

    .share-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .share-button {
        width: 38px;
        height: 38px;
        border: 1px solid var(--provider-border);
        border-radius: 10px;
        background: #fff;
        color: var(--provider-primary-dark);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        cursor: pointer;
        transition: all .2s ease;
    }

    .share-button:hover {
        background: var(--provider-primary-soft);
        color: var(--provider-primary-dark);
        border-color: #C9DAD2;
    }

    /* =========================================================
       MAP
       ========================================================= */

    .provider-map {
        width: 100%;
        height: 300px;
        border: 0;
        border-radius: 15px;
    }

    /* =========================================================
       MODAL
       ========================================================= */

    .provider-modal .modal-content {
        border: 0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 25px 70px rgba(0, 0, 0, .16);
    }

    .provider-modal .modal-header {
        border-bottom: 1px solid var(--provider-border);
        padding: 20px 22px;
    }

    .provider-modal .modal-title {
        color: var(--provider-primary-dark);
        font-size: 1rem;
        font-weight: 750;
    }

    .provider-modal .modal-body {
        padding: 22px;
    }

    .provider-modal .modal-footer {
        border-top: 1px solid var(--provider-border);
        padding: 15px 22px;
    }

    .feedback-textarea {
        width: 100%;
        min-height: 140px;
        resize: vertical;
        border: 1px solid var(--provider-border);
        border-radius: 12px;
        padding: 13px;
        font-size: .83rem;
        outline: none;
    }

    .feedback-textarea:focus {
        border-color: var(--provider-primary);
    }

    /* =========================================================
       TOAST
       ========================================================= */

    .provider-toast {
        position: fixed;
        right: 20px;
        bottom: 20px;
        z-index: 2000;
        display: none;
        background: var(--provider-primary-dark);
        color: #fff;
        padding: 12px 16px;
        border-radius: 11px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
        font-size: .78rem;
        font-weight: 650;
    }

    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 991.98px) {
        .provider-hero {
            padding-bottom: 80px;
        }

        .provider-profile-row {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .provider-actions {
            width: 100%;
            margin-left: 0;
        }

        .provider-sidebar {
            margin-top: 25px;
        }

        .provider-tabs-wrapper {
            top: 0;
        }
    }

    @media (max-width: 767.98px) {
        .provider-hero {
            padding: 30px 0 75px;
        }

        .provider-profile-row {
            gap: 17px;
        }

        .provider-avatar,
        .provider-avatar-fallback {
            width: 85px;
            height: 85px;
            border-radius: 21px;
        }

        .provider-avatar-fallback {
            font-size: 1.6rem;
        }

        .provider-title {
            font-size: 1.75rem;
        }

        .provider-category {
            font-size: .7rem;
            padding: 6px 10px;
            margin-bottom: 8px;
        }

        .provider-location {
            font-size: .78rem;
        }

        .provider-actions {
            gap: 7px;
        }

        .provider-action-btn {
            flex: 1;
            padding: 0 10px;
            min-height: 42px;
            font-size: .75rem;
        }

        .provider-action-btn span {
            display: none;
        }

        .provider-stats {
            margin-top: -42px;
        }

        .provider-stats-card {
            padding: 10px;
        }

        .provider-stat {
            padding: 8px;
            min-height: 55px;
        }

        .provider-stat-icon {
            width: 37px;
            height: 37px;
            border-radius: 10px;
        }

        .provider-stat-value {
            font-size: 1rem;
        }

        .provider-stat-label {
            font-size: .65rem;
        }

        .provider-stat-divider {
            height: 35px;
        }

        .provider-section {
            padding: 21px;
        }

        .provider-section-title {
            font-size: 1.2rem;
        }

        .provider-detail-grid {
            grid-template-columns: 1fr;
        }

        .rating-summary {
            align-items: flex-start;
            gap: 15px;
            padding: 16px;
        }

        .rating-big {
            min-width: 75px;
        }

        .rating-number {
            font-size: 1.9rem;
        }

        .provider-map {
            height: 240px;
        }
    }

    @media (max-width: 575.98px) {
        .provider-hero-content {
            padding: 0 3px;
        }

        .provider-stats-card .row {
            flex-wrap: nowrap;
        }

        .provider-stat-divider {
            display: none;
        }

        .provider-stat {
            flex-direction: column;
            text-align: center;
            gap: 6px;
        }

        .provider-stat-label {
            line-height: 1.2;
        }

        .provider-tabs {
            border-radius: 12px;
        }

        .provider-tab {
            padding: 10px 12px;
            font-size: .75rem;
        }

        .provider-section {
            padding: 18px;
        }

        .provider-profile-row {
            display: grid;
            grid-template-columns: auto 1fr;
        }

        .provider-actions {
            grid-column: 1 / -1;
        }

        .provider-action-btn {
            display: flex;
        }

        .provider-action-btn span {
            display: inline;
        }
    }
</style>


<div class="provider-page">

    {{-- =========================================================
         HERO
    ========================================================== --}}
    <section class="provider-hero">

        <div class="container">

            <div class="provider-breadcrumb">
                <a href="{{ url('/') }}">
                    <i class="fa-solid fa-house"></i>
                    Home
                </a>

                <span class="separator">/</span>

                <span>{{ $providerName }}</span>
            </div>

            <div class="provider-hero-content">

                <div class="provider-profile-row">

                    <div class="provider-avatar-wrap">

                        @if($profileImage)
                            <img
                                src="{{ $profileImage }}"
                                alt="{{ $providerName }}"
                                class="provider-avatar"
                                loading="eager"
                            >
                        @else
                            <div class="provider-avatar-fallback">
                                {{ $initials ?: 'SP' }}
                            </div>
                        @endif

                        <span
                            class="provider-online"
                            title="Service provider"
                        ></span>

                    </div>


                    <div class="provider-hero-info">

                        <div class="provider-category">
                            <i class="fa-solid fa-briefcase"></i>
                            {{ $categoryName }}
                        </div>

                        <h1 class="provider-title">
                            {{ $providerName }}
                        </h1>

                        @if($city)
                            <div class="provider-location">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>{{ $city }}</span>
                            </div>
                        @endif

                    </div>


                    <div class="provider-actions">

                        <button
                            type="button"
                            class="provider-action-btn provider-action-primary"
                            onclick="switchProfileTab('contact')"
                        >
                            <i class="fa-regular fa-paper-plane"></i>
                            <span>Contact</span>
                        </button>

                        @if($whatsappUrl)
                            <a
                                href="{{ $whatsappUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="provider-action-btn provider-action-whatsapp"
                            >
                                <i class="fa-brands fa-whatsapp"></i>
                                <span>WhatsApp</span>
                            </a>
                        @endif

                        <button
                            type="button"
                            class="provider-action-btn provider-action-outline"
                            onclick="shareProvider()"
                        >
                            <i class="fa-solid fa-share-nodes"></i>
                            <span>Share</span>
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
         STATS
    ========================================================== --}}
    <div class="container provider-stats">

        <div class="provider-stats-card">

            <div class="row align-items-center">

                <div class="col">
                    <div class="provider-stat">

                        <div class="provider-stat-icon">
                            <i class="fa-solid fa-star"></i>
                        </div>

                        <div>
                            <div class="provider-stat-value">
                                {{ number_format($averageRating, 1) }}
                            </div>

                            <div class="provider-stat-label">
                                Rating
                            </div>
                        </div>

                    </div>
                </div>


                <div class="col-auto">
                    <div class="provider-stat-divider"></div>
                </div>


                <div class="col">
                    <div class="provider-stat">

                        <div class="provider-stat-icon">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>

                        <div>
                            <div class="provider-stat-value">
                                {{ $displayedServiceCount }}
                            </div>

                            <div class="provider-stat-label">
                                Services
                            </div>
                        </div>

                    </div>
                </div>


                <div class="col-auto">
                    <div class="provider-stat-divider"></div>
                </div>


                <div class="col">
                    <div class="provider-stat">

                        <div class="provider-stat-icon">
                            <i class="fa-solid fa-check"></i>
                        </div>

                        <div>
                            <div class="provider-stat-value">
                                {{ $totalSales }}
                            </div>

                            <div class="provider-stat-label">
                                Completed
                            </div>
                        </div>

                    </div>
                </div>


                <div class="col-auto">
                    <div class="provider-stat-divider"></div>
                </div>


                <div class="col">
                    <div class="provider-stat">

                        <div class="provider-stat-icon">
                            <i class="fa-solid fa-images"></i>
                        </div>

                        <div>
                            <div class="provider-stat-value">
                                {{ $portfolioCount }}
                            </div>

                            <div class="provider-stat-label">
                                Portfolio
                            </div>
                        </div>

                    </div>
                </div>


                <div class="col-auto">
                    <div class="provider-stat-divider"></div>
                </div>


                <div class="col">
                    <div class="provider-stat">

                        <div class="provider-stat-icon">
                            <i class="fa-regular fa-message"></i>
                        </div>

                        <div>
                            <div class="provider-stat-value">
                                {{ $reviewsAndFeedbackCount }}
                            </div>

                            <div class="provider-stat-label">
                                Reviews
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>


    <div class="container">

        {{-- =====================================================
             TABS
        ====================================================== --}}
        <div class="provider-tabs-wrapper">

            <nav class="provider-tabs" id="providerTabs">

                <button
                    type="button"
                    class="provider-tab active"
                    data-tab="overview"
                    onclick="switchProfileTab('overview')"
                >
                    <i class="fa-regular fa-user"></i>
                    Overview
                </button>


                <button
                    type="button"
                    class="provider-tab"
                    data-tab="services"
                    onclick="switchProfileTab('services')"
                >
                    <i class="fa-solid fa-briefcase"></i>
                    Services

                    <span class="provider-tab-count">
                        {{ $displayedServiceCount }}
                    </span>
                </button>


                @if($portfolioCount > 0)
                    <button
                        type="button"
                        class="provider-tab"
                        data-tab="portfolio"
                        onclick="switchProfileTab('portfolio')"
                    >
                        <i class="fa-solid fa-images"></i>
                        Portfolio

                        <span class="provider-tab-count">
                            {{ $portfolioCount }}
                        </span>
                    </button>
                @endif


                <button
                    type="button"
                    class="provider-tab"
                    data-tab="reviews"
                    onclick="switchProfileTab('reviews')"
                >
                    <i class="fa-regular fa-star"></i>
                    Reviews

                    <span class="provider-tab-count">
                        {{ $reviewsAndFeedbackCount }}
                    </span>
                </button>


                <button
                    type="button"
                    class="provider-tab"
                    data-tab="contact"
                    onclick="switchProfileTab('contact')"
                >
                    <i class="fa-regular fa-paper-plane"></i>
                    Contact
                </button>

            </nav>

        </div>


        {{-- =====================================================
             MAIN
        ====================================================== --}}
        <div class="provider-main">

            <div class="row g-4">

                {{-- =================================================
                     LEFT / MAIN CONTENT
                ================================================== --}}
                <div class="col-lg-8">


                    {{-- =============================================
                         OVERVIEW
                    ============================================== --}}
                    <div
                        class="provider-tab-content"
                        id="tab-overview"
                    >

                        <div class="provider-content-card">

                            @if($hasAboutContent)

                                <section class="provider-section">

                                    <div class="provider-section-heading">

                                        <div class="provider-eyebrow">
                                            <i class="fa-solid fa-circle-info"></i>
                                            About
                                        </div>

                                        <h2 class="provider-section-title">
                                            About {{ $providerName }}
                                        </h2>

                                    </div>


                                    @if(filled($sprovider->about))
                                        <div class="provider-about">
                                            {!! nl2br(e($sprovider->about)) !!}
                                        </div>
                                    @endif


                                    <div class="provider-detail-grid">

                                        @if(filled($sprovider->qualification))

                                            <div class="provider-detail-box">

                                                <div class="provider-detail-label">
                                                    Qualification
                                                </div>

                                                <div class="provider-detail-value">
                                                    {!! nl2br(e($sprovider->qualification)) !!}
                                                </div>

                                            </div>

                                        @endif


                                        @if(filled($sprovider->experience))

                                            <div class="provider-detail-box">

                                                <div class="provider-detail-label">
                                                    Experience
                                                </div>

                                                <div class="provider-detail-value">
                                                    {!! nl2br(e($sprovider->experience)) !!}
                                                </div>

                                            </div>

                                        @endif

                                    </div>

                                </section>


                                @if(filled($sprovider->skills))

                                    <section class="provider-section">

                                        <div class="provider-section-heading">

                                            <div class="provider-eyebrow">
                                                <i class="fa-solid fa-layer-group"></i>
                                                Expertise
                                            </div>

                                            <h2 class="provider-section-title">
                                                Skills & Expertise
                                            </h2>

                                        </div>

                                        <div class="provider-skills">

                                            @foreach(
                                                preg_split(
                                                    '/[,;\n]+/',
                                                    $sprovider->skills,
                                                    -1,
                                                    PREG_SPLIT_NO_EMPTY
                                                ) as $skill
                                            )

                                                <span class="provider-skill">
                                                    <i class="fa-solid fa-check"></i>
                                                    {{ trim($skill) }}
                                                </span>

                                            @endforeach

                                        </div>

                                    </section>

                                @endif

                            @else

                                <section class="provider-section">

                                    <div class="provider-empty">

                                        <div class="provider-empty-icon">
                                            <i class="fa-regular fa-user"></i>
                                        </div>

                                        <h5>
                                            Profile information coming soon
                                        </h5>

                                        <p>
                                            More information about this service provider
                                            will be available here.
                                        </p>

                                    </div>

                                </section>

                            @endif


                            {{-- =====================================
                                 PROMOTIONS
                            ====================================== --}}
                            @if($activePromotions->isNotEmpty())

                                <section class="provider-section">

                                    <div class="provider-section-heading">

                                        <div class="provider-eyebrow">
                                            <i class="fa-solid fa-tag"></i>
                                            Special offers
                                        </div>

                                        <h2 class="provider-section-title">
                                            Current Promotions
                                        </h2>

                                        <p class="provider-section-description">
                                            Explore current offers from this provider.
                                        </p>

                                    </div>


                                    <div class="row g-3">

                                        @foreach($activePromotions as $promotion)

                                            @php
                                                $promotionEndDate = $promotion->end_date
                                                    ? Carbon::parse($promotion->end_date)
                                                    : null;

                                                $promotionService = $promotion->service;

                                                $promotionCategory = $promotion->category;

                                                $promotionImage = null;

                                                if ($promotionService?->image) {
                                                    $promotionImage = asset(
                                                        'image/services/' . $promotionService->image
                                                    );
                                                } elseif ($promotion->image ?? null) {
                                                    $promotionImage = asset(
                                                        'image/promotions/' . $promotion->image
                                                    );
                                                }
                                            @endphp

                                            <div class="col-md-6">

                                                <div class="promotion-card">

                                                    @if($promotionImage)

                                                        <img
                                                            src="{{ $promotionImage }}"
                                                            alt="{{ $promotionService?->name ?? 'Promotion' }}"
                                                            class="promotion-image"
                                                            loading="lazy"
                                                        >

                                                    @endif

                                                    <div class="promotion-content">

                                                        @if(isset($promotion->discount) && $promotion->discount)
                                                            <span class="promotion-badge">
                                                                {{ $promotion->discount }}
                                                                @if(($promotion->discount_type ?? null) === 'percentage')
                                                                    % OFF
                                                                @else
                                                                    OFF
                                                                @endif
                                                            </span>
                                                        @else
                                                            <span class="promotion-badge">
                                                                Special Offer
                                                            </span>
                                                        @endif

                                                        <div class="promotion-title">
                                                            {{ $promotionService?->name
                                                                ?? $promotionCategory?->name
                                                                ?? 'Special promotion' }}
                                                        </div>

                                                        @if($promotionEndDate)
                                                            <div class="promotion-meta">
                                                                <i class="fa-regular fa-clock me-1"></i>
                                                                Available until
                                                                {{ $promotionEndDate->format('d M Y') }}
                                                            </div>
                                                        @endif

                                                    </div>

                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                </section>

                            @endif

                        </div>

                    </div>


                    {{-- =============================================
                         SERVICES
                    ============================================== --}}
                    <div
                        class="provider-tab-content d-none"
                        id="tab-services"
                    >

                        <div class="provider-content-card">

                            <section class="provider-section">

                                <div class="provider-section-heading">

                                    <div class="provider-eyebrow">
                                        <i class="fa-solid fa-briefcase"></i>
                                        What we offer
                                    </div>

                                    <h2 class="provider-section-title">
                                        Services
                                    </h2>

                                    <p class="provider-section-description">
                                        Browse the services offered by {{ $providerName }}.
                                    </p>

                                </div>


                                @if($groupedServices->isNotEmpty())

                                    @foreach($groupedServices as $subcategoryName => $services)

                                        <div class="service-category-block">

                                            <div class="service-category-title">
                                                {{ $subcategoryName }}
                                            </div>


                                            <div class="row g-3">

                                                @foreach($services as $service)

                                                    @php
                                                        $hasDiscount = filled($service->discount)
                                                            && (float) $service->discount > 0;

                                                        $originalPrice = (float) ($service->price ?? 0);

                                                        $discountValue = (float) ($service->discount ?? 0);

                                                        $discountType = strtolower(
                                                            $service->discount_type ?? 'percentage'
                                                        );

                                                        $finalPrice = $originalPrice;

                                                        if ($hasDiscount) {
                                                            if (
                                                                in_array(
                                                                    $discountType,
                                                                    ['percentage', '%', 'percent']
                                                                )
                                                            ) {
                                                                $finalPrice = max(
                                                                    0,
                                                                    $originalPrice -
                                                                    ($originalPrice * $discountValue / 100)
                                                                );
                                                            } else {
                                                                $finalPrice = max(
                                                                    0,
                                                                    $originalPrice - $discountValue
                                                                );
                                                            }
                                                        }

                                                        $serviceDescription = $service->description
                                                            ?? $service->details
                                                            ?? null;
                                                    @endphp

                                                    <div class="col-md-6">

                                                        <article class="provider-service-card">

                                                            <div class="service-icon">
                                                                <i class="fa-solid fa-briefcase"></i>
                                                            </div>


                                                            <div class="service-name">
                                                                {{ $service->name }}
                                                            </div>


                                                            @if($serviceDescription)
                                                                <div class="service-description">
                                                                    {{ Str::limit(
                                                                        strip_tags($serviceDescription),
                                                                        125
                                                                    ) }}
                                                                </div>
                                                            @else
                                                                <div class="service-description">
                                                                    Professional service
                                                                    provided by {{ $providerName }}.
                                                                </div>
                                                            @endif


                                                            <div class="service-price-row">

                                                                <div>

                                                                    @if($originalPrice > 0)

                                                                        @if($hasDiscount)

                                                                            <span class="service-price">
                                                                                {{ number_format($finalPrice, 0) }}
                                                                            </span>

                                                                            <span class="service-old-price">
                                                                                {{ number_format($originalPrice, 0) }}
                                                                            </span>

                                                                        @else

                                                                            <span class="service-price">
                                                                                {{ number_format($originalPrice, 0) }}
                                                                            </span>

                                                                        @endif

                                                                        <small class="text-muted">
                                                                            RWF
                                                                        </small>

                                                                    @else

                                                                        <span class="service-price">
                                                                            Contact provider
                                                                        </span>

                                                                    @endif

                                                                </div>


                                                                @if($hasDiscount)

                                                                    <span class="service-discount">

                                                                        @if(
                                                                            in_array(
                                                                                $discountType,
                                                                                ['percentage', '%', 'percent']
                                                                            )
                                                                        )
                                                                            -{{ $discountValue }}%
                                                                        @else
                                                                            -{{ number_format($discountValue, 0) }}
                                                                        @endif

                                                                    </span>

                                                                @endif


                                                                @if($service->slug)

                                                                    <a
                                                                        href="{{ route(
                                                                            'home.service_details',
                                                                            ['service_slug' => $service->slug]
                                                                        ) }}"
                                                                        class="service-action"
                                                                        title="View service"
                                                                    >
                                                                        <i class="fa-solid fa-arrow-right"></i>
                                                                    </a>

                                                                @endif

                                                            </div>

                                                        </article>

                                                    </div>

                                                @endforeach

                                            </div>

                                        </div>

                                    @endforeach

                                @else

                                    <div class="provider-empty">

                                        <div class="provider-empty-icon">
                                            <i class="fa-solid fa-briefcase"></i>
                                        </div>

                                        <h5>
                                            No services available
                                        </h5>

                                        <p>
                                            This provider has not published any services yet.
                                        </p>

                                    </div>

                                @endif

                            </section>

                        </div>

                    </div>


                    {{-- =============================================
                         PORTFOLIO
                    ============================================== --}}
                    @if($portfolioCount > 0)

                        <div
                            class="provider-tab-content d-none"
                            id="tab-portfolio"
                        >

                            <div class="provider-content-card">

                                <section class="provider-section">

                                    <div class="provider-section-heading">

                                        <div class="provider-eyebrow">
                                            <i class="fa-solid fa-images"></i>
                                            Recent work
                                        </div>

                                        <h2 class="provider-section-title">
                                            Portfolio
                                        </h2>

                                        <p class="provider-section-description">
                                            A selection of work completed through the
                                            services offered by {{ $providerName }}.
                                        </p>

                                    </div>


                                    <div class="row g-3">

                                        @foreach($portfolios as $portfolio)

                                            @php
                                                $portfolioImage = !empty($portfolio->image)
                                                    ? asset(
                                                        'image/portfolios/' .
                                                        $portfolio->image
                                                    )
                                                    : asset('image/profile/default.png');

                                                $portfolioTitle =
                                                    $portfolio->title
                                                    ?? $portfolio->name
                                                    ?? 'Portfolio project';

                                                $portfolioService =
                                                    $portfolio->service?->name;
                                            @endphp

                                            <div class="col-sm-6">

                                                <article class="portfolio-card">

                                                    <div class="portfolio-image-wrap">

                                                        <img
                                                            src="{{ $portfolioImage }}"
                                                            alt="{{ $portfolioTitle }}"
                                                            class="portfolio-image"
                                                            loading="lazy"
                                                        >

                                                        <div class="portfolio-overlay"></div>

                                                    </div>


                                                    <div class="portfolio-content">

                                                        <div class="portfolio-title">
                                                            {{ $portfolioTitle }}
                                                        </div>

                                                        @if($portfolioService)

                                                            <div class="portfolio-service-name">
                                                                <i class="fa-solid fa-briefcase"></i>
                                                                {{ $portfolioService }}
                                                            </div>

                                                        @endif

                                                    </div>

                                                </article>

                                            </div>

                                        @endforeach

                                    </div>

                                </section>

                            </div>

                        </div>

                    @endif


                    {{-- =============================================
                         REVIEWS
                    ============================================== --}}
                    <div
                        class="provider-tab-content d-none"
                        id="tab-reviews"
                    >

                        <div class="provider-content-card">

                            <section class="provider-section">

                                <div class="provider-section-heading">

                                    <div class="provider-eyebrow">
                                        <i class="fa-regular fa-star"></i>
                                        Client experience
                                    </div>

                                    <h2 class="provider-section-title">
                                        Reviews & Feedback
                                    </h2>

                                </div>


                                <div class="rating-summary">

                                    <div class="rating-big">

                                        <div class="rating-number">
                                            {{ number_format($averageRating, 1) }}
                                        </div>

                                        <div class="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)

                                                @if($averageRating >= $i)
                                                    <i class="fa-solid fa-star"></i>
                                                @elseif($averageRating >= ($i - .5))
                                                    <i class="fa-solid fa-star-half-stroke"></i>
                                                @else
                                                    <i class="fa-regular fa-star"></i>
                                                @endif

                                            @endfor
                                        </div>

                                        <div class="rating-count">
                                            {{ $ratingCount }}
                                            {{ Str::plural('rating', $ratingCount) }}
                                        </div>

                                    </div>


                                    <div class="rating-summary-text">
                                        Ratings are based on approved client reviews
                                        for services provided by {{ $providerName }}.
                                    </div>

                                </div>


                                {{-- Add Rating --}}
                                @auth

                                    <div class="provider-detail-box mb-4">

                                        <div class="provider-detail-label mb-3">
                                            Rate this provider
                                        </div>

                                        <form
                                            action="{{ route('rating.store') }}"
                                            method="POST"
                                        >
                                            @csrf

                                            <input
                                                type="hidden"
                                                name="Service_Provider_ID"
                                                value="{{ $sprovider->id }}"
                                            >

                                            <div class="mb-3">

                                                <div class="d-flex gap-2">

                                                    @for($i = 1; $i <= 5; $i++)

                                                        <label
                                                            style="cursor:pointer;"
                                                            class="text-warning"
                                                        >
                                                            <input
                                                                type="radio"
                                                                name="rating"
                                                                value="{{ $i }}"
                                                                class="d-none"
                                                                required
                                                            >

                                                            <i
                                                                class="fa-regular fa-star rating-select-star"
                                                                data-value="{{ $i }}"
                                                                style="font-size:1.35rem;"
                                                            ></i>

                                                        </label>

                                                    @endfor

                                                </div>

                                            </div>

                                            <button
                                                type="submit"
                                                class="provider-submit-btn"
                                            >
                                                <i class="fa-solid fa-star me-1"></i>
                                                Submit rating
                                            </button>

                                        </form>

                                    </div>

                                @endauth


                                @if($ratings->isNotEmpty())

                                    <div>

                                        @foreach($ratings as $rating)

                                            @php
                                                $reviewUser =
                                                    $rating->user
                                                    ?? $rating->customer
                                                    ?? null;

                                                $reviewName =
                                                    $reviewUser?->name
                                                    ?? $rating->name
                                                    ?? 'Client';

                                                $reviewInitials = collect(
                                                    preg_split(
                                                        '/\s+/',
                                                        $reviewName,
                                                        -1,
                                                        PREG_SPLIT_NO_EMPTY
                                                    )
                                                )
                                                    ->take(2)
                                                    ->map(
                                                        fn ($word) =>
                                                            Str::upper(
                                                                Str::substr(
                                                                    $word,
                                                                    0,
                                                                    1
                                                                )
                                                            )
                                                    )
                                                    ->implode('');

                                                $reviewDate =
                                                    $rating->created_at
                                                    ? Carbon::parse(
                                                        $rating->created_at
                                                    )->format('d M Y')
                                                    : null;

                                                $reviewComment =
                                                    $rating->comment
                                                    ?? $rating->review
                                                    ?? $rating->message
                                                    ?? '';
                                            @endphp

                                            <div class="review-card">

                                                <div class="review-header">

                                                    <div class="review-avatar">
                                                        {{ $reviewInitials ?: 'C' }}
                                                    </div>

                                                    <div>

                                                        <div class="review-author">
                                                            {{ $reviewName }}
                                                        </div>

                                                        @if($reviewDate)
                                                            <div class="review-date">
                                                                {{ $reviewDate }}
                                                            </div>
                                                        @endif

                                                    </div>

                                                    <div class="review-rating">

                                                        @for($i = 1; $i <= 5; $i++)

                                                            @if((float) $rating->rating >= $i)
                                                                <i class="fa-solid fa-star"></i>
                                                            @else
                                                                <i class="fa-regular fa-star"></i>
                                                            @endif

                                                        @endfor

                                                    </div>

                                                </div>


                                                @if($reviewComment)

                                                    <p class="review-text">
                                                        {{ $reviewComment }}
                                                    </p>

                                                @endif

                                            </div>

                                        @endforeach

                                    </div>

                                @else

                                    <div class="provider-empty">

                                        <div class="provider-empty-icon">
                                            <i class="fa-regular fa-star"></i>
                                        </div>

                                        <h5>
                                            No ratings yet
                                        </h5>

                                        <p>
                                            Be the first client to rate this provider.
                                        </p>

                                    </div>

                                @endif

                            </section>


                            {{-- Feedback --}}
                            <section class="provider-section">

                                <div class="d-flex justify-content-between align-items-start gap-3 mb-4">

                                    <div>

                                        <div class="provider-eyebrow">
                                            <i class="fa-regular fa-message"></i>
                                            Client voices
                                        </div>

                                        <h2 class="provider-section-title">
                                            Feedback
                                        </h2>

                                    </div>


                                    @auth

                                        <button
                                            type="button"
                                            class="provider-submit-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#FeedbackModal"
                                        >
                                            <i class="fa-solid fa-plus me-1"></i>
                                            Add feedback
                                        </button>

                                    @endauth

                                </div>


                                @if($feedback->isNotEmpty())

                                    <div class="row g-3">

                                        @foreach($feedback as $item)

                                            @php
                                                $feedbackUser =
                                                    $item->user
                                                    ?? $item->customer
                                                    ?? null;

                                                $feedbackName =
                                                    $feedbackUser?->name
                                                    ?? $item->name
                                                    ?? 'Client';

                                                $feedbackMessage =
                                                    $item->message
                                                    ?? $item->feedback
                                                    ?? $item->comment
                                                    ?? '';
                                            @endphp

                                            <div class="col-md-6">

                                                <div class="feedback-card">

                                                    <div class="feedback-quote">
                                                        <i class="fa-solid fa-quote-left"></i>
                                                    </div>

                                                    <div class="feedback-text">
                                                        {{ $feedbackMessage }}
                                                    </div>

                                                    <div class="feedback-author">
                                                        {{ $feedbackName }}
                                                    </div>

                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                @else

                                    <div class="provider-empty">

                                        <div class="provider-empty-icon">
                                            <i class="fa-regular fa-message"></i>
                                        </div>

                                        <h5>
                                            No feedback yet
                                        </h5>

                                        <p>
                                            Client feedback will appear here.
                                        </p>

                                    </div>

                                @endif

                            </section>

                        </div>

                    </div>


                    {{-- =============================================
                         CONTACT
                    ============================================== --}}
                    <div
                        class="provider-tab-content d-none"
                        id="tab-contact"
                    >

                        <div class="provider-content-card">

                            <section class="provider-section">

                                <div class="provider-section-heading">

                                    <div class="provider-eyebrow">
                                        <i class="fa-regular fa-paper-plane"></i>
                                        Get in touch
                                    </div>

                                    <h2 class="provider-section-title">
                                        Contact {{ $providerName }}
                                    </h2>

                                    <p class="provider-section-description">
                                        Reach out directly for questions, service details
                                        or booking information.
                                    </p>

                                </div>


                                <div class="row g-3 mb-4">

                                    @if($email)

                                        <div class="col-md-6">

                                            <a
                                                href="mailto:{{ $email }}"
                                                class="contact-option"
                                            >

                                                <div class="contact-option-icon">
                                                    <i class="fa-regular fa-envelope"></i>
                                                </div>

                                                <div>

                                                    <div class="contact-option-title">
                                                        Email
                                                    </div>

                                                    <div class="contact-option-text">
                                                        {{ $email }}
                                                    </div>

                                                </div>

                                            </a>

                                        </div>

                                    @endif


                                    @if($phone)

                                        <div class="col-md-6">

                                            <a
                                                href="tel:{{ $phone }}"
                                                class="contact-option"
                                            >

                                                <div class="contact-option-icon">
                                                    <i class="fa-solid fa-phone"></i>
                                                </div>

                                                <div>

                                                    <div class="contact-option-title">
                                                        Phone
                                                    </div>

                                                    <div class="contact-option-text">
                                                        {{ $phone }}
                                                    </div>

                                                </div>

                                            </a>

                                        </div>

                                    @endif


                                    @if($whatsappUrl)

                                        <div class="col-md-6">

                                            <a
                                                href="{{ $whatsappUrl }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="contact-option"
                                            >

                                                <div class="contact-option-icon">
                                                    <i class="fa-brands fa-whatsapp"></i>
                                                </div>

                                                <div>

                                                    <div class="contact-option-title">
                                                        WhatsApp
                                                    </div>

                                                    <div class="contact-option-text">
                                                        Chat directly
                                                    </div>

                                                </div>

                                            </a>

                                        </div>

                                    @endif


                                    @if($city)

                                        <div class="col-md-6">

                                            <div class="contact-option">

                                                <div class="contact-option-icon">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                </div>

                                                <div>

                                                    <div class="contact-option-title">
                                                        Location
                                                    </div>

                                                    <div class="contact-option-text">
                                                        {{ $city }}
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    @endif

                                </div>


                                {{-- Email Inquiry --}}
                                @if($email)

                                    <div class="provider-detail-box mb-4">

                                        <div class="provider-detail-label mb-3">
                                            Send an inquiry
                                        </div>

                                        <form
                                            action="{{ url('/sendEmailInquiry') }}"
                                            method="POST"
                                        >

                                            @csrf

                                            <input
                                                type="hidden"
                                                name="proEmail"
                                                value="{{ $email }}"
                                            >

                                            <input
                                                type="hidden"
                                                name="Service_Provider_ID"
                                                value="{{ $sprovider->id }}"
                                            >


                                            <div class="row g-3">

                                                <div class="col-md-6">

                                                    <label class="contact-form-label">
                                                        Your name
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="name"
                                                        class="form-control contact-form-control"
                                                        value="{{ old('name') }}"
                                                        required
                                                    >

                                                </div>


                                                <div class="col-md-6">

                                                    <label class="contact-form-label">
                                                        Your email
                                                    </label>

                                                    <input
                                                        type="email"
                                                        name="email"
                                                        class="form-control contact-form-control"
                                                        value="{{ old('email') }}"
                                                        required
                                                    >

                                                </div>


                                                <div class="col-12">

                                                    <label class="contact-form-label">
                                                        Message
                                                    </label>

                                                    <textarea
                                                        name="message"
                                                        class="form-control contact-form-control"
                                                        required
                                                        placeholder="Tell the provider what you need..."
                                                    >{{ old('message') }}</textarea>

                                                </div>


                                                <div class="col-12">

                                                    <button
                                                        type="submit"
                                                        class="provider-submit-btn"
                                                    >
                                                        <i class="fa-regular fa-paper-plane me-1"></i>
                                                        Send inquiry
                                                    </button>

                                                </div>

                                            </div>

                                        </form>

                                    </div>

                                @endif


                                {{-- Map --}}
                                @if($city)

                                    <div>

                                        <div class="provider-detail-label mb-3">
                                            Service location
                                        </div>

                                        <iframe
                                            src="https://www.google.com/maps?q={{ urlencode($mapQuery) }}&output=embed"
                                            class="provider-map"
                                            loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade"
                                            title="Map showing {{ $city }}"
                                        ></iframe>

                                    </div>

                                @endif

                            </section>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     SIDEBAR
                ================================================== --}}
                <div class="col-lg-4 provider-sidebar">


                    {{-- Provider Information --}}
                    <div class="provider-sidebar-card">

                        <div class="provider-sidebar-section">

                            <div class="sidebar-title">
                                Provider information
                            </div>


                            @if($email)

                                <div class="sidebar-info">

                                    <div class="sidebar-info-icon">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>

                                    <div>

                                        <div class="sidebar-info-label">
                                            Email
                                        </div>

                                        <div class="sidebar-info-value">

                                            <a
                                                href="mailto:{{ $email }}"
                                                class="sidebar-link"
                                            >
                                                {{ $email }}
                                            </a>

                                        </div>

                                    </div>

                                </div>

                            @endif


                            @if($phone)

                                <div class="sidebar-info">

                                    <div class="sidebar-info-icon">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>

                                    <div>

                                        <div class="sidebar-info-label">
                                            Phone
                                        </div>

                                        <div class="sidebar-info-value">

                                            <a
                                                href="tel:{{ $phone }}"
                                                class="sidebar-link"
                                            >
                                                {{ $phone }}
                                            </a>

                                        </div>

                                    </div>

                                </div>

                            @endif


                            @if($city)

                                <div class="sidebar-info">

                                    <div class="sidebar-info-icon">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </div>

                                    <div>

                                        <div class="sidebar-info-label">
                                            Location
                                        </div>

                                        <div class="sidebar-info-value">
                                            {{ $city }}
                                        </div>

                                    </div>

                                </div>

                            @endif


                            <div class="sidebar-info">

                                <div class="sidebar-info-icon">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div>

                                <div>

                                    <div class="sidebar-info-label">
                                        Category
                                    </div>

                                    <div class="sidebar-info-value">
                                        {{ $categoryName }}
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Rating --}}
                        <div class="provider-sidebar-section">

                            <div class="sidebar-title">
                                Customer rating
                            </div>

                            <div class="d-flex align-items-center gap-3">

                                <div
                                    style="
                                        font-size:2rem;
                                        line-height:1;
                                        font-weight:800;
                                        color:var(--provider-primary-dark);
                                    "
                                >
                                    {{ number_format($averageRating, 1) }}
                                </div>

                                <div>

                                    <div class="rating-stars">

                                        @for($i = 1; $i <= 5; $i++)

                                            @if($averageRating >= $i)
                                                <i class="fa-solid fa-star"></i>
                                            @elseif($averageRating >= ($i - .5))
                                                <i class="fa-solid fa-star-half-stroke"></i>
                                            @else
                                                <i class="fa-regular fa-star"></i>
                                            @endif

                                        @endfor

                                    </div>

                                    <div class="sidebar-info-label mt-1">
                                        Based on {{ $ratingCount }}
                                        {{ Str::plural('rating', $ratingCount) }}
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Working Hours --}}
                        @if($workingHours->isNotEmpty())

                            <div class="provider-sidebar-section">

                                <div class="sidebar-title">
                                    Working hours
                                </div>


                                @php
                                    $days = [
                                        'monday' => 'Monday',
                                        'tuesday' => 'Tuesday',
                                        'wednesday' => 'Wednesday',
                                        'thursday' => 'Thursday',
                                        'friday' => 'Friday',
                                        'saturday' => 'Saturday',
                                        'sunday' => 'Sunday',
                                    ];
                                @endphp


                                @foreach($days as $dayKey => $dayLabel)

                                    @php
                                        $hour = $workingHoursByDay->get($dayKey);

                                        $startTime = null;
                                        $endTime = null;

                                        if ($hour?->start_time) {
                                            try {
                                                $startTime = Carbon::parse(
                                                    $hour->start_time
                                                )->format('g:i A');
                                            } catch (\Throwable $e) {
                                                $startTime = $hour->start_time;
                                            }
                                        }

                                        if ($hour?->end_time) {
                                            try {
                                                $endTime = Carbon::parse(
                                                    $hour->end_time
                                                )->format('g:i A');
                                            } catch (\Throwable $e) {
                                                $endTime = $hour->end_time;
                                            }
                                        }

                                        $isClosed =
                                            !$hour
                                            || (
                                                !$startTime
                                                && !$endTime
                                            );
                                    @endphp

                                    <div
                                        class="hours-row {{ $today === $dayKey ? 'hours-today' : '' }}"
                                    >

                                        <span class="hours-day">
                                            {{ $dayLabel }}
                                        </span>

                                        @if($isClosed)

                                            <span class="hours-time hours-closed">
                                                Closed
                                            </span>

                                        @else

                                            <span class="hours-time">
                                                {{ $startTime }}
                                                –
                                                {{ $endTime }}
                                            </span>

                                        @endif

                                    </div>

                                @endforeach

                            </div>

                        @endif


                        {{-- Share --}}
                        <div class="provider-sidebar-section">

                            <div class="sidebar-title">
                                Share profile
                            </div>

                            <div class="share-buttons">

                                <button
                                    type="button"
                                    class="share-button"
                                    onclick="shareProvider()"
                                    title="Share"
                                >
                                    <i class="fa-solid fa-share-nodes"></i>
                                </button>


                                <a
                                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($profileUrl) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="share-button"
                                    title="Facebook"
                                >
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>


                                @if($whatsappUrl)

                                    <a
                                        href="https://wa.me/?text={{ urlencode($providerName . ' - ' . $profileUrl) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="share-button"
                                        title="WhatsApp"
                                    >
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>

                                @endif


                                <a
                                    href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($profileUrl) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="share-button"
                                    title="LinkedIn"
                                >
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>


                                <button
                                    type="button"
                                    class="share-button"
                                    onclick="copyProfileLink()"
                                    title="Copy link"
                                >
                                    <i class="fa-regular fa-copy"></i>
                                </button>

                            </div>

                        </div>

                    </div>


                    {{-- Quick Contact --}}
                    <div class="provider-sidebar-card">

                        <div class="provider-sidebar-section">

                            <div class="sidebar-title">
                                Need this service?
                            </div>

                            <p
                                style="
                                    color:var(--provider-muted);
                                    font-size:.8rem;
                                    line-height:1.65;
                                    margin-bottom:17px;
                                "
                            >
                                Contact {{ $providerName }} to discuss your
                                requirements and get more information.
                            </p>

                            <button
                                type="button"
                                class="provider-submit-btn w-100"
                                onclick="switchProfileTab('contact')"
                            >
                                <i class="fa-regular fa-paper-plane me-1"></i>
                                Contact provider
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     FEEDBACK MODAL
============================================================== --}}
<div
    class="modal fade provider-modal"
    id="FeedbackModal"
    tabindex="-1"
    aria-labelledby="FeedbackModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <div>

                    <div class="provider-eyebrow mb-1">
                        <i class="fa-regular fa-message"></i>
                        Client feedback
                    </div>

                    <h5
                        class="modal-title"
                        id="FeedbackModalLabel"
                    >
                        Share your experience
                    </h5>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form
                method="POST"
                action="{{ route('feedback.store') }}"
                id="feedbackForm"
            >

                @csrf

                <div class="modal-body">

                    <input
                        type="hidden"
                        name="Service_Provider_ID"
                        value="{{ $sprovider->id }}"
                    >


                    <div class="mb-3">

                        <label
                            for="feedbackMessage"
                            class="contact-form-label"
                        >
                            Your feedback
                        </label>

                        <textarea
                            id="feedbackMessage"
                            name="message"
                            class="feedback-textarea"
                            placeholder="Tell us about your experience with this service provider..."
                            required
                        >{{ old('message') }}</textarea>

                        @error('message')
                            <div class="text-danger mt-2" style="font-size:.75rem;">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="provider-submit-btn"
                    >
                        <i class="fa-solid fa-paper-plane me-1"></i>
                        Submit feedback
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>


{{-- =============================================================
     SHARE TOAST
============================================================== --}}
<div
    class="provider-toast"
    id="providerToast"
    role="status"
    aria-live="polite"
></div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        /*
        |--------------------------------------------------------------------------
        | Tabs
        |--------------------------------------------------------------------------
        */

        const tabs = document.querySelectorAll('.provider-tab');
        const contents = document.querySelectorAll('.provider-tab-content');

        function activateTab(tabName, updateHash = true) {

            const target = document.getElementById('tab-' + tabName);

            if (!target) {
                tabName = 'overview';
            }

            tabs.forEach(function (tab) {

                const isActive =
                    tab.dataset.tab === tabName;

                tab.classList.toggle(
                    'active',
                    isActive
                );

                tab.setAttribute(
                    'aria-selected',
                    isActive ? 'true' : 'false'
                );

            });


            contents.forEach(function (content) {

                content.classList.toggle(
                    'd-none',
                    content.id !== 'tab-' + tabName
                );

            });


            if (updateHash) {

                try {
                    history.replaceState(
                        null,
                        '',
                        '#' + tabName
                    );
                } catch (error) {
                    // Ignore browser history errors.
                }

            }

        }


        window.switchProfileTab = function (tabName) {

            activateTab(tabName);

            const tabsWrapper =
                document.querySelector('.provider-tabs-wrapper');

            if (tabsWrapper) {

                const offset =
                    tabsWrapper.getBoundingClientRect().top +
                    window.scrollY -
                    20;

                window.scrollTo({
                    top: Math.max(0, offset),
                    behavior: 'smooth'
                });

            }

        };


        /*
        |--------------------------------------------------------------------------
        | Open initial hash
        |--------------------------------------------------------------------------
        */

        const initialHash =
            window.location.hash.replace('#', '');

        if (
            initialHash &&
            document.getElementById('tab-' + initialHash)
        ) {

            activateTab(
                initialHash,
                false
            );

        } else {

            activateTab(
                'overview',
                false
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Rating stars
        |--------------------------------------------------------------------------
        */

        const ratingInputs =
            document.querySelectorAll(
                'input[name="rating"]'
            );

        const ratingStars =
            document.querySelectorAll(
                '.rating-select-star'
            );


        function updateRatingStars(value) {

            ratingStars.forEach(function (star) {

                const starValue =
                    parseInt(
                        star.dataset.value,
                        10
                    );

                if (starValue <= value) {

                    star.classList.remove(
                        'fa-regular'
                    );

                    star.classList.add(
                        'fa-solid'
                    );

                } else {

                    star.classList.remove(
                        'fa-solid'
                    );

                    star.classList.add(
                        'fa-regular'
                    );

                }

            });

        }


        ratingInputs.forEach(function (input) {

            input.addEventListener(
                'change',
                function () {

                    updateRatingStars(
                        parseInt(
                            this.value,
                            10
                        )
                    );

                }
            );

        });


        ratingStars.forEach(function (star) {

            star.addEventListener(
                'mouseenter',
                function () {

                    updateRatingStars(
                        parseInt(
                            this.dataset.value,
                            10
                        )
                    );

                }
            );

        });


        const ratingContainer =
            document.querySelector(
                '.rating-select-star'
            )?.parentElement?.parentElement;


        if (ratingContainer) {

            ratingContainer.addEventListener(
                'mouseleave',
                function () {

                    const checked =
                        document.querySelector(
                            'input[name="rating"]:checked'
                        );

                    updateRatingStars(
                        checked
                            ? parseInt(
                                checked.value,
                                10
                            )
                            : 0
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Share
        |--------------------------------------------------------------------------
        */

        window.shareProvider = async function () {

            const shareData = {
                title: @json($providerName),
                text: @json(
                    'View the service provider profile of ' .
                    $providerName
                ),
                url: @json($profileUrl)
            };


            if (
                navigator.share &&
                typeof navigator.share === 'function'
            ) {

                try {

                    await navigator.share(
                        shareData
                    );

                    return;

                } catch (error) {

                    if (
                        error &&
                        error.name === 'AbortError'
                    ) {
                        return;
                    }

                }

            }


            copyProfileLink();

        };


        /*
        |--------------------------------------------------------------------------
        | Copy profile link
        |--------------------------------------------------------------------------
        */

        window.copyProfileLink = async function () {

            const url =
                @json($profileUrl);

            try {

                if (
                    navigator.clipboard &&
                    window.isSecureContext
                ) {

                    await navigator.clipboard.writeText(
                        url
                    );

                } else {

                    const textarea =
                        document.createElement('textarea');

                    textarea.value = url;

                    textarea.style.position =
                        'fixed';

                    textarea.style.opacity =
                        '0';

                    document.body.appendChild(
                        textarea
                    );

                    textarea.select();

                    document.execCommand(
                        'copy'
                    );

                    textarea.remove();

                }

                showProviderToast(
                    'Profile link copied'
                );

            } catch (error) {

                showProviderToast(
                    'Unable to copy profile link'
                );

            }

        };


        /*
        |--------------------------------------------------------------------------
        | Toast
        |--------------------------------------------------------------------------
        */

        window.showProviderToast = function (message) {

            const toast =
                document.getElementById(
                    'providerToast'
                );

            if (!toast) {
                return;
            }

            toast.textContent =
                message;

            toast.style.display =
                'block';

            clearTimeout(
                window.providerToastTimeout
            );

            window.providerToastTimeout =
                setTimeout(function () {

                    toast.style.display =
                        'none';

                }, 2500);

        };


        /*
        |--------------------------------------------------------------------------
        | Reopen feedback modal after validation error
        |--------------------------------------------------------------------------
        */

        @if($errors->has('message') && old('Service_Provider_ID') == $sprovider->id)

            const feedbackModal =
                document.getElementById(
                    'FeedbackModal'
                );

            if (
                feedbackModal &&
                typeof bootstrap !== 'undefined'
            ) {

                bootstrap.Modal
                    .getOrCreateInstance(
                        feedbackModal
                    )
                    .show();

            }

        @endif

    });
</script>

@endsection