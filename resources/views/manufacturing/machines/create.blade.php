{{-- resources/views/manufacturing/machines/create.blade.php --}}
<form method="POST" action="{{ route('manufacturing.machines.store') }}" id="machineCreateForm">
  @csrf

  <div class="px-4 pt-3">

    {{-- Row 1: Machine + File Type (aligned) --}}
    <div class="row g-3">
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
          <div class="form-text help-spacer">{{ __('Machine names are unique.') }}</div>
        @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">{{ __('File Type') }}</label>
        <select name="file_type" class="form-select @error('file_type') is-invalid @enderror" required>
          @php($types = ['csv' => 'CSV', 'xml' => 'XML', 'other' => 'Other'])
          @foreach ($types as $v => $l)
            <option value="{{ $v }}" {{ old('file_type') === $v ? 'selected' : '' }}>{{ $l }}</option>
          @endforeach
        </select>
        @error('file_type')
          <div class="invalid-feedback">{{ $message }}</div>
        @else
          {{-- empty spacer to match Machine helper height --}}
          <div class="form-text help-spacer">&nbsp;</div>
        @enderror
      </div>
    </div>

    {{-- Row 2: File Path (left) + Description (right) --}}
    <div class="row g-3 mt-1">
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
        <input type="file" id="folderPicker" webkitdirectory directory multiple class="d-none">
      </div>

      <div class="col-md-6">
        <label class="form-label">{{ __('Description') }} <span class="text-muted small">({{ __('optional') }})</span></label>
        <textarea name="description" rows="3"
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

<style>
  /* Ensures both columns in row 1 have the same bottom helper height */
  .help-spacer{ min-height: 22px; }
</style>

<script>
  // Folder picker helper (fills the text box with folder label)
  (function(){
    const btn = document.getElementById('pickFolderBtn');
    const picker = document.getElementById('folderPicker');
    const target = document.getElementById('file_path');

    btn?.addEventListener('click', () => picker?.click());
    picker?.addEventListener('change', () => {
      if (!picker.files || !picker.files.length) return;
      const rel = picker.files[0].webkitRelativePath || '';
      const folder = rel.split('/')[0] || '';
      if (folder && !target.value) target.value = folder;
    });
  })();
</script>
