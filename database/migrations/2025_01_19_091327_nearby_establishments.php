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
        Schema::create('nearby_establishments', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('name'); // Establishment name
            $table->text('description'); // Establishment description
            $table->decimal('distance', 5, 2); // Distance in kilometers
            $table->string('image_url'); // Image URL
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('nearby_establishments');
    }
};
