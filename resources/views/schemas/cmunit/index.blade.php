@extends('layouts.app')
@section('page-title')
    {{ __('CM Units') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('CM Units') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('CM Units') }}</h5>
                    </div>
                    <div class="col-auto">
                          <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-model="CMUnit"
                           data-url="{{ route('schemas.import.form') }}"
                           data-title="{{ __('Import CM Unit') }}">
                           <i data-feather="plus"></i> {{ __('Import') }}
                        </a>
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('cm-unit.create') }}"
                           data-title="{{ __('Create CM Unit') }}">
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
                                @foreach(['schema_id','retrofit','nailon','block','le3_clr','le3_lam','clr_temp','le3_temp','lam_temp','feat1','feat2','feat3','clr_clr','le3_clr_le3','le3_combo','sta_grid','tpi','tpo','acid_edge','solar_cool','status'] as $field)
                                <th>{{ __(ucwords(str_replace('_',' ', $field))) }}</th>
                                @endforeach
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cmunits as $unit)
                                <tr>
                                    @foreach(['schema_id','retrofit','nailon','block','le3_clr','le3_lam','clr_temp','le3_temp','lam_temp','feat1','feat2','feat3','clr_clr','le3_clr_le3','le3_combo','sta_grid','tpi','tpo','acid_edge','solar_cool','status'] as $field)
                                    <td>{{ $unit->$field }}</td>
                                    @endforeach
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info customModal"
                                           data-size="lg"
                                           data-url="{{ route('cm-unit.edit', $unit->id) }}"
                                           data-title="{{ __('Edit CM Unit') }}">
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
