{{Form::open(array('url'=>'visitor','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-6">
            {{Form::label('first_name',__('First Name'),array('class'=>'form-label'))}}
            {{Form::text('first_name',null,array('class'=>'form-control','placeholder'=>__('Enter first name')))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('last_name',__('Last Name'),array('class'=>'form-label'))}}
            {{Form::text('last_name',null,array('class'=>'form-control','placeholder'=>__('Enter last name')))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('email',__('Email'),array('class'=>'form-label'))}}
            {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter email')))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('phone_number',__('Phone Number'),array('class'=>'form-label'))}}
            {{Form::text('phone_number',null,array('class'=>'form-control','placeholder'=>__('Enter phone number')))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('gender',__('Gender'),array('class'=>'form-label'))}}
            {{Form::select('gender',$gender,null,array('class'=>'form-control hidesearch'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('category',__('Category'),array('class'=>'form-label'))}}
            {{Form::select('category',$category,null,array('class'=>'form-control hidesearch'))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('address',__('Address'),array('class'=>'form-label'))}}
            {{Form::textarea('address',null,array('class'=>'form-control','rows'=>1))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('date',__('Visit Date'),array('class'=>'form-label'))}}
            {{Form::date('date',date('Y-m-d'),array('class'=>'form-control'))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('entry_time',__('Entry Time'),array('class'=>'form-label'))}}
            {{Form::time('entry_time',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('exit_time',__('Exit Time'),array('class'=>'form-label'))}}
            {{Form::time('exit_time',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('status',__('Status'),array('class'=>'form-label'))}}
            {{Form::select('status',$status,null,array('class'=>'form-control hidesearch'))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('notes',__('Notes'),array('class'=>'form-label'))}}
            {{Form::textarea('notes',null,array('class'=>'form-control','rows'=>2))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{Form::submit(__('Create'),array('class'=>'btn btn-secondary btn-rounded'))}}
</div>
{{ Form::close() }}


