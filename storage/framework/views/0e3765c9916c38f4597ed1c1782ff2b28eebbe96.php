<form action="<?php echo e(route('glasstype.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="modal-header">
        <h5 class="modal-title">Add Glass Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body row g-3">
        <div class="col-md-12">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">3.1 MM</label>
            <input type="text" name="thickness_3_1_mm" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">3.9 MM</label>
            <input type="text" name="thickness_3_9_mm" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">4.7 MM</label>
            <input type="text" name="thickness_4_7_mm" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">5.7 MM</label>
            <input type="text" name="thickness_5_7_mm" class="form-control">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/bill_of_material/menu/GlassType/create.blade.php ENDPATH**/ ?>