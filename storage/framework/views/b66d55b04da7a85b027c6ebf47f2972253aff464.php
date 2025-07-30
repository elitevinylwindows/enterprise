
<?php $__env->startSection('page-title', __('Supplier Quotes')); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Supplier Quotes')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5><?php echo e(__('Supplier Quotes')); ?></h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="<?php echo e(route('purchasing.supplier-quotes.create')); ?>"
                           data-title="<?php echo e(__('Create Quote')); ?>">
                           <i class="fa-solid fa-circle-plus"></i> <?php echo e(__('Create')); ?>

                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Quote No')); ?></th>
                                <th><?php echo e(__('Product')); ?></th>
                                <th><?php echo e(__('Supplier')); ?></th>
                                <th><?php echo e(__('Purchase Request')); ?></th>
                                <th><?php echo e(__('Quote Date')); ?></th>
                                <th><?php echo e(__('Total Amount')); ?></th>
                                <th><?php echo e(__('Attachment')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $supplierQuotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($quote->quote_number); ?></td>
                                <td><?php echo e($quote->product); ?></td>
                                <td><?php echo e($quote->supplier->name ?? '-'); ?></td>
                                <td><?php echo e($quote->purchaseRequest->request_number ?? '-'); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($quote->quote_date)->format('M d, Y')); ?></td>
                                <td><?php echo e(number_format($quote->total_amount, 2)); ?></td>
                                <td>
                                    <?php if($quote->attachment): ?>
                                        <a href="<?php echo e(asset('storage/' . $quote->attachment)); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-file-pdf"></i> View
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge bg-<?php echo e($quote->status == 'accepted' ? 'success' : ($quote->status == 'rejected' ? 'danger' : 'secondary')); ?>">
                                    <?php echo e(ucfirst($quote->status)); ?></span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="<?php echo e(route('purchasing.supplier-quotes.edit', $quote->id)); ?>"
                                       data-title="<?php echo e(__('Edit Quote')); ?>">
                                       <i class="fa fa-edit"></i>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/purchasing/supplier_quotes/index.blade.php ENDPATH**/ ?>