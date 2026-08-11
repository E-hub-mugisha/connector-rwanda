{{--
    Header partial — Home / Explore offcanvas / Search / AI Search / Theme switcher / Auth

    Expected variables (pass from a View Composer or the controller):
      $scategories        Collection of service_categories (id, name, slug, image)
      $subcategories       Collection of service_sub_categories (id, name, slug, service_category_id)
      $locations           Collection|array of distinct provider locations/cities, e.g. ['Kigali', 'Huye', ...]
      $latestJobs           Collection of the most recent open jobs (title, location, type, company relation)
      $latestBlogs          Collection of the most recent published blog posts (title, slug, image, created_at)

    Route names referenced below match the ones already used elsewhere in this project
    (home.service_by_subcategory, home.service_by_category, home.service_provider, home.jobs,
    home.blogs, home.contact, services.search, login, register, password.request, logout,
    admin.dashboard, sprovider.dashboard, customer.dashboard). Two are guessed and should be
    wired up on the backend if the names differ: `services.ai_search` and `home.job_details`.

    NOTE: The "Service Categories" block used to be a click-to-expand <details> accordion.
    It is now a two-level drill-in menu: on pointer devices the sub-category panel opens
    automatically on hover (mouseenter) of a category row; on touch devices (no hover) it
    opens on tap instead, since there is no hover state to rely on there.
--}}

<header class="cn-header" id="cn-header">
    <div class="cn-inner">

        {{-- Logo --}}
        <a href="/" class="cn-logo">
            <img src="{{ asset('asset/images/logo/logo-connector-header.png') }}" alt="Connector" width="150">
        </a>

        {{-- Primary nav: Home + Explore (hover-triggered dropdown, Bootstrap-dropdown style) --}}
        <nav class="cn-nav">
            <ul class="cn-nav-list">
                <li><a href="/" class="cn-link">Home</a></li>
                <li class="cn-explore-wrap" id="cnExploreWrap">
                    <button type="button" class="cn-link cn-explore-btn" id="cnExploreBtn" aria-haspopup="true" aria-expanded="false">
                        <span class="cn-explore-hamburger" aria-hidden="true">
                            <span></span><span></span><span></span>
                        </span>
                        <span class="cn-explore-label">
                            <small>Browse</small>
                            <strong>Explore</strong>
                        </span>
                    </button>

                    {{-- Desktop dropdown panel: opens on hover of the Explore button.
                         Each category row has its own nested submenu that opens on
                         hover to the right, like a classic Bootstrap dropdown-submenu. --}}
                    <div class="cn-explore-dropdown" id="cnExploreDropdown">

                        <div class="cn-dd-section">
                            <h6 class="cn-dd-title">Service Categories</h6>
                            <ul class="cn-dd-list">
                                @forelse($scategories ?? [] as $scategory)
                                @php $scatSubs = ($subcategories ?? collect())->where('service_category_id', $scategory->id); @endphp
                                <li class="cn-dd-item">
                                    <span class="cn-dd-link">
                                        <span class="cn-accordion-label">
                                            <img src="{{ asset('image/categories') }}/{{ $scategory->image }}" alt="" class="cn-cat-icon">
                                            {{ $scategory->name }}
                                        </span>
                                        <svg width="13" height="13" class="cn-cat-arrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="m9 18 6-6-6-6" />
                                        </svg>
                                    </span>
                                    <div class="cn-dd-submenu">
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
                                </li>
                                @empty
                                <li class="cn-empty">No categories available yet.</li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="cn-dd-section">
                            <h6 class="cn-dd-title">Providers &amp; Shops</h6>
                            <div class="cn-dd-chips">
                                <a href="{{ route('home.service_provider') }}" class="cn-chip cn-chip-primary">All Providers</a>
                                @foreach($scategories ?? [] as $scategory)
                                <a href="{{ route('home.service_provider') }}?category={{ $scategory->slug }}" class="cn-chip">{{ $scategory->name }}</a>
                                @endforeach
                            </div>
                            @if(!empty($locations ?? []))
                            <div class="cn-dd-chips cn-dd-chips-locations">
                                @foreach($locations ?? [] as $location)
                                <a href="{{ route('home.service_provider') }}?location={{ urlencode($location) }}" class="cn-chip">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path d="M12 22s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12Z" />
                                        <circle cx="12" cy="10" r="2.5" />
                                    </svg>
                                    {{ $location }}
                                </a>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <div class="cn-dd-section cn-dd-section-split">
                            <div>
                                <h6 class="cn-dd-title">Latest Jobs</h6>
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
                            <div>
                                <h6 class="cn-dd-title">News &amp; Blog</h6>
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

                        <div class="cn-dd-footer">
                            <a href="{{ route('home.contact') }}" class="cn-btn-outline cn-btn-block">Contact Us</a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>

        {{-- Utility bar: search, AI search, theme switcher --}}
        <div class="cn-utility">
            <form action="{{ route('services.search') }}" class="cn-search-bar">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
                <input type="text" name="query" placeholder="Search services...">
            </form>

            <button type="button" class="cn-icon-btn cn-ai-btn" data-bs-toggle="modal" data-bs-target="#aiSearchModal" title="AI Search">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 3v3M12 18v3M4.2 4.2l2.1 2.1M17.7 17.7l2.1 2.1M3 12h3M18 12h3M4.2 19.8l2.1-2.1M17.7 6.3l2.1-2.1" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                <span>AI Search</span>
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

        {{-- Auth actions --}}
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

        {{-- Mobile toggler (opens the same Explore offcanvas + reveals utility icons) --}}
        <button class="cn-toggler" id="cnToggler" data-bs-toggle="offcanvas" data-bs-target="#exploreOffcanvas" aria-label="Toggle navigation">
            <span></span><span></span><span></span>
        </button>

    </div>
