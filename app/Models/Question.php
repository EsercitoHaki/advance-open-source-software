<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    /**
     * Chỉ định tên bảng trong cơ sở dữ liệu
     *
     * @var string
     */
    protected $table = 'questions';

    /**
     * Chỉ định khóa chính
     *
     * @var string
     */
    protected $primaryKey = 'question_id';

    /**
     * Chỉ định các cột có thể gán giá trị hàng loạt
     *
     * @var array
     */
    protected $fillable = [
        'lesson_id',
        'score',
        'content',
        'question_text',
        // đã loại bỏ correct_answer
        'explanation',
        'audio_file',
    ];

    /**
     * Chỉ định rằng model này không sử dụng timestamp mặc định
     *
     * @var bool
     */
    public $timestamps = false;
    public function options(): HasMany
    {
        return $this->hasMany(Option::class, 'question_id', 'question_id');
    }
    /**
     * Quan hệ với model Lesson
     *
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id', 'question_id');
    }
    /**
     * Quan hệ với model LESSON
     *
     * @return BelongsTo
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'lesson_id');
    }
/**
 * Kiểm tra xem câu hỏi có file âm thanh không
 *
 * @return bool
 */
public function hasAudio(): bool
{
    return !empty($this->audio_file);
}

/**
 * Lấy đường dẫn đầy đủ tới file âm thanh
 *
 * @return string|null
 */
public function getAudioUrl(): ?string
{
    if (!$this->hasAudio()) {
        return null;
    }
    
    return url('storage/audios/' . $this->audio_file);
}
}