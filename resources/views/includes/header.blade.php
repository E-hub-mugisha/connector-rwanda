<header class="cn-header" id="cn-header">
    <div class="cn-inner">

        {{-- Logo --}}
        <a href="/" class="cn-logo">
            <img src="{{ asset('asset/images/logo/logo-connector-header.png') }}" alt="Connector" width="120">
        </a>

        {{-- Explore — opens the offcanvas --}}
        <button type="button" class="cn-explore-btn" id="cnExploreBtn" data-bs-toggle="offcanvas" data-bs-target="#exploreOffcanvas" aria-controls="exploreOffcanvas">
            <span class="cn-explore-hamburger" aria-hidden="true">
                <span></span><span></span><span></span>
            </span>
            <span class="cn-explore-label">
                <small>All</small>
            </span>
        </button>

        {{-- Big search tray (Amazon Style) --}}
        <form action="{{ route('services.search') }}" class="cn-search-tray">
            <select class="cn-search-select" aria-label="Search category">
                <option>All</option>
                @foreach($scategories ?? [] as $scat)
                <option value="{{ $scat->slug }}">{{ $scat->name }}</option>
                @endforeach
            </select>
            <input type="text" name="query" placeholder="Search services, providers, categories...">
            <button type="submit" class="cn-search-tray-go" aria-label="Search">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
            </button>
        </form>

        {{-- AI assistant + theme switch --}}
        <div class="cn-utility">
            <button type="button" class="cn-icon-btn cn-ai-btn" data-bs-toggle="modal" data-bs-target="#aiSearchModal" title="AI Search">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 3v3M12 18v3M4.2 4.2l2.1 2.1M17.7 17.7l2.1 2.1M3 12h3M18 12h3M4.2 19.8l2.1-2.1M17.7 6.3l2.1-2.1" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                <span>AI Assistant</span>
            </button>

            <button type="button" class="cn-icon-btn cn-theme-toggle" id="cnThemeToggle" title="Toggle theme" aria-label="Toggle light and dark theme">
                <svg width="18" height="18" class="cn-icon-sun" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="4" />
                    <path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" />
                </svg>
                <svg width="18" height="18" class="cn-icon-moon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
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
                <button class="cn-amz-link" id="userPill">
                    <small>Hello, {{ Str::words(auth()->user()->name, 1, '') }}</small>
                    <strong>Account & Lists</strong>
                    <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="m6 9 6 6 6-6" /></svg>
                </button>
                <ul class="cn-dropdown" id="userDropdown">
                    @if($utype === 'ADM')
                    <li><a href="{{ route('admin.dashboard') }}" target="_blank">Dashboard</a></li>
                    @elseif($utype === 'SVP')
                    <li><a href="{{ route('sprovider.dashboard') }}" target="_blank">Dashboard</a></li>
                    @else
                    <li><a href="{{ route('customer.dashboard') }}" target="_blank">Dashboard</a></li>
                    @endif
                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('cn-logout-form').submit();">Sign Out</a></li>
                </ul>
            </div>
            <form id="cn-logout-form" method="POST" action="{{ route('logout') }}" style="display:none">@csrf</form>
            @else
            <a href="#" class="cn-amz-link" data-bs-toggle="modal" data-bs-target="#loginModal">
                <small>Hello, sign in</small>
                <strong>Account & Lists</strong>
            </a>
            <a href="{{ route('register') }}" class="cn-amz-link">
                <small>New customer?</small>
                <strong>Get Started</strong>
            </a>
            @endauth
            @endif
        </div>

    </div>

    <form action="{{ route('services.search') }}" class="cn-search-tray cn-search-tray-mobile">
        <input type="text" name="query" placeholder="Search Connector...">
        <button type="submit" class="cn-search-tray-go">Go</button>
    </form>
</header>

