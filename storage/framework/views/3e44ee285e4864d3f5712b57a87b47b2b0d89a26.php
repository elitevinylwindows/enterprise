<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Panel View')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"><?php echo e(__('Panel View')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Panel View')); ?></h5>
                        </div>
                           <div class="col-auto">
    <div class="d-flex flex-wrap gap-2 align-items-center">

        
<a href="#" class="btn btn-secondary customModal" id="launch-bulk-btn"
   data-title="Create Bulk Event"
   data-size="lg"
   data-url="">
   <i class="ti ti-copy"></i> Bulk Event
</a>




        
        <a href="<?php echo e(route('sr.deliveries.refresh')); ?>" class="btn btn-secondary">
            <i class="ti ti-refresh"></i> <?php echo e(__('Fields Refresh')); ?>

        </a>

        
        <a href="<?php echo e(route('sr.deliveries.recheck')); ?>" class="btn btn-secondary">
            <i class="ti ti-rotate-clockwise"></i> <?php echo e(__('Import from Orders')); ?>

        </a>

        
        <a href="<?php echo e(route('sr.deliveries.refreshUnitCheck')); ?>" class="btn btn-secondary">
            <i class="ti ti-check-circle"></i> <?php echo e(__('Unit Check Refresh')); ?>

        </a>

    </div>
</div>


                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable" id="deliveriesTable">
                            <thead>
                                <tr>
                                       
<th>
      <input type="checkbox" id="select-all-checkbox" />
    </th>                                    <th><?php echo e(__('Order #')); ?></th>
                                    <th><?php echo e(__('Customer Name')); ?></th>
                                    <th><?php echo e(__('Customer')); ?></th>
                                    <th><?php echo e(__('Carts')); ?></th>
                                    <th><?php echo e(__('Units')); ?></th>
                                    <th><?php echo e(__('Unit Check')); ?></th>
                                    <th><?php echo e(__('Comment')); ?></th>
                                    <th><?php echo e(__('Commission')); ?></th>
                                  <th><?php echo e(__('Delivery / Pickup')); ?></th>
                                    <th><?php echo e(__('Address')); ?></th>
                                    <th><?php echo e(__('City')); ?></th>
                                     <th><?php echo e(__('Delivery Date')); ?></th>
                                    <th><?php echo e(__('Priority')); ?></th>
                                    <th><?php echo e(__('Timeframe')); ?></th>
                                     <th><?php echo e(__('Email')); ?></th>
                                    <th><?php echo e(__('Contact Phone')); ?></th>
                                    <th><?php echo e(__('Notes')); ?></th>

                                    <th><?php echo e(__('Status')); ?></th>
                                    <th class="text-right"><?php echo e(__('Action')); ?></th>
                                  
                                </tr>
                            </thead>
                            <tbody>
<?php $__currentLoopData = $deliveries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $delivery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                <td><input type="checkbox" class="bulk-delivery-checkbox" name="delivery_ids[]" value="<?php echo e($delivery->id); ?>"></td>
   <td><?php echo e($delivery->order_number); ?></td>
<td><?php echo e($delivery->customer_name); ?></td>
<td><?php echo e($delivery->customer); ?></td>
<td><?php echo e($delivery->carts); ?></td>
<td><?php echo e($delivery->units); ?></td>
<td>
    <?php if(isset($delivery->units_check) && $delivery->units_check == 0): ?>
        <span class="badge bg-success" data-bs-toggle="tooltip" title="All units scanned">&#10003;</span>
    <?php elseif(isset($delivery->units_check)): ?>
        <a href="#" class="badge bg-danger customModal"
           data-url="<?php echo e(route('sr.deliveries.missingBarcodes', $delivery->order_number)); ?>"
           data-title="Missing Barcodes for Order #<?php echo e($delivery->order_number); ?>"
           data-size="md"
           data-bs-toggle="tooltip"
           title="<?php echo e($delivery->unit_check); ?> units missing">
            <?php echo e($delivery->units_check); ?>

        </a>
    <?php else: ?>
        <span class="badge bg-danger" data-bs-toggle="tooltip" title="Unit check not calculated">--</span>
    <?php endif; ?>
</td>





<td><?php echo e($delivery->comment); ?></td>
<td><?php echo e($delivery->commission); ?></td>


