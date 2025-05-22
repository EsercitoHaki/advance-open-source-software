<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạm thời tắt kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Xóa dữ liệu cũ để tránh trùng lặp
        Option::truncate();
        
        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Tạo dữ liệu mẫu cho options
        $options = [];
        
        // LESSON 1 OPTIONS (Kỹ năng nghe hiểu cơ bản) - 10 questions, 4 options each
        $this->addOptionsForLesson1($options);
        
        // LESSON 2 OPTIONS (Nghe hiểu bài hội thoại) - 10 questions, 4 options each
        $this->addOptionsForLesson2($options);
        
        // LESSON 3 OPTIONS (Kỹ năng đọc hiểu văn bản) - 10 questions, 4 options each
        $this->addOptionsForLesson3($options);
        
        // LESSON 4 OPTIONS (Đọc hiểu đoạn văn học thuật) - 10 questions, 4 options each
        $this->addOptionsForLesson4($options);
        
        // LESSON 5 OPTIONS (Luyện nghe đoạn hội thoại dài) - 10 questions, 4 options each
        $this->addOptionsForLesson5($options);

        // Thêm dữ liệu vào database
        foreach ($options as $option) {
            Option::create($option);
        }
    }
}