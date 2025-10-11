@extends('layouts.staradmin')

@section('title', 'Edit Blog')

@section('content')

<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card shadow mb-4">
                <!-- Card Body -->
                <div class="card-body">
                    <!-- Card Title -->
                    <h4 class="card-title ">Edit {{ $blog->title }}</h4>
                    @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                    @endif

                    <form action="{{ route('serviceProviderBlog.blogUpdate', $blog->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <!-- Title -->
                            <div class="form-group">
                                <label for="title">Title *</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $blog->title }}" required>
                                @error('title') <p class="text-danger">{{ $message }}</p>@enderror
                            </div>

                            <!-- Blog Category -->
                            <div class="col-md-6 form-group">
                                <label for="blog_category">Blog Category</label>
                                <select class="form-control" id="blog_category" name="blog_category">
                                    <option value="{{ $blog->blog_category }}">{{ $blog->blog_category }}</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('blog_category') <p class="text-danger">{{ $message }}</p>@enderror
                            </div>

                            <!-- Sub Category -->
                            <div class="col-md-6 form-group">
                                <label for="sub_category">Sub Category</label>
                                <select class="form-control" id="sub_category" name="sub_category">
                                    <option value="{{ $blog->sub_category }}">{{ $blog->sub_category }}</option>
                                    @foreach($subcategory as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('sub_category') <p class="text-danger">{{ $message }}</p>@enderror
                            </div>

                            <!-- Content -->
                            <div class="form-group col-md-12">
                                <label for="content">Content</label>
                                <textarea class="form-control summernote" id="content" name="content" required>{!! $blog->content !!}</textarea>
                                @error('content') <p class="text-danger">{{ $message }}</p>@enderror
                            </div>

                            <!-- Image -->
                            <div class="form-group col-md-6">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" value="{{asset('image/blog')}}/{{$blog->image}}" id="image" name="image">
                                @error('image') <p class="text-danger">{{ $message }}</p>@enderror
                                <img src="{{asset('image/blog')}}/{{$blog->image}}" width="60">
                            </div>

                            <!-- Thumbnail -->
                            <div class="form-group col-md-6">
                                <label for="thumbnail">Thumbnail</label>
                                <input type="file" class="form-control" value="{{asset('image/blog')}}/{{$blog->thumbnail}}" id="thumbnail" name="thumbnail">
                                @error('thumbnail') <p class="text-danger">{{ $message }}</p>@enderror
                                <img src="{{asset('image/blog')}}/{{$blog->thumbnail}}" width="60">
                            </div>

                            <!-- Status -->
                            <div class="form-group col-md-6">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="{{ $blog->status }}">{{ $blog->status }}</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>

                            <!-- Featured -->
                            <div class="form-group col-md-6">
                                <label for="featured">Featured</label>
                                <select class="form-control" name="featured" id="featured">
                                    <option value="1" {{ $blog->featured == 1 ? 'selected' : '' }}>True</option>
                                    <option value="0" {{ $blog->featured == 0 ? 'selected' : '' }}>False</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-flag"></i>
                                    </span>
                                    <span class="text">Update Blog</span>
                                </button>
                            </div>
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
            placeholder: 'Edit your blog content here...',
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