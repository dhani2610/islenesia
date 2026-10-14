<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->string('whatsapp')->nullable()->change();
            if (!Schema::hasColumn('inquiries', 'channel')) {
                $table->string('channel')->default('whatsapp')->after('email'); // whatsapp, email, both
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            if (Schema::hasColumn('inquiries', 'channel')) {
                $table->dropColumn('channel');
            }
        });
    }
};
