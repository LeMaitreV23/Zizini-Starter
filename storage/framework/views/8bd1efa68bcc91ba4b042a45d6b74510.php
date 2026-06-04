<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?php echo e($title ?? 'Zizini Admin'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script><script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script>tailwind.config={theme:{extend:{colors:{pasture:'#2F6B3D',fresh:'#7FBF3F',cream:'#F6F1E7',earth:'#7A5C3E',charcoal:'#1F1F1F',trust:'#2D6CDF'},fontFamily:{sans:['Inter'],display:['Poppins']}}}}</script>
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="bg-cream font-sans text-charcoal">
<div x-data="{adminMenu:false}" class="min-h-screen lg:flex">
    <aside class="shrink-0 border-b border-earth/10 bg-pasture p-4 text-white lg:min-h-screen lg:w-64 lg:min-w-[16rem] lg:max-w-[16rem] lg:basis-64">
        <div class="flex items-center justify-between gap-3">
            <a href="/admin/dashboard" class="flex items-center gap-3 whitespace-nowrap"><span class="grid h-14 w-14 place-items-center rounded-xl bg-white/95 shadow-sm"><img src="/assets/brand/logo-symbol.png" class="h-12 w-12 object-contain" alt="Zizini"></span><span class="font-display text-xl">Zizini Admin</span></a>
            <button type="button" @click="adminMenu=!adminMenu" class="min-h-[52px] rounded-xl bg-white/10 px-5 py-3 text-base font-extrabold lg:hidden">Menu</button>
        </div>
        <div class="mt-5 rounded-xl bg-white/10 p-3 text-sm">
            <p class="font-bold"><?php echo e(auth()->user()?->name ?? 'Zizini Admin'); ?></p>
            <p class="mt-1 text-white/70"><?php echo e(auth()->user()?->role ?? 'Administrator'); ?></p>
        </div>
        <nav :class="adminMenu ? 'grid' : 'hidden lg:grid'" class="mt-6 gap-5 text-base font-semibold lg:mt-8 lg:gap-4 lg:text-sm">
            <?php $__currentLoopData = [
                'Marketplace' => [['Listings','/admin/listings'],['Categories','/admin/categories'],['Category Groups','/admin/category-groups'],['Subcategories / Types','/admin/subcategories'],['Featured Listings','/admin/featured']],
                'Users' => [['Sellers','/admin/users'],['Access Requests','/admin/access-requests'],['Roles & Permissions','/admin/users']],
                'Operations' => [['Reports','/admin/reports'],['Inquiries','/admin/inquiries'],['Audit Logs','/admin/audit-logs']],
                'Settings' => [['Platform Settings','/admin/settings'],['Analytics','/admin/analytics'],['Guide','/guide']],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <p class="px-4 text-xs font-extrabold uppercase tracking-wide text-white/55"><?php echo e($section); ?></p>
                    <div class="mt-2 grid gap-2 lg:mt-1 lg:gap-1">
                        <?php if($section === 'Marketplace' && $loop->first): ?><a class="min-h-[48px] rounded-xl px-4 py-3 hover:bg-white/10 lg:min-h-0" href="/admin/dashboard">Dashboard</a><?php endif; ?>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><a class="min-h-[48px] rounded-xl px-4 py-3 hover:bg-white/10 lg:min-h-0" href="<?php echo e($item[1]); ?>"><?php echo e($item[0]); ?></a><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <form method="post" action="<?php echo e(route('logout')); ?>" class="px-4">
                <?php echo csrf_field(); ?>
                <button class="min-h-[52px] w-full rounded-xl bg-white px-4 py-3 text-left text-base font-extrabold text-pasture">Logout</button>
            </form>
        </nav>
    </aside>
    <main class="min-w-0 flex-1 p-4 lg:p-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="min-h-[44px] rounded-xl bg-white px-4 py-3 text-sm font-bold text-earth shadow-sm">&larr; Admin Dashboard</a>
                <div class="flex flex-wrap gap-2 text-sm font-bold">
                    <a href="<?php echo e(route('admin.listings')); ?>" class="min-h-[44px] rounded-xl bg-white px-4 py-3 text-pasture shadow-sm">Listings</a>
                    <a href="<?php echo e(route('admin.users')); ?>" class="min-h-[44px] rounded-xl bg-white px-4 py-3 text-pasture shadow-sm">Users</a>
                    <a href="<?php echo e(route('admin.reports')); ?>" class="min-h-[44px] rounded-xl bg-white px-4 py-3 text-pasture shadow-sm">Reports</a>
                    <a href="<?php echo e(route('admin.settings')); ?>" class="min-h-[44px] rounded-xl bg-white px-4 py-3 text-pasture shadow-sm">Settings</a>
                </div>
            </div>
            <?php echo e($slot); ?>

        </div>
    </main>
</div>
</body>
</html>
<?php /**PATH F:\George Clients\Zizini-starter\resources\views/components/layouts/admin.blade.php ENDPATH**/ ?>