<?php

namespace App\Repositories;

use App\Models\MascotPic;
use Illuminate\Support\Collection;
use App\Repositories\MascotPicRepositoryInterface;

class MascotPicRepository implements MascotPicRepositoryInterface
{
    public function getMascotPics(int $mascotId): Collection
    {
        return MascotPic::where('mascot_id', $mascotId)
            ->orderBy('pic_name', 'asc')
            ->get();
    }
    public function getMainMascotPic(int $mascotId): ?MascotPic
    {
        return MascotPic::where('mascot_id', $mascotId)
            ->whereRaw("pic_name NOT REGEXP '_[0-9]+$'")
            ->orderBy('pic_name', 'asc')
            ->first();
    }
}