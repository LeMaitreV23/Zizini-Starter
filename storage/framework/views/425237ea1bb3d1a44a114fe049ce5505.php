<?php if (isset($component)) { $__componentOriginal8a240419d16b3c1a159498153f053ed2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a240419d16b3c1a159498153f053ed2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.main','data' => ['title' => 'Seller Login']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.main'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Seller Login']); ?>
    <section class="mx-auto max-w-md px-4 py-16">
        <div class="rounded-3xl bg-white p-8 shadow-sm">
            <p class="text-sm font-bold text-earth">Seller portal</p>
            <h1 class="mt-2 font-display text-3xl text-pasture">Seller Login</h1>
            <p class="mt-2 text-sm text-charcoal/65">Use this page for reseller, farm, feed seller, and service provider accounts.</p>
            <form action="<?php echo e(route('login.store')); ?>" method="post" class="mt-6 grid gap-4">
                <?php echo csrf_field(); ?>
                <input name="login" class="rounded-lg border border-earth/20 p-3" placeholder="Seller email or phone" required>
                <input name="password" class="rounded-lg border border-earth/20 p-3" placeholder="Password" type="password" required>
                <button class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Login as Seller</button>
            </form>
            <div class="mt-5 grid gap-2 text-sm font-semibold sm:grid-cols-2">
                <a href="/seller/register" class="text-pasture">Register as seller</a>
                <a href="/admin/login" class="text-earth sm:text-right">Admin login</a>
                <a href="/contact" class="text-earth sm:col-span-2">Need login help?</a>
            </div>
        </div>
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
<?php /**PATH F:\George Clients\Zizini-starter\resources\views/seller/login.blade.php ENDPATH**/ ?>