<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('SH Units')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"><?php echo e(__('SH Units')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5><?php echo e(__('SH Units')); ?></h5>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="<?php echo e(route('sh-unit.create')); ?>"
                           data-title="<?php echo e(__('Create SH Unit')); ?>">
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
                                <th><?php echo e(__('Schema ID')); ?></th>
                                <th><?php echo e(__('Product ID')); ?></th>
                                <th><?php echo e(__('Retrofit')); ?></th>
                                <th><?php echo e(__('Nailon')); ?></th>
                                <th><?php echo e(__('Block')); ?></th>
                                <th><?php echo e(__('LE3 CLR')); ?></th>
                                <th><?php echo e(__('LE3 LAM')); ?></th>
                                <th><?php echo e(__('CLR TEMP')); ?></th>
                                <th><?php echo e(__('LE3 TEMP')); ?></th>
                                <th><?php echo e(__('LAM TEMP')); ?></th>
                                <th><?php echo e(__('Feat1')); ?></th>
                                <th><?php echo e(__('Feat2')); ?></th>
                                <th><?php echo e(__('Feat3')); ?></th>
                                <th><?php echo e(__('CLR CLR')); ?></th>
                                <th><?php echo e(__('LE3 CLR LE3')); ?></th>
                                <th><?php echo e(__('LE3 COMBO')); ?></th>
                                <th><?php echo e(__('STA GRID')); ?></th>
                                <th><?php echo e(__('TPI')); ?></th>
                                <th><?php echo e(__('TPO')); ?></th>
                                <th><?php echo e(__('Acid Edge')); ?></th>
                                <th><?php echo e(__('Solar Cool')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $shunits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($unit->schema_id); ?></td>
                                    <td><?php echo e($unit->product_id); ?></td>
                                    <td><?php echo e($unit->retrofit); ?></td>
                                    <td><?php echo e($unit->nailon); ?></td>
                                    <td><?php echo e($unit->block); ?></td>
                                    <td><?php echo e($unit->le3_clr); ?></td>
                                    <td><?php echo e($unit->le3_lam); ?></td>
                                    <td><?php echo e($unit->clr_temp); ?></td>
                                    <td><?php echo e($unit->le3_temp); ?></td>
                                    <td><?php echo e($unit->lam_temp); ?></td>
                                    <td><?php echo e($unit->feat1); ?></td>
                                    <td><?php echo e($unit->feat2); ?></td>
                                    <td><?php echo e($unit->feat3); ?></td>
                                    <td><?php echo e($unit->clr_clr); ?></td>
                                    <td><?php echo e($unit->le3_clr_le3); ?></td>
                                    <td><?php echo e($unit->le3_combo); ?></td>
                                    <td><?php echo e($unit->sta_grid); ?></td>
                                    <td><?php echo e($unit->tpi); ?></td>
                                    <td><?php echo e($unit->tpo); ?></td>
                                    <td><?php echo e($unit->acid_edge); ?></td>
                                    <td><?php echo e($unit->solar_cool); ?></td>
                                    <td><?php echo e($unit->status); ?></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info customModal"
                                           data-size="lg"
                                           data-url="<?php echo e(route('sh-unit.edit', $unit->id)); ?>"
                                           data-title="<?php echo e(__('Edit SH Unit')); ?>">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/schemas/shunit/index.blade.php ENDPATH**/ ?>