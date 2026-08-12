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

        {{-- Explore --}}
        <button type="button" class="cn-explore-btn" id="cnExploreBtn" aria-haspopup="true" aria-expanded="false" aria-controls="cnExploreCanvas">
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
            <button class="cn-toggler" id="cnToggler" aria-label="Toggle navigation">
                <span></span><span></span><span></span>
            </button>
            <ul class="cn-nav-list" id="cnNavList">
                <li><a href="{{ route('home.service_provider') }}" class="cn-link">Providers</a></li>
                <li><a href="{{ route('home.jobs') }}" class="cn-link">Jobs</a></li>

                {{-- Company mega menu --}}
                <li class="cn-mega-wrap">
                    <button type="button" class="cn-link cn-mega-trigger" id="cnMegaTrigger" aria-haspopup="true" aria-expanded="false">
                        Company
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>

                    <div class="cn-mega-panel" id="cnMegaPanel">
                        <div class="cn-mega-cols">
                            <div class="cn-mega-col">
                                <h4>Company</h4>
                                <a href="{{ route('about') }}">About Us</a>
                                <a href="{{ route('faq') }}">How It Works</a>
                                <a href="{{ route('home.jobs') }}">Careers</a>
                                <a href="{{ route('home.blogs') }}">Blog</a>
                            </div>
                            <div class="cn-mega-col">
                                <h4>Support</h4>
                                <a href="{{ route('faq') }}">Help Center</a>
                                <a href="{{ route('home.contact') }}">Contact Us</a>
                                <a href="{{ route('policy') }}">Trust &amp; Safety</a>
                            </div>
                            <div class="cn-mega-col cn-mega-promo">
                                <h4>Become a Provider</h4>
                                <p>List your services and reach customers across Rwanda.</p>
                                <a href="{{ route('register') }}" class="cn-btn-solid cn-btn-sm">Get Started</a>
                            </div>
                        </div>
                    </div>
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
        </div>

    </div>
</header>

