@extends('layouts.staradmin')
@section('title', 'Edit account')
@section('content')
<div class="content-wrapper">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-10 grid-margin stretch-card">
            <div class="card container mb-3" style="border-radius: .5rem;">

                <h2 class="main-title mt-3">Edit Account {{ $sprovider->user->name }}</h2>

                <div class="bg-white card-box border-20">
                    @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                    @endif
                    <form method="POST" action="{{ route('get', $sprovider->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Hidden field for profile ID -->
                        <input type="hidden" name="profile_id" value="{{ Auth::user()->id }}">

                        <!-- Profile Image -->
                        <div class="mb-3">
                            @if($sprovider->image)
                            <img src="{{ asset('image/profile/' . $sprovider->image) }}" alt="Avatar" class="img-fluid mb-2" style="width: 80px;">
                            @else
                            <img src="{{ asset('assets/images/sproviders/avatar.jpg') }}" alt="Avatar" class="img-fluid mb-2" style="width: 80px;">
                            @endif
                            <input type="file" name="image" class="form-control">
                            @error('image')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- About -->
                        <div class="mb-3">
                            <label for="about">About:</label>
                            <textarea name="about" class="form-control summernote" required>{{ old('about', $sprovider->about) }}</textarea>
                            @error('about')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Skills -->
                        <div class="mb-3">
                            <label for="skills">Skills:</label>
                            <textarea name="skills" class="form-control summernote" required>{{ old('skills', $sprovider->skills) }}</textarea>
                            @error('skills')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Qualification -->
                        <div class="mb-3">
                            <label for="qualification">Qualification:</label>
                            <textarea name="qualification" class="form-control summernote" required>{{ old('qualification', $sprovider->qualification) }}</textarea>
                            @error('qualification')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Experience -->
                        <div class="mb-3">
                            <label for="experience">Experience:</label>
                            <textarea name="experience" class="form-control summernote" required>{{ old('experience', $sprovider->experience) }}</textarea>
                            @error('experience')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- City -->
                        <div class="mb-3">
                            <label for="city">City:</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $sprovider->city) }}" required>
                            @error('city')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Service Category -->
                        <div class="mb-3">
                            <label for="service_category_id">Service Category:</label>
                            <select name="service_category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($scategories as $scategory)
                                <option value="{{ $scategory->id }}" {{ $sprovider->service_category_id == $scategory->id ? 'selected' : '' }}>
                                    {{ $scategory->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('service_category_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Service Locations -->
                        <div class="mb-3">
                            <label for="service_locations">Service Locations:</label>
                            <input type="text" name="service_locations" class="form-control" value="{{ old('service_locations', $sprovider->service_locations) }}" required>
                            @error('service_locations')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Update Profile</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Summernote CSS and JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300,
            placeholder: 'Write your content here...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>

@endsection