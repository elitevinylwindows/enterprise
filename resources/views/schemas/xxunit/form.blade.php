<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label>Schema ID</label>
            <input type="number" name="schema_id" class="form-control" value="{{ old('schema_id', $xxunit->schema_id ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Retrofit</label>
            <input type="text" name="retrofit" class="form-control" value="{{ old('retrofit', $xxunit->retrofit ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Nailon</label>
            <input type="text" name="nailon" class="form-control" value="{{ old('nailon', $xxunit->nailon ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Block</label>
            <input type="text" name="block" class="form-control" value="{{ old('block', $xxunit->block ?? '') }}">
        </div>
        <div class="mb-3">
            <label>LE3 Clr</label>
            <input type="text" name="le3_clr" class="form-control" value="{{ old('le3_clr', $xxunit->le3_clr ?? '') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label>LE3 Lam</label>
            <input type="text" name="le3_lam" class="form-control" value="{{ old('le3_lam', $xxunit->le3_lam ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Clr Temp</label>
            <input type="text" name="clr_temp" class="form-control" value="{{ old('clr_temp', $xxunit->clr_temp ?? '') }}">
        </div>
        <div class="mb-3">
            <label>LE3 Clr + LE3</label>
            <input type="text" name="le3_clr_le3" class="form-control" value="{{ old('le3_clr_le3', $xxunit->le3_clr_le3 ?? '') }}">
        </div>
        <div class="mb-3">
            <label>2LE3 + 1CLR Temp</label>
            <input type="text" name="twole3_oneclr_temp" class="form-control" value="{{ old('twole3_oneclr_temp', $xxunit->twole3_oneclr_temp ?? '') }}">
        </div>
    </div>
</div>
