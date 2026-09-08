@extends('layouts.app')

@section('title', 'Service Categories')

@section('content')

<style>
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
        --connector-white: #ffffff;
        --connector-shadow: 0 10px 30px rgba(37, 64, 53, .08);
        --connector-shadow-lg: 0 20px 50px rgba(37, 64, 53, .12);
        --connector-radius: 18px;
    }

    .category-page {
        min-height: calc(100vh - 70px);
        background: var(--connector-bg);
        padding: 28px;
    }

    .category-container {
        max-width: 1500px;
        margin: 0 auto;
    }

    /* -------------------------------------------------------
       HEADER
    ------------------------------------------------------- */

    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 28px;
    }

    .page-header-left {
        min-width: 0;
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--connector-primary);
        margin-bottom: 8px;
    }

    .eyebrow-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--connector-primary);
    }

    .page-title {
        margin: 0;
        color: var(--connector-text);
        font-size: 30px;
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -.03em;
    }

    .page-description {
        margin: 8px 0 0;
        color: var(--connector-muted);
        font-size: 14px;
        max-width: 650px;
        line-height: 1.6;
    }

    .page-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    /* -------------------------------------------------------
       BUTTONS
    ------------------------------------------------------- */

    .btn-connector {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 0;
        border-radius: 11px;
        padding: 11px 16px;
        font-size: 13px;
        font-weight: 750;
        text-decoration: none !important;
        transition: all .2s ease;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-primary {
        background: var(--connector-primary);
        color: white !important;
        box-shadow: 0 7px 18px rgba(107, 144, 128, .22);
    }

    .btn-primary:hover {
        background: var(--connector-primary-dark);
        transform: translateY(-1px);
        color: white !important;
    }

    .btn-light {
        background: white;
        color: var(--connector-text) !important;
        border: 1px solid var(--connector-border);
    }

    .btn-light:hover {
        background: var(--connector-soft);
        border-color: #cbdad4;
    }

    .btn-danger {
        background: #FFF3F0;
        color: var(--connector-danger) !important;
        border: 1px solid #F2D8D2;
    }

    .btn-danger:hover {
        background: var(--connector-danger);
        color: white !important;
    }

    .btn-gold {
        background: #FBF6EA;
        color: #8B671E !important;
        border: 1px solid #EBDDAD;
    }

    .btn-gold:hover {
        background: var(--connector-gold);
        color: white !important;
    }

    /* -------------------------------------------------------
       ALERT
    ------------------------------------------------------- */

    .success-alert {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        background: #ECF8F2;
        border: 1px solid #CFE9DA;
        color: #286345;
        padding: 13px 16px;
        border-radius: 12px;
        margin-bottom: 22px;
        font-size: 13px;
        font-weight: 650;
    }

    .success-alert-content {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .success-alert svg {
        flex-shrink: 0;
    }

    .alert-close {
        border: 0;
        background: transparent;
        color: inherit;
        cursor: pointer;
        opacity: .7;
    }

    /* -------------------------------------------------------
       STATS
    ------------------------------------------------------- */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: white;
        border: 1px solid var(--connector-border);
        border-radius: var(--connector-radius);
        padding: 19px;
        box-shadow: var(--connector-shadow);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .stat-label {
        font-size: 12px;
        color: var(--connector-muted);
        font-weight: 700;
        margin-bottom: 6px;
    }

    .stat-value {
        font-size: 25px;
        color: var(--connector-text);
        font-weight: 850;
        line-height: 1;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        flex-shrink: 0;
    }

    .stat-icon.gold {
        background: #FBF6EA;
        color: var(--connector-gold);
    }

    .stat-icon.dark {
        background: #EEF2F0;
        color: var(--connector-primary-dark);
    }

    /* -------------------------------------------------------
       MAIN WORKSPACE
    ------------------------------------------------------- */

    .workspace {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 430px;
        gap: 20px;
        align-items: start;
    }

    .category-library {
        background: white;
        border: 1px solid var(--connector-border);
        border-radius: 20px;
        box-shadow: var(--connector-shadow);
        min-width: 0;
        overflow: hidden;
    }

    .library-header {
        padding: 20px;
        border-bottom: 1px solid var(--connector-border);
    }

    .library-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 16px;
    }

    .library-title {
        margin: 0;
        font-size: 17px;
        font-weight: 800;
        color: var(--connector-text);
    }

    .library-count {
        color: var(--connector-muted);
        font-size: 12px;
        font-weight: 700;
    }

    .search-form {
        display: flex;
        gap: 8px;
    }

    .search-wrapper {
        position: relative;
        flex: 1;
    }

    .search-wrapper svg {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #8B9B94;
        pointer-events: none;
    }

    .search-input {
        width: 100%;
        height: 42px;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        background: #FAFCFB;
        color: var(--connector-text);
        padding: 0 13px 0 40px;
        font-size: 13px;
        outline: none;
        transition: .2s;
    }

    .search-input:focus {
        border-color: var(--connector-primary);
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .10);
        background: white;
    }

    .search-button {
        height: 42px;
        padding: 0 15px;
        border-radius: 10px;
        border: 0;
        background: var(--connector-primary);
        color: white;
        font-size: 13px;
        font-weight: 750;
        cursor: pointer;
    }

    .clear-search {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 42px;
        padding: 0 14px;
        border-radius: 10px;
        border: 1px solid var(--connector-border);
        color: var(--connector-muted);
        background: white;
        text-decoration: none !important;
        font-size: 13px;
        font-weight: 700;
    }

    /* -------------------------------------------------------
       CATEGORY GRID
    ------------------------------------------------------- */

    .category-grid {
        padding: 20px;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .category-card {
        position: relative;
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 16px;
        overflow: hidden;
        transition: all .22s ease;
        cursor: pointer;
    }

    .category-card:hover {
        border-color: #bfd1c9;
        box-shadow: 0 12px 30px rgba(37, 64, 53, .09);
        transform: translateY(-2px);
    }

    .category-card.active {
        border-color: var(--connector-primary);
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .12);
    }

    .category-card-top {
        display: flex;
        gap: 14px;
        padding: 16px;
    }

    .category-image {
        width: 78px;
        height: 78px;
        border-radius: 13px;
        overflow: hidden;
        flex-shrink: 0;
        background: var(--connector-soft);
        border: 1px solid var(--connector-border);
    }

    .category-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .category-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--connector-primary);
    }

    .category-main {
        min-width: 0;
        flex: 1;
    }

    .category-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
    }

    .category-name {
        margin: 0;
        color: var(--connector-text);
        font-size: 15px;
        line-height: 1.3;
        font-weight: 800;
    }

    .featured-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #FBF6EA;
        color: #8B671E;
        border: 1px solid #EBDDAD;
        border-radius: 999px;
        padding: 4px 7px;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
        flex-shrink: 0;
    }

    .category-slug {
        margin-top: 5px;
        font-size: 11px;
        color: var(--connector-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .category-info {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-top: 12px;
        flex-wrap: wrap;
    }

    .category-info-item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: var(--connector-muted);
        font-size: 11px;
        font-weight: 700;
    }

    .category-info-item svg {
        color: var(--connector-primary);
    }

    .category-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding: 11px 13px;
        background: #FAFCFB;
        border-top: 1px solid var(--connector-border);
    }

    .view-category {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--connector-primary-dark);
        font-size: 11px;
        font-weight: 800;
        background: transparent;
        border: 0;
        cursor: pointer;
        padding: 4px;
    }

    .category-actions {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-height: 30px;
        padding: 6px 9px;
        border-radius: 8px;
        border: 1px solid transparent;
        background: transparent;
        font-size: 10px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none !important;
        transition: .2s;
    }

    .action-edit {
        color: var(--connector-primary-dark);
        background: #F0F6F3;
        border-color: #D9E8E1;
    }

    .action-edit:hover {
        background: var(--connector-primary);
        color: white;
    }

    .action-delete {
        color: var(--connector-danger);
        background: #FFF3F0;
        border-color: #F2D8D2;
    }

    .action-delete:hover {
        background: var(--connector-danger);
        color: white;
    }

    /* -------------------------------------------------------
       PAGINATION
    ------------------------------------------------------- */

    .pagination-area {
        border-top: 1px solid var(--connector-border);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .pagination-info {
        color: var(--connector-muted);
        font-size: 12px;
    }

    .pagination-info strong {
        color: var(--connector-text);
    }

    .pagination-nav .pagination {
        margin: 0;
    }

    .pagination-nav .page-link {
        color: var(--connector-primary-dark);
        border-color: var(--connector-border);
        font-size: 12px;
        font-weight: 700;
        border-radius: 8px !important;
        margin: 0 2px;
    }

    .pagination-nav .page-item.active .page-link {
        background: var(--connector-primary);
        border-color: var(--connector-primary);
        color: white;
    }

    /* -------------------------------------------------------
       RIGHT DETAILS PANEL
    ------------------------------------------------------- */

    .details-panel {
        background: white;
        border: 1px solid var(--connector-border);
        border-radius: 20px;
        box-shadow: var(--connector-shadow);
        position: sticky;
        top: 20px;
        min-height: 500px;
        overflow: hidden;
    }

    .details-empty {
        min-height: 500px;
        padding: 45px 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .empty-icon {
        width: 66px;
        height: 66px;
        border-radius: 18px;
        background: var(--connector-soft);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
    }

    .details-empty h3 {
        margin: 0 0 8px;
        color: var(--connector-text);
        font-size: 17px;
        font-weight: 800;
    }

    .details-empty p {
        max-width: 270px;
        margin: 0;
        color: var(--connector-muted);
        font-size: 13px;
        line-height: 1.6;
    }

    .details-content {
        display: none;
    }

    .details-content.active {
        display: block;
        animation: panelIn .22s ease;
    }

    @keyframes panelIn {
        from {
            opacity: 0;
            transform: translateX(8px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .details-header {
        position: relative;
        padding: 20px;
        background: linear-gradient(135deg, #F2F7F4 0%, #FFFFFF 100%);
        border-bottom: 1px solid var(--connector-border);
    }

    .details-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .details-category-info {
        display: flex;
        gap: 12px;
        min-width: 0;
    }

    .details-image {
        width: 62px;
        height: 62px;
        border-radius: 13px;
        overflow: hidden;
        flex-shrink: 0;
        background: var(--connector-soft);
        border: 1px solid var(--connector-border);
    }

    .details-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .details-category-name {
        margin: 0;
        color: var(--connector-text);
        font-size: 17px;
        font-weight: 850;
        line-height: 1.3;
    }

    .details-category-slug {
        color: var(--connector-muted);
        font-size: 11px;
        margin-top: 5px;
    }

    .close-details {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--connector-border);
        border-radius: 9px;
        background: white;
        color: var(--connector-muted);
        cursor: pointer;
        flex-shrink: 0;
    }

    .close-details:hover {
        background: var(--connector-soft);
        color: var(--connector-text);
    }

    .details-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 9px;
        margin-top: 18px;
    }

    .details-stat {
        background: rgba(255,255,255,.75);
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        padding: 10px;
    }

    .details-stat-label {
        color: var(--connector-muted);
        font-size: 10px;
        font-weight: 700;
    }

    .details-stat-value {
        color: var(--connector-text);
        font-size: 17px;
        font-weight: 850;
        margin-top: 2px;
    }

    .details-actions {
        display: flex;
        gap: 7px;
        margin-top: 15px;
    }

    .details-actions .btn-connector {
        flex: 1;
        padding: 9px 10px;
        font-size: 11px;
    }

    .subcategories-section {
        padding: 20px;
    }

    .subcategories-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 13px;
    }

    .subcategories-heading h4 {
        margin: 0;
        color: var(--connector-text);
        font-size: 14px;
        font-weight: 800;
    }

    .sub-count {
        color: var(--connector-muted);
        font-size: 11px;
        font-weight: 700;
    }

    .subcategories-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .subcategory-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 11px;
        border: 1px solid var(--connector-border);
        border-radius: 11px;
        background: #FAFCFB;
    }

    .subcategory-left {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 0;
    }

    .subcategory-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--connector-soft);
        color: var(--connector-primary);
        flex-shrink: 0;
    }

    .subcategory-name {
        margin: 0;
        color: var(--connector-text);
        font-size: 12px;
        font-weight: 750;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .subcategory-slug {
        color: var(--connector-muted);
        font-size: 9px;
        margin-top: 2px;
    }

    .subcategory-actions {
        display: flex;
        gap: 4px;
        flex-shrink: 0;
    }

    .sub-action {
        width: 27px;
        height: 27px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        border: 1px solid var(--connector-border);
        background: white;
        cursor: pointer;
        transition: .2s;
    }

    .sub-edit {
        color: var(--connector-primary-dark);
    }

    .sub-edit:hover {
        background: var(--connector-primary);
        border-color: var(--connector-primary);
        color: white;
    }

    .sub-delete {
        color: var(--connector-danger);
    }

    .sub-delete:hover {
        background: var(--connector-danger);
        border-color: var(--connector-danger);
        color: white;
    }

    .no-subcategories {
        text-align: center;
        padding: 30px 15px;
        border: 1px dashed #CCDAD4;
        border-radius: 12px;
        background: #FAFCFB;
    }

    .no-subcategories svg {
        color: var(--connector-primary);
        margin-bottom: 8px;
    }

    .no-subcategories p {
        margin: 0 0 12px;
        color: var(--connector-muted);
        font-size: 12px;
    }

    /* -------------------------------------------------------
       MODAL
    ------------------------------------------------------- */

    .connector-modal .modal-content {
        border: 0;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: var(--connector-shadow-lg);
    }

    .connector-modal .modal-header {
        padding: 20px 22px;
        background: linear-gradient(135deg, #F2F7F4, #fff);
        border-bottom: 1px solid var(--connector-border);
    }

    .connector-modal .modal-title {
        color: var(--connector-text);
        font-size: 17px;
        font-weight: 800;
    }

    .connector-modal .modal-body {
        padding: 22px;
    }

    .connector-modal .modal-footer {
        padding: 15px 22px;
        border-top: 1px solid var(--connector-border);
        background: #FAFCFB;
    }

    .form-label {
        display: block;
        color: var(--connector-text);
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .form-control-connector,
    .form-select-connector {
        width: 100%;
        min-height: 43px;
        border: 1px solid var(--connector-border);
        border-radius: 10px;
        padding: 9px 12px;
        color: var(--connector-text);
        background: white;
        font-size: 13px;
        outline: none;
        transition: .2s;
    }

    .form-control-connector:focus,
    .form-select-connector:focus {
        border-color: var(--connector-primary);
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .10);
    }

    .form-help {
        font-size: 10px;
        color: var(--connector-muted);
        margin-top: 5px;
    }

    .required {
        color: var(--connector-danger);
    }

    .image-upload {
        border: 1px dashed #C9D8D2;
        border-radius: 12px;
        padding: 18px;
        background: #FAFCFB;
        text-align: center;
    }

    .image-upload svg {
        color: var(--connector-primary);
        margin-bottom: 7px;
    }

    .image-upload input {
        font-size: 11px;
        width: 100%;
    }

    /* -------------------------------------------------------
       MOBILE DETAILS DRAWER
    ------------------------------------------------------- */

    .drawer-overlay {
        display: none;
    }

    /* -------------------------------------------------------
       RESPONSIVE
    ------------------------------------------------------- */

    @media (max-width: 1200px) {
        .workspace {
            grid-template-columns: minmax(0, 1fr) 370px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .category-page {
            padding: 20px;
        }

        .workspace {
            display: block;
        }

        .category-library {
            margin-bottom: 20px;
        }

        .details-panel {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: min(440px, 92vw);
            z-index: 1050;
            border-radius: 20px 0 0 20px;
            transform: translateX(105%);
            transition: transform .25s ease;
            overflow-y: auto;
        }

        .details-panel.mobile-open {
            transform: translateX(0);
        }

        .drawer-overlay {
            position: fixed;
            inset: 0;
            z-index: 1040;
            background: rgba(24, 48, 40, .35);
            backdrop-filter: blur(2px);
        }

        .drawer-overlay.active {
            display: block;
        }
    }

    @media (max-width: 700px) {
        .category-page {
            padding: 14px;
        }

        .page-header {
            display: block;
        }

        .page-actions {
            margin-top: 15px;
        }

        .page-actions .btn-connector {
            width: 100%;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .stat-card {
            padding: 14px;
        }

        .stat-value {
            font-size: 21px;
        }

        .category-grid {
            grid-template-columns: 1fr;
            padding: 14px;
        }

        .library-header {
            padding: 15px;
        }

        .search-form {
            flex-wrap: wrap;
        }

        .search-wrapper {
            flex-basis: 100%;
        }

        .search-button,
        .clear-search {
            flex: 1;
        }

        .pagination-area {
            display: block;
        }

        .pagination-info {
            margin-bottom: 12px;
        }

        .pagination-nav {
            overflow-x: auto;
        }
    }

    @media (max-width: 450px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .category-card-top {
            padding: 13px;
        }

        .category-image {
            width: 65px;
            height: 65px;
        }

        .category-actions .action-button span {
            display: none;
        }

        .action-button {
            width: 30px;
            padding: 6px;
        }

        .details-panel {
            width: 100%;
            border-radius: 0;
        }
    }
</style>

<div class="category-page">
    <div class="category-container">

        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}
        <div class="page-header">
            <div class="page-header-left">
                <div class="eyebrow">
                    <span class="eyebrow-dot"></span>
                    Marketplace
                </div>

                <h1 class="page-title">
                    Service Categories
                </h1>

                <p class="page-description">
                    Organize the services available on Connector using categories
                    and subcategories.
                </p>
            </div>

            <div class="page-actions">
                <button
                    type="button"
                    class="btn-connector btn-primary"
                    data-toggle="modal"
                    data-target="#addCategoryModal"
                >
                    <i data-lucide="plus" width="16"></i>
                    <span>Add Category</span>
                </button>
            </div>
        </div>

        {{-- =====================================================
             SUCCESS MESSAGE
        ====================================================== --}}
        @if(session('message'))
            <div class="success-alert" id="successAlert">
                <div class="success-alert-content">
                    <i data-lucide="circle-check" width="17"></i>
                    <span>{{ session('message') }}</span>
                </div>

                <button
                    type="button"
                    class="alert-close"
                    onclick="document.getElementById('successAlert').remove()"
                >
                    <i data-lucide="x" width="16"></i>
                </button>
            </div>
        @endif

        {{-- =====================================================
             STATISTICS
        ====================================================== --}}
        <div class="stats-grid">

            <div class="stat-card">
                <div>
                    <div class="stat-label">Total Categories</div>
                    <div class="stat-value">
                        {{ number_format($totalCategories ?? 0) }}
                    </div>
                </div>

                <div class="stat-icon">
                    <i data-lucide="layers" width="20"></i>
                </div>
            </div>

            <div class="stat-card">
                <div>
                    <div class="stat-label">Featured</div>
                    <div class="stat-value">
                        {{ number_format($featuredCategories ?? 0) }}
                    </div>
                </div>

                <div class="stat-icon gold">
                    <i data-lucide="star" width="20"></i>
                </div>
            </div>

            <div class="stat-card">
                <div>
                    <div class="stat-label">Parent Categories</div>
                    <div class="stat-value">
                        {{ number_format($parentCategories ?? 0) }}
                    </div>
                </div>

                <div class="stat-icon dark">
                    <i data-lucide="folder-tree" width="20"></i>
                </div>
            </div>

            <div class="stat-card">
                <div>
                    <div class="stat-label">Subcategories</div>
                    <div class="stat-value">
                        {{ number_format($totalSubcategories ?? 0) }}
                    </div>
                </div>

                <div class="stat-icon">
                    <i data-lucide="list-tree" width="20"></i>
                </div>
            </div>

        </div>

        {{-- =====================================================
             MAIN WORKSPACE
        ====================================================== --}}
        <div class="workspace">

            {{-- =================================================
                 CATEGORY LIBRARY
            ================================================== --}}
            <section class="category-library">

                <div class="library-header">

                    <div class="library-title-row">
                        <div>
                            <h2 class="library-title">
                                Category Library
                            </h2>

                            <div class="library-count">
                                {{ number_format($scategories->total()) }}
                                {{ $scategories->total() === 1 ? 'category' : 'categories' }}
                            </div>
                        </div>
                    </div>

                    {{-- Search --}}
                    <form
                        method="GET"
                        action="{{ route('admin.service_categories') }}"
                        class="search-form"
                    >
                        <div class="search-wrapper">
                            <i data-lucide="search" width="16"></i>

                            <input
                                type="search"
                                name="search"
                                class="search-input"
                                value="{{ $search ?? request('search') }}"
                                placeholder="Search categories by name or slug..."
                                autocomplete="off"
                            >
                        </div>

                        <button
                            type="submit"
                            class="search-button"
                        >
                            Search
                        </button>

                        @if(request('search'))
                            <a
                                href="{{ route('admin.service_categories') }}"
                                class="clear-search"
                            >
                                Clear
                            </a>
                        @endif
                    </form>

                </div>

                {{-- =================================================
                     CATEGORY CARDS
                ================================================== --}}
                <div class="category-grid">

                    @forelse($scategories as $category)

                        @php
                            $subcategoryCount = $category->subcategories
                                ? $category->subcategories->count()
                                : 0;

                            $imagePath = $category->image
                                ? asset('image/categories/' . $category->image)
                                : null;
                        @endphp

                        <article
                            class="category-card"
                            id="category-card-{{ $category->id }}"
                            data-category-id="{{ $category->id }}"
                            onclick="openCategory({{ $category->id }})"
                        >

                            <div class="category-card-top">

                                <div class="category-image">
                                    @if($imagePath)
                                        <img
                                            src="{{ $imagePath }}"
                                            alt="{{ $category->name }}"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        >

                                        <div
                                            class="category-image-placeholder"
                                            style="display:none;"
                                        >
                                            <i data-lucide="image-off" width="24"></i>
                                        </div>
                                    @else
                                        <div class="category-image-placeholder">
                                            <i data-lucide="layers" width="24"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="category-main">

                                    <div class="category-heading">

                                        <h3 class="category-name">
                                            {{ $category->name }}
                                        </h3>

                                        @if($category->featured)
                                            <span class="featured-badge">
                                                <i data-lucide="star" width="10"></i>
                                                Featured
                                            </span>
                                        @endif

                                    </div>

                                    <div class="category-slug">
                                        /{{ $category->slug }}
                                    </div>

                                    <div class="category-info">

                                        <span class="category-info-item">
                                            <i data-lucide="list-tree" width="13"></i>

                                            {{ $subcategoryCount }}
                                            {{ $subcategoryCount === 1 ? 'subcategory' : 'subcategories' }}
                                        </span>

                                        <span class="category-info-item">
                                            <i data-lucide="calendar-days" width="13"></i>

                                            {{ $category->created_at?->format('M d, Y') ?? '—' }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                            <div class="category-card-footer">

                                <button
                                    type="button"
                                    class="view-category"
                                    onclick="event.stopPropagation(); openCategory({{ $category->id }})"
                                >
                                    <span>View Subcategories</span>
                                    <i data-lucide="arrow-right" width="13"></i>
                                </button>

                                <div class="category-actions">

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('admin.edit_service_category', $category->id) }}"
                                        class="action-button action-edit"
                                        onclick="event.stopPropagation();"
                                        title="Edit Category"
                                    >
                                        <i data-lucide="pencil" width="13"></i>
                                        <span>Edit</span>
                                    </a>

                                    {{-- Delete --}}
                                    <button
                                        type="button"
                                        class="action-button action-delete"
                                        onclick="event.stopPropagation(); confirmDeleteCategory({{ $category->id }}, @js($category->name))"
                                        title="Delete Category"
                                    >
                                        <i data-lucide="trash-2" width="13"></i>
                                        <span>Delete</span>
                                    </button>

                                </div>

                            </div>

                        </article>

                    @empty

                        <div
                            style="
                                grid-column:1/-1;
                                text-align:center;
                                padding:60px 20px;
                            "
                        >
                            <div class="empty-icon" style="margin:0 auto 15px;">
                                <i data-lucide="folder-search" width="28"></i>
                            </div>

                            <h3 style="
                                margin:0 0 7px;
                                color:var(--connector-text);
                                font-size:16px;
                                font-weight:800;
                            ">
                                No categories found
                            </h3>

                            <p style="
                                margin:0 0 18px;
                                color:var(--connector-muted);
                                font-size:13px;
                            ">
                                @if(request('search'))
                                    No categories match your search.
                                @else
                                    Start by creating your first service category.
                                @endif
                            </p>

                            @if(request('search'))
                                <a
                                    href="{{ route('admin.service_categories') }}"
                                    class="btn-connector btn-light"
                                >
                                    Clear Search
                                </a>
                            @else
                                <button
                                    type="button"
                                    class="btn-connector btn-primary"
                                    data-toggle="modal"
                                    data-target="#addCategoryModal"
                                >
                                    <i data-lucide="plus" width="15"></i>
                                    Add Category
                                </button>
                            @endif
                        </div>

                    @endforelse

                </div>

                {{-- =================================================
                     PAGINATION
                ================================================== --}}
                @if($scategories->hasPages())

                    <div class="pagination-area">

                        <div class="pagination-info">

                            Showing
                            <strong>
                                {{ $scategories->firstItem() ?? 0 }}
                            </strong>

                            to

                            <strong>
                                {{ $scategories->lastItem() ?? 0 }}
                            </strong>

                            of

                            <strong>
                                {{ number_format($scategories->total()) }}
                            </strong>

                            categories

                        </div>

                        <div class="pagination-nav">
                            {{ $scategories->onEachSide(1)->links() }}
                        </div>

                    </div>

                @endif

            </section>


            {{-- =================================================
                 RIGHT SIDE DETAILS PANEL
            ================================================== --}}
            <aside
                class="details-panel"
                id="detailsPanel"
            >

                {{-- Empty state --}}
                <div
                    class="details-empty"
                    id="detailsEmpty"
                >

                    <div class="empty-icon">
                        <i data-lucide="mouse-pointer-click" width="28"></i>
                    </div>

                    <h3>
                        Select a category
                    </h3>

                    <p>
                        Click any category card to view its subcategories,
                        manage them, or add a new one.
                    </p>

                </div>


                {{-- =================================================
                     DYNAMIC CATEGORY DETAILS
                ================================================== --}}
                @foreach($scategories as $category)

                    @php
                        $subcategoryCount = $category->subcategories
                            ? $category->subcategories->count()
                            : 0;

                        $imagePath = $category->image
                            ? asset('image/categories/' . $category->image)
                            : null;
                    @endphp

                    <div
                        class="details-content"
                        id="details-{{ $category->id }}"
                    >

                        {{-- Header --}}
                        <div class="details-header">

                            <div class="details-top">

                                <div class="details-category-info">

                                    <div class="details-image">

                                        @if($imagePath)

                                            <img
                                                src="{{ $imagePath }}"
                                                alt="{{ $category->name }}"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                            >

                                            <div
                                                class="category-image-placeholder"
                                                style="display:none;"
                                            >
                                                <i data-lucide="layers" width="22"></i>
                                            </div>

                                        @else

                                            <div class="category-image-placeholder">
                                                <i data-lucide="layers" width="22"></i>
                                            </div>

                                        @endif

                                    </div>

                                    <div>
                                        <h3 class="details-category-name">
                                            {{ $category->name }}
                                        </h3>

                                        <div class="details-category-slug">
                                            /{{ $category->slug }}
                                        </div>
                                    </div>

                                </div>

                                <button
                                    type="button"
                                    class="close-details"
                                    onclick="closeCategoryPanel()"
                                    aria-label="Close"
                                >
                                    <i data-lucide="x" width="16"></i>
                                </button>

                            </div>


                            {{-- Statistics --}}
                            <div class="details-stats">

                                <div class="details-stat">
                                    <div class="details-stat-label">
                                        Subcategories
                                    </div>

                                    <div class="details-stat-value">
                                        {{ $subcategoryCount }}
                                    </div>
                                </div>

                                <div class="details-stat">
                                    <div class="details-stat-label">
                                        Status
                                    </div>

                                    <div class="details-stat-value">
                                        {{ $category->featured ? 'Featured' : 'Active' }}
                                    </div>
                                </div>

                            </div>


                            {{-- Actions --}}
                            <div class="details-actions">

                                {{-- Add --}}
                                <button
                                    type="button"
                                    class="btn-connector btn-primary"
                                    onclick="openAddSubcategoryModal(
                                        {{ $category->id }},
                                        @js($category->name)
                                    )"
                                >
                                    <i data-lucide="plus" width="14"></i>
                                    <span>Add Subcategory</span>
                                </button>

                                {{-- Edit --}}
                                <a
                                    href="{{ route('admin.edit_service_category', $category->id) }}"
                                    class="btn-connector btn-light"
                                >
                                    <i data-lucide="pencil" width="14"></i>
                                    <span>Edit</span>
                                </a>

                            </div>

                        </div>


                        {{-- =================================================
                             SUBCATEGORIES
                        ================================================== --}}
                        <div class="subcategories-section">

                            <div class="subcategories-heading">

                                <h4>
                                    Subcategories
                                </h4>

                                <span class="sub-count">
                                    {{ $subcategoryCount }}
                                    {{ $subcategoryCount === 1 ? 'item' : 'items' }}
                                </span>

                            </div>


                            @if($subcategoryCount > 0)

                                <div class="subcategories-list">

                                    @foreach($category->subcategories as $subcategory)

                                        <div class="subcategory-item">

                                            <div class="subcategory-left">

                                                <div class="subcategory-icon">
                                                    <i data-lucide="tag" width="14"></i>
                                                </div>

                                                <div style="min-width:0;">

                                                    <p class="subcategory-name">
                                                        {{ $subcategory->name }}
                                                    </p>

                                                    <div class="subcategory-slug">
                                                        /{{ $subcategory->slug }}
                                                    </div>

                                                </div>

                                            </div>


                                            <div class="subcategory-actions">

                                                {{-- Edit --}}
                                                <button
                                                    type="button"
                                                    class="sub-action sub-edit"
                                                    title="Edit Subcategory"
                                                    onclick="openEditSubcategoryModal(
                                                        {{ $subcategory->id }},
                                                        @js($subcategory->name),
                                                        {{ $category->id }}
                                                    )"
                                                >
                                                    <i data-lucide="pencil" width="12"></i>
                                                </button>


                                                {{-- Delete --}}
                                                <button
                                                    type="button"
                                                    class="sub-action sub-delete"
                                                    title="Delete Subcategory"
                                                    onclick="confirmDeleteSubcategory(
                                                        {{ $subcategory->id }},
                                                        @js($subcategory->name)
                                                    )"
                                                >
                                                    <i data-lucide="trash-2" width="12"></i>
                                                </button>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <div class="no-subcategories">

                                    <i data-lucide="folder-plus" width="25"></i>

                                    <p>
                                        No subcategories have been added
                                        to this category yet.
                                    </p>

                                    <button
                                        type="button"
                                        class="btn-connector btn-primary"
                                        onclick="openAddSubcategoryModal(
                                            {{ $category->id }},
                                            @js($category->name)
                                        )"
                                    >
                                        <i data-lucide="plus" width="14"></i>
                                        Add Subcategory
                                    </button>

                                </div>

                            @endif

                        </div>

                    </div>

                @endforeach

            </aside>

        </div>

    </div>
