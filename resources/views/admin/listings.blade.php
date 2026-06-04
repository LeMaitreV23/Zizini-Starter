<x-layouts.admin title="Admin Listings">
    <div x-data="{timer:null, liveSubmit(){ clearTimeout(this.timer); this.timer = setTimeout(() => this.$refs.adminFilters.submit(), 450) }}">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h1 class="font-display text-4xl text-pasture">Manage Listings</h1>
        <a href="{{ route('admin.listings.create') }}" class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Add Listing</a>
    </div>

    <form x-ref="adminFilters" action="{{ route('admin.listings') }}" class="mt-6 grid gap-3 rounded-2xl bg-white p-4 shadow-sm md:grid-cols-2 lg:grid-cols-6">
        <input name="q" value="{{ request('q') }}" @input="liveSubmit()" placeholder="Search listings" class="rounded-lg border border-earth/20 px-4 py-3 lg:col-span-2">
        <select name="seller_id" @change="$refs.statusFilter.value='active'; $refs.adminFilters.submit()" class="rounded-lg border border-earth/20 px-4 py-3">
            <option value="">All sellers</option>
            @foreach($adminFilters['sellers'] as $seller)
                <option value="{{ $seller->id }}" @selected((string) request('seller_id') === (string) $seller->id)>{{ $seller->name }}</option>
            @endforeach
        </select>
        <select x-ref="statusFilter" name="status" @change="$refs.adminFilters.submit()" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">All statuses</option>@foreach($adminFilters['statuses'] as $status)<option value="{{ $status }}" @selected(request('status')===$status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>@endforeach</select>
        <select name="category" @change="$refs.adminFilters.submit()" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">All categories</option>@foreach($adminFilters['categories'] as $category)<option value="{{ $category->name }}" @selected(request('category')===$category->name)>{{ $category->name }}</option>@endforeach</select>
        <select name="county" @change="$refs.adminFilters.submit()" class="rounded-lg border border-earth/20 px-4 py-3"><option value="">All counties</option>@foreach($adminFilters['counties'] as $county)<option @selected(request('county')===$county)>{{ $county }}</option>@endforeach</select>
        <button class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Filter</button>
        <a href="{{ route('admin.listings') }}" class="rounded-lg bg-cream px-5 py-3 text-center font-bold">Clear</a>
    </form>

    <div class="mt-6 flex flex-wrap gap-2">
        @foreach($adminFilters['statuses'] as $status)
            <a href="{{ route('admin.listings', array_merge(request()->only(['q', 'seller_id', 'category', 'county']), ['status' => $status])) }}" class="rounded-full bg-white px-4 py-2 text-sm font-bold text-earth">{{ ucfirst(str_replace('_', ' ', $status)) }} ({{ $adminFilters['statusCounts'][$status] ?? 0 }})</a>
        @endforeach
    </div>

    <div class="mt-4 grid gap-4 lg:grid-cols-[320px_1fr]">
        <aside class="rounded-2xl border border-earth/10 bg-white p-4 shadow-sm">
            <h2 class="font-display text-xl text-pasture">{{ $selectedSeller ? $selectedSeller->name : 'Marketplace Brief' }}</h2>
            @if($selectedSeller)
                <div class="mt-3 grid gap-2 text-sm">
                    <div class="mb-3 flex items-center gap-3 rounded-xl bg-cream p-3"><img src="{{ $selectedSeller->logo_path ?: '/assets/seller-logos/default-company-logo.png' }}" class="h-12 w-12 rounded-lg border border-earth/10 bg-white object-cover p-1" alt=""><div><strong>{{ $selectedSeller->name }}</strong><p class="text-xs text-charcoal/60">{{ $selectedSeller->county ?? 'County not set' }}</p></div></div>
                    <p><strong>Registered:</strong> {{ $selectedSeller->created_at?->format('d M Y') ?? '-' }}</p>
                    <p><strong>Role:</strong> {{ $selectedSeller->role }}</p>
                    <p><strong>Approval:</strong> {{ $selectedSeller->approval_status }}</p>
                    <p><strong>Posting:</strong> {{ $selectedSeller->posting_status }}</p>
                    <p><strong>Allowance:</strong> {{ $selectedSeller->listing_allowance_used }} / {{ $selectedSeller->listing_allowance_total }}</p>
                    <p><strong>Expires:</strong> {{ $selectedSeller->access_end_date?->format('d M Y') ?? '-' }}</p>
                    <p><strong>Total posted:</strong> {{ $summaryCounts['total'] }}</p>
                    <p><strong>Active listings:</strong> {{ $summaryCounts['active'] }}</p>
                    <p><strong>Unverified:</strong> {{ $summaryCounts['unverified'] }}</p>
                </div>
                <a href="{{ route('admin.users.show', $selectedSeller->id) }}" class="mt-4 inline-flex rounded-lg bg-cream px-4 py-2 text-sm font-bold">Manage seller</a>
            @else
                <div class="mt-3 grid gap-2 text-sm">
                    <p><strong>Total ever posted:</strong> {{ $summaryCounts['total'] }}</p>
                    <p><strong>Active listings:</strong> {{ $summaryCounts['active'] }}</p>
                    <p><strong>Unverified:</strong> {{ $summaryCounts['unverified'] }}</p>
                    <p><strong>Pending:</strong> {{ $summaryCounts['pending'] }}</p>
                    <p><strong>Reported:</strong> Review open reports from the Reports section.</p>
                </div>
            @endif
        </aside>

        <div class="flex flex-wrap items-center gap-3 rounded-2xl border border-earth/10 bg-white p-4 shadow-sm">
            @foreach([['verify', 'Verify all filtered', 'bg-pasture text-white'], ['take_down', 'Take down all filtered', 'bg-red-700 text-white'], ['expire', 'Expire all filtered', 'bg-cream text-earth']] as $bulk)
                <form method="post" action="{{ route('admin.listings.bulk-moderate') }}">
                    @csrf
                    <input type="hidden" name="action" value="{{ $bulk[0] }}">
                    @foreach(['q', 'seller_id', 'status', 'category', 'county'] as $filter)
                        @if(request()->filled($filter))
                            <input type="hidden" name="{{ $filter }}" value="{{ request($filter) }}">
                        @endif
                    @endforeach
                    <button class="rounded-lg px-4 py-2 text-sm font-bold {{ $bulk[2] }}">{{ $bulk[1] }}</button>
                </form>
            @endforeach
            <p class="text-sm text-charcoal/60">Bulk actions apply only to the current filtered result set.</p>
        </div>
    </div>

    <div class="mt-6 overflow-x-auto rounded-2xl bg-white shadow-sm">
        <table class="w-full min-w-[1000px] text-left text-sm">
            <thead class="bg-cream text-earth"><tr><th class="p-4">Listing</th><th>Seller</th><th>Category</th><th>County</th><th>Price</th><th>Status</th><th>Expiry</th><th>Clicks</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($adminListings as $listing)
                    <tr class="border-t border-earth/10">
                        <td class="p-4"><div class="flex items-center gap-3"><img src="{{ $listing['images'][0] }}" class="h-12 w-14 rounded object-cover"><strong>{{ $listing['title'] }}</strong></div></td>
                        <td><div class="flex items-center gap-2"><img src="{{ $listing['seller_logo'] }}" class="h-8 w-8 rounded-md border border-earth/10 object-cover p-0.5" alt=""><span>{{ $listing['seller_name'] }}</span></div></td>
                        <td>{{ $listing['category'] }}</td>
                        <td>{{ $listing['county'] }}</td>
                        <td>KSh {{ number_format($listing['price']) }}</td>
                        <td><x-badge>{{ ucfirst(str_replace('_', ' ', $listing['status'])) }}</x-badge></td>
                        <td>{{ $listing['expiry_date'] }}</td>
                        <td>{{ $listing['contact_clicks'] }}</td>
                        <td><div class="flex flex-wrap gap-2"><a class="font-bold text-pasture" href="/admin/listings/{{ $listing['id'] }}">View</a><a class="font-bold text-earth" href="{{ route('admin.listings.edit', $listing['id']) }}">Edit</a><form method="post" action="{{ route('admin.listings.moderate', $listing['id']) }}">@csrf<input type="hidden" name="action" value="verify"><button class="font-bold text-green-700">Verify</button></form><form method="post" action="{{ route('admin.listings.moderate', $listing['id']) }}">@csrf<input type="hidden" name="action" value="take_down"><button class="font-bold text-red-700">Take down</button></form></div></td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="p-6 text-center font-semibold text-charcoal/60">No listings match these filters.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
</x-layouts.admin>
