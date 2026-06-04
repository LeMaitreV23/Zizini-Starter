<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('category_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();
        });

        Schema::table('livestock_categories', function (Blueprint $table) {
            if (! Schema::hasColumn('livestock_categories', 'category_group_id')) {
                $table->foreignId('category_group_id')->nullable()->after('id')->constrained('category_groups');
            }
            if (! Schema::hasColumn('livestock_categories', 'description')) {
                $table->text('description')->nullable()->after('slug');
            }
            if (! Schema::hasColumn('livestock_categories', 'display_order')) {
                $table->unsignedInteger('display_order')->default(0)->after('active');
            }
            if (! Schema::hasColumn('livestock_categories', 'featured')) {
                $table->boolean('featured')->default(false)->after('display_order');
            }
        });

        Schema::table('livestock_listings', function (Blueprint $table) {
            if (! Schema::hasColumn('livestock_listings', 'category_group_id')) {
                $table->foreignId('category_group_id')->nullable()->after('seller_id')->constrained('category_groups');
            }
            if (! Schema::hasColumn('livestock_listings', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('category_group_id')->constrained('livestock_categories');
            }
            if (! Schema::hasColumn('livestock_listings', 'county_id')) {
                $table->foreignId('county_id')->nullable()->after('category_id')->constrained('counties');
            }
            if (! Schema::hasColumn('livestock_listings', 'listing_type')) {
                $table->string('listing_type')->default('animal')->after('county_id');
            }
            if (! Schema::hasColumn('livestock_listings', 'price_type')) {
                $table->string('price_type')->default('negotiable')->after('price_negotiable');
            }
            if (! Schema::hasColumn('livestock_listings', 'verified_badge')) {
                $table->boolean('verified_badge')->default(false)->after('verified');
            }
            if (! Schema::hasColumn('livestock_listings', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('expires_at');
            }
            if (! Schema::hasColumn('livestock_listings', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->after('approved_at')->constrained('zizini_users');
            }
            if (! Schema::hasColumn('livestock_listings', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('approved_by');
            }
        });

        Schema::create('animal_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('livestock_listings')->cascadeOnDelete();
            $table->string('animal_purpose')->nullable();
            $table->string('species')->nullable();
            $table->string('breed')->nullable();
            $table->string('sex')->nullable();
            $table->string('age')->nullable();
            $table->string('weight')->nullable();
            $table->string('milk_production')->nullable();
            $table->string('vaccination_status')->nullable();
            $table->string('health_status')->nullable();
            $table->string('pregnancy_status')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamps();
        });

        Schema::create('feed_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('livestock_listings')->cascadeOnDelete();
            $table->string('feed_type')->nullable();
            $table->string('target_animal')->nullable();
            $table->string('unit')->nullable();
            $table->string('quantity_available')->nullable();
            $table->string('brand_name')->nullable();
            $table->timestamps();
        });

        Schema::create('service_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('livestock_listings')->cascadeOnDelete();
            $table->string('service_type')->nullable();
            $table->string('provider_type')->nullable();
            $table->string('service_area')->nullable();
            $table->string('availability')->nullable();
            $table->string('pricing_model')->nullable();
            $table->text('quote_note')->nullable();
            $table->timestamps();
        });

        Schema::create('listing_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('livestock_listings')->cascadeOnDelete();
            $table->string('path');
            $table->string('alt_text')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('zizini_users');
            $table->string('action');
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('listing_images');
        Schema::dropIfExists('service_details');
        Schema::dropIfExists('feed_details');
        Schema::dropIfExists('animal_details');
        Schema::dropIfExists('category_groups');
        Schema::dropIfExists('counties');
    }
};
