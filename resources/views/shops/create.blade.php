{{ Form::open(['route' => 'shops.store', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">

        <div class="form-group col-md-6">
            {{ Form::label('customer', __('Customer #'), ['class' => 'form-label']) }}
            {{ Form::text('customer', null, ['class' => 'form-control', 'required']) }}
        </div>
            <div class="form-group col-md-6">
            {{ Form::label('customer_name', __('Customer Name'), ['class' => 'form-label']) }}
            {{ Form::text('customer_name', null, ['class' => 'form-control', 'required']) }}
        </div>
          <div class="form-group col-md-6">
            {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
            {{ Form::text('email', null, ['class' => 'form-control', 'required']) }}
        </div>
         <div class="form-group col-md-6">
            {{ Form::label('contact_phone', __('Contact Phone'), ['class' => 'form-label']) }}
            {{ Form::text('contact_phone', null, ['class' => 'form-control', 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('address', __('Address'), ['class' => 'form-label']) }}
            {{ Form::text('address', null, ['class' => 'form-control', 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('city', __('City'), ['class' => 'form-label']) }}
            {{ Form::text('city', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('zip', __('ZIP'), ['class' => 'form-label']) }}
            {{ Form::text('zip', null, ['class' => 'form-control']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{ Form::submit(__('Create'), ['class' => 'btn btn-secondary']) }}
</div>
{{ Form::close() }}


<script>
document.getElementById('customer').addEventListener('blur', function () {
    const customer = this.value;

    if (!customer) return;

    fetch(/shops/fetch-customer-name/${customer})
        .then(response => response.json())
        .then(data => {
            if (data.customer_name) {
                document.getElementById('customer_name').value = data.customer_name;
            }
        });
});
</script>