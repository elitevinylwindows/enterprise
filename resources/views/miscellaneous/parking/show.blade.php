<div class="modal-body">
  <div class="row g-3">
    {{-- LEFT: Avatar --}}
    <div class="col-md-4 text-center d-flex align-items-start justify-content-center">
      @php
        use Illuminate\Support\Facades\Storage;

        $u = $assignment->user;
        $profileUrl = $u->profile ?? null;
       
      @endphp

      @if($profileUrl)
        <img src="{{ $profileUrl }}" alt="avatar"
             class="img-fluid rounded-circle border"
             style="max-width:160px; max-height:160px; width:160px; height:160px; object-fit:cover;">
      @else
        <div id="parking-avatar-fallback"></div>
      @endif
    </div>

    {{-- RIGHT: Info --}}
    <div class="col-md-8">
      <h5 class="fw-bold mb-3">{{ $u->name ?? __('Unassigned') }}</h5>
      <dl class="row mb-0">
        <dt class="col-sm-4">{{ __('Department') }}</dt>
        <dd class="col-sm-8">{{ $u && method_exists($u,'getRoleNames') ? ($u->getRoleNames()->first() ?? '—') : '—' }}</dd>

        <dt class="col-sm-4">{{ __('Email') }}</dt>
        <dd class="col-sm-8">{{ $u->email ?? '—' }}</dd>

        <dt class="col-sm-4">{{ __('Phone') }}</dt>
        <dd class="col-sm-8">{{ $u->phone_number ?? '—' }}</dd>

        <dt class="col-sm-4">{{ __('Spot #') }}</dt>
        <dd class="col-sm-8">{{ $assignment->spot }}</dd>

        <dt class="col-sm-4">{{ __('Wheelchair') }}</dt>
        <dd class="col-sm-8">
          @if($assignment->wheelchair)
            <i class="fa-solid fa-wheelchair" style="color:#0d6efd;"></i> {{ __('Accessible') }}
          @else
            {{ __('No') }}
          @endif
        </dd>

        @if(!empty($assignment->notes))
          <dt class="col-sm-4">{{ __('Notes') }}</dt>
          <dd class="col-sm-8">{{ $assignment->notes }}</dd>
        @endif
      </dl>
    </div>
  </div>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
</div>

<style>
#parking-avatar-fallback{
  width:160px;height:160px;border-radius:50%;background:#9b0000;
}
</style>
