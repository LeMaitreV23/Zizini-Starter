<?php if (isset($component)) { $__componentOriginal16d5847f731ff3719af1cada32a6eea3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16d5847f731ff3719af1cada32a6eea3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.seller','data' => ['title' => 'Seller Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.seller'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Seller Dashboard']); ?>
    <?php
        $sellerStatusLabels = ['Live', 'Unverified', 'Pending', 'Sold', 'Expired'];
        $sellerStatusValues = [
            $sellerStats['active'] ?? 0,
            $sellerStats['unverified'] ?? 0,
            $sellerStats['pending'] ?? 0,
            $sellerStats['sold'] ?? 0,
            $sellerStats['expired'] ?? 0,
        ];
        $usedAllowance = (int) $seller['listing_allowance_used'];
        $remainingAllowance = (int) $seller['listing_allowance_remaining'];
    ?>
    <section class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-bold text-earth">Seller workspace</p>
                <h1 class="mt-2 font-display text-4xl text-pasture">Seller Dashboard</h1>
                <p class="mt-2 text-charcoal/65"><?php echo e($seller['name']); ?> - <?php echo e($seller['posting_status']); ?> - Access expires <?php echo e($seller['access_end_date']); ?></p>
            </div>
            <?php if($seller['can_post']): ?>
                <a href="<?php echo e(route('seller.create.type')); ?>" class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Post New Listing</a>
            <?php else: ?>
                <div class="rounded-lg bg-amber-50 px-5 py-3 text-sm font-bold text-amber-900">Posting locked. You can still manage and review your dashboard.</div>
            <?php endif; ?>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Live listings','value' => $sellerStats['active'] ?? 0,'hint' => 'Active + unverified']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Live listings','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sellerStats['active'] ?? 0),'hint' => 'Active + unverified']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Unverified','value' => $sellerStats['unverified'] ?? 0,'hint' => 'Live, awaiting admin badge']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Unverified','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sellerStats['unverified'] ?? 0),'hint' => 'Live, awaiting admin badge']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Sold','value' => $sellerStats['sold'] ?? 0,'hint' => 'Marked by seller']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Sold','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sellerStats['sold'] ?? 0),'hint' => 'Marked by seller']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Contact clicks','value' => $sellerStats['clicks'] ?? 0,'hint' => 'Buyer interest']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Contact clicks','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sellerStats['clicks'] ?? 0),'hint' => 'Buyer interest']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Allowance left','value' => $seller['listing_allowance_remaining'],'hint' => 'Out of '.e($seller['listing_allowance_total']).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Allowance left','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seller['listing_allowance_remaining']),'hint' => 'Out of '.e($seller['listing_allowance_total']).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <h2 class="font-display text-2xl text-pasture">Listing Performance</h2>
                <p class="mt-1 text-sm text-charcoal/60">Status breakdown across your current listings.</p>
                <div class="mt-4 h-72"><canvas id="sellerStatusChart"></canvas></div>
            </section>
            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <h2 class="font-display text-2xl text-pasture">Posting Allowance</h2>
                <p class="mt-1 text-sm text-charcoal/60">How much posting access remains.</p>
                <div class="mt-4 h-72"><canvas id="allowanceChart"></canvas></div>
            </section>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_360px]">
            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-earth/10 pb-4">
                    <div>
                        <h2 class="font-display text-2xl text-pasture">Recent Listings</h2>
                        <p class="mt-1 text-sm text-charcoal/60">Auto-published listings can be active before admin verification.</p>
                    </div>
                    <a href="<?php echo e(route('seller.listings')); ?>" class="text-sm font-bold text-pasture">Manage all</a>
                </div>
                <div class="mt-4 grid gap-3">
                    <?php $__empty_1 = true; $__currentLoopData = $recentListings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between gap-3 rounded-xl border border-earth/10 p-3">
                            <div class="flex min-w-0 items-center gap-3">
                                <img src="<?php echo e($listing['images'][0]); ?>" class="h-14 w-16 rounded-lg object-cover" alt="">
                                <div class="min-w-0"><strong class="block truncate"><?php echo e($listing['title']); ?></strong><p class="text-sm text-charcoal/60"><?php echo e($listing['county']); ?> - <?php echo e($listing['expiry_date']); ?></p></div>
                            </div>
                            <?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
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
<?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-charcoal/60">No listings yet.</p>
                    <?php endif; ?>
                </div>
            </section>

            <aside class="space-y-6">
                <section class="rounded-2xl bg-white p-6 shadow-sm">
                    <h2 class="font-display text-2xl text-pasture">Access Status</h2>
                    <div class="mt-4 grid gap-3 text-sm">
                        <div class="rounded-lg bg-cream p-3"><strong>Posting status</strong><p><?php echo e($seller['posting_status']); ?></p></div>
                        <div class="rounded-lg bg-cream p-3"><strong>Access window</strong><p><?php echo e($seller['access_start_date']); ?> to <?php echo e($seller['access_end_date']); ?></p></div>
                        <div class="rounded-lg bg-cream p-3"><strong>Listing allowance</strong><p><?php echo e($seller['listing_allowance_used']); ?> used / <?php echo e($seller['listing_allowance_total']); ?> total</p></div>
                    </div>
                </section>
                <section class="rounded-2xl bg-white p-6 shadow-sm">
                    <h2 class="font-display text-2xl text-pasture">Recent Inquiries</h2>
                    <div class="mt-4 grid gap-3">
                        <?php $__empty_1 = true; $__currentLoopData = $recentInquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="rounded-lg border border-earth/10 p-3 text-sm"><strong><?php echo e($inquiry->listing?->title); ?></strong><p class="text-charcoal/60"><?php echo e(ucfirst($inquiry->channel)); ?> - <?php echo e($inquiry->created_at?->format('d M Y')); ?></p></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-charcoal/60">No inquiries recorded yet.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </aside>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const colors = ['#2F6B3D', '#7FBF3F', '#D97706', '#2D6CDF', '#7A5C3E'];
            const baseOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { labels: { boxWidth: 10, font: { family: 'Inter' } } } }
            };
            new Chart(document.getElementById('sellerStatusChart'), {
                type: 'bar',
                data: { labels: <?php echo json_encode($sellerStatusLabels, 15, 512) ?>, datasets: [{ data: <?php echo json_encode($sellerStatusValues, 15, 512) ?>, backgroundColor: '#2F6B3D', borderRadius: 8 }] },
                options: { ...baseOptions, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
            });
            new Chart(document.getElementById('allowanceChart'), {
                type: 'doughnut',
                data: { labels: ['Used', 'Remaining'], datasets: [{ data: <?php echo json_encode([$usedAllowance, $remainingAllowance], 512) ?>, backgroundColor: ['#7A5C3E', '#7FBF3F'], borderWidth: 0 }] },
                options: { ...baseOptions, cutout: '62%' }
            });
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16d5847f731ff3719af1cada32a6eea3)): ?>
<?php $attributes = $__attributesOriginal16d5847f731ff3719af1cada32a6eea3; ?>
<?php unset($__attributesOriginal16d5847f731ff3719af1cada32a6eea3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16d5847f731ff3719af1cada32a6eea3)): ?>
<?php $component = $__componentOriginal16d5847f731ff3719af1cada32a6eea3; ?>
<?php unset($__componentOriginal16d5847f731ff3719af1cada32a6eea3); ?>
<?php endif; ?>
<?php /**PATH F:\George Clients\Zizini-starter\resources\views/seller/dashboard.blade.php ENDPATH**/ ?>