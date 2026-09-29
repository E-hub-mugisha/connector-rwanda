@extends('layouts.base')

@section('title', 'Frequently Asked Questions')

@section('content')

<style>
    :root {
        --primary: #254035;
        --accent: #6B9080;
        --accent-soft: #edf3f0;
        --text: #18231e;
        --muted: #6f7b75;
        --border: #e5ebe8;
        --soft: #f8faf9;
        --white: #ffffff;
    }

    .faq-page {
        background: var(--soft);
        color: var(--text);
    }

    /* Hero */
    .faq-hero {
        padding: 90px 0 80px;
        background: var(--white);
        border-bottom: 1px solid var(--border);
    }

    .faq-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 13px;
        border-radius: 50px;
        background: var(--accent-soft);
        color: var(--primary);
        font-size: 13px;
        font-weight: 700;
        letter-spacing: .02em;
        margin-bottom: 20px;
    }

    .faq-eyebrow i {
        font-size: 14px;
    }

    .faq-hero h1 {
        max-width: 760px;
        margin: 0 auto 18px;
        color: var(--primary);
        font-size: clamp(38px, 5vw, 62px);
        line-height: 1.08;
        font-weight: 750;
        letter-spacing: -0.04em;
    }

    .faq-hero p {
        max-width: 650px;
        margin: 0 auto;
        color: var(--muted);
        font-size: 17px;
        line-height: 1.8;
    }

    /* Search */
    .faq-search-wrapper {
        max-width: 700px;
        margin: 35px auto 0;
    }

    .faq-search {
        position: relative;
    }

    .faq-search i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--accent);
        font-size: 19px;
        z-index: 2;
    }

    .faq-search input {
        width: 100%;
        height: 60px;
        padding: 0 22px 0 53px;
        border: 1px solid var(--border);
        border-radius: 16px;
        background: var(--white);
        color: var(--text);
        font-size: 15px;
        outline: none;
        box-shadow: 0 10px 35px rgba(37, 64, 53, .06);
        transition: all .2s ease;
    }

    .faq-search input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 4px rgba(107, 144, 128, .12);
    }

    /* Main */
    .faq-section {
        padding: 80px 0;
    }

    .faq-layout {
        display: grid;
        grid-template-columns: 240px minmax(0, 1fr);
        gap: 60px;
        align-items: start;
    }

    /* Categories */
    .faq-sidebar {
        position: sticky;
        top: 100px;
    }

    .faq-sidebar-title {
        color: var(--primary);
        font-size: 14px;
        font-weight: 750;
        margin-bottom: 15px;
    }

    .faq-category-list {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .faq-category {
        display: flex;
        align-items: center;
        gap: 11px;
        width: 100%;
        padding: 11px 13px;
        border: 0;
        border-radius: 10px;
        background: transparent;
        color: var(--muted);
        font-size: 14px;
        font-weight: 600;
        text-align: left;
        transition: all .2s ease;
    }

    .faq-category i {
        width: 18px;
        text-align: center;
        font-size: 16px;
    }

    .faq-category:hover,
    .faq-category.active {
        background: var(--accent-soft);
        color: var(--primary);
    }

    /* FAQ groups */
    .faq-group {
        margin-bottom: 55px;
    }

    .faq-group:last-child {
        margin-bottom: 0;
    }

    .faq-group-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-bottom: 18px;
    }

    .faq-group-icon {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: var(--accent-soft);
        color: var(--primary);
        font-size: 18px;
        flex-shrink: 0;
    }

    .faq-group-heading h2 {
        margin: 0;
        color: var(--primary);
        font-size: 23px;
        font-weight: 750;
        letter-spacing: -.02em;
    }

    .faq-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .faq-item {
        border: 1px solid var(--border);
        border-radius: 14px;
        background: var(--white);
        overflow: hidden;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .faq-item:hover {
        border-color: #d5dfda;
    }

    .faq-item.active {
        border-color: rgba(107, 144, 128, .55);
        box-shadow: 0 8px 30px rgba(37, 64, 53, .05);
    }

    .faq-question {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 20px 22px;
        border: 0;
        background: transparent;
        color: var(--primary);
        text-align: left;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.5;
    }

    .faq-question:hover {
        color: var(--accent);
    }

    .faq-question-icon {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--accent-soft);
        color: var(--primary);
        flex-shrink: 0;
        transition: transform .25s ease;
    }

    .faq-item.active .faq-question-icon {
        transform: rotate(180deg);
    }

    .faq-answer {
        padding: 0 22px 22px;
        color: var(--muted);
        font-size: 14px;
        line-height: 1.8;
    }

    .faq-answer p {
        margin: 0;
    }

    .faq-answer a {
        color: var(--primary);
        font-weight: 700;
        text-decoration: none;
    }

    .faq-answer a:hover {
        color: var(--accent);
    }

    /* Empty search */
    .faq-empty {
        display: none;
        padding: 45px 25px;
        border: 1px dashed var(--border);
        border-radius: 16px;
        background: var(--white);
        text-align: center;
        color: var(--muted);
    }

    .faq-empty i {
        display: block;
        margin-bottom: 12px;
        color: var(--accent);
        font-size: 30px;
    }

    .faq-empty h3 {
        margin-bottom: 6px;
        color: var(--primary);
        font-size: 18px;
    }

    .faq-empty p {
        margin: 0;
        font-size: 14px;
    }

    /* CTA */
    .faq-cta {
        padding: 0 0 80px;
    }

    .faq-cta-card {
        position: relative;
        overflow: hidden;
        padding: 50px;
        border-radius: 24px;
        background: var(--primary);
    }

    .faq-cta-card::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        right: -90px;
        top: -120px;
        border-radius: 50%;
        background: rgba(107, 144, 128, .18);
    }

    .faq-cta-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
    }

    .faq-cta h2 {
        margin-bottom: 12px;
        color: #fff;
        font-size: 30px;
        font-weight: 750;
        letter-spacing: -.025em;
    }

    .faq-cta p {
        margin-bottom: 25px;
        color: rgba(255,255,255,.72);
        font-size: 15px;
        line-height: 1.7;
    }

    .faq-cta .btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 12px 20px;
        border-radius: 10px;
        border: 0;
        background: #fff;
        color: var(--primary);
        font-size: 14px;
        font-weight: 700;
    }

    .faq-cta .btn:hover {
        background: var(--accent-soft);
        color: var(--primary);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .faq-hero {
            padding: 70px 0 65px;
        }

        .faq-layout {
            grid-template-columns: 1fr;
            gap: 35px;
        }

        .faq-sidebar {
            position: static;
        }

        .faq-category-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .faq-section {
            padding: 65px 0;
        }
    }

    @media (max-width: 575px) {
        .faq-hero {
            padding: 55px 0;
        }

        .faq-hero p {
            font-size: 15px;
        }

        .faq-search input {
            height: 54px;
        }

        .faq-section {
            padding: 50px 0;
        }

        .faq-category-list {
            grid-template-columns: 1fr;
        }

        .faq-group {
            margin-bottom: 42px;
        }

        .faq-group-heading h2 {
            font-size: 20px;
        }

        .faq-question {
            padding: 17px;
            font-size: 14px;
        }

        .faq-answer {
            padding: 0 17px 18px;
            font-size: 13px;
        }

        .faq-cta-card {
            padding: 35px 25px;
            border-radius: 20px;
        }

        .faq-cta h2 {
            font-size: 25px;
        }
    }
