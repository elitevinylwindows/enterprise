@extends('layouts.app')
@section('page-title', __('Purchase Requests'))

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Purchase Requests') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('Purchase Requests') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('purchasing.purchase-requests.create') }}"
                           data-title="{{ __('Create Request') }}">
                           <i class="fa-solid fa-circle-plus"></i> {{ __('Create') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
                            <tr>
                                <th>{{ __('Request No') }}</th>
                                <th>{{ __('Requested By') }}</th>
                                <th>{{ __('Department') }}</th>
                                <th>{{ __('Request Date') }}</th>
                                <th>{{ __('Expected Date') }}</th>
                                <th>{{ __('Priority') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Notes') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchaseRequests as $request)
                            <tr>
                                <td>{{ $request->purchase_request_id }}</td>
                                <td>{{ $request->requested_by }}</td>
                                <td>{{ $request->department }}</td>
                                <td>{{ \Carbon\Carbon::parse($request->request_date)->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($request->expected_date)->format('M d, Y') }}</td>
                                <td><span class="badge bg-warning">{{ ucfirst($request->priority) }}</span></td>
                                <td><span class="badge bg-{{ $request->status === 'approved' ? 'success' : ($request->status === 'rejected' ? 'danger' : 'secondary') }}">
                                    {{ ucfirst($request->status) }}</span>
                                </td>
                                <td>{{ Str::limit($request->notes, 30) }}</td>
                                <td>
                                 
<a class="avtar avtar-xs btn-link-success text-success customModal"
   data-bs-toggle="tooltip"
   data-bs-original-title="Edit Request"
   href="#"
   data-size="lg"
   data-url="{{ route('purchasing.purchase-requests.edit', $request->id) }}"
   data-title="Edit Request">
    <i data-feather="edit"></i>
</a>





<a class="avtar avtar-xs btn-link-warning text-warning customModal"
   data-size="lg"
   data-url="{{ route('purchasing.purchase-requests.show', $request->id) }}"
   data-title="Purchase Request Items">
    <i data-feather="eye"></i>
</a>





<a href="{{ route('purchasing.purchase-requests.send-mail', $request->id) }}"
   class="avtar avtar-xs btn-link-warning text-secondary"
   title="Send Email to Supplier">
    <i data-feather="mail"></i>
</a>





<a class="avtar avtar-xs btn-link-danger text-danger"
   data-bs-toggle="tooltip"
   data-bs-original-title="Delete Request"
   href="{{ route('purchasing.purchase-requests.destroy', $request->id) }}"
   onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this request?')) document.getElementById('delete-form-{{ $request->id }}').submit();">
    <i data-feather="trash-2"></i>
</a>

<form id="delete-form-{{ $request->id }}" action="{{ route('purchasing.purchase-requests.destroy', $request->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
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