{{-- ============ Explore Offcanvas ============ --}}
<div class="offcanvas offcanvas-start cn-offcanvas" tabindex="-1" id="exploreOffcanvas" aria-labelledby="exploreOffcanvasLabel">
    <div class="cn-offcanvas-header">
        <h5>Browse</h5>
        <button type="button" class="cn-offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
        </button>
    </div>

    <div class="cn-offcanvas-body">

        {{-- ============ PART 1 — Service Categories ============ --}}
        <div class="cn-explore-part">
            <h6 class="cn-part-title">Service Categories</h6>

            <div class="cn-dropdown-group">
                @forelse($scategories ?? [] as $scategory)
                @php $scatSubs = ($subcategories ?? collect())->where('service_category_id', $scategory->id); @endphp
                <div class="dropdown cn-explore-dropdown">
                    <button class="cn-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                        <span class="cn-dropdown-label">
                            <img src="{{ asset('image/categories') }}/{{ $scategory->image }}" alt="" class="cn-acc-icon">
                            {{ $scategory->name }}
                        </span>
                        <svg width="12" height="12" class="cn-dropdown-arrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="m9 18 6-6-6-6" /></svg>
                    </button>
                    <ul class="dropdown-menu cn-dropdown-menu">
                        <li><a class="dropdown-item cn-subcat-viewall" href="{{ route('home.service_by_category', ['category_slug' => $scategory->slug]) }}">View all {{ $scategory->name }}</a></li>
                        @if($scatSubs->isNotEmpty())<li><hr class="dropdown-divider cn-divider"></li>@endif
                        @forelse($scatSubs as $scat)
                        <li><a class="dropdown-item" href="{{ route('home.service_by_subcategory', ['subcategory_slug' => $scat->slug]) }}">{{ $scat->name }}</a></li>
                        @empty
                        <li><span class="cn-empty">No sub-categories yet.</span></li>
                        @endforelse
                    </ul>
                </div>
                @empty
                <p class="cn-empty">No categories available yet.</p>
                @endforelse

                <div class="dropdown cn-explore-dropdown">
                    <button class="cn-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                        <span class="cn-dropdown-label">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12Z" /><circle cx="12" cy="10" r="2.5" /></svg>
                            Providers by Location
                        </span>
                        <svg width="12" height="12" class="cn-dropdown-arrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="m9 18 6-6-6-6" /></svg>
                    </button>
                    <ul class="dropdown-menu cn-dropdown-menu">
                        <li><a class="dropdown-item cn-subcat-viewall" href="{{ route('home.service_provider') }}">All Providers</a></li>
                        @if(($locations ?? collect())->isNotEmpty())<li><hr class="dropdown-divider cn-divider"></li>@endif
                        @forelse($locations ?? [] as $location)
                        <li><a class="dropdown-item" href="{{ route('home.service_provider') }}?location={{ urlencode($location) }}">{{ $location }}</a></li>
                        @empty
                        <li><span class="cn-empty">No locations available yet.</span></li>
                        @endforelse
                    </ul>
                </div>

                <div class="dropdown cn-explore-dropdown">
                    <button class="cn-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                        <span class="cn-dropdown-label">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" /><rect x="14" y="3" width="7" height="7" /><rect x="14" y="14" width="7" height="7" /><rect x="3" y="14" width="7" height="7" /></svg>
                            By Category
                        </span>
                        <svg width="12" height="12" class="cn-dropdown-arrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="m9 18 6-6-6-6" /></svg>
                    </button>
                    <ul class="dropdown-menu cn-dropdown-menu">
                        <li><a class="dropdown-item cn-subcat-viewall" href="{{ route('home.service_provider') }}">All Providers</a></li>
                        @if(($scategories ?? collect())->isNotEmpty())<li><hr class="dropdown-divider cn-divider"></li>@endif
                        @forelse($scategories ?? [] as $scategory)
                        <li><a class="dropdown-item" href="{{ route('home.service_provider') }}?category={{ $scategory->slug }}">{{ $scategory->name }}</a></li>
                        @empty
                        <li><span class="cn-empty">No categories available yet.</span></li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- ============ PART 2 — Providers & Shops ============ --}}
        <div class="cn-explore-part">
            <h6 class="cn-part-title">Providers &amp; Shops</h6>
            <div class="cn-dropdown-group">
                <div class="dropdown cn-explore-dropdown">
                    <button class="cn-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                        <span class="cn-dropdown-label">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12Z" /><circle cx="12" cy="10" r="2.5" /></svg>
                            By Location
                        </span>
                        <svg width="12" height="12" class="cn-dropdown-arrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="m9 18 6-6-6-6" /></svg>
                    </button>
                    <ul class="dropdown-menu cn-dropdown-menu">
                        <li><a class="dropdown-item cn-subcat-viewall" href="{{ route('home.service_provider') }}">All Providers</a></li>
                        @if(($locations ?? collect())->isNotEmpty())<li><hr class="dropdown-divider cn-divider"></li>@endif
                        @forelse($locations ?? [] as $location)
                        <li><a class="dropdown-item" href="{{ route('home.service_provider') }}?location={{ urlencode($location) }}">{{ $location }}</a></li>
                        @empty
                        <li><span class="cn-empty">No locations available yet.</span></li>
                        @endforelse
                    </ul>
                </div>

                <div class="dropdown cn-explore-dropdown">
                    <button class="cn-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                        <span class="cn-dropdown-label">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" /><rect x="14" y="3" width="7" height="7" /><rect x="14" y="14" width="7" height="7" /><rect x="3" y="14" width="7" height="7" /></svg>
                            By Category
                        </span>
                        <svg width="12" height="12" class="cn-dropdown-arrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="m9 18 6-6-6-6" /></svg>
                    </button>
                    <ul class="dropdown-menu cn-dropdown-menu">
                        <li><a class="dropdown-item cn-subcat-viewall" href="{{ route('home.service_provider') }}">All Providers</a></li>
                        @if(($scategories ?? collect())->isNotEmpty())<li><hr class="dropdown-divider cn-divider"></li>@endif
                        @forelse($scategories ?? [] as $scategory)
                        <li><a class="dropdown-item" href="{{ route('home.service_provider') }}?category={{ $scategory->slug }}">{{ $scategory->name }}</a></li>
                        @empty
                        <li><span class="cn-empty">No categories available yet.</span></li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- ============ PART 3 — Latest Updates ============ --}}
        <div class="cn-explore-part">
            <h6 class="cn-part-title">Latest Updates</h6>
            <div class="cn-dropdown-group">
                <div class="dropdown cn-explore-dropdown">
                    <button class="cn-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                        <span class="cn-dropdown-label">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12a9 9 0 1 1-9-9" /><path d="M21 3v6h-6" /><path d="M12 7v5l3 3" /></svg>
                            Latest Updates
                        </span>
                        <svg width="12" height="12" class="cn-dropdown-arrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="m9 18 6-6-6-6" /></svg>
                    </button>
                    <ul class="dropdown-menu cn-dropdown-menu">
                        <li>
                            <a class="dropdown-item cn-latest-link" href="{{ route('home.jobs') }}">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="7" width="18" height="13" rx="2" /><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" /></svg>
                                <span class="cn-latest-text">
                                    <strong>Jobs</strong>
                                    <small>Browse open positions</small>
                                </span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider cn-divider"></li>
                        <li>
                            <a class="dropdown-item cn-latest-link" href="{{ route('home.blogs') }}">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h13a3 3 0 0 1 3 3v13H7a3 3 0 0 1-3-3V4Z" /><path d="M8 9h8M8 13h5" /></svg>
                                <span class="cn-latest-text">
                                    <strong>News &amp; Blog</strong>
                                    <small>Read latest articles</small>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="cn-explore-footer">
            <a href="{{ route('home.contact') }}" class="cn-btn-solid cn-btn-block">Contact Us</a>
        </div>

    </div>
