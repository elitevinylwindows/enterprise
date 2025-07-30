<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Deliveries')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Deliveries')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
    <?php if(Gate::check('create delivery')): ?>
        <a class="btn btn-secondary btn-sm ml-20 customModal" href="#" data-size="lg"
            data-url="<?php echo e(route('delivery.create')); ?>" data-title="<?php echo e(__('Create Delivery')); ?>">
            <i class="ti-plus mr-5"></i><?php echo e(__('Create Delivery')); ?></a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>
                                <?php echo e(__('Deliveries')); ?>

                            </h5>
                        </div>
                        <?php if(Gate::check('create delivery')): ?>
                            <div class="col-auto">
                                <a class="btn btn-secondary customModal" href="#" data-size="lg"
                                    data-url="<?php echo e(route('deliveries.create')); ?>" data-title="<?php echo e(__('Create Delivery')); ?>">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> <?php echo e(__('Create Delivery')); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable" id="deliveriesTable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Order #')); ?></th>
                                    <th><?php echo e(__('Customer Name')); ?></th>
                                    <th><?php echo e(__('Customer')); ?></th>
                                    <th><?php echo e(__('Comment')); ?></th>
                                    <th><?php echo e(__('Address')); ?></th>
                                    <th><?php echo e(__('City')); ?></th>
                                    <th><?php echo e(__('Units')); ?></th>
                                    <th><?php echo e(__('Carts')); ?></th>
                                    <th><?php echo e(__('Driver')); ?></th>
                                    <th><?php echo e(__('Truck')); ?></th>
                                    <th><?php echo e(__('Notes')); ?></th>
                                    <th><?php echo e(__('Delivery Date')); ?></th>

                                    <th><?php echo e(__('Status')); ?></th>
                                    
                                        <th class="text-right"><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $deliveries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $delivery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr role="row">
                                       <td><?php echo e($delivery->order_number); ?></td>
    <td><?php echo e($delivery->customer_name); ?></td>
    <td><?php echo e($delivery->customer); ?></td>
        <td><?php echo e($delivery->comment); ?></td>
    <td><?php echo e($delivery->address); ?></td>
    <td><?php echo e($delivery->city); ?></td>
    <td><?php echo e($delivery->units); ?></td>
    <td><?php echo e($delivery->carts); ?></td>
   <td><?php echo e($delivery->driver?->name ?? '-'); ?></td>
   
<td><?php echo e($delivery->truck_number); ?></td> <!-- ✅ shows actual truck number -->

    <td><?php echo e($delivery->notes); ?></td>
    <td><?php echo e(\Carbon\Carbon::parse($delivery->delivery_date)->format('M d, Y')); ?></td>

    
                                     <td>
    <?php if($delivery->status == 'pending'): ?>
        <span class="d-inline badge text-bg-primary">Pending</span>
    <?php elseif($delivery->status == 'customer_notified'): ?>
        <span class="d-inline badge text-bg-info">Customer Notified</span>
    <?php elseif($delivery->status == 'in_transit'): ?>
        <span class="d-inline badge text-bg-warning">In Transit</span>
    <?php elseif($delivery->status == 'cancelled'): ?>
        <span class="d-inline badge text-bg-danger">Cancelled</span>
    <?php elseif($delivery->status == 'delivered' || $delivery->status == 'complete'): ?>
        <span class="d-inline badge text-bg-success"><?php echo e(ucfirst($delivery->status)); ?></span>
    <?php else: ?>
        <span class="d-inline badge text-bg-secondary"><?php echo e(ucfirst($delivery->status)); ?></span>
    <?php endif; ?>
</td>

                                        
                                        
                                        <td>
    <?php if(Gate::check('edit delivery') || Gate::check('delete delivery') || Gate::check('show delivery')): ?>
        <div class="cart-action">
            <?php echo Form::open(['method' => 'DELETE', 'route' => ['deliveries.destroy', $delivery->id]]); ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show delivery')): ?>
                <a class="avtar avtar-xs btn-link-warning text-warning customModal"
                    data-bs-toggle="tooltip"
                    data-bs-original-title="<?php echo e(__('Details')); ?>" href="#"
                    data-size="lg" data-url="<?php echo e(route('deliveries.show', $delivery->id)); ?>"
                    data-title="<?php echo e(__('Delivery Details')); ?>">
                    <i data-feather="eye"></i></a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit delivery')): ?>
                <a class="avtar avtar-xs btn-link-secondary text-secondary customModal"
                    data-bs-toggle="tooltip"
                    data-bs-original-title="<?php echo e(__('Edit')); ?>" href="#"
                    data-size="lg" data-url="<?php echo e(route('deliveries.edit', $delivery->id)); ?>"
                    data-title="<?php echo e(__('Edit Delivery')); ?>">
                    <i data-feather="edit"></i></a>
            <?php endif; ?>
           <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete delivery')): ?>
                <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
                    data-bs-toggle="tooltip"
                    data-bs-original-title="<?php echo e(__('Delete')); ?>" href="#">
                    <i data-feather="trash-2"></i></a>
            <?php endif; ?>-->
            <?php echo Form::close(); ?>

        </div>
    <?php endif; ?>
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

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).on('submit', '#deliveryEditForm', function (e) {
        e.preventDefault();
        let form = $(this);
        let action = form.attr('action');
        let data = form.serialize();

        $.ajax({
            url: action,
            method: 'POST',
            data: data,
            success: function (response) {
                if (response.success) {
                    $('#commonModal').modal('hide');
                    toastr.success(response.message || 'Delivery updated.');

                    // Optional: Reload the page to reflect changes
                    setTimeout(function () {
                        location.reload();
                    }, 1000); // delay to show toast before reload
                } else {
                    toastr.error(response.message || 'Failed to update.');
                }
            },
            error: function (xhr) {
                let message = xhr.responseJSON?.message || 'Server error.';
                toastr.error(message);
            }
        });
    });

    // Optional: Re-initialize tooltips if needed after reload
    $(document).on('shown.bs.modal', function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/deliveries/index.blade.php ENDPATH**/ ?>