@extends('layouts.app')

@section('page-title', __('Job Planning'))

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Job Planning') }}</li>
@endsection

@section('content')

<div class="mb-4"></div>
<div class="mb-4"></div>

<div class="row">
  {{-- Sidebar filters (optional) --}}
  <div class="col-md-2">
    <div class="card">
      <div class="list-group list-group-flush">
        <a href="{{ route('manufacturing.job_planning.index', ['status'=>'all']) }}"
           class="list-group-item {{ ($status ?? 'all') === 'all' ? 'active' : '' }}">All</a>
        <a href="{{ route('manufacturing.job_planning.index', ['status'=>'queued']) }}"
           class="list-group-item {{ ($status ?? '') === 'queued' ? 'active' : '' }}">Queued</a>
        <a href="{{ route('manufacturing.job_planning.index', ['status'=>'in_production']) }}"
           class="list-group-item {{ ($status ?? '') === 'in_production' ? 'active' : '' }}">In Production</a>
        <a href="{{ route('manufacturing.job_planning.index', ['status'=>'completed']) }}"
           class="list-group-item {{ ($status ?? '') === 'completed' ? 'active' : '' }}">Completed</a>
        <a href="{{ route('manufacturing.job_planning.index', ['status'=>'deleted']) }}"
           class="list-group-item text-danger {{ ($status ?? '') === 'deleted' ? 'active' : '' }}">Deleted</a>
      </div>
    </div>
  </div>

  <div class="col-sm-10">
    <div class="card table-card">
      <div class="card-header px-3 px-md-4">
        <div class="row align-items-center g-2">
          <div class="col"><h5 class="mb-0">{{ __('Job Planning') }}</h5></div>
          <div class="col-auto">
            <a href="#" class="btn btn-primary customModal"
               data-size="xl"
               data-url="{{ route('manufacturing.job_planning.create') }}"
               data-title="{{ __('Create Job Planning') }}">
               <i class="fa-solid fa-circle-plus"></i> {{ __('Create') }}
            </a>
          </div>
        </div>
      </div>

      <div class="card-body pt-0 px-3 px-md-4">
        <div class="dt-responsive table-responsive">
          <table class="table table-hover advance-datatable mb-0">
            <thead>
              <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Job Order #') }}</th>
                <th>{{ __('Series') }}</th>
                <th class="text-end">{{ __('Qty') }}</th>
                <th>{{ __('Line') }}</th>
                <th>{{ __('Delivery Date') }}</th>
                <th>{{ __('Type') }}</th>
                <th>{{ __('Production Status') }}</th>
                <th>{{ __('Entry Date') }}</th>
                <th>{{ __('Last Transaction Date') }}</th>
                <th>{{ __('Action') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($jobs as $job)
              <tr>
                <td>{{ $job->id }}</td>
                <td>{{ $job->job_order_number }}</td>
                <td>{{ $job->series }}</td>
                <td class="text-end">{{ $job->qty }}</td>
                <td>{{ $job->line }}</td>
                <td>{{ optional($job->delivery_date)->format('Y-m-d') }}</td>
                <td>{{ $job->type }}</td>
                <td>
                  <span class="badge bg-light-{{ in_array(strtolower($job->production_status), ['queued','pending']) ? 'warning' : (strtolower($job->production_status) === 'completed' ? 'success' : 'info') }}">
                    {{ ucwords(str_replace('_',' ',$job->production_status)) }}
                  </span>
                </td>
                <td>{{ optional($job->entry_date)->format('Y-m-d') }}</td>
                <td>{{ optional($job->last_transaction_date)->format('Y-m-d H:i') }}</td>
                <td>
                  <a href="#" class="btn btn-sm btn-info customModal"
                     data-size="xl"
                     data-url="{{ route('manufacturing.job_planning.edit', $job->id) }}"
                     data-title="{{ __('Edit Job Planning') }}">
                     <i data-feather="edit"></i>
                  </a>
                  <form action="{{ route('manufacturing.job_planning.destroy', $job->id) }}"
                        method="POST" class="d-inline">
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
      </div> {{-- /card-body --}}
    </div>
  </div>
</div>
@endsection
