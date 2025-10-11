
<?php $__env->startSection('title','Users'); ?>
<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center py-3">
            <h6 class="m-0 font-weight-bold text-primary">Meet Our Users</h6>
        </div>
        <div class="card-body">
            <?php if(Session::has('message')): ?>
            <div class="alert alert-success" role="alert"><?php echo e(Session::get('message')); ?></div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>UTYPE</th>
                            <th>Verified</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($user->id); ?></td>
                            <td>
                                <img src="<?php echo e($user->image ? asset('assets/images/sproviders/'.$user->image) : asset('assets/images/sproviders/avatar.jpg')); ?>" alt="<?php echo e($user->name); ?>" width="50" class="rounded-circle">
                            </td>
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td><?php echo e($user->phone); ?></td>
                            <td><?php echo e(ucfirst($user->utype)); ?></td>
                            <td>
                                <?php if($user->email_verified_at || $user->is_verified): ?>
                                    <span class="badge badge-success">Verified</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Unverified</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($user->created_at->format('d M Y')); ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Options
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?php echo e(route('admin.activate', $user->id)); ?>" onclick="return confirm('Activate as Admin?');">
                                            <span class="badge badge-primary">Activate Admin</span>
                                        </a>
                                        <a class="dropdown-item" href="<?php echo e(route('customer.activate', $user->id)); ?>" onclick="return confirm('Activate as Customer?');">
                                            <span class="badge badge-success">Activate Customer</span>
                                        </a>
                                        <a class="dropdown-item" href="<?php echo e(route('provider.activate', $user->id)); ?>" onclick="return confirm('Activate as Provider?');">
                                            <span class="badge badge-warning">Activate Provider</span>
                                        </a>
                                        <?php if(!$user->email_verified_at && !$user->is_verified): ?>
                                        <a href="#verifyModal<?php echo e($user->id); ?>" class="dropdown-item text-info" data-toggle="modal">
                                            <span class="badge badge-info">Verify User</span>
                                        </a>
                                        <?php endif; ?>
                                        <form action="<?php echo e(route('users.delete', $user->id)); ?>" method="POST" onsubmit="return confirm('Delete this user?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="dropdown-item text-danger">
                                                <span class="badge badge-danger">Delete User</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal for each user -->
                        <div class="modal fade" id="verifyModal<?php echo e($user->id); ?>" tabindex="-1" role="dialog" aria-labelledby="verifyModalLabel<?php echo e($user->id); ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form method="POST" action="<?php echo e(route('users.verify', $user->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="modal-content">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title" id="verifyModalLabel<?php echo e($user->id); ?>">Verify User</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to verify <strong><?php echo e($user->name); ?></strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-info">Yes, Verify</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\connector\git\hiletask\resources\views/admin/users/index.blade.php ENDPATH**/ ?>