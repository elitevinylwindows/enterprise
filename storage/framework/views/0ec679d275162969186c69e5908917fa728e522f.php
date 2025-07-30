<!-- Add Tier Modal -->
<div class="modal fade" id="addTierModal" tabindex="-1" aria-labelledby="addTierModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="<?php echo e(route('executives.tiers.store')); ?>" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="addTierModalLabel">Add New Tier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tier Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Gold, Silver" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Benefits</label>
                    <textarea name="benefits" rows="4" class="form-control" placeholder="List the benefits..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Create Tier</button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/executives/tiers/create.blade.php ENDPATH**/ ?>