<td>
    <button 
        class="btn btn-sm toggle-delivery-btn <?php echo e($delivery->is_delivery ? 'btn-secondary' : ''); ?>"
        style="<?php echo e(!$delivery->is_delivery ? 'color: #a80000; border: 1px solid #a80000; background: transparent;' : ''); ?>"
        data-id="<?php echo e($delivery->id); ?>"
        data-current="<?php echo e($delivery->is_delivery); ?>"
        data-order="<?php echo e($delivery->order_number); ?>"
        data-bs-toggle="tooltip"
        title="<?php echo e($delivery->is_delivery ? 'Click to mark as pickup' : 'Click to mark as delivery'); ?>">
        <?php echo e($delivery->is_delivery ? 'Delivery' : 'Pickup'); ?>

    </button>
</td>



<td><?php echo e($delivery->address); ?></td>
<td><?php echo e($delivery->city); ?></td>
<td><?php echo e($delivery->delivery_date ? \Carbon\Carbon::parse($delivery->delivery_date)->format('M d, Y') : '-'); ?>

</td>
<!--Priority-->
<td>
    <form method="POST" action="<?php echo e(route('sr.deliveries.toggleFieldButton', $delivery->id)); ?>">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="field" value="priority">
        <input type="hidden" name="value" value="<?php echo e($delivery->priority ? 0 : 1); ?>">
        <button type="submit"
            class="btn btn-sm <?php echo e($delivery->priority ? 'btn-secondary' : ''); ?>"
            style="<?php echo e(!$delivery->priority ? 'color: #a80000; border: 1px solid #a80000; background: transparent;' : ''); ?>"
            data-bs-toggle="tooltip"
            title="<?php echo e($delivery->priority ? 'Click to remove priority' : 'Click to mark as priority'); ?>">
            <?php echo e($delivery->priority ? 'Priority' : 'Normal'); ?>

        </button>
    </form>
</td>


<td><?php echo e($delivery->timeframe ?? '-'); ?></td>
<td><?php echo e($delivery->shop->email ?? '—'); ?></td>
<td><?php echo e($delivery->shop->contact_phone ?? '—'); ?></td>
<td><?php echo e($delivery->notes ?? '-'); ?></td>

<td>
    <?php
        $statusClass = match($delivery->status) {
            'complete' => 'success',
            'pending' => 'warning',
            default => 'secondary',
        };
    ?>
    <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e(ucfirst($delivery->status)); ?></span>
</td>

                                        <td>
  


<!--<a href="tel:+1<?php echo e(preg_replace('/\D/', '', $delivery->contact_phone)); ?>"
   class="avtar avtar-xs btn-link-success text-success"
   title="Click to call via RingCentral or default app">
    <i data-feather="phone"></i>
</a>-->
  <div class="cart-action">
<?php
    $formattedNumber = '+1' . preg_replace('/\D/', '', $delivery->contact_phone);
?>

<a href="tel:<?php echo e($formattedNumber); ?>"
   class="avtar avtar-xs btn-link-success text-success"
   data-bs-toggle="tooltip" title="Call via RingCentral App">
    <i data-feather="phone"></i>
</a>



        
        <a href="<?php echo e(route('action.sendTemplate', ['id' => $delivery->id, 'template_id' => 2])); ?>" class="avtar avtar-xs btn-link-info text-info send-reminder"
           data-id="<?php echo e($delivery->id); ?>"
   data-template-id="2"
           data-bs-toggle="tooltip" title="<?php echo e(__('Send Reminder')); ?>">
            <i data-feather="bell"></i>
        </a>

        
        <a href="<?php echo e(route('action.sendTemplate', ['id' => $delivery->id, 'template_id' => 1])); ?>" class="avtar avtar-xs btn-link-dark text-dark send-followup"
           data-id="<?php echo e($delivery->id); ?>"
data-template-id="1"
data-bs-toggle="tooltip" title="<?php echo e(__('Send Follow Up')); ?>">
            <i data-feather="message-circle"></i>
        </a>

        
        <a class="avtar avtar-xs btn-link-success text-success customModal"
           data-bs-toggle="tooltip" title="<?php echo e(__('Show')); ?>" href="#"
           data-size="lg" data-url="<?php echo e(route('sr.deliveries.show', $delivery->id)); ?>"
           data-title="<?php echo e(__('Delivery Details')); ?>">
            <i data-feather="eye"></i>
        </a>

        
        
        <a class="avtar avtar-xs btn-link-warning text-warning customModal"
           data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>" href="#"
           data-size="lg" data-url="<?php echo e(route('sr.deliveries.edit', $delivery->id)); ?>"
           data-title="<?php echo e(__('Edit Delivery')); ?>">
            <i data-feather="edit"></i>
        </a>

        
        <?php echo Form::open(['method' => 'DELETE', 'route' => ['sr.deliveries.destroy', $delivery->id]]); ?>

       <!-- <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
           data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>" href="#">
            <i data-feather="trash-2"></i>
        </a>-->

        <?php echo Form::close(); ?>

    </div>
