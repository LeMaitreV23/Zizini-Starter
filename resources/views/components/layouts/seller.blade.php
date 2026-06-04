<!doctype html>
@php($brand = $brand ?? config('zizini-demo-data.brand'))
@php($authSeller = auth()->user())
@php($demoSeller = config('zizini-demo-data.sellers.0'))
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Seller Portal' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script>tailwind.config={theme:{extend:{colors:{pasture:'#2F6B3D',fresh:'#7FBF3F',cream:'#F6F1E7',earth:'#7A5C3E',charcoal:'#1F1F1F',trust:'#2D6CDF'},fontFamily:{sans:['Inter'],display:['Poppins']}}}}</script>
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="bg-cream font-sans text-charcoal">
<div x-data="{mobile:false}" class="min-h-screen lg:flex">
    <aside class="shrink-0 border-b border-earth/10 bg-pasture p-4 text-white lg:min-h-screen lg:w-64 lg:min-w-[16rem] lg:max-w-[16rem] lg:basis-64">
        <div class="flex items-center justify-between gap-3">
            <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 whitespace-nowrap">
                <span class="grid h-16 w-16 place-items-center rounded-xl bg-white/95 shadow-sm"><img src="{{ $brand['logo'] }}" class="max-h-14 max-w-14 object-contain" alt="Zizini"></span>
                <span class="font-display text-xl">Seller Portal</span>
            </a>
            <button @click="mobile=!mobile" class="min-h-[52px] rounded-xl bg-white/10 px-5 py-3 text-base font-extrabold lg:hidden">Menu</button>
        </div>
        <div class="mt-5 rounded-xl bg-white/10 p-3 text-sm">
            <p class="font-bold">{{ $authSeller?->name ?? $demoSeller['name'] ?? 'Seller' }}</p>
            <p class="mt-1 text-white/70">{{ $authSeller?->posting_status ?? $demoSeller['posting_status'] ?? 'Posting status' }}</p>
        </div>
        <nav :class="mobile ? 'grid' : 'hidden lg:grid'" class="mt-6 gap-5 text-base font-semibold lg:text-sm">
            @foreach([
                'Workspace' => [['Dashboard', route('seller.dashboard')], ['My Listings', route('seller.listings')], ['Post New Listing', route('seller.create.type')], ['Inquiries', route('seller.inquiries')]],
                'Account' => [['Profile', route('seller.profile')], ['Approval Status', route('seller.pending')], ['Seller Guide', route('guide')]],
                'Marketplace' => [['Browse Marketplace', route('marketplace')], ['Categories', route('categories')]],
            ] as $section => $items)
                <div>
                    <p class="px-4 text-xs font-extrabold uppercase tracking-wide text-white/55">{{ $section }}</p>
                    <div class="mt-2 grid gap-2 lg:mt-1 lg:gap-1">
                        @foreach($items as $item)
                            <a href="{{ $item[1] }}" class="min-h-[48px] rounded-xl px-4 py-3 hover:bg-white/10 lg:min-h-0 {{ request()->url() === $item[1] ? 'bg-white/15' : '' }}">{{ $item[0] }}</a>
                        @endforeach
                    </div>
                </div>
            @endforeach
            <form method="post" action="{{ route('logout') }}" class="px-4">@csrf<button class="min-h-[52px] w-full rounded-xl bg-white px-4 py-3 text-left text-base font-extrabold text-pasture">Logout</button></form>
        </nav>
    </aside>
    <main class="min-w-0 flex-1">
        <div class="border-b border-earth/10 bg-white/70 px-4 py-3 lg:px-8">
            <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-3">
                <a href="{{ route('marketplace') }}" class="text-sm font-bold text-earth">Back to marketplace</a>
                <div class="flex flex-wrap gap-2 text-sm font-bold">
                    <a href="{{ route('seller.create.type') }}" class="min-h-[44px] rounded-xl bg-pasture px-5 py-3 text-white">Post Listing</a>
                    <a href="{{ route('seller.profile') }}" class="min-h-[44px] rounded-xl bg-cream px-5 py-3 text-earth">Profile</a>
                </div>
            </div>
        </div>
        @if(session('status'))
            <div class="mx-auto mt-4 max-w-7xl px-4 lg:px-8"><div class="rounded-lg border border-fresh/30 bg-white p-3 text-sm font-semibold text-pasture">{{ session('status') }}</div></div>
        @endif
        {{ $slot }}
    </main>
</div>
</body>
</html>
