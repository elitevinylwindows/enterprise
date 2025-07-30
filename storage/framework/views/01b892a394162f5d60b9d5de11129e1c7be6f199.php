

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('New Invoice')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('sales.invoices.index')); ?>"><?php echo e(__('Invoices')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('New Invoice')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><h5><?php echo e(__('Create New Invoice')); ?></h5></div>
            <div class="card-body">
                <?php echo Form::open(['route' => 'sales.invoices.store', 'method' => 'post']); ?>

                <div class="row">
                    <div class="form-group col-md-6">
                        <?php echo Form::label('invoice_date', __('Invoice Date'), ['class' => 'form-label']); ?>

                        <?php echo Form::date('invoice_date', \Carbon\Carbon::now(), ['class' => 'form-control']); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo Form::label('status', __('Status'), ['class' => 'form-label']); ?>

                        <?php echo Form::select('status', ['Pending' => 'Pending', 'Paid' => 'Paid'], null, ['class' => 'form-control']); ?>

                    </div>
                    <div class="form-group col-md-6">
    <?php echo Form::label('customer_number', __('Customer Number'), ['class' => 'form-label']); ?>

    <input type="text" name="customer_number" class="form-control" required>
</div>

<div class="form-group col-md-6">
    <?php echo Form::label('customer_name', __('Customer Name'), ['class' => 'form-label']); ?>

    <input type="text" name="customer_name" class="form-control" readonly>
</div>

                    <div class="form-group col-md-6">
                        <?php echo Form::label('net_price', __('Net Price'), ['class' => 'form-label']); ?>

                        <?php echo Form::number('net_price', null, ['class' => 'form-control', 'step' => '0.01']); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo Form::label('paid_amount', __('Paid Amount'), ['class' => 'form-label']); ?>

                        <?php echo Form::number('paid_amount', null, ['class' => 'form-control', 'step' => '0.01']); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo Form::label('remaining_amount', __('Remaining Amount'), ['class' => 'form-label']); ?>

                        <?php echo Form::number('remaining_amount', null, ['class' => 'form-control', 'step' => '0.01']); ?>

                    </div>
                    <div class="form-group col-md-12">
                        <?php echo Form::label('notes', __('Notes'), ['class' => 'form-label']); ?>

                        <?php echo Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 3]); ?>

                    </div>
                </div>
                <div class="mt-4 text-end">
                    <?php echo Form::submit(__('Save Invoice'), ['class' => 'btn btn-primary']); ?>

                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const customerInput = document.querySelector('input[name="customer_number"]');
    const customerNameInput = document.querySelector('input[name="customer_name"]');

    customerInput.addEventListener('change', function () {
        const number = this.value;

        if (!number.trim()) return;

        fetch(`/sales/customers/${number}`)
            .then(res => res.json())
            .then(data => {
                if (data.customer_name) {
                    customerNameInput.value = data.customer_name;
                } else {
                    customerNameInput.value = '';
                    alert('Customer not found');
                }
            })
            .catch(() => {
                customerNameInput.value = '';
                alert('Failed to fetch customer.');
            });
    });
});
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/sales/invoices/create.blade.php ENDPATH**/ ?>