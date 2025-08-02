<div class="modal fade" id="createStockInModal" tabindex="-1" aria-labelledby="createStockInLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form method="POST" action="{{ route('inventory.stock-in.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Create Stock In') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-4">
              <label>{{ __('Date') }}</label>
              <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-4">
              <label>{{ __('Reference No') }}</label>
              <input type="text" name="reference_no" class="form-control">
            </div>
            <div class="col-md-4">
              <label>{{ __('Warehouse') }}</label>
              <select name="warehouse" class="form-control">
                <option value="South Gate">South Gate</option>
                <option value="Whittier">Whittier</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
 <div class="col-md-4">
            <label>{{ __('Location') }}</label>
            <select name="location_id" id="location_id" class="form-control select2">
                <option value="">{{ __('Select Location') }}</option>
                @foreach ($locations as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
    </div>

    <div class="col-md-4">
            <label>{{ __('Product') }}</label>
            <select name="product_id" id="product_id" class="form-control select2">
                <option value="">{{ __('Select Product') }}</option>
                @foreach ($products as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
    </div>

            <div class="col-md-4">
              <label>{{ __('Quantity') }}</label>
              <input type="number" name="quantity" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label>{{ __('Received Date') }}</label>
              <input type="date" name="received_date" class="form-control">
            </div>
            <div class="col-md-4">
              <label>{{ __('Supplier') }}</label>
              <select name="supplier_id" class="form-control">
                @foreach ($suppliers as $id => $name)
                  <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label>{{ __('Status') }}</label>
              <select name="status" class="form-control">
                <option value="pending">Pending</option>
                <option value="received">Received</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label>{{ __('Note') }}</label>
            <textarea name="note" class="form-control" rows="3"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        </div>
      </div>
    </form>
  </div>
</div>


@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "{{ __('Select an option') }}",
            allowClear: true,
            dropdownParent: $('#createStockInModal'), // Only if inside a modal
            dropdownCssClass: '!border-gray-300 !rounded-md !shadow-lg !mt-1', // Tailwind classes
        });
    });
</script>
@endpush


