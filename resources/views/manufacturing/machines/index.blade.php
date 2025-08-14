@extends('layouts.app')

@section('page-title', __('Machines'))

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Machines') }}</li>
@endsection




@section('content')


<div class="mb-4"></div> {{-- Space after title --}}
<div class="mb-4"></div> {{-- Space --}}

<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('manufacturing.machines.index', ['status' => 'all']) }}"
                   class="list-group-item {{ ($status ?? 'all') === 'all' ? 'active' : '' }}">
                    All Machines
                </a>
                <a href="{{ route('manufacturing.machines.index', ['status' => 'csv']) }}"
                   class="list-group-item {{ ($status ?? '') === 'csv' ? 'active' : '' }}">
                    .CSV
                </a>
                <a href="{{ route('manufacturing.machines.index', ['status' => 'xml']) }}"
                   class="list-group-item {{ ($status ?? '') === 'xml' ? 'active' : '' }}">
                    .XML
                </a>
                <a href="{{ route('manufacturing.machines.index', ['status' => 'deleted']) }}"
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
                    <div class="col"><h5>{{ __('Machines') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('manufacturing.machines.create') }}"
                           data-title="{{ __('Create Machine') }}">
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
                                <th>{{ __('Machine') }}</th>
                                <th>{{ __('File Type') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($machines as $machine)
                            <tr>
                                <td>{{ $machine->id }}</td>
                                <td>{{ $machine->machine }}</td>
                                <td>{{ $machine->file_type }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('manufacturing.machines.edit', $machine->id) }}"
                                       data-title="{{ __('Edit Machine') }}">
                                       <i data-feather="edit"></i>
                                    </a>
                                    <form action="{{ route('manufacturing.machines.destroy', $machine->id) }}" 
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

@endsection
