<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label',
    'name',
    'icon' => 'chevron-down',
    'required' => false
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
    'label',
    'name',
    'icon' => 'chevron-down',
    'required' => false
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="col-<?php echo e($attributes->get('col', '12')); ?> mb-3">
    <div class="form-group">
        <label for="<?php echo e($name); ?>"><?php echo e($label); ?> <?php if($required): ?><span class="text-danger">*</span><?php endif; ?></label>
        <div class="position-relative has-icon-left">
            <select class="form-control <?php echo e($attributes->get('class', '')); ?>" 
                    id="<?php echo e($name); ?>" 
                    name="<?php echo e($name); ?>"
                    <?php echo e($attributes); ?>>
                <?php echo e($slot); ?>

            </select>
            <div class="form-control-position">
                <i class="feather icon-<?php echo e($icon); ?>"></i>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/components/form/select.blade.php ENDPATH**/ ?>