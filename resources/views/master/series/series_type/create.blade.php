<form action="{{ route('master.series-type.store') }}" method="POST">
    @csrf
    <div class="modal-header"><h5 class="modal-title">Add Series Type</h5></div>
    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="series_id">Series</label>
            <select name="series_id" class="form-control" required>
                @foreach($series as $s)
                    <option value="{{ $s->id }}">{{ $s->series }}</option>
                @endforeach
            </select>
        </div>

       
<div class="row">
    <div class="col-md-6">
<div class="form-group mb-3">
    <label for="series_type">Series Type</label>
    <input type="text" id="series_type_input" class="form-control" placeholder="Type and press enter">
    <div id="series_type_tags" class="mt-2"></div>
    <input type="hidden" name="series_type" id="series_type_hidden">
</div>
</div>
 <div class="col-md-6">
    <div class="form-group mb-3">
    <label for="series_type">Product ID</label>
    <input type="text" id="series_type_input" class="form-control" placeholder="Enter Product ID">
    <div id="series_type_tags" class="mt-2"></div>
    <input type="hidden" name="series_type" id="series_type_hidden">
</div>
    </div>
    </div>
</div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>


@push('scripts')
<script>
    const input = document.getElementById('series_type_input');
    const tagsContainer = document.getElementById('series_type_tags');
    const hiddenInput = document.getElementById('series_type_hidden');
    let tags = [];

    input.addEventListener('keypress', function (e) {
        if (e.key === 'Enter' && input.value.trim() !== '') {
            e.preventDefault();
            const tagText = input.value.trim();

            if (!tags.includes(tagText)) {
                tags.push(tagText);

                const tag = document.createElement('span');
                tag.className = 'badge bg-primary me-1 mb-1';
                tag.innerHTML = `${tagText} <span class="ms-1" style="cursor:pointer;" onclick="removeTag('${tagText}')">&times;</span>`;
                tag.dataset.value = tagText;
                tagsContainer.appendChild(tag);

                updateHiddenInput();
            }

            // ✅ Clear the input AFTER processing
            input.value = '';
        }
    });

    function removeTag(value) {
        tags = tags.filter(tag => tag !== value);
        const badges = document.querySelectorAll('#series_type_tags .badge');
        badges.forEach(badge => {
            if (badge.dataset.value === value) {
                badge.remove();
            }
        });
        updateHiddenInput();
    }

    function updateHiddenInput() {
        hiddenInput.value = tags.join(',');
    }
</script>
@endpush
