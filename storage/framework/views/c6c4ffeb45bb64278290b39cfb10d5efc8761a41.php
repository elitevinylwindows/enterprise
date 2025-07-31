

<?php $__env->startSection('page-title', __('Invoices')); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Invoices')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5><?php echo e(__('Invoices')); ?></h5>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="<?php echo e(route('sales.invoices.create')); ?>"
                           data-title="<?php echo e(__('Send to Quickbooks')); ?>">
                            <i data-feather="plus"></i> <?php echo e(__('Send to Quickbooks')); ?>

                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead class="table-light">
                            <tr>
                                <th><?php echo e(__('Customer Number')); ?></th>
                                <th><?php echo e(__('Customer Name')); ?></th>
                                <th><?php echo e(__('Invoice Date')); ?></th>
                                <th><?php echo e(__('Net Price')); ?></th>
                                <th><?php echo e(__('Paid Amount')); ?></th>
                                <th><?php echo e(__('Remaining Amount')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Notes')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($invoice->customer->customer_number ?? '-'); ?></td>
                                    <td><?php echo e($invoice->customer->customer_name ?? '-'); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d')); ?></td>
                                    <td>$<?php echo e(number_format($invoice->net_price, 2)); ?></td>
                                    <td>$<?php echo e(number_format($invoice->paid_amount, 2)); ?></td>
                                    <td>$<?php echo e(number_format($invoice->net_price - $invoice->paid_amount, 2)); ?></td>
                                    <td>
                                        <?php if($invoice->status === 'paid'): ?>
                                            <span class="badge bg-success">Paid</span>
                                        <?php elseif($invoice->status === 'partial'): ?>
                                            <span class="badge bg-warning text-dark">Partially Paid</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Unpaid</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($invoice->notes); ?></td>
                                    <td class="text-nowrap">
                                        <a href="#" class="btn btn-sm btn-info customModal"
                                           data-size="lg"
                                           data-url="<?php echo e(route('sales.invoices.edit', $invoice->id)); ?>"
                                           data-title="<?php echo e(__('Edit Invoice')); ?>">
                                            <i data-feather="edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div> <!-- table-responsive -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col -->
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/sales/invoices/index.blade.php ENDPATH**/ ?>