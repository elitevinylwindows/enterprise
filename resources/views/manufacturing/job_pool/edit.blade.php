      <form method="POST" action="{{ route('manufacturing.job_pool.store') }}" id="jobPoolCreateForm">
          @csrf

          <div class="modal-body">
              <div class="row mb-3">
                  <div class="col-md-4">
                      <label>Order</label>
                      <select name="order_id" class="form-control" required>
                          <option value="">Select Order</option>
                          @foreach($orders as $order)
                          <option value="{{ $order->id }}">{{ $order->order_number }} - {{ $order->customer_name }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-md-4">
                      <label>Series</label>
                      <input type="text" name="series" id="series" class="form-control" placeholder="Enter Series" required>
                  </div>
                   <div class="col-md-4">
                      <label>Qty</label>
                      <input type="text" name="qty" id="qty" class="form-control">
                  </div>
              </div>

              <div class="row mb-3">
                 
                  <div class="col-md-4">
                      <label>Line</label>
                      <input type="text" name="line" id="line" class="form-control">
                  </div>
                    <div class="col-md-4">
                      <label>Type</label>
                      <input type="text" name="type" class="form-control">
                  </div>
                   <div class="col-md-4">
                      <label>Delivery Date</label>
                      <input type="date" name="delivery_date" class="form-control">
                  </div>
              </div>

              <div class="row mb-3">
                  <div class="col-md-4">
                      <label>Production Status</label>
                      <select name="production_status" class="form-control">
                          <option value="active">Active</option>
                          <option value="draft">Draft</option>
                      </select>
                  </div>
                   <div class="col-md-4">
                      <label>Entry Date</label>
                      <input type="date" name="entry_date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                  </div>
              </div>

          </div>

          <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Update Job Pool</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
      </form>
