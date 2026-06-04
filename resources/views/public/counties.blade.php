<x-layouts.main title="Counties">
    <section class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
        <h1 class="font-display text-4xl text-pasture">Browse by County</h1><p class="mt-2 text-charcoal/65">Find livestock near your farm, market, or transport route.</p>
        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">@foreach($counties as $county)
            <a href="/counties/{{ $county['slug'] }}" class="rounded-xl border border-earth/10 bg-white p-5 shadow-sm hover:border-pasture"><h2 class="font-display text-2xl">{{ $county['name'] }}</h2><p class="mt-1 text-charcoal/60">{{ $county['count'] }} active listings</p><span class="mt-4 inline-flex text-sm font-bold text-pasture">View Livestock</span></a>
        @endforeach</div>
    </section>
</x-layouts.main>
