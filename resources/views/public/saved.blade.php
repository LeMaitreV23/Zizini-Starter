<x-layouts.main title="Saved Listings">
    <section class="mx-auto max-w-7xl px-4 py-10 lg:px-8"><h1 class="font-display text-4xl text-pasture">Saved Listings</h1><div class="mt-6 grid gap-5 md:grid-cols-3">@forelse($savedListings as $listing)<x-listing-card :listing="$listing" />@empty<div class="rounded-2xl bg-white p-8"><p>No saved listings yet.</p><a href="/marketplace" class="mt-4 inline-flex rounded-lg bg-pasture px-5 py-3 font-bold text-white">Browse marketplace</a></div>@endforelse</div></section>
</x-layouts.main>
