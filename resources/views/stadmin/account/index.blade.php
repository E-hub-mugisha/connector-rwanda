@extends('layouts.app')

@section('title', 'My Profile')

@php
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon;

    $user = Auth::user();

    $profileImage = $sprovider && $sprovider->image
        ? asset('image/profile/' . $sprovider->image)
        : asset('assets/images/sproviders/avatar.jpg');

    $serviceCount = $sprovider?->services?->count() ?? 0;
    $staffCount = $sprovider?->staffMembers?->count() ?? 0;
    $ratingCount = $sprovider?->ratings?->count() ?? 0;
    $feedbackCount = $sprovider?->feedback?->count() ?? 0;

    $averageRating = $ratingCount > 0
        ? round(
            $sprovider->ratings->avg(function ($rating) {
                return $rating->rating
                    ?? $rating->stars
                    ?? $rating->score
                    ?? 0;
            }),
            1
        )
        : 0;

    /*
    |--------------------------------------------------------------------------
    | Profile Completion
    |--------------------------------------------------------------------------
    */

    $profileFields = [
        $user?->name,
        $user?->email,
        $user?->phone,
        $sprovider?->image,
        $sprovider?->city,
        $sprovider?->service_locations,
        $sprovider?->service_category_id,
        $sprovider?->about,
        $sprovider?->skills,
        $sprovider?->qualification,
        $sprovider?->experience,
        $sprovider?->workingHours?->count() > 0 ? true : null,
    ];

    $completedFields = collect($profileFields)
        ->filter(fn ($value) => filled($value))
        ->count();

    $totalFields = count($profileFields);

    $completion = $totalFields > 0
        ? round(($completedFields / $totalFields) * 100)
        : 0;

    /*
    |--------------------------------------------------------------------------
    | Working Hours
    |--------------------------------------------------------------------------
    */

    $dayOrder = [
        'Monday' => 1,
        'Tuesday' => 2,
        'Wednesday' => 3,
        'Thursday' => 4,
        'Friday' => 5,
        'Saturday' => 6,
        'Sunday' => 7,
    ];

    $workingHours = collect($sprovider?->workingHours ?? [])
        ->sortBy(function ($hour) use ($dayOrder) {
            return $dayOrder[$hour->day] ?? 99;
        });

    $workingHourCount = $workingHours->count();

    $openDays = $workingHours->filter(
        fn ($hour) => !$hour->is_closed
    )->count();

    $closedDays = $workingHours->filter(
        fn ($hour) => $hour->is_closed
    )->count();

    $missingDays = 7 - $workingHourCount;
@endphp

@section('content')

