{{--
    Header partial — Logo / Explore / Search / AI Assistant / Theme switcher / Account
    + a single Explore offcanvas with three consistent accordion sections.

    Expected variables (pass from a View Composer or the controller):
      $scategories        Collection of service_categories (id, name, slug, image)
      $subcategories       Collection of service_sub_categories (id, name, slug, service_category_id)
      $locations           Collection|array of distinct provider locations/provinces, e.g. ['Kigali', 'Huye', ...]
      $latestJobs           Collection of the most recent open jobs (title, location, type, company relation)
      $latestBlogs          Collection of the most recent published blog posts (title, slug, image, created_at)

    Route names referenced below match the ones already used elsewhere in this project
    (home.service_by_subcategory, home.service_by_category, home.service_provider, home.jobs,
    home.blogs, home.contact, services.search, login, register, password.request, logout,
    admin.dashboard, sprovider.dashboard, customer.dashboard). Two are guessed and should be
    wired up on the backend if the names differ: `services.ai_search` and `home.job_details`.

    STRUCTURE NOTES (updated):
      - Header bar is now: Logo — Explore — big search tray — AI Assistant — Theme switch — Account.
        "Explore" is a single button that opens ONE offcanvas on every screen size (no separate
        desktop hover-dropdown anymore) — one place to maintain instead of two.
      - The Explore offcanvas has exactly three sections, and all three use the SAME accordion
        pattern (row + arrow + inline expanding submenu) for a consistent feel:
          1. Service Categories — each category row expands to show its sub-categories.
          2. Providers & Shops — two rows, "By Location" (expands to provinces/locations) and
             "By Category" (expands to categories).
          3. Latest Updates — two rows, "Jobs" and "News & Blog" (each expands to its latest items).
        Within each of the three sections only one row can be open at a time.
--}}

<header class="cn-header" id="cn-header">
    <div class="cn-inner">

        {{-- Logo --}}
        <a href="/" class="cn-logo">
            <img src="{{ asset('asset/images/logo/logo-connector-header.png') }}" alt="Connector" width="150">
        </a>

        {{-- Explore — opens the offcanvas (same content/behavior on desktop and mobile) --}}
        <button type="button" class="cn-explore-btn" id="cnExploreBtn" data-bs-toggle="offcanvas" data-bs-target="#exploreOffcanvas" aria-controls="exploreOffcanvas">
            <span class="cn-explore-hamburger" aria-hidden="true">
                <span></span><span></span><span></span>
            </span>
            <span class="cn-explore-label">
                <small>Browse</small>
                <strong>Explore</strong>
            </span>
        </button>

        {{-- Big search tray --}}
        <form action="{{ route('services.search') }}" class="cn-search-tray">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35" />
            </svg>
            <input type="text" name="query" placeholder="Search services, providers, categories...">
            <button type="submit" class="cn-search-tray-go">Search</button>
        </form>

        {{-- AI assistant + theme switch --}}
        <div class="cn-utility">
            <button type="button" class="cn-icon-btn cn-ai-btn" data-bs-toggle="modal" data-bs-target="#aiSearchModal" title="AI Search">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 3v3M12 18v3M4.2 4.2l2.1 2.1M17.7 17.7l2.1 2.1M3 12h3M18 12h3M4.2 19.8l2.1-2.1M17.7 6.3l2.1-2.1" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                <span>AI Assistant</span>
            </button>

            <button type="button" class="cn-icon-btn cn-theme-toggle" id="cnThemeToggle" title="Toggle theme" aria-label="Toggle light and dark theme">
                <svg width="17" height="17" class="cn-icon-sun" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="4" />
                    <path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" />
                </svg>
                <svg width="17" height="17" class="cn-icon-moon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z" />
                </svg>
            </button>
        </div>

        {{-- Account --}}
        <div class="cn-actions">
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
            <a href="#" class="cn-btn-outline" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
            <a href="{{ route('register') }}" class="cn-btn-solid">Get Started</a>
            @endauth
            @endif
        </div>

    </div>

    {{-- Compact search, shown only under the header row on small screens where
         the big tray in the main row is hidden. --}}
    <form action="{{ route('services.search') }}" class="cn-search-tray cn-search-tray-mobile">
        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
        </svg>
        <input type="text" name="query" placeholder="Search services, providers, categories...">
    </form>
</header>

