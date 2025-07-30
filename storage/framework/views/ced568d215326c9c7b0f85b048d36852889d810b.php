<tr>
    <td><?php echo e($item->description); ?></td>
    <td><input type="number" name="qty[]" value="<?php echo e($item->qty); ?>" class="form-control form-control-sm" style="width: 60px;"></td>
    <td><?php echo e($item->size ?? ''); ?></td>
    <td><?php echo e($item->glass); ?></td>
    <td><?php echo e($item->grid); ?></td>
    <td>$<?php echo e($item->price); ?></td>
    <td>$<?php echo e($item->total); ?></td>
    <td><img src="https://via.placeholder.com/40" class="img-thumbnail" alt="Item"></td>
    <td><button type="button" class="btn btn-sm btn-danger remove-row">Delete</button></td>
</tr>

<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/sales/quotes/quote_items/row.blade.php ENDPATH**/ ?>