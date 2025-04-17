<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
     * @var array
     */
    protected $fillable = [
        'title',
        'category',
        'created_date',
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
     * @var array
     */
    public static $categories = ['Grammar', 'Vocabulary', 'Listening', 'Reading'];
}
