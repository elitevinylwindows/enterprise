@extends('layouts.app')

@section('page-title', 'Kanban Board')
@endsection
@section('content')
<div class="row" id="kanban-board">
    @foreach($statuses as $statusKey => $statusLabel)
        <div class="col-md-3">
            <h5 class="text-capitalize">{{ $statusLabel }}</h5>
            <div class="kanban-column" data-status="{{ $statusKey }}">
                @foreach($leadsByStatus[$statusKey] as $card)
                    <div class="kanban-card card mb-2" data-id="{{ $card->id }}">
                        <div class="card-body">
                            <strong>{{ $card->name }}</strong><br>
                            <small>{{ $card->phone }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection

@push('styles')
<style>
    .kanban-column {
        min-height: 300px;
        background-color: #f8f9fa;
        padding: 10px;
        border: 1px solid #dee2e6;
    }

    .kanban-card {
        background: white;
        border: 1px solid #ccc;
        margin-bottom: 10px;
        padding: 10px;
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
    });
</script>
@endpush
