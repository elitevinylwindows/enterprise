

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Invoice Check')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"><?php echo e(__('Invoice Check')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5><?php echo e(__('Invoice Check')); ?></h5>
                    </div>
                   
                </div>
            </div>
                    <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="ordersTable">
                        <thead>
                            <tr>
                                <th>Order #</th>
                <th>Customer #</th>
                <th>Customer Name</th>
                <th>Payment Method</th>
                <th>Payment Amount</th>
                <th>Payment Status</th>
                <th>Cancel Note</th>
                <th>Delivery Note</th>
                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($invoice->order_number); ?></td>
                    <td><?php echo e($invoice->customer); ?></td>
                    <td><?php echo e($invoice->customer_name); ?></td>
<td><?php echo e(ucfirst($invoice->payment_method ?? '-')); ?></td>
<td><?php echo e($invoice->payment_amount ?? '-'); ?></td>
<td><?php echo e(ucfirst($invoice->payment_status ?? '-')); ?></td>

                    <td><?php echo e($invoice->cancel_note ?? '-'); ?></td>
                    <td><?php echo e($invoice->delivery_note ?? '-'); ?></td>
                    <td>
                        <span class="badge bg-<?php echo e($invoice->status === 'delivered' ? 'success' : ($invoice->status === 'cancelled' ? 'danger' : 'info')); ?>">
                            <?php echo e(ucfirst($invoice->status)); ?>

                        </span>
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





<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/invoice_checker/index.blade.php ENDPATH**/ ?>