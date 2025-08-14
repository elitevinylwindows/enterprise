@php
  // What to show as the terminal label
  $terminalLabel = $station->station ?? $station->name ?? '01';
@endphp

<div class="row g-4">

  {{-- LEFT: main column --}}
  <div class="col-lg-9">

    {{-- Top row: Terminal card + Notes card --}}
    <div class="row g-4">
      <div class="col-md-6">
        <div class="terminal-tile p-4">
          <h4 class="mb-3 fw-bold">TERMINAL:{{ $station->id }} </h4>
          <div class="small text-muted">{{ $terminalLabel }}</div>

          <div class="mt-4 h5 fw-semibold mb-2">JOB:</div>
          <div class="text-muted small">
            {{-- hook job info here --}}
            <em>No job loaded.</em>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="terminal-tile p-4 h-100">
          <h4 class="mb-3 fw-bold">NOTES</h4>
          <textarea class="form-control" rows="3" placeholder="Type notes here…"></textarea>
        </div>
      </div>
    </div>

    {{-- Middle: big work area --}}
    <div class="terminal-tile p-4 mt-4 terminal-canvas d-flex align-items-center justify-content-center">
      <div class="text-muted text-center">
        <div class="fw-semibold mb-1">Work Area</div>
        <small>Render job details, drawings, or controls here.</small>
      </div>
    </div>

    {{-- Bottom: controls bar --}}
    <div class="terminal-tile p-3 mt-4 d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-3">
        <button type="button" class="btn btn-light d-inline-flex align-items-center gap-2 px-3"
                title="Stop">
          <span class="stop-oct" aria-hidden="true">🛑</span>
          <span class="d-none d-sm-inline fw-semibold">Stop</span>
        </button>
      </div>

      <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-dark rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width:44px;height:44px" title="Pause">
          <i class="fa-solid fa-pause"></i>
        </button>
        <button type="button" class="btn btn-dark d-inline-flex align-items-center gap-2 px-3"
                title="Next">
          <span class="fw-semibold">Next</span>
          <i class="fa-solid fa-arrow-right"></i>
        </button>
      </div>
    </div>

  </div>

  {{-- RIGHT: queue column --}}
  <div class="col-lg-3">
    <div class="terminal-tile p-4 terminal-queue">
      <div class="d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-bold">QUEUE</h6>
      </div>

      <hr>

      {{-- Sample queue items (replace with real data) --}}
      <div class="list-group list-group-flush small">
        <div class="list-group-item px-0 border-0 d-flex justify-content-between">
          <span>JP-1001 • LAM-WH</span>
          <span class="text-muted">24 pcs</span>
        </div>
        <div class="list-group-item px-0 border-0 d-flex justify-content-between">
          <span>JP-1002 • BLK</span>
          <span class="text-muted">10 pcs</span>
        </div>
        <div class="list-group-item px-0 border-0 d-flex justify-content-between">
          <span>JP-1003 • AMD</span>
          <span class="text-muted">18 pcs</span>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- Local styles just for this partial --}}
<style>
  .terminal-tile{
    background:#fff;
    border-radius:20px;
    border:1px solid rgba(0,0,0,.06);
    box-shadow:0 1px 2px rgba(0,0,0,.04);
  }
  .terminal-canvas{
    min-height:420px;
  }
  .terminal-queue{
    position: sticky;
    top: 1rem;
    max-height: calc(100vh - 8rem);
    overflow: auto;
  }
  .stop-oct{
    display:inline-flex; align-items:center; justify-content:center;
    width:22px; height:22px; font-size:16px; line-height:1;
  }
</style>
