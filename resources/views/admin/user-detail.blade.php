@php
    $startValue = $seller['access_start_date_input'] ?: now()->format('Y-m-d');
    $endValue = $seller['access_end_date_input'] ?: now()->addDays((int) $seller['default_listing_duration'])->format('Y-m-d');
@endphp

<x-layouts.admin title="Seller Access">
<div
    x-data="{
        editProfile:false,
        startDate:'{{ $startValue }}',
        endDate:'{{ $endValue }}',
        days:{{ (int) $seller['default_listing_duration'] }},
        total:{{ (int) $seller['listing_allowance_total'] }},
        used:{{ (int) $seller['listing_allowance_used'] }},
        formatDate(date){ return date.toISOString().slice(0,10) },
        syncEnd(){ if(!this.startDate || !this.days) return; const d=new Date(this.startDate+'T00:00:00'); d.setDate(d.getDate()+Number(this.days)); this.endDate=this.formatDate(d) },
        syncDays(){ if(!this.startDate || !this.endDate) return; const start=new Date(this.startDate+'T00:00:00'); const end=new Date(this.endDate+'T00:00:00'); this.days=Math.max(1, Math.round((end-start)/86400000)) },
        approve30(){ this.startDate=this.formatDate(new Date()); this.days=30; this.syncEnd(); document.querySelector('[name=posting_status]').value='Approved' },
        remaining(){ return Math.max(0, Number(this.total || 0) - Number(this.used || 0)) }
    }"
