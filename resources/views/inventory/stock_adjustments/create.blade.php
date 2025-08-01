<!-- Create Stock Adjustment Modal -->
<div class="modal fade" id="createStockAdjustmentModal" tabindex="-1" aria-labelledby="createStockAdjustmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        {!! Form::open(['route' => 'inventory.stock-adjustments.store', 'method' => 'post']) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('New Stock Adjustment') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        {!! Form::label('date', __('Date'), ['class' => 'form-label']) !!}
                        {!! Form::date('date', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('reference_no', __('Reference No'), ['class' => 'form-label']) !!}
                        {!! Form::text('reference_no', 'ADJ-' . strtoupper(\Illuminate\Support\Str::random(6)), ['class' => 'form-control', 'readonly']) !!}
                    </div>

                    <div class="form-group col-md-12 mt-3">
                        {!! Form::label('product_id', __('Product'), ['class' => 'form-label']) !!}
                        {!! Form::select('product_id', $products, null, ['class' => 'form-control', 'placeholder' => 'Select Product']) !!}
                    </div>

                    <div class="form-group col-md-6 mt-3">
                        {!! Form::label('quantity', __('Quantity'), ['class' => 'form-label']) !!}
                        {!! Form::number('quantity', null, ['class' => 'form-control', 'step' => '1', 'min' => '1']) !!}
                    </div>

                    <div class="form-group col-md-6 mt-3">
                        {!! Form::label('status', __('Adjustment Type'), ['class' => 'form-label']) !!}
                        {!! Form::select('status', ['deducted' => 'Deduct from Stock', 'added' => 'Add to Stock'], 'deducted', ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-md-12 mt-3">
                        {!! Form::label('reason', __('Reason'), ['class' => 'form-label']) !!}
                        {!! Form::textarea('reason', null, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                {!! Form::submit(__('Create'), ['class' => 'btn btn-primary']) !!}
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
