<?php

namespace App\Repositories;

use App\Models\MascotPic;

class MascotPicRepository
{
    public function getMascotPics(int $mascotId)
    {
        return MascotPic::where('mascot_id', $mascotId)
            ->orderBy('pic_name', 'asc')
            ->get();
    }
    public function getMainMascotPic(int $mascotId)
    {
        return MascotPic::where('mascot_id', $mascotId)
            ->whereRaw("pic_name NOT REGEXP '_[0-9]+$'")
            ->orderBy('pic_name', 'asc')
            ->first();
    }
}