@extends('layouts.staradmin')
@section('title', 'Account')
@section('content')

<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 d-flex justify-content-center align-items-center grid-margin stretch-card">
            <div class="card container mb-3" style="border-radius: .5rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <div class="row g-0">
                    <!-- Profile Picture & About Info -->
                    <div class="col-md-4 gradient-custom">
                        <div class="d-flex justify-content-center align-items-center flex-column my-5">

                            @php
                                $profileImage = $sprovider && $sprovider->image
                                    ? asset('image/profile/' . $sprovider->image)
                                    : asset('assets/images/sproviders/avatar.jpg');
                            @endphp

                            <img src="{{ $profileImage }}" alt="Avatar" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;" />

                            <h5 class="text-white">{{ Auth::user()->name ?? 'Unknown User' }}</h5>
                        </div>
                    </div>

                    <!-- Account Details -->
                    <div class="col-md-8">
                        <div class="card-body p-4">
                            <h6 class="mb-4" style="font-weight: bold;">Account Information for {{ Auth::user()->name ?? 'Unknown User' }}</h6>
                            <hr class="mt-0 mb-4">

                            <div class="row pt-1">
                                <div class="col-4 mb-3">
                                    <h6>Email</h6>
                                    <p class="text-muted">{{ Auth::user()->email ?? 'Not provided' }}</p>
                                </div>
                                <div class="col-4 mb-3">
                                    <h6>Phone</h6>
                                    <p class="text-muted">{{ Auth::user()->phone ?? 'Not provided' }}</p>
                                </div>
                                <div class="col-4 mb-3">
                                    <h6>City</h6>
                                    <p class="text-muted">{{ $sprovider->city ?? 'Not set' }}</p>
                                </div>
                            </div>

                            <div class="row pt-1">
                                <h6>Service Details</h6>
                                <hr class="mt-0 mb-4">
                                <div class="col-6 mb-3">
                                    <h6>Service Category</h6>
                                    <p class="text-muted">{{ $sprovider->category->name ?? 'Not selected' }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <h6>Service Location</h6>
                                    <p class="text-muted">{{ $sprovider->service_locations ?? 'Not specified' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- About, Skills, etc -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <h5 class="mb-3">About</h5>
                            <p>{!! $sprovider->about ?? '<em>No description available.</em>' !!}</p>
                        </div>
                        <div class="mb-3">
                            <h5 class="mb-3">Skills</h5>
                            <p>{!! $sprovider->skills ?? '<em>No skills listed.</em>' !!}</p>
                        </div>
                        <div class="mb-3">
                            <h5>Qualification</h5>
                            <p>{!! $sprovider->qualification ?? '<em>No qualifications listed.</em>' !!}</p>
                        </div>
                        <div class="mb-3">
                            <h5>Experience</h5>
                            <p>{!! $sprovider->experience ?? '<em>No experience details yet.</em>' !!}</p>
                        </div>

                        <!-- Edit Account Button -->
                        <div class="d-sm-flex justify-content-between mb-4 align-items-start">
                            <div>
                                <a href="{{ route('sprovider.edit_profile') }}" class="btn btn-primary btn-sm text-white mb-0 me-0" type="button">
                                    <i class="mdi mdi-pencil"></i> Edit Account
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
