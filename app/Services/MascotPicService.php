<?php

namespace App\Services;

use App\Repositories\Interfaces\MascotPicRepositoryInterface;
use App\Repositories\MascotPicRepository;
use App\Services\Interfaces\MascotPicServiceInterface;
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
        
        $filteredPics = $mascotPics->filter(function ($pic) {
        $ext = strtolower(pathinfo($pic->filename ?? $pic->url ?? '', PATHINFO_EXTENSION));
            return in_array($ext, ['png', 'jpg', 'jpeg']);
        });

        if ($filteredPics->isEmpty()) {
            throw new AppException('Không có hình ảnh linh vật hợp lệ (PNG, JPG).');
        }
        
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

        $ext = strtolower(pathinfo($mainPic->filename ?? $mainPic->url ?? '', PATHINFO_EXTENSION));
        if (!in_array($ext, ['png', 'jpg', 'jpeg'])) {
            throw new AppException('Hình ảnh chính không ở định dạng PNG hoặc JPG.');
        }

        return MascotPicDTO::fromModel($mainPic);
    }
}