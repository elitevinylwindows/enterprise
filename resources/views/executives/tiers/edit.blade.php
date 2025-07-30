<!-- Edit Tier Modal -->
<div class="modal fade" id="editTierModal-{{ $tier->id }}" tabindex="-1" aria-labelledby="editTierModalLabel-{{ $tier->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('executives.tiers.update', $tier->id) }}" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="editTierModalLabel-{{ $tier->id }}">Edit Tier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tier Name</label>
                    <input type="text" name="name" value="{{ $tier->name }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Percentage</label>
                    <input type="number" name="percentage" value="{{ number_format($tier->percentage, 2) }}" class="form-control" required step="0.01" min="0" max="100">
                </div>
                <div class="mb-3">
                    <label class="form-label">Benefits</label>
                    <textarea name="benefits" class="form-control" rows="4" required>{{ $tier->benefits }}</textarea>
                </div>
               
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Update Tier</button>
            </div>
        </form>
    </div>
</div>
