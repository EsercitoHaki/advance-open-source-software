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
    
    private function addOptionsForLesson1(&$options)
    {
        // Question 1: What did the customer order?
        $options[] = ['question_id' => 1, 'option_text' => 'A small americano', 'is_correct' => false];
        $options[] = ['question_id' => 1, 'option_text' => 'A large cappuccino with an extra shot of espresso', 'is_correct' => true];
        $options[] = ['question_id' => 1, 'option_text' => 'A medium latte with vanilla syrup', 'is_correct' => false];
        $options[] = ['question_id' => 1, 'option_text' => 'A hot chocolate with whipped cream', 'is_correct' => false];
        
        // Question 2: What will the weather be like tomorrow?
        $options[] = ['question_id' => 2, 'option_text' => 'Rainy and cold', 'is_correct' => false];
        $options[] = ['question_id' => 2, 'option_text' => 'Sunny with a high of 25 degrees Celsius', 'is_correct' => true];
        $options[] = ['question_id' => 2, 'option_text' => 'Cloudy with a chance of showers', 'is_correct' => false];
        $options[] = ['question_id' => 2, 'option_text' => 'Windy with occasional snowfall', 'is_correct' => false];
        
        // Question 3: What platform is the train to London departing from?
        $options[] = ['question_id' => 3, 'option_text' => 'Platform 1', 'is_correct' => false];
        $options[] = ['question_id' => 3, 'option_text' => 'Platform 2', 'is_correct' => false];
        $options[] = ['question_id' => 3, 'option_text' => 'Platform 3', 'is_correct' => true];
        $options[] = ['question_id' => 3, 'option_text' => 'Platform 4', 'is_correct' => false];
        
        // Question 4: What time is the meeting scheduled for?
        $options[] = ['question_id' => 4, 'option_text' => '1:30 PM on Monday', 'is_correct' => false];
        $options[] = ['question_id' => 4, 'option_text' => '2:30 PM on Tuesday', 'is_correct' => true];
        $options[] = ['question_id' => 4, 'option_text' => '3:30 PM on Wednesday', 'is_correct' => false];
        $options[] = ['question_id' => 4, 'option_text' => '4:30 PM on Thursday', 'is_correct' => false];
        
        // Question 5: How many people is the reservation for?
        $options[] = ['question_id' => 5, 'option_text' => '2 people', 'is_correct' => false];
        $options[] = ['question_id' => 5, 'option_text' => '3 people', 'is_correct' => false];
        $options[] = ['question_id' => 5, 'option_text' => '4 people', 'is_correct' => true];
        $options[] = ['question_id' => 5, 'option_text' => '5 people', 'is_correct' => false];
        
        // Question 6: Why is the flight delayed?
        $options[] = ['question_id' => 6, 'option_text' => 'Technical issues with the aircraft', 'is_correct' => false];
        $options[] = ['question_id' => 6, 'option_text' => 'Bad weather conditions', 'is_correct' => true];
        $options[] = ['question_id' => 6, 'option_text' => 'Air traffic congestion', 'is_correct' => false];
        $options[] = ['question_id' => 6, 'option_text' => 'Crew scheduling problems', 'is_correct' => false];
        
        // Question 7: What does the doctor recommend?
        $options[] = ['question_id' => 7, 'option_text' => 'Taking the medication once daily before bed', 'is_correct' => false];
        $options[] = ['question_id' => 7, 'option_text' => 'Taking the medication twice daily with meals and getting plenty of rest', 'is_correct' => true];
        $options[] = ['question_id' => 7, 'option_text' => 'Only taking the medication when symptoms appear', 'is_correct' => false];
        $options[] = ['question_id' => 7, 'option_text' => 'Stopping all current medications immediately', 'is_correct' => false];
        
        // Question 8: What floor is the guest's room on?
        $options[] = ['question_id' => 8, 'option_text' => '3rd floor', 'is_correct' => false];
        $options[] = ['question_id' => 8, 'option_text' => '4th floor', 'is_correct' => false];
        $options[] = ['question_id' => 8, 'option_text' => '5th floor', 'is_correct' => true];
        $options[] = ['question_id' => 8, 'option_text' => '6th floor', 'is_correct' => false];
        
        // Question 9: How much did the customer pay?
        $options[] = ['question_id' => 9, 'option_text' => '$35.99', 'is_correct' => false];
        $options[] = ['question_id' => 9, 'option_text' => '$40.99', 'is_correct' => false];
        $options[] = ['question_id' => 9, 'option_text' => '$45.99', 'is_correct' => true];
        $options[] = ['question_id' => 9, 'option_text' => '$50.99', 'is_correct' => false];
        
        // Question 10: How far is the museum from the hotel?
        $options[] = ['question_id' => 10, 'option_text' => 'A 5-minute walk', 'is_correct' => false];
        $options[] = ['question_id' => 10, 'option_text' => 'A 10-minute walk', 'is_correct' => true];
        $options[] = ['question_id' => 10, 'option_text' => 'A 15-minute walk', 'is_correct' => false];
        $options[] = ['question_id' => 10, 'option_text' => 'A 20-minute walk', 'is_correct' => false];
    }
    
    private function addOptionsForLesson2(&$options)
    {
        // Question 11: What experience does the candidate highlight?
        $options[] = ['question_id' => 11, 'option_text' => 'Software development and coding', 'is_correct' => false];
        $options[] = ['question_id' => 11, 'option_text' => 'Customer service and client relations', 'is_correct' => false];
        $options[] = ['question_id' => 11, 'option_text' => 'Team management and project coordination', 'is_correct' => true];
        $options[] = ['question_id' => 11, 'option_text' => 'Marketing and sales strategies', 'is_correct' => false];
        
        // Question 12: What major event does the professor discuss?
        $options[] = ['question_id' => 12, 'option_text' => 'World War II', 'is_correct' => false];
        $options[] = ['question_id' => 12, 'option_text' => 'The Industrial Revolution', 'is_correct' => true];
        $options[] = ['question_id' => 12, 'option_text' => 'The French Revolution', 'is_correct' => false];
        $options[] = ['question_id' => 12, 'option_text' => 'The American Civil War', 'is_correct' => false];
        
        // Question 13: What is the main topic of the meeting?
        $options[] = ['question_id' => 13, 'option_text' => 'Budget cuts for the next fiscal year', 'is_correct' => false];
        $options[] = ['question_id' => 13, 'option_text' => 'The company\'s new marketing strategy', 'is_correct' => true];
        $options[] = ['question_id' => 13, 'option_text' => 'Employee performance reviews', 'is_correct' => false];
        $options[] = ['question_id' => 13, 'option_text' => 'Office relocation plans', 'is_correct' => false];
        
        // Question 14: What is the recommended activity for rainy days?
        $options[] = ['question_id' => 14, 'option_text' => 'Going to the beach', 'is_correct' => false];
        $options[] = ['question_id' => 14, 'option_text' => 'Hiking in the mountains', 'is_correct' => false];
        $options[] = ['question_id' => 14, 'option_text' => 'Visiting the city museum', 'is_correct' => true];
        $options[] = ['question_id' => 14, 'option_text' => 'Taking a boat tour', 'is_correct' => false];
        
        // Question 15: What is the customer's complaint?
        $options[] = ['question_id' => 15, 'option_text' => 'Product not delivered on time', 'is_correct' => false];
        $options[] = ['question_id' => 15, 'option_text' => 'Being charged twice for their subscription', 'is_correct' => true];
        $options[] = ['question_id' => 15, 'option_text' => 'Poor quality of the product', 'is_correct' => false];
        $options[] = ['question_id' => 15, 'option_text' => 'Rude customer service', 'is_correct' => false];
        
        // Question 16: What inspired the author to write the book?
        $options[] = ['question_id' => 16, 'option_text' => 'Their childhood memories', 'is_correct' => false];
        $options[] = ['question_id' => 16, 'option_text' => 'A historical event', 'is_correct' => false];
        $options[] = ['question_id' => 16, 'option_text' => 'Their travels through Southeast Asia', 'is_correct' => true];
        $options[] = ['question_id' => 16, 'option_text' => 'A conversation with a famous person', 'is_correct' => false];
        
        // Question 17: How long should the dish be baked?
        $options[] = ['question_id' => 17, 'option_text' => '25 minutes at 325 degrees', 'is_correct' => false];
        $options[] = ['question_id' => 17, 'option_text' => '30 minutes at 375 degrees', 'is_correct' => false];
        $options[] = ['question_id' => 17, 'option_text' => '35 minutes at 350 degrees', 'is_correct' => true];
        $options[] = ['question_id' => 17, 'option_text' => '40 minutes at 400 degrees', 'is_correct' => false];
        
        // Question 18: What aspect of the film does the reviewer praise the most?
        $options[] = ['question_id' => 18, 'option_text' => 'The acting performances', 'is_correct' => false];
        $options[] = ['question_id' => 18, 'option_text' => 'The plot and storyline', 'is_correct' => false];
        $options[] = ['question_id' => 18, 'option_text' => 'The cinematography and visual effects', 'is_correct' => true];
        $options[] = ['question_id' => 18, 'option_text' => 'The musical score', 'is_correct' => false];
        
        // Question 19: What new feature does the product offer?
        $options[] = ['question_id' => 19, 'option_text' => 'Extended battery life', 'is_correct' => false];
        $options[] = ['question_id' => 19, 'option_text' => 'AI-powered voice recognition', 'is_correct' => true];
        $options[] = ['question_id' => 19, 'option_text' => 'Water-resistant design', 'is_correct' => false];
        $options[] = ['question_id' => 19, 'option_text' => 'Improved camera resolution', 'is_correct' => false];
        
        // Question 20: What are they planning for the weekend?
        $options[] = ['question_id' => 20, 'option_text' => 'Going to a concert', 'is_correct' => false];
        $options[] = ['question_id' => 20, 'option_text' => 'Visiting relatives', 'is_correct' => false];
        $options[] = ['question_id' => 20, 'option_text' => 'A camping trip in the mountains', 'is_correct' => true];
        $options[] = ['question_id' => 20, 'option_text' => 'Staying home to watch movies', 'is_correct' => false];
    }
    
    private function addOptionsForLesson3(&$options)
    {
        // Question 21: What is the main topic of the passage?
        $options[] = ['question_id' => 21, 'option_text' => 'Deforestation and its economic benefits', 'is_correct' => false];
        $options[] = ['question_id' => 21, 'option_text' => 'The importance of protecting endangered species and their habitats', 'is_correct' => true];
        $options[] = ['question_id' => 21, 'option_text' => 'Agricultural development in conservation areas', 'is_correct' => false];
        $options[] = ['question_id' => 21, 'option_text' => 'The history of environmental activism', 'is_correct' => false];
        
        // Question 22: According to the text, what is the biggest challenge facing AI development?
        $options[] = ['question_id' => 22, 'option_text' => 'Lack of computing power', 'is_correct' => false];
        $options[] = ['question_id' => 22, 'option_text' => 'Ethical considerations and data privacy', 'is_correct' => true];
        $options[] = ['question_id' => 22, 'option_text' => 'Hardware limitations', 'is_correct' => false];
        $options[] = ['question_id' => 22, 'option_text' => 'Cost of implementation', 'is_correct' => false];
        
        // Question 23: What diet is recommended for heart health?
        $options[] = ['question_id' => 23, 'option_text' => 'Ketogenic diet', 'is_correct' => false];
        $options[] = ['question_id' => 23, 'option_text' => 'Paleo diet', 'is_correct' => false];
        $options[] = ['question_id' => 23, 'option_text' => 'Mediterranean diet', 'is_correct' => true];
        $options[] = ['question_id' => 23, 'option_text' => 'Vegan diet', 'is_correct' => false];
        
        // Question 24: What is the next major goal for space agencies according to the article?
        $options[] = ['question_id' => 24, 'option_text' => 'Sending humans to Mars', 'is_correct' => false];
        $options[] = ['question_id' => 24, 'option_text' => 'Establishing a permanent base on the Moon', 'is_correct' => true];
        $options[] = ['question_id' => 24, 'option_text' => 'Building a space elevator', 'is_correct' => false];
        $options[] = ['question_id' => 24, 'option_text' => 'Mining asteroids for resources', 'is_correct' => false];
        
        // Question 25: Which artist is credited with founding cubism?
        $options[] = ['question_id' => 25, 'option_text' => 'Salvador Dalí', 'is_correct' => false];
        $options[] = ['question_id' => 25, 'option_text' => 'Claude Monet', 'is_correct' => false];
        $options[] = ['question_id' => 25, 'option_text' => 'Pablo Picasso and Georges Braque', 'is_correct' => true];
        $options[] = ['question_id' => 25, 'option_text' => 'Vincent van Gogh', 'is_correct' => false];
        
        // Question 26: What solution does the article propose for traffic congestion?
        $options[] = ['question_id' => 26, 'option_text' => 'Building more highways', 'is_correct' => false];
        $options[] = ['question_id' => 26, 'option_text' => 'Expanding public transportation networks', 'is_correct' => true];
        $options[] = ['question_id' => 26, 'option_text' => 'Limiting car ownership', 'is_correct' => false];
        $options[] = ['question_id' => 26, 'option_text' => 'Implementing more toll roads', 'is_correct' => false];
        
        // Question 27: What literary device is prominently featured in the excerpt?
        $options[] = ['question_id' => 27, 'option_text' => 'Alliteration', 'is_correct' => false];
        $options[] = ['question_id' => 27, 'option_text' => 'Metaphor', 'is_correct' => true];
        $options[] = ['question_id' => 27, 'option_text' => 'Onomatopoeia', 'is_correct' => false];
        $options[] = ['question_id' => 27, 'option_text' => 'Hyperbole', 'is_correct' => false];
        
        // Question 28: What economic principle is being described?
        $options[] = ['question_id' => 28, 'option_text' => 'Inflation', 'is_correct' => false];
        $options[] = ['question_id' => 28, 'option_text' => 'Supply and demand', 'is_correct' => true];
        $options[] = ['question_id' => 28, 'option_text' => 'Diminishing returns', 'is_correct' => false];
        $options[] = ['question_id' => 28, 'option_text' => 'Opportunity cost', 'is_correct' => false];
        
        // Question 29: What was the main cause of the event according to the historian?
        $options[] = ['question_id' => 29, 'option_text' => 'Religious conflicts', 'is_correct' => false];
        $options[] = ['question_id' => 29, 'option_text' => 'Military aggression', 'is_correct' => false];
        $options[] = ['question_id' => 29, 'option_text' => 'Economic inequality', 'is_correct' => true];
        $options[] = ['question_id' => 29, 'option_text' => 'Political corruption', 'is_correct' => false];
        
        // Question 30: What theory does the psychologist propose?
        $options[] = ['question_id' => 30, 'option_text' => 'Cognitive dissonance reduction', 'is_correct' => false];
        $options[] = ['question_id' => 30, 'option_text' => 'Behavioral conditioning', 'is_correct' => false];
        $options[] = ['question_id' => 30, 'option_text' => 'Sleep patterns linked to cognitive performance and memory', 'is_correct' => true];
        $options[] = ['question_id' => 30, 'option_text' => 'Multiple intelligence theory', 'is_correct' => false];
    }
    
    private function addOptionsForLesson4(&$options)
    {
        // Question 31: What is causing coral bleaching according to the research?
        $options[] = ['question_id' => 31, 'option_text' => 'Ocean pollution from plastic waste', 'is_correct' => false];
        $options[] = ['question_id' => 31, 'option_text' => 'Rising ocean temperatures due to climate change', 'is_correct' => true];
        $options[] = ['question_id' => 31, 'option_text' => 'Overfishing in reef areas', 'is_correct' => false];
        $options[] = ['question_id' => 31, 'option_text' => 'Increased tourism in coral reef regions', 'is_correct' => false];
        
        // Question 32: What did the researchers discover about memory formation?
        $options[] = ['question_id' => 32, 'option_text' => 'Diet has the biggest impact on memory', 'is_correct' => false];
        $options[] = ['question_id' => 32, 'option_text' => 'Physical exercise is essential for memory formation', 'is_correct' => false];
        $options[] = ['question_id' => 32, 'option_text' => 'Sleep plays a crucial role in memory consolidation', 'is_correct' => true];
        $options[] = ['question_id' => 32, 'option_text' => 'Memory capacity is primarily determined by genetics', 'is_correct' => false];
        
        // Question 33: What conclusion does the study draw about solar power?
        $options[] = ['question_id' => 33, 'option_text' => 'It will never be as reliable as fossil fuels', 'is_correct' => false];
        $options[] = ['question_id' => 33, 'option_text' => 'It will become the most cost-effective energy source within a decade', 'is_correct' => true];
        $options[] = ['question_id' => 33, 'option_text' => 'Its environmental impact outweighs its benefits', 'is_correct' => false];
        $options[] = ['question_id' => 33, 'option_text' => 'It has reached its maximum potential efficiency', 'is_correct' => false];
        
        // Question 34: What evidence supports the cultural diffusion theory presented?
        $options[] = ['question_id' => 34, 'option_text' => 'Written records of cultural exchanges', 'is_correct' => false];
        $options[] = ['question_id' => 34, 'option_text' => 'Similar artifact designs found across geographically separated regions', 'is_correct' => true];
        $options[] = ['question_id' => 34, 'option_text' => 'DNA evidence from ancient remains', 'is_correct' => false];
        $options[] = ['question_id' => 34, 'option_text' => 'Linguistic similarities between ancient languages', 'is_correct' => false];
        
        // Question 35: What phenomenon does the article explain?
        $options[] = ['question_id' => 35, 'option_text' => 'The extinction of ancient languages', 'is_correct' => false];
        $options[] = ['question_id' => 35, 'option_text' => 'The standardization of global English', 'is_correct' => false];
        $options[] = ['question_id' => 35, 'option_text' => 'Language acquisition in multilingual environments', 'is_correct' => true];
        $options[] = ['question_id' => 35, 'option_text' => 'The development of writing systems', 'is_correct' => false];
        
        // Question 36: What correlation did the research identify?
        $options[] = ['question_id' => 36, 'option_text' => 'Urban population density and crime rates', 'is_correct' => false];
        $options[] = ['question_id' => 36, 'option_text' => 'Urban green spaces and reduced stress levels in residents', 'is_correct' => true];
        $options[] = ['question_id' => 36, 'option_text' => 'City size and economic prosperity', 'is_correct' => false];
        $options[] = ['question_id' => 36, 'option_text' => 'Urban pollution and respiratory disease', 'is_correct' => false];
        
        // Question 37: What principle is demonstrated by the experiment?
        $options[] = ['question_id' => 37, 'option_text' => 'Gravity', 'is_correct' => false];
        $options[] = ['question_id' => 37, 'option_text' => 'Quantum entanglement', 'is_correct' => true];
        $options[] = ['question_id' => 37, 'option_text' => 'Thermodynamics', 'is_correct' => false];
        $options[] = ['question_id' => 37, 'option_text' => 'Electromagnetism', 'is_correct' => false];
        
        // Question 38: What social trend does the study document?
        $options[] = ['question_id' => 38, 'option_text' => 'Declining voter turnout', 'is_correct' => false];
        $options[] = ['question_id' => 38, 'option_text' => 'Increasing influence of social media on political engagement among young adults', 'is_correct' => true];
        $options[] = ['question_id' => 38, 'option_text' => 'Rising distrust in government institutions', 'is_correct' => false];
        $options[] = ['question_id' => 38, 'option_text' => 'Shifts in traditional family structures', 'is_correct' => false];
        
        // Question 39: What prediction does the climate model make?
        $options[] = ['question_id' => 39, 'option_text' => 'Global cooling within the next century', 'is_correct' => false];
        $options[] = ['question_id' => 39, 'option_text' => 'More frequent extreme weather events in coastal regions', 'is_correct' => true];
        $options[] = ['question_id' => 39, 'option_text' => 'Stabilization of global temperatures', 'is_correct' => false];
        $options[] = ['question_id' => 39, 'option_text' => 'Increased rainfall in desert regions', 'is_correct' => false];
        
        // Question 40: What new dating technique revealed about the artifacts?
        $options[] = ['question_id' => 40, 'option_text' => 'They are newer than previously thought', 'is_correct' => false];
        $options[] = ['question_id' => 40, 'option_text' => 'They are approximately 2,000 years older than previously thought', 'is_correct' => true];
        $options[] = ['question_id' => 40, 'option_text' => 'They come from a different geographical region', 'is_correct' => false];
        $options[] = ['question_id' => 40, 'option_text' => 'They were made by a different civilization', 'is_correct' => false];
    }
    
    private function addOptionsForLesson5(&$options)
    {
        // Question 41: What economic theory does the professor primarily critique?
        $options[] = ['question_id' => 41, 'option_text' => 'Keynesian economics', 'is_correct' => false];
        $options[] = ['question_id' => 41, 'option_text' => 'Trickle-down economics', 'is_correct' => true];
        $options[] = ['question_id' => 41, 'option_text' => 'Monetarism', 'is_correct' => false];
        $options[] = ['question_id' => 41, 'option_text' => 'Modern Monetary Theory', 'is_correct' => false];
        
        // Question 42: What solution do most panelists agree on?
        $options[] = ['question_id' => 42, 'option_text' => 'Individual consumer choices are most important', 'is_correct' => false];
        $options[] = ['question_id' => 42, 'option_text' => 'International cooperation and carbon pricing', 'is_correct' => true];
        $options[] = ['question_id' => 42, 'option_text' => 'Technology alone will solve climate issues', 'is_correct' => false];
        $options[] = ['question_id' => 42, 'option_text' => 'National governments should act independently', 'is_correct' => false];
        
        // Question 43: What inspired the author's latest book?
        $options[] = ['question_id' => 43, 'option_text' => 'A historical figure they researched', 'is_correct' => false];
        $options[] = ['question_id' => 43, 'option_text' => 'Their childhood experiences in rural Ireland', 'is_correct' => true];
        $options[] = ['question_id' => 43, 'option_text' => 'A dream they had repeatedly', 'is_correct' => false];
        $options[] = ['question_id' => 43, 'option_text' => 'Current political events', 'is_correct' => false];
          // Question 44: What caused the empire's eventual decline?
        $options[] = ['question_id' => 44, 'option_text' => 'A single decisive military defeat', 'is_correct' => false];
        $options[] = ['question_id' => 44, 'option_text' => 'Economic problems, military overextension, and climate change', 'is_correct' => true];
        $options[] = ['question_id' => 44, 'option_text' => 'Rebellion of the conquered peoples', 'is_correct' => false];
        $options[] = ['question_id' => 44, 'option_text' => 'Succession crisis after the emperor\'s death', 'is_correct' => false];
        
        // Question 45: What recent discovery is discussed?
        $options[] = ['question_id' => 45, 'option_text' => 'A new planet in our solar system', 'is_correct' => false];
        $options[] = ['question_id' => 45, 'option_text' => 'Potentially habitable exoplanets in a nearby star system', 'is_correct' => true];
        $options[] = ['question_id' => 45, 'option_text' => 'Evidence of ancient life on Mars', 'is_correct' => false];
        $options[] = ['question_id' => 45, 'option_text' => 'A new type of black hole', 'is_correct' => false];
        
        // Question 46: What is the main point of disagreement between the speakers?
        $options[] = ['question_id' => 46, 'option_text' => 'Whether to increase taxes', 'is_correct' => false];
        $options[] = ['question_id' => 46, 'option_text' => 'Whether historical preservation should take precedence over new development', 'is_correct' => true];
        $options[] = ['question_id' => 46, 'option_text' => 'The role of public transportation', 'is_correct' => false];
        $options[] = ['question_id' => 46, 'option_text' => 'How to attract tourism', 'is_correct' => false];
        
        // Question 47: What preventive measure does the speaker emphasize most?
        $options[] = ['question_id' => 47, 'option_text' => 'Regular exercise', 'is_correct' => false];
        $options[] = ['question_id' => 47, 'option_text' => 'Early vaccination programs', 'is_correct' => true];
        $options[] = ['question_id' => 47, 'option_text' => 'Dietary changes', 'is_correct' => false];
        $options[] = ['question_id' => 47, 'option_text' => 'Mental health screenings', 'is_correct' => false];
        
        // Question 48: What cultural tradition is described in detail?
        $options[] = ['question_id' => 48, 'option_text' => 'Wedding ceremonies', 'is_correct' => false];
        $options[] = ['question_id' => 48, 'option_text' => 'Water festival celebrations', 'is_correct' => true];
        $options[] = ['question_id' => 48, 'option_text' => 'Harvest rituals', 'is_correct' => false];
        $options[] = ['question_id' => 48, 'option_text' => 'Funeral practices', 'is_correct' => false];
        
        // Question 49: What future technology does the speaker predict will have the biggest impact?
        $options[] = ['question_id' => 49, 'option_text' => 'Artificial intelligence', 'is_correct' => false];
        $options[] = ['question_id' => 49, 'option_text' => 'Quantum computing', 'is_correct' => true];
        $options[] = ['question_id' => 49, 'option_text' => 'Virtual reality', 'is_correct' => false];
        $options[] = ['question_id' => 49, 'option_text' => 'Biotechnology', 'is_correct' => false];
        
        // Question 50: What ecosystem is the main focus of the conservation efforts discussed?
        $options[] = ['question_id' => 50, 'option_text' => 'Coral reefs', 'is_correct' => false];
        $options[] = ['question_id' => 50, 'option_text' => 'Rainforests', 'is_correct' => true];
        $options[] = ['question_id' => 50, 'option_text' => 'Arctic tundra', 'is_correct' => false];
        $options[] = ['question_id' => 50, 'option_text' => 'Wetlands', 'is_correct' => false];
    }
}
