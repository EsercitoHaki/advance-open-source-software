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
            // Lesson 1: Kỹ năng nghe hiểu cơ bản
            [
                'lesson_id' => 1,
                'score' => 1.0,
                'content' => 'Audio: Basic conversation at a coffee shop',
                'question_text' => 'What did the customer order?',
                'explanation' => 'In the audio, the customer orders a large cappuccino with an extra shot of espresso.'
            ],
            [
                'lesson_id' => 1,
                'score' => 1.0,
                'content' => 'Audio: Weather forecast',
                'question_text' => 'What will the weather be like tomorrow?',
                'explanation' => 'The weather forecast predicts sunny conditions with a high of 25 degrees Celsius.'
            ],
            [
                'lesson_id' => 1,
                'score' => 1.0,
                'content' => 'Audio: Train station announcement',
                'question_text' => 'What platform is the train to London departing from?',
                'explanation' => 'The announcement states that the train to London is departing from Platform 3.'
            ],
            [
                'lesson_id' => 1,
                'score' => 1.0,
                'content' => 'Audio: Phone conversation',
                'question_text' => 'What time is the meeting scheduled for?',
                'explanation' => 'In the conversation, they agree to meet at 2:30 PM on Tuesday.'
            ],
            [
                'lesson_id' => 1,
                'score' => 1.0,
                'content' => 'Audio: Restaurant reservation',
                'question_text' => 'How many people is the reservation for?',
                'explanation' => 'The caller makes a reservation for a table for 4 people.'
            ],
            [
                'lesson_id' => 1,
                'score' => 1.0,
                'content' => 'Audio: Airport announcement',
                'question_text' => 'Why is the flight delayed?',
                'explanation' => 'The announcement mentions that the flight is delayed due to bad weather conditions.'
            ],
            [
                'lesson_id' => 1,
                'score' => 1.0,
                'content' => 'Audio: Doctor appointment',
                'question_text' => 'What does the doctor recommend?',
                'explanation' => 'The doctor recommends taking the medication twice daily with meals and getting plenty of rest.'
            ],
            [
                'lesson_id' => 1,
                'score' => 1.0,
                'content' => 'Audio: Hotel check-in conversation',
                'question_text' => 'What floor is the guest\'s room on?',
                'explanation' => 'The receptionist mentions that the room is on the 5th floor.'
            ],
            [
                'lesson_id' => 1,
                'score' => 1.0,
                'content' => 'Audio: Shopping conversation',
                'question_text' => 'How much did the customer pay?',
                'explanation' => 'The customer paid $45.99 for the items.'
            ],
            [
                'lesson_id' => 1,
                'score' => 1.0,
                'content' => 'Audio: Direction instructions',
                'question_text' => 'How far is the museum from the hotel?',
                'explanation' => 'According to the directions, the museum is about a 10-minute walk from the hotel.'
            ],

            // Lesson 2: Nghe hiểu bài hội thoại
            [
                'lesson_id' => 2,
                'score' => 1.0,
                'content' => 'Audio: Job interview',
                'question_text' => 'What experience does the candidate highlight?',
                'explanation' => 'The candidate emphasizes their previous experience in team management and project coordination.'
            ],
            [
                'lesson_id' => 2,
                'score' => 1.0,
                'content' => 'Audio: Academic lecture on history',
                'question_text' => 'What major event does the professor discuss?',
                'explanation' => 'The professor primarily discusses the Industrial Revolution and its impact on society.'
            ],
            [
                'lesson_id' => 2,
                'score' => 1.0,
                'content' => 'Audio: Business meeting',
                'question_text' => 'What is the main topic of the meeting?',
                'explanation' => 'The main topic of the meeting is the company\'s new marketing strategy for the upcoming quarter.'
            ],
            [
                'lesson_id' => 2,
                'score' => 1.0,
                'content' => 'Audio: Travel guide information',
                'question_text' => 'What is the recommended activity for rainy days?',
                'explanation' => 'The guide recommends visiting the city museum on rainy days.'
            ],
            [
                'lesson_id' => 2,
                'score' => 1.0,
                'content' => 'Audio: Customer service call',
                'question_text' => 'What is the customer\'s complaint?',
                'explanation' => 'The customer is complaining about being charged twice for their subscription.'
            ],
            [
                'lesson_id' => 2,
                'score' => 1.0,
                'content' => 'Audio: Radio interview with author',
                'question_text' => 'What inspired the author to write the book?',
                'explanation' => 'The author mentions that their travels through Southeast Asia inspired them to write the book.'
            ],
            [
                'lesson_id' => 2,
                'score' => 1.0,
                'content' => 'Audio: Cooking instructions',
                'question_text' => 'How long should the dish be baked?',
                'explanation' => 'According to the instructions, the dish should be baked for 35 minutes at 350 degrees.'
            ],
            [
                'lesson_id' => 2,
                'score' => 1.0,
                'content' => 'Audio: Film review',
                'question_text' => 'What aspect of the film does the reviewer praise the most?',
                'explanation' => 'The reviewer particularly praises the cinematography and visual effects of the film.'
            ],
            [
                'lesson_id' => 2,
                'score' => 1.0,
                'content' => 'Audio: Technology podcast',
                'question_text' => 'What new feature does the product offer?',
                'explanation' => 'The podcast discusses the product\'s new AI-powered voice recognition feature.'
            ],
            [
                'lesson_id' => 2,
                'score' => 1.0,
                'content' => 'Audio: Family conversation',
                'question_text' => 'What are they planning for the weekend?',
                'explanation' => 'The family is planning a camping trip in the mountains for the weekend.'
            ],

            // Lesson 3: Kỹ năng đọc hiểu văn bản
            [
                'lesson_id' => 3,
                'score' => 1.0,
                'content' => 'Reading passage about environmental conservation',
                'question_text' => 'What is the main topic of the passage?',
                'explanation' => 'The main topic of the passage is the importance of protecting endangered species and their habitats.'
            ],
            [
                'lesson_id' => 3,
                'score' => 1.0,
                'content' => 'Reading passage about technological innovation',
                'question_text' => 'According to the text, what is the biggest challenge facing AI development?',
                'explanation' => 'The text identifies ethical considerations and data privacy as the biggest challenges facing AI development.'
            ],
            [
                'lesson_id' => 3,
                'score' => 1.0,
                'content' => 'Reading passage about healthy eating',
                'question_text' => 'What diet is recommended for heart health?',
                'explanation' => 'The passage recommends the Mediterranean diet for maintaining heart health.'
            ],
            [
                'lesson_id' => 3,
                'score' => 1.0,
                'content' => 'Reading passage about space exploration',
                'question_text' => 'What is the next major goal for space agencies according to the article?',
                'explanation' => 'According to the article, establishing a permanent base on the Moon is the next major goal for space agencies.'
            ],
            [
                'lesson_id' => 3,
                'score' => 1.0,
                'content' => 'Reading passage about modern art',
                'question_text' => 'Which artist is credited with founding cubism?',
                'explanation' => 'The passage credits Pablo Picasso and Georges Braque with founding the cubist movement.'
            ],
            [
                'lesson_id' => 3,
                'score' => 1.0,
                'content' => 'Reading passage about urban planning',
                'question_text' => 'What solution does the article propose for traffic congestion?',
                'explanation' => 'The article proposes expanding public transportation networks as the primary solution for traffic congestion.'
            ],
            [
                'lesson_id' => 3,
                'score' => 1.0,
                'content' => 'Reading passage about literary analysis',
                'question_text' => 'What literary device is prominently featured in the excerpt?',
                'explanation' => 'The excerpt prominently features metaphor as a literary device to convey the author\'s message.'
            ],
            [
                'lesson_id' => 3,
                'score' => 1.0,
                'content' => 'Reading passage about economic theory',
                'question_text' => 'What economic principle is being described?',
                'explanation' => 'The passage is describing the principle of supply and demand in market economies.'
            ],
            [
                'lesson_id' => 3,
                'score' => 1.0,
                'content' => 'Reading passage about historical events',
                'question_text' => 'What was the main cause of the event according to the historian?',
                'explanation' => 'According to the historian cited, economic inequality was the main cause of the event.'
            ],
            [
                'lesson_id' => 3,
                'score' => 1.0,
                'content' => 'Reading passage about psychology',
                'question_text' => 'What theory does the psychologist propose?',
                'explanation' => 'The psychologist proposes a theory linking sleep patterns to cognitive performance and memory consolidation.'
            ],

            // Lesson 4: Đọc hiểu đoạn văn học thuật
            [
                'lesson_id' => 4,
                'score' => 1.0,
                'content' => 'Academic reading on marine biology',
                'question_text' => 'What is causing coral bleaching according to the research?',
                'explanation' => 'The research indicates that rising ocean temperatures due to climate change are the primary cause of coral bleaching.'
            ],
            [
                'lesson_id' => 4,
                'score' => 1.0,
                'content' => 'Academic reading on neuroscience',
                'question_text' => 'What did the researchers discover about memory formation?',
                'explanation' => 'The researchers discovered that sleep plays a crucial role in memory consolidation and formation.'
            ],
            [
                'lesson_id' => 4,
                'score' => 1.0,
                'content' => 'Academic reading on renewable energy',
                'question_text' => 'What conclusion does the study draw about solar power?',
                'explanation' => 'The study concludes that advances in solar panel efficiency will make it the most cost-effective energy source within a decade.'
            ],
            [
                'lesson_id' => 4,
                'score' => 1.0,
                'content' => 'Academic reading on anthropology',
                'question_text' => 'What evidence supports the cultural diffusion theory presented?',
                'explanation' => 'Similar artifact designs found across geographically separated regions support the cultural diffusion theory presented.'
            ],
            [
                'lesson_id' => 4,
                'score' => 1.0,
                'content' => 'Academic reading on linguistics',
                'question_text' => 'What phenomenon does the article explain?',
                'explanation' => 'The article explains the phenomenon of language acquisition in multilingual environments.'
            ],
            [
                'lesson_id' => 4,
                'score' => 1.0,
                'content' => 'Academic reading on public health',
                'question_text' => 'What correlation did the research identify?',
                'explanation' => 'The research identified a strong correlation between urban green spaces and reduced stress levels in residents.'
            ],
            [
                'lesson_id' => 4,
                'score' => 1.0,
                'content' => 'Academic reading on physics',
                'question_text' => 'What principle is demonstrated by the experiment?',
                'explanation' => 'The experiment demonstrates the principle of quantum entanglement described in the text.'
            ],
            [
                'lesson_id' => 4,
                'score' => 1.0,
                'content' => 'Academic reading on sociology',
                'question_text' => 'What social trend does the study document?',
                'explanation' => 'The study documents the increasing influence of social media on political engagement among young adults.'
            ],
            [
                'lesson_id' => 4,
                'score' => 1.0,
                'content' => 'Academic reading on climate science',
                'question_text' => 'What prediction does the climate model make?',
                'explanation' => 'The climate model predicts more frequent extreme weather events in coastal regions over the next 50 years.'
            ],
            [
                'lesson_id' => 4,
                'score' => 1.0,
                'content' => 'Academic reading on archaeology',
                'question_text' => 'What new dating technique revealed about the artifacts?',
                'explanation' => 'The new dating technique revealed that the artifacts are approximately 2,000 years older than previously thought.'
            ],

            // Lesson 5: Luyện nghe đoạn hội thoại dài
            [
                'lesson_id' => 5,
                'score' => 1.0,
                'content' => 'Audio: Extended academic lecture on economics',
                'question_text' => 'What economic theory does the professor primarily critique?',
                'explanation' => 'The professor primarily critiques the theory of trickle-down economics throughout the lecture.'
            ],
            [
                'lesson_id' => 5,
                'score' => 1.0,
                'content' => 'Audio: Panel discussion on climate change',
                'question_text' => 'What solution do most panelists agree on?',
                'explanation' => 'Most panelists agree that international cooperation and carbon pricing are essential solutions.'
            ],
            [
                'lesson_id' => 5,
                'score' => 1.0,
                'content' => 'Audio: Interview with a novelist',
                'question_text' => 'What inspired the author\'s latest book?',
                'explanation' => 'The author explains that their childhood experiences in rural Ireland inspired their latest book.'
            ],
            [
                'lesson_id' => 5,
                'score' => 1.0,
                'content' => 'Audio: Historical documentary narration',
                'question_text' => 'What caused the empire\'s eventual decline?',
                'explanation' => 'According to the narration, a combination of economic problems, military overextension, and climate change caused the empire\'s decline.'
            ],
            [
                'lesson_id' => 5,
                'score' => 1.0,
                'content' => 'Audio: Scientific podcast on astronomy',
                'question_text' => 'What recent discovery is discussed?',
                'explanation' => 'The podcast discusses the recent discovery of potentially habitable exoplanets in a nearby star system.'
            ],
            [
                'lesson_id' => 5,
                'score' => 1.0,
                'content' => 'Audio: Debate on urban development',
                'question_text' => 'What is the main point of disagreement between the speakers?',
                'explanation' => 'The main disagreement is whether historical preservation should take precedence over new development needs.'
            ],
            [
                'lesson_id' => 5,
                'score' => 1.0,
                'content' => 'Audio: Medical lecture on public health',
                'question_text' => 'What preventive measure does the speaker emphasize most?',
                'explanation' => 'The speaker most emphasizes the importance of early vaccination programs for disease prevention.'
            ],
            [
                'lesson_id' => 5,
                'score' => 1.0,
                'content' => 'Audio: Travel documentary about Southeast Asia',
                'question_text' => 'What cultural tradition is described in detail?',
                'explanation' => 'The water festival celebrations and their cultural significance are described in detail.'
            ],
            [
                'lesson_id' => 5,
                'score' => 1.0,
                'content' => 'Audio: Technology conference keynote',
                'question_text' => 'What future technology does the speaker predict will have the biggest impact?',
                'explanation' => 'The speaker predicts that advancements in quantum computing will have the biggest impact in the next decade.'
            ],
            [
                'lesson_id' => 5,
                'score' => 1.0,
                'content' => 'Audio: Environmental conservation discussion',
                'question_text' => 'What ecosystem is the main focus of the conservation efforts discussed?',
                'explanation' => 'Rainforest preservation and biodiversity conservation are the main focus of the discussion.'
            ]
        ];

        // Thêm dữ liệu vào database
        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}