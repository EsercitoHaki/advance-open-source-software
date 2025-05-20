<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // Add time limit column
            if (!Schema::hasColumn('lessons', 'time_limit')) {
                $table->unsignedInteger('time_limit')->default(600)->comment('Thời gian giới hạn của bài học tính bằng giây');
            }
        });

        // Add elapsed_time column to user_progress table
        Schema::table('user_progress', function (Blueprint $table) {
            if (!Schema::hasColumn('user_progress', 'elapsed_time')) {
                $table->unsignedInteger('elapsed_time')->default(0)->comment('Thời gian đã sử dụng (tính bằng giây)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            if (Schema::hasColumn('lessons', 'time_limit')) {
                $table->dropColumn('time_limit');
            }
        });

        Schema::table('user_progress', function (Blueprint $table) {
            if (Schema::hasColumn('user_progress', 'elapsed_time')) {
                $table->dropColumn('elapsed_time');
            }
        });
    }
};
