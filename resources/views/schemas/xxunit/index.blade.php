@extends('layouts.app')

@section('page-title')
    {{ __('XX Units') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('XX Units') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('XX Units') }}</h5>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-model="XXUnit"
                           data-url="{{ route('schemas.import.form') }}"
                           data-title="{{ __('Import XX Unit') }}">
                           <i data-feather="plus"></i> {{ __('Import') }}
                        </a>
                        <a href="#" class="btn btn-primary customModal"
                            data-size="lg"
                            data-url="{{ route('xx-unit.create') }}"
                            data-title="{{ __('Create XX Unit') }}">
                            <i data-feather="plus"></i> {{ __('Create') }}
                        </a>

                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="xxUnitsTable">
                        <thead>
                            <tr>
                                <th>{{ __('Schema ID') }}</th>
                                <th>{{ __('Product ID') }}</th>
                                <th>{{ __('Retrofit') }}</th>
                                <th>{{ __('Nailon') }}</th>
                                <th>{{ __('Block') }}</th>
                                <th>{{ __('LE3 CLR') }}</th>
                                <th>{{ __('CLR CLR') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($xxunits as $unit)
                                <tr>
                                    <td>{{ $unit->schema_id }}</td>
                                    <td>{{ $unit->product_id }}</td>
                                    <td>{{ $unit->retrofit }}</td>
                                    <td>{{ $unit->nailon }}</td>
                                    <td>{{ $unit->block }}</td>
                                    <td>{{ $unit->le3_clr }}</td>
                                    <td>{{ $unit->clr_clr }}</td>
                                    <td>{{ $unit->status }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info customModal"
                                           data-size="lg"
                                           data-url="{{ route('xx-unit.edit', $unit->id) }}"
                                           data-title="{{ __('Edit XX Unit') }}">
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
