@extends('layouts.app')

@section('page-title')
{{ __('Job Planning') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Job Planning') }}</li>
@endsection

@section('content')
@php $current = $status ?? 'all'; @endphp

<div class="mb-4"></div>
<div class="mb-4"></div>

<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('manufacturing.job_planning.index', ['status' => 'all']) }}"
                   class="list-group-item {{ $current === 'all' ? 'active' : '' }}">
                    All Manufacturing Orders
                </a>
                <a href="{{ route('manufacturing.job_planning.index', ['status' => 'processed']) }}"
                   class="list-group-item {{ $current === 'processed' ? 'active' : '' }}">
                    Processed Jobs
                </a>
                <a href="{{ route('manufacturing.job_planning.index', ['status' => 'tempered']) }}"
                   class="list-group-item {{ $current === 'tempered' ? 'active' : '' }}">
                    Tempered Jobs
                </a>
                <a href="{{ route('manufacturing.job_planning.index', ['status' => 'unprocessed']) }}"
                   class="list-group-item {{ $current === 'unprocessed' ? 'active' : '' }}">
                    Unprocessed Jobs
                </a>
                <a href="{{ route('manufacturing.job_planning.index', ['status' => 'deleted']) }}"
                   class="list-group-item text-danger {{ $current === 'deleted' ? 'active' : '' }}">
                    Deleted
                </a>
            </div>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="col-sm-10">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Manufacturing Orders') }}</h5>
                    </div>
                    <div class="col-auto ms-auto">
                        {{-- IMPORTANT: target must match the modal id below --}}
                        <button type="button" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#createJobModal">
                            <i class="fa-solid fa-paper-plane"></i> Collate Job
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="jobsTable">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Job Order #') }}</th>
                                <th>{{ __('Station') }}</th>
                                <th>{{ __('Production Status') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobs as $job)
                                <tr>
                                    <td>{{ $job->id }}</td>
                                    <td>{{ $job->order->job_order_number ?? 'N/A' }}</td>
                                    <td>{{ $job->station ?? 'N/A' }}</td>
                                    <td>
                                        @if($current === 'deleted')
                                            <span class="badge bg-danger">Deleted</span>
                                        @else
                                            @switch($job->status)
                                                @case('active')      <span class="badge bg-success">Active</span> @break
                                                @case('draft')       <span class="badge bg-secondary">Draft</span> @break
                                                @case('processed')   <span class="badge bg-info text-dark">Processed</span> @break
                                                @case('tempered')    <span class="badge bg-warning text-dark">Tempered</span> @break
                                                @case('unprocessed') <span class="badge bg-light text-muted">Unprocessed</span> @break
                                                @default             <span class="badge bg-light text-muted">{{ ucfirst($job->status ?? 'n/a') }}</span>
                                            @endswitch
                                        @endif
                                    </td>
                                    <td>{{ $job->description ?? 'N/A' }}</td>
                                    <td class="text-nowrap">
                                        @if($current === 'deleted')
                                            {{-- Restore --}}
                                            <form action="{{ route('manufacturing.job_planning.restore', $job->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="avtar avtar-xs btn-link-success text-success border-0 bg-transparent p-0"
                                                        data-bs-toggle="tooltip" title="Restore">
                                                    <i data-feather="rotate-ccw"></i>
                                                </button>
                                            </form>
                                            {{-- Force Delete --}}
                                            <form action="{{ route('manufacturing.job_planning.force-delete', $job->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="avtar avtar-xs btn-link-danger text-danger border-0 bg-transparent p-0"
                                                        data-bs-toggle="tooltip" title="Delete Permanently"
                                                        onclick="return confirm('Permanently delete this job?')">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        @else
                                            {{-- View (AJAX modal via your customModal handler) --}}
                                            <a class="avtar avtar-xs btn-link-success text-success customModal"
                                               data-bs-toggle="tooltip" title="View Job"
                                               href="#"
                                               data-size="xl"
                                               data-url="{{ route('manufacturing.job_planning.show', $job->id) }}"
                                               data-title="Job Summary">
                                                <i data-feather="eye"></i>
                                            </a>

                                            {{-- Edit (AJAX modal) --}}
                                            <a class="avtar avtar-xs btn-link-primary text-primary customModal"
                                               data-bs-toggle="tooltip" title="Edit Job"
                                               href="#"
                                               data-size="xl"
                                               data-url="{{ route('manufacturing.job_planning.edit', $job->id) }}"
                                               data-title="Edit Job">
                                                <i data-feather="edit"></i>
                                            </a>

                                            {{-- Prioritize --}}
                                            <a class="avtar avtar-xs btn-link-success text-success"
                                               data-bs-toggle="tooltip" title="Prioritize"
                                               href="{{ route('manufacturing.job_planning.prioritize', $job->id) }}">
                                                <i data-feather="share"></i>
                                            </a>

                                            {{-- Payment (AJAX modal) --}}
                                            <a class="avtar avtar-xs btn-link-success text-success customModal"
                                               data-bs-toggle="tooltip" title="Request Payment"
                                               href="#"
                                               data-size="lg"
                                               data-url="{{ route('manufacturing.job_planning.payment', $job->id) }}"
                                               data-title="Invoice Payment">
                                                <i data-feather="credit-card"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No jobs found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> <!-- table-responsive -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col -->
</div>

{{-- ====== Create Job Modal (embedded so the button can open it) ====== --}}
<div class="modal fade" id="createJobModal" tabindex="-1" aria-labelledby="createJobLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form method="POST" action="{{ route('manufacturing.job_planning.store') }}" id="jobCreateForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Job</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          {{-- Row 1 --}}
          <div class="row mb-3">
            <div class="col-md-4">
              <label>Order ID</label>
              <input type="number" name="order_id" class="form-control" placeholder="Internal Order ID" required>
              <small class="text-muted">Link this job to an existing order.</small>
            </div>
            <div class="col-md-4">
              <label>Status</label>
              <select name="status" class="form-control" required>
                @foreach(['unprocessed'=>'Unprocessed','processed'=>'Processed','tempered'=>'Tempered','active'=>'Active','draft'=>'Draft'] as $v=>$l)
                  <option value="{{ $v }}">{{ $l }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label>Priority</label>
              <input type="number" name="priority" class="form-control" min="0" step="1" value="0">
            </div>
          </div>

          {{-- Row 2 --}}
          <div class="row mb-3">
            <div class="col-md-6">
              <label>Station</label>
              @if(isset($stations) && count($stations))
                <select name="station" class="form-control">
                  @foreach($stations as $s)
                    <option value="{{ $s->station_number }}">{{ $s->station_number }} — {{ $s->description }}</option>
                  @endforeach
                </select>
              @else
                <input type="text" name="station" class="form-control" placeholder="e.g., ST-01">
              @endif
            </div>
            <div class="col-md-6">
              <label>Description</label>
              <input type="text" name="description" class="form-control" placeholder="Short description (optional)">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create Job</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    // DataTable init (exactly 6 columns)
    if ($.fn.DataTable) {
        $('#jobsTable').DataTable({
            pageLength: 25,
            order: [[0, 'desc']],
            columnDefs: [{ targets: -1, orderable: false, searchable: false }]
        });
    }

    // Feather icons refresh (if not already handled globally)
    if (window.feather) feather.replace();

    // Optional: quick check modal exists
    const m = document.getElementById('createJobModal');
    if (!m) { console.error('Create Job modal not found in DOM'); }
});
</script>
@endpush
