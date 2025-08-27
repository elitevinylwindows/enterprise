@extends('layouts.app')
@section('page-title', __('GSCO CM Unit'))
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('GSCO CM Unit') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('GSCO CM Unit') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-model="GSCOCMUnit"
                           data-url="{{ route('schemas.import.form') }}"
                           data-title="{{ __('Import GSCO CM Unit') }}">
                           <i data-feather="plus"></i> {{ __('Import') }}
                        </a>
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('hs-unit.create') }}"
                           data-title="{{ __('Create GSCO CM Unit') }}">
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
        <th>{{ __('Retrofit') }}</th>
        <th>{{ __('Nailon') }}</th>
        <th>{{ __('Block') }}</th>
        <th>{{ __('Le3 Clr') }}</th>
        <th>{{ __('Le3 Lam') }}</th>
        <th>{{ __('Clr Temp') }}</th>
        <th>{{ __('OneLe3 OneClr Temp') }}</th>
        <th>{{ __('Lam Temp') }}</th>
        <th>{{ __('Feat1') }}</th>
        <th>{{ __('Feat2') }}</th>
        <th>{{ __('Feat3') }}</th>
        <th>{{ __('Clr Clr') }}</th>
        <th>{{ __('Le3 Clr Le3') }}</th>
        <th>{{ __('TwoLe3 OneClr Temp') }}</th>
        <th>{{ __('Sta Grid') }}</th>
        <th>{{ __('TPI') }}</th>
        <th>{{ __('TPO') }}</th>
        <th>{{ __('Status') }}</th>
        <th>{{ __('Action') }}</th>
    </tr>
</thead>
<tbody>
    @foreach ($gscocmunits as $gscocmunit)
    <tr>
        <td>{{ $gscocmunit->id }}</td>
        <td>{{ $gscocmunit->schema_id }}</td>
        <td>{{ $gscocmunit->product_id }}</td>
        <td>{{ $gscocmunit->product_code }}</td>
        <td>{{ $gscocmunit->retrofit }}</td>
        <td>{{ $gscocmunit->nailon }}</td>
        <td>{{ $gscocmunit->block }}</td>
        <td>{{ $gscocmunit->le3_clr }}</td>
        <td>{{ $gscocmunit->le3_lam }}</td>
        <td>{{ $gscocmunit->clr_temp }}</td>
        <td>{{ $gscocmunit->onele3_oneclr_temp }}</td>
        <td>{{ $gscocmunit->lam_temp }}</td>
        <td>{{ $gscocmunit->feat1 }}</td>
        <td>{{ $gscocmunit->feat2 }}</td>
        <td>{{ $gscocmunit->feat3 }}</td>
        <td>{{ $gscocmunit->clr_clr }}</td>
        <td>{{ $gscocmunit->le3_clr_le3 }}</td>
        <td>{{ $gscocmunit->twole3_oneclr_temp }}</td>
        <td>{{ $gscocmunit->sta_grid }}</td>
        <td>{{ $gscocmunit->tpi }}</td>
        <td>{{ $gscocmunit->tpo }}</td>
        <td>{{ $gscocmunit->status }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('hs-unit.edit', $gscocmunit->id) }}"
                                       data-title="{{ __('Edit GSCO CM Unit') }}">
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
