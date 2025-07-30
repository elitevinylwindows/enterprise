<?php
    $profile = asset(Storage::url('upload/profile/'));
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Customer Details')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('users.index')); ?>"><?php echo e(__('Customer')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Show')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on('change', '.plan_change', function() {
            $('.plan_change_info').hide();
            var plan_id = $('.plan_change:checked').attr('id');
            $('.plan_change_info.' + plan_id).show();
            console.log($('.plan_change_info.' + plan_id));

        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="profile-tab-1" data-bs-toggle="tab" href="#profile-1"
                                role="tab" aria-selected="true">
                                <i class="material-icons-two-tone">request_quote</i>
                                <?php echo e(__('Transactions History')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-2" data-bs-toggle="tab" href="#profile-2" role="tab"
                                aria-selected="true">
                                <i class="material-icons-two-tone me-2">description</i>
                                <?php echo e(__('Packages')); ?>

                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                            <div class="row">
                                <div class="col-lg-4 col-xxl-3">
                                    <div class="card border">
                                        <div class="card-header">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img class="img-radius img-fluid wid-40"
                                                        src="<?php echo e(!empty($user->profile) ? $profile . '/' . $user->profile : $profile . '/avatar.png'); ?>"
                                                        alt="User image" />
                                                </div>
                                                <div class="flex-grow-1 mx-3">
                                                    <h5 class="mb-1"><?php echo e($user->name); ?></h5>
                                                    <h6 class="text-muted mb-0"><?php echo $user->SubscriptionLeftDay(); ?></h6>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="badge bg-primary rounded-pill text-base">
                                                        <?php echo e($user->type); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body px-2 pb-0">
                                            <div class="list-group list-group-flush">
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">email</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0"><?php echo e(__('Email')); ?></h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <small><?php echo e($user->email); ?></small>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">phonelink_ring</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0"><?php echo e(__('Phone')); ?></h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <small><?php echo e($user->phone_number); ?></small>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">pin_drop</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0"><?php echo e(__('Package')); ?></h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <small><?php echo e(!empty($user->subscriptions) ? $user->subscriptions->title : ''); ?></small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-xxl-9">
                                    <div class="card border">
                                        <div class="card-header">
                                            <h5><?php echo e(__('Transactions History')); ?></h5>
                                        </div>
                                        <div class="card-body">
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
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e(!empty($transaction->users) ? $transaction->users->name : ''); ?>

                                                                </td>
                                                                <td><?php echo e(dateFormat($transaction->created_at)); ?></td>
                                                                <td><?php echo e(!empty($transaction->subscriptions) ? $transaction->subscriptions->title : '-'); ?>

                                                                </td>
                                                                <td><?php echo e($settings['CURRENCY_SYMBOL'] . $transaction->amount); ?>

                                                                </td>
                                                                <td><?php echo e($transaction->payment_type); ?></td>
                                                                <td>
                                                                    <?php if($transaction->payment_status == 'Pending'): ?>
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
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                            <div class="row">
                                <div class="col-lg-4 col-xxl-3">
                                    <div class="card border">
                                        <div class="card-header">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img class="img-radius img-fluid wid-40"
                                                        src="<?php echo e(!empty($user->profile) ? $profile . '/' . $user->profile : $profile . '/avatar.png'); ?>"
                                                        alt="User image" />
                                                </div>
                                                <div class="flex-grow-1 mx-3">
                                                    <h5 class="mb-1"><?php echo e($user->name); ?></h5>
                                                    <h6 class="text-muted mb-0"><?php echo $user->SubscriptionLeftDay(); ?></h6>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="badge bg-primary rounded-pill text-base">
                                                        <?php echo e($user->type); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body px-2 pb-0">
                                            <div class="list-group list-group-flush">
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">email</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0"><?php echo e(__('Email')); ?></h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <small><?php echo e($user->email); ?></small>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">phonelink_ring</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0"><?php echo e(__('Phone')); ?></h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <small><?php echo e($user->phone_number); ?></small>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">pin_drop</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0"><?php echo e(__('Package')); ?></h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <small><?php echo e(!empty($user->subscriptions) ? $user->subscriptions->title : ''); ?></small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-xxl-9">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <img src="../assets/images/admin/img-bulb.svg" alt="images"
                                                        class="img-fluid" />
                                                    <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription_key => $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        
                                                        <ul class="gap-2 mt-3 plan_change_info customCheckdef<?php echo e($subscription_key); ?>"
                                                            style="display:<?php echo e($subscription->id == $user->subscription ? 'block' : 'none'); ?>">
                                                            <li><?php echo e(__('User Limit')); ?> <?php echo e($subscription->user_limit); ?>

                                                            </li>
                                                            <?php if($subscription->enabled_logged_history): ?>
                                                                <li><?php echo e(__('Enabled')); ?> <?php echo e(__('Logged History')); ?></li>
                                                            <?php else: ?>
                                                                <li><?php echo e(__('Disable')); ?> <?php echo e(__('Logged History')); ?></li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <div class="col-sm-7">
                                                    <div class="course-price">
                                                        <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sitem_key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="form-check p-0">
                                                                <input type="radio" name="radio1"
                                                                    class="form-check-input input-primary plan_change"
                                                                    <?php echo e($item->id == $user->subscription ? 'checked' : ''); ?>

                                                                    id="customCheckdef<?php echo e($sitem_key); ?>" />
                                                                <label class="form-check-label d-block"
                                                                    for="customCheckdef<?php echo e($sitem_key); ?>">
                                                                    <span class="d-flex align-items-center">
                                                                        <span class="flex-grow-1 me-3">
                                                                            <span
                                                                                class="h5 d-block"><?php echo e($item->title); ?></span>
                                                                            <?php if($item->id == $user->subscription): ?>
                                                                                <span
                                                                                    class="badge"><?php echo e($item->id == $user->subscription ? __('Active') : __('Click to Select')); ?></span>
                                                                            <?php else: ?>
                                                                                <?php echo Form::open([
                                                                                    'method' => 'POST',
                                                                                    'route' => [
                                                                                        'subscription.manual_assign_package',
                                                                                        [\Illuminate\Support\Facades\Crypt::encrypt($item->id), $user->id],
                                                                                    ],
                                                                                ]); ?>

                                                                                <a class="text-danger confirm_dialog"
                                                                                    data-dialog-title="<?php echo e(__('Are you sure want to Change Package?')); ?>"
                                                                                    data-dialog-text="<?php echo e(__('This record can not be restore after change. Do you want to confirm?')); ?>"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-original-title="<?php echo e(__('Select')); ?>"
                                                                                    href="#"> <span
                                                                                        class="badge"><?php echo e($item->id == $user->subscription ? __('Active') : __('Click to Select')); ?></span>
                                                                                </a>
                                                                                <?php echo Form::close(); ?>

                                                                            <?php endif; ?>
                                                                        </span>
                                                                        <span class="flex-shrink-0">
                                                                            <span class="h3 mb-0">
                                                                                <?php echo e($item->package_amount); ?><?php echo e(subscriptionPaymentSettings()['CURRENCY_SYMBOL']); ?>/
                                                                                <span
                                                                                    class="text-sm"><?php echo e($item->interval); ?></span>
                                                                            </span>
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/user/show.blade.php ENDPATH**/ ?>