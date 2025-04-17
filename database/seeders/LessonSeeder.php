<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;
use Carbon\Carbon;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now()->format('Y-m-d');

        // Dữ liệu mẫu cho bài học
        $lessons = [
            [
                'title' => 'Introduction to Laravel',
                'category' => 'Grammar',
                'created_date' => $now,
            ],
            [
                'title' => 'Laravel Controllers',
                'category' => 'Grammar',
                'created_date' => $now,
            ],
            [
                'title' => 'Eloquent ORM Basics',
                'category' => 'Vocabulary',
                'created_date' => $now,
            ],
            [
                'title' => 'Laravel Blade Templates',
                'category' => 'Reading',
                'created_date' => $now,
            ],
            [
                'title' => 'Laravel Authentication',
                'category' => 'Listening',
                'created_date' => $now,
            ],
            [
                'title' => 'Laravel Middleware',
                'category' => 'Grammar',
                'created_date' => $now,
            ],
            [
                'title' => 'Laravel Migration & Seeding',
                'category' => 'Vocabulary',
                'created_date' => $now,
            ],
            [
                'title' => 'Laravel API Development',
                'category' => 'Reading',
                'created_date' => $now,
            ],
            [
                'title' => 'Laravel Validation',
                'category' => 'Listening',
                'created_date' => $now,
            ],
            [
                'title' => 'Laravel Testing',
                'category' => 'Grammar',
                'created_date' => $now,
            ],
        ];

        foreach ($lessons as $lesson) {
            Lesson::create($lesson);
        }
    }
}
