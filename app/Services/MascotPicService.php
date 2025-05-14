<?php

namespace App\Services;

use App\Repositories\MascotPicRepositoryInterface;
use App\Repositories\MascotPicRepository;
use App\Exceptions\AppException;
use App\DTOs\MascotPicDTO;
use App\Models\MascotPic;

class MascotPicService implements MascotPicServiceInterface
{
    protected $mascotPicRepository;

    public function __construct(MascotPicRepository $mascotPicRepository)
    {
        $this->mascotPicRepository = $mascotPicRepository;
    }

    public function getMascotPics(int $mascotId): array
    {
        $mascotPics = $this->mascotPicRepository->getMascotPics($mascotId);
        if ($mascotPics->isEmpty()) {
            throw new AppException('Hình ảnh linh vật không tồn tại.');
        }

        return $mascotPics->map(fn($mascotpic) => MascotPicDTO::fromModel($mascotpic))->toArray();
    }

    public function getMainMascotPic(int $mascotId): MascotPicDTO
    {
        $mainPic = $this->mascotPicRepository->getMainMascotPic($mascotId);
        if (!$mainPic) {
            throw new AppException('Hình ảnh chính của linh vật không tồn tại.');
        }

        return MascotPicDTO::fromModel($mainPic);
    }
}
