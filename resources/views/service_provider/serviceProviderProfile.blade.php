@extends('layouts.base')

@section('title', 'Profile - ' . ($sproviders->sprovider_name ?? 'Service Provider'))

@section('content')

@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    /*
    |--------------------------------------------------------------------------
    | Safe Profile Data
    |--------------------------------------------------------------------------
    */

    $providerName = trim($sproviders->sprovider_name ?? 'Service Provider');
    $categoryName = optional($sproviders->category)->name ?? 'Professional Service Provider';
    $city = trim($sproviders->city ?? '');
    $email = trim($sproviders->proEmail ?? '');
    $phone = optional($sproviders->user)->phone ?? ($sproviders->phone ?? '');
    $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

    $image = !empty($sproviders->image)
        ? asset('image/profile/' . $sproviders->image)
        : asset('image/profile/default.png');

    $totalSales = \App\Models\ServiceBooking::where('service_provider_id', $sproviders->id)
        ->where('status', 'completed')
        ->count();

    $averageRating = (float) ($averageRating ?? 0);
    $ratingCount = isset($ratings) ? $ratings->count() : 0;
    $profileUrl = url()->current();

    /*
    |--------------------------------------------------------------------------
    | Provider Services
    |--------------------------------------------------------------------------
    */

    $groupedServices = \App\Models\Service::where('service_provider_id', $sproviders->id)
        ->with('subcategory')
        ->latest()
        ->get()
        ->groupBy(function ($service) {
            return optional($service->subcategory)->name ?? 'Other services';
        });

    $serviceCount = $groupedServices->flatten()->count();
    $portfolioCount = isset($portfolios) ? $portfolios->count() : 0;
    $reviewsAndFeedbackCount = $ratingCount + (isset($feedback) ? $feedback->count() : 0);

    $activePromotions = collect($promotions ?? [])->filter(function ($promotion) {
        return Carbon::now()->lessThanOrEqualTo($promotion->end_date);
    });

    $hasAboutContent = !empty($sproviders->about)
        || !empty($sproviders->skills)
        || !empty($sproviders->qualification)
        || !empty($sproviders->experience);
@endphp

