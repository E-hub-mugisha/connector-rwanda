
<?php $__env->startSection('title', 'Job Openings'); ?>
<?php $__env->startSection('content'); ?>

<div class="inner-banner-one position-relative">
    <div class="container">
        <div class="position-relative">
            <div class="row">
                <div class="col-xl-6 m-auto text-center">
                    <div class="title-two">
                        <h2 class="text-white">Job Listing </h2>
                    </div>
                    <p class="text-lg text-white mt-30 lg-mt-20 mb-35 lg-mb-20">We delivered blazing fast &amp; striking work solution</p>
                </div>
            </div>
            <div class="position-relative">
                <div class="row">
                    <div class="col-xl-9 col-lg-8 m-auto">
                        <div class="job-search-one position-relative">
                            <form action="job-grid-v1.html">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="input-box">
                                            <div class="label">What are you looking for?</div>
                                            <select class="nice-select lg" style="display: none;">
                                                <option value="1">UI Designer</option>
                                                <option value="2">Content creator</option>
                                                <option value="3">Web Developer</option>
                                                <option value="4">SEO Guru</option>
                                                <option value="5">Digital marketer</option>
                                            </select>
                                            <div class="nice-select lg" tabindex="0"><span class="current">UI Designer</span>
                                                <ul class="list">
                                                    <li data-value="1" class="option selected">UI Designer</li>
                                                    <li data-value="2" class="option">Content creator</li>
                                                    <li data-value="3" class="option">Web Developer</li>
                                                    <li data-value="4" class="option">SEO Guru</li>
                                                    <li data-value="5" class="option">Digital marketer</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-box border-left">
                                            <div class="label">Category</div>
                                            <select class="nice-select lg" style="display: none;">
                                                <option value="1">Web Design</option>
                                                <option value="2">Design &amp; Creative</option>
                                                <option value="3">It &amp; Development</option>
                                                <option value="4">Web &amp; Mobile Dev</option>
                                                <option value="5">Writing</option>
                                                <option value="6">Sales &amp; Marketing</option>
                                                <option value="7">Music &amp; Audio</option>
                                            </select>
                                            <div class="nice-select lg" tabindex="0"><span class="current">Web Design</span>
                                                <ul class="list">
                                                    <li data-value="1" class="option selected">Web Design</li>
                                                    <li data-value="2" class="option">Design &amp; Creative</li>
                                                    <li data-value="3" class="option">It &amp; Development</li>
                                                    <li data-value="4" class="option">Web &amp; Mobile Dev</li>
                                                    <li data-value="5" class="option">Writing</li>
                                                    <li data-value="6" class="option">Sales &amp; Marketing</li>
                                                    <li data-value="7" class="option">Music &amp; Audio</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="fw-500 text-uppercase h-100 tran3s search-btn">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.job-search-one -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <img src="images/shape/shape_02.svg" alt="" class="lazy-img shapes shape_01" style="">
    <img src="images/shape/shape_03.svg" alt="" class="lazy-img shapes shape_02" style="">
</div>

<section class="job-listing-three bg-color pt-90 lg-pt-80 pb-160 xl-pb-150 lg-pb-80">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="job-post-item-wrapper">
                    <div class="upper-filter d-flex justify-content-between align-items-start align-items-sm-center mb-30">
                        <div class="d-sm-flex align-items-center">
                            <button type="button" class="filter-btn fw-500 tran3s me-3" data-bs-toggle="modal" data-bs-target="#filterPopUp">
                                <i class="bi bi-funnel"></i>
                                Filter
                            </button>
                            <div class="total-job-found xs-mt-10">All <span class="text-dark fw-500">7,096</span> jobs found</div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="short-filter d-flex align-items-center">
                                <div class="text-dark fw-500 me-2">Short:</div>
                                <select class="nice-select" style="display: none;">
                                    <option value="0">Latest</option>
                                    <option value="1">Category</option>
                                    <option value="2">Job Type</option>
                                </select>
                                <div class="nice-select" tabindex="0"><span class="current">Latest</span>
                                    <ul class="list">
                                        <li data-value="0" class="option selected">Latest</li>
                                        <li data-value="1" class="option">Category</li>
                                        <li data-value="2" class="option">Job Type</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.upper-filter -->
                    <div class="wrapper">
                        <div class="row">
                            <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-6 mb-30">
                                <div class="job-list-three d-flex h-100 w-100">
                                    <div class="main-wrapper h-100 w-100">
                                        <a href="<?php echo e(route('home.jobs.show', $job->id)); ?>" class="save-btn text-center rounded-circle tran3s" title="Save Job"><i class="bi bi-bookmark-dash"></i></a>
                                        <div class="list-header d-flex align-items-center">
                                            <a href="<?php echo e(route('home.jobs.show', $job->id)); ?>" class="logo"><img src="images/logo/media_22.png" alt="" class="lazy-img m-auto" style=""></a>
                                            <div class="info-wrapper">
                                                <a href="<?php echo e(route('home.jobs.show', $job->id)); ?>" class="title fw-500 tran3s"><?php echo e($job->title); ?></a>
                                                <ul class="style-none d-flex flex-wrap info-data">
                                                    <li><?php echo e($job->company->name); ?></li>
                                                    <li><?php echo e($job->location); ?></li>
                                                    <li><?php echo e($job->deadline); ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- ./.list-header -->
                                        <p><?php echo e($job->description); ?></p>
                                        <div class="d-sm-flex align-items-center justify-content-between mt-auto">
                                            <div class="d-flex align-items-center">
                                                <img src="images/icon/icon_51.svg" alt="">
                                                <span class="fw-500 client-status"><?php echo e($job->status); ?></span>
                                                <a href="<?php echo e(route('home.jobs.show', $job->id)); ?>" class="job-duration fw-500"><?php echo e($job->type); ?></a>
                                            </div>
                                            <a href="<?php echo e(route('home.jobs.show', $job->id)); ?>" class="apply-btn text-center tran3s xs-mt-20">APPLY</a>
                                        </div>
                                    </div>
                                </div> <!-- /.job-list-three -->
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <!-- /.accordion-box -->

                    <div class="pt-30 lg-pt-20 d-sm-flex align-items-center justify-content-between">
                        <p class="m0 order-sm-last text-center text-sm-start xs-pb-20">Showing <span class="text-dark fw-500">1 to 20</span> of <span class="text-dark fw-500">7,096</span></p>
                        <ul class="pagination-one d-flex align-items-center justify-content-center justify-content-sm-start style-none">
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li>....</li>
                            <li class="ms-2"><a href="#" class="d-flex align-items-center">Last <img src="images/icon/icon_50.svg" alt="" class="ms-2"></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /.job-post-item-wrapper -->
            </div>
            <!-- /.col- -->
        </div>
    </div>
</section>
<!-- /.job-listing-three -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\connector\git\hiletask\resources\views/pages/jobs/index.blade.php ENDPATH**/ ?>