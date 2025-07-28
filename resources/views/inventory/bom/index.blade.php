@extends('layouts.app')

@section('page-title')
    {{ __('BOM') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('BOM') }}</li>
@endsection

@section('card-action-btn')
<form action="{{ route('inventory.bom.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-block">
    @csrf
    <input type="file" name="import_file" accept=".csv, .xls, .xlsx" required class="form-control d-inline-block w-auto">
    <button type="submit" class="btn btn-sm btn-primary">
        <i data-feather="upload"></i> Import BOM
    </button>
    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
    <i class="ti ti-plus"></i> {{ __('Add Material') }}
</button>

</form>

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
  <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('BOM') }}</h5>
                    </div>
                                           <div class="col-auto">

            </div>
              </div>
            </div>
      <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="bomsTable">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Material Name</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Vendor</th>
                    <th>Price</th>
                    <th>Sold By</th>
                    <th>L in/Each Pcs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($boms as $bom)
                    <tr>
                        <td><input type="checkbox" class="bom-checkbox" value="{{ $bom->id }}"></td>
            <td>{{ $bom->material_name }}</td>
            <td>{{ $bom->description }}</td>
            <td>{{ $bom->unit }}</td>
            <td>{{ $bom->vendor }}</td>
            <td>${{ number_format($bom->price, 2) }}</td>
            <td>{{ $bom->sold_by }}</td>
            <td>{{ $bom->lin_pcs }}</td>
            <td>
                <a href="{{ route('inventory.bom.edit', $bom->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('inventory.bom.destroy', $bom->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-primary" onclick="return confirm('Are you sure?')">Delete</button>
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
@endsection

<!-- Add Material Modal -->
<div class="modal fade" id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMaterialLabel">Add Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @include('inventory.bom.create') {{-- or paste the form inline if no partial --}}
        </div>
    </div>
</div>


@push('scripts')
<script>
    document.getElementById('select-all').addEventListener('click', function() {
        let checked = this.checked;
        document.querySelectorAll('.bom-checkbox').forEach(cb => cb.checked = checked);
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


@endpush
