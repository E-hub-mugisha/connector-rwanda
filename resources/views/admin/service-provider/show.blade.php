@extends('layouts.app')
@section('title','Service Provider')
@section('content')

<!-- Font Awesome for star icons -->
@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@endpush

<div class="container mb-3">
    <a href="{{ route('admin.service_providers') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="container">
    <div class="card shadow mb-4 p-4">
        <div class="row g-4">

            <div class="col-md-6">
                <div class="text-center">
                    <img src="{{ $UserProvide->image 
                        ? asset('image/profile/'.$UserProvide->image) 
                        : asset('assets/images/sproviders/avatar.jpg') }}" 
                        alt="{{ $UserProvide->user->name ?? 'Provider' }}" 
                        class="rounded-circle img-thumbnail mb-3" 
                        style="width: 100px; height: 100px; object-fit: cover;">
                    <h4>{{ $UserProvide->sprovider_name }}</h4>
                    <p class="mb-1"><i class="fas fa-phone-alt me-1"></i>{{ $UserProvide->user->phone ?? 'N/A' }}</p>
                    <p class="mb-1"><i class="fas fa-envelope me-1"></i>{{ $UserProvide->proEmail ?? 'N/A' }}</p>
                    <p>
                        <span class="badge bg-{{ $UserProvide->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($UserProvide->status) }}
                        </span>
                    </p>
                </div>

                <hr>

                <h6 class="fw-bold">Service Category</h6>
                <p>{{ $UserProvide->category->name ?? 'No Category Assigned' }}</p>

                <h6 class="fw-bold mt-3">Service Location</h6>
                <p>{{ $UserProvide->service_locations ?? 'Not Provided' }}</p>

                <h6 class="fw-bold mt-3">About</h6>
                <p class="text-muted">{!! $UserProvide->about ?? 'No description provided.' !!}</p>
            </div>

            <div class="col-md-6">
                <h5 class="fw-bold">Services</h5>
                @if($services && count($services) > 0)
                    @foreach($services as $service)
                        <span class="badge bg-info text-white me-1 mb-1">{{ $service->name }}</span>
                    @endforeach
                @else
                    <p class="text-muted">No services available.</p>
                @endif

                <hr class="my-4">

                <h5 class="fw-bold">Location Map</h5>
                <div class="rounded overflow-hidden shadow-sm">
                    <iframe class="w-100 rounded" height="280"
                        src="https://maps.google.com/maps?q={{ urlencode($UserProvide->city) }}&t=&z=12&ie=UTF8&iwloc=B&output=embed"
                        frameborder="0" allowfullscreen></iframe>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold">User Reviews</h5>
                <ul class="list-group">
                    @if($reviews && count($reviews) > 0)
                        @foreach($reviews as $review)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <p class="mb-1">{{ $review->comment }}</p>
                                    <div>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item text-muted">No reviews available.</li>
                    @endif
                </ul>
            </div>

        </div>
    </div>
</div>

@endsection
