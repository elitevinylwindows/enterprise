{{-- Modal PARTIAL for customModal — NO @extends --}}
@php
  use Carbon\Carbon;
  $fmt = function($v,$p='Y-m-d'){ if(!$v) return '-'; try{ return Carbon::parse($v)->format($p);}catch(\Throwable){return (string)$v;}};
  $glassRows = $glassRows ?? []; $frameRows = $frameRows ?? []; $sashRows = $sashRows ?? []; $gridRows = $gridRows ?? [];
@endphp

<div class="container-fluid">
  <div class="mb-4"></div> {{-- Space --}}
  <ul class="nav nav-tabs mb-3" role="tablist" style="--bs-nav-tabs-border-width:0;">
    <li class="nav-item" role="presentation">
      <button class="nav-link active text-white" style="background:#a70f0f; border-radius:14px 14px 0 0;"
              data-bs-toggle="tab" data-bs-target="#jp-pane-job" type="button" role="tab">
        {{ __('Job #:') }} {{ $job->job_order_number ?? '-' }}
      </button>
    </li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jp-pane-glass"  type="button">{{ __('Glass') }}</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jp-pane-frame"  type="button">{{ __('Frame') }}</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jp-pane-sash"   type="button">{{ __('Sash') }}</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jp-pane-grids"  type="button">{{ __('Grids') }}</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jp-pane-barc"   type="button">{{ __('Barcodes') }}</button></li>
  </ul>

  <div class="tab-content">

    {{-- Job Order # --}}
    <div class="tab-pane fade show active" id="jp-pane-job" role="tabpanel">
      <div class="card">
        <div class="card-body px-3 px-md-4">
          <div class="row gy-3">
            <div class="col-md-6">
              <div><strong>{{ __('Delivery Date:') }}</strong> {{ $fmt($job->delivery_date) }}</div>
              <div><strong>{{ __('Customer #:') }}</strong> {{ $job->customer_number ?? '-' }}</div>
              <div><strong>{{ __('Customer Name:') }}</strong> {{ $job->customer_name ?? '-' }}</div>
            </div>
            <div class="col-md-6">
              <div><strong>{{ __('Line:') }}</strong> {{ $job->line ?? '-' }}</div>
              <div><strong>{{ __('Series:') }}</strong> {{ $job->series ?? '-' }}</div>
              <div><strong>{{ __('Qty:') }}</strong> {{ $job->qty ?? 0 }}</div>
            </div>
          </div>

          <div class="mt-4">
            <label class="form-label">{{ __('Internal Notes') }}</label>
            <textarea class="form-control" rows="4" disabled>{{ $job->internal_notes ?? '' }}</textarea>
            <div class="mt-4">
  <div class="row g-3 align-items-center">

    {{-- LEFT: 4 Excel + 1 PDF (image icons) --}}
    <div class="col-12 col-md-5">
      <div class="d-flex flex-wrap gap-2">
        <a class="icon-link" aria-label="Glass (XLS)"
           href="{{ route('manufacturing.job_planning.download', ['job'=>$job->id,'type'=>'glass_xls']) }}"
           title="Glass (XLS)"><img src="{{ asset('assets/icons/excel.svg') }}" alt="Excel"></a>

        <a class="icon-link" aria-label="Frame (XLS)"
           href="{{ route('manufacturing.job_planning.download', ['job'=>$job->id,'type'=>'frame_xls']) }}"
           title="Frame (XLS)"><img src="{{ asset('assets/icons/excel.svg') }}" alt="Excel"></a>

        <a class="icon-link" aria-label="Sash (XLS)"
           href="{{ route('manufacturing.job_planning.download', ['job'=>$job->id,'type'=>'sash_xls']) }}"
           title="Sash (XLS)"><img src="{{ asset('assets/icons/excel.svg') }}" alt="Excel"></a>

        <a class="icon-link" aria-label="Grids (XLS)"
           href="{{ route('manufacturing.job_planning.download', ['job'=>$job->id,'type'=>'grids_xls']) }}"
           title="Grids (XLS)"><img src="{{ asset('assets/icons/excel.svg') }}" alt="Excel"></a>

        <a class="icon-link" aria-label="Barcodes (PDF)"
           href="{{ route('manufacturing.job_planning.download', ['job'=>$job->id,'type'=>'barcodes_pdf']) }}"
           title="Barcodes (PDF)"><img src="{{ asset('assets/icons/pdf.svg') }}" alt="PDF"></a>
      </div>
    </div>

    {{-- CENTER: 2 TXT icons --}}
    <div class="col-12 col-md-2 text-center">
      <div class="d-flex justify-content-center gap-2">
        <a class="icon-link" aria-label="Cutlist (TXT)"
           href="{{ route('manufacturing.job_planning.download', ['job'=>$job->id,'type'=>'cutlist_txt']) }}"
           title="Cutlist (TXT)"><img src="{{ asset('assets/icons/txt.svg') }}" alt="TXT"></a>

        <a class="icon-link" aria-label="Labels (TXT)"
           href="{{ route('manufacturing.job_planning.download', ['job'=>$job->id,'type'=>'labels_txt']) }}"
           title="Labels (TXT)"><img src="{{ asset('assets/icons/txt.svg') }}" alt="TXT"></a>
      </div>
    </div>

    {{-- RIGHT: Download All --}}
    <div class="col-12 col-md-5 text-md-end">
      <a href="{{ route('manufacturing.job_planning.download', ['job'=>$job->id,'type'=>'all']) }}"
         class="btn btn-outline-dark">
        <i class="fa-solid fa-download" aria-hidden="true"></i> {{ __('Download All') }}
      </a>
    </div>

  </div>
</div>

          </div>
        </div>
      </div>
    </div>

    {{-- Glass --}}
    <div class="tab-pane fade" id="jp-pane-glass" role="tabpanel">
      <div class="card"><div class="card-body px-3 px-md-4">
        <div class="table-responsive">
          <table class="table table-hover table-sm mb-0">
            <thead class="table-light">
              <tr>
                <th>{{ __('PO') }}</th>
                <th>{{ __('Unit') }}</th>
                <th>{{ __('Grid') }}</th>
                <th>{{ __('Pattern') }}</th>
                <th>{{ __('Cardinal') }}</th>
                <th>{{ __('Glass Description') }}</th>
                <th>{{ __('Width') }}</th>
                <th>{{ __('Height') }}</th>
                <th>{{ __('Slot') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($glassRows as $r)
                <tr>
                  <td>{{ $r['po'] ?? '-' }}</td>
                  <td>{{ $r['unit'] ?? '-' }}</td>
                  <td>{{ $r['grid'] ?? '-' }}</td>
                  <td>{{ $r['pattern'] ?? '-' }}</td>
                  <td>{{ $r['cardinal'] ?? '-' }}</td>
                  <td>{{ $r['glass_description'] ?? '-' }}</td>
                  <td>{{ $r['width'] ?? '-' }}</td>
                  <td>{{ $r['height'] ?? '-' }}</td>
                  <td>{{ $r['slot'] ?? '-' }}</td>
                </tr>
              @empty
                <tr><td colspan="9" class="text-center text-muted">{{ __('No glass rows.') }}</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div></div>
    </div>

    {{-- Frame --}}
    <div class="tab-pane fade" id="jp-pane-frame" role="tabpanel">
      <div class="card"><div class="card-body px-3 px-md-4">
        <div class="table-responsive">
          <table class="table table-hover table-sm mb-0">
            <thead class="table-light">
              <tr>
                <th>{{ __('Bar') }}</th>
                <th>{{ __('Unit') }}</th>
                <th>{{ __('Note') }}</th>
                <th>{{ __('Color') }}</th>
                <th>{{ __('Profile') }}</th>
                <th>{{ __('Frabrication') }}</th>
                <th>{{ __('Cut Lenght') }}</th>
                <th>{{ __('Frame Bin') }}</th>
                <th>{{ __('PO') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($frameRows as $r)
                <tr>
                  <td>{{ $r['bar'] ?? '-' }}</td>
                  <td>{{ $r['unit'] ?? '-' }}</td>
                  <td>{{ $r['note'] ?? '-' }}</td>
                  <td>{{ $r['color'] ?? '-' }}</td>
                  <td>{{ $r['profile'] ?? '-' }}</td>
                  <td>{{ $r['frabrication'] ?? $r['fabrication'] ?? '-' }}</td>
                  <td>{{ $r['cut_lenght'] ?? $r['cut_length'] ?? '-' }}</td>
                  <td>{{ $r['frame_bin'] ?? '-' }}</td>
                  <td>{{ $r['po'] ?? '-' }}</td>
                </tr>
              @empty
                <tr><td colspan="9" class="text-center text-muted">{{ __('No frame rows.') }}</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div></div>
    </div>

    {{-- Sash --}}
    <div class="tab-pane fade" id="jp-pane-sash" role="tabpanel">
      <div class="card"><div class="card-body px-3 px-md-4">
        <div class="table-responsive">
          <table class="table table-hover table-sm mb-0">
            <thead class="table-light">
              <tr>
                <th>{{ __('Bar') }}</th>
                <th>{{ __('Unit') }}</th>
                <th>{{ __('Note') }}</th>
                <th>{{ __('Color') }}</th>
                <th>{{ __('Profile') }}</th>
                <th>{{ __('Fabrication') }}</th>
                <th>{{ __('Cut lenght') }}</th>
                <th>{{ __('Frame Bin') }}</th>
                <th>{{ __('PO') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($sashRows as $r)
                <tr>
                  <td>{{ $r['bar'] ?? '-' }}</td>
                  <td>{{ $r['unit'] ?? '-' }}</td>
                  <td>{{ $r['note'] ?? '-' }}</td>
                  <td>{{ $r['color'] ?? '-' }}</td>
                  <td>{{ $r['profile'] ?? '-' }}</td>
                  <td>{{ $r['fabrication'] ?? '-' }}</td>
                  <td>{{ $r['cut_lenght'] ?? $r['cut_length'] ?? '-' }}</td>
                  <td>{{ $r['frame_bin'] ?? '-' }}</td>
                  <td>{{ $r['po'] ?? '-' }}</td>
                </tr>
              @empty
                <tr><td colspan="9" class="text-center text-muted">{{ __('No sash rows.') }}</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div></div>
    </div>

    {{-- Grids --}}
    <div class="tab-pane fade" id="jp-pane-grids" role="tabpanel">
      <div class="card"><div class="card-body px-3 px-md-4">
        <div class="table-responsive">
          <table class="table table-hover table-sm mb-0">
            <thead class="table-light">
              <tr>
                <th>{{ __('PO') }}</th>
                <th>{{ __('color') }}</th>
                <th>{{ __('window') }}</th>
                <th>{{ __('Unit') }}</th>
                <th>{{ __('grid') }}</th>
                <th>{{ __('pattern') }}</th>
                <th>{{ __('width') }}</th>
                <th>{{ __('height') }}</th>
                <th>{{ __('slot') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($gridRows as $r)
                <tr>
                  <td>{{ $r['po'] ?? '-' }}</td>
                  <td>{{ $r['color'] ?? '-' }}</td>
                  <td>{{ $r['window'] ?? '-' }}</td>
                  <td>{{ $r['unit'] ?? '-' }}</td>
                  <td>{{ $r['grid'] ?? '-' }}</td>
                  <td>{{ $r['pattern'] ?? '-' }}</td>
                  <td>{{ $r['width'] ?? '-' }}</td>
                  <td>{{ $r['height'] ?? '-' }}</td>
                  <td>{{ $r['slot'] ?? '-' }}</td>
                </tr>
              @empty
                <tr><td colspan="9" class="text-center text-muted">{{ __('No grid rows.') }}</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div></div>
    </div>

    {{-- Barcodes --}}
    <div class="tab-pane fade" id="jp-pane-barc" role="tabpanel">
      <div class="card"><div class="card-body px-3 px-md-4">
        <div class="alert alert-secondary mb-0">{{ __('Barcode preview / controls go here.') }}</div>
      </div></div>
    </div>

  </div>
</div>