</div>


{{-- =============================================================
     MOBILE OVERLAY
============================================================= --}}
<div
    class="drawer-overlay"
    id="drawerOverlay"
    onclick="closeCategoryPanel()"
></div>


{{-- =============================================================
     ADD CATEGORY MODAL
============================================================= --}}
<div
    class="modal fade connector-modal"
    id="addCategoryModal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">

            <form
                method="POST"
                action="{{ route('admin.create_service_category') }}"
                enctype="multipart/form-data"
                id="addCategoryForm"
            >

                @csrf

                <div class="modal-header">

                    <div>
                        <div class="eyebrow" style="margin-bottom:4px;">
                            <span class="eyebrow-dot"></span>
                            Marketplace
                        </div>

                        <h5 class="modal-title">
                            Add Category
                        </h5>
                    </div>

                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>


                <div class="modal-body">

                    {{-- Category type --}}
                    <div class="form-group">

                        <label class="form-label">
                            Category Type
                        </label>

                        <select
                            name="service_category_id"
                            id="categoryParent"
                            class="form-select-connector"
                        >
                            <option value="">
                                Main Category
                            </option>

                            @foreach($categories ?? [] as $parentCategory)

                                <option value="{{ $parentCategory->id }}">
                                    Subcategory of {{ $parentCategory->name }}
                                </option>

                            @endforeach

                        </select>

                        <div class="form-help">
                            Choose Main Category to create a top-level category.
                        </div>

                    </div>


                    {{-- Name --}}
                    <div class="form-group">

                        <label class="form-label">
                            Name
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control-connector"
                            placeholder="e.g. Home Cleaning"
                            value="{{ old('name') }}"
                            required
                        >

                    </div>


                    {{-- Image --}}
                    <div
                        class="form-group"
                        id="categoryImageGroup"
                    >

                        <label class="form-label">
                            Category Image
                            <span
                                class="required"
                                id="imageRequired"
                            >
                                *
                            </span>
                        </label>

                        <div class="image-upload">

                            <i data-lucide="image-plus" width="23"></i>

                            <input
                                type="file"
                                name="image"
                                id="categoryImage"
                                accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml"
                            >

                            <div class="form-help">
                                JPG, PNG, GIF or SVG. Maximum 2MB.
                            </div>

                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn-connector btn-light"
                        data-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn-connector btn-primary"
                    >
                        <i data-lucide="plus" width="15"></i>
                        Create Category
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>


