<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Packages')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Packages')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Pricing Packages List')); ?></h5>
                        </div>
                        <?php if(
                            \Auth::user()->type == 'super admin' &&
                                (subscriptionPaymentSettings()['STRIPE_PAYMENT'] == 'on' ||
                                    subscriptionPaymentSettings()['paypal_payment'] == 'on' ||
                                    subscriptionPaymentSettings()['bank_transfer_payment'] == 'on')): ?>
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="md"
                                    data-url="<?php echo e(route('subscriptions.create')); ?>" data-title="<?php echo e(__('Create Package')); ?>">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> <?php echo e(__('Create Package')); ?>

                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="price-card2">
                        <?php
                            $features = [
                                __('User Limit'),
                                __('Visitor Pre Register'),
                                __('Enabled Logged History'),
                                __('Coupon Applicable'),
                            ];
                        ?>
                        <table class="table table-striped m-0">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Features')); ?></th>
                                    <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th>
                                            <div class="card-body border-start text-center py-5 py-md-5">
                                                <h3 class="text-primary"><b> <?php echo e($subscription->title); ?></b></h3>
                                                <h3 class="text-muted mb-0 mt-5">
                                                    <b>
                                                        <sup><?php echo e(subscriptionPaymentSettings()['CURRENCY_SYMBOL']); ?></sup>
                                                        <?php echo e($subscription->package_amount); ?>

                                                        <span>/<?php echo e($subscription->interval); ?></span>
                                                    </b>
                                                </h3>
                                            </div>
                                        </th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(__($feature)); ?></td>
                                        <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="text-center">
                                                <?php switch($feature):
                                                    case (__('User Limit')): ?>
                                                        <?php echo e($subscription->user_limit); ?>

                                                    <?php break; ?>

                                                    <?php case (__('Visitor Pre Register')): ?>
                                                        <?php if($subscription->enabled_pre_register == 1): ?>
                                                            <div class="bg-success text-white avtar avtar-xs icon">
                                                                <i class="ti ti-check f-20"></i>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="bg-danger text-white avtar avtar-xs icon">
                                                                <i class="ti ti-x f-20"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php break; ?>

                                                    <?php case (__('Enabled Logged History')): ?>
                                                        <?php if($subscription->enabled_logged_history): ?>
                                                            <div class="bg-success text-white avtar avtar-xs icon">
                                                                <i class="ti ti-check f-20"></i>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="bg-danger text-white avtar avtar-xs icon">
                                                                <i class="ti ti-x f-20"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php break; ?>

                                                    <?php case (__('Coupon Applicable')): ?>
                                                        <?php if($subscription->couponCheck() > 0): ?>
                                                            <div class="bg-success text-white avtar avtar-xs icon">
                                                                <i class="ti ti-check f-20"></i>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="bg-danger text-white avtar avtar-xs icon">
                                                                <i class="ti ti-x f-20"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php break; ?>
                                                <?php endswitch; ?>
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-center">
                                            <?php if(\Auth::user()->type != 'super admin' && \Auth::user()->subscription == $subscription->id): ?>
                                                <span class="badge text-bg-success"><?php echo e(__('Active')); ?></span>
                                                <br>
                                                <span><?php echo e(\Auth::user()->subscription_expire_date ? dateFormat(\Auth::user()->subscription_expire_date) : __('Unlimited')); ?></span>
                                                <?php echo e(__('Expiry Date')); ?>

                                            <?php else: ?>
                                                <?php if(\Auth::user()->type == 'owner' && \Auth::user()->subscription != $subscription->id): ?>
                                                    <div class="border-start py-4 py-md-5">
                                                        <a href="<?php echo e(route('subscriptions.show', \Illuminate\Support\Facades\Crypt::encrypt($subscription->id))); ?>"
                                                            class="btn btn-outline-primary bg-light text-primary">
                                                            <?php echo e(__('Purchase Now')); ?>

                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['subscriptions.destroy', $subscription->id]]); ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit pricing packages')): ?>
                                                <a class="text-secondary customModal" data-bs-toggle="tooltip"
                                                    data-bs-original-title="<?php echo e(__('Edit')); ?>" href="#"
                                                    data-url="<?php echo e(route('subscriptions.edit', $subscription->id)); ?>"
                                                    data-title="<?php echo e(__('Edit Package')); ?>"> <i data-feather="edit"></i></a>
                                            <?php endif; ?>
                                            <?php if($subscription->id != 1): ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete pricing packages')): ?>
                                                    <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                        data-bs-original-title="<?php echo e(__('Detete')); ?>" href="#"> <i
                                                            data-feather="trash-2"></i></a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php echo Form::close(); ?>

                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/subscription/index.blade.php ENDPATH**/ ?>