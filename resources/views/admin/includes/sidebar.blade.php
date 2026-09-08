@php
    $serviceCategoryActive = request()->routeIs(
        'admin.service_categories',
        'admin.sub_category'
    );

    $servicesActive = request()->routeIs(
        'admin.all_services',
        'admin.create_service'
    );

    $contentActive = request()->routeIs(
        'admin.slider',
        'admin.blogs',
        'admin.add_blog',
        'admin.partners'
    );

    $communityActive = request()->routeIs(
        'admin.service_providers',
        'admin.users',
        'admin.ProviderFeedback',
        'admin.ProviderRatings',
        'admin.newsletterSubscriptions.index',
        'admin.messages',
        'admin.messageDetail'
    );

    $marketplaceActive = request()->routeIs(
        'admin.bookings',
        'admin.jobs'
    );
@endphp

<ul
    class="navbar-nav sidebar sidebar-dark accordion connector-sidebar"
    id="accordionSidebar"
>

    {{-- ==========================================
        BRAND
    =========================================== --}}
    <a
        class="sidebar-brand connector-sidebar-brand"
        href="{{ route('admin.dashboard') }}"
    >
        <div class="connector-brand-mark">
            <span>C</span>
        </div>

        <div class="connector-brand-content">
            <div class="connector-brand-name">
                Connector
            </div>

            <div class="connector-brand-subtitle">
                Admin Console
            </div>
        </div>

        <div class="connector-brand-status">
            <span></span>
        </div>
    </a>

    {{-- ==========================================
        SIDEBAR SEARCH
    =========================================== --}}
    <div class="connector-sidebar-search">
        <div class="connector-search-wrapper">
            <i class="fas fa-search"></i>

            <input
                type="text"
                id="sidebarSearch"
                placeholder="Search menu..."
                autocomplete="off"
            />

            <span class="connector-search-key">
                /
            </span>
        </div>
    </div>


    {{-- ==========================================
        MAIN
    =========================================== --}}
    <div class="connector-sidebar-section">
        <div class="connector-sidebar-label">
            Main
        </div>
    </div>

    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a
            class="nav-link connector-nav-link"
            href="{{ route('admin.dashboard') }}"
        >
            <span class="connector-nav-icon">
                <i class="fas fa-th-large"></i>
            </span>

            <span class="connector-nav-text">
                Dashboard
            </span>
        </a>
    </li>


    {{-- ==========================================
        MARKETPLACE
    =========================================== --}}
    <div class="connector-sidebar-section">
        <div class="connector-sidebar-label">
            Marketplace
        </div>
    </div>


    {{-- SERVICE CATEGORIES --}}
    <li class="nav-item {{ $serviceCategoryActive ? 'active' : '' }}">

        <a
            class="nav-link connector-nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseServiceCategories"
            aria-expanded="{{ $serviceCategoryActive ? 'true' : 'false' }}"
            aria-controls="collapseServiceCategories"
        >
            <span class="connector-nav-icon">
                <i class="fas fa-layer-group"></i>
            </span>

            <span class="connector-nav-text">
                Categories
            </span>

            <i class="fas fa-chevron-right connector-nav-arrow"></i>
        </a>

        <div
            id="collapseServiceCategories"
            class="collapse {{ $serviceCategoryActive ? 'show' : '' }}"
            data-parent="#accordionSidebar"
        >
            <div class="connector-submenu">

                <a
                    href="{{ route('admin.service_categories') }}"
                    class="connector-submenu-link {{ request()->routeIs('admin.service_categories') ? 'active' : '' }}"
                >
                    <span class="submenu-dot"></span>
                    <span>Service Categories</span>
                </a>

                <a
                    href="{{ route('admin.sub_category') }}"
                    class="connector-submenu-link {{ request()->routeIs('admin.sub_category') ? 'active' : '' }}"
                >
                    <span class="submenu-dot"></span>
                    <span>Sub Categories</span>
                </a>

            </div>
        </div>
    </li>


    {{-- SERVICES --}}
    <li class="nav-item {{ $servicesActive ? 'active' : '' }}">

        <a
            class="nav-link connector-nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseServices"
            aria-expanded="{{ $servicesActive ? 'true' : 'false' }}"
            aria-controls="collapseServices"
        >
            <span class="connector-nav-icon">
                <i class="fas fa-briefcase"></i>
            </span>

            <span class="connector-nav-text">
                Services
            </span>

            <i class="fas fa-chevron-right connector-nav-arrow"></i>
        </a>

        <div
            id="collapseServices"
            class="collapse {{ $servicesActive ? 'show' : '' }}"
            data-parent="#accordionSidebar"
        >
            <div class="connector-submenu">

                <a
                    href="{{ route('admin.all_services') }}"
                    class="connector-submenu-link {{ request()->routeIs('admin.all_services') ? 'active' : '' }}"
                >
                    <span class="submenu-dot"></span>
                    <span>All Services</span>
                </a>

                <a
                    href="{{ route('admin.create_service') }}"
                    class="connector-submenu-link {{ request()->routeIs('admin.create_service') ? 'active' : '' }}"
                >
                    <span class="submenu-dot"></span>
                    <span>Add Service</span>
                </a>

            </div>
        </div>
    </li>


    {{-- BOOKINGS --}}
    <li class="nav-item {{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
        <a
            class="nav-link connector-nav-link"
            href="{{ route('admin.bookings') }}"
        >
            <span class="connector-nav-icon">
                <i class="fas fa-calendar-check"></i>
            </span>

            <span class="connector-nav-text">
                Bookings
            </span>

            <span class="connector-nav-badge">
                Live
            </span>
        </a>
    </li>


    {{-- JOBS --}}
    <li class="nav-item {{ request()->routeIs('admin.jobs') ? 'active' : '' }}">
        <a
            class="nav-link connector-nav-link"
            href="{{ route('admin.jobs') }}"
        >
            <span class="connector-nav-icon">
                <i class="fas fa-clipboard-list"></i>
            </span>

            <span class="connector-nav-text">
                Job Postings
            </span>
        </a>
    </li>


    {{-- ==========================================
        PEOPLE & COMMUNITY
    =========================================== --}}
    <div class="connector-sidebar-section">
        <div class="connector-sidebar-label">
            People & Community
        </div>
    </div>


    {{-- SERVICE PROVIDERS --}}
    <li class="nav-item {{ request()->routeIs('admin.service_providers') ? 'active' : '' }}">
        <a
            class="nav-link connector-nav-link"
            href="{{ route('admin.service_providers') }}"
        >
            <span class="connector-nav-icon">
                <i class="fas fa-user-tie"></i>
            </span>

            <span class="connector-nav-text">
                Service Providers
            </span>
        </a>
    </li>


    {{-- USERS --}}
    <li class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
        <a
            class="nav-link connector-nav-link"
            href="{{ route('admin.users') }}"
        >
            <span class="connector-nav-icon">
                <i class="fas fa-users"></i>
            </span>

            <span class="connector-nav-text">
                Users
            </span>
        </a>
    </li>


    {{-- FEEDBACK & RATINGS --}}
    <li class="nav-item {{ request()->routeIs('admin.ProviderFeedback', 'admin.ProviderRatings') ? 'active' : '' }}">

        <a
            class="nav-link connector-nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseReviews"
            aria-expanded="{{ request()->routeIs('admin.ProviderFeedback', 'admin.ProviderRatings') ? 'true' : 'false' }}"
        >
            <span class="connector-nav-icon">
                <i class="fas fa-star"></i>
            </span>

            <span class="connector-nav-text">
                Reviews
            </span>

            <i class="fas fa-chevron-right connector-nav-arrow"></i>
        </a>

        <div
            id="collapseReviews"
            class="collapse {{ request()->routeIs('admin.ProviderFeedback', 'admin.ProviderRatings') ? 'show' : '' }}"
            data-parent="#accordionSidebar"
        >
            <div class="connector-submenu">

                <a
                    href="{{ route('admin.ProviderFeedback') }}"
                    class="connector-submenu-link {{ request()->routeIs('admin.ProviderFeedback') ? 'active' : '' }}"
                >
                    <span class="submenu-dot"></span>
                    <span>Provider Feedback</span>
                </a>

                <a
                    href="{{ route('admin.ProviderRatings') }}"
                    class="connector-submenu-link {{ request()->routeIs('admin.ProviderRatings') ? 'active' : '' }}"
                >
                    <span class="submenu-dot"></span>
                    <span>Provider Ratings</span>
                </a>

            </div>
        </div>
    </li>


    {{-- MESSAGES --}}
    <li class="nav-item {{ request()->routeIs('admin.messages', 'admin.messageDetail') ? 'active' : '' }}">
        <a
            class="nav-link connector-nav-link"
            href="{{ route('admin.messages') }}"
        >
            <span class="connector-nav-icon">
                <i class="fas fa-comments"></i>
            </span>

            <span class="connector-nav-text">
                Messages
            </span>
        </a>
    </li>


    {{-- NEWSLETTER --}}
    <li class="nav-item {{ request()->routeIs('admin.newsletterSubscriptions.index') ? 'active' : '' }}">
        <a
            class="nav-link connector-nav-link"
            href="{{ route('admin.newsletterSubscriptions.index') }}"
        >
            <span class="connector-nav-icon">
                <i class="fas fa-envelope-open-text"></i>
            </span>

            <span class="connector-nav-text">
                Newsletter
            </span>
        </a>
    </li>


    {{-- ==========================================
        CONTENT
    =========================================== --}}
    <div class="connector-sidebar-section">
        <div class="connector-sidebar-label">
            Content
        </div>
    </div>


    {{-- CONTENT MANAGEMENT --}}
    <li class="nav-item {{ $contentActive ? 'active' : '' }}">

        <a
            class="nav-link connector-nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseContent"
            aria-expanded="{{ $contentActive ? 'true' : 'false' }}"
        >
            <span class="connector-nav-icon">
                <i class="fas fa-edit"></i>
            </span>

            <span class="connector-nav-text">
                Website Content
            </span>

            <i class="fas fa-chevron-right connector-nav-arrow"></i>
        </a>

        <div
            id="collapseContent"
            class="collapse {{ $contentActive ? 'show' : '' }}"
            data-parent="#accordionSidebar"
        >
            <div class="connector-submenu">

                <a
                    href="{{ route('admin.slider') }}"
                    class="connector-submenu-link {{ request()->routeIs('admin.slider') ? 'active' : '' }}"
                >
                    <span class="submenu-dot"></span>
                    <span>Sliders</span>
                </a>

                <a
                    href="{{ route('admin.blogs') }}"
                    class="connector-submenu-link {{ request()->routeIs('admin.blogs') ? 'active' : '' }}"
                >
                    <span class="submenu-dot"></span>
                    <span>Blogs</span>
                </a>

                <a
                    href="{{ route('admin.add_blog') }}"
                    class="connector-submenu-link {{ request()->routeIs('admin.add_blog') ? 'active' : '' }}"
                >
                    <span class="submenu-dot"></span>
                    <span>Add Blog</span>
                </a>

                <a
                    href="{{ route('admin.partners') }}"
                    class="connector-submenu-link {{ request()->routeIs('admin.partners') ? 'active' : '' }}"
                >
                    <span class="submenu-dot"></span>
                    <span>Partners</span>
                </a>

            </div>
        </div>
    </li>


    {{-- ==========================================
        SYSTEM
    =========================================== --}}
    <div class="connector-sidebar-section">
        <div class="connector-sidebar-label">
            System
        </div>
    </div>


    <li class="nav-item">
        <a
            class="nav-link connector-nav-link"
            href="/"
            target="_blank"
        >
            <span class="connector-nav-icon">
                <i class="fas fa-external-link-alt"></i>
            </span>

            <span class="connector-nav-text">
                View Website
            </span>
        </a>
    </li>


    {{-- ==========================================
        SIDEBAR FOOTER
    =========================================== --}}
    <div class="connector-sidebar-footer">

        <div class="connector-help-card">

            <div class="connector-help-icon">
                <i class="fas fa-headset"></i>
            </div>

            <div class="connector-help-content">
                <strong>Need help?</strong>
                <span>Contact support</span>
            </div>

            <i class="fas fa-arrow-right"></i>

        </div>

        <button
            class="btn btn-link sidebar-toggle-btn"
            id="sidebarToggle"
            type="button"
            aria-label="Toggle sidebar"
        >
            <i class="fas fa-angle-double-left"></i>
        </button>

    </div>

