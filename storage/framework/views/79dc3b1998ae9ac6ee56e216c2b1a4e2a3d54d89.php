<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Locations')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Locations')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
<form action="<?php echo e(route('cims.import')); ?>" method="POST" enctype="multipart/form-data" class="d-inline-block">
    <?php echo csrf_field(); ?>
    <input type="file" name="import_file" accept=".csv, .xls, .xlsx" required class="form-control d-inline-block w-auto">
    <button type="submit" class="btn btn-sm btn-primary">
        <i data-feather="upload"></i> Import Locations
    </button>
</form>

     <!-- <a class="btn btn-outline-primary btn-sm" href="<?php echo e(route('cims.import')); ?>">
        <i class="ti ti-upload"></i> <?php echo e(__('Import cims')); ?>

    </a>
  <a class="btn btn-outline-success btn-sm" href="<?php echo e(route('cims.create')); ?>">
        <i class="ti ti-plus"></i> <?php echo e(__('Add cim')); ?>

    </a>-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5><?php echo e(__('Locations')); ?></h5>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="cimsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order #</th>
                                <th>Cart #</th>
                                <th>Production Barcode</th>
                                <th>Customer</th>
                                <th>Customer Name</th>
                                <th>Short Name</th>
                                <th>Description</th>
                                <th>Comment</th>
                                <th>Width</th>
                                <th>Height</th>
                             <!--    <th>Action</th>-->
                              
                       
                           
                             
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $cims; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cim): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($cim->order_number); ?></td>
                                    <td><?php echo e($cim->cart_barcode); ?></td>
                                    <td><?php echo e($cim->production_barcode); ?></td>
                                    <td><?php echo e($cim->customer); ?></td>
                                    <td><?php echo e($cim->customer_name); ?></td>
                                    <td><?php echo e($cim->customer_short_name); ?></td>
                                    <td><?php echo e($cim->description); ?></td>
                                    <td><?php echo e($cim->comment); ?></td>
                                    <td><?php echo e($cim->width); ?></td>
                                    <td><?php echo e($cim->height); ?></td>
                                   
                                
                                  <!--  <td>
                                        <div class="cart-action">
                                            <a class="avtar avtar-xs btn-link-warning text-warning customModal"
                                                data-bs-toggle="tooltip" title="<?php echo e(__('Details')); ?>" href="#"
                                                data-size="lg" data-url="<?php echo e(route('cims.show', $cim->id)); ?>"
                                                data-title="<?php echo e(__('CIM Details')); ?>">
                                                <i data-feather="eye"></i>
                                            </a>
                                            <a class="avtar avtar-xs btn-link-secondary text-secondary customModal"
                                                data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>" href="#"
                                                data-size="lg" data-url="<?php echo e(route('cims.edit', $cim->id)); ?>"
                                                data-title="<?php echo e(__('Edit cim')); ?>">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
                                                data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>"
                                                data-url="<?php echo e(route('cims.destroy', $cim->id)); ?>"
                                                data-confirm="<?php echo e(__('Are you sure?')); ?>">
                                                <i data-feather="trash-2"></i>
                                            </a>
                                        </div>
                                    </td>-->
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
   // Custom Modal Loader
    $(document).on('click', '.customModal', function (e) {
        e.preventDefault();
        let url = $(this).data('url');
        let title = $(this).data('title');
        let size = $(this).data('size') ?? 'md';

        $.ajax({
            url: url,
            success: function (response) {
                $('#commonModal .modal-title').text(title);
                $('#commonModal .modal-body').html(response);
                $('#commonModal .modal-dialog')
                    .removeClass('modal-sm modal-md modal-lg modal-xl')
                    .addClass('modal-' + size);
                $('#commonModal').modal('show');
            },
            error: function () {
                alert('Failed to load modal.');
            }
        });
    });

</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/cims/index.blade.php ENDPATH**/ ?>