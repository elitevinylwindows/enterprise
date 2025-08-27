@extends('layouts.app')
@section('page-title', __('SLD Units'))
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('SLD Units') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('SLD Units') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-model="SLDUnit"
                           data-url="{{ route('schemas.import.form') }}"
                           data-title="{{ __('Import SLD Unit') }}">
                           <i data-feather="plus"></i> {{ __('Import') }}
                        </a>
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('hs-unit.create') }}"
                           data-title="{{ __('Create SLD Unit') }}">
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
                            <th>{{ __('Lam') }}</th>
                            <th>{{ __('Feat1') }}</th>
                            <th>{{ __('Feat2') }}</th>
                            <th>{{ __('Feat3') }}</th>
                            <th>{{ __('Acid Edge') }}</th>
                            <th>{{ __('Solar Cool') }}</th>
                            <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sldunits as $sldunit)
                            <tr>
                                <td>{{ $sldunit->schema_id }}</td>
                                <td>{{ $sldunit->product_id }}</td>
                                <td>{{ $sldunit->product_code }}</td>
                                <td>${{ $sldunit->lam }}</td>
                                <td>${{ $sldunit->feat1 }}</td>
                                <td>${{ $sldunit->feat2 }}</td>
                                <td>${{ $sldunit->feat3 }}</td>
                                <td>${{ $sldunit->acid_edge }}</td>
                                <td>${{ $sldunit->solar_cool }}</td>
                                <td>{{ $sldunit->status }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('hs-unit.edit', $sldunit->id) }}"
                                       data-title="{{ __('Edit SLD Unit') }}">
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
