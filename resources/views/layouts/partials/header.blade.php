@php
    $user = auth()->user();

    $role = strtoupper($user?->role ?? '');

    $isCustomer = $role === 'CST';
    $isProvider = $role === 'SVP';
    $isAdmin = $role === 'ADM';

    $initials = collect(explode(' ', trim($user?->name ?? 'User')))
        ->filter()
        ->take(2)
        ->map(fn($name) => strtoupper(substr($name, 0, 1)))
        ->implode('');

    $pageTitle = 'Dashboard';

    if ($isCustomer) {
        if (request()->routeIs('customer.services')) {
            $pageTitle = 'Find Services';
        } elseif (request()->routeIs('CustomerServiceBooked')) {
            $pageTitle = 'My Bookings';
        } elseif (request()->routeIs('customer-profile')) {
            $pageTitle = 'My Profile';
        } elseif (request()->routeIs('CustomerProfile.edit')) {
            $pageTitle = 'Edit Profile';
        } elseif (request()->routeIs('customer.dashboard')) {
            $pageTitle = 'Customer Dashboard';
        }
    }

    if ($isProvider) {
        if (request()->routeIs('serviceProvider.*')) {
            $pageTitle = 'My Services';
        } elseif (request()->routeIs('serviceProviderBooking.*')) {
            $pageTitle = 'Bookings';
        } elseif (request()->routeIs('sprovider.portfolio')) {
            $pageTitle = 'Portfolio';
        } elseif (request()->routeIs('working_hours.*')) {
            $pageTitle = 'Working Hours';
        } elseif (request()->routeIs('promotions.*')) {
            $pageTitle = 'Promotions';
        } elseif (request()->routeIs('provider.jobs.*')) {
            $pageTitle = 'Jobs';
        } elseif (request()->routeIs('sprovider.profile')) {
            $pageTitle = 'My Profile';
        } elseif (request()->routeIs('sprovider.dashboard')) {
            $pageTitle = 'Provider Dashboard';
        }
    }

    if ($isAdmin) {
        if (request()->routeIs('admin.users')) {
            $pageTitle = 'Users';
        } elseif (request()->routeIs('admin.service_categories')) {
            $pageTitle = 'Service Categories';
        } elseif (request()->routeIs('admin.all_services')) {
            $pageTitle = 'Services';
        } elseif (request()->routeIs('admin.service_providers')) {
            $pageTitle = 'Service Providers';
        } elseif (request()->routeIs('admin.bookings')) {
            $pageTitle = 'Bookings';
        } elseif (request()->routeIs('admin.blogs')) {
            $pageTitle = 'Blogs';
        } elseif (request()->routeIs('admin.jobs')) {
            $pageTitle = 'Jobs';
        } elseif (request()->routeIs('admin.dashboard')) {
            $pageTitle = 'Admin Dashboard';
        }
    }
@endphp

<header class="app-header">

    <div class="header-left">

        {{-- Mobile sidebar button --}}
        <button
            type="button"
            class="sidebar-toggle"
            id="sidebarToggle">

            <i class="bi bi-list fs-5"></i>

        </button>

        <div class="page-heading">

            <h5>
                {{ $pageTitle }}
            </h5>

            <small>
                @if($isCustomer)
                    Manage your services and bookings
                @elseif($isProvider)
                    Manage your service business
                @elseif($isAdmin)
                    Manage the Connector platform
                @else
                    Welcome to Connector
                @endif
            </small>

        </div>

    </div>


    <div class="header-actions">

        {{-- Notifications --}}
        <a
            href="#"
            class="header-icon notification"
            title="Notifications">

            <i class="bi bi-bell"></i>

        </a>


        {{-- Profile dropdown --}}
        <div class="dropdown">

            <button
                class="header-profile btn p-0 border-0 bg-transparent dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">

                <div class="header-avatar">
                    {{ $initials ?: 'U' }}
                </div>

                <div class="header-user-info text-start">

                    <div class="header-user-name">
                        {{ $user?->name ?? 'User' }}
                    </div>

                    <div class="header-user-role">

                        @if($isCustomer)
                            Customer
                        @elseif($isProvider)
                            Service Provider
                        @elseif($isAdmin)
                            Administrator
                        @else
                            User
                        @endif

                    </div>

                </div>

            </button>


            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">

                @if($isCustomer)

                    <li>
                        <a
                            class="dropdown-item"
                            href="{{ route('customer-profile') }}">

                            <i class="bi bi-person me-2"></i>

                            Profile

                        </a>
                    </li>

                @elseif($isProvider)

                    <li>
                        <a
                            class="dropdown-item"
                            href="{{ route('sprovider.profile') }}">

                            <i class="bi bi-person me-2"></i>

                            Profile

                        </a>
                    </li>

                @elseif($isAdmin)

                    <li>
                        <a
                            class="dropdown-item"
                            href="{{ route('admin.dashboard') }}">

                            <i class="bi bi-speedometer2 me-2"></i>

                            Dashboard

                        </a>
                    </li>

                @endif

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>

                    <form
                        method="POST"
                        action="{{ route('logout') }}">

                        @csrf

                        <button
                            type="submit"
                            class="dropdown-item text-danger">

                            <i class="bi bi-box-arrow-right me-2"></i>

                            Logout

                        </button>

                    </form>

                </li>

            </ul>

        </div>

    </div>

</header>