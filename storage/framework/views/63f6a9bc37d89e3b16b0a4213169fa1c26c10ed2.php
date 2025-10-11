

<?php $__env->startSection('title', 'Service Provider'); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Service Provider</h1>
        <a href="<?php echo e(route('admin.AddServiceProviders')); ?>" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add Service Provider
        </a>
    </div>

    <!-- DataTable Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Our Service Providers</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <?php if(Session::has('message')): ?>
                    <div class="alert alert-success" role="alert"><?php echo e(Session::get('message')); ?></div>
                <?php endif; ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__currentLoopData = $sproviders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sprovider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($sprovider->id); ?></td>
                                <td>
                                    <img src="<?php echo e($sprovider->image 
                                                ? asset('image/profile/' . $sprovider->image) 
                                                : asset('assets/images/sproviders/avatar.jpg')); ?>" 
                                        alt="<?php echo e($sprovider->user->name ?? 'Service Provider'); ?>" 
                                        width="60" height="50" 
                                        class="rounded" style="object-fit: cover;">
                                </td>
                                <td><?php echo e($sprovider->user->name ?? 'Unknown'); ?></td>
                                <td><?php echo e($sprovider->category->name ?? 'No Category'); ?></td>
                                <td><?php echo e($sprovider->user->phone ?? 'N/A'); ?></td>
                                <td><?php echo e($sprovider->service_locations ?? 'N/A'); ?></td>
                                <td>
                                    <?php if($sprovider->status === 'active'): ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary"><?php echo e(ucfirst($sprovider->status)); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($sprovider->created_at->format('Y-m-d H:i')); ?></td>
                                <td>
                                    <a class="btn btn-sm badge-info" 
                                       href="<?php echo e(route('admin.ShowServiceProviders', $sprovider->id)); ?>">
                                        Show
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    
                </table>

            </div>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/connector/public_html/hiletask/resources/views/admin/service-provider/index.blade.php ENDPATH**/ ?>