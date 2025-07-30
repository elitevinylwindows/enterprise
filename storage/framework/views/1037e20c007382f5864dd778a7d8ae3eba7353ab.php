

<?php $__env->startSection('page-title', 'My Route'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">My Route</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <?php $__empty_1 = true; $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="row mt-4">
            <div class="col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header text-white" style="background-color: #A80000;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Truck: <?php echo e($route['truck_number']); ?></strong><br>
                                Driver: <?php echo e($route['driver'] ?? 'N/A'); ?>

                                
                            </div>
                             <a href="<?php echo e(route('routes.pdf', ['truck' => $route['truck_number'], 'date' => $date])); ?>"
                                           class="btn btn-sm btn-white text-white"
                                           target="_blank" title="Show Route PDF">
                                            <i data-feather="eye"></i>
                                        </a>
                            <a href="#" class="btn btn-sm btn-outline-light text-white"
                           onclick='openGoogleRoute("<?php echo e(addslashes($warehouseAddress)); ?>", <?php echo json_encode(array_map(fn($s) => $s["address"] . ", " . $s["city"], $route["stops"])); ?>)'>
                            Start Route
                        </a>
                        </div>
                    </div>

                    <div class="card-body overflow-auto" style="max-height: 350px;">
                        <ol class="list-group list-group-numbered">
                            <li class="list-group-item static-stop">Base: <?php echo e($warehouseAddress); ?></li>

                            <?php $__currentLoopData = $route['stops']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $idsKey = implode('-', $stop['ids']);
                                ?>
                                <li class="list-group-item" data-ids="<?php echo e(implode(',', $stop['ids'])); ?>">
                                    <div class="fw-bold mb-2">
                                        <?php echo e($stop['label'] ?? $loop->iteration); ?> - <?php echo e($stop['customer']); ?>

                                    </div>

                                    <div>
                                        <?php echo e($stop['address']); ?>, <?php echo e($stop['city']); ?><br>
                                        <?php echo e($stop['contact'] ?? ''); ?><br>
                                        Orders: <?php echo e($stop['order'] ?? 'N/A'); ?><br>
                                        <span class="badge stop-status"
                                              id="status-badge-<?php echo e($idsKey); ?>"
                                              style="background-color: <?php echo e(($stop['status'] ?? 'pending') === 'delivered' ? '#198754' : (($stop['status'] ?? 'pending') === 'cancelled' ? '#dc3545' : '#0dcaf0')); ?>">
                                            <?php echo e(ucfirst($stop['status'] ?? 'Pending')); ?>

                                        </span>
                                    </div>

                                    <div class="d-flex mt-2 align-items-center gap-2">
                                        <a href="https://www.google.com/maps/dir/?api=1&origin=<?php echo e(urlencode($warehouseAddress)); ?>&destination=<?php echo e(urlencode($stop['address'])); ?>"
                                           target="_blank" class="btn btn-sm text-white" style="background-color:#A80000;">Go</a>

                                        <?php if($stop['contact']): ?>
                                            <a href="tel:<?php echo e($stop['contact']); ?>" class="btn btn-sm text-white" style="background-color:#A80000;" title="Call">
                                                <i class="ti ti-phone"></i>
                                            </a>
                                        <?php endif; ?>

                                        <button type="button" class="btn btn-sm btn-secondary open-status" data-stop="<?php echo e($idsKey); ?>">
                                            Update Status
                                        </button>
                                    </div>



                                    
                                    <div class="status-options mt-3 d-none" id="status-panel-<?php echo e($idsKey); ?>">
                                        <p class="fw-bold">Mark Status:</p>
                                        <button class="btn btn-sm btn-success delivered-btn" data-stop="<?php echo e($idsKey); ?>">Delivered</button>
                                        <button class="btn btn-sm btn-danger cancelled-btn" data-stop="<?php echo e($idsKey); ?>">Cancelled</button>

                                        <div class="delivered-form d-none mt-2" id="delivered-form-<?php echo e($idsKey); ?>">
                                            <label class="me-2"><input type="radio" name="payment_method_<?php echo e($idsKey); ?>" value="cash"> Cash</label>
                                            <label class="me-2"><input type="radio" name="payment_method_<?php echo e($idsKey); ?>" value="check"> Check</label>
                                            <label class="me-2"><input type="radio" name="payment_method_<?php echo e($idsKey); ?>" value="card"> Card</label>
                                            <label class="me-2"><input type="radio" name="payment_method_<?php echo e($idsKey); ?>" value="transfer"> Transfer</label>

                                            <input type="number" class="form-control mt-2 d-none" placeholder="Amount" id="amount-<?php echo e($idsKey); ?>">
                                            <textarea class="form-control mt-2" placeholder="Delivery Note" id="delivery-note-<?php echo e($idsKey); ?>"></textarea>
                                            <button class="btn btn-sm btn-primary mt-2 submit-delivery" data-stop="<?php echo e($idsKey); ?>">Submit</button>
                                        </div>

                                        <div class="cancelled-form d-none mt-2" id="cancelled-form-<?php echo e($idsKey); ?>">
                                            <textarea class="form-control" placeholder="Cancellation Note" id="cancel-note-<?php echo e($idsKey); ?>"></textarea>
                                            <button class="btn btn-sm btn-danger mt-2 submit-cancelled" data-stop="<?php echo e($idsKey); ?>">Submit</button>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <li class="list-group-item">Return: <?php echo e($warehouseAddress); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="alert alert-info">No assigned routes for you.</div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle panel
    document.querySelectorAll('.open-status').forEach(btn => {
        btn.addEventListener('click', function () {
            const stopId = this.dataset.stop;
            document.getElementById(`status-panel-${stopId}`).classList.toggle('d-none');
        });
    });

    // Show Delivered form
    document.querySelectorAll('.delivered-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const stopId = this.dataset.stop;
            document.getElementById(`delivered-form-${stopId}`).classList.remove('d-none');
            document.getElementById(`cancelled-form-${stopId}`).classList.add('d-none');
        });
    });

    // Show Cancelled form
    document.querySelectorAll('.cancelled-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const stopId = this.dataset.stop;
            document.getElementById(`cancelled-form-${stopId}`).classList.remove('d-none');
            document.getElementById(`delivered-form-${stopId}`).classList.add('d-none');
        });
    });

    // Handle Delivered Submit
   // Handle Delivered Submit
