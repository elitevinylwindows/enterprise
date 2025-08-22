{{-- Modal body for Job Planning Create / Send to Production (PARTIAL for customModal) --}}
<form id="jobPlanningQueueForm" method="POST" action="{{ route('manufacturing.job_planning.queue') }}">
    @csrf

    <div class="px-4 pt-3"> {{-- padding inside modal body --}}


{{-- FILTERS CARD --}}
<div class="card mb-4">
    <div class="card-header fw-semibold px-3 px-md-4">{{ __('Filter') }}</div>
    <div class="card-body px-3 px-md-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">{{ __('Date From') }}</label>
                <input type="date" class="form-control" name="date_from" id="date_from"
                       value="{{ now()->toDateString() }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">{{ __('Date To') }}</label>
                <input type="date" class="form-control" name="date_to" id="date_to"
                       value="{{ now()->toDateString() }}">
            </div>

            {{-- Series Dropdown --}}
            <div class="col-md-3">
                <label class="form-label">{{ __('Series') }}</label>
                <select class="form-select" name="series" id="series">
                    <option value="">{{ __('All Series') }}</option>
                    @foreach($series as $s)
                        <option value="{{ $s->series }}">{{ $s->series }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12"></div>

           {{-- Colors from Config --}}
<div class="col-md-9">
    <label class="form-label d-block mb-2">{{ __('Color') }}</label>
    <div class="d-flex flex-wrap gap-3">
        @foreach($colors as $c)
            @php
                $code  = $c->code;
                $label = $c->name;
                $safeId = 'color_' . preg_replace('/[^a-z0-9_]+/i','_', strtolower($code));
            @endphp
            <div class="form-check form-check-inline">
                <input class="form-check-input color-filter" type="checkbox" value="{{ $code }}" id="{{ $safeId }}">
                <label class="form-check-label" for="{{ $safeId }}">{{ $code }}</label>
            </div>
        @endforeach

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="color_all" checked>
            <label class="form-check-label" for="color_all">{{ __('All') }}</label>
        </div>
    </div>
</div>


            <div class="col-md-3 text-md-end">
                <button type="button" id="btnSearchJobs" class="btn btn-primary">
                    <i class="fa-solid fa-magnifying-glass"></i> {{ __('Search') }}
                </button>
            </div>
        </div>
    </div>
</div>








        {{-- RESULTS CARD --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center px-3 px-md-4">
                <span class="fw-semibold">{{ __('Results') }}</span>
                <small class="text-muted"><span id="resultCount">0</span> {{ __('item(s)') }}</small>
            </div>
            <div class="card-body px-3 pb-3">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="jobResultsTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width:36px;"><input type="checkbox" id="checkAll"></th>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Job Order #') }}</th>
                                <th>{{ __('Series') }}</th>
                                <th class="text-end">{{ __('Qty') }}</th>
                                <th>{{ __('Line') }}</th>
                                <th>{{ __('Delivery Date') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Production Status') }}</th>
                                <th>{{ __('Entry Date') }}</th>
                                <th>{{ __('Last Transaction Date') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Filled by JS --}}
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between align-items-center px-3 px-md-4">
                <div class="small text-muted" id="selectionHint">{{ __('Select jobs to send') }}</div>
                <button type="submit" id="btnSendQueue" class="btn btn-success" disabled>
                    <i class="fa-solid fa-paper-plane"></i> {{ __('Send to Production Queue') }}
                </button>
            </div>
        </div>

        {{-- Hidden inputs for selected IDs (populated by JS) --}}
        <div id="selectedContainer"></div>
    </div>
</form>

@push('scripts')
<script>
(function() {
  const btnSearch = document.getElementById('btnSearchJobs');
  const tableBody = document.querySelector('#jobResultsTable tbody');
  const checkAll = document.getElementById('checkAll');
  const resultCount = document.getElementById('resultCount');
  const btnSendQueue = document.getElementById('btnSendQueue');
  const selectedContainer = document.getElementById('selectedContainer');
  const selectionHint = document.getElementById('selectionHint');
  const qtyCapHint = document.getElementById('qtyCapHint');
  const totalQtyInput = document.getElementById('selected_qty_total');
  const form = document.getElementById('jobPlanningQueueForm');
  const MAX_QTY = 50;

  const showRouteTpl = `{{ route('manufacturing.job_planning.show', ':id') }}`;

  function statusBadge(s) {
    const v = (s || '').toLowerCase();
    const cls = v === 'completed' ? 'success'
             : (v === 'queued' || v === 'pending') ? 'warning'
             : 'info';
    const label = (s || '-').toString().replace(/_/g,' ').replace(/\b\w/g, c => c.toUpperCase());
    return `<span class="badge bg-light-${cls}">${label}</span>`;
  }

  function getSelectedColors() {
    if (document.getElementById('color_all').checked) return [];
    const vals = [];
    document.querySelectorAll('.color-filter:checked').forEach(cb => vals.push(cb.value));
    return vals;
  }

  // "All" toggle clears specific colors
  document.getElementById('color_all').addEventListener('change', (e) => {
    if (e.target.checked) document.querySelectorAll('.color-filter').forEach(cb => cb.checked = false);
  });

  // ——— rendering ———
  function renderRows(rows) {
    tableBody.innerHTML = '';
    let html = '';
    rows.forEach(r => {
      const qty = parseInt(r.qty ?? 0, 10) || 0;
      html += `
<tr draggable="true" data-id="${r.id}" data-qty="${qty}">
  <td><input type="checkbox" class="row-check" value="${r.id}"></td>
  <td>${r.id ?? '-'}</td>
  <td>${r.job_order_number ?? '-'}</td>
  <td>${r.series ?? '-'}</td>
  <td class="text-end">${qty}</td>
  <td>${r.line ?? '-'}</td>
  <td>${r.delivery_date ?? '-'}</td>
  <td>${r.type ?? '-'}</td>
  <td>${statusBadge(r.production_status)}</td>
  <td>${r.entry_date ?? '-'}</td>
  <td>${r.last_transaction_date ?? '-'}</td>
  <td>
    <a href="#" class="btn btn-sm btn-info customModal"
       data-size="xl"
       data-title="Job # ${r.job_order_number ?? r.id}"
       data-url="${showRouteTpl.replace(':id', r.id)}">
       <i data-feather="eye"></i>
    </a>
  </td>
</tr>`;
    });
    tableBody.insertAdjacentHTML('beforeend', html);
    resultCount.textContent = rows.length;

    // bind selection change
    tableBody.querySelectorAll('.row-check').forEach(cb => cb.addEventListener('change', onRowCheckChange));

    // reset controls
    checkAll.checked = false;
    updateSelection();

    // enable drag
    enableDrag();
  }

  // ——— selection + cap ———
  function getSelectedTotalQty() {
    let sum = 0;
    tableBody.querySelectorAll('tr').forEach(tr => {
      const cb = tr.querySelector('.row-check');
      if (cb?.checked) sum += parseInt(tr.dataset.qty || '0', 10) || 0;
    });
    return sum;
  }

  function getSelectedIdsInDOMOrder() {
    const ids = [];
    tableBody.querySelectorAll('tr').forEach(tr => {
      const cb = tr.querySelector('.row-check');
      if (cb?.checked) ids.push(tr.getAttribute('data-id'));
    });
    return ids;
  }

  function onRowCheckChange(e) {
    const cb = e.target;
    const tr = cb.closest('tr');
    const qty = parseInt(tr?.dataset?.qty || '0', 10) || 0;
    const current = getSelectedTotalQty();

    if (cb.checked && current > MAX_QTY) {
      cb.checked = false;
      alert(`Cannot exceed total Qty ${MAX_QTY}.`);
    }
    updateSelection();
  }

  function updateSelection() {
    // rebuild hidden inputs in DOM order
    selectedContainer.querySelectorAll('input[name="selected_ids[]"]').forEach(el => el.remove());
    const ids = getSelectedIdsInDOMOrder();
    ids.forEach(id => {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'selected_ids[]';
      input.value = id;
      selectedContainer.appendChild(input);
    });

    const totalQty = getSelectedTotalQty();
    totalQtyInput.value = String(totalQty);

    btnSendQueue.disabled = (ids.length === 0) || (totalQty === 0) || (totalQty > MAX_QTY);
    selectionHint.textContent = ids.length
      ? `${ids.length} selected | qty ${totalQty}/${MAX_QTY}`
      : '{{ __('Select jobs to send') }}';
    if (qtyCapHint) qtyCapHint.textContent = `Qty cap: ${totalQty}/${MAX_QTY}`;
  }

  // Check-all respects the cap (checks until it hits 50)
  checkAll.addEventListener('change', () => {
    if (!checkAll.checked) {
      tableBody.querySelectorAll('.row-check').forEach(cb => cb.checked = false);
      updateSelection();
      return;
    }
    let running = 0;
    tableBody.querySelectorAll('tr').forEach(tr => {
      const cb = tr.querySelector('.row-check');
      const q = parseInt(tr.dataset.qty || '0', 10) || 0;
      if (cb) {
        if (running + q <= MAX_QTY) {
          cb.checked = true;
          running += q;
        } else {
          cb.checked = false;
        }
      }
    });
    updateSelection();
  });

  // ——— drag & drop ———
  function enableDrag() {
    if (window.Sortable) {
      Sortable.create(tableBody, { animation: 150, onSort: updateSelection });
      return;
    }
    // native fallback
    let dragEl = null;
    tableBody.querySelectorAll('tr').forEach(tr => {
      tr.addEventListener('dragstart', (e) => {
        dragEl = tr; tr.classList.add('dragging'); e.dataTransfer.effectAllowed = 'move';
      });
      tr.addEventListener('dragend', () => { tr.classList.remove('dragging'); dragEl = null; updateSelection(); });
      tr.addEventListener('dragover', (e) => {
        e.preventDefault();
        const target = e.currentTarget;
        if (!dragEl || dragEl === target) return;
        const rect = target.getBoundingClientRect();
        const before = (e.clientY - rect.top) < rect.height / 2;
        tableBody.insertBefore(dragEl, before ? target : target.nextSibling);
      });
    });
  }

  // ——— search ———
  btnSearch.addEventListener('click', () => {
    const params = new URLSearchParams();
    params.append('date_from', document.getElementById('date_from').value || '');
    params.append('date_to', document.getElementById('date_to').value || '');
    params.append('series', document.getElementById('series').value || '');
    getSelectedColors().forEach(c => params.append('colors[]', c));

    fetch(`{{ route('manufacturing.job_planning.lookup') }}?` + params.toString(), {
      headers: { 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(json => renderRows(json && json.success ? (json.data || []) : []))
    .catch(() => renderRows([]));
  });

  // safety: block submits over cap
  form.addEventListener('submit', (e) => {
    if (getSelectedTotalQty() > MAX_QTY) {
      e.preventDefault();
      alert(`Total Qty exceeds ${MAX_QTY}. Please adjust your selection.`);
    }
  });
})();
</script>

@endpush
