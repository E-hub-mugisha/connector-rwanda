@php
    $exploreCategories = $exploreCategories ?? [
        [
            'name' => 'Home Services',
            'icon' => 'home',
            'subcategories' => [
                ['name' => 'Cleaning', 'locations' => ['Kigali', 'Musanze', 'Huye']],
                ['name' => 'Plumbing', 'locations' => ['Kigali', 'Rubavu']],
                ['name' => 'Electrical', 'locations' => ['Kigali', 'Muhanga']],
            ],
        ],
        [
            'name' => 'Events',
            'icon' => 'calendar',
            'subcategories' => [
                ['name' => 'Photography', 'locations' => ['Kigali', 'Huye']],
                ['name' => 'Catering', 'locations' => ['Kigali', 'Rubavu', 'Musanze']],
            ],
        ],
        [
            'name' => 'Professional',
            'icon' => 'briefcase',
            'subcategories' => [
                ['name' => 'Accounting', 'locations' => ['Kigali']],
                ['name' => 'Legal Consulting', 'locations' => ['Kigali', 'Huye']],
            ],
        ],
        [
            'name' => 'Beauty & Wellness',
            'icon' => 'sparkle',
            'subcategories' => [
                ['name' => 'Hair & Makeup', 'locations' => ['Kigali', 'Musanze']],
                ['name' => 'Massage Therapy', 'locations' => ['Kigali']],
            ],
        ],
    ];

    $providerCategories = $providerCategories ?? [
        [
            'name' => 'Home Services Providers',
            'locations' => ['Kigali', 'Musanze', 'Huye', 'Rubavu']
        ],
        [
            'name' => 'Event Providers',
            'locations' => ['Kigali', 'Huye']
        ],
        [
            'name' => 'Professional Providers',
            'locations' => ['Kigali', 'Muhanga']
        ],
        [
            'name' => 'Beauty & Wellness Providers',
            'locations' => ['Kigali', 'Musanze']
        ],
    ];

    $latestNews = $latestNews ?? [
        [
            'title' => 'Connector launches verified provider badges',
            'url' => '#',
            'date' => 'Aug 2026'
        ],
        [
            'title' => 'How to price your services competitively',
            'url' => '#',
            'date' => 'Jul 2026'
        ],
        [
            'title' => 'New payment options now supported',
            'url' => '#',
            'date' => 'Jul 2026'
        ],
    ];

    $latestJobs = $latestJobs ?? [
        [
            'title' => 'Field Operations Coordinator',
            'url' => '#',
            'location' => 'Kigali'
        ],
        [
            'title' => 'Customer Support Associate',
            'url' => '#',
            'location' => 'Remote'
        ],
        [
            'title' => 'Partnerships Manager',
            'url' => '#',
            'location' => 'Kigali'
        ],
    ];
@endphp


