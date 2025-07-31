<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Drivers')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"><?php echo e(__('Drivers')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Driver List')); ?></h5>
                        </div>
                        <?php if(Gate::check('create driver')): ?>
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="md"
                                   data-url="<?php echo e(route('drivers.create')); ?>" data-title="<?php echo e(__('Add Driver')); ?>">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> <?php echo e(__('Add Driver')); ?>

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
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Phone')); ?></th>
                                    <th><?php echo e(__('Email')); ?></th>
                                    <th><?php echo e(__('License Number')); ?></th>
                                    <th><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($driver->name); ?></td>
                                        <td><?php echo e($driver->phone); ?></td>
                                        <td><?php echo e($driver->email); ?></td>
                                        <td><?php echo e($driver->license_number); ?></td>
                                        <td class="text-end">
                                        <?php if(Gate::check('edit driver') || Gate::check('delete driver')): ?>
                                            <div class="d-flex justify-content-end">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit driver')): ?>
                                                    <a href="#" class="btn btn-sm btn-info customModal me-1"
                                                       data-url="<?php echo e(route('drivers.edit', $driver->id)); ?>"
                                                       data-title="<?php echo e(__('Edit driver')); ?>">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete driver')): ?>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['drivers.destroy', $driver->id], 'id' => 'driver-'.$driver->id]); ?>

                                                        <button type="submit" class="btn btn-sm btn-danger confirm_dialog">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    <?php echo Form::close(); ?>

                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/drivers/index.blade.php ENDPATH**/ ?>