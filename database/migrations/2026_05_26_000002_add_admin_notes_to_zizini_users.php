<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('zizini_users', function (Blueprint $table) {
            $table->text('admin_notes')->nullable()->after('default_listing_duration');
        });
    }

    public function down(): void
    {
        Schema::table('zizini_users', function (Blueprint $table) {
            $table->dropColumn('admin_notes');
        });
    }
};
