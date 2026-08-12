{{--
    Connector Header
    -----------------
    Assumed route names — rename to match your actual route list where they differ:
    home.service_categories, home.services, home.service_provider, home.jobs, home.blogs, home.contact,
    home.about, home.how_it_works, home.careers, home.trust_safety, home.help_center,
    home.news (news/updates listing), home.ai_assistant (AI assistant landing/chat page)

    Optional data you can pass from the controller (falls back to demo data if not set):
    $exploreCategories  = [ ['name' => '', 'icon' => '', 'subcategories' => [ ['name' => '', 'locations' => ['', ...]] ]] ]
    $providerCategories = [ ['name' => '', 'locations' => ['', ...]] ]
    $latestNews         = [ ['title' => '', 'url' => '', 'date' => ''] ]
    $latestJobs         = [ ['title' => '', 'url' => '', 'location' => ''] ]

    The "Explore" panel now follows the same 3-level hover-flyout pattern used
    by the Terra header (offcanvas -> flyout -> flyout), instead of the old
    click-to-expand accordion. The "Company" dropdown has been pulled out into
    its own partial: partials/company-dropdown.blade.php, so it can be edited
    on its own. The mobile hamburger toggle now sits at the end of the actions
    row instead of inside the nav.
--}}

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
['name' => 'Home Services Providers', 'locations' => ['Kigali', 'Musanze', 'Huye', 'Rubavu']],
['name' => 'Event Providers', 'locations' => ['Kigali', 'Huye']],
['name' => 'Professional Providers', 'locations' => ['Kigali', 'Muhanga']],
['name' => 'Beauty & Wellness Providers', 'locations' => ['Kigali', 'Musanze']],
];

$latestNews = $latestNews ?? [
['title' => 'Connector launches verified provider badges', 'url' => '#', 'date' => 'Aug 2026'],
['title' => 'How to price your services competitively', 'url' => '#', 'date' => 'Jul 2026'],
['title' => 'New payment options now supported', 'url' => '#', 'date' => 'Jul 2026'],
];

$latestJobs = $latestJobs ?? [
['title' => 'Field Operations Coordinator', 'url' => '#', 'location' => 'Kigali'],
['title' => 'Customer Support Associate', 'url' => '#', 'location' => 'Remote'],
['title' => 'Partnerships Manager', 'url' => '#', 'location' => 'Kigali'],
];
@endphp

