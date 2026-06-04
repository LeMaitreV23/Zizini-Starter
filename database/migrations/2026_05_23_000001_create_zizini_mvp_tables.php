<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zizini_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('county')->nullable();
            $table->string('business_name')->nullable();
            $table->string('seller_type')->nullable();
            $table->string('role')->default('Viewer/Buyer');
            $table->string('approval_status')->default('Not approved');
            $table->boolean('verified')->default(false);
            $table->string('posting_status')->default('Not approved');
            $table->unsignedInteger('listing_allowance_total')->default(0);
            $table->unsignedInteger('listing_allowance_used')->default(0);
            $table->date('access_start_date')->nullable();
            $table->date('access_end_date')->nullable();
            $table->unsignedInteger('default_listing_duration')->default(30);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('livestock_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('active')->default(true);
            $table->json('breeds')->nullable();
            $table->timestamps();
        });

        Schema::create('livestock_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('zizini_users');
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category');
            $table->string('breed')->nullable();
            $table->unsignedInteger('price')->nullable();
            $table->boolean('price_negotiable')->default(false);
            $table->string('county');
            $table->string('location')->nullable();
            $table->string('age')->nullable();
            $table->string('sex')->nullable();
            $table->string('health_status')->nullable();
            $table->string('vaccination_status')->nullable();
            $table->string('milk_production')->nullable();
            $table->string('weight')->nullable();
            $table->text('description')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('owner_whatsapp')->nullable();
            $table->string('preferred_contact')->default('Both');
            $table->boolean('featured')->default(false);
            $table->boolean('verified')->default(false);
            $table->string('status')->default('draft');
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('contact_clicks')->default(0);
            $table->unsignedInteger('email_clicks')->default(0);
            $table->unsignedInteger('whatsapp_clicks')->default(0);
            $table->unsignedInteger('call_clicks')->default(0);
            $table->date('expires_at')->nullable();
            $table->json('images')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('taken_down_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['status', 'county', 'category']);
        });

        Schema::create('seller_access_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('zizini_users');
            $table->string('requested_role')->default('Seller');
            $table->unsignedInteger('requested_listing_count')->default(1);
            $table->string('requested_duration')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('zizini_users');
            $table->timestamps();
        });

        Schema::create('listing_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('livestock_listings');
            $table->string('reason');
            $table->string('reported_by')->nullable();
            $table->string('reporter_contact')->nullable();
            $table->string('status')->default('Open');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('listing_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('livestock_listings');
            $table->string('channel')->default('email');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });

        Schema::create('admin_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('zizini_users');
            $table->string('action');
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();
            $table->index(['subject_type', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_activities');
        Schema::dropIfExists('listing_inquiries');
        Schema::dropIfExists('listing_reports');
        Schema::dropIfExists('seller_access_requests');
        Schema::dropIfExists('livestock_listings');
        Schema::dropIfExists('livestock_categories');
        Schema::dropIfExists('zizini_users');
    }
};
