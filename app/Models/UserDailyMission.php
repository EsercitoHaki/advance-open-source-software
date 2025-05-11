<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDailyMission extends Model
{
    protected $primaryKey = 'user_mission_id';
    protected $fillable = [
        'user_id', 
        'mission_id', 
        'date', 
        'progress', 
        'is_completed', 
        'reward_claimed'
    ];
    
    public $timestamps = false;

    public function mission()
    {
        return $this->belongsTo(Mission::class, 'mission_id', 'mission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}