@extends('layouts.app')
@section('page-title', __('GSCO PW Units'))
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('GSCO PW Units') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('GSCO PW Units') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-model="GSCOPWUnit"
                           data-url="{{ route('schemas.import.form') }}"
                           data-title="{{ __('Import GSCO PW Unit') }}">
                           <i data-feather="plus"></i> {{ __('Import') }}
                        </a>
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('hs-unit.create') }}"
                           data-title="{{ __('Create GSCO PW Unit') }}">
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
                            @foreach ($gscopwunits as $gscopwunit)
                            <tr>
                                <td>{{ $gscopwunit->schema_id }}</td>
                                <td>{{ $gscopwunit->product_id }}</td>
                                <td>{{ $gscopwunit->product_code }}</td>
                                <td>${{ $gscopwunit->retrofit }}</td>
                                <td>${{ $gscopwunit->nailon }}</td>
                                <td>${{ $gscopwunit->block }}</td>
                                <td>${{ $gscopwunit->le3_clr }}</td>
                                <td>${{ $gscopwunit->clr_clr }}</td>
                                <td>${{ $gscopwunit->le3_lam }}</td>
                                <td>${{ $gscopwunit->le3_clr_le3 }}</td>
                                <td>${{ $gscopwunit->clr_temp }}</td>
                                <td>${{ $gscopwunit->lam_temp }}</td>
                                <td>${{ $gscopwunit->obs }}</td>
                                <td>${{ $gscopwunit->feat2 }}</td>
                                <td>${{ $gscopwunit->feat3 }}</td>
                                <td>{{ $gscopwunit->status }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('hs-unit.edit', $gscopwunit->id) }}"
                                       data-title="{{ __('Edit HS Unit') }}">
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
