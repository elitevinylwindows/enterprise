

<?php $__env->startSection('page-title'); ?>
    Raffle Draw
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Raffle Draw</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-2 mb-4">
        <form action="<?php echo e(route('executives.raffle.start')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-primary w-100">🎉 Start Raffle</button>
        </form>
    </div>
    <div class="col-md-2 mb-4">
        <form action="<?php echo e(route('executives.raffle.reset')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-primary w-100">♻️ Reset</button>
        </form>
    </div>
</div>

<?php if(session('raffle_winner')): ?>
    <?php $winner = session('raffle_winner'); ?>

    <div class="card border-success">
        <div class="card-header bg-success text-white">
            🎊 Raffle Winner
        </div>
        <div class="card-body">
            <h5 class="card-title"><?php echo e($winner->name); ?></h5>
            <p class="card-text">
                <strong>Customer #:</strong> <?php echo e($winner->customer_number ?? '—'); ?><br>
                <strong>Tier:</strong> <?php echo e($winner->tier ?? '—'); ?><br>
                <strong>Total Spent:</strong> $<?php echo e(number_format($winner->total_spent ?? 0, 2)); ?>

            </p>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/executives/raffle/index.blade.php ENDPATH**/ ?>