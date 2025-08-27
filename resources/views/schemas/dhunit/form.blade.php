<div class="row">
    @foreach(['schema_id','retrofit','nailon','block','le3_clr','le3_lam','clr_temp','le3_temp','lam_temp','feat1','feat2','feat3','clr_clr','le3_clr_le3','twole3_oneclr_temp','sta_grd','tpi','tpo','acid_edge','solar_cool','status'] as $field)
    <div class="col-md-4 mb-3">
        <label>{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
        <input type="text" name="{{ $field }}" class="form-control" value="{{ old($field, $dhunit->$field ?? '') }}">
    </div>
    @endforeach
</div>
