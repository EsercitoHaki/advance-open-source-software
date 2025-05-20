<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    use HasFactory;

    protected $table = 'leaderboard';
    protected $primaryKey = 'leaderboard_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'rank',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