<header class="cn-header" id="cn-header">

    <div class="cn-container">

        {{-- ==========================================================
             BRAND
        =========================================================== --}}
        <a href="{{ route('home') }}" class="cn-brand" aria-label="Connector home">
            <img
                src="{{ asset('asset/images/logo/logo-connector-header.png') }}"
                alt="Connector"
                class="cn-brand-logo"
            >
        </a>


        {{-- ==========================================================
             PRIMARY NAVIGATION
        =========================================================== --}}
        <nav class="cn-primary-nav" id="cn-primary-nav">

            {{-- Explore --}}
            <button
                type="button"
                class="cn-explore-trigger"
                id="cnfExploreBtn"
                aria-haspopup="true"
                aria-expanded="false"
                aria-controls="cnf-offcanvas"
                onclick="cnfOpenOffcanvas()"
            >
                <span class="cn-explore-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                        <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                        <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                        <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                    </svg>
                </span>

                <span>Explore</span>

                <svg class="cn-chevron" width="12" height="12"
                     viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5">
                    <path d="m6 9 6 6 6-6"/>
                </svg>
            </button>


            <a
                href="{{ route('home.service_provider') }}"
                class="cn-nav-link {{ request()->routeIs('home.service_provider') ? 'active' : '' }}"
            >
                Providers
            </a>

            <a
                href="{{ route('home.jobs') }}"
                class="cn-nav-link {{ request()->routeIs('home.jobs') ? 'active' : '' }}"
            >
                Jobs
            </a>


            {{-- ======================================================
                 COMPANY
            ======================================================= --}}
            <div class="cn-company">

                <button
                    type="button"
                    class="cn-nav-link cn-company-trigger"
                    id="cncTrigger"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    Company

                    <svg width="12" height="12"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2.5">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </button>


                <div class="cn-company-menu" id="cncPanel">

                    <div class="cn-company-grid">

                        <div class="cn-company-column">

                            <span class="cn-menu-label">
                                Company
                            </span>

                            <a href="{{ route('about') }}">
                                <span>About Us</span>
                                <small>Learn about Connector</small>
                            </a>

                            <a href="{{ route('faq') }}">
                                <span>How It Works</span>
                                <small>Discover how Connector works</small>
                            </a>

                            <a href="{{ route('home.jobs') }}">
                                <span>Careers</span>
                                <small>Join our growing team</small>
                            </a>

                            <a href="{{ route('home.blogs') }}">
                                <span>Blog</span>
                                <small>Insights and updates</small>
                            </a>

                        </div>


                        <div class="cn-company-column">

                            <span class="cn-menu-label">
                                Support
                            </span>

                            <a href="{{ route('faq') }}">
                                <span>Help Center</span>
                                <small>Find answers quickly</small>
                            </a>

                            <a href="{{ route('home.contact') }}">
                                <span>Contact Us</span>
                                <small>Talk to our team</small>
                            </a>

                            <a href="{{ route('policy') }}">
                                <span>Trust & Safety</span>
                                <small>Our safety standards</small>
                            </a>

                        </div>


                        <div class="cn-provider-promo">

                            <div class="cn-promo-icon">
                                <svg width="20" height="20"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path d="M12 5v14"/>
                                    <path d="M5 12h14"/>
                                </svg>
                            </div>

                            <strong>
                                Grow your business
                            </strong>

                            <p>
                                List your services and connect with customers
                                across Rwanda.
                            </p>

                            <a
                                href="{{ route('register') }}"
                                class="cn-promo-button"
                            >
                                Become a provider
                                <svg width="14" height="14"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path d="M5 12h14"/>
                                    <path d="m13 6 6 6-6 6"/>
                                </svg>
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </nav>


        {{-- ==========================================================
             SEARCH
        =========================================================== --}}
        <form
            action="{{ route('services.search') }}"
            method="GET"
            class="cn-search"
        >

            <svg
                class="cn-search-icon"
                width="18"
                height="18"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <circle cx="11" cy="11" r="7"/>
                <path d="m20 20-4-4"/>
            </svg>

            <input
                type="search"
                name="query"
                value="{{ request('query') }}"
                placeholder="Search services, providers..."
                autocomplete="off"
            >

            <button type="submit">
                Search
            </button>

        </form>


        {{-- ==========================================================
             RIGHT ACTIONS
        =========================================================== --}}
        <div class="cn-actions">


            {{-- AI --}}
            <a
                href="#"
                class="cn-ai"
                title="AI Assistant"
            >
                <svg width="17" height="17"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8">
                    <path d="M12 3v3"/>
                    <path d="M12 18v3"/>
                    <path d="M3 12h3"/>
                    <path d="M18 12h3"/>
                    <path d="m4.9 4.9 2.1 2.1"/>
                    <path d="m17 17 2.1 2.1"/>
                    <path d="m19.1 4.9-2.1 2.1"/>
                    <path d="m7 17-2.1 2.1"/>
                    <circle cx="12" cy="12" r="3.2"/>
                </svg>

                <span>AI</span>
            </a>


            @if(Route::has('login'))

                @auth

                    @php
                        $utype = Auth::user()->utype;
                    @endphp


                    {{-- USER MENU --}}
                    <div class="cn-user">

                        <button
                            type="button"
                            class="cn-user-trigger"
                            id="userPill"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >

                            <img
                                src="{{ asset('admin/img/undraw_profile.svg') }}"
                                alt=""
                            >

                            <span class="cn-user-name">
                                {{ Str::words(auth()->user()->name, 1, '') }}
                            </span>

                            <svg width="12" height="12"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2.5">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>

                        </button>


                        <div
                            class="cn-user-menu"
                            id="userDropdown"
                        >

                            <div class="cn-user-menu-head">

                                <img
                                    src="{{ asset('admin/img/undraw_profile.svg') }}"
                                    alt=""
                                >

                                <div>
                                    <strong>
                                        {{ auth()->user()->name }}
                                    </strong>

                                    <span>
                                        {{ auth()->user()->email }}
                                    </span>
                                </div>

                            </div>


                            <div class="cn-user-menu-divider"></div>


                            @if($utype === 'ADM')

                                <a href="{{ route('admin.dashboard') }}" target="_blank">

                                    <svg width="16" height="16"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <rect x="3" y="3" width="7" height="7"/>
                                        <rect x="14" y="3" width="7" height="7"/>
                                        <rect x="14" y="14" width="7" height="7"/>
                                        <rect x="3" y="14" width="7" height="7"/>
                                    </svg>

                                    Dashboard

                                </a>

                            @elseif($utype === 'SVP')

                                <a href="{{ route('sprovider.dashboard') }}" target="_blank">

                                    <svg width="16" height="16"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <rect x="3" y="3" width="7" height="7"/>
                                        <rect x="14" y="3" width="7" height="7"/>
                                        <rect x="14" y="14" width="7" height="7"/>
                                        <rect x="3" y="14" width="7" height="7"/>
                                    </svg>

                                    Dashboard

                                </a>

                            @else

                                <a href="{{ route('customer.dashboard') }}" target="_blank">

                                    <svg width="16" height="16"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <rect x="3" y="3" width="7" height="7"/>
                                        <rect x="14" y="3" width="7" height="7"/>
                                        <rect x="14" y="14" width="7" height="7"/>
                                        <rect x="3" y="14" width="7" height="7"/>
                                    </svg>

                                    Dashboard

                                </a>

                            @endif


                            <a
                                href="#"
                                class="cn-logout"
                                onclick="event.preventDefault(); document.getElementById('cn-logout-form').submit();"
                            >

                                <svg width="16" height="16"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                    <path d="m16 17 5-5-5-5"/>
                                    <path d="M21 12H9"/>
                                </svg>

                                Logout

                            </a>

                        </div>

                    </div>


                    <form
                        id="cn-logout-form"
                        method="POST"
                        action="{{ route('logout') }}"
                        style="display:none"
                    >
                        @csrf
                    </form>


                @else

                    <a
                        href="#"
                        class="cn-login"
                        data-bs-toggle="modal"
                        data-bs-target="#loginModal"
                    >
                        Login
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="cn-get-started"
                    >
                        Get Started
                    </a>

                @endauth

            @endif


            {{-- MOBILE --}}
            <button
                type="button"
                class="cn-mobile-toggle"
                id="cnToggler"
                aria-label="Open navigation"
                aria-expanded="false"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>

    </div>

</header>


{{-- ================================================================
     EXPLORE OFFCANVAS
================================================================ --}}

<div
    class="cnf-overlay"
    id="cnf-overlay"
    onclick="cnfCloseOffcanvas()"
></div>


<aside
    class="cnf-offcanvas"
    id="cnf-offcanvas"
    aria-label="Explore Connector"
