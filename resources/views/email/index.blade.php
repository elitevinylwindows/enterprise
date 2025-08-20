@extends('layouts.app')

@section('page-title', 'Email')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Email</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-header bg-white">
    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#composeModal">
          <i data-feather="edit-3" class="me-1"></i> Compose
        </button>
        <div class="vr d-none d-md-block"></div>
        <div class="btn-group btn-group-sm" role="group" aria-label="Bulk actions">
          <button id="selectAllBtn" class="btn btn-light" title="Select All"><i data-feather="check-square"></i></button>
          <button class="btn btn-light" id="markReadBtn" title="Mark as read"><i data-feather="mail"></i></button>
          <button class="btn btn-light" id="archiveBtn" title="Archive"><i data-feather="archive"></i></button>
          <button class="btn btn-light text-danger" id="deleteBtn" title="Delete"><i data-feather="trash-2"></i></button>
        </div>
      </div>

      <div class="d-flex flex-grow-1 flex-md-grow-0 align-items-center gap-2">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-light border-0"><i data-feather="search"></i></span>
          <input type="search" class="form-control border-0" placeholder="Search mail, names, or keywords…" id="emailSearch">
        </div>
        <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#filterModal" title="Filters">
          <i data-feather="sliders"></i>
        </button>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="row g-0" id="emailSplitPane">
      <!-- Sidebar -->
      <aside class="col-12 col-md-3 col-lg-2 border-end bg-body">
        <nav class="list-group list-group-flush py-2">
          <a href="#" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between active">
            <span><i data-feather="inbox" class="me-2"></i>Inbox</span>
            <span class="badge bg-primary rounded-pill">12</span>
          </a>
          <a href="#" class="list-group-item list-group-item-action"><i data-feather="send" class="me-2"></i>Sent</a>
          <a href="#" class="list-group-item list-group-item-action"><i data-feather="file-text" class="me-2"></i>Drafts</a>
          <a href="#" class="list-group-item list-group-item-action"><i data-feather="archive" class="me-2"></i>Archived</a>
          <a href="#" class="list-group-item list-group-item-action"><i data-feather="trash-2" class="me-2"></i>Trash</a>

          <div class="px-3 pt-3 small text-muted">Labels</div>
          <a href="#" class="list-group-item list-group-item-action"><span class="badge bg-warning me-2">Urgent</span> Project A</a>
          <a href="#" class="list-group-item list-group-item-action"><span class="badge bg-info me-2">Info</span> Finance</a>
          <a href="#" class="list-group-item list-group-item-action"><span class="badge bg-success me-2">OK</span> Customers</a>
        </nav>
      </aside>

      <!-- List -->
      <section class="col-12 col-md-4 col-lg-4 border-end" style="min-height: 70vh;">
        <div class="d-flex align-items-center justify-content-between px-3 py-2 border-bottom bg-body">
          <div class="small text-muted">Showing latest</div>
          <div class="btn-group btn-group-sm">
            <button class="btn btn-light" id="refreshBtn" title="Refresh"><i data-feather="refresh-cw"></i></button>
            <button class="btn btn-light" id="compactToggle" title="Compact density"><i data-feather="layout"></i></button>
          </div>
        </div>

        <ul class="list-group list-group-flush email-list" id="emailList">
          @forelse($emails ?? [] as $email)
            <li class="list-group-item email-item py-3 {{ $email->is_unread ? 'email-unread' : '' }}" 
                data-id="{{ $email->id }}">
              <div class="d-flex align-items-start gap-3">
                <div class="form-check mt-1">
                  <input class="form-check-input email-checkbox" type="checkbox" value="{{ $email->id }}">
                </div>

                <div class="rounded-circle flex-shrink-0 bg-light d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                  <span class="small fw-semibold">{{ strtoupper(substr($email->from_name ?? 'U',0,1)) }}</span>
                </div>

                <div class="flex-grow-1">
                  <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex align-items-center gap-2">
                      <button class="btn btn-sm p-0 border-0 bg-transparent email-star" title="Star">
                        <i data-feather="{{ $email->is_starred ? 'star' : 'star' }}" class="{{ $email->is_starred ? 'text-warning' : 'text-muted' }}"></i>
                      </button>
                      <span class="fw-semibold">{{ $email->from_name ?? $email->from_email }}</span>
                      @if(!empty($email->labels))
                        @foreach($email->labels as $label)
                          <span class="badge bg-light text-dark border">{{ $label }}</span>
                        @endforeach
                      @endif
                    </div>
                    <small class="text-muted">{{ $email->sent_at?->format('M d, H:i') }}</small>
                  </div>
                  <div class="text-truncate">
                    <a href="javascript:void(0)" class="stretched-link email-open text-decoration-none">
                      <span class="me-2">{{ $email->subject }}</span>
                      @if($email->has_attachments)
                        <i data-feather="paperclip" class="align-text-bottom"></i>
                      @endif
                    </a>
                  </div>
                  <div class="text-muted small text-truncate">{{ $email->snippet }}</div>
                </div>
              </div>
            </li>
          @empty
            <li class="list-group-item py-5 text-center text-muted">No emails found.</li>
          @endforelse
        </ul>

        @if(($emails ?? null) && method_exists($emails, 'links'))
          <div class="px-3 py-2 border-top">
            {{ $emails->links() }}
          </div>
        @endif
      </section>

      <!-- Preview -->
      <article class="col-12 col-md-5 col-lg-6" id="emailPreview">
        <div class="h-100 d-flex flex-column">
          <div class="border-bottom px-3 py-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
              <button class="btn btn-sm btn-light d-md-none" id="backToList"><i data-feather="chevron-left"></i></button>
              <h5 class="mb-0 fw-semibold" id="previewSubject">Select an email</h5>
            </div>
            <div class="btn-group btn-group-sm">
              <button class="btn btn-light" id="replyBtn"><i data-feather="corner-up-left"></i></button>
              <button class="btn btn-light" id="forwardBtn"><i data-feather="corner-up-right"></i></button>
              <button class="btn btn-light" id="printBtn"><i data-feather="printer"></i></button>
              <button class="btn btn-light text-danger" id="previewDeleteBtn"><i data-feather="trash-2"></i></button>
            </div>
          </div>

          <div class="px-3 py-2 small text-muted border-bottom" id="previewMeta">
            <div><strong id="previewFrom">—</strong> <span id="previewFromEmail" class="text-muted"></span></div>
            <div>To: <span id="previewTo">—</span></div>
            <div>Date: <span id="previewDate">—</span></div>
          </div>

          <div class="p-3 overflow-auto" style="min-height: 40vh;" id="previewBody">
            <div class="text-muted">Nothing selected.</div>
          </div>

          <div class="border-top p-3 d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-outline-secondary"><i data-feather="mail"></i> Mark as unread</button>
            <button class="btn btn-sm btn-outline-secondary"><i data-feather="archive"></i> Archive</button>
            <button class="btn btn-sm btn-outline-danger ms-auto"><i data-feather="trash-2"></i> Delete</button>
          </div>
        </div>
      </article>
    </div>
  </div>