{{-- ============ Explore Offcanvas — Categories / Providers & Shops / Latest Updates ============ --}}
<div class="offcanvas offcanvas-start cn-offcanvas" tabindex="-1" id="exploreOffcanvas" aria-labelledby="exploreOffcanvasLabel">
    <div class="cn-offcanvas-header">
        <a href="/" class="cn-logo">
            <img src="{{ asset('asset/images/logo/logo-connector-header.png') }}" alt="Connector" width="140">
        </a>
        <button type="button" class="cn-offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>
    </div>

    <div class="cn-offcanvas-body">

        {{-- PART 1 — Service categories: each row expands to its sub-categories --}}
        <div class="cn-explore-part">
            <h6 class="cn-part-title">Service Categories</h6>

            <div class="cn-acc-list" id="cnCatMenu">
                @forelse($scategories ?? [] as $scategory)
                @php $scatSubs = ($subcategories ?? collect())->where('service_category_id', $scategory->id); @endphp
                <div class="cn-acc-item">
                    <button type="button" class="cn-acc-row" aria-expanded="false">
                        <span class="cn-accordion-label">
                            <img src="{{ asset('image/categories') }}/{{ $scategory->image }}" alt="" class="cn-acc-icon">
                            {{ $scategory->name }}
                        </span>
                        <svg width="13" height="13" class="cn-acc-arrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                    <div class="cn-acc-submenu">
                        <a href="{{ route('home.service_by_category', ['category_slug' => $scategory->slug]) }}" class="cn-subcat-link cn-subcat-viewall">
                            View all {{ $scategory->name }}
                        </a>
                        @forelse($scatSubs as $scat)
                        <a href="{{ route('home.service_by_subcategory', ['subcategory_slug' => $scat->slug]) }}" class="cn-subcat-link">
                            {{ $scat->name }}
                        </a>
                        @empty
                        <p class="cn-empty">No sub-categories yet.</p>
                        @endforelse
                    </div>
                </div>
                @empty
                <p class="cn-empty">No categories available yet.</p>
                @endforelse
            </div>
        </div>

        {{-- PART 2 — Providers & Shops: "By Location" (→ provinces/locations) and
             "By Category" (→ categories), same accordion pattern as Part 1 --}}
        <div class="cn-explore-part">
            <h6 class="cn-part-title">Providers &amp; Shops</h6>

            <div class="cn-acc-list" id="cnProvidersMenu">
                <div class="cn-acc-item">
                    <button type="button" class="cn-acc-row" aria-expanded="false">
                        <span class="cn-accordion-label">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 22s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12Z" />
                                <circle cx="12" cy="10" r="2.5" />
                            </svg>
                            By Location
                        </span>
                        <svg width="13" height="13" class="cn-acc-arrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                    <div class="cn-acc-submenu">
                        <a href="{{ route('home.service_provider') }}" class="cn-subcat-link cn-subcat-viewall">All Providers</a>
                        @forelse($locations ?? [] as $location)
                        <a href="{{ route('home.service_provider') }}?location={{ urlencode($location) }}" class="cn-subcat-link">
                            {{ $location }}
                        </a>
                        @empty
                        <p class="cn-empty">No locations available yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="cn-acc-item">
                    <button type="button" class="cn-acc-row" aria-expanded="false">
                        <span class="cn-accordion-label">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                            </svg>
                            By Category
                        </span>
                        <svg width="13" height="13" class="cn-acc-arrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                    <div class="cn-acc-submenu">
                        <a href="{{ route('home.service_provider') }}" class="cn-subcat-link cn-subcat-viewall">All Providers</a>
                        @forelse($scategories ?? [] as $scategory)
                        <a href="{{ route('home.service_provider') }}?category={{ $scategory->slug }}" class="cn-subcat-link">
                            {{ $scategory->name }}
                        </a>
                        @empty
                        <p class="cn-empty">No categories available yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- PART 3 — Latest Updates: "Jobs" and "News & Blog", same accordion pattern --}}
        <div class="cn-explore-part">
            <h6 class="cn-part-title">Latest Updates</h6>

            <div class="cn-acc-list" id="cnLatestMenu">
                <div class="cn-acc-item">
                    <button type="button" class="cn-acc-row" aria-expanded="false">
                        <span class="cn-accordion-label">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="3" y="7" width="18" height="13" rx="2" />
                                <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                            </svg>
                            Jobs
                        </span>
                        <svg width="13" height="13" class="cn-acc-arrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                    <div class="cn-acc-submenu cn-acc-submenu-list">
                        @forelse($latestJobs ?? [] as $job)
                        <a href="{{ route('home.jobs') }}" class="cn-latest-item">
                            <span class="cn-latest-title">{{ $job->title }}</span>
                            <span class="cn-latest-meta">{{ $job->location }} &middot; {{ $job->type }}</span>
                        </a>
                        @empty
                        <p class="cn-empty">No open positions right now.</p>
                        @endforelse
                        <a href="{{ route('home.jobs') }}" class="cn-subcat-link cn-subcat-viewall">View all jobs</a>
                    </div>
                </div>

                <div class="cn-acc-item">
                    <button type="button" class="cn-acc-row" aria-expanded="false">
                        <span class="cn-accordion-label">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M4 4h13a3 3 0 0 1 3 3v13H7a3 3 0 0 1-3-3V4Z" />
                                <path d="M8 9h8M8 13h5" />
                            </svg>
                            News &amp; Blog
                        </span>
                        <svg width="13" height="13" class="cn-acc-arrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                    <div class="cn-acc-submenu cn-acc-submenu-list">
                        @forelse($latestBlogs ?? [] as $blog)
                        <a href="{{ route('home.blogs') }}" class="cn-latest-item">
                            <span class="cn-latest-title">{{ $blog->title }}</span>
                            <span class="cn-latest-meta">{{ optional($blog->created_at)->format('M d, Y') }}</span>
                        </a>
                        @empty
                        <p class="cn-empty">No blog posts published yet.</p>
                        @endforelse
                        <a href="{{ route('home.blogs') }}" class="cn-subcat-link cn-subcat-viewall">View all articles</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="cn-explore-footer">
            <a href="{{ route('home.contact') }}" class="cn-btn-outline cn-btn-block">Contact Us</a>
        </div>

    </div>
