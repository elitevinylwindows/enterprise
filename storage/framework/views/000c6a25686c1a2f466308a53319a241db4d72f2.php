<div class="modal-header">
    <h5 class="modal-title">Purchase Request: <?php echo e($request->purchase_request_id); ?></h5>
    <a href="<?php echo e(route('purchasing.purchase-requests.download', $request->id)); ?>" class="btn btn-sm btn-primary ms-auto">
        <i class="fa fa-download"></i> Download PDF
    </a>
</div>

<div class="modal-body">
    <p><strong>Requested By:</strong> <?php echo e($request->requested_by); ?></p>
    <p><strong>Department:</strong> <?php echo e($request->department); ?></p>

    <?php
        $firstProduct = $request->items->first()->product ?? null;
    ?>
    <p><strong>Supplier:</strong> <?php echo e($firstProduct?->supplier->name ?? 'N/A'); ?></p>

    <p><strong>Request Date:</strong> <?php echo e(\Carbon\Carbon::parse($request->request_date)->format('M d, Y')); ?></p>
    <p><strong>Expected Date:</strong> <?php echo e(\Carbon\Carbon::parse($request->expected_date)->format('M d, Y')); ?></p>

    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $request->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($item->product->name ?? 'N/A'); ?></td>
                        <td><?php echo e($item->product->description ?? '-'); ?></td>
                        <td><?php echo e($item->qty); ?></td>
                        <td>$<?php echo e(number_format($item->price, 2)); ?></td>
                        <td>$<?php echo e(number_format($item->total, 2)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/purchasing/purchase_requests/show.blade.php ENDPATH**/ ?>