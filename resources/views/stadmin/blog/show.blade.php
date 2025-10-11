@extends('layouts.staradmin')
@section('title','Blog Detail')
@section('content')

<div class="content-wrapper">
    <div class="row justify-content-center">
        <!-- Blog Detail Card -->
        <div class="col-xl-8 col-lg-9">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <!-- Blog Image -->
                    <a href="#">
                        <img src="{{asset('image/blog')}}/{{$blog->image}}" alt="{{$blog->title}}" class="img-fluid" style="border-radius: 8px;">
                    </a>

                    <!-- Meta Information -->
                    <div class="entry-meta mt-3">
                        <span class="entry-author text-muted">
                            by <a href="#">HileTasker</a>
                        </span>
                        <span class="meta-separator text-muted">|</span>
                        <a href="#" class="text-muted">{{ $blog->created_at->format('F j, Y') }}</a>
                        <span class="meta-separator text-muted">|</span>
                        <a href="#" class="text-muted">2 Comments</a>
                    </div><!-- End .entry-meta -->

                    <!-- Blog Title -->
                    <h4 class="entry-title mt-3">
                        <a href="#" class="text-dark">{{ Str::limit($blog->title, 50) }}</a>
                    </h4><!-- End .entry-title -->

                    <!-- Blog Category -->
                    <div class="entry-cats text-muted">
                        in <a href="#" class="text-info">{{$blog->blog_category}}</a>
                    </div><!-- End .entry-cats -->

                    <!-- Blog Content -->
                    <div class="entry-content mt-4">
                        <p>{!! $blog->content !!}</p>
                        <img src="{{asset('image/blog')}}/{{$blog->thumbnail}}" alt="{{$blog->title}}" class="img-fluid" style="border-radius: 8px;">
                    </div><!-- End .entry-content -->

                    <!-- Edit Blog Button -->
                    <div class="form-footer mt-4">
                        <a href="{{route('serviceProviderBlog.editBlog', $blog->id)}}" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-edit"></i>
                            </span>
                            <span class="text">Edit Blog</span>
                        </a>
                    </div><!-- End .form-footer -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
