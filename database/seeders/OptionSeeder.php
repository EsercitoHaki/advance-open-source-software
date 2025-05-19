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
        $options = [
            // Lesson 1: Question 1
            [
                'question_id' => 1,
                'option_text' => 'She go to school every day.',
                'is_correct' => false
            ],
            [
                'question_id' => 1,
                'option_text' => 'She goes to school every day.',
                'is_correct' => true
            ],
            [
                'question_id' => 1,
                'option_text' => 'She going to school every day.',
                'is_correct' => false
            ],
            [
                'question_id' => 1,
                'option_text' => 'She gone to school every day.',
                'is_correct' => false
            ],
            
            // Lesson 1: Question 2
            [
                'question_id' => 2,
                'option_text' => 'Eat',
                'is_correct' => false
            ],
            [
                'question_id' => 2,
                'option_text' => 'Ate',
                'is_correct' => true
            ],
            [
                'question_id' => 2,
                'option_text' => 'Eated',
                'is_correct' => false
            ],
            [
                'question_id' => 2,
                'option_text' => 'Eating',
                'is_correct' => false
            ],
            
            // Lesson 1: Question 3
            [
                'question_id' => 3,
                'option_text' => 'They lived here for ten years.',
                'is_correct' => false
            ],
            [
                'question_id' => 3,
                'option_text' => 'They have lived here for ten years.',
                'is_correct' => true
            ],
            [
                'question_id' => 3,
                'option_text' => 'They living here for ten years.',
                'is_correct' => false
            ],
            [
                'question_id' => 3,
                'option_text' => 'They are live here for ten years.',
                'is_correct' => false
            ],
            
            // Lesson 1: Question 4
            [
                'question_id' => 4,
                'option_text' => 'Mark Twain wrote the book.',
                'is_correct' => false
            ],
            [
                'question_id' => 4,
                'option_text' => 'The book was written by Mark Twain.',
                'is_correct' => true
            ],
            [
                'question_id' => 4,
                'option_text' => 'The book is write by Mark Twain.',
                'is_correct' => false
            ],
            [
                'question_id' => 4,
                'option_text' => 'Mark Twain has wrote the book.',
                'is_correct' => false
            ],
            
            // Lesson 1: Question 5
            [
                'question_id' => 5,
                'option_text' => 'If it will rain tomorrow, I stay at home.',
                'is_correct' => false
            ],
            [
                'question_id' => 5,
                'option_text' => 'If it rains tomorrow, I will stay at home.',
                'is_correct' => true
            ],
            [
                'question_id' => 5,
                'option_text' => 'If it raining tomorrow, I will staying at home.',
                'is_correct' => false
            ],
            [
                'question_id' => 5,
                'option_text' => 'If it rained tomorrow, I would stay at home.',
                'is_correct' => false
            ],
            
            // Lesson 2: Question 6
            [
                'question_id' => 6,
                'option_text' => 'A type of camera',
                'is_correct' => false
            ],
            [
                'question_id' => 6,
                'option_text' => 'A detailed plan for a journey',
                'is_correct' => true
            ],
            [
                'question_id' => 6,
                'option_text' => 'A person who guides tourists',
                'is_correct' => false
            ],
            [
                'question_id' => 6,
                'option_text' => 'A travel document',
                'is_correct' => false
            ],
            
            // Lesson 2: Question 7
            [
                'question_id' => 7,
                'option_text' => 'Hotel',
                'is_correct' => false
            ],
            [
                'question_id' => 7,
                'option_text' => 'Hostel',
                'is_correct' => false
            ],
            [
                'question_id' => 7,
                'option_text' => 'Excursion',
                'is_correct' => true
            ],
            [
                'question_id' => 7,
                'option_text' => 'Resort',
                'is_correct' => false
            ],
            
            // Lesson 2: Question 8
            [
                'question_id' => 8,
                'option_text' => 'A fee for excess luggage',
                'is_correct' => false
            ],
            [
                'question_id' => 8,
                'option_text' => 'A temporary sleep problem caused by traveling across time zones',
                'is_correct' => true
            ],
            [
                'question_id' => 8,
                'option_text' => 'The delay of a flight',
                'is_correct' => false
            ],
            [
                'question_id' => 8,
                'option_text' => 'A type of aircraft',
                'is_correct' => false
            ],
            
            // Lesson 2: Question 9
            [
                'question_id' => 9,
                'option_text' => 'Where is museum?',
                'is_correct' => false
            ],
            [
                'question_id' => 9,
                'option_text' => 'Could you tell me how to get to the museum?',
                'is_correct' => true
            ],
            [
                'question_id' => 9,
                'option_text' => 'I want museum.',
                'is_correct' => false
            ],
            [
                'question_id' => 9,
                'option_text' => 'Give me directions.',
                'is_correct' => false
            ],
            
            // Lesson 2: Question 10
            [
                'question_id' => 10,
                'option_text' => 'A place where tourists are physically trapped',
                'is_correct' => false
            ],
            [
                'question_id' => 10,
                'option_text' => 'An attraction that is overpriced and often disappointing',
                'is_correct' => true
            ],
            [
                'question_id' => 10,
                'option_text' => 'A special discount for tourists',
                'is_correct' => false
            ],
            [
                'question_id' => 10,
                'option_text' => 'A device for catching tourists',
                'is_correct' => false
            ],
            
            // Lesson 3: Questions 11-15 (Listening comprehension)
            // Question 11
            [
                'question_id' => 11,
                'option_text' => '9:30 PM',
                'is_correct' => false
            ],
            [
                'question_id' => 11,
                'option_text' => '10:15 PM',
                'is_correct' => false
            ],
            [
                'question_id' => 11,
                'option_text' => '10:45 PM',
                'is_correct' => true
            ],
            [
                'question_id' => 11,
                'option_text' => '11:00 PM',
                'is_correct' => false
            ],
            
            // Question 12
            [
                'question_id' => 12,
                'option_text' => 'Rainy',
                'is_correct' => false
            ],
            [
                'question_id' => 12,
                'option_text' => 'Sunny',
                'is_correct' => true
            ],
            [
                'question_id' => 12,
                'option_text' => 'Cloudy',
                'is_correct' => false
            ],
            [
                'question_id' => 12,
                'option_text' => 'Windy',
                'is_correct' => false
            ],
            
            // Question 13
            [
                'question_id' => 13,
                'option_text' => 'Budget overruns',
                'is_correct' => false
            ],
            [
                'question_id' => 13,
                'option_text' => 'Staff performance',
                'is_correct' => false
            ],
            [
                'question_id' => 13,
                'option_text' => 'Timeline delays',
                'is_correct' => true
            ],
            [
                'question_id' => 13,
                'option_text' => 'Quality issues',
                'is_correct' => false
            ],
            
            // Question 14
            [
                'question_id' => 14,
                'option_text' => 'Ice cream only',
                'is_correct' => false
            ],
            [
                'question_id' => 14,
                'option_text' => 'Apple pie',
                'is_correct' => false
            ],
            [
                'question_id' => 14,
                'option_text' => 'Chocolate cake with ice cream',
                'is_correct' => true
            ],
            [
                'question_id' => 14,
                'option_text' => 'No dessert',
                'is_correct' => false
            ],
            
            // Question 15
            [
                'question_id' => 15,
                'option_text' => 'Global warming',
                'is_correct' => false
            ],
            [
                'question_id' => 15,
                'option_text' => 'Economic impacts of climate change',
                'is_correct' => true
            ],
            [
                'question_id' => 15,
                'option_text' => 'Renewable energy',
                'is_correct' => false
            ],
            [
                'question_id' => 15,
                'option_text' => 'Environmental policy',
                'is_correct' => false
            ],
            
            // Lesson 4: Questions 16-20 (Reading comprehension)
            // Question 16
            [
                'question_id' => 16,
                'option_text' => 'Wind power',
                'is_correct' => false
            ],
            [
                'question_id' => 16,
                'option_text' => 'Solar power',
                'is_correct' => true
            ],
            [
                'question_id' => 16,
                'option_text' => 'Hydroelectric power',
                'is_correct' => false
            ],
            [
                'question_id' => 16,
                'option_text' => 'Geothermal energy',
                'is_correct' => false
            ],
            
            // Question 17
            [
                'question_id' => 17,
                'option_text' => 'Overfishing',
                'is_correct' => false
            ],
            [
                'question_id' => 17,
                'option_text' => 'Ocean acidification',
                'is_correct' => true
            ],
            [
                'question_id' => 17,
                'option_text' => 'Plastic pollution',
                'is_correct' => false
            ],
            [
                'question_id' => 17,
                'option_text' => 'Tourism',
                'is_correct' => false
            ],
            
            // Question 18
            [
                'question_id' => 18,
                'option_text' => 'AI will replace all human jobs within a decade',
                'is_correct' => false
            ],
            [
                'question_id' => 18,
                'option_text' => 'AI will transform industries but requires ethical considerations',
                'is_correct' => true
            ],
            [
                'question_id' => 18,
                'option_text' => 'AI development should be halted immediately',
                'is_correct' => false
            ],
            [
                'question_id' => 18,
                'option_text' => 'AI has been overhyped and will have minimal impact',
                'is_correct' => false
            ],
            
            // Question 19
            [
                'question_id' => 19,
                'option_text' => 'Mediterranean diet',
                'is_correct' => false
            ],
            [
                'question_id' => 19,
                'option_text' => 'DASH diet',
                'is_correct' => false
            ],
            [
                'question_id' => 19,
                'option_text' => 'Ketogenic diet',
                'is_correct' => true
            ],
            [
                'question_id' => 19,
                'option_text' => 'Vegetarian diet',
                'is_correct' => false
            ],
            
            // Question 20
            [
                'question_id' => 20,
                'option_text' => 'Building more roads',
                'is_correct' => false
            ],
            [
                'question_id' => 20,
                'option_text' => 'Investing in public transportation',
                'is_correct' => true
            ],
            [
                'question_id' => 20,
                'option_text' => 'Banning cars in city centers',
                'is_correct' => false
            ],
            [
                'question_id' => 20,
                'option_text' => 'Implementing road tolls',
                'is_correct' => false
            ],
            
            // Lesson 5: Questions 21-25 (Business communication)
            // Question 21
            [
                'question_id' => 21,
                'option_text' => 'Hey there,',
                'is_correct' => false
            ],
            [
                'question_id' => 21,
                'option_text' => 'Dear Mr./Ms. [Last Name],',
                'is_correct' => true
            ],
            [
                'question_id' => 21,
                'option_text' => 'Hi,',
                'is_correct' => false
            ],
            [
                'question_id' => 21,
                'option_text' => 'To whom it concerns,',
                'is_correct' => false
            ],
            
            // Question 22
            [
                'question_id' => 22,
                'option_text' => 'A baseball term',
                'is_correct' => false
            ],
            [
                'question_id' => 22,
                'option_text' => 'A rough numerical estimate',
                'is_correct' => true
            ],
            [
                'question_id' => 22,
                'option_text' => 'A final offer',
                'is_correct' => false
            ],
            [
                'question_id' => 22,
                'option_text' => 'A competitive price',
                'is_correct' => false
            ],
            
            // Question 23
            [
                'question_id' => 23,
                'option_text' => 'Simply ignore the proposal',
                'is_correct' => false
            ],
            [
                'question_id' => 23,
                'option_text' => 'Thank you for your proposal. After careful consideration, we have decided not to proceed at this time.',
                'is_correct' => true
            ],
            [
                'question_id' => 23,
                'option_text' => 'Your proposal is rejected.',
                'is_correct' => false
            ],
            [
                'question_id' => 23,
                'option_text' => 'We will get back to you later.',
                'is_correct' => false
            ],
            
            // Question 24
            [
                'question_id' => 24,
                'option_text' => 'Checking your phone during the meeting',
                'is_correct' => false
            ],
            [
                'question_id' => 24,
                'option_text' => 'Paraphrasing and asking clarifying questions',
                'is_correct' => true
            ],
            [
                'question_id' => 24,
                'option_text' => 'Waiting for your turn to speak',
                'is_correct' => false
            ],
            [
                'question_id' => 24,
                'option_text' => 'Taking notes without making eye contact',
                'is_correct' => false
            ],
            
            // Question 25
            [
                'question_id' => 25,
                'option_text' => 'To delegate tasks effectively',
                'is_correct' => false
            ],
            [
                'question_id' => 25,
                'option_text' => 'To do something in the easiest or cheapest way, often by omitting important steps',
                'is_correct' => true
            ],
            [
                'question_id' => 25,
                'option_text' => 'To maximize profit',
                'is_correct' => false
            ],
            [
                'question_id' => 25,
                'option_text' => 'To innovate in business',
                'is_correct' => false
            ],
        ];

        // Thêm dữ liệu vào database
        foreach ($options as $option) {
            Option::create($option);
        }
    }
}
