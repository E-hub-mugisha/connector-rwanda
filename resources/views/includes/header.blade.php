<header class="cn-header" id="cn-header">
    <div class="cn-inner">

        {{-- Logo --}}
        <a href="/" class="cn-logo">
            <img src="{{ asset('asset/images/logo/logo-connector-header.png') }}" alt="Connector" width="150">
        </a>

        {{-- Nav --}}
        <nav class="cn-nav" id="cnNav">
            <button class="cn-toggler" id="cnToggler" aria-label="Toggle navigation">
                <span></span><span></span><span></span>
            </button>
            <ul class="cn-nav-list" id="cnNavList">
                <li><a href="/" class="cn-link">Home</a></li>
                <li><a href="{{ route('home.service_categories') }}" class="cn-link">Categories</a></li>
                <li><a href="{{ route('home.services') }}" class="cn-link">Services</a></li>
                <li><a href="{{ route('home.service_provider') }}" class="cn-link">Providers</a></li>
                <li><a href="{{ route('home.jobs') }}" class="cn-link">Jobs</a></li>
                <li><a href="{{ route('home.blogs') }}" class="cn-link">Blog</a></li>
                <li><a href="{{ route('home.contact') }}" class="cn-link">Contact</a></li>
            </ul>
        </nav>

        {{-- Search --}}
        <form action="{{ route('services.search') }}" class="cn-search-bar">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35" />
            </svg>
            <input type="text" name="query" placeholder="Search services...">
        </form>

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

    </div>
</header>

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
        padding: 0 48px;
        transition: background .35s ease, box-shadow .35s ease, padding .35s ease;
        background: transparent;
    }

    .cn-header.scrolled {
        background: #fff;
        box-shadow: 0 2px 24px rgba(37, 64, 53, .08);
    }

    .cn-inner {
        display: flex;
        align-items: center;
        height: 72px;
        gap: 8px;
    }

    .cn-logo img {
        height: 38px;
    }

    /* ---- Nav ---- */
    .cn-nav {
        flex: 1;
        display: flex;
        justify-content: center;
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
        font-size: 14px;
        font-weight: 500;
        padding: 7px 13px;
        border-radius: 8px;
        color: rgba(255, 255, 255, .9);
        text-decoration: none;
        transition: background .2s, color .2s;
        white-space: nowrap;
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
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 24px;
        padding: 8px 16px;
        transition: all .3s;
        color: rgba(255, 255, 255, .75);
        min-width: 200px;
    }

    .cn-header.scrolled .cn-search-bar {
        background: var(--cn-light);
        border-color: rgba(107, 144, 128, .25);
        color: var(--cn-green);
    }

    .cn-search-bar input {
        background: none;
        border: none;
        outline: none;
        font-size: 13px;
        color: #fff;
        width: 140px;
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
        background: #6B9080;
        color: #fff;
        border: none;
        text-decoration: none;
        cursor: pointer;
        transition: background .25s;
        white-space: nowrap;
        display: inline-block;
    }

    .cn-btn-solid:hover {
        background: #254035;
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
        color: #6B9080;
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

    /* ---- Mobile toggler ---- */
    @media (max-width: 992px) {
        .cn-header {
            padding: 0 20px;
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

        .cn-nav {
            position: static;
            flex: unset;
            margin-left: auto;
        }

        .cn-nav-list {
            display: none;
            position: absolute;
            top: 72px;
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

        .cn-search-bar {
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
            document.addEventListener('click', () => drop.classList.remove('open'));
        }

        // Mobile nav toggle
        if (toggler && navList) {
            toggler.addEventListener('click', () => navList.classList.toggle('open'));
        }
    })();
</script>