</div>

{{-- ============ Modals (Search & Login) ============ --}}
<div class="modal fade" id="aiSearchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px">
        <div class="modal-content cn-modal cn-ai-modal">
            <button type="button" class="cn-modal-close" data-bs-dismiss="modal" aria-label="Close">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
            </button>
            <div class="cn-modal-header">
                <span class="cn-ai-badge">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 3v3M12 18v3M4.2 4.2l2.1 2.1M17.7 17.7l2.1 2.1M3 12h3M18 12h3M4.2 19.8l2.1-2.1M17.7 6.3l2.1-2.1" /><circle cx="12" cy="12" r="3" /></svg>
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

<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px">
        <div class="modal-content cn-modal">
            <button type="button" class="cn-modal-close" data-bs-dismiss="modal" aria-label="Close">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
            </button>
            <div class="cn-modal-header">
                <h2>Welcome back</h2>
                <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
            </div>
            <form method="POST" action="{{ route('login') }}" class="cn-modal-form">
                @csrf
                <div class="cn-field">
                    <label for="login_email">Email</label>
                    <input type="email" id="login_email" name="email" value="{{ old('email') }}" required autofocus class="{{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="you@example.com">
                    @error('email')<span class="cn-error">{{ $message }}</span>@enderror
                </div>
                <div class="cn-field">
                    <label for="login_password">Password</label>
                    <input type="password" id="login_password" name="password" required autocomplete="current-password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="••••••••">
                    @error('password')<span class="cn-error">{{ $message }}</span>@enderror
                </div>
                <div class="cn-field-row">
                    <label class="cn-checkbox"><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}><span>Keep me logged in</span></label>
                    @if(Route::has('password.request'))<a href="{{ route('password.request') }}" class="cn-link-muted">Forgot password?</a>@endif
                </div>
                <button type="submit" class="cn-btn-solid cn-btn-block">Login</button>
            </form>
        </div>
    </div>
