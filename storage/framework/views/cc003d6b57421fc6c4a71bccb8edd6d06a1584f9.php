<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Role')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('role.index')); ?>"><?php echo e(__('Role')); ?></a></li>
    <li class="breadcrumb-item" aria-current="Edit"> <?php echo e(__('Edit')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php
        $systemModules = \App\Models\User::$systemModules;
    ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Create Role And Permissions')); ?></h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <?php echo e(Form::model($role,array('route' => array('role.update', $role->id), 'method' => 'PUT'))); ?>

                    <div class="form-group">
                        <?php echo e(Form::label('title',__('Role Title'),['class'=>'form-label'])); ?>

                        <?php echo e(Form::text('title',$role->name,array('class'=>'form-control','placeholder'=>__('Enter role title'),in_array($role->name,['tenant','maintainer'])?'readonly':''))); ?>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                


                                <?php $__currentLoopData = $systemModules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row">
                                        <?php $__currentLoopData = $permissionList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(str_contains(strtolower($permission->name), strtolower($module))): ?>
                                                <div class="form-check custom-chek form-check-inline col-md-2">
                                                    <?php echo e(Form::checkbox('user_permission[]', $permission->id, null, ['class'=>'form-check-input', 'id' => $module.'_permission'.$permission->id,in_array($permission->id,$assignPermission)?'checked':''])); ?>

                                                    <?php echo e(Form::label($module.'_permission'.$permission->id, ucfirst($permission->name), ['class'=>'form-check-label'])); ?>

                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <hr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-20 text-end">
                        <?php echo e(Form::submit(__('Update'),array('class'=>'btn btn-secondary btn-rounded'))); ?>

                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/role/edit.blade.php ENDPATH**/ ?>