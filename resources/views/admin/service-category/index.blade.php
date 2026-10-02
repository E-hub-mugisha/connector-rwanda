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
    --connector-white: #FFFFFF;
    --connector-shadow: 0 10px 30px rgba(37, 64, 53, .07);
    --connector-shadow-lg: 0 20px 50px rgba(37, 64, 53, .11);
  }

  .category-page {
    min-height: calc(100vh - 70px);
    background: var(--connector-bg);
    padding: 28px 0 45px;
  }

  .category-container {
    max-width: 1600px;
    margin: 0 auto;
    padding: 0 28px;
  }

  /* =========================================================
       PAGE HEADER
    ========================================================= */

  .page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 20px;
    margin-bottom: 25px;
  }

  .page-header-left {
    min-width: 0;
  }

  .page-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: var(--connector-primary);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: 7px;
  }

  .page-eyebrow span {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--connector-primary);
  }

  .page-title {
    color: var(--connector-text);
    font-size: 28px;
    line-height: 1.15;
    font-weight: 800;
    letter-spacing: -.035em;
    margin: 0;
  }

  .page-description {
    color: var(--connector-muted);
    font-size: 14px;
    margin: 7px 0 0;
    max-width: 680px;
  }

  .page-actions {
    display: flex;
    gap: 10px;
    flex-shrink: 0;
  }

  .btn-saas {
    min-height: 42px;
    padding: 0 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border-radius: 11px;
    border: 1px solid var(--connector-border);
    background: #fff;
    color: var(--connector-text);
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: all .2s ease;
  }

  .btn-saas:hover {
    color: var(--connector-primary-dark);
    text-decoration: none;
    border-color: #cadbd4;
    transform: translateY(-1px);
  }

  .btn-saas-primary {
    background: var(--connector-primary-dark);
    color: #fff;
    border-color: var(--connector-primary-dark);
    box-shadow: 0 7px 18px rgba(37, 64, 53, .14);
  }

  .btn-saas-primary:hover {
    background: #1c3229;
    color: #fff;
    border-color: #1c3229;
  }


  /* =========================================================
       ALERT
    ========================================================= */

  .saas-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    background: var(--connector-soft);
    border: 1px solid #d7e6df;
    border-radius: 12px;
    color: var(--connector-primary-dark);
    font-size: 13px;
    margin-bottom: 20px;
  }

  .saas-alert i {
    color: var(--connector-primary);
  }


  /* =========================================================
       STATS
    ========================================================= */

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 20px;
  }

  .stat-card {
    background: #fff;
    border: 1px solid var(--connector-border);
    border-radius: 15px;
    padding: 18px;
    box-shadow: var(--connector-shadow);
    transition: .2s ease;
  }

  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--connector-shadow-lg);
  }

  .stat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
  }

  .stat-label {
    color: var(--connector-muted);
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .055em;
  }

  .stat-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: var(--connector-soft);
    color: var(--connector-primary-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
  }

  .stat-value {
    color: var(--connector-text);
    font-size: 24px;
    line-height: 1;
    font-weight: 800;
    letter-spacing: -.03em;
  }

  .stat-description {
    margin-top: 7px;
    color: var(--connector-muted);
    font-size: 11px;
  }


  /* =========================================================
       MAIN CARD
    ========================================================= */

  .main-card {
    background: #fff;
    border: 1px solid var(--connector-border);
    border-radius: 18px;
    box-shadow: var(--connector-shadow);
    overflow: hidden;
  }

  .main-card-header {
    padding: 20px;
    border-bottom: 1px solid var(--connector-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
  }

  .card-heading {
    min-width: 0;
  }

  .card-title {
    color: var(--connector-text);
    font-size: 16px;
    font-weight: 800;
    margin: 0;
  }

  .card-description {
    color: var(--connector-muted);
    font-size: 12px;
    margin: 4px 0 0;
  }


  /* =========================================================
       TOOLBAR
    ========================================================= */

  .toolbar {
    padding: 14px 20px;
    background: #fbfdfc;
    border-bottom: 1px solid var(--connector-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }

  .search-box {
    width: 330px;
    position: relative;
  }

  .search-box i {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #92a39b;
    font-size: 12px;
  }

  .search-box input {
    width: 100%;
    height: 39px;
    border: 1px solid var(--connector-border);
    border-radius: 10px;
    background: #fff;
    padding: 0 13px 0 36px;
    color: var(--connector-text);
    font-size: 12px;
    outline: none;
    transition: .2s ease;
  }

  .search-box input:focus {
    border-color: var(--connector-primary);
    box-shadow: 0 0 0 3px rgba(107, 144, 128, .10);
  }

  .toolbar-count {
    color: var(--connector-muted);
    font-size: 12px;
    white-space: nowrap;
  }


  /* =========================================================
       TABLE
    ========================================================= */

  .table-wrap {
    overflow-x: auto;
  }

  .category-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px;
  }

  .category-table th {
    background: #fafcfb;
    color: var(--connector-muted);
    border-bottom: 1px solid var(--connector-border);
    padding: 12px 18px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .06em;
    white-space: nowrap;
  }

  .category-table td {
    padding: 14px 18px;
    border-bottom: 1px solid #edf2ef;
    vertical-align: middle;
    color: var(--connector-text);
    font-size: 13px;
  }

  .category-table tbody tr {
    transition: .15s ease;
  }

  .category-table tbody tr:hover {
    background: #fbfdfc;
  }

  .category-table tbody tr:last-child td {
    border-bottom: 0;
  }


  /* =========================================================
       CATEGORY ID
    ========================================================= */

  .category-id {
    width: 45px;
    color: #95a49e;
    font-size: 11px;
    font-weight: 700;
  }


  /* =========================================================
       CATEGORY IMAGE
    ========================================================= */

  .category-image {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    object-fit: cover;
    border: 1px solid var(--connector-border);
    background: var(--connector-soft);
  }

  .image-placeholder {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: var(--connector-soft);
    color: var(--connector-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
  }


  /* =========================================================
       CATEGORY NAME
    ========================================================= */

  .category-info {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .category-name {
    color: var(--connector-text);
    font-size: 13px;
    font-weight: 800;
    margin-bottom: 3px;
  }

  .category-slug {
    color: var(--connector-muted);
    font-size: 10px;
  }


  /* =========================================================
       BADGES
    ========================================================= */

  .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 9px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 800;
    white-space: nowrap;
  }

  .status-badge::before {
    content: "";
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
  }

  .status-featured {
    color: #89681c;
    background: #faf4e4;
  }

  .status-normal {
    color: var(--connector-muted);
    background: #f1f4f2;
  }

  .parent-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--connector-primary-dark);
    background: var(--connector-soft);
    border-radius: 8px;
    padding: 5px 8px;
    font-size: 10px;
    font-weight: 700;
  }

  .sub-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 27px;
    height: 27px;
    padding: 0 8px;
    border-radius: 8px;
    background: var(--connector-soft);
    color: var(--connector-primary-dark);
    font-size: 11px;
    font-weight: 800;
    margin-right: 6px;
  }

  .view-subcategories {
    border: 0;
    background: transparent;
    color: var(--connector-primary);
    font-size: 11px;
    font-weight: 800;
    cursor: pointer;
    padding: 0;
  }

  .view-subcategories:hover {
    color: var(--connector-primary-dark);
  }


  /* =========================================================
       ACTIONS
    ========================================================= */

  .action-group {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 6px;
  }

  .action-btn {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--connector-border);
    background: #fff;
    color: var(--connector-muted);
    transition: .2s ease;
    text-decoration: none;
    cursor: pointer;
  }

  .action-btn:hover {
    color: var(--connector-primary-dark);
    background: var(--connector-soft);
    border-color: #cadbd4;
    text-decoration: none;
  }

  .action-btn.delete:hover {
    color: var(--connector-danger);
    background: #fff3f0;
    border-color: #f0d4cd;
  }

  .action-form {
    margin: 0;
    padding: 0;
  }


  /* =========================================================
       EMPTY STATE
    ========================================================= */

  .empty-state {
    padding: 65px 25px;
    text-align: center;
  }

  .empty-icon {
    width: 58px;
    height: 58px;
    margin: 0 auto 15px;
    border-radius: 16px;
    background: var(--connector-soft);
    color: var(--connector-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
  }

  .empty-title {
    color: var(--connector-text);
    font-size: 15px;
    font-weight: 800;
    margin-bottom: 5px;
  }

  .empty-description {
    color: var(--connector-muted);
    font-size: 12px;
    margin-bottom: 17px;
  }


  /* =========================================================
       MODAL
    ========================================================= */

  .saas-modal .modal-content {
    border: 0;
    border-radius: 18px;
    box-shadow: 0 25px 70px rgba(20, 40, 32, .20);
    overflow: hidden;
  }

  .saas-modal .modal-header {
    padding: 19px 20px;
    background: #fff;
    border-bottom: 1px solid var(--connector-border);
  }

  .saas-modal .modal-title {
    color: var(--connector-text);
    font-size: 16px;
    font-weight: 800;
  }

  .saas-modal .modal-body {
    padding: 22px;
    background: #fff;
  }

  .saas-modal .modal-footer {
    padding: 14px 20px;
    border-top: 1px solid var(--connector-border);
    background: #fbfdfc;
  }

  .modal-subtitle {
    color: var(--connector-muted);
    font-size: 12px;
    margin-top: 3px;
  }

  .form-label-saas {
    display: block;
    color: var(--connector-text);
    font-size: 12px;
    font-weight: 800;
    margin-bottom: 7px;
  }

  .required {
    color: var(--connector-danger);
  }

  .form-control-saas {
    width: 100%;
    height: 43px;
    border: 1px solid var(--connector-border);
    border-radius: 10px;
    padding: 0 12px;
    font-size: 13px;
    color: var(--connector-text);
    background: #fff;
    outline: none;
    transition: .2s ease;
  }

  textarea.form-control-saas {
    height: auto;
    min-height: 100px;
    padding-top: 10px;
  }

  .form-control-saas:focus {
    border-color: var(--connector-primary);
    box-shadow: 0 0 0 3px rgba(107, 144, 128, .10);
  }

  .form-help {
    display: block;
    color: var(--connector-muted);
    font-size: 10px;
    margin-top: 6px;
  }

  .image-upload {
    border: 1px dashed #cbdad4;
    border-radius: 12px;
    background: #fbfdfc;
    padding: 15px;
  }

  .image-upload input {
    width: 100%;
    font-size: 12px;
    color: var(--connector-muted);
  }

  .modal-btn {
    min-height: 40px;
    padding: 0 15px;
    border-radius: 9px;
    font-size: 12px;
    font-weight: 700;
    border: 1px solid var(--connector-border);
  }

  .modal-btn-primary {
    background: var(--connector-primary-dark);
    color: #fff;
    border-color: var(--connector-primary-dark);
  }

  .modal-btn-primary:hover {
    background: #1d342b;
    color: #fff;
  }


  /* =========================================================
       SUBCATEGORY LIST
    ========================================================= */

  .subcategory-list {
    display: grid;
    gap: 8px;
  }

  .subcategory-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 12px;
    border: 1px solid var(--connector-border);
    border-radius: 10px;
    background: #fbfdfc;
  }

  .subcategory-number {
    width: 26px;
    height: 26px;
    min-width: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: var(--connector-soft);
    color: var(--connector-primary-dark);
    font-size: 10px;
    font-weight: 800;
  }

  .subcategory-name {
    color: var(--connector-text);
    font-size: 12px;
    font-weight: 700;
  }

  .no-subcategories {
    text-align: center;
    padding: 30px 10px;
    color: var(--connector-muted);
    font-size: 12px;
  }


  /* =========================================================
       RESPONSIVE
    ========================================================= */

  @media (max-width: 1200px) {

    .stats-grid {
      grid-template-columns: repeat(2, 1fr);
    }

  }

  @media (max-width: 768px) {

    .category-page {
      padding-top: 20px;
    }

    .category-container {
      padding: 0 15px;
    }

    .page-header {
      flex-direction: column;
      align-items: flex-start;
    }

    .page-actions {
      width: 100%;
    }

    .page-actions .btn-saas {
      flex: 1;
    }

    .page-title {
      font-size: 24px;
    }

    .stats-grid {
      grid-template-columns: 1fr 1fr;
    }

    .main-card-header {
      align-items: flex-start;
      flex-direction: column;
    }

    .toolbar {
      align-items: stretch;
      flex-direction: column;
    }

    .search-box {
      width: 100%;
    }

  }

  @media (max-width: 500px) {

    .stats-grid {
      grid-template-columns: 1fr;
    }

    .stat-card {
      padding: 16px;
    }

    .page-actions {
      flex-direction: column;
    }

    .page-actions .btn-saas {
      width: 100%;
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

        <div class="page-eyebrow">
          <span></span>
          Marketplace
        </div>

        <h1 class="page-title">
          Service Categories
        </h1>

        <p class="page-description">
          Organize services into clear categories and subcategories
          to make your marketplace easier to discover and manage.
        </p>

      </div>

      <div class="page-actions">

        <button type="button"
          class="btn-saas btn-saas-primary"
          data-bs-toggle="modal"
          data-bs-target="#CategoryModal">

          <i class="fas fa-plus"></i>

          Add Category

        </button>

      </div>

    </div>


    {{-- =====================================================
             SUCCESS MESSAGE
        ====================================================== --}}

    @if(Session::has('message'))

    <div class="saas-alert">

      <i class="fas fa-check-circle"></i>

      <span>
        {{ Session::get('message') }}
      </span>

    </div>

    @endif


    {{-- =====================================================
             SUMMARY
        ====================================================== --}}

    @php

    $totalCategories = $scategories->count();

    $featuredCategories = $scategories->where('featured', true)->count();

    $parentCategories = $scategories->filter(function ($category) {
    return empty($category->service_category_id);
    })->count();

    $totalSubcategories = $scategories->sum(function ($category) {
    return $category->subcategories->count();
    });

    @endphp


    <div class="stats-grid">

      {{-- Total --}}
      <div class="stat-card">

        <div class="stat-header">

          <span class="stat-label">
            Total Categories
          </span>

          <div class="stat-icon">
            <i class="fas fa-layer-group"></i>
          </div>

        </div>

        <div class="stat-value">
          {{ number_format($totalCategories) }}
        </div>

        <div class="stat-description">
          All service categories
        </div>

      </div>


      {{-- Featured --}}
      <div class="stat-card">

        <div class="stat-header">

          <span class="stat-label">
            Featured
          </span>

          <div class="stat-icon">
            <i class="fas fa-star"></i>
          </div>

        </div>

        <div class="stat-value">
          {{ number_format($featuredCategories) }}
        </div>

        <div class="stat-description">
          Featured marketplace categories
        </div>

      </div>


      {{-- Parent --}}
      <div class="stat-card">

        <div class="stat-header">

          <span class="stat-label">
            Main Categories
          </span>

          <div class="stat-icon">
            <i class="fas fa-folder"></i>
          </div>

        </div>

        <div class="stat-value">
          {{ number_format($parentCategories) }}
        </div>

        <div class="stat-description">
          Top-level categories
        </div>

      </div>


      {{-- Subcategories --}}
      <div class="stat-card">

        <div class="stat-header">

          <span class="stat-label">
            Subcategories
          </span>

          <div class="stat-icon">
            <i class="fas fa-sitemap"></i>
          </div>

        </div>

        <div class="stat-value">
          {{ number_format($totalSubcategories) }}
        </div>

        <div class="stat-description">
          Organized service types
        </div>

      </div>

    </div>


    {{-- =====================================================
             ADD CATEGORY MODAL
        ====================================================== --}}

    <div class="modal fade saas-modal"
      id="CategoryModal"
      tabindex="-1"
      role="dialog"
      aria-hidden="true">

      <div class="modal-dialog modal-dialog-centered"
        role="document">

        <div class="modal-content">

          <div class="modal-header">

            <div>

              <h5 class="modal-title">
                Add service category
              </h5>

              <div class="modal-subtitle">
                Create a new category for your marketplace.
              </div>

            </div>

            <button type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"></button>

          </div>


          <form action="{{ route('admin.create_service_category') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="modal-body">

              {{-- Category name --}}

              <div class="form-group">

                <label class="form-label-saas"
                  for="category_name">

                  Category name

                  <span class="required">*</span>

                </label>

                <input type="text"
                  class="form-control-saas"
                  id="category_name"
                  name="name"
                  value="{{ old('name') }}"
                  placeholder="e.g. Home Services"
                  required>

                @error('name')
                <small class="text-danger">
                  {{ $message }}
                </small>
                @enderror

              </div>


              {{-- Parent category --}}

              <div class="form-group">

                <label class="form-label-saas"
                  for="service_category_id">

                  Parent category

                </label>

                <select class="form-control-saas"
                  name="service_category_id"
                  id="service_category_id">

                  <option value="">
                    None — Main Category
                  </option>

                  @foreach($scategories as $category)

                  <option value="{{ $category->id }}"
                    {{ old('service_category_id') == $category->id ? 'selected' : '' }}>

                    {{ $category->name }}

                  </option>

                  @endforeach

                </select>

                <small class="form-help">
                  Select a parent if this should be a subcategory.
                </small>

              </div>


              {{-- Image --}}

              <div class="form-group mb-0">

                <label class="form-label-saas"
                  for="image">

                  Category image

                  <span class="required">*</span>

                </label>

                <div class="image-upload">

                  <input type="file"
                    id="image"
                    name="image"
                    accept="image/*"
                    required>

                  <small class="form-help">
                    Use a clear square image for the best marketplace appearance.
                  </small>

                </div>

                @error('image')
                <small class="text-danger">
                  {{ $message }}
                </small>
                @enderror

              </div>

            </div>


            <div class="modal-footer">

              <button type="button"
                class="modal-btn"
                data-bs-dismiss="modal">

                Cancel

              </button>

              <button type="submit"
                class="modal-btn modal-btn-primary">

                <i class="fas fa-plus mr-1"></i>

                Create category

              </button>

            </div>

          </form>

        </div>

      </div>

    </div>


    {{-- =====================================================
             CATEGORY TABLE
        ====================================================== --}}

    <div class="main-card">

      <div class="main-card-header">

        <div class="card-heading">

          <h2 class="card-title">
            Category library
          </h2>

          <p class="card-description">
            Manage categories, hierarchy and marketplace visibility.
          </p>

        </div>

        <div class="toolbar-count">

          {{ $totalCategories }}

          {{ Str::plural('category', $totalCategories) }}

        </div>

      </div>


      {{-- Search --}}

      <div class="toolbar">

        <div class="search-box">

          <i class="fas fa-search"></i>

          <input type="text"
            id="categorySearch"
            placeholder="Search categories...">

        </div>

        <div class="toolbar-count"
          id="visibleCount">

          Showing {{ $totalCategories }}

        </div>

      </div>


      @if($scategories->count())

      <div class="table-wrap">

        <table class="category-table"
          id="categoryTable">

          <thead>

            <tr>

              <th>#</th>

              <th>Category</th>

              <th>Visibility</th>

              <th>Parent</th>

              <th>Subcategories</th>

              <th class="text-right">
                Actions
              </th>

            </tr>

          </thead>


          <tbody>

            @foreach($scategories as $scategory)

            <tr class="category-row"
              data-search="{{ strtolower(
                                        $scategory->name . ' ' .
                                        ($scategory->slug ?? '')
                                    ) }}">

              {{-- ID --}}

              <td>

                <span class="category-id">
                  #{{ $scategory->id }}
                </span>

              </td>


              {{-- Category --}}

              <td>

                <div class="category-info">

                  @if(!empty($scategory->image))

                  <img
                    src="{{ asset('image/categories/' . $scategory->image) }}"
                    alt="{{ $scategory->name }}"
                    class="category-image"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                  <div class="image-placeholder"
                    style="display:none;">
                    <i class="fas fa-image"></i>
                  </div>

                  @else

                  <div class="image-placeholder">
                    <i class="fas fa-image"></i>
                  </div>

                  @endif


                  <div>

                    <div class="category-name">
                      {{ $scategory->name }}
                    </div>

                    @if(!empty($scategory->slug))

                    <div class="category-slug">
                      /{{ $scategory->slug }}
                    </div>

                    @endif

                  </div>

                </div>

              </td>


              {{-- Featured --}}

              <td>

                @if($scategory->featured)

                <span class="status-badge status-featured">
                  Featured
                </span>

                @else

                <span class="status-badge status-normal">
                  Standard
                </span>

                @endif

              </td>


              {{-- Parent --}}

              <td>

                @if(!empty($scategory->service_category_id))

                @php

                $parent = $scategories->firstWhere(
                'id',
                $scategory->service_category_id
                );

                @endphp

                <span class="parent-badge">

                  <i class="fas fa-level-up-alt"></i>

                  {{ $parent->name ?? 'Parent category' }}

                </span>

                @else

                <span style="color:#9aa9a2;font-size:11px;">
                  Main category
                </span>

                @endif

              </td>


              {{-- Subcategories --}}

              <td>

                @php
                $subCount = $scategory->subcategories->count();
                @endphp

                <span class="sub-count">
                  {{ $subCount }}
                </span>

                <button type="button"
                  class="view-subcategories"
                  data-bs-toggle="offcanvas"
                  data-bs-target="#subCategoryPanel{{ $scategory->id }}"
                  aria-controls="subCategoryPanel{{ $scategory->id }}">
                  Manage
                </button>
              </td>


              {{-- Actions --}}

              <td>

                <div class="action-group">

                  {{-- View services --}}

                  <a
                    href="{{ route(
                        'admin.service_by_category',
                        ['category_slug' => $scategory->slug]
                    ) }}"
                    class="action-btn"
                    title="View services"
                    aria-label="View services"
                  >
                    <svg
                      width="16"
                      height="16"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      aria-hidden="true"
                    >
                      <path d="M4 5h16"></path>
                      <path d="M4 12h16"></path>
                      <path d="M4 19h16"></path>
                      <circle cx="8" cy="5" r="1"></circle>
                      <circle cx="16" cy="12" r="1"></circle>
                      <circle cx="10" cy="19" r="1"></circle>
                    </svg>
                  </a>


                  {{-- Edit --}}

                  <a
                    href="{{ route(
                        'admin.edit_service_category',
                        $scategory->id
                    ) }}"
                    class="action-btn"
                    title="Edit category"
                    aria-label="Edit category"
                  >
                    <svg
                      width="16"
                      height="16"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      aria-hidden="true"
                    >
                      <path d="M12 20h9"></path>
                      <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                    </svg>
                  </a>


                  {{-- Delete --}}

                  <form
                    class="action-form"
                    action="{{ route(
                        'admin.delete_service_category',
                        $scategory->id
                    ) }}"
                    method="POST"
                  >

                    @csrf

                    @method('DELETE')

                    <button
                      type="submit"
                      class="action-btn delete"
                      title="Delete category"
                      aria-label="Delete category"
                      onclick="return confirm('Are you sure you want to delete {{ addslashes($scategory->name) }}?')"
                    >
                      <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                      >
                        <path d="M3 6h18"></path>
                        <path d="M8 6V4h8v2"></path>
                        <path d="M19 6l-1 14H6L5 6"></path>
                        <path d="M10 11v5"></path>
                        <path d="M14 11v5"></path>
                      </svg>
                    </button>

                  </form>

                </div>

              </td>

            </tr>

            @endforeach

          </tbody>

        </table>

      </div>



      {{-- =====================================================
           SUBCATEGORY PANELS
           Bootstrap 5 offcanvas panels are kept outside the table.
           Each category gets its own right-side management panel.
         ====================================================== --}}
      @foreach($scategories as $scategory)
        @php
          $subCount = $scategory->subcategories->count();
        @endphp

        <div
          class="offcanvas offcanvas-end subcategory-panel"
          tabindex="-1"
          id="subCategoryPanel{{ $scategory->id }}"
          aria-labelledby="subCategoryPanelLabel{{ $scategory->id }}"
          data-bs-backdrop="true"
        >
          <div class="offcanvas-header subcategory-panel-header">
            <div class="subcategory-panel-heading">
              <div class="subcategory-panel-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M4 5h16"></path>
                  <path d="M4 12h16"></path>
                  <path d="M4 19h16"></path>
                  <circle cx="8" cy="5" r="1"></circle>
                  <circle cx="16" cy="12" r="1"></circle>
                  <circle cx="10" cy="19" r="1"></circle>
                </svg>
              </div>
              <div>
                <h5 class="offcanvas-title" id="subCategoryPanelLabel{{ $scategory->id }}">
                  {{ $scategory->name }}
                </h5>
                <div class="modal-subtitle">
                  {{ $subCount }} {{ Str::plural('subcategory', $subCount) }}
                </div>
              </div>
            </div>

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>

          <div class="offcanvas-body subcategory-panel-body">
            <div class="subcategory-panel-toolbar">
              <div>
                <div class="panel-section-title">Subcategories</div>
                <div class="panel-section-description">
                  Manage the service types under <strong>{{ $scategory->name }}</strong>.
                </div>
              </div>

              <button
                type="button"
                class="btn-saas btn-saas-primary panel-add-btn"
                data-bs-toggle="modal"
                data-bs-target="#addSubCategoryModal{{ $scategory->id }}"
              >
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M12 5v14"></path>
                  <path d="M5 12h14"></path>
                </svg>
                Add
              </button>
            </div>

            @if($subCount > 0)
              <div class="subcategory-list subcategory-management-list">
                @foreach($scategory->subcategories as $index => $scat)
                  <div class="subcategory-item subcategory-management-item">
                    <div class="subcategory-number">{{ $index + 1 }}</div>

                    <div class="subcategory-main">
                      <div class="subcategory-name">{{ $scat->name }}</div>
                      @if(!empty($scat->slug))
                        <div class="subcategory-slug">/{{ $scat->slug }}</div>
                      @endif
                    </div>

                    <div class="subcategory-actions">
                      <button
                        type="button"
                        class="panel-action-btn"
                        title="Edit subcategory"
                        aria-label="Edit {{ $scat->name }}"
                        data-bs-toggle="modal"
                        data-bs-target="#editSubCategoryModal{{ $scat->id }}"
                      >
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                          <path d="M12 20h9"></path>
                          <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                        </svg>
                      </button>

                      <form
                        action="{{ route('admin.delete_sub_category', $scat->id) }}"
                        method="POST"
                        class="subcategory-delete-form"
                      >
                        @csrf
                        @method('DELETE')
                        <button
                          type="submit"
                          class="panel-action-btn delete"
                          title="Delete subcategory"
                          aria-label="Delete {{ $scat->name }}"
                          onclick="return confirm('Are you sure you want to delete {{ addslashes($scat->name) }}?')"
                        >
                          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M3 6h18"></path>
                            <path d="M8 6V4h8v2"></path>
                            <path d="M19 6l-1 14H6L5 6"></path>
                            <path d="M10 11v5"></path>
                            <path d="M14 11v5"></path>
                          </svg>
                        </button>
                      </form>
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <div class="panel-empty-state">
                <div class="panel-empty-icon">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M4 6h16"></path>
                    <path d="M4 12h16"></path>
                    <path d="M4 18h10"></path>
                  </svg>
                </div>
                <div class="panel-empty-title">No subcategories yet</div>
                <div class="panel-empty-description">
                  Add the first subcategory under {{ $scategory->name }}.
                </div>
                <button
                  type="button"
                  class="btn-saas btn-saas-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#addSubCategoryModal{{ $scategory->id }}"
                >
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 5v14"></path>
                    <path d="M5 12h14"></path>
                  </svg>
                  Add subcategory
                </button>
              </div>
            @endif
          </div>
        </div>

        {{-- Add subcategory modal --}}
        <div class="modal fade saas-modal" id="addSubCategoryModal{{ $scategory->id }}" tabindex="-1" aria-labelledby="addSubCategoryModalLabel{{ $scategory->id }}" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <div>
                  <h5 class="modal-title" id="addSubCategoryModalLabel{{ $scategory->id }}">Add subcategory</h5>
                  <div class="modal-subtitle">Create a service type under {{ $scategory->name }}.</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <form action="{{ route('admin.add_Subcategory') }}" method="POST">
                @csrf
                <div class="modal-body">
                  <input type="hidden" name="service_category_id" value="{{ $scategory->id }}">

                  <div class="form-group mb-0">
                    <label class="form-label-saas" for="subcategory_name_{{ $scategory->id }}">
                      Subcategory name <span class="required">*</span>
                    </label>
                    <input
                      type="text"
                      class="form-control-saas"
                      id="subcategory_name_{{ $scategory->id }}"
                      name="name"
                      value="{{ old('name') }}"
                      placeholder="e.g. House Cleaning"
                      required
                    >
                    <small class="form-help">The slug can be generated automatically by your controller.</small>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="modal-btn" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="modal-btn modal-btn-primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path d="M12 5v14"></path>
                      <path d="M5 12h14"></path>
                    </svg>
                    Add subcategory
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        {{-- Edit subcategory modals --}}
        @foreach($scategory->subcategories as $scat)
          <div class="modal fade saas-modal" id="editSubCategoryModal{{ $scat->id }}" tabindex="-1" aria-labelledby="editSubCategoryModalLabel{{ $scat->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <div>
                    <h5 class="modal-title" id="editSubCategoryModalLabel{{ $scat->id }}">Edit subcategory</h5>
                    <div class="modal-subtitle">Update this service type under {{ $scategory->name }}.</div>
                  </div>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('admin.update_service_subcategory', $scat->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="modal-body">
                    <input type="hidden" name="service_category_id" value="{{ $scategory->id }}">

                    <div class="form-group mb-0">
                      <label class="form-label-saas" for="edit_subcategory_name_{{ $scat->id }}">
                        Subcategory name <span class="required">*</span>
                      </label>
                      <input
                        type="text"
                        class="form-control-saas"
                        id="edit_subcategory_name_{{ $scat->id }}"
                        name="name"
                        value="{{ $scat->name }}"
                        required
                      >
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="modal-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="modal-btn modal-btn-primary">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                      </svg>
                      Save changes
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      @endforeach

      {{-- Empty search state --}}

      <div class="empty-state"
        id="searchEmpty"
        style="display:none;">

        <div class="empty-icon">

          <i class="fas fa-search"></i>

        </div>

        <div class="empty-title">
          No categories found
        </div>

        <div class="empty-description">
          Try searching with a different category name.
        </div>

      </div>

      @else

      <div class="empty-state">

        <div class="empty-icon">

          <i class="fas fa-layer-group"></i>

        </div>

        <div class="empty-title">
          No service categories yet
        </div>

        <div class="empty-description">
          Create your first category to start organizing services.
        </div>

        <button type="button"
          class="btn-saas btn-saas-primary"
          data-bs-toggle="modal"
          data-bs-target="#CategoryModal">

          <i class="fas fa-plus"></i>

          Create first category

        </button>

      </div>

      @endif

    </div>

  </div>

</div>


{{-- ===============================================================
     SEARCH
================================================================ --}}

<script>
  document.addEventListener('DOMContentLoaded', function() {

    const searchInput = document.getElementById('categorySearch');
    const rows = document.querySelectorAll('.category-row');
    const visibleCount = document.getElementById('visibleCount');
    const searchEmpty = document.getElementById('searchEmpty');

    if (!searchInput) {
      return;
    }

    searchInput.addEventListener('input', function() {

      const search = this.value
        .toLowerCase()
        .trim();

      let visible = 0;

      rows.forEach(function(row) {

        const searchableText =
          row.getAttribute('data-search') || '';

        const matches =
          searchableText.includes(search);

        row.style.display = matches ? '' : 'none';

        if (matches) {
          visible++;
        }

      });


      if (visibleCount) {

        visibleCount.innerText =
          'Showing ' + visible;

      }


      if (searchEmpty) {

        searchEmpty.style.display =
          visible === 0 ? 'block' : 'none';

      }

    });

  });
</script>


{{-- ===============================================================
     REOPEN ADD MODAL AFTER VALIDATION ERROR
================================================================ --}}

@if($errors->any())
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const categoryModal = document.getElementById('CategoryModal');

    if (categoryModal && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
      bootstrap.Modal.getOrCreateInstance(categoryModal).show();
      return;
    }

    const parentCategoryId = @json(old('service_category_id'));
    const subcategoryName = @json(old('name'));

    if (parentCategoryId && typeof bootstrap !== 'undefined' && bootstrap.Offcanvas) {
      const panel = document.getElementById('subCategoryPanel' + parentCategoryId);
      if (panel) {
        bootstrap.Offcanvas.getOrCreateInstance(panel).show();
      }

      const addModal = document.getElementById('addSubCategoryModal' + parentCategoryId);
      if (addModal && subcategoryName !== null) {
        bootstrap.Modal.getOrCreateInstance(addModal).show();
      }
    }
  });
</script>
@endif

@endsection