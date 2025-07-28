{{ Form::open(array('url' => 'permission')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group ">
            {{Form::label('title',__('Permission Title'),['class'=>'form-label '])}}
            {{Form::text('title',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group">
            {{ Form::label('user_roles', __('User Roles'),['class'=>'form-label']) }}
            {!! Form::select('user_roles[]', $userRoles, null,array('class' => 'form-control hidesearch','multiple','required'=>'required')) !!}
        </div>
        <div class="col-md-12">
            {{Form::submit(__('Create'),array('class'=>'btn btn-secondary btn-rounded'))}}
        </div>
    </div>
</div>
{{ Form::close() }}


