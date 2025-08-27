@extends('layouts.app')
@section('page-title', __('GSCO XX Units'))
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('GSCO XX Units') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('GSCO XX Units') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-model="GSCOXXUnit"
                           data-url="{{ route('schemas.import.form') }}"
                           data-title="{{ __('Import GSCO XX Unit') }}">
                           <i data-feather="plus"></i> {{ __('Import') }}
                        </a>
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('hs-unit.create') }}"
                           data-title="{{ __('Create GSCO XX Unit') }}">
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
                            @foreach ($gscoxxunits as $gscoxxunit)
                            <tr>
                                <td>{{ $gscoxxunit->schema_id }}</td>
                                <td>{{ $gscoxxunit->product_id }}</td>
                                <td>{{ $gscoxxunit->product_code }}</td>
                                <td>${{ $gscoxxunit->retrofit }}</td>
                                <td>${{ $gscoxxunit->nailon }}</td>
                                <td>${{ $gscoxxunit->block }}</td>
                                <td>${{ $gscoxxunit->le3_clr }}</td>
                                <td>${{ $gscoxxunit->clr_clr }}</td>
                                <td>${{ $gscoxxunit->le3_lam }}</td>
                                <td>${{ $gscoxxunit->le3_clr_le3 }}</td>
                                <td>${{ $gscoxxunit->clr_temp }}</td>
                                <td>${{ $gscoxxunit->lam_temp }}</td>
                                <td>${{ $gscoxxunit->obs }}</td>
                                <td>${{ $gscoxxunit->feat2 }}</td>
                                <td>${{ $gscoxxunit->feat3 }}</td>
                                <td>{{ $gscoxxunit->status }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('hs-unit.edit', $gscoxxunit->id) }}"
                                       data-title="{{ __('Edit GSCO XX Unit') }}">
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
