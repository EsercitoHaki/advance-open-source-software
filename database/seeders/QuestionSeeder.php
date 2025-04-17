<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạm thời tắt kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Xóa dữ liệu cũ để tránh trùng lặp
        Question::truncate();
        
        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Tạo dữ liệu mẫu cho câu hỏi
        $questions = [
            // Lesson 1: Ngữ pháp tiếng Anh cơ bản
            [
                'lesson_id' => 1,
                'score' => 1.0,
                'content' => null,
                'question_text' => 'Which of the following is a correct sentence?',
                'explanation' => '"She goes to school every day" is correct. Subject-verb agreement requires "goes" with the third person singular subject "she".'
            ],
            [
                'lesson_id' => 1,
                'score' => 1.0,
                'content' => null,
                'question_text' => 'What is the past tense form of the verb "eat"?',
                'explanation' => 'The past tense of "eat" is "ate". It is an irregular verb.'
            ],
            [
                'lesson_id' => 1,
                'score' => 1.5,
                'content' => null,
                'question_text' => 'Which sentence uses the present perfect tense correctly?',
                'explanation' => '"They have lived here for ten years" correctly uses the present perfect tense to describe an action that began in the past and continues to the present.'
            ],
            [
                'lesson_id' => 1,
                'score' => 2.0,
                'content' => null,
                'question_text' => 'Identify the correct passive voice construction:',
                'explanation' => '"The book was written by Mark Twain" is in passive voice. The subject receives the action.'
            ],
            [
                'lesson_id' => 1,
                'score' => 1.5,
                'content' => null,
                'question_text' => 'Choose the correct conditional sentence:',
                'explanation' => '"If it rains tomorrow, I will stay at home" is a first conditional sentence that expresses a possible future condition.'
            ],

            // Lesson 2: Từ vựng chủ đề du lịch
            [
                'lesson_id' => 2,
                'score' => 1.0,
                'content' => null,
                'question_text' => 'What is the meaning of "itinerary"?',
                'explanation' => 'An itinerary is a detailed plan for a journey, including the route and places to be visited.'
            ],
            [
                'lesson_id' => 2,
                'score' => 1.0,
                'content' => null,
                'question_text' => 'Which word is NOT related to accommodation?',
                'explanation' => '"Excursion" means a short journey or trip, especially one taken as a leisure activity. It\'s not related to accommodation.'
            ],
            [
                'lesson_id' => 2,
                'score' => 1.5,
                'content' => null,
                'question_text' => 'What is "jet lag"?',
                'explanation' => 'Jet lag is a temporary sleep problem that can affect anyone who travels across multiple time zones.'
            ],
            [
                'lesson_id' => 2,
                'score' => 1.0,
                'content' => null,
                'question_text' => 'Which phrase would you use to ask for directions?',
                'explanation' => '"Could you tell me how to get to the museum?" is a polite way to ask for directions.'
            ],
            [
                'lesson_id' => 2,
                'score' => 1.5,
                'content' => null,
                'question_text' => 'What is a "tourist trap"?',
                'explanation' => 'A "tourist trap" is a place that attracts tourists and is typically overpriced and overcrowded.'
            ],

            // Lesson 3: Kỹ năng nghe hiểu
            [
                'lesson_id' => 3,
                'score' => 1.0,
                'content' => 'Audio: A woman asking about train schedules',
                'question_text' => 'What time does the last train to London depart?',
                'explanation' => 'In the audio, the station attendant mentions that the last train to London departs at 10:45 PM.'
            ],
            [
                'lesson_id' => 3,
                'score' => 1.5,
                'content' => 'Audio: Weather forecast',
                'question_text' => 'What will the weather be like tomorrow afternoon?',
                'explanation' => 'The weather forecaster predicts sunny conditions for tomorrow afternoon with temperatures reaching 25 degrees Celsius.'
            ],
            [
                'lesson_id' => 3,
                'score' => 2.0,
                'content' => 'Audio: Business meeting discussion',
                'question_text' => 'What is the main concern the manager expresses about the project?',
                'explanation' => 'The manager primarily expresses concerns about the project timeline and potential delays.'
            ],
            [
                'lesson_id' => 3,
                'score' => 1.5,
                'content' => 'Audio: Restaurant conversation',
                'question_text' => 'What does the customer order for dessert?',
                'explanation' => 'The customer orders chocolate cake with ice cream for dessert after considering the apple pie.'
            ],
            [
                'lesson_id' => 3,
                'score' => 2.0,
                'content' => 'Audio: Academic lecture',
                'question_text' => 'What is the main topic of the professor\'s lecture?',
                'explanation' => 'The professor\'s lecture primarily focuses on the economic impacts of climate change.'
            ],

            // Lesson 4: Kỹ năng đọc hiểu
            [
                'lesson_id' => 4,
                'score' => 1.5,
                'content' => 'Reading passage about renewable energy',
                'question_text' => 'According to the passage, which renewable energy source is growing the fastest globally?',
                'explanation' => 'The passage states that solar power is currently the fastest-growing renewable energy source globally.'
            ],
            [
                'lesson_id' => 4,
                'score' => 2.0,
                'content' => 'Reading passage about marine biology',
                'question_text' => 'What is the main threat to coral reefs mentioned in the article?',
                'explanation' => 'The article identifies ocean acidification as the primary threat to coral reefs worldwide.'
            ],
            [
                'lesson_id' => 4,
                'score' => 1.5,
                'content' => 'Reading passage about technological innovation',
                'question_text' => 'What conclusion does the author draw about artificial intelligence?',
                'explanation' => 'The author concludes that artificial intelligence will transform numerous industries but requires careful ethical considerations.'
            ],
            [
                'lesson_id' => 4,
                'score' => 2.0,
                'content' => 'Reading passage about healthy lifestyle',
                'question_text' => 'Which diet is NOT mentioned as beneficial for heart health?',
                'explanation' => 'While the Mediterranean and DASH diets are mentioned as beneficial for heart health, the ketogenic diet is not discussed in this context in the passage.'
            ],
            [
                'lesson_id' => 4,
                'score' => 1.5,
                'content' => 'Reading passage about urban planning',
                'question_text' => 'What solution does the article propose for urban traffic congestion?',
                'explanation' => 'The article proposes investment in public transportation infrastructure as the most effective solution for urban traffic congestion.'
            ],

            // Lesson 5: Giao tiếp trong kinh doanh
            [
                'lesson_id' => 5,
                'score' => 1.0,
                'content' => null,
                'question_text' => 'Which phrase is most appropriate for beginning a formal business email?',
                'explanation' => '"Dear Mr./Ms. [Last Name]" is the most appropriate and professional way to begin a formal business email.'
            ],
            [
                'lesson_id' => 5,
                'score' => 1.5,
                'content' => null,
                'question_text' => 'In a business negotiation, what does the phrase "ballpark figure" mean?',
                'explanation' => 'A "ballpark figure" refers to a rough numerical estimate or approximation.'
            ],
            [
                'lesson_id' => 5,
                'score' => 2.0,
                'content' => null,
                'question_text' => 'What is the most appropriate way to decline a business proposal?',
                'explanation' => 'Expressing appreciation followed by a clear but polite decline is the most professional approach to declining a business proposal.'
            ],
            [
                'lesson_id' => 5,
                'score' => 1.5,
                'content' => null,
                'question_text' => 'Which statement represents active listening in a business meeting?',
                'explanation' => 'Paraphrasing and asking clarifying questions demonstrates active listening by showing engagement and seeking to understand the speaker\'s points.'
            ],
            [
                'lesson_id' => 5,
                'score' => 1.0,
                'content' => null,
                'question_text' => 'What does the idiom "to cut corners" mean in business context?',
                'explanation' => 'To "cut corners" means to do something in the easiest or cheapest way, often by omitting important elements or steps.'
            ]
        ];

        // Thêm dữ liệu vào database
        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
