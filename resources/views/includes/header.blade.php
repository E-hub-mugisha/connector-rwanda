{{-- ============================================================
    CONNECTOR HEADER
    ============================================================ --}}

@php
    use App\Models\ServiceCategory;

    /*
    |--------------------------------------------------------------------------
    | Load real service categories
    |--------------------------------------------------------------------------
    |
    | ServiceCategory
    |      └── subcategories
    |              └── services
    |
    */

    $exploreCategories = ServiceCategory::query()
        ->with([
            'subcategories' => function ($query) {
                $query->orderBy('name');
            },
            'subcategories.services',
        ])
        ->withCount('services')
        ->orderByDesc('featured')
        ->orderBy('name')
        ->get();

    $user = auth()->user();

    $role = strtoupper($user?->utype ?? $user?->role ?? '');

    /*
    |--------------------------------------------------------------------------
    | Initials
    |--------------------------------------------------------------------------
    */

    $initials = collect(
        preg_split('/\s+/', trim($user?->name ?? 'User'))
    )
        ->filter()
        ->take(2)
        ->map(fn ($name) => strtoupper(substr($name, 0, 1)))
        ->implode('');

    /*
    |--------------------------------------------------------------------------
    | Helper for service locations
    |--------------------------------------------------------------------------
    */

    $getLocations = function ($subcategory) {
        return $subcategory->services
            ->map(function ($service) {
                return $service->location ?? null;
            })
            ->filter()
            ->map(fn ($location) => trim($location))
            ->filter()
            ->unique()
            ->sort()
            ->values();
    };
@endphp


