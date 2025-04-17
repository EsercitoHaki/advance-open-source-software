<?php

namespace App\Repositories;

use App\Models\Option;
use Illuminate\Support\Collection;

interface OptionRepositoryInterface
{
    /**
     * Lấy tất cả các options cho một câu hỏi cụ thể
     *
     * @param int $questionId
     * @return Collection
     */
    public function getOptionsByQuestionId(int $questionId): Collection;

    /**
     * Lấy đáp án đúng của một câu hỏi
     *
     * @param int $questionId
     * @return Option|null
     */
    public function getCorrectOption(int $questionId): ?Option;

    /**
     * Tạo một option mới
     *
     * @param array $data
     * @return Option
     */
    public function createOption(array $data): Option;

    /**
     * Cập nhật thông tin option
     *
     * @param int $optionId
     * @param array $data
     * @return Option
     */
    public function updateOption(int $optionId, array $data): Option;

    /**
     * Xóa một option
     *
     * @param int $optionId
     * @return bool
     */
    public function deleteOption(int $optionId): bool;
}