<form action="{{ route('hs-unit.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="file" class="form-label">Select File to Import</label>
                <input type="file" class="form-control" id="file" name="file" accept=".csv,.xlsx,.xls" required>
                <small class="text-muted">Supported formats: CSV, Excel</small>
            </div>
            
            <div class="col-md-12 mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="header_row" name="header_row" checked>
                    <label class="form-check-label" for="header_row">
                        File contains header row
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-secondary">Import</button>
    </div>
</form>
