@extends('layouts.staradmin')

@section('title', 'Add Service')

@section('content')
<div class="content-wrapper">
    <form action="{{ route('serviceProvider.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Basic Information -->
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body row">
                        <h4 class="card-title">Basic Information</h4>
                        <p class="card-description">Fill in the form</p>

                        <div class="form-group col-md-4">
                            <label>Service Name</label>
                            <input type="text" class="form-control" name="name" required>
                            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label>Service Category</label>
                            <select class="form-control" name="service_category_id" required>
                                <option value="">Select service category</option>
                                @if(isset($sprovider->category))
                                    <option value="{{ $sprovider->category->id }}">{{ $sprovider->category->name }}</option>
                                @endif
                            </select>
                            @error('service_category_id') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label>Sub-category</label>
                            <input type="text" class="form-control" name="sub_category" required>
                            @error('sub_category') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label>Discount Type</label>
                            <select class="form-control" name="discount_type">
                                <option value="">Select type</option>
                                <option value="fixed">Fixed</option>
                                <option value="percent">Percent</option>
                            </select>
                            @error('discount_type') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label>Discount</label>
                            <input type="text" class="form-control" name="discount">
                            @error('discount') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label>Duration *</label>
                            <input type="text" class="form-control" name="duration" required>
                            @error('duration') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label>Price</label>
                            <input type="text" class="form-control" name="price" required>
                            @error('price') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description & Other Fields -->
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <textarea class="form-control summernote" name="description" required></textarea>
                                @error('description') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Inclusion</label>
                                <textarea class="form-control summernote" name="inclusion" required></textarea>
                                @error('inclusion') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Exclusion</label>
                                <textarea class="form-control summernote" name="exclusion" required></textarea>
                                @error('exclusion') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Location</label>
                                    <input type="text" class="form-control" name="location">
                                    @error('location') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>File Upload</label>
                                    <input type="file" class="form-control" name="image" >
                                    @error('image') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <button type="reset" class="btn btn-light">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Include Summernote -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200,
            placeholder: 'Type here...',
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
