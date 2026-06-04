@if($guideRole === 'seller')
    <x-layouts.main title="Seller Guide">
        <section class="mx-auto max-w-5xl px-4 py-10 lg:px-8">
            <a href="{{ route('seller.dashboard') }}" class="text-sm font-bold text-earth">Back to dashboard</a>
            <h1 class="mt-3 font-display text-4xl text-pasture">Seller Guide</h1>
            <p class="mt-3 text-charcoal/70">A simple guide for posting livestock, feeds, or services and receiving calls or WhatsApp inquiries.</p>
            <div class="mt-8 grid gap-5 md:grid-cols-2">
                @foreach([
                    'Register and wait for approval' => 'Admin reviews seller accounts before posting is unlocked.',
                    'Create a listing' => 'Choose livestock, feeds, or services, then add clear details and photos.',
                    'Submit for approval' => 'Listings are reviewed before they appear publicly.',
                    'Receive direct inquiries' => 'Buyers contact you by call, WhatsApp, or inquiry form.',
                    'Keep listings updated' => 'Mark sold items promptly and request renewal when access expires.',
                    'Sell safely offline' => 'Meet carefully, confirm details, and agree offline.',
                ] as $title => $body)
                    <section class="rounded-2xl bg-white p-6 shadow-sm"><h2 class="font-display text-xl text-pasture">{{ $title }}</h2><p class="mt-2 text-sm text-charcoal/70">{{ $body }}</p></section>
                @endforeach
            </div>
        </section>
    </x-layouts.main>
@else
    <x-layouts.admin title="Admin Guide">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-earth">Back to admin dashboard</a>
            <h1 class="mt-3 font-display text-4xl text-pasture">Admin Operating Guide</h1>
            <p class="mt-2 max-w-3xl text-charcoal/70">Livestock-first marketplace guidance for the current contact-first MVP.</p>
        </div>
        <div class="mt-8 grid gap-6 lg:grid-cols-3">
            @foreach([
                'Current MVP' => ['Livestock-first marketplace', 'Feeds and services support the livestock market', 'Contact-first flow', 'Seller approval', 'Listing approval', 'Category hierarchy', 'Admin access control'],
                'Homepage Logic' => ['Featured Livestock shows animals only', 'Homepage category browsing uses 3 simple cards', 'Detailed categories live on /categories', 'Marketplace defaults to livestock priority'],
                'Removed from MVP' => ['Payment', 'M-Pesa', 'Checkout', 'WooCommerce', 'Cart', 'Revenue dashboard'],
            ] as $title => $items)
                <section class="rounded-2xl bg-white p-6 shadow-sm"><h2 class="font-display text-2xl text-pasture">{{ $title }}</h2><ul class="mt-4 grid gap-2 text-sm text-charcoal/70">@foreach($items as $item)<li>{{ $item }}</li>@endforeach</ul></section>
            @endforeach
        </div>
        <div class="mt-8 grid gap-6 lg:grid-cols-3">
            @foreach([
                'Public journey' => ['Homepage', 'Browse Livestock', 'Listing Detail', 'Contact Owner', 'Call/WhatsApp', 'Inspect safely', 'Agree offline'],
                'Seller journey' => ['Register', 'Pending Approval', 'Access Granted', 'Create Listing', 'Submit for Approval', 'Listing Live', 'Receive Calls/WhatsApp'],
                'Admin journey' => ['Dashboard', 'Approve Sellers', 'Assign Access', 'Manage Category Groups', 'Manage Categories/Subcategories', 'Approve Listings', 'Monitor Reports'],
            ] as $title => $steps)
                <section class="rounded-2xl bg-white p-6 shadow-sm"><h2 class="font-display text-2xl text-pasture">{{ $title }}</h2><div class="mt-4 flex flex-wrap gap-2">@foreach($steps as $step)<span class="rounded-full bg-cream px-3 py-2 text-sm font-bold text-earth">{{ $step }}</span>@endforeach</div></section>
            @endforeach
        </div>
        <div class="mt-8 rounded-2xl bg-white p-6 shadow-sm"><h2 class="font-display text-2xl text-pasture">Future Modules</h2><p class="mt-3 text-charcoal/70">M-Pesa, paid packages, dealer subscriptions, vet verification, transporter marketplace, movement permit integration, AI advisory, and mobile app can be added later.</p></div>
    </x-layouts.admin>
@endif
