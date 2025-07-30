

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Settings')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Settings')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-4"></div> 

<div class="row">
    
    <div class="col-md-4">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="<?php echo e(route('sales.settings.index', ['selected' => 'quickbooks'])); ?>" class="list-group-item <?php echo e(request('selected') == 'quickbooks' ? 'active' : ''); ?>">Quickbooks</a>
                <a href="<?php echo e(route('sales.settings.index', ['selected' => 'sales_admin'])); ?>" class="list-group-item <?php echo e(request('selected') == 'sales_admin' ? 'active' : ''); ?>">Sales Admin</a>
                <a href="<?php echo e(route('sales.settings.index', ['selected' => 'api'])); ?>" class="list-group-item <?php echo e(request('selected') == 'api' ? 'active' : ''); ?> text-danger">API</a>
            </div>
        </div>
    </div>

    
    <div class="col-sm-8">
        <div class="card">
            <div class="card-header">
                <h5><?php echo e(ucfirst(str_replace('_', ' ', request('selected', 'Settings')))); ?> Settings</h5>
            </div>
            <div class="card-body">
                <?php echo Form::open(['route' => 'sales.settings.save', 'method' => 'post']); ?>

                <?php echo Form::hidden('section', request('selected')); ?>


                <?php if(request('selected') === 'quickbooks'): ?>
                    <div class="form-group mb-3">
                        <?php echo Form::label('quickbooks_api_key', 'API Key', ['class' => 'form-label']); ?>

                        <?php echo Form::text('quickbooks_api_key', sales_setting('quickbooks_api_key'), ['class' => 'form-control']); ?>

                    </div>
                    <div class="form-group mb-3">
                        <?php echo Form::label('quickbooks_company_id', 'Company ID', ['class' => 'form-label']); ?>

                        <?php echo Form::text('quickbooks_company_id', sales_setting('quickbooks_company_id'), ['class' => 'form-control']); ?>

                    </div>

                <?php elseif(request('selected') === 'sales_admin'): ?>
                    <div class="form-group mb-3">
                        <?php echo Form::label('default_sales_region', 'Default Sales Region', ['class' => 'form-label']); ?>

                        <?php echo Form::text('default_sales_region', sales_setting('default_sales_region'), ['class' => 'form-control']); ?>

                    </div>
                    <div class="form-group mb-3">
                        <?php echo Form::label('sales_notification_email', 'Notification Email', ['class' => 'form-label']); ?>

                        <?php echo Form::email('sales_notification_email', sales_setting('sales_notification_email'), ['class' => 'form-control']); ?>

                    </div>

                <?php elseif(request('selected') === 'api'): ?>
                    <div class="form-group mb-3">
                        <?php echo Form::label('api_access_token', 'Access Token', ['class' => 'form-label']); ?>

                        <?php echo Form::text('api_access_token', sales_setting('api_access_token'), ['class' => 'form-control']); ?>

                    </div>
                    <div class="form-group mb-3">
                        <?php echo Form::label('api_base_url', 'Base URL', ['class' => 'form-label']); ?>

                        <?php echo Form::url('api_base_url', sales_setting('api_base_url'), ['class' => 'form-control']); ?>

                    </div>
                <?php else: ?>
                    <p>Please select a section from the left.</p>
                <?php endif; ?>

                <?php if(request('selected')): ?>
                <div class="mt-3 text-end">
                    <?php echo Form::submit(__('Save Settings'), ['class' => 'btn btn-primary']); ?>

                </div>
                <?php endif; ?>

                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/sales/settings/index.blade.php ENDPATH**/ ?>