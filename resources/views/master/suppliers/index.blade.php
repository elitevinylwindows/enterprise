@extends('layouts.app')

@section('page-title')
    {{ __('Suppliers') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Suppliers</li>
@endsection

@section('card-action-btn')
<button type="button" class="btn btn-md btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
    <i class="ti ti-plus"></i> Add Supplier
</button>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <h5>{{ __('Suppliers') }}</h5>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="supplierTable">
<thead>
    <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>City</th>
        <th>Country</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
</thead>

                        <tbody>
                            @foreach($suppliers as $supplier)
                                <tr>
<td>{{ $supplier->id }}</td>
<td>{{ ucfirst($supplier->supplier_type) }}</td>
<td>{{ $supplier->name }}</td>
<td>{{ $supplier->phone }}</td>
<td>{{ $supplier->email }}</td>
<td>{{ $supplier->city }}</td>
<td>{{ $supplier->country }}</td>
<td>{{ $supplier->status }}</td>

<td>
    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editSupplierModal{{ $supplier->id }}">
                <i class="ti ti-edit"></i> Edit
            </button>
</td>
                                </tr>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('master.suppliers.create')
 @include('master.suppliers.edit')

@endsection
