<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Pickups')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Pickups')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
    <?php if(Gate::check('create pickup')): ?>
        <a class="btn btn-secondary btn-sm ml-20 customModal" href="#" data-size="lg"
            data-url="<?php echo e(route('pickup.create')); ?>" data-title="<?php echo e(__('Create Pickup')); ?>">
            <i class="ti-plus mr-5"></i><?php echo e(__('Create Pickup')); ?></a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Pickups')); ?></h5>
                        </div>
                        <?php if(Gate::check('create pickup')): ?>
                            <div class="col-auto">
                                <a class="btn btn-secondary customModal" href="#" data-size="lg"
                                    data-url="<?php echo e(route('pickup.create')); ?>" data-title="<?php echo e(__('Create Pickup')); ?>">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> <?php echo e(__('Create Pickup')); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable" id="pickupsTable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Order #')); ?></th>
                                    <th><?php echo e(__('Customer Name')); ?></th>
                                    <th><?php echo e(__('Customer')); ?></th>
                                    <th><?php echo e(__('Units')); ?></th>
                                    <th><?php echo e(__('Carts')); ?></th>
                                    <th><?php echo e(__('Date Picked Up')); ?></th>

                                    <th><?php echo e(__('Status')); ?></th>
                                    
                                        <th class="text-right"><?php echo e(__('Action')); ?></th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $pickups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pickup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($pickup->order_number); ?></td>
                                        <td><?php echo e($pickup->customer_name); ?></td>
                                        <td><?php echo e($pickup->customer); ?></td>
                                        <td><?php echo e($pickup->units); ?></td>
           <td><?php echo e($pickup->carts); ?></td>

                                        <td>
    <?php echo e($pickup->date_picked_up ? \Carbon\Carbon::parse($pickup->date_picked_up)->format('M d, Y') : '-'); ?>

</td>

                                        <td>
                                            <?php
                                                $statusClass = match($pickup->status) {
                                                    'pending' => 'primary',
                                                    'ready' => 'info',
                                                    'picked_up' => 'success',
                                                    'cancelled' => 'danger',
                                                    default => 'secondary'
                                                };
                                            ?>
                                            <span class="d-inline badge text-bg-<?php echo e($statusClass); ?>">
                                                <?php echo e(ucfirst($pickup->status)); ?>

                                            </span>
                                        </td>
  <td>
    <div class="cart-action">
        <?php echo Form::open(['method' => 'DELETE', 'route' => ['pickup.destroy', $pickup->id]]); ?>


        <a class="avtar avtar-xs btn-link-warning text-warning customModal"
            data-bs-toggle="tooltip" title="Details" href="#"
            data-size="lg" data-url="<?php echo e(route('pickup.show', $pickup->id)); ?>"
            data-title="Pickup Details">
            <i data-feather="eye"></i>
        </a>

        <a class="avtar avtar-xs btn-link-secondary text-secondary customModal"
            data-bs-toggle="tooltip" title="Edit" href="#"
            data-size="lg" data-url="<?php echo e(route('pickup.edit', $pickup->id)); ?>"
            data-title="Edit Pickup">
            <i data-feather="edit"></i>
        </a>

        <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
            data-bs-toggle="tooltip" title="Delete" href="#">
            <i data-feather="trash-2"></i>
        </a>

        <?php echo Form::close(); ?>

    </div>
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
    // Handle pickup form submission via AJAX
    $(document).on('submit', '#pickupEditForm', function (e) {
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
                    toastr.success(response.message || 'Pickup updated.');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
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

    // Tooltip reinitialization for modal elements
    $(document).on('shown.bs.modal', function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    // ✅ DataTable with pagination length dropdown
    $(function () {
        let table = $('#deliveriesTable');

        if ($.fn.DataTable.isDataTable(table)) {
            table.DataTable().destroy();
        }

        table.DataTable({
            dom: 'lBfrtip', // 'l' shows entries dropdown
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            buttons: [
                { extend: 'copyHtml5', className: 'btn btn-sm btn-light', exportOptions: { columns: ':visible' } },
                { extend: 'excelHtml5', className: 'btn btn-sm btn-light', exportOptions: { columns: ':visible' } },
                { extend: 'pdfHtml5', className: 'btn btn-sm btn-light', exportOptions: { columns: ':visible' } },
                { extend: 'colvis', className: 'btn btn-sm btn-light' }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search deliveries..."
            },
            responsive: true,
            order: [[0, 'desc']]
        });

        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/pickups/index.blade.php ENDPATH**/ ?>