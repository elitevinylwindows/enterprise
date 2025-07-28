@extends('layouts.app')

@section('page-title')
    {{ __('Leads') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Leads') }}</li>
@endsection

@section('card-action-btn')
<form action="{{ route('leads.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-block">
    @csrf
    <input type="file" name="import_file" accept=".csv, .xls, .xlsx" required class="form-control d-inline-block w-auto">
    <button type="submit" class="btn btn-sm btn-primary">
        <i data-feather="upload"></i> Import Leads
    </button>
</form>

     <!-- <a class="btn btn-outline-primary btn-sm" href="{{ route('cims.import') }}">
        <i class="ti ti-upload"></i> {{ __('Import cims') }}
    </a>
  <a class="btn btn-outline-success btn-sm" href="{{ route('cims.create') }}">
        <i class="ti ti-plus"></i> {{ __('Add cim') }}
    </a>-->
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
  <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Leads') }}</h5>
                    </div>
                                           <div class="col-auto">
    <div class="d-flex flex-wrap gap-2 align-items-center">
        
              <form action="{{ route('leads.reassignUnassigned') }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-sm btn-primary">
       <i class="ti ti-refresh"></i> Assign Unassigned Leads
    </button>
</form>

                </div>
            </div>
              </div>
            </div>
      <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="leadsTable">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>License #</th>
                    <th>Name</th>
                    <th>Phone #</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Zip</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leads as $lead)
                    <tr>
                        <td><input type="checkbox" class="lead-checkbox" value="{{ $lead->id }}"></td>
                        <td>{{ $lead->license_number }}</td>
                        <td>{{ $lead->name }}</td>
                        <td>{{ $lead->phone }}</td>
                        <td>{{ $lead->address }}</td>
                        <td>{{ $lead->city }}</td>
                        <td>{{ $lead->zip }}</td>
                      <td style="white-space: nowrap;">
    <span id="status-badge-{{ $lead->id }}" class="badge bg-primary text-capitalize">{{ $lead->status }}</span>

    <div class="dropdown d-inline">
        <button class="btn btn-sm btn-outline-white text-white dropdown-toggle" type="button" data-bs-toggle="dropdown">
            Update
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item call-status-update" data-id="{{ $lead->id }}" data-status="call_back" href="#">🔁 Call Back Requested</a></li>
            <li><a class="dropdown-item call-status-update" data-id="{{ $lead->id }}" data-status="wrong_number" href="#">❌ Wrong Number</a></li>
            <li><a class="dropdown-item call-status-update" data-id="{{ $lead->id }}" data-status="voicemail" href="#">📴 Voicemail Left</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item call-status-update" data-id="{{ $lead->id }}" data-status="spoke" href="#">💬 Spoke with Contractor</a></li>
            <li><a class="dropdown-item call-status-update" data-id="{{ $lead->id }}" data-status="info_sent" href="#">📩 Info Sent</a></li>
            <li><a class="dropdown-item call-status-update" data-id="{{ $lead->id }}" data-status="not_interested" href="#">🚫 Not Interested</a></li>
            <li><a class="dropdown-item call-status-update" data-id="{{ $lead->id }}" data-status="considering" href="#">⏳ Considering Us</a></li>
             <li><a class="dropdown-item call-status-update" data-id="{{ $lead->id }}" data-status="considering" href="#">🚫 Do Not Call</a></li>
        </ul>
    </div>
</td>


                        <td>
                            @php
    $formattedNumber = '+1' . preg_replace('/\D/', '', $lead->phone);
@endphp

<a href="tel:{{ $formattedNumber }}"
   class="avtar avtar-xs btn-link-success text-success"
   data-bs-toggle="tooltip" title="Call via RingCentral App">
    <i data-feather="phone"></i>
</a>
        <a class="avtar avtar-xs btn-link-warning text-warning customModal"
           data-bs-toggle="tooltip" title="{{ __('Edit') }}" href="#"
           data-size="lg" data-url="{{ route('leads.edit', $lead->id) }}"
           data-title="{{ __('Edit Lead') }}">
            <i data-feather="edit"></i>
        </a>
                           <a class="avtar avtar-sm btn-link-danger text-danger confirm_dialog"
           data-bs-toggle="tooltip" title="{{ __('Delete') }}" href="{{ route('leads.destroy', $lead->id) }}">
            <i data-feather="trash-2"></i>
        </a>
                            <!--<form action="{{ route('leads.destroy', $lead->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="avtar avtar-xs btn-link-danger text-danger confirm_dialog" onclick="return confirm('Delete this lead?')"><i data-feather="trash-2"></i></button>
                            </form>-->
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

@push('scripts')
<script>
    document.getElementById('select-all').addEventListener('click', function() {
        let checked = this.checked;
        document.querySelectorAll('.lead-checkbox').forEach(cb => cb.checked = checked);
    });

    $(document).on('click', '.customModal', function (e) {
        e.preventDefault();

        const url = $(this).data('url');
        const title = $(this).data('title') || 'Modal';
        const size = $(this).data('size') || 'md';

        $('#mainModal .modal-dialog').removeClass('modal-sm modal-md modal-lg modal-xl').addClass('modal-' + size);
        $('#mainModal .modal-title').text(title);
        $('#mainModal .modal-body').html('<div class="text-center p-5"><i class="ti ti-loader ti-spin"></i> Loading...</div>');

        $('#mainModal').modal('show');

        $.get(url, function (data) {
            $('#mainModal .modal-body').html(data);
        }).fail(function () {
            $('#mainModal .modal-body').html('<div class="alert alert-danger">Failed to load content.</div>');
        });
    });
    
</script>
<script>
    $(document).on('click', '.call-status-update', function (e) {
        e.preventDefault();

        const leadId = $(this).data('id');
        const newStatus = $(this).data('status');

        $.ajax({
            url: '{{ route('leads.updateStatus') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: leadId,
                status: newStatus
            },
            success: function () {
                $('#status-badge-' + leadId).text(newStatus.replace('_', ' ')).addClass('bg-primary');
                toastr.success('Status updated!');
            },
            error: function () {
                toastr.error('Failed to update status.');
            }
        });
    });
</script>


@endpush
