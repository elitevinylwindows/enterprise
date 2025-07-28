<form action="{{ route('master.series-type.update', $seriesType->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title">Edit Series Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="series_id">Series</label>
            <select name="series_id" class="form-control" required>
                @foreach($series as $s)
                    <option value="{{ $s->id }}" {{ $seriesType->series_id == $s->id ? 'selected' : '' }}>
                        {{ $s->series }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Series Type</label>
            <div id="series_type_tags_{{ $seriesType->id }}" class="mb-2"></div>
            <input type="text" id="series_type_input_{{ $seriesType->id }}" class="form-control" placeholder="Type and press enter">
            <input type="hidden" name="series_type" id="series_type_hidden_{{ $seriesType->id }}">
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        (function () {
            const input = document.getElementById('series_type_input_{{ $seriesType->id }}');
            const tagsContainer = document.getElementById('series_type_tags_{{ $seriesType->id }}');
            const hiddenInput = document.getElementById('series_type_hidden_{{ $seriesType->id }}');
            let tags = [];

            const existingTags = @json(json_decode($seriesType->series_type, true));
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
                tag.innerHTML = `${tagText} <span style="cursor:pointer;" class="remove-tag" data-id="{{ $seriesType->id }}" data-value="${tagText}">&times;</span>`;
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
@endpush
