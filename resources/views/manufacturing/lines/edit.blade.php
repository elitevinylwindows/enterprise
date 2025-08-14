{{-- Modal PARTIAL: Edit Line --}}
<form method="POST" action="{{ route('manufacturing.lines.update', $line->id) }}" id="lineEditForm">
  @csrf
  @method('PUT')

  <div class="row gy-3 px-1 px-md-2">
    <div class="col-md-4">
      <label class="form-label">{{ __('Line') }}</label>
      <input type="text" name="line" class="form-control" value="{{ old('line', $line->line) }}" required>
      @error('line') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
      <label class="form-label">{{ __('Status') }}</label>
      <select name="status" class="form-control" required>
        <option value="active"   {{ old('status', $line->status) === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
        <option value="inactive" {{ old('status', $line->status) === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
      </select>
      @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-12">
      <label class="form-label">{{ __('Description') }}</label>
      <textarea name="description" rows="3" class="form-control">{{ old('description', $line->description) }}</textarea>
      @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="mt-4 d-flex justify-content-end gap-2">
    <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>
