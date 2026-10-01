@extends('layouts.app')

@section('title', ($details->name ?? 'Service') . ' | Service Details')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | Service Image
    |--------------------------------------------------------------------------
    */
    $image = $details->image ?: 'default.png';

    $imagePath = public_path(
        'image/services/' . ltrim($image, '/')
    );

    $imageUrl = file_exists($imagePath)
        ? asset('image/services/' . ltrim($image, '/'))
        : asset('image/services/default.png');


    /*
    |--------------------------------------------------------------------------
    | Pricing
    |--------------------------------------------------------------------------
    */
    $price = (float) ($details->price ?? 0);
    $discount = (float) ($details->discount ?? 0);
    $discountType = strtolower($details->discount_type ?? '');

    if ($discount > 0) {

        if (in_array($discountType, [
            'percentage',
            'percent',
            '%'
        ])) {

            $discountAmount = ($price * $discount) / 100;

            $finalPrice = max(
                0,
                $price - $discountAmount
            );

            $discountLabel =
                rtrim(
                    rtrim(
                        number_format($discount, 2),
                        '0'
                    ),
                    '.'
                ) . '% OFF';

        } else {

            $discountAmount = $discount;

            $finalPrice = max(
                0,
                $price - $discountAmount
            );

            $discountLabel =
                number_format($discountAmount) . ' RWF OFF';
        }

    } else {

        $discountAmount = 0;
        $finalPrice = $price;
        $discountLabel = null;
    }


    /*
    |--------------------------------------------------------------------------
    | Collections
    |--------------------------------------------------------------------------
    */
    $inclusions = collect(
        preg_split(
            '/\s*\|\s*/',
            $details->inclusion ?? ''
        )
    )
        ->filter(
            fn ($item) => trim($item) !== ''
        )
        ->values();

    $exclusions = collect(
        preg_split(
            '/\s*\|\s*/',
            $details->exclusion ?? ''
        )
    )
        ->filter(
            fn ($item) => trim($item) !== ''
        )
        ->values();


    $ratings = $details->ratings ?? collect();

    $media = $details->media ?? collect();

    $portfolios = $details->portfolios ?? collect();

    $staffMembers = $details->staffMembers ?? collect();


    $mediaImages = $media
        ->where('type', 'image')
        ->values();

    $mediaVideos = $media
        ->where('type', 'video')
        ->values();


    /*
    |--------------------------------------------------------------------------
    | Rating
    |--------------------------------------------------------------------------
    */
    $ratingValues = $ratings
        ->map(function ($rating) {

            return (float) (
                $rating->rating
                ?? $rating->stars
                ?? $rating->score
                ?? 0
            );
        })
        ->filter(
            fn ($rating) => $rating > 0
        );

    $averageRating = $ratingValues->count()
        ? round($ratingValues->avg(), 1)
        : 0;

    $ratingCount = $ratingValues->count();


    /*
    |--------------------------------------------------------------------------
    | Provider
    |--------------------------------------------------------------------------
    */
    $provider = $details->provider;

    $providerName =
        $provider?->name
        ?? $provider?->business_name
        ?? $provider?->company_name
        ?? 'Service Provider';

    $providerInitials = collect(
        explode(
            ' ',
            trim($providerName)
        )
    )
        ->filter()
        ->take(2)
        ->map(
            fn ($name) =>
                strtoupper(
                    substr($name, 0, 1)
                )
        )
        ->implode('');


    /*
    |--------------------------------------------------------------------------
    | Service Status
    |--------------------------------------------------------------------------
    */
    $isActive = (bool) $details->status;
@endphp


