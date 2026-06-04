@php $titles=['pending'=>'Your seller account is under review','submitted'=>'Listing submitted successfully','profile'=>'Seller Profile','inquiries'=>'Seller Inquiries']; @endphp
<x-layouts.seller title="{{ $titles[$page] }}">
    <section class="mx-auto max-w-5xl px-4 py-10 lg:px-8">
        <a href="{{ route('seller.dashboard') }}" class="text-sm font-bold text-earth">Back to dashboard</a>
        <h1 class="mt-3 font-display text-4xl text-pasture">{{ $titles[$page] }}</h1>
        @if($page === 'pending')
            <div class="mt-6 rounded-2xl bg-white p-8 shadow-sm">
                <p>Your seller account is in admin review. You can log in and view your account, but posting remains locked until approval.</p>
                <div class="mt-5 grid gap-3 md:grid-cols-4">
                    @foreach(['Seller details received','Admin checks account','Access limit assigned','Posting window activated'] as $item)
                        <div class="rounded-lg bg-cream p-4 font-bold">{{ $item }}</div>
                    @endforeach
                </div>
            </div>
        @elseif($page === 'submitted')
            <div class="mt-6 rounded-2xl bg-white p-8 shadow-sm"><p>Your listing is live if your account is approved, but it remains unverified until admin reviews it.</p><p class="mt-3 text-sm text-charcoal/65">Buyers can contact you while admin verification is pending, unless a listing is rejected or taken down.</p></div>
        @elseif($page === 'profile')
            @if(session('status'))
                <div class="mt-5 rounded-xl bg-fresh/15 px-4 py-3 font-semibold text-pasture">{{ session('status') }}</div>
            @endif
            <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm">
                <div class="flex flex-wrap items-center gap-5">
                    <img src="{{ $seller['logo_path'] ?? '/assets/seller-logos/default-company-logo.png' }}" class="h-24 w-24 rounded-2xl object-cover ring-1 ring-earth/10" alt="{{ $seller['name'] }}">
                    <form method="post" action="{{ route('seller.profile.logo') }}" enctype="multipart/form-data" class="grid gap-3 sm:flex sm:items-center">
                        @csrf
                        <input type="file" name="logo" accept="image/*" class="rounded-lg border border-earth/20 p-3">
                        <button class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Upload Logo</button>
                    </form>
                </div>
            </div>
            <div class="mt-6 grid gap-6 md:grid-cols-2">
                @foreach(['Name'=>$seller['name'],'Phone'=>$seller['phone'],'WhatsApp'=>$seller['whatsapp'],'Email'=>$seller['email'],'County'=>$seller['county'],'Role'=>$seller['role'],'Posting status'=>$seller['posting_status'],'Access expires'=>$seller['access_end_date'],'Allowance'=>$seller['listing_allowance_used'].' used / '.$seller['listing_allowance_total'].' total'] as $label => $value)
                    <div class="rounded-xl bg-white p-5 shadow-sm"><strong class="text-earth">{{ $label }}</strong><p class="mt-1">{{ $value ?: '-' }}</p></div>
                @endforeach
            </div>
        @else
            <div class="mt-6 grid gap-4">
                @forelse($sellerInquiries as $inquiry)
                    <div class="rounded-xl bg-white p-5 shadow-sm">
                        <div class="flex flex-wrap items-center justify-between gap-3"><strong>{{ $inquiry->listing?->title }}</strong><x-badge>{{ ucfirst($inquiry->channel) }}</x-badge></div>
                        <p class="mt-2 text-sm text-charcoal/65">{{ $inquiry->message ?: 'No message supplied.' }}</p>
                        <p class="mt-2 text-xs text-charcoal/50">{{ $inquiry->name ?: 'Buyer' }} - {{ $inquiry->phone ?: $inquiry->email ?: 'No contact supplied' }} - {{ $inquiry->created_at?->format('d M Y') }}</p>
                    </div>
                @empty
                    <div class="rounded-2xl bg-white p-8 shadow-sm text-charcoal/60">No inquiries recorded for your listings yet.</div>
                @endforelse
            </div>
        @endif
    </section>
</x-layouts.seller>
