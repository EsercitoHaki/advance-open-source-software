<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MascotPic extends Model
{
    protected $table = 'mascot_pics';
    protected $primaryKey = 'pic_id';
    public $timestamps = false; 

    protected $fillable = [
        'mascot_id',
        'pic_name',
        'pic_url',
    ];
}
