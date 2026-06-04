<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label', 'value', 'hint' => '']));

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

foreach (array_filter((['label', 'value', 'hint' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<div class="rounded-xl border border-earth/10 bg-white p-5 shadow-sm">
    <p class="text-sm font-medium text-charcoal/60"><?php echo e($label); ?></p>
    <p class="mt-2 font-display text-3xl text-pasture"><?php echo e($value); ?></p>
    <p class="mt-1 text-xs text-charcoal/60"><?php echo e($hint); ?></p>
</div>
<?php /**PATH F:\George Clients\Zizini-starter\resources\views/components/stat-card.blade.php ENDPATH**/ ?>