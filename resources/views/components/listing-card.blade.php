@props(['listing'])
<article class="overflow-hidden rounded-xl border border-earth/10 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" x-data="{fav:false,contact:false}">
    <div class="relative aspect-[4/3] overflow-hidden">
        <img src="{{ $listing['images'][0] }}" alt="{{ $listing['title'] }}" class="h-full w-full object-cover">
        <div class="absolute left-3 top-3 flex flex-wrap gap-2">
            @if($listing['featured'])<x-badge>Featured</x-badge>@endif
            @if($listing['seller_verified'])<x-badge>Verified</x-badge>@endif
        </div>
        <button @click="fav=!fav" class="absolute right-3 top-3 grid h-10 w-10 place-items-center rounded-full bg-white text-lg shadow" :class="fav ? 'text-red-600' : 'text-earth'" aria-label="Save listing">♡</button>
    </div>
    <div class="p-4">
        <div class="flex items-center justify-between gap-3">
            <p class="text-xs font-extrabold uppercase tracking-wide text-earth">{{ $listing['type_label'] ?? 'Animal' }} · {{ $listing['category'] }}</p>
            <x-badge>{{ $listing['status'] === 'active' ? 'Active' : ucfirst($listing['status']) }}</x-badge>
        </div>
        <h3 class="mt-2 font-display text-xl leading-tight">{{ $listing['title'] }}</h3>
        <p class="mt-3 text-xl font-extrabold text-trust">{{ ($listing['price_type'] ?? 'negotiable') === 'quote' || $listing['price'] <= 0 ? 'Contact for quote' : 'KSh '.number_format($listing['price']) }}</p>
        <p class="mt-3 text-sm text-charcoal/65">{{ $listing['county'] }} <span class="mx-1">•</span> {{ ($listing['listing_type'] ?? 'animal') === 'service' ? 'Provider service' : ($listing['breed'] ?: $listing['category']) }} <span class="mx-1">•</span> {{ ($listing['listing_type'] ?? 'animal') === 'feed' ? 'Farm input' : ($listing['sex'] ?: 'Available') }}</p>
        <div class="mt-4 grid gap-2">
            <a href="/livestock/{{ $listing['slug'] }}" class="rounded-lg bg-pasture px-4 py-3 text-center text-sm font-extrabold text-white">View Details</a>
            <button @click="contact=true" class="text-sm font-bold text-pasture">{{ ($listing['listing_type'] ?? 'animal') === 'service' ? 'Contact Provider' : (($listing['listing_type'] ?? 'animal') === 'feed' ? 'Contact Seller' : 'Contact Owner') }}</button>
        </div>
    </div>
    <div x-cloak x-show="contact" class="fixed inset-0 z-50 grid place-items-center bg-black/40 p-4">
        <div @click.outside="contact=false" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
            <h3 class="font-display text-xl text-pasture">{{ ($listing['listing_type'] ?? 'animal') === 'service' ? 'Contact Provider' : (($listing['listing_type'] ?? 'animal') === 'feed' ? 'Contact Seller' : 'Contact Owner') }}</h3>
            <p class="mt-2 text-sm text-charcoal/70">{{ $listing['seller_name'] }} · {{ $listing['seller_phone'] }}</p>
            <form method="post" action="{{ route('livestock.inquiries.store', $listing['id']) }}" class="mt-4">
                @csrf
                <input type="hidden" name="channel" value="form">
                <div class="grid gap-2 sm:grid-cols-2">
                    <input name="name" class="rounded-lg border border-earth/20 p-3 text-sm" placeholder="Your name">
                    <input name="phone" class="rounded-lg border border-earth/20 p-3 text-sm" placeholder="Your phone">
                </div>
                <textarea name="message" class="mt-3 w-full rounded-lg border border-earth/20 p-3 text-sm" rows="4">Hello, I saw your {{ $listing['title'] }} on Zizini.co.ke. Is it still available?</textarea>
            <div class="mt-4 flex gap-2">
                <button class="flex-1 rounded-lg bg-pasture px-4 py-3 text-center text-sm font-bold text-white">Send Inquiry</button>
                <button @click="contact=false" class="rounded-lg bg-cream px-4 py-3 text-sm font-bold">Close</button>
            </div>
            </form>
        </div>
    </div>
</article>
