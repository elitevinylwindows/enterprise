<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" action="<?php echo e(route('executives.customers.update', $customer->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="modal-header">
          <h5 class="modal-title" id="editCustomerLabel">Edit Customer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Customer Number</label>
              <input type="text" name="customer_number" class="form-control" value="<?php echo e($customer->customer_number); ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Customer Name</label>
              <input type="text" name="name" class="form-control" value="<?php echo e($customer->name); ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Street</label>
              <input type="text" name="street" class="form-control" value="<?php echo e($customer->street); ?>">
            </div>
            <div class="col-md-3">
              <label class="form-label">City</label>
              <input type="text" name="city" class="form-control" value="<?php echo e($customer->city); ?>">
            </div>
            <div class="col-md-3">
              <label class="form-label">ZIP Code</label>
              <input type="text" name="zip" class="form-control" value="<?php echo e($customer->zip); ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tier</label>
              <select name="tier_id" class="form-control">
                <?php $__currentLoopData = $tiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($tier->id); ?>" <?php if($tier->id == $customer->tier_id): ?> selected <?php endif; ?>>
                    <?php echo e($tier->name); ?>

                  </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Status</label>
              <select name="status" class="form-control">
                <option value="active" <?php if($customer->status === 'active'): ?> selected <?php endif; ?>>Active</option>
                <option value="inactive" <?php if($customer->status === 'inactive'): ?> selected <?php endif; ?>>Inactive</option>
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update Customer</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/executives/customers/edit.blade.php ENDPATH**/ ?>