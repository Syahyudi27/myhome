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
        Schema::create('credit_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // Contoh: TRX-20261021-001
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->integer('amount'); // Jumlah token, misal: 50
            $table->decimal('price', 12, 2); // Harga dalam Rp, misal: 90000.00
            
            // Menggunakan string biasa pengganti enum
            // Nilai yang valid: 'pending', 'success', 'expired', 'failed'
            $table->string('payment_status')->default('pending');
            $table->string('payment_type')->default('qris'); 
            $table->text('qris_url')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_orders');
    }
};
