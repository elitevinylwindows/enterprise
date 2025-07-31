
<?php $__env->startSection('page-title', __('Purchase Orders')); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Purchase Orders')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5><?php echo e(__('Purchase Orders')); ?></h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="<?php echo e(route('purchasing.purchase-orders.create')); ?>"
                           data-title="<?php echo e(__('Create Order')); ?>">
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
                                <th><?php echo e(__('Order No')); ?></th>
                                <th><?php echo e(__('Supplier')); ?></th>
                                <th><?php echo e(__('Request No')); ?></th>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Tracking #')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $purchaseOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($order->order_number); ?></td>
                                <td><?php echo e($order->supplier->name ?? 'N/A'); ?></td>
                                <td><?php echo e($order->purchaseRequest->request_number ?? 'N/A'); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($order->order_date)->format('Y-m-d')); ?></td>
                                <td><span class="badge bg-light-<?php echo e($order->status == 'pending' ? 'warning' : 'success'); ?>"><?php echo e(ucfirst($order->status)); ?></span></td>
                                <td><?php echo e($order->tracking_number ?? '-'); ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="<?php echo e(route('purchasing.purchase-orders.edit', $order->id)); ?>"
                                       data-title="<?php echo e(__('Edit Order')); ?>">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/purchasing/purchase_orders/index.blade.php ENDPATH**/ ?>