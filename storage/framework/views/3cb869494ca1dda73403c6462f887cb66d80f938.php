<?php $__env->startSection('page-title', __('HS Units')); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item active" aria-current="page"><?php echo e(__('HS Units')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5><?php echo e(__('HS Units')); ?></h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="<?php echo e(route('hs-unit.create')); ?>"
                           data-title="<?php echo e(__('Create HS Unit')); ?>">
                           <i data-feather="plus"></i> <?php echo e(__('Create')); ?>

                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
                            <tr><th><?php echo e(__('Schema Id')); ?></th>
                            <th><?php echo e(__('Product Id')); ?></th>
                            <th><?php echo e(__('Product Code')); ?></th>
                            <th><?php echo e(__('Retrofit')); ?></th>
                            <th><?php echo e(__('Nailon')); ?></th>
                            <th><?php echo e(__('Block')); ?></th>
                            <th><?php echo e(__('Le3 Clr')); ?></th>
                            <th><?php echo e(__('Clr Clr')); ?></th>
                            <th><?php echo e(__('Le3 Lam')); ?></th>
                            <th><?php echo e(__('Le3 Clr Le3')); ?></th>
                            <th><?php echo e(__('Clr Temp')); ?></th>
                            <th><?php echo e(__('Lam Temp')); ?></th>
                            <th><?php echo e(__('Obs')); ?></th>
                            <th><?php echo e(__('Feat2')); ?></th>
                            <th><?php echo e(__('Feat3')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $hsunits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hsunit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($hsunit->schema_id); ?></td>
                                <td><?php echo e($hsunit->product_id); ?></td>
                                <td><?php echo e($hsunit->product_code); ?></td>
                                <td><?php echo e($hsunit->retrofit); ?></td>
                                <td><?php echo e($hsunit->nailon); ?></td>
                                <td><?php echo e($hsunit->block); ?></td>
                                <td><?php echo e($hsunit->le3_clr); ?></td>
                                <td><?php echo e($hsunit->clr_clr); ?></td>
                                <td><?php echo e($hsunit->le3_lam); ?></td>
                                <td><?php echo e($hsunit->le3_clr_le3); ?></td>
                                <td><?php echo e($hsunit->clr_temp); ?></td>
                                <td><?php echo e($hsunit->lam_temp); ?></td>
                                <td><?php echo e($hsunit->obs); ?></td>
                                <td><?php echo e($hsunit->feat2); ?></td>
                                <td><?php echo e($hsunit->feat3); ?></td>
                                <td><?php echo e($hsunit->status); ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="<?php echo e(route('hs-unit.edit', $hsunit->id)); ?>"
                                       data-title="<?php echo e(__('Edit HS Unit')); ?>">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/schemas/hsunit/index.blade.php ENDPATH**/ ?>