

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Product Prices')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active"><?php echo e(__('Product Prices')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
    <form action="<?php echo e(route('prices.productprices.import')); ?>" method="POST" enctype="multipart/form-data" class="d-inline-block">
        <?php echo csrf_field(); ?>
        <input type="file" name="import_file" accept=".csv, .xls, .xlsx" required class="form-control d-inline-block w-auto">
        <button type="submit" class="btn btn-sm btn-primary">
            <i data-feather="upload"></i> Import Files
        </button>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5><?php echo e(__('Product Prices')); ?></h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="dataTable">
                        <thead>
                <tr>
    <th>Product Id</th>
    <th>Schema ID</th>
    <th>Product Code</th>
    <th>Product Class</th>
    <th>Description</th>
    <th>Retrofit</th>
    <th>Nailon</th>
    <th>Block</th>
    <th>Clr</th>
    <th>Le3</th>
    <th>Le3 Clr</th>
    <th>Clr Clr</th>
    <th>Le3 Lam</th>
    <th>Le3 Clr Le3</th>
    <th>Clr Temp</th>
    <th>1Le3 1Clrtemp</th>
    <th>2Le3 1Clrtemp</th>
    <th>Lam Temp</th>
    <th>Clt Clt</th>
    <th>Let Let Let</th>
    <th>Le3 Lam Le3</th>
    <th>Let Clt Let</th>
    <th>Let Lam Let</th>
    <th>Let Clt</th>
    <th>Obs</th>
    <th>Gery</th>
    <th>Rain</th>
    <th>Temp</th>
    <th>Clr Lam</th>
    <th>Color Multi</th>
    <th>Base Multi</th>
    <th>Feat1</th>
    <th>Feat2</th>
    <th>Feat3</th>
    <th>Sta Grd</th>
    <th>Tpi</th>
    <th>Tpo</th>
    <th>Acid Etch</th>
    <th>Acid Edge</th>
    <th>Solar Cool</th>
    <th>Solar Cool G</th>
    <th>Sales Factor</th>
    <th>Total Cost</th>
    <th>Cost Ft</th>
    <th>Cost Pc</th>
    <th>Cost</th>
    <th>Mark Up</th>
    <th>Rate</th>
    <th>M Cost</th>
    <th>Calculated Cost</th>
    <th>Cost Inch</th>
    <th>Unit Box</th>
    <th>Price Box</th>
    <th>Price Piece</th>
    <th>Box Weight</th>
    <th>Ft Box</th>
    <th>Inch Box</th>
    <th>Price Inch</th>
    <th>Vent</th>
    <th>Xfix</th>
    <th>Fix</th>
    <th>Grid</th>
    <th>Lam Im Gx</th>
    <th>Two Panel Frame</th>
    <th>Three Panel Frame</th>
    <th>Four Panel Frame</th>
    <th>Panel</th>
    <th>Price Sq Ft</th>
    <th>Stf</th>
    <th>Labor Sta</th>
    <th>Labor Field</th>
    <th>Profit</th>
    <th>Purchase Price</th>
    <th>Markup Percentage</th>
    <th>Purchase By Piece</th>
    <th>Purchase By Bnd 99</th>
    <th>Purchase By Bnd 54</th>
    <th>Purchase By Bnd 70</th>
    <th>Purchase By Bnd 63</th>
    <th>Purchase By Bnd 77</th>
    <th>Purchase By Bnd 49</th>
    <th>Purchase By Bnd 42</th>
    <th>Purchase By Bnd 396</th>
    <th>Purchase By Bnd 510</th>
    <th>Purchase By Bnd 341</th>
    <th>Purchase By Bnd 81</th>
    <th>Purchase By Bnd 72</th>
    <th>Purchase By Bnd 90</th>
</tr></thead>
            <tbody>
