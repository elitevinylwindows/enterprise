@extends('layouts.app')

@section('page-title', __('Email'))

@section('content')
<div class="email-app d-flex" style="height: calc(100vh - 120px);">

  {{-- LEFT SIDEBAR --}}
  <aside class="email-sidebar border-end p-3" style="width:260px; flex-shrink:0; overflow:auto;">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <div class="fw-bold">My Mail</div>
        <div class="small text-muted">you@company.com</div>
      </div>
      <i data-feather="more-vertical"></i>
    </div>

    <div class="d-grid mb-3">
      <a href="#" class="btn btn-primary rounded-3">
        <i data-feather="edit-3" class="me-1"></i> Compose
      </a>
    </div>

    <ul class="list-unstyled email-nav">
      <li class="mb-2"><a href="#" class="d-flex justify-content-between align-items-center active">
        <span><i data-feather="inbox" class="me-2"></i>Inbox</span>
        <span class="badge bg-light text-dark">45</span>
      </a></li>
      <li class="mb-2"><a href="#"><i data-feather="star" class="me-2"></i>Starred</a></li>
      <li class="mb-2"><a href="#"><i data-feather="send" class="me-2"></i>Sent</a></li>
      <li class="mb-2"><a href="#"><i data-feather="file-text" class="me-2"></i>Drafts</a></li>
      <li class="mb-2"><a href="#"><i data-feather="trash-2" class="me-2"></i>Deleted</a></li>
    </ul>

    <div class="mt-4">
      <div class="small text-uppercase text-muted fw-bold mb-2">Labels</div>
      <ul class="list-unstyled email-nav">
        <li class="mb-2"><a href="#"><i data-feather="briefcase" class="me-2"></i>Work</a></li>
        <li class="mb-2"><a href="#"><i data-feather="users" class="me-2"></i>Team Events</a></li>
        <li class="mb-2"><a href="#"><i data-feather="layers" class="me-2"></i>Applications</a></li>
      </ul>
    </div>
  </aside>

  {{-- MESSAGE LIST --}}
  <section class="email-list border-end flex-grow-1 d-flex flex-column" style="max-width:400px;">
    <div class="p-3 border-bottom d-flex align-items-center">
      <input type="checkbox" class="form-check-input me-3">
      <button class="btn btn-sm btn-light border me-2"><i data-feather="refresh-cw"></i></button>
      <div class="input-group input-group-sm">
        <span class="input-group-text bg-transparent border-end-0"><i data-feather="search"></i></span>
        <input type="text" class="form-control border-start-0" placeholder="Search mail…">
      </div>
    </div>

    <div class="flex-grow-1 overflow-auto">
      @for ($i = 0; $i < 12; $i++)
      <a href="#" class="email-item d-block p-3 border-bottom text-reset text-decoration-none">
        <div class="d-flex align-items-center mb-1">
          <span class="fw-bold me-2">Megan Jackson</span>
          <span class="text-muted flex-grow-1 text-truncate">— New project lead</span>
          <small class="text-muted">11:30am</small>
        </div>
        <div class="text-muted small text-truncate">Hey Edward, just checking in about the docs…</div>
      </a>
      @endfor
    </div>
  </section>

  {{-- READER PANEL --}}
  <section class="email-reader flex-grow-1 d-flex flex-column">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
      <div>
        <h6 class="mb-1">New Project Lead</h6>
        <div class="small text-muted">From: megan@company.com</div>
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-sm btn-light border"><i data-feather="archive"></i></button>
        <button class="btn btn-sm btn-light border"><i data-feather="trash-2"></i></button>
        <button class="btn btn-sm btn-light border"><i data-feather="corner-up-left"></i></button>
      </div>
    </div>

    <div class="flex-grow-1 overflow-auto p-3">
      <p>Thanks for sending over the documents. We’re good to go on this end — very excited to start working with you!</p>
      <div class="fw-bold mt-4">Attachments</div>
      <div class="d-flex gap-2 mt-2">
        <a href="#" class="btn btn-sm btn-outline-secondary"><i data-feather="file"></i> Project.pdf</a>
        <a href="#" class="btn btn-sm btn-outline-secondary"><i data-feather="image"></i> Screenshot.png</a>
      </div>
    </div>

    <div class="p-3 border-top">
      <form>
        <div class="form-control mb-2" contenteditable="true" style="min-height:120px;">Reply here…</div>
        <button class="btn btn-primary"><i data-feather="send" class="me-1"></i> Send</button>
      </form>
    </div>
  </section>

</div>
@endsection

@push('styles')
<style>
  .email-app { background:#fff; border-radius:.75rem; overflow:hidden; }
  .email-nav a { display:flex; align-items:center; color:inherit; text-decoration:none; padding:.35rem .5rem; border-radius:.35rem; }
  .email-nav a:hover { background:var(--bs-light); }
  .email-nav a.active { background:var(--bs-primary); color:#fff; }
  .email-item:hover { background:var(--bs-light); }
</style>
@endpush

@push('scripts')
<script> feather.replace(); </script>
@endpush
