@extends('layouts.app')
@section('page-title', __('Barcode Generator'))
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Barcode Generator') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('Barcode Generator') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('inventory.barcodes.create') }}"
                           data-title="{{ __('Create Barcode') }}">
                           <i data-feather="plus"></i> {{ __('Create') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
                            <tr>
                                <th>{{ __('Product') }}</th>
                                <th>{{ __('SKU') }}</th>
                                <th>{{ __('Barcode') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barcodes as $barcode)
                            <tr>
                                <td>{{ $barcode->product }}</td>
                                <td>{{ $barcode->sku }}</td>
                                <td>
                                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($barcode->barcode, 'C128') }}" alt="barcode" />
                                    <div>{{ $barcode->barcode }}</div>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('inventory.barcodes.edit', $barcode->id) }}"
                                       data-title="{{ __('Edit Barcode') }}">
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
