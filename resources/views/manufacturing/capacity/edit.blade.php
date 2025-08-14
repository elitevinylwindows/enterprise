{{-- Modal PARTIAL: Edit Capacity --}}
<form method="POST" action="{{ route('manufacturing.capacity.update', $capacity->id) }}" id="capacityEditForm">
  @csrf
  @method('PUT')

  <div class="px-4 pt-3">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">{{ __('Description') }}</label>
        <input type="text"
               name="description"
               class="form-control @error('description') is-invalid @enderror"
               value="{{ old('description', $capacity->description) }}"
               required>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-3">
        <label class="form-label">{{ __('Limit') }}</label>
        <input type="number"
               step="0.01"
               min="0"
               name="limit"
               id="cap_limit_edit"
               class="form-control @error('limit') is-invalid @enderror"
               value="{{ old('limit', $capacity->limit) }}"
               required>
        @error('limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-3">
        <label class="form-label">{{ __('Actual') }}</label>
        <input type="number"
               step="0.01"
               min="0"
               name="actual"
               id="cap_actual_edit"
               class="form-control @error('actual') is-invalid @enderror"
               value="{{ old('actual', $capacity->actual) }}"
               required>
        @error('actual') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-3">
        <label class="form-label">{{ __('Percentage') }}</label>
        <div class="input-group">
          <input type="number"
                 step="0.01"
                 min="0"
                 name="percentage"
                 id="cap_percentage_edit"
                 class="form-control @error('percentage') is-invalid @enderror"
                 value="{{ old('percentage', $capacity->percentage) }}"
                 placeholder="0.00">
          <span class="input-group-text">%</span>
        </div>
        <div class="form-text">{{ __('Auto-calculated from Actual / Limit (editable)') }}</div>
        @error('percentage') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
    </div>
  </div>

  <div class="modal-footer px-4">
    <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

{{-- Local auto-calc (safe inside AJAX modal) --}}
<script>
(function(){
  const limitEl = document.getElementById('cap_limit_edit');
  const actualEl = document.getElem
