<?php

namespace App\Services;

use App\Repositories\MascotPicRepositoryInterface;
use App\DTOs\MascotPicDTO;

interface MascotPicServiceInterface
{
    public function getMascotPics(int $mascotId): array;
    public function getMainMascotPic(int $mascotId): MascotPicDTO;
}