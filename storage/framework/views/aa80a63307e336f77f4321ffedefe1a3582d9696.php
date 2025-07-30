<?php $__env->startSection('page-title', 'Formulas'); ?>

<?php $__env->startSection('content'); ?>
<div class="card mt-4">
    <div class="card-body">
        <h5 class="mb-4">Tier Formula Settings</h5>

        <?php
            $rows = [
                'master_data' => 'Master Data Percentage',
                'tier_1' => 'Tier 1 %',
                'tier_2' => 'Tier 2 %',
                'tier_3' => 'Tier 3 %',
                'vip' => 'VIP %'
            ];
        ?>

        <form method="POST" action="<?php echo e(route('executives.formulas.update')); ?>">
            <?php echo csrf_field(); ?>

            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="row align-items-center mb-3">
                <div class="col-md-4">
                    <label class="form-label mb-0"><?php echo e($label); ?></label>
                </div>

                <div class="col-md-4 d-flex align-items-center gap-2">
                    <input type="number" name="formulas[<?php echo e($key); ?>]" 
                           class="form-control formula-input" 
                           id="input-<?php echo e($key); ?>" 
                           step="0.01" 
                           value="<?php echo e($formulas[$key] ?? ''); ?>" 
                           placeholder="Enter %">

                    <button type="submit" class="btn btn-primary" title="Save">
                        <i class="ti ti-check"></i>
                    </button>

                    <button type="button" class="btn btn-primary lock-btn" 
                            data-target="input-<?php echo e($key); ?>" title="Lock/Unlock">
                        <i class="ti ti-lock"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.querySelectorAll('.lock-btn').forEach(button => {
    button.addEventListener('click', function () {
        const inputId = this.dataset.target;
        const input = document.getElementById(inputId);

        if (input.hasAttribute('readonly')) {
            input.removeAttribute('readonly');
            this.innerHTML = '<i class="ti ti-lock"></i>';
        } else {
            input.setAttribute('readonly', true);
            this.innerHTML = '<i class="ti ti-lock-open"></i>';
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/executives/formulas/index.blade.php ENDPATH**/ ?>