<?php if (isset($component)) { $__componentOriginal8a240419d16b3c1a159498153f053ed2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a240419d16b3c1a159498153f053ed2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.main','data' => ['title' => 'Zizini.co.ke']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.main'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Zizini.co.ke']); ?>
    <section class="brand-bg">
        <div class="mx-auto grid max-w-7xl items-center gap-8 px-4 py-10 lg:grid-cols-[1fr_.75fr] lg:px-8 lg:py-14">
            <div>
                <h1 class="font-display text-4xl leading-tight text-charcoal md:text-5xl">Welcome to <span class="text-pasture">Zizini Livestock Market</span></h1>
                <p class="mt-3 font-display text-2xl italic text-earth">Uza Nunua Mifugo hapa</p>
                <p class="mt-4 max-w-2xl text-lg text-charcoal/75">Browse live livestock listings from trusted sellers across Kenya. View photos, compare prices, and contact the owner directly by call or WhatsApp.</p>
                <form action="/marketplace" class="mt-6 grid gap-3 rounded-2xl border border-earth/10 bg-white p-4 shadow-lg md:grid-cols-[1fr_1fr_1fr_auto]">
                    <input name="q" class="rounded-lg border border-earth/20 px-4 py-3" placeholder="Search livestock...">
                    <select name="category" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">Animal type</option><?php $__currentLoopData = collect($categories)->where('group_slug', 'livestock'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option><?php echo e($cat['name']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                    <select name="county" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">County</option><?php $__currentLoopData = $counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option><?php echo e($county['name']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                    <button class="rounded-lg bg-pasture px-6 py-3 font-bold text-white">Search</button>
                </form>
                <div class="mt-5 flex flex-wrap gap-3"><a href="/marketplace?type=animal" class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Browse Livestock</a><a href="/seller/register" class="rounded-lg border border-pasture px-5 py-3 font-bold text-pasture">Sell Livestock</a></div>
            </div>
            <div class="relative mx-auto w-full max-w-md">
                <div class="rounded-3xl bg-white p-8 shadow-2xl">
                    <div class="mx-auto grid h-44 w-44 place-items-center rounded-full bg-cream shadow-inner">
                        <img src="/assets/brand/logo-symbol.png" class="h-32 w-32 object-contain" alt="Zizini logo">
                    </div>
                    <img src="/assets/livestock/cow-ayrshire.jpg" class="mt-6 aspect-[16/9] w-full rounded-2xl object-cover" alt="Livestock marketplace">
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
        <div class="flex items-end justify-between gap-4"><div><h2 class="font-display text-3xl text-pasture">Featured Livestock</h2><p class="mt-1 text-charcoal/65">Approved animal listings with direct owner contact.</p></div><a class="font-bold text-pasture" href="/marketplace?type=animal">View all</a></div>
        <div class="mt-6 grid gap-5 md:grid-cols-2 lg:grid-cols-4"><?php $__currentLoopData = $featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if (isset($component)) { $__componentOriginal31ec1dc5dadb4835ef50de3d88e519ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal31ec1dc5dadb4835ef50de3d88e519ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listing-card','data' => ['listing' => $listing]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('listing-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing)]); ?>
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
    </section>

    <section class="bg-white py-10">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h2 class="font-display text-3xl text-pasture">Browse Marketplace</h2>
            <div class="mt-6 grid gap-5 md:grid-cols-3">
                <?php $__currentLoopData = [
                    ['Livestock','Cattle, goats, sheep, poultry and other animals.','View Livestock','/marketplace?type=animal','/assets/livestock/cow-field-real.jpg'],
                    ['Feeds & Farm Inputs','Hay, silage, dairy meal, poultry feed and farm supplies.','View Feeds','/marketplace?type=feed','/assets/feeds/hay-silage.jpg'],
                    ['Livestock Services','Transport, vet services, breeding help and farm support.','View Services','/marketplace?type=service','/assets/services/livestock-market-support.jpg'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($card[3]); ?>" class="overflow-hidden rounded-2xl border border-earth/10 bg-cream shadow-sm transition hover:-translate-y-1 hover:border-pasture hover:shadow-lg">
                        <img src="<?php echo e($card[4]); ?>" class="aspect-[16/9] w-full object-cover" alt="<?php echo e($card[0]); ?>">
                        <div class="p-5"><h3 class="font-display text-2xl text-pasture"><?php echo e($card[0]); ?></h3><p class="mt-2 text-sm text-charcoal/65"><?php echo e($card[1]); ?></p><span class="mt-5 inline-flex rounded-lg bg-pasture px-4 py-2 text-sm font-bold text-white"><?php echo e($card[2]); ?></span></div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-5 px-4 py-10 lg:grid-cols-4 lg:px-8">
        <?php $__currentLoopData = ['Search livestock' => 'Find animals by type, county or price.', 'View details' => 'Check photos, price, location and owner contact.', 'Contact owner' => 'Call or WhatsApp the owner directly.', 'Inspect safely' => 'Visit, confirm details and agree offline.']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="rounded-xl border border-earth/10 bg-white p-6 shadow-sm"><div class="mb-4 grid h-12 w-12 place-items-center rounded-full bg-fresh/20 text-xl font-bold text-pasture">✓</div><h3 class="font-display text-xl"><?php echo e($step); ?></h3><p class="mt-2 text-sm text-charcoal/65"><?php echo e($text); ?></p></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </section>

    <section class="bg-pasture py-10 text-white">
        <div class="mx-auto grid max-w-7xl gap-5 px-4 md:grid-cols-4 lg:px-8">
            <?php $__currentLoopData = ['Approved Listings' => 'Listings are reviewed before going live.', 'Direct Owner Contact' => 'Call or WhatsApp the seller directly.', 'Search by County' => 'Find animals closer to you.', 'Safer Marketplace' => 'Report suspicious listings anytime.']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trust => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="rounded-xl bg-white/10 p-5"><p class="font-display text-xl"><?php echo e($trust); ?></p><p class="mt-2 text-sm text-white/75"><?php echo e($text); ?></p></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
        <h2 class="font-display text-3xl text-pasture">Browse Counties</h2>
        <div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-6"><?php $__currentLoopData = $counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><a href="/counties/<?php echo e($county['slug']); ?>" class="rounded-lg bg-white p-4 font-semibold shadow-sm"><?php echo e($county['name']); ?> <span class="mt-2 block text-sm font-normal text-charcoal/55"><?php echo e($county['count']); ?> listings</span><span class="mt-3 inline-flex text-sm font-bold text-pasture">View listings</span></a><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
        <div class="mt-10 rounded-2xl bg-white p-8 shadow-sm md:flex md:items-center md:justify-between"><div><h2 class="font-display text-3xl text-pasture">Have livestock, feeds or services to list?</h2><p class="mt-2 text-charcoal/65">Join as a seller. Once approved, you can post listings and receive calls or WhatsApp inquiries.</p></div><a href="/seller/register" class="mt-5 inline-flex rounded-lg bg-pasture px-5 py-3 font-bold text-white md:mt-0">Join as Seller</a></div>
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
<?php /**PATH F:\George Clients\Zizini-starter\resources\views/public/home.blade.php ENDPATH**/ ?>