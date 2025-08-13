{{-- Modal body for Job Pool Create / Send to Production --}}
<form id="jobPoolQueueForm" method="POST" action="{{ route('manufacturing.job_planning.queue') }}">
    @csrf

    {{-- FILTERS CARD --}}
    <div class="card mb-3">
        <div class="card-header fw-semibold">{{ __('Filter') }}</div>
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">{{ __('Date From') }}</label>
                    <input type="date" class="form-control" name="date_from" id="date_from" value="{{ now()->toDateString() }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Date To') }}</label>
                    <input type="date" class="form-control" name="date_to" id="date_to" value="{{ now()->toDateString() }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Series') }}</label>
                    <input type="text" class="form-control" name="series" id="series" placeholder="{{ __('e.g. LAM-WH') }}">
                </div>

                <div class="col-12"></div>

                <div class="col-md-9">
                    <label class="form-label d-block mb-2">{{ __('Color') }}</label>
                    <div class="d-flex flex-wrap gap-3">
                        @php
                            $colors = ['White' => 'white', 'Black' => 'black', 'Almond' => 'almond'];
                        @endphp
                        @foreach($colors as $label => $val)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input color-filter" type="checkbox" value="{{ $val }}" id="color_{{ $val }}">
                                <label class="form-check-label" for="color_{{ $val }}">{{ $label }}</label>
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
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-semibold">{{ __('Results') }}</span>
            <small class="text-muted"><span id="resultCount">0</span> {{ __('item(s)') }}</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="jobResultsTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width:36px;">
                                <input type="checkbox" id="checkAll">
                            </th>
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

        <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="small text-muted" id="selectionHint">{{ __('Select jobs to send') }}</div>
            <button type="submit" id="btnSendQueue" class="btn btn-success" disabled>
                <i class="fa-solid fa-paper-plane"></i> {{ __('Send to Production Queue') }}
            </button>
        </div>
    </div>

    {{-- Hidden inputs for selected IDs (populated by JS) --}}
    <div id="selectedContainer"></div>
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

    function getSelectedColors() {
        if (document.getElementById('color_all').checked) return [];
        const vals = [];
        document.querySelectorAll('.color-filter:checked').forEach(cb => vals.push(cb.value));
        return vals;
    }

    // All toggle
    document.getElementById('color_all').addEventListener('change', (e) => {
        const on = e.target.checked;
        document.querySelectorAll('.color-filter').forEach(cb => cb.checked = false);
    });

    function renderRows(rows) {
        tableBody.innerHTML = '';
        let html = '';
        rows.forEach(r => {
            html += `
            <tr>
  <td><input type="checkbox" class="row-check" value="${r.id}"></td>
  <td>${r.id ?? '-'}</td>
  <td>${r.job_order_number ?? '-'}</td>
  <td>${r.series ?? '-'}</td>
  <td class="text-end">${r.qty ?? 0}</td>
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
        tableBody.querySelectorAll('.row-check').forEach(cb => {
            cb.addEventListener('change', updateSelection);
        });

        // reset controls
        checkAll.checked = false;
        updateSelection();
    }

    checkAll.addEventListener('change', () => {
        tableBody.querySelectorAll('.row-check').forEach(cb => cb.checked = checkAll.checked);
        updateSelection();
    });

    function updateSelection() {
        const selected = Array.from(tableBody.querySelectorAll('.row-check:checked')).map(cb => cb.value);
        selectedContainer.innerHTML = '';
        selected.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_ids[]';
            input.value = id;
            selectedContainer.appendChild(input);
        });
        btnSendQueue.disabled = selected.length === 0;
        selectionHint.textContent = selected.length
            ? `${selected.length} selected`
            : '{{ __('Select jobs to send') }}';
    }

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
        .then(json => {
            if (json && json.success) {
                renderRows(json.data || []);
            } else {
                renderRows([]);
            }
        })
        .catch(() => renderRows([]));
    });
})();
</script>
@endpush
