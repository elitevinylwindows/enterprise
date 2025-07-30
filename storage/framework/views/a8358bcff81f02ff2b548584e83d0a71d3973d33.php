<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Coupon')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Coupon')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Coupon List')); ?></h5>
                        </div>
                        <?php if(Gate::check('create coupon')): ?>
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="lg"
                                    data-url="<?php echo e(route('coupons.create')); ?>" data-title="<?php echo e(__('Create Coupon')); ?>"> <i
                                        class="ti ti-circle-plus align-text-bottom"></i> <?php echo e(__('Create Coupon')); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Coupon Name')); ?></th>
                                    <th><?php echo e(__('Type')); ?></th>
                                    <th><?php echo e(__('Rate')); ?></th>
                                    <th><?php echo e(__('Code')); ?></th>
                                    <th><?php echo e(__('Valid For')); ?></th>
                                    <th><?php echo e(__('Use Limit')); ?></th>
                                    <th><?php echo e(__('Applicable Packages')); ?></th>
                                    <th><?php echo e(__('Total Used')); ?></th>
                                    <th><?php echo e(__('status')); ?></th>
                                    <?php if(Gate::check('edit coupon') || Gate::check('delete coupon')): ?>
                                        <th class="text-right"><?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr role="row">
                                        <td> <?php echo e($coupon->name); ?> </td>
                                        <td> <?php echo e(\App\Models\Coupon::$type[$coupon->type]); ?> </td>
                                        <td><?php echo e($coupon->rate); ?> </td>
                                        <td><?php echo e($coupon->code); ?> </td>
                                        <td><?php echo e(dateFormat($coupon->valid_for)); ?> </td>
                                        <td><?php echo e($coupon->use_limit); ?> </td>
                                        <td>

                                            <?php $__currentLoopData = $coupon->package($coupon->applicable_packages); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge bg-light-secondary ms-2 f-12"> <?php echo e($package->title); ?> </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </td>
                                        <td><?php echo e($coupon->usedCoupon()); ?></td>
                                        <td>
                                            <?php if($coupon->status == 1): ?>
                                                <span
                                                    class="badge bg-success ms-2 f-12"><?php echo e(\App\Models\Coupon::$status[$coupon->status]); ?></span>
                                            <?php else: ?>
                                                <span
                                                    class="badge bg-danger ms-2 f-12"><?php echo e(\App\Models\Coupon::$status[$coupon->status]); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <?php if(Gate::check('edit coupon') || Gate::check('delete coupon')): ?>
                                            <td class="text-right">
                                                <div class="cart-action">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['coupons.destroy', $coupon->id]]); ?>


                                                    <?php if(Gate::check('edit coupon')): ?>
                                                        <a class="avtar avtar-xs btn-link-secondary text-secondary customModal" data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Edit')); ?>" data-size="lg"
                                                            href="#"
                                                            data-url="<?php echo e(route('coupons.edit', $coupon->id)); ?>"
                                                            data-title="<?php echo e(__('Edit Coupon')); ?>"> <i
                                                                data-feather="edit"></i></a>
                                                    <?php endif; ?>
                                                    <?php if(Gate::check('delete coupon')): ?>
                                                        <a class=" avtar avtar-xs btn-link-danger text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Detete')); ?>"
                                                            href="#"> <i data-feather="trash-2"></i></a>
                                                    <?php endif; ?>
                                                    <?php echo Form::close(); ?>

                                        </div>
                                    </td>
                                <?php endif; ?>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/coupon/index.blade.php ENDPATH**/ ?>