

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Markup')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Master')); ?></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Markup')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
    <button type="button" class="btn btn-md btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addMarkupModal">
        <i class="ti ti-plus"></i> Add Markup
    </button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5><?php echo e(__('Markup List')); ?></h5>
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
                                <th>Markup (%)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $markups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $markup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($markup->id); ?></td>
                                    <td><?php echo e($markup->series->series ?? 'N/A'); ?></td>
                                    <td><?php echo e($markup->percentage); ?>%</td>
                                    <td>
                                        <?php if(!$markup->locked): ?>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editMarkupModal<?php echo e($markup->id); ?>">
                                                Edit
                                            </button>

                                            <form action="<?php echo e(route('master.prices.markup.lock', $markup->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Lock this markup?')">
                                                    Lock
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Locked</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editMarkupModal<?php echo e($markup->id); ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <?php echo $__env->make('master.prices.markup.edit', ['markup' => $markup], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<div class="modal fade" id="addMarkupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo $__env->make('master.prices.markup.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/master/prices/markup/index.blade.php ENDPATH**/ ?>