{{-- PARTIAL ONLY (no @extends) --}}

<form id="jobPlanningQueueForm" method="POST" action="{{ route('manufacturing.job_planning.queue') }}">
  @csrf

  <div class="modal-body">

    {{-- FILTERS --}}
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
            <select class="form-select" name="series" id="series">
              <option value="">{{ __('All Series') }}</option>
              @foreach($series as $s)
                <option value="{{ $s->series_code }}">
                  {{ $s->series_code }} @if(!empty($s->series_name)) — {{ $s->series_name }} @endif
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-12"></div>

          <div class="col-md-9">
            <label class="form-label d-block mb-2">{{ __('Color') }}</label>
            <div class="d-flex flex-wrap gap-3">
              @foreach($colors as $c)
                @php
                  $code  = $c->color_code;
                  $label = $c->color_name ?: $c->color_code;
                  $safeId = 'color_'.preg_replace('/[^a-z0-9_]+/i','_', $code);
                @endphp
                <div class="form-check form-check-inline">
                  <input class="form-check-input color-filter" type="checkbox" value="{{ $code }}" id="{{ $safeId }}">
                  <label class="form-check-label" for="{{ $safeId }}">{{ $label }}</label>
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

    {{-- RESULTS --}}
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold">{{ __('Results') }}</span>
        <div class="small text-muted d-flex align-items-center gap-3">
          <span id="resultCount">0</span> {{ __('item(s)') }}
          <span class="badge bg-light-primary text-primary" id="qtyCapHint">{{ __('Qty cap: 0/50') }}</span>
        </div>
      </div>
      <div class="card-body p-0">
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
              {{-- filled by JS --}}
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

    {{-- hidden fields for selected ids and total qty --}}
    <div id="selectedContainer" class="d-none">
      <input type="hidden" name="selected_qty_total" id="selected_qty_total" value="0">
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
  </div>
</form>

