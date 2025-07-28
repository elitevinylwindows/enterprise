{{ Form::model(Auth::User(), array('route' => array('setting.smtp.testing'), 'method' => 'POST')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{Form::label('email',__('Test Email'),array('class'=>'form-label'))}}
            {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email'),'required'=>'required'))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{Form::submit(__('Send Mail'),array('class'=>'btn btn-secondary btn-rounded'))}}
</div>
{{ Form::close() }}