{{-- ============ Explore Off-canvas ============ --}}
<div class="cn-canvas-backdrop" id="cnCanvasBackdrop"></div>
<aside class="cn-canvas" id="cnExploreCanvas" aria-hidden="true">
    <div class="cn-canvas-head">
        <h3>Explore Connector</h3>
        <button type="button" class="cn-canvas-close" id="cnCanvasClose" aria-label="Close">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>
    </div>

    <div class="cn-canvas-body">

        {{-- 1. Service categories --}}
        <section class="cn-canvas-section">
            <button type="button" class="cn-section-toggle is-open" data-target="cnSecCategories">
                <span class="cn-section-num">1</span>
                <span>Service Categories</span>
                <svg class="cn-chev" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6" /></svg>
            </button>
            <div class="cn-section-body" id="cnSecCategories">
                @foreach($exploreCategories as $cat)
                <div class="cn-acc-item">
                    <button type="button" class="cn-acc-toggle" data-target="cnCat{{ $loop->index }}">
                        <span>{{ $cat['name'] }}</span>
                        <svg class="cn-chev" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6" /></svg>
                    </button>
                    <div class="cn-acc-body" id="cnCat{{ $loop->index }}">
                        @foreach($cat['subcategories'] as $sub)
                        <div class="cn-acc-item cn-acc-item-nested">
                            <button type="button" class="cn-acc-toggle cn-acc-toggle-sm" data-target="cnSub{{ $loop->parent->index }}_{{ $loop->index }}">
                                <span>{{ $sub['name'] }}</span>
                                <svg class="cn-chev" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6" /></svg>
                            </button>
                            <div class="cn-acc-body" id="cnSub{{ $loop->parent->index }}_{{ $loop->index }}">
                                <div class="cn-loc-tags">
                                    @foreach($sub['locations'] as $loc)
                                    <a href="{{ route('home.services', ['category' => $cat['name'], 'sub' => $sub['name'], 'location' => $loc]) }}" class="cn-loc-tag">{{ $loc }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        {{-- 2. Providers --}}
        <section class="cn-canvas-section">
            <button type="button" class="cn-section-toggle" data-target="cnSecProviders">
                <span class="cn-section-num">2</span>
                <span>Providers</span>
                <svg class="cn-chev" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6" /></svg>
            </button>
            <div class="cn-section-body" id="cnSecProviders">
                @foreach($providerCategories as $pcat)
                <div class="cn-acc-item">
                    <button type="button" class="cn-acc-toggle" data-target="cnProv{{ $loop->index }}">
                        <span>{{ $pcat['name'] }}</span>
                        <svg class="cn-chev" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6" /></svg>
                    </button>
                    <div class="cn-acc-body" id="cnProv{{ $loop->index }}">
                        <div class="cn-loc-tags">
                            @foreach($pcat['locations'] as $loc)
                            <a href="{{ route('home.service_provider', ['category' => $pcat['name'], 'location' => $loc]) }}" class="cn-loc-tag">{{ $loc }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        {{-- 3. Latest updates --}}
        <section class="cn-canvas-section">
            <button type="button" class="cn-section-toggle" data-target="cnSecUpdates">
                <span class="cn-section-num">3</span>
                <span>Latest Updates</span>
                <svg class="cn-chev" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6" /></svg>
            </button>
            <div class="cn-section-body" id="cnSecUpdates">
                <div class="cn-updates-cols">
                    <div class="cn-updates-col">
                        <h5>News</h5>
                        <ul class="cn-updates-list">
                            @foreach($latestNews as $item)
                            <li><a href="{{ $item['url'] }}">{{ $item['title'] }}<span>{{ $item['date'] }}</span></a></li>
                            @endforeach
                        </ul>
                        <a href="{{ route('home.blogs') }}" class="cn-updates-more">View all news →</a>
                    </div>
                    <div class="cn-updates-col">
                        <h5>Jobs</h5>
                        <ul class="cn-updates-list">
                            @foreach($latestJobs as $item)
                            <li><a href="{{ $item['url'] }}">{{ $item['title'] }}<span>{{ $item['location'] }}</span></a></li>
                            @endforeach
                        </ul>
                        <a href="{{ route('home.jobs') }}" class="cn-updates-more">View all jobs →</a>
                    </div>
                </div>
            </div>
        </section>

    </div>
</aside>

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

    /* ---- Mega menu ---- */
    .cn-mega-wrap {
        position: relative;
    }

    .cn-mega-panel {
        display: none;
        position: absolute;
        top: calc(100% + 12px);
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        border: 1px solid var(--cn-border);
        border-radius: 16px;
        box-shadow: 0 16px 48px rgba(37, 64, 53, .16);
        padding: 24px;
        width: 520px;
        z-index: 1100;
    }

    .cn-mega-panel.open {
        display: block;
    }

    .cn-mega-cols {
        display: grid;
        grid-template-columns: 1fr 1fr 1.1fr;
        gap: 24px;
    }

    .cn-mega-col h4 {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: var(--cn-green);
        margin-bottom: 12px;
    }

    .cn-mega-col a {
        display: block;
        font-size: 14px;
        color: var(--cn-dark);
        text-decoration: none;
        padding: 7px 0;
        transition: color .15s;
    }

    .cn-mega-col a:hover {
        color: var(--cn-green);
    }

    .cn-mega-promo {
        background: var(--cn-light);
        border-radius: 12px;
        padding: 16px;
        margin: -4px;
    }

    .cn-mega-promo p {
        font-size: 13px;
        color: #4a5f56;
        margin: 0 0 14px;
        line-height: 1.5;
    }

    .cn-btn-sm {
        padding: 8px 16px;
        font-size: 12px;
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

    /* ---- Off-canvas Explore ---- */
    .cn-canvas-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(37, 64, 53, .45);
        z-index: 1200;
    }

    .cn-canvas-backdrop.open {
        display: block;
    }

    .cn-canvas {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 420px;
        max-width: 92vw;
        background: #fff;
        z-index: 1201;
        display: flex;
        flex-direction: column;
        transform: translateX(-100%);
        transition: transform .35s ease;
        box-shadow: 8px 0 32px rgba(37, 64, 53, .18);
    }

    .cn-canvas.open {
        transform: translateX(0);
    }

    .cn-canvas-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 22px;
        border-bottom: 1px solid var(--cn-border);
        flex-shrink: 0;
        background: var(--cn-dark);
    }

    .cn-canvas-head h3 {
        font-size: 17px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }

    .cn-canvas-close {
        background: rgba(255, 255, 255, .12);
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        cursor: pointer;
        transition: background .2s;
    }

    .cn-canvas-close:hover {
        background: rgba(255, 255, 255, .22);
    }

    .cn-canvas-body {
        flex: 1;
        overflow-y: auto;
        padding: 8px 0 24px;
    }

    .cn-canvas-section {
        border-bottom: 1px solid var(--cn-border);
    }

    .cn-section-toggle {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 12px;
        background: none;
        border: none;
        padding: 18px 22px;
        font-size: 15px;
        font-weight: 700;
        color: var(--cn-dark);
        cursor: pointer;
        text-align: left;
        font-family: inherit;
    }

    .cn-section-num {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: var(--cn-green);
        color: #fff;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .cn-section-toggle span:nth-of-type(1) {
        flex: 1;
    }

    .cn-chev {
        flex-shrink: 0;
        transition: transform .25s;
        color: var(--cn-green);
    }

    .cn-section-toggle.is-open .cn-chev {
        transform: rotate(180deg);
    }

    .cn-section-body {
        display: none;
        padding: 0 22px 18px 22px;
    }

    .cn-section-body.is-open {
        display: block;
    }

    .cn-acc-item {
        border-top: 1px solid var(--cn-border);
    }

    .cn-acc-item:first-child {
        border-top: none;
    }

    .cn-acc-toggle {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        background: none;
        border: none;
        padding: 12px 4px;
        font-size: 14px;
        font-weight: 600;
        color: var(--cn-dark);
        cursor: pointer;
        text-align: left;
        font-family: inherit;
    }

    .cn-acc-toggle span {
        flex: 1;
    }

    .cn-acc-toggle-sm {
        font-size: 13px;
        font-weight: 500;
        padding-left: 14px;
        color: #45594e;
    }

    .cn-acc-toggle.is-open .cn-chev {
        transform: rotate(180deg);
    }

    .cn-acc-body {
        display: none;
        padding: 0 4px 14px 14px;
    }

    .cn-acc-body.is-open {
        display: block;
    }

    .cn-acc-item-nested {
        padding-left: 8px;
    }

    .cn-loc-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .cn-loc-tag {
        font-size: 12.5px;
        font-weight: 500;
        padding: 6px 13px;
        border-radius: 18px;
        background: var(--cn-light);
        color: var(--cn-dark);
        text-decoration: none;
        transition: background .15s, color .15s;
    }

    .cn-loc-tag:hover {
        background: var(--cn-green);
        color: #fff;
    }

    .cn-updates-cols {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .cn-updates-col h5 {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: var(--cn-green);
        margin: 4px 0 10px;
    }

    .cn-updates-list {
        list-style: none;
        margin: 0 0 8px;
        padding: 0;
    }

    .cn-updates-list li a {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 8px 0;
        font-size: 13.5px;
        color: var(--cn-dark);
        text-decoration: none;
        border-bottom: 1px dashed var(--cn-border);
    }

    .cn-updates-list li:last-child a {
        border-bottom: none;
    }

    .cn-updates-list li a span {
        flex-shrink: 0;
        font-size: 11.5px;
        color: #8ba39a;
        font-weight: 500;
    }

    .cn-updates-list li a:hover {
        color: var(--cn-green);
    }

    .cn-updates-more {
        display: inline-block;
        font-size: 13px;
        font-weight: 600;
        color: var(--cn-green);
        text-decoration: none;
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

        .cn-mega-panel {
            position: static;
            transform: none;
            width: auto;
            box-shadow: none;
            border: none;
            padding: 8px 0 0;
        }

        .cn-mega-cols {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .cn-mega-promo {
            margin: 0;
        }

        .cn-canvas {
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
        const megaTrigger = document.getElementById('cnMegaTrigger');
        const megaPanel = document.getElementById('cnMegaPanel');
        const exploreBtn = document.getElementById('cnExploreBtn');
        const canvas = document.getElementById('cnExploreCanvas');
        const canvasBackdrop = document.getElementById('cnCanvasBackdrop');
        const canvasClose = document.getElementById('cnCanvasClose');

        // Sticky scroll
        const onScroll = () => {
            hdr.classList.toggle('scrolled', window.scrollY > 40);
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        // User dropdown
        if (pill && drop) {
            pill.addEventListener('click', (e) => {
                e.stopPropagation();
                drop.classList.toggle('open');
            });
        }

        // Company mega menu
        if (megaTrigger && megaPanel) {
            megaTrigger.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = megaPanel.classList.toggle('open');
                megaTrigger.setAttribute('aria-expanded', isOpen);
            });
        }

        document.addEventListener('click', () => {
            if (drop) drop.classList.remove('open');
            if (megaPanel) {
                megaPanel.classList.remove('open');
                megaTrigger.setAttribute('aria-expanded', 'false');
            }
        });

        // Mobile nav toggle
        if (toggler && navList) {
            toggler.addEventListener('click', () => navList.classList.toggle('open'));
        }

        // Explore off-canvas
        function openCanvas() {
            canvas.classList.add('open');
            canvasBackdrop.classList.add('open');
            canvas.setAttribute('aria-hidden', 'false');
            exploreBtn.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        }

        function closeCanvas() {
            canvas.classList.remove('open');
            canvasBackdrop.classList.remove('open');
            canvas.setAttribute('aria-hidden', 'true');
            exploreBtn.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }

        if (exploreBtn) exploreBtn.addEventListener('click', openCanvas);
        if (canvasClose) canvasClose.addEventListener('click', closeCanvas);
        if (canvasBackdrop) canvasBackdrop.addEventListener('click', closeCanvas);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeCanvas();
        });

        // Top-level section accordions (1 / 2 / 3)
        document.querySelectorAll('.cn-section-toggle').forEach((btn) => {
            btn.addEventListener('click', () => {
                const body = document.getElementById(btn.dataset.target);
                const willOpen = !btn.classList.contains('is-open');
                btn.classList.toggle('is-open', willOpen);
                if (body) body.classList.toggle('is-open', willOpen);
            });
        });

        // Nested accordions (categories -> subcategories, providers -> locations)
        document.querySelectorAll('.cn-acc-toggle').forEach((btn) => {
            btn.addEventListener('click', () => {
                const body = document.getElementById(btn.dataset.target);
                const willOpen = !btn.classList.contains('is-open');
                btn.classList.toggle('is-open', willOpen);
                if (body) body.classList.toggle('is-open', willOpen);
            });
        });
    })();
</script>