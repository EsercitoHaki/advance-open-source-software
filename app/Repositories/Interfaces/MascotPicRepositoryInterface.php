<?php

namespace App\Repositories\Interfaces;

use App\Models\MascotPic;
use Illuminate\Support\Collection;

interface MascotPicRepositoryInterface
{
    public function getMascotPics(int $mascotId): Collection;
    public function getMainMascotPic(int $mascotId): ?MascotPic;
}