{{-- =============================================================
     ADD SUBCATEGORY MODAL
============================================================= --}}
<div
    class="modal fade connector-modal"
    id="addSubcategoryModal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >

        <div class="modal-content">

            <form
                method="POST"
                action="{{ route('admin.create_service_category') }}"
                id="addSubcategoryForm"
            >

                @csrf

                <input
                    type="hidden"
                    name="service_category_id"
                    id="addSubcategoryParentId"
                >

                <div class="modal-header">

                    <div>
                        <div class="eyebrow" style="margin-bottom:4px;">
                            <span class="eyebrow-dot"></span>
                            Subcategory
                        </div>

                        <h5 class="modal-title">
                            Add Subcategory
                        </h5>

                        <div
                            id="addSubcategoryParentName"
                            style="
                                font-size:11px;
                                color:var(--connector-muted);
                                margin-top:3px;
                            "
                        ></div>
                    </div>

                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>


                <div class="modal-body">

                    <div class="form-group">

                        <label class="form-label">
                            Subcategory Name
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control-connector"
                            placeholder="e.g. Deep Cleaning"
                            required
                        >

                        <div class="form-help">
                            A unique slug will be generated automatically.
                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn-connector btn-light"
                        data-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn-connector btn-primary"
                    >
                        <i data-lucide="plus" width="15"></i>
                        Add Subcategory
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>


