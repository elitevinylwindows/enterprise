<div class="modal fade" id="addOptionModal" tabindex="-1" aria-labelledby="addOptionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form method="POST" action="<?php echo e(route('form-options.options.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="modal-header">
          <h5 class="modal-title">Add Option</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>



       <div class="modal-body">
  
  <div class="mb-3">
    <label class="form-label">Group Name</label>
    <input type="text" name="name" class="form-control" required>
  </div>

  
  <div class="mb-3">
    <label class="form-label">Series</label>
    <select name="series_id" class="form-control" required>
      <option value="">Select Series</option>
      <?php $__currentLoopData = $seriesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $series): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($series->id); ?>"><?php echo e($series->name); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
  </div>

  
  <div class="mb-3">
    <label class="form-label">Condition (Optional)</label>
    <input type="text" name="condition" class="form-control" placeholder="e.g., color=white">
  </div>




          
          <div id="regularOptionsContainer">
            <div class="row g-3 mb-2 align-items-center option-row">
              <div class="col-md-4">
                <input type="text" name="options[0][name]" class="form-control" placeholder="Option Name">
              </div>
              <div class="col-md-2 sub-col">
                <input type="checkbox" name="options[0][sub_option]" class="form-check-input">
                <label class="form-check-label">Sub</label>
              </div>
              <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-danger remove-option">&times;</button>
              </div>
            </div>
          </div>



<div class="mb-3 default-toggle">
  <input type="checkbox" id="setAsDefault" name="is_default" class="form-check-input">
  <label class="form-check-label" for="setAsDefault">Set as Default</label>
</div>

  
          
          <div id="glassSetsContainer" style="display: none;">
            <div class="glass-set mb-3">
              <div class="mb-2">
                <label class="form-label">Option Name</label>
                <input type="text" name="glass_sets[0][name]" class="form-control" placeholder="e.g. Clear, Frosted">
              </div>
              <?php
                $glassRows = [
                    ['thickness' => '3.1 MM', 'fraction' => '1/8'],
                    ['thickness' => '3.9 MM', 'fraction' => '5/32'],
                    ['thickness' => '4.7 MM', 'fraction' => '3/16'],
                    ['thickness' => '5.7 MM', 'fraction' => '1/4'],
                ];
              ?>
              <?php $__currentLoopData = $glassRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="row mb-2">
                <div class="col-md-4">
                  <input type="text" class="form-control" value="<?php echo e($row['thickness']); ?>" readonly>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control" value="<?php echo e($row['fraction']); ?>" readonly>
                </div>
                <div class="col-md-4">
                  <input type="text" name="glass_sets[0][prices][<?php echo e($i); ?>]" class="form-control" placeholder="Price">
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>

          <button type="button" id="add-more-options" class="btn btn-danger btn-sm mb-3">+ Add More Options</button>
        </div>
        
        

<div id="reinforcementOptionsContainer" style="display: none;">
  <div class="reinforce-size-rows-wrapper">
<div class="row g-2 mb-4 ms-2 reinforce-size-row">
    <div class="col-md-4">
        <input type="text" name="reinforce_option[sizes][0][size]" class="form-control" placeholder="Size (e.g. 12)">
      </div>
      <div class="col-md-4">
        <input type="text" name="reinforce_option[sizes][0][name]" class="form-control" placeholder="Option Name">
      </div>
      
      <div class="col-md-1">
        <button type="button" class="btn btn-sm btn-danger w-100 remove-reinforce-size">&times;</button>
      </div>
    </div>
  </div>
</div>



        <div class="modal-footer">
          <button class="btn btn-primary">Add Option</button>
        </div>
      </form>
    </div>
  </div>
</div>


<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('addOptionModal');

  modal.addEventListener('shown.bs.modal', function () {
    const groupSelect = modal.querySelector('#groupSelect');
    const defaultToggle = modal.querySelector('.default-toggle');
    const subCols = modal.querySelectorAll('.sub-col');
    const regularOptionsContainer = modal.querySelector('#regularOptionsContainer');
    const glassSetsContainer = modal.querySelector('#glassSetsContainer');
    const reinforceContainer = modal.querySelector('#reinforcementOptionsContainer');
    const reinforceWrapper = modal.querySelector('.reinforce-size-rows-wrapper');
    const addMoreBtn = modal.querySelector('#add-more-options');

    let reinforceIndex = 1;
    let regularIndex = 1;
    let glassIndex = 1;

    function toggleSections() {
      const selectedText = groupSelect.options[groupSelect.selectedIndex].text.toLowerCase();
      const isGlass = selectedText.includes('glass type');
      const isReinforcement = selectedText.includes('sash reinforcement') || selectedText.includes('mull reinforcement');

      regularOptionsContainer.style.display = (!isGlass && !isReinforcement) ? 'block' : 'none';
      glassSetsContainer.style.display = isGlass ? 'block' : 'none';
      reinforceContainer.style.display = isReinforcement ? 'block' : 'none';

      defaultToggle.style.display = (!isGlass && !isReinforcement) ? 'block' : 'none';
      subCols.forEach(el => el.style.display = (!isGlass && !isReinforcement) ? 'block' : 'none');
    }

    groupSelect.addEventListener('change', toggleSections);
    toggleSections(); // Initial run

    addMoreBtn.addEventListener('click', function () {
      const selectedText = groupSelect.options[groupSelect.selectedIndex].text.toLowerCase();
      const isGlass = selectedText.includes('glass type');
      const isReinforcement = selectedText.includes('sash reinforcement') || selectedText.includes('mull reinforcement');

      if (isReinforcement) {
        const row = document.createElement('div');
row.classList.add('row', 'g-2', 'mb-2', 'ms-2', 'reinforce-size-row');
       row.innerHTML = `
  
  <div class="col-md-4">
    <input type="text" name="reinforce_option[sizes][${reinforceIndex}][size]" class="form-control" placeholder="Size (e.g. 12)">
  </div>
  <div class="col-md-4">
    <input type="text" name="reinforce_option[sizes][${reinforceIndex}][name]" class="form-control" placeholder="Option Name">
  </div>
  <div class="col-md-1">
    <button type="button" class="btn btn-sm btn-danger w-100 remove-reinforce-size">&times;</button>
  </div>`;

        reinforceWrapper.appendChild(row);
        reinforceIndex++;
        return;
      }

      if (isGlass) {
        const wrapper = document.createElement('div');
        wrapper.classList.add('glass-set', 'mb-3');

        let html = `
          <div class="mb-2">
            <label class="form-label">Option Name</label>
            <input type="text" name="glass_sets[${glassIndex}][name]" class="form-control" placeholder="e.g. Clear, Frosted">
          </div>`;

        const thicknesses = ['3.1 MM', '3.9 MM', '4.7 MM', '5.7 MM'];
        const fractions = ['1/8', '5/32', '3/16', '1/4'];

        for (let i = 0; i < 4; i++) {
          html += `
            <div class="row mb-2">
              <div class="col-md-4"><input type="text" class="form-control" value="${thicknesses[i]}" readonly></div>
              <div class="col-md-4"><input type="text" class="form-control" value="${fractions[i]}" readonly></div>
              <div class="col-md-4"><input type="text" name="glass_sets[${glassIndex}][prices][${i}]" class="form-control" placeholder="Price"></div>
            </div>`;
        }

        wrapper.innerHTML = html;
        glassSetsContainer.appendChild(wrapper);
        glassIndex++;
        return;
      }

      // Default option row (regular group)
      const row = document.createElement('div');
      row.classList.add('row', 'g-3', 'mb-2', 'align-items-center', 'option-row');
      row.innerHTML = `
        <div class="col-md-4">
          <input type="text" name="options[${regularIndex}][name]" class="form-control" placeholder="Option Name">
        </div>
        <div class="col-md-2 sub-col">
          <input type="checkbox" name="options[${regularIndex}][sub_option]" class="form-check-input">
          <label class="form-check-label">Sub</label>
        </div>
        <div class="col-md-1">
          <button type="button" class="btn btn-sm btn-danger remove-option">&times;</button>
        </div>`;
      regularOptionsContainer.appendChild(row);
      regularIndex++;
    });

    // Remove handlers
    modal.addEventListener('click', function (e) {
      if (e.target.classList.contains('remove-option')) {
        e.target.closest('.option-row')?.remove();
      }
      if (e.target.classList.contains('remove-reinforce-size')) {
        e.target.closest('.reinforce-size-row')?.remove();
      }
    });
  });
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/inventory/form_options/create.blade.php ENDPATH**/ ?>