<div class="connector-profile-page">

    {{-- =========================================================
        ALERTS
    ========================================================== --}}

    <div class="container-fluid px-3 px-lg-4">

        @if(session('success'))
            <div class="connector-alert alert-success">
                <div class="connector-alert-icon">
                    <i class="bi bi-check-lg"></i>
                </div>

                <div class="flex-grow-1">
                    <strong>Success</strong>
                    <span>{{ session('success') }}</span>
                </div>

                <button
                    type="button"
                    class="alert-close"
                    data-bs-dismiss="alert"
                >
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="connector-alert alert-danger">
                <div class="connector-alert-icon">
                    <i class="bi bi-exclamation-lg"></i>
                </div>

                <div class="flex-grow-1">
                    <strong>Something went wrong</strong>
                    <span>{{ session('error') }}</span>
                </div>

                <button
                    type="button"
                    class="alert-close"
                    data-bs-dismiss="alert"
                >
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="connector-alert alert-danger">

                <div class="connector-alert-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>

                <div class="flex-grow-1">

                    <strong>Please review the form</strong>

                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

                <button
                    type="button"
                    class="alert-close"
                    data-bs-dismiss="alert"
                >
                    <i class="bi bi-x-lg"></i>
                </button>

            </div>
        @endif


        {{-- =====================================================
            PROFILE HERO
        ====================================================== --}}

        <section class="profile-hero">

            <div class="hero-decoration hero-decoration-one"></div>
            <div class="hero-decoration hero-decoration-two"></div>

            <div class="profile-hero-main">

                <div class="profile-avatar-container">

                    <img
                        src="{{ $profileImage }}"
                        alt="{{ $user?->name ?? 'Service Provider' }}"
                        class="profile-avatar"
                        id="profileImage"
                    >

                    <span class="profile-online">
                        <i class="bi bi-check-lg"></i>
                    </span>

                </div>


                <div class="profile-identity">

                    <span class="profile-overline">
                        SERVICE PROVIDER
                    </span>

                    <h1>
                        {{ $user?->name ?? 'Service Provider' }}
                    </h1>

                    <div class="profile-contact">

                        @if($user?->email)
                            <span>
                                <i class="bi bi-envelope"></i>
                                {{ $user->email }}
                            </span>
                        @endif

                        @if($sprovider?->city)
                            <span>
                                <i class="bi bi-geo-alt"></i>
                                {{ $sprovider->city }}
                            </span>
                        @endif

                    </div>

                    @if($sprovider?->category)
                        <div class="hero-category">
                            <i class="bi bi-briefcase"></i>
                            {{ $sprovider->category->name }}
                        </div>
                    @endif

                </div>

            </div>


            <div class="hero-actions">

                <button
                    type="button"
                    class="hero-edit-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#editProfileModal"
                >
                    <i class="bi bi-pencil-square"></i>
                    Edit Profile
                </button>

            </div>


            {{-- PROFILE STATISTICS --}}

            <div class="profile-statistics">

                <div class="hero-stat">
                    <div class="hero-stat-icon">
                        <i class="bi bi-briefcase"></i>
                    </div>

                    <div>
                        <strong>{{ $serviceCount }}</strong>
                        <span>Services</span>
                    </div>
                </div>


                <div class="hero-stat">
                    <div class="hero-stat-icon">
                        <i class="bi bi-people"></i>
                    </div>

                    <div>
                        <strong>{{ $staffCount }}</strong>
                        <span>Staff Members</span>
                    </div>
                </div>


                <div class="hero-stat">
                    <div class="hero-stat-icon">
                        <i class="bi bi-star-fill"></i>
                    </div>

                    <div>
                        <strong>{{ number_format($averageRating, 1) }}</strong>
                        <span>{{ $ratingCount }} Ratings</span>
                    </div>
                </div>


                <div class="hero-stat">
                    <div class="hero-stat-icon">
                        <i class="bi bi-chat-left-text"></i>
                    </div>

                    <div>
                        <strong>{{ $feedbackCount }}</strong>
                        <span>Feedback</span>
                    </div>
                </div>

            </div>

        </section>


        {{-- =====================================================
            MAIN CONTENT
        ====================================================== --}}

        <div class="row g-4 profile-content">

            {{-- =================================================
                LEFT COLUMN
            ================================================== --}}

            <div class="col-xl-8">

                {{-- ACCOUNT INFORMATION --}}

                <section class="profile-card">

                    <div class="card-header-custom">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="bi bi-person"></i>
                            </div>

                            <div>
                                <h2>Account Information</h2>
                                <p>Your primary account details</p>
                            </div>

                        </div>

                    </div>


                    <div class="information-grid">

                        <div class="information-item">

                            <span>Full Name</span>

                            <strong>
                                {{ $user?->name ?? 'Not provided' }}
                            </strong>

                        </div>


                        <div class="information-item">

                            <span>Email Address</span>

                            <strong>
                                {{ $user?->email ?? 'Not provided' }}
                            </strong>

                        </div>


                        <div class="information-item">

                            <span>Phone Number</span>

                            <strong>
                                {{ $user?->phone ?? 'Not provided' }}
                            </strong>

                        </div>


                        <div class="information-item">

                            <span>City</span>

                            <strong>
                                {{ $sprovider?->city ?? 'Not specified' }}
                            </strong>

                        </div>

                    </div>

                </section>


                {{-- SERVICE INFORMATION --}}

                <section class="profile-card">

                    <div class="card-header-custom">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="bi bi-briefcase"></i>
                            </div>

                            <div>
                                <h2>Service Information</h2>
                                <p>How customers find your business</p>
                            </div>

                        </div>

                    </div>


                    <div class="information-grid">

                        <div class="information-item">

                            <span>Primary Category</span>

                            <strong>
                                {{ $sprovider?->category?->name ?? 'Not selected' }}
                            </strong>

                        </div>


                        <div class="information-item">

                            <span>Service Location</span>

                            <strong>
                                {{ $sprovider?->service_locations ?? 'Not specified' }}
                            </strong>

                        </div>

                    </div>

                </section>


                {{-- ABOUT --}}

                <section class="profile-card">

                    <div class="card-header-custom">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="bi bi-person-lines-fill"></i>
                            </div>

                            <div>
                                <h2>About</h2>
                                <p>Introduction to your business or professional services</p>
                            </div>

                        </div>

                    </div>


                    <div class="rich-content">

                        @if($sprovider?->about)
                            {!! $sprovider->about !!}
                        @else
                            <div class="content-empty">
                                <div>
                                    <i class="bi bi-file-text"></i>
                                </div>

                                <span>
                                    No description has been added yet.
                                </span>
                            </div>
                        @endif

                    </div>

                </section>


                {{-- SKILLS --}}

                <section class="profile-card">

                    <div class="card-header-custom">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="bi bi-stars"></i>
                            </div>

                            <div>
                                <h2>Skills</h2>
                                <p>Professional skills and areas of expertise</p>
                            </div>

                        </div>

                    </div>


                    <div class="rich-content">

                        @if($sprovider?->skills)
                            {!! $sprovider->skills !!}
                        @else
                            <div class="content-empty">
                                <div>
                                    <i class="bi bi-stars"></i>
                                </div>

                                <span>
                                    No skills have been listed yet.
                                </span>
                            </div>
                        @endif

                    </div>

                </section>


                {{-- QUALIFICATIONS --}}

                <section class="profile-card">

                    <div class="card-header-custom">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="bi bi-mortarboard"></i>
                            </div>

                            <div>
                                <h2>Qualifications</h2>
                                <p>Education, certifications and professional qualifications</p>
                            </div>

                        </div>

                    </div>


                    <div class="rich-content">

                        @if($sprovider?->qualification)
                            {!! $sprovider->qualification !!}
                        @else
                            <div class="content-empty">
                                <div>
                                    <i class="bi bi-mortarboard"></i>
                                </div>

                                <span>
                                    No qualifications have been added yet.
                                </span>
                            </div>
                        @endif

                    </div>

                </section>


                {{-- EXPERIENCE --}}

                <section class="profile-card">

                    <div class="card-header-custom">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="bi bi-award"></i>
                            </div>

                            <div>
                                <h2>Experience</h2>
                                <p>Professional experience and background</p>
                            </div>

                        </div>

                    </div>


                    <div class="rich-content">

                        @if($sprovider?->experience)
                            {!! $sprovider->experience !!}
                        @else
                            <div class="content-empty">
                                <div>
                                    <i class="bi bi-award"></i>
                                </div>

                                <span>
                                    No experience details have been added yet.
                                </span>
                            </div>
                        @endif

                    </div>

                </section>


                {{-- =================================================
                    WORKING HOURS
                ================================================== --}}

                <section class="profile-card working-hours-card">

                    <div class="card-header-custom working-header">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="bi bi-clock"></i>
                            </div>

                            <div>
                                <h2>Working Hours</h2>
                                <p>
                                    Manage your weekly service availability
                                </p>
                            </div>

                        </div>


                        <button
                            type="button"
                            class="btn-add-hours"
                            data-bs-toggle="modal"
                            data-bs-target="#addWorkingHourModal"
                        >
                            <i class="bi bi-plus-lg"></i>
                            Add Hours
                        </button>

                    </div>


                    {{-- HOURS SUMMARY --}}

                    <div class="hours-summary">

                        <div class="hours-summary-item">

                            <div class="hours-summary-icon">
                                <i class="bi bi-calendar-check"></i>
                            </div>

                            <div>
                                <strong>{{ $workingHourCount }}</strong>
                                <span>Configured</span>
                            </div>

                        </div>


                        <div class="hours-summary-item">

                            <div class="hours-summary-icon">
                                <i class="bi bi-door-open"></i>
                            </div>

                            <div>
                                <strong>{{ $openDays }}</strong>
                                <span>Open Days</span>
                            </div>

                        </div>


                        <div class="hours-summary-item">

                            <div class="hours-summary-icon">
                                <i class="bi bi-door-closed"></i>
                            </div>

                            <div>
                                <strong>{{ $closedDays }}</strong>
                                <span>Closed Days</span>
                            </div>

                        </div>


                        <div class="hours-summary-item">

                            <div class="hours-summary-icon">
                                <i class="bi bi-calendar-plus"></i>
                            </div>

                            <div>
                                <strong>{{ $missingDays }}</strong>
                                <span>Not Set</span>
                            </div>

                        </div>

                    </div>


                    @if($workingHours->count())

                        <div class="schedule-list">

                            @foreach($workingHours as $hour)

                                <div class="schedule-row">

                                    <div class="schedule-day">

                                        <div class="day-icon">
                                            <i class="bi bi-calendar3"></i>
                                        </div>

                                        <div>

                                            <strong>
                                                {{ $hour->day }}
                                            </strong>

                                            <small>
                                                Weekly schedule
                                            </small>

                                        </div>

                                    </div>


                                    <div class="schedule-time">

                                        @if($hour->is_closed)

                                            <span class="schedule-closed">
                                                <i class="bi bi-dash-circle"></i>
                                                Closed
                                            </span>

                                        @else

                                            <span class="schedule-open">

                                                <i class="bi bi-clock"></i>

                                                <span>
                                                    {{ $hour->start_time
                                                        ? Carbon::parse($hour->start_time)->format('g:i A')
                                                        : '--'
                                                    }}
                                                </span>

                                                <em>to</em>

                                                <span>
                                                    {{ $hour->end_time
                                                        ? Carbon::parse($hour->end_time)->format('g:i A')
                                                        : '--'
                                                    }}
                                                </span>

                                            </span>

                                        @endif

                                    </div>


                                    <div class="schedule-actions">

                                        <button
                                            type="button"
                                            class="schedule-btn edit-working-hour"
                                            data-id="{{ $hour->id }}"
                                            title="Edit working hours"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>


                                        <button
                                            type="button"
                                            class="schedule-btn schedule-delete delete-working-hour"
                                            data-id="{{ $hour->id }}"
                                            data-day="{{ $hour->day }}"
                                            title="Delete working hours"
                                        >
                                            <i class="bi bi-trash3"></i>
                                        </button>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="schedule-empty">

                            <div class="schedule-empty-icon">
                                <i class="bi bi-clock"></i>
                            </div>

                            <h3>
                                No working hours configured
                            </h3>

                            <p>
                                Add your weekly availability so customers
                                know when your services are available.
                            </p>

                            <button
                                type="button"
                                class="btn-add-hours"
                                data-bs-toggle="modal"
                                data-bs-target="#addWorkingHourModal"
                            >
                                <i class="bi bi-plus-lg"></i>
                                Add Working Hours
                            </button>

                        </div>

                    @endif

                </section>

            </div>


            {{-- =================================================
                RIGHT COLUMN
            ================================================== --}}

            <div class="col-xl-4">

                {{-- PROFILE COMPLETION --}}

                <section class="completion-card">

                    <div class="completion-decoration"></div>

                    <div class="completion-header">

                        <div>
                            <span>
                                PROFILE COMPLETION
                            </span>

                            <strong>
                                {{ $completion }}%
                            </strong>
                        </div>

                        <div class="completion-circle">
                            <span>{{ $completion }}%</span>
                        </div>

                    </div>


                    <div class="completion-progress">

                        <div
                            class="completion-progress-bar"
                            style="width: {{ $completion }}%"
                        ></div>

                    </div>


                    <p>
                        A complete profile gives customers more
                        information and confidence when choosing your services.
                    </p>

                </section>


                {{-- CATEGORY --}}

                <section class="profile-card">

                    <div class="small-card-heading">

                        <div class="small-card-icon">
                            <i class="bi bi-grid"></i>
                        </div>

                        <h3>
                            Service Category
                        </h3>

                    </div>


                    <div class="category-box">

                        <div class="category-box-icon">
                            <i class="bi bi-briefcase"></i>
                        </div>

                        <div>

                            <strong>
                                {{ $sprovider?->category?->name ?? 'Not selected' }}
                            </strong>

                            <span>
                                Primary service category
                            </span>

                        </div>

                    </div>

                </section>


                {{-- LOCATION --}}

                <section class="profile-card">

                    <div class="small-card-heading">

                        <div class="small-card-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>

                        <h3>
                            Service Location
                        </h3>

                    </div>


                    <div class="location-box">

                        <div class="location-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>

                        <span>
                            {{ $sprovider?->service_locations ?? 'Service location not specified' }}
                        </span>

                    </div>

                </section>


                {{-- WORKING HOURS SUMMARY --}}

                <section class="profile-card">

                    <div class="small-card-heading">

                        <div class="small-card-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>

                        <h3>
                            Availability
                        </h3>

                    </div>


                    <div class="availability-overview">

                        <div class="availability-main">

                            <div class="availability-number">
                                {{ $openDays }}
                            </div>

                            <div>
                                <strong>Open days</strong>
                                <span>of 7 days</span>
                            </div>

                        </div>


                        <div class="availability-bar">

                            @foreach([
                                'Monday',
                                'Tuesday',
                                'Wednesday',
                                'Thursday',
                                'Friday',
                                'Saturday',
                                'Sunday'
                            ] as $day)

                                @php
                                    $dayHour = $workingHours->firstWhere('day', $day);
                                @endphp

                                <div
                                    class="availability-day {{ !$dayHour ? 'not-set' : ($dayHour->is_closed ? 'closed' : 'open') }}"
                                    title="{{ $day }}: {{ !$dayHour ? 'Not configured' : ($dayHour->is_closed ? 'Closed' : 'Open') }}"
                                >
                                    <span>
                                        {{ substr($day, 0, 1) }}
                                    </span>
                                </div>

                            @endforeach

                        </div>


                        <div class="availability-legend">

                            <span>
                                <i class="legend-dot open"></i>
                                Open
                            </span>

                            <span>
                                <i class="legend-dot closed"></i>
                                Closed
                            </span>

                            <span>
                                <i class="legend-dot not-set"></i>
                                Not set
                            </span>

                        </div>

                    </div>

                </section>


                {{-- QUICK ACTIONS --}}

                <section class="profile-card">

                    <div class="small-card-heading">

                        <div class="small-card-icon">
                            <i class="bi bi-lightning"></i>
                        </div>

                        <h3>
                            Quick Actions
                        </h3>

                    </div>


                    <div class="quick-actions">

                        <a
                            href="{{ route('serviceProvider.index') }}"
                            class="quick-action"
                        >

                            <div class="quick-action-icon">
                                <i class="bi bi-briefcase"></i>
                            </div>

                            <div>
                                <strong>My Services</strong>
                                <span>Manage your services</span>
                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <button
                            type="button"
                            class="quick-action"
                            data-bs-toggle="modal"
                            data-bs-target="#editProfileModal"
                        >

                            <div class="quick-action-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>

                            <div>
                                <strong>Update Profile</strong>
                                <span>Edit your information</span>
                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </button>


                        <button
                            type="button"
                            class="quick-action"
                            data-bs-toggle="modal"
                            data-bs-target="#addWorkingHourModal"
                        >

                            <div class="quick-action-icon">
                                <i class="bi bi-clock"></i>
                            </div>

                            <div>
                                <strong>Manage Hours</strong>
                                <span>Update availability</span>
                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </button>

                    </div>

                </section>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
    EDIT PROFILE MODAL