>

    <div class="cnf-header">

        <div>

            <span class="cnf-kicker">
                DISCOVER
            </span>

            <h3>
                Explore Connector
            </h3>

        </div>

        <button
            type="button"
            class="cnf-close"
            onclick="cnfCloseOffcanvas()"
            aria-label="Close"
        >
            <svg width="18" height="18"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">
                <path d="M18 6 6 18"/>
                <path d="m6 6 12 12"/>
            </svg>
        </button>

    </div>


    <div class="cnf-body">

        <div class="cnf-intro">
            Find trusted services, professionals and opportunities.
        </div>


        <div class="cnf-cat-list">

            @forelse($exploreCategories as $ci => $cat)

                <div class="cnf-cat-row">

                    <button
                        type="button"
                        class="cnf-cat-item"
                        data-opens-flyout="cnf-subflyout-cat-{{ $ci }}"
                        onclick="cnfToggleCat(event, 'cat-{{ $ci }}')"
                        onmouseenter="cnfHoverOpen('cnf-subflyout-cat-{{ $ci }}', this, 'cat')"
                        onmouseleave="cnfHoverClose('cnf-subflyout-cat-{{ $ci }}')"
                    >

                        <span class="cnf-cat-left">

                            <span class="cnf-cat-icon">

                                @if(($cat['icon'] ?? '') === 'home')

                                    <svg width="17" height="17"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path d="m3 11 9-8 9 8"/>
                                        <path d="M5 10v10h14V10"/>
                                        <path d="M9 20v-6h6v6"/>
                                    </svg>

                                @elseif(($cat['icon'] ?? '') === 'calendar')

                                    <svg width="17" height="17"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <rect x="3" y="4" width="18" height="17" rx="2"/>
                                        <path d="M16 2v4"/>
                                        <path d="M8 2v4"/>
                                        <path d="M3 10h18"/>
                                    </svg>

                                @elseif(($cat['icon'] ?? '') === 'briefcase')

                                    <svg width="17" height="17"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <rect x="3" y="7" width="18" height="13" rx="2"/>
                                        <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                    </svg>

                                @else

                                    <svg width="17" height="17"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path d="m12 3 1.5 5.5L19 10l-5.5 1.5L12 17l-1.5-5.5L5 10l5.5-1.5L12 3Z"/>
                                    </svg>

                                @endif

                            </span>

                            <span>
                                {{ $cat['name'] }}
                            </span>

                        </span>

                        <svg width="15" height="15"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <path d="m9 18 6-6-6-6"/>
                        </svg>

                    </button>

                </div>

            @empty

                <div class="cnf-empty">
                    No service categories yet.
                </div>

            @endforelse


            {{-- PROVIDERS --}}
            <div class="cnf-section-divider"></div>

            <div class="cnf-cat-row">

                <button
                    type="button"
                    class="cnf-cat-item"
                    data-opens-flyout="cnf-subflyout-providers"
                    onclick="cnfToggleCat(event, 'providers')"
                    onmouseenter="cnfHoverOpen('cnf-subflyout-providers', this, 'cat')"
                    onmouseleave="cnfHoverClose('cnf-subflyout-providers')"
                >

                    <span class="cnf-cat-left">

                        <span class="cnf-cat-icon">

                            <svg width="17" height="17"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M3 21a6 6 0 0 1 12 0"/>
                                <path d="M16 11a4 4 0 0 1 5 4"/>
                            </svg>

                        </span>

                        <span>Providers</span>

                    </span>

                    <svg width="15" height="15"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>

                </button>

            </div>


            {{-- NEWS --}}
            <div class="cnf-cat-row">

                <button
                    type="button"
                    class="cnf-cat-item"
                    data-opens-flyout="cnf-subflyout-updates"
                    onclick="cnfToggleCat(event, 'updates')"
                    onmouseenter="cnfHoverOpen('cnf-subflyout-updates', this, 'cat')"
                    onmouseleave="cnfHoverClose('cnf-subflyout-updates')"
                >

                    <span class="cnf-cat-left">

                        <span class="cnf-cat-icon">

                            <svg width="17" height="17"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path d="M4 4h16v16H4z"/>
                                <path d="M8 8h8"/>
                                <path d="M8 12h8"/>
                                <path d="M8 16h5"/>
                            </svg>

                        </span>

                        <span>Updates & News</span>

                    </span>

                    <svg width="15" height="15"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>

                </button>

            </div>

        </div>

    </div>

</aside>


{{-- ================================================================
     CATEGORY FLYOUTS
================================================================ --}}

@foreach($exploreCategories as $ci => $cat)

    <div
        class="cnf-flyout cnf-sub-flyout"
        id="cnf-subflyout-cat-{{ $ci }}"
        onmouseenter="cnfCancelClose('cnf-subflyout-cat-{{ $ci }}')"
        onmouseleave="cnfHoverClose('cnf-subflyout-cat-{{ $ci }}')"
    >

        <div class="cnf-flyout-title">
            {{ $cat['name'] }}
        </div>

        @forelse($cat['subcategories'] as $si => $sub)

            <button
                type="button"
                class="cnf-flyout-item"
                data-opens-flyout="cnf-flyout-cat-{{ $ci }}-{{ $si }}"
                onclick="cnfToggleSub(event, 'cat-{{ $ci }}-{{ $si }}')"
                onmouseenter="cnfHoverOpen('cnf-flyout-cat-{{ $ci }}-{{ $si }}', this, 'sub')"
                onmouseleave="cnfHoverClose('cnf-flyout-cat-{{ $ci }}-{{ $si }}')"
            >

                <span>
                    {{ $sub['name'] }}
                </span>

                <svg width="14" height="14"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">
                    <path d="m9 18 6-6-6-6"/>
                </svg>

            </button>

        @empty

            <div class="cnf-flyout-empty">
                No sub-categories yet
            </div>

        @endforelse

    </div>

@endforeach


{{-- LEVEL 3 --}}
@foreach($exploreCategories as $ci => $cat)

    @foreach($cat['subcategories'] as $si => $sub)

        <div
            class="cnf-flyout cnf-service-flyout"
            id="cnf-flyout-cat-{{ $ci }}-{{ $si }}"
            data-parent-flyout="cnf-subflyout-cat-{{ $ci }}"
            onmouseenter="cnfCancelClose('cnf-flyout-cat-{{ $ci }}-{{ $si }}')"
            onmouseleave="cnfHoverClose('cnf-flyout-cat-{{ $ci }}-{{ $si }}')"
        >

            <div class="cnf-flyout-title">
                {{ $sub['name'] }}
            </div>

            @forelse($sub['locations'] as $loc)

                <a
                    href="{{ route('home.services', [
                        'category' => $cat['name'],
                        'sub' => $sub['name'],
                        'location' => $loc
                    ]) }}"
                    class="cnf-flyout-item"
                >
                    <span>{{ $loc }}</span>

                    <svg width="14" height="14"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </a>

            @empty

                <div class="cnf-flyout-empty">
                    No locations yet
                </div>

            @endforelse

        </div>

    @endforeach

@endforeach


{{-- PROVIDER FLYOUT --}}
<div
    class="cnf-flyout cnf-sub-flyout"
    id="cnf-subflyout-providers"
    onmouseenter="cnfCancelClose('cnf-subflyout-providers')"
    onmouseleave="cnfHoverClose('cnf-subflyout-providers')"
