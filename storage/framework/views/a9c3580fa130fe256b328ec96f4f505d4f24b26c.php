<?php echo e(Form::model($shop, ['route' => ['shops.update', $shop->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('customer', __('Customer'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('customer', null, ['class' => 'form-control', 'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('customer_name', __('Customer Name'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('customer_name', null, ['class' => 'form-control', 'required'])); ?>

        </div>
         <div class="form-group col-md-6">
            <?php echo e(Form::label('email', __('Email'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('email', null, ['class' => 'form-control', 'required'])); ?>

        </div>
         <div class="form-group col-md-6">
            <?php echo e(Form::label('contact_phone', __('Contact Phone'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('contact_phone', null, ['class' => 'form-control', 'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('address', __('Address'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('address', null, ['class' => 'form-control', 'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('city', __('City'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('city', null, ['class' => 'form-control'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('zip', __('ZIP'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('zip', null, ['class' => 'form-control'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <?php echo e(Form::submit(__('Update'), ['class' => 'btn btn-secondary'])); ?>

</div>
<?php echo e(Form::close()); ?>


<script>
document.getElementById('customer').addEventListener('blur', function () {
    const customer = this.value;

    if (!customer) return;

    fetch(`/shops/fetch-customer-name/${customer}`)
        .then(response => response.json())
        .then(data => {
            if (data.customer_name) {
                document.getElementById('customer_name').value = data.customer_name;
            }
        });
});
</script>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/shops/edit.blade.php ENDPATH**/ ?>