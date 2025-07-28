@extends('layouts.app')

@section('page-title', 'Formulas')

@section('content')
<div class="card mt-4">
    <div class="card-body">
        <h5 class="mb-4">Tier Formula Settings</h5>

        @php
            $rows = [
                'master_data' => 'Master Data Percentage',
                'tier_1' => 'Tier 1 %',
                'tier_2' => 'Tier 2 %',
                'tier_3' => 'Tier 3 %',
                'vip' => 'VIP %'
            ];
        @endphp

        <form method="POST" action="{{ route('executives.formulas.update') }}">
            @csrf

            @foreach ($rows as $key => $label)
            <div class="row align-items-center mb-3">
                <div class="col-md-4">
                    <label class="form-label mb-0">{{ $label }}</label>
                </div>

                <div class="col-md-4 d-flex align-items-center gap-2">
                    <input type="number" name="formulas[{{ $key }}]" 
                           class="form-control formula-input" 
                           id="input-{{ $key }}" 
                           step="0.01" 
                           value="{{ $formulas[$key] ?? '' }}" 
                           placeholder="Enter %">

                    <button type="submit" class="btn btn-primary" title="Save">
                        <i class="ti ti-check"></i>
                    </button>

                    <button type="button" class="btn btn-primary lock-btn" 
                            data-target="input-{{ $key }}" title="Lock/Unlock">
                        <i class="ti ti-lock"></i>
                    </button>
                </div>
            </div>
            @endforeach

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.lock-btn').forEach(button => {
    button.addEventListener('click', function () {
        const inputId = this.dataset.target;
        const input = document.getElementById(inputId);

        if (input.hasAttribute('readonly')) {
            input.removeAttribute('readonly');
            this.innerHTML = '<i class="ti ti-lock"></i>';
        } else {
            input.setAttribute('readonly', true);
            this.innerHTML = '<i class="ti ti-lock-open"></i>';
        }
    });
});
</script>
@endpush
