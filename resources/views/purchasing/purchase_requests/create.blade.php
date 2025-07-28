{{ Form::open(['route' => 'purchasing.purchase-requests.store', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('request_number', __('Request Number'), ['class' => 'form-label']) !!}
            {!! Form::text('request_number', null, ['class' => 'form-control', 'required' => true]) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('requested_by', __('Requested By'), ['class' => 'form-label']) !!}
            {!! Form::text('requested_by', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('department', __('Department'), ['class' => 'form-label']) !!}
            {!! Form::text('department', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('request_date', __('Request Date'), ['class' => 'form-label']) !!}
            {!! Form::date('request_date', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('expected_date', __('Expected Date'), ['class' => 'form-label']) !!}
            {!! Form::date('expected_date', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('priority', __('Priority'), ['class' => 'form-label']) !!}
            {!! Form::select('priority', ['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High', 'Urgent' => 'Urgent'], null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
            {!! Form::select('status', ['Pending' => 'Pending', 'Approved' => 'Approved', 'Rejected' => 'Rejected'], 'Pending', ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('notes', __('Notes'), ['class' => 'form-label']) !!}
            {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 3]) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit(__('Create'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}
