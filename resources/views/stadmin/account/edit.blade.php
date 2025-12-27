@extends('layouts.staradmin')
@section('title', 'Edit account')
@section('content')

<style>
    .modern-card{
        border-radius: 18px;
        border: none;
        box-shadow: 0px 10px 30px rgba(0,0,0,0.08);
    }
    .section-title{
        font-weight: 700;
        font-size: 18px;
        margin-top: 25px;
        margin-bottom: 10px;
    }
    .avatar-wrapper{
        display:flex;
        align-items:center;
        gap:20px;
    }
    .avatar-wrapper img{
        width:100px;
        height:100px;
        border-radius: 50%;
        object-fit:cover;
        border:4px solid #28a745;
        box-shadow: 0 5px 20px rgba(0,0,0,.1);
    }
</style>

<div class="content-wrapper">
<div class="row d-flex justify-content-center align-items-center">
<div class="col-md-10 grid-margin stretch-card">

<div class="card modern-card container mb-3">

    <div class="card-body">
        <h3 class="mb-1 fw-bold">Edit Profile</h3>
        <p class="text-muted mb-3">Manage and update your professional account details</p>

        <!-- Success / Error Messages -->
        <div id="loadingMessage" class="alert alert-info" style="display:none;">
            Updating profile... please wait
        </div>

        <div id="successMessage" class="alert alert-success" style="display:none;"></div>
        <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>

        <form id="profileForm" enctype="multipart/form-data">
            @csrf

            <h6 class="section-title">Profile Picture</h6>
            <div class="avatar-wrapper mb-3">
                <img id="profileImagePreview"
                     src="{{ $sprovider->image ? asset('image/profile/'.$sprovider->image) : asset('assets/images/sproviders/avatar.jpg') }}">
                <div>
                    <input type="file" name="image" class="form-control">
                    <span class="text-danger" id="imageError"></span>
                </div>
            </div>

            <h6 class="section-title">Profile Information</h6>

            <div class="mb-3">
                <label><strong>About</strong></label>
                <textarea name="about" class="form-control summernote" required>{{ $sprovider->about }}</textarea>
                <span class="text-danger" id="aboutError"></span>
            </div>

            <div class="mb-3">
                <label><strong>Skills</strong></label>
                <textarea name="skills" class="form-control summernote" required>{{ $sprovider->skills }}</textarea>
                <span class="text-danger" id="skillsError"></span>
            </div>

            <div class="mb-3">
                <label><strong>Qualification</strong></label>
                <textarea name="qualification" class="form-control summernote" required>{{ $sprovider->qualification }}</textarea>
                <span class="text-danger" id="qualificationError"></span>
            </div>

            <div class="mb-3">
                <label><strong>Experience</strong></label>
                <textarea name="experience" class="form-control summernote" required>{{ $sprovider->experience }}</textarea>
                <span class="text-danger" id="experienceError"></span>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label><strong>City</strong></label>
                    <input type="text" name="city" class="form-control" value="{{ $sprovider->city }}" required>
                    <span class="text-danger" id="cityError"></span>
                </div>

                <div class="col-md-6 mb-3">
                    <label><strong>Category</strong></label>
                    <select name="service_category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($scategories as $category)
                        <option value="{{ $category->id }}" 
                                {{ $sprovider->service_category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="categoryError"></span>
                </div>
            </div>

            <div class="mb-3">
                <label><strong>Service Locations</strong></label>
                <input type="text" name="service_locations" class="form-control" value="{{ $sprovider->service_locations }}" required>
                <span class="text-danger" id="locationsError"></span>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-success btn-lg mt-2 w-100">
                Save Changes
            </button>
        </form>

    </div>
</div>

</div>
</div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

<script>
$(document).ready(function(){

    $('.summernote').summernote({
        height: 250,
        placeholder: 'Write here...',
    });

    $('#profileForm').on('submit', function(e){
        e.preventDefault();

        var formData = new FormData(this);

        $('span.text-danger').text('');
        $('#successMessage').hide();
        $('#errorMessage').hide();

        $('#loadingMessage').show();
        $('#submitBtn').prop('disabled', true).text('Updating...');

        $.ajax({
            url: "{{ route('sprovider.profile.ajaxUpdate') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function(response){
                $('#loadingMessage').hide();
                $('#submitBtn').prop('disabled', false).text('Save Changes');

                if(response.status === 'success'){
                    $('#successMessage').text(response.message).show();

                    if(response.image){
                        $('#profileImagePreview').attr('src', response.image);
                    }
                }
            },

            error: function(xhr){
                $('#loadingMessage').hide();
                $('#submitBtn').prop('disabled', false).text('Save Changes');

                if(xhr.responseJSON && xhr.responseJSON.errors){
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value){
                        $('#' + key + 'Error').text(value[0]);
                    });
                    $('#errorMessage').text('Please fix highlighted fields.').show();
                } else {
                    $('#errorMessage').text('Something went wrong. Try again later.').show();
                }
            }
        });
    });
});
</script>

@endsection