============================================================= --}}

<div
    class="modal fade"
    id="editProfileModal"
    tabindex="-1"
    aria-labelledby="editProfileModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-xl">

        <div class="modal-content connector-modal">

            <form
                action="{{ route('sprovider.update_profile') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')


                <div class="modal-header connector-modal-header">

                    <div>

                        <span class="modal-overline">
                            ACCOUNT SETTINGS
                        </span>

                        <h5
                            class="modal-title"
                            id="editProfileModalLabel"
                        >
                            Update Profile
                        </h5>

                        <p>
                            Keep your professional information up to date.
                        </p>

                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <div class="modal-body connector-modal-body">

                    <div class="row g-4">

                        {{-- IMAGE --}}

                        <div class="col-lg-3">

                            <div class="profile-image-editor">

                                <div class="modal-profile-image">

                                    <img
                                        src="{{ $profileImage }}"
                                        id="modalProfilePreview"
                                        alt="Profile"
                                    >

                                </div>


                                <label
                                    for="profileImageInput"
                                    class="photo-btn"
                                >
                                    <i class="bi bi-camera"></i>
                                    Change Photo
                                </label>

                                <input
                                    type="file"
                                    name="image"
                                    id="profileImageInput"
                                    class="d-none"
                                    accept=".jpg,.jpeg,.png,.webp"
                                >

                                <small>
                                    JPG, PNG or WEBP
                                    <br>
                                    Maximum 5MB
                                </small>

                                <div
                                    id="imageFileName"
                                    class="selected-file"
                                ></div>

                            </div>

                        </div>


                        {{-- FORM --}}

                        <div class="col-lg-9">

                            <div class="row g-4">

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Full Name
                                        <span>*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name', $user?->name) }}"
                                        class="form-control"
                                        required
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Email Address
                                        <span>*</span>
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ old('email', $user?->email) }}"
                                        class="form-control"
                                        required
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Phone Number
                                    </label>

                                    <input
                                        type="text"
                                        name="phone"
                                        value="{{ old('phone', $user?->phone) }}"
                                        class="form-control"
                                        placeholder="+250 7XX XXX XXX"
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        City
                                    </label>

                                    <input
                                        type="text"
                                        name="city"
                                        value="{{ old('city', $sprovider?->city) }}"
                                        class="form-control"
                                        placeholder="e.g. Kigali"
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Service Category
                                    </label>

                                    <select
                                        name="service_category_id"
                                        class="form-select"
                                    >

                                        <option value="">
                                            Select Category
                                        </option>

                                        @foreach($categories as $category)

                                            <option
                                                value="{{ $category->id }}"
                                                {{ old(
                                                    'service_category_id',
                                                    $sprovider?->service_category_id
                                                ) == $category->id ? 'selected' : '' }}
                                            >
                                                {{ $category->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Service Location
                                    </label>

                                    <input
                                        type="text"
                                        name="service_locations"
                                        value="{{ old(
                                            'service_locations',
                                            $sprovider?->service_locations
                                        ) }}"
                                        class="form-control"
                                        placeholder="e.g. Kigali and surrounding areas"
                                    >

                                </div>


                                <div class="col-12">

                                    <label class="form-label">
                                        About
                                    </label>

                                    <textarea
                                        name="about"
                                        rows="4"
                                        class="form-control"
                                        placeholder="Tell customers about your business..."
                                    >{{ old('about', $sprovider?->about) }}</textarea>

                                </div>


                                <div class="col-12">

                                    <label class="form-label">
                                        Skills
                                    </label>

                                    <textarea
                                        name="skills"
                                        rows="4"
                                        class="form-control"
                                        placeholder="List your professional skills and expertise..."
                                    >{{ old('skills', $sprovider?->skills) }}</textarea>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Qualification
                                    </label>

                                    <textarea
                                        name="qualification"
                                        rows="5"
                                        class="form-control"
                                        placeholder="Education, certifications and qualifications..."
                                    >{{ old(
                                        'qualification',
                                        $sprovider?->qualification
                                    ) }}</textarea>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Experience
                                    </label>

                                    <textarea
                                        name="experience"
                                        rows="5"
                                        class="form-control"
                                        placeholder="Describe your professional experience..."
                                    >{{ old(
                                        'experience',
                                        $sprovider?->experience
                                    ) }}</textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="modal-footer connector-modal-footer">

                    <button
                        type="button"
                        class="btn-modal-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn-modal-primary"
                    >
                        <i class="bi bi-check2-circle"></i>
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =============================================================
    ADD WORKING HOURS MODAL
