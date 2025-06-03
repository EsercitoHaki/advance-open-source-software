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
            // Lesson 1: Part 5: Incomplete Sentences - Grammar and Vocabulary
            [
                'lesson_id' => 1,
                'question_text' => "The team worked hard to ______ the product launch would be on schedule.\nChoose the word that best completes the sentence.",
                'explanation' => 'Từ đúng là "ensure", có nghĩa là đảm bảo rằng điều gì đó sẽ xảy ra. Trong ngữ cảnh này, nhóm đang nỗ lực để đảm bảo việc ra mắt sản phẩm diễn ra đúng lịch.'
            ],
            [
                'lesson_id' => 1,
                'question_text' => "The company was able to ______ a significant profit despite economic challenges.\nChoose the word that best completes the sentence.",
                'explanation' => 'Từ đúng là "generate", có nghĩa là tạo ra hoặc sản xuất. Nó phù hợp với ngữ cảnh đạt được lợi nhuận bất chấp những thách thức kinh tế.'
            ],
            [
                'lesson_id' => 1,
                'question_text' => "All employees are required to ______ the training session next week.\nChoose the word that best completes the sentence.",
                'explanation' => 'Từ đúng là "attend", có nghĩa là tham dự một sự kiện hoặc buổi học, chẳng hạn như một chương trình đào tạo.'
            ],
            [
                'lesson_id' => 1,
                'question_text' => "Effective communication is ______ to the success of this project.\nChoose the word that best completes the sentence.",
                'explanation' => 'Từ đúng là "crucial", có nghĩa là cực kỳ quan trọng hoặc thiết yếu, phù hợp với ngữ cảnh thành công của dự án.'
            ],
            [
                'lesson_id' => 1,
                'question_text' => "The new software will help us ______ customer data more efficiently.\nChoose the word that best completes the sentence.",
                'explanation' => 'Từ đúng là "process", có nghĩa là xử lý hoặc quản lý dữ liệu, phù hợp với chức năng của phần mềm.'
            ],

            // Lesson 2: Part 6: Text Completion - Business Contexts
            [
                'lesson_id' => 2,
                'question_text' => "Due to rising demand, the factory will ______ production capacity next quarter.\nChoose the word or phrase that best completes the memo.",
                'explanation' => 'Cụm từ đúng là "increase", vì ngữ cảnh mô tả việc mở rộng năng lực sản xuất để đáp ứng nhu cầu.'
            ],
            [
                'lesson_id' => 2,
                'question_text' => "We are excited to announce the ______ of our new branch office in Singapore next month.\nChoose the word or phrase that best completes the email.",
                'explanation' => 'Từ đúng là "opening", phù hợp với ngữ cảnh thông báo về việc khai trương chi nhánh mới.'
            ],
            [
                'lesson_id' => 2,
                'question_text' => "Please submit expense reports by Friday to ______ timely reimbursement.\nChoose the word or phrase that best completes the notice.",
                'explanation' => 'Cụm từ đúng là "ensure", có nghĩa là đảm bảo việc hoàn trả đúng hạn bằng cách đáp ứng thời hạn.'
            ],
            [
                'lesson_id' => 2,
                'question_text' => "The report focuses on profit growth, ______ the need for a new marketing strategy.\nChoose the word or phrase that best completes the report.",
                'explanation' => 'Cụm từ đúng là "highlighting", vì nó nhấn mạnh nhu cầu về một chiến lược tiếp thị mới dựa trên tăng trưởng lợi nhuận.'
            ],
            [
                'lesson_id' => 2,
                'question_text' => "Our new training program is ______ to improve management skills for all supervisors.\nChoose the word or phrase that best completes the advertisement.",
                'explanation' => 'Từ đúng là "designed", có nghĩa là được tạo ra hoặc dành sẵn cho một mục đích cụ thể, chẳng hạn như cải thiện kỹ năng.'
            ],

            // Lesson 3: Part 7: Reading Comprehension - Emails and Reports
            [
                'lesson_id' => 3,
                'question_text' => "Subject: Project Update Meeting\nDear Team,\nWe have scheduled a meeting for April 20 at 2 PM to address the client’s request. The focus will be on the project timeline and resource allocation.\nWhat is the purpose of the meeting mentioned in the email?",
                'explanation' => 'Email nêu rõ cuộc họp nhằm xem xét tiến độ dự án, theo yêu cầu của khách hàng.'
            ],
            [
                'lesson_id' => 3,
                'question_text' => "Annual Sales Report 2024\nOur company saw a 15% increase in sales this year. This growth was largely due to strong demand in the Asian market, particularly in China and Japan.\nWhat was the main reason for the sales increase in 2024?",
                'explanation' => 'Báo cáo chỉ ra rằng nhu cầu mạnh mẽ ở thị trường châu Á là lý do chính cho sự gia tăng doanh số.'
            ],
            [
                'lesson_id' => 3,
                'question_text' => "Subject: Conference Registration\nDear Staff,\nPlease complete your registration for the annual conference by March 15. Late submissions will not be accepted.\nWhat is the deadline for conference registration?",
                'explanation' => 'Email nêu rõ thời hạn đăng ký hội nghị là ngày 15 tháng 3.'
            ],
            [
                'lesson_id' => 3,
                'question_text' => "Employee Survey Results\nOur recent survey showed that 60% of employees requested more flexible hours, while 25% asked for better equipment and 15% wanted additional vacation days.\nWhat did 60% of employees request according to the survey?",
                'explanation' => 'Báo cáo nêu rằng 60% nhân viên yêu cầu giờ làm linh hoạt hơn.'
            ],
            [
                'lesson_id' => 3,
                'question_text' => "Subject: Office Relocation\nDear Employees,\nWe are moving to a new office on June 1. Please pack your belongings by May 30 to ensure a smooth transition.\nWhat should employees do by May 30?",
                'explanation' => 'Email hướng dẫn nhân viên đóng gói đồ đạc trước ngày 30 tháng 5 để chuẩn bị cho việc di dời.'
            ],

            // Lesson 4: Part 3: Conversations - Workplace Dialogues
            [
                'lesson_id' => 4,
                'question_text' => "Employee: I’m concerned the project might not meet the deadline.\nManager: Why is that?\nEmployee: We’ve run into unexpected technical issues with the software.\nWhy does the employee say the project might be delayed?",
                'explanation' => 'Nhân viên đề cập rằng các vấn đề kỹ thuật bất ngờ là lý do cho khả năng dự án bị trì hoãn.'
            ],
            [
                'lesson_id' => 4,
                'question_text' => "Colleague A: Are you attending the training session tomorrow?\nColleague B: Yes, I think it’ll be useful. It’s focused on improving customer service skills.\nWhat is the main topic of the training session discussed?",
                'explanation' => 'Các đồng nghiệp thảo luận về một buổi đào tạo tập trung vào việc cải thiện kỹ năng dịch vụ khách hàng.'
            ],
            [
                'lesson_id' => 4,
                'question_text' => "Supervisor: Just a reminder about the dress code.\nEmployee: Could you clarify that?\nSupervisor: Business casual is required on weekdays, but Fridays are casual.\nWhat does the supervisor say about the dress code?",
                'explanation' => 'Người giám sát giải thích rằng trang phục công sở bình thường được yêu cầu vào các ngày trong tuần.'
            ],
            [
                'lesson_id' => 4,
                'question_text' => "Team Member A: Who are we targeting with this campaign?\nTeam Member B: We’re focusing on young professionals aged 25 to 35 for maximum impact.\nWhat is the target audience for the campaign?",
                'explanation' => 'Các thành viên trong nhóm đề cập rằng chiến dịch nhắm đến các chuyên gia trẻ tuổi từ 25 đến 35.'
            ],
            [
                'lesson_id' => 4,
                'question_text' => "Client: We need more details before we proceed.\nSales Rep: I understand. I’ll provide a detailed proposal and a cost estimate by the end of the week.\nWhat does the client request from the sales representative?",
                'explanation' => 'Khách hàng yêu cầu một đề xuất chi tiết và dự toán chi phí trước cuối tuần.'
            ],

            // Lesson 5: Part 4: Talks - Announcements and Presentations
            [
                'lesson_id' => 5,
                'question_text' => "Announcement: Attention passengers, the flight to Tokyo, originally scheduled for 3 PM, has been delayed. We are conducting routine maintenance checks to ensure your safety.\nWhy has the flight to Tokyo been delayed?",
                'explanation' => 'Thông báo nêu rằng chuyến bay đến Tokyo bị hoãn do các kiểm tra bảo trì định kỳ.'
            ],
            [
                'lesson_id' => 5,
                'question_text' => "CEO: Good morning, team. Next year, our focus will be to expand into two new international markets to boost our global presence.\nWhat is the company’s goal for the next year according to the CEO?",
                'explanation' => 'Giám đốc điều hành nêu rằng mục tiêu là mở rộng vào hai thị trường quốc tế mới trong năm tới.'
            ],
            [
                'lesson_id' => 5,
                'question_text' => "Store Announcement: Welcome, shoppers! Today, we’re offering discounts up to 30% on electronics and clothing. Don’t miss out!\nWhat items are on sale according to the announcement?",
                'explanation' => 'Thông báo đề cập rằng đồ điện tử và quần áo đang được giảm giá lên đến 30%.'
            ],
            [
                'lesson_id' => 5,
                'question_text' => "Speaker: Safety is our priority. I recommend regular safety drills and updated equipment checks to keep our workplace secure.\nWhat does the speaker recommend for improving safety?",
                'explanation' => 'Diễn giả đề xuất các cuộc diễn tập an toàn định kỳ và kiểm tra thiết bị cập nhật.'
            ],
            [
                'lesson_id' => 5,
                'question_text' => "Tour Guide: Welcome to our city tour! We’ll explore key landmarks over approximately three hours, with a short break midway.\nHow long does the city tour last according to the guide?",
                'explanation' => 'Hướng dẫn viên du lịch nêu rằng chuyến tham quan thành phố kéo dài khoảng ba giờ.'
            ],
            // Lesson 6: Part 1: Photographs - Describing Images
            [
                'lesson_id' => 6,
                'question_text' => "The photograph shows a busy office. Several people are working at desks with computers.\nWhat is the setting of the photograph?",
                'explanation' => 'Ảnh mô tả một văn phòng bận rộn với nhiều người làm việc tại bàn với máy tính, do đó bối cảnh là một văn phòng.'
            ],
            [
                'lesson_id' => 6,
                'question_text' => "In the image, a woman is giving a presentation to a group in a meeting room.\nWhat is the woman doing in the photograph?",
                'explanation' => 'Ảnh cho thấy một phụ nữ đang thuyết trình cho một nhóm, vì vậy hành động của cô ấy là thuyết trình.'
            ],
            [
                'lesson_id' => 6,
                'question_text' => "The picture depicts a construction site with workers wearing helmets and operating machinery.\nWhat are the workers wearing in the image?",
                'explanation' => 'Ảnh miêu tả một công trường với công nhân đội mũ bảo hộ, do đó họ đang đội mũ bảo hộ.'
            ],
            // Lesson 7: Part 2: Question-Response - Daily Scenarios
            [
                'lesson_id' => 7,
                'question_text' => "Question: When does the next train to Hanoi depart?\nResponse: (A) It leaves at 3 PM. (B) I’m driving there. (C) It’s a long trip.\nWhich response best answers the question?",
                'explanation' => 'Câu trả lời đúng là "It leaves at 3 PM" vì nó trực tiếp trả lời câu hỏi về thời gian khởi hành của tàu.'
            ],
            [
                'lesson_id' => 7,
                'question_text' => "Question: Where can I park my car?\nResponse: (A) It’s a new car. (B) There’s a parking lot behind the building. (C) The car is blue.\nWhich response best answers the question?",
                'explanation' => 'Câu trả lời đúng là "There’s a parking lot behind the building" vì nó cung cấp thông tin về nơi đỗ xe.'
            ],
            [
                'lesson_id' => 7,
                'question_text' => "Question: How long does the meeting last?\nResponse: (A) It’s in Room 5. (B) About an hour. (C) The manager is leading it.\nWhich response best answers the question?",
                'explanation' => 'Câu trả lời đúng là "About an hour" vì nó trả lời trực tiếp về thời gian kéo dài của cuộc họp.'
            ],
            // Lesson 8: Part 5: Incomplete Sentences - Advanced Grammar
            [
                'lesson_id' => 8,
                'question_text' => "Despite the delay, the manager insisted that the team ______ the original deadline.\nChoose the word that best completes the sentence.",
                'explanation' => 'Từ đúng là "meet", có nghĩa là đáp ứng hoặc tuân thủ. Trong ngữ cảnh này, người quản lý muốn đội hoàn thành đúng hạn mặc dù bị trì hoãn.'
            ],
            [
                'lesson_id' => 8,
                'question_text' => "The new policy, if ______ correctly, will improve workplace efficiency.\nChoose the word that best completes the sentence.",
                'explanation' => 'Từ đúng là "implemented", có nghĩa là được thực thi hoặc áp dụng, phù hợp với ngữ cảnh cải thiện hiệu quả công việc.'
            ],
            [
                'lesson_id' => 8,
                'question_text' => "Her presentation was so ______ that everyone understood the complex topic.\nChoose the word that best completes the sentence.",
                'explanation' => 'Từ đúng là "clear", có nghĩa là rõ ràng, phù hợp để mô tả một bài thuyết trình dễ hiểu.'
            ],

            // Lesson 9: Part 6: Text Completion - Technical Reports
            [
                'lesson_id' => 9,
                'question_text' => "The system upgrade will ______ data processing speeds by 20% next year.\nChoose the word or phrase that best completes the report.",
                'explanation' => 'Cụm từ đúng là "boost", có nghĩa là tăng cường, phù hợp với ngữ cảnh cải thiện tốc độ xử lý dữ liệu.'
            ],
            [
                'lesson_id' => 9,
                'question_text' => "Our engineers are ______ to address software bugs reported last month.\nChoose the word or phrase that best completes the update.",
                'explanation' => 'Cụm từ đúng là "working diligently", có nghĩa là làm việc chăm chỉ, phù hợp với nỗ lực sửa lỗi phần mềm.'
            ],
            [
                'lesson_id' => 9,
                'question_text' => "The project requires additional funding to ______ completion by December.\nChoose the word or phrase that best completes the proposal.",
                'explanation' => 'Cụm từ đúng là "ensure", có nghĩa là đảm bảo, phù hợp với mục tiêu hoàn thành dự án đúng hạn.'
            ],

            // Lesson 10: Part 7: Reading Comprehension - Advertisements
            [
                'lesson_id' => 10,
                'question_text' => "New Product Launch: Discover our latest smartphone! Available from May 1, it offers a 48MP camera and 5G support for only $599.\nWhat feature does the new smartphone include?",
                'explanation' => 'Quảng cáo nêu rõ điện thoại mới có camera 48MP và hỗ trợ 5G, do đó đáp án là tính năng này.'
            ],
            [
                'lesson_id' => 10,
                'question_text' => "Summer Sale: Buy one shirt, get one free! Offer valid from June 1 to June 15 at all our stores.\nWhat is the duration of the summer sale?",
                'explanation' => 'Quảng cáo cho biết chương trình giảm giá diễn ra từ ngày 1 đến ngày 15 tháng 6.'
            ],
            [
                'lesson_id' => 10,
                'question_text' => "Join Our Gym Today! Sign up by April 30 and get a 20% discount on your first month’s membership.\nWhat is the benefit of signing up by April 30?",
                'explanation' => 'Quảng cáo nêu rằng đăng ký trước ngày 30 tháng 4 sẽ được giảm 20% cho tháng đầu tiên.'
            ],

            // Lesson 11: Part 3: Conversations - Customer Service Scenarios
            [
                'lesson_id' => 11,
                'question_text' => "Customer: My order hasn’t arrived yet.\nAgent: I apologize. May I have your order number to check the status?\nWhat does the agent ask for?",
                'explanation' => 'Đại diện yêu cầu số đơn hàng để kiểm tra trạng thái giao hàng.'
            ],
            [
                'lesson_id' => 11,
                'question_text' => "Customer: Can you replace this defective product?\nStaff: Certainly! Please bring it to our store with the receipt.\nWhat does the staff instruct the customer to do?",
                'explanation' => 'Nhân viên hướng dẫn khách hàng mang sản phẩm lỗi và biên lai đến cửa hàng.'
            ],
            [
                'lesson_id' => 11,
                'question_text' => "Customer: Is this item available in blue?\nClerk: Yes, we have it in stock. Would you like me to get it for you?\nWhat color does the customer ask about?",
                'explanation' => 'Khách hàng hỏi về sản phẩm có màu xanh dương.'
            ],
            // Lesson 12: Part 5: Incomplete Sentences - Professional Terms
            [
                'lesson_id' => 12,
                'question_text' => "The company’s ______ to environmental standards earned it a sustainability award.\nChoose the word that best completes the sentence.",
                'explanation' => 'Từ đúng là "commitment", có nghĩa là cam kết, phù hợp với ngữ cảnh công ty tuân thủ tiêu chuẩn môi trường để nhận giải.'
            ],
            [
                'lesson_id' => 12,
                'question_text' => "The consultant provided a detailed ______ of the market trends for the next quarter.\nChoose the word that best completes the sentence.",
                'explanation' => 'Từ đúng là "analysis", có nghĩa là phân tích, phù hợp với việc tư vấn về xu hướng thị trường.'
            ],
            [
                'lesson_id' => 12,
                'question_text' => "To improve productivity, the manager decided to ______ the workflow process.\nChoose the word that best completes the sentence.",
                'explanation' => 'Từ đúng là "streamline", có nghĩa là tối ưu hóa hoặc đơn giản hóa, phù hợp với mục tiêu cải thiện năng suất.'
            ],

            // Lesson 13: Part 6: Text Completion - Project Proposals
            [
                'lesson_id' => 13,
                'question_text' => "This proposal outlines a plan to ______ our online presence through social media.\nChoose the word or phrase that best completes the proposal.",
                'explanation' => 'Cụm từ đúng là "enhance", có nghĩa là nâng cao, phù hợp với kế hoạch cải thiện sự hiện diện trực tuyến.'
            ],
            [
                'lesson_id' => 13,
                'question_text' => "We anticipate a ______ increase in revenue if the project is approved.\nChoose the word or phrase that best completes the proposal.",
                'explanation' => 'Cụm từ đúng là "significant", có nghĩa là đáng kể, phù hợp với dự đoán về tăng trưởng doanh thu.'
            ],
            [
                'lesson_id' => 13,
                'question_text' => "Our team is prepared to ______ the project within the proposed timeline.\nChoose the word or phrase that best completes the proposal.",
                'explanation' => 'Cụm từ đúng là "execute", có nghĩa là thực hiện, phù hợp với việc hoàn thành dự án theo thời gian đề xuất.'
            ],

            // Lesson 14: Part 7: Reading Comprehension - News Articles
            [
                'lesson_id' => 14,
                'question_text' => "Tech Giant Unveils New AI Tool\nOn April 25, 2025, a leading tech company launched an AI tool to assist with data analysis, promising faster results for businesses.\nWhat did the tech company launch on April 25, 2025?",
                'explanation' => 'Bài báo nêu rằng công ty công nghệ đã ra mắt một công cụ AI để hỗ trợ phân tích dữ liệu vào ngày 25 tháng 4 năm 2025.'
            ],
            [
                'lesson_id' => 14,
                'question_text' => "City to Host Annual Marathon\nThe marathon, set for May 10, 2025, expects over 5,000 runners and will raise funds for local charities.\nWhat is the purpose of the marathon mentioned in the article?",
                'explanation' => 'Bài báo cho biết cuộc đua marathon nhằm gây quỹ cho các tổ chức từ thiện địa phương.'
            ],
            [
                'lesson_id' => 14,
                'question_text' => "New Factory Opens in the Region\nA car manufacturer opened a factory on May 1, 2025, creating 1,000 new jobs for the local community.\nHow many jobs did the new factory create?",
                'explanation' => 'Bài báo đề cập rằng nhà máy mới đã tạo ra 1.000 việc làm cho cộng đồng địa phương.'
            ],

            // Lesson 15: Part 4: Talks - Conference Speeches
            [
                'lesson_id' => 15,
                'question_text' => "Speaker: Welcome to the 2025 Tech Conference! Today, we’ll discuss innovations in renewable energy to combat climate change.\nWhat is the main topic of the 2025 Tech Conference according to the speaker?",
                'explanation' => 'Diễn giả nêu rằng hội nghị sẽ thảo luận về các đổi mới trong năng lượng tái tạo để chống biến đổi khí hậu.'
            ],
            [
                'lesson_id' => 15,
                'question_text' => "Presenter: Our new app streamlines team collaboration. It’s available for download starting June 1, 2025.\nWhen will the new app be available for download?",
                'explanation' => 'Diễn giả cho randint ứng mới sẽ có sẵn để tải xuống từ ngày 1 tháng 6 năm 2025.'
            ],
            [
                'lesson_id' => 15,
                'question_text' => "Keynote Speaker: To succeed, businesses must prioritize customer feedback and adapt quickly to market changes.\nWhat does the speaker say businesses must prioritize?",
                'explanation' => 'Diễn giả nhấn mạnh rằng các doanh nghiệp phải ưu tiên phản hồi từ khách hàng để thành công.'
            ],
        ];

        // Thêm dữ liệu vào database
        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}