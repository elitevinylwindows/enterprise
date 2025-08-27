@extends('layouts.app')
@section('page-title', __('GSCO SWD Units'))
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('GSCO SWD Units') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('GSCO SWD Units') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-model="GSCOSWDUnit"
                           data-url="{{ route('schemas.import.form') }}"
                           data-title="{{ __('Import GSCO SWD Unit') }}">
                           <i data-feather="plus"></i> {{ __('Import') }}
                        </a>
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('hs-unit.create') }}"
                           data-title="{{ __('Create GSCO SWD Unit') }}">
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
        <th>{{ __('ID') }}</th>
        <th>{{ __('Schema Id') }}</th>
        <th>{{ __('Product Id') }}</th>
        <th>{{ __('Product Code') }}</th>
        <th>{{ __('Clr Clr') }}</th>
        <th>{{ __('Le3 Clr') }}</th>
        <th>{{ __('Le3 Clr Le3') }}</th>
        <th>{{ __('Le3 Lam') }}</th>
        <th>{{ __('Clr Lam') }}</th>
        <th>{{ __('Color Multi') }}</th>
        <th>{{ __('Base Multi') }}</th>
        <th>{{ __('Feat1') }}</th>
        <th>{{ __('Feat2') }}</th>
        <th>{{ __('Feat3') }}</th>
        <th>{{ __('Status') }}</th>
        <th>{{ __('Action') }}</th>
    </tr>
</thead>
<tbody>
    @foreach ($gscoswdunits as $gscoswdunit)
    <tr>
        <td>{{ $gscoswdunit->id }}</td>
        <td>{{ $gscoswdunit->schema_id }}</td>
        <td>{{ $gscoswdunit->product_id }}</td>
        <td>{{ $gscoswdunit->product_code }}</td>
        <td>{{ $gscoswdunit->clr_clr }}</td>
        <td>{{ $gscoswdunit->le3_clr }}</td>
        <td>{{ $gscoswdunit->le3_clr_le3 }}</td>
        <td>{{ $gscoswdunit->le3_lam }}</td>
        <td>{{ $gscoswdunit->clr_lam }}</td>
        <td>{{ $gscoswdunit->color_multi }}</td>
        <td>{{ $gscoswdunit->base_multi }}</td>
        <td>{{ $gscoswdunit->feat1 }}</td>
        <td>{{ $gscoswdunit->feat2 }}</td>
        <td>{{ $gscoswdunit->feat3 }}</td>
        <td>{{ $gscoswdunit->status }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('hs-unit.edit', $gscoswdunit->id) }}"
                                       data-title="{{ __('Edit GSCO SWD Unit') }}">
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
