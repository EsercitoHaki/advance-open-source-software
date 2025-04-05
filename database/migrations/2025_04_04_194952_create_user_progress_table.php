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
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id('progress_id');
            $table->char('user_id', 36); 
            $table->unsignedBigInteger('lesson_id');
            $table->enum('completion_status', ['Not Started', 'In Progress', 'Completed'])->default('Not Started');
            $table->decimal('score', 5, 2)->default(0.00); 
            $table->timestamp('start_date')->nullable(); 
            $table->timestamp('completion_date')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('lesson_id')->references('lesson_id')->on('lessons')->onDelete('cascade');
            $table->unique(['user_id', 'lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};
