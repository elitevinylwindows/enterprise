    <h5>The following records already exist:</h5>
    <ul>
        @foreach ($duplicates as $recordId)
        <li>Record #{{ $recordId }}</li>
        @endforeach
    </ul>

    <div class="d-flex gap-2">
        <form method="POST" action="{{ route('schemas.import') }}" class="d-flex gap-2" id="confirmImportForm">
            @csrf
            <input type="hidden" name="import_file" value="{{ $originalFile }}">
            <input type="hidden" name="model" value="{{ $model }}">
            
            <button type="button" name="action_type" id="skipBtn" value="skip" class="btn btn-warning">
                Skip Existing
            </button>
            
            <button type="button" name="action_type" id="overwriteBtn"  value="overwrite" class="btn btn-danger">
                Overwrite Existing
            </button>
        </form>
    </div>
