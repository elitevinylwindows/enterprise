<form action="{{ route('master.series-configuration.import.upload') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="p-3">
    <div class="mb-2 text-muted small">
      {{ __('Upload a file with columns: Series | Type1 | Type2 | Type3 | Type4') }}
    </div>

    <div class="table-responsive mb-3">
      <table class="table table-sm table-bordered align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>{{ __('Series') }}</th>
            <th>{{ __('Type1') }}</th>
            <th>{{ __('Type2') }}</th>
            <th>{{ __('Type3') }}</th>
            <th>{{ __('Type4') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>XO</td>
            <td>2101</td>
            <td>2201</td>
            <td>2301</td>
            <td>2801</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mb-3">
      <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".xlsx,.xls,.csv" required>
      @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="d-flex justify-content-end gap-2">
      <button type="submit" class="btn btn-primary">
        <i class="fa-solid fa-cloud-arrow-up"></i> {{ __('Import') }}
      </button>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    </div>
  </div>
</form>
