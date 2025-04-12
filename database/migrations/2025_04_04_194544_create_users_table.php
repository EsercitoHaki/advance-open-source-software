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
        Schema::create('users', function (Blueprint $table) {
            $table->char('user_id', 36)->primary()->default(DB::raw('UUID()')); // Lưu dưới dạng UUID chuỗi
            $table->string('username', 50)->unique()->notNullable();
            $table->string('email', 100)->unique()->notNullable();
            $table->string('password', 255)->notNullable();
            $table->string('full_name', 50)->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('avatar')->default('default-avatar.png')->change();
            $table->unsignedBigInteger('role_id')->default(2); // Can sua lai trong database 
            $table->integer('coins')->default(0);
            $table->integer('lives')->default(5);
            $table->integer('current_streak')->default(0);
            $table->integer('longest_streak')->default(0);
            $table->timestamp('registration_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('is_active')->default(true);
            $table->foreign('role_id')->references('role_id')->on('roles'); // Liên kết với bảng Roles
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
