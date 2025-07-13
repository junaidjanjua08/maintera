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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('sender_id'); // User ID (customer or technician)
            $table->enum('sender_type', ['customer', 'technician']);
            $table->text('message');
            $table->enum('message_type', ['text', 'image', 'file', 'location'])->default('text');
            $table->string('file_path')->nullable(); // For images/files
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();
            $table->json('location_data')->nullable(); // For location sharing
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['order_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
