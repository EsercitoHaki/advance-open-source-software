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
            // Lesson 1: Part 5: Incomplete Sentences - Grammar and Vocabulary
            // Question 1
            [
                'question_id' => 1,
                'option_text' => 'assist',
                'is_correct' => false
            ],
            [
                'question_id' => 1,
                'option_text' => 'ensure',
                'is_correct' => true
            ],
            [
                'question_id' => 1,
                'option_text' => 'require',
                'is_correct' => false
            ],
            [
                'question_id' => 1,
                'option_text' => 'delay',
                'is_correct' => false
            ],
            // Question 2
            [
                'question_id' => 2,
                'option_text' => 'reduce',
                'is_correct' => false
            ],
            [
                'question_id' => 2,
                'option_text' => 'generate',
                'is_correct' => true
            ],
            [
                'question_id' => 2,
                'option_text' => 'expand',
                'is_correct' => false
            ],
            [
                'question_id' => 2,
                'option_text' => 'limit',
                'is_correct' => false
            ],
            // Question 3
            [
                'question_id' => 3,
                'option_text' => 'ignore',
                'is_correct' => false
            ],
            [
                'question_id' => 3,
                'option_text' => 'attend',
                'is_correct' => true
            ],
            [
                'question_id' => 3,
                'option_text' => 'cancel',
                'is_correct' => false
            ],
            [
                'question_id' => 3,
                'option_text' => 'postpone',
                'is_correct' => false
            ],
            // Question 4
            [
                'question_id' => 4,
                'option_text' => 'useful',
                'is_correct' => false
            ],
            [
                'question_id' => 4,
                'option_text' => 'crucial',
                'is_correct' => true
            ],
            [
                'question_id' => 4,
                'option_text' => 'similar',
                'is_correct' => false
            ],
            [
                'question_id' => 4,
                'option_text' => 'optional',
                'is_correct' => false
            ],
            // Question 5
            [
                'question_id' => 5,
                'option_text' => 'store',
                'is_correct' => false
            ],
            [
                'question_id' => 5,
                'option_text' => 'process',
                'is_correct' => true
            ],
            [
                'question_id' => 5,
                'option_text' => 'delete',
                'is_correct' => false
            ],
            [
                'question_id' => 5,
                'option_text' => 'review',
                'is_correct' => false
            ],

            // Lesson 2: Part 6: Text Completion - Business Contexts
            // Question 6
            [
                'question_id' => 6,
                'option_text' => 'reduce',
                'is_correct' => false
            ],
            [
                'question_id' => 6,
                'option_text' => 'increase',
                'is_correct' => true
            ],
            [
                'question_id' => 6,
                'option_text' => 'maintain',
                'is_correct' => false
            ],
            [
                'question_id' => 6,
                'option_text' => 'cancel',
                'is_correct' => false
            ],
            // Question 7
            [
                'question_id' => 7,
                'option_text' => 'closure',
                'is_correct' => false
            ],
            [
                'question_id' => 7,
                'option_text' => 'opening',
                'is_correct' => true
            ],
            [
                'question_id' => 7,
                'option_text' => 'relocation',
                'is_correct' => false
            ],
            [
                'question_id' => 7,
                'option_text' => 'expansion',
                'is_correct' => false
            ],
            // Question 8
            [
                'question_id' => 8,
                'option_text' => 'avoid',
                'is_correct' => false
            ],
            [
                'question_id' => 8,
                'option_text' => 'ensure',
                'is_correct' => true
            ],
            [
                'question_id' => 8,
                'option_text' => 'delay',
                'is_correct' => false
            ],
            [
                'question_id' => 8,
                'option_text' => 'request',
                'is_correct' => false
            ],
            // Question 9
            [
                'question_id' => 9,
                'option_text' => 'reducing',
                'is_correct' => false
            ],
            [
                'question_id' => 9,
                'option_text' => 'highlighting',
                'is_correct' => true
            ],
            [
                'question_id' => 9,
                'option_text' => 'ignoring',
                'is_correct' => false
            ],
            [
                'question_id' => 9,
                'option_text' => 'delaying',
                'is_correct' => false
            ],
            // Question 10
            [
                'question_id' => 10,
                'option_text' => 'offered',
                'is_correct' => false
            ],
            [
                'question_id' => 10,
                'option_text' => 'designed',
                'is_correct' => true
            ],
            [
                'question_id' => 10,
                'option_text' => 'required',
                'is_correct' => false
            ],
            [
                'question_id' => 10,
                'option_text' => 'canceled',
                'is_correct' => false
            ],

            // Lesson 3: Part 7: Reading Comprehension - Emails and Reports
            // Question 11
            [
                'question_id' => 11,
                'option_text' => 'To finalize the budget',
                'is_correct' => false
            ],
            [
                'question_id' => 11,
                'option_text' => 'To review the project timeline',
                'is_correct' => true
            ],
            [
                'question_id' => 11,
                'option_text' => 'To train new employees',
                'is_correct' => false
            ],
            [
                'question_id' => 11,
                'option_text' => 'To discuss marketing strategies',
                'is_correct' => false
            ],
            // Question 12
            [
                'question_id' => 12,
                'option_text' => 'New product launches',
                'is_correct' => false
            ],
            [
                'question_id' => 12,
                'option_text' => 'Strong demand in the Asian market',
                'is_correct' => true
            ],
            [
                'question_id' => 12,
                'option_text' => 'Improved shipping methods',
                'is_correct' => false
            ],
            [
                'question_id' => 12,
                'option_text' => 'Lower production costs',
                'is_correct' => false
            ],
            // Question 13
            [
                'question_id' => 13,
                'option_text' => 'March 10',
                'is_correct' => false
            ],
            [
                'question_id' => 13,
                'option_text' => 'March 15',
                'is_correct' => true
            ],
            [
                'question_id' => 13,
                'option_text' => 'April 10',
                'is_correct' => false
            ],
            [
                'question_id' => 13,
                'option_text' => 'April 12',
                'is_correct' => false
            ],
            // Question 14
            [
                'question_id' => 14,
                'option_text' => 'Higher salaries',
                'is_correct' => false
            ],
            [
                'question_id' => 14,
                'option_text' => 'More flexible hours',
                'is_correct' => true
            ],
            [
                'question_id' => 14,
                'option_text' => 'Better equipment',
                'is_correct' => false
            ],
            [
                'question_id' => 14,
                'option_text' => 'Additional vacation days',
                'is_correct' => false
            ],
            // Question 15
            [
                'question_id' => 15,
                'option_text' => 'Contact HR for support',
                'is_correct' => false
            ],
            [
                'question_id' => 15,
                'option_text' => 'Pack their belongings',
                'is_correct' => true
            ],
            [
                'question_id' => 15,
                'option_text' => 'Schedule a meeting',
                'is_correct' => false
            ],
            [
                'question_id' => 15,
                'option_text' => 'Update their schedules',
                'is_correct' => false
            ],

            // Lesson 4: Part 3: Conversations - Workplace Dialogues
            // Question 16
            [
                'question_id' => 16,
                'option_text' => 'Lack of staff',
                'is_correct' => false
            ],
            [
                'question_id' => 16,
                'option_text' => 'Unexpected technical issues',
                'is_correct' => true
            ],
            [
                'question_id' => 16,
                'option_text' => 'Client changes',
                'is_correct' => false
            ],
            [
                'question_id' => 16,
                'option_text' => 'Budget cuts',
                'is_correct' => false
            ],
            // Question 17
            [
                'question_id' => 17,
                'option_text' => 'New software training',
                'is_correct' => false
            ],
            [
                'question_id' => 17,
                'option_text' => 'Improving customer service skills',
                'is_correct' => true
            ],
            [
                'question_id' => 17,
                'option_text' => 'Team building exercises',
                'is_correct' => false
            ],
            [
                'question_id' => 17,
                'option_text' => 'Safety procedures',
                'is_correct' => false
            ],
            // Question 18
            [
                'question_id' => 18,
                'option_text' => 'Casual attire is acceptable daily',
                'is_correct' => false
            ],
            [
                'question_id' => 18,
                'option_text' => 'Business casual is required on weekdays',
                'is_correct' => true
            ],
            [
                'question_id' => 18,
                'option_text' => 'Formal attire is mandatory',
                'is_correct' => false
            ],
            [
                'question_id' => 18,
                'option_text' => 'No dress code exists',
                'is_correct' => false
            ],
            // Question 19
            [
                'question_id' => 19,
                'option_text' => 'Teenagers',
                'is_correct' => false
            ],
            [
                'question_id' => 19,
                'option_text' => 'Young professionals aged 25 to 35',
                'is_correct' => true
            ],
            [
                'question_id' => 19,
                'option_text' => 'Retirees',
                'is_correct' => false
            ],
            [
                'question_id' => 19,
                'option_text' => 'Families with children',
                'is_correct' => false
            ],
            // Question 20
            [
                'question_id' => 20,
                'option_text' => 'A product sample',
                'is_correct' => false
            ],
            [
                'question_id' => 20,
                'option_text' => 'A detailed proposal and cost estimate',
                'is_correct' => true
            ],
            [
                'question_id' => 20,
                'option_text' => 'A meeting schedule',
                'is_correct' => false
            ],
            [
                'question_id' => 20,
                'option_text' => 'A discount offer',
                'is_correct' => false
            ],

            // Lesson 5: Part 4: Talks - Announcements and Presentations
            // Question 21
            [
                'question_id' => 21,
                'option_text' => 'Bad weather',
                'is_correct' => false
            ],
            [
                'question_id' => 21,
                'option_text' => 'Routine maintenance checks',
                'is_correct' => true
            ],
            [
                'question_id' => 21,
                'option_text' => 'Staff shortages',
                'is_correct' => false
            ],
            [
                'question_id' => 21,
                'option_text' => 'A security issue',
                'is_correct' => false
            ],
            // Question 22
            [
                'question_id' => 22,
                'option_text' => 'Increase employee salaries',
                'is_correct' => false
            ],
            [
                'question_id' => 22,
                'option_text' => 'Expand into two new international markets',
                'is_correct' => true
            ],
            [
                'question_id' => 22,
                'option_text' => 'Launch a new product line',
                'is_correct' => false
            ],
            [
                'question_id' => 22,
                'option_text' => 'Reduce operational costs',
                'is_correct' => false
            ],
            // Question 23
            [
                'question_id' => 23,
                'option_text' => 'Furniture and appliances',
                'is_correct' => false
            ],
            [
                'question_id' => 23,
                'option_text' => 'Electronics and clothing',
                'is_correct' => true
            ],
            [
                'question_id' => 23,
                'option_text' => 'Books and stationery',
                'is_correct' => false
            ],
            [
                'question_id' => 23,
                'option_text' => 'Toys and games',
                'is_correct' => false
            ],
            // Question 24
            [
                'question_id' => 24,
                'option_text' => 'Hiring more staff',
                'is_correct' => false
            ],
            [
                'question_id' => 24,
                'option_text' => 'Regular safety drills and updated equipment checks',
                'is_correct' => true
            ],
            [
                'question_id' => 24,
                'option_text' => 'Reducing work hours',
                'is_correct' => false
            ],
            [
                'question_id' => 24,
                'option_text' => 'Installing security cameras',
                'is_correct' => false
            ],
            // Question 25
            [
                'question_id' => 25,
                'option_text' => 'Two hours',
                'is_correct' => false
            ],
            [
                'question_id' => 25,
                'option_text' => 'Three hours',
                'is_correct' => true
            ],
            [
                'question_id' => 25,
                'option_text' => 'Four hours',
                'is_correct' => false
            ],
            [
                'question_id' => 25,
                'option_text' => 'Five hours',
                'is_correct' => false
            ],
            // Lesson 6: Part 1: Photographs - Describing Images
            // Question 1
            [
                'question_id' => 26,
                'option_text' => 'A restaurant',
                'is_correct' => false
            ],
            [
                'question_id' => 26,
                'option_text' => 'An office',
                'is_correct' => true
            ],
            [
                'question_id' => 26,
                'option_text' => 'A park',
                'is_correct' => false
            ],
            [
                'question_id' => 26,
                'option_text' => 'A classroom',
                'is_correct' => false
            ],
            // Question 2
            [
                'question_id' => 27,
                'option_text' => 'Reading a book',
                'is_correct' => false
            ],
            [
                'question_id' => 27,
                'option_text' => 'Giving a presentation',
                'is_correct' => true
            ],
            [
                'question_id' => 27,
                'option_text' => 'Typing on a computer',
                'is_correct' => false
            ],
            [
                'question_id' => 27,
                'option_text' => 'Taking a break',
                'is_correct' => false
            ],
            // Question 3
            [
                'question_id' => 28,
                'option_text' => 'Glasses',
                'is_correct' => false
            ],
            [
                'question_id' => 28,
                'option_text' => 'Helmets',
                'is_correct' => true
            ],
            [
                'question_id' => 28,
                'option_text' => 'Suits',
                'is_correct' => false
            ],
            [
                'question_id' => 28,
                'option_text' => 'Gloves',
                'is_correct' => false
            ],
            // Lesson 7: Part 2: Question-Response - Daily Scenarios
            // Question 4
            [
                'question_id' => 29,
                'option_text' => 'It’s a long trip.',
                'is_correct' => false
            ],
            [
                'question_id' => 29,
                'option_text' => 'It leaves at 3 PM.',
                'is_correct' => true
            ],
            [
                'question_id' => 29,
                'option_text' => 'I’m driving there.',
                'is_correct' => false
            ],
            [
                'question_id' => 29,
                'option_text' => 'The station is closed.',
                'is_correct' => false
            ],
            // Question 5
            [
                'question_id' => 30,
                'option_text' => 'It’s a new car.',
                'is_correct' => false
            ],
            [
                'question_id' => 30,
                'option_text' => 'There’s a parking lot behind the building.',
                'is_correct' => true
            ],
            [
                'question_id' => 30,
                'option_text' => 'The car is blue.',
                'is_correct' => false
            ],
            [
                'question_id' => 30,
                'option_text' => 'Parking is not allowed.',
                'is_correct' => false
            ],
            // Question 6
            [
                'question_id' => 31,
                'option_text' => 'It’s in Room 5.',
                'is_correct' => false
            ],
            [
                'question_id' => 31,
                'option_text' => 'About an hour.',
                'is_correct' => true
            ],
            [
                'question_id' => 31,
                'option_text' => 'The manager is leading it.',
                'is_correct' => false
            ],
            [
                'question_id' => 31,
                'option_text' => 'It’s canceled.',
                'is_correct' => false
            ],
            // Lesson 8: Part 5: Incomplete Sentences - Advanced Grammar
            // Question 1
            [
                'question_id' => 32,
                'option_text' => 'ignore',
                'is_correct' => false
            ],
            [
                'question_id' => 32,
                'option_text' => 'meet',
                'is_correct' => true
            ],
            [
                'question_id' => 32,
                'option_text' => 'delay',
                'is_correct' => false
            ],
            [
                'question_id' => 32,
                'option_text' => 'cancel',
                'is_correct' => false
            ],
            // Question 2
            [
                'question_id' => 33,
                'option_text' => 'ignored',
                'is_correct' => false
            ],
            [
                'question_id' => 33,
                'option_text' => 'implemented',
                'is_correct' => true
            ],
            [
                'question_id' => 33,
                'option_text' => 'delayed',
                'is_correct' => false
            ],
            [
                'question_id' => 33,
                'option_text' => 'canceled',
                'is_correct' => false
            ],
            // Question 3
            [
                'question_id' => 34,
                'option_text' => 'confusing',
                'is_correct' => false
            ],
            [
                'question_id' => 34,
                'option_text' => 'clear',
                'is_correct' => true
            ],
            [
                'question_id' => 34,
                'option_text' => 'boring',
                'is_correct' => false
            ],
            [
                'question_id' => 34,
                'option_text' => 'long',
                'is_correct' => false
            ],

            // Lesson 9: Part 6: Text Completion - Technical Reports
            // Question 4
            [
                'question_id' => 35,
                'option_text' => 'reduce',
                'is_correct' => false
            ],
            [
                'question_id' => 35,
                'option_text' => 'boost',
                'is_correct' => true
            ],
            [
                'question_id' => 35,
                'option_text' => 'maintain',
                'is_correct' => false
            ],
            [
                'question_id' => 35,
                'option_text' => 'stop',
                'is_correct' => false
            ],
            // Question 5
            [
                'question_id' => 36,
                'option_text' => 'ignoring the issue',
                'is_correct' => false
            ],
            [
                'question_id' => 36,
                'option_text' => 'working diligently',
                'is_correct' => true
            ],
            [
                'question_id' => 36,
                'option_text' => 'delaying the fix',
                'is_correct' => false
            ],
            [
                'question_id' => 36,
                'option_text' => 'outsourcing the task',
                'is_correct' => false
            ],
            // Question 6
            [
                'question_id' => 37,
                'option_text' => 'delay',
                'is_correct' => false
            ],
            [
                'question_id' => 37,
                'option_text' => 'ensure',
                'is_correct' => true
            ],
            [
                'question_id' => 37,
                'option_text' => 'cancel',
                'is_correct' => false
            ],
            [
                'question_id' => 37,
                'option_text' => 'pause',
                'is_correct' => false
            ],

            // Lesson 10: Part 7: Reading Comprehension - Advertisements
            // Question 7
            [
                'question_id' => 38,
                'option_text' => 'A waterproof case',
                'is_correct' => false
            ],
            [
                'question_id' => 38,
                'option_text' => 'A 48MP camera and 5G support',
                'is_correct' => true
            ],
            [
                'question_id' => 38,
                'option_text' => 'A free charger',
                'is_correct' => false
            ],
            [
                'question_id' => 38,
                'option_text' => 'A larger screen',
                'is_correct' => false
            ],
            // Question 8
            [
                'question_id' => 39,
                'option_text' => 'May 1 to May 15',
                'is_correct' => false
            ],
            [
                'question_id' => 39,
                'option_text' => 'June 1 to June 15',
                'is_correct' => true
            ],
            [
                'question_id' => 39,
                'option_text' => 'June 15 to June 30',
                'is_correct' => false
            ],
            [
                'question_id' => 39,
                'option_text' => 'July 1 to July 15',
                'is_correct' => false
            ],
            // Question 9
            [
                'question_id' => 40,
                'option_text' => 'A free gym bag',
                'is_correct' => false
            ],
            [
                'question_id' => 40,
                'option_text' => 'A 20% discount on the first month',
                'is_correct' => true
            ],
            [
                'question_id' => 40,
                'option_text' => 'A personal trainer',
                'is_correct' => false
            ],
            [
                'question_id' => 40,
                'option_text' => 'Free parking',
                'is_correct' => false
            ],

            // Lesson 11: Part 3: Conversations - Customer Service Scenarios
            // Question 10
            [
                'question_id' => 41,
                'option_text' => 'The customer’s address',
                'is_correct' => false
            ],
            [
                'question_id' => 41,
                'option_text' => 'The order number',
                'is_correct' => true
            ],
            [
                'question_id' => 41,
                'option_text' => 'The payment method',
                'is_correct' => false
            ],
            [
                'question_id' => 41,
                'option_text' => 'The delivery date',
                'is_correct' => false
            ],
            // Question 11
            [
                'question_id' => 42,
                'option_text' => 'Call the manager',
                'is_correct' => false
            ],
            [
                'question_id' => 42,
                'option_text' => 'Bring the product and receipt to the store',
                'is_correct' => true
            ],
            [
                'question_id' => 42,
                'option_text' => 'Send an email complaint',
                'is_correct' => false
            ],
            [
                'question_id' => 42,
                'option_text' => 'Wait for a refund',
                'is_correct' => false
            ],
            // Question 12
            [
                'question_id' => 43,
                'option_text' => 'Red',
                'is_correct' => false
            ],
            [
                'question_id' => 43,
                'option_text' => 'Blue',
                'is_correct' => true
            ],
            [
                'question_id' => 43,
                'option_text' => 'Green',
                'is_correct' => false
            ],
            [
                'question_id' => 43,
                'option_text' => 'Black',
                'is_correct' => false
            ],
            // Lesson 12: Part 5: Incomplete Sentences - Professional Terms
    // Question 1
    [
        'question_id' => 44,
        'option_text' => 'response',
        'is_correct' => false
    ],
    [
        'question_id' => 44,
        'option_text' => 'commitment',
        'is_correct' => true
    ],
    [
        'question_id' => 44,
        'option_text' => 'delay',
        'is_correct' => false
    ],
    [
        'question_id' => 44,
        'option_text' => 'request',
        'is_correct' => false
    ],
    // Question 2
    [
        'question_id' => 45,
        'option_text' => 'summary',
        'is_correct' => false
    ],
    [
        'question_id' => 45,
        'option_text' => 'analysis',
        'is_correct' => true
    ],
    [
        'question_id' => 45,
        'option_text' => 'prediction',
        'is_correct' => false
    ],
    [
        'question_id' => 45,
        'option_text' => 'proposal',
        'is_correct' => false
    ],
    // Question 3
    [
        'question_id' => 46,
        'option_text' => 'complicate',
        'is_correct' => false
    ],
    [
        'question_id' => 46,
        'option_text' => 'streamline',
        'is_correct' => true
    ],
    [
        'question_id' => 46,
        'option_text' => 'cancel',
        'is_correct' => false
    ],
    [
        'question_id' => 46,
        'option_text' => 'ignore',
        'is_correct' => false
    ],

    // Lesson 13: Part 6: Text Completion - Project Proposals
    // Question 4
    [
        'question_id' => 47,
        'option_text' => 'reduce',
        'is_correct' => false
    ],
    [
        'question_id' => 47,
        'option_text' => 'enhance',
        'is_correct' => true
    ],
    [
        'question_id' => 47,
        'option_text' => 'limit',
        'is_correct' => false
    ],
    [
        'question_id' => 47,
        'option_text' => 'remove',
        'is_correct' => false
    ],
    // Question 5
    [
        'question_id' => 48,
        'option_text' => 'minor',
        'is_correct' => false
    ],
    [
        'question_id' => 48,
        'option_text' => 'significant',
        'is_correct' => true
    ],
    [
        'question_id' => 48,
        'option_text' => 'temporary',
        'is_correct' => false
    ],
    [
        'question_id' => 48,
        'option_text' => 'slow',
        'is_correct' => false
    ],
    // Question 6
    [
        'question_id' => 49,
        'option_text' => 'delay',
        'is_correct' => false
    ],
    [
        'question_id' => 49,
        'option_text' => 'execute',
        'is_correct' => true
    ],
    [
        'question_id' => 49,
        'option_text' => 'cancel',
        'is_correct' => false
    ],
    [
        'question_id' => 49,
        'option_text' => 'pause',
        'is_correct' => false
    ],

    // Lesson 14: Part 7: Reading Comprehension - News Articles
    // Question 7
    [
        'question_id' => 50,
        'option_text' => 'A new factory',
        'is_correct' => false
    ],
    [
        'question_id' => 50,
        'option_text' => 'An AI tool for data analysis',
        'is_correct' => true
    ],
    [
        'question_id' => 50,
        'option_text' => 'A smartphone app',
        'is_correct' => false
    ],
    [
        'question_id' => 50,
        'option_text' => 'A training program',
        'is_correct' => false
    ],
    // Question 8
    [
        'question_id' => 51,
        'option_text' => 'To promote fitness',
        'is_correct' => false
    ],
    [
        'question_id' => 51,
        'option_text' => 'To raise funds for charities',
        'is_correct' => true
    ],
    [
        'question_id' => 51,
        'option_text' => 'To attract tourists',
        'is_correct' => false
    ],
    [
        'question_id' => 51,
        'option_text' => 'To test new routes',
        'is_correct' => false
    ],
    // Question 9
    [
        'question_id' => 52,
        'option_text' => '500',
        'is_correct' => false
    ],
    [
        'question_id' => 52,
        'option_text' => '1,000',
        'is_correct' => true
    ],
    [
        'question_id' => 52,
        'option_text' => '2,000',
        'is_correct' => false
    ],
    [
        'question_id' => 52,
        'option_text' => '5,000',
        'is_correct' => false
    ],

    // Lesson 15: Part 4: Talks - Conference Speeches
    // Question 10
    [
        'question_id' => 53,
        'option_text' => 'Artificial intelligence',
        'is_correct' => false
    ],
    [
        'question_id' => 53,
        'option_text' => 'Innovations in renewable energy',
        'is_correct' => true
    ],
    [
        'question_id' => 53,
        'option_text' => 'Customer service strategies',
        'is_correct' => false
    ],
    [
        'question_id' => 53,
        'option_text' => 'Marketing trends',
        'is_correct' => false
    ],
    // Question 11
    [
        'question_id' => 54,
        'option_text' => 'May 1, 2025',
        'is_correct' => false
    ],
    [
        'question_id' => 54,
        'option_text' => 'June 1, 2025',
        'is_correct' => true
    ],
    [
        'question_id' => 54,
        'option_text' => 'July 1, 2025',
        'is_correct' => false
    ],
    [
        'question_id' => 54,
        'option_text' => 'August 1, 2025',
        'is_correct' => false
    ],
    // Question 12
    [
        'question_id' => 55,
        'option_text' => 'Cost reduction',
        'is_correct' => false
    ],
    [
        'question_id' => 55,
        'option_text' => 'Customer feedback',
        'is_correct' => true
    ],
    [
        'question_id' => 55,
        'option_text' => 'Employee training',
        'is_correct' => false
    ],
    [
        'question_id' => 55,
        'option_text' => 'Product development',
        'is_correct' => false
    ],
        ];

        // Thêm dữ liệu vào database
        foreach ($options as $option) {
            Option::create($option);
        }
    }
}