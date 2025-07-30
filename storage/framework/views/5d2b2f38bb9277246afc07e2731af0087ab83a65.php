<form action="<?php echo e(route('mullstack.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="modal-header">
        <h5 class="modal-title">Add MullStack</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>MullStack</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group mt-3">
            <label>Color</label>
            <select name="color" class="form-select" required>
                <option value="white">White</option>
                <option value="black">Black</option>
                <option value="almond">Almond</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/bill_of_material/menu/MullStack/create.blade.php ENDPATH**/ ?>