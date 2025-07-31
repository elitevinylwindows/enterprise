<?php $__env->startSection('page-title', __('Stock Alerts')); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Stock Alerts')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5><?php echo e(__('Stock Alerts')); ?></h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="<?php echo e(route('inventory.stock-alerts.batch_requests')); ?>"
                           data-title="<?php echo e(__('Create Stock Alert')); ?>">
                           <i data-feather="copy"></i> <?php echo e(__('Bulk Create')); ?>

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
        <th><?php echo e(__('Reorder level')); ?></th>
        <th><?php echo e(__('Current Stock')); ?></th>
        <th><?php echo e(__('Reorder Qty')); ?></th>
        <th><?php echo e(__('Status')); ?></th>
        <th><?php echo e(__('Purchase Request')); ?></th>
        <th><?php echo e(__('Alert Date')); ?></th>
        <th><?php echo e(__('Action')); ?></th>
    </tr>
</thead>
<tbody>
    <?php $__currentLoopData = $stock_alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($alert->product->name ?? ''); ?></td>
        <td><?php echo e($alert->reorder_level); ?></td>
        <td><?php echo e($alert->current_stock); ?></td>
        <td><?php echo e($alert->reorder_qty); ?></td>
        <td><?php echo e($alert->status); ?></td>
        <td>
    <?php if($alert->purchaseRequest): ?>
        <a href="#"
           class="text-primary customModal"
           data-size="lg"
           data-url="<?php echo e(route('purchasing.purchase-requests.show', $alert->purchaseRequest->id)); ?>"
           data-title="Purchase Request">
           <?php echo e($alert->purchaseRequest->purchase_request_id); ?>

        </a>
    <?php else: ?>
        <span class="text-muted">–</span>
    <?php endif; ?>
</td>

        <td><?php echo e(\Carbon\Carbon::parse($alert->alert_date)->format('Y-m-d')); ?></td>
        <td>
   <!-- Edit Alert -->
<a class="avtar avtar-xs btn-link-primary text-primary customModal"
   data-bs-toggle="tooltip"
   data-bs-original-title="Edit"
   href="#"
   data-size="xl"
   data-url="<?php echo e(route('inventory.stock-alerts.edit', $alert->id)); ?>"
   data-title="Edit Alert">
    <i data-feather="edit"></i>
</a>

<?php if($alert->status === 'Low Stock'): ?>
    <!-- Create Request -->
    <a href="#"
       class="avtar avtar-xs btn-link-warning text-warning"
       onclick="event.preventDefault(); document.getElementById('create-request-<?php echo e($alert->id); ?>').submit();"
       title="Create Purchase Request">
        <i data-feather="hexagon"></i>
    </a>

   <form id="create-request-<?php echo e($alert->id); ?>" action="<?php echo e(route('inventory.stock-alerts.create_request', $alert->id)); ?>" method="GET" style="display: none;">
</form>

<?php else: ?>
    <span class="badge bg-success" data-bs-toggle="tooltip" title="Request already created">Requested</span>
<?php endif; ?>



<!-- Delete Alert -->
<a class="avtar avtar-xs btn-link-danger text-danger customModal"
   data-bs-toggle="tooltip"
   data-bs-original-title="Delete"
   href="#"
   data-size="md"
   data-url="<?php echo e(route('inventory.stock-alerts.destroy', $alert->id)); ?>"
   data-title="Delete Alert">
    <i data-feather="trash-2"></i>
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


 <!-- Batched Request 
    <a class="avtar avtar-xs btn-link-success text-primary customModal"
       data-bs-toggle="tooltip"
       data-bs-original-title="Batched Request"
       href="#"
       data-size="xl"
       data-url="<?php echo e(route('inventory.stock-alerts.batch_requests')); ?>"
       data-title="Batched Request">
        <i data-feather="copy"></i>
    </a>-->
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/inventory/stock_alerts/index.blade.php ENDPATH**/ ?>