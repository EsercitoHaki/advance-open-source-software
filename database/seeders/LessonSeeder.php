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
                'title' => 'Ngữ pháp tiếng Anh cơ bản',
                'category' => 'Grammar',
                'created_date' => '2025-04-10'
            ],
            [
                'title' => 'Từ vựng chủ đề du lịch',
                'category' => 'Vocabulary',
                'created_date' => '2025-04-11'
            ],
            [
                'title' => 'Kỹ năng nghe hiểu',
                'category' => 'Listening',
                'created_date' => '2025-04-12'
            ],
            [
                'title' => 'Kỹ năng đọc hiểu',
                'category' => 'Reading',
                'created_date' => '2025-04-13'
            ],
            [
                'title' => 'Giao tiếp trong kinh doanh',
                'category' => 'Vocabulary',
                'created_date' => '2025-04-14'
            ],
        ];

        // Thêm dữ liệu vào database
        foreach ($lessons as $lesson) {
            Lesson::create($lesson);
        }
    }
}
