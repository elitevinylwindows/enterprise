<form action="{{ route('prices.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Add Material</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body row">
        <div class="mb-3 col-md-6">
            <label for="material_name" class="form-label">Material Name</label>
            <input type="text" name="material_name" class="form-control" required>
        </div>

        <div class="mb-3 col-md-6">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3 col-md-6">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" name="unit" id="unit" class="form-control">
        </div>

        <div class="mb-3 col-md-6">
            <label for="vendor" class="form-label">Vendor</label>
            <input type="text" name="vendor" class="form-control">
        </div>

        <div class="mb-3 col-md-6">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01">
        </div>

        <div class="mb-3 col-md-6">
            <label for="sold_by" class="form-label">Sold By</label>
            <select name="sold_by" id="sold_by" class="form-control">
                <option value="">Select</option>
                @foreach(['By BOX', 'By PCs', 'By Roll', 'By BND', 'By Tube', 'By Spool'] as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-md-6">
            <label for="lin_pcs" class="form-label">L in/Each PCS</label>
            <input type="text" name="lin_pcs" id="lin_pcs" class="form-control" readonly>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save</button>
    </div>
</form>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function setupCalculation(modalId = '') {
        const prefix = modalId ? `#${modalId} ` : '';
        const priceEl = document.querySelector(`${prefix}#price`);
        const unitEl = document.querySelector(`${prefix}#unit`);
        const soldByEl = document.querySelector(`${prefix}#sold_by`);
        const linEl = document.querySelector(`${prefix}#lin_pcs`);

        function extractCount(unit) {
            const match = unit.match(/(\d+)\s*pcs?/i);
            return match ? parseInt(match[1]) : 0;
        }

        function getDefaultCount(soldBy) {
            const defaultGroups = ['by pcs', 'by tube', 'by box', 'by roll', 'by bnd', 'by spool'];
            return defaultGroups.includes((soldBy || '').toLowerCase()) ? 1 : 0;
        }

        function recalculate() {
            const price = parseFloat(priceEl?.value || 0);
            const unit = unitEl?.value || '';
            const soldBy = soldByEl?.value || '';

            let count = extractCount(unit);
            if (!count) count = getDefaultCount(soldBy);

            let result = '';
            if (count > 0 && price > 0) {
                result = (price / count).toFixed(5);
            }

            if (linEl) linEl.value = result;
        }

        [priceEl, unitEl, soldByEl].forEach(el => {
            if (el) {
                el.addEventListener('input', recalculate);
                el.addEventListener('change', recalculate);
            }
        });

        // Recalculate once on load
        recalculate();
    }

    // For static create modal
    setupCalculation();

    // For dynamically loaded edit modal (with ID "editPriceModal" or similar)
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('shown.bs.modal', function () {
            const modalId = modal.getAttribute('id');
            setupCalculation(modalId);
        });
    });
});
</script>
@endpush
