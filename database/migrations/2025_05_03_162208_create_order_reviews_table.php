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
        Schema::create('order_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('technician_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('rating'); // 1 to 5
            $table->text('review')->nullable();
            $table->tinyInteger('service_quality')->nullable(); // 1 to 5
            $table->tinyInteger('communication')->nullable(); // 1 to 5
            $table->tinyInteger('punctuality')->nullable(); // 1 to 5
            $table->tinyInteger('professionalism')->nullable(); // 1 to 5
            $table->timestamps();
            
            // Ensure one review per order
            $table->unique('order_id');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_reviews');
    }
};
