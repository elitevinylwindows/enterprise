@extends('layouts.app')

@section('page-title')
    {{ __('SH Units') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('SH Units') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('SH Units') }}</h5>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-model="SHUnit"
                           data-url="{{ route('schemas.import.form') }}"
                           data-title="{{ __('Import SH Unit') }}">
                           <i data-feather="plus"></i> {{ __('Import') }}
                        </a>
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('sh-unit.create') }}"
                           data-title="{{ __('Create SH Unit') }}">
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
                                <th>{{ __('Schema ID') }}</th>
                                <th>{{ __('Product ID') }}</th>
                                <th>{{ __('Product Code') }}</th>
                                <th>{{ __('Retrofit') }}</th>
                                <th>{{ __('Nailon') }}</th>
                                <th>{{ __('Block') }}</th>
                                <th>{{ __('LE3 CLR') }}</th>
                                <th>{{ __('LE3 LAM') }}</th>
                                <th>{{ __('CLR TEMP') }}</th>
                                <th>{{ __('LE3 TEMP') }}</th>
                                <th>{{ __('LAM TEMP') }}</th>
                                <th>{{ __('Feat1') }}</th>
                                <th>{{ __('Feat2') }}</th>
                                <th>{{ __('Feat3') }}</th>
                                <th>{{ __('CLR CLR') }}</th>
                                <th>{{ __('LE3 CLR LE3') }}</th>
                                <th>{{ __('LE3 COMBO') }}</th>
                                <th>{{ __('STA GRID') }}</th>
                                <th>{{ __('TPI') }}</th>
                                <th>{{ __('TPO') }}</th>
                                <th>{{ __('Acid Edge') }}</th>
                                <th>{{ __('Solar Cool') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shunits as $unit)
                                <tr>
                                    <td>{{ $unit->schema_id }}</td>
                                    <td>{{ $unit->product_id }}</td>
                                    <td>{{ $unit->product_code }}</td>
                                    <td>{{ $unit->retrofit }}</td>
                                    <td>{{ $unit->nailon }}</td>
                                    <td>{{ $unit->block }}</td>
                                    <td>{{ $unit->le3_clr }}</td>
                                    <td>{{ $unit->le3_lam }}</td>
                                    <td>{{ $unit->clr_temp }}</td>
                                    <td>{{ $unit->le3_temp }}</td>
                                    <td>{{ $unit->lam_temp }}</td>
                                    <td>{{ $unit->feat1 }}</td>
                                    <td>{{ $unit->feat2 }}</td>
                                    <td>{{ $unit->feat3 }}</td>
                                    <td>{{ $unit->clr_clr }}</td>
                                    <td>{{ $unit->le3_clr_le3 }}</td>
                                    <td>{{ $unit->le3_combo }}</td>
                                    <td>{{ $unit->sta_grid }}</td>
                                    <td>{{ $unit->tpi }}</td>
                                    <td>{{ $unit->tpo }}</td>
                                    <td>{{ $unit->acid_edge }}</td>
                                    <td>{{ $unit->solar_cool }}</td>
                                    <td>{{ $unit->status }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info customModal"
                                           data-size="lg"
                                           data-url="{{ route('sh-unit.edit', $unit->id) }}"
                                           data-title="{{ __('Edit SH Unit') }}">
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
