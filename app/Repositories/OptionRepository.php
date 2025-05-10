<?php

namespace App\Repositories;

use App\Models\Option;
use App\Repositories\Interfaces\OptionRepositoryInterface;
use Illuminate\Support\Collection;

class OptionRepository extends BaseRepository implements OptionRepositoryInterface
{
    /**
     * OptionRepository constructor.
     *
     * @param Option $model
     */
    public function __construct(Option $model)
    {
        parent::__construct($model);
    }

    /**
     * Lấy tất cả các options cho một câu hỏi cụ thể
     *
     * @param int $questionId
     * @return Collection
     */
    public function getOptionsByQuestionId(int $questionId): Collection
    {
        return $this->model->where('question_id', $questionId)->get();
    }

    /**
     * Lấy đáp án đúng của một câu hỏi
     *
     * @param int $questionId
     * @return Option|null
     */
    public function getCorrectOption(int $questionId): ?Option
    {
        return $this->model->where('question_id', $questionId)
            ->where('is_correct', true)
            ->first();
    }

    /**
     * Tạo một option mới
     *
     * @param array $data
     * @return Option
     */
    public function createOption(array $data): Option
    {
        return $this->model->create($data);
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
        $option = $this->model->findOrFail($optionId);
        $option->update($data);
        return $option->fresh();
    }

    /**
     * Xóa một option
     *
     * @param int $optionId
     * @return bool
     */
    public function deleteOption(int $optionId): bool
    {
        return $this->model->findOrFail($optionId)->delete();
    }
}