@extends('layouts.app')

@section('page-title')
{{ __('Quote Details') }}
@endsection

@push('css-page')
<style>
    #window-previewer {
        width: 500px;
        height: 500px;
        border: 1px solid #ccc;
        margin: 20px auto;
        position: relative;
    }

</style>
@endpush

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('sales.quotes.index') }}">Quotes</a></li>
<li class="breadcrumb-item active">Quote Details</li>
@endsection

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-dark">Quote Details</h5>
        </div>

        <!--    @include('sales.quotes.partials.quote-steps', ['activeStep' => 2])-->

        <div class="card-body">
            <!-- Quote Metadata -->
            <div class="row mb-3">
                <div class="col-md-2">
                    <label>Customer Number</label>
                    <input type="text" class="form-control" value="{{ $quote->customer_number }}" readonly>
                </div>
                <div class="col-md-2">
                    <label>Customer Name</label>
                    <input type="text" class="form-control" value="{{ $quote->customer_name }}" readonly>
                </div>
                <div class="col-md-2">
                    <label>Quote Number</label>
                    <input type="text" class="form-control" value="{{ $quote->quote_number }}" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Entered By</label>
                    <input type="text" class="form-control" value="{{ $quote->entered_by }}" readonly>
                </div>
                <div class="col-md-4">
                    <label>Entry Date</label>
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($quote->entry_date)->format('Y-m-d') }}" readonly>
                </div>
                <div class="col-md-4">
                    <label>Expected Delivery</label>
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($quote->expected_delivery)->format('Y-m-d') }}" readonly>
                </div>
            </div>

            <div class="row mb-3 align-items-end">
                {{-- Series --}}
                <div class="col-md-4">
                    <label for="seriesSelect">Series</label>
                    <select name="series_id" id="seriesSelect" class="form-control">
                        <option value="">Select Series</option>
                        @foreach ($seriesList as $id => $series)
                        <option value="{{ $id }}">{{ $series }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Configuration --}}
                <div class="col-md-6">
                    <label>Configuration</label>
                    <div class="d-flex gap-2">
                        <select name="series_type_id" id="seriesTypeSelect" class="form-control flex-grow-1" style="height: 44px;">
                            <option value="">Select a configuration</option>
                        </select>
                        <a href="#" class="btn btn-primary d-flex align-items-center justify-content-center" style="height: 44px;" data-bs-toggle="modal" data-bs-target="#configLookupModal">
                            <i class="fa-brands fa-searchengin"></i>
                        </a>
                    </div>
                </div>

                {{-- Add Item --}}
                <div class="col-md-2 text-end">
                    <a href="#" class="btn btn-primary w-100 d-flex align-items-center justify-content-center" style="height: 44px;" data-bs-toggle="modal" data-bs-target="#addItemModal">
                        <i class="fas fa-plus me-2"></i> Add Item
                    </a>
                </div>
            </div>




            <!-- Items Table -->
            <table id="quoteDetailsTable" class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Size</th>
                        <th>Glass</th>
                        <th>Grid</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($quoteItems as $item)
                    <tr data-id="{{ $item->id }}">
                        <td style="text-wrap:auto">{{ $item->description }}</td>
                        <td><input type="number" name="qty[]" value="{{ $item->qty }}" class="form-control form-control-sm qty-input" style="width: 60px;" data-id="{{ $item->id }}" data-price="{{ $item->price }}"></td>
                        <td>{{ $item->width }}" x {{ $item->height }}"</td>
                        <td>{{ $item->glass }}</td>
                        <td>{{ $item->grid }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td class="item-total" data-id="{{ $item->id }}">${{ number_format($item->total, 2) }}</td>
                        <td><img src="{{ $item->image_url ?? 'https://via.placeholder.com/40' }}" class="img-thumbnail" alt="Item"></td>
                        <td class="text-nowrap">
                            <a href="javascript:void(0);" class="avtar avtar-xs btn-link-success text-success view-quote-item" data-id="{{ $item->id }}">
                                <i data-feather="eye"></i>
                            </a>
                            <a href="javascript:void(0);" class="avtar avtar-xs btn-link-primary text-primary edit-quote-item" data-id="{{ $item->id }}">
                                <i data-feather="edit"></i>
                            </a>
                            <a href="javascript:void(0);" class="avtar avtar-xs btn-link-danger text-danger remove-row" data-id="{{ $item->id }}">
                                <i data-feather="trash-2"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>


            </table>
            <!-- Totals -->
            <div class="row mt-4">
                <div class="col-md-6 offset-md-6">
                    <table class="table"  id="totalsTable">
                        <tr>
                            <th>Discount:</th>
                            <input type="hidden" name="discount" id="discount" value="{{ number_format($quote->discount, 2) }}">
                            <td id="discount-amount">${{ number_format($quote->discount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td>
                                <input type="number" step="0.01" class="form-control w-25" name="shipping" id="shipping" value="{{ number_format($quote->shipping, 2) }}">
                            </td>
                        </tr>
                        <tr>
                            <th>Subtotal:</th>
                            <input type="hidden" name="subtotal" id="subtotal" value="{{ number_format($quote->sub_total, 2) }}">
                            <td id="subtotal-amount">${{ number_format($quote->sub_total, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Tax:</th>
                            <input type="hidden" name="tax" id="tax" value="{{ $quote->tax }}">
                            <td id="tax-amount">${{ number_format($quote->tax, 2) }} ({{ number_format($taxRate, 2) }}%)</td>
                        </tr>

                        <tr>
                            <th>Total:</th>
                            <input type="hidden" name="total" id="total" value="{{ number_format($quote->total, 2) }}">
                            <td><strong id="total-amount">${{ number_format($quote->total, 2) }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="row mt-3 text-muted small">
                <div class="col-md-4"><strong>Entered By:</strong> {{ $quote->entered_by }}</div>
                <div class="col-md-4"><strong>Date:</strong> {{ \Carbon\Carbon::parse($quote->entry_date)->format('m/d/Y') }}</div>
                <div class="col-md-4"><strong>Expires:</strong> {{ \Carbon\Carbon::parse($quote->valid_until)->format('m/d/Y') }}</div>
            </div>


            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('sales.quotes.previous', $quote->id) }}" class="btn btn-secondary">&larr; Previous</a>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary" id="saveDraftButton">Save Draft</button>

                    <a class="btn btn-secondary customModal text-white"
                        data-size="xl"
                        data-url="{{ route('sales.quotes.preview', $quote->id) }}"
                        data-title="Quote Preview">
                       Continue &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="quoteItemForm" method="POST" action="{{ route('sales.quotes.storeItem', $quote->id) }}">
                @csrf
                <input type="hidden" name="quote_id" id="quoteId" value="{{ $quote->id }}">
                <input type="hidden" name="item_id" id="itemId">

                <!-- Hidden fields for JS-generated display values -->
                <input type="hidden" name="description" id="description">
                <input type="hidden" name="glass" id="glass">
                <input type="hidden" name="grid" id="grid">
                <input type="hidden" name="size" id="size">
                <input type="hidden" name="price" id="price">
                <input type="hidden" name="total" id="total">


                <div class="modal-header bg-white text-dark">
                    <h5 class="mb-0" id="modalTitle">Add Quote Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-3" id="quoteItemTabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#item">Item</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#color">Color</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#general">General</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#glasss">Glass</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#grids">Grids</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#other">Other</a></li>
                    </ul>
                    <div class="row">
                        <!-- Left Form -->
                        <div class="col-md-6">
                            <div class="tab-content">

                                <div class="tab-pane fade show active" id="item">
                                    <div class="mb-3">
                                        <label>Qty</label>
                                        <input type="number" name="qty" class="form-control" value="1">
                                    </div>

                                    <div class="mb-3">
                                        <label>Width</label>
                                        <div class="input-group">
                                            <input type="text" name="width" class="form-control" value="60">
                                            <span class="input-group-text">inches</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label>Height</label>
                                        <div class="input-group">
                                            <input type="text" name="height" class="form-control" value="48">
                                            <span class="input-group-text">inches</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label>Line Item Comment</label>
                                        <textarea name="item_comment" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="color">
                                    <div class="mb-3">
                                        <label>Color Configuration</label>
                                        <select class="form-control" name="color_config" id="colorConfigDropdown" required
                                            <option value="">Select Configuration</option>
                                            @foreach($colorConfigurations as $config)
                                            <option value="{{ $config->code }}" data-id="{{ $config->id }}">{{ $config->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Color Code (Exterior)</label>
                                        <select class="form-control" name="color_exterior" id="colorExteriorDropdown" required>
                                            <option value="">Select Exterior Color</option>
                                            @foreach($exteriorColors as $color)
                                            <option value="{{ $color->code }}" data-id="{{ $color->id }}" data-group="regular">{{ $color->name }}</option>
                                            @endforeach
                                            @foreach($laminateColors as $color)
                                            <option value="{{ $color->code }}" data-id="{{ $color->id }}" data-group="laminate">{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Color Code (Interior)</label>
                                        <select class="form-control" name="color_interior" id="colorInteriorDropdown" required>
                                            <option value="">Select Interior Color</option>
                                            @foreach($interiorColors as $color)
                                            <option value="{{ $color->code }}" data-id="{{ $color->id }}" data-group="regular">{{ $color->name }}</option>
                                            @endforeach
                                            @foreach($laminateColors as $color)
                                            <option value="{{ $color->code }}" data-id="{{ $color->id }}" data-group="laminate">{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="general">
                                    <div class="mb-3">
                                        <label>Frame Type</label>
                                        <select class="form-control" name="frame_type" id="frame_type">
                                            <option value="Retrofit">Retrofit</option>
                                            <option value="Nailon">Nailon</option>
                                            <option value="Block">Block</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Retrofit Fin Type</label>
                                        <select class="form-control" name="fin_type" required id="fin_type">
                                            <option value="Regular">Regular</option>
                                            <option value="Longfin">Longfin</option>
                                        </select>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="knocked_down" id="knocked_down">
                                        <label class="form-check-label" for="knocked_down">
                                            Knocked Down
                                        </label>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="glasss">
                                    <div class="mb-3">
                                        <label>Glass Type</label>
                                        <select class="form-control" name="glass_type">
                                            <option value="CLR/CLR">CLR/CLR</option>
                                            <option value="LE3/CLR">LE3/CLR</option>
                                            <option value="LE3/LAM">LE3/LAM</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Spacer</label>
                                        <select class="form-control" name="spacer">
                                            <option value="Duralite">Duralite</option>
                                            <option value="Superspacer">Superspacer</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Tempered Glass Option</label>
                                        <select class="form-control" name="tempered">
                                            <option value="All">All</option>
                                            <option value="Select">Select</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Specialty Glass</label>
                                        <select class="form-control" name="specialty_glass">
                                            <option value="Acid Etch">Acid Etch</option>
                                            <option value="Bamboo">Bamboo</option>
                                            <option value="Bronze">Bronze</option>
                                            <option value="Delta Frost">Delta Frost</option>
                                            <option value="Flemish">Flemish</option>
                                            <option value="Glue Chip">Glue Chip</option>
                                            <option value="Grey">Grey</option>
                                            <option value="Matte">Matte</option>
                                            <option value="Obscure">Obscure</option>
                                            <option value="Rain">Rain</option>
                                            <option value="Reed">Reed</option>
                                            <option value="Sand Blast">Sand Blast</option>
                                            <option value="Solar Cool">Solar Cool</option>
                                            <option value="Solar Cool G">Solar Cool G</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="grids">
                                    <!-- <div class="mb-3">
                                        <label>Grid Type</label>
                                        <select class="form-control" name="grid_type">
                                            <option value="None">None</option>
                                        <option value="GR">Non Glass Diving Grilles</option>
                                        <option value="CAD">Grille Macro</option>
                                        <option value="INS">DXF/Inser Macro</option>
                                        </select>
                                    </div>-->
                                    <div class="mb-3">
                                        <label>Grid Pattern</label>
                                        <select class="form-control" name="grid_pattern">
                                            <option value="Colonial">Colonial</option>
                                            <option value="Marginal-12">Marginal-12</option>
                                            <option value="Marginal-18">Marginal-18</option>
                                            <option value="Queen">Queen</option>

                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Grid Profile</label>
                                        <select class="form-control" name="grid_profile">
                                            <option value="F-3/4">F-3/4</option>
                                            <option value="F-5/8">F-5/8</option>
                                            <option value="S-1">S-1</option>
                                            <option value="S-5/8">S-5/8</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="other">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="retrofit_bottom_only" id="retrofit_bottom_only">
                                        <label class="form-check-label" for="retrofit_bottom_only">Retrofit Bottom Only</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="no_logo_lock" id="no_logo_lock">
                                        <label class="form-check-label" for="no_logo_lock">No Logo Lock</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="double_lock" id="double_lock">
                                        <label class="form-check-label" for="double_lock">2 Locks (Each Sash)</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="custom_lock_position" id="custom_lock_position">
                                        <label class="form-check-label" for="custom_lock_position">Lock Position Not Standard</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="custom_vent_latch" id="custom_vent_latch">
                                        <label class="form-check-label" for="custom_vent_latch">Vent Latch Position Not Standard</label>
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label>Internal Notes</label>
                                        <textarea name="internal_note" class="form-control" rows="3" placeholder="Enter internal notes..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Right Preview + Tabs -->
                        <div class="col-md-6">
                            <ul class="nav nav-pills justify-content-end mb-3" id="previewTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="pill" href="#preview-panel">Preview</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="pill" href="#options-panel">Options</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="pill" href="#pricing-panel">
                                        Pricing - $<span id="totalPrice">0.00</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-pane fade show active" id="preview-panel">
                                <div class="tab-pane fade show active" id="preview-panel">

                                    <!-- SVG Preview Box -->
                                    <div id="window-svg-preview" class="border rounded bg-light p-4 mb-3 text-center" style="height: 300px; position: relative;">
                                    </div>

                                    <!-- View Mode Buttons -->
                                    <div class="btn-group mb-3 w-100" role="group">
                                        <a href="javascript:void(0);" class="btn btn-secondary active">Inside</a>
                                        <a href="javascript:void(0);" class="btn btn-light text-light">Outside</a>
                                        <a href="javascript:void(0);" class="btn btn-light text-light">Both</a>
                                    </div>


                                    <!-- Ratings -->
                                    <div class="alert alert-light border text-muted small text-center">
                                        <strong>NFRC Ratings</strong> â€” SHG: 0.34 UF: 0.22 VT: 0.47
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="options-panel">
                                <p class="text-muted">Option settings will go here.</p>
                            </div>

                            <div class="tab-pane fade" id="pricing-panel">
                                <h5 class="text-center">$0.00</h5>
                                <p class="text-muted text-center">Detailed pricing breakdown can be shown here.</p>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between align-items-center">
                            <h2 class="mb-0">Total Price: $<span id="globalTotalPrice">0.00</span></h2>
                            <div>
                                <a href="javascript:void(0);" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                                <button type="button" id="saveQuoteItem" class="btn btn-primary">Add to Quote</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="configLookupModal" tabindex="-1" aria-labelledby="configLookupLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="configLookupLabel">Select Configuration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="accordion" id="categoryAccordion">
                    {{-- Categories with configs will be dynamically inserted here --}}
                </div>

                <div class="text-end mt-3">
                    <a href="#" id="confirmConfigSelection" class="btn btn-primary">Select Configuration</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quote PDF Preview Modal -->
    <div class="modal fade" id="quotePreviewModal" tabindex="-1" aria-labelledby="quotePreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quote Preview</h5>
                    <a href="{{ route('sales.quotes.download', $quote->id) }}" target="_blank" class="btn btn-outline-primary btn-sm">Download PDF</a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="min-height: 80vh;">


                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-success">Send Quote</button>
                    <button type="button" class="btn btn-primary">Save Quote</button>
                </div>
            </div>
        </div>
    </div>

@endsection



@push('scripts')
<script>
    // Load configurations based on series
    document.getElementById('seriesSelect').addEventListener('change', function() {
        const seriesId = this.value;
        const configSelect = document.getElementById('seriesTypeSelect');
        configSelect.innerHTML = '<option value="">Loading...</option>';

        if (!seriesId) {
            configSelect.innerHTML = '<option value="">Select a configuration</option>';
            return;
        }

        fetch(`/sales/series-types/${seriesId}`)
            .then(response => response.json())
            .then(data => {
                configSelect.innerHTML = '<option value="">Select a configuration</option>';
                data.forEach(type => {
                    const cleanType = type.trim().replace(/^"(.*)"$/, '$1');
                    configSelect.innerHTML += `<option value="${cleanType}">${cleanType}</option>`;
                });
            })
            .catch((err) => {
                console.error('Fetch error:', err);
                configSelect.innerHTML = '<option value="">Failed to load</option>';
            });
    });


    // Add item to quote table
    document.getElementById('saveQuoteItem').addEventListener('click', function() {
        const form = document.getElementById('quoteItemForm');
        const qty = form.querySelector('[name="qty"]').value;
        const width = form.querySelector('[name="width"]').value;
        const height = form.querySelector('[name="height"]').value;
        const series = document.getElementById('seriesSelect').selectedOptions[0] ?.text ?? '';
        const series_id = document.getElementById('seriesSelect').value ?? '';
        const config = document.getElementById('seriesTypeSelect').value;

        const glassType = form.querySelector('[name="glass_type"]').value;
        const spacer = form.querySelector('[name="spacer"]').value;
        const tempered = form.querySelector('[name="tempered"]').value;
        const specialtyGLass = form.querySelector('[name="specialty_glass"]').value;

        const gridPattern = form.querySelector('[name="grid_pattern"]').value;
        const gridProfile = form.querySelector('[name="grid_profile"]').value;

        const frameType = form.querySelector('[name="frame_type"]').value;
        const finType = form.querySelector('[name="fin_type"]').value;

        const colorConfigDropdown = form.querySelector('[name="color_config"]');
        const colorConfig = colorConfigDropdown.value;
        const colorConfigId = colorConfigDropdown.selectedOptions[0]?.value ?? '';
        const colorExt = form.querySelector('[name="color_exterior"]');
        const colorInt = form.querySelector('[name="color_interior"]');
        const colorIntId = colorInt.selectedOptions[0]?.value ?? '';
        const item_id = form.querySelector('[name="item_id"]').value;
        const laminateExtText = colorExt ?.selectedOptions[0] ?.text ?? '';
        const colorIntText = colorInt ?.selectedOptions[0] ?.text ?? '';

        let colorDisplay = '';
        if (colorConfig.includes('LAM')) {
            colorDisplay = `LAM (${laminateExtText}) - ${colorIntText}`;
        } else {
            colorDisplay = `${colorConfig}`;
        }

       // validate colorConfigDropdown
       if (!colorConfigId) {
           alert('Please select a Color Configuration.');
           return;
       }
        // validate colorExt and colorInt
        if (!colorExtId || !colorIntId) {
            alert('Please select both Exterior and Interior colors.');
            return;
        }

        if(!item_id) {
            if (!series || !config || !width || !height) {
                alert('Please select Series, Configuration, Width, and Height.');
                return;
            }
        }

        const itemDesc = `${series}-${config} / ${colorDisplay} / ${frameType}-${finType}`;
        document.getElementById('description').value = itemDesc;

        const glass = `${glassType}-${spacer} / ${tempered} / ${specialtyGLass}`;
        const grid = `${gridPattern} / ${gridProfile}`;
        const size = `${width}" x ${height}"`;
        const price = form.querySelector('[name="price"]').value;
        const discount = $("#discount").val() || 0;
        const taxRate = {{ $taxRate }};
        const total = (qty * parseFloat(price)).toFixed(2);
        const tax = (taxRate *(total / 100)).toFixed(2);
        const item_comment = form.querySelector('[name="item_comment"]').value;
        const internal_note = form.querySelector('[name="internal_note"]').value;

        const formData = new FormData();
        formData.append('item_id', item_id);
        formData.append('series_id', series_id);
        formData.append('series_type', config);
        formData.append('description', itemDesc);
        formData.append('width', width);
        formData.append('height', height);
        formData.append('glass', glass);
        formData.append('grid', grid);
        formData.append('qty', qty);
        formData.append('tax', tax);
        formData.append('price', price);
        formData.append('discount', discount);
        formData.append('total', total);
        formData.append('item_comment', item_comment);
        formData.append('internal_note', internal_note);
        formData.append('color_config', colorConfigId);
        formData.append('color_exterior', colorExtId);
        formData.append('color_interior', colorIntId);
        formData.append('frame_type', frameType);
        formData.append('fin_type', finType);
        formData.append('glass_type', glassType);
        formData.append('spacer', spacer);
        formData.append('tempered', tempered);
        formData.append('specialty_glass', specialtyGLass);
        formData.append('grid_pattern', gridPattern);
        formData.append('grid_profile', gridProfile);
        formData.append('retrofit_bottom_only', form.querySelector('[name="retrofit_bottom_only"]').checked ? 1 : 0);
        formData.append('no_logo_lock', form.querySelector('[name="no_logo_lock"]').checked ? 1 : 0);
        formData.append('double_lock', form.querySelector('[name="double_lock"]').checked ? 1 : 0);
        formData.append('custom_lock_position', form.querySelector('[name="custom_lock_position"]').checked ? 1 : 0);
        formData.append('custom_vent_latch', form.querySelector('[name="custom_vent_latch"]').checked ? 1 : 0);
        formData.append('knocked_down', form.querySelector('[name="knocked_down"]').checked ? 1 : 0);


        const quoteId = document.getElementById('quoteId').value;

        fetch(`/sales/quotes/${quoteId}/items`, {
                method: 'POST'
                , headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    // Do NOT set Content-Type — browser sets it to multipart/form-data
                }
                , body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const currentModal = document.getElementById('addItemModal');
                        // close modal if open
                    const currentModalInstance = bootstrap.Modal.getInstance(currentModal) ?? new bootstrap.Modal(currentModal);
                    if (currentModalInstance) {
                        currentModalInstance.hide();
                    }

                    const row = `
                        <tr data-id="${data.item_id}">
                            <td style="text-wrap:auto">${itemDesc}</td>
                            <td><input type="number" name="qty[]" value="${qty}" min="1" class="form-control form-control-sm qty-input" style="width: 60px;" data-price="${price}" data-id="${data.item_id}"></td>
                            <td>${size}</td>
                            <td>${glass}</td>
                            <td>${grid}</td>
                            <td>$${price}</td>
                            <td class="item-total" data-id="${data.item_id}">$${total}</td>
                            <td><img src="https://via.placeholder.com/40" class="img-thumbnail" alt="Item"></td>
                            <td class="text-nowrap">
                                <a href="javascript:void(0);" class="avtar avtar-xs btn-link-success text-success view-quote-item" data-id="${data.item_id}">
                                    <i data-feather="eye"></i>
                                </a>
                                <a href="javascript:void(0);" class="avtar avtar-xs btn-link-primary text-primary edit-quote-item" data-id="${data.item_id}">
                                    <i data-feather="edit"></i>
                                </a>
                                <a href="javascript:void(0);" class="avtar avtar-xs btn-link-danger text-danger remove-row" data-id="${data.item_id}">
                                    <i data-feather="trash-2"></i>
                                </a>
                            </td>
                        </tr>
                    `;

                    calculateTotals();

                    if(data.is_update == false) {
                        document.querySelector('#quoteDetailsTable tbody').insertAdjacentHTML('beforeend', row);
                    } else {
                        const existingRow = document.querySelector(`#quoteDetailsTable tbody tr[data-id="${data.item_id}"]`);
                        if (existingRow) {
                            existingRow.remove();
                        }

                        document.querySelector('#quoteDetailsTable tbody').insertAdjacentHTML('beforeend', row);
                    }
                    console.log('Modal closed');
                } else {
                    alert('Item failed to save.');
                }
            })


        // 3. Hide modal
        // const modalElement = document.getElementById('quoteItemModal');
        // const modal = bootstrap.Modal.getInstance(modalElement) ?? new bootstrap.Modal(modalElement);
        // if (modal) {
        //     modal.hide();
        // }
        // 4. Reset form + preview
        form.reset();



        document.getElementById('window-svg-preview').innerHTML = '<svg></svg>';
    });

    // Delete row
    document.querySelector('#quoteDetailsTable tbody').addEventListener('click', function(e) {

        if (e.target.closest('.remove-row')) {
            const row = e.target.closest('tr');
            const itemId = row.getAttribute('data-id');
            const quoteId = "{{ $quote->id }}";
            if (!itemId) return;

            if (!confirm('Are you sure you want to delete this item?')) return;
            fetch(`/sales/quotes/${quoteId}/items/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    row.remove();
                    calculateTotals();
                       // also reset seriesSelect field and seriesTypeSelect field to on delete the row
                    document.getElementById('seriesSelect').value = '';
                    document.getElementById('seriesTypeSelect').value = '';
                } else {
                    alert('Failed to delete item.');
                }
            })
            .catch(() => alert('Server error'));
        }

    });

    // open modal in view mode
    document.querySelector('#quoteDetailsTable tbody').addEventListener('click', function(e) {
        const viewBtn = e.target.closest('.view-quote-item');
        // Only run if the actual button was clicked (not bubbling from table row)
        if (viewBtn && viewBtn.classList.contains('view-quote-item')) {
            const itemId = viewBtn.getAttribute('data-id');
            if (!itemId) return; // Prevent API call if no itemId

            const quoteId = "{{ $quote->id }}";
            fetch(`/sales/quotes/view/${quoteId}/items/${itemId}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.success || !data.item) {
                        alert('Failed to load item.');
                        return;
                    }
                    const form = document.getElementById('quoteItemForm');
                    // Populate fields
                    form.querySelector('[name="qty"]').value = data.item.qty;
                    form.querySelector('[name="width"]').value = data.item.width;
                    form.querySelector('[name="height"]').value = data.item.height;
                    form.querySelector('[name="item_comment"]').value = data.item.item_comment || '';
                    form.querySelector('[name="color_config"]').value = data.item.color_config || '';
                    form.querySelector('[name="color_exterior"]').value = data.item.color_exterior || '';
                    form.querySelector('[name="color_interior"]').value = data.item.color_interior || '';
                    form.querySelector('[name="frame_type"]').value = data.item.frame_type || '';
                    form.querySelector('[name="fin_type"]').value = data.item.fin_type || '';
                    form.querySelector('[name="glass_type"]').value = data.item.glass_type || '';
                    form.querySelector('[name="spacer"]').value = data.item.spacer || '';
                    form.querySelector('[name="tempered"]').value = data.item.tempered || '';
                    form.querySelector('[name="specialty_glass"]').value = data.item.specialty_glass || '';
                    form.querySelector('[name="grid_pattern"]').value = data.item.grid_pattern || '';
                    form.querySelector('[name="grid_profile"]').value = data.item.grid_profile || '';
                    form.querySelector('[name="internal_note"]').value = data.item.internal_note || '';
                    form.querySelector('[name="retrofit_bottom_only"]').checked = !!data.item.retrofit_bottom_only;
                    form.querySelector('[name="no_logo_lock"]').checked = !!data.item.no_logo_lock;
                    form.querySelector('[name="double_lock"]').checked = !!data.item.double_lock;
                    form.querySelector('[name="custom_lock_position"]').checked = !!data.item.custom_lock_position;
                    form.querySelector('[name="custom_vent_latch"]').checked = !!data.item.custom_vent_latch;
                    form.querySelector('[name="knocked_down"]').checked = !!data.item.knocked_down;

                    form.querySelector('#globalTotalPrice').textContent = data.item.price || '';
                    // Disable all fields
                    Array.from(form.elements).forEach(el => {
                        // Do not disable the btn-close button
                        if (!(el.classList && el.classList.contains('btn-close'))) {
                            el.disabled = true;
                        }
                    });
                    // Hide add button
                    document.getElementById('saveQuoteItem').style.display = 'none';
                    // Show modal
                    document.getElementById('modalTitle').textContent = 'View Quote Item';
                    const modal = new bootstrap.Modal(document.getElementById('addItemModal'));
                    modal.show();
                })
                .catch(() => alert('Server error'));
        }
    });

    document.querySelector('#quoteDetailsTable tbody').addEventListener('click', function(e) {
        const editBtn = e.target.closest('.edit-quote-item');
        // Only run if the actual button was clicked (not bubbling from table row)
        if (editBtn && editBtn.classList.contains('edit-quote-item')) {
            const itemId = editBtn.getAttribute('data-id');
            if (!itemId) return; // Prevent API call if no itemId

            const quoteId = "{{ $quote->id }}";
            fetch(`/sales/quotes/view/${quoteId}/items/${itemId}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.success || !data.item) {
                        alert('Failed to load item.');
                        return;
                    }
                    const form = document.getElementById('quoteItemForm');
                    // Populate fields
                    form.querySelector('[name="item_id"]').value = data.item.id;
                    form.querySelector('[name="qty"]').value = data.item.qty;
                    form.querySelector('[name="width"]').value = data.item.width;
                    form.querySelector('[name="height"]').value = data.item.height;
                    form.querySelector('[name="item_comment"]').value = data.item.item_comment || '';
                    form.querySelector('[name="color_config"]').value = data.item.color_config || '';
                    form.querySelector('[name="frame_type"]').value = data.item.frame_type || '';
                    form.querySelector('[name="fin_type"]').value = data.item.fin_type || '';
                    form.querySelector('[name="glass_type"]').value = data.item.glass_type || '';
                    form.querySelector('[name="spacer"]').value = data.item.spacer || '';
                    form.querySelector('[name="tempered"]').value = data.item.tempered || '';
                    form.querySelector('[name="specialty_glass"]').value = data.item.specialty_glass || '';
                    form.querySelector('[name="grid_pattern"]').value = data.item.grid_pattern || '';
                    form.querySelector('[name="grid_profile"]').value = data.item.grid_profile || '';
                    form.querySelector('[name="internal_note"]').value = data.item.internal_note || '';
                    form.querySelector('[name="retrofit_bottom_only"]').checked = !!data.item.retrofit_bottom_only;
                    form.querySelector('[name="no_logo_lock"]').checked = !!data.item.no_logo_lock;
                    form.querySelector('[name="double_lock"]').checked = !!data.item.double_lock;
                    form.querySelector('[name="custom_lock_position"]').checked = !!data.item.custom_lock_position;
                    form.querySelector('[name="custom_vent_latch"]').checked = !!data.item.custom_vent_latch;
                    form.querySelector('[name="knocked_down"]').checked = !!data.item.knocked_down;
                    // Pre-select series_id (dropdown)
                    const seriesSelect = $('#seriesSelect');
                    seriesSelect.val(data.item.series_id ?? '');

                    // Trigger change to load dependent series_type_id options
                    document.getElementById('seriesSelect').dispatchEvent(new Event('change'));

                    setTimeout(() => {
                        form.querySelector('[name="color_exterior"]').value = data.item.color_exterior || '';
                        form.querySelector('[name="color_interior"]').value = data.item.color_interior || '';
                    }, 500);
                    // Wait for the fetch to complete and then set the value
                    setTimeout(() => {
                        const seriesTypeSelect = document.getElementById('seriesTypeSelect');
                        Array.from(seriesTypeSelect.options).forEach(opt => {
                            if (opt.value == (data.item.series_type ?? '')) {
                                seriesTypeSelect.value = opt.value;
                            }
                        });

                        document.getElementById('seriesTypeSelect').dispatchEvent(new Event('change'));

                    }, 1000);

                    form.querySelector('#globalTotalPrice').textContent = data.item.price || '';
                    // Show modal
                    document.getElementById('modalTitle').textContent = 'Edit Quote Item';
                    document.getElementById('saveQuoteItem').textContent = 'Update Quote Item';
                    const modal = new bootstrap.Modal(document.getElementById('addItemModal'));
                    modal.show();
                })
                .catch(() => alert('Server error'));
        }
    });

    // When modal closes, re-enable fields and show add button
    document.getElementById('addItemModal').addEventListener('hidden.bs.modal', function() {
        const form = document.getElementById('quoteItemForm');
        Array.from(form.elements).forEach(el => el.disabled = false);
        document.getElementById('saveQuoteItem').style.display = '';
        form.reset();
        document.getElementById('modalTitle').textContent = 'Add Quote Item';
        document.getElementById('globalTotalPrice').textContent = '0.00';
    });

    document.getElementById('addItemModal').addEventListener('shown.bs.modal', function() {
        const value = $('#colorConfigDropdown').val();
        const [exterior, interior] = value.split('-');
        const exteriorDropdown = document.getElementById('colorExteriorDropdown');
        const interiorDropdown = document.getElementById('colorInteriorDropdown');

        exteriorDropdown.value = '';
        interiorDropdown.value = '';

        filterColorOptions(exteriorDropdown, exterior === 'LAM' ? 'laminate' : 'regular');
        filterColorOptions(interiorDropdown, interior === 'LAM' ? 'laminate' : 'regular');

        if (exterior !== 'LAM') exteriorDropdown.value = exterior;
        if (interior !== 'LAM') interiorDropdown.value = interior;

        // Add readonly if config is WH-WH, WH-BK, BK-WH, BK-BK
        const readonlyConfigs = ['WH-WH', 'WH-BK', 'BK-WH', 'BK-BK', 'WH-LAM', 'BK-LAM', 'LAM-WH', 'LAM-BK'];
        // Reset both first
        exteriorDropdown.disabled = false;
        interiorDropdown.disabled = false;
        exteriorDropdown.classList.remove('readonly');
        interiorDropdown.classList.remove('readonly');

        if (readonlyConfigs.includes(value)) {
            // Special handling for LAM cases
            if (value.includes('LAM')) {
                if (value.startsWith('LAM')) {
                    // LAM-X → disable X (interior)
                    interiorDropdown.disabled = true;
                    interiorDropdown.classList.add('readonly');
                } else if (value.endsWith('LAM')) {
                    // X-LAM → disable X (exterior)
                    exteriorDropdown.disabled = true;
                    exteriorDropdown.classList.add('readonly');
                }
            } else {
                // Non-LAM case → disable both
                exteriorDropdown.disabled = true;
                interiorDropdown.disabled = true;
                exteriorDropdown.classList.add('readonly');
                interiorDropdown.classList.add('readonly');
            }
        }

    });


    // Color config dropdown logic
    document.getElementById('colorConfigDropdown').addEventListener('change', function() {
        const value = this.value;
        const [exterior, interior] = value.split('-');
        const exteriorDropdown = document.getElementById('colorExteriorDropdown');
        const interiorDropdown = document.getElementById('colorInteriorDropdown');

        exteriorDropdown.value = '';
        interiorDropdown.value = '';

        filterColorOptions(exteriorDropdown, exterior === 'LAM' ? 'laminate' : 'regular');
        filterColorOptions(interiorDropdown, interior === 'LAM' ? 'laminate' : 'regular');

        if (exterior !== 'LAM') exteriorDropdown.value = exterior;
        if (interior !== 'LAM') interiorDropdown.value = interior;

        // Add readonly if config is WH-WH, WH-BK, BK-WH, BK-BK
        const readonlyConfigs = ['WH-WH', 'WH-BK', 'BK-WH', 'BK-BK', 'WH-LAM', 'BK-LAM', 'LAM-WH', 'LAM-BK'];
        // Reset both first
        exteriorDropdown.disabled = false;
        interiorDropdown.disabled = false;
        exteriorDropdown.classList.remove('readonly');
        interiorDropdown.classList.remove('readonly');

        if (readonlyConfigs.includes(value)) {
            // Special handling for LAM cases
            if (value.includes('LAM')) {
                if (value.startsWith('LAM')) {
                    // LAM-X → disable X (interior)
                    interiorDropdown.disabled = true;
                    interiorDropdown.classList.add('readonly');
                } else if (value.endsWith('LAM')) {
                    // X-LAM → disable X (exterior)
                    exteriorDropdown.disabled = true;
                    exteriorDropdown.classList.add('readonly');
                }
            } else {
                // Non-LAM case → disable both
                exteriorDropdown.disabled = true;
                interiorDropdown.disabled = true;
                exteriorDropdown.classList.add('readonly');
                interiorDropdown.classList.add('readonly');
            }
        }
    });

    // Filter color options
    function filterColorOptions(dropdown, group) {
        dropdown.querySelectorAll('option').forEach(opt => {
            if (!opt.value) return;
            opt.style.display = opt.dataset.group === group ? 'block' : 'none';
        });
    }

    // Window preview logic
    function updateWindowPreview() {
        const series = document.getElementById('seriesSelect').selectedOptions[0] ?.text ?.toLowerCase();
        const config = document.getElementById('seriesTypeSelect').value;
        const width = document.querySelector('[name="width"]').value || 60;
        const height = document.querySelector('[name="height"]').value || 48;
        const previewBox = document.getElementById('window-svg-preview');

        if (series && config && width && height) {
            const url = `/window/render/${series}/${config}?width=${width}&height=${height}`;
            fetch(url)
                .then(res => res.text())
                .then(svg => {
                    previewBox.innerHTML = svg;
                })
                .catch(() => {
                    previewBox.innerHTML = `<div class="text-danger">Preview unavailable</div>`;
                });
        } else {
            previewBox.innerHTML = `<p style="position: absolute; top: 30%; left: 40%; font-size: 24px;">CLCL</p>
                                <p style="position: absolute; bottom: 10%; right: 20%; font-size: 18px;">ARG</p>`;
        }
    }

    // Watch inputs for preview
    document.getElementById('seriesSelect').addEventListener('change', updateWindowPreview);
    document.getElementById('seriesTypeSelect').addEventListener('change', updateWindowPreview);
    document.querySelector('[name="width"]').addEventListener('input', updateWindowPreview);
    document.querySelector('[name="height"]').addEventListener('input', updateWindowPreview);

    // Modal cleanup
    document.addEventListener('hidden.bs.modal', function(event) {
        document.body.classList.remove('modal-open');
        document.body.style = '';
        // document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    });


    document.getElementById('colorConfigDropdown').addEventListener('change', function() {
        const value = this.value;
        const [exterior, interior] = value.split('-');

        // Reset all dropdowns
        const exteriorDropdown = document.getElementById('exteriorDropdown');
        const exteriorLaminateDropdown = document.getElementById('exteriorLaminateDropdown');
        const interiorDropdown = document.getElementById('interiorDropdown');
        const interiorLaminateDropdown = document.getElementById('interiorLaminateDropdown');

        if (exteriorDropdown) exteriorDropdown.classList.add('d-none');
        if (exteriorLaminateDropdown) exteriorLaminateDropdown.classList.add('d-none');
        if (interiorDropdown) interiorDropdown.classList.add('d-none');
        if (interiorLaminateDropdown) interiorLaminateDropdown.classList.add('d-none');

        // Exterior logic
        if (exterior === 'LAM') {
            if (exteriorLaminateDropdown) exteriorLaminateDropdown.classList.remove('d-none');
        } else {
            if (exteriorDropdown) {
                exteriorDropdown.classList.remove('d-none');
                exteriorDropdown.value = exterior;
            }
        }

        // Interior logic
        if (interior === 'LAM') {
            if (interiorLaminateDropdown) interiorLaminateDropdown.classList.remove('d-none');
        } else {
            if (interiorDropdown) {
                interiorDropdown.classList.remove('d-none');
                interiorDropdown.value = interior;
            }
        }
    });

    function filterColorOptions(dropdown, group) {
        let options = dropdown.querySelectorAll('option');

        options.forEach(opt => {
            if (!opt.value) return; // skip placeholder
            const isVisible = opt.dataset.group === group;
            opt.style.display = isVisible ? 'block' : 'none';
        });
    }

    document.getElementById('colorConfigDropdown').addEventListener('change', function() {
        const config = this.value;
        const [exteriorCode, interiorCode] = config.split('-');

        const exteriorDropdown = document.getElementById('colorExteriorDropdown');
        const interiorDropdown = document.getElementById('colorInteriorDropdown');

        // Reset values
        exteriorDropdown.value = '';
        interiorDropdown.value = '';

        // Filter options based on code
        if (exteriorCode === 'LAM') {
            filterColorOptions(exteriorDropdown, 'laminate');
        } else {
            filterColorOptions(exteriorDropdown, 'regular');
            exteriorDropdown.value = exteriorCode;
        }

        if (interiorCode === 'LAM') {
            filterColorOptions(interiorDropdown, 'laminate');
        } else {
            filterColorOptions(interiorDropdown, 'regular');
            interiorDropdown.value = interiorCode;
        }
    });

    let isAddingLineItem = false;
    let isFirstLineItem = true;
    let currentLineItemDiscount = 0; // Track discount for current line item
    let hasAppliedFirstDiscount = false; // Ensure first discount only applies once

    function fetchBasePrice() {
        const series_id = $('#seriesSelect').val();
        const series_type = $('#seriesTypeSelect').val();
        const width = $('input[name="width"]').val();
        const height = $('input[name="height"]').val();

        if (series_id && series_type && width && height) {
            $.post("{{ route('sales.quotes.checkPrice') }}", {
                _token: "{{ csrf_token() }}",
                series_id: series_id,
                series_type: series_type,
                width: width,
                height: height,
                customer_number: "{{ $quote->customer_number ?? '' }}"
            }, function(res) {
                const price = parseFloat(res.price ?? 0).toFixed(2);
                const newDiscount = parseFloat(res.discount ?? 0);
                const currentGlobalDiscount = parseFloat($('input[name="discount"]').val() || 0);

                let updatedGlobalDiscount = currentGlobalDiscount;

                // Case 1: First time discount application
                if (isFirstLineItem && !hasAppliedFirstDiscount) {
                    updatedGlobalDiscount = newDiscount;
                    hasAppliedFirstDiscount = true;
                    currentLineItemDiscount = newDiscount;
                }
                // Case 2: New line item being added
                else if (isAddingLineItem) {
                    // Remove previous discount for this item and add new
                    updatedGlobalDiscount = currentGlobalDiscount - currentLineItemDiscount + newDiscount;
                    currentLineItemDiscount = newDiscount;
                }
                // Case 3: Existing configuration change
                else {
                    // Only update current item's discount without affecting global total
                    currentLineItemDiscount = newDiscount;
                }

                // Update UI elements
                $('input[name="discount"]').val(updatedGlobalDiscount.toFixed(2));
                $('#globalTotalPrice').text(price);
                $('input[name="price"]').val(price);
                $('input[name="total"]').val(price);

                // Reset adding flag after processing
                isAddingLineItem = false;
            });
        }
    }

    // Event handlers remain the same
    $('#seriesSelect, #seriesTypeSelect').on('change', fetchBasePrice);
    $('input[name="width"], input[name="height"]').on('keyup', fetchBasePrice);
    $('#saveQuoteItem').on('click', function() {
        isAddingLineItem = true;
    });

    @if(isset($allConfigurations))

    const allConfigurations = @json($allConfigurations);

    document.addEventListener('DOMContentLoaded', function() {
        const modalTrigger = document.querySelector('[data-bs-target="#configLookupModal"]');
        const confirmBtn = document.getElementById('confirmConfigSelection');

        modalTrigger.addEventListener('click', function() {
            const selectedSeriesId = document.getElementById('seriesSelect').value;
            const selectedSeriesText = document.getElementById('seriesSelect').selectedOptions[0] ?.text ?.trim();
            const accordion = document.getElementById('categoryAccordion');
            accordion.innerHTML = '';

            const seriesConfigs = allConfigurations[selectedSeriesId];

            if (!seriesConfigs || seriesConfigs.length === 0) {
                accordion.innerHTML = '<p class="text-danger">No configurations available for selected series.</p>';
                return;
            }

            const grouped = {};
            seriesConfigs.forEach(item => {
                const config = typeof item === 'string' ? {
                    name: item
                    , category: 'General'
                    , image: `${item.toLowerCase()}.png`
                    , series: selectedSeriesText
                } : item;

                if (!grouped[config.category]) grouped[config.category] = [];
                grouped[config.category].push(config);
            });

            let index = 0;
            for (const category in grouped) {
                const configs = grouped[category];
                const collapseId = `collapse${index}`;

                const section = document.createElement('div');
                section.className = 'accordion-item';
                section.innerHTML = `
                <h2 class="accordion-header" id="heading${index}">
                    <button class="accordion-button ${index > 0 ? 'collapsed' : ''}" type="button"
                            data-bs-toggle="collapse" data-bs-target="#${collapseId}" aria-expanded="${index === 0}"
                            aria-controls="${collapseId}">
                        ${category}
                    </button>
                </h2>
                <div id="${collapseId}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}"
                     aria-labelledby="heading${index}" data-bs-parent="#categoryAccordion">
                    <div class="accordion-body">
                        <div class="row g-3">
                            ${configs.map(conf => `
                                <div class="col-md-3">
                                    <div class="card h-100 text-center config-card p-2">
                                        <input type="radio" name="configSelect" value="${conf.name}" class="form-check-input my-2">
                                        <img src="/config-thumbs/${conf.series}/${conf.category}/${conf.image}"
                                             class="card-img-top" alt="${conf.name}" style="height: 140px; object-fit: contain;">
                                        <div class="card-body p-2">
                                            <small>${conf.name}</small>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
                accordion.appendChild(section);
                index++;
            }
        });

        confirmBtn.addEventListener('click', function() {
            const selectedRadio = document.querySelector('input[name="configSelect"]:checked');
            const dropdown = document.getElementById('seriesTypeSelect');

            if (!selectedRadio) {
                alert('Please select a configuration.');
                return;
            }

            const selectedValue = selectedRadio.value;

            for (let opt of dropdown.options) {
                if (opt.text.trim() === selectedValue.trim()) {
                    dropdown.value = opt.value;
                    break;
                }
            }

            bootstrap.Modal.getInstance(document.getElementById('configLookupModal')).hide();
        });
    });
    @endif

    $('#frame_type').on('change', function() {
        const selectedFrame = $(this).val();
        $.ajax({
            url: '/sales/quotes/schema/price',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                dropdown_value: selectedFrame,
                series_type: $('#seriesTypeSelect').val()
            },
            success: function(data) {

                const currentTotal = parseFloat($('#globalTotalPrice').text()) || 0;
                $('#globalTotalPrice').text(currentTotal + data.price);
                // You can update the UI or perform other actions based on the response
            },
            error: function(xhr, status, error) {
                console.error('Error fetching frame details:', error);
            }
        });
        console.log('Selected frame type:', selectedFrame);
    });

    $('#fin_type').on('change', function() {
        const selectedFin = $(this).val();
        console.log('Selected finish type:', selectedFin);
    });

     $('#shipping').on('focusout', function() {
        const shippingValue = parseFloat($(this).val()) || 0;
        $('#shipping-amount').text('$' + shippingValue.toFixed(2));
        $('#shipping').val(shippingValue.toFixed(2));
        calculateTotals();
    });

    function openQuotePreview(quoteId) {
        // const pdfUrl = `/quotes/pdf/${quoteId}/preview`; // You can adjust route if different
        // document.getElementById('quotePdfIframe').src = pdfUrl;
        // document.getElementById('downloadQuoteBtn').href = pdfUrl + '?download=true';
        const modalElement = document.getElementById('quotePreviewModal');
        if (modalElement) {
            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
            modal.show();
        } else {
            alert('Quote preview modal not found in the DOM.');
        }
    }

    function calculateTotals(shipping = 0, modalOpen = false) {

         fetch('{{ route('calculate.total', ['quote_id' => $quote->id]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                shipping: parseFloat(document.getElementById('shipping').value) || 0
            })
        }).then(response => response.json()).then(data => {
            if (data.success) {
                if(modalOpen) {
                    var shipping = $('#shipping').val();
                    // If modal is open, update the totals in the modal
                    $('#discount-amount').text("$" + data.data.total_discount);

                    document.getElementById('sub-total-amount').textContent = '$' + data.data.sub_total;
                    document.getElementById('tax-amount-preview').textContent = '$' + data.data.tax + ' (' + data.data.tax_rate + '%)';
                    document.getElementById('shipping-amount').textContent = '$' + data.data.shipping;
                    document.getElementById('grand-total-amount').textContent = '$' + data.data.grand_total;
                } else {
                    // Update the UI with the new totals
                    $('#subtotal-amount').text('$' + data.data.sub_total);
                    $('#discount-amount').text("$" + data.data.total_discount);
                    $('#tax-amount').text('$' + data.data.tax + ' (' + data.data.tax_rate + '%)');
                    $('#total-amount').text('$' + data.data.grand_total);
                    document.getElementById('tax').value = data.data.tax;
                    document.getElementById('subtotal').value = data.data.sub_total;
                    document.getElementById('tax').value = data.data.tax;
                    document.getElementById('total').value = data.data.grand_total;
                }
            } else {
                alert('Error calculating totals.');
            }
        }).catch(error => {
            console.error('Error fetching total:', error);
        });
    }
    // Save draft button click event
    document.getElementById('saveDraftButton').addEventListener('click', function() {
        const formData = new FormData();
        formData.append('subtotal', document.getElementById('subtotal').value);
        formData.append('tax', document.getElementById('tax').value);
        formData.append('total', document.getElementById('total').value);
        formData.append('discount', document.getElementById('discount').value);
        formData.append('shipping', document.getElementById('shipping').value);

        fetch('{{ route('sales.quotes.save.draft', $quote->id) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
               if (data.success) {
                toastr.success('Draft saved successfully!', 'Success', {
                        timeOut: 3000
                        , progressBar: true
                        , closeButton: true
                    });
                window.location.href = '{{ route('sales.quotes.index') }}';
            } else {
                alert('Error saving draft.');
                toastr.error('Failed to save draft. Please try again.', 'Error', {
                        timeOut: 3000
                        , progressBar: true
                        , closeButton: true
                    });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Listen for qty input changes
     document.addEventListener('input', function(e) {
        if (e.target.classList.contains('qty-input')) {
            var shipping = $('#shipping').val();
            calculateTotals(shipping, false);
        }
    });

    document.getElementById('customModal').addEventListener('shown.bs.modal', function() {
        var shipping = $('#shipping').val();
        calculateTotals(shipping, true);
    });

    // Initial calculation on page load
    document.addEventListener('DOMContentLoaded', calculateTotals);

</script>

@endpush