============================================================= --}}

<div
    class="modal fade"
    id="addWorkingHourModal"
    tabindex="-1"
    aria-labelledby="addWorkingHourModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content connector-modal">

            <form
                action="{{ route('working_hours.store') }}"
                method="POST"
            >

                @csrf


                <div class="modal-header connector-modal-header">

                    <div>

                        <span class="modal-overline">
                            AVAILABILITY
                        </span>

                        <h5
                            class="modal-title"
                            id="addWorkingHourModalLabel"
                        >
                            Add Working Hours
                        </h5>

                        <p>
                            Set your availability for a day.
                        </p>

                    </div>


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <div class="modal-body connector-modal-body">

                    <div class="mb-4">

                        <label
                            for="add_day"
                            class="form-label"
                        >
                            Day
                            <span>*</span>
                        </label>

                        <select
                            name="day"
                            id="add_day"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Select day
                            </option>

                            @foreach([
                                'Monday',
                                'Tuesday',
                                'Wednesday',
                                'Thursday',
                                'Friday',
                                'Saturday',
                                'Sunday'
                            ] as $day)

                                <option value="{{ $day }}">
                                    {{ $day }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div
                        class="time-fields"
                        id="addTimeFields"
                    >

                        <div>

                            <label
                                for="add_start_time"
                                class="form-label"
                            >
                                Opening Time
                            </label>

                            <input
                                type="time"
                                name="start_time"
                                id="add_start_time"
                                class="form-control"
                            >

                        </div>


                        <div>

                            <label
                                for="add_end_time"
                                class="form-label"
                            >
                                Closing Time
                            </label>

                            <input
                                type="time"
                                name="end_time"
                                id="add_end_time"
                                class="form-control"
                            >

                        </div>

                    </div>


                    <div class="closed-toggle">

                        <div class="closed-toggle-content">

                            <div class="closed-toggle-icon">
                                <i class="bi bi-door-closed"></i>
                            </div>

                            <div>

                                <strong>
                                    Day is closed
                                </strong>

                                <span>
                                    Mark this day as unavailable.
                                </span>

                            </div>

                        </div>


                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_closed"
                                value="1"
                                id="add_is_closed"
                            >

                        </div>

                    </div>

                </div>


                <div class="modal-footer connector-modal-footer">

                    <button
                        type="button"
                        class="btn-modal-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn-modal-primary"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Add Hours
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =============================================================
    EDIT WORKING HOURS MODAL
============================================================= --}}

<div
    class="modal fade"
    id="editWorkingHourModal"
    tabindex="-1"
    aria-labelledby="editWorkingHourModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content connector-modal">

            <form
                method="POST"
                id="editWorkingHourForm"
            >

                @csrf
                @method('PUT')


                <div class="modal-header connector-modal-header">

                    <div>

                        <span class="modal-overline">
                            AVAILABILITY
                        </span>

                        <h5
                            class="modal-title"
                            id="editWorkingHourModalLabel"
                        >
                            Edit Working Hours
                        </h5>

                        <p>
                            Update your availability for this day.
                        </p>

                    </div>


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <div class="modal-body connector-modal-body">

                    <div class="mb-4">

                        <label
                            for="edit_day"
                            class="form-label"
                        >
                            Day
                            <span>*</span>
                        </label>

                        <select
                            name="day"
                            id="edit_day"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Select day
                            </option>

                            @foreach([
                                'Monday',
                                'Tuesday',
                                'Wednesday',
                                'Thursday',
                                'Friday',
                                'Saturday',
                                'Sunday'
                            ] as $day)

                                <option value="{{ $day }}">
                                    {{ $day }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div
                        class="time-fields"
                        id="editTimeFields"
                    >

                        <div>

                            <label
                                for="edit_start_time"
                                class="form-label"
                            >
                                Opening Time
                            </label>

                            <input
                                type="time"
                                name="start_time"
                                id="edit_start_time"
                                class="form-control"
                            >

                        </div>


                        <div>

                            <label
                                for="edit_end_time"
                                class="form-label"
                            >
                                Closing Time
                            </label>

                            <input
                                type="time"
                                name="end_time"
                                id="edit_end_time"
                                class="form-control"
                            >

                        </div>

                    </div>


                    <div class="closed-toggle">

                        <div class="closed-toggle-content">

                            <div class="closed-toggle-icon">
                                <i class="bi bi-door-closed"></i>
                            </div>

                            <div>

                                <strong>
                                    Day is closed
                                </strong>

                                <span>
                                    Mark this day as unavailable.
                                </span>

                            </div>

                        </div>


                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_closed"
                                value="1"
                                id="edit_is_closed"
                            >

                        </div>

                    </div>

                </div>


                <div class="modal-footer connector-modal-footer">

                    <button
                        type="button"
                        class="btn-modal-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn-modal-primary"
                    >
                        <i class="bi bi-check2-circle"></i>
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =============================================================
    DELETE FORM
============================================================= --}}

