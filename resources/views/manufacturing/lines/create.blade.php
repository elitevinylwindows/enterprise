{{-- Modal PARTIAL: Create Line --}}
<form method="POST" action="{{ route('manufacturing.lines.store') }}" id="lineCreateForm">
  @csrf

  <div class="row gy-3 px-1 px-md-2">
    <div class="col-md-4">
      <label class="form-label">{{ __('Line') }}</label>
      <input type="text" name="line" class="form-control" placeholder="e.g., Line A" value="{{ old('line') }}" required>
      @error('line') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
      <label class="form-label">{{ __('Status') }}</label>
      <select name="status" class="form-control" required>
        <option value="active" {{ old('status','active') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
      </select>
      @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-12">
      <label class="form-label">{{ __('Description') }}</label>
      <textarea name="description" rows="3" class="form-control" placeholder="{{ __('Brief description') }}">{{ old('description') }}</textarea>
      @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="mt-4 d-flex justify-content-end gap-2">
    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>
