{{-- resources/views/manufacturing/capacity/create.blade.php --}}
<form method="POST" action="{{ route('manufacturing.capacity.store') }}" id="capacityCreateForm">
  @csrf

  <div class="px-4 pt-3"> {{-- adds horizontal + top padding inside modal --}}
    <div class="row g-3 align-items-end"> {{-- g-3 = column gutters --}}
      <div class="col-md-6">
        <label class="form-label">{{ __('Description') }}</label>
        <input type="text"
               name="description"
               class="form-control @error('description') is-invalid @enderror"
               placeholder="{{ __('e.g., Daily Glass Cutting') }}"
               value="{{ old('description') }}"
               required>
        @error('description')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-3">
        <label class="form-label">{{ __('Limit') }}</label>
        <input type="number"
               step="0.01"
               min="0"
               name="limit"
               class="form-control @error('limit') is-invalid @enderror"
               value="{{ old('limit') }}"
               required>
        @error('limit')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-3">
        <label class="form-label">{{ __('Actual') }}</label>
        <input type="number"
               step="0.01"
               min="0"
               name="actual"
               class="form-control @error('actual') is-invalid @enderror"
               value="{{ old('actual') }}"
               required>
        @error('actual')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="row g-3 mt-2">
      <div class="col-md-3">
        <label class="form-label">{{ __('Percentage') }}</label>
        <div class="input-group">
          <input type="number"
                 step="0.01"
                 min="0"
                 name="percentage"
                 class="form-control @error('percentage') is-invalid @enderror"
                 value="{{ old('percentage') }}"
                 placeholder="0.00">
          <span class="input-group-text">%</span>
        </div>
        <div class="form-text">
          {{ __('Optional. If empty, it can be calculated from Actual ÷ Limit × 100.') }}
        </div>
        @error('percentage')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-9 d-none d-md-block">
        {{-- spacer to mirror the stations template layout --}}
      </div>
    </div>
  </div>

  <div class="modal-footer px-4">
    <button type="submit" class="btn btn-primary">{{ __('Create Capacity Record') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>
