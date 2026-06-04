<?php

use App\Http\Controllers\ZiziniController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ZiziniController::class, 'home'])->name('home');
Route::get('/marketplace', [ZiziniController::class, 'marketplace'])->name('marketplace');
Route::get('/listings/{slug}', [ZiziniController::class, 'listingDetail'])->name('listings.show');
Route::get('/livestock/{slug}', [ZiziniController::class, 'listingDetail'])->name('livestock.show');
Route::get('/categories', [ZiziniController::class, 'categories'])->name('categories');
Route::get('/categories/{category}', [ZiziniController::class, 'categoryDetail'])->name('categories.show');
Route::get('/counties', [ZiziniController::class, 'counties'])->name('counties');
Route::get('/counties/{county}', [ZiziniController::class, 'countyDetail'])->name('counties.show');
Route::get('/how-it-works', [ZiziniController::class, 'simplePage'])->defaults('page', 'how-it-works')->name('how');
Route::get('/about', [ZiziniController::class, 'simplePage'])->defaults('page', 'about')->name('about');
Route::get('/faq', [ZiziniController::class, 'simplePage'])->defaults('page', 'faq')->name('faq');
Route::get('/contact', [ZiziniController::class, 'simplePage'])->defaults('page', 'contact')->name('contact');
Route::get('/safety', [ZiziniController::class, 'simplePage'])->defaults('page', 'safety')->name('safety');
Route::get('/guide', [ZiziniController::class, 'guide'])->name('guide');
Route::get('/buyer/saved', [ZiziniController::class, 'buyerSaved'])->name('buyer.saved');
Route::get('/inquiry/sent', [ZiziniController::class, 'inquirySent'])->name('inquiry.sent');

Route::post('/livestock/{listing}/inquiries', [ZiziniController::class, 'storeInquiry'])->middleware('throttle:8,1')->name('livestock.inquiries.store');
Route::post('/livestock/{listing}/reports', [ZiziniController::class, 'reportListing'])->middleware('throttle:5,1')->name('livestock.reports.store');
Route::get('/livestock/{listing}/contact/{channel}', [ZiziniController::class, 'redirectContact'])->middleware('throttle:30,1')->name('livestock.contact.redirect');

Route::get('/seller/register', [ZiziniController::class, 'sellerRegister'])->name('seller.register');
Route::post('/seller/register', [ZiziniController::class, 'registerSeller'])->middleware('throttle:5,1')->name('seller.register.store');
Route::get('/login', [ZiziniController::class, 'login'])->name('login');
Route::post('/login', [ZiziniController::class, 'authenticate'])->middleware('throttle:10,1')->name('login.store');
Route::post('/logout', [ZiziniController::class, 'logout'])->name('logout');

Route::middleware(['auth.zizini', 'seller'])->group(function () {
    Route::get('/seller/pending', [ZiziniController::class, 'sellerSimple'])->defaults('page', 'pending')->name('seller.pending');
    Route::get('/seller/dashboard', [ZiziniController::class, 'sellerDashboard'])->name('seller.dashboard');
    Route::get('/seller/listings', [ZiziniController::class, 'sellerListings'])->name('seller.listings');
    Route::get('/seller/listings/create/type', [ZiziniController::class, 'sellerCreate'])->defaults('step', 'type')->name('seller.create.type');
    Route::get('/seller/listings/create/category', [ZiziniController::class, 'sellerCreate'])->defaults('step', 'category')->name('seller.create.category');
    Route::get('/seller/listings/create/details', [ZiziniController::class, 'sellerCreate'])->defaults('step', 'details')->name('seller.create.details');
    Route::get('/seller/listings/create/photos', [ZiziniController::class, 'sellerCreate'])->defaults('step', 'photos')->name('seller.create.photos');
    Route::get('/seller/listings/create/preview', [ZiziniController::class, 'sellerCreate'])->defaults('step', 'preview')->name('seller.create.preview');
    Route::post('/seller/listings', [ZiziniController::class, 'storeSellerListing'])->name('seller.listings.store');
    Route::post('/seller/listings/{listing}/status/{status}', [ZiziniController::class, 'updateSellerListingStatus'])->name('seller.listings.status');
    Route::get('/seller/listings/submitted', [ZiziniController::class, 'sellerSimple'])->defaults('page', 'submitted')->name('seller.submitted');
    Route::get('/seller/profile', [ZiziniController::class, 'sellerSimple'])->defaults('page', 'profile')->name('seller.profile');
    Route::post('/seller/profile/logo', [ZiziniController::class, 'updateSellerLogo'])->name('seller.profile.logo');
    Route::get('/seller/inquiries', [ZiziniController::class, 'sellerSimple'])->defaults('page', 'inquiries')->name('seller.inquiries');
});