>

    <div class="cnf-flyout-title">
        Provider categories
    </div>

    @forelse($providerCategories as $pi => $pcat)

        <button
            type="button"
            class="cnf-flyout-item"
            data-opens-flyout="cnf-flyout-provider-{{ $pi }}"
            onclick="cnfToggleSub(event, 'provider-{{ $pi }}')"
            onmouseenter="cnfHoverOpen('cnf-flyout-provider-{{ $pi }}', this, 'sub')"
            onmouseleave="cnfHoverClose('cnf-flyout-provider-{{ $pi }}')"
        >

            <span>
                {{ $pcat['name'] }}
            </span>

            <svg width="14" height="14"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">
                <path d="m9 18 6-6-6-6"/>
            </svg>

        </button>

    @empty

        <div class="cnf-flyout-empty">
            No provider categories yet
        </div>

    @endforelse

</div>


{{-- PROVIDER LOCATIONS --}}
@foreach($providerCategories as $pi => $pcat)

    <div
        class="cnf-flyout cnf-service-flyout"
        id="cnf-flyout-provider-{{ $pi }}"
        data-parent-flyout="cnf-subflyout-providers"
        onmouseenter="cnfCancelClose('cnf-flyout-provider-{{ $pi }}')"
        onmouseleave="cnfHoverClose('cnf-flyout-provider-{{ $pi }}')"
    >

        <div class="cnf-flyout-title">
            {{ $pcat['name'] }}
        </div>

        @forelse($pcat['locations'] as $loc)

            <a
                href="{{ route('home.service_provider', [
                    'category' => $pcat['name'],
                    'location' => $loc
                ]) }}"
                class="cnf-flyout-item"
            >
                {{ $loc }}
            </a>

        @empty

            <div class="cnf-flyout-empty">
                No locations yet
            </div>

        @endforelse

    </div>

@endforeach


{{-- NEWS / JOBS --}}
<div
    class="cnf-flyout cnf-sub-flyout cnf-updates-flyout"
    id="cnf-subflyout-updates"
    onmouseenter="cnfCancelClose('cnf-subflyout-updates')"
    onmouseleave="cnfHoverClose('cnf-subflyout-updates')"
>

    <div class="cnf-flyout-title">
        Latest updates
    </div>

    <div class="cnf-flyout-label">
        News
    </div>

    @forelse($latestNews as $item)

        <a
            href="{{ $item['url'] }}"
            class="cnf-news-item"
        >
            <span>{{ $item['title'] }}</span>
            <small>{{ $item['date'] }}</small>
        </a>

    @empty

        <div class="cnf-flyout-empty">
            No news yet
        </div>

    @endforelse


    <a
        href="{{ route('home.blogs') }}"
        class="cnf-view-all"
    >
        View all news
        <span>→</span>
    </a>


    <div class="cnf-divider"></div>


    <div class="cnf-flyout-label">
        Jobs
    </div>

    @forelse($latestJobs as $item)

        <a
            href="{{ $item['url'] }}"
            class="cnf-news-item"
        >
            <span>{{ $item['title'] }}</span>
            <small>{{ $item['location'] }}</small>
        </a>

    @empty

        <div class="cnf-flyout-empty">
            No jobs yet
        </div>

    @endforelse


    <a
        href="{{ route('home.jobs') }}"
        class="cnf-view-all"
    >
        View all jobs
        <span>→</span>
    </a>

</div>


<style>

/* ================================================================
   CONNECTOR HEADER
================================================================ */

:root {
    --cn-green: #6B9080;
    --cn-green-dark: #557668;
    --cn-green-soft: #EEF5F2;

    --cn-dark: #254035;
    --cn-text: #253A32;
    --cn-muted: #71857D;

    --cn-white: #ffffff;
    --cn-border: #E4ECE8;

    --cn-shadow:
        0 8px 30px rgba(37, 64, 53, .08);

    --cn-shadow-lg:
        0 18px 55px rgba(37, 64, 53, .15);

    --cn-transition:
        .22s cubic-bezier(.4, 0, .2, 1);
}


/* ================================================================
   HEADER
================================================================ */

.cn-header {

    position: fixed;

    top: 0;
    left: 0;
    right: 0;

    z-index: 1050;

    height: 78px;

    background: rgba(37, 64, 53, .98);

    border-bottom: 1px solid rgba(255,255,255,.08);

    transition:
        background .3s ease,
        box-shadow .3s ease,
        height .3s ease;
}


.cn-header.scrolled {

    background: rgba(255,255,255,.97);

    backdrop-filter: blur(16px);

    border-bottom-color: var(--cn-border);

    box-shadow:
        0 5px 25px rgba(37,64,53,.08);

}


.cn-container {

    width: min(1440px, calc(100% - 64px));

    height: 100%;

    margin: 0 auto;

    display: flex;

    align-items: center;

    gap: 20px;
}


/* ================================================================
   LOGO
================================================================ */

.cn-brand {

    display: flex;

    align-items: center;

    flex-shrink: 0;

    text-decoration: none;
}


.cn-brand-logo {

    display: block;

    width: auto;

    height: 38px;

    max-width: 150px;

    object-fit: contain;
}


/* ================================================================
   PRIMARY NAV
================================================================ */

.cn-primary-nav {

    display: flex;

    align-items: center;

    gap: 3px;

    flex-shrink: 0;
}


.cn-nav-link,
.cn-explore-trigger {

    height: 40px;

    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 0 12px;

    border-radius: 8px;

    border: 0;

    background: transparent;

    color: rgba(255,255,255,.86);

    font-family: inherit;

    font-size: 13.5px;

    font-weight: 600;

    text-decoration: none;

    white-space: nowrap;

    cursor: pointer;

    transition:
        color var(--cn-transition),
        background var(--cn-transition);
}


.cn-nav-link:hover,
.cn-explore-trigger:hover {

    color: #fff;

    background: rgba(255,255,255,.09);
}


.cn-nav-link.active {

    color: #fff;

    background: rgba(255,255,255,.11);
}


.cn-header.scrolled .cn-nav-link,
.cn-header.scrolled .cn-explore-trigger {

    color: var(--cn-dark);
}


.cn-header.scrolled .cn-nav-link:hover,
.cn-header.scrolled .cn-explore-trigger:hover {

    color: var(--cn-green-dark);

    background: var(--cn-green-soft);
}


/* ================================================================
   EXPLORE
================================================================ */

.cn-explore-trigger {

    background: var(--cn-green);

    color: #fff;

    padding: 0 14px;

    margin-right: 4px;
}


.cn-explore-trigger:hover {

    background: var(--cn-green-dark);

    color: #fff;
}


.cn-explore-icon {

    display: grid;

    place-items: center;
}


.cn-chevron {

    transition: transform .2s ease;
}


