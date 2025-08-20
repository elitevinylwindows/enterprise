{{-- resources/views/email/index.blade.php --}}
@extends('layouts.app')

@section('page-title', __('Email'))

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-body p-0">
    <div class="row g-0">

      {{-- LEFT: folders / labels --}}
      <aside class="col-12 col-md-3 col-lg-3 border-end">
        <div class="p-3 d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <span class="avatar bg-primary-subtle text-primary fw-bold">G</span>
            <div class="small">
              <div class="fw-semibold">Google account</div>
              <div class="text-muted">you@company.com</div>
            </div>
          </div>
          <button class="btn btn-soft-secondary btn-sm">
            <i data-feather="more-vertical"></i>
          </button>
        </div>

        <div class="px-3 pb-3">
          <a href="#" class="btn btn-primary w-100 rounded-3">
            <i data-feather="edit-3" class="me-1"></i> Compose
          </a>
        </div>

        <div class="px-2 small text-uppercase text-muted fw-semibold">Inbox</div>
        <ul class="list-group list-group-flush mb-3 email-nav">
          <li class="list-group-item d-flex justify-content-between align-items-center active">
            <a href="#" class="stretched-link text-white">
              <i data-feather="inbox" class="me-2"></i> Mail inbox
            </a>
            <span class="badge bg-white text-primary fw-semibold">45</span>
          </li>
          <li class="list-group-item"><i data-feather="star" class="me-2"></i> Starred <span class="ms-auto text-muted">12</span></li>
          <li class="list-group-item"><i data-feather="send" class="me-2"></i> Sent <span class="ms-auto text-muted">20</span></li>
          <li class="list-group-item"><i data-feather="file-text" class="me-2"></i> Drafts <span class="ms-auto text-muted">3</span></li>
          <li class="list-group-item"><i data-feather="trash-2" class="me-2"></i> Deleted</li>
        </ul>

        <div class="px-2 small text-uppercase text-muted fw-semibold">Labels</div>
        <ul class="list-group list-group-flush email-nav">
          <li class="list-group-item d-flex align-items-center">
            <span class="dot dot-blue me-2"></span> Work <span class="ms-auto text-muted">32</span>
          </li>
          <li class="list-group-item d-flex align-items-center">
            <span class="dot dot-violet me-2"></span> Team events <span class="ms-auto text-muted">42</span>
          </li>
          <li class="list-group-item d-flex align-items-center">
            <span class="dot dot-amber me-2"></span> Applications <span class="ms-auto text-muted">12</span>
          </li>
        </ul>

        <div class="p-3">
          <div class="small text-uppercase text-muted fw-semibold mb-2">Upcoming meetings</div>
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-secondary-subtle text-secondary">15 min</span>
            <div class="small">
              <div class="fw-semibold">Design Team Meeting</div>
              <div class="text-muted">09:30 – 09:45 AM</div>
            </div>
          </div>
          <div class="d-flex align-items-center gap-2">
            <span class="badge bg-secondary-subtle text-secondary">60 min</span>
            <div class="small">
              <div class="fw-semibold">Interview block</div>
              <div class="text-muted">11:30 – 12:30 PM</div>
            </div>
          </div>
        </div>
      </aside>

      {{-- MIDDLE: message list --}}
      <section class="col-12 col-md-4 col-lg-4 border-end d-flex flex-column">
        <div class="p-3 border-bottom d-flex align-items-center gap-2">
          <div class="form-check me-2">
            <input class="form-check-input" type="checkbox" id="checkAll">
          </div>
          <div class="ms-auto d-flex align-items-center gap-2">
            <button class="btn btn-soft-secondary btn-sm"><i data-feather="refresh-cw"></i></button>
            <button class="btn btn-soft-secondary btn-sm"><i data-feather="sliders"></i></button>
            <div class="input-group input-group-sm" style="max-width: 240px;">
              <span class="input-group-text bg-transparent border-end-0"><i data-feather="search"></i></span>
              <input type="search" class="form-control border-start-0" placeholder="Search mail…">
            </div>
          </div>
        </div>

        <div class="flex-grow-1 overflow-auto" style="max-height: calc(100vh - 240px);">
          @for ($i = 0; $i < 10; $i++)
          <a href="#" class="list-group-item list-group-item-action py-3 px-3 d-block email-row">
            <div class="d-flex align-items-center">
              <div class="form-check me-2">
                <input class="form-check-input" type="checkbox">
              </div>
              <div class="avatar avatar-sm bg-info-subtle text-info rounded-circle me-2 fw-semibold">M</div>
              <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2">
                  <span class="fw-semibold">Megan Jackson</span>
                  <span class="text-muted">· New project lead</span>
                  <span class="ms-auto small text-muted">Today, 11:30am</span>
                </div>
                <div class="text-muted small mt-1 text-truncate">
                  Hey Edward, just getting in touch because I wanted to get…
                </div>
                <div class="mt-2 d-flex align-items-center gap-2">
                  <span class="chip chip-blue"><i data-feather="briefcase" class="me-1"></i>Work</span>
                  <span class="chip chip-gray"><i data-feather="inbox" class="me-1"></i>Inbox</span>
                  <i data-feather="paperclip" class="small text-muted"></i>
                </div>
              </div>
            </div>
          </a>
          @endfor
        </div>
      </section>

      {{-- RIGHT: reader / composer --}}
      <section class="col-12 col-md-5 col-lg-5 d-flex flex-column">
        <div class="p-3 border-bottom">
          <div class="d-flex align-items-start justify-content-between">
            <div>
              <div class="d-flex align-items-center gap-2">
                <span class="avatar bg-warning-subtle text-warning fw-bold">M</span>
                <h6 class="mb-0">New project lead</h6>
              </div>
              <div class="small text-muted mt-1">megan@company.com • To you • Cc: Team</div>
            </div>
            <div class="d-flex align-items-center gap-1">
              <button class="btn btn-soft-secondary btn-sm"><i data-feather="archive"></i></button>
              <button class="btn btn-soft-secondary btn-sm"><i data-feather="trash-2"></i></button>
              <button class="btn btn-soft-secondary btn-sm"><i data-feather="corner-up-left"></i></button>
              <button class="btn btn-soft-secondary btn-sm"><i data-feather="more-horizontal"></i></button>
            </div>
          </div>

          <div class="d-flex flex-wrap gap-2 mt-3">
            <span class="chip chip-gray"><i data-feather="inbox" class="me-1"></i>Inbox</span>
            <span class="chip chip-purple"><i data-feather="pen-tool" class="me-1"></i>Design</span>
            <span class="chip chip-amber"><i data-feather="check-circle" class="me-1"></i>Review</span>
            <span class="chip chip-green"><i data-feather="users" class="me-1"></i>Team</span>
          </div>
        </div>

        <div class="flex-grow-1 overflow-auto p-3" style="max-height: calc(100vh - 340px);">
          <div class="mb-3">
            <div class="small text-muted">Today, 5 min ago</div>
            <div class="border rounded p-3 mt-2 bg-body">
              Thanks for sending over the documents. We’re good to go on this end —
              very excited to start working with you!
            </div>
          </div>

          <div class="mb-3">
            <div class="fw-semibold mb-2">Attachments</div>
            <div class="d-flex flex-wrap gap-2">
              <a href="#" class="btn btn-soft-primary btn-sm"><i data-feather="image" class="me-1"></i> Projects 7.png</a>
              <a href="#" class="btn btn-soft-indigo btn-sm"><i data-feather="file-text" class="me-1"></i> Concept brief.pdf</a>
              <a href="#" class="btn btn-soft-orange btn-sm"><i data-feather="film" class="me-1"></i> Instruction.mp4</a>
            </div>
          </div>
        </div>

        {{-- Quick reply --}}
        <div class="border-top p-3">
          <form>
            <div class="mb-2 small text-muted">
              To: <span class="fw-semibold">Megan Jackson</span>
            </div>
            <div class="form-control mb-2" contenteditable="true" style="min-height:120px;">
              Good morning, Megan! Thank you for your response…
            </div>
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
              <div class="btn-group">
                <button class="btn btn-primary"><i data-feather="send" class="me-1"></i> Send</button>
                <button type="button" class="btn btn-soft-secondary"><i data-feather="paperclip"></i></button>
                <button type="button" class="btn btn-soft-secondary"><i data-feather="smile"></i></button>
                <button type="button" class="btn btn-soft-secondary"><i data-feather="calendar"></i></button>
                <button type="button" class="btn btn-soft-secondary"><i data-feather="file"></i></button>
                <button type="button" class="btn btn-soft-secondary"><i data-feather="more-horizontal"></i></button>
              </div>
              <div class="small text-muted">Saved as draft</div>
            </div>
          </form>
        </div>
      </section>

    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .email-nav .list-group-item { border: 0; border-radius: .75rem; margin: .15rem .5rem; }
  .email-nav .list-group-item.active { background: var(--bs-primary); }
  .email-row:hover { background: var(--bs-light); }
  .avatar { width: 34px; height: 34px; display: inline-grid; place-items: center; border-radius: 50%; }

  /* Label dots */
  .dot { width:10px; height:10px; border-radius:50%; display:inline-block }
  .dot-blue{ background:#3b82f6 } .dot-violet{ background:#8b5cf6 } .dot-amber{ background:#f59e0b }

  /* Soft colorful buttons (no outline, gentle bg) */
  .btn-soft-secondary{ background: var(--bs-secondary-bg-subtle); color: var(--bs-secondary); border:0; }
  .btn-soft-secondary:hover{ background: var(--bs-secondary); color:#fff; }
  .btn-soft-primary{ background: var(--bs-primary-bg-subtle); color: var(--bs-primary); border:0; }
  .btn-soft-primary:hover{ background: var(--bs-primary); color:#fff; }
  .btn-soft-indigo{ background:#ede9fe; color:#5b21b6; border:0; }
  .btn-soft-indigo:hover{ background:#5b21b6; color:#fff; }
  .btn-soft-orange{ background:#fff1e6; color:#d97706; border:0; }
  .btn-soft-orange:hover{ background:#d97706; color:#fff; }

  /* Chips like the screenshot */
  .chip{ display:inline-flex; align-items:center; gap:.35rem; padding:.25rem .55rem; border-radius:999px; font-size:.75rem; font-weight:600; }
  .chip-gray{ background: var(--bs-gray-100); color: var(--bs-gray-700); }
  .chip-blue{ background:#e6f0ff; color:#1d4ed8; }
  .chip-purple{ background:#f1e8ff; color:#7c3aed; }
  .chip-amber{ background:#fff4e5; color:#b45309; }
  .chip-green{ background:#e8f7ef; color:#0f766e; }

  @media (max-width: 991.98px){ .email-row .text-truncate{max-width: 60vw;} }
</style>
@endpush

@push('scripts')
<script> feather.replace(); </script>
@endpush
