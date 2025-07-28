@extends('layouts.app')

@section('page-title')
    CRUD Generator
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">CRUD Generator</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Generate New CRUD Module</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('crud.generate') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="table_name" class="form-label">Table Name</label>
                        <input type="text" class="form-control" id="table_name" name="table_name" placeholder="e.g. suppliers" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fields</label>
                        <table class="table table-bordered" id="fieldsTable">
                            <thead>
                                <tr>
                                    <th>Field Name</th>
                                    <th>Field Type</th>
                                    <th>Nullable?</th>
                                    <th>Default</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="fields[0][name]" class="form-control" required></td>
                                    <td>
                                        <select name="fields[0][type]" class="form-control">
                                            <option value="string">String</option>
                                            <option value="text">Text</option>
                                            <option value="integer">Integer</option>
                                            <option value="float">Float</option>
                                            <option value="boolean">Boolean</option>
                                            <option value="date">Date</option>
                                            <option value="datetime">Datetime</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="fields[0][nullable]">
                                    </td>
                                    <td><input type="text" name="fields[0][default]" class="form-control"></td>
                                    <td><button type="button" class="btn btn-primary btn-sm remove-field">Remove</button></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-sm btn-secondary" id="addField">+ Add Field</button>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Generate CRUD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let fieldIndex = 1;
document.getElementById('addField').addEventListener('click', function () {
    const tableBody = document.querySelector('#fieldsTable tbody');
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td><input type="text" name="fields[${fieldIndex}][name]" class="form-control" required></td>
        <td>
            <select name="fields[${fieldIndex}][type]" class="form-control">
                <option value="string">String</option>
                <option value="text">Text</option>
                <option value="integer">Integer</option>
                <option value="float">Float</option>
                <option value="boolean">Boolean</option>
                <option value="date">Date</option>
                <option value="datetime">Datetime</option>
            </select>
        </td>
        <td class="text-center">
            <input type="checkbox" name="fields[${fieldIndex}][nullable]">
        </td>
        <td><input type="text" name="fields[${fieldIndex}][default]" class="form-control"></td>
        <td><button type="button" class="btn btn-primary btn-sm remove-field">Remove</button></td>
    `;
    tableBody.appendChild(newRow);
    fieldIndex++;
});

document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('remove-field')) {
        e.target.closest('tr').remove();
    }
});
</script>
@endpush
