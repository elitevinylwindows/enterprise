<form action="<?php echo e(route('master.series-type.update', $seriesType->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="modal-header">
        <h5 class="modal-title">Edit Series Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="series_id">Series</label>
            <select name="series_id" class="form-control" required>
                <?php $__currentLoopData = $series; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>" <?php echo e($seriesType->series_id == $s->id ? 'selected' : ''); ?>>
                        <?php echo e($s->series); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Series Type</label>
            <div id="series_type_tags_<?php echo e($seriesType->id); ?>" class="mb-2"></div>
            <input type="text" id="series_type_input_<?php echo e($seriesType->id); ?>" class="form-control" placeholder="Type and press enter">
            <input type="hidden" name="series_type" id="series_type_hidden_<?php echo e($seriesType->id); ?>">
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        (function () {
            const input = document.getElementById('series_type_input_<?php echo e($seriesType->id); ?>');
            const tagsContainer = document.getElementById('series_type_tags_<?php echo e($seriesType->id); ?>');
            const hiddenInput = document.getElementById('series_type_hidden_<?php echo e($seriesType->id); ?>');
            let tags = [];

            const existingTags = <?php echo json_encode(json_decode($seriesType->series_type, true), 512) ?>;
            if (existingTags && Array.isArray(existingTags)) {
                existingTags.forEach(t => {
                    if (t.trim() && !tags.includes(t.trim())) addTag(t.trim());
                });
            }

            input?.addEventListener('keypress', function (e) {
                if (e.key === 'Enter' && input.value.trim() !== '') {
                    e.preventDefault();
                    const tagText = input.value.trim();
                    if (!tags.includes(tagText)) {
                        addTag(tagText);
                        input.value = '';
                    }
                }
            });

            function addTag(tagText) {
                tags.push(tagText);
                const tag = document.createElement('span');
                tag.className = 'badge bg-primary me-1 mb-1';
                tag.dataset.value = tagText;
                tag.innerHTML = `${tagText} <span style="cursor:pointer;" class="remove-tag" data-id="<?php echo e($seriesType->id); ?>" data-value="${tagText}">&times;</span>`;
                tagsContainer.appendChild(tag);
                updateHidden();
            }

            tagsContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-tag')) {
                    const value = e.target.dataset.value;
                    tags = tags.filter(tag => tag !== value);
                    e.target.parentElement.remove();
                    updateHidden();
                }
            });

            function updateHidden() {
                hiddenInput.value = tags.join(',');
            }
        })();
    });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/master/series/series_type/edit.blade.php ENDPATH**/ ?>