<form
    method="POST"
    id="deleteWorkingHourForm"
    class="d-none"
>
    @csrf
    @method('DELETE')
</form>


<style>

/* =========================================================
   CONNECTOR PROFILE
========================================================= */

:root {
    --connector-green: #6B9080;
    --connector-dark: #254035;
    --connector-deep: #1d332a;
    --connector-light: #F4F8F6;
    --connector-border: #E1EAE5;
    --connector-muted: #78857F;
    --connector-text: #2E3D36;
    --connector-danger: #B34D4D;
}


/* =========================================================
   PAGE
========================================================= */

.connector-profile-page {
    min-height: 100vh;
    background: #f7f9f8;
    padding: 24px 0 60px;
    color: var(--connector-text);
}

.profile-content {
    margin-top: 24px;
}


/* =========================================================
   ALERTS
========================================================= */

.connector-alert {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 15px 17px;
    border-radius: 12px;
    margin-bottom: 18px;
    border: 1px solid transparent;
    font-size: 13px;
}

.connector-alert.alert-success {
    background: #eef8f2;
    color: #286641;
    border-color: #d7eddf;
}

.connector-alert.alert-danger {
    background: #fff2f2;
    color: #994646;
    border-color: #f1d8d8;
}

.connector-alert-icon {
    width: 32px;
    height: 32px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.alert-success .connector-alert-icon {
    background: #dff1e5;
}

.alert-danger .connector-alert-icon {
    background: #f8dddd;
}

.connector-alert strong,
.connector-alert span {
    display: block;
}

.connector-alert strong {
    margin-bottom: 2px;
    font-size: 13px;
}

.connector-alert ul {
    margin: 7px 0 0;
    padding-left: 17px;
}

.alert-close {
    border: 0;
    background: transparent;
    color: currentColor;
    opacity: .55;
    padding: 3px;
}

.alert-close:hover {
    opacity: 1;
}


/* =========================================================
   PROFILE HERO
========================================================= */

.profile-hero {
    position: relative;
    overflow: hidden;
    background: linear-gradient(
        135deg,
        #254035 0%,
        #315847 55%,
        #6B9080 100%
    );
    border-radius: 20px;
    padding: 30px;
    color: #fff;
    box-shadow: 0 15px 40px rgba(37,64,53,.12);
}

.hero-decoration {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,.05);
    pointer-events: none;
}

.hero-decoration-one {
    width: 330px;
    height: 330px;
    right: -100px;
    top: -180px;
}

.hero-decoration-two {
    width: 220px;
    height: 220px;
    left: 43%;
    bottom: -170px;
}

.profile-hero-main {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 22px;
}

.profile-avatar-container {
    position: relative;
    flex-shrink: 0;
}

.profile-avatar {
    width: 116px;
    height: 116px;
    border-radius: 50%;
    object-fit: cover;
    background: #fff;
    border: 5px solid rgba(255,255,255,.22);
    box-shadow: 0 8px 25px rgba(0,0,0,.16);
}

.profile-online {
    position: absolute;
    right: 3px;
    bottom: 6px;
    width: 29px;
    height: 29px;
    border-radius: 50%;
    background: #fff;
    color: var(--connector-green);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid #315847;
    font-size: 13px;
}

.profile-identity {
    min-width: 0;
}

.profile-overline {
    display: block;
    margin-bottom: 4px;
    font-size: 10px;
    letter-spacing: 1.8px;
    font-weight: 700;
    color: rgba(255,255,255,.65);
}

.profile-identity h1 {
    margin: 0 0 8px;
    font-size: 29px;
    line-height: 1.2;
    font-weight: 700;
    color: #fff;
}

.profile-contact {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    color: rgba(255,255,255,.76);
    font-size: 13px;
}

.profile-contact span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.hero-category {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-top: 12px;
    padding: 7px 11px;
    border-radius: 30px;
    background: rgba(255,255,255,.10);
    border: 1px solid rgba(255,255,255,.10);
    color: rgba(255,255,255,.85);
    font-size: 11px;
    font-weight: 600;
}

.hero-actions {
    position: absolute;
    z-index: 3;
    right: 30px;
    top: 30px;
}

.hero-edit-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 44px;
    padding: 0 16px;
    border: 0;
    border-radius: 10px;
    background: #fff;
    color: var(--connector-dark);
    font-size: 13px;
    font-weight: 600;
    transition: .2s ease;
}

.hero-edit-btn:hover {
    background: var(--connector-light);
    color: var(--connector-dark);
    transform: translateY(-1px);
}


/* =========================================================
   HERO STATS
========================================================= */

.profile-statistics {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px;
    margin-top: 30px;
    border-radius: 13px;
    overflow: hidden;
    background: rgba(255,255,255,.12);
}

.hero-stat {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    background: rgba(255,255,255,.065);
}

.hero-stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(255,255,255,.10);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}

.hero-stat strong {
    display: block;
    font-size: 18px;
    line-height: 1;
    color: #fff;
}

.hero-stat span {
    display: block;
    margin-top: 5px;
    color: rgba(255,255,255,.62);
    font-size: 11px;
}


/* =========================================================
   CARDS
========================================================= */

.profile-card,
.completion-card {
    background: #fff;
    border: 1px solid var(--connector-border);
    border-radius: 16px;
    box-shadow: 0 7px 28px rgba(37,64,53,.045);
    margin-bottom: 20px;
}

.profile-card {
    padding: 24px;
}

.card-header-custom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 22px;
}

.card-heading {
    display: flex;
    align-items: center;
    gap: 12px;
}

.card-icon,
.small-card-icon {
    width: 42px;
    height: 42px;
    border-radius: 11px;
    background: var(--connector-light);
    color: var(--connector-green);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 18px;
}

.card-heading h2 {
    margin: 0;
    color: var(--connector-dark);
    font-size: 16px;
    font-weight: 700;
}

.card-heading p {
    margin: 3px 0 0;
    color: var(--connector-muted);
    font-size: 12px;
}


/* =========================================================
   INFORMATION GRID
========================================================= */

.information-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    border-top: 1px solid var(--connector-border);
}

.information-item {
    padding: 18px 12px;
    border-bottom: 1px solid var(--connector-border);
}

.information-item:nth-child(odd) {
    padding-left: 0;
    padding-right: 25px;
}

.information-item:nth-child(even) {
    padding-left: 25px;
    border-left: 1px solid var(--connector-border);
}

.information-item span {
    display: block;
    margin-bottom: 6px;
    color: var(--connector-muted);
    font-size: 11px;
}

.information-item strong {
    display: block;
    color: var(--connector-dark);
    font-size: 13px;
    line-height: 1.5;
}


/* =========================================================
   RICH CONTENT
========================================================= */

