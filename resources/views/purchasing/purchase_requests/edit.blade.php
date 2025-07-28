{{ Form::model($request, ['route' => ['purchasing.purchase-requests.update', $request->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('request_number', __('Request Number'), ['class' => 'form-label']) !!}
            {!! Form::text('request_number', $request->request_number, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('requested_by', __('Requested By'), ['class' => 'form-label']) !!}
            {!! Form::text('requested_by', $request->requested_by, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('department', __('Department'), ['class' => 'form-label']) !!}
            {!! Form::text('department', $request->department, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('request_date', __('Request Date'), ['class' => 'form-label']) !!}
            {!! Form::date('request_date', \Carbon\Carbon::parse($request->request_date), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('expected_date', __('Expected Date'), ['class' => 'form-label']) !!}
            {!! Form::date('expected_date', \Carbon\Carbon::parse($request->expected_date), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('priority', __('Priority'), ['class' => 'form-label']) !!}
            {!! Form::select('priority', ['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'], $request->priority, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
            {!! Form::select('status', ['Pending' => 'Pending', 'Approved' => 'Approved', 'Rejected' => 'Rejected'], $request->status, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('notes', __('Notes'), ['class' => 'form-label']) !!}
            {!! Form::textarea('notes', $request->notes, ['class' => 'form-control', 'rows' => 3]) !!}
        </div>
    </div>
</div>

<div class="modal-footer">
    {!! Form::submit(__('Update'), ['class' => 'btn btn-primary']) !!}
</div>
{{ Form::close() }}