<header class="cn-header" id="connectorHeader">

    {{-- ========================================================
        TOP / MAIN HEADER
        ======================================================== --}}
    <div class="cn-header-main">
        <div class="container-fluid px-lg-4 px-xl-5">

            <div class="cn-header-inner">

                {{-- BRAND --}}
                <a href="{{ route('home') }}" class="cn-brand">
                    <span class="cn-brand-mark">
                        <i class="bi bi-link-45deg"></i>
                    </span>

                    <span class="cn-brand-text">
                        <strong>Connector</strong>
                        <small>Services made simple</small>
                    </span>
                </a>


                {{-- DESKTOP NAVIGATION --}}
                <nav class="cn-desktop-nav" id="cnDesktopNav">

                    <a href="{{ route('home') }}"
                       class="cn-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        Home
                    </a>

                    <a href="{{ route('home.service_categories') }}"
                       class="cn-nav-link {{ request()->routeIs('home.service_categories') ? 'active' : '' }}">
                        Categories
                    </a>

                    <a href="{{ route('home.services') }}"
                       class="cn-nav-link {{ request()->routeIs('home.services') ? 'active' : '' }}">
                        Services
                    </a>

                    {{-- COMPANY --}}
                    <div class="cn-nav-dropdown">

                        <button type="button"
                                class="cn-nav-link cn-dropdown-trigger">
                            Company
                            <i class="bi bi-chevron-down"></i>
                        </button>

                        <div class="cn-dropdown-menu">

                            <a href="{{ route('about') }}">
                                <span class="cn-dropdown-icon">
                                    <i class="bi bi-building"></i>
                                </span>
                                <span>
                                    <strong>About Us</strong>
                                    <small>Learn about Connector</small>
                                </span>
                            </a>

                            <a href="{{ route('faq') }}">
                                <span class="cn-dropdown-icon">
                                    <i class="bi bi-question-circle"></i>
                                </span>
                                <span>
                                    <strong>FAQ</strong>
                                    <small>Frequently asked questions</small>
                                </span>
                            </a>

                            <a href="{{ route('home.jobs') }}">
                                <span class="cn-dropdown-icon">
                                    <i class="bi bi-briefcase"></i>
                                </span>
                                <span>
                                    <strong>Jobs</strong>
                                    <small>Explore job opportunities</small>
                                </span>
                            </a>

                            <a href="{{ route('home.blogs') }}">
                                <span class="cn-dropdown-icon">
                                    <i class="bi bi-journal-text"></i>
                                </span>
                                <span>
                                    <strong>Blog</strong>
                                    <small>Ideas and useful insights</small>
                                </span>
                            </a>

                            <a href="{{ route('home.contact') }}">
                                <span class="cn-dropdown-icon">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <span>
                                    <strong>Contact</strong>
                                    <small>Get in touch with us</small>
                                </span>
                            </a>

                            <div class="cn-dropdown-divider"></div>

                            <a href="{{ route('policy') }}">
                                <span class="cn-dropdown-icon">
                                    <i class="bi bi-shield-check"></i>
                                </span>
                                <span>
                                    <strong>Privacy Policy</strong>
                                    <small>Your privacy matters</small>
                                </span>
                            </a>

                        </div>
                    </div>

                </nav>


                {{-- SEARCH --}}
                <form action="{{ route('services.search') }}"
                      method="GET"
                      class="cn-header-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="search"
                        name="query"
                        value="{{ request('query') }}"
                        placeholder="Search services..."
                        autocomplete="off"
                    >

                    <button type="submit">
                        Search
                    </button>
                </form>


                {{-- RIGHT ACTIONS --}}
                <div class="cn-header-actions">

                    {{-- EXPLORE --}}
                    <button type="button"
                            class="cn-explore-btn"
                            id="cnExploreBtn"
                            aria-controls="cnExplorePanel"
                            aria-expanded="false">

                        <span class="cn-explore-icon">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </span>

                        <span class="d-none d-xl-inline">
                            Explore
                        </span>
                    </button>


                    {{-- USER --}}
                    @auth

                        <div class="cn-user-dropdown">

                            <button type="button"
                                    class="cn-user-btn"
                                    id="cnUserBtn"
                                    aria-expanded="false">

                                <span class="cn-avatar">
                                    {{ $initials ?: 'U' }}
                                </span>

                                <span class="cn-user-info d-none d-lg-flex">
                                    <strong>{{ Str::limit($user->name, 18) }}</strong>

                                    <small>
                                        @if($role === 'ADM')
                                            Administrator
                                        @elseif($role === 'SVP')
                                            Service Provider
                                        @else
                                            Customer
                                        @endif
                                    </small>
                                </span>

                                <i class="bi bi-chevron-down d-none d-lg-block"></i>
                            </button>


                            <div class="cn-user-menu" id="cnUserMenu">

                                <div class="cn-user-menu-header">

                                    <span class="cn-avatar cn-avatar-large">
                                        {{ $initials ?: 'U' }}
                                    </span>

                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <small>{{ $user->email }}</small>
                                    </div>

                                </div>

                                <div class="cn-dropdown-divider"></div>

                                @if($role === 'ADM')

                                    <a href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2"></i>
                                        Dashboard
                                    </a>

                                @elseif($role === 'SVP')

                                    <a href="{{ route('sprovider.dashboard') }}">
                                        <i class="bi bi-speedometer2"></i>
                                        Dashboard
                                    </a>

                                @else

                                    <a href="{{ route('customer.dashboard') }}">
                                        <i class="bi bi-speedometer2"></i>
                                        Dashboard
                                    </a>

                                @endif

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit" class="cn-logout">
                                        <i class="bi bi-box-arrow-right"></i>
                                        Logout
                                    </button>
                                </form>

                            </div>

                        </div>

                    @else

                        <a href="{{ route('register') }}"
                           class="cn-register-btn">
                            Get Started
                        </a>

                    @endauth


                    {{-- MOBILE BUTTON --}}
                    <button type="button"
                            class="cn-mobile-toggle"
                            id="cnMobileToggle"
                            aria-controls="cnMobilePanel"
                            aria-expanded="false">

                        <span></span>
                        <span></span>
                        <span></span>

                    </button>

                </div>

            </div>

        </div>
    </div>


    {{-- ========================================================
        EXPLORE OFFCANVAS
        ======================================================== --}}

    <div class="cn-explore-overlay" id="cnExploreOverlay"></div>

    <aside class="cn-explore-panel"
           id="cnExplorePanel"
           aria-hidden="true">

        <div class="cn-explore-header">

            <div>
                <span class="cn-panel-label">
                    EXPLORE
                </span>

                <h5>Find a Service</h5>

                <p>
                    Browse services by category and location.
                </p>
            </div>

            <button type="button"
                    class="cn-panel-close"
                    id="cnExploreClose">

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        <div class="cn-explore-content">

            {{-- ALL CATEGORIES --}}
            <a href="{{ route('home.service_categories') }}"
               class="cn-explore-all">

                <span class="cn-explore-all-icon">
                    <i class="bi bi-grid"></i>
                </span>

                <span>
                    <strong>All Service Categories</strong>
                    <small>
                        Browse everything available
                    </small>
                </span>

                <i class="bi bi-arrow-right"></i>

            </a>


            {{-- REAL CATEGORIES --}}
            <div class="cn-category-list">

                @forelse($exploreCategories as $category)

                    <div class="cn-category-item">

                        <button type="button"
                                class="cn-category-trigger"
                                data-category-toggle>

                            <span class="cn-category-icon">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}"
                                         alt="{{ $category->name }}">
                                @else
                                    <i class="bi bi-grid"></i>
                                @endif
                            </span>

                            <span class="cn-category-content">

                                <strong>
                                    {{ $category->name }}
                                </strong>

                                <small>
                                    {{ $category->services_count }}
                                    {{ Str::plural('service', $category->services_count) }}
                                </small>

                            </span>

                            @if($category->subcategories->count())
                                <i class="bi bi-chevron-right cn-category-arrow"></i>
                            @endif

                        </button>


                        {{-- SUBCATEGORIES --}}
                        @if($category->subcategories->count())

                            <div class="cn-category-submenu">

                                <div class="cn-submenu-heading">

                                    <a href="{{ route('home.service_by_category', [
                                        'category_slug' => $category->slug
                                    ]) }}">

                                        View all {{ $category->name }}

                                    </a>

                                    <i class="bi bi-arrow-up-right"></i>

                                </div>


                                @foreach($category->subcategories as $subcategory)

                                    @php
                                        $locations = $getLocations($subcategory);
                                    @endphp

                                    <div class="cn-subcategory-item">

                                        <button type="button"
                                                class="cn-subcategory-trigger"
                                                data-subcategory-toggle>

                                            <span>
                                                {{ $subcategory->name }}
                                            </span>

                                            @if($locations->count())
                                                <i class="bi bi-chevron-right"></i>
                                            @endif

                                        </button>


                                        {{-- LOCATIONS --}}
                                        @if($locations->count())

                                            <div class="cn-location-menu">

                                                <a href="{{ route('home.service_by_category', [
                                                    'category_slug' => $category->slug,
                                                    'scategory_slug' => $subcategory->slug
                                                ]) }}"
                                                   class="cn-view-subcategory">

                                                    <i class="bi bi-grid"></i>
                                                    All {{ $subcategory->name }}

                                                </a>

                                                @foreach($locations as $location)

                                                    <a href="{{ route('home.service_location', [
                                                        'service_location' => Str::slug($location)
                                                    ]) }}">

                                                        <i class="bi bi-geo-alt"></i>

                                                        {{ $location }}

                                                    </a>

                                                @endforeach

                                            </div>

                                        @else

                                            <a href="{{ route('home.service_by_category', [
                                                'category_slug' => $category->slug,
                                                'scategory_slug' => $subcategory->slug
                                            ]) }}"
                                               class="cn-subcategory-direct">

                                                <i class="bi bi-arrow-right"></i>

                                            </a>

                                        @endif

                                    </div>

                                @endforeach

                            </div>

                        @endif

                    </div>

                @empty

                    <div class="cn-empty-category">

                        <i class="bi bi-grid"></i>

                        <strong>No categories available</strong>

                        <p>
                            Service categories will appear here.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </aside>


    {{-- ========================================================
        MOBILE NAVIGATION
        ======================================================== --}}

    <div class="cn-mobile-overlay" id="cnMobileOverlay"></div>

    <aside class="cn-mobile-panel"
           id="cnMobilePanel"
           aria-hidden="true">

        <div class="cn-mobile-header">

            <a href="{{ route('home') }}" class="cn-mobile-brand">

                <span class="cn-brand-mark">
                    <i class="bi bi-link-45deg"></i>
                </span>

                <strong>Connector</strong>

            </a>

            <button type="button"
                    class="cn-mobile-close"
                    id="cnMobileClose">

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        {{-- MOBILE SEARCH --}}
        <form action="{{ route('services.search') }}"
              method="GET"
              class="cn-mobile-search">

            <i class="bi bi-search"></i>

            <input
                type="search"
                name="query"
                value="{{ request('query') }}"
                placeholder="Search services..."
            >

            <button type="submit">
                <i class="bi bi-arrow-right"></i>
            </button>

        </form>


        <nav class="cn-mobile-nav">

            <a href="{{ route('home') }}"
               class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="bi bi-house"></i>
                <span>Home</span>
            </a>


            <a href="{{ route('home.service_categories') }}"
               class="{{ request()->routeIs('home.service_categories') ? 'active' : '' }}">
                <i class="bi bi-grid"></i>
                <span>All Categories</span>
            </a>


            <a href="{{ route('home.services') }}">
                <i class="bi bi-briefcase"></i>
                <span>All Services</span>
            </a>


            {{-- MOBILE CATEGORIES --}}
            <div class="cn-mobile-section">

                <button type="button"
                        class="cn-mobile-section-trigger"
                        data-mobile-section>

                    <span>
                        <i class="bi bi-grid-3x3-gap"></i>
                        Service Categories
                    </span>

                    <i class="bi bi-chevron-down"></i>

                </button>


                <div class="cn-mobile-section-content">

                    @foreach($exploreCategories as $category)

                        <div class="cn-mobile-category">

                            <button type="button"
                                    class="cn-mobile-category-trigger"
                                    data-mobile-category>

                                <span>
                                    {{ $category->name }}
                                </span>

                                @if($category->subcategories->count())
                                    <i class="bi bi-plus"></i>
                                @else
                                    <i class="bi bi-arrow-right"></i>
                                @endif

                            </button>


                            @if($category->subcategories->count())

                                <div class="cn-mobile-subcategories">

                                    <a href="{{ route('home.service_by_category', [
                                        'category_slug' => $category->slug
                                    ]) }}"
                                       class="cn-mobile-view-all">

                                        All {{ $category->name }}

                                    </a>


                                    @foreach($category->subcategories as $subcategory)

                                        <a href="{{ route('home.service_by_category', [
                                            'category_slug' => $category->slug,
                                            'scategory_slug' => $subcategory->slug
                                        ]) }}">

                                            {{ $subcategory->name }}

                                            <i class="bi bi-arrow-right"></i>

                                        </a>

                                    @endforeach

                                </div>

                            @else

                                <a href="{{ route('home.service_by_category', [
                                    'category_slug' => $category->slug
                                ]) }}"
                                   class="cn-mobile-category-direct">

                                    View services
                                </a>

                            @endif

                        </div>

                    @endforeach

                </div>

            </div>


            {{-- COMPANY --}}
            <div class="cn-mobile-section">

                <button type="button"
                        class="cn-mobile-section-trigger"
                        data-mobile-section>

                    <span>
                        <i class="bi bi-building"></i>
                        Company
                    </span>

                    <i class="bi bi-chevron-down"></i>

                </button>


                <div class="cn-mobile-section-content cn-mobile-company">

                    <a href="{{ route('about') }}">
                        About Us
                    </a>

                    <a href="{{ route('faq') }}">
                        FAQ
                    </a>

                    <a href="{{ route('home.jobs') }}">
                        Jobs
                    </a>

                    <a href="{{ route('home.blogs') }}">
                        Blog
                    </a>

                    <a href="{{ route('home.contact') }}">
                        Contact
                    </a>

                    <a href="{{ route('policy') }}">
                        Privacy Policy
                    </a>

                </div>

            </div>

        </nav>


        {{-- MOBILE ACCOUNT --}}
        <div class="cn-mobile-account">

            @auth

                <div class="cn-mobile-user">

                    <span class="cn-avatar">
                        {{ $initials ?: 'U' }}
                    </span>

                    <div>
                        <strong>{{ $user->name }}</strong>

                        <small>
                            @if($role === 'ADM')
                                Administrator
                            @elseif($role === 'SVP')
                                Service Provider
                            @else
                                Customer
                            @endif
                        </small>
                    </div>

                </div>


                @if($role === 'ADM')

                    <a href="{{ route('admin.dashboard') }}"
                       class="cn-mobile-dashboard">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>

                @elseif($role === 'SVP')

                    <a href="{{ route('sprovider.dashboard') }}"
                       class="cn-mobile-dashboard">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>

                @else

                    <a href="{{ route('customer.dashboard') }}"
                       class="cn-mobile-dashboard">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>

                @endif


                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                            class="cn-mobile-logout">

                        <i class="bi bi-box-arrow-right"></i>
                        Logout

                    </button>

                </form>

            @else

                <a href="{{ route('register') }}"
                   class="cn-mobile-register">

                    Get Started

                </a>

            @endauth

        </div>

    </aside>