</div>

{{-- ============ Styles ============ --}}
<style>
    :root {
        --cn-amz-navy: #131921;
        --cn-amz-navy-2: #232f3e;
        --cn-amz-yellow: #febd69;
        --cn-amz-yellow-hover: #f3a847;
        --cn-amz-orange: #ff9900;
        --cn-border: #ddd;
        --cn-text: #0f1111;
        --cn-muted: #555;
        --cn-bg: #ffffff;
        --cn-surface: #ffffff;
        --cn-hover: #eaeded;
    }

    [data-theme="dark"] {
        --cn-text: #e7e9ec;
        --cn-muted: #999;
        --cn-bg: #0f1111;
        --cn-surface: #1a2024;
        --cn-border: #3a4553;
        --cn-hover: #232f3e;
    }

    body { background: var(--cn-bg); color: var(--cn-text); font-family: "Amazon Ember", Arial, sans-serif; }

    /* ---- Header ---- */
    .cn-header {
        position: fixed; top: 0; left: 0; right: 0; z-index: 1050;
        background: var(--cn-amz-navy);
        padding: 0;
        height: 60px;
    }
    .cn-inner {
        display: flex; align-items: center; height: 100%; gap: 5px;
        padding: 0 10px;
    }

    /* ---- Shared Amazon Hover ---- */
    .cn-logo, .cn-explore-btn, .cn-amz-link, .cn-ai-btn, .cn-theme-toggle {
        display: inline-flex; align-items: center;
        border: 1px solid transparent;
        border-radius: 2px;
        padding: 8px 6px;
        cursor: pointer;
        background: transparent;
        color: #fff;
        text-decoration: none;
        height: 42px;
        transition: border-color .1s;
    }
    .cn-logo:hover, .cn-explore-btn:hover, .cn-amz-link:hover, .cn-ai-btn:hover, .cn-theme-toggle:hover {
        border-color: #fff;
    }
    .cn-logo img { height: 30px; }

    /* ---- Explore Button ---- */
    .cn-explore-btn { gap: 6px; }
    .cn-explore-hamburger { display: flex; flex-direction: column; gap: 3px; width: 16px; }
    .cn-explore-hamburger span { display: block; height: 2px; width: 100%; background: #fff; border-radius: 1px; }
    .cn-explore-label { display: flex; flex-direction: column; line-height: 1.1; font-weight: 700; font-size: 14px; }

    /* ---- Big Search Tray ---- */
    .cn-search-tray {
        flex: 1; display: flex; align-items: center; height: 40px;
        background: #fff; border-radius: 4px; overflow: hidden;
        border: 2px solid transparent; transition: box-shadow .2s;
        max-width: 700px; margin: 0 5px;
    }
    .cn-search-tray:focus-within { box-shadow: 0 0 0 3px rgba(254, 189, 105, 0.5); }
    .cn-search-select {
        height: 100%; background: #f3f3f3; border: none; border-right: 1px solid var(--cn-border);
        padding: 0 8px; font-size: 12px; color: #555; outline: none; cursor: pointer;
    }
    .cn-search-tray input {
        flex: 1; min-width: 0; background: none; border: none; outline: none;
        font-size: 15px; color: #111; padding: 0 10px;
    }
    .cn-search-tray-go {
        flex-shrink: 0; border: none; background: var(--cn-amz-yellow); color: #111;
        width: 45px; display: flex; align-items: center; justify-content: center; cursor: pointer;
    }
    .cn-search-tray-go:hover { background: var(--cn-amz-yellow-hover); }
    .cn-search-tray-mobile { display: none; margin: 5px 10px 10px; border-radius: 4px; height: 40px; }

    /* ---- AI + Theme ---- */
    .cn-utility { display: flex; align-items: center; gap: 5px; flex-shrink: 0; }
    .cn-ai-btn span { font-size: 13px; font-weight: 700; margin-left: 4px; }
    .cn-icon-moon { display: none; }
    [data-theme="dark"] .cn-icon-sun { display: none; }
    [data-theme="dark"] .cn-icon-moon { display: block; }

    /* ---- Account ---- */
    .cn-actions { display: flex; align-items: center; gap: 5px; flex-shrink: 0; }
    .cn-amz-link { flex-direction: column; align-items: flex-start; line-height: 1.1; padding: 4px 6px; }
    .cn-amz-link small { font-size: 11px; color: #ccc; font-weight: 400; }
    .cn-amz-link strong { font-size: 14px; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 3px; }

    /* User Dropdown */
    .cn-user-menu { position: relative; }
    .cn-dropdown {
        display: none; position: absolute; top: calc(100% + 2px); right: 0;
        background: var(--cn-surface); border: 1px solid var(--cn-border); border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 200px; padding: 6px; list-style: none; margin: 0; z-index: 1060;
    }
    .cn-dropdown.open { display: block; }
    .cn-dropdown li a { display: flex; align-items: center; gap: 8px; padding: 8px 12px; font-size: 13px; color: var(--cn-text); border-radius: 2px; text-decoration: none; }
    .cn-dropdown li a:hover { background: var(--cn-hover); }
    .cn-dropdown li:last-child a { color: #c0392b; }

    /* ---- Explore Offcanvas ---- */
    .cn-offcanvas { width: 370px; max-width: 92vw; background: var(--cn-surface); color: var(--cn-text); border: none; }
    .cn-offcanvas-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background: var(--cn-amz-navy-2); color: #fff; }
    .cn-offcanvas-header h5 { margin: 0; font-size: 18px; font-weight: 700; }
    .cn-offcanvas-close { background: none; border: none; color: #fff; cursor: pointer; padding: 0; display: flex; }
    .cn-offcanvas-body { padding: 15px 0; overflow-y: auto; }
    .cn-part-title { font-size: 16px; font-weight: 700; color: var(--cn-text); padding: 8px 20px; margin-bottom: 5px; border-bottom: 1px solid var(--cn-border); }
    
    .cn-dropdown-group { display: flex; flex-direction: column; }
    .cn-explore-dropdown { position: static !important; }
    .cn-dropdown-toggle {
        width: 100%; display: flex; align-items: center; justify-content: space-between;
        padding: 10px 20px; font-size: 14px; font-weight: 500; color: var(--cn-text);
        background: none; border: none; text-align: left; cursor: pointer; transition: background .1s;
    }
    .cn-dropdown-toggle:hover, .cn-dropdown-toggle:focus-visible { background: var(--cn-hover); outline: none; }
    .cn-dropdown-toggle.show { background: var(--cn-hover); }
    .cn-dropdown-label { display: flex; align-items: center; gap: 10px; }
    .cn-dropdown-label svg { color: var(--cn-text); flex-shrink: 0; }
    .cn-acc-icon { width: 24px; height: 24px; object-fit: contain; border-radius: 4px; }
    .cn-dropdown-arrow { color: var(--cn-muted); transition: transform .2s ease; }
    .cn-dropdown-toggle.show .cn-dropdown-arrow { transform: rotate(90deg); }

    /* Floating Popover Styles */
    .cn-dropdown-menu {
        width: 340px !important; max-width: 80vw !important;
        border: 1px solid var(--cn-border) !important; border-radius: 4px !important;
        background: var(--cn-surface) !important; padding: 12px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important; z-index: 1060 !important;
        max-height: 70vh; overflow-y: auto;
    }
    .cn-dropdown-menu .dropdown-item {
        padding: 8px 10px; font-size: 13px; color: var(--cn-text); border-radius: 2px;
        display: flex; align-items: center; gap: 8px; text-decoration: none; background: none; border: none; width: 100%;
    }
    .cn-dropdown-menu .dropdown-item:hover, .cn-dropdown-menu .dropdown-item:focus {
        background: var(--cn-hover); color: var(--cn-text);
    }
    .cn-dropdown-menu .cn-subcat-viewall { font-weight: 700; color: var(--cn-amz-orange); }
    .cn-divider { border-color: var(--cn-border); margin: 6px 0; }

    .cn-latest-link { flex-direction: row !important; align-items: flex-start !important; gap: 10px !important; padding: 10px !important; }
    .cn-latest-link svg { color: var(--cn-text); flex-shrink: 0; margin-top: 1px; }
    .cn-latest-text { display: flex; flex-direction: column; line-height: 1.3; }
    .cn-latest-text strong { font-size: 14px; font-weight: 700; color: var(--cn-text); }
    .cn-latest-text small { font-size: 12px; color: var(--cn-muted); }

    .cn-empty { font-size: 13px; color: var(--cn-muted); padding: 6px 10px; display: block; }
    .cn-explore-footer { padding: 20px; margin-top: 10px; border-top: 1px solid var(--cn-border); }
    .cn-btn-solid { background: var(--cn-amz-yellow); color: #111; border: 1px solid #a88734; padding: 8px 20px; border-radius: 4px; font-weight: 700; text-decoration: none; cursor: pointer; transition: background .1s; display: inline-block; }
    .cn-btn-solid:hover { background: var(--cn-amz-yellow-hover); color: #111; }
    .cn-btn-block { width: 100%; text-align: center; padding: 10px; font-size: 15px; }

    /* ---- Modals ---- */
    .cn-modal { border: none; border-radius: 8px; padding: 32px; position: relative; background: var(--cn-surface); color: var(--cn-text); }
    .cn-modal-close { position: absolute; top: 16px; right: 16px; background: none; border: none; color: var(--cn-muted); cursor: pointer; }
    .cn-modal-header { margin-bottom: 24px; }
    .cn-modal-header h2 { font-size: 22px; font-weight: 700; margin-bottom: 6px; }
    .cn-modal-header p { font-size: 14px; color: var(--cn-muted); }
    .cn-modal-header a { color: var(--cn-amz-orange); text-decoration: none; }
    .cn-ai-badge { display: inline-flex; align-items: center; gap: 6px; background: var(--cn-hover); color: var(--cn-text); font-size: 11.5px; font-weight: 700; padding: 5px 12px; border-radius: 12px; margin-bottom: 12px; }
    .cn-modal-form { display: flex; flex-direction: column; gap: 16px; }
    .cn-field { display: flex; flex-direction: column; gap: 6px; }
    .cn-field label { font-size: 13px; font-weight: 700; }
    .cn-field input, .cn-field textarea {
        padding: 8px 12px; border: 1px solid var(--cn-border); border-radius: 4px; font-size: 14px; color: var(--cn-text);
        background: var(--cn-bg); outline: none; font-family: inherit; resize: vertical;
    }
    .cn-field input:focus, .cn-field textarea:focus { border-color: var(--cn-amz-yellow); box-shadow: 0 0 3px rgba(254, 189, 105, 0.5); }
    .cn-field input.is-invalid { border-color: #e74c3c; }
    .cn-error { font-size: 12px; color: #e74c3c; }
    .cn-field-row { display: flex; align-items: center; justify-content: space-between; }
    .cn-checkbox { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--cn-muted); cursor: pointer; }
    .cn-link-muted { font-size: 13px; color: var(--cn-amz-orange); text-decoration: none; }

    /* ---- Responsive ---- */
    @media (max-width: 992px) {
        .cn-inner .cn-search-tray { display: none; }
        .cn-ai-btn span { display: none; }
        .cn-amz-link small { display: none; }
        .cn-amz-link strong { font-size: 13px; }
        .cn-search-tray-mobile { display: flex; }
    }
</style>

{{-- ============ Script ============ --}}
<script>
    (function () {
        const hdr = document.getElementById('cn-header');
        const pill = document.getElementById('userPill');
        const drop = document.getElementById('userDropdown');
        const themeToggle = document.getElementById('cnThemeToggle');

        // Sticky scroll
        const onScroll = () => hdr.classList.toggle('scrolled', window.scrollY > 40);
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        // User dropdown (custom — header)
        if (pill && drop) {
            pill.addEventListener('click', (e) => {
                e.stopPropagation();
                drop.classList.toggle('open');
            });
            document.addEventListener('click', (e) => {
                if (!pill.contains(e.target)) drop.classList.remove('open');
            });
        }

        // Theme switcher (persisted)
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

        // Initialize Dropdowns as floating Popovers
        document.querySelectorAll('#exploreOffcanvas .dropdown-toggle').forEach(toggle => {
            bootstrap.Dropdown.getOrCreateInstance(toggle, {
                popperConfig: {
                    strategy: 'fixed', // Escapes the overflow: hidden of the offcanvas body
                    placement: 'right-start', // Forces it to pop out to the right
                    modifiers: [
                        {
                            name: 'offset',
                            options: { offset: [0, 5] }
                        },
                        {
                            name: 'flip',
                            options: {
                                fallbackPlacements: ['bottom-start', 'left-start']
                            }
                        }
                    ]
                }
            });
        });

        // Close all open dropdowns inside offcanvas when it closes or scrolls
        const exploreOffcanvasEl = document.getElementById('exploreOffcanvas');
        if (exploreOffcanvasEl) {
            exploreOffcanvasEl.addEventListener('hidden.bs.offcanvas', () => {
                exploreOffcanvasEl.querySelectorAll('.cn-dropdown-toggle.show').forEach((btn) => {
                    const dd = bootstrap.Dropdown.getInstance(btn);
                    if (dd) dd.hide();
                });
            });

            const offcanvasBody = exploreOffcanvasEl.querySelector('.cn-offcanvas-body');
            if (offcanvasBody) {
                offcanvasBody.addEventListener('scroll', () => {
                    exploreOffcanvasEl.querySelectorAll('.cn-dropdown-toggle.show').forEach((btn) => {
                        const dd = bootstrap.Dropdown.getInstance(btn);
                        if (dd) dd.hide();
                    });
                });
            }
        }
    })();
</script>