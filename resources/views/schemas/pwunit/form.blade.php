<div class="row">
    <div class="col-md-4 mb-3"><label>Schema ID</label><input type="number" name="schema_id" class="form-control" value="{{ old('schema_id', $item->schema_id ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>Retrofit</label><input type="text" name="retrofit" class="form-control" value="{{ old('retrofit', $item->retrofit ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>Nailon</label><input type="text" name="nailon" class="form-control" value="{{ old('nailon', $item->nailon ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>Block</label><input type="text" name="block" class="form-control" value="{{ old('block', $item->block ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>LE3 CLR</label><input type="text" name="le3_clr" class="form-control" value="{{ old('le3_clr', $item->le3_clr ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>CLR CLR</label><input type="text" name="clr_clr" class="form-control" value="{{ old('clr_clr', $item->clr_clr ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>LE3 LAM</label><input type="text" name="le3_lam" class="form-control" value="{{ old('le3_lam', $item->le3_lam ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>CLR TEMP</label><input type="text" name="clr_temp" class="form-control" value="{{ old('clr_temp', $item->clr_temp ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>LE3 CLR LE3</label><input type="text" name="le3_clr_le3" class="form-control" value="{{ old('le3_clr_le3', $item->le3_clr_le3 ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>1LE3 + 1CLR TEMP</label><input type="text" name="onele3_oneclr_temp" class="form-control" value="{{ old('onele3_oneclr_temp', $item->onele3_oneclr_temp ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>STA GRD</label><input type="text" name="sta_grd" class="form-control" value="{{ old('sta_grd', $item->sta_grd ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>TPI</label><input type="text" name="tpi" class="form-control" value="{{ old('tpi', $item->tpi ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>TPO</label><input type="text" name="tpo" class="form-control" value="{{ old('tpo', $item->tpo ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>Acid Edge</label><input type="text" name="acid_edge" class="form-control" value="{{ old('acid_edge', $item->acid_edge ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>Solar Cool</label><input type="text" name="solar_cool" class="form-control" value="{{ old('solar_cool', $item->solar_cool ?? '') }}"></div>
    <div class="col-md-4 mb-3"><label>Status</label><input type="text" name="status" class="form-control" value="{{ old('status', $item->status ?? 'Active') }}"></div>
</div>
