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
     * @var array
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
     * @var array
     */
    protected $casts = [
        'score' => 'float',
        'start_date' => 'datetime',
        'completion_date' => 'datetime',
    ];

    /**
     * Quan hệ với model User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Quan hệ với model Lesson
     *
     * @return BelongsTo
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'lesson_id');
    }
}