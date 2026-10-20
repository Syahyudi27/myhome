<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();

            // Relasi ke Pemilik / Agen
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('thumbnail');
            $table->text('about');

            // Menggunakan unsignedBigInteger untuk nominal harga besar
            $table->unsignedBigInteger('price');

            // Spesifikasi Ruangan & Bangunan
            $table->integer('bedroom');
            $table->integer('bathroom');
            $table->integer('garage')->default(0);
            $table->integer('floors')->default(1);
            $table->string('certificate');
            $table->integer('electric');
            $table->integer('land_area');
            $table->integer('building_area');

            // Lokasi & Detail Alamat
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Status & Tipe (Menggunakan string biasa, bukan enum)
            $table->string('furnishing');
            $table->string('listing_type');
            $table->string('status');

            // Relasi Kategori & Kota
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};