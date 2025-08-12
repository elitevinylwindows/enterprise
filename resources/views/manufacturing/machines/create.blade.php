<!-- Machine Create Modal -->
<div class="modal fade" id="createMachineModal" tabindex="-1" aria-labelledby="createMachineLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form method="POST" action="{{ route('manufacturing.machines.store') }}" id="machineCreateForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Machine</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          {{-- Row 1 --}}
          <div class="row mb-3">
            <div class="col-md-6">
              <label>Machine Name</label>
              <input type="text" name="machine" class="form-control" placeholder="e.g., Bottero 352 Glass Cutter" required>
            </div>
            <div class="col-md-6">
              <label>File Type</label>
              <select name="file_type" class="form-control" required>
                @foreach (['csv'=>'CSV','xml'=>'XML','image'=>'Image','video'=>'Video','other'=>'Other'] as $v=>$l)
                  <option value="{{ $v }}">{{ $l }}</option>
                @endforeach
              </select>
            </div>
          </div>

          {{-- (Optional) Notes --}}
          <div class="row">
            <div class="col-md-12">
              <small class="text-muted">Attach configuration formats this machine accepts via “File Type”.</small>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create Machine</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
