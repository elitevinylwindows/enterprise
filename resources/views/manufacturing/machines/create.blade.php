{{-- resources/views/manufacturing/machines/create.blade.php --}}
<form method="POST" action="{{ route('manufacturing.machines.store') }}" id="machineCreateForm">
  @csrf

  <div class="px-4 pt-3">
    {{-- Row 1: Machine + File Type --}}
    <div class="row g-3 align-items-end">
      <div class="col-md-6">
        <label class="form-label">{{ __('Machine') }}</label>
        <input type="text"
               name="machine"
               class="form-control @error('machine') is-invalid @enderror"
               placeholder="{{ __('e.g., Bottero 352 Glass Cutter') }}"
               value="{{ old('machine') }}"
               required>
        @error('machine')
          <div class="invalid-feedback">{{ $message }}</div>
        @else
          <div class="form-text">{{ __('Machine names are unique.') }}</div>
        @enderror
      </div>

      <div class="col-md-4">
        <label class="form-label">{{ __('File Type') }}</label>
        <select name="file_type"
                class="form-select @error('file_type') is-invalid @enderror"
                required>
          @php($types = ['csv' => 'CSV', 'xml' => 'XML', 'other' => 'Other'])
          @foreach ($types as $v => $l)
            <option value="{{ $v }}" {{ old('file_type') === $v ? 'selected' : '' }}>{{ $l }}</option>
          @endforeach
        </select>
        @error('file_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>

    {{-- Row 2: File Path (left) + Description (right) --}}
    <div class="row g-3 mt-2">
      <div class="col-md-6">
        <label class="form-label">{{ __('File Path') }}</label>
        <div class="input-group">
          <input type="text"
                 name="file_path"
                 id="file_path"
                 class="form-control @error('file_path') is-invalid @enderror"
                 placeholder="{{ __('e.g., \\\\SERVER\\share\\machines\\bottero or /mnt/machines/bottero') }}"
                 value="{{ old('file_path') }}">
          <button type="button" class="btn btn-outline-light" id="pickFolderBtn">
            <i class="fa-solid fa-folder-open"></i> {{ __('Choose Folder') }}
          </button>
        </div>
        @error('file_path') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        <div class="form-text">
          {{ __('Enter a network/server path, or click “Choose Folder”. Browsers only expose a folder name (not the full local path).') }}
        </div>

        {{-- Hidden directory picker (Chrome/Edge/Safari) --}}
        <input type="file" id="folderPicker" webkitdirectory directory multiple class="d-none">
      </div>

      <div class="col-md-6">
        <label class="form-label">
          {{ __('Description') }}
          <span class="text-muted small">({{ __('optional') }})</span>
        </label>
        <textarea name="description"
                  rows="3"
                  class="form-control @error('description') is-invalid @enderror"
                  placeholder="{{ __('Optional notes or capabilities') }}">{{ old('description') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>
  </div>

  <div class="modal-footer px-4">
    <button type="submit" class="btn btn-primary">{{ __('Create Machine') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

{{-- Tiny helper to grab a folder name for display --}}
<script>
  (function(){
    const btn   = document.getElementById('pickFolderBtn');
    const input = document.getElementById('folderPicker');
    const dest  = document.getElementById('file_path');

    btn?.addEventListener('click', () => input?.click());

    input?.addEventListener('change', () => {
      if (!input.files || input.files.length === 0) return;
      // First file’s relative path gives us "FolderName/file.ext"
      const rel = input.files[0].webkitRelativePath || '';
      const folder = rel.split('/')[0] || '';
      if (folder) {
        // Put just the folder label; keep editable so user can paste a true server path if desired
        if (!dest.value) dest.value = folder;
      }
    });
  })();
</script>
