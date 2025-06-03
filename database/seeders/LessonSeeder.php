<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạm thời tắt kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Xóa dữ liệu cũ để tránh trùng lặp
        Lesson::truncate();
        
        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Tạo dữ liệu mẫu cho bài học
        $lessons = [
            [
                'title' => 'Part 5: Incomplete Sentences - Grammar and Vocabulary',
                'category' => 'Reading',
                'created_date' => '2025-04-10',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Part 6: Text Completion - Business Contexts',
                'category' => 'Reading',
                'created_date' => '2025-04-11',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Part 7: Reading Comprehension - Emails and Reports',
                'category' => 'Reading',
                'created_date' => '2025-04-12',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Part 3: Conversations - Workplace Dialogues',
                'category' => 'Listening',
                'created_date' => '2025-04-13',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Part 4: Talks - Announcements and Presentations',
                'category' => 'Listening',
                'created_date' => '2025-04-14',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Part 1: Photographs - Describing Images',
                'category' => 'Listening',
                'created_date' => '2025-04-15',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Part 2: Question-Response - Daily Scenarios',
                'category' => 'Listening',
                'created_date' => '2025-04-16',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Part 5: Incomplete Sentences - Advanced Grammar',
                'category' => 'Reading',
                'created_date' => '2025-04-17',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Part 6: Text Completion - Technical Reports',
                'category' => 'Reading',
                'created_date' => '2025-04-18',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Part 7: Reading Comprehension - Advertisements',
                'category' => 'Reading',
                'created_date' => '2025-04-19',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Part 3: Conversations - Customer Service Scenarios',
                'category' => 'Listening',
                'created_date' => '2025-04-20',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Part 5: Incomplete Sentences - Professional Terms',
                'category' => 'Reading',
                'created_date' => '2025-04-21',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Part 6: Text Completion - Project Proposals',
                'category' => 'Reading',
                'created_date' => '2025-04-22',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Part 7: Reading Comprehension - News Articles',
                'category' => 'Reading',
                'created_date' => '2025-04-23',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Part 4: Talks - Conference Speeches',
                'category' => 'Listening',
                'created_date' => '2025-04-24',
                'time_limit' => 600 // 10 phút
            ],
        ];

        // Thêm dữ liệu vào database
        foreach ($lessons as $lesson) {
            Lesson::create($lesson);
        }
    }
}