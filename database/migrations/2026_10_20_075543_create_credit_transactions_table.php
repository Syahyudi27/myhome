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
        Schema::create('credit_transactions', function (Blueprint $table) {
            $table->id();

            // Relasi ke user pemilik token
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Jumlah kredit (+10 kalau top-up, -1 kalau dipakai)
            $table->integer('amount');

            // Tipe transaksi: 'topup', 'use_listing', 'refund', 'bonus'
            $table->string('type');

            // Catatan/keterangan transaksi
            $table->string('description')->nullable();
            // Tambahan opsional untuk melacak order mana yang menghasilkan topup ini
            $table->foreignId('credit_order_id')->nullable()->constrained('credit_orders')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_transactions');
    }
};