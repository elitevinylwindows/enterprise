

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('BOM')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"><?php echo e(__('BOM')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
<form action="<?php echo e(route('inventory.bom.import')); ?>" method="POST" enctype="multipart/form-data" class="d-inline-block">
    <?php echo csrf_field(); ?>
    <input type="file" name="import_file" accept=".csv, .xls, .xlsx" required class="form-control d-inline-block w-auto">
    <button type="submit" class="btn btn-sm btn-primary">
        <i data-feather="upload"></i> Import BOM
    </button>
    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
    <i class="ti ti-plus"></i> <?php echo e(__('Add Material')); ?>

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
                        <h5><?php echo e(__('BOM')); ?></h5>
                    </div>
                                           <div class="col-auto">

            </div>
              </div>
            </div>
      <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="bomsTable">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Material Name</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Vendor</th>
                    <th>Price</th>
                    <th>Sold By</th>
                    <th>L in/Each Pcs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $boms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><input type="checkbox" class="bom-checkbox" value="<?php echo e($bom->id); ?>"></td>
            <td><?php echo e($bom->material_name); ?></td>
            <td><?php echo e($bom->description); ?></td>
            <td><?php echo e($bom->unit); ?></td>
            <td><?php echo e($bom->vendor); ?></td>
            <td>$<?php echo e(number_format($bom->price, 2)); ?></td>
            <td><?php echo e($bom->sold_by); ?></td>
            <td><?php echo e($bom->lin_pcs); ?></td>
            <td>
                <a href="<?php echo e(route('inventory.bom.edit', $bom->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                <form action="<?php echo e(route('inventory.bom.destroy', $bom->id)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-sm btn-primary" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>

<!-- Add Material Modal -->
<div class="modal fade" id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMaterialLabel">Add Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php echo $__env->make('inventory.bom.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
        </div>
    </div>
</div>


<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('select-all').addEventListener('click', function() {
        let checked = this.checked;
        document.querySelectorAll('.bom-checkbox').forEach(cb => cb.checked = checked);
    });

    $(document).on('click', '.customModal', function (e) {
        e.preventDefault();

        const url = $(this).data('url');
        const title = $(this).data('title') || 'Modal';
        const size = $(this).data('size') || 'md';

        $('#mainModal .modal-dialog').removeClass('modal-sm modal-md modal-lg modal-xl').addClass('modal-' + size);
        $('#mainModal .modal-title').text(title);
        $('#mainModal .modal-body').html('<div class="text-center p-5"><i class="ti ti-loader ti-spin"></i> Loading...</div>');

        $('#mainModal').modal('show');

        $.get(url, function (data) {
            $('#mainModal .modal-body').html(data);
        }).fail(function () {
            $('#mainModal .modal-body').html('<div class="alert alert-danger">Failed to load content.</div>');
        });
    });
    
</script>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/inventory/bom/index.blade.php ENDPATH**/ ?>