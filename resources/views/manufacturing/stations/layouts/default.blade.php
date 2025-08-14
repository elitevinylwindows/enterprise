@extends('layouts.app')

@section('page-title', __('Station Terminal'))

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{ __('Station Terminal') }}</li>
@endsection

@section('content')
@php
  // Safe fallbacks so this page renders even without data
  $station    = $station    ?? (object)['id' => 1, 'station' => 'Glass Cutting'];
  $previewUrl = $previewUrl ?? null;
  $queue = $queue ?? [
    ['job' => 'JP-1001', 'qty' => 24],
    ['job' => 'JP-1002', 'qty' => 10],
    ['job' => 'JP-1003', 'qty' => 18],
  ];
  $terminalLabel = $station->station ?? $station->name ?? '01';
@endphp

<div class="container-fluid pb-5">

  {{-- PAGE GRID --}}
  <div class="row g-4 terminal-page">

    {{-- LEFT MAIN COLUMN --}}
    <div class="col-xl-9">

      {{-- TOP ROW: Job • Notes • Queue (equal height) --}}
      <div class="row g-4 align-items-stretch top-row-equal">

        {{-- Job Info --}}
        <div class="col-md-4">
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
        <div class="col-md-4">
          <div class="tile top-tile-fixed p-4 d-flex flex-column">
            <h5 class="fw-bold mb-3">NOTES</h5>
            <textarea class="form-control flex-grow-1" rows="7" placeholder="Type notes here…"></textarea>
          </div>
        </div>

        {{-- Queue --}}
        <div class="col-md-4">
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

      </div>

      {{-- MIDDLE: Work Area --}}
      <div class="tile p-4 mt-4 work-area d-flex align-items-center justify-content-center">
        <div class="text-muted text-center">
          <div class="fw-semibold mb-1">Work Area</div>
          <small>Render job details, drawings, or controls here.</small>
        </div>
      </div>

      {{-- BOTTOM: Controls bar --}}
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

    {{-- RIGHT SIDEBAR: Chat (top equal height) + Preview (fills rest) --}}
    <div class="col-xl-3 d-flex flex-column min-h-0">

      {{-- Chat --}}
      <div class="tile top-tile-fixed tile-chat p-4 d-flex flex-column">
        <h5 class="fw-bold mb-3">CHAT</h5>
        <div class="chat-log flex-grow-1 border rounded-3 p-2 mb-2 bg-light-subtle overflow-auto">
          <div class="small text-muted">No messages yet.</div>
        </div>
        <div class="input-group mt-auto">
          <input type="text" class="form-control" placeholder="Type a message…">
          <button class="btn btn-primary" type="button"><i class="fa-solid fa-paper-plane"></i></button>
        </div>
      </div>

      {{-- Preview (fills remaining height) --}}
      <div class="tile p-3 mt-4 flex-grow-1 d-flex flex-column min-h-0">
        <h6 class="fw-bold mb-3">Preview</h6>
        <div class="ratio ratio-4x3 rounded-3 overflow-hidden border flex-grow-1">
          @if($previewUrl)
            <img src="{{ $previewUrl }}" class="w-100 h-100 object-fit-cover" alt="Preview">
          @else
            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-muted small">
              No preview
            </div>
          @endif
        </div>
      </div>

    </div>

  </div>
</div>

{{-- LOCAL STYLES --}}
@push('styles')
<style>
  :root{
    /* Height for ALL top-row cards (Job / Notes / Queue / Chat) */
    --top-tile-h: 280px;
  }

  /* Page section tall enough so right column can flex */
  .terminal-page{ min-height: calc(100vh - 6rem); } /* adjust subtraction for your header height */

  /* Base tile */
  .tile{
    background:#fff;
    border-radius:20px;
    border:1px solid rgba(0,0,0,.06);
    box-shadow:0 1px 2px rgba(0,0,0,.04);
  }

  /* Equalize top-row card heights */
  .top-row-equal .top-tile-fixed,
  .top-tile-fixed{ height: var(--top-tile-h); }

  /* Let inner content scroll instead of stretching the card */
  .scroll-area{ min-height: 0; }
  .tile-chat{ min-height: 0; }
  .chat-log{ min-height: 0; }

  /* Work area min height */
  .work-area{ min-height: 420px; }

  /* Helpers */
  .object-fit-cover{ object-fit: cover; }
  .min-h-0{ min-height: 0 !important; }

  /* Queue icon-only buttons (neutral; hover highlight) */
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

  /* Little stop icon pill */
  .stop-oct{
    display:inline-flex; align-items:center; justify-content:center;
    width:22px; height:22px; font-size:16px; line-height:1;
  }
</style>
@endpush
@endsection
