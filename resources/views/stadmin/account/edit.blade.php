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
                    <form method="POST" action="{{ route('get.modify.profile') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row ">
                            <div class="col-md-10 dash-input-wrapper mb-30 form-group">
                               <input type="hidden" name="profile_id" value="{{ Auth::user()->id }}">

                                <div class="col-md-3 dash-btn-one d-inline-block position-relative me-3">
                                    @if($sprovider->image)
                                    <img src="{{asset('image/profile')}}/{{$sprovider->image}}" alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                                    @else
                                    <img src="{{ asset('assets/images/sproviders/avatar.jpg') }}" alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                                    @endif
                                </div>
                                <div class="col-md-3 dash-btn-one d-inline-block position-relative me-3">
                                    <i class="bi bi-plus"></i>
                                    Upload Profile
                                    <input type="file" class="form-control-file" id="image" name="image" required>
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class=" dash-input-wrapper mb-30 form-group">
                            <label for="about" class="control-label">About: </label>
                            <textarea class="form-control summernote" id="about" name="about" required>{{$sprovider->about}}</textarea>
                            @error('about')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class=" dash-input-wrapper mb-30 form-group">
                                <label for="skills" class="control-label">Skills: </label>
                                <textarea class="form-control summernote" id="skills" name="skills" required>{{$sprovider->skills}}</textarea>
                                @error('skills')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class=" dash-input-wrapper mb-30 form-group">
                                <label for="qualification" class="control-label">Qualification: </label>
                                <textarea class="form-control summernote" id="qualification" name="qualification" required>{{$sprovider->qualification}}</textarea>
                                @error('qualification')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class=" dash-input-wrapper mb-30 form-group">
                                <label for="experience" class="control-label">Experience: </label>
                                <textarea class="form-control summernote" id="experience" name="experience" required>{{$sprovider->experience}}</textarea>
                                @error('experience')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4 dash-input-wrapper mb-30 form-group">
                                <label for="city" class="control-label">City: </label>
                                <input type="text" class="form-control" name="city" value="{{$sprovider->city}}" required>
                                @error('city')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 dash-input-wrapper mb-30 form-group">
                                <label for="service_category_id" class="control-label">Service Category: </label>

                                <select name="service_category_id" class="nice-select form-control" wire:model="service_category_id" required>
                                    @if($sprovider->service_category_id)
                                    <option value="{{$sprovider->category}}">{{$sprovider->category->name}}</option>
                                    @endif
                                    @foreach ($scategories as $scategory)
                                    <option value="{{ $scategory->id }}">{{ $scategory->name }}</option>
                                    @endforeach
                                </select>
                                @error('service_category_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="col-md-4 dash-input-wrapper mb-30 form-group">
                                <label for="service_location" class="control-label">Service Locations</label>

                                <input type="text" class="form-control" name="service_locations" value="{{$sprovider->service_locations}}" required>
                                @error('service_locations')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label"></label>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-success pull-right">Update Profile</button>
                            </div>
                        </div>
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