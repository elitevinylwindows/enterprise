<?php
    $settings = settings();
?>
<?php $__env->startSection('tab-title'); ?>
    <?php echo e(__('Login')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <?php if($settings['google_recaptcha'] == 'on'): ?>
        <?php echo NoCaptcha::renderJs(); ?>

    <?php endif; ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <?php
        $registerPage = getSettingsValByName('register_page');
    ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="d-flex justify-content-center">
                    <div class="auth-header">
                        <h2 class="text-secondary"><b><?php echo e(__('Hi, Welcome Back')); ?> </b></h2>
                        <p class="f-16 mt-2"><?php echo e(__('Enter your credentials to continue')); ?></p>
                    </div>
                </div>
            </div>

            <?php echo e(Form::open(['route' => 'login', 'method' => 'post', 'id' => 'loginForm', 'class' => 'login-form'])); ?>

            <?php if(session('error')): ?>
            <div class="alert alert-danger" role="alert"><?php echo e(session('error')); ?></div>
            <?php endif; ?>
            <?php if(session('success')): ?>
            <div class="alert alert-success" role="alert"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('status')): ?>
            <div class="alert alert-success" role="alert"><?php echo e(session('status')); ?></div>
            <?php endif; ?>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email"
                    placeholder="<?php echo e(__('Email address')); ?>" />
                <label for="email"><?php echo e(__('Email address')); ?></label>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-email text-danger" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="<?php echo e(__('Password')); ?>" />
                <label for="password"><?php echo e(__('Password')); ?></label>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-password text-danger" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="d-flex mt-1 justify-content-between">
                <div class="form-check">
                    <input class="form-check-input input-primary" type="checkbox" id="agree"
                        <?php echo e(old('remember') ? 'checked' : ''); ?> />
                    <label class="form-check-label text-muted" for="agree"><?php echo e(__('Remember me')); ?></label>
                </div>
                <?php if(Route::has('password.request')): ?>
                    <a href="<?php echo e(route('password.request')); ?>" class="text-secondary"><?php echo e(__('Forgot Password?')); ?></a>
                <?php endif; ?>
            </div>
            <?php if($settings['google_recaptcha'] == 'on'): ?>
                <div class="form-group">
                    <label for="email" class="form-label"></label>
                    <?php echo NoCaptcha::display(); ?>


                </div>
                <?php if($errors->has('g-recaptcha-response')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('g-recaptcha-response')); ?></strong>
                    </span>
                <?php endif; ?>
            <?php endif; ?>
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-secondary p-2"><?php echo e(__('Sign In')); ?></button>
            </div>
            <?php if($registerPage == 'on'): ?>
                <hr />
                <h5 class="d-flex justify-content-center"><?php echo e(__("Don't Have An Account?")); ?> <a class="ms-1 text-secondary"
                        href="<?php echo e(route('register')); ?>"><?php echo e(__('Create an account')); ?></a>
                </h5>
            <?php endif; ?>
            <?php echo e(Form::close()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\elitevinyle\resources\views/auth/login.blade.php ENDPATH**/ ?>