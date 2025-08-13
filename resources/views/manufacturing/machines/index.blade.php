@extends('layouts.app')

@section('page-title')
{{ __('Machines') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Machines') }}</li>
@endsection

@section('content')
<div class="mb-4"></div> {{-- Space after title --}}
<div class="mb-4"></div> {{-- Space --}}

<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('manufacturing.machines.index', ['status' => 'all']) }}"
                   class="list-group-item {{ ($status ?? 'all') === 'all' ? 'active' : '' }}">
                    All Machines
                </a>
                <a href="{{ route('manufacturing.machines.index', ['status' => 'csv']) }}"
                   class="list-group-item {{ ($status ?? '') === 'csv' ? 'active' : '' }}">
                    .CSV
                </a>
                <a href="{{ route('manufacturing.machines.index', ['status' => 'xml']) }}"
                   class="list-group-item {{ ($status ?? '') === 'xml' ? 'active' : '' }}">
                    .XML
                </a>
                <a href="{{ route('manufacturing.machines.index', ['status' => 'image']) }}"
                   class="list-group-item {{ ($status ?? '') === 'image' ? 'active' : '' }}">
                    Images
                </a>
                <a href="{{ route('manufacturing.machines.index', ['status' => 'video']) }}"
                   class="list-group-item {{ ($status ?? '') === 'video' ? 'active' : '' }}">
                    Videos
                </a>
                <a href="{{ route('manufacturing.machines.index', ['status' => 'other']) }}"
                   class="list-group-item {{ ($status ?? '') === 'other' ? 'active' : '' }}">
                    Other
                </a>
                <a href="{{ route('manufacturing.machines.index', ['status' => 'deleted']) }}"
                   class="list-group-item text-danger {{ ($status ?? '') === 'deleted' ? 'active' : '' }}">
                    Deleted
                </a>
            </div>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="col-sm-10">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Machines') }}</h5>
                    </div>
                    <div class="col-auto ms-auto">
                        <a href="{{ route('manufacturing.machines.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Add Machine
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover" id="machinesTable">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Machine') }}</th>
                                <th>{{ __('File Type') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($machines as $machine)
                                <tr>
                                    <td>{{ $machine->id }}</td>
                                    <td>{{ $machine->machine }}</td>
                                    <td>{{ $machine->file_type ? strtoupper($machine->file_type) : '—' }}</td>
                                    <td class="text-nowrap">
                                        @if(($status ?? 'all') === 'deleted')
                                            {{-- Restore --}}
                                            <form action="{{ route('manufacturing.machines.restore', $machine->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit"
                                                        class="avtar avtar-xs btn-link-success text-success border-0 bg-transparent p-0"
                                                        data-bs-toggle="tooltip" title="Restore">
                                                    <i data-feather="rotate-ccw"></i>
                                                </button>
                                            </form>
                                            {{-- Force Delete --}}
                                            <form action="{{ route('manufacturing.machines.force-delete', $machine->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="avtar avtar-xs btn-link-danger text-danger border-0 bg-transparent p-0"
                                                        data-bs-toggle="tooltip" title="Delete Permanently"
                                                        onclick="return confirm('Permanently delete this machine?')">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        @else
                                            {{-- View --}}
                                            <a href="{{ route('manufacturing.machines.show', $machine->id) }}"
                                               class="avtar avtar-xs btn-link-success text-success"
                                               data-bs-toggle="tooltip" title="View">
                                                <i data-feather="eye"></i>
                                            </a>
                                            {{-- Edit --}}
                                            <a href="{{ route('manufacturing.machines.edit', $machine->id) }}"
                                               class="avtar avtar-xs btn-link-primary text-primary"
                                               data-bs-toggle="tooltip" title="Edit">
                                                <i data-feather="edit"></i>
                                            </a>
                                            {{-- Delete --}}
                                            <form action="{{ route('manufacturing.machines.destroy', $machine->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="avtar avtar-xs btn-link-danger text-danger border-0 bg-transparent p-0"
                                                        data-bs-toggle="tooltip" title="Delete"
                                                        onclick="return confirm('Delete this machine?')">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- table-responsive -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col -->
</div>
@endsection


@include('manufacturing.machines.create')

@push('scripts')
<script>
$(function () {
    // Initialize DataTable (kept simple — 4 columns only)
    if ($.fn.DataTable) {
        if ( $.fn.dataTable.isDataTable('#machinesTable') ) {
            $('#machinesTable').DataTable().destroy();
        }
        // Columns: 0: ID, 1: Machine, 2: File Type, 3: Action
        $('#machinesTable').DataTable({
            pageLength: 25,
            order: [[0, 'desc']],
            columnDefs: [{ orderable: false, searchable: false, targets: 4 }] // Action column not orderable/searchable
        });
    }

    // Feather icons refresh (if your layout does not already do this after ajax)
    if (window.feather) feather.replace();
});
</script>
@endpush