</td>


                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
     </div>
    </div>  
    
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">



<script>
 

    // Send reminder/follow-up template
    $(document).on('click', '.send-template-action', function () {
        let deliveryId = $(this).data('id');
        let templateId = $(this).data('template-id');

        $.ajax({
            url: '<?php echo e(route("action.sendTemplate", [":id", ":template_id"])); ?>'
                .replace(':id', deliveryId)
                .replace(':template_id', templateId),
            type: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function () {
                toastr.success('Template sent!');
            },
            error: function () {
                alert('Failed to send email.');
            }
        });
    });


  // Priority toggle
    $(document).on('change', '.toggle-switch', function () {
        const checkbox = $(this);
        const id = checkbox.data('id');
        const field = checkbox.data('field');
        const value = checkbox.prop('checked') ? 1 : 0;

        $.ajax({
            type: 'POST',
            url: `/sr/deliveries/${id}/toggle`,
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                field: field,
                value: value
            },
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message || 'Toggle failed.');
                }
            },
            error: function () {
                toastr.error('Server error while toggling.');
            }
        });
    });
    
    
       // ✅ Delivery toggle button with dynamic update + customModal
$(document).on('click', '.toggle-delivery-btn', function () {
    let btn = $(this);
    let deliveryId = btn.data('id');
    let isCurrentlyDelivery = parseInt(btn.data('current'));
    let orderNumber = btn.data('order');

    $.ajax({
        url: '/sr/deliveries/' + deliveryId + '/toggle-delivery',
        method: 'POST',
        data: {
            _token: '<?php echo e(csrf_token()); ?>',
            is_delivery: isCurrentlyDelivery ? 0 : 1,
            order_number: orderNumber
        },
        success: function (response) {
            const tooltipTitle = isCurrentlyDelivery
                ? 'Click to mark as delivery'
                : 'Click to mark as pickup';

            if (response.open_modal) {
                $('#commonModal .modal-title').text('Create Delivery');
                $('#commonModal .modal-body').html('<div class="text-center p-4"><div class="spinner-border text-primary"></div></div>');
                $('#commonModal .modal-dialog')
                    .removeClass('modal-sm modal-md modal-lg modal-xl')
                    .addClass('modal-md');
                $('#commonModal').modal('show');

                $.get('<?php echo e(route("calendar.create")); ?>', function (formHtml) {
                    $('#commonModal .modal-body').html(formHtml);

                    let orderInput = document.querySelector('input[name="order_number"]');
                    if (orderInput) {
                        orderInput.value = response.order_number;
                        $(orderInput).trigger('blur');
                    }
                });

                btn.text('Delivery')
                    .removeClass('btn-outline-secondary')
                    .addClass('btn-success')
                    .attr('title', tooltipTitle)
                    .tooltip('dispose')
                    .tooltip();

                btn.data('current', 0);
            } else {
                btn.text('Pickup')
                    .removeClass('btn-success')
                    .addClass('btn-outline-secondary')
                    .attr('title', tooltipTitle)
                    .tooltip('dispose')
                    .tooltip();

                btn.data('current', 1);

                // Clear delivery date cell (12th column, index 11)
                btn.closest('tr').find('td').eq(11).html('-');
            }
        },
        error: function () {
            alert('Failed to update delivery status.');
        }
    });
});

  // ✅ Modal logic
    $(document).on('shown.bs.modal', function () {
        const emailField = $('#email');
        const phoneField = $('#contact_phone');
        const addressField = $('#address');
        const cityField = $('#city');
        const zipField = $('#zip');

        function clearFields() {
            emailField.val('').prop('readonly', false);
            phoneField.val('').prop('readonly', false);
            addressField.val('').prop('readonly', false);
            cityField.val('').prop('readonly', false);
            zipField.val('').prop('readonly', false);
        }

        function fetchShopContact(callback = () => {}) {
            const customer = $('input[name="customer"]').val();
            if (!customer) return;

            $.ajax({
                url: '<?php echo e(route("calendar.getShop")); ?>',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({ customer }),
                success: function (data) {
                    if (!data.error) {
                        emailField.val(data.email).prop('readonly', true);
                        phoneField.val(data.contact_phone).prop('readonly', true);
                        callback(data);
                    } else {
                        toastr.error(data.error);
                    }
                },
                error: function () {
                    toastr.error('Failed to fetch shop info.');
                }
            });
        }

        // Exclusive checkbox toggle
        $('.location-toggle').off('change').on('change', function () {
            $('.location-toggle').not(this).prop('checked', false);
            clearFields();

            const customer = $('input[name="customer"]').val();

            if (this.id === 'use_shop' && this.checked && customer) {
                fetchShopContact(function (data) {
                    addressField.val(data.address).prop('readonly', true);
                    cityField.val(data.city).prop('readonly', true);
                    zipField.val(data.zip).prop('readonly', true);
                });
            }

            if (this.id === 'use_whittier' && this.checked) {
                addressField.val('11648 Washington Blvd').prop('readonly', true);
                cityField.val('Whittier').prop('readonly', true);
                zipField.val('90606').prop('readonly', true);
                if (customer) fetchShopContact(); // fill only contact
            }

            if (this.id === 'use_other_location' && this.checked) {
                addressField.prop('readonly', false);
                cityField.prop('readonly', false);
                zipField.prop('readonly', false);
                if (customer) fetchShopContact(); // fill only contact
            }
        });

        // ✅ Autofill order number
        $('input[name="order_number"]').off('blur').on('blur', function () {
            const orderNumber = $(this).val();
            if (!orderNumber) return;

            $.get('/calendar/order-details/' + orderNumber, function (data) {
                if (!data.error) {
                    $('input[name="customer_name"]').val(data.customer_name || '');
                    $('input[name="customer"]').val(data.customer || '');
                    $('textarea[name="comment"]').val(data.comment || '');
                    $('input[name="city"]').val(data.city || '');
                } else {
                    toastr.error(data.error);
                }
            }).fail(function () {
                toastr.error('Order not found.');
            });
        });
    });

    calendar.render();

