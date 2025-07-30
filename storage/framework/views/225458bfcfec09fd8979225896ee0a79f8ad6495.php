<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('SealingAssignment')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="#"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('SealingAssignment')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
        <i data-feather="plus"></i> <?php echo e(__('Add SealingAssignment')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5><?php echo e(__('SealingAssignment')); ?></h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="dataTable">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Rebate Depth')); ?></th>
<th><?php echo e(__('Installation Thickness From')); ?></th>
<th><?php echo e(__('Installation Thickness To')); ?></th>
<th><?php echo e(__('Style')); ?></th>
<th><?php echo e(__('Profile System')); ?></th>
<th><?php echo e(__('Condition')); ?></th>
<th><?php echo e(__('Comment')); ?></th>
<th><?php echo e(__('Area')); ?></th>
<th><?php echo e(__('Evaluation')); ?></th>
<th><?php echo e(__('Manufacturer System')); ?></th>
<th><?php echo e(__('Sort Order')); ?></th>
                                <th class="text-end"><?php echo e(__('Actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->rebate_depth); ?></td>
<td><?php echo e($item->installation_thickness_from); ?></td>
<td><?php echo e($item->installation_thickness_to); ?></td>
<td><?php echo e($item->style); ?></td>
<td><?php echo e($item->profile_system); ?></td>
<td><?php echo e($item->condition); ?></td>
<td><?php echo e($item->comment); ?></td>
<td><?php echo e($item->area); ?></td>
<td><?php echo e($item->evaluation); ?></td>
<td><?php echo e($item->manufacturer_system); ?></td>
<td><?php echo e($item->sort_order); ?></td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-info" data-id="<?php echo e($item->id); ?>"><i data-feather="edit"></i></a>
                                        <button class="btn btn-sm btn-danger" data-id="<?php echo e($item->id); ?>"><i data-feather="trash-2"></i></button>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/master/products/sealingassignment/index.blade.php ENDPATH**/ ?>