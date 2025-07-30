<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h3>Edit Configuration</h3>
    <form action="<?php echo e(route('master.library.configurations.update', $configuration->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-3">
            <label>Series ID</label>
            <input type="number" name="series_id" class="form-control" value="<?php echo e($configuration->series_id); ?>" required>
        </div>
        <div class="mb-3">
            <label>Series Type</label>
            <input type="text" name="series_type" class="form-control" value="<?php echo e($configuration->series_type); ?>" required>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control" value="<?php echo e($configuration->category); ?>">
        </div>
        <div class="mb-3">
            <label>Image (Filename only)</label>
            <input type="text" name="image" class="form-control" value="<?php echo e($configuration->image); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/master/library/configurations/edit.blade.php ENDPATH**/ ?>