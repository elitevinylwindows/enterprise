@php
  $terminalLabel = $station->station ?? $station->name ?? '01';

  // Demo queue; replace with real data
  $queue = $queue ?? [
    ['job' => 'JP-1001', 'qty' => 24],
    ['job' => 'JP-1002', 'qty' => 10],
    ['job' => 'JP-1003', 'qty' => 18],
  ];

  $previewUrl = $previewUrl ?? null;
@endphp

<div class="container-fluid">

  {{-- TOP ROW: Terminal • Notes • Queue • Chat (all equal height) --}}
  <div class="row g-4 align-items-stretch top-row-equal">

    {{-- Terminal --}}
    <div class="col-lg-3 col-md-6">
      <div class="tile top-tile-fixed p-4 d-flex flex-column">
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
    <div class="col-lg-3 col-md-6">
      <div class="tile top-tile-fixed p-4 d-flex flex-column">
        <h5 class="fw-bold mb-3">NOTES</h5>
        <textarea class="form-control flex-grow-1" rows="7" placeholder="Type notes here…"></textarea>
      </div>
    </div>

    {{-- Queue --}}
    <div class="col-lg-3 col-md-6">
      <div class="tile top-tile-fixed p-4 d-flex flex-column">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h5 class="fw-bold mb-0">QUEUE</h5>
        </div>

        <div class="scroll-area flex-grow-1 overflow-auto">
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
                      <button class="icon-btn" title="Pause"><i class="fa-solid fa-pause"></i></button>
                      <button class="icon-btn" title="Stop"><i class="fa-solid fa-hand"></i></button>
                      <button class="icon-btn" title="Prioritize"><i class="fa-solid fa-arrow-up"></i></button>
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

    {{-- Chat --}}
    <div class="col-lg-3 col-md-6">
      <div class="tile top-tile-fixed p-4 d-flex flex-column">
        <h5 class="fw-bold mb-3">CHAT</h5>
        <div class="chat-log flex-grow-1 border rounded-3 p-2 mb-2 bg-light-subtle overflow-auto">
          <div class="small text-muted">No messages yet.</div>
        </div>
        <div class="input-group mt-auto">
          <input type="text" class="form-control" placeholder="Type a message…">
          <button class="btn btn-primary" type="button"><i class="fa-solid fa-paper-plane"></i></button>
        </div>
      </div>
    </div>

  </div>

  {{-- MIDDLE ROW: Work Area (left) • Preview (right) --}}
 <div class="row g-4 mt-4 align-items-stretch">
  <div class="col-xl-9 d-flex">
    <div class="tile p-4 work-area h-100 flex-fill d-flex align-items-center justify-content-center">

        <div class="text-muted text-center">
          <div class="fw-semibold mb-1">Work Area</div>
          <small>Render job details, drawings, or controls here.</small>
        </div>
      </div>
    </div>

    <div class="col-xl-3 d-flex">
  <div class="tile p-3 h-100 flex-fill">
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

  {{-- BOTTOM ROW: Controls (left) --}}
  <div class="row g-4 mt-4">
    <div class="col-xl-9">
      <div class="tile p-3 d-flex align-items-center justify-content-between mb-5">
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
  </div>

</div>

{{-- LOCAL STYLES --}}
<style>
  :root{
    /* same height for all four top cards */
    --top-tile-h: 280px;
  }

  .tile{
    background:#fff;
    border-radius:20px;
    border:1px solid rgba(0,0,0,.06);
    box-shadow:0 1px 2px rgba(0,0,0,.04);
  }

  .top-tile-fixed{ height: var(--top-tile-h); }

  /* inner areas scroll instead of stretching the tile */
  .scroll-area{ min-height: 0; }
  .chat-log{ min-height: 0; }

  .work-area{ min-height: 420px; }
  .object-fit-cover{ object-fit: cover; }

  /* keep preview visible as you scroll */
  .preview-sticky{ position: sticky; top: 1rem; }

  /* neutral icon-only buttons for queue actions */
  .icon-btn{
    appearance:none; background:transparent; border:0; color:#6c757d;
    padding:.25rem .35rem; border-radius:8px;
    transition: color .15s ease, transform .15s ease, background-color .15s ease;
  }
  .icon-btn:hover{ color:#111; background:rgba(0,0,0,.05); transform:translateY(-1px); }
  .icon-btn:active{ transform:none; }

  .stop-oct{
    display:inline-flex; align-items:center; justify-content:center;
    width:22px; height:22px; font-size:16px; line-height:1;
  }
</style>