.rich-content {
    color: #56645d;
    font-size: 14px;
    line-height: 1.8;
}

.rich-content p:last-child {
    margin-bottom: 0;
}

.rich-content ul,
.rich-content ol {
    padding-left: 20px;
}

.content-empty {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 17px;
    border-radius: 10px;
    background: var(--connector-light);
    color: #9aa69f;
    font-size: 13px;
}

.content-empty div {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--connector-green);
}


/* =========================================================
   COMPLETION CARD
========================================================= */

.completion-card {
    position: relative;
    overflow: hidden;
    padding: 24px;
    background: linear-gradient(
        135deg,
        #254035,
        #6B9080
    );
    border: 0;
    color: #fff;
}

.completion-decoration {
    position: absolute;
    width: 180px;
    height: 180px;
    right: -80px;
    top: -80px;
    border-radius: 50%;
    background: rgba(255,255,255,.05);
}

.completion-header {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.completion-header span {
    display: block;
    color: rgba(255,255,255,.65);
    font-size: 9px;
    letter-spacing: 1.5px;
    font-weight: 700;
}

.completion-header strong {
    display: block;
    margin-top: 3px;
    font-size: 31px;
    color: #fff;
}

.completion-circle {
    width: 65px;
    height: 65px;
    border-radius: 50%;
    border: 4px solid rgba(255,255,255,.25);
    display: flex;
    align-items: center;
    justify-content: center;
}

.completion-circle span {
    color: #fff;
    font-size: 13px;
    letter-spacing: 0;
}

.completion-progress {
    position: relative;
    z-index: 2;
    height: 7px;
    margin: 18px 0 14px;
    border-radius: 20px;
    background: rgba(255,255,255,.15);
    overflow: hidden;
}

.completion-progress-bar {
    height: 100%;
    border-radius: inherit;
    background: #fff;
}

.completion-card p {
    position: relative;
    z-index: 2;
    margin: 0;
    color: rgba(255,255,255,.68);
    font-size: 12px;
    line-height: 1.65;
}


/* =========================================================
   SMALL RIGHT CARDS
========================================================= */

.small-card-heading {
    display: flex;
    align-items: center;
    gap: 11px;
    margin-bottom: 18px;
}

.small-card-heading h3 {
    margin: 0;
    color: var(--connector-dark);
    font-size: 14px;
    font-weight: 700;
}

.small-card-icon {
    width: 38px;
    height: 38px;
    font-size: 16px;
}

.category-box {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 15px;
    border-radius: 11px;
    background: var(--connector-light);
}

.category-box-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: #fff;
    color: var(--connector-green);
    display: flex;
    align-items: center;
    justify-content: center;
}

.category-box strong,
.category-box span {
    display: block;
}

.category-box strong {
    color: var(--connector-dark);
    font-size: 13px;
}

.category-box span {
    margin-top: 3px;
    color: var(--connector-muted);
    font-size: 11px;
}

.location-box {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 15px;
    border-radius: 11px;
    background: var(--connector-light);
    color: #59675f;
    font-size: 13px;
    line-height: 1.6;
}

.location-icon {
    color: var(--connector-green);
    font-size: 18px;
}


/* =========================================================
   AVAILABILITY OVERVIEW
========================================================= */

.availability-main {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-bottom: 18px;
    border-bottom: 1px solid var(--connector-border);
}

.availability-number {
    width: 49px;
    height: 49px;
    border-radius: 12px;
    background: var(--connector-light);
    color: var(--connector-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 700;
}

.availability-main strong,
.availability-main span {
    display: block;
}

.availability-main strong {
    color: var(--connector-dark);
    font-size: 13px;
}

.availability-main span {
    margin-top: 3px;
    color: var(--connector-muted);
    font-size: 11px;
}

.availability-bar {
    display: flex;
    gap: 6px;
    margin-top: 18px;
}

.availability-day {
    flex: 1;
    height: 34px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
}

.availability-day.open {
    background: #e6f3eb;
    color: #397452;
}

.availability-day.closed {
    background: #f9eaea;
    color: #a55757;
}

.availability-day.not-set {
    background: #f0f3f1;
    color: #9aa59f;
}

.availability-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 13px;
    margin-top: 14px;
}

.availability-legend span {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    color: var(--connector-muted);
    font-size: 10px;
}

.legend-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
}

.legend-dot.open {
    background: #4e9569;
}

.legend-dot.closed {
    background: #c36b6b;
}

.legend-dot.not-set {
    background: #aeb8b3;
}


/* =========================================================
   QUICK ACTIONS
========================================================= */

.quick-actions {
    display: flex;
    flex-direction: column;
}

.quick-action {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 0;
    border: 0;
    border-bottom: 1px solid var(--connector-border);
    background: transparent;
    color: var(--connector-dark);
    text-align: left;
    text-decoration: none;
}

.quick-action:last-child {
    border-bottom: 0;
}

.quick-action:hover {
    color: var(--connector-dark);
}

.quick-action-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: var(--connector-light);
    color: var(--connector-green);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.quick-action > div:nth-child(2) {
    flex: 1;
}

.quick-action strong,
.quick-action span {
    display: block;
}

.quick-action strong {
    font-size: 12px;
}

.quick-action span {
    margin-top: 2px;
    color: var(--connector-muted);
    font-size: 10px;
}

.quick-action > i:last-child {
    color: #9aa59f;
    font-size: 13px;
}


/* =========================================================
   WORKING HOURS
========================================================= */

.working-header {
    align-items: center;
}

.btn-add-hours {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 40px;
    padding: 0 15px;
    border: 0;
    border-radius: 9px;
    background: var(--connector-dark);
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    transition: .2s ease;
}

.btn-add-hours:hover {
    background: var(--connector-green);
    color: #fff;
    transform: translateY(-1px);
}


/* HOURS SUMMARY */

.hours-summary {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}

.hours-summary-item {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 12px;
    border-radius: 10px;
    background: var(--connector-light);
}

