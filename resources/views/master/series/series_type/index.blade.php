@extends('layouts.app')

@section('page-title', __('Series Types'))

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
  <li class="breadcrumb-item">{{ __('Master') }}</li>
  <li class="breadcrumb-item active" aria-current="page">{{ __('Series Types') }}</li>
@endsection

@section('content')

<div class="mb-4"></div>
<div class="mb-4"></div>

<div class="row">
  {{-- Taskbar --}}
  <div class="col-md-2">
    <div class="card">
      <div class="list-group list-group-flush">
        <a href="{{ route('master.series-type.index') }}"
           class="list-group-item active">
          {{ __('All Configurations') }}
        </a>
      </div>
    </div>
  </div>

  <div class="col-sm-10">
    <div class="card table-card">
      <div class="card-header">
        <div class="row align-items-center g-2">
          <div class="col"><h5>{{ __('Series Types') }}</h5></div>
          <div class="col-auto">
            <a href="#"
               class="btn btn-primary customModal"
               data-size="lg"
               data-title="{{ __('Add Series Type') }}"
               data-url="{{ route('master.series-type.create') }}">
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
                <th>{{ __('Series') }}</th>
                <th>{{ __('Configuration') }}</th>
                <th>{{ __('Actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($seriesTypes as $st)
                <tr>
                  <td>{{ $st->id }}</td>
                  <td>{{ $st->series->series ?? '-' }}</td>
                  <td><span class="badge bg-primary">{{ $st->series_type }}</span></td>
                 
                  <td>
                    <a href="#"
                       class="btn btn-sm btn-info customModal"
                       data-size="lg"
                       data-title="{{ __('Edit Series Type') }}"
                       data-url="{{ route('master.series-type.edit', $st->id) }}">
                      <i data-feather="edit"></i>
                    </a>

                    <form action="{{ route('master.series-type.destroy', $st->id) }}"
                          method="POST" style="display:inline-block;">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger"
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
