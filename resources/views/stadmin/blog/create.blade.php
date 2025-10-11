@extends('layouts.staradmin')

@section('title', 'Create Blog')

@section('content')

<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-10">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Add Blog</h6>
                </div>
                <div class="card-body">
                    @if(Session::has('message'))
                        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                    @endif

                    <form action="{{ route('serviceProviderBlog.StoreBlog') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Title -->
                            <div class="form-group col-md-12">
                                <label for="title">Title *</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                                @error('title') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                            <!-- Blog Category -->
                            <div class="col-md-6 form-group">
                                <label for="blog_category">Blog Category</label>
                                <select class="form-control" id="blog_category" name="blog_category">
                                    <option value="">-- select blog category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('blog_category') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                            <!-- Sub Category -->
                            <div class="col-md-6 form-group">
                                <label for="sub_category">Sub Category</label>
                                <select class="form-control" id="sub_category" name="sub_category">
                                    <option value="">-- select sub category --</option>
                                    @foreach($subcategory as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('sub_category') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                            <!-- Content -->
                            <div class="form-group col-md-12">
                                <label for="content">Content</label>
                                <textarea class="form-control summernote" id="content" name="content" required></textarea>
                                @error('content') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                            <!-- Image -->
                            <div class="form-group col-md-6">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" id="image" name="image" required>
                                @error('image') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                            <!-- Thumbnail -->
                            <div class="form-group col-md-6">
                                <label for="thumbnail">Thumbnail</label>
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail" required>
                                @error('thumbnail') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary">
                                <span class="text">Create Blog</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Summernote -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300,
            placeholder: 'Write your blog content here...',
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
