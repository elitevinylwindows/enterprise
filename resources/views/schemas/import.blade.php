<div class="modal-body" id="importModalBody">
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="file" class="form-label">Select File to Import</label>
            <input type="file" class="form-control" id="file" name="import_file" accept=".csv,.xlsx,.xls" required>
            <small class="text-muted">Supported formats: CSV, Excel</small>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" id="submitBtn" class="btn btn-secondary">Import</button>
</div>

<script>
    document.getElementById('submitBtn').addEventListener('click', function() {
        const fileInput = document.getElementById('file');
        if (fileInput.files.length === 0) {
            alert('Please select a file to import.');
            return;
        }
        const formData = new FormData();
        formData.append('import_file', fileInput.files[0]);

        fetch('{{route("schemas.import")}}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Import successful');
                window.location.reload();
            } else {
                if(data.has_duplicates) {
                    document.getElementById('importModalBody').innerHTML = data.view;
                } else {
                    alert('Import failed. Please try again.');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Import failed. Please try again.');
        });
    });

    // Handle the confirmation form submission
    // Handle the skip and overwrite buttons
    document.addEventListener('click', function(e) {
        if (e.target.matches('#skipBtn, #overwriteBtn')) {
            const form = document.getElementById('confirmImportForm');
            const formData = new FormData(form);
            formData.append('action_type', e.target.value);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Import successful');
                    window.location.reload();
                } else {
                    alert('Import failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Import failed. Please try again.');
            });
        }
    });
</script>
