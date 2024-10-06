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
        Schema::create('apartment', function (Blueprint $table) {
           $table->id();
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('room_number');
            $table->unsignedBigInteger('renter_id')->nullable();
            $table->foreign('renter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->string('status');
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartment');
    }
};
