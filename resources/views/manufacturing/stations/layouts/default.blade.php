@php
  $terminalLabel = $station->station ?? $station->name ?? '01';

  // Demo queue (replace with real data)
  $queue = $queue ?? [
    ['job' => 'JP-1001', 'qty' => 24],
    ['job' => 'JP-1002', 'qty' => 10],
    ['job' => 'JP-1003', 'qty' => 18],
  ];

  // Optional preview image url: $previewUrl
  $previewUrl = $previewUrl ?? null;
@endphp

<div class="row g-4">

  {{-- LEFT MAIN COLUMN --}}
  <div class="col-xl-9">

    {{-- TOP: JOB INFO • NOTES • QUEUE --}}
    <div class="row g-4">
      {{-- Job Info --}}
      <div class="col-md-4">
        <div class="terminal-tile p-4 h-100">
          <h5 class="fw-bold mb-1">TERMINAL: {{ $station->id }}</h5>
          <div class="text-muted small mb-3">{{ $terminalLabel }}</div>

          <div class="small lh-lg">
            <div><strong>Job #:</strong> <span class="text-body">—</span></div>
            <div><strong>Series:</strong> <span class="text-body">—</span></div>
            <div><strong>Line:</strong> <span class="text-body">—</span></div>
            <div><strong>Qty:</strong> <span class="text-body">—</span></div>
            <div><strong>Delivery:</strong> <span class="text-body">—</span></div>
          </div>
        </div>
      </div>

      {{-- Notes --}}
      <div class="col-md-4">
        <div class="terminal-tile p-4 h-100">
          <h5 class="fw-bold mb-3">NOTES</h5>
          <textarea class="form-control" rows="7" placeholder="Type notes here…"></textarea>
        </div>
      </div>

      {{-- Queue (next jobs) --}}
      <div class="col-md-4">
        <div class="terminal-tile p-4 h-100">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="fw-bold mb-0">QUEUE</h5>
          </div>

          <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th class="text-nowrap">Job #</th>
                  <th class="text-end">Qty</th>
                  <th class="text-nowrap">{{ __('Actions') }}</th>
                </tr>
              </thead>
              <tbody>
                @forelse($queue as $q)
                  <tr>
                    <td class="fw-semibold">{{ $q['job'] }}</td>
                    <td class="text-end">{{ $q['qty'] }}</td>
                    <td class="text-nowrap">
                      <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-secondary" title="Pause">
                          <i class="fa-solid fa-pause"></i>
                        </button>
                        <button class="btn btn-outline-danger" title="Stop">
                          <i class="fa-solid fa-hand"></i>
                        </button>
                        <button class="btn btn-outline-warning" title="Prioritize">
                          <i class="fa-solid fa-arrow-up"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="3" class="text-center text-muted small">No queued jobs.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- MIDDLE: BIG WORK AREA --}}
    <div class="terminal-tile p-4 mt-4 terminal-canvas d-flex align-items-center justify-content-center">
      <div class="text-muted text-center">
        <div class="fw-semibold mb-1">Work Area</div>
        <small>Render job details, drawings, or controls here.</small>
      </div>
    </div>

    {{-- BOTTOM: CONTROLS BAR --}}
<div class="terminal-tile p-3 mt-4 mb-5 d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center gap-3">
        <button type="button" class="btn btn-light d-inline-flex align-items-center gap-2 px-3" title="Stop All">
          <span class="stop-oct" aria-hidden="true">🛑</span>
          <span class="d-none d-sm-inline fw-semibold">Stop</span>
        </button>
      </div>

      <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-dark rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width:44px;height:44px" title="Pause">
          <i class="fa-solid fa-pause"></i>
        </button>
        <button type="button" class="btn btn-dark d-inline-flex align-items-center gap-2 px-3" title="Next">
          <span class="fw-semibold">Next</span>
          <i class="fa-solid fa-arrow-right"></i>
        </button>
      </div>
    </div>

  </div>

  {{-- RIGHT SIDEBAR: PREVIEW + CHAT --}}
  <div class="col-xl-3">
    {{-- Preview card --}}
    <div class="terminal-tile p-3">
      <h6 class="fw-bold mb-3">Preview</h6>

      @if($previewUrl)
        <div class="ratio ratio-4x3 rounded-3 overflow-hidden border">
          <img src="{{ $previewUrl }}" class="w-100 h-80 object-fit-cover" alt="Preview">
        </div>
      @else
        <div class="preview-box ratio ratio-4x3 rounded-3 border d-flex align-items-center justify-content-center bg-light">
          <div class="text-muted small">No preview</div>
        </div>
      @endif
    </div>

    {{-- Chat card --}}
    <div class="terminal-tile p-3 mt-4">
      <h6 class="fw-bold mb-3">Chat</h6>
      <div class="chat-log border rounded-3 p-2 mb-2 bg-light-subtle">
        <div class="small text-muted">No messages yet.</div>
      </div>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Type a message…">
        <button class="btn btn-primary" type="button">
          <i class="fa-solid fa-paper-plane"></i>
        </button>
      </div>
    </div>
  </div>

</div>

<div class="mb-4"></div>

{{-- LOCAL STYLES --}}
<style>
  .terminal-tile{
    background:#fff;
    border-radius:20px;
    border:1px solid rgba(0,0,0,.06);
    box-shadow:0 1px 2px rgba(0,0,0,.04);
  }
  .terminal-canvas{ min-height:420px; }
  .stop-oct{
    display:inline-flex; align-items:center; justify-content:center;
    width:22px; height:22px; font-size:16px; line-height:1;
  }
  .preview-box img{ object-fit:cover; }
  .chat-log{
    height:220px;
    overflow:auto;
  }
  /* utility if missing */
  .object-fit-cover{ object-fit:cover; }
</style>
