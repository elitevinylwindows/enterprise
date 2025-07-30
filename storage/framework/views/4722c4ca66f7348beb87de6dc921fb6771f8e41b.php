

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Shops')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"><?php echo e(__('Shops')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('card-action-btn'); ?>
<form action="<?php echo e(route('shops.import')); ?>" method="POST" enctype="multipart/form-data" class="d-inline-block">
    <?php echo csrf_field(); ?>
    <input type="file" name="import_file" accept=".csv, .xls, .xlsx" required class="form-control d-inline-block w-auto">
    <button type="submit" class="btn btn-sm btn-primary">
        <i data-feather="upload"></i> Import Shops
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
                        <h5><?php echo e(__('Shops')); ?></h5>
                    </div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create shop')): ?>
                        <div class="col-auto">
                    
                            <a href="#" class="btn btn-primary customModal"
                               data-size="lg"
                               data-url="<?php echo e(route('shops.create')); ?>"
                               data-title="<?php echo e(__('Create Shop')); ?>">
                                <i data-feather="plus"></i> <?php echo e(__('Create')); ?>

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
                                <th><?php echo e(__('Customer #')); ?></th>
                                <th><?php echo e(__('Customer Name')); ?></th>
                                 <th><?php echo e(__('Email')); ?></th>
                                  <th><?php echo e(__('Phone')); ?></th>
                                <th><?php echo e(__('Address')); ?></th>
                                <th><?php echo e(__('City')); ?></th>
                                <th><?php echo e(__('ZIP')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($shop->customer); ?></td>
                                    <td><?php echo e($shop->customer_name); ?></td>
                                     <td><?php echo e($shop->email); ?></td>
                                      <td><?php echo e($shop->contact_phone); ?></td>
                                    <td><?php echo e($shop->address); ?></td>
                                    <td><?php echo e($shop->city); ?></td>
                                    <td><?php echo e($shop->zip); ?></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info customModal"
                                           data-size="lg"
                                           data-url="<?php echo e(route('shops.edit', $shop->id)); ?>"
                                           data-title="<?php echo e(__('Edit Shop')); ?>">
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/shops/index.blade.php ENDPATH**/ ?>