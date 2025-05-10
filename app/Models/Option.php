<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Option extends Model
{
    /**
     * Chỉ định tên bảng trong cơ sở dữ liệu
     *
     * @var string
     */
    protected $table = 'options';

    /**
     * Chỉ định khóa chính
     *
     * @var string
     */
    protected $primaryKey = 'option_id';

    /**
     * Chỉ định các cột có thể gán giá trị hàng loạt
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
    ];

    /**
     * Chỉ định rằng model này không sử dụng timestamp mặc định
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Quan hệ với model Question
     *
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id', 'question_id');
    }
}