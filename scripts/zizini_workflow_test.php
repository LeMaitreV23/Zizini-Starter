<?php

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\LivestockListing;
use App\Models\ListingInquiry;
use App\Models\ListingReport;
use App\Models\SellerAccessRequest;
use App\Models\User;
use App\Models\CategoryGroup;
use App\Models\County;

$failures = [];

$check = function (string $label, bool $condition) use (&$failures): void {
    echo ($condition ? 'PASS ' : 'FAIL ').$label.PHP_EOL;
    if (! $condition) {
        $failures[] = $label;
    }
};

$statuses = LivestockListing::query()
    ->selectRaw('status, count(*) as total')
    ->groupBy('status')
    ->pluck('total', 'status')
    ->toArray();

$requiredStatuses = ['active', 'unverified', 'pending', 'rejected', 'sold', 'expired', 'draft', 'taken_down'];

echo 'Zizini workflow data check'.PHP_EOL;
echo 'Users: '.User::count().PHP_EOL;
echo 'Sellers: '.User::whereNotIn('role', ['Admin', 'Super Admin'])->count().PHP_EOL;
echo 'Listings: '.LivestockListing::count().PHP_EOL;
echo 'Counties: '.County::count().PHP_EOL;
echo 'Category groups: '.CategoryGroup::count().PHP_EOL;
echo 'Reports: '.ListingReport::count().PHP_EOL;
echo 'Inquiries: '.ListingInquiry::count().PHP_EOL;
echo 'Listing statuses: '.json_encode($statuses).PHP_EOL.PHP_EOL;
echo 'Listing types: '.json_encode(LivestockListing::selectRaw('listing_type,count(*) total')->groupBy('listing_type')->pluck('total', 'listing_type')->toArray()).PHP_EOL.PHP_EOL;

$check('admin account exists', User::where('email', 'admin@zizini.co.ke')->where('role', 'Admin')->exists());
$check('approved seller can post', (bool) User::where('email', 'approved@zizini.test')->first()?->hasActivePostingAccess());
$check('pending seller cannot post', ! User::where('email', 'pending@zizini.test')->first()?->hasActivePostingAccess());
$check('expired seller cannot post', ! User::where('email', 'expired@zizini.test')->first()?->hasActivePostingAccess());
$check('suspended seller cannot post', ! User::where('email', 'suspended@zizini.test')->first()?->hasActivePostingAccess());
$check('rejected seller cannot post', ! User::where('email', 'donkeys@zizini.test')->first()?->hasActivePostingAccess());
$check('all required listing statuses are represented', collect($requiredStatuses)->every(fn ($status) => array_key_exists($status, $statuses)));
$check('public marketplace has live listings', LivestockListing::whereIn('status', ['active', 'unverified'])->count() >= 8);
$check('unverified listings exist for admin verification', LivestockListing::where('status', 'unverified')->count() >= 2);
$check('expired listings exist for renewal testing', LivestockListing::where('status', 'expired')->count() >= 2);
$check('open reports exist', ListingReport::where('status', 'Open')->count() >= 3);
$check('seller inquiries exist', ListingInquiry::count() >= 6);
$check('access requests cover pending approved rejected', collect(['Pending', 'Approved', 'Rejected'])->every(fn ($status) => SellerAccessRequest::where('status', $status)->exists()));
$check('three category groups exist', CategoryGroup::whereIn('slug', ['livestock', 'feeds', 'services'])->count() === 3);
$check('twelve counties exist', County::count() >= 12);
$check('animal feed and service listings exist', collect(['animal', 'feed', 'service'])->every(fn ($type) => LivestockListing::where('listing_type', $type)->exists()));

exit(count($failures) > 0 ? 1 : 0);
