@php
    $recentBookings = \App\Models\ServiceBooking::latest()
        ->take(5)
        ->get();

    $recentContacts = \App\Models\Contact::latest()
        ->take(5)
        ->get();
@endphp

<nav class="connector-topbar">

    {{-- MOBILE MENU --}}
    <button
        id="sidebarToggleTop"
        class="connector-mobile-toggle"
        type="button"
        aria-label="Open navigation"
    >
        <i class="fas fa-bars"></i>
    </button>


    {{-- PAGE CONTEXT --}}
    <div class="connector-header-context">

        <div class="connector-breadcrumb">
            <span>Admin</span>
            <i class="fas fa-chevron-right"></i>
            <strong>
                @yield('page_title', 'Dashboard')
            </strong>
        </div>

        <div class="connector-header-status">
            <span class="status-dot"></span>
            System operational
        </div>

    </div>


    {{-- GLOBAL SEARCH --}}
    <div class="connector-global-search">

        <i class="fas fa-search"></i>

        <input
            type="text"
            placeholder="Search anything..."
            id="globalAdminSearch"
            autocomplete="off"
        />

        <div class="connector-search-shortcut">
            Ctrl K
        </div>

    </div>


    {{-- HEADER ACTIONS --}}
    <div class="connector-header-actions">


        {{-- QUICK CREATE --}}
        <div class="dropdown">

            <button
                class="connector-icon-button"
                type="button"
                data-toggle="dropdown"
                aria-expanded="false"
                title="Quick actions"
            >
                <i class="fas fa-plus"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-right connector-dropdown connector-quick-menu">

                <div class="connector-dropdown-header">
                    <div>
                        <strong>Quick actions</strong>
                        <span>Create something new</span>
                    </div>
                </div>

                <a
                    href="{{ route('admin.create_service') }}"
                    class="connector-quick-action"
                >
                    <span class="quick-action-icon">
                        <i class="fas fa-briefcase"></i>
                    </span>

                    <span>
                        <strong>Add Service</strong>
                        <small>Create a marketplace service</small>
                    </span>
                </a>

                <a
                    href="{{ route('admin.add_blog') }}"
                    class="connector-quick-action"
                >
                    <span class="quick-action-icon">
                        <i class="fas fa-pen"></i>
                    </span>

                    <span>
                        <strong>Write Blog</strong>
                        <small>Publish new content</small>
                    </span>
                </a>

                <a
                    href="{{ route('admin.service_categories') }}"
                    class="connector-quick-action"
                >
                    <span class="quick-action-icon">
                        <i class="fas fa-folder-plus"></i>
                    </span>

                    <span>
                        <strong>Category</strong>
                        <small>Manage service categories</small>
                    </span>
                </a>

            </div>

        </div>


        {{-- NOTIFICATIONS --}}
        <div class="dropdown">

            <button
                class="connector-icon-button has-notification"
                type="button"
                data-toggle="dropdown"
                aria-expanded="false"
                title="Notifications"
            >
                <i class="far fa-bell"></i>
                @if($recentBookings->count() > 0)
                    <span class="notification-dot"></span>
                @endif
            </button>

            <div class="dropdown-menu dropdown-menu-right connector-dropdown connector-notification-menu">

                <div class="connector-dropdown-header">

                    <div>
                        <strong>Notifications</strong>
                        <span>Recent booking activity</span>
                    </div>

                    <span class="connector-count-badge">
                        {{ $recentBookings->count() }}
                    </span>

                </div>

                <div class="connector-notification-list">

                    @forelse($recentBookings as $booking)

                        <a
                            href="{{ route('admin.bookings') }}"
                            class="connector-notification-item"
                        >

                            <div class="notification-icon booking">
                                <i class="fas fa-calendar-check"></i>
                            </div>

                            <div class="notification-content">

                                <strong>
                                    New booking received
                                </strong>

                                <span>
                                    {{ $booking->names ?? 'Customer' }}
                                    @if($booking->location)
                                        · {{ $booking->location }}
                                    @endif
                                </span>

                                <small>
                                    {{ optional($booking->created_at)->diffForHumans() }}
                                </small>

                            </div>

                        </a>

                    @empty

                        <div class="connector-empty-state">
                            <i class="far fa-bell-slash"></i>
                            <span>No recent notifications</span>
                        </div>

                    @endforelse

                </div>

                <a
                    href="{{ route('admin.bookings') }}"
                    class="connector-dropdown-footer"
                >
                    View all bookings
                    <i class="fas fa-arrow-right"></i>
                </a>

            </div>

        </div>


        {{-- MESSAGES --}}
        <div class="dropdown">

            <button
                class="connector-icon-button has-notification"
                type="button"
                data-toggle="dropdown"
                aria-expanded="false"
                title="Messages"
            >
                <i class="far fa-comment-dots"></i>

                @if($recentContacts->count() > 0)
                    <span class="notification-dot"></span>
                @endif
            </button>

            <div class="dropdown-menu dropdown-menu-right connector-dropdown connector-message-menu">

                <div class="connector-dropdown-header">

                    <div>
                        <strong>Messages</strong>
                        <span>Latest contact requests</span>
                    </div>

                    <span class="connector-count-badge">
                        {{ $recentContacts->count() }}
                    </span>

                </div>

                <div class="connector-notification-list">

                    @forelse($recentContacts as $contact)

                        <a
                            href="{{ route('admin.messageDetail', $contact->id) }}"
                            class="connector-notification-item"
                        >

                            <div class="connector-avatar avatar-small">
                                {{ strtoupper(substr($contact->name ?? 'U', 0, 1)) }}
                            </div>

                            <div class="notification-content">

                                <strong>
                                    {{ $contact->name ?? 'New message' }}
                                </strong>

                                <span>
                                    {{ \Illuminate\Support\Str::limit($contact->message ?? 'New contact message', 48) }}
                                </span>

                                <small>
                                    {{ optional($contact->created_at)->diffForHumans() }}
                                </small>

                            </div>

                        </a>

                    @empty

                        <div class="connector-empty-state">
                            <i class="far fa-comment-slash"></i>
                            <span>No recent messages</span>
                        </div>

                    @endforelse

                </div>

                <a
                    href="{{ route('admin.messages') }}"
                    class="connector-dropdown-footer"
                >
                    Open message center
                    <i class="fas fa-arrow-right"></i>
                </a>

            </div>

        </div>


        {{-- DIVIDER --}}
        <div class="connector-header-divider"></div>


        {{-- USER PROFILE --}}
        <div class="dropdown">

            <button
                class="connector-profile-button"
                type="button"
                data-toggle="dropdown"
                aria-expanded="false"
            >

                <div class="connector-avatar">

                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}

                </div>

                <div class="connector-profile-summary">

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <span>
                        Administrator
                    </span>

                </div>

                <i class="fas fa-chevron-down connector-profile-chevron"></i>

            </button>


            <div class="dropdown-menu dropdown-menu-right connector-dropdown connector-profile-menu">

                <div class="connector-profile-header">

                    <div class="connector-avatar connector-avatar-large">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>

                    <div>

                        <strong>
                            {{ auth()->user()->name }}
                        </strong>

                        <span>
                            {{ auth()->user()->email }}
                        </span>

                    </div>

                </div>


                <div class="connector-profile-menu-links">

                    <button
                        type="button"
                        class="connector-profile-link"
                        data-toggle="modal"
                        data-target="#adminProfileModal"
                    >
                        <span>
                            <i class="far fa-user"></i>
                        </span>

                        <div>
                            <strong>My Profile</strong>
                            <small>Account information</small>
                        </div>
                    </button>


                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="connector-profile-link"
                    >
                        <span>
                            <i class="fas fa-th-large"></i>
                        </span>

                        <div>
                            <strong>Dashboard</strong>
                            <small>Back to overview</small>
                        </div>
                    </a>


                    <a
                        href="/"
                        target="_blank"
                        class="connector-profile-link"
                    >
                        <span>
                            <i class="fas fa-external-link-alt"></i>
                        </span>

                        <div>
                            <strong>View Website</strong>
                            <small>Open public website</small>
                        </div>
                    </a>

                </div>


                <div class="connector-profile-logout">

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >
                        @csrf

                        <button type="submit">

                            <i class="fas fa-sign-out-alt"></i>

                            <span>
                                Sign out
                            </span>

                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

