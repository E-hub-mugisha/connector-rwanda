<?php $__env->startSection('title', 'Edit Blog'); ?>

<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card shadow mb-4">
                <!-- Card Body -->
                <div class="card-body">
                    <!-- Card Title -->
                    <h4 class="card-title ">Edit <?php echo e($blog->title); ?></h4>
                    <?php if(Session::has('message')): ?>
                    <div class="alert alert-success" role="alert"><?php echo e(Session::get('message')); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('serviceProviderBlog.blogUpdate', $blog->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('put'); ?>
                        <div class="row">
                            <!-- Title -->
                            <div class="form-group">
                                <label for="title">Title *</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo e($blog->title); ?>" required>
                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Blog Category -->
                            <div class="col-md-6 form-group">
                                <label for="blog_category">Blog Category</label>
                                <select class="form-control" id="blog_category" name="blog_category">
                                    <option value="<?php echo e($blog->blog_category); ?>"><?php echo e($blog->blog_category); ?></option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->name); ?>"><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['blog_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Sub Category -->
                            <div class="col-md-6 form-group">
                                <label for="sub_category">Sub Category</label>
                                <select class="form-control" id="sub_category" name="sub_category">
                                    <option value="<?php echo e($blog->sub_category); ?>"><?php echo e($blog->sub_category); ?></option>
                                    <?php $__currentLoopData = $subcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->name); ?>"><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['sub_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Content -->
                            <div class="form-group col-md-12">
                                <label for="content">Content</label>
                                <textarea class="form-control summernote" id="content" name="content" required><?php echo $blog->content; ?></textarea>
                                <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Image -->
                            <div class="form-group col-md-6">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" value="<?php echo e(asset('image/blog')); ?>/<?php echo e($blog->image); ?>" id="image" name="image">
                                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <img src="<?php echo e(asset('image/blog')); ?>/<?php echo e($blog->image); ?>" width="60">
                            </div>

                            <!-- Thumbnail -->
                            <div class="form-group col-md-6">
                                <label for="thumbnail">Thumbnail</label>
                                <input type="file" class="form-control" value="<?php echo e(asset('image/blog')); ?>/<?php echo e($blog->thumbnail); ?>" id="thumbnail" name="thumbnail">
                                <?php $__errorArgs = ['thumbnail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <img src="<?php echo e(asset('image/blog')); ?>/<?php echo e($blog->thumbnail); ?>" width="60">
                            </div>

                            <!-- Status -->
                            <div class="form-group col-md-6">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="<?php echo e($blog->status); ?>"><?php echo e($blog->status); ?></option>
                                    <option value="published">Published</option>
                                </select>
                            </div>

                            <!-- Featured -->
                            <div class="form-group col-md-6">
                                <label for="featured">Featured</label>
                                <select class="form-control" name="featured" id="featured">
                                    <option value="1" <?php echo e($blog->featured == 1 ? 'selected' : ''); ?>>True</option>
                                    <option value="0" <?php echo e($blog->featured == 0 ? 'selected' : ''); ?>>False</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-flag"></i>
                                    </span>
                                    <span class="text">Update Blog</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Summernote -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300,
            placeholder: 'Edit your blog content here...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.staradmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/connector/public_html/hiletask/resources/views/stadmin/blog/edit.blade.php ENDPATH**/ ?>