<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Cart Allocation')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Carts')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
    <?php if(Gate::check('manage carts')): ?>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#startScanModal">
                    <i class="ti ti-scan"></i> <?php echo e(__('Start Scanning')); ?>

                </button>
            <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card table-card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th></th> <!-- Toggle column -->
                            <th>Cart Number</th>
                            <th>Order #</th>
                            <th>Customer Name</th>
                            <th>Barcode</th>
                            <th>Width</th>
                            <th>Height</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cartBarcode => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php $firstItem = $items->first(); ?>
                            <tr data-bs-toggle="collapse" data-bs-target="#cart-<?php echo e($loop->index); ?>" aria-expanded="false" class="cursor-pointer">
                                <td class="text-center align-middle">
                                    <i class="ti ti-plus"></i>
                                </td>
                                <td><?php echo e($firstItem->cart_barcode); ?></td>
                                <td><?php echo e($firstItem->order_number); ?></td>
                                <td><?php echo e($firstItem->customer_short_name); ?></td>
                                <td><?php echo e($firstItem->production_barcode); ?></td>
                                <td><?php echo e($firstItem->width); ?></td>
                                <td><?php echo e($firstItem->height); ?></td>
                                <td><?php echo e($firstItem->comment); ?></td>
                                <td>
                                    <a href="#"
                                        class="btn btn-sm btn-primary edit-cart-btn"
                                        data-cart-barcode="<?php echo e($firstItem->cart_barcode); ?>"
                                        data-items='<?php echo json_encode($items, 15, 512) ?>'
                                        data-update-url="<?php echo e(route('cart.update', ['cart_barcode' => $firstItem->cart_barcode])); ?>">
                                        Edit
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger delete-cart-btn">Delete</a>
                                </td>
                            </tr>
                            <tr class="collapse bg-light" id="cart-<?php echo e($loop->index); ?>">
                                <td colspan="9">
                                    <strong>Items in this Cart:</strong>
                                    <table class="table table-sm table-bordered mt-2">
                                        <thead>
                                            <tr>
                                                <th>Barcode</th>
                                                <th>Description</th>
                                                <th>Width</th>
                                                <th>Height</th>
                                                <th>Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($item->production_barcode); ?></td>
                                                    <td><?php echo e($item->description); ?></td>
                                                    <td><?php echo e($item->width); ?></td>
                                                    <td><?php echo e($item->height); ?></td>
                                                    <td><?php echo e($item->comment); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center">No carts found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('cart._scan_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('cart._edit_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script>
    document.querySelectorAll('.edit-cart-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const cartBarcode = this.getAttribute('data-cart-barcode');
            const items = JSON.parse(this.getAttribute('data-items'));
            const actionUrl = this.getAttribute('data-update-url');

            openEditModal(cartBarcode, items, actionUrl);
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/cart/index.blade.php ENDPATH**/ ?>