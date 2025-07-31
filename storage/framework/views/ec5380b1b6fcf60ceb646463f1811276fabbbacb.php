<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('CM Units')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"><?php echo e(__('CM Units')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5><?php echo e(__('CM Units')); ?></h5>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="<?php echo e(route('cm-unit.create')); ?>"
                           data-title="<?php echo e(__('Create CM Unit')); ?>">
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
                                <?php $__currentLoopData = ['schema_id','retrofit','nailon','block','le3_clr','le3_lam','clr_temp','le3_temp','lam_temp','feat1','feat2','feat3','clr_clr','le3_clr_le3','le3_combo','sta_grid','tpi','tpo','acid_edge','solar_cool','status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e(__(ucwords(str_replace('_',' ', $field)))); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $cmunits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php $__currentLoopData = ['schema_id','retrofit','nailon','block','le3_clr','le3_lam','clr_temp','le3_temp','lam_temp','feat1','feat2','feat3','clr_clr','le3_clr_le3','le3_combo','sta_grid','tpi','tpo','acid_edge','solar_cool','status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td><?php echo e($unit->$field); ?></td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info customModal"
                                           data-size="lg"
                                           data-url="<?php echo e(route('cm-unit.edit', $unit->id)); ?>"
                                           data-title="<?php echo e(__('Edit CM Unit')); ?>">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/schemas/cmunit/index.blade.php ENDPATH**/ ?>