@extends('layouts.app')

@section('page-title')
    {{ __('Capacity') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Capacity') }}</li>
@endsection

@section('content')
<div class="mb-4"></div> {{-- Space after title --}}
<div class="mb-4"></div> {{-- Space --}}

<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('manufacturing.capacity.index', ['status' => 'all']) }}"
                   class="list-group-item {{ ($status ?? 'all') === 'all' ? 'active' : '' }}">
                    All
                </a>
                <a href="{{ route('manufacturing.capacity.index', ['status' => 'under']) }}"
                   class="list-group-item {{ ($status ?? '') === 'under' ? 'active' : '' }}">
                    Under Capacity (&lt; 80%)
                </a>
                <a href="{{ route('manufacturing.capacity.index', ['status' => 'near']) }}"
                   class="list-group-item {{ ($status ?? '') === 'near' ? 'active' : '' }}">
                    Near Capacity (80–99%)
                </a>
                <a href="{{ route('manufacturing.capacity.index', ['status' => 'full']) }}"
                   class="list-group-item {{ ($status ?? '') === 'full' ? 'active' : '' }}">
                    At / Over Capacity (≥ 100%)
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
                        <h5>{{ __('Capacity List') }}</h5>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="capacityTable">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Description</th>
                                <th class="text-end">Limit</th>
                                <th class="text-end">Actual</th>
                                <th class="text-end">Percentage</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($capacities as $cap)
                            @php
                                $limit = (float)($cap->limit ?? 0);
                                $actual = (float)($cap->actual ?? 0);
                                $pct = $limit > 0 ? ($actual / $limit) * 100 : 0;
                            @endphp
                            <tr>
                                <td>{{ $cap->id }}</td>
                                <td>{{ $cap->description }}</td>
                                <td class="text-end">{{ number_format($limit, 0) }}</td>
                                <td class="text-end">{{ number_format($actual, 0) }}</td>
                                <td class="text-end">
                                    {{ number_format($pct, 1) }}%
                                </td>
                                <td class="text-nowrap">
                                    {{-- Original Action Buttons --}}
                                    {{-- View --}}
                                    <a class="avtar avtar-xs btn-link-success text-success customModal" data-bs-toggle="tooltip" data-bs-original-title="View Invoice" href="#" data-size="xl" data-url="{{ route('sales.invoices.show', $invoice->id) }}" data-title="Invoice Summary">
                                        <i data-feather="eye"></i>
                                    </a>

                                    {{-- Send to QB --}}
                                    <a class="avtar avtar-xs btn-link-success text-success" data-bs-toggle="tooltip" data-bs-original-title="Send to QuickBooks" href="{{ route('sales.invoices.sendToQuickBooks', $invoice->id) }}" data-title="Send to Quickbooks">
                                        <i data-feather="share"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a class="avtar avtar-xs btn-link-primary text-primary customModal" data-bs-toggle="tooltip" data-bs-original-title="Edit" href="#" data-size="xl" data-url="{{ route('sales.invoices.edit', $invoice->id) }}" data-title="Edit Invoice">
                                        <i data-feather="edit"></i>
                                    </a>
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

@include('manufacturing.capacity.create')

@push('scripts')
<script>
    $(function () {
        // If you’re using DataTables elsewhere, this will hook in seamlessly.
        if ($.fn.DataTable) {
            $('#capacityTable').DataTable({
                pageLength: 25,
                order: [[0, 'asc']]
            });
        }
    });
</script>
@endpush