</header>


{{-- ============================================================
    HEADER CSS
    ============================================================ --}}

<style>

:root {
    --cn-primary: #6B9080;
    --cn-primary-dark: #254035;
    --cn-primary-soft: #edf5f1;
    --cn-white: #ffffff;
    --cn-text: #18231f;
    --cn-muted: #718078;
    --cn-border: #e7ece9;
    --cn-shadow: 0 15px 45px rgba(37, 64, 53, .13);
}


/* ============================================================
   HEADER
   ============================================================ */

.cn-header {
    position: relative;
    z-index: 1100;
    width: 100%;
}

.cn-header-main {
    height: 78px;
    background: var(--cn-primary-dark);
    transition: all .25s ease;
}

.cn-header.scrolled .cn-header-main {
    background: rgba(255, 255, 255, .97);
    box-shadow: 0 5px 25px rgba(0,0,0,.07);
    backdrop-filter: blur(12px);
}

.cn-header-inner {
    height: 78px;
    display: flex;
    align-items: center;
    gap: 26px;
}


/* ============================================================
   BRAND
   ============================================================ */

.cn-brand {
    display: flex;
    align-items: center;
    gap: 11px;
    color: #fff;
    text-decoration: none;
    flex-shrink: 0;
}

.cn-brand:hover {
    color: #fff;
}