</div>

{{-- ============ AI Search Modal ============ --}}
<div class="modal fade" id="aiSearchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px">
        <div class="modal-content cn-modal cn-ai-modal">
            <button type="button" class="cn-modal-close" data-bs-dismiss="modal" aria-label="Close">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
            <div class="cn-modal-header">
                <span class="cn-ai-badge">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M12 3v3M12 18v3M4.2 4.2l2.1 2.1M17.7 17.7l2.1 2.1M3 12h3M18 12h3M4.2 19.8l2.1-2.1M17.7 6.3l2.1-2.1" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    AI Assistant
                </span>
                <h2>Describe what you need</h2>
                <p>Try "bridal makeup near me under 100,000 RWF" or "a barber open on Sunday in Musanze".</p>
            </div>
            <form method="GET" action="{{ route('services.search') }}" class="cn-modal-form">
                <div class="cn-field">
                    <textarea name="query" rows="3" placeholder="Ask anything about services, providers, or locations..." required></textarea>
                </div>
                <button type="submit" class="cn-btn-solid cn-btn-block">Search with AI</button>
            </form>
        </div>
    </div>
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
        --cn-primary: #3A6354;
        --cn-primary-dark: #274538;
        --cn-mint: #C2D9D1;
        --cn-white: #ffffff;
        --cn-border: rgba(58, 99, 84, .16);
        --cn-light: rgba(58, 99, 84, .08);
        --cn-text: #1F2E28;
        --cn-muted: #6E8880;

        --cn-bg: #ffffff;
        --cn-surface: #ffffff;
    }

    [data-theme="dark"] {
        --cn-bg: #101915;
        --cn-surface: #16221c;
        --cn-text: #E9F1ED;
        --cn-muted: #9CB6AC;
        --cn-border: rgba(194, 217, 209, .18);
        --cn-light: rgba(194, 217, 209, .1);
        --cn-mint: #274538;
    }

    body {
        background: var(--cn-bg);
        color: var(--cn-text);
    }

    /* ---- Header ---- */
    .cn-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1050;
        padding: 0 48px;
        transition: box-shadow .35s ease;
        background: var(--cn-primary);
    }

    .cn-header.scrolled {
        box-shadow: 0 2px 24px rgba(16, 25, 21, .25);
    }

    .cn-inner {
        display: flex;
        align-items: center;
        height: 76px;
        gap: 18px;
    }

    .cn-logo img {
        height: 38px;
    }

    /* ---- Explore button ---- */
    .cn-explore-btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 8px 14px 8px 10px;
        border: 1px solid transparent;
        border-radius: 8px;
        background: none;
        cursor: pointer;
        flex-shrink: 0;
        transition: background .2s, border-color .2s;
    }

    .cn-explore-btn:hover,
    .cn-explore-btn:focus-visible {
        border-color: rgba(255, 255, 255, .5);
        background: rgba(255, 255, 255, .1);
    }

    .cn-explore-hamburger {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 3px;
        width: 18px;
        flex-shrink: 0;
    }

    .cn-explore-hamburger span {
        display: block;
        height: 2px;
        width: 100%;
        background: #fff;
        border-radius: 1px;
    }

    .cn-explore-label {
        display: flex;
        flex-direction: column;
        line-height: 1.15;
        text-align: left;
    }

    .cn-explore-label small {
        font-size: 10px;
        font-weight: 500;
        color: rgba(255, 255, 255, .7);
        text-transform: none;
    }

    .cn-explore-label strong {
        font-size: 13.5px;
        font-weight: 700;
        color: #fff;
    }

    /* ---- Big search tray ---- */
    .cn-search-tray {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        border: 1px solid rgba(255, 255, 255, .5);
        border-radius: 30px;
        padding: 6px 8px 6px 20px;
        min-width: 0;
        max-width: 640px;
        box-shadow: 0 6px 20px rgba(16, 25, 21, .18);
    }

    .cn-search-tray svg {
        color: var(--cn-muted);
        flex-shrink: 0;
    }

    .cn-search-tray input {
        flex: 1;
        min-width: 0;
        background: none;
        border: none;
        outline: none;
        font-size: 14.5px;
        color: var(--cn-text);
        padding: 8px 0;
    }

    .cn-search-tray input::placeholder {
        color: var(--cn-muted);
    }

    .cn-search-tray-go {
        flex-shrink: 0;
        border: none;
        background: var(--cn-primary);
        color: #fff;
        font-size: 13.5px;
        font-weight: 700;
        padding: 10px 22px;
        border-radius: 24px;
        cursor: pointer;
        transition: background .2s;
    }

    .cn-search-tray-go:hover {
        background: var(--cn-primary-dark);
    }

    .cn-search-tray-mobile {
        display: none;
        margin: 0 16px 14px;
    }

    /* ---- AI assistant + theme switch ---- */
    .cn-utility {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .cn-icon-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, .14);
        border: 1px solid rgba(255, 255, 255, .28);
        border-radius: 24px;
        padding: 8px 12px;
        color: #fff;
        cursor: pointer;
        transition: all .2s;
        font-size: 13px;
        font-weight: 600;
    }

    .cn-icon-btn:hover {
        background: #fff;
        color: var(--cn-primary-dark);
        border-color: #fff;
    }

    .cn-ai-btn span {
        white-space: nowrap;
    }

    .cn-theme-toggle {
        padding: 8px;
    }

    .cn-icon-moon {
        display: none;
    }

    [data-theme="dark"] .cn-icon-sun {
        display: none;
    }

    [data-theme="dark"] .cn-icon-moon {
        display: block;
    }

    /* ---- Account ---- */
    .cn-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .cn-btn-outline {
        font-size: 13px;
        font-weight: 600;
        padding: 8px 20px;
        border-radius: 24px;
        border: 1.5px solid rgba(255, 255, 255, .55);
        color: #fff;
        text-decoration: none;
        transition: all .25s;
        white-space: nowrap;
        display: inline-block;
        text-align: center;
    }

    .cn-header.scrolled .cn-btn-outline {
        color: var(--cn-primary-dark);
        border-color: var(--cn-border);
    }

    .cn-btn-outline:hover {
        background: rgba(255, 255, 255, .14);
    }

    .cn-header.scrolled .cn-btn-outline:hover {
        background: var(--cn-light);
    }

    .cn-btn-solid {
        font-size: 13px;
        font-weight: 600;
        padding: 9px 22px;
        border-radius: 24px;
        background: var(--cn-primary);
        color: #fff;
        border: none;
        text-decoration: none;
        cursor: pointer;
        transition: background .25s;
        white-space: nowrap;
        display: inline-block;
    }

    .cn-btn-solid:hover {
        background: var(--cn-primary-dark);
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
        border: 1.5px solid rgba(255, 255, 255, .32);
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
        color: var(--cn-primary-dark);
    }

    .cn-user-pill svg {
        color: rgba(255, 255, 255, .65);
    }

    .cn-header.scrolled .cn-user-pill svg {
        color: var(--cn-primary);
    }

    .cn-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        background: var(--cn-surface);
        border: 1px solid var(--cn-border);
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(39, 69, 56, .14);
        min-width: 180px;
        padding: 6px;
        list-style: none;
        margin: 0;
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
        color: var(--cn-text);
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

    /* ---- Explore offcanvas ---- */
    .cn-offcanvas {
        width: 420px;
        max-width: 92vw;
        background: var(--cn-surface);
        color: var(--cn-text);
        border-right: 1px solid var(--cn-border);
    }

    .cn-offcanvas-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        border-bottom: 1px solid var(--cn-border);
    }

    .cn-offcanvas-close {
        background: var(--cn-light);
        border: none;
        border-radius: 50%;
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--cn-primary-dark);
        cursor: pointer;
        transition: background .2s;
    }

    .cn-offcanvas-close:hover {
        background: var(--cn-mint);
    }

    .cn-offcanvas-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 26px;
        overflow-y: auto;
    }

    .cn-part-title {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--cn-primary);
        margin-bottom: 12px;
    }

    /* ---- Shared accordion pattern: used by all 3 offcanvas sections ---- */
    .cn-acc-list {
        border: 1px solid var(--cn-border);
        border-radius: 10px;
        background: var(--cn-bg);
        overflow: hidden;
    }

    .cn-acc-item {
        border-bottom: 1px solid var(--cn-border);
    }

    .cn-acc-item:last-child {
        border-bottom: none;
    }

    .cn-acc-row {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 14px;
        font-size: 14px;
        font-weight: 600;
        color: var(--cn-text);
        background: none;
        border: none;
        text-align: left;
        cursor: pointer;
        transition: background .15s;
    }

    .cn-acc-row:hover,
    .cn-acc-row:focus-visible {
        background: var(--cn-light);
        outline: none;
    }

    .cn-accordion-label {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cn-accordion-label svg {
        color: var(--cn-primary);
        flex-shrink: 0;
    }

    .cn-acc-icon {
        width: 20px;
        height: 20px;
        object-fit: contain;
        border-radius: 4px;
    }

    .cn-acc-arrow {
        color: var(--cn-muted);
        flex-shrink: 0;
        transition: transform .2s ease;
    }

    .cn-acc-item.open .cn-acc-arrow {
        transform: rotate(90deg);
    }

    .cn-acc-submenu {
        max-height: 0;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        gap: 2px;
        padding: 0 8px;
        background: var(--cn-light);
        transition: max-height .25s ease;
    }

    .cn-acc-item.open .cn-acc-submenu {
        max-height: 420px;
        overflow-y: auto;
        padding: 8px;
    }

    .cn-subcat-link {
        padding: 8px 10px;
        font-size: 13px;
        color: var(--cn-muted);
        text-decoration: none;
        border-radius: 7px;
        transition: background .15s, color .15s;
    }

    .cn-subcat-link:hover {
        background: var(--cn-mint);
        color: var(--cn-primary-dark);
    }

    .cn-subcat-viewall {
        font-weight: 700;
        color: var(--cn-primary);
    }

    .cn-latest-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
        padding: 8px 10px;
        border-radius: 7px;
        text-decoration: none;
        transition: background .15s;
    }

    .cn-latest-item:hover {
        background: var(--cn-mint);
    }

    .cn-latest-title {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--cn-text);
    }

    .cn-latest-meta {
        font-size: 11.5px;
        color: var(--cn-muted);
    }

    .cn-empty {
        font-size: 13px;
        color: var(--cn-muted);
        padding: 6px 4px;
    }

    .cn-explore-footer {
        margin-top: auto;
        padding-top: 6px;
    }

    .cn-explore-footer .cn-btn-outline {
        color: var(--cn-primary);
        border-color: var(--cn-primary);
    }

    .cn-explore-footer .cn-btn-outline:hover {
        background: var(--cn-mint);
    }

    /* ---- Modals ---- */
    .cn-modal {
        border: none;
        border-radius: 18px;
        padding: 40px;
        position: relative;
        background: var(--cn-surface);
        color: var(--cn-text);
    }

    .cn-modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        background: var(--cn-light);
        border: none;
        border-radius: 50%;
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--cn-primary-dark);
        cursor: pointer;
        transition: background .2s;
    }

    .cn-modal-close:hover {
        background: var(--cn-mint);
    }

    .cn-modal-header {
        margin-bottom: 28px;
    }

    .cn-ai-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--cn-mint);
        color: var(--cn-primary-dark);
        font-size: 11.5px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        margin-bottom: 12px;
    }

    .cn-modal-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: var(--cn-text);
        margin-bottom: 6px;
    }

    .cn-modal-header p {
        font-size: 14px;
        color: var(--cn-muted);
    }

    .cn-modal-header a {
        color: var(--cn-primary);
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
        color: var(--cn-text);
    }

    .cn-field input,
    .cn-field textarea {
        padding: 11px 14px;
        border: 1.5px solid var(--cn-border);
        border-radius: 10px;
        font-size: 14px;
        color: var(--cn-text);
        background: var(--cn-bg);
        outline: none;
        transition: border .2s;
        font-family: inherit;
        resize: vertical;
    }

    .cn-field input:focus,
    .cn-field textarea:focus {
        border-color: var(--cn-primary);
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
        color: var(--cn-muted);
        cursor: pointer;
    }

    .cn-link-muted {
        font-size: 13px;
        color: var(--cn-primary);
        text-decoration: none;
        font-weight: 500;
    }

    /* ---- Responsive ---- */
    @media (max-width: 992px) {
        .cn-header {
            padding: 0 16px;
        }

        .cn-inner {
            height: 64px;
        }

        .cn-inner .cn-search-tray {
            display: none;
        }

        .cn-explore-label small {
            display: none;
        }

        .cn-ai-btn span {
            display: none;
        }

        .cn-search-tray-mobile {
            display: flex;
        }

        .cn-offcanvas {
            width: 340px;
        }
    }

    @media (max-width: 560px) {
        .cn-actions .cn-btn-outline {
            display: none;
        }
    }
