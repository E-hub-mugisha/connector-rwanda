<?php $__env->startSection('title','Blog Detail'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <div class="row justify-content-center">
        <!-- Blog Detail Card -->
        <div class="col-xl-8 col-lg-9">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <!-- Blog Image -->
                    <a href="#">
                        <img src="<?php echo e(asset('image/blog')); ?>/<?php echo e($blog->image); ?>" alt="<?php echo e($blog->title); ?>" class="img-fluid" style="border-radius: 8px;">
                    </a>

                    <!-- Meta Information -->
                    <div class="entry-meta mt-3">
                        <span class="entry-author text-muted">
                            by <a href="#">HileTasker</a>
                        </span>
                        <span class="meta-separator text-muted">|</span>
                        <a href="#" class="text-muted"><?php echo e($blog->created_at->format('F j, Y')); ?></a>
                        <span class="meta-separator text-muted">|</span>
                        <a href="#" class="text-muted">2 Comments</a>
                    </div><!-- End .entry-meta -->

                    <!-- Blog Title -->
                    <h4 class="entry-title mt-3">
                        <a href="#" class="text-dark"><?php echo e(Str::limit($blog->title, 50)); ?></a>
                    </h4><!-- End .entry-title -->

                    <!-- Blog Category -->
                    <div class="entry-cats text-muted">
                        in <a href="#" class="text-info"><?php echo e($blog->blog_category); ?></a>
                    </div><!-- End .entry-cats -->

                    <!-- Blog Content -->
                    <div class="entry-content mt-4">
                        <p><?php echo $blog->content; ?></p>
                        <img src="<?php echo e(asset('image/blog')); ?>/<?php echo e($blog->thumbnail); ?>" alt="<?php echo e($blog->title); ?>" class="img-fluid" style="border-radius: 8px;">
                    </div><!-- End .entry-content -->

                    <!-- Edit Blog Button -->
                    <div class="form-footer mt-4">
                        <a href="<?php echo e(route('serviceProviderBlog.editBlog', $blog->id)); ?>" class="btn btn-primary btn-icon-split">
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.staradmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/connector/public_html/hiletask/resources/views/stadmin/blog/show.blade.php ENDPATH**/ ?>