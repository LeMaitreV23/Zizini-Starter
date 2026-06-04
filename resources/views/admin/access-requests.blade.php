<x-layouts.admin title="Access Requests">
    <h1 class="font-display text-4xl text-pasture">Access Requests</h1>
    <div class="mt-6 grid gap-4">
        @foreach($access_requests as $request)
            <div class="rounded-2xl bg-white p-5 shadow-sm md:flex md:items-center md:justify-between">
                <div>
                    <h2 class="font-display text-xl">{{ $request['seller_name'] }}</h2>
                    <p class="text-sm text-charcoal/65">{{ $request['requested_role'] }} - {{ $request['requested_listing_count'] }} listings - {{ $request['requested_duration'] }} - {{ $request['created_at'] }} - {{ $request['status'] }}</p>
                </div>
                <div class="mt-4 flex gap-2 md:mt-0">
                    <form method="post" action="{{ route('admin.access.review', [$request['id'], 'approve']) }}">@csrf<button class="rounded-lg bg-pasture px-4 py-2 font-bold text-white">Approve</button></form>
                    <form method="post" action="{{ route('admin.access.review', [$request['id'], 'reject']) }}">@csrf<button class="rounded-lg bg-red-600 px-4 py-2 font-bold text-white">Reject</button></form>
                    <a href="/admin/users/{{ $request['seller_id'] }}" class="rounded-lg bg-cream px-4 py-2 font-bold">Assign access</a>
                    <a href="{{ route('admin.listings', ['seller_id' => $request['seller_id']]) }}" class="rounded-lg bg-white px-4 py-2 font-bold text-pasture">View listings</a>
                </div>
            </div>
        @endforeach
    </div>
</x-layouts.admin>
