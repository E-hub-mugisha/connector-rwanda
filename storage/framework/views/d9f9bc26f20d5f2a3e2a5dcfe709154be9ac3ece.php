<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="<?php echo e($job->title ?? ''); ?>" required>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4" required><?php echo e($job->description ?? ''); ?></textarea>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Type</label>
        <select name="type" class="form-control" required>
            <?php $__currentLoopData = ['full-time','part-time','contract']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($type); ?>" <?php echo e(isset($job) && $job->type==$type ? 'selected' : ''); ?>>
                    <?php echo e(ucfirst($type)); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control" value="<?php echo e($job->location ?? ''); ?>" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Requirements</label>
    <textarea name="requirements" class="form-control" rows="3"><?php echo e($job->requirements ?? ''); ?></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Responsibilities</label>
    <textarea name="responsibilities" class="form-control" rows="3"><?php echo e($job->responsibilities ?? ''); ?></textarea>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Deadline</label>
        <input type="date" name="deadline" class="form-control" value="<?php echo e(isset($job) ? $job->deadline->format('Y-m-d') : ''); ?>">
    </div>
</div>
<?php /**PATH D:\connector\git\hiletask\resources\views/stadmin/jobs/form.blade.php ENDPATH**/ ?>