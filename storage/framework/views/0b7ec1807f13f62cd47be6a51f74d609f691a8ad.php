
<?php $__env->startSection('title','Service Provider'); ?>
<?php $__env->startSection('content'); ?>

<!-- Font Awesome for star icons -->
<?php $__env->startPush('styles'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<?php $__env->stopPush(); ?>

<div class="container mb-3">
    <a href="<?php echo e(route('admin.service_providers')); ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="container">
    <div class="card shadow mb-4 p-4">
        <div class="row g-4">

            <div class="col-md-6">
                <div class="text-center">
                    <img src="<?php echo e($UserProvide->image 
                        ? asset('image/profile/'.$UserProvide->image) 
                        : asset('assets/images/sproviders/avatar.jpg')); ?>" 
                        alt="<?php echo e($UserProvide->user->name ?? 'Provider'); ?>" 
                        class="rounded-circle img-thumbnail mb-3" 
                        style="width: 100px; height: 100px; object-fit: cover;">
                    <h4><?php echo e($UserProvide->sprovider_name); ?></h4>
                    <p class="mb-1"><i class="fas fa-phone-alt me-1"></i><?php echo e($UserProvide->user->phone ?? 'N/A'); ?></p>
                    <p class="mb-1"><i class="fas fa-envelope me-1"></i><?php echo e($UserProvide->proEmail ?? 'N/A'); ?></p>
                    <p>
                        <span class="badge bg-<?php echo e($UserProvide->status === 'active' ? 'success' : 'secondary'); ?>">
                            <?php echo e(ucfirst($UserProvide->status)); ?>

                        </span>
                    </p>
                </div>

                <hr>

                <h6 class="fw-bold">Service Category</h6>
                <p><?php echo e($UserProvide->category->name ?? 'No Category Assigned'); ?></p>

                <h6 class="fw-bold mt-3">Service Location</h6>
                <p><?php echo e($UserProvide->service_locations ?? 'Not Provided'); ?></p>

                <h6 class="fw-bold mt-3">About</h6>
                <p class="text-muted"><?php echo $UserProvide->about ?? 'No description provided.'; ?></p>
            </div>

            <div class="col-md-6">
                <h5 class="fw-bold">Services</h5>
                <?php if($services && count($services) > 0): ?>
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge bg-info text-white me-1 mb-1"><?php echo e($service->name); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p class="text-muted">No services available.</p>
                <?php endif; ?>

                <hr class="my-4">

                <h5 class="fw-bold">Location Map</h5>
                <div class="rounded overflow-hidden shadow-sm">
                    <iframe class="w-100 rounded" height="280"
                        src="https://maps.google.com/maps?q=<?php echo e(urlencode($UserProvide->city)); ?>&t=&z=12&ie=UTF8&iwloc=B&output=embed"
                        frameborder="0" allowfullscreen></iframe>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold">User Reviews</h5>
                <ul class="list-group">
                    <?php if($reviews && count($reviews) > 0): ?>
                        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <p class="mb-1"><?php echo e($review->comment); ?></p>
                                    <div>
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= $review->rating): ?>
                                                <i class="fas fa-star text-warning"></i>
                                            <?php else: ?>
                                                <i class="far fa-star text-warning"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <li class="list-group-item text-muted">No reviews available.</li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\connector\git\hiletask\resources\views/admin/service-provider/show.blade.php ENDPATH**/ ?>