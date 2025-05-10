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
        Schema::create('missions', function (Blueprint $table) {
            $table->id('mission_id'); 
            $table->string('title', 100);
            $table->text('description');
            $table->integer('reward_coins')->default(10); 
            $table->integer('required_count')->default(1); 
            $table->boolean('is_active')->default(true); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
