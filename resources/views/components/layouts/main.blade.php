<!doctype html>
@php($brand = $brand ?? config('zizini-demo-data.brand'))
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Zizini.co.ke - Livestock Market' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { colors: { pasture:'#2F6B3D', fresh:'#7FBF3F', cream:'#F6F1E7', earth:'#7A5C3E', charcoal:'#1F1F1F', trust:'#2D6CDF' }, fontFamily: { sans:['Inter','sans-serif'], display:['Poppins','sans-serif'] } } } }
    </script>
    <style>[x-cloak]{display:none!important}.soft-shadow{box-shadow:0 18px 45px rgba(31,31,31,.10)}.brand-bg{background:radial-gradient(circle at 80% 0%,rgba(127,191,63,.18),transparent 32%),#F6F1E7}</style>
</head>
<body class="bg-cream font-sans text-charcoal antialiased">
<div x-data="{mobile:false}" class="min-h-screen">
    <header class="sticky top-0 z-40 border-b border-earth/10 bg-cream/90 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 lg:px-8">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ $brand['logo'] }}" alt="Zizini.co.ke" class="h-20 w-auto object-contain md:h-24">
            </a>
            <nav class="hidden items-center gap-6 text-sm font-medium lg:flex">
                <a href="/marketplace" class="hover:text-pasture">Browse Livestock</a>
                <a href="/categories" class="hover:text-pasture">Categories</a>
                <a href="/how-it-works" class="hover:text-pasture">How It Works</a>
                <a href="/about" class="hover:text-pasture">About</a>
                <a href="/faq" class="hover:text-pasture">FAQ</a>
            </nav>
            <div class="hidden items-center gap-3 lg:flex">
                <a href="/login" class="rounded-lg px-4 py-2 text-sm font-semibold text-pasture hover:bg-white">Seller Login</a>
                <a href="/admin/login" class="rounded-lg px-4 py-2 text-sm font-semibold text-earth hover:bg-white">Admin</a>
                <a href="/seller/register" class="rounded-lg bg-pasture px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-800">Sell Livestock</a>
            </div>
            <button @click="mobile=!mobile" class="min-h-[52px] rounded-xl border border-earth/20 px-5 py-3 text-base font-extrabold text-pasture lg:hidden" aria-label="Open menu">Menu</button>
        </div>
        <div x-cloak x-show="mobile" class="border-t border-earth/10 bg-cream px-4 py-5 lg:hidden">
            <div class="grid gap-3 text-base font-bold">
                <a class="min-h-[52px] rounded-xl bg-white px-4 py-4 shadow-sm" href="/marketplace">Browse Livestock</a>
                <a class="min-h-[52px] rounded-xl bg-white px-4 py-4 shadow-sm" href="/categories">Categories</a>
                <a class="min-h-[52px] rounded-xl bg-white px-4 py-4 shadow-sm" href="/counties">Counties</a>
                <a class="min-h-[52px] rounded-xl bg-white px-4 py-4 shadow-sm" href="/how-it-works">How It Works</a>
                <a class="min-h-[56px] rounded-xl bg-pasture px-4 py-4 text-center text-white shadow-sm" href="/seller/register">Sell Livestock</a>
                <a class="min-h-[52px] rounded-xl bg-white px-4 py-4 shadow-sm" href="/login">Seller Login</a>
                <a class="min-h-[52px] rounded-xl bg-white px-4 py-4 shadow-sm" href="/admin/login">Admin Login</a>
            </div>
        </div>
    </header>
    @if(session('status'))
        <div class="mx-auto mt-4 max-w-7xl px-4"><div class="rounded-lg border border-fresh/30 bg-white p-3 text-sm font-semibold text-pasture">{{ session('status') }}</div></div>
    @endif
    <main>{{ $slot }}</main>
    <footer class="mt-16 border-t border-earth/10 bg-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 md:grid-cols-4 lg:px-8">
            <div><img src="{{ $brand['logo'] }}" class="h-14 w-auto" alt="Zizini"><p class="mt-3 text-sm text-charcoal/70">Zizini connects livestock buyers and sellers across Kenya through direct owner contact.</p></div>
            <div><h3 class="font-display text-lg text-pasture">Marketplace</h3><div class="mt-3 grid gap-2 text-sm"><a href="/marketplace">Browse livestock</a><a href="/categories">Categories</a><a href="/counties">Counties</a><a href="/safety">Safety</a></div></div>
            <div><h3 class="font-display text-lg text-pasture">Sellers</h3><div class="mt-3 grid gap-2 text-sm"><a href="/seller/register">Join as seller</a><a href="/login">Seller login</a><a href="/seller/dashboard">Seller dashboard</a><a href="/seller/listings">My listings</a><a href="/admin/login">Admin login</a></div></div>
            <div><h3 class="font-display text-lg text-pasture">Support</h3><p class="mt-3 text-sm">Phone: +254 700 000 000<br>WhatsApp: +254 700 000 000<br>Email: hello@zizini.co.ke</p><p class="mt-4 font-semibold italic text-earth">Uza Nunua Mifugo hapa</p></div>
        </div>
    </footer>
</div>
</body>
</html>
