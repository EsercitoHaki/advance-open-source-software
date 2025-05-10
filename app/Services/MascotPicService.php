<?php

namespace App\Services;

use App\Repositories\MascotPicRepository;
use App\Exceptions\AppException;    
use Illuminate\Support\Facades\Auth;

class MascotPicService
{
    protected $mascotPicRepository;

    public function __construct(MascotPicRepository $mascotPicRepository)
    {
        $this->mascotPicRepository = $mascotPicRepository;
    }

    public function getMascotPics(int $mascotId)
    {
        $mascotPics = $this->mascotPicRepository->getMascotPics($mascotId);
        if ($mascotPics->isEmpty()) {
            throw new AppException('Hình ảnh linh vật không tồn tại.');
        }
        
        return $mascotPics;
    }
    
    public function getMainMascotPic(int $mascotId)
    {
        $mascotPic = $this->mascotPicRepository->getMainMascotPic($mascotId);
        
        if (!$mascotPic) {
            throw new AppException('Không tìm thấy hình ảnh chính cho linh vật này.');
        }

        return $mascotPic;
    }


}