</style>

<div class="faq-page">

    {{-- Hero --}}
    <section class="faq-hero">
        <div class="container text-center">

            <div class="faq-eyebrow">
                <i class="bi bi-question-circle"></i>
                Help Center
            </div>

            <h1>
                Frequently Asked Questions
            </h1>

            <p>
                Find answers to common questions about finding services,
                connecting with providers, creating an account, and using Connector.
            </p>

            <div class="faq-search-wrapper">
                <div class="faq-search">
                    <i class="bi bi-search"></i>

                    <input
                        type="search"
                        id="faqSearch"
                        class="form-control"
                        placeholder="Search your question..."
                        autocomplete="off"
                    >
                </div>
            </div>

        </div>
    </section>


    {{-- FAQ Content --}}
    <section class="faq-section">
        <div class="container">

            <div class="faq-layout">

                {{-- Sidebar --}}
                <aside class="faq-sidebar">

                    <div class="faq-sidebar-title">
                        Browse by topic
                    </div>

                    <div class="faq-category-list">

                        <button
                            type="button"
                            class="faq-category active"
                            data-target="general"
                        >
                            <i class="bi bi-info-circle"></i>
                            General
                        </button>

                        <button
                            type="button"
                            class="faq-category"
                            data-target="customers"
                        >
                            <i class="bi bi-person"></i>
                            Customers
                        </button>

                        <button
                            type="button"
                            class="faq-category"
                            data-target="providers"
                        >
                            <i class="bi bi-briefcase"></i>
                            Service Providers
                        </button>

                        <button
                            type="button"
                            class="faq-category"
                            data-target="account"
                        >
                            <i class="bi bi-person-gear"></i>
                            Account
                        </button>

                        <button
                            type="button"
                            class="faq-category"
                            data-target="payments"
                        >
                            <i class="bi bi-credit-card"></i>
                            Payments
                        </button>

                        <button
                            type="button"
                            class="faq-category"
                            data-target="safety"
                        >
                            <i class="bi bi-shield-check"></i>
                            Safety & Trust
                        </button>

                    </div>

                </aside>


                {{-- Questions --}}
                <div class="faq-content">

                    <div class="faq-empty" id="faqEmpty">
                        <i class="bi bi-search"></i>

                        <h3>No questions found</h3>

                        <p>
                            Try using different words or browse the categories.
                        </p>
                    </div>


                    {{-- General --}}
                    <div class="faq-group" data-category="general">

                        <div class="faq-group-heading">
                            <div class="faq-group-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>

                            <h2>General</h2>
                        </div>

                        <div class="faq-list">

                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqGeneralOne"
                                    aria-expanded="false"
                                >
                                    <span>What is Connector?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqGeneralOne"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            Connector is a service marketplace that helps customers
                                            discover and connect with service providers. Whether you
                                            need a professional service or want to offer your skills,
                                            Connector provides a place to make that connection.
                                        </p>
                                    </div>
                                </div>

                            </div>


                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqGeneralTwo"
                                >
                                    <span>What can I find on Connector?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqGeneralTwo"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            You can discover different services offered by
                                            professionals and businesses. Services may include
                                            technology, design, home services, professional services,
                                            creative work, and other categories available on the platform.
                                        </p>
                                    </div>
                                </div>

                            </div>


                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqGeneralThree"
                                >
                                    <span>Is Connector only for businesses?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqGeneralThree"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            No. Connector can be used by individuals, professionals,
                                            freelancers, and businesses looking for services or offering
                                            their expertise.
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- Customers --}}
                    <div class="faq-group" data-category="customers">

                        <div class="faq-group-heading">
                            <div class="faq-group-icon">
                                <i class="bi bi-person"></i>
                            </div>

                            <h2>For Customers</h2>
                        </div>

                        <div class="faq-list">

                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqCustomerOne"
                                >
                                    <span>How do I find a service?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqCustomerOne"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            Browse the available service categories or use the search
                                            functionality to find a service that matches your needs.
                                            You can then review the available service information and
                                            provider details.
                                        </p>
                                    </div>
                                </div>

                            </div>


                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqCustomerTwo"
                                >
                                    <span>How do I contact a service provider?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqCustomerTwo"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            Open the service you are interested in and use the
                                            available contact or connection options to communicate
                                            with the provider.
                                        </p>
                                    </div>
                                </div>

                            </div>


                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqCustomerThree"
                                >
                                    <span>Can I compare different service providers?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqCustomerThree"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            Yes. You can review different services and provider
                                            information before deciding who you would like to contact.
                                            This allows you to make an informed choice based on the
                                            information available on the platform.
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- Providers --}}
                    <div class="faq-group" data-category="providers">

                        <div class="faq-group-heading">
                            <div class="faq-group-icon">
                                <i class="bi bi-briefcase"></i>
                            </div>

                            <h2>For Service Providers</h2>
                        </div>

                        <div class="faq-list">

                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqProviderOne"
                                >
                                    <span>How can I become a service provider?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqProviderOne"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            Create an account and complete your provider profile.
                                            Once your profile is ready, you can add the services you
                                            offer and provide relevant information for customers to
                                            discover.
                                        </p>
                                    </div>
                                </div>

                            </div>


                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqProviderTwo"
                                >
                                    <span>What information should I include in my service?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqProviderTwo"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            Provide a clear service title, detailed description,
                                            relevant category, location, pricing where applicable,
                                            portfolio or previous work, and other information that
                                            helps customers understand what you offer.
                                        </p>
                                    </div>
                                </div>

                            </div>


                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqProviderThree"
                                >
                                    <span>How can customers discover my services?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqProviderThree"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            Once your services are published and available on the
                                            platform, customers can discover them through service
                                            categories, search, and other marketplace browsing features.
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- Account --}}
                    <div class="faq-group" data-category="account">

                        <div class="faq-group-heading">
                            <div class="faq-group-icon">
                                <i class="bi bi-person-gear"></i>
                            </div>

                            <h2>Account</h2>
                        </div>

                        <div class="faq-list">

                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqAccountOne"
                                >
                                    <span>Do I need an account to browse services?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqAccountOne"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            You can browse publicly available services without an
                                            account where permitted. Some features, such as connecting
                                            with providers or managing your services, may require an
                                            account.
                                        </p>
                                    </div>
                                </div>

                            </div>


                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqAccountTwo"
                                >
                                    <span>How do I change my account information?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqAccountTwo"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            Sign in to your account and open your profile or account
                                            settings. From there, you can update the information
                                            available for editing.
                                        </p>
                                    </div>
                                </div>

                            </div>


                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqAccountThree"
                                >
                                    <span>What should I do if I forget my password?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqAccountThree"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            Use the password reset option on the login page and follow
                                            the instructions sent to your registered email address.
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- Payments --}}
                    <div class="faq-group" data-category="payments">

                        <div class="faq-group-heading">
                            <div class="faq-group-icon">
                                <i class="bi bi-credit-card"></i>
                            </div>

                            <h2>Payments</h2>
                        </div>

                        <div class="faq-list">

                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqPaymentOne"
                                >
                                    <span>Does Connector handle payments for every service?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqPaymentOne"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            Payment arrangements can vary depending on the service
                                            and the features available on Connector. Always review
                                            the service information and payment terms before proceeding.
                                        </p>
                                    </div>
                                </div>

                            </div>


                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqPaymentTwo"
                                >
                                    <span>Are service prices set by Connector?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqPaymentTwo"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            Service providers generally determine the prices of their
                                            services. Customers should review the displayed pricing
                                            and confirm the final terms directly with the provider
                                            where necessary.
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- Safety --}}
                    <div class="faq-group" data-category="safety">

                        <div class="faq-group-heading">
                            <div class="faq-group-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <h2>Safety & Trust</h2>
                        </div>

                        <div class="faq-list">

                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqSafetyOne"
                                >
                                    <span>How does Connector promote trust?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqSafetyOne"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            Connector provides service and provider information to
                                            help customers make informed decisions. Users should
                                            review profiles, service details, ratings or other
                                            available information before engaging with a provider.
                                        </p>
                                    </div>
                                </div>

                            </div>


                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqSafetyTwo"
                                >
                                    <span>What should I do if I have a problem with a service?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqSafetyTwo"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            If you experience an issue, first communicate with the
                                            service provider to resolve it. If additional assistance
                                            is required, contact the Connector support team with
                                            relevant details about the issue.
                                        </p>
                                    </div>
                                </div>

                            </div>


                            <div class="faq-item">

                                <button
                                    class="faq-question"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqSafetyThree"
                                >
                                    <span>How can I report inappropriate content or behavior?</span>

                                    <span class="faq-question-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </button>

                                <div
                                    id="faqSafetyThree"
                                    class="collapse"
                                >
                                    <div class="faq-answer">
                                        <p>
                                            Contact the Connector support team and provide enough
                                            information for the issue to be reviewed. Where available,
                                            use the reporting functionality provided on the platform.
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>


    {{-- CTA --}}
    <section class="faq-cta">
        <div class="container">

            <div class="faq-cta-card">

                <div class="faq-cta-content">

                    <h2>
                        Still have a question?
                    </h2>

                    <p>
                        If you cannot find the information you are looking for,
                        our team is here to help you with your questions about Connector.
                    </p>

                    <a href="{{ route('home.contact') }}" class="btn">
                        Contact us
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>

        </div>
    </section>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const searchInput = document.getElementById('faqSearch');
        const faqItems = document.querySelectorAll('.faq-item');
        const faqGroups = document.querySelectorAll('.faq-group');
        const emptyState = document.getElementById('faqEmpty');
        const categoryButtons = document.querySelectorAll('.faq-category');

        /*
         * FAQ search
         */
        searchInput.addEventListener('input', function () {

            const search = this.value.trim().toLowerCase();
            let visibleItems = 0;

            faqItems.forEach(function (item) {

                const question = item
                    .querySelector('.faq-question span')
                    ?.textContent
                    .toLowerCase() || '';

                const answer = item
                    .querySelector('.faq-answer')
                    ?.textContent
                    .toLowerCase() || '';

                const matches =
                    question.includes(search) ||
                    answer.includes(search);

                item.style.display = matches ? '' : 'none';

                if (matches) {
                    visibleItems++;
                }
            });

            faqGroups.forEach(function (group) {

                const visibleGroupItems = group.querySelectorAll(
                    '.faq-item:not([style*="display: none"])'
                );

                group.style.display =
                    visibleGroupItems.length > 0 ? '' : 'none';
            });

            emptyState.style.display =
                visibleItems === 0 ? 'block' : 'none';

        });


        /*
         * Category filtering
         */
        categoryButtons.forEach(function (button) {

            button.addEventListener('click', function () {

                const target = this.dataset.target;

                categoryButtons.forEach(function (btn) {
                    btn.classList.remove('active');
                });

                this.classList.add('active');

                faqGroups.forEach(function (group) {

                    if (target === 'all' || group.dataset.category === target) {
                        group.style.display = '';
                    } else {
                        group.style.display = 'none';
                    }

                });

                emptyState.style.display = 'none';

                /*
                 * Clear search when switching category
                 */
                searchInput.value = '';

                faqItems.forEach(function (item) {
                    item.style.display = '';
                });

                const selectedGroup = document.querySelector(
                    `.faq-group[data-category="${target}"]`
                );

                if (selectedGroup) {
                    selectedGroup.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }

            });

        });


        /*
         * FAQ active state
         */
        document.querySelectorAll('.faq-item .collapse').forEach(function (collapse) {

            collapse.addEventListener('show.bs.collapse', function () {

                const item = this.closest('.faq-item');

                if (item) {
                    item.classList.add('active');
                }

            });

            collapse.addEventListener('hide.bs.collapse', function () {

                const item = this.closest('.faq-item');

                if (item) {
                    item.classList.remove('active');
                }

            });

        });

    });
</script>

@endsection