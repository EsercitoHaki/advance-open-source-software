<?php

namespace App\Services;

use App\Models\Option;
use App\Repositories\OptionRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OptionService implements OptionServiceInterface
{
    /**
     * @var OptionRepositoryInterface
     */
    protected $optionRepository;

    /**
     * OptionService constructor.
     *
     * @param OptionRepositoryInterface $optionRepository
     */
    public function __construct(OptionRepositoryInterface $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    /**
     * Lấy tất cả các options cho một câu hỏi cụ thể
     *
     * @param int $questionId
     * @return Collection
     */
    public function getOptionsByQuestionId(int $questionId): Collection
    {
        return $this->optionRepository->getOptionsByQuestionId($questionId);
    }

    /**
     * Tạo một option mới
     *
     * @param array $data
     * @return Option
     */
    public function createOption(array $data): Option
    {
        return $this->optionRepository->createOption($data);
    }

    /**
     * Cập nhật thông tin option
     *
     * @param int $optionId
     * @param array $data
     * @return Option
     */
    public function updateOption(int $optionId, array $data): Option
    {
        return $this->optionRepository->updateOption($optionId, $data);
    }

    /**
     * Xóa một option
     *
     * @param int $optionId
     * @return bool
     */
    public function deleteOption(int $optionId): bool
    {
        return $this->optionRepository->deleteOption($optionId);
    }

    /**
     * Tạo nhiều option cùng lúc cho một câu hỏi
     *
     * @param int $questionId
     * @param array $optionsData
     * @return Collection
     */
    public function createOptionsForQuestion(int $questionId, array $optionsData): Collection
    {
        // Đảm bảo tính nhất quán của dữ liệu bằng transaction
        return DB::transaction(function () use ($questionId, $optionsData) {
            $options = collect();

            foreach ($optionsData as $optionData) {
                $optionData['question_id'] = $questionId;
                $option = $this->optionRepository->createOption($optionData);
                $options->push($option);
            }

            return $options;
        });
    }
}