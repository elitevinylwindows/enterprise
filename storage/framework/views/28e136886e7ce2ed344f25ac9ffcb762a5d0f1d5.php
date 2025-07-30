<?php $__env->startSection('page-title', 'Tiers & Benefits'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-3 mt-4 d-flex justify-content-between align-items-center">
    <input type="text" class="form-control w-50" placeholder="Search tiers...">
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addTierModal">
        <i class="ti ti-plus"></i> Add Tier
    </button>
</div>

<div class="row">
    <?php $__empty_1 = true; $__currentLoopData = $tiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-3 mb-4">
            <div class="flip-card h-100">
                <div class="flip-card-inner">
                    
                    <div class="flip-card-front card text-center p-3 d-flex flex-column justify-content-center">
                        <h5 class="fw-bold mb-0"><?php echo e($tier->name); ?></h5>
                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editTierModal-<?php echo e($tier->id); ?>">
                            <i class="ti ti-pencil"></i>
                        </button>
                    </div>

                    
                    <div class="flip-card-back card p-3 d-flex flex-column justify-content-center">
                        <h6 class="text-muted text-center">Benefits</h6>
                        <div class="text-center">
                            <?php echo nl2br(e($tier->benefits)); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <?php echo $__env->make('executives.tiers.edit', ['tier' => $tier], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-muted">No tiers added yet.</p>
    <?php endif; ?>
</div>


<?php echo $__env->make('executives.tiers.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.flip-card {
    background-color: transparent;
    perspective: 1000px;
    height: 300px;
    position: relative;
}
.flip-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transition: transform 0.6s;
    transform-style: preserve-3d;
}
.flip-card:hover .flip-card-inner {
    transform: rotateY(180deg);
}
.flip-card-front, .flip-card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    border-radius: 0.75rem;
}
.flip-card-front {
    background-color: #fff;
    z-index: 2;
}
.flip-card-back {
    background-color: #f8f9fa;
    transform: rotateY(180deg);
    z-index: 1;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/executives/tiers/index.blade.php ENDPATH**/ ?>