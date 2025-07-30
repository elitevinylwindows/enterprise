

<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Quote Details')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
<style>
    #window-previewer {
        width: 500px;
        height: 500px;
        border: 1px solid #ccc;
        margin: 20px auto;
        position: relative;
    }

</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('sales.quotes.index')); ?>">Quotes</a></li>
<li class="breadcrumb-item active">Quote Details</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-dark">Quote Details</h5>
        </div>

        <!--    <?php echo $__env->make('sales.quotes.partials.quote-steps', ['activeStep' => 2], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>-->

        <div class="card-body">
            <!-- Quote Metadata -->
            <div class="row mb-3">
                <div class="col-md-2">
                    <label>Customer Number</label>
                    <input type="text" class="form-control" value="<?php echo e($quote->customer_number); ?>" readonly>
                </div>
                <div class="col-md-2">
                    <label>Customer Name</label>
                    <input type="text" class="form-control" value="<?php echo e($quote->customer_name); ?>" readonly>
                </div>
                <div class="col-md-2">
                    <label>Quote Number</label>
                    <input type="text" class="form-control" value="<?php echo e($quote->quote_number); ?>" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Entered By</label>
                    <input type="text" class="form-control" value="<?php echo e($quote->entered_by); ?>" readonly>
                </div>
                <div class="col-md-4">
                    <label>Entry Date</label>
                    <input type="text" class="form-control" value="<?php echo e(\Carbon\Carbon::parse($quote->entry_date)->format('Y-m-d')); ?>" readonly>
                </div>
                <div class="col-md-4">
                    <label>Expected Delivery</label>
                    <input type="text" class="form-control" value="<?php echo e(\Carbon\Carbon::parse($quote->expected_delivery)->format('Y-m-d')); ?>" readonly>
                </div>
            </div>

            <div class="row mb-3 align-items-end">
                
                <div class="col-md-4">
                    <label for="seriesSelect">Series</label>
                    <select name="series_id" id="seriesSelect" class="form-control">
                        <option value="">Select Series</option>
                        <?php $__currentLoopData = $seriesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $series): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>"><?php echo e($series); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
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
                    <?php $__currentLoopData = $quoteItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->description); ?></td>
                        <td><input type="number" name="qty[]" value="<?php echo e($item->qty); ?>" class="form-control form-control-sm" style="width: 60px;"></td>
                        <td><?php echo e($item->width); ?>" x <?php echo e($item->height); ?>"</td>
                        <td><?php echo e($item->glass); ?></td>
                        <td><?php echo e($item->grid); ?></td>
                        <td>$<?php echo e(number_format($item->price, 2)); ?></td>
                        <td>$<?php echo e(number_format($item->total, 2)); ?></td>
                        <td><img src="<?php echo e($item->image_url ?? 'https://via.placeholder.com/40'); ?>" class="img-thumbnail" alt="Item"></td>
                        <td class="text-nowrap">
                            <a href="javascript:void(0);" class="avtar avtar-xs btn-link-success text-success view-quote-item" data-id="<?php echo e($item->id); ?>">
                                <i data-feather="eye"></i>
                            </a>
                            <a href="javascript:void(0);" class="avtar avtar-xs btn-link-primary text-primary edit-quote-item" data-id="<?php echo e($item->id); ?>">
                                <i data-feather="edit"></i>
                            </a>
                            <a href="javascript:void(0);" class="avtar avtar-xs btn-link-danger text-danger remove-row" data-id="<?php echo e($item->id); ?>">
                                <i data-feather="trash-2"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>


            </table>

            <!-- Totals -->
            <div class="row mt-4">
                <div class="col-md-6 offset-md-6">
                    <table class="table">
                        <tr>
                            <th>Surcharge:</th>
                            <td>$0.00</td>
                        </tr>
                        <tr>
                            <th>Subtotal:</th>
                            <td>$0.00</td>
                        </tr>
                        <tr>
                            <th>Tax:</th>
                            <td>$0.00</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td><strong>$0.00</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="row mt-3 text-muted small">
                <div class="col-md-4"><strong>Entered By:</strong> <?php echo e($quote->entered_by); ?></div>
                <div class="col-md-4"><strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($quote->entry_date)->format('m/d/Y')); ?></div>
                <div class="col-md-4"><strong>Expires:</strong> <?php echo e(\Carbon\Carbon::parse($quote->valid_until)->format('m/d/Y')); ?></div>
            </div>


            <div class="d-flex justify-content-between mt-4">
                <a href="<?php echo e(route('sales.quotes.create')); ?>" class="btn btn-secondary">&larr; Previous</a>

                <div class=class="d-flex gap-2">
                    <a href="" class="btn btn-secondary">Save Draft</a>
                    <a href="" class="btn btn-secondary">Continue &rarr;</a>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="quoteItemForm" method="POST" action="<?php echo e(route('sales.quotes.storeItem', $quote->id)); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="quote_id" id="quoteId" value="<?php echo e($quote->id); ?>">

                <!-- Hidden fields for JS-generated display values -->
                <input type="hidden" name="description" id="description">
                <input type="hidden" name="glass" id="glass">
                <input type="hidden" name="grid" id="grid">
                <input type="hidden" name="size" id="size">
                <input type="hidden" name="price" id="price">
                <input type="hidden" name="total" id="total">


                <div class="modal-header bg-white text-dark">
                    <h5 class="mb-0">Add Quote Item</h5>
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
                                        <select class="form-control" name="color_config" id="colorConfigDropdown">
                                            <option value="">Select Configuration</option>
                                            <?php $__currentLoopData = $colorConfigurations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($config->code); ?>"><?php echo e($config->code); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Color Code (Exterior)</label>
                                        <select class="form-control" name="color_exterior" id="colorExteriorDropdown">
                                            <option value="">Select Exterior Color</option>
                                            <?php $__currentLoopData = $exteriorColors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($color->code); ?>" data-group="regular"><?php echo e($color->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $laminateColors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($color->code); ?>" data-group="laminate"><?php echo e($color->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Color Code (Interior)</label>
                                        <select class="form-control" name="color_interior" id="colorInteriorDropdown">
                                            <option value="">Select Interior Color</option>
                                            <?php $__currentLoopData = $interiorColors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($color->code); ?>" data-group="regular"><?php echo e($color->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $laminateColors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($color->code); ?>" data-group="laminate"><?php echo e($color->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="general">
                                    <div class="mb-3">
                                        <label>Frame Type</label>
                                        <select class="form-control" name="frame_type" id="frame_type">
                                            <option value="">Select Frame Type</option>
                                            <option value="Retrofit">Retrofit</option>
                                            <option value="Nailon">Nailon</option>
                                            <option value="Block">Block</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Retrofit Fin Type</label>
                                        <select class="form-control" name="fin_type" required id="fin_type">
                                            <option value="">Select Fin Type</option>
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
                                    <div id="window-previewer" class="border rounded bg-light p-4 mb-3 text-center" style="height: 300px; position: relative;">
                                        <!-- This gets dynamically replaced -->
                                        <canvas id="windowCanvas" width="500" height="200"></canvas>
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
                    
                </div>

                <div class="text-end mt-3">
                    <a href="#" id="confirmConfigSelection" class="btn btn-primary">Select Configuration</a>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- View Quote Item Modal -->
<div class="modal fade" id="viewQuoteItemModal" tabindex="-1" aria-labelledby="viewQuoteItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="viewQuoteItemModalContent">
            <!-- AJAX-loaded content goes here -->
        </div>
    </div>
</div>




<?php $__env->stopSection(); ?>



<?php $__env->startPush('scripts'); ?>
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
        const config = document.getElementById('seriesTypeSelect').value;

        const glassType = form.querySelector('[name="glass_type"]').value;
        const spacer = form.querySelector('[name="spacer"]').value;
        const tempered = form.querySelector('[name="tempered"]').value;
        const specialtyGLass = form.querySelector('[name="specialty_glass"]').value;

        const gridPattern = form.querySelector('[name="grid_pattern"]').value;
        const gridProfile = form.querySelector('[name="grid_profile"]').value;

        const frameType = form.querySelector('[name="frame_type"]').value;
        const finType = form.querySelector('[name="fin_type"]').value;

        const colorConfig = form.querySelector('[name="color_config"]').value;
        const colorExt = form.querySelector('[name="color_exterior"]');
        const colorInt = form.querySelector('[name="color_interior"]');
        const laminateExtText = colorExt ?.selectedOptions[0] ?.text ?? '';
        const colorIntText = colorInt ?.selectedOptions[0] ?.text ?? '';

        let colorDisplay = '';
        if (colorConfig.includes('LAM')) {
            colorDisplay = `LAM (${laminateExtText}) - ${colorIntText}`;
        } else {
            colorDisplay = `${colorConfig}`;
        }

        if (!series || !config || !width || !height) {
            alert('Please select Series, Configuration, Width, and Height.');
            return;
        }

        const itemDesc = `${series}-${config} / ${colorDisplay} / ${frameType}-${finType}`;
        document.getElementById('description').value = itemDesc;

        const glass = `${glassType}-${spacer} / ${tempered} / ${specialtyGLass}`;
        const grid = `${gridPattern} / ${gridProfile}`;
        const size = `${width}" x ${height}"`;
        const price = '0.00';
        const total = (qty * parseFloat(price)).toFixed(2);

        // 1. Append to table
        const row = `
        <tr>
            <td>${itemDesc}</td>
            <td><input type="number" name="qty[]" value="${qty}" class="form-control form-control-sm" style="width: 60px;"></td>
            <td>${size}</td>
            <td>${glass}</td>
            <td>${grid}</td>
            <td>$${price}</td>
            <td>$${total}</td>
            <td><img src="https://via.placeholder.com/40" class="img-thumbnail" alt="Item"></td>
            <td class="text-nowrap">
                <a href="javascript:void(0);" class="avtar avtar-xs btn-link-success text-success view-quote-item">
                    <i data-feather="eye"></i>
                </a>
                <a href="javascript:void(0);" class="avtar avtar-xs btn-link-primary text-primary edit-quote-item">
                    <i data-feather="edit"></i>
                </a>
                <a href="javascript:void(0);" class="avtar avtar-xs btn-link-danger text-danger remove-row">
                    <i data-feather="trash-2"></i>
                </a>
            </td>
        </tr>
    `;
        document.querySelector('#quoteDetailsTable tbody').insertAdjacentHTML('beforeend', row);

        // 2. Save to DB using FormData

        const formData = new FormData();
        formData.append('description', itemDesc);
        formData.append('width', width);
        formData.append('height', height);
        formData.append('glass', glass);
        formData.append('grid', grid);
        formData.append('qty', qty);
        formData.append('price', price);
        formData.append('total', total);
        formData.append('item_comment', '');
        formData.append('internal_note', '');

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

                    console.log('Modal closed');
                } else {
                    alert('Item failed to save.');
                }
            })
            .catch(() => alert('Server error'));


        // 3. Hide modal
        const modalElement = document.getElementById('quoteItemModal');
        const modal = bootstrap.Modal.getInstance(modalElement) ?? new bootstrap.Modal(modalElement);
        if (modal) {
            modal.hide();
        }
        // 4. Reset form + preview
        form.reset();



        document.getElementById('window-svg-preview').innerHTML = '<svg></svg>';
    });

    // Delete row
    document.querySelector('#quoteDetailsTable tbody').addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            e.target.closest('tr').remove();
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
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    });


    document.getElementById('colorConfigDropdown').addEventListener('change', function() {
        const value = this.value;
        const [exterior, interior] = value.split('-');

        // Reset all dropdowns
        document.getElementById('exteriorDropdown').classList.add('d-none');
        document.getElementById('exteriorLaminateDropdown').classList.add('d-none');
        document.getElementById('interiorDropdown').classList.add('d-none');
        document.getElementById('interiorLaminateDropdown').classList.add('d-none');

        // Exterior logic
        if (exterior === 'LAM') {
            document.getElementById('exteriorLaminateDropdown').classList.remove('d-none');
        } else {
            document.getElementById('exteriorDropdown').classList.remove('d-none');
            document.getElementById('exteriorDropdown').value = exterior;
        }

        // Interior logic
        if (interior === 'LAM') {
            document.getElementById('interiorLaminateDropdown').classList.remove('d-none');
        } else {
            document.getElementById('interiorDropdown').classList.remove('d-none');
            document.getElementById('interiorDropdown').value = interior;
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

    function fetchBasePrice() {
        const series_id = $('#seriesSelect').val();
        const series_type = $('#seriesTypeSelect').val();
        const width = $('input[name="width"]').val();
        const height = $('input[name="height"]').val();

        if (series_id && series_type && width && height) {
            $.post("<?php echo e(route('sales.quotes.checkPrice')); ?>", {
                _token: "<?php echo e(csrf_token()); ?>"
                , series_id: series_id
                , series_type: series_type
                , width: width
                , height: height,
                customer_number: "<?php echo e($quote->customer_number ?? ''); ?>"
            }, function(res) {
                const price = parseFloat(res.price ?? 0).toFixed(2);
                $('#globalTotalPrice').text(price);
                $('input[name="price"]').val(price);
                $('input[name="total"]').val(price);
            });

        }
    }

    // Trigger on input change
    $('#seriesSelect, #seriesTypeSelect').on('change', fetchBasePrice);
    $('input[name="width"], input[name="height"]').on('keyup', fetchBasePrice);


    document.querySelectorAll('.view-quote-item').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.dataset.url;
            const modalContent = document.getElementById('viewQuoteItemModalContent');

            modalContent.innerHTML = '<div class="modal-body text-center p-4"><div class="spinner-border text-primary" role="status"></div></div>';

            fetch(url)
                .then(res => res.text())
                .then(html => {
                    modalContent.innerHTML = html;
                })
                .catch(err => {
                    modalContent.innerHTML = '<div class="modal-body text-danger">Failed to load item.</div>';
                    console.error(err);
                });
        });
    });

    <?php if(isset($allConfigurations)): ?>

    const allConfigurations = <?php echo json_encode($allConfigurations, 15, 512) ?>;

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
    <?php endif; ?>

    $('#frame_type').on('change', function() {
        const selectedFrame = $(this).val();
        $.ajax({
            url: '/sales/quotes/schema/price',
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
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
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\elitevinyle\resources\views/sales/quotes/details.blade.php ENDPATH**/ ?>