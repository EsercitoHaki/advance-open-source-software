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
        Schema::create('friend_requests', function (Blueprint $table) {
            $table->id('friend_request_id'); 
            $table->char('sender_id', 36);
            $table->char('receiver_id', 36); 
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); 
            $table->timestamps(0); 
            $table->unique(['sender_id', 'receiver_id']); 
            $table->foreign('sender_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('user_id')->on('users')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friend_requests');
    }
};
