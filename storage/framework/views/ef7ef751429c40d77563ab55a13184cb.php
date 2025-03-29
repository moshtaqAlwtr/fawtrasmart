<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label' => 'المنطقة الزمنية',
    'name' => 'timezone',
    'icon' => 'clock',
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
    'label' => 'المنطقة الزمنية',
    'name' => 'timezone',
    'icon' => 'clock',
    'required' => false
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="form-group">
    <label for="<?php echo e($name); ?>"><?php echo e($label); ?></label>
    <div class="position-relative has-icon-left">
        <select class="form-control select2" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>">
            <?php $__currentLoopData = \App\Helpers\TimezoneHelper::getAllTimezones(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>" <?php echo e($key == 'Asia/Riyadh' ? 'selected' : ''); ?>>
                    <?php echo e($timezone); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div class="form-control-position">
            <i class="feather icon-<?php echo e($icon); ?>"></i>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\fawtrasmart\fawtrasmart\resources\views/components/form/timezone-select.blade.php ENDPATH**/ ?>