<header class="cn-header" id="cn-header">
    <div class="cn-inner">

        {{-- Logo --}}
        <a href="/" class="cn-logo">
            <img src="{{ asset('asset/images/logo/logo-connector-header.png') }}" alt="Connector" width="150">
        </a>

        {{-- Explore (Terra-style flyout offcanvas trigger) --}}
        <button type="button" class="cn-explore-btn" id="cnfExploreBtn" aria-haspopup="true" aria-expanded="false" aria-controls="cnf-offcanvas" onclick="cnfOpenOffcanvas()">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="3" width="7" height="7" rx="1.5" />
                <rect x="14" y="3" width="7" height="7" rx="1.5" />
                <rect x="14" y="14" width="7" height="7" rx="1.5" />
                <rect x="3" y="14" width="7" height="7" rx="1.5" />
            </svg>
            <span>Explore</span>
        </button>

        {{-- Nav --}}
        <nav class="cn-nav" id="cnNav">
            <ul class="cn-nav-list" id="cnNavList">
                <li><a href="{{ route('home.service_provider') }}" class="cn-link">Providers</a></li>
                <li><a href="{{ route('home.jobs') }}" class="cn-link">Jobs</a></li>

                {{-- Company dropdown lives in its own partial now --}}
                <li>
                    {{--
    Company Dropdown (Connector)
    -----------------------------
    Extracted from the main header so it can be edited on its own without
    touching header-connector.blade.php. Include it wherever the "Company"
    nav item should appear, e.g.:

        <li>@include('partials.company-dropdown')</li>

    Assumed route names — rename to match your actual route list where they differ:
    about, faq, home.jobs, home.blogs, home.contact, policy, register
--}}

                    <div class="cnc-wrap" id="cncCompanyWrap">
                        <button type="button" class="cn-link cnc-trigger" id="cncTrigger" aria-haspopup="true" aria-expanded="false">
                            Company
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </button>

                        <div class="cnc-panel" id="cncPanel">
                            <div class="cnc-cols">
                                <div class="cnc-col">
                                    <h4>Company</h4>
                                    <a href="{{ route('about') }}">About Us</a>
                                    <a href="{{ route('faq') }}">How It Works</a>
                                    <a href="{{ route('home.jobs') }}">Careers</a>
                                    <a href="{{ route('home.blogs') }}">Blog</a>
                                </div>
                                <div class="cnc-col">
                                    <h4>Support</h4>
                                    <a href="{{ route('faq') }}">Help Center</a>
                                    <a href="{{ route('home.contact') }}">Contact Us</a>
                                    <a href="{{ route('policy') }}">Trust &amp; Safety</a>
                                </div>
                                <div class="cnc-col cnc-promo">
                                    <h4>Become a Provider</h4>
                                    <p>List your services and reach customers across Rwanda.</p>
                                    <a href="{{ route('register') }}" class="cn-btn-solid cn-btn-sm">Get Started</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        .cnc-wrap {
                            position: relative;
                        }

                        .cnc-trigger {
                            display: flex;
                            align-items: center;
                            gap: 4px;
                        }

                        .cnc-panel {
                            display: none;
                            position: absolute;
                            top: calc(100% + 12px);
                            left: 50%;
                            transform: translateX(-50%);
                            background: #fff;
                            border: 1px solid var(--cn-border, rgba(37, 64, 53, .14));
                            border-radius: 16px;
                            box-shadow: 0 16px 48px rgba(37, 64, 53, .16);
                            padding: 24px;
                            width: 520px;
                            z-index: 1100;
                        }

                        .cnc-panel.open {
                            display: block;
                        }

                        .cnc-cols {
                            display: grid;
                            grid-template-columns: 1fr 1fr 1.1fr;
                            gap: 24px;
                        }

                        .cnc-col h4 {
                            font-size: 12px;
                            font-weight: 700;
                            text-transform: uppercase;
                            letter-spacing: .04em;
                            color: var(--cn-green, #6B9080);
                            margin-bottom: 12px;
                        }

                        .cnc-col a {
                            display: block;
                            font-size: 14px;
                            color: var(--cn-dark, #254035);
                            text-decoration: none;
                            padding: 7px 0;
                            transition: color .15s;
                        }

                        .cnc-col a:hover {
                            color: var(--cn-green, #6B9080);
                        }

                        .cnc-promo {
                            background: var(--cn-light, rgba(107, 144, 128, .1));
                            border-radius: 12px;
                            padding: 16px;
                            margin: -4px;
                        }

                        .cnc-promo p {
                            font-size: 13px;
                            color: #4a5f56;
                            margin: 0 0 14px;
                            line-height: 1.5;
                        }

                        @media (max-width: 992px) {
                            .cnc-panel {
                                position: static;
                                transform: none;
                                width: auto;
                                box-shadow: none;
                                border: none;
                                padding: 8px 0 0;
                            }

                            .cnc-cols {
                                grid-template-columns: 1fr;
                                gap: 14px;
                            }

                            .cnc-promo {
                                margin: 0;
                            }
                        }
                    </style>

                    <script>
                        (function() {
                            const trigger = document.getElementById('cncTrigger');
                            const panel = document.getElementById('cncPanel');
                            if (!trigger || !panel) return;

                            trigger.addEventListener('click', (e) => {
                                e.stopPropagation();
                                const isOpen = panel.classList.toggle('open');
                                trigger.setAttribute('aria-expanded', isOpen);
                            });

                            document.addEventListener('click', () => {
                                panel.classList.remove('open');
                                trigger.setAttribute('aria-expanded', 'false');
                            });
                        })();
                    </script>
                </li>
            </ul>
        </nav>

        {{-- Big search --}}
        <form action="{{ route('services.search') }}" class="cn-search-bar">
            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35" />
            </svg>
            <input type="text" name="query" placeholder="Search services, providers, categories...">
            <button type="submit" class="cn-search-submit">Search</button>
        </form>

        {{-- Auth actions --}}
        <div class="cn-actions">

            {{-- AI Assistant --}}
            <a href="#" class="cn-ai-btn" title="AI Assistant">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M12 3v3M12 18v3M4.2 4.2l2.1 2.1M17.7 17.7l2.1 2.1M3 12h3M18 12h3M4.2 19.8l2.1-2.1M17.7 6.3l2.1-2.1" />
                    <circle cx="12" cy="12" r="3.2" />
                </svg>
                <span>AI Assistant</span>
            </a>

            @if(Route::has('login'))
            @auth
            @php $utype = Auth::user()->utype; @endphp
            <div class="cn-user-menu">
                <button class="cn-user-pill" id="userPill">
                    <img src="{{ asset('admin/img/undraw_profile.svg') }}" alt="avatar">
                    <span>{{ Str::words(auth()->user()->name, 1, '') }}</span>
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>
                <ul class="cn-dropdown" id="userDropdown">
                    @if($utype === 'ADM')
                    <li><a href="{{ route('admin.dashboard') }}" target="_blank">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                            </svg>
                            Dashboard
                        </a></li>
                    @elseif($utype === 'SVP')
                    <li><a href="{{ route('sprovider.dashboard') }}" target="_blank">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                            </svg>
                            Dashboard
                        </a></li>
                    @else
                    <li><a href="{{ route('customer.dashboard') }}" target="_blank">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                            </svg>
                            Dashboard
                        </a></li>
                    @endif
                    <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('cn-logout-form').submit();">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
            <form id="cn-logout-form" method="POST" action="{{ route('logout') }}" style="display:none">@csrf</form>
            @else
            <div class="cn-auth-group">
                <a href="#" class="cn-btn-outline" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                <a href="{{ route('register') }}" class="cn-btn-solid">Get Started</a>
            </div>
            @endauth
            @endif

            {{-- Mobile toggler — moved to the end of the actions row --}}
            <button class="cn-toggler" id="cnToggler" aria-label="Toggle navigation">
                <span></span><span></span><span></span>
            </button>
        </div>

    </div>
</header>

{{-- ============ Explore Off-canvas — Terra-style hover flyout ============ --}}
<div class="cnf-overlay" id="cnf-overlay" onclick="cnfCloseOffcanvas()"></div>
<aside class="cnf-offcanvas" id="cnf-offcanvas" aria-label="Explore Connector">
    <div class="cnf-offcanvas-head">
        <h3 class="cnf-offcanvas-title">Explore Connector</h3>
        <button class="cnf-offcanvas-close" type="button" onclick="cnfCloseOffcanvas()" aria-label="Close">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="cnf-offcanvas-body">
        <div class="cnf-cat-list">

            {{-- Service category top-level items --}}
            @forelse($exploreCategories as $ci => $cat)
            <div class="cnf-cat-row">
                <button type="button" class="cnf-cat-item"
                    data-opens-flyout="cnf-subflyout-cat-{{ $ci }}"
                    onclick="cnfToggleCat(event, 'cat-{{ $ci }}')"
                    onmouseenter="cnfHoverOpen('cnf-subflyout-cat-{{ $ci }}', this, 'cat')"
                    onmouseleave="cnfHoverClose('cnf-subflyout-cat-{{ $ci }}')">
                    {{ $cat['name'] }}
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </button>
            </div>
            @empty
            <div class="cnf-flyout-empty">No service categories yet</div>
            @endforelse

            {{-- Providers --}}
            <div class="cnf-cat-row">
                <button type="button" class="cnf-cat-item"
                    data-opens-flyout="cnf-subflyout-providers"
                    onclick="cnfToggleCat(event, 'providers')"
                    onmouseenter="cnfHoverOpen('cnf-subflyout-providers', this, 'cat')"
                    onmouseleave="cnfHoverClose('cnf-subflyout-providers')">
                    Providers
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </button>
            </div>

            {{-- Latest Updates & News --}}
            <div class="cnf-cat-row">
                <button type="button" class="cnf-cat-item"
                    data-opens-flyout="cnf-subflyout-updates"
                    onclick="cnfToggleCat(event, 'updates')"
                    onmouseenter="cnfHoverOpen('cnf-subflyout-updates', this, 'cat')"
                    onmouseleave="cnfHoverClose('cnf-subflyout-updates')">
                    Latest Updates & News
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </button>
            </div>

        </div>
    </div>
</aside>

{{-- LEVEL 2 flyouts — each explore category's subcategories --}}
@foreach($exploreCategories as $ci => $cat)
<div class="cnf-flyout cnf-sub-flyout" id="cnf-subflyout-cat-{{ $ci }}"
    onmouseenter="cnfCancelClose('cnf-subflyout-cat-{{ $ci }}')"
    onmouseleave="cnfHoverClose('cnf-subflyout-cat-{{ $ci }}')">
    @forelse($cat['subcategories'] as $si => $sub)
    <button type="button" class="cnf-flyout-item"
        data-opens-flyout="cnf-flyout-cat-{{ $ci }}-{{ $si }}"
        onclick="cnfToggleSub(event, 'cat-{{ $ci }}-{{ $si }}')"
        onmouseenter="cnfHoverOpen('cnf-flyout-cat-{{ $ci }}-{{ $si }}', this, 'sub')"
        onmouseleave="cnfHoverClose('cnf-flyout-cat-{{ $ci }}-{{ $si }}')">
        {{ $sub['name'] }}
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18l6-6-6-6" />
        </svg>
    </button>
    @empty
    <div class="cnf-flyout-empty">No sub-categories yet</div>
    @endforelse
</div>
@endforeach

{{-- LEVEL 3 flyouts — each subcategory's locations --}}
@foreach($exploreCategories as $ci => $cat)
@foreach($cat['subcategories'] as $si => $sub)
<div class="cnf-flyout cnf-service-flyout" id="cnf-flyout-cat-{{ $ci }}-{{ $si }}"
    data-parent-flyout="cnf-subflyout-cat-{{ $ci }}"
    onmouseenter="cnfCancelClose('cnf-flyout-cat-{{ $ci }}-{{ $si }}')"
    onmouseleave="cnfHoverClose('cnf-flyout-cat-{{ $ci }}-{{ $si }}')">
    @forelse($sub['locations'] as $loc)
    <a href="{{ route('home.services', ['category' => $cat['name'], 'sub' => $sub['name'], 'location' => $loc]) }}" class="cnf-flyout-item">
        {{ $loc }}
    </a>
    @empty
    <div class="cnf-flyout-empty">No locations yet</div>
    @endforelse
</div>
@endforeach
@endforeach

{{-- LEVEL 2 flyout — Providers → provider categories --}}
<div class="cnf-flyout cnf-sub-flyout" id="cnf-subflyout-providers"
    onmouseenter="cnfCancelClose('cnf-subflyout-providers')"
    onmouseleave="cnfHoverClose('cnf-subflyout-providers')">
    @forelse($providerCategories as $pi => $pcat)
    <button type="button" class="cnf-flyout-item"
        data-opens-flyout="cnf-flyout-provider-{{ $pi }}"
        onclick="cnfToggleSub(event, 'provider-{{ $pi }}')"
        onmouseenter="cnfHoverOpen('cnf-flyout-provider-{{ $pi }}', this, 'sub')"
        onmouseleave="cnfHoverClose('cnf-flyout-provider-{{ $pi }}')">
        {{ $pcat['name'] }}
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18l6-6-6-6" />
        </svg>
    </button>
    @empty
    <div class="cnf-flyout-empty">No provider categories yet</div>
    @endforelse
</div>

{{-- LEVEL 3 flyouts — each provider category's locations --}}
@foreach($providerCategories as $pi => $pcat)
<div class="cnf-flyout cnf-service-flyout" id="cnf-flyout-provider-{{ $pi }}"
    data-parent-flyout="cnf-subflyout-providers"
    onmouseenter="cnfCancelClose('cnf-flyout-provider-{{ $pi }}')"
    onmouseleave="cnfHoverClose('cnf-flyout-provider-{{ $pi }}')">
    @forelse($pcat['locations'] as $loc)
    <a href="{{ route('home.service_provider', ['category' => $pcat['name'], 'location' => $loc]) }}" class="cnf-flyout-item">
        {{ $loc }}
    </a>
    @empty
    <div class="cnf-flyout-empty">No locations yet</div>
    @endforelse
</div>
@endforeach

{{-- Latest Updates & News flyout — direct links, no third level --}}
<div class="cnf-flyout cnf-sub-flyout cnf-updates-flyout" id="cnf-subflyout-updates"
    onmouseenter="cnfCancelClose('cnf-subflyout-updates')"
    onmouseleave="cnfHoverClose('cnf-subflyout-updates')">

    <div class="cnf-flyout-label">News</div>
    @forelse($latestNews as $item)
    <a href="{{ $item['url'] }}" class="cnf-flyout-item cnf-flyout-item-meta">
        <span>{{ $item['title'] }}</span>
        <em>{{ $item['date'] }}</em>
    </a>
    @empty
    <div class="cnf-flyout-empty">No news yet</div>
    @endforelse
    <a href="{{ route('home.blogs') }}" class="cnf-flyout-item cnf-flyout-viewall">View all news →</a>

    <div class="cnf-flyout-divider"></div>

    <div class="cnf-flyout-label">Jobs</div>
    @forelse($latestJobs as $item)
    <a href="{{ $item['url'] }}" class="cnf-flyout-item cnf-flyout-item-meta">
        <span>{{ $item['title'] }}</span>
        <em>{{ $item['location'] }}</em>
    </a>
    @empty
    <div class="cnf-flyout-empty">No jobs yet</div>
    @endforelse
    <a href="{{ route('home.jobs') }}" class="cnf-flyout-item cnf-flyout-viewall">View all jobs →</a>
</div>

{{-- ============ Login Modal ============ --}}
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px">
        <div class="modal-content cn-modal">
            <button type="button" class="cn-modal-close" data-bs-dismiss="modal" aria-label="Close">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
            <div class="cn-modal-header">
                <h2>Welcome back</h2>
                <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
            </div>
            <form method="POST" action="{{ route('login') }}" class="cn-modal-form">
                @csrf
                <div class="cn-field">
                    <label for="login_email">Email</label>
                    <input type="email" id="login_email" name="email" value="{{ old('email') }}" required autofocus
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="you@example.com">
                    @error('email')
                    <span class="cn-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="cn-field">
                    <label for="login_password">Password</label>
                    <input type="password" id="login_password" name="password" required autocomplete="current-password"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="••••••••">
                    @error('password')
                    <span class="cn-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="cn-field-row">
                    <label class="cn-checkbox">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Keep me logged in</span>
                    </label>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="cn-link-muted">Forgot password?</a>
                    @endif
                </div>
                <button type="submit" class="cn-btn-solid cn-btn-block">Login</button>
            </form>
        </div>
    </div>
</div>

{{-- ============ Styles ============ --}}
<style>
    :root {
        --cn-green: #6B9080;
        --cn-dark: #254035;
        --cn-white: #fff;
        --cn-border: rgba(37, 64, 53, .14);
        --cn-light: rgba(107, 144, 128, .1);
        --cnf-t: .2s cubic-bezier(.4, 0, .2, 1);
    }

    /* ---- Header ---- */
    .cn-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1050;
        padding: 0 40px;
        transition: background .35s ease, box-shadow .35s ease, padding .35s ease;
        background: var(--cn-dark);
    }

    .cn-header.scrolled {
        background: #fff;
        box-shadow: 0 2px 24px rgba(37, 64, 53, .1);
    }

    .cn-inner {
        display: flex;
        align-items: center;
        height: 76px;
        gap: 14px;
    }

    .cn-logo img {
        height: 36px;
    }

    /* ---- Explore button ---- */
    .cn-explore-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--cn-green);
        color: #fff;
        border: none;
        border-radius: 24px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background .2s, transform .15s;
        flex-shrink: 0;
    }

    .cn-explore-btn:hover {
        background: #5a7a6c;
    }

    .cn-explore-btn:active {
        transform: scale(.97);
    }

    /* ---- Nav ---- */
    .cn-nav {
        display: flex;
        align-items: center;
    }

    .cn-nav-list {
        display: flex;
        align-items: center;
        gap: 2px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .cn-link {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 14px;
        font-weight: 500;
        padding: 8px 13px;
        border-radius: 8px;
        color: rgba(255, 255, 255, .9);
        text-decoration: none;
        background: none;
        border: none;
        cursor: pointer;
        transition: background .2s, color .2s;
        white-space: nowrap;
        font-family: inherit;
    }

    .cn-header.scrolled .cn-link {
        color: #254035;
    }

    .cn-link:hover,
    .cn-header.scrolled .cn-link:hover {
        background: var(--cn-light);
        color: var(--cn-dark);
    }

    .cn-toggler {
        display: none;
    }

    /* ---- Search bar ---- */
    .cn-search-bar {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 26px;
        padding: 6px 8px 6px 18px;
        transition: all .3s;
        color: rgba(255, 255, 255, .75);
        max-width: 480px;
        min-width: 160px;
    }

    .cn-header.scrolled .cn-search-bar {
        background: var(--cn-light);
        border-color: rgba(107, 144, 128, .25);
        color: var(--cn-green);
    }

    .cn-search-bar input {
        flex: 1;
        background: none;
        border: none;
        outline: none;
        font-size: 14px;
        color: #fff;
        min-width: 0;
    }

    .cn-header.scrolled .cn-search-bar input {
        color: #254035;
    }

    .cn-search-bar input::placeholder {
        color: rgba(255, 255, 255, .55);
    }

    .cn-header.scrolled .cn-search-bar input::placeholder {
        color: #9bb5aa;
    }

    .cn-search-submit {
        flex-shrink: 0;
        background: var(--cn-green);
        color: #fff;
        border: none;
        border-radius: 20px;
        padding: 9px 18px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s;
    }

    .cn-search-submit:hover {
        background: #254035;
    }

    /* ---- Auth actions ---- */
    .cn-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .cn-auth-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* AI assistant */
    .cn-ai-btn {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        font-weight: 600;
        padding: 9px 16px;
        border-radius: 24px;
        border: 1.5px solid var(--cn-green);
        color: var(--cn-green);
        background: rgba(107, 144, 128, .12);
        text-decoration: none;
        white-space: nowrap;
        transition: all .2s;
    }

    .cn-header.scrolled .cn-ai-btn {
        background: var(--cn-light);
    }

    .cn-ai-btn:hover {
        background: var(--cn-green);
        color: #fff;
    }

    .cn-btn-outline {
        font-size: 13px;
        font-weight: 600;
        padding: 8px 20px;
        border-radius: 24px;
        border: 1.5px solid rgba(255, 255, 255, .5);
        color: #fff;
        text-decoration: none;
        transition: all .25s;
        white-space: nowrap;
    }

    .cn-header.scrolled .cn-btn-outline {
        color: #254035;
        border-color: rgba(37, 64, 53, .3);
    }

    .cn-btn-outline:hover {
        background: rgba(255, 255, 255, .12);
    }

    .cn-header.scrolled .cn-btn-outline:hover {
        background: var(--cn-light);
    }

    .cn-btn-solid {
        font-size: 13px;
        font-weight: 600;
        padding: 9px 22px;
        border-radius: 24px;
        background: var(--cn-green);
        color: #fff;
        border: none;
        text-decoration: none;
        cursor: pointer;
        transition: background .25s;
        white-space: nowrap;
        display: inline-block;
    }

    .cn-btn-solid:hover {
        background: var(--cn-dark);
        color: #fff;
    }

    .cn-btn-sm {
        padding: 8px 16px;
        font-size: 12px;
    }

    .cn-btn-block {
        width: 100%;
        text-align: center;
        padding: 12px;
        font-size: 15px;
        border-radius: 10px;
    }

    /* ---- User pill & dropdown ---- */
    .cn-user-menu {
        position: relative;
    }

    .cn-user-pill {
        display: flex;
        align-items: center;
        gap: 8px;
        background: none;
        border: 1.5px solid rgba(255, 255, 255, .3);
        border-radius: 24px;
        padding: 5px 14px 5px 5px;
        cursor: pointer;
        transition: all .2s;
    }

    .cn-header.scrolled .cn-user-pill {
        border-color: var(--cn-border);
    }

    .cn-user-pill img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
    }

    .cn-user-pill span {
        font-size: 13px;
        font-weight: 500;
        color: #fff;
    }

    .cn-header.scrolled .cn-user-pill span {
        color: #254035;
    }

    .cn-user-pill svg {
        color: rgba(255, 255, 255, .6);
    }

    .cn-header.scrolled .cn-user-pill svg {
        color: var(--cn-green);
    }

    .cn-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        background: #fff;
        border: 1px solid var(--cn-border);
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(37, 64, 53, .12);
        min-width: 180px;
        padding: 6px;
        list-style: none;
        margin: 0;
        z-index: 1100;
    }

    .cn-dropdown.open {
        display: block;
    }

    .cn-dropdown li a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        font-size: 14px;
        color: #254035;
        border-radius: 8px;
        text-decoration: none;
        transition: background .15s;
    }

    .cn-dropdown li a:hover {
        background: var(--cn-light);
    }

    .cn-dropdown li:last-child a {
        color: #c0392b;
    }

    .cn-dropdown li:last-child a:hover {
        background: #fdf0ee;
    }

    /* ---- Login modal ---- */
    .cn-modal {
        border: none;
        border-radius: 18px;
        padding: 40px;
        position: relative;
    }

    .cn-modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        background: rgba(107, 144, 128, .1);
        border: none;
        border-radius: 50%;
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #254035;
        cursor: pointer;
        transition: background .2s;
    }

    .cn-modal-close:hover {
        background: rgba(107, 144, 128, .2);
    }

    .cn-modal-header {
        margin-bottom: 28px;
    }

    .cn-modal-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: #254035;
        margin-bottom: 6px;
    }

    .cn-modal-header p {
        font-size: 14px;
        color: #888;
    }

    .cn-modal-header a {
        color: #6B9080;
        font-weight: 600;
        text-decoration: none;
    }

    .cn-modal-form {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .cn-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .cn-field label {
        font-size: 13px;
        font-weight: 600;
        color: #254035;
    }

    .cn-field input {
        padding: 11px 14px;
        border: 1.5px solid #dde8e4;
        border-radius: 10px;
        font-size: 14px;
        color: #254035;
        outline: none;
        transition: border .2s;
    }

    .cn-field input:focus {
        border-color: #6B9080;
    }

    .cn-field input.is-invalid {
        border-color: #e74c3c;
    }

    .cn-error {
        font-size: 12px;
        color: #e74c3c;
    }

    .cn-field-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .cn-checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #555;
        cursor: pointer;
    }

    .cn-link-muted {
        font-size: 13px;
        color: #6B9080;
        text-decoration: none;
        font-weight: 500;
    }

    /* ================================================
       EXPLORE — Terra-style hover-flyout off-canvas
       (prefixed cnf- to avoid clashing with cn- header)
       ================================================ */
    .cnf-overlay {
        position: fixed;
        inset: 0;
        z-index: 1199;
        background: rgba(37, 64, 53, .5);
        backdrop-filter: blur(3px);
        opacity: 0;
        visibility: hidden;
        transition: opacity var(--cnf-t), visibility var(--cnf-t);
    }

    .cnf-overlay.open {
        opacity: 1;
        visibility: visible;
    }

    .cnf-offcanvas {
        position: fixed;
        top: 0;
        bottom: 0;
        left: -100%;
        z-index: 1200;
        width: min(340px, 92vw);
        background: #fff;
        display: flex;
        flex-direction: column;
        box-shadow: 20px 0 60px rgba(0, 0, 0, .25);
        transition: left .32s cubic-bezier(.4, 0, .2, 1);
    }

    .cnf-offcanvas.open {
        left: 0;
    }

    .cnf-offcanvas-head {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 20px 22px;
        background: var(--cn-dark);
        color: #fff;
        flex-shrink: 0;
    }

    .cnf-offcanvas-title {
        flex: 1;
        min-width: 0;
        font-size: 17px;
        font-weight: 700;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cnf-offcanvas-close {
        width: 32px;
        height: 32px;
        min-width: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .12);
        border: none;
        display: grid;
        place-items: center;
        cursor: pointer;
        color: #fff;
        transition: background var(--cnf-t);
    }

    .cnf-offcanvas-close:hover {
        background: var(--cn-green);
    }

    .cnf-offcanvas-close svg {
        width: 16px;
        height: 16px;
    }

    .cnf-offcanvas-body {
        flex: 1;
        overflow-y: auto;
    }

    .cnf-cat-list {
        padding: 8px;
    }

    .cnf-cat-row {
        position: relative;
    }

    .cnf-cat-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        width: 100%;
        padding: 13px 14px;
        border: none;
        background: none;
        border-radius: 10px;
        font-size: 14.5px;
        font-weight: 600;
        color: var(--cn-dark);
        text-align: left;
        text-decoration: none;
        cursor: pointer;
        transition: background var(--cnf-t), color var(--cnf-t);
    }

    .cnf-cat-item:hover,
    .cnf-cat-item.active {
        background: var(--cn-light);
        color: var(--cn-green);
    }

    .cnf-cat-item svg {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
        color: rgba(37, 64, 53, .35);
        transition: color var(--cnf-t);
    }

    .cnf-cat-item:hover svg,
    .cnf-cat-item.active svg {
        color: var(--cn-green);
    }

    .cnf-flyout {
        position: fixed;
        z-index: 1250;
        min-width: 230px;
        max-width: 300px;
        max-height: 70vh;
        overflow-y: auto;
        background: #fff;
        border-radius: 12px;
        border: 1px solid var(--cn-border);
        box-shadow: 0 20px 50px rgba(37, 64, 53, .2);
        padding: 8px;
        opacity: 0;
        visibility: hidden;
        transform: translateX(-6px);
        transition: opacity .16s ease, transform .16s ease, visibility .16s ease;
    }

    .cnf-flyout.open {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: translateX(0);
    }

    .cnf-flyout:not(.open) {
        pointer-events: none;
    }

    .cnf-flyout-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        width: 100%;
        padding: 10px 11px;
        border: none;
        background: none;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 500;
        color: var(--cn-dark);
        text-align: left;
        text-decoration: none;
        cursor: pointer;
        transition: background var(--cnf-t), color var(--cnf-t);
    }

    .cnf-flyout-item:hover,
    .cnf-flyout-item.active {
        background: var(--cn-light);
        color: var(--cn-green);
    }

    .cnf-flyout-item svg {
        width: 13px;
        height: 13px;
        flex-shrink: 0;
        color: rgba(37, 64, 53, .35);
        transition: color var(--cnf-t);
    }

    .cnf-flyout-item:hover svg {
        color: var(--cn-green);
    }

    .cnf-flyout-item-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 2px;
    }

    .cnf-flyout-item-meta em {
        font-style: normal;
        font-size: 11px;
        font-weight: 500;
        color: #8ba39a;
    }

    .cnf-flyout-viewall {
        font-weight: 700;
        color: var(--cn-green);
        justify-content: flex-start;
    }

    .cnf-flyout-label {
        padding: 8px 11px 4px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #8ba39a;
    }

    .cnf-flyout-divider {
        height: 1px;
        background: var(--cn-border);
        margin: 8px 4px;
    }

    .cnf-flyout-empty {
        padding: 12px 11px;
        font-size: 12.5px;
        color: rgba(37, 64, 53, .4);
    }

    .cnf-updates-flyout {
        min-width: 260px;
        max-width: 320px;
    }

    /* ---- Mobile ---- */
    @media (max-width: 1100px) {
        .cn-search-bar {
            display: none;
        }

        .cn-ai-btn span {
            display: none;
        }

        .cn-ai-btn {
            padding: 9px;
        }
    }

    @media (max-width: 992px) {
        .cn-header {
            padding: 0 18px;
        }

        .cn-explore-btn span {
            display: none;
        }

        .cn-explore-btn {
            padding: 10px;
        }

        .cn-toggler {
            display: flex;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
        }

        .cn-toggler span {
            display: block;
            width: 22px;
            height: 2px;
            background: #fff;
            border-radius: 2px;
            transition: .3s;
        }

        .cn-header.scrolled .cn-toggler span {
            background: #254035;
        }

        .cn-nav-list {
            display: none;
            position: absolute;
            top: 76px;
            left: 0;
            right: 0;
            background: #fff;
            flex-direction: column;
            align-items: stretch;
            padding: 12px 20px 20px;
            gap: 4px;
            box-shadow: 0 10px 30px rgba(37, 64, 53, .1);
        }

        .cn-nav-list.open {
            display: flex;
        }

        .cn-link {
            color: #254035 !important;
        }

        .cnf-offcanvas {
            width: 100%;
            max-width: 100%;
        }
    }
