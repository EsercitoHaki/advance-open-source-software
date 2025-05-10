<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('missions')->insert([
            [
                'title' => 'Hoàn thành bài học đầu tiên',
                'description' => 'Người dùng cần hoàn thành bài học đầu tiên để nhận thưởng.',
                'reward_coins' => 20,
                'required_action' => 'complete_lesson',
                'required_count' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Trả lời 5 câu hỏi đúng',
                'description' => 'Người dùng cần trả lời đúng 5 câu hỏi trong hệ thống.',
                'reward_coins' => 30,
                'required_action' => 'correct_answers',
                'required_count' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Điểm danh 3 ngày liên tiếp',
                'description' => 'Người dùng cần điểm danh 3 ngày liên tiếp.',
                'reward_coins' => 50,
                'required_action' => 'daily_checkin',
                'required_count' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Mời 1 người bạn',
                'description' => 'Mời bạn bè tham gia hệ thống để nhận thưởng.',
                'reward_coins' => 40,
                'required_action' => 'invite_friend',
                'required_count' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Hoàn thành tất cả nhiệm vụ trong ngày',
                'description' => 'Người dùng cần hoàn thành toàn bộ nhiệm vụ được giao trong ngày.',
                'reward_coins' => 100,
                'required_action' => 'complete_daily_missions',
                'required_count' => 1,
                'is_active' => false,
            ],
        ]);
    }
}
