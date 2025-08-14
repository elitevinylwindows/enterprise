@extends('layouts.app')

@section('page-title', __('Lines'))

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Lines') }}</li>
@endsection

@section('content')

<div class="mb-4"></div> {{-- Space after title --}}
<div class="mb-4"></div> {{-- Space --}}

<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('manufacturing.lines.index', ['status' => 'all']) }}"
                   class="list-group-item {{ ($status ?? 'all') === 'all' ? 'active' : '' }}">
                    {{ __('All Lines') }}
                </a>
                <a href="{{ route('manufacturing.lines.index', ['status' => 'active']) }}"
                   class="list-group-item {{ ($status ?? '') === 'active' ? 'active' : '' }}">
                    {{ __('Active') }}
                </a>
                <a href="{{ route('manufacturing.lines.index', ['status' => 'inactive']) }}"
                   class="list-group-item {{ ($status ?? '') === 'inactive' ? 'active' : '' }}">
                    {{ __('Inactive') }}
                </a>
                <a href="{{ route('manufacturing.lines.index', ['status' => 'deleted']) }}"
                   class="list-group-item text-danger {{ ($status ?? '') === 'deleted' ? 'active' : '' }}">
                    {{ __('Deleted') }}
                </a>
            </div>
        </div>
    </div>

    <div class="col-sm-10">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('Lines') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('manufacturing.lines.create') }}"
                           data-title="{{ __('Create Line') }}">
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
                                <th>{{ __('Line') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lines as $line)
                            <tr>
                                <td>{{ $line->id }}</td>
                                <td>{{ $line->line }}</td>
                                <td>{{ $line->description }}</td>
                                <td>
                                    <span class="badge bg-light-{{ $line->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($line->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('manufacturing.lines.edit', $line->id) }}"
                                       data-title="{{ __('Edit Line') }}">
                                       <i data-feather="edit"></i>
                                    </a>

                                    <form action="{{ route('manufacturing.lines.destroy', $line->id) }}"
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
