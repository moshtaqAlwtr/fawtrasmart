<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => '',
    'tools' => ''
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => '',
    'tools' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="card">
    <?php if($title): ?>
    <div class="card-header">
        <h4 class="card-title"><?php echo e($title); ?></h4>
        <?php if($tools): ?>
        <div class="card-tools">
            <?php echo e($tools); ?>

        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="card-content">
        <div class="card-body">
            <?php echo e($slot); ?>

        </div>
    </div>
</div>
<?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/components/layout/card.blade.php ENDPATH**/ ?>