.cn-brand-mark {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: var(--cn-primary);
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.cn-brand-text {
    display: flex;
    flex-direction: column;
    line-height: 1.1;
}

.cn-brand-text strong {
    font-size: 20px;
    font-weight: 700;
    letter-spacing: -.3px;
}

.cn-brand-text small {
    font-size: 9px;
    opacity: .65;
    margin-top: 4px;
}


/* ============================================================
   DESKTOP NAV
   ============================================================ */

.cn-desktop-nav {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-left: 8px;
}

.cn-nav-link {
    border: 0;
    background: transparent;
    color: rgba(255,255,255,.78);
    text-decoration: none;
    padding: 11px 12px;
    border-radius: 9px;
    font-size: 14px;
    font-weight: 500;
    transition: .2s ease;
}

.cn-nav-link:hover,
.cn-nav-link.active {
    color: #fff;
    background: rgba(255,255,255,.09);
}

.cn-header.scrolled .cn-nav-link {
    color: #52605a;
}

.cn-header.scrolled .cn-nav-link:hover,
.cn-header.scrolled .cn-nav-link.active {
    color: var(--cn-primary-dark);
    background: var(--cn-primary-soft);
}

.cn-dropdown-trigger {
    display: flex;
    align-items: center;
    gap: 6px;
}

.cn-dropdown-trigger i {
    font-size: 10px;
}


/* ============================================================
   COMPANY DROPDOWN
   ============================================================ */

.cn-nav-dropdown {
    position: relative;
}

.cn-dropdown-menu {
    position: absolute;
    top: calc(100% + 13px);
    left: 0;
    width: 275px;
    padding: 8px;
    background: #fff;
    border: 1px solid var(--cn-border);
    border-radius: 15px;
    box-shadow: var(--cn-shadow);
    opacity: 0;
    visibility: hidden;
    transform: translateY(8px);
    transition: .2s ease;
}

.cn-nav-dropdown:hover .cn-dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.cn-dropdown-menu > a {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 10px;
    color: var(--cn-text);
    text-decoration: none;
    border-radius: 10px;
}

.cn-dropdown-menu > a:hover {
    background: var(--cn-primary-soft);
}

.cn-dropdown-menu > a > span:last-child {
    display: flex;
    flex-direction: column;
}

.cn-dropdown-menu strong {
    font-size: 13px;
}

.cn-dropdown-menu small {
    color: var(--cn-muted);
    font-size: 11px;
    margin-top: 2px;
}

.cn-dropdown-icon {
    width: 35px;
    height: 35px;
    background: var(--cn-primary-soft);
    color: var(--cn-primary-dark);
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cn-dropdown-divider {
    height: 1px;
    background: var(--cn-border);
    margin: 6px 4px;
}


/* ============================================================
   SEARCH
   ============================================================ */

.cn-header-search {
    margin-left: auto;
    width: min(300px, 25vw);
    height: 43px;
    background: rgba(255,255,255,.09);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 11px;
    display: flex;
    align-items: center;
    padding-left: 13px;
    transition: .2s ease;
}

.cn-header-search > i {
    color: rgba(255,255,255,.55);
    font-size: 14px;
}

.cn-header-search input {
    min-width: 0;
    flex: 1;
    border: 0;
    outline: 0;
    background: transparent;
    color: #fff;
    padding: 0 10px;
    font-size: 13px;
}

.cn-header-search input::placeholder {
    color: rgba(255,255,255,.55);
}

.cn-header-search button {
    border: 0;
    background: var(--cn-primary);
    color: #fff;
    height: 35px;
    margin-right: 4px;
    padding: 0 13px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}

.cn-header.scrolled .cn-header-search {
    background: #f5f8f6;
    border-color: var(--cn-border);
}

.cn-header.scrolled .cn-header-search > i {
    color: var(--cn-muted);
}

.cn-header.scrolled .cn-header-search input {
    color: var(--cn-text);
}

.cn-header.scrolled .cn-header-search input::placeholder {
    color: #8c9993;
}


/* ============================================================
   ACTIONS
   ============================================================ */

.cn-header-actions {
    display: flex;
    align-items: center;
    gap: 9px;
}

.cn-explore-btn {
    height: 43px;
    padding: 0 13px;
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1px solid rgba(255,255,255,.15);
    background: rgba(255,255,255,.07);
    color: #fff;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
}

.cn-explore-btn:hover {
    background: rgba(255,255,255,.13);
}

.cn-header.scrolled .cn-explore-btn {
    color: var(--cn-primary-dark);
    background: var(--cn-primary-soft);
    border-color: transparent;
}

.cn-explore-icon {
    display: flex;
}


/* ============================================================
   REGISTER
   ============================================================ */

.cn-register-btn {
    height: 43px;
    padding: 0 16px;
    border-radius: 10px;
    background: var(--cn-primary);
    color: #fff;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    font-size: 13px;
    font-weight: 600;
}

.cn-register-btn:hover {
    color: #fff;
    background: #5d8272;
}


/* ============================================================
   USER
   ============================================================ */

.cn-user-dropdown {
    position: relative;
}

.cn-user-btn {
    border: 0;
    background: transparent;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 4px;
}

.cn-header.scrolled .cn-user-btn {
    color: var(--cn-text);
}

.cn-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: var(--cn-primary);
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
}

.cn-avatar-large {
    width: 43px;
    height: 43px;
}

.cn-user-info {
    flex-direction: column;
    align-items: flex-start;
    line-height: 1.15;
}

.cn-user-info strong {
    font-size: 12px;
}

.cn-user-info small {
    font-size: 10px;
    opacity: .65;
    margin-top: 3px;
}

.cn-user-menu {
    position: absolute;
    top: calc(100% + 12px);
    right: 0;
    width: 260px;
    background: #fff;
    border: 1px solid var(--cn-border);
    border-radius: 15px;
    box-shadow: var(--cn-shadow);
    padding: 8px;
    display: none;
}

.cn-user-menu.show {
    display: block;
}

.cn-user-menu-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px;
}

