{{Form::model($coupon, array('route' => array('coupons.update', $coupon->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-6">
            {{Form::label('name',__('Coupon Name'),array('class'=>'form-label'))}}
            {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter coupon name')))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('type',__('Coupon Type'),array('class'=>'form-label'))}}
            {{Form::select('type',$type,null,array('class'=>'form-control basic-select'))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('code',__('Coupon Code'),array('class'=>'form-label'))}}
            {{Form::text('code',null,array('class'=>'form-control','placeholder'=>__('Enter coupon code')))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('rate',__('Discount Rate'),array('class'=>'form-label'))}}
            {{Form::number('rate',null,array('class'=>'form-control','placeholder'=>__('Enter coupon discount rate')))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('valid_for',__('Valid For'),array('class'=>'form-label'))}}
            {{Form::date('valid_for',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('use_limit',__('Number Of Times This Coupon Can Be Used'),array('class'=>'form-label'))}}
            {{Form::number('use_limit',null,array('class'=>'form-control','placeholder'=>__('Enter coupon use limit')))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('applicable_packages',__('Applicable Packages'),array('class'=>'form-label'))}}
            {{Form::select('applicable_packages[]',$packages,explode(',',$coupon->applicable_packages),array('class'=>'form-control hidesearch','multiple'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('status',__('Status'),array('class'=>'form-label'))}}
            {{Form::select('status',$status,null,array('class'=>'form-control basic-select'))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{Form::submit(__('Update'),array('class'=>'btn btn-secondary btn-rounded'))}}
</div>
{{ Form::close() }}