<style>

    /* =========================================================
       CONNECTOR PROFILE
    ========================================================= */

    :root {
        --connector-primary: #6B9080;
        --connector-primary-dark: #254035;
        --connector-soft: #EEF4F1;
        --connector-bg: #F7FAF8;
        --connector-text: #183028;
        --connector-muted: #65786F;
        --connector-border: #E1EAE6;
        --connector-gold: #C99A3B;
        --connector-danger: #C95A43;
        --connector-whatsapp: #25D366;

        --profile-radius: 18px;
        --profile-shadow: 0 10px 30px rgba(37,64,53,.07);
        --profile-shadow-hover: 0 18px 40px rgba(37,64,53,.12);
    }

    .connector-profile-page {
        background: var(--connector-bg);
        color: var(--connector-text);
        min-height: 100vh;
        padding-bottom: 80px;
    }

    .connector-profile-page *,
    .connector-profile-page *::before,
    .connector-profile-page *::after {
        box-sizing: border-box;
    }

    .connector-profile-page a {
        text-decoration: none;
    }

    /* =========================================================
       HERO
    ========================================================= */

    .profile-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, var(--connector-primary-dark), #355C4E 55%, var(--connector-primary));
        padding: 42px 0 105px;
    }

    .profile-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        opacity: .25;
        background-image:
            linear-gradient(rgba(255,255,255,.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.05) 1px, transparent 1px);
        background-size: 40px 40px;
    }

    .profile-hero-content { position: relative; z-index: 2; }

    .profile-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 28px;
        color: rgba(255,255,255,.72);
        font-size: 12px;
        font-weight: 600;
    }

    .profile-breadcrumb a { color: #fff; }
    .profile-breadcrumb a:hover { color: #D9E9E2; }
    .profile-breadcrumb i { font-size: 8px; opacity: .7; }

    .profile-hero-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 11px;
        border: 1px solid rgba(255,255,255,.14);
        border-radius: 999px;
        background: rgba(255,255,255,.09);
        color: #fff;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .profile-hero-label i { color: #BFDCCF; font-size: 8px; }

    .profile-hero h1 {
        margin: 15px 0 8px;
        max-width: 850px;
        color: #fff;
        font-size: clamp(32px, 4vw, 50px);
        line-height: 1.05;
        font-weight: 800;
        letter-spacing: -.035em;
    }

    .profile-hero-subtitle { color: rgba(255,255,255,.76); font-size: 15px; line-height: 1.6; }

    /* =========================================================
       PROFILE HEADER CARD
    ========================================================= */

    .profile-header-wrap { position: relative; z-index: 10; margin-top: -72px; }

    .profile-header-card {
        display: grid;
        grid-template-columns: 120px minmax(0, 1fr) auto;
        gap: 24px;
        align-items: center;
        padding: 25px;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 22px;
        box-shadow: var(--profile-shadow-hover);
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        overflow: hidden;
        border-radius: 18px;
        background: var(--connector-soft);
        border: 5px solid #fff;
        box-shadow: 0 8px 25px rgba(37,64,53,.13);
    }

    .profile-avatar img { display: block; width: 100%; height: 100%; object-fit: cover; }

    .profile-header-info { min-width: 0; }

    .profile-category {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--connector-primary);
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .profile-category i { font-size: 11px; }

    .profile-header-info h2 {
        margin: 0;
        color: var(--connector-text);
        font-size: 26px;
        line-height: 1.2;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .profile-location {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-top: 8px;
        color: var(--connector-muted);
        font-size: 13px;
    }

    .profile-location i { color: var(--connector-primary); }

    .profile-header-actions { display: flex; align-items: center; gap: 8px; }

    .profile-action {
        height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 0 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 800;
        transition: .2s ease;
    }

    .profile-action-primary { background: var(--connector-primary); color: #fff; }
    .profile-action-primary:hover { background: var(--connector-primary-dark); color: #fff; }
    .profile-action-whatsapp { background: #EAF8EF; color: #168B45; }
    .profile-action-whatsapp:hover { background: var(--connector-whatsapp); color: #fff; }

    .profile-action-share {
        width: 43px;
        padding: 0;
        background: var(--connector-soft);
        color: var(--connector-primary-dark);
        border: 0;
        cursor: pointer;
    }

    .profile-action-share:hover { background: var(--connector-primary); color: #fff; }

    /* =========================================================
       MAIN LAYOUT
    ========================================================= */

    .profile-main { padding-top: 28px; }

    .profile-layout {
        display: grid;
        grid-template-columns: 285px minmax(0, 1fr);
        gap: 25px;
        align-items: start;
    }

    .profile-sidebar { min-width: 0; position: sticky; top: 20px; }
    .profile-content { min-width: 0; }

    /* =========================================================
       SIDEBAR CARD
    ========================================================= */

    .profile-side-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: var(--profile-radius);
        box-shadow: var(--profile-shadow);
        overflow: hidden;
        margin-bottom: 18px;
    }

    .side-card-header { padding: 17px 18px; border-bottom: 1px solid var(--connector-border); }
    .side-card-header h3 { margin: 0; color: var(--connector-text); font-size: 14px; font-weight: 800; }
    .side-card-body { padding: 18px; }

    /* =========================================================
       RATING
    ========================================================= */

    .rating-summary { display: flex; align-items: center; gap: 13px; }
    .rating-score { color: var(--connector-text); font-size: 32px; line-height: 1; font-weight: 800; }
    .rating-stars { display: flex; gap: 2px; color: var(--connector-gold); font-size: 14px; }
    .rating-count { margin-top: 4px; color: var(--connector-muted); font-size: 11px; }

    /* =========================================================
       INFO LIST
    ========================================================= */

    .profile-info-list { display: flex; flex-direction: column; gap: 0; }

    .profile-info-item {
        display: grid;
        grid-template-columns: 30px minmax(0, 1fr);
        gap: 10px;
        padding: 13px 0;
        border-bottom: 1px solid var(--connector-border);
    }

    .profile-info-item:first-child { padding-top: 0; }
    .profile-info-item:last-child { padding-bottom: 0; border-bottom: 0; }

    .info-icon {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        font-size: 12px;
    }

    .info-label {
        display: block;
        color: #8A9992;
        font-size: 9px;
        line-height: 1.2;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .info-value { display: block; margin-top: 3px; color: var(--connector-text); font-size: 12px; line-height: 1.4; font-weight: 600; overflow-wrap: anywhere; }
    .info-value a { color: var(--connector-text); }
    .info-value a:hover { color: var(--connector-primary); }

    /* =========================================================
       WORKING HOURS
    ========================================================= */

    .working-hour-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 9px 0;
        border-bottom: 1px solid var(--connector-border);
        font-size: 11px;
    }

    .working-hour-row:last-child { border-bottom: 0; }
    .working-hour-day { color: var(--connector-text); font-weight: 700; }
    .working-hour-time { color: var(--connector-muted); text-align: right; }
    .working-hour-closed { color: var(--connector-danger); font-weight: 800; }

    /* =========================================================
       SHARE
    ========================================================= */

    .share-buttons { display: grid; grid-template-columns: repeat(5, 1fr); gap: 6px; }

    .share-button {
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: var(--connector-soft);
        color: var(--connector-primary-dark);
        font-size: 13px;
        transition: .2s ease;
    }

    .share-button:hover { background: var(--connector-primary); color: #fff; }

    /* =========================================================
       TAB NAVIGATION
    ========================================================= */

    .profile-tabnav {
        display: flex;
        gap: 4px;
        margin-bottom: 20px;
        padding: 5px;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        box-shadow: var(--profile-shadow);
        overflow-x: auto;
        scrollbar-width: none;
        position: sticky;
        top: 12px;
        z-index: 20;
    }

    .profile-tabnav::-webkit-scrollbar { display: none; }

    .profile-tab-btn {
        flex: 1 1 auto;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        height: 42px;
        padding: 0 16px;
        border: 0;
        border-radius: 10px;
        background: transparent;
        color: var(--connector-muted);
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        transition: .18s ease;
    }

    .profile-tab-btn i { font-size: 11px; }

    .profile-tab-btn .tab-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 17px;
        height: 17px;
        padding: 0 4px;
        border-radius: 999px;
        background: var(--connector-soft);
        color: var(--connector-primary-dark);
        font-size: 9px;
    }

    .profile-tab-btn:hover { color: var(--connector-text); background: var(--connector-bg); }

    .profile-tab-btn.is-active {
        background: var(--connector-primary);
        color: #fff;
    }

    .profile-tab-btn.is-active .tab-count { background: rgba(255,255,255,.22); color: #fff; }

    .profile-tabpanel { display: none; }
    .profile-tabpanel.is-active {
        display: block;
        animation: connectorTabFade .25s ease;
    }

    @keyframes connectorTabFade {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* =========================================================
       CONTENT CARDS
    ========================================================= */

    .profile-section-card {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: var(--profile-radius);
        box-shadow: var(--profile-shadow);
        padding: 25px;
        margin-bottom: 20px;
    }

    .profile-section-card:last-child { margin-bottom: 0; }

    .section-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 20px;
    }

    .section-heading-left { min-width: 0; }

    .section-eyebrow {
        display: block;
        margin-bottom: 5px;
        color: var(--connector-primary);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .07em;
    }

    .section-heading h3 { margin: 0; color: var(--connector-text); font-size: 21px; font-weight: 800; }
    .section-heading p { margin: 5px 0 0; color: var(--connector-muted); font-size: 12px; line-height: 1.6; }

    .profile-text { color: #53665E; font-size: 14px; line-height: 1.85; }
    .profile-text p:last-child { margin-bottom: 0; }

    /* =========================================================
       QUICK STATS
    ========================================================= */

    .profile-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; }
    .profile-stat { padding: 17px; background: var(--connector-soft); border-radius: 12px; }
    .profile-stat-label { color: var(--connector-muted); font-size: 10px; font-weight: 700; }
    .profile-stat-value { margin-top: 4px; color: var(--connector-text); font-size: 23px; line-height: 1; font-weight: 800; }

    /* =========================================================
       ABOUT SUB-BLOCKS (within Overview tab)
    ========================================================= */

    .about-subsection { margin-top: 26px; padding-top: 22px; border-top: 1px solid var(--connector-border); }
    .about-subsection:first-of-type { margin-top: 0; padding-top: 0; border-top: 0; }

    .about-subsection-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 12px;
        color: var(--connector-text);
        font-size: 14px;
        font-weight: 800;
    }

    .about-subsection-title::before {
        content: "";
        width: 4px;
        height: 16px;
        border-radius: 4px;
        background: var(--connector-primary);
    }

    /* =========================================================
       TAG CONTENT
    ========================================================= */

    .rich-content { color: #53665E; font-size: 14px; line-height: 1.85; }
    .rich-content p:last-child { margin-bottom: 0; }
    .rich-content ul, .rich-content ol { padding-left: 20px; }

    /* =========================================================
       SERVICES
    ========================================================= */

    .service-category-section { margin-bottom: 30px; }
    .service-category-section:last-child { margin-bottom: 0; }

    .service-category-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 13px;
        color: var(--connector-text);
        font-size: 14px;
        font-weight: 800;
    }

    .service-category-title::before {
        content: "";
        width: 4px;
        height: 18px;
        border-radius: 4px;
        background: var(--connector-primary);
    }

    .services-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 15px; }

    .service-card {
        min-width: 0;
        overflow: hidden;
        border: 1px solid var(--connector-border);
        border-radius: 14px;
        background: #fff;
        transition: .22s ease;
    }

    .service-card:hover { transform: translateY(-3px); border-color: #CBDCD4; box-shadow: var(--profile-shadow-hover); }

    .service-image { position: relative; display: block; aspect-ratio: 16 / 10; overflow: hidden; background: var(--connector-soft); }
    .service-image img { width: 100%; height: 100%; display: block; object-fit: cover; transition: transform .3s ease; }
    .service-card:hover .service-image img { transform: scale(1.04); }

    .service-duration {
        position: absolute;
        right: 9px;
        top: 9px;
        padding: 5px 8px;
        border-radius: 7px;
        background: rgba(255,255,255,.95);
        color: var(--connector-text);
        font-size: 9px;
        font-weight: 800;
    }

    .service-body { padding: 14px; }

    .service-subcategory {
        display: block;
        margin-bottom: 5px;
        color: var(--connector-primary);
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .service-title { display: block; min-height: 38px; color: var(--connector-text); font-size: 14px; line-height: 1.35; font-weight: 800; overflow: hidden; }

    .service-price-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-top: 12px;
        padding-top: 11px;
        border-top: 1px solid var(--connector-border);
    }

    .service-price-label { color: var(--connector-muted); font-size: 9px; }
    .service-price { color: var(--connector-text); font-size: 14px; font-weight: 800; }

    .service-location { display: flex; align-items: center; gap: 6px; margin-top: 9px; color: var(--connector-muted); font-size: 10px; }
    .service-location i { color: var(--connector-primary); }

    .service-buttons { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-top: 13px; }

    .service-button {
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 800;
    }

    .service-button-outline { border: 1px solid var(--connector-border); color: var(--connector-primary-dark); background: #fff; }
    .service-button-outline:hover { background: var(--connector-soft); color: var(--connector-primary-dark); }
    .service-button-primary { background: var(--connector-primary); color: #fff; }
    .service-button-primary:hover { background: var(--connector-primary-dark); color: #fff; }

    /* =========================================================
       PORTFOLIO
    ========================================================= */

    .portfolio-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 13px; }

    .portfolio-item { display: block; position: relative; aspect-ratio: 4 / 3; overflow: hidden; border-radius: 12px; background: var(--connector-soft); }
    .portfolio-item img { display: block; width: 100%; height: 100%; object-fit: cover; transition: transform .3s ease; }

    .portfolio-item::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(37,64,53,.25);
        opacity: 0;
        transition: .2s ease;
    }

    .portfolio-item:hover img { transform: scale(1.05); }
    .portfolio-item:hover::after { opacity: 1; }

    .portfolio-view-icon {
        position: absolute;
        z-index: 2;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -40%);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fff;
        color: var(--connector-primary-dark);
        opacity: 0;
        transition: .2s ease;
    }

    .portfolio-item:hover .portfolio-view-icon { opacity: 1; transform: translate(-50%, -50%); }

    /* =========================================================
       REVIEWS
    ========================================================= */

    .review-list { display: flex; flex-direction: column; gap: 12px; }

    .review-item { padding: 16px; border: 1px solid var(--connector-border); border-radius: 12px; background: #FCFDFC; }
    .review-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
    .review-user { display: flex; align-items: center; gap: 9px; }

    .review-avatar {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--connector-soft);
        color: var(--connector-primary-dark);
        font-size: 11px;
        font-weight: 800;
    }

    .review-user-name { color: var(--connector-text); font-size: 12px; font-weight: 800; }
    .review-date { color: var(--connector-muted); font-size: 9px; margin-top: 2px; }
    .review-rating { color: var(--connector-gold); white-space: nowrap; font-size: 11px; }
    .review-message { margin: 12px 0 0; color: var(--connector-muted); font-size: 12px; line-height: 1.65; }

    /* =========================================================
       REVIEW FORM
    ========================================================= */

    .rating-input { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 3px; }
    .rating-input input { position: absolute; opacity: 0; pointer-events: none; }

    .rating-input label { cursor: pointer; color: #D9E0DC; font-size: 28px; line-height: 1; transition: .15s ease; }

    .rating-input label:hover,
    .rating-input label:hover ~ label,
    .rating-input input:checked ~ label { color: var(--connector-gold); }

    .connector-form-group { margin-bottom: 15px; }
    .connector-form-label { display: block; margin-bottom: 6px; color: var(--connector-text); font-size: 11px; font-weight: 800; }

    .connector-form-control {
        width: 100%;
        min-height: 45px;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        padding: 10px 12px;
        outline: none;
        background: #fff;
        color: var(--connector-text);
        font-size: 12px;
        transition: .2s ease;
    }

    .connector-form-control:focus { border-color: var(--connector-primary); box-shadow: 0 0 0 3px rgba(107,144,128,.10); }
    textarea.connector-form-control { min-height: 110px; resize: vertical; }

    .connector-submit {
        height: 43px;
        padding: 0 18px;
        border: 0;
        border-radius: 9px;
        background: var(--connector-primary);
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
    }

    .connector-submit:hover { background: var(--connector-primary-dark); }

    /* =========================================================
       FEEDBACK
    ========================================================= */

    .feedback-item { padding: 20px; background: var(--connector-soft); border-radius: 14px; }
    .feedback-quote { color: var(--connector-primary); font-size: 25px; margin-bottom: 8px; }
    .feedback-message { color: var(--connector-text); font-size: 14px; line-height: 1.7; font-weight: 500; }
    .feedback-date { display: block; margin-top: 12px; color: var(--connector-muted); font-size: 10px; }

    /* =========================================================
       EMAIL FORM
    ========================================================= */

    .email-form-card { background: linear-gradient(145deg, #fff, var(--connector-soft)); }
    .email-intro { color: var(--connector-muted); font-size: 12px; line-height: 1.6; margin-bottom: 20px; }

    /* =========================================================
       PROMOTIONS
    ========================================================= */

    .promotion-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 15px; }
    .promotion-card { overflow: hidden; background: #fff; border: 1px solid var(--connector-border); border-radius: 14px; transition: .2s ease; }
    .promotion-card:hover { transform: translateY(-3px); box-shadow: var(--profile-shadow-hover); }
    .promotion-image { position: relative; aspect-ratio: 16 / 10; overflow: hidden; }
    .promotion-image img { width: 100%; height: 100%; object-fit: cover; }

    .promotion-discount {
        position: absolute;
        top: 9px;
        right: 9px;
        padding: 6px 8px;
        border-radius: 7px;
        background: var(--connector-danger);
        color: #fff;
        font-size: 10px;
        font-weight: 800;
    }

    .promotion-body { padding: 14px; }
    .promotion-category { color: var(--connector-primary); font-size: 9px; font-weight: 800; text-transform: uppercase; }
    .promotion-title { display: block; margin-top: 5px; color: var(--connector-text); font-size: 14px; line-height: 1.35; font-weight: 800; }
    .promotion-description { min-height: 35px; margin: 7px 0 0; color: var(--connector-muted); font-size: 10px; line-height: 1.5; }

    .promotion-meta { display: flex; justify-content: space-between; gap: 8px; margin-top: 12px; padding-top: 11px; border-top: 1px solid var(--connector-border); }
    .promotion-meta span { color: var(--connector-muted); font-size: 9px; }
    .promotion-meta strong { display: block; color: var(--connector-text); font-size: 11px; margin-top: 2px; }

    .promotion-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-top: 12px; }

    /* =========================================================
       EMPTY
    ========================================================= */

    .profile-empty { padding: 35px; text-align: center; border-radius: 14px; background: var(--connector-soft); color: var(--connector-muted); font-size: 12px; }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1199px) {
        .profile-header-card { grid-template-columns: 100px minmax(0, 1fr); }
        .profile-avatar { width: 100px; height: 100px; }
        .profile-header-actions { grid-column: 1 / -1; justify-content: flex-start; }
        .profile-layout { grid-template-columns: 245px minmax(0, 1fr); }
        .services-grid, .promotion-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 991px) {
        .profile-hero { padding: 35px 0 90px; }
        .profile-header-wrap { margin-top: -65px; }
        .profile-layout { display: block; }
        .profile-sidebar { position: static; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 15px; margin-bottom: 20px; }
        .profile-side-card { margin-bottom: 0; }
        .profile-side-card:last-child { grid-column: 1 / -1; }
    }

    @media (max-width: 767px) {
        .connector-profile-page { padding-bottom: 50px; }
        .profile-hero { padding: 30px 0 85px; }
        .profile-hero h1 { font-size: 32px; }

        .profile-header-card { grid-template-columns: 75px minmax(0, 1fr); gap: 15px; padding: 18px; border-radius: 16px; }
        .profile-avatar { width: 75px; height: 75px; border-radius: 13px; border-width: 3px; }
        .profile-header-info h2 { font-size: 20px; }

        .profile-header-actions { grid-column: 1 / -1; width: 100%; display: grid; grid-template-columns: minmax(0, 1fr) 45px 45px; }
        .profile-action { width: 100%; padding: 0 10px; }
        .profile-action span { display: none; }
        .profile-action-primary span { display: inline; }

        .profile-sidebar { display: block; }
        .profile-side-card { margin-bottom: 15px; }

        .profile-tabnav { top: 0; }
        .profile-tab-btn { flex: 0 0 auto; padding: 0 14px; }
        .profile-tab-btn .tab-label { display: inline; }

        .profile-section-card { padding: 18px; border-radius: 15px; }
        .profile-stats { grid-template-columns: repeat(3, 1fr); gap: 7px; }
        .profile-stat { padding: 12px; }
        .profile-stat-value { font-size: 19px; }

        .services-grid, .promotion-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
        .portfolio-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .section-heading h3 { font-size: 18px; }
    }

    @media (max-width: 480px) {
        .profile-hero h1 { font-size: 27px; }
        .profile-header-card { grid-template-columns: 65px minmax(0, 1fr); padding: 14px; }
        .profile-avatar { width: 65px; height: 65px; }
        .profile-header-info h2 { font-size: 17px; }
        .profile-location { font-size: 10px; }

        .services-grid, .promotion-grid { grid-template-columns: 1fr; }
        .profile-stats { grid-template-columns: 1fr; }
        .profile-stat { display: flex; align-items: center; justify-content: space-between; }
        .profile-stat-value { margin-top: 0; }
        .portfolio-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .review-top { flex-direction: column; gap: 7px; }
        .promotion-actions, .service-buttons { grid-template-columns: 1fr; }

        .profile-tab-btn .tab-label { display: none; }
        .profile-tab-btn { padding: 0 12px; }
    }

</style>

<div class="connector-profile-page">

    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="profile-hero">
        <div class="container">
            <div class="profile-hero-content">

                <div class="profile-breadcrumb">
                    <a href="{{ url('/') }}">Home</a>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span>Service Providers</span>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span>Profile</span>
                </div>

                <span class="profile-hero-label">
                    <i class="fa-solid fa-circle"></i>
                    Connector Professional
                </span>

                <h1>{{ $providerName }}</h1>

                <div class="profile-hero-subtitle">
                    {{ $categoryName }}
                    @if($city)
                        · {{ $city }}
                    @endif
                </div>

            </div>
        </div>
    </section>

    {{-- =====================================================
         PROFILE HEADER
    ====================================================== --}}

    <div class="profile-header-wrap">
        <div class="container">
            <div class="profile-header-card">

                <div class="profile-avatar">
                    <img
                        src="{{ $image }}"
                        alt="{{ $providerName }}"
                        loading="lazy"
                        onerror="this.onerror=null;this.src='{{ asset('image/profile/default.png') }}';"
                    >
                </div>

                <div class="profile-header-info">
                    <div class="profile-category">
                        <i class="fa-solid fa-briefcase"></i>
                        {{ $categoryName }}
                    </div>

                    <h2>{{ $providerName }}</h2>

                    @if($city)
                        <div class="profile-location">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>{{ $city }}</span>
                        </div>
                    @endif
                </div>

                <div class="profile-header-actions">
                    @if($email)
                        <button
                            type="button"
                            class="profile-action profile-action-primary"
                            onclick="switchProfileTab('contact')"
                        >
                            <i class="fa-regular fa-envelope"></i>
                            <span>Contact</span>
                        </button>
                    @endif

                    @if($cleanPhone)
                        <a
                            href="https://wa.me/{{ $cleanPhone }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="profile-action profile-action-whatsapp"
                            title="Contact on WhatsApp"
                        >
                            <i class="fa-brands fa-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>
                    @endif

                    <button
                        type="button"
                        class="profile-action profile-action-share"
                        onclick="shareProviderProfile()"
                        title="Share profile"
                    >
                        <i class="fa-solid fa-share-nodes"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

    <main class="profile-main">
        <div class="container">
            <div class="profile-layout">

                {{-- =================================================
                     SIDEBAR
                ================================================== --}}

                <aside class="profile-sidebar">

                    {{-- Profile information --}}
                    <div class="profile-side-card">
                        <div class="side-card-header"><h3>Provider information</h3></div>
                        <div class="side-card-body">
                            <div class="profile-info-list">

                                @if($phone)
                                    <div class="profile-info-item">
                                        <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
                                        <div>
                                            <span class="info-label">Phone</span>
                                            <span class="info-value"><a href="tel:{{ $phone }}">{{ $phone }}</a></span>
                                        </div>
                                    </div>
                                @endif

                                @if($email)
                                    <div class="profile-info-item">
                                        <div class="info-icon"><i class="fa-regular fa-envelope"></i></div>
                                        <div>
                                            <span class="info-label">Email</span>
                                            <span class="info-value"><a href="mailto:{{ $email }}">{{ $email }}</a></span>
                                        </div>
                                    </div>
                                @endif

                                @if($city)
                                    <div class="profile-info-item">
                                        <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
                                        <div>
                                            <span class="info-label">Location</span>
                                            <span class="info-value">{{ $city }}</span>
                                        </div>
                                    </div>
                                @endif

                                <div class="profile-info-item">
                                    <div class="info-icon"><i class="fa-solid fa-check"></i></div>
                                    <div>
                                        <span class="info-label">Completed jobs</span>
                                        <span class="info-value">{{ number_format($totalSales) }}</span>
                                    </div>
                                </div>

                                <div class="profile-info-item">
                                    <div class="info-icon"><i class="fa-solid fa-star"></i></div>
                                    <div>
                                        <span class="info-label">Overall rating</span>
                                        <span class="info-value">{{ number_format($averageRating, 1) }} / 5</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Rating --}}
                    <div class="profile-side-card">
                        <div class="side-card-header"><h3>Customer rating</h3></div>
                        <div class="side-card-body">
                            <div class="rating-summary">
                                <div class="rating-score">{{ number_format($averageRating, 1) }}</div>
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
                                    <div class="rating-count">
                                        {{ $ratingCount }} {{ $ratingCount === 1 ? 'review' : 'reviews' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Working hours --}}
                    <div class="profile-side-card">
                        <div class="side-card-header"><h3>Working hours</h3></div>
                        <div class="side-card-body">
                            @forelse($workingHours as $workingHour)
                                <div class="working-hour-row">
                                    <span class="working-hour-day">{{ Carbon::parse($workingHour->day)->format('D') }}</span>
                                    @if($workingHour->is_closed)
                                        <span class="working-hour-closed">Closed</span>
                                    @else
                                        <span class="working-hour-time">
                                            {{ Carbon::parse($workingHour->start_time)->format('h:i A') }}
                                            –
                                            {{ Carbon::parse($workingHour->end_time)->format('h:i A') }}
                                        </span>
                                    @endif
                                </div>
                            @empty
                                <div class="profile-empty">Working hours not available.</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Share --}}
                    <div class="profile-side-card">
                        <div class="side-card-header"><h3>Share profile</h3></div>
                        <div class="side-card-body">
                            <div class="share-buttons">
                                <a href="#" onclick="shareOnFacebook(event)" class="share-button" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#" onclick="shareOnWhatsApp(event)" class="share-button" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                                <a href="#" onclick="shareOnLinkedIn(event)" class="share-button" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                                <a href="#" onclick="shareOnTwitter(event)" class="share-button" title="X"><i class="fa-brands fa-x-twitter"></i></a>
                                <a href="#" onclick="copyProfileLink(event)" class="share-button" title="Copy link"><i class="fa-solid fa-link"></i></a>
                            </div>
                        </div>
                    </div>

                </aside>

                {{-- =================================================
                     PROFILE CONTENT (TABBED)
                ================================================== --}}

                <div class="profile-content">

                    {{-- Tab navigation --}}
                    <div class="profile-tabnav" role="tablist" aria-label="Profile sections">

                        <button type="button" class="profile-tab-btn is-active" data-tab="overview" role="tab" aria-selected="true" onclick="switchProfileTab('overview')">
                            <i class="fa-regular fa-id-card"></i>
                            <span class="tab-label">Overview</span>
                        </button>

                        <button type="button" class="profile-tab-btn" data-tab="services" role="tab" aria-selected="false" onclick="switchProfileTab('services')">
                            <i class="fa-solid fa-briefcase"></i>
                            <span class="tab-label">Services</span>
                            <span class="tab-count">{{ $serviceCount }}</span>
                        </button>

                        @if($portfolioCount)
                            <button type="button" class="profile-tab-btn" data-tab="portfolio" role="tab" aria-selected="false" onclick="switchProfileTab('portfolio')">
                                <i class="fa-regular fa-images"></i>
                                <span class="tab-label">Portfolio</span>
                                <span class="tab-count">{{ $portfolioCount }}</span>
                            </button>
                        @endif

                        <button type="button" class="profile-tab-btn" data-tab="reviews" role="tab" aria-selected="false" onclick="switchProfileTab('reviews')">
                            <i class="fa-regular fa-star"></i>
                            <span class="tab-label">Reviews</span>
                            <span class="tab-count">{{ $reviewsAndFeedbackCount }}</span>
                        </button>

                        @if($city || $email)
                            <button type="button" class="profile-tab-btn" data-tab="contact" role="tab" aria-selected="false" onclick="switchProfileTab('contact')">
                                <i class="fa-regular fa-paper-plane"></i>
                                <span class="tab-label">Contact</span>
                            </button>
                        @endif

                    </div>

                    {{-- =================================================
                         TAB: OVERVIEW
                    ================================================== --}}

                    <section class="profile-tabpanel is-active" data-tabpanel="overview">

                        <div class="profile-stats">
                            <div class="profile-stat">
                                <span class="profile-stat-label">Completed jobs</span>
                                <strong class="profile-stat-value">{{ number_format($totalSales) }}</strong>
                            </div>
                            <div class="profile-stat">
                                <span class="profile-stat-label">Rating</span>
                                <strong class="profile-stat-value">{{ number_format($averageRating, 1) }}</strong>
                            </div>
                            <div class="profile-stat">
                                <span class="profile-stat-label">Services</span>
                                <strong class="profile-stat-value">{{ $serviceCount }}</strong>
                            </div>
                        </div>

                        <section class="profile-section-card">

                            <div class="section-heading">
                                <div class="section-heading-left">
                                    <span class="section-eyebrow">Professional profile</span>
                                    <h3>About {{ $providerName }}</h3>
                                </div>
                            </div>

                            @if($hasAboutContent)

                                <div class="about-subsection">
                                    <div class="profile-text">
                                        @if(!empty($sproviders->about))
                                            {!! $sproviders->about !!}
                                        @else
                                            <div class="profile-empty">This provider has not added an about description yet.</div>
                                        @endif
                                    </div>
                                </div>

                                @if(!empty($sproviders->skills))
                                    <div class="about-subsection">
                                        <div class="about-subsection-title">Skills &amp; expertise</div>
                                        <div class="rich-content">{!! $sproviders->skills !!}</div>
                                    </div>
                                @endif

                                @if(!empty($sproviders->qualification))
                                    <div class="about-subsection">
                                        <div class="about-subsection-title">Qualifications</div>
                                        <div class="rich-content">{!! $sproviders->qualification !!}</div>
                                    </div>
                                @endif

                                @if(!empty($sproviders->experience))
                                    <div class="about-subsection">
                                        <div class="about-subsection-title">Experience</div>
                                        <div class="rich-content">{!! $sproviders->experience !!}</div>
                                    </div>
                                @endif

                            @else

                                <div class="profile-empty">This provider has not added an about description yet.</div>

                            @endif

                        </section>

                    </section>

                    {{-- =================================================
                         TAB: SERVICES
                    ================================================== --}}

                    <section class="profile-tabpanel" data-tabpanel="services">

                        <section class="profile-section-card">

                            <div class="section-heading">
                                <div class="section-heading-left">
                                    <span class="section-eyebrow">Marketplace</span>
                                    <h3>Services provided</h3>
                                    <p>Explore the services available from {{ $providerName }}.</p>
                                </div>
                            </div>

                            @forelse($groupedServices as $subcategoryName => $services)

                                <div class="service-category-section">

                                    <div class="service-category-title">{{ $subcategoryName }}</div>

                                    <div class="services-grid">
                                        @foreach($services as $service)

                                            @php
                                                $serviceImage = !empty($service->image)
                                                    ? asset('image/services/' . $service->image)
                                                    : asset('image/services/default.png');

                                                $servicePrice = (float) ($service->price ?? 0);
                                                $serviceTotal = $servicePrice;

                                                if (!empty($service->discount) && $service->discount_type === 'fixed') {
                                                    $serviceTotal = $servicePrice - (float) $service->discount;
                                                }

                                                if (!empty($service->discount) && $service->discount_type === 'percent') {
                                                    $serviceTotal = $servicePrice - ($servicePrice * ((float) $service->discount / 100));
                                                }

                                                $serviceTotal = max(0, $serviceTotal);
                                            @endphp

                                            <article class="service-card">

                                                <a href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}" class="service-image">
                                                    <img
                                                        src="{{ $serviceImage }}"
                                                        alt="{{ $service->name }}"
                                                        loading="lazy"
                                                        onerror="this.onerror=null;this.src='{{ asset('image/services/default.png') }}';"
                                                    >
                                                    @if(!empty($service->duration))
                                                        <span class="service-duration">{{ $service->duration }}</span>
                                                    @endif
                                                </a>

                                                <div class="service-body">

                                                    <span class="service-subcategory">{{ optional($service->subcategory)->name ?? 'Service' }}</span>

                                                    <a href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}" class="service-title">
                                                        {{ $service->name }}
                                                    </a>

                                                    <div class="service-price-row">
                                                        <div>
                                                            <span class="service-price-label">Price</span>
                                                            <strong class="service-price">{{ number_format($serviceTotal, 0) }} RWF</strong>
                                                        </div>

                                                        @if(!empty($service->discount) && $service->discount > 0)
                                                            <span class="promotion-discount">
                                                                @if($service->discount_type === 'percent')
                                                                    -{{ $service->discount }}%
                                                                @else
                                                                    Discount
                                                                @endif
                                                            </span>
                                                        @endif
                                                    </div>

                                                    @if(!empty($service->location))
                                                        <div class="service-location">
                                                            <i class="fa-solid fa-location-dot"></i>
                                                            <span>{{ $service->location }}</span>
                                                        </div>
                                                    @endif

                                                    <div class="service-buttons">
                                                        <a href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}" class="service-button service-button-outline">
                                                            View service
                                                        </a>
                                                        <a href="{{ route('home.booking', ['service_slug' => $service->slug]) }}" class="service-button service-button-primary">
                                                            Book now
                                                        </a>
                                                    </div>

                                                </div>

                                            </article>

                                        @endforeach
                                    </div>

                                </div>

                            @empty

                                <div class="profile-empty">No services have been added by this provider yet.</div>

                            @endforelse

                        </section>

                        @if($activePromotions->count())

                            <section class="profile-section-card">

                                <div class="section-heading">
                                    <div class="section-heading-left">
                                        <span class="section-eyebrow">Limited-time offers</span>
                                        <h3>Promotions for you</h3>
                                        <p>Save on selected services from this provider.</p>
                                    </div>
                                </div>

                                <div class="promotion-grid">
                                    @foreach($activePromotions as $promotion)

                                        @php
                                            $promotionService = $promotion->service;

                                            if (!$promotionService) {
                                                continue;
                                            }

                                            $promotionImage = !empty($promotionService->image)
                                                ? asset('image/services/' . $promotionService->image)
                                                : asset('image/services/default.png');

                                            $promotionPrice = (float) ($promotionService->price ?? 0);
                                        @endphp

                                        <article class="promotion-card">

                                            <a href="{{ route('home.service_details', ['service_slug' => $promotionService->slug]) }}" class="promotion-image">
                                                <img
                                                    src="{{ $promotionImage }}"
                                                    alt="{{ $promotion->title }}"
                                                    loading="lazy"
                                                    onerror="this.onerror=null;this.src='{{ asset('image/services/default.png') }}';"
                                                >
                                                <span class="promotion-discount">-{{ $promotion->discount }}%</span>
                                            </a>

                                            <div class="promotion-body">

                                                <span class="promotion-category">{{ optional($promotion->category)->name ?? 'Promotion' }}</span>

                                                <a href="{{ route('home.service_details', ['service_slug' => $promotionService->slug]) }}" class="promotion-title">
                                                    {{ $promotion->title }}
                                                </a>

                                                <p class="promotion-description">{{ Str::limit($promotion->description, 80) }}</p>

                                                <div class="promotion-meta">
                                                    <div>
                                                        <span>Price</span>
                                                        <strong>{{ number_format($promotionPrice, 0) }} RWF</strong>
                                                    </div>
                                                    <div style="text-align:right;">
                                                        <span>Ends</span>
                                                        <strong>{{ Carbon::parse($promotion->end_date)->format('d M Y') }}</strong>
                                                    </div>
                                                </div>

                                                <div class="promotion-actions">
                                                    <a href="{{ route('home.service_details', ['service_slug' => $promotionService->slug]) }}" class="service-button service-button-outline">
                                                        View service
                                                    </a>
                                                    <a href="{{ route('home.booking', ['service_slug' => $promotionService->slug]) }}" class="service-button service-button-primary">
                                                        Book now
                                                    </a>
                                                </div>

                                            </div>

                                        </article>

                                    @endforeach
                                </div>

                            </section>

                        @endif

                    </section>

                    {{-- =================================================
                         TAB: PORTFOLIO
                    ================================================== --}}

                    @if($portfolioCount)

                        <section class="profile-tabpanel" data-tabpanel="portfolio">

                            <section class="profile-section-card">

                                <div class="section-heading">
                                    <div class="section-heading-left">
                                        <span class="section-eyebrow">Recent work</span>
                                        <h3>Portfolio</h3>
                                        <p>A selection of work from {{ $providerName }}.</p>
                                    </div>
                                </div>

                                <div class="portfolio-grid">
                                    @foreach($portfolios as $portfolio)
                                        <a href="{{ asset('image/portfolios/' . $portfolio->image) }}" target="_blank" class="portfolio-item">
                                            <img
                                                src="{{ asset('image/portfolios/' . $portfolio->image) }}"
                                                alt="{{ $providerName }} portfolio"
                                                loading="lazy"
                                            >
                                            <span class="portfolio-view-icon"><i class="fa-solid fa-expand"></i></span>
                                        </a>
                                    @endforeach
                                </div>

                            </section>

                        </section>

                    @endif

                    {{-- =================================================
                         TAB: REVIEWS
                    ================================================== --}}

                    <section class="profile-tabpanel" data-tabpanel="reviews">

                        <section class="profile-section-card">

                            <div class="section-heading">
                                <div class="section-heading-left">
                                    <span class="section-eyebrow">Customer experiences</span>
                                    <h3>Reviews &amp; ratings</h3>
                                    <p>See what customers are saying about this provider.</p>
                                </div>
                            </div>

                            @if(isset($ratings) && $ratings->count())

                                <div class="review-list">
                                    @foreach($ratings as $rating)
                                        <div class="review-item">

                                            <div class="review-top">

                                                <div class="review-user">
                                                    <div class="review-avatar">{{ strtoupper(substr($rating->name ?? 'U', 0, 1)) }}</div>
                                                    <div>
                                                        <div class="review-user-name">{{ $rating->name ?? 'Customer' }}</div>
                                                        <div class="review-date">
                                                            @if($rating->created_at)
                                                                {{ $rating->created_at->format('d M Y') }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="review-rating">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= (int) $rating->rating)
                                                            <i class="fa-solid fa-star"></i>
                                                        @else
                                                            <i class="fa-regular fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>

                                            </div>

                                            @if(!empty($rating->message))
                                                <p class="review-message">{{ $rating->message }}</p>
                                            @endif

                                        </div>
                                    @endforeach
                                </div>

                            @else

                                <div class="profile-empty">No reviews have been submitted yet.</div>

                            @endif

                            {{-- Add rating --}}
                            <div style="margin-top:25px;">

                                <div class="section-heading" style="margin-bottom:15px;">
                                    <div class="section-heading-left">
                                        <h3 style="font-size:16px;">Leave a rating</h3>
                                    </div>
                                </div>

                                <form action="{{ route('rating.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="Service_Provider_ID" value="{{ $sproviders->id }}">

                                    <div class="connector-form-group">
                                        <label class="connector-form-label">Your rating</label>
                                        <div class="rating-input">
                                            @for($i = 5; $i >= 1; $i--)
                                                <input type="radio" name="rating" value="{{ $i }}" id="profile-rating-{{ $i }}">
                                                <label for="profile-rating-{{ $i }}" title="{{ $i }} stars">★</label>
                                            @endfor
                                        </div>
                                    </div>

                                    <div class="connector-form-group">
                                        <label for="rating-message" class="connector-form-label">Comment</label>
                                        <textarea id="rating-message" name="message" class="connector-form-control" rows="4" placeholder="Share your experience..."></textarea>
                                        @error('message')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <button type="submit" class="connector-submit">Submit review</button>

                                </form>

                            </div>

                        </section>

                        <section class="profile-section-card">

                            <div class="section-heading">
                                <div class="section-heading-left">
                                    <span class="section-eyebrow">Community feedback</span>
                                    <h3>User feedback</h3>
                                </div>

                                <a href="#" data-bs-toggle="modal" data-bs-target="#FeedbackModal" class="service-button service-button-primary" style="padding:0 14px;">
                                    Add feedback
                                </a>
                            </div>

                            @if(isset($feedback) && $feedback->count())

                                <div id="feedbackCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                                    <div class="carousel-inner">
                                        @foreach($feedback as $index => $item)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <div class="feedback-item">
                                                    <div class="feedback-quote"><i class="fa-solid fa-quote-left"></i></div>
                                                    <div class="feedback-message">{{ $item->message }}</div>
                                                    @if($item->created_at)
                                                        <span class="feedback-date">Posted {{ $item->created_at->format('d M Y') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if($feedback->count() > 1)
                                        <button class="carousel-control-prev" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        </button>
                                    @endif
                                </div>

                            @else

                                <div class="profile-empty">No feedback has been submitted yet.</div>

                            @endif

                        </section>

                    </section>

                    {{-- =================================================
                         TAB: CONTACT
                    ================================================== --}}

                    @if($city || $email)

                        <section class="profile-tabpanel" data-tabpanel="contact">

                            @if($city)
                                <section class="profile-section-card">

                                    <div class="section-heading">
                                        <div class="section-heading-left">
                                            <span class="section-eyebrow">Service area</span>
                                            <h3>Location</h3>
                                            <p>{{ $city }}</p>
                                        </div>
                                    </div>

                                    <div style="width:100%;height:330px;overflow:hidden;border-radius:14px;border:1px solid var(--connector-border);">
                                        <iframe
                                            src="https://maps.google.com/maps?width=600&height=400&hl=en&q={{ urlencode($city) }}&t=&z=12&ie=UTF8&iwloc=B&output=embed"
                                            width="100%"
                                            height="100%"
                                            style="border:0;"
                                            loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade"
                                        ></iframe>
                                    </div>

                                </section>
                            @endif

                            @if($email)
                                <section class="profile-section-card email-form-card" id="sendEmail">

                                    <div class="section-heading">
                                        <div class="section-heading-left">
                                            <span class="section-eyebrow">Direct contact</span>
                                            <h3>Contact {{ $providerName }}</h3>
                                            <p>Send a direct inquiry about a service, quotation or availability.</p>
                                        </div>
                                    </div>

                                    @if(Session::has('message'))
                                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                                    @endif

                                    <form action="/sendEmailInquiry" method="POST">
                                        @csrf
                                        <input type="hidden" name="proEmail" value="{{ $email }}">

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="connector-form-group">
                                                    <label for="contact-name" class="connector-form-label">Name</label>
                                                    <input type="text" id="contact-name" name="name" class="connector-form-control" placeholder="Your name" required>
                                                    @error('name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="connector-form-group">
                                                    <label for="contact-phone" class="connector-form-label">Phone</label>
                                                    <input type="text" id="contact-phone" name="phone" class="connector-form-control" placeholder="Your phone number">
                                                    @error('phone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="connector-form-group">
                                                    <label for="contact-email" class="connector-form-label">Email</label>
                                                    <input type="email" id="contact-email" name="email" class="connector-form-control" placeholder="you@example.com" required>
                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="connector-form-group">
                                                    <label for="contact-subject" class="connector-form-label">Subject</label>
                                                    <input type="text" id="contact-subject" name="subject" class="connector-form-control" placeholder="What can we help with?">
                                                    @error('subject')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="connector-form-group">
                                                    <label for="contact-message" class="connector-form-label">Message</label>
                                                    <textarea id="contact-message" name="message" class="connector-form-control" placeholder="Tell the provider what you need..." required></textarea>
                                                    @error('message')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" class="connector-submit">
                                                    <i class="fa-regular fa-paper-plane me-1"></i>
                                                    Send inquiry
                                                </button>
                                            </div>

                                        </div>

                                    </form>

                                </section>
                            @endif

                        </section>

                    @endif

                </div>

            </div>
        </div>
    </main>

</div>

{{-- =========================================================
     FEEDBACK MODAL
========================================================= --}}

<div class="modal fade" id="FeedbackModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius:18px;overflow:hidden;">

            <div class="modal-header border-0 px-4 pt-4">
                <div>
                    <span class="section-eyebrow">Community</span>
                    <h5 class="modal-title" style="color:var(--connector-text);font-weight:800;">Share your feedback</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 pb-4">
                <form method="POST" action="{{ route('feedback.store') }}">
                    @csrf
                    <input type="hidden" name="Service_Provider_ID" value="{{ $sproviders->id }}">

                    <div class="connector-form-group">
                        <label for="feedback-message" class="connector-form-label">Your feedback</label>
                        <textarea id="feedback-message" name="message" class="connector-form-control" rows="5" placeholder="Tell others about your experience..." required></textarea>
                        @error('message')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="connector-submit">Submit feedback</button>

                </form>
            </div>

        </div>
    </div>
</div>

<script>

    const providerProfileUrl = @json($profileUrl);
    const providerProfileText = @json('Check out ' . $providerName . ' on Connector.');

    /*
    |--------------------------------------------------------------------------
    | Tabs
    |--------------------------------------------------------------------------
    */

    function switchProfileTab(tabName) {

        document.querySelectorAll('.profile-tab-btn').forEach(function (btn) {
            const isActive = btn.getAttribute('data-tab') === tabName;
            btn.classList.toggle('is-active', isActive);
            btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });

        document.querySelectorAll('.profile-tabpanel').forEach(function (panel) {
            panel.classList.toggle('is-active', panel.getAttribute('data-tabpanel') === tabName);
        });

        const activeBtn = document.querySelector('.profile-tab-btn[data-tab="' + tabName + '"]');
        if (activeBtn) {
            activeBtn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        }

        const nav = document.querySelector('.profile-tabnav');
        if (nav) {
            const navTop = nav.getBoundingClientRect().top + window.scrollY - 90;
            if (window.scrollY > navTop) {
                window.scrollTo({ top: navTop, behavior: 'smooth' });
            }
        }

        if (history.replaceState) {
            history.replaceState(null, '', '#' + tabName);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const hash = window.location.hash.replace('#', '');
        if (hash && document.querySelector('.profile-tab-btn[data-tab="' + hash + '"]')) {
            switchProfileTab(hash);
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Share Profile
    |--------------------------------------------------------------------------
    */

    function shareProviderProfile() {
        if (navigator.share) {
            navigator.share({
                title: @json($providerName . ' - Connector'),
                text: providerProfileText,
                url: providerProfileUrl
            }).catch(() => {});
            return;
        }
        copyProfileLink();
    }

    /*
    |--------------------------------------------------------------------------
    | Copy Profile Link
    |--------------------------------------------------------------------------
    */

    function copyProfileLink(event) {
        if (event) {
            event.preventDefault();
        }

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(providerProfileUrl)
                .then(function () { showShareMessage('Profile link copied'); })
                .catch(function () { fallbackCopy(); });
        } else {
            fallbackCopy();
        }
    }

    function fallbackCopy() {
        const textarea = document.createElement('textarea');
        textarea.value = providerProfileUrl;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();

        try {
            document.execCommand('copy');
            showShareMessage('Profile link copied');
        } catch (error) {
            alert(providerProfileUrl);
        }

        document.body.removeChild(textarea);
    }

    /*
    |--------------------------------------------------------------------------
    | Facebook
    |--------------------------------------------------------------------------
    */

    function shareOnFacebook(event) {
        event.preventDefault();
        const url = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(providerProfileUrl);
        window.open(url, '_blank', 'width=650,height=500');
    }

    /*
    |--------------------------------------------------------------------------
    | WhatsApp
    |--------------------------------------------------------------------------
    */

    function shareOnWhatsApp(event) {
        event.preventDefault();
        const text = providerProfileText + ' ' + providerProfileUrl;
        const url = 'https://wa.me/?text=' + encodeURIComponent(text);
        window.open(url, '_blank');
    }

    /*
    |--------------------------------------------------------------------------
    | LinkedIn
    |--------------------------------------------------------------------------
    */

    function shareOnLinkedIn(event) {
        event.preventDefault();
        const url = 'https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(providerProfileUrl);
        window.open(url, '_blank', 'width=650,height=500');
    }

    /*
    |--------------------------------------------------------------------------
    | X / Twitter
    |--------------------------------------------------------------------------
    */

    function shareOnTwitter(event) {
        event.preventDefault();
        const url = 'https://twitter.com/intent/tweet?url=' + encodeURIComponent(providerProfileUrl) + '&text=' + encodeURIComponent(providerProfileText);
        window.open(url, '_blank', 'width=650,height=500');
    }

    /*
    |--------------------------------------------------------------------------
    | Share notification
    |--------------------------------------------------------------------------
    */

    function showShareMessage(message) {
        const existing = document.getElementById('profileShareToast');
        if (existing) {
            existing.remove();
        }

        const toast = document.createElement('div');
        toast.id = 'profileShareToast';
        toast.innerHTML = '<i class="fa-solid fa-check"></i> ' + message;
        toast.style.cssText = `
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 99999;
            padding: 12px 16px;
            border-radius: 10px;
            background: #254035;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            box-shadow: 0 12px 30px rgba(0,0,0,.18);
        `;

        document.body.appendChild(toast);
        setTimeout(function () { toast.remove(); }, 2500);
    }

</script>

@endsection