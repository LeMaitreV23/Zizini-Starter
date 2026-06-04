<x-layouts.seller title="Seller Dashboard">
    @php
        $sellerStatusLabels = ['Live', 'Unverified', 'Pending', 'Sold', 'Expired'];
        $sellerStatusValues = [
            $sellerStats['active'] ?? 0,
            $sellerStats['unverified'] ?? 0,
            $sellerStats['pending'] ?? 0,
            $sellerStats['sold'] ?? 0,
            $sellerStats['expired'] ?? 0,
        ];
        $usedAllowance = (int) $seller['listing_allowance_used'];
        $remainingAllowance = (int) $seller['listing_allowance_remaining'];
    @endphp
    <section class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-bold text-earth">Seller workspace</p>
                <h1 class="mt-2 font-display text-4xl text-pasture">Seller Dashboard</h1>
                <p class="mt-2 text-charcoal/65">{{ $seller['name'] }} - {{ $seller['posting_status'] }} - Access expires {{ $seller['access_end_date'] }}</p>
            </div>
            @if($seller['can_post'])
                <a href="{{ route('seller.create.type') }}" class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Post New Listing</a>
            @else
                <div class="rounded-lg bg-amber-50 px-5 py-3 text-sm font-bold text-amber-900">Posting locked. You can still manage and review your dashboard.</div>
            @endif
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <x-stat-card label="Live listings" :value="$sellerStats['active'] ?? 0" hint="Active + unverified" />
            <x-stat-card label="Unverified" :value="$sellerStats['unverified'] ?? 0" hint="Live, awaiting admin badge" />
            <x-stat-card label="Sold" :value="$sellerStats['sold'] ?? 0" hint="Marked by seller" />
            <x-stat-card label="Contact clicks" :value="$sellerStats['clicks'] ?? 0" hint="Buyer interest" />
            <x-stat-card label="Allowance left" :value="$seller['listing_allowance_remaining']" hint="Out of {{ $seller['listing_allowance_total'] }}" />
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <h2 class="font-display text-2xl text-pasture">Listing Performance</h2>
                <p class="mt-1 text-sm text-charcoal/60">Status breakdown across your current listings.</p>
                <div class="mt-4 h-72"><canvas id="sellerStatusChart"></canvas></div>
            </section>
            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <h2 class="font-display text-2xl text-pasture">Posting Allowance</h2>
                <p class="mt-1 text-sm text-charcoal/60">How much posting access remains.</p>
                <div class="mt-4 h-72"><canvas id="allowanceChart"></canvas></div>
            </section>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_360px]">
            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-earth/10 pb-4">
                    <div>
                        <h2 class="font-display text-2xl text-pasture">Recent Listings</h2>
                        <p class="mt-1 text-sm text-charcoal/60">Auto-published listings can be active before admin verification.</p>
                    </div>
                    <a href="{{ route('seller.listings') }}" class="text-sm font-bold text-pasture">Manage all</a>
                </div>
                <div class="mt-4 grid gap-3">
                    @forelse($recentListings as $listing)
                        <div class="flex items-center justify-between gap-3 rounded-xl border border-earth/10 p-3">
                            <div class="flex min-w-0 items-center gap-3">
                                <img src="{{ $listing['images'][0] }}" class="h-14 w-16 rounded-lg object-cover" alt="">
                                <div class="min-w-0"><strong class="block truncate">{{ $listing['title'] }}</strong><p class="text-sm text-charcoal/60">{{ $listing['county'] }} - {{ $listing['expiry_date'] }}</p></div>
                            </div>
                            <x-badge>{{ ucfirst(str_replace('_', ' ', $listing['status'])) }}</x-badge>
                        </div>
                    @empty
                        <p class="text-sm text-charcoal/60">No listings yet.</p>
                    @endforelse
                </div>
            </section>

            <aside class="space-y-6">
                <section class="rounded-2xl bg-white p-6 shadow-sm">
                    <h2 class="font-display text-2xl text-pasture">Access Status</h2>
                    <div class="mt-4 grid gap-3 text-sm">
                        <div class="rounded-lg bg-cream p-3"><strong>Posting status</strong><p>{{ $seller['posting_status'] }}</p></div>
                        <div class="rounded-lg bg-cream p-3"><strong>Access window</strong><p>{{ $seller['access_start_date'] }} to {{ $seller['access_end_date'] }}</p></div>
                        <div class="rounded-lg bg-cream p-3"><strong>Listing allowance</strong><p>{{ $seller['listing_allowance_used'] }} used / {{ $seller['listing_allowance_total'] }} total</p></div>
                    </div>
                </section>
                <section class="rounded-2xl bg-white p-6 shadow-sm">
                    <h2 class="font-display text-2xl text-pasture">Recent Inquiries</h2>
                    <div class="mt-4 grid gap-3">
                        @forelse($recentInquiries as $inquiry)
                            <div class="rounded-lg border border-earth/10 p-3 text-sm"><strong>{{ $inquiry->listing?->title }}</strong><p class="text-charcoal/60">{{ ucfirst($inquiry->channel) }} - {{ $inquiry->created_at?->format('d M Y') }}</p></div>
                        @empty
                            <p class="text-sm text-charcoal/60">No inquiries recorded yet.</p>
                        @endforelse
                    </div>
                </section>
            </aside>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const colors = ['#2F6B3D', '#7FBF3F', '#D97706', '#2D6CDF', '#7A5C3E'];
            const baseOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { labels: { boxWidth: 10, font: { family: 'Inter' } } } }
            };
            new Chart(document.getElementById('sellerStatusChart'), {
                type: 'bar',
                data: { labels: @json($sellerStatusLabels), datasets: [{ data: @json($sellerStatusValues), backgroundColor: '#2F6B3D', borderRadius: 8 }] },
                options: { ...baseOptions, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
            });
            new Chart(document.getElementById('allowanceChart'), {
                type: 'doughnut',
                data: { labels: ['Used', 'Remaining'], datasets: [{ data: @json([$usedAllowance, $remainingAllowance]), backgroundColor: ['#7A5C3E', '#7FBF3F'], borderWidth: 0 }] },
                options: { ...baseOptions, cutout: '62%' }
            });
        });
    </script>
</x-layouts.seller>
