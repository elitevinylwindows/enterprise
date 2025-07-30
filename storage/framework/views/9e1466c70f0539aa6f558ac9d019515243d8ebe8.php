<?php $__env->startSection('page-title', __('Barcode Generator')); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Barcode Generator')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5><?php echo e(__('Barcode Generator')); ?></h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="<?php echo e(route('inventory.barcodes.create')); ?>"
                           data-title="<?php echo e(__('Create Barcode')); ?>">
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
                                <th><?php echo e(__('SKU')); ?></th>
                                <th><?php echo e(__('Barcode')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $barcodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barcode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($barcode->product); ?></td>
                                <td><?php echo e($barcode->sku); ?></td>
                                <td>
                                    <img src="data:image/png;base64,<?php echo e(DNS1D::getBarcodePNG($barcode->barcode, 'C128')); ?>" alt="barcode" />
                                    <div><?php echo e($barcode->barcode); ?></div>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="<?php echo e(route('inventory.barcodes.edit', $barcode->id)); ?>"
                                       data-title="<?php echo e(__('Edit Barcode')); ?>">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/inventory/barcodes/index.blade.php ENDPATH**/ ?>