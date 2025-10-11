
<?php $__env->startSection('title', 'Working Hours'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                        <div>
                            <h4 class="card-title card-title-dash"><?php echo $__env->yieldContent('title'); ?></h4>
                        </div>
                        <div>
                            <div class="btn-wrapper">
                                <button class="btn btn-primary btn-sm text-white mb-0 me-0" type="button" data-bs-toggle="modal" data-bs-target="#portfolioModal"><i class="mdi mdi-plus"></i>Add new Hours</button>
                            </div>
                        </div>
                    </div>

                    <?php if($message = Session::get('success')): ?>
                    <div class="alert alert-success">
                        <p><?php echo e($message); ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="table-responsive  mt-1">
                        <table class="table select-table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Is Closed</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $workingHours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workingHour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                <td><?php echo e($workingHour->day); ?></td>
                                <td><?php echo e($workingHour->is_closed ? 'Yes' : 'No'); ?></td>
                                <td><?php echo e($workingHour->start_time); ?></td>
                                <td><?php echo e($workingHour->end_time); ?></td>
                                <td>
                                    <a class="btn btn-primary" href="<?php echo e(route('working_hours.edit', $workingHour->id)); ?>">Edit</a>
                                    <form action="<?php echo e(route('working_hours.destroy', $workingHour->id)); ?>" method="POST" style="display:inline-block;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="portfolioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $__env->yieldContent('title'); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?php if(Session::has('message')): ?>
                    <div class="alert alert-success" role="alert"><?php echo e(Session::get('message')); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('working_hours.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="sprovider_id" value="<?php echo e($sprovider->id); ?>">
                                <div class="mb-3">
                                    <label for="day" class="form-label">Day</label>
                                    <input type="text" class="form-control" name="day" id="day" placeholder="Enter Day">
                                    <?php $__errorArgs = ['day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-3">
                                    <label for="is_closed" class="form-label">Is Closed</label>
                                    <input type="checkbox" name="is_closed" id="is_closed" value="1">
                                </div>
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" name="start_time" id="start_time">
                                    <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">End Time</label>
                                    <input type="time" class="form-control" name="end_time" id="end_time">
                                    <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('is_closed').addEventListener('change', function() {
                let timeFields = document.querySelectorAll('#time-fields');
                if (this.checked) {
                    timeFields.forEach(function(field) {
                        field.style.display = 'none';
                    });
                } else {
                    timeFields.forEach(function(field) {
                        field.style.display = 'block';
                    });
                }
            });
        </script>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.staradmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/connector/public_html/hiletask/resources/views/stadmin/working_hours/index.blade.php ENDPATH**/ ?>