@extends('layouts.app')

@section('page-title')
    {{ __('Shops') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Shops') }}</li>
@endsection
@section('card-action-btn')
<form action="{{ route('shops.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-block">
    @csrf
    <input type="file" name="import_file" accept=".csv, .xls, .xlsx" required class="form-control d-inline-block w-auto">
    <button type="submit" class="btn btn-sm btn-primary">
        <i data-feather="upload"></i> Import Shops
    </button>
</form>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Shops') }}</h5>
                    </div>
                    @can('create shop')
                        <div class="col-auto">
                    
                            <a href="#" class="btn btn-primary customModal"
                               data-size="lg"
                               data-url="{{ route('shops.create') }}"
                               data-title="{{ __('Create Shop') }}">
                                <i data-feather="plus"></i> {{ __('Create') }}
                            </a>
                        </div>
                    @endcan
                </div>
            </div>
                    <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="ordersTable">
                        <thead>
                            <tr>
                                <th>{{ __('Customer #') }}</th>
                                <th>{{ __('Customer Name') }}</th>
                                 <th>{{ __('Email') }}</th>
                                  <th>{{ __('Phone') }}</th>
                                <th>{{ __('Address') }}</th>
                                <th>{{ __('City') }}</th>
                                <th>{{ __('ZIP') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shops as $shop)
                                <tr>
                                    <td>{{ $shop->customer }}</td>
                                    <td>{{ $shop->customer_name }}</td>
                                     <td>{{ $shop->email }}</td>
                                      <td>{{ $shop->contact_phone }}</td>
                                    <td>{{ $shop->address }}</td>
                                    <td>{{ $shop->city }}</td>
                                    <td>{{ $shop->zip }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info customModal"
                                           data-size="lg"
                                           data-url="{{ route('shops.edit', $shop->id) }}"
                                           data-title="{{ __('Edit Shop') }}">
                                           <i data-feather="edit"></i>
                                        </a>
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

