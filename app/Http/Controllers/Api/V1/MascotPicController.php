<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\MascotPicService;
use Illuminate\Http\Request;
use App\Exceptions\AppException;

class MascotPicController extends Controller
{
    protected $mascotPicService;

    public function __construct(MascotPicService $mascotPicService)
    {
        $this->mascotPicService = $mascotPicService;
    }

    public function getMascotPics($mascotId)
    {
        try {
            $pics = $this->mascotPicService->getMascotPics((int)$mascotId);

            return response()->json([
                'status' => 'success',
                'data' => $pics,
            ]);
        } catch (AppException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function getMainMascotPic($mascotId)
    {
        try {
            $pic = $this->mascotPicService->getMainMascotPic((int)$mascotId);

            return response()->json([
                'status' => 'success',
                'data' => $pic,
            ]);
        } catch (AppException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
