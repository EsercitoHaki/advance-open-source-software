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
        Schema::create('store_items', function (Blueprint $table) {
            $table->id('item_id');
            $table->string('item_name', 100); 
            $table->enum('item_type', ['Lives', 'Mascot']); 
            $table->integer('item_price'); 
            $table->string('mascot_pic', 255)->nullable(); 
            $table->integer('lives_amount')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_items');
    }
};
