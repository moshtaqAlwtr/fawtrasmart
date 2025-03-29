<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label',
    'name',
    'multiple' => false,
    'accept' => '*/*'
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
    'multiple' => false,
    'accept' => '*/*'
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
        <label for="<?php echo e($name); ?>"><?php echo e($label); ?></label>
        <input type="file" name="<?php echo e($name); ?>" id="<?php echo e($name); ?>" class="d-none" <?php echo e($multiple ? 'multiple' : ''); ?> accept="<?php echo e($accept); ?>">
        <div class="upload-area border rounded p-3 text-center position-relative" onclick="document.getElementById('<?php echo e($name); ?>').click()">
            <div class="d-flex align-items-center justify-content-center gap-2">
                <i class="fas fa-cloud-upload-alt text-primary"></i>
                <span class="text-primary">اضغط هنا</span>
                <span>أو</span>
                <span class="text-primary">اختر من جهازك</span>
            </div>
            <div class="position-absolute end-0 top-50 translate-middle-y me-3">
                <i class="fas fa-file-alt fs-3 text-secondary"></i>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\fawtrasmart\fawtrasmart\resources\views/components/form/file.blade.php ENDPATH**/ ?>