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
        Schema::create('technician_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->string('occupation')->nullable();
            $table->string('experience')->nullable();
            $table->string('qualification')->nullable();
            
            // Address fields
            $table->text('address')->nullable();
            $table->string('street_number')->nullable();
            $table->string('route')->nullable();
            $table->string('locality')->nullable();
            $table->string('area')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->default('Pakistan');
            
            // Location coordinates
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            
            // Profile image
            $table->string('profile_image')->nullable();
            
            // Additional fields
            $table->text('bio')->nullable();
            $table->json('skills')->nullable();
            $table->boolean('is_available')->default(true);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('total_orders')->default(0);
            $table->integer('completed_orders')->default(0);
            
            // Verification fields
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technician_profiles');
    }
}; 