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
                'title' => 'Kỹ năng nghe hiểu cơ bản',
                'category' => 'Listening',
                'created_date' => '2025-04-10',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Nghe hiểu bài hội thoại',
                'category' => 'Listening',
                'created_date' => '2025-04-11',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Kỹ năng đọc hiểu văn bản',
                'category' => 'Reading',
                'created_date' => '2025-04-12',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Đọc hiểu đoạn văn học thuật',
                'category' => 'Reading',
                'created_date' => '2025-04-13',
                'time_limit' => 600 // 10 phút
            ],
            [
                'title' => 'Luyện nghe đoạn hội thoại dài',
                'category' => 'Listening',
                'created_date' => '2025-04-14',
                'time_limit' => 600 // 10 phút
            ],
        ];

        // Thêm dữ liệu vào database
        foreach ($lessons as $lesson) {
            Lesson::create($lesson);
        }
    }
}
