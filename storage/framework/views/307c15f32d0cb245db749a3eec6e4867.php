<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Admin Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Admin Dashboard']); ?>
    <?php
        $statusCounts = collect($dashboardData['statusCounts'] ?? []);
        $categoryCounts = collect($dashboardData['categoryCounts'] ?? []);
        $countyCounts = collect($dashboardData['countyCounts'] ?? []);
    ?>
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-4xl text-pasture">Admin Dashboard</h1>
            <p class="mt-2 text-charcoal/65">Live operational view for sellers, listings, reports, access windows, and moderation.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="<?php echo e(route('admin.access')); ?>" class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Review Access Requests</a>
            <a href="<?php echo e(route('admin.listings', ['status' => 'unverified'])); ?>" class="rounded-lg bg-white px-5 py-3 font-bold text-earth shadow-sm">Verify Listings</a>
        </div>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => $stat[0],'value' => $stat[1],'hint' => $stat[2] ?? 'Live data']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stat[0]),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stat[1]),'hint' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stat[2] ?? 'Live data')]); ?>
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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-3">
        <section class="rounded-2xl bg-white p-5 shadow-sm xl:col-span-1">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="font-display text-xl text-pasture">Listing Status Mix</h2>
                    <p class="mt-1 text-sm text-charcoal/60">Moderation and marketplace health.</p>
                </div>
                <a href="<?php echo e(route('admin.listings')); ?>" class="text-sm font-bold text-pasture">View</a>
            </div>
            <div class="mt-4 h-72"><canvas id="statusChart"></canvas></div>
        </section>
        <section class="rounded-2xl bg-white p-5 shadow-sm xl:col-span-1">
            <h2 class="font-display text-xl text-pasture">Top Categories</h2>
            <p class="mt-1 text-sm text-charcoal/60">Where listings are concentrated.</p>
            <div class="mt-4 h-72"><canvas id="categoryChart"></canvas></div>
        </section>
        <section class="rounded-2xl bg-white p-5 shadow-sm xl:col-span-1">
            <h2 class="font-display text-xl text-pasture">Top Counties</h2>
            <p class="mt-1 text-sm text-charcoal/60">Most active marketplace locations.</p>
            <div class="mt-4 h-72"><canvas id="countyChart"></canvas></div>
        </section>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-[1fr_360px]">
        <section class="rounded-2xl bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-3 border-b border-earth/10 pb-4">
                <h2 class="font-display text-2xl text-pasture">Recent Listings</h2>
                <a class="text-sm font-bold text-pasture" href="<?php echo e(route('admin.listings')); ?>">Open listings</a>
            </div>
            <div class="mt-4 overflow-x-auto rounded-xl border border-earth/10">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="bg-cream text-earth"><tr><th class="p-3">Listing</th><th>Seller</th><th>Status</th><th>County</th><th>Clicks</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $dashboardData['recentListings'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-t border-earth/10">
                                <td class="p-3 font-bold"><?php echo e($listing['title']); ?></td>
                                <td><?php echo e($listing['seller_name']); ?></td>
                                <td><?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
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
<?php endif; ?></td>
                                <td><?php echo e($listing['county']); ?></td>
                                <td><?php echo e($listing['contact_clicks']); ?></td>
                                <td><a href="<?php echo e(route('admin.listings.show', $listing['id'])); ?>" class="font-bold text-pasture">Review</a></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="p-4 text-center text-charcoal/60">No listings yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="space-y-6">
            <section class="rounded-2xl bg-white p-5 shadow-sm">
                <h2 class="font-display text-2xl text-pasture">Listing Status</h2>
                <div class="mt-4 grid gap-2">
                    <?php $__currentLoopData = $dashboardData['statusCounts'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('admin.listings', ['status' => $status])); ?>" class="flex items-center justify-between rounded-lg bg-cream px-3 py-2 text-sm font-bold"><span><?php echo e(ucfirst(str_replace('_', ' ', $status))); ?></span><span><?php echo e($total); ?></span></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>
            <section class="rounded-2xl bg-white p-5 shadow-sm">
                <h2 class="font-display text-2xl text-pasture">Open Reports</h2>
                <div class="mt-4 grid gap-3">
                    <?php $__empty_1 = true; $__currentLoopData = $dashboardData['recentReports'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="rounded-lg border border-earth/10 p-3 text-sm">
                            <strong><?php echo e($report->listing?->title ?? 'Listing removed'); ?></strong>
                            <p class="mt-1 text-charcoal/60"><?php echo e($report->reason); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-charcoal/60">No open reports.</p>
                    <?php endif; ?>
                </div>
            </section>
        </aside>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        <?php $__currentLoopData = ['categoryCounts' => 'Listings by Category', 'countyCounts' => 'Listings by County']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <section class="rounded-2xl bg-white p-5 shadow-sm">
                <h2 class="font-display text-xl text-pasture"><?php echo e($title); ?></h2>
                <div class="mt-4 grid gap-2">
                    <?php $__currentLoopData = $dashboardData[$key] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between rounded-lg bg-cream px-3 py-2 text-sm"><span><?php echo e($label); ?></span><strong><?php echo e($total); ?></strong></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <section class="rounded-2xl bg-white p-5 shadow-sm">
            <h2 class="font-display text-xl text-pasture">Expiring Sellers</h2>
            <div class="mt-4 grid gap-2">
                <?php $__empty_1 = true; $__currentLoopData = $dashboardData['expiringSellers'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('admin.users.show', $seller->id)); ?>" class="flex items-center justify-between rounded-lg bg-cream px-3 py-2 text-sm"><span><?php echo e($seller->name); ?></span><strong><?php echo e($seller->access_end_date?->format('d M Y')); ?></strong></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-charcoal/60">No seller expiry dates found.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const colors = ['#2F6B3D', '#7FBF3F', '#7A5C3E', '#2D6CDF', '#D97706', '#DC2626', '#6B7280', '#111827'];
            const chartDefaults = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { labels: { boxWidth: 10, font: { family: 'Inter' } } } },
            };
            const makeDoughnut = (id, labels, values) => new Chart(document.getElementById(id), {
                type: 'doughnut',
                data: { labels, datasets: [{ data: values, backgroundColor: colors, borderWidth: 0 }] },
                options: { ...chartDefaults, cutout: '62%' }
            });
            const makeBar = (id, labels, values) => new Chart(document.getElementById(id), {
                type: 'bar',
                data: { labels, datasets: [{ data: values, backgroundColor: '#2F6B3D', borderRadius: 8 }] },
                options: { ...chartDefaults, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } }, x: { ticks: { maxRotation: 45, minRotation: 0 } } } }
            });
            makeDoughnut('statusChart', <?php echo json_encode($statusCounts->keys()->map(fn($status) => ucfirst(str_replace('_', ' ', $status)))->values()) ?>, <?php echo json_encode($statusCounts->values(), 15, 512) ?>);
            makeBar('categoryChart', <?php echo json_encode($categoryCounts->keys()->values(), 15, 512) ?>, <?php echo json_encode($categoryCounts->values(), 15, 512) ?>);
            makeBar('countyChart', <?php echo json_encode($countyCounts->keys()->values(), 15, 512) ?>, <?php echo json_encode($countyCounts->values(), 15, 512) ?>);
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $attributes = $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $component = $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php /**PATH F:\George Clients\Zizini-starter\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>