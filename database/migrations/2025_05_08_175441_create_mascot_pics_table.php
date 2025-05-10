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
        Schema::create('mascot_pics', function (Blueprint $table) {
            $table->id('pic_id'); 
            $table->unsignedBigInteger('mascot_id'); 
            $table->string('pic_name', 100); 
            $table->string('pic_url', 255); 
            $table->foreign('mascot_id')->references('item_id')->on('store_items')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascot_pics');
    }
};
