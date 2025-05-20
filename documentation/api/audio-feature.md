# Tài liệu API: Tính năng Audio cho Câu hỏi Listening

## Tổng quan

Các endpoints này cho phép bạn tải lên, truy xuất và phát các file âm thanh liên kết với các câu hỏi listening.

## Các API Endpoints cho Audio

### 1. Tải lên File Âm thanh cho Câu hỏi

Tải lên file âm thanh (MP3, WAV, hoặc OGG) cho một câu hỏi cụ thể. Lưu ý rằng câu hỏi phải thuộc một bài học với danh mục "Listening".

```http
POST /questions/{questionId}/audio
Authorization: Bearer your-jwt-token
Content-Type: multipart/form-data

Form Data:
  audio_file: [BINARY_FILE_DATA]
```

**Tham số:**

-   `questionId` (tham số đường dẫn): ID của câu hỏi để liên kết với file âm thanh

**Phản hồi (200 OK):**

```json
{
    "success": true,
    "message": "Tải lên file âm thanh thành công",
    "data": {
        "question_id": 13,
        "audio_file": "question_13_1747491234.mp3",
        "audio_url": "http://your-api-domain.com/api/v1/audio/file/question_13_1747491234.mp3",
        "urls": {
            "direct": "http://your-api-domain.com/storage/audios/question_13_1747491234.mp3",
            "api": "http://your-api-domain.com/api/v1/audio/file/question_13_1747491234.mp3",
            "question_api": "http://your-api-domain.com/api/v1/audio/question/13"
        }
    }
}
```

**Phản hồi lỗi:**

-   400: Định dạng file không hợp lệ hoặc câu hỏi không thuộc bài học danh mục Listening
-   404: Không tìm thấy câu hỏi
-   401: Không được phép (không có token JWT hợp lệ)

### 2. Phát Audio theo ID Câu hỏi

Phát file âm thanh liên kết với một câu hỏi cụ thể. Endpoint này không yêu cầu xác thực.

```http
GET /audio/question/{questionId}
```

**Tham số:**

-   `questionId` (tham số đường dẫn): ID của câu hỏi để lấy audio

**Phản hồi:**

-   File âm thanh được phát với MIME type phù hợp
-   Headers cho hỗ trợ CORS

**Phản hồi lỗi:**

-   404: Không tìm thấy câu hỏi hoặc không có file âm thanh liên kết

### 3. Phát Audio theo Tên File

Phát một file âm thanh cụ thể theo tên file. Endpoint này không yêu cầu xác thực.

```http
GET /audio/file/{filename}
```

**Tham số:**

-   `filename` (tham số đường dẫn): Tên của file âm thanh (ví dụ: question_13_1747491234.mp3)

**Phản hồi:**

-   File âm thanh được phát với MIME type phù hợp
-   Headers cho hỗ trợ CORS

**Phản hồi lỗi:**

-   404: Không tìm thấy file

### 4. Truy cập Trực tiếp File Âm thanh

Truy cập file âm thanh trực tiếp qua máy chủ web. Endpoint này không yêu cầu xác thực.

```http
GET /audio/{filename}
```

**Tham số:**

-   `filename` (tham số đường dẫn): Tên của file âm thanh (ví dụ: question_13_1747491234.mp3)

**Phản hồi:**

-   File âm thanh được phát với MIME type phù hợp
-   Headers cho hỗ trợ CORS

**Phản hồi lỗi:**

-   404: Không tìm thấy file

### 5. Lấy Chi tiết Câu hỏi kèm Audio

Truy xuất chi tiết câu hỏi bao gồm thông tin audio nếu có.

```http
GET /questions/{questionId}
Authorization: Bearer your-jwt-token
```

**Tham số:**

-   `questionId` (tham số đường dẫn): ID của câu hỏi cần truy xuất

**Phản hồi (200 OK):**

```json
{
    "success": true,
    "data": {
        "question_id": 13,
        "lesson_id": 3,
        "score": 2.5,
        "content": "Audio: Cuộc hội thoại tại nhà hàng",
        "question_text": "Khách hàng gọi món tráng miệng gì?",
        "explanation": "Khách hàng gọi bánh socola với kem sau khi cân nhắc bánh táo.",
        "audio_file": "question_13_1747491234.mp3",
        "audio_url": "http://your-api-domain.com/api/v1/audio/file/question_13_1747491234.mp3"
    }
}
```

**Phản hồi lỗi:**

-   404: Không tìm thấy câu hỏi
-   401: Không được phép (không có token JWT hợp lệ)

## Hướng dẫn Triển khai Frontend

### Phát Audio trong Frontend

#### Sử dụng HTML Audio Element

```html
<audio controls>
    <source
        src="http://your-api-domain.com/api/v1/audio/file/question_13_1747491234.mp3"
        type="audio/mpeg"
    />
    Trình duyệt của bạn không hỗ trợ phần tử audio.
</audio>
```

## Ví dụ React

```jsx
import React, { useState, useEffect } from "react";
import axios from "axios";

const AudioQuestion = ({ questionId }) => {
    const [question, setQuestion] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchQuestion = async () => {
            try {
                const token = localStorage.getItem("jwt_token");
                const response = await axios.get(
                    `http://your-api-domain.com/api/v1/questions/${questionId}`,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );

                setQuestion(response.data.data);
                setLoading(false);
            } catch (err) {
                setError("Không thể tải dữ liệu câu hỏi");
                setLoading(false);
            }
        };

        fetchQuestion();
    }, [questionId]);

    if (loading) return <div>Đang tải...</div>;
    if (error) return <div>{error}</div>;
    if (!question) return <div>Không tìm thấy câu hỏi</div>;

    return (
        <div className="audio-question">
            <h3>{question.question_text}</h3>
            <div className="content">{question.content}</div>

            {question.audio_url && (
                <div className="audio-player">
                    <audio controls>
                        <source src={question.audio_url} type="audio/mpeg" />
                        Trình duyệt của bạn không hỗ trợ phần tử audio.
                    </audio>
                </div>
            )}

            {/* Render các tùy chọn và các phần tử câu hỏi khác tại đây */}
        </div>
    );
};

export default AudioQuestion;
```

## Ghi chú Bổ sung

1. File âm thanh được lưu trong thư mục `storage/app/public/audios/`.
2. Hệ thống hỗ trợ định dạng âm thanh MP3, WAV và OGG.
3. Kích thước file tối đa cho phép là 10MB.
4. Để câu hỏi có audio, chúng phải thuộc các bài học với danh mục "Listening".
5. Header CORS được bao gồm trong phản hồi để cho phép phát audio xuyên miền.
6. Nhiều định dạng URL được cung cấp để truy cập file âm thanh, mang lại sự linh hoạt cho các kịch bản frontend khác nhau.

## Xử lý Sự cố

1. **Lỗi 403 Forbidden**: Đảm bảo symbolic link từ `storage/app/public` đến `public/storage` được thiết lập đúng và máy chủ web có đủ quyền truy cập.
2. **Lỗi 404 Not Found**: Kiểm tra xem file âm thanh có tồn tại ở đúng vị trí và câu hỏi có trường audio_file được thiết lập đúng hay không.
3. **Lỗi 401 Unauthorized**: Đảm bảo token JWT của bạn hợp lệ và được bao gồm trong header request.
