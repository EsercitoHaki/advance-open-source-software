<?php

namespace App\Services;

use App\Models\Option;
use Illuminate\Support\Collection;

interface OptionServiceInterface
{
    /**
     * Lấy tất cả các options cho một câu hỏi cụ thể
     *
     * @param int $questionId
     * @return Collection
     */
    public function getOptionsByQuestionId(int $questionId): Collection;

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

    /**
     * Tạo nhiều option cùng lúc cho một câu hỏi
     *
     * @param int $questionId
     * @param array $optionsData
     * @return Collection
     */
    public function createOptionsForQuestion(int $questionId, array $optionsData): Collection;
}