<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreItem extends Model
{
    protected $table = 'store_items';
    protected $primaryKey = 'item_id';
    public $timestamps = false; 

    protected $fillable = [
        'item_name',
        'item_type',
        'item_price',
        'mascot_pic',
        'lives_amount',
    ];
}
