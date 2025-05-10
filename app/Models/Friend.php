<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friend extends Model
{
    use HasFactory;


    protected $table = 'friends';

    /**
     *
     * @var string
     */
    protected $primaryKey = 'friend_id';

    /**
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user1_id',
        'user2_id',
        'created_date',
    ];

    /**
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_date' => 'datetime',
    ];

    /**
     *
     * @return BelongsTo
     */
    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user1_id', 'user_id');
    }

    /**
     *
     * @return BelongsTo
     */
    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user2_id', 'user_id');
    }
}