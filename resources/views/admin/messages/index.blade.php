@extends('layouts.app')

@section('title', 'Messages')

@section('content')

@php
    $messageData = $messages->map(function ($message) {
        return [
            'id' => $message->id,
            'name' => $message->name ?? 'Unknown',
            'email' => $message->email ?? '',
            'phone' => $message->phone ?? '',
            'subject' => $message->subject ?? 'No subject',
            'message' => $message->message ?? '',
            'created_at' => $message->created_at
                ? $message->created_at->format('M d, Y · H:i')
                : '',
        ];
    })->values()->all();
@endphp

<style>
    :root {
        --connector-primary: #6B9080;
        --connector-dark: #254035;
        --connector-light: #edf4f1;
        --connector-border: #e3ebe7;
        --connector-muted: #718078;
        --connector-bg: #f7f9f8;
    }

    .message-center {
        min-height: calc(100vh - 120px);
        background: var(--connector-bg);
        padding: 24px 0 40px;
    }

    .message-shell {
        background: #fff;
        border: 1px solid var(--connector-border);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(37, 64, 53, .06);
        display: flex;
        min-height: 680px;
    }

    /* LEFT SIDE */

    .message-sidebar {
        width: 370px;
        min-width: 370px;
        border-right: 1px solid var(--connector-border);
        background: #fff;
        display: flex;
        flex-direction: column;
    }

    .message-sidebar-header {
        padding: 22px 20px 16px;
        border-bottom: 1px solid var(--connector-border);
    }

    .message-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 17px;
    }

    .message-title {
        margin: 0;
        color: var(--connector-dark);
        font-size: 21px;
        font-weight: 800;
    }

    .message-count {
        min-width: 28px;
        height: 28px;
        padding: 0 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--connector-light);
        color: var(--connector-dark);
        border-radius: 50px;
        font-size: 11px;
        font-weight: 800;
    }

    .message-search {
        position: relative;
    }

    .message-search svg {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        width: 17px;
        height: 17px;
        fill: none;
        stroke: #8a9791;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .message-search input {
        width: 100%;
        height: 42px;
        border: 1px solid var(--connector-border);
        background: #f8faf9;
        border-radius: 10px;
        padding: 0 14px 0 40px;
        color: var(--connector-dark);
        font-size: 13px;
        outline: none;
    }

    .message-search input:focus {
        background: #fff;
        border-color: var(--connector-primary);
        box-shadow: 0 0 0 3px rgba(107, 144, 128, .10);
    }

    .message-list {
        flex: 1;
        overflow-y: auto;
    }

    .message-item {
        width: 100%;
        display: flex;
        gap: 13px;
        padding: 17px 18px;
        border: 0;
        border-bottom: 1px solid #eef2f0;
        background: #fff;
        text-align: left;
        cursor: pointer;
        transition: background .18s ease;
        position: relative;
    }

    .message-item:hover {
        background: #f8faf9;
    }

    .message-item.active {
        background: var(--connector-light);
    }

    .message-item.active::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: var(--connector-primary);
    }

    .message-avatar {
        width: 43px;
        height: 43px;
        min-width: 43px;
        border-radius: 12px;
        background: var(--connector-light);
        color: var(--connector-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 800;
    }

    .message-item-content {
        min-width: 0;
        flex: 1;
    }

    .message-item-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 4px;
    }

    .message-sender {
        color: var(--connector-dark);
        font-size: 13px;
        font-weight: 750;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .message-time {
        color: #8a9690;
        font-size: 10px;
        white-space: nowrap;
    }

    .message-subject {
        color: #43534c;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 4px;
    }

    .message-preview {
        color: #8a9690;
        font-size: 11px;
        line-height: 1.5;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .unread-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--connector-primary);
        margin-top: 5px;
    }

    /* RIGHT SIDE */

    .message-content {
        flex: 1;
        min-width: 0;
        background: #fff;
        display: flex;
        flex-direction: column;
    }

    .message-content-header {
        min-height: 82px;
        padding: 17px 25px;
        border-bottom: 1px solid var(--connector-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .selected-message-info {
        min-width: 0;
    }

    .selected-message-subject {
        margin: 0 0 5px;
        color: var(--connector-dark);
        font-size: 18px;
        font-weight: 800;
    }

    .selected-message-meta {
        color: var(--connector-muted);
        font-size: 11px;
    }

    .message-actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .message-action {
        width: 38px;
        height: 38px;
        border: 1px solid var(--connector-border);
        background: #fff;
        color: #68766f;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: .2s ease;
        text-decoration: none;
    }

    .message-action:hover {
        background: var(--connector-light);
        border-color: #cbdad3;
        color: var(--connector-dark);
        text-decoration: none;
    }

    .message-action.delete:hover {
        background: #fff1f1;
        border-color: #f1cccc;
        color: #b54d4d;
    }

    .message-action svg {
        width: 17px;
        height: 17px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.7;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .message-body {
        flex: 1;
        overflow-y: auto;
        padding: 30px;
    }

    .sender-card {
        display: flex;
        align-items: center;
        gap: 13px;
        padding-bottom: 23px;
        margin-bottom: 25px;
        border-bottom: 1px solid #edf1ef;
    }

    .sender-avatar-large {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 13px;
        background: var(--connector-light);
        color: var(--connector-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 850;
    }

    .sender-name {
        margin: 0 0 3px;
        color: var(--connector-dark);
        font-size: 14px;
        font-weight: 800;
    }

    .sender-email {
        color: var(--connector-muted);
        font-size: 11px;
    }

    .sender-email a {
        color: var(--connector-primary);
        text-decoration: none;
    }

    .sender-email a:hover {
        text-decoration: underline;
    }

    .message-date {
        margin-left: auto;
        color: #929d97;
        font-size: 10px;
        white-space: nowrap;
    }

    .message-full-text {
        max-width: 820px;
        color: #46564f;
        font-size: 14px;
        line-height: 1.85;
        white-space: pre-line;
    }

    .message-reply {
        margin-top: 35px;
        padding: 20px;
        border: 1px solid var(--connector-border);
        border-radius: 13px;
        background: #fafcfb;
    }

    .message-reply-title {
        margin: 0 0 5px;
        color: var(--connector-dark);
        font-size: 13px;
        font-weight: 800;
    }

    .message-reply-text {
        margin: 0 0 14px;
        color: var(--connector-muted);
        font-size: 11px;
    }

    .reply-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 38px;
        padding: 0 15px;
        border-radius: 9px;
        background: var(--connector-dark);
        color: #fff;
        font-size: 11px;
        font-weight: 750;
        text-decoration: none;
        transition: .2s ease;
    }

    .reply-btn:hover {
        background: #1d332a;
        color: #fff;
        text-decoration: none;
    }

    .reply-btn svg {
        width: 15px;
        height: 15px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* EMPTY */

    .message-empty {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px;
    }

    .message-empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 17px;
        border-radius: 20px;
        background: var(--connector-light);
        color: var(--connector-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .message-empty-icon svg {
        width: 32px;
        height: 32px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.5;
    }

    .message-empty h4 {
        color: var(--connector-dark);
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .message-empty p {
        color: var(--connector-muted);
        font-size: 12px;
        margin: 0;
    }

    .empty-inbox {
        padding: 60px 25px;
        text-align: center;
        color: var(--connector-muted);
    }

    .empty-inbox svg {
        width: 38px;
        height: 38px;
        margin-bottom: 12px;
        fill: none;
        stroke: #9ba8a2;
        stroke-width: 1.5;
    }

    .empty-inbox p {
        margin: 0;
        font-size: 12px;
    }

    .mobile-back {
        display: none;
        width: 34px;
        height: 34px;
        border: 1px solid var(--connector-border);
        border-radius: 8px;
        background: #fff;
        align-items: center;
        justify-content: center;
        color: var(--connector-dark);
        margin-right: 8px;
    }

    .mobile-back svg {
        width: 16px;
        height: 16px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
    }

    .hidden-message {
        display: none !important;
    }

    @media (max-width: 991px) {

        .message-sidebar {
            width: 320px;
            min-width: 320px;
        }

        .message-body {
            padding: 22px;
        }
    }

    @media (max-width: 767px) {

        .message-center {
            padding: 10px 0 25px;
        }

        .message-shell {
            min-height: calc(100vh - 150px);
            border-radius: 12px;
        }

        .message-sidebar {
            width: 100%;
            min-width: 100%;
            border-right: 0;
        }

        .message-content {
            display: none;
        }

        .message-shell.message-open .message-sidebar {
            display: none;
        }

        .message-shell.message-open .message-content {
            display: flex;
            width: 100%;
        }

        .mobile-back {
            display: inline-flex;
        }

        .message-content-header {
            padding: 15px;
        }

        .message-body {
            padding: 20px 15px;
        }

        .message-date {
            display: none;
        }
    }
</style>


<div class="message-center">

    <div class="container-fluid">

        <div class="message-shell" id="messageShell">

            {{-- =====================================================
                 MESSAGE LIST
            ====================================================== --}}
            <aside class="message-sidebar">

                <div class="message-sidebar-header">

                    <div class="message-title-row">

                        <h2 class="message-title">
                            Messages
                        </h2>

                        <span class="message-count">
                            {{ $messages->count() }}
                        </span>

                    </div>

                    <div class="message-search">

                        <svg viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="m20 20-4-4"></path>
                        </svg>

                        <input
                            type="text"
                            id="messageSearch"
                            placeholder="Search messages..."
                        >

                    </div>

                </div>


                <div class="message-list">

                    @forelse($messages as $message)

                        @php
                            $name = trim($message->name ?? 'Unknown');
                            $words = preg_split('/\s+/', $name);

                            $initials = strtoupper(
                                substr($words[0] ?? 'U', 0, 1) .
                                (isset($words[1]) ? substr($words[1], 0, 1) : '')
                            );
                        @endphp

                        <button
                            type="button"
                            class="message-item {{ $loop->first ? 'active' : '' }}"
                            data-message="{{ $message->id }}"
                            data-name="{{ strtolower($message->name ?? '') }}"
                            data-email="{{ strtolower($message->email ?? '') }}"
                            data-subject="{{ strtolower($message->subject ?? '') }}"
                        >

                            <div class="message-avatar">
                                {{ $initials }}
                            </div>

                            <div class="message-item-content">

                                <div class="message-item-top">

                                    <span class="message-sender">
                                        {{ $message->name }}
                                    </span>

                                    <span class="message-time">
                                        {{ $message->created_at ? $message->created_at->diffForHumans() : '' }}
                                    </span>

                                </div>

                                <div class="message-subject">
                                    {{ $message->subject ?: 'No subject' }}
                                </div>

                                <div class="message-preview">
                                    {{ Str::limit(strip_tags($message->message), 65) }}
                                </div>

                            </div>

                        </button>

                    @empty

                        <div class="empty-inbox">

                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                <path d="m3 7 9 6 9-6"></path>
                            </svg>

                            <p>No messages yet.</p>

                        </div>

                    @endforelse

                </div>

            </aside>


            {{-- =====================================================
                 MESSAGE READING PANEL
            ====================================================== --}}
            <section class="message-content">

                @if($messages->count())

                    @php
                        $firstMessage = $messages->first();

                        $firstName = trim($firstMessage->name ?? 'Unknown');
                        $firstWords = preg_split('/\s+/', $firstName);

                        $firstInitials = strtoupper(
                            substr($firstWords[0] ?? 'U', 0, 1) .
                            (isset($firstWords[1]) ? substr($firstWords[1], 0, 1) : '')
                        );
                    @endphp


                    {{-- HEADER --}}

                    <div class="message-content-header">

                        <div style="display:flex;align-items:center;min-width:0;">

                            <button
                                type="button"
                                class="mobile-back"
                                id="mobileBack"
                            >
                                <svg viewBox="0 0 24 24">
                                    <path d="m15 18-6-6 6-6"></path>
                                </svg>
                            </button>

                            <div class="selected-message-info">

                                <h1
                                    class="selected-message-subject"
                                    id="selectedSubject"
                                >
                                    {{ $firstMessage->subject ?: 'No subject' }}
                                </h1>

                                <div class="selected-message-meta">

                                    From
                                    <strong id="selectedSender">
                                        {{ $firstMessage->name }}
                                    </strong>

                                </div>

                            </div>

                        </div>


                        <div class="message-actions">

                            {{-- EMAIL --}}

                            <a
                                href="mailto:{{ $firstMessage->email }}"
                                class="message-action"
                                id="emailAction"
                                title="Reply by email"
                            >

                                <svg viewBox="0 0 24 24">
                                    <path d="M4 4h16v16H4z"></path>
                                    <path d="m4 5 8 7 8-7"></path>
                                </svg>

                            </a>


                            {{-- DELETE --}}

                            <form
                                id="deleteMessageForm"
                                action="{{ route('admin.delete_message', $firstMessage->id) }}"
                                method="POST"
                                style="margin:0;"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="message-action delete"
                                    title="Delete message"
                                    onclick="return confirm('Are you sure you want to delete this message?')"
                                >

                                    <svg viewBox="0 0 24 24">
                                        <path d="M4 7h16"></path>
                                        <path d="M9 7V4h6v3"></path>
                                        <path d="M7 7l1 13h8l1-13"></path>
                                        <path d="M10 11v5"></path>
                                        <path d="M14 11v5"></path>
                                    </svg>

                                </button>

                            </form>

                        </div>

                    </div>


                    {{-- MESSAGE BODY --}}

                    <div class="message-body">

                        <div class="sender-card">

                            <div
                                class="sender-avatar-large"
                                id="selectedAvatar"
                            >
                                {{ $firstInitials }}
                            </div>

                            <div>

                                <h3
                                    class="sender-name"
                                    id="selectedName"
                                >
                                    {{ $firstMessage->name }}
                                </h3>

                                <div class="sender-email">

                                    <a
                                        href="mailto:{{ $firstMessage->email }}"
                                        id="selectedEmail"
                                    >
                                        {{ $firstMessage->email }}
                                    </a>

                                    @if(!empty($firstMessage->phone))

                                        <span>
                                            · {{ $firstMessage->phone }}
                                        </span>

                                    @endif

                                </div>

                            </div>

                            <div
                                class="message-date"
                                id="selectedDate"
                            >
                                {{ $firstMessage->created_at ? $firstMessage->created_at->format('M d, Y · H:i') : '' }}
                            </div>

                        </div>


                        <div
                            class="message-full-text"
                            id="selectedMessage"
                        >
                            {!! nl2br(e($firstMessage->message)) !!}
                        </div>


                        <div class="message-reply">

                            <h4 class="message-reply-title">
                                Need to respond?
                            </h4>

                            <p class="message-reply-text">
                                Reply directly to this sender using your email client.
                            </p>

                            <a
                                href="mailto:{{ $firstMessage->email }}?subject={{ rawurlencode('Re: ' . ($firstMessage->subject ?: 'Your message')) }}"
                                class="reply-btn"
                                id="replyButton"
                            >

                                <svg viewBox="0 0 24 24">
                                    <path d="M22 2 11 13"></path>
                                    <path d="m22 2-7 20-4-9-9-4Z"></path>
                                </svg>

                                Reply by email

                            </a>

                        </div>

                    </div>

                @else

                    <div class="message-empty">

                        <div>

                            <div class="message-empty-icon">

                                <svg viewBox="0 0 24 24">
                                    <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                    <path d="m3 7 9 6 9-6"></path>
                                </svg>

                            </div>

                            <h4>
                                Your messages
                            </h4>

                            <p>
                                Select a message from the inbox to read it here.
                            </p>

                        </div>

                    </div>

                @endif

            </section>

        </div>

    </div>

</div>


@if($messages->count())

<script>
document.addEventListener('DOMContentLoaded', function () {

    const shell = document.getElementById('messageShell');
    const items = document.querySelectorAll('.message-item');
    const search = document.getElementById('messageSearch');

    const subject = document.getElementById('selectedSubject');
    const sender = document.getElementById('selectedSender');
    const selectedName = document.getElementById('selectedName');
    const selectedEmail = document.getElementById('selectedEmail');
    const selectedAvatar = document.getElementById('selectedAvatar');
    const selectedDate = document.getElementById('selectedDate');
    const selectedMessage = document.getElementById('selectedMessage');

    const emailAction = document.getElementById('emailAction');
    const replyButton = document.getElementById('replyButton');
    const deleteForm = document.getElementById('deleteMessageForm');
    const mobileBack = document.getElementById('mobileBack');


    /*
    |--------------------------------------------------------------------------
    | Message data
    |--------------------------------------------------------------------------
    */

    const messages = @json($messageData);


    /*
    |--------------------------------------------------------------------------
    | Initials
    |--------------------------------------------------------------------------
    */

    function getInitials(name) {

        if (!name) {
            return 'U';
        }

        const parts = name.trim().split(/\s+/);

        let initials = parts[0].charAt(0);

        if (parts.length > 1) {
            initials += parts[1].charAt(0);
        }

        return initials.toUpperCase();
    }


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        if (value === null || value === undefined) {
            return '';
        }

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }


    /*
    |--------------------------------------------------------------------------
    | Open message
    |--------------------------------------------------------------------------
    */

    function openMessage(id) {

        const message = messages.find(function (item) {
            return String(item.id) === String(id);
        });

        if (!message) {
            return;
        }


        /*
        | Active message
        */

        items.forEach(function (item) {
            item.classList.remove('active');
        });

        const activeItem = document.querySelector(
            '.message-item[data-message="' + id + '"]'
        );

        if (activeItem) {
            activeItem.classList.add('active');
        }


        /*
        | Header
        */

        subject.textContent = message.subject || 'No subject';

        sender.textContent = message.name || 'Unknown';


        /*
        | Sender information
        */

        selectedName.textContent = message.name || 'Unknown';

        selectedEmail.textContent = message.email || '';

        selectedEmail.href = 'mailto:' + message.email;

        selectedAvatar.textContent = getInitials(message.name);

        selectedDate.textContent = message.created_at || '';


        /*
        | Message body
        */

        selectedMessage.innerHTML = escapeHtml(
            message.message || ''
        ).replace(/\n/g, '<br>');


        /*
        | Email
        */

        emailAction.href = 'mailto:' + message.email;


        /*
        | Reply
        */

        const replySubject = encodeURIComponent(
            'Re: ' + (message.subject || 'Your message')
        );

        replyButton.href =
            'mailto:' +
            message.email +
            '?subject=' +
            replySubject;


        /*
        | Delete
        |
        | IMPORTANT:
        | This must match your Laravel route:
        | /admin/message/delete/{id}
        */

        deleteForm.action =
            "{{ url('/admin/message/delete') }}/" + message.id;


        /*
        | Mobile
        */

        shell.classList.add('message-open');
    }


    /*
    |--------------------------------------------------------------------------
    | Click message
    |--------------------------------------------------------------------------
    */

    items.forEach(function (item) {

        item.addEventListener('click', function () {

            openMessage(this.dataset.message);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Mobile back
    |--------------------------------------------------------------------------
    */

    if (mobileBack) {

        mobileBack.addEventListener('click', function () {

            shell.classList.remove('message-open');

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    if (search) {

        search.addEventListener('input', function () {

            const value = this.value.toLowerCase().trim();

            items.forEach(function (item) {

                const searchableText =
                    (item.dataset.name || '') + ' ' +
                    (item.dataset.email || '') + ' ' +
                    (item.dataset.subject || '');

                if (searchableText.includes(value)) {

                    item.classList.remove('hidden-message');

                } else {

                    item.classList.add('hidden-message');

                }

            });

        });

    }

});
</script>

@endif

@endsection