<style>

    /*
    |--------------------------------------------------------------------------
    | PAGE
    |--------------------------------------------------------------------------
    */

    .service-detail-page {
        background: #f4f8f6;
        min-height: 100vh;
        padding-bottom: 60px;
    }


    /*
    |--------------------------------------------------------------------------
    | HERO
    |--------------------------------------------------------------------------
    */

    .service-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(
            135deg,
            #254035 0%,
            #315646 55%,
            #6b9080 100%
        );
        padding: 44px 0;
    }

    .service-hero::before {
        content: "";
        position: absolute;
        width: 420px;
        height: 420px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
        right: -150px;
        top: -200px;
    }

    .service-hero::after {
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,.04);
        left: -100px;
        bottom: -150px;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: rgba(255,255,255,.78);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 20px;
        transition: .2s ease;
    }

    .back-link:hover {
        color: #fff;
    }

    .hero-title {
        color: #fff;
        font-size: clamp(27px, 3vw, 42px);
        line-height: 1.15;
        font-weight: 750;
        margin-bottom: 12px;
    }

    .hero-description {
        max-width: 760px;
        color: rgba(255,255,255,.75);
        font-size: 14px;
        line-height: 1.75;
        margin-bottom: 0;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 25px;
    }

    .btn-hero-light,
    .btn-hero-outline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 42px;
        padding: 9px 17px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .btn-hero-light {
        background: #fff;
        color: #254035;
        border: 1px solid #fff;
    }

    .btn-hero-light:hover {
        background: #edf5f1;
        color: #254035;
    }

    .btn-hero-outline {
        background: transparent;
        color: #fff;
        border: 1px solid rgba(255,255,255,.35);
    }

    .btn-hero-outline:hover {
        background: rgba(255,255,255,.1);
        color: #fff;
    }


    /*
    |--------------------------------------------------------------------------
    | CARDS
    |--------------------------------------------------------------------------
    */

    .detail-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e4ece8;
        border-radius: 16px;
        box-shadow: 0 5px 18px rgba(37,64,53,.045);
    }

    .detail-card-header {
        padding: 19px 21px;
        border-bottom: 1px solid #edf2ef;
    }

    .detail-card-body {
        padding: 21px;
    }

    .detail-card-title {
        color: #254035;
        font-size: 16px;
        font-weight: 750;
        margin: 0;
    }

    .detail-card-subtitle {
        color: #89958f;
        font-size: 12px;
        line-height: 1.6;
        margin-top: 4px;
        margin-bottom: 0;
    }


    /*
    |--------------------------------------------------------------------------
    | SERVICE IMAGE
    |--------------------------------------------------------------------------
    */

    .service-image-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 14px;
        background: #edf3f0;
    }

    .service-main-image {
        display: block;
        width: 100%;
        height: 360px;
        object-fit: cover;
    }

    .service-status {
        position: absolute;
        top: 14px;
        left: 14px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 8px;
        background: rgba(255,255,255,.95);
        color: #254035;
        font-size: 11px;
        font-weight: 750;
        box-shadow: 0 4px 12px rgba(0,0,0,.08);
    }

    .service-status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #6b9080;
    }


    /*
    |--------------------------------------------------------------------------
    | PRICE
    |--------------------------------------------------------------------------
    */

    .price-panel {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 18px;
        padding: 17px;
        border: 1px solid #e3ece7;
        border-radius: 12px;
        background: #f7faf8;
    }

    .price-label {
        display: block;
        color: #8b9691;
        font-size: 11px;
        font-weight: 650;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 4px;
    }

    .price-value {
        color: #254035;
        font-size: 23px;
        font-weight: 800;
    }

    .old-price {
        color: #a1aaa6;
        text-decoration: line-through;
        font-size: 12px;
        margin-left: 7px;
    }

    .discount-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 9px;
        border-radius: 7px;
        background: #e9f4ef;
        color: #315f4c;
        font-size: 10px;
        font-weight: 750;
    }


    /*
    |--------------------------------------------------------------------------
    | INFO GRID
    |--------------------------------------------------------------------------
    */

    .service-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-top: 18px;
    }

    .service-info-item {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        padding: 13px;
        border: 1px solid #e8efec;
        border-radius: 11px;
        background: #fff;
    }

    .service-info-icon {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #edf5f1;
        color: #254035;
        font-size: 17px;
    }

    .service-info-label {
        display: block;
        color: #9aa39f;
        font-size: 10px;
        font-weight: 650;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 2px;
    }

    .service-info-value {
        display: block;
        color: #254035;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.4;
    }


    /*
    |--------------------------------------------------------------------------
    | DESCRIPTION
    |--------------------------------------------------------------------------
    */

    .service-description {
        color: #66746e;
        font-size: 13px;
        line-height: 1.85;
        margin: 0;
    }


    /*
    |--------------------------------------------------------------------------
    | FEATURE LISTS
    |--------------------------------------------------------------------------
    */

    .feature-section {
        margin-top: 22px;
    }

    .feature-title {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #254035;
        font-size: 13px;
        font-weight: 750;
        margin-bottom: 11px;
    }

    .feature-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .feature-list li {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        color: #66746e;
        font-size: 12px;
        line-height: 1.5;
    }

    .feature-list li i {
        flex: 0 0 auto;
        color: #6b9080;
        font-size: 15px;
        margin-top: 1px;
    }

    .exclusion-list li i {
        color: #bd7777;
    }


    /*
    |--------------------------------------------------------------------------
    | PROVIDER
    |--------------------------------------------------------------------------
    */

    .provider-box {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .provider-avatar {
        width: 52px;
        height: 52px;
        flex: 0 0 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: #eaf3ef;
        color: #254035;
        font-size: 16px;
        font-weight: 800;
    }

    .provider-name {
        color: #254035;
        font-size: 14px;
        font-weight: 750;
        margin-bottom: 3px;
    }

    .provider-label {
        color: #929d98;
        font-size: 11px;
    }


    /*
    |--------------------------------------------------------------------------
    | RATING
    |--------------------------------------------------------------------------
    */

    .rating-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .rating-score {
        color: #254035;
        font-size: 29px;
        line-height: 1;
        font-weight: 800;
    }

    .rating-stars {
        color: #d6a842;
        font-size: 14px;
        letter-spacing: 1px;
    }

    .rating-count {
        color: #89958f;
        font-size: 11px;
        margin-top: 4px;
    }


    /*
    |--------------------------------------------------------------------------
    | RESOURCE STATS
    |--------------------------------------------------------------------------
    */

    .resource-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 8px;
    }

    .resource-item {
        padding: 13px 8px;
        border: 1px solid #e8efec;
        border-radius: 11px;
        text-align: center;
        background: #fbfcfc;
    }

    .resource-icon {
        color: #6b9080;
        font-size: 18px;
        margin-bottom: 5px;
    }

    .resource-value {
        display: block;
        color: #254035;
        font-size: 16px;
        font-weight: 800;
    }

    .resource-label {
        display: block;
        color: #919c97;
        font-size: 9px;
        font-weight: 650;
        text-transform: uppercase;
        letter-spacing: .04em;
    }


    /*
    |--------------------------------------------------------------------------
    | MEDIA TOOLBAR
    |--------------------------------------------------------------------------
    */

    .media-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .media-count {
        color: #7d8984;
        font-size: 11px;
        font-weight: 650;
    }

    .btn-add-media {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-height: 36px;
        padding: 7px 12px;
        border: 0;
        border-radius: 8px;
        background: #254035;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        transition: .2s ease;
    }

    .btn-add-media:hover {
        background: #315646;
        color: #fff;
        transform: translateY(-1px);
    }


    /*
    |--------------------------------------------------------------------------
    | MEDIA GRID
    |--------------------------------------------------------------------------
    */

    .media-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 13px;
    }

    .media-item {
        position: relative;
        overflow: hidden;
        height: 190px;
        border-radius: 12px;
        background: #eef3f0;
        cursor: pointer;
    }

    .media-item img,
    .media-item video {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .3s ease;
    }

    .media-item:hover img,
    .media-item:hover video {
        transform: scale(1.04);
    }

    .media-overlay {
        position: absolute;
        inset: auto 0 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 10px;
        background: linear-gradient(
            transparent,
            rgba(0,0,0,.72)
        );
        opacity: 0;
        transition: opacity .2s ease;
    }

    .media-item:hover .media-overlay {
        opacity: 1;
    }

    .media-type {
        color: #fff;
        font-size: 10px;
        font-weight: 700;
    }

    .media-actions {
        display: flex;
        gap: 5px;
    }

    .media-action-btn {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border: 0;
        border-radius: 7px;
        background: rgba(255,255,255,.94);
        color: #254035;
        font-size: 14px;
        cursor: pointer;
    }

    .media-action-btn:hover {
        background: #fff;
    }

    .media-video-icon {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }

    .media-video-icon i {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(37,64,53,.85);
        color: #fff;
        font-size: 19px;
        padding-left: 2px;
    }


    /*
    |--------------------------------------------------------------------------
    | EMPTY MEDIA
    |--------------------------------------------------------------------------
    */

    .media-empty {
        padding: 45px 20px;
        text-align: center;
        border: 1px dashed #d8e5df;
        border-radius: 13px;
        background: #f8fbf9;
    }

    .media-empty-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        background: #e9f2ed;
        color: #254035;
        font-size: 25px;
    }

    .media-empty h6 {
        color: #254035;
        font-size: 14px;
        font-weight: 750;
        margin-bottom: 6px;
    }

    .media-empty p {
        max-width: 450px;
        margin: 0 auto 17px;
        color: #7f8b86;
        font-size: 12px;
        line-height: 1.6;
    }


    /*
    |--------------------------------------------------------------------------
    | PORTFOLIO
    |--------------------------------------------------------------------------
    */

    .portfolio-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .portfolio-item {
        position: relative;
        overflow: hidden;
        border: 1px solid #e4ece8;
        border-radius: 14px;
        background: #fff;
    }

    .portfolio-preview-trigger {
        position: relative;
        display: block;
        width: 100%;
        padding: 0;
        border: 0;
        background: #f3f7f5;
        cursor: pointer;
        overflow: hidden;
    }

    .portfolio-image {
        display: block;
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform .3s ease;
    }

    .portfolio-preview-trigger:hover .portfolio-image {
        transform: scale(1.04);
    }

    .portfolio-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(37,64,53,.58);
        opacity: 0;
        transition: opacity .25s ease;
    }

    .portfolio-preview-trigger:hover .portfolio-overlay {
        opacity: 1;
    }

    .portfolio-view {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 14px;
        border-radius: 9px;
        background: #fff;
        color: #254035;
        font-size: 12px;
        font-weight: 700;
    }

    .portfolio-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 11px 12px;
    }

    .portfolio-tag {
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .portfolio-tag-icon {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #edf5f1;
        color: #254035;
    }

    .portfolio-tag small {
        display: block;
        margin-bottom: 2px;
        color: #89958f;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .portfolio-tag strong {
        display: block;
        max-width: 180px;
        overflow: hidden;
        color: #254035;
        font-size: 12px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .portfolio-delete-btn {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 34px;
        border: 1px solid #f0dede;
        border-radius: 9px;
        background: #fff7f7;
        color: #c94b4b;
        cursor: pointer;
        transition: all .2s ease;
    }

    .portfolio-delete-btn:hover {
        background: #c94b4b;
        border-color: #c94b4b;
        color: #fff;
    }

    .portfolio-empty {
        padding: 45px 20px;
        text-align: center;
        border: 1px dashed #d8e5df;
        border-radius: 14px;
        background: #f8fbf9;
    }

    .portfolio-empty-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: #e9f2ed;
        color: #254035;
        font-size: 25px;
    }

    .portfolio-empty h6 {
        margin-bottom: 6px;
        color: #254035;
        font-size: 15px;
        font-weight: 700;
    }

    .portfolio-empty p {
        max-width: 480px;
        margin: 0 auto 18px;
        color: #7a8781;
        font-size: 13px;
    }

    .portfolio-upload-preview {
        overflow: hidden;
        margin-top: 15px;
        border: 1px solid #e4ece8;
        border-radius: 12px;
        background: #f5f8f6;
    }

    .portfolio-upload-preview img {
        display: block;
        width: 100%;
        max-height: 280px;
        object-fit: contain;
    }

    .portfolio-preview-shell {
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
        border-radius: 14px;
        background: #f3f6f4;
    }

    .portfolio-preview-large {
        display: block;
        max-width: 100%;
        max-height: 75vh;
        object-fit: contain;
        border-radius: 10px;
    }


    /*
    |--------------------------------------------------------------------------
    | LOCATION
    |--------------------------------------------------------------------------
    */

    .location-box {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        padding: 14px;
        border-radius: 11px;
        background: #f7faf8;
        border: 1px solid #e6efeb;
    }

    .location-icon {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #e8f2ed;
        color: #254035;
    }

    .location-label {
        display: block;
        color: #929d98;
        font-size: 10px;
        text-transform: uppercase;
        font-weight: 650;
        letter-spacing: .05em;
        margin-bottom: 3px;
    }

    .location-value {
        color: #254035;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.5;
    }


    /*
    |--------------------------------------------------------------------------
    | ACTION CARD
    |--------------------------------------------------------------------------
    */

    .manage-action {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 12px;
        border: 1px solid #e5ece9;
        border-radius: 10px;
        background: #fff;
        color: #254035;
        text-decoration: none;
        transition: .2s ease;
    }

    .manage-action:hover {
        background: #f5f9f7;
        border-color: #cddcd5;
        color: #254035;
        transform: translateY(-1px);
    }

    .manage-action-icon {
        width: 35px;
        height: 35px;
        flex: 0 0 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #edf5f1;
        color: #254035;
    }

    .manage-action strong {
        display: block;
        font-size: 12px;
        font-weight: 750;
    }

    .manage-action small {
        display: block;
        margin-top: 2px;
        color: #929d98;
        font-size: 10px;
    }


    /*
    |--------------------------------------------------------------------------
    | MODALS
    |--------------------------------------------------------------------------
    */

    .modal-content {
        border-radius: 15px !important;
    }

    .modal-header {
        padding: 18px 20px;
        border-bottom: 1px solid #edf2ef;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #edf2ef;
    }

    .modal-subtitle {
        margin-top: 3px;
        color: #87938d;
        font-size: 12px;
    }

    .form-label {
        color: #254035;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .form-control {
        min-height: 42px;
        border-color: #dfe9e4;
        border-radius: 9px;
        color: #254035;
        font-size: 13px;
        box-shadow: none !important;
    }

    .form-control:focus {
        border-color: #6b9080;
        box-shadow: 0 0 0 3px rgba(107,144,128,.12) !important;
    }

    .form-text {
        color: #8b9691;
        font-size: 11px;
    }

    .btn-media-submit {
        padding: 9px 16px;
        border: 0;
        border-radius: 9px;
        background: #254035;
        color: #fff;
        font-size: 13px;
        font-weight: 650;
    }

    .btn-media-submit:hover {
        background: #315646;
        color: #fff;
    }

    .file-preview {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 8px;
        margin-top: 15px;
    }

    .file-preview-item {
        overflow: hidden;
        height: 85px;
        border-radius: 9px;
        background: #f2f6f4;
        border: 1px solid #e0e9e5;
    }

    .file-preview-item img,
    .file-preview-item video {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-shell {
        min-height: 450px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
        border-radius: 12px;
        background: #f3f6f4;
    }

    .preview-image {
        display: block;
        max-width: 100%;
        max-height: 72vh;
        object-fit: contain;
        border-radius: 8px;
    }

    .preview-video {
        display: block;
        width: 100%;
        max-height: 72vh;
        border-radius: 8px;
        background: #111;
    }


    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1199px) {

        .media-grid,
        .portfolio-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

    }

    @media (max-width: 991px) {

        .service-main-image {
            height: 320px;
        }

        .service-info-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

    }

    @media (max-width: 767px) {

        .service-hero {
            padding: 32px 0;
        }

        .hero-actions {
            flex-direction: column;
        }

        .btn-hero-light,
        .btn-hero-outline {
            width: 100%;
        }

        .detail-card-body,
        .detail-card-header {
            padding: 16px;
        }

        .service-main-image {
            height: 260px;
        }

        .media-grid,
        .portfolio-grid {
            grid-template-columns: 1fr 1fr;
        }

        .media-toolbar {
            align-items: flex-start;
            flex-direction: column;
        }

        .media-toolbar > div:last-child {
            width: 100%;
        }

        .media-toolbar .btn-add-media {
            width: 100%;
        }

    }

    @media (max-width: 575px) {

        .service-info-grid {
            grid-template-columns: 1fr;
        }

        .media-grid,
        .portfolio-grid {
            grid-template-columns: 1fr;
        }

        .portfolio-image {
            height: 220px;
        }

        .resource-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .price-panel {
            align-items: flex-start;
            flex-direction: column;
        }

        .file-preview {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

    }

</style>


<div class="service-detail-page">


    {{-- =========================================================
        HERO
    ========================================================== --}}

    <section class="service-hero">

        <div class="container">

            <div class="hero-content">

                <a href="{{ url()->previous() }}"
                   class="back-link">

                    <i class="mdi mdi-arrow-left"></i>
                    Back

                </a>

                <h1 class="hero-title">
                    {{ $details->name }}
                </h1>

                <p class="hero-description">
                    {{ \Illuminate\Support\Str::limit(
                        strip_tags($details->description ?? ''),
                        260
                    ) }}
                </p>

                <div class="hero-actions">

                    @if(Route::has('service.edit'))
                        <a href="{{ route('service.edit', $details->id) }}"
                           class="btn-hero-light">

                            <i class="mdi mdi-pencil-outline"></i>
                            Edit Service

                        </a>
                    @endif

                    @if(Route::has('services.index'))
                        <a href="{{ route('services.index') }}"
                           class="btn-hero-outline">

                            <i class="mdi mdi-view-grid-outline"></i>
                            All Services

                        </a>
                    @endif

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}

    <div class="container py-4">

        <div class="row g-4">


            {{-- =================================================
                LEFT COLUMN
            ================================================== --}}

            <div class="col-lg-8">


                {{-- =================================================
                    SERVICE INFORMATION
                ================================================== --}}

                <div class="detail-card">

                    <div class="detail-card-body">

                        <div class="service-image-wrapper">

                            <img src="{{ $imageUrl }}"
                                 alt="{{ $details->name }}"
                                 class="service-main-image"
                                 onerror="this.onerror=null;this.src='{{ asset('image/services/default.png') }}';">

                            <div class="service-status">

                                <span class="service-status-dot"></span>

                                {{ $isActive ? 'Active Service' : 'Inactive Service' }}

                            </div>

                        </div>


                        {{-- PRICE --}}

                        <div class="price-panel">

                            <div>

                                <span class="price-label">
                                    Service Price
                                </span>

                                <span class="price-value">
                                    {{ number_format($finalPrice) }}
                                    RWF
                                </span>

                                @if($discount > 0)

                                    <span class="old-price">
                                        {{ number_format($price) }} RWF
                                    </span>

                                @endif

                            </div>

                            @if($discountLabel)

                                <span class="discount-badge">
                                    {{ $discountLabel }}
                                </span>

                            @endif

                        </div>


                        {{-- SERVICE INFORMATION GRID --}}

                        <div class="service-info-grid">


                            <div class="service-info-item">

                                <div class="service-info-icon">
                                    <i class="mdi mdi-shape-outline"></i>
                                </div>

                                <div>

                                    <span class="service-info-label">
                                        Category
                                    </span>

                                    <span class="service-info-value">
                                        {{ $details->category?->name ?? 'Not specified' }}
                                    </span>

                                </div>

                            </div>


                            <div class="service-info-item">

                                <div class="service-info-icon">
                                    <i class="mdi mdi-format-list-bulleted"></i>
                                </div>

                                <div>

                                    <span class="service-info-label">
                                        Subcategory
                                    </span>

                                    <span class="service-info-value">
                                        {{ $details->subcategory?->name ?? 'Not specified' }}
                                    </span>

                                </div>

                            </div>


                            <div class="service-info-item">

                                <div class="service-info-icon">
                                    <i class="mdi mdi-clock-outline"></i>
                                </div>

                                <div>

                                    <span class="service-info-label">
                                        Duration
                                    </span>

                                    <span class="service-info-value">
                                        {{ $details->duration ?: 'Not specified' }}
                                    </span>

                                </div>

                            </div>


                            <div class="service-info-item">

                                <div class="service-info-icon">
                                    <i class="mdi mdi-map-marker-outline"></i>
                                </div>

                                <div>

                                    <span class="service-info-label">
                                        Location
                                    </span>

                                    <span class="service-info-value">
                                        {{ $details->location ?: 'Not specified' }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    SERVICE OVERVIEW
                ================================================== --}}

                <div class="detail-card mt-4">

                    <div class="detail-card-header">

                        <h4 class="detail-card-title">
                            Service Overview
                        </h4>

                        <p class="detail-card-subtitle">
                            Detailed information about this service.
                        </p>

                    </div>

                    <div class="detail-card-body">

                        <p class="service-description">
                            {!! nl2br(
                                e(
                                    $details->description
                                    ?? 'No service description has been provided.'
                                )
                            ) !!}
                        </p>

                    </div>

                </div>


                {{-- =================================================
                    SERVICE MEDIA
                ================================================== --}}

                <div class="detail-card mt-4">

                    <div class="detail-card-header">

                        <div class="media-toolbar">

                            <div>

                                <h4 class="detail-card-title">
                                    Service Media
                                </h4>

                                <p class="detail-card-subtitle">
                                    Photos and videos showcasing this service.
                                </p>

                            </div>

                            <div class="d-flex align-items-center gap-2">

                                <span class="media-count">

                                    {{ $media->count() }}

                                    {{ $media->count() == 1 ? 'file' : 'files' }}

                                </span>

                                <button type="button"
                                        class="btn btn-add-media"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addMediaModal">

                                    <i class="mdi mdi-plus"></i>

                                    Add Media

                                </button>

                            </div>

                        </div>

                    </div>


                    <div class="detail-card-body">

                        @if($media->count())

                            <div class="media-grid">

                                @foreach($media as $item)

                                    @php

                                        /*
                                         * Media controller stores files in:
                                         * public/image/services/
                                         */

                                        $mediaFile =
                                            ltrim(
                                                $item->file_path ?? '',
                                                '/'
                                            );

                                        $mediaPath =
                                            public_path(
                                                'image/services/' .
                                                $mediaFile
                                            );

                                        $mediaUrl =
                                            file_exists($mediaPath)
                                                ? asset(
                                                    'image/services/' .
                                                    $mediaFile
                                                )
                                                : asset(
                                                    'image/services/default.png'
                                                );

                                        $mediaType =
                                            strtolower(
                                                $item->type ?? 'image'
                                            );

                                    @endphp


                                    <div class="media-item"
                                         data-media-type="{{ $mediaType }}"
                                         data-media-url="{{ $mediaUrl }}"
                                         data-media-name="{{ $item->file_path }}"
                                         onclick="previewMedia(this)">


                                        @if($mediaType === 'video')

                                            <video preload="metadata"
                                                   muted
                                                   playsinline>

                                                <source src="{{ $mediaUrl }}">

                                            </video>

                                            <div class="media-video-icon">

                                                <i class="mdi mdi-play"></i>

                                            </div>

                                        @else

                                            <img src="{{ $mediaUrl }}"
                                                 alt="{{ $details->name }}"
                                                 loading="lazy"
                                                 onerror="this.onerror=null;this.src='{{ asset('image/services/default.png') }}';">

                                        @endif


                                        <div class="media-overlay">

                                            <span class="media-type">

                                                @if($mediaType === 'video')

                                                    <i class="mdi mdi-video-outline me-1"></i>
                                                    Video

                                                @else

                                                    <i class="mdi mdi-image-outline me-1"></i>
                                                    Image

                                                @endif

                                            </span>


                                            <div class="media-actions">

                                                <button type="button"
                                                        class="media-action-btn"
                                                        title="Preview"
                                                        onclick="event.stopPropagation(); previewMedia(this.closest('.media-item'))">

                                                    <i class="mdi mdi-eye-outline"></i>

                                                </button>


                                                <form action="{{ route('service-media.destroy', $item->id) }}"
                                                      method="POST"
                                                      class="delete-media-form"
                                                      onclick="event.stopPropagation();">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="media-action-btn"
                                                            title="Delete">

                                                        <i class="mdi mdi-delete-outline"></i>

                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="media-empty">

                                <div class="media-empty-icon">

                                    <i class="mdi mdi-image-multiple-outline"></i>

                                </div>

                                <h6>
                                    No media uploaded yet
                                </h6>

                                <p>
                                    Add photos or videos to make this service
                                    more informative and attractive.
                                </p>

                                <button type="button"
                                        class="btn btn-add-media"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addMediaModal">

                                    <i class="mdi mdi-plus me-1"></i>

                                    Add First Media

                                </button>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    SERVICE PORTFOLIO
                ================================================== --}}

                <div class="detail-card mt-4">

                    <div class="detail-card-header">

                        <div class="media-toolbar">

                            <div>

                                <h4 class="detail-card-title">
                                    Service Portfolio
                                </h4>

                                <p class="detail-card-subtitle">
                                    Showcase completed work and previous
                                    projects related to this service.
                                </p>

                            </div>

                            <div class="d-flex align-items-center gap-2">

                                <span class="media-count">

                                    {{ $portfolios->count() }}

                                    {{ $portfolios->count() == 1
                                        ? 'project'
                                        : 'projects' }}

                                </span>

                                <button type="button"
                                        class="btn btn-add-media"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addPortfolioModal">

                                    <i class="mdi mdi-plus"></i>

                                    Add Portfolio

                                </button>

                            </div>

                        </div>

                    </div>


                    <div class="detail-card-body">

                        @if($portfolios->count())

                            <div class="portfolio-grid">

                                @foreach($portfolios as $portfolio)

                                    @php

                                        $portfolioImage =
                                            $portfolio->image ?? '';

                                        $portfolioFile =
                                            ltrim(
                                                $portfolioImage,
                                                '/'
                                            );

                                        $portfolioPath =
                                            public_path(
                                                'image/services/' .
                                                $portfolioFile
                                            );

                                        $portfolioUrl =
                                            file_exists($portfolioPath)
                                                ? asset(
                                                    'image/services/' .
                                                    $portfolioFile
                                                )
                                                : asset(
                                                    'image/services/default.png'
                                                );

                                        $portfolioTag =
                                            $portfolio->tag
                                            ?: 'Portfolio';

                                    @endphp


                                    <div class="portfolio-item">


                                        <button type="button"
                                                class="portfolio-preview-trigger js-portfolio-preview"
                                                data-image="{{ $portfolioUrl }}"
                                                data-tag="{{ $portfolioTag }}">

                                            <img src="{{ $portfolioUrl }}"
                                                 alt="{{ $portfolioTag }}"
                                                 class="portfolio-image"
                                                 loading="lazy"
                                                 onerror="this.onerror=null;this.src='{{ asset('image/services/default.png') }}';">


                                            <div class="portfolio-overlay">

                                                <span class="portfolio-view">

                                                    <i class="mdi mdi-eye-outline"></i>

                                                    Preview

                                                </span>

                                            </div>

                                        </button>


                                        <div class="portfolio-meta">


                                            <div class="portfolio-tag">

                                                <span class="portfolio-tag-icon">

                                                    <i class="mdi mdi-briefcase-outline"></i>

                                                </span>


                                                <div>

                                                    <small>
                                                        Project
                                                    </small>

                                                    <strong>
                                                        {{ $portfolioTag }}
                                                    </strong>

                                                </div>

                                            </div>


                                            <form action="{{ route('portfolios.destroy', $portfolio->id) }}"
                                                  method="POST"
                                                  class="delete-portfolio-form">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="portfolio-delete-btn"
                                                        title="Delete portfolio">

                                                    <i class="mdi mdi-delete-outline"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="portfolio-empty">

                                <div class="portfolio-empty-icon">

                                    <i class="mdi mdi-briefcase-outline"></i>

                                </div>

                                <h6>
                                    No portfolio items yet
                                </h6>

                                <p>
                                    Add completed projects or previous work
                                    to showcase this service.
                                </p>

                                <button type="button"
                                        class="btn btn-add-media"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addPortfolioModal">

                                    <i class="mdi mdi-plus me-1"></i>

                                    Add First Portfolio

                                </button>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    INCLUSIONS / EXCLUSIONS
                ================================================== --}}

                @if(
                    $inclusions->count()
                    || $exclusions->count()
                )

                    <div class="detail-card mt-4">

                        <div class="detail-card-header">

                            <h4 class="detail-card-title">
                                What's Included
                            </h4>

                            <p class="detail-card-subtitle">
                                Service inclusions and exclusions.
                            </p>

                        </div>

                        <div class="detail-card-body">

                            <div class="row g-4">

                                @if($inclusions->count())

                                    <div class="col-md-6">

                                        <div class="feature-title">

                                            <i class="mdi mdi-check-circle-outline"></i>

                                            Included

                                        </div>

                                        <ul class="feature-list">

                                            @foreach($inclusions as $item)

                                                <li>

                                                    <i class="mdi mdi-check-circle"></i>

                                                    <span>
                                                        {{ trim($item) }}
                                                    </span>

                                                </li>

                                            @endforeach

                                        </ul>

                                    </div>

                                @endif


                                @if($exclusions->count())

                                    <div class="col-md-6">

                                        <div class="feature-title">

                                            <i class="mdi mdi-close-circle-outline"></i>

                                            Not Included

                                        </div>

                                        <ul class="feature-list exclusion-list">

                                            @foreach($exclusions as $item)

                                                <li>

                                                    <i class="mdi mdi-close-circle"></i>

                                                    <span>
                                                        {{ trim($item) }}
                                                    </span>

                                                </li>

                                            @endforeach

                                        </ul>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                @endif


            </div>


            {{-- =================================================
                RIGHT COLUMN
            ================================================== --}}

            <div class="col-lg-4">


                {{-- =================================================
                    PROVIDER
                ================================================== --}}

                <div class="detail-card">

                    <div class="detail-card-header">

                        <h4 class="detail-card-title">
                            Service Provider
                        </h4>

                        <p class="detail-card-subtitle">
                            Provider responsible for this service.
                        </p>

                    </div>

                    <div class="detail-card-body">

                        <div class="provider-box">

                            <div class="provider-avatar">

                                {{ $providerInitials ?: 'SP' }}

                            </div>

                            <div>

                                <div class="provider-name">
                                    {{ $providerName }}
                                </div>

                                <div class="provider-label">
                                    Service Provider
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    RATING
                ================================================== --}}

                <div class="detail-card mt-4">

                    <div class="detail-card-header">

                        <h4 class="detail-card-title">
                            Service Rating
                        </h4>

                    </div>

                    <div class="detail-card-body">

                        <div class="rating-box">

                            <div>

                                <div class="rating-score">
                                    {{ number_format($averageRating, 1) }}
                                </div>

                                <div class="rating-stars">

                                    @for($i = 1; $i <= 5; $i++)

                                        @if($averageRating >= $i)

                                            <i class="mdi mdi-star"></i>

                                        @elseif($averageRating >= ($i - .5))

                                            <i class="mdi mdi-star-half-full"></i>

                                        @else

                                            <i class="mdi mdi-star-outline"></i>

                                        @endif

                                    @endfor

                                </div>

                                <div class="rating-count">

                                    {{ $ratingCount }}
                                    {{ $ratingCount == 1 ? 'review' : 'reviews' }}

                                </div>

                            </div>


                            <div class="text-end">

                                <i class="mdi mdi-star-circle-outline"
                                   style="font-size:42px;color:#d6a842;"></i>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    SERVICE RESOURCES
                ================================================== --}}

                <div class="detail-card mt-4">

                    <div class="detail-card-header">

                        <h4 class="detail-card-title">
                            Service Resources
                        </h4>

                        <p class="detail-card-subtitle">
                            Content attached to this service.
                        </p>

                    </div>

                    <div class="detail-card-body">

                        <div class="resource-grid">


                            <div class="resource-item">

                                <div class="resource-icon">
                                    <i class="mdi mdi-image-multiple-outline"></i>
                                </div>

                                <span class="resource-value">
                                    {{ $media->count() }}
                                </span>

                                <span class="resource-label">
                                    Media
                                </span>

                            </div>


                            <div class="resource-item">

                                <div class="resource-icon">
                                    <i class="mdi mdi-briefcase-outline"></i>
                                </div>

                                <span class="resource-value">
                                    {{ $portfolios->count() }}
                                </span>

                                <span class="resource-label">
                                    Portfolio
                                </span>

                            </div>


                            <div class="resource-item">

                                <div class="resource-icon">
                                    <i class="mdi mdi-account-group-outline"></i>
                                </div>

                                <span class="resource-value">
                                    {{ $staffMembers->count() }}
                                </span>

                                <span class="resource-label">
                                    Staff
                                </span>

                            </div>


                        </div>

                    </div>

                </div>


                {{-- =================================================
                    LOCATION
                ================================================== --}}

                <div class="detail-card mt-4">

                    <div class="detail-card-header">

                        <h4 class="detail-card-title">
                            Service Location
                        </h4>

                    </div>

                    <div class="detail-card-body">

                        <div class="location-box">

                            <div class="location-icon">

                                <i class="mdi mdi-map-marker-outline"></i>

                            </div>

                            <div>

                                <span class="location-label">
                                    Location
                                </span>

                                <div class="location-value">

                                    {{ $details->location ?: 'Location not specified' }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    MANAGE SERVICE
                ================================================== --}}

                <div class="detail-card mt-4">

                    <div class="detail-card-header">

                        <h4 class="detail-card-title">
                            Manage Service
                        </h4>

                        <p class="detail-card-subtitle">
                            Manage this service and its resources.
                        </p>

                    </div>

                    <div class="detail-card-body">

                        <div class="d-flex flex-column gap-2">


                            @if(Route::has('service.edit'))

                                <a href="{{ route('service.edit', $details->id) }}"
                                   class="manage-action">

                                    <span class="manage-action-icon">

                                        <i class="mdi mdi-pencil-outline"></i>

                                    </span>

                                    <span>

                                        <strong>
                                            Edit Service
                                        </strong>

                                        <small>
                                            Update service information
                                        </small>

                                    </span>

                                </a>

                            @endif


                            <button type="button"
                                    class="manage-action"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addMediaModal">

                                <span class="manage-action-icon">

                                    <i class="mdi mdi-image-plus-outline"></i>

                                </span>

                                <span>

                                    <strong>
                                        Add Media
                                    </strong>

                                    <small>
                                        Upload service photos or videos
                                    </small>

                                </span>

                            </button>


                            <button type="button"
                                    class="manage-action"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addPortfolioModal">

                                <span class="manage-action-icon">

                                    <i class="mdi mdi-briefcase-plus-outline"></i>

                                </span>

                                <span>

                                    <strong>
                                        Add Portfolio
                                    </strong>

                                    <small>
                                        Showcase completed work
                                    </small>

                                </span>

                            </button>


                            @if(Route::has('service.destroy'))

                                <form action="{{ route('service.destroy', $details->id) }}"
                                      method="POST"
                                      id="deleteServiceForm">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="manage-action w-100 text-start">

                                        <span class="manage-action-icon"
                                              style="background:#fff3f3;color:#bd5555;">

                                            <i class="mdi mdi-delete-outline"></i>

                                        </span>

                                        <span>

                                            <strong style="color:#bd5555;">
                                                Delete Service
                                            </strong>

                                            <small>
                                                Permanently remove this service
                                            </small>

                                        </span>

                                    </button>

                                </form>

                            @endif


                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>


    {{-- =========================================================
        ADD MEDIA MODAL
    ========================================================== --}}

    <div class="modal fade"
         id="addMediaModal"
         tabindex="-1"
         aria-labelledby="addMediaModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content border-0 shadow-lg">

                <form action="{{ route('service-media.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <input type="hidden"
                           name="service_id"
                           value="{{ $details->id }}">


                    <div class="modal-header">

                        <div>

                            <h5 class="modal-title"
                                id="addMediaModalLabel">

                                Add Service Media

                            </h5>

                            <p class="modal-subtitle mb-0">

                                Upload photos or videos for this service.

                            </p>

                        </div>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                        </button>

                    </div>


                    <div class="modal-body">


                        <div class="mb-3">

                            <label for="serviceMediaFiles"
                                   class="form-label">

                                Select Files
                                <span class="text-danger">*</span>

                            </label>

                            <input type="file"
                                   name="files[]"
                                   id="serviceMediaFiles"
                                   class="form-control"
                                   accept=".jpg,.jpeg,.png,.mp4,.mov,.avi"
                                   multiple
                                   required>

                            <div class="form-text">

                                Supported formats:
                                JPG, JPEG, PNG, MP4, MOV and AVI.

                            </div>

                            @error('files.*')

                                <div class="text-danger small mt-1">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>


                        <div id="selectedFilesPreview"
                             class="file-preview">

                        </div>


                        @error('service_id')

                            <div class="text-danger small mt-2">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>


                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit"
                                class="btn btn-media-submit">

                            <i class="mdi mdi-upload me-1"></i>

                            Upload Media

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- =========================================================
        MEDIA PREVIEW MODAL
    ========================================================== --}}

    <div class="modal fade"
         id="mediaPreviewModal"
         tabindex="-1"
         aria-labelledby="mediaPreviewModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-centered">

            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header">

                    <div>

                        <h5 class="modal-title"
                            id="mediaPreviewModalLabel">

                            Media Preview

                        </h5>

                        <p class="modal-subtitle mb-0"
                           id="previewMediaName">

                            Service Media

                        </p>

                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="preview-shell">


                        <img id="previewImage"
                             src=""
                             alt="Media preview"
                             class="preview-image d-none">


                        <video id="previewVideo"
                               class="preview-video d-none"
                               controls
                               playsinline>

                            <source id="previewVideoSource"
                                    src="">

                        </video>


                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        ADD PORTFOLIO MODAL
    ========================================================== --}}

    <div class="modal fade"
         id="addPortfolioModal"
         tabindex="-1"
         aria-labelledby="addPortfolioModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content border-0 shadow-lg">

                <form action="{{ route('portfolios.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <input type="hidden"
                           name="service_id"
                           value="{{ $details->id }}">


                    <div class="modal-header">

                        <div>

                            <h5 class="modal-title"
                                id="addPortfolioModalLabel">

                                Add Portfolio

                            </h5>

                            <p class="modal-subtitle mb-0">

                                Add a completed project to this service.

                            </p>

                        </div>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                        </button>

                    </div>


                    <div class="modal-body">


                        <div class="mb-3">

                            <label for="portfolioTag"
                                   class="form-label">

                                Project / Portfolio Tag
                                <span class="text-danger">*</span>

                            </label>

                            <input type="text"
                                   name="tag"
                                   id="portfolioTag"
                                   class="form-control"
                                   value="{{ old('tag') }}"
                                   placeholder="e.g. Website Design, Home Renovation, Event Setup"
                                   maxlength="255"
                                   required>

                            @error('tag')

                                <div class="text-danger small mt-1">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>


                        <div class="mb-3">

                            <label for="portfolioImage"
                                   class="form-label">

                                Portfolio Image
                                <span class="text-danger">*</span>

                            </label>

                            <input type="file"
                                   name="image"
                                   id="portfolioImage"
                                   class="form-control"
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   required>

                            <div class="form-text">

                                Upload a JPG, JPEG, PNG or WEBP image.

                            </div>

                            @error('image')

                                <div class="text-danger small mt-1">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>


                        <div id="portfolioImagePreview"
                             class="portfolio-upload-preview d-none">

                            <img id="portfolioPreviewImage"
                                 src=""
                                 alt="Portfolio preview">

                        </div>


                        @error('service_id')

                            <div class="text-danger small mt-2">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>


                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit"
                                class="btn btn-media-submit">

                            <i class="mdi mdi-plus me-1"></i>

                            Add Portfolio

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- =========================================================
        PORTFOLIO PREVIEW MODAL
    ========================================================== --}}

    <div class="modal fade"
         id="portfolioPreviewModal"
         tabindex="-1"
         aria-labelledby="portfolioPreviewModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-centered">

            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header">

                    <div>

                        <h5 class="modal-title"
                            id="portfolioPreviewModalLabel">

                            Portfolio Preview

                        </h5>

                        <p class="modal-subtitle mb-0"
                           id="portfolioPreviewTag">

                            Portfolio

                        </p>

                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="portfolio-preview-shell">

                        <img id="portfolioPreviewLarge"
                             src=""
                             alt="Portfolio preview"
                             class="portfolio-preview-large">

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | DELETE SERVICE
    |--------------------------------------------------------------------------
    */

    const deleteServiceForm =
        document.getElementById('deleteServiceForm');

    if (deleteServiceForm) {

        deleteServiceForm.addEventListener(
            'submit',
            function (event) {

                const confirmed = confirm(
                    'Are you sure you want to delete this service? This action cannot be undone.'
                );

                if (!confirmed) {
                    event.preventDefault();
                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | DELETE MEDIA
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.delete-media-form')
        .forEach(function (form) {

            form.addEventListener(
                'submit',
                function (event) {

                    const confirmed = confirm(
                        'Are you sure you want to delete this media file? This action cannot be undone.'
                    );

                    if (!confirmed) {
                        event.preventDefault();
                    }

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | DELETE PORTFOLIO
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.delete-portfolio-form')
        .forEach(function (form) {

            form.addEventListener(
                'submit',
                function (event) {

                    const confirmed = confirm(
                        'Are you sure you want to delete this portfolio item? This action cannot be undone.'
                    );

                    if (!confirmed) {
                        event.preventDefault();
                    }

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | MEDIA FILE PREVIEW BEFORE UPLOAD
    |--------------------------------------------------------------------------
    */

    const mediaInput =
        document.getElementById('serviceMediaFiles');

    const selectedFilesPreview =
        document.getElementById('selectedFilesPreview');

    if (
        mediaInput &&
        selectedFilesPreview
    ) {

        mediaInput.addEventListener(
            'change',
            function () {

                selectedFilesPreview.innerHTML = '';

                const files = Array.from(
                    this.files || []
                );

                if (!files.length) {
                    return;
                }

                files.forEach(function (file) {

                    const wrapper =
                        document.createElement('div');

                    wrapper.className =
                        'file-preview-item';


                    if (
                        file.type.startsWith('image/')
                    ) {

                        const image =
                            document.createElement('img');

                        image.alt = file.name;

                        const reader =
                            new FileReader();

                        reader.onload =
                            function (event) {

                                image.src =
                                    event.target.result;

                            };

                        reader.readAsDataURL(file);

                        wrapper.appendChild(image);

                    } else if (
                        file.type.startsWith('video/')
                    ) {

                        const video =
                            document.createElement('video');

                        video.muted = true;
                        video.playsInline = true;

                        const reader =
                            new FileReader();

                        reader.onload =
                            function (event) {

                                video.src =
                                    event.target.result;

                            };

                        reader.readAsDataURL(file);

                        wrapper.appendChild(video);

                    }

                    selectedFilesPreview.appendChild(
                        wrapper
                    );

                });

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | MEDIA PREVIEW MODAL
    |--------------------------------------------------------------------------
    */

    const mediaPreviewModalElement =
        document.getElementById(
            'mediaPreviewModal'
        );

    const previewImage =
        document.getElementById(
            'previewImage'
        );

    const previewVideo =
        document.getElementById(
            'previewVideo'
        );

    const previewVideoSource =
        document.getElementById(
            'previewVideoSource'
        );

    const previewMediaName =
        document.getElementById(
            'previewMediaName'
        );


    if (
        mediaPreviewModalElement &&
        previewImage &&
        previewVideo &&
        previewVideoSource
    ) {

        mediaPreviewModalElement.addEventListener(
            'hidden.bs.modal',
            function () {

                previewImage.classList.add('d-none');

                previewImage.removeAttribute('src');

                previewVideo.pause();

                previewVideo.classList.add('d-none');

                previewVideoSource.removeAttribute(
                    'src'
                );

                previewVideo.load();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | PORTFOLIO PREVIEW
    |--------------------------------------------------------------------------
    */

    const portfolioModalElement =
        document.getElementById(
            'portfolioPreviewModal'
        );

    const portfolioPreviewImage =
        document.getElementById(
            'portfolioPreviewLarge'
        );

    const portfolioPreviewTag =
        document.getElementById(
            'portfolioPreviewTag'
        );


    if (
        portfolioModalElement &&
        portfolioPreviewImage
    ) {

        const portfolioModal =
            bootstrap.Modal.getOrCreateInstance(
                portfolioModalElement
            );


        document
            .querySelectorAll('.js-portfolio-preview')
            .forEach(function (button) {

                button.addEventListener(
                    'click',
                    function () {

                        const image =
                            this.dataset.image || '';

                        const tag =
                            this.dataset.tag ||
                            'Portfolio';


                        portfolioPreviewImage.src =
                            image;

                        portfolioPreviewImage.alt =
                            tag;


                        if (portfolioPreviewTag) {

                            portfolioPreviewTag.textContent =
                                tag;

                        }


                        portfolioModal.show();

                    }
                );

            });


        portfolioModalElement.addEventListener(
            'hidden.bs.modal',
            function () {

                portfolioPreviewImage.removeAttribute(
                    'src'
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | PORTFOLIO IMAGE UPLOAD PREVIEW
    |--------------------------------------------------------------------------
    */

    const portfolioInput =
        document.getElementById(
            'portfolioImage'
        );

    const portfolioPreview =
        document.getElementById(
            'portfolioImagePreview'
        );

    const portfolioPreviewImage =
        document.getElementById(
            'portfolioPreviewImage'
        );


    if (
        portfolioInput &&
        portfolioPreview &&
        portfolioPreviewImage
    ) {

        portfolioInput.addEventListener(
            'change',
            function () {

                const file =
                    this.files &&
                    this.files[0];


                if (!file) {

                    portfolioPreview.classList.add(
                        'd-none'
                    );

                    portfolioPreviewImage.removeAttribute(
                        'src'
                    );

                    return;

                }


                if (
                    !file.type.startsWith(
                        'image/'
                    )
                ) {

                    portfolioPreview.classList.add(
                        'd-none'
                    );

                    portfolioPreviewImage.removeAttribute(
                        'src'
                    );

                    return;

                }


                const reader =
                    new FileReader();


                reader.onload =
                    function (event) {

                        portfolioPreviewImage.src =
                            event.target.result;

                        portfolioPreview.classList.remove(
                            'd-none'
                        );

                    };


                reader.readAsDataURL(file);

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CLEAR PORTFOLIO FORM WHEN MODAL CLOSES
    |--------------------------------------------------------------------------
    */

    const addPortfolioModal =
        document.getElementById(
            'addPortfolioModal'
        );


    if (addPortfolioModal) {

        addPortfolioModal.addEventListener(
            'hidden.bs.modal',
            function () {

                if (portfolioPreview) {

                    portfolioPreview.classList.add(
                        'd-none'
                    );

                }

                if (portfolioPreviewImage) {

                    portfolioPreviewImage.removeAttribute(
                        'src'
                    );

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CLEAR MEDIA PREVIEW WHEN ADD MEDIA MODAL CLOSES
    |--------------------------------------------------------------------------
    */

    const addMediaModal =
        document.getElementById(
            'addMediaModal'
        );


    if (addMediaModal) {

        addMediaModal.addEventListener(
            'hidden.bs.modal',
            function () {

                if (mediaInput) {

                    mediaInput.value = '';

                }

                if (selectedFilesPreview) {

                    selectedFilesPreview.innerHTML =
                        '';

                }

            }
        );

    }

});


/*
|--------------------------------------------------------------------------
| GLOBAL MEDIA PREVIEW FUNCTION
|--------------------------------------------------------------------------
*/

function previewMedia(element)
{
    if (!element) {
        return;
    }


    const mediaType =
        element.dataset.mediaType || 'image';

    const mediaUrl =
        element.dataset.mediaUrl || '';

    const mediaName =
        element.dataset.mediaName || 'Service Media';


    const modalElement =
        document.getElementById(
            'mediaPreviewModal'
        );

    const previewImage =
        document.getElementById(
            'previewImage'
        );

    const previewVideo =
        document.getElementById(
            'previewVideo'
        );

    const previewVideoSource =
        document.getElementById(
            'previewVideoSource'
        );

    const previewMediaName =
        document.getElementById(
            'previewMediaName'
        );


    if (
        !modalElement ||
        !previewImage ||
        !previewVideo ||
        !previewVideoSource
    ) {

        return;

    }


    previewImage.classList.add('d-none');

    previewImage.removeAttribute('src');


    previewVideo.pause();

    previewVideo.classList.add('d-none');

    previewVideoSource.removeAttribute(
        'src'
    );


    if (previewMediaName) {

        previewMediaName.textContent =
            mediaName;

    }


    if (mediaType === 'video') {

        previewVideoSource.src =
            mediaUrl;

        previewVideo.load();

        previewVideo.classList.remove(
            'd-none'
        );

    } else {

        previewImage.src =
            mediaUrl;

        previewImage.classList.remove(
            'd-none'
        );

    }


    const modal =
        bootstrap.Modal.getOrCreateInstance(
            modalElement
        );

    modal.show();
}

</script>

@endsection