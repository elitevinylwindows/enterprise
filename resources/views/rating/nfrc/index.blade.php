@extends('layouts.app')

@section('page-title','NFRC Directory Search')

@section('content')
<div class="container-xxl">

  {{-- Top bar / title --}}
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="mb-0">NFRC Directory Search</h4>
    <a href="{{ route('rating.nfrc.index') }}" class="btn btn-outline-secondary btn-sm">New Search</a>
  </div>

  {{-- Search cards (two up) --}}
  <div class="row g-3">
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-header fw-semibold">Window Type</div>
        <div class="card-body">
          <select id="typeSelect" class="form-select" aria-label="Window Type"></select>
          <div class="form-check mt-2">
            <input class="form-check-input" type="checkbox" id="energyStarOnly">
            <label class="form-check-label" for="energyStarOnly">Energy Star Products Only</label>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-header fw-semibold">Series / Product Line</div>
        <div class="card-body">
          <div class="row g-2">
            <div class="col-12">
              <label class="form-label">Series / Model Number</label>
              <select id="modelSelect" class="form-select"></select>
            </div>
            <div class="col-12">
              <label class="form-label">Product Line</label>
              <select id="productLineSelect" class="form-select"></select>
            </div>
          </div>
          <button id="findBtn" class="btn btn-primary mt-3">Find Product Lines</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Results card --}}
  <div class="card mt-3">
    <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
      <span>Detailed Product Ratings</span>
      <a id="exportBtn" class="btn btn-sm btn-outline-primary disabled" role="button" aria-disabled="true">Export to Excel</a>
    </div>
    <div class="card-body">
      <div id="plMeta" class="mb-3 small text-muted"></div>
      <div class="table-responsive">
        <table class="table table-sm table-striped align-middle" id="ratingsTable">
          <thead class="table-dark">
            <tr>
              <th>CPD #</th>
              <th>Manufacturer Product Code</th>
              <th class="text-end">U-factor</th>
              <th class="text-end">SHGC</th>
              <th class="text-end">VT</th>
              <th class="text-end">Condensation</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody><tr><td colspan="7" class="text-center text-muted">Select a product line and click “Find Product Lines”.</td></tr></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Minimal JS (vanilla) --}}
<script>
(async function () {
  const typeSel   = document.getElementById('typeSelect');
  const modelSel  = document.getElementById('modelSelect');
  const plSel     = document.getElementById('productLineSelect');
  const findBtn   = document.getElementById('findBtn');
  const tableBody = document.querySelector('#ratingsTable tbody');
  const plMeta    = document.getElementById('plMeta');
  const exportBtn = document.getElementById('exportBtn');
  const energyStarOnly = document.getElementById('energyStarOnly');

  const api = {
    types:   () => fetch('/api/nfrc/types').then(r=>r.json()),
    models:  (typeId) => fetch('/api/nfrc/models?type_id='+typeId).then(r=>r.json()),
    lines:   (typeId) => fetch('/api/nfrc/lines?type_id='+typeId).then(r=>r.json()),
    ratings: (plId)   => fetch('/api/nfrc/ratings?product_line_id='+plId).then(r=>r.json()),
  };

  // Populate window types
  const types = await api.types();
  typeSel.innerHTML = '<option value="">— Select Type —</option>' + types.map(t =>
    `<option value="${t.id}">${t.name}</option>`).join('');

  // When type changes, refresh models + product lines
  typeSel.addEventListener('change', async () => {
    const id = typeSel.value || '';
    modelSel.innerHTML = '<option value="">— Select Series/Model —</option>';
    plSel.innerHTML    = '<option value="">— Select Product Line —</option>';

    if (!id) return;

    const [models, lines] = await Promise.all([api.models(id), api.lines(id)]);
    modelSel.innerHTML += models.map(m => `<option value="${m}">${m}</option>`).join('');
    const onlyStar = energyStarOnly.checked;
    plSel.innerHTML += lines
      .filter(l => !onlyStar || l.is_energy_star === 1)
      .map(l => `<option value="${l.id}">${l.product_line} (${l.series_model})</option>`).join('');
  });

  // Filter product lines by chosen model
  modelSel.addEventListener('change', async () => {
    const typeId = typeSel.value || '';
    if (!typeId) return;
    const lines = await api.lines(typeId);
    const chosen = modelSel.value || '';
    plSel.innerHTML = '<option value="">— Select Product Line —</option>' +
      lines.filter(l => !chosen || l.series_model === chosen)
           .map(l => `<option value="${l.id}">${l.product_line} (${l.series_model})</option>`).join('');
  });

  // Fetch ratings
  findBtn.addEventListener('click', async () => {
    const plId = plSel.value;
    if (!plId) return;

    tableBody.innerHTML = '<tr><td colspan="7" class="text-center">Loading…</td></tr>';
    const data = await api.ratings(plId);

    // meta
    plMeta.innerHTML = data.product_line
      ? `<div><strong>Manufacturer:</strong> ${data.product_line.manufacturer} &nbsp; 
         <strong>Series:</strong> ${data.product_line.series_model} &nbsp; 
         <strong>Product Line:</strong> ${data.product_line.product_line}</div>`
      : '';

    // rows
    if (!data.ratings || data.ratings.length === 0) {
      tableBody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No ratings found.</td></tr>';
    } else {
      tableBody.innerHTML = data.ratings.map(r => `
        <tr>
          <td><a href="#" tabindex="-1">${r.cpd_number ?? ''}</a></td>
          <td class="small">${r.manufacturer_code ?? ''}</td>
          <td class="text-end">${fmt(r.u_factor)}</td>
          <td class="text-end">${fmt(r.shgc)}</td>
          <td class="text-end">${fmt(r.vt)}</td>
          <td class="text-end">${fmt(r.condensation_res)}</td>
          <td class="small">${r.product_description ?? ''}</td>
        </tr>`).join('');
    }

    // export (hook up later to your export endpoint)
    exportBtn.classList.remove('disabled');
  });

  function fmt(v){ return (v===null || v===undefined) ? '—' : Number(v).toFixed(2); }
})();
</script>
@endsection
