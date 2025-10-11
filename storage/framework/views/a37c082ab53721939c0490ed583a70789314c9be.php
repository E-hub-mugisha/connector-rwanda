
<?php $__env->startSection('title', 'Job Applications'); ?>
<?php $__env->startSection('content'); ?>


<div class="content-wrapper">
    <div class="row">

        <h2><?php echo e($job->title ?? 'Unknown'); ?> Applications</h2>

        <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo e(session('success')); ?>

            <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
        </div>
        <?php endif; ?>

        <table class="table table-hover table-bordered mt-3">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Job</th>
                    <th>Applicant</th>
                    <th>Status</th>
                    <th>Applied On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $job->applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($app->id); ?></td>
                    <td><?php echo e($app->job->title ?? 'N/A'); ?></td>
                    <td>
                        <?php
                        $provider = $app->user ? \App\Models\ServiceProvider::where('user_id', $app->user->id)->first() : null;
                        ?>

                        <?php if($provider): ?>
                        <a href="<?php echo e(route('home.service-provider_profile', $app->user->id)); ?>"
                            class="text-primary font-weight-bold"
                            title="View <?php echo e($app->user->name); ?>'s provider profile">
                            <i class="fa fa-briefcase text-info mr-1"></i> <?php echo e($app->user->name); ?>

                        </a>
                        <?php elseif($app->user): ?>
                        <span class="text-dark">
                            <i class="fa fa-user mr-1 text-muted"></i> <?php echo e($app->user->name); ?>

                        </span>
                        <?php else: ?>
                        <span class="text-muted">N/A</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge badge-<?php echo e($app->status == 'pending' ? 'secondary' : ($app->status=='accepted' ? 'success' : 'danger')); ?>">
                            <?php echo e(ucfirst($app->status)); ?>

                        </span>
                    </td>
                    <td><?php echo e($app->created_at->format('d M Y')); ?></td>
                    <td class="d-flex gap-1">
                        <!-- View Applicant Modal Trigger -->
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewApplicantModal<?php echo e($app->id); ?>">
                            <i class="fa fa-eye"></i>View
                        </button>

                        <!-- Accept/Reject -->
                        <?php if($app->status == 'pending'): ?>
                        <form action="<?php echo e(route('provider.applications.accept', $app->id)); ?>" method="POST" class="mr-1">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa-check"></i>Accept
                            </button>
                        </form>

                        <form action="<?php echo e(route('provider.applications.reject', $app->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa fa-times"></i> Reject
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>

                <!-- View Applicant Modal -->
                <div class="modal fade" id="viewApplicantModal<?php echo e($app->id); ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content shadow-lg border-0 rounded-lg">

                            <div class="modal-header" style="background: linear-gradient(135deg, #6c757d, #343a40); color: #fff;">
                                <h5 class="modal-title">
                                    <i class="fa fa-user mr-2"></i> Applicant - <?php echo e($app->user->name ?? 'N/A'); ?>

                                </h5>
                                <button type="button" class="close text-white" data-bs-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <h6><i class="fa fa-envelope mr-2"></i>Email</h6>
                                    <p class="border rounded p-2 bg-light"><?php echo e($app->user->email ?? 'N/A'); ?></p>
                                </div>
                                <div class="mb-3">
                                    <h6><i class="fa fa-file-alt mr-2"></i>Cover Letter</h6>
                                    <p class="border rounded p-2 bg-light"><?php echo e($app->cover_letter); ?></p>
                                </div>
                                <div class="mb-3">
                                    <h6><i class="fa fa-file-pdf mr-2"></i>Resume</h6>
                                    <?php if($app->resume): ?>
                                    <a href="<?php echo e(asset('storage/'.$app->resume)); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                    <?php else: ?>
                                    <p>N/A</p>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <h6><i class="fa fa-briefcase mr-2"></i>Job Applied</h6>
                                    <p class="border rounded p-2 bg-light"><?php echo e($app->job->title ?? 'N/A'); ?></p>
                                </div>
                            </div>

                            <div class="modal-footer border-top-0">
                                <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-bs-dismiss="modal">
                                    <i class="fa fa-times mr-1"></i> Close
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">No applicants yet.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.staradmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\connector\git\hiletask\resources\views/stadmin/jobs/applications.blade.php ENDPATH**/ ?>