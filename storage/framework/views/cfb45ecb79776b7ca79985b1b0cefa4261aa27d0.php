<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Transaction')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Transaction')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Pricing Package Transaction List')); ?></h5>
                        </div>

                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('User')); ?></th>
                                    <th><?php echo e(__('Date')); ?></th>
                                    <th><?php echo e(__('Subscription')); ?></th>
                                    <th><?php echo e(__('Amount')); ?></th>
                                    <th><?php echo e(__('Payment Type')); ?></th>
                                    <th><?php echo e(__('Payment Status')); ?></th>
                                    <th><?php echo e(__('Receipt')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(!empty($transaction->users)?$transaction->users->name:''); ?></td>
                                <td><?php echo e(dateFormat($transaction->created_at)); ?></td>
                                <td><?php echo e(!empty($transaction->subscriptions)?$transaction->subscriptions->title:'-'); ?></td>
                                <td><?php echo e($settings['CURRENCY_SYMBOL'].$transaction->amount); ?></td>
                                <td><?php echo e($transaction->payment_type); ?></td>
                                <td>
                                    <?php if($transaction->payment_status=='Pending'): ?>
                                        <span
                                            class="d-inline badge text-bg-warning"><?php echo e($transaction->payment_status); ?></span>
                                    <?php elseif($transaction->payment_status=='succeeded' || $transaction->payment_status=='Success'): ?>
                                        <span
                                            class="d-inline badge text-bg-success"><?php echo e($transaction->payment_status); ?></span>
                                    <?php else: ?>
                                        <span
                                            class="d-inline badge text-bg-danger"><?php echo e($transaction->payment_status); ?></span>
                                    <?php endif; ?>


                                </td>
                                <td>
                                    <?php if($transaction->payment_type=='Stripe'): ?>
                                        <a class="avtar avtar-xs btn-link-primary text-primary" data-bs-toggle="tooltip" target="_blank"
                                           data-bs-original-title="<?php echo e(__('Receipt')); ?>" href="<?php echo e($transaction->receipt); ?>">
                                            <i data-feather="file"></i></a>
                                    <?php elseif($transaction->payment_type=='Bank Transfer'): ?>
                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['subscription.bank.transfer.action', [$transaction->id,'accept']]]); ?>


                                        <a class="avtar avtar-xs btn-link-primary text-primary" data-bs-toggle="tooltip" target="_blank"
                                           data-bs-original-title="<?php echo e(__('Receipt')); ?>"
                                           href="<?php echo e(asset('/storage/upload/payment_receipt/'.$transaction->receipt)); ?>">
                                            <i data-feather="file"></i></a>

                                        <?php if(\Auth::user()->type=='super admin' && $transaction->payment_status=='Pending'): ?>
                                            <a class="avtar avtar-xs btn-link-success text-success" data-bs-toggle="tooltip"
                                               data-bs-original-title="<?php echo e(__('Accept')); ?>"
                                               href="<?php echo e(route('subscription.bank.transfer.action', [$transaction->id,'accept'])); ?>">
                                                <i data-feather="user-check"></i></a>

                                            <a class="avtar avtar-xs btn-link-danger text-danger" data-bs-toggle="tooltip"
                                               data-bs-original-title="<?php echo e(__('Reject')); ?>"
                                               href="<?php echo e(route('subscription.bank.transfer.action', [$transaction->id,'reject'])); ?>">
                                                <i data-feather="user-x"></i></a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/subscription/transaction.blade.php ENDPATH**/ ?>