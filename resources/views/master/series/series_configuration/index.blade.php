@extends('layouts.app')

@section('page-title', __('Configurations - PT'))

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
  <li class="breadcrumb-item">{{ __('Master') }}</li>
  <li class="breadcrumb-item active" aria-current="page">{{ __('Configurations - PT') }}</li>
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
          <div class="col"><h5>{{ __('Configurations - Product Type') }}</h5></div>
          <div class="col-auto">
            <a href="#"
   class="btn btn-outline-primary customModal"
   data-size="lg"
   data-title="{{ __('Import Series & Product Types') }}"
   data-url="{{ route('master.series-configuration.import.form') }}">
  <i class="fa-solid fa-file-import"></i> {{ __('Import') }}
</a>

            <a href="#"
               class="btn btn-primary customModal"
               data-size="lg"
               data-title="{{ __('Add Series Type') }}"
               data-url="{{ route('master.series-configuration.create') }}">
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
                <th>{{ __('Series Type') }}</th>
                <th>{{ __('Product Types') }}</th>
                <th>{{ __('Actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($seriesTypes as $st)
                <tr>
                  <td>{{ $st->id }}</td>
                  <td><span class="badge bg-primary">{{ $st->series_type }}</span></td>
                  <td>
                    @forelse($st->productTypes as $pt)
                      <span class="badge bg-secondary me-1 mb-1">{{ $pt->product_type ?? $pt->name }}</span>
                    @empty
                      <span class="text-muted">-</span>
                    @endforelse
                  </td>
                  <td>
                    <a href="#"
                       class="btn btn-sm btn-info customModal"
                       data-size="lg"
                       data-title="{{ __('Edit Series Type') }}"
                       data-url="{{ route('master.series-configuration.edit', $st->id) }}">
                      <i data-feather="edit"></i>
                    </a>

                    <form action="{{ route('master.series-configuration.destroy', $st->id) }}"
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
