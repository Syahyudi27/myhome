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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mortgage_request_id')->constrained()->cascadeOnDelete();
            $table->integer('no_of_payment');
            $table->unsignedBigInteger('total_tax_amount')->change();
            $table->unsignedBigInteger('grand_total_amount')->change();
            $table->unsignedBigInteger('sub_total_amount')->change();
            $table->unsignedBigInteger('insurance_amount')->change();
            $table->string('proof')->nullable();
            $table->boolean('is_paid');
            $table->string('payment_type');
            $table->unsignedBigInteger('remaining_loan_amount')->change();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
