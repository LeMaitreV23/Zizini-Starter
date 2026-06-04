<x-layouts.main title="Categories">
    <section class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
        <h1 class="font-display text-4xl text-pasture">Marketplace Categories</h1>
        <p class="mt-2 max-w-3xl text-charcoal/65">Browse proper livestock categories grouped as animals, feeds and farm inputs, and service providers.</p>

        @foreach(($categoryGroups ?? collect()) as $group)
            <div class="mt-10">
                <div class="flex flex-wrap items-end justify-between gap-3">
                    <div>
                        <h2 class="font-display text-3xl text-pasture">{{ $group->name }}</h2>
                        <p class="mt-1 text-sm text-charcoal/60">{{ $group->description }}</p>
                    </div>
                    <a href="{{ route('marketplace', ['type' => $group->slug === 'feeds' ? 'feed' : ($group->slug === 'services' ? 'service' : 'animal')]) }}" class="text-sm font-bold text-pasture">View all {{ strtolower($group->name) }}</a>
                </div>
                <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($categories as $cat)
                        @continue(($cat['group_slug'] ?? null) !== $group->slug)
                        <a href="/categories/{{ $cat['slug'] }}" class="overflow-hidden rounded-2xl border border-earth/10 bg-white shadow-sm transition hover:-translate-y-1 hover:border-pasture hover:shadow-lg">
                            <div class="relative aspect-[16/9] bg-pasture">
                                <img src="{{ $cat['image'] }}" class="h-full w-full object-cover" alt="{{ $cat['name'] }}">
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-5 text-white">
                                    <span class="rounded-full bg-white px-3 py-1 text-xs font-extrabold text-pasture">{{ $cat['group'] }}</span>
                                    <h3 class="mt-2 font-display text-2xl">{{ $cat['public_label'] ?? $cat['name'] }}</h3>
                                </div>
                            </div>
                            <div class="p-5">
                                <p class="text-sm text-charcoal/65">{{ $cat['description'] ?? 'Active listings from approved sellers and providers.' }}</p>
                                <div class="mt-5 flex items-center justify-between">
                                    <span class="text-sm text-charcoal/60">{{ $cat['count'] }} active listings</span>
                                    <span class="rounded-lg bg-pasture px-4 py-2 text-sm font-bold text-white">View listings</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </section>
</x-layouts.main>