.cn-explore-trigger[aria-expanded="true"] .cn-chevron {

    transform: rotate(180deg);
}


/* ================================================================
   SEARCH
================================================================ */

.cn-search {

    flex: 1;

    min-width: 180px;

    max-width: 430px;

    height: 44px;

    margin-left: auto;

    display: flex;

    align-items: center;

    gap: 10px;

    padding: 0 6px 0 14px;

    background: rgba(255,255,255,.1);

    border: 1px solid rgba(255,255,255,.16);

    border-radius: 10px;

    transition:
        background var(--cn-transition),
        border var(--cn-transition);
}


.cn-header.scrolled .cn-search {

    background: #F5F8F6;

    border-color: var(--cn-border);
}


.cn-search:focus-within {

    border-color: var(--cn-green);

    background: rgba(255,255,255,.14);
}


.cn-header.scrolled .cn-search:focus-within {

    background: #fff;

    box-shadow:
        0 0 0 3px rgba(107,144,128,.10);
}


.cn-search-icon {

    flex-shrink: 0;

    color: rgba(255,255,255,.6);
}


.cn-header.scrolled .cn-search-icon {

    color: var(--cn-green);
}


.cn-search input {

    flex: 1;

    min-width: 0;

    height: 100%;

    border: 0;

    outline: 0;

    background: transparent;

    color: #fff;

    font-family: inherit;

    font-size: 13px;
}


.cn-header.scrolled .cn-search input {

    color: var(--cn-text);
}


.cn-search input::placeholder {

    color: rgba(255,255,255,.55);
}


.cn-header.scrolled .cn-search input::placeholder {

    color: #9AA9A3;
}


.cn-search button {

    height: 34px;

    padding: 0 14px;

    border: 0;

    border-radius: 7px;

    background: var(--cn-green);

    color: #fff;

    font-family: inherit;

    font-size: 12px;

    font-weight: 700;

    cursor: pointer;

    transition: background .2s ease;
}


.cn-search button:hover {

    background: var(--cn-green-dark);
}


/* ================================================================
   ACTIONS
================================================================ */

.cn-actions {

    display: flex;

    align-items: center;

    gap: 8px;

    flex-shrink: 0;
}


/* AI */

.cn-ai {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 6px;

    height: 38px;

    padding: 0 10px;

    color: rgba(255,255,255,.85);

    text-decoration: none;

    border-radius: 8px;

    font-size: 12px;

    font-weight: 600;

    transition: all .2s ease;
}


.cn-ai:hover {

    background: rgba(255,255,255,.08);

    color: #fff;
}


.cn-header.scrolled .cn-ai {

    color: var(--cn-dark);
}


.cn-header.scrolled .cn-ai:hover {

    color: var(--cn-green-dark);

    background: var(--cn-green-soft);
}


/* LOGIN */

.cn-login {

    height: 38px;

    display: inline-flex;

    align-items: center;

    padding: 0 13px;

    color: #fff;

    text-decoration: none;

    border-radius: 8px;

    font-size: 13px;

    font-weight: 600;

    transition: all .2s ease;
}


.cn-login:hover {

    background: rgba(255,255,255,.08);

    color: #fff;
}


.cn-header.scrolled .cn-login {

    color: var(--cn-dark);
}


.cn-header.scrolled .cn-login:hover {

    background: var(--cn-green-soft);

    color: var(--cn-green-dark);
}


/* GET STARTED */

.cn-get-started {

    height: 40px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 0 17px;

    background: var(--cn-green);

    color: #fff;

    border-radius: 8px;

    text-decoration: none;

    font-size: 13px;

    font-weight: 700;

    transition: all .2s ease;
}


.cn-get-started:hover {

    background: var(--cn-green-dark);

    color: #fff;

    transform: translateY(-1px);
}


/* ================================================================
   USER
================================================================ */

.cn-user {

    position: relative;
}


.cn-user-trigger {

    height: 40px;

    display: flex;

    align-items: center;

    gap: 8px;

    padding: 3px 10px 3px 4px;

    border: 1px solid rgba(255,255,255,.18);

    border-radius: 9px;

    background: rgba(255,255,255,.06);

    cursor: pointer;

    color: #fff;

    font-family: inherit;
}


.cn-user-trigger:hover {

    background: rgba(255,255,255,.1);
}


.cn-header.scrolled .cn-user-trigger {

    background: #F7F9F8;

    border-color: var(--cn-border);

    color: var(--cn-dark);
}


.cn-user-trigger img {

    width: 31px;

    height: 31px;

    border-radius: 7px;

    object-fit: cover;
}


.cn-user-name {

    max-width: 90px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

    font-size: 12.5px;

    font-weight: 600;
}


.cn-user-menu {

    display: none;

    position: absolute;

    top: calc(100% + 10px);

    right: 0;

    width: 245px;

    padding: 7px;

    background: #fff;

    border: 1px solid var(--cn-border);

    border-radius: 12px;

    box-shadow: var(--cn-shadow-lg);

    z-index: 1200;
}


.cn-user-menu.open {

    display: block;

    animation: cnMenuIn .18s ease;
}


