<?php echo e(Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data'])); ?>

<div class="modal-body">
    <div class="row">
        <?php if(\Auth::user()->type != 'super admin'): ?>
            <div class="form-group col-md-6">
                <?php echo e(Form::label('role', __('Assign Role'), ['class' => 'form-label'])); ?>

                <?php echo Form::select('role', $userRoles, !empty($user->roles) ? $user->roles[0]->id : null, [
                    'class' => 'form-control hidesearch ',
                    'required' => 'required',
                ]); ?>

            </div>
        <?php endif; ?>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Name'), 'required' => 'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('email', __('Email'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Enter Email'), 'required' => 'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('phone_number', __('Phone Number'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('phone_number', null, ['class' => 'form-control', 'placeholder' => __('Enter Phone Number')])); ?>

        </div>
        <div class="form-group <?php echo e(\Auth::user()->type == 'super admin' ? 'col-md-6 col-lg-6' : 'col-md-12 col-lg-12'); ?>">
            <?php echo e(Form::label('profile', __('Profile'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::file('profile', ['class' => 'form-control'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <?php echo e(Form::submit(__('Update'), ['class' => 'btn btn-secondary btn-rounded'])); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/user/edit.blade.php ENDPATH**/ ?>