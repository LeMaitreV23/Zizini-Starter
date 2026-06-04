<?php

namespace Database\Seeders;

use App\Models\LivestockCategory;
use App\Models\LivestockListing;
use App\Models\ListingInquiry;
use App\Models\ListingImage;
use App\Models\ListingReport;
use App\Models\SellerAccessRequest;
use App\Models\AnimalDetail;
use App\Models\AuditLog;
use App\Models\CategoryGroup;
use App\Models\County;
use App\Models\FeedDetail;
use App\Models\ServiceDetail;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $data = config('zizini-demo-data');

        $admin = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@zizini.co.ke')],
            [
                'name' => 'Zizini Admin',
                'phone' => '+254 700 000 000',
                'whatsapp' => '+254 700 000 000',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
                'role' => 'Admin',
                'approval_status' => 'Approved',
                'posting_status' => 'Approved',
                'verified' => true,
                'listing_allowance_total' => 999,
                'access_start_date' => now(),
                'access_end_date' => now()->addYears(5),
            ],
        );

        foreach ($data['counties'] as $county) {
            County::updateOrCreate(
                ['slug' => $county['slug']],
                ['name' => $county['name'], 'active' => true],
            );
        }

        $groups = [
            'livestock' => ['name' => 'Livestock', 'description' => 'Cattle, goats, sheep, poultry and other livestock for sale.'],
            'feeds' => ['name' => 'Feeds & Farm Inputs', 'description' => 'Hay, silage, feed, supplements, pasture seed and farm inputs.'],
            'services' => ['name' => 'Livestock Services', 'description' => 'Veterinary, transport, breeding, permits and farm advisory services.'],
        ];
        foreach ($groups as $slug => $group) {
            CategoryGroup::updateOrCreate(
                ['slug' => $slug],
                ['name' => $group['name'], 'description' => $group['description'], 'active' => true, 'display_order' => array_search($slug, array_keys($groups), true) + 1],
            );
        }

        $groupIds = CategoryGroup::pluck('id', 'slug');
        $structuredCategories = [
            'livestock' => [
                ['Cattle', 'cattle', 'Dairy cows, beef animals, bulls, heifers and calves.'],
                ['Goats', 'goats', 'Dairy goats, meat goats, breeding bucks and does.'],
                ['Sheep', 'sheep', 'Dorper, wool and meat sheep from farms and cooperatives.'],
                ['Poultry', 'poultry', 'Kienyeji, layers, broilers and poultry batches.'],
                ['Pigs', 'pigs', 'Piglets, sows, boars and pork production stock.'],
                ['Donkeys', 'donkeys', 'Working donkeys and farm transport animals.'],
                ['Camels', 'camels', 'Dairy and breeding camels from arid and pastoral regions.'],
            ],
            'feeds' => [
                ['Hay', 'hay', 'Dry hay bales and roughage for cattle, goats and sheep.'],
                ['Silage', 'silage', 'Stored forage and silage for dairy and beef animals.'],
                ['Dairy Meal', 'dairy-meal', 'Dairy meal and supplements for milk production.'],
                ['Poultry Feed', 'poultry-feed', 'Feed for layers, broilers and kienyeji poultry.'],
                ['Mineral Supplements', 'mineral-supplements', 'Mineral blocks and livestock nutrition support.'],
                ['Pasture Seeds', 'pasture-seeds', 'Pasture seed and fodder establishment inputs.'],
                ['Farm Equipment', 'farm-equipment', 'Small farm tools and livestock equipment.'],
            ],
            'services' => [
                ['Animal Transport', 'animal-transport', 'Livestock movement and transport providers.'],
                ['Veterinary Services', 'veterinary-services', 'Farm visits, vaccination, treatment and herd health support.'],
                ['Breeding Services', 'breeding-services', 'Artificial insemination and breeding support.'],
                ['Farm Consulting', 'farm-consulting', 'Farm planning, herd management and feeding advice.'],
                ['Movement Permit Support', 'movement-permit-support', 'Documentation and movement permit guidance.'],
                ['AI Advisory', 'ai-advisory', 'Artificial insemination advisory and coordination.'],
            ],
        ];

        $categoryImages = [
            'cattle' => '/assets/categories/cattle.jpg',
            'goats' => '/assets/livestock/goat-real.jpg',
            'sheep' => '/assets/livestock/sheep-real.jpg',
            'poultry' => '/assets/livestock/chicken.jpg',
            'pigs' => '/assets/livestock/cows-field.jpg',
            'donkeys' => '/assets/categories/donkeys.jpg',
            'camels' => '/assets/categories/camels.jpg',
            'hay' => '/assets/feeds/hay-silage.jpg',
            'silage' => '/assets/feeds/silage-bales.jpg',
            'dairy-meal' => '/assets/feeds/fodder-africa.jpg',
            'poultry-feed' => '/assets/feeds/fodder-africa.jpg',
            'mineral-supplements' => '/assets/defaults/default-feed-image.jpg',
            'pasture-seeds' => '/assets/defaults/default-feed-image.jpg',
            'farm-equipment' => '/assets/defaults/default-feed-image.jpg',
            'animal-transport' => '/assets/services/livestock-transport.jpg',
            'veterinary-services' => '/assets/services/livestock-market-support.jpg',
            'breeding-services' => '/assets/services/livestock-market-support.jpg',
            'farm-consulting' => '/assets/services/livestock-market-support.jpg',
            'movement-permit-support' => '/assets/services/livestock-market-support.jpg',
            'ai-advisory' => '/assets/services/livestock-market-support.jpg',
        ];
        $publicLabels = [
            'animal-transport' => 'Transport',
            'veterinary-services' => 'Vet Services',
            'breeding-services' => 'Breeding / AI',
            'farm-consulting' => 'Farm Advice',
            'movement-permit-support' => 'Movement Permits',
            'ai-advisory' => 'AI Help',
        ];

        foreach ($structuredCategories as $groupSlug => $categories) {
            foreach ($categories as $index => [$name, $slug, $description]) {
                LivestockCategory::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'category_group_id' => $groupIds[$groupSlug] ?? null,
                        'parent_id' => null,
                        'name' => $name,
                        'public_label' => $publicLabels[$slug] ?? $name,
                        'description' => $description,
                        'image' => $categoryImages[$slug] ?? null,
                        'active' => true,
                        'display_order' => $index + 1,
                        'featured' => $index < 3,
                        'breeds' => [],
                    ],
                );
            }
        }

        $subcategories = [
            'cattle' => ['Dairy Cattle', 'Beef Cattle', 'Breeding Bulls', 'Heifers', 'Calves', 'Pregnant Cows', 'Milking Cows'],
            'goats' => ['Dairy Goats', 'Meat Goats', 'Breeding Goats'],
            'sheep' => ['Dorper', 'Red Maasai', 'Breeding Sheep'],
            'poultry' => ['Layers', 'Broilers', 'Kienyeji', 'Chicks'],
            'hay' => ['Rhodes Hay', 'Boma Rhodes', 'Lucerne Hay'],
            'silage' => ['Maize Silage', 'Napier Silage'],
            'dairy-meal' => ['Dairy Meal Bags', 'Calf Pellets'],
            'poultry-feed' => ['Layers Mash', 'Broiler Starter', 'Chick Mash'],
            'animal-transport' => ['Truck Transport', 'Short Distance Transport'],
            'veterinary-services' => ['Farm Visit', 'Vaccination', 'Treatment'],
            'breeding-services' => ['Artificial Insemination', 'Breeding Advice'],
            'farm-consulting' => ['Dairy Farm Advice', 'Feeding Plan'],
            'movement-permit-support' => ['Permit Guidance', 'Document Support'],
            'ai-advisory' => ['Artificial Insemination Help'],
        ];
        foreach ($subcategories as $parentSlug => $items) {
            $parent = LivestockCategory::where('slug', $parentSlug)->first();
            if (! $parent) {
                continue;
            }
            foreach ($items as $index => $name) {
                LivestockCategory::updateOrCreate(
                    ['slug' => Str::slug($parentSlug.'-'.$name)],
                    [
                        'category_group_id' => $parent->category_group_id,
                        'parent_id' => $parent->id,
                        'name' => $name,
                        'public_label' => $name,
                        'description' => $name.' listings and types under '.$parent->public_label.'.',
                        'image' => $parent->image,
                        'active' => true,
                        'display_order' => $index + 1,
                        'featured' => false,
                        'breeds' => [],
                    ],
                );
            }
        }

        foreach ($data['sellers'] as $seller) {
            User::updateOrCreate(
                ['email' => $seller['email']],
                [
                    'name' => $seller['name'],
                    'phone' => $seller['phone'],
                    'whatsapp' => $seller['whatsapp'],
                    'logo_path' => $seller['logo_path'] ?? null,
                    'password' => Hash::make('password'),
                    'county' => $seller['county'],
                    'seller_type' => $seller['seller_type'],
                    'role' => $seller['role'],
                    'approval_status' => $seller['approval_status'] === 'Awaiting Approval' ? 'Pending' : $seller['approval_status'],
                    'posting_status' => $seller['posting_status'],
                    'verified' => $seller['verified'],
                    'listing_allowance_total' => $seller['listing_allowance_total'],
                    'listing_allowance_used' => $seller['listing_allowance_used'],
                    'access_start_date' => $this->parseDemoDate($seller['access_start_date']),
                    'access_end_date' => $this->parseDemoDate($seller['access_end_date']),
                    'default_listing_duration' => $seller['default_listing_duration'],
                ],
            );
        }

        $scenarioSellers = [
            [
                'name' => 'Rift Valley Grazers',
                'email' => 'pending@zizini.test',
                'phone' => '+254 700 111 001',
                'whatsapp' => '+254 700 111 001',
                'county' => 'Uasin Gishu',
                'logo_path' => null,
                'seller_type' => 'Individual farmer',
                'role' => 'Reseller',
                'approval_status' => 'Pending',
                'posting_status' => 'Not approved',
                'verified' => false,
                'listing_allowance_total' => 0,
                'listing_allowance_used' => 0,
                'access_start_date' => null,
                'access_end_date' => null,
            ],
            [
                'name' => 'Kericho Highlands Dairy',
                'email' => 'expired@zizini.test',
                'phone' => '+254 700 111 002',
                'whatsapp' => '+254 700 111 002',
                'county' => 'Kericho',
                'logo_path' => null,
                'seller_type' => 'Farm/dealer',
                'role' => 'Verified Seller',
                'approval_status' => 'Approved',
                'posting_status' => 'Expired',
                'verified' => true,
                'listing_allowance_total' => 12,
                'listing_allowance_used' => 12,
                'access_start_date' => now()->subDays(90),
                'access_end_date' => now()->subDays(5),
            ],
            [
                'name' => 'Isiolo Plains Livestock',
                'email' => 'suspended@zizini.test',
                'phone' => '+254 700 111 003',
                'whatsapp' => '+254 700 111 003',
                'county' => 'Isiolo',
                'logo_path' => null,
                'seller_type' => 'Broker',
                'role' => 'Reseller',
                'approval_status' => 'Approved',
                'posting_status' => 'Suspended',
                'verified' => false,
                'listing_allowance_total' => 5,
                'listing_allowance_used' => 2,
                'access_start_date' => now()->subDays(20),
                'access_end_date' => now()->addDays(10),
            ],
            [
                'name' => 'Naivasha Poultry Cooperative',
                'email' => 'approved@zizini.test',
                'phone' => '+254 700 111 004',
                'whatsapp' => '+254 700 111 004',
                'county' => 'Nakuru',
                'logo_path' => '/assets/brand/logo-symbol.png',
                'seller_type' => 'Cooperative',
                'role' => 'Reseller',
                'approval_status' => 'Approved',
                'posting_status' => 'Approved',
                'verified' => false,
                'listing_allowance_total' => 20,
                'listing_allowance_used' => 4,
                'access_start_date' => now()->subDays(10),
                'access_end_date' => now()->addDays(80),
            ],
            [
                'name' => 'Nyeri Fresh Feeds',
                'email' => 'feeds@zizini.test',
                'phone' => '+254 700 111 005',
                'whatsapp' => '+254 700 111 005',
                'county' => 'Nyeri',
                'logo_path' => null,
                'seller_type' => 'Feed supplier',
                'role' => 'Verified Seller',
                'approval_status' => 'Approved',
                'posting_status' => 'Approved',
                'verified' => true,
                'listing_allowance_total' => 30,
                'listing_allowance_used' => 6,
                'access_start_date' => now()->subMonths(3),
                'access_end_date' => now()->addDays(14),
            ],
            [
                'name' => 'Garissa Camel Dairy',
                'email' => 'camels@zizini.test',
                'phone' => '+254 700 111 006',
                'whatsapp' => '+254 700 111 006',
                'county' => 'Garissa',
                'logo_path' => null,
                'seller_type' => 'Pastoral farm',
                'role' => 'Farm/Dealer',
                'approval_status' => 'Approved',
                'posting_status' => 'Approved',
                'verified' => true,
                'listing_allowance_total' => 18,
                'listing_allowance_used' => 5,
                'access_start_date' => now()->subDays(45),
                'access_end_date' => now()->addDays(45),
            ],
            [
                'name' => 'Machakos Donkey Traders',
                'email' => 'donkeys@zizini.test',
                'phone' => '+254 700 111 007',
                'whatsapp' => '+254 700 111 007',
                'county' => 'Machakos',
                'logo_path' => null,
                'seller_type' => 'Broker',
                'role' => 'Reseller',
                'approval_status' => 'Rejected',
                'posting_status' => 'Not approved',
                'verified' => false,
                'listing_allowance_total' => 0,
                'listing_allowance_used' => 0,
                'access_start_date' => null,
                'access_end_date' => null,
            ],
        ];

        foreach ($scenarioSellers as $seller) {
            User::updateOrCreate(
                ['email' => $seller['email']],
                array_merge($seller, [
                    'password' => Hash::make('password'),
                    'default_listing_duration' => 30,
                ]),
            );
        }

        foreach ($data['listings'] as $listing) {
            $seller = User::where('email', $data['sellers'][$listing['seller_id'] - 1]['email'] ?? null)->first() ?? $admin;
            LivestockListing::updateOrCreate(
                ['slug' => $listing['slug']],
                [
                    'seller_id' => $seller->id,
                    'title' => $listing['title'],
                    'category' => $listing['category'],
                    'breed' => $listing['breed'],
                    'price' => $listing['price'],
                    'county' => $listing['county'],
                    'location' => $listing['location'],
                    'age' => $listing['age'],
                    'sex' => $listing['sex'],
                    'health_status' => $listing['health_status'],
                    'vaccination_status' => $listing['vaccination_status'],
                    'milk_production' => $listing['milk_production'],
                    'weight' => $listing['weight'],
                    'description' => $listing['description'],
                    'owner_phone' => $listing['seller_phone'],
                    'owner_whatsapp' => $listing['seller_whatsapp'],
                    'featured' => $listing['featured'],
                    'verified' => $listing['seller_verified'],
                    'status' => $listing['status'],
                    'views' => $listing['views'],
                    'contact_clicks' => $listing['contact_clicks'],
                    'whatsapp_clicks' => $listing['whatsapp_clicks'],
                    'call_clicks' => $listing['call_clicks'],
                    'expires_at' => Str::contains($listing['expiry_date'], '2026') ? date('Y-m-d', strtotime($listing['expiry_date'])) : null,
                    'images' => $listing['images'],
                    'published_at' => now()->subDays(7),
                    'verified_at' => $listing['seller_verified'] ? now()->subDays(6) : null,
                ],
            );
        }

        $scenarioListings = [
            ['seller' => 'approved@zizini.test', 'slug' => 'hyline-layer-pullets-naivasha', 'title' => 'Hy-Line Layer Pullets', 'category' => 'Poultry', 'breed' => 'Layers', 'price' => 28000, 'county' => 'Nakuru', 'location' => 'Naivasha', 'age' => '6 months', 'sex' => 'Female', 'status' => 'unverified', 'verified' => false, 'featured' => false, 'expires_at' => now()->addDays(26), 'image' => '/assets/livestock/chicken.jpg'],
            ['seller' => 'approved@zizini.test', 'slug' => 'kienyeji-breeding-roosters-gilgil', 'title' => 'Kienyeji Breeding Roosters', 'category' => 'Poultry', 'breed' => 'Kienyeji', 'price' => 16500, 'county' => 'Nakuru', 'location' => 'Gilgil', 'age' => '8 months', 'sex' => 'Male', 'status' => 'active', 'verified' => true, 'featured' => true, 'expires_at' => now()->addDays(35), 'image' => '/assets/livestock/chicken.jpg'],
            ['seller' => 'expired@zizini.test', 'slug' => 'friesian-heifer-litein', 'title' => 'Friesian Dairy Heifer', 'category' => 'Cattle', 'breed' => 'Friesian', 'price' => 76000, 'county' => 'Kericho', 'location' => 'Litein', 'age' => '2 years', 'sex' => 'Female', 'status' => 'expired', 'verified' => true, 'featured' => false, 'expires_at' => now()->subDays(3), 'image' => '/assets/livestock/cow-ayrshire.jpg'],
            ['seller' => 'suspended@zizini.test', 'slug' => 'boran-breeding-bull-isiolo', 'title' => 'Boran Breeding Bull', 'category' => 'Cattle', 'breed' => 'Boran', 'price' => 132000, 'county' => 'Isiolo', 'location' => 'Isiolo Town', 'age' => '5 years', 'sex' => 'Male', 'status' => 'taken_down', 'verified' => false, 'featured' => false, 'expires_at' => now()->addDays(12), 'image' => '/assets/livestock/bull-real.jpg'],
            ['seller' => 'pending@zizini.test', 'slug' => 'boer-cross-buck-eldoret', 'title' => 'Boer Cross Buck', 'category' => 'Goats', 'breed' => 'Boer', 'price' => 22000, 'county' => 'Uasin Gishu', 'location' => 'Eldoret', 'age' => '14 months', 'sex' => 'Male', 'status' => 'draft', 'verified' => false, 'featured' => false, 'expires_at' => null, 'image' => '/assets/livestock/goat-real.jpg'],
            ['seller' => 'approved@zizini.test', 'slug' => 'dorper-ewe-naivasha', 'title' => 'Dorper Breeding Ewe', 'category' => 'Sheep', 'breed' => 'Dorper', 'price' => 19000, 'county' => 'Nakuru', 'location' => 'Naivasha', 'age' => '1 year', 'sex' => 'Female', 'status' => 'rejected', 'verified' => false, 'featured' => false, 'expires_at' => now()->addDays(20), 'image' => '/assets/livestock/sheep-real.jpg'],
            ['seller' => 'approved@zizini.test', 'slug' => 'toggenburg-dairy-doe-bahati', 'title' => 'Toggenburg Dairy Doe', 'category' => 'Goats', 'breed' => 'Toggenburg', 'price' => 24500, 'county' => 'Nakuru', 'location' => 'Bahati', 'age' => '2 years', 'sex' => 'Female', 'status' => 'sold', 'verified' => true, 'featured' => false, 'expires_at' => now()->addDays(8), 'image' => '/assets/livestock/goat-real.jpg'],
            ['seller' => 'approved@zizini.test', 'slug' => 'artificial-insemination-service-nakuru', 'title' => 'Artificial Insemination Service', 'category' => 'Breeding Services', 'breed' => 'Dairy cattle', 'price' => 2500, 'county' => 'Nakuru', 'location' => 'Nakuru Town', 'age' => null, 'sex' => 'Mixed', 'status' => 'active', 'verified' => true, 'featured' => true, 'expires_at' => now()->addDays(60), 'image' => '/assets/services/livestock-market-support.jpg'],
            ['seller' => 'feeds@zizini.test', 'slug' => 'rhodes-hay-bales-nyeri', 'title' => 'Rhodes Grass Hay Bales', 'category' => 'Hay', 'breed' => 'Rhodes grass', 'price' => 350, 'county' => 'Nyeri', 'location' => 'Karatina', 'age' => null, 'sex' => 'Mixed', 'status' => 'active', 'verified' => true, 'featured' => false, 'expires_at' => now()->addDays(12), 'image' => '/assets/feeds/hay-silage.jpg'],
            ['seller' => 'feeds@zizini.test', 'slug' => 'dairy-meal-70kg-nyeri', 'title' => 'Dairy Meal 70kg Bags', 'category' => 'Dairy Meal', 'breed' => 'Dairy supplement', 'price' => 3200, 'county' => 'Nyeri', 'location' => 'Nyeri Town', 'age' => null, 'sex' => 'Mixed', 'status' => 'unverified', 'verified' => false, 'featured' => false, 'expires_at' => now()->addDays(22), 'image' => '/assets/feeds/fodder-africa.jpg'],
            ['seller' => 'feeds@zizini.test', 'slug' => 'maize-silage-nanyuki', 'title' => 'Maize Silage', 'category' => 'Silage', 'breed' => 'Maize silage', 'price' => 4500, 'county' => 'Laikipia', 'location' => 'Nanyuki', 'age' => null, 'sex' => 'Cattle', 'status' => 'active', 'verified' => true, 'featured' => false, 'expires_at' => now()->addDays(18), 'image' => '/assets/feeds/silage-bales.jpg'],
            ['seller' => 'feeds@zizini.test', 'slug' => 'poultry-feed-layers-kiambu', 'title' => 'Layers Poultry Feed', 'category' => 'Poultry Feed', 'breed' => 'Layers mash', 'price' => 2900, 'county' => 'Kiambu', 'location' => 'Limuru', 'age' => null, 'sex' => 'Poultry', 'status' => 'active', 'verified' => true, 'featured' => false, 'expires_at' => now()->addDays(28), 'image' => '/assets/feeds/fodder-africa.jpg'],
            ['seller' => 'camels@zizini.test', 'slug' => 'lactating-camel-garissa', 'title' => 'Lactating Camel', 'category' => 'Camels', 'breed' => 'Somali camel', 'price' => 185000, 'county' => 'Garissa', 'location' => 'Balambala', 'age' => '6 years', 'sex' => 'Female', 'status' => 'active', 'verified' => true, 'featured' => true, 'expires_at' => now()->addDays(40), 'image' => '/assets/categories/camels.jpg'],
            ['seller' => 'camels@zizini.test', 'slug' => 'young-camel-bull-garissa', 'title' => 'Young Camel Bull', 'category' => 'Camels', 'breed' => 'Rendille cross', 'price' => 145000, 'county' => 'Garissa', 'location' => 'Dadaab Road', 'age' => '3 years', 'sex' => 'Male', 'status' => 'pending', 'verified' => false, 'featured' => false, 'expires_at' => null, 'image' => '/assets/categories/camels.jpg'],
            ['seller' => 'donkeys@zizini.test', 'slug' => 'working-donkey-machakos', 'title' => 'Working Donkey', 'category' => 'Donkeys', 'breed' => 'Local', 'price' => 28000, 'county' => 'Machakos', 'location' => 'Kangundo', 'age' => '4 years', 'sex' => 'Male', 'status' => 'rejected', 'verified' => false, 'featured' => false, 'expires_at' => null, 'image' => '/assets/categories/donkeys.jpg'],
            ['seller' => 'expired@zizini.test', 'slug' => 'expired-ai-service-kericho', 'title' => 'Artificial Insemination Visit', 'category' => 'Breeding Services', 'breed' => 'Dairy cattle', 'price' => 3000, 'county' => 'Kericho', 'location' => 'Kericho Town', 'age' => null, 'sex' => 'Mixed', 'status' => 'expired', 'verified' => true, 'featured' => false, 'expires_at' => now()->subDays(14), 'image' => '/assets/services/livestock-market-support.jpg'],
            ['seller' => 'camels@zizini.test', 'slug' => 'livestock-transport-garissa-nairobi', 'title' => 'Livestock Transport Garissa to Nairobi', 'category' => 'Animal Transport', 'breed' => 'Truck transport', 'price' => 0, 'county' => 'Garissa', 'location' => 'Garissa and Nairobi route', 'age' => 'Weekdays', 'sex' => 'Company', 'status' => 'active', 'verified' => true, 'featured' => false, 'expires_at' => now()->addDays(50), 'image' => '/assets/services/livestock-transport.jpg'],
            ['seller' => 'feeds@zizini.test', 'slug' => 'farm-consulting-nyeri', 'title' => 'Dairy Feeding Consultation', 'category' => 'Farm Consulting', 'breed' => 'Dairy advisory', 'price' => 0, 'county' => 'Nyeri', 'location' => 'Nyeri and nearby counties', 'age' => 'By appointment', 'sex' => 'Consultant', 'status' => 'unverified', 'verified' => false, 'featured' => false, 'expires_at' => now()->addDays(30), 'image' => '/assets/services/livestock-market-support.jpg'],
            ['seller' => 'suspended@zizini.test', 'slug' => 'suspended-goat-listing-isiolo', 'title' => 'Small East African Doe', 'category' => 'Goats', 'breed' => 'SEA', 'price' => 13500, 'county' => 'Isiolo', 'location' => 'Merti', 'age' => '18 months', 'sex' => 'Female', 'status' => 'taken_down', 'verified' => false, 'featured' => false, 'expires_at' => now()->addDays(7), 'image' => '/assets/livestock/goat-real.jpg'],
        ];

        foreach ($scenarioListings as $listing) {
            $seller = User::where('email', $listing['seller'])->first() ?? $admin;
            LivestockListing::updateOrCreate(
                ['slug' => $listing['slug']],
                [
                    'seller_id' => $seller->id,
                    'title' => $listing['title'],
                    'category' => $listing['category'],
                    'breed' => $listing['breed'],
                    'price' => $listing['price'],
                    'county' => $listing['county'],
                    'location' => $listing['location'],
                    'age' => $listing['age'],
                    'sex' => $listing['sex'],
                    'health_status' => 'Healthy',
                    'vaccination_status' => 'Up to date',
                    'description' => $listing['title'].' seeded for workflow testing.',
                    'owner_phone' => $seller->phone,
                    'owner_whatsapp' => $seller->whatsapp,
                    'featured' => $listing['featured'],
                    'verified' => $listing['verified'],
                    'status' => $listing['status'],
                    'views' => rand(15, 320),
                    'contact_clicks' => rand(0, 50),
                    'whatsapp_clicks' => rand(0, 20),
                    'call_clicks' => rand(0, 20),
                    'email_clicks' => rand(0, 10),
                    'expires_at' => $listing['expires_at'],
                    'images' => [$listing['image']],
                    'published_at' => in_array($listing['status'], ['active', 'unverified', 'sold'], true) ? now()->subDays(3) : null,
                    'verified_at' => $listing['verified'] ? now()->subDays(2) : null,
                    'taken_down_at' => $listing['status'] === 'taken_down' ? now()->subDay() : null,
                ],
            );
        }

        foreach ($data['access_requests'] as $request) {
            $seller = User::where('name', $request['seller_name'])->first();
            if (! $seller) {
                continue;
            }

            SellerAccessRequest::updateOrCreate(
                ['seller_id' => $seller->id, 'requested_role' => $request['requested_role']],
                [
                    'requested_listing_count' => $request['requested_listing_count'],
                    'requested_duration' => $request['requested_duration'],
                    'status' => $request['status'],
                ],
            );
        }

        foreach (['pending@zizini.test', 'expired@zizini.test', 'donkeys@zizini.test', 'feeds@zizini.test', 'camels@zizini.test'] as $email) {
            $seller = User::where('email', $email)->first();
            SellerAccessRequest::updateOrCreate(
                ['seller_id' => $seller->id, 'requested_role' => 'Reseller'],
                [
                    'requested_listing_count' => match ($email) {
                        'pending@zizini.test' => 8,
                        'donkeys@zizini.test' => 6,
                        default => 15,
                    },
                    'requested_duration' => match ($email) {
                        'pending@zizini.test' => '30 days',
                        'donkeys@zizini.test' => '45 days',
                        default => '90 days',
                    },
                    'status' => match ($email) {
                        'donkeys@zizini.test' => 'Rejected',
                        'feeds@zizini.test', 'camels@zizini.test' => 'Approved',
                        default => 'Pending',
                    },
                ],
            );
        }

        foreach ($data['reports'] as $report) {
            $listing = LivestockListing::where('slug', $data['listings'][$report['listing_id'] - 1]['slug'] ?? null)->first();
            if ($listing) {
                ListingReport::updateOrCreate(
                    ['listing_id' => $listing->id, 'reason' => $report['reason']],
                    [
                        'reported_by' => $report['reported_by'],
                        'status' => $report['status'],
                    ],
                );
            }
        }

        $reportedListing = LivestockListing::where('slug', 'boran-breeding-bull-isiolo')->first();
        if ($reportedListing) {
            ListingReport::updateOrCreate(
                ['listing_id' => $reportedListing->id, 'reason' => 'Seller documents need confirmation'],
                ['reported_by' => 'Test buyer', 'reporter_contact' => 'buyer@example.test', 'status' => 'Open'],
            );
        }

        $inquiryListing = LivestockListing::where('slug', 'kienyeji-breeding-roosters-gilgil')->first();
        if ($inquiryListing) {
            foreach (['phone', 'whatsapp', 'email'] as $channel) {
                ListingInquiry::updateOrCreate(
                    ['listing_id' => $inquiryListing->id, 'channel' => $channel, 'email' => "buyer-{$channel}@example.test"],
                    ['name' => 'Test Buyer', 'phone' => '+254 799 000 000', 'message' => 'Is this listing still available?'],
                );
            }
        }

        foreach (['lactating-camel-garissa', 'rhodes-hay-bales-nyeri', 'artificial-insemination-service-nakuru'] as $slug) {
            $listing = LivestockListing::where('slug', $slug)->first();
            if (! $listing) {
                continue;
            }

            foreach (['phone', 'whatsapp'] as $channel) {
                ListingInquiry::updateOrCreate(
                    ['listing_id' => $listing->id, 'channel' => $channel, 'email' => "buyer-{$slug}-{$channel}@example.test"],
                    ['name' => 'Scenario Buyer', 'phone' => '+254 799 111 222', 'message' => 'Can I inspect this listing this week?', 'created_at' => now()->subDays(rand(1, 20))],
                );
            }
        }

        foreach (['young-camel-bull-garissa' => 'Pending listing has incomplete photos', 'working-donkey-machakos' => 'Rejected seller tried to post without approval', 'suspended-goat-listing-isiolo' => 'Suspicious duplicate listing'] as $slug => $reason) {
            $listing = LivestockListing::where('slug', $slug)->first();
            if ($listing) {
                ListingReport::updateOrCreate(
                    ['listing_id' => $listing->id, 'reason' => $reason],
                    ['reported_by' => 'Scenario buyer', 'reporter_contact' => 'scenario@example.test', 'status' => 'Open'],
                );
            }
        }

        User::whereNotIn('role', ['Admin', 'Super Admin'])->get()->each(function (User $seller) {
            $used = $seller->listings()->whereNotIn('status', ['draft'])->count();
            $seller->update(['listing_allowance_used' => min($used, $seller->listing_allowance_total)]);
        });

        $this->syncStructuredListingData($admin);

        foreach ([
            ['seller approved', User::where('email', 'approved@zizini.test')->first()],
            ['listing approved', LivestockListing::where('status', 'active')->first()],
            ['listing rejected', LivestockListing::where('status', 'rejected')->first()],
            ['report handled', ListingReport::first()],
        ] as [$action, $subject]) {
            if ($subject) {
                AuditLog::updateOrCreate(
                    ['action' => $action, 'subject_type' => $subject::class, 'subject_id' => $subject->id],
                    ['user_id' => $admin->id, 'description' => Str::headline($action).' during seed/demo setup.', 'metadata' => ['seeded' => true]],
                );
            }
        }
    }

    private function syncStructuredListingData(User $admin): void
    {
        $animalCategories = ['Cattle', 'Goats', 'Sheep', 'Poultry', 'Pigs', 'Donkeys', 'Camels'];
        $feedCategories = ['Hay', 'Silage', 'Dairy Meal', 'Poultry Feed', 'Mineral Supplements', 'Pasture Seeds', 'Farm Equipment'];
        $serviceCategories = ['Animal Transport', 'Veterinary Services', 'Breeding Services', 'Farm Consulting', 'Movement Permit Support', 'AI Advisory'];

        $fallbacks = [
            'animal' => '/assets/defaults/default-animal-image.jpg',
            'feed' => '/assets/defaults/default-feed-image.jpg',
            'service' => '/assets/defaults/default-service-image.jpg',
        ];

        LivestockListing::with('seller')->get()->each(function (LivestockListing $listing) use ($animalCategories, $feedCategories, $serviceCategories, $fallbacks, $admin) {
            $type = in_array($listing->category, $feedCategories, true) ? 'feed' : (in_array($listing->category, $serviceCategories, true) ? 'service' : 'animal');
            $groupSlug = ['animal' => 'livestock', 'feed' => 'feeds', 'service' => 'services'][$type];
            $group = CategoryGroup::where('slug', $groupSlug)->first();
            $category = LivestockCategory::where('name', $listing->category)->first()
                ?? LivestockCategory::where('slug', Str::slug($listing->category))->first();
            $county = County::where('name', $listing->county)->first();
            $images = $listing->images ?: [$fallbacks[$type]];

            $listing->update([
                'listing_type' => $type,
                'category_group_id' => $group?->id,
                'category_id' => $category?->id,
                'county_id' => $county?->id,
                'price_type' => $type === 'service' ? 'quote' : 'negotiable',
                'verified_badge' => (bool) $listing->verified,
                'approved_at' => $listing->verified ? ($listing->verified_at ?? now()) : null,
                'approved_by' => $listing->verified ? $admin->id : null,
                'images' => $images,
            ]);

            foreach ($images as $index => $image) {
                ListingImage::updateOrCreate(
                    ['listing_id' => $listing->id, 'path' => $image],
                    ['alt_text' => $listing->title, 'is_primary' => $index === 0, 'display_order' => $index],
                );
            }

            if ($type === 'animal') {
                AnimalDetail::updateOrCreate(
                    ['listing_id' => $listing->id],
                    [
                        'animal_purpose' => $listing->category === 'Cattle' ? 'dairy' : ($listing->category === 'Poultry' ? 'poultry' : 'mixed'),
                        'species' => $listing->category,
                        'breed' => $listing->breed,
                        'sex' => $listing->sex,
                        'age' => $listing->age,
                        'weight' => $listing->weight,
                        'milk_production' => $listing->milk_production,
                        'vaccination_status' => $listing->vaccination_status,
                        'health_status' => $listing->health_status,
                        'quantity' => Str::contains(Str::lower($listing->title), ['batch', 'pullets']) ? 20 : 1,
                    ],
                );
            } elseif ($type === 'feed') {
                FeedDetail::updateOrCreate(
                    ['listing_id' => $listing->id],
                    [
                        'feed_type' => $listing->breed ?: $listing->category,
                        'target_animal' => Str::contains(Str::lower($listing->title), 'poultry') ? 'Poultry' : 'Cattle, goats and sheep',
                        'unit' => Str::contains(Str::lower($listing->title), ['bag', 'meal']) ? 'bag' : 'bale',
                        'quantity_available' => 'Available in bulk',
                        'brand_name' => $listing->seller?->name,
                    ],
                );
            } else {
                ServiceDetail::updateOrCreate(
                    ['listing_id' => $listing->id],
                    [
                        'service_type' => $listing->category,
                        'provider_type' => 'company',
                        'service_area' => $listing->county,
                        'availability' => 'By appointment',
                        'pricing_model' => 'quote',
                        'quote_note' => 'Contact provider for availability and exact quote.',
                    ],
                );
            }
        });
    }

    private function parseDemoDate(?string $value): ?string
    {
        if (! $value || $value === '-') {
            return null;
        }

        return date('Y-m-d', strtotime($value));
    }
}
