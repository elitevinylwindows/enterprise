@extends('layouts.app')

@section('page-title', __('Formulas'))



@section('content')

<div class='mb-4'></div>
<div class="card shadow-sm border-0">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">{{ __('Formulas') }}</h5>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#formulaEditModal"
            data-id="NEW" data-name="" data-fields="" data-expression="">
      <i class="ti ti-plus"></i> {{ __('New Formula') }}
    </button>
  </div>

  <div class="card-body">
    {{-- Static table (stub) --}}
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
        <tr>
          <th>{{ __('ID') }}</th>
          <th>{{ __('Formula Name') }}</th>
          <th class="text-end">{{ __('Action') }}</th>
        </tr>
        </thead>
        <tbody>
        {{-- Example rows; replace with @foreach($formulas as $f) --}}
        <tr>
          <td>1</td>
          <td>IGU Base Price</td>
          <td class="text-end">
            <button class="btn btn-sm btn-outline-primary"
                    data-bs-toggle="modal" data-bs-target="#formulaEditModal"
                    data-id="1"
                    data-name="IGU Base Price"
                    data-fields='["retrofit","nailon","le3_clr","le3_lam","clr_temp"]'
                    data-expression="base_multi * (le3_clr + le3_lam) + clr_temp">
              <i class="ti ti-pencil"></i> Edit
            </button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>TPI/TPO Adjustment</td>
          <td class="text-end">
            <button class="btn btn-sm btn-outline-primary"
                    data-bs-toggle="modal" data-bs-target="#formulaEditModal"
                    data-id="2"
                    data-name="TPI/TPO Adjustment"
                    data-fields='["tpi","tpo","sta_grid"]'
                    data-expression="IF(tpi > 0, tpi * 0.05, 0) + IF(tpo > 0, tpo * 0.03, 0) + (sta_grid ?? 0)">
              <i class="ti ti-pencil"></i> Edit
            </button>
          </td>
        </tr>
        {{-- @endforeach --}}
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal fade" id="formulaEditModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content border-0">
      <div class="modal-header">
        <h5 class="modal-title">
          <span class="me-2">{{ __('Edit Formula') }}</span>
          <small class="text-muted" id="formula-id-label"></small>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
      </div>
      <div class="modal-body">
        <div class="row g-4">
          {{-- Left: Formula name + editor + quick inserts --}}
          <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-header fw-semibold">{{ __('Formula Details') }}</div>
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label">{{ __('Formula Name') }}</label>
                  <input type="text" class="form-control" id="formula-name" placeholder="e.g., IGU Base Price">
                </div>

                <label class="form-label d-flex align-items-center justify-content-between">
                  <span>{{ __('Expression') }}</span>
                  <small class="text-muted">{{ __('Click tokens below to insert') }}</small>
                </label>
                <textarea class="form-control font-monospace" id="formula-expression" rows="5"
                          placeholder="e.g., base_multi * (le3_clr + le3_lam) + clr_temp"></textarea>

                <div class="mt-3">
                  <div class="d-flex flex-wrap gap-2" id="token-palette">
                    {{-- Populated by JS based on selected checkboxes --}}
                  </div>
                </div>

                <div class="mt-3">
                  <label class="form-label">{{ __('Preview (static)') }}</label>
                  <div class="form-control bg-light-subtle" id="formula-preview" style="min-height: 44px;"></div>
                  <small class="text-muted">
                    {{ __('Preview shows expression text only (no evaluation yet).') }}
                  </small>
                </div>
              </div>
            </div>
          </div>

          {{-- Right: field toggles + helpers --}}
          <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-header fw-semibold">{{ __('Fields Included in Formula') }}</div>
              <div class="card-body">
                <div class="row">
                  @php
                    // Common fields from your schemas
                    $fields = [
                      'retrofit','nailon','block','le3_clr','le3_lam','clr_temp','onele3_oneclr_temp',
                      'lam_temp','feat1','feat2','feat3','clr_clr','le3_clr_le3','twole3_oneclr_temp',
                      'sta_grid','tpi','tpo','status','color_multi','base_multi','clr_lam','product_id','product_code'
                    ];
                  @endphp

                  @foreach($fields as $f)
                    <div class="col-6 mb-2">
                      <div class="form-check">
                        <input class="form-check-input formula-field" type="checkbox" value="{{ $f }}" id="fld_{{ $f }}">
                        <label class="form-check-label" for="fld_{{ $f }}">{{ Str::headline($f) }}</label>
                      </div>
                    </div>
                  @endforeach
                </div>
                <small class="text-muted d-block mt-2">
                  {{ __('Tick fields to make them available as tokens in the editor.') }}
                </small>
              </div>
            </div>

            <div class="card border-0 shadow-sm">
              <div class="card-header fw-semibold">{{ __('Helpers & Functions') }}</div>
              <div class="card-body">
                <div class="small">
                  <ul class="mb-2">
                    <li><code>IF(condition, then, else)</code> — conditional inclusion</li>
                    <li><code>COALESCE(a, b)</code> / <code>(a ?? b)</code> — fallback to b when a is null</li>
                    <li><code>ROUND(x, n)</code> — round to n decimals</li>
                    <li><code>MIN(a, b, ...)</code>, <code>MAX(a, b, ...)</code></li>
                    <li><code>ABS(x)</code>, <code>CEIL(x)</code>, <code>FLOOR(x)</code></li>
                  </ul>
                  <div class="border rounded p-2 bg-light-subtle">
                    <div class="fw-semibold mb-1">{{ __('Examples') }}</div>
                    <code>base_multi * (le3_clr + le3_lam)</code><br>
                    <code>IF(tpi &gt; 0, tpi * 0.05, 0) + (tpo ?? 0)</code><br>
                    <code>ROUND(color_multi * 1.15, 2)</code>
                  </div>
                </div>
              </div>
            </div>

          </div> {{-- /Right --}}
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="button" class="btn btn-primary" id="save-formula-btn">{{ __('Save (static)') }}</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
(function() {
  const modal = document.getElementById('formulaEditModal');
  const nameInput = document.getElementById('formula-name');
  const exprInput = document.getElementById('formula-expression');
  const preview = document.getElementById('formula-preview');
  const idLabel = document.getElementById('formula-id-label');
  const tokenPalette = document.getElementById('token-palette');

  function setChecked(fieldsArr) {
    document.querySelectorAll('.formula-field').forEach(cb => {
      cb.checked = fieldsArr.includes(cb.value);
    });
  }

  function currentFields() {
    return Array.from(document.querySelectorAll('.formula-field:checked')).map(cb => cb.value);
  }

  function renderTokens() {
    tokenPalette.innerHTML = '';
    currentFields().forEach(f => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'btn btn-sm btn-outline-secondary';
      btn.textContent = f;
      btn.onclick = () => insertToken(f);
      tokenPalette.appendChild(btn);
    });
  }

  function insertToken(tok) {
    const el = exprInput;
    const start = el.selectionStart ?? el.value.length;
    const end = el.selectionEnd ?? el.value.length;
    const before = el.value.substring(0, start);
    const after = el.value.substring(end);
    el.value = before + tok + after;
    el.focus();
    el.selectionStart = el.selectionEnd = start + tok.length;
    updatePreview();
  }

  function updatePreview() {
    preview.textContent = exprInput.value || '';
  }

  // Open modal with data
  modal.addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    const id = btn?.getAttribute('data-id') ?? 'NEW';
    const nm = btn?.getAttribute('data-name') ?? '';
    const expr = btn?.getAttribute('data-expression') ?? '';
    const fields = btn?.getAttribute('data-fields');

    idLabel.textContent = `ID: ${id}`;
    nameInput.value = nm;
    exprInput.value = expr;
    updatePreview();

    let fieldsArr = [];
    try { fieldsArr = fields ? JSON.parse(fields) : []; } catch(_e) { fieldsArr = []; }
    setChecked(fieldsArr);
    renderTokens();
  });

  // Update token list when toggles change
  document.addEventListener('change', function(e) {
    if (e.target.classList.contains('formula-field')) {
      renderTokens();
    }
  });

  exprInput.addEventListener('input', updatePreview);

  // Static save (no backend)
  document.getElementById('save-formula-btn').addEventListener('click', function() {
    // For now just close the modal; integrate with AJAX later
    const m = bootstrap.Modal.getInstance(modal);
    if (m) m.hide();
  });
})();
</script>
@endpush