</style>

{{-- ============ Script ============ --}}
<script>
    (function() {
        const hdr = document.getElementById('cn-header');
        const pill = document.getElementById('userPill');
        const drop = document.getElementById('userDropdown');
        const themeToggle = document.getElementById('cnThemeToggle');

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
            document.addEventListener('click', () => drop.classList.remove('open'));
        }

        // Theme switcher (persisted in localStorage)
        const applyTheme = (theme) => {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('cn-theme', theme);
        };
        const savedTheme = localStorage.getItem('cn-theme') ||
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        applyTheme(savedTheme);

        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                const current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
                applyTheme(current === 'dark' ? 'light' : 'dark');
            });
        }

        // Shared accordion behavior for all three offcanvas sections
        // (Categories, Providers & Shops, Latest Updates). Each .cn-acc-list
        // manages its own open/closed state independently — only one row
        // open at a time within that list.
        document.querySelectorAll('.cn-acc-list').forEach((list) => {
            const items = Array.from(list.children).filter((el) => el.classList.contains('cn-acc-item'));
            items.forEach((item) => {
                const row = item.querySelector('.cn-acc-row');
                if (!row) return;
                row.addEventListener('click', () => {
                    const wasOpen = item.classList.contains('open');
                    items.forEach((i) => {
                        i.classList.remove('open');
                        i.querySelector('.cn-acc-row')?.setAttribute('aria-expanded', 'false');
                    });
                    if (!wasOpen) {
                        item.classList.add('open');
                        row.setAttribute('aria-expanded', 'true');
                    }
                });
            });
        });

        // Reset every accordion back to fully-collapsed whenever the Explore
        // offcanvas is closed, so it starts fresh next time it opens.
        const exploreOffcanvasEl = document.getElementById('exploreOffcanvas');
        if (exploreOffcanvasEl) {
            exploreOffcanvasEl.addEventListener('hidden.bs.offcanvas', () => {
                exploreOffcanvasEl.querySelectorAll('.cn-acc-item.open').forEach((i) => {
                    i.classList.remove('open');
                    i.querySelector('.cn-acc-row')?.setAttribute('aria-expanded', 'false');
                });
            });
        }
    })();
</script>