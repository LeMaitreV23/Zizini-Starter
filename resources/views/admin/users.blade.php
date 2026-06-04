@php
    $filters = $userFilters ?? [];
    $options = $userFilterOptions ?? ['counties' => collect($sellers)->pluck('county')->filter()->unique()->sort(), 'roles' => collect($sellers)->pluck('role')->filter()->unique()->sort(), 'sellerTypes' => collect($sellers)->pluck('seller_type')->filter()->unique()->sort()];
@endphp

<x-layouts.admin title="Admin Users">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-4xl text-pasture">Sellers and Users</h1>
            <p class="mt-2 text-sm text-charcoal/65">Filter sellers by access, approval, location, type, and listing activity.</p>
        </div>
        <a href="{{ route('admin.access') }}" class="rounded-lg bg-white px-4 py-3 font-bold text-earth shadow-sm">Access Requests</a>
    </div>

    <form method="get" action="{{ route('admin.users') }}" class="mt-6 grid gap-3 rounded-2xl bg-white p-4 shadow-sm md:grid-cols-2 xl:grid-cols-6">
        <input name="q" value="{{ $filters['q'] ?? '' }}" class="rounded-lg border border-earth/20 px-4 py-3 xl:col-span-2" placeholder="Search name, email, phone...">
        <select name="county" class="rounded-lg border border-earth/20 px-4 py-3">
            <option value="">All counties</option>
            @foreach($options['counties'] as $county)
                <option value="{{ $county }}" @selected(($filters['county'] ?? '') === $county)>{{ $county }}</option>
            @endforeach
        </select>
        <select name="seller_type" class="rounded-lg border border-earth/20 px-4 py-3">
            <option value="">All seller types</option>
            @foreach($options['sellerTypes'] as $type)
                <option value="{{ $type }}" @selected(($filters['seller_type'] ?? '') === $type)>{{ $type }}</option>
            @endforeach
        </select>
        <select name="role" class="rounded-lg border border-earth/20 px-4 py-3">
            <option value="">All roles</option>
            @foreach($options['roles'] as $role)
                <option value="{{ $role }}" @selected(($filters['role'] ?? '') === $role)>{{ $role }}</option>
            @endforeach
        </select>
        <select name="approval_status" class="rounded-lg border border-earth/20 px-4 py-3">
            <option value="">Approval status</option>
            @foreach(['Pending','Approved','Rejected','Suspended'] as $status)
                <option value="{{ $status }}" @selected(($filters['approval_status'] ?? '') === $status)>{{ $status }}</option>
            @endforeach
        </select>
        <select name="posting_status" class="rounded-lg border border-earth/20 px-4 py-3">
            <option value="">Posting status</option>
            @foreach(['Not approved','Approved','Suspended','Expired'] as $status)
                <option value="{{ $status }}" @selected(($filters['posting_status'] ?? '') === $status)>{{ $status }}</option>
            @endforeach
        </select>
        <select name="access_state" class="rounded-lg border border-earth/20 px-4 py-3">
            <option value="">Access window</option>
            @foreach(['active' => 'Active access', 'expiring' => 'Expiring in 14 days', 'expired' => 'Expired access', 'no_access' => 'No access dates'] as $value => $label)
                <option value="{{ $value }}" @selected(($filters['access_state'] ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <select name="verified" class="rounded-lg border border-earth/20 px-4 py-3">
            <option value="">Verification</option>
            <option value="1" @selected(($filters['verified'] ?? '') === '1')>Verified</option>
            <option value="0" @selected(($filters['verified'] ?? '') === '0')>Not verified</option>
        </select>
        <button class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Apply Filters</button>
        <a href="{{ route('admin.users') }}" class="rounded-lg bg-cream px-5 py-3 text-center font-bold text-earth">Clear</a>
    </form>

    <div class="mt-4 flex flex-wrap gap-2 text-sm">
        <span class="rounded-full bg-white px-4 py-2 font-bold text-earth">{{ count($sellers) }} users shown</span>
        @foreach(['Approved','Pending','Rejected','Suspended'] as $status)
            <a href="{{ route('admin.users', array_merge(request()->except('approval_status'), ['approval_status' => $status])) }}" class="rounded-full bg-white px-4 py-2 font-bold text-earth">{{ $status }} ({{ $approvalCounts[$status] ?? 0 }})</a>
        @endforeach
    </div>

    <div class="mt-6 overflow-x-auto rounded-2xl bg-white shadow-sm">
        <table class="w-full min-w-[980px] text-left text-sm">
            <thead class="bg-cream text-earth">
                <tr><th class="p-4">Seller</th><th>Phone</th><th>County</th><th>Type</th><th>Role</th><th>Approval</th><th>Allowance</th><th>Live</th><th>Expiry</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($sellers as $seller)
                    <tr class="border-t border-earth/10">
                        <td class="p-4"><div class="flex items-center gap-3"><img src="{{ $seller['logo_path'] }}" class="h-10 w-10 rounded-lg border border-earth/10 object-cover p-1" alt=""><div><strong>{{ $seller['name'] }}</strong><p class="text-xs text-charcoal/50">{{ $seller['email'] }}</p></div></div></td>
                        <td>{{ $seller['phone'] }}</td>
                        <td>{{ $seller['county'] }}</td>
                        <td>{{ $seller['seller_type'] }}</td>
                        <td><x-badge>{{ $seller['role'] }}</x-badge></td>
                        <td><x-badge>{{ $seller['approval_status'] }}</x-badge></td>
                        <td>{{ $seller['listing_allowance_used'] }}/{{ $seller['listing_allowance_total'] }}</td>
                        <td>{{ $seller['active_listing_count'] ?? 0 }}</td>
                        <td>{{ $seller['access_end_date'] }}</td>
                        <td><a class="font-bold text-pasture" href="{{ route('admin.users.show', $seller['id']) }}">View user</a></td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="p-8 text-center text-charcoal/60">No users match these filters.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
