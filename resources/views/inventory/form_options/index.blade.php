@extends('layouts.app')
        @php use Illuminate\Support\Str; @endphp

@section('page-title', 'Form Options')

@section('content')
<div class="mt-4 mb-3">
    <input type="text" id="searchCardInput" class="form-control" placeholder="Search group or condition...">
</div>
<div class="d-flex justify-content-end gap-2 mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGroupModal">
        <i class="ti ti-plus"></i> Add Group
    </button>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOptionModal">
        <i class="ti ti-plus"></i> Add Option
    </button>
</div>

<div id="cardContainer" class="row">
    @forelse($groups as $group)
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>{{ $group->name }}</strong>
                    <div>
                        @if ($group->condition)
                            <span class="badge bg-info text-dark">Condition: {{ $group->condition }}</span>
                        @endif
                        <button type="button" class="btn btn-sm btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#editGroupModal-{{ $group->id }}">
                            <i class="ti ti-pencil"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    @if($group->options->count())
                        <ul class="list-group list-group-flush">
                            @foreach($group->options as $option)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
    <div>

{{-- Reinforcement and Glass Type (custom formats) --}}
@if (Str::contains(strtolower($group->name), 'reinforcement'))
    {{ $option->name }} <br>
    <small class="text-muted">{{ $option->size }}</small>

@elseif (Str::contains(strtolower($group->name), 'glass type'))
    {{ $option->name }}
    @php
        $prices = is_array($option->prices) ? $option->prices : json_decode($option->prices, true);
    @endphp
    @if (!empty($prices))
        <ul class="mb-0 ps-3 small text-muted">
            @foreach ($prices as $row)
                <li>{{ $row['thickness'] ?? '' }} / {{ $row['fraction'] ?? '' }} — ${{ $row['price'] ?? '' }}</li>
            @endforeach
        </ul>
    @endif

@else
    {{ $option->option_name }}
    @if ($option->sub_option)
        <span class="badge bg-secondary ms-2">Sub: {{ $option->sub_option }}</span>
    @endif
    @if ($option->is_default)
        <span class="badge bg-success ms-2">Default</span>
    @endif
@endif


       
    </div>

    {{-- Action buttons --}}
    <div class="d-flex gap-1">
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editOptionModal-{{ $option->id }}">
            <i class="ti ti-pencil"></i>
        </button>
        <form action="{{ route('form-options.destroy', $option->id) }}" method="POST" onsubmit="return confirm('Delete this option?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
        </form>
    </div>
</li>

                                {{-- Edit Option Modal --}}
                                @include('inventory.form_options.edit', ['option' => $option])
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No options added.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Edit Group Modal --}}
        <div class="modal fade" id="editGroupModal-{{ $group->id }}" tabindex="-1" aria-labelledby="editGroupModalLabel-{{ $group->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('form-options.groups.update', $group->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Group</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Group Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $group->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Condition</label>
                                <input type="text" name="condition" class="form-control" value="{{ $group->condition }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">No groups created yet.</p>
    @endforelse
</div>

{{-- Add Group Modal --}}
<div class="modal fade" id="addGroupModal" tabindex="-1" aria-labelledby="addGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('form-options.groups.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addGroupModalLabel">Add Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Group Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Condition (optional)</label>
                        <input type="text" name="condition" class="form-control" placeholder="e.g., color=white">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Add Group</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('inventory.form_options.create', ['groups' => $groups])
@endsection













