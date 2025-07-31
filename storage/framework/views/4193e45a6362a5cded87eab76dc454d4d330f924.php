<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Truck Board')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"><?php echo e(__('Trucks')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Truck List')); ?></h5>
                        </div>
                        <?php if(Gate::check('create truck')): ?>
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="md"
                                   data-url="<?php echo e(route('trucks.create')); ?>" data-title="<?php echo e(__('Add Truck')); ?>">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> <?php echo e(__('Add Truck')); ?>

                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                   <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="ordersTable">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Truck Number')); ?></th>
                                <th><?php echo e(__('Model')); ?></th>
                                <th><?php echo e(__('Capacity')); ?></th>
                                <th><?php echo e(__('License Plate')); ?></th>
                                <th><?php echo e(__('Created Date')); ?></th>
                                <th class="text-end"><?php echo e(__('Actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $trucks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $truck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($truck->truck_number); ?></td>
                                    <td><?php echo e($truck->model); ?></td>
                                    <td><?php echo e($truck->capacity); ?></td>
                                    <td><?php echo e($truck->license_plate); ?></td>
                                    <td><?php echo e(dateFormat($truck->created_at)); ?></td>
                                    <td class="text-end">
                                        <?php if(Gate::check('edit truck') || Gate::check('delete truck')): ?>
                                            <div class="d-flex justify-content-end">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit truck')): ?>
                                                    <a href="#" class="btn btn-sm btn-info customModal me-1"
                                                       data-url="<?php echo e(route('trucks.edit', $truck->id)); ?>"
                                                       data-title="<?php echo e(__('Edit Truck')); ?>">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete truck')): ?>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['trucks.destroy', $truck->id], 'id' => 'truck-'.$truck->id]); ?>

                                                        <button type="submit" class="btn btn-sm btn-danger confirm_dialog">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    <?php echo Form::close(); ?>

                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted"><?php echo e(__('No trucks found.')); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/trucks/index.blade.php ENDPATH**/ ?>