</header>

{{-- ============ Explore Offcanvas ============ --}}
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

        {{-- PART 1 — Service categories, drill-in child menu (hover-to-open on desktop, tap on touch) --}}
        <div class="cn-explore-part">
            <h6 class="cn-part-title">Service Categories</h6>

            <div class="cn-cat-menu" id="cnCatMenu">

                {{-- Level 1: category list --}}
                <div class="cn-cat-list" id="cnCatList">
                    @forelse($scategories ?? [] as $scategory)
                    <div class="cn-cat-row" data-cat-target="#cnCatChildren-{{ $scategory->id }}" tabindex="0">
                        <span class="cn-accordion-label">
                            <img src="{{ asset('image/categories') }}/{{ $scategory->image }}" alt="" class="cn-cat-icon">
                            {{ $scategory->name }}
                        </span>
                        <svg width="13" height="13" class="cn-cat-arrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </div>
                    @empty
                    <p class="cn-empty">No categories available yet.</p>
                    @endforelse
                </div>

                {{-- Level 2: sub-category child panels, one per category, slide over the list --}}
                @foreach($scategories ?? [] as $scategory)
                @php $scatSubs = ($subcategories ?? collect())->where('service_category_id', $scategory->id); @endphp
                <div class="cn-cat-children" id="cnCatChildren-{{ $scategory->id }}">
                    <button type="button" class="cn-cat-back">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        {{ $scategory->name }}
                    </button>
                    <div class="cn-cat-children-body">
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
                @endforeach

            </div>
        </div>

        {{-- PART 2 — Providers by category + Locations --}}
        <div class="cn-explore-part">
            <h6 class="cn-part-title">Providers &amp; Shops</h6>

            <div class="cn-subtabs">
                <button type="button" class="cn-subtab active" data-target="#panelProvidersByCategory">By Category</button>
                <button type="button" class="cn-subtab" data-target="#panelProvidersByLocation">By Location</button>
            </div>

            <div class="cn-subtab-panel active" id="panelProvidersByCategory">
                <a href="{{ route('home.service_provider') }}" class="cn-chip cn-chip-primary">All Providers</a>
                @foreach($scategories ?? [] as $scategory)
                <a href="{{ route('home.service_provider') }}?category={{ $scategory->slug }}" class="cn-chip">{{ $scategory->name }}</a>
                @endforeach
            </div>

            <div class="cn-subtab-panel" id="panelProvidersByLocation">
                @forelse($locations ?? [] as $location)
                <a href="{{ route('home.service_provider') }}?location={{ urlencode($location) }}" class="cn-chip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M12 22s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12Z" />
                        <circle cx="12" cy="10" r="2.5" />
                    </svg>
                    {{ $location }}
                </a>
                @empty
                <p class="cn-empty">No locations available yet.</p>
                @endforelse
            </div>
        </div>

        {{-- PART 3 — Latest: Jobs / News & Blog --}}
        <div class="cn-explore-part">
            <h6 class="cn-part-title">Latest Updates</h6>

            <div class="cn-subtabs">
                <button type="button" class="cn-subtab active" data-target="#panelLatestJobs">Jobs</button>
                <button type="button" class="cn-subtab" data-target="#panelLatestBlog">News &amp; Blog</button>
            </div>

            <div class="cn-subtab-panel active" id="panelLatestJobs">
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

            <div class="cn-subtab-panel" id="panelLatestBlog">
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
                    AI Search
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
        height: 72px;
        gap: 18px;
    }

    .cn-logo img {
        height: 38px;
    }

    /* ---- Primary nav ---- */
    .cn-nav-list {
        display: flex;
        align-items: center;
        gap: 4px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .cn-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        font-weight: 600;
        padding: 8px 14px;
        border-radius: 8px;
        color: rgba(255, 255, 255, .92);
        background: none;
        border: none;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s, color .2s;
        white-space: nowrap;
    }

    .cn-link:hover {
        background: rgba(255, 255, 255, .12);
        color: #fff;
    }

    /* ---- Explore button (Amazon "All" style) ---- */
    .cn-explore-btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 8px 14px 8px 10px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .cn-explore-btn:hover,
    .cn-explore-btn:focus-visible {
        border-color: #fff;
        background: none;
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

    /* ---- Explore dropdown (hover-triggered, Bootstrap-dropdown style) ---- */
    .cn-explore-wrap {
        position: relative;
    }

    .cn-explore-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        margin-top: 10px;
        width: 640px;
        max-width: 82vw;
        max-height: 76vh;
        overflow-y: auto;
        background: var(--cn-surface);
        color: var(--cn-text);
        border: 1px solid var(--cn-border);
        border-radius: 14px;
        box-shadow: 0 20px 50px rgba(16, 25, 21, .28);
        padding: 18px;
        display: none;
        z-index: 1060;
    }

    .cn-explore-dropdown.show {
        display: block;
    }

    .cn-dd-section {
        padding-bottom: 16px;
        margin-bottom: 16px;
        border-bottom: 1px solid var(--cn-border);
    }

    .cn-dd-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .cn-dd-title {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--cn-primary);
        margin-bottom: 10px;
    }

    /* Level-1 category list */
    .cn-dd-list {
        list-style: none;
        margin: 0;
        padding: 0;
        columns: 2;
        column-gap: 8px;
    }

    .cn-dd-item {
        position: relative;
        break-inside: avoid;
    }

    .cn-dd-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding: 9px 10px;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 600;
        color: var(--cn-text);
        cursor: default;
        transition: background .15s;
    }

    .cn-dd-item:hover .cn-dd-link {
        background: var(--cn-light);
    }

    /* Level-2 submenu: pops out to the right of its category, like a
       Bootstrap dropdown-submenu. Opens/closes via JS on hover. */
    .cn-dd-submenu {
        position: absolute;
        top: 0;
        left: 100%;
        margin-left: 8px;
        width: 240px;
        max-height: 320px;
        overflow-y: auto;
        background: var(--cn-surface);
        border: 1px solid var(--cn-border);
        border-radius: 10px;
        box-shadow: 0 14px 34px rgba(16, 25, 21, .22);
        padding: 8px;
        display: none;
        z-index: 5;
    }

    .cn-dd-submenu.show {
        display: block;
    }

    .cn-dd-submenu--left {
        left: auto;
        right: 100%;
        margin-left: 0;
        margin-right: 8px;
    }

    .cn-dd-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .cn-dd-chips-locations {
        margin-top: 8px;
    }

    .cn-dd-section-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .cn-dd-footer {
        padding-top: 4px;
    }

    .cn-dd-footer .cn-btn-outline {
        color: var(--cn-primary);
        border-color: var(--cn-primary);
    }

    .cn-dd-footer .cn-btn-outline:hover {
        background: var(--cn-mint);
    }

    /* ---- Utility bar ---- */
    .cn-utility {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .cn-search-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, .14);
        border: 1px solid rgba(255, 255, 255, .28);
        border-radius: 24px;
        padding: 8px 16px;
        transition: all .2s;
        color: rgba(255, 255, 255, .8);
        min-width: 200px;
    }

    .cn-search-bar:focus-within {
        background: #fff;
        border-color: #fff;
    }

    .cn-search-bar input {
        background: none;
        border: none;
        outline: none;
        font-size: 13px;
        color: #fff;
        width: 140px;
    }

    .cn-search-bar:focus-within input {
        color: var(--cn-text);
    }

    .cn-search-bar input::placeholder {
        color: rgba(255, 255, 255, .6);
    }

    .cn-search-bar:focus-within input::placeholder {
        color: var(--cn-muted);
    }

    .cn-search-bar:focus-within svg {
        color: var(--cn-primary);
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

    /* ---- Auth actions ---- */
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

    /* ---- Mobile toggler ---- */
    .cn-toggler {
        display: none;
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
        background: var(--cn-primary-dark);
    }

    /* ---- Explore offcanvas ---- */
    .cn-offcanvas {
        width: 400px;
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

    /* ---- Category drill-in menu (level 1 list + level 2 hover flyout) ---- */
    .cn-cat-menu {
        position: relative;
        border: 1px solid var(--cn-border);
        border-radius: 10px;
        background: var(--cn-bg);
        overflow: hidden;
        /* tall enough that the sliding child panel doesn't jump-resize the offcanvas */
        min-height: 40px;
    }

    .cn-cat-list {
        display: flex;
        flex-direction: column;
    }

    .cn-cat-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 14px;
        font-size: 14px;
        font-weight: 600;
        color: var(--cn-text);
        cursor: pointer;
        border-bottom: 1px solid var(--cn-border);
        transition: background .15s;
    }

    .cn-cat-row:last-child {
        border-bottom: none;
    }

    .cn-cat-row:hover,
    .cn-cat-row:focus-visible {
        background: var(--cn-light);
        outline: none;
    }

    .cn-accordion-label {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cn-cat-icon {
        width: 20px;
        height: 20px;
        object-fit: contain;
        border-radius: 4px;
    }

    .cn-cat-arrow {
        color: var(--cn-muted);
        flex-shrink: 0;
    }

    /* Child (sub-category) panel: slides in from the right and covers the list.
       Auto-opens on hover via JS adding the .open class; on touch devices JS
       adds it on tap instead, since there is no hover state to rely on. */
    .cn-cat-children {
        position: absolute;
        inset: 0;
        background: var(--cn-bg);
        display: flex;
        flex-direction: column;
        transform: translateX(100%);
        transition: transform .25s ease;
        pointer-events: none;
        max-height: 360px;
        overflow-y: auto;
    }

    .cn-cat-children.open {
        transform: translateX(0);
        pointer-events: auto;
    }

    .cn-cat-back {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        text-align: left;
        padding: 11px 14px;
        border: none;
        border-bottom: 1px solid var(--cn-border);
        background: var(--cn-light);
        color: var(--cn-primary-dark);
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        position: sticky;
        top: 0;
    }

    .cn-cat-children-body {
        padding: 8px;
        display: flex;
        flex-direction: column;
        gap: 2px;
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

    /* Sub-tabs (Providers/Locations, Jobs/Blog) */
    .cn-subtabs {
        display: flex;
        gap: 6px;
        background: var(--cn-light);
        padding: 4px;
        border-radius: 10px;
        margin-bottom: 12px;
    }

    .cn-subtab {
        flex: 1;
        border: none;
        background: none;
        padding: 8px 10px;
        font-size: 12.5px;
        font-weight: 700;
        color: var(--cn-muted);
        border-radius: 8px;
        cursor: pointer;
        transition: all .2s;
    }

    .cn-subtab.active {
        background: var(--cn-primary);
        color: #fff;
    }

    .cn-subtab-panel {
        display: none;
    }

    .cn-subtab-panel.active {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    #panelLatestJobs.active,
    #panelLatestBlog.active {
        flex-direction: column;
        flex-wrap: nowrap;
    }

    .cn-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 13px;
        font-size: 12.5px;
        font-weight: 600;
        border-radius: 20px;
        border: 1px solid var(--cn-border);
        color: var(--cn-text);
        text-decoration: none;
        transition: all .2s;
    }

    .cn-chip:hover {
        background: var(--cn-mint);
        border-color: var(--cn-mint);
        color: var(--cn-primary-dark);
    }

    .cn-chip-primary {
        background: var(--cn-primary);
        border-color: var(--cn-primary);
        color: #fff;
    }

    .cn-chip-primary:hover {
        background: var(--cn-primary-dark);
        color: #fff;
    }

    .cn-latest-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
        padding: 10px 12px;
        border-radius: 9px;
        text-decoration: none;
        transition: background .15s;
    }

    .cn-latest-item:hover {
        background: var(--cn-light);
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

        .cn-nav,
        .cn-utility .cn-search-bar,
        .cn-ai-btn span {
            display: none;
        }

        .cn-utility {
            justify-content: flex-end;
            flex: 0;
        }

        .cn-toggler {
            display: flex;
        }

        .cn-offcanvas {
            width: 340px;
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

        // Sub-tabs inside the Explore offcanvas (Providers/Locations, Jobs/Blog)
        document.querySelectorAll('.cn-subtabs').forEach((group) => {
            const buttons = group.querySelectorAll('.cn-subtab');
            buttons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const targetSelector = btn.getAttribute('data-target');
                    const panelGroup = btn.closest('.cn-explore-part');

                    buttons.forEach((b) => b.classList.remove('active'));
                    btn.classList.add('active');

                    panelGroup.querySelectorAll('.cn-subtab-panel').forEach((panel) => panel.classList.remove('active'));
                    const target = panelGroup.querySelector(targetSelector);
                    if (target) target.classList.add('active');
                });
            });
        });

        // Explore dropdown (desktop, ≥992px, hover-triggered — like a Bootstrap
        // dropdown) with a nested per-category submenu that opens on hover to
        // the right, like a classic Bootstrap dropdown-submenu.
        const exploreWrap = document.getElementById('cnExploreWrap');
        const exploreDropdown = document.getElementById('cnExploreDropdown');
        if (exploreWrap && exploreDropdown) {
            const OPEN_DELAY = 60;
            const CLOSE_DELAY = 220;
            let ddOpenTimer, ddCloseTimer;

            const ddItems = exploreDropdown.querySelectorAll('.cn-dd-item');

            const closeAllSubmenus = () => {
                ddItems.forEach((item) => {
                    const sub = item.querySelector('.cn-dd-submenu');
                    if (sub) sub.classList.remove('show', 'cn-dd-submenu--left');
                });
            };

            const openDropdown = () => {
                clearTimeout(ddCloseTimer);
                ddOpenTimer = setTimeout(() => {
                    exploreDropdown.classList.add('show');
                    document.getElementById('cnExploreBtn')?.setAttribute('aria-expanded', 'true');
                }, OPEN_DELAY);
            };

            const closeDropdown = () => {
                clearTimeout(ddOpenTimer);
                ddCloseTimer = setTimeout(() => {
                    exploreDropdown.classList.remove('show');
                    document.getElementById('cnExploreBtn')?.setAttribute('aria-expanded', 'false');
                    closeAllSubmenus();
                }, CLOSE_DELAY);
            };

            exploreWrap.addEventListener('mouseenter', openDropdown);
            exploreWrap.addEventListener('mouseleave', closeDropdown);
            exploreDropdown.addEventListener('mouseenter', () => clearTimeout(ddCloseTimer));
            exploreDropdown.addEventListener('mouseleave', closeDropdown);

            ddItems.forEach((item) => {
                const sub = item.querySelector('.cn-dd-submenu');
                if (!sub) return;
                let subCloseTimer;

                const openSub = () => {
                    clearTimeout(subCloseTimer);
                    closeAllSubmenus();
                    sub.classList.add('show');
                    // Flip to the left side if there isn't enough room on the right,
                    // so the submenu never gets clipped off-screen.
                    const rect = sub.getBoundingClientRect();
                    if (rect.right > window.innerWidth - 12) {
                        sub.classList.add('cn-dd-submenu--left');
                    }
                };
                const closeSub = () => {
                    subCloseTimer = setTimeout(() => sub.classList.remove('show'), CLOSE_DELAY);
                };

                item.addEventListener('mouseenter', openSub);
                item.addEventListener('mouseleave', closeSub);
                sub.addEventListener('mouseenter', () => clearTimeout(subCloseTimer));
                sub.addEventListener('mouseleave', closeSub);
            });

            // Keyboard access: focusing the button opens the dropdown; Escape closes it.
            const exploreBtn = document.getElementById('cnExploreBtn');
            if (exploreBtn) {
                exploreBtn.addEventListener('focus', openDropdown);
                exploreBtn.addEventListener('click', () => {
                    exploreDropdown.classList.contains('show') ? closeDropdown() : openDropdown();
                });
            }
            exploreWrap.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeDropdown();
            });
        }

        // Category drill-in menu: hover auto-opens the sub-category panel on
        // devices with a real pointer/hover (desktop). On touch devices, where
        // there is no hover state, it opens on tap instead. A "back" button
        // always returns to the category list, and leaving the whole menu
        // area closes any open child panel.
        const catMenu = document.getElementById('cnCatMenu');
        if (catMenu) {
            const rows = catMenu.querySelectorAll('.cn-cat-row');
            const children = catMenu.querySelectorAll('.cn-cat-children');
            const canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

            const openChild = (selector) => {
                children.forEach((child) => {
                    child.classList.toggle('open', ('#' + child.id) === selector);
                });
            };

            const closeChildren = () => {
                children.forEach((child) => child.classList.remove('open'));
            };

            rows.forEach((row) => {
                const target = row.getAttribute('data-cat-target');

                if (canHover) {
                    row.addEventListener('mouseenter', () => openChild(target));
                    row.addEventListener('focus', () => openChild(target));
                } else {
                    row.addEventListener('click', () => openChild(target));
                }

                // Keyboard access regardless of pointer type
                row.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        openChild(target);
                    }
                });
            });

            children.forEach((child) => {
                const backBtn = child.querySelector('.cn-cat-back');
                if (backBtn) {
                    backBtn.addEventListener('click', closeChildren);
                }
            });

            if (canHover) {
                catMenu.addEventListener('mouseleave', closeChildren);
            }

            // Always let the offcanvas close (e.g. via nav to a sub-category)
            // reset the menu back to the top level for next time it opens.
            const exploreOffcanvasEl = document.getElementById('exploreOffcanvas');
            if (exploreOffcanvasEl) {
                exploreOffcanvasEl.addEventListener('hidden.bs.offcanvas', closeChildren);
            }
        }
    })();
</script>