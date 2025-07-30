<!-- Edit Supplier Modal -->
<div class="modal fade" id="editSupplierModal<?php echo e($supplier->id); ?>" tabindex="-1" aria-labelledby="editSupplierModalLabel<?php echo e($supplier->id); ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="<?php echo e(route('master.suppliers.update', $supplier->id)); ?>">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editSupplierModalLabel<?php echo e($supplier->id); ?>">Edit Supplier</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label>Supplier Number</label>
            <input type="text" name="supplier_number" value="<?php echo e($supplier->supplier_number); ?>" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo e($supplier->name); ?>" class="form-control" required>
          </div>

          <!-- Supplier Type Radios -->
          <div class="col-md-12">
            <label>Supplier Type</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="supplier_type" id="individual<?php echo e($supplier->id); ?>" value="individual" <?php echo e($supplier->supplier_type == 'individual' ? 'checked' : ''); ?>>
              <label class="form-check-label" for="individual<?php echo e($supplier->id); ?>">Individual</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="supplier_type" id="organization<?php echo e($supplier->id); ?>" value="organization" <?php echo e($supplier->supplier_type == 'organization' ? 'checked' : ''); ?>>
              <label class="form-check-label" for="organization<?php echo e($supplier->id); ?>">Organization</label>
            </div>
          </div>

          <div class="col-md-6">
            <label>Street</label>
            <input type="text" name="street" value="<?php echo e($supplier->street); ?>" class="form-control">
          </div>
          <div class="col-md-6">
            <label>City</label>
            <input type="text" name="city" value="<?php echo e($supplier->city); ?>" class="form-control">
          </div>
          <div class="col-md-4">
            <label>ZIP</label>
            <input type="text" name="zip" value="<?php echo e($supplier->zip); ?>" class="form-control">
          </div>
          <div class="col-md-4">
            <label>Country</label>
            <input type="text" name="country" value="<?php echo e($supplier->country); ?>" class="form-control">
          </div>
          <div class="col-md-4">
            <label>Status</label>
            <select name="status" class="form-control">
              <option value="active" <?php echo e($supplier->status == 'active' ? 'selected' : ''); ?>>Active</option>
              <option value="inactive" <?php echo e($supplier->status == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
            </select>
          </div>

          <div class="col-md-6">
            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo e($supplier->phone); ?>" class="form-control">
          </div>
          <div class="col-md-6">
            <label>Website</label>
            <input type="text" name="website" value="<?php echo e($supplier->website); ?>" class="form-control">
          </div>

          <div class="col-md-6">
            <label>Client Group</label>
            <input type="text" name="client_group" value="<?php echo e($supplier->client_group); ?>" class="form-control">
          </div>

          <div class="col-md-3">
            <label>Currency</label>
            <input type="text" name="currency" value="<?php echo e($supplier->currency); ?>" class="form-control">
          </div>
          <div class="col-md-3">
            <label>Currency Symbol</label>
            <input type="text" name="currency_symbol" value="<?php echo e($supplier->currency_symbol); ?>" class="form-control">
          </div>

          <div class="col-md-6">
            <label>Label</label>
            <input type="text" name="label" value="<?php echo e($supplier->label); ?>" class="form-control">
          </div>

          <div class="col-md-3">
            <label>EIN Number</label>
            <input type="text" name="ein_number" value="<?php echo e($supplier->ein_number); ?>" class="form-control">
          </div>
          <div class="col-md-3">
            <label>License Number</label>
            <input type="text" name="license_number" value="<?php echo e($supplier->license_number); ?>" class="form-control">
          </div>

          <div class="col-md-6 d-flex align-items-center">
            <div class="form-check mt-4">
              <input class="form-check-input" type="checkbox" name="disable_payment" value="1" id="disable_payment<?php echo e($supplier->id); ?>" <?php echo e($supplier->disable_payment ? 'checked' : ''); ?>>
              <label class="form-check-label" for="disable_payment<?php echo e($supplier->id); ?>">Disable Payment</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Update Supplier</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/master/suppliers/edit.blade.php ENDPATH**/ ?>