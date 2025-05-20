<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDailyMission extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'user_mission_id';

    protected $fillable = [
        'user_id',
        'mission_id',
        'date',
        'progress',
        'is_completed',
        'reward_claimed'
    ];

    protected $casts = [
        'date' => 'date',
        'is_completed' => 'boolean',
        'reward_claimed' => 'boolean'
    ];

    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class, 'mission_id', 'mission_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}