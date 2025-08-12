@extends('layouts.app')

@section('page-title')
{{ __('Customers') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item">{{ __('Master') }}</li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Customers') }}</li>
@endsection

@section('content')
<!-- Spacer between breadcrumb and first card -->
<div class="mb-4"></div>

<!-- Card 1: Header and Actions -->
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <form action="{{ route('master.customers.import') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-grow-1 gap-2">
                @csrf
                <input type="file" name="import_file" accept=".csv,.xls,.xlsx" required class="form-control" style="max-width: 250px;">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-upload me-1"></i> Import
                </button>
            </form>

            <div class="d-flex gap-2">
    <!-- Add Customer Button -->
    <button type="button" class="btn text-white" style="background-color: #a80000" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
        <i class="ti ti-plus me-1"></i> Add Customer
    </button>

    @if(request()->get('status') === 'active')
        <a href="{{ route('master.customers.index') }}" class="btn text-white" style="background-color: #a80000">
            Show All
        </a>
    @else
        <a href="{{ route('master.customers.index', ['status' => 'active']) }}" class="btn text-white" style="background-color: #a80000">
            Show Active
        </a>
    @endif
</div>
        </div>
    </div>
</div>

<!-- Spacer between action card and table card -->
<div class="mb-4"></div>

<!-- Card 2: Customers Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ __('Customers List') }}</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover advance-datatable" id="customersTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Customer #</th>
                        <th>Customer Name</th>
                        <th>Street</th>
                        <th>City</th>
                        <th>ZIP</th>
                        <th>Status</th>
                        <th>Tier</th>
                        <th>Loyalty Credit</th>
                        <th>Total Spent</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                    <tr>
                        <td><input type="checkbox" class="customer-checkbox" value="{{ $customer->id }}"></td>
                        <td>{{ $customer->customer_number }}</td>
                        <td>{{ $customer->customer_name }}</td>
                        <td>{{ $customer->billing_address }}</td>
                        <td>{{ $customer->billing_city }}</td>
                        <td>{{ $customer->billing_zip }}</td>
                        <td>
                            <span class="badge bg-{{ $customer->status === 'active' ? 'warning' : 'secondary' }}">
                                {{ ucfirst($customer->status) }}
                            </span>
                        </td>
                        <td>{{ $customer->tier?->name }}</td>
                        <td>${{ number_format($customer->loyalty_credit, 2) }}</td>
                        <td>${{ number_format($customer->total_spent, 2) }}</td>
                        <td class="text-nowrap">
                            <a class="avtar avtar-xs btn-link-primary text-primary customModal"
                               data-bs-toggle="tooltip"
                               data-bs-original-title="Edit Customer"
                               href="#"
                               data-size="xl"
                               data-url="{{ route('master.customers.edit', $customer->id) }}"
                               data-title="Edit Customer">
                                <i data-feather="edit"></i>
                            </a>
                            <form action="{{ route('master.customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <a class="avtar avtar-xs btn-link-danger text-danger delete-confirm"
                                   data-bs-toggle="tooltip"
                                   data-bs-original-title="Delete Customer"
                                   href="#"
                                   onclick="event.preventDefault(); if(confirm('Are you sure?')) { this.closest('form').submit(); }">
                                    <i data-feather="trash-2"></i>
                                </a>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            @include('master.customers.create')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Select all checkbox
    document.getElementById('select-all').addEventListener('click', function() {
        const checked = this.checked;
        document.querySelectorAll('.customer-checkbox').forEach(cb => cb.checked = checked);
    });
</script>
@endpush
