@extends('layouts.app')

@section('page-title', 'My Kanban')

@section('content')
<div class="row">
    <div class="col-12">
       <div class="kanban-board d-flex gap-4 overflow-auto">
    @foreach ($statuses as $statusKey => $label)
        <div class="kanban-column-wrapper">
            <div class="card bg-light rounded kanban-status" style="min-width: 280px;">
               <div class="card-header bg-white text-center font-weight-bold">
                                     {{ $label }}
                </div>
                <div class="card-body kanban-column" data-status="{{ $statusKey }}">
                   @foreach ($leadsByStatus[$statusKey] ?? [] as $lead)
    <div class="card mb-2 p-2 shadow-sm customModal"
         data-id="{{ $lead->id }}"
         data-url="{{ route('leads.edit', $lead->id) }}"
         data-title="Edit Lead"
         data-size="lg">
         
        @if ($lead->phone)
            <a href="tel:{{ preg_replace('/\D/', '', $lead->phone) }}"
               class="position-absolute top-0 end-0 m-1 avtar avtar-xs btn-link-success text-success"
               onclick="event.stopPropagation();"
               data-bs-toggle="tooltip" title="Call">
                <i data-feather="phone"></i>
            </a>
        @endif

        <strong>{{ $lead->name }}</strong><br>
        <small>{{ $lead->phone }} | {{ $lead->email }}</small>
    </div>
@endforeach

                </div>
            </div>
        </div>
    @endforeach
</div>

    </div>
</div>
@endsection



@push('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    $(function () {
        $(".kanban-column").sortable({
    connectWith: ".kanban-column",
    items: ".card",
    placeholder: "kanban-placeholder",
    tolerance: "pointer",
    revert: true,
    cursor: "move",
    receive: function (event, ui) {
        const leadId = ui.item.data("id"); // make sure this returns a valid number
        const newStatus = $(this).data("status"); // column receiving the card

        $.ajax({
            url: '{{ route("leads.updateStatus") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: leadId,
                status: newStatus
            },
            success: function () {
                toastr.success("Status updated!");
            },
            error: function () {
                toastr.error("Failed to update status.");
            }
        });
    }
}).disableSelection();

    });
</script>

<script>
$(document).on('click', '.customModal', function (e) {
    e.preventDefault();
    const url = $(this).data('url');
    const title = $(this).data('title') || 'Modal';
    const size = $(this).data('size') || 'md';

    $('#mainModal .modal-dialog')
        .removeClass('modal-sm modal-md modal-lg modal-xl')
        .addClass('modal-' + size);

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
@endpush
