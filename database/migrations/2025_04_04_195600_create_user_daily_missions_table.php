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
        Schema::create('user_daily_missions', function (Blueprint $table) {
            $table->id('user_mission_id');
            $table->char('user_id', 36);
            $table->unsignedBigInteger('mission_id');
            $table->date('date'); 
            $table->integer('progress')->default(0); 
            $table->boolean('is_completed')->default(false); 
            $table->boolean('reward_claimed')->default(false); 
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade'); 
            $table->foreign('mission_id')->references('mission_id')->on('missions')->onDelete('cascade'); 
            $table->unique(['user_id', 'mission_id', 'date']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_daily_missions');
    }
};
