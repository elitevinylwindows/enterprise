<?php $__env->startSection('page-title', __('Stock Levels')); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Stock Levels')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5><?php echo e(__('Stock Levels')); ?></h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="<?php echo e(route('inventory.stock-level.create')); ?>"
                           data-title="<?php echo e(__('Create Stock Level')); ?>">
                           <i data-feather="plus"></i> <?php echo e(__('Create')); ?>

                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
    <tr>
        <th><?php echo e(__('Product')); ?></th>
        <th><?php echo e(__('Location')); ?></th>
        <th><?php echo e(__('Stock On Hand')); ?></th>
        <th><?php echo e(__('Reserved')); ?></th>
        <th><?php echo e(__('Available')); ?></th>
        <th><?php echo e(__('Min. Level')); ?></th>
        <th><?php echo e(__('Max. Level')); ?></th>
        <th><?php echo e(__('Reorder Level')); ?></th>
        <th><?php echo e(__('Action')); ?></th>
    </tr>
</thead>
<tbody>
    <?php $__currentLoopData = $stockLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($level->product->name ?? ''); ?></td>
        <td><?php echo e($level->location->name ?? ''); ?></td>
        <td><?php echo e($level->stock_on_hand ?? 0); ?></td>
        <td><?php echo e($level->stock_reserved ?? 0); ?></td>
        <td><?php echo e($level->stock_available ?? 0); ?></td>
        <td><?php echo e($level->minimum_level ?? 0); ?></td>
        <td><?php echo e($level->maximum_level ?? 0); ?></td>
        <td><?php echo e($level->reorder_level ?? 0); ?></td>
        <td>
            <a href="#" class="btn btn-sm btn-info customModal"
               data-size="lg"
               data-url="<?php echo e(route('inventory.stock-level.edit', $level->id)); ?>"
               data-title="<?php echo e(__('Edit Stock Level')); ?>">
               <i data-feather="edit"></i>
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
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/inventory/stock_levels/index.blade.php ENDPATH**/ ?>