@extends('layouts.app')
@section('page-title', __('GSCO SLD Units'))
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('GSCO SLD Units') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('GSCO SLD Units') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-model="GSCOSLDUnit"
                           data-url="{{ route('schemas.import.form') }}"
                           data-title="{{ __('Import GSCO SLD Unit') }}">
                           <i data-feather="plus"></i> {{ __('Import') }}
                        </a>
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('hs-unit.create') }}"
                           data-title="{{ __('Create GSCO SLD Unit') }}">
                           <i data-feather="plus"></i> {{ __('Create') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
                            <tr><th>{{ __('Schema Id') }}</th>
                            <th>{{ __('Product Id') }}</th>
                            <th>{{ __('Product Code') }}</th>
                            <th>{{ __('Retrofit') }}</th>
                            <th>{{ __('Nailon') }}</th>
                            <th>{{ __('Block') }}</th>
                            <th>{{ __('Le3 Clr') }}</th>
                            <th>{{ __('Clr Clr') }}</th>
                            <th>{{ __('Le3 Lam') }}</th>
                            <th>{{ __('Le3 Clr Le3') }}</th>
                            <th>{{ __('Clr Temp') }}</th>
                            <th>{{ __('Lam Temp') }}</th>
                            <th>{{ __('Obs') }}</th>
                            <th>{{ __('Feat2') }}</th>
                            <th>{{ __('Feat3') }}</th>
                            <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gscosldunits as $gscosldunit)
                            <tr>
                                <td>{{ $hsunit->schema_id }}</td>
                                <td>{{ $hsunit->product_id }}</td>
                                <td>{{ $hsunit->product_code }}</td>
                                <td>${{ $hsunit->retrofit }}</td>
                                <td>${{ $hsunit->nailon }}</td>
                                <td>${{ $hsunit->block }}</td>
                                <td>${{ $hsunit->le3_clr }}</td>
                                <td>${{ $hsunit->clr_clr }}</td>
                                <td>${{ $hsunit->le3_lam }}</td>
                                <td>${{ $hsunit->le3_clr_le3 }}</td>
                                <td>${{ $hsunit->clr_temp }}</td>
                                <td>${{ $hsunit->lam_temp }}</td>
                                <td>${{ $hsunit->obs }}</td>
                                <td>${{ $hsunit->feat2 }}</td>
                                <td>${{ $hsunit->feat3 }}</td>
                                <td>{{ $hsunit->status }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('hs-unit.edit', $hsunit->id) }}"
                                       data-title="{{ __('Edit GSCO SLD Unit') }}">
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