.cn-user-menu-header > div {
    min-width: 0;
    display: flex;
    flex-direction: column;
}

.cn-user-menu-header strong {
    font-size: 13px;
}

.cn-user-menu-header small {
    color: var(--cn-muted);
    font-size: 10px;
    margin-top: 3px;
    overflow: hidden;
    text-overflow: ellipsis;
}

.cn-user-menu > a,
.cn-user-menu .cn-logout {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    border: 0;
    background: transparent;
    color: var(--cn-text);
    text-decoration: none;
    border-radius: 9px;
    font-size: 13px;
    text-align: left;
}

.cn-user-menu > a:hover,
.cn-user-menu .cn-logout:hover {
    background: var(--cn-primary-soft);
}

.cn-user-menu .cn-logout {
    color: #b44343;
}


/* ============================================================
   EXPLORE PANEL
   ============================================================ */

.cn-explore-overlay,
.cn-mobile-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 25, 21, .42);
    backdrop-filter: blur(2px);
    opacity: 0;
    visibility: hidden;
    transition: .25s ease;
    z-index: 1090;
}

.cn-explore-overlay.show,
.cn-mobile-overlay.show {
    opacity: 1;
    visibility: visible;
}

.cn-explore-panel {
    position: fixed;
    top: 0;
    left: 0;
    width: 410px;
    max-width: 92vw;
    height: 100vh;
    background: #fff;
    z-index: 1110;
    transform: translateX(-100%);
    transition: transform .3s cubic-bezier(.4,0,.2,1);
    box-shadow: 20px 0 50px rgba(0,0,0,.12);
    overflow: hidden;
}

.cn-explore-panel.show {
    transform: translateX(0);
}

