<x-layouts.main title="Browse Livestock">
    <section class="mx-auto max-w-7xl px-4 py-10 lg:px-8" x-data="{filters:false, timer:null, liveSubmit(){ clearTimeout(this.timer); this.timer = setTimeout(() => this.$refs.filters.submit(), 450) }}">
        <div class="grid gap-6 lg:grid-cols-[1fr_130px] lg:items-end">
            <div>
                <h1 class="font-display text-4xl leading-tight text-pasture md:text-5xl">Browse livestock across Kenya</h1>
                <p class="mt-3 max-w-5xl text-charcoal/70">Find animals first, with feeds and livestock services available when you need farm support. View details and contact owners directly.</p>
            </div>
            <div class="rounded-xl bg-white p-5 text-center shadow-sm">
                <p class="font-display text-2xl text-pasture">{{ $visibleListings->count() }}</p>
                <p class="text-sm font-bold">listings visible</p>
            </div>
        </div>

        <button @click="filters=!filters" class="mt-6 rounded-lg bg-pasture px-4 py-3 font-bold text-white md:hidden">Filters</button>
        <form x-ref="filters" action="/marketplace" class="mt-8 grid gap-3 rounded-2xl border border-earth/10 bg-white p-4 shadow-lg md:grid-cols-2 lg:grid-cols-5" :class="filters ? '' : 'hidden md:grid'">
            <input name="q" value="{{ request('q') }}" @input="liveSubmit()" placeholder="Search animals, feeds or services..." class="rounded-lg border border-earth/20 px-4 py-3 lg:col-span-2">
            <select name="type" @change="$refs.filters.submit()" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">All types</option><option value="animal" @selected(request('type')==='animal')>Animals</option><option value="feed" @selected(request('type')==='feed')>Feeds</option><option value="service" @selected(request('type')==='service')>Services</option></select>
            <select name="category" @change="$refs.filters.submit()" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">Category</option>@foreach($categories as $cat)<option @selected(request('category')===$cat['name'])>{{ $cat['name'] }}</option>@endforeach</select>
            <select name="county" @change="$refs.filters.submit()" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">County</option>@foreach($counties as $county)<option @selected(request('county')===$county['name'])>{{ $county['name'] }}</option>@endforeach</select>
            <select name="{{ request('type') === 'service' ? 'breed' : 'breed' }}" @change="$refs.filters.submit()" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">{{ request('type') === 'feed' ? 'Feed type' : (request('type') === 'service' ? 'Service type' : 'Breed') }}</option>@foreach(collect($listings)->pluck('breed')->filter()->unique()->sort() as $breed)<option @selected(request('breed')===$breed)>{{ $breed }}</option>@endforeach</select>
            @if(request('type') === 'feed')
                <select name="target_animal" @change="$refs.filters.submit()" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">Target animal</option>@foreach(['Cattle','Goats','Sheep','Poultry','Pigs','Mixed livestock'] as $target)<option value="{{ $target }}" @selected(request('target_animal')===$target)>{{ $target }}</option>@endforeach</select>
            @elseif(request('type') === 'service')
                <select name="provider_type" @change="$refs.filters.submit()" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">Provider type</option>@foreach(['individual','company','vet','transporter','consultant'] as $provider)<option value="{{ $provider }}" @selected(request('provider_type')===$provider)>{{ ucfirst($provider) }}</option>@endforeach</select>
            @else
                <select name="sex" @change="$refs.filters.submit()" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">Sex</option>@foreach(['Male','Female','Mixed'] as $sex)<option @selected(request('sex')===$sex)>{{ $sex }}</option>@endforeach</select>
            @endif
            <input name="min_price" type="number" min="0" value="{{ request('min_price') }}" @input="liveSubmit()" placeholder="Min price" class="rounded-lg border border-earth/20 px-4 py-3">
            <input name="max_price" type="number" min="0" value="{{ request('max_price') }}" @input="liveSubmit()" placeholder="Max price" class="rounded-lg border border-earth/20 px-4 py-3">
            <select name="status" @change="$refs.filters.submit()" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">Status</option>@foreach(['active','unverified','sold'] as $status)<option value="{{ $status }}" @selected(request('status')===$status)>{{ ucfirst($status) }}</option>@endforeach</select>
            <select name="sort" @change="$refs.filters.submit()" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">Latest</option><option value="price_asc" @selected(request('sort')==='price_asc')>Lowest price</option><option value="price_desc" @selected(request('sort')==='price_desc')>Highest price</option><option value="featured" @selected(request('sort')==='featured')>Featured</option></select>
            <button class="rounded-lg bg-pasture px-8 py-3 font-extrabold text-white">Filter</button>
        </form>

        <div class="mt-6 flex flex-wrap items-center gap-3 text-sm">
            @foreach([null => 'All', 'animal' => 'Livestock', 'feed' => 'Feeds', 'service' => 'Services'] as $type => $label)
                <a href="{{ route('marketplace', array_filter(array_merge(request()->except('type'), ['type' => $type]))) }}" class="rounded-full px-4 py-2 font-bold {{ request('type') === $type || (!request('type') && !$type) ? 'bg-pasture text-white' : 'bg-white text-earth' }}">{{ $label }}</a>
            @endforeach
            <a href="{{ request()->fullUrlWithQuery(['featured' => 1]) }}" class="rounded-lg border border-earth/20 bg-white px-4 py-2 font-bold text-earth">Featured only</a>
            <a href="/marketplace" class="rounded-lg border border-earth/20 bg-white px-4 py-2 font-bold text-earth">Clear filters</a>
            <span class="font-semibold text-charcoal/75">Sort:</span>
            <a href="/marketplace" class="font-bold text-pasture">Latest</a>
            <span>|</span>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" class="font-bold text-pasture">Lowest price</a>
            <span>|</span>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" class="font-bold text-pasture">Highest price</a>
            <span>|</span>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}" class="font-bold text-pasture">Featured</a>
        </div>

        <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
            @forelse($visibleListings as $listing)
                <x-listing-card :listing="$listing" />
            @empty
                <div class="rounded-2xl bg-white p-8 text-center font-semibold text-charcoal/70 md:col-span-2 lg:col-span-4">No listings match these filters.</div>
            @endforelse
        </div>
    </section>
</x-layouts.main>
