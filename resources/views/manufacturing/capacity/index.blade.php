@extends('layouts.app')

@section('page-title', __('Capacity'))

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Capacity') }}</li>
@endsection

@section('content')

<div class="mb-4"></div> {{-- Space after title --}}
<div class="mb-4"></div> {{-- Space --}}

<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('manufacturing.capacity.index', ['status' => 'all']) }}"
                   class="list-group-item {{ ($status ?? 'all') === 'all' ? 'active' : '' }}">
                    All Capacity Records
                </a>
                <a href="{{ route('manufacturing.capacity.index', ['status' => 'over']) }}"
                   class="list-group-item {{ ($status ?? '') === 'over' ? 'active' : '' }}">
                    Over Limit
                </a>
                <a href="{{ route('manufacturing.capacity.index', ['status' => 'within']) }}"
                   class="list-group-item {{ ($status ?? '') === 'within' ? 'active' : '' }}">
                    Within Limit
                </a>
                <a href="{{ route('manufacturing.capacity.index', ['status' => 'deleted']) }}"
                   class="list-group-item text-danger {{ ($status ?? '') === 'deleted' ? 'active' : '' }}">
                    Deleted
                </a>
            </div>
        </div>
    </div>

    <div class="col-sm-10">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('Capacity') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('manufacturing.capacity.create') }}"
                           data-title="{{ __('Create Capacity Record') }}">
                           <i class="fa-solid fa-circle-plus"></i> {{ __('Create') }}
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
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Limit') }}</th>
                                <th>{{ __('Actual') }}</th>
                                <th>{{ __('Percentage') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($capacities as $capacity)
                            <tr>
                                <td>{{ $capacity->id }}</td>
                                <td>{{ $capacity->description }}</td>
                                <td>{{ $capacity->limit }}</td>
                                <td>{{ $capacity->actual }}</td>
                                <td>{{ $capacity->percentage }}%</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('manufacturing.capacity.edit', $capacity->id) }}"
                                       data-title="{{ __('Edit Capacity Record') }}">
                                       <i data-feather="edit"></i>
                                    </a>
                                    <form action="{{ route('manufacturing.capacity.destroy', $capacity->id) }}" 
                                          method="POST" 
                                          style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="return confirm('{{ __('Are you sure?') }}')">
                                            <i data-feather="trash-2"></i>
                                        </button>
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
