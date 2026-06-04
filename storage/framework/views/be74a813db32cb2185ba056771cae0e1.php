<?php if (isset($component)) { $__componentOriginal8a240419d16b3c1a159498153f053ed2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a240419d16b3c1a159498153f053ed2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.main','data' => ['title' => ''.e($listing['title']).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.main'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($listing['title']).'']); ?>
    <?php ($contactLabel = ($listing['listing_type'] ?? 'animal') === 'service' ? 'Provider' : ((($listing['listing_type'] ?? 'animal') === 'feed') ? 'Seller' : 'Owner')); ?>
    <section class="mx-auto max-w-7xl px-4 py-10 lg:px-8" x-data="{contact:false,report:false,fav:false,shared:false}">
        <a href="<?php echo e(route('marketplace')); ?>" class="mb-5 inline-flex rounded-lg bg-white px-4 py-2 text-sm font-bold text-earth shadow-sm">&larr; Back to Marketplace</a>
        <div class="grid gap-8 lg:grid-cols-[1.2fr_.8fr]">
            <div>
                <img src="<?php echo e($listing['images'][0]); ?>" class="aspect-[16/10] w-full rounded-2xl object-cover shadow-xl" alt="<?php echo e($listing['title']); ?>">
                <div class="mt-3 grid grid-cols-3 gap-3">
                    <?php $__currentLoopData = $listing['images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e($image); ?>" class="aspect-video rounded-xl object-cover" alt="">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="rounded-2xl border border-earth/10 bg-white p-6 shadow-sm">
                <div class="flex flex-wrap gap-2"><?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e($listing['type_label'] ?? 'Animal'); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?><?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e(ucfirst(str_replace('_', ' ', $listing['status']))); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?><?php if($listing['featured']): ?><?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
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
<?php endif; ?><?php endif; ?></div>
                <h1 class="mt-4 font-display text-4xl text-pasture"><?php echo e($listing['title']); ?></h1>
                <p class="mt-2 text-2xl font-extrabold text-trust"><?php echo e(($listing['price_type'] ?? 'negotiable') === 'quote' || $listing['price'] <= 0 ? 'Contact for quote' : 'KSh '.number_format($listing['price'])); ?></p>
                <p class="mt-3 text-charcoal/70"><?php echo e($listing['location']); ?>, <?php echo e($listing['county']); ?></p>
                <div class="mt-6 grid grid-cols-2 gap-3 text-sm">
                    <?php $__currentLoopData = ['Type'=>$listing['type_label'] ?? 'Animal','Category'=>$listing['category'],'Details'=>$listing['breed'],'Availability'=>$listing['age'],'Contact type'=>$listing['sex'],'Unit / weight'=>$listing['weight'] ?? 'Optional','Quantity / quote'=>$listing['milk_production'] ?? 'N/A','Quality / health'=>$listing['health_status']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="rounded-lg bg-cream p-3"><span class="block text-xs font-bold uppercase text-earth"><?php echo e($k); ?></span><?php echo e($v ?: 'N/A'); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="mt-6 grid gap-2 sm:grid-cols-3">
                    <button @click="contact=true" class="rounded-lg bg-pasture px-4 py-3 font-bold text-white">Contact <?php echo e($contactLabel); ?></button>
                    <a href="<?php echo e(route('livestock.contact.redirect', [$listing['id'], 'call'])); ?>" class="rounded-lg bg-cream px-4 py-3 text-center font-bold text-earth">Call <?php echo e($contactLabel); ?></a>
                    <a href="<?php echo e(route('livestock.contact.redirect', [$listing['id'], 'whatsapp'])); ?>" class="rounded-lg bg-green-50 px-4 py-3 text-center font-bold text-pasture">WhatsApp <?php echo e($contactLabel); ?></a>
                </div>
                <div class="mt-3 flex gap-2"><button @click="fav=!fav" class="rounded-lg border border-earth/10 px-3 py-2 text-sm font-bold" x-text="fav ? 'Saved' : 'Favorite'"></button><button @click="shared=true" class="rounded-lg border border-earth/10 px-3 py-2 text-sm font-bold" x-text="shared ? 'Link copied' : 'Share'"></button><button @click="report=true" class="rounded-lg border border-red-100 px-3 py-2 text-sm font-bold text-red-700">Report Listing</button></div>
            </div>
        </div>
        <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_360px]">
            <div class="rounded-2xl bg-white p-6 shadow-sm"><h2 class="font-display text-2xl text-pasture">Description</h2><p class="mt-3 text-charcoal/75"><?php echo e($listing['description']); ?></p><div class="mt-6 rounded-xl bg-cream p-4 text-sm text-earth">Zizini connects buyers and sellers. Always inspect the animal, product, or service provider, verify ownership or availability, and agree safely offline.</div></div>
            <div class="rounded-2xl bg-white p-6 shadow-sm"><h2 class="font-display text-2xl text-pasture"><?php echo e($contactLabel); ?></h2><div class="mt-3 flex items-center gap-3"><img src="<?php echo e($listing['seller_logo'] ?? '/assets/brand/logo-symbol.png'); ?>" class="h-14 w-14 rounded-xl border border-earth/10 object-contain p-1" alt="<?php echo e($listing['seller_name']); ?> logo"><div><p class="font-bold"><?php echo e($listing['seller_name']); ?></p><?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e($listing['seller_badge']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?></div></div><p class="mt-3 text-sm text-charcoal/65">Posted recently - Expires: <?php echo e($listing['expiry_date']); ?></p></div>
        </div>
        <h2 class="mt-10 font-display text-2xl text-pasture">Similar listings</h2><div class="mt-4 grid gap-5 md:grid-cols-3"><?php $__currentLoopData = $similar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if (isset($component)) { $__componentOriginal31ec1dc5dadb4835ef50de3d88e519ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal31ec1dc5dadb4835ef50de3d88e519ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listing-card','data' => ['listing' => $item]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('listing-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal31ec1dc5dadb4835ef50de3d88e519ce)): ?>
<?php $attributes = $__attributesOriginal31ec1dc5dadb4835ef50de3d88e519ce; ?>
<?php unset($__attributesOriginal31ec1dc5dadb4835ef50de3d88e519ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal31ec1dc5dadb4835ef50de3d88e519ce)): ?>
<?php $component = $__componentOriginal31ec1dc5dadb4835ef50de3d88e519ce; ?>
<?php unset($__componentOriginal31ec1dc5dadb4835ef50de3d88e519ce); ?>
<?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
        <div x-cloak x-show="contact||report" class="fixed inset-0 z-50 grid place-items-center bg-black/40 p-4">
            <div @click.outside="contact=report=false" class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl">
                <h3 class="font-display text-2xl text-pasture" x-text="report ? 'Report Listing' : 'Contact <?php echo e($contactLabel); ?>'"></h3>
                <p class="mt-2 text-sm"><?php echo e($listing['seller_name']); ?> - send an inquiry through Zizini.</p>
                <form x-show="!report" method="post" action="<?php echo e(route('livestock.inquiries.store', $listing['id'])); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="channel" value="form">
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <input name="name" class="rounded-lg border border-earth/20 p-3" placeholder="Your name">
                        <input name="phone" class="rounded-lg border border-earth/20 p-3" placeholder="Your phone">
                    </div>
                    <input name="email" class="mt-3 w-full rounded-lg border border-earth/20 p-3" placeholder="Your email optional">
                    <textarea name="message" class="mt-4 w-full rounded-lg border border-earth/20 p-3" rows="4">Hello, I saw your listing on Zizini.co.ke. Is it still available?</textarea>
                    <button class="mt-4 inline-flex rounded-lg bg-pasture px-5 py-3 font-bold text-white">Send Inquiry</button>
                </form>
                <form x-show="report" method="post" action="<?php echo e(route('livestock.reports.store', $listing['id'])); ?>">
                    <?php echo csrf_field(); ?>
                    <textarea name="reason" class="mt-4 w-full rounded-lg border border-earth/20 p-3" rows="4" placeholder="Why are you reporting this listing?" required></textarea>
                    <input name="reporter_contact" class="mt-3 w-full rounded-lg border border-earth/20 p-3" placeholder="Your email or phone optional">
                    <button class="mt-4 inline-flex rounded-lg bg-red-700 px-5 py-3 font-bold text-white">Submit Report</button>
                </form>
                <button @click="contact=report=false" class="ml-2 rounded-lg bg-cream px-5 py-3 font-bold">Close</button>
            </div>
        </div>
        <div class="fixed inset-x-0 bottom-0 z-30 grid grid-cols-3 gap-2 bg-white p-3 shadow-2xl lg:hidden"><button @click="contact=true" class="rounded-lg bg-pasture py-3 font-bold text-white">Contact</button><a href="<?php echo e(route('livestock.contact.redirect', [$listing['id'], 'call'])); ?>" class="rounded-lg bg-cream py-3 text-center font-bold">Call</a><a href="<?php echo e(route('livestock.contact.redirect', [$listing['id'], 'whatsapp'])); ?>" class="rounded-lg bg-green-50 py-3 text-center font-bold text-pasture">WhatsApp</a></div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a240419d16b3c1a159498153f053ed2)): ?>
<?php $attributes = $__attributesOriginal8a240419d16b3c1a159498153f053ed2; ?>
<?php unset($__attributesOriginal8a240419d16b3c1a159498153f053ed2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a240419d16b3c1a159498153f053ed2)): ?>
<?php $component = $__componentOriginal8a240419d16b3c1a159498153f053ed2; ?>
<?php unset($__componentOriginal8a240419d16b3c1a159498153f053ed2); ?>
<?php endif; ?>
<?php /**PATH F:\George Clients\Zizini-starter\resources\views/public/listing-detail.blade.php ENDPATH**/ ?>