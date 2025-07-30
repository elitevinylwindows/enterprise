<!-- Edit Tier Modal -->
<div class="modal fade" id="editTierModal-<?php echo e($tier->id); ?>" tabindex="-1" aria-labelledby="editTierModalLabel-<?php echo e($tier->id); ?>" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="<?php echo e(route('executives.tiers.update', $tier->id)); ?>" class="modal-content">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="editTierModalLabel-<?php echo e($tier->id); ?>">Edit Tier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tier Name</label>
                    <input type="text" name="name" value="<?php echo e($tier->name); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Benefits</label>
                    <textarea name="benefits" class="form-control" rows="4" required><?php echo e($tier->benefits); ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Update Tier</button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/executives/tiers/edit.blade.php ENDPATH**/ ?>