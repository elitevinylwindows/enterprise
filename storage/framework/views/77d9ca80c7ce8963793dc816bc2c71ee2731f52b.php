

<?php $__env->startSection('page-title'); ?>
    Price Matrix
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Price Matrix</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
    <i data-feather="upload"></i> Import
</button>

<button class="btn btn-sm btn-secondary ms-2" data-bs-toggle="modal" data-bs-target="#checkPriceModal">
    <i data-feather="search"></i> Check Price
</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form method="GET" class="row align-items-end g-3 mb-4">
    <div class="col-md-3">
        <label for="filterSeries" class="form-label">Series</label>
        <select name="series" id="filterSeries" class="form-select" required>
            <option value="">All Series</option>
            <?php $__currentLoopData = $seriesForModal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s->id); ?>" <?php echo e(request('series') == $s->id ? 'selected' : ''); ?>><?php echo e($s->series); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="col-md-3">
        <label for="filterSeriesType" class="form-label">Series Type</label>
        <select name="series_type_id" id="filterSeriesType" class="form-select" required>
            <option value="">Select Series Type</option>
        </select>
    </div>

    <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<?php if(request('series') && request('series_type_id')): ?>
<div class="card shadow-sm mt-3">
    <div class="card-body table-responsive" style="max-height: 600px; overflow: auto;">
        <table class="table table-bordered table-hover">
            <thead class="table-light sticky-top" style="top: 0; z-index: 1;">
                <tr>
                    <th class="bg-light">Height \ Width</th>
                    <?php $__currentLoopData = $widths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th class="bg-light"><?php echo e($w); ?></th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $heights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th class="bg-light position-sticky start-0" style="z-index: 1;"><?php echo e($h); ?></th>
                        <?php $__currentLoopData = $widths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $price = $prices->where('width', $w)->where('height', $h)->first();
                            ?>
                            <td><?php echo e($price ? number_format($price->price, 2) : '-'); ?></td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>


<div class="modal fade" id="checkPriceModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="<?php echo e(route('master.prices.matrice.check')); ?>" id="checkPriceForm" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title">Check Price</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Series</label>
                    <select name="series_id" id="checkSeries" class="form-select" required>
                        <?php $__currentLoopData = $seriesForModal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s->id); ?>"><?php echo e($s->series); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Series Type</label>
                    <select name="series_type_id" id="checkSeriesType" class="form-select" required>
                        <option value="">Select Series Type</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Width</label>
                        <input type="number" name="width" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Height</label>
                        <input type="number" name="height" class="form-control" required>
                    </div>
                </div>

                <div class="mt-3" id="checkPriceResult" style="display: none;">
                    <strong>Price:</strong> <span id="priceOutput"></span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="checkPriceBtn">Check</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?php echo e(route('master.prices.matrice.import')); ?>" method="POST" enctype="multipart/form-data" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title">Import Price Matrix</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label>Series</label>
                    <select name="series_id" id="importSeries" class="form-select" required>
                        <?php $__currentLoopData = $seriesForModal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s->id); ?>"><?php echo e($s->series); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Series Type</label>
                    <select name="series_type_id" id="importSeriesType" class="form-select" required>
                        <option value="">Select Series Type</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Select File</label>
                    <input type="file" name="import_file" class="form-control" accept=".csv,.xls,.xlsx" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('checkPriceBtn').addEventListener('click', function () {
    const form = document.getElementById('checkPriceForm');

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            series_id: form.querySelector('#checkSeries').value,
            series_type_id: form.querySelector('#checkSeriesType').value,
            width: form.querySelector('[name="width"]').value,
            height: form.querySelector('[name="height"]').value
        })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('priceOutput').textContent = `$${data.price ?? 'Not found'}`;
        document.getElementById('checkPriceResult').style.display = 'block';
    })
    .catch(() => {
        document.getElementById('priceOutput').textContent = 'Error';
        document.getElementById('checkPriceResult').style.display = 'block';
    });
});
</script>

<script>
function setupSeriesToTypeDropdown(seriesId, typeId) {
    $(`#${seriesId}`).on('change', function () {
        const seriesID = $(this).val();
        $(`#${typeId}`).html('<option value="">Loading...</option>');

        if (seriesID) {
            fetch(`/master/prices/matrice/types/${seriesID}`)
                .then(res => res.json())
                .then(data => {
                    let options = '<option value="">Select Series Type</option>';
                    data.forEach(item => {
                        options += `<option value="${item.id}">${item.series_type}</option>`;
                    });
                    $(`#${typeId}`).html(options);
                })
                .catch(() => {
                    $(`#${typeId}`).html('<option value="">Failed to load</option>');
                });
        }
    });
}

setupSeriesToTypeDropdown('filterSeries', 'filterSeriesType');
setupSeriesToTypeDropdown('importSeries', 'importSeriesType');
setupSeriesToTypeDropdown('checkSeries', 'checkSeriesType');
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/master/prices/matrice/index.blade.php ENDPATH**/ ?>