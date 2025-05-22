<?php
namespace App\Http\Controllers\Api\V1;


use App\DTOs\OptionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOptionsRequest;
use App\Http\Requests\OptionRequest;
use App\Services\Interfaces\OptionServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    protected $optionService;

    public function __construct(OptionServiceInterface $optionService)
    {
        $this->optionService = $optionService;
    }

    /**
     * Lấy danh sách options của một câu hỏi
     *
     * @param int $questionId
     * @return JsonResponse
     */
    public function getByQuestionId(int $questionId): JsonResponse
    {
        $options = $this->optionService->getOptionsByQuestionId($questionId);

        return response()->json([
            'status' => 'success',
            'data' => $options
        ]);
    }

    /**
     * Tạo một option mới
     *
     * @param OptionRequest $request
     * @return JsonResponse
     */
    public function create(OptionRequest $request): JsonResponse
    {
        $optionData = $request->validated();
        $option = $this->optionService->createOption($optionData);

        return response()->json([
            'status' => 'success',
            'message' => 'Option created successfully',
            'data' => $option
        ], 201);
    }

    /**
     * Cập nhật một option
     *
     * @param OptionRequest $request
     * @param int $optionId
     * @return JsonResponse
     */
    public function update(OptionRequest $request, int $optionId): JsonResponse
    {
        $optionData = $request->validated();
        $option = $this->optionService->updateOption($optionId, $optionData);

        return response()->json([
            'status' => 'success',
            'message' => 'Option updated successfully',
            'data' => $option
        ]);
    }

    /**
     * Xóa một option
     *
     * @param int $optionId
     * @return JsonResponse
     */
    public function delete(int $optionId): JsonResponse
    {
        $deleted = $this->optionService->deleteOption($optionId);

        return response()->json([
            'status' => 'success',
            'message' => 'Option deleted successfully'
        ]);
    }

    /**
     * Tạo nhiều options cho một câu hỏi
     *
     * @param CreateOptionsRequest $request
     * @param int $questionId
     * @return JsonResponse
     */
    public function createOptionsForQuestion(CreateOptionsRequest $request, int $questionId): JsonResponse
    {
        $optionsData = $request->validated()['options'];
        $options = $this->optionService->createOptionsForQuestion($questionId, $optionsData);

        return response()->json([
            'status' => 'success',
            'message' => count($options) . ' options created successfully',
            'data' => $options
        ], 201);
    }
}