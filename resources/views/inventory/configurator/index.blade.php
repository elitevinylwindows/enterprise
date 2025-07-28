@extends('layouts.app')
@php $selectedColor = $selectedColor ?? request('color', 'White'); @endphp


@section('page-title', 'Product Configurator')

@section('content')
<form method="GET" action="{{ route('inventory.configurator.index') }}">

    
{{--Window Configurator & Subtotal  --}}    
<div class="container py-4">
    <div class="row">
        {{-- Left Config Card --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Window Configuration</h5>
                </div>
                <div class="card-body">
                    <form id="dimensionForm">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Series / Unit</th>
                                    <th>Width</th>
                                    <th>Height</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><select name="series" class="form-select" id="seriesSelector" onchange="window.location.href='?series=' + this.value + '&color={{ $selectedColor }}'">
    @foreach ($seriesList as $series)
        <option value="{{ $series->slug }}" {{ $selectedSeries === $series->slug ? 'selected' : '' }}>
            {{ $series->name }}
        </option>
    @endforeach
</select>
</td>
                                    <td>
                                        <input type="number" step="0.001" name="width" id="widthInput" class="form-control" value="48">
                                    </td>
                                    <td>
                                        <input type="number" step="0.001" name="height" id="heightInput" class="form-control" value="48">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Glass Fix</td>
                                    <td><input type="text" id="glassFixWidth" class="form-control" readonly></td>
                                    <td><input type="text" id="glassFixHeight" class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td>Glass Sash</td>
                                    <td><input type="text" id="glassSashWidth" class="form-control" readonly></td>
                                    <td><input type="text" id="glassSashHeight" class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td>Screen</td>
                                    <td><input type="text" id="screenWidth" class="form-control" readonly></td>
                                    <td><input type="text" id="screenHeight" class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td>Color</td>
                                    <td colspan="2">
                                       <form method="GET" action="{{ route('inventory.configurator.index') }}">
    <select name="color" class="form-select" onchange="this.form.submit()">
        @foreach (['White', 'Black', 'Almond'] as $clr)
            <option value="{{ $clr }}" {{ $selectedColor === $clr ? 'selected' : '' }}>{{ $clr }}</option>
        @endforeach
    </select>
</form>


</form>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right Subtotal Card --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Summary</h5>
                </div>
                <div class="card-body">
                    <h6>Subtotal</h6>
                    <h3 class="text-success" id="subtotalDisplay">$0.00</h3>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ============================= --}}
{{-- Second Card: FORM COMPONENT --}}
{{-- ============================= --}}
<div class="col-12 mt-4">
  <div class="card">
    <div class="card-header bg-primary text-white">
      <h5 class="card-title">SASH</h5>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
          <tr>
            <th>Item</th>
            <th>Dropdown</th>
            <th>Submenu</th>
            <th>Need</th>
            <th>Measure</th>
            <th>Cost ($)</th>
            <th>Total ($)</th>
          </tr>
        </thead>
        <tbody>
