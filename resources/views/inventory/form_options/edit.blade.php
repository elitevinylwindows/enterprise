@foreach ($group->options as $option)
<div class="modal fade" id="editOptionModal-{{ $option->id }}" tabindex="-1" aria-labelledby="editOptionModalLabel-{{ $option->id }}" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form method="POST" action="{{ route('form-options.options.update', $option->id) }}">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit Option</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          {{-- REGULAR --}}
          @if (!Str::contains(strtolower($group->name), 'glass') && !Str::contains(strtolower($group->name), 'reinforcement'))
            <div class="mb-3">
              <label class="form-label">Option Name</label>
              <input type="text" name="option_name" class="form-control" value="{{ $option->option_name }}" required>
            </div>

            <div class="row g-3 mb-3 align-items-center">
              <div class="col-md-6">
                <input type="text" name="sub_option" class="form-control sub-option-field" value="{{ $option->sub_option }}" placeholder="Sub Option" style="{{ $option->sub_option ? '' : 'display:none' }}">
              </div>
              <div class="col-auto">
                <div class="form-check">
                  <input class="form-check-input sub-option-toggle" type="checkbox" id="editSubToggle{{ $option->id }}" {{ $option->sub_option ? 'checked' : '' }}>
                  <label class="form-check-label small" for="editSubToggle{{ $option->id }}">Sub</label>
                </div>
              </div>
            </div>

            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" name="is_default" value="1" {{ $option->is_default ? 'checked' : '' }}>
              <label class="form-check-label">Set as default</label>
            </div>

          {{-- REINFORCEMENT --}}
          @elseif(Str::contains(strtolower($group->name), 'reinforcement'))
            <label class="form-label">Reinforcement Sizes</label>
            <div id="editReinforceRows{{ $option->id }}">
              @php $sizes = json_decode($option->size_json ?? '[]', true); @endphp
              @foreach ($sizes as $i => $row)
                <div class="row g-2 mb-2 reinforce-size-row">
                  <div class="col-md-5">
                    <input type="text" name="sizes[{{ $i }}][size]" class="form-control" value="{{ $row['size'] ?? '' }}" placeholder="Size">
                  </div>
                  <div class="col-md-5">
                    <input type="text" name="sizes[{{ $i }}][name]" class="form-control" value="{{ $row['name'] ?? '' }}" placeholder="Option Name">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-danger w-100 remove-reinforce-row">&times;</button>
                  </div>
                </div>
              @endforeach
            </div>
            <button type="button" class="btn btn-sm btn-primary" onclick="addReinforceRow({{ $option->id }})">+ Add Size</button>

            <div class="form-check mt-3">
              <input class="form-check-input" type="checkbox" name="is_default" value="1" {{ $option->is_default ? 'checked' : '' }}>
              <label class="form-check-label">Set as default</label>
            </div>

          {{-- GLASS TYPE --}}
          @elseif(Str::contains(strtolower($group->name), 'glass'))
            <div class="mb-3">
              <label class="form-label">Option Name</label>
              <input type="text" name="option_name" class="form-control" value="{{ $option->option_name }}" required>
            </div>

            @php
              $rows = json_decode($option->thickness_json ?? '[]', true);
            @endphp
            <label class="form-label">Glass Pricing</label>
            @foreach ($rows as $i => $row)
              <div class="row mb-2">
                <div class="col-md-4">
                  <input type="text" class="form-control" value="{{ $row['thickness'] ?? '' }}" readonly>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control" value="{{ $row['fraction'] ?? '' }}" readonly>
                </div>
                <div class="col-md-4">
                  <input type="text" name="thickness_json[{{ $i }}][price]" class="form-control" value="{{ $row['price'] ?? '' }}" placeholder="Price">
                </div>
              </div>
            @endforeach

            <div class="form-check mt-3">
              <input class="form-check-input" type="checkbox" name="is_default" value="1" {{ $option->is_default ? 'checked' : '' }}>
              <label class="form-check-label">Set as default</label>
            </div>
          @endif
        </div>

        <div class="modal-footer">
          <button class="btn btn-primary">Update Option</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

@push('scripts')
<script>
function addReinforceRow(optionId) {
  const container = document.getElementById(`editReinforceRows${optionId}`);
  const index = container.querySelectorAll('.reinforce-size-row').length;
  const row = document.createElement('div');
  row.className = 'row g-2 mb-2 reinforce-size-row';
  row.innerHTML = `
    <div class="col-md-5">
      <input type="text" name="sizes[${index}][size]" class="form-control" placeholder="Size">
    </div>
    <div class="col-md-5">
      <input type="text" name="sizes[${index}][name]" class="form-control" placeholder="Option Name">
    </div>
    <div class="col-md-2">
      <button type="button" class="btn btn-sm btn-danger w-100 remove-reinforce-row">&times;</button>
    </div>`;
  container.appendChild(row);
}

document.addEventListener('click', function (e) {
  if (e.target.classList.contains('remove-reinforce-row')) {
    e.target.closest('.reinforce-size-row')?.remove();
  }
});
</script>
@endpush
