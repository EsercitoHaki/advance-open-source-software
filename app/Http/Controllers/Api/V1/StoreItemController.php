<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\StoreItemService;
use App\Exceptions\AppException;
use Illuminate\Http\Request;

class StoreItemController extends Controller
{
    protected $storeItemService;

    public function __construct(StoreItemService $storeItemService)
    {
        $this->storeItemService = $storeItemService;
    }

    public function getStoreItems()
    {
        try {
            $user = Auth::user(); 

            $items = $this->storeItemService->getAllItems();

            return response()->json([
                'status' => 'success',
                'data' => $items
            ], 200);

        } catch (AppException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
