@extends('layouts.app')

@section('page-title')
{{ __('Job Planning') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Job Planning') }}</li>
@endsection

@section('content')
<div class="mb-4"></div> {{-- Space after title --}}


<div class="mb-4"></div> {{-- Space --}}



<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('manufacturing.job_planning.index', ['status' => 'all']) }}" class="list-group-item {{ $status === 'all' ? 'active' : '' }}">
                    All Manufacturing Orders
                </a>
                <a href="{{ route('manufacturing.job_planning.index', ['status' => 'processed']) }}" class="list-group-item {{ $status === 'pending' ? 'active' : '' }}">
                    Processed Jobs
                </a>
                <a href="{{ route('manufacturing.job_planning.index', ['status' => 'tempered']) }}" class="list-group-item {{ $status === 'partially_paid' ? 'active' : '' }}">
                    Tempered Jobs
                </a>
                <a href="{{ route('manufacturing.job_planning.index', ['status' => 'unprocessed']) }}" class="list-group-item {{ $status === 'fully_paid' ? 'active' : '' }}">
                    Unprocessed Jobs
                </a>
                <a href="{{ route('manufacturing.job_planning.index', ['status' => 'deleted']) }}" class="list-group-item text-danger {{ $status === 'deleted' ? 'active' : '' }}">
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
                        <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOrderModal">
                            <i class="fa-solid fa-paper-plane"></i> Collate Job
                        </a>
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
                            @foreach ($jobs as $job)
                            <tr>
                                <td>{{ $job->id }}</td>
                                <td>{{ $job->order->job_order_number ?? 'N/A' }}</td>
                                <td>{{ $job->station ?? 'N/A' }}</td>
                                <td>
                                    @if($status === 'deleted')
                                    <span class="badge bg-danger">Deleted</span>
                                    @else
                                    @if($job->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                    @elseif($job->status === 'draft')
                                    <span class="badge bg-secondary">Draft</span>
                                    @else
                                    <span class="badge bg-light text-muted">{{ ucfirst($job->status) }}</span>
                                    @endif
                                    @endif
                                </td>
                                <td>{{ $job->descriptipn ?? 'N/A' }}</td>
                                <td class="text-nowrap">
                                    @if($status === 'deleted')
                                    {{-- Restore Button --}}
                                    <form action="{{ route('manufacturing.job_planning.restore', $job->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="avtar avtar-xs btn-link-success text-success border-0 bg-transparent p-0" data-bs-toggle="tooltip" data-bs-original-title="Restore">
                                            <i data-feather="rotate-ccw"></i>
                                        </button>
                                    </form>

                                    {{-- Permanent Delete Button --}}
                                    <form action="{{ route('manufacturing.job_planning.force-delete', $invoice->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="avtar avtar-xs btn-link-danger text-danger border-0 bg-transparent p-0" data-bs-toggle="tooltip" data-bs-original-title="Delete Permanently" onclick="return confirm('Permanently delete this job?')">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
                                    @else
                                    {{-- Original Action Buttons --}}
                                    {{-- View --}}
                                    <a class="avtar avtar-xs btn-link-success text-success customModal" data-bs-toggle="tooltip" data-bs-original-title="View Job" href="#" data-size="xl" data-url="{{ route('manufacturing.job_planning.show', $job->id) }}" data-title="Job Summary">
                                        <i data-feather="eye"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a class="avtar avtar-xs btn-link-primary text-primary customModal" data-bs-toggle="tooltip" data-bs-original-title="Edit" href="#" data-size="xl" data-url="{{ route('manufacturing.job_planning.edit', $job->id) }}" data-title="Edit Job">
                                        <i data-feather="edit"></i>
                                    </a>

                                    {{-- Prioritize --}}
                                    <a class="avtar avtar-xs btn-link-success text-success" data-bs-toggle="tooltip" data-bs-original-title="Prioritize" href="{{ route('manufacturing.job_planning.prioritize', $job->id) }}" data-title="Prioritize">
                                        <i data-feather="share"></i>
                                    </a>

                                    {{-- Take Payment --}}
                                    <a class="avtar avtar-xs btn-link-success text-success customModal" data-bs-toggle="tooltip" title="Request Payment" href="#" data-size="lg" data-url="{{ route('manufacturing.job_planning.payment', $job->id) }}" data-title="Invoice Payment">
                                        <i data-feather="credit-card"></i>
                                    </a>

                                    
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>


                    </table>
                </div> <!-- table-responsive -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col -->


</div>
@endsection

@include('manufacturing.job_planning.create')

@push('scripts')

<script>
    $(document).ready(function() {

        @if($errors->any())
        @foreach($errors->all() as $error)
        toastr.error('{{ $error }}', 'Error', {
            timeOut: 3000
            , progressBar: true
            , closeButton: true
        });
        @endforeach
        @endif


        @if(session('error'))
        toastr.error('{{ session('
            error ') }}', 'Error', {
                timeOut: 3000
                , progressBar: true
                , closeButton: true
            });
        @endif
        // Add click handler for the email button
        $('.emailButton').on('click', function(e) {
            e.preventDefault();

            const $button = $(this);
            const $icon = $button.find('#emailIcon');
            const $spinner = $button.find('.spinner-border');
            const url = $button.data('url');

            // Show spinner and hide icon
            $icon.addClass('d-none');
            $spinner.removeClass('d-none');
            $button.prop('disabled', true);

            $.ajax({
                url: url
                , type: 'GET'
                , data: {
                    _token: '{{ csrf_token() }}'
                }
                , success: function(response) {
                    toastr.success('Email sent successfully!', 'Success', {
                        timeOut: 3000
                        , progressBar: true
                        , closeButton: true
                    });
                }
                , error: function(xhr) {
                    toastr.error('Failed to send email. Please try again.', 'Error', {
                        timeOut: 3000
                        , progressBar: true
                        , closeButton: true
                    });
                }
                , complete: function() {
                    // Always hide spinner and show icon when request is complete
                    $spinner.addClass('d-none');
                    $icon.removeClass('d-none');
                    $button.prop('disabled', false);
                }
            });
        });

        // Delete quote with confirmation
        $('.delete-quote-btn').on('click', function(e) {
            e.preventDefault();
            const $form = $(this).closest('form');
            if (confirm('Are you sure you want to delete this quote?')) {
                $form.submit();
            }
        });
    });

</script>
@endpush
