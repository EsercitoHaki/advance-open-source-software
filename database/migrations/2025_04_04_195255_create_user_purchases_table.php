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
        Schema::create('user_purchases', function (Blueprint $table) {
            $table->id('purchase_id');
            $table->char('user_id', 36);
            $table->unsignedBigInteger('item_id');
            $table->timestamp('purchase_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('item_id')->references('item_id')->on('store_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_purchases');
    }
};