document.querySelectorAll('.submit-delivery').forEach(btn => {
    btn.addEventListener('click', function () {
        const stopId = this.dataset.stop;
        const ids = stopId.split('-');
        const method = document.querySelector(`input[name="payment_method_${stopId}"]:checked`);
        const amount = document.getElementById(`amount-${stopId}`).value;
        const note = document.getElementById(`delivery-note-${stopId}`).value; // fixed line

        if (!method) return alert('Select a payment method.');
        if (['cash', 'check'].includes(method.value) && (!amount || isNaN(amount))) {
            return alert('Enter a valid amount.');
        }

        fetch(`<?php echo e(route('route.updateStatus')); ?>`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            },
            body: JSON.stringify({
                stop_id: ids,
                status: 'delivered',
                payment_status: 'paid',
                payment_method: method.value,
                payment_amount: amount,
                note: note,
            })
        }).then(res => res.ok ? res.json() : Promise.reject())
          .then(() => {
              const badge = document.getElementById(`status-badge-${stopId}`);
              badge.textContent = 'Delivered';
              badge.className = 'badge bg-success stop-status';
              document.getElementById(`status-panel-${stopId}`).classList.add('d-none');
              toastr.success('Marked as Delivered');
          }).catch(() => toastr.error('Failed to update'));
    });
});


    // Handle Cancelled Submit
    document.querySelectorAll('.submit-cancelled').forEach(btn => {
        btn.addEventListener('click', function () {
            const stopId = this.dataset.stop;
            const ids = stopId.split('-');
            const note = document.getElementById(`cancel-note-${stopId}`).value;

            if (!note.trim()) return alert('Enter a cancellation note.');

            fetch(`<?php echo e(route('route.updateStatus')); ?>`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                },
                body: JSON.stringify({
                    stop_id: ids,
                    status: 'cancelled',
                    note: note,
                })
            }).then(res => res.ok ? res.json() : Promise.reject())
              .then(() => {
                  const badge = document.getElementById(`status-badge-${stopId}`);
                  badge.textContent = 'Cancelled';
                  badge.className = 'badge bg-danger stop-status';
                  document.getElementById(`status-panel-${stopId}`).classList.add('d-none');
                  toastr.warning('Marked as Cancelled');
              }).catch(() => toastr.error('Failed to update'));
        });
    });

    // Show amount if cash/check is selected
    document.querySelectorAll('input[type=radio][name^="payment_method_"]').forEach(radio => {
        radio.addEventListener('change', function () {
            const stopId = this.name.replace('payment_method_', '');
            const method = this.value;
            const amountInput = document.getElementById(`amount-${stopId}`);

            if (['cash', 'check'].includes(method)) {
                amountInput.classList.remove('d-none');
            } else {
                amountInput.classList.add('d-none');
                amountInput.value = '';
            }
        });
    });
});
function openGoogleRoute(origin, stops) {
    if (!Array.isArray(stops) || stops.length === 0) return;

    let baseUrl = "https://www.google.com/maps/dir/?api=1";
    let destination = encodeURIComponent(origin); // Return to warehouse
    let allStops = [...stops, origin]; // Include return in stops

    let waypoints = allStops.map(encodeURIComponent).join('|');

    let url = `${baseUrl}&origin=${encodeURIComponent(origin)}&destination=${destination}&travelmode=driving&waypoints=${waypoints}`;

    window.open(url, '_blank');
}


</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/routes/driver.blade.php ENDPATH**/ ?>