@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- EDIT MODAL: Sub option toggle ---
    document.querySelectorAll('.sub-option-toggle').forEach(function (toggle) {
        toggle.addEventListener('change', function () {
            let field = this.closest('.mb-3').querySelector('.sub-option-field');
            field.style.display = this.checked ? 'block' : 'none';
        });
    });

    // --- EDIT MODAL: Size toggle ---
    document.querySelectorAll('.edit-size-toggle').forEach(toggle => {
        toggle.addEventListener('change', function () {
            let wrapper = this.closest('form').querySelector('.edit-size-fields');
            wrapper.style.display = this.checked ? 'block' : 'none';
        });
    });

    // --- EDIT MODAL: Thickness toggle ---
    document.querySelectorAll('[id^="editThicknessToggle"]').forEach(toggle => {
        toggle.addEventListener('change', function () {
            let field = this.closest('form').querySelector('.thickness-field');
            field.style.display = this.checked ? 'block' : 'none';
        });
    });

    // --- EDIT MODAL: Add more size rows ---
    document.querySelectorAll('.add-size-row').forEach(button => {
        button.addEventListener('click', function () {
            const container = this.closest('.edit-size-fields');
            const count = container.querySelectorAll('.row').length;
            const row = document.createElement('div');
            row.classList.add('row', 'g-2', 'mb-2');
            row.innerHTML = `
                <div class="col-md-6">
                    <input type="text" name="sizes[${count}][size]" class="form-control" placeholder="Size">
                </div>
                <div class="col-md-6">
                    <input type="text" name="sizes[${count}][name]" class="form-control" placeholder="Size Name">
                </div>`;
            container.insertBefore(row, this);
        });
    });

    // --- CREATE MODAL: Sub-option toggle ---
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('sub-option-check')) {
            const row = e.target.closest('.option-row');
            const field = row.querySelector('.sub-option-field');
            field.style.display = e.target.checked ? 'block' : 'none';
        }
    });

    // --- CREATE MODAL: Size toggle ---
    const sizeToggleCreate = document.getElementById('hasSize');
    const sizeFieldsCreate = document.getElementById('size-fields');
    if (sizeToggleCreate && sizeFieldsCreate) {
        sizeToggleCreate.addEventListener('change', function () {
            sizeFieldsCreate.style.display = this.checked ? 'block' : 'none';
        });
    }

    // --- CREATE MODAL: Add size rows ---
    const addSizeBtn = document.getElementById('add-more-size');
    if (addSizeBtn) {
        addSizeBtn.addEventListener('click', function () {
            const container = document.getElementById('size-fields');
            const count = container.querySelectorAll('.row').length;
            const row = document.createElement('div');
            row.classList.add('row', 'g-3', 'mb-2');
            row.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="size[${count}][size]" class="form-control" placeholder="Size">
                </div>
                <div class="col-md-4">
                    <input type="text" name="size[${count}][name]" class="form-control" placeholder="Size Name">
                </div>`;
            container.insertBefore(row, addSizeBtn.closest('.mb-3'));
        });
    }

    // --- CREATE MODAL: Add more option rows ---
    const optionList = document.getElementById('option-list');
    const addOptionBtn = document.getElementById('add-more-options');
    let optionIndex = optionList?.querySelectorAll('.option-row').length || 1;

    if (addOptionBtn && optionList) {
        addOptionBtn.addEventListener('click', function () {
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'g-3', 'mb-2', 'align-items-center', 'option-row');
            newRow.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="options[${optionIndex}][name]" class="form-control" placeholder="Option Name" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="options[${optionIndex}][sub_option]" class="form-control sub-option-field" placeholder="Sub Option" style="display:none">
                </div>
                <div class="col-md-1">
                    <input type="checkbox" class="form-check-input sub-option-check" data-index="${optionIndex}">
                    <label class="form-check-label small">Sub</label>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger remove-option">&times;</button>
                </div>`;
            optionList.appendChild(newRow);
            optionIndex++;
        });
    }
    
// CREATE MODAL: Thickness toggle
document.addEventListener('change', function (e) {
    if (e.target.id === 'hasThickness') {
        const form = e.target.closest('form');
        const field = form.querySelector('.thickness-field');
        field.style.display = e.target.checked ? 'block' : 'none';
    }
});


    // --- CREATE MODAL: Remove option row ---
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-option')) {
            e.target.closest('.option-row').remove();
        }
    });
});
</script>
<script>
    document.getElementById('searchCardInput').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.card').forEach(card => {
            const title = card.querySelector('.card-header strong')?.innerText.toLowerCase() || '';
            const condition = card.querySelector('.badge')?.innerText.toLowerCase() || '';
            card.style.display = title.includes(query) || condition.includes(query) ? 'block' : 'none';
        });
    });
</script>
<script>
    new Sortable(document.getElementById('cardContainer'), {
        animation: 150,
        handle: '.card-header', // Optional: drag from header
        ghostClass: 'bg-light',
    });
</script>
@endpush
