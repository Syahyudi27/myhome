<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Buat tabel master listing_types
        Schema::create('listing_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Jual, Sewa
            $table->string('slug')->unique(); // jual, sewa
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropForeign(['listing_type_id']);
            $table->dropColumn('listing_type_id');
        });

        Schema::dropIfExists('listing_types');
    }
};