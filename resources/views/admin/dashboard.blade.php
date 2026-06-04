<x-layouts.admin title="Admin Dashboard">
    @php
        $statusCounts = collect($dashboardData['statusCounts'] ?? []);
        $categoryCounts = collect($dashboardData['categoryCounts'] ?? []);
        $countyCounts = collect($dashboardData['countyCounts'] ?? []);
    @endphp
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-4xl text-pasture">Admin Dashboard</h1>
            <p class="mt-2 text-charcoal/65">Live operational view for sellers, listings, reports, access windows, and moderation.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.access') }}" class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Review Access Requests</a>
            <a href="{{ route('admin.listings', ['status' => 'unverified']) }}" class="rounded-lg bg-white px-5 py-3 font-bold text-earth shadow-sm">Verify Listings</a>
        </div>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach($stats as $stat)
            <x-stat-card :label="$stat[0]" :value="$stat[1]" :hint="$stat[2] ?? 'Live data'" />
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-3">
        <section class="rounded-2xl bg-white p-5 shadow-sm xl:col-span-1">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="font-display text-xl text-pasture">Listing Status Mix</h2>
                    <p class="mt-1 text-sm text-charcoal/60">Moderation and marketplace health.</p>
                </div>
                <a href="{{ route('admin.listings') }}" class="text-sm font-bold text-pasture">View</a>
            </div>
            <div class="mt-4 h-72"><canvas id="statusChart"></canvas></div>
        </section>
        <section class="rounded-2xl bg-white p-5 shadow-sm xl:col-span-1">
            <h2 class="font-display text-xl text-pasture">Top Categories</h2>
            <p class="mt-1 text-sm text-charcoal/60">Where listings are concentrated.</p>
            <div class="mt-4 h-72"><canvas id="categoryChart"></canvas></div>
        </section>
        <section class="rounded-2xl bg-white p-5 shadow-sm xl:col-span-1">
            <h2 class="font-display text-xl text-pasture">Top Counties</h2>
            <p class="mt-1 text-sm text-charcoal/60">Most active marketplace locations.</p>
            <div class="mt-4 h-72"><canvas id="countyChart"></canvas></div>
        </section>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-[1fr_360px]">
        <section class="rounded-2xl bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-3 border-b border-earth/10 pb-4">
                <h2 class="font-display text-2xl text-pasture">Recent Listings</h2>
                <a class="text-sm font-bold text-pasture" href="{{ route('admin.listings') }}">Open listings</a>
            </div>
            <div class="mt-4 overflow-x-auto rounded-xl border border-earth/10">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="bg-cream text-earth"><tr><th class="p-3">Listing</th><th>Seller</th><th>Status</th><th>County</th><th>Clicks</th><th>Action</th></tr></thead>
                    <tbody>
                        @forelse($dashboardData['recentListings'] ?? [] as $listing)
                            <tr class="border-t border-earth/10">
                                <td class="p-3 font-bold">{{ $listing['title'] }}</td>
                                <td>{{ $listing['seller_name'] }}</td>
                                <td><x-badge>{{ ucfirst(str_replace('_', ' ', $listing['status'])) }}</x-badge></td>
                                <td>{{ $listing['county'] }}</td>
                                <td>{{ $listing['contact_clicks'] }}</td>
                                <td><a href="{{ route('admin.listings.show', $listing['id']) }}" class="font-bold text-pasture">Review</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-4 text-center text-charcoal/60">No listings yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="space-y-6">
            <section class="rounded-2xl bg-white p-5 shadow-sm">
                <h2 class="font-display text-2xl text-pasture">Listing Status</h2>
                <div class="mt-4 grid gap-2">
                    @foreach($dashboardData['statusCounts'] ?? [] as $status => $total)
                        <a href="{{ route('admin.listings', ['status' => $status]) }}" class="flex items-center justify-between rounded-lg bg-cream px-3 py-2 text-sm font-bold"><span>{{ ucfirst(str_replace('_', ' ', $status)) }}</span><span>{{ $total }}</span></a>
                    @endforeach
                </div>
            </section>
            <section class="rounded-2xl bg-white p-5 shadow-sm">
                <h2 class="font-display text-2xl text-pasture">Open Reports</h2>
                <div class="mt-4 grid gap-3">
                    @forelse($dashboardData['recentReports'] ?? [] as $report)
                        <div class="rounded-lg border border-earth/10 p-3 text-sm">
                            <strong>{{ $report->listing?->title ?? 'Listing removed' }}</strong>
                            <p class="mt-1 text-charcoal/60">{{ $report->reason }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-charcoal/60">No open reports.</p>
                    @endforelse
                </div>
            </section>
        </aside>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        @foreach(['categoryCounts' => 'Listings by Category', 'countyCounts' => 'Listings by County'] as $key => $title)
            <section class="rounded-2xl bg-white p-5 shadow-sm">
                <h2 class="font-display text-xl text-pasture">{{ $title }}</h2>
                <div class="mt-4 grid gap-2">
                    @foreach($dashboardData[$key] ?? [] as $label => $total)
                        <div class="flex items-center justify-between rounded-lg bg-cream px-3 py-2 text-sm"><span>{{ $label }}</span><strong>{{ $total }}</strong></div>
                    @endforeach
                </div>
            </section>
        @endforeach
        <section class="rounded-2xl bg-white p-5 shadow-sm">
            <h2 class="font-display text-xl text-pasture">Expiring Sellers</h2>
            <div class="mt-4 grid gap-2">
                @forelse($dashboardData['expiringSellers'] ?? [] as $seller)
                    <a href="{{ route('admin.users.show', $seller->id) }}" class="flex items-center justify-between rounded-lg bg-cream px-3 py-2 text-sm"><span>{{ $seller->name }}</span><strong>{{ $seller->access_end_date?->format('d M Y') }}</strong></a>
                @empty
                    <p class="text-sm text-charcoal/60">No seller expiry dates found.</p>
                @endforelse
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const colors = ['#2F6B3D', '#7FBF3F', '#7A5C3E', '#2D6CDF', '#D97706', '#DC2626', '#6B7280', '#111827'];
            const chartDefaults = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { labels: { boxWidth: 10, font: { family: 'Inter' } } } },
            };
            const makeDoughnut = (id, labels, values) => new Chart(document.getElementById(id), {
                type: 'doughnut',
                data: { labels, datasets: [{ data: values, backgroundColor: colors, borderWidth: 0 }] },
                options: { ...chartDefaults, cutout: '62%' }
            });
            const makeBar = (id, labels, values) => new Chart(document.getElementById(id), {
                type: 'bar',
                data: { labels, datasets: [{ data: values, backgroundColor: '#2F6B3D', borderRadius: 8 }] },
                options: { ...chartDefaults, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } }, x: { ticks: { maxRotation: 45, minRotation: 0 } } } }
            });
            makeDoughnut('statusChart', @json($statusCounts->keys()->map(fn($status) => ucfirst(str_replace('_', ' ', $status)))->values()), @json($statusCounts->values()));
            makeBar('categoryChart', @json($categoryCounts->keys()->values()), @json($categoryCounts->values()));
            makeBar('countyChart', @json($countyCounts->keys()->values()), @json($countyCounts->values()));
        });
    </script>
</x-layouts.admin>
