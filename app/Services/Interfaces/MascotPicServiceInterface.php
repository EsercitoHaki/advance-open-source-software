<?php

namespace App\Services\Interfaces;

use App\Repositories\Interfaces\MascotPicRepositoryInterface;
use App\DTOs\MascotPicDTO;

interface MascotPicServiceInterface
{
    public function getMascotPics(int $mascotId): array;
    public function getMainMascotPic(int $mascotId): MascotPicDTO;
}