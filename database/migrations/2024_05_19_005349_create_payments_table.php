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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_id')->references('id')->on('apartment')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
            $table->decimal('amount',15,2)->unsigned()->default(0);
            $table->string('category');
            $table->string('transaction_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('status')->default('Pending');
            $table->string('receipt')->nullable();
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
