

<?php
    $title = 'Configuration Library';
    $subTitle = 'Organise Configurations by Series';
    $seriesList = $seriesList ?? [];
?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Master')); ?></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Series')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card mb-5">
            <div class="card-header">
                <h5><?php echo e(__('Configuration Library')); ?></h5>
            </div>

            <div class="card-body">
                <?php if(empty($seriesList)): ?>
                    <p class="text-muted">No series folders available.</p>
                <?php endif; ?>

                <div class="row g-3 px-3 mb-6">
                    <?php $__currentLoopData = $seriesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seriesName => $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-3">
                            <div class="card text-center shadow-sm series-folder" style="cursor:pointer;" data-series="<?php echo e($seriesName); ?>">
                                <div class="card-body">
                                    <i class="fas fa-folder fa-2x text-warning mb-2"></i>
                                    <h6 class="mb-0"><?php echo e($seriesName); ?></h6>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="card mt-4 d-none" id="configArea">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 id="selectedSeriesTitle">Configurations</h5>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">+ Add Category</button>
                    </div>
                    <div class="card-body px-4" id="seriesDetailsContainer">
                        <!-- Series images & accordions load here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteImageModal" tabindex="-1" aria-labelledby="deleteImageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteImageModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this configuration image?
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Zoom/Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <img id="quickViewImage" src="" alt="Zoom View" class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="" id="addCategoryForm">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="series" id="selectedSeriesInput">
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="category_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteImageModal" tabindex="-1" aria-labelledby="deleteImageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteImageModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this configuration image?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.querySelectorAll('.series-folder').forEach(folder => {
    folder.addEventListener('click', function () {
        const series = this.getAttribute('data-series');
        const encoded = encodeURIComponent(series);

        // Set heading and input
        document.getElementById('selectedSeriesTitle').innerText = `Configurations for: ${series}`;
        document.getElementById('selectedSeriesInput').value = series;
        document.getElementById('addCategoryForm').action = `/master/library/configurations/${encoded}/add-category`;

        // Show config area
        document.getElementById('configArea').classList.remove('d-none');

        // Fetch accordion content
        fetch(`/master/library/configurations/${encoded}`)
            .then(res => res.ok ? res.text() : Promise.reject('Failed to load series folder.'))
            .then(html => {
                document.getElementById('seriesDetailsContainer').innerHTML = html;
            })
            .catch(err => {
                document.getElementById('seriesDetailsContainer').innerHTML = `<p class="text-danger">${err}</p>`;
            });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/master/library/configurations/index.blade.php ENDPATH**/ ?>