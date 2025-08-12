@extends('layouts.app')

@section('page-title')
{{ __('Stations') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Stations') }}</li>
@endsection

@section('content')
<div class="mb-4"></div>
<div class="mb-4"></div>

<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('manufacturing.stations.index', ['status' => 'all']) }}"
                   class="list-group-item {{ ($status ?? 'all') === 'all' ? 'active' : '' }}">
                    All Stations
                </a>
                <a href="{{ route('manufacturing.stations.index', ['status' => 'active']) }}"
                   class="list-group-item {{ ($status ?? '') === 'active' ? 'active' : '' }}">
                    Active
                </a>
                <a href="{{ route('manufacturing.stations.index', ['status' => 'inactive']) }}"
                   class="list-group-item {{ ($status ?? '') === 'inactive' ? 'active' : '' }}">
                    Inactive
                </a>
                <a href="{{ route('manufacturing.stations.index', ['status' => 'deleted']) }}"
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
                        <h5>{{ __('Stations') }}</h5>
                    </div>
                    <div class="col-auto ms-auto">
                        <a href="{{ route('manufacturing.stations.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Add Station
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="stationsTable">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Station #') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stations as $station)
                                <tr>
                                    <td>{{ $station->id }}</td>
                                    <td>{{ $station->station_number ?? $station->station_no ?? 'N/A' }}</td>
                                    <td>{{ $station->description ?? '—' }}</td>
                                    <td class="text-nowrap">
                                        @if(($status ?? 'all') === 'deleted')
                                            {{-- Restore --}}
                                            <form action="{{ route('manufacturing.stations.restore', $station->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit"
                                                        class="avtar avtar-xs btn-link-success text-success border-0 bg-transparent p-0"
                                                        title="Restore">
                                                    <i data-feather="rotate-ccw"></i>
                                                </button>
                                            </form>
                                            {{-- Force Delete --}}
                                            <form action="{{ route('manufacturing.stations.force-delete', $station->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="avtar avtar-xs btn-link-danger text-danger border-0 bg-transparent p-0"
                                                        title="Delete Permanently"
                                                        onclick="return confirm('Permanently delete this station?')">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        @else
                                            {{-- View --}}
                                            <a href="{{ route('manufacturing.stations.show', $station->id) }}"
                                               class="avtar avtar-xs btn-link-success text-success" title="View">
                                                <i data-feather="eye"></i>
                                            </a>
                                            {{-- Edit --}}
                                            <a href="{{ route('manufacturing.stations.edit', $station->id) }}"
                                               class="avtar avtar-xs btn-link-primary text-primary" title="Edit">
                                                <i data-feather="edit"></i>
                                            </a>
                                            {{-- Delete --}}
                                            <form action="{{ route('manufacturing.stations.destroy', $station->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="avtar avtar-xs btn-link-danger text-danger border-0 bg-transparent p-0"
                                                        title="Delete"
                                                        onclick="return confirm('Delete this station?')">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            @if($stations->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No stations found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div> <!-- table-responsive -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col -->
</div>
@endsection

@push('scripts')
<script>
$(function () {
    if ($.fn.DataTable) {
        $('#stationsTable').DataTable({
            pageLength: 25,
            order: [[0, 'desc']],
            columnDefs: [{ targets: -1, orderable: false, searchable: false }]
        });
    }
    if (window.feather) feather.replace();
});
</script>
@endpush
