<?php

$cowHero = '/assets/livestock/cow-ayrshire.jpg';
$cowBull = '/assets/livestock/bull-real.jpg';
$goat = '/assets/livestock/goat-real.jpg';
$sheep = '/assets/livestock/sheep-real.jpg';
$chicken = '/assets/livestock/chicken.jpg';
$pig = '/assets/livestock/cows-field.jpg';
$camel = '/assets/categories/camels.jpg';
$donkey = '/assets/categories/donkeys.jpg';
$feeds = '/assets/categories/animal-feeds.jpg';
$services = '/assets/categories/farm-services.jpg';
$brand = '/assets/brand/coming-soon-web.png';

return [
    'brand' => [
        'name' => 'Zizini.co.ke',
        'descriptor' => 'Zizini Livestock Market',
        'tagline' => 'Uza Nunua Mifugo hapa',
        'logo' => '/assets/brand/logo-primary-transparent-cropped.png',
        'symbol' => '/assets/brand/logo-symbol.png',
        'colors' => [
            'pasture' => '#2F6B3D',
            'fresh' => '#7FBF3F',
            'cream' => '#F6F1E7',
            'earth' => '#7A5C3E',
            'charcoal' => '#1F1F1F',
            'blue' => '#2D6CDF',
        ],
    ],
    'categories' => [
        ['name' => 'Cattle', 'slug' => 'cattle', 'count' => 42, 'icon' => 'cow', 'image' => $cowHero],
        ['name' => 'Goats', 'slug' => 'goats', 'count' => 28, 'icon' => 'goat', 'image' => $goat],
        ['name' => 'Sheep', 'slug' => 'sheep', 'count' => 19, 'icon' => 'sheep', 'image' => $sheep],
        ['name' => 'Poultry', 'slug' => 'poultry', 'count' => 33, 'icon' => 'egg', 'image' => $chicken],
        ['name' => 'Pigs', 'slug' => 'pigs', 'count' => 8, 'icon' => 'pig', 'image' => $pig],
        ['name' => 'Donkeys', 'slug' => 'donkeys', 'count' => 5, 'icon' => 'donkey', 'image' => $donkey],
        ['name' => 'Camels', 'slug' => 'camels', 'count' => 7, 'icon' => 'camel', 'image' => $camel],
        ['name' => 'Hay', 'slug' => 'hay', 'count' => 16, 'icon' => 'leaf', 'image' => $feeds],
        ['name' => 'Livestock Services', 'slug' => 'services', 'count' => 11, 'icon' => 'tool', 'image' => $services],
    ],
    'counties' => [
        ['name' => 'Nakuru', 'slug' => 'nakuru', 'count' => 24],
        ['name' => 'Kiambu', 'slug' => 'kiambu', 'count' => 18],
        ['name' => 'Nyeri', 'slug' => 'nyeri', 'count' => 13],
        ['name' => 'Uasin Gishu', 'slug' => 'uasin-gishu', 'count' => 12],
        ['name' => 'Kajiado', 'slug' => 'kajiado', 'count' => 15],
        ['name' => 'Narok', 'slug' => 'narok', 'count' => 9],
        ['name' => 'Garissa', 'slug' => 'garissa', 'count' => 6],
        ['name' => 'Meru', 'slug' => 'meru', 'count' => 17],
        ['name' => 'Machakos', 'slug' => 'machakos', 'count' => 14],
        ['name' => 'Nairobi', 'slug' => 'nairobi', 'count' => 10],
        ['name' => "Murang'a", 'slug' => 'muranga', 'count' => 8],
        ['name' => 'Laikipia', 'slug' => 'laikipia', 'count' => 7],
    ],
    'sellers' => [
        [
            'id' => 1,
            'name' => 'Wanjiku Dairy Farm',
            'phone' => '+254 712 345 678',
            'whatsapp' => '+254 712 345 678',
            'email' => 'hello@wanjikufarm.test',
            'logo_path' => '/assets/brand/logo-symbol.png',
            'county' => 'Nakuru',
            'seller_type' => 'Farm/dealer',
            'role' => 'Verified Seller',
            'approval_status' => 'Approved',
            'verified' => true,
            'posting_status' => 'Approved',
            'listing_allowance_total' => 10,
            'listing_allowance_used' => 4,
            'listing_allowance_remaining' => 6,
            'access_start_date' => '01 May 2026',
            'access_end_date' => '30 June 2026',
            'default_listing_duration' => 30,
            'joined_date' => '12 April 2026',
        ],
        [
            'id' => 2,
            'name' => 'Kajiado Livestock Yard',
            'phone' => '+254 723 456 789',
            'whatsapp' => '+254 723 456 789',
            'email' => 'yard@example.test',
            'logo_path' => null,
            'county' => 'Kajiado',
            'seller_type' => 'Broker',
            'role' => 'Seller',
            'approval_status' => 'Awaiting Approval',
            'verified' => false,
            'posting_status' => 'Not approved',
            'listing_allowance_total' => 0,
            'listing_allowance_used' => 0,
            'listing_allowance_remaining' => 0,
            'access_start_date' => '-',
            'access_end_date' => '-',
            'default_listing_duration' => 30,
            'joined_date' => '19 May 2026',
        ],
        [
            'id' => 3,
            'name' => 'Meru Goat Cooperative',
            'phone' => '+254 734 567 890',
            'whatsapp' => '+254 734 567 890',
            'email' => 'goats@example.test',
            'logo_path' => '/assets/brand/logo-symbol.png',
            'county' => 'Meru',
            'seller_type' => 'Cooperative',
            'role' => 'Farm/Dealer',
            'approval_status' => 'Approved',
            'verified' => true,
            'posting_status' => 'Approved',
            'listing_allowance_total' => 25,
            'listing_allowance_used' => 9,
            'listing_allowance_remaining' => 16,
            'access_start_date' => '10 May 2026',
            'access_end_date' => '10 August 2026',
            'default_listing_duration' => 30,
            'joined_date' => '03 May 2026',
        ],
    ],
    'listings' => [
        ['id' => 1, 'slug' => 'ayrshire-cow-nakuru', 'title' => 'Ayrshire Cow', 'category' => 'Cattle', 'breed' => 'Ayrshire', 'price' => 95000, 'county' => 'Nakuru', 'location' => 'Molo', 'age' => '4.5 years', 'sex' => 'Female', 'health_status' => 'Healthy', 'vaccination_status' => 'Vaccinated', 'milk_production' => '16 litres/day', 'weight' => '430 kg', 'seller_id' => 1, 'seller_name' => 'Wanjiku Dairy Farm', 'seller_phone' => '+254 712 345 678', 'seller_whatsapp' => '+254 712 345 678', 'seller_verified' => true, 'seller_badge' => 'Verified Seller', 'featured' => true, 'status' => 'active', 'views' => 312, 'contact_clicks' => 47, 'whatsapp_clicks' => 22, 'call_clicks' => 18, 'expiry_date' => '30 June 2026', 'images' => [$cowHero, $cowBull, $brand], 'description' => 'Calm dairy cow, good udder condition, currently in milk and available for farm inspection.'],
        ['id' => 2, 'slug' => 'friesian-cow-nyeri', 'title' => 'Friesian Cow', 'category' => 'Cattle', 'breed' => 'Friesian', 'price' => 87500, 'county' => 'Nyeri', 'location' => 'Othaya', 'age' => '3 years', 'sex' => 'Female', 'health_status' => 'Healthy', 'vaccination_status' => 'Vaccinated', 'milk_production' => '14 litres/day', 'weight' => '390 kg', 'seller_id' => 1, 'seller_name' => 'Wanjiku Dairy Farm', 'seller_phone' => '+254 712 345 678', 'seller_whatsapp' => '+254 712 345 678', 'seller_verified' => true, 'seller_badge' => 'Verified Seller', 'featured' => false, 'status' => 'active', 'views' => 201, 'contact_clicks' => 31, 'whatsapp_clicks' => 15, 'call_clicks' => 12, 'expiry_date' => '28 June 2026', 'images' => [$cowHero, $cowBull], 'description' => 'Strong dairy Friesian, suitable for small and medium farms.'],
        ['id' => 3, 'slug' => 'boran-bull-garissa', 'title' => 'Boran Bull', 'category' => 'Cattle', 'breed' => 'Boran', 'price' => 120000, 'county' => 'Garissa', 'location' => 'Town outskirts', 'age' => '5 years', 'sex' => 'Male', 'health_status' => 'Healthy', 'vaccination_status' => 'Up to date', 'milk_production' => null, 'weight' => '610 kg', 'seller_id' => 2, 'seller_name' => 'Kajiado Livestock Yard', 'seller_phone' => '+254 723 456 789', 'seller_whatsapp' => '+254 723 456 789', 'seller_verified' => false, 'seller_badge' => 'Seller', 'featured' => false, 'status' => 'active', 'views' => 177, 'contact_clicks' => 24, 'whatsapp_clicks' => 9, 'call_clicks' => 10, 'expiry_date' => '21 June 2026', 'images' => [$cowBull, $cowHero], 'description' => 'Hardy Boran bull for breeding or beef production, inspection by appointment.'],
        ['id' => 4, 'slug' => 'sahiwal-cow-kajiado', 'title' => 'Sahiwal Cow', 'category' => 'Cattle', 'breed' => 'Sahiwal', 'price' => 78000, 'county' => 'Kajiado', 'location' => 'Kitengela', 'age' => '4 years', 'sex' => 'Female', 'health_status' => 'Healthy', 'vaccination_status' => 'Vaccinated', 'milk_production' => '9 litres/day', 'weight' => '410 kg', 'seller_id' => 2, 'seller_name' => 'Kajiado Livestock Yard', 'seller_phone' => '+254 723 456 789', 'seller_whatsapp' => '+254 723 456 789', 'seller_verified' => false, 'seller_badge' => 'Seller', 'featured' => false, 'status' => 'pending', 'views' => 96, 'contact_clicks' => 0, 'whatsapp_clicks' => 0, 'call_clicks' => 0, 'expiry_date' => 'Pending approval', 'images' => [$cowHero, $cowBull], 'description' => 'Heat tolerant Sahiwal cow, pending admin moderation.'],
        ['id' => 5, 'slug' => 'galla-goat-machakos', 'title' => 'Galla Goat', 'category' => 'Goats', 'breed' => 'Galla', 'price' => 18000, 'county' => 'Machakos', 'location' => 'Kangundo', 'age' => '18 months', 'sex' => 'Male', 'health_status' => 'Healthy', 'vaccination_status' => 'Vaccinated', 'milk_production' => null, 'weight' => '42 kg', 'seller_id' => 3, 'seller_name' => 'Meru Goat Cooperative', 'seller_phone' => '+254 734 567 890', 'seller_whatsapp' => '+254 734 567 890', 'seller_verified' => true, 'seller_badge' => 'Farm/Dealer', 'featured' => true, 'status' => 'active', 'views' => 143, 'contact_clicks' => 19, 'whatsapp_clicks' => 11, 'call_clicks' => 6, 'expiry_date' => '03 July 2026', 'images' => [$goat, $cowHero], 'description' => 'Large-framed Galla buck, suitable for breeding.'],
        ['id' => 6, 'slug' => 'dorper-sheep-narok', 'title' => 'Dorper Sheep', 'category' => 'Sheep', 'breed' => 'Dorper', 'price' => 14500, 'county' => 'Narok', 'location' => 'Narok North', 'age' => '14 months', 'sex' => 'Female', 'health_status' => 'Healthy', 'vaccination_status' => 'Vaccinated', 'milk_production' => null, 'weight' => '36 kg', 'seller_id' => 3, 'seller_name' => 'Meru Goat Cooperative', 'seller_phone' => '+254 734 567 890', 'seller_whatsapp' => '+254 734 567 890', 'seller_verified' => true, 'seller_badge' => 'Farm/Dealer', 'featured' => false, 'status' => 'active', 'views' => 88, 'contact_clicks' => 12, 'whatsapp_clicks' => 5, 'call_clicks' => 4, 'expiry_date' => '07 July 2026', 'images' => [$sheep, $goat], 'description' => 'Clean Dorper ewe, owner available for calls and farm visit scheduling.'],
        ['id' => 7, 'slug' => 'kienyeji-chicken-batch-kiambu', 'title' => 'Kienyeji Chicken Batch', 'category' => 'Poultry', 'breed' => 'Kienyeji', 'price' => 12000, 'county' => 'Kiambu', 'location' => 'Limuru', 'age' => '5 months', 'sex' => 'Mixed', 'health_status' => 'Healthy', 'vaccination_status' => 'Vaccinated', 'milk_production' => null, 'weight' => null, 'seller_id' => 1, 'seller_name' => 'Wanjiku Dairy Farm', 'seller_phone' => '+254 712 345 678', 'seller_whatsapp' => '+254 712 345 678', 'seller_verified' => true, 'seller_badge' => 'Verified Seller', 'featured' => false, 'status' => 'sold', 'views' => 166, 'contact_clicks' => 29, 'whatsapp_clicks' => 17, 'call_clicks' => 9, 'expiry_date' => 'Sold', 'images' => [$chicken, $brand], 'description' => 'Batch of improved Kienyeji chickens. Marked sold by owner.'],
        ['id' => 8, 'slug' => 'dairy-goat-meru', 'title' => 'Dairy Goat', 'category' => 'Goats', 'breed' => 'Toggenburg cross', 'price' => 25000, 'county' => 'Meru', 'location' => 'Nkubu', 'age' => '2 years', 'sex' => 'Female', 'health_status' => 'Healthy', 'vaccination_status' => 'Vaccinated', 'milk_production' => '2 litres/day', 'weight' => '48 kg', 'seller_id' => 3, 'seller_name' => 'Meru Goat Cooperative', 'seller_phone' => '+254 734 567 890', 'seller_whatsapp' => '+254 734 567 890', 'seller_verified' => true, 'seller_badge' => 'Farm/Dealer', 'featured' => false, 'status' => 'expired', 'views' => 72, 'contact_clicks' => 6, 'whatsapp_clicks' => 2, 'call_clicks' => 3, 'expiry_date' => 'Expired', 'images' => [$goat, $cowHero], 'description' => 'Dairy goat listing awaiting renewal request.'],
    ],
    'access_requests' => [
        ['id' => 1, 'seller_id' => 2, 'seller_name' => 'Kajiado Livestock Yard', 'requested_role' => 'Seller', 'requested_listing_count' => 8, 'requested_duration' => '60 days', 'status' => 'Pending', 'created_at' => '19 May 2026'],
        ['id' => 2, 'seller_id' => 3, 'seller_name' => 'Meru Goat Cooperative', 'requested_role' => 'Farm/Dealer', 'requested_listing_count' => 25, 'requested_duration' => '90 days', 'status' => 'Approved', 'created_at' => '10 May 2026'],
    ],
    'reports' => [
        ['id' => 1, 'listing_id' => 3, 'reason' => 'Buyer asked to confirm ownership documents', 'reported_by' => 'Public buyer', 'status' => 'Open', 'created_at' => '22 May 2026'],
    ],
];