</script>
<script>
$(document).ready(function () {
    const table = $('.advance-datatable').DataTable();

    // After DataTable has rendered
    table.on('init.dt', function () {
        $('.delivery-row').each(function () {
            const row = $(this);

            // Try to find customer value from input or data-attribute
            let customer = row.find('.customer-field').val() || row.data('customer');
            if (!customer) return;

            $.ajax({
                url: '<?php echo e(route("shop.contact")); ?>',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({ customer: customer }),
                success: function (data) {
                    if (!data.error) {
                        // Fill only if fields are empty
                        if (!row.find('.email-field').val()) {
                            row.find('.email-field').val(data.email);
                        }
                        if (!row.find('.phone-field').val()) {
                            row.find('.phone-field').val(data.contact_phone);
                        }
                    }
                },
                error: function () {
                    console.warn('Shop contact fetch failed for customer:', customer);
                }
            });
        });
    });
});
</script>
<script>
    // On form submit, collect selected IDs and add to hidden input
    $('#bulk-calendar-form').on('submit', function (e) {
        const selected = $('.bulk-delivery-checkbox:checked').map(function () {
            return $(this).val();
        }).get();

        if (selected.length === 0) {
            e.preventDefault();
            alert('Select at least one delivery.');
            return;
        }

        $('#delivery-ids-field').val(JSON.stringify(selected));
    });
</script>
<script>
$(document).on('submit', '#bulkCreateForm', function (e) {
    e.preventDefault();

    const $form = $(this);
    const url = $form.attr('action');
    const data = $form.serialize();

    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function () {
            toastr.success('Bulk deliveries created successfully.');
            $('#customModal').modal('hide');

            // Optional: redirect to calendar
            window.location.href = '<?php echo e(route("calendar.index")); ?>';
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            toastr.error('Failed to create deliveries.');
        }
    });
});
</script>

<script>
  $('#launch-bulk-btn').on('click', function (e) {
    e.preventDefault();

    const selected = $('.bulk-delivery-checkbox:checked').map(function () {
        return $(this).val();
    }).get();

    if (selected.length === 0) {
        alert('Please select at least one order.');
        return;
    }

    const url = '<?php echo e(route("calendar.bulkCreateForm")); ?>' + '?ids=' + encodeURIComponent(JSON.stringify(selected));

    // update data-url and retrigger modal
    const $btn = $(this);
    $btn.attr('data-url', url);
    $btn.attr('data-title', 'Create Bulk Event');
    $btn.attr('data-size', 'lg');
    $btn.trigger('click'); // this must re-trigger .customModal
});

</script>
<script>
    $(document).ready(function () {
        $('#select-all-checkbox').on('change', function () {
            $('.bulk-delivery-checkbox').prop('checked', this.checked);
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/sr/deliveries/all.blade.php ENDPATH**/ ?>