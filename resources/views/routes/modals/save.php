<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('routes.plan.optimize') }}" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label for="delivery_date" class="form-label">Delivery Date</label>
                <input type="date" id="delivery_date" name="delivery_date" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="max_stops" class="form-label">Max Stops Per Truck</label>
                <input type="number" id="max_stops" name="max_stops" class="form-control" value="10" min="1" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Create Planned Route</button>
            </div>
        </form>
    </div>
</div>