

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Suppliers')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Suppliers</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
<button type="button" class="btn btn-md btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
    <i class="ti ti-plus"></i> Add Supplier
</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <h5><?php echo e(__('Suppliers')); ?></h5>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="supplierTable">
<thead>
    <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Name</th>
        <th>Phone</th>
        <th>City</th>
        <th>Country</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
</thead>

                        <tbody>
                            <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
<td><?php echo e($supplier->id); ?></td>
<td><?php echo e(ucfirst($supplier->type)); ?></td>
<td><?php echo e($supplier->company_name); ?></td>
<td><?php echo e($supplier->phone); ?></td>
<td><?php echo e($supplier->city); ?></td>
<td><?php echo e($supplier->country); ?></td>
<td><?php echo e($supplier->status); ?></td>

<td>
    <a href="<?php echo e(route('master.suppliers.edit', $supplier->id)); ?>" class="btn btn-sm btn-primary">
        <i class="ti ti-edit"></i> Edit
    </a>
</td>
                                </tr>
                                            </div>
                                        </form>
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
<?php echo $__env->make('master.suppliers.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/master/suppliers/index.blade.php ENDPATH**/ ?>