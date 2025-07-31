<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['code' => 'XO', 'width' => 60, 'height' => 48]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['code' => 'XO', 'width' => 60, 'height' => 48]); ?>
<?php foreach (array_filter((['code' => 'XO', 'width' => 60, 'height' => 48]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $codeParts = explode('-', $code);
    $segments = array_filter($codeParts, fn($p) => !in_array($p, ['T1', 'B1']));
    $hasTop = in_array('T1', $codeParts);
    $hasBottom = in_array('B1', $codeParts);
    $paneCount = count($segments);

    $svgWidth = 300;
    $svgHeight = 250;
    $paneWidth = $svgWidth / $paneCount;
    $paneY = $hasTop ? 50 : 0;
    $paneHeight = $svgHeight - ($hasTop ? 50 : 0) - ($hasBottom ? 50 : 0);
?>

<svg width="<?php echo e($svgWidth); ?>" height="<?php echo e($svgHeight); ?>" xmlns="http://www.w3.org/2000/svg" style="border:1px solid #ccc; background:#fff;">

    
    <?php if($hasTop): ?>
        <rect x="0" y="0" width="<?php echo e($svgWidth); ?>" height="50" fill="#cce6f6" />
        <line x1="0" y1="50" x2="<?php echo e($svgWidth); ?>" y2="50" stroke="#000" stroke-width="1" />
    <?php endif; ?>

    
    <?php $__currentLoopData = $segments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $pane): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $x = $i * $paneWidth;
            $isX = $pane === 'X';
            $fill = $isX ? '#cce6f6' : '#e0e0e0';
        ?>

        <rect x="<?php echo e($x); ?>" y="<?php echo e($paneY); ?>" width="<?php echo e($paneWidth); ?>" height="<?php echo e($paneHeight); ?>" fill="<?php echo e($fill); ?>" stroke="#000" stroke-width="1"/>

        
        <?php if($isX): ?>
            <?php for($g = 1; $g < 4; $g++): ?>
                <line x1="<?php echo e($x + $g * ($paneWidth / 4)); ?>" y1="<?php echo e($paneY); ?>" x2="<?php echo e($x + $g * ($paneWidth / 4)); ?>" y2="<?php echo e($paneY + $paneHeight); ?>" stroke="#99cbee" stroke-width="0.5" />
            <?php endfor; ?>
            <?php for($g = 1; $g < 4; $g++): ?>
                <line x1="<?php echo e($x); ?>" y1="<?php echo e($paneY + $g * ($paneHeight / 4)); ?>" x2="<?php echo e($x + $paneWidth); ?>" y2="<?php echo e($paneY + $g * ($paneHeight / 4)); ?>" stroke="#99cbee" stroke-width="0.5" />
            <?php endfor; ?>

            
           <?php
    $yMid = $paneY + $paneHeight / 2;
    $yUp = $yMid - 10;
    $yDown = $yMid + 10;
    $xArrow = $arrowDir === 'right' ? $arrowX + 20 : $arrowX - 20;

    $arrowPoints = "$arrowX,$yMid $arrowX,$yUp $xArrow,$yMid $arrowX,$yDown";
?>

            <polygon points="<?php echo e($arrowPoints); ?>" fill="#444" />
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <?php if($hasBottom): ?>
        <line x1="0" y1="<?php echo e($svgHeight - 50); ?>" x2="<?php echo e($svgWidth); ?>" y2="<?php echo e($svgHeight - 50); ?>" stroke="#000" stroke-width="1" />
        <rect x="0" y="<?php echo e($svgHeight - 50); ?>" width="<?php echo e($svgWidth); ?>" height="50" fill="#cce6f6" />
    <?php endif; ?>

    
    <text x="10" y="<?php echo e($svgHeight - 10); ?>" font-size="12" fill="#555">
        <?php echo e($code); ?> — <?php echo e($width); ?>" x <?php echo e($height); ?>"
    </text>
</svg>


























<?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/components/window-config.blade.php ENDPATH**/ ?>