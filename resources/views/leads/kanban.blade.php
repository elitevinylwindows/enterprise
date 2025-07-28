@extends('layouts.app')

@section('page-title', 'Kanban Board')


@section('content')
<div class="mb-4">
</div>
<div class="kanban-scroll-wrapper-top">
    <div class="kanban-scroll-inner">
        &nbsp;
    </div>
</div>


<div id="kanban-scroll-wrapper" class="horizontal-scroll">
    <div id="kanban-scroll-wrapper" class="d-flex flex-nowrap gap-3" style="min-width: max-content;">
        @foreach($statuses as $statusKey => $statusLabel)
            <div class="kanban-column-wrapper">
                <div class="card bg-light">
                    <div class="card-header bg-white text-center font-weight-bold">
                        {{ $statusLabel }}
                    </div>
                    <div class="card-body kanban-column" data-status="{{ $statusKey }}">
                        @foreach($leadsByStatus[$statusKey] as $card)
                          <div class="kanban-card card mb-2 position-relative customModal"
     data-id="{{ $card->id }}"
     data-url="{{ route('leads.edit', $card->id) }}"
     data-title="Edit Lead"
     data-size="lg">

    {{-- Call button using avatar class --}}
    @if($card->phone)
        <a href="tel:{{ preg_replace('/\D/', '', $card->phone) }}"
           class="position-absolute top-0 end-0 m-1 avtar avtar-xs btn-link-success text-success"
           style="z-index: 10;"
           onclick="event.stopPropagation();"
           data-bs-toggle="tooltip" title="Call">
            <i data-feather="phone"></i>
        </a>
    @endif

    <div class="card-body p-2 pe-4">
        <strong>{{ $card->name }}</strong><br>
        <small>{{ $card->phone }}</small>
    </div>
</div>

                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection



@push('styles')
<style>
    .horizontal-scroll {
        position: relative;
        overflow-x: auto;
        padding-bottom: 20px;
        margin-top: 1rem;
    }

    .kanban-column-wrapper {
        min-width: 250px;
        max-width: 250px;
        flex: 0 0 auto;
    }

    .kanban-column {
        min-height: 200px;
        overflow-y: auto;
        background-color: #f8f9fa;
        padding: 8px;
        border: 1px dashed #ccc;
    }

    .kanban-card {
        background: #fff;
        border: 1px solid #ddd;
        padding: 6px;
        cursor: move;
    }

    .kanban-placeholder {
        border: 2px dashed #ccc;
        height: 50px;
        margin-bottom: 10px;
    }
    
</style>
@endpush




@push('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    $(function () {
        $(".kanban-column").sortable({
            connectWith: ".kanban-column",
            placeholder: "kanban-placeholder",
            receive: function (event, ui) {
                let cardId = ui.item.data("id");
                let newStatus = $(this).data("status");

                $.ajax({
                    url: "{{ route('leads.kanban.update-status') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: cardId,
                        status: newStatus
                    },
                    success: function () {
                        toastr.success("Lead status updated!");
                    },
                    error: function () {
                        toastr.error("Failed to update status.");
                    }
                });
            }
        }).disableSelection();


$(function () {
    const topScroll = document.querySelector('.kanban-scroll-wrapper-top');
    const bottomScroll = document.querySelector('.kanban-scroll-wrapper-bottom');

    topScroll.addEventListener('scroll', () => {
        bottomScroll.scrollLeft = topScroll.scrollLeft;
    });

    bottomScroll.addEventListener('scroll', () => {
        topScroll.scrollLeft = bottomScroll.scrollLeft;
    });
});



        // Modal trigger
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
    });
</script>
@endpush

