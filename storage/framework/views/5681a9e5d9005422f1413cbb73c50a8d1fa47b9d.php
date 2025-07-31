<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Auth Page')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Auth Page')); ?></li>
<?php $__env->stopSection(); ?>
<?php
    $profile = asset(Storage::url('upload/profile'));
    $settings = settings();
    $activeTab = session('tab', 'footer_column_1');
?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $('.location').on('click', '.location_list_remove', function() {
            if ($('.location_list').length > 1) {
                $(this).closest('.location_remove').remove();
            }
        });
        $('.location').on('click', '.location_clone', function() {
            var clonedlocation = $(this).closest('.location').find('.location_list').first().clone();
            clonedlocation.find('input[type="text"]').val('');
            $(this).closest('.location').find('.location_list_results').append(clonedlocation);
        });
    </script>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <?php echo e(Form::model($authPage, ['route' => ['authPage.update', $authPage->id ?? 1], 'method' => 'PUT', 'enctype' => 'multipart/form-data'])); ?>

                    <div class="row">

                        <div class="col form-group">
                            <?php echo e(Form::label('section', __('Section Enabled'), ['class' => 'form-label'])); ?>

                            <div class="form-check form-switch">
                                <?php echo e(Form::hidden('section', '0')); ?>

                                <?php echo e(Form::checkbox('section', '1', $authPage->section ?? false, ['class' => 'form-check-input', 'role' => 'switch'])); ?>

                            </div>
                        </div>

                        <div class="col form-group">
                            <?php echo e(Form::label('image', __('Image'), ['class' => 'form-label'])); ?>

                            <?php if(!empty($authPage->image)): ?>
                                <a href="<?php echo e(asset(Storage::url($authPage->image))); ?>" target="_blank">
                                    <i class="ti ti-eye ms-2 f-15"></i>
                                </a>
                            <?php endif; ?>
                            <?php echo e(Form::file('image', ['class' => 'form-control'])); ?>

                        </div>

                        <div class="col-md-12 form-group location">
                            <?php if(!empty($titles) && count($titles) > 0): ?>
                                <?php $__currentLoopData = $titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row location_list location_remove">
                                        <div class="col form-group">
                                            <?php echo e(Form::label('Sec6_Box_title', __('Title'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::text('title[]', $title, ['class' => 'form-control', 'placeholder' => __('Enter title')])); ?>

                                        </div>
                                        <div class="col form-group">
                                            <?php echo e(Form::label('Sec6_Box_subtitle', __('Sub Title'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::text('description[]', $descriptions[$index] ?? '', ['class' => 'form-control', 'placeholder' => __('Enter subtitle')])); ?>

                                        </div>
                                        <div class="col-auto form-group m-auto">
                                            <a href="javascript:void(0)"
                                                class="bg-danger text-white location_list_remove btn btn-md">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <!-- If no titles are available, show blank input fields -->
                                <div class="row location_list location_remove">
                                    <div class="col form-group">
                                        <?php echo e(Form::label('title', __('Title'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('title[]', '', ['class' => 'form-control', 'placeholder' => __('Enter title')])); ?>

                                    </div>
                                    <div class="col form-group">
                                        <?php echo e(Form::label('description', __('Sub Title'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('description[]', '', ['class' => 'form-control', 'placeholder' => __('Enter subtitle')])); ?>

                                    </div>
                                    <div class="col-auto form-group m-auto">
                                        <a href="javascript:void(0)"
                                            class="bg-danger text-white location_list_remove btn btn-md">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="location_list_results"></div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="javascript:void(0)" class="btn btn-secondary btn-xs location_clone">
                                        <i class="ti ti-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-6"></div>
                            <div class="col-6 text-end">
                                <?php echo e(Form::hidden('tab', 'some_value')); ?>

                                <?php echo e(Form::submit(__('Save'), ['class' => 'btn btn-secondary btn-rounded'])); ?>

                            </div>
                        </div>

                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/auth_page/authPage.blade.php ENDPATH**/ ?>