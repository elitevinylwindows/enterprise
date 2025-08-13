<form id="jobPlanningCreateForm" method="POST" action="{{ route('manufacturing.job_planning.store') }}">
  @csrf

  <div class="px-4 pt-3"> {{-- padding inside the modal body --}}
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Job Order #</label>
        <input type="text" name="job_order_number" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Series</label>
        <input type="text" name="series" class="form-control" placeholder="e.g., LAM-WH">
      </div>
      <div class="col-md-4">
        <label class="form-label">Line</label>
        <input type="text" name="line" class="form-control" placeholder="Line # / Name">
      </div>

      <div class="col-md-4">
        <label class="form-label">Qty</label>
        <input type="number" name="qty" class="form-control" min="0" value="0">
      </div>
      <div class="col-md-4">
        <label class="form-label">Delivery Date</label>
        <input type="date" name="delivery_date" class="form-control">
      </div>
      <div class="col-md-4">
        <label class="form-label">Type</label>
        <input type="text" name="type" class="form-control" placeholder="e.g., New / Remodel">
      </div>

      <div class="col-md-4">
        <label class="form-label">Production Status</label>
        <select name="production_status" class="form-select">
          <option value="created">Created</option>
          <option value="queued">Queued</option>
          <option value="in_production">In Production</option>
          <option value="completed">Completed</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Entry Date</label>
        <input type="date" name="entry_date" class="form-control" value="{{ now()->toDateString() }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Last Transaction</label>
        <input type="datetime-local" name="last_transaction_date" class="form-control">
      </div>

      <div class="col-12">
        <label class="form-label">Internal Notes</label>
        <textarea name="internal_notes" rows="3" class="form-control" placeholder="Optional notes..."></textarea>
      </div>
    </div>
  </div>

  <div class="modal-footer px-4">
    <button type="submit" class="btn btn-primary">Save</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
  </div>
</form>
