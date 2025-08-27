@extends('layouts.app')

@section('page-title')
{{ __('PW Units') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item" aria-current="page">{{ __('PW Units') }}</li>
@endsection


@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('PW Units') }}</h5>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal" data-size="lg" data-model="PWUnit" data-url="{{ route('schemas.import.form') }}" data-title="{{ __('Import PW Unit') }}">
                            <i data-feather="plus"></i> {{ __('Import') }}
                        </a>
                        <a href="#" class="btn btn-primary customModal" data-size="lg" data-url="{{ route('pw-unit.create') }}" data-title="{{ __('Create PW Unit') }}">
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
                                <th>ID</th>
                                <th>Schema ID</th>
                                <th>Product ID</th>
                                <th>Product Code</th>
                                <th>Retrofit</th>
                                <th>Nailon</th>
                                <th>Block</th>
                                <th>LE3 CLR</th>
                                <th>CLR CLR</th>
                                <th>LE3 LAM</th>
                                <th>CLR TEMP</th>
                                <th>LE3 CLR LE3</th>
                                <th>TWOLE3 ONECLR TEMP</th>
                                <th>STA GRID</th>
                                <th>TPI</th>
                                <th>TPO</th>
                                <th>ACID EDGE</th>
                                <th>SOLAR COOL</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pwunits as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->schema_id }}</td>
                                <td>{{ $item->product_id }}</td>
                                <td>{{ $item->product_code }}</td>
                                <td>{{ $item->retrofit }}</td>
                                <td>{{ $item->nailon }}</td>
                                <td>{{ $item->block }}</td>
                                <td>{{ $item->le3_clr }}</td>
                                <td>{{ $item->clr_clr }}</td>
                                <td>{{ $item->le3_lam }}</td>
                                <td>{{ $item->clr_temp }}</td>
                                <td>{{ $item->le3_clr_le3 }}</td>
                                <td>{{ $item->twole3_oneclr_temp }}</td>
                                <td>{{ $item->sta_grid }}</td>
                                <td>{{ $item->tpi }}</td>
                                <td>{{ $item->tpo }}</td>
                                <td>{{ $item->acid_edge }}</td>
                                <td>{{ $item->solar_cool }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    <a href="{{ route('pw-unit.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('pw-unit.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
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