@php
 $allItems = [
  ['label' => 'Frame Type', 'field' => 'frame_type', 'measure' => 'L In', 'hasSubmenu' => false, 'condition_group' => 'Frame Type'],
    ['label' => 'Trim', 'field' => 'trim', 'measure' => 'L In', 'hasSubmenu' => false, 'condition_group' => 'Trim'],
    ['label' => 'Stop', 'field' => 'stop', 'measure' => '-', 'hasSubmenu' => false, 'condition_group' => 'Stop'],
    ['label' => 'Track', 'field' => 'track', 'measure' => 'L In', 'hasSubmenu' => false, 'condition_group' => 'Track'],
    ['label' => 'Water Flow', 'field' => 'water_flow', 'measure' => 'L In', 'hasSubmenu' => false, 'condition_group' => 'Water Flow'],
    ['label' => 'Night Lock', 'field' => 'night_lock', 'measure' => 'Qty', 'hasSubmenu' => false, 'condition_group' => 'Night Lock'],
    ['label' => 'Anti-Theft', 'field' => 'anti_theft', 'measure' => 'Qty', 'hasSubmenu' => false, 'condition_group' => 'Anti-Theft'],
    ['label' => 'AMMA Label', 'field' => 'amma_label', 'measure' => 'Qty', 'hasSubmenu' => false, 'condition_group' => 'AMMA Label'], 
['label' => 'SASH', 'field' => 'sash', 'measure' => 'L In', 'need' => 0],
              ['label' => 'Interlock', 'field' => 'interlock', 'measure' => 'L In', 'need' => 0],
              ['label' => 'Interlock Reinf.', 'field' => 'interlock_reinf', 'measure' => 'Qty', 'need' => 0],
              ['label' => 'Rollers', 'field' => 'rollers', 'measure' => 'Qty', 'need' => 0],
              ['label' => 'Lock Mech', 'field' => 'lock_mech', 'measure' => 'Qty', 'need' => 0],
              ['label' => 'Mech Screws', 'field' => 'mech_screws', 'measure' => 'Qty', 'need' => 0],
              ['label' => 'Lock Cover', 'field' => 'lock_cover', 'measure' => 'Qty', 'need' => 0],
              ['label' => 'GLASS Sash OUT', 'field' => 'glass_sash_out', 'measure' => 'sq. ft.', 'need' => 0],
              ['label' => 'GLASS Sash IN', 'field' => 'glass_sash_in', 'measure' => 'sq. ft.', 'need' => 0],
              ['label' => 'Spacer', 'field' => 'spacer', 'measure' => 'L In', 'need' => 0],
              ['label' => 'Double Tape', 'field' => 'double_tape', 'measure' => '—', 'need' => 0],
              ['label' => 'Snapping', 'field' => 'snapping', 'measure' => '—', 'need' => 0],
              ['label' => 'Setting Block', 'field' => 'setting_block', 'measure' => 'Qty', 'need' => 2],
              ['label' => 'Grids', 'field' => 'grids', 'measure' => 'L In', 'need' => 0],
              ['label' => 'Visible Union', 'field' => 'visible_union', 'measure' => '—', 'need' => 0],
               ['label' => 'Mull', 'field' => 'mull', 'measure' => 'L In'],
              ['label' => 'Strike', 'field' => 'strike', 'measure' => 'Qty'],
              ['label' => 'Strike Screw', 'field' => 'strike_screw', 'measure' => 'Qty'],
              ['label' => 'Mull Cap', 'field' => 'mull_cap', 'measure' => 'Qty'],
              ['label' => 'Mull Screws', 'field' => 'mull_screws', 'measure' => 'Qty'],
              ['label' => 'Reinf. Material', 'field' => 'reinf_material', 'measure' => '-'],
              ['label' => 'Steel Reinf.', 'field' => 'steel_reinf', 'measure' => 'Qty'],
              ['label' => 'Aluminum Reinf.', 'field' => 'aluminum_reinf', 'measure' => '-'],
               ['label' => 'Screen Frame', 'field' => 'screen_frame', 'measure' => 'L In'],
              ['label' => 'Pullers', 'field' => 'pullers', 'measure' => 'Qty'],
              ['label' => 'Tension Springs', 'field' => 'tension_springs', 'measure' => 'Pcs'],
              ['label' => 'Corners', 'field' => 'corners', 'measure' => 'Qty'],
              ['label' => 'Mesh', 'field' => 'mesh', 'measure' => 'sq. ft.'],
              ['label' => 'Spline', 'field' => 'spline', 'measure' => 'L In'],
              ['label' => 'Warning Label', 'field' => 'warning_label', 'measure' => 'Qty'],
              
];
@endphp

    @foreach ($allItems as $item)
          <tr>
            {{-- Item Label --}}
            <td><strong>{{ $item['label'] }}</strong></td>

            {{-- Dropdown --}}
            <td>
              <select name="bom[{{ $item['field'] }}]" class="form-select">
                <option value="">Select {{ $item['label'] }}</option>
              @if (!empty($item['condition_group']))
    @foreach ($groupedOptions[$item['condition_group']] ?? [] as $opt)
        <option value="{{ $opt->id }}">{{ $opt->option_name }}</option>
    @endforeach
@endif
              </select>
            </td>


            {{-- Submenu --}}
            <td>
              @if (!empty($item['hasSubmenu']))
                @includeIf('components.submenu-dropdown', ['type' => $item['condition_group']])
              @else
                <span>-</span>
              @endif
            </td>



            {{-- Need --}}
<td><span class="need-{{ $item['field'] }}">0.00</span></td>

            {{-- Measure --}}
            <td>{{ $item['measure'] }}</td>

            {{-- Cost & Total --}}
            <td><span class="cost-{{ $item['field'] }}">0.00</span></td>
            <td><span class="total-{{ $item['field'] }}">0.00</span></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
</div>
</div>













    <button class="btn btn-primary">Submit</button>
</form>
@endsection

@push('scripts')
<script>
    const allOptions = @json($groups->mapWithKeys(function($group) {
        return [$group->id => $group->options->where('level', 2)->groupBy('value')];
    }));

    document.querySelectorAll('.main-option').forEach(select => {
        select.addEventListener('change', function () {
            const groupId = this.dataset.group;
            const selectedValue = this.value;
            const subContainer = document.getElementById('sub-options-' + groupId);
            subContainer.innerHTML = '';

            const groupSubOptions = allOptions[groupId] ?? {};

            if (groupSubOptions[selectedValue]) {
                const subSelect = document.createElement('select');
                subSelect.classList.add('form-control', 'mt-2');
                subSelect.name = `sub_option_${groupId}`;

                subSelect.innerHTML = `<option value="">-- Sub Option --</option>`;
                groupSubOptions[selectedValue].forEach(option => {
                    subSelect.innerHTML += `<option value="${option.value}">${option.label}</option>`;
                });

                subContainer.appendChild(subSelect);
            }
        });
    });
</script>
<script>
function calculateValues() {
    const width = parseFloat(document.getElementById('widthInput').value) || 0;
    const height = parseFloat(document.getElementById('heightInput').value) || 0;

    document.getElementById('glassFixWidth').value = (width / 2 - 1.75).toFixed(3);
    document.getElementById('glassFixHeight').value = (height - 2.125).toFixed(3);

    document.getElementById('glassSashWidth').value = (width / 2 - 3.125).toFixed(3);
    document.getElementById('glassSashHeight').value = (height - 4.625).toFixed(3);

    document.getElementById('screenWidth').value = (width / 2 - 3).toFixed(3);
    document.getElementById('screenHeight').value = (height - 3.375).toFixed(3);

    // Placeholder subtotal logic (you'll replace this later)
    document.getElementById('subtotalDisplay').innerText = '$0.00';
}

document.getElementById('widthInput').addEventListener('input', calculateValues);
document.getElementById('heightInput').addEventListener('input', calculateValues);

// Initial run
calculateValues();
</script>
@endpush