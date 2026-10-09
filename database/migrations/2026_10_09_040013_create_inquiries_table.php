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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('buyer'); // buyer, petani, general
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('whatsapp');
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('status')->default('new'); // new, contacted, deal, closed
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