.hours-summary-icon {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: #fff;
    color: var(--connector-green);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.hours-summary-item strong,
.hours-summary-item span {
    display: block;
}

.hours-summary-item strong {
    color: var(--connector-dark);
    font-size: 15px;
}

.hours-summary-item span {
    color: var(--connector-muted);
    font-size: 9px;
    margin-top: 1px;
}


/* SCHEDULE */

.schedule-list {
    border: 1px solid var(--connector-border);
    border-radius: 12px;
    overflow: hidden;
}

.schedule-row {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 13px 15px;
    border-bottom: 1px solid var(--connector-border);
    background: #fff;
}

.schedule-row:last-child {
    border-bottom: 0;
}

.schedule-day {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    min-width: 155px;
}

.day-icon {
    width: 38px;
    height: 38px;
    border-radius: 9px;
    background: var(--connector-light);
    color: var(--connector-green);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.schedule-day strong,
.schedule-day small {
    display: block;
}

.schedule-day strong {
    color: var(--connector-dark);
    font-size: 13px;
}

.schedule-day small {
    margin-top: 2px;
    color: var(--connector-muted);
    font-size: 9px;
}

.schedule-time {
    min-width: 210px;
}

.schedule-open,
.schedule-closed {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 10px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 600;
}

.schedule-open {
    background: #eef7f1;
    color: #326d4a;
}

.schedule-open i {
    color: var(--connector-green);
}

.schedule-open em {
    font-style: normal;
    color: #91a097;
    font-weight: 400;
}

.schedule-closed {
    background: #fbefef;
    color: #a34f4f;
}

.schedule-actions {
    display: flex;
    align-items: center;
    gap: 6px;
}

.schedule-btn {
    width: 34px;
    height: 34px;
    padding: 0;
    border: 1px solid var(--connector-border);
    border-radius: 8px;
    background: #fff;
    color: var(--connector-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .2s ease;
}

.schedule-btn:hover {
    background: var(--connector-light);
    border-color: var(--connector-green);
    color: var(--connector-green);
}

.schedule-delete:hover {
    background: #fff2f2;
    border-color: #e5b7b7;
    color: var(--connector-danger);
}


/* EMPTY */

.schedule-empty {
    padding: 35px 20px;
    text-align: center;
    border: 1px dashed #d5e1db;
    border-radius: 12px;
    background: #fbfcfb;
}

.schedule-empty-icon {
    width: 54px;
    height: 54px;
    margin: 0 auto 14px;
    border-radius: 14px;
    background: var(--connector-light);
    color: var(--connector-green);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.schedule-empty h3 {
    margin: 0 0 5px;
    color: var(--connector-dark);
    font-size: 14px;
    font-weight: 700;
}

.schedule-empty p {
    max-width: 430px;
    margin: 0 auto 17px;
    color: var(--connector-muted);
    font-size: 11px;
    line-height: 1.6;
}


/* =========================================================
   MODALS
========================================================= */

.connector-modal {
    border: 0;
    border-radius: 17px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,.15);
}

.connector-modal-header {
    padding: 23px 26px;
    border: 0;
    background: linear-gradient(
        135deg,
        var(--connector-dark),
        var(--connector-green)
    );
    color: #fff;
}

.connector-modal-header .btn-close {
    filter: brightness(0) invert(1);
}

.modal-overline {
    display: block;
    margin-bottom: 3px;
    color: rgba(255,255,255,.62);
    font-size: 9px;
    letter-spacing: 1.5px;
    font-weight: 700;
}

.connector-modal .modal-title {
    margin: 0;
    color: #fff;
    font-size: 21px;
    font-weight: 700;
}

.connector-modal-header p {
    margin: 4px 0 0;
    color: rgba(255,255,255,.68);
    font-size: 11px;
}

.connector-modal-body {
    padding: 27px;
    max-height: 72vh;
    overflow-y: auto;
}

.connector-modal-footer {
    padding: 17px 26px;
    border-top: 1px solid var(--connector-border);
    background: #fff;
}

.connector-modal .form-label {
    margin-bottom: 7px;
    color: var(--connector-dark);
    font-size: 12px;
    font-weight: 600;
}

.connector-modal .form-label span {
    color: #c65353;
}

.connector-modal .form-control,
.connector-modal .form-select {
    min-height: 45px;
    border: 1px solid #dce6e1;
    border-radius: 9px;
    box-shadow: none;
    color: var(--connector-dark);
    font-size: 13px;
}

.connector-modal textarea.form-control {
    min-height: auto;
}

.connector-modal .form-control:focus,
.connector-modal .form-select:focus {
    border-color: var(--connector-green);
    box-shadow: 0 0 0 .18rem rgba(107,144,128,.12);
}


/* PROFILE IMAGE EDITOR */

.profile-image-editor {
    padding: 18px;
    border-radius: 13px;
    background: var(--connector-light);
    text-align: center;
}

.modal-profile-image {
    width: 145px;
    height: 145px;
    margin: 0 auto 17px;
    border-radius: 50%;
    overflow: hidden;
    background: #fff;
    border: 5px solid #fff;
    box-shadow: 0 7px 25px rgba(37,64,53,.12);
}

.modal-profile-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 42px;
    padding: 0 12px;
    border: 1px solid #ccd9d3;
    border-radius: 9px;
    background: #fff;
    color: var(--connector-dark);
    cursor: pointer;
    font-size: 12px;
    font-weight: 600;
}

.photo-btn:hover {
    border-color: var(--connector-green);
    color: var(--connector-green);
}

.profile-image-editor small {
    display: block;
    margin-top: 9px;
    color: var(--connector-muted);
    font-size: 10px;
    line-height: 1.6;
}

.selected-file {
    margin-top: 8px;
    color: #397451;
    font-size: 10px;
    word-break: break-word;
}


/* TIME FIELDS */

.time-fields {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 13px;
}


/* CLOSED TOGGLE */

.closed-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-top: 20px;
    padding: 14px;
    border-radius: 11px;
    background: var(--connector-light);
}

.closed-toggle-content {
    display: flex;
    align-items: center;
    gap: 10px;
}

.closed-toggle-icon {
    width: 35px;
    height: 35px;
    border-radius: 9px;
    background: #fff;
    color: var(--connector-green);
    display: flex;
    align-items: center;
    justify-content: center;
}

.closed-toggle-content strong,
.closed-toggle-content span {
    display: block;
}

.closed-toggle-content strong {
    color: var(--connector-dark);
    font-size: 12px;
}

.closed-toggle-content span {
    margin-top: 2px;
    color: var(--connector-muted);
    font-size: 10px;
}

.closed-toggle .form-check {
    margin: 0;
}

.closed-toggle .form-check-input {
    width: 2.45em;
    height: 1.3em;
    cursor: pointer;
}

.closed-toggle .form-check-input:checked {
    background-color: var(--connector-green);
    border-color: var(--connector-green);
}


/* MODAL BUTTONS */

.btn-modal-primary,
.btn-modal-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 43px;
    padding: 0 17px;
    border-radius: 9px;
    font-size: 12px;
    font-weight: 600;
}

.btn-modal-primary {
    border: 0;
    background: var(--connector-dark);
    color: #fff;
}

.btn-modal-primary:hover {
    background: var(--connector-green);
    color: #fff;
}

.btn-modal-secondary {
    border: 1px solid #d8e2dd;
    background: #fff;
    color: var(--connector-dark);
}

.btn-modal-secondary:hover {
    background: var(--connector-light);
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1199.98px) {

    .hero-actions {
        position: static;
        margin-top: 20px;
    }

    .hero-edit-btn {
        width: 100%;
    }

}


@media (max-width: 991.98px) {

    .profile-hero {
        padding: 24px;
    }

    .profile-statistics {
        grid-template-columns: repeat(2, 1fr);
    }

    .hours-summary {
        grid-template-columns: repeat(2, 1fr);
    }

}


