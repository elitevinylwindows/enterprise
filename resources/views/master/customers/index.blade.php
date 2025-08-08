@extends('layouts.app')

@section('page-title')
{{ __('Customers') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item">{{ __('Master') }}</li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Customers') }}</li>
@endsection

@section('card-action-btn')
<form action="{{ route('master.customers.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-block me-2">
    @csrf
    <input type="file" name="import_file" accept=".csv,.xls,.xlsx" required class="form-control d-inline-block w-auto">
    <button type="submit" class="btn btn-md btn-primary">
        <i data-feather="upload"></i> Import Customers
    </button>
</form>

<button type="button" class="btn btn-md btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
    <i class="ti ti-plus"></i> Add Customer
</button>

<a href="{{ route('master.customers.index', ['status' => 'active']) }}" class="btn btn-primary btn-md me-2">
    Show Only Active Users
</a>

@if(request()->get('status') === 'active')
<a href="{{ route('master.customers.index') }}" class="btn btn-primary btn-md">
    Show All Users
</a>
@endif
@endsection





@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Customers') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
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
                                <td>{{ $customer->street }}</td>
                                <td>{{ $customer->city }}</td>
                                <td>{{ $customer->zip }}</td>
                                <td>
                                    <span class="badge bg-{{ $customer->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($customer->status) }}
                                    </span>
                                </td>
                                <td>{{ $customer->tier?->name }}</td>
                                <td>${{ number_format($customer->loyalty_credit, 2) }}</td>
                                <td>${{ number_format($customer->total_spent, 2) }}</td>
                                <td>
                                    <a href="{{ route('master.customers.edit', $customer->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('master.customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-primary" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            @include('master.customers.create') {{-- or inline form --}}
        </div>
    </div>
</div>

<!-- Add Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            @include('master.customers.edit') {{-- or inline form --}}
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.getElementById('select-all').addEventListener('click', function() {
        const checked = this.checked;
        document.querySelectorAll('.customer-checkbox').forEach(cb => cb.checked = checked);
    });

</script>
@endpush
