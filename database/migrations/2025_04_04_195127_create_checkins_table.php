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
        Schema::create('checkins', function (Blueprint $table) {
            $table->id('checkin_id');
            $table->char('user_id', 36); 
            $table->date('checkin_date');
            $table->integer('coins_earned')->default(10);
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'checkin_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkins');
    }
};