</nav>


{{-- ==========================================
    PROFILE MODAL
=========================================== --}}
<div
    class="modal fade"
    id="adminProfileModal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >

        <div class="modal-content connector-profile-modal">

            <div class="connector-modal-header">

                <div>

                    <span class="connector-modal-eyebrow">
                        Account
                    </span>

                    <h4>
                        My Profile
                    </h4>

                    <p>
                        Manage your administrator information.
                    </p>

                </div>

                <button
                    type="button"
                    class="connector-modal-close"
                    data-dismiss="modal"
                >
                    <i class="fas fa-times"></i>
                </button>

            </div>


            <div class="connector-profile-modal-body">

                <div class="connector-profile-cover">

                    <div class="connector-modal-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>

                </div>


                <div class="connector-modal-user">

                    <h5>
                        {{ auth()->user()->name }}
                    </h5>

                    <span>
                        Administrator
                    </span>

                </div>


                <div class="connector-account-grid">

                    <div class="connector-account-item">

                        <div class="account-item-icon">
                            <i class="far fa-user"></i>
                        </div>

                        <div>
                            <label>Name</label>
                            <strong>
                                {{ auth()->user()->name ?? '—' }}
                            </strong>
                        </div>

                    </div>


                    <div class="connector-account-item">

                        <div class="account-item-icon">
                            <i class="far fa-envelope"></i>
                        </div>

                        <div>
                            <label>Email</label>
                            <strong>
                                {{ auth()->user()->email ?? '—' }}
                            </strong>
                        </div>

                    </div>


                    <div class="connector-account-item">

                        <div class="account-item-icon">
                            <i class="fas fa-phone"></i>
                        </div>

                        <div>
                            <label>Phone</label>
                            <strong>
                                {{ auth()->user()->phone ?? 'Not provided' }}
                            </strong>
                        </div>

                    </div>


                    <div class="connector-account-item">

                        <div class="account-item-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>

                        <div>
                            <label>Location</label>
                            <strong>
                                {{ auth()->user()->location ?? 'Not provided' }}
                            </strong>
                        </div>

                    </div>

                </div>

            </div>


            <div class="connector-modal-footer">

                <button
                    type="button"
                    class="btn connector-btn-secondary"
                    data-dismiss="modal"
                >
                    Close
                </button>

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="btn connector-btn-primary"
                >
                    Go to Dashboard
                </a>

            </div>

        </div>

    </div>
