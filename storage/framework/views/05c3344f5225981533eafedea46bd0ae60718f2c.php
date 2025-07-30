<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Material Prices')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Bill of Material')); ?></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Material Prices')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
    <button type="button" class="btn btn-md btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
        <i class="ti ti-plus"></i> Add Material
    </button>
    <form action="<?php echo e(route('price.import')); ?>" method="POST" enctype="multipart/form-data" class="d-inline-block">
        <?php echo csrf_field(); ?>
        <input type="file" name="import_file" accept=".csv, .xls, .xlsx" required class="form-control d-inline-block w-auto">
        <button type="submit" class="btn btn-md btn-outline-primary">
            <i class="ti ti-upload"></i> Import Prices
        </button>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5 class="mb-0"><?php echo e(__('Material Prices List')); ?></h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover" id="pricesTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Material Name</th>
                                <th>Description</th>
                                <th>Unit</th>
                                <th>Vendor</th>
                                <th>Price</th>
                                <th>Sold By</th>
                                <th>L in/Each Pcs</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $prices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($price->material_name); ?></td>
                                    <td><?php echo e($price->description); ?></td>
                                    <td><?php echo e($price->unit); ?></td>
                                    <td><?php echo e($price->vendor); ?></td>
                                    <td>$<?php echo e(number_format($price->price, 2)); ?></td>
                                    <td><?php echo e($price->sold_by); ?></td>
                                    <td><?php echo e($price->lin_pcs); ?></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPriceModal<?php echo e($price->id); ?>">
                                            Edit
                                        </button>
                                        <form action="<?php echo e(route('prices.destroy', $price->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editPriceModal<?php echo e($price->id); ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <?php echo $__env->make('bill_of_material.prices.edit', ['price' => $price], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<div class="modal fade" id="addMaterialModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php echo $__env->make('bill_of_material.prices.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/bill_of_material/prices/index.blade.php ENDPATH**/ ?>