Route::get('/admin/login', [ZiziniController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin/login', [ZiziniController::class, 'authenticate'])->middleware('throttle:10,1')->name('admin.login.store');

Route::middleware(['auth.zizini', 'role:Admin,Super Admin'])->group(function () {
    Route::get('/admin/dashboard', [ZiziniController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/listings', [ZiziniController::class, 'adminListings'])->name('admin.listings');
    Route::get('/admin/listings/create', [ZiziniController::class, 'adminCreateListing'])->name('admin.listings.create');
    Route::post('/admin/listings', [ZiziniController::class, 'storeAdminListing'])->name('admin.listings.store');
    Route::post('/admin/listings/bulk-moderate', [ZiziniController::class, 'bulkModerateListings'])->name('admin.listings.bulk-moderate');
    Route::get('/admin/listings/{id}', [ZiziniController::class, 'adminListingReview'])->name('admin.listings.show');
    Route::get('/admin/listings/{listing}/edit', [ZiziniController::class, 'adminEditListing'])->name('admin.listings.edit');
    Route::post('/admin/listings/{listing}', [ZiziniController::class, 'updateAdminListing'])->name('admin.listings.update');
    Route::post('/admin/listings/{listing}/delete', [ZiziniController::class, 'destroyAdminListing'])->name('admin.listings.destroy');
    Route::post('/admin/listings/{listing}/moderate', [ZiziniController::class, 'moderateListing'])->name('admin.listings.moderate');
    Route::get('/admin/users', [ZiziniController::class, 'adminUsers'])->name('admin.users');
    Route::get('/admin/users/{id}', [ZiziniController::class, 'adminUserDetail'])->name('admin.users.show');
    Route::post('/admin/users/{seller}/profile', [ZiziniController::class, 'updateSellerProfile'])->name('admin.users.profile.update');
    Route::post('/admin/users/{seller}/access', [ZiziniController::class, 'updateSellerAccess'])->name('admin.users.access.update');
    Route::get('/admin/access-requests', [ZiziniController::class, 'adminAccessRequests'])->name('admin.access');
    Route::post('/admin/access-requests/{accessRequest}/{decision}', [ZiziniController::class, 'reviewAccessRequest'])->name('admin.access.review');
    Route::get('/admin/categories', [ZiziniController::class, 'adminSimple'])->defaults('page', 'categories')->name('admin.categories');
    Route::post('/admin/categories', [ZiziniController::class, 'storeCategory'])->name('admin.categories.store');
    Route::post('/admin/categories/{category}', [ZiziniController::class, 'updateCategory'])->name('admin.categories.update');
    Route::get('/admin/category-groups', [ZiziniController::class, 'adminSimple'])->defaults('page', 'category-groups')->name('admin.category-groups');
    Route::post('/admin/category-groups', [ZiziniController::class, 'storeCategoryGroup'])->name('admin.category-groups.store');
    Route::post('/admin/category-groups/{categoryGroup}', [ZiziniController::class, 'updateCategoryGroup'])->name('admin.category-groups.update');
    Route::get('/admin/subcategories', [ZiziniController::class, 'adminSimple'])->defaults('page', 'subcategories')->name('admin.subcategories');
    Route::post('/admin/subcategories', [ZiziniController::class, 'storeSubcategory'])->name('admin.subcategories.store');
    Route::post('/admin/subcategories/{category}', [ZiziniController::class, 'updateSubcategory'])->name('admin.subcategories.update');
    Route::get('/admin/reports', [ZiziniController::class, 'adminSimple'])->defaults('page', 'reports')->name('admin.reports');
    Route::post('/admin/reports/{report}/action/{action}', [ZiziniController::class, 'handleReport'])->name('admin.reports.action');
    Route::get('/admin/inquiries', [ZiziniController::class, 'adminSimple'])->defaults('page', 'inquiries')->name('admin.inquiries');
    Route::get('/admin/featured', [ZiziniController::class, 'adminSimple'])->defaults('page', 'featured')->name('admin.featured');
    Route::get('/admin/settings', [ZiziniController::class, 'adminSimple'])->defaults('page', 'settings')->name('admin.settings');
    Route::post('/admin/settings', [ZiziniController::class, 'fakeAction'])->name('admin.settings.save');
    Route::get('/admin/analytics', [ZiziniController::class, 'adminSimple'])->defaults('page', 'analytics')->name('admin.analytics');
    Route::get('/admin/audit-logs', [ZiziniController::class, 'adminSimple'])->defaults('page', 'audit-logs')->name('admin.audit-logs');
});

Route::post('/prototype/status', [ZiziniController::class, 'fakeAction'])->middleware('throttle:10,1')->name('prototype.status');

foreach (['pricing', 'seller/listings/create/payment', 'admin/payments', 'cart', 'checkout', 'payment', 'mpesa', 'transactions'] as $futurePath) {
    Route::match(['get', 'post'], '/'.$futurePath, [ZiziniController::class, 'futureModule'])->name('future.'.str_replace(['/', '-'], '.', $futurePath));
}
