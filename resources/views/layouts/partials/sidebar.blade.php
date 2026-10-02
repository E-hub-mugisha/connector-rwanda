@php
    $user = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | Normalize User utype
    |--------------------------------------------------------------------------
    | Supports:
    | CST / cst / Customer
    | SVP / svp / Service Provider
    | ADM / adm / Admin
    |--------------------------------------------------------------------------
    */

    $utype = strtoupper(trim((string) ($user?->utype ?? '')));

    $isCustomer = $utype === 'CST';
    $isProvider = $utype === 'SVP';
    $isAdmin    = $utype === 'ADM';

    /*
    |--------------------------------------------------------------------------
    | User Initials
    |--------------------------------------------------------------------------
    */

    $initials = collect(
        preg_split('/\s+/', trim($user?->name ?? 'User'))
    )
        ->filter()
        ->take(2)
        ->map(fn ($name) => strtoupper(substr($name, 0, 1)))
        ->implode('');

    $initials = $initials ?: 'U';
@endphp


<aside
    class="app-sidebar"
    id="appSidebar">

    {{-- =========================================================
         BRAND
    ========================================================== --}}
    <div class="sidebar-brand">

        <div class="brand-logo">
            <i class="bi bi-grid-1x2-fill"></i>
        </div>

        <div>
            <h5 class="brand-name">
                Connector
            </h5>

            <p class="brand-subtitle">
                Service Marketplace
            </p>
        </div>

    </div>


    {{-- =========================================================
         NAVIGATION
    ========================================================== --}}
    <div class="sidebar-body">

        {{-- =====================================================
             CUSTOMER
        ====================================================== --}}
        @if($isCustomer)

            <div class="sidebar-section">

                <div class="sidebar-title">
                    Customer
                </div>

                <a
                    href="{{ route('customer.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">

                    <i class="bi bi-grid-1x2"></i>

                    <span>Dashboard</span>

                </a>

                <a
                    href="{{ route('customer.services') }}"
                    class="sidebar-link {{ request()->routeIs('customer.services') ? 'active' : '' }}">

                    <i class="bi bi-search"></i>

                    <span>Find Services</span>

                </a>

                <a
                    href="{{ route('customer.GetProviderService') }}"
                    class="sidebar-link {{ request()->routeIs('customer.GetProviderService') ? 'active' : '' }}">

                    <i class="bi bi-people"></i>

                    <span>Service Providers</span>

                </a>


            </div>


            <div class="sidebar-section">

                <div class="sidebar-title">
                    Account
                </div>

                <a
                    href="{{ route('customer-profile') }}"
                    class="sidebar-link {{ request()->routeIs('customer-profile') ? 'active' : '' }}">

                    <i class="bi bi-person"></i>

                    <span>My Profile</span>

                </a>

                <a
                    href="{{ route('CustomerProfile.edit') }}"
                    class="sidebar-link {{ request()->routeIs('CustomerProfile.edit') ? 'active' : '' }}">

                    <i class="bi bi-pencil-square"></i>

                    <span>Edit Profile</span>

                </a>

            </div>

        @endif


        {{-- =====================================================
             SERVICE PROVIDER
        ====================================================== --}}
        @if($isProvider)

            <div class="sidebar-section">

                <div class="sidebar-title">
                    Overview
                </div>

                <a
                    href="{{ route('sprovider.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('sprovider.dashboard') ? 'active' : '' }}">

                    <i class="bi bi-grid-1x2"></i>

                    <span>Dashboard</span>

                </a>

            </div>


            <div class="sidebar-section">

                <div class="sidebar-title">
                    Services
                </div>

                <a
                    href="{{ route('serviceProvider.index') }}"
                    class="sidebar-link {{ request()->routeIs('serviceProvider.*') ? 'active' : '' }}">

                    <i class="bi bi-briefcase"></i>

                    <span>Services</span>

                </a>


            </div>


            <div class="sidebar-section">

                <div class="sidebar-title">
                    Business
                </div>


                <a
                    href="{{ route('promotions.index') }}"
                    class="sidebar-link {{ request()->routeIs('promotions.*') ? 'active' : '' }}">

                    <i class="bi bi-megaphone"></i>

                    <span>Promotions</span>

                </a>

            </div>


            <div class="sidebar-section">

                <div class="sidebar-title">
                    Content
                </div>

                <a
                    href="{{ route('serviceProviderBlog.index') }}"
                    class="sidebar-link {{ request()->routeIs('serviceProviderBlog.*') ? 'active' : '' }}">

                    <i class="bi bi-journal-text"></i>

                    <span>My Blog</span>

                </a>

                <a
                    href="{{ route('provider.jobs.index') }}"
                    class="sidebar-link {{ request()->routeIs('provider.jobs.*') || request()->routeIs('provider.applications.*') ? 'active' : '' }}">

                    <i class="bi bi-person-workspace"></i>

                    <span>Jobs</span>

                </a>

            </div>


            <div class="sidebar-section">

                <div class="sidebar-title">
                    Feedback
                </div>

                <a
                    href="{{ route('serviceProvider.reviews') }}"
                    class="sidebar-link {{ request()->routeIs('serviceProvider.reviews') ? 'active' : '' }}">

                    <i class="bi bi-star"></i>

                    <span>Reviews</span>

                </a>

                <a
                    href="{{ route('serviceProvider.feedback') }}"
                    class="sidebar-link {{ request()->routeIs('serviceProvider.feedback') ? 'active' : '' }}">

                    <i class="bi bi-chat-left-text"></i>

                    <span>Feedback</span>

                </a>

            </div>


            <div class="sidebar-section">

                <div class="sidebar-title">
                    Account
                </div>

                <a
                    href="{{ route('sprovider.profile') }}"
                    class="sidebar-link {{ request()->routeIs('sprovider.profile') || request()->routeIs('sprovider.edit_profile') ? 'active' : '' }}">

                    <i class="bi bi-person-circle"></i>

                    <span>My Profile</span>

                </a>

            </div>

        @endif


        {{-- =====================================================
             ADMIN
        ====================================================== --}}
        @if($isAdmin)

            <div class="sidebar-section">

                <div class="sidebar-title">
                    Administration
                </div>

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                    <i class="bi bi-speedometer2"></i>

                    <span>Dashboard</span>

                </a>

            </div>


            <div class="sidebar-section">

                <div class="sidebar-title">
                    Marketplace
                </div>

                <a
                    href="{{ route('admin.service_categories') }}"
                    class="sidebar-link {{ request()->routeIs('admin.service_categories') || request()->routeIs('admin.add_service_category') || request()->routeIs('admin.edit_service_category') ? 'active' : '' }}">

                    <i class="bi bi-grid"></i>

                    <span>Categories</span>

                </a>

                <a
                    href="{{ route('admin.all_services') }}"
                    class="sidebar-link {{ request()->routeIs('admin.all_services') || request()->routeIs('admin.show_service') || request()->routeIs('admin.edit_service') ? 'active' : '' }}">

                    <i class="bi bi-briefcase"></i>

                    <span>Services</span>

                </a>

                <a
                    href="{{ route('admin.service_providers') }}"
                    class="sidebar-link {{ request()->routeIs('admin.service_providers') || request()->routeIs('admin.ShowServiceProviders') ? 'active' : '' }}">

                    <i class="bi bi-person-badge"></i>

                    <span>Service Providers</span>

                </a>

            </div>


            <div class="sidebar-section">

                <div class="sidebar-title">
                    Users
                </div>

                <a
                    href="{{ route('admin.users') }}"
                    class="sidebar-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">

                    <i class="bi bi-people"></i>

                    <span>Users</span>

                </a>

                <a
                    href="{{ route('admin.messages') }}"
                    class="sidebar-link {{ request()->routeIs('admin.messages') || request()->routeIs('admin.messageDetail') ? 'active' : '' }}">

                    <i class="bi bi-envelope"></i>

                    <span>Messages</span>

                </a>

            </div>


            <div class="sidebar-section">

                <div class="sidebar-title">
                    Content
                </div>

                <a
                    href="{{ route('admin.blogs') }}"
                    class="sidebar-link {{ request()->routeIs('admin.blogs') || request()->routeIs('admin.add_blog') || request()->routeIs('admin.edit_blog') || request()->routeIs('admin.blog_detail') ? 'active' : '' }}">

                    <i class="bi bi-journal-text"></i>

                    <span>Blogs</span>

                </a>

                <a
                    href="{{ route('admin.slider') }}"
                    class="sidebar-link {{ request()->routeIs('admin.slider') ? 'active' : '' }}">

                    <i class="bi bi-images"></i>

                    <span>Slider</span>

                </a>

                <a
                    href="{{ route('admin.partners') }}"
                    class="sidebar-link {{ request()->routeIs('admin.partners') ? 'active' : '' }}">

                    <i class="bi bi-building"></i>

                    <span>Partners</span>

                </a>

            </div>


            <div class="sidebar-section">

                <div class="sidebar-title">
                    Jobs
                </div>

                <a
                    href="{{ route('admin.jobs') }}"
                    class="sidebar-link {{ request()->routeIs('admin.jobs*') || request()->routeIs('admin.jobs.applications') || request()->routeIs('admin.applications.*') ? 'active' : '' }}">

                    <i class="bi bi-briefcase-fill"></i>

                    <span>Jobs</span>

                </a>

            </div>

        @endif


        {{-- =====================================================
             FALLBACK
        ====================================================== --}}
        @if(!$isCustomer && !$isProvider && !$isAdmin)

            <div class="sidebar-section">

                <div class="sidebar-title">
                    Account
                </div>

                <div class="px-3 py-2 text-muted small">
                    utype not recognized.
                </div>

            </div>

        @endif

    </div>


    {{-- =========================================================
         USER
    ========================================================== --}}
    <div class="sidebar-user">

        <div class="sidebar-user-box">

            <div class="user-avatar">
                {{ $initials }}
            </div>

            <div class="flex-grow-1">

                <div class="user-name">
                    {{ $user?->name ?? 'User' }}
                </div>

                <div class="user-utype">

                    @if($isCustomer)
                        Customer
                    @elseif($isProvider)
                        Service Provider
                    @elseif($isAdmin)
                        Administrator
                    @else
                        {{ $user?->utype ?? 'User' }}
                    @endif

                </div>

            </div>

        </div>

    </div>

</aside>