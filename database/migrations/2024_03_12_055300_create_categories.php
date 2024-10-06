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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('price');
            $table->text('description');
            $table->softDeletes(); 
            $table->timestamps();
        });
        Schema::create('category_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->onDelete('cascade');
            $table->string('image');    
            $table->text('description')->nullable();  
            $table->softDeletes();      
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
