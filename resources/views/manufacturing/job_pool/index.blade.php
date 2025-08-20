@extends('layouts.app')

@section('page-title', __('Job Pool'))

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Job Pool') }}</li>
@endsection

@section('content')

<div class="mb-4"></div> {{-- Space after title --}}
<div class="mb-4"></div> {{-- Space --}}

<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('manufacturing.job_pool.index', ['status' => 'all']) }}"
                   class="list-group-item {{ ($status ?? 'all') === 'all' ? 'active' : '' }}">
                    All Jobs
                </a>
                <a href="{{ route('manufacturing.job_pool.index', ['status' => 'queued']) }}"
                   class="list-group-item {{ ($status ?? '') === 'queued' ? 'active' : '' }}">
                    Queued
                </a>
                <a href="{{ route('manufacturing.job_pool.index', ['status' => 'in_production']) }}"
                   class="list-group-item {{ ($status ?? '') === 'in_production' ? 'active' : '' }}">
                    In Production
                </a>
                <a href="{{ route('manufacturing.job_pool.index', ['status' => 'completed']) }}"
                   class="list-group-item {{ ($status ?? '') === 'completed' ? 'active' : '' }}">
                    Completed
                </a>
                <a href="{{ route('manufacturing.job_pool.index', ['status' => 'deleted']) }}"
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
                    <div class="col"><h5>{{ __('Job Pool') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('manufacturing.job_pool.create') }}"
                           data-title="{{ __('Create Job') }}">
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
                                <th>{{ __('Order #') }}</th>
                                <th>{{ __('Customer #') }}</th>
                                <th>{{ __('Customer Name') }}</th>
                                <th>{{ __('Series') }}</th>
                                <th>{{ __('Color') }}</th>
                                <th>{{ __('Frame Type') }}</th>
                                <th>{{ __('Qty') }}</th>
                                <th>{{ __('Line') }}</th>
                                <th>{{ __('Delivery Date') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Production Status') }}</th>
                                <th>{{ __('Is Rush') }}</th>
                                <th>{{ __('Note') }}</th>
                                <th>{{ __('Entry Date') }}</th>
                                <th>{{ __('Last Transaction Date') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobs as $job)
                            <tr>
                                <td>{{ $job->id }}</td>
                                <td>{{ $job->order->order_number }}</td>
                                <td>{{ $job->customer_number }}</td>
                                <td>{{ $job->customer_name }}</td>
                                <td>{{ $job->series }}</td>
                                <td>{{ $job->color }}</td>
                                <td>{{ $job->frame_type }}</td>
                                <td>{{ $job->qty }}</td>
                                <td>{{ $job->line }}</td>
                                <td>{{ optional($job->delivery_date)->format('Y-m-d') }}</td>
                                <td>{{ $job->type }}</td>
                                <td>
                                    <span class="badge bg-light-{{ in_array(strtolower($job->production_status), ['queued','pending']) ? 'warning' : (strtolower($job->production_status) === 'completed' ? 'success' : 'info') }}">
                                        {{ ucfirst($job->production_status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light-primary">
                                        {{ ucfirst($job->order->is_rush ? ' Yes' : 'No') }}
                                    </span>
                                </td>
                                <td>{{ $job->profile }}</td>
                                <td>{{ optional($job->entry_date)->format('Y-m-d') }}</td>
                                <td>{{ optional($job->last_transaction_date)->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('manufacturing.job_pool.edit', $job->id) }}"
                                       data-title="{{ __('Edit Job') }}">
                                       <i data-feather="edit"></i>
                                    </a>
                                    <form action="{{ route('manufacturing.job_pool.destroy', $job->id) }}" 
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