.cn-explore-header {
    padding: 28px 25px 22px;
    border-bottom: 1px solid var(--cn-border);
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.cn-panel-label {
    color: var(--cn-primary);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.5px;
}

.cn-explore-header h5 {
    margin: 5px 0;
    color: var(--cn-primary-dark);
    font-size: 20px;
}

.cn-explore-header p {
    margin: 0;
    color: var(--cn-muted);
    font-size: 12px;
}

.cn-panel-close,
.cn-mobile-close {
    width: 36px;
    height: 36px;
    flex-shrink: 0;
    border: 1px solid var(--cn-border);
    background: #fff;
    color: var(--cn-text);
    border-radius: 10px;
}

.cn-panel-close:hover,
.cn-mobile-close:hover {
    background: var(--cn-primary-soft);
    color: var(--cn-primary-dark);
}

.cn-explore-content {
    height: calc(100vh - 133px);
    overflow-y: auto;
    padding: 15px;
}

.cn-explore-all {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 13px;
    margin-bottom: 12px;
    border: 1px solid var(--cn-border);
    border-radius: 12px;
    color: var(--cn-text);
    text-decoration: none;
}

.cn-explore-all:hover {
    background: var(--cn-primary-soft);
    border-color: #d5e4dd;
}

.cn-explore-all-icon {
    width: 37px;
    height: 37px;
    background: var(--cn-primary-soft);
    color: var(--cn-primary-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 9px;
}

.cn-explore-all span:nth-child(2) {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.cn-explore-all strong {
    font-size: 12px;
}

.cn-explore-all small {
    color: var(--cn-muted);
    font-size: 10px;
    margin-top: 2px;
}

.cn-explore-all > i {
    color: var(--cn-primary);
}


/* ============================================================
   CATEGORY
   ============================================================ */

.cn-category-item {
    border-bottom: 1px solid var(--cn-border);
}

.cn-category-trigger {
    width: 100%;
    border: 0;
    background: #fff;
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 12px 8px;
    text-align: left;
}

.cn-category-trigger:hover {
    background: #fafcfb;
}

.cn-category-icon {
    width: 42px;
    height: 42px;
    border-radius: 11px;
    background: var(--cn-primary-soft);
    color: var(--cn-primary-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
}

.cn-category-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cn-category-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.cn-category-content strong {
    color: var(--cn-text);
    font-size: 13px;
}

.cn-category-content small {
    color: var(--cn-muted);
    font-size: 10px;
    margin-top: 3px;
}

.cn-category-arrow {
    color: #9ba8a2;
    font-size: 12px;
    transition: .2s ease;
}

.cn-category-item.open .cn-category-arrow {
    transform: rotate(90deg);
    color: var(--cn-primary);
}


/* ============================================================
   SUBCATEGORY
   ============================================================ */

.cn-category-submenu {
    display: none;
    padding: 0 8px 10px 61px;
}

.cn-category-item.open .cn-category-submenu {
    display: block;
}

.cn-submenu-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 6px 0 9px;
}

.cn-submenu-heading a {
    color: var(--cn-primary);
    text-decoration: none;
    font-size: 11px;
    font-weight: 700;
}

.cn-submenu-heading i {
    color: var(--cn-primary);
    font-size: 10px;
}

.cn-subcategory-item {
    position: relative;
}

.cn-subcategory-trigger {
    width: 100%;
    border: 0;
    background: transparent;
    color: #4f5e57;
    padding: 8px 4px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    text-align: left;
}

.cn-subcategory-trigger:hover {
    color: var(--cn-primary-dark);
}

.cn-subcategory-trigger i {
    font-size: 9px;
}

.cn-location-menu {
    display: none;
    padding: 3px 0 7px 9px;
}

.cn-subcategory-item.open .cn-location-menu {
    display: block;
}

.cn-location-menu a {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 6px 4px;
    color: var(--cn-muted);
    text-decoration: none;
    font-size: 11px;
}

.cn-location-menu a:hover {
    color: var(--cn-primary-dark);
}

.cn-location-menu a i {
    color: var(--cn-primary);
}

.cn-location-menu .cn-view-subcategory {
    color: var(--cn-primary-dark);
    font-weight: 600;
    border-bottom: 1px solid var(--cn-border);
    margin-bottom: 2px;
}

.cn-subcategory-direct {
    display: flex;
    justify-content: flex-end;
    color: var(--cn-primary);
    font-size: 11px;
    padding: 5px;
}

.cn-empty-category {
    text-align: center;
    padding: 45px 20px;
    color: var(--cn-muted);
}

.cn-empty-category > i {
    font-size: 32px;
    color: var(--cn-primary);
}

.cn-empty-category strong {
    display: block;
    color: var(--cn-text);
    margin-top: 12px;
}

.cn-empty-category p {
    font-size: 12px;
}


/* ============================================================
   MOBILE TOGGLE
   ============================================================ */

.cn-mobile-toggle {
    display: none;
    width: 42px;
    height: 42px;
    border: 1px solid rgba(255,255,255,.15);
    background: rgba(255,255,255,.07);
    border-radius: 10px;
    padding: 10px;
}

.cn-mobile-toggle span {
    display: block;
    height: 2px;
    background: #fff;
    margin: 4px 0;
    border-radius: 5px;
}

.cn-header.scrolled .cn-mobile-toggle {
    border-color: var(--cn-border);
    background: var(--cn-primary-soft);
}

.cn-header.scrolled .cn-mobile-toggle span {
    background: var(--cn-primary-dark);
}


/* ============================================================
   MOBILE PANEL
   ============================================================ */

.cn-mobile-panel {
    position: fixed;
    top: 0;
    right: 0;
    width: 390px;
    max-width: 92vw;
    height: 100vh;
    background: #fff;
    z-index: 1110;
    transform: translateX(100%);
    transition: transform .3s cubic-bezier(.4,0,.2,1);
    display: flex;
    flex-direction: column;
    box-shadow: -20px 0 50px rgba(0,0,0,.12);
}

.cn-mobile-panel.show {
    transform: translateX(0);
}

.cn-mobile-header {
    min-height: 74px;
    padding: 15px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid var(--cn-border);
}

.cn-mobile-brand {
    display: flex;
    align-items: center;
    gap: 9px;
    color: var(--cn-primary-dark);
    text-decoration: none;
}

.cn-mobile-brand strong {
    font-size: 18px;
}

.cn-mobile-search {
    margin: 15px;
    height: 45px;
    border: 1px solid var(--cn-border);
    border-radius: 11px;
    display: flex;
    align-items: center;
    padding-left: 12px;
}

.cn-mobile-search > i {
    color: var(--cn-muted);
}

.cn-mobile-search input {
    flex: 1;
    min-width: 0;
    border: 0;
    outline: 0;
    padding: 0 9px;
    font-size: 13px;
}

.cn-mobile-search button {
    width: 37px;
    height: 37px;
    margin-right: 4px;
    border: 0;
    border-radius: 8px;
    background: var(--cn-primary);
    color: #fff;
}

.cn-mobile-nav {
    flex: 1;
    overflow-y: auto;
    padding: 0 15px 20px;
}

.cn-mobile-nav > a {
    display: flex;
    align-items: center;
    gap: 12px;
    min-height: 47px;
    padding: 0 11px;
    color: var(--cn-text);
    text-decoration: none;
    border-radius: 9px;
    font-size: 13px;
}

.cn-mobile-nav > a:hover,
.cn-mobile-nav > a.active {
    color: var(--cn-primary-dark);
    background: var(--cn-primary-soft);
}

.cn-mobile-nav > a i {
    width: 20px;
    color: var(--cn-primary);
}


/* ============================================================
   MOBILE SECTIONS
   ============================================================ */

.cn-mobile-section {
    margin-top: 5px;
    border-top: 1px solid var(--cn-border);
}

.cn-mobile-section-trigger {
    width: 100%;
    border: 0;
    background: transparent;
    min-height: 48px;
    padding: 0 11px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: var(--cn-text);
    font-size: 13px;
    font-weight: 600;
}

.cn-mobile-section-trigger span {
    display: flex;
    align-items: center;
    gap: 12px;
}

.cn-mobile-section-trigger span i {
    width: 20px;
    color: var(--cn-primary);
}

.cn-mobile-section.open
.cn-mobile-section-trigger > i {
    transform: rotate(180deg);
}

.cn-mobile-section-content {
    display: none;
    padding: 0 0 8px;
}

.cn-mobile-section.open .cn-mobile-section-content {
    display: block;
}

.cn-mobile-category {
    border-top: 1px solid #f0f3f1;
}

.cn-mobile-category-trigger {
    width: 100%;
    min-height: 42px;
    padding: 0 12px 0 32px;
    border: 0;
    background: transparent;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #536159;
    font-size: 12px;
    text-align: left;
}

.cn-mobile-category-trigger:hover {
    color: var(--cn-primary-dark);
}

.cn-mobile-category-trigger i {
    color: var(--cn-primary);
}

.cn-mobile-category.open
.cn-mobile-category-trigger i {
    transform: rotate(45deg);
}

.cn-mobile-subcategories {
    display: none;
    padding: 0 0 7px 45px;
}

.cn-mobile-category.open .cn-mobile-subcategories {
    display: block;
}

.cn-mobile-subcategories a,
.cn-mobile-category-direct {
    min-height: 34px;
    padding: 0 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: var(--cn-muted);
    text-decoration: none;
    font-size: 11px;
}

.cn-mobile-subcategories a:hover {
    color: var(--cn-primary-dark);
}

.cn-mobile-subcategories .cn-mobile-view-all {
    color: var(--cn-primary-dark);
    font-weight: 700;
}

.cn-mobile-category-direct {
    padding-left: 45px;
    color: var(--cn-primary);
}


/* ============================================================
   MOBILE COMPANY
   ============================================================ */

.cn-mobile-company {
    padding-left: 32px;
}

.cn-mobile-company a {
    display: block;
    padding: 8px 10px;
    color: var(--cn-muted);
    text-decoration: none;
    font-size: 12px;
}

.cn-mobile-company a:hover {
    color: var(--cn-primary-dark);
}


/* ============================================================
   MOBILE ACCOUNT
   ============================================================ */

.cn-mobile-account {
    border-top: 1px solid var(--cn-border);
    padding: 15px;
    background: #fbfcfb;
}

.cn-mobile-user {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
}

.cn-mobile-user > div {
    display: flex;
    flex-direction: column;
}

.cn-mobile-user strong {
    color: var(--cn-text);
    font-size: 13px;
}

.cn-mobile-user small {
    color: var(--cn-muted);
    font-size: 10px;
    margin-top: 2px;
}

.cn-mobile-dashboard,
.cn-mobile-logout {
    display: flex;
    align-items: center;
    gap: 9px;
    width: 100%;
    min-height: 39px;
    padding: 0 10px;
    border-radius: 8px;
    text-decoration: none;
    border: 0;
    background: transparent;
    color: var(--cn-text);
    font-size: 12px;
}

.cn-mobile-dashboard:hover {
    background: var(--cn-primary-soft);
}

.cn-mobile-logout {
    color: #b44343;
}

.cn-mobile-register {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 43px;
    background: var(--cn-primary);
    color: #fff;
    text-decoration: none;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 600;
}


/* ============================================================
   RESPONSIVE
   ============================================================ */

@media (max-width: 1199.98px) {

    .cn-header-inner {
        gap: 14px;
    }

    .cn-desktop-nav {
        margin-left: 0;
    }

    .cn-nav-link {
        padding-left: 8px;
        padding-right: 8px;
    }

    .cn-header-search {
        width: 220px;
    }

}

@media (max-width: 991.98px) {

    .cn-desktop-nav,
    .cn-header-search {
        display: none;
    }

    .cn-header-inner {
        justify-content: space-between;
    }

    .cn-brand {
        margin-right: auto;
    }

    .cn-mobile-toggle {
        display: block;
    }

    .cn-explore-btn {
        display: none;
    }

    .cn-register-btn {
        display: none;
    }

}

@media (max-width: 575.98px) {

    .cn-header-main,
    .cn-header-inner {
        height: 68px;
    }

    .cn-brand-mark {
        width: 37px;
        height: 37px;
    }

    .cn-brand-text strong {
        font-size: 18px;
    }

    .cn-brand-text small {
        display: none;
    }

    .cn-user-info,
    .cn-user-btn > i {
        display: none !important;
    }

    .cn-avatar {
        width: 36px;
        height: 36px;
    }

    .cn-mobile-panel {
        width: 100%;
        max-width: 100%;
    }

}


/* ============================================================
   LOCK BODY WHEN MENU IS OPEN
   ============================================================ */

body.cn-menu-open {
    overflow: hidden;
}

</style>


{{-- ============================================================
    HEADER JAVASCRIPT
    ============================================================ --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const header = document.getElementById('connectorHeader');

    const exploreBtn = document.getElementById('cnExploreBtn');
    const explorePanel = document.getElementById('cnExplorePanel');
    const exploreOverlay = document.getElementById('cnExploreOverlay');
    const exploreClose = document.getElementById('cnExploreClose');

    const mobileToggle = document.getElementById('cnMobileToggle');
    const mobilePanel = document.getElementById('cnMobilePanel');
    const mobileOverlay = document.getElementById('cnMobileOverlay');
    const mobileClose = document.getElementById('cnMobileClose');

    const userBtn = document.getElementById('cnUserBtn');
    const userMenu = document.getElementById('cnUserMenu');


    /*
    |--------------------------------------------------------------------------
    | Header scroll
    |--------------------------------------------------------------------------
    */

    function updateHeader() {

        if (window.scrollY > 25) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

    }

    updateHeader();

    window.addEventListener('scroll', updateHeader, {
        passive: true
    });


    /*
    |--------------------------------------------------------------------------
    | Body lock
    |--------------------------------------------------------------------------
    */

    function lockBody() {
        document.body.classList.add('cn-menu-open');
    }

    function unlockBody() {

        if (
            !explorePanel?.classList.contains('show') &&
            !mobilePanel?.classList.contains('show')
        ) {
            document.body.classList.remove('cn-menu-open');
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Explore
    |--------------------------------------------------------------------------
    */

    function openExplore() {

        if (!explorePanel) return;

        explorePanel.classList.add('show');
        exploreOverlay.classList.add('show');

        explorePanel.setAttribute('aria-hidden', 'false');

        exploreBtn?.setAttribute('aria-expanded', 'true');

        lockBody();

    }


    function closeExplore() {

        if (!explorePanel) return;

        explorePanel.classList.remove('show');
        exploreOverlay.classList.remove('show');

        explorePanel.setAttribute('aria-hidden', 'true');

        exploreBtn?.setAttribute('aria-expanded', 'false');

        unlockBody();

    }


    exploreBtn?.addEventListener('click', function (event) {

        event.preventDefault();

        if (explorePanel.classList.contains('show')) {
            closeExplore();
        } else {
            closeMobile();
            openExplore();
        }

    });


    exploreClose?.addEventListener('click', closeExplore);
    exploreOverlay?.addEventListener('click', closeExplore);


    /*
    |--------------------------------------------------------------------------
    | Mobile menu
    |--------------------------------------------------------------------------
    */

    function openMobile() {

        if (!mobilePanel) return;

        mobilePanel.classList.add('show');
        mobileOverlay.classList.add('show');

        mobilePanel.setAttribute('aria-hidden', 'false');

        mobileToggle?.setAttribute('aria-expanded', 'true');

        lockBody();

    }


    function closeMobile() {

        if (!mobilePanel) return;

        mobilePanel.classList.remove('show');
        mobileOverlay.classList.remove('show');

        mobilePanel.setAttribute('aria-hidden', 'true');

        mobileToggle?.setAttribute('aria-expanded', 'false');

        unlockBody();

    }


    mobileToggle?.addEventListener('click', function () {

        if (mobilePanel.classList.contains('show')) {
            closeMobile();
        } else {
            closeExplore();
            openMobile();
        }

    });


    mobileClose?.addEventListener('click', closeMobile);
    mobileOverlay?.addEventListener('click', closeMobile);


    /*
    |--------------------------------------------------------------------------
    | Escape key
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') return;

        closeExplore();
        closeMobile();

        if (userMenu) {
            userMenu.classList.remove('show');
        }

    });


    /*
    |--------------------------------------------------------------------------
    | User menu
    |--------------------------------------------------------------------------
    */

    userBtn?.addEventListener('click', function (event) {

        event.stopPropagation();

        userMenu?.classList.toggle('show');

    });


    document.addEventListener('click', function (event) {

        if (
            userMenu &&
            !userMenu.contains(event.target) &&
            !userBtn?.contains(event.target)
        ) {
            userMenu.classList.remove('show');
        }

    });


    /*
    |--------------------------------------------------------------------------
    | Desktop category accordion
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('[data-category-toggle]').forEach(function (button) {

        button.addEventListener('click', function () {

            const item = button.closest('.cn-category-item');

            if (!item) return;

            const wasOpen = item.classList.contains('open');

            document
                .querySelectorAll('.cn-category-item.open')
                .forEach(function (openItem) {

                    if (openItem !== item) {
                        openItem.classList.remove('open');

                        openItem
                            .querySelectorAll('.cn-subcategory-item.open')
                            .forEach(function (subItem) {
                                subItem.classList.remove('open');
                            });
                    }

                });

            item.classList.toggle('open', !wasOpen);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Desktop subcategory accordion
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('[data-subcategory-toggle]').forEach(function (button) {

        button.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            const item = button.closest('.cn-subcategory-item');

            if (!item) return;

            const wasOpen = item.classList.contains('open');

            item
                .closest('.cn-category-submenu')
                ?.querySelectorAll('.cn-subcategory-item.open')
                .forEach(function (openItem) {

                    if (openItem !== item) {
                        openItem.classList.remove('open');
                    }

                });

            item.classList.toggle('open', !wasOpen);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Mobile main sections
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('[data-mobile-section]').forEach(function (button) {

        button.addEventListener('click', function () {

            const section = button.closest('.cn-mobile-section');

            if (!section) return;

            const wasOpen = section.classList.contains('open');

            document
                .querySelectorAll('.cn-mobile-section.open')
                .forEach(function (openSection) {

                    if (openSection !== section) {
                        openSection.classList.remove('open');
                    }

                });

            section.classList.toggle('open', !wasOpen);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Mobile categories
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('[data-mobile-category]').forEach(function (button) {

        button.addEventListener('click', function () {

            const category = button.closest('.cn-mobile-category');

            if (!category) return;

            const wasOpen = category.classList.contains('open');

            category
                .parentElement
                ?.querySelectorAll('.cn-mobile-category.open')
                .forEach(function (openCategory) {

                    if (openCategory !== category) {
                        openCategory.classList.remove('open');
                    }

                });

            category.classList.toggle('open', !wasOpen);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Close mobile menu when clicking a link
    |--------------------------------------------------------------------------
    */

    mobilePanel?.querySelectorAll('a').forEach(function (link) {

        link.addEventListener('click', function () {
            closeMobile();
        });

    });


    /*
    |--------------------------------------------------------------------------
    | Resize
    |--------------------------------------------------------------------------
    */

    window.addEventListener('resize', function () {

        if (window.innerWidth >= 992) {
            closeMobile();
        }

    });

});
</script>