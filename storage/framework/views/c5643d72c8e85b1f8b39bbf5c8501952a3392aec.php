<?php
    $users = \Auth::user();
    $languages = \App\Models\Custom::languages();
    $userLang = \Auth::user()->lang;
    $profile = asset(Storage::url('upload/profile'));
    $ids = parentId();
    $authUser = \App\Models\User::find($ids);
    $subscription = \App\Models\Subscription::find($authUser->subscription);
?>

<header class="pc-header">
    <div class="header-wrapper"><!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="pc-h-item header-mobile-collapse">
                    <a href="#" class="pc-head-link head-link-secondary ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link head-link-secondary ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>

            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">

                <?php if(
                    \Auth::user()->type == 'owner' &&
                        Gate::check('manage pre register visitor') &&
                        $subscription->enabled_pre_register == 1): ?>
                    <li class="dropdown pc-h-item pc-mega-menu" data-bs-toggle="tooltip"
                        data-bs-original-title="<?php echo e(__('Copy pre-register form link')); ?>" data-bs-placement="bottom">
                        <a href="#"
                            class="pc-head-link head-link-secondary dropdown-toggle arrow-none me-0 copy_register_link"
                            data-url="<?php echo e(route('pre-register', \Auth::user()->code)); ?>">
                            <i class="ti ti-copy"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="dropdown pc-h-item" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Language')); ?>"
                    data-bs-placement="bottom">
                    <a class="pc-head-link head-link-primary dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-language"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($language != 'en'): ?>
                                <a href="<?php echo e(route('language.change', $language)); ?>"
                                    class="dropdown-item <?php echo e($userLang == $language ? 'active' : ''); ?>">
                                    <span class="align-middle"><?php echo e(ucfirst($language)); ?></span>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </div>
                </li>





                <?php if(\Auth::user()->type == 'super admin' || \Auth::user()->type == 'owner'): ?>
                    <li class="dropdown pc-h-item pc-mega-menu" data-bs-toggle="tooltip"
                        data-bs-original-title="<?php echo e(__('Theme Settings')); ?>" data-bs-placement="bottom">
                        <a href="#" class="pc-head-link head-link-secondary dropdown-toggle arrow-none me-0"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvas_pc_layout">
                            <i class="ti ti-settings"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link head-link-primary dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="<?php echo e(!empty($users->profile) ? $profile . '/' . $users->profile : $profile . '/avatar.png'); ?>"
                            alt="user-image" class="user-avtar" />
                        <span>
                            <i class="ti ti-user-check"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header">
                            <h4>
                                <?php echo e(__('Good Morning')); ?>,
                                <span class="small text-muted"><?php echo e(\Auth::user()->name); ?></span>
                            </h4>
                            <p class="text-muted"><?php echo e(\Auth::user()->type); ?></p>

                            <div class="profile-notification-scroll position-relative"
                                style="max-height: calc(100vh - 280px)">
                                <hr />
                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['setting.account.delete']]); ?>

                                <a href="#" class="dropdown-item common_confirm_dialog" data-actions="Account">
                                    <i class="ti ti-user-x"></i>
                                    <span><?php echo e(__('Account Delete')); ?></span>
                                </a>
                                <?php echo Form::close(); ?>

                                <?php if (is_impersonating()) : ?>
                                    <a href="<?php echo e(route('impersonate.leave')); ?>" class="dropdown-item"
                                        data-actions="Account">
                                        <i class="ti ti-transfer-out"></i>
                                        <span><?php echo e(__('Leave')); ?></span>
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('logout')); ?>" class="dropdown-item"
                                    onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                    <i class="ti ti-logout"></i>
                                    <span><?php echo e(__('Logout')); ?></span>
                                    <form id="frm-logout" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                        <?php echo e(csrf_field()); ?>

                                    </form>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/admin/header.blade.php ENDPATH**/ ?>