>
    @if(session('status'))
        <div class="mb-5 rounded-xl bg-fresh/15 px-4 py-3 font-semibold text-pasture">{{ session('status') }}</div>
    @endif
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div class="min-w-0">
            <a href="{{ route('admin.users') }}" class="text-sm font-bold text-earth">Back to users</a>
            <div class="mt-2 flex flex-wrap items-center gap-3">
                <h1 class="font-display text-3xl text-pasture md:text-4xl">{{ $seller['name'] }}</h1>
                <x-badge>{{ $seller['approval_status'] }}</x-badge>
                <x-badge>{{ $seller['posting_status'] }}</x-badge>
            </div>
            <p class="mt-1 text-sm text-charcoal/65">{{ $seller['seller_type'] ?? 'Seller' }} in {{ $seller['county'] ?? 'county not set' }} - Registered {{ $seller['joined_date'] }}</p>
        </div>
        <div class="flex shrink-0 flex-wrap gap-2">
            <button type="button" @click="editProfile=true" class="rounded-lg bg-white px-5 py-3 font-bold text-earth shadow-sm">Edit Profile</button>
            <a href="{{ route('admin.listings', ['seller_id' => $seller['id']]) }}" class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">View Listings</a>
            <a href="{{ route('admin.access') }}" class="rounded-lg bg-white px-5 py-3 font-bold text-earth shadow-sm">Access Requests</a>
        </div>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Total listings" :value="$sellerStats['total']" hint="All time" />
        <x-stat-card label="Live listings" :value="$sellerStats['active']" hint="Active + unverified" />
        <x-stat-card label="Open reports" :value="$sellerStats['reports']" hint="Needs review" />
        <x-stat-card label="Contact clicks" :value="$sellerStats['clicks']" hint="Buyer interest" />
    </div>

    <div class="mt-6 grid min-w-0 gap-6 xl:grid-cols-[340px_minmax(0,1fr)]">
        <aside class="space-y-6">
            <section class="rounded-xl bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <img src="{{ $seller['logo_path'] }}" class="h-11 w-11 rounded-lg border border-earth/10 bg-cream object-cover p-1" alt="">
                    <div>
                        <h2 class="font-display text-xl text-pasture">Seller Snapshot</h2>
                        <p class="text-xs text-charcoal/55">{{ $seller['county'] ?? 'County not set' }}</p>
                    </div>
                </div>
                <dl class="mt-4 grid gap-3 text-sm">
                    <div class="flex justify-between gap-4 border-b border-earth/10 pb-2"><dt class="font-bold text-earth">Email</dt><dd class="text-right text-charcoal/75">{{ $seller['email'] }}</dd></div>
                    <div class="flex justify-between gap-4 border-b border-earth/10 pb-2"><dt class="font-bold text-earth">Phone</dt><dd>{{ $seller['phone'] ?? '-' }}</dd></div>
                    <div class="flex justify-between gap-4 border-b border-earth/10 pb-2"><dt class="font-bold text-earth">WhatsApp</dt><dd>{{ $seller['whatsapp'] ?? '-' }}</dd></div>
                    <div class="flex justify-between gap-4 border-b border-earth/10 pb-2"><dt class="font-bold text-earth">Role</dt><dd>{{ $seller['role'] }}</dd></div>
                    <div class="flex justify-between gap-4 border-b border-earth/10 pb-2"><dt class="font-bold text-earth">Allowance</dt><dd>{{ $seller['listing_allowance_used'] }}/{{ $seller['listing_allowance_total'] }}</dd></div>
                    <div class="flex justify-between gap-4"><dt class="font-bold text-earth">Access</dt><dd class="text-right">{{ $seller['access_start_date'] }} to {{ $seller['access_end_date'] }}</dd></div>
                </dl>
                @if(! $seller['can_post'])
                    <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 p-3 text-sm font-semibold text-amber-900">Posting is currently locked for this seller.</div>
                @endif
            </section>

            <section class="rounded-xl bg-white p-5 shadow-sm">
                <h2 class="font-display text-xl text-pasture">Access History</h2>
                <div class="mt-4 space-y-3">
                    @forelse($accessRequests as $request)
                        <div class="rounded-lg border border-earth/10 p-3 text-sm">
                            <div class="flex items-center justify-between gap-3"><strong>{{ $request['requested_role'] }}</strong><x-badge>{{ $request['status'] }}</x-badge></div>
                            <p class="mt-1 text-charcoal/65">{{ $request['requested_listing_count'] }} listings - {{ $request['requested_duration'] }} - {{ $request['created_at'] }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-charcoal/60">No access requests recorded yet.</p>
                    @endforelse
                </div>
            </section>
        </aside>

        <main class="min-w-0 space-y-6">
            <form method="post" action="{{ route('admin.users.access.update', $seller['id']) }}" class="rounded-xl bg-white p-5 shadow-sm">
                @csrf
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-earth/10 pb-4">
                    <div>
                        <h2 class="font-display text-2xl text-pasture">Posting Access</h2>
                        <p class="mt-1 text-sm text-charcoal/60">Set publication rights, allowance, and expiry for this seller.</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" @click="approve30()" class="rounded-lg bg-green-50 px-4 py-2 text-sm font-bold text-pasture">Approve 30 days</button>
                        <button type="button" onclick="document.querySelector('[name=posting_status]').value='Suspended';" class="rounded-lg bg-red-50 px-4 py-2 text-sm font-bold text-red-700">Suspend</button>
                    </div>
                </div>

                <div class="mt-5 grid gap-4 md:grid-cols-2">
                    <label class="grid gap-2 text-sm font-bold text-earth">Seller role<select name="role" class="rounded-lg border border-earth/20 p-3 text-charcoal"><option @selected($seller['role'] === 'Reseller')>Reseller</option><option @selected($seller['role'] === 'Verified Seller')>Verified Seller</option><option @selected($seller['role'] === 'Farm/Dealer')>Farm/Dealer</option><option @selected($seller['role'] === 'Admin')>Admin</option></select></label>
                    <label class="grid gap-2 text-sm font-bold text-earth">Posting status<select name="posting_status" class="rounded-lg border border-earth/20 p-3 text-charcoal"><option @selected($seller['posting_status'] === 'Not approved')>Not approved</option><option @selected($seller['posting_status'] === 'Approved')>Approved</option><option @selected($seller['posting_status'] === 'Suspended')>Suspended</option><option @selected($seller['posting_status'] === 'Expired')>Expired</option></select></label>
                    <label class="grid gap-2 text-sm font-bold text-earth">Total listing allowance<input name="listing_allowance_total" x-model.number="total" type="number" min="0" class="rounded-lg border border-earth/20 p-3 text-charcoal"></label>
                    <label class="grid gap-2 text-sm font-bold text-earth">Remaining listings<input class="rounded-lg border border-earth/20 bg-cream p-3 text-charcoal" :value="remaining()" disabled></label>
                    <label class="grid gap-2 text-sm font-bold text-earth">Access start date<input name="access_start_date" x-model="startDate" @change="syncEnd()" type="date" class="rounded-lg border border-earth/20 p-3 text-charcoal"></label>
                    <label class="grid gap-2 text-sm font-bold text-earth">Access end date<input name="access_end_date" x-model="endDate" @change="syncDays()" type="date" class="rounded-lg border border-earth/20 p-3 text-charcoal"></label>
                    <label class="grid gap-2 text-sm font-bold text-earth">Default listing duration days<input name="default_listing_duration" x-model.number="days" @input.debounce.150ms="syncEnd()" type="number" min="1" class="rounded-lg border border-earth/20 p-3 text-charcoal"><span class="text-xs font-medium text-charcoal/55">Changing this recalculates the end date from the start date. Changing the end date recalculates this value.</span></label>
                    <label class="grid gap-2 text-sm font-bold text-earth md:col-span-2">Admin notes<textarea name="admin_notes" class="rounded-lg border border-earth/20 p-3 text-charcoal" rows="3" placeholder="Documents checked, call notes, renewal reason...">{{ $seller['admin_notes'] }}</textarea></label>
                </div>
                <div class="mt-5 flex flex-wrap items-center gap-3"><button class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Save Access Settings</button><p class="text-sm text-charcoal/60">Changes apply immediately.</p></div>
            </form>

            <section class="rounded-xl bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-earth/10 pb-4"><h2 class="font-display text-2xl text-pasture">Recent Listings</h2><a href="{{ route('admin.listings', ['seller_id' => $seller['id']]) }}" class="text-sm font-bold text-pasture">Open filtered listings</a></div>
                <div class="mt-4 overflow-x-auto rounded-lg border border-earth/10">
                    <table class="w-full min-w-[760px] text-left text-sm">
                        <thead class="bg-cream text-earth"><tr><th class="p-3">Listing</th><th>Status</th><th>Price</th><th>Expiry</th><th>Clicks</th><th>Action</th></tr></thead>
                        <tbody>
                            @forelse($sellerListings as $listing)
                                <tr class="border-t border-earth/10"><td class="p-3 font-bold">{{ $listing['title'] }}</td><td><x-badge>{{ ucfirst(str_replace('_', ' ', $listing['status'])) }}</x-badge></td><td>KSh {{ number_format($listing['price']) }}</td><td>{{ $listing['expiry_date'] }}</td><td>{{ $listing['contact_clicks'] }}</td><td><a href="{{ route('admin.listings.show', $listing['id']) }}" class="font-bold text-pasture">Review</a></td></tr>
                            @empty
                                <tr><td colspan="6" class="p-4 text-center text-charcoal/60">No listings yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div x-cloak x-show="editProfile" class="fixed inset-0 z-50 grid place-items-center bg-charcoal/50 p-4" @keydown.escape.window="editProfile=false">
        <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-2xl" @click.outside="editProfile=false">
            <div class="flex items-start justify-between gap-4 border-b border-earth/10 pb-4">
                <div>
                    <h2 class="font-display text-2xl text-pasture">Edit Seller Profile</h2>
                    <p class="mt-1 text-sm text-charcoal/60">Update the public seller details shown across admin and marketplace pages.</p>
                </div>
                <button type="button" @click="editProfile=false" class="rounded-lg bg-cream px-3 py-2 font-bold text-earth">Close</button>
            </div>
            <form method="post" action="{{ route('admin.users.profile.update', $seller['id']) }}" enctype="multipart/form-data" class="mt-5 grid gap-4 md:grid-cols-2">
                @csrf
                <div class="md:col-span-2 flex items-center gap-4 rounded-xl bg-cream p-4">
                    <img src="{{ $seller['logo_path'] }}" class="h-16 w-16 rounded-xl border border-earth/10 object-cover" alt="{{ $seller['name'] }}">
                    <label class="grid flex-1 gap-2 text-sm font-bold text-earth">Profile photo / company logo<input name="logo" type="file" accept="image/*" class="rounded-lg border border-earth/20 bg-white p-3 text-charcoal"></label>
                </div>
                <label class="grid gap-2 text-sm font-bold text-earth">Name<input name="name" value="{{ $seller['name'] }}" class="rounded-lg border border-earth/20 p-3 text-charcoal" required></label>
                <label class="grid gap-2 text-sm font-bold text-earth">Email<input name="email" value="{{ $seller['email'] }}" type="email" class="rounded-lg border border-earth/20 p-3 text-charcoal"></label>
                <label class="grid gap-2 text-sm font-bold text-earth">Phone<input name="phone" value="{{ $seller['phone'] }}" class="rounded-lg border border-earth/20 p-3 text-charcoal"></label>
                <label class="grid gap-2 text-sm font-bold text-earth">WhatsApp<input name="whatsapp" value="{{ $seller['whatsapp'] }}" class="rounded-lg border border-earth/20 p-3 text-charcoal"></label>
                <label class="grid gap-2 text-sm font-bold text-earth">County<input name="county" value="{{ $seller['county'] }}" class="rounded-lg border border-earth/20 p-3 text-charcoal"></label>
                <label class="grid gap-2 text-sm font-bold text-earth">Seller type<input name="seller_type" value="{{ $seller['seller_type'] }}" class="rounded-lg border border-earth/20 p-3 text-charcoal"></label>
                <div class="flex flex-wrap items-center gap-3 md:col-span-2">
                    <button class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Save Profile</button>
                    <button type="button" @click="editProfile=false" class="rounded-lg bg-cream px-5 py-3 font-bold text-earth">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.admin>
