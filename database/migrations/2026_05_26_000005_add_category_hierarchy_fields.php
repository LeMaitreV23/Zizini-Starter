<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('livestock_categories', function (Blueprint $table) {
            if (! Schema::hasColumn('livestock_categories', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->after('category_group_id')->constrained('livestock_categories');
            }
            if (! Schema::hasColumn('livestock_categories', 'public_label')) {
                $table->string('public_label')->nullable()->after('name');
            }
            if (! Schema::hasColumn('livestock_categories', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('livestock_categories', function (Blueprint $table) {
            if (Schema::hasColumn('livestock_categories', 'parent_id')) {
                $table->dropConstrainedForeignId('parent_id');
            }
            if (Schema::hasColumn('livestock_categories', 'public_label')) {
                $table->dropColumn('public_label');
            }
            if (Schema::hasColumn('livestock_categories', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