{{-- =============================================================
     EDIT SUBCATEGORY MODAL
============================================================= --}}
<div
    class="modal fade connector-modal"
    id="editSubcategoryModal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >

        <div class="modal-content">

            <form
                method="POST"
                id="editSubcategoryForm"
            >

                @csrf
                @method('PUT')

                <div class="modal-header">

                    <div>
                        <div class="eyebrow" style="margin-bottom:4px;">
                            <span class="eyebrow-dot"></span>
                            Subcategory
                        </div>

                        <h5 class="modal-title">
                            Edit Subcategory
                        </h5>
                    </div>

                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>


                <div class="modal-body">

                    <div class="form-group">

                        <label class="form-label">
                            Subcategory Name
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="editSubcategoryName"
                            class="form-control-connector"
                            required
                        >

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn-connector btn-light"
                        data-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn-connector btn-primary"
                    >
                        <i data-lucide="save" width="15"></i>
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>


{{-- =============================================================
     DELETE CATEGORY FORM
============================================================= --}}
<form
    method="POST"
    id="deleteCategoryForm"
    style="display:none;"
>
    @csrf
    @method('DELETE')
</form>


{{-- =============================================================
     DELETE SUBCATEGORY FORM
============================================================= --}}
<form
    method="POST"
    id="deleteSubcategoryForm"
    style="display:none;"
