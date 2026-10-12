<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            if (!Schema::hasColumn('sliders', 'type')) {
                $table->string('type')->default('image')->after('title');
            }
            if (!Schema::hasColumn('sliders', 'youtube_url')) {
                $table->string('youtube_url')->nullable()->after('type');
            }
        });

        try {
            DB::statement("ALTER TABLE sliders MODIFY COLUMN image VARCHAR(255) NULL");
        } catch (\Throwable $e) {
            // Ignore if already nullable or different driver
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            if (Schema::hasColumn('sliders', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('sliders', 'youtube_url')) {
                $table->dropColumn('youtube_url');
            }
        });
    }
};
