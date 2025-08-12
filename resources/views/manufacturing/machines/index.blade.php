@extends('layouts.app')

@section('page-title')
    {{ __('Machines') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Machines') }}</li>
@endsection

@section('content')
<div class="mb-4"></div>

<div class="row">
    {{-- Sidebar --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('manufacturing.machines.index') }}"
                   class="list-group-item {{ ($status ?? 'all') === 'all' ? 'active' : '' }}">
                    All Machines
                </a>
                <a href="{{ route('manufacturing.machines.index', ['file_type' => 'pdf']) }}"
                   class="list-group-item {{ ($status ?? '') === 'pdf' ? 'active' : '' }}">
                    .CSV
                </a>
                <a href="{{ route('manufacturing.machines.index', ['file_type' => 'image']) }}"
                   class="list-group-item {{ ($status ?? '') === 'image' ? 'active' : '' }}">
                    .XML
                </a>
                <a href="{{ route('manufacturing.machines.index', ['file_type' => 'other']) }}"
                   class="list-group-item {{ ($status ?? '') === 'other' ? 'active' : '' }}">
                    Other
                </a>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="col-sm-10">
        <div class="card table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>{{ __('Machines List') }}</h5>
                <a href="{{ route('manufacturing.machines.create') }}" class="btn btn-primary btn-sm">
                    <i data-feather="plus"></i> Add Machine
                </a>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="machinesTable">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Machine</th>
                                <th>File Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
@php $thCount = 4; @endphp

@forelse ($machines as $machine)
    <tr>
        <td>{{ $machine->id }}</td>
        <td>{{ $machine->machine }}</td>
        <td>{{ $machine->file_type ? ucfirst($machine->file_type) : '—' }}</td>
        <td class="text-nowrap">
            <a href="{{ route('manufacturing.machines.show', $machine->id) }}"
               class="avtar avtar-xs btn-link-success text-success" title="View">
               <i data-feather="eye"></i>
            </a>

            <a href="{{ route('manufacturing.machines.edit', $machine->id) }}"
               class="avtar avtar-xs btn-link-primary text-primary" title="Edit">
               <i data-feather="edit"></i>
            </a>

            <form action="{{ route('manufacturing.machines.destroy', $machine->id) }}"
                  method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="avtar avtar-xs btn-link-danger text-danger border-0 bg-transparent p-0"
                        title="Delete"
                        onclick="return confirm('Delete this machine?')">
                    <i data-feather="trash-2"></i>
                </button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="{{ $thCount }}" class="text-center text-muted">No machines found</td>
    </tr>
@endforelse
</tbody>


                    </table>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        if ($.fn.DataTable) {
            $('#machinesTable').DataTable({
                pageLength: 25,
                order: [[0, 'asc']]
            });
        }
    });
</script>
@endpush
