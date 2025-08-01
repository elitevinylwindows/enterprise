<div class="modal fade" id="editStockInModal-{{ $stockIn->id }}" tabindex="-1" aria-labelledby="editStockInModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form method="POST" action="{{ route('inventory.stock-in.update', $stockIn->id) }}">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Edit Stock In') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-4">
              <label>{{ __('Date') }}</label>
              <input type="date" name="date" class="form-control" value="{{ $stockIn->date }}">
            </div>
            <div class="col-md-4">
              <label>{{ __('Reference No') }}</label>
              <input type="text" name="reference_no" class="form-control" value="{{ $stockIn->reference_no }}">
            </div>
            <div class="col-md-4">
              <label>{{ __('Warehouse') }}</label>
              <select name="warehouse" class="form-control">
                <option value="South Gate" {{ $stockIn->warehouse == 'South Gate' ? 'selected' : '' }}>South Gate</option>
                <option value="Whittier" {{ $stockIn->warehouse == 'Whittier' ? 'selected' : '' }}>Whittier</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label>{{ __('Location') }}</label>
              <select name="location_id" class="form-control">
                @foreach ($locations as $id => $name)
                  <option value="{{ $id }}" {{ $stockIn->location_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label>{{ __('Product') }}</label>
              <select name="product_id" class="form-control">
                @foreach ($products as $id => $name)
                  <option value="{{ $id }}" {{ $stockIn->product_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label>{{ __('Quantity') }}</label>
              <input type="number" name="quantity" class="form-control" value="{{ $stockIn->quantity }}">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label>{{ __('Received Date') }}</label>
              <input type="date" name="received_date" class="form-control" value="{{ $stockIn->received_date }}">
            </div>
            <div class="col-md-4">
              <label>{{ __('Supplier') }}</label>
              <select name="supplier_id" class="form-control">
                @foreach ($suppliers as $id => $name)
                  <option value="{{ $id }}" {{ $stockIn->supplier_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label>{{ __('Status') }}</label>
              <select name="status" class="form-control">
                <option value="pending" {{ $stockIn->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="received" {{ $stockIn->status == 'received' ? 'selected' : '' }}>Received</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label>{{ __('Note') }}</label>
            <textarea name="note" class="form-control" rows="3">{{ $stockIn->note }}</textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        </div>
      </div>
    </form>
  </div>
</div>
