<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    /**
     * Chỉ định tên bảng trong cơ sở dữ liệu
     *
     * @var string
     */
    protected $table = 'user_progress';

    /**
     * Chỉ định khóa chính
     *
     * @var string
     */
    protected $primaryKey = 'progress_id';

    /**
     * Chỉ định các cột có thể gán giá trị hàng loạt
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'lesson_id',
        'completion_status',
        'score',
        'start_date',
        'completion_date'
    ];

    /**
     * Chỉ định rằng model này không sử dụng timestamp mặc định
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Các trường được xác định kiểu
     *
     * @var array<string, string>
     */
    protected $casts = [
        'score' => 'float',
        'start_date' => 'datetime',
        'completion_date' => 'datetime',
    ];

    /**
     * Các trạng thái hoàn thành hợp lệ
     * 
     * @var array<int, string>
     */
    public static $statuses = [
        'Not Started',
        'In Progress',
        'Completed'
    ];

    /**
     * Quan hệ với model User - một tiến độ thuộc về một người dùng
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Quan hệ với model Lesson - một tiến độ thuộc về một bài học
     *
     * @return BelongsTo
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'lesson_id');
    }

    /**
     * Kiểm tra xem bài học có đang được tiến hành không
     *
     * @return bool
     */
    public function isInProgress(): bool
    {
        return $this->completion_status === 'In Progress';
    }

    /**
     * Kiểm tra xem bài học có được hoàn thành không
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completion_status === 'Completed';
    }

    /**
     * Kiểm tra xem bài học có đạt điểm đậu không
     * 
     * @param float $passingScore Điểm đậu (mặc định là 70)
     * @return bool
     */
    public function isPassed(float $passingScore = 50.0): bool
    {
        return $this->isCompleted() && $this->score >= $passingScore;
    }

    /**
     * Lấy thời gian hoàn thành bài học (nếu đã hoàn thành)
     * 
     * @return int|null Thời gian hoàn thành tính bằng giây, null nếu chưa hoàn thành
     */
    public function getCompletionTime(): ?int
    {
        if (!$this->isCompleted() || !$this->completion_date || !$this->start_date) {
            return null;
        }

        return $this->completion_date->diffInSeconds($this->start_date);
    }

    /**
     * Lấy thời gian hoàn thành bài học dưới dạng chuỗi thân thiện 
     * 
     * @return string|null Chuỗi thời gian, null nếu chưa hoàn thành
     */
    public function getCompletionTimeFormatted(): ?string
    {
        $seconds = $this->getCompletionTime();
        if ($seconds === null) {
            return null;
        }

        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        return sprintf('%d phút %d giây', $minutes, $remainingSeconds);
    }
}