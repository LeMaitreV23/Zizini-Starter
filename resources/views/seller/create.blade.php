@php
    $steps = ['type' => 'Type', 'category' => 'Category', 'details' => 'Details', 'photos' => 'Photos', 'preview' => 'Preview'];
@endphp

<x-layouts.seller title="Create Listing">
    <section class="mx-auto max-w-6xl px-4 py-6 sm:py-8 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div class="min-w-0">
                <p class="text-sm font-bold text-earth">Seller workspace</p>
                <h1 class="mt-2 max-w-2xl font-display text-3xl leading-tight text-pasture sm:text-4xl lg:text-5xl">Create Marketplace Listing</h1>
                <p class="mt-2 text-sm text-charcoal/65">Add animals, feeds, or livestock services for buyers to contact you directly.</p>
            </div>
            <a href="{{ route('seller.listings') }}" class="rounded-lg bg-white px-4 py-3 text-sm font-bold text-earth shadow-sm">Back to My Listings</a>
        </div>

        <div class="-mx-4 mt-5 overflow-x-auto px-4 pb-2">
            <div class="grid min-w-[560px] grid-cols-5 gap-2">
                @foreach($steps as $key => $label)
                    <div class="rounded-xl p-3 text-center text-xs font-extrabold sm:text-sm {{ $step === $key ? 'bg-pasture text-white shadow-sm' : 'bg-white text-earth shadow-sm' }}">
                        <span class="block text-base">{{ $loop->iteration }}.</span>
                        <span>{{ $label }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        @if(! $seller['can_post'])
            <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm font-semibold text-amber-900">Posting is locked for this account. You can still view your dashboard and listings, but admin must approve or renew access before new listings go live.</div>
        @elseif($step === 'type')
            <div class="mt-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-900">Posting permission active. Remaining listings: {{ $seller['listing_allowance_remaining'] }}.</div>
            <div class="mt-6 grid gap-4 md:grid-cols-3">
                @foreach([['animal','Animals','Cattle, goats, sheep, poultry and other livestock.','/assets/livestock/cow-field-real.jpg'],['feed','Feeds / Farm Inputs','Hay, silage, dairy meal, supplements and farm equipment.','/assets/feeds/hay-silage.jpg'],['service','Services','Veterinary, transport, breeding, permits and consulting.','/assets/services/livestock-market-support.jpg']] as $type)
                    <a href="{{ route('seller.create.category', ['type' => $type[0]]) }}" class="overflow-hidden rounded-2xl bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <img src="{{ $type[3] }}" class="aspect-video w-full object-cover" alt="{{ $type[1] }}">
                        <div class="p-5 sm:p-6">
                        <h2 class="font-display text-2xl text-pasture">{{ $type[1] }}</h2>
                        <p class="mt-2 text-sm leading-6 text-charcoal/60">{{ $type[2] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @elseif($step === 'category')
            <div class="mt-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-900">Posting permission active. Remaining listings: {{ $seller['listing_allowance_remaining'] }}.</div>
            <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach($categories as $cat)
                    @if(!request('type') || ($cat['group_slug'] === 'livestock' && request('type') === 'animal') || ($cat['group_slug'] === 'feeds' && request('type') === 'feed') || ($cat['group_slug'] === 'services' && request('type') === 'service'))
                        <a href="{{ route('seller.create.details', ['type' => request('type', 'animal'), 'category' => $cat['name']]) }}" class="rounded-2xl bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                            <h2 class="font-display text-xl text-pasture">{{ $cat['public_label'] ?? $cat['name'] }}</h2>
                            <p class="mt-2 text-sm leading-6 text-charcoal/60">{{ $cat['description'] }}</p>
                        </a>
                    @endif
                @endforeach
            </div>
        @elseif($step === 'details')
            <form action="{{ route('seller.listings.store') }}" method="post" class="mt-6 grid gap-4 rounded-2xl bg-white p-4 shadow-sm sm:p-6 md:grid-cols-2">
                @csrf
                <input type="hidden" name="listing_type" value="{{ request('type', 'animal') }}">
                <input name="title" class="rounded-lg border border-earth/20 p-3" placeholder="Listing title" required>
                <input name="category" class="rounded-lg border border-earth/20 p-3" placeholder="Category" value="{{ request('category') }}" required>
                <input name="breed" class="rounded-lg border border-earth/20 p-3" placeholder="{{ request('type') === 'feed' ? 'Feed type / brand' : (request('type') === 'service' ? 'Service type' : 'Breed') }}">
                <input name="sex" class="rounded-lg border border-earth/20 p-3" placeholder="{{ request('type') === 'animal' ? 'Sex' : 'Target animal / provider type' }}">
                <input name="age" class="rounded-lg border border-earth/20 p-3" placeholder="{{ request('type') === 'animal' ? 'Age' : 'Availability' }}">
                <input name="price" type="number" min="0" class="rounded-lg border border-earth/20 p-3" placeholder="Price or estimate">
                <input name="county" class="rounded-lg border border-earth/20 p-3" placeholder="County" required>
                <input name="location" class="rounded-lg border border-earth/20 p-3" placeholder="Exact location / service area">
                <input name="health_status" class="rounded-lg border border-earth/20 p-3" placeholder="{{ request('type') === 'animal' ? 'Health status' : 'Quality / availability note' }}">
                <input name="vaccination_status" class="rounded-lg border border-earth/20 p-3" placeholder="{{ request('type') === 'animal' ? 'Vaccination status' : 'Packaging / delivery note' }}">
                <input name="milk_production" class="rounded-lg border border-earth/20 p-3" placeholder="{{ request('type') === 'animal' ? 'Milk production if cattle/dairy' : 'Quantity / pricing model' }}">
                <input name="weight" class="rounded-lg border border-earth/20 p-3" placeholder="{{ request('type') === 'animal' ? 'Weight optional' : 'Unit e.g. bale, bag, visit' }}">
                <input name="owner_phone" class="rounded-lg border border-earth/20 p-3" placeholder="Owner/provider phone">
                <input name="owner_whatsapp" class="rounded-lg border border-earth/20 p-3" placeholder="Owner/provider WhatsApp">
                <textarea name="description" class="rounded-lg border border-earth/20 p-3 md:col-span-2" rows="5" placeholder="Description"></textarea>
                <select name="price_negotiable" class="rounded-lg border border-earth/20 p-3"><option value="1">Negotiable / quote allowed</option><option value="0">Fixed price</option></select>
                <select name="preferred_contact" class="rounded-lg border border-earth/20 p-3"><option>Both</option><option>Call</option><option>WhatsApp</option><option>Form</option></select>
                <a href="{{ route('seller.listings') }}" class="rounded-lg bg-cream px-5 py-3 text-center font-bold">Cancel</a>
                <button class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Submit for Approval</button>
            </form>
        @else
            <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_300px]">
                <x-listing-card :listing="$listings[0]" />
                <div class="rounded-2xl bg-white p-6 shadow-sm"><h2 class="font-display text-2xl text-pasture">Ready to publish?</h2><p class="mt-2 text-sm text-charcoal/65">Approved resellers auto-publish immediately. Admin verifies listings after publication.</p><div class="mt-5 grid gap-3"><a href="/seller/listings/create/details" class="rounded-lg bg-pasture px-5 py-3 text-center font-bold text-white">Enter Listing Details</a></div></div>
            </div>
        @endif
    </section>
</x-layouts.seller>