>
    @csrf
    @method('DELETE')
</form>


{{-- =============================================================
     JAVASCRIPT
============================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        /*
        |--------------------------------------------------------------------------
        | Lucide Icons
        |--------------------------------------------------------------------------
        */
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }


        /*
        |--------------------------------------------------------------------------
        | Category Parent / Image Handling
        |--------------------------------------------------------------------------
        */
        const parentSelect = document.getElementById('categoryParent');
        const imageInput = document.getElementById('categoryImage');
        const imageGroup = document.getElementById('categoryImageGroup');
        const imageRequired = document.getElementById('imageRequired');

        function updateCategoryType() {

            if (!parentSelect) {
                return;
            }

            const isSubcategory = parentSelect.value !== '';

            if (isSubcategory) {

                if (imageGroup) {
                    imageGroup.style.display = 'none';
                }

                if (imageInput) {
                    imageInput.value = '';
                    imageInput.removeAttribute('required');
                }

                if (imageRequired) {
                    imageRequired.style.display = 'none';
                }

            } else {

                if (imageGroup) {
                    imageGroup.style.display = 'block';
                }

                if (imageInput) {
                    imageInput.setAttribute('required', 'required');
                }

                if (imageRequired) {
                    imageRequired.style.display = 'inline';
                }
            }
        }

        if (parentSelect) {
            parentSelect.addEventListener(
                'change',
                updateCategoryType
            );

            updateCategoryType();
        }


        /*
        |--------------------------------------------------------------------------
        | Open Category
        |--------------------------------------------------------------------------
        */
        window.openCategory = function (categoryId) {

            const emptyState =
                document.getElementById('detailsEmpty');

            const panel =
                document.getElementById('detailsPanel');

            const overlay =
                document.getElementById('drawerOverlay');

            if (!emptyState || !panel) {
                return;
            }

            /*
             * Hide all detail contents
             */
            document
                .querySelectorAll('.details-content')
                .forEach(function (content) {
                    content.classList.remove('active');
                });

            /*
             * Remove active card
             */
            document
                .querySelectorAll('.category-card')
                .forEach(function (card) {
                    card.classList.remove('active');
                });

            /*
             * Show selected content
             */
            const details =
                document.getElementById(
                    'details-' + categoryId
                );

            const card =
                document.getElementById(
                    'category-card-' + categoryId
                );

            if (details) {
                details.classList.add('active');
            }

            if (card) {
                card.classList.add('active');
            }

            emptyState.style.display = 'none';

            /*
             * Mobile drawer
             */
            if (window.innerWidth <= 992) {

                panel.classList.add('mobile-open');

                if (overlay) {
                    overlay.classList.add('active');
                }

                document.body.style.overflow = 'hidden';
            }

            /*
             * Scroll selected category into view
             */
            if (card && window.innerWidth <= 992) {
                card.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }
        };


        /*
        |--------------------------------------------------------------------------
        | Close Category Panel
        |--------------------------------------------------------------------------
        */
        window.closeCategoryPanel = function () {

            const panel =
                document.getElementById('detailsPanel');

            const overlay =
                document.getElementById('drawerOverlay');

            if (panel) {
                panel.classList.remove('mobile-open');
            }

            if (overlay) {
                overlay.classList.remove('active');
            }

            document.body.style.overflow = '';

            document
                .querySelectorAll('.category-card')
                .forEach(function (card) {
                    card.classList.remove('active');
                });

            document
                .querySelectorAll('.details-content')
                .forEach(function (content) {
                    content.classList.remove('active');
                });

            const emptyState =
                document.getElementById('detailsEmpty');

            if (emptyState) {
                emptyState.style.display = 'flex';
            }
        };


        /*
        |--------------------------------------------------------------------------
        | Add Subcategory
        |--------------------------------------------------------------------------
        */
        window.openAddSubcategoryModal = function (
            categoryId,
            categoryName
        ) {

            const parentId =
                document.getElementById(
                    'addSubcategoryParentId'
                );

            const parentName =
                document.getElementById(
                    'addSubcategoryParentName'
                );

            const form =
                document.getElementById(
                    'addSubcategoryForm'
                );

            if (parentId) {
                parentId.value = categoryId;
            }

            if (parentName) {
                parentName.textContent =
                    'Adding to: ' + categoryName;
            }

            if (form) {
                form.querySelector('input[name="name"]').value = '';
            }

            $('#addSubcategoryModal').modal('show');
        };


        /*
        |--------------------------------------------------------------------------
        | Edit Subcategory
        |--------------------------------------------------------------------------
        */
        window.openEditSubcategoryModal = function (
            subcategoryId,
            subcategoryName,
            categoryId
        ) {

            const form =
                document.getElementById(
                    'editSubcategoryForm'
                );

            const nameInput =
                document.getElementById(
                    'editSubcategoryName'
                );

            if (nameInput) {
                nameInput.value = subcategoryName;
            }

            /*
             * Change this route if your project uses
             * another update route.
             *
             * Expected:
             * PUT /admin/subcategory/{id}
             */
            if (form) {

                form.action =
                    "{{ url('/admin/subcategory') }}/" +
                    subcategoryId;
            }

            $('#editSubcategoryModal').modal('show');
        };


        /*
        |--------------------------------------------------------------------------
        | Delete Category
        |--------------------------------------------------------------------------
        */
        window.confirmDeleteCategory = function (
            categoryId,
            categoryName
        ) {

            const confirmed = confirm(
                'Delete "' +
                categoryName +
                '"?\n\n' +
                'This may also affect its related subcategories and services.'
            );

            if (!confirmed) {
                return;
            }

            const form =
                document.getElementById(
                    'deleteCategoryForm'
                );

            if (!form) {
                return;
            }

            form.action =
                "{{ url('/admin/service-category') }}/" +
                categoryId;

            form.submit();
        };


        /*
        |--------------------------------------------------------------------------
        | Delete Subcategory
        |--------------------------------------------------------------------------
        */
        window.confirmDeleteSubcategory = function (
            subcategoryId,
            subcategoryName
        ) {

            const confirmed = confirm(
                'Delete subcategory "' +
                subcategoryName +
                '"?'
            );

            if (!confirmed) {
                return;
            }

            const form =
                document.getElementById(
                    'deleteSubcategoryForm'
                );

            if (!form) {
                return;
            }

            form.action =
                "{{ url('/admin/subcategory') }}/" +
                subcategoryId;

            form.submit();
        };


        /*
        |--------------------------------------------------------------------------
        | ESC closes mobile panel
        |--------------------------------------------------------------------------
        */
        document.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Escape') {

                    const panel =
                        document.getElementById(
                            'detailsPanel'
                        );

                    if (
                        panel &&
                        panel.classList.contains(
                            'mobile-open'
                        )
                    ) {
                        closeCategoryPanel();
                    }
                }
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Re-render icons
        |--------------------------------------------------------------------------
        */
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

    });
</script>


{{-- =============================================================
     VALIDATION ERRORS
============================================================= --}}
@if($errors->any())

    <div
        class="modal fade connector-modal"
        id="validationErrorModal"
        tabindex="-1"
        role="dialog"
    >

        <div
            class="modal-dialog modal-dialog-centered"
            role="document"
        >

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Please check your input
                    </h5>

                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                    >
                        <span>&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <div
                        style="
                            background:#FFF3F0;
                            border:1px solid #F2D8D2;
                            border-radius:11px;
                            padding:14px;
                        "
                    >

                        <ul
                            style="
                                margin:0;
                                padding-left:18px;
                                color:var(--connector-danger);
                                font-size:12px;
                            "
                        >
                            @foreach($errors->all() as $error)
                                <li style="margin-bottom:5px;">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn-connector btn-primary"
                        data-dismiss="modal"
                    >
                        Close
                    </button>

                </div>

            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#validationErrorModal').modal('show');
        });
    </script>

@endif

@endsection