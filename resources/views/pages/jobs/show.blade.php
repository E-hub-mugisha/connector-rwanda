@extends('layouts.base')
@section('title', 'Job Details')
@section('content')

<div class="inner-banner-one position-relative">
    <div class="container">
        <div class="position-relative">
            <div class="row">
                <div class="col-xl-6 m-auto text-center">
                    <div class="title-two">
                        <h2 class="text-white">Job Details</h2>
                    </div>
                    <p class="text-lg text-white mt-30 lg-mt-20">Here will be your company job details &amp; requirements</p>
                </div>
            </div>
        </div>
    </div>
    <img src="images/shape/shape_02.svg" alt="" class="lazy-img shapes shape_01" style="">
    <img src="images/shape/shape_03.svg" alt="" class="lazy-img shapes shape_02" style="">
</div>

<section class="job-details pt-100 lg-pt-80 pb-130 lg-pb-80">
    <div class="container">
        <div class="row">
            <div class="col-xxl-9 col-xl-8">
                <div class="details-post-data me-xxl-5 pe-xxl-4">
                    <div class="post-date">{{ $job->created_at->format('d M Y') }} by <a href="#" class="fw-500 text-dark">{{ $job->company->name }}</a></div>
                    <h3 class="post-title">{{ $job->title }}</h3>
                    <ul class="share-buttons d-flex flex-wrap style-none">
                        <li><a href="#" class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-facebook"></i>
                                <span>Facebook</span>
                            </a></li>
                        <li><a href="#" class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-twitter"></i>
                                <span>Twitter</span>
                            </a></li>
                        <li><a href="#" class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-link-45deg"></i>
                                <span>Copy</span>
                            </a></li>
                    </ul>

                    <div class="post-block border-style mt-50 lg-mt-30">
                        <div class="d-flex align-items-center">
                            <div class="block-numb text-center fw-500 text-white rounded-circle me-2">1</div>
                            <h4 class="block-title">Overview</h4>
                        </div>
                        <p>{{ $job->company->about }}</p>
                    </div>
                    <div class="post-block border-style mt-30">
                        <div class="d-flex align-items-center">
                            <div class="block-numb text-center fw-500 text-white rounded-circle me-2">2</div>
                            <h4 class="block-title">Job Description</h4>
                        </div>
                        <p>
                            {{ $job->description }}
                        </p>
                    </div>
                    <div class="post-block border-style mt-40 lg-mt-30">
                        <div class="d-flex align-items-center">
                            <div class="block-numb text-center fw-500 text-white rounded-circle me-2">3</div>
                            <h4 class="block-title">Responsibilities</h4>
                        </div>
                        <ul class="list-type-one style-none mb-15">
                            <li>{{ $job->responsibilities }}</li>
                        </ul>
                    </div>
                    <div class="post-block border-style mt-40 lg-mt-30">
                        <div class="d-flex align-items-center">
                            <div class="block-numb text-center fw-500 text-white rounded-circle me-2">4</div>
                            <h4 class="block-title">Required Skills:</h4>
                        </div>
                        <ul class="list-type-two style-none mb-15">
                            <li>{{ $job->requirements }}</li>
                        </ul>
                    </div>
                </div>
                <!-- /.details-post-data -->
            </div>

            <div class="col-xxl-3 col-xl-4">
                <div class="job-company-info ms-xl-5 ms-xxl-0 lg-mt-50">
                    <img src="{{asset('image/profile')}}/{{$job->company->image}}" alt="" class="lazy-img m-auto logo" style="">
                    <div class="text-md text-dark text-center mt-15 mb-20">{{ $job->company->name }}</div>
                    <a href="{{route('home.service-provider_profile',['sprovider_id'=>$job->company->id])}}" class="website-btn tran3s">Visit profile</a>

                    <div class="border-top mt-40 pt-40">
                        <ul class="job-meta-data row style-none">
                            <li class="col-xl-7 col-md-4 col-sm-6">
                                <span>Status</span>
                                <div>{{ $job->status }}</div>
                            </li>
                            <li class="col-xl-5 col-md-4 col-sm-6">
                                <span>Expertise</span>
                                <div>{{ $job->expertise }}</div>
                            </li>
                            <li class="col-xl-7 col-md-4 col-sm-6">
                                <span>Location</span>
                                <div>{{ $job->location }}</div>
                            </li>
                            <li class="col-xl-5 col-md-4 col-sm-6">
                                <span>Job Type</span>
                                <div>{{ $job->type }}</div>
                            </li>
                            <li class="col-xl-7 col-md-4 col-sm-6">
                                <span>Date</span>
                                <div>{{ $job->deadline }}</div>
                            </li>
                            <li class="col-xl-5 col-md-4 col-sm-6">
                                <span>Experience</span>
                                <div>{{ $job->experience }} Years</div>
                            </li>
                        </ul>

                        <div class="job-tags d-flex flex-wrap pt-15">
                            <a href="#">Design</a>
                            <a href="#">Product Design</a>
                            <a href="#">Brands</a>
                            <a href="#">Application</a>
                            <a href="#">UI/UX</a>
                        </div>
                        <a data-bs-toggle="modal" data-bs-target="#applyModal{{ $job->id }}" class="btn-one w-100 mt-25">Apply Now</a>

                        <!-- Apply Modal -->
                        <div class="modal fade" id="applyModal{{ $job->id }}" tabindex="-1" aria-labelledby="applyModalLabel{{ $job->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <form action="{{ route('apply.job') }}" method="POST" enctype="multipart/form-data" class="modal-content shadow-lg rounded-4 border-0">
                                    @csrf
                                    <input type="hidden" name="job_id" value="{{ $job->id }}">

                                    <!-- Modal Header with Gradient -->
                                    <div class="modal-header p-4 rounded-top" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); color: #fff;">
                                        <h5 class="modal-title d-flex align-items-center gap-2" id="applyModalLabel{{ $job->id }}">
                                            <i class="bi bi-send-fill"></i> Apply for {{ $job->title }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body p-4 bg-light">
                                        @if(session('success'))
                                        <div class="alert alert-success rounded-3">{{ session('success') }}</div>
                                        @elseif(session('error'))
                                        <div class="alert alert-danger rounded-3">{{ session('error') }}</div>
                                        @endif

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold"><i class="bi bi-pencil-square me-1"></i> Cover Letter</label>
                                            <textarea name="cover_letter" class="form-control form-control-lg shadow-sm" rows="5" placeholder="Write your cover letter..." required></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold"><i class="bi bi-file-earmark-arrow-up me-1"></i> Upload Resume</label>
                                            <input type="file" name="resume" class="form-control form-control-lg shadow-sm" accept=".pdf,.doc,.docx">
                                            <small class="text-muted">PDF, DOC, DOCX formats only. Max size: 2MB</small>
                                        </div>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="modal-footer p-3 border-0">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle me-1"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary rounded-pill d-flex align-items-center gap-2">
                                            <i class="bi bi-send-fill"></i> Submit Application
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.job-company-info -->
            </div>
        </div>
    </div>
</section>

<section class="related-job-section pt-90 lg-pt-70 pb-120 lg-pb-70">
    <div class="container">
        <div class="position-relative">
            <div class="title-three text-center text-md-start mb-55 lg-mb-40">
                <h2 class="main-font">Related Jobs</h2>
            </div>

            <div class="related-job-slider slick-initialized slick-slider">
                <div class="slick-list draggable">
                    <div class="slick-track" style="opacity: 1; width: 4290px; transform: translate3d(-2340px, 0px, 0px);">
                        @foreach($relatedJobs as $relatedJob)
                        <div class="item slick-slide" data-slick-index="0" id="" aria-hidden="false" style="width: 360px;" tabindex="-1">
                            <div class="job-list-two style-two position-relative">
                                <a href="{{ route('home.jobs.show', $relatedJob->id) }}" class="logo" tabindex="-1"><img src="images/logo/media_23.png" alt="" class="m-auto"></a>
                                <a href="{{ route('home.jobs.show', $relatedJob->id) }}" class="save-btn text-center rounded-circle tran3s" title="Save Job" tabindex="-1"><i class="bi bi-bookmark-dash"></i></a>
                                <div><a href="{{ route('home.jobs.show', $relatedJob->id) }}" class="job-duration fw-500 part-time" tabindex="-1">{{ $relatedJob->type }}</a></div>
                                <div><a href="{{ route('home.jobs.show', $relatedJob->id) }}" class="title fw-500 tran3s" tabindex="-1">{{ $relatedJob->title }}</a></div>
                                <div class="job-salary"><span class="fw-500 text-dark">{{ $relatedJob->company->name }}</span></div>
                                <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <div class="job-location"><a href="{{ route('home.jobs.show', $relatedJob->id) }}" tabindex="-1">{{ $relatedJob->location }}</a></div>
                                    <a href="{{ route('home.jobs.show', $relatedJob->id) }}" class="apply-btn text-center tran3s" tabindex="-1">APPLY</a>
                                </div>
                            </div> <!-- /.job-list-two -->
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <ul class="slider-arrows slick-arrow-one color-two d-flex justify-content-center style-none sm-mt-20">
                <li class="prev_e slick-arrow" style=""><i class="bi bi-arrow-left"></i></li>
                <li class="next_e slick-arrow" style=""><i class="bi bi-arrow-right"></i></li>
            </ul>
        </div>
    </div>
</section>
@endsection