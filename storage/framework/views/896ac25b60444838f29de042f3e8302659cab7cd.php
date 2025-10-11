
<?php $__env->startSection('title', 'Jobs Management'); ?>
<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Jobs</h2>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addJobModal">
            <i class="bi bi-plus-circle"></i> Add Job
        </button>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>


    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle" id="dataTable" width="100%" cellspacing="0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Company</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($job->id); ?></td>
                    <td><?php echo e($job->title); ?></td>
                    <td><?php echo e($job->company->sprovider_name ?? 'N/A'); ?></td>
                    <td><?php echo e(ucfirst($job->type)); ?></td>
                    <td><?php echo e($job->location); ?></td>
                    <td><?php echo e($job->deadline ? $job->deadline->format('d M Y') : 'N/A'); ?></td>
                    <td>
                        <span class="badge bg-<?php echo e($job->status == 'open' ? 'success' : 'secondary'); ?>">
                            <?php echo e(ucfirst($job->status)); ?>

                        </span>
                    </td>
                    <td class="d-flex gap-1">
                        <!-- Edit Button -->
                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editJobModal<?php echo e($job->id); ?>">
                            Edit
                        </button>
                        <!-- View Button -->
                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewJobModal<?php echo e($job->id); ?>">
                            View
                        </button>
                        <!-- Update Status Button -->
                        <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#updateStatusModal<?php echo e($job->id); ?>">
                            Update Status
                        </button>
                        <!-- Job Applicants Button -->
                        <a class="btn btn-sm btn-primary" href="<?php echo e(route('admin.jobs.applications', $job->id)); ?>">
                            Job Applicants <i class="fa fa-users"></i> <?php echo e($job->applications->count()); ?>

                        </a>
                        <!-- Delete Button -->
                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteJobModal<?php echo e($job->id); ?>">
                            Delete
                        </button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <!-- View Job Modals -->
    <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <!-- View Job Modal -->
    <div class="modal fade" id="viewJobModal<?php echo e($job->id); ?>" tabindex="-1" role="dialog" aria-labelledby="viewJobModalLabel<?php echo e($job->id); ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg border-0 rounded-lg">

                <!-- Modal Header -->
                <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8, #117a8b); color: #fff;">
                    <h5 class="modal-title" id="viewJobModalLabel<?php echo e($job->id); ?>">
                        <i class="fa fa-briefcase mr-2"></i> Job Details - <?php echo e($job->title); ?>

                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="mb-3">
                        <h6><i class="fa fa-align-left mr-2"></i>Description</h6>
                        <p class="border rounded p-2 bg-light"><?php echo e($job->description); ?></p>
                    </div>

                    <div class="mb-3">
                        <h6><i class="fa fa-list-alt mr-2"></i>Requirements</h6>
                        <p class="border rounded p-2 bg-light"><?php echo e($job->requirements ?? 'N/A'); ?></p>
                    </div>

                    <div class="mb-3">
                        <h6><i class="fa fa-tasks mr-2"></i>Responsibilities</h6>
                        <p class="border rounded p-2 bg-light"><?php echo e($job->responsibilities ?? 'N/A'); ?></p>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6><i class="fa fa-building mr-2"></i>Company</h6>
                            <p class="border rounded p-2 bg-light"><?php echo e($job->company->sprovider_name ?? 'N/A'); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6><i class="fa fa-clock mr-2"></i>Type</h6>
                            <p class="border rounded p-2 bg-light"><?php echo e(ucfirst($job->type)); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6><i class="fa fa-map-marker mr-2"></i>Location</h6>
                            <p class="border rounded p-2 bg-light"><?php echo e($job->location); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6><i class="fa fa-calendar mr-2"></i>Deadline</h6>
                            <p class="border rounded p-2 bg-light"><?php echo e($job->deadline ? $job->deadline->format('d M Y') : 'N/A'); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6><i class="fa fa-info-circle mr-2"></i>Status</h6>
                            <p class="border rounded p-2 bg-light"><?php echo e(ucfirst($job->status)); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-dismiss="modal">
                        <i class="fa fa-times mr-1"></i> Close
                    </button>
                </div>

            </div>
        </div>
    </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!-- update status modal -->
    <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="updateStatusModal<?php echo e($job->id); ?>" tabindex="-1">
        <div class="modal-dialog">
            <form action="<?php echo e(route('admin.jobs.updateStatus', $job->id)); ?>" method="POST" class="modal-content">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">Update Job Status - <?php echo e($job->title); ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <?php $__currentLoopData = ['open','closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status); ?>" <?php echo e($job->status == $status ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst($status)); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-secondary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!-- Edit Job Modals -->
    <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <!-- Edit Job Modal -->
    <div class="modal fade" id="editJobModal<?php echo e($job->id); ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="<?php echo e(route('admin.jobs.update', $job->id)); ?>" method="POST" class="modal-content">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">Edit Job - <?php echo e($job->title); ?></h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php echo $__env->make('admin.jobs.form', ['job' => $job], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update Job</button>
                </div>
            </form>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <!-- Delete Job Modal -->
    <div class="modal fade" id="deleteJobModal<?php echo e($job->id); ?>" tabindex="-1">
        <div class="modal-dialog">
            <form action="<?php echo e(route('admin.jobs.destroy', $job->id)); ?>" method="POST" class="modal-content">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Delete Job</h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the job <strong><?php echo e($job->title); ?></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Job</button>
                </div>
            </form>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <!-- Add Job Modal -->
    <div class="modal fade" id="addJobModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="<?php echo e(route('admin.jobs.store')); ?>" method="POST" class="modal-content">
                <?php echo csrf_field(); ?>
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add New Job</h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php echo $__env->make('admin.jobs.form', ['job' => null], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Job</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\connector\git\hiletask\resources\views/admin/jobs/index.blade.php ENDPATH**/ ?>