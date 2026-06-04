<x-layouts.main title="{{ $title }}">
    <section class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
        <div class="rounded-3xl bg-white p-8 shadow-sm">
            <h1 class="font-display text-4xl text-pasture">{{ $mode === 'county' ? 'Livestock for sale in '.$title : $title.' Listings' }}</h1>
            <p class="mt-2 text-charcoal/65">{{ $mode === 'county' ? 'Filter by category and contact owners directly.' : 'Browse available animals in this category.' }}</p>
            <div class="mt-5 flex flex-wrap gap-2">@foreach($categories as $cat)<a href="/categories/{{ $cat['slug'] }}" class="rounded-full bg-cream px-4 py-2 text-sm font-bold text-earth">{{ $cat['name'] }}</a>@endforeach</div>
        </div>
        <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-4">@foreach($visibleListings as $listing)<x-listing-card :listing="$listing" />@endforeach</div>
        <div class="mt-10 rounded-2xl bg-pasture p-8 text-white md:flex md:items-center md:justify-between"><div><h2 class="font-display text-2xl">Have {{ strtolower($title) }} to sell?</h2><p class="mt-1 text-white/75">Join as a seller and wait for admin posting approval.</p></div><a href="/seller/register" class="mt-4 inline-flex rounded-lg bg-white px-5 py-3 font-bold text-pasture md:mt-0">Join as a seller</a></div>
    </section>
</x-layouts.main>
