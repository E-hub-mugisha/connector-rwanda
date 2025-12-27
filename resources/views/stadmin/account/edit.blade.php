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
                    <form id="profileForm" enctype="multipart/form-data">
                        @csrf

                        <!-- Image -->
                        <div class="mb-3">
                            <img id="profileImagePreview" src="{{ $sprovider->image ? asset('image/profile/'.$sprovider->image) : asset('assets/images/sproviders/avatar.jpg') }}" width="80">
                            <input type="file" name="image" class="form-control">
                            <span class="text-danger" id="imageError"></span>
                        </div>

                        <!-- About -->
                        <textarea name="about" class="form-control summernote" required>{{ $sprovider->about }}</textarea>
                        <span class="text-danger" id="aboutError"></span>

                        <!-- Skills -->
                        <textarea name="skills" class="form-control summernote" required>{{ $sprovider->skills }}</textarea>
                        <span class="text-danger" id="skillsError"></span>

                        <!-- Qualification -->
                        <textarea name="qualification" class="form-control summernote" required>{{ $sprovider->qualification }}</textarea>
                        <span class="text-danger" id="qualificationError"></span>

                        <!-- Experience -->
                        <textarea name="experience" class="form-control summernote" required>{{ $sprovider->experience }}</textarea>
                        <span class="text-danger" id="experienceError"></span>

                        <!-- City -->
                        <input type="text" name="city" class="form-control" value="{{ $sprovider->city }}" required>
                        <span class="text-danger" id="cityError"></span>

                        <!-- Category -->
                        <select name="service_category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($scategories as $category)
                            <option value="{{ $category->id }}" {{ $sprovider->service_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="categoryError"></span>

                        <!-- Service Locations -->
                        <input type="text" name="service_locations" class="form-control" value="{{ $sprovider->service_locations }}" required>
                        <span class="text-danger" id="locationsError"></span>

                        <button type="submit" class="btn btn-success mt-2">Update Profile</button>
                    </form>

                    <div id="successMessage" class="text-success mt-2"></div>

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


<script>
$(document).ready(function(){
    $('#profileForm').on('submit', function(e){
        e.preventDefault();

        var formData = new FormData(this);

        // Clear previous errors
        $('span.text-danger').text('');
        $('#successMessage').text('');

        $.ajax({
            url: "{{ route('sprovider.profile.ajaxUpdate') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                if(response.status === 'success'){
                    $('#successMessage').text(response.message);
                    if(response.image){
                        $('#profileImagePreview').attr('src', response.image);
                    }
                }
            },
            error: function(xhr){
                let errors = xhr.responseJSON.errors;
                if(errors){
                    $.each(errors, function(key, value){
                        $('#' + key + 'Error').text(value[0]);
                    });
                }
            }
        });
    });
});
</script>

@endsection