</style>

{{-- ============ Script ============ --}}
<script>
    (function() {
        const hdr = document.getElementById('cn-header');
        const pill = document.getElementById('userPill');
        const drop = document.getElementById('userDropdown');
        const toggler = document.getElementById('cnToggler');
        const navList = document.getElementById('cnNavList');

        // Sticky scroll
        const onScroll = () => {
            hdr.classList.toggle('scrolled', window.scrollY > 40);
        };
        window.addEventListener('scroll', onScroll, {
            passive: true
        });
        onScroll();

        // User dropdown
        if (pill && drop) {
            pill.addEventListener('click', (e) => {
                e.stopPropagation();
                drop.classList.toggle('open');
            });
        }

        document.addEventListener('click', () => {
            if (drop) drop.classList.remove('open');
        });

        // Mobile nav toggle (button now lives at the end of .cn-actions)
        if (toggler && navList) {
            toggler.addEventListener('click', () => navList.classList.toggle('open'));
        }
    })();

    /* ════════════════════════════════════════════
       EXPLORE OFFCANVAS — Terra-style 3-level flyout
       ════════════════════════════════════════════ */
    (function() {
        const overlay = document.getElementById('cnf-overlay');
        const panel = document.getElementById('cnf-offcanvas');
        if (!overlay || !panel) return;

        const CLOSE_DELAY = 280;
        const closeTimers = {};

        function getParentFlyoutId(flyoutId) {
            const el = document.getElementById(flyoutId);
            return el ? (el.dataset.parentFlyout || null) : null;
        }

        function cancelCloseChain(flyoutId) {
            if (closeTimers[flyoutId]) {
                clearTimeout(closeTimers[flyoutId]);
                delete closeTimers[flyoutId];
            }
            const parentId = getParentFlyoutId(flyoutId);
            if (parentId) cancelCloseChain(parentId);
        }

        function closeNow(flyoutId) {
            if (closeTimers[flyoutId]) {
                clearTimeout(closeTimers[flyoutId]);
                delete closeTimers[flyoutId];
            }
            const el = document.getElementById(flyoutId);
            if (el) el.classList.remove('open');

            document.querySelectorAll('[data-opens-flyout="' + flyoutId + '"]').forEach(t => {
                t.classList.remove('active');
            });

            document.querySelectorAll('[data-parent-flyout="' + flyoutId + '"]').forEach(child => {
                if (child.id) closeNow(child.id);
            });
        }

        function scheduleClose(flyoutId) {
            if (closeTimers[flyoutId]) clearTimeout(closeTimers[flyoutId]);
            closeTimers[flyoutId] = setTimeout(() => {
                closeNow(flyoutId);
                delete closeTimers[flyoutId];
            }, CLOSE_DELAY);
        }

        function closeSiblings(flyoutId, type) {
            if (type === 'cat') {
                document.querySelectorAll('.cnf-sub-flyout.open').forEach(f => {
                    if (f.id !== flyoutId) closeNow(f.id);
                });
            } else if (type === 'sub') {
                const parentId = getParentFlyoutId(flyoutId);
                if (parentId) {
                    document.querySelectorAll('[data-parent-flyout="' + parentId + '"].open').forEach(f => {
                        if (f.id !== flyoutId) closeNow(f.id);
                    });
                }
            }
        }

        function positionFlyout(flyout, triggerEl, type) {
            const rect = triggerEl.getBoundingClientRect();

            if (type === 'cat') {
                const offRect = panel.getBoundingClientRect();
                flyout.style.top = rect.top + 'px';
                flyout.style.left = (offRect.right + 4) + 'px';
                flyout.style.right = '';
            } else if (type === 'sub') {
                const parentFlyout = triggerEl.closest('.cnf-flyout');
                const parentRect = parentFlyout ? parentFlyout.getBoundingClientRect() : rect;
                flyout.style.top = rect.top + 'px';
                flyout.style.left = (parentRect.right + 4) + 'px';
                flyout.style.right = '';
            }

            requestAnimationFrame(() => {
                const fRect = flyout.getBoundingClientRect();
                if (fRect.right > window.innerWidth - 10) {
                    flyout.style.left = '';
                    flyout.style.right = '10px';
                }
                if (fRect.bottom > window.innerHeight - 10) {
                    flyout.style.top = Math.max(10, window.innerHeight - fRect.height - 10) + 'px';
                }
            });
        }

        window.cnfHoverOpen = function(flyoutId, triggerEl, type) {
            cancelCloseChain(flyoutId);

            const parentFlyout = triggerEl.closest('.cnf-flyout');
            if (parentFlyout && parentFlyout.id) {
                cancelCloseChain(parentFlyout.id);
            }

            const flyout = document.getElementById(flyoutId);
            if (!flyout) return;

            closeSiblings(flyoutId, type);

            positionFlyout(flyout, triggerEl, type);
            flyout.classList.add('open');
            triggerEl.classList.add('active');
        };

        window.cnfHoverClose = function(flyoutId) {
            scheduleClose(flyoutId);
        };

        window.cnfCancelClose = function(flyoutId) {
            cancelCloseChain(flyoutId);
        };

        window.cnfOpenOffcanvas = function() {
            overlay.classList.add('open');
            panel.classList.add('open');
            document.body.style.overflow = 'hidden';
        };

        window.cnfCloseOffcanvas = function() {
            overlay.classList.remove('open');
            panel.classList.remove('open');
            document.querySelectorAll('.cnf-flyout.open').forEach(f => f.classList.remove('open'));
            document.querySelectorAll('.cnf-cat-item.active, .cnf-flyout-item.active').forEach(el => el.classList.remove('active'));
            Object.keys(closeTimers).forEach(id => {
                clearTimeout(closeTimers[id]);
                delete closeTimers[id];
            });
            document.body.style.overflow = '';
        };

        window.cnfToggleCat = function(e, catId) {
            const flyoutId = 'cnf-subflyout-' + catId;
            const flyout = document.getElementById(flyoutId);
            if (!flyout) return;
            if (flyout.classList.contains('open')) {
                closeNow(flyoutId);
            } else {
                document.querySelectorAll('.cnf-sub-flyout.open').forEach(f => {
                    if (f.id !== flyoutId) closeNow(f.id);
                });
                positionFlyout(flyout, e.currentTarget, 'cat');
                flyout.classList.add('open');
                e.currentTarget.classList.add('active');
            }
        };

        window.cnfToggleSub = function(e, subId) {
            const flyoutId = 'cnf-flyout-' + subId;
            const flyout = document.getElementById(flyoutId);
            if (!flyout) return;
            if (flyout.classList.contains('open')) {
                closeNow(flyoutId);
            } else {
                const parentFlyout = e.currentTarget.closest('.cnf-flyout');
                if (parentFlyout) {
                    document.querySelectorAll('[data-parent-flyout="' + parentFlyout.id + '"].open').forEach(f => {
                        if (f.id !== flyoutId) closeNow(f.id);
                    });
                }
                positionFlyout(flyout, e.currentTarget, 'sub');
                flyout.classList.add('open');
                e.currentTarget.classList.add('active');
            }
        };

        document.addEventListener('click', function(e) {
            if (!panel.contains(e.target) &&
                !e.target.closest('.cnf-flyout') &&
                !e.target.closest('#cnfExploreBtn')) {
                document.querySelectorAll('.cnf-flyout.open').forEach(f => closeNow(f.id));
            }
        });
    })();
</script>