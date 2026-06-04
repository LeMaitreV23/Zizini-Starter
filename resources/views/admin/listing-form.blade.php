<x-layouts.admin title="{{ $listing ? 'Edit Listing' : 'Add Listing' }}">
    <h1 class="font-display text-4xl text-pasture">{{ $listing ? 'Edit Listing' : 'Add Listing' }}</h1>
    <form method="post" action="{{ $listing ? route('admin.listings.update', $listing['id']) : route('admin.listings.store') }}" class="mt-8 grid gap-4 rounded-2xl bg-white p-6 shadow-sm md:grid-cols-2">
        @csrf
        <select name="seller_id" class="rounded-lg border border-earth/20 p-3" required>
            @foreach($sellers as $seller)
                <option value="{{ $seller->id }}" @selected(($listing['seller_id'] ?? null) === $seller->id)>{{ $seller->name }}</option>
            @endforeach
        </select>
        <input name="title" value="{{ $listing['title'] ?? '' }}" class="rounded-lg border border-earth/20 p-3" placeholder="Listing title" required>
        <input name="category" value="{{ $listing['category'] ?? '' }}" class="rounded-lg border border-earth/20 p-3" placeholder="Category" required>
        <input name="breed" value="{{ $listing['breed'] ?? '' }}" class="rounded-lg border border-earth/20 p-3" placeholder="Breed">
        <input name="sex" value="{{ $listing['sex'] ?? '' }}" class="rounded-lg border border-earth/20 p-3" placeholder="Sex">
        <input name="age" value="{{ $listing['age'] ?? '' }}" class="rounded-lg border border-earth/20 p-3" placeholder="Age">
        <input name="price" value="{{ $listing['price'] ?? '' }}" type="number" min="0" class="rounded-lg border border-earth/20 p-3" placeholder="Price">
        <input name="county" value="{{ $listing['county'] ?? '' }}" class="rounded-lg border border-earth/20 p-3" placeholder="County" required>
        <input name="location" value="{{ $listing['location'] ?? '' }}" class="rounded-lg border border-earth/20 p-3" placeholder="Exact location">
        <input name="health_status" value="{{ $listing['health_status'] ?? '' }}" class="rounded-lg border border-earth/20 p-3" placeholder="Health status">
        <input name="vaccination_status" value="{{ $listing['vaccination_status'] ?? '' }}" class="rounded-lg border border-earth/20 p-3" placeholder="Vaccination status">
        <input name="milk_production" value="{{ $listing['milk_production'] ?? '' }}" class="rounded-lg border border-earth/20 p-3" placeholder="Milk production if cattle/dairy">
        <input name="weight" value="{{ $listing['weight'] ?? '' }}" class="rounded-lg border border-earth/20 p-3" placeholder="Weight optional">
        <input name="owner_phone" value="{{ $listing['seller_phone'] ?? '' }}" class="rounded-lg border border-earth/20 p-3" placeholder="Owner phone">
        <input name="owner_whatsapp" value="{{ $listing['seller_whatsapp'] ?? '' }}" class="rounded-lg border border-earth/20 p-3" placeholder="Owner WhatsApp">
        <input name="expires_at" type="date" class="rounded-lg border border-earth/20 p-3">
        <select name="status" class="rounded-lg border border-earth/20 p-3">
            @foreach(['active','unverified','pending','rejected','expired','sold','taken_down','draft'] as $status)
                <option value="{{ $status }}" @selected(($listing['status'] ?? 'active') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
            @endforeach
        </select>
        <label class="flex items-center gap-2 rounded-lg border border-earth/20 p-3"><input name="verified" value="1" type="checkbox" @checked($listing['verified'] ?? true)> Verified listing</label>
        <label class="flex items-center gap-2 rounded-lg border border-earth/20 p-3"><input name="featured" value="1" type="checkbox" @checked($listing['featured'] ?? false)> Featured listing</label>
        <textarea name="description" class="rounded-lg border border-earth/20 p-3 md:col-span-2" rows="5" placeholder="Description">{{ $listing['description'] ?? '' }}</textarea>
        <a href="{{ route('admin.listings') }}" class="rounded-lg bg-cream px-5 py-3 text-center font-bold">Cancel</a>
        <button class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">{{ $listing ? 'Save Listing' : 'Create Listing' }}</button>
    </form>
    @if($listing)
        <form method="post" action="{{ route('admin.listings.destroy', $listing['id']) }}" class="mt-4">@csrf<button class="rounded-lg bg-red-700 px-5 py-3 font-bold text-white">Delete Listing</button></form>
    @endif
</x-layouts.admin>
