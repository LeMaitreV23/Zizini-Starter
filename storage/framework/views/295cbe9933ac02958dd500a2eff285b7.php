<?php
    $value = $slot instanceof Illuminate\Support\HtmlString ? $slot->toHtml() : trim((string) $slot);
    $map = [
        'active' => 'bg-green-100 text-green-800', 'approved' => 'bg-green-100 text-green-800', 'verified seller' => 'bg-blue-100 text-blue-800', 'verified' => 'bg-blue-100 text-blue-800',
        'pending' => 'bg-amber-100 text-amber-800', 'awaiting approval' => 'bg-amber-100 text-amber-800', 'not approved' => 'bg-gray-100 text-gray-700',
        'rejected' => 'bg-red-100 text-red-800', 'suspended' => 'bg-red-100 text-red-800', 'sold' => 'bg-gray-200 text-gray-700', 'expired' => 'bg-gray-200 text-gray-700',
        'draft' => 'bg-slate-100 text-slate-700', 'featured' => 'bg-trust/10 text-trust', 'farm/dealer' => 'bg-earth/10 text-earth'
    ];
    $class = $map[strtolower($value)] ?? 'bg-cream text-earth';
?>
<span <?php echo e($attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold $class"])); ?>><?php echo e($slot); ?></span>
<?php /**PATH F:\George Clients\Zizini-starter\resources\views/components/badge.blade.php ENDPATH**/ ?>