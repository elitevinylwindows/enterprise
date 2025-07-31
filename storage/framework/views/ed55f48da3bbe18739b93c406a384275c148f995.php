<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Series Names')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Master')); ?></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Series Names')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
    <button type="button" class="btn btn-md btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addItemModal">
        <i class="ti ti-plus"></i> Add Series Names
    </button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5><?php echo e(__('Series Names List')); ?></h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Series</th>
                                <th>Series Names</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
<?php $__currentLoopData = $seriesNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seriesName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($seriesName->id); ?></td>
        <td><?php echo e($seriesName->series->series ?? '-'); ?></td>
        <td><?php echo e($seriesName->series_name); ?></td>
        <td>
            <!-- Edit Button -->
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editItemModal<?php echo e($seriesName->id); ?>">
                Edit
            </button>

            <!-- Delete Form -->
            <form action="<?php echo e(route('master.series-name.destroy', $seriesName->id)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </td>
    </tr>

    <!-- Edit Modal -->
    <div class="modal fade" id="editItemModal<?php echo e($seriesName->id); ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo $__env->make('master.series.series_name.edit', [
                    'seriesName' => $seriesName,
                    'series' => $series
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo $__env->make('master.series.series_name.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/master/series/series_name/index.blade.php ENDPATH**/ ?>