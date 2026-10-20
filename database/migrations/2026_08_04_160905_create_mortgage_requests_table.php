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
        Schema::create('mortgage_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('house_id')->constrained()->cascadeOnDelete();
            $table->foreignId('interest_id')->constrained()->cascadeOnDelete();
            
            $table->integer('duration');
            $table->string('bank_name');
            
            // Hapus ->change(), langsung definisikan tipe datanya
            $table->decimal('interest', 5, 2); 
            $table->unsignedBigInteger('dp_total_amount');
            $table->integer('dp_percentage');
            $table->unsignedBigInteger('loan_total_amount');
            $table->unsignedBigInteger('loan_interest_total_amount');
            $table->unsignedBigInteger('house_price');
            $table->unsignedBigInteger('monthly_amount');
            
            $table->string('status');
            $table->text('rejection_reason')->nullable(); // Ditambahkan untuk alasan penolakan
            $table->string('documents');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mortgage_requests');
    }
};