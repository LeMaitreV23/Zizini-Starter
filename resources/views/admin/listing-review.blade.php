<x-layouts.admin title="Review Listing">
    <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
        <div class="rounded-2xl bg-white p-6 shadow-sm"><img src="{{ $listing['images'][0] }}" class="aspect-video w-full rounded-xl object-cover"><h1 class="mt-5 font-display text-3xl text-pasture">{{ $listing['title'] }}</h1><div class="mt-4 grid gap-3 md:grid-cols-3">@foreach(['Category'=>$listing['category'],'Breed'=>$listing['breed'],'County'=>$listing['county'],'Health'=>$listing['health_status'],'Vaccination'=>$listing['vaccination_status'],'Expiry'=>$listing['expiry_date']] as $k=>$v)<div class="rounded-lg bg-cream p-3"><strong>{{ $k }}</strong><br>{{ $v }}</div>@endforeach</div><textarea form="moderation-notes" name="admin_notes" class="mt-5 w-full rounded-lg border border-earth/20 p-3" rows="4" placeholder="Admin notes"></textarea></div>
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <h2 class="font-display text-2xl text-pasture">Moderation</h2>
            <p class="mt-2 text-sm">{{ $listing['seller_name'] }} - {{ $listing['seller_phone'] }}</p>
            <x-badge>{{ ucfirst($listing['status']) }}</x-badge>
            <div class="mt-5 grid gap-3">
                @foreach([['verify','Approve / Verify Listing','bg-pasture text-white'],['reject','Reject Listing','bg-red-600 text-white'],['take_down','Take Down Post','bg-red-700 text-white'],['feature','Mark Featured','bg-trust text-white'],['extend','Extend Listing Period','border border-earth/20']] as $action)
                    <form id="{{ $loop->first ? 'moderation-notes' : '' }}" method="post" action="{{ route('admin.listings.moderate', $listing['id']) }}">@csrf<input type="hidden" name="action" value="{{ $action[0] }}"><button class="w-full rounded-lg px-5 py-3 font-bold {{ $action[2] }}">{{ $action[1] }}</button></form>
                @endforeach
            </div>
            <div class="mt-6 rounded-lg bg-cream p-4 text-sm">Safety checklist: photos clear, seller contact available, no payment claims, details reasonable.</div>
        </div>
    </div>
</x-layouts.admin>
