# Hệ thống Streak - Tài liệu tham khảo

## 1. Tổng quan về hệ thống Streak

Hệ thống Streak là tính năng theo dõi và khuyến khích người dùng học tập liên tục mỗi ngày. Streak đại diện cho số ngày liên tiếp mà người dùng đã hoàn thành ít nhất một bài học.

### Các thành phần chính:

-   `current_streak`: Số ngày liên tiếp hiện tại người dùng đã hoàn thành bài học
-   `longest_streak`: Chuỗi ngày liên tiếp dài nhất người dùng đạt được

## 2. Flow hoạt động của hệ thống

```
┌────────────────┐
│                │
│  Hoàn thành    │
│  bài học       │
│                │
└───────┬────────┘
        │
        ▼
┌────────────────┐
│                │       ┌────────────────┐
│  Kiểm tra      │  Có   │                │
│  đã học        ├──────►│  Trả về        │
│  hôm nay chưa? │       │ streak hiện tại│
│                │       │                │
└───────┬────────┘       └────────────────┘
        │ Không
        ▼
┌────────────────┐
│                │       ┌────────────────┐
│  Kiểm tra      │  Có   │                │
│  đã học        ├──────►│ current_streak │
│  hôm qua?      │       │  += 1          │
│                │       │                │
└───────┬────────┘       └────────────────┘
        │ Không
        ▼
┌────────────────┐
│                │
│ current_streak │
│  = 0           │
│                │
└───────┬────────┘
        │
        ▼
┌────────────────┐
│                │       ┌────────────────┐
│  current >     │  Có   │                │
│  longest?      ├──────►│ longest_streak │
│                │       │= current_streak│
└───────┬────────┘       │                │
        │ Không          └────────────────┘
        ▼
┌────────────────┐
│                │
│  Lưu streak    │
│  vào DB & cache│
│                │
└────────────────┘
```

## 3. Quy tắc tính Streak

1. **Bắt đầu streak**: Khi người dùng hoàn thành bài học đầu tiên, streak = 1
2. **Tăng streak**: Streak tăng thêm 1 nếu người dùng hoàn thành bài học trong ngày tiếp theo
3. **Đặt lại streak**: Streak về 0 nếu người dùng bỏ lỡ một hoặc nhiều ngày không học
4. **Bảo toàn streak**: Mỗi ngày chỉ cần hoàn thành 1 bài học để duy trì streak
5. **Giới hạn**: Mỗi ngày streak chỉ tăng tối đa 1, dù học nhiều bài

## 4. Cơ chế Backend

### StreakService

Service chính xử lý logic streak:

-   `updateStreak()`: Cập nhật streak khi hoàn thành bài học
-   `checkAndResetStreaks()`: Reset streak cho người dùng không hoạt động

### Cache Keys sử dụng

-   `user_{userId}_last_lesson_date`: Lưu ngày cuối cùng người dùng hoàn thành bài học
-   Cache hết hạn vào cuối ngày để đảm bảo tính chính xác

### Cơ chế Reset tự động

Mỗi ngày, hệ thống sẽ tự động kiểm tra và đặt lại streak cho người dùng không hoạt động thông qua lệnh `app:check-streaks`.

## 5. API Response

### Ví dụ response khi hoàn thành bài học:

```json
{
  "total_score": 85,
  "max_score": 100,
  "passed": true,
  "question_results": [...],
  "progress_status": "Completed",
  "streak_info": {
    "current_streak": 3,
    "longest_streak": 5,
    "streak_updated": true,
    "message": "Tuyệt vời! Bạn đã giữ được streak liên tục trong 3 ngày!"
  }
}
```

### Ví dụ response từ endpoint thống kê:

```json
{
    "coins": 100,
    "lives": 5,
    "current_streak": 3,
    "longest_streak": 5,
    "learning_progress": {
        "completed_lessons": 10,
        "mastered_words": 50,
        "total_lessons": 30,
        "average_score": 80
    }
}
```

## 6. Hướng dẫn sử dụng cho Frontend

### Hiển thị Streak

1. Hiển thị `current_streak` ở profile, dashboard hoặc header
2. Tạo biểu tượng trực quan (lửa, biểu đồ) để thể hiện streak
3. Hiển thị `message` từ response khi streak được cập nhật

### Thông báo

1. Hiển thị thông báo khi streak tăng
2. Cảnh báo khi người dùng sắp mất streak (chưa học trong ngày)
3. Khuyến khích người dùng học bài để tiếp tục streak

### Phần thưởng (đề xuất)

1. Tích hợp thưởng coins cho các milestone streak (7, 30, 100 ngày)
2. Hiển thị huy hiệu/thành tích khi đạt được streak dài

## 7. Lệnh kiểm tra thủ công

Để kiểm tra và reset streak thủ công:

```bash
php artisan app:check-streaks
```

---

_Tài liệu này dành cho team Frontend và Backend để hiểu về cách triển khai và hiển thị hệ thống streak._
