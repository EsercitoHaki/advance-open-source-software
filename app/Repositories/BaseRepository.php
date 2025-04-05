<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Lấy tất cả bản ghi
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Tìm theo ID
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Tạo bản ghi mới
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Cập nhật bản ghi
     */
    public function update($id, array $data)
    {
        $record = $this->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }

    /**
     * Xoá bản ghi
     */
    public function delete($id)
    {
        $record = $this->find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }
}
