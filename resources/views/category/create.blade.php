{{Form::open(array('url'=>'visit-category','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            {{Form::label('title',__('Title'),array('class'=>'form-label'))}}
            {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter category title'),'required'=>'required'))}}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('type', __('Visit Type'),['class'=>'form-label']) }}
            {!! Form::select('type', $types, null,array('class' => 'form-control hidesearch','required'=>'required')) !!}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('fees',__('Fees'),array('class'=>'form-label'))}}
            {{Form::number('fees',0,array('class'=>'form-control','placeholder'=>__('Enter visit amount')))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{Form::submit(__('Create'),array('class'=>'btn btn-secondary btn-rounded'))}}
</div>
{{ Form::close() }}


