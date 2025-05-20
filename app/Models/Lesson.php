<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    /**
     * Chỉ định tên bảng trong cơ sở dữ liệu
     *
     * @var string
     */
    protected $table = 'lessons';

    /**
     * Chỉ định khóa chính
     *
     * @var string
     */
    protected $primaryKey = 'lesson_id';

    /**
     * Chỉ định các cột có thể gán giá trị hàng loạt
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'category',
        'created_date',
        'time_limit',
    ];

    /**
     * Chỉ định rằng model này không sử dụng timestamp mặc định
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Các giá trị category hợp lệ
     *
     * @var array<int, string>
     */
    public static $categories = ['Grammar', 'Vocabulary', 'Listening', 'Reading'];

    /**
     * Định dạng các kiểu dữ liệu cho các cột
     * 
     * @var array<string, string>
     */
    protected $casts = [
        'created_date' => 'datetime',
    ];

    /**
     * Quan hệ với model Question - một bài học có nhiều câu hỏi
     *
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'lesson_id', 'lesson_id');
    }

    /**
     * Kiểm tra xem danh mục có hợp lệ không
     *
     * @param string $category
     * @return bool
     */
    public static function isValidCategory(string $category): bool
    {
        return in_array($category, self::$categories);
    }

    /**
     * Lấy danh sách các danh mục bài học
     * 
     * @return array<int, string>
     */
    public static function getCategories(): array
    {
        return self::$categories;
    }
}