</div>

{{-- Compose Modal --}}
<div class="modal fade" id="composeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i data-feather="edit-3" class="me-2"></i>New Message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label class="form-label">To</label>
          <input type="email" class="form-control" placeholder="name@example.com">
        </div>
        <div class="mb-2">
          <label class="form-label">Subject</label>
          <input type="text" class="form-control" placeholder="Subject">
        </div>
        <div class="mb-2">
          <label class="form-label">Message</label>
          <textarea class="form-control" rows="10" placeholder="Write your message…"></textarea>
        </div>
        <div class="mb-2">
          <label class="form-label">Attachments</label>
          <input type="file" class="form-control" multiple>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary"><i data-feather="send" class="me-1"></i> Send</button>
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Discard</button>
      </div>
    </form>
  </div>
</div>

{{-- Filter Modal --}}
<div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i data-feather="sliders" class="me-2"></i>Filters</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Status</label>
            <select class="form-select">
              <option value="">Any</option>
              <option>Unread</option>
              <option>Starred</option>
              <option>Has attachments</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Date</label>
            <select class="form-select">
              <option>Any time</option>
              <option>Last 24 hours</option>
              <option>Last 7 days</option>
              <option>Last 30 days</option>
            </select>
          </div>
          <div class="col-12">
            <label class="form-label">From</label>
            <input type="text" class="form-control" placeholder="name@example.com">
          </div>
          <div class="col-12">
            <label class="form-label">Has words</label>
            <input type="text" class="form-control" placeholder="invoice, quote, meeting…">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Apply</button>
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Reset</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('styles')
<style>
  /* Compact density toggle */
  .email-list.compact .email-item { padding-top:.5rem!important; padding-bottom:.5rem!important; }
  .email-unread { background: var(--bs-light-bg-subtle, #f8f9fa); }
  @media (max-width: 767.98px){
    #emailPreview { display:none; }
    #emailSplitPane.show-preview #emailPreview { display:block; }
    #emailSplitPane.show-preview section.col-md-4 { display:none; }
  }
</style>
@endpush

@push('scripts')
<script>
  feather.replace();

  // Demo JS wiring (stubbed)
  const splitPane = document.getElementById('emailSplitPane');
  const list = document.getElementById('emailList');
  const backBtn = document.getElementById('backToList');
  const compactToggle = document.getElementById('compactToggle');

  // Toggle compact density
  compactToggle?.addEventListener('click', () => {
    list.classList.toggle('compact');
  });

  // Mobile back to list
  backBtn?.addEventListener('click', () => {
    splitPane.classList.remove('show-preview');
  });

  // Open preview (demo: replace with AJAX fetch for email body/meta)
  list?.addEventListener('click', (e) => {
    const a = e.target.closest('.email-open, .email-item');
    if (!a) return;
    const item = e.target.closest('.email-item');
    if (!item) return;

    // Example: populate preview with placeholders (replace with real data)
    document.getElementById('previewSubject').textContent = item.querySelector('.text-truncate a')?.innerText?.trim() || 'Subject';
    document.getElementById('previewFrom').textContent = item.querySelector('.fw-semibold')?.innerText || 'Sender';
    document.getElementById('previewFromEmail').textContent = ' <sender@example.com>';
    document.getElementById('previewTo').textContent = 'me@company.com';
    document.getElementById('previewDate').textContent = new Date().toLocaleString();
    document.getElementById('previewBody').innerHTML = `<p class="mb-2 text-muted small">Preview content goes here.</p><p>${item.querySelector('.text-muted.small')?.innerText || ''}</p>`;

    // Mark read UI state
    item.classList.remove('email-unread');

    // Mobile: switch pane
    splitPane.classList.add('show-preview');
  });

  // Bulk select
  document.getElementById('selectAllBtn')?.addEventListener('click', () => {
    document.querySelectorAll('.email-checkbox').forEach(cb => cb.checked = true);
  });

  // TODO: bind real routes for mark read/archive/delete/refresh
</script>
@endpush