</div>


<style>
    .connector-topbar {
        min-height: 76px;
        width: 100%;
        background: rgba(255,255,255,.96);
        border-bottom: 1px solid #e5ece8;
        display: flex;
        align-items: center;
        padding: 0 26px;
        position: relative;
        z-index: 1020;
        box-shadow: 0 4px 18px rgba(37,64,53,.035);
    }

    .connector-mobile-toggle {
        width: 40px;
        height: 40px;
        border: 0;
        border-radius: 10px;
        background: #f2f6f4;
        color: #254035;
        display: none;
        align-items: center;
        justify-content: center;
        margin-right: 14px;
    }

    .connector-header-context {
        min-width: 200px;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .connector-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #8a9a93;
        font-size: 11px;
    }

    .connector-breadcrumb i {
        font-size: 7px;
        color: #b1bdb8;
    }

    .connector-breadcrumb strong {
        color: #254035;
        font-weight: 700;
    }

    .connector-header-status {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #84938d;
        font-size: 9px;
        font-weight: 600;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #5cbf8b;
    }

    .connector-global-search {
        height: 42px;
        width: min(360px, 28vw);
        margin-left: auto;
        margin-right: 25px;
        border: 1px solid #e4ebe8;
        background: #f8faf9;
        border-radius: 11px;
        display: flex;
        align-items: center;
        padding: 0 12px;
        transition: .2s ease;
    }

    .connector-global-search:focus-within {
        background: #fff;
        border-color: #9ab5aa;
        box-shadow: 0 0 0 3px rgba(107,144,128,.08);
    }

    .connector-global-search > i {
        color: #91a19a;
        font-size: 13px;
        margin-right: 9px;
    }

    .connector-global-search input {
        width: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        color: #254035;
        font-size: 11px;
    }

    .connector-global-search input::placeholder {
        color: #a0ada7;
    }

    .connector-search-shortcut {
        white-space: nowrap;
        border: 1px solid #e2e9e6;
        background: #fff;
        border-radius: 5px;
        padding: 3px 6px;
        color: #899991;
        font-size: 8px;
        font-weight: 700;
    }

    .connector-header-actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .connector-icon-button {
        width: 40px;
        height: 40px;
        border: 1px solid #e5ece9;
        background: #fff;
        color: #667a71;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: .18s ease;
    }

    .connector-icon-button:hover {
        background: #f4f8f6;
        color: #254035;
        border-color: #d7e3de;
    }

    .notification-dot {
        position: absolute;
        right: 8px;
        top: 7px;
        width: 6px;
        height: 6px;
        background: #d86b59;
        border-radius: 50%;
        border: 1.5px solid #fff;
    }

    .connector-header-divider {
        width: 1px;
        height: 32px;
        background: #e7ecea;
        margin: 0 6px;
    }

    .connector-profile-button {
        border: 0;
        background: transparent;
        display: flex;
        align-items: center;
        padding: 4px 2px 4px 7px;
        border-radius: 11px;
        transition: .18s ease;
    }

    .connector-profile-button:hover {
        background: #f6f9f7;
    }

    .connector-avatar {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 11px;
        background: #dfeae5;
        color: #315447;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 800;
    }

    .avatar-small {
        width: 35px;
        height: 35px;
        min-width: 35px;
        font-size: 11px;
        border-radius: 10px;
    }

    .connector-profile-summary {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-left: 9px;
        line-height: 1.2;
    }

    .connector-profile-summary strong {
        color: #254035;
        font-size: 11px;
        font-weight: 700;
    }

    .connector-profile-summary span {
        color: #91a099;
        font-size: 9px;
        margin-top: 3px;
    }

    .connector-profile-chevron {
        margin-left: 10px;
        color: #9aa9a3;
        font-size: 8px;
    }

    .connector-dropdown {
        width: 330px;
        margin-top: 9px;
        padding: 0;
        border: 1px solid #e4ebe8;
        border-radius: 15px;
        box-shadow: 0 18px 45px rgba(37,64,53,.12);
        overflow: hidden;
    }

    .connector-dropdown-header {
        padding: 17px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #edf1ef;
    }

    .connector-dropdown-header div {
        display: flex;
        flex-direction: column;
    }

    .connector-dropdown-header strong {
        color: #254035;
        font-size: 12px;
        font-weight: 800;
    }

    .connector-dropdown-header span {
        color: #91a099;
        font-size: 9px;
        margin-top: 4px;
    }

    .connector-count-badge {
        width: 25px;
        height: 25px;
        border-radius: 7px;
        background: #edf4f1;
        color: #4e7465;
        display: flex !important;
        align-items: center;
        justify-content: center;
        font-size: 9px !important;
        font-weight: 800;
        margin: 0 !important;
    }

    .connector-notification-item {
        padding: 13px 17px;
        display: flex;
        align-items: flex-start;
        gap: 11px;
        text-decoration: none !important;
        border-bottom: 1px solid #f0f3f2;
        transition: .15s ease;
    }

    .connector-notification-item:hover {
        background: #f7faf8;
    }

    .notification-icon {
        width: 34px;
        height: 34px;
        min-width: 34px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
    }

    .notification-icon.booking {
        background: #edf5f1;
        color: #608778;
    }

    .notification-content {
        min-width: 0;
        display: flex;
        flex-direction: column;
        line-height: 1.25;
    }

    .notification-content strong {
        color: #30473e;
        font-size: 10px;
        font-weight: 700;
    }

    .notification-content span {
        color: #82928b;
        font-size: 9px;
        margin-top: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .notification-content small {
        color: #a5b0ac;
        font-size: 8px;
        margin-top: 5px;
    }

    .connector-dropdown-footer {
        padding: 13px 17px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #527566 !important;
        text-decoration: none !important;
        font-size: 10px;
        font-weight: 700;
        background: #fbfcfb;
    }

    .connector-dropdown-footer:hover {
        background: #f3f7f5;
    }

    .connector-dropdown-footer i {
        font-size: 8px;
    }

    .connector-empty-state {
        min-height: 100px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 7px;
        color: #a0ada7;
        font-size: 9px;
    }

    .connector-empty-state i {
        font-size: 18px;
        color: #c2ccc7;
    }

    .connector-quick-action {
        padding: 12px 17px;
        display: flex;
        align-items: center;
        gap: 11px;
        text-decoration: none !important;
        transition: .15s ease;
    }

    .connector-quick-action:hover {
        background: #f7faf8;
    }

    .quick-action-icon {
        width: 35px;
        height: 35px;
        border-radius: 9px;
        background: #edf4f1;
        color: #54786a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
    }

    .connector-quick-action > span:last-child {
        display: flex;
        flex-direction: column;
    }

    .connector-quick-action strong {
        color: #30473e;
        font-size: 10px;
    }

    .connector-quick-action small {
        color: #98a49f;
        font-size: 8px;
        margin-top: 3px;
    }

    .connector-profile-menu {
        width: 290px;
    }

    .connector-profile-header {
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 11px;
        background: #f8faf9;
        border-bottom: 1px solid #e9efec;
    }

    .connector-avatar-large {
        width: 45px;
        height: 45px;
        min-width: 45px;
    }

    .connector-profile-header > div:last-child {
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .connector-profile-header strong {
        color: #254035;
        font-size: 11px;
        font-weight: 800;
    }

    .connector-profile-header span {
        color: #899992;
        font-size: 8px;
        margin-top: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .connector-profile-menu-links {
        padding: 7px;
    }

    .connector-profile-link {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        border: 0;
        background: transparent;
        text-decoration: none !important;
        border-radius: 9px;
        text-align: left;
        transition: .15s ease;
    }

    .connector-profile-link:hover {
        background: #f4f8f6;
    }

    .connector-profile-link > span {
        width: 31px;
        height: 31px;
        border-radius: 8px;
        background: #edf4f1;
        color: #5b7d6f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
    }

    .connector-profile-link > div {
        display: flex;
        flex-direction: column;
    }

    .connector-profile-link strong {
        color: #334b41;
        font-size: 9px;
    }

    .connector-profile-link small {
        color: #9aa7a2;
        font-size: 8px;
        margin-top: 3px;
    }

    .connector-profile-logout {
        border-top: 1px solid #edf1ef;
        padding: 8px;
    }

    .connector-profile-logout button {
        width: 100%;
        border: 0;
        background: #fff5f3;
        color: #bd6252;
        border-radius: 9px;
        min-height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 9px;
        font-weight: 700;
    }

    .connector-profile-modal {
        border: 0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 25px 70px rgba(24,48,40,.18);
    }

    .connector-modal-header {
        padding: 25px;
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid #edf1ef;
    }

    .connector-modal-eyebrow {
        color: #6b9080;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.3px;
    }

    .connector-modal-header h4 {
        color: #254035;
        font-size: 20px;
        font-weight: 800;
        margin: 6px 0 4px;
    }

    .connector-modal-header p {
        color: #87958f;
        font-size: 10px;
        margin: 0;
    }

    .connector-modal-close {
        width: 34px;
        height: 34px;
        border: 0;
        background: #f3f7f5;
        color: #75857e;
        border-radius: 9px;
    }

    .connector-profile-cover {
        height: 85px;
        background:
            linear-gradient(
                135deg,
                #254035,
                #6b9080
            );
        position: relative;
    }

    .connector-modal-avatar {
        width: 76px;
        height: 76px;
        border-radius: 20px;
        position: absolute;
        bottom: -38px;
        left: 25px;
        background: #fff;
        border: 5px solid #fff;
        color: #365b4d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 800;
        box-shadow: 0 8px 25px rgba(0,0,0,.12);
    }

    .connector-modal-user {
        padding: 48px 25px 20px;
    }

    .connector-modal-user h5 {
        color: #254035;
        font-size: 17px;
        font-weight: 800;
        margin: 0;
    }

    .connector-modal-user span {
        color: #71827b;
        font-size: 9px;
    }

    .connector-profile-modal-body {
        padding-bottom: 10px;
    }

    .connector-account-grid {
        padding: 0 25px 20px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .connector-account-item {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 12px;
        border: 1px solid #e9efec;
        border-radius: 11px;
        background: #fbfcfb;
    }

    .account-item-icon {
        width: 30px;
        height: 30px;
        min-width: 30px;
        border-radius: 8px;
        background: #edf4f1;
        color: #5c7d6f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
    }

    .connector-account-item > div:last-child {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .connector-account-item label {
        color: #9aa7a2;
        font-size: 8px;
        margin: 0 0 3px;
    }

    .connector-account-item strong {
        color: #344c42;
        font-size: 9px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .connector-modal-footer {
        padding: 15px 25px;
        background: #f8faf9;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .connector-btn-primary {
        background: #6b9080;
        border-color: #6b9080;
        color: #fff;
        border-radius: 9px;
        font-size: 10px;
        font-weight: 700;
        padding: 9px 14px;
    }

    .connector-btn-primary:hover {
        background: #557a6b;
        color: #fff;
    }

    .connector-btn-secondary {
        background: #fff;
        border: 1px solid #dfe8e4;
        color: #60746b;
        border-radius: 9px;
        font-size: 10px;
        font-weight: 700;
        padding: 9px 14px;
    }

    @media (max-width: 992px) {

        .connector-header-context {
            display: none;
        }

        .connector-global-search {
            width: min(300px, 40vw);
        }

        .connector-mobile-toggle {
            display: flex;
        }

    }

    @media (max-width: 768px) {

        .connector-topbar {
            min-height: 66px;
            padding: 0 14px;
        }

        .connector-global-search {
            width: auto;
            flex: 1;
            margin: 0 8px;
        }

        .connector-search-shortcut {
            display: none;
        }

        .connector-profile-summary,
        .connector-profile-chevron {
            display: none;
        }

        .connector-header-divider {
            display: none;
        }

        .connector-icon-button {
            width: 36px;
            height: 36px;
        }

        .connector-profile-button {
            padding-left: 3px;
        }

        .connector-dropdown {
            position: fixed !important;
            top: 65px !important;
            right: 10px !important;
            width: calc(100vw - 20px) !important;
            max-width: 360px;
            margin-top: 0;
        }

        .connector-account-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {

        .connector-global-search {
            max-width: none;
        }

        .connector-global-search > i {
            margin-right: 0;
        }

        .connector-global-search input {
            display: none;
        }

        .connector-profile-button {
            margin-left: 2px;
        }
    }
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const search = document.getElementById('globalAdminSearch');

    if (!search) {
        return;
    }

    document.addEventListener('keydown', function (event) {

        if (
            (event.ctrlKey || event.metaKey) &&
            event.key.toLowerCase() === 'k'
        ) {

            event.preventDefault();

            search.focus();
            search.select();

        }

    });

});
</script>