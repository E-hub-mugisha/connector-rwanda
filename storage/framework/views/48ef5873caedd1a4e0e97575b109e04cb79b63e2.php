<?php $__env->startSection('title', 'Account'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <div class="row justify-content-center">

        <div class="col-md-10 col-lg-8 d-flex justify-content-center align-items-center grid-margin stretch-card">
            <div class="card container mb-3" style="border-radius: .5rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <div class="row g-0">
                    <!-- Profile Picture & About Info -->
                    <div class="col-md-4 gradient-custom">
                        <div class="d-flex justify-content-center align-items-center flex-column my-5">
                            <?php if($sprovider->image): ?>
                            <img src="<?php echo e(asset('image/profile')); ?>/<?php echo e($sprovider->image); ?>" alt="Avatar" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;" />
                            <?php else: ?>
                            <img src="<?php echo e(asset('assets/images/sproviders/avatar.jpg')); ?>" alt="Avatar" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;" />
                            <?php endif; ?>
                            <h5 class="text-white"><?php echo e(Auth::user()->name); ?></h5>
                        </div>


                    </div>

                    <!-- Account Details -->
                    <div class="col-md-8">
                        <div class="card-body p-4">
                            <h6 class="mb-4" style="font-weight: bold;">Account Information</h6>
                            <hr class="mt-0 mb-4">

                            <div class="row pt-1">
                                <div class="col-4 mb-3">
                                    <h6>Email</h6>
                                    <p class="text-muted"><?php echo e(Auth::user()->email); ?></p>
                                </div>
                                <div class="col-4 mb-3">
                                    <h6>Phone</h6>
                                    <p class="text-muted"><?php echo e(Auth::user()->phone); ?></p>
                                </div>
                                <div class="col-4 mb-3">
                                    <h6>City</h6>
                                    <p class="text-muted"><?php echo e($sprovider->city); ?></p>
                                </div>
                            </div>

                            <div class="row pt-1">
                                <h6>Service Details</h6>
                                <hr class="mt-0 mb-4">
                                <div class="col-6 mb-3">
                                    <h6>Service Category</h6>
                                    <p class="text-muted"><?php if($sprovider->service_category_id): ?> <?php echo e($sprovider->category->name); ?> <?php endif; ?></p>
                                </div>
                                <div class="col-6 mb-3">
                                    <h6>Service Location</h6>
                                    <p class="text-muted"><?php echo e($sprovider->service_locations); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <h5 class="mb-3">About</h5>
                            <p><?php echo $sprovider->about; ?></p>
                        </div>
                        <div class="mb-3">
                            <h5 class="mb-3">Skills</h5>
                            <p><?php echo $sprovider->skills; ?></p>
                        </div>
                        <div class="mb-3">
                            <h5>Qualification</h5>
                            <p><?php echo $sprovider->qualification; ?></p>
                        </div>
                        <div class="mb-3">
                            <h5>Experience</h5>
                            <p><?php echo $sprovider->experience; ?></p>
                        </div>

                        <!-- Edit Account Button -->
                        <div class="d-sm-flex justify-content-between mb-4 align-items-start">
                            <div>
                                <a href="<?php echo e(route('sprovider.edit_profile')); ?>" class="btn btn-primary btn-sm text-white mb-0 me-0" type="button"><i class="mdi mdi-pencil"></i>Edit Account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .gradient-custom {
        background: linear-gradient(45deg, #ff7e5f, #feb47b);
    }

    .hover-icon:hover {
        color: #007bff;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .text-muted {
        color: #6c757d !important;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.staradmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/connector/public_html/hiletask/resources/views/stadmin/account/index.blade.php ENDPATH**/ ?>