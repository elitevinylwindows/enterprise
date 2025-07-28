<div class="modal fade" id="createPlannedRouteModal" tabindex="-1" aria-labelledby="createPlannedRouteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('routes.plan.optimize') }}" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="createPlannedRouteLabel">Create Planned Route</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="delivery_date_modal" class="form-label">Delivery Date</label>
          <input type="date" name="delivery_date" id="delivery_date_modal" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="max_stops_modal" class="form-label">Max Stops Per Truck</label>
          <input type="number" name="max_stops" id="max_stops_modal" class="form-control" value="10" min="1" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Create</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>
