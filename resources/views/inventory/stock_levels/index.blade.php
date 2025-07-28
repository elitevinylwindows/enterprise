@extends('layouts.app')
@section('page-title', __('Stock Levels'))
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Stock Levels') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('Stock Levels') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('inventory.stock-level.create') }}"
                           data-title="{{ __('Create Stock Level') }}">
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
        <th>{{ __('Product') }}</th>
        <th>{{ __('Location') }}</th>
        <th>{{ __('Stock On Hand') }}</th>
        <th>{{ __('Reserved') }}</th>
        <th>{{ __('Available') }}</th>
        <th>{{ __('Min. Level') }}</th>
        <th>{{ __('Max. Level') }}</th>
        <th>{{ __('Reorder Level') }}</th>
        <th>{{ __('Action') }}</th>
    </tr>
</thead>
<tbody>
    @foreach ($stockLevels as $level)
    <tr>
        <td>{{ $level->product->name ?? '' }}</td>
        <td>{{ $level->location->name ?? '' }}</td>
        <td>{{ $level->stock_on_hand ?? 0 }}</td>
        <td>{{ $level->stock_reserved ?? 0 }}</td>
        <td>{{ $level->stock_available ?? 0 }}</td>
        <td>{{ $level->minimum_level ?? 0 }}</td>
        <td>{{ $level->maximum_level ?? 0 }}</td>
        <td>{{ $level->reorder_level ?? 0 }}</td>
        <td>
            <a href="#" class="btn btn-sm btn-info customModal"
               data-size="lg"
               data-url="{{ route('inventory.stock-level.edit', $level->id) }}"
               data-title="{{ __('Edit Stock Level') }}">
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