</ul>


<style>
    :root {
        --connector-primary: #6B9080;
        --connector-primary-dark: #254035;
        --connector-sidebar: #18352c;
        --connector-sidebar-deep: #122b23;
        --connector-sidebar-hover: rgba(255,255,255,.075);
        --connector-sidebar-active: rgba(107,144,128,.22);
        --connector-sidebar-text: #d7e5df;
        --connector-sidebar-muted: #82988f;
        --connector-white: #ffffff;
    }

    .connector-sidebar {
        background:
            linear-gradient(
                180deg,
                var(--connector-sidebar) 0%,
                var(--connector-sidebar-deep) 100%
            ) !important;

        width: 270px;
        min-width: 270px;
        box-shadow: 8px 0 35px rgba(19, 47, 38, .08);
        position: relative;
        z-index: 1030;
        overflow-x: hidden;
    }

    .connector-sidebar-brand {
        height: 82px;
        padding: 0 20px;
        display: flex !important;
        align-items: center;
        justify-content: flex-start !important;
        text-decoration: none !important;
        border-bottom: 1px solid rgba(255,255,255,.07);
        position: relative;
    }

    .connector-brand-mark {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 12px;
        background: #ffffff;
        color: var(--connector-primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 800;
        box-shadow: 0 8px 20px rgba(0,0,0,.12);
    }

    .connector-brand-content {
        margin-left: 12px;
        line-height: 1;
    }

    .connector-brand-name {
        color: #fff;
        font-size: 17px;
        font-weight: 800;
        letter-spacing: -.3px;
    }

    .connector-brand-subtitle {
        color: #8da69c;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-top: 7px;
    }

    .connector-brand-status {
        margin-left: auto;
    }

    .connector-brand-status span {
        display: block;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #6ed6a3;
        box-shadow: 0 0 0 4px rgba(110,214,163,.10);
    }

    .connector-sidebar-search {
        padding: 18px 16px 8px;
    }

    .connector-search-wrapper {
        height: 42px;
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.07);
        border-radius: 11px;
        display: flex;
        align-items: center;
        padding: 0 11px;
        transition: .2s ease;
    }

    .connector-search-wrapper:focus-within {
        background: rgba(255,255,255,.09);
        border-color: rgba(107,144,128,.55);
    }

    .connector-search-wrapper i {
        color: #718c81;
        font-size: 13px;
        margin-right: 9px;
    }

    .connector-search-wrapper input {
        width: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        color: #fff;
        font-size: 12px;
    }

    .connector-search-wrapper input::placeholder {
        color: #789087;
    }

    .connector-search-key {
        width: 21px;
        height: 21px;
        border: 1px solid rgba(255,255,255,.10);
        border-radius: 5px;
        color: #81958e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
    }

    .connector-sidebar-section {
        padding: 18px 20px 7px;
    }

    .connector-sidebar-label {
        color: #6f897f;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .connector-sidebar .nav-item {
        margin: 2px 10px;
    }

    .connector-nav-link {
        border-radius: 11px !important;
        min-height: 46px;
        padding: 0 12px !important;
        display: flex !important;
        align-items: center;
        color: var(--connector-sidebar-text) !important;
        transition: all .18s ease;
        position: relative;
    }

    .connector-nav-link:hover {
        background: var(--connector-sidebar-hover);
        color: #fff !important;
    }

    .connector-nav-link .connector-nav-icon {
        width: 32px;
        min-width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8fa89f;
        font-size: 13px;
        transition: .18s ease;
    }

    .connector-nav-link:hover .connector-nav-icon,
    .connector-nav-link.active .connector-nav-icon {
        color: #b8d4c8;
    }

    .connector-nav-text {
        font-size: 12px;
        font-weight: 600;
        margin-left: 7px;
        white-space: nowrap;
    }

    .connector-nav-arrow {
        margin-left: auto;
        font-size: 9px;
        color: #71877f;
        transition: transform .2s ease;
    }

    .connector-nav-link[aria-expanded="true"] .connector-nav-arrow {
        transform: rotate(90deg);
    }

    .connector-sidebar .nav-item.active > .connector-nav-link {
        background: var(--connector-sidebar-active);
        color: #fff !important;
    }

    .connector-sidebar .nav-item.active > .connector-nav-link::before {
        content: "";
        position: absolute;
        left: -10px;
        top: 9px;
        bottom: 9px;
        width: 3px;
        background: #a7c9ba;
        border-radius: 0 4px 4px 0;
    }

    .connector-nav-badge {
        margin-left: auto;
        font-size: 8px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 4px 7px;
        border-radius: 6px;
        background: rgba(110,214,163,.12);
        color: #82d8ab;
    }

    .connector-submenu {
        margin: 2px 0 6px 42px;
        padding: 5px 0;
        border-left: 1px solid rgba(255,255,255,.08);
    }

    .connector-submenu-link {
        min-height: 36px;
        padding: 0 10px 0 15px;
        display: flex;
        align-items: center;
        gap: 9px;
        color: #8da29a !important;
        text-decoration: none !important;
        font-size: 11px;
        font-weight: 500;
        transition: .18s ease;
        border-radius: 0 8px 8px 0;
    }

    .connector-submenu-link:hover {
        color: #fff !important;
        background: rgba(255,255,255,.04);
    }

    .connector-submenu-link.active {
        color: #c4ddd1 !important;
        background: rgba(107,144,128,.13);
    }

    .submenu-dot {
        width: 5px;
        height: 5px;
        min-width: 5px;
        border-radius: 50%;
        background: #58766a;
    }

    .connector-submenu-link.active .submenu-dot {
        background: #9fc1b2;
    }

    .connector-sidebar-footer {
        margin-top: auto;
        padding: 15px;
    }

    .connector-help-card {
        padding: 12px;
        border-radius: 12px;
        background: rgba(255,255,255,.055);
        border: 1px solid rgba(255,255,255,.06);
        display: flex;
        align-items: center;
        cursor: pointer;
        transition: .2s ease;
    }

    .connector-help-card:hover {
        background: rgba(255,255,255,.085);
    }

    .connector-help-icon {
        width: 32px;
        height: 32px;
        min-width: 32px;
        border-radius: 9px;
        background: rgba(107,144,128,.18);
        color: #a5c5b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .connector-help-content {
        margin-left: 9px;
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .connector-help-content strong {
        color: #e8f0ed;
        font-size: 10px;
        font-weight: 700;
    }

    .connector-help-content span {
        color: #71877f;
        font-size: 9px;
        margin-top: 3px;
    }

    .connector-help-card > i {
        margin-left: auto;
        color: #60786e;
        font-size: 9px;
    }

    .sidebar-toggle-btn {
        width: 100%;
        margin-top: 10px;
        color: #6f887e !important;
        text-align: center;
        font-size: 11px;
    }

    .sidebar-toggle-btn:hover {
        color: #fff !important;
    }

    .connector-sidebar.toggled {
        width: 90px !important;
        min-width: 90px !important;
    }

    .connector-sidebar.toggled .connector-sidebar-brand {
        justify-content: center !important;
        padding: 0 !important;
    }

    .connector-sidebar.toggled .connector-brand-content,
    .connector-sidebar.toggled .connector-brand-status,
    .connector-sidebar.toggled .connector-sidebar-search,
    .connector-sidebar.toggled .connector-sidebar-label,
    .connector-sidebar.toggled .connector-nav-text,
    .connector-sidebar.toggled .connector-nav-arrow,
    .connector-sidebar.toggled .connector-nav-badge,
    .connector-sidebar.toggled .connector-help-card {
        display: none;
    }

    .connector-sidebar.toggled .connector-sidebar-section {
        height: 12px;
        padding: 0;
    }

    .connector-sidebar.toggled .connector-nav-link {
        justify-content: center;
        padding: 0 !important;
    }

    .connector-sidebar.toggled .connector-nav-icon {
        margin: 0;
    }

    .connector-sidebar.toggled .connector-submenu {
        display: none !important;
    }

    .connector-sidebar.toggled .connector-sidebar-footer {
        padding: 10px;
    }

    .connector-sidebar.toggled .sidebar-toggle-btn {
        margin-top: 0;
    }

    @media (max-width: 768px) {
        .connector-sidebar {
            width: 270px !important;
            min-width: 270px !important;
        }
    }
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('sidebarSearch');

    if (searchInput) {

        searchInput.addEventListener('input', function () {

            const query = this.value.toLowerCase().trim();

            document
                .querySelectorAll('.connector-sidebar .nav-item')
                .forEach(function (item) {

                    const text = item.innerText.toLowerCase();

                    if (!query || text.includes(query)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }

                });

        });

    }

    document.addEventListener('keydown', function (event) {

        if (
            event.key === '/' &&
            !['INPUT', 'TEXTAREA'].includes(
                document.activeElement.tagName
            )
        ) {
            event.preventDefault();

            if (searchInput) {
                searchInput.focus();
            }
        }

    });

});
</script>