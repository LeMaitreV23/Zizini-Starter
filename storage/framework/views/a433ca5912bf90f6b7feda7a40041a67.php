<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['listing']));

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

foreach (array_filter((['listing']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<article class="overflow-hidden rounded-xl border border-earth/10 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" x-data="{fav:false,contact:false}">
    <div class="relative aspect-[4/3] overflow-hidden">
        <img src="<?php echo e($listing['images'][0]); ?>" alt="<?php echo e($listing['title']); ?>" class="h-full w-full object-cover">
        <div class="absolute left-3 top-3 flex flex-wrap gap-2">
            <?php if($listing['featured']): ?><?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Featured <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?><?php endif; ?>
            <?php if($listing['seller_verified']): ?><?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Verified <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?><?php endif; ?>
        </div>
        <button @click="fav=!fav" class="absolute right-3 top-3 grid h-10 w-10 place-items-center rounded-full bg-white text-lg shadow" :class="fav ? 'text-red-600' : 'text-earth'" aria-label="Save listing">♡</button>
    </div>
    <div class="p-4">
        <div class="flex items-center justify-between gap-3">
            <p class="text-xs font-extrabold uppercase tracking-wide text-earth"><?php echo e($listing['type_label'] ?? 'Animal'); ?> · <?php echo e($listing['category']); ?></p>
            <?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e($listing['status'] === 'active' ? 'Active' : ucfirst($listing['status'])); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
        </div>
        <h3 class="mt-2 font-display text-xl leading-tight"><?php echo e($listing['title']); ?></h3>
        <p class="mt-3 text-xl font-extrabold text-trust"><?php echo e(($listing['price_type'] ?? 'negotiable') === 'quote' || $listing['price'] <= 0 ? 'Contact for quote' : 'KSh '.number_format($listing['price'])); ?></p>
        <p class="mt-3 text-sm text-charcoal/65"><?php echo e($listing['county']); ?> <span class="mx-1">•</span> <?php echo e(($listing['listing_type'] ?? 'animal') === 'service' ? 'Provider service' : ($listing['breed'] ?: $listing['category'])); ?> <span class="mx-1">•</span> <?php echo e(($listing['listing_type'] ?? 'animal') === 'feed' ? 'Farm input' : ($listing['sex'] ?: 'Available')); ?></p>
        <div class="mt-4 grid gap-2">
            <a href="/livestock/<?php echo e($listing['slug']); ?>" class="rounded-lg bg-pasture px-4 py-3 text-center text-sm font-extrabold text-white">View Details</a>
            <button @click="contact=true" class="text-sm font-bold text-pasture"><?php echo e(($listing['listing_type'] ?? 'animal') === 'service' ? 'Contact Provider' : (($listing['listing_type'] ?? 'animal') === 'feed' ? 'Contact Seller' : 'Contact Owner')); ?></button>
        </div>
    </div>
    <div x-cloak x-show="contact" class="fixed inset-0 z-50 grid place-items-center bg-black/40 p-4">
        <div @click.outside="contact=false" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
            <h3 class="font-display text-xl text-pasture"><?php echo e(($listing['listing_type'] ?? 'animal') === 'service' ? 'Contact Provider' : (($listing['listing_type'] ?? 'animal') === 'feed' ? 'Contact Seller' : 'Contact Owner')); ?></h3>
            <p class="mt-2 text-sm text-charcoal/70"><?php echo e($listing['seller_name']); ?> · <?php echo e($listing['seller_phone']); ?></p>
            <form method="post" action="<?php echo e(route('livestock.inquiries.store', $listing['id'])); ?>" class="mt-4">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="channel" value="form">
                <div class="grid gap-2 sm:grid-cols-2">
                    <input name="name" class="rounded-lg border border-earth/20 p-3 text-sm" placeholder="Your name">
                    <input name="phone" class="rounded-lg border border-earth/20 p-3 text-sm" placeholder="Your phone">
                </div>
                <textarea name="message" class="mt-3 w-full rounded-lg border border-earth/20 p-3 text-sm" rows="4">Hello, I saw your <?php echo e($listing['title']); ?> on Zizini.co.ke. Is it still available?</textarea>
            <div class="mt-4 flex gap-2">
                <button class="flex-1 rounded-lg bg-pasture px-4 py-3 text-center text-sm font-bold text-white">Send Inquiry</button>
                <button @click="contact=false" class="rounded-lg bg-cream px-4 py-3 text-sm font-bold">Close</button>
            </div>
            </form>
        </div>
    </div>
</article>
<?php /**PATH F:\George Clients\Zizini-starter\resources\views/components/listing-card.blade.php ENDPATH**/ ?>