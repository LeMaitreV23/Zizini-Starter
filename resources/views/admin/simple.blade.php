@php
    $titles = [
        'categories' => 'Categories',
        'category-groups' => 'Category Groups',
        'subcategories' => 'Subcategories and Types',
        'reports' => 'Reported Listings',
        'inquiries' => 'Buyer Inquiries',
        'featured' => 'Featured Listings',
        'settings' => 'Platform Settings',
        'analytics' => 'Operational Analytics',
        'audit-logs' => 'Audit Logs',
    ];
    $editingCategory = $page === 'categories' ? collect($categoryGroups ?? [])->flatMap(fn ($group) => $group->categories)->firstWhere('id', (int) request('edit')) : null;
    $editingSubcategory = $page === 'subcategories' ? collect($subcategories ?? [])->firstWhere('id', (int) request('edit')) : null;
    $editingGroup = $page === 'category-groups' ? collect($categoryGroups ?? [])->firstWhere('id', (int) request('edit_group')) : null;
@endphp

<x-layouts.admin title="{{ $titles[$page] ?? 'Admin' }}">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-earth">Back to Dashboard</a>
            <h1 class="mt-2 font-display text-4xl text-pasture">{{ $titles[$page] ?? 'Admin' }}</h1>
        </div>
        @if($page === 'categories')
            <div class="flex flex-wrap gap-2">
                <a href="#category-form" class="rounded-lg bg-pasture px-4 py-2 font-bold text-white">Add Category</a>
                <a href="{{ route('admin.subcategories') }}#subcategory-form" class="rounded-lg bg-white px-4 py-2 font-bold text-earth shadow-sm">Add Subcategory</a>
                <a href="{{ route('admin.category-groups') }}" class="rounded-lg bg-cream px-4 py-2 font-bold text-earth">Manage Category Groups</a>
            </div>
        @endif
    </div>

    @if(session('status'))
        <div class="mt-5 rounded-xl bg-fresh/15 px-4 py-3 font-semibold text-pasture">{{ session('status') }}</div>
    @endif

    @if($page === 'categories')
        <div class="mt-6 grid gap-4 md:grid-cols-3">
            @foreach($categoryGroups ?? [] as $group)
                <div class="rounded-2xl bg-white p-5 shadow-sm">
                    <h2 class="font-display text-2xl text-pasture">{{ $group->name }}</h2>
                    <p class="mt-2 text-sm text-charcoal/60">{{ $group->description }}</p>
                    <p class="mt-4 font-bold text-earth">{{ $group->categories->whereNull('parent_id')->count() }} main categories</p>
                </div>
            @endforeach
        </div>

        @foreach($categoryGroups ?? [] as $group)
            <section class="mt-8">
                <h2 class="font-display text-2xl text-pasture">{{ $group->name }}</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($group->categories->whereNull('parent_id') as $cat)
                        <div class="rounded-xl bg-white p-5 shadow-sm">
                            <img src="{{ $cat->image ?: '/assets/defaults/default-animal-image.jpg' }}" class="aspect-video w-full rounded-lg object-cover" alt="{{ $cat->name }}">
                            <div class="mt-3 flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="font-display text-xl">{{ $cat->public_label ?: $cat->name }}</h3>
                                    <p class="text-sm text-charcoal/60">{{ $cat->name }} · {{ $group->name }}</p>
                                </div>
                                <x-badge>{{ $cat->active ? 'Active' : 'Inactive' }}</x-badge>
                            </div>
                            <p class="mt-2 text-sm text-charcoal/60">{{ $cat->description }}</p>
                            <p class="mt-3 text-sm font-bold text-earth">{{ $subcategories->where('parent_id', $cat->id)->count() }} subcategories · {{ collect($listings)->where('category', $cat->name)->count() }} listings</p>
                            <a href="{{ route('admin.categories', ['edit' => $cat->id]) }}#category-form" class="mt-4 inline-flex rounded-lg bg-cream px-4 py-2 font-bold">Edit category</a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

        <form id="category-form" action="{{ $editingCategory ? route('admin.categories.update', $editingCategory) : route('admin.categories.store') }}" method="post" enctype="multipart/form-data" class="mt-8 grid gap-4 rounded-2xl bg-white p-6 shadow-sm md:grid-cols-2">
            @csrf
            <div class="md:col-span-2">
                <h2 class="font-display text-2xl text-pasture">{{ $editingCategory ? 'Edit Category' : 'Add Category' }}</h2>
                <p class="text-sm text-charcoal/60">Main public categories such as Cattle, Hay, or Vet Services.</p>
            </div>
            <select name="category_group_id" class="rounded-lg border border-earth/20 p-3" required>
                @foreach($categoryGroups ?? [] as $group)
                    <option value="{{ $group->id }}" @selected(($editingCategory?->category_group_id) === $group->id)>{{ $group->name }}</option>
                @endforeach
            </select>
            <select name="parent_id" class="rounded-lg border border-earth/20 p-3">
                <option value="">No parent category</option>
                @foreach($categoryGroups ?? [] as $group)
                    @foreach($group->categories->whereNull('parent_id') as $cat)
                        <option value="{{ $cat->id }}" @selected(($editingCategory?->parent_id) === $cat->id)>{{ $cat->public_label ?: $cat->name }}</option>
                    @endforeach
                @endforeach
            </select>
            <input name="name" value="{{ old('name', $editingCategory?->name) }}" class="rounded-lg border border-earth/20 p-3" placeholder="Name" required>
            <input name="public_label" value="{{ old('public_label', $editingCategory?->public_label) }}" class="rounded-lg border border-earth/20 p-3" placeholder="Public label">
            <input name="slug" value="{{ old('slug', $editingCategory?->slug) }}" class="rounded-lg border border-earth/20 p-3" placeholder="Slug">
            <input name="display_order" type="number" value="{{ old('display_order', $editingCategory?->display_order ?? 0) }}" class="rounded-lg border border-earth/20 p-3" placeholder="Display order">
            <input name="image" value="{{ old('image', $editingCategory?->image) }}" class="rounded-lg border border-earth/20 p-3" placeholder="/assets/categories/cattle.jpg">
            <input name="image_upload" type="file" accept="image/*" class="rounded-lg border border-earth/20 p-3">
            <textarea name="description" class="rounded-lg border border-earth/20 p-3 md:col-span-2" placeholder="Description">{{ old('description', $editingCategory?->description) }}</textarea>
            <label class="flex items-center gap-2 font-bold text-earth"><input type="checkbox" name="featured" value="1" @checked($editingCategory?->featured)> Featured</label>
            <label class="flex items-center gap-2 font-bold text-earth"><input type="checkbox" name="active" value="1" @checked($editingCategory?->active ?? true)> Active</label>
            <button class="rounded-lg bg-pasture px-5 py-3 font-bold text-white md:col-span-2">{{ $editingCategory ? 'Save Category' : 'Create Category' }}</button>
        </form>
    @elseif($page === 'category-groups')
        <div class="mt-6 grid gap-4 md:grid-cols-3">
            @foreach($categoryGroups ?? [] as $group)
                <div class="rounded-xl bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between"><h2 class="font-display text-xl text-pasture">{{ $group->name }}</h2><x-badge>{{ $group->active ? 'Active' : 'Inactive' }}</x-badge></div>
                    <p class="mt-2 text-sm text-charcoal/60">{{ $group->description }}</p>
                    <dl class="mt-4 grid gap-2 text-sm"><div class="flex justify-between"><dt class="font-bold text-earth">Slug</dt><dd>{{ $group->slug }}</dd></div><div class="flex justify-between"><dt class="font-bold text-earth">Order</dt><dd>{{ $group->display_order }}</dd></div><div class="flex justify-between"><dt class="font-bold text-earth">Homepage</dt><dd>Visible</dd></div></dl>
                    <a href="{{ route('admin.category-groups', ['edit_group' => $group->id]) }}#group-form" class="mt-4 inline-flex rounded-lg bg-cream px-4 py-2 font-bold">Edit group</a>
                </div>
            @endforeach
        </div>
        <form id="group-form" action="{{ $editingGroup ? route('admin.category-groups.update', $editingGroup) : route('admin.category-groups.store') }}" method="post" class="mt-8 grid gap-4 rounded-2xl bg-white p-6 shadow-sm md:grid-cols-2">
            @csrf
            <h2 class="font-display text-2xl text-pasture md:col-span-2">{{ $editingGroup ? 'Edit Category Group' : 'Create Category Group' }}</h2>
            <input name="name" value="{{ old('name', $editingGroup?->name) }}" class="rounded-lg border border-earth/20 p-3" placeholder="Name" required>
            <input name="slug" value="{{ old('slug', $editingGroup?->slug) }}" class="rounded-lg border border-earth/20 p-3" placeholder="Slug">
            <textarea name="description" class="rounded-lg border border-earth/20 p-3 md:col-span-2" placeholder="Description">{{ old('description', $editingGroup?->description) }}</textarea>
            <input name="display_order" type="number" value="{{ old('display_order', $editingGroup?->display_order ?? 0) }}" class="rounded-lg border border-earth/20 p-3" placeholder="Display order">
            <label class="flex items-center gap-2 rounded-lg border border-earth/20 p-3 font-bold text-earth"><input type="checkbox" name="active" value="1" @checked($editingGroup?->active ?? true)> Active</label>
            <button class="rounded-lg bg-pasture px-5 py-3 font-bold text-white md:col-span-2">Save Category Group</button>
        </form>
    @elseif($page === 'subcategories')
        <div class="mt-6 flex flex-wrap gap-2">@foreach(['Livestock Subcategories','Breeds','Feed Types','Service Types'] as $tab)<span class="rounded-full bg-white px-4 py-2 text-sm font-bold text-earth">{{ $tab }}</span>@endforeach</div>
        <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach($subcategories ?? [] as $sub)
                <div class="rounded-xl bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between"><h2 class="font-display text-xl text-pasture">{{ $sub->public_label ?: $sub->name }}</h2><x-badge>{{ $sub->active ? 'Active' : 'Inactive' }}</x-badge></div>
                    <p class="mt-1 text-sm text-charcoal/60">{{ $sub->parent?->public_label ?: $sub->parent?->name }} · {{ $sub->group?->name }}</p>
                    <p class="mt-2 text-sm text-charcoal/60">{{ $sub->description }}</p>
                    <a href="{{ route('admin.subcategories', ['edit' => $sub->id]) }}#subcategory-form" class="mt-4 inline-flex rounded-lg bg-cream px-4 py-2 font-bold">Edit type</a>
                </div>
            @endforeach
        </div>
        <form id="subcategory-form" action="{{ $editingSubcategory ? route('admin.subcategories.update', $editingSubcategory) : route('admin.subcategories.store') }}" method="post" class="mt-8 grid gap-4 rounded-2xl bg-white p-6 shadow-sm md:grid-cols-2">
            @csrf
            <h2 class="font-display text-2xl text-pasture md:col-span-2">{{ $editingSubcategory ? 'Edit Subcategory / Type' : 'Create Subcategory / Type' }}</h2>
            <select name="parent_id" class="rounded-lg border border-earth/20 p-3" required>
                <option value="">Parent category</option>
                @foreach($categoryGroups ?? [] as $group)
                    @foreach($group->categories->whereNull('parent_id') as $cat)
                        <option value="{{ $cat->id }}" @selected(($editingSubcategory?->parent_id) === $cat->id)>{{ $cat->public_label ?: $cat->name }}</option>
                    @endforeach
                @endforeach
            </select>
            <input name="name" value="{{ old('name', $editingSubcategory?->name) }}" class="rounded-lg border border-earth/20 p-3" placeholder="Name" required>
            <input name="public_label" value="{{ old('public_label', $editingSubcategory?->public_label) }}" class="rounded-lg border border-earth/20 p-3" placeholder="Public label">
            <input name="slug" value="{{ old('slug', $editingSubcategory?->slug) }}" class="rounded-lg border border-earth/20 p-3" placeholder="Slug">
            <textarea name="description" class="rounded-lg border border-earth/20 p-3 md:col-span-2" placeholder="Description">{{ old('description', $editingSubcategory?->description) }}</textarea>
            <input name="display_order" type="number" value="{{ old('display_order', $editingSubcategory?->display_order ?? 0) }}" class="rounded-lg border border-earth/20 p-3" placeholder="Display order">
            <label class="flex items-center gap-2 rounded-lg border border-earth/20 p-3 font-bold text-earth"><input type="checkbox" name="active" value="1" @checked($editingSubcategory?->active ?? true)> Active</label>
            <button class="rounded-lg bg-pasture px-5 py-3 font-bold text-white md:col-span-2">Save Subcategory / Type</button>
        </form>
    @elseif($page === 'reports')
        <div class="mt-6 grid gap-4">
            @forelse($reports as $report)
                <div class="rounded-xl bg-white p-5 shadow-sm">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div><h2 class="font-bold">{{ $report['listing_title'] ?: 'Listing #'.$report['listing_id'] }}</h2><p class="text-sm">{{ $report['reason'] }} · {{ $report['reported_by'] ?: 'Public viewer' }} · {{ $report['created_at'] }}</p></div>
                        <x-badge>{{ ucfirst(str_replace('_', ' ', $report['status'])) }}</x-badge>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach(['review' => 'Review', 'dismiss' => 'Dismiss', 'remove' => 'Remove listing'] as $action => $label)
                            <form method="post" action="{{ route('admin.reports.action', [$report['id'], $action]) }}">@csrf<button class="{{ $action === 'remove' ? 'bg-red-600 text-white' : ($action === 'review' ? 'bg-pasture text-white' : 'bg-cream') }} rounded-lg px-4 py-2 font-bold">{{ $label }}</button></form>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="rounded-2xl bg-white p-8 text-charcoal/60 shadow-sm">No reports need attention.</div>
            @endforelse
        </div>
    @elseif($page === 'inquiries')
        <div class="mt-6 overflow-x-auto rounded-2xl bg-white shadow-sm">
            <table class="w-full min-w-[850px] text-left text-sm">
                <thead class="bg-cream text-earth"><tr><th class="p-4">Listing</th><th>Buyer</th><th>Contact</th><th>Channel</th><th>Message</th><th>Date</th></tr></thead>
                <tbody>
                    @forelse($inquiries ?? [] as $inquiry)
                        <tr class="border-t border-earth/10"><td class="p-4 font-bold">{{ $inquiry->listing?->title }}</td><td>{{ $inquiry->name ?: 'Buyer' }}</td><td>{{ $inquiry->phone ?: $inquiry->email ?: '-' }}</td><td>{{ ucfirst($inquiry->channel) }}</td><td>{{ Str::limit($inquiry->message ?: '-', 60) }}</td><td>{{ $inquiry->created_at?->format('d M Y') }}</td></tr>
                    @empty
                        <tr><td colspan="6" class="p-5 text-center text-charcoal/60">No inquiries recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @elseif($page === 'featured')
        <div class="mt-6 grid gap-4 md:grid-cols-3">
            @forelse(collect($listings)->where('featured', true) as $listing)
                <div class="rounded-xl bg-white p-5 shadow-sm">
                    <img src="{{ $listing['images'][0] }}" class="aspect-video w-full rounded-lg object-cover" alt="{{ $listing['title'] }}">
                    <h2 class="mt-3 font-display text-xl">{{ $listing['title'] }}</h2>
                    <p class="text-sm">Feature expiry: {{ $listing['expiry_date'] }}</p>
                    <form method="post" action="{{ route('admin.listings.moderate', $listing['id']) }}" class="mt-4">@csrf<input type="hidden" name="action" value="extend"><button class="rounded-lg bg-cream px-4 py-2 font-bold">Extend feature period</button></form>
                </div>
            @empty
                <div class="rounded-2xl bg-white p-8 text-charcoal/60 shadow-sm">No featured listings yet.</div>
            @endforelse
        </div>
    @elseif($page === 'settings')
        <form method="post" action="{{ route('admin.settings.save') }}" class="mt-6 grid gap-4 rounded-2xl bg-white p-6 shadow-sm md:grid-cols-2">
            @csrf
            <input type="hidden" name="message" value="Platform settings saved for this demo build.">
            @foreach(['Listing approval required','Default listing duration','Default seller access duration','Default listing allowance','Allow public seller registration','Contact email','Support WhatsApp number','Homepage announcement','Enable featured listings','Enable saved listings','Enable seller auto-approval'] as $field)
                <input class="rounded-lg border border-earth/20 p-3" placeholder="{{ $field }}">
            @endforeach
            <button class="rounded-lg bg-pasture px-5 py-3 font-bold text-white md:col-span-2">Save Settings</button>
        </form>
    @elseif($page === 'audit-logs')
        <div class="mt-6 overflow-x-auto rounded-2xl bg-white shadow-sm"><table class="w-full min-w-[760px] text-left text-sm"><thead class="bg-cream text-earth"><tr><th class="p-4">Action</th><th>Description</th><th>Date</th></tr></thead><tbody>@forelse($auditLogs ?? [] as $log)<tr class="border-t border-earth/10"><td class="p-4 font-bold">{{ $log->action }}</td><td>{{ $log->description }}</td><td>{{ $log->created_at?->format('d M Y H:i') }}</td></tr>@empty<tr><td colspan="3" class="p-5 text-center text-charcoal/60">No audit logs yet.</td></tr>@endforelse</tbody></table></div>
    @else
        <div class="mt-6 grid gap-6 lg:grid-cols-2"><x-chart-placeholder title="Listings posted per month" /><x-chart-placeholder title="Most popular categories" /><x-chart-placeholder title="Most popular counties" /><x-chart-placeholder title="Contact owner clicks" /></div>
    @endif
</x-layouts.admin>
