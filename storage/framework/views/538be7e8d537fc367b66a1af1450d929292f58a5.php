
<?php $__env->startSection('title', 'Services Media'); ?>
<?php $__env->startSection('content'); ?>

<style>
    .media-container {
        position: relative;
        overflow: hidden;
    }

    .media-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }

    .media-container:hover .media-image {
        transform: scale(1.1);
        /* Slight zoom-in effect on hover */
    }

    .media-options {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: rgba(0, 0, 0, 0.6);
        padding: 10px;
        border-radius: 50%;
        display: none;
    }

    .media-container:hover .media-options {
        display: block;
    }

    .media-options button {
        color: #fff;
    }
</style>
<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <!-- Header Section with Button -->
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom pb-3">
                        <h4 class="card-title"><?php echo $__env->yieldContent('title'); ?></h4>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <i class="fas fa-upload"></i> Add Media
                        </button>
                    </div>

                    <!-- Display Media Grid -->
                    <div class="container mt-4">
                        <div class="row">
                            <?php $__currentLoopData = $medias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-2 mb-4">
                                <div class="card shadow-sm">
                                    <!-- Media Content (Image or Video) -->
                                    <div class="media-container">
                                        <?php if($media->type === 'image'): ?>
                                        <img src="<?php echo e(asset('image/services/' . $media->file_path)); ?>" class="card-img-top media-image" alt="Service Image">
                                        <?php elseif($media->type === 'video'): ?>
                                        <video class="card-img-top media-image" controls style="height: 200px; object-fit: cover;">
                                            <source src="<?php echo e(asset('image/services/' . $media->file_path)); ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <?php endif; ?>
                                        <!-- Hover Effect Options -->
                                        <div class="media-options">
                                            <form action="<?php echo e(route('service-media.destroy', $media->id )); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo e($media->id); ?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </button></form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Modal for Uploading Media -->
                    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadModalLabel">Upload Media</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="uploadForm" method="POST" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="form-group">
                                            <label for="service_id">Service Name</label>
                                            <select class="form-control" name="service_id" id="service_id" required>
                                                <option value="">Select Service Name</option>
                                                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['service_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="mediaFiles" class="form-label">Select Images or Videos</label>
                                            <input type="file" class="form-control" name="files[]" id="mediaFiles" multiple required>
                                        </div>
                                        <button type="submit" class="btn btn-success w-100 mt-3">Upload</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Handle the delete button click using SweetAlert
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const mediaId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make AJAX request to delete the media
                    fetch(`/service-media/${mediaId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            }
                        }).then(response => response.json())
                        .then(data => {
                            Swal.fire(
                                'Deleted!',
                                'The media has been deleted.',
                                'success'
                            );
                            location.reload(); // Refresh the page after successful delete
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error!',
                                'Something went wrong, try again later.',
                                'error'
                            );
                        });
                }
            });
        });
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.staradmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/connector/public_html/hiletask/resources/views/stadmin/media/index.blade.php ENDPATH**/ ?>