@media (max-width: 767.98px) {

    .connector-profile-page {
        padding-top: 15px;
    }

    .profile-hero {
        padding: 20px;
        border-radius: 15px;
    }

    .profile-hero-main {
        align-items: flex-start;
        flex-direction: column;
    }

    .profile-avatar {
        width: 95px;
        height: 95px;
    }

    .profile-identity h1 {
        font-size: 24px;
    }

    .profile-contact {
        flex-direction: column;
        gap: 7px;
    }

    .profile-statistics {
        grid-template-columns: repeat(2, 1fr);
        margin-top: 22px;
    }

    .hero-stat {
        padding: 13px;
    }

    .profile-card {
        padding: 19px;
        border-radius: 14px;
    }

    .information-grid {
        grid-template-columns: 1fr;
    }

    .information-item:nth-child(even) {
        padding-left: 0;
        border-left: 0;
    }

    .information-item:nth-child(odd) {
        padding-right: 0;
    }

    .working-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .working-header .btn-add-hours {
        width: 100%;
    }

    .hours-summary {
        grid-template-columns: repeat(2, 1fr);
    }

    .schedule-row {
        flex-wrap: wrap;
    }

    .schedule-day {
        flex-basis: 100%;
    }

    .schedule-time {
        min-width: 0;
        flex: 1;
    }

    .schedule-actions {
        margin-left: auto;
    }

    .connector-modal-body {
        padding: 20px;
        max-height: 75vh;
    }

}


@media (max-width: 575.98px) {

    .profile-statistics {
        grid-template-columns: 1fr 1fr;
    }

    .profile-stat {
        padding: 11px;
    }

    .hero-stat-icon {
        width: 34px;
        height: 34px;
    }

    .hours-summary {
        grid-template-columns: 1fr 1fr;
    }

    .hours-summary-item {
        padding: 10px;
    }

    .time-fields {
        grid-template-columns: 1fr;
    }

    .working-hour-item {
        align-items: flex-start;
    }

    .schedule-open {
        flex-wrap: wrap;
    }

    .connector-modal-footer {
        flex-direction: column-reverse;
    }

    .btn-modal-primary,
    .btn-modal-secondary {
        width: 100%;
    }

}

</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       PROFILE IMAGE PREVIEW
    ========================================================== */

    const imageInput =
        document.getElementById('profileImageInput');

    const imagePreview =
        document.getElementById('modalProfilePreview');

    const imageFileName =
        document.getElementById('imageFileName');

    if (imageInput) {

        imageInput.addEventListener('change', function () {

            const file = this.files && this.files[0];

            if (!file) {
                return;
            }

            if (imageFileName) {
                imageFileName.textContent = file.name;
            }

            if (!file.type.startsWith('image/')) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {

                if (imagePreview) {
                    imagePreview.src = event.target.result;
                }

            };

            reader.readAsDataURL(file);

        });

    }


    /* =========================================================
       ADD WORKING HOURS
    ========================================================== */

    const addClosed =
        document.getElementById('add_is_closed');

    const addStart =
        document.getElementById('add_start_time');

    const addEnd =
        document.getElementById('add_end_time');


    function toggleAddFields() {

        if (!addClosed || !addStart || !addEnd) {
            return;
        }

        const closed = addClosed.checked;

        addStart.disabled = closed;
        addEnd.disabled = closed;

        addStart.required = !closed;
        addEnd.required = !closed;

        if (closed) {
            addStart.value = '';
            addEnd.value = '';
        }

    }


    if (addClosed) {

        addClosed.addEventListener(
            'change',
            toggleAddFields
        );

        toggleAddFields();

    }


    /* =========================================================
       EDIT WORKING HOURS
    ========================================================== */

    const editModalElement =
        document.getElementById('editWorkingHourModal');

    const editForm =
        document.getElementById('editWorkingHourForm');

    const editDay =
        document.getElementById('edit_day');

    const editStart =
        document.getElementById('edit_start_time');

    const editEnd =
        document.getElementById('edit_end_time');

    const editClosed =
        document.getElementById('edit_is_closed');


    let editModal = null;

    if (
        editModalElement &&
        typeof bootstrap !== 'undefined'
    ) {

        editModal =
            new bootstrap.Modal(editModalElement);

    }


    function toggleEditFields() {

        if (!editClosed || !editStart || !editEnd) {
            return;
        }

        const closed = editClosed.checked;

        editStart.disabled = closed;
        editEnd.disabled = closed;

        editStart.required = !closed;
        editEnd.required = !closed;

        if (closed) {
            editStart.value = '';
            editEnd.value = '';
        }

    }


    if (editClosed) {

        editClosed.addEventListener(
            'change',
            toggleEditFields
        );

    }


    document
        .querySelectorAll('.edit-working-hour')
        .forEach(function (button) {

            button.addEventListener('click', function () {

                const id = this.dataset.id;

                if (!id) {
                    return;
                }


                fetch(
                    "{{ url('/sprovider/working_hours') }}/" +
                    id +
                    "/edit",
                    {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                )
                .then(function (response) {

                    if (!response.ok) {
                        throw new Error(
                            'Unable to load working hours.'
                        );
                    }

                    return response.json();

                })
                .then(function (data) {

                    if (editDay) {
                        editDay.value =
                            data.day || '';
                    }

                    if (editStart) {
                        editStart.value =
                            data.start_time || '';
                    }

                    if (editEnd) {
                        editEnd.value =
                            data.end_time || '';
                    }

                    if (editClosed) {
                        editClosed.checked =
                            Boolean(data.is_closed);
                    }

                    if (editForm) {

                        editForm.action =
                            "{{ url('/working_hours/update') }}/" +
                            data.id;

                    }

                    toggleEditFields();

                    if (editModal) {
                        editModal.show();
                    }

                })
                .catch(function (error) {

                    console.error(error);

                    alert(
                        'Unable to load the working hours. Please try again.'
                    );

                });

            });

        });


    /* =========================================================
       DELETE WORKING HOURS
    ========================================================== */

    const deleteForm =
        document.getElementById('deleteWorkingHourForm');


    document
        .querySelectorAll('.delete-working-hour')
        .forEach(function (button) {

            button.addEventListener('click', function () {

                const id = this.dataset.id;
                const day =
                    this.dataset.day || 'this day';

                if (!id || !deleteForm) {
                    return;
                }


                const confirmed = window.confirm(
                    'Delete working hours for ' +
                    day +
                    '?\n\nThis action cannot be undone.'
                );


                if (!confirmed) {
                    return;
                }


                deleteForm.action =
                    "{{ url('/working_hours/delete') }}/" +
                    id;

                deleteForm.submit();

            });

        });


    /* =========================================================
       DISABLE TIMES WHEN CLOSED
    ========================================================== */

    const addModal =
        document.getElementById('addWorkingHourModal');

    if (addModal) {

        addModal.addEventListener(
            'hidden.bs.modal',
            function () {

                const form =
                    addModal.querySelector('form');

                if (form) {
                    form.reset();
                }

                toggleAddFields();

            }
        );

    }


    /* =========================================================
       VALIDATION ERROR MODAL
    ========================================================== */

    @if($errors->any())

        const editProfileModal =
            document.getElementById('editProfileModal');

        const addWorkingModal =
            document.getElementById('addWorkingHourModal');

        /*
         * Working-hour validation errors can be detected
         * by the old input fields.
         */

        @if(old('day') || old('start_time') || old('end_time') || old('is_closed'))

            if (
                addWorkingModal &&
                typeof bootstrap !== 'undefined'
            ) {

                new bootstrap.Modal(
                    addWorkingModal
                ).show();

            }

        @else

            if (
                editProfileModal &&
                typeof bootstrap !== 'undefined'
            ) {

                new bootstrap.Modal(
                    editProfileModal
                ).show();

            }

        @endif

    @endif

});
</script>

@endsection