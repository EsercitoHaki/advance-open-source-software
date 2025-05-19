<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $table = 'missions';
    protected $primaryKey = 'mission_id';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'reward_coins',
        'required_action',
        'required_count',
        'is_active',
    ];
}
