<?php

namespace App\Http\Controllers;

use App\Models\AdminActivity;
use App\Models\AuditLog;
use App\Models\CategoryGroup;
use App\Models\County;
use App\Models\LivestockCategory;
use App\Models\LivestockListing;
use App\Models\ListingInquiry;
use App\Models\ListingReport;
use App\Models\SellerAccessRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class ZiziniController extends Controller
{
    private function data(): array
    {
        if (! $this->databaseReady()) {
            return config('zizini-demo-data');
        }

        $this->expireListings();
        $categoryMeta = collect(config('zizini-demo-data.categories'))->keyBy('slug');

        return array_merge(config('zizini-demo-data'), [
            'categoryGroups' => CategoryGroup::with(['categories' => fn ($query) => $query->where('active', true)->orderBy('display_order')->orderBy('name')])->where('active', true)->orderBy('display_order')->get(),
            'subcategories' => LivestockCategory::with(['group', 'parent'])->whereNotNull('parent_id')->orderBy('display_order')->orderBy('name')->get(),
            'categories' => LivestockCategory::with(['group', 'parent'])->where('active', true)->whereNull('parent_id')->orderBy('display_order')->orderBy('name')->get()->map(function ($category) use ($categoryMeta) {
                $meta = $categoryMeta->get($category->slug, []);
                $groupSlug = $category->group?->slug;

                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'public_label' => $category->public_label ?? $category->name,
                    'slug' => $category->slug,
                    'count' => LivestockListing::where('category', $category->name)->whereIn('status', ['active', 'unverified'])->count(),
                    'icon' => Arr::get($meta, 'icon', Str::slug($category->name)),
                    'group' => $category->group?->name,
                    'group_slug' => $groupSlug,
                    'description' => $category->description,
                    'parent' => $category->parent?->name,
                    'image' => $category->image ?: Arr::get($meta, 'image', $this->categoryImage($category->slug, $groupSlug)),
                ];
            })->all(),
            'counties' => $this->countiesFromListings(),
            'sellers' => User::whereNotIn('role', ['Admin', 'Super Admin'])->orderBy('name')->get()->map(fn ($seller) => $this->sellerArray($seller))->all(),
            'listings' => LivestockListing::with('seller')->latest()->get()->map(fn ($listing) => $this->listingArray($listing))->all(),
            'access_requests' => SellerAccessRequest::with('seller')->latest()->get()->map(fn ($request) => $this->accessRequestArray($request))->all(),
            'auditLogs' => AuditLog::latest()->take(50)->get(),
            'inquiries' => ListingInquiry::with('listing.seller')->latest()->take(80)->get(),
            'reports' => ListingReport::with('listing')->latest()->get()->map(fn ($report) => [
                'id' => $report->id,
                'listing_id' => $report->listing_id,
                'listing_title' => $report->listing?->title,
                'reason' => $report->reason,
                'reported_by' => $report->reported_by,
                'status' => $report->status,
                'created_at' => $report->created_at?->format('d M Y'),
            ])->all(),
        ]);
    }

    private function view(string $view, array $extra = [])
    {
        return view($view, array_merge($this->data(), $extra));
    }

    public function home()
    {
        if ($this->databaseReady()) {
            $featured = LivestockListing::with('seller')
                ->where('listing_type', 'animal')
                ->whereIn('status', ['active', 'unverified'])
                ->orderByRaw("case when category = 'Cattle' then 0 when category in ('Goats', 'Sheep', 'Poultry') then 1 else 2 end")
                ->orderByDesc('featured')
                ->latest()
                ->take(4)
                ->get()
                ->map(fn ($listing) => $this->listingArray($listing));
        } else {
            $featured = collect($this->data()['listings'])->where('status', 'active')->where('listing_type', 'animal')->take(4)->values();
        }

        return $this->view('public.home', compact('featured'));
    }

    public function marketplace(Request $request)
    {
        $listings = $this->databaseReady()
            ? LivestockListing::with('seller')->whereIn('status', ['active', 'unverified', 'sold'])
            : collect($this->data()['listings']);

        if ($this->databaseReady()) {
            foreach (['category', 'county', 'status', 'breed', 'sex'] as $filter) {
                if ($request->filled($filter)) {
                    $listings->where($filter, $request->string($filter)->toString());
                }
            }
            if ($request->filled('type')) {
                $listings->where('listing_type', $request->string('type')->toString());
            }
            if ($request->filled('purpose')) {
                $listings->whereHas('animalDetail', fn ($query) => $query->where('animal_purpose', $request->string('purpose')->toString()));
            }
            if ($request->filled('unit')) {
                $listings->whereHas('feedDetail', fn ($query) => $query->where('unit', $request->string('unit')->toString()));
            }
            if ($request->filled('target_animal')) {
                $listings->whereHas('feedDetail', fn ($query) => $query->where('target_animal', $request->string('target_animal')->toString()));
            }
            if ($request->filled('provider_type')) {
                $listings->whereHas('serviceDetail', fn ($query) => $query->where('provider_type', $request->string('provider_type')->toString()));
            }
            if ($request->filled('pricing_model')) {
                $listings->whereHas('serviceDetail', fn ($query) => $query->where('pricing_model', $request->string('pricing_model')->toString()));
            }
            if ($request->filled('featured')) {
                $listings->where('featured', true);
            }
            if ($request->filled('min_price')) {
                $listings->where('price', '>=', (int) $request->input('min_price'));
            }
            if ($request->filled('max_price')) {
                $listings->where('price', '<=', (int) $request->input('max_price'));
            }
            if ($request->filled('q')) {
                $q = Str::lower($request->string('q')->toString());
                $listings->where(fn ($query) => $query
                    ->whereRaw('LOWER(title) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(breed) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(county) LIKE ?', ["%{$q}%"]));
            }
            match ($request->input('sort')) {
                'price_asc' => $listings->orderBy('price'),
                'price_desc' => $listings->orderByDesc('price'),
                'featured' => $listings->orderByDesc('featured')->latest(),
                default => $listings->orderByRaw("case when listing_type = 'animal' then 0 when listing_type = 'feed' then 1 else 2 end")->latest(),
            };
            $visibleListings = $listings->get()->map(fn ($listing) => $this->listingArray($listing))->values();
        } else {
            foreach (['category', 'county', 'status', 'breed', 'sex'] as $filter) {
                if ($request->filled($filter)) {
                    $listings = $listings->where($filter, $request->string($filter)->toString());
                }
            }
            if ($request->filled('featured')) {
                $listings = $listings->where('featured', true);
            }
            if ($request->filled('min_price')) {
                $listings = $listings->where('price', '>=', (int) $request->input('min_price'));
            }
            if ($request->filled('max_price')) {
                $listings = $listings->where('price', '<=', (int) $request->input('max_price'));
            }
            if ($request->filled('q')) {
                $q = Str::lower($request->string('q')->toString());
                $listings = $listings->filter(fn ($item) => Str::contains(Str::lower($item['title'].' '.$item['breed'].' '.$item['county']), $q));
            }
            $listings = match ($request->input('sort')) {
                'price_asc' => $listings->sortBy('price'),
                'price_desc' => $listings->sortByDesc('price'),
                'featured' => $listings->sortByDesc('featured'),
                default => $listings,
            };
            $visibleListings = $listings->values();
        }

        return $this->view('public.marketplace', compact('visibleListings'));
    }

    public function listingDetail(string $slug)
    {
        if ($this->databaseReady()) {
            $model = LivestockListing::with('seller')
                ->where('slug', $slug)
                ->whereIn('status', ['active', 'unverified', 'sold'])
                ->firstOrFail();
            $model->increment('views');
            $listing = $this->listingArray($model->fresh('seller'));
            $similar = LivestockListing::with('seller')
                ->where('category', $model->category)
                ->where('id', '!=', $model->id)
                ->whereIn('status', ['active', 'unverified', 'sold'])
                ->take(3)
                ->get()
                ->map(fn ($item) => $this->listingArray($item))
                ->values();

            return $this->view('public.listing-detail', compact('listing', 'similar'));
        }

        $listing = collect($this->data()['listings'])->firstWhere('slug', $slug) ?? $this->data()['listings'][0];
        $similar = collect($this->data()['listings'])->where('category', $listing['category'])->where('slug', '!=', $listing['slug'])->take(3)->values();

        return $this->view('public.listing-detail', compact('listing', 'similar'));
    }

    public function categories()
    {
        return $this->view('public.categories');
    }

    public function categoryDetail(string $category)
    {
        $categoryName = Str::headline(str_replace('-', ' ', $category));
        $visibleListings = collect($this->data()['listings'])->where('category', $categoryName)->values();

        return $this->view('public.collection', [
            'mode' => 'category',
            'title' => $categoryName,
            'visibleListings' => $visibleListings->isEmpty() ? collect($this->data()['listings'])->take(4) : $visibleListings,
        ]);
    }

    public function counties()
    {
        return $this->view('public.counties');
    }

    public function countyDetail(string $county)
    {
        $countyName = collect($this->data()['counties'])->firstWhere('slug', $county)['name'] ?? Str::headline($county);
        $visibleListings = collect($this->data()['listings'])->where('county', $countyName)->values();

        return $this->view('public.collection', [
            'mode' => 'county',
            'title' => $countyName,
            'visibleListings' => $visibleListings->isEmpty() ? collect($this->data()['listings'])->take(4) : $visibleListings,
        ]);
    }

    public function simplePage(string $page)
    {
        return $this->view('public.simple', ['page' => $page]);
    }

    public function futureModule()
    {
        return $this->view('public.future-module');
    }

    public function guide()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        return $this->view('guide.index', [
            'guideRole' => Auth::user()?->isAdmin() ? 'admin' : (Auth::check() ? 'seller' : 'public'),
        ]);
    }

    public function sellerRegister()
    {
        return $this->view('seller.register');
    }

    public function registerSeller(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255', 'unique:zizini_users,email'],
            'county' => ['required', 'string', 'max:100'],
            'business_name' => ['nullable', 'string', 'max:255'],
            'seller_type' => ['required', 'string', 'max:100'],
            'password' => ['required', 'confirmed', 'min:8'],
            'terms' => ['accepted'],
        ]);

        $seller = User::create([
            ...Arr::except($validated, ['password', 'terms']),
            'password' => Hash::make($validated['password']),
            'role' => 'Reseller',
            'approval_status' => 'Pending',
            'posting_status' => 'Not approved',
            'listing_allowance_total' => 0,
        ]);

        SellerAccessRequest::create([
            'seller_id' => $seller->id,
            'requested_role' => 'Reseller',
            'requested_listing_count' => 5,
            'requested_duration' => '30 days',
            'status' => 'Pending',
        ]);

        Auth::login($seller);

        return redirect()->route('seller.pending')->with('status', 'Seller application submitted. Admin approval is required before posting.');
    }

    public function login()
    {
        if (! $this->databaseReady() && request()->cookie('zizini_demo_role') === 'seller') {
            return redirect()->route('seller.dashboard');
        }

        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')->with('status', 'You are already logged in as admin.')
                : redirect()->route('seller.dashboard');
        }

        return $this->view('seller.login');
    }

    public function authenticate(Request $request)
    {
        if (! $this->databaseReady()) {
            $login = $request->input('login', '');
            $password = $request->input('password', '');
            $isAdminRoute = $request->routeIs('admin.login.store');
            $validSeller = in_array($login, ['hello@wanjikufarm.test', '+254 712 345 678', '0712345678'], true) && $password === 'password';
            $validAdmin = in_array($login, ['admin@zizini.co.ke', 'admin@zizini'], true) && $password === 'password';

            if ($isAdminRoute && $validAdmin) {
                return redirect()->route('admin.dashboard')->withCookie(cookie('zizini_demo_role', 'admin', 120));
            }

            if (! $isAdminRoute && $validSeller) {
                return redirect()->route('seller.dashboard')->withCookie(cookie('zizini_demo_role', 'seller', 120));
            }

            return redirect($isAdminRoute ? route('admin.login') : route('login'));
        }

        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $login = $credentials['login'] === 'admin@zizini' ? 'admin@zizini.co.ke' : $credentials['login'];
        $user = User::where('email', $login)->orWhere('phone', $login)->first();

        if (! $user || ! Hash::check($credentials['password'], (string) $user->password)) {
            return back()->with('status', 'Invalid login details.');
        }
        if ($request->routeIs('admin.login.store') && ! $user->isAdmin()) {
            return back()->with('status', 'This login is for admins only. Use the seller login for seller accounts.');
        }
        if ($request->routeIs('login.store') && $user->isAdmin()) {
            return back()->with('status', 'This login is for sellers only. Use Admin Login to continue.');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended($user->isAdmin() ? route('admin.dashboard') : route('seller.dashboard'));
    }

    public function logout(Request $request)
    {
        if (! $this->databaseReady()) {
            return redirect()->route('home')->withCookie(cookie()->forget('zizini_demo_role'));
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Logged out.');
    }

    public function sellerDashboard()
    {
        if (! $this->databaseReady()) {
            $seller = $this->data()['sellers'][0];
            $sellerListings = collect($this->data()['listings'])->where('seller_id', $seller['id'])->values();

            return $this->view('seller.dashboard', [
                'seller' => array_merge(['can_post' => true], $seller),
                'sellerStats' => [
                    'active' => $sellerListings->where('status', 'active')->count(),
                    'unverified' => 0,
                    'pending' => $sellerListings->where('status', 'pending')->count(),
                    'sold' => $sellerListings->where('status', 'sold')->count(),
                    'expired' => $sellerListings->where('status', 'expired')->count(),
                    'clicks' => $sellerListings->sum('contact_clicks'),
                ],
                'recentListings' => $sellerListings->take(5),
                'recentInquiries' => collect(),
            ]);
        }

        $sellerModel = Auth::user();
        $seller = $this->sellerArray($sellerModel);
        $sellerListings = $sellerModel->listings()->latest()->get();
        $listingIds = $sellerListings->pluck('id');

        return $this->view('seller.dashboard', [
            'seller' => $seller,
            'sellerStats' => [
                'active' => $sellerListings->whereIn('status', ['active', 'unverified'])->count(),
                'unverified' => $sellerListings->where('status', 'unverified')->count(),
                'pending' => $sellerListings->where('status', 'pending')->count(),
                'sold' => $sellerListings->where('status', 'sold')->count(),
                'expired' => $sellerListings->where('status', 'expired')->count(),
                'clicks' => $sellerListings->sum('contact_clicks'),
            ],
            'recentListings' => $sellerListings->take(5)->map(fn ($listing) => $this->listingArray($listing))->values(),
            'recentInquiries' => ListingInquiry::with('listing')->whereIn('listing_id', $listingIds)->latest()->take(5)->get(),
        ]);
    }

    public function sellerListings()
    {
        if (! $this->databaseReady()) {
            return $this->view('seller.listings', [
                'sellerListings' => collect($this->data()['listings'])->where('seller_id', $this->data()['sellers'][0]['id'])->values(),
            ]);
        }

        $sellerListings = Auth::user()->listings()->latest()->get()->map(fn ($listing) => $this->listingArray($listing))->values();

        return $this->view('seller.listings', compact('sellerListings'));
    }

    public function sellerCreate(string $step)
    {
        if (! $this->databaseReady()) {
            $seller = array_merge(['can_post' => true], $this->data()['sellers'][0]);

            return $this->view('seller.create', compact('step', 'seller'));
        }

        $seller = $this->sellerArray(Auth::user());

        return $this->view('seller.create', compact('step', 'seller'));
    }

    public function storeSellerListing(Request $request)
    {
        $seller = Auth::user();

        if (! $seller->hasActivePostingAccess()) {
            return back()->with('status', 'You do not currently have permission or allowance to publish new listings. Please contact admin.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'listing_type' => ['nullable', 'in:animal,feed,service'],
            'category' => ['required', 'string', 'max:100'],
            'breed' => ['nullable', 'string', 'max:100'],
            'sex' => ['nullable', 'string', 'max:50'],
            'age' => ['nullable', 'string', 'max:100'],
            'price' => ['nullable', 'integer', 'min:0'],
            'county' => ['required', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'health_status' => ['nullable', 'string', 'max:255'],
            'vaccination_status' => ['nullable', 'string', 'max:255'],
            'milk_production' => ['nullable', 'string', 'max:100'],
            'weight' => ['nullable', 'string', 'max:100'],
            'owner_phone' => ['nullable', 'string', 'max:50'],
            'owner_whatsapp' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:3000'],
            'price_negotiable' => ['nullable', 'boolean'],
            'preferred_contact' => ['nullable', 'string', 'max:50'],
        ]);
        $listingType = $validated['listing_type'] ?? 'animal';
        $category = LivestockCategory::where('name', $validated['category'])->first();
        $county = County::where('name', $validated['county'])->first();
        $groupSlug = ['animal' => 'livestock', 'feed' => 'feeds', 'service' => 'services'][$listingType];
        $group = CategoryGroup::where('slug', $groupSlug)->first();

        $listing = LivestockListing::create([
            ...$validated,
            'seller_id' => $seller->id,
            'listing_type' => $listingType,
            'category_group_id' => $group?->id,
            'category_id' => $category?->id,
            'county_id' => $county?->id,
            'slug' => Str::slug($validated['title']).'-'.Str::lower(Str::random(6)),
            'owner_phone' => ($validated['owner_phone'] ?? null) ?: $seller->phone,
            'owner_whatsapp' => ($validated['owner_whatsapp'] ?? null) ?: $seller->whatsapp,
            'status' => 'unverified',
            'verified' => false,
            'verified_badge' => false,
            'published_at' => now(),
            'expires_at' => now()->addDays($seller->default_listing_duration ?: 30),
            'price_type' => $listingType === 'service' ? 'quote' : ($request->boolean('price_negotiable') ? 'negotiable' : 'fixed'),
            'images' => [$this->defaultListingImage($listingType)],
        ]);

        if ($listingType === 'animal') {
            \App\Models\AnimalDetail::create(['listing_id' => $listing->id, 'species' => $validated['category'], 'breed' => $validated['breed'] ?? null, 'sex' => $validated['sex'] ?? null, 'age' => $validated['age'] ?? null, 'health_status' => $validated['health_status'] ?? null, 'vaccination_status' => $validated['vaccination_status'] ?? null, 'quantity' => 1]);
        } elseif ($listingType === 'feed') {
            \App\Models\FeedDetail::create(['listing_id' => $listing->id, 'feed_type' => $validated['breed'] ?? $validated['category'], 'target_animal' => $validated['sex'] ?? null, 'unit' => $validated['weight'] ?? null, 'quantity_available' => $validated['milk_production'] ?? null]);
        } else {
            \App\Models\ServiceDetail::create(['listing_id' => $listing->id, 'service_type' => $validated['breed'] ?? $validated['category'], 'provider_type' => $validated['sex'] ?? 'company', 'service_area' => $validated['location'] ?? $validated['county'], 'availability' => $validated['age'] ?? 'By appointment', 'pricing_model' => 'quote', 'quote_note' => $validated['milk_production'] ?? null]);
        }

        $seller->increment('listing_allowance_used');

        return redirect()->route('livestock.show', $listing->slug)->with('status', 'Listing published. It is live but still awaiting admin verification.');
    }

    public function updateSellerListingStatus(LivestockListing $listing, string $status)
    {
        abort_unless($listing->seller_id === Auth::id(), 403);
        abort_unless(in_array($status, ['sold', 'draft', 'expired'], true), 422);

        $listing->update(['status' => $status]);

        return back()->with('status', 'Listing updated.');
    }

    public function sellerSimple(string $page)
    {
        if (! $this->databaseReady()) {
            $seller = array_merge(['can_post' => true], $this->data()['sellers'][0]);
            $sellerListings = collect($this->data()['listings'])->where('seller_id', $seller['id'])->values();

            return $this->view('seller.simple', [
                'page' => $page,
                'seller' => $seller,
                'sellerListings' => $sellerListings,
                'sellerInquiries' => collect(),
            ]);
        }

        $sellerModel = Auth::user();
        $sellerListings = $sellerModel->listings()->latest()->get();

        return $this->view('seller.simple', [
            'page' => $page,
            'seller' => $this->sellerArray($sellerModel),
            'sellerListings' => $sellerListings->map(fn ($listing) => $this->listingArray($listing))->values(),
            'sellerInquiries' => ListingInquiry::with('listing')->whereIn('listing_id', $sellerListings->pluck('id'))->latest()->take(20)->get(),
        ]);
    }

    public function buyerSaved()
    {
        return $this->view('public.saved', ['savedListings' => collect($this->data()['listings'])->take(3)]);
    }

    public function inquirySent(Request $request)
    {
        $listing = $this->databaseReady() && $request->filled('listing')
            ? $this->listingArray(LivestockListing::where('slug', $request->string('listing'))->firstOrFail())
            : $this->data()['listings'][0];

        return $this->view('public.inquiry-sent', ['listing' => $listing]);
    }

    public function storeInquiry(Request $request, LivestockListing $listing)
    {
        $this->abortUnlessPublicListing($listing);

        $validated = $request->validate([
            'channel' => ['required', 'in:email,phone,whatsapp,form'],
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        ListingInquiry::create([...$validated, 'listing_id' => $listing->id]);

        $listing->increment('contact_clicks');
        if ($validated['channel'] === 'phone') {
            $listing->increment('call_clicks');
        } elseif ($validated['channel'] === 'whatsapp') {
            $listing->increment('whatsapp_clicks');
        } else {
            $listing->increment('email_clicks');
        }

        return redirect()->route('inquiry.sent', ['listing' => $listing->slug])->with('status', 'Inquiry sent to the seller through Zizini.');
    }

    public function redirectContact(LivestockListing $listing, string $channel)
    {
        abort_unless(in_array($channel, ['call', 'whatsapp'], true), 404);
        $this->abortUnlessPublicListing($listing);

        $listing->increment('contact_clicks');
        $phone = preg_replace('/\D+/', '', $listing->owner_phone ?: $listing->seller?->phone ?: '');
        $whatsapp = preg_replace('/\D+/', '', $listing->owner_whatsapp ?: $listing->seller?->whatsapp ?: $listing->owner_phone ?: $listing->seller?->phone ?: '');

        if ($channel === 'call') {
            $listing->increment('call_clicks');
            abort_if($phone === '', 404);

            return redirect()->away('tel:+'.$phone);
        }

        $listing->increment('whatsapp_clicks');
        abort_if($whatsapp === '', 404);
        $message = urlencode('Hello, I saw your '.$listing->title.' on Zizini.co.ke. Is it still available?');

        return redirect()->away('https://wa.me/'.$whatsapp.'?text='.$message);
    }

    public function reportListing(Request $request, LivestockListing $listing)
    {
        $this->abortUnlessPublicListing($listing);

        $validated = $request->validate([
            'reason' => ['required', 'string', 'max:1000'],
            'reported_by' => ['nullable', 'string', 'max:255'],
            'reporter_contact' => ['nullable', 'string', 'max:255'],
        ]);

        ListingReport::create([...$validated, 'listing_id' => $listing->id, 'status' => 'Open']);

        return back()->with('status', 'Report submitted. Admin will review this listing.');
    }

    public function adminLogin()
    {
        if (! $this->databaseReady() && request()->cookie('zizini_demo_role') === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('seller.dashboard')->with('status', 'You are logged in as a seller. Log out before using admin login.');
        }

        return $this->view('admin.login');
    }

    public function adminDashboard()
    {
        $stats = $this->databaseReady() ? [
            ['Total listings', LivestockListing::count(), 'All records'],
            ['Live listings', LivestockListing::whereIn('status', ['active', 'unverified'])->count(), 'Active + unverified'],
            ['Unverified listings', LivestockListing::where('status', 'unverified')->count(), 'Needs admin review'],
            ['Expired listings', LivestockListing::where('status', 'expired')->count(), 'Renewal candidates'],
            ['Sold listings', LivestockListing::where('status', 'sold')->count(), 'Marked sold'],
            ['Registered sellers', User::whereNotIn('role', ['Admin', 'Super Admin'])->count(), 'Seller accounts'],
            ['Awaiting approval', User::where('approval_status', 'Pending')->count(), 'Access requests'],
            ['Open reports', ListingReport::where('status', 'Open')->count(), 'Needs moderation'],
        ] : [];
        $dashboardData = $this->databaseReady() ? [
            'statusCounts' => LivestockListing::select('status', DB::raw('count(*) as total'))->groupBy('status')->orderBy('status')->pluck('total', 'status'),
            'categoryCounts' => LivestockListing::select('category', DB::raw('count(*) as total'))->groupBy('category')->orderByDesc('total')->take(8)->pluck('total', 'category'),
            'countyCounts' => LivestockListing::select('county', DB::raw('count(*) as total'))->groupBy('county')->orderByDesc('total')->take(8)->pluck('total', 'county'),
            'recentReports' => ListingReport::with('listing')->latest()->take(5)->get(),
            'recentListings' => LivestockListing::with('seller')->latest()->take(6)->get()->map(fn ($listing) => $this->listingArray($listing)),
            'expiringSellers' => User::whereNotIn('role', ['Admin', 'Super Admin'])->whereNotNull('access_end_date')->orderBy('access_end_date')->take(6)->get(),
        ] : [];

        return $this->view('admin.dashboard', compact('stats', 'dashboardData'));
    }

    public function adminListings(Request $request)
    {
        if ($this->databaseReady()) {
            $query = $this->adminListingQuery($request)->with('seller');

            $adminListings = $query->latest()->get()->map(fn ($listing) => $this->listingArray($listing))->values();
            $adminFilters = [
                'sellers' => User::whereNotIn('role', ['Admin', 'Super Admin'])->orderBy('name')->get(),
                'categories' => LivestockCategory::orderBy('name')->get(),
                'counties' => LivestockListing::query()->whereNotNull('county')->distinct()->orderBy('county')->pluck('county'),
                'statuses' => ['active', 'unverified', 'pending', 'rejected', 'sold', 'expired', 'draft', 'taken_down'],
                'statusCounts' => $this->adminListingQuery($request, ['status'])
                    ->select('status', DB::raw('count(*) as total'))
                    ->groupBy('status')
                    ->pluck('total', 'status'),
            ];
            $selectedSeller = $request->filled('seller_id') ? User::find((int) $request->input('seller_id')) : null;
            $summaryCounts = [
                'total' => (clone $this->adminListingQuery($request, ['status']))->count(),
                'active' => (clone $this->adminListingQuery($request, ['status']))->where('status', 'active')->count(),
                'unverified' => (clone $this->adminListingQuery($request, ['status']))->where('status', 'unverified')->count(),
                'pending' => (clone $this->adminListingQuery($request, ['status']))->where('status', 'pending')->count(),
            ];
        } else {
            $adminListings = collect($this->data()['listings']);
            $adminFilters = [
                'sellers' => collect(),
                'categories' => collect(),
                'counties' => collect(),
                'statuses' => ['active', 'pending', 'rejected', 'sold', 'expired', 'draft'],
                'statusCounts' => collect(),
            ];
            $selectedSeller = null;
            $summaryCounts = [
                'total' => $adminListings->count(),
                'active' => $adminListings->where('status', 'active')->count(),
                'unverified' => $adminListings->where('status', 'unverified')->count(),
                'pending' => $adminListings->where('status', 'pending')->count(),
            ];
        }

        return $this->view('admin.listings', compact('adminListings', 'adminFilters', 'selectedSeller', 'summaryCounts'));
    }

    public function bulkModerateListings(Request $request)
    {
        $validated = $request->validate([
            'action' => ['required', 'in:verify,take_down,expire'],
            'q' => ['nullable', 'string'],
            'seller_id' => ['nullable', 'integer'],
            'status' => ['nullable', 'string'],
            'category' => ['nullable', 'string'],
            'county' => ['nullable', 'string'],
        ]);

        $query = $this->adminListingQuery($request);
        $updates = match ($validated['action']) {
            'verify' => ['status' => 'active', 'verified' => true, 'verified_at' => now()],
            'take_down' => ['status' => 'taken_down', 'taken_down_at' => now()],
            'expire' => ['status' => 'expired'],
        };
        $count = $query->update($updates);

        $this->logAdmin('bulk_listing_'.$validated['action'], new LivestockListing(['id' => null]));

        return redirect()->route('admin.listings', $request->only(['q', 'seller_id', 'status', 'category', 'county']))
            ->with('status', "{$count} listing(s) updated.");
    }

    public function adminCreateListing()
    {
        return $this->view('admin.listing-form', [
            'listing' => null,
            'sellers' => User::whereNotIn('role', ['Admin', 'Super Admin'])->orderBy('name')->get(),
        ]);
    }

    public function storeAdminListing(Request $request)
    {
        $listing = LivestockListing::create($this->listingPayload($request) + [
            'slug' => Str::slug($request->string('title')).'-'.Str::lower(Str::random(6)),
            'status' => $request->input('status', 'active'),
            'verified' => $request->boolean('verified', true),
            'published_at' => now(),
            'verified_at' => $request->boolean('verified', true) ? now() : null,
            'images' => ['/assets/brand/coming-soon-web.png'],
        ]);

        $this->logAdmin('listing_created', $listing);

        return redirect()->route('admin.listings.show', $listing->id)->with('status', 'Admin listing created.');
    }

    public function adminEditListing(LivestockListing $listing)
    {
        return $this->view('admin.listing-form', [
            'listing' => $this->listingArray($listing->load('seller')),
            'listingModel' => $listing,
            'sellers' => User::whereNotIn('role', ['Admin', 'Super Admin'])->orderBy('name')->get(),
        ]);
    }

    public function updateAdminListing(Request $request, LivestockListing $listing)
    {
        $listing->update($this->listingPayload($request) + [
            'status' => $request->input('status', $listing->status),
            'verified' => $request->boolean('verified'),
            'verified_at' => $request->boolean('verified') ? ($listing->verified_at ?? now()) : null,
        ]);

        $this->logAdmin('listing_updated', $listing);

        return redirect()->route('admin.listings.show', $listing->id)->with('status', 'Listing updated.');
    }

    public function destroyAdminListing(LivestockListing $listing)
    {
        $listing->delete();
        $this->logAdmin('listing_deleted', $listing);

        return redirect()->route('admin.listings')->with('status', 'Listing deleted.');
    }

    public function adminListingReview(int $id)
    {
        $listing = $this->databaseReady()
            ? $this->listingArray(LivestockListing::with('seller')->findOrFail($id))
            : (collect($this->data()['listings'])->firstWhere('id', $id) ?? $this->data()['listings'][0]);

        return $this->view('admin.listing-review', compact('listing'));
    }

    public function moderateListing(Request $request, LivestockListing $listing)
    {
        $validated = $request->validate([
            'action' => ['required', 'in:verify,reject,feature,expire,sold,take_down,extend'],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $updates = ['admin_notes' => $validated['admin_notes'] ?? $listing->admin_notes];
        match ($validated['action']) {
            'verify' => $updates += ['status' => 'active', 'verified' => true, 'verified_at' => now()],
            'reject' => $updates += ['status' => 'rejected'],
            'feature' => $updates += ['featured' => true],
            'expire' => $updates += ['status' => 'expired'],
            'sold' => $updates += ['status' => 'sold'],
            'take_down' => $updates += ['status' => 'taken_down', 'taken_down_at' => now()],
            'extend' => $updates += ['expires_at' => now()->addDays(30), 'status' => $listing->status === 'expired' ? 'active' : $listing->status],
        };

        $listing->update($updates);
        $this->logAdmin('listing_'.$validated['action'], $listing);

        return back()->with('status', 'Listing moderation updated.');
    }

    public function adminUsers(Request $request)
    {
        if (! $this->databaseReady()) {
            return $this->view('admin.users', ['userFilters' => $request->all()]);
        }

        $query = User::withCount([
            'listings as live_listings_count' => fn ($inner) => $inner->whereIn('status', ['active', 'unverified']),
        ])->whereNotIn('role', ['Admin', 'Super Admin']);

        if ($request->filled('q')) {
            $q = Str::lower($request->string('q')->toString());
            $query->where(fn ($inner) => $inner
                ->whereRaw('LOWER(name) LIKE ?', ["%{$q}%"])
                ->orWhereRaw('LOWER(email) LIKE ?', ["%{$q}%"])
                ->orWhereRaw('LOWER(phone) LIKE ?', ["%{$q}%"])
                ->orWhereRaw('LOWER(COALESCE(business_name, \'\')) LIKE ?', ["%{$q}%"]));
        }
        foreach (['county', 'role', 'approval_status', 'posting_status', 'seller_type'] as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->string($filter)->toString());
            }
        }
        if ($request->filled('verified')) {
            $query->where('verified', $request->boolean('verified'));
        }
        if ($request->input('access_state') === 'expired') {
            $query->whereDate('access_end_date', '<', now());
        } elseif ($request->input('access_state') === 'expiring') {
            $query->whereBetween('access_end_date', [now(), now()->addDays(14)]);
        } elseif ($request->input('access_state') === 'active') {
            $query->whereDate('access_end_date', '>=', now());
        } elseif ($request->input('access_state') === 'no_access') {
            $query->whereNull('access_end_date');
        }

        $sellers = $query->orderBy('name')->get()->map(function (User $seller) {
            $row = $this->sellerArray($seller);
            $row['active_listing_count'] = $seller->live_listings_count ?? 0;

            return $row;
        })->all();
        $approvalCounts = User::whereNotIn('role', ['Admin', 'Super Admin'])
            ->select('approval_status', DB::raw('count(*) as total'))
            ->groupBy('approval_status')
            ->pluck('total', 'approval_status');

        return $this->view('admin.users', [
            'sellers' => $sellers,
            'userFilters' => $request->all(),
            'approvalCounts' => $approvalCounts,
            'userFilterOptions' => [
                'counties' => User::whereNotNull('county')->distinct()->orderBy('county')->pluck('county'),
                'roles' => User::whereNotIn('role', ['Admin', 'Super Admin'])->whereNotNull('role')->distinct()->orderBy('role')->pluck('role'),
                'sellerTypes' => User::whereNotNull('seller_type')->distinct()->orderBy('seller_type')->pluck('seller_type'),
            ],
        ]);
    }

    public function adminUserDetail(int $id)
    {
        if ($this->databaseReady()) {
            $sellerModel = User::with(['listings' => fn ($query) => $query->latest(), 'accessRequests' => fn ($query) => $query->latest()])->findOrFail($id);
            abort_if($sellerModel->isAdmin(), 404);
            $seller = $this->sellerArray($sellerModel);
            $sellerStats = [
                'total' => $sellerModel->listings->count(),
                'active' => $sellerModel->listings->whereIn('status', ['active', 'unverified'])->count(),
                'unverified' => $sellerModel->listings->where('status', 'unverified')->count(),
                'sold' => $sellerModel->listings->where('status', 'sold')->count(),
                'expired' => $sellerModel->listings->where('status', 'expired')->count(),
                'reports' => ListingReport::whereIn('listing_id', $sellerModel->listings->pluck('id'))->where('status', 'Open')->count(),
                'clicks' => $sellerModel->listings->sum('contact_clicks'),
            ];
            $sellerListings = $sellerModel->listings->take(6)->map(fn ($listing) => $this->listingArray($listing))->values();
            $accessRequests = $sellerModel->accessRequests->map(fn ($request) => $this->accessRequestArray($request))->values();
        } else {
            $seller = collect($this->data()['sellers'])->firstWhere('id', $id) ?? $this->data()['sellers'][0];
            $sellerStats = ['total' => 0, 'active' => 0, 'unverified' => 0, 'sold' => 0, 'expired' => 0, 'reports' => 0, 'clicks' => 0];
            $sellerListings = collect();
            $accessRequests = collect();
        }

        return $this->view('admin.user-detail', compact('seller', 'sellerStats', 'sellerListings', 'accessRequests'));
    }

    public function updateSellerAccess(Request $request, User $seller)
    {
        abort_if($seller->isAdmin(), 404);

        $validated = $request->validate([
            'role' => ['required', 'in:Seller,Reseller,Verified Seller,Farm/Dealer'],
            'posting_status' => ['required', 'in:Not approved,Approved,Suspended,Expired'],
            'listing_allowance_total' => ['required', 'integer', 'min:0'],
            'access_start_date' => ['nullable', 'date'],
            'access_end_date' => ['nullable', 'date'],
            'default_listing_duration' => ['required', 'integer', 'min:1'],
            'admin_notes' => ['nullable', 'string', 'max:3000'],
        ]);

        $seller->update([
            ...$validated,
            'approval_status' => $validated['posting_status'] === 'Approved' ? 'Approved' : $seller->approval_status,
            'verified' => in_array($validated['role'], ['Verified Seller', 'Farm/Dealer'], true),
        ]);

        $this->logAdmin('seller_access_updated', $seller);

        return back()->with('status', 'Seller access settings saved.');
    }

    public function updateSellerProfile(Request $request, User $seller)
    {
        abort_if($seller->isAdmin(), 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:zizini_users,email,'.$seller->id],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'county' => ['nullable', 'string', 'max:100'],
            'seller_type' => ['nullable', 'string', 'max:100'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $this->storePublicUpload($request->file('logo'), 'seller-logos');
        }
        unset($validated['logo']);

        $seller->update($validated);
        $this->logAdmin('seller_profile_updated', $seller);

        return back()->with('status', 'Seller profile updated.');
    }

    public function adminAccessRequests()
    {
        return $this->view('admin.access-requests');
    }

    public function reviewAccessRequest(SellerAccessRequest $accessRequest, string $decision)
    {
        abort_unless(in_array($decision, ['approve', 'reject'], true), 422);

        DB::transaction(function () use ($accessRequest, $decision) {
            $seller = $accessRequest->seller;
            $accessRequest->update([
                'status' => $decision === 'approve' ? 'Approved' : 'Rejected',
                'reviewed_at' => now(),
                'reviewed_by' => Auth::id(),
            ]);

            if ($decision === 'approve') {
                $seller->update([
                    'role' => 'Reseller',
                    'approval_status' => 'Approved',
                    'posting_status' => 'Approved',
                    'listing_allowance_total' => max($seller->listing_allowance_total, $accessRequest->requested_listing_count ?: 5),
                    'access_start_date' => now(),
                    'access_end_date' => now()->addDays((int) filter_var($accessRequest->requested_duration, FILTER_SANITIZE_NUMBER_INT) ?: 30),
                    'default_listing_duration' => 30,
                ]);
            } else {
                $seller->update(['approval_status' => 'Rejected', 'posting_status' => 'Not approved']);
            }
        });

        return back()->with('status', 'Access request reviewed.');
    }

    public function adminSimple(string $page)
    {
        return $this->view('admin.simple', ['page' => $page]);
    }

    public function updateSellerLogo(Request $request)
    {
        $validated = $request->validate([
            'logo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        /** @var User $seller */
        $seller = Auth::user();
        $seller->update([
            'logo_path' => $this->storePublicUpload($validated['logo'], 'seller-logos'),
        ]);

        return back()->with('status', 'Seller logo updated.');
    }

    public function storeCategoryGroup(Request $request)
    {
        $group = CategoryGroup::create($this->categoryGroupPayload($request));
        $this->logAdmin('category_group_created', $group);

        return redirect()->route('admin.category-groups', ['edit_group' => $group->id])
            ->with('status', 'Category group created.');
    }

    public function updateCategoryGroup(Request $request, CategoryGroup $categoryGroup)
    {
        $categoryGroup->update($this->categoryGroupPayload($request));
        $this->logAdmin('category_group_updated', $categoryGroup);

        return redirect()->route('admin.category-groups', ['edit_group' => $categoryGroup->id])
            ->with('status', 'Category group updated.');
    }

    public function storeCategory(Request $request)
    {
        $category = LivestockCategory::create($this->categoryPayload($request));
        $this->logAdmin('category_created', $category);

        return redirect()->route('admin.categories', ['edit' => $category->id])
            ->with('status', 'Category created.');
    }

    public function updateCategory(Request $request, LivestockCategory $category)
    {
        $category->update($this->categoryPayload($request));
        $this->logAdmin('category_updated', $category);

        return redirect()->route('admin.categories', ['edit' => $category->id])
            ->with('status', 'Category updated.');
    }

    public function storeSubcategory(Request $request)
    {
        $category = LivestockCategory::create($this->categoryPayload($request, parentRequired: true));
        $this->logAdmin('subcategory_created', $category);

        return redirect()->route('admin.subcategories', ['edit' => $category->id])
            ->with('status', 'Subcategory/type created.');
    }

    public function updateSubcategory(Request $request, LivestockCategory $category)
    {
        $category->update($this->categoryPayload($request, parentRequired: true));
        $this->logAdmin('subcategory_updated', $category);

        return redirect()->route('admin.subcategories', ['edit' => $category->id])
            ->with('status', 'Subcategory/type updated.');
    }

    public function handleReport(ListingReport $report, string $action)
    {
        abort_unless(in_array($action, ['review', 'dismiss', 'remove'], true), 422);

        match ($action) {
            'review' => $report->update(['status' => 'reviewed']),
            'dismiss' => $report->update(['status' => 'dismissed']),
            'remove' => DB::transaction(function () use ($report) {
                $report->update(['status' => 'action_taken']);
                $report->listing?->update(['status' => 'taken_down', 'taken_down_at' => now()]);
            }),
        };

        $this->logAdmin('report_'.$action, $report);

        return back()->with('status', 'Report action saved.');
    }

    public function fakeAction(Request $request)
    {
        return back()->with('status', $request->input('message', 'Prototype state updated.'));
    }

    private function categoryGroupPayload(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:140'],
            'description' => ['nullable', 'string', 'max:1000'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'boolean'],
        ]);

        return [
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?: Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'display_order' => $validated['display_order'] ?? 0,
            'active' => $request->boolean('active'),
        ];
    }

    private function categoryPayload(Request $request, bool $parentRequired = false): array
    {
        $validated = $request->validate([
            'category_group_id' => [$parentRequired ? 'nullable' : 'required', 'exists:category_groups,id'],
            'parent_id' => [$parentRequired ? 'required' : 'nullable', 'exists:livestock_categories,id'],
            'name' => ['required', 'string', 'max:120'],
            'public_label' => ['nullable', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:140'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'featured' => ['nullable', 'boolean'],
            'active' => ['nullable', 'boolean'],
        ]);

        $parent = empty($validated['parent_id']) ? null : LivestockCategory::find($validated['parent_id']);
        $image = $validated['image'] ?? null;
        if ($request->hasFile('image_upload')) {
            $image = $this->storePublicUpload($request->file('image_upload'), 'categories');
        }

        return [
            'category_group_id' => $parent?->category_group_id ?? $validated['category_group_id'],
            'parent_id' => $validated['parent_id'] ?? null,
            'name' => $validated['name'],
            'public_label' => $validated['public_label'] ?: $validated['name'],
            'slug' => $validated['slug'] ?: Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'image' => $image,
            'display_order' => $validated['display_order'] ?? 0,
            'featured' => $request->boolean('featured'),
            'active' => $request->boolean('active'),
        ];
    }

    private function storePublicUpload($file, string $folder): string
    {
        $target = public_path('assets/uploads/'.$folder);
        if (! is_dir($target)) {
            mkdir($target, 0775, true);
        }

        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'-'.Str::lower(Str::random(8)).'.'.$file->getClientOriginalExtension();
        $file->move($target, $name);

        return '/assets/uploads/'.$folder.'/'.$name;
    }

    private function databaseReady(): bool
    {
        try {
            $connection = config('database.default');
            $driver = config("database.connections.$connection.driver");

            if ($driver && ! in_array($driver, \PDO::getAvailableDrivers(), true)) {
                return false;
            }

            return Schema::hasTable('livestock_listings') && Schema::hasTable('zizini_users');
        } catch (Throwable) {
            return false;
        }
    }

    private function expireListings(): void
    {
        try {
            LivestockListing::whereIn('status', ['active', 'unverified'])
                ->whereDate('expires_at', '<', now())
                ->update(['status' => 'expired']);

            LivestockListing::whereIn('status', ['active', 'unverified'])
                ->whereHas('seller', fn ($query) => $query->whereDate('access_end_date', '<', now()))
                ->update(['status' => 'expired']);
        } catch (Throwable) {
            //
        }
    }

    private function listingArray(LivestockListing $listing): array
    {
        $seller = $listing->seller;

        return [
            'id' => $listing->id,
            'slug' => $listing->slug,
            'title' => $listing->title,
            'category' => $listing->category,
            'breed' => $listing->breed,
            'price' => $listing->price ?? 0,
            'county' => $listing->county,
            'location' => $listing->location,
            'age' => $listing->age,
            'sex' => $listing->sex,
            'health_status' => $listing->health_status,
            'vaccination_status' => $listing->vaccination_status,
            'milk_production' => $listing->milk_production,
            'weight' => $listing->weight,
            'seller_id' => $seller?->id,
            'seller_name' => $seller?->name ?? 'Zizini Seller',
            'seller_logo' => $seller?->logo_path ?: '/assets/seller-logos/default-company-logo.png',
            'seller_phone' => $listing->owner_phone ?: $seller?->phone,
            'seller_whatsapp' => $listing->owner_whatsapp ?: $seller?->whatsapp,
            'seller_verified' => (bool) ($seller?->verified || $listing->verified),
            'seller_badge' => $seller?->role ?? 'Reseller',
            'featured' => $listing->featured,
            'verified' => $listing->verified,
            'status' => $listing->status,
            'views' => $listing->views,
            'contact_clicks' => $listing->contact_clicks,
            'whatsapp_clicks' => $listing->whatsapp_clicks,
            'call_clicks' => $listing->call_clicks,
            'expiry_date' => $listing->expires_at?->format('d M Y') ?? ucfirst($listing->status),
            'images' => $listing->images ?: ['/assets/brand/coming-soon-web.png'],
            'description' => $listing->description,
            'listing_type' => $listing->listing_type ?? 'animal',
            'type_label' => match ($listing->listing_type ?? 'animal') {
                'feed' => 'Feed / Farm Input',
                'service' => 'Service',
                default => 'Animal',
            },
            'price_type' => $listing->price_type ?? 'negotiable',
        ];
    }

    private function abortUnlessPublicListing(LivestockListing $listing): void
    {
        abort_unless(in_array($listing->status, ['active', 'unverified', 'sold'], true), 404);
    }

    private function categoryImage(string $slug, ?string $groupSlug = null): string
    {
        return match ($slug) {
            'hay', 'silage' => '/assets/feeds/hay-silage.jpg',
            'dairy-meal', 'poultry-feed', 'mineral-supplements', 'pasture-seeds', 'farm-equipment', 'feeds' => '/assets/feeds/fodder-africa.jpg',
            'animal-transport' => '/assets/services/livestock-transport.jpg',
            'veterinary-services', 'breeding-services', 'ai-advisory' => '/assets/services/livestock-market-support.jpg',
            'farm-consulting', 'movement-permit-support' => '/assets/services/livestock-market-support.jpg',
            default => match ($groupSlug) {
                'feeds' => '/assets/defaults/default-feed-image.jpg',
                'services' => '/assets/defaults/default-service-image.jpg',
                default => '/assets/defaults/default-animal-image.jpg',
            },
        };
    }

    private function defaultListingImage(string $listingType): string
    {
        return match ($listingType) {
            'feed' => '/assets/defaults/default-feed-image.jpg',
            'service' => '/assets/defaults/default-service-image.jpg',
            default => '/assets/defaults/default-animal-image.jpg',
        };
    }

    private function sellerArray(User $seller): array
    {
        return [
            'id' => $seller->id,
            'name' => $seller->name,
            'phone' => $seller->phone,
            'whatsapp' => $seller->whatsapp,
            'email' => $seller->email,
            'logo_path' => $seller->logo_path ?: '/assets/seller-logos/default-company-logo.png',
            'county' => $seller->county,
            'seller_type' => $seller->seller_type,
            'role' => $seller->role,
            'approval_status' => $seller->approval_status,
            'verified' => $seller->verified,
            'posting_status' => $seller->posting_status,
            'listing_allowance_total' => $seller->listing_allowance_total,
            'listing_allowance_used' => $seller->listing_allowance_used,
            'listing_allowance_remaining' => $seller->remaining_allowance,
            'can_post' => $seller->hasActivePostingAccess(),
            'access_start_date' => $seller->access_start_date?->format('d M Y') ?? '-',
            'access_end_date' => $seller->access_end_date?->format('d M Y') ?? '-',
            'default_listing_duration' => $seller->default_listing_duration,
            'admin_notes' => $seller->admin_notes,
            'joined_date' => $seller->created_at?->format('d M Y') ?? '-',
            'access_start_date_input' => $seller->access_start_date?->format('Y-m-d'),
            'access_end_date_input' => $seller->access_end_date?->format('Y-m-d'),
        ];
    }

    private function accessRequestArray(SellerAccessRequest $request): array
    {
        return [
            'id' => $request->id,
            'seller_id' => $request->seller_id,
            'seller_name' => $request->seller?->name ?? 'Unknown Seller',
            'requested_role' => $request->requested_role,
            'requested_listing_count' => $request->requested_listing_count,
            'requested_duration' => $request->requested_duration,
            'status' => $request->status,
            'created_at' => $request->created_at?->format('d M Y'),
        ];
    }

    private function countiesFromListings(): array
    {
        return LivestockListing::query()
            ->select('county', DB::raw('count(*) as count'))
            ->whereNotNull('county')
            ->groupBy('county')
            ->orderBy('county')
            ->get()
            ->map(fn ($row) => ['name' => $row->county, 'slug' => Str::slug($row->county), 'count' => $row->count])
            ->all();
    }

    private function logAdmin(string $action, object $subject): void
    {
        if (! $this->databaseReady()) {
            return;
        }

        AdminActivity::create([
            'admin_id' => Auth::id(),
            'action' => $action,
            'subject_type' => $subject::class,
            'subject_id' => $subject->id ?? null,
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'subject_type' => $subject::class,
            'subject_id' => $subject->id ?? null,
            'description' => Str::headline(str_replace('_', ' ', $action)),
            'metadata' => ['source' => 'admin_ui'],
            'ip_address' => request()?->ip(),
        ]);
    }

    private function adminListingQuery(Request $request, array $except = [])
    {
        $query = LivestockListing::query();

        foreach (['status', 'category', 'county'] as $filter) {
            if (! in_array($filter, $except, true) && $request->filled($filter)) {
                $query->where($filter, $request->string($filter)->toString());
            }
        }
        if (! in_array('seller_id', $except, true) && $request->filled('seller_id')) {
            $query->where('seller_id', (int) $request->input('seller_id'));
        }
        if (! in_array('q', $except, true) && $request->filled('q')) {
            $q = Str::lower($request->string('q')->toString());
            $query->where(fn ($inner) => $inner
                ->whereRaw('LOWER(title) LIKE ?', ["%{$q}%"])
                ->orWhereRaw('LOWER(breed) LIKE ?', ["%{$q}%"])
                ->orWhereRaw('LOWER(county) LIKE ?', ["%{$q}%"]));
        }

        return $query;
    }

    private function listingPayload(Request $request): array
    {
        $validated = $request->validate([
            'seller_id' => ['required', 'exists:zizini_users,id'],
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'breed' => ['nullable', 'string', 'max:100'],
            'sex' => ['nullable', 'string', 'max:50'],
            'age' => ['nullable', 'string', 'max:100'],
            'price' => ['nullable', 'integer', 'min:0'],
            'county' => ['required', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'health_status' => ['nullable', 'string', 'max:255'],
            'vaccination_status' => ['nullable', 'string', 'max:255'],
            'milk_production' => ['nullable', 'string', 'max:100'],
            'weight' => ['nullable', 'string', 'max:100'],
            'owner_phone' => ['nullable', 'string', 'max:50'],
            'owner_whatsapp' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:3000'],
            'price_negotiable' => ['nullable', 'boolean'],
            'preferred_contact' => ['nullable', 'string', 'max:50'],
            'featured' => ['nullable', 'boolean'],
            'expires_at' => ['nullable', 'date'],
        ]);

        abort_if(User::whereKey($validated['seller_id'])->whereIn('role', ['Admin', 'Super Admin'])->exists(), 422);

        return $validated;
    }
}
