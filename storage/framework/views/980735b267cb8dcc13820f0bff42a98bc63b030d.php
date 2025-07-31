<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>HS Unit Records</h1>
    <a href="<?php echo e(route('hs-unit.create')); ?>" class="btn btn-primary mb-3">Add New HS Unit</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Schema Id</th>
                <th>Retrofit</th>
                <th>Nailon</th>
                <th>Block</th>
                <th>Le3 Clr</th>
                <th>Clr Clr</th>
                <th>Le3 Lam</th>
                <th>Le3 Clr Le3</th>
                <th>Clr Temp</th>
                <th>Onele3 Oneclr Temp</th>
                <th>Twole3 Oneclr Temp</th>
                <th>Lam Temp</th>
                <th>Obs</th>
                <th>Feat2</th>
                <th>Feat3</th>
                <th>Sta Grd</th>
                <th>Tpi</th>
                <th>Tpo</th>
                <th>Acid Etch</th>
                <th>Solar Cool</th>
                <th>Solar Cool G</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $hsunits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hsunit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($hsunit->id); ?></td>
                <td>{ $hsunit->schema_id }</td>
                <td>{ $hsunit->retrofit }</td>
                <td>{ $hsunit->nailon }</td>
                <td>{ $hsunit->block }</td>
                <td>{ $hsunit->le3_clr }</td>
                <td>{ $hsunit->clr_clr }</td>
                <td>{ $hsunit->le3_lam }</td>
                <td>{ $hsunit->le3_clr_le3 }</td>
                <td>{ $hsunit->clr_temp }</td>
                <td>{ $hsunit->onele3_oneclr_temp }</td>
                <td>{ $hsunit->twole3_oneclr_temp }</td>
                <td>{ $hsunit->lam_temp }</td>
                <td>{ $hsunit->obs }</td>
                <td>{ $hsunit->feat2 }</td>
                <td>{ $hsunit->feat3 }</td>
                <td>{ $hsunit->sta_grd }</td>
                <td>{ $hsunit->tpi }</td>
                <td>{ $hsunit->tpo }</td>
                <td>{ $hsunit->acid_etch }</td>
                <td>{ $hsunit->solar_cool }</td>
                <td>{ $hsunit->solar_cool_g }</td>
                <td><?php echo e($hsunit->status); ?></td>
                <td>
                    <a href="<?php echo e(route('hs-unit.edit', $hsunit->id)); ?>" class="btn btn-sm btn-warning">Edit</a>
                    <form action="<?php echo e(route('hs-unit.destroy', $hsunit->id)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/schemas/hs-unit/index.blade.php ENDPATH**/ ?>