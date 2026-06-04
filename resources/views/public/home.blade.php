<x-layouts.main title="Zizini.co.ke">
    <section class="brand-bg">
        <div class="mx-auto grid max-w-7xl items-center gap-8 px-4 py-10 lg:grid-cols-[1fr_.75fr] lg:px-8 lg:py-14">
            <div>
                <h1 class="font-display text-4xl leading-tight text-charcoal md:text-5xl">Welcome to <span class="text-pasture">Zizini Livestock Market</span></h1>
                <p class="mt-3 font-display text-2xl italic text-earth">Uza Nunua Mifugo hapa</p>
                <p class="mt-4 max-w-2xl text-lg text-charcoal/75">Browse live livestock listings from trusted sellers across Kenya. View photos, compare prices, and contact the owner directly by call or WhatsApp.</p>
                <form action="/marketplace" class="mt-6 grid gap-3 rounded-2xl border border-earth/10 bg-white p-4 shadow-lg md:grid-cols-[1fr_1fr_1fr_auto]">
                    <input name="q" class="rounded-lg border border-earth/20 px-4 py-3" placeholder="Search livestock...">
                    <select name="category" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">Animal type</option>@foreach(collect($categories)->where('group_slug', 'livestock') as $cat)<option>{{ $cat['name'] }}</option>@endforeach</select>
                    <select name="county" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">County</option>@foreach($counties as $county)<option>{{ $county['name'] }}</option>@endforeach</select>
                    <button class="rounded-lg bg-pasture px-6 py-3 font-bold text-white">Search</button>
                </form>
                <div class="mt-5 flex flex-wrap gap-3"><a href="/marketplace?type=animal" class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Browse Livestock</a><a href="/seller/register" class="rounded-lg border border-pasture px-5 py-3 font-bold text-pasture">Sell Livestock</a></div>
            </div>
            <div class="relative mx-auto w-full max-w-md">
                <div class="rounded-3xl bg-white p-8 shadow-2xl">
                    <div class="mx-auto grid h-44 w-44 place-items-center rounded-full bg-cream shadow-inner">
                        <img src="/assets/brand/logo-symbol.png" class="h-32 w-32 object-contain" alt="Zizini logo">
                    </div>
                    <img src="/assets/livestock/cow-ayrshire.jpg" class="mt-6 aspect-[16/9] w-full rounded-2xl object-cover" alt="Livestock marketplace">
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
        <div class="flex items-end justify-between gap-4"><div><h2 class="font-display text-3xl text-pasture">Featured Livestock</h2><p class="mt-1 text-charcoal/65">Approved animal listings with direct owner contact.</p></div><a class="font-bold text-pasture" href="/marketplace?type=animal">View all</a></div>
        <div class="mt-6 grid gap-5 md:grid-cols-2 lg:grid-cols-4">@foreach($featured as $listing)<x-listing-card :listing="$listing" />@endforeach</div>
    </section>

    <section class="bg-white py-10">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h2 class="font-display text-3xl text-pasture">Browse Marketplace</h2>
            <div class="mt-6 grid gap-5 md:grid-cols-3">
                @foreach([
                    ['Livestock','Cattle, goats, sheep, poultry and other animals.','View Livestock','/marketplace?type=animal','/assets/livestock/cow-field-real.jpg'],
                    ['Feeds & Farm Inputs','Hay, silage, dairy meal, poultry feed and farm supplies.','View Feeds','/marketplace?type=feed','/assets/feeds/hay-silage.jpg'],
                    ['Livestock Services','Transport, vet services, breeding help and farm support.','View Services','/marketplace?type=service','/assets/services/livestock-market-support.jpg'],
                ] as $card)
                    <a href="{{ $card[3] }}" class="overflow-hidden rounded-2xl border border-earth/10 bg-cream shadow-sm transition hover:-translate-y-1 hover:border-pasture hover:shadow-lg">
                        <img src="{{ $card[4] }}" class="aspect-[16/9] w-full object-cover" alt="{{ $card[0] }}">
                        <div class="p-5"><h3 class="font-display text-2xl text-pasture">{{ $card[0] }}</h3><p class="mt-2 text-sm text-charcoal/65">{{ $card[1] }}</p><span class="mt-5 inline-flex rounded-lg bg-pasture px-4 py-2 text-sm font-bold text-white">{{ $card[2] }}</span></div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-5 px-4 py-10 lg:grid-cols-4 lg:px-8">
        @foreach(['Search livestock' => 'Find animals by type, county or price.', 'View details' => 'Check photos, price, location and owner contact.', 'Contact owner' => 'Call or WhatsApp the owner directly.', 'Inspect safely' => 'Visit, confirm details and agree offline.'] as $step => $text)
            <div class="rounded-xl border border-earth/10 bg-white p-6 shadow-sm"><div class="mb-4 grid h-12 w-12 place-items-center rounded-full bg-fresh/20 text-xl font-bold text-pasture">✓</div><h3 class="font-display text-xl">{{ $step }}</h3><p class="mt-2 text-sm text-charcoal/65">{{ $text }}</p></div>
        @endforeach
    </section>

    <section class="bg-pasture py-10 text-white">
        <div class="mx-auto grid max-w-7xl gap-5 px-4 md:grid-cols-4 lg:px-8">
            @foreach(['Approved Listings' => 'Listings are reviewed before going live.', 'Direct Owner Contact' => 'Call or WhatsApp the seller directly.', 'Search by County' => 'Find animals closer to you.', 'Safer Marketplace' => 'Report suspicious listings anytime.'] as $trust => $text)
                <div class="rounded-xl bg-white/10 p-5"><p class="font-display text-xl">{{ $trust }}</p><p class="mt-2 text-sm text-white/75">{{ $text }}</p></div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
        <h2 class="font-display text-3xl text-pasture">Browse Counties</h2>
        <div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-6">@foreach($counties as $county)<a href="/counties/{{ $county['slug'] }}" class="rounded-lg bg-white p-4 font-semibold shadow-sm">{{ $county['name'] }} <span class="mt-2 block text-sm font-normal text-charcoal/55">{{ $county['count'] }} listings</span><span class="mt-3 inline-flex text-sm font-bold text-pasture">View listings</span></a>@endforeach</div>
        <div class="mt-10 rounded-2xl bg-white p-8 shadow-sm md:flex md:items-center md:justify-between"><div><h2 class="font-display text-3xl text-pasture">Have livestock, feeds or services to list?</h2><p class="mt-2 text-charcoal/65">Join as a seller. Once approved, you can post listings and receive calls or WhatsApp inquiries.</p></div><a href="/seller/register" class="mt-5 inline-flex rounded-lg bg-pasture px-5 py-3 font-bold text-white md:mt-0">Join as Seller</a></div>
    </section>
</x-layouts.main>