<?php $__currentLoopData = $prices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($item->product_id); ?></td>    
    <td><?php echo e($item->schema_id); ?></td>
    <td><?php echo e($item->product_code); ?></td>
    <td><?php echo e($item->product_class); ?></td>
    <td><?php echo e($item->description); ?></td>
    <td><?php echo e($item->retrofit); ?></td>
    <td><?php echo e($item->nailon); ?></td>
    <td><?php echo e($item->block); ?></td>
    <td><?php echo e($item->clr); ?></td>
    <td><?php echo e($item->le3); ?></td>
    <td><?php echo e($item->le3_clr); ?></td>
    <td><?php echo e($item->clr_clr); ?></td>
    <td><?php echo e($item->le3_lam); ?></td>
    <td><?php echo e($item->le3_clr_le3); ?></td>
    <td><?php echo e($item->clr_temp); ?></td>
    <td><?php echo e($item->onele3_1clrtemp); ?></td>
    <td><?php echo e($item->twole3_1clrtemp); ?></td>
    <td><?php echo e($item->lam_temp); ?></td>
    <td><?php echo e($item->clt_clt); ?></td>
    <td><?php echo e($item->let_let_let); ?></td>
    <td><?php echo e($item->le3_lam_le3); ?></td>
    <td><?php echo e($item->let_clt_let); ?></td>
    <td><?php echo e($item->let_lam_let); ?></td>
    <td><?php echo e($item->let_clt); ?></td>
    <td><?php echo e($item->obs); ?></td>
    <td><?php echo e($item->gery); ?></td>
    <td><?php echo e($item->rain); ?></td>
    <td><?php echo e($item->temp); ?></td>
    <td><?php echo e($item->clr_lam); ?></td>
    <td><?php echo e($item->color_multi); ?></td>
    <td><?php echo e($item->base_multi); ?></td>
    <td><?php echo e($item->feat1); ?></td>
    <td><?php echo e($item->feat2); ?></td>
    <td><?php echo e($item->feat3); ?></td>
    <td><?php echo e($item->sta_grd); ?></td>
    <td><?php echo e($item->tpi); ?></td>
    <td><?php echo e($item->tpo); ?></td>
    <td><?php echo e($item->acid_etch); ?></td>
    <td><?php echo e($item->acid_edge); ?></td>
    <td><?php echo e($item->solar_cool); ?></td>
    <td><?php echo e($item->solar_cool_g); ?></td>
    <td><?php echo e($item->sales_factor); ?></td>
    <td><?php echo e($item->total_cost); ?></td>
    <td><?php echo e($item->cost_ft); ?></td>
    <td><?php echo e($item->cost_pc); ?></td>
    <td><?php echo e($item->cost); ?></td>
    <td><?php echo e($item->mark_up); ?></td>
    <td><?php echo e($item->rate); ?></td>
    <td><?php echo e($item->m_cost); ?></td>
    <td><?php echo e($item->calculated_cost); ?></td>
    <td><?php echo e($item->cost_inch); ?></td>
    <td><?php echo e($item->unit_box); ?></td>
    <td><?php echo e($item->price_box); ?></td>
    <td><?php echo e($item->price_piece); ?></td>
    <td><?php echo e($item->box_weight); ?></td>
    <td><?php echo e($item->ft_box); ?></td>
    <td><?php echo e($item->inch_box); ?></td>
    <td><?php echo e($item->price_inch); ?></td>
    <td><?php echo e($item->vent); ?></td>
    <td><?php echo e($item->xfix); ?></td>
    <td><?php echo e($item->fix); ?></td>
    <td><?php echo e($item->grid); ?></td>
    <td><?php echo e($item->lam_im_gx); ?></td>
    <td><?php echo e($item->two_panel_frame); ?></td>
    <td><?php echo e($item->three_panel_frame); ?></td>
    <td><?php echo e($item->four_panel_frame); ?></td>
    <td><?php echo e($item->panel); ?></td>
    <td><?php echo e($item->price_sq_ft); ?></td>
    <td><?php echo e($item->stf); ?></td>
    <td><?php echo e($item->labor_sta); ?></td>
    <td><?php echo e($item->labor_field); ?></td>
    <td><?php echo e($item->profit); ?></td>
    <td><?php echo e($item->purchase_price); ?></td>
    <td><?php echo e($item->markup_percentage); ?></td>
    <td><?php echo e($item->purchase_by_piece); ?></td>
    <td><?php echo e($item->purchase_by_bnd_99); ?></td>
    <td><?php echo e($item->purchase_by_bnd_54); ?></td>
    <td><?php echo e($item->purchase_by_bnd_70); ?></td>
    <td><?php echo e($item->purchase_by_bnd_63); ?></td>
    <td><?php echo e($item->purchase_by_bnd_77); ?></td>
    <td><?php echo e($item->purchase_by_bnd_49); ?></td>
    <td><?php echo e($item->purchase_by_bnd_42); ?></td>
    <td><?php echo e($item->purchase_by_bnd_396); ?></td>
    <td><?php echo e($item->purchase_by_bnd_510); ?></td>
    <td><?php echo e($item->purchase_by_bnd_341); ?></td>
    <td><?php echo e($item->purchase_by_bnd_81); ?></td>
    <td><?php echo e($item->purchase_by_bnd_72); ?></td>
    <td><?php echo e($item->purchase_by_bnd_90); ?></td>
</tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\elitevinyle\resources\views/master/prices/productprices/index.blade.php ENDPATH**/ ?>