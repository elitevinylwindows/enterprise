<!-- Job Create Modal -->
<div class="modal fade" id="createJobModal" tabindex="-1" aria-labelledby="createJobLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form method="POST" action="{{ route('manufacturing.job_planning.store') }}" id="jobCreateForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Job</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          {{-- Row 1 --}}
          <div class="row mb-3">
            <div class="col-md-4">
              <label>Order ID</label>
              <input type="number" name="order_id" class="form-control" placeholder="Internal Order ID" required>
              <small class="text-muted">Link this job to an existing order.</small>
            </div>
            <div class="col-md-4">
              <label>Status</label>
              <select name="status" class="form-control" required>
                @foreach(['unprocessed'=>'Unprocessed','processed'=>'Processed','tempered'=>'Tempered','active'=>'Active','draft'=>'Draft'] as $v=>$l)
                  <option value="{{ $v }}">{{ $l }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label>Priority</label>
              <input type="number" name="priority" class="form-control" min="0" step="1" value="0">
            </div>
          </div>

          {{-- Row 2 --}}
          <div class="row mb-3">
            <div class="col-md-6">
              <label>Station</label>
              @if(isset($stations) && count($stations))
                <select name="station" class="form-control">
                  @foreach($stations as $s)
                    <option value="{{ $s->station_number }}">{{ $s->station_number }} — {{ $s->description }}</option>
                  @endforeach
                </select>
              @else
                <input type="text" name="station" class="form-control" placeholder="e.g., ST-01">
              @endif
            </div>
            <div class="col-md-6">
              <label>Description</label>
              <input type="text" name="description" class="form-control" placeholder="Short description (optional)">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create Job</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
