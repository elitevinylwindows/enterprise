@extends('layouts.app')
@section('page-title', __('SWD Units'))
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('SWD Units') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('SWD Units') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-model="SWDUnit"
                           data-url="{{ route('schemas.import.form') }}"
                           data-title="{{ __('Import GSCO SWD Unit') }}">
                           <i data-feather="plus"></i> {{ __('Import') }}
                        </a>
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('hs-unit.create') }}"
                           data-title="{{ __('Create SWD Unit') }}">
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
                            @foreach ($swdunits as $swdunit)
                            <tr>
                                <td>{{ $swdunit->schema_id }}</td>
                                <td>{{ $swdunit->product_id }}</td>
                                <td>{{ $swdunit->product_code }}</td>
                                <td>${{ $swdunit->retrofit }}</td>
                                <td>${{ $swdunit->nailon }}</td>
                                <td>${{ $swdunit->block }}</td>
                                <td>${{ $swdunit->le3_clr }}</td>
                                <td>${{ $swdunit->clr_clr }}</td>
                                <td>${{ $swdunit->le3_lam }}</td>
                                <td>${{ $swdunit->le3_clr_le3 }}</td>
                                <td>${{ $swdunit->clr_temp }}</td>
                                <td>${{ $swdunit->lam_temp }}</td>
                                <td>${{ $swdunit->obs }}</td>
                                <td>${{ $swdunit->feat2 }}</td>
                                <td>${{ $swdunit->feat3 }}</td>
                                <td>{{ $swdunit->status }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('hs-unit.edit', $swdunit->id) }}"
                                       data-title="{{ __('Edit SWD Unit') }}">
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
