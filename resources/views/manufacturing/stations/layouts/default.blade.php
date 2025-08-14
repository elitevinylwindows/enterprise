@php
  $terminalLabel = $station->station ?? $station->name ?? '01';

  // Demo queue; replace with your real data
  $queue = $queue ?? [
    ['job' => 'JP-1001', 'qty' => 24],
    ['job' => 'JP-1002', 'qty' => 10],
    ['job' => 'JP-1003', 'qty' => 18],
  ];

  $previewUrl = $previewUrl ?? null; // pass from controller if you have one
@endphp

<div class="row g-4">

  {{-- LEFT: MAIN COLUMN ----------------------------------------------------}}
  <div class="col-xl-9">

    {{-- TOP: Job Info • Notes • Queue (same height) ------------------------}}
    <div class="row g-4 align-items-stretch">
      {{-- Job Info --}}
      <div class="col-md-4">
        <div class="tile top-tile p-4 h-100">
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
        <div class="tile top-tile p-4 h-100">
          <h5 class="fw-bold mb-3">NOTES</h5>
          <textarea class="form-control" rows="7" placeholder="Type notes here…"></textarea>
        </div>
      </div>

      {{-- Queue --}}
      <div class="col-md-4">
        <div class="tile top-tile p-4 h-100">
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
                      <div class="d-inline-flex gap-1">
                        <button class="icon-btn" title="Pause">
                          <i class="fa-solid fa-pause"></i>
                        </button>
                        <button class="icon-btn" title="Stop">
                          <i class="fa-solid fa-hand"></i>
                        </button>
                        <button class="icon-btn" title="Prioritize">
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

    {{-- MIDDLE: BIG WORK AREA -----------------------------------------------}}
    <div class="tile p-4 mt-4 work-area d-flex align-items-center justify-content-center">
      <div class="text-muted text-center">
        <div class="fw-semibold mb-1">Work Area</div>
        <small>Render job details, drawings, or controls here.</small>
      </div>
    </div>

    {{-- BOTTOM: CONTROLS BAR -------------------------------------------------}}
    <div class="tile p-3 mt-4 mb-5 d-flex align-items-center justify-content-between">
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

  {{-- RIGHT SIDEBAR: CHAT (top same height) + PREVIEW (tall) ----------------}}
  <div class="col-xl-3">
    {{-- Chat at the top, same height as top tiles --}}
    <div class="w-100 h-100 tile top-tile top-tile-fixed tile-chat p-4">
  <h5 class="fw-bold mb-3">CHAT</h5>

  <div class="chat-log flex-grow-1 border rounded-3 p-2 mb-2 bg-light-subtle overflow-auto">
    <div class="small text-muted">No messages yet.</div>
  </div>

  <div class="input-group mt-auto">
    <input type="text" class="form-control" placeholder="Type a message…">
    <button class="btn btn-primary" type="button">
      <i class="fa-solid fa-paper-plane"></i>
    </button>
  </div>
</div>


    {{-- Tall preview below, fills down to bottom --}}
    <div class="tile p-3 mt-4 preview-sticky">
      <h6 class="fw-bold mb-3">Preview</h6>
      @if($previewUrl)
        <div class="ratio ratio-4x3 rounded-3 overflow-hidden border">
          <img src="{{ $previewUrl }}" class="w-100 h-100 object-fit-cover" alt="Preview">
        </div>
      @else
        <div class="ratio ratio-4x3 rounded-3 border d-flex align-items-center justify-content-center bg-light">
          <div class="text-muted small">No preview</div>
        </div>
      @endif
    </div>
  </div>

</div>

{{-- LOCAL STYLES ------------------------------------------------------------}}
<style>
  :root{
    --top-tile-minh: 260px;   /* controls the uniform height of the top cards (and Chat) */
    --gap-y: 1.5rem;          /* vertical gap used for sticky math */
  }

  .tile{
    background:#fff;
    border-radius:20px;
    border:1px solid rgba(0,0,0,.06);
    box-shadow:0 1px 2px rgba(0,0,0,.04);
  }
  .top-tile{ min-height: var(--top-tile-minh); }
  .work-area{ min-height: 420px; }

  /* Right preview stays visible while scrolling */
  .preview-sticky{
    position: sticky;
    top: var(--gap-y);
  }

  /* Icon-only buttons for Queue actions (neutral, hover-only emphasis) */
  .icon-btn{
    appearance: none;
    background: transparent;
    border: 0;
    color: #6c757d;
    padding: .25rem .35rem;
    border-radius: 8px;
    transition: color .15s ease, transform .15s ease, background-color .15s ease;
  }
  .icon-btn:hover{
    color: #111;
    background: rgba(0,0,0,.05);
    transform: translateY(-1px);
  }
  .icon-btn:active{
    transform: translateY(0);
  }

  .stop-oct{
    display:inline-flex; align-items:center; justify-content:center;
    width:22px; height:22px; font-size:16px; line-height:1;
  }
  .chat-log{ height: 150px; overflow: auto; }
  .object-fit-cover{ object-fit: cover; }
</style>