@keyframes cnMenuIn {

    from {
        opacity: 0;
        transform: translateY(-5px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }

}


.cn-user-menu-head {

    display: flex;

    align-items: center;

    gap: 10px;

    padding: 9px;
}


.cn-user-menu-head img {

    width: 38px;

    height: 38px;

    border-radius: 8px;
}


.cn-user-menu-head strong {

    display: block;

    color: var(--cn-dark);

    font-size: 13px;
}


.cn-user-menu-head span {

    display: block;

    max-width: 160px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

    color: var(--cn-muted);

    font-size: 11px;

    margin-top: 2px;
}


.cn-user-menu-divider {

    height: 1px;

    margin: 5px;

    background: var(--cn-border);
}


.cn-user-menu > a {

    display: flex;

    align-items: center;

    gap: 10px;

    padding: 10px;

    border-radius: 7px;

    color: var(--cn-dark);

    text-decoration: none;

    font-size: 13px;

    font-weight: 500;

    transition: background .15s ease;
}


.cn-user-menu > a:hover {

    background: var(--cn-green-soft);
}


.cn-user-menu .cn-logout {

    color: #B34D45;
}


.cn-user-menu .cn-logout:hover {

    background: #FFF3F1;
}


/* ================================================================
   COMPANY MENU
================================================================ */

.cn-company {

    position: relative;
}


.cn-company-menu {

    position: absolute;

    top: calc(100% + 12px);

    left: 50%;

    width: 680px;

    transform:
        translateX(-50%)
        translateY(-5px);

    padding: 18px;

    background: #fff;

    border: 1px solid var(--cn-border);

    border-radius: 14px;

    box-shadow: var(--cn-shadow-lg);

    opacity: 0;

    visibility: hidden;

    pointer-events: none;

    transition:
        opacity .18s ease,
        transform .18s ease,
        visibility .18s ease;
}


.cn-company-menu.open {

    opacity: 1;

    visibility: visible;

    pointer-events: auto;

    transform:
        translateX(-50%)
        translateY(0);
}


.cn-company-grid {

    display: grid;

    grid-template-columns:
        1fr
        1fr
        1.15fr;

    gap: 10px;
}


.cn-company-column {

    padding: 8px;
}


.cn-menu-label {

    display: block;

    margin-bottom: 8px;

    color: var(--cn-green);

    font-size: 10px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .09em;
}


.cn-company-column a {

    display: block;

    padding: 9px;

    border-radius: 8px;

    text-decoration: none;

    transition: background .15s ease;
}


.cn-company-column a:hover {

    background: var(--cn-green-soft);
}


.cn-company-column a span {

    display: block;

    color: var(--cn-dark);

    font-size: 13px;

    font-weight: 650;
}


.cn-company-column a small {

    display: block;

    margin-top: 2px;

    color: var(--cn-muted);

    font-size: 10.5px;

    line-height: 1.35;
}


/* PROVIDER PROMO */

.cn-provider-promo {

    padding: 20px;

    background: var(--cn-green-soft);

    border-radius: 11px;
}


.cn-promo-icon {

    width: 38px;

    height: 38px;

    display: grid;

    place-items: center;

    margin-bottom: 15px;

    background: var(--cn-green);

    color: #fff;

    border-radius: 9px;
}


.cn-provider-promo strong {

    display: block;

    color: var(--cn-dark);

    font-size: 14px;
}


.cn-provider-promo p {

    margin: 6px 0 16px;

    color: var(--cn-muted);

    font-size: 11.5px;

    line-height: 1.5;
}


.cn-promo-button {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    color: var(--cn-green-dark);

    text-decoration: none;

    font-size: 11.5px;

    font-weight: 750;
}


/* ================================================================
   MOBILE TOGGLER
================================================================ */

.cn-mobile-toggle {

    display: none;

    width: 38px;

    height: 38px;

    border: 1px solid rgba(255,255,255,.2);

    background: rgba(255,255,255,.06);

    border-radius: 8px;

    align-items: center;

    justify-content: center;

    flex-direction: column;

    gap: 4px;

    cursor: pointer;
}


.cn-mobile-toggle span {

    width: 18px;

    height: 2px;

    background: #fff;

    border-radius: 2px;

    transition: .2s ease;
}


.cn-header.scrolled .cn-mobile-toggle {

    border-color: var(--cn-border);

    background: #F7F9F8;
}


.cn-header.scrolled .cn-mobile-toggle span {

    background: var(--cn-dark);
}


/* ================================================================
   EXPLORE OFFCANVAS
================================================================ */

.cnf-overlay {

    position: fixed;

    inset: 0;

    z-index: 1199;

    background: rgba(20,34,29,.45);

    backdrop-filter: blur(3px);

    opacity: 0;

    visibility: hidden;

    transition:
        opacity .25s ease,
        visibility .25s ease;
}


.cnf-overlay.open {

    opacity: 1;

    visibility: visible;
}


.cnf-offcanvas {

    position: fixed;

    top: 0;

    bottom: 0;

    left: 0;

    width: 350px;

    max-width: 90vw;

    z-index: 1200;

    display: flex;

    flex-direction: column;

    background: #fff;

    box-shadow:
        15px 0 60px rgba(0,0,0,.18);

    transform: translateX(-100%);

    transition:
        transform .32s cubic-bezier(.4,0,.2,1);
}


.cnf-offcanvas.open {

    transform: translateX(0);
}


.cnf-header {

    min-height: 88px;

    padding: 20px 22px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    background: var(--cn-dark);

    color: #fff;
}


.cnf-kicker {

    display: block;

    margin-bottom: 4px;

    color: #A9C2B8;

    font-size: 9px;

    font-weight: 800;

    letter-spacing: .12em;
}


.cnf-header h3 {

    margin: 0;

    font-size: 18px;

    font-weight: 700;
}


.cnf-close {

    width: 34px;

    height: 34px;

    display: grid;

    place-items: center;

    border: 0;

    border-radius: 8px;

    background: rgba(255,255,255,.09);

    color: #fff;

    cursor: pointer;
}


.cnf-close:hover {

    background: var(--cn-green);
}


.cnf-body {

    flex: 1;

    overflow-y: auto;
}


.cnf-intro {

    padding: 18px 22px 10px;

    color: var(--cn-muted);

    font-size: 12px;

    line-height: 1.5;
}


.cnf-cat-list {

    padding: 8px 12px 20px;
}


.cnf-cat-item {

    width: 100%;

    min-height: 52px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 12px;

    padding: 8px 10px;

    border: 0;

    background: transparent;

    border-radius: 9px;

    color: var(--cn-dark);

    font-family: inherit;

    font-size: 13.5px;

    font-weight: 650;

    text-align: left;

    cursor: pointer;

    transition: all .18s ease;
}


.cnf-cat-item:hover,
.cnf-cat-item.active {

    color: var(--cn-green-dark);

    background: var(--cn-green-soft);
}


.cnf-cat-left {

    display: flex;

    align-items: center;

    gap: 11px;
}


.cnf-cat-icon {

    width: 34px;

    height: 34px;

    display: grid;

    place-items: center;

    border-radius: 8px;

    background: #F4F8F6;

    color: var(--cn-green);

    flex-shrink: 0;
}


.cnf-cat-item:hover .cnf-cat-icon,
.cnf-cat-item.active .cnf-cat-icon {

    background: #fff;
}


.cnf-section-divider {

    height: 1px;

    margin: 8px 6px;

    background: var(--cn-border);
}


/* ================================================================
   FLYOUT
================================================================ */

.cnf-flyout {

    position: fixed;

    z-index: 1250;

    min-width: 240px;

    max-width: 310px;

    max-height: 70vh;

    overflow-y: auto;

    padding: 9px;

    background: #fff;

    border: 1px solid var(--cn-border);

    border-radius: 12px;

    box-shadow: var(--cn-shadow-lg);

    opacity: 0;

    visibility: hidden;

    pointer-events: none;

    transform: translateX(-7px);

    transition:
        opacity .16s ease,
        transform .16s ease,
        visibility .16s ease;
}


.cnf-flyout.open {

    opacity: 1;

    visibility: visible;

    pointer-events: auto;

    transform: translateX(0);
}


.cnf-flyout-title {

    padding: 9px 10px 7px;

    color: var(--cn-dark);

    font-size: 12px;

    font-weight: 750;

    border-bottom: 1px solid var(--cn-border);

    margin-bottom: 4px;
}


.cnf-flyout-item {

    width: 100%;

    min-height: 39px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 10px;

    padding: 8px 10px;

    border: 0;

    background: transparent;

    border-radius: 7px;

    color: var(--cn-dark);

    font-family: inherit;

    font-size: 12.5px;

    font-weight: 550;

    text-decoration: none;

    text-align: left;

    cursor: pointer;

    transition: all .16s ease;
}


.cnf-flyout-item:hover,
.cnf-flyout-item.active {

    background: var(--cn-green-soft);

    color: var(--cn-green-dark);
}


.cnf-flyout-empty {

    padding: 15px 10px;

    color: var(--cn-muted);

    font-size: 11.5px;
}


.cnf-updates-flyout {

    width: 310px;

    max-width: 90vw;
}


.cnf-flyout-label {

    padding: 9px 10px 4px;

    color: #8A9A94;

    font-size: 9px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .08em;
}


.cnf-news-item {

    display: block;

    padding: 9px 10px;

    border-radius: 7px;

    text-decoration: none;
}


.cnf-news-item:hover {

    background: var(--cn-green-soft);
}


.cnf-news-item span {

    display: block;

    color: var(--cn-dark);

    font-size: 11.5px;

    font-weight: 600;

    line-height: 1.35;
}


.cnf-news-item small {

    display: block;

    margin-top: 2px;

    color: #91A39B;

    font-size: 9.5px;
}


.cnf-view-all {

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 9px 10px;

    color: var(--cn-green-dark);

    text-decoration: none;

    font-size: 11px;

    font-weight: 750;
}


.cnf-divider {

    height: 1px;

    margin: 7px 4px;

    background: var(--cn-border);
}


/* ================================================================
   MOBILE
================================================================ */

@media (max-width: 1200px) {

    .cn-container {

        width: min(100% - 36px, 1440px);

        gap: 12px;
    }

    .cn-primary-nav {

        gap: 0;
    }

    .cn-nav-link,
    .cn-explore-trigger {

        padding-left: 9px;

        padding-right: 9px;
    }

    .cn-search {

        max-width: 340px;
    }

    .cn-ai span {

        display: none;
    }

}


@media (max-width: 1050px) {

    .cn-primary-nav {

        display: none;
    }

    .cn-search {

        max-width: none;

        margin-left: auto;
    }

    .cn-mobile-toggle {

        display: flex;
    }

}


@media (max-width: 700px) {

    .cn-header {

        height: 68px;
    }

    .cn-container {

        width: calc(100% - 28px);

        gap: 8px;
    }

    .cn-brand-logo {

        height: 32px;

        max-width: 125px;
    }

    .cn-search {

        display: none;
    }

    .cn-ai {

        width: 36px;

        height: 36px;

        padding: 0;
    }

    .cn-login {

        display: none;
    }

    .cn-get-started {

        height: 36px;

        padding: 0 11px;

        font-size: 11px;
    }

    .cn-user-name {

        display: none;
    }

    .cn-user-trigger {

        padding-right: 5px;
    }

    .cnf-offcanvas {

        width: 100%;

        max-width: 100%;
    }

}


@media (max-width: 420px) {

    .cn-get-started {

        display: none;
    }

    .cn-actions {

        margin-left: auto;
    }

}


/* ================================================================
   ACCESSIBILITY
================================================================ */

.cn-nav-link:focus-visible,
.cn-explore-trigger:focus-visible,
.cn-search:focus-within,
.cn-get-started:focus-visible,
.cn-login:focus-visible,
.cn-user-trigger:focus-visible,
.cn-mobile-toggle:focus-visible {

    outline: 3px solid rgba(107,144,128,.35);

    outline-offset: 2px;
}


body.cn-menu-open {

    overflow: hidden;
}

</style>


<script>

/* ================================================================
   HEADER SCROLL
================================================================ */

(function () {

    const header = document.getElementById('cn-header');

    if (!header) return;

    function updateHeader() {

        header.classList.toggle(
            'scrolled',
            window.scrollY > 30
        );

    }

    window.addEventListener(
        'scroll',
        updateHeader,
        { passive: true }
    );

    updateHeader();

})();


/* ================================================================
   COMPANY DROPDOWN
================================================================ */

(function () {

    const trigger = document.getElementById('cncTrigger');
    const panel = document.getElementById('cncPanel');

    if (!trigger || !panel) return;

    trigger.addEventListener('click', function (event) {

        event.stopPropagation();

        const open = panel.classList.toggle('open');

        trigger.setAttribute(
            'aria-expanded',
            open ? 'true' : 'false'
        );

    });

    document.addEventListener('click', function (event) {

        if (
            !panel.contains(event.target) &&
            !trigger.contains(event.target)
        ) {

            panel.classList.remove('open');

            trigger.setAttribute(
                'aria-expanded',
                'false'
            );

        }

    });

})();


/* ================================================================
   USER DROPDOWN
================================================================ */

(function () {

    const trigger = document.getElementById('userPill');
    const dropdown = document.getElementById('userDropdown');

    if (!trigger || !dropdown) return;

    trigger.addEventListener('click', function (event) {

        event.stopPropagation();

        const open = dropdown.classList.toggle('open');

        trigger.setAttribute(
            'aria-expanded',
            open ? 'true' : 'false'
        );

    });

    document.addEventListener('click', function (event) {

        if (
            !dropdown.contains(event.target) &&
            !trigger.contains(event.target)
        ) {

            dropdown.classList.remove('open');

            trigger.setAttribute(
                'aria-expanded',
                'false'
            );

        }

    });

})();


/* ================================================================
   MOBILE NAV
================================================================ */

(function () {

    const toggler = document.getElementById('cnToggler');
    const nav = document.getElementById('cn-primary-nav');

    if (!toggler || !nav) return;

    toggler.addEventListener('click', function () {

        const open = nav.classList.toggle('mobile-open');

        toggler.setAttribute(
            'aria-expanded',
            open ? 'true' : 'false'
        );

    });

})();


/* ================================================================
   EXPLORE FLYOUT
================================================================ */

(function () {

    const overlay =
        document.getElementById('cnf-overlay');

    const panel =
        document.getElementById('cnf-offcanvas');

    if (!overlay || !panel) return;

    const CLOSE_DELAY = 240;

    const timers = {};


    function parentFlyout(id) {

        const element =
            document.getElementById(id);

        return element
            ? element.dataset.parentFlyout || null
            : null;

    }


    function cancelClose(id) {

        if (timers[id]) {

            clearTimeout(timers[id]);

            delete timers[id];

        }

        const parent =
            parentFlyout(id);

        if (parent) {

            cancelClose(parent);

        }

    }


    function closeFlyout(id) {

        const element =
            document.getElementById(id);

        if (!element) return;

        element.classList.remove('open');

        document
            .querySelectorAll(
                '[data-opens-flyout="' + id + '"]'
            )
            .forEach(function (item) {

                item.classList.remove('active');

            });

        document
            .querySelectorAll(
                '[data-parent-flyout="' + id + '"]'
            )
            .forEach(function (child) {

                if (child.id) {

                    closeFlyout(child.id);

                }

            });

    }


    function scheduleClose(id) {

        if (timers[id]) {

            clearTimeout(timers[id]);

        }

        timers[id] = setTimeout(function () {

            closeFlyout(id);

            delete timers[id];

        }, CLOSE_DELAY);

    }


    function positionFlyout(
        flyout,
        trigger,
        type
    ) {

        const triggerRect =
            trigger.getBoundingClientRect();

        if (type === 'cat') {

            const panelRect =
                panel.getBoundingClientRect();

            flyout.style.top =
                triggerRect.top + 'px';

            flyout.style.left =
                (panelRect.right + 6) + 'px';

            flyout.style.right = '';

        } else {

            const parent =
                trigger.closest('.cnf-flyout');

            const parentRect =
                parent
                    ? parent.getBoundingClientRect()
                    : triggerRect;

            flyout.style.top =
                triggerRect.top + 'px';

            flyout.style.left =
                (parentRect.right + 6) + 'px';

            flyout.style.right = '';

        }


        requestAnimationFrame(function () {

            const rect =
                flyout.getBoundingClientRect();

            if (rect.right > window.innerWidth - 12) {

                flyout.style.left = '';

                flyout.style.right = '12px';

            }

            if (rect.bottom > window.innerHeight - 12) {

                flyout.style.top =
                    Math.max(
                        12,
                        window.innerHeight -
                        rect.height -
                        12
                    ) + 'px';

            }

        });

    }


    window.cnfHoverOpen =
        function (flyoutId, trigger, type) {

            cancelClose(flyoutId);

            const flyout =
                document.getElementById(flyoutId);

            if (!flyout) return;

            document
                .querySelectorAll('.cnf-flyout.open')
                .forEach(function (item) {

                    if (
                        item.id !== flyoutId &&
                        (
                            type === 'cat' ||
                            item.dataset.parentFlyout ===
                            flyout.dataset.parentFlyout
                        )
                    ) {

                        closeFlyout(item.id);

                    }

                });

            positionFlyout(
                flyout,
                trigger,
                type
            );

            flyout.classList.add('open');

            trigger.classList.add('active');

        };


    window.cnfHoverClose =
        function (flyoutId) {

            scheduleClose(flyoutId);

        };


    window.cnfCancelClose =
        function (flyoutId) {

            cancelClose(flyoutId);

        };


    window.cnfOpenOffcanvas =
        function () {

            overlay.classList.add('open');

            panel.classList.add('open');

            document.body.classList.add(
                'cn-menu-open'
            );

            const trigger =
                document.getElementById(
                    'cnfExploreBtn'
                );

            if (trigger) {

                trigger.setAttribute(
                    'aria-expanded',
                    'true'
                );

            }

        };


    window.cnfCloseOffcanvas =
        function () {

            overlay.classList.remove('open');

            panel.classList.remove('open');

            document.body.classList.remove(
                'cn-menu-open'
            );

            document
                .querySelectorAll(
                    '.cnf-flyout.open'
                )
                .forEach(function (item) {

                    closeFlyout(item.id);

                });

            const trigger =
                document.getElementById(
                    'cnfExploreBtn'
                );

            if (trigger) {

                trigger.setAttribute(
                    'aria-expanded',
                    'false'
                );

            }

        };


    window.cnfToggleCat =
        function (event, catId) {

            const flyoutId =
                'cnf-subflyout-' + catId;

            const flyout =
                document.getElementById(flyoutId);

            if (!flyout) return;

            if (flyout.classList.contains('open')) {

                closeFlyout(flyoutId);

                return;

            }

            document
                .querySelectorAll(
                    '.cnf-sub-flyout.open'
                )
                .forEach(function (item) {

                    if (item.id !== flyoutId) {

                        closeFlyout(item.id);

                    }

                });

            positionFlyout(
                flyout,
                event.currentTarget,
                'cat'
            );

            flyout.classList.add('open');

            event.currentTarget.classList.add(
                'active'
            );

        };


    window.cnfToggleSub =
        function (event, subId) {

            const flyoutId =
                'cnf-flyout-' + subId;

            const flyout =
                document.getElementById(flyoutId);

            if (!flyout) return;

            if (flyout.classList.contains('open')) {

                closeFlyout(flyoutId);

                return;

            }

            const parent =
                event.currentTarget.closest(
                    '.cnf-flyout'
                );

            if (parent) {

                document
                    .querySelectorAll(
                        '[data-parent-flyout="' +
                        parent.id +
                        '"].open'
                    )
                    .forEach(function (item) {

                        if (item.id !== flyoutId) {

                            closeFlyout(item.id);

                        }

                    });

            }

            positionFlyout(
                flyout,
                event.currentTarget,
                'sub'
            );

            flyout.classList.add('open');

            event.currentTarget.classList.add(
                'active'
            );

        };


    overlay.addEventListener(
        'click',
        window.cnfCloseOffcanvas
    );


    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {

                window.cnfCloseOffcanvas();